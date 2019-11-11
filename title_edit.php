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
	$title_id = $_GET['id'];
	
	$title_name = mysqli_real_escape_string($con,$_POST['title_name']);
	$title_format = mysqli_real_escape_string($con,$_POST['title_format']);
	$title_year = mysqli_real_escape_string($con,$_POST['title_year']);
	$title_publisher = mysqli_real_escape_string($con,$_POST['title_publisher']);
	$title_description = mysqli_real_escape_string($con,$_POST['title_description']);
	$title_long_description = mysqli_real_escape_string($con,$_POST['title_long_description']);
	
	$title_add_date = date("Y-m-d ");
	$title_edit_date = date("Y-m-d ");	
	
	$title_image = $_FILES['title_image']['name'];
	$tmp_title_image = $_FILES['title_image']['tmp_name'];	
	$title_image_size = $_FILES['title_image']['size'];	
		
	if(strlen($title_name) < 2)
	{
		$error = "Fyll i titeln";
	}
	else if(!isset($_POST['title_format']))
	{ 
        $error = "Välj ett format"; 
    } 
	if(strlen($title_year) < 2)
	{
		$error = "Fyll i årtal";
	}
	else if(!isset($_POST['title_publisher']))
	{ 
        $error = "Välj utgivare / förlag"; 
    } 
	else if(strlen($title_description) < 2)
	{
		$error = "Fyll i en kortfattad beskrivning av titeln";
	}
	else if(strlen($title_long_description) < 2)
	{
		$error = "Fyll i en beskrivning av titeln";
	}
	
	else if($title_image !== "")
	{

			$res = mysqli_query($con, "SELECT title_image FROM title WHERE title_id = '$title_id'");
			$row = mysqli_fetch_array($res);

			unlink("bilder/title_bilder/".$row['title_image']);
		
			if($title_image_size > 409600)
			{
				$error = "Bilden får inte vara större än 400 kb!";	
			}
		
				$imageext = explode(".", $title_image);
				$imageExtension = $imageext[1];
		
				if($imageExtension == "PNG" || $imageExtension == "png" || $imageExtension == "JPG" || $imageExtension == "jpg" 
				|| $imageExtension == 		"GIF" || $imageExtension == "gif")
				{
		
				$title_image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
			
					$updatequery = "UPDATE title SET title_name = '{$title_name}', title_format = '{$title_format}', title_year = '{$title_year}', title_publisher = '{$title_publisher}', title_description = '{$title_description}', title_long_description = '{$title_long_description}', title_image = '{$title_image}', title_edit_date = '{$title_edit_date}' WHERE title_id = $title_id";
			
						if(mysqli_query($con, $updatequery))
						{
						
							if(move_uploaded_file($tmp_title_image, "bilder/title_bilder/$title_image"))
								{
									$id = (int)$_GET['id'];
									
									
									$error = "Sidan är uppdaterad";
								}
							else
								{
									$error = "OBS! Endast formaten jpg, gif och png är tillåtna!";	
								}

						} // end if query
			
				} // end if image extension
				
	} // end if image
	
	
	else
	{
		
			$updatequery = "UPDATE title SET title_name = '{$title_name}', title_format = '{$title_format}', title_year = '{$title_year}', title_publisher = '{$title_publisher}', title_description = '{$title_description}', title_long_description = '{$title_long_description}', title_edit_date = '{$title_edit_date}' WHERE title_id = $title_id";
				if(mysqli_query($con, $updatequery))
				{
					$id = (int)$_GET['id'];
									
					$error = "Sidan är uppdaterad";
					
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

<h1>Redigera titel</h1><hr>

  
   <p>Här kan du enkelt redigera information om en titel från databasen.</p>
   <p>Eventuella frågor och funderingar besvaras av <a href="mailto:joakim@homeruns.se">supporten</a>. </p><br> 
   
   </p>
   
   <a href="title_add.php" class="submitbutton" style="color: #4A4631;">Tillbaka</a><br><br><br>
  
    
   <?php 
			
			$id = (int)$_GET['id'];
			$query = "SELECT * FROM title WHERE title_id = '$id'";

			if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
    
  		<form method="POST" action="title_edit.php?id=<?php echo $row['title_id'];?>" enctype="multipart/form-data">
       
        <div class="registrationcontentleft">
        
        <label>Senast uppdaterad:</label><br>
        <p><?php echo $row['title_edit_date'];?></p>
      
         <label>Namn:</label><br>
        <input type="text" class="textfield" name="title_name" value="<?php echo $row['title_name'];?>"/><br><br>
        
        <label>Format:</label><br><br>
            <input type="radio" name="title_format" value="1" checked="checked" id="title_format_0">
            Serietidning&nbsp; &nbsp; &nbsp; <br>
         
       
            <input type="radio" name="title_format" value="2" id="title_format_1">
            Album&nbsp; &nbsp; &nbsp; <br>
            
           
            <input type="radio" name="title_format" value="3" id="title_format_2">
            Pocket&nbsp; &nbsp; &nbsp; <br><br>
            
          <label>Utgivare / förlag:</label><br><br>
            <input type="radio" name="title_publisher" value="1" checked="checked" id="title_publisher_0">
            Centerförlaget&nbsp; &nbsp; &nbsp; <br>
         
       
            <input type="radio" name="title_publisher" value="2" id="title_publisher_1">
            Red CLown&nbsp; &nbsp; &nbsp; <br>
            
           
            <input type="radio" name="title_publisher" value="3" id="title_publisher_2">
            Semic Press AB&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="4" id="title_publisher_3">
            Egmont&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="5" id="title_publisher_4">
            Marvel&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="6" id="title_publisher_5">
            Atlantic Förlags AB&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="7" id="title_publisher_6">
            Satellitförlaget&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="8" id="title_publisher_7">
            Williams Förlags AB&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="9" id="title_publisher_8">
            Carlsen/if&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="10" id="title_publisher_9">
            Schibstedförlagen AB&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="11" id="title_publisher_10">
            Oscar Caesar AB&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="12" id="title_publisher_11">
            Full Stop Media AB&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="13" id="title_publisher_12">
            Saxon & Lindströms Förlag&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="14" id="title_publisher_13">
            AB Svenska Serier&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="15" id="title_publisher_14">
            Hemmets Journals Förlag&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="16" id="title_publisher_15">
            Seriefrämjandet&nbsp; &nbsp; &nbsp; <br>
            
            <input type="radio" name="title_publisher" value="17" id="title_publisher_16">
            RSR Epix AB&nbsp; &nbsp; &nbsp; <br>
          
      
        </div>
        <div class="registrationcontentright">
         <label>Årtal:</label><br>
        <input type="text" class="textfield" name="title_year" value="<?php echo $row['title_year'];?>"/><br><br>
        
        <label>Beskrivning:</label><br>
        <input type="text" class="textfield" name="title_description" value="<?php echo $row['title_description'];?>"/><br><br>
        
        <label>Lång beskrivning:</label><br>
        <textarea type="text" rows="8" class="textfield" name="title_long_description"><?php echo $row['title_long_description'];?></textarea><br><br>
        
        <label>Nuvarande bild:</label>
        <p><img class="image100" src="bilder/title_bilder/<?php echo $row["title_image"];?>"></p>
                
        <label>Ladda upp en ny bild:</label><br>
        <input type="file" name="title_image"   /><br>
      
        
        <div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
        
        <input name="rensa" type="reset" class="submitbutton" value="Återställ formuläret"   /><br><br>
        <input name="submit" type="submit" class="submitbutton" value="ladda upp" /><br>
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