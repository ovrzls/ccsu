<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html lang="en-US">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo(get_bloginfo('title')); ?></title>
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Transistional Styles from Old version -->
<link rel="stylesheet" type="text/css" href="<?php echo(get_bloginfo('template_directory')); ?>/css/custom.css">
<!-- for google translate -->
<meta name="google-translate-customization" content="97aba8bc5b2dc9fb-6199ab180942bf4c-gf4441d90d02da6c6-17"></meta>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<?php 
ini_set('display_errors',0);
ini_set('display_startup_errors',0);
error_reporting(0);
wp_head(); ?>
 
<!-- if page is content page -->
<?php if (is_single()) { ?>
<meta property="og:url" content="<?php the_permalink() ?>"/>
<meta property="og:title" content="<?php htmlspecialchars(single_post_title('')); ?>" />
<meta property="og:description" content="<?php echo htmlspecialchars(strip_tags(get_the_excerpt($post->ID))); ?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php if (function_exists('wp_get_attachment_thumb_url')) {echo wp_get_attachment_thumb_url(get_post_thumbnail_id($post->ID)); }?>" />
 
<!-- if page is others -->
<?php } else { ?>
<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<meta property="og:description" content="<?php bloginfo('description'); ?>" />
<meta property="og:type" content="website" />
<meta property="og:image" content="<?php echo get_stylesheet_directory_uri(); ?>/images/icon.jpg" /> <?php } ?>
</head>

<body class="<?php echo CCSU_SCHOOL; ?>">
<?php if (is_single() || is_page_template('sum-it-up-newsletter.php')) { ?>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<?php } ?>
<div class="container">
	<div class="row" id="header">
<?php
$announceFile=CCSU_PATH . '/custom/headerAnnouncement.php';
include_once($announceFile); 
?>
		<div id="super-header" class="hidden-xs hidden-sm ">
			<div class="col-sm-4 pull-left">
				<a href="<?php echo get_bloginfo('url'); ?>" class="district-mark"><h1><?php echo get_bloginfo ( 'name' );  ?><br><?php echo get_bloginfo ( 'description' );  ?></h1></a>
			</div>
			<div class="col-sm-8 pull-right hidden-xs text-right">
				<div id="header-search">
				<?php get_search_form(); ?>
				</div>
				<span class="login-notify">
					<?php
					global $current_user;
					$current_user = wp_get_current_user();
					$adminurl = admin_url();
					$logoutURL=get_permalink();
					if (is_user_logged_in()) {
						echo 'Welcome ' . $current_user->display_name . '. <a href="' . wp_logout_url($logoutURL) . '"  title="Logout">Log out?</a>';
						if (current_user_can( 'edit_posts' )) echo ' | <a href="' . $adminurl . '"  title="Admin Panel">Site Admin</a>';
					} else {
						echo 'Not Logged in. <a href="' . str_replace('http://','//',get_option('siteurl')) . '/login" class="login">Log in?</a>';
					}
					?>
				</span>
				<?php wp_nav_menu( array( 'menu_class' => 'quick-nav-list text-right', 'theme_location' => 'quicknav', 'depth' => '-1' ) ); ?>
			</div><!-- eo super-links -->
		</div><!-- eo #super-header -->
	<div class="navbar navbar-ccsu" role="navigation">
		<div class="navbar-header visible-xs visible-sm">
			<a class="navbar-brand visible-xs visible-sm" href="<?php echo str_replace('http://','//',get_option('siteurl')); ?>"><?php echo get_bloginfo ( 'name' );  ?></a>
			<div class="align-right">
				<a href="<?php str_replace('http://','//',get_option('siteurl')); ?>/dashboard" class="dashboard-ico btn btn-info visible-xs"><i class="fa fa-tasks"></i> Dashboard</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="btn btn-info fa fa-bars"></span>
				</button>
			</div>
			<div class="align-right visible-xs" style="margin-top:.8em;">
				<div id="header-search">
				<?php get_search_form(); ?>
				</div>
				<?php 
				if (is_user_logged_in()) {
						echo 'Welcome ' . $current_user->display_name . '. <a href="' . wp_logout_url($logoutURL) . '"  title="Logout" class="">Log out?</a>'; 
						if (current_user_can('edit_posts')) echo ' | <a href="' . $adminurl . '"  title="Admin Panel">Site Admin</a>';
					} else {
						echo 'Not Logged in. <a href="' . str_replace('http://','//',get_option('siteurl')) . '/login" class="login">Log in?</a>';
					}
				?>
			</div>
		</div>
		<div class="navbar-collapse collapse">
