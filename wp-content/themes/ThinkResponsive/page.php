<?php 
/**
 * Template Name: Page Template
 */
 
get_header();
if(have_posts())
{
	have_posts();
	the_post();
	$postID	= get_the_ID();
	
	$sidebarDefault = opt('sidebardefault', '');
	global $sidebarPos;
	$sidebarPos = get_post_meta($postID, "sidebarPos", true);
	if($sidebarPos=='' || $sidebarPos=='Default') $sidebarPos = $sidebarDefault;
	
	$content = get_the_content();
	$content = apply_filters('the_content', $content);
	$title = get_the_title();
}
?>

<div id="wrapper">
	<section id="content" class="<?php echo ($sidebarPos!='None')?'content-with-sidebar':'content-full-width'; ?>">
		<!-- <?php if(!(is_home() || is_front_page())){ ?> <hr class="bar"/>	<?php } ?> -->
		<div id="left-col" class="<?php echo ($sidebarPos!='None')?'left-col-with-sidebar':'page-content'; ?>">
			<?php echo $content; ?>
		</div>
	</section>
<?php if($sidebarPos!='None') get_sidebar(); ?>
<div class="clearfix"></div>
</div>
<?php get_footer(); ?>