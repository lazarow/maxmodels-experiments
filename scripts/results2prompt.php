<?php
$data = <<<'DATA'
Problem	clingo	dlv	smodels	maxmodels
crossing-minimization-problem	1732,36	15,52*	2400,02	1010,47
longest-path-problem	1700,88	1975,1	836,82	602,53*
max-cut-problem	2277,04	1475,23	2188,17	95,62*
maximal-clique-problem	2400,15	1854,76	2028,8	100,56*
minimum-test-set-problem	679,42	525,53	2256,35	216,35*
weight-bounded-dominating-set	1446,56	974,79*	1792,65	1367,91
Total-Computing-Time	10236,41	6820,93	11502,81	3393,44*
Average-Success-Rate	45,00%	61,67%	36,67%	86,67%
DATA;

$data = array_map('trim', explode("\n", trim($data)));
$solvers = array_slice(preg_split('/\s+/', $data[0]), 1);
$nofProblems = count($data) - 3;
$problems = array_map(function ($line) {
    $row = preg_split('/\s+/', $line);
    return trim($row[0]);
}, array_slice($data, 1, -2));
$results = array_fill(0, count($solvers), []);

$line = array_slice($data, -2, 1)[0];
$row = preg_split('/\s+/', $line);
$total = array_map(function ($value) {
    return (float) strtr($value, [',' => '.']);
}, array_slice($row, 1));

$line = array_slice($data, -1, 1)[0];
$row = preg_split('/\s+/', $line);
$avgSuccessRate = array_map(function ($value) {
    return strtr($value, [',' => '.']);
}, array_slice($row, 1));

for ($i = 1; $i < count($data) - 2; ++$i) {
    $row = preg_split('/\s+/', $data[$i]);
    for ($j = 1; $j < count($row); ++$j) {
        if (strpos($row[$j], '*') !== false) {
            $value = (float) strtr(mb_substr($row[$j], 0, -1), [',' => '.']);
            $results[$j - 1][] = number_format($value, 2) . ' s';
        } else {
            $value = (float) strtr($row[$j], [',' => '.']);
            $results[$j - 1][] = number_format($value, 2) . ' s';
        }
    }
}

echo "In the conducted experiment, there were " . $nofProblems . " problems named: " . implode(', ', $problems) . ". ";
echo "There were " . count($solvers) . " solvers named: " . implode(', ', $solvers) . ". ";
for ($i = 0; $i < count($solvers); $i++) {
    echo $solvers[$i] . " had the following solving times: " . implode(', ', $results[$i]) . ", so the total solving time was "
        . number_format($total[$i], 2) . " s and the average success rate was " . $avgSuccessRate[$i] . ". ";
}
echo "Please write a detailed and academic comparison of the solvers based on the obtained results. Please rank up the solvers based on the efficiency.";
