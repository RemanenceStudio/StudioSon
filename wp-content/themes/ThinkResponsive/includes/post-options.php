<?php
//use thumbnail with post
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array('aside', 'audio', 'gallery', 'image', 'link', 'quote', 'video') );

//Create new post type as Portfolio
add_action( 'init', 'create_portfolio_post_type' );
function create_portfolio_post_type() {
	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' => __('Portfolios','rb'),
				'singular_name' => __('Portfolios', 'rb'),
				'add_new' => __('Add New Portfolio Item', 'rb'),
				'edit_item' => __('Edit Portfolio Item', 'rb'),
				'new_item' => __('New Portfolio Item', 'rb'),
				'view_item' => __('View Portfolio Item', 'rb'),
				'search_items' => __('Search Portfolio Item', 'rb'),
				'not_found' => __('Not found any portfolio item.', 'rb'),
				'not_found_in_trash' => __('Not found any portfolio item in trash', 'rb')
			),
			'public' => true,
			'supports' => array(
				'editor',
				'title',
				'excerpt',
				'custom-fields',
				'thumbnail',
				'post-formats'
				),
			'has_archive' => true,
			'rewrite' => array('slug' => 'portfolios'),
			'taxonomies' => array('category', 'post_tag'),
			'menu_position' => 6
		)
	);
}

function postf($postid)
{
    $post_ID = (int) $_GET['post'];
    $postType = get_post_type( $post_ID );
	
    if( $_GET['post_type']=='portfolio' || $postType == 'portfolio' )
    {
        add_theme_support( 'post-formats', array( 'image', 'gallery', 'video' ) );
        add_post_type_support( 'portfolio', 'post-formats' );
    }
}
add_action('init', 'postf');



/* Structure */
$meta_box[] = array(
	'id' => 'page-general-sidebar',
	'title' => __('Sidebar Option','rb'),
	'post_type' => 'page',
	'post_format' => '',
	'func' => 'pageGeneralSidebar',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Sidebar Position','rb'),
			'id' => 'sidebarPos',
			'type' => 'select',
			'default' => 'Default',
			'options'=> array(__('Default','rb')=>'Default',__('Right','rb')=>'Right',__('Left','rb')=>'Left',__('None','rb')=>'None')
		)
	)
);

//Meta Boxes for Post Formats
$meta_box[] = array(
	'id' => 'post-meta-general',
	'title' => 'Additional Post General',
	'post_type' => 'post',
	'post_format' => '',
	'func' => 'postMetaGeneral',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Show in Detail Page','rb'),
			'id' => 'useInDetail',
			'type' => 'hidden',
			'default' => ''
		),
		array(
			'name' => __('Use Image Resizer Script','rb'),
			'id' => 'useResizer',
			'type' => 'hidden',
			'default' => ''
		)
	)
);

$meta_box[] = array(
	'id' => 'post-general-sidebar',
	'title' => __('Sidebar Option','rb'),
	'post_type' => 'post',
	'post_format' => '',
	'func' => 'postGeneralSidebar',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Sidebar Position','rb'),
			'id' => 'sidebarPos',
			'type' => 'select',
			'default' => 'Default',
			'options'=> array(__('Default','rb')=>'Default',__('Right','rb')=>'Right',__('Left','rb')=>'Left',__('None','rb')=>'None')
		)
	)
);


$meta_box[] = array(
	'id' => 'post_meta_quote',
	'title' => __('Quote for The Post','rb'),
	'post_type' => 'post',
	'post_format' => 'quote',
	'func' => 'postMetaQuote',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Quote','rb'),
			'desc' => __('(Info) Title will be shown as owner of quote','rb'),
			'id' => 'rb_format_quote', 
			'type' => 'textarea',
			'default' => ''
			)
		)
);

$meta_box[] = array(
	'id' => 'post_meta_image',
	'title' => __('Large Size Image URL','rb'),
	'post_type' => 'post',
	'post_format' => 'image',
	'func' => 'postMetaImage',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Lager Image URL','rb'),
			'desc' => __('(Required) URL of the large image','rb'),
			'id' => 'rb_format_big_image_url', 
			'type' => 'imageuploadbutton',
			'default' => ''
			)
		)
);

