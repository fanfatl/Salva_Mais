<?php 
require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;
$client->setClientId("1063843599243-gqe8u6vbsgtmr0l0tbiucna4c3d2b9st.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/salva+/receive_data.php");

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

<div class="container">
  <h2>User Information</h2>
  <form action="crud/create.php" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userinfo->email); ?>" readonly>
    </div>
    <div class="form-group">
      <label for="familyName">Family Name:</label>
      <input type="text" class="form-control" id="familyName" name="familyName" value="<?php echo htmlspecialchars($userinfo->familyName); ?>" readonly>
    </div>
    <div class="form-group">
      <label for="givenName">Given Name:</label>
      <input type="text" class="form-control" id="givenName" name="givenName" value="<?php echo htmlspecialchars($userinfo->givenName); ?>" readonly>
    </div>
    <div class="form-group">
      <label for="name">Full Name:</label>
      <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userinfo->name); ?>" readonly>
    </div>
    <div class="form-group">
      <label for="cpf">CPF:</label>
      <input type="text" class="form-control cpf-mask" id="cpf" name="cpf" placeholder="000.000.000-00" required>
      <div id="cpf-error" class="text-danger" style="display: none;">CPF inválido</div>
    </div>
    <button type="submit" class="btn btn-primary">Save to Database</button>
  </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
  $(document).ready(function(){
    $('.cpf-mask').mask('000.000.000-00', {reverse: true});
    $('#cpf').on('blur', function() {
      var cpf = $(this).val();
      $.ajax({
        url: 'validar_cpf.php',
        type: 'POST',
        data: { cpf: cpf },
        dataType: 'json',
        success: function(response) {
          if (response.valid) {
            $('#cpf-error').hide();
          } else {
            $('#cpf-error').show();
          }
        }
      });
    });
  });
</script>
    
</body>
</html>