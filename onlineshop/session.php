
<?php
// ! < meaning ! bu cun zai, dont have ! = cunzai
// session meaning like public
// check got tong xing zhen or not
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: http://localhost/portfolio/onlineshop/login.php?action=decline");
}
?>