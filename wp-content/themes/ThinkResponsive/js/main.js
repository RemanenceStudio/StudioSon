var $ = jQuery.noConflict();
var mobileDevice = false
jQuery(document).ready(function() {
	// Accordion Script
	$('.sh_accordion .sh_acc_item_title a').click(function(){
		if($(this).next().is(':hidden')){
			$(this).parent().parent().find('.sh_acc_item').slideUp().prev().removeClass('sh_acc_item_title_opened');
			$(this).addClass('sh_acc_item_title_opened');
			$(this).next().slideDown();
		}
	});
	$('.sh_accordion .sh_acc_item:first').slideDown().prev().addClass('sh_acc_item_title_opened');
	
	// Tab Menu Script
	$('.sh_tabs a.sh_tab_title').each(function(){
		$(this).parent().parent().parent().find('.sh_tabs_menu').append($('<li></li>').append(this).click(function(){
			var element = $(this).parent().parent();
			if($(element).find('div [id='+$(this).find('a').attr('rel')+']').is(':hidden')){
				$(element).find('div.sh_tab_item').slideUp();
				$(element).find('div [id='+$(this).find('a').attr('rel')+']').slideDown();
				$(this).parent().find('li a').removeClass('sh_tab_title_active');
				$(this).find('a').addClass('sh_tab_title_active');
			}
		}));
	});
	$('.sh_tabs .sh_tab_item:first').show();
	$('.sh_tabs .sh_tabs_menu a:first').addClass('sh_tab_title_active');
	
});

// Set Modals
jQuery(document).ready(function($) {
	var modalParams = {
	theme:'light_square', 
	autoplay: true, 
	opacity:0.4, 
	show_title: false,
	markup: '<div class="pp_pic_holder"> \
						<div class="ppt">&nbsp;</div> \
						<div class="pp_top"> \
							<div class="pp_left"></div> \
							<div class="pp_middle"></div> \
							<div class="pp_right"></div> \
						</div> \
						<div class="pp_content_container"> \
							<div class="pp_left"> \
							<div class="pp_right"> \
								<div class="pp_content"> \
									<div class="pp_loaderIcon"></div> \
									<div class="pp_fade"> \
										<a href="#" class="pp_expand" title="Expand the image">Expand</a> \
										<div class="pp_hoverContainer"> \
											<a class="pp_next" href="#">next</a> \
											<a class="pp_previous" href="#">previous</a> \
										</div> \
										<div id="pp_full_res"></div> \
										<div class="pp_details"> \
											<div class="pp_nav"> \
												<a href="#" class="pp_arrow_previous">Previous</a> \
												<p class="currentTextHolder">0/0</p> \
												<a href="#" class="pp_arrow_next">Next</a> \
											</div> \
											<p class="pp_description"></p> \
											<a class="pp_close" href="#">Close</a> \
										</div> \
									</div> \
								</div> \
							</div> \
							</div> \
						</div> \
						<div class="pp_bottom"> \
							<div class="pp_left"></div> \
							<div class="pp_middle"></div> \
							<div class="pp_right"></div> \
						</div> \
					</div> \
					<div class="pp_overlay"></div>',
			gallery_markup: '<div class="pp_gallery"> \
								<a href="#" class="pp_arrow_previous">Previous</a> \
								<div> \
									<ul> \
										{gallery} \
									</ul> \
								</div> \
								<a href="#" class="pp_arrow_next">Next</a> \
							</div>'
	};

	$('.sh_lightbox').each(function(){
		var modalsh = randomString(5);
		$(this).find('a img').parent().attr('rel','gallery[photo'+modalsh+']').not('.nomodal').prettyPhoto(modalParams);
	});
	
	var modalid = randomString(5);
	$('.modal').not('.nomodal').attr('rel','gallery[photo'+modalid+']');
	$('.modal').not('.nomodal').prettyPhoto(modalParams);
});

