<?php
global $sidebarPos;
if($sidebarPos=='Left'){ ?>
<style type="text/css">
/* Sidebar Left Position Css*/
#content{
	float:right;
}
#right-col{
	float:left;
	margin-left:0;
	margin-right:20px;
}
</style>
<?php } ?>
<aside id="right-col">
<hr class="bar"/>
<ul>
	<?php 
	if(!is_front_page() && is_active_sidebar('first-general-wa')){
		echo '<li>'; dynamic_sidebar('first-general-wa'); echo "</li>";}
		
	if($sidebarPos=='Left' && is_active_sidebar('left-general-wa')){
		echo '<li>'; dynamic_sidebar('left-general-wa'); echo "</li>";}
		
	if($sidebarPos=='Right' && is_active_sidebar('right-general-wa')){
		echo '<li>'; dynamic_sidebar('right-general-wa'); echo "</li>";}
	
	if(is_front_page() && is_active_sidebar('front-page-wa')){
		echo "<li>"; dynamic_sidebar('front-page-wa'); echo "</li>";}
		
	if(is_single() && is_active_sidebar('single-wa')){
		echo "<li>"; dynamic_sidebar('single-wa'); echo "</li>";}
		
	if(is_page() && is_active_sidebar('page-wa')){
		echo "<li>"; dynamic_sidebar('page-wa'); echo "</li>";}
		
	if(is_category() && is_active_sidebar('category-wa')){
		echo "<li>"; dynamic_sidebar('category-wa'); echo "</li>";}
		
	if(is_tag() && is_active_sidebar('tag-wa')){
		echo "<li>"; dynamic_sidebar('tag-wa'); echo "</li>";}
		
	if(is_author() && is_active_sidebar('author-wa')){
		echo "<li>"; dynamic_sidebar('author-wa'); echo "</li>";}
		
	if(is_date() && is_active_sidebar('date-wa')){
		echo "<li>"; dynamic_sidebar('date-wa'); echo "</li>";}
		
	if(is_archive() && is_active_sidebar('archive-wa')){
		echo "<li>"; dynamic_sidebar('archive-wa'); echo "</li>";}
		
	if(is_search() && is_active_sidebar('search-wa')){
		echo "<li>0"; dynamic_sidebar('search-wa'); echo "</li>";}
	 
	if(is_active_sidebar('last-general-wa')){
		echo "<li>"; dynamic_sidebar('last-general-wa'); echo "</li>";}
	?>
</ul>
</aside>