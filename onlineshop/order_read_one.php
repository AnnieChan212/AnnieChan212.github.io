<?php
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Order</h1>
        </div>


        <!-- PHP read one record will be here -->
        <?php

        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {

            // prepare select query
            $query = "SELECT order_detail_id, order_id, product_id, quantity, price_each FROM order_details WHERE order_id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);
            // this is the first question mark
            $stmt->bindParam(1, $order_id);
            // execute our query
            $stmt->execute();
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $order_detail_id = $row['order_detail_id'];
            $order_id = $row['order_id'];
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $price_each = $row['price_each'];

            // prepare select query
            $query = "SELECT total_amount FROM order_summary ORDER BY order_id DESC";
            $stmt = $con->prepare($query);
            // this is the first question mark
            $stmt->bindParam(1, $order_id);
            // execute our query
            $stmt->execute();
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $total_amount = $row['total_amount'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>


        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order Details ID</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars($order_detail_id, ENT_QUOTES);  ?></th>
                    <td><?php echo htmlspecialchars($product_id, ENT_QUOTES);  ?></td>
                    <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
                    <td><?php echo htmlspecialchars($price_each, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars($order_detail_id, ENT_QUOTES);  ?></th>
                    <td><?php echo htmlspecialchars($product_id, ENT_QUOTES);  ?></td>
                    <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
                    <td><?php echo htmlspecialchars($price_each, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars($order_detail_id, ENT_QUOTES);  ?></th>
                    <td><?php echo htmlspecialchars($product_id, ENT_QUOTES);  ?></td>
                    <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
                    <td><?php echo htmlspecialchars($price_each, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <th scope="row">Total Amount</th>
                    <td colspan="2"></td>
                    <td><?php echo htmlspecialchars($total_amount, ENT_QUOTES);  ?></td>
                </tr>
            </tbody>
        </table>



    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>