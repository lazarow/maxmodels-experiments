#!/bin/bash

gringo --output=smodels $1 $2 | smodels 0
