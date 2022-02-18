<?php

// General scripts and styles
function scripts()
{
    global $wp_styles;

    wp_enqueue_script('vendor-js', get_template_directory_uri() . '/scripts/vendor.min.js', array('jquery'), filemtime(get_template_directory() . '/scripts/vendor.min.js'), true);
    wp_enqueue_script('site-js', get_template_directory_uri() . '/scripts/scripts.min.js', array('jquery'), filemtime(get_template_directory() . '/scripts/scripts.min.js'), true);
}
add_action('wp_enqueue_scripts', 'scripts', 999);

function styles() {
    wp_enqueue_style( 'site-css', get_template_directory_uri() . '/styles/theme.css', array(), filemtime(get_template_directory() . '/styles/theme.css'), 'all' );
}
add_action('wp_enqueue_scripts', 'styles', 999);

// Move jQuery to footer, 'group' is arbitrary
function move_jquery_into_footer($wp_scripts)
{
    if( is_admin() ) {
        //return;
    }
    $wp_scripts->add_data('jquery', 'group', 1);
    $wp_scripts->add_data('jquery-core', 'group', 1);
    $wp_scripts->add_data('jquery-migrate', 'group', 1);
}
