<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once('db/database.php');
require_once('db/errors.php');

if (isset($_GET['id_complaint']) && isset($_SESSION['user_id'])) {
  $id_complaint = $_GET['id_complaint'];
  $res = $database->read($id_complaint, 'complaints');
  $row = mysqli_fetch_assoc($res);
  $email = $row['email'];
  $country = $row['country'];
  $benefit = $row['benefit'];
  $tier = $row['tier'];
  $digits = $row['digits'];
  $description = $row['description'];
  $attachment = $row['attachment'];
  $date = $row['date'];
  $state = $row['state'];
} else {
  $id_complaint = null;
  $email = '';
  $country = 'Select a Country';
  $benefit = 'Select a Benefit';
  $tier = 'Select a Tier';
  $digits = '';
  $description = '';
  $attachment = '';
  $state = '';
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
  <!-- As a heading -->
  <nav class="navbar bg-primary">
    <?php
    if (isset($_SESSION['user_id']) && $_SESSION['user_rol'] == 1) { ?>
      <div class="container-fluid justify-content-end">
        <a class="navbar-brand h1 text-light mb-0 me-4 me-sm-5" href="/php_intermedio/admin/"><i class="bi bi-arrow-right"></i> Admin</a>
      </div>
    <?php } else { ?>
      <div class="container-fluid">
        <span class="navbar-brand h1"></span>
      </div>
    <?php } ?>
  </nav>

  <!-- FORM ADD COMPLAINT -->
  <section class="section-form d-flex p-5">
    <form class="w-100 m-auto needs-validation" id="complaint-form" enctype="multipart/form-data" novalidate onsubmit="return validateForm(event)">
      <div class="bg-primary text-light text-center text-uppercase py-2 mb-4">
        <h5 class="mb-0">Complaints - <?= date("D d/m/Y"); ?></h5>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" aria-describedby="emailHelp" placeholder="contact@email.com" value="<?= $email; ?>" required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>

      <div class="mb-3 d-flex flex-wrap align-items-start justify-content-between">
        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
          <label for="country" class="form-label">Country</label>
          <select class="form-select" name="country" id="country" required>
            <?php if (isset($country)) {
              echo '<option value="' . $country . '" selected hidden>' . $country . '</option>';
            } ?>
          </select>
        </div>

        <div class="col-12 col-sm-5 mb-2 mb-sm-0">
          <label for="benefit" class="form-label">Benefit</label>
          <select class="form-select" name="benefit" id="benefit" required>
            <?php if (isset($benefit)) {
              echo '<option value="' . $benefit . '" selected hidden>' . $benefit . '</option>';
            } ?>
          </select>
        </div>
      </div>

      <div class="mb-1 d-flex flex-wrap align-items-start justify-content-between">
        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
          <label for="tier" class="form-label">Tier</label>
          <select class="form-select" name="tier" id="tier" required>
            <?php if (isset($tier)) {
              echo '<option value="' . $tier . '" selected hidden>' . $tier . '</option>';
            } ?>
            <option value="Standard">Standard</option>
            <option value="Gold">Gold</option>
            <option value="Platinum">Platinum</option>
          </select>
        </div>

        <div class="col-12 col-sm-5 mb-2 mb-sm-0">
          <label for="digits" class="form-label">Digits Card</label>
          <input type="text" class="form-control" name="digits" id="digits" minlength="6" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" aria-describedby="digitsHelp" placeholder="123123" value="<?= $digits; ?>" required>
          <div id="digitsHelp" class="form-text">Min 6 numbers, max 8.</div>
        </div>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Message ..." required><?= $description; ?></textarea>
      </div>

      <div class="mb-4">
        <label for="attachment" class="form-label">Attachment</label>
        <input type="file" class="form-control media" name="attachment" id="attachment" accept=".jpg,.jpeg,.xls,.xlsx,.pdf,.csv" aria-describedby="attachmentHelp">
        <div id="attachmentHelp" class="form-text">Accept jpg, jpeg, xls, xlsx, csv, pdf. Max 5mb.</div>
      </div>

      <input type="hidden" name="id_complaint" value="<?= $id_complaint; ?>">

      <button type="submit" name="submit" class="btn btn-lg btn-primary btn-submit w-100 d-flex align-items-center justify-content-center">
        <span id="textSubmit">Submit</span>
        <div id="loader" class="loadingio-spinner-rolling-d3wiswqexi d-none">
          <div class="ldio-7t30krv4zsh">
            <div></div>
          </div>
        </div>
      </button>
    </form>
  </section>

  <script src="./assets/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>