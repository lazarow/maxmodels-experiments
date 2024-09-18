<?php
$input = file_get_contents('php://stdin');

if (strpos($input, 's UNSATISFIABLE') !== false) {
    echo 'UNSAT' . PHP_EOL;
    exit;
}

$pos = strrpos($input, "\no ");
$cost = trim(substr($input, $pos + 3, strpos($input, "\n", $pos + 3) - ($pos + 2)));
file_put_contents('cost.out',  '~~~~~~~~' . PHP_EOL . 'COST=' . $cost . PHP_EOL);
echo 'SAT' . PHP_EOL;
$pos = strpos($input, "\nv ") + 3;
$var = 1;
while (true) {
    if ($input[$pos] != "0" && $input[$pos] != "1") {
        break;
    }
    echo ($var === 1 ? '' : ' ') . ($input[$pos] == "0" ? '-' : '') . $var++;
    $pos++;
}
echo PHP_EOL;
