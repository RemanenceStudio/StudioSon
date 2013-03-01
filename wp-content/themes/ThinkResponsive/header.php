<!DOCTYPE html>
<?php 
$tmpurl = get_template_directory_uri();

if(opt('contentFont','')!='')
	wp_enqueue_style('contentFont', opt('contentFontFull',''), false, null, 'all');
if(opt('headerFont','')!='')
	wp_enqueue_style('headerFont', opt('headerFontFull',''), false, null, 'all');

?>
<html>
<head <?php language_attributes(); ?>>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
<?php
$favicon = trim(opt('favicon',''));
if(!empty($favicon)){
if(strpos($favicon,'http')===false)
	$favicon = $tmpurl.'/'.$favicon;
?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon; ?>" />
<?php } ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script type='text/javascript'>
var	ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
</script>
<?php 
$analyticsCode = trim(opt('googlecode',''));
if(!empty($analyticsCode))
{
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $analyticsCode; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php } ?>
<link href="<?php echo $tmpurl; ?>/includes/video-js/video-js.css" rel="stylesheet">
<script src="<?php echo $tmpurl; ?>/includes/video-js/video.js"></script>
<script>
  _V_.options.flash.swf = "<?php echo $tmpurl; ?>/includes/video-js/video-js.swf"
</script>
</head>
<body <?php body_class( $class ); ?>>
<?php 
global $demo;
if($demo){ ?>
<!-- BEGIN: DEMO Picker -->
<div id="palette">
	<div id="paletteHeader">
		<div id="colorResult">#0199FE</div>
		<a href="javascript:void(0);" class="closeButton"></a>
		<a href="javascript:void(0);" class="openButton"></a>
	</div>
	<div id="paletteBody">
		<div id="colorPicker"></div>
		<canvas id="colorPalette" width="150" height="150"></canvas>
	</div>
	<div id="ThemeSwitch">
		<a class="themeBtn light selected" href="javascript:void(0)" onclick="changeTheme('light')">LIGHT</a>
		<a class="themeBtn dark" href="javascript:void(0)" onclick="changeTheme('dark')">DARK</a>
	</div>
</div>
<script type="text/javascript">var themeURL = '<?php echo $tmpurl; ?>';</script>
<script type='text/javascript' src='<?php echo $tmpurl; ?>/js/demo.js'></script>
<script type="text/javascript">DrawPicker('colorPalette');</script>
<!-- BEGIN: DEMO Picker -->
<?php } ?>
	<?php if(is_active_sidebar('top-popup-left-wa') || is_active_sidebar('top-popup-right-wa')){ ?>
	<section id="topPopup" class="w-1">
		<div id="topPopupWrapper" <?php echo ((opt('top_popup','')=='true')?'style="display:block"':'');?>>
			
			<?php if(is_active_sidebar('top-popup-left-wa')){ ?>
			<div class="popupLeft">
				<?php dynamic_sidebar('top-popup-left-wa'); ?>
			</div>
			<?php } ?>
			
			
			<?php if(is_active_sidebar('top-popup-right-wa')){ ?>
			<div class="popupRight">
				<?php dynamic_sidebar('top-popup-right-wa'); ?>
			</div>
			<?php } ?>
			
			<div class="clearfix"></div>
		</div>
		<a id="topPopupOpenner" class="<?php echo ((opt('top_popup','')=='true')?'closeicon':'openicon');?>" href="javascript:void(0);"></a>
	</section>
	<?php } ?>
	<!-- container -->
	<div class="container">
	<header id="header-wrapper">

		<?php
		if( (($sliderPosition=='home-before' && is_home()) || $sliderPosition=='all-before') && $sliderGeneral!='disable')
			getGeneralSlider($sliderGeneral);
		?>
		<div id="header-container">
			<div id="header" style="z-index:900">
				<!-- LANGUE SELECTOR -->
				<?php do_action('icl_language_selector'); ?>
				<!-- LANGUE SELECTOR -->
				<div id="logo">
					<a href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>">
					<?php 
					$logoURL = opt('logo','');
					if(strpos($logoURL,'http')===false)
						$logoURL = $tmpurl.'/'.$logoURL;
					?>
					<img src="<?php echo $logoURL; ?>" title="<?php bloginfo('name'); ?>" />
					</a>
				</div>
				
				<nav id="main-menu">
				<?php 
				wp_nav_menu( array(
					'container_class'	=> 'menu-header', 
					'theme_location'	=> 'primary', 
					'walker'			=> new My_Walker(), 
					'show_home'			=> true 
				)); 
				//wp_nav_menu(array(
				//	'container_class'	=> 'menu-dropdown',
				//	'theme_location'	=> 'primary',
				//	'walker'			=> new Walker_Nav_Menu_Dropdown(),
				//	'items_wrap'		=> '<select id="sec-selector" name="sec-selector" onchange="location.href = document.getElementById(\'sec-selector\').value;">%3$s</select>',
				//	'show_home'			=> true
				//));
				//?>
				</nav>
			</div>
			<div class="clearfix"></div>
			<hr class="bar" style="margin:0 auto" />
		</div>
		<?php
		global $pageTitle;
		$pageTitle = '';
				if(is_search()) {
					 if(have_posts()){
						$pageTitle .= '<h1>'.__('Results for ','rb').'"'.get_search_query().'"</h1>';
					}else{ 
						$pageTitle .= '<h1>'.__('Not found for ','rb').'"'.get_search_query().'"</h1>';
					}
				}elseif(is_page()){
					if(have_posts()){
						$pageTitle .='<h1>'.get_the_title().'</h1>';
					}else{
						$pageTitle .='<h1>'.__('Page request could not be found.','rb').'</h1>';
					}
				}elseif(is_tag()){
					if(have_posts()){
						$pageTitle .='<h1>'.__('Tag, ','rb').single_tag_title('',false).'</h1>';
					 }else{ 
						$pageTitle .= '<h1>'.__('Page request could not be found.','rb').'</h1>';
					 }
				
				}elseif(is_category()){
					if(have_posts()){
						$pageTitle .= '<h1>'.__('Category, ','rb').single_tag_title('',false).'</h1>';
					}else{
						$pageTitle .= '<h1>'.__('Page request could not be found.','rb').'</h1>';
					}
				
				}elseif(is_archive()){
					if(have_posts()){
						$pageTitle .='<h1> ';
						if(is_day())
							$pageTitle .= __('Daily Archives, ','rb').get_the_date();
						elseif(is_month())
							$pageTitle .= __('Monthly Archives, ','rb').get_the_date('F Y');
						elseif(is_year())
							$pageTitle .= __('Yearly Archives, ','rb').get_the_date('Y');
						else
							$pageTitle .= __('Blog Archives','rb');
						$pageTitle .= '</h1>';
					}else{
						$pageTitle .='<h1>'.__('Page request could not be found.','rb').'</h1>';
					}
				}elseif(is_404()){
						$pageTitle .='<h1> '.__('You may find your requested page by searching.','rb').'</h1>';
				}else{
					$pageTitle .='<h1>'.get_the_title().'</h1>'; 
				}
		?>
		
	</header>
	
	<div id="bodywrapper">

		<?php	
		if(!(is_home() || is_front_page())){
			?>
			<div id="page-title-wrapper">
				<?php echo $pageTitle; ?>
				<?php if(is_active_sidebar('page-title-wa')) dynamic_sidebar('page-title-wa'); ?>
				<div class="clearfix"></div>
			</div>
			<?php
		}
	