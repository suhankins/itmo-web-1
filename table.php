<?php
$time_start = microtime(true);
function validate($X, $Y, $R) {
    $valid_x = array(-2, -1.5, -1, -0.5, 0, 0.5, 1, 1.5, 2);
    $valid_y = array(
        "lower" => -3,
        "upper" => 5,
    );
    $valid_r = array(1, 1.5, 2, 2.5, 3);

    if (!in_array($X, $valid_x)) {
        return false;
    }
    if (!in_array($R, $valid_r)) {
        return false;
    }
    if (!($Y >= $valid_y["lower"] and $Y <= $valid_y["upper"])) {
        return false;
    }
    return true;
}

function in_area($X, $Y, $R) {
    #     |
    #     | X
    # ----+----
    #     |
    #     |
    if ($X > 0 and $Y > 0) {
        return false;
    }
    #     |
    #     | 
    # ----+----
    #     | X
    #     |
    if (($X >= 0 and $X <= $R) and ($Y <= 0 and $Y >= $R/2)) {
        return true;
    }
    #     |
    #     | 
    # ----+----
    #   X | 
    #     |
    if (($X <= 0 and $Y <= 0) and (abs($X) + abs($Y) <= $R)) {
        return true;
    }
    #     |
    #   X | 
    # ----+----
    #     | 
    #     |
    if (($X <= 0 and $Y >= 0) and (sqrt($X ** 2 + $Y ** 2) <= $R/2)) {
        return true;
    }
    return false;
}

$X = intval($_GET["X"]);
$Y = intval($_GET["Y"]);
$R = intval($_GET["R"]);

$validated = validate($X, $Y, $R);
$in_area = null;
if ($validated) {
    $in_area = in_area($X, $Y, $R);
}
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./css/styles.css">
        <link rel="icon" type="image/png" href="./img/favicon.png">
    </head>
    <body>
        <main>
            <?php if ($validated): ?>
            <img src="./img/graph.png">
            <h1>Latest result:</h1>
            <table>
                <tr>
                    <th>
                        X
                    </th>
                    <td>
                        <?php echo $X; ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Y
                    </th>
                    <td>
                        <?php echo $Y; ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        R
                    </th>
                    <td>
                        <?php echo $R; ?>
                    </td>
                </tr>
                <tr class="result">
                    <th>
                        Result
                    </th>
                    <td>
                        <?php if ($in_area) {
                            echo "Is in area";
                        } else {
                            echo "Not in area";
                        } ?>
                    </td>
                </tr>
                <tr class="misc">
                    <th>
                        Current time
                    </th>
                    <td>
                        <?php echo time(); ?>
                    </td>
                </tr>
                <tr class="misc">
                    <th>
                        Execution time
                    </th>
                    <td>
                        <?php echo microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"] . "s"; ?>
                    </td>
                </tr>
            </table>
            <h1>Previous results:</h1>
            <?php endif; ?>
        </main>
    </body>
</html>