<?php
include('blog-sh.php');
include('portfolio-sh.php');
include('gallery-sh.php');

add_shortcode('inbox', 'sh_inbox');
function sh_inbox($attr, $content=null){
	return '<div class="sh_inBox">'.do_shortcode($content).'</div>';
}

add_shortcode('testimonials', 'sh_testimonials');
function sh_testimonials($attr, $content=null){
	$re = '<div class="sh_testimonials">
		<div class="tes_items">'.do_shortcode($content).'</div>
		<div class="tes_nav"></div>
		</div>';
	return $re;
}

add_shortcode('testimonial_item', 'sh_testimonial_item');
function sh_testimonial_item($attr, $content=null){
	$re = '';
	$re .= '<div class="sh_testimonial"><div class="tes_block">';
	$re .='<h5 class="tes_quote">'.$content.'</h5>';
	if(@!empty($attr['owner']))
		$re.='<h6 class="tes_owner">&mdash; '.$attr['owner'].'</h6>';
	$re .= '</div></div>';
	return $re;
}

add_shortcode('teaser', 'sh_teaser');
function sh_teaser($attr, $content=null){
	return '<div class="sh_teaser">'.do_shortcode($content).'</div>';
}

add_shortcode('readmore', 'sh_readmore');
function sh_readmore($attr, $content=null){
	$style='';
	if(!empty($attr['align']))
		$style = ' style="float:'.$attr['align'].'"';
	return '<a '.$style.' class="sh_post_more" href="'.$attr['url'].'">'.$content.'</a>';
}

add_shortcode('list_two', 'sh_list_two');
function sh_list_two($attr, $content=null){
	$re = '<div class="sh_list_two">'.do_shortcode($content).'</div>';
	return $re;
}

add_shortcode('list_item', 'sh_list_item');
function sh_list_item($attr, $content=null){
	$re = '<div class="sh_item_two_one">'.$attr['title'].'</div>';
	$re .= '<div class="sh_item_two_two">';
	
	if(!empty($attr['type']))
	{
		if($attr['type']=='url')
			$re.='<a href="'.$content.'" target="_blank">'.$content.'</a>';
		elseif($attr['type']=='email')
			$re.='<a href="mailto:'.$content.'" >'.$content.'</a>';
	}
	else
		$re .= $content;
	
	$re .= '</div>';
	return $re;
}

add_shortcode('flexslider', 'sh_flexslider');
function sh_flexslider($attr, $content=null){
	global $wpdb;
	$height = 0;
	$useResizer = true;
	$styleAdd = '';
	if(@!empty($attr['height']))
		$height = (int)$attr['height'];
	if(@!empty($attr['style']))
		$styleAdd = 'style="'.$attr['style'].'"';
	if($height>0){
		$heightAdd = '&amp;h='.$height;
		$heightAddDiv = 'style="height:'.$height.'px; overflow:hidden;"';
	}
	if(@$attr['resizer']=='false')
		$useResizer = false;
		
	$randomId = createRandomKey(6);
	$re = '';
	$result = $wpdb->get_results("SELECT IMAGEID, TYPE, CONTENT, THUMB, CAPTION, DESCRIPTION, WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE GALLERYID in (".$attr['id'].") ORDER BY SLIDERORDER");
	$re .= '<div class="flexslider" '.$styleAdd.'>
	    <ul class="slides">';
	foreach($result as $row){
		if($row->TYPE=='image'){
			$re .= '<li>';
			if($useResizer)
				$re .= '<img src="'.get_template_directory_uri().'/includes/timthumb.php?src='.$row->CONTENT.'&amp;w=940'.$heightAdd.'&amp;zc=1&amp;q=100" />';
			else
				$re .= '<img src="'.$row->CONTENT.'" />';
			if(!empty($row->CONTENT))
				$re .= '<p class="flex-caption">'.htmlentities(stripslashes($row->CAPTION), ENT_QUOTES, "UTF-8").'</p>';
			$re .= '</li>';
		}
		elseif($row->TYPE=='vimeo'){
			$re .=  '<li><div '.$heightAddDiv.'>';
			if($height==0)
				$re .= '<iframe src="http://player.vimeo.com/video/'.$row->CONTENT.'?title=0&amp;byline=0&amp;portrait=0&amp;color=7d7d7d" width="'.$row->WIDTH.'" height="'.$row->HEIGHT.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			else
				$re .= '<iframe src="http://player.vimeo.com/video/'.$row->CONTENT.'?title=0&amp;byline=0&amp;portrait=0&amp;color=7d7d7d" width="100%" height="100%" frameborder="0" class="noVideoFit" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			$re .= '</div></li>';
		}
		elseif($row->TYPE=='youtube'){
			$re .=  '<li><div '.$heightAddDiv.'>';
			if($height==0)
				$re .= '<iframe width="'.$row->WIDTH.'" height="'.$row->HEIGHT.'" src="http://www.youtube.com/embed/'.$row->CONTENT.'?wmode=transparent&amp;rel=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>';
			else
				$re .= '<iframe width="100%" height="100%" src="http://www.youtube.com/embed/'.$row->CONTENT.'?wmode=transparent&amp;rel=0" frameborder="0" class="noVideoFit" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>';
			$re .= '</div></li>';
		}elseif($row->TYPE=='selfhosted')
			$re .= '<li>'.stripslashes($row->CONTENT).'</li>';
	}
	$re .= '</ul>
		</div>';
	return $re;
}

