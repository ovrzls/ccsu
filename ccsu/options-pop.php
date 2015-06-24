
<?php
	$pop_text = trim(of_get_option('pop_editor')); if(($pop_text == "")) unset($pop_text);

	if (isset($pop_text)):
		echo $pop_text;
	endif;
	
?>

	