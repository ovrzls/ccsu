<ul class="right-nav">
<?php
$school=CCSU_SCHOOL;
$database='wp_' . strtolower($school);
$connectionId=1;
include CCSU_DBPATH . '/dbWeb.php'; 
$connectionId=2;
include CCSU_DBPATH . '/dbWeb.php'; 
$connectionId=3;
include CCSU_DBPATH . '/dbWeb.php'; 

$database='website';
$connectionId=1;
include CCSU_DBPATH . '/dbIntranet.php'; 
$connectionId=2;
include CCSU_DBPATH . '/dbIntranet.php'; 
$connectionId=3;
include CCSU_DBPATH . '/dbIntranet.php'; 
$connectionId=4;
include CCSU_DBPATH . '/dbIntranet.php'; 
$connectionId=5;
include CCSU_DBPATH . '/dbIntranet.php'; 


$linkURL1=get_permalink();
$linkURL2=$linkURL1;
$linkURL1=get_permalink();
$pageId = get_the_ID();
$linkURL1=str_replace('https','http',$linkURL1);


$tablePrefix="wp_" . $school . ".wp_" . $school . "_";
				
$sql="SELECT wg.webGroup,wc.category,wc.webGroupId,wc.categoryId FROM website.webItems wi
	INNER JOIN website.webCategories wc ON wc.categoryId=wi.categoryId 
	INNER JOIN website.webGroups wg ON wg.webGroupId=wc.webGroupId
	WHERE linkURL=? AND wc.school=? LIMIT 1";

if($stmt = $dbi1->prepare($sql)) {
		$stmt->bind_param("ss",$linkURL1,$school);
		$stmt->execute();

		mysqli_stmt_bind_result($stmt, $webGroup, $category, $webGroupId, $categoryId);
		$categoryId1=0;
		while (mysqli_stmt_fetch($stmt)) {
			$categoryId1=$categoryId;
		}
		
		if($categoryId1>0) {	
			showSideLinks($categoryId,$webGroupId,$school,$linkURL2,$pageId,$dbi2,$dbi3,$dbi4,$dbw1);
		}
}
if($categoryId1==0) {

	$sql="SELECT post_parent FROM " . $tablePrefix . "posts WHERE id=? AND post_status='publish' AND post_type='page' ORDER BY post_title";
	
	if($stmt = $dbw1->prepare($sql)) {
		$stmt->bind_param("s",$pageId);
		$stmt->execute();
                $id1=0;
		mysqli_stmt_bind_result($stmt, $post_parent);
		while (mysqli_stmt_fetch($stmt)) {
			$id1=$post_parent;		
		}
		$parentLink=get_permalink($id1);
		$parentLink=str_replace( 'https://', 'http://', $parentLink); 
                            

		$sql5="SELECT wg.webGroup,wc.category,wc.webGroupId,wc.categoryId,wi.linkURL FROM website.webItems wi
		INNER JOIN website.webCategories wc ON wc.categoryId=wi.categoryId 
		INNER JOIN website.webGroups wg ON wg.webGroupId=wc.webGroupId 
                WHERE linkURL=? LIMIT 1";
					
		
		if($stmt5 = $dbi5->prepare($sql5)) {
			$stmt5->bind_param("s",$parentLink);
			$stmt5->execute();
			mysqli_stmt_bind_result($stmt5, $webGroup, $category, $webGroupId, $categoryId,$linkURL);
			$categoryId1=0;
			while (mysqli_stmt_fetch($stmt5)) {
				$categoryId1=$categoryId;
			}
			if($categoryId1>0) {
				showSideLinks($categoryId1,$webGroupId,$school,$linkURL,$id1,$dbi2,$dbi3,$dbi4,$dbw1);
			}
		}
	}
		
}


function showSideLinks($categoryId,$webGroupId,$school,$linkURL2,$pageId,$dbi2,$dbi3,$dbi4,$dbw1) {

	$tablePrefix="wp_" . $school . ".wp_" . $school . "_";
	

	$sql1="SELECT abbr,webGroup,webGroupId as webGroupId1 FROM website.webGroups ORDER BY seq";
	if($stmt2 = $dbi2->prepare($sql1)) {
		$stmt2->execute();
		mysqli_stmt_bind_result($stmt2, $abbr, $webGroup, $webGroupId1);
					
		while (mysqli_stmt_fetch($stmt2)) {
			if($webGroupId1==$webGroupId) {
				echo "\t<li class='right-nav-section' id='right_nav_" . $abbr . "' aria-label='" . strtolower($webGroup) . "'>";
				echo "<h4>" . $webGroup . "&nbsp;<i class=\"fa fa-chevron-down\"></i></h4>";

				$sql2="SELECT categoryId as categoryId1,category,anchorPage 
				FROM website.webCategories WHERE webGroupId=? AND school=? ORDER BY seq";

				if($stmt3 = $dbi3->prepare($sql2)) {
					$stmt3->bind_param("ss",$webGroupId,$school);
					$stmt3->execute();

					mysqli_stmt_bind_result($stmt3, $categoryId1, $category, $anchorPage);
					$categoryId1=0;
					while (mysqli_stmt_fetch($stmt3)) {
						echo "\n\t<ul class='right-nav-list'>";
						if(!empty($anchorPage)) {
							echo "\n\t\t<li><span class='right-nav-title'><a href='" . $anchorPage . "'>" . $category . "</a></span>";
                               	                } else {
							echo "\n\t\t<li><span class='right-nav-title'>" . $category . "</span>";// please make this clickable
						}

						if($categoryId1==$categoryId){
							echo "\n\t\t<ul class='right-sub-nav'>";
							$sql3="SELECT linkURL, linkTitle,templateId from website.webItems 
							WHERE categoryId=? and school=? and linkTitle<>'' ORDER BY linkTitle";
							if($stmt4 = $dbi4->prepare($sql3)) {
								$stmt4->bind_param("ss",$categoryId,$school);
								$stmt4->execute();

								mysqli_stmt_bind_result($stmt4, $linkURL, $linkTitle,$templateId);
								while (mysqli_stmt_fetch($stmt4)) {
									$class = '';

									if($templateId<99) $linkURL=  preg_replace('#^https?:#', '',$linkURL);// Stripping HTTP(s) from the URL to compare
									$url  = preg_replace('#^https?:#', '',$linkURL2);

									if (isset($queryString)) $url .= "?" . $queryString;
									if($linkURL==$url) $class = "current";
									echo "\n\t\t\t<li class=\"". $class ."\"><a href=\"" . $linkURL . "\">". $linkTitle . "</a>";
									if($linkURL==$url) {
										echo "\n\t\t\t<ul class=\"\">";
										$sql3="SELECT ID,post_title FROM " . $tablePrefix . "posts WHERE post_parent=? AND post_status='publish' AND post_type='page'    AND INSTR(post_content,'GrabCustom')=0 ORDER BY post_title";
										if($stmt5 = $dbw1->prepare($sql3)) {
											$stmt5->bind_param("s",$pageId);
											$stmt5->execute();
											mysqli_stmt_bind_result($stmt5, $ID, $post_title);
											while (mysqli_stmt_fetch($stmt5)) {						
												$id1=$ID;
												echo "\n\t\t\t\t<li><a href='" . get_permalink($id1) . "' title='" .  $post_title . "'>" .  $post_title . "</a></li>";
											}
										}
										echo "\n\t\t\t</ul>";
									}										
												
									echo "</li>";
								}
							}
							echo "\n\t\t</ul>";
						}	
						echo "</li>\n\t</ul>";
					}
		
				}
			}
		}
	}
				
}
?>
</li>
</ul>