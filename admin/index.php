<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once('../db/database.php');
require_once('../db/errors.php');

if (isset($_GET['filter']) && $_GET['filter'] == 'complaints') {
  foreach ($_GET as $key => $value) {
    if ($key != 'filter') {
      $data[] = "$key='$value'";
    }
  }
  $res = $database->filter($data, $_GET['filter']);
  $table = $database->filter($data, $_GET['filter']);
} else {
  $res = $database->read('', 'complaints');
  $table = $database->read('', 'complaints');
}

if (isset($_SESSION['user_id']) && $_SESSION['user_rol'] == 1) {
  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];
  $user_email = $_SESSION['user_email'];
} elseif (isset($_SESSION['user_id']) && $_SESSION['user_rol'] != 1) {
  header('Location: /php_intermedio/admin/login.php?error=user-permission');
} else {
  header('Location: /php_intermedio/admin/login.php');
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
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
  <!-- As a heading -->
  <nav class="navbar bg-primary">
    <div class="container-fluid justify-content-end">
      <div class="user me-2">
        <img src="https://play-lh.googleusercontent.com/ahJtMe0vfOlAu1XJVQ6rcaGrQBgtrEZQefHy7SXB7jpijKhu1Kkox90XDuH8RmcBOXNn" width="50" height="50" alt="" class="rounded-pill me-1">
        <button class="btn btn-primary text-uppercase" onclick="openModal('editUser');"><?= $user_name; ?></button>
      </div>
      <a class="btn btn-primary mb-0 me-4 me-sm-5" href="/db/logout.php">Logout <i class="bi bi-arrow-right"></i></a>
    </div>
  </nav>

  <section class="section-admin p-5">
    <div class="text-center text-lg-start mb-4">
      <button type="button" class="btn btn-primary" id="btnExport" onclick="exportTableToExcel('complaints_<?= date('d_m_Y') ?>.xls')">Export to Excel</button>
    </div>
    <!-- FILTERS -->
    <div class="filter d-flex flex-wrap flex-lg-nowrap mb-4 gap-4 mx-auto">
      <select class="form-select" id="filter_digits" onchange="filter_change(this)">
        <option>Digits</option>
        <?php
        $digitsSelect = $database->filterDistinct('digits', 'complaints');
        $digitsSelect = mysqli_fetch_all($digitsSelect, MYSQLI_ASSOC);
        foreach ($digitsSelect as $d) {
        ?>
          <option value="<?= $d['digits']; ?>"><?= $d['digits']; ?></option>
        <?php } ?>
      </select>
      <select class="form-select" id="filter_benefit" onchange="filter_change(this)">
        <option>Benefit</option>
        <?php
        $benefitSelect = $database->filterDistinct('benefit', 'complaints');
        $benefitSelect = mysqli_fetch_all($benefitSelect, MYSQLI_ASSOC);
        foreach ($benefitSelect as $b) {
        ?>
          <option value="<?= $b['benefit']; ?>"><?= $b['benefit']; ?></option>
        <?php } ?>
      </select>
      <select class="form-select" id="filter_tier" onchange="filter_change(this)">
        <option>Tier</option>
        <?php
        $tierSelect = $database->filterDistinct('tier', 'complaints');
        $tierSelect = mysqli_fetch_all($tierSelect, MYSQLI_ASSOC);
        foreach ($tierSelect as $t) {
        ?>
          <option value="<?= $t['tier']; ?>"><?= $t['tier']; ?></option>
        <?php } ?>
      </select>
      <select class="form-select" id="filter_country" onchange="filter_change(this)">
        <option>Country</option>
        <?php
        $countrySelect = $database->filterDistinct('country', 'complaints');
        $countrySelect = mysqli_fetch_all($countrySelect, MYSQLI_ASSOC);
        foreach ($countrySelect as $c) {
        ?>
          <option value="<?= $c['country']; ?>"><?= $c['country']; ?></option>
        <?php } ?>
      </select>
      <select class="form-select" id="filter_email" onchange="filter_change(this)">
        <option>Email</option>
        <?php
        $emailSelect = $database->filterDistinct('email', 'complaints');
        $emailSelect = mysqli_fetch_all($emailSelect, MYSQLI_ASSOC);
        foreach ($emailSelect as $e) {
        ?>
          <option value="<?= $e['email']; ?>"><?= $e['email']; ?></option>
        <?php } ?>
      </select>
      <select class="form-select" id="filter_date" onchange="filter_change(this)">
        <option>Date</option>
        <?php
        $dateSelect = $database->filterDistinct('date', 'complaints');
        $dateSelect = mysqli_fetch_all($dateSelect, MYSQLI_ASSOC);
        foreach ($dateSelect as $d) {
        ?>
          <option value="<?= $d['date']; ?>"><?= $d['date']; ?></option>
        <?php } ?>
      </select>
      <select class="form-select" id="filter_state" onchange="filter_change(this)">
        <option>State</option>
        <?php
        $stateSelect = $database->filterDistinct('state', 'complaints');
        $stateSelect = mysqli_fetch_all($stateSelect, MYSQLI_ASSOC);
        foreach ($stateSelect as $st) {
        ?>
          <option value="<?= $st['state']; ?>"><?php switch ($st['state']) {
                                                  case 1:
                                                    echo 'Pending';
                                                    break;
                                                  case 2:
                                                    echo 'In process';
                                                    break;
                                                  case 3:
                                                    echo 'Resolved';
                                                    break;
                                                  case 4:
                                                    echo 'Cancelled';
                                                    break;
                                                } ?></option>
        <?php } ?>
      </select>
      <div class="d-flex gap-2">
        <button type="button" id="btn_filter" class="btn btn-primary" disabled onclick="filter_list()">Filter</button>
        <button type="button" class="btn btn-dark" onclick="window.location.href = '/php_intermedio/admin/'">Clear</button>
      </div>
    </div>
    <!-- TABLE -->
    <div class="container-table w-100 overflow-auto">
      <table class="table table-bordered table-hover" style="min-width: 1620px;" id='table_complaints'>
        <thead class="table-light">
          <tr class="text-center">
            <th scope="col" class="d-none">ID</th>
            <th scope="col">Digits</th>
            <th scope="col">Benefit</th>
            <th scope="col">Tier</th>
            <th scope="col">Country</th>
            <th scope="col">Description</th>
            <th scope="col">Email</th>
            <th scope="col">Date</th>
            <th scope="col">State</th>
            <th scope="col">Attachment</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($res->num_rows > 0) {
            while ($r = mysqli_fetch_assoc($res)) {
          ?>
              <tr class="text-center">
                <td class="d-none"><?= $r['id']; ?></td>
                <td><?= $r['digits']; ?></td>
                <td><?= $r['benefit']; ?></td>
                <td><?= $r['tier']; ?></td>
                <td><?= $r['country']; ?></td>
                <td><?= $r['description']; ?></td>
                <td><?= $r['email']; ?></td>
                <td><?= $r['date']; ?></td>
                <td style="min-width: 130px;">
                  <select class="form-select" name="tier" id="tier" onchange="window.location.href = '/db/update_complaint.php/?id='+<?= $r['id']; ?>+'&&state='+this.value">
                    <option value="1" <?= $r['state'] == '1' || $r['state'] == null ? 'selected' : ''; ?>>Pending</option>
                    <option value="2" <?= $r['state'] == '2' ? 'selected' : ''; ?>>In process</option>
                    <option value="3" <?= $r['state'] == '3' ? 'selected' : ''; ?>>Resolved</option>
                    <option value="4" <?= $r['state'] == '4' ? 'selected' : ''; ?>>Cancelled</option>
                  </select>
                </td>
                <td><?= $r['attachment']; ?></td>
                <td style="min-width: 160px;">
                  <?php if ($r['attachment'] != 'No') { ?>
                    <button type="button" class="btn btn-primary text-uppercase" onclick="window.location.href = '/php_intermedio/admin/download_attachment.php?path=<?= $r['attachment']; ?>'"><i class="bi bi-download"></i></button>
                  <?php } ?>
                  <button type="button" class="btn btn-warning text-uppercase" onclick="window.location.href = '/?id_complaint=<?= $r['id']; ?>'"><i class="bi bi-pencil-square"></i></button>
                  <button type="button" class="btn btn-danger text-uppercase" onclick="confirm('Do you want to delete the complaint?') ? window.location.href = '/db/delete.php/?id='+<?= $r['id']; ?>+'&object=complaints' : ''"><i class="bi bi-trash3-fill"></i></button>
                </td>
              </tr>
            <?php }
          } else { ?>
            <tr class="text-center">
              <td colspan="11">
                <h5 class="py-4">No complaints found</h5>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </section>

  <!-- DOWNLOAD TABLE -->
  <table id='table_complaints_download' style="display: none;">
    <thead>
      <tr>
        <th scope="col">Digits</th>
        <th scope="col">Benefit</th>
        <th scope="col">Tier</th>
        <th scope="col">Country</th>
        <th scope="col">Description</th>
        <th scope="col">Email</th>
        <th scope="col">Date</th>
        <th scope="col">State</th>
        <th scope="col">Attachment</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($table->num_rows > 0) {
        while ($td = mysqli_fetch_assoc($table)) {
      ?>
          <tr>
            <td><?= $td['digits']; ?></td>
            <td><?= $td['benefit']; ?></td>
            <td><?= $td['tier']; ?></td>
            <td><?= $td['country']; ?></td>
            <td><?= $td['description']; ?></td>
            <td><?= $td['email']; ?></td>
            <td><?= $td['date']; ?></td>
            <td><?= $td['state']; ?></td>
            <td><?= $td['attachment']; ?></td>
          </tr>
        <?php }
      } else { ?>
        <tr>
          <td colspan="11">
            <h5>No complaints found</h5>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <!-- DOWNLOAD TABLE -->

  <!-- MODAL -->
  <!-- Modal Edit User -->
  <!-- <div class="modal-dialog modal-dialog-centered">
    <form>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">User name</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div> -->
  <!-- MODAL -->

  <script src="../assets/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>