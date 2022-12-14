<?php
session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Login Littlazy Camera</title>
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

        .error {
            color: red;
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
        $query = "SELECT password, account_status FROM customer WHERE username=:username";
        // prepare query for execution
        $stmt = $con->prepare($query);
        // bind the parameters
        $stmt->bindParam(':username', $username);
        // Execute the query
        $stmt->execute();
        $num = $stmt->rowCount();

        //if num 1 found username from database
        if ($num > 0) {
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $password = $row['password'];
            $account_status = $row['account_status'];

            //find password
            //echo $password;
            //echo "<br>";
            //echo md5($_POST['password']);
            if ($password == md5($_POST['password'])) {
                // account ban
                if ($account_status == 'Active') {
                    // Start the session
                    // session = box, user key's username store inside box
                    $_SESSION['user'] = $_POST['username'];
                    header("Location: home.php");
                } else {
                    $statusErr = "Your account is ban*";
                }
            } else {
                $pasErr = "Incorrect Password*";
            }
        } else {
            $useErr = "User not found *";
        }
        if (empty($_POST['username'])) {
            $useErr = "Username & Password is required";
        }
    }
    ?>

    <main class="form-signin">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <form>

                <h1 class="h1 mb-3 fw-normal">LITTLAZY</h1>
                <h1 class="h3 mb-3 fw-normal">Sign In</h1>
                <?php
                if (isset($_GET['action'])) {
                    if ($_GET['action'] = 'decline');
                    echo "<div class='text-danger'>Access Decline*</div>";
                }
                ?>
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
                <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
            </form>
        </form>
    </main>

</body>

</html>