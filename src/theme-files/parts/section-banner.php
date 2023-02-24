<?php
get_template_part('parts/section', 'nav');

if (!empty(get_field('banner')['heading']) && !is_home()) {
    $heading = get_field('banner')['heading'];
    $sub_heading = get_field('banner')['sub_heading'];
} elseif (is_home()) {
    $heading = "Our Blog";
    $sub_heading = "Our team will assist you in researching, organising, and negotiating loans on your behalf. View our services below.";
}
?>
<?php if (!is_404()) : ?>
    <header class="subpage_header">

    </header>
<?php endif; ?>