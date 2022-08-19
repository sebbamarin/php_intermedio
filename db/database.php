<?php
DEFINE('DB_USERNAME', 'root');
DEFINE('DB_PWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'php_intermedio');

// CLASS DB CONNECTION
class Database
{
  private $connection;

  function __construct()
  {
    $this->connect_db();
  }

  public function connect_db()
  {
    $this->connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PWD, DB_NAME);
    if (mysqli_connect_error()) {
      die("Database Connection Failed" . mysqli_connect_error() . mysqli_connect_errno());
    }
  }

  public function create($params, $table)
  {
    foreach ($params as $key => $value) {
      if ($key == 'user_password') {
        $value = password_hash($value, PASSWORD_BCRYPT);
      }
      $keys[] = $key;
      $values[] = "'" . $value . "'";
    }
    $keys = implode(',', $keys);
    $values = implode(',', $values);
    $sql = "INSERT INTO $table ($keys) VALUES ($values)";
    $result = mysqli_query($this->connection, $sql);
    if ($result) {
      return mysqli_insert_id($this->connection);
    } else {
      return false;
    }
  }

  public function read($id = null, $table)
  {
    $sql = "SELECT * FROM $table";
    if ($id) {
      $sql .= " WHERE id=$id";
    }
    $res = mysqli_query($this->connection, $sql);
    return $res;
  }

  public function update($id, $params, $table)
  {
    $sql = "UPDATE $table SET ";
    foreach ($params as $key => $value) {
      $sql .= "$key='$value',";
    }
    $sql = rtrim($sql, ',');
    $sql .= " WHERE id=$id";
    $result = mysqli_query($this->connection, $sql);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  public function delete($id, $table)
  {
    $file = $this->read($id, $table);
    $file = mysqli_fetch_assoc($file);
    $sql = "DELETE FROM $table WHERE id=$id";
    $res = mysqli_query($this->connection, $sql);
    if ($res) {
      unlink(' /uploads/' . $file['attachment']);
      return true;
    } else {
      return false;
    }
  }

  public function filterDistinct($field, $table)
  {
    $sql = "SELECT DISTINCT $field FROM $table";
    $res = mysqli_query($this->connection, $sql);
    return $res;
  }

  public function filter($data, $table)
  {
    $sql = "SELECT * FROM $table";
    if (count($data) > 0) {
      $sql .= " WHERE " . implode(' AND ', $data);
    }
    $res = mysqli_query($this->connection, $sql);
    return $res;
  }

  public function sanitize($var)
  {
    $return = mysqli_real_escape_string($this->connection, $var);
    return $return;
  }

  public function login($email, $password)
  {
    $sql = "SELECT * FROM users WHERE user_email='$email'";
    $res = mysqli_query($this->connection, $sql);
    $result = mysqli_fetch_assoc($res);
    if (!$result) {
      return false;
    } elseif (password_verify($password, $result['user_password'])) {
      return $result;
    } else {
      return false;
    }
  }
}

$database = new Database();
