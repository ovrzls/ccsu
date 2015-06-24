<?php
/*
Template Name: Full Page
*/
get_header(); ?>
<div id="content" class="col-md-12">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<br>
</div><!-- eo content -->
<?php get_footer(); ?>