// Set Testimonial Animation
jQuery(document).ready(function($) {
	$('.sh_testimonials').each(function(){
		var countItems = $(this).find('.tes_items .sh_testimonial').length;
		$(this).find('.tes_items .sh_testimonial').hide();
		$(this).find('.tes_items .sh_testimonial:first-child').addClass('opened').show();
		$(this).find('.tes_items').height($(this).find('.tes_items .sh_testimonial.opened').height());
		for(var i=1; i<countItems+1; i++)
			$(this).find('.tes_nav').append('<a href="javascript:void(0);" rel="'+i+'">'+i+'</a>');
		$(this).find('.tes_nav a:first-child').addClass('selected');
		$(this).find('.tes_nav a').click(function(){
			showTestimonial(this)
		});
		$(this).mouseenter(function(){
			testimonialPaused = true;
			clearInterval(testimonialTimer);
		}).mouseleave(function(){
			testimonialPaused = false;
			clearInterval(testimonialTimer);
			testimonialTimer = setInterval(nextTestimonial, 5000);
		});
	});
	testimonialTimer = setInterval(nextTestimonial, 5000);
});
var testimonialProg = false;
var testimonialPaused = false;
var testimonialTimer;
function showTestimonial(obj){
	if(testimonialProg) return false;
	var no = parseInt($(obj).attr('rel'));
	if($(obj).parent().parent().find('.tes_items .sh_testimonial:nth-child('+no+')').is(':hidden')){
		testimonialProg = true;
		$(obj).parent().find('a').removeClass('selected');
		$(obj).addClass('selected');
					
		var oldh = $(obj).parent().parent().find('.tes_items .sh_testimonial.opened').height();
		$(obj).parent().parent().find('.tes_items').css({overflow:'hidden', height:oldh+'px'});
		var newh = $(obj).parent().parent().find('.tes_items .sh_testimonial:nth-child('+no+')').show().css({opacity:0}).height();
		$(obj).parent().parent().find('.tes_items .sh_testimonial.opened').animate({opacity:0}, 300, function(){
			$(obj).parent().parent().find('.tes_items .sh_testimonial.opened').removeClass('opened').hide();
			$(obj).parent().parent().find('.tes_items').animate({height:newh+'px'}, 300, function(){
				$(obj).parent().parent().find('.tes_items').css({overflow:'none'});
				$(obj).parent().parent().find('.tes_items .sh_testimonial:nth-child('+no+')').animate({opacity:1}, 300, function(){
					$(this).addClass('opened');
					testimonialProg = false;
				});
			});
		});
	}
}

function nextTestimonial(){
	if(testimonialProg || testimonialPaused) return false;
	$('.sh_testimonials').each(function(){
		if($(this).find('.tes_nav a.selected').is(':last-child'))
			showTestimonial($(this).find('.tes_nav a:first-child'));
		else
			showTestimonial($(this).find('.tes_nav a.selected').next());
	});
}

// Set Logos Animation
jQuery(document).ready(function($) {
	$('.logos li a').hover(function(){
		$(this).find('img').stop().animate({opacity:.5}, 500);
	}, function(){
		$(this).find('img').stop().animate({opacity:1}, 500);
	});
});

// Set Tips
jQuery(document).ready(function($) {
	$('.tip').mouseenter(function(){
		console.log('tip', 'over');
		if($(this).attr('tips-id')==undefined)
			$(this).attr('tips-id', 'tips-'+randomString(5));
		var tipsID = $(this).attr('tips-id');
		if($('#'+tipsID).length==0){
			var pos = $(this).position();
			$('body').append($('<div id="'+tipsID+'" class="meta-tips">'+$(this).attr('rel')+'<span><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="10px" height="10px"><polygon points="0,0 10,0 10,10" /></svg></span></div>'));
			$('#'+tipsID).css({top:(pos.top-$('#'+tipsID).height()-21)+'px', opacity:'0', left:(pos.left-$('#'+tipsID).width()-20+$(this).width()/2)+'px'});
		}
		$('#'+tipsID).stop().animate({opacity:'1'});
	}).mouseleave(function(){
		console.log('tip', 'out');
		var tipsID = $(this).attr('tips-id');
		$('#'+tipsID).stop().animate({opacity:'0'}, function(){
			$(this).remove();
		});
	});
});

// Superfish Menu
jQuery(document).ready(function() {
		$('#main-menu ul.menu').superfish({ 
		animation: {height:'show', opacity:'show'},
		delay:     300,
		speed:     300
		 });
});


// Toggle Script
jQuery(document).ready(function() {
	$('div.sh_toggle_text').click( function(){
				$(this).parent().find(".sh_toggle_content").slideToggle("slow");
				$(this).toggleClass("sh_toggle_text_opened");
			}
		);
});

