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
    include 'session.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Customer</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php

        $flag = false;

        if (isset($_GET["action"])) {
            if ($_GET["action"] == "success") {
                echo "<div class='alert alert-success'>Record was saved.</div>";
            }
        }

        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $confirm_password = htmlspecialchars(strip_tags($_POST['confirm_password']));
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                if (isset($_POST['gender'])) $gender = ($_POST['gender']);
                $dateofbirth = htmlspecialchars(strip_tags($_POST['dateofbirth']));


                if (empty($username)) {
                    echo "<div class='alert alert-danger'>Please insert the UserName.</div>";
                    $flag = true;
                }
                if (empty($password)) {
                    echo "<div class='alert alert-danger'>Please insert the Password.</div>";
                    $flag = true;
                } else {
                    $password = md5('password');
                }

                if (empty($confirm_password)) {
                    //echo "<div class='alert alert-danger'>Please insert the Confirm Password.</div>";
                    $flag = true;
                    //compare password match or not
                } else if ($_POST['password'] == $_POST['confirm_password']) {
                    $password = md5('password');
                } else {
                    echo "<div class='alert alert-danger'>Password not match.</div>";
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
                } else {
                    $date2 = date('Y-m-d');
                    $diff = (strtotime($date2) - strtotime($dateofbirth));
                    $year = floor($diff / (365 * 60 * 60 * 24));
                    //echo $diff;
                    //abs(strtotime($date2)) meaning between positive num or negative num zui hou dou hui bian positive

                    if ($year < 18) {
                        echo "<div class='alert alert-danger'>Age should above 18.</div>";
                        $flag = true;
                    }
                }

                //echo $dateofbirth;

                // insert query
                $query = "SELECT username FROM customer WHERE username=:username";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // bind the parameters
                $stmt->bindParam(':username', $username);
                // Execute the query
                $stmt->execute();
                $num = $stmt->rowCount();

                //if num 1 found username from database
                if ($num > 0) {
                    echo "<div class='alert alert-danger'>Username have been taken.</div>";
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
                        header("Location: http://localhost/portfolio/onlineshop/customer_create.php?action=success");
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        //echo $password;
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
                    <td>Username</td>
                    <td><input type='text' name='username' minlength="6" class='form-control' value='<?php if (isset($_POST['username'])) echo $_POST['username']; ?>' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' value='<?php if (isset($_POST['password'])) echo $_POST['password']; ?>' /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirm_password' class='form-control' value='<?php if (isset($_POST['confirm_password'])) echo $_POST['confirm_password']; ?>' /></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' class='form-control' value='<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' class='form-control' value='<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input type="radio" id="male" name='gender' value="M" <?php if (isset($_POST['gender'])) {
                                                                                    if ($_POST['gender'] == "M")
                                                                                        echo "checked";
                                                                                }
                                                                                ?> />
                          <label for="M">M</label>
                          <input type="radio" id="female" name='gender' value="F" <?php if (isset($_POST['gender'])) {
                                                                                        if ($_POST['gender'] == "F")
                                                                                            echo "checked";
                                                                                    } ?> />
                          <label for="F">F</label>

                    </td>

                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='dateofbirth' class='form-control' value='<?php if (isset($_POST['dateofbirth'])) echo $_POST['dateofbirth']; ?>' /></td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customer</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>