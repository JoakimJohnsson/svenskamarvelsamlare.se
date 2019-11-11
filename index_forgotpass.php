<?php

include("php/connect.php");
include("php/functions.php");

if(logged_in())
 	{
	 	header("location:home.php");
		exit();
	}

$error = "";

if(isset($_POST['submit'])) // skickar mail till mig om att user har glömt lösenordet
{
	$email = mysqli_real_escape_string($con,$_POST['email']);
	$seca = mysqli_real_escape_string($con,$_POST['seca']);
	
					
		if(email_seca_exists($seca, $email, $con)) // check om säkerhetsfrågan och e-mail är korrekt
		{
			
			require_once "Mail.php";

			$to = "joakim@homeruns.se";
			$subject = "Återställning av lösenord";
			$body = "Vänligen återställ mitt lösenord! Den e-post jag angav vid registreringen är - $email, och svaret på säkerhetsfrågan är - $seca.";
			
			$host = "mail.talkactive.net";
			$port = 587;
			$username = 'joakim@homeruns.se';
			$password = 'Vinter201501';
			
			$headers = array (
				'From' => $username, 
				'To' => $to, 
				'Subject' => $subject,
				'text_charset'  => 'UTF-8',
  				'html_charset'  => 'UTF-8',
  				'head_charset'  => 'UTF-8',
  				'Content-Type'  => 'text/html; charset=UTF-8'
				);
				
			$smtp = Mail::factory('smtp',
			array (
			'host' => $host,
			'port'=>$port,
			'auth' => true,
			'username' => $username,
			'password' => $password,
		
			)
			);
			
			$mail = $smtp->send($to, $headers, $body);
			
			if (PEAR::isError($mail)) {
			echo("" . $mail->getMessage() . "".PHP_EOL);
			} 
			
			$error = "Tack! Supporten kommer kontakta dig inom kort!";
		} // end if seca email exists
		else
		{
		$error = "Du har angett fel e-postadress eller svar på säkerhetsfrågan.";
		}
	
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



<div id="topbar"> 
	<div id="topbarleft"></div>
	<div id="topbarright"></div>
</div> <!-- end topbar -->

<div id="header"> 
  	<a href="index.php"><img img src="bilder/sidbilder/smslogoheader.png" class="img-responsive" alt="Svenska Marvelsamlare - Logo"></a>
</div> <!-- end header -->

<div><?php include 'menu/indexmenu.php';?></div> <!-- meny -->

<div class="maincontent">
  
	<div class="contentleft">

		<h1> Har du glömt ditt lösenord?</h1><hr>
		<p>Inga problem! För att återskapa ditt lösenord måste du fylla den e-postadress du angav vid registreringen samt svaret på vår säkerhetsfråga. När vi fått in dina uppgifter skickar vi ett temporärt lösenord som du kan använda för att logga in. Du kan sen byta lösenord som vanligt.</p>
		<p>Lycka till!</p><hr>
		
 </div> <!-- end contentleft -->
		<div class="rightcontainer"><h1>Återskapa lösenordet</h1><hr>
				<div id="contentright" class="rounded">

				<form method="POST" action="index_forgotpass.php" enctype="multipart/form-data" charset="UTF-8">
				
				<label>E-post:</label><br>
				<input type="text" class="textfield" name="email" /><br><br>
				
				<label>Säkerhetsfråga - Vilken är din din favorithjälte/skurk i Marvels universum?</label><br>
				<input type="text" class="textfield" name="seca" /><br><br>
				
				<div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
				
				<input name="submit" type="submit" class="submitbutton" value="SKICKA" /><br>
			   
				</form>
  
			</div> <!-- end registrationcontentleft -->
			
		</div> <!-- end container100 -->
  
	
	
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
