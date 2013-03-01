<?php
$demo = false;
$upload_dir = wp_upload_dir();
$settingsimages = $upload_dir['basedir'].'/settingsimages';
$settingsimagesUrl = $upload_dir['baseurl'].'/settingsimages';
$galleryimages = $upload_dir['basedir'].'/galleryimages';
$galleryimagesUrl = $upload_dir['baseurl'].'/galleryimages';
$timthumbCacheDir = get_template_directory().'/includes/cache';

include("includes/admin-structure.php");
include("includes/general-settings.php");
include('includes/post-options.php');
include("includes/register-widgets.php");
include("includes/shortcodes.php");
include("includes/main-ajax.php");
include("includes/RB_flickr_widget.php");
include("includes/RB_twitter_widget.php");
include("includes/RB_newsletter_widget.php");
include("includes/update_notifier.php");

function getSettingsItem($itemid){
	global $SettingsOptions;
	$re = false;
	foreach($SettingsOptions as $sm){
		if($sm['type']=='fields'){
			foreach($SettingsOptions as $field){
				if($field['id']==$itemid){
					$re = $field;
					break;
				}
			}
		}
	}
	return $re;
}

function is_assoc($array) {
  return (bool)count(array_filter(array_keys($array), 'is_string'));
}

// disabled auto tags such as br, p
remove_filter ('the_content', 'wpautop');

// localization support
load_theme_textdomain('rb');

// For use shortcode in widgets
add_filter('widget_text', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');

// menus
register_nav_menu('primary', 'Main Navigation');

if($demo){
	function enqueue_less_styles($tag, $handle) {
		global $wp_styles;
		$match_pattern = '/\.less$/U';
		if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
			$handle = $wp_styles->registered[$handle]->handle;
			$media = $wp_styles->registered[$handle]->args;
			$href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
			$rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
			$title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

			$tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
		}
		return $tag;
	}
	add_filter( 'style_loader_tag', 'enqueue_less_styles', 5, 2);
}

if(!is_admin())
{
   	$tmpurl = get_template_directory_uri();
	wp_enqueue_script("jquery", $tmpurl."/js/jquery-1.6.2.min.js", false, null); 
	wp_enqueue_script("superfish", $tmpurl."/js/superfish.js", false, null); 
	wp_enqueue_script("easing",$tmpurl."/js/jquery.easing.1.3.js", false, null);
	wp_enqueue_script("slider", $tmpurl."/js/jquery.flexslider.js", false, null); 
	wp_enqueue_script("main", $tmpurl."/js/main.js", false, null); 
	wp_enqueue_script("color", $tmpurl."/js/jquery.color.js", false, null); 
	wp_enqueue_script("carouFredSel", $tmpurl."/js/jquery.carouFredSel-5.5.3-packed.js", false, null); 
	wp_enqueue_script("jwplayer", $tmpurl."/jwplayer/jwplayer.js", false, null);
	wp_enqueue_script("fitvids", $tmpurl."/js/jquery.fitvids.js", false, null);
	wp_enqueue_script("quicksand", $tmpurl."/js/jquery.quicksand.js", false, null);
	wp_enqueue_script("modal", $tmpurl."/includes/prettyPhoto/js/jquery.prettyPhoto.js", false, null); 
	wp_enqueue_script("html5shiv", $tmpurl."/js/html5shiv.js", false, null); 
	wp_enqueue_script("uicore", $tmpurl."/js/jquery-ui-1.8.19.min.js", false, null); 

	wp_enqueue_style("modal", $tmpurl."/includes/prettyPhoto/css/prettyPhoto.css", false, null, 'all'); 
	wp_enqueue_style('generalStyle', $tmpurl."/style.css", false, null, 'all');
	wp_enqueue_style('flexslider', $tmpurl."/css/flexslider.css", false, null, 'all');
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	
	if(!$demo)
		wp_enqueue_style('ThemeStyle', $tmpurl."/style.php", false, null, 'all');
	if($demo){
		wp_enqueue_script("cookie", $tmpurl."/js/jquery.cookie.js", false, null);
		wp_enqueue_script("lesscss", $tmpurl."/js/less-1.1.6.js", false, null);
		//wp_enqueue_style('lessStyle', $tmpurl."/style.less", false, null, 'all');
		wp_enqueue_style('ThemeStyle', $tmpurl."/style.php?file=style.less", false, null, 'all');
		wp_enqueue_style('democss', $tmpurl."/css/demo.css", false, null, 'all');
	}
	
}


