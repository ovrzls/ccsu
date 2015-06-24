<?php get_header(); ?>
<div id="content" class="col-md-8 col-md-offset-1 col-sm-9">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<!-- Load the Template content-page -->
	<?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<br>
</div><!-- eo content -->
<div class="col-sm-3">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>