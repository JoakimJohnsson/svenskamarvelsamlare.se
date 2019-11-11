<?php

include("php/connect.php");
include("php/functions.php");

$error = "";

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
 
 	<h1>Titlar</h1><hr>
    
    <p>Här hittar du information om alla serietidningar, album och pocketböcker som publicerat innehåll från <a href="publisher.php?id=5">Marvel Comics</a> i Sverige. </p>
    <p><input type="search" class="searchfield"> &nbsp;<img src="bilder/sidbilder/icons/smallicons/search.gif" width="26" height="40" alt=""/>
    (UNDER KONSTRUKTION)</p><hr>
 
   
   <?php 
   
   $query = "SELECT * FROM title";
	$result = mysqli_query($con, $query);
	$count = mysqli_num_rows($result);

   
   $rows = $count;
   
   $page_rows = 15;
   
   $last = ceil($rows/$page_rows);
   
   if($last < 1){
	$last = 1;
}

$pagenum = 1;

if(isset($_GET['pn'])){
	$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
}

if ($pagenum < 1) { 
    $pagenum = 1; 
} else if ($pagenum > $last) { 
    $pagenum = $last; 
}

$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

$sql = "SELECT * FROM title order by title_name asc, title_year asc $limit";
   
   $query = mysqli_query($con, $sql);
   
$textline2 = "Sida <b>$pagenum</b> av <b>$last</b> (Totalt <b>$rows</b> titlar i databasen)";

$paginationCtrls = '';

if($last != 1){
	/* First we check if we are on page one. If we are then we don't need a link to 
	   the previous page or the first page so we do nothing. If we aren't then we
	   generate links to the first page, and to the previous page. */
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'"> << </a>  &nbsp; ';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
			}
	    }
    }
	
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}
	
	 if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= '  <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'"> >> </a> ';
    }
}
$list = '';

while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
	$title_id = $row["title_id"];
	$title_image = $row["title_image"];
	$title_name = $row["title_name"];
	$title_year = $row["title_year"];
	
	$list .= '<p class="usrimagebkg" style="text-align: center;">
	<a href="title.php?id='.$title_id.'">
	
	<img src="bilder/title_bilder/'.$title_image.'" name="Logotyp" class="publisherimagetmb"><br>
	
	 '.$title_name.' | '.$title_year.'</a><br></p>';
}


/* close connection */
mysqli_close($con);
?>

<div>
  <p><?php echo $textline2; ?></p>
  <div class="pagination_controls"><?php echo $paginationCtrls;?></div>
  <p><?php echo $list; ?></p>
  <div class="pagination_controls"><?php echo $paginationCtrls;?></div>
</div>
   
 
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