$meta_box[] = array(
	'id' => 'post_meta_link',
	'title' => __('URL for Link Format','rb'),
	'post_type' => 'post',
	'post_format' => 'link',
	'func' => 'postMetaLink',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('URL','rb'),
			'desc' => __('(Required) URL will be open in new window','rb'),
			'id' => 'rb_format_link_url', 
			'type' => 'text',
			'default' => 'http://'
			)
		)
);

$meta_box[] = array(
	'id' => 'post_meta_video',
	'title' => __('Video for The Post','rb'),
	'post_type' => 'post',
	'post_format' => 'video',
	'func' => 'postMetaVideo',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Video URL','rb'),
			'desc' => __('(Required) You can enter a url like youtube, vimeo or self hosted video file.','rb'),
			'id' => 'rb_format_video_url', 
			'type' => 'text',
			'default' => ''
			),
		array(
			'name' => __('Video Height','rb'),
			'desc' => __('(Required) As an integer','rb'),
			'id' => 'rb_format_video_height', 
			'type' => 'text',
			'default' => ''
			),
		array(
			'name' => __('Video Width','rb'),
			'desc' => __('(Required) As an integer','rb'),
			'id' => 'rb_format_video_width', 
			'type' => 'text',
			'default' => ''
			)/*,
		array(
			'name' => __('Poster Image URL','rb'),
			'desc' => __('(Optional) For self hosted video','rb'),
			'id' => 'rb_format_video_poster', 
			'type' => 'imageuploadbutton',
			'default' => ''
			)*/
		)
);

$meta_box[] = array(
	'id' => 'post_meta_audio',
	'title' => __('Audio for The Post','rb'),
	'post_type' => 'post',
	'post_format' => 'audio',
	'func' => 'postMetaAudio',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Audio File URL','rb'),
			'desc' => __('(Required) You can enter a url of your file. Supported .aac, .m4a, .f4a, .ogg, .oga and .mp3','rb'),
			'id' => 'rb_format_audio_url', 
			'type' => 'text',
			'default' => ''
			)
		)
);

$meta_box[] = array(
	'id' => 'post_meta_gallery',
	'title' => __('Gallery ID','rb'),
	'post_type' => 'post',
	'post_format' => 'gallery',
	'func' => 'postMetaGallery',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Galley [id] Name','rb'),
			'desc' => __('(Required)','rb'),
			'id' => 'rb_format_gallery_id', 
			'type' => 'galleryid',
			'default' => ''
			)
		)
);

//Meta Boxes for Portfolio Formats
$meta_box[] = array(
	'id' => 'portfolio-meta-general',
	'title' => __('Additional Portfolio Settings','rb'),
	'post_type' => 'portfolio',
	'post_format' => '',
	'func' => 'portfolioMetaGeneral',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Use Image Resizer Script','rb'),
			'id' => 'useResizer',
			'type' => 'hidden',
			'default' => ''
		),
		array(
			'name' => __('Crop Position','rb'),
			'id' => 'cropPos',
			'type' => 'hidden',
			'default' => ''
		)
	)
);
	
$meta_box[] = array(
	'id' => 'portfolio_meta_gallery',
	'title' => __('Gallery ID','rb'),
	'post_type' => 'portfolio',
	'post_format' => 'gallery',
	'func' => 'portfolioMetaGallery',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Galley [id] Name','rb'),
			'desc' => __('(Required)','rb'),
			'id' => 'rb_format_portfolio_gallery_id', 
			'type' => 'galleryid',
			'default' => ''
			)
		)
);

$meta_box[] = array(
	'id' => 'portfolio_meta_image',
	'title' => __('Large Size Image URL','rb'),
	'post_type' => 'portfolio',
	'post_format' => 'image',
	'func' => 'portfolioMetaImage',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Lager Image URL','rb'),
			'desc' => __('(Required) URL of the large image','rb'),
			'id' => 'rb_format_portfolio_image_url', 
			'type' => 'imageuploadbutton',
			'default' => ''
			)
		)
);

