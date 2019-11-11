<nav class="navbar navbar-default navbar-custom">
	<div class="container-fluid">
  
    <!-- Brand and toggle get grouped for better mobile display -->
	
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1">
      <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span>
      <span class="icon-bar"></span></button>
    </div>
	
    <!-- Collect the nav links, forms, and other content for toggling -->
	
		<div class="collapse navbar-collapse" id="defaultNavbar1">
			<ul class="nav navbar-nav">
				<li><a href="index.php">Startsida</a></li>
				<li><a href="index_registration.php">Bli medlem</a></li>
				<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Logga in<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					
						<li>
						<form method="POST" action="index.php" class="navbar-form navbar-left">
							E-POST:<br>
							<input type="text" class="menuinputfield" name="email" /><br><br>
							LÖSENORD:<br>
							<input type="password" class="menuinputfield" name="password" /><br><br>
							
						<input type="checkbox" name="keep"><br>Håll mig inloggad<br><br>	
						
						<input name="submit" type="submit" class="submitbutton" value="LOGGA IN" /><br><br>
						
						<a href="index_forgotpass.php">Glömt lösenord?</a><br>
						<a href="index_registration.php">Bli medlem!</a><br>
						
						</form>
						</li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
