<?php 
global $more, $blogparams, $paged, $pageTitle, $pageTitleFull;
$dataformat ='dMY';
$metaformat = 'posted, category, comments, tag';

$sidebarPos = opt('sidebardefault', '');
?>
<div id="wrapper">
	<div id="content" class="<?php echo ($sidebarPos!='None')?'content-with-sidebar':'content-full-width'; ?>">
		<?php if(!(is_home() || is_front_page())){ ?> <hr class="bar"/>	<?php } ?>
		<div id="left-col" class="<?php echo ($sidebarPos!='None')?'left-col-with-sidebar':'page-content'; ?>">
<?php
	while(have_posts())
	{
		the_post();
		$blogformat = strtolower( get_post_format(get_the_ID()) );
		if($blogformat == 'standart' || $blogformat == '') 	$blogformat = 'standart';
		
		$blogClass = '';
		$blogClassArr = get_post_class(array('blogitem'), get_the_ID());
		foreach($blogClassArr as $blogClassArrItem)
			$blogClass.=$blogClassArrItem.' ';
		$re .= '<div id="post-'.get_the_ID().'" class="'.$blogClass.'">'; // // Begin blog item wrapper
		
		$re .= '<div class="blogcontent" >'; // Begin blog content
		$re .= '<div class="blogdatemeta">'; // Begin blog meta
		$re .= get_blog_meta(get_the_ID(), $metaformat); 		
		$re .= '</div>'; // End Blog Meta
		$re .= '</div>'; // End Blog Content
		
		$re .= '<div class="blogimage">'; // Begin Blog Image
		
		$re .= get_blog_media(get_the_ID(), 'list');
		
		$more=1; 
		$re.= '<p>'.substr(strip_tags(preg_replace('|[[\/\!]*?[^\[\]]*?]|si', '', get_the_content())), 0, 600).'...'.'</p>';
		
		$re .= '</div>'; //End Blog Image
		
		$re .= '<hr class="seperator"/>
		<div class="clearfix"></div>
		</div>'; // End Blog Item
	}
	
	if(function_exists('wp_pagenavi'))
	$re .= wp_pagenavi( array('options' => array('return_string' => true) ));
	$re.='
	<div class="divider" style="height:10px"></div>
	<div class="clearfix"></div>';
	echo $re;
?>
		</div>
	</div>
<?php if($sidebarPos!='None') get_sidebar(); ?>
</div>