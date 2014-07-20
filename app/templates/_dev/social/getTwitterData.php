<?php
error_reporting(E_ALL ^ E_NOTICE);
ob_start();

require_once(__DIR__."/../config/system_head.php");
require(__DIR__."/../social/twitter/twitteroauth.php");



//w9rMdZqOlNb5HS2AMwYjCyP5m
//8xla0G7TtanFsyxUvAUx2iOGushqyhXYls0npdSeyMIMkKnHKd

session_start();

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {


    $twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
   
    $_SESSION['access_token'] = $access_token;
    $user_info = $twitteroauth->get('account/verify_credentials');

    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: '.$server_url.'login-twitter.php');
    } else {
        $twitter_otoken=$_SESSION['oauth_token'];
        $twitter_otoken_secret=$_SESSION['oauth_token_secret'];

        // echo "<pre>";
        // var_dump($user_info);
        // exit;


        $email='';
        $uid = $user_info->id;
        $img = $user_info->profile_image_url_https;
        
        $img = str_replace("_normal.", "_bigger.", $user_info->profile_image_url_https);


        $username = $user_info->name;

        $facebook_acces_token = null;

        $link = "https://twitter.com/".$user_info->screen_name;



        if($twitter_otoken && $twitter_otoken_secret && $access_token){
              $userdata = $app->checkUser($_SESSION["id"], $uid, 'twitter', $username, $email, $gender, $twitter_oauth_token, $twitter_otoken_secret, $facebook_acces_token, serialize($access_token), $img, $link, $liked);

        }



        if(!empty($userdata)){
            session_start();
            $_SESSION['id'] = $userdata['id'];
            $_SESSION['oauth_id'] = $uid;
            $_SESSION['img'] = str_replace('_normal', '', $img);
            $_SESSION['username'] = $userdata['username'];
            $_SESSION['oauth_provider'] = $userdata['oauth_provider'];

            header("Location: ".$server_url);
        }
    }
} else {
    // Something's missing, go back to square 1
    header('Location: '.$server_url.'login-twitter.php');
}
?>
