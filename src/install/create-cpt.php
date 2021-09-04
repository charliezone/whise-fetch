<?php
function wf_create_cpt(){
    register_post_type( 'estates',
        array(
            'labels' => array(
                'name' => __( 'Estates' ),
                'singular_name' => __( 'Estate' )
            ),
            'public' => true,
            'has_archive' => true,
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => true,
            'supports' => array('title', 'custom-fields')
        )
    );
}

add_action( 'init', 'wf_cpt_init' );
function wf_cpt_init() {
    wf_create_cpt();
}

register_activation_hook( __FILE__, 'wf_rewrite_flush' );
function wf_rewrite_flush() {
    wf_cpt_init();
    flush_rewrite_rules();
}