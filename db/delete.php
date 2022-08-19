<?php
require_once('database.php');
$id = $_GET['id'];
$table = $_GET['object'];

$res = $database->delete($id, $table);
if ($res) {
  header('Location: /php_intermedio/admin/');
} else {
  header('Location: /php_intermedio/admin/?error=delete-complaint');
}
