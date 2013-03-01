<?php 
//Setup location of WordPress
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

//Access WordPress
require_once( $path_to_wp.'/wp-load.php' );

header ("Content-Type:text/css");


if(!$demo){
$prfx = '';
$colorFirst = '#'.opt('colorFirst','');
$colorFirstTint = '#'.opt('colorFirstTint','');
$colorInverse = '#'.opt('colorInverse', '');
$colorSecond = '#'.opt('colorSecond', '');
$colorSecondInverse = '#'.opt('colorSecondInverse', '');
$colorBox = '#'.opt('colorBox','');
$colorBoxInverse = '#'.opt('colorBoxInverse','');
$colorFont = '#'.opt('colorFont', ''); 

$colorMenu = '#'.opt('colorMenu', '');
$colorMenuFont = '#'.opt('colorMenuFont', '');
$colorMenuInverse = '#'.opt('colorMenuInverse', '');
$colorHeaderFont = '#'.opt('colorHeaderFont', '');
$colorHeaderFontHover = '#'.opt('colorHeaderFontHover', '');
$colorMenuFontHover = '#'.opt('colorMenuFontHover', '');
$colorMenuBorder = '#'.opt('colorMenuBorder', '');

$menuHeaderFontSize = opt('menuHeaderFontSize','');
$contentFontSize = opt('contentFontSize','');
$menuFontSize = opt('menuFontSize','');

$background_bg = stripslashes (opt('background_bg','')); 

$contentFont = "'".opt('contentFont','')."', sans-serif";
$headerFont = "'".opt('headerFont','')."', sans-serif";

$theme_style = opt('theme_style','');
$colorThemeBorder = '#CCCCCC'; 
$themeBodyWrapperColor = 'rgba(255,255,255,.9)';
if($theme_style=='dark'){
	$colorThemeBorder = '#4E4E4E';
	$themeBodyWrapperColor = 'rgba(0,0,0,.7)';
}

}else{
	echo '@colorFirst : '. "#".opt('colorFirst','').";\n";
	$colorFirst = '@colorFirst';
	echo '@colorFirstTint : '. "#".opt('colorFirstTint','').";\n";
	$colorFirstTint = '@colorFirstTint';
	echo '@colorInverse : '. "#".opt('colorInverse', '').";\n";
	$colorInverse = '@colorInverse';
	echo '@colorSecond : '. "#".opt('colorSecond', '').";\n";
	$colorSecond = '@colorSecond';
	echo '@colorSecondInverse : '. "#".opt('colorSecondInverse', '').";\n";
	$colorSecondInverse = '@colorSecondInverse';
	echo '@colorBox : '. "#".opt('colorBox','').";\n";
	$colorBox = '@colorBox';
	echo '@colorBoxInverse : '. "#".opt('colorBoxInverse','').";\n";
	$colorBoxInverse = '@colorBoxInverse';
	echo '@colorFont : '. "#".opt('colorFont', '').";\n"; 
	$colorFont = '@colorFont';

	echo '@colorMenu : ' ."#".opt('colorMenu', '').";\n";
	$colorMenu = '@colorMenu';
	echo '@colorMenuFont : '. "#".opt('colorMenuFont', '').";\n";
	$colorMenuFont = '@colorMenuFont';
	echo '@colorMenuInverse : '. "#".opt('colorMenuInverse', '').";\n";
	$colorMenuInverse = '@colorMenuInverse';
	echo '@colorHeaderFont : '. "#".opt('colorHeaderFont', '').";\n";
	$colorHeaderFont = '@colorHeaderFont';
	echo '@colorHeaderFontHover : '. "#".opt('colorHeaderFontHover', '').";\n";
	$colorHeaderFontHover = '@colorHeaderFontHover';
	echo '@colorMenuFontHover : '. "#".opt('colorMenuFontHover', '').";\n";
	$colorMenuFontHover = '@colorMenuFontHover';
	echo '@colorMenuBorder : '. "#".opt('colorMenuBorder', '').";\n";
	$colorMenuBorder = '@colorMenuBorder';

	$menuHeaderFontSize = opt('menuHeaderFontSize','');
	$contentFontSize = opt('contentFontSize','');
	$menuFontSize = opt('menuFontSize','');
	
	echo '@background_bg : '. stripslashes (opt('background_bg','')).";\n"; 
	$background_bg = '@background_bg';
	
	$contentFont = "'".opt('contentFont','')."', sans-serif";
	$headerFont = "'".opt('headerFont','')."', sans-serif";
	
	echo '@theme_style : '. "'".opt('theme_style','')."';\n";
	$theme_style = '@{theme_style}';
	$colorThemeBorder = '#CCCCCC'; 
	$themeBodyWrapperColor = 'rgba(255,255,255,.9)';
	if($theme_style=='dark'){
		$colorThemeBorder = '#4E4E4E';
		$themeBodyWrapperColor = 'rgba(0,0,0,.7)';
	}
	echo '@colorThemeBorder : '. $colorThemeBorder.";\n";
	echo '@themeBodyWrapperColor : '. $themeBodyWrapperColor.";\n";
	$colorThemeBorder = '@colorThemeBorder';
	$themeBodyWrapperColor = '@themeBodyWrapperColor';
	
	echo "@ImagesDir : '/';\n";
	$prfx = '@{ImagesDir}';
}
?>
/*
Theme Name: Think Responsive
Theme URI: http://www.renklibeyaz.com/
Description: Think responsive
Author: RenkliBeyaz - Salih Ozovali
Version: 1.0
*/

/* General */
* {
	margin:0px;
	padding:0px;
	border:none;
	outline:none;
	font-size:<?php echo $contentFontSize; ?>px;
	line-height:1.5em;
	color: <?php echo $colorFont; ?>;
	font-family: <?php echo $contentFont; ?>;
}

* html .clearfix {
	height: 1%;
}
*+html .clearfix {
	display: inline-block; 
}
.clearfix:after { 
	content: ".";
	display: block;
	clear: both;
	visibility: hidden;
	line-height: 0;
	height: 0;
	font-size:0px;
}
html[xmlns] .clearfix {
	display: block;
}
::selection {
        background: <?php echo $colorSecond;?>; /* Safari */
		color: <?php echo $colorSecondInverse;?>;
        }
::-moz-selection {
        background: <?php echo $colorSecond;?>; /* Firefox */
		color: <?php echo $colorSecondInverse;?>;  
}
body{
	background: <?php echo $background_bg;?>;
	/*overflow:scroll;*/
}

a{
	-moz-transition: all 0.3s ease-in-out 0s;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
}
a:link, a:visited{
	text-decoration:none;
	border-bottom:1px dotted <?php echo $colorFont; ?>;
}
a:hover, a:active{
	text-decoration:none;
	color: <?php echo $colorFirst; ?>;
}
.content-full-width-grid .wp-pagenavi, 
.content-with-sidebar-grid .wp-pagenavi{
	 margin-left:20px;
}
.wp-pagenavi{
	margin-top:20px;
}
.wp-pagenavi a{ border:none; }

#left-col .wp-pagenavi .pages{
	float:left; 
	font-size:12px;
	padding:2px 10px;
	margin:0 1px 20px 0;
	text-transform: uppercase;
	color: <?php echo $colorBoxInverse;?>;
	background-color: <?php echo $colorBox;?>;
}
#left-col .wp-pagenavi .current, 
#left-col .wp-pagenavi .page, 
#left-col .wp-pagenavi .nextpostslink,
#left-col .wp-pagenavi .previouspostslink {
	font-size:12px;
	text-transform: uppercase;
	padding: 2px 10px;
	display:block;
	float:left;
	color: <?php echo $colorBoxInverse; ?>;
	background-color: <?php echo $colorBox; ?>;
	text-align: center;
	text-decoration: none;
	margin-right: 1px;
	vertical-align:middle;
}

#left-col .wp-pagenavi .page:hover, 
#left-col .wp-pagenavi .nextpostslink:hover,
#left-col .wp-pagenavi .previouspostslink:hover {
	background-color: <?php echo $colorSecond; ?>;
	box-shadow:0 0 10px <?php echo $colorSecond; ?>;
	color: <?php echo $colorSecondInverse; ?>;
	position:relative;
	z-index:9999;
}

#left-col .wp-pagenavi .current{
	background-color: <?php echo $colorSecond; ?>;
	color: <?php echo $colorSecondInverse; ?>;
}
.content-full-width-grid{}
.content-with-sidebar{
	float:left; 
}
.content-with-sidebar-grid{
	width:620px; 
	float:left; 
	margin-top:20px;
}

#footer{
	width:940px;
	text-align:center;
	margin:20px auto 0 auto;
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') top left repeat-x;
}

#footer-wrapper .footer-wa-container{
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') bottom left repeat-x;
	padding-bottom:10px;
	margin-bottom:20px;
	min-height:320px;
}

#footer-wrapper .tweets li:first-child{ padding-top:0px; }
#footer-wrapper .widget_recent_entries ul li:first-child a{ margin-top:0px; }
#footer-wrapper .widget_recent_entries ul li:last-child{ background-image:none; }

#footer-wrapper{
	text-align:left;
}
#footer-sub{
	width:940px;
	text-align:left;
	padding:6px;
	margin: 0 auto;
}
#footertextwrapper{
	height:55px;
}

#footertext{
	margin:8px 20px 0 0;
	float:right;
	font-size:11px;
}

#footer-main-container{
	padding:20px 0 0 0;
	margin:0px auto;
}

#container {
	text-align:center;
	width:100%;
}

