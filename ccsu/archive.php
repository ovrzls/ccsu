<?php get_header(); ?>
<div id="content" class="col-md-9 col-md-push-3">
<?php 
echo category_description();
if (have_posts()) : while (have_posts()) : the_post(); 

if( is_sticky( get_the_ID() ) ) { ?>
	<?php the_content(__('Read more'));?>
<?php } else { ?>
<div class="entry e<?php if($i == 0){$i++;}elseif($i == 1){$i--;}echo $i;?>">
<div class="podcastTitle">
<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><br /><span class="byline">posted on <?php the_time('F jS, Y'); 
echo"<br />";
?>
</span></h3>
</div>
<?php

	echo "<div class=\"postThumb\">";
			if (has_post_thumbnail()) the_post_thumbnail('thumbnail',array( 'class' => 'alignleft' ));
			else echo '<img src="' . bloginfo("stylesheet_directory") . '/images/default_post_image.png" width="150" class="alignleft post-item-thumb" alt="CCSU">';
	echo "</div>";
	echo "<div class=\"postContentPic\">";
	$excerpt = get_the_excerpt();
	echo "<p>" . $excerpt;
	echo "&nbsp;&nbsp;";
	if (strlen($excerpt) >= 200){
?>
   <a href="<?php the_permalink() ?>">Read More</a></p>
   <?php } ?>
   </div>
   <br class="clear" />
   <?php global $user_level; if($user_level == 10){edit_post_link('Edit', '<p>', '</p>');}; ?>

</div>
<?php } endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?>
</p>
<?php endif;?>
<p><?php posts_nav_link(' &#8212; ', __('&larr; Previous Page'), __('Next Page &rarr;')); ?></p>
</div><!-- eo #content -->
<div class="col-md-3 col-md-pull-9">
<?php get_sidebar(); ?>
</div>


<?php get_footer(); ?>