function getFont($name, $type='url', $opt='')
{
	$fonts = json_decode(get_option('fonts'));
	$font;
	for($i=0; $i<sizeof($fonts->items); $i++)
	{
		if($fonts->items[$i]->family==$name)
		{
			$font = $fonts->items[$i];
			break;
		}
	}
	
	if($type=='url' && isset($font))
	{
		$url = 'http://fonts.googleapis.com/css?family='.urlencode($font->family);
		
		if(sizeof($font->variants)==1)
		{
			$url .= ':'.$font->variants[0];
		}
		else{
			$url .= ':'.opt($opt.'Variant','');
		}
			
		$url .= '&subset='.implode(',',$font->subsets);
		return $url;
	}
	
	if($type=='variants' && isset($font))
	{
		return $font->variants;
	}
}

function opt($v, $def)
{
	if(!session_is_registered('previewID'))
	{
		if($v=='contentFontFull' || $v=='headerFontFull')
		{
			$v = str_replace('Full','', $v);
			return getFont(opt($v,''),'url',$v);
		}
		elseif(get_option($v)=='' && !empty($def))
			return $def;
		elseif(get_option($v)=='' && empty($def)){
			$item = getSettingsItem($v);
			if(is_array($item) && !empty($item['default']))
				return $item['default'];
			else
				return '';
		}else
			return get_option($v);
	}/*else{
		global $wpdb;
		$select_query = "SELECT s.*
							FROM settings s
							WHERE s.ID='".$_SESSION['previewID']."'";
		$query = $wpdb->get_results($select_query);
		if(sizeof($query)==1)
		{
			$datajson = json_decode($query[0]->SETTINGS);
			if($v=='contentFontFull' || $v=='headerFontFull')
			{
				$v = str_replace('Full','', $v);
				return getFont(opt($v,''),'url',$v);
			}
			elseif(!isset($datajson->{$v}))
				$data = get_option($v);
			else
				$data = $datajson->{$v};
				
			return $data;
		}else
			$data = get_option($v);
	}*/
}
function eopt($v, $def){ echo opt($v, $def); }

function createItemForImageList($name, $url)
{
$id = str_replace('.', '', $name);
$ret ='
	<tr id="imgs'.$id.'" rel="'.$url.'">
		<td>';
	$ext = strtolower(end(explode('.',$name)));
	if($ext=='jpg' || $ext=='gif' || $ext=='png')
		$ret .= '<img id="img'.$id.'" rel="selectable" src="'. get_template_directory_uri() .'/includes/timthumb.php?src='.$url.'&h=35&w=35&zc=1&q=100" width="35" height="35" style="border:1px solid #333" />';
	else
		$ret .= '<div id="img'.$id.'" rel="selectable" style="width:35px; height:35px" style="border:1px solid #333">'.$ext.' File</div>';
$ret .= '</td>
		<td>'.$name.'<br />
			<a href="javascript:void(0);" onclick="imageDelete(\''.$id.'\',\''.$name.'\')">'.__('[Delete]','rb').'</a>
		</td>
	</tr>
';
return $ret;
}



// clear page navi style
function wp_pagenavi_clear(){
	wp_deregister_style('wp-pagenavi');
}
add_action( 'wp_print_styles', 'wp_pagenavi_clear');

