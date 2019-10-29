<?php

/*
 * Archive v1.0
 * September 2006
 * Thomas Mayer
 */
 
session_start(); // PHP-Session 
include("constants.php"); // include secret constants

/*
 * ##### Function 'connectToDB'#####
 * For Rara use connectToDB('Rara')
 */
function connectToDB($db = 'th_mayer_de')
{
	$dbconn = @mysqli_connect(_HOST_, _USER_, _PASSWORD_, $db);
	if(!$dbconn){
		exit("<p>Connection refused to database <i>$db</i></p>");
	}
	return $dbconn;
}
/* +++++ END Function 'connectToDB'+++++ */

function mysqli_result($res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}

/* 
 * ##### Function 'displayResults' #####
 * For RARA use a different function
 */
 function displayResults($result, $numInt = 0)
 {
	 
	$field_number = mysqli_result($result,$numInt,"number");
	$field_phenomenon = mysqli_result($result,$numInt,"phenomenon");
	$field_found = mysqli_result($result,$numInt,"found");
	$field_domain = mysqli_result($result,$numInt,"domain");
	$field_subdomain = mysqli_result($result,$numInt,"subdomain");
	$field_keywords = mysqli_result($result,$numInt,"keywords");
	$field_type = mysqli_result($result,$numInt,"type");
	$field_violates = mysqli_result($result,$numInt,"violates");
	$field_source = mysqli_result($result,$numInt,"source");
	$field_old_number = mysqli_result($result,$numInt,"old_number");
	$used_to_be = "";
	if($field_old_number != "" AND $field_number != $field_old_number){
		$used_to_be = "(used to be $field_old_number in the old version)";
	}
	
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
	<tr><td width="175" class="odd">&nbsp;<b>Number</b>&nbsp;</td>
		<td class="odd">$field_number</td></tr>
	<tr><td class="even">&nbsp;<b>Phenomenon</b>&nbsp;</td>
		<td class="even">$field_phenomenon</td></tr>
	<tr><td class="odd">&nbsp;<b>Where found</b>&nbsp;</td>
		<td class="odd">$field_found</td></tr>
	<tr><td class="even">&nbsp;<b>Domain</b>&nbsp;</td>
		<td class="even">$field_domain</td></tr>
	<tr><td class="odd">&nbsp;<b>Subdomain</b>&nbsp;</td>
		<td class="odd">$field_subdomain</td></tr>
	<tr><td class="even">&nbsp;<b>Keywords</b>&nbsp;</td>
		<td class="even">$field_keywords</td></tr>
	<tr><td class="odd">&nbsp;<b>Type</b>&nbsp;</td>
		<td class="odd">$field_type</td></tr>
	<tr><td class="even">&nbsp;<b>Universals violated</b>&nbsp;</td>
		<td class="even">$field_violates</td></tr>
	<tr><td class="odd">&nbsp;<b>Source</b>&nbsp;</td>
		<td class="odd">$field_source</td></tr>
TABLEEND;
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
	 $numOfPosts = mysqli_num_rows($resultPosts); // number of posts to be displayed
	 
	 echo "	<tr><td class=\"even\">&nbsp;<b>$title</b>&nbsp;";
	 if($_SESSION['userLoggedOn']){
		 echo "<br>&nbsp;<span class=\"addPost\">";
		 echo "<a href=\"../edit/submitPost.php?num=$number&amp;field=$kind&amp;PHPSESSID=$sid\">";
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
		 $text = mysqli_result($resultPosts,$i,"text");
		 $user = mysqli_result($resultPosts,$i,"user");
		 $id = mysqli_result($resultPosts,$i,$field_id);
		 $editable = mysqli_result($resultPosts,$i,"editable");
		 $fullDate = explode(" ",mysqli_result($resultPosts,$i,"date_post"));
		 $date = $fullDate[0];
		 $time = $fullDate[1];
		 $timeExploded = explode(":",$time);
		 $dateExploded = explode("-",$date);
		 $resultUser = get_user($user);
		 $mail = mysqli_result($resultUser,0,"email");
		 $name = mysqli_result($resultUser,0,"name");
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
	 $db = 'th_mayer_de';
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
	 system("/usr/local/mysql-standard-5.0.22-osx10.4-powerpc/bin/mysqldump --opt -h $host -u $dbUser -p$pass $db > ../../backup/RARA-$year$month$day-$hour$min.sql",$fp);
	 if($fp == 0){
		 return true;
	 }
	 else{
		 return false;
	 }
 }
/* +++++ END Function 'dumpDatabase' +++++ */

/* 
 * ##### Function 'get_posts' #####
 */
 function get_posts($num,$kind = 'rara_comment')
 {
	 $dbconn = connectToDB('th_mayer_de');
	 $sql_commID = "SELECT * FROM rara WHERE number=$num;";
	 $result_sql_commID = $dbconn->query($sql_commID);
	 $entry_id = mysqli_result($result_sql_commID,0,"entry_id");
	 $sql_posts = "SELECT * FROM $kind WHERE entry=$entry_id ORDER BY date_post ASC";
	 $result_posts = $dbconn->query($sql_posts);
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
	 $result_user = $dbconn->query($sql_user);
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
Das grammatische Rarit&auml;tenkabinett &copy;1998-2006 :: Universit&auml;t Konstanz
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
	 <title>Das grammatische Rarit&auml;tenkabinett</title>
	 <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">\n
HEADER;
	 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../inc/style2.css\">\n";
	 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../inc/style.css\">\n";
	 echo "</head>\n<body>\n";
	
	if($header == "true"){
	
		echo <<<HEADERBAR
<table style="background-image: url(../img/buecher3x.jpg); background-repeat:no-repeat;
	background-position:top right;" cellspacing="0" cellpadding="0">
<tr>
<td></td>
<td></td>
<td colspan="3" valign="middle">
	<a href="../intro/index.php" style="font-size:18pt; color:#022b83; font-weight:bold;">
	<br>Das grammatische<br>Rarit&auml;tenkabinett
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
        <a href="../../archive/intro/" title="The Universals Archive">Archive</a></td>
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
	 $header = "From: Raritaetenkabinett <thommy.mayer@gmx.de>\n";
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

<br><br><br><br><br><br>
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
