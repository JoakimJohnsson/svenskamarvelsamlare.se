<?php

include("php/connect.php");
include("php/functions.php");

$error = "";

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
		header("location:index.php"); // om user inte är inloggad - skickas till index.php
	}

?>

<!doctype html>

<html>

<head>

	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 

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
  
		    
    <h1>Bulletinen</h1>
    
    <hr>
				
					<p>Nyheter, artiklar, filmtips och annat som gör livet värt att leva. Dela gärna med dig av dina tankar och funderingar.</p><br>
                    
                    <a href="post_add.php" class="submitbutton" style="color: #4A4631;">Skriv ett inlägg</a><br>
                    
                    <hr>
                                            
                     
                     <?php $query = "SELECT * FROM blogg inner join category on post_category = category_id inner join users on post_author = id order by post_date desc LIMIT 0, 8";

if ($result = mysqli_query($con, $query)) {

    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) { 
        ?>
          
    <a href="<?php echo $row['category_url'];?>"><img src="<?php echo $row['category_code'];?>" width="26" height="40" alt=""/> &nbsp;<?php echo $row['category'];?></a> 
    
    <h2><?php echo $row['post_headline'];?> </a></h2>
    
    
    
    
    <h5>PUBLICERAD <?php echo $row['post_date'];?> | av <a href="profil.php?id=<?php echo $row['id'];?>"><?php echo $row['firstname'];?> <?php echo $row['lastname'];?></a></h5>
    
    <div class="post">
    
    <?php
if (!empty($row['post_image'])) {
  ?>
  <div class="homepostimg"><img src="bilder/post_bilder/<?php echo $row['post_image'];?>" name="" class="postimagetmb"></div>
  <?php
}
?>
</div>
    
   <div class="homeposttext"> <?php echo substr($row['post_post'], 0,300);?>...<br><br>
    
    <a href="post.php?id=<?php echo $row['post_id'];?>" class="submitbutton" style="color: #4A4631;">LÄS MER</a>&nbsp;&nbsp;
    
   
    
    
    
      <?php
if ($row['post_author'] === $userid) {
  ?>
  
<a href="post_edit.php?id=<?php echo $row['post_id'];?>"><img src="bilder/sidbilder/icons/smallicons/skriv.gif" width="26" height="40" alt=""/></a>
<a onclick='return confirmDelete()' href="php/delete_post.php?id=<?php echo $row['post_id'];?>"><img src="bilder/sidbilder/icons/smallicons/radera.gif" width="26" height="40" alt=""/></a>
  <?php
}
?>
    
    </div>
    
    
    
   
    
    <hr>
		
		<?php
    }

    /* free result set */
    mysqli_free_result($result);
}


?>
                     
                     
                     
                     
                     
                     
                     
                     
             

      
      </div><!-- end contentleft -->
  
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
            <p><a href="post_debatt.php"><img src="bilder/sidbilder/icons/smallicons/debatt.gif" width="26" height="40" alt=""/> &nbsp;Debatt</a> </p><hr>

            
            
            <h1>Statistik</h1><hr><div class="icontent">
				
					  <h4>ANTAL MEDLEMMAR:</h4>
                                            
                       	<?php 
					   
					   	$query = "SELECT * FROM users";
						$result = mysqli_query($con, $query);
						$count = mysqli_num_rows($result);
						
						?>
								
							<p><a href="profil_members.php"><?php echo $count;?></a></p>
      
                      <h4>NYASTE MEDLEMMAR:</h4>
                      
                      	<?php 
						
						$query = "SELECT * FROM users order by id desc LIMIT 0, 5";

						if ($result = mysqli_query($con, $query)) {
						
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								
							<p><a href="profil.php?id=<?php echo $row['id'];?>"> 
								 
						<?php echo $row['firstname'];?> 
						<?php echo $row['lastname'];?> |
                        <?php echo $row['date'];?>
                        </a></p>
								
						<?php
							}
						
							/* free result set */
							mysqli_free_result($result);
						}
						
						
						?>
                        
                         <p><a href="profil_members.php" class="submitbutton" style="color: #4A4631;">SE ALLA</a></p>
                        
                        <hr>
                        
                          <h4>ANTAL TITLAR:</h4>
                        
                       <?php 
					   
					   	$query = "SELECT * FROM title";
						$result = mysqli_query($con, $query);
						$count = mysqli_num_rows($result);
						
						
						
						?>
								
							<p><a href="title_lista.php"><?php echo $count;?></a></p>
                            
                            
                        
                        <h4>SENAST INLAGDA TITLAR:</h4>
                        
                          <?php 
						
						$query = "SELECT * FROM title order by title_id desc LIMIT 0, 5";

						if ($result = mysqli_query($con, $query)) {
						
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
						?>
                        
                        	<p><a href="title.php?id=<?php echo $row['title_id'];?>"> 
								 
						<?php echo $row['title_name'];?> |
                        
                        <?php echo $row['title_add_date'];?>
                        </a></p>
								
						<?php
							}
						
							/* free result set */
							mysqli_free_result($result);
							
							
							
						}?>
                        
                         <p><a href="title_lista.php" class="submitbutton" style="color: #4A4631;">SE ALLA</a></p>
                          
                          <hr>
                        
                          <h4>STÖRST SAMLING:</h4>
                        
                       <p>-</p>
                        
                        <h4>MEST VÄRDEFULLA SAMLING:</h4>
                        
                          <p>-</p>
                        
                        
</div>
		<br>
        <h1>Administratörer</h1><hr><div class="icontent">
        
         <?php 
						
						$query = "SELECT * FROM users WHERE adm = 1";

						if ($result = mysqli_query($con, $query)) {
						
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
						?>
                        
                        <p><a href="profil.php?id=<?php echo $row['id'];?>"> 
								 
						<?php echo $row['firstname'];?> 
						<?php echo $row['lastname'];?>
                                               </a></p>
                        
                        <?php
							}
						
							/* free result set */
							mysqli_free_result($result);
							
							/* close connection */
						mysqli_close($con);
							
						}?>
                        
                        
        
        </div>
        			
				
			</div> <!-- end homerightcontainer -->
		  
</div> <!-- maincontent -->

<div class="container100">

<?php 

$ctaarticle = array('calltoact/calltoact1.php' , 'calltoact/calltoact2.php');

$ctaarrayNo = rand(0,1);

$ctaarticle = $ctaarticle[$ctaarrayNo];

$ctaarticle = include($ctaarticle);

?>

</div> <!-- cta container100-->

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