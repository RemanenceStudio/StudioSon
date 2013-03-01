<?php
add_action('admin_menu', 'add_control_panel'); 
function add_control_panel()
{
	add_menu_page('RB Panel', __('RB Admin', 'rb'), 'manage_options', 'top-level-menu-action', 'RBsettings', '','64');
	add_action( 'admin_init', 'reg_settings' );  
}

function create_backgrounds_table(){
global $wpdb;
$prf = $wpdb->prefix;
$create_query = <<<EOT
CREATE TABLE `{$prf}backgrounds` (
  `IMAGEID` int(11) NOT NULL auto_increment,
  `GALLERYID` bigint(20) unsigned NOT NULL,
  `SLIDERORDER` int(11) unsigned NOT NULL,
  `EXT` varchar(255) NOT NULL,
  `CAPTION` text,
  `DESCRIPTION` mediumtext NOT NULL,
  `TYPE` varchar(20) default NULL,
  `CONTENT` text,
  `THUMB` text,
  `WIDTH` int(11) default NULL,
  `HEIGHT` int(11) NOT NULL,
  PRIMARY KEY  (`IMAGEID`),
  KEY `GALLERYID` (`GALLERYID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
EOT;
$create = $wpdb->get_results($create_query);
}

function create_galleries_table(){
global $wpdb;
$prf = $wpdb->prefix;
$create_query = <<<EOT
CREATE TABLE `{$prf}galleries` (
  `GALLERYID` int(10) unsigned NOT NULL auto_increment,
  `GALLERYNAME` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`GALLERYID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
EOT;
$create = $wpdb->get_results($create_query);
}

//Check Tables
if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}backgrounds'") != $wpdb->prefix.'backgrounds')
	create_backgrounds_table();
if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}galleries'") != $wpdb->prefix.'galleries')
	create_galleries_table();

function reg_settings()
{
	global $SettingsOptions;
	foreach($SettingsOptions as $sm){
		if($sm['type'] == 'fields'){
			foreach($sm['fields'] as $field){
				register_setting( 'rbsettings', $field['id']);
				if(get_option($field['id'])=='' && !empty($field['default'])){
					update_option($field['id'], $field['default']);
				}
			}
		}
	}
		
	// Define Google Web Fonts
	register_setting('rbsettings', 'fonts');
	if(get_option('fonts')=='' || isset($_GET['updatefonts']))
	{
		$googleFonts = @file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBgeqKlFdYj3Y7VwmrEXnXzpnx5TfKXG4o');
		if(empty($googleFonts))
		{
			include 'googleFontList.php';
			$googleFonts = $googleFontList;
		}
		update_option('fonts', $googleFonts);
	}
	
}


