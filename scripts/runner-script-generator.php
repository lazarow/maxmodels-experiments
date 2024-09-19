<?php
$problems = [
    'crossing-minimization-problem' => [
        '_instances' => __DIR__ . '/../crossing-minimization-problem/instances',
        '_default' => __DIR__ . '/../crossing-minimization-problem/models'
    ],
    'longest-path-problem' => [
        '_instances' => __DIR__ . '/../longest-path-problem/instances',
        '_default' => __DIR__ . '/../longest-path-problem/models/clingo+smodels+maxmodels',
        'dlv' => __DIR__ . '/../longest-path-problem/models/dlv'
    ],
    'max-cut-problem' => [
        '_instances' => __DIR__ . '/../max-cut-problem/instances',
        '_default' => __DIR__ . '/../max-cut-problem/models/clingo+smodels+maxmodels',
        'dlv' => __DIR__ . '/../max-cut-problem/models/dlv'
    ],
    'maximal-clique-problem' => [
        '_instances' => __DIR__ . '/../maximal-clique-problem/instances',
        '_default' => __DIR__ . '/../maximal-clique-problem/models',
        'doNotUseAugmenting' => true
    ],
    'minimum-test-set-problem' => [
        '_instances' => __DIR__ . '/../minimum-test-set-problem/instances',
        '_default' => __DIR__ . '/../minimum-test-set-problem/models/clingo+smodels+maxmodels',
        'dlv' => __DIR__ . '/../minimum-test-set-problem/models/dlv',
        'doNotUseAugmenting' => true
    ],
    'weight-bounded-dominating-set' => [
        '_instances' => __DIR__ . '/../weight-bounded-dominating-set/instances',
        '_default' => __DIR__ . '/../weight-bounded-dominating-set/models/clingo+smodels+maxmodels',
        'dlv' => __DIR__ . '/../weight-bounded-dominating-set/models/dlv'
    ],
];

$solvers = [
    'clingo' => 'timelimit -t240 ' . realpath(__DIR__ . '/../scripts/run-clingo.sh') . ' {{FILES}}',
    'dlv' => 'timelimit -t240 ' . realpath(__DIR__ . '/../scripts/run-dlv.sh') . ' {{FILES}}',
    'smodels' => 'timelimit -t240 ' . realpath(__DIR__ . '/../scripts/run-smodels.sh') . ' {{FILES}}',
    'maxmodels' => 'timelimit -t240 ' . realpath(__DIR__ . '/../scripts/run-maxmodels.sh') . ' {{FILES}}',
    'lp2sat' => 'timelimit -t240 ' . realpath(__DIR__ . '/../scripts/run-lp2sat.sh') . ' {{FILES}}',
];

echo "#!/bin/bash\n\n";
foreach ($problems as $problem => $paths) {
    for ($i = 1; $i <= 10; $i++) {
        foreach ($solvers as $solver => $command) {
            $instancesPath = $paths['_instances'];
            $modelsPath = $paths[$solver] ?? $paths['_default'];
            $files = [];
            if (file_exists("$instancesPath/p$i.lp")) {
                $files[] = realpath($instancesPath) . "/p$i.lp";
            }
            if (file_exists("$instancesPath/p$i.dl")) {
                $files[] = realpath($instancesPath) . "/p$i.dl";
            }
            if (file_exists("$instancesPath/p$i.asp")) {
                $files[] = realpath($instancesPath) . "/p$i.asp";
            }
            if (file_exists("$modelsPath/encoding.asp")) {
                $files[] = realpath($modelsPath) . "/encoding.asp";
            }
            if (file_exists("$modelsPath/encoding.dl")) {
                $files[] = realpath($modelsPath) . "/encoding.dl";
            }
            if (file_exists("$modelsPath/encoding.lp")) {
                $files[] = realpath($modelsPath) . "/encoding.lp";
            }
            if (isset($paths['doNotUseAugmenting']) && $paths['doNotUseAugmenting'] && $solver == 'maxmodels') {
                $command = 'timelimit -t240 ' . realpath(__DIR__ . '/../scripts/run-maxmodels-without-augmenting.sh') . ' {{FILES}}';
            }
            echo "start=`date +%s%N`\n";
            echo strtr($command, ['{{FILES}}' => implode(' ', $files)]) . "\n";
            echo "end=`date +%s%N`\n";
            echo 'echo "===^^^=== '.$problem.' | p'.$i.' | '.$solver.' | It takes $(( ($end - $start) / 1000000 )) milliseconds to complete this task ===^^^==="' . "\n";
            echo "echo ''\n";
        }
    }
}