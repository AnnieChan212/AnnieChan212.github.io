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

    <?php
    include 'config/database.php';

    //total customer
    $query = "SELECT * FROM customer";
    $stmt = $con->prepare($query);
    $stmt->execute();
    // this is how to get number of rows returned
    $total_customer = $stmt->rowCount();

    //total products
    $query = "SELECT * FROM products";
    $stmt = $con->prepare($query);
    $stmt->execute();
    // this is how to get number of rows returned
    $total_products = $stmt->rowCount();

    //total order
    $query = "SELECT * FROM order_summary";
    $stmt = $con->prepare($query);
    $stmt->execute();
    // this is how to get number of rows returned
    $total_order = $stmt->rowCount();

    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <!-- <h1>Home</h1> -->
        </div>

        <div class="card mt-5">
            <div class="card-header bg-danger text-light">
                Announcement
            </div>
            <div class="card-body">
                <h5 class="card-title text-danger">Chinese New Year Offer</h5>
                <p class="card-text">Thank you for customer supporting, we have 3 days promotion! Keep system work smooth</p>
                <a href="order_read.php" class="btn btn-warning">Go Order List</a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h2 class="fw-bold mb-5 py-4">LITTLAZY CAMERA</h2>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Total number of Customer</h6>
                        <p class="card-text"><?php echo $total_customer ?> user has been resgister</p>
                        <a href="customer_read.php" class="btn btn-primary">Customer List</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Total number of Products</h6>
                        <p class="card-text"><?php echo $total_products ?> products has added</p>
                        <a href="product_read.php" class="btn btn-primary">Products List</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Total number of Order</h6>
                        <p class="card-text"><?php echo $total_order ?> sales!</p>
                        <a href="order_read.php" class="btn btn-primary">Order List</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card">
                    <!-- <img src="..." class="card-img-top" alt="..."> -->
                    <div class="card-body">
                        <h5 class="card-title">Higher Purchased Amount</h5>
                        <p class="card-text">
                            <?php
                            //Higher amount
                            $query = "SELECT c.username, c.firstname, c.lastname, s.total_amount
                            FROM order_summary s
                            INNER JOIN customer c 
                            ON c.customer_id = s.customer_id
                            ORDER BY total_amount DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            $username = $row['username'];
                            $firstname = $row['firstname'];
                            $lastname = $row['lastname'];
                            $total_amount = $row['total_amount'];

                            echo "Username: " . $username;
                            echo "<br>";
                            echo "Name: " . $firstname . ' ' . $lastname;
                            echo "<br>";
                            echo "Total Amount: " . "<b>RM </b>" . "<b>$total_amount </b>";
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <!--  <img src="..." class="card-img-top" alt="..."> -->
                    <div class="card-body">
                        <h5 class="card-title">Latest Order</h5>
                        <p class="card-text">
                            <?php
                            //Latest order
                            $query = "SELECT s.order_date, s.total_amount, s.customer_id, c.firstname, c.lastname 
                            FROM order_summary s
                            INNER JOIN customer c 
                            ON c.customer_id = s.customer_id
                            ORDER BY order_id DESC LIMIT 0,1";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            $firstname = $row['firstname'];
                            $lastname = $row['lastname'];
                            $order_date = $row['order_date'];
                            $total_amount = $row['total_amount'];

                            echo "Name: " . $firstname . ' ' . $lastname;
                            echo "<br>";
                            echo "Total Amount: " . "<b>RM </b>" . "<b>$total_amount </b>";
                            echo "<br>";
                            echo "Transaction Date: " . $order_date;
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <!-- <img src="..." class="card-img-top" alt="..."> -->
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Products</h5>
                        <p class="card-text">
                            <?php
                            $query = "SELECT o.product_id, SUM(o.quantity) as totalquantity ,p.name as productname FROM order_details o 
                            INNER JOIN products p 
                            ON o.product_id = p.id 
                            GROUP BY o.product_id 
                            ORDER BY totalquantity DESC LIMIT 5";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();


                            if ($num > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);

                                    echo $productname . ' ' . "<b>$totalquantity </b>" . "<br>";
                                }
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <!-- <img src="..." class="card-img-top" alt="..."> -->
                    <div class="card-body">
                        <h5 class="card-title">3 Product Never Purchased</h5>
                        <p class="card-text">
                            <?php
                            $query = "SELECT p.name, p.id FROM products p
                            LEFT JOIN order_details o 
                            ON o.product_id = p.id
                            WHERE o.product_id iS NULL LIMIT 3";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $num = $stmt->rowCount();

                            if ($num > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);

                                    echo "Product ID: " . "<b>$id</b>";
                                    echo "<br>";
                                    echo "Product Name: " . $name;
                                    echo "<br>";
                                }
                            }


                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>