function RBsettings()
{
global $wpdb, $SettingsOptions;
$pURL = str_replace('http://'.$_SERVER['SERVER_NAME'],'',get_template_directory_uri());
$fonts = json_decode(get_option('fonts'));
?>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/ibutton/jquery.ibutton.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/ibutton/jquery.ibutton.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/colorpicker/js/colorpicker.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/includes/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript">
	var settingsVar = new Array();
	<?php
		foreach($SettingsOptions as $sm){
			if($sm['type'] == 'fields'){
				$sv = "settingsVar['".$sm['id']."'] = new Array(";
				foreach($sm['fields'] as $field){
					$sv .= "'".$field['id']."',";
				}
				$sv = substr($sv,0,-1);
				$sv .= "); \n";
				echo $sv;
			}
		}
	?>
	
	var $ = jQuery.noConflict();
	
	function getGalleriesList(){
		showMessage('waiting', '<?php _e('Getting gallery list...','rb'); ?>', 'getgallery');
		$.post(ajaxurl, {'action':'get_gallery_list'}, function(data){
			$('#gallerieslistbody').html(data);
			$('#gallerieslist').slideDown('slow');
			showMessage('successful', '<?php _e('Gallery list has been gotted successfully','rb'); ?>', 'getgallery');
		});	
	}
	
	function closeImageManager(){
		$('#imageManager').stop().animate({opacity:'0'}, 300, function(){
			$(this).hide().css({left:'830px', top:'20px'});
		});
	}
	function getImageManager(){
		showMessage('waiting', '<?php _e('Getting images list...','rb'); ?>', 'getimages');
		$.post(ajaxurl, {'action':'get_images'}, function(data){
			$('#imageList tbody').html(data);
			$('#imageManager').show().css({opacity:'0', left:'830px', top:'20px'}).stop().animate({opacity:'1'}, 300);
			showMessage('successful', '<?php _e('Images list has been gotted successfully','rb'); ?>', 'getimages');
		});	
	}
	function themeCheck(){
		showMessage('waiting', '<?php  _e('Theme checking...','rb'); ?>', 'ctheme');
		$.post(ajaxurl, {'action':'check_theme'}, function(data){
			$('#checktheme').html(data);
			$('#checktheme').slideDown('slow');
			
			var imgTest = $("<img />").attr('src', '<?php echo get_template_directory_uri(); ?>/includes/timthumb.php?src=<?php echo get_template_directory_uri(); ?>/includes/adminimages/timthumb.jpg&w=20&h=20')
                      .load(function() {
                         if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
							$('#timthumbcheck .statusNOK').show();
							$('#timthumbcheck .ErrMessage').show();
							$('#timthumbcheck .ErrInfo').show();
                         } else {
							$('#timthumbcheck .statusOK').show();
                         }
                      })
					  .error(function(){
						$('#timthumbcheck .statusNOK').show();
						$('#timthumbcheck .ErrMessage').show();
						$('#timthumbcheck .ErrInfo').show();
					  });

			
			
			showMessage('successful', '<?php _e('Theme has been checked successfully','rb'); ?>', 'ctheme');
		});	
	}
	
	function detailGallery(no, name){
		closeImageManager();
		$('#rbcontent > div').slideUp('slow');
		$('#gallerydetailid').text(no);
		$('#gallerydetailname').text(name);
		$('#gallerieslistbody').html('');
		getSliderDetail(no);
		
		$("#fileUploadWrapGalleryDetail").html('<div id="fileUploadGalleryDetail">Upload doesnt work. You have a problem with your javascript</div>');
			$("#fileUploadGalleryDetail").uploadify({
				'uploader': '<?php echo get_template_directory_uri(); ?>/includes/uploadify/uploadify.swf',
				'cancelImg': '<?php echo get_template_directory_uri(); ?>/includes/uploadify/cancel.png',
				'script': '<?php echo $pURL ?>/includes/uploadify/upload_background_image.php',
				'multi': true,
				'width': 400,
				'auto': true,
				'wmode': 'transparent',
				'scriptData': {GALLERYID:no},
				'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
				'displayData': 'speed',
				'onComplete'  : function(event, ID, fileObj, response, data) {
					if(response!='1')
						alert(response);
				},
				'onAllComplete':function(event,eventdata){
					getSliderDetail(no);
				}
		});
		
		$('#gallerydetail').slideDown('slow');
	}
	
	function setFrontpageGallery(no){
		if(window.confirm('<?php _e('Are you sure set this item as Front Page Gallery?','rb'); ?>')){
			showMessage('waiting', '<?php _e('Setting gallery as Front Page Gallery...','rb'); ?>', 'setfpgallery');
			$.post(ajaxurl, {'action':'setfp_gallery', 'GALLERYID':no}, function(data){
				data = $.parseJSON(data);
				if(data.status=='OK'){
					$('#gallerieslistbody .settedfp').remove();
					$('#glist_'+no+' td::nth-child(2)').append($(' <span class="settedfp">[Front Page]</span>'));
					showMessage('successful', '<?php _e('Gallery has been setted as front page gallery successfully.','rb'); ?>', 'setfpgallery');
				}else
					showMessage('error', '<?php _e('Have got an error while setting gallery as front page gallery.','rb'); ?>', 'setfpgallery');
			});	
		}
	}
	
	function removeGallery(no){
		if(window.confirm('<?php _e('Are you sure to delete?','rb'); ?>')){
			showMessage('waiting', '<?php _e('Deleteting gallery...', 'rb'); ?>', 'delgallery');
			$.post(ajaxurl, {'action':'delete_gallery', 'GALLERYID':no}, function(data){
				data = $.parseJSON(data);
				if(data.status=='OK'){
					$('#glist_'+no).slideUp('slow', function(){
						$(this).remove();
					});
					showMessage('successful', '<?php _e('Gallery has been deleted successfully','rb'); ?>', 'delgallery');
				}else
					showMessage('error', '<?php _e('Have got an error while deleting gallery.','rb'); ?>', 'delgallery');
			});	
		}
	}
	
	
	jQuery(document).ready(function($){
		
		$('#rbmenu li a').click(function(){
			$(this).parent().parent().find('li').removeClass('selected');
			$(this).parent().addClass('selected');
		});
		
		
		$('#textoptions select[name=headerFont], #textoptions select[name=contentFont]').change(function(){
			loadFontVariants($(this).attr('name'), $(this).val()); 
		});  
		
		$('#addGallery').click(function(){
			var galleryName = window.prompt('<?php _e('Please enter a name','rb');?>', '');
			if(galleryName && $.trim(galleryName)!=''){
				showMessage('waiting', '<?php _e('Creating a new gallery...','rb'); ?>', 'addgallery');
				$.post(ajaxurl, {'action':'add_new_gallery', 'name':$.trim(galleryName)}, function(data){
					data = $.parseJSON(data);
					if(data.status=='OK'){
						$('#gallerieslistbody').append($(data.html));
						showMessage('successful', '<?php _e('New gallery has been created successfully','rb'); ?>', 'addgallery');
					}else
						showMessage('error', '<?php _e('Have got an error while creation new gallery.','rb'); ?>', 'addgallery');
				});
			}
		});
		
		
		$("#uploader").append('<div id="fileUpload">Upload doesnt work. You have a problem with your javascript</div>');
		$("#fileUpload").uploadify({
			'uploader': '<?php echo get_template_directory_uri(); ?>/includes/uploadify/uploadify.swf',
			'cancelImg': '<?php echo get_template_directory_uri(); ?>/includes/uploadify/cancel.png',
			'script': '<?php echo $pURL ?>/includes/uploadify/upload_settings_image.php',
			'multi': true,
			'width': 200,
			'auto': true,
			'wmode': 'opaque',
			'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
			'displayData': 'speed',
			'scriptData': {},
			'onAllComplete':function(){
			},
			'onComplete':function(event,eventdata, fileObj, response, data){
				data = $.parseJSON(response); 
				if(data.status=='OK')
				{
					$('#imageList tbody').prepend(data.html);
				}else{
					alert(data.ERR);
				}
			}
		});
		
		
		/* Gallery Detail*/
		$('#addBg ul li a').click(function(){
			$('#addBg ul li a').removeClass('selected');
			$(this).addClass('selected');
			if($(this).attr('rel')=='video')
			{
				$('#addBg .video').show();
				$('#addBg .image').hide();
			}else{
				$('#addBg .video').hide();
				$('#addBg .image').show();
			}
		});

				
		$('#sliderImageForm').submit(function(){
			showMessage('waiting', '<?php _e('Slider items are saving...','rb'); ?>', 'slideritemssave');
			var serialdata = $(this).serialize();
			serialdata+='&action=save_slider_items';
			$.ajax({
			   type: "POST",
			   url: ajaxurl,
			   data: serialdata,
			   success: function(msg){
				 showMessage('successful', '<?php _e('Slider items has been saved successfuly.','rb'); ?>', 'slideritemssave');
				}
			});
			return false;
		});
		
		$('#addBg .video select').change(function(){
			var videoType = $('#addBg .video select option:selected').val();
			$('#addBg .video .videotype').hide();
			if(videoType=='youtube' || videoType=='vimeo')
				$('#addBg .video .videoid').show();
			else if(videoType=='selfhosted')
				$('#addBg .video .videourl').show();
			else if(videoType=='flash')
				$('#addBg .video .videourl').show();
			
			if(videoType=='youtube' || videoType=='vimeo' || videoType=='selfhosted' || videoType=='flash')
				$('#addBg .video .videowh').show();
		});
		
		$('#addVideo').click(function(){
			var videoType = $('#addBg .video select option:selected').val();
			var videoData = '';
			if(videoType=='youtube' || videoType=='vimeo')
				videoData = $('#addBg .video .videoid input').val();
			else if(videoType=='selfhosted' || videoType=='flash')
				videoData = $('#addBg .video .videourl input').val();
			
			var vW = $('#addBg .video .videowh input[name=width]').val();
			var vH = $('#addBg .video .videowh input[name=height]').val();
			
			if(videoType=='youtube' || videoType=='vimeo' || videoType=='selfhosted' || videoType=='flash')
			{
				if(videoData=='' || vW=='' || vH=='' ){
					alert('<?php _e('You must fill all field','rb'); ?>');
					return;
				}
			}
			
			showMessage('waiting', '<?php _e('Adding your video item...','rb'); ?>', 'additem');
			$.post(ajaxurl, {action:'add_video_item', type:videoType, data:videoData, width:vW, height:vH, GALLERYID:$('#gallerydetailid').text()},function(data){
				data = $.parseJSON(data);
				if(data.status=='OK')
				{
					getSliderDetail(data.GALLERYID);
					showMessage('successful', '<?php _e('New video item has been added successfully.','rb'); ?>', 'additem');
				}
				else
					showMessage('error', '<?php _e('Have been an error while adding video item.','rb'); ?>', 'additem');
			});
			
		});
		
		
		$('#rbmenu ul li:first-child a').trigger('click');
	});
	

	jQuery(document).ready(function($){
	
		locateMsg();
		$(window).bind('resize', function() {
					locateMsg();
				});
		$(window).bind('scroll', function() {
					locateMsg();
				});
	
		$('.colorSelector').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).find('input').val(hex);
				$(el).find('div').css('backgroundColor', '#'+hex);
				$(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor($(this).find('input').val());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		
		$('.colorSelectorControl').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).find('input').val(hex);
				$(el).find('div').css('backgroundColor', '#'+hex);
				$(el).ColorPickerHide();
				setBg($(el).parent().parent());
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor($(this).find('input').val());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		
		$('.bgcontrol select[name=horizontal], .bgcontrol select[name=vertical]').change(function(){
			if($(this).val()=='value')	
				$(this).parent().find("input").show();
			else
			$(this).parent().find("input").hide();
		});

		$('.bgcontrol select').change(function(){
			setBg($(this).parent().parent());
		});

		$('.bgcontrol select, .bgcontrol input').blur(function(){
			setBg($(this).parent().parent());
		});

	});
	
	function locateMsg()
	{					
		var top = $(window).height()+$(window).scrollTop()-100;
		$('#messageArea').css('top', top+'px');
	}
		
	function showMessage(type, message, id)
	{
		if(type=='waiting')
		{
			$('#messageArea').append('<div class="waiting" id="waiting_'+id+'">'+message+'</div>').find('#waiting_'+id).slideDown('slow');
		}
		else if(type=='successful')
		{
			$('#waiting_'+id).slideUp('slow', function(){$(this).remove()});
			$('#messageArea').append('<div class="successful" id="successful_'+id+'">'+message+'</div>').find('#successful_'+id).slideDown('slow').delay(3000).slideUp('slow',function(){$(this).remove();});
		}
		else if(type=='error')
		{
			$('#waiting_'+id).slideUp('slow', function(){$(this).remove()});
			$('#messageArea').append('<div class="error2" id="error_'+id+'">'+message+'</div>').find('#error_'+id).slideDown('slow').delay(3000).slideUp('slow',function(){$(this).remove();});
		}
	}
	
	function saveSettings(objName)
	{
		if(!window.confirm('<?php _e('Are you sure to apply. If you continue all current settings will be change.','rb'); ?>'))
			return false;
		
		var varList ='';
		$('#'+objName+' input[type!=submit], #'+objName+' select').not('.novar').each(function(){
			varList += '&vars[]='+$(this).attr('name');
		});
		
		settingsData = '';
		$.each(settingsVar[objName],function(i,el){
			if($('#'+objName+' input[name='+el+']').length==1)
				if($('#'+objName+' input[name='+el+']').is(':checkbox'))
				{
					if($('#'+objName+' input[name='+el+']').is(':checked'))
						settingsData+='&'+el+'='+$('#'+objName+' input[name='+el+']').first().val();
				}
				else
					settingsData+='&'+el+'='+$('#'+objName+' input[name='+el+']').val();
			else if($('#'+objName+' select[name='+el+']').length==1)
				settingsData+='&'+el+'='+$('#'+objName+' select[name='+el+']').val();		
		});
		
		settingsData += varList;
		settingsData+="&action=General_save";
		
		showMessage('waiting', '<?php _e('Saving general settings...','rb'); ?>', 'Generalsave');
		$.post(ajaxurl, settingsData, function(data){
			data = $.parseJSON(data);
			if(data.status=='OK')
			{			
				showMessage('successful', '<?php _e('General settings has been updated successfully.','rb'); ?>', 'Generalsave');
			}
			else
				showMessage('error', '<?php _e('Have got an error while saving settings.','rb'); ?>', 'Generalsave');
				
		});
		return false;
	}
	
	function getSettings(setid)
	{
		showMessage('waiting', '<?php _e('Getting current settings...','rb'); ?>', 'get_general');
		$.post(ajaxurl, {'action':'get_general','setid':setid}, function(data){
			data = $.parseJSON(data);
			showMessage('successful', '<?php _e('Current settings has been gotten successfully.','rb'); ?>', 'get_general');	
			setForm(data);
			if($('#'+setid).is(':hidden')){
				$('#'+setid).slideDown('slow');
			}
		});
	}
	
	function getSliderDetail(no)
	{
		showMessage('waiting', '<?php _e('Backgrounds are getting...','rb'); ?>', 'slider_details');
		$.post(ajaxurl, {action:'list_slider_items', GALLERYID:no},function(data){
			showMessage('successful', '<?php _e('Backgrounds has been getted successfully.','rb'); ?>', 'slider_details');
			$('#sliderImageItems tbody').html(data);
			$( "#sliderImageItems tbody").sortable({
				start:function(event, ui){
					ui.item.addClass('activeMove');
				},
				stop:function(event, ui){
					ui.item.removeClass('activeMove');
				},
				cancel: 'input, textarea, object, embed'
			});
			$( "#sliderImageItems input, #sliderImageItems textarea, #sliderImageItems object, #sliderImageItems embed" ).bind('click.sortable mousedown.sortable',function(ev){
				ev.target.focus();
			});
		});
	}
	
	function imageDelete(imgID, imgName)
	{
		if(window.confirm('<?php _e('Are you sure to delete this image?','rb'); ?>'))
		{
			showMessage('waiting', '<?php _e('Deleting image...','rb'); ?>', 'delete_image');
			$.post(ajaxurl, {'action':'delete_image', 'imgID':imgID, 'imgName':imgName}, function(data){
				data = $.parseJSON(data);
				if(data.status=='OK')
				{
					showMessage('successful', '<?php _e('Settings has been deleted successfully.','rb'); ?>', 'delete_image');	
					$('#imgs'+data.imgID).remove();
				}else
					showMessage('error', '<?php _e('Have got an error while deleting image.','rb'); ?>'+data.ERR, 'delete_image');
			});
		}
	}
	
	function loadFontVariants(area, font)
	{
		if(font!=undefined){
		$.ajax({ url:ajaxurl,
				 async: false,
				 data: {'action':'load_font_variants', 'font':font },
				 dataType:'text',
				 type: "POST",
				 success:function(data){
					data = $.parseJSON(data); 
					if(data.status=='OK')
					{
						$('#rbcontent select[name="'+area+'Variant"] option').remove();
						for(i=0; i<data.variants.length; i++)
							$('#rbcontent select[name="'+area+'Variant"]').append($('<option></option>').text(data.variants[i]).attr('value', data.variants[i]));
					}else
						showMessage('error', '<?php _e('Have got an error while getting font variant','rb'); ?>', 'get_variant');
					}
			});
		}
	}
	
	function setForm(data)
	{
		$('#rbcontent input[type=text]').val('');
		$('#rbcontent select').selectedIndex = -1;
		$('#rbcontent .colorSelectorControl div').css("backgroundColor",'#FFFFFF');
		
		loadFontVariants('headerFont', data.headerFont);
		loadFontVariants('contentFont', data.contentFont);
		
			$.each(data, function(name,i){
				if($('#rbcontent input:checkbox[name='+name+']').length==1){
					if($('#rbcontent input:checkbox[name='+name+']').val()==data[name])
					{
						$('#rbcontent input:checkbox[name='+name+']').attr('checked','checked');
					}else{
						$('#rbcontent input:checkbox[name='+name+']').removeAttr('checked');
					}
				}else{
					$('#rbcontent input[name='+name+']').val(data[name]);
					$('#rbcontent select[name='+name+']').attr('selectedIndex', -1).find('option[value="'+data[name]+'"]').attr('selected','selected');
					$('#rbcontent input[name='+name+'][name*="color"]').parent().find("div").css('backgroundColor', '#'+data[name]);
				}
			});
			
			$('#rbcontent input[name$="bg"]').each(function(){
				// finding starting with "bg" for setting background properties
				var wrapper = $(this).parent().parent().find(".bgcontrol");
				// spliting parameters 
				var params = $(this).val().split(" ");				
				if(params.length>0)
				{
					// params[0] taransparent or color value
					if(params[0]=='transparent' || params[0]=='' || params[0]==' ')
					{
						// trnasparent or no color
						$(wrapper).find("select[name=colorOption]").find('option[value=transparent]').attr("selected","selected");
					}else{
						// set color value and "use color"
						params[0] = params[0].replace("#",'');
						$(wrapper).find("select[name=colorOption]").find('option[value=usecolor]').attr("selected","selected");
						$(wrapper).find(".colorSelectorControl input").val(params[0]);
						$(wrapper).find(".colorSelectorControl div").css("backgroundColor",'#'+params[0]);
					}
					
					// if have got backgroun image and other paramters
					if(params.length>1)
					{
						if(params[1]!='')
						{
							// params[1] is background url
							params[1] = params[1].replace("url('",'');
							params[1] = params[1].replace("')",'');
							$(wrapper).find("input[name=url]").val(params[1]);//URL
							
							// params[2] is predefined left value or horizontal pixel value
							if(params[2]=='left' || params[2]=='right' || params[2]=='center')
							{
								$(wrapper).find("select[name=horizontal]").find('option[value='+params[2]+']').attr("selected","selected");
								$(wrapper).find("input[name=horizontalValue]").hide();
							}
							else
							{
								$(wrapper).find("select[name=horizontal]").find('option[value="value"]').attr("selected","selected");
								$(wrapper).find("input[name=horizontalValue]").show().val(params[2]);
							}
							
							// params[2] is predefined top value or vertical pixel value
							if(params[3]=='top' || params[3]=='bottom' || params[3]=='middle')
							{
								$(wrapper).find("select[name=vertical]").find('option[value='+params[3]+']').attr("selected","selected");
								$(wrapper).find("input[name=verticalValue]").hide();
							}else{
								$(wrapper).find("select[name=vertical]").find('option[value="value"]').attr("selected","selected");
								$(wrapper).find("input[name=verticalValue]").show().val(params[3]);
							}
							// params[4] is predefined repeat value
							$(wrapper).find("select[name=repeat]").find('option[value='+params[4]+']').attr("selected","selected");
							// params[5] is predefined position value
							$(wrapper).find("select[name=position]").find('option[value='+params[5]+']').attr("selected","selected");
						}else{
							// if no value clear all
							$(wrapper).find("input[name=url]").val('');
							$(wrapper).find("select[name=horizontal]").selectedIntex = 1;
							$(wrapper).find("select[name=vertical]").selectedIntex = 1;
							$(wrapper).find("select[name=repeat]").selectedIntex = 1;
							$(wrapper).find("select[name=position]").selectedIntex = 1;
							$(wrapper).find("input[name=horizontalValue]").hide();
							$(wrapper).find("input[name=verticalValue]").hide();
						}
					}else{
							// if no value clear all
							$(wrapper).find("input[name=url]").val('');
							$(wrapper).find("select[name=horizontal]").selectedIntex = 1;
							$(wrapper).find("select[name=vertical]").selectedIntex = 1;
							$(wrapper).find("select[name=repeat]").selectedIntex = 1;
							$(wrapper).find("select[name=position]").selectedIntex = 1;
							$(wrapper).find("input[name=horizontalValue]").hide();
							$(wrapper).find("input[name=verticalValue]").hide();
					}
				}
			});
		
		$(":checkbox").iButton("repaint");
	}
	
	function setBg(obj)
	{
		bg = '';
		if($(obj).find('select[name=colorOption]').val()=='usecolor')
			bg = '#'+$(obj).find('input[name=color]').val();
		else
			bg = 'transparent';
		
		if($(obj).find('input[name=url]').val()!='')
		{
			bg += " url('"+$(obj).find('input[name=url]').val()+"')";
			if($(obj).find('select[name=horizontal]').val()=='value')
				bg += ' '+$(obj).find('input[name=horizontalValue]').val();
			else
				bg += ' '+$(obj).find('select[name=horizontal]').val();
			if($(obj).find('select[name=vertical]').val()=='value')
				bg += ' '+$(obj).find('input[name=verticalValue]').val();
			else
				bg += ' '+$(obj).find('select[name=vertical]').val();
			bg += ' '+$(obj).find('select[name=repeat]').val();
			bg += ' '+$(obj).find('select[name=position]').val();
		}
		$(obj).parent().find('input:first').val(bg);
	}
	

	var urlObj; 
	var activeLink;
	function getUrlFromFile(el) 
	{
		if(activeLink!=el)
		{
			$('body').unbind('click');
			activeLink = null;
			urlObj = null;
					
			activeLink = el;
			pos = $(el).position();
			$('#imageManager').animate({
					left:pos.left+80,
					top:pos.top-150
					}, 500);
			urlObj = $(el).parent().find('input');
			$('body').click(function(e) 
			{
				var obj = (e.target ? e.target : e.srcElement);		
				if($(obj).attr('rel')=='selectable')
				{
					$(urlObj).val($(obj).parent().parent().attr('rel'));
					$(urlObj).focus().animate({backgroundColor:'#fffeee'},500).animate({backgroundColor:'#FFFFFF'},500);
					$('body').unbind('click');
					activeLink = null;
					urlObj = null;
					$('#imageManager').animate({
					left:830,
					top:20
					}, 500);
					
				}
				else if(obj!=activeLink)
				{
					$('body').unbind('click');
					activeLink = null;
					urlObj = null;
					$('#imageManager').animate({
					left:850,
					top:170
					}, 500);
				}
			});
		}
	}
	
	function deleteItemImage(me)
	{
		if(window.confirm('<?php _e('Are you sure to delete this image?','rb'); ?>'))
		{
			var imgID = $(me).parent().parent().parent().find("input[name='imageID[]']").val();
			if(imgID!=undefined){
				showMessage('waiting', '<?php _e('Image is deleting...','rb'); ?>', 'delete_image'+imgID);
				$.post(ajaxurl, {action:"remove_item_image", IMAGEID:imgID}, function(data){
					var jdata = $.parseJSON(data);
					if(jdata.status=='OK')
					{
						showMessage('successful', '<?php _e('Image has been deleted successfully.','rb'); ?>', 'delete_image'+jdata.IMAGEID);
						$("#sliderImageItems input[name='imageID[]'][value='"+jdata.IMAGEID+"']").parent().parent().remove();
					}
					else
					{
						showMessage('error', '<?php _e('Image coudn\\\'t be deleted','rb'); ?>.', 'delete_image'+jdata.IMAGEID);
					}
				});
			}
		}
	}
	
	function changeDimension(me, type)
	{
		var imgID = $(me).parent().parent().parent().find("input[name='imageID[]']").val();
		var dimValue = $(me).text();
		var newValue = window.prompt('<?php _e('Please enter a new value','rb');?>', dimValue);
		if(newValue!=false && dimValue!=newValue)
		{
			$('#imageID'+imgID+' .video'+type+' a').text(newValue);
			showMessage('waiting', '<?php _e('Dimension of Video is deleting...','rb'); ?>', 'dim_video'+imgID);
			$.post(ajaxurl, {action:"change_video_dimension", IMAGEID:imgID, dimType:type, value:newValue}, function(data){
				var jdata = $.parseJSON(data);
				if(jdata.status=='OK')
				{
					showMessage('successful', '<?php _e('Dimension of Video has been updated successfully.','rb'); ?>', 'dim_video'+jdata.IMAGEID);
					$('#imageID'+jdata.IMAGEID+' .video'+jdata.dimType+' a').text(jdata.value);
				}
				else
				{
					showMessage('error', '<?php _e('Dimension of Video coudn\\\'t be updated.','rb'); ?>', 'dim_video'+jdata.IMAGEID);
				}
			});
		}
	}
	
	function thumUploader(me){
		var imgID = $(me).parent().parent().parent().find("input[name='imageID[]']").val();
		$('.thumbUplodifyWrap').remove();
		if($('#imageID'+imgID+' td:nth-child(2) .thumbUplodifyWrap').length==0)
		{
			var addNot = '';
			if($.browser.msie || $.browser.webkit)
				addNot = '<div style="clear:both; margin-top:10px;"></div>This browser may not support Multi Upload module. Please try another browser like Firefox etc.';

			$('#imageID'+imgID+' td:nth-child(2)').append($('<div class="thumbUplodifyWrap"><div id="thumbUplodify"></div>'+addNot+'</div>'));
			$("#thumbUplodify").uploadify({
				'uploader': '<?php echo get_template_directory_uri(); ?>/includes/uploadify/uploadify.swf',
				'cancelImg': '<?php echo get_template_directory_uri(); ?>/includes/uploadify/cancel.png',
				'script': '<?php echo $pURL ?>/includes/uploadify/upload_background_thumb.php',
				'multi': false,
				'auto':true,
				'width':400,
				'scriptData': {'IMAGEID':imgID},
				'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
				'displayData': 'speed',
				'wmode': 'transparent',
				'onComplete'  : function(event, ID, fileObj, response, data) {
					var jdata = $.parseJSON(response);
					if(jdata.status=='OK')
						$('#imageID'+imgID+' td:nth-child(1) .sliderImageItemImage img').attr('src', '<?php echo get_template_directory_uri();?>/includes/timthumb.php?src='+jdata.path+'&h=80&w=120&zc=1&q=100');
					else
						alert(jdata.ERR);
				},
				'onError'     : function (event,ID,fileObj,errorObj) {
				  alert(errorObj.type + ' <?php _e('Error:','rb'); ?> ' + errorObj.info);
				}
		});
		}
	}
	
	function getSettingsOptions(settingsID, settingsType, settingsImageManager, callfunction){
		$('#rbcontent > div').slideUp('slow');
		if(settingsImageManager=='true')
			getImageManager();
		else
			closeImageManager();
		if(settingsType=='fields'){
			getSettings(settingsID);
		}else if(settingsType=='area'){
			if($('#'+settingsID).is(':hidden'))
				$('#'+settingsID).slideDown('slow');
		}else{
			var fn = window[callfunction];
			if(typeof fn === 'function')
				fn();
		}
	}
	
