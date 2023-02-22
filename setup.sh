#!/bin/sh
composer install
cd src
cd Schema
../../vendor/bin/propel config:convert