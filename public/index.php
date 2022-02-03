<?php

require "../vendor/autoload.php";

use eftec\bladeone\Bladeone;
use Dotenv\Dotenv;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

session_start();

// $dotenv = new Dotenv(__DIR__);
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$clientID = $_ENV['CLIENT_ID'];
$clientSecret = $_ENV['CLIENT_SECRET'];
$redirectUri = 'http://localhost:8000';

$header = "INFORMACION CATASTRAL";
$email = "";

if (isset($_SESSION['name'])) {
    if (isset($_GET['botonpetlogout'])) {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', 0, '/');
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
//     $service = new Google_Service_Oauth2($client);
        $client->addScope("profile");

        $url = $client->createAuthUrl();
        echo $blade->run('formlogin', compact('url'));
    } else {
        $email = $_SESSION['email'];
        $name = $_SESSION['name'];
        $picture = $_SESSION['picture'];
        echo $blade->run('private', compact('email', 'picture', 'name'));
    }
} else if (empty($_POST)) {
// authenticate code from Google OAuth Flow
    if (isset($_GET['code'])) {
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $code = filter_input(INPUT_GET, 'code');
        $token = $client->fetchAccessTokenWithAuthCode($code);

// get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email = $google_account_info->email;
        $picture = $google_account_info->picture;
        $name = $google_account_info->givenName;
        
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['picture'] = $picture;
        $revoked = $client->revokeToken($token);

        echo $blade->run('private', compact('email', 'picture', 'name'));

// Usuario identificado
    } else {
// init configuration
// create Client Request to access Google API
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
//     $service = new Google_Service_Oauth2($client);
        $client->addScope("profile");

        $url = $client->createAuthUrl();

        echo $blade->run('formlogin', compact('url'));
    }
}

