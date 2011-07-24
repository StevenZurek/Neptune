<?php
// <editor-fold desc="PATTERNS">
$pattern_Date = '/[0-9]{4}-{1}[0-9]{2}-{1}[0-9]{2}+/';
$pattern_State = '/\D{2}/';
$pattern_Zip = '/.{4,}/';
// </editor-fold>    
class debugger {
    public $enabled;
    
    public function report($string){
        if($this->enabled == true){
            echo $string . '<br/>' . chr(10);
        }
    }
}
class eventDriver {

    public $parent;

    function __construct() {
        $this->parent = get_class($this);
    }

    protected function reportResult($errorID, $process, $returnData = false) {
        $this->resultID = (string) $errorID;
        $_SESSION['MasterSession']->SESSION['EventHandler']->handle($this->parent, $process, $this->resultID, $returnData);
    }

}

class Module extends eventDriver {

    public $resultID;
    public $requestData;
    protected $version;
    protected $title;
    protected $adminEnabled;

    function __construct() {
        parent::__construct();
        $this->version = "1.0";
        $this->title = get_class($this);
        $this->adminEnabled = false;
    }

    function __destruct() {
        unset($this->requestData);
    }

    public function getInfo() {
        $info = array();
        $info['version'] = $this->version;
        $info['title'] = $this->title;
        $info['name'] = $this->parent;
        $info['adminEnabled'] = $this->adminEnabled;
        return $info;
    }

}

class sessionManager extends eventDriver{

    private $sessions;
    public $SESSION;

    function __construct() {
        $this->parent = "CORE";
        $this->sessions = array();
    }

    public function addSession() {

    }

    public function removeSession() {

    }

    public function loadSession() {
        $sessionName = "";
        // <editor-fold desc="SET $sessionName = DOMAIN NAME">
        if (isset($_SERVER['HTTP_REFERER'])) {
            $workString = ltrim($_SERVER['HTTP_REFERER'], "http://");
            $workString = explode("/", $workString);
            $sessionName = array_shift($workString);
        } else {
            $sessionName = $_SERVER['SERVER_NAME'];
        }
        // </editor-fold>
        // <editor-fold desc="SET $this->SESSION = &$this->sessions[$sessionName]">
        if (!isset($this->sessions[$sessionName])) {
            $this->sessions[$sessionName] = array();
        }
        $this->SESSION = &$this->sessions[$sessionName];
        // </editor-fold>
        // <editor-fold desc="CHECK FOR INACTIVITY">
        /*
        if(isset($this->SESSION['LAST_ACTIVITY'])){
            if(time() - ($this->SESSION['LAST_ACTIVITY'] + (60*60)) > 0){ // IF 60 * 60 Seconds have passed (60 mins) THEN Expire Session
                //unset($this->SESSION);
                //unset($this->sessions[$sessionName]);
                $this->loadSession(); // RELOAD SESSION
            } else {
                $this->SESSION['LAST_ACTIVITY'] = time();
            }
        } else {
            $this->SESSION['LAST_ACTIVITY'] = time();
        }
         */
        // </editor-fold>
    }
}

interface dataObject {
    public function asXML();
}

function isModuleEnabled($module) {
    $queryResults = runQuery('framework', 'getModules.sql');
    $found = false;
    while ($queryData = mysqli_fetch_array($queryResults)) {
        if ($queryData['module'] == $module) {
            $found = true;
        }
    }
    return $found;
}

function FatalError($file, $class, $function, $line, $error) {
    die("FATAL ERROR [FILE: " . $file . " | CLASS: " . $class . " | FUNCTION: " . $function . " | LINE: " . $line . " | ERROR: " . $error . "]");
}

