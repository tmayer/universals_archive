<?php

/*
 * Archive v1.0
 * September 2006
 * Thomas Mayer
 */
 
session_start(); // PHP-Session 
include("../../../Sites_Additional/constants.php"); // include secret constants

/*
 * ##### Function 'connectToDB'#####
 * For Rara use connectToDB('Rara')
 */
 function connectToDB($db = 'Universals')
 {
	 $dbconn = @mysql_connect(_HOST_, _USER_, _PASSWORD_);
	 if(!@mysql_select_db($db)){
		 exit("<p>Connection refused to database <i>$db</i></p>");
	 }
	 return $dbconn;
 }
/* +++++ END Function 'connectToDB'+++++ */

/*
 * ##### Function 'displayEditResults' #####
 * For Rara use different Function
 */
 function displayEditResults($result, $number = 1, $numInt = 0)
 {
	 
	$field_number = mysql_result($result,$numInt,number);
	$field_original = mysql_result($result,$numInt,original);
	$field_standardized = mysql_result($result,$numInt,standardized);
	$field_formula = mysql_result($result,$numInt,formula);
	$field_keywords = mysql_result($result,$numInt,keywords);
	$field_domain = mysql_result($result,$numInt,domain);
	$field_type = mysql_result($result,$numInt,type);
	$field_status = mysql_result($result,$numInt,status);
	$field_quality = mysql_result($result,$numInt,quality);
	$field_basis = mysql_result($result,$numInt,basis);
	$field_source = mysql_result($result,$numInt,source);
	$field_id = mysql_result($result,$numInt,entry_id);

	 echo <<<BLANCOHEADER
<!-- Display Results Begin -->
<table class="blanco" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32" /></td>
		<td class="blanco_2">&nbsp;</td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32" /></td>
	</tr>
</table>
<table class="blanco" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>
BLANCOHEADER;

		echo <<<TABLEEND
<form action="$PHP_SELF" method="POST">
<table width="100%">
	<tr><td>
<input type="submit" name="edited" value="Save changes">
<input type="hidden" name="number" value="$number">
<input type="hidden" name="entry_id" value="$field_id">
<span style="text-decoration:blink; color:red; ">!</span></td>
<td align="right"><input type="submit" name="delete" value="Delete this entry!"></tr>
</table>
<br>
<table class="displayTable">
	<tr><td width="175" class="odd">&nbsp;<b>Number</b>&nbsp;</td>
		<td class="odd">$field_number</td><tr>
	<tr><td class="even">&nbsp;<b>Original</b>&nbsp;</td>
		<td class="even"><textarea name="original" cols="90" rows="3">$field_original</textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Standardized</b>&nbsp;</td>
		<td class="odd"><textarea name="standardized" cols="90" rows="3">$field_standardized</textarea></td><tr>
	<tr><td class="even">&nbsp;<b>Formula</b>&nbsp;</td>
		<td class="even"><textarea name="formula" cols="90" rows="1">$field_formula</textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Keywords</b>&nbsp;</td>
		<td class="odd"><textarea name="keywords" cols="90" rows="1">$field_keywords</textarea></td><tr>
	<tr><td class="even">&nbsp;<b>Domain</b>&nbsp;</td>
		<td class="even"><textarea name="domain" cols="90" rows="1">$field_domain</textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Type</b>&nbsp;</td>
		<td class="odd"><textarea name="type" cols="90" rows="1">$field_type</textarea></td><tr>
	<tr><td class="even">&nbsp;<b>Status</b>&nbsp;</td>
		<td class="even"><textarea name="status" cols="90" rows="1">$field_status</textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Quality</b>&nbsp;</td>
		<td class="odd"><textarea name="quality" cols="90" rows="1">$field_quality</textarea></td><tr>
	<tr><td class="even">&nbsp;<b>Basis</b>&nbsp;</td>
		<td class="even"><textarea name="basis" cols="90" rows="1">$field_basis</textarea></td><tr>
	<tr><td class="odd">&nbsp;<b>Source</b>&nbsp;</td>
		<td class="odd"><textarea name="source" cols="90" rows="1">$field_source</textarea></td><tr>
	 
TABLEEND;
	displayPosts($field_number,'counter','true');
	displayPosts($field_number,'comment','true');
	echo "</td></tr></table></form><br>";
	
	echo <<<BLANCOFOOTER
		</td>
		<td class="blanco_6"></td>
	</tr>
	<tr>
		<td class="blanco_7"></td>
		<td class="blanco_8">&nbsp;</td>
		<td class="blanco_9"></td>
	</tr>
</table>
BLANCOFOOTER;
		
	echo "\n<!-- Display Results End -->\n";
 }
