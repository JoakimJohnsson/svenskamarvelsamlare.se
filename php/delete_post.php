<?php

include("connect.php");
 
$id = $_GET['id'];






$res = mysqli_query($con, "SELECT post_image FROM blogg WHERE post_id = '$id'");
			$row = mysqli_fetch_array($res);
			
 				unlink("../bilder/post_bilder/".$row['post_image']);
				
			if(mysqli_query($con, "DELETE FROM blogg WHERE post_id = '$id'"))
					{
		
						header("location: ../home.php");
					}


?>