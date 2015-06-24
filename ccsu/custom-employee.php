<?php
/*
Template Name: Employees only
*/
get_header(); ?>
<?php 
//if( current_user_can('read') ) {
if (is_user_logged_in() ){ ?>
<?php $leftCol = 1; ?>
<div id="content" class="col-md-<?php echo 9 - $leftCol; ?> col-sm-offset-1">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="contentTitle">
	<h2><?php the_title(); ?></h2>
	</div>
<?php the_content(__('Read more'));?>
<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<br>	<?php if($name = get_post_meta($post->ID,'Posted By',true)) echo "<span class=\"meta\">Posted By: " . $name . "</span>  "; ?>
	<?php if($date = get_post_meta($post->ID,'Updated',true)) echo "<span class=\"meta\">Updated: " . $date . "</span> "; ?>
	<p><?php edit_post_link('(Edit Page)', '&nbsp;', ''); ?></p>
</div><!-- eo content -->
<div class="col-md-3">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
<?php
}else {
	$link = "/login/?refcontinue=" . curPageURL();     
	echo "<meta http-equiv=\"Refresh\" content=\"0;url=$link\">";
}



function curPageURL() {
 $pageURL = 'https://';
 if ($_SERVER["SERVER_PORT"] != "80") {
  //$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>