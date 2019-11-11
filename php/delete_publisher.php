<?php

include("connect.php");
 
$id = $_GET['id'];

$res = mysqli_query($con, "SELECT publisher_image FROM publisher WHERE publisher_id = '$id'");
			$row = mysqli_fetch_array($res);

			unlink("../bilder/publisher_bilder/".$row['publisher_image']);
			
			if(mysqli_query($con, "DELETE FROM publisher WHERE publisher_id = '$id'"))
					{
		
						header("location: ../publisher_add.php");
					}


	

?>