<?php

function gdao_nav(array $navLinks, $name = null, array $args = array())
{
    if ($name !== null) {
        $navLinks = apply_filters($name, $navLinks, $args);
    }
    $menu = get_view()->navigation()->menu(new Omeka_Navigation($navLinks));
    if ($acl = get_acl()) {
        $menu->setRole(current_user())->setAcl($acl);
    }
    return $menu;
}

function gdao_list_kaltura_addresses() {
    $db=get_db();
    $elementTable = $db->getTable('Element');
    $kalturaEntryElement = $elementTable->findByElementSetNameAndElementName('Item Type Metadata','KalturaEntryID');

    $kalturaEntries = $db->getTable('ElementText')->findByElement($kalturaEntryElement->id);
    $f = fopen("/var/www/html/omeka/files/downloadKalturaMedia", "w") or die("Unable to open file!");
    foreach($kalturaEntries as $kalturaEntry) {
        $command = "wget http://kaltura.com/p/475671/sp/0/playManifest/entryId/".$kalturaEntry->getText()."/format/url/flavorParamId/0/".$kalturaEntry->record_id.".mp4\n";
        fwrite($f,$command);
    }
    die('done');
}

function gdao_pdfify_fanzines_part_II() {
    $db=get_db();
    $itemTable = $db->getTable('Item');
    $select = $itemTable->getSelect();
    $itemTable->filterByItemType($select,'Fanzine');
    $fanzines = $itemTable->fetchObjects($select);

    foreach($fanzines as $fanzine) {
        set_time_limit(30);

        $filename = '/gdaodata/fanzines/'.$fanzine->id.'.pdf'; 
        if(!file_exists($filename))
            continue;

        $files = $fanzine->getFiles();
        
        foreach($files as $file) {
            if(strtolower($file->getExtension())==='jpg' )
                $file->delete();
            if(strtolower($file->getExtension())==='pdf')
                $file->delete();
        }
        insert_files_for_item($fanzine,'Filesystem',array($filename),array('ignore_invalid_files'=>true));
    }
    die('done');
}
//    gdao_pdfify_fanzines();
function gdao_pdfify_fanzines() {
    $db=get_db();
    $itemType = $db->getTable('ItemType')->findByName('Fanzine');
    $itemTable = $db->getTable('Item');
    $select = $itemTable->getSelect();
    $itemTable->filterByItemType($select,'Fanzine');
    $fanzines = $itemTable->fetchObjects($select);
    /*
       $item_ids = array(
       /*		    825885,
       825858,
       825828,
       825814,
       825800,
       825798,
       825796,
       825795,
       825926*/
    /*
       825804,
       825805,
       825806,
       825807,
       825808,
       825809,
       825810,
       825811,
       825813,
       825815,
       825820,
       825824,
       825825,
       825826,
       825831,
       825832,
       825833,
       825834,
       825837,
       825842,
       825843,
       825844,
       825851,
       825857
       ); 
     */
    $f = fopen("/var/www/html/omeka/files/copyZineImage2", "w") or die("Unable to open file!");
    foreach($fanzines as $fanzine) {

        $files = $fanzine->getFiles();
        foreach($files as $file) {
            if($file->getExtension()=='jpg')
	        continue;
        }
        
        //    $fanzine = get_record_by_id('item',$fanzine_id);

        fwrite($f,'if [ ! -d "'.$fanzine->id.'" ]; then'."\n");
        fwrite($f,'echo "processing '.$fanzine->id.'"'."\n");
        fwrite($f,'mkdir '.$fanzine->id."\n");

        $ark = metadata($fanzine,array('Item Type Metadata','ARK'));

        $arksections = explode('/',$ark);
        $arksection = $arksections[2];
        $findc = 'find "/gdaoimages/images/cache/pairtree_root/ar/k+/=3/83/05/=g/';
        $findc .= substr($arksection,1,2).'/';
        $findc .= substr($arksection,3,2).'/';
        $findc .= substr($arksection,5,2).'/';
        $findc .= substr($arksection,7,1).'="';
        $findc .= ' -type f -name "*ark*" -not -name "*.dzi" -not -name "*.jpg" | while read line; do'."\n";
        fwrite($f,$findc);
        fwrite($f,'newname=$(basename $line)'."\n");
        fwrite($f,'newname=${newname//\'ark+=38305=\'/\'\'}'."\n");
        fwrite($f,'newname=${newname//\'=is=\'/\'\'}'."\n");
        fwrite($f,'convert $line -resize 1275x -quality 75 '.$fanzine->id.'/${newname}.jpg'."\n");
        fwrite($f,"done\n");
        fwrite($f,"fi\n\n");

        /*    foreach ($fanzine->getFiles() as $file){
	   fwrite($f,'cp /var/www/html/omeka/files/original/'.$file->filename." ".$fanzine->id."/".$file->original_filename."\n");
	   }*/
        //    $filename = '/gdaodata/fanzines/jpgs/'.$fanzine_id.'.pdf';
        //    insert_files_for_item($fanzine,'Filesystem',array($filename),array('ignore_invalid_files'=>false));
        /*$fanzine = get_record_by_id("Item",$fanzine_id);
           $commandPrefix = "convert ";
           $command = '';
           $commandSuffix = '/home/ethenry/fanzines/gdao_fanzine_'.$fanzine->id."_original.pdf\n";
           $files = $fanzine->getFiles();
           fwrite($f,'mkdir '.$fanzine_id."\n");
           foreach($files as $file) {
           fwrite($f, 'cp /var/www/html/omeka/files/original/'.$file->filename.' '.$fanzine_id."\n");
           }
         */
        /*
           fwrite($f,'echo "Processing item '.$fanzine->id.' original"'."\n");
           fwrite($f,$commandPrefix.$command.$commandSuffix);
           fwrite($f,'echo "Processing item '.$fanzine->id.' 300"'."\n");
           //    fwrite($f,'convert -units PixelsPerInch ~/fanzines/gdao_fanzine_'.$fanzine->id."_original.pdf -density 150 ~/fanzines/gdao_fanzine_".$fanzine->id."_300.pdf\n"); 
           fwrite($f,'gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/ebook -dNOPAUSE -dQUIET -dBATCH -sOutputFile=/home/ethenry/fanzines/gdao_fanzine_'.$fanzine->id."_ebook.pdf /home/ethenry/fanzines/gdao_fanzine_".$fanzine->id."_original.pdf\n");
           //    fwrite($f,'echo "Processing item '.$fanzine->id.' 150"'."\n");
           //fwrite($f,'gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=/home/ethenry/fanzines/gdao_fanzine_'.$fanzine->id."_screen.pdf /home/ethenry/fanzines/gdao_fanzine_".$fanzine->id."_original.pdf\n");
           //   fwrite($f,'convert -units PixelsPerInch ~/fanzines/gdao_fanzine_'.$fanzine->id."_original.pdf -density 150 ~/fanzines/gdao_fanzine_".$fanzine->id."_150.pdf\n"); 
           
         */
    }
    fclose($f);

}

