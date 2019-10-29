<?php

include("../inc/functions.php");
$part = 0;
if($_GET['pt']){
	$part = $_GET['pt'];
}

if($part == 0){
	htmlHeader("intro");
}
else{
	htmlHeader("intro");
}

	echo <<<TABLEEND
	<table class="blanco" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32"></td>
		<td class="blanco_2">&nbsp;</td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32"></td>
	</tr>
</table>
<table class="blanco" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>

TABLEEND;

//echo "<table width=\"790\"><tr><td><td width=\"10\">&nbsp;</td><td>";
include("part$part.php");
//echo "</td></tr></table>";

echo <<<TABLEEND2
		
</td>
		<td class="blanco_6"></td>
	</tr>
	<tr>
		<td class="blanco_7"></td>
		<td class="blanco_8">&nbsp;</td>
		<td class="blanco_9"></td>
	</tr>
</table>
	
TABLEEND2;


htmlFooter();
		
?>
