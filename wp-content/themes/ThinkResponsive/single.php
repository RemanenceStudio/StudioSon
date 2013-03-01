<?php
get_header();
if(have_posts())
{
	if(have_posts())
	{
		the_post();
		$postID	= get_the_ID();
		$content = get_the_content();
        $content = apply_filters('the_content', $content);
		$title = get_the_title();
		$imgW = $imageW = 570;
		$imgH = $imageH = 0;
	}
}

$useInDetail = get_post_meta($postID, "useInDetail", true);
$sidebarDefault = opt('sidebarsingledefault', '');
$sidebarPos = get_post_meta($postID, "sidebarPos", true);
if($sidebarPos=='' || $sidebarPos=='Default') $sidebarPos = $sidebarDefault;

?>
<!-- BEGIN: single -->
<div id="wrapper">
<section id="content" class="<?php echo ($sidebarPos!='None')?'content-with-sidebar':''; ?>">
	<hr class="bar"/>
	<article id="left-col" class="<?php echo ($sidebarPos!='None')?'left-col-with-sidebar':''; ?>">
			<div id="post-prev-next" class="bg_bottom">
				<div class='post-prev'>
					<?php previous_post_link('%link', '<span class="p-icon-left"></span><span class="p-title-left">%title</span>', true); ?>
				</div>
				<div class='post-next'>
					<?php next_post_link('%link', '<span class="p-icon-right"></span><span class="p-title-right">%title</span>', true); ?>
				</div>
				<div class="clearfix"></div>
			</div>
			<?php 
			$mediaDetail = get_blog_media(get_the_ID(), 'detail');
			if($useInDetail=='use' && !empty($mediaDetail)){ echo $mediaDetail; }else{ ?>
			<div class="sh_divider"></div>
			<?php } ?>
			<div class="sh_1of4 bg_bottom" style="padding-bottom:5px;">
				<?php echo get_blog_meta($postID,'posted, category, tag, comments, share','detail'); ?>
			</div>
			<div class="<?php echo ($sidebarPos!='None')?'sh_2of4':'sh_3of4';?> column_end">
			
				<p class="bg_bottom"><?php $more=1; the_content(''); ?></p>
				
				
			
				<div class="clearfix"></div>
				<?php/* comments_template( '', true ); */?>
			</div>
	</article> <!-- end of left-col -->
</section>
<!-- END: single -->
<?php if($sidebarPos!='None') get_sidebar(); ?>
</div>
<?php get_footer(); ?> 
