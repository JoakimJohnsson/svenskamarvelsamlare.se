<?php

	
	$email = $_SESSION['email'];
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
			

?>



<nav class="navbar navbar-default navbar-custom">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="defaultNavbar1">
      <ul class="nav navbar-nav">
      
        <li><a href="home.php">Startsida</a></li>
        <li ><a href="#">Marvel-index</a></li>
                
        	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Min samling&nbsp;<span 
            class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
           
            <li><a href="#">Serietidningar</a></li>
            <li><a href="#">Album</a></li>
            <li><a href="#">Pockets</a></li>
            <li><a href="#">Marvelklubben</a></li>
            <li><a href="#">Böcker</a></li>
            
            <li class="divider"></li>
            <li><a href="#">Tv / Film / Video</a></li>
            <li class="divider"></li>
            <li><a href="#">Annat</a></li>
          	</ul>
        	</li>
         
        
        	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Marvel-historia&nbsp;<span 
        	class="caret"></span></a>
         	<ul class="dropdown-menu" role="menu">
            <li><a href="publisher_lista.php">Utgivare / Förlag</a></li>
            <li><a href="title_lista.php">Titlar</a></li>
            <li><a href="#">Personer</a></li>
            <li><a href="#">Marvel i Sverige</a></li>
            
            <li class="divider"></li>
            <li><a href="#">Nyckeltidningar</a></li>
          	</ul>
        	</li>       
        
    	
        
        	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Verktyg&nbsp;<span class="caret">
        	</span></a>
        	<ul class="dropdown-menu" role="menu">
            <li><a href="profil_min.php">Min profil</a></li>
            <li><a href="profil_edit.php">Ändra min profil</a></li>
             <li><a href="changepass.php">Ändra lösenord</a></li>
            <li><a href="avsluta.php">Avsluta medlemskap</a></li>
            <li class='divider'></li>
            <li><a href="profil_members.php">Medlemmar</a></li>
            <li class='divider'></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Länkar</a></li>
            
            <?php if($useradm == "1")
		{
			echo "
			
			<li class='divider'></li>
            <li><a href='adm_home.php'>Administration</a></li>
			";	
		}
 ?>
            
            <li class="divider"></li>
           
            <li ><a href="#">Kontakta oss</a></li>
            <li class="divider"></li>
            <li><a href="php/logout.php">Logga ut</a></li>
            
           	</ul>
        	</li>
	</ul>
    
     
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>
