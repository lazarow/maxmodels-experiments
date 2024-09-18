#!/bin/bash

SCRIPT_DIR=$( dirname -- "$( readlink -f -- "$0"; )"; )

unzip $SCRIPT_DIR/../crossing-minimization-problem/instances/instances.zip -d $SCRIPT_DIR/../crossing-minimization-problem/instances
unzip $SCRIPT_DIR/../maximal-clique-problem/instances/instances.zip -d $SCRIPT_DIR/../maximal-clique-problem/instances
unzip $SCRIPT_DIR/../max-cut-problem/instances/instances.zip -d $SCRIPT_DIR/../max-cut-problem/instances
unzip $SCRIPT_DIR/../longest-path-problem/instances/instances.zip -d $SCRIPT_DIR/../longest-path-problem/instances
unzip $SCRIPT_DIR/../weight-bounded-dominating-set/instances/instances.zip -d $SCRIPT_DIR/../weight-bounded-dominating-set/instances