function wp_title_modification( $title, $separator ){
	global $paged;

	if(is_search())
	{
		$title = __('Results for ', 'rb').get_search_query();
		$title .= " $separator ".get_bloginfo('name');
		return $title;
	}else{
	
		if($paged>1) 
			$title .= ' '.__('Page ','rb').$paged." $separator ";
			
		$title .= get_bloginfo('name');

		$description = get_bloginfo('description');

		if((is_home() || is_front_page()) && $description) 
			$title .= " $separator ".$description;
		return $title;
	}
}
add_filter( 'wp_title', 'wp_title_modification', 10, 2 );

class My_Walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth, $args) 
	{
		global $wp_query;
		$incount=($depth)?str_repeat( "\t",$depth):'';
		$li_class_name='';
		$val='';
 
		if(empty( $item->classes ))
			$classes=array();
		else
			$classes=(array)$item->classes;
 
		$li_class_name=join(' ',apply_filters( 'nav_menu_css_class', array_filter($classes),$item));
		$li_class_name=' class="'.esc_attr($li_class_name).'"';
 
		$output.=$incount.'<li id="menu-item-'.$item->ID.'"'.$val.$li_class_name.'>';
 
		$attributes= !empty($item->attr_title)?' title="'  .esc_attr($item->attr_title).'"':'';
		$attributes.=!empty($item->target)?' target="' .esc_attr( $item->target) .'"':'';
		$attributes.= !empty($item->xfn)?' rel="'    .esc_attr( $item->xfn).'"':'';
		$attributes.= !empty($item->url)?' href="'   .esc_attr($item->url).'"':'';
 
		$out = '';
		$out= $args->before;
		$out.='<a'. $attributes .'><span class="title">';
		$out.=$args->link_before.apply_filters('the_title',$item->title,$item->ID).$args->link_after.'</span>';
		$out.='<span class="description">'.$item->description.'</span>';
		$out.='</a>';
		$out.= $args->after;
 
		$output.=apply_filters('walker_nav_menu_start_el',$out,$item,$depth,$args);
	}
}

class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
	var $to_depth = -1;
    function start_lvl(&$output, $depth){
      $output .= '</option>';
    }
	
    function end_lvl(&$output, $depth){
      $indent = str_repeat("\t", $depth); // don't output children closing tag
    }
	
    function start_el(&$output, $item, $depth, $args){
		$indent = ( $depth ) ? str_repeat( "&nbsp;", $depth * 4 ) : '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-dropdown-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
		$id = apply_filters( 'nav_menu_item_id', 'menu-dropdown-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		$value = ' value="'. $item->url .'"';
		$output .= '<option'.$id.$value.$class_names.'>';
		$item_output = $args->before;
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$output .= $indent.$item_output;
    }

    function end_el(&$output, $item, $depth){
		if(substr($output, -9) != '</option>')
      		$output .= "</option>"; // replace closing </li> with the option tag
    }
}

