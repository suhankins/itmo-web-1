<?php
function validate($X, $Y, $R) {
    $valid_x = array(-2, -1.5, -1, -0.5, 0, 0.5, 1, 1.5, 2);
    $valid_y = array(
        "lower" => -3,
        "upper" => 5,
    );
    $valid_r = array(1, 1.5, 2, 2.5, 3);

    if (!in_array($X, $valid_x)) {
        echo var_dump($X);
        echo "X sucks";
        return false;
    }
    if (!in_array($R, $valid_r)) {
        echo var_dump($R);
        echo "R sucks";
        return false;
    }
    if (!($Y >= $valid_y["lower"] and $Y <= $valid_y["upper"])) {
        echo var_dump($Y);
        echo "Y sucks";
        return false;
    }
    return true;
}

$X = intval($_GET["X"]);
$Y = intval($_GET["Y"]);
$R = intval($_GET["R"]);

$validated = validate($X, $Y, $R);
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title><?php
            if ($validated) {
                echo "Results for X:{$X} Y:{$Y} R:{$R}";
            } else {
                echo "Error!";
            }
        ?></title>
    </head>
    <body>
        
    </body>
</html>