$meta_box[] = array(
	'id' => 'portfolio_meta_video',
	'title' => __('Video for The Portfolio','rb'),
	'post_type' => 'portfolio',
	'post_format' => 'video',
	'func' => 'portfolioMetaVideo',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Video URL','rb'),
			'desc' => __('(Required) You can enter a url like youtube, vimeo or self hosted video file.','rb'),
			'id' => 'rb_format_portfolio_video_url', 
			'type' => 'text',
			'default' => ''
			),
		array(
			'name' => __('Video Height','rb'),
			'desc' => __('(Required) As an integer','rb'),
			'id' => 'rb_format_portfolio_video_height', 
			'type' => 'text',
			'default' => ''
			),
		array(
			'name' => __('Video Width','rb'),
			'desc' => __('(Required) As an integer','rb'),
			'id' => 'rb_format_portfolio_video_width', 
			'type' => 'text',
			'default' => ''
			)/*,
		array(
			'name' => __('Poster Image URL','rb'),
			'desc' => __('(Optional) For self hosted video','rb'),
			'id' => 'rb_format_portfolio_video_poster', 
			'type' => 'imageuploadbutton',
			'default' => ''
			)*/
		)
);

$meta_box[] = array(
	'id' => 'portfolio_meta_general2',
	'title' => __('Portfolio Client and Link','rb'),
	'post_type' => 'portfolio',
	'post_format' => '',
	'func' => 'portfolioMetaGeneral2',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Client','rb'),
			'desc' => __('(Optional)','rb'),
			'id' => 'rb_format_portfolio_client', 
			'type' => 'text',
			'default' => ''
			),
		array(
			'name' => __('Portfolio Link','rb'),
			'desc' => __('(Optional)','rb'),
			'id' => 'rb_format_portfolio_plink', 
			'type' => 'text',
			'default' => ''
			)
		)
);

// Meta Creation Functions
function pageGeneralSidebar(){
	$meta = getPostMeta('pageGeneralSidebar');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function postMetaGeneral(){
	global $post;
	
	$meta = getPostMeta('postMetaGeneral');
	if(checkVisible($meta)){
	?>
	<style>
	#cpositions{
		width:111px; 
		height:111px; 
		padding:3px; 
		border:1px solid #eee;
	}
	.cposition{
		display:block;
		float:left;
		margin-right:3px;
		margin-bottom:3px;
		width:33px; 
		height:33px; 
		border:1px solid #ddd;
	}
	.cpselected{
		border-color:#ff0000;
	}
	</style>
	
	
	<div style="width:50%; float:left;">
		<input type="checkbox" name="useInDetail" id="useInDetail" value="use"  <?php echo (get_post_meta( $post->ID,"useInDetail",true)=='use')?'checked':''; ?> /> 
		<?php _e('Show in Detail Page','rb'); ?>
	</div>
	
	<div style="width:50%; float:left;">
		<input type="checkbox" name="useResizer" id="useResizer" value="use"  <?php echo (get_post_meta( $post->ID,"useResizer",true)=='use')?'checked':''; ?> /> 
		<?php _e('Use Image Resizer Script','rb') ?>
	</div>
	<div style="clear:both;"></div>
	<?php
	}
}



