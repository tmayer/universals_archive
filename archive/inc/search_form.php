<?php

htmlHeader("search");
echo "</tr></table><br>\n";
$sid = session_id();

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
	<form action="$PHP_SELF" method="POST">
	<table class="searchFields">
	<tr><td></td><td><b>Boolean Search Mode</b></td>
	<td><b>List Display</b></td>	
	</tr>
	<tr>
	<td></td><td>AND<INPUT type="radio" name="boolean" value="and" CHECKED>
	&nbsp;OR<INPUT type="radio" name="boolean" value="or"></td>
	<td><INPUT type="checkbox" name="list" value="on">ON</td>
	</tr><tr>
	<td>Original:</td><td><INPUT type="text" name="original" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="original">Display</td>
	</tr><tr>
	<td>Standardized:</td><td><INPUT type="text" name="standardized" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="standardized">Display</td>
	</tr><tr>
	<td>Formula:</td><td><INPUT type="text" name="formula" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="formula">Display</td>
	</tr><tr>
	<td>Keywords:</td><td><INPUT type="text" name="keywords" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="keywords">Display</td>
	</tr><tr>
	<td>Domain:</td><td><SELECT name="domain" size="1">
				<OPTION VALUE="" SELECTED>------ choose an option -------</OPTION>
				<OPTION VALUE="syntax">Syntax</OPTION>
				<OPTION VALUE="morphology">Morphology</OPTION>
				<OPTION VALUE="semantics">Semantics</OPTION>
				<OPTION VALUE="phonology">Phonology</OPTION>
				<OPTION VALUE="inflection">Inflection</OPTION>
				<OPTION VALUE="prosodic">Prosodic Phonology</OPTION>
				<OPTION VALUE="formation">Word Formation</OPTION>
				<OPTION VALUE="lexicon">Lexicon</OPTION>
				<OPTION VALUE="discourse">Discourse</OPTION>
				<OPTION VALUE="pragmatics">Pragmatics</OPTION>
			</SELECT></TD>
	<td><INPUT type="checkbox" name="listitem[]" value="domain">Display</td>
	</tr><tr>
	<td>Type:</td><td><SELECT name="type" size="1">
				<OPTION VALUE="" SELECTED>------ choose an option -------</OPTION>
				<OPTION VALUE="+implication -hierarchy">Implication</OPTION>
				<OPTION VALUE="+implicational +hierarchy">Implicational Hierarchy</OPTION>
				<OPTION VALUE="+mutual +implication">Mutual Implication</OPTION>
				<OPTION VALUE="+nested +implication">Nested Implication</OPTION>
				<OPTION VALUE="+no +genuine +implication">No Genuine Implication</OPTION>
				<OPTION VALUE="unconditional">Unconditional</OPTION>
				<OPTION VALUE="target < source">Target &lt; Source</OPTION>
			</SELECT></TD>
	<td><INPUT type="checkbox" name="listitem[]" value="type">Display</td>
	</tr><tr>
	<td>Status:</td><td><SELECT name="status" size="1">
				<OPTION VALUE="" SELECTED>------ choose an option -------</OPTION>
				<OPTION VALUE="+achronic -diachronic">Achronic</OPTION>
				<OPTION VALUE="+achronic +diachronic">Achronic and/or Diachronic</OPTION>
				<OPTION VALUE="+diachronic -achronic">Diachronic</OPTION>
				<OPTION VALUE="statistical">Statistical</OPTION>
			</SELECT></TD>
	<td><INPUT type="checkbox" name="listitem[]" value="status">Display</td>
	</tr><tr>
	<td>Quality:</td><td><SELECT name="quality" size="1">
				<OPTION VALUE="" SELECTED>------ choose an option -------</OPTION>
				<OPTION VALUE="absolute">Absolute</OPTION>
				<OPTION VALUE="statistical">Statistical</OPTION>
			</SELECT></TD>
	<td><INPUT type="checkbox" name="listitem[]" value="quality">Display</td>
	</tr><tr>
	<td>Basis:</td><td><INPUT type="text" name="basis" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="basis">Display</td>
	</tr><tr>
	<td>Source:</td><td><INPUT type="text" name="source" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="source">Display</td>
	</tr><tr>
	<td>Counterexamples:</td><td><INPUT type="text" name="counterexamples" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="counterexamples">Display</td>
	</tr><tr>
	<td>Comments:</td><td><INPUT type="text" name="comments" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="comments">Display</td>
	</tr><tr>
	<td></td><td><INPUT type="submit" name="sent" value="Submit Query">
		<INPUT type="reset" value="Reset">
		<INPUT type="hidden" name="PHPSESSID" value="$sid"></td>
	</tr>
</table>
</form>
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

htmlFooter();

?>

