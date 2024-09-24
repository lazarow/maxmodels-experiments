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

for ($i = 0; $i < count($data) - 2; ++$i) {
    $row = preg_split('/\s+/', $data[$i]);
    for ($j = 0; $j < count($row); ++$j) {
        if ($j > 0) {
            echo ' & ';
        }
        if (is_numeric($row[$j][0]) && strpos($row[$j], ',') !== false) {
            if (strpos($row[$j], '*') !== false) {
                $value = (float) strtr(mb_substr($row[$j], 0, -1), [',' => '.']);
                echo '$ \\mathbf{' . number_format(
                    $value,
                    2,
                    '.',
                    ''
                ) . '} $ \unit{\second}';
            } else {
                $value = (float) strtr($row[$j], [',' => '.']);
                echo '$ ' . number_format(
                    (float) strtr($row[$j], [',' => '.']),
                    2,
                    '.',
                    ''
                ) . ' $ \unit{\second}';
            }
        } else if (is_numeric($row[$j])) {
            $total[$j] += (int) $row[$j];
            echo '$ ' . ((int) $row[$j]) . ' $';
        } else if ($row[$j] === 'Tak') {
            echo 'Yes';
        } else if ($row[$j] === 'Nie') {
            echo 'No';
        } else if ($row[$j] === 'TL') {
            $total[$j] += 240;
            echo $row[$j];
        } else {
            echo $row[$j];
        }
    }
    echo " \\\\ \n";    
}

echo "\midrule\n";
echo 'Total';
for ($i = 0; $i < count($total); ++$i) {
    echo ' & $ ' . number_format(
        strtr($total[$i], [',' => '.', '*' => '']),
        2,
        '.',
        ''
    ) . ' $ \unit{\second}';
}
echo " \\\\ \n";

echo "\midrule\n";
echo 'Avg. Success Rate';
for ($i = 0; $i < count($avgSuccessRate); ++$i) {
    echo ' & $ ' . number_format(
        strtr($avgSuccessRate[$i], ['%' => '', ',' => '.', '*' => '']),
        0,
        '.',
        ''
    ) . '\% $';
}
echo " \\\\ \n";
