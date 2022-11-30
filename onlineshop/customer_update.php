<?php
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <!-- HTML form to update record will be here -->
    </div>
    <!-- end .container -->

    <?php
    //include database connection
    include 'config/database.php';
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $username = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record Username not found.');

    // read current record's data
    try {
        // prepare select query
        $query = "SELECT username, password, firstname, lastname, gender, dateofbirth FROM customer WHERE username = ? LIMIT 0,1 ";
        $stmt = $con->prepare($query);

        // this is the first question mark
        $stmt->bindParam(1, $username);

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // values to fill up our form
        if ($row) {
            $username = $row['username'];
            $password = $row['password'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $dateofbirth = $row['dateofbirth'];
        }
    }

    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
    ?>

    <!-- PHP post to update record will be here -->
    <?php


    // check if form was submitted
    if ($_POST) {
        try {
            $flag = false;

            // write update query
            // in this case, it seemed like we have so many fields to pass and
            // it is better to label them and not use question marks
            $query = "UPDATE customer SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, dateofbirth=:dateofbirth WHERE username = :username";

            // prepare query for excecution
            $stmt = $con->prepare($query);

            // posted values //user key de dongxi
            $username = htmlspecialchars(strip_tags($_POST['username']));
            $password = htmlspecialchars(strip_tags($_POST['password']));
            $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
            $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
            if (isset($_POST['gender'])) $gender = ($_POST['gender']);
            $dateofbirth = htmlspecialchars(strip_tags($_POST['dateofbirth']));

            if (empty($username)) {
                echo "<div class='alert alert-danger'>Please insert the UserName.</div>";
                $flag = true;
            }

            if (!empty($_POST['password'])) {

                if (md5($_POST['old_password']) == $password) {

                    //compare oldpass with database password
                    if (md5($_POST['old_password']) == md5($_POST['password'])) {
                        echo "<div class='alert alert-danger'>New Password cannot same as Old Password.</div>";
                        $flag = true;
                    } else {
                        $password = md5($_POST['password']);
                    }

                    if (empty($_POST['confirm_new_password'])) {
                        echo "<div class='alert alert-danger'>Please confirm password.</div>";
                        $flag = true;
                    } else {
                        $confirm_new_password = ($_POST['confirm_new_password']);

                        if (($_POST['password']) != ($_POST['confirm_new_password'])) {
                            echo "<div class='alert alert-danger'>Please confirm new password.</div>";
                            $flag = true;
                        }
                    }
                } else {
                    echo "<div class='alert alert-danger'>Password not match.</div>";
                    $flag = true;
                }
            }

            if ($flag == false) {
                // bind the parameters
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':dateofbirth', $dateofbirth);
                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Makesure is correct</div>";
            }
        }
        // show errors
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
    } ?>


    <!--we have our html form here where new record information can be updated-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?username={$username}"); ?>" method="post">
        <table class='table table-hover table-responsive table-bordered container-lg py-4 mt-3'>
            <tr>
                <td>Username</td>
                <td><input type='text' name='username' minlength="6" value="<?php echo htmlspecialchars($username, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Old Password</td>
                <td><input type='password' name='password' class='form-control' /></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td><input type='password' name='new_password' class='form-control' /></td>
            </tr>
            <tr>
                <td>Confirm New Password</td>
                <td><input type='password' name='confirm_new_password' class='form-control' /></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <input type="radio" id="male" name='gender' value="M" <?php if ($gender == "M") {
                                                                                echo "checked";
                                                                            }
                                                                            ?> />
                      <label for="M">M</label>
                      <input type="radio" id="female" name='gender' value="F" <?php if ($gender == "F") {
                                                                                    echo "checked";
                                                                                }
                                                                                ?> />
                      <label for="F">F</label>

                </td>

            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><input type='date' name='dateofbirth' value="<?php echo htmlspecialchars($dateofbirth, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save Changes' class='btn btn-primary' />
                    <a href='customer_read.php' class='btn btn-danger'>Back to read customer</a>
                </td>
            </tr>
        </table>
    </form>


</body>

</html>