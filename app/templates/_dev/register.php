<?php
require_once ("config/system_head.php");

header("Content-Type: text/plain");

if (isset($_POST["name"]) && $_POST["name"] != "" && isset($_POST["email"]) && $_POST["email"]) {
    if (!$_SESSION["id"]) {
        
        $username = $_POST["name"];
        $email = $_POST["email"];
        
        $userdata = $app->checkUser($_SESSION["id"], null, 'email', $username, $email);
        
        $_SESSION['id'] = $userdata['id'];
        $_SESSION['oauth_id'] = $userdata['id'];

      
        $_SESSION['username'] = $userdata['username'];
        $_SESSION['oauth_provider'] = "email";
        
        
        echo json_encode(array('done' => $userdata['username']));
    } else {



        echo json_encode(array('done' => "jau ir sesija! ".$_POST["name"]));
    }
} else {
    echo json_encode(array('error' => "error post data "));
    exit;
}
?>