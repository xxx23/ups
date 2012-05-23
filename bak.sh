DIR=/mnt/raid/elearning
BAKDIR=/mnt/raid/elearning_bak

dirs=$(ls $DIR|grep -v File)

for var in $dirs
do 
	cp -R $var $BAKDIR
done
