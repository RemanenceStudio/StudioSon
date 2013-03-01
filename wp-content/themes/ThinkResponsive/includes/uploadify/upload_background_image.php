<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

//Access WordPress
require_once( $path_to_wp.'/wp-load.php' );


// JQuery File Upload Plugin v1.4.1 by RonnieSan - (C)2009 Ronnie Garcia
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$ext = end(explode('.',$_FILES['Filedata']['name']));
	$newName = createRandomKey(16).'.'.$ext;
	
	$targetFile = $galleryimages.'/'.$newName;
	$targetURL = $galleryimagesUrl.'/'.$newName;
	
	if(@move_uploaded_file($tempFile,$targetFile))
	{
		$result = $wpdb->get_row( "SELECT MAX(SLIDERORDER)+1 as lastid FROM {$wpdb->prefix}backgrounds ");
	
		$insertResult = $wpdb->insert( $wpdb->prefix.'backgrounds', array( 'SLIDERORDER'=>$result->lastid, 'CONTENT'=>$targetURL, 'TYPE'=>'image', 'THUMB'=>$targetURL, 'GALLERYID'=>$_REQUEST['GALLERYID']), 
		array('%d','%s', '%s', '%s', '%d') );
		
		if($insertResult)
			echo '1';
		else
			_e('Have gots an error while inserting to database','rb');
		
	}else{
		 _e("File doesn't move to upload folder",'rb');
	}
}
?>