#wrapper {
	width: 940px;
	margin: 0 auto;
	text-align:left;
	padding:0 20px;
}
#bodywrapper{
	width:980px;
	margin:0 auto;
	<?php if($demo || opt('usecontentbgcolor','false')=='true') { ?>
	background-color:<?php echo $themeBodyWrapperColor; ?>;
	<?php } ?>
}

#header-wrapper{
	width:100%;
	text-align:center;
}
#header {
	height: 102px;
	width: 940px;
	margin: 0 auto;
}
#page-title-wrapper{
	text-align:left;
	margin:0 auto 16px auto;
}
.page-title-wa-container{
	width:220px;
	display:inline-block;
	float:right;
	margin-top:13px;
}
#slider-head-wrapper object, #slider-head-wrapper embed{
	margin-bottom:-40px;
}

#logo{
	float:left;
	display:inline-block;
}
#logo a{ border:none; }

h1, h2, h3, h4, h5, h6 {
	position:relative;
	font-weight:normal;
	line-height: 1.1em;
	font-family: <?php echo $headerFont; ?>;
	margin:0 0 10px 0;
}
h1 {
	font-size:<?php eopt('h1FontSize','');?>px;
	color: <?php echo $colorFirst; ?>;
}
.postHeader{
	width:600px;
}
#page-title-wrapper > h1{
	display:inline-block;
	float:left;
	font-size:20px;
	margin:15px 0 0 0;
}
h2 {
	color: <?php echo $colorFirst; ?>;
	font-size:<?php eopt('h2FontSize','');?>px;
}
h3 {
	color: <?php echo $colorFirst; ?>;
	font-size:<?php eopt('h3FontSize','');?>px;
}
h4 {
	color: <?php echo $colorFirst; ?>;
	font-size:<?php eopt('h4FontSize','');?>px;
}
h5 {
	color: <?php echo $colorFirst; ?>;
	font-size:<?php eopt('h5FontSize','');?>px;
}
h6 {
	color: <?php echo $colorFirst; ?>;
	font-size:<?php eopt('h6FontSize','');?>px;
}
h2>a{
	font-family: <?php echo $headerFont; ?>;
}

#left-col{
	float:left;
}

#right-col{
	float:right;
	width:220px;
	margin:0 0 0 20px;
}

#right-col > ul{
	list-style:none outside none;
}

#right-col ul li{
	width: 220px;
}

#right-col > ul > li > div{
	padding-bottom:20px;
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') bottom left repeat-x;
	margin-top:20px;
}

#right-col ul li div h3{
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-half-border.png') bottom left no-repeat;
	font-size:14px;
	margin:0;
	padding-bottom:20px;
	margin-top:20px;
}

.dform p{
	display:block;
	clear:both;
}

.dFormInput{
	width:200px;
	float:left;
	padding:2px;
	margin-left:10px;
	margin-bottom:20px;
	border: 1px solid <?php echo $colorThemeBorder; ?>;
	background-color:transparent;
}
.dFormInputFocus{
	border-color:<?php echo $colorFirst;?>;
}
.dform label{
	float:left;
	display:inline-block;
	width:100px;
}
.dform input[type=text], .dform select, .dform textarea{
	background:none;
	width:200px;
}
.dform input[type=text]:focus, .dform select:focus, .dform textarea:focus{
}
.dform select{
}
.dform input[type=submit]{
	margin-left:10px;
}
.dform textarea{
	height:100px;
}
.dform label.error{
	clear:both;
	float:left;
	margin-left:100px;
	padding-left:10px;
	color:<?php echo $colorSecond; ?>;
	font-weight:normal;
}
.form_message{
	display:none;
	padding:5px;
	background-color:  <?php echo $colorSecond; ?>;
	color:  <?php echo $colorSecondInverse; ?>;
}
div.form_input{
	float:left;
	margin-left:10px;
}
pre{
	white-space: pre-wrap;       /* css-3 */
	white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
	white-space: -pre-wrap;      /* Opera 4-6 */
	white-space: -o-pre-wrap;    /* Opera 7 */
	overflow: auto;
	font-family: 'Consolas',monospace;
	font-size:13px;
	color: #fff;
	line-height:24px;
	background: url("<?php echo $prfx; ?>images/pre-bg.jpg") repeat scroll left top #FFFFFF;
	margin: 0 0 10px 0;
	padding: 24px 10px;
}

/* Widgets */
#topPopup .widget_links h3,  
#bottomPopup .widget_links h3{
	display:none;
}

#topPopup .widget_links ul,  
#bottomPopup .widget_links ul{
	display:inline-block;
	list-style:none;
}

#topPopup .widget_links li,  
#bottomPopup .widget_links li{
	float:left;
	margin:0 10px;
}

#topPopup .widget_links a:link,
#topPopup .widget_links a:visited,
#bottomPopup .widget_links a:link,
#bottomPopup .widget_links a:visited{
	text-decoration:none;
	border-bottom:1px solid transparent;
}

#topPopup .widget_links a:active,
#topPopup .widget_links a:hover,
#bottomPopup .widget_links a:active,
#bottomPopup .widget_links a:hover{
	text-decoration:none;
	border-bottom:1px solid <?php echo $colorSecond; ?>;
}

.textwidget{margin-top:20px;}
#topPopup .textwidget, #bottomPopup .textwidget{margin-top:0px;}
#flickr_badge_wrapper{margin-top:20px;}
.wtitle-container{
	margin-bottom:20px;
}

/* Widgets */
.widget_tag_cloud a:link, .widget_tag_cloud a:visited{
	float:left;
	display:inline;
	font-size:12px !important;
	line-height:24px;
	padding:0 5px;
	color:<?php echo $colorBoxInverse; ?>;
	background-color:<?php echo $colorBox; ?>;
	text-decoration:none;
	text-transform:uppercase;
	margin:1px 1px 0 0;
	border:none;
}
.widget_tag_cloud a:hover, .widget_tag_cloud a:active{
	background-color:<?php echo $colorSecond; ?>;
	color:<?php echo $colorSecondInverse; ?>;
	box-shadow:0 0 10px <?php echo $colorSecond;?>;
	position:relative;
	z-index:99999;
	text-decoration:none;
}
.tagcloud:after {
    clear: both;
    content: ".";
    display: block;
    height: 0;
    visibility: hidden;
}

.widget_categories ul, .widget_archive ul, .widget_recent_comments ul, .widget_recent_entries ul{ list-style:none;}
.widget_categories ul li, .widget_archive ul li, 
#right-col .widget_recent_comments ul li, #right-col .widget_recent_entries ul li { padding:5px 0;}

.widget_categories ul li, .widget_archive ul li{ text-align:right; color:<?php echo $colorFirst;?>; }
.widget_categories ul li a, .widget_archive ul li a{ float:left; }

.recentcomments a.url:link, 
.recentcomments a.url:visited{ color:<?php echo $colorFirst; ?>}

#right-col .widget_categories ul li, 
#right-col .widget_archive ul li {}

#right-col .widget_recent_comments li:first-child{ padding-top:0px; }

.widget_categories ul li a:link,
.widget_categories ul li a:visited,
.widget_archive ul li a:link,
.widget_archive ul li a:visited,
.widget_recent_comments ul li a:link,
.widget_recent_comments ul li a:visited{
	display:inline-block;
	text-indent:9px; 
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-list-icon-miniplus.png') center left no-repeat;
	color:<?php echo $colorFont; ?>;
	text-transform:uppercase;
	border:none;
}
.widget_categories ul li a:hover,
.widget_categories ul li a:active,
.widget_archive ul li a:hover,
.widget_archive ul li a:active,
.widget_recent_comments ul li a:hover,
.widget_recent_comments ul li a:active,
.widget_recent_entries ul li a:hover,
.widget_recent_entries ul li a:active{
	color:<?php echo $colorFirst; ?>;
	text-decoration:underline;
}

.widget_recent_comments ul li a:link, 
.widget_recent_comments ul li a:visited{
	background:none;
	border:none;
}

/*Recent Posts*/
.widget_recent_entries ul li a:link,
.widget_recent_entries ul li a:visited{
	display:inline-block;
	font-size:12px;
	color:<?php echo $colorFont; ?>;
	text-transform:uppercase;
	margin:20px 0 20px 0;
	border:none;
}
.widget_recent_entries ul li a:hover,
.widget_recent_entries ul li a:active{ color:<?php echo $colorFirst; ?>; }

.widget_recent_entries ul li{ 
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-half-border.png') bottom left no-repeat;
}
#footer-wrapper h3{
	margin-bottom:20px !important;
	padding-bottom:20px;
	font-size:14px;
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-half-border.png') bottom left no-repeat;
}

.RB_Newsletter_Widget h3{
	margin:0;
	padding:0;
	display:inline-block;
	font-size:14px;
}

.RB_Newsletter_Widget form{
	padding:3px;
	display:inline-block;
	background-color:<?php echo $colorFirstTint; ?>;
	margin-left:10px;
}
.RB_Newsletter_Widget form input[type=text]{
	font-family: <?php echo $contentFont; ?>;
	background-color:transparent;
	display:inline-block;
	line-height:24px;
	height:24px;
	width:190px;
}
.RB_Newsletter_Widget form a:link,
.RB_Newsletter_Widget form a:visited{
	font-family: <?php echo $contentFont; ?>;
	background-color:<?php echo $colorBox; ?>;
	display:inline-block;
	line-height:24px;
	height:24px;
	padding:0 4px;
	border:none;
}
.RB_Newsletter_Widget form a:hover,
.RB_Newsletter_Widget form a:active{
	text-decoration:none;
	background-color:<?php echo $colorSecond; ?>;
	box-shadow:0 0 10px <?php echo $colorSecond; ?>;
	position:relative;
	z-index:99999;
}

