<?


use Facebook\FacebookHttpable;
use Facebook\FacebookCurl;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSession;
use Facebook\FacebookJavaScriptLoginHelper;
use Facebook\GraphObject;
use Facebook\GraphUser;





if($session) {
  try {
    $user_profile = (new FacebookRequest(
      $session, 'GET', '/me'
    ))->execute()->getGraphObject(GraphUser::className());


        $uid = $user_profile->getId();
        $username = $user_profile->getName();
        $email = null; // specialu permision

        $gender =$user_profile->getProperty('gender');
        $img = "https://graph.facebook.com/".$uid."/picture?width=1000&height=1000";
        $link = $user_profile->getLink();
        
        $twitter_otoken_secret = null;
        $facebook_acces_token = null;


        $userdata =  $app->checkUser($_SESSION["id"], $uid, 'facebook', $username,$email,$gender,$twitter_oauth_token,$twitter_otoken_secret,$facebook_acces_token, $access_token, $img ,$link );
        if (!empty($userdata)) {
            // ir users pieseivojam sesija?
        }

        var_dump($userdata);

  } catch(FacebookRequestException $e) {
    echo "Exception occured, code: " . $e->getCode();
    echo " with message: " . $e->getMessage();
  }   
} else {
    echo "PHP: login";
}




?>