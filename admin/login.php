<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once('../db/database.php');
require_once('../db/errors.php');

if (isset($_SESSION['user_id']) && $_SESSION['user_rol'] == 1) {
  header("Location: /admin/");
  exit();
}

if (isset($_POST['submit-login'])) {
  if (empty($_POST['email']) || empty($_POST['password'])) {
    echo "<script>alert('Complete email and password')</script>";
  } else {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = $database->login($email, $password);
    if (!$user) {
      echo "<script>alert('Email or password wrongs')</script>";
    } else {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['user_name'];
      $_SESSION['user_email'] = $user['user_email'];
      $_SESSION['user_rol'] = $user['user_rol'];
      header("Location: /admin");
      exit();
    }
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="https://ferozo.email/skins/larry/images/favicon.ico" type="image/x-icon">
  <title>MONSTERCARD - Complaints</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    html {
      height: 100%;
    }
  </style>
</head>

<body class="h-100 d-flex align-items-center justify-content-center bg-light text-center">

  <main class="form-signin w-100 p-3">
    <form id="login-complaint-form" class="needs-validation" novalidate onsubmit="return validateFormLogin(event)">
      <img src="../assets/img/logo.png" alt="" width="130" height="130">
      <h3 class="mb-3 fw-normal">Sign in</h3>
      <div class="form-floating">
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
        <label for="floatingInput">Email</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" minlength="6" maxlength="8" required>
        <label for="floatingPassword">Password</label>
      </div>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember-me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-submit w-100 d-flex align-items-center justify-content-center" type="submit" name="submit-login">
        <span id="textSubmit">Submit</span>
        <div id="loader" class="loadingio-spinner-rolling-d3wiswqexi d-none">
          <div class="ldio-7t30krv4zsh">
            <div></div>
          </div>
        </div>
      </button>

      <p class="mt-4 text-muted">&copy; MonsterCard – <?= date('d/m/Y') ?></p>

      <a href="/admin/register.php" class="fw-semibold text-secondary text-decoration-none">You are not registered? Do it here</a>
    </form>
  </main>

  <script src="../assets/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>