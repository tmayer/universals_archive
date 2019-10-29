<?php

include("../inc/functions.php");
global $dbconn;

if(!($dbconn = connectToDB('th_mayer_de'))){
	exit('<p>Connection refused to database server.</p>');
}

$num = getVariable('number');

if($entry_id = getVariable('entry_id') AND !(getVariable('number'))){
	$sql_id = "SELECT * FROM archive WHERE entry_id='$entry_id';";
	$result_id = $dbconn->query($sql_id);
	$num = mysqli_result($result_id,0,"number");
}

if(getVariable('numIncr')){
	$num++;
}
if(getVariable('numDecr')){
	$num--;
}
$totalNumber = mysqli_num_rows($dbconn->query("SELECT * from rara"));
if($num > $totalNumber){
	$num = $totalNumber;
}
if($num < 1){
	$num = 1;
}

htmlHeader("browse",$num,"true",$totalNumber);

//panel($num,$totalNumber);

$sql = "SELECT *
				FROM rara WHERE number=$num";
$result = $dbconn->query($sql);

if($result){
	displayResults($result);
}
else{
	echo "<p",mysqli_error($dbconn),"</p>";
}

mysqli_close($dbconn);

htmlFooter();

?>
