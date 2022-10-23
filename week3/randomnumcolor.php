<!DOCTYPE html>

<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<head>
    <style>
        .bigger {
            font-weight: bold;
            font-size: large;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row text-center mt-5">
            <div class="col p-3 bg-success">
                <?php
                $x = rand(5, 50);
                $y = rand(5, 50);

                if ($x > $y) {
                    echo "<span class=\"bigger\">";
                    echo $x;
                    echo "</span>";
                } else {
                    echo $x;
                }
                ?>
            </div>
            <div class="col p-3 bg-danger">
                <?php
                if ($x < $y) {
                    echo "<span class=\"bigger\">";
                    echo $y;
                    echo "</span>";
                } else {
                    echo $y;
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>