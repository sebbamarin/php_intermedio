<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: /admin/');
}

if(isset($_GET['path'])){
  $path = $_GET['path'];
  if (file_exists(' /uploads/' . $path)) {
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . $path . "\"");
    readfile(' /uploads/'.$path);
  }
}

header('Location: /admin/');