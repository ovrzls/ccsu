<?php
/*
Template Name: Supervisors only
*/
get_header(); ?>
<?php 
global $current_user;
$curUser=$current_user->user_login; 
$supervisor=0;
$database='hr';
	
$connectionId=1;
include CCSU_DBPATH . '/dbIntranet.php'; 
				
$query="SELECT userName FROM hr.approvers WHERE userName=?";
if($stmt = $dbi1->prepare($query)) {
	$stmt->bind_param("s",$curUser);
	$stmt->execute();
	mysqli_stmt_bind_result($stmt, $userName);
	while (mysqli_stmt_fetch($stmt)) {
		$supervisor=1;
	}
}	
mysqli_close($dbi1);
if( current_user_can('super') ) 	$supervisor=1;

if($supervisor>0) { ?>
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
<br>
	<p>Last updated: <?php the_modified_date('M j'); ?> at <?php the_modified_date('g:i a'); ?>
	<?php edit_post_link('(Edit Page)', '&nbsp;', ''); ?></p>
</div><!-- eo content -->
<div class="col-md-3">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
<?php
}else {
	$link = get_option('siteurl') . "/login/?refcontinue=" . curPageURL();     
	echo "<meta http-equiv=\"Refresh\" content=\"0;url=$link\">";
}



function curPageURL() {
 $pageURL = 'http://';
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>