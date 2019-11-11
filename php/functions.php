<?php

	function email_exists($email, $con)
	{
		$result = mysqli_query($con,"SELECT id FROM users WHERE email='$email'");
		
		if(mysqli_num_rows($result) == 1)
		{
			return true;	
		}
		else
		{
			return false;
		}
	
	
	}
	
	
		function email_seca_exists($seca, $email, $con)
	{
		$result = mysqli_query($con,"SELECT id FROM users WHERE seca='$seca' AND email='$email'");
		
		if(mysqli_num_rows($result) == 1)
		{
			return true;	
		}
		else
		{
			return false;
		}
	
	
	}
	
	
		function get_user_info()
	{
	
		$get_user_info = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
	
		$user = mysqli_fetch_array($get_user_info);
		
		$firstname = $user['firstname'];
		$lastname = $user['lastname'];
		$seca = $user['seca'];
		$image = $user['image'];
	}
	
	
	
	
	function logged_in()
		{
			if(isset($_SESSION['email']) || isset($_COOKIE['email']))	
			{
				return true;	
			}
			else
			{
				return false;	
			}
			
		}

	








?>