/* shortcode for including a php file
 * useful in simple pages, which no longer accept
 * php code by default
 */
add_shortcode('gdao_include_page','gdaoIncludePage');

/*
 * returns an array of poster artists
 * called in artists.php
 */
function gdao_get_poster_artists($solr) {
    $queryParams = gdao_solr_get_params();
    $queryParams['facet'] = 'true';
    $queryParams['facet.field'] = '39_s';
    $search = gdao_get_poster_artist_search();
    $queryParams['facet.limit'] = '11'; // So we can skip Greene, he's a photographer mostly
    $json = $solr->search($search, 0, 0, $queryParams)->getRawResponse();
    $result = json_decode($json, TRUE);
    return $result;
}

function gdao_get_poster_artist_search() {
    return '(114_s:"MS 332. Grateful Dead Records, Series 8: Posters" OR 114_s:"MS 340: David Singer Poster Collection, 1969-1971" OR 114_s:"MS 342. Nicholas G. Meriwether Poster Collection")';
}

function gdao_get_photographer_search() {
    return '(114_s:"MS 332. Grateful Dead Records, Series 6: Photographs" OR 114_s:"MS 334. Herb Greene Photographs")';
}

/*
 * returns an array of poster artists
 * called in artists.php
 */
function gdao_get_photographers($solr) {
    $queryParams = gdao_solr_get_params();
    $queryParams['facet.field'] = '39_s';
    $queryParams['facet.limit'] = '10';
    $queryParams['facet'] = 'true';
    $search = gdao_get_photographer_search();
    $json = $solr->search($search, 0, 0, $queryParams)->getRawResponse();
    $result = json_decode($json, TRUE);
    return $result;
}

