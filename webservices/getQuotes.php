<?php
$DATA_FILE="./data/log";

//<responseData>
//	<error>Error MSG</error>
//	<quote id="USD">
//		<bid>3.32</bid>
//		<ask>34.73</ask>
//	</quote>
//</responseData>

header('Content-type: text/xml');
echo "<responseData>";

function reportError( $msg )
{
    echo "<error>$msg</error>";
    echo "</responseData>";
    exit;
}

function search_in_array( $ary, $value )
{
    $count = count( $ary );
    for( $i=0 ; $i<$count ; $i++ )
    {
	if( strcasecmp( $ary[$i], $value) == 0 )
	    return true;
    }
    return false;
}

$handle = fopen($DATA_FILE, "r");
if( !$handle )
{
    reportError( "Unable to get Forex Data" );
}


if( !isset( $_REQUEST['data'] ) )
{
    echo "<error>#</error>";
    while( ($data= fgetcsv( $handle, 1000, "," )) !== FALSE )
    {
	$currency_id_ary=explode( " ", $data[0] );
	$currency_id=$currency_id_ary[2];

	echo "<quote id=\"$currency_id\">";
	echo "<ask>".$data[1]."</ask>";
	echo "<bid>".$data[2]."</bid>";
	echo "</quote>";
    }

}
else
{
    echo "<error>#</error>";
    $required_currency = explode( " ", $_REQUEST['data'] );

    while( ($data= fgetcsv( $handle, 1000, "," )) !== FALSE )
    {
	$currency_id_ary=explode( " ", $data[0] );
	$currency_id=$currency_id_ary[2];

	if( search_in_array( $required_currency, $currency_id ) )  //if found then output
	{
	    echo "<quote id=\"$currency_id\">";
	    echo "<ask>".$data[1]."</ask>";
	    echo "<bid>".$data[2]."</bid>";
	    echo "</quote>";
	}
    }

}





echo "</responseData>";
