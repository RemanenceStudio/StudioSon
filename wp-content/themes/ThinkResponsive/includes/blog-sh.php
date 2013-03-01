<?php
add_shortcode('blog', 'sh_blog');
function sh_blog($attr, $content=null){
	global $paged, $wpdb, $more, $blogparams, $pageTitle, $sidebarPos;
	$blogparams = $attr;
	$cats = '';
	$postperpage = 10;
	$pagination = 'pager';
	$metaformat = 'posted, comments, tag, category, share';
	if(!empty($blogparams['postperpage']))
		$postperpage  = $blogparams['postperpage'];
	if(!empty($blogparams['cats']))
		$cats  = $blogparams['cats'];
	if(!empty($blogparams['metaformat']))
		$metaformat  = $blogparams['metaformat'];
	if(!empty($blogparams['pagination']))
		$pagination  = $blogparams['pagination'];
	
	$re = '';
	
	wp_reset_postdata();
	$the_query_arr = 'post_type=post&posts_per_page='.$postperpage.'&cat='.$cats.'&paged='.$paged;
	$the_query = new WP_Query($the_query_arr);

	while($the_query->have_posts()){
		$the_query->the_post();
		$blogformat = strtolower( get_post_format(get_the_ID()) );
		if($blogformat == 'standart' || $blogformat == '') 	$blogformat = 'standart';
		
		$blogClass = '';
		$blogClassArr = get_post_class(array('blogitem'), get_the_ID());
		foreach($blogClassArr as $blogClassArrItem)
			$blogClass.=$blogClassArrItem.' ';
		$re .= '<article id="post-'.get_the_ID().'" class="'.$blogClass.'">';  // Begin blog item wrapper
		
		//$re .= '<div class="blogcontent" >'; // Begin blog content
		//$re .= '<div class="blogdatemeta">'; // Begin blog meta
		//$re .= get_blog_meta(get_the_ID(), $metaformat); 		
		//$re .= '</div>'; // End Blog Meta
		//$re .= '</div>'; // End Blog Content
		
		$re .= '<div class="blogimage">'; // Begin Blog Image
		
		$re .= get_blog_media(get_the_ID(), 'list');
		
		$more=0;
		$re .= '<div class="blogmeta" >'; // Begin blog meta
		$re .= get_blog_meta(get_the_ID(), $metaformat); 
		$re .= '</div>'; // End Blog Meta	 

		$re .= '<div class="blogpost" >'; // Begin blog post
		$re.= '<p>'.get_the_content('').'</p>';
		$re .= '</div>'; // End Blog Post

		$re .= '</div>'; //End Blog Image
		
		$re .= '<hr class="seperator"/>
		<div class="clearfix"></div>
		</article>'; // End Blog Item
} // end while post item
	
	if($pagination=='pager'){
		// Blog Footer and Pagination
		if(function_exists('wp_pagenavi'))
			$re .= wp_pagenavi( array( 'query' => $the_query, 'options' => array('return_string' => true) ));
	}
	wp_reset_postdata();	
	$re.='
	<div class="divider" style="height:10px"></div>
	<div class="clearfix"></div>';
	return $re;
}