.RB_Newsletter_Widget .loading{
	vertical-align:top;
	display:inline-block;
	line-height:24px;
	height:24px;
	width:26px;
	margin:0;
	background: <?php echo $colorFirst; ?> url('<?php echo $prfx; ?>images/loading.gif') center center no-repeat;
}


#wp-calendar caption{
	text-align: right;
	padding: 0 10px 10px 0;
	font-family: <?php echo $headerFont; ?>;
}

#wp-calendar{
	width:100%;
	color: <?php echo $colorFirst; ?>;
}

#wp-calendar td, #wp-calendar th{
	text-align:center;
	color: <?php echo $colorFirst; ?>;
	font-family: <?php echo $headerFont; ?>;
}
#wp-calendar td{
	font-family: <?php echo $contentFont; ?>;
}

#wp-calendar tfoot td { text-align:left;}
#prev a{
	text-align:left;
	color: <?php echo $colorFirst; ?>;
	
	text-decoration: none;
}
#prev a:hover{
	text-decoration: underline;
}
#wp-calendar tbody #today{
	background-color: <?php echo $colorSecond; ?>;
	color: <?php echo $colorSecondInverse;  ?>;
}

.blogroll li a{
	display:block;
}
.blogroll li{
	margin-bottom:3px;
}
ul.tweets{
	list-style:none;
}
ul.tweets li{
	background: url("<?php echo $prfx; ?>images/<?php echo $theme_style;?>-half-border.png") no-repeat scroll left bottom transparent;
	padding:20px 0;
}
ul.tweets li:last-child{
	background: none;
}
ul.tweets li span{
	display:none;
}
ul.tweets em, ul.tweets b{
	font-style:normal;
	display:inline-block;
	color:<?php echo $colorFont; ?>;
}
ul.tweets li a:link, ul.tweets li a:visited{
	text-decoration:none;
	color:<?php echo $colorFont; ?>;
}
ul.tweets li a:hover, ul.tweets li a:active{
	text-decoration:none;
	color:<?php echo $colorFirst; ?>;
}

#flickr_badge_wrapper a:link,
#flickr_badge_wrapper a:visited{
	margin:0 20px 20px 0;
	display:inline-block;
	width:50px;
	height:50px;
	border:none;
}
#flickr_badge_wrapper a:hover,
#flickr_badge_wrapper a:active{
	box-shadow:0 0 10px <?php echo $colorSecond; ?>;
	position:relative;
	z-index:99999;
}
#flickr_badge_wrapper a, #flickr_badge_wrapper a img{
	width:50px;
	height:50px;
}

#headertext{
	height:14px;
	line-height:50px;
	padding:0 14px;
}

/* Main menu CSS*/
#main-menu a{
	-moz-transition: all 0.3s ease-in-out 0s;
	border:none;
}

#main-menu {
	margin-top: 37px;
	display:inline-block;
	float:right;
}
#main-menu .sf-sub-indicator{
	display:none;
}
/* current menu */
#main-menu ul li.current-menu-item > a, #main-menu ul li.current-menu-ancestor > a{
	background: <?php echo $colorMenu; ?>;
}
#main-menu ul > .sfHover > a{
	background: <?php echo $colorMenu; ?>;
}

#main-menu ul li.sfHover > a:link, #main-menu ul li.sfHover > a:visited {}
#main-menu ul ul li.sfHover > a:link, #main-menu ul ul li.sfHover > a:visited {}

#main-menu ul li.sfHover > a span.title{
	color: <?php echo $colorHeaderFontHover; ?>;
}
#main-menu ul li a:hover span.title, #main-menu ul li.current-menu-item a span.title, #main-menu ul li.current-menu-ancestor a span.title{
	color: <?php echo $colorHeaderFontHover; ?>;
}
#main-menu ul li ul li.sfHover > a:link span.title, #main-menu ul li ul li.sfHover > a:visited span.title{
	color: <?php echo $colorMenuFontHover; ?>;
}
#main-menu ul li ul li.sfHover > a{
	background-color: <?php echo $colorMenuInverse; ?>;
}
#main-menu ul {
	list-style:none outside none;
}

#main-menu ul li {
	position:relative;
	float:left;
	width:auto !important;
	width:0;
	white-space: nowrap;
	margin-left:1px;
}
#main-menu ul li a {
	cursor: pointer;
}
#main-menu ul li > a span {
	float:left;
	clear:both;
	text-align:left;
}
#main-menu ul li a > span.title {
	font-size:<?php echo $menuHeaderFontSize; ?>px;
	padding:8px 14px;
	text-align:left;
	font-family: <?php echo $headerFont; ?>;
	color:<?php echo $colorHeaderFont; ?>;
}
#main-menu ul li li a span.title {
	text-shadow: none;
	font-weight:normal;
}

#main-menu ul li a span.description {
	display:none;
	font-family: <?php echo $contentFont; ?>;
	font-size:8pt;
	margin-top:0px; /*ie*/
	padding:0px 10px 0px 10px;
	text-align:left;
	color: <?php echo $colorHeaderFontContent; ?>;
}

#main-menu ul li ul li a span.description {
	display:none;
}

#main-menu ul li a:link, #main-menu ul li a:visited {
	display:inline-block;
	text-decoration:none;
	line-height:75px;
	z-index:999;
	color: <?php echo $colorHeaderFont; ?>;
}
#main-menu ul li a:hover, #main-menu ul li a:active {
	background-color: <?php echo $colorMenu; ?>;
}

#main-menu ul ul {
	display:none;
	width:200px;
	position:absolute;
	top:38px;
	list-style:none;
	z-index:1000;
	color: <?php echo $colorMenu; ?> !important;
}
@-moz-document url-prefix() {
	#main-menu ul ul {
		top:38px;
  }
}
<?php if(!$demo) { ?>
#main-menu ul ul { top:37px\9 } /* ie9*/
<?php } ?>
@media all and (-webkit-min-device-pixel-ratio:10000), not all and (-webkit-min-device-pixel-ratio:0){
	#main-menu ul ul {top:37px;}
}

#main-menu ul li ul li {
	width:200px !important;
	margin:0;
	border:0;
	/*border-bottom: 1px solid <?php echo $colorMenuBorder; ?>;*/
	margin-bottom:1px;
	background:<?php echo $colorMenu; ?>;
}

#main-menu ul ul li a span.title{
	margin-top:2px;
	font-size:<?php echo $menuFontSize; ?>px;
}
#main-menu ul ul li a:link, #main-menu ul ul li a:visited {
	font-size:10pt;
	width:100%;
	display:block;
	height:39px;
	color:<?php echo $colorMenuFont; ?>;
}
#main-menu ul ul li a:link span.title, #main-menu ul ul li a:visited span.title{
	color:<?php echo $colorMenuFont; ?>;
}
#main-menu ul ul li a:hover, #main-menu ul ul li a:active{
	background:<?php echo $colorMenuInverse; ?>;
	box-shadow: 0px 0px 15px <?php echo $colorMenuInverse; ?>;
	z-index:5000;
	position:relative;
}
#main-menu ul ul li a:hover span.title, #main-menu ul ul li a:active span.title{
	color:<?php echo $colorMenuFontHover; ?>;
}
#main-menu ul ul ul {
	left:200px;
	top:0;
}

/* Blog */
.blogitem{
	margin-top:20px;
	background:url("<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png") repeat-x scroll left bottom transparent;
	padding-bottom:25px;
}
.blogimage{
	float:left;
	display:block;
	width:460px;
}
.blogcontent{
	float:left;
	display:block;
	width:220px;
	margin-right:20px;
}
.blogformat, a.blogformat:link, a.blogformat:visited{
	width:50px;
	height:50px;
	background-color:<?php echo $colorBox; ?>;
	margin-right:1px;
	display:block;
	float:left;
	background-position:center center;
	background-repeat:no-repeat;
	border:none;
}
a.blogformat:hover, a.blogformat:active{
	background-color:<?php echo $colorSecond; ?>;
    box-shadow: 0px 0px 15px <?php echo $colorSecond; ?>;
	z-index:5000;
	position:relative;
}

.formatstandard{ background-image:url('<?php echo $prfx; ?>images/format_standard.png'); }
.formataside{ background-image:url('<?php echo $prfx; ?>images/format_aside.png'); }
.formatvideo{ background-image:url('<?php echo $prfx; ?>images/format_video.png'); }
.formataudio{ background-image:url('<?php echo $prfx; ?>images/format_audio.png'); }
.formatimage{ background-image:url('<?php echo $prfx; ?>images/format_image.png'); }
.formatgallery{ background-image:url('<?php echo $prfx; ?>images/format_gallery.png'); }
.formatlink{ background-image:url('<?php echo $prfx; ?>images/format_link.png'); }
.formatquote{ background-image:url('<?php echo $prfx; ?>images/format_quote.png'); }

