<?php
add_shortcode('gallery', 'sh_gallery');
function sh_gallery($attr, $content=null){
	$prm = $attr;
	global $paged, $wpdb, $post, $sidebarPos;
	if(!isset($prm['id']))
		$cat = '';
	else
		$cat = $prm['id'];
		
	if(!isset($prm['usetimthumb']) || @$prm['usetimthumb']=='true')
		$useResizer = 'use';
	else
		$useResizer = $prm['usetimthumb'];
		
	$imageType = 'landscape';
	if(@isset($prm['type']))
		$imageType = $prm['type'];
	
	$count = 3;
	if(@isset($prm['count'])) $count = (int) $prm['count'];
	if($count>6) $count=6;
	if($count<3) $count=3;
		
	$textType = 'true';
	if(@isset($prm['text'])) $textType = $prm['text'];
	
	if($sidebarPos!='None'){
		$pageWidth = 700;
		$ulClass = 'galleryWithSidebar';
		$ulType = 'withSidebar';
	}else{
		$pageWidth = 940;
		$ulClass = 'galleryWithoutSidebar';
		$ulType = 'withoutSidebar';
	}
	$spaceH = 20;
	$columnW = (int) (($pageWidth-($spaceH*($count-1)))/$count);

	$imageW = (int) ($columnW);
	if($imageType=='landscape')
		$imageH = (int) ($imageW/1.5);
	if($imageType=='portrait')
		$imageH = (int) ($imageW*1.5);
	if($imageType=='square')
		$imageH = (int)($imageW);

	 
	$re = '';		
	$re .= '<ul class="galleryitems c'.$count.'columns_'.$ulType.' '.$ulClass.'">';
		
	$result = $wpdb->get_results("SELECT IMAGEID, TYPE, CONTENT, THUMB, CAPTION, DESCRIPTION, WIDTH, HEIGHT FROM {$wpdb->prefix}backgrounds WHERE GALLERYID in (".$cat.") ORDER BY SLIDERORDER");
	$i=0;
	foreach($result as $row){
		$i++;
		$re .= '<li class="galleryitem">';
		
		$thumb_src = '';
		if($row->TYPE=='image'){
			if(!empty($row->THUMB))
				$thumb_src = $row->THUMB;
			else
				$thumb_src = $row->CONTENT;
			
		}else
			$thumb_src = $row->THUMB;
		
		if($useResizer=='use')
				$thumbnail_url = get_template_directory_uri().'/includes/timthumb.php?src='.$thumb_src.'&amp;h='.$imageH.'&amp;w='.$imageW.'&amp;zc=1&amp;q=100';
			else
				$thumbnail_url = $thumb_src;
		
		if($row->TYPE=='image')
			$thumbnail_href = $row->CONTENT;
		elseif($row->TYPE=='vimeo')
			$thumbnail_href = 'http://vimeo.com/'.$row->CONTENT;
		elseif($row->TYPE=='youtube')
			$thumbnail_href = 'http://www.youtube.com/watch?v='.$row->CONTENT;
		elseif($row->TYPE=='selfhosted')
			$thumbnail_href =  $row->CONTENT;
		elseif($row->TYPE=='flash')
			$thumbnail_href =  $row->CONTENT.'?width='.$row->WIDTH.'&amp;height='.$row->HEIGHT;
		
		$modalClass = 'modal';
		if($row->TYPE=='vimeo' || $row->TYPE=='youtube' || $row->TYPE=='selfhosted' || $row->TYPE=='flash')
			$modalClass = 'modalVideo';
				

		$re .= '<div class="image_frame">
		<a class="modal" href="'.$thumbnail_href.'"  title="'.htmlentities(stripslashes($row->CAPTION), ENT_QUOTES, "UTF-8").'">
			<img src="'.$thumbnail_url.'" width="'.$imageW.'" title="'.htmlentities(stripslashes($row->CAPTION), ENT_QUOTES, "UTF-8").'" alt="'.htmlentities(stripslashes($row->DESCRIPTION), ENT_QUOTES, "UTF-8").'" />
		<div class="hoverWrapperBg"></div>
		<div class="hoverWrapper">';
		if($row->TYPE=='image')
			$re .= '<span class="hoverWrapperModal"></span>';
		else
			$re .= '<span class="hoverWrapperModal hoverWrapperVideo"></span>';
		$re .= '</div>
		</a>
		</div>';
		
		if($textType!='none'){
			if(!empty($row->CAPTION))
				$re .= '<h3>'.stripslashes($row->CAPTION).'</h3>';
		}						
		
		$re .= '</li>';
	}
	$re .= '</ul>
		<hr class="seperator" />
		<div class="clearfix"></div>';
	return $re;
}
?>