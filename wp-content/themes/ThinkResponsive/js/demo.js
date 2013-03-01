// DEMO FUNCTIONS
var activeTheme = 'light';
var themeVars = {
				'@colorFirst' : '#333333',
				'@colorFirstTint' : '#666666',
				'@colorInverse' : '#ffffff',
				'@colorSecond' : '#0199fe',
				'@colorSecondInverse' : '#ffffff',
				'@colorBox' : '#333333',
				'@colorBoxInverse' : '#ffffff',
				'@colorFont' : '#666666',
				'@colorMenu' : '#333333',
				'@colorMenuFont' : '#ffffff',
				'@colorMenuInverse' : '#0199fe',
				'@colorHeaderFont' : '#333333',
				'@colorHeaderFontHover' : '#ffffff',
				'@colorMenuFontHover' : '#ffffff',
				'@colorMenuBorder' : '#000000',
				/*'@background_bg' : 'transparent url(\''+themeURL+'/images/whitediamond.png\') left top repeat scroll',*/
				'@background_bg' : 'transparent url(\'http://www.renklibeyaz.com/thinkresponsive/wp-content/uploads/settingsimages/63091069.jpg\') right bottom no-repeat fixed',
				'@theme_style' : "'"+activeTheme+"'",
				'@colorThemeBorder' : '#CCCCCC',
				'@themeBodyWrapperColor' : 'rgba(255,255,255,.9)'
				};
function changeTheme(tn){
	 $('#ThemeSwitch a').removeClass('selected');
	 $('#ThemeSwitch .'+tn).addClass('selected');
	 activeTheme = tn;
	 $.cookie("defTheme", tn, {path:'/'});
	 if(tn=='dark'){
		themeVars['@colorFirst'] = '#eeeeee';
		themeVars['@colorInverse'] = '#4d4d4d';
		themeVars['@colorFirstTint'] = '#6C6C6C';
		themeVars['@colorBox'] = '#4e4e4e';
		themeVars['@colorBoxInverse'] = '#e3e3e3';
		themeVars['@colorMenu'] = '#4e4e4e';
		themeVars['@colorThemeBorder'] = '#4e4e4e';
		themeVars['@colorMenuBorder'] = '#666666';
		themeVars['@colorHeaderFont'] = '#999999';
		//themeVars['@background_bg'] =	'transparent url(\''+themeURL+'/images/dark_geometric.png\') left top repeat scroll';
		themeVars['@theme_style'] = 	"'"+activeTheme+"'";
		themeVars['@ImagesDir'] = 	"'"+themeURL+'/'+"'";
		themeVars['@themeBodyWrapperColor'] = 	'rgba(0,0,0,.7)';
		
		less.modifyVars(themeVars);
		$(document).ready(function(){
			$('#logo img').attr('src', themeURL+'/images/dark_think_responsive_logo.png');
		});
	}else{
		themeVars['@colorFirst'] = '#333333';
		themeVars['@colorInverse'] = '#ffffff';
		themeVars['@colorFirstTint'] = '#666666';
		themeVars['@colorBox'] = '#333333';
		themeVars['@colorBoxInverse'] = '#ffffff';
		themeVars['@colorMenu'] = '#333333';
		themeVars['@colorThemeBorder'] = '#CCCCCC';
		themeVars['@colorMenuBorder'] = '#000000';
		themeVars['@colorHeaderFont'] = '#333333';
		//themeVars['@background_bg'] =	'transparent url(\''+themeURL+'/images/whitediamond.png\') left top repeat scroll';
		themeVars['@theme_style'] = 	"'"+activeTheme+"'";
		themeVars['@ImagesDir'] = 	"'"+themeURL+'/'+"'";
		themeVars['@themeBodyWrapperColor'] = 	'rgba(255,255,255,.9)';
		
		less.modifyVars(themeVars);
		$(document).ready(function(){
			$('#logo img').attr('src', themeURL+'/images/light_think_responsive_logo.png');
		});
	}
}
  
