#!/bin/bash

set -e
apt-get update
a2enmod rewrite
apt-get clean