/* +++++ END Function 'displayEditResults' +++++ */

/* 
 * ##### Function 'displayResults' #####
 * For RARA use a different function
 */
 function displayResults($result, $numInt = 0)
 {
	 
	$field_number = mysql_result($result,$numInt,number);
	$field_original = mysql_result($result,$numInt,original);
	$field_standardized = mysql_result($result,$numInt,standardized);
	$field_formula = mysql_result($result,$numInt,formula);
	$field_keywords = mysql_result($result,$numInt,keywords);
	$field_domain = mysql_result($result,$numInt,domain);
	$field_type = mysql_result($result,$numInt,type);
	$field_status = mysql_result($result,$numInt,status);
	$field_quality = mysql_result($result,$numInt,quality);
	$field_basis = mysql_result($result,$numInt,basis);
	$field_source = mysql_result($result,$numInt,source);
	
	echo <<<BLANCOHEADER
<!-- Display Results Begin -->
<table class="blanco" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32" /></td>
		<td class="blanco_2">&nbsp;</td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32" /></td>
	</tr>
</table>
<table class="blanco" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>
BLANCOHEADER;

	echo <<<TABLEEND
<table class="displayTable">
	<tr><td width="175" class="odd">&nbsp;<b>Number</b>&nbsp;</td><td class="odd">$field_number</td><tr>
	<tr><td class="even">&nbsp;<b>Original</b>&nbsp;</td><td class="even">$field_original</td><tr>
	<tr><td class="odd">&nbsp;<b>Standardized</b>&nbsp;</td><td class="odd">$field_standardized</td><tr>
	<tr><td class="even">&nbsp;<b>Formula</b>&nbsp;</td><td class="even">$field_formula</td><tr>
	<tr><td class="odd">&nbsp;<b>Keywords</b>&nbsp;</td><td class="odd">$field_keywords</td><tr>
	<tr><td class="even">&nbsp;<b>Domain</b>&nbsp;</td><td class="even">$field_domain</td><tr>
	<tr><td class="odd">&nbsp;<b>Type</b>&nbsp;</td><td class="odd">$field_type</td><tr>
	<tr><td class="even">&nbsp;<b>Status</b>&nbsp;</td><td class="even">$field_status</td><tr>
	<tr><td class="odd">&nbsp;<b>Quality</b>&nbsp;</td><td class="odd">$field_quality</td><tr>
	<tr><td class="even">&nbsp;<b>Basis</b>&nbsp;</td><td class="even">$field_basis</td><tr>
	<tr><td class="odd">&nbsp;<b>Source</b>&nbsp;</td><td class="odd">$field_source</td><tr>
TABLEEND;
	displayPosts($field_number,'counter');
	displayPosts($field_number,'comment');
	echo "</td></tr>\n</table>";
	echo <<<BLANCOFOOTER
		</td>
		<td class="blanco_6"></td>
	</tr>
	<tr>
		<td class="blanco_7"></td>
		<td class="blanco_8">&nbsp;</td>
		<td class="blanco_9"></td>
	</tr>
</table>	
BLANCOFOOTER;

	echo "\n<!-- Display Results End -->\n";
 }
/* +++++ END Function 'displayResults' +++++ */

