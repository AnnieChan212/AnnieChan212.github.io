<!DOCTYPE html>

<html>

<head>
    <style>
        .red {
            color: red;
        }

        .blue {
            color: blue;
        }
    </style>
</head>

<body>

    <?php
    echo "My first <strong>PHP</strong> script!<br>";

    echo "<span class=\"red\">" . date("jS") . "</span> ";
    echo date("F");
    echo "<span class=\"blue\">" . date("Y") . "</span>";

    ?>

</body>

</html>