<?php
require_once(dirname(__FILE__).'/whise.php');

add_action( 'wp_ajax_fetch_whise', 'wf_fetch_service' );

function wf_fetch_service() {
    try{
        wf_create_post();
    }catch(Exception $e){
        http_response_code(500);
        echo $e->getMessage();
        wp_die();
    }
    
	http_response_code(200);
    echo 'Fetch successfully';

	wp_die();
}