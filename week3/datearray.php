<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .scrollable-menu {
            height: auto;
            max-height: 200px;
            overflow-x: hidden;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
    $month = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

    $selected_day = date('d'); //current day
    echo "<div class=\"container text-center\">";
    echo "<div class=\"btn-group pt-3 gap-5\">";
    echo "<button class=\"btn btn-info btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
    echo "Day";
    echo "</button>";
    echo "<ul class=\"dropdown-menu scrollable-menu\">";
    for ($i_day = 1; $i_day <= 31; $i_day++) {
        $selected = ($selected_day == $i_day ? ' selected' : '');
        echo '<option value="' . $i_day . '"' . $selected . '>' . $i_day . '</option>' . "\n";
    }
    echo '</select>' . "\n";
    echo "</ul>";
    ?>

    <?php
    echo "<button class=\"btn btn-warning btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
    echo "Month";
    echo "</button>";
    echo "<ul class=\"dropdown-menu scrollable-menu\">";
    echo $month[0] . "<br>";
    echo $month[1] . "<br>";
    echo $month[2] . "<br>";
    echo $month[3] . "<br>";
    echo $month[4] . "<br>";
    echo $month[5] . "<br>";
    echo $month[6] . "<br>";
    echo $month[7] . "<br>";
    echo $month[8] . "<br>";
    echo $month[9] . "<br>";
    echo $month[10] . "<br>";
    echo $month[11] . "<br>";
    echo "</ul>";
    ?>

    <?php
    $year_start  = 1900;
    $year_end = date('Y'); // current Year
    $user_selected_year = 2022; // user date of birth year

    echo "<button class=\"btn btn-danger btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">";
    echo "Year";
    echo "</button>";
    echo "<ul class=\"dropdown-menu scrollable-menu\">";
    for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
        $selected = ($user_selected_year == $i_year ? ' selected' : '');
        echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
    }
    echo '</select>' . "\n";
    echo "</ul>";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>