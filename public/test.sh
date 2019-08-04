#!/bin/sh

#sh ./dockercommand/build.sh
result=$(sh ./dockercommand/run.sh)
echo $result
#sh ./dockercommand/exec.sh

#result=$( docker images )
#if [[ -z "$result" ]]; then
#  echo "Container exists"
#else
#  echo $result
#fi