<?php
/**
 Start Main Navigation
**/
?>	

		<nav role="navigation" class="">
			<div class="quick-nav-wrap visible-sm">
				<div class="text-right">
					<div id="header-search">
					<?php get_search_form(); ?>
					</div>
					<?php 
					if (is_user_logged_in()) {
							echo 'Welcome ' . $current_user->display_name . '. <a href="' . wp_logout_url($logoutURL) . '"  title="Logout" class="">Log out?</a>'; 
							if (current_user_can('edit_posts')) echo ' | <a href="' . $adminurl . '"  title="Admin Panel">Site Admin</a>';
						} else {
							echo 'Not Logged in. <a href="' . str_replace('http://','//',get_option('siteurl')) . '/login" class="login">Log in?</a>';
						}
					?>
				</div>
				<a href="<?php str_replace('http://','//',get_option('siteurl')); ?>/dashboard" class="dashboard-ico btn btn-info visible-xs"><i class="fa fa-tasks"></i> Dashboard</a>
				<?php wp_nav_menu( array( 'menu_class' => 'quick-nav-list text-right', 'theme_location' => 'quicknav', 'depth' => '-1' ) ); ?>
			</div>
			<div class="visible-sm clearfix"></div>
			<div id="main_nav_wrap" class="main-nav-wrap">
				<ul class="main-nav-list">
				<?php


				$school=CCSU_SCHOOL;
				//$database='food'; // MZ this doesn't appear to be Used 03/20/15
				$connectionId=1;
				include CCSU_DBPATH . '/dbIntranet.php'; 
				$connectionId=2;
				include CCSU_DBPATH . '/dbIntranet.php'; 
				$connectionId=3;
				include CCSU_DBPATH . '/dbIntranet.php'; 

				
				
				$sql="SELECT webGroupId,abbr,webGroup FROM website.webGroups WHERE category = 'ccsu' ORDER BY seq";
				if($stmt = $dbi1->prepare($sql)) {
					$stmt->execute();

					mysqli_stmt_bind_result($stmt, $webGroupId,$abbr,$webGroup);

					while (mysqli_stmt_fetch($stmt)) {
						$subnavlist=array();
						echo "<li class='main-nav-item main-nav-" . $abbr . "' id='main_nav_" . $abbr . "' aria-label='" . strtolower($webGroup) . "'>";
						echo "<div class='main-nav-title-wrap'><span class='main-nav-title'><a href='#' class=''>" . $webGroup . "&nbsp;<i class=\"fa fa-chevron-right\"></i></a></span></div>";
						echo "<div class='sub-nav-wrap text-left' id='sub_nav_" . $abbr . "' style='/*display: none; left: 9999em;*/'>";


						$sql1="SELECT categoryId,category FROM website.webCategories WHERE webGroupId=? AND school=? ORDER BY seq";
						if($stmt2 = $dbi2->prepare($sql1)) {
							$stmt2->bind_param("ss",$webGroupId,$school);
							$stmt2->execute();

							mysqli_stmt_bind_result($stmt2,$categoryId,$category);
							$i = 0;
							//$subnavlist [$i];
							while (mysqli_stmt_fetch($stmt2)) {
								$subnavlist[$i] = "<span class='sub-nav-title'>" . $category . "</span>";

								$sql2="SELECT linkTitle,linkURL,templateId FROM website.webItems WHERE categoryId=? AND school=? ORDER BY linkTitle";
								if($stmt3 = $dbi3->prepare($sql2)) {

									$stmt3->bind_param("ss",$categoryId,$school);
									$stmt3->execute();

									mysqli_stmt_bind_result($stmt3,$linkTitle,$linkURL,$templateId);
									$count = 0;

									while (mysqli_stmt_fetch($stmt3)) {
										$i ++;
										if($templateId<99) $linkURL=str_replace('http://','//',$linkURL);// forcing HTTPS
										$subnavlist[$i] =  "<a href='" . $linkURL . "'";
			   						        if($templateId==99) $subnavlist[$i] .= " target='_blank'";
										$subnavlist[$i] .=  ">" . $linkTitle . "</a>";
									}
									$i++;
								}

							}
                                         
							$totalItems = count($subnavlist) ;
							$colCount =  ceil(($totalItems) / 4) ;
		
							$k = 0;
							echo "<div class=\"sub-nav-list\">\n";
							foreach (array_chunk($subnavlist, $colCount) as $key) { ?>
									<div class="col-sm-3">
								<?php 
								foreach ($key as $value) {
										echo $value;
								} ?>
								</div><!-- eo col-3 -->
	
							<?php }
							echo "</div>\n";
							echo "</li>\n";
						}
						
					}	
					

				}
				mysqli_close($dbi1);
				mysqli_close($dbi2);
				mysqli_close($dbi3);

				?>				 	
				
				</ul>
			</div>
		</nav><!-- eo #navigation -->
		</div><!--/.nav-collapse -->
	</div><!-- eo  div role="navigation" -->
		</div><!-- eo .row -->
		<div class="clearfix"></div>
 	<div class="row">
 <?php if(!is_front_page()) the_breadcrumb(); ?>
