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

$result = $dbconn->query($sql);

if($result){
	$totalNumber = mysqli_num_rows($result);
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
	$field_number = mysqli_result($result,$i,"number");
		echo "<tr><td width=\"175\" class=\"odd\">&nbsp;<b>Number</b>&nbsp;</td>";
		echo "<td class=\"odd\">$field_number</td></tr>";
	if(count($listitem) > 0){
	$counter = 1;
		foreach($listitem as $key){
			$counter++;
			$mod = "odd";
			if($counter % 2 == 0){
				$mod = "even";
			}
			if($key == 'comments'){
				displayPosts($field_number,'comments');
			}
			elseif($key == 'counterexamples'){
				displayPosts($field_number,'counter');
			}
			else{
				$field = mysqli_result($result,$i,$key);
				switch ($key) {
					case "original":
						$title = "Original";
						break;
					case "standardized":
						$title = "Standardized";
						break;
					case "formula":
						$title = "Formula";
						break;
					case "keywords":
						$title = "Keywords";
						break;
					case "domain":
						$title = "Domain";
						break;
					case "type":
						$title = "Type";
						break;
					case "status":
						$title = "Status";
						break;
					case "quality":
						$title = "Quality";
						break;
					case "basis":
						$title = "Basis";
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