function runQuery($module, $query) {
    global $INCLUDE_PATH;
    global $mysqlConnection;

    $results = false;
    $args = func_get_args();
    array_shift($args);
    array_shift($args);

    foreach ($args as $key => $value) {
        $args[$key] = mysqli_real_escape_string($mysqlConnection, stripslashes($value));
    }

    $queryScript = $INCLUDE_PATH . "/" . $module . "/queries/" . $query;
    $IOHandler = fopen($queryScript, 'r');
    if (filesize($queryScript) > 0) {
        $queryData = fread($IOHandler, filesize($queryScript));
    } else {
        error_log("runQuery Error Failed to Read Script [" . $queryScript . "]");
    }
    fclose($IOHandler);

    if (strlen($queryData) > 0 AND substr_count($queryData, "?") > 0 AND count($args) > 0) {
        $loop = true;
        $count = substr_count($queryData, "?");
        while ($loop == true) {
            if (strpos($queryData, "?$count") !== false) {
                if (isset($args[$count - 1])) {
                    $queryData = str_replace("?$count", $args[$count - 1], $queryData);
                } else {
                    $queryData = str_replace("?$count", "NULL", $queryData);
                }
            }
            $count--;
            if (strpos($queryData, "?") == false) {
                $loop = false;
            }
        }
    }
    if (strlen($queryData) > 0) {
        $results = mysqli_query($mysqlConnection,$queryData) or $results = false;
    }
    if($results === false){
        error_log("QUERY ERROR [MODULE: " . $module . " | QUERY: " . $query . " | SCRIPT: " . $queryData ." | ERROR:" . mysqli_error($mysqlConnection) . "]");
    }
    return $results;
}

function runUnsafeQuery($module, $query) {
    global $INCLUDE_PATH;
    global $mysqlConnection;

    $results = false;
    $args = func_get_args();
    array_shift($args);
    array_shift($args);

    $queryScript = $INCLUDE_PATH . "/" . $module . "/queries/" . $query;
    $IOHandler = fopen($queryScript, 'r');
    if (filesize($queryScript) > 0) {
        $queryData = fread($IOHandler, filesize($queryScript));
    }
    fclose($IOHandler);

    if (strlen($queryData) > 0 AND substr_count($queryData, "?") > 0 AND count($args) > 0) {
        $loop = true;
        $count = substr_count($queryData, "?");
        while ($loop == true) {
            if (strpos($queryData, "?$count") !== false) {
                if (isset($args[$count - 1])) {
                    $queryData = str_replace("?$count", $args[$count - 1], $queryData);
                } else {
                    $queryData = str_replace("?$count", "NULL", $queryData);
                }
            }
            $count--;
            if (strpos($queryData, "?") == false) {
                $loop = false;
            }
        }
    }
    if (strlen($queryData) > 0) {
        $results = mysqli_query($mysqlConnection,$queryData, MYSQLI_USE_RESULT) or die("QUERY ERROR [MODULE: " . $module . " | QUERY: " . $query . " | SCRIPT: " . $queryData ." | ERROR:" . mysqli_error($mysqlConnection) . "]");
    }
    return $results;
}

function xmlToArray($XML){
    $returnData = array();
    $XML = simplexml_load_string($XML);

    foreach($XML as $node){
        if($node->count() > 0){
            $returnData[$node->getName()] = xmlToArray($node->asXML());
        } else {
            $returnData[$node->getName()] = urldecode((string) $node);
        }
    }
    return $returnData;
}

function arrayToXml($array){
    $debug = new debugger();
    $debug->enabled = false;
    
    $XML = "";
    foreach ($array as $index => $value) {
        $debug->report("Type :" . gettype($array[$index]));
        $debug->report("index :" . $index);
        $debug->report("value :" . $value);
        $debug->report("isArrayEmpty :" . isArrayEmpty($array[$index]));
        if (gettype($array[$index]) == 'array') {
            if (!isArrayEmpty($array[$index])) {
                if(preg_match('/^\d+$/', $index) == 0) {
                    $XML .= "<$index>";
                }
                if (gettype($array[$index]) == 'array') {
                    if (!isArrayEmpty($array[$index])) {
                        $XML .= arrayToXml($array[$index]);
                    }
                } else {
                    $XML .= urlencode($value);
                }
                if(preg_match('/^\d+$/', $index) == 0) {
                    $XML .= "</$index>";
                }
            } else {
                if(preg_match('/^\d+$/', $index) == 0) {
                    $XML .= "<$index/>";
                }
            }
        } else {
            if ($array[$index] == "0" or $array[$index] == "0.00") {
                $XML .= "<$index>" . urlencode($value) . "</$index>";
            } else {
                if (!empty($array[$index])) {
                    $XML .= "<$index>";
                    if (gettype($array[$index]) == 'array') {
                        if (!isArrayEmpty($array[$index])) {
                            $XML .= arrayToXml($array[$index]);
                        }
                    } else {
                        $XML .= urlencode($value);
                    }
                    if (preg_match('/^\d+$/', $index) == 0) {
                        $XML .= "</$index>";
                    }
                } else {
                    if (preg_match('/^\d+$/', $index) == 0) {
                        $XML .= "<$index/>";
                    }
                }
            }
        }
    }
    return $XML;
}

