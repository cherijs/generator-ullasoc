<?
header('Content-Type: text/plain; charset=utf-8');
require_once ("config/system_head.php");


if(checkPOSTS(array("name","surname","check","email","phone","age"))){

	if($_POST["spam"]=="on"){
		$_POST["spam"] = 1;
	} else {
		$_POST["spam"] = 0;
	}

	$done = $app->registerUser($_POST["name"], $_POST["surname"],  $_POST["check"], $_POST["email"], $_POST["phone"] , $_POST["age"], $_POST["spam"]);

	if($done){
		echo json_encode(array('done' => $done));
	} else {
		echo json_encode(array('error' => "check_in_use"));
	}


} else {
	echo json_encode(array('error' => 'error'));
}


function checkPOSTS($arr){
	global $_POST;
	if (is_array($arr)){
		foreach ($arr as $value) {
			if(!isset($_POST[$value]) || trim($_POST[$value])==''){
				return false;
				break;
			}
		}
		return true;
	} else {
		return false;
	}
}


?>