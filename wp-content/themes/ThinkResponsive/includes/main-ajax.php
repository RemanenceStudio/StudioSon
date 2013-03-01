<?php
if(is_admin())
{

/*Admin Functions*/
add_action('wp_ajax_load_font_variants', 'load_font_variants');
function load_font_variants()
{
	echo '{"status":"OK", "variants":'.json_encode(getFont($_POST['font'],'variants')).'}';
	die();
}

add_action('wp_ajax_General_save', 'General_save');
function General_save()
{
	foreach($_POST['vars'] as $regKey)
	{
		if(array_key_exists($regKey, $_POST)){
			update_option($regKey, $_POST[$regKey]);
		}else{
			$item = getSettingsItem($regKey);
			if(is_array($item))
				update_option($regKey, $item['default']);
			else
				update_option($regKey, '');
		}
	}
		echo '{"status":"OK", "type":"apply"}';
	die();
}

add_action('wp_ajax_delete_set', 'delete_set');
function delete_set()
{
	global $wpdb;
	$result = $wpdb->query("DELETE FROM {$wpdb->prefix}settings WHERE ID = ".$_POST['setID']);
	if($result>0)
		echo '{"status":"OK", "setID":"'.$_POST['setID'].'"}';
	else
		echo '{"status":"NOK", "ERR":"'.__('Have got an error when deleting.','rb').'"}';
	die();
}

add_action('wp_ajax_get_images', 'get_images');
function get_images()
{
	global $settingsimages, $settingsimagesUrl;
	$re = '';
	if ($handle = opendir($settingsimages)) {
		while (false !== ($imageInDir = readdir($handle))) {
			if($imageInDir!='.' && $imageInDir!=='..'){
				$imageInDir = end(explode('/', $imageInDir));
				$re .= createItemForImageList($imageInDir, $settingsimagesUrl.'/'.$imageInDir);
			}
		}
	}else	
		$re .= '<tr><td colspan="2">'.__('Directory has not been created;','rb').' '.$settingsimages.'</td></tr>';

	echo $re;
	die();
}

add_action('wp_ajax_delete_image', 'delete_image');
function delete_image()
{
	global $upload_dir, $settingsimages, $settingsimagesUrl;
	$src = $settingsimages.'/'.$_POST['imgName'];	
	if(unlink($src))
	{
		echo '{"status":"OK", "imgID":"'.$_POST['imgID'].'"}';
	}else{
		echo '{"status":"NOK", "ERR":"'.__('Have got an error when deleting file.','rb').'"}';
	}
	die();
}




add_action('wp_ajax_get_general', 'get_general');
function get_general()
{
	global $SettingsOptions;
	foreach($SettingsOptions as $sm){
		if($sm['type']=='fields' && $sm['id']==$_POST['setid']){
			foreach($sm['fields'] as $field){
				$ret[$field['id']]=stripslashes(get_option($field['id'], $field['default']));
			}
			break;
		}
	}
	echo json_encode($ret);
	die();
}


add_action('wp_ajax_get_gallery_list', 'get_gallery_list');
function get_gallery_list(){
	global $wpdb;
	$listHTML = '';
	$result = $wpdb->get_results("SELECT GALLERYID, GALLERYNAME FROM {$wpdb->prefix}galleries ORDER BY GALLERYID");
	foreach($result as $row)
	{
		$listHTML .= createGalleryListItem($row->GALLERYID, $row->GALLERYNAME);
	}
	echo $listHTML;
	die();
}


add_action('wp_ajax_delete_gallery', 'delete_gallery');
function delete_gallery(){
	global $wpdb;
	$result = $wpdb->query("DELETE FROM {$wpdb->prefix}galleries WHERE GALLERYID = ".$_POST['GALLERYID']);
	if($result>0)
		echo '{"status":"OK", "GALLERYID":"'.$_POST['GALLERYID'].'"}';
	else
		echo '{"status":"NOK", "GALLERYID":"'.$_POST['GALLERYID'].'"}';
	die();
}

add_action('wp_ajax_setfp_gallery', 'setfp_gallery');
function setfp_gallery(){
	update_option('fpgalleryid', $_POST['GALLERYID']);
	echo '{"status":"OK"}';
	die();
}

function createGalleryListItem($id, $name){
	$fpgalleryid = get_option('fpgalleryid');
	if(empty($fpgalleryid))
		register_setting('rightnowsettings', 'fpgalleryid');
	return '<tr id="glist_'.$id.'">
		<td>'.$id.'</td>
		<td>'.$name.(($fpgalleryid==$id)?' <span class="settedfp">'.__('[Front Page]','rb').'</span>':'').'</td>
		<td>
			<input type="button" name="detailGalleryBtn" onclick="detailGallery('.$id.',\''.$name.'\');" class="button" value="'.__('Edit Gallery','rb').'" />
			<!--<input type="button" name="setFrontpageGalleryBtn" onclick="setFrontpageGallery('.$id.');" class="button" value="'.__('Set Front Page','rb').'" />-->
			<input type="button" name="removeGalleryBtn" onclick="removeGallery('.$id.');" class="button" value="'.__('Remove','rb').'" />
		</td>
	</tr>';
}



function getSliderItemImage($imageID, $type, $content, $caption, $description, $thumb, $width, $height)
{
	$total = "";
	$total = 	'<tr id="imageID'.$imageID.'" class="sliderImageItem">';
	$total .= 	'<td><input type="hidden" name="imageID[]" value="'.$imageID.'" />';
	$total .= 	'<div class="sliderImageItemImage">
					<img width="120" height="80" src="'.get_template_directory_uri().'/includes/timthumb.php?src='.$thumb.'&amp;h=80&amp;w=120&amp;zc=1&amp;q=100" />
					<br/>';
	if($type=='vimeo' || $type=='youtube' || $type=='selfhosted' || $type=='flash')
	{
		$total .= 'Video <span class="videoWidth"><a href="javascript:void(0);" onclick="changeDimension(this, \'Width\')">'.$width.'</a></span> x
					<span class="videoHeight"><a href="javascript:void(0);" onclick="changeDimension(this, \'Height\')">'.$height.'</a></span><br>';
	}
	$total .=	'<a href="javascript:void(0);" onclick="deleteItemImage(this)">'.__('[Delete]','rb').'</a> <br/>
				<a class="thumbUploaderBtn" href="javascript:void(0);" onclick="thumUploader(this)">'.__('[Upload Thumbnail]','rb').'</a>
				</div>
				</td>';
	$total .=	'<td>
				<input type="hidden" name="IMAGEID[]" value="'.$imageID.'" />';
	$total .=	'<div class="sliderImageItemControl">
				<span>'.__('CAPTION','rb').'</span><br />
				<input type="text" name="CAPTION[]" value="'.$caption.'" style="width:400px;" />
				<br />
				<span>'.__('DESCRIPTION','rb').'</span><br />
				<textarea name="DESCRIPTION[]" style="width:400px; height:50px;">'.$description.'</textarea>
				</div>';
	$total .= 	'</td>';
	$total .= 	'</tr>';
	return $total;
}

add_action('wp_ajax_list_slider_items', 'list_slider_items');
function list_slider_items()
{
	global $wpdb;
	$result = $wpdb->get_results("SELECT IMAGEID, TYPE, CONTENT, THUMB, CAPTION, DESCRIPTION, WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE GALLERYID='".$_POST['GALLERYID']."' ORDER BY SLIDERORDER");
	$i=0;
	foreach($result as $row)
	{
		echo getSliderItemImage($row->IMAGEID, $row->TYPE, $row->CONTENT, stripslashes($row->CAPTION), stripslashes($row->DESCRIPTION), $row->THUMB, $row->WIDTH, $row->HEIGHT);
		$i++;
	}
	die();
}

add_action('wp_ajax_save_slider_items', 'save_slider_items');
function save_slider_items()
{
	global $wpdb;
	for($i=0; $i<count($_POST['imageID']); $i++)
	{
		$wpdb->update($wpdb->prefix.'backgrounds', array('CAPTION'=>$_POST['CAPTION'][$i], 'DESCRIPTION'=>$_POST['DESCRIPTION'][$i], 'SLIDERORDER'=>($i+1)), array('IMAGEID'=>$_POST['imageID'][$i]), array('%s', '%s', '%d'), array('%d')); 
	}
	die();
}


add_action('wp_ajax_change_video_dimension', 'change_video_dimension');
function change_video_dimension()
{
	global $wpdb;
	$resultOld = $wpdb->get_row( "SELECT WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE IMAGEID=".$_POST['IMAGEID']);
	if($_POST['dimType']=='Width'){
		$wpdb->update($wpdb->prefix.'backgrounds', array('WIDTH'=>$_POST['value']), array('IMAGEID'=>$_POST['IMAGEID']), array('%d'), array('%d')); 
	}elseif($_POST['dimType']=='Height'){
		$wpdb->update($wpdb->prefix.'backgrounds', array('HEIGHT'=>$_POST['value']), array('IMAGEID'=>$_POST['IMAGEID']), array('%d'), array('%d')); 
	}
	$resultNew = $wpdb->get_row( "SELECT WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE IMAGEID=".$_POST['IMAGEID']);
	
	if($_POST['dimType']=='Width'){
		echo '{"status":"OK", "IMAGEID":"'.$_POST['IMAGEID'].'", "dimType":"'.$_POST['dimType'].'", "value":"'.$resultNew->WIDTH.'"}';
	}elseif($_POST['dimType']=='Height'){
		echo '{"status":"OK", "IMAGEID":"'.$_POST['IMAGEID'].'", "dimType":"'.$_POST['dimType'].'", "value":"'.$resultNew->HEIGHT.'"}';
	}
	die();
}

add_action('wp_ajax_add_video_item', 'add_video_item');
function add_video_item(){
	global $wpdb;
	$result = $wpdb->get_row( "SELECT MAX(SLIDERORDER)+1 as lastid FROM {$wpdb->prefix}backgrounds ");
	$target = $_POST['data'];
	$thumb = '';
	if($_POST['type']=='youtube')
		$thumb = 'http://img.youtube.com/vi/'.$_POST['data'].'/1.jpg';
	elseif($_POST['type']=='vimeo'){
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$_POST['data'].".php"));
		$thumb = $hash[0]['thumbnail_medium'];
	}	
	$insertResult = $wpdb->insert( $wpdb->prefix.'backgrounds', array('SLIDERORDER'=>$result->lastid, 'CONTENT'=>$target, 'TYPE'=>$_POST['type'], 
	'THUMB'=>$thumb, 'WIDTH'=>$_POST['width'], 'HEIGHT'=>$_POST['height'], 'GALLERYID'=>$_POST['GALLERYID']), array('%d','%s', '%s', '%s', '%d', '%d', '%d') );
	
	if($insertResult>0)
		echo '{"status":"OK", "IMAGEID":"'.$wpdb->insert_id.'", "GALLERYID":"'.$_POST['GALLERYID'].'"}';
	else
		echo '{"status":"NOK"}';
	
	die();
}


