<?php
	$curDate=date('Y-m-d');
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
			echo "<h2 class=\"titlebreak four\"><span>Today&#8217;s Lunch Menu</span></h2>\n";
			echo "<ul id=\"lunchmenu\">";
			$stmt3->execute();
			mysqli_stmt_bind_result($stmt3, $summary,$vod,$description);
			while (mysqli_stmt_fetch($stmt3)) {
				echo "<li><a href=\"/food-service/\" title=\"View Weekly Menu\">" . ucwords(strtolower($summary)) . "</a>\n";
				if($vod==1) echo " Vegetable of the day\n";
				else echo $description . "\n";
			}
			echo "</ul>";
		}
	}
	mysqli_close($dbi3); 
?>