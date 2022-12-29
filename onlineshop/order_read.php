<?php
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
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
            <h1>Order List</h1>
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

            echo "<div class='alert alert-success'>Order was deleted.</div>";
        }
        if ($action == 'successful') {

            echo "<div class='alert alert-success'>Order was created.</div>";
        }

        // select all data
        $query = "SELECT o.order_id, o.customer_id, o.order_date, o.total_amount, c.firstname, c.lastname FROM order_summary o INNER JOIN customer c ON c.customer_id = o.customer_id ORDER BY order_id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='create_new_order.php' class='btn btn-primary m-b-1em mb-3'>Create New Order</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Customer ID</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Order Date</th>";
            echo "<th>Total Amount</th>";
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
                echo "<td>{$order_id}</td>";
                echo "<td>{$customer_id}</td>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$order_date}</td>";
                //echo "<td>{$total_amount}</td>";
                echo "<td class= \"text-end\" > RM " . number_format((float)$total_amount, 2, '.', '') . "</td>";
                echo "<td>";
                // read one record
                echo "<a href='order_read_one.php?order_id={$order_id}' class='btn btn-info m-r-1em mx-2'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='order_update.php?order_id={$order_id}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$order_id});'  class='btn btn-danger mx-2'>Delete</a>";
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

        function delete_user(order_id) {

            var answer = confirm('Are you sure?');

            if (answer) {

                // if user clicked ok,

                // pass the id to delete.php and execute the delete query
                window.location =
                    'order_delete.php?order_id=' + order_id;

            }

        }
    </script>

</body>

</html>