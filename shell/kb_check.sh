#!/usr/bin/env bash

if [[ $1 == "-h" ]] || [[ $1 == '--help' ]]
then
  echo HELP! I need somebody!
fi

for word in `echo "$@"`
do
  param=`echo "$word" | awk -F'=' '{print $1}'`
  value=`echo "$word" | awk -F'=' '{print $2}'`
  declare $param=$value
done

function checkVariables {
  if [[ -z $IP ]]
  then
    read -s -p "IP or NAME: " IP
  fi
  if [[ -z $DOMAIN ]]
  then
    read -s -p "Account name: " DOMAIN
  fi
  if [[ -z $ACCOUNT ]]
  then
    read -s -p "Account name: " ACCOUNT
  fi
  if [[ -z $PASS ]]
  then
    read -s -p "Password: " PASS
  fi
  if [[ -z $KB ]]
  then
    read -s -p "KB: "
  fi
  if [[ -z $FILE ]]
  then
    read -s -p "File: "
  fi

}

if [[ $KB ]]
then
  wmic -U "$DOMAIN/$ACCOUNT" //$OBJECT "select * from Win32_OperatingSystemQFE" | sed -r 's/(.*)([Kk][Bb][0-9]*)(.*)/\2/g' | sort -u | grep [kK][bB][0-9]* > $FILE_TO_OUT
fi

exit $?