/*
 * ##### Function 'displayPosts' #####
 * For RARA use a different function
 */
 function displayPosts($number,$kind,$edit = 'false')
 {
	 $sid = session_id();
	 $resultPosts; // result of SQL query
	 $title; // to be displayed on the left side
	 $nameField; // name of the field in the SQL table
	 $field_id; // name of the field_id (either 'counter_id' or 'comment_id')
	 $id = get_id($number);
	 if($kind == "counter"){
		 $resultPosts = get_posts($number,'counter');
		 $title = "Counterexamples";
		 $nameField = "counterexample";
		 $field_id = "counter_id";
	 }
	 else{
		 $resultPosts = get_posts($number);
		 $title = "Comments";
		 $nameField = "comment";
		 $field_id = "comment_id";
	 }
	 $numOfPosts = mysql_num_rows($resultPosts); // number of posts to be displayed
	 
	 echo "	<tr><td class=\"even\">&nbsp;<b>$title</b>&nbsp;";
	 if($_SESSION['userLoggedOn']){
		 echo "<br>&nbsp;<span class=\"addPost\">";
		 echo "<a href=\"../edit/submitPost.php?num=$number&amp;id=$id&amp;field=$kind&amp;PHPSESSID=$sid\">";
		 echo "&rArr; add a $nameField</a></span>&nbsp;";
	 }
	 echo "</td>\n<td valign=\"top\" height=\"100%\">";
	 echo "\n<!-- Begin Post Table -->\n";
	 echo "\n<table class=\"postTable\" cellspacing=\"0\" cellpadding=\"0\">\n<tr><td>";
	 if($numOfPosts == 0){
		 echo "&mdash;";
	 }
	 else{
	 for($i = 0; $i < $numOfPosts; $i++){
		 $editMode = "";
		 $no = $i+1;
		 $text = mysql_result($resultPosts,$i,text);
		 $user = mysql_result($resultPosts,$i,user);
		 $id = mysql_result($resultPosts,$i,$field_id);
		 $editable = mysql_result($resultPosts,$i,editable);
		 $fullDate = explode(" ",mysql_result($resultPosts,$i,date_post));
		 $date = $fullDate[0];
		 $time = $fullDate[1];
		 $timeExploded = explode(":",$time);
		 $dateExploded = explode("-",$date);
		 $resultUser = get_user($user);
		 $mail = mysql_result($resultUser,0,email);
		 $name = mysql_result($resultUser,0,name);
		 if($_SESSION['userLoggedOn']){
			 $userSession = $_SESSION['userLoggedOn'];
			 if(($userSession == $user && $editable == 'true') ||
			 		($_SESSION['userStatus'] == 'admin' && $edit == 'true')){
				 $editMode = "&nbsp;<a href=\"../edit/editPost.php?field=$kind&amp;id=$id&amp;number=$number&amp;PHPSESSID=$sid\">&rArr; edit</a>";
			 }
		 }
		 echo "<!-- Begin Table Post -->\n";
		 echo "\n<table class=\"posts\">\n<tr>\n<td>";
		 echo "<table class=\"post\">\n<tr class=\"postContent\"><td>";
		 echo "By $name <a href=\"mailto:$mail\" title=\"Send a mail to $name\">";
		 echo "<img src=\"../img/mail.gif\" border=\"0\"></a>$editMode</td>";
		 echo "<td align=\"right\">$dateExploded[2].$dateExploded[1].$dateExploded[0],&nbsp;";
		 echo "$timeExploded[0]:$timeExploded[1]&nbsp;</td></tr>";
		 echo "</table>\n</td></tr>";
		 echo "<tr><td>$text</td></tr></table>";
		 echo "\n<!-- END Table Post -->\n";
	 }
	 }
	 echo "</td></tr></table>\n";
	 echo "\n<!-- END Table Posts -->\n";
 }
/* +++++ END Function 'displayPosts' +++++ */

/*
 * ##### Function 'dumpDatabase' #####
 * For RARA use a different function
 */
 function dumpDatabase()
 {
	 $host = _HOST_;
	 $dbUser = _USER_;
	 $pass = _PASSWORD_;
	 $db = 'Universals';
	 $today = getDate();
	 $day = $today[mday];
	 if($day < 10){
		 $day = "0$day";
	 }
	 $month = $today[mon];
	 if($month < 10){
		 $month = "0$month";
	 }
	 $year = $today[year];
	 $hour = $today[hours];
	 if($hour < 10){
		 $hour = "0$hour";
	 }
	 $min = $today[minutes];
	 if($min < 10){
		 $min = "0$min";
	 }
	 system("/usr/local/mysql-standard-5.0.22-osx10.4-powerpc/bin/mysqldump --opt -h $host -u $dbUser -p$pass $db > ../../backup/UA-$year$month$day-$hour$min.sql",$fp);
	 if($fp == 0){
		 return true;
	 }
	 else{
		 return false;
	 }
 }