function DrawPicker(pickerID){
	mobileDevice = false;
	if( navigator.userAgent.match(/Android/i) || 
		navigator.userAgent.match(/webOS/i) ||
		navigator.userAgent.match(/iPhone/i) ||
		navigator.userAgent.match(/iPad/i) ||
		navigator.userAgent.match(/iPod/i)
		) mobileDevice = true;

	if(!isCanvasSupported() || mobileDevice){
		$('#palette').hide();
		return false;
	}
	
    var ctx = document.getElementById(pickerID).getContext('2d');
    var img = new Image();
    img.src = themeURL+'/images/280.png';
    img.onload = function(){
		ctx.drawImage(img,0,0,150,150);
	}
	
	var defColor = $.cookie("defColor");
	var defTheme = $.cookie("defTheme");
	var defPalette = $.cookie("defPalette");
	var defPaletteX = $.cookie("defPaletteX");
	var defPaletteY = $.cookie("defPaletteY");
	if(defColor!=null){
		setDemoColor(defColor);
		setDemoColorPreview(defColor);
	}
	if(defTheme)
		changeTheme(defTheme);
	if(defPalette=='hide')
		hidePalette();
	else if(defPalette==null){
		if((($(window).width()-940)/2)-40-$('#palette').width()<0){
			hidePalette();
		}
	}
	if(defPaletteX!=null && defPaletteY!=null){
		if(defPaletteX<20) defPaletteX = 20;
		if(defPaletteY<20) defPaletteY = 20;
		if(defPaletteX>$(window).width()) defPaletteX = $(window).width()-20;
		if(defPaletteY>$(window).height()) defPaletteY = $(window).height()-20;
		$('#palette').css({left:defPaletteX+'px', top:defPaletteY+'px'});
	}
	
	
	$('#paletteHeader .closeButton').click(hidePalette);
	$('#paletteHeader .openButton').click(showPalette);
	  
	$('#'+pickerID+', #colorPicker').bind('selectstart dragstart', rFalse);
	$('#'+pickerID+', #colorPicker').bind('mousedown', function(){
		$('#'+pickerID).bind('mousemove', {pickerID:pickerID},GetColor);
	});

	$('#'+pickerID+', #colorPicker').bind('mouseup', function(){
		$('#'+pickerID).unbind('mousemove', GetColor);
		$.cookie("defColor", $('#colorResult').html(), {path:'/'});
		setDemoColor($('#colorResult').html());
	});
	
	$('#paletteHeader').bind('mousedown', function(e){
		$(document).bind('selectstart dragstart', rFalse);
		if(typeof document.body.style.MozUserSelect!="undefined") //Firefox route
		document.body.style.MozUserSelect="none";
		
		$(document).bind('mouseup', function(){
			$.cookie('defPaletteX', $('#palette').offset().left, {path:'/'});
			$.cookie('defPaletteY', $('#palette').offset().top, {path:'/'});
			$(document).unbind('selectstart dragstart', rFalse);
			$(document).unbind('mousemove');
		});
		
		$(document).bind('mousemove', {fX:e.pageX, fY:e.pageY, pX:$('#palette').offset().left, pY:$('#palette').offset().top}, movePalette);
	});	 
}

function hidePalette(){
	$.cookie("defPalette", 'hide', {path:'/'});
	$('#paletteHeader .openButton').show();
	$('#paletteHeader .closeButton').hide();
	$('#paletteBody, #ThemeSwitch, #colorResult').hide();
}
function showPalette(){
	$.cookie("defPalette", 'show', {path:'/'});
	$('#paletteHeader .openButton').hide();
	$('#paletteHeader .closeButton').show();
	$('#paletteBody, #ThemeSwitch, #colorResult').show();
}

function setDemoColor(color){
	themeVars['@colorSecond'] =  color;
	themeVars['@colorMenuInverse'] =  color;
	themeVars['@ImagesDir'] = 	"'"+themeURL+'/'+"'";
	less.modifyVars(themeVars)
}
function setDemoColorPreview(color){
	$('#colorResult').html(color);
    $('#colorResult').css('background-color', color);
}

function movePalette(event){
	var x = (event.pageX-event.data.fX) + event.data.pX;
	var y = (event.pageY-event.data.fY) + event.data.pY;
	$('#palette').css({left:x+'px', top:y+'px'});
}
function GetColor(event){
        var x = event.pageX - $(event.currentTarget).parent().offset().left;
        var y = event.pageY - $(event.currentTarget).parent().offset().top;
        var ctx = document.getElementById(event.data.pickerID).getContext('2d');
        var imgd = ctx.getImageData(x, y, 1, 1);
        var data = imgd.data;
		$('#colorPicker').css({left:(x-5)+'px', top:(y-5)+'px'});
        var hexString = RGBtoHex(data[0],data[1],data[2]);
        setDemoColorPreview('#'+hexString);
}
function RGBtoHex(R,G,B) {return toHex(R)+toHex(G)+toHex(B)}
function toHex(N) {
      if (N==null) return "00";
      N=parseInt(N); if (N==0 || isNaN(N)) return "00";
      N=Math.max(0,N); N=Math.min(N,255); N=Math.round(N);
      return "0123456789ABCDEF".charAt((N-N%16)/16)
           + "0123456789ABCDEF".charAt(N%16);
}
function rFalse(event){ return false; }
function isCanvasSupported(){
  var elem = document.createElement('canvas');
  return !!(elem.getContext && elem.getContext('2d'));
}