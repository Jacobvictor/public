#!/bin/bash

# Directory to search

echo "What is the folder with the all the ebooks to clean up: "

read ebooks


# Find and delete all files that do not have the .epub extension
find "$ebooks" -type f ! -name "*.epub" -exec rm -f {} +

echo "Non-epub files have been removed from $ebooks."