/* +++++ END Function 'dumpDatabase' +++++ */

/* 
 * ##### Function 'get_id' #####
 */
function get_id($number)
{
	$dbconn = connectToDB();
	$sqlID = "SELECT * FROM archive WHERE number=$number;";
	$resultID = mysql_query($sqlID,$dbconn);
	return mysql_result($resultID,0,entry_id);
}
/* +++++ END Function 'get_id' +++++ */

/* 
 * ##### Function 'get_posts' #####
 */
 function get_posts($num,$kind = 'comment')
 {
	 $dbconn = connectToDB();
	 $sql_posts = "SELECT * FROM $kind WHERE entry=$num ORDER BY date_post ASC";
	 $result_posts = mysql_query($sql_posts,$dbconn);
	 return $result_posts;
 }
/* +++++ END Function 'get_posts' +++++ */

/*
 * ##### Function get_user' #####
 */
 function get_user($user)
 {
	 $dbconn = connectToDB();
	 $sql_user = "SELECT * FROM user WHERE nickname='$user'";
	 $result_user = mysql_query($sql_user,$dbconn);
	 return $result_user;
 }
/* +++++ END Function 'get_user' +++++ */

/*
 * ##### Function 'getVariable' #####
 */
 function getVariable($name)
 {
	 $value = $_GET[$name];
	 if($_POST[$name]){
		 $value = $_POST[$name];
	 }
	 return $value;
 }
/* +++++ END Function 'getVariable' +++++

/*
 * ##### Function 'htmlFooter' #####
 */
 function htmlFooter($mode = "")
 {
	 if($mode == "UArchive" || $mode == "Rara"){
	 echo <<<FOOTERHEAD
<table style="width:770px; margin-left:12px; text-align:center; color:#A0A0A0;">
<tr><td class="footerBar">
<p style="font-size:8pt;">
The Universals Archive &copy;1998-2006 :: Universit&auml;t Konstanz
			  :: <a href="imprint">Contact</a><br>
				This site is maintained by <a href="mailto:frans.plank@uni-konstanz.de" 
				title="Send a mail to Frans Plank">
				Frans Plank</a>. If you have questions about or comments on this page, 
				please send your mail to the 
				<a href="thomas.mayer@uni-konstanz.de" title="Send a mail to the webmaster">
				Webmaster</a>.&nbsp;
</p></td></tr></table>
FOOTERHEAD;
	 }

	 echo <<<FOOTERFOOT
</body>
</html>
FOOTERFOOT;
 }
/* +++++ END Function 'htmlFooter' +++++ */

