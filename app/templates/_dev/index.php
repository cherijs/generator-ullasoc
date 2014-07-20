<?php
require_once ("config/system_head.php");

$tmp=explode('/',$_SERVER['REQUEST_URI']);
$REQUEST_URI = array();
$i=count($tmp);
for($n=0;$n<$i;$n++){
    if($tmp[$n]){
        $REQUEST_URI[$n]=$tmp[$n];
    }
}


if (array_key_exists("login", $_GET)) {
	$oauth_provider = $_GET['oauth_provider'];
	if ($oauth_provider == 'twitter') {
		header("Location: login-twitter.php");
	} else if ($oauth_provider == 'facebook') {
		header("Location: login-facebook.php");
	} else if ($oauth_provider == 'draugiem') {
		header("Location: login-draugiem.php");
	}
}

switch (@$REQUEST_URI[1]) {

	case "logout":
		header("Location: ".$server_url."logout.php?logout");
		break;

    default:
        include_once ('home.php');
        break;
}

?>