.blogdate br{ font-size:0px; }
.blogdate{
	width:40px;
	height:43px;
	display:block;
	float:left;
	
	padding:2px 5px 5px 5px;
	text-align:center;
	background-color:<?php echo $colorFirstTint; ?>;
	color:<?php echo $colorBoxInverse; ?>;
	font-size: 14px;
	line-height:14px;
	font-family: <?php echo $headerFont; ?>;
}
.blogitem h3, .blogitem h3 a, 
.linkformat, .linkformat:link, .linkformat:visited{
	font-size:14px;
	line-height:1.2em;
	text-decoration:none;
	font-family: <?php echo $headerFont; ?>;
	color: <?php echo $colorFirst; ?>;
	margin:20px 0 0 0;
	border:none;
}
.blogitem h3 a:hover,
.blogitem h3 a:active,
.linkformat:hover,
.linkformat:active{
	color: <?php echo $colorFont; ?>;
}
.meta-row span{
	text-transform:none;
	display:inline-block;
	font-family: <?php echo $headerFont; ?>;
	font-size:14px;
	color: <?php echo $colorFirst; ?>;
	width:90px;
}
.meta-row, a.meta-row:link, a.meta-row:visited,
.meta-row a:link, .meta-row a:visited{
	text-decoration:none;
	color:<?php echo $colorFont; ?>;
	text-transform:uppercase;
	border:none;
}
a.meta-row:hover, a.meta-row:active,
.meta-row a:hover, .meta-row a:active{
	text-decoration:underline;
	color:<?php echo $colorFirst; ?>;
}
h3.postQuote{
	margin-top:0px;
}
h3.postQuote a:link,
h3.postQuote a:visited{
	font-family: <?php echo $headerFont; ?>;
	font-size:18px;
	color: <?php echo $colorFont; ?>;
}
h3.postQuote a:hover,
h3.postQuote a:active{
	color: <?php echo $colorFirst; ?>;
}

h4.postQuoteTitle{
	margin-top:10px;
	font-size:14px;
	text-align:right;
}
.tes_items{
	position:relative;
}
.sh_testimonial{
	position:absolute;
	background:url("<?php echo $prfx; ?>images/<?php echo $theme_style; ?>-quote-bg.png") no-repeat scroll 0 5px;
}
.tes_block{
	margin-left:50px;
	border-left:1px solid <?php echo $colorThemeBorder; ?>;
}
.tes_quote{
	margin-left:20px;
	color:<?php echo $colorFont; ?>;
}
.tes_owner{margin-left:20px;}
.tes_nav{
	margin-top:20px;
	text-align:center;
}
.tes_nav a:link,
.tes_nav a:visited{
	border-radius:50%;
	margin-right:1px;
	display:inline-block;
	width:16px;
	height:16px;
	background:url('<?php echo $prfx; ?>images/tes_nav_icon.png') 0 0 no-repeat;
	border:none;
	text-indent:-99999px;
}
.tes_nav a:hover,
.tes_nav a:active{
	background-position:0 -16px;
}
.tes_nav a.selected:link,
.tes_nav a.selected:visited,
.tes_nav a.selected:hover,
.tes_nav a.selected:active{
	background-position:0 -32px;
}

.post-share{margin-bottom:20px;}
.post-share a:link, 
.post-share a:visited{ 
	display:block;
	float:left;
	width:24px;
	height:24px;
	background-position:center center;
	background-repeat:no-repeat;
	background-color:<?php echo $colorBox; ?>;
	margin-right:1px;
	border:none;
}

a.comm:link,
a.comm:visited{
	background-image:url('<?php echo $prfx; ?>images/icon-comm.png'); 
	background-color:<?php echo $colorFirstTint; ?>;
	border:none;
}
.post-share a:hover, 
.post-share a:active,
a.comm:hover,
a.comm:active{
	background-color:<?php echo $colorSecond; ?>;
    box-shadow: 0px 0px 10px <?php echo $colorSecond; ?>;
	z-index:5000;
	position:relative;
}

.fb{background-image:url('<?php echo $prfx; ?>images/icon-fb.png');}
.tw{background-image:url('<?php echo $prfx; ?>images/icon-tw.png');}
.gplus{background-image:url('<?php echo $prfx; ?>images/icon-gplus.png');}

.entry-date{
	padding: 7px 20px 9px 20px;
	background: <?php echo $colorSecond; ?>;
	display:block;
	float:left;
	color: <?php echo $colorSecondInverse;  ?>;
	font-size: 18pt;
	line-height:18pt;
	font-family: <?php echo $headerFont; ?>;
}
.postleftimage{
	margin-bottom: 50px;
}
.entry-title{
	clear:both;
}
.separator{
	display:inline-block;
	width:10px;
}
h2.entry-title-full-page a{
	position:relative;
	top:0px;
	color: <?php echo $colorFirst; ?>;
	font-size: 16pt;
	text-decoration:none;
	line-height:1em;
}
.blog-link{
	padding-left: 20px;
	margin-right: 15px;
}
.blog-link, .blog-link span{
	color: <?php echo $colorThemeBorder;?>;
	font-size: 11px;
}
.blog-link  span.title a, .blog-link a{
	color:<?php echo $colorInverse; ?>;
	font-size: 11px;
	text-decoration: none;
}
.blog-link  span.title a:hover, .blog-link a:hover{
	text-decoration: underline;
}
.icon-posted{
	background: url('<?php echo $prfx; ?>images/icon-posted.png') no-repeat;
}
.icon-cat{
	background: url('<?php echo $prfx; ?>images/icon-cat.png') no-repeat;
}
.icon-comm{
	background: url('<?php echo $prfx; ?>images/icon-comm.png') left 3px no-repeat;
}
.icon-tag{
	background: url('<?php echo $prfx; ?>images/icon-tag.png') no-repeat;
}

