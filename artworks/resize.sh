#!/bin/bash

for s in `ls exported`; do
	for f in `ls exported/$s | grep \.png`; do
	    echo "Resizing $f to $s pixels"
	    convert exported/$s/$f -filter Catrom -resize $s resized/$f
	done
done

