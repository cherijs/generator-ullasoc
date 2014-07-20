<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL ^ E_NOTICE);

require_once ('config/system_head.php');



require_once ('social/Facebook/FacebookHttpable.php');
require_once ('social/Facebook/FacebookCurl.php');
require_once ('social/Facebook/FacebookCurlHttpClient.php');
require_once ('social/Facebook/FacebookSDKException.php');
require_once ('social/Facebook/FacebookRequestException.php');
require_once ('social/Facebook/FacebookServerException.php');
require_once ('social/Facebook/FacebookAuthorizationException.php');
require_once ('social/Facebook/FacebookOtherException.php');
require_once ('social/Facebook/FacebookRequest.php');
require_once ('social/Facebook/FacebookResponse.php');

require_once ('social/Facebook/GraphObject.php');
require_once ('social/Facebook/GraphUser.php');

require_once ('social/Facebook/GraphSessionInfo.php');
require_once ('social/Facebook/FacebookSession.php');

require_once ('social/Facebook/FacebookRedirectLoginHelper.php');



use Facebook\FacebookHttpable;
use Facebook\FacebookCurl;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookServerException;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookOtherException;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;

use Facebook\GraphSessionInfo;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

use Facebook\GraphObject;
use Facebook\GraphUser;

FacebookSession::setDefaultApplication(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);
$helper = new FacebookRedirectLoginHelper($server_url."login-facebook.php");

if (isset($_REQUEST["signed_request"])) {
    
    //pieseivojam dorsibas pec
    $_SESSION["signed_request"] = $_REQUEST["signed_request"];
}

if (isset($_REQUEST['request_ids'])) {
    
    //pieseivojam dorsibas pec
    $_SESSION["request_ids"] = $_REQUEST["request_ids"];
}

if (isset($_SESSION) && isset($_SESSION['fb_token'])) {
    $session = new FacebookSession($_SESSION['fb_token']);
    try {
        if (!$session->validate()) {
            $session = null;
        }
    }
    catch(Exception $e) {
        $session = null;
    }
} else {
    try {
        $session = $helper->getSessionFromRedirect();
    }
    catch(FacebookRequestException $ex) {
        print_r($ex);
    }
    catch(Exception $ex) {
        print_r($ex);
    }
}

if (isset($session)) {
    $_SESSION['fb_token'] = $session->getToken();
    $session = new FacebookSession($session->getToken());
    
    if ($session) {
        try {
            $user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
            $uid = $user_profile->getId();
            $username = $user_profile->getName();
            $email = $user_profile->getProperty('email');
            
            // specialu permision
            $gender = $user_profile->getProperty('gender');
            $img = "https://graph.facebook.com/" . $uid . "/picture?width=100&height=100";
            $link = $user_profile->getLink();
            
            $twitter_otoken_secret = null;
            $facebook_acces_token = $_SESSION['fb_token'];
            
            $_SESSION['fb_token'] = $session->getToken();
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['FB'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['oauth_id'] = $uid; //oauth_id
            $_SESSION['genderFB'] = $gender;
            $_SESSION['oauth_provider'] = "facebook";
            
            $userdata = $app->checkUser($_SESSION["id"], $uid, 'facebook', $username, $email, $gender, $twitter_oauth_token, $twitter_otoken_secret, $facebook_acces_token, $access_token, $img, $link, $liked);
            if (!empty($userdata)) {
                
                // ir users pieseivojam sesija?
                $_SESSION['id'] = $userdata['id'];
            }
            
            // if( isset($_SESSION["request_ids"])  && $uid ) {
            //       // You may have more than one request, so it's better to loop
            //       $requests = explode(',',$_SESSION['request_ids']);
            //       foreach($requests as $request_id) {
            //         $full_request = $request_id."_".$uid;
            //         // $requestG = (new FacebookRequest($session, 'DELETE', '/'.$full_request))->execute();
            //         // var_dump($uid);
            //         // var_dump($request_id);
            //         $app->updateRequest($request_id,$uid);
            //       }
            //       unset($_SESSION['request_ids']);
            // }
            
             // echo '<a href="' . $helper->getLogoutUrl($session, $server_url."logout.php?logout") . '">Logout</a>';

            //redirect uz sakumu
            header("Location: ".$server_url);

        }
        catch(FacebookRequestException $e) {
            
            // echo "Exception occured, code: " . $e->getCode();
            // echo " with message: " . $e->getMessage();
            
            
        }
    } else {
        
        // echo "NAV autorizēta aplikacija";
        unset($_SESSION['id']);
        unset($_SESSION['fb_token']);
        unset($_SESSION['valid']);
        unset($_SESSION['timeout']);
        unset($_SESSION['FB']);
        unset($_SESSION['username']);
        unset($_SESSION['oauth_id']);
        unset($_SESSION['genderFB']);
    }
} else {
    // echo '<a href="' . $helper->getLoginUrl(array('email')) . '">Login</a>';
    header("Location: ".$helper->getLoginUrl(array('email')));
}
?>