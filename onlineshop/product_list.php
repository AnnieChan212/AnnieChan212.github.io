<?php
$action = isset($_GET['action']) ?
$_GET['action'] : "";

// if it was redirected from delete.php

if($action=='deleted'){

echo "<div class='alert
alert-success'>Record was deleted.</div>";

}
