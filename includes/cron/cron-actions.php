<?php

$timestamp_8am = strtotime('07:01:00');
$timestamp_12am = strtotime('11:01:00');
$timestamp_15am = strtotime('14:01:00');


if (!wp_next_scheduled('update_xml_data_event_8')) {
  wp_schedule_event($timestamp_8am, 'daily', 'update_xml_data_event_8');
}

if (!wp_next_scheduled('update_xml_data_event_12')) {
  wp_schedule_event($timestamp_12am, 'daily', 'update_xml_data_event_12');
}
if (!wp_next_scheduled('update_xml_data_event_15')) {
  wp_schedule_event($timestamp_15am, 'daily', 'update_xml_data_event_15');
}

add_action('update_xml_data_event_8', 'update_xml_data');
add_action('update_xml_data_event_12', 'update_xml_data');
add_action('update_xml_data_event_15', 'update_xml_data');

function cron_log()
{
  $upload_dir = wp_upload_dir();
  $log_file = $upload_dir['basedir'] . '/logi-cron/cron.log';
  $message = date('Y-m-d H:i:s') . " Cron job executed\n";
  file_put_contents($log_file, $message, FILE_APPEND);
}