/* 
 * ##### Function 'htmlHeader' #####
 * For RARA use a different function 
 */
 function htmlHeader($mode="browse",$num=1,$header="true",$totalNumber="0",$number = -1)
{
	$sid = session_id();
	if($number == -1){
		$number = $num;
	}
	$titleResOrNum = "Number ";
	if($mode == "browse"){
		$browsePic = "active.gif";
		$browseBar = "activated.gif";
	}
	else{
		$browsePic = "inactive.gif";
		$browseBar = "activated_bar.gif";
	}
	if($mode == "intro" || $mode == "home"){
		$homePic = "active.gif";
		$homeBar = "activated.gif";
	}
	else{
		$homePic = "inactive.gif";
		$homeBar = "activated_bar.gif";
	}
	if($mode == "search"){
		$searchPic = "active.gif";
		$searchBar = "activated.gif";
		$titleResOrNum = "Result ";
	}
	else{
		$searchPic = "inactive.gif";
		$searchBar = "activated_bar.gif";
	}
	if($mode == "edit"){
		$editPic = "active.gif";
		$editBar = "activated.gif";
	}
	else{
		$editPic = "inactive.gif";
		$editBar = "activated_bar.gif";
	}
	
	echo <<<HEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	 <title>The Universals Archive</title>
	 <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
HEADER;
	 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../inc/style2.css\">";
	 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../inc/style.css\">";
	 echo "</head>\n<body>\n";
	
	if($header == "true"){
	
		echo <<<HEADERBAR
<table style="background-image: url(../img/buecher3.jpg); background-repeat:no-repeat;
	background-position:top right;" cellspacing="0" cellpadding="0">
<tr>
<td></td>
<td></td>
<td colspan="3" valign="middle">
	<a href="../intro/index.php" style="font-size:18pt; color:#022b83; font-weight:bold;">
	<br>The Universals<br>Archive
	</a>
</td>
<td colspan="10" height="80">&nbsp;</td>
</tr>
HEADERBAR;


		echo <<<HEADERBAR

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td><td class="navi" style="background: url(../img/buttons/$homePic); height:47;" align="center" valign="bottom">
	<a href="../intro/index.php" title="Home">Home</a></td>
<td class="navi" style="background: url(../img/buttons/$browsePic); height:47;" align="center" valign="bottom">
	<a href="../nav/browse.php?number=$number&amp;PHPSESSID=$sid" title="Browse Mode">Browse</a></td>
<td class="navi" style="background: url(../img/buttons/$searchPic);" align="center" valign="bottom">
	<a href="../nav/search.php?PHPSESSID=$sid" title="Search Mode">Search</a></td>
HEADERBAR;
		
		if($userLogged = $_SESSION['userLoggedOn'] && $_SESSION['userStatus'] == 'admin'){
			echo "<td class=\"navi\" style=\"background: url(../img/buttons/$editPic);\" align=\"center\" valign=\"bottom\">
        <a href=\"../edit/editEntry.php?number=$number&amp;PHPSESSID=$sid\" title=\"Edit Mode\">Edit</a></td>";
		}
		else{
			echo "<td>&nbsp;</td>";
		}

		echo <<<HEADERBAR
<td class="navi" style="background: url(../img/buttons/inactive2.gif);" align="center" valign="bottom">
        <a href="../../rara/intro/" title="Das grammatische Rarit&auml;tenkabinett">Rara</a></td>
HEADERBAR;

		if($userLogged = $_SESSION['userLoggedOn']){
			echo "<td class=\"navi\" style=\"background: url(../img/buttons/inactive5.gif);\" align=\"center\" valign=\"bottom\">
        <a href=\"../edit/user.php?number=".$num."&amp;PHPSESSID=$sid&amp;logout=1\" style=\"text-decoration:blink;\">Logout</a></td>";
		}
		else{
			echo "<td class=\"navi\" style=\"background: url(../img/buttons/inactive3.gif);\" align=\"center\" valign=\"bottom\">
        <a href=\"../edit/user.php?number=$num&amp;PHPSESSID=$sid\">Login</a></td>";
		}

		echo <<<HEADERBAR
<td></td>
<td>&nbsp;</td>
</tr>
HEADERBAR;


		echo <<<HEADERBAR

<tr>
<td style="width:13px;"></td>
<td><img src="../img/buttons/left_edge.gif"></td>
<td><img src="../img/buttons/activated_bar.gif" width="154" height="12"></td>
<td><img src="../img/buttons/$homeBar" width="96" height="12"></td>
<td><img src="../img/buttons/$browseBar" width="96" height="12"></td>
<td><img src="../img/buttons/$searchBar" width="96" height="12"></td>
<td><img src="../img/buttons/$editBar" width="96" height="12"></td>
<td><img src="../img/buttons/activated_bar.gif" width="96" height="12"></td>
<td><img src="../img/buttons/activated_bar.gif" width="96" height="12"></td>
<td><img src="../img/buttons/activated_bar.gif" width="30" height="12"></td>
<td><img src="../img/buttons/right_edge.gif"></td>
</tr>
</table>
HEADERBAR;

		if($totalNumber != 0){
			echo <<<HEADERBAR
<table cellspacing="0" cellpadding="0">
<tr>
<form action="$PHP_SELF" method="POST">
<td style="width:13px;">&nbsp;</td>
<td style="width:5px;">&nbsp;</td>
<td><img src="../img/buttons/inactive_upside_left_edge.gif"></td>
<td style="background: url(../img/buttons/inactive_upside_middle.gif); height:47; 
vertical-align:middle;" align="center">
	<span class="navi3">$titleResOrNum &nbsp;</span>
	<input class="numberField" type="text" name="number" size="5" maxlength="4" value="$num"><input type="submit" class="button" name="sent" value="&crarr;">
	<span class="navi3">of $totalNumber</span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<span class="navi2"><input type="submit" class="button" name="numDecr" value="<<<"></span>
	
	<span class="navi2"><input type="submit" class="button" name="numIncr" value=">>>"></span>
</td>
<td><img src="../img/buttons/inactive_upside_right_edge.gif"></td>
<td>&nbsp;</td>
HEADERBAR;

		} // $totalNumber != 0 
		if($mode == "intro"){
			echo <<<HEADERBAR
<table cellspacing="0" cellpadding="0">
<tr>
<form action="$PHP_SELF" method="POST">
<td style="width:13px;">&nbsp;</td>
<td style="width:5px;">&nbsp;</td>
<td><img src="../img/buttons/inactive_upside_left_edge.gif"></td>
<td style="background: url(../img/buttons/inactive_upside_middle.gif); height:47; 
vertical-align:middle;" align="center" class="navi2">
Intro Part &nbsp;
<a href="index.php?pt=1" title="Intro Pt. I">I</a>, &nbsp;
<a href="index.php?pt=2" title="Intro Pt. II">II</a>, &nbsp;
<a href="index.php?pt=3" title="Intro Pt. III">III</a>, &nbsp;
<a href="index.php?pt=4" title="Intro Pt. IV">IV</a>, &nbsp;
<a href="index.php?pt=5" title="Intro Pt. V">V</a>, &nbsp;
<a href="index.php?pt=6" title="Intro Pt. VI">VI</a>, &nbsp;
<a href="index.php?pt=7" title="References">References</a>
</td>
<td><img src="../img/buttons/inactive_upside_right_edge.gif"></td>
<td>&nbsp;</td>
HEADERBAR;
			
		}
		

		if($mode == "search"){
	
		}
		else{
			echo "</form></tr></table><br>\n";
		}

	
	} // $header == 'true'
}
/* +++++ END Function 'htmlHeader' ++++++ */