// T
jQuery(document).ready(function(){
	$('.post-prev > a').hover( function(){ 
		$(this).find('.p-icon-left').addClass('p-icon-hover', 300);
		$(this).find('.p-title-left').addClass('p-title-left-hover', 300);
	}, function(){
		$(this).find('.p-icon-left').removeClass('p-icon-hover', 300);
		$(this).find('.p-title-left').removeClass('p-title-left-hover', 300);
	});
	
	$('.post-next > a').hover( function(){
		$(this).find('.p-icon-right').addClass('p-icon-hover', 300);
		$(this).find('.p-title-right').addClass('p-title-right-hover', 300);
	}, function(){
		$(this).find('.p-icon-right').removeClass('p-icon-hover', 300);
		$(this).find('.p-title-right').removeClass('p-title-right-hover', 300);
	});
});

// dForm hover
jQuery(document).ready(function(){
	// Form Focus
	$('.dform input[type=text], .dform select,  .dform textarea').focus(function(){
		$(this).parent().addClass('dFormInputFocus');
	}).blur(function(){
		$(this).parent().removeClass('dFormInputFocus');
	});
});

// NewsLetter
jQuery(document).ready(function(){
	$('.RB_Newsletter_Widget form').submit(function(){
		var value = $(this).find('input[name=address]').val();
		if(value.length>6){
			$(this).find('a').hide();
			$(this).append($('<div class="loading"></div>'));
			$.post(ajaxurl, {action:'addemailtonewsletter', address:value}, function(data){
				data = $.parseJSON(data);
				alert(data.msg);
				if(data.status=='OK'){
					$('.RB_Newsletter_Widget form').trigger('reset');
				}
				$('.RB_Newsletter_Widget .loading').remove();
				$('.RB_Newsletter_Widget form a').show();
			});
		}
		return false;
	});
});


/*Pop up animation*/
jQuery(document).ready(function() {
	$('#topPopupOpenner').click(function(){
		if($('#topPopupWrapper').is(':hidden'))
			$('#topPopupWrapper').slideDown(500, 'easeOutQuad', function(){
				$('#topPopupOpenner').removeClass('openicon').addClass('closeicon');
			});
		else
			$('#topPopupWrapper').slideUp(500, 'easeOutQuad', function(){
				$('#topPopupOpenner').removeClass('closeicon').addClass('openicon');
			});
	});
	
	$('#bottomPopupOpenner').click(function(){
		if($('#bottomPopupWrapper').is(':hidden')){
			$('html, body').animate({ scrollTop:$(document).height()+$('#bottomPopupWrapper').height()}, 500, 'easeOutQuad');
			$('#bottomPopupWrapper').slideDown(500, 'easeOutQuad', function(){
				$('#bottomPopupOpenner').removeClass('openicon').addClass('closeicon');				
			});
		}else
			$('#bottomPopupWrapper').slideUp(500, 'easeOutQuad', function(){
				$('#bottomPopupOpenner').removeClass('closeicon').addClass('openicon');
			});
	});
});

/* Flex Slider */
function applyFlexSlider(target){
	$(target).flexslider();
	$(target+" .flex-control-nav, "+target+" .flex-direction-nav").css("opacity","0");
	$(target).hover(function(){
		$(this).find(".flex-control-nav, .flex-direction-nav").animate({opacity:"1"}, 300);
	},
	function(){
		$(this).find(".flex-control-nav, .flex-direction-nav").animate({opacity:"0"}, 300);
	});
}

// First Load FlexSlider
jQuery(document).ready(function() {
	applyFlexSlider('.flexslider');
});

// Set Filter
function setFilter(catid){
	$('.portfolioFilter li[data-value='+catid+']').find('a').trigger('click');
}

// First Load Filter
jQuery(document).ready(function() {
	var $applications = $('.portfolioitems');
	var $data = $applications.clone();
	
	$('.portfolioFilter li a').click(function(e) {
		$(this).parent().parent().find('a').removeClass('selected');
		$(this).addClass('selected');
	
		closePortfolioDetail(true, null);
	
		var dataValue = $(this).parent().attr('data-value');
		if (dataValue=='all'){
			var $filteredData = $data.find('li');
		} else {
			var $filteredData = $data.find('li[data-type~="cat-' + dataValue + '"]');
		}

		// finally, call quicksand
		$('.hoverWrapper, .hoverWrapper a').hide();
		$applications.quicksand($filteredData, {
		  duration: 800,
		  easing: 'easeInOutQuad',
		  enhancement: function(){ 
			setImageAni();
			setPortfolioItems();
			hidePassiveItems();
			}
		}, function(){
			//
		});
	});
});

// Video Fit
$(document).ready(function(){
	$("body").fitVids();
});


// Portfolio Script
activeLoading = false;
jQuery(document).ready(function() {
	setPortfolioItems();
});

