

<div class="clearfix"></div>
			<!-- <div class="push"></div> -->
	
	</div> <!-- bodywrapper -->
	<div class="footer_wrapper">
		<footer id="footer">
			<div id="footer-main-container">
				<div id="footer-wrapper">
					<div class="footer_separator"></div>
					<div class="sh_1of4">
					<?php 
					if(is_active_sidebar('footer-wa1'))
						dynamic_sidebar('footer-wa1');
					?>

					</div>
					<div class="sh_1of4">
					<?php 
					if(is_active_sidebar('footer-wa2'))
						dynamic_sidebar('footer-wa2');
					?>
					</div>
					<div class="sh_1of4">
					<?php 
					if(is_active_sidebar('footer-wa3'))
						dynamic_sidebar('footer-wa3');
					?>
					</div>
					<div class="sh_1of4 column_end">
					<?php 
					if(is_active_sidebar('footer-wa4'))
						dynamic_sidebar('footer-wa4');
					?>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</footer>
	</div>
</div><!-- container -->
	<?php if(is_active_sidebar('bottom-popup-left-wa') || is_active_sidebar('bottom-popup-right-wa')){ ?>
	<section id="bottomPopup" class="w-1">
		<div id="bottomPopupWrapper" <?php echo ((opt('bottom_popup','')=='true')?'style="display:block"':'');?>>
			
			<?php if(is_active_sidebar('bottom-popup-left-wa')){ ?>
			<div class="popupLeft">
				<?php dynamic_sidebar('bottom-popup-left-wa'); ?>
			</div>
			<?php } ?>
			
			
			<?php if(is_active_sidebar('bottom-popup-right-wa')){ ?>
			<div class="popupRight">
				<?php dynamic_sidebar('bottom-popup-right-wa'); ?>
			</div>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
		<a id="bottomPopupOpenner" class="<?php echo ((opt('bottom_popup','')=='true')?'closeicon':'openicon');?>" href="javascript:void(0);"></a>
	</section>
	<?php } ?>
	<?php wp_footer(); ?>
</body>
</html>