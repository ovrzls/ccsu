<?php get_header(); ?>
<div id="content" class="col-md-8 col-md-push-2">
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
</div>


<?php get_footer(); ?>