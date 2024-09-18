<?php
$input = file_get_contents('php://stdin');

$results = [];

$lastCost = null;
foreach(preg_split("/((\r?\n)|(\r\n?))/", $input) as $line) {
    
    if (strlen($line) === 0) {
        continue;
    }

    if (str_starts_with($line, 'COST')) {
        $lastCost = substr($line, 5);
        continue;
    }

    $matches = [];
    if (preg_match('/\=\=\=\^\^\^\=\=\= ([a-zA-Z0-9_-]+) \| ([a-zA-Z0-9]+) \| ([a-zA-Z0-9_-]+) \| It takes (\d+) milliseconds to complete this task/', $line, $matches)) {
            $problem = $matches[1];
            $instance = $matches[2];
            $solver = $matches[3];
            $time = $matches[4];
            $results[$problem][$instance][$solver] = [$time, $lastCost];
            $lastCost = null;
    }

} 

foreach ($results as $problem => $instances) {
    echo implode(';', array_merge([$problem], array_keys($instances['p1']), array_keys($instances['p1']))) . PHP_EOL;
    foreach ($instances as $instance => $solvers) {
        echo $instance;
        foreach ($solvers as $solver => $metrics) {
            echo ';' . number_format((float)$metrics[0]/1000, 2, ',', '');
        }
        foreach ($solvers as $solver => $metrics) {
            if (strpos($metrics[1], '@') !== false) {
                $tmp = explode('@', $metrics[1]);
                $metrics[1] = $tmp[0];
            }
            echo ';' . $metrics[1];
        }
        echo PHP_EOL;
    }
}
