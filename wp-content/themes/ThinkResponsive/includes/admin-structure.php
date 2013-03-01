<?php

// options
$SettingsOptions = array(
	array(
		'id' => 'themecheck',
		'name'=>__('THEME CHECK','rb'),
		'type'=>'script',
		'imagemanager'=>'false',
		'icon'=>get_template_directory_uri().'/includes/adminimages/icon_themecheck.png',
		'run'=>'themeCheck'
	),
	array(
		'id' => 'setGeneral',
		'name'=>__('GENERAL SETTINGS','rb'),
		'type'=>'fields',
		'imagemanager'=>'true',
		'icon'=>get_template_directory_uri().'/includes/adminimages/icon_picker.png',
		'fields'=> array(
			array(
				'id' => 'top_popup',
				'name' => __('Top Pop Up Open','rb'),
				'default' => 'false',
				'type'=>'onoff',
				'on'=>'true',
				'off'=>'false'
			),
			array(
				'id' => 'bottom_popup',
				'name' => __('Bottom Pop Up Open','rb'),
				'default' => 'false',
				'type'=>'onoff',
				'on'=>'true',
				'off'=>'false'
			),
			array(
				'id'=>'logo',
				'name'=>__('Logo Url','rb'),
				'default'=> get_template_directory_uri().'/images/light_think_responsive_logo.png',
				'type'=>'url'
			),
			array(
				'id' => 'favicon',
				'name' => __('Favicon (.ico file)','rb'),
				'default' => get_template_directory_uri().'/images/favicon.ico',
				'type' => 'url'
			),
			array(
				'id' => 'googlecode',
				'name' => __('Google Analytics Code','rb'),
				'default' => '',
				'type' => 'text'
			),
			array(
				'id' => 'sidebardefault',
				'name' => __('Default Sidebar Position on Page','rb'),
				'default' => 'Right',
				'options' => array(__('None','rb')=>'None', __('Left','rb')=>'Left', __('Right','rb')=>'Right'),
				'type' => 'select'
			),
			array(
				'id' => 'sidebarsingledefault',
				'name' => __('Default Sidebar Position on Post Detail','rb'),
				'default' => 'Right',
				'options' => array(__('None','rb')=>'None', __('Left','rb')=>'Left', __('Right','rb')=>'Right'),
				'type' => 'select'
			),
			array(
				'id' => 'newscoutanddownload',
				'name' => __('News Widget Record Count','rb'),
				'type' => 'newsletter'
			)
		)
	),
	array(
		'id' => 'style',
		'name'=>__('STYLE OPTIONS','rb'),
		'type'=>'fields',
		'imagemanager'=>'true',
		'icon'=>get_template_directory_uri().'/includes/adminimages/icon_generalsettings.png',
		'fields'=> array(
			array(
				'id' => 'theme_style',
				'name' => __('Theme Style','rb'),
				'default' => 'light',
				'type'=>'select',
				'options'=>array(__('Light','rb')=>'light', __('Dark','rb')=>'dark')
			),
			array(
				'id' => 'usecontentbgcolor',
				'name' => __('Use Content Bg Color','rb'),
				'default' => 'false',
				'type'=>'onoff',
				'on'=>'true',
				'off'=>'false'
			),
			array(
				'id' => 'colorFirst',
				'name' => __('First Color','rb'),
				'default' => '333333',
				'type'=>'color'
			),
			array(
				'id' => 'colorInverse',
				'name' => __('First Color Inverse','rb'),
				'default' => 'ffffff',
				'type'=>'color'
			),
			array(
				'id'=>'colorSecond',
				'name'=>__('Color Second','rb'),
				'default'=> '0199fe',
				'type'=>'color'
			),
			array(
				'id'=>'colorSecondInverse',
				'name'=>__('Second Color Inverse','rb'),
				'default'=> 'ffffff',
				'type'=>'color'
			),
			array(
				'id' => 'colorBox',
				'name' => __('Box Color','rb'),
				'default' => '333333',
				'type'=>'color'
			),
			array(
				'id' => 'colorFirstTint',
				'name' => __('Box Color Tint','rb'),
				'default' => '666666',
				'type'=>'color'
			),
			array(
				'id' => 'colorBoxInverse',
				'name' => __('Box Inverse Color','rb'),
				'default' => 'ffffff',
				'type'=>'color'
			),
			array(
				'id' => 'background_bg',
				'name' => __('Background Pattern','rb'),
				'default' => "transparent url('".get_template_directory_uri()."/images/whitediamond.png') left top repeat scroll",
				'type' => 'background'
			),
			array(
				'id' => 'colorMenu',
				'name' => __('Menu Color','rb'),
				'default'=>'333333',
				'type'=>'color'
			),
			array(
				'id' => 'colorMenuFont',
				'name' => __('Menu Text Color','rb'),
				'default'=>'ffffff',
				'type'=>'color'
			),
			array(
				'id' => 'colorMenuInverse',
				'name' => __('Inverse Color of Menu','rb'),
				'default'=>'0199fe',
				'type'=>'color'
			),
			array(
				'id' => 'colorHeaderFont',
				'name' => __('Header Text Color on Menu','rb'),
				'default'=>'333333',
				'type'=>'color'
			),
			array(
				'id' => 'colorHeaderFontHover',
				'name' => __('Hover Color of Header Text on Menu','rb'),
				'default'=>'ffffff',
				'type'=>'color'
			),
			array(
				'id' => 'colorMenuFontHover',
				'name' => __('Hover Color of Text on Menu','rb'),
				'default'=>'ffffff',
				'type'=>'color'
			),
			array(
				'id' => 'colorMenuBorder',
				'name' => __('Color of Menu Border','rb'),
				'default'=>'000000',
				'type'=>'color'
			)
		)
	),
	array(
		'id' => 'textoptions',
		'name'=>__('TEXT OPTIONS','rb'),
		'type'=>'fields',
		'imagemanager'=>'false',
		'icon'=>get_template_directory_uri().'/includes/adminimages/icon_textoptions.png',
		'fields'=> array(
			array(
				'id' => 'colorFont',
				'name' => __('Font Color','rb'),
				'default' => '999999',
				'type'=>'color'
			),
			array(
				'id' => 'headerFont',
				'name' => __('Header Font','rb'),
				'default' => 'Alegreya SC',
				'type'=>'font'
			),
			array(
				'id' => 'contentFont',
				'name' => __('Content Font','rb'),
				'default' => 'PT Sans Narrow',
				'type'=>'font'
			),
			array(
				'id' => 'contentFontSize',
				'name' => __('Content Font','rb'),
				'default' => '12',
				'type'=>'integer',
				'after'=>' px'
			),
			array(
				'id' => 'menuHeaderFontSize',
				'name' => __('Menu Header Text Size','rb'),
				'default' => '14',
				'type'=>'integer',
				'after'=>' px'
			),	
			array(
				'id' => 'menuFontSize',
				'name' => __('Menu Text Size','rb'),
				'default' => '14',
				'type'=>'integer',
				'after'=>' px'
			),
			array(
				'id' => 'h1FontSize',
				'name' => __('H1 Text Size','rb'),
				'default' => '36',
				'type'=>'integer',
				'after'=>' px'
			),
			array(
				'id' => 'h2FontSize',
				'name' => __('H2 Text Size','rb'),
				'default' => '30',
				'type'=>'integer',
				'after'=>' px'
			),
			array(
				'id' => 'h3FontSize',
				'name' => __('H3 Text Size','rb'),
				'default' => '24',
				'type'=>'integer',
				'after'=>' px'
			),
			array(
				'id' => 'h4FontSize',
				'name' => __('H4 Text Size','rb'),
				'default' => '20',
				'type'=>'integer',
				'after'=>' px'
			),
			array(
				'id' => 'h5FontSize',
				'name' => __('H5 Text Size','rb'),
				'default' => '18',
				'type'=>'integer',
				'after'=>' px'
			),
			array(
				'id' => 'h6FontSize',
				'name' => __('H6 Text Size','rb'),
				'default' => '14',
				'type'=>'integer',
				'after'=>' px'
			)
		)
	),
	array(
		'id' => 'gallerymanager',
		'name'=>__('GALLERY MANAGER','rb'),
		'imagemanager'=>'false',
		'icon'=>get_template_directory_uri().'/includes/adminimages/icon_gallerymanager.png',
		'type'=>'script',
		'run'=>'getGalleriesList'
	),
	array(
		'id' => 'help',
		'imagemanager'=>'false',
		'icon'=>get_template_directory_uri().'/includes/adminimages/icon_help.png',
		'name'=>__('HELP','rb'),
		'type'=>'area'
	)
);

?>