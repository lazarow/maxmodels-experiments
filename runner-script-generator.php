<?php
$problems = [
    'crossing-minimization-problem' => [
        '_default' => __DIR__ . '/crossing-minimization-problem'
    ],
    'longest-path-problem' => [
        '_default' => __DIR__ . '/longest-path-problem/models/clingo+smodels+maxmodels',
        'dlv' => __DIR__ . '/longest-path-problem/models/dlv'
    ],
    'max-cut-problem' => [
        '_default' => __DIR__ . '/max-cut-problem/models/clingo+smodels+maxmodels',
        'dlv' => __DIR__ . '/max-cut-problem/models/dlv'
    ],
    'maximal-clique-problem' => [
        '_default' => __DIR__ . '/maximal-clique-problem'
    ]
];

$solvers = [
    'clingo' => 'time timelimit -t240 clingo -q {{FILES}}',
    'dlv' => 'time timelimit -t240 dlv --silent=2 {{FILES}}',
    'smodels' => 'time gringo --output=smodels {{FILES}} | timelimit -t240 smodels 0',
    'time gringo --output=smodels --warn=none {{FILES}} | lp2normal-2.27 | timelimit -t240 maxmodels -e ~/workspace/asp-solvers/maxmodels/.env'
];

echo "#!/bin/bash\n\n";
foreach ($problems as $problem => $paths) {
    foreach ($solvers as $solver => $command) {
        for ($i = 1; $i <= 10; $i++) {
            $path = $paths[$solver] ?? $paths['_default'];
            $files = [];
            if (file_exists("$path/p$i.lp")) {
                $files[] = realpath($path) . "/p$i.lp";
            }
            if (file_exists("$path/p$i.asp")) {
                $files[] = realpath($path) . "/p$i.asp";
            }
            if (file_exists("$path/encoding.asp")) {
                $files[] = realpath($path) . "/encoding.asp";
            }
            echo strtr($command, ['{{FILES}}' => implode(' ', $files)]) . "\n";
            echo "echo '===^^^=== $problem | p$i | $solver ===^^^==='\n";
            echo "echo ''\n";
        }
    }
}