<?php 
get_header();
	if(!have_posts()){
		getNotFoundPage(__('No results were found for your keywords. Please try again with another keyword.','rb'), true);
	 }else{ 
		get_template_part('loop','search');
	}
get_footer(); 
?>
