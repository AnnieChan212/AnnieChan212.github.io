<?php
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Customer List</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Customer List</h1>
        </div>


        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ?
            $_GET['action'] : "";

        // if it was redirected from delete.php

        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Customer was deleted.</div>";
        }
        if ($action == 'failed') {
            echo "<div class='alert alert-danger'>Record cannot delete due User have Order.</div>";
        }
        if ($action == 'successful') {
            echo "<div class='alert alert-success'>Customer create successful.</div>";
        }

        // select all data
        $query = "SELECT customer_id, username, firstname, lastname, gender, dateofbirth FROM customer ORDER BY customer_id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='customer_create.php' class='btn btn-primary m-b-1em mb-3'>Create New Customer</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>Customer ID</th>";
            echo "<th>Username</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Gender</th>";
            echo "<th>Date of Birth</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$customer_id}</td>";
                echo "<td>{$username}</td>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$gender}</td>";
                echo "<td>{$dateofbirth}</td>";
                echo "<td>";
                // read one record
                echo "<a href='customer_read_one.php?customer_id={$customer_id}' class='btn btn-info m-r-1em mx-2'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='customer_update.php?customer_id={$customer_id}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$customer_id});'  class='btn btn-danger mx-2'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }



            // end table
            echo "</table>";
        }
        // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>



    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- confirm delete record will be here -->
    <script type='text/javascript'>
        // confirm record deletion

        function delete_user(customer_id) {

            var answer = confirm('Are you sure?');

            if (answer) {

                // if user clicked ok,

                // pass the id to delete.php and execute the delete query
                window.location =
                    'customer_delete.php?customer_id=' + customer_id;

            }

        }
    </script>

</body>

</html>