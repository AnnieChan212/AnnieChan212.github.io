<?php

// include database connection

include 'config/database.php';

try {

    // get record ID

    // isset() is a PHP function used to verify if a value is there or not

    $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] :
        die('ERROR: Record ID not found.');


    // delete query
    $query = "SELECT o.customer_id, c.customer_id FROM order_summary o INNER JOIN customer c ON c.customer_id = o.customer_id WHERE c.customer_id = ? LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $customer_id);
    $stmt->execute();
    $num = $stmt->rowCount();

    //if num > 0 means it found related info in database
    if ($num > 0) {
        header('Location:customer_read.php?action=failed');
    } else {
        $query = "DELETE FROM customer WHERE customer_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $customer_id);
        if ($stmt->execute()) {
            // redirect to read records page and
            // tell the user record was deleted
            header('Location:customer_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
}

// show error

catch (PDOException $exception) {

    die('ERROR: ' . $exception->getMessage());
}