/* Single Page*/
.bg_bottom{background: url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') bottom left repeat-x; padding-bottom:25px;}
#post-prev-next{ padding-top:20px; }
.post-prev{float:left; /*width:40%;*/}
.post-next{float:right; /*width:40%;*/ text-align:right;}

.post-prev a:link, .post-prev a:visited, 
.post-next a:link, .post-next a:visited{
	display:block;
	font-family: <?php echo $headerFont; ?>;
	font-size:14px;
	color:<?php echo $colorFirst; ?>; 
	text-decoration:none;
	border:none;
}
.post-prev a:active, .post-prev a:hover{}
.post-next a:active, .post-next a:hover{}
.post-prev a{}


.p-title-left, .p-title-right{
	float:left;
	display:block;
	font-family: <?php echo $headerFont; ?>;
	font-size:14px;
	color:<?php echo $colorFirst; ?>; 
	text-decoration:none;
	margin-left:20px;
}
.p-title-right{ float:right; margin-left:0; margin-right:20px;}

.p-icon-left, .p-icon-right{
	float:left;
	display:block;
	width:24px;
	height:24px;
	background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/slider_arrow_left.png') center center no-repeat;
}
.p-icon-right{
	float:right; 
	background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/slider_arrow_right.png') center center no-repeat;
}

.p-icon-hover{
	background-color:<?php echo $colorSecond; ?>;
	box-shadow:0 0 10px <?php echo $colorSecond ?>;
}
.p-title-left-hover{ margin-left:10px; color:<?php echo $colorFont;?>; }
.p-title-right-hover{ margin-right:10px; color:<?php echo $colorFont;?>; }



/*Portfolio*/
.portfolioitems{
	list-style:none;
	width:620px;
	overflow:hidden;
	margin-top:20px;
}
.portfolioitem{
	float:left;
	margin:0 20px 20px 0;
	background:url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') left bottom repeat-x;
	padding-bottom:12px;
}
.portfolioitem .meta-row{ margin-bottom:10px;}
.portfolioitem h3{ font-size:14px; margin:14px 0 0 0;}
.portfolioFilter{
	display:inline-block;
	float:right;
	list-style:none;
	margin:20px 0 0 0;
	padding-bottom:20px;
}
.portfolioFilter li{ float:left; margin:0 0 1px 1px;}
.portfolioFilter li a:link,
.portfolioFilter li a:visited{
	display:block;
	background-color:<?php echo $colorBox; ?>; 
	text-decoration:none;
	color:<?php echo $colorBoxInverse; ?>;
	font-family: <?php echo $contentFont; ?>;
	font-size:12px;
	line-height:24px;
	padding:0 10px;
	border:none;
}
.portfolioFilter li a:hover,
.portfolioFilter li a:active{
	background-color:<?php echo $colorSecond; ?>; 
	color:<?php echo $colorSecondInverse; ?>;
	box-shadow: 0px 0px 10px <?php echo $colorSecond; ?>;
	z-index:5000;
	position:relative;
}
.portfolioFilter li a.selected{ 
	background-color:<?php echo $colorSecond; ?>; 
	color:<?php echo $colorSecondInverse; ?>;
	box-shadow:none;
}
h2.sh_portfolio_title{
	font-family: <?php echo $HeaderFont; ?>;
	color: <?php echo $colorFirst; ?>;
	margin:20px 0;
	font-size:20px;
	float:left;
	display:inline-block;
}
h3.portfolio-controls{
	font-size:18px;
}
.p-control, .p-control:link, .p-control:visited { border:none; width: 24px; height: 24px; display: block; cursor: pointer; text-indent: -9999px;}
.p-control:hover{background-color:<?php echo $colorSecond; ?>; box-shadow:0 0 10px <?php echo $colorSecond; ?>; z-index:99999; position:relative;}
.p-control-close {background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/slider_arrow_close.png') center center no-repeat; float:right;}
.p-control-next {background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/slider_arrow_right.png') center center no-repeat; float:right; margin-right:1px;}
.p-control-prev {background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/slider_arrow_left.png') center center no-repeat; float:right; margin-right:1px;}
.p-control-disabled,
.p-control-disabled:hover,
.p-control-disabled:active{background-color:<?php echo $colorFirstTint; ?>; cursor: default; box-shadow:none;}
.c3columns_withSidebar > li{ width:220px;}
.c4columns_withSidebar > li{ width:160px;}
.c5columns_withSidebar > li{ width:124px;}
.c6columns_withSidebar > li{ width:100px;}
.c3columns_withoutSidebar > li{ width:300px;}
.c4columns_withoutSidebar > li{ width:220px;}
.c5columns_withoutSidebar > li{ width:172px;}
.c6columns_withoutSidebar > li{ width:140px;}


/*Gallery*/
.galleryitems{
	list-style:none;
	overflow:hidden;
	margin-top:20px;
}
.galleryitem{
	float:left;
	margin:0 20px 20px 0;
	padding-bottom:25px;
	background:url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') left bottom repeat-x;
}
.galleryitem h3{ font-size:14px; margin-top:14px;}

div.read-more-link{
	text-align:right;
	border-bottom: <?php echo $colorSecond; ?> 1px solid;
	margin-bottom: 40px;
	font-family: <?php echo $headerFont; ?>;
}

a.read-more-link{
	display:inline-block !important; 
	color:<?php echo $colorSecondInverse;  ?>;
	font-size: 12pt;
	text-decoration: none;
	padding: 6px 6px 8px 35px;
	background:<?php echo $colorSecond; ?> url('<?php echo $prfx; ?>images/readmore-icon.png') 22px center no-repeat;
	width:auto;
}
.page-content{
	width: 960px;
	margin: 0;
	display:inline-block;
}

/* Comments CSS*/
#comments h4{
	padding:20px 0 10px 0;
	font-size:14px;
}
.comment-wrapper{
	border:1px solid <?php echo $colorThemeBorder;?>;
	margin-bottom:20px;
}

#comments ul, #comments ol{
	list-style:none;
}

#comments ol li li{
	padding-left:44px;
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style; ?>-comment-icon.png') 0px 20px no-repeat;
}

.comment-avatar{
	float:left;
	position:relative;
	padding:8px 8px 5px 8px;
	margin:20px;
	background-color:<?php echo $colorBox; ?>;
	border:0;
}
.comment-avatar svg{
	position:absolute;
	right:-9px;
	top:5px;
	fill:<?php echo $colorBox; ?>;
}
.comment-text{
	padding:0 20px 20px 20px;
}
.comment-author{
	margin-top:15px;
	float:left;
}
.author-link, .author-date, .author-time {
	font-size:14px;
	color: <?php echo $colorFirst; ?>;
	font-family:<?php echo $headerFont; ?>;
}
.comment-text p{ border-top:1px solid <?php echo $colorThemeBorder; ?>; padding-top:20px; }
.form-allowed-tags{ display:none; }
.commentslist{padding-bottom:5px;}
.reply{margin-right:20px;}
.author-link a:link,
.author-link a:visited{
	border:0;
	font-size:14px;
	color: <?php echo $colorFirst; ?>;
	font-family:<?php echo $headerFont; ?>;
}
.author-link a:hover,
.author-link a:active{
	color: <?php echo $colorFont; ?>;
	text-decoration:underline;
}

/*Comment Form*/
#respond{ 
	margin-top:17px; 
	padding-bottom:1px;
	background:url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') left bottom repeat-x;
}
#reply-title{ 
	font-size:14px; 
	background: url("<?php echo $prfx; ?>images/<?php echo $theme_style;?>-half-border.png") no-repeat scroll left bottom transparent;
	padding-bottom:20px;
}
#commentform{
	margin-bottom:20px;
}
.comment-notes, .logged-in-as{
	background: url("<?php echo $prfx; ?>images/<?php echo $theme_style;?>-half-border.png") no-repeat scroll left bottom transparent;
	padding-bottom:20px;
}
#commentform label{
	display:inline-block;
	width: 132px;
	font-size:14px;
	height:32px;
	vertical-align:top;
} 
#commentform .required{
	display:inline-block;
	width:15px;
	height:22px;
	color: <?php echo $colorSecond;?>;
	vertical-align:top;
}
#commentform .comment-form-author label, 
#commentform .comment-form-email label{
	width:115px;
}
#commentform input[type=text], 
#commentform textarea{
	width: 250px;
	height: 22px;
	border:1px solid <?php echo $colorThemeBorder; ?>;
	padding:5px;
	background:transparent;
}
#commentform input[type=text]:focus, 
#commentform textarea:focus{
	border:1px solid <?php echo $colorFirst; ?>;
}
#commentform textarea{
	height:140px;
}
#commentform p{
	margin-top:20px;
	vertical-align:top;
}
#commentform input[type=submit]{
	cursor:pointer;
	margin-left:132px;
	display:inline-block;
	font-size:12px;
	line-height:20px;
	height:20px;
	padding:0px 9px 5px 9px;
	text-transform:uppercase;
	background-color: <?php echo $colorBox ;?>;
	color: <?php echo $colorBoxInverse;?>;
}
#commentform input[type=submit]:hover{
	color: <?php echo $colorInverse;?>;	
	background-color:<?php echo $colorSecond; ?>;
    box-shadow: 0px 0px 10px <?php echo $colorSecond; ?>;
	z-index:5000;
	position:relative;
	
}
@-moz-document url-prefix() {
	#commentform input[type=submit]{
		padding:0px 11px 1px 11px;
  }
}



.loading {
	float:none;
	clear:both;
	width:32px;
	height:32px;
	margin:0 auto 25px auto;
	background: url('<?php echo $prfx; ?>images/loading.gif') center center no-repeat;
}

/*** Shortcodes ***/
.sh_divider{
	height:20px;
}
.sh_acc_item{
	display:none;
}
.sh_acc_item_title {
	margin-bottom:5px;
	vertical-align:text-top;
}
.sh_acc_item_title a:link,
.sh_acc_item_title a:visited{
	vertical-align:top;
	display:block;
	padding: 20px;
	cursor:pointer;
	height:24px;
	border:none;
}
.sh_acc_item_title a:link span.text,
.sh_acc_item_title a:visited span.text{
	display:inline-block;
	vertical-align:top;
	color: <?php echo $colorFirst;?>;
	text-decoration:none;
	font-size: 16px;
	line-height:24px;
	font-family:<?php echo $headerFont; ?>;
}
.sh_acc_item_title a:hover span.text,
.sh_acc_item_title a:active span.text{
	color: <?php echo $colorSecond;?>;
}
.sh_acc_item_title{
	border:1px solid <?php echo $colorThemeBorder; ?>;
}
.sh_acc_item_title a:link span.icon,
.sh_acc_item_title a:visited span.icon{
	background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/acc_open.png') center center no-repeat;
	display:inline-block;
	width:24px;
	height:24px;
	margin-right:20px;
}
.sh_acc_item_title a:hover span.icon,
.sh_acc_item_title a:active span.icon{
	background-color:<?php echo $colorFirstTint; ?>;
}
.sh_acc_item{
	margin:0 20px 20px 20px;
	padding:20px 0 0 0;
	border-top:1px solid <?php echo $colorThemeBorder; ?>;
}
a.sh_acc_item_title_opened:link span.icon,
a.sh_acc_item_title_opened:visited span.icon,
a.sh_acc_item_title_opened:hover span.icon,
a.sh_acc_item_title_opened:active span.icon{
	background:<?php echo $colorFirstTint; ?> url('<?php echo $prfx; ?>images/acc_close.png') center center no-repeat;
}
.sh_tab_item{
	display:none;
}
.sh_tab_wrapper{
	clear:both;
	border: 1px solid <?php echo $colorThemeBorder; ?>;
	padding: 20px;
	position:relative;
	top:-4px;
}
.sh_tabs_menu{ 
	margin: 0;
	padding: 0;
	list-style: none;
	clear:both;
}
.sh_tabs_menu li{
	float:left;
}
a.sh_tab_title:link,
a.sh_tab_title:visited{
	-moz-transition: none;
	transition: none;
	-webkit-transition: none;
	-o-transition: none;
	
	display:block;
	padding:10px 15px;
	cursor:pointer;
	color: <?php echo $colorThemeBorder;?>;
	text-decoration:none;
	font-family:<?php echo $headerFont; ?>;
	font-size: 16px;
	border-style:solid solid none solid;
	border-width:1px;
	border-color:<?php echo $colorThemeBorder; ?>;
}
a.sh_tab_title:hover,
a.sh_tab_title:active{
	color: <?php echo $colorFirst?>;
}
a.sh_tab_title_active:link,
a.sh_tab_title_active:visited{
	padding:12px 12px;
	color:<?php echo $colorFirst; ?>;
	position:relative;
	top:-4px;
	font-family: <?php echo $headerFont; ?>;
	border-right:1px solid <?php echo $colorThemeBorder; ?>;
	border-left:1px solid <?php echo $colorThemeBorder; ?>;
}
.sh_tabs_menu li:first-child a{
	border-left:1px solid <?php echo $colorThemeBorder; ?>;
}
.sh_tabs_menu li:last-child a{
	border-right:1px solid <?php echo $colorThemeBorder; ?>;
}
div.sh_image{
	display:inline-block;
	padding:4px; 
	-moz-box-shadow: 	0px 0px 1px 2px rgba(0,0,0,.10);
	-webkit-box-shadow: 0px 0px 1px 2px rgba(0,0,0,.10);
	box-shadow: 		0px 0px 1px 2px rgba(0,0,0,.10);
	border:1px solid #fff;
	margin:10px;
}
div.sh_image a{
	margin:0px;
	padding:0px;
	display:inline-block;
}
div.sh_image_border a:link,
div.sh_image_border a:visited{
	margin:10px;
	display:inline-block;
	border: 3px solid <?php echo $colorThemeBorder; ?>;
}
div.sh_image_border a:hover,
div.sh_image_border a:active{
	border: 3px solid <?php echo $colorSecond; ?>;
}

