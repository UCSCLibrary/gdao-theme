  /* advanced search scripts */
  jQuery('#as-submit').click(function() {
    $url = '/solr-search/results/index?q=';

    jQuery('.as-query').each(function() {
      $field = jQuery(this).find('select').val();
      $term = jQuery(this).find('input:text').val();

      if ($term != '') {
        if ($field != '') {
          $url += ($field + ':(' + $term + ')');
        }
        else {
          $url += ('(' + $term + ')');
        }

        $url += ' AND ';
      }
    });

    $itemtype = jQuery('#item-type').val();

    if ($itemtype != '') {
      $url += ('itemtype:%22' + $itemtype + '%22 AND ');
    }

    $date1 = jQuery("#datepicker1").val();
    $date2 = jQuery("#datepicker2").val();

    if ($date1 == '' && $date2 == '') {
      // do nothing
    }
    else if ($date1 != '' && $date2 == '') {
      $url += ('40_s:[' + $date1 + 'T00:00:00.000Z TO *]');
    }
    else if ($date2 != '' && $date1 == '') {
      $url += ('40_s:[* TO ' + $date2 + 'T00:00:00.000Z]');
    }
    else {
      $url += ('40_s:[' + $date1 + 'T00:00:00.000Z TO ' + $date2 + 'T00:00:00.000Z]');
    }

    if ($url.substr($url.length - 5) === ' AND ') {
      $url = $url.substr(0, $url.length - 5);
    }

    jQuery(location).attr('href', $url);
  });

  jQuery("#datepicker1").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    minDate: "1965-01-01",
    maxDate: "1996-01-01",
    yearRange: "1965:1996"
  });

  jQuery("#datepicker2").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    minDate: "1965-01-01",
    maxDate: "1996-01-01",
    yearRange: "1965:1996"
  });
  /* end of advanced search scripts */
