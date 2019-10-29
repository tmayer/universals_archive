<?php

include("../inc/functions.php");

$dbconn = connectToDB('Rara');

$sqlComm = "SELECT * FROM comment;";
$sqlResult = mysql_query($sqlComm,$dbconn);
if($sqlResult){
	$resultNumbers = mysql_num_rows($sqlResult);
	echo "Gegenbeispiele sind gefunden worden<br>";
	$counter = 0;

	for($i=0;$i<$resultNumbers;$i++){
		$counter++;
		$entryNr = mysql_result($sqlResult,$i,entry);
		$counterID = mysql_result($sqlResult,$i,comment_id);
	
		$sqlEntry = "SELECT * FROM archive WHERE old_number='$entryNr';";
		$sqlEntryResult = mysql_query($sqlEntry,$dbconn);
		if($sqlEntryResult){
			$entryId = mysql_result($sqlEntryResult,0,entry_id);
	
			$sqlUpdate = "UPDATE comment SET entry='$entryId' WHERE comment_id='$counterID';";
			$sqlUpdateResult = mysql_query($sqlUpdate,$dbconn);
			if($sqlUpdateResult){
				echo "$counter) Archiv-Daten sind gefunden worden.<br>";
			}
			else{
				echo "<span style=\"color:red;\">$counter) Archiv-Daten sind nicht gefunden worden.</span><br>";
			}
		}
		else{
			echo "Fehler beim Finden der entsprechenden Archiv-Daten";
		}
	}
	
}
else{
	echo "Fehler beim Finden der Kommentare!";
}


?>
