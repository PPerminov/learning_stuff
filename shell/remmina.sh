#!/bin/bash

. credentials  # in this file must be declared variables  $ldap_user $search_base $remmina_path

echo $ldap_user
echo $search_base



function get_servers {
  ldapsearch -D $ldap_user -b $search_base -h AD_Server -W -E pr=15000/noprompt '(operatingsystem=*server*)' cn | grep 'cn: ' | awk -F'cn: ' '{print $NF}'
}

function main {

  servers=`get_servers`

  for server in $servers:
  do
    echo "[remmina]
disableclipboard=0
ssh_auth=0
clientname=
quality=0
ssh_charset=
ssh_privatekey=
console=1
resolution=1879x977
group=
password= #insert password here
name=$server
ssh_loopback=0
shareprinter=0
ssh_username=
ssh_server=
security=
protocol=RDP
execpath=
sound=off
exec=
ssh_enabled=0
username=a-pper003
sharefolder=/home/
domain=ies
server=$server
colordepth=15
window_maximize=0
window_height=726
viewmode=1
window_width=1440" > $remmina_path/"$server".remmina
  done
}


main
