jQuery(document).ready(function() {
	jQuery('.uploadBtnToURL').click(function() {
		var targetElement = jQuery(this).attr('rel');
		window.send_to_editor = function(html) 
		{
			imgurl = jQuery('img',html).attr('src');
			jQuery('#'+targetElement).val(imgurl);
			tb_remove();
		}
		tb_show('', 'media-upload.php?post_id=1&amp;type=image&amp;TB_iframe=true');
		return false;
	});
});