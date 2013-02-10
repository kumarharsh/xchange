<?php 

echo "<script type=\"text/javascript\" src=\"javascript/figs.js\"></script>";

header('Content-type: text/xml');
echo "<div id=\"holder\" style=\"width:800px; margin-top:5%;\">";
echo "<div id=\"topBar\">Market History</div>";
echo "<div style=\"overflow:auto; height:500px;\">";

$file = fopen("$PATH_WEB/include/currencyInfo.txt","r");
$data = fgets($file);
$data = explode(",",$data);
$len = count($data);
$i=0;
echo "<select id=\"currency\">";
while($i<$len)
{
	echo "<option value=\"$data[$i]\">$data[$i]</option>";
	$i++;
}
echo "</select>";

echo "<select id=\"duration\">
	  <option value=\"1d\">One Day</option>
	  <option value=\"5d\">Five Days</option>
	  <option value=\"3m\">Three Months</option>
      <option value=\"1y\">One Year</option></select>";

echo "<input name=\"\" type=\"button\" id=\"submit\" value=\"Submit\" onClick=\"getImage();\" />";

echo "<div id='image'></div>";
echo "</div>";
echo "</div>";
?>