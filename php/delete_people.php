<?php

include("connect.php");
 
$id = $_GET['id'];

$res = mysqli_query($con, "SELECT people_image FROM people WHERE people_id = '$id'");
			$row = mysqli_fetch_array($res);

			unlink("../bilder/people_bilder/".$row['people_image']);
			
			if(mysqli_query($con, "DELETE FROM people WHERE people_id = '$id'"))
					{
		
						header("location: ../people_add.php");
					}


	

?>