/*
 *
 *
 */
function gdao_add_tag($id,$tag_name){
    set_current_record('Item',$item=get_record_by_id('Item',$id));  

    if(strpos(tag_string(get_record_by_id('Item',$id),null,','),$tag_name))
        return true;
    else {
        $tag = get_db()->getTable('Tag')->findOrNew($tag_name);
        $tag->save();
        $recordsTag = new RecordsTags();
        $recordsTag->record_id = $id;
        $recordsTag->record_type = 'Item';
        $recordsTag->tag_id = $tag->id;
        $recordsTag->save();
    }
    return true;
}

/* this function is run once by header.php 
 * (called by the head() function) and runs
 * before returning the first output to the browser
 */
function gdao_run_header_functions() {

    //if not already installed, create all necessary elements and element sets
    if(!get_option('gdao-installed'))
        gdaoInstall();

    //fix undefined constants
    $title = isset($title) ? ' | '.$title : '';
    $title = get_option('site_title').$title;

    $bodyclass = isset($bodyclass) ? $bodyclass : '';

    $item = get_view()->item;
    $itemtype = $item ? metadata($item,'item type name') : null;
    $ark = $item ? metadata($item, array('Item Type Metadata', 'ARK')) : null;
    $restricted = $item ? metadata($item, array('Item Type Metadata', 'AccessRestricted')) : null;

    if($item) {

        $item_title = gdao_show_untitled_items(metadata($item,array('Dublin Core', 'Title')));
        $item_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        $item_image_meta = '<meta property="og:image" content="';
        if (metadata($item, 'has thumbnail') ){
            $iLink = simplexml_load_string(item_image('square_thumbnail') ); 
            $item_image_meta .= $iLink['src'];
            $item_description = "GDAO Object";
        } elseif ($itemtype == 'Sound') {
            $item_image_meta .= absolute_url('/themes/gdao-theme/images/itemtype-sound.png');
            $item_description = "GDAO Sound";
        } elseif ($itemtype == 'Video') {
            $item_image_meta .= absolute_url('/themes/gdao-theme/images/itemtype-video.png');
            $item_description = "GDAO Video";
        } elseif ($itemtype == 'Article' && empty($ark)) {
            $item_image_meta .= absolute_url('/themes/gdao-theme/images/itemtype-article.png');
            $item_description ="GDAO Article";
        }  elseif ($itemtype == 'Website'){
            $item_image_meta .= absolute_url('/themes/gdao-theme/images/itemtype-website.png');
            $item_description = "GDAO Website";
        } elseif ($itemtype == 'Story'){
            $item_image_meta .= absolute_url('/themes/gdao-theme/images/itemtype-oralhistory.png');
            $item_description = "GDAO Sound";
        } elseif ($itemtype == 'Fan Tape'){
            $item_image_meta .= absolute_url('/themes/gdao-theme/images/ia-logo-sm.png');
            $item_description="GDAO Internet Archive Fan Tape";
        } else {
            $item_image_meta .= absolute_url('/themes/gdao-theme/images/logo-gdao.png');
            $item_description="GDAO Object";
        } 

        if($restricted == 'true' && !gdao_is_authorized()) {
            $item_image_meta =absolute_url('/themes/gdao-theme/images/content-not-available.png');
            $item_description = "";
        }

    } else {
        $item_title = "The Grateful Dead Archive Online";
        $item_url = absolute_url();
        $item = false;
        $item_image_meta = absolute_url('/themes/gdao-theme/images/logo-gdao.png');
        $item_description = "The Grateful Dead Archive Online (GDAO) is a socially constructed collection comprised of over 45,000 digitized items drawn from the UCSC Library&#039;s extensive Grateful Dead Archive (GDA) and from digital content submitted by the community and global network of Grateful Dead fans.";
    }
    
    return array(
	'title'=>$title,
	'bodyclass'=>$bodyclass,
	'item'=>$item,
	'item_title'=>$item_title,
	'item_url' =>$item_url,
	'item_image' =>$item_image_meta,
	'item_description'=>$item_description
    );
}

