#!/usr/bin/bash
if [-z "$(which php)"] ; then
    echo "SAKey : Php is missing on your computer";
    echo "Would you want SAKey downloads PHP for you (Y/n)";
    select option in "n" "no"; do
    case $option in "n")
            echo "We won't download PHP, we can't run the software.";
            sleep 1;
            exit
            break
        ;;
        "no")
            echo "We won't download PHP, we can't run the software.";
            sleep 1;
            exit
            break
        ;;
        *)
        echo "We will download PHP to run the software.";
        sleep 1;
        sudo apt install php
        ./SAKeyProg.php
        ;;

    esac
    done
else
    ./SAKeyProg.php
fi
