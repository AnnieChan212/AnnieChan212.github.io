<?php
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Product</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php

        $flag = false;

        if ($_POST) {
            // include database connection
            include 'config/database.php';
            date_default_timezone_set("Asia/Kuala_Lumpur");
            try {
                // posted values user write's
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                $expired_date = htmlspecialchars(strip_tags($_POST['expired_date']));

                if (empty($_POST['name'])) {
                    echo "<div class='alert alert-danger'>Please insert the Name.</div>";
                    $flag = true;
                } else {
                    $name = htmlspecialchars(strip_tags($_POST['name']));
                }

                if (empty($_POST['description'])) {
                    //echo "<div class='alert alert-danger'>Please insert D.</div>";
                    $description = htmlspecialchars(strip_tags($_POST['description']));
                }

                if (empty($_POST['price'])) {
                    echo "<div class='alert alert-danger'>Please insert the Price.</div>";
                    $flag = true;
                } else {
                    $price = htmlspecialchars(strip_tags($_POST['price']));
                }

                if (empty($_POST['promotion_price'])) {
                    $promotion_price = null;
                    //echo "<div class='alert alert-danger'>Please insert the Promotion Price.</div>";
                } else if (($_POST['promotion_price']) > ($_POST['price'])) {
                    echo "<div class='alert alert-danger'>Promotion price must cheaper than Original Price</div>";
                    $flag = true;
                } else {
                    $promotion_price = number_format((float)htmlspecialchars(strip_tags($_POST['promotion_price']), 2, '.', ''));
                }

                if (empty($_POST['manufacture_date'])) {
                    echo "<div class='alert alert-danger'>Please insert the Manufacture Date.</div>";
                    $flag = true;
                } else {
                    $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                }

                if (empty($_POST['expired_date'])) {
                    $expired_date = null;
                    //echo "<div class='alert alert-danger'>Please insert the Expired Date.</div>";
                } else if (($_POST['expired_date']) < ($_POST['manufacture_date'])) {
                    echo "<div class='alert alert-danger'>Expired date must late than manufacture date</div>";
                    $flag = true;
                }

                //print_r($_POST);



                if ($flag == false) {
                    // insert query
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':created', $created);
                    // Execute the query
                    if ($stmt->execute()) {
                        header("Location: http://localhost/portfolio/onlineshop/product_read.php?action=successful");
                        //echo "<div class='alert alert-danger'>Unable.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                } /* else {
                    echo "<div class='alert alert-danger'>Makesure is correct</div>";
                } */
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>


        <!-- html form here where the product information will be entered -->


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' value='<?php if (isset($_POST['name'])) {
                                                                                        echo $_POST['name'];
                                                                                    } ?>' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control' rows="4" cols="50"><?php if (isset($_POST['description'])) {
                                                                                                    echo $_POST['description'];
                                                                                                } ?></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' value='<?php if (isset($_POST['price'])) {
                                                                                        echo $_POST['price'];
                                                                                    } ?>' /></td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='text' name='promotion_price' class='form-control' value='<?php if (isset($_POST['promotion_price'])) {
                                                                                                    echo $_POST['promotion_price'];
                                                                                                } ?>' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' class='form-control' value='<?php if (isset($_POST['manufacture_date'])) {
                                                                                                    echo $_POST['manufacture_date'];
                                                                                                } ?>' /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' class='form-control' value='<?php if (isset($_POST['expired_date'])) {
                                                                                                echo $_POST['expired_date'];
                                                                                            } ?>' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>