function getSource($sourceData, $imageW, $imageH, $addParams=null)
{
	if(!empty($sourceData))
	{
		$embedCode = '';
		$sourceType = getMediaType(trim($sourceData));
		$ext = getMediaType(trim($sourceData), 'ext');
		$mediaParams = getParamsFromUrl(trim($sourceData));
		if(empty($sourceType))
			return '';
	
			if($sourceType=='vimeo')
				$embedCode = '<iframe src="http://player.vimeo.com/video/'.$mediaParams['v'].'?title=0&amp;byline=0&amp;portrait=0" width="'.$imageW.'" height="'.$imageH.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			elseif($sourceType=='youtube')
				$embedCode = '<iframe width="'.$imageW.'" height="'.$imageH.'" src="http://www.youtube.com/embed/'.$mediaParams['v'].'?wmode=transparent&amp;rel=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>';
			elseif($sourceType=='jwplayer' || $sourceType=='jwplayeraudio')
			{
				$rand = createRandomKey(5);
				
				if($sourceType=='jwplayeraudio'){
					$imageSW = '100%';
					$imageSH = '24px';
					$imageW = '"100%"';
				}else{
					$imageSW = $imageW.'px';
					$imageSH = $imageH.'px';
				}
				
				$addtional = '';
				if(@!empty($addParams['image']))
					$addtional .= 'image: "'.$addParams['image'].'", ';


				
				$embedCode = '<div id="jwEP'.$rand.'" ></div>
							<script>
							jwplayer("jwEP'.$rand.'").setup({
								flashplayer: "'.get_template_directory_uri().'/jwplayer/player.swf",
								autostart: false,
								file: "'.$mediaParams['vurl'].'",
								controlbar: "bottom",
								height: '.$imageH.',
								'.$addtional.'
								width: '.$imageW.'
								});
								';
				if($sourceType=='jwplayeraudio')
					$embedCode .= '$("#jwEP'.$rand.'_wrapper").addClass("noVideoFit");';
				$embedCode .= '</script>';
				
			}
			elseif($sourceType=='flash')
			{
				$rand = createRandomKey(5);
				$embedCode = '<div id="flashContent'.$rand.'">
								<p>You need to <a href="http://www.adobe.com/products/flashplayer/" target="_blank">upgrade your Flash Player</a> to version 10 or newer.</p>  
							</div>
							<script type="text/javascript">  
									var flashvars = {};  
									var attributes = {};  
									attributes.wmode = "transparent";
									attributes.play = "true";
									attributes.menu = "false";
									attributes.scale = "showall";
									attributes.wmode = "transparent";
									attributes.allowfullscreen = "true";
									attributes.allowscriptaccess = "always";
									attributes.allownetworking = "all";					
									swfobject.embedSWF("'.$mediaParams['vurl'].'", "flashContent'.$rand.'", "'.$imageW.'", "'.$imageH.'", "10", "'.get_template_directory_uri().'/js/expressInstall.swf", flashvars, attributes);  
							</script>';
			}
			return $embedCode;
	}
}

function getMediaType($mediaUrl, $type='type'){
	if (stripos($mediaUrl, 'youtu.be')!==false || stripos($mediaUrl, 'youtube.com/watch')!==false)
		return 'youtube';
	else if(stripos($mediaUrl,'vimeo.com')!==false)
		return 'vimeo';
	else{
		$extensions = explode('.',$mediaUrl);
		if(sizeof($extensions)>1)
		{
			$qmPosition = stripos(end($extensions),'?');
			if($qmPosition>0)
				$le = substr(end($extensions), $qmPosition);
			else
				$le = end($extensions);
			$le = strtolower($le);
			
			if($type=='type'){
				if($le=='flv' || $le=='f4v' || $le=='m4v' || $le=='mp4' || $le=='mov' || $le=='webm')
					return 'jwplayer';
				else if($le=='aac' || $le=='m4a' || $le=='f4a' || $le=='ogg' || $le=='oga' || $le=='mp3')
					return 'jwplayeraudio';
				else if($le=='swf')
					return 'html5';
				else
					return '';
			}else{
				return $le;
			}
		}else
			return '';
	}
}
function getParamsFromUrl($mediaURL){
	$params = array();
	$urlSections = explode('/', $mediaURL);
	$lastSection = end($urlSections);
	$qmPosition = stripos($lastSection,'?');
	if(stripos($mediaURL, '?')!==false)
		$params['vurl'] = substr($mediaURL, 0, stripos($mediaURL, '?')); 
	else
		$params['vurl'] = $mediaURL;
		
	if($qmPosition>-1){
		$params['v'] = substr($lastSection, 0, $qmPosition); 
		$queryString = substr($lastSection, $qmPosition+1); 
		$qsSections = explode('&', $queryString);
		for($i=0; $i<sizeof($qsSections); $i++){
			$keyValue = explode('=', $qsSections[$i]);
			if(sizeof($keyValue)==2)
				$params[$keyValue[0]] = $keyValue[1];
		}
	}else{
		$params['v'] = $lastSection;
	}
	return $params;
}

function getTweets($username,$number) 
{
	//$xml = @simplexml_load_file('http://search.twitter.com/search.atom?q='.urlencode($username)."&rpp=".$number);
	$xml = @simplexml_load_file('https://twitter.com/statuses/user_timeline/'.urlencode($username).'.atom?count='.$number);
	$html = "<ul class=\"tweets\">\n";
	for($i=0; $i<@count($xml->entry); $i++)
	{
		$content = @str_replace('<a href', '<a target="_blank" href', $xml->entry[$i]->content);
		$html.= '<li><span>'.$xml->entry[$i]->published.'</span>'.$content."</li>\n";
	}
	$html .="</ul>\n";
	return $html;
}

function getFlickr($args){
	if($args['sourceType']=='user')
		$source = 'source=user&amp;user='.$args['user'];
	elseif($args['sourceType']=='group')
		$source = 'source=group&amp;group='.$args['user'];
		
	if(empty($args['size']))
		$args['size'] = 's';
	if(empty($args['layout']))
		$args['layout'] = 'h';
	
	$style = '';
	if(!empty($args['width']))
		$style .= 'width:'.$args['width'].'; ';
	if(!empty($args['height']))
		$style .= 'height:'.$args['height'].'; ';
	
	return '<div id="flickr_badge_wrapper" class="flicker" style="'.$style.'"> 
	<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='.$args['count'].'&amp;display=latest&amp;size='.$args['size'].'&amp;layout='.$args['layout'].'&amp;'.$source.'"></script>
	</div>
	';
}
 
 function getNotFoundPage($message, $searchform){
 $sidebarPos = opt('sidebardefault', '');
 ?>
	<div id="wrapper">
	<div id="content" class="<?php echo ($sidebarPos!='None')?'content-with-sidebar':'content-full-width'; ?>">
		<?php if(!(is_home() || is_front_page())){ ?> <hr class="bar"/>	<?php } ?>
		<div id="left-col" class="<?php echo ($sidebarPos!='None')?'left-col-with-sidebar':'page-content'; ?>">
			<div class="sh_divider"></div>
			<?php echo $message; 
			if($searchform){?>
			<br /><br />
			<?php 
			get_search_form();
			} ?>
		</div>
	</div>
	<?php if($sidebarPos!='None') get_sidebar(); ?>
	</div>
<?php
}
 
add_filter('avatar_defaults','custom_gravatar');
function custom_gravatar($avatar_defaults) 
{
	$myavatar = get_template_directory_uri().'/images/default_avatar.jpg';
	$avatar_defaults[$myavatar] = 'Think Responsive Default Avatar'; 
	return $avatar_defaults;
}

if(!function_exists('fb_addgravatar')) 
{
	function fb_addgravatar( $avatar_defaults ) 
	{
		$myavatar = get_template_directory_uri().'/images/default_avatar.jpg';
		$avatar_defaults[$myavatar] = 'Think Responsive Default Avatar';
		return $avatar_defaults;
	}
	add_filter('avatar_defaults','fb_addgravatar');
}

function comment_callback($comments, $args, $depth ) {
	$GLOBALS['comment'] = $comments;
	switch($comments->comment_type)
	{
		case '':
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<div class="comment-wrapper">
				<div class="comment-avatar">
					<?php echo get_avatar($comments, 34); ?>
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="9px" height="9px"><polygon points="0,0 9,0 0,9" /></svg>
				</div>
				
					<div class="comment-author">
						<span class="author-link"><?php echo get_comment_author_link(); ?></span><br/>
						<span class="author-date"><?php echo get_comment_date(); ?></span> 
						<span class="author-time"><?php echo get_comment_time(); ?></span>
					</div> 
					<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
				
				<div class="clearfix"></div>
				<div class="comment-text">
					<?php comment_text(); ?>
				</div>
			</div>
  <?php
			break;
		case 'pingback'  :
		case 'trackback' :
  ?>
        <li class="post pingback">
          <p>
            <?php __('Pingback:', 'rb' ); ?>
            <?php comment_author_link(); ?>
            <?php edit_comment_link( __('Edit','rb'),''); ?>
          </p>
          <?php
			break;
	}
}

?>