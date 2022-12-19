<?php
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Order</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <!-- container -->


    <div class="container mt-5 pt-5 mb-5">
        <div class="page-header">
            <h1>Create Order</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->

        <!-- PHP read one record will be here -->
        <?php

        include 'menu.php';
        include 'config/database.php';

        $useErr = $proErr = $quaErr = "";
        $flag = false;

        if ($_POST) {

            if (empty($_POST["customer_id"])) {
                $useErr = "Username is required *";
                $flag = true;
            } else {
                $customer_id = htmlspecialchars(strip_tags($_POST["customer_id"]));
            }

            $product_id = $_POST["product_id"];
            $quantity = $_POST["quantity"];

            //if detect theres duplicate item
            if (count(array_unique($product_id)) < count($product_id)) {
                $proErr = "Please reselect your products *";
                $flag = true;
            } else {
                for ($x = 0; $x < count($product_id); $x++) {
                    if (!empty($product_id[$x]) && !empty($quantity[$x])) {
                        //if flag = true wont be able to process through here
                        if ($flag == false) {

                            $total_amount = 0;

                            //set rule/conditions
                            //run loop 3 times
                            for ($x = 0; $x < 3; $x++) {

                                $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                $stmt = $con->prepare($query);
                                $stmt->bindParam(':id', $product_id[$x]);
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                //if database pro price is 0/no promo, price = row price
                                if ($row['promotion_price'] == 0) {
                                    $price = $row['price'];
                                } else {
                                    $price = $row['promotion_price'];
                                }

                                //combine prvious total_amount with new ones, loop (3 times)
                                $total_amount = $total_amount + ((float)$price * (int)$quantity[$x]);
                            }
                            echo $total_amount;

                            $order_date = date('Y-m-d');

                            $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date, total_amount=:total_amount";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':customer_id', $customer_id);
                            $stmt->bindParam(':order_date', $order_date);
                            $stmt->bindParam(':total_amount', $total_amount);

                            if ($stmt->execute()) {
                                //if success > insert id
                                //put order id put into order details table

                                $order_id = $con->lastInsertId();
                                echo "<div class='alert alert-success'>Order Successfully.</div>";

                                for ($x = 0; $x < 3; $x++) {
                                    $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                    $stmt = $con->prepare($query);
                                    //bind user choose product(id) with order details product id
                                    $stmt->bindParam(':id', $product_id[$x]);
                                    $stmt->execute();
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                    if ($row['promotion_price'] == 0) {
                                        $price = $row['price'];
                                    } else {
                                        $price = $row['promotion_price'];
                                    }
                                    $price_each = ((float)$price * (int)$quantity[$x]);

                                    //send data to 'order_details' table in myphp
                                    $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:order_id, price_each=:price_each";
                                    $stmt = $con->prepare($query);
                                    //product & quantity is array, [0,1,2]
                                    $stmt->bindParam(':product_id', $product_id[$x]);
                                    $stmt->bindParam(':quantity', $quantity[$x]);
                                    $stmt->bindParam(':order_id', $order_id);
                                    $stmt->bindParam(':price_each', $price_each);
                                    $stmt->execute();
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Failed to Order.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Order Failed.</div>";
                        }
                    }
                }
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <?php
            // select customer
            $query = "SELECT customer_id, username FROM customers ORDER BY customer_id DESC";
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
                    <span class="error"><?php echo $useErr; ?></span>
                    <select class="form-select bg-warning" name="customer_id" aria-label="form-select-lg example">
                        <option value='' selected>Choose Username</option>
                        <?php
                        //if more then 0, value="01">"username"</option>
                        if ($num > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row); ?>
                                <option value="<?php echo $customer_id; ?>"><?php echo htmlspecialchars($username, ENT_QUOTES); ?></option>
                        <?php }
                        }
                        ?>

                    </select>

                </div>
                <span class="error"><?php echo $proErr; ?></span>
                <?php
                //forloop, for 3 product
                //no need repeat to paste 3 things
                for ($x = 0; $x < 3; $x++) {
                    // select product
                    $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();
                ?>

                    <div class="row">

                        <div class="col-12">
                            <label class="order-form-label col-3">Product</label>
                            <label class="order-form-label">Quantity</label>

                        </div>
                        <div class="col-3 mb-2 mt-2">
                            <select class="form-select bg-warning" name="product_id[]" aria-label="form-select-lg example">
                                <option selected>Choose Product</option>
                                <?php
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row); ?>
                                        <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name, ENT_QUOTES); ?><?php if ($promotion_price == 0) {
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
            <input type="submit" class="btn btn-warning" />
        </form>


        <!-- end .container -->


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
</body>

</html>