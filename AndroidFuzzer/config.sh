#!/bin/sh
#DIR_OUT="../out"
#FILE="Resume_`date +"%d%b%Y"`"
#FILENAME=$FILE
#SRCFILE="src_Resume.tex"
#MIDFILE="mid_Resume.tex"
#FIRMNAME="fuckyou!"

#vim $SRCFILE  
#sed "s/$FIRMNAME/$1/g" < $SRCFILE > $MIDFILE 
#pdflatex -jobname=$FILENAME -output-directory=$DIR_OUT $SRCFILE >> tmp
#rm $DIR_OUT/*.aux $DIR_OUT/*.log tmp
#open "$DIR_OUT/$FILENAME.pdf"

vim SS_report.tex
pdflatex SS_report.tex > tmp
rm *.aux *.log tmp
open "SS_report.pdf"