</script>
<style>
#messageArea { position:absolute; left:0px; top:0px; width:800px; z-index:999;}
#messageArea .waiting{padding:5px 5px 5px 25px; background:url('<?php echo get_template_directory_uri(); ?>/images/admin-loading.gif') #FF7300 5px center no-repeat; color:#FFFFFF; display:none;}
#messageArea .successful{padding:5px; background-color:#10CD02; color:#FFFFFF; display:none;}
#messageArea .error2{padding:5px; background-color:#FF0000; color:#FFFFFF; display:none;}

.widefat td{
	padding:8px;
}

#imageManager{
	display:none;
	opacity:0;
	position: absolute;
	left: 830px;
	top:20px;
	z-index:998;
}

.trueHeader{
	background: url('../images/gray-grad.png') repeat-x scroll left top #DFDFDF;	
	-moz-border-radius-topleft:3px;
	-moz-border-radius-topright:3px;
	padding:10px;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
	border:1px solid #DFDFDF;
}
.trueWrapper{
	background-color:#FFFFFF;
	-moz-border-radius-topleft:3px;
	-moz-border-radius-topright:3px;
	-moz-border-radius-bottomleft:3px;
	-moz-border-radius-bottomright:3px;
	border:1px solid #DFDFDF;
}
.colorSelectorWrapper{
	height:35px;
}
.colorSelector, .colorSelectorControl {
	width: 36px;
	height: 36px;
	float:left;
}
.colorSelector div, .colorSelectorControl div{
	top: 4px;
	left: 4px;
	width: 28px;
	height: 28px;
	background: url(<?php echo get_template_directory_uri(); ?>/includes/colorpicker/images/select2.png) center;
}
.color{
	display:none;
	margin-left:40px;
}
.bgcontrol > div {
	clear:both;
}
.bgcontrol select{
	width:100px;
}
.bgcontrol label{
	float:left;
	width:80px;
}

