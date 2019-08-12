<?php
  include 'inc/ServerConstants.php';
  include 'inc/DatabaseUtil.php';

  $conn = new mysqli($servername, $username, $password, $db_name);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // table doesn't exist
  if (!isTableExist($table_name, $conn)) {
    echo 3;
    die();
  }

  $usr = htmlspecialchars(stripcslashes(trim($_POST['name'])));
  $pwd = md5(htmlspecialchars(stripcslashes(trim($_POST['pwd']))));

  $format = "SELECT * FROM $table_name WHERE username = %s";
  $sql = sprintf($format, $usr);
  $result = $conn->query($sql);
  if ($result->num_rows == 0) {
    echo 3;
    die();
  }
  $row = mysqli_fetch_array($result);
  echo $row['password'] == $pwd;
?>