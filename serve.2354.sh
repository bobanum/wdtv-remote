#!/bin/bash
chemin=$(dirname "$0")
port=`expr "$0" : '.*[_\.]\([0-9]*\)\.sh'`
if [ ! $port ]
then
((port=8000))
fi
cd "${chemin}"
while [ -n "`netstat -atn | grep \".$port \"`" ]
do
((port=port+1))
done
echo "Adresse du site : http://localhost:"$port
start http://localhost:$port
php -S 0.0.0.0:$port
