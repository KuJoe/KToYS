#!/bin/bash
ram=`free -m | grep "Mem" | awk '{print $2}'`
swap=`free -m | grep "Swap" | awk '{print $2}'`
cpu=`cat /proc/cpuinfo | grep "model name" | head -n 1 | sed -r 's/^.{13}//' | tr -s " "`
cpunum=`cat /proc/cpuinfo | grep processor | wc -l`
cpuclock=`cat /proc/cpuinfo | grep MHz | head -n 1 | awk '{print $4}' | awk '{printf("%d\n",$1 + 0.5)}'`
disk=`df -h | grep "/" | grep "G" | awk '{print $2}' | awk '{s+=$1} END {print s}'`
ipv4=`ifconfig | grep "inet addr" | grep -v "127" | awk '{print substr($2,6)}' | tr '\n' ' '`
ipv6=`ifconfig | grep "inet6 addr" | grep -v "Scope:Host" | grep -v "Scope:Compat" | awk '{print $3}' | tr '\n' ' '`

echo "${ram}MB,${swap}MB,${cpu},${cpunum},${cpuclock}MHz,${disk}GB,${ipv4},${ipv6}"