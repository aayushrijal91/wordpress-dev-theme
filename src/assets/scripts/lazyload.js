jQuery(document).ready(function() {
    var $lazy_loaded_image = jQuery('.lazyload');
    $lazy_loaded_image.lazyload().each(function() {
        var $image = jQuery(this);
        $image.trigger('lazyload');
    });
});