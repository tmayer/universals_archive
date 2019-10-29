<?php

include("../inc/functions.php");
$sid = session_id();

$userLoggedOn = $_SERVER['PHP_AUTH_USER'];
$field = getVariable("field");
$id = getVariable("id");
$field_id = $field . "_id";
$number = getVariable("number");

$dbconn = connectToDB();

if($_SESSION['userLoggedOn']){

if($_POST['sent']){
	if($text = $_POST['text']){
		$sqlChange = "UPDATE $field SET text='$text'";
		$sqlChange .= " WHERE $field_id='$id'";
		$saveResult = mysql_query($sqlChange,$dbconn);
		//echo "<p class=\"confirm\">Your changes have been saved!</p>";
		$msg = "Your changes have been saved!";
		messageHeader($msg,"confirm","nav/browse.php?number=$number&amp;PHPSESSID=$sid");
		dumpDatabase();
	}
	else{
		//echo "<p class=\"error\">An error occurred while saving the entry!</p>";
		$msg = "An error occurred while saving the entry!";
		messageHeader($msg,"error","nav/browse.php?number=$number&amp;PHPSESSID=$sid");
	}
}
elseif($_POST['delete']){
	$delete = "DELETE FROM $field WHERE $field_id=$id";
	$resultDel = mysql_query($delete,$dbconn);
	$entries = mysql_query("SELECT * FROM $field WHERE entry='$id' ORDER BY date_post",$dbconn);
	$numberOfEntries = mysql_num_rows($entries);
	if($numberOfEntries > 0){
		$newestEntryID = mysql_result($entries,$numberOfEntries-1,$field_id);
		$changeEdit = "UPDATE $field SET editable='true' WHERE $field_id=$newestEntryID";
		$resultEditable = mysql_query($changeEdit,$dbconn);
	}
	if($resultDel){
		//echo "<p class=\"confirm\">Your entry has successfully been deleted.</p>";
		$msg = "Your entry has successfully been deleted. <br>";
		if($resultEditable || $numberOfEntries == 0){
			//echo "<p class=\"confirm\">Entries have been updated.</p>";
			$msg .= "All entries have been updated.";
		}
		else{
			//echo "<p class=\"error\">Error in updating the entries.</p>";
			$msg .= "An error occurred in updating the entries.";
		}
		dumpDatabase();
		messageHeader($msg,"confirm","nav/browse.php?number=$number&amp;PHPSESSID=$sid");
	}
	else{
		//echo "<p class=\"error\">Error in deleting the entry.</p>";
		$msg = "An error occurred while deleting the entry.";
		messageHeader($msg,"error","nav/browse.php?number=$number&amp;PHPSESSID=$sid");
	}
}
else{
	
	htmlHeader("browse",$number,"true");
	//echo "</tr></table><br>\n";
	
	$edit = "SELECT * FROM $field WHERE $field_id=$id";
	$result = mysql_query($edit,$dbconn);
	$text = mysql_result($result,0,text);
	//$user = mysql_result($result,0,user);
	//$entry = mysql_result($result,0,entry);
	if($result){
		echo <<<EDITFORM
		<table style="background-color:#f6f6f6; width:800px;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32" /></td>
		<td class="blanco_2">Edit $field for entry no. $number&nbsp;</td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32" /></td>
	</tr>
</table>
<table style="background-color:#f6f6f6; width:800px;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>
		
<form action="$PHP_SELF" method="POST">
<table>
<tr>
	<td><textarea name="text" cols="100" rows=20">$text</textarea>
	</td>
</tr>
<tr>
	<td><input type="submit" name="sent" value="Save changes">
			<input type="submit" name="delete" value="Delete entry">
	</td>
</tr>
</table>
<input type="hidden" name="field" value="$field">
<input type="hidden" name="id" value="$id">
<input type="hidden" name="num" value="$num">
<input type="hidden" name="PHPSESSID" value="$sid">
</form>

</td>
		<td class="blanco_6"></td>
	</tr>
	<tr>
		<td class="blanco_7"></td>
		<td class="blanco_8">&nbsp;</td>
		<td class="blanco_9"></td>
	</tr>
</table>
EDITFORM;

	htmlFooter();
	}
	else{
		//echo "<p class=\"error\">Error in editing post!</p>";
		$msg = "An error occurred while editing the post.";
		messageHeader($msg,"error","nav/browse.php?number=$number&amp;PHPSESSID=$sid");
	}
}
}

else{
	$msg = "Your session has expired. <br>Please log in again.";
	messageHeader($msg,"error","edit/user.php");
}

mysql_close($dbconn);

?>
