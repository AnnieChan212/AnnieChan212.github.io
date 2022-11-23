
<?php
session_start();

session_destroy();   // function that Destroys Session 
header("Location: http://localhost/portfolio/onlineshop/login.php");
?>