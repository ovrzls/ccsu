<?php
/*
Template Name: Custom Dashboard
*/
?><?php get_header(); ?>
<?php
echo "<div class='col-md-12'>";
echo "<br>";
echo "<div class='tab-content'>";
global $current_user;
$curUser = $current_user->user_login; 
if(empty($curUser)) $userType='';
else $userType=getUserType($curUser);
$site=CCSU_SCHOOL;

echo "<ul class='nav nav-tabs nav-pills nav-blue' role='tablist' data-tabs='tabs'>";
if(($userType=='') || ($userType=='Student')) {
	echo "<li class='active'><a data-toggle='tab' data-target='#students' href='#students'><h4>STUDENTS</h4></a></li>";
}
if($userType=='') {
  echo "<li><a data-toggle='tab' data-target='#parents' href='#parents'><h4>FAMILIES</h4></a></li>";
}
if($userType=='Parent') {
 echo "<li class='active'><a data-toggle='tab' data-target='#parents' href='#parents'><h4>FAMILIES</h4></a></li>";
}

if($userType=='') {
  echo "<li><a data-toggle='tab' data-target='#staff' href='#staff'><h4>STAFF</h4></a></li>";
}
if($userType=='Teacher') {
 echo "<li class='active'><a data-toggle='tab' data-target='#staff' href='#staff'><h4>STAFF</h4></a></li>";
}
echo "</ul>";

$database='website';	
$connectionId=1;
include CCSU_DBPATH . '/dbIntranet.php'; 
$connectionId=2;
include CCSU_DBPATH . '/dbIntranet.php'; 
$connectionId=3;
include CCSU_DBPATH . '/dbIntranet.php'; 

