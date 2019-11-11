<?php

include("php/connect.php");
include("php/functions.php");

$error = "";

if(logged_in())
	{
	
	$email = ($_SESSION['email']);
	
	$get_user_info = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");

	$user = mysqli_fetch_array($get_user_info);
	
	$userfirstname = $user['firstname'];
	$userlastname = $user['lastname'];
	$userseca = $user['seca'];
	
	$userID = (int)$_GET['id'];
	
	$fetcher = mysqli_query($con, "SELECT * FROM users WHERE id='$userID'");
	
	while ($data = mysqli_fetch_assoc($fetcher))
		{
			$firstname = $data['firstname'];
			$lastname = $data['lastname'];
			$image = $data['image'];
			$date = $data['date'];
			$email = $data['email'];
			$email_profile = $data['email_profile'];
			$hemstad = $data['hemstad'];
			$ommig = $data['ommig'];
			$efterlysning = $data['efterlysning'];
			$id = $data['id'];
			
		}
	
			
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
</div> <!-- end header -->

<div><?php include 'menu/menu.php';?></div> <!-- meny -->

<div class="maincontent">
  <div class="normalcontent">
  


      
      
      <h1><?php echo $firstname;?> <?php echo $lastname;?> </h1><hr>
    	
      
      
      <p><img class="usrimage" src="bilder/user_bilder/<?php echo $image;?>"></p><hr>
      
     
      <p><h4>Medlemsnr: </h4><?php echo $id;?> </p>
      <p><h4>Blev medlem den: </h4> <?php echo $date;?></p>
      <p><h4>E-post: </h4><a href="mailto:<?php echo $email_profile;?>"><?php echo $email_profile;?></a></p>
      <p><h4>Hemstad: </h4> <?php echo $hemstad;?></p>
      <p><h4>Om mig: </h4> <?php echo $ommig;?></p>
      <p><h4>Jag letar efter: </h4> <?php echo $efterlysning;?></p>
      
      <p><h4>Inlägg: </h4></p>
      
      <?php $query = "SELECT * FROM blogg WHERE post_author = $id";

if ($result = mysqli_query($con, $query)) {

    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
 
    <h5><a href="post.php?id=<?php echo $row['post_id'];?>"><?php echo $row['post_headline'];?></a> | PUBLICERAD <?php echo $row['post_date'];?></h5>
    

   
		
		<?php
    }

    /* free result set */
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($con);

?>
      
      
      
      
  <br><a href="profil_members.php" class="submitbutton" style="color: #4A4631;">Tillbaka till medlemmar</a><br>
      
   
  
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