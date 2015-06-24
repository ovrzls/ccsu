<?php get_header(); ?>
<div id="content" class="col-md-10 col-md-offset-1">
 <?php
 //if ( is_tag() ) {
	$term_id = get_query_var('tag_id');
	//$term_tax = get_query_var('taxonomy');
	$terms = get_term_by('id', $term_id, 'post_tag');
	/*
	print_r($term_id);
	$terms = get_terms( $taxonomy, $args );
	$taxonomy = 'post_tag';*/
//}
?>
<h1><?php echo $terms->name; ?> Gallery</h1>
<?php
// WP_Query arguments
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$wp_query = new WP_Query(array(
	'pagination'		=> true,
	'post_status' 		=> 'any',
	'post_parent' 		=> null,
	'posts_per_page'	=> '20',
	/*'tag_id'			=> $term_id,*/
	'tax_query' 		=> array(
					array(
						'taxonomy' => 'homepagetag',
						'field' => 'slug',
						'terms' => $terms->slug
					)
				),
	'paged'			=> $paged, //not sure why this is not working
)); ?>
<ul class="gallery-grid wide-grid">
<?php
while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
<?php
	$size = 'slideshow-thumb';
	$attachments = get_post( $post->ID );
	$image_output = wp_get_attachment_link( null, $size, false, false );
	$image_output = str_replace('<a','<a class="fancybox" rel="image-gallery" data-fancybox-title="' . wptexturize($attachments->post_excerpt) .'"',$image_output);
	$image_output = str_replace('http://','//',$image_output);
	echo '<li class="gallery-item">'. $image_output .'</span></li>';
?>	
<?php endwhile; ?>
</ul>
<div class="clear">&nbsp;</div>
<div class="col-xsm-6"><?php previous_posts_link(); ?></div><div class="col-xsm-6 text-right"><?php next_posts_link(); ?></div>
</div><!-- eo #content -->
<?php get_footer(); ?>