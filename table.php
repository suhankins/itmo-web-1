<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Report {
    public $x;
    public $y;
    public $r;
    public $result;
    public $current;
    public $execution;
    public $table_row;

    private static function area_string($in_area) {
        if ($in_area) return "Is in area";
        return "Not in area";
    }
    public function __construct($x, $y, $r, $result, $current, $execution) {
        $this->x = $x;
        $this->y = $y;
        $this->r = $r;
        $this->result = $result;
        $this->current = $current;
        $this->execution = $execution;

        $this->table_row = "<tr><td>" . $x . "</td><td>" . $y . "</td><td>" . $r .
        "</td><td class='result'>" . $this->area_string($result) . "</td><td class='misc'>" . $current .
        "</td><td class='misc'>" . $execution . " s</td></tr>";
    }
}

$time_start = microtime(true);
$table_head = '<tr><th>X</th><th>Y</th><th>R</th><th class="result">Result</th><th class="misc">Current time</th><th class="misc">Execution time</th></tr>';
function validate($x, $y, $r) {
    $valid_x = array(-2, -1.5, -1, -0.5, 0, 0.5, 1, 1.5, 2);
    $valid_y = array(
        "lower" => -3,
        "upper" => 5,
    );
    $valid_r = array(1, 1.5, 2, 2.5, 3);

    if (!in_array($x, $valid_x)) {
        return false;
    }
    if (!in_array($r, $valid_r)) {
        return false;
    }
    if (!($y >= $valid_y["lower"] and $y <= $valid_y["upper"])) {
        return false;
    }
    return true;
}

function in_area($x, $y, $r) {
    #     |
    #     | X
    # ----+----
    #     |
    #     |
    if ($x > 0 and $y > 0) {
        return false;
    }
    #     |
    #     | 
    # ----+----
    #     | X
    #     |
    if (($x >= 0 and $x <= $r) and ($y <= 0 and $y >= $r/2)) {
        return true;
    }
    #     |
    #     | 
    # ----+----
    #   X | 
    #     |
    if (($x <= 0 and $y <= 0) and (abs($x) + abs($y) <= $r)) {
        return true;
    }
    #     |
    #   X | 
    # ----+----
    #     | 
    #     |
    if (($x <= 0 and $y >= 0) and (sqrt($x ** 2 + $y ** 2) <= $r/2)) {
        return true;
    }
    return false;
}

$x = floatval($_GET["X"]);
$y = floatval($_GET["Y"]);
$r = floatval($_GET["R"]);

$validated = validate($x, $y, $r);
$in_area = null;
$current_time = null;
$execution_time = null;
if ($validated) {
    $execution_time = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 7);
    $current_time =  date("j M o G:i:s", time());
    $in_area = in_area($x, $y, $r);
    $report = new Report($x, $y, $r, $in_area, $current_time, $execution_time);
    session_start();
    if (!isset($_SESSION['data'])) {
        $_SESSION['data'] = array();
    }
    array_push($_SESSION['data'], $report);
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
            <a href="index.html" class="submit">Go back</a><br>
            <?php if ($validated): ?>
            <img src="./img/graph.png">
            <h1>Latest result:</h1>
            <table>
                <?php echo $table_head; ?>
                <?php echo $report->table_row; ?>
            </table>
            <h1>Previous results:</h1>
            <table>
                <?php echo $table_head; ?>
                <?php
                for ($i = 0; $i < count($_SESSION['data']) - 1; $i = $i + 1) {
                    echo $_SESSION['data'][$i]->table_row;
                }
            ?>
            </table>
            <?php else: ?>
            <h1>Invalid data</h1>
            <?php endif; ?>
        </main>
    </body>
</html>