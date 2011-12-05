#!/bin/bash

GENERATED=../jazzy-forms/generated/

php model.php > $GENERATED/Model.php
php schema.php > $GENERATED/schema.sql

