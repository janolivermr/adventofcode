#!/bin/bash
echo "Enter your session value to download the input files!"
read -p 'Session Value: ' session

for i in {1..12}
do
	filename=$(printf "Dec%02d.txt" $i)
	if [ ! -f "$filename" ]
	then
		echo "Downloading $filename"
		echo "|"
		curl "https://adventofcode.com/2019/day/$i/input" -o "$filename" -b "session=$session"
		sleep 1
	fi
done