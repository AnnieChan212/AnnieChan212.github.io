<!DOCTYPE html>

<html>

<head>
    <style>
        .line1 {
            color: green;
            font-style: italic;
        }

        .line2 {
            color: blue;
            font-style: italic;
        }

        .line3 {
            color: red;
            font-weight: bold;
        }

        .line4 {
            font-weight: bold;
            font-style: italic;
        }
    </style>
</head>

<body>

    <?php
    $x = rand(10, 500);
    $y = rand(10, 500);

    echo "<span class=\"line1\">";
    echo $x;
    echo "</span> <br>";

    echo "<span class=\"line1\">";
    echo $y;
    echo "</span> <br>";

    echo "<span class=\"line3\">";
    echo ($x + $y);
    echo "</span> <br>";

    echo "<span class=\"line4\">";
    echo ($x * $y);
    echo "</span> <br>";


    ?>

</body>

</html>