/* this function is used by the "fan-art" carousel page
 * to retrieve a new set of records when users push
 * the "next" or "prev" buttons
 */
function gdao_handle_ajax() {
    $result = gdao_get_fanart();
    foreach ($result['response']['docs'] as $index => $values) 
        echo gdao_get_fanart_image($values); 
    die();
}

function gdao_get_fanart_image($values) {

    echo '
    <li class="solr_item">
    <a href="';
    echo public_url('items/show/' . $values['modelid']);
    echo '">
    <img src="';
    echo public_url('files/fullsize/'.$values['483_s'][0]);
    echo '"  />
    <div class="carousel-label">
      '.gdao_shorten_text($values['title'][0]).'
    </div>
    </a>
    </li>
';
}

function gdao_get_fanart(){
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
    $queryParams = gdao_solr_get_params();
    $letter = isset($_GET['letter']) ? $_GET['letter'] : null;
    $field = ' AND title:';

    $solr = new Apache_Solr_Service(get_option('solr_search_host'),get_option('solr_search_port'),get_option('solr_search_core'));
    $query = '114_s:"MS 332. Grateful Dead Records, Series 11: Decorated Envelopes"';

    $query = !empty($letter) ? $query . $field . substr($letter, 0, 1) . '*' : $query;


    $json = $solr->search($query, $offset, 6, $queryParams)->getRawResponse();
    return json_decode($json, TRUE);
}

function gdao_solr_get_params(
    $req=null, $qParam='solrq', $facetParam='solrfacet', $other=null
) {
    if ($req === null) {
        $req = $_REQUEST;
    }
    $params = array();
    if (isset($req[$qParam])) {
        $params['q'] = preg_replace('/:/', ' ', $req[$qParam]);
    }
    if (isset($req[$facetParam])) {
        $params['facet'] = $req[$facetParam];
    }
    if ($other !== null) {
        foreach ($other as $key) {
            if (array_key_exists($key, $req)) {
	        $params[$key] = $req[$key];
            }
        }
    }
    return $params;
}

function gdaoIncludePage($args,$view) {
    ob_start();
    try{
        include(dirname(__FILE__).'/simple-pages/page/'.$args['slug'].'.php');
    } catch(Exception $e) {
        return('Error retrieving page: '.$e->getMessage());
    } 
    return ob_get_clean();

}

add_filter(array('Display', 'Item', 'Dublin Core', 'Title'), 'gdao_show_untitled_items');

function gdaoInstall() 
{
    //the idea is to run this once when the theme installs, set an option to say that it has been installed, then never run it again.

    //item type elements to add
    $itmElements = array(
	'Curated',
	'ARK',
	'AccessRestricted',
        
	//sound, video
        
	//website
	//'URL', (exists by default)

	//Story
    );

    //add the item type elements
    $elementTable = get_db()->getTable('Element');
    foreach ($itmElements as $elementName) {
        if($elementTable->findByElementSetNameAndElementName('Item Type Metadata',$elementName))
            continue;
        $element = new Element();
        $element->setElementSet('Item Type Metadata');
        $element->setName($elementName);
        $element->save();
    }

    //add new item types and add elements to item types

    $itemTypeTable = get_db()->getTable('ItemType');
    $elementTable = get_db()->getTable('Element');

    //what needs to be added to 'video'?
    //$video = new ItemType();
    $video = $itemTypeTable->findByName('Moving Image');
    $video->addElements(array(
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','KalturaEntryID'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','KalturaUIConfID'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','KalturaPlayerID')
    ));
    $video->save();

    //$story = new ItemType();
    $story = $itemTypeTable->findByName('Oral History');
    $story->addElements(array(
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','gdao-oh-how'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','gdao-oh-show'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','gdao-oh-song'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','gdao-oh-scene'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','gdao-oh-how'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','gdao-oh-phenom')
    ));
    $story->save();
    
    //$story = new ItemType();
    $sound = $itemTypeTable->findByName('Sound');
    $sound->addElements(array(
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','KalturaEntryID'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','KalturaUIConfID'),
	$elementTable->findByElementSetNameAndElementName('Item Type Metadata','KalturaPlayerID')
    ));
    $sound->save();

    //todo: configure simple pages and exhibits
    //todo: configure error messages?
    //todo: artists.xml?
    //

    set_option('gdao-installed',true);

}

