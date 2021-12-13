#!/usr/bin/env bash

function fail {
    if [ "$1" ]
    then
        echo $1
    fi

    cd $CURRENT_DIR

    exit 1
}

CURRENT_DIR=`pwd`

printf "\n\nRunning Unit Tests...\n"
$CURRENT_DIR/vendor/composer/composer/bin/composer test-unit
if [ $? != 0 ]
then
    fail "Unit tests failed."
fi

cd $CURRENT_DIR

exit $?