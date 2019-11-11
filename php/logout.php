<?php

session_start();
session_destroy();
setcookie("email",'',time()-7000);

header("location: ../index.php");

?>