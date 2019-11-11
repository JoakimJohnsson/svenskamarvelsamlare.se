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
	
	$post_id = (int)$_GET['id'];
	
	$fetcher = mysqli_query($con, "SELECT * FROM blogg inner join category on post_category = category_id inner join users on post_author = id WHERE post_id='$post_id' ");
	
	while ($data = mysqli_fetch_assoc($fetcher))
		{
			$post_headline = $data['post_headline'];
			$post_date = $data['post_date'];
			$post_image = $data['post_image'];
			$post_description = $data['post_description'];
			$post_post = $data['post_post'];
			$post_category = $data['category'];
			$post_category_url = $data['category_url'];
			$post_category_code = $data['category_code'];
			$post_author_firstname = $data['firstname'];
			$post_author_lastname = $data['lastname'];
			$post_author_id = $data['id'];
			
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
    
    <script type='text/javascript'>
function confirmDelete()
{
   return confirm("Vill du verkligen radera det här inlägget?");
}
</script>
    
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
  <div class="contentleft">
  


     
      
      <h1><?php echo $post_headline;?> 
      
      <?php
if ($post_author_id === $userid) {
  ?>
  
<a href="post_edit.php?id=<?php echo $post_id;?>"><img src="bilder/sidbilder/icons/smallicons/skriv.gif" width="26" height="40" alt=""/></a>
<a onclick='return confirmDelete()' href="php/delete_post.php?id=<?php echo $post_id;?>"><img src="bilder/sidbilder/icons/smallicons/radera.gif" width="26" height="40" alt=""/></a>
  <?php
}
?>
      
      
      
      </h1><hr>
      
      <a href=" <?php echo $post_category_url;?>"><img src="<?php echo $post_category_code;?>" width="26" height="40" alt=""/> &nbsp;<?php echo $post_category;?> </a><h5>PUBLICERAD  <?php echo $post_date;?> | av <a href="profil.php?id=<?php echo $post_author_id;?>"><?php echo $post_author_firstname;?> <?php echo $post_author_lastname;?></a></h5>
      
      <hr>
    	
          <?php
if (!empty($post_image)) {
  ?>
   <p><img class="postimage" src="bilder/post_bilder/<?php echo $post_image;?>"></p><br>
  <?php
}
?>
    
      
   <?php echo $post_post;?> 

      
  <hr><a href="home.php" class="submitbutton" style="color: #4A4631;">Tillbaka</a><hr>
      
   
  
  </div> <!-- end contentleft -->
  
  <div class="rightcontainer">
            
               <h1>Fler inlägg</h1><hr>
            
            <p><a href="post_nyheter.php"><img src="bilder/sidbilder/icons/smallicons/nyheter.gif" width="26" height="40" alt=""/> &nbsp;Nyheter</a> </p>
            <p><a href="post_boktips.php"><img src="bilder/sidbilder/icons/smallicons/boktips.gif" width="26" height="40" alt=""/> &nbsp;Boktips</a> </p>
            <p><a href="post_filmtv.php"><img src="bilder/sidbilder/icons/smallicons/filmtv.gif" width="26" height="40" alt=""/> &nbsp;Film / Tv-tips</a> </p>
            <p><a href="post_vigillar.php"><img src="bilder/sidbilder/icons/smallicons/gillar.gif" width="26" height="40" alt=""/> &nbsp;Vi gillar</a> </p>
            <p><a href="post_artiklar.php"><img src="bilder/sidbilder/icons/smallicons/artiklar.gif" width="26" height="40" alt=""/> &nbsp;Artiklar</a> </p>
            <p><a href="post_evenemang.php"><img src="bilder/sidbilder/icons/smallicons/evenemang.gif" width="26" height="40" alt=""/> &nbsp;Evenemang</a> </p>
            <p><a href="post_viktigt.php"><img src="bilder/sidbilder/icons/smallicons/viktigt.gif" width="26" height="40" alt=""/> &nbsp;Viktigt</a> </p>
            <p><a href="post_blandat.php"><img src="bilder/sidbilder/icons/smallicons/blandat.gif" width="26" height="40" alt=""/> &nbsp;Blandat</a> </p>
            <p><a href="post_debatt.php"><img src="bilder/sidbilder/icons/smallicons/debatt.gif" width="26" height="40" alt=""/> &nbsp;Debatt</a> </p>
</div>
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