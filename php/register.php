<?php
  include 'inc/ServerConstants.php';
  include 'inc/DatabaseUtil.php';

  $conn = new mysqli($servername, $username, $password, $db_name);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $type = $_GET['type'];
  if ($type == 'register') {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // simple protection
        $usr =  htmlspecialchars(stripcslashes(trim($_POST['usr'])));
        $pwd =  md5(htmlspecialchars(stripcslashes(trim($_POST['pwd']))));
        $pwd2 =  md5(htmlspecialchars(stripcslashes(trim($_POST['pwd_conf']))));
        $email = htmlspecialchars(stripcslashes(trim($_POST['email'])));

        if (!isTableExist($table_name, $conn)) {
          $conn->query("CREATE TABLE loginData (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(15) NOT NULL,
            password VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);");
        }

        // validate input
        $format = "SELECT * FROM $table_name WHERE username = %s";
        $sql = sprintf($format, $usr);
        $result = $conn->query($sql);
        if ($result->num_rows == 0 && $pwd == $pwd2) {
            $format = "INSERT INTO loginData (username, password, email) VALUES ('%s', '%s', '%s');";
            $sql = sprintf($format, $usr, $pwd, $email);
            $conn->query($sql);
        }
      }
  }
  else if ($type == 'checkUsr') {
      if (!isTableExist($table_name, $conn)) {
        echo 1;
      }
      else {
        $usr = htmlspecialchars(stripcslashes(trim($_POST['name'])));
        $format = "SELECT * FROM $table_name WHERE username = %s";
        $sql = sprintf($format, $usr);
        $result = $conn->query($sql);
        echo $result->num_rows == 0;
      }
  }
?>