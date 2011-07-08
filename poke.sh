#!/bin/bash
# Lame Facebook poker
# Made by Sikevux
# Feel free to do whatever the fuck you want with this
# Mee needs cookies kk?
# TODO:
# Fix auth cookie
# Fix poke loop

DEPENDENCIES="curl sed"
for DEP in $DEPENDENCIES; do
	if [ -z "`which $DEP`" ]; then
		echo "ERROR: Missing dependency '$DEP'." >&2
		exit
	fi
done

echo -e "Starting up.... \n\tThis may take a while"
POKE=$(curl -s -b cookies.txt https://m.facebook.com/home.php | grep notifications | sed 's/^.*href="\/a\/notifications\.php?poke/https\:\/\/m\.facebook\.com\/a\/notifications\.php?poke/' | sed 's/".*$//')
# Sure it's a long string to match but better safe than sorry
POKE=$(echo $POKE |sed 's/amp;//g')
if [[ $POKE == https* ]]; then
	curl -s -b cookies.txt $POKE
	echo "Poked"
else
	echo -e "Something failed\nBut we liek debug sooo here's the liink"
	echo $POKE
fi