ul.sh_list{ list-style:none;} 
ul.sh_list li{ text-indent: 25px; line-height:1.5em; list-style:none;}

#filter{
	list-style:none;
	margin-left:20px;
	padding-bottom:40px;
}
#filter li{
	float:left;
	display:inline-block;
	margin-right:5px;
}
#filter li a:link, #filter li a:visited{
	display:block;
	padding:3px 11px;
	border-radius: 10px 10px 10px;
	text-transform:uppercase;
	background-color: <?php echo $colorInverse; ?>;
	color: <?php echo $colorFont; ?>;
	border:none;
}
#filter li a:hover, #filter li a:active, #filter li a.selected{
	text-decoration:none;
	background-color: <?php echo $colorBox; ?>;
	color: <?php echo $colorInverse; ?>;
}



.blog-meta{
	display:inline-block;
	margin:12px 0 0 10px;
}

.blog_wrapper{
	cursor:pointer;
	overflow:hidden;
	position:absolute;
	left:5px;
	top:5px;	
}

.sh_lastpost_container{
	position:relative;
}
.sh_lastpost_wrapper{
	cursor:pointer;
	overflow:hidden;
	position:absolute;
	left:5px;
	top:5px;
}
.innerCaption, .innerCaptionUp{
	text-decoration:none;
	text-transform:uppercase;
	line-height:16px;
	text-align:center;
	font-family: <?php echo $headerFont; ?>;
	font-size:16px;
	color: #fff;
	position: absolute;
	bottom:0;
	padding:10px 10px;
}
.innerBg, .innerBgUp{
	position: absolute;
	background-color:#000;
	opacity:0;
	filter: alpha(opacity=0);
	zoom:1;
}
.innerReadMore{
	position:absolute;
	bottom: 20px;
	opacity:0;
	filter: alpha(opacity=0);
	zoom:1;
}
.carouselHeader{
	height:40px;
}
.carouselHeader h3{
	margin:11px 0 0 0;
	display:inline-block;
	float:left;
	font-size:14px;
	color: <?php echo $colorFirst;?>;
}
.list_carousel {
	margin: 0;
} 
.list_carousel ul {
	margin: 0;
	padding: 0;
	list-style: none;
	display: block;
}
.list_carousel li {
	display: block;
	float: left;
}

div.pagercarousel{
	display:inline-block;
	float:right;
	margin-top:8px;
}
div.pagercarousel a{
	background-color: <?php echo $colorBox?>;
	color:<?php echo $colorInverse; ?>;
	border:none;
    display: inline-block;
    line-height:24px;
	text-align:center;
	height: 24px;
    margin-left: 1px;
    width: 24px;
	text-decoration:none;
}
div.pagercarousel a:hover{
	background-color: <?php echo $colorSecond;?>;
	color: <?php echo $colorSecondInverse;?>;
	box-shadow:0 0 10px <?php echo $colorSecond; ?>;
	position:relative;
	z-index:99999;
}
div.pagercarousel a span{
	line-height:24px;
	color: <?php echo $colorSecondInverse; ?>;
} 
div.pagercarousel a:hover span{
	color: <?php echo $colorSecondInverse; ?>;
}
div.pagercarousel a.selected, div.pagercarousel a.selected:hover{ background-color: <?php echo $colorSecond;?>; box-shadow:none; }
div.pagercarousel a.selected span, div.pagercarousel a.selected:hover span{ color: <?php echo $colorSecondInverse; ?>; }

a.nextcarousel:link, a.nextcarousel:visited, 
a.prevcarousel:link, a.prevcarousel:visited{
	float:right;
    display: inline-block;
	color: <?php echo $colorInverse; ?>;
	text-decoration:none;
	text-align:center;
	width:24px;
	height:24px;
	line-height:24px;
	border:none;
	text-indent:-99999px;
}

a.nextcarousel:link, a.nextcarousel:visited{
	background:<?php echo $colorBox;?> url("<?php echo $prfx; ?>images/slider_arrow_right.png") center center no-repeat scroll;
}
a.prevcarousel:link, a.prevcarousel:visited{
	background:<?php echo $colorBox;?> url("<?php echo $prfx; ?>images/slider_arrow_left.png") center center no-repeat scroll;
}

a.nextcarousel:hover, a.nextcarousel:active, 
a.prevcarousel:hover, a.prevcarousel:active{
	background-color: <?php echo $colorSecond;?>;
	color: <?php echo $colorSecondInverse; ?>;
	box-shadow:0 0 10px <?php echo $colorSecond; ?>;
	position:relative;
	z-index:99999;
}
a.prevcarousel, a.nextcarousel{
	margin-top: 8px;
}
a.nextcarousel{
	margin-right:0px;
	margin-left:1px;
}

div.sh_toggle{
	clear:both;
}
div.sh_toggle_text a:link,
div.sh_toggle_text a:visited{
	color:<?php echo $colorBoxInverse; ?>;
	font-size: 12px;
	text-transform:uppercase;
	text-decoration: none;
	border:none;
}
.sh_toggle_text{
	display:inline-block;
	padding: 3px 8px 4px 20px;
	background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/toggle_closed.png') 6px 9px no-repeat;
	cursor:pointer;
}
.sh_toggle_text_opened{
	background:<?php echo $colorBox; ?>  url('<?php echo $prfx; ?>images/toggle_opened.png') 7px 8px no-repeat;
	cursor:pointer;
}
.sh_toggle_content{
	display:none;
}
ul.sh_post{
	list-style:none;
}
ul.sh_post li{
	padding:5px 0 10px 0;
	border-bottom: 1px solid <?php echo $colorThemeBorder; ?>;
	background:url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') left bottom repeat-x;
}
ul.sh_post li:last-child{
	border-bottom: none; 
}
ul.sh_post li:first-child{
	padding-top:0;
}
a.sh_post_more:link,
a.sh_post_more:visited,
a.sh_post_more_border:link,
a.sh_post_more_border:visited,
#comments .reply a:link,
#comments .reply a:visited
{
	display:inline-block;
	float:right;
	font-size:12px;
	padding:3px 8px 4px 8px;
	text-transform:uppercase;
	background-color: <?php echo $colorBox ;?>;
	color: <?php echo $colorBoxInverse ;?>;
	border:none;
}
#comments .reply a:link,
#comments .reply a:visited{
	margin-top:20px;
	margin-bottom:20px;
}
#comments ol ul .reply a:link,
#comments ol ul .reply a:visited{}
a.sh_post_more:hover,
a.sh_post_more:active,
a.sh_post_more_border:hover,
a.sh_post_more_border:active,
#comments .reply a:hover,
#comments .reply a:active{
	text-decoration:none;
	color: <?php echo $colorSecondInverse ;?>;
	background-color:<?php echo $colorSecond; ?>;
    box-shadow: 0px 0px 10px <?php echo $colorSecond; ?>;
	z-index:5000;
	position:relative;
}


a.sh_lastpost_title:link,
a.sh_lastpost_title:visited{
	display:block;
	font-family: <?php echo $headerFont ?>;
	color: <?php echo $colorFirst; ?>;
	border:none;
	font-size: 12px;
}
.sh_lastpost_content{
}
a.sh_lastpost_title:hover,
a.sh_lastpost_title:active{
	color: <?php echo $colorFont; ?>;
	text-decoration:none;
}

.sh_lastpost_categories a:link,
.sh_lastpost_categories a:visited{
	text-decoration:none;
	color:<?php echo $colorFont; ?>;
	border:none;
}

.sh_lastpost_categories a:hover,
.sh_lastpost_categories a:active{
	color:<?php echo $colorFirst; ?>;
}

.sh_lastpost_bottom a:link,
.sh_lastpost_bottom a:visited{
	text-decoration:none;
	color:<?php echo $colorThemeBorder; ?>;
	border:none;
}
.sh_lastpost_bottom a:hover,
.sh_lastpost_bottom a:active{
	color:<?php echo $colorFont; ?>;
}
.sh_lastpost_bottom{
	color:<?php echo $colorThemeBorder; ?>;
}

.vSpace10{
	width:10px;
	height:10px;
	float:left;
}

.box{
}
.boxinside{
min-height:36px;
height:auto !important;
height:36px;
}
.boxinsideNoicon{
}
.boxinside a:link,
.boxinside a:visited,
.boxinside *{
	color:#ffffff;
	border-bottom-color:#ffffff;
}

.boxinside a:hover,
.boxinside a:active{
	border-bottom:none;
}



h4 span.sh_headersub{font-size:14px; top:0px;}
h2 span.sh_headersub{font-size:16px; top:0px;}

input.searchbox{
	float: left;
	text-indent: 10px;
	width:192px;
	background-color: <?php echo $colorBox; ?>;
	color: <?php echo $colorBoxInverse; ?>;
	height: 28px;
	line-height:28px;
	vertical-align: middle; 
	border-radius:0px;
}
.searchbutton,
.searchbutton:visited,
.searchbutton:link{
	display:block;
	float: left;
	width:28px;
	height:28px;
	font-size:0px;
	background: <?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/search_arrow.png') center center no-repeat;
	border:none;
	text-indent:-9999px;
}

