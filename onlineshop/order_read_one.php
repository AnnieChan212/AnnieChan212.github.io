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
            <h1>Order Details</h1>
        </div>


        <!-- PHP read one record will be here -->
        <?php

        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        // prepare select query
        try {


            $query = "SELECT s.order_id,order_detail_id,o.product_id,quantity,price_each,p.price,p.promotion_price,p.name,s.total_amount
            FROM order_details o 
            INNER JOIN products p 
            ON o.product_id = p.id
            INNER JOIN order_summary s
            ON o.order_id = s.order_id
            WHERE o.order_id = ?";
            $stmt = $con->prepare($query);
            // this is the first question mark
            $stmt->bindParam(1, $order_id);
            // execute our query
            $stmt->execute();
            $num = $stmt->rowCount();


            /* // prepare select query
        $query = "SELECT total_amount FROM order_summary ORDER BY order_id DESC";
        $stmt = $con->prepare($query);
        // this is the first question mark
        $stmt->bindParam(1, $order_id);
        // execute our query
        $stmt->execute();
        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // values to fill up our form
        */
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
                    <th scope="col">Product ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($num > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row); ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product_id, ENT_QUOTES);  ?></th>
                            <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></th>
                            <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
                            <td><?php echo number_format((float)htmlspecialchars($price, ENT_QUOTES), 2, '.', ''); ?></td>
                            <td><?php echo number_format((float)htmlspecialchars($price_each, ENT_QUOTES), 2, '.', ''); ?></td>

                        </tr>
                <?php }
                } ?>
                <tr>
                    <th scope="row">Total Amount</th>
                    <td colspan="3"></td>
                    <td><?php echo "<b>" . htmlspecialchars($total_amount, ENT_QUOTES) . "</b>"; ?></td>
                </tr>
            </tbody>
        </table>
        <div>
            <tr>
                <td></td>
                <td>
                    <a href='order_read.php' class='btn btn-danger'>Back to read Order</a>
                </td>
            </tr>
        </div>



    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>