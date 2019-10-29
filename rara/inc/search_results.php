<?php

global $dbconn, $sid, $original, $standardized, $formula, $keywords,
	$domain, $type, $status, $quality, $basis, $source, $counterexamples,
	$comments, $boolean;


$sid = session_id();

if(!($dbconn = connectToDB('th_mayer_de'))){
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
$sql = "SELECT * FROM rara WHERE MATCH (phenomenon) AGAINST ('$phenomenon' IN BOOLEAN MODE)
	UNION
	SELECT * FROM rara WHERE MATCH (found) AGAINST ('$found' IN BOOLEAN MODE)
	UNION
	SELECT * FROM rara WHERE MATCH (domain) AGAINST ('$domain' IN BOOLEAN MODE)
	UNION
	SELECT * FROM rara WHERE MATCH (subdomain) AGAINST ('$subdomain' IN BOOLEAN MODE) 
	UNION
	SELECT * FROM rara WHERE MATCH (keywords) AGAINST ('$keywords' IN BOOLEAN MODE)
	UNION
	SELECT * FROM rara WHERE MATCH (type) AGAINST ('$type' IN BOOLEAN MODE)
	UNION
	SELECT * FROM rara WHERE MATCH (violates) AGAINST ('$violates' IN BOOLEAN MODE)
	UNION
	SELECT a.* FROM rara AS a, comment AS c WHERE a.number = c.entry AND MATCH (c.text) AGAINST ('$comment' IN BOOLEAN MODE)
	UNION 
	SELECT * FROM rara WHERE MATCH (source) AGAINST ('$source' IN BOOLEAN MODE) ORDER BY number ASC";
}
else{
	$commentExists = "";
	if($comment != ""){
		$commentExists = ",comment";
	}
	$sql = "SELECT rara.* FROM rara$commentExists WHERE ";
	
	if($phenomenon != ""){
		$sql .= "MATCH (rara.phenomenon) AGAINST ('$phenomenon' IN BOOLEAN MODE) AND ";
	}
	if($found != ""){
		$sql .= "MATCH (rara.found) AGAINST ('$found' IN BOOLEAN MODE) AND ";
	}
	if($domain != ""){
		$sql .= "MATCH (rara.domain) AGAINST ('$domain' IN BOOLEAN MODE) AND ";
	}
	
	if($subdomain != ""){
		$sql .= "MATCH (rara.subdomain) AGAINST ('$subdomain' IN BOOLEAN MODE) AND ";
	}
	
	if($keywords != ""){
		$sql .= "MATCH (rara.keywords) AGAINST ('$keywords' IN BOOLEAN MODE) AND ";
	}
	if($type != ""){
		$sql .= "MATCH (rara.type) AGAINST ('$type' IN BOOLEAN MODE) AND ";
	}
	if($violates != ""){
		$sql .= "MATCH (rara.violates) AGAINST ('$violates' IN BOOLEAN MODE) AND ";
	}
	if($source != ""){
		$sql .= "MATCH (rara.source) AGAINST ('$source' IN BOOLEAN MODE) AND ";
	}
	if($comment != ""){
		$sql .= "rara.number=rara_comment.entry AND MATCH (rara_comment.text) AGAINST ('$comment' IN BOOLEAN MODE) AND ";
	}
	$sql .= "1 ORDER BY rara.number ASC";
}

$result = $dbconn->query($sql);

if($result){
	$totalNumber = mysqli_num_rows($result);
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
		$number =  mysqli_result($result,$numInt,"number");

		
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
	$msg = "Connection error: <br>".mysqli_error($dbconn);
	messageHeader($msg,"error","nav/search.php?PHPSESSID=$sid","");
	//echo "<p>",mysql_error($dbconn), "</p>";
}
	
}
	
else{
	$msg = "Your query is not complete!";
	messageHeader($msg,"error","nav/search.php?PHPSESSID=$sid","");
	//echo "<p>Query not complete!</p>\n";
}


mysqli_close($dbconn);

?>
