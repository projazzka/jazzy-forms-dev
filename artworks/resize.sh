#!/bin/bash

for f in `ls exported`; do
    echo "Resizing $f"
    convert exported/$f -filter Catrom -resize 16x16 resized/$f
done
