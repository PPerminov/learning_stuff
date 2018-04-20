#!/bin/bash
rm -rf ids ids.tmp ddata ddata.tmp down
links=''
if [[ -f $1 ]]
then
  while read line
  do
    first_page=`curl https://www.catalog.update.microsoft.com/Search.aspx?q="$line" | grep _C0_R | awk '{print $NF}' | awk -F'"|_' '{print $2}' | sort -u`
  done < $1
else
  first_page=`curl https://www.catalog.update.microsoft.com/Search.aspx?q="$1" | grep _C0_R | awk '{print $NF}' | awk -F'"|_' '{print $2}' | sort -u`
fi
echo done 1
while read line
do
  form=updateIDs=[\{\"size\"\:0,\"languages\"\:\"\",\"uidInfo\"\:\""$line"\"\,\"updateID\"\:\""$line"\"\}\]
links="$links
`curl --form "$form" https://www.catalog.update.microsoft.com/DownloadDialog.aspx | grep downloadInformation | grep url | awk '{print $NF}' | tr -d "\';"`"
done <<< "$first_page"


download_list=`echo "$links" | egrep -v 'cht|csy|nld|jpn|ara|sve|esn|chs|deu|hun|trk|kor|nor|heb|fra|ell|ita|plk|fin|ptg|dan|ptb|ia64' | sort -u `

echo "$download_list" | wget --directory-prefix='.' -i -
