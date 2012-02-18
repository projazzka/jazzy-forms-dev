#!/bin/bash

GENERATED=../jazzy-forms/generated/

php model.php > $GENERATED/Basic_Model.php
php schema.php > $GENERATED/schema.sql
php update.php > $GENERATED/update.sql
