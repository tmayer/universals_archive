<?php

include("../inc/functions.php");

$dbconn = connectToDB();

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
	$originalChanged = $_POST['original'];
	$standardizedChanged = $_POST['standardized'];
	$formulaChanged = $_POST['formula'];
	$keywordsChanged = $_POST['keywords'];
	$domainChanged = $_POST['domain'];
	$typeChanged = $_POST['type'];
	$statusChanged = $_POST['status'];
	$qualityChanged = $_POST['quality'];
	$basisChanged = $_POST['basis'];
	$sourceChanged = $_POST['source'];
	$sqlChange = "UPDATE archive SET original='$originalChanged',";
	$sqlChange .= "standardized='$standardizedChanged',";
	$sqlChange .= "formula='$formulaChanged',keywords='$keywordsChanged',";
	$sqlChange .= "domain='$domainChanged',type='$typeChanged',status='$statusChanged',";
	$sqlChange .= "quality='$qualityChanged',basis='$basisChanged',source='$sourceChanged'";
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
elseif($_POST['delete']){
	$sqlDelete = "DELETE FROM archive WHERE entry_id='$entry_id';";
	//$deleteResult = mysql_query($sqlDelete,$dbconn);
	// there's much more to be done here! Update comments and counterex.
	// Update higher numbered entries
	if($deleteResult){
		$msg = "The entry has been deleted!";
		messageHeader($msg,"confirm","nav/browse.php","");
	}
	else{
		$msg = "Error in deleting the entry!";
		messageHeader($msg,"error","nav/browse.php","");
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