function portfolioMetaGeneral(){
	global $post;
	
	$meta = getPostMeta('portfolioMetaGeneral');
	if(checkVisible($meta)){
	?>
	<style>
	#cpositions{
		width:111px; 
		height:111px; 
		padding:3px; 
		border:1px solid #eee;
	}
	.cposition{
		display:block;
		float:left;
		margin-right:3px;
		margin-bottom:3px;
		width:33px; 
		height:33px; 
		border:1px solid #ddd;
	}
	.cpselected{
		border-color:#ff0000;
	}
	</style>
	<script>
	function setCropPos(obj, pos){
		jQuery('#cropPos').val(pos);
		jQuery('#cpositions a').removeClass('cpselected');
		jQuery(obj).addClass('cpselected');
		if(pos=='t')
			jQuery('#cpositions .tl, #cpositions .tr').addClass('cpselected');
		if(pos=='b')
			jQuery('#cpositions .bl, #cpositions .br').addClass('cpselected');
		if(pos=='l')
			jQuery('#cpositions .tl, #cpositions .bl').addClass('cpselected');
		if(pos=='r')
			jQuery('#cpositions .tr, #cpositions .br').addClass('cpselected');
	}
	</script>
	
		<div style="width:50%; float:left;">
			<input type="checkbox" name="useResizer" id="useResizer" value="use"  <?php echo (get_post_meta( $post->ID,"useResizer",true)=='use')?'checked':''; ?> /> 
			<?php _e('Use Image Resizer Script','rb') ?>
		</div>
		
		<div style="width:50%; float:left;">
			<?php _e('Select a Crop Position','rb'); ?>
			<?php $cp = get_post_meta($post->ID,"cropPos",true); ?>
			<div id="cpositions">
				<a class="cposition tl <?php echo ($cp=='tl' || $cp=='t' || $cp=='l')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'tl');" ></a>
				<a class="cposition t <?php echo  ($cp=='t')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 't');" ></a>
				<a class="cposition tr <?php echo ($cp=='tr' || $cp=='t' || $cp=='r')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'tr');" style="margin-right:0px;"></a>
				
				<a class="cposition l <?php echo  ($cp=='l')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'l');" ></a>
				<a class="cposition c <?php echo  ($cp=='c' || $cp=='')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'c');" ></a>
				<a class="cposition r <?php echo  ($cp=='r')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'r');" style="margin-right:0px;"></a>
				
				<a class="cposition bl <?php echo ($cp=='bl' || $cp=='b' || $cp=='l')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'bl');" ></a>
				<a class="cposition b <?php echo  ($cp=='b')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'b');" ></a>
				<a class="cposition br <?php echo ($cp=='br' || $cp=='b' || $cp=='r')?'cpselected':''; ?>" href="javascript:void(0);" onclick="setCropPos(this, 'br');" style="margin-right:0px;"></a>
			</div>
			
			<input type="hidden" name="cropPos" id="cropPos" value="<?php echo (get_post_meta($post->ID,"cropPos",true)=='')?'c':get_post_meta( $post->ID,"cropPos",true); ?>" />
		</div>
	<div style="clear:both;"></div>
	<?php
	}
}

