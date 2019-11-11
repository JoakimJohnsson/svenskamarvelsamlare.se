<?php

include("php/connect.php");
include("php/functions.php");

$error = "";

if(isset($_POST['savepass']))
		
		{
			$password = $_POST['password'];	
			$confirmPassword = $_POST['passwordconfirm'];
			
			if(strlen($password) < 7)
			{
				$error = "OBS! Ett lösenord måste vara minst 8 tecken.";
			}
			else if($password !== $confirmPassword)
			{
				$error = "OBS! Du har fyllt i fel lösenord i bekräfta lösenord-rutan";
			}
			else
			{
				$password = md5($password);
				
				$email = $_SESSION['email'];
				
				if(mysqli_query($con, "UPDATE users SET password='$password' WHERE email='$email'"))
					{
						$error = "Lösenordet har nu ändrats. Great success!";	
					}
			}
			
		}

if(logged_in())
	{
		
		$email = $_SESSION['email'];
		
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
</div>

<div>
	<?php include 'menu/menu.php';?>
</div>

<div class="maincontent">
  
  <div class="contentleft">

  <h1>Vill du ändra ditt lösenord?</h1><hr>
  
   <p>Detta gör du enkelt genom att fylla i detta formulär. </p>
   <p>Eventuella frågor och funderingar besvaras av <a href="mailto:joakim@homeruns.se">supporten</a>. </p><hr>
  
  
 </div>
  
  
  
  <div class="rightcontainer"> <h1>Ändra lösenord</h1><hr>
  
  
  	<div id="contentright">
  
  		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
             
        <label>Nytt lösenord:</label><br>
        <input type="password" class="textfield" name="password" /><br><br>
        
        <label>Bekräfta lösenord:</label><br>
        <input type="password" class="textfield" name="passwordconfirm" /><br><br>
        
        <div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
      
        <input name="savepass" type="submit" class="submitbutton" value="Spara mitt nya lösenord" /><br>
       
        </form>
  
  

</div>
  
  </div>
  
</div>

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

<div><?php include 'footer/footer.php';?></div>

<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<!-- <script src="js/bootstrap.js" type="text/javascript"></script> -->
<script src="js/bootstrap-3.3.4.js" type="text/javascript"></script>
</body>
</html>