.gl{
	border:3px solid #ddd;
	padding:2px;
	text-align:center;
	margin:2px auto;
}
.gl_active
{
	border-color:#bbb; 
}
.da{
	width:200px;
}
.glcontrol{
	border: 2px solid #ddd;
	background-color: #eee;
	position:absolute;
	padding:5px;
} 
.glcontrol h5{
	margin:0;
}

.subText{
	float:left;
	margin-right:5px;
	width:50px;
}
#settingShow{
	display:none;
}

	* html .clearfix {
		height: 1%; /* IE5-6 */
	}
	*+html .clearfix {
		display: inline-block; /* IE7not8 */
	}
	.clearfix:after { /* FF, IE8, O, S, etc. */
		content: ".";
		display: block;
		height: 0;
		clear: both;
		visibility: hidden;
	}
	.colorpicker{
		z-index:99;
	}
	.settedfp{
		font-weight:bold;
		color:red;
	}
	
	
	#rbwrap{width:800px; margin-top:20px;}
	#rbheader{height:46px;}
	.rbheaderbordertop{height:3px; background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/header-bg1.png');}
	.rbheaderborderbottom{height:3px; background-color:#2c2c2c;}
	#rbheadermenu{height:40px; background-color:#333;}
	#rbmenu{background-color:#2c2c2c; width:170px; float:left;}
	#rbheadermenuleft{
		float:left;
		width:250px;
	}
	#rbheadermenuright{
		text-align:right;
		float:right;
		width:500px;
	}
	#rbbody{background-color:#eeeeee;}
	#rbcontent{background-color:#eeeeee; width:630px; float:left;}
	
	
	#rbmenu ul{list-style:none; margin:0;}
	#rbmenu ul li{
		width:164px; 
		height:40px; 
		margin:0 3px;
		background-color:#333333;
		margin-bottom:3px;
	}
	#rbmenu ul li a:link,
	#rbmenu ul li a:visited{
		-moz-transition: all 0.5s ease-in-out 0s;
		transition: all 0.5s ease-in-out;
		-webkit-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		
		display:block;
		height:40px;
		font-size:11px; 
		font-family: 'Open Sans', sans-serif; 
		font-weight:800;
		text-decoration:none;
		box-shadow: 1px 1px rgba(255,255,255,.1) inset, -1px -1px rgba(0,0,0,.3) inset;
		
		background: -moz-linear-gradient(top,  rgba(255,255,255,0.07) 0%, rgba(255,255,255,0) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.07)), color-stop(100%,rgba(255,255,255,0))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(255,255,255,0.07) 0%,rgba(255,255,255,0) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(255,255,255,0.07) 0%,rgba(255,255,255,0) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(255,255,255,0.07) 0%,rgba(255,255,255,0) 100%); /* IE10+ */
		background: linear-gradient(top,  rgba(255,255,255,0.07) 0%,rgba(255,255,255,0) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#12ffffff', endColorstr='#00ffffff',GradientType=0 ); /* IE6-9 */

	}
	#rbmenu ul li a:hover,
	#rbmenu ul li a:active{		
		background: -moz-linear-gradient(top,  rgba(255,255,255,0) 0%, rgba(255,255,255,0.07) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(100%,rgba(255,255,255,0.07))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.07) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.07) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.07) 100%); /* IE10+ */
		background: linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.07) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#12ffffff',GradientType=0 ); /* IE6-9 */
	}
	#rbmenu ul li a:link span,
	#rbmenu ul li a:visited span{	
		background-repeat:repeat-y;
		background-position: 0px 0px;
	}
	#rbmenu ul li a:hover span,
	#rbmenu ul li a:active span{	
		background-position:0 -40px;
	}
	#rbmenu ul li a:hover div,
	#rbmenu ul li a:active div{
		color:#bbbbbb;
	}
	
	#rbmenu ul li a div{
		-moz-transition: all 0.5s ease-in-out 0s;
		transition: all 0.5s ease-in-out;
		-webkit-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		
		vertical-align:top;
		display:inline-block;
		height:40px;
		color:#6e6e6e;
		line-height:40px;
	}
	#rbmenu ul li a span{
		-moz-transition: all 0.5s ease-in-out 0s;
		transition: all 0.5s ease-in-out;
		-webkit-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		
		display:inline-block;
		width:40px;
		height:40px;
	}
	
	#rbmenu ul li.selected{
		width:167px; 
		height:40px; 
		margin:0 0 3px 3px;
		background-color:#eeeeee;
	}
	#rbmenu ul li.selected a:link,
	#rbmenu ul li.selected a:visited,
	#rbmenu ul li.selected a:hover,
	#rbmenu ul li.selected a:active{
		cursor:default;
		color:6e6e6e;
		background:none;
		box-shadow:none;
		box-shadow: 1px 1px rgba(255,255,255,1) inset;
	}
	#rbmenu ul li.selected a:link span,
	#rbmenu ul li.selected a:visited span,
	#rbmenu ul li.selected a:hover span,
	#rbmenu ul li.selected a:active span{
		background-position:0 0;
	}
	#rbmenu ul li.selected a:link div,
	#rbmenu ul li.selected a:visited div,
	#rbmenu ul li.selected a:hover div,
	#rbmenu ul li.selected a:active div{
		color:#6e6e6e;
	}
	
	#rbheadermenuleft a:link,
	#rbheadermenuleft a:visited{
		display:inline-block;
		height:40px;
		line-height:40px;
		padding:0 15px;
		font-size:14px; 
		font-family: 'Open Sans', sans-serif; 
		font-weight:800;
		color:#ffffff;
		background-color:#3d3d3d;
		text-decoration:none;
	}
	#rbheadermenuleft a:hover,
	#rbheadermenuleft a:active{
		color:#ffffcc;
	}
	#rbheadermenuright a:link,
	#rbheadermenuright a:visited{
		text-align:left;
		display:inline-block;
		height:33px;
		line-height:1.2em;
		padding:7px 13px 0px 46px;
		font-size:10px; 
		font-family: Tahoma;
		color:#ffffff;
		background-color:#3d3d3d;
		text-decoration:none;
		margin-left:1px;
		background-position:6px 7px;
		background-repeat:no-repeat;
	}
	#rbheadermenuright a:hover,
	#rbheadermenuright a:active{
		color:#ffffcc;
	}
	
	
	
	.statusIcon{
		width:15px;
		height:15px;
		margin:2px auto 0 auto;
	}
	.statusOK{	background:url("<?php echo get_template_directory_uri(); ?>/images/list-check.png") no-repeat; }
	.statusNOK{	background:url("<?php echo get_template_directory_uri(); ?>/images/list-cross.png") no-repeat; }

	.ErrInfo, .attentionbox, .downloadbox, .ErrMessage{
		padding:20px 20px 20px 75px;
		border:2px solid #333;
		margin:10px;
	}
	.ErrInfo{
		border-color:#0066cc;
		color:#0066cc;
		background: url('<?php echo get_template_directory_uri(); ?>/images/box-info.png') 20px center no-repeat;
	}
	.attentionbox{
		border-color:#ffcc00;
		color:#ffcc00;
		background: url('<?php echo get_template_directory_uri(); ?>/images/box-attention.png') 20px center no-repeat;
	}
	.downloadbox{
		border-color:#009900;
		color:#009900;
		background: url('<?php echo get_template_directory_uri(); ?>/images/box-download.png') 20px center no-repeat;
	}
	.ErrMessage{
		border-color:#ff0000;
		color:#ff0000;
		background: url('<?php echo get_template_directory_uri(); ?>/images/box-cross.png') 20px center no-repeat;
	}
	.statusWait{ display:none; }
	
	
	
	/* Gallery Detail*/
	#addBg{ width:590px; margin:20px;}
	#addBg ul{list-style:none;}
	#addBg ul li{
		float:left;
		margin:0 5px 0 0;
	}
	#addBg ul li a:link,
	#addBg ul li a:visited{
		display:block;
		padding:6px 12px;
		color:#333333;
		background-color: #F1F1F1;
		background-image:-moz-linear-gradient(center top , #F9F9F9, #dddddd);
		font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
		text-decoration:none;
		border-radius:6px 6px 0px 0px;
		text-shadow:0 1px 0 rgba(255, 255, 255, 0.8);
	}
	#addBg ul li a:hover,
	#addBg ul li a:active{
		color:#333333;
		background-image:-moz-linear-gradient(center top , #dddddd, #F9F9F9);
	}
	#addBg ul li a.selected:link,
	#addBg ul li a.selected:visited,
	#addBg ul li a.selected:hover,
	#addBg ul li a.selected:active
	{
		color:#F1F1F1;
		background-color: #333333;
		background-image: none;
		text-shadow:0 1px 0 rgba(0, 0, 0, 0.8);
	}
	
	.sliderItem{padding:3px; background-color:#EEEEEE; margin-bottom:3px}
	.sliderImageItemImage{}
	.sliderImageItem, .sliderImageItem td{cursor:move;}
	.sliderImageItem{
		background: url('<?php echo get_template_directory_uri(); ?>/images/lined.png') repeat;
	}
	.activeMove{
		background-color:#FEFFE2;
	}
	#sliderOptions form input[type="text"], #sliderOptions form select{
		width:150px;
	}
	#sliderOptions form input[type="text"]{
		text-align:right;
	}
	.video{
		display:none;
		clear:both;
		border:1px solid #dddddd;
		padding:10px;
		margin-bottom:10px;
		background-color:#f9f9f9;
		border-radius:0 3px 3px 3px;
	}
	.image{
		clear:both;
		border:1px solid #dddddd;
		padding:10px;
		margin-bottom:10px;
		background-color:#f9f9f9;
		border-radius:0 3px 3px 3px;
	}
	</style>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,800' rel='stylesheet' type='text/css'>
	
	<div id="messageArea"></div> 
	
	<div id="rbwrap">
		<div id="rbheader">
			<div class="rbheaderbordertop"></div>
			<div id="rbheadermenu">
				<div id="rbheadermenuleft"><a href="http://themeforest.net/user/RenkliBeyaz/portfolio" target="_blank"><?php _e('RENKLIBEYAZ\'S THEMES','rb'); ?></a></div>
				<div id="rbheadermenuright">
					<a href="<?php _e('http://themeforest.net/user/renklibeyaz/follow','rb'); ?>" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_star.png');"><?php _e('Follow us on<br />Themeforest','rb'); ?></a>
					<a href="<?php _e('http://renklibeyaz.com/forum/purchisecode.html','rb'); ?>" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_lock.png');"><?php _e('Forum<br />Register Code','rb'); ?></a>
					<a href="<?php _e('http://renklibeyaz.com/forum/','rb'); ?>" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_forum.png');"><?php _e('Support<br />Forum','rb'); ?></a>
					<a href="<?php _e('http://twitter.com/renklibeyaz','rb'); ?>" target="_blank" style="background-image:url('<?php echo get_template_directory_uri(); ?>/includes/adminimages/icon_tw.png');"><?php _e('Follow us on<br />Twitter','rb'); ?></a>
				</div>
			</div>
			<div class="rbheaderborderbottom"></div>
		</div>
		<div id="rbbody"> 
			<div id="rbmenu">
				<ul>
					<?php
					foreach($SettingsOptions as $sm){
						echo '<li><a href="javascript:void(0);" 
							onclick="getSettingsOptions(\''.$sm['id'].'\', \''.$sm['type'].'\',  \''.$sm['imagemanager'].'\', '.(($sm['type']=='script')?'\''.$sm['run'].'\'':'null').')">
							<span style="'.((!empty($sm['icon']))?'background-image:url(\''.$sm['icon'].'\');':'').'" ></span><div>'.__($sm['name'],'rb').'</div></a></li>';
					}
					?>
				</ul>
			</div>
			<div id="rbcontent">
			<!-- ******************************   CONTENT START   ****************************** -->
			
			
			
			<?php
				foreach($SettingsOptions as $sm){
					if($sm['type']=='fields')
					{
					echo '<div id="'.$sm['id'].'" style="display:none">';
					echo '<form method="post" action="#" onsubmit="return saveSettings(\''.$sm['id'].'\');">';
					echo '<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">';
					echo '<thead>
						<tr>
							<th width="25%">'.__('Option', 'rb').'</th>
							<th width="75%">'.__('Value', 'rb').'</th>
						</tr>
					</thead>
					<tbody>
					<tr class="gs">
						<td align="left">
	                        <input type="submit" id="apply" class="button" value="'.__('Apply Settings','rb').'" />
                        </td>
						<td align="right"></td>
					</tr>';
						foreach($sm['fields'] as $field){
							echo '<tr class="gs">';
							echo '<td>'.__($field['name'],'rb').'</td>';
							echo '<td>';
							
							if(isset($field['before'])) echo $field['before'];
							
							if($field['type']=='onoff'){
								echo '<input type="checkbox" name="'.$field['id'].'" value="'.$field['on'].'" id="'.$field['id'].'" />';
							}elseif($field['type']=='color'){
								echo '<div class="colorSelector"><div style="background-color:"></div>';
								echo '<input type="text" class="color" name="'.$field['id'].'" value="" />';
								echo '</div>';
							}elseif($field['type']=='text'){
								echo '<input type="text" name="'.$field['id'].'" value="" style="width:300px;" />';
							}elseif($field['type']=='select'){
								echo '<select name="'.$field['id'].'" style="width:100px;">';
								if(is_array($field['options'])){
									if(is_assoc($field['options']))
										foreach($field['options'] as $optionk => $optionv)
											echo '<option value="'.$optionv.'">'.__($optionk,'rb').'</option>';
									else
										foreach($field['options'] as $option)
											echo '<option value="'.$option.'">'.$option.'</option>';
								}
								echo '</select>';
							}elseif($field['type']=='url'){
								echo '<div class="url">';
								echo '<input type="text" name="'.$field['id'].'" value="" style="width:300px;"/>';
								echo '<a href="javascript:void(0);" onclick="getUrlFromFile(this)">'.__('Get URL','rb').'</a>';
								echo '</div>';
							}elseif($field['type']=='newsletter'){
								$user_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}newsletter;" ) );
								echo sprintf(__('%d Records', 'rb'), $user_count);
								echo ' <a href="'.get_template_directory_uri().'/includes/newsletterdownload.php" target="_blank">'.__('Download the list', 'rb').'</a>';
							}elseif($field['type']=='font'){
								echo '<select name="'.$field['id'].'" style="width:200px;">';
								echo '<option value="">Default</option>';
								for($i=0; $i<sizeof($fonts->items); $i++)
									echo '<option value="'.$fonts->items[$i]->family.'" >'.$fonts->items[$i]->family.'</option>';
								echo '</select>';
								echo '<select name="'.$field['id'].'Variant" style="width:100px;"></select>';
							}elseif($field['type']=='integer'){
								echo '<input type="text" name="'.$field['id'].'" style="width:50px;" value="" />';
							}elseif($field['type']=='background'){
								echo '<label><input type="text" name="'.$field['id'].'" value="" style="width:300px; display:none" /></label>';
								echo '<div id="'.$field['id'].'-bgcontrol" class="bgcontrol">';
								?>
								<div>
									<label>Color: </label>
									<div class="colorSelectorControl"><div style="background-color:">
										<input class="novar" type="text" name="color" value="" style="display:none"/>
										</div>
									</div>
										<select class="novar" name="colorOption">
											<option value="transparent"><?php echo _e('Transparent','rb'); ?></option>
											<option value="usecolor"><?php echo _e('Use Color','rb'); ?></option>
										</select>
								</div>
								<div class="url">
									<label><?php echo __('Url:','rb'); ?> </label>
									<input class="novar" type="text" name="url" value="" style="width:280px;"/>
									<a href="javascript:void(0);" onclick="getUrlFromFile(this)"><?php _e('Get URL','rb'); ?></a>
									
								</div>
								<div class="horizontal">
									<label>
									<?php  _e('Horizontal:','rb'); ?>
									</label>
										<select name="horizontal" class="novar">
											<option value="left"><?php  _e('Left','rb'); ?></option>
											<option value="right"><?php  _e('Right','rb'); ?></option>
											<option value="center"><?php _e('Center','rb'); ?></option>
											<option value="value"><?php _e('Value','rb'); ?></option>
										</select>
										<input class="novar" type="text" name="horizontalValue" value="" style="display:none"/>
									
								</div>
								<div class="vertical">
									<label>
									<?php _e('Vertical:','rb'); ?>
									</label>
										<select class="novar" name="vertical">
											<option value="top"><?php _e('Top','rb'); ?></option>
											<option value="bottom"><?php _e('Bottom','rb'); ?></option>
											<option value="middle"><?php _e('Middle','rb'); ?></option>
											<option value="value"><?php _e('Value','rb'); ?></option>
										</select>
										<input class="novar" type="text" name="verticalValue" value="" style="display:none"/>
									
								</div>
								<div class="novar" class="repeat">
									<label>
									<?php  _e('Repeat:','rb'); ?>
									</label>
										<select class="novar" name="repeat">
											<option value="repeat"><?php _e('Repeat','rb'); ?></option>
											<option value="repeat-x"><?php _e('Repeat-X','rb'); ?></option>
											<option value="repeat-y"><?php _e('Repeat-Y','rb'); ?></option>
											<option value="no-repeat"><?php _e('No-Repeat','rb'); ?></option>
										</select>
									
								</div>
								<div class="position">
									<label>
									<?php _e('Position:','rb'); ?>
									</label>
										<select class="novar" name="position">
											<option value="scroll"><?php _e('Scroll','rb'); ?></option>
											<option value="fixed"><?php _e('Fixed','rb'); ?></option>
										</select>
									
								</div>
								<?php
								echo '</div>';
							}
							
							if(isset($field['after'])) echo $field['after'];
							echo '</td>';
							echo '</tr>';
						}
						
					echo '<tr class="gs">
						<td align="left">
	                        <input type="submit" id="apply2" class="button" value="'.__('Apply Settings','rb').'" />
                        </td>
						<td align="right"></td>
						</tr>
					</tbody>
					</table>
					</form>
					</div>';				
					}
				}
			?>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!-- ****  GALLERIES LIST START   **** -->
			<div id="gallerieslist" style="display:none">
			<table cellpadding="0" style="width:590px; margin:20px;" class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('GALLERIES','rb'); ?></th>
					</tr>
					<tr>
						<th width="50"><?php _e('ID','rb'); ?></th>
						<th ><?php _e('NAME','rb'); ?></th>
						<th width="280"><?php _e('ACTIONS','rb'); ?></th>
					</tr>
				</thead>                
				<tbody id="gallerieslistbody">
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2">
							<input type="button" name="addGallery" id="addGallery" class="button" value="<?php _e('Add a New Gallery','rb'); ?>" />
						</td>
					</tr>
				</tfoot>
			</table>
			</div>
			<!-- ****   GALLERIES LIST END   **** -->
			
			
			
			
			
			
			
			
			
			
			<!-- ****  GALLERY DETAIL START   **** -->
			<div id="gallerydetail" style="display:none">
				<div id="addBg">
					<ul>
					 <li><a rel="image" class="selected" href="javascript:void(0);" ><?php _e('Image','rb'); ?></a></li>
					 <li><a rel="video" href="javascript:void(0);" ><?php _e('Video','rb'); ?></a></li>
					</ul>
					<div class="image">
						<div id="fileUploadWrapGalleryDetail"></div>
						<div style="clear:both; margin-top:10px;"></div>
						<script>
						if($.browser.msie || $.browser.webkit)
							document.write('<?php _e('This browser may not support Multi Upload module. Please try another browser like Firefox etc.','rb'); ?>');
						</script>
					</div>
					<div class="video">
						<form>
						<select name="type" style="float:left; width:200px">
							<option value="youtube">Youtube</option>
							<option value="vimeo">Vimeo</option>
							<option value="selfhosted"><?php _e('Self Hosted Video','rb'); ?></option>
							<option value="flash"><?php _e('Flash SWF File','rb'); ?></option>
						</select>
						<div class="videotype videoid" style="float:left; margin-left:10px">
							<label style="width:100px"><?php  __('Video ID','rb'); ?></label>
							<input type="text" name="id" value="" style="width:100px" />
						</div>
						<div class="videotype videourl" style="display:none">
							<label><?php  _e('Video URL','rb'); ?></label>
							<input type="text" name="url" value="" />
						</div>
						<div class="videotype videocode" style="display:none; clear:both; padding:10px 0;">
							<label style="vertical-align: top; padding-right:150px;"><?php  _e('Iframe Code','rb'); ?></label>
							<textarea name="iframecode" style="width:400px;"></textarea>
						</div>
						<div class="videotype videowh" style="clear:both; padding:10px 0;">
							<label><?php _e('Width','rb'); ?></label>
							<input type="text" name="width" value="" style="width:50px; margin-left:15px" />
							<label><?php _e('Height','rb'); ?></label>
							<input type="text" name="height" value="" style="width:50px"/>
						</div>
						<input type="button" name="addVideo" id="addVideo" class="button" value="<?php _e('Add Video','rb'); ?>" />
						</form>
					</div>
				</div>
				<div id="sliderImages">
					<form id="sliderImageForm">
					<table id="sliderImageItems" class="widefat" cellspacing="0" style="width:590px; margin:20px;">
						<thead>
							<tr>
								<td colspan="2"><input type="button" name="backtoGallery" id="backtoGallery" class="button" onclick="getGalleriesList();" value="<?php _e('Back to Gallery List','rb'); ?>" style="float:right" /></td>
							<tr>
							<tr>
								<th colspan="2">[<?php _e('ID','rb'); ?>:<span id="gallerydetailid"></span>] <span id="gallerydetailname"></span> <?php _e('Gallery','rb'); ?></th>
							</tr>
							<tr>
								<th><?php _e('Image','rb'); ?></th>
								<th><?php _e('Informations','rb'); ?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="2">
									<input type="submit" name="submit" class="button" value="<?php _e('Save Changes','rb'); ?>" />
								</td>
							</tr>
						</tfoot>
						<tbody>
						</tbody>
					</table>
					</form>
				</div>
			</div>
			<!-- ****  GALLERY DETAIL END   **** -->
			
			
			
			
			
			<!-- ****  THEME CHECK START   **** -->
			<div id="checktheme" style="display:none">
			</div>
			<!-- ****  THEME CHECK END   **** -->
			
			
			
			<!-- ****  HELP   **** -->
			<div id="help" style="display:none">
			<iframe src="<?php echo get_template_directory_uri(); ?>/includes/documentation/" style="margin:20px" width="590" height="500" frameborder="0"></iframe>
			</div>
			<!-- ****  HELP   **** -->
			
				
				<!-- ******************************   CONTENT END   ****************************** -->
			</div>
		<div class="clearfix"></div>
		</div>
	<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
<!-- New Theme END -->


<div id="imageManager" class="trueWrapper" style="width:340px;">
	<h3 class="trueHeader" style="margin:0"><?php _e('Image Manager','rb'); ?></h3>
	<div id="imageBody" style="padding:20px;">
	<div id="uploadControl" style="margin-bottom:10px;">
		<div id="uploader"></div>
		<div style="clear:both; margin-top:10px;"></div> 
		<script>
		if($.browser.msie || $.browser.webkit)
			document.write('<?php _e('This browser may not support Multi Upload module. Please try another browser like Firefox etc.','rb'); ?>');
		</script>
	</div>
	<div style="overflow:auto; height:250px;">
	<table id="imageList" cellpadding="0" width="325"  style="width:300px;" class="widefat">
		<thead>
			<tr>
				<th width="75px"><?php _e('Image','rb'); ?></th>
				<th><?php _e('Actions','rb'); ?></th>
			</tr>
		</thead>                
		<tbody>
			<?php
			
			?>
		</tbody>
	</table>
	</div>
	</div>
</div>


<?php
}
?>