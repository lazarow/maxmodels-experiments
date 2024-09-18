#!/bin/bash

gringo --output=smodels --warn=none $1 $2 | smodels 0
