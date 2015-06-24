<?php

//Initialize the update checker.
require 'theme-updates/theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
	'ccsu',
	'http://https://district.ccsuvt.org/themes/ccsu/info.json'
);

define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/options-framework/' );
require_once dirname( __FILE__ ) . '/options-framework/options-framework.php';
require_once get_template_directory() . '/options.php';

// Disable update emails
add_filter( 'auto_core_update_send_email', '__return_false' );

function add_custom_type_to_tag_archive( $query ) // this is used on the tag.php so we can display the attachments 
{
	if ( ! is_main_query() or ! is_tag() )
		return $query;

	$term_id = get_query_var('tag_id');
	$terms = get_term_by('id', $term_id, 'post_tag');

	$query->set( 'post_type', 'attachment' );
	$query->set( 'tax_query', array(
					array(
						'taxonomy' => 'homepagetag',
						'field' => 'slug',
						'terms' => $terms->slug
					)
				) );
	$query->set( 'posts_per_page', 20 );

    return $query;
}

//add_filter( 'pre_get_posts', 'add_custom_type_to_tag_archive' );

add_action( 'template_redirect', 'my_template_redirect' );

function my_template_redirect() {
	global $post, $wp_query;
	if (strpos($_SERVER['REQUEST_URI'], 'tag/')) { // so that the tag.php is used. The 404 template comes up because index uses the count of post tags.
		include TEMPLATEPATH . '/tag.php';
		die();
	}
}

add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
	return 'class="btn btn-custom"';
}

function register_scripts(){

	// uncomment the line below if your theme does nto have jQuery loaded
	wp_register_script( 'jquery', CCSU_STYLE . '/js/vendor/jquery-1.11.1.min.js' );

	wp_register_script( 'fancybox', CCSU_STYLE . '/js/vendor/fancybox/jquery.fancybox.js?v=2.1.5', array( 'jquery' ) );
	wp_register_script( 'bootstrap', CCSU_STYLE . '/js/vendor/bootstrap/bootstrap.min.js', array( 'jquery' ) );
	wp_register_script( 'custom_js', CCSU_STYLE . '/js/scripts.js', array( 'bootstrap' ) );
	// This Loads a Script to Enable Cookies
	wp_register_script( 'cookie_js', CCSU_STYLE . '/js/vendor/jquery.cookie.js', array( 'jquery' ) );
	// This Loads a Script to Add Ratings to feedback
	wp_register_script( 'ratings_js', CCSU_STYLE . '/js/vendor/bootstrap-rating-input.min.js', array( 'jquery' ) );

	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css' );
	//wp_enqueue_style( 'bootstrap-theme-css', CCSU_STYLE . '/css/bootstrap/bootstrap-theme.min.css' );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );
	//wp_enqueue_style( 'style-css', get_stylesheet_uri(), 15 );
	wp_enqueue_style( 'fancybox-css', CCSU_STYLE . '/js/vendor/fancybox/jquery.fancybox.css?v=2.1.5' );

	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'fancybox' );
	wp_enqueue_script( 'custom_js' );
	wp_enqueue_script( 'cookie_js' );
	wp_enqueue_script( 'ratings_js' );

}

add_action( 'wp_enqueue_scripts', 'register_scripts' );

function register_childcss() {
	wp_enqueue_style( 'style-css', get_stylesheet_uri() );
}
add_action('wp_enqueue_scripts', 'register_childcss', 15);

function wpb_add_google_fonts() {
	wp_register_style('wpb-googleFonts', '//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic|Droid+Serif:400,700,400italic,700italic|Roboto+Slab:400|Open+Sans:400');
	wp_enqueue_style( 'wpb-googleFonts');
}
add_action('wp_print_styles', 'wpb_add_google_fonts');

add_action('init', 'add_taxonomy_objects');

function add_taxonomy_objects() {
	//register_taxonomy_for_object_type( 'post_tag', 'attachment' ); // allows us to search the post_tag on attachements
	//register_taxonomy_for_object_type('category', 'attachment');
	$labels = array( // making a custom post type for the homepage to speed hompage response
		'name'              => _x( 'Tags', 'taxonomy general name' ),
		'singular_name'     => _x( 'Tag', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Tags' ),
		'all_items'         => __( 'All Tags' ),
		'parent_item'       => __( 'Parent Tag' ),
		'parent_item_colon' => __( 'Parent Tag:' ),
		'edit_item'         => __( 'Edit Tag' ),
		'update_item'       => __( 'Update Tag' ),
		'add_new_item'      => __( 'Add New Tag' ),
		'new_item_name'     => __( 'New Tag Name' ),
		'menu_name'         => __( 'Tag' ),
	);
	$args = array(
		'hierarchical'		=> false,
		'labels'			=> $labels,
		'show_ui'		=> true,
		'show_admin_column' 	=> true,
		'query_var'		=> true,
		'rewrite'		=> array( 'slug' => 'homepage' ),
	);
	register_taxonomy('homepagetag', 'attachment',$args); 
}

// ensure all tags are included in queries
function tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
	if ($wp_query->get('category')) $wp_query->set('post_type', 'any');
}
// tag hooks
add_action('pre_get_posts', 'tags_support_query');


