#!/bin/bash

netlist_tk_test=""

netlist_fin=""

testlist=""

wdir_tmp=$(dirname $0)
wdir=$(realpath $wdir_tmp)
tklist="$wdir"/tk.list
date=$(date +%Y-%m-%d-%H-%M-%s)
port=445
result="$wdir/result/$date"
report="$wdir/report/$date"
tmp="$wdir/tmp/$date"
mkdir -p "$result"/{pulsar,vulnerability} "$report"/{pulsar,vulnerability} "$tmp"/scanlist
lastReports=`find $wdir/report -type f -not -path *vulnerability/report -exec cat {} +`


function make_list {
  while read line
  do
    name=$(echo "$line" | awk -F':' '{print $2}')
    ip=$(echo "$line" | awk -F':' '{print $1}')
    echo "Searching adresses with open 445/tcp in" "$ip" $name net
    nmap --min-parallelism 400 -Pn -p "$port" --open -n "$ip" | grep 'scan report for' | awk '{print $NF}' >> "$tmp/scanlist/$name"
  done <<< "$1"
}

function scan_pulsar_by_ip {
  time1=$(date +%s)
  for file in "$tmp"/scanlist/*
  do
    name=$(realpath "$file" | awk -F'/' '{print $NF}')
    echo Searching pulsar on "$name"
    $wdir/stat.py --threads 1000 --timeout 5 --file "$file" >> "$result/pulsar/$name"
  done
  time1=$(date +%s)
}

function scan_vul_by_ip {
  time1=$(date +%s)
  for file in "$tmp"/scanlist/*
  do
    name=$(realpath "$file" | awk -F'/' '{print $NF}')
    echo Searching MS017-010 on "$name"
    $wdir/wannacry_tlscan.py -t 5 -f "$file" >> "$result/vulnerability/$name"
  done
  time2=$(date +%s)
}

function report_pulsar {
  for file1 in $result/pulsar/*
  do
    name=$(realpath "$file1" | awk -F'/' '{print $NF}')
    file1=$(cat $file1)
    overall_count=$(echo "$file1" | wc -l)
    overall_problems=$(echo "$file1" | grep '+' | awk '{print $2}' | tr -d '[]')
    if [[ ! -z $overall_problems ]]
    then
      echo "$name" >> $report/pulsar/report
      echo -e "$overall_problems\n\n\n" >> "$report"/pulsar/report
    fi
  done
  echo Pulsar report here":" "$report"/pulsar/report
}

function report_vul {
  for file1 in "$result"/vulnerability/*
  do
    name=$(realpath "$file1" | awk -F'/' '{print $NF}')
    file1=$(cat "$file1" | sort -u )
    overall_count=$(echo "$file1" | wc -l)

    echo "$file1" | grep 'system is vulnerable' | awk '{print $1}' | sort >> $report/vulnerability/report_"$name"_full

overall=`cat "$report"/vulnerability/report_"$name"_full`
    if [[ ! -z $overall ]]
    then
	while read line
	do
		inters=`echo "$lastReports" | grep -c "$line"`
		echo "$lastReports" | grep "$line"
overall_problems="$overall_problems
$line (в предыдущих отчётах адрес встречался $inters раз)"
	done <<< "$overall"
      echo "$name" >> "$report"/vulnerability/report
      echo -e "$overall_problems\n\n\n" >> $report/vulnerability/report
    fi
overall_problems=""
  done
  echo MS017-010 report here":" "$report"/vulnerability/report
}

function mail {
  date1=$(date +'%H:%M %d.%m.%Y')

  body_vul=$(cat "$report"/vulnerability/report)
  body="<font size=4><font size=4><b>Следующие машины не пропатчены от уязвимости MS017-010<br>На них необходимо срочно поставить соответствующий патч</b></font><br></td><pre>$body_vul</pre><br><br><br><br><br><p align=right><font size=2>По вопросам работы скрипта обращатсья к Перминову П.С.<br><a href="mailto:me@me.me">me@me.me</a></p></font>"
  template="<font size=>Отчёт от $date1</font><br>"
  
  echo -e "$body" | mutt -e 'my_hdr From:Central Pulsar <pulsar@holed.windows>' -e 'set content_type="text/html"' -s "Отчёт от $date1" -- "$maillist" #-a "$file"
  rm -f "$file"
}

function pulsar_test {
  make_list "$list1"
  scan_pulsar_by_ip
  report_pulsar
  mail
}

function vulnerability_test {
  make_list "$list1"
  scan_vul_by_ip
  report_vul
  mail
}

function all {
  make_list "$list1"
  scan_vul_by_ip
  report_vul
  mail
}

if [[ $2 == "test" ]]
then
  list1="$testlist"
  maillist="me@me.,e"
elif [[ $2 == "tktest" ]]
then
  list1="$netlist_tk_test"
  maillist="me@me.,e"
else
  list1="$netlist_fin"
. $wdir/maillist.env
fi

if [[ $1 == "pulsar" ]]
then
  pulsar_test
elif [[ $1 == "vul" ]]
then
  vulnerability_test
elif [[ $1 == "scan" ]]
then
  make_list "$list1"
elif [[ $1 == "all" ]]
then
  all
fi