add_action('wp_ajax_remove_item_image', 'remove_item_image');
function remove_item_image()
{
	global $wpdb;
	$result = $wpdb->query("DELETE FROM {$wpdb->prefix}backgrounds WHERE IMAGEID = ".$_POST['IMAGEID']);
	if($result>0)
		echo '{"status":"OK", "IMAGEID":"'.$_POST['IMAGEID'].'"}';
	else
		echo '{"status":"NOK" "IMAGEID":"'.$_POST['IMAGEID'].'"}';
	die();
}

add_action('wp_ajax_add_new_gallery', 'add_new_gallery');
function add_new_gallery(){
	global $wpdb;
	$insertResult = $wpdb->insert( $wpdb->prefix.'galleries', array( 'GALLERYNAME'=>$_POST['name']), array('%s'));
	if($insertResult>0)
		echo json_encode(array('status'=>'OK', 'html'=>createGalleryListItem($wpdb->insert_id, $_POST['name'])));
	else
		echo json_encode(array('status'=>'NOK'));
	die();
}

add_action('wp_ajax_check_theme', 'check_theme');
function check_theme(){
	global $upload_dir, $settingsimages, $settingsimagesUrl, $galleryimages, $timthumbCacheDir;
	$re = '<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">
				<thead>
					<tr>
						<th colspan="2">'.__('THEME CHECK RESULT','rb').'S</th>
					</tr>
					<tr>
						<th width="50">'.__('STATUS','rb').'</th>
						<th>ITEM</th>
					</tr>
				</thead>                
				<tbody>';
	
	$re .= addCheckItem( array('name'=>__('TimThumb PHP Script','rb'), 'status'=>'wait', 'id'=>'timthumbcheck',
		'ErrMessage'=>__('ThimThumb image resizer script is not working on your server!','rb'), 
		'ErrInfo'=>__('This script resizes and crop the images. Without this script, you must edit your images manually.','rb')) );
	
	$chErr = checkDir($upload_dir['basedir'], 0777);
	$re .= addCheckItem( array('name'=>__('Upload Directory','rb'), 'status'=>$chErr['status'], 'ErrMessage'=>$chErr['err'], 'ErrInfo'=>__('This directory usually being used by WordPress for all media files. <strong>Default is wp-content/uploads</strong>. For that reason, you can\'t upload any image files without createing and giving its permissions.','rb')) );
	
	$chErr = checkDir($settingsimages, 0777);
	$re .= addCheckItem( array('name'=>__('Image Manager Directory','rb'), 'status'=>$chErr['status'], 'ErrMessage'=>$chErr['err'], 'ErrInfo'=>__('This folder is used by Image Manager in General Theme Settings. In order to run this function, this folder must be created.','rb')) );
	
	$chErr = checkDir($galleryimages, 0777);
	$re .= addCheckItem( array('name'=>__('Gallery Images Directory','rb'), 'status'=>$chErr['status'], 'ErrMessage'=>$chErr['err'], 'ErrInfo'=>__('This folder is used for uploading images in Gallery section.','rb')) );
	
	$chErr = checkDir($timthumbCacheDir, 0777);
	$re .= addCheckItem( array('name'=>__('TimThumb Cache Directory','rb'), 'status'=>$chErr['status'], 'ErrMessage'=>$chErr['err'], 'ErrInfo'=>__('If ThimThumb will be used, this folder must have needed permission.','rb')) );
			
	$wpnavi = (function_exists('wp_pagenavi'))?'ok':'nok';
	$re .= addCheckItem( array('name'=>__('WP-PageNavi Plugin','rb'), 'status'=>$wpnavi, 'ErrMessage'=>__('Please Install and Activate WP-PageNavi Plugin.', 'rb'), 'ErrInfo'=>__('This plugin is used for pagination in Blog and Portfolio sections. You can find this plugin in downloaded files / plugins folder.(You can watch the video about plugin installation)','rb')) );
		
	$getContentRemote = @file_get_contents('http://www.renklibeyaz.com/think.xml');
	$getContentRemoteStatus = empty($getContentRemote)?'nok':'ok';
	$re .= addCheckItem( array('name'=>__('file_get_contents Remote Server Access','rb'), 'status'=>$getContentRemoteStatus, 
		'ErrMessage'=>__('Your server is blocking "Remote Server Connection". Please contact your host provider to allow "file_get_contents" php function.','rb'), 
		'ErrInfo'=>__('This function gets the thumbnail of the video files, update the fonts and displaying notice about theme updates.','rb')) );
	
	
	$sxml = (function_exists('simplexml_load_string'))?'ok':'nok';
	$re .= addCheckItem( array('name'=>__('PHP SimpleXml Class','rb'), 'status'=>$sxml, 
		'ErrMessage'=>__('Your server doesn\\\'t have "SimpleXml Class" which is a PHP Class.','rb'), 
		'ErrInfo'=>__('This Class gets the thumbnail of the video files, displaying notice about theme updates.','rb')) );
	
	$curlStatus = (function_exists('curl_init'))?'ok':'nok';
	$re .= addCheckItem( array('name'=>__('PHP cURL Class','rb'), 'status'=>$curlStatus, 
		'ErrMessage'=>__('Your server doesn\'t have "cURL Class" which is a PHP Class.','rb'), 
		'ErrInfo'=>__('This Class is displaying notice about theme updates.','rb')) );
		
	$re .= '</tbody>
		<table>';
	echo $re;
	die();
}

