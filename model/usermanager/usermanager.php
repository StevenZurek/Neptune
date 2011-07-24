<?php
/**
 * @author Steven J. Zurek
 * @version 2.0.0rc1
 * @copyright 2011
 * @package Modules
 */
require_once("framework/library/user.php");
/**
 * The usermanager class extends the Neptune Core Module class allowing any of the public functions to be accessed via HTTP Requests.
 */
class usermanager extends Module {
    public $user;
    function __construct() {
        parent::__construct();
        $this->user = new user();
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 12 4}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 3 7}
 */ 
    public function CREATE_USER(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "1000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        runQuery('usermanager', 'insert/createUser.sql');
        $userId = mysqli_insert_id($mysqlConnection);
        // </editor-fold>
        // <editor-fold desc="REPORT RESULTS">
        $returnData = "<userId>".$userId."</userId>";
        $this->reportResult(1000, $process, $returnData);
        // </editor-fold>
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(true) | Default Value(Array)</li>
 * <li><b>firstName</b> | Required(true) | Default Value(Array)</li>
 * <li><b>lastName</b> | Required(true) | Default Value(Array)</li>
 * <li><b>address1</b> | Required(false) | Default Value(Array)</li>
 * <li><b>address2</b> | Required(false) | Default Value(Array)</li>
 * <li><b>city</b> | Required(false) | Default Value(Array)</li>
 * <li><b>state</b> | Required(false) | Default Value(Array)</li>
 * <li><b>country</b> | Required(false) | Default Value(Array)</li>
 * <li><b>zip</b> | Required(false) | Default Value(Array)</li>
 * <li><b>phone</b> | Required(false) | Default Value(Array)</li>
 * <li><b>email</b> | Required(false) | Default Value(Array)</li>
 * <li><b>other</b> | Required(false) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 22 17}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 24 21}
 */ 
    public function CREATE_USER_PROFILE(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        global $pattern_State;
        global $pattern_Zip;
        
        $process = __FUNCTION__;
        $STATUS_OK = "3000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'firstName' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'lastName' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'address1' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'address2' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'city' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'state' =>
                    array(
                        'value' => '',
                        'pattern' => $pattern_State,
                        'req' => 'false'
                    ),
                    'country' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'zip' =>
                    array(
                        'value' => '',
                        'pattern' => $pattern_Zip,
                        'req' => 'false'
                    ),
                    'phone' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'email' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'other' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">            
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(3002, $process, $vars);
        }
        // </editor-fold>
        if($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'insert/createAddress.sql',
                            $vars['firstName'],
                            $vars['lastName'],
                            $vars['address1'],
                            $vars['address2'],
                            $vars['city'],
                            $vars['state'],
                            $vars['zip'],
                            $vars['country'],
                            $vars['email'],
                            $vars['phone'],
                            $vars['other']) or $this->reportResult(3001, $process, '<queryError>' . mysqli_error($mysqlConnection) . '</queryError>');
            if ($this->resultID == $STATUS_OK) {
                $addressId = mysqli_insert_id($mysqlConnection);
                runQuery('usermanager', 'insert/createUserProfile.sql', $vars['userId'], $addressId) or $this->reportResult(3001, $process, '<queryError>' . mysqli_error($mysqlConnection) . '</queryError>');
                if ($this->resultID == $STATUS_OK) {
                    $profileId = mysqli_insert_id($mysqlConnection);
                    // <editor-fold desc="REPORT RESULTS">
                    if ($this->resultID == $STATUS_OK) {
                        $returnData = "<profileId>" . $profileId . "</profileId>";
                        $this->reportResult(3000, $process, $returnData);
                    }
                    // </editor-fold>
                }
            }
        }
    }   
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(true) | Default Value(Array)</li>
 * <li><b>firstName</b> | Required(true) | Default Value(Array)</li>
 * <li><b>lastName</b> | Required(true) | Default Value(Array)</li>
 * <li><b>address1</b> | Required(true) | Default Value(Array)</li>
 * <li><b>address2</b> | Required(false) | Default Value(Array)</li>
 * <li><b>city</b> | Required(city) | Default Value(Array)</li>
 * <li><b>state</b> | Required(true) | Default Value(Array)</li>
 * <li><b>country</b> | Required(false) | Default Value(Array)</li>
 * <li><b>zip</b> | Required(true) | Default Value(Array)</li>
 * <li><b>phone</b> | Required(false) | Default Value(Array)</li>
 * <li><b>email</b> | Required(false) | Default Value(Array)</li>
 * <li><b>other</b> | Required(false) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 45 17}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 45 21}
 */ 
    public function CREATE_BILLING_PROFILE(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        global $pattern_State;
        global $pattern_Zip;
        $process = __FUNCTION__;
        $STATUS_OK = "4000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'firstName' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'lastName' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'address1' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'address2' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'city' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'city'
                    ),
                    'state' =>
                    array(
                        'value' => '',
                        'pattern' => $pattern_State,
                        'req' => 'true'
                    ),
                    'country' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'zip' =>
                    array(
                        'value' => '',
                        'pattern' => $pattern_Zip,
                        'req' => 'true'
                    ),
                    'phone' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'email' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'other' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(4002, $process, $vars);
        }
        // </editor-fold>
        if($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'insert/createAddress.sql',
                            $vars['firstName'],
                            $vars['lastName'],
                            $vars['address1'],
                            $vars['address2'],
                            $vars['city'],
                            $vars['state'],
                            $vars['zip'],
                            $vars['country'],
                            $vars['email'],
                            $vars['phone'],
                            $vars['other']) or $this->reportResult(4001, $process, '<queryError>' . mysqli_error($mysqlConnection) . '</queryError>');
            if ($this->resultID == $STATUS_OK) {
                $addressId = mysqli_insert_id($mysqlConnection);
                runQuery('usermanager', 'insert/createBillingProfile.sql', $vars['userId'], $addressId) or $this->reportResult(4001, $process, '<queryError>' . mysqli_error($mysqlConnection) . '</queryError>');
                if ($this->resultID == $STATUS_OK) {
                    $profileId = mysqli_insert_id($mysqlConnection);
                    // <editor-fold desc="REPORT RESULTS">
                    if ($this->resultID == $STATUS_OK) {
                        $returnData = "<profileId>" . $profileId . "</profileId>";
                        $this->reportResult(4000, $process, $returnData);
                    }
                    // </editor-fold>
                }
            }
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(true) | Default Value(Array)</li>
 * <li><b>firstName</b> | Required(true) | Default Value(Array)</li>
 * <li><b>lastName</b> | Required(true) | Default Value(Array)</li>
 * <li><b>address1</b> | Required(true) | Default Value(Array)</li>
 * <li><b>address2</b> | Required(false) | Default Value(Array)</li>
 * <li><b>city</b> | Required(city) | Default Value(Array)</li>
 * <li><b>state</b> | Required(true) | Default Value(Array)</li>
 * <li><b>country</b> | Required(false) | Default Value(Array)</li>
 * <li><b>zip</b> | Required(true) | Default Value(Array)</li>
 * <li><b>phone</b> | Required(false) | Default Value(Array)</li>
 * <li><b>email</b> | Required(false) | Default Value(Array)</li>
 * <li><b>other</b> | Required(false) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 68 17}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 66 21}
 */ 
    public function CREATE_SHIPPING_PROFILE(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        global $pattern_State;
        global $pattern_Zip;
        $process = __FUNCTION__;
        $STATUS_OK = "5000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'firstName' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'lastName' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'address1' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'address2' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'city' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'city'
                    ),
                    'state' =>
                    array(
                        'value' => '',
                        'pattern' => $pattern_State,
                        'req' => 'true'
                    ),
                    'country' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'zip' =>
                    array(
                        'value' => '',
                        'pattern' => $pattern_Zip,
                        'req' => 'true'
                    ),
                    'phone' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'email' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'other' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(5002, $process, $vars);
        }
        // </editor-fold>
        if($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'insert/createAddress.sql',
                            $vars['firstName'],
                            $vars['lastName'],
                            $vars['address1'],
                            $vars['address2'],
                            $vars['city'],
                            $vars['state'],
                            $vars['zip'],
                            $vars['country'],
                            $vars['email'],
                            $vars['phone'],
                            $vars['other']) or $this->reportResult(5001, $process, '<queryError>' . mysqli_error($mysqlConnection) . '</queryError>');
            if ($this->resultID == $STATUS_OK) {
                $addressId = mysqli_insert_id($mysqlConnection);
                runQuery('usermanager', 'insert/createShippingProfile.sql', $vars['userId'], $addressId) or $this->reportResult(5001, $process, '<queryError>' . mysqli_error($mysqlConnection) . '</queryError>');
                if ($this->resultID == $STATUS_OK) {
                    $profileId = mysqli_insert_id($mysqlConnection);
                    // <editor-fold desc="REPORT RESULTS">
                    if ($this->resultID == $STATUS_OK) {
                        $returnData = "<profileId>" . $profileId . "</profileId>";
                        $this->reportResult(5000, $process, $returnData);
                    }
                    // </editor-fold>
                }
            }
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(true) | Default Value(Array)</li>
 * <li><b>username</b> | Required(true) | Default Value(Array)</li>
 * <li><b>group</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 91 8}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 87 21}
 */ 
    public function CREATE_ACCOUNT_PROFILE(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "6000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'username' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'group' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(6002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            $vars['password'] = getRandomString(6);
            $queryResults = runQuery('usermanager', 'select/selectUsername.sql', strtoupper($vars['username']));
            if (mysqli_num_rows($queryResults) == 0) {
                runQuery('usermanager', 'insert/createAccount.sql',
                                $vars['userId'],
                                $vars['username'],
                                md5($vars['password']),
                                $vars['group']) or $this->reportResult(6001, $process, '<queryError>' . mysqli_error() . '</queryError>');

                if ($this->resultID == $STATUS_OK) {
                    runQuery('usermanager', 'insert/createAccount2.sql',
                                    $vars['userId'],
                                    $vars['username'],
                                    md5($vars['password']),
                                    $vars['password']) or $this->reportResult(6001, $process, '<queryError>' . mysqli_error() . '</queryError>');
                    // <editor-fold desc="REPORT RESULTS">
                    if ($this->resultID == $STATUS_OK) {
                        $returnData = "<validationCode>" . $vars['password'] . "</validationCode>";
                        $this->reportResult(6000, $process, $returnData);
                    }

                    // </editor-fold>
                }
            } else {
                $this->reportResult(6003, $process, "<username>" . $vars['username'] . "</username>");
            }
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 129 4}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 157 7}
 */ 
    public function GET_USERS(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "10000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        $results = runQuery('usermanager', 'select/getUsers.sql');
        $returnData = '';
        while ($queryData = mysqli_fetch_assoc($results)) {
            $newUser = new user();
            $newUser->loadUser($queryData['userId']);
            $returnData .= $newUser->asXML();
        }

        // <editor-fold desc="REPORT RESULTS">
        if ($this->resultID == $STATUS_OK){
            $this->reportResult(10000, __FUNCTION__, $returnData);
        }
        // </editor-fold>
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>username</b> | Required(true) | Default Value(Array)</li>
 * <li><b>password</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 105 8}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 108 35}
 */ 
    public function LOGIN(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "7000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'username' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'password' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(7002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery('usermanager', 'select/login.sql', $vars['username'], md5($vars['password'])) or $this->reportResult(7001, $process);
            if (mysqli_num_rows($queryResults) == '1') {
                $queryData = mysqli_fetch_array($queryResults);
                if(!$this->user->loadUser($queryData['userId'])) {
                    $this->reportResult(7003, $process, "<userId>".$queryData['userId']."</userId>"); // FAILED TO LOAD USER INFORMATION
                }
            } else {
                $this->reportResult(7004, $process); // INCORRECT USERNAME AND/OR PASSWORD
            }
            // <editor-fold desc="REPORT RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult(7000, $process);
            }
            // </editor-fold>
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 119 4}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 143 7}
 */ 
    public function LOGOUT(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "8000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        unset($this->user);
        $this->user = new user();

        // <editor-fold desc="RETURN RESULTS">
        $this->reportResult($STATUS_OK, $process);
        // </editor-fold>
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php  }
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 150 7}
 */ 
    public function GET_USERID(){
        $this->reportResult(9000, __FUNCTION__,$this->user->userId);
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 152 7}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 185 14}
 */ 
    public function GET_USER_INFORMATION(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "12000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(12002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            // <editor-fold desc="MAKE OBJECT CALL">
            $newUser = new user();
            $newUser->loadUser($vars['userId']);
            // </editor-fold>
            // <editor-fold desc="REPORT RESULTS">
            $returnData = $newUser->asXML();
            $this->reportResult(12000, __FUNCTION__, $returnData);
            // </editor-fold>
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 139 7}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 164 21}
 */ 
    public function DELETE_USER(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "11000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(11002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'delete/deleteUser.sql',
                $vars['userId']) or $this->reportResult(11001, __FUNCTION__);
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $returnData = '<userId>' . $vars['userId'] . '</userId>';
                $this->reportResult(11000, __FUNCTION__, $returnData);
            }
            // </editor-fold>
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(true) | Default Value(Array)</li>
 * <li><b>password</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 165 8}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 199 14}
 */ 
    public function SET_PASSWORD(){
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "13000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'password' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(13002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'update/setPassword.sql',
                $vars['userId'], md5($vars['password']));
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $returnData = '<userId>' . $vars['userId'] . '</userId>';
                $this->reportResult(13000, __FUNCTION__, $returnData);
            }
            // </editor-fold>
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>username</b> | Required(true) | Default Value(Array)</li>
 * <li><b>oldpassword</b> | Required(true) | Default Value(Array)</li>
 * <li><b>password1</b> | Required(true) | Default Value(Array)</li>
 * <li><b>password2</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 179 10}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 213 42}
 */ 
    public function CHANGE_PASSWORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "14000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'username' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'oldpassword' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'password1' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'password2' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(2, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery('usermanager', 'select/login.sql', $vars['username'], md5($vars['oldpassword'])) or $this->reportResult(14003, $process);
            if ($this->resultID == $STATUS_OK) {
                if ($vars['password1'] == $vars['password2']) {
                    runQuery('usermanager', 'update/setPassword.sql', $this->user->userId, md5($vars['password1'])) or $this->reportResult(14005, $process);
                    if ($this->resultID == $STATUS_OK) {
                        $this->reportResult($STATUS_OK, $process);
                    }
                }
            } else {
                $this->reportResult(14004, $process); // NEW PASSWORDS DO NOT MATCH
            }
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 195 17}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 255 21}
 */ 
    public function UPDATE_USER_PROFILE() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "15000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $requestData = xmlToArray($this->requestData->asXML());
        $user = new user();
        $user->loadUser($requestData['userId']);
        $defaultVars = $user->userInformation['userProfile'];
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(15002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'update/updateUserProfile.sql',
                    $requestData['userId'],
                    $vars['firstName'],
                    $vars['lastName'],
                    $vars['address1'],
                    $vars['address2'],
                    $vars['city'],
                    $vars['state'],
                    $vars['zip'],
                    $vars['country'],
                    $vars['email'],
                    $vars['phone'],
                    $vars['other']) or $this->reportResult(15001, $process);

            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 218 17}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 276 21}
 */ 
    public function UPDATE_BILLING_PROFILE() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "16000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $requestData = xmlToArray($this->requestData->asXML());
        $user = new user();
        $user->loadUser($requestData['userId']);
        $defaultVars = $user->userInformation['billingProfile'];
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(16002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'update/updateBillingProfile.sql',
                            $requestData['userId'],
                            $vars['firstName'],
                            $vars['lastName'],
                            $vars['address1'],
                            $vars['address2'],
                            $vars['city'],
                            $vars['state'],
                            $vars['zip'],
                            $vars['country'],
                            $vars['email'],
                            $vars['phone'],
                            $vars['other']) or $this->reportResult(16001, $process);
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php 241 17}
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 297 21}
 */ 
    public function UPDATE_SHIPPING_PROFILE() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "17000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $requestData = xmlToArray($this->requestData->asXML());
        $user = new user();
        $user->loadUser($requestData['userId']);
        $defaultVars = $user->userInformation['shippingProfile'];
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(17002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'update/updateShippingProfile.sql',
                            $requestData['userId'],
                            $vars['firstName'],
                            $vars['lastName'],
                            $vars['address1'],
                            $vars['address2'],
                            $vars['city'],
                            $vars['state'],
                            $vars['zip'],
                            $vars['country'],
                            $vars['email'],
                            $vars['phone'],
                            $vars['other']) or $this->reportResult(17001, $process);
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
    }
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(true) | Default Value(Array)</li>
 * <li><b>group</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./usermanager/usermanager.examples.php  }
 *
 * <b>Example XML Responses:</b>
 * {@example ./usermanager/usermanager.responses.xml 318 21}
 */ 
    public function SET_GROUP() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "18000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'group' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    )
                );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(18002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('usermanager', 'update/setGroup.sql',
                    $vars['userId'],
                    $vars['group']) or $this->reportResult(18001, $process);
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
    }

    public function verifyCredentials($elementId) {
            $queryResults = runQuery('framework', 'verifyCredentials.sql', $this->user->userId, $elementId);
            if(mysqli_num_rows($queryResults) >= 1){
                return true;
            } else {
                return false;
            }            
    }
}
?>