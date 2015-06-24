<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Test data
	$theme_footer_widgets = array(
		'3' => __('Three', 'options_check'),
		'4' => __('Four', 'options_check')
	);
	
	$theme_layout_array = array(
		'boxed' => __('Boxed', 'options_check'),
		'wide' => __('Wide', 'options_check')
	);
	
	$wider_sidebar = array(
		'1' => __('Yes', 'options_check'),
		'0' => __('No', 'options_check')
	);	

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_check'),
		'two' => __('Pancake', 'options_check'),
		'three' => __('Omelette', 'options_check'),
		'four' => __('Crepe', 'options_check'),
		'five' => __('Waffle', 'options_check')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	
	$imagepath =  get_template_directory_uri() . '/inc/admin/images/';

	$options = array();
	
	//Settings for Basic Settings Tab
			
		
	$options[] = array(
		'name' => __('Main Slider Settings', 'options_check'),
		'type' => 'heading');	
		
	$options[] = array(
		'name' => __('Settings for Slider on Home page.', 'options_check'),
		'desc' => __('Check to display Slider. Defaults to False.', 'options_check'),
		'id' => 'display_slider',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Slider Speed', 'options_check'),
		'desc' => __('Set Slider Interval (in miliseconds).', 'options_check'),
		'id' => 'slider_interval',
		'std' => '2500',
		'type' => 'text');

	$options[] = array(
		'name' => __('Slider Pause on Mouse Hover', 'options_check'),
		'desc' => __('Check if you want Slider to pause on mouse hover.', 'options_check'),
		'id' => 'pause_on_hover',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Slider Image 1', 'options_check'),
		'desc' => __('Set image for slider. Preferred size 621x266', 'options_check'),
		'id' => 'slider_img_1',
		'type' => 'upload');
		
	$options[] = array(		
		'desc' => __('Heading of Image 1.', 'options_check'),
		'id' => 'slider_image_heading_1',
		'std' => 'Heading 1',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Caption of Image 1. 36 words or less.', 'options_check'),
		'id' => 'slider_image_caption_1',
		'std' => 'Caption 1',
		'type' => 'textarea');

	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_1',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button.', 'options_check'),
		'id' => 'slider_image_button_1_link',
		'type' => 'text');

	$options[] = array(
		'name' => __('Slider Image 2', 'options_check'),
		'desc' => __('Set image for slider. Preferred size 621x266', 'options_check'),
		'id' => 'slider_img_2',
		'type' => 'upload');
		
	$options[] = array(		
		'desc' => __('Heading of Image 2.', 'options_check'),
		'id' => 'slider_image_heading_2',
		'std' => 'Heading 2',
		'type' => 'text');	
		
	$options[] = array(		
		'desc' => __('Caption of Image 2. 36 words or less.', 'options_check'),
		'id' => 'slider_image_caption_2',
		'std' => 'Caption 2',
		'type' => 'textarea');
		
	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_2',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'slider_image_button_2_link',
		'type' => 'text');

	$options[] = array(
		'name' => __('Slider Image 3', 'options_check'),
		'desc' => __('Set image for slider. Will be Cropped to 621x266', 'options_check'),
		'id' => 'slider_img_3',
		'type' => 'upload');	

	$options[] = array(		
		'desc' => __('Heading of Image 3.', 'options_check'),
		'id' => 'slider_image_heading_3',
		'std' => 'Heading 3',
		'type' => 'text');	
		
	$options[] = array(		
		'desc' => __('Caption of Image 3.', 'options_check'),
		'id' => 'slider_image_caption_3',
		'std' => 'Caption 3',
		'type' => 'textarea');

	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_3',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'slider_image_button_3_link',
		'type' => 'select',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Slider Image 4', 'options_check'),
		'desc' => __('Set image for slider. Preferred size 621x266', 'options_check'),
		'id' => 'slider_img_4',
		'type' => 'upload');	

	$options[] = array(		
		'desc' => __('Heading of Image 4.', 'options_check'),
		'id' => 'slider_image_heading_4',
		'std' => 'Heading 4',
		'type' => 'text');	
		
	$options[] = array(		
		'desc' => __('Caption of Image 4.', 'options_check'),
		'id' => 'slider_image_caption_4',
		'std' => 'Caption 4',
		'type' => 'textarea');
		
	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_4',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'slider_image_button_4_link',
		'type' => 'select',
		'type' => 'text');	

		
	$options[] = array(
		'name' => __('Slider Image 5', 'options_check'),
		'desc' => __('Set image for slider. Preferred size 621x266', 'options_check'),
		'id' => 'slider_img_5',
		'type' => 'upload');	

	$options[] = array(		
		'desc' => __('Heading of Image 5.', 'options_check'),
		'id' => 'slider_image_heading_5',
		'std' => 'Heading 5',
		'type' => 'text');	
		
	$options[] = array(		
		'desc' => __('Caption of Image 5.', 'options_check'),
		'id' => 'slider_image_caption_5',
		'std' => 'Caption 5',
		'type' => 'textarea');
		
	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_5',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'slider_image_button_5_link',
		'type' => 'select',
		'type' => 'text');	

		
	$options[] = array(
		'name' => __('Slider Image 6', 'options_check'),
		'desc' => __('Set image for slider. Preferred size 621x266', 'options_check'),
		'id' => 'slider_img_6',
		'type' => 'upload');	

	$options[] = array(		
		'desc' => __('Heading of Image 6.', 'options_check'),
		'id' => 'slider_image_heading_6',
		'std' => 'Heading 6',
		'type' => 'text');	
		
	$options[] = array(		
		'desc' => __('Caption of Image 6.', 'options_check'),
		'id' => 'slider_image_caption_6',
		'std' => 'Caption 6',
		'type' => 'textarea');
		
	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_6',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'slider_image_button_6_link',
		'type' => 'select',
		'type' => 'text');	

		
	$options[] = array(
		'name' => __('Slider Image 7', 'options_check'),
		'desc' => __('Set image for slider. Preferred size 621x266', 'options_check'),
		'id' => 'slider_img_7',
		'type' => 'upload');	

	$options[] = array(		
		'desc' => __('Heading of Image 7.', 'options_check'),
		'id' => 'slider_image_heading_7',
		'std' => 'Heading 7',
		'type' => 'text');	
		
	$options[] = array(		
		'desc' => __('Caption of Image 7.', 'options_check'),
		'id' => 'slider_image_caption_7',
		'std' => 'Caption 7',
		'type' => 'textarea');
		
	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_7',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'slider_image_button_7_link',
		'type' => 'select',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Slider Image 8', 'options_check'),
		'desc' => __('Set image for slider. Preferred size 621x266', 'options_check'),
		'id' => 'slider_img_8',
		'type' => 'upload');	

	$options[] = array(		
		'desc' => __('Heading of Image 8.', 'options_check'),
		'id' => 'slider_image_heading_8',
		'std' => 'Heading 8',
		'type' => 'text');	
		
	$options[] = array(		
		'desc' => __('Caption of Image 8.', 'options_check'),
		'id' => 'slider_image_caption_8',
		'std' => 'Caption 8',
		'type' => 'textarea');
		
	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_8',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'slider_image_button_8_link',
		'type' => 'select',
		'type' => 'text');	

		
	$options[] = array(
		'name' => __('Slider Image 9', 'options_check'),
		'desc' => __('Set image for slider. Preferred size 621x266', 'options_check'),
		'id' => 'slider_img_9',
		'type' => 'upload');	

	$options[] = array(		
		'desc' => __('Heading of Image 9.', 'options_check'),
		'id' => 'slider_image_heading_9',
		'std' => 'Heading 9',
		'type' => 'text');	
		
	$options[] = array(		
		'desc' => __('Caption of Image 9.', 'options_check'),
		'id' => 'slider_image_caption_9',
		'std' => 'Caption 9',
		'type' => 'textarea');
		
	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'slider_image_button_9',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'slider_image_button_9_link',
		'type' => 'select',
		'type' => 'text');

