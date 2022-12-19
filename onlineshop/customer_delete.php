<?php

// include database connection

include 'config/database.php';

try {

    // get record ID

    // isset() is a PHP function used to verify if a value is there or not

    $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] :
        die('ERROR: Record ID not found.');

    // delete query

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

// show error

catch (PDOException $exception) {

    die('ERROR: ' . $exception->getMessage());
}
