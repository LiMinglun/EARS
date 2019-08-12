<?php
  function isTableExist($table, $conn) {
    $row = $conn->query("SHOW TABLES LIKE '$table'");
    if (isset($row->num_rows)) {
      return $row->num_rows == 1;
    }
    return false;
  }
?>