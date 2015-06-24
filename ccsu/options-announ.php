
	<blockquote id="announcement">
<?php
	$announ_text = trim(of_get_option('announce_editor')); if(($announ_text == "")) unset($announ_text);
	$icon_color = trim(of_get_option('announce_colorpicker')); if($icon_color == "") $icon_color = "#ffcc33";
	$button = trim(of_get_option('announce_button')); if(($button == "")) unset($button);
	$link = trim(of_get_option('announce_button_link')); if(($link == "")) unset($link);

	/*if (isset($announ_img)):
		if (isset($link)) echo "<a href=\"" . $link ."\">";
		$announ_img = str_replace("http://", "//", $announ_img);
		echo "<img src=\"" . $announ_img . "\">\n";
		if (isset($link)) echo "</a>\n";
	endif;*/
	if (isset($announ_text)): ?>
	<style type="text/css">
	#announcement:after, #announcement:after:hover { color:<?php 
		echo $icon_color; 
	?>;}
	</style>
	<?php		
		echo "<p>";
		echo $announ_text;
		if (isset($link) && $link != ""):
			echo "<br><a href=\"" . $link ."\" class=\"btn btn-custom\">";
			echo $button;
			echo "</a>\n";
		endif;
		echo "</p>";
	endif;
	
?>

	</blockquote>
	