add_shortcode('divider', 'sh_divider');
function sh_divider($attr, $content=null){
	$style = '';
	if(@!empty($attr['style']))
		$style = 'style="'.$attr['style'].'"';
	elseif(@!empty($attr['height']))
		$style = 'style="height:'.$attr['height'].'px"';
	return '<div class="sh_divider" '.$style.'></div>';
}

add_shortcode('form', 'sh_form');
function sh_form($attr, $content=null)
{
	$class='form_'.createRandomKey(5);
	$re ='<div class="'.$class.' dform"><form>'.do_shortcode($content);
	
	if(!empty($attr['secure']))
	{
		$r1 = rand(0,9);
		$r2 = rand(0,9);
		$re.='<p>
				<input type="hidden" name="s1" value="'.$r1.'" /> 
				<input type="hidden" name="s2" value="'.$r2.'" /> 
				<label for="sec">'.$r1.'+'.$r2.'=</label></p><div class="dFormInput" style="width:50px"><input  type="text" id="s" name="s" class="required" value="" /></div>';
	}
	
	$re .= '<p><label for="submit">&nbsp;</label></p><div class="form_input">';
	$re .= '<a class="sh_post_more" href="javascript:void(0);" onclick="javascript:$(\'.'.$class.' form\').submit();">'. __('Submit','rb').'</a>';
	$re .= '</div>
			</form>
			</div>';
	$re .= '<script type="text/javascript" src="'.get_template_directory_uri().'/js/jquery.validate.min.js"></script>';
	$re .= '<script>
	jQuery(document).ready(function($){
		$(".'.$class.' form").validate({
		  errorPlacement: function(error, element) {
			 error.appendTo(element.parent());
		   }
		 });
		$(".'.$class.' form").submit(function(){
			if($(".'.$class.' form").valid())
			{
				var formdata = $(".'.$class.' form").serialize();
				$(".'.$class.' form").slideUp();
				$(".'.$class.'").append("<div class=\"form_message\">'.__('Please wait...','rb').'</div>").find("div.form_message").slideDown("slow");
				$.post("'.get_template_directory_uri().'/includes/form-sender.php'.'", formdata, function(data){
					data = $.parseJSON(data); 
					if(data.status=="OK")
					{
						$(".'.$class.' .form_message").html("'.__('Your message has been sent successfuly.', 'rb').'");
					}
					else
					{
						alert(data.ERR);
						$(".'.$class.' form").slideDown();
						$(".'.$class.' .form_message").remove();
					}
				});
			}else
				alert("'.__('Please fill all required fields','rb').'");
			return false;
		});
	});
	</script>';
	
	return $re;
}

add_shortcode('form_item', 'sh_form_item');
function sh_form_item($attr, $content=null)
{
	$type='text';
	$re = '';
	$re.= '<p><label for="'.$attr['name'].'" >'.$attr['title'].'</label>';
	$re.='<input type="hidden" id="'.$attr['name'].'_title" name="title[]" value="'.$attr['title'].'" />';
	$re.='<input type="hidden" id="'.$attr['name'].'_key" name="key[]" value="'.$attr['name'].'" />';
	if(!empty($attr['type']))
		$type = $attr['type'];
	
	$re .='</p><div class="dFormInput">';
	$class = '';
	
	if(!empty($attr['validate']))
		$class = $attr['validate'];
	
	if($type=='text')
		$re.='<input class="'.$class.'" id="'.$attr['name'].'" type="text" name="'.$attr['name'].'" />';
	elseif($type=='textarea')
		$re.='<textarea class="'.$class.'" id="'.$attr['name'].'" name="'.$attr['name'].'" ></textarea>';
	elseif($type=='select')
	{
		$re.='<select class="'.$class.'" id="'.$attr['name'].'" name="'.$attr['name'].'" >';
		$vals = explode(',',$attr['values']);
		foreach($vals as $val)
			$re.='<option>'.trim($val).'</option>';
		$re.='</select>';
	}
	$re .='</div>';
	
	return $re;
}