/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @since 1.0
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */
function gallery_tiles_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'		=> 'ASC',
		'orderby'	=> 'menu_order ID',
		'id'		=> $post ? $post->ID : 0,
		'itemtag'	=> 'dl',
		'icontag'	=> 'dt',
		'captiontag'	=> 'dd',
		'columns'	=> 3,
		'size'		=> 'slideshow-thumb',
		'class'		=> 'fancybox',
		'include'	=> '',
		'exclude'	=> '',
		'link'		=> ''
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		
	$size_class = sanitize_html_class( $size );

	$gallery_div = "<ul id='$selector' class='gallery-grid galleryid-{$id} '>";

	$output = apply_filters( 'gallery_style', '' . "\n\t\t" . $gallery_div );

	foreach ( $attachments as $id => $attachment ) {
		if ( ! empty( $link ) && 'file' === $link ) {
			$image_output = wp_get_attachment_link( $id, $size, false, false );
			$image_output = str_replace('<a','<a class="fancybox"',$image_output);
		} elseif ( ! empty( $link ) && 'none' === $link ) {
			$image_output = wp_get_attachment_image( $id, $size, false );
		}
		else {
			$image_output = wp_get_attachment_link( $id, $size, true, false );
		}
		
		$image_output = str_replace('http://','//',$image_output);
		$output .= '<li class="gallery-item">'.$image_output.'<span>'.wptexturize($attachment->post_excerpt).'</span></li>';
	}
	$output .= '</ul>';

	return $output;
}

add_shortcode('gallery_tiles','gallery_tiles_shortcode');

