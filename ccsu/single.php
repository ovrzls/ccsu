<?php
/**
 * The Template for displaying all single posts.
 */
get_header(); ?>
<div class="col-md-8 col-md-offset-1 <?php
$catid = get_the_category($post->ID);
if(isset($catid[0]))
	echo get_cat_slug($catid[0]->term_id); ?>" role="content">
	<div id="primary" class="site-content">
		<div id="content" role="main">
		<header class="entry-header">
			<h1 class="entry-title"><?php wp_title(''); ?></h1>
			<div class="fb-share-button" data-href="<?php the_permalink() ?>" data-layout="icon_link"></div>
		</header>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
				<footer>
				<?php edit_post_link( __( 'Edit', 'CCSU' ), '<span class="edit-link">', '</span>' ); ?>
				</footer>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div> <!-- .col-md- .content -->	
<div class="col-md-3">
<?php get_sidebar('category'); ?>
</div>

<?php get_footer(); ?>