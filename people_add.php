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
	$people_firstname= mysqli_real_escape_string($con,$_POST['people_firstname']);
	$people_lastname= mysqli_real_escape_string($con,$_POST['people_lastname']);
	
	$people_description = mysqli_real_escape_string($con,$_POST['people_description']);
	
	$people_image = $_FILES['people_image']['name'];
	$tmp_people_image = $_FILES['people_image']['tmp_name'];	
	$people_image_size = $_FILES['people_image']['size'];	
	
	$people_add_date = date("Y-m-d ");	
	
	if(strlen($people_firstname) < 2)
	{
		$error = "Fyll i förnamn";
	}
	else if(strlen($people_lastname) < 2)
	{
		$error = "Fyll i efternamn";
	}
	
	
	else if(strlen($people_description) < 2)
	{
		$error = "Fyll i information";
	}
	
	
	else if($people_image == "")
	{
		$error = "Ladda upp ett porträtt";
	}
	else if($title_image_size > 409600)
	{
		$error = "Bilden får inte vara större än 400 kb!";	
	}

	else
	{
		
		$imageext = explode(".", $people_image);
		$imageExtension = $imageext[1];
		
		if($imageExtension == "PNG" || $imageExtension == "png" || $imageExtension == "JPG" || $imageExtension == "jpg" || $imageExtension == "GIF" || $imageExtension == "gif")
		{
		
			$people_image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
		
		
		$insertquery = "INSERT INTO people(people_firstname, people_lastname, people_description, people_add_date, people_image) VALUES ('$people_firstname', '$people_lastname','$people_description', '$people_add_date', '$people_image')";
					
					if(mysqli_query($con, $insertquery))
			{
				if(move_uploaded_file($tmp_people_image, "bilder/people_bilder/$people_image"))
				{
					
					$error = "Uppladdningen lyckades";
				}
				
				else
				{
					$error = "Uppladdningen misslyckades";
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
    
    <script type='text/javascript'>
function confirmDelete()
{
   return confirm("Vill du verkligen radera den här personen?");
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

<h1>Kreatörer</h1><hr>
  
   <p>Här kan du enkelt redigera, lägga in och ta bort kreatörer från databasen.</p>
   <p>Eventuella frågor och funderingar besvaras av <a href="mailto:joakim@homeruns.se">supporten</a>. </p><br>
   
   <a href="adm_home.php" class="submitbutton" style="color: #4A4631;">ADMINISTRATION</a><br><br><hr>
   
    
   <?php $query = "SELECT * FROM people 

   
   order by people_lastname asc";

		if ($result = mysqli_query($con, $query)) {
			
		

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
				
        ?>
        
    <br>		<br><p><a href="people.php?id=<?php echo $row['people_id'];?>"><img class="usrimage" src="bilder/people_bilder/<?php echo $row['people_image'];?>" name="Porträtt"></p><br>
    			<p> 
				<?php echo $row['people_firstname'];?> <?php echo $row['people_lastname'];?></a> </p>
                <h5>Yrke:</h5>
                <h5>ID: <?php echo $row['people_id'];?></h5>
                <h5>Inlagd: <?php echo $row['people_add_date'];?></h5>
                <h5>Senast uppdaterad: <?php echo $row['people_edit_date'];?></h5><br>
                
                
                
                
               <p style="float:right;"> 
               <a href="people_edit.php?id=<?php echo $row['people_id'];?>"><img src="bilder/sidbilder/icons/smallicons/skriv.gif" width="26" height="40" alt=""/></a>
               
               <a onclick='return confirmDelete()' href="php/delete_people.php?id=<?php echo $row['people_id'];?>"><img src="bilder/sidbilder/icons/smallicons/radera.gif" width="26" height="40" alt=""/></a></p>
              
               
               
		<hr>
		
		<?php
    }

    /* free result set */
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($con);
?>
   
   <br>
   
   
   
   
</div>
  		
           <div class="rightcontainer"> <h1>Lägg till kreatörer</h1><hr>
  
  
  	<div class="icontent">
        
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                   
        <label>Förnamn:</label><br>
        <input type="text" class="textfield" name="people_firstname" /><br><br>
        <label>Efternamn:</label><br>
        <input type="text" class="textfield" name="people_lastname" /><br><br>
        
        
        <label>Beskrivning:</label><br>
        <textarea type="text" rows="8" class="textfield" name="people_description"></textarea><br><br>
        
     
                
        <label>Bild (bredd ska vara 300px):</label><br>
        <input type="file" name="people_image"   /><br>
      
        
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