<?php
require_once('database.php');
$id = $_GET['id'];
$table = $_GET['object'];

$res = $database->delete($id, $table);
if ($res) {
  header('Location: /admin/');
} else {
  header('Location: /admin/?error=delete-complaint');
}
