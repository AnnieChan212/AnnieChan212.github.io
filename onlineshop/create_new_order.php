<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .scrollable-menu {
            height: auto;
            max-height: 200px;
            overflow-x: hidden;
        }
    </style>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="icon" href="img/logo_yellow.png" sizes="32x32" type="image/png">

<body>
    <?php
    include 'menu.php';
    include 'config/database.php'; // include database connection
    $flag = false;
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create New Order</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->

        <?php

        if ($_POST) {
            if (empty($_POST["username"])) {
                echo "<div class='alert alert-danger'>Please select UserName.</div>";
                $flag = true;
            } else {
                $customer_id = htmlspecialchars(strip_tags($_POST['username']));
            }

            //submit user fill in de product and quantity
            $product_id = $_POST["product_id"];
            $quantity = $_POST["quantity"];


            //error if morethan 1(duplicate)
            if (count(array_unique($product_id)) < count($product_id)) {
                echo "<div class='alert alert-danger'>Product cannot be repeated.</div>";
                $flag = true;
            } else {
                for ($i = 0; $i < count($product_id); $i++) {
                    if (!empty($product_id[$i]) && !empty($quantity[$i])) {


                        if ($flag == false) {
                            $total_amount = 0;

                            // set rules/condition 给它repeat do 3times
                            for ($x = 0; $x < 3; $x++) {

                                $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                $stmt = $con->prepare($query);
                                //顾客选的product跟orderdetails table 里面的productid 绑在一起
                                $stmt->bindParam(':id', $product_id[$x]);
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                //if database的promotionprice 没有promoprice就显示price，不然show promoprice
                                if ($row["promotion_price"] == 0) {
                                    $price = $row["price"];
                                } else {
                                    $price = $row['promotion_price'];
                                }

                                //combine prvious total_amount with new ones, loop (3 times)
                                $total_amount = $total_amount + ($price * $quantity[$x]);
                            }
                            //echo $amount;
                            //send data to 'order_summary' table in myphp
                            $order_date = date('Y-m-d');
                            $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date, total_amount=:total_amount";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':customer_id', $customer_id);
                            $stmt->bindParam(':order_date', $order_date);
                            $stmt->bindParam(':total_amount', $total_amount);
                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success'>Order Successful.</div>";
                                //if success,then ba order_id put order_details table
                                $order_id = $con->lastInsertId();

                                for ($x = 0; $x < 3; $x++) {
                                    $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                    $stmt = $con->prepare($query);
                                    $stmt->bindParam(':id', $product_id[$x]);
                                    $stmt->execute();
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                    if ($row['promotion_price'] == 0) {
                                        $price = $row['price'];
                                    } else {
                                        $price = $row['promotion_price'];
                                    }
                                    $price_each = $price * $quantity[$x];

                                    //send data to 'order_details' table in myphp
                                    $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:order_id, price_each=:price_each";
                                    $stmt = $con->prepare($query);
                                    //product & quantity is array, [0,1,2]
                                    // user key and link to database's product_id
                                    $stmt->bindParam(':product_id', $product_id[$x]);
                                    $stmt->bindParam(':quantity', $quantity[$x]);
                                    $stmt->bindParam(':order_id', $order_id);
                                    $stmt->bindParam(':price_each', $price_each);
                                    $stmt->execute();
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Order Fail.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Makesure is selected</div>";
                        }
                    }
                }
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <?php
            // select customer
            $query = "SELECT customer_id, username FROM customer ORDER BY customer_id DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();
            // this is how to get number of rows returned
            $num = $stmt->rowCount();
            ?>


            <table class='table table-hover table-responsive table-bordered mb-5'>
                <div class="row">
                    <label class="order-form-label">Username</label>
                </div>

                <div class="col-6 mb-3 mt-2">
                    <select class="form-select" name="username" aria-label="form-select-lg example">
                        <option value='' selected>Customer Name</option>
                        <?php
                        //if more then 0, value="01">"username"</option>
                        if ($num > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row); ?>
                                <!--1 for database, 1 for user-->
                                <option value="<?php echo $customer_id; ?>"><?php echo htmlspecialchars($username, ENT_QUOTES); ?></option>
                        <?php }
                        }
                        ?>

                    </select>

                </div>

                <?php
                //forloop, for 3 product
                for ($x = 0; $x < 3; $x++) {
                    // select product
                    $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();
                ?>

                    <div class="row">
                        <label class="order-form-label">Product</label>

                        <div class="col-3 mb-2 mt-2">
                            <select class="form-select bg-primary" name="product_id[]" aria-label="form-select-lg example">
                                <option selected>Choose Product</option>
                                <?php
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row); ?>
                                        <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name, ENT_QUOTES);
                                                                            if ($promotion_price == 0) {
                                                                                echo " (RM$price)";
                                                                            } else {
                                                                                echo " (RM$promotion_price)";
                                                                            } ?></option>
                                <?php }
                                }
                                ?>

                            </select>
                        </div>

                        <input class="col-1 mb-2 mt-2" type="number" id="quantity[]" name="quantity[]" min=1>
                    </div>
                <?php } ?>


            </table>
            <input type="submit" class="btn btn-danger" />
        </form>

    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- confirm delete record will be here -->

</body>

</html>