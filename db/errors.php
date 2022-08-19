<?php

if (isset($_GET['error'])) {
  $error = '';
  switch ($_GET['error']):
    case 'emptyfields':
      $error = 'Fill in all fields';
      break;
    case 'submit-complaint':
      $error = 'Error submitting complaint';
      break;
    case 'invalidattachment':
      $error = 'Uploaded attachment not supported';
      break;
    case 'sizeattachment':
      $error = 'Attachment too big';
      break;
    case 'existsattachment':
      $error = 'This attachment already exists in our database';
      break;
    case 'upload-attachment':
      $error = 'Error uploading attachment';
      break;
    case 'update-state':
      $error = 'Error updating state';
      break;
    case 'delete-complaint':
      $error = 'Error deleting complaint';
      break;
    case 'user-permission':
      $error = 'User without permission to enter';
      break;
    default:
      $error = 'Error';
      break;
  endswitch;
  echo '<script>alert("Error: '.$error.'")</script>';

} else if (isset($_GET['success'])) {
  $success = '';
  switch ($_GET['success']):
    case 'submit-complaint':
      $success = 'Complaint submitted successfully!';
      break;
    case 'create-user':
      $success = 'User created successfully!';
      break;
    default:
      $success = 'Successfully!';
      break;
  endswitch;
  echo '<script>alert("' . $success . '")</script>';
}
