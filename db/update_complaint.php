<?php
// Update field when change state filter in admin page
require_once('database.php');
$id = $_GET['id'];

$res = $database->read($id, 'complaints');
$res = mysqli_fetch_assoc($res);

$upd_complaint['state'] = $_GET['state'];
$upd_complaint['email'] = $res['email'];
$upd_complaint['country'] = $res['country'];
$upd_complaint['benefit'] = $res['benefit'];
$upd_complaint['tier'] = $res['tier'];
$upd_complaint['digits'] = $res['digits'];
$upd_complaint['description'] = $res['description'];

$res = $database->update($id, $upd_complaint, 'complaints');
if ($res) {
  header('Location: /php_intermedio/admin/');
} else {
  header('Location: /php_intermedio/admin/?error=update-state');
}
