<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once('../db/database.php');

if (isset($_POST['submit-register'])) {
  if (empty($_POST['user_name']) || empty($_POST['user_email']) || empty($_POST['user_password']) || empty($_POST['user_password_repeat'])) {
    echo "<script>alert('Complete all fields')</script>";
  } else {
    $register['user_name'] = $_POST['user_name'];
    $register['user_email'] = $_POST['user_email'];
    $register['user_password'] = $_POST['user_password'];
    $user = $database->create($register, 'users');
    if (!$user) {
      echo "<script>alert('Error creating user')</script>";
    } else {
      header("Location: /php_intermedio/admin/login.php?success=create-user");
      exit();
    }
  }
}

if (isset($_SESSION['user_id'])) {
  header("Location: /php_intermedio/admin/");
  exit();
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

  <main class="form-register w-100 p-3">
    <form id="register-complaint-form" class="needs-validation" novalidate onsubmit="return validateFormRegister(event)">
      <img src="../assets/img/logo.png" alt="" width="130" height="130">
      <h3 class="mb-3 fw-normal">Register</h3>
      <div class="form-floating">
        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="John Sebastian" required>
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="name@example.com" required>
        <label for="floatingInput">Email</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" minlength="6" maxlength="8" required>
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat" placeholder="Password" minlength="6" maxlength="8" required>
        <label for="floatingPassword">Confirm Password</label>
      </div>
      <button class="btn btn-lg btn-primary btn-submit w-100 d-flex align-items-center justify-content-center" type="submit" name="submit-register">
        <span id="textSubmit">Submit</span>
        <div id="loader" class="loadingio-spinner-rolling-d3wiswqexi d-none">
          <div class="ldio-7t30krv4zsh">
            <div></div>
          </div>
        </div>
      </button>

      <p class="mt-4 text-muted">&copy; Monster Card – <?= date('d/m/Y') ?></p>

      <a href="/php_intermedio/admin/login.php" class="fw-semibold text-secondary text-decoration-none">Have you already registered? Enter here</a>
    </form>
  </main>

  <script src="../assets/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>