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
    //include database connection
    include 'config/database.php';
    ?>
    <!-- container -->

    <div class="container">
        <div class="page-header">
            <h1>Update Order</h1>
        </div>

        <?php
        // after submit
        if ($_POST) {
            $product = $_POST["product"];
            $quantity = $_POST["quantity"];
            $order_detail_id = $_POST["order_detail_id"];

            $total_amount = 0;

            for ($x = 0; $x < count($product); $x++) {
                $query = "SELECT price, promotion_price FROM products WHERE id =:id";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':id', $product[$x]);
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
                //echo $total_amount;
            }

            //send data to order_summary
            $query = "UPDATE order_summary SET order_date=:order_date, total_amount=:total_amount WHERE order_id=:order_id";
            $stmt = $con->prepare($query);
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $order_date = date('Y-m-d H:i:s');
            $stmt->bindParam(':order_date', $order_date);
            $stmt->bindParam(':total_amount', $total_amount);
            $stmt->bindParam(':order_id', $order_id);
            if ($stmt->execute()) {

                for ($x = 0; $x < count($product); $x++) {

                    $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':id', $product[$x]);
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

                    $query = "UPDATE order_details SET product_id=:product_id, quantity=:quantity, price_each=:price_each WHERE order_detail_id=:order_detail_id";

                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':product_id', $product[$x]);
                    $stmt->bindParam(':quantity', $quantity[$x]);
                    $stmt->bindParam(':order_detail_id', $order_detail_id[$x]);
                    $stmt->bindParam(':price_each', $price_each);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Order was updated.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update order.</div>";
                    }
                }
            }
        }
        ?>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');
        $product_id_ = array();
        $quantity_ = array();
        $order_detail_id_ = array();

        // STTEP1: select id, quantity, price each from order_detail
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

        <table class="table table-bordered mt-4">

            <tbody>
                <?php
                if ($num > 0) {

                    //STEP2:Check how many row, pre submit de
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $product_id_[] = $product_id;
                        $quantity_[] = $quantity;
                        $order_detail_id_[] = $order_detail_id;
                    }
                    echo "<b>Customer ID:</b> $customer_id";
                    echo "<br>";
                    echo "<b>Customer Name:</b> $firstname $lastname";
                    echo "<br>";
                    echo "<b>Order Date:</b> $order_date";
                    //print_r($quantity_);
                } ?>

                <table class='table table-hover table-responsive table-bordered'>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?order_id={$order_id}"); ?>" method="post">

                        <?php for ($x = 0; $x < count($product_id_); $x++) {
                            // select pro_id + name
                            $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();
                        ?>
                            <div class="pRow">
                                <div class="row">
                                    <div class="col-8 mb-2 ">
                                        <label class="order-form-label">Product</label>
                                    </div>

                                    <div class="col-4 mb-2"><label class="order-form-label">Quantity</label>
                                    </div>

                                    <div class="col-8 mb-2">
                                        <select class="form-select mb-3" id="" name="product[]" aria-label="form-select-lg example">

                                            <?php if ($num > 0) {
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    extract($row); ?>
                                                    <option value="<?php echo $id; ?>" <?php if ($id == $product_id_[$x]) echo "selected"; ?>>
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


                                    <div class="col-4 mb-3">
                                        <input type='number' name='quantity[]' class='form-control' value="<?php echo $quantity_[$x] ?>" min=1 />
                                        <input type="hidden" name="order_detail_id[]" value="<?php echo $order_detail_id_[$x] ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-8">
                            <input type='submit' value='Save Changes' class='btn btn-success' />
                            <a href='order_read.php' class='btn btn-danger'>Back to order list</a>
                        </div>
                    </form>
                </table>

            </tbody>
        </table>

    </div> <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- confirm delete record will be here -->

</body>

</html>