if($userType=='') {
     	echo "<div class='tab-pane fade in active' id='students'>";
	$sql="SELECT c.categoryId,c.category FROM website.webDashboardCategories c
	INNER JOIN website.webDashboard d ON d.categoryId=c.categoryId
	WHERE d.students=1 AND (d.school=? OR d.school='ccsu') 
	GROUP BY c.categoryId ORDER BY c.seq";
	

	if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("s", $site);
		$stmt->execute();

		mysqli_stmt_bind_result($stmt, $categoryId,$category);
		while (mysqli_stmt_fetch($stmt)) {
			echo "<ul class='gallery-grid'>";
			echo "<li class='grid-header'>";
			echo "<h3>" . $category . "</h3>";
			echo "<ul class='grid-row'>";
		
			$sql1="SELECT d.linkURL,d.linkIcon,d.title FROM website.webDashboard d 
			WHERE d.students=1 AND d.categoryId=? AND (d.school=? OR d.school='ccsu')  ORDER BY d.title";

			if($stmt2 = $dbi2->prepare($sql1)) {
				$stmt2->bind_param("ss", $categoryId,$site);
				$stmt2->execute();

				mysqli_stmt_bind_result($stmt2, $linkURL,$linkIcon,$title);
				while (mysqli_stmt_fetch($stmt2)) {
					echo "<li class='grid-item'><a href='" . $linkURL . "' ><img src='" . CCSU_STYLE . "/images/dashboard/" . $linkIcon . "' alt='" . $title . "'></a>" . $title . "</li>";
				}
			}
			echo "</ul>";
			echo "</li></ul>";
	        }
		echo "</div>";
	}


	echo "<div class='tab-pane fade' id='parents'>";
	
		
	$sql="SELECT c.categoryId,c.category FROM website.webDashboardCategories c
	INNER JOIN website.webDashboard d ON d.categoryId=c.categoryId
	WHERE d.parents=1 AND (d.school=? OR d.school='ccsu')
	GROUP BY c.categoryId ORDER BY c.seq";
	if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("s", $site);
		$stmt->execute();

		mysqli_stmt_bind_result($stmt, $categoryId,$category);
		while (mysqli_stmt_fetch($stmt)) {
			echo "<ul class='gallery-grid'>";
			echo "<li class='grid-header'>";
			echo "<h3>" . $category . "</h3>";
			echo "<ul class='grid-row'>";
		
			$sql1="SELECT d.linkURL,d.linkIcon,d.title FROM website.webDashboard d 
				WHERE d.parents=1 AND d.categoryId=? AND (d.school=? OR d.school='ccsu')  ORDER BY d.title";
			if($stmt2 = $dbi2->prepare($sql1)) {
				$stmt2->bind_param("ss", $categoryId,$site);
				$stmt2->execute();
				mysqli_stmt_bind_result($stmt2, $linkURL,$linkIcon,$title);
				while (mysqli_stmt_fetch($stmt2)) {
					echo "<li class='grid-item'><a href='" . $linkURL . "' ><img src='" . CCSU_STYLE . "/images/dashboard/" . $linkIcon . "' alt='" . $title . "'></a>" . $title . "</li>";
				}
			}	
			echo "</ul>";
			echo "</li></ul>";
		}   
		echo "</div>";
	}


	echo "<div class='tab-pane fade' id='staff'>";
	$sql="SELECT c.categoryId,c.category FROM website.webDashboardCategories c
	INNER JOIN website.webDashboard d ON d.categoryId=c.categoryId
	WHERE d.faculty=1 AND  (d.school=? OR d.school='ccsu')
	GROUP BY c.categoryId ORDER BY c.seq";
	if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("s", $site);
		$stmt->execute();

		mysqli_stmt_bind_result($stmt, $categoryId,$category);
		while (mysqli_stmt_fetch($stmt)) {
			echo "<ul class='gallery-grid'>";
			echo "<li class='grid-header'>";
			echo "<h3>" . $category . "</h3>";
			echo "<ul class='grid-row'>";
		
			$sql1="SELECT d.linkURL,d.linkIcon,d.title FROM website.webDashboard d 
				WHERE d.faculty=1 AND d.categoryId=? AND (d.school=? OR d.school='ccsu')  ORDER BY d.title";
			if($stmt2 = $dbi2->prepare($sql1)) {
				$stmt2->bind_param("ss", $categoryId,$site);
				$stmt2->execute();

				mysqli_stmt_bind_result($stmt2, $linkURL,$linkIcon,$title);
				while (mysqli_stmt_fetch($stmt2)) {
					echo "<li class='grid-item'><a href='" . $linkURL . "' ><img src='" . CCSU_STYLE . "/images/dashboard/" . $linkIcon . "' alt='" . $title . "'></a>" . $title . "</li>";
				}
			}	
			echo "</ul>";
			echo "</li></ul>";
		}   
	}
	echo "</div>";
} elseif($userType=='Student') {
     	echo "<div class='tab-pane fade in active' id='students'>";
	$sql="SELECT c.categoryId,c.category FROM website.webDashboardCategories c
	INNER JOIN website.webDashboard d ON d.categoryId=c.categoryId
	WHERE d.students=1 AND (d.school=? OR d.school='ccsu') 
	GROUP BY c.categoryId ORDER BY c.seq";
	

	if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("s", $site);
		$stmt->execute();

		mysqli_stmt_bind_result($stmt, $categoryId,$category);
		while (mysqli_stmt_fetch($stmt)) {
			echo "<ul class='gallery-grid'>";
			echo "<li class='grid-header'>";
			echo "<h3>" . $category . "</h3>";
			echo "<ul class='grid-row'>";
		
			$sql1="SELECT d.linkURL,d.linkIcon,d.title FROM website.webDashboard d 
			WHERE d.students=1 AND d.categoryId=? AND (d.school=? OR d.school='ccsu')  ORDER BY d.title";

			if($stmt2 = $dbi2->prepare($sql1)) {
				$stmt2->bind_param("ss", $categoryId,$site);
				$stmt2->execute();

				mysqli_stmt_bind_result($stmt2, $linkURL,$linkIcon,$title);
				while (mysqli_stmt_fetch($stmt2)) {
					echo "<li class='grid-item'><a href='" . $linkURL . "' ><img src='" . CCSU_STYLE . "/images/dashboard/" . $linkIcon . "' alt='" . $title . "'></a>" . $title . "</li>";
				}
			}
			echo "</ul>";
			echo "</li></ul>";
	        }
	}
	echo "</div>";
} elseif($userType=='Parent') {
	echo "<div class='tab-pane fade in active' id='parents'>";
	
	
	$sql="SELECT c.categoryId,c.category FROM website.webDashboardCategories c
	INNER JOIN website.webDashboard d ON d.categoryId=c.categoryId
	WHERE d.parents=1 AND (d.school=? OR d.school='ccsu')
	GROUP BY c.categoryId ORDER BY c.seq";
	if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("s", $site);
		$stmt->execute();

		mysqli_stmt_bind_result($stmt, $categoryId,$category);
		while (mysqli_stmt_fetch($stmt)) {
			echo "<ul class='gallery-grid'>";
			echo "<li class='grid-header'>";
			echo "<h3>" . $category . "</h3>";
			echo "<ul class='grid-row'>";
		
			$sql1="SELECT d.linkURL,d.linkIcon,d.title FROM website.webDashboard d 
				WHERE d.parents=1 AND d.categoryId=? AND (d.school=? OR d.school='ccsu')  ORDER BY d.title";
			if($stmt2 = $dbi2->prepare($sql1)) {
				$stmt2->bind_param("ss", $categoryId,$site);
				$stmt2->execute();
				mysqli_stmt_bind_result($stmt2, $linkURL,$linkIcon,$title);
				while (mysqli_stmt_fetch($stmt2)) {
					echo "<li class='grid-item'><a href='" . $linkURL . "' ><img src='" . CCSU_STYLE . "/images/dashboard/" . $linkIcon . "' alt='" . $title . "'></a>" . $title . "</li>";
				}
			}	
			echo "</ul>";
			echo "</li></ul>";
		}   
		
	}
	echo "</div>";
}elseif($userType=='Teacher') {
	echo "<div class='tab-pane in active' id='staff'>";
	$i1=0;
	$sql="SELECT itemId FROM website.webCustomDashboard WHERE userName=?";
	if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("s", $curUser);
		$stmt->execute();

		$stmt->store_result();
				
	        $i1=$stmt->num_rows;
	}
       
	if($i1==0) {
		$sql="SELECT c.categoryId,c.category FROM website.webDashboardCategories c
		INNER JOIN website.webDashboard d ON d.categoryId=c.categoryId
		WHERE d.faculty=1 AND  (d.school=? OR d.school='ccsu')
		GROUP BY c.categoryId ORDER BY c.seq";
		if($stmt = $dbi1->prepare($sql)) {
			$stmt->bind_param("s", $site);
			$stmt->execute();

			mysqli_stmt_bind_result($stmt, $categoryId,$category);
			while (mysqli_stmt_fetch($stmt)) {
				echo "<ul class='gallery-grid'>";
				echo "<li class='grid-header'>";
				echo "<h3>" . $category . "</h3>";
				echo "<ul class='grid-row'>";
			
				$sql1="SELECT d.linkURL,d.linkIcon,d.title FROM website.webDashboard d 
					WHERE d.faculty=1 AND d.categoryId=? AND (d.school=? OR d.school='ccsu')  ORDER BY d.title";
				if($stmt2 = $dbi2->prepare($sql1)) {
					$stmt2->bind_param("ss", $categoryId,$site);
					$stmt2->execute();

					mysqli_stmt_bind_result($stmt2, $linkURL,$linkIcon,$title);
					while (mysqli_stmt_fetch($stmt2)) {
						echo "<li class='grid-item'><a href='" . $linkURL . "' ><img src='" . CCSU_STYLE . "/images/dashboard/" . $linkIcon . "' alt='" . $title . "'></a>" . $title . "</li>";
					}
				}	
				echo "</ul>";
				echo "</li></ul>";
			}   
		}
	}else{

		$sql="SELECT c.categoryId,c.category FROM website.webDashboardCategories c
		INNER JOIN website.webCustomDashboard d ON d.categoryId=c.categoryId
		WHERE d.userName=? AND  (d.school=? OR d.school='ccsu') 
		GROUP BY c.categoryId ORDER BY c.seq";

		if($stmt = $dbi1->prepare($sql)) {
			$stmt->bind_param("ss", $curUser,$site);
			$stmt->execute();

			mysqli_stmt_bind_result($stmt, $categoryId,$category);
			while (mysqli_stmt_fetch($stmt)) {
				echo "<ul class='gallery-grid'>";
				echo "<li class='grid-header'>";
				echo "<h3>" . $category . "</h3>";
				echo "<ul class='grid-row'>";
		
				$sql1="SELECT d.linkURL,d.linkIcon,d.title FROM website.webCustomDashboard d 
				WHERE d.userName=? AND d.categoryId=? AND (d.school=? OR d.school='ccsu')  ORDER BY d.title";

				if($stmt2 = $dbi2->prepare($sql1)) {
					$stmt2->bind_param("sss", $curUser,$categoryId,$site);
					$stmt2->execute();

					mysqli_stmt_bind_result($stmt2, $linkURL,$linkIcon,$title);
					while (mysqli_stmt_fetch($stmt2)) {
						echo "<li class='grid-item'><a href='" . $linkURL . "' target='_blank'><img src='" . CCSU_STYLE . "/images/dashboard/" . $linkIcon . "' alt='" . $title . "'></a>" . $title . "</li>";
					}
				}	
				echo "</ul>";
				echo "</li></ul>";
			}
			
		}   


	}
	echo "</div>";
}


mysqli_close($dbi1);
mysqli_close($dbi2);
mysqli_close($dbi3);


echo "</ul>";
echo "</div></div>";
if($userType=='Teacher') {
	echo "<div style='float:right;'><br/><a href='http://ccsu73.ccsuvt.org/ccsu/customDashboard/" . $site . "/" . $curUser . "/'>Customize Your Dashboard</a><br/></div>";  
}
?>

<?php get_footer(); ?>