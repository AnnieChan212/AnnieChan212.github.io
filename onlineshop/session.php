
<?php
// ! < meaning ! bu cun zai, dont have ! = cunzai
// session meaning like public
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: http://localhost/portfolio/onlineshop/login.php");
}
?>