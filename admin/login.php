<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>관리자 로그인 - quantumcode</title>

    <!-- Favicon -->

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/css/core-style.css">
    <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/css/login.css">

    <!-- Bootstrap, jQuery -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  </head>
<body>

  <div class="d-flex">
    <aside>
      <div class="copy">
        <h2>Connect your Dream with Our passion</h2>
        <h3>everything you can imagine is can be possible with us</h3>
      </div>
    </aside>

    <div class="login_container d-flex flex-column justify-content-center align-items-center">
      <h1 class="main_tt">Admin Account</h1>
      <div class="row login_box">
        <form action="login_ok.php" method="POST">
          <div class="form-floating">
            <input type="text" class="form-control" id="userid" name="userid" placeholder="Admin">
            <label for="userid">Admin</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="userpw" name="userpw" placeholder="1111">
            <label for="userpw">1111</label>
          </div>
          <p class="mt-4 mb-4"><a href="#" class="forgotpw">Forgot Password?</a></p>
          <button class="btn btn-primary">Log in</button>
        </form>
      </div>
  </div>
    
  </div>

  
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?>