function postGeneralSidebar(){
	$meta = getPostMeta('postGeneralSidebar');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function postMetaQuote(){
	$meta = getPostMeta('postMetaQuote');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function postMetaLink(){
	$meta = getPostMeta('postMetaLink');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function postMetaImage(){
	$meta = getPostMeta('postMetaImage');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function postMetaVideo(){
	$meta = getPostMeta('postMetaVideo');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function postMetaAudio(){
	$meta = getPostMeta('postMetaAudio');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function postMetaGallery(){
	$meta = getPostMeta('postMetaGallery');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function portfolioMetaGallery(){
	$meta = getPostMeta('portfolioMetaGallery');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function portfolioMetaImage(){
	$meta = getPostMeta('portfolioMetaImage');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function portfolioMetaVideo(){
	$meta = getPostMeta('portfolioMetaVideo');
	if(checkVisible($meta))
		createMetaForm($meta);
}

function portfolioMetaGeneral2(){
	$meta = getPostMeta('portfolioMetaGeneral2');
	if(checkVisible($meta))
		createMetaForm($meta);
}

add_action('admin_menu', 'rb_add_box');
add_action('save_post', 'rb_save_data');

//Add meta boxes to post types
function rb_add_box(){
	wp_enqueue_script('postOptionsScript', get_template_directory_uri() . '/includes/js/post-options.js', false, null);
	
	global $meta_box, $post;
	foreach($meta_box as $value)
		add_meta_box($value['id'], $value['title'], $value['func'],  $value['post_type'], $value['context'], $value['priority']);
}

function getPostMeta($func){
	global $meta_box;
	$currentMeta;
	foreach($meta_box as $value){
		if($value['func']==$func){
			$currentMeta = $value;
		}
	}
	if(!is_array($currentMeta))
		return false;
		
	return $currentMeta;
}

function checkVisible($current){
	global $meta_box, $post;
	$post_format = get_post_format($post->ID);
	$post_type = $post->post_type;

	if(!is_array($current))
		return false;
		
	if(!(	($post_type==$current['post_type'] || empty($current['post_type'])) && ($post_format==$current['post_format'] || empty($current['post_format'])) ))
	{
		echo "<script>
			jQuery(document).ready(function($){
				$('#".$current['id']."').hide();
			});
		</script>";
		return false;
	}else
		return true;
}

function createMetaForm($metaBox){
	global $post, $wpdb;
	echo '<input type="hidden" name="rb_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
	
	foreach ($metaBox['fields'] as $field){
	// get current post meta data
	$meta = get_post_meta($post->ID, $field['id'], true);
	
	echo '<tr>'.
		'<th style="width:20%"><label for="'. $field['id'] .'">'. __($field['name'],'rb'). '</label></th>'.
		'<td>';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" size="30" style="width:97%" />'. '<br />'. $field['desc'];
				break;
			case 'imageuploadbutton':
				echo '<input type="text" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" size="30" style="width:80%" />
				<input id="'. $field['id'] .'_button" class="button uploadBtnToURL" type="button" rel="'.$field['id'].'" value="Browse" name="'. $field['id'] .'_button" style="float: right;"> <br />'. $field['desc'];
				break;
			case 'hidden':
				echo '<input type="hidden" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" />';
				break;
			case 'textarea':
				echo '<textarea name="'. $field['id']. '" id="'. $field['id']. '" cols="60" rows="4" style="width:97%">'. ($meta ? $meta : $field['default']) . '</textarea>'. '<br />'. $field['desc'];
				break;
			case 'select':
				echo '<select name="'. $field['id'] . '" id="'. $field['id'] . '">';
				if(is_assoc($field['options']))
					foreach($field['options'] as $optionk => $optionv)
						echo '<option value="'.$optionv.'" '. ( $meta == $optionv ? ' selected="selected"' : '' ) . '>'.__($optionk,'rb').'</option>';
				else
					foreach($field['options'] as $option)
						echo '<option value="'.$option.'" '. ( $meta == $option ? ' selected="selected"' : '' ) . '>'.$option.'</option>';
				
				
				echo '</select>';
				break;
			case 'galleryid':
				echo '<select name="'. $field['id'] . '" id="'. $field['id'] . '" style="width:97%" >';
				$result = $wpdb->get_results("SELECT GALLERYID, GALLERYNAME FROM {$wpdb->prefix}galleries ORDER BY GALLERYID");
				foreach ($result as $option) {
					echo '<option value="'.$option->GALLERYID.'" '. ( $meta == $option->GALLERYID ? ' selected="selected"' : '' ) . '>[#'. $option->GALLERYID.'] '.$option->GALLERYNAME . '</option>';
				}
				echo '</select>';
				break;
			case 'radio':
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="' . $field['id'] . '" value="' . $option['value'] . '"' . ( $meta == $option['value'] ? ' checked="checked"' : '' ) . ' />' . __($option['name'],'rb');
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '"' . ( $meta ? ' checked="checked"' : '' ) . ' />';
				break;
		}
		echo '<td>'.'</tr>';
	}
	echo '</table>';
}


// Save data from meta box
function rb_save_data($post_id){
	global $meta_box, $post;
	
	//Verify nonce
	if (!wp_verify_nonce($_POST['rb_meta_box_nonce'], basename(__FILE__))) return $post_id;
	
	//Check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	//Check quick edit
	if(defined('DOING_AJAX') && DOING_AJAX) return $post_id;
	
	//Check permissions
	if ('page' == $_POST['post_type'])
		if (!current_user_can('edit_page', $post_id)) return $post_id;
	elseif (!current_user_can('edit_post', $post_id)) return $post_id;

	for($y=0; $y<sizeof($meta_box); $y++){
		foreach ($meta_box[$y]['fields'] as $field){
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old) update_post_meta($post_id, $field['id'], $new);
			elseif ('' == $new && $old) delete_post_meta($post_id, $field['id'], $old);
		}
	}
}


?>