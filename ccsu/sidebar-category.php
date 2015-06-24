<aside>
<nav>
<ul class="right-nav right-sub-nav">
<?php
$cats = get_the_category();
if( isset($cats[0]) ) : 
	$cat = $cats[0]->term_id; ?>
	<h4>Other Posts Labeled: <?php echo $cats[0]->name; ?></h4>
<?php else: ?>
	<h4>Recent Posts</h4>
<?php  endif; ?>
<?php
$args = array( 'numberposts' => '8', 'cat' => $cat, 'post__not_in' => get_option( 'sticky_posts' ) );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
		if ( $recent['post_title'] != '' ) {
			$title = $recent['post_title'];
		} else {
			$date = $recent['post_date'];
			$title = "Posted: " . date('M, d Y', strtotime($date));
		}
		echo "<li><a href=\"" . get_permalink($recent['ID']) . "\">" .   $title ."</a> </li> ";
	}
?>
</ul>
</nav>
</aside>