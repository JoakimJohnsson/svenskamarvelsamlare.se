<?php

include("php/connect.php");
include("php/functions.php");

if(logged_in())
 	{
	 	header("location:home.php");
		exit();
	}

$error = "";

if(isset($_POST['submit']))
{
	$firstname = mysqli_real_escape_string($con,$_POST['fname']);
	$lastname = mysqli_real_escape_string($con,$_POST['lname']);
	$email = mysqli_real_escape_string($con,$_POST['email']);
	$email_profile = mysqli_real_escape_string($con,$_POST['email_profile']);
	$hemstad = mysqli_real_escape_string($con,$_POST['hemstad']);
	$ommig = mysqli_real_escape_string($con,$_POST['ommig']);
	$efterlysning = mysqli_real_escape_string($con,$_POST['efterlysning']);
	$password = $_POST['password'];	
	$passwordconfirm = $_POST['passwordconfirm'];
	
	$seca = mysqli_real_escape_string($con,$_POST['seca']);
	
	$image = $_FILES['image']['name'];
	$tmp_image = $_FILES['image']['tmp_name'];	
	$image_size = $_FILES['image']['size'];	
	
	$adm = mysqli_real_escape_string($con,$_POST['adm']);
	
	$date = date("Y-m-d");
	
	
	if(strlen($firstname) < 2)
	{
		$error = "Förnamnet måste bestå av minst 2 tecken.";
	}
	
	else if(strlen($lastname) < 2)
	{
		$error = "Efternamnet måste bestå av minst 2 tecken.";
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$error = "Det där är inte en korrekt e-postadress!";
	}
	else if(email_exists($email, $con))
	{
		$error = "Den E-postadressen är upptagen!";
	}
	else if(strlen($password) < 7)
	{
		$error = "Ett lösenord måste vara minst 8 tecken.";
	}
	else if($password !== $passwordconfirm)
	{
		$error = "Lösenordet har inte bekräftats korrekt!";
	}
	else if(strlen($seca) < 2)
	{
		$error = "Fyll i din favorithjälte/skurk!";
	}
	else if($image == "")
	{
		$error = "Var snäll och ladda upp din profilbild!";
	}
	else if($image_size > 409600)
	{
		$error = "Profilbilden får inte vara större än 400 kb!";	
	}
	
	
	else
	{
		$password = md5($password);
		
		$imageext = explode(".", $image);
		$imageExtension = $imageext[1];
		
		if($imageExtension == "PNG" || $imageExtension == "png" || $imageExtension == "JPG" || $imageExtension == "jpg" || $imageExtension == "GIF" || $imageExtension == "gif")
		{
		
			$image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
		
			$insertquery = "INSERT INTO users(firstname, lastname, email, email_profile, hemstad, ommig, efterlysning, password, seca, image, date) VALUES ('$firstname','$lastname','$email','$email_profile','$hemstad','$ommig','$efterlysning','$password', '$seca', '$image','$date')";
			if(mysqli_query($con, $insertquery))
			{
				if(move_uploaded_file($tmp_image, "bilder/user_bilder/$image"))
				{
					$error = "Grattis! Du är nu medlem i Svenska Marvelsamlare!";
				}
				else
				{
					$error = "OBS! Din profilbild har inte blivit uppladdad!";
				}
			} //end if mysqliquery
		} //end imageextension
		
		else
		{
			$error = "OBS! Endast formaten jpg, gif och png är tillåtna!";	
		}	
	
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



<div id="topbar">
  	<div id="topbarleft"><div id="error"><?php echo $error ?></div></div>
    <div id="topbarright"></div>
</div> <!-- end topbar -->

<div id="header">
  	<a href="index.php"><img img src="bilder/sidbilder/smslogoheader.png" class="img-responsive" alt="Svenska Marvelsamlare - Logo"></a>
</div> <!-- end header -->

<div><?php include 'menu/indexmenu.php';?></div> <!-- meny -->

<div class="maincontent">
  
  <div class="normalcontent">

  <h1> Bli medlem</h1><hr>
  <p>För att kunna ta del av alla funktioner på sidan måste du registrera dig hos <strong>Svenska Marvelsamlare</strong>. Detta gör du enkelt genom att fylla i personuppgifterna i rutan här nedanför och ladda upp en profilbild. </p><hr><br>
  
  	<h1>Läs det här först</h1><hr>
		<ul>
  			<li>Uppladdning av en profilbild är obligatorisk. Ha gärna en profilbild förberedd innan du påbörjar registreringsprocessen. Lämpliga format är JPG, GIF eller PNG.</li>
  			<li>Ditt lösenord måste bestå av minst 8 tecken och är skiftlägekänsligt, d.v.s. du måste vara noga med STOR och liten bokstav o.s.v.</li>
   			<li>Inloggning sker sedan med din e-postadress och ett lösenord.</li>
    		<li>Genom att bekräfta ditt medlemskap går du också med på våra medlemsvillkor och att vi använder cookies (sparar inloggningen på din dator, så duslipper logga in på nytt). Medlemsvillkor har vi än så länge inga, men alla personuppgifter  är såklart skyddade enligt konstens alla regler och kommer aldrig användas för något annat än en smidig administration av webbplatsen. </li>
   			<li>Eventuella frågor och funderingar kan du skicka till <a href="mailto:joakim@homeruns.se">supporten</a>.</li>
   			<li>Fält märkta med * är obligatoriska.</li>
   		</ul><hr><br>
  
  	<h2>Registrera dig här</h2><hr>
  
  		
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
       
        
        <div class="registrationcontentleft">
      
        <label>* Förnamn:</label><br>
        <input type="text" class="textfield" name="fname" /><br><br>
        
        <label>* Efternamn:</label><br>
        <input type="text" class="textfield" name="lname" /><br><br>
        
        <label>* E-post (Användarnamn):</label><br>
        <input type="text" class="textfield" name="email" /><br><br>
        
        <label>E-post (Visas på profilsidan):</label><br>
        <input type="text" class="textfield" name="email_profile" placeholder="-"  /><br><br>
        
        <label>Hemstad (Visas på profilsidan):</label><br>
        <input type="text" class="textfield" name="hemstad" placeholder="-"  /><br><br>
        
        <label>Om mig (Visas på profilsidan):</label><br>
        <textarea type="text" class="textfield" name="ommig" placeholder="-"></textarea><br><br>
        
       
        </div>
        <div class="registrationcontentright">
        <label>Jag letar efter (Visas på profilsidan):</label><br>
        <textarea type="text" class="textfield" name="efterlysning" placeholder="-"></textarea><br><br>
        
        <label>* Lösenord:</label><br>
        <input type="password" class="textfield" name="password" /><br><br>
        
        <label>Bekräfta lösenord:</label><br>
        <input type="password" class="textfield" name="passwordconfirm" /><br><br>
        
        <label>* Säkerhetsfråga - Vilken är din favorithjälte/skurk i Marvels universum?</label>
        <br>
        <input type="text" class="textfield" name="seca" /><br><br>
        
        <label>* Ladda upp en profilbild:</label><br>
        <input type="file" name="image"   /><br>
        
        <input type="hidden" name="adm" value="0"/>
        
        <div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
        
        <input name="rensa" type="reset" class="submitbutton" value="Återställ formuläret"   /><br><br>
        <input name="submit" type="submit" class="submitbutton" value="bli medlem" /><br>
     	</div>
        </form>

  
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