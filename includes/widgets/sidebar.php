<?php
if (!function_exists('ess_register_sidebars')) {
    function ess_register_sidebars()
    {
        register_sidebar([
            'id' => 'main-sidebar',
            'name' => 'Testowy',
            'description' => 'opis'
        ]);
    }
}

add_action('widgets_init', 'ess_register_sidebars');
