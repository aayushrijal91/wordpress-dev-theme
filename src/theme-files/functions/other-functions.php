<?php
// enable ACF options page

function init_setup() {
    add_theme_support( 'title-tag' );
    
    if ( function_exists( 'add_theme_support' ) ) {
        add_theme_support( 'post-thumbnails' );
    }
}
add_action( 'after_setup_theme', 'init_setup' );

if (function_exists('acf_add_options_page')) acf_add_options_page();

add_filter('wpcf7_validate_customlist*', 'wpcf7_customlist_validation_filter', 10, 2);

function wpcf7_customlist_validation_filter($result, $tag) {
    $tag = new WPCF7_FormTag($tag);

    $name = $tag->name;

    if (isset($_POST[$name]) && is_array($_POST[$name])) {
        foreach ($_POST[$name] as $key => $value) {
            if ('' === $value) {
                unset($_POST[$name][$key]);
            }
        }
    }

    $empty = !isset($_POST[$name]) || empty($_POST[$name]) && '0' !== $_POST[$name];

    if ($tag->is_required() && $empty) {
        $result->invalidate($tag, wpcf7_get_message('invalid_required'));
    }

    return $result;
}

/* CF7 remove auto p */
add_filter('wpcf7_autop_or_not', '__return_false');

function numeric_posts_nav() {
 
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<div class="d-flex flex-wrap align-items-center justify-content-center mt-md-5 mt-2 mb-md-0 mb-5"><ul class="pagination">' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="page-item">%s</li>' . "\n", get_previous_posts_link('Prev') );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="page-item active"' : ' class="page-item"';
 
        printf( '<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li class="page-item">�</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="page-item active"' : ' class="page-item"';
        printf( '<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>�</li>' . "\n";
 
        $class = $paged == $max ? ' class="page-item active"' : ' class="page-item"';
        printf( '<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="page-item">%s</li>' . "\n", get_next_posts_link('Next') );
 
    echo '</ul></div>' . "\n";
 
}

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
  return 'class="page-link link-arrow"';
}

/* contact 7 button */
/* removing default submit tag */
remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit');
/* adding action with function which handles our button markup */
add_action('wpcf7_init', 'aiims_child_cf7_button');
/* adding out submit button tag */
if (!function_exists('aiims_child_cf7_button')) {

    function aiims_child_cf7_button() {
        wpcf7_add_form_tag('submit', 'aiims_child_cf7_button_handler');
    }

}
/* out button markup inside handler */
if (!function_exists('aiims_child_cf7_button_handler')) {

    function aiims_child_cf7_button_handler($tag) {
        $tag = new WPCF7_FormTag($tag);
        $class = wpcf7_form_controls_class($tag->type);
        $atts = array();
        $atts['class'] = $tag->get_class_option($class);
        $atts['id'] = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option('tabindex', 'int', true);
        $value = isset($tag->values[0]) ? $tag->values[0] : '';
        if (empty($value)) {
            $value = esc_html__('Contact Us', 'twentysixteen');
        }
        $atts['type'] = 'submit';
        $atts = wpcf7_format_atts($atts);
        $html = sprintf('<button %1$s>%2$s</button>', $atts, $value);
        return $html;
    }
}

function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if (!empty($matches[1][0])) {
        $first_img = $matches[1][0];
    }
  
    if(empty($first_img)){ //Defines a default image
      $website_url = get_template_directory_uri();
      $first_img =  "$website_url/images/default.jpg";
    }
    return $first_img;
  }