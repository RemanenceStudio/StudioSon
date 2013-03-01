<?php get_header(); ?>
<div id="wrapper">
	<section id="content" class="<?php echo ($sidebarPos!='None')?'content-with-sidebar':'content-full-width'; ?>">
		<?php if(!(is_home() || is_front_page())){ ?> <hr class="bar"/>	<?php } ?>
		<div id="left-col" class="<?php echo ($sidebarPos!='None')?'left-col-with-sidebar':'page-content'; ?>">
			<?php 
			if(have_posts())
			{
				have_posts();
				the_post();
				$sidebarDefault = opt('sidebardefault', '');
				global $sidebarPos;
				$sidebarPos = get_post_meta($postID, "sidebarPos", true);
				if($sidebarPos=='' || $sidebarPos=='Default') $sidebarPos = $sidebarDefault;
				
				$content = get_the_content();
				$content = apply_filters('the_content', $content);
				echo $content;
			}
			?>
		</div>
	</section>
<?php if($sidebarPos!='None') get_sidebar(); ?>
</div>
<?php get_footer(); ?>