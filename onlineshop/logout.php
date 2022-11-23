
<?php
session_start();

echo "Logout Successfully ";
session_destroy();   // function that Destroys Session 
header("Location: http://localhost/portfolio/onlineshop/login.php");
?>