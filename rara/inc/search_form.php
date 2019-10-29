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

<form action="$PHP_SELF" method="POST" name="Searchform">

	<table cellpadding="0" cellspacing="0">
	<tr><td>

	<table class="searchFields">
	<tr><td></td><td><b>Boolean Search Mode</b></td>
	<td><b>List Display</b></td>	
	</tr>
	<tr>
	<td></td><td>AND<INPUT type="radio" name="boolean" value="and" CHECKED>
	&nbsp;OR<INPUT type="radio" name="boolean" value="or"></td>
	<td><INPUT type="checkbox" name="list" value="on">ON</td>
	</tr><tr>
	<td>Phenomenon:</td><td><INPUT type="text" name="phenomenon" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="phenomenon">Display</td>
	</tr><tr>
	<td>Where found:</td><td><INPUT type="text" name="found" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="found">Display</td>
	</tr><tr>
	<td>Domain:</td><td><SELECT name="domain" size="1">
			<OPTION VALUE="" SELECTED>------ choose an option -------</OPTION>
			<OPTION VALUE="lexicon">Lexicon</OPTION>
			<OPTION VALUE="morphology">Morphology</OPTION>
			<OPTION VALUE="inflection">Inflection</OPTION>
			<OPTION VALUE="formation">Word Formation</OPTION>
			<OPTION VALUE="phonology">Phonology</OPTION>
			<OPTION VALUE="semantics">Semantics</OPTION>
			<OPTION VALUE="syntax">Syntax</OPTION>		
	</SELECT></td>
	<td><INPUT type="checkbox" name="listitem[]" value="domain">Display</td>
	</tr><tr>
	<td>Subdomain:</td><td><INPUT type="text" name="subdomain" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="subdomain">Display</td>
	</tr><tr>
	<td>Keywords:</td><td><INPUT type="text" name="keywords" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="keywords">Display</td>
	</tr><tr>
	<td>Type:</td><td><SELECT name="type" size="1">
		<OPTION VALUE="" SELECTED>------ choose an option -------</OPTION>
		<OPTION VALUE="infrequentale">Infrequentale</OPTION>
		<OPTION VALUE="nonesuch">Nonesuch</OPTION>
		<OPTION VALUE="rarissimum">Rarissimum</OPTION>
		<OPTION VALUE="rarum">Rarum</OPTION>		
	</SELECT></td>
	<td><INPUT type="checkbox" name="listitem[]" value="type">Display</td>
	</tr><tr>
	<td>Universals violated:</td><td><INPUT type="text" name="violates" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="violates">Display</td>
	</tr><tr>
	<td>Source:</td><td><INPUT type="text" name="source" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="source">Display</td>
	</tr><tr>
	<td>Comment:</td><td><INPUT type="text" name="comment" size="30"></td>
	<td><INPUT type="checkbox" name="listitem[]" value="comment">Display</td>
	</tr><tr>
	<td></td><td><INPUT type="submit" name="sent" value="Submit Query">
		<INPUT type="reset" value="Reset">
		<INPUT type="hidden" name="PHPSESSID" value="$sid"></td>
	</tr></table>
	
	</td>
	<td width="20">&nbsp;</td>
	<td width="350">
	<p align="justify" style="font-size:9pt;">
<ul>
<li>If you simultaneously want to search for items from more than one field (e.g., Phenomenon 
and Domain), use the radion buttons on top of the search form to determine whether they should
be joined with "AND" or "OR".</li>
<li>If you simultaneously want to search for several items within one field (e.g., both 
<i>nominative</i> and <i>accusative</i> in Keywords), mark those items which have to be 
present with a plus sign (e.g., <i>+nominative +accusative</i> when searching for entries
which contain both <i>nominative</i> and <i>accusative</i> in the keywords field).</li>
<li>In the same vein, mark those items that should not be present with a minus sign (e.g., 
<i>+nominative -accusative</i> yields all the entries where the field contains <i>nominative</i>
but not <i>accusative</i>).</li>
<li>If you want to search for consecutive word combinations (e.g., all and only those occurrences
where <i>case</i> is followed by <i>marking</i>), put them in quotation marks 
(<i>"case marking"</i>).</li>
</ul>

</p>
</td>
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

