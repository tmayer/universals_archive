<?php

include("../inc/functions.php");

$user = $_SESSION['userLoggedOn'];
$num = getVariable("num");
$id = get_id($num);
$field = getVariable("field");
$sid = session_id();

if($field == "counter"){
	$fieldExt = "counterexample";
}
else{
	$fieldExt = $field;
}

//htmlHeader($num,"edit");

if($_SESSION['userLoggedOn']){

if($_POST['sent']){
	if(!$text = $_POST['text']){
		//echo "<p class=\"error\">The text field must not be empty!</p>";
		$msg = "The text field must not be empty!";
		messageHeader($msg,"error","edit/submit.php?field=$field&amp;num=$num&amp;PHPSESSID=$sid");
	}
	else{
		$dbconn = connectToDB();
		$update = "UPDATE $field SET editable='false' WHERE entry=$id";
		$resultEdit = mysql_query($update,$dbconn);
		$result = mysql_query("INSERT INTO $field (entry,text,user,date_post) VALUES($id,\"$text\",\"$user\",NOW())",$dbconn);
		if($result){
			if($resultEdit){
				//echo "<p class=\"confirm\">Entry submitted</p>";
				if(dumpDatabase()){
					$msg = "Entry submitted";
					messageHeader($msg,"confirm","nav/browse.php?number=$num&amp;PHPSESSID=$sid");
				}
				else{
					$msg = "Entry submitted but database dump failed";
					messageHeader($msg,"confirm","nav/browse.php?number=$num&amp;PHPSESSID=$sid");
				}
				//mailNotice("New $fieldExt",$num,$user,$text);
			}
			else{
				//echo "<p class=\"error\">Error in updating table!</p>";
				$msg = "Error in updating table!";
				messageHeader($msg,"error","nav/browse.php?number=$num&amp;PHPSESSID=$sid");
			}
		}
		else{
			//echo "<p class=\"error\">Error in submitting entry!</p>";
			$msg = "Error in submitting entry!";
			messageHeader($msg,"error","nav/browse.php?number=$num&amp;PHPSESSID=$sid");
		}
	}
}
elseif($num != "" && $field != ""){

htmlHeader("browse",$num);
	echo <<<TEXTFIELD
	<table style="background-color:#f6f6f6; width:800px;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32" /></td>
		<td class="blanco_2">$fieldExt by $user for entry no. $num:&nbsp;</td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32" /></td>
	</tr>
</table>
<table style="background-color:#f6f6f6; width:800px;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>
		

<form action="$PHP_SELF" method="POST">
<table class="comment">
<tr><td>
	<textarea name="text" rows="20" cols="100"></textarea>
</td></tr>
<tr><td>
	<input type="submit" name="sent" value="Post">
	<input type="reset">
	<input type="hidden" name="PHPSESSID" value="$sid">
</td></tr>
</table>

</td>
		<td class="blanco_6"></td>
	</tr>
	<tr>
		<td class="blanco_7"></td>
		<td class="blanco_8">&nbsp;</td>
		<td class="blanco_9"></td>
	</tr>
</table>
</form>\n
TEXTFIELD;
}
else{
	$msg = "Some important information is missing.";
	messageHeader($msg,"error","nav/browse.php");
}

}
else{
	$msg = "Your session has expired. <br>Please log in again.";
	messageHeader($msg,"error","edit/user.php");
}

?>
