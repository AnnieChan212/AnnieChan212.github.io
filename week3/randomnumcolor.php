<!DOCTYPE html>

<html>

<head>
    <style>
        .bigger {
            font-weight: bold;
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