#topPopup, #bottomPopup{
	margin:0 auto; 
	position:relative;
	background-color:<?php echo $colorBox; ?>;
	color:<?php echo $colorInverse; ?>;
	text-align:left;
}
#topPopupOpenner:visited,
#topPopupOpenner:link,
#bottomPopupOpenner:visited,
#bottomPopupOpenner:link{
	display:block;
	position:absolute;
	right:0px;
	bottom:-24px;
	width:24px;
	height:24px;
	background-color:<?php echo $colorBox;?>;
	border:none;
}
#topPopupOpenner:hover,
#topPopupOpenner:active,
#bottomPopupOpenner:hover,
#bottomPopupOpenner:active{
	background-color:<?php echo $colorSecond; ?>;
	box-shadow:0 0 10px <?php echo $colorSecond; ?>;
}
#bottomPopupOpenner:visited,
#bottomPopupOpenner:link{
	bottom:auto;
	top:-24px;
}
#topPopupWrapper,
#bottomPopupWrapper{
	display:none;
	padding:20px;
}

#bottomPopup .widget_text *, #topPopup .widget_text *{
	font-family:<?php echo $headerFont; ?>;	
}
#bottomPopup *, #topPopup *{
	color: <?php echo $colorBoxInverse; ?>;
}
.openicon{ background: url('<?php echo $prfx; ?>images/light-openicon.png') no-repeat center center; }
.closeicon{ background: url('<?php echo $prfx; ?>images/light-closeicon.png') no-repeat center center; }

.popupLeft{
	display:inline-block;
	float:left;
	text-align:left;
}
.popupRight{
	display:inline-block;
	float:right;
	text-align:right;
}
#sec-selector, #sec-selector option{
	font-family:<?php echo $headerFont; ?>;
	font-size:<?php echo $menuFontSize; ?>;
	background-color:<?php echo $colorMenu; ?>;
	color:<?php echo $colorMenuFont; ?>;
	border:1px solid <?php echo $colorMenuBorder; ?>;
}
#sec-selector option{
	border:none;
	border-top:1px solid <?php echo $colorMenuBorder; ?>;
	padding:0 10px;
}

/*960px Elements*/
.pp_pic_holder a {
	border:none;
	-moz-transition: none;
	transition: none;
	-webkit-transition: none;
	-o-transition: none;
}
#portfolioWrapper{clear:both; float:none; width:100%;}
.sh_post{width:960px;}
.sh_post li{ float:left; width:220px;}
.content-full-width{ width: 940px;  }
#header-container{width:940px; margin:0 auto;  /*background-color:rgba(255,255,255,0.9);*/ padding:0 20px;}
#wrapper{width:940px;}
#footer{width:940px;}
#page-title-wrapper{width:940px;}
.content-with-sidebar{ width:700px;}
.left-col-with-sidebar{	width:700px;}
.page-content{ 	width: 940px;  }
#main-menu .menu-dropdown{display:none;}
#right-col{ width:220px;}
.portfolioWithSidebar{width:720px;}
.portfolioWithoutSidebar{width:960px;}
#portfoliodetail{
	display:none; 
	margin-top:20px; 
	clear:both;
	background:url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png') left bottom repeat-x;
}
#portfoliodetail h5{ margin-bottom:0px; }
.portfoliodetail_withSidebar{ width:700px; float:left;}
.portfoliodetail_withoutSidebar{ float:left; width:940px; }
	
.galleryWithSidebar{width:720px;} 
.galleryWithoutSidebar{width:960px;}

.sh_1of1, .sh_1of2, .sh_1of3,
.sh_2of3, .sh_1of4, .sh_2of4,
.sh_3of4, .sh_1of5, .sh_2of5,
.sh_3of5, .sh_4of5, .sh_1of6,
.sh_2of6, .sh_3of6, .sh_4of6,
.sh_4of6, .sh_5of6{ 
	float:left;
	margin: 0 20px 20px 0;
}

.sh_1of1 { width:940px; }
.sh_1of2 { width:460px; }
.sh_1of3 { width:300px; }
.sh_2of3 { width:620px; }
.sh_1of4 { width:220px; }
.sh_2of4 { width:460px; }
.sh_3of4 { width:700px; }
.sh_1of5 { width:172px; }
.sh_2of5 { width:364px; }
.sh_3of5 { width:556px; }
.sh_4of5 { width:748px; }
.sh_1of6 { width:140px; }
.sh_2of6 { width:300px; }
.sh_3of6 { width:460px; }
.sh_4of6 { width:620px; }
.sh_5of6 { width:780px; }

.w-1	{width:980px;}
.w-3-4	{width:700px;}

/* Tablet Portrait 768-960 */
@media only screen and (min-width: 768px) and (max-width: 959px) {
	.w-1{width:768px;}
	.w-3-4{width:556px;}
	#bodywrapper{width:768px;}
	#wrapper { padding:0 10px;}
	.content-full-width { width: 748px; }
	#header { width:748px; }
	#header-container{width:748px; padding:0 10px; }
	.page-content{ width: 748px; }
	#wrapper{width:748px;}
	#footer{width:748px;}
	#page-title-wrapper{width:748px;}
	#right-col, #right-col ul li{ width:172px;}
	.content-with-sidebar{ width:556px;}
	.left-col-with-sidebar{	width:556px;}
	#main-menu .menu-dropdown{display:none;}
	input.searchbox{width:144px;}
	.page-title-wa-container{width:172px;}
	.blogimage .image_frame img{width:321px;}
	.blogimage {width:321px;}
	.blogcontent{ width:215px; }
	.portfolioWithSidebar{width:576px;}
	.portfolioWithoutSidebar{width:768px;}
	.galleryWithSidebar{width:576px;}
	.galleryWithoutSidebar{width:768px;}
	.portfoliodetail_withSidebar{ width:556px;}
	.portfoliodetail_withoutSidebar{width:748px;}
	.sh_post{width:768px;}
	.sh_post li{ float:left; width:172px;}
	.sh_post li .sh_lastpost_imagelink img {width:172px;}
	
	.c3columns_withSidebar > li { width:172px; }
	.c3columns_withSidebar li img{ width:172px; }
	.c4columns_withSidebar > li{ width:124px;}
	.c4columns_withSidebar li img{ width:124px;}
	.c5columns_withSidebar > li{ width:95px;}
	.c5columns_withSidebar li img{ width:95px;  }
	.c6columns_withSidebar > li{ width:76px;}
	.c6columns_withSidebar li img{ width:76px; }
	
	.c3columns_withoutSidebar > li{ width:236px;}
	.c3columns_withoutSidebar li img{ width:236px;}
	.c4columns_withoutSidebar > li{ width:172px;}
	.c4columns_withoutSidebar li img{ width:172px;}
	.c5columns_withoutSidebar > li{ width:133px;}
	.c5columns_withoutSidebar li img{ width:133px;}
	.c6columns_withoutSidebar > li{ width:108px;}
	.c6columns_withoutSidebar li img{ width:108px;}
	
	.sh_1of1, .sh_1of2, .sh_1of3, .sh_2of3, .sh_1of4, .sh_2of4, .sh_3of4, .sh_1of5, .sh_2of5,
	.sh_3of5, .sh_4of5, .sh_1of6, .sh_2of6, .sh_3of6, .sh_4of6,	.sh_4of6, .sh_5of6{ 
		float:left;
		margin: 0 20px 20px 0;
	}
	
	.sh_1of1 { width:748px; }
	.sh_1of2 { width:364px; }
	.sh_1of3 { width:236px; }
	.sh_2of3 { width:492px; }
	.sh_1of4 { width:172px; }
	.sh_2of4 { width:364px; }
	.sh_3of4 { width:556px; }
	.sh_1of5 { width:133px; }
	.sh_2of5 { width:286px; }
	.sh_3of5 { width:439px; }
	.sh_4of5 { width:592px; }
	.sh_1of6 { width:108px; }
	.sh_2of6 { width:236px; }
	.sh_3of6 { width:364px; }
	.sh_4of6 { width:492px; }
	.sh_5of6 { width:620px; }		
}

/* Mobile Portrait 320 */
@media only screen and (max-width: 767px){
	#bodywrapper{width:320px;}
	.content-full-width { width: 300px; }
	.page-content{ width: 300px; }
	.w-1{width:320px;}
	.w-3-4{width:300px;}
	#header { width:300px; }
	#header-container{width:300px; padding:10px 0; }
	.page-content{ width: 300px; }
	#wrapper{width:300px; padding:10px 0;}
	#footer{width:300px;}
	#logo{margin:0 auto; display:block; float:none;}
	#page-title-wrapper{width:300px; padding:10px 0;}
	#page-title-wrapper h1{ display:block; float:none;}
	#page-title-wrapper .page-title-wa-container{ display:block; float:none;}
	#right-col{ width:auto; margin:20px 0 0 0;}
	#right-col ul li:last-child div:last-child{background-image:none; }
	.content-with-sidebar{ width:300px;}
	.left-col-with-sidebar{	width:300px;}
	#right-col ul li{ width:300px; }
	#main-menu .menu-dropdown{display:block;}
	#main-menu .menu-header{display:none;}
	#main-menu{ display:block;  width:300px;}
	#main-menu{ margin:20px auto;}
	.blogimage { width:300px; }
	.blogimage .image_frame img{width:300px;}
	.blogcontent{ width:100%; margin:20px 0 0 0;}
	.portfolioWithSidebar{width:320px;}
	.portfolioWithoutSidebar{width:320px;}
	.galleryWithSidebar{width:320px;}
	.galleryWithoutSidebar{width:320px;}
	.portfoliodetail_withSidebar{ width:300px;}
	.portfoliodetail_withoutSidebar{width:300px;}
	#footer-wrapper .footer-wa-container{ min-height:0; }
	.popupRight{clear:both; float:left; text-align:left; margin-top:20px;}
	.sh_post{width:320px;}
	.sh_post li{ float:left; width:140px;}
	.sh_post li .sh_lastpost_imagelink img {width:140px;}
	
	.c3columns_withSidebar > li,
	.c3columns_withoutSidebar > li,
	.c4columns_withSidebar > li,
	.c4columns_withoutSidebar > li,
	.c5columns_withSidebar > li,
	.c5columns_withoutSidebar > li,
	.c6columns_withSidebar > li,
	.c6columns_withoutSidebar > li
	{ width:140px; }
	
	.c3columns_withSidebar li img,
	.c3columns_withoutSidebar li img,
	.c4columns_withSidebar li img,
	.c4columns_withoutSidebar li img,
	.c5columns_withSidebar li img,
	.c5columns_withoutSidebar li img,
	.c6columns_withSidebar li img,
	.c6columns_withoutSidebar li img
	{ width:140px;}
	
	.sh_1of1, .sh_1of2, .sh_1of3, .sh_2of3, .sh_1of4, .sh_2of4, .sh_3of4, .sh_1of5, .sh_2of5, .sh_3of5, 
	.sh_4of5, .sh_1of6,	.sh_2of6, .sh_3of6, .sh_4of6, .sh_4of6, .sh_5of6{
		float:left;
		margin: 0 0 20px 0;
		width:300px;
	}
}

