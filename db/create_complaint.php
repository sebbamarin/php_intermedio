<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once('database.php');

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PWD, DB_NAME);

if (!isset($_POST['email']) || !isset($_POST['country']) || !isset($_POST['benefit']) || !isset($_POST['tier']) || !isset($_POST['digits']) || !isset($_POST['description'])) {
    header('Location: /?error=emptyfields');
} else {
    $digits = $_POST['digits'];
    $benefit = $_POST['benefit'];
    $tier = $_POST['tier'];
    $country = $_POST['country'];
    $description = $_POST['description'];
    $email = $_POST['email'];
    $date = date("d/m/Y");

    if ($_FILES['attachment']['size'] == 0) {
        if ($_POST['id_complaint'] == null) {
            $sql = "INSERT INTO complaints (email, country, benefit, tier, digits, description, date) VALUES ('$email', '$country', '$benefit', '$tier', '$digits', '$description', '$date')";
        } else {
            $sql = "UPDATE complaints SET email = '$email', country = '$country', benefit = '$benefit', tier = '$tier', digits = '$digits', description = '$description', date = '$date' WHERE id = " . $_POST['id_complaint'];
        }
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            header('Location: /?error=submit-complaint');
        } else {
            header('Location: ../?success=submit-complaint');
        }
    } else {
        $at = $_FILES['attachment'];
        $atName = $at['name'];
        $atType = $at['type'];
        $atSize = $at['size'];
        $atTmpName = $at['tmp_name'];
        $atError = $at['error'];
        $atExt = explode('.', $atName);
        $atActualExt = strtolower(end($atExt));
        $allowed = array('jpg', 'jpeg', 'xls', 'xlsx', 'csv', 'pdf');

        if (!in_array($atActualExt, $allowed)) {
            header('Location: /?error=invalidattachment');
        } else if ($atError === 0) {
            if ($atSize > 5000000) {
                header('Location: /?error=sizeattachment');
            } else {
                // Check if file already exists
                if (file_exists(' /uploads/' . $atName)) {
                    header('Location: /?error=existsattachment');
                } else {
                    $atDestination = ' /uploads/' . $atName;
                    move_uploaded_file($atTmpName, $atDestination);
                    if ($_POST['id_complaint'] == null) {
                        $sql = "INSERT INTO complaints (email, country, benefit, tier, digits, description, attachment, date) VALUES ('$email', '$country', '$benefit', '$tier', '$digits', '$description', '$atName', '$date')";
                    } else {
                        $sql = "UPDATE complaints SET email = '$email', country = '$country', benefit = '$benefit', tier = '$tier', digits = '$digits', description = '$description', attachment = '$atName', date = '$date' WHERE id = " . $_POST['id_complaint'];
                    }
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        header('Location: ../?error=submit-complaint');
                    } else {
                        header('Location: ../?success=submit-complaint');
                    }
                }
            }
        } else {
            header('Location: /?error=upload-attachment');
        }
    }
}

mysqli_close($conn);
