<?php
header ("Content-Type:text/plain"); 
//Setup location of WordPress
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

//Access WordPress
require_once( $path_to_wp.'/wp-load.php' );
if(current_user_can('administrator')){
	$results = $wpdb->get_results("SELECT email FROM {$wpdb->prefix}newsletter");
	foreach($results as $row)
		echo $row->email."\n";
}
?>