for f in `ls *.png`
do
convert $f -quality 80% $f
done;
