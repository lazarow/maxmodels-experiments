#!/bin/bash

SCRIPT_DIR=$( dirname -- "$( readlink -f -- "$0"; )"; )

gringo --output=smodels --warn=none $1 $2 | smodels -internal -nolookahead | lpcat-1.25 | lp2normal-2.27 | igen-1.7 | smodels -internal -nolookahead | lpcat-1.25 | lp2lp2-1.23 | lp2sat-1.24 1> program.cnf
wmaxcdcl program.cnf | php $SCRIPT_DIR/make-dimacs.php > model.out
cat model.out | interpret-1.11 -p -d program.cnf
cat cost.out
#rm model.out
#rm program.cnf
#rm cost.out