//This is for the  Ad and Lunch Menu in the lower right of the Hompage

	$options[] = array(
		'name' => __( 'Ad and Menu', 'theme-textdomain' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __('Lunch Menu Settings', 'options_check'),
		'desc' => __('<b>Following section will allow you to set text and button settings</b>', 'options_check'),
		'type' => 'info');		
		
	$options[] = array(
		//'name' => __('Check to display Ad Text on home page.', 'options_check'),
		'desc' => __('Check to display the lunch menu on home page.', 'options_check'),
		'id' => 'display_menu',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Ad Settings - Following section allows you to configure your Ad on front page.', 'options_check'),
		'desc' => __('<b>Following section will allow you to set text and button settings</b>', 'options_check'),
		'type' => 'info');		
		
	$options[] = array(
		//'name' => __('Check to display Ad Text on home page.', 'options_check'),
		'desc' => __('Check to display Ad on home page.', 'options_check'),
		'id' => 'display_ad',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Ad Button', 'options_check'),
		'desc' => __('Ad image. Preferred size 310x280', 'options_check'),
		'id' => 'ad_img',
		'type' => 'upload');
		
	$options[] = array(
		//'name' => __('Ad Text', 'options_check'),
		'desc' => __('Enter text here to be displayed in Ad Heading. (optional) ', 'options_check'),
		'id' => 'ad_heading',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		//'name' => __('Ad Text', 'options_check'),
		'desc' => __('Enter text here to be displayed in Ad Section.', 'options_check'),
		'id' => 'ad_text',
		'std' => 'Special Announcement',
		'type' => 'textarea');	
		
	$options[] = array(
		//'name' => __('Ad Button Title', 'options_check'),
		'desc' => __('Set title for Ad Button.', 'options_check'),
		'id' => 'ad_button_title',
		'std' => 'Get In Touch',
		'type' => 'text');
		
	$options[] = array(
		//'name' => __('Select a Page to link to Ad Button', 'options_check'),
		'desc' => __('Link for Ad Button', 'options_check'),
		'id' => 'ad_button_link',
		'type' => 'text');

//This is for the Announcements of the Hompage

	$options[] = array(
		'name' => __( 'Inline Announcement', 'theme-textdomain' ),
		'type' => 'heading'
	);

	$options[] = array(
		//'name' => __('Check to display annoucment Text on home page.', 'options_check'),
		'desc' => __('Check to display the announcement on home page.', 'options_check'),
		'id' => 'display_announ',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __( 'Colorpicker', 'theme-textdomain' ),
		'desc' => __( 'Changes the color of the graphic on the homepage', 'theme-textdomain' ),
		'id' => 'announce_colorpicker',
		'std' => '#FF00D5',
		'type' => 'color'
	);

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	$options[] = array(
		'name' => __( 'Add an announcement', 'theme-textdomain' ),
		'desc' => sprintf( __( 'This will place an announcement on the homepage', 'theme-textdomain' ) ),
		'id' => 'announce_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);
		
	$options[] = array(		
		'desc' => __('Set title for Button.', 'options_check'),
		'id' => 'announce_button',
		'std' => 'Learn more',
		'type' => 'text');
		
	$options[] = array(		
		'desc' => __('Link for Button', 'options_check'),
		'id' => 'announce_button_link',
		'type' => 'select',
		'type' => 'text');


//This is for the pop-over nag of the Hompage

	$options[] = array(
		'name' => __( 'popover', 'theme-textdomain' ),
		'type' => 'heading'
	);

	$options[] = array(
		//'name' => __('Check to display annoucment Text on home page.', 'options_check'),
		'desc' => __('Check to display the pop-over on home page.', 'options_check'),
		'id' => 'display_pop',
		'std' => '0',
		'type' => 'checkbox');

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	$options[] = array(
		'name' => __( 'Add a Popover', 'theme-textdomain' ),
		'desc' => sprintf( __( 'This will create a pop-over on the homepage. Use <u>sparingly</u>', 'theme-textdomain' ) ),
		'id' => 'pop_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);
	
	return $options;
}