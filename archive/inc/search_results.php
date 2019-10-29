<?php

global $dbconn, $sid, $original, $standardized, $formula, $keywords,
	$domain, $type, $status, $quality, $basis, $source, $counterexamples,
	$comments, $boolean;


$sid = session_id();

if(!($dbconn = connectToDB())){
	exit('<p class="error">Connection refused to database server.</p>');
}

if($_POST['keywords'] OR $_POST['original'] OR $_POST['standardized'] OR $_POST['formula']
	 OR $_POST['domain'] OR $_POST['type'] OR $_POST['status'] OR $_POST['quality']
	  OR $_POST['basis'] OR $_POST['source'] OR $_POST['counterexamples']
	   OR $_POST['comments']){
	
$original = $_POST['original'];
$standardized = $_POST['standardized'];
$formula = $_POST['formula'];
$keywords = $_POST['keywords'];
$domain = $_POST['domain'];
$type = $_POST['type'];
$status = $_POST['status'];
$quality = $_POST['quality'];
$basis = $_POST['basis'];
$source = $_POST['source'];
$counterexamples = $_POST['counterexamples'];
$comments = $_POST['comments'];
$boolean = $_POST['boolean'];

if($boolean == 'or'){	
$sql = "SELECT * FROM archive WHERE MATCH (original) AGAINST ('$original' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (standardized) AGAINST ('$standardized' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (formula) AGAINST ('$formula' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (keywords) AGAINST ('$keywords' IN BOOLEAN MODE) 
	UNION
	SELECT * FROM archive WHERE MATCH (domain) AGAINST ('$domain' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (type) AGAINST ('$type' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (status) AGAINST ('$status' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (basis) AGAINST ('$basis' IN BOOLEAN MODE)
	UNION
	SELECT a.* FROM archive AS a, counter AS c WHERE a.number = c.entry AND MATCH (c.text) AGAINST ('$counterexamples' IN BOOLEAN MODE)
	UNION
	SELECT a.* FROM archive AS a, comment AS c WHERE a.number = c.entry AND MATCH (c.text) AGAINST ('$comments' IN BOOLEAN MODE)	
	UNION 
	SELECT * FROM archive WHERE MATCH (source) AGAINST ('$source' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (quality) AGAINST ('$quality' IN BOOLEAN MODE) ORDER BY number ASC";
}
else{
	$counterTable = "";
	if($counterexamples != ""){
		$counterTable = ",counter";
	}
	$commentTable = "";
	if($comments != ""){
		$commentTable = ",comment";
	}
	$sql = "SELECT archive.* FROM archive$counterTable$commentTable WHERE ";
	
	if($original != ""){
		$sql .= "MATCH (archive.original) AGAINST ('$original' IN BOOLEAN MODE) AND ";
	}
	if($standardized != ""){
		$sql .= "MATCH (archive.standardized) AGAINST ('$standardized' IN BOOLEAN MODE) AND ";
	}
	if($formula != ""){
		$sql .= "MATCH (archive.formula) AGAINST ('$formula' IN BOOLEAN MODE) AND ";
	}
	
	if($keywords != ""){
		$sql .= "MATCH (archive.keywords) AGAINST ('$keywords' IN BOOLEAN MODE) AND ";
	}
	
	if($domain != ""){
		$sql .= "MATCH (archive.domain) AGAINST ('$domain' IN BOOLEAN MODE) AND ";
	}
	if($type != ""){
		$sql .= "MATCH (archive.type) AGAINST ('$type' IN BOOLEAN MODE) AND ";
	}
	if($status != ""){
		$sql .= "MATCH (archive.status) AGAINST ('$status' IN BOOLEAN MODE) AND ";
	}
	
	if($quality != ""){
		$sql .= "MATCH (archive.quality) AGAINST ('$quality' IN BOOLEAN MODE) AND ";
	}
	
	if($basis != ""){
		$sql .= "MATCH (archive.basis) AGAINST ('$basis' IN BOOLEAN MODE) AND ";
	}
	if($source != ""){
		$sql .= "MATCH (archive.source) AGAINST ('$source' IN BOOLEAN MODE) AND ";
	}
	if($counterexamples != ""){
		$sql .= "archive.number=counter.entry AND MATCH (counter.text) AGAINST ('$counterexamples' IN BOOLEAN MODE) AND ";
	}
	if($comments != ""){
		$sql .= "archive.number=comment.entry AND MATCH (comment.text) AGAINST ('$comments' IN BOOLEAN MODE) AND ";
	}
	$sql .= "1 ORDER BY archive.number ASC";
}

$result = mysql_query($sql,$dbconn);

if($result){
	$totalNumber = mysql_num_rows($result);
	if($totalNumber == 0){
		$msg = "Your query matched no results!";
		messageHeader($msg,"error","nav/search.php?PHPSESSID=$sid","");
	}
	else{
		$num = getVariable('number');
		if(getVariable('numIncr')){
			$num++;
		}
		if(getVariable('numDecr')){
			$num--;
		}
		if($num > $totalNumber){
			$num = $totalNumber;
		}
		if($num < 1){
			$num = 1;
		}
		$numInt = $num - 1;
		$number =  mysql_result($result,$numInt,number);

		
htmlHeader("search",$num,"true",$totalNumber,$number);

echo <<<FORMANSWER
<input type="hidden" name="original" value='$original'>
<input type="hidden" name="standardized" value='$standardized'>
<input type="hidden" name="formula" value='$formula'>
<input type="hidden" name="keywords" value='$keywords'>
<input type="hidden" name="domain" value='$domain'>
<input type="hidden" name="type" value='$type'>
<input type="hidden" name="status" value='$status'>
<input type="hidden" name="quality" value='$quality'>
<input type="hidden" name="basis" value='$basis'>
<input type="hidden" name="source" value='$source'>
<input type="hidden" name="counterexamples" value='$counterexamples'>
<input type="hidden" name="comments" value='$comments'>
<input type="hidden" name="boolean" value='$boolean'>
<input type="hidden" name="sent" value='Submit Query'>
<input type="hidden" name="PHPSESSID" value='$sid'>
</form>
<!-- End of panel -->\n\n
FORMANSWER;

echo "</tr></table><br>\n";


$numInt = $num - 1;

displayResults($result, $numInt);

htmlFooter();

}
} else {
	$msg = "Connection error: <br>".mysql_error($dbconn);
	messageHeader($msg,"error","nav/search.php?PHPSESSID=$sid","");
	//echo "<p>",mysql_error($dbconn), "</p>";
}
	
}
	
else{
	$msg = "Your query is not complete!";
	messageHeader($msg,"error","nav/search.php?PHPSESSID=$sid","");
	//echo "<p>Query not complete!</p>\n";
}


mysql_close($dbconn);

?>
