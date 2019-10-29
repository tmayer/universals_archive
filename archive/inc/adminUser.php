<?php

include("../inc/functions.php");

$dbconn = connectToDB();

if(isset($_GET['sort'])){
	$sort = $_GET['sort'];
}
else{
	$sort = 'name';
}
if(isset($_GET['dir'])){
	$dir = $_GET['dir'];
}
else{
	$dir = 'ASC';
}


if($_POST['enter']){
	
	if($_POST['name'] AND $_POST['nickname'] AND $_POST['email'] 
		AND $_POST['password'] AND $_POST['status']){
			$login = $_POST['nickname'];
		$sql_confirm = "SELECT * FROM user WHERE nickname='$login'";
		$result_confirm = mysql_query($sql_confirm,$dbconn);
		$result_confirm_rows = mysql_num_rows($result_confirm);
		if($result_confirm_rows > 0){
			$msg = "Login name already exists!";
			messageHeader($msg,"error","inc/adminUser.php","");
		}
		else{
			$name = $_POST['name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$status = $_POST['status'];
			$sql_cmd = "INSERT INTO user SET name='$name', email='$email', password='$password', status='$status', nickname='$login';";
			$result_sql_cmd = mysql_query($sql_cmd,$dbconn);
			if($result_sql_cmd){
				$msg = "Entry submitted";
				messageHeader($msg,"confirm","inc/adminUser.php","");
			}
			else{
				$msg = "Entry not submitted";
				messageHeader($msg,"error","inc/adminUser.php","");
			}
		}
	}
	else{
		$msg = "Field is missing!";
		messageHeader($msg,"error","inc/adminUser.php","");
	}
}
elseif($_GET['entryID'] AND !($_POST['del'] OR $_POST['edit'])){

	htmlHeader("edit",$number,"false",0);
	
	$entry_id = $_GET['entryID'];
	
	$sql_id = "SELECT * FROM user WHERE user_id='$entry_id';";
	$result_id = mysql_query($sql_id,$dbconn);
	$result_Number = mysql_num_rows($result_id);
	if($result_Number == 1){
		$name = mysql_result($result_id,0,name);
		$nickname = mysql_result($result_id,0,nickname);
		$email = mysql_result($result_id,0,email);
		$password = mysql_result($result_id,0,password);
		$status = mysql_result($result_id,0,status);
		
			
	echo <<<USERFORM
	<form action="$PHP_SELF" method="POST">
	<table>
	<tr>
	<td><b>Name</b></td><td><b>Login</b></td>
	<td><b>E-Mail</b></td><td><b>Password</b></td><td><b>Status</b></td>
	</tr>
	<tr>
		<td><INPUT type="text" name="name" size="30" value="$name"></td>
		<td><INPUT type="text" name="nickname" size="30" value="$nickname"></td>
		<td><INPUT type="text" name="email" size="40" value="$email"></td>
		<td><INPUT type="text" name="password" size="30" value="$password">
		<INPUT type="hidden" name="user_id" value="$entry_id"></td>
		<td><SELECT name="status" size="1">
USERFORM;
if($status == "user"){
			echo "<OPTION VALUE=\"user\" SELECTED>user</OPTION>";
			echo "<OPTION VALUE=\"admin\">admin</OPTION>";
}
else{
			echo "<OPTION VALUE=\"admin\" SELECTED>admin</OPTION>";
			echo "<OPTION VALUE=\"user\">user</OPTION>";
}
			echo <<<USERFORM
			</SELECT>
		</td>
	</tr>
	<tr>
		<td><INPUT type="submit" name="edit" value="submit changes!"></td>
		<td><a href="adminUser.php">&rArr; New entry</a></td>
		<td><INPUT type="submit" name="del" value="delete entry!"></td>
	</tr>
	</table>
	</form>
	<hr>
	
USERFORM;

	displayUsers($dbconn,$sort,$dir);
	}
	else{
		$msg = "ID does not exist!";
		messageHeader($msg,"error","inc/adminUser.php","");
	}
}
elseif($_POST['edit']){
	$entry_id = $_POST['user_id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$status = $_POST['status'];
	$nickname = $_POST['nickname'];
	$sql_update = "UPDATE user SET name='$name', email='$email', 
		password='$password', status='$status', nickname='$nickname' 
		WHERE user_id='$entry_id';";
	$result_update = mysql_query($sql_update,$dbconn);
	if($result_update){
		$msg = "Entry has been updated";
		messageHeader($msg,"confirm","inc/adminUser.php","");
	}
	else{
		$msg = "Error in updating entry";
		messageHeader($msg,"error","inc/adminUser.php","");
	}
}
elseif($_POST['del']){
	$entry_id = $_POST['user_id'];
	$sql_del = "DELETE FROM user WHERE user_id='$entry_id';";
	$result_del = mysql_query($sql_del);
	if($result_del){
		$msg = "Entry has been deleted!";
		messageHeader($msg,"confirm","inc/adminUser.php","");
	}
	else{
		$msg = "Error in deleting entry!";
		messageHeader($msg,"error","inc/adminUser.php","");
	}
}
else{
	
	htmlHeader("edit",$number,"false",0);
	echo <<<USERFORM
	
	<form action="$PHP_SELF" method="POST">
	<table>
	<tr>
	<td><b>Name</b></td><td><b>Login</b></td>
	<td><b>E-Mail</b></td><td><b>Password</b></td><td><b>Status</b></td>
	</tr>
	<tr>
		<td><INPUT type="text" name="name" size="30"></td>
		<td><INPUT type="text" name="nickname" size="30"></td>
		<td><INPUT type="text" name="email" size="40"></td>
		<td><INPUT type="text" name="password" size="20"></td>
		<td><SELECT name="status" size="1">
			<OPTION VALUE="user" SELECTED>user</OPTION>
			<OPTION VALUE="admin">admin</OPTION>
			</SELECT>
		</td>
	</tr>
	<tr>
		<td><INPUT type="submit" name="enter" value="create new entry!"></td>
	</tr>
	</table>
	</form>
	<hr>
	
USERFORM;

displayUsers($dbconn,$sort,$dir);

}

mysql_close($dbconn);

htmlFooter();

function displayUsers($dbconn, $sort, $dir = 'ASC'){
	
echo <<<TABLEEND
<table cellspacing="0" cellpadding="0"><tr><td width="5"></td><td>
<table style="border:thin solid #C0C0C0;" rules="all" width="750">
<tr>
<td><b>No.</b></td>
<td><b>Name</b>&nbsp;&nbsp;<a href="adminUser.php?sort=name&dir=DESC">
<img src="../img/up.gif"></a><a href="adminUser.php?sort=name">
<img src="../img/down.gif"></a></td>
<td><b>Login</b>
&nbsp;&nbsp;<a href="adminUser.php?sort=nickname&dir=DESC">
<img src="../img/up.gif"></a><a href="adminUser.php?sort=nickname">
<img src="../img/down.gif"></a></td>
<td><b>E-Mail</b>&nbsp;&nbsp;<a href="adminUser.php?sort=email&dir=DESC">
<img src="../img/up.gif"></a><a href="adminUser.php?sort=email">
<img src="../img/down.gif"></a></td>
<td><b>Password</b>&nbsp;&nbsp;
<a href="adminUser.php?sort=password&dir=DESC"><img src="../img/up.gif">
<a href="adminUser.php?sort=password"><img src="../img/down.gif">
</td>
<td><b>Status</b>&nbsp;&nbsp;<a href="adminUser.php?sort=status&dir=DESC">
<img src="../img/up.gif"></a><a href="adminUser.php?sort=status">
<img src="../img/down.gif"></a></td>
<td><b>ID</b>&nbsp;&nbsp;<a href="adminUser.php?sort=user_id&dir=DESC">
<img src="../img/up.gif"></a><a href="adminUser.php?sort=user_id">
<img src="../img/down.gif"></a></td><td>&nbsp;</td></tr>
TABLEEND;

$sql = "SELECT * FROM user ORDER BY $sort $dir;";
$counter = 0;
$result = mysql_query($sql,$dbconn);
$totalNumber = mysql_num_rows($result);
for($i=0;$i<$totalNumber;$i++){
	$counter++;
	$id = mysql_result($result,$i,user_id);
	$name = mysql_result($result,$i,name);
	$email = mysql_result($result,$i,email);
	$password = mysql_result($result,$i,password);
	$status = mysql_result($result,$i,status);
	$nickname = mysql_result($result,$i,nickname);
	echo "\n<tr><td align=\"right\">$counter&nbsp;</td><td>$name</td><td>$nickname</td><td>$email</td>";
	echo "<td>$password</td><td>$status</td><td>$id</td>";
	echo "<td><a href=\"adminUser.php?entryID=$id\">edit</a></td></tr>\n";
}

echo "</table></td></tr></table>";
}

?>
