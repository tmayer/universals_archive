<?php

include("../inc/functions.php");

$dbconn = connectToDB('Rara');

$number = getVariable('number');
if(getVariable('numIncr')){
	$number++;
}
if(getVariable('numDecr')){
	$number--;
}
$totalNumber = mysql_num_rows(mysql_query("SELECT * from archive", $dbconn));
if($number > $totalNumber){
	$number = $totalNumber;
}
if($number < 1){
	$number = 1;
}

$sid = session_id();

if($_SESSION['userLoggedOn']){
	if($_SESSION['userStatus'] == 'admin'){

if($_POST['edited']){
	$phenomenonChanged = $_POST['phenomenon'];
	$foundChanged = $_POST['found'];
	$domainChanged = $_POST['domain'];
	$subdomainChanged = $_POST['subdomain'];
	$keywordsChanged = $_POST['keywords'];
	$typeChanged = $_POST['type'];
	$violatesChanged = $_POST['violates'];
	$sourceChanged = $_POST['source'];
	$sqlChange = "UPDATE archive SET phenomenon='$phenomenonChanged',";
	$sqlChange .= "found='$foundChanged',";
	$sqlChange .= "domain='$domainChanged',subdomain='$subdomainChanged',";
	$sqlChange .= "keywords='$keywordsChanged',type='$typeChanged',violates='$violatesChanged',";
	$sqlChange .= "source='$sourceChanged'";
	$sqlChange .= " WHERE number='$number'";
	$saveResult = mysql_query($sqlChange,$dbconn);
	if($saveResult){
		$msg = "Your changes have been saved!";
		messageHeader($msg,"confirm","edit/editEntry.php?PHPSESSID=$sid&amp;number=$number");
		dumpDatabase();
	}
	else{
		$msg = "Error in saving the changes!";
		messageHeader($msg,"error","edit/editEntry.php?PHPSESSID=$sid&amp;number=$number");
	}
}
else{
	
	htmlHeader("edit",$number,"true",$totalNumber);
	
	$edit = "SELECT * FROM archive WHERE number=$number";
	$result = mysql_query($edit,$dbconn);

	displayEditResults($result,$number);


htmlFooter();
}


	}
	else{
		$msg = "You are not allowed to edit the entries.";
		messageHeader($msg,"error","nav/browse.php");
	}
}
else{
	$msg = "Your session has expired. <br>Please log in again.";
	messageHeader($msg,"error","edit/user.php");
}




?>
