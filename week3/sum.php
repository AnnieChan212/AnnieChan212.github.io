<!DOCTYPE html>

<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<head>
    <style>

    </style>
</head>

<body>
    <?php

    $sum = 0;

    for ($x = 1; $x <= 100; $x++) {
        $sum += $x;

        if ($x % 2 == 0) {
            echo "<strong>" . $x . "</strong>";
            if ($x < 100) {
                echo "+";
            }
        } else {
            echo $x, "+";
        }
    }

    echo "=" . $sum;
    ?>
</body>

</html>