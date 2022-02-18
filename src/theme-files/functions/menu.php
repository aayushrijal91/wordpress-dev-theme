<?php

// Menu registration
function register_menus()
{
    register_nav_menu('primary', _('Primary Menu'));
}

add_action('init', 'register_menus');

// List item classes
function menu_item_classes($classes, $item, $args)
{
    if (isset($args->item_class)) {
        $classes[] = $args->item_class;
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'menu_item_classes', 1, 3);

// Link item classes
function menu_link_classes($attrib, $item, $args)
{
    if (property_exists($args, 'link_class')) {
        $attrib['class'] = $args->link_class;
    }

    return $attrib;
}
add_filter('nav_menu_link_attributes', 'menu_link_classes', 1, 3);

// Dropdown menu class
function menu_dropdown_class($classes, $item)
{
    if (in_array('menu-item-has-children', $classes)) {
        $classes[] = 'dropdown';
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'menu_dropdown_class', 10, 2);

// Submenu class
function menu_submenu_dropdown_class($classes)
{
    $classes[] = 'dropdown-menu';

    return $classes;
}
add_filter('nav_menu_submenu_css_class', 'menu_submenu_dropdown_class');

// Add 'active' class to menu items
function menu_active_navlink($classes, $item)
{
    if (in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes)) {
        $classes[] = 'active';
    }

    return $classes;
}
