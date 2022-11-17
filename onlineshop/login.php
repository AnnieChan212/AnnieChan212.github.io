<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="name"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<!-- Custom styles for this template -->
<link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <?php
    //set var Error message
    $useErr =  $pasErr = $statusErr = "";

    if ($_POST) {

        include 'config/database.php';

        //find username
        $username = htmlspecialchars(strip_tags($_POST['username']));

        // insert query
        $query = "SELECT * FROM customer WHERE username=:username";
        // prepare query for execution
        $stmt = $con->prepare($query);
        // bind the parameters
        $stmt->bindParam(':username', $username);
        // Execute the query
        $stmt->execute();
        $num = $stmt->rowCount();

        //if num 1 found username from database
        if ($num > 0) {


            //find password
            $password = md5('password');

            // insert query //password and username must be match only can login
            $query = "SELECT * FROM customer WHERE password=:password and username=:username";
            // prepare query for execution
            $stmt = $con->prepare($query);
            // bind the parameters
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':username', $username);
            // Execute the query
            $stmt->execute();
            $num = $stmt->rowCount();

            //if num 1 found password from database & direct to homepage
            if ($num > 0) {

                // account ban
                $account_status = 'Active';

                $result = "SELECT * FROM customer WHERE username=:username and account_status=:account_status ";

                $stmt = $con->prepare($result);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':account_status', $account_status);
                $stmt->execute();
                $num = $stmt->rowCount();

                if ($num > 0) {
                    header("Location: http://localhost/portfolio/onlineshop/home_create.php");
                } else {
                    $statusErr = "Your account is ban*";
                }
            } else {
                $pasErr = "Incorrect Password*";
            }
        } else {
            $useErr = "User not found *";
        }
    }
    ?>

    <main class="form-signin">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <form>
                <h1 class="h3 mb-3 fw-normal">Please Sign In</h1>

                <!--echo error msg-->
                <span class="error"><?php echo $useErr; ?></span>
                <span class="error"><?php echo $pasErr; ?></span>
                <span class="error"><?php echo $statusErr; ?></span>

                <div class="form-floating ">
                    <input type="text" class="form-control" name="username" value='<?php if (isset($_POST['username'])) {
                                                                                        echo $_POST['username'];
                                                                                    } ?>'>
                    <label for="username">Username</span></label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control" name="password" value='<?php if (isset($_POST['password'])) {
                                                                                            echo $_POST['password'];
                                                                                        } ?>'>
                    <label for="password ">Password</label>
                </div>

                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
            </form>
        </form>
    </main>

</body>

</html>