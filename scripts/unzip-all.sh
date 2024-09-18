#!/bin/bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

unzip $SCRIPT_DIR/../crossing-minimization-problem/crossing-minimization-problem.zip -d crossing-minimization-problem
unzip $SCRIPT_DIR/../maximal-clique-problem/maximal-clique-problem.zip -d maximal-clique-problem

unzip $SCRIPT_DIR/../max-cut-problem/models/clingo+smodels+maxmodels/clingo+smodels+maxmodels.zip -d max-cut-problem/models/clingo+smodels+maxmodels
unzip $SCRIPT_DIR/../max-cut-problem/models/dlv/dlv.zip -d max-cut-problem/models/dlv

unzip $SCRIPT_DIR/../longest-path-problem/models/clingo+smodels+maxmodels/clingo+smodels+maxmodels.zip -d longest-path-problem/models/clingo+smodels+maxmodels
unzip $SCRIPT_DIR/../longest-path-problem/models/dlv/dlv.zip -d longest-path-problem/models/dlv

unzip $SCRIPT_DIR/../weight-bounded-dominating-set/instances/instances.zip -d weight-bounded-dominating-set/instances