/* Mobile Landscape 480 */
@media only screen and (min-width: 460px) and (max-width: 767px) {
	#bodywrapper{width:480px;}
	.content-full-width { width: 460px; }
	.page-content{ width: 460px; }
	.w-1{width:480px;}
	.w-3-4{width:460px;}
	#header { width:460px; text-align:center; }
	#header-container{width:460px; }
	.page-content{ width: 460px; }
	#wrapper{width:460px;}
	#footer{width:460px;}
	#logo{margin:0 auto; float:none; }
	#page-title-wrapper{width:460px; float:none; clear:both;}
	
	#page-title-wrapper h1{ display:block; float:none;}
	#page-title-wrapper .page-title-wa-container{ display:block; float:none;}
	#right-col{ width:460px; margin:20px 0 0 0; }
	.content-with-sidebar{ width:460px;}
	.left-col-with-sidebar{	width:460px;}
	#right-col ul li{ width:460px; }
	#main-menu .menu-dropdown{display:block;}
	#main-menu .menu-header{display:none;}
	#main-menu{ display:block;  width:460px;}
	.blogimage{width:460px;}
	.blogimage .image_frame img{width:460px; }
	.blogcontent{ width:100%; margin:20px 0 0 0;}
	.portfolioWithSidebar{width:480px;}
	.portfolioWithoutSidebar{width:480px;}
	.galleryWithSidebar{width:480px;}
	.galleryWithoutSidebar{width:480px;}
	.portfoliodetail_withSidebar{ width:460px;}
	.portfoliodetail_withoutSidebar{width:460px;}
	.sh_post{width:480px;}
	.sh_post li{ float:left; width:220px;}
	.sh_post li .sh_lastpost_imagelink img {width:220px;}
	
	.c3columns_withSidebar > li,
	.c3columns_withoutSidebar > li,
	.c4columns_withSidebar > li,
	.c4columns_withoutSidebar > li,
	.c5columns_withSidebar > li,
	.c5columns_withoutSidebar > li,
	.c6columns_withSidebar > li,
	.c6columns_withoutSidebar > li
	{ width:140px; }
	
	.c3columns_withSidebar li img,
	.c3columns_withoutSidebar li img,
	.c4columns_withSidebar li img,
	.c4columns_withoutSidebar li img,
	.c5columns_withSidebar li img,
	.c5columns_withoutSidebar li img,
	.c6columns_withSidebar li img,
	.c6columns_withoutSidebar li img
	{ width:140px;}
	
	.sh_1of1, .sh_1of2, .sh_1of3, .sh_2of3, .sh_1of4, .sh_2of4, .sh_3of4, .sh_1of5, .sh_2of5, .sh_3of5, 
	.sh_4of5, .sh_1of6,	.sh_2of6, .sh_3of6, .sh_4of6, .sh_4of6, .sh_5of6{
		float:left;
		margin:0 0 20px 0;
		width:460px;
	}
}
.column_end { clear:right; margin-right:0px; }

.sh_highlight_text{
	color: <?php echo $colorFirstTint; ?>;
}

.logos li{
	position:relative;
	list-style:none;
	float:left;
	margin:0;
}
.logos a:link, 
.logos a:visited{ border:none; }

hr.bar{
	display:block;
	height:5px;
	background:url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png');
}

hr.mborder{
	text-align:left;
	display:block;
	height:1px;
	font-size:0px;
	width:20px;
	margin:20px 0 20px 0;
	background: url("<?php echo $prfx; ?>images/<?php echo $theme_style;?>-half-border.png") no-repeat scroll left top transparent;
}

.sh_teaser, .sh_teaser span{
	font-family: <?php echo $headerFont ?>;
	font-size:22px;
	line-height:1.2em;
}

div.sh_hr{
	width:100%;
	height:10px;
	line-height:0px;
	font-size:0px;
	clear:both;
}

div.sh_seperator{
	width:100%;
	background:url('<?php echo $prfx; ?>images/<?php echo $theme_style;?>-bar-pattern.png');
	height:5px;
	margin:0;
	line-height:0px;
	font-size:0px;
	clear:both;
}

div.sh_seperator_header{
	text-align:center;
	width:100%;
	background:url('<?php echo $prfx; ?>images/seperatorbg.png') repeat-x left center;
	margin:0;
	clear:both;
}
div.sh_seperator_header h4{
	display:inline-block;
	margin:0;
	padding:2px 4px;
}

.quotes-one{
	margin-left:20px;
	border-left:3px solid <?php echo $colorBox; ?>;
	padding-left:20px;
}
.quotes-two{
	padding-left:35px;
	background: url('<?php echo $prfx; ?>images/<?php echo $theme_style; ?>-quote-bg.png') 0px 5px no-repeat;
}
.dropcap, .dropcapcircle{
	text-align:center;
	display:block;
	float:left;
	font-size:28px;
	line-height:40px;
	width:40px;
	font-family: <?php echo $headerFont; ?>;
	background-color: <?php echo $colorBox; ?>;
	color:<?php echo $colorBoxInverse; ?>;
	padding:0 0 2px 0;
	margin:10px 15px 0 0;
}
.dropcapcircle{ border-radius:50%; }
.quotes-writer{color:<?php echo $colorThemeBorder;?>;}
.right{float:right; margin:5px 0 5px 15px;}
.left{float:left; margin:5px 15px 5px 0px;}
span.highlight {background-color:<?php echo $colorFirstTint; ?>; color:<?php echo $colorBoxInverse; ?>; padding:0px 5px;}
span.textlight {color:<?php echo $colorFirst; ?>;}

.meta-tips{
	position:absolute;
	color:<?php echo $colorBoxInverse; ?>;
	padding:5px 10px;
	background-color:<?php echo $colorBox; ?>;
}
.meta-tips span{
	display:block;
	width:10px;
	height:10px;
	position:absolute;
	bottom:-6px;
	right:0px;
}
.meta-tips span svg polygon{
	fill:<?php echo $colorBox; ?>;
}

/* Flex Slider Direction */
.flex-direction-nav li a {width: 24px; height: 24px; display: block; position: absolute; top: 40px; cursor: pointer; text-indent: -9999px; border:none; }
.flex-direction-nav li a:hover{ background-color:<?php echo $colorSecond; ?>; box-shadow:0 0 10px <?php echo $colorSecond; ?>;}
.flex-direction-nav li .next {background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/slider_arrow_right.png') center center no-repeat; right: 40px;}
.flex-direction-nav li .prev {background:<?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/slider_arrow_left.png') center center no-repeat; right: 65px;}
.flex-direction-nav li .disabled {opacity: .3; filter:alpha(opacity=30); cursor: default;}

div.sh_item_two_one{
	float:left;
	width:25%;
	padding:15px 5px;
	vertical-align:top;
}
div.sh_item_two_two{
	float:left;
	width:65%;
	margin-left:10px;
	padding:15px 5px;
	border-bottom: 1px solid <?php echo $colorThemeBorder; ?>;
	vertical-align:top;
}
.sh_item_two_two a:link,
.sh_item_two_two a:visited{
	border:none;
}


/*Image Animate*/
.hoverWrapperBg{
	opacity:.50;
	background:url("<?php echo $prfx; ?>images/<?php echo $theme_style; ?>-image-pattern.png");
	position:absolute;
	width:100%;
	left:0px;
	top:0px;
}
.image_frame{
	position:relative;
	cursor:pointer;
}
.image_frame > a{
	display:block;
	padding:0;
	margin:0;
	font-size:0px;
	border:none;
}
.hoverWrapper{
	position:absolute;
	width:100%;
	left:0;
	top:0;
}

.hoverWrapperLink, .hoverWrapperModal{
	display:block;
	opacity:0;
	<?php if(!$demo) { ?>
	filter: alpha(opacity = 0);
	<?php } ?>
	width:32px;
	height:32px;
	position:absolute;
	background: <?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/light-anchor-icon.png') center center no-repeat;
}
.hoverWrapperModal{ background: <?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/light-zoom-icon.png') center center no-repeat; }
.hoverWrapperVideo{ background: <?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/light-video-icon.png') center center no-repeat; }
.hoverWrapperGallery{ background: <?php echo $colorBox; ?> url('<?php echo $prfx; ?>images/light-gallery-icon.png') center center no-repeat; }