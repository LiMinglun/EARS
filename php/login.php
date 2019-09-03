<?php
  include 'inc/ServerConstants.php';
  include 'inc/DatabaseUtil.php';

  $conn = new mysqli($servername, $username, $password, $db_name);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $type = $_GET['type'];

  if ($type == 'login') {
    // table doesn't exist
    if (!isTableExist($table_name, $conn)) {
      echo 3;
      die();
    }

    $usr = htmlspecialchars(stripcslashes(trim($_POST['name'])));
    $pwd = htmlspecialchars(stripcslashes(trim(md5($_POST['pwd']))));

    $format = "SELECT * FROM $table_name WHERE username = %s";
    $sql = sprintf($format, $usr);
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
      echo 3;
      die();
    }
    $row = mysqli_fetch_array($result);
    echo $row['password'] == $pwd ? "1".$pwd : 0;
  }
  else if ($type == 'cookieLogin') {
    if (!isTableExist($table_name, $conn)) {
      echo 0;
      die();
    }
    $usr = htmlspecialchars(stripcslashes(trim($_POST['usr'])));
    $pwd = htmlspecialchars(stripcslashes(trim($_POST['pwd'])));
    $format = "SELECT * FROM $table_name WHERE username = %s";
    $sql = sprintf($format, $usr);
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
      echo 0;
      die();
    }
    $row = mysqli_fetch_array($result);
    echo $row['password'] == $pwd;
  }
?>