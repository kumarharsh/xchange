

#wget -O log http://download.finance.yahoo.com/d/quotes.csv?s=USDINR=X+USDGBP=X+USDEUR=X+USDCAD=X+USDJPY=X+USDCHF=X+USDAUD=X+USDNZD=X+USDCNY=X+USDSGD=X\&f=nba

OUTPUT_FILE="log";

if [ "$#" -le "0" ]
then
	echo "INVALID USAGE";
	exit;
fi

s="s=";

while [ "$1" != "" ]; do
	s="${s}USD$1=X+";
	shift;
done

echo $s


echo "wget -O $OUTPUT_FILE http://download.finance.yahoo.com/d/quotes.csv?s=$s\&f=nba"

`wget -O $OUTPUT_FILE http://download.finance.yahoo.com/d/quotes.csv?$s\&f=nba`
	
	
