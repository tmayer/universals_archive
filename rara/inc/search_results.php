<?php

global $dbconn, $sid, $original, $standardized, $formula, $keywords,
	$domain, $type, $status, $quality, $basis, $source, $counterexamples,
	$comments, $boolean;


$sid = session_id();

if(!($dbconn = connectToDB('Rara'))){
	exit('<p class="error">Connection refused to database server.</p>');
}

if($_POST['phenomenon'] OR $_POST['found'] OR $_POST['domain'] OR $_POST['subdomain']
	 OR $_POST['keywords'] OR $_POST['type'] OR $_POST['violates'] OR $_POST['source']
	  OR $_POST['comment']){
	
$phenomenon = $_POST['phenomenon'];
$found = $_POST['found'];
$domain = $_POST['domain'];
$subdomain = $_POST['subdomain'];
$keywords = $_POST['keywords'];
$type = $_POST['type'];
$violates = $_POST['violates'];
$source = $_POST['source'];
$comment = $_POST['comment'];
$boolean = $_POST['boolean'];

if($boolean == 'or'){	
$sql = "SELECT * FROM archive WHERE MATCH (phenomenon) AGAINST ('$phenomenon' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (found) AGAINST ('$found' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (domain) AGAINST ('$domain' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (subdomain) AGAINST ('$subdomain' IN BOOLEAN MODE) 
	UNION
	SELECT * FROM archive WHERE MATCH (keywords) AGAINST ('$keywords' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (type) AGAINST ('$type' IN BOOLEAN MODE)
	UNION
	SELECT * FROM archive WHERE MATCH (violates) AGAINST ('$violates' IN BOOLEAN MODE)
	UNION
	SELECT a.* FROM archive AS a, comment AS c WHERE a.number = c.entry AND MATCH (c.text) AGAINST ('$comment' IN BOOLEAN MODE)
	UNION 
	SELECT * FROM archive WHERE MATCH (source) AGAINST ('$source' IN BOOLEAN MODE) ORDER BY number ASC";
}
else{
	$commentExists = "";
	if($comment != ""){
		$commentExists = ",comment";
	}
	$sql = "SELECT archive.* FROM archive$commentExists WHERE ";
	
	if($phenomenon != ""){
		$sql .= "MATCH (archive.phenomenon) AGAINST ('$phenomenon' IN BOOLEAN MODE) AND ";
	}
	if($found != ""){
		$sql .= "MATCH (archive.found) AGAINST ('$found' IN BOOLEAN MODE) AND ";
	}
	if($domain != ""){
		$sql .= "MATCH (archive.domain) AGAINST ('$domain' IN BOOLEAN MODE) AND ";
	}
	
	if($subdomain != ""){
		$sql .= "MATCH (archive.subdomain) AGAINST ('$subdomain' IN BOOLEAN MODE) AND ";
	}
	
	if($keywords != ""){
		$sql .= "MATCH (archive.keywords) AGAINST ('$keywords' IN BOOLEAN MODE) AND ";
	}
	if($type != ""){
		$sql .= "MATCH (archive.type) AGAINST ('$type' IN BOOLEAN MODE) AND ";
	}
	if($violates != ""){
		$sql .= "MATCH (archive.violates) AGAINST ('$violates' IN BOOLEAN MODE) AND ";
	}
	if($source != ""){
		$sql .= "MATCH (archive.source) AGAINST ('$source' IN BOOLEAN MODE) AND ";
	}
	if($comment != ""){
		$sql .= "archive.number=comment.entry AND MATCH (comment.text) AGAINST ('$comment' IN BOOLEAN MODE) AND ";
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
<input type="hidden" name="phenomenon" value='$phenomenon'>
<input type="hidden" name="found" value='$found'>
<input type="hidden" name="domain" value='$domain'>
<input type="hidden" name="subdomain" value='$subdomain'>
<input type="hidden" name="keywords" value='$keywords'>
<input type="hidden" name="type" value='$type'>
<input type="hidden" name="violates" value='$violates'>
<input type="hidden" name="source" value='$source'>
<input type="hidden" name="comment" value='$comment'>
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
