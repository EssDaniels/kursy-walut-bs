<?php

function update_xml_data()
{
  // pobierz dane z pliku XML
  $xml = simplexml_load_file('https://www.sgb.pl/wp-content/uploads/exchanges/waluty.xml');
  $array = json_decode(json_encode((array)$xml), true);
  $currency = $array['exchangeRates']['currency'];


  // przeglądaj dane XML i aktualizuj posty i post meta
  foreach ($currency as $item) {
    $currency_name = $item['@attributes']['name'];
    $sell_value = $item['@attributes']['sell'];
    $buy_value = $item['@attributes']['buy'];

    // sprawdź, czy istnieje już post dla tej waluty
    $existing_post = get_page_by_title($currency_name, 'OBJECT', 'waluta');

    // jeśli post istnieje, aktualizuj go
    if ($existing_post) {
      $post_id = $existing_post->ID;

      // zapisz poprzednie wartości sell i buy jako historię
      update_post_meta($post_id, 'sell_history', get_post_meta($post_id, 'sell', true));
      update_post_meta($post_id, 'buy_history', get_post_meta($post_id, 'buy', true));

      // zapisz aktualne wartości sell i buy jako post meta
      update_post_meta($post_id, 'sell', $sell_value);
      update_post_meta($post_id, 'buy', $buy_value);
    }
    // jeśli post nie istnieje, utwórz nowy
    else {
      $post_data = array(
        'post_title' => $currency_name,
        'post_status' => 'publish',
        'post_type' => 'waluta'
      );

      // utwórz nowy post dla waluty
      $post_id = wp_insert_post($post_data);

      // zapisz wartości sell i buy jako post meta
      add_post_meta($post_id, 'sell', $sell_value);
      add_post_meta($post_id, 'buy', $buy_value);
    }
  }
  cron_log();
}

function get_currenty()
{
  global $wpdb;

  $prefix = $wpdb->prefix;

  $sql = "SELECT
  post_title,
  m1.meta_value AS buy_value,
  m2.meta_value AS sell_value,
  m3.meta_value AS buy_history_value,
  m4.meta_value AS sell_history_value
  FROM
  {$prefix}posts AS p
  LEFT JOIN {$prefix}postmeta AS m1
  ON
  m1.post_id = p.ID AND m1.meta_key = 'buy'
  LEFT JOIN {$prefix}postmeta AS m2
  ON
  m2.post_id = p.ID AND m2.meta_key = 'sell'
  LEFT JOIN {$prefix}postmeta AS m3
  ON
  m3.post_id = p.ID AND m3.meta_key = 'buy_history'
  LEFT JOIN {$prefix}postmeta AS m4
  ON
  m4.post_id = p.ID AND m4.meta_key = 'sell_history'
  WHERE
  p.post_type = 'waluta'";


  $results = $wpdb->get_results($sql, ARRAY_A);

  return $results;
}

/*
* @param $set string
*         buy or sell
*/

function currency_status($item, $set = 'buy')
{

  $value = $item[$set . '_value'];
  $history_value = $item[$set . '_history_value'];

  if ($value == $history_value) {

    return  $value . '<span class="currency__neutral">&#8212;</span>';
  } elseif ($value > $history_value) {

    return  $value . '<span class="currency__up">&#9650;</span>';
  } else {

    return  $value . '<span class="currency__down">&#9660;</span>';
  }
}
