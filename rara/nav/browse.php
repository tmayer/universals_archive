<?php

include("../inc/functions.php");
global $dbconn;

if(!($dbconn = connectToDB('Rara'))){
	exit('<p>Connection refused to database server.</p>');
}

$num = getVariable('number');

if($entry_id = getVariable('entry_id') AND !(getVariable('number'))){
	$sql_id = "SELECT * FROM archive WHERE entry_id='$entry_id';";
	$result_id = mysql_query($sql_id,$dbconn);
	$num = mysql_result($result_id,0,number);
}

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

$sql = "SELECT *
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
