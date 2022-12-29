<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php
    include 'menu.php';
    ?>

    <!-- container -->

    <div class="container">
        <div class="page-header">
            <h1>Update Order</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        $query = "SELECT quantity, name, price, promotion_price, id FROM order_details o
        INNER JOIN products p ON o.product_id = p.id
        WHERE order_id = ?";
        $stmt2 = $con->prepare($query);
        $stmt2->bindParam(1, $order_id);
        $stmt2->execute();
        $num2 = $stmt2->rowCount();

        $query = "SELECT s.order_id, order_detail_id, o.product_id, quantity, price_each, p.price, p.promotion_price, p.name, s.total_amount, c.firstname, c.lastname, s.order_date, c.customer_id 
        FROM order_details o 
        INNER JOIN products p 
        ON o.product_id = p.id 
        INNER JOIN order_summary s 
        ON o.order_id = s.order_id 
        INNER JOIN customer c 
        ON c.customer_id = s.customer_id 
        WHERE o.order_id = ?";

        $stmt = $con->prepare($query);
        // this is the first question mark
        $stmt->bindParam(1, $order_id);
        // execute our query
        $stmt->execute();
        $num = $stmt->rowCount();
        ?>

        <?php
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row); ?>
        <?php }
            echo "<b>Customer ID:</b> $customer_id";
            echo "<br>";
            echo "<b>Customer Name:</b> $firstname $lastname";
            echo "<br>";
            echo "<b>Order Date:</b> $order_date";
        } ?>

        <?php
        $proErr = "";
        $flag = false;

        if ($_POST) {

            $product_id = $_POST['product_id'];
            $value = array_count_values($product_id);
            $quantity = $_POST['quantity'];

            for ($x = 0; $x < count($product_id); $x++) {

                if ($value[$product_id[$x]] > 1) {
                    $proErr = "Do not choose the same product *";
                    $flag = true;
                }
            }

            if ($flag == false) {

                $total_amount = 0;

                for ($x = 0; $x < count($product_id); $x++) {
                    $query = "SELECT price, promotion_price FROM products WHERE id =:id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':id', $product_id[$x]);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $num = $stmt->rowCount();
                    $price = 0;

                    if ($num > 0) {
                        if ($row['promotion_price'] == 0) {
                            $price = $row['price'];
                        } else {
                            $price = $row['promotion_price'];
                        }
                    }
                    $total_amount = $total_amount + ((float)$price * (int)$quantity[$x]);
                }

                //send data to order_summary
                $query = "UPDATE order_summary SET order_date=:order_date, total_amount=:total_amount WHERE order_id=:order_id ";
                $stmt = $con->prepare($query);
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $order_date = date('Y-m-d H:i:s');
                $stmt->bindParam(':order_date', $order_date);
                $stmt->bindParam(':total_amount', $total_amount);
                $stmt->bindParam(':order_id', $order_id);

                if ($stmt->execute()) {

                    for ($x = 0; $x < count($product_id); $x++) {

                        $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(':id', $product_id[$x]);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $num = $stmt->rowCount();

                        if ($num > 0) {
                            if ($row['promotion_price'] == 0) {
                                $price = $row['price'];
                            } else {
                                $price = $row['promotion_price'];
                            }
                        }

                        $price_each = ((float)$price * (int)$quantity[$x]);

                        $query = "UPDATE order_details SET product_id=:product_id, quantity=:quantity, order_id=:order_id, price_each=:price_each WHERE order_id=:order_id";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(':product_id', $product_id[$x]);
                        $stmt->bindParam(':quantity', $quantity[$x]);
                        $stmt->bindParam(':order_id', $order_id);
                        $stmt->bindParam(':price_each', $price_each);
                        $stmt->execute();
                    }
                    echo "<div class='alert alert-success'>Able to save record.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to execute.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Unable to save record.</div>";
            }
        }
        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->

        <?php
        $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?order_id={$order_id}"); ?>" method="post">

            <div class="pRow">
                <?php if ($num2 > 0) {
                    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        extract($row); ?>
                        <div class="row mt-3">
                            <div class="col-8 mb-2 ">
                                <label class="order-form-label">Product</label>
                            </div>

                            <div class="col-4 mb-2">
                                <label class="order-form-label">Quantity</label>
                            </div>

                            <div class="col-8 ">
                                <select class="form-select mb-3" name="product_id[]" aria-label="form-select-lg example">
                                    <option value="<?php echo $id; ?>" selected><?php echo htmlspecialchars($name, ENT_QUOTES);
                                                                                if ($promotion_price == 0) {
                                                                                    echo " (RM$price)";
                                                                                } else {
                                                                                    echo " (RM$promotion_price)";
                                                                                } ?></option>

                                    <?php if ($num > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row); ?>
                                            <option value="<?php echo $id; ?>">
                                                <?php echo htmlspecialchars($name, ENT_QUOTES);
                                                if ($promotion_price == 0) {
                                                    echo " (RM$price)";
                                                } else {
                                                    echo " (RM$promotion_price)";
                                                } ?>

                                            </option>
                                    <?php }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4 ">
                                <input type='number' name='quantity[]' class='form-control' min=1 value='<?php echo $quantity; ?>' />
                            </div>
                        </div>
                <?php }
                }
                ?>

            </div>
            <div class="col-8">
                <input type='submit' value='Save Changes' class='btn btn-success' />
                <a href='order_read.php' class='btn btn-danger'>Back to order list</a>
            </div>
        </form>

    </div> <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- confirm delete record will be here -->

</body>

</html>