function gdao_is_authorized() {
    // Our production sits behind a cache so needs to check headers
    $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'], 1) : array("");
    $ip = trim($ip[0]);

    // Our development has no cache and needs to check client IP
    if ($ip == '') {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if (startsWith($ip, '128.114.')
        || startsWith($ip, '169.233.')) {
        return true;
    }

    return false;
}

function gdao_show_untitled_items($title) {
    $prepTitle = trim(strip_formatting($title));

    if (empty($prepTitle)) {
        return '[Untitled]';
    }

    return $title;
}

/**
 * Create a SolrFacetLink
 *
 * @param array   $current The current facet search.
 * @param string  $facet
 * @param string  $label
 * @param integer $count
 * @return string
 */
function gdao_createFacetHtml($current, $facet, $label, $count) {
    $uri = SolrSearch_ViewHelpers::getBaseUrl();

    $escaped = str_replace('"', '\"', $label);
    $escaped = str_replace('&', '\%26', $escaped);
    $escaped = str_replace("'", "\'", $escaped);

    if (isset($current['q'])) {
        $q = 'solrq=' . html_escape($current['q']) . '&';
    }
    else {
        $q = '';
    }

    if (!empty($current['facet'])) {
        $facetq = "{$current['facet']}+AND+$facet:&#x022;$escaped&#x022;";
    }
    else {
        $facetq = "$facet:&#x022;$escaped&#x022;";
    }

    $link = $uri . '?' . $q . 'solrfacet=' . $facetq;

    return "<div class='fn'><a href='$uri?{$q}solrfacet=$facetq'>$label</a> &nbsp;"
         . "<span class='facet_hit_count'>($count)</span></div>";
}

function gdao_shorten_text($text) {
    $words = explode(' ', $text, 16);

    if (count($words) == 16) {
        array_pop($words);
    }

    return implode(' ', $words) . (count($words) == 15 ? '... ' : '');
}

function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);

    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function gdao_display_field($fieldName, $fieldLabel, $uri) {
    if (!empty($fieldName)) {
        echo '<div class="item-field ' . str_replace(',', '', str_replace('?', '', str_replace(' ', '_', strtolower($fieldLabel)))) . '">';
        if (is_array($fieldName) && count($fieldName) > 1) {
            echo '<h3>' . $fieldLabel . 's:</h3>';
            echo '<ul>';
            foreach ($fieldName as $name) {
	        echo '<li>';
	        if (!is_null($uri) && startsWith($name, 'http')) {
	            echo '<a href="' . urldecode($name) . '" target="_blank">' . gdao_format($name) . '</a>';
	        }elseif (!is_null($uri)) {
	            echo '<a href="' . $uri . urlencode($name) . '">';
	            echo gdao_format($name) . '</a>';
	        } else {
	            echo gdao_format($name);
	        }
	        echo '</li>';
            }
            echo '</ul>';
        } else {
            $name = '';
            if (is_array($fieldName)) {
	        $name = $fieldName[0];
            }
            else {
	        $name = $fieldName;
            }

            echo '<h3>' . $fieldLabel . ':</h3>';
            echo '<ul>';
            echo '<li>';
            if (!is_null($uri) && startsWith($name, 'http')) {
	        echo '<a href="' . urldecode($name) . '" target="_blank">' . gdao_format($name) . '</a>';
            }
            elseif (!is_null($uri)) {
	        echo '<a href="' . $uri . gdao_solr_escape($name) . '">' . gdao_format($name) . '</a>';
            }
            else {
	        echo gdao_format($name);
            }
            echo '</li>';
            echo '</ul>';
        }
        echo '</div>';
    }
}

// + - & || ! ( ) { } [ ] ^ " ~ * ? : \
function gdao_solr_escape($query,$quotes=true) {
    $query = str_replace('&quot;', '\%22', $query);
    $query = str_replace(':', '\%3A', $query);
    $query = str_replace('+', '\%2B', $query);
    $query = str_replace('-', '\-', $query);
    $query = str_replace('(', '\(', $query);
    $query = str_replace(')', '\)', $query);
    $query = str_replace('[', '\%5B', $query);
    $query = str_replace(']', '\%5D', $query);
    $query = str_replace('"', '\%22', $query);
    $query = str_replace('?', '\%3F', $query);
    $query = str_replace('^', '\%5E', $query);
    $query = str_replace('&#039;', "\'", $query);
    $query = str_replace('&', '\%26', $query);
    $query = str_replace('|', '\%7C', $query);
    $query = str_replace('!', '\!', $query);
    $query = str_replace('{', '\%7B', $query);
    $query = str_replace('}', '\%7D', $query);
    if($quotes)
        $query = '%22' . $query . '%22';
    return $query;
}

