<?php

include("../inc/functions.php");

if($_POST['sent']){
	
	$replacee = getVariable('replacee');
	$replacer = getVariable('replacer');
	$table = getVariable('field');
	
	$dbconn = connectToDB('Rara');
	$result = mysql_query("SELECT * FROM $table", $dbconn);
	$totalNumber = mysql_num_rows($result);
	
	for($i=0; $i++; $i<$totalNumber){
		$number = mysql_result($result,$i,number);
		$original = mysql_result($result,$i,original);
		$standardized = mysql_result($result,$i,standardized);
		$formula = mysql_result($result,$i,formula);
		$basis = mysql_result($result,$i,basis);
		$source = mysql_result($result,$i,source);
		
		$originalRev = preg_replace($replacee,$replacer,$original);
		$standardizedRev = preg_replace($replacee,$replacer,$standardized);
		$formulaRev = preg_replace($replacee,$replacer,$formula);
		$basisRev = preg_replace($replacee,$replacer,$basis);
		$sourceRev = preg_replace($replacee,$replacer,$source);
		
		$sqlChange = "UPDATE $table SET original='$originalRev',";
		$sqlChange .= "standardized='$standardizedRev',";
		$sqlChange .= "formula='$formulaRev',basis='$basisRev'";
		$sqlChange .= "source='$sourceRev'";
		$sqlChange .= "WHERE number='$number'";
		$saveResult = mysql_query($sqlChange,$dbconn);
		if($saveResult){	
			$msq = "Your changes have been saved!";
			messageHeader($msg,"confirm","nav/browse.php");
			dumpDatabase();
		}
		else{
			$msq = "Error in saving the changes!";
			messageHeader($msg,"error","nav/browse.php");
		}
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
