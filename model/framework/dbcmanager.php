<?php
function mysqliConnect($configFile) {
  //Load the database settings file  
  $settings = simplexml_load_file($configFile);
var_dump ($settings);
exit();
  //Validate the settings.xml file
  if ((string) $settings->mysql->username === "_USER_") {
    $errMsg = "Please set the database username (./Neptune/model/framework/settings.xml\n";
  }
  if ((string) $settings->mysql->password === "_PASSWORD_") {
    $errMsg = "Please set the database password (./Neptune/model/framework/settings.xml\n";
  }
  if ((string) $settings->mysql->database === "_DATABASE_") {
    $errMsg = "Please set the database name (./Neptune/model/framework/settings.xml\n";
  }
  
  if(isset($errMsg)){
    printf("Neptune Error:" + $errMsg);
    exit();
  }
  
  $con = mysqli_connect(
          (string) $settings->mysql->server, (string) $settings->mysql->username, (string) $settings->mysql->password, (string) $settings->mysql->database);

  if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
  }
  return $con;
}

class mysqlRow {
  function __construct() {
    foreach ($this as $column => $value) {
      $this->$column = urldecode($value);
    }
  }
}
?>
