<?php

add_action( 'wp_ajax_fetch_whise', 'wf_fetch_service' );

function wf_fetch_service() {
	http_response_code(200);

    echo json_encode(array('status' => 'empingao'));

	wp_die();
}