function replaceSymbols($XML, $symbols) {
    $XML = $XML->asXML();
    foreach ($symbols as $symbol => $value) {
        if (preg_match('/'.preg_quote($symbol).'/', $XML) == 1) {
           $XML = preg_replace('/'.preg_quote($symbol).'/', $value , $XML);
        }
    }
    return simplexml_load_string($XML);
}

function array_deep_merge($array1, $array2){
    foreach($array1 as $index => $value){
        if(gettype($array1[$index]) == 'array'){
            if(isset($array2[$index])){
                $array1[$index] = array_deep_merge($array1[$index], $array2[$index]);
            }
        } else {
            if(isset($array2[$index])){
                $array1[$index] = $array2[$index];
            }
        }
    }
    foreach ($array2 as $index => $value) {
        if (!isset($array1[$index])) {
            $array1[$index] = $array2[$index];
        }
    }
    return($array1);
}

function isArrayEmpty($array){
    $debug = new debugger();
    $debug->enabled = false;

    $empty = true;
    foreach($array as $index => $value){
        if(gettype($array[$index]) == 'array'){
            $debug->report("Recurse");
            $empty = isArrayEmpty($array[$index]);
        } else {
            $debug->report("Array Value: " . $array[$index]);
            if(!empty($array[$index])){
                $debug->report("Array Not Empty");
                $empty = false;
            }
        }
        if($empty == false){
            break;
        }
    }
    return $empty;
}

function array_clear(&$array) {
    foreach ($array as $key) {
        array_pop($array);
    }
}