function addCheckItem($params){
	$re = '';
	$re.= '<tr '.((!empty($params['id']))?'id="'.$params['id'].'"':'').'><td>';
	if($params['status']=='ok' || $params['status']=='wait')
		$re .= '<div class="statusIcon statusOK '.(($params['status']=='wait')?'statusWait':'').'"></div>';
	if($params['status']=='nok' || $params['status']=='wait')
		$re .= '<div class="statusIcon statusNOK '.(($params['status']=='wait')?'statusWait':'').'" ><div>';
	$re.= '</td><td>'.__($params['name'],'rb');
	
	if(($params['status']=='nok' && !empty($params['ErrMessage'])) || $params['status']=='wait')
		$re.= '<div class="ErrMessage '.(($params['status']=='wait')?'statusWait':'').'">'.__($params['ErrMessage'],'rb').'</div>';
	
	if(($params['status']=='nok' && !empty($params['ErrInfo'])) || $params['status']=='wait')
		$re.= '<div class="ErrInfo '.(($params['status']=='wait')?'statusWait':'').'">'.__($params['ErrInfo'],'rb').'</div>';
	
	$re.= '</td></tr>';
	return $re;
}

function checkDir($dir, $mode){
	if(!is_dir($dir)){
		@mkdir($dir, $mode);
		if(!is_dir($dir)){
			return array( 'err' => sprintf(__('This directory could not be created automatically. Please create "%s" directory and give %s permission.','rb'), $dir, decoct($mode)),
				'status'=>'nok',
				'code'=>1);
		}
	}
	if(is_dir($dir)){
		if(substr(decoct( fileperms($dir) ), 2)!=decoct($mode)){
			if(!chmod($dir, $mode))
				return array( 'err' => sprintf(__('This directory permissions could not be changed automatically. Please change permissions "%s" directory as %s.','rb'), $dir, decoct($mode)),
					'status'=>'nok',
					'code'=>2);
			else
				return array('status'=>'ok', 'code'=>3);
		}else
			return array('status'=>'ok', 'code'=>4);
	}
}

} // end of admin funtions

