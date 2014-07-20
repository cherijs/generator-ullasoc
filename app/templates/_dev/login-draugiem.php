<?php
require_once("config/system_head.php");


$redirect_url = $server_url."login-draugiem.php";

include 'social/DraugiemApi.php';
	
$draugiem = new DraugiemApi(DRAUGIEM_APP_ID, DRAUGIEM_APP_KEY);//Create Draugiem.lv API object
	
$session = $draugiem->getSession(); //Try to authenticate user

if($session && !empty($_GET['dr_auth_code'])){//New session, check if we are not redirected from popup
	if(!empty($_GET['dr_popup'])){//Redirected from popup, refresh parent window and close the popup with Javascript
		?>
		<script type="text/javascript">
		window.opener.location.reload();
		window.opener.focus();
		if(window.opener!=window){
			window.close();
		}
		</script>
		<?php
	} else {//No popup, simply reload current window
		header("Location: ".$redirect_url);
	}
	exit;
}elseif(!empty($_GET['dr_popup'])){ // failed login
		?><script type="text/javascript">
		window.opener.location.reload();
		window.opener.focus();
		if(window.opener!=window){
			window.close();
		}
		</script>
		<?php
		exit;
}

?>
<?php
	if($session){//Authentication successful

		$user = $draugiem->getUserData();//Get user info

		$img = $user['img'];
		$uid = $user['uid'];
		$username = $user['name'].' '.$user['surname'];
		$gender = $user['sex'];


        // echo "<pre>";
        // var_dump($user);
        // exit;
        		// array(15) { ["uid"]=> int(4028) ["name"]=> string(7) "Artūrs" ["surname"]=> string(6) "Cirsis" ["nick"]=> string(7) "cherijs" ["place"]=> string(0) "" ["img"]=> string(60) "http://i8.ifrype.com/profile/004/028/v1351607126/sm_4028.jpg" ["imgi"]=> string(59) "http://i8.ifrype.com/profile/004/028/v1351607126/i_4028.jpg" ["imgm"]=> string(60) "http://i8.ifrype.com/profile/004/028/v1351607126/nm_4028.jpg" ["imgl"]=> string(59) "http://i8.ifrype.com/profile/004/028/v1351607126/l_4028.jpg" ["sex"]=> string(1) "M" ["birthday"]=> bool(false) ["age"]=> bool(false) ["adult"]=> int(1) ["type"]=> string(12) "User_Default" ["deleted"]=> bool(false) }
		
		
 		$userdata = $app->checkUser($_SESSION["id"], $uid, 'draugiem', $username, $email, $gender, $twitter_oauth_token, $twitter_otoken_secret, $facebook_acces_token, $access_token, $img, $link, $liked);

		// $userdata =  $app->checkUser($user['uid'], 'draugiem', $username,null,null,null,null, null,$img );
        

			$_SESSION['id'] = $userdata['id'];
            $_SESSION['oauth_id'] = $user['uid'];
            $_SESSION['pikcha'] = $user['imgm'];
            $_SESSION['username'] = $user['name'].' '.$user['surname'];
            $_SESSION['oauth_provider'] = "draugiem";

             header("Location: ".$server_url);



	} else { 

		$url = 'http://api.draugiem.lv/authorize/?app='.DRAUGIEM_APP_ID.'&hash='.md5(DRAUGIEM_APP_KEY.$redirect_url).'&redirect='.$redirect_url;
 		header('Location: ' . $url);

		
	}
?>