/**
 * The Ken Burns Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * http://www.github.com/toymakerlabs/kenburns/
 *
 * @since 1.0
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */
function kenburns_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'		=> 'ASC',
		'orderby'	=> 'menu_order ID',
		'id'		=> $post ? $post->ID : 0,
		'itemtag'	=> 'dl',
		'icontag'	=> 'dt',
		'captiontag'	=> 'dd',
		'columns'	=> 3,
		'size'		=> 'slideshow-thumb',
		'class'		=> 'fancybox',
		'include'	=> '',
		'exclude'	=> '',
		'link'		=> ''
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		
	$size_class = sanitize_html_class( $size );

	$output = "<script type=\"text/javascript\" src=\"https://content.ccsuvt.org/custom/js/kenburns-slideshow/js/kenburns.js\"></script>\n";
	$output .= "<style type=\"text/css\">@import url(\"https://content.ccsuvt.org/custom/js/kenburns-slideshow/css/style.css\")</style>\n";
	$output .= "<div id=\"kenburns-slideshow\"></div>";
	$output .= "<div id=\"kenburns-description\">";
	$output .= "<h1 id=\"status\">Loading Images..</h1>";
	$output .= "<h1 id=\"slide-title\"></h1><br>";
	$output .= "</div><!-- eo kb slideshow -->\n";
	$output .= "<p>Ken Burns effect adapted from: <a href=\"http://www.github.com/toymakerlabs/kenburns/\" target=\"blank\"> toymakerlabs</a></p>";

	$output .= "<script type=\"text/javascript\">";
	$images = '';
	$output .= "
	var titles = [\"\"];/* titles */

	jQuery(document).ready(function() {
	    jQuery('#kenburns-slideshow').Kenburns({
	    	images: [ ";
	foreach ( $attachments as $id => $attachment ) {
		/*if ( ! empty( $link ) && 'file' === $link ) {
			$image_output = wp_get_attachment_link( $id, $size, false, false );
			$image_output = str_replace('<a','<a class="fancybox" rel="kenburns"',$image_output);
		} elseif ( ! empty( $link ) && 'none' === $link ) {
			$image_output = wp_get_attachment_image( $id, $size, false );
		}
		else {
			$image_output = wp_get_attachment_link( $id, $size, true, false );
		}*/
		$image_output = wp_get_attachment_image_src( $id, $size, false );
		$image_output = str_replace('http://','//',$image_output);
		$output .= "\"" . $image_output[0] . "\","; // list the images for output
	}
	    	$output .= "],
	    	scale:.95,
	    	duration:6000,
	    	fadeSpeed:1200,
	    	ease3d:'cubic-bezier(0.445, 0.050, 0.550, 0.950)',

	    	onSlideComplete: function(){
	    		jQuery('#slide-title').html(titles[this.getSlideIndex()]);
	    	},
	    	onLoadingComplete: function(){
	    		jQuery('#status').html(\"Loading Complete\");
	    	}

	    });
	});
	</script>";
	/*$gallery_div = "<ul id='$selector' class=''>";

	$output .= apply_filters( 'gallery_style', '' . "\n\t\t" . $gallery_div );

	foreach ( $attachments as $id => $attachment ) {
		if ( ! empty( $link ) && 'file' === $link ) {
			$image_output = wp_get_attachment_link( $id, $size, false, false );
			$image_output = str_replace('<a','<a class="fancybox" rel="kenburns"',$image_output);
		} elseif ( ! empty( $link ) && 'none' === $link ) {
			$image_output = wp_get_attachment_image( $id, $size, false );
		}
		else {
			$image_output = wp_get_attachment_link( $id, $size, true, false );
		}
		
		$image_output = str_replace('http','https',$image_output);
		$output .= '<li class="">'.$image_output.'<span>'.wptexturize($attachment->post_excerpt).'</span></li>';
	}
	$output .= '</ul>';*/

	return $output;
}

add_shortcode('kenburns_gallery','kenburns_gallery_shortcode');


function ccsu_widgets_init() {
	register_sidebar( array(
		'name' => 'Footer Welcome',
		'id' => 'footer-welcome',
		'description' => 'Welcome Message appears in the footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer Contact Address',
		'id' => 'footer-address',
		'description' => 'Address and phone of CCSU',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer Social Icons',
		'id' => 'footer-social',
		'description' => 'Social Links to be added to the footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

add_action('widgets_init','ccsu_widgets_init');

add_theme_support('menus');

if ( !current_user_can( 'manage_options' ) ) {
	show_admin_bar( false ); //hide the admin bar for everyone but the admins of the site
}

function register_my_menus() {
	register_nav_menus(
		array(
			'quicknav' => __( 'Quick Navigation Menu', 'CCSU' ),
			'leftnav' => __( 'Left Navigation Menu', 'CCSU' ),
			'footernav' => __( 'Footer Navigation Menu', 'CCSU' ),
			'footersocialnav' => __( 'Footer Social Menu', 'CCSU' )
		)
	);
}
add_action( 'admin_init', 'register_my_menus' );

add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
	$admin_bar->add_menu( array(
		'id'    => 'fpoptions',
		'title' => 'Front Page Options',
		'href'  => '/wp-admin/themes.php?page=options-framework',
		'meta'  => array(
			'title' => __('Front Page Options'),
		),
	));
	$admin_bar->add_menu( array(
		'id'    => 'help',
		'title' => 'Help With Wordpress',
		'href'  => 'http://www.ccsuvt.org/technology/wphelp',
		'meta'  => array(
			'title' => __('fpo'),
			'target' => __('_blank'),
		),
	));
	$admin_bar->add_menu( array(
		'id'    => 'posthelp',
		'parent' => 'help',
		'title' => 'Help with Post or Page',
		'href'  => 'http://www.ccsuvt.org/technology/wphelp/posts-and-page',
		'meta'  => array(
			'title' => __('Help with Post or Page'),
			'target' => '_blank',
		),
	));
	$admin_bar->add_menu( array(
		'id'    => 'fpohelp',
		'parent' => 'help',
		'title' => 'Help with Front Page Options',
		'href'  => 'http://www.ccsuvt.org/technology/wphelp/front-page-options',
		'meta'  => array(
			'title' => __('Help with Front Page Options'),
			'target' => '_blank',
		),
	));
	$admin_bar->remove_menu( 'wp-logo' );
}


//Archive Blog Thumbnail
add_theme_support('post-thumbnails');


function GrabCustomExternalPageFunc($atts){
	include CCSU_PATH . '/custom/' . $atts['pagename'];
}

add_shortcode( 'GrabCustomExternalPage', 'GrabCustomExternalPageFunc');

add_filter('query_vars', 'parameter_queryvars');

function parameter_queryvars( $qvars )
{
$qvars[] = 'refid';
$qvars[] = 'refuser';
$qvars[] = 'refmode';
$qvars[] = 'refschool';
$qvars[] = 'refcontinue';
$qvars[] = 'reffp1';
$qvars[] = 'reffp2';
$qvars[] = 'reffp3';
$qvars[] = 'reffp4';
return $qvars;
}


//Add styles to the Tiny MCE
add_editor_style('style.css');


//add_image_size('slideshow-full',220,180,true); // (cropped)
add_image_size('slider-home',700,300,true); // (cropped)
add_image_size('slideshow-thumb',220,180,true); // (cropped)
add_image_size('slideshow-tiny',50,50,true); // (cropped)

add_theme_support( 'html5', array( 'search-form' ) );

/*********************************************
***
*** Food Menu Short Code for Nutrition page
***
*********************************************/
function fooddayFunc($atts){
	$thismonth = date("m");
	$a = shortcode_atts( array(
		'month' => $thismonth,
		 ), $atts);
	$database='food';

	$database='food';
	$connectionId=1;
	include CCSU_DBPATH . '/dbIntranet.php'; 
	$connectionId=2;
	include CCSU_DBPATH . '/dbIntranet.php'; 
	$monthId=date('m');
	$dayId=date('d');
	$sql="SELECT monthName,monthDescription,monthImage FROM food.foodMonth where monthId=?";

	$eventDay = date("l");
	$eventMonth = date("M");
	$eventDate = date("j");
	$imgPath=CCSU_STYLE . '/food/';
	
	if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("s",$monthId);
		$stmt->execute();
		mysqli_stmt_bind_result($stmt,$monthName,$monthDescription,$monthImage);
		while (mysqli_stmt_fetch($stmt)) {
			echo "<div class='alignleft call-out'>";
			echo "<img src=" . $imgPath .  $monthImage . ">";
			echo "<h4>" . $eventMonth .  " " . $eventDate . ", " . $eventDay . ":</h4>";
			$sql2="SELECT summary FROM food.foodDay where month=? AND day=?";
			if($stmt2 = $dbi2->prepare($sql2)) {
				$stmt2->bind_param("ss",$monthId,$dayId);
				$stmt2->execute();
				mysqli_stmt_bind_result($stmt2,$summary);
				while (mysqli_stmt_fetch($stmt2)) {
					echo "<em>" .  $summary . "</em>";
				}
			}
		
			echo "<h4>" . strtoupper($monthName) . " is also:</h4>";
			$desc = explode(',', $monthDescription);
			foreach ($desc as $key => $value) {
				echo "<small>" . $value . "</small><br>";
			}
			echo "</div>";
		}
	}
	mysqli_close($dbi1);
	mysqli_close($dbi2);

}

add_shortcode( 'foodday', 'fooddayFunc');

function todaysMenuFUNC($atts){
	$today = date("Y-m-d");
	
	$a = shortcode_atts( array(
		'curDate' => $today,
		 ), $atts);
	$database='food';

	$database='food';
	$connectionId=1;
	include CCSU_DBPATH . '/dbIntranet.php'; 
	$connectionId=2;
	include CCSU_DBPATH . '/dbIntranet.php'; 

	$param=	"{$a['curDate']}";
	$sql = "SELECT mi.summary,mi.description,mi.schoolGroup,MAX(s.schoolId) AS schoolId,COUNT(*) AS count1 FROM food.menuItems mi 
		INNER JOIN food.menu m ON m.menuId=mi.menuId
		INNER JOIN food.menuSchools ms ON ms.menuId=m.menuId
		INNER JOIN food.schools s ON s.schoolId=ms.schoolId
		WHERE mi.menuDate=? AND m.published=1 AND !ISNULL(s.schoolName) 
		GROUP BY mi.summary";

	$feedback = "";
	$menuItems = '';
	$fullmenu = '';
	$options = '';
	if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("s",$param);
		$stmt->execute();
		mysqli_stmt_bind_result($stmt,$summary,$description,$schoolGroup,$schoolId,$count1);

		while (mysqli_stmt_fetch($stmt)) {
			$options .= '<option value="' . ucwords(strtolower($summary)) . '"><span style="text-transform:lowercase;">' . ucwords(strtolower($summary)) . '</span></option>';
			$fullmenu .= '<h4 class="">' . $summary . '</h4>';
			$fullmenu .= '<p style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px;">' . $description;
			$fullmenu .= '<span class="meta">Available at : ';

			$schools='';
			$sql2 = "SELECT s.schoolName,s.schoolId FROM food.menuItems mi 
				INNER JOIN food.menu m ON m.menuId=mi.menuId
				INNER JOIN food.menuSchools ms ON ms.menuId=m.menuId
				INNER JOIN food.schools s ON s.schoolId=ms.schoolId
				WHERE mi.menuDate=? AND m.published=1 AND !ISNULL(s.schoolName)
				AND mi.summary=? GROUP BY  s.schoolName";

				if($stmt2 = $dbi2->prepare($sql2)) {
					$stmt2->bind_param("ss",$param,$summary);
					$stmt2->execute();
					mysqli_stmt_bind_result($stmt2,$schoolName,$schoolId);

					while (mysqli_stmt_fetch($stmt2)) {

						if(!empty($schools)) $schools.=', ';
						$linkURL=CCSU_URL . "/support/food-services/nutritional-menu?refmode=" . $schoolId;					
						$schools.="<a href='". $linkURL . "' style='display:inline;'>". $schoolName . "</a>";
					}
					$fullmenu .= $schools;
				}
		}
	}
	if ($fullmenu<>'') $fullmenu .= "</span></p></div><hr class=\"clear\">";
	if ($fullmenu<>'') {
		echo "<div class=\"cafe-menu\"><h3 class=\"text-center\" style=\"margin-top:0;\">Today&#8217;s Lunch Menu";
		$feedback .= "<div id=\"feedback\">\n";
		$feedback .= "<a class=\"fancybox btn btn-warning small\" href=\"#inlineform\"><i class=\"fa fa-comment-o\"></i> Let Us Know What You Think!</a></div>\n";
		$feedback .= "<!-- hidden inline form -->\n";
		$feedback .= "<div id=\"inlineform\" style=\"display:none;\">\n";
		$feedback .= "<h3>Let us know</h3>\n";
		$feedback .= "<form id=\"contact\" action=\"#\" method=\"post\" name=\"Menu_Rating_\">\n";
		$feedback .= "<div style=\"width:190px;float:left;\"><label for=\"name\">Your Name <small>(optional)</small></label><br>\n";
		$feedback .= "<input id=\"name\" class=\"txt\" type=\"name\" name=\"name\" /></div>\n";
		$feedback .= "<div style=\"width:190px;float:left;\"><label for=\"email\">Your E-mail <small>(optional)</small></label><br>\n<input id=\"email\" class=\"txt\" type=\"email\" name=\"email\" /></div><hr width=\"380\" class=\"clear\"><br>\n";
		$feedback .= "<label for=\"myrating\">My rating<span class=\"required fa fa-asterisk\"></a></label><br><input type=\"number\" data-max=\"5\" data-min=\"1\" name=\"myrating\" id=\"myrating\" class=\"rating\" data-clearable=\" \"/><hr class=\"clear\">";
		$feedback .= "<label for=\"meal\">For<span class=\"required fa fa-asterisk\"></a></label><br>";
		$feedback .= '<div><select id="meal" name="meal">' . $options . '</select></div>';
		$feedback .= "<div class=\"clear\"></div><hr>";
		$feedback .= "<label for=\"msg\">Comment</label><br>\n<textarea id=\"msg\" class=\"txtarea\" name=\"msg\" style=\"width:100%\"></textarea>\n<br>";
		$feedback .= "<label for=\"imhuman\">Are you human?<span class=\"required fa fa-asterisk\"></a></label><br>No <input type=\"radio\" name=\"imhuman\" value=\"yes\" checked /> ";
		$feedback .= "Yes <input type=\"radio\" name=\"imhuman\" value=\"false\" /><br>";
		$feedback .= "<input type=\"hidden\" name=\"subject\" value=\"Today&#8217;s Lunch Menu\" /><br>";
		if(isset($_GET['refmode'])) $school1= $_GET['refmode'];
		else $school1='ccsu';
                
		$feedback .= '<input type="hidden" name="school" value="' . $school1 . '">';
		$feedback .= "<button id=\"sendfeedback\">Send Feedback</button></form></div><!-- eo inlineform -->\n";
	}
	

	echo $feedback;
	echo $menuItems;
	echo $fullmenu;
}

add_shortcode( 'todaysMenu', 'todaysMenuFUNC');


function feedbackFUNC($atts){
	$today = date("Y-m-d");
	$a = shortcode_atts( array(
		'context' => 'General Question',
		'name' => FALSE,
		'email' => FALSE,
		'rating' => FALSE,
		'comment' => FLASE,
		 ), $atts);
	$output = "";
	$output .= "<div id=\"feedback\">\n";
	$output .= "<a class=\"fancybox btn btn-warning small\" href=\"#inlineform\"><i class=\"fa fa-comment-o\"></i> Let Us Know What You Think!</a></div>\n";
	$output .= "<!-- hidden inline form -->\n";
	$output .= "<div id=\"inlineform\" style=\"display:none;\">\n";
	$output .= "<h3>Let us know</h3>\n";
	$output .= "<form id=\"contact\" action=\"#\" method=\"post\" name=\"{$a['context']}\">\n";
	if($a['name']) $output .= "<label for=\"name\">Your Name <small>(optional)</small></label><br>\n";
	if($a['name']) $output .= "<input id=\"name\" class=\"txt\" type=\"name\" name=\"name\" /><br>\n";
	if($a['email']) $output .= "<label for=\"email\">Your E-mail <small>(optional)</small></label><br>\n<input id=\"email\" class=\"txt\" type=\"email\" name=\"email\" /><br>\n";
	if($a['rating']) $output .= "<label for=\"myrating\">My rating</label><br><input type=\"number\" data-max=\"5\" data-min=\"1\" name=\"your_awesome_parameter\" id=\"myrating\" class=\"rating\" data-clearable=\"clear\"/>";
	if($a['rating']) $output .= "<label for=\"msg\">Comment</label><br>\n<textarea id=\"msg\" class=\"txtarea\" name=\"msg\"></textarea>\n<br>";
	$output .= "<button id=\"send\">Send Feedback</button></form></div><!-- eo inlineform -->\n";
	return $output;
	
}

add_shortcode( 'feedback', 'feedbackFUNC');

/*********************************************
***
*** Add custom CTA styles to TinyMCE editor
***
*********************************************/
// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_3( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_3', 'my_mce_buttons_3');
// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Button',
			'selector' => 'a',
			'classes' => 'btn btn-info'
		),  
		array(  
			'title' => 'clearfix',  
			'selector' => 'h4',
			'classes' => 'clearfix',
			'wrapper' => true,
		),
		array(  
			'title' => 'Bulleted List',  
			'selector' => 'ul',  
			'classes' => 'bullets',
			'wrapper' => true,
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 

function FAQ_func( $atts, $content= '' ) {
	$a = shortcode_atts(
		array(
			'q' => 'Question',
		), $atts, 'FAQ' );

	$return = '<ul class="faq"><li><a href="#" class="question">';
	$return .=  "{$atts['q']}";
	$return .= '</a><div style="margin-left: 2em;">';
	$return .= '<p>' . $content . '</p>';
	$return .= '</div></li></ul>';

	return $return;
}
add_shortcode( 'FAQ', 'FAQ_func' );


// MZ edit 03/09/2015 - Do we need this?
function getUserType($login){

	$database='district';
	$connectionId=1;
	include CCSU_DBPATH . '/dbWeb.php'; 
	$userType='';
	$query="SELECT username from district.teacher_info where username=?";
	if($stmt = $dbw1->prepare($query)) {
		$stmt->bind_param("s",$login);
		$stmt->execute();
		mysqli_stmt_bind_result($stmt,$username);
		while (mysqli_stmt_fetch($stmt)) {
			$userType='Teacher';
		}
	}

	if(empty($userType)){
		$query="SELECT userName from district.student_info where userName=?";
		if($stmt = $dbw1->prepare($query)) {
			$stmt->bind_param("s",$login);
			$stmt->execute();
			mysqli_stmt_bind_result($stmt,$userName);
			while (mysqli_stmt_fetch($stmt)) {
				$userType='Student';
			}
		}
	}

	if(empty($userType)){
		$query="SELECT userLogin from district.parent_info where userLogin=?";
		if($stmt = $dbw1->prepare($query)) {
			$stmt->bind_param("s",$login);
			$stmt->execute();
			mysqli_stmt_bind_result($stmt,$userLogin);
			while (mysqli_stmt_fetch($stmt)) {
				$userType='Parent';
			}
		}
	}
	
	return $userType;
}
function GrabLinksPageFunc($atts){
	if(isset($atts['type'])) $type=$atts['type'];
	if(isset($atts['ownerid'])) $ownerId=$atts['ownerid'];
	if(isset($atts['subcategory'])) $subCategory=$atts['subcategory'];
	include_once(CCSU_PATH . '/custom/' . $atts['pagename']);
}

add_shortcode( 'GrabLinksPage', 'GrabLinksPageFunc');

function contentTableFunc ($atts,$content=NULL) { // this is really just used for the ccsu weekly
	$removeStrings = array('<h2>','<h3>');
	$replaceStrings = array('<h2 class="content-h2">','<h3 class="content-h3">');
	$contentFixed = str_replace($removeStrings, $replaceStrings, $content);
	$output = "<table id=\"contentTable\" width=\"250px\" cellspacing=\"12\" cellpadding=\"8\" align=\"right\">";
	$output .= "<tbody><tr><td style=\"font-size: 11px; font-family: Arial, Helvetica, sans-serif;padding: 10px; color: #ffffff; background: #444;text-align:left; border-left:12px white solid\">";
	$output .= $contentFixed;
	$output .= "</td></tr></tbody></table>";
	return $output;
}
add_shortcode('contentTable','contentTableFunc');

function get_cat_slug($cat_id) { // used to get the cat Slug for Category Pages
	$cat_id = (int) $cat_id;
	$category = get_category($cat_id);
	return $category->slug;
}

/****************************************************
	copied from :
	shows posts from given Tag Group
****************************************************/

function pti_post_tag_images_shortcode( $atts ) {
// if ( is_tag() ) {
// 	$term_id = get_query_var('tag_id');
// 	$taxonomy = 'post_tag';
// 	$args ='include=' . $term_id;
// 	$terms = get_terms( $taxonomy, $args );
// }
// WP_Query arguments
$args = new WP_Query(array( // this seems SLOW
	'post_type' 		=> 'attachment',
	'pagination'		=> false,
	'posts_per_page'	=> '6',
	'post_status' 		=> 'inherit',
	'tax_query' 		=> array(
					array(
						'taxonomy' => 'homepagetag',
						'field' => 'slug',
						'terms' => 'homepage'
					)
				)
));

$output = '<ul class="gallery-grid">';
while ( $args->have_posts() ) : $args->the_post(); 
	global $post;
	//$size = 'slideshow-thumb';
	$caption = '';
	$full = '';
	$attachments = get_posts( array('p' => $post->ID, 'post_type' => 'attachment') );
	foreach ($attachments as $attachment) { // this gets the meta
		$caption .= $attachment->post_excerpt;
		//$full .= wp_get_attachment_link( $attachment->ID , 'large', false );
 	}
	//$image_output = wp_get_attachment_link( $post->ID, $size, false, false );
	$thumb = wp_get_attachment_image_src($post->ID,'slideshow-thumb');
	$full = wp_get_attachment_image_src($post->ID,'large');
	//$image_output = str_replace('<a','<a class="fancybox" rel="image-gallery" data-fancybox-title="' . $caption . '"',$image_output);
	$image_output = "<a href=\"" . $full[0] ."\" class=\"fancybox\" rel=\"image-gallery\" data-fancybox-title=\"" . $caption . "\"><img src=\"" . $thumb[0] . "\"></a>";
	$image_output = str_replace('http://','//',$image_output);
	$output .= '<li class="gallery-item">' . $image_output . '</li>';
endwhile;
$output .= '</ul>';
return $output;
// Reset Post Data
wp_reset_postdata();
}
add_shortcode( 'post_tag_images', 'pti_post_tag_images_shortcode' );

/**********************************************************
Calendar for homepage
**********************************************************/
if (!function_exists('upcoming_events_fnc')) { // Check if function is in child theme so the child theme function can override!!!
	function upcoming_events_fnc () {
		//$locations = implode("','", $location);
		$locations = "'ccsu','board','ccsuboard','wfdboard','u46board','prudboard'";
		$database='calendar';
		$connectionId=1;
		include CCSU_DBPATH . '/dbIntranet.php'; 
		$nearsql = "SELECT e.id,e.date,e.starttime,e.endtime,e.name,e.description 
		FROM calendar.events e 
		WHERE e.location IN ($locations) AND e.date >= CURDATE() 
		AND e.name <> 'A' AND e.name <> 'B' 
		UNION 
		(SELECT dc.dayId as id,dc.date,'' AS starttime,'' AS endtime,IF(ISNULL(dc.desc),'No School',dc.desc) AS NAME,'' AS description 
		FROM calendar.districtCalendar dc 
		WHERE dc.date>=CURDATE() AND dc.noschoolday=1 AND dc.weekend=0 AND (dc.schools='All' OR INSTR(dc.schools,'ccsu')>0))
		ORDER BY DATE";

		if($stmt = $dbi1->prepare($nearsql)) {
			$stmt->execute();
			$stmt->store_result();
					
			$nearnumrows=$stmt->num_rows;

			if($nearnumrows == 0) {
				echo "<a href=\"".get_option('siteurl')."/cal.php\" title=\"No upcoming Events\">No upcoming events</a>";
			} else {

				$stmt->execute();

				mysqli_stmt_bind_result($stmt, $id,$date,$starttime,$endtime,$name,$description);
				$i=0;	
				while (mysqli_stmt_fetch($stmt)) {
					$nameFixed = htmlspecialchars($name) ;
					$eventTime = $starttime != '' ? '<span class="event-start-time">@ '.str_replace('-','',$starttime).'</span>' : '';
					$eventDay = date("D", strtotime($date));
					$eventMonth = date("M", strtotime($date));
					$eventDate = date("j", strtotime($date));
					?>
					<div class="event-item">
					<div class="event-cal" align="center">
					<span class="event-month"></span>
					<small ><?php echo $eventMonth; ?></small>
					<span class="event-date"><?php echo $eventDate; ?></span>
					<span class="event-day"><?php echo $eventDay; ?></span>
					</div><!--eo event-cal -->
					<div class="event-content">
					<p>
					<?php 
					$eventURL= CCSU_URL . "events-calendar/?reffp1=" . date("m", strtotime($date)) . "&reffp2=" . date("Y", strtotime($date)); 
					echo "<a href='" . $eventURL . "'>".$nameFixed . " " .$eventTime . "</a>"; ?>
					</p>
					</div><!--eo .event-content -->
					</div><!-- eo .event-item -->
					<?php
					$i++;
					if($i>=3) break;
				}
			}
		}
	mysqli_close($dbi1);
	}
} // eo function exists check

add_shortcode( 'upcoming_events', 'upcoming_events_fnc',3 );

/*********************************************
/ Bread Crumbs
*********************************************/

if (!function_exists('the_breadcrumb')) { // Check if function is in child theme so the child theme function can override!!!
	function the_breadcrumb() {

		$database='wp_' . strtolower(CCSU_SCHOOL); // needs to be updated to this sites DB
		$connectionId=1;
		include CCSU_DBPATH . '/dbWeb.php'; 

		$database='website';
		$connectionId=1;
		include CCSU_DBPATH . '/dbIntranet.php'; 
		$connectionId=2;
		include CCSU_DBPATH . '/dbIntranet.php'; 
		$connectionId=3;
		include CCSU_DBPATH . '/dbIntranet.php'; 
	        $prefix=$database . "." . $database;

		echo '<ul id="breadcrumbs">';
		if (!is_home()) {
			echo '<li><a href="';
			echo get_option('home');
			echo '">';
			echo 'Home';
			echo "</a></li>";

			if (is_category() || is_single()) {
				if (is_single()) {
				    $postId=get_the_ID();
				    $sql="SELECT t.term_id,t.name FROM " . $prefix . "_term_relationships tr 
					INNER JOIN " .  $prefix . "_term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id
					INNER JOIN " . $prefix . "_terms t ON t.term_id=tt.term_id
					WHERE tr.object_id=? AND tt.taxonomy='category' LIMIT 1";

					if($stmt = $dbw1->prepare($sql)) {
						$stmt->bind_param("s",$postId);
						$stmt->execute();

						mysqli_stmt_bind_result($stmt, $term_id,$name);

						while (mysqli_stmt_fetch($stmt)) {
	                        			$category_id=$term_id;
							echo "<li><a href='" . get_category_link( $category_id ) . "'>"  . $name . "</a></li>";
						}
					}	

					echo "<li><a href=''>Post</a></li>";
				} else {
					$linkURL=CCSU_URL . $_SERVER["REQUEST_URI"];
					$sql="SELECT webGroup,category,linkTitle FROM website.webItems where linkURL=? limit 1";

					if($stmt = $dbi1->prepare($sql)) {
						$stmt->bind_param("s",$linkURL);
						$stmt->execute();

						mysqli_stmt_bind_result($stmt, $webGroup,$category,$linkTitle);

						while (mysqli_stmt_fetch($stmt)) {
							echo "<li><a href=''>" . $webGroup . "</a></li>";
						        echo "<li><a href=''>" . $category . "</a></li>";
						        echo "<li><a href=''>" . $linkTitle . "</a></li>";
						}
					}
				}
			
			} elseif (is_page()) {
					$linkURL=get_permalink();
					$linkURL=str_replace('https://','//',$linkURL);
					$sql="SELECT wg.webGroup,wc.category FROM website.webItems wi
					INNER JOIN website.webCategories wc ON wc.categoryId=wi.categoryId
					INNER JOIN website.webGroups wg ON wg.webGroupId=wc.`webGroupId`
					where wi.linkURL=? limit 1";
						
					if($stmt = $dbi1->prepare($sql)) {
						$stmt->bind_param("s",$linkURL);
						$stmt->execute();

						mysqli_stmt_bind_result($stmt, $webGroup,$category);

						while (mysqli_stmt_fetch($stmt)) {
							echo "<li><a href=''>" . $webGroup . "</a></li>";
							echo "<li><a href=''>" . $category . "</a></li>";
						}
					}
			}
		}
		echo '</ul>';
	}
} // eo function exists check

/**
 * Overrides the core Gallery feature to make it bootstrapped!
 *
 * @since v1.0
 */


function slide_gallery_shortcode($foo, $attr) {
	global $post;

	static $instance = 0;
	$instance++;

	extract(shortcode_atts(array(
		'order'		=> 'DESC',
		'orderby'	=> 'rand',
		'id'		=> $post->ID,
		'itemtag'	=> 'div',
		'icontag'	=> 'div',
		'captiontag'	=> 'div',
		'columns'	=> 1,
		'size'		=> 'full',
		'include'	=> '',
		'exclude'	=> ''
	), $attr));

	$columns = 1;
	$size    = 'full';

	$id = intval($id);
	$orderby = "rand";

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
      	$size_class = sanitize_html_class( $size );

	$gallery_div = "";
	//$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
	$output = "<br><div id=\"mySlideshow\" class=\"carousel slide\" data-ride=\"carousel\">\n\t";
	$output .= "<div class=\"carousel-inner\">\n\t\t";

	$i = 0;
	$c = count($attachments);
	$output .= "<ol class=\"carousel-indicators\">";
	while ($i < $c) {
		if($i=='0') $active = "active";
		$output .= "<li data-target=\"#mySlideshow\" data-slide-to=\"{$i}\" class=\"{$active}\"></li>";
		$i++;
	}
	$output .= "</ol>";

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_image($id, $size, false, false) : wp_get_attachment_image($id, $size, true, false);
		
		if($i=='0') $active = " active";

		$output .= "<{$itemtag} class=\"item{$active}\">\n\t\t\t";
		$output .= "$link\n\t\t\t";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "<{$captiontag} class='carousel-caption gallery-slideshow'>";
			$output .= wptexturize($attachment->post_excerpt);
			$output .= "</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		$i++;
		$active = "";
	}

	$output .= "\n\t";
	$output .= "</div><!-- eo carousel-inner -->\n";
	$output .= "</div><!-- eo carousel -->\n";
	
	return $output;
}

add_filter('post_gallery', 'slide_gallery_shortcode', 4, 2);

function wpb_latest_sticky() { 

	/* Get all sticky posts */
	$sticky = get_option( 'sticky_posts' );

	/* Sort the stickies with the newest ones at the top */
	//rsort( $sticky );

	/* Get the 1 stickie. Defaults to 10 */
	//$sticky = array_slice( $sticky, 0, 1 );
	
	$cat = get_query_var('cat');
	$return = '';
	$args = array(
		'post_type' => 'post',
		'ignore_sticky_posts' => 'false',
		'post__in' => get_option('sticky_posts'),
		'cat' => $cat,
		'posts_per_page'      => 1,
	);

	/* Query sticky posts */
	$the_query = new WP_Query( $args );
	// The Loop
	if ( $the_query->have_posts() ) {
		if (isset($sticky[0])) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$return .= get_the_content();
				$return .= edit_post_link('edit header', '<small>', '</small>');
			}
		}
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	return $return; 

} 
add_shortcode('latest_stickies', 'wpb_latest_sticky');

/**
 * Customizer additions.
 *
 * @since v1.0
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Import Short code for Menu on the homepages
 *
 * @since v1.0
 */
require get_template_directory() . '/inc/showfood.php';

?>