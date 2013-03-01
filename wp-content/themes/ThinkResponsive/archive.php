<?php 
get_header(); 
if(!have_posts()){
	 getNotFoundPage(__('May be searching will help.','rb'), true);
}else{
	rewind_posts();
	get_template_part('loop','archive');
}
get_footer(); 
?> 
