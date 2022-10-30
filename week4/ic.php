<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <div class="row justify-content-center p-5">
        <div class="col-2">

            <?php
            $ic = ("991112-14-5533");
            echo "$ic <br>";
            $DOB = substr($ic, 0, 6);
            ?>

            <?php
            $gender = substr($ic, -1);
            if ($gender % 2 == 0) {
                echo "Mrs. <br>";
            } else {
                echo "Mr. <br>";
            }
            ?>

            <?php
            $icDOB = date_create_from_format("ymd", $DOB);
            echo date_format($icDOB, "M d, Y");
            echo "<br>";
            ?>

            <?php
            $day = substr($ic, 4, 2);
            $month = substr($ic, 2, 2);
            function sign($day, $month)
            {

                if (($month == 3 || $month == 4) && ($day > 22 || $day < 21)) {
                    $sign = "Aries";
                    echo "<img src='img/aries.png'/>";
                } elseif (($month == 4 || $month == 5) && ($day > 22 || $day < 22)) {
                    $sign = "Taurus";
                    echo "<img src='img/Taurus.png'/>";
                } elseif (($month == 5 || $month == 6) && ($day > 23 || $day < 22)) {
                    $sign = "Gemini";
                    echo "<img src='img/Gemini.png'/>";
                } elseif (($month == 6 || $month == 7) && ($day > 23 || $day < 23)) {
                    $sign = "Cancer";
                    echo "<img src='img/Cancer.png'/>";
                } elseif (($month == 7 || $month == 8) && ($day > 24 || $day < 22)) {
                    $sign = "Leo";
                    echo "<img src='img/Leo.png'/>";
                } elseif (($month == 8 || $month == 9) && ($day > 23 || $day < 24)) {
                    $sign = "Virgo";
                    echo "<img src='img/Virgo.png'/>";
                } elseif (($month == 9 || $month == 10) && ($day > 25 || $day < 24)) {
                    $sign = "Libra";
                    echo "<img src='img/Libra.png'/>";
                } elseif (($month == 10 || $month == 11) && ($day > 25 || $day < 23)) {
                    $sign = "Scorpio";
                    echo "<img src='img/Scorpio.png'/>";
                } elseif (($month == 11 || $month == 12) && ($day > 24 || $day < 23)) {
                    $sign = "Sagittarius";
                    echo "<img src='img/Sagittarius.png'/>";
                } elseif (($month == 12 || $month == 1) && ($day > 24 || $day < 21)) {
                    $sign = "Cpricorn";
                    echo "<img src='img/Cpricorn.png'/>";
                } elseif (($month == 1 || $month == 2) && ($day > 22 || $day < 20)) {
                    $sign = "Aquarius";
                    echo "<img src='img/Aquarius.png'/>";
                } elseif (($month == 2 || $month == 3) && ($day > 21 || $day < 21)) {
                    $sign = "Pisces";
                    echo "<img src='img/Pisces.png'/>";
                }
                return $sign;
            }
            echo sign($day, $month);
            ?>
        </div>
    </div>

</body>

</html>