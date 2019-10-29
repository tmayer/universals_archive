<?php

include("../inc/functions.php");
$number = getVariable("number");
$sid = session_id();

if($_POST['login']){
	$user = $_POST['user'];
	$pw = $_POST['pw'];
	if($user == "" OR $pw == ""){
		$msg = "No user name or password entered!";
		messageHeader($msg,"error","edit/user.php?number=$number&amp;PHPSESSID=$sid");
	}
	else{
		$dbconn = connectToDB();
		$query = "SELECT * FROM user WHERE nickname='$user'";
		$result = mysql_query($query,$dbconn);
		$dbPW = mysql_result($result,0,password);
		$status = mysql_result($result,0,status);
		if($result && $pw == $dbPW){
			$_SESSION['userLoggedOn'] = $user;
			$_SESSION['userStatus'] = $status;
			$msg = "You are logged on as $user";
			messageHeader($msg,"confirm","nav/browse.php?number=$number&amp;PHPSESSID=$sid");
		}
		else{
			$msg = "No valid password or user name!";
			messageHeader($msg,"error","edit/user.php?number=$number&amp;PHPSESSID=$sid");
		}
	}
}
elseif($_GET['logout'] || $_SESSION['userLoggedOn'] != ""){
	$_SESSION['userLoggedOn'] = "";
	$_SESSION['userStatus'] = "";
	$msg = "You are logged out now!";
	messageHeader($msg,"confirm","nav/browse.php?number=$number&amp;PHPSESSID=$sid");
}
else{
	htmlHeader("edit",$number,"false",0);
	echo <<<USERFORM
	<br>
	<table style="background-color:#f6f6f6; width:400px;" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_1"><img src="../img/blocks/blocks_bl_01.jpg" width="23" height="32" /></td>
		<td class="blanco_2" align="center"><b>Please enter your user name and password</b></td>
		<td class="blanco_3"><img src="../img/blocks/blocks_bl_03.jpg" width="25" height="32" /></td>
	</tr>
</table>
<table style="background-color:#f6f6f6; width:400px;" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="blanco_4"></td>
		<td>
		
	<form action="$PHP_SELF" method="POST">
	<table align="center">
	<tr><td>User name:</td><td>
	<input type="text" name="user">
	</td></tr>
	<tr><td>Password:</td><td>
	<input type="password" name="pw">
	</td></tr>
	<tr><td></td><td>
	<input type="submit" name="login" value="Login">
	<input type="reset">
	</td></tr>
	<tr><td></td><td>
	<a href="../nav/browse.php?number=$number&amp;PHPSESSID=$sid">back to Browse Mode</a>
	</td></tr>
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
</table>
		
	
	
	
USERFORM;
	//htmlFooter();
}

?>
