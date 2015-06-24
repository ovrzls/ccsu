<?php
function showLunchMenu(){

	$curDate=date('Y-m-d');
	$linkURL=get_bloginfo('url') . "/food-service/";
	$database='food';
	$connectionId=3;
	include CCSU_DBPATH . '/dbIntranet.php'; 
	$school=CCSU_SCHOOL;
	$sql3 = "SELECT mi.summary,mi.vod,mi.description FROM food.menuItems mi 
		INNER JOIN food.menu m ON m.menuId=mi.menuId
		INNER JOIN food.menuSchools ms ON ms.menuId=m.menuId
		INNER JOIN food.schools s ON s.schoolId=ms.schoolId
		WHERE mi.menuDate=? AND s.schoolId=? AND m.published=1";
		
	if($stmt3 = $dbi3->prepare($sql3)) {
		$stmt3->bind_param("ss",$curDate,$school);
		$stmt3->execute();
		$stmt3->store_result();
	        $numrows3=$stmt3->num_rows;
		if($numrows3>0) {
			echo "<div id='menuHold'>";
			echo "<h4>Today Lunch Menu</h4><ul>";
			$selectOptions = '';
			$stmt3->execute();
			mysqli_stmt_bind_result($stmt3, $summary,$vod,$description);
			while (mysqli_stmt_fetch($stmt3)) {
				echo "<li><a href='" . $linkURL  ."' title='View Weekly Menu'";
				if($vod==1) echo "><strong>" .  $summary . "</strong></a>Vegetable of the day</li>";
				else echo "><strong>" .  $summary . "</strong></a>" . $description . "</li>";
				$selectOptions .= "<option value='" .  ucwords(strtolower($summary)) . "'>" .  ucwords(strtolower($summary)) . "</option>";

			}
			echo "</div>";
		}
	}
	mysqli_close($dbi3); 
	
}
?>