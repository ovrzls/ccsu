</div><!--eo .row -->
<footer>
<div class="row" id="footer">
<div class="col-md-7">
<span class="vcard">
<h2>Welcome to <span class="org"><?php echo get_bloginfo ( 'name' );  ?></soan></h2>
<small style="text-transform: initial;font-size: 11px;line-height: 1.45em;display: block;margin: 10px 0;">
<?php  echo get_theme_mod("welcome_text"); ?>
</small>
<span class="street-address"><?php  echo get_theme_mod("contact_info"); ?></span><br>
<span class="license">&copy; <?php echo date('Y'); ?> <span class="fn org"><?php echo get_bloginfo ( 'name' );  ?></span></span>
<span class="links"> | <a href="<?php echo str_replace('http:','https:',get_bloginfo('url')); ?>/comments/">Comments/Feedback</a> | <a href="mailto:webmaster@ccsuvt.com">webmaster</a></span><br>
<span class="terms"><a href="http://www.ccsuvt.org/terms">Terms of Use</a></span>
</span>
<br><br>
<div id="webGodaddySeal">
<span id="siteseal"><img src="//content.ccsuvt.org/custom/logos/godaddy_verified.png" width="124" height="34"></span>
</div>
</div><!-- eo col-md-8 -->
<div class="col-md-5">
<br>
	<h4>
		<?php
			$current_user = wp_get_current_user();
			if (is_user_logged_in()) {
				echo 'Welcome ' . $current_user->display_name . '. <a href="' . wp_logout_url( get_permalink() ) . '"  title="Log out">Log out?</a>';
			} else {
				echo '<a href="' . get_bloginfo("url") . '/login"><img src="' . get_bloginfo("template_directory"). '/images/SchoolPort.png"> Log in</a>';
			}
			?>
			</h4>
<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<?php wp_nav_menu( array( 'menu_class' => 'social social-nav-list clearfix','class'=>'nav-item', 'theme_location' => 'footernav', 'depth' => '0' ) ); ?>
	<div id="footer-search" class="clearfix">
	<?php get_search_form(); ?>
	</div>

<hr class="clear"><br>
	<?php wp_nav_menu( array( 'menu_class' => 'social social-nav-list clearfix','class'=>'social-icons', 'theme_location' => 'footersocialnav', 'depth' => '-1' ) ); ?>
 <p class="clear"></p>
</div><!-- eo col-md-4 -->
 <div class="clearfix visible-lg-block"></div>
 <p class="clear"></p>
</div><!-- eo .row #footer -->
</footer>
</div><!-- eo .mainconatiner -->
<?php wp_footer(); ?>
</body>
</html>