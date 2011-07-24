<?php
// -------------------------------------------------------------------------------------
// Copyright (c) 2010 Azimuth 360, LLC
// Author - Steven J. Zurek
// All rights reserved.
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
//                                   framework.php
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
//
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
//                                                                           DESCRIPTION
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// THIS FILE SETS THE PROPER INCLUDE PATH FOR THE REST OF THE MODULES, INCLUDES BASE
// MODULES, ENABLED MODULES, INITIATES THE SESSION OBJECTS, RUNS START UP SCRIPTS FOR
// EACH MODULE WHEN REQUIRED.
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
//                                                                               CLASSES
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// THIS FILE HAS NO CLASSES
//
$debug = false;
if($debug){
    error_reporting(E_ALL ^ E_NOTICE);
}
date_default_timezone_set('America/Denver');
//<editor-fold desc="SET INCLUDE PATH TO root/_modules/com/Neptune/model/">
$INCLUDE_PATH = __FILE__;
if (strpos($INCLUDE_PATH, ":") !== false) {
    $INCLUDE_PATH = substr($INCLUDE_PATH, strpos($INCLUDE_PATH, ":", 0) + 1, strlen($INCLUDE_PATH) - strpos($INCLUDE_PATH, ":", 0) + 1);
}
$INCLUDE_PATH = str_replace("/", "\\", $INCLUDE_PATH);
$INCLUDE_PATH = rtrim($INCLUDE_PATH, "framework\\framework.php");
$INCLUDE_PATH = str_replace("\\", "/", $INCLUDE_PATH);
set_include_path($INCLUDE_PATH . PATH_SEPARATOR . get_include_path());

//</editor-fold>
// <editor-fold desc="SET GLOBAL CONSTANTS">
$documentRoot = $_SERVER["DOCUMENT_ROOT"];

$serverName = $_SERVER["SERVER_NAME"];

$curFile = rtrim(substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1), ".php");

$serverName = $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
if (strpos($serverName, "?") !== false) {
    $serverName = substr($serverName, 0, strpos($serverName, "?"));
}
if (strpos($serverName, $curFile . '.php') !== false) {
    $serverName = substr($serverName, 0, strpos($serverName, $curFile . '.php'));
}
// </editor-fold>
//<editor-fold desc="COPY _GET VARS TO _POST VARS">
foreach ($_GET as $key => $value) {
    $_POST[$key] = $value;
}
//</editor-fold>
//<editor-fold desc="BASE INCLUDES BLOCK">
require_once('framework/core.php');
require_once('framework/configuration.php');
require_once('framework/dbcmanager.php');
require_once('framework/security.php');
require_once('framework/eventhandler.php');
//</editor-fold>
//<editor-fold desc="OPEN MYSQL DB CONNECTION">
$mysqlConnection = mysqliConnect($INCLUDE_PATH . "/framework/settings.xml");
//</editor-fold>
//<editor-fold desc="MODULE INCLUDES BLOCK">
$queryResults = runQuery("framework", "getModules.sql");
while ($queryRecord = mysqli_fetch_array($queryResults)) {
    require_once($queryRecord['module'] . "/" . $queryRecord['module'] . ".php");
}
//</editor-fold>
// <editor-fold desc="START SESSION">
if (!isset($_SESSION)) {
    session_start();
}
// </editor-fold>
// <editor-fold desc="LOAD MASTER SESSION">
if (!isset($_SESSION['MasterSession'])) {
    $_SESSION['MasterSession'] = new sessionManager();
}
$_SESSION['MasterSession']->loadSession();
// </editor-fold>
//<editor-fold desc="INITIATE BASE OBJECTS BLOCK">
if (!isset($_SESSION['MasterSession']->SESSION['SecurityMonitor'])) {
    $_SESSION['MasterSession']->SESSION['SecurityMonitor'] = new securityMonitor();
}
if (!isset($_SESSION['MasterSession']->SESSION['EventHandler'])) {
    $_SESSION['MasterSession']->SESSION['EventHandler'] = new EventHandler();
}
//</editor-fold>
//<editor-fold desc="INITIATE MODULE OBJECTS BLOCK">
$queryResults = runQuery("framework", "getSessionObjects.sql");
while ($module = mysqli_fetch_array($queryResults)) {
    require_once($module['module'] . "/" . $module['module'] . ".php");
    if (!isset($_SESSION['MasterSession']->SESSION[$module['sessionObject']])) {
        $_SESSION['MasterSession']->SESSION[$module['sessionObject']] = new $module['module']();
    }
}
//</editor-fold>
////<editor-fold desc="RUN BASE MODULE SCRIPTS BLOCK">
include("framework/autoexec.php");
//</editor-fold>
//<editor-fold desc="RUN MODULE SCRIPTS BLOCK">
$queryResults = runQuery("framework", "getModules.sql");
while ($queryRecord = mysqli_fetch_array($queryResults)) {
    if ($queryRecord['runStartupScript'] == 'true') {
        include($queryRecord['module'] . "/scripts/autoexec.php");

    }
}
//</editor-fold>

?>
