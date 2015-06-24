<?php
/*
Template Name: Home
*/
?><?php get_header(); ?>
	<?php
	// the Banner Roll
	$display_slider = of_get_option('display_slider');
	if(isset($display_slider) && $display_slider==true) {
		get_template_part( 'options-slides', 'index' );
	}
?>
<?php
	// the announcement Banner
	$display_announ = of_get_option('display_announ');
	if(isset($display_announ) && $display_announ==true) { ?>
		<div class="col-sm-12">
		<?php
			get_template_part( 'options-announ', 'index' );
		?>
		</div>
	<?php
	}
?>
	<div class="col-sm-6 col-md-5">
	<ul class="gallery-grid">
	<h2 class="titlebreak yellow"><span>Image Gallery</span></h2>
	<?php echo do_shortcode( '[post_tag_images]' ); 
?>
	<div class="clearfix"></div>
	<a href="/tag/homepage" class="btn btn-primary btn-block btn-sm btn-custom"><span class="glyphicon glyphicon-camera"></span> View more images</a>
	</ul><!--eo gallery-grid -->
	
	<div class="clearfix"></div>
	</div><!-- eo .col-md-5 -->
	 <div class="col-sm-6 col-md-4">
<?php
	$news_items = 7;
	// the Menu
	$display_menu = of_get_option('display_menu');
	if(isset($display_menu) && $display_menu==true) {
		$news_items = 5;
		get_template_part( 'options-menu', 'index' );
	}
?>
	<div class="clearfix"></div>
	 <div class="news-feed">
	 <h2 class="titlebreak two"><span>News Feed</span></h2>

<ul>
<?php
$args = array(
	'category_name' => 'main',
	'posts_per_page' => $news_items,
	);
query_posts( $args );
while ( have_posts() ) : the_post(); ?>
	<li class="news-item">
		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
		<?php if ( has_post_thumbnail() ) {
				$post_id=get_the_ID();
				//the_post_thumbnail( 'slideshow-thumb', array( 'class' => 'alignleft post-item-thumb' ) );
				$thumb_url = get_the_post_thumbnail( $post_id, 'slideshow-thumb', array( 'class' => 'alignleft post-item-thumb' ) );
				$thumb_url = str_replace('http://', '//', $thumb_url);
				echo $thumb_url;
			} else {
				?>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/default_post_image.png" alt="<?php the_title(); ?>" class="alignleft post-item-thumb">
				<?php
			}
			?>
			<div class="news-content">
			<h3><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a><?php //the_date('F d, Y', '<span class="meta">', '</span>'); ?></h3>
			<p>
			<?php 
				$excerpt = get_the_excerpt();
				//$excerpt = substr($excerpt,0,80);
				echo $excerpt;
			?>
			</p>
			</div>
			<div class="clearfix"></div>
	</li>
<?php endwhile;
	
	// Reset Query	
	wp_reset_query();

?>
<li class="pull-right"><a href="<?php echo get_bloginfo('url'); ?>/category/main/" class="btn btn-primary small btn-custom">More News <i class="fa fa-angle-right"></i></a></li>
</ul>
	<div class="clearfix"></div>
	</div><!--eo .news-feed -->
	</div><!-- eo .col-md-4 -->

 <div class="clearfix visible-sm-block"></div>
	<div class="col-sm-6 col-md-3">
	<div class="events">
	<h2 class="titlebreak amber"><span>Upcoming Events</span></h2>
<?php do_shortcode('[upcoming_events]'); ?>

<div class="pull-right"><a href="<?php echo get_bloginfo('url'); ?>/events-calendar/" class="btn btn-primary small btn-custom">More Events <i class="fa fa-angle-right"></i></a></div>
<br><br>
	</div><!--eo events -->
	</div><!-- eo .col-md-3 -->
<?php
	// the Ad Banner
	$display_ad = of_get_option('display_ad');
	if(isset($display_ad) && $display_ad==true) {
		get_template_part( 'options-ad', 'index' );
	}
?>
<?php get_footer(); ?>