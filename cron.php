<?php
require_once(dirname(__FILE__).'/src/admin/whise.php');

register_activation_hook( __FILE__, 'wf_cron' );
add_action( 'wf_hourly_event', 'wf_event_hourly' );
 
function wf_cron() {
    wp_schedule_event( time(), 'hourly', 'wf_hourly_event' );
}
 
function wf_event_hourly() {
    wf_create_post();
}

register_deactivation_hook( __FILE__, 'wf_deactivation' );
 
function wf_deactivation() {
    wp_clear_scheduled_hook( 'wf_hourly_event' );
}