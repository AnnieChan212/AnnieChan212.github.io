<!DOCTYPE html>
<html>

<body>

    <?php
    date_default_timezone_set("Asia/Kuala_Lumpur");

    $t = date("H");


    if ($t > "06" and $t < "12") {
        echo "morning!";
    }
    if ($t > "13" and $t < "18") {
        echo "afternoon!";
    } elseif ($t = "12") {
        echo "lunch time!";
    }
    ?>


</body>

</html>