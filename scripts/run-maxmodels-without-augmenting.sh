#!/bin/bash

gringo --output=smodels --warn=none $1 $2 | lp2normal-2.27 | maxmodels -n
