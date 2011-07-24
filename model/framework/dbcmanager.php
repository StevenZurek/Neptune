<?php
function mysqliConnect($configFile) {
    $settings = simplexml_load_file($configFile);
    $con = mysqli_connect(
            (string)$settings->mysql->server,
            (string)$settings->mysql->username,
            (string)$settings->mysql->password,
            (string)$settings->mysql->database);
    if (mysqli_connect_errno()) {
      printf("Connection failed: %s\n", mysqli_connect_error());
      exit();
    }
    return $con;
}

class mysqlRow {
    function __construct() {
        foreach($this as $column => $value) {
            $this->$column = urldecode($value);
        }
    }
}

?>
