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
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected>Day</option>

                <?php
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $day = date("d");
                for ($i_day = 1; $i_day <= 31; $i_day++) {
                    $selected = ($day == $i_day ? ' selected' : '');
                    echo '<option value="' . $i_day . '"' . $selected . '>' . $i_day . '</option>';
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row justify-content-center p-5">
        <div class="col-2">
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected>Month</option>

                <?php
                $month = date('m');
                for ($i_month = 1; $i_month <= 12; $i_month++) {
                    $selected = ($month == $i_month ? ' selected' : '');
                    echo '<option value="' . $i_month . '"' . $selected . '>' . date('F', mktime(0, 0, 0, $i_month)) . '</option>';
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row justify-content-center p-5">
        <div class="col-2">
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected>Year</option>

                <?php
                $year = date('Y');
                for ($i_year = 2010; $i_year <= 2022; $i_year++) {
                    $selected = ($year == $i_year ? ' selected' : '');
                    echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>';
                }
                ?>
            </select>
        </div>
    </div>




</body>

</html>