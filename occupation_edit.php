<?php

include("php/connect.php");
include("php/functions.php");

if(logged_in())
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
	$occupation_id = $_GET['id'];
	
	$occupation_name = mysqli_real_escape_string($con,$_POST['occupation_name']);
	
	
	if(strlen($occupation_name) < 2)
	{
		$error = "Skriv ett yrke";
	}
	
		
	else
	{
		
			$updatequery = "UPDATE occupation SET occupation_name = '{$occupation_name}' WHERE occupation_id = $occupation_id";
			
				if(mysqli_query($con, $updatequery))
				{
					$id = (int)$_GET['id'];
									
					$error = "Inlägget är redigerat";
					
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
    
    <script type='text/javascript'>
function confirmDelete()
{
   return confirm("Vill du verkligen radera den här posten?");
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
  
  <div class="normalcontent">

<h1>Redigera yrket</h1><hr>

  
   <p>Här kan du enkelt redigera ett yrke.</p>
   <p>Eventuella frågor och funderingar besvaras av <a href="mailto:joakim@homeruns.se">supporten</a>. </p><br> 
   
   </p>
   
   <a href="occupation_add.php" class="submitbutton" style="color: #4A4631;">Tillbaka</a><br><br><br>
  
   
   <?php 
			
			$id = (int)$_GET['id'];
			$query = "SELECT * FROM occupation WHERE occupation_id = '$id'";

			if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
    
  		<form method="POST" action="occupation_edit.php?id=<?php echo $row['occupation_id'];?>" enctype="multipart/form-data">
        
        <div class="icontent">
             
        <p>
          
        <label>Yrke:</label><br>
        <input type="text" class="textfield" name="occupation_name" value="<?php echo $row['occupation_name'];?>"/><br><br>
        
          
                
        <input type="hidden" name="post_author" value="<?php echo $userid; ?>"/>
             
        
        <div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
        
        <input name="rensa" type="reset" class="submitbutton" value="Rensa formuläret"   /><br><br>
        <input name="submit" type="submit" class="submitbutton" value="Uppdatera" /><br><br>
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



<div><?php include 'footer/footer.php';?></div> <!-- footer -->

<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<!-- <script src="js/bootstrap.js" type="text/javascript"></script> -->
<script src="js/bootstrap-3.3.4.js" type="text/javascript"></script>
</body>
</html>