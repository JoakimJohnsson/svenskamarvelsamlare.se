<?php

include("php/connect.php");
include("php/functions.php");

if(logged_in()) // check if user är inloggad
	{
		$email = ($_SESSION['email']);	
		
		$get_user_info = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");

	$user = mysqli_fetch_array($get_user_info);
	
	$userid = $user['id'];
	$useradm = $user['adm'];
	$userfirstname = $user['firstname'];
	$userlastname = $user['lastname'];
	$useremail = $user['email'];
	$userseca = $user['seca'];
	$userimage = $user['image'];
	$userdate = $user['date'];
		
		
		
	}
	else
	{
		header("location:index.php");
	}

$error = "";

if(isset($_POST['submit']))
{
	$firstname = mysqli_real_escape_string($con,$_POST['fname']);
	$lastname = mysqli_real_escape_string($con,$_POST['lname']);
	$email_profile = mysqli_real_escape_string($con,$_POST['email_profile']);
	$hemstad = mysqli_real_escape_string($con,$_POST['hemstad']);
	$ommig = mysqli_real_escape_string($con,$_POST['ommig']);
	$efterlysning = mysqli_real_escape_string($con,$_POST['efterlysning']);
			
	$image = $_FILES['image']['name'];
	$tmp_image = $_FILES['image']['tmp_name'];	
	$image_size = $_FILES['image']['size'];	
	
	if(strlen($firstname) < 2)
	{
		$error = "Förnamnet måste bestå av minst 2 tecken.";
	}
	else if(strlen($lastname) < 2)
	{
		$error = "Efternamnet måste bestå av minst 2 tecken.";
	}
	else if(!filter_var($email_profile, FILTER_VALIDATE_EMAIL))
	{
		$error = "Det där är inte en korrekt e-postadress!";
	}
	
	else if($image !== "")
	{

			$res = mysqli_query($con, "SELECT image FROM users WHERE email = '$email'");
			$row = mysqli_fetch_array($res);

			unlink("bilder/user_bilder/".$row['image']);
		
			if($image_size > 409600)
			{
				$error = "Profilbilden får inte vara större än 400 kb!";	
			}
		
				$imageext = explode(".", $image);
				$imageExtension = $imageext[1];
		
				if($imageExtension == "PNG" || $imageExtension == "png" || $imageExtension == "JPG" || $imageExtension == "jpg" 
				|| $imageExtension == 		"GIF" || $imageExtension == "gif")
				{
		
				$image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
			
					$updatequery = "UPDATE users SET firstname = '{$firstname}', lastname = '{$lastname}', email_profile = '{$email_profile}', hemstad = '{$hemstad}', ommig = '{$ommig}', efterlysning = '{$efterlysning}', image = '{$image}' WHERE email= '$email'";
			
						if(mysqli_query($con, $updatequery))
						{
						
							if(move_uploaded_file($tmp_image, "bilder/user_bilder/$image"))
								{
									header("location:minprofil.php");
								}
							else
								{
									$error = "OBS! Endast formaten jpg, gif och png är tillåtna!";	
								}

						} // end if query
			
				} // end if image extension
				
	} // end if image
			
	else
	{
		
			$updatequery = "UPDATE users SET firstname = '{$firstname}', lastname = '{$lastname}', email_profile = '{$email_profile}', hemstad = '{$hemstad}', ommig = '{$ommig}', efterlysning = '{$efterlysning}' WHERE email= '$email'";
				if(mysqli_query($con, $updatequery))
				{
					header("location:minprofil.php");
					
				} //end if mysqliquery
		
	} //end else
		
} //end if isset

?>

<!doctype html>

<html>

<head>

	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>

<!-- <link href="CSS/bootstrap.css" rel="stylesheet" type="text/css"> -->

	<link href="CSS/bootstrap-3.3.4.css" rel="stylesheet" type="text/css">

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" type="text/css" href="CSS/layout.css">
    <link rel="stylesheet" type="text/css" href="CSS/bootstrapedit.css">
    
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Svenska Marvelsamlare</title>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<div><?php include 'topbar/topbar.php';?></div> <!-- topbar -->

<div id="header">
  	<a href="home.php"><img img src="bilder/sidbilder/smslogoheader.png" class="img-responsive" alt="Svenska Marvelsamlare - Logo"></a>
</div> <!-- end header -->

<div>
	<?php include 'menu/menu.php';?></div> <!-- meny -->

<div class="maincontent">
  
	<div class="normalcontent">

		<h1>Uppdatera din profil</h1><hr>
  
	   <p>Detta gör du enkelt genom att fylla i detta formulär. </p>
	   <p>Eventuella frågor och funderingar besvaras av <a href="mailto:joakim@homeruns.se">supporten</a>. </p><br>
       
       <a href="profil_min.php" class="submitbutton" style="color: #4A4631;">Tillbaka till min profil</a><br><br><hr>

		<h2>Gör ändringar här</h2><hr>
    
    	<?php 
			$query = "SELECT * FROM users WHERE email = '$email' order by id asc";

			if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
    
  		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
       
        <div class="registrationcontentleft">
      
        <label>Förnamn:</label><br>
        <input type="text" class="textfield" name="fname" value="<?php echo $row['firstname'];?>"/><br><br>
        
        <label>Efternamn:</label><br>
        <input type="text" class="textfield" name="lname" value="<?php echo $row['lastname'];?>"/><br><br>
                
        <label>E-post (Visas på profilsidan):</label><br>
        <input type="text" class="textfield" name="email_profile" value="<?php echo $row['email_profile'];?>"  /><br><br>
        
        <label>Hemstad:</label><br>
        <input type="text" class="textfield" name="hemstad" value="<?php echo $row['hemstad'];?>"  /><br><br>
       
        <label>Om mig:</label><br>
        <textarea type="text" class="textfield" name="ommig" ><?php echo $row['ommig'];?></textarea><br><br>
         </div>
        <div class="registrationcontentright">
        <label>Jag letar efter:</label><br>
        <textarea type="text" class="textfield" name="efterlysning" ><?php echo $row['efterlysning'];?></textarea><br><br>
        
        <label>Din nuvarande profilbild:</label>
        <p><img class="usrimage" src="bilder/user_bilder/<?php echo $row["image"];?>"></p>
                
        <label>Ladda upp en ny profilbild:</label><br>
        <input type="file" name="image"   /><br>
        
        <div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
        
        <input name="submit" type="submit" class="submitbutton" value="uppdatera min profil" /><br>
     	</div>
        </form>
  
  	<?php
    }

    /* free result set */
    mysqli_free_result($result);
	}

	/* close connection */
	mysqli_close($con);
	?>
  
	</div> <!-- end normalcontent -->
</div> <!-- end maincontent -->

<div class="container100">

<?php 

$ctaarticle = array('calltoact/calltoact1.php' , 'calltoact/calltoact2.php');

$ctaarrayNo = rand(0,1);

$ctaarticle = $ctaarticle[$ctaarrayNo];

$ctaarticle = include($ctaarticle);

?>

</div> <!-- cta -->

<div class="maincontent">

<?php 

$article = array('icons/icons1.php' , 'icons/icons2.php' , 'icons/icons3.php');

$arrayNo = rand(0,2);

$article = $article[$arrayNo];

$article = include($article);

?>

</div> <!-- icons -->

<div><?php include 'footer/footer.php';?></div> <!-- footer -->

<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<!-- <script src="js/bootstrap.js" type="text/javascript"></script> -->
<script src="js/bootstrap-3.3.4.js" type="text/javascript"></script>
</body>
</html>