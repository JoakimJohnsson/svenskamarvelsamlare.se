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
	$publisher_name = mysqli_real_escape_string($con,$_POST['publisher_name']);
	$publisher_description = mysqli_real_escape_string($con,$_POST['publisher_description']);
	$publisher_long_description = mysqli_real_escape_string($con,$_POST['publisher_long_description']);
	$publisher_country = mysqli_real_escape_string($con,$_POST['publisher_country']);
	
	$publisher_image = $_FILES['publisher_image']['name'];
	$tmp_publisher_image = $_FILES['publisher_image']['tmp_name'];	
	$publisher_image_size = $_FILES['publisher_image']['size'];	
	
	$publisher_add_date = date("Y-m-d ");	
	
	if(strlen($publisher_name) < 2)
	{
		$error = "Fyll i utgivarens namn";
	}
	
	else if(strlen($publisher_description) < 2)
	{
		$error = "Fyll i en beskrivning av utgivaren";
	}
	
		else if(strlen($publisher_long_description) < 2)
	{
		$error = "Fyll i en beskrivning av utgivaren";
	}
	
	else if(strlen($publisher_country) < 2)
	{
		$error = "Fyll i utgivarens land";
	}
	else if($publisher_image == "")
	{
		$error = "Ladda upp en logotyp";
	}
	else if($publisher_image_size > 409600)
	{
		$error = "Bilden får inte vara större än 400 kb!";	
	}

	else
	{
		
		$imageext = explode(".", $publisher_image);
		$imageExtension = $imageext[1];
		
		if($imageExtension == "PNG" || $imageExtension == "png" || $imageExtension == "JPG" || $imageExtension == "jpg" || $imageExtension == "GIF" || $imageExtension == "gif")
		{
		
			$publisher_image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
		
		
		$insertquery = "INSERT INTO publisher(publisher_name, publisher_description, publisher_long_description, publisher_add_date, publisher_country, publisher_image) VALUES ('$publisher_name', '$publisher_description', '$publisher_long_description', '$publisher_add_date', '$publisher_country', '$publisher_image')";
					
					if(mysqli_query($con, $insertquery))
			{
				if(move_uploaded_file($tmp_publisher_image, "bilder/publisher_bilder/$publisher_image"))
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

<h1>Utgivare / Förlag</h1><hr>
  
   <p>Här kan du enkelt lägga in och ta bort en utgivare eller förlag från databasen.</p>
   <p>Eventuella frågor och funderingar besvaras av <a href="mailto:joakim@homeruns.se">supporten</a>. </p><br>
   
   <a href="adm_home.php" class="submitbutton" style="color: #4A4631;">ADMINISTRATION</a><br><br><hr>
   
   <h3>Svenska utgivare / förlag</h3><hr>
   
    
   <?php $query = "SELECT * FROM publisher WHERE publisher_country = 'sverige' order by publisher_name asc";

		if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
        
    <br>		<br><p><a href="publisher.php?id=<?php echo $row['publisher_id'];?>"><img class="image100" src="bilder/publisher_bilder/<?php echo $row['publisher_image'];?>" name="Logotyp"></p><br>
    			<p> 
				<?php echo $row['publisher_name'];?></a> </p>
                <h5>ID: <?php echo $row['publisher_id'];?></h5>
                <h5>Inlagd: <?php echo $row['publisher_add_date'];?></h5>
                <h5>Senast uppdaterad: <?php echo $row['publisher_edit_date'];?></h5><br>
                
                <p><?php echo $row['publisher_description'];?></p>
                
                
               <p style="float:right;"> 
               <a href="publisher_edit.php?id=<?php echo $row['publisher_id'];?>"><img src="bilder/sidbilder/icons/smallicons/skriv.gif" width="26" height="40" alt=""/></a>
               
               <a onclick='return confirmDelete()' href="php/delete_publisher.php?id=<?php echo $row['publisher_id'];?>"><img src="bilder/sidbilder/icons/smallicons/radera.gif" width="26" height="40" alt=""/></a></p>
              
               
               
		<hr>
		
		<?php
    }

    /* free result set */
    mysqli_free_result($result);
}

?>

 <h3>Utländska utgivare / förlag</h3>
   
   <?php $query = "SELECT * FROM publisher WHERE publisher_country != 'sverige' order by publisher_name asc";

		if ($result = mysqli_query($con, $query)) {

    		/* fetch associative array */
    		while ($row = mysqli_fetch_assoc($result)) {
        ?>
        
    <br>		<br><p><a href="publisher.php?id=<?php echo $row['publisher_id'];?>"><img class="image100" src="bilder/publisher_bilder/<?php echo $row['publisher_image'];?>" name="Logotyp"></p><br>
    			<p> 
				<?php echo $row['publisher_name'];?></a> </p>
                <h5>Inlagd: <?php echo $row['publisher_add_date'];?></h5>
                <h5>Senast uppdaterad: <?php echo $row['publisher_edit_date'];?></h5><br>
                <p><?php echo $row['publisher_description'];?></p>
                
                <p style="float:right;"> 
                <a href="publisher_edit.php?id=<?php echo $row['publisher_id'];?>"><img src="bilder/sidbilder/icons/smallicons/skriv.gif" width="26" height="40" alt=""/></a>
                
                <a onclick='return confirmDelete()' href="php/delete_publisher.php?id=<?php echo $row['publisher_id'];?>"><img src="bilder/sidbilder/icons/smallicons/radera.gif" width="26" height="40" alt=""/></a></p>
                
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
  		
           <div class="rightcontainer"> <h1>Lägg till utgivare / förlag</h1><hr>
  
  
  	<div class="icontent">
        
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                   
        <label>Namn:</label><br>
        <input type="text" class="textfield" name="publisher_name" /><br><br>
        
        <label>Beskrivning:</label><br>
        <input type="text" class="textfield" name="publisher_description" /><br><br>
        
        <label>Lång beskrivning:</label><br>
        <textarea type="text" rows="8" class="textfield" name="publisher_long_description"></textarea><br><br>
        
        <label>Land:</label><br>
        <input type="text" class="textfield" name="publisher_country" /><br><br>
        
         <label>Bild (bredd ska vara 300px):</label><br>
        <input type="file" name="publisher_image"   /><br>
      
        
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