<?php

include("php/connect.php");
include("php/functions.php");

if(logged_in()) // check if user är inloggad

 	{
	 	header("location:home.php");
		exit();
	}

$error = "";

if(isset($_POST['submit'])) //inloggningen

{
	
	$email = mysqli_real_escape_string($con,$_POST['email']);
	$password = mysqli_real_escape_string($con,$_POST['password']);	
	$checkbox = isset($_POST['keep']);
		
	if(email_exists($email,$con))
	{
		$result = mysqli_query($con, "SELECT password FROM users WHERE email='$email'");
		$retrievepassword = mysqli_fetch_assoc($result);
		
		if(md5($password) !== $retrievepassword['password'])
		{
			$error = "Du har angett fel e-post / lösenord!";	
		}
		else
		{
			$_SESSION['email'] = $email;
			
			if($checkbox == "on")
			{
				setcookie("email",$email, time()+7000);	
			}
			
			header("location: home.php");
		} // end if md5 password
	} // end if email exists
	else
	{
		$error = "Du har angett fel e-post / lösenord!";	
	}
} // end if isset

?>

<!doctype html>

<html>

<head>

	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 

	<link href="CSS/bootstrap-3.3.4.css" rel="stylesheet" type="text/css">
	
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" type="text/css" href="CSS/layout.css">
	<link rel="stylesheet" type="text/css" href="CSS/bootstrapedit.css">
    
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Svenska Marvelsamlare</title>

</head>

<body>

<div id="topbar">
  	<div id="topbarleft"><div id="error"><?php echo $error ?></div></div>
    <div id="topbarright"></div>
</div> <!-- end topbar -->

<div id="header">
  	<a href="index.php"><img img src="bilder/sidbilder/smslogoheader.png" class="img-responsive" alt="Svenska Marvelsamlare - Logo"></a>
</div> <!-- end header -->

<div><?php include 'menu/indexmenu.php';?></div> <!-- meny -->



<div class="container100">


  
   <object id="headbanner" data="bilder/headslidebanner/smsbanner3/smsbanner3.html"></object> 
   <object id="headbanner2" data="bilder/headslidebanner/smsbanner600/smsbanner600.html"></object> 
   <object id="headbanner3" data="bilder/headslidebanner/smsbanner300/smsbanner300.html"></object> 
  
  

</div> <!-- end container100 -->
<div class="maincontent">
  	
	<div class="contentleft">
  
		<h1>Välkommen</h1><hr>
 
		<p> Svenska Marvelsamlare är en webbplats för dig som gillar att samla på marveltidningar, filmer samlarfigurer m.m. Sidan är för närvarande under utveckling, men i framtiden kommer du kunna registrera dig, hålla koll på och administrera din samling, jämföra den med likasinnade samlare och hitta intressant information om Marvels historia i Sverige.</p>
		<p>Som sagt - webbplatsen är för tillfället under utveckling. Information och bilder ska samlas in, databaser ska skapas och funktioner och samband ska kluras ut. Fokus kommer till en början ligga på de svenska serietidningarna, för att sedan utvecklas med tiden.</p>
		<p>Känner du att du vill hjälpa till med något är det bara att höra av sig till <a href="mailto:joakim@homeruns.se">supporten</a>. Speciella förfrågningar om exempelvis insamling av scannade omslag m.m. kommer i första hand att komma i vår <a href="https://www.facebook.com/groups/1674855616070499/">facebookgrupp</a> när det blir aktuellt. </p><hr>
        
        
        <h2>Senaste nytt</h2><hr>
        
        <h4>160128</h4>
        
        <p>Nu har det hänt en hel del på insidan av hemsidan! <a href="index_registration.php">Bli medlem</a> eller logga in för att kolla vad som hänt!
        
        
        </p><hr>
			
			
  
	</div> <!-- end content left -->
  
			<div class="rightcontainer"><h1>Logga in</h1><hr>
				<div id="contentright">
					  
						<form method="POST" action="index.php">
					
						<label>E-post:</label><br>
						<input type="text" class="textfield" name="email" /><br><br>
					
						<label>Lösenord:</label><br>
						<input type="password" class="textfield" name="password" /><br><br>
						
						<input type="checkbox" name="keep">&nbsp;<label>Håll mig inloggad</label><br>
						
						<div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
					
						<input name="submit" type="submit" class="submitbutton" value="LOGGA IN" /><br><br>
						<a href="index_forgotpass.php">Glömt lösenord?</a><br>
						<a href="index_registration.php">Bli medlem!</a>
						</form>
					
					
				</div> <!-- end contentright -->
			</div> <!-- end rightcontainer -->
		  
</div> <!-- maincontent -->

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
<script src="js/bootstrap.js" type="text/javascript"></script>
</body>
</html>