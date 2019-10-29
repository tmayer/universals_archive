<?php

include("../inc/functions.php");
global $dbconn;

if(!($dbconn = connectToDB())){
	exit('<p>Connection refused to database server.</p>');
}

$num = getVariable('number');
if(getVariable('numIncr')){
	$num++;
}
if(getVariable('numDecr')){
	$num--;
}
$totalNumber = mysql_num_rows(mysql_query("SELECT * from archive", $dbconn));
if($num > $totalNumber){
	$num = $totalNumber;
}
if($num < 1){
	$num = 1;
}

htmlHeader("browse",$num,"true",$totalNumber);

//panel($num,$totalNumber);

$sql = "SELECT number,original,standardized,formula,keywords,domain,type,status,
				quality,basis,source,counterexamples,comments
				FROM archive WHERE number=$num";
$result = mysql_query($sql,$dbconn);

if($result){
	displayResults($result);
}
else{
	echo "<p",mysql_error($dbconn),"</p>";
}

mysql_close($dbconn);

htmlFooter();

?>
