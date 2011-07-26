<?php

function mysqliConnect($configFile) {
  //Load the database settings file  
  $settings = simplexml_load_file($configFile);
  //Validate the settings.xml file
  $errMsg = "";
  if ((string) $settings->mysql->username === "_USER_") {
    $errMsg .= "Please set the database <i>username</i> (./Neptune/model/framework/settings.xml <br />";
  }
  if ((string) $settings->mysql->password === "_PASSWORD_") {
    $errMsg .= "Please set the database <i>password</i> (./Neptune/model/framework/settings.xml <br />";
  }
  if ((string) $settings->mysql->database === "_DATABASE_") {
    $errMsg .= "Please set the database <i>name</i>(./Neptune/model/framework/settings.xml <br />";
  }

  if ($errMsg !== "") {
    printf("<h1>Neptune Error: </h1><p>" . $errMsg . '</p>');
    exit();
  }

  $con = mysqli_connect(
          (string) $settings->mysql->server, 
          (string) $settings->mysql->username, 
          (string) $settings->mysql->password, 
          (string) $settings->mysql->database);

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
