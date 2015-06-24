<?php
function ccsu_customize_register( $wp_customize ) {
	
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Add an additional description to the header image section.
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'colors' );


	//$wp_customize->get_section( 'title_tagline' )->description = __( 'Applied to the header on small screens and the sidebar on wide screens.', 'ccsu' );

	$wp_customize->add_section( 'ccsu_footer_content', array(
		'title'		=> __( 'Footer Content', 'ccsu' ),
		'priority'	=> 120,
	) );
	$wp_customize->add_setting("welcome_text", array(
		"default" => " testing text ",
		"transport" => "postMessage",
	));
	$wp_customize->add_control(new Textarea_Custom_Control(
	$wp_customize,
	"welcome_text",
	array(
		"label" => __("Footer Welcome Text", "customizer_welcome_text_label"),
		"settings" => "welcome_text",
		"type" => "textarea",
		'section'     => 'ccsu_footer_content',
		)
	));
	$wp_customize->add_setting("contact_info", array(
		"default" => "",
		"transport" => "postMessage",
	));
	$wp_customize->add_control(new Textarea_Custom_Control(
	$wp_customize,
	"contact_info",
	array(
		"label" => __("Welcome Text", "customizer_contact_info_label"),
		"settings" => "contact_info",
		"type" => "textarea",
		'section'     => 'ccsu_footer_content',
		)
	));

	$wp_customize->add_setting(
	'social_fb',
	array(
		'default'    =>  'flase',
		'transport'  =>  'postMessage'
		)
	);
}
add_action( 'customize_register', 'ccsu_customize_register', 11 );

/**********************************************************************************
/
//////////////// Import the class file to render the textareas for input
/
**********************************************************************************/
require_once('class-textarea_custom_control.php');

/*function ccsu_custom_register($wp_customize) {
	$wp_customize->add_section( 'ccsu_welcome_text', array(
		'title'		=> __( 'Welcome Description', 'ccsu' ),
		'priority'	=> 35,
	) );
}

add_action('customize_register', 'ccsu_custom_register');*/
/*function ccsu_customize_register($wp_customize) 
{
	$wp_customize->add_setting("ads_code", array(
		"default" => " testing text ",
		"transport" => "postMessage",
	));
}
 
add_action("customize_register","ccsu_customize_register");*/

/*# Add checkbox section to enable Custom Text
$wp_customize->add_setting('ccsu_options[use_custom_text]', array(
    'capability' => 'activate_plugins',
    'type'       => 'option',
    'default'       => '1', # Default checked
));
 
$wp_customize->add_control('ccsu_options[use_custom_text]', array(
    'settings' => 'ccsu_options[use_custom_text]',
    'label'    => __('Display Custom Text', 'ccsu'),
    'section'  => 'layout_section', # Layout Section
    'type'     => 'checkbox', # Type of control: checkbox
));
 
# Add text input form to change custom text
$wp_customize->add_setting('ccsu_options[custom_text]', array(
    'capability' => 'edit_theme_options',
    'type'       => 'option',
    'default'       => 'Custom text', # Default custom text
));
 
$wp_customize->add_control('ccsu_options[custom_text]', array(
        'label' => 'Custom text', # Label of text form
        'section' => 'layout_section', # Layout Section
        'type' => 'text', # Type of control: text input
));*/
?>