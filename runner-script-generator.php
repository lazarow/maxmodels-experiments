<?php
$problems = [
    'longest-path-problem' => [
        '_default' => __DIR__ . '/longest-path-problem/models/clingo+smodels+maxmodels',
        'dlv' => __DIR__ . '/longest-path-problem/models/dlv'
    ],
    'crossing-minimization-problem' => [
        '_default' => __DIR__ . '/crossing-minimization-problem'
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
    'clingo' => 'timelimit -t240 clingo -q {{FILES}}',
    'dlv' => 'timelimit -t240 dlv --silent=2 {{FILES}}',
    'smodels' => 'gringo --output=smodels {{FILES}} | timelimit -t240 smodels 0',
    'maxmodels' => 'gringo --output=smodels --warn=none {{FILES}} | lp2normal-2.27 | timelimit -t240 maxmodels -e ~/workspace/asp-solvers/maxmodels/.env'
];

echo "#!/bin/bash\n\n";
foreach ($problems as $problem => $paths) {
    for ($i = 1; $i <= 10; $i++) {
        foreach ($solvers as $solver => $command) {
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
            echo "start=`date +%s%N`\n";
            echo strtr($command, ['{{FILES}}' => implode(' ', $files)]) . "\n";
            echo "end=`date +%s%N`\n";
            echo 'echo "===^^^=== '.$problem.' | p'.$i.' | '.$solver.' | It takes $(( ($end - $start) / 1000000 )) milliseconds to complete this task ===^^^==="' . "\n";
            echo "echo ''\n";
        }
    }
}