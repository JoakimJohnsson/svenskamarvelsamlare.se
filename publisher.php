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
	
	$publisher_id = (int)$_GET['id'];
	$fetcher = mysqli_query($con, "SELECT * FROM publisher WHERE publisher_id='$publisher_id'");
	
	while ($data = mysqli_fetch_assoc($fetcher))
		{		
			
			$publisher_name = $data['publisher_name'];
			$publisher_description = $data['publisher_description'];
			$publisher_long_description = $data['publisher_long_description'];
			$publisher_country = $data['publisher_country'];
			$publisher_image = $data['publisher_image'];
			$publisher_edit_date = $data['publisher_edit_date'];
			
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
  <div class="contentleft">
  

<p><img class="image100 rounded" src="bilder/publisher_bilder/<?php echo $publisher_image;?>" name="Logotyp"></p><hr>
      
      
      <h1><?php echo $publisher_name;?></h1><h4><?php echo $publisher_country;?></h4> <hr>
      
      <h5>Senast uppdaterad: <?php echo $publisher_edit_date;?></h5><hr>
      
    	
    
      
   
    
     <p><?php echo $publisher_long_description;?> </p>
     
     
     <h2>Utgivna titlar med marvelrelaterat innehåll</h2><hr>
     
     <h3>Serietidningar</h3><hr>
     
     <?php $query = "SELECT * FROM title WHERE title_publisher = $publisher_id AND title_format = '1' order by title_name asc";

		if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
        
           
        <p class="usrimagebkg" style="text-align: center;"><a href="title.php?id=<?php echo $row['title_id'];?>"> 
		<img src="bilder/title_bilder/<?php echo $row['title_image'];?>" name="Logotyp" class="publisherimagetmb"> <br>
		<?php echo $row['title_name'];?></a></p>
 
                
		
		<?php
    }

    /* free result set */
    mysqli_free_result($result);
}

?>

      
  <br><br><a href="publisher_lista.php" class="submitbutton" style="color: #4A4631;">Utgivare / Förlag</a><br><br>
      
   </div> <!-- end content left -->
    
    
  
			<div class="rightcontainer"><div class="icontent">
            
            <h2>Svenska utgivare / förlag</h2><hr>
            
			<?php $query = "SELECT * FROM publisher WHERE publisher_country = 'sverige' order by publisher_name asc";

		if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
        
        <p><a href="publisher.php?id=<?php echo $row['publisher_id'];?>"> 
		
		<?php echo $row['publisher_name'];?></a></p>
 
                
		
		<?php
    }

    /* free result set */
    mysqli_free_result($result);
}

?>

 <h2>Utländska utgivare / förlag</h2><hr>
   
   <?php $query = "SELECT * FROM publisher WHERE publisher_country != 'sverige' order by publisher_name asc";

		if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
        
     <p><a href="publisher.php?id=<?php echo $row['publisher_id'];?>"> 
		
		<?php echo $row['publisher_name'];?></a></p>
           
		
		<?php
    }

    /* free result set */
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($con);
?>
            
            
              </div> <!-- end icontent -->
  
  </div> <!-- end rightcontainer -->
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