function authenticateRequest($module, $method) {
    if (isModuleEnabled('usermanager')) {
        $queryResults = runQuery('framework', 'authenticateRequest.sql',
                        $_SESSION['MasterSession']->SESSION['usermanager']->user->userId,
                        $module,
                        $method);
        if (mysqli_num_rows($queryResults) >= 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function validateRequestData($defaultArray, $requestData, $merge = false){
    $debug = new debugger();
    $debug->enabled = false;
    $errors = false;
    $failedIndex = '';
    foreach ($defaultArray as $index => $value) { // For each index in $defaultArray
        $debug->report("foreach index ($index)");
        if (gettype($defaultArray[$index]) == 'array') {  // If defaultIndex is an array
            if (isset($defaultArray[$index]['value'])) { // If the defaultIndex is a end node
                if (isset($requestData[$index])) { // If the defaultIndex is found in the requestArray
                    $defaultArray[$index]['value'] = $requestData[$index]; // Set the value of the defaultIndex to the requestIndex
                }
                
                $debug->report($index . ' - ' . $defaultArray[$index]['pattern'] . ' = ' . preg_match($defaultArray[$index]['pattern'], $defaultArray[$index]['value']));

                if ($defaultArray[$index]['req'] == 'true' or !empty($defaultArray[$index]['value'])) {
                    if (preg_match($defaultArray[$index]['pattern'], $defaultArray[$index]['value']) == '0') {
                        $errors = true;
                        $failedIndex .=
                                '<node>' .
                                '<index>' .
                                $index .
                                '</index>' .
                                '<value>' .
                                $defaultArray[$index]['value'] .
                                '</value>' .
                                '<pattern>' .
                                $defaultArray[$index]['pattern'] .
                                '</pattern>' .
                                '<req>' .
                                $defaultArray[$index]['req'] . 
                                '</req>' .
                                '</node>';
                    }
                }
            } else { // If the defaultIndex is not an end node
                if (isset($requestData[$index])) { // If the index is found in the requestArray
                    $debug->report('Recursion on index ('.$index.') ... <br/>');
                    
                    $defaultArray[$index] = validateRequestData($defaultArray[$index], $requestData[$index]); // Recurse
                    // <editor-fold desc="DEBUG">
                    
                    // </editor-fold>
                    if(gettype($defaultArray[$index]) != 'array'){
                        $errors = true;
                        $failedIndex .= $defaultArray[$index];
                        $debug->report('NOT AN ARRAY!');
                        
                    }
                } else { // If the index is NOT found in the requestArray
                    if (!$merge) {
                        if (hasRequiredFeilds($requestData[$index])) {
                            $errors = true;
                            $failedIndex .=
                                    '<node>' .
                                    '<index>' .
                                    $index .
                                    '</index>' .
                                    '<value>PARENT NODE</value>' .
                                    '<pattern>NULL</pattern>' .
                                    '<req>true</req>' .
                                    '</node>';
                        }
                    }
                }
            }
        }
    }
    // <editor-fold desc="COLLAPSE VALUE/PATTERN PAIRS">
    $debug->report("<br/> Collapsing VALUE/PATTERN PAIRS ....");
    
    foreach($defaultArray as $index => $value){ // For each index in $defaultArray
        $debug->report("INDEX(".$index .") ");
        if (gettype($defaultArray[$index]) == 'array') { // If defaultIndex contains arrays
            if (isset($defaultArray[$index]['value'])) { // If the defaultIndex is a end node
                $debug->report("COLLAPSED");
                $defaultArray[$index] = $defaultArray[$index]['value'];
            }
        }
    }
    // </editor-fold>
    // <editor-fold desc="DEBUG">
    if($debug->enabled == true){
        echo '$defaultArray = ';var_dump($defaultArray);echo '<br/>';
        echo '$failedIndex = ';var_dump($failedIndex);echo '<br/>';
    }
    // </editor-fold>
    
    if(!$errors){
        return($defaultArray);
    } else {
        return $failedIndex;
    }
}

function hasRequiredFeilds($array){
    $requiredFeildsDetected = false;
    foreach($array as $key => $value){
        if (gettype($array[$key]) == 'array') { // IF KEY IS AN ARRAY THEN
            if (isset($array[$key]['value'])) { // If the key is a end node
                if(ucwords($array[$key]['req']) == "TRUE"){
                    $requiredFeildsDetected = true;
                }
            } else { // IF NOT END NODE RECURESE
                $requiredFeildsDetected = hasRequiredFeilds($array[$key]);
            }
        }
    }
    return $requiredFeildsDetected;
}

function collapseValidationArray($array){
    // <editor-fold desc="COLLAPSE VALUE/PATTERN PAIRS">
    foreach ($array as $index => $value) { // For each index in $defaultArray
        if (gettype($array[$index]) == 'array') { // If defaultIndex contains arrays
            if (isset($array[$index]['value'])) { // If the defaultIndex is a end node
                $array[$index] = $array[$index]['value'];
            } else {
                $array[$index] = collapseValidationArray($array[$index]); // Recurse
            }
        }
    }
    // </editor-fold>
    return $array;
}

function getRandomString($len = 10) {
    $characters = "abcdefhijklmnopqrstuvwxyz0123456789";
    $validationCode = "";
    for ($count = 1; $count <= $len; $count+=1) {
        $validationCode .= substr($characters, mt_rand(0, strlen($characters) - 1), 1);
    }
    return $validationCode;
}

function getRevision(){
    exec("svn info .", $revision);
    $revision = trim(ltrim($revision[4],"Revision:"));
    return $revision;
}


?>
