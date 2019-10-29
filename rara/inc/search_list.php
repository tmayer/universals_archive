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


		
htmlHeader("browse",$num,"true",0,$number);

echo <<<END
	<table width="800px" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32" /></td>
		<td class="blanco_2">&nbsp;</td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32" /></td>
	</tr>
</table>
<table width="800px" style="background-color: #f6f6f6;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>	
END;

$listitem = $_POST['listitem'];
for($i=0; $i<$totalNumber; $i++){
	$nr = $i + 1;
	echo "<table class=\"displayTable\" style=\"border:thin solid #A0A0A0;\">";
	echo "<tr style=\"background-color:#A0A0A0; color:#FFFFFF;\">";
	echo "<td width=\"175\">&nbsp;<b>Result No. $nr</b></td><td></td></tr>";
	$field_number = mysql_result($result,$i,number);
		echo "<tr><td width=\"175\" class=\"odd\">&nbsp;<b>Number</b>&nbsp;</td>";
		echo "<td class=\"odd\">$field_number</td></tr>";
	if(sizeof($listitem) > 0){
	$counter = 1;
		foreach($listitem as $key){
			$counter++;
			$mod = "odd";
			if($counter % 2 == 0){
				$mod = "even";
			}
			if($key == 'comment'){
				displayPosts($field_number,'comments');
			}
			else{
				$field = mysql_result($result,$i,$key);
				switch ($key) {
					case "phenomenon":
						$title = "Phenomenon";
						break;
					case "found":
						$title = "Where found";
						break;
					case "domain":
						$title = "Domain";
						break;
					case "subdomain":
						$title = "Subdomain";
						break;
					case "keywords":
						$title = "Keywords";
						break;
					case "type":
						$title = "Type";
						break;
					case "violates":
						$title = "Universals violated";
						break;
					case "source":
						$title = "Source";
						break;
				}
				echo "<tr><td width=\"175\" class=\"$mod\">&nbsp;<b>$title</b>&nbsp;</td>";
				echo "<td class=\"$mod\">$field</td></tr>";
			}
		}
	}

	echo "</table><br>";
}


echo <<<END
		</td>
		<td class="blanco_6"></td>
	</tr>
	<tr>
		<td class="blanco_7"></td>
		<td class="blanco_8">&nbsp;</td>
		<td class="blanco_9"></td>
	</tr>
</table><br>
END;

//displayResults($result, $numInt);

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
