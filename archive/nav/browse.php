<?php

include("../inc/functions.php");
global $dbconn;
global $num;

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
$totalNumber = mysqli_num_rows($dbconn->query("SELECT * from archive"));
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