function get_blog_meta($itemid, $metaformat='posted, category, tag, comments', $type='list'){
	global $post;
	$re = '';
	$blogformat = strtolower( get_post_format($itemid) );
	if($blogformat == 'standard' || $blogformat == '') 	$blogformat = 'standard';
	
	//if($type=='list')
		//$re .= '<a href="'.get_permalink($itemid).'" title="'.get_the_title($itemid).'" class="blogformat format'.$blogformat.'"></a>'; //blog format icon link
	//else
		//$re .= '<div class="blogformat format'.$blogformat.'"></div>'; //blog format icon box
	//if($dataformat!='none') // blog date box
		//$re .= '<div class="blogdate">'.get_the_time('d').'<br/>'.get_the_time('M').'<br/>'.get_the_time('Y').'</div>';
				
	$re .= '<div class="clearfix"></div>'; 
	
	// all meta informations about post
	if($metaformat!='none'){
		//$re .= '<hr class="mborder" style="margin-bottom:14px;" />';
		$re .= '<div class="meta-links">'; // Begin meta links
		
		if(strpos($metaformat, 'posted')!==false)
			//$re .= '<a class="meta-row url fn n" href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" title="'.get_the_author().'"><span>'.__('Posted By', 'rb').'</span>'.get_the_author().'</a>';
											
		if(strpos($metaformat, 'category')!==false){
			if(count(get_the_category($itemid))){
				//$re .= '<div class="meta-row"><span>'.__('Categories', 'rb').'</span>';
				//$re.= get_the_category_list( ', ' ).'</div>';
			}
		} 
					
		if(strpos($metaformat, 'tag')!==false){
			$tags_list = get_the_tag_list('',', ');
			if ( $tags_list ){
				$re .= '<div class="meta-row"><span>'.__('Tags', 'rb').'</span>';
				$re .= $tags_list;
				$re .= '</div>';
			}
		}
					
		//if(strpos($metaformat, 'comments')!==false){
		//	$commentCount = get_comments_number($itemid);
		//	if($commentCount==0)
		//		$commentStr = __('No Comment', 'rb');
		//	elseif($commentCount==1)
		//		$commentStr = __('1 Comment', 'rb');
		//	else
		//		$commentStr = $commentCount.' '.__('Comments', 'rb');
		//	$re .= '<div class="meta-row"><span>'.__('Comments', 'rb').'</span>'.$commentStr.'</div>';
		//}
					
		$re.='</div>'; // End meta links
	}
				
	//$re.= '<hr class="mborder" />';	
	
	if(strpos($metaformat, 'share')!==false){
		$re.= '<div class="post-share">';
		$re.= '<a class="fb" target="_blank" href="http://www.facebook.com/sharer.php?u='.urlencode(get_permalink($itemid)).'" ></a>';
		$re.= '<a class="tw" target="_blank" href="http://twitter.com/home?status='.urlencode(get_the_title($itemid).' - '.get_permalink($itemid)).'" ></a>';
		$re.= '<a class="gplus" target="_blank" href="https://plusone.google.com/_/+1/confirm?url='.get_permalink($itemid).'&amp;title='.urlencode(get_the_title($itemid)).'" ></a>';
		$re.= '<a class="comm" href="'.get_permalink($itemid).'#comments" ></a>';
		$re.= '<div class="clearfix"></div>';
		$re.= '</div>';
	}
	return $re;
}

