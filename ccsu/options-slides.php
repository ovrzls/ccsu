<?php
	$imagepath =  get_template_directory_uri() . '/images/';
	
	$slider_img_1 = of_get_option('slider_img_1'); if(($slider_img_1 == "")) unset($slider_img_1);
	$slider_img_2 = of_get_option('slider_img_2'); if(($slider_img_2 == "")) unset($slider_img_2);
	$slider_img_3 = of_get_option('slider_img_3'); if(($slider_img_3 == "")) unset($slider_img_3);
	$slider_img_4 = of_get_option('slider_img_4'); if(($slider_img_4 == "")) unset($slider_img_4);
	$slider_img_5 = of_get_option('slider_img_5'); if(($slider_img_5 == "")) unset($slider_img_5);
	$slider_img_6 = of_get_option('slider_img_6'); if(($slider_img_6 == "")) unset($slider_img_6);
	$slider_img_7 = of_get_option('slider_img_7'); if(($slider_img_7 == "")) unset($slider_img_7);
	$slider_img_8 = of_get_option('slider_img_8'); if(($slider_img_8 == "")) unset($slider_img_8);
	$slider_img_9 = of_get_option('slider_img_9'); if(($slider_img_9 == "")) unset($slider_img_9);
	
	$heading_1 = trim(of_get_option('slider_image_heading_1')); if(($heading_1 == "")) unset($heading_1);
	$heading_2 = trim(of_get_option('slider_image_heading_2')); if(($heading_2 == "")) unset($heading_2);
	$heading_3 = trim(of_get_option('slider_image_heading_3')); if(($heading_3 == "")) unset($heading_3);
	$heading_4 = trim(of_get_option('slider_image_heading_4')); if(($heading_4 == "")) unset($heading_4);
	$heading_5 = trim(of_get_option('slider_image_heading_5')); if(($heading_5 == "")) unset($heading_5);
	$heading_6 = trim(of_get_option('slider_image_heading_6')); if(($heading_6 == "")) unset($heading_6);
	$heading_7 = trim(of_get_option('slider_image_heading_7')); if(($heading_7 == "")) unset($heading_7);
	$heading_8 = trim(of_get_option('slider_image_heading_8')); if(($heading_8 == "")) unset($heading_8);
	$heading_9 = trim(of_get_option('slider_image_heading_9')); if(($heading_9 == "")) unset($heading_9);
	
	$caption_1 = trim(of_get_option('slider_image_caption_1')); if(($caption_1 == "")) unset($caption_1);
	$caption_2 = trim(of_get_option('slider_image_caption_2')); if(($caption_2 == "")) unset($caption_2);
	$caption_3 = trim(of_get_option('slider_image_caption_3')); if(($caption_3 == "")) unset($caption_3);
	$caption_4 = trim(of_get_option('slider_image_caption_4')); if(($caption_4 == "")) unset($caption_4);
	$caption_5 = trim(of_get_option('slider_image_caption_5')); if(($caption_5 == "")) unset($caption_5);
	$caption_6 = trim(of_get_option('slider_image_caption_6')); if(($caption_6 == "")) unset($caption_6);
	$caption_7 = trim(of_get_option('slider_image_caption_7')); if(($caption_7 == "")) unset($caption_7);
	$caption_8 = trim(of_get_option('slider_image_caption_8')); if(($caption_8 == "")) unset($caption_8);
	$caption_9 = trim(of_get_option('slider_image_caption_9')); if(($caption_9 == "")) unset($caption_9);
	
	$button_1 = trim(of_get_option('slider_image_button_1')); if(($button_1 == "")) unset($button_1);
	$button_2 = trim(of_get_option('slider_image_button_2')); if(($button_2 == "")) unset($button_2);
	$button_3 = trim(of_get_option('slider_image_button_3')); if(($button_3 == "")) unset($button_3);
	$button_4 = trim(of_get_option('slider_image_button_4')); if(($button_4 == "")) unset($button_4);
	$button_5 = trim(of_get_option('slider_image_button_5')); if(($button_5 == "")) unset($button_5);
	$button_6 = trim(of_get_option('slider_image_button_6')); if(($button_6 == "")) unset($button_6);
	$button_7 = trim(of_get_option('slider_image_button_7')); if(($button_7 == "")) unset($button_7);
	$button_8 = trim(of_get_option('slider_image_button_8')); if(($button_8 == "")) unset($button_8);
	$button_9 = trim(of_get_option('slider_image_button_9')); if(($button_9 == "")) unset($button_9);
	
	$link_1 = trim(of_get_option('slider_image_button_1_link')); if(($link_1 == "")) unset($link_1);
	$link_2 = trim(of_get_option('slider_image_button_2_link')); if(($link_2 == "")) unset($link_2);
	$link_3 = trim(of_get_option('slider_image_button_3_link')); if(($link_3 == "")) unset($link_3);
	$link_4 = trim(of_get_option('slider_image_button_4_link')); if(($link_4 == "")) unset($link_4);
	$link_5 = trim(of_get_option('slider_image_button_5_link')); if(($link_5 == "")) unset($link_5);
	$link_6 = trim(of_get_option('slider_image_button_6_link')); if(($link_6 == "")) unset($link_6);
	$link_7 = trim(of_get_option('slider_image_button_7_link')); if(($link_7 == "")) unset($link_7);
	$link_8 = trim(of_get_option('slider_image_button_8_link')); if(($link_8 == "")) unset($link_8);
	$link_9 = trim(of_get_option('slider_image_button_9_link')); if(($link_9 == "")) unset($link_9);

	$sliderArray = array();
	//array_push($sliderArray, $slider_img_1, $slider_img_2, $slider_img_3, $slider_img_4);
        if(!empty($slider_img_1)){
	        if(empty($heading_1)) $heading_1='';
        	if(empty($caption_1)) $caption_1='';
		if(empty($button_1)) $button_1='';
		if(empty($link_1)) $link_1='';
		$sliderArray[] = array($slider_img_1, $heading_1, $caption_1, $button_1, $link_1);
	}
        if(!empty($slider_img_2)){
	        if(empty($heading_2)) $heading_2='';
        	if(empty($caption_2)) $caption_2='';
		if(empty($button_2)) $button_2='';
		if(empty($link_2)) $link_2='';
		$sliderArray[] = array($slider_img_2, $heading_2, $caption_2, $button_2, $link_2);
	}
        if(!empty($slider_img_3)){
	        if(empty($heading_3)) $heading_3='';
        	if(empty($caption_3)) $caption_3='';
		if(empty($button_3)) $button_3='';
		if(empty($link_3)) $link_3='';
		$sliderArray[] = array($slider_img_3, $heading_3, $caption_3, $button_3, $link_3);
	}
        if(!empty($slider_img_4)){
	        if(empty($heading_4)) $heading_4='';
        	if(empty($caption_4)) $caption_4='';
		if(empty($button_4)) $button_4='';
		if(empty($link_4)) $link_4='';
		$sliderArray[] = array($slider_img_4, $heading_4, $caption_4, $button_4, $link_4);
	}

        if(!empty($slider_img_5)){
	        if(empty($heading_5)) $heading_5='';
        	if(empty($caption_5)) $caption_5='';
		if(empty($button_5)) $button_5='';
		if(empty($link_5)) $link_5='';
		$sliderArray[] = array($slider_img_5, $heading_5, $caption_5, $button_5, $link_5);
	}


        if(!empty($slider_img_6)){
	        if(empty($heading_6)) $heading_6='';
        	if(empty($caption_6)) $caption_6='';
		if(empty($button_6)) $button_6='';
		if(empty($link_6)) $link_6='';
		$sliderArray[] = array($slider_img_6, $heading_6, $caption_6, $button_6, $link_6);
	}

        if(!empty($slider_img_7)){
	        if(empty($heading_7)) $heading_7='';
        	if(empty($caption_7)) $caption_7='';
		if(empty($button_7)) $button_7='';
		if(empty($link_7)) $link_7='';
		$sliderArray[] = array($slider_img_7, $heading_7, $caption_7, $button_7, $link_7);
	}

        if(!empty($slider_img_8)){
	        if(empty($heading_8)) $heading_8='';
        	if(empty($caption_8)) $caption_8='';
		if(empty($button_8)) $button_8='';
		if(empty($link_8)) $link_8='';
		$sliderArray[] = array($slider_img_8, $heading_8, $caption_8, $button_8, $link_8);
	}

        if(!empty($slider_img_9)){
	        if(empty($heading_9)) $heading_9='';
        	if(empty($caption_9)) $caption_9='';
		if(empty($button_9)) $button_9='';
		if(empty($link_9)) $link_9='';
		$sliderArray[] = array($slider_img_9, $heading_9, $caption_9, $button_9, $link_9);
	}


	//print_r($sliderArray);
