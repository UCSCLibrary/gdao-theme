

//This deletes all items with id above a given number.
// it is helpful if you bungle an import and want to undo it.
if(false and isset($_GET['test33'])){
    $db=get_db();
    $sql = "SELECT `id` from `omeka_items` where id > 1695979";
    $response = $db->query($sql);
    $rows = $response->fetchAll();
    foreach($rows as $row){
        echo('deleting:'.$row['id'].'<br>');
        $item = get_record_by_id('Item',$row['id']);
        $item->delete();
        
    }    
    die('it is done.');
}

//This imports items from an omeka-json file.
//it does not properly handle tags, or date added / modified.
if(false or isset($_GET['test22'])){
    $file = dirname(__FILE__).'/3_2.json';
    $jsonstring = file_get_contents($file);
    $json = json_decode($jsonstring);

    foreach($json as $jsonItem) {
        if(!is_array($jsonItem) || $jsonItem[0]!="item")
            continue;
//        echo '<pre>';
//        print_r($jsonItem);
//        die('<pre>');
        $item = new Item();
        $fileUrls = array();
        foreach($jsonItem as $jsonItemComponent){
            if(is_object($jsonItemComponent)){
//                if((int) $jsonItem->itemId > 1695746)
//                    continue;
                if($jsonItemComponent->itemId > 0 && $jsonItemComponent->itemId <= 1695554)
                    die('complete!');
                $item->public = $jsonItemComponent->public;
                $item->featured = $jsonItemComponent->featured;
                continue;
            }
            if(!is_array($jsonItemComponent))
                continue;
            switch($jsonItemComponent[0]){
                case "fileContainer":
                    foreach($jsonItemComponent as $file){
                        if(!is_array($file))
                            continue;
                        foreach($file as $fileComponent){
                            if(!is_array($fileComponent))
                                continue;
                            if($fileComponent[0]=="src"){
                                $fileUrls[]=$fileComponent[1];
                                break;
                            }
                        }
                    }
                    break;
                case "collection":
                    foreach($jsonItemComponent as $collectionComponent){
                        if(!is_object($collectionComponent))
                            continue;         
                        if(isset($collectionComponent->collectionId))
                            $item->collection_id=$collectionComponent->collectionId;
                    }
                    break;
                case "itemType":
                    foreach($jsonItemComponent as $itemTypeComponent){
                        if(!is_object($itemTypeComponent))
                            continue;         
                        if(isset($itemTypeComponent->itemTypeId))
                            $item->item_type_id=$itemTypeComponent->itemTypeId;
                    }
                    break;
                case "elementSetContainer":
                    $item->save();
                    foreach($jsonItemComponent as $elementSet){
                        if(!is_array($elementSet))
                            continue;
                        if($elementSet[0]=="elementSet"){
                            foreach($elementSet as $elementSetComponent){

                                if(!is_array($elementSetComponent))
                                    continue;
                                if($elementSetComponent[0]=="elementContainer"){
                                    foreach($elementSetComponent as $element){
                                        if(!is_array($element))
                                            continue;
                                        foreach($element as $elementComponent){
                                            if(is_object($elementComponent)){
                                                $elementId = $elementComponent->elementId;
                                                continue;
                                            }
                                            if(!is_array($elementComponent))
                                                continue;
                                            if($elementComponent[0]=="elementTextContainer"){
                                                foreach($elementComponent as $elementText){
                                                    if(!is_array($elementText)) continue;
                                                    foreach($elementText as $elementTextComponent){
                                                        if(!is_array($elementTextComponent)) continue;
                                                        if($elementTextComponent[0]=="text")
                                                            $text = $elementTextComponent[1];
                                                        break;
                                                    }
                                                    $newElementText = new ElementText();
                                                    $newElementText->element_id = $elementId;
                                                    $newElementText->record_id = $item->id;
                                                    $newElementText->record_type = 'Item';
                                                    $newElementText->html = 0;
                                                    $newElementText->text=$text;
                                                    $newElementText->save();
                                                }
                                            }
                                        }                                        
                                    }
                                }
                            }
                        }
                    }
                    break;
                default:
                    echo('<pre>');
                    print_r($jsonItemComponent);
                    echo('</pre>');
                    break;
            }
        }
        $item->save();
        set_time_limit(30);
        echo "<br>created item # ".$item->id.". uploading files...";
        insert_files_for_item($item,'Url',$fileUrls,array('ignore_invalid_files'=>true));
    }
}

