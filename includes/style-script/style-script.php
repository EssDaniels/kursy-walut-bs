<?php
function wpdocs_theme_name_scripts()
{
    wp_enqueue_style('ess', get_template_directory_uri() . '/dist/css/main.css', array(), '1.0.0');
    wp_enqueue_script('ess', get_template_directory_uri() . '/dist/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'wpdocs_theme_name_scripts');
