#!/bin/bash

gringo --output=smodels $1 $2 | lp2normal-2.27 | maxmodels
