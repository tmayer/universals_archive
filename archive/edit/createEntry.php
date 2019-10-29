<?php

include("../inc/functions.php");

$dbconn = connectToDB();
$sid = session_id();

if($_SESSION['userLoggedOn']){
	if($_SESSION['userStatus'] == 'admin'){

if($_POST['create']){
	if($_POST['original'] AND $_POST['source']){
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
	$numberChanged = $_POST['number'];
	$sqlChange = "INSERT INTO archive SET original='$originalChanged',";
	$sqlChange .= "standardized='$standardizedChanged',";
	$sqlChange .= "formula='$formulaChanged',keywords='$keywordsChanged',";
	$sqlChange .= "domain='$domainChanged',type='$typeChanged',status='$statusChanged',";
	$sqlChange .= "quality='$qualityChanged',basis='$basisChanged',source='$sourceChanged',";
	$sqlChange .= " number='$number';";
	$saveResult = mysql_query($sqlChange,$dbconn);
	if($saveResult){
		$msg = "Your entry has been submitted!";
		messageHeader($msg,"confirm","edit/createEntry.php?PHPSESSID=$sid&amp;number=$number");
		dumpDatabase();
	}
	else{
		$msg = "Error in submitting the entry!";
		messageHeader($msg,"error","edit/createEntry.php?PHPSESSID=$sid&amp;number=$number");
	}
	}
	else{
		$msg = "Fields 'Original' and 'Source' must not be empty!";
		messageHeader($msg,"error","edit/createEntry.php?PHPSESSID=$sid&amp;number=$number");
	}
}
else{
	
	htmlHeader("edit",$number,"true",$totalNumber);
	
	$sql = "SELECT number FROM archive ORDER BY number DESC;";
	$result = mysql_query($sql,$dbconn);
	$max = mysql_result($result,0,number);
	$max++;
	
	echo <<<BLANCOHEADER
<!-- Display Results Begin -->
<table class="blanco" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32" /></td>
		<td class="blanco_2">&nbsp;</td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32" /></td>
	</tr>
</table>
<table class="blanco" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>
BLANCOHEADER;

		echo <<<TABLEEND
<form action="$PHP_SELF" method="POST">
<table>
	<tr><td>
<input type="submit" name="create" value="Create entry!">
<input type="hidden" name="number" value="$max"><span style="text-decoration:blink; color:red; ">!</span></td></tr>
</table>
<br>
<table class="displayTable">
	<tr><td width="175" class="odd">&nbsp;<b>Number</b>&nbsp;</td>
		<td class="odd">$max</td><tr>
	<tr><td class="even">&nbsp;<b>Original</b>&nbsp;</td>
		<td class="even"><textarea name="original" cols="90" rows="3"></textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Standardized</b>&nbsp;</td>
		<td class="odd"><textarea name="standardized" cols="90" rows="3"></textarea></td><tr>
	<tr><td class="even">&nbsp;<b>Formula</b>&nbsp;</td>
		<td class="even"><textarea name="formula" cols="90" rows="1"></textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Keywords</b>&nbsp;</td>
		<td class="odd"><textarea name="keywords" cols="90" rows="1"></textarea></td><tr>
	<tr><td class="even">&nbsp;<b>Domain</b>&nbsp;</td>
		<td class="even"><textarea name="domain" cols="90" rows="1"></textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Type</b>&nbsp;</td>
		<td class="odd"><textarea name="type" cols="90" rows="1"></textarea></td><tr>
	<tr><td class="even">&nbsp;<b>Status</b>&nbsp;</td>
		<td class="even"><textarea name="status" cols="90" rows="1"></textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Quality</b>&nbsp;</td>
		<td class="odd"><textarea name="quality" cols="90" rows="1"></textarea></td><tr>
	<tr><td class="even">&nbsp;<b>Basis</b>&nbsp;</td>
		<td class="even"><textarea name="basis" cols="90" rows="1"></textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Source</b>&nbsp;</td>
		<td class="odd"><textarea name="source" cols="90" rows="1"></textarea></td><tr>
	 
TABLEEND;
	echo "</table></form><br>";
	
	echo <<<BLANCOFOOTER
		</td>
		<td class="blanco_6"></td>
	</tr>
	<tr>
		<td class="blanco_7"></td>
		<td class="blanco_8">&nbsp;</td>
		<td class="blanco_9"></td>
	</tr>
</table>
BLANCOFOOTER;
		
	echo "\n<!-- Display Fields End -->\n";


htmlFooter();
}


	}
	else{
		$msg = "You are not allowed to create an entry.";
		messageHeader($msg,"error","nav/browse.php");
	}
}
else{
	$msg = "Your session has expired. <br>Please log in again.";
	messageHeader($msg,"error","edit/user.php");
}




?>
