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
		
		$updateResult = $wpdb->update($wpdb->prefix.'backgrounds', array('THUMB'=>$targetURL), array('IMAGEID'=>$_REQUEST['IMAGEID']), array('%s'), array('%d')); 
		
		if(sizeof($updateResult)>0)
			echo '{"status":"OK", "IMAGEID":"'.$_REQUEST['IMAGEID'].'", "path":"'.$targetURL.'"}';
		else
			echo '{"status":"NOK", "ERR":"'.__('Have gots an error while inserting to database.','rb').'"}';
		
	}else{
		echo '{"status":"NOK", "ERR":"'.__('File doesn\\\'t move to upload folder.','rv').'"}';
	}
}
?>