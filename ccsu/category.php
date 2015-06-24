<?php get_header(); ?>
<div id="content" class="col-md-8 col-md-offset-1">
	<section id="primary" class="site-content">
		<div id="content" role="main">
		<?php if ( have_posts() ) : ?>
			<header class="category-header">
				<h1 class="category-title"><span><?php printf( single_cat_title( '', false )  ); ?></span></h1>
			<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="category-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header>
			<?php echo do_shortcode('[latest_stickies]'); ?>
		<!-- .category-header -->
		<dl class="post-list">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
			if(!is_sticky()) {
			?>
			<dd class="post-item">
				<?php
				echo '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( $post->post_title ) . '">';
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'slideshow-thumb', array( 'class' => 'alignleft post-item-thumb' ) );
				} else {
					?>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/default_post_image.png" class="alignleft post-item-thumb" alt="CCSU">
					<?php
				}
				//echo get_the_post_thumbnail($post_id,'slideshow-thumb');
				echo '</a>'; ?>
				<h3><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a><?php the_date('F d, Y', '<span class="meta">', '</span>'); ?></h3>

				<p>
				<?php //the_excerpt();
				echo(get_the_excerpt());
				?>
				</p>
				<div class="clearfix"></div>
			</dd>
			<?php
			} // eo if is not sticky
			endwhile;
			//openstrap_content_nav( 'nav-below' );
			?>
		</dl><!--eo post-list -->
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
<div class="nav-previous alignleft"><?php next_posts_link( '<i class="fa fa-arrow-left"></i> Older posts' ); ?></div>
<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts <i class="fa fa-arrow-right"></i>' ); ?></div>
		</div><!-- #content -->
	</section><!-- #primary -->
</div><!-- eo #content -->
<div class="col-md-3">
<?php get_sidebar('category'); ?>
</div>


<?php get_footer(); ?>