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
	$post_category = mysqli_real_escape_string($con,$_POST['post_category']);
	$post_headline = mysqli_real_escape_string($con,$_POST['post_headline']);
	$post_post = mysqli_real_escape_string($con,$_POST['post_post']);
		
	$post_image = $_FILES['post_image']['name'];
	$tmp_post_image = $_FILES['post_image']['tmp_name'];	
	$post_image_size = $_FILES['post_image']['size'];	
	
	$post_date = date("Y-m-d ");	
	
	$post_author = mysqli_real_escape_string($con,$_POST['post_author']);
	
	 if(!isset($_POST['post_category']))
	{ 
        $error = "Välj en kategori"; 
    } 
	
	
	else if(strlen($post_headline) < 2)
	{
		$error = "Skriv en rubrik";
	}
	
	else if(strlen($post_post) < 2)
	{
		$error = "Skriv ett inlägg";
	}
	

	else if($post_image_size > 609600)
	{
		$error = "Bilden får inte vara större än 600 kb!";	
	}
	
	else if($post_image === "")
	{
		$insertquery = "INSERT INTO blogg(post_category, post_headline, post_post, post_date, post_author) VALUES ('$post_category', '$post_headline', '$post_post', '$post_date', '$post_author')";
		
		if(mysqli_query($con, $insertquery))
				{
													
					header("location:home.php");
					
				} //end if mysqliquery
		
	}

	else
	{
		
		$imageext = explode(".", $post_image);
		$imageExtension = $imageext[1];
		
		if($imageExtension == "PNG" || $imageExtension == "png" || $imageExtension == "JPG" || $imageExtension == "jpg" || $imageExtension == "GIF" || $imageExtension == "gif")
		{
		
			$post_image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
		
		
		$insertquery = "INSERT INTO blogg(post_category, post_headline, post_post, post_date, post_image, post_author) VALUES ('$post_category', '$post_headline', '$post_post', '$post_date', '$post_image', '$post_author')";
					
					if(mysqli_query($con, $insertquery))
			{
				if(move_uploaded_file($tmp_post_image, "bilder/post_bilder/$post_image"))
				{
					
					header("location:home.php");
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
  
  <div class="normalcontent">

<h1>Skriv ett inlägg</h1><hr>
  
   <p>Dela med dig av dina tankar och funderingar, tipsa om intressanta grejer, eller ventilera åsikter.</p>
   <p>Eventuella frågor och funderingar besvaras av <a href="mailto:joakim@homeruns.se">supporten</a>. </p><hr>
  
  
  	<div class="icontent">
        
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        
        <p>
          <label>Kategori:</label><br><br>
            <input type="radio" name="post_category" value="1" checked="checked" id="post_category_0">
            Nyheter&nbsp; &nbsp; &nbsp; 
         
         
            <input type="radio" name="post_category" value="2" id="post_category_1">
            Boktips&nbsp; &nbsp; &nbsp; 
          
        
            <input type="radio" name="post_category" value="3" id="post_category_2">
            Film / TV-tips&nbsp; &nbsp; &nbsp; 
         
         
            <input type="radio" name="post_category" value="4" id="post_category_3">
            Vi gillar&nbsp; &nbsp; &nbsp; 
        
         
            <input type="radio" name="post_category" value="5" id="post_category_4">
            Artiklar&nbsp; &nbsp; &nbsp; 
       
       
            <input type="radio" name="post_category" value="6" id="post_category_5">
            Evenemang&nbsp; &nbsp; &nbsp; 
            
          
            <input type="radio" name="post_category" value="7" id="post_category_6">
            Viktigt&nbsp; &nbsp; &nbsp; 
            
           
            <input type="radio" name="post_category" value="8" id="post_category_7">
            Blandat&nbsp; &nbsp; &nbsp; 
            
           
            <input type="radio" name="post_category" value="9" id="post_category_7">
            Debatt
        
        </p><br>
        <label>Rubrik:</label><br>
        <input type="text" class="textfield" name="post_headline" /><br><br>
        
        <label>Bild (Läggs överst i inlägget, får vara max 600kb stor):</label><br>
        <input type="file" name="post_image"   /><br>
        
        <label>Använd gärna följande htmltaggar när du skriver ditt inlägg:</label>
        
        <p>&lt;p&gt; <em>(din text)</em> &lt;/p&gt; - för styckesindelning. 
        <br>
        &lt;h2&gt; <em>(din text)</em> &lt;/h2&gt;- för extra rubrik.
        <br>
        &lt;a href="<em>(din länk)</em>"&gt;<em>(din text)</em>&lt;/a&gt; - för att lägga in en länk.
        <br>
        &lt;br&gt; - för radmatning. 
        </p> 
                
        <label>Inlägg:</label><br>
        <textarea type="text" rows="12" class="textfield" name="post_post"></textarea><br><br>
        
        
        <input type="hidden" name="post_author" value="<?php echo $userid; ?>"/>
             
        
        <div class="errorbutton" style=" <?php if($error !="") { ?> display:block; <?php   }   ?> "><?php echo $error ?></div><br>
        
        <input name="rensa" type="reset" class="submitbutton" value="Rensa formuläret"   /><br><br>
        <input name="submit" type="submit" class="submitbutton" value="Posta inlägget" /><br><br>
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