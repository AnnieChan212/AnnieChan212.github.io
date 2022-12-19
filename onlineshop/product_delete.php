<?php

// include database connection

include 'config/database.php';

try {

    // get record ID

    // isset() is a PHP function used to verify if a value is there or not

    $id = isset($_GET['id']) ? $_GET['id'] :
        die('ERROR: Record ID not found.');

    // delete query
    $query = "SELECT o.product_id, p.id FROM order_details o INNER JOIN products p ON p.id = o.product_id WHERE o.product_id = ? LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $num = $stmt->rowCount();

    //if num > 0 means it found related info in database
    if ($num > 0) {
        header('Location:product_read.php?action=failed');
    } else {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            // redirect to read records page and
            // tell the user record was deleted
            header('Location:product_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
}

// show error

catch (PDOException $exception) {

    die('ERROR: ' . $exception->getMessage());
}
