<?php

include("connect.php");
 
$id = $_GET['id'];

$res = mysqli_query($con, "SELECT title_image FROM title WHERE title_id = '$id'");
			$row = mysqli_fetch_array($res);

			unlink("../bilder/title_bilder/".$row['title_image']);
			
			if(mysqli_query($con, "DELETE FROM title WHERE title_id = '$id'"))
					{
		
						header("location: ../title_add.php");
					}


	

?>