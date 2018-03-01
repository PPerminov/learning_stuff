#!/bin/bash

# Addition for apt-mirror
# Delete unused files when repo deleted from mirroring
# First argument - path to dists files
# Second argument - release name to delete

if [[ -z $1 ]] || [[ -z $2 ]]
then
echo "Bad args
First argument - path to dists files
For example /repo/mirror/ru.archive.ubuntu.com/ubuntu/dists
Second argument - release name to delete
For example - trusty
"
exit 2
fi

path=$(realpath $1)

release=$2

delete_list=/tmp/files_left

stay_list=/tmp/files_right

all_packs=$(find $path -name Packages | sort -u)

remove_packs=$(echo $all_packs | grep $release)

tmp_packs="$remove_packs
$all_packs"

stay_packs=$(echo "$tmp_packs" | sort | uniq -u )

function delete_files {
  while read line
  do
    stay="$stay
    $(cat "$line" | grep Filename | awk -F': ' '{print $2}')"
  done <<< "$stay_packs"

  while read line
  do
    remove="$remove
    $(cat "$line" | grep Filename | awk -F': ' '{print $2}')"
  done <<< "$remove_packs"

  echo "$remove" | sort -u > $delete_list
  echo "$stay" | sort -u > $stay_list


  data=$(comm -23 $delete_list $stay_list)

  while read line
  do
    rm -f "$path/../$line"
  done <<< "$data"
}

function delete_dirs {
  find $path/../../../../ -type d -iname *$release* -exec rm -rf {} +
}

delete_files
delete_dirs
