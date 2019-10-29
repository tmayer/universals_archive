<?php

include("../inc/functions.php");
$sid = session_id();

if($_POST['sent']){
	if($_POST['list'] == 'on'){
		include("../inc/search_list.php");
	}
	else{
		include("../inc/search_results.php");
	}
}
else{
	include("../inc/search_form.php");
}

?>
