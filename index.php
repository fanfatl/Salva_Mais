<?php
require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;
$client->setClientId("1063843599243-gqe8u6vbsgtmr0l0tbiucna4c3d2b9st.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/salva+/main.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="<?= $url ?>">Sign in with google</a>
</body>
</html>