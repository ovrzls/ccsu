<?php get_header(); ?>
<div id="content" class="col-md-9 col-sm-offset-1">
<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'CCSU' ), get_search_query() ); ?></h1>
			</header><!-- .page-header -->

				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						//get_template_part( 'content', get_post_format() );
				?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h4 class="entry-title"><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h4>
	</header>
	<div class="entry-content">
		<?php
			if (has_post_thumbnail()) the_post_thumbnail('thumbnail',array( 'class' => 'alignleft' ));
			//else echo '<img src="' . get_bloginfo('stylesheet_directory') . '/images/default_post_image.png" class="alignleft post-item-thumb" alt="CCSU">';
		?>
		<?php the_excerpt(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'CCSU' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'CCSU' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
<div class="clear">&nbsp;</div>
<hr>
				<?php
					endwhile;
					// Previous/next post navigation.
					//twentyfourteen_paging_nav();

				else :
					// If no content, include the "No posts found" template.
?>
<section id="primary" class="site-content">
		<div id="content" role="main">

<h1>Page Not Found</h1>
<h3>The page you are trying to access cannot be found.</h3>
<div class="row">
				
			<div class="col-md-offset-8 col-md-4">
				<p>Perhaps searching can help.</p>
				<?php get_search_form(); ?>
			</div>
		</div><!-- eo row -->
		<div class="row">
			<div class="col-md-6">
				<div class="col-header">
				<h3>Popular Posts</h3>
				</div>
<?php
	$posts = get_posts('orderby=rand&numberposts=5');
	foreach($posts as $post) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><br/>
 <?php } ?>

			</div>
			<div class="col-md-6">
				<div class="col-header">
				<h3>Recent Posts</h3>
				</div>
				<?php wp_get_archives( array( 'type' => 'postbypost', 'limit' => 10, 'format' => 'custom', 'before' => '', 'after' => '<br />' ) ); ?>
			</div>
		</div><!-- eo row -->
	</section>
<?php
				endif;
			?>

		</div><!-- #content -->
	</section><!-- #primary -->
</div><!-- eo content -->


<?php get_footer(); ?>