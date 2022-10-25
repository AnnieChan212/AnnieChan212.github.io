<!DOCTYPE html>
<html>

<body>

    <?php
    date_default_timezone_set("Asia/Kuala_Lumpur");

    $t = "12";
    echo $t . "<br>";

    if ($t >= "06" and $t < "12") {
        echo "morning!";
    }
    if ($t >= "12" and $t <= "18") {
        echo "afternoon!";
        if ($t == "12") {
            echo "lunch time!";
        }
    } else {
        echo "night";
    }
    ?>
</body>

</html>