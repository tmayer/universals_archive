<?php

include("../inc/functions.php");

if($_POST['sent']){
	
	$replacee = getVariable('replacee');
	$replacer = getVariable('replacer');
	$table = getVariable('field');
	
	$dbconn = connectToDB('Rara');
	$result = mysql_query("SELECT * FROM $table", $dbconn);
	$totalNumber = mysql_num_rows($result);
	
	for($i=0; $i<$totalNumber; $i++){
		$number = mysql_result($result,$i,number);
		$phenomenon = mysql_result($result,$i,phenomenon);
		$found = mysql_result($result,$i,found);
		$source = mysql_result($result,$i,source);
		
		$phenomenonRev = preg_replace($replacee,$replacer,$phenomenon);
		$foundRev = preg_replace($replacee,$replacer,$found);
		$sourceRev = preg_replace($replacee,$replacer,$source);
		
		$sqlChange = "UPDATE $table SET phenomenon='$phenomenonRev',";
		$sqlChange .= "found='$foundRev',";
		$sqlChange .= "source='$sourceRev'";
		$sqlChange .= "WHERE number='$number'";
		$saveResult = mysql_query($sqlChange,$dbconn);
	}
	
}
else{

echo <<<FORMREPLACE

<form action="$PHP_SELF" method="POST">
<table border="0">
<tr>
<td>Find</td><td><input type="text" name="replacee" size="30"></td>
</tr><tr>
<td>Replace by</td><td><input type="text name="replacer" size="30"></td>
</tr><tr>
<td>&nbsp;</td><td>
<select name="field" size="1">
<option value="" SELECTED>--- select table ---</option>
<option value="archive">archive</option>
<option value="counter">counter</option>
<option value="comment">comment</otpion>
</select>
</td>
</tr><tr>
<td><input type="submit" name="sent" value="Replace!">
<input type="reset"></td>
</tr>
</table>
</form>

FORMREPLACE;
	
}

?>
