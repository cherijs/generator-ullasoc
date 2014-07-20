<?php
if (array_key_exists("logout", $_GET)) {
    session_start();
    
    unset($_SESSION['oauth_provider']);
    unset($_SESSION['id']);
    unset($_SESSION['fb_token']);
    unset($_SESSION['valid']);
    unset($_SESSION['timeout']);
    unset($_SESSION['FB']);
    unset($_SESSION['username']);
    unset($_SESSION['oauth_id']);
    unset($_SESSION['genderFB']);
    unset($_SESSION["signed_request"]);
    unset($_SESSION["request_ids"]);
    unset($_SESSION["rescue"]);

    
    session_destroy();
    
    // session_destroy();
    header("location: index.php");
}
?>
