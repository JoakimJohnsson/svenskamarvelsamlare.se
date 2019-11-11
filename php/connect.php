<?php

$con = mysqli_connect("db.svenskamarvelsamlare.se","wse664972","Hunkpapa666","wse664972_1");

if(mysqli_connect_errno())
{
	
	echo "Error occured while connecting with database ".mysqli_connect_errno();
	
}

session_start();


?>