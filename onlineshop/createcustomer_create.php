<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Customer</h1>
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
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $dateofbirth = htmlspecialchars(strip_tags($_POST['dateofbirth']));


                if (empty($username)) {
                    echo "<div class='alert alert-danger'>Please insert the UserName.</div>";
                    $flag = true;
                }
                if (empty($password)) {
                    echo "<div class='alert alert-danger'>Please insert the Password.</div>";
                    $flag = true;
                }
                if (empty($firstname)) {
                    echo "<div class='alert alert-danger'>Please insert the First Name.</div>";
                    $flag = true;
                }
                if (empty($lastname)) {
                    echo "<div class='alert alert-danger'>Please insert the Last Name.</div>";
                    $flag = true;
                }
                if (empty($gender)) {
                    echo "<div class='alert alert-danger'>Please insert the Gender.</div>";
                    $flag = true;
                }
                if (empty($dateofbirth)) {
                    echo "<div class='alert alert-danger'>Please insert the Date of Birth.</div>";
                    $flag = true;
                }

                if ($flag == false) {
                    // insert query
                    $query = "INSERT INTO customer SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, dateofbirth=:dateofbirth, registration_date_time=:registration_date_time";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':dateofbirth', $dateofbirth);

                    // specify when this record was inserted to the database
                    $registration_date_time = date('Y-m-d H:i:s');
                    $stmt->bindParam(':registration_date_time', $registration_date_time);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        echo $password;
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
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home_create.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product_create.php">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="createcustomer_create.php">Create Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="readcustomer.php">Read Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactus_create.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="readproduct.php">Read Product</a>
                    </li>
                </ul>
            </div>
        </nav>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='text' name='password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input type="radio" id="male" name="gender" value="M">
                          <label for="M">M</label>
                          <input type="radio" id="female" name="gender" value="F">
                          <label for="f">F</label>
                    </td>

                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='dateofbirth' class='form-control' /></td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>