?>    
<?php if(isset($slider_img_1) || isset($slider_img_2) || isset($slider_img_3) || isset($slider_img_4) || isset($slider_img_5) || isset($slider_img_6) || isset($slider_img_7) || isset($slider_img_8) || isset($slider_img_9)) :?>
	<!-- Carousel
    ================================================== -->


<div id="myCarousel" class="carousel slide well">
	<div class="carousel-inner">
<?php
shuffle($sliderArray);
$i = 0;
foreach ($sliderArray as $key => $value) {
	if(isset($value[0])): 
		$img = str_replace('http://', '//', $value[0]);?>
		<div class="item<?php if(!$i) echo " active"; ?>" style="background: url('<?php echo $img; ?>') no-repeat 0 0;background-size: auto 87%;">
		<?php 
		if($value[4] && $value[4] != "") echo "<a href=\"" . $value[4] . "\">"; ?>
		<img src="<?php echo $img; ?>" style="height:234px;opacity:0;" alt=""><?php if($value[4]) echo "</a>"; ?>
		<div class="bottom_shadow_full"></div>
			<?php if($value[1] || $value[2] || $value[4]) { ?>
			<div class="caption-container">
				<div class="carousel-caption">
				<?php if(isset($value[1])): ?>
				<h3><?php echo $value[1];?></h3>
				<?php endif;?>
				<?php if(isset($value[2])): ?>
				<p class="lead"><?php echo $value[2]; ?></p>
				<?php endif;?>
				</div><!--eo .carousel-caption -->
				<?php if(isset($value[4]) && $value[4] != ""): ?>
				<a class="btn btn-primary btn-large btn-custom caption-button" href="<?php echo $value[4]; ?>"><?php echo $value[3]; ?></a>
				<?php endif;?>
			</div><!-- eo .container -->
			<?php } ?>
		</div><!-- eo .item -->
	<?php 
	$i++;
	endif;
}
?>
		</div><!-- eo .carousel-inner -->
	<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span></span></a>
	<a class="right carousel-control" href="#myCarousel" data-slide="next"><span></span></a>
	</div><!-- carousel -->
	  <!-- Indicators -->
<!--
      <ol class="carousel-indicators">
	  <?php if(isset($slider_img_1)): ?>
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	  <?php endif;?>
	  <?php if(isset($slider_img_2)): ?>
        <li data-target="#myCarousel" data-slide-to="1"></li>
	  <?php endif;?>
	  <?php if(isset($slider_img_3)): ?>
        <li data-target="#myCarousel" data-slide-to="2"></li>
	  <?php endif;?>
	  <?php if(isset($slider_img_4)): ?>
        <li data-target="#myCarousel" data-slide-to="3"></li>
	  <?php endif;?>
      </ol>
-->
<?php endif;?>