#!/bin/bash

# Daily push


if [[ ! -d .git ]]
then
  echo Wrong directory
fi

if [[ -z $1 ]]
then
message=\'\'
else
message=\'$1\'
fi


git add --all .

git commit --allow-empty-message --no-edit -m $message

git push