/*Front end Functions*/
add_action('wp_ajax_nopriv_get_portfolio_item_detail', 'get_portfolio_item_detail');
add_action('wp_ajax_get_portfolio_item_detail', 'get_portfolio_item_detail');
function get_portfolio_item_detail(){
	$itemid = (int) end(explode('-', $_POST['itemid']));
	$fullwidth = ($_POST['fullwidth']=='true')?true:false;
	$re = '';
	if($itemid>0){
		$the_post = get_post($itemid);
		
		$re .= '<div class="portfolio-media-'.(($fullwidth)?'withoutSidebar':'withSidebar').' '.(($fullwidth)?'sh_3of4':'sh_2of4').'">';
		$blogformat = strtolower( get_post_format($itemid) );
		if($blogformat == 'standart' || $blogformat == '') 	$blogformat = 'standart';
		
		if($blogformat=='image'){
			$re .= '<img width="100%" src="'.get_post_meta($itemid, "rb_format_portfolio_image_url", true).'" alt="" />';
		}elseif($blogformat=='video'){
			$videoUrl		= get_post_meta($itemid, "rb_format_portfolio_video_url", true);
			$videoHeight	= (int) get_post_meta($itemid, "rb_format_portfolio_video_height", true);
			$videoWidth	= (int) get_post_meta($itemid, "rb_format_portfolio_video_width", true);
			$videoPoster 	= get_post_meta($itemid, "rb_format_portfolio_video_poster", true);
			if(!empty($videoUrl) && $videoHeight>0){
				$sourceType = getMediaType($videoUrl);
				if($sourceType=='youtube' || $sourceType=='vimeo' || $sourceType=='jwplayer'){
					$sourceStr = getSource($videoUrl, $videoWidth, $videoHeight);
					if(!empty($sourceStr)){
						$re .= ' '.$sourceStr.' ';
					}
				}
			}
		}elseif($blogformat=='gallery'){
			$galleryid		= (int)get_post_meta($itemid, "rb_format_portfolio_gallery_id", true);
			if($galleryid>0){
				$re .= do_shortcode('[flexslider id="'.$galleryid.'" style="margin:0px;"]');
			}
		}
		
		$re .= '</div>';
		$re .= '<div class="portfolio-meta sh_1of4 column_end">';
		
		$re .= '<div class="portfolio-controls">';
			$re .= '<a href="javascript:void(0);" class="p-control p-control-close"></a>';
			$re .= '<a href="javascript:void(0);" class="p-control p-control-next"></a>';
			$re .= '<a href="javascript:void(0);" class="p-control p-control-prev"></a>';
		$re .= '</div>';
		$re .= '<div class="clearfix"></div>';
		$re .= '<hr class="mborder" />';
		
		$re .= '<h3 class="portfolio-controls">'.$the_post->post_title.'</h3>';
		
		$client	= get_post_meta($itemid, "rb_format_portfolio_client", true);
		if(!empty($client)){
			$re .= '<hr class="mborder" />';
			$re .= '<h6>'.__('Client', 'rb').'</h6>';
			$re .= '<span>'.$client.'</span>';
		}


		if(count(get_the_category($itemid))){
			$re .= '<hr class="mborder" />';
			//$re .= '<h6>'.__('Categories', 'rb').'</h6>';
			$re .= '<div class="meta-row">';
			$addcat = '';
			foreach((get_the_category($itemid)) as $category)
				$addcat .= '<a rel="category" title="'.__('View all posts in ', 'rb').$category->cat_name.'" href="javascript:void(0);" onclick="setFilter(\''.$category->cat_ID.'\')">'.$category->cat_name.'</a>, ';
			$re .= substr($addcat, 0, -2);
			$re .= '</div>';
		}
		
		$plink	= get_post_meta($itemid, "rb_format_portfolio_plink", true);
		if(!empty($plink)){
			$re .= '<hr class="mborder" />';
			$re .= '<h6>'.__('Project Link', 'rb').'</h6>';
			$re .= '<a href="'.$plink.'" target="_blank">'.__('Launch Project', 'rb').'</a>';
		}
		
		if(!empty($the_post->post_content)){
			$re .= '<hr class="mborder" />';
			$re .= '<p>'.$the_post->post_content.'</p>';
		}
		$re .= '</div>'; 
		$re .= '<div class="clearfix"></div>';
		echo $re;
		die();
	}else
		echo 'Error';
		
	die();
}

?>