function setPortfolioItems(){
	$('.portfolioitem .image_frame a').click(function(){
		if(activeLoading) return false;
		var dataid = $(this).parent().parent().attr('data-id');
		if($("#portfoliodetail").attr('data-id') == dataid)	return false;
		if($("#portfoliodetail").length==0){
			createPortfolioDetail(this);
			loadPortfolioItem(dataid);
		}else{
			closePortfolioDetail(false, function(){
				loadPortfolioItem(dataid);
			});
		}
		return false;
	});
}

function goScrollPos(target){
	if($(target).length>0){
		if(!(($(target).offset().top+$(target).height())>$(window).scrollTop() && ($(target).offset().top+$(target).height())<($(window).scrollTop()+$(window).height())))
			$('html, body').animate({ scrollTop: $(target).offset().top-65 }, 500)
	}
}

function hidePassiveItems(){
	$('ul.portfolioitems .image_frame').not('.active-frame').each(function(i, n){
		imageAniHout(null, n);
	});
}

function loadPortfolioItem(itemid){
	activeLoading = true;
	
	$('ul.portfolioitems li .image_frame').removeClass('active-frame');
	$('ul.portfolioitems li[data-id='+itemid+']').find('.image_frame').addClass('active-frame');
	hidePassiveItems();
	imageAniHover(null, $('ul.portfolioitems li .active-frame'));
	
	$.post(ajaxurl, {'action':'get_portfolio_item_detail', 'itemid':itemid, 'fullwidth':(($('ul.portfolioitems').attr('data-side')=='withSidebar')?false:true)}, function(data){
			if(data!='Error'){
				$('#portfoliodetail').slideUp(800, 'easeOutQuad', function(){
					$('#portfoliodetail').html(data);
					$("#portfoliodetail").attr('data-id', itemid);
					applyPControls();
					applyFlexSlider('#portfoliodetail .flexslider');
					
					var imageTotal = $('#portfoliodetail img').length;
					var imageCount = 0;
					if(imageTotal>0)
					{
						$('#portfoliodetail img').load(function(){
							if(++imageCount == imageTotal){
								portfolioSlideDown();
								return true;
							}
						}).error(function(){
							if(++imageCount == imageTotal){
								portfolioSlideDown();
								return true;
							}
						});
					}else{
						portfolioSlideDown();
					}
				});
			}
		});	
}

function portfolioSlideDown(){
	$('#portfolioLoading').slideUp(400, 'easeOutQuad');
	$('#portfoliodetail .sh_3of4, #portfoliodetail .sh_2of4').css({opacity:0});
	$('#portfoliodetail .sh_1of4 > *').css({opacity:0});
	$('#portfoliodetail .sh_3of4, #portfoliodetail .sh_2of4').delay(300).animate({opacity:1}, 800, 'easeOutQuad');
	$('#portfoliodetail .sh_1of4 > *').each(function(i,n){
		$(this).delay(i*100+300).animate({opacity:1}, 400, 'easeOutQuad');
	});
	$('#portfoliodetail').slideDown(800, 'easeOutQuad', function(){
		activeLoading = false;
		goScrollPos("#portfolioWrapper");
		$("#portfoliodetail").fitVids();
	});
}

function createPortfolioDetail(obj){
	var dataside = $(obj).parent().parent().attr('data-side');
	
	if($('ul.portfolioFilter').length==1)
		$('ul.portfolioFilter').before($('<div id="portfolioWrapper"><div id="portfolioLoading" class="loading"></div><div id="portfoliodetail" data-id="" data-side="'+dataside+'" class="portfoliodetail_'+dataside+'"></div></div>').hide()); 
	else
		$('ul.portfolioitems').before($('<div id="portfolioWrapper" style="margin-top:20px;"><div id="portfolioLoading" class="loading" style="margin-top:20px;"></div><div id="portfoliodetail" data-id="" data-side="'+dataside+'" class="portfoliodetail_'+dataside+'" style="margin-bottom:20px;"></div></div>').hide()); 
	$('#portfolioWrapper').slideDown(400, 'easeOutQuad');
}

function closePortfolioDetail(remove, runFunction){
	$('#portfoliodetail').slideUp('slow', function(){
		if(!remove){
			$('#portfolioLoading').slideDown(400, 'easeOutQuad');
			if(typeof runFunction === 'function') runFunction();
		}else{
			$('#portfolioWrapper').slideUp(400, 'easeOutQuad', function(){
				$('#portfolioWrapper').remove();
				if(typeof runFunction === 'function') runFunction();
			});
		}
	});
}

