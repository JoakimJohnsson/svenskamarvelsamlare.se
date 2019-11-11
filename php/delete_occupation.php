<?php

include("connect.php");
 
$id = $_GET['id'];

			
			if(mysqli_query($con, "DELETE FROM occupation WHERE occupation_id = '$id'"))
					{
		
						header("location: ../occupation_add.php");
					}


	

?>