#!/bin/bash

if ! command -v php &> /dev/null; then
    echo "SAKey : PHP is missing on your computer."
    read -p "Would you like SAKey to download PHP for you? (Y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]] || [[ -z $REPLY ]]; then
        echo "We will download PHP to run the software."
        sleep 1
        if sudo apt install -y php; then
            ./SAKeyProg.php
        else
            echo "Failed to install PHP. Please install it manually."
            exit 1
        fi
    else
        echo "We won't download PHP. We can't run the software."
        sleep 1
        exit 0
    fi
else
    ./SAKeyProg.php
fi