/*
 * ##### Function 'mailNotice' #####
 */
 function mailNotice($sort,$numberOfEntry,$user,$content)
 {
	 $emailTo = "thommy.mayer@gmx.de";
	 $header = "From: Universals Archive <thommy.mayer@gmx.de>\n";
	 $header .= "Reply-To: thommy.mayer@gmx.de\n";
	 $header .= "X-Mailer: PHP/" . phpversion(). "\n";
	 $header .= "X-Sender-IP: " . getenv('REMOTE_ADDR') . "\n";
	 $header .= "Content-Type: text/plain";
	 $text = "$sort by $user for entry no. $numberOfEntry: \n\n";
	 $text .= "-----------------------------------------------\n\n";
	 $text .= "$content\n\n";
	 $betreff = "The database has been changed";
	 @mail($emailTo,$betreff,$text,$header);
	 
 }
/* +++++ END Function 'mailNotice' +++++ */

/*
 * ##### Function 'messageHeader'
 */
 function messageHeader($msg,$sort,$url)
 {
	 echo <<<END
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>The Universals Archive</title>\n
	<meta http-equiv="refresh" content="2; URL=../$url">
	<link rel="stylesheet" type="text/css" href="../inc/style2.css">
	<link rel="stylesheet" type="text/css" href="../inc/style.css">
</head>
<body>	

<br>
<table style="background-color:#f6f6f6; width:400px;" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32" /></td>
		<td class="blanco_2">
<p align="center" class="$sort">$msg</p></td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32" /></td>
	</tr>
</table>
<table style="background-color:#f6f6f6; width:400px;" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>
<p align="center" class="forward">If your browser does not forward automatically, click 
<a href="../$url">here</a>.</p>
</td>
		<td class="blanco_6"></td>
	</tr>
	<tr>
		<td class="blanco_7"></td>
		<td class="blanco_8">&nbsp;</td>
		<td class="blanco_9"></td>
	</tr>
</table>
</body>
</html>
	 
END;
	 
 }
/* +++++ END Function 'messageHeader' +++++ */

?>
