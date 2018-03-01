#!/bin/bash
DIR=$1
T_FILE=/tmp/$(cat /dev/urandom | tr -dc "a-zA-Z0-9" | fold -w15 | head -1)
rm -f $T_FILE
touch $T_FILE

FILELLIST=$(find "$DIR" -type f)

while read line
do
  hash=$(md5sum "$line" | awk '{print $1}')
  g1=$(cat $T_FILE | grep -c "$hash" )
  if [[ "$g1" -gt 0 ]]
  then
    echo Deleting   "$line"
#    rm -f "$line"
  else
    echo "$line"';'"$hash" >> $T_FILE
  fi
done <<< "$FILELLIST"

#rm -f $T_FILE