function checkPControls(){
	if($('ul.portfolioitems li .active-frame').parent().is(':last-child'))
		$('#portfoliodetail .p-control-next').addClass('p-control-disabled');
	else
		$('#portfoliodetail .p-control-next').removeClass('p-control-disabled');
		
	if($('ul.portfolioitems li .active-frame').parent().is(':first-child'))
		$('#portfoliodetail .p-control-prev').addClass('p-control-disabled');
	else
		$('#portfoliodetail .p-control-prev').removeClass('p-control-disabled');
}

function applyPControls(){
	$('#portfoliodetail .p-control-close').click(portfolioClose);
	$('#portfoliodetail .p-control-next').click(portfolioNext);
	$('#portfoliodetail .p-control-prev').click(portfolioPrev);
	checkPControls();
}

function portfolioClose(){
	if(activeLoading) return false;
	$('ul.portfolioitems li .image_frame').removeClass('active-frame');
	closePortfolioDetail(true, function(){
		hidePassiveItems();
	});
}

function portfolioNext(){
	if(activeLoading) return false;
	if(!$('ul.portfolioitems li .active-frame').parent().is(':last-child'))
	{
		var nextItem = $('ul.portfolioitems li .active-frame').parent().next();
		$('ul.portfolioitems li.portfolioitem .active-frame').removeClass('active-frame');
		$(nextItem).find('.image_frame').addClass('active-frame');

		hidePassiveItems();
		imageAniHover(null, $(nextItem).find('.active-frame'));
		closePortfolioDetail(false, function(){
			loadPortfolioItem($(nextItem).attr('data-id'));
		});
	}
}

function portfolioPrev(){
	if(activeLoading) return false;
	if(!$('ul.portfolioitems li .active-frame').parent().is(':first-child'))
	{
		var prevItem = $('ul.portfolioitems li .active-frame').parent().prev();
		$('ul.portfolioitems li .active-frame').removeClass('active-frame');
		$(prevItem).find('.image_frame').addClass('active-frame');
		hidePassiveItems();
		imageAniHover(null, $(prevItem).find('.active-frame'));
		closePortfolioDetail(false, function(){
			loadPortfolioItem($(prevItem).attr('data-id'));
		});
	}
}


$(window).load(function(){
	setImageAni();
	$(window).bind('resize', function(){
		setImageAni();
		$('.list_carousel').trigger("destroy");
	});
});


function imageAniHover(event, obj){
	obj = (obj==undefined)?this:obj;
	$(obj).find('.hoverWrapper span').stop(true).delay(100).animate({opacity:'1'}, 300);
	$(obj).find('.hoverWrapperBg').stop(true).animate({opacity:'1'}, 300);
}
function imageAniHout(event, obj){
	obj = (obj==undefined)?this:obj;
	if(!$(obj).hasClass('active-frame')){
		$(obj).find('.hoverWrapper span').stop(true).animate({opacity:'0'}, 200);
		$(obj).find('.hoverWrapperBg').stop(true).delay(100).animate({opacity:'0'}, 300);
	}
};

function setImageAni()
{
	// Image Animation
	$('.image_frame a img').each(function(){
		// Set First Position and Size for Image Hover
		$(this).parent().parent().find('.hoverWrapperBg').css({width:$(this).width()+'px', height:$(this).height()+'px', opacity:'0'});
		$(this).parent().parent().find('.hoverWrapper').css({width:$(this).width()+'px', height:$(this).height()+'px'});
		$(this).parent().parent().find('.hoverWrapper span').stop(true,true).css({opacity:'0', left:(($(this).width()-32)/2)+'px', top:(($(this).height()-32)/2)+'px'});
		$(this).parent().click(function(event){
			event.stopPropagation();
		});
		// Set Image Hover Animation
		$(this).parent().parent().bind('mouseenter', imageAniHover).bind('mouseleave', imageAniHout);
		$(this).parent().parent().hover(imageAniHover, imageAniHout);
	});
}

// Randoma string generator
function randomString(size) {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var randomstring = '';
	for (var i=0; i<size; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

function setActiveSliderItem(sliderID, type)
{
	var curr = $("#slider"+sliderID).data("nivo:vars").currentSlide;
	if(type=="next")
	{
		if(curr<$("#slider"+sliderID).data("nivo:vars").totalSlides-1)
			curr++;
		else
			curr=0;
	}
	$(".slider-wrapper-"+sliderID+" .nivoController li").removeClass("selected");
	$(".slider-wrapper-"+sliderID+" .nivoController a[rel="+curr+"]").parent().addClass("selected");
}