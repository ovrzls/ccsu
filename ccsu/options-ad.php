<div class="col-sm-6 col-md-3">
	<div class="activity-box">
<?php
	$imagepath =  get_template_directory_uri() . '/images/';
	$ad_img = of_get_option('ad_img'); if(($ad_img == "")) unset($ad_img);
	$ad_heading = trim(of_get_option('ad_heading')); if(($ad_heading == "")) unset($ad_heading);
	$ad_text = trim(of_get_option('ad_text')); if(($ad_text == "")) unset($ad_text);
	$display_button = of_get_option('display_ad_button'); if(($display_button == "")) unset($display_button);
	$button = trim(of_get_option('ad_button_title')); if(($button == "")) unset($button);
	$link = trim(of_get_option('ad_button_link')); if(($link == "")) unset($link);

	if (isset($ad_img)):
		if (isset($link)) echo "<a href=\"" . $link ."\">";
		$ad_img = str_replace("http://", "//", $ad_img);
		echo "<img src=\"" . $ad_img . "\">\n";
		if (isset($link)) echo "</a>\n";
	endif;
	if (isset($ad_text)):
		echo "<p class=\"caption\">" . $ad_text;
		if (isset($link)):
			echo " <a href=\"" . $link ."\">";
			echo $button;
			echo "</a>\n";
		endif;
		echo "</p>\n";
	endif;
	
?>
	</div><!-- eo .activity-box -->
</div><!-- eo .col-md-3 -->