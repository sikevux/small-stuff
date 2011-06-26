#!/bin/bash                                                                    
# Derp fetches stuff like chan

if [ -z  $1 ]; then
	echo "Usage: "$0" [url]"
	exit
fi

wget -O links_source $1 -U Mozilla
cat links_source | grep href= | grep .jpg | sed 's/^.*href="//' | sed 's/".*$//' | sed '$!N; /^\(.*\)\n\1$/!P; D' > links
wget -i links -U Mozilla --no-check-certificate
rm links_source links
echo "Done, boom"