add_shortcode('flickr', 'sh_flickr');
function sh_flickr($attr, $content=null)
{
	$re = '';
	$num = 5;
	$title = '';
	$attr['sourceType'] = 'user';
	if(!empty($attr['sourcetype']))
		$attr['sourceType'] = $attr['sourcetype'];
	if(!empty($attr['count']))
		$attr['count'] = (int)$attr['count'];
		
	if(!empty($attr['title']))
		$title = $attr['title'];
	if(!empty($title))
		$re .= '<h3>'.$title.'</h3>';
	$re .= getFlickr($attr);
	return $re;
}

add_shortcode('tweets', 'sh_tweets');
function sh_tweets($attr, $content=null)
{
	$re = '';
	$num = 5;
	$title = '';
	if(!empty($attr['num']))
		$num = (int)$attr['num'];
	if(!empty($attr['title']))
		$title = $attr['title'];
	if(!empty($title))
		$re .= '<h3>'.$title.'</h3>';
	$re .= getTweets($attr['user'], $num);
	return $re;
}


add_shortcode('light_box','sh_light_box');
function sh_light_box($attr, $content=null)
{
	$w = '200';
	$h = '200';
	$width = '';
	if(!empty($attr['width']))
		$width = ' style="width:'.$attr['width'].'px" ';
	if(!empty($attr['img_width']))
		$w = $attr['img_width'];
	if(!empty($attr['img_height']))
		$h = $attr['img_height'];
		
	$re = '';
	preg_match_all('/<img[^>]+>/i',$content, $imgs);
	foreach($imgs[0] as $img)
	{
		preg_match_all('#(?: ([a-z^=]+)=.*"([^"]*)")#Usi',$img, $patterns);
		$imgsrc = '';
		$imghtml = '<img ';
		for($i=0; $i<sizeof($patterns[1]); $i++)
		{
			if($patterns[1][$i]=='src')
			{
				$imghtml .= $patterns[1][$i].'="'.get_template_directory_uri().'/includes/timthumb.php?src='.$patterns[2][$i].'&amp;h='.$h.'&amp;w='.$w.'&amp;zc=1&amp;q=80" ';
				$imgsrc = $patterns[2][$i];
			}
			else if($patterns[1][$i]=='width')
				$imghtml .= $patterns[1][$i].'="'.$w.'" ';
			else if($patterns[1][$i]=='height')
				$imghtml .= $patterns[1][$i].'="'.$h.'" ';
			else
				$imghtml .= $patterns[1][$i].'="'.$patterns[2][$i].'" ';
		}
		$imghtml .=' />';				
				
		$re .= '<div class="image_frame" style="float:left; margin:10px 20px 10px 0">
		<a href="'.$imgsrc.'" title="">'.$imghtml.'
			<div class="hoverWrapperBg"></div>
			<div class="hoverWrapper">
				<span class="hoverWrapperModal"></span>
			</div>
		</a>
		</div>';
	}	
	$re = '<div class="sh_lightbox" '.$width.' >'.$re.'</div>';
	return $re;
}

add_shortcode('price_table','sh_price_table');
function sh_price_table($attr, $content=null)
{
	$attrs = array('bgcolor', 'headerbgcolor', 'headerfontcolor', 'bordercolor', 'fontcolor', 'width');
	$bgcolor = '#F9FCFE';
	$headerbgcolor = '#F4F9FE';
	$headerfontcolor = '#66A3D3';
	$bordercolor = '#E5EFF8';
	$fontcolor = '#678197';
	$width = '100%';
	foreach($attrs as $att)
	{
		if(!empty($attr[$att]))
		{
			${$att}=$attr[$att];
		}
	}
	
	$class='price_'.createRandomKey(5);
	$re = '<style type="text/css">
			.'.$class.' table{
			width: '.$width.';
			border-spacing: 0;
			border-collapse: collapse;
			border-right: 1px solid '.$bordercolor.';
		}

		.'.$class.' table tbody td{
			text-align:center;
			vertical-align:top;
			padding:5px;
			background-color: '.$bgcolor.';
			color: '.$fontcolor.';
			border-bottom: 1px solid '.$bordercolor.';
			border-left: 1px solid '.$bordercolor.';
		}
		.'.$class.' table tbody th{
			text-align:left;
			vertical-align:middle;
			padding:5px;
			background-color: '.$headerbgcolor.';
			color:'.$headerfontcolor.';
			border-bottom: 1px solid '.$bordercolor.';
			border-left: 1px solid '.$bordercolor.';
		}
		
		.'.$class.' table thead th, .'.$class.' table tfoot th{
			text-align:center;
			vertical-align:top;
			padding:5px;
			background-color: '.$headerbgcolor.';
			color:'.$headerfontcolor.';
			border-bottom: 1px solid '.$bordercolor.';
			border-left: 1px solid '.$bordercolor.';
		}
		 .'.$class.' table thead th > *{
			color:'.$headerfontcolor.';
		 }
		.'.$class.' table thead td{
			border-bottom: 1px solid '.$bordercolor.';
		}
		.'.$class.' table thead th{
			border-top: 1px solid '.$bordercolor.';
			font-size:18px;
		}
	</style>';
	$re .= '<div class="'.$class.'">'.do_shortcode($content).'</div>';
	return $re;
}

