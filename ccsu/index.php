<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Openstrap
 * @subpackage Openstrap
 * @since Openstrap 0.1
 */

get_header(); ?>

<?php
$layout = of_get_option('page_layouts');

if(isset($layout)) {
	//load template as per settings
	switch($layout) {
		case "full-width":
			get_template_part( 'layouts/full', 'width' ); 
			break;
		case "sidebar-content":
			get_template_part( 'layouts/sidebar', 'content' ); 
			break;
		case "content-sidebar":
			get_template_part( 'layouts/content', 'sidebar' );
			break;
		case "content-sidebar-sidebar":			
			get_template_part( 'layouts/content', 'sidebar-sidebar' ); 			
			break;	
		case "sidebar-sidebar-content":			
			get_template_part( 'layouts/sidebar', 'sidebar-content' ); 			
			break;		
		case "sidebar-content-sidebar":			
			get_template_part( 'layouts/sidebar', 'content-sidebar' ); 			
			break;				
		default:
			get_template_part( 'layouts/content', 'sidebar' );			
	}	
} else {

if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="contentTitle">
	<h1><?php the_title(); ?></h1>
	</div>
	<?php the_content(__('Read more'));?>
<?php endwhile; else: ?>
	<?php _e('<p>Sorry, no posts matched your criteria.</p>'); ?><?php endif; ?>
	<br />
	<p>Last updated: <?php the_modified_date('M j'); ?> at <?php the_modified_date('g:i a'); ?>
	<?php edit_post_link('(Edit Page)', '&nbsp;', ''); ?></p>
	<?php comments_template(); // Get wp-comments.php template 
	//load default template content/sidebar
	get_template_part( 'layouts/content', 'sidebar' );
}
?>
<?php get_footer(); ?>