function get_blog_media($itemid, $type='list'){
	global $post, $sidebarPos;
	$blogformat = strtolower( get_post_format($itemid) );
	if($blogformat == 'standart' || $blogformat == '') 	$blogformat = 'standart';
	$useResizer = get_post_meta(get_the_ID(), "useResizer", true);
	
	$addImgClass = '';
	if($type=='list'){
		$imgW = 700;
		if($sidebarPos!='None') $imgW = 460;
	}elseif($type=='detail'){
		$imgW = 940;
		$addImgClass = 'w-1';
		if($sidebarPos!='None'){
			$imgW = 700;
			$addImgClass = 'w-3-4';
		}
	}
	$re = '';
	
	if($type=='detail' && $blogformat!='aside')
		$re .= "\n".'<div class="sh_divider"></div>';
	
	$imagevar = false;
	if( has_post_thumbnail() && ($blogformat=='image' || $blogformat=='standart') ){
		$imagevar = true;
		$thumbnail_src = wp_get_attachment_url(get_post_thumbnail_id($itemid)); 
		if($useResizer=='use') 	$thumbnail_url = get_template_directory_uri().'/includes/timthumb.php?src='.$thumbnail_src.'&amp;w='.$imgW.'&amp;zc=1&amp;q=100';
		else $thumbnail_url = $thumbnail_src;
		
		if($type=='list' || $blogformat=='image'){
			$re .= "\n".'<div class="image_frame" '.(($type=='detail')?'style="cursor:auto"':'').' >'; //Begin Image Frame
			$re .= "\n".'<a href="'.(($blogformat!='image')?get_permalink():get_post_meta($itemid, "rb_format_big_image_url", true)).'" class="'.(($blogformat=='image')?'modal':'').'" title="'.get_the_title($itemid).'">';
		}
		
		$re .= '<img src="'.$thumbnail_url.'" '.(!empty($addImgClass)?'class="'.$addImgClass.'"':'').' width="'.$imgW.'" alt="'.get_the_title($itemid).'" />';
		
		if($type=='list' || $blogformat=='image'){
			$re .= '<div class="hoverWrapperBg"></div>
			<div class="hoverWrapper">';
			if($blogformat=='image') $re .= '<span class="hoverWrapperModal"></span>';
			else $re .= '<span class="hoverWrapperLink"></span>';
			$re.='</div></a>';
		}
		if($type=='list' || $blogformat=='image')
			$re .= '</div>'; // End Image Frame
		
		

	}elseif($blogformat=='video'){
		$videoUrl		= get_post_meta($itemid, "rb_format_video_url", true);
		$videoWidth		= (int) get_post_meta($itemid, "rb_format_video_width", true);
		$videoHeight	= (int) get_post_meta($itemid, "rb_format_video_height", true);
		$videoPoster 	= get_post_meta($itemid, "rb_format_video_poster", true);
		if(!empty($videoUrl) && $videoHeight>0){
			$sourceType = getMediaType($videoUrl);
			if($sourceType=='youtube' || $sourceType=='vimeo' || $sourceType=='jwplayer'){
				$sourceStr = getSource($videoUrl, $videoWidth, $videoHeight);
				if(!empty($sourceStr)){
					$re .= ' '.$sourceStr.' ';
					$imagevar = true;
				}
			}
		}
	}elseif($blogformat=='audio'){
		$audioUrl		= get_post_meta($itemid, "rb_format_audio_url", true);
		$audioPoster 	= get_post_meta($itemid, "rb_format_audio_poster", true);
		if(!empty($audioUrl)){
			$sourceType = getMediaType($audioUrl);
			if($sourceType=='jwplayeraudio'){
				$sourceStr = getSource($audioUrl, $imgW, 24);
				if(!empty($sourceStr)){
					$re .= $sourceStr;
					$imagevar = true;
				}
			}
		}
	}elseif($blogformat=='gallery'){
		$galleryid		= (int)get_post_meta($itemid, "rb_format_gallery_id", true);
		if($galleryid>0){
			$imagevar = true;
			$re .= do_shortcode('[flexslider id="'.$galleryid.'" style="margin:0px;"]');
		}
	}

	if($blogformat=='quote'){
		$re.='<h3 class="postQuote"><a class="linkformat" href="'.(($type=='detail')?'#':get_permalink($itemid)).'">'.get_post_meta($itemid, "rb_format_quote", true).'</a></h3>';
		$re.='<h4 class="postQuoteTitle">&mdash; '.get_the_title($itemid).'</h4>';
		
		if($type=='detail')
			$re.= '<hr class="mborder" />'; 
	}

	if(!($blogformat=='aside' || $blogformat=='quote') ){
		if($blogformat!='link' && $type=='list')
			$re.= '<h3 '.((!$imagevar)?'style="margin-top:0px;"':'').'><a href="'.get_permalink($itemid).'">'.get_the_title().'</a></h3>';
		else
			$re.= '<h3 '.((!$imagevar)?'style="margin-top:0px;"':'').'><a class="linkformat" target="_blank" href="'.get_post_meta($itemid, "rb_format_link_url", true).'">'.get_post_meta($itemid, "rb_format_link_url", true).'</a></h3>';
		//$re.= '<hr class="mborder" />';
	}elseif( !($blogformat=='aside' || $blogformat=='quote') && $type=='list'){
		$re.= '<hr class="mborder" style="margin-top:0px;"/>';
	}elseif($type=='list' && $blogformat!='aside'){
		$re.= '<hr class="mborder" />'; 
	}

	return $re;
}

?>