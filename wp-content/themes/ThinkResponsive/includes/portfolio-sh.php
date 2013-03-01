<?php

add_shortcode('portfolio', 'sh_portfolio');
function sh_portfolio($attr, $content=null)
{
	$prm = $attr;
	global $post, $paged, $more, $wpdb, $pageTitle, $sidebarPos;
	if(!isset($prm['category']))
		$cat = '';
	else
		$cat = $prm['category'];
		
	$type = 'pagination';
	if(@isset($prm['type'])) $type = $prm['type'];
	
	$imageType = 'landscape';
	
	$count = 3;
	if(@isset($prm['count'])) $count = (int) $prm['count'];
	
	if($count<3) $count =3;
	if($count>6) $count =6;
	
	$textType = 'true';
	if(@isset($prm['text'])) $textType = $prm['text'];
		
	$sidebarType = 'none';
	if(@isset($prm['sidebar'])) $sidebarType = $prm['sidebar'];
		

	$postperpage = 10;
	if(@isset($prm['postperpage']))	$postperpage = (int) $prm['postperpage'];

	if($sidebarPos!='None'){
		$ulClass = 'portfolioWithSidebar';
		$ulType = 'withSidebar';
		$pageWidth = 700;
	}else{
		$ulClass = 'portfolioWithoutSidebar';
		$ulType = 'withoutSidebar';
		$pageWidth = 940;
	}
	$spaceH = 20;
	$columnW = (int) (($pageWidth-($spaceH*($count-1)))/$count);
	$imageW = (int) ($columnW);
	
	
	$imageW = (int) ($columnW);
	if($imageType=='landscape')
		$imageH = (int) ($imageW/1.5);
	if($imageType=='portrait')
		$imageH = (int) ($imageW*1.5);
	if($imageType=='square')
		$imageH = (int)($imageW);
	
	
	

	if($postperpage<=0)
		$postperpage = 10;
	 
	$re = '';
	
	if(@!empty($prm['title']))
		$re .= '<h2 class="sh_portfolio_title">'.$prm['title'].'</h2>';

	if($type=='filter'){
		$catParam = '';
		if(!empty($cat))
			$catParam = " WHERE wterms.term_id in(".$cat.") ";
		
		$re .= '<ul class="portfolioFilter">';
			$cat_query = "SELECT wterms.name, wterms.term_id FROM $wpdb->terms wterms ".$catParam." ORDER BY wterms.name ASC";
			
			$catResults = $wpdb->get_results($cat_query);
			$re .= '<li data-value="all"><a href="javascript:void(0);" class="selected">'.__('ALL', 'rb').'</a></li>'."\n";
			foreach($catResults as $catRow)
				$re .= '<li data-value="'.$catRow->term_id.'"><a  href="javascript:void(0);">'.$catRow->name.'</a></li>'."\n";
		$re .= '</ul><div class="clearfix"></div>';
		$re .= '<hr class="bar"/>';
	}	
			$re .= '<ul class="portfolioitems c'.$count.'columns_'.$ulType.' '.$ulClass.'" data-col="'.$count.'" data-side="'.$ulType.'">';
			if($type=='pagination')
				$wp_res = new WP_Query('post_type=portfolio&posts_per_page='.$postperpage.'&cat='.$cat.'&paged='.$paged);
			else
				$wp_res = new WP_Query('post_type=portfolio&cat='.$cat.'&posts_per_page=-1');
			
			if($wp_res->have_posts()){
				$i=0;
				while($wp_res->have_posts()){
				$i++;
					$wp_res->the_post();
					
				
			$useResizer = get_post_meta($post->ID, "useResizer", true);
			$cropPos 	= get_post_meta($post->ID, "cropPos", true);
			$cropPos	= ($cropPos=='')?'c':$cropPos;
			
			
			$dataID = 'data-id="id-'.$post->ID.'"';
			$dataCalss='';
			if($type=='filter')
			{
				$catIDs = '';
				foreach((get_the_category($post->ID)) as $category)
						$catIDs .= 'cat-'.$category->cat_ID.' ';
				if(!empty($catIDs))
					$dataCalss .= ' data-type="'.$catIDs.'" ';
			}		
			
			$re .= '<li '.$dataID.' '.$dataCalss.' class="portfolioitem" >';			
			$thumbnail_src = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); 
			
			if($useResizer=='use')
				$thumbnail_url = get_template_directory_uri().'/includes/timthumb.php?src='.$thumbnail_src.'&amp;h='.$imageH.'&amp;w='.$imageW.'&amp;zc=1&amp;a='.$cropPos.'&amp;q=100';
			else
				$thumbnail_url = $thumbnail_src;
					
			$portfolioformat = strtolower( get_post_format(get_the_ID()) );
			$re .= '<div class="image_frame">
				<a href="javascript:void(0);"  title="'.get_the_title().'">
					<img src="'.$thumbnail_url.'" width="'.$imageW.'" alt="'.get_the_title().'" />';
			$re .= '<div class="hoverWrapperBg"></div>';
				$re .= '<div class="hoverWrapper">';
					if($portfolioformat=='video')
						$re .= '<span class="hoverWrapperModal hoverWrapperVideo"></span>';
					elseif($portfolioformat=='gallery')
						$re .= '<span class="hoverWrapperModal hoverWrapperGallery"></span>';
					else
						$re .= '<span class="hoverWrapperModal"></span>';
				$re .='</div>';
			$re .= '</a>';
			$re .= '</div>';
			if($textType!='none'){
				$re .= '<h3>'.get_the_title().'</h3>';
				if(count(get_the_category($post->ID))){
					$re .= '<div class="meta-row">';
					$catList = '';
					foreach((get_the_category($post->ID)) as $category){
						$catList .= '<a title="'.__('View all posts in ', 'rb').$category->cat_name.'" href="javascript:void(0);" onclick="setFilter(\''.$category->cat_ID.'\')" >'.$category->cat_name.'</a>, ';
					}
					$catList = substr($catList, 0, -2);
					$re .= $catList.'</div>';
				}
			}
				
			$re .= '</li>';
		}
	}
	$re .= '</ul>
		<hr class="seperator" />
		<div class="clearfix"></div>';

	if($type=='pagination'){
		if(function_exists('wp_pagenavi')){
			$re .= wp_pagenavi( array( 'query' => $wp_res, 'options' => array('return_string' => true) ));
			$re.='	<div class="divider" style="height:10px"></div>
			<div class="clearfix"></div>';
		}
	}
	wp_reset_postdata();	
	return $re;
}

?>