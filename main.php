<?php 
require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;
$client->setClientId("1063843599243-gqe8u6vbsgtmr0l0tbiucna4c3d2b9st.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/salva+/main.php");

if ( ! isset($_GET["code"])){
    exit("Login failed");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
$client->setAccessToken($token["access_token"]);
$oauth = new Google\Service\Oauth2($client);
$userinfo = $oauth->userinfo->get();
/*
var_dump(
    $userinfo->email,
    $userinfo->familyName,
    $userinfo->givenName,
    $userinfo->name
);
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<table class="table table-striped table-dark"> 
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Email</th>
      <th scope="col">Usuario</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><?= $userinfo->givenName ?></td>
      <td><?= $userinfo->email ?></td>
      <td><?= $userinfo->name ?></td>
    </tr>
  </tbody>
</table>
    
</body>
</html>