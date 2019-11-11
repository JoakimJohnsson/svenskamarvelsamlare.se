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
	
	if($useradm == "0")
	{
		header("location:home.php");
	}
						
	}
	else
	{
		header("location:index.php");
	}

$error = "";



if(isset($_POST['submit']))
{
	$occupation_name = mysqli_real_escape_string($con,$_POST['occupation_name']);
	
	
	if(strlen($occupation_name) < 2)
	{
		$error = "Fyll i ett yrke";
	}
	
	

	else
	{
		
		
		
		$insertquery = "INSERT INTO occupation(occupation_name) VALUES ('$occupation_name')";
					
					if(mysqli_query($con, $insertquery))
			{
									
					$error = "Uppladdningen lyckades";
				}
				
				else
				{
					$error = "Uppladdningen misslyckades";
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
  
  <div class="contentleft">

<h1>Källa</h1><hr>
  
   <p>Här kan du enkelt lägga in och ta bort källor från databasen.</p>
   <p>Eventuella frågor och funderingar besvaras av <a href="mailto:joakim@homeruns.se">supporten</a>. </p><br>
   
   <a href="adm_home.php" class="submitbutton" style="color: #4A4631;">ADMINISTRATION</a><br><br><hr>
   
    
   <?php $query = "SELECT * FROM occupation order by occupation_id asc";

		if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
        
    <br>		<?php echo $row['occupation_id'];?>. 
    
    			<?php echo $row['occupation_name'];?> - 
    			
                
                
             
               <a href="occupation_edit.php?id=<?php echo $row['occupation_id'];?>"><img src="bilder/sidbilder/icons/smallicons/skriv.gif" width="26" height="40" alt=""/></a>
               
               <a onclick='return confirmDelete()' href="php/delete_occupation.php?id=<?php echo $row['occupation_id'];?>"><img src="bilder/sidbilder/icons/smallicons/radera.gif" width="26" height="40" alt=""/></a>
              
               
               
		
		
		
		<?php
    }

    /* free result set */
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($con);
?>
   
  
   
   
   
   
</div>
  		
           <div class="rightcontainer"> <h1>Lägg till en källa</h1><hr>
  
  
  	<div class="icontent">
        
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                   
        <label>Yrke:</label><br>
        <input type="text" class="textfield" name="occupation_name" /><br><br>

        <div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
        
        <input name="rensa" type="reset" class="submitbutton" value="Återställ formuläret"   /><br><br>
        <input name="submit" type="submit" class="submitbutton" value="ladda upp" /><br><br>
     	</div>
        </form>
  

</div> <!-- end normalcontent -->
</div> <!-- end maincontent -->



<div><?php include 'footer/footer.php';?></div> <!-- footer -->

<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<!-- <script src="js/bootstrap.js" type="text/javascript"></script> -->
<script src="js/bootstrap-3.3.4.js" type="text/javascript"></script>
</body>
</html>