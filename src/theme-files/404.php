<?php
get_header();
get_template_part('parts/section', 'banner');
?>
<div class="404_page bg-light-grey py-5 py-lg-7">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <img src="<?= get_template_directory_uri() ?>/images/lib/no-results.png" alt="Nothing Found">
            </div>
            <div class="col-12">
                <div class="text-center fs-50 fw-600 text-primary pt-5">Sorry, nothing found!</div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>