function gdao_escapeSolrValue($string)
{
    $match = array('\\', '+', '-', '&', '|', '!', '(', ')', '{', '}', '[', ']', '^', '~', '*', '?', ':', '"', ';', ' ');
    $replace = array('\\\\', '\\+', '\\-', '\\&', '\\|', '\\!', '\\(', '\\)', '\\{', '\\}', '\\[', '\\]', '\\^', '\\~', '\\*', '\\?', '\\:', '\\"', '\\;', '\\ ');
    $string = str_replace($match, $replace, $string);

    return $string;
}

function gdao_create_sort_form() {
    $uri = url('solr-search');
    $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';

    $html = '';
    ob_start();
?>
  <div id="gdao_search_sort_form">
    <form action="<?php echo $uri;?>" method="get">
      <?php if(isset($_REQUEST['q'])) { ?>
        <input type="hidden" name="q" value="<?php echo $_REQUEST['q'] ?>" id="solrq"/>
      <?php } 
      if(isset($_REQUEST['solrfacet'])){ ?>
        <input type='hidden' name='solrfacet' value='<?php  echo $_REQUEST['solrfacet']; ?>' id='solrfacet'/>
      <?php } ?>
      <span id="sort-label">
        <label for="sort" class="optional">Sort By</label>
      </span>
      <select name="sort" id="sort">
        
        <option value="" label="Relevancy"
                <?php echo (empty($sort) ? ' selected="selected"' : ' ');?>>Relevancy</option>
        
        <option value="sortedDate asc" label="Date Ascending"
                <?php echo ($sort == 'sortedDate asc' ? ' selected="selected"' : ' '); ?>>Date Ascending</option>
        
        <option value="sortedDate desc" label="Date Descending"
                <?php echo ($sort == 'sortedDate desc' ? ' selected="selected"' : ' ');?>>Date Descending</option>
      </select>
      
      <input type="submit" name="submit" id="submit" value="Go"/>
    </form>
  </div>
  <?php  
  return ob_get_clean();
  }

  function gdao_solr_search_element_lookup($facet) {
  $label;

  if ($facet == '39_s') {
  $label = 'Creator';
  }
  elseif ($facet == '38_s') {
  $label = 'Related Show';
  }
  elseif ($facet == '48_s') {
  $label = 'Source';
  }
  elseif ($facet == '40_s') {
  $label = 'Date';
  }
  elseif ($facet == '49_s') {
  $label = 'Subject';
  }
  elseif ($facet == '125_s') {
  $label = 'Venue';
  }
  elseif ($facet == '126_s') {
  $label = 'Show Date';
  }
  elseif ($facet == 'itemtype') {
  $label = 'Item Type';
  }
  elseif ($facet == '260_s') {
  $label = 'Subject';
  }
  elseif ($facet == '196_s') {
  $label = 'Year';
  }
  else {
  $label = $facet;
  }

  return $label;
  }

  function gdao_facet_is_displayable($facet) {
  if ($facet == 'Copyright Clearance') {}
  else {
  return true;
  }

  return false;
  }

  function gdao_format($string) {
  // strtotime() doesn't handle year/month designations; adding workaround
  // an example of this timestamp is: 2012-00-00T00:00:00Z
  if (endsWith($string, '-00-00T00:00:00Z')) {
  return substr($string, 0, 4);
  }
  else if (endsWith($string, '-00T00:00:00Z')) {
  return substr($string, 0, 7);
  }
  else if (endsWith($string, 'T00:00:00Z')) {
  return substr($string, 0, 10);
  }

  $time = strtotime($string);

  if ($time == true) {
  return date('Y-m-d', $time);
  }

  return $string;
  }

  function gdao_solr_search_facet_link($current, $facet, $label, $count) {
  $html = '';
  $uri = solr_search_base_url();

  // if the query contains one of the facets in the list
  if (isset($current['q']) && strpos($current['q'], "$facet:\"$label\"") !== false) {
  //generate remove facet link
  $removeFacetLink = solr_search_remove_facet($facet, $label);
  $html .= "<div class='fn'><b>$label</b></div> "
  . "<div class='fc'>$removeFacetLink</div>";
  }
  else {
  if (isset($current['q'])) {
  $q = 'solrq=' . html_escape($current['q']) . '&';
  }
  else {
  $q = '';
  }

  if (isset($current['facet']) && $current['facet'] != '') {
  $facetq = "{$current['facet']}+AND+$facet:&#x022;$label&#x022;";
  }
  else {
  $facetq = "$facet:&#x022;$label&#x022;";
  }

  //otherwise just display a link to a new query with the facet count
  $html .= "<div class='gdao_facet'><span class='gdao_facet_value'>"
    . "<a href='$uri?{$q}solrfacet=$facetq'>$label</a></span>&nbsp; ("
    . "<span class='gdao_facet_count'>$count</span>)</div>";
  }

  return $html;
  }

  function gdao_solr_search_remove_facets() {
  $uri = solr_search_base_url();
  $queryParams = solr_search_get_params();
  $html = '';

  if (empty($queryParams) || (isset($queryParams['q']) && $queryParams['q'] == '*:*'
  && !isset($queryParams['facet']))) {
  $html .= '<li><b>ALL TERMS</b></li>';
  }
  else {
  if (isset($queryParams['q'])) {
  $html .= "<li><b>Keyword:</b> {$queryParams['q']} "
    . "[<a href='$uri?solrfacet={$queryParams['facet']}'>X</a>]"
    . "</li>";
  }

  if (isset($queryParams['facet'])) {
  foreach (explode(' AND ', $queryParams['facet']) as $param) {
  $paramSplit = explode(':', $param);
  $facet = $paramSplit[0];
  $label = trim($paramSplit[1], '"');

  if (strpos($param, '_') !== false) {
  $category = solr_search_element_lookup($facet);
  }
  else {
  $category = ucwords($facet);
  }

  if ($facet != '*') {
  $link = solr_search_remove_facet($facet, $label);
  $html .= "<li><b>$category:</b> $label $link</li>";
  }
  }
  }
  }

  return $html;
  }

  /**
  Displays Kaltura viewer; metadata has playerID, too, but we're ignoring?
  */
  function gdao_display_kaltura($uiConfID, $entryID, $height, $width) {
  echo '<script type="text/javascript" src="http://www.kaltura.com/p/475671/sp/47567100/embedIframeJs/uiconf_id/';
                                            echo $uiConfID . '/partner_id/475671"></script><object id="kaltura_player_1337299051" name="kaltura_player_1337299051" ';
                                                                                                   echo 'type="application/x-shockwave-flash" allowFullScreen="true" allowNetworking="all" allowScriptAccess="always" ';
                                                                                                   echo 'height="' . $height . '" width="' . $width . '" bgcolor="#FFFFFF" xmlns:dc="http://purl.org/dc/terms/" ';
                                                                                                   echo 'xmlns:media="http://search.yahoo.com/searchmonkey/media/" rel="media:video" ';
                                                                                                   echo 'resource="http://www.kaltura.com/index.php/kwidget/cache_st/1337299051/wid/_475671/uiconf_id/';
                                                                                                                   echo $uiConfID . '/entry_id/' . $entryID . '" ';
                                                                                                   echo 'data="http://www.kaltura.com/index.php/kwidget/cache_st/1337299051/wid/_475671/uiconf_id/';
                                                                                                               echo $uiConfID . '/entry_id/' . $entryID . '"><param name="allowFullScreen" value="true" /><param name="allowNetworking" ';
                                                                                                                                                                                                                 echo 'value="all" /><param name="allowScriptAccess" value="always" /><param name="bgcolor" value="#000000" />';
    echo '<param name="flashVars" value="&{FLAVOR}" /><span property="media:width" content="' . $width . '"></span><span ';
                                                                                                                         echo 'property="media:height" content="' . $height . '"></span><span property="media:type" ';
                                                                                                                                                                                              echo 'content="application/x-shockwave-flash"></span></object>';
  }
