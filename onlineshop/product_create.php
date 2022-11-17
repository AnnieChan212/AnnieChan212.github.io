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
            try {
                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                $expired_date = htmlspecialchars(strip_tags($_POST['expired_date']));

                if (empty($name)) {
                    echo "<div class='alert alert-danger'>Please insert the Name.</div>";
                    $flag = true;
                }
                if (empty($description)) {
                    //echo "<div class='alert alert-danger'>Please insert the Description.</div>";
                    $flag = true;
                }
                if (empty($price)) {
                    echo "<div class='alert alert-danger'>Please insert the Price.</div>";
                    $flag = true;
                }
                if (empty($promotion_price)) {
                    //echo "<div class='alert alert-danger'>Please insert the Promotion Price.</div>";
                    $flag = true;
                }
                if (empty($manufacture_date)) {
                    //echo "<div class='alert alert-danger'>Please insert the Manufacture Date.</div>";
                    $flag = true;
                }
                if (empty($expired_date)) {
                    echo "<div class='alert alert-danger'>Please insert the Expired Date.</div>";
                    $flag = true;
                }

                if (($promotion_price) > ($price)) {
                    echo "<div class='alert alert-danger'>Promotion price must cheaper than Original Price</div>";
                    $flag = true;
                }

                if (($expired_date) < ($manufacture_date)) {
                    echo "<div class='alert alert-danger'>Expired date must late than manufacture date</div>";
                    $flag = true;
                }

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
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Makesure is correct</div>";
                }
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
                    <td><input type='text' name='name' class='form-control' value='<?php if (isset($_POST['name'])) echo $_POST['name']; ?>' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control' rows="4" cols="50"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' value='<?php if (isset($_POST['price'])) echo $_POST['price']; ?>' /></td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='text' name='promotion_price' class='form-control' value='<?php if (isset($_POST['promotion_price'])) echo $_POST['promotion_price']; ?>' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' class='form-control' value='<?php if (isset($_POST['manufacture_date'])) echo $_POST['manufacture_date']; ?>' /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' class='form-control' value='<?php if (isset($_POST['expired_date'])) echo $_POST['expired_date']; ?>' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='readproduct.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>