<?php
$rq = explode("/", $_SERVER['REQUEST_URI']);
$config_request = end($rq);
$dynamic_admin_file = "admin-" . $config_request . ".php";
$has_template = locate_template( "partials/admin/" . $dynamic_admin_file);
global $wp_query;

if(!empty($has_template) && $has_template != "" && current_user_can('manage_options')) {
    status_header(200);
    $wp_query->is_404 = false;

    get_header();
    get_template_part("partials/setup","header");
    get_template_part("partials/header/cover");
    get_template_part( "partials/admin/admin", $config_request );
    get_footer();
    exit();
} else {
    $wp_query->set_404();
    status_header( 404 );

    get_template_part( 404 );
    exit();
}