add_shortcode('accordion','sh_accordion');
function sh_accordion($attr, $content=null)
{
	$style='';
	if(!empty($attr['width']))
		$style = ' style="width:'.$attr['width'].'px" ';
	$re = '<div '.$style.' class="sh_accordion">'.do_shortcode($content).'</div>';
	return $re;
}

add_shortcode('acc_item','sh_acc_item');
function sh_acc_item($attr, $content=null)
{
	$re = '<div class="sh_acc_item_title"><a href="javascript:void(0);"><span class="icon"></span><span class="text">'.$attr['title'].'</span></a>
				<div class="sh_acc_item">'.do_shortcode($content).'<div class="clearfix"></div></div>
			</div>';
	return $re;
}

add_shortcode('tabs','sh_tabs');
function sh_tabs($attr, $content=null)
{
	$style='';
	if(!empty($attr['width']))
		$style = ' style="width:'.$attr['width'].'px" ';
	$re = '<div '.$style.' class="sh_tabs">
		    <ul class="sh_tabs_menu"></ul>
			<div class="sh_tab_wrapper">
				'.do_shortcode($content).'
			</div>
			</div>';
	return $re;
}

add_shortcode('tab_item','sh_tab_item');
function sh_tab_item($attr, $content=null)
{
	$uid = createRandomKey(5);
	$re = '<div id="tab'.$uid.'" class="sh_tab_item"><a href="javascript:void(0);" class="sh_tab_title" rel="tab'.$uid.'">'.$attr['title'].'</a>'.do_shortcode($content).'<div class="clearfix"></div></div>';
	return $re;
}

add_shortcode('map','sh_map');
function sh_map($attr, $content=null) //latlng -34.397, 150.644
{
$content = trim($content); 
//defaults
$width = '500px';
$height = '500px;';
$zoom = 11; // 0,7 to 18
$sensor = 'true'; 
$controls = 'false';
$type = 'HYBRID '; // ROADMAP | SATELLITE | TERRAIN 
$marker = '';
$marker_icon = '';
if(!empty($attr['zoom']))
	$zoom = $attr['zoom'];
if(!empty($attr['sensor']))
	$sensor = $attr['sensor'];
if(!empty($attr['nocontrols']))
	$controls = $attr['nocontrols'];
if(!empty($attr['type']))
	$type = $attr['type'];
if(!empty($attr['width']))
	$width = $attr['width'];
if(!empty($attr['height']))
	$height = $attr['height'];

$mapID = createRandomKey(5); 
if(!empty($attr['marker']) || !empty($content))
{
	if(!empty($attr['marker_icon']))
		$marker_icon = ', icon:\''.$attr['marker_icon'].'\'';
		
	$marker = 'var marker'.$mapID.' = new google.maps.Marker({map: mapObj'.$mapID.', 
		position: mapObj'.$mapID.'.getCenter()
		'.$marker_icon.'
		});';
		
	if(!empty($content))
	{
		
		$marker .= '
		var infowindow'.$mapID.' = new google.maps.InfoWindow();
		infowindow'.$mapID.'.setContent(\''.$content.'\');
		google.maps.event.addListener(marker'.$mapID.', \'click\', function() {
				infowindow'.$mapID.'.open(mapObj'.$mapID.',  marker'.$mapID.');
		});';
	}
	
}
$re = '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor='.$sensor.'">
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
	var latlng = new google.maps.LatLng('.$attr['lat'].', '.$attr['lng'].');
	var myOptions = {
	  zoom: '.$zoom.',
	  disableDefaultUI: '.$controls.',
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.'.$type.'
	};
	var mapObj'.$mapID.' = new google.maps.Map(document.getElementById("map'.$mapID.'"), myOptions);
	'.$marker.'
});
</script>
<div id="map'.$mapID.'" style="width:'.$width.'; height:'.$height.'"></div>
';

return $re;
}

function createRandomKey($amount){
	$keyset  = "abcdefghijklmABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$randkey = "";
	for ($i=0; $i<$amount; $i++)
		$randkey .= substr($keyset, rand(0, strlen($keyset)-1), 1);
	return $randkey;	
}

function sh_get_recent_posts($attr, $content=null)
{
	$num = '4'; // default count
	$cat = ''; // if empty show all
	$order = 'DESC'; // ASC or DESC
	$orderby = 'date'; //title or date
	$title = ''; 
	$useimage = true;
	$useheader = true;
	$usetext = true;
	$imgwidth = '220';
	$imgheight = '165';
	$innerwidth = '';
	$textsize=170;
	$position = 'horizontal';
	$innertext = false;
	$minheight = 0;
	$type = 'post';

	$attrs = array('num', 'cat', 'order', 'orderby', 'title', 'imgwidth', 'imgheight', 'useimage', 'useheader', 'usetext', 'innerwidth', 'textsize', 'position','innertext', 'minheight', 'type');
	foreach($attrs as $att)
	{
		if(!empty($attr[$att]))
		{
			if($attr[$att]=='true')
				$value = true;
			elseif($attr[$att]=='false')
				$value = false;
			else
				$value = $attr[$att];
			${$att}=$value;
		}
	}
	
	$positionparams  = '';
	$extraStyle = '';
	if($position=='horizontal')
		$positionparams = 'border:none; padding:0 0 25px 0; margin:0 20px 20px 0';
	else
		$extraStyle = ' style="margin:0 0 20px 0" ';
	
	$innerwidthparams = '';
	if(!empty($innerwidth))
		$innerwidthparams = 'width:'.$innerwidth;
		
	if($minheight>0)
		$positionparams .= '; min-height:'.$minheight.'px; ';
	
	$categories='';
	if(!empty($cat))
	$categories='&cat='.$cat;
	
	
	
	$re = '';
	$q ='post_type='.$type.'&posts_per_page=-1'.$categories.'&post_status=publish&showposts='.$num.'&orderby='.$orderby.'&order='.$order;
	$wp_query = new WP_Query($q);
	if(!empty($title))
		$re .= '<h3 style="margin-top:0">'.$title.'</h3><div class="sh_hr"></div>';
	if($wp_query->have_posts())
	{
		$re.='<ul class="sh_post">';
		while($wp_query->have_posts())
		{
			$re .= '<li style="'.$innerwidthparams.'; '.$positionparams.'">';
			$wp_query->the_post();
	
			if(has_post_thumbnail())
			{

				$thumbnail_src = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
				$re .= '<div class="sh_lastpost_container">';
				$re .= '<div class="image_frame sh_lastpost_imagelink" '.$extraStyle.'>
					<a href="'.get_permalink().'" title="'.get_the_title().'" >';
				$re .= '<img width="'.$imgwidth.'px" src="'.get_template_directory_uri().'/includes/timthumb.php?src='.$thumbnail_src.'&amp;h='.$imgheight.'&amp;w='.$imgwidth.'&amp;zc=1&amp;q=100" alt="'.get_the_title().'" />';
								
				$re .= '
					<div class="hoverWrapperBg"></div>
					<div class="hoverWrapper">
						<span class="hoverWrapperLink"></span>
					</div>
				</a>
				</div>
				</div>
				';
			}
	
			if($useheader && !$innertext)
			{
				$re .= '<div class="sh_divider"></div>';
				$re .= '<a class="sh_lastpost_title" href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'" rel="bookmark">';
				$re .= get_the_title();
				$re .= '</a>';
				
				if(count(get_the_category())){
					$re.= '<div class="sh_lastpost_categories">'.get_the_category_list( ', ' ).'</div>';
				}
			}
			$re .= '<hr class="mborder" />';
			if($usetext)
			{
				if($textsize==0)
					$re .= '<p class="sh_lastpost_content">'.get_the_content('').'</p>';
				else
					$re .= '<p class="sh_lastpost_content">'.substr(strip_tags(preg_replace('|[[\/\!]*?[^\[\]]*?]|si', '', get_the_content())), 0, ((int)$textsize)).'...</p>';
				$re .= '<hr class="mborder" />';	
				
				$re .= '<div class="sh_lastpost_bottom">';
				$re .= get_the_time('Y M d');
				$tags_list = get_the_tag_list('',', ');
				if($tags_list)	$re .= ',&nbsp;&nbsp;'.$tags_list;
				$re .= '</div>';
			} 
			$re .='<div class="clearfix" ></div>';
			$re .=' </li>';
		}
		$re .= '</ul>';
		$re .='<div class="clearfix"></div>';
	}
	return $re;
}
add_shortcode('get_recent_posts','sh_get_recent_posts');

add_shortcode('carousel','sh_carousel');
function sh_carousel($attr, $content=null)
{
	$outerwidth = '100%';
	$outerheight = 'null';
	$innerwidth = 'null';
	$innerheight = 'null';
	$fx = 'scroll';
	$direction = 'left';
	$duration = '500';
	$scrollitems = 'null';
	$pagination = true;
	$auto = true;
	$usepager = false;
	$useprevnext = false;
	$title = '';
	$padding='';
	
	
	$attrs = array('outerwidth', 'outerheight', 'usepager', 'useprevnext', 'fx', 'direction', 'duration', 'scrollitems', 'pagination', 'auto', 'title', 'padding');
	foreach($attrs as $att)
	{
		if(!empty($attr[$att]))
		{
			if($attr[$att]=='true')
				$value = true;
			elseif($attr[$att]=='false')
				$value = false;
			else
				$value = $attr[$att];
			${$att}=$value;
		}
	}
	
	if(!empty($padding))
		$padding = 'padding:'.$padding;
	
	$rand = createRandomKey(5);
	$re = '';
	
	if(!empty($title) || $useprevnext || $usepager)
	{
		$re .= '<div class="carouselHeader" style="width:'.$outerwidth.'px;" >';
		if(!empty($title))
			$re .= '<h3>'.$title.'</h3>';
		if($useprevnext)
			$re .= '<a class="nextcarousel" id="'.$rand.'_next" href="#"></a>';
		if($usepager)
			$re .= '<div id="pager'.$rand.'" class="pagercarousel" '.((!$useprevnext)?'style="margin-right:8px;"':'').'></div>';
		if($useprevnext)
			$re .= '<a class="prevcarousel" id="'.$rand.'_prev" href="#"></a>';
		
		$re .='<div class="clearfix"></div>'; 
		$re .= '</div>';
		$re .='<div class="clearfix"></div>'; 
	}
	
	$marginLeft = '';	
	
	$re.='<div class="list_carousel" id="'.$rand.'" style="position:relative; width:'.$outerwidth.'px; height:'.$outerheight.'px; '.$marginLeft.'; '.$padding.'" >'; 
	$re.= do_shortcode($content);
	
	$re .='<div class="clearfix"></div>';

	$re .= '</div>';
	$re .='<div class="clearfix"></div>'; 
	
	$re .= '<script>
	$(window).load(function(){
	$("#'.$rand.'").children(":first-child").carouFredSel({
				scroll:{
					items:'.$scrollitems.',
					pauseOnHover: true,
					fx: "'.$fx.'",
					easing: "swing",
					duration:'.$duration.'
				},
				auto: '.(($auto)?'true':'false').',
				pagination: "#pager'.$rand.'",
				direction: "'.$direction.'",
				width: "'.$outerwidth.'",
				prev : {   
					button  : "#'.$rand.'_prev",
					key     : "left"
				},
				next : {
					button  : "#'.$rand.'_next",
					key     : "right"
				}
			});
	});
	</script>';
	return $re;
}


function sh_toggle($attr, $content=null){
	$style='';
	if(!empty($attr['width']))
		$style = ' style="width:'.$attr['width'].'px"';
	return '<div '.$style.' class="sh_toggle"><div class="sh_toggle_text"><a href="javascript:void(0);">'.$attr['title'].'</a></div><div class="sh_toggle_content">'.do_shortcode($content).'<div class="clearfix"></div></div></div>';
}
add_shortcode('toggle','sh_toggle');

function sh_hr($attr, $content=null){
	return '<div class="sh_hr"></div>';
}
add_shortcode('hr','sh_hr');

function sh_seperator($attr, $content=null){
	$con = '';
	$sepClass = 'sh_seperator';
	if(!empty($attr['title']))
	{
		$style='';
		if(!empty($attr['titlebg']))
			$style='background:'.$attr['titlebg'];
		$con = '<h4 style="'.$style.'">'.$attr['title'].'</h3>';
		$sepClass = 'sh_seperator_header';
	}
	return '<div class="'.$sepClass.'">'.$con.'</div>';
}
add_shortcode('seperator','sh_seperator'); 

function sh_half_seperator($attr, $content=null){
	return '<hr class="mborder" style="">';
}
add_shortcode('half_seperator','sh_half_seperator'); 

function sh_list($attr, $content=null){
	$icon = '';
	if(!empty($attr['icon']))
	{
		$icon = ' style="background:url(\''.get_template_directory_uri().'/icons/'.$attr['icon'].'.png\') no-repeat scroll left 0px transparent;"';
		$content = str_replace('<li>', '<li '.$icon.'>', $content);
	}
	return '<ul class="sh_list" >'.do_shortcode($content).'</ul>';
}
add_shortcode('list','sh_list'); 


function sh_dropcap($attr, $content=null){
	return '<div class="dropcap">'.do_shortcode($content).'</div>';
}
add_shortcode('dropcap','sh_dropcap'); 

function sh_dropcapcircle($attr, $content=null){
	return '<div class="dropcapcircle">'.do_shortcode($content).'</div>';
}
add_shortcode('dropcapcircle','sh_dropcapcircle'); 

function sh_quotes_one($attr, $content=null){
	return '<div class="quotes-one">'.do_shortcode($content).'</div>';
}
add_shortcode('quotes_one','sh_quotes_one'); 

function sh_quotes_two($attr, $content=null){
	$style = "";
	$addClass = "";
	if(@!empty($attr['align']))
		$addClass = $attr['align'];
	if(@!empty($attr['style']))
		$style = 'style='.$attr['style'];
	return '<div class="quotes-two '.$addClass.'" '.$style.'>'.do_shortcode($content).'</div>';
}
add_shortcode('quotes_two','sh_quotes_two'); 


function sh_quotes_writer($attr, $content=null){
	return '<div class="quotes-writer">'.do_shortcode($content).'</div>';
}
add_shortcode('quotes_writer','sh_quotes_writer'); 

add_shortcode('highlight', 'sh_highlight');
function sh_highlight($attr, $content=null){
	return '<span class="highlight">'.$content.'</span>';
}

add_shortcode('video ', 'sh_video');
function sh_video($attr, $content=null){
	
	$sourceStr = getSource( $attr['url'], $attr['width'], $attr['height']);
	
	$imgW = (int) $attr['width'];
	$imgH = (int) $attr['height'];
	return $sourceStr;		
}
function sh_tip($attr, $content=null){
	return '<a href="#" class="tip" rel="'.$attr['text'].'">'.do_shortcode($content).'</a>';
}
add_shortcode('tip','sh_tip'); 
 
function sh_code($attr, $content = null){
	return '<pre>'.htmlspecialchars($content).'</pre>';
}
add_shortcode('code', 'sh_code');

function sh_message($attr, $content = null)
{
	if($attr['type']=='error'){
		$textcolor = '#ffffff';
		$icon = 'errorbox';
		$body='#ff0000';
	}
	elseif($attr['type']=='download'){
		$textcolor = '#ffffff';
		$icon = 'downloadbox';
		$body='#00C100';
	}
	elseif($attr['type']=='warning'){
		$textcolor = '#ffffff';
		$icon = 'warningbox';
		$body='#FFCC00';
	}
	else{ // info
		$textcolor = '#ffffff';
		$icon = 'infobox';
		$body='#3AC8F7';
	}
	$iconattr = '';
	if(empty($attr['noicon']))
		$iconattr = ' icon="'.$icon.'"';
	$box = '[box '.$iconattr.' textcolor="'.$textcolor.'" bgcolor="'.$body.'"]'.do_shortcode($content).'[/box]';
	return do_shortcode($box);
}
add_shortcode('message','sh_message');

function sh_box($attr, $content = null)
{
	$style='padding:20px; margin:10px 0; ';
	$style_in ='';
	if(!empty($attr['width']))
		$style .= 'width:'.$attr['width'].'; ';
	else
		$style .= '';
		
	if(!empty($attr['height']))
		$style .= 'height:'.$attr['height'].'; ';
	else
		$style .= '';
	
	if(!empty($attr['align']))
	{
		if($attr['align']=='center')
			$style.='margin:0 auto 0 auto; ';
		elseif($attr['align']=='right')
			$style.='margin:10px 0 10px auto; ';
	}
	
	if(!empty($attr['textcolor']))
	{
		$style_in.='color:'.$attr['textcolor'].'; ';
	}else{
		$style_in.='color:#'.opt('colorFont',"").'; ';
	}
	
	if(empty($attr['border']))
	{
		if(!empty($attr['bordercolor']))
		{
			$style.='border:1px solid '.$attr['bordercolor'].'; ';
		}
	}else{
		// advanced usage
		$style.=$attr['border'].'; ';
	}
	
	if(empty($attr['background']))
	{
		if(!empty($attr['bgcolor']))
		{
			$style.='background-color:'.$attr['bgcolor'].'; ';
		}
	}else{
		// advanced usage
		$style.='background:'.$attr['background'].'; ';
	}
	
	$boxinsideClass = 'boxinside';
	if(!empty($attr['icon']))
	{
		$style_in .= 'padding-left:55px; ';
		$style_in .= 'background:url(\''.get_template_directory_uri().'/icons/'.$attr['icon'].'.png\') no-repeat left top; ';
	}else{
		$boxinsideClass = 'boxinsideNoicon';
	}
	
	
	return '<div  class="box" style="'.$style.'"><div class="'.$boxinsideClass.'" style="'.$style_in.'">'.do_shortcode($content).'<div class="clearfix"></div></div></div>';
}
add_shortcode('box','sh_box');

/* Columns Codes **/
function sh_1of1($attr, $content = null){
	return '<div class="sh_1of1 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('1of1', 'sh_1of1');

function sh_1of2($attr, $content = null){
	return '<div class="sh_1of2">'.do_shortcode($content).'</div>';
}
add_shortcode('1of2', 'sh_1of2');

function sh_1of2_end($attr, $content = null){
	return '<div class="sh_1of2 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('1of2_end', 'sh_1of2_end');

function sh_1of3($attr, $content = null){
	return '<div class="sh_1of3">'.do_shortcode($content).'</div>';
}
add_shortcode('1of3', 'sh_1of3');

function sh_1of3_end($attr, $content = null){
	return '<div class="sh_1of3 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('1of3_end', 'sh_1of3_end');

function sh_2of3($attr, $content = null){
	return '<div class="sh_2of3">'.do_shortcode($content).'</div>';
}
add_shortcode('2of3', 'sh_2of3');

function sh_2of3_end($attr, $content = null){
	return '<div class="sh_2of3 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('2of3_end', 'sh_2of3_end');

function sh_1of4($attr, $content = null){
	return '<div class="sh_1of4">'.do_shortcode($content).'</div>';
}
add_shortcode('1of4', 'sh_1of4');

function sh_1of4_end($attr, $content = null){
	return '<div class="sh_1of4 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('1of4_end', 'sh_1of4_end');

function sh_2of4($attr, $content = null){
	return '<div class="sh_2of4">'.do_shortcode($content).'</div>';
}
add_shortcode('2of4', 'sh_2of4');

function sh_2of4_end($attr, $content = null){
	return '<div class="sh_2of4 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('2of4_end', 'sh_2of4_end');

function sh_3of4($attr, $content = null){
	return '<div class="sh_3of4">'.do_shortcode($content).'</div>';
}
add_shortcode('3of4', 'sh_3of4');

function sh_3of4_end($attr, $content = null){
	return '<div class="sh_3of4 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('3of4_end', 'sh_3of4_end');

function sh_1of5($attr, $content = null){
	return '<div class="sh_1of5">'.do_shortcode($content).'</div>';
}
add_shortcode('1of5', 'sh_1of5');

function sh_1of5_end($attr, $content = null){
	return '<div class="sh_1of5 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('1of5_end', 'sh_1of5_end');

function sh_2of5($attr, $content = null){
	return '<div class="sh_2of5">'.do_shortcode($content).'</div>';
}
add_shortcode('2of5', 'sh_2of5');

function sh_2of5_end($attr, $content = null){
	return '<div class="sh_2of5 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('2of5_end', 'sh_2of5_end');

function sh_3of5($attr, $content = null){
	return '<div class="sh_3of5">'.do_shortcode($content).'</div>';
}
add_shortcode('3of5', 'sh_3of5');

function sh_3of5_end($attr, $content = null){
	return '<div class="sh_3of5 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('3of5_end', 'sh_3of5_end');

function sh_4of5($attr, $content = null){
	return '<div class="sh_4of5">'.do_shortcode($content).'</div>';
}
add_shortcode('4of5', 'sh_4of5');

function sh_4of5_end($attr, $content = null){
	return '<div class="sh_4of5 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('4of5_end', 'sh_4of5_end');

function sh_1of6($attr, $content = null){
	return '<div class="sh_1of6">'.do_shortcode($content).'</div>';
}
add_shortcode('1of6', 'sh_1of6');

function sh_1of6_end($attr, $content = null){
	return '<div class="sh_1of6 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('1of6_end', 'sh_1of6_end');

function sh_2of6($attr, $content = null){
	return '<div class="sh_2of6">'.do_shortcode($content).'</div>';
}
add_shortcode('2of6', 'sh_2of6');

function sh_2of6_end($attr, $content = null){
	return '<div class="sh_2of6 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('2of6_end', 'sh_2of6_end');

function sh_3of6($attr, $content = null){
	return '<div class="sh_3of6">'.do_shortcode($content).'</div>';
}
add_shortcode('3of6', 'sh_3of6');

function sh_3of6_end($attr, $content = null){
	return '<div class="sh_3of6 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('3of6_end', 'sh_3of6_end');

function sh_4of6($attr, $content = null){
	return '<div class="sh_4of6">'.do_shortcode($content).'</div>';
}
add_shortcode('4of6', 'sh_4of6');

function sh_4of6_end($attr, $content = null){
	return '<div class="sh_4of6 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('4of6_end', 'sh_4of6_end');

function sh_5of6($attr, $content = null){
	return '<div class="sh_5of6">'.do_shortcode($content).'</div>';
}
add_shortcode('5of6', 'sh_5of6');

function sh_5of6_end($attr, $content = null){
	return '<div class="sh_5of6 column_end">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('5of6_end', 'sh_5of6_end');

function sh_clear($attr, $content = null){
	return '<div class="clearfix"></div>';
}
add_shortcode('clear', 'sh_clear');
?>