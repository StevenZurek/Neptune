<?php

/**
 * @author Steven J. Zurek
 * @version 2.0.0rc1
 * @copyright 2011
 * @package Modules
 */

/**
 * The healthjournal class extends the Neptune Core Module class allowing any of the public functions to be accessed via HTTP Requests.
 */
class healthjournal extends Module {

    private $userId;

    public function __construct() {
        parent::__construct();
        if (isset($_SESSION['MasterSession']->SESSION['usermanager']->user->userId)) {
            $this->userId = $_SESSION['MasterSession']->SESSION['usermanager']->user->userId;
        } else {
            $this->userId = 0;
        }
    }

    // <editor-fold desc="*_ACTIVITIES_RECORD">

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>activityLog</b> | Parent </li>
     * <li><b>activityDate</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityType</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityLevel</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDistanceValue</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDistanceType</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationHours</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationMinutes</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationSeconds</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityCalories</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>recordId</b> | Required(false) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 5 17}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 3 21}
     */
    public function CREATE_ACTIVITIES_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "1000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'activityLog' =>
                    array(
                        'activityDate' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityType' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityLevel' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityDistanceValue' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityDistanceType' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityDurationHours' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityDurationMinutes' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityDurationSeconds' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityCalories' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        )
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(1002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'insert/createActivitiesRecord.sql',
                            $this->userId,
                            $vars['activityLog']['activityDate'],
                            $vars['activityLog']['activityType'],
                            $vars['activityLog']['activityLevel'],
                            $vars['activityLog']['activityDistanceValue'],
                            $vars['activityLog']['activityDistanceType'],
                            $vars['activityLog']['activityDurationHours'],
                            $vars['activityLog']['activityDurationMinutes'],
                            $vars['activityLog']['activityDurationSeconds'],
                            $vars['activityLog']['activityCalories']) or $this->reportResult(1001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'recordId' =>
                        array(
                            'value' => '' . mysqli_insert_id($mysqlConnection),
                            'pattern' => '/.+/',
                            'req' => 'false'
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold> 
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * <li><b>activityLog</b> | Parent </li>
     * <li><b>activityDate</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityType</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityLevel</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDistanceValue</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDistanceType</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationHours</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationMinutes</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationSeconds</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityCalories</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 26 18}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 24 21}
     */
    public function UPDATE_ACTIVITIES_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "2000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="GET CURRENT DATA">
        $vars = xmlToArray($this->requestData->asXML());
        $queryResults = runQuery(__CLASS__, 'select/selectActivitesRecord.sql',
                        $vars['recordId']) or $this->reportResult(2001, __FUNCTION__);
        if (mysqli_num_rows($queryResults) == 0) {
            $this->reportResult(2001, $process);
        }
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        if ($this->resultID == $STATUS_OK) {
            $current = mysqli_fetch_assoc($queryResults);
            $defaultVars =
                    array(
                        'recordId' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'activityLog' =>
                        array(
                            'activityDate' =>
                            array(
                                'value' => '' . $current['activityDate'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityType' =>
                            array(
                                'value' => '' . $current['activityType'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityLevel' =>
                            array(
                                'value' => '' . $current['activityLevel'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDistanceValue' =>
                            array(
                                'value' => '' . $current['activityDistanceValue'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDistanceType' =>
                            array(
                                'value' => '' . $current['activityDistanceType'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDurationHours' =>
                            array(
                                'value' => '' . $current['activityDurationHours'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDurationMinutes' =>
                            array(
                                'value' => '' . $current['activityDurationMinutes'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDurationSeconds' =>
                            array(
                                'value' => '' . $current['activityDurationSeconds'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityCalories' =>
                            array(
                                'value' => '' . $current['activityCalories'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
            );
            // </editor-fold>
            // <editor-fold desc="VALIDATE REQUEST">
            $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
            if (gettype($vars) != 'array') {
                $this->reportResult(2002, $process, $vars);
            }
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, '/update/updateActivitiesRecord.sql',
                            $this->userId,
                            $vars['activityLog']['activityDate'],
                            $vars['activityLog']['activityType'],
                            $vars['activityLog']['activityLevel'],
                            $vars['activityLog']['activityDistanceValue'],
                            $vars['activityLog']['activityDistanceType'],
                            $vars['activityLog']['activityDurationHours'],
                            $vars['activityLog']['activityDurationMinutes'],
                            $vars['activityLog']['activityDurationSeconds'],
                            $vars['activityLog']['activityCalories'],
                            $vars['recordId']) or $this->reportResult(2001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 47 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 45 21}
     */
    public function DELETE_ACTIVITIES_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "3000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(3002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'delete/deleteActivitiesRecord.sql', $vars['recordId']) or $this->reportResult(3001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>activityLog</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDate</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityType</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityLevel</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDistanceValue</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDistanceType</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationHours</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationMinutes</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationSeconds</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityCalories</b> | Required(false) | Default Value(Array) | Parent Node(activityLog)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 57 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 66 21}
     */
    public function GET_ACTIVITIES_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "4000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
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
            $this->reportResult(4002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectActivitesRecord.sql',
                            $vars['recordId']) or $this->reportResult(4001, $process, mysqli_error($mysqlConnection));
            if ($this->resultID == $STATUS_OK AND mysqli_num_rows($queryResults) != 0) {
                $queryData = mysqli_fetch_array($queryResults);
            }
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'activityLog' =>
                        array(
                            'recordId' =>
                            array(
                                'value' => '' . $queryData['recordId'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'userId' =>
                            array(
                                'value' => '' . $queryData['userId'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDate' =>
                            array(
                                'value' => '' . $queryData['activityDate'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityType' =>
                            array(
                                'value' => '' . $queryData['activityType'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityLevel' =>
                            array(
                                'value' => '' . $queryData['activityLevel'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDistanceValue' =>
                            array(
                                'value' => '' . $queryData['activityDistanceValue'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDistanceType' =>
                            array(
                                'value' => '' . $queryData['activityDistanceType'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDurationHours' =>
                            array(
                                'value' => '' . $queryData['activityDurationHours'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDurationMinutes' =>
                            array(
                                'value' => '' . $queryData['activityDurationMinutes'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityDurationSeconds' =>
                            array(
                                'value' => '' . $queryData['activityDurationSeconds'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'activityCalories' =>
                            array(
                                'value' => '' . $queryData['activityCalories'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>activityLog</b> | Parent </li>
     * <li><b>userId</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityRecordId</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDate</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityType</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityLevel</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDistanceValue</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDistanceType</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationHours</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationMinutes</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityDurationSeconds</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * <li><b>activityCalories</b> | Required(true) | Default Value(Array) | Parent Node(activityLog)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 67 4}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 87 21}
     */
    public function GET_ALL_ACTIVITIES_RECORDS() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "5000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectAllActivitiesRecords.sql',
                            $this->userId) or $this->reportResult(5001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnArray['activities'] = array();
            while ($queryData = mysqli_fetch_array($queryResults)) {
                $returnData =
                        array(
                            'activityLog' =>
                            array(
                                'userId' =>
                                array(
                                    'value' => '' . $queryData['userId'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityRecordId' =>
                                array(
                                    'value' => '' . $queryData['recordId'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityDate' =>
                                array(
                                    'value' => '' . $queryData['activityDate'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityType' =>
                                array(
                                    'value' => '' . $queryData['activityType'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityLevel' =>
                                array(
                                    'value' => '' . $queryData['activityLevel'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityDistanceValue' =>
                                array(
                                    'value' => '' . $queryData['activityDistanceValue'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityDistanceType' =>
                                array(
                                    'value' => '' . $queryData['activityDistanceType'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityDurationHours' =>
                                array(
                                    'value' => '' . $queryData['activityDurationHours'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityDurationMinutes' =>
                                array(
                                    'value' => '' . $queryData['activityDurationMinutes'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityDurationSeconds' =>
                                array(
                                    'value' => '' . $queryData['activityDurationSeconds'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                ),
                                'activityCalories' =>
                                array(
                                    'value' => '' . $queryData['activityCalories'],
                                    'pattern' => '/.+/',
                                    'req' => 'true'
                                )
                            )
                );
                array_push($returnArray['activities'], $returnData);
            }
            $returnArray = arrayToXml(collapseValidationArray($returnArray));
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnArray);
            }
        }
        // </editor-fold>
    }

    // </editor-fold>
    // <editor-fold desc="*_VITAL_RECORD">
    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>vitalRecord</b> | Parent </li>
     * <li><b>date</b> | Required(true) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>weight</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>bloodPressure</b> | Parent  | Parent Node(vitalRecord)</li>
     * <li><b>syc</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>dya</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>pulse</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>glucose</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>cholesterol</b> | Parent  | Parent Node(bloodPressure)</li>
     * <li><b>ldl</b> | Required(false) | Default Value(Array) | Parent Node(cholesterol)</li>
     * <li><b>hdl</b> | Required(false) | Default Value(Array) | Parent Node(cholesterol)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>recordId</b> | Required(false) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 76 20}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 108 21}
     */
    public function CREATE_VITAL_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "6000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'vitalRecord' =>
                    array(
                        'date' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'weight' =>
                        array(
                            'value' => '0',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'bloodPressure' =>
                        array(
                            'syc' =>
                            array(
                                'value' => '0',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'dya' =>
                            array(
                                'value' => '0',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'pulse' =>
                            array(
                                'value' => '0',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        ),
                        'glucose' =>
                        array(
                            'value' => '0',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'cholesterol' =>
                        array(
                            'ldl' =>
                            array(
                                'value' => '0',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'hdl' =>
                            array(
                                'value' => '0',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(6002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'insert/createVitalRecord.sql',
                            $this->userId,
                            $vars['vitalRecord']['date'],
                            $vars['vitalRecord']['weight'],
                            $vars['vitalRecord']['bloodPressure']['syc'],
                            $vars['vitalRecord']['bloodPressure']['dya'],
                            $vars['vitalRecord']['bloodPressure']['pulse'],
                            $vars['vitalRecord']['glucose'],
                            $vars['vitalRecord']['cholesterol']['ldl'],
                            $vars['vitalRecord']['cholesterol']['hdl']) or $this->reportResult(6001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'recordId' =>
                        array(
                            'value' => '' . mysqli_insert_id($mysqlConnection),
                            'pattern' => '/.+/',
                            'req' => 'false'
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * <li><b>vitalRecord</b> | Parent </li>
     * <li><b>date</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>weight</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>bloodPressure</b> | Parent  | Parent Node(vitalRecord)</li>
     * <li><b>syc</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>dya</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>pulse</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>glucose</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>cholesterol</b> | Parent  | Parent Node(bloodPressure)</li>
     * <li><b>ldl</b> | Required(false) | Default Value(Array) | Parent Node(cholesterol)</li>
     * <li><b>hdl</b> | Required(false) | Default Value(Array) | Parent Node(cholesterol)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 100 21}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 129 21}
     */
    public function UPDATE_VITAL_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "7000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="GET CURRENT DATA">
        $vars = xmlToArray($this->requestData->asXML());
        $queryResults = runQuery(__CLASS__, 'select/selectVitalRecord.sql',
                        $vars['recordId']) or $this->reportResult(7001, __FUNCTION__);
        if (mysqli_num_rows($queryResults) == 0) {
            $this->reportResult(7001, $process);
        }
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        if ($this->resultID == $STATUS_OK) {
            $current = mysqli_fetch_assoc($queryResults);
            $defaultVars =
                    array(
                        'recordId' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'vitalRecord' =>
                        array(
                            'date' =>
                            array(
                                'value' => '' . $current['date'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'weight' =>
                            array(
                                'value' => '' . $current['weight'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'bloodPressure' =>
                            array(
                                'syc' =>
                                array(
                                    'value' => '' . $current['syc'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'dya' =>
                                array(
                                    'value' => '' . $current['dya'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'pulse' =>
                                array(
                                    'value' => '' . $current['pulse'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                )
                            ),
                            'glucose' =>
                            array(
                                'value' => '' . $current['glucose'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'cholesterol' =>
                            array(
                                'ldl' =>
                                array(
                                    'value' => '' . $current['ldl'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'hdl' =>
                                array(
                                    'value' => '' . $current['hdl'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                )
                            )
                        )
            );
        }
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(7002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, '/update/updateVitalRecord.sql',
                            $vars['recordId'],
                            $vars['vitalRecord']['date'],
                            $vars['vitalRecord']['weight'],
                            $vars['vitalRecord']['bloodPressure']['syc'],
                            $vars['vitalRecord']['bloodPressure']['dya'],
                            $vars['vitalRecord']['bloodPressure']['pulse'],
                            $vars['vitalRecord']['glucose'],
                            $vars['vitalRecord']['cholesterol']['ldl'],
                            $vars['vitalRecord']['cholesterol']['hdl']) or $this->reportResult(7001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 125 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 150 21}
     */
    public function DELETE_VITAL_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "8000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(8002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'delete/deleteVitalRecord.sql',
                            $vars['recordId']) or $this->reportResult(8001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>vitalRecord</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>date</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>weight</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>bloodPressure</b> | Parent  | Parent Node(vitalRecord)</li>
     * <li><b>syc</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>dya</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>pulse</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>glucose</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>cholesterol</b> | Parent  | Parent Node(bloodPressure)</li>
     * <li><b>ldl</b> | Required(false) | Default Value(Array) | Parent Node(cholesterol)</li>
     * <li><b>hdl</b> | Required(false) | Default Value(Array) | Parent Node(cholesterol)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 136 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 171 21}
     */
    public function GET_VITAL_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "9000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(9002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectVitalRecord.sql',
                            $vars['recordId']) or $this->reportResult(9001, $process);
            if ($this->resultID == $STATUS_OK AND mysqli_num_rows($queryResults) != 0) {
                $queryData = mysqli_fetch_array($queryResults);
            }
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'vitalRecord' =>
                        array(
                            'recordId' =>
                            array(
                                'value' => '' . $queryData['recordId'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'userId' =>
                            array(
                                'value' => '' . $queryData['userId'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'date' =>
                            array(
                                'value' => '' . $queryData['date'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'weight' =>
                            array(
                                'value' => '' . $queryData['weight'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'bloodPressure' =>
                            array(
                                'syc' =>
                                array(
                                    'value' => '' . $queryData['syc'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'dya' =>
                                array(
                                    'value' => '' . $queryData['dya'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'pulse' =>
                                array(
                                    'value' => '' . $queryData['pulse'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                )
                            ),
                            'glucose' =>
                            array(
                                'value' => '' . $queryData['glucose'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'cholesterol' =>
                            array(
                                'ldl' =>
                                array(
                                    'value' => '' . $queryData['ldl'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'hdl' =>
                                array(
                                    'value' => '' . $queryData['hdl'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                )
                            )
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>vitalRecord</b> | Parent </li>
     * <li><b>vitalRecord</b> | Parent  | Parent Node(vitalRecord)</li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>date</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>weight</b> | Required(false) | Default Value(Array) | Parent Node(vitalRecord)</li>
     * <li><b>bloodPressure</b> | Parent  | Parent Node(vitalRecord)</li>
     * <li><b>syc</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>dya</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>pulse</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>glucose</b> | Required(false) | Default Value(Array) | Parent Node(bloodPressure)</li>
     * <li><b>cholesterol</b> | Parent  | Parent Node(bloodPressure)</li>
     * <li><b>ldl</b> | Required(false) | Default Value(Array) | Parent Node(cholesterol)</li>
     * <li><b>hdl</b> | Required(false) | Default Value(Array) | Parent Node(cholesterol)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 147 4}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 192 21}
     */
    public function GET_ALL_VITAL_RECORDS() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "10000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectAllVitalRecords.sql',
                            $this->userId) or $this->reportResult(10001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnArray['vitalRecords'] = array();
            while ($queryData = mysqli_fetch_array($queryResults)) {
                $returnData =
                        array(
                            'vitalRecord' =>
                            array(
                                'vitalRecord' =>
                                array(
                                    'recordId' =>
                                    array(
                                        'value' => '' . $queryData['recordId'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'userId' =>
                                    array(
                                        'value' => '' . $queryData['userId'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'date' =>
                                    array(
                                        'value' => '' . $queryData['date'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'weight' =>
                                    array(
                                        'value' => '' . $queryData['weight'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'bloodPressure' =>
                                    array(
                                        'syc' =>
                                        array(
                                            'value' => '' . $queryData['syc'],
                                            'pattern' => '/.+/',
                                            'req' => 'false'
                                        ),
                                        'dya' =>
                                        array(
                                            'value' => '' . $queryData['dya'],
                                            'pattern' => '/.+/',
                                            'req' => 'false'
                                        ),
                                        'pulse' =>
                                        array(
                                            'value' => '' . $queryData['pulse'],
                                            'pattern' => '/.+/',
                                            'req' => 'false'
                                        )
                                    ),
                                    'glucose' =>
                                    array(
                                        'value' => '' . $queryData['glucose'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'cholesterol' =>
                                    array(
                                        'ldl' =>
                                        array(
                                            'value' => '' . $queryData['ldl'],
                                            'pattern' => '/.+/',
                                            'req' => 'false'
                                        ),
                                        'hdl' =>
                                        array(
                                            'value' => '' . $queryData['hdl'],
                                            'pattern' => '/.+/',
                                            'req' => 'false'
                                        )
                                    )
                                )
                            )
                );
                array_push($returnArray['vitalRecords'], $returnData);
            }
            $returnArray = arrayToXml(collapseValidationArray($returnArray));
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnArray);
            }
        }
        // </editor-fold>
    }

    // </editor-fold>
    // <editor-fold desc="*_DIARY_RECORD">
    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>diaryRecord</b> | Parent </li>
     * <li><b>diaryDate</b> | Required(true) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>diaryTitle</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>entry</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>feelings</b> | Parent  | Parent Node(diaryRecord)</li>
     * <li><b>mood</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>energy</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>stress</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>anger</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>appetite</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>clarity</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>health</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>sleep</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>recordId</b> | Required(false) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 156 21}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 213 21}
     */
    public function CREATE_DIARY_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "11000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'diaryRecord' =>
                    array(
                        'diaryDate' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'diaryTitle' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'entry' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'feelings' =>
                        array(
                            'mood' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'energy' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'stress' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'anger' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'appetite' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'clarity' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'health' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'sleep' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(11002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'insert/createDiaryRecord.sql',
                            $this->userId,
                            $vars['diaryRecord']['diaryDate'],
                            $vars['diaryRecord']['diaryTitle'],
                            $vars['diaryRecord']['entry'],
                            $vars['diaryRecord']['feelings']['mood'],
                            $vars['diaryRecord']['feelings']['energy'],
                            $vars['diaryRecord']['feelings']['stress'],
                            $vars['diaryRecord']['feelings']['anger'],
                            $vars['diaryRecord']['feelings']['appetite'],
                            $vars['diaryRecord']['feelings']['clarity'],
                            $vars['diaryRecord']['feelings']['health'],
                            $vars['diaryRecord']['feelings']['sleep']) or $this->reportResult(11001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'recordId' =>
                        array(
                            'value' => '' . mysqli_insert_id($mysqlConnection),
                            'pattern' => '/.+/',
                            'req' => 'false'
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * <li><b>diaryRecord</b> | Parent </li>
     * <li><b>diaryDate</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>diaryTitle</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>entry</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>feelings</b> | Parent  | Parent Node(diaryRecord)</li>
     * <li><b>mood</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>energy</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>stress</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>anger</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>appetite</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>clarity</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>health</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>sleep</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 181 22}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 234 21}
     */
    public function UPDATE_DIARY_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "12000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="GET CURRENT DATA">
        $vars = xmlToArray($this->requestData->asXML());
        $queryResults = runQuery(__CLASS__, 'select/selectDiaryRecord.sql',
                        $vars['recordId']) or $this->reportResult(12001, __FUNCTION__);
        if (mysqli_num_rows($queryResults) == 0) {
            $this->reportResult(12001, $process);
        }
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        if ($this->resultID == $STATUS_OK) {
            $current = mysqli_fetch_assoc($queryResults);
            $defaultVars =
                    array(
                        'recordId' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'diaryRecord' =>
                        array(
                            'diaryDate' =>
                            array(
                                'value' => '' . $current['diaryDate'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'diaryTitle' =>
                            array(
                                'value' => '' . $current['diaryTitle'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'entry' =>
                            array(
                                'value' => '' . $current['entry'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'feelings' =>
                            array(
                                'mood' =>
                                array(
                                    'value' => '' . $current['mood'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'energy' =>
                                array(
                                    'value' => '' . $current['energy'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'stress' =>
                                array(
                                    'value' => '' . $current['stress'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'anger' =>
                                array(
                                    'value' => '' . $current['anger'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'appetite' =>
                                array(
                                    'value' => '' . $current['appetite'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'clarity' =>
                                array(
                                    'value' => '' . $current['clarity'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'health' =>
                                array(
                                    'value' => '' . $current['health'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'sleep' =>
                                array(
                                    'value' => '' . $current['sleep'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                )
                            )
                        )
            );
        }
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(12002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, '/update/updateDiaryRecord.sql',
                            $vars['recordId'],
                            $vars['diaryRecord']['diaryDate'],
                            $vars['diaryRecord']['diaryTitle'],
                            $vars['diaryRecord']['entry'],
                            $vars['diaryRecord']['feelings']['mood'],
                            $vars['diaryRecord']['feelings']['energy'],
                            $vars['diaryRecord']['feelings']['stress'],
                            $vars['diaryRecord']['feelings']['anger'],
                            $vars['diaryRecord']['feelings']['appetite'],
                            $vars['diaryRecord']['feelings']['clarity'],
                            $vars['diaryRecord']['feelings']['health'],
                            $vars['diaryRecord']['feelings']['sleep']) or $this->reportResult(12001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 207 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 255 21}
     */
    public function DELETE_DIARY_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "13000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">    
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
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
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'delete/deleteDiaryRecord.sql',
                            $vars['recordId']) or $this->reportResult(13001, $process);
            // </editor-fold>   
            // <editor-fold desc="RETURN RESULTS"> 
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>    
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>diaryRecord</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>diaryDate</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>diaryTitle</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>entry</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>feelings</b> | Parent  | Parent Node(diaryRecord)</li>
     * <li><b>mood</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>energy</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>stress</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>anger</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>appetite</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>clarity</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>health</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>sleep</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 218 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 276 21}
     */
    public function GET_DIARY_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "14000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(14002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectDiaryRecord.sql',
                            $vars['recordId']) or $this->reportResult(14001, $process);
            if ($this->resultID == $STATUS_OK) {
                if (mysqli_num_rows($queryResults) != 0) {
                    $queryData = mysqli_fetch_array($queryResults);
                } else {
                    $this->reportResult(14001, $process);
                }
            }
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            if ($this->resultID == $STATUS_OK) {
                $returnData =
                        array(
                            'diaryRecord' =>
                            array(
                                'recordId' =>
                                array(
                                    'value' => '' . $queryData['recordId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'userId' =>
                                array(
                                    'value' => '' . $queryData['userId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'diaryDate' =>
                                array(
                                    'value' => '' . $queryData['diaryDate'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'diaryTitle' =>
                                array(
                                    'value' => '' . $queryData['diaryTitle'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'entry' =>
                                array(
                                    'value' => '' . $queryData['entry'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'feelings' =>
                                array(
                                    'mood' =>
                                    array(
                                        'value' => '' . $queryData['mood'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'energy' =>
                                    array(
                                        'value' => '' . $queryData['energy'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'stress' =>
                                    array(
                                        'value' => '' . $queryData['stress'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'anger' =>
                                    array(
                                        'value' => '' . $queryData['anger'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'appetite' =>
                                    array(
                                        'value' => '' . $queryData['appetite'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'clarity' =>
                                    array(
                                        'value' => '' . $queryData['clarity'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'health' =>
                                    array(
                                        'value' => '' . $queryData['health'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'sleep' =>
                                    array(
                                        'value' => '' . $queryData['sleep'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    )
                                )
                            )
                );
                $returnData = arrayToXml(collapseValidationArray($returnData));
            }
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>diaryRecord</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>diaryDate</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>diaryTitle</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>entry</b> | Required(false) | Default Value(Array) | Parent Node(diaryRecord)</li>
     * <li><b>feelings</b> | Parent  | Parent Node(diaryRecord)</li>
     * <li><b>mood</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>energy</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>stress</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>anger</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>appetite</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>clarity</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>health</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * <li><b>sleep</b> | Required(false) | Default Value(Array) | Parent Node(feelings)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 229 4}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 297 21}
     */
    public function GET_ALL_DIARY_RECORDS() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "15000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectAllDiaryRecords.sql',
                            $this->userId) or $this->reportResult(15001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnArray['diaryRecords'] = array();
            while ($queryData = mysqli_fetch_array($queryResults)) {
                $returnData =
                        array(
                            'diaryRecord' =>
                            array(
                                'recordId' =>
                                array(
                                    'value' => '' . $queryData['recordId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'userId' =>
                                array(
                                    'value' => '' . $queryData['userId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'diaryDate' =>
                                array(
                                    'value' => '' . $queryData['diaryDate'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'diaryTitle' =>
                                array(
                                    'value' => '' . $queryData['diaryTitle'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'entry' =>
                                array(
                                    'value' => '' . $queryData['entry'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'feelings' =>
                                array(
                                    'mood' =>
                                    array(
                                        'value' => '' . $queryData['mood'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'energy' =>
                                    array(
                                        'value' => '' . $queryData['energy'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'stress' =>
                                    array(
                                        'value' => '' . $queryData['stress'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'anger' =>
                                    array(
                                        'value' => '' . $queryData['anger'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'appetite' =>
                                    array(
                                        'value' => '' . $queryData['appetite'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'clarity' =>
                                    array(
                                        'value' => '' . $queryData['clarity'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'health' =>
                                    array(
                                        'value' => '' . $queryData['health'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'sleep' =>
                                    array(
                                        'value' => '' . $queryData['sleep'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    )
                                )
                            )
                );
                array_push($returnArray['diaryRecords'], $returnData);
            }
            $returnArray = arrayToXml(collapseValidationArray($returnArray));
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnArray);
            }
        }
        // </editor-fold>
    }

    // </editor-fold>
    // <editor-fold desc="*_BODY_RECORD">
    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>bodyRecord</b> | Parent </li>
     * <li><b>date</b> | Required(true) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>neck</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>shoulders</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>chest</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftBicep</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightBicep</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftForearm</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightForearm</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>waist</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>hips</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftThigh</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightThigh</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftCalf</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightCalf</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>recordId</b> | Required(false) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 238 22}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 318 21}
     */
    public function CREATE_BODY_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "16000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'bodyRecord' =>
                    array(
                        'date' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'neck' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'shoulders' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'chest' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'leftBicep' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'rightBicep' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'leftForearm' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'rightForearm' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'waist' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'hips' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'leftThigh' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'rightThigh' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'leftCalf' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'rightCalf' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        )
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(16002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'insert/createBodyRecord.sql',
                            $this->userId,
                            $vars['bodyRecord']['date'],
                            $vars['bodyRecord']['neck'],
                            $vars['bodyRecord']['shoulders'],
                            $vars['bodyRecord']['chest'],
                            $vars['bodyRecord']['leftBicep'],
                            $vars['bodyRecord']['rightBicep'],
                            $vars['bodyRecord']['leftForarm'],
                            $vars['bodyRecord']['rightForearm'],
                            $vars['bodyRecord']['waist'],
                            $vars['bodyRecord']['hips'],
                            $vars['bodyRecord']['leftThigh'],
                            $vars['bodyRecord']['rightThigh'],
                            $vars['bodyRecord']['leftCalf'],
                            $vars['bodyRecord']['rightCalf']) or $this->reportResult(16001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'recordId' =>
                        array(
                            'value' => '' . mysqli_insert_id($mysqlConnection),
                            'pattern' => '/.+/',
                            'req' => 'false'
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * <li><b>bodyRecord</b> | Parent </li>
     * <li><b>date</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>neck</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>shoulders</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>chest</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftBicep</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightBicep</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftForearm</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightForearm</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>waist</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>hips</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftThigh</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightThigh</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftCalf</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightCalf</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 264 23}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 339 21}
     */
    public function UPDATE_BODY_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "17000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="GET CURRENT DATA">
        $vars = xmlToArray($this->requestData->asXML());
        $queryResults = runQuery(__CLASS__, 'select/selectBodyRecord.sql',
                        $vars['recordId']) or $this->reportResult(16001, __FUNCTION__);
        if (mysqli_num_rows($queryResults) == 0) {
            $this->reportResult(16001, $process);
        }
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        if ($this->resultID == $STATUS_OK) {
            $current = mysqli_fetch_assoc($queryResults);
            $defaultVars =
                    array(
                        'recordId' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'bodyRecord' =>
                        array(
                            'date' =>
                            array(
                                'value' => '' . $current['date'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'neck' =>
                            array(
                                'value' => '' . $current['neck'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'shoulders' =>
                            array(
                                'value' => '' . $current['shoulders'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'chest' =>
                            array(
                                'value' => '' . $current['chest'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'leftBicep' =>
                            array(
                                'value' => '' . $current['leftBicep'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'rightBicep' =>
                            array(
                                'value' => '' . $current['rightBicep'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'leftForearm' =>
                            array(
                                'value' => '' . $current['leftForearm'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'rightForearm' =>
                            array(
                                'value' => '' . $current['rightForearm'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'waist' =>
                            array(
                                'value' => '' . $current['waist'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'hips' =>
                            array(
                                'value' => '' . $current['hips'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'leftThigh' =>
                            array(
                                'value' => '' . $current['leftThigh'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'rightThigh' =>
                            array(
                                'value' => '' . $current['rightThigh'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'leftCalf' =>
                            array(
                                'value' => '' . $current['leftCalf'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'rightCalf' =>
                            array(
                                'value' => '' . $current['rightCalf'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
            );
        }
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(16002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, '/update/updateBodyRecord.sql',
                            $vars['recordId'],
                            $vars['bodyRecord']['date'],
                            $vars['bodyRecord']['neck'],
                            $vars['bodyRecord']['shoulders'],
                            $vars['bodyRecord']['chest'],
                            $vars['bodyRecord']['leftBicep'],
                            $vars['bodyRecord']['rightBicep'],
                            $vars['bodyRecord']['leftForearm'],
                            $vars['bodyRecord']['rightForearm'],
                            $vars['bodyRecord']['waist'],
                            $vars['bodyRecord']['hips'],
                            $vars['bodyRecord']['leftThigh'],
                            $vars['bodyRecord']['rightThigh'],
                            $vars['bodyRecord']['leftCalf'],
                            $vars['bodyRecord']['rightCalf']) or $this->reportResult(001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 291 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 360 21}
     */
    public function DELETE_BODY_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "18000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
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
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'delete/deleteBodyRecord.sql',
                            $vars['recordId']) or $this->reportResult(18001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>bodyRecord</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>date</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>neck</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>shoulders</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>chest</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftBicep</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightBicep</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftForearm</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightForearm</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>waist</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>hips</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftThigh</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightThigh</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftCalf</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightCalf</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 302 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 381 21}
     */
    public function GET_BODY_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "19000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(19002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectBodyRecord.sql',
                            $vars['recordId']) or $this->reportResult(19001, $process);
            if ($this->resultID == $STATUS_OK AND mysqli_num_rows($queryResults) != 0) {
                $queryData = mysqli_fetch_array($queryResults);
            }
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'bodyRecord' =>
                        array(
                            'recordId' =>
                            array(
                                'value' => '' . $queryData['recordId'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'userId' =>
                            array(
                                'value' => '' . $queryData['userId'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'date' =>
                            array(
                                'value' => '' . $queryData['date'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'neck' =>
                            array(
                                'value' => '' . $queryData['neck'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'shoulders' =>
                            array(
                                'value' => '' . $queryData['shoulders'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'chest' =>
                            array(
                                'value' => '' . $queryData['chest'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'leftBicep' =>
                            array(
                                'value' => '' . $queryData['leftBicep'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'rightBicep' =>
                            array(
                                'value' => '' . $queryData['rightBicep'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'leftForearm' =>
                            array(
                                'value' => '' . $queryData['leftForearm'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'rightForearm' =>
                            array(
                                'value' => '' . $queryData['rightForearm'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'waist' =>
                            array(
                                'value' => '' . $queryData['waist'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'hips' =>
                            array(
                                'value' => '' . $queryData['hips'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'leftThigh' =>
                            array(
                                'value' => '' . $queryData['leftThigh'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'rightThigh' =>
                            array(
                                'value' => '' . $queryData['rightThigh'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'leftCalf' =>
                            array(
                                'value' => '' . $queryData['leftCalf'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'rightCalf' =>
                            array(
                                'value' => '' . $queryData['rightCalf'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>bodyRecord</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>date</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>neck</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>shoulders</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>chest</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftBicep</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightBicep</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftForearm</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightForearm</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>waist</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>hips</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftThigh</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightThigh</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>leftCalf</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * <li><b>rightCalf</b> | Required(false) | Default Value(Array) | Parent Node(bodyRecord)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 313 4}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 402 21}
     */
    public function GET_ALL_BODY_RECORDS() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "20000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectAllBodyRecords.sql',
                            $this->userId) or $this->reportResult(20001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnArray['bodyRecords'] = array();
            while ($queryData = mysqli_fetch_array($queryResults)) {
                $returnData =
                        array(
                            'bodyRecord' =>
                            array(
                                'recordId' =>
                                array(
                                    'value' => '' . $queryData['recordId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'userId' =>
                                array(
                                    'value' => '' . $queryData['userId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'date' =>
                                array(
                                    'value' => '' . $queryData['date'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'neck' =>
                                array(
                                    'value' => '' . $queryData['neck'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'shoulders' =>
                                array(
                                    'value' => '' . $queryData['shoulders'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'chest' =>
                                array(
                                    'value' => '' . $queryData['chest'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'leftBicep' =>
                                array(
                                    'value' => '' . $queryData['leftBicep'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'rightBicep' =>
                                array(
                                    'value' => '' . $queryData['rightBicep'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'leftForearm' =>
                                array(
                                    'value' => '' . $queryData['leftForearm'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'rightForearm' =>
                                array(
                                    'value' => '' . $queryData['rightForearm'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'waist' =>
                                array(
                                    'value' => '' . $queryData['waist'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'hips' =>
                                array(
                                    'value' => '' . $queryData['hips'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'leftThigh' =>
                                array(
                                    'value' => '' . $queryData['leftThigh'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'rightThigh' =>
                                array(
                                    'value' => '' . $queryData['rightThigh'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'leftCalf' =>
                                array(
                                    'value' => '' . $queryData['leftCalf'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'rightCalf' =>
                                array(
                                    'value' => '' . $queryData['rightCalf'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                )
                            )
                );
                array_push($returnArray['bodyRecords'], $returnData);
            }
            $returnArray = arrayToXml(collapseValidationArray($returnArray));
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnArray);
            }
        }
        // </editor-fold>
    }

    // </editor-fold>
    // <editor-fold desc="*_FOOD_ITEM_RECORD">
    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>userId</b> | Required(false) | Default Value(Array)</li>
     * <li><b>foodItem</b> | Parent </li>
     * <li><b>name</b> | Required(true) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>calories</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>cholesterol</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>carbs</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>dietaryFiber</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>totalFat</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>sodium</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>sugars</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>protein</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>recordId</b> | Required(false) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 322 18}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 423 21}
     */
    public function CREATE_FOOD_ITEM_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "21000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '' . $this->userId,
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'foodItem' =>
                    array(
                        'name' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'calories' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'cholesterol' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'carbs' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'dietaryFiber' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'totalFat' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'sodium' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'sugars' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        ),
                        'protein' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'false'
                        )
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(21002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'insert/createFoodItemRecord.sql',
                            $vars['userId'],
                            $vars['foodItem']['name'],
                            $vars['foodItem']['calories'],
                            $vars['foodItem']['cholesterol'],
                            $vars['foodItem']['carbs'],
                            $vars['foodItem']['dietaryFiber'],
                            $vars['foodItem']['totalFat'],
                            $vars['foodItem']['sodium'],
                            $vars['foodItem']['sugars'],
                            $vars['foodItem']['protein']) or $this->reportResult(21001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'recordId' =>
                        array(
                            'value' => '' . mysqli_insert_id($mysqlConnection),
                            'pattern' => '/.+/',
                            'req' => 'false'
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * <li><b>foodItem</b> | Parent </li>
     * <li><b>name</b> | Required(true) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>calories</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>cholesterol</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>carbs</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>dietaryFiber</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>totalFat</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>sodium</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>sugars</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>protein</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 344 18}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 444 21}
     */
    public function UPDATE_FOOD_ITEM_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "22000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="GET CURRENT DATA">
        $vars = xmlToArray($this->requestData->asXML());
        $queryResults = runQuery(__CLASS__, 'select/selectFoodItemRecord.sql',
                        $vars['recordId']) or $this->reportResult(22001, __FUNCTION__);
        if (mysqli_num_rows($queryResults) == 0) {
            $this->reportResult(22001, $process);
        }
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        if ($this->resultID == $STATUS_OK) {
            $current = mysqli_fetch_assoc($queryResults);
            $defaultVars =
                    array(
                        'recordId' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'foodItem' =>
                        array(
                            'name' =>
                            array(
                                'value' => '' . $current['name'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'calories' =>
                            array(
                                'value' => '' . $current['calories'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'cholesterol' =>
                            array(
                                'value' => '' . $current['cholesterol'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'carbs' =>
                            array(
                                'value' => '' . $current['carbs'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'dietaryFiber' =>
                            array(
                                'value' => '' . $current['dietaryFiber'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'totalFat' =>
                            array(
                                'value' => '' . $current['totalFat'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'sodium' =>
                            array(
                                'value' => '' . $current['sodium'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'sugars' =>
                            array(
                                'value' => '' . $current['sugars'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'protein' =>
                            array(
                                'value' => '' . $current['protein'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
            );
        }
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(22002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, '/update/updateFoodItemRecord.sql',
                            $vars['recordId'],
                            $vars['foodItem']['name'],
                            $vars['foodItem']['calories'],
                            $vars['foodItem']['cholesterol'],
                            $vars['foodItem']['carbs'],
                            $vars['foodItem']['dietaryFiber'],
                            $vars['foodItem']['totalFat'],
                            $vars['foodItem']['sodium'],
                            $vars['foodItem']['sugars'],
                            $vars['foodItem']['protein']) or $this->reportResult(22001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 366 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 465 21}
     */
    public function DELETE_FOOD_ITEM_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "23000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(23002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'delete/deleteFoodItemRecord.sql',
                            $vars['recordId']) or $this->reportResult(23001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>foodItem</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>name</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>calories</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>cholesterol</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>carbs</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>dietaryFiber</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>totalFat</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>sodium</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>sugars</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>protein</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 377 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 486 21}
     */
    public function GET_FOOD_ITEM_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "24000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(24002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectFoodItemRecord.sql',
                            $vars['recordId']) or $this->reportResult(24001, $process);
            if ($this->resultID == $STATUS_OK AND mysqli_num_rows($queryResults) != 0) {
                $queryData = mysqli_fetch_array($queryResults);
            }
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'foodItem' =>
                        array(
                            'recordId' =>
                            array(
                                'value' => '' . $queryData['recordId'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'userId' =>
                            array(
                                'value' => '' . $queryData['userId'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'name' =>
                            array(
                                'value' => '' . $queryData['name'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'calories' =>
                            array(
                                'value' => '' . $queryData['calories'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'cholesterol' =>
                            array(
                                'value' => '' . $queryData['cholesterol'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'carbs' =>
                            array(
                                'value' => '' . $queryData['carbs'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'dietaryFiber' =>
                            array(
                                'value' => '' . $queryData['dietaryFiber'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'totalFat' =>
                            array(
                                'value' => '' . $queryData['totalFat'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'sodium' =>
                            array(
                                'value' => '' . $queryData['sodium'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'sugars' =>
                            array(
                                'value' => '' . $queryData['sugars'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'protein' =>
                            array(
                                'value' => '' . $queryData['protein'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>foodItem</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>name</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>calories</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>cholesterol</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>carbs</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>dietaryFiber</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>totalFat</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>sodium</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>sugars</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * <li><b>protein</b> | Required(false) | Default Value(Array) | Parent Node(foodItem)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 388 4}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 507 21}
     */
    public function GET_ALL_FOOD_ITEM_RECORDS() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "25000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectAllFoodItemRecords.sql',
                            $this->userId) or $this->reportResult(25001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnArray['foodItems'] = array();
            while ($queryData = mysqli_fetch_array($queryResults)) {
                $returnData =
                        array(
                            'foodItem' =>
                            array(
                                'recordId' =>
                                array(
                                    'value' => '' . $queryData['recordId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'userId' =>
                                array(
                                    'value' => '' . $queryData['userId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'name' =>
                                array(
                                    'value' => '' . $queryData['name'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'calories' =>
                                array(
                                    'value' => '' . $queryData['calories'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'cholesterol' =>
                                array(
                                    'value' => '' . $queryData['cholesterol'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'carbs' =>
                                array(
                                    'value' => '' . $queryData['carbs'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'dietaryFiber' =>
                                array(
                                    'value' => '' . $queryData['dietaryFiber'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'totalFat' =>
                                array(
                                    'value' => '' . $queryData['totalFat'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'sodium' =>
                                array(
                                    'value' => '' . $queryData['sodium'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'sugars' =>
                                array(
                                    'value' => '' . $queryData['sugars'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'protein' =>
                                array(
                                    'value' => '' . $queryData['protein'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                )
                            )
                );
                array_push($returnArray['foodItems'], $returnData);
            }
            $returnArray = arrayToXml(collapseValidationArray($returnArray));
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnArray);
            }
        }
        // </editor-fold>
    }

    // </editor-fold>
    // <editor-fold desc="*_FOOD_RECORD">
    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>foodLog</b> | Parent </li>
     * <li><b>foodDate</b> | Required(true) | Default Value(Array) | Parent Node(foodLog)</li>
     * <li><b>foodMeal</b> | Required(true) | Default Value(Array) | Parent Node(foodLog)</li>
     * <li><b>foodItem</b> | Required(true) | Default Value(Array) | Parent Node(foodLog)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>recordId</b> | Required(false) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 397 11}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 528 21}
     */
    public function CREATE_FOOD_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "26000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'foodLog' =>
                    array(
                        'foodDate' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'foodMeal' =>
                        array(
                            'value' => '',
                            'pattern' => '/.+/',
                            'req' => 'true'
                        ),
                        'foodItem' =>
                        array(
                            'value' => '',
                            'pattern' => '/\d+/',
                            'req' => 'true'
                        )
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(26002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'insert/createFoodRecord.sql',
                            $this->userId,
                            $vars['foodLog']['foodDate'],
                            $vars['foodLog']['foodMeal'],
                            $vars['foodLog']['foodItem']) or $this->reportResult(26001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'recordId' =>
                        array(
                            'value' => '' . mysqli_insert_id($mysqlConnection),
                            'pattern' => '/.+/',
                            'req' => 'false'
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * <li><b>foodLog</b> | Parent </li>
     * <li><b>foodDate</b> | Required(true) | Default Value(Array) | Parent Node(foodLog)</li>
     * <li><b>foodMeal</b> | Required(true) | Default Value(Array) | Parent Node(foodLog)</li>
     * <li><b>foodItem</b> | Required(true) | Default Value(Array) | Parent Node(foodLog)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 412 12}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 549 21}
     */
    public function UPDATE_FOOD_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "27000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="GET CURRENT DATA">
        $vars = xmlToArray($this->requestData->asXML());
        $queryResults = runQuery(__CLASS__, 'select/selectFoodRecord.sql',
                        $vars['recordId']) or $this->reportResult(27001, __FUNCTION__);
        if (mysqli_num_rows($queryResults) == 0) {
            $this->reportResult(27001, $process);
        }
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        if ($this->resultID == $STATUS_OK) {
            $current = mysqli_fetch_assoc($queryResults);
            $defaultVars =
                    array(
                        'recordId' =>
                        array(
                            'value' => '',
                            'pattern' => '/\d+/',
                            'req' => 'true'
                        ),
                        'foodLog' =>
                        array(
                            'foodDate' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'foodMeal' =>
                            array(
                                'value' => '',
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'foodItem' =>
                            array(
                                'value' => '',
                                'pattern' => '/\d+/',
                                'req' => 'true'
                            )
                        )
            );
        }
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(27002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, '/update/updateFoodRecord.sql',
                            $vars['recordId'],
                            $vars['foodLog']['foodDate'],
                            $vars['foodLog']['foodMeal'],
                            $vars['foodLog']['foodItem']) or $this->reportResult(27001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 428 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 570 21}
     */
    public function DELETE_FOOD_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "28000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(28002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            runQuery(__CLASS__, 'delete/deleteFoodRecord.sql',
                            $vars['recordId']) or $this->reportResult(28001, $process);
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>recordId</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>foodLog</b> | Parent </li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(foodLog)</li>
     * <li><b>foodDate</b> | Required(false) | Default Value(Array) | Parent Node(foodLog)</li>
     * <li><b>foodMeal</b> | Required(false) | Default Value(Array) | Parent Node(foodLog)</li>
     * <li><b>foodItem</b> | Required(false) | Default Value(Array) | Parent Node(foodLog)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 439 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 591 21}
     */
    public function GET_FOOD_RECORD() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "29000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'recordId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(29002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectFoodRecord.sql',
                            $vars['recordId']) or $this->reportResult(29001, $process);
            if ($this->resultID == $STATUS_OK AND mysqli_num_rows($queryResults) != 0) {
                $queryData = mysqli_fetch_array($queryResults);
            }
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'foodLog' =>
                        array(
                            'userId' =>
                            array(
                                'value' => '' . $queryData['userId'],
                                'pattern' => '/\d+/',
                                'req' => 'false'
                            ),
                            'foodDate' =>
                            array(
                                'value' => '' . $queryData['date'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'foodMeal' =>
                            array(
                                'value' => '' . $queryData['meal'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'foodItem' =>
                            array(
                                'name' =>
                                array(
                                    'value' => '' . $queryData['name'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'calories' =>
                                array(
                                    'value' => '' . $queryData['calories'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'cholesterol' =>
                                array(
                                    'value' => '' . $queryData['cholesterol'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'carbs' =>
                                array(
                                    'value' => '' . $queryData['carbs'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'dietaryFiber' =>
                                array(
                                    'value' => '' . $queryData['dietaryFiber'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'totalFat' =>
                                array(
                                    'value' => '' . $queryData['totalFat'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'sodium' =>
                                array(
                                    'value' => '' . $queryData['sodium'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'sugars' =>
                                array(
                                    'value' => '' . $queryData['sugars'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'protein' =>
                                array(
                                    'value' => '' . $queryData['protein'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                )
                            )
                        )
            );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
        // </editor-fold>
    }

    /**
     * {PURPOSE}
     *
     * <b>Inputs:</b>
     * <ul>
     * <li><b>date</b> | Required(true) | Default Value(Array)</li>
     * </ul>
     *
     * <b>Return Data:</b>
     * <ul>
     * <li><b>record</b> | Parent </li>
     * <li><b>recordId</b> | Required(false) | Default Value(Array) | Parent Node(record)</li>
     * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(record)</li>
     * <li><b>foodDate</b> | Required(false) | Default Value(Array) | Parent Node(record)</li>
     * <li><b>foodMeal</b> | Required(false) | Default Value(Array) | Parent Node(record)</li>
     * <li><b>foodItem</b> | Required(false) | Default Value(Array) | Parent Node(record)</li>
     * </ul>
     *
     * <b>Example XML Request:</b>
     * {@example ./healthjournal/healthjournal.examples.php 450 7}
     *
     * <b>Example XML Responses:</b>
     * {@example ./healthjournal/healthjournal.responses.xml 612 21}
     */
    public function GET_ALL_FOOD_RECORDS() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "30000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'date' =>
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
            $this->reportResult(30002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery(__CLASS__, 'select/selectAllFoodRecords.sql',
                            $this->userId,
                            $vars['date']) or $this->reportResult(30001, $process);
            // </editor-fold>
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnArray['foodRecords'] = array();
            while ($queryData = mysqli_fetch_array($queryResults)) {
                $returnData =
                        array(
                            'record' =>
                            array(
                                'recordId' =>
                                array(
                                    'value' => '' . $queryData['recordId'],
                                    'pattern' => '/\d+/',
                                    'req' => 'false'
                                ),
                                'userId' =>
                                array(
                                    'value' => '' . $queryData['userId'],
                                    'pattern' => '/\d+/',
                                    'req' => 'false'
                                ),
                                'foodDate' =>
                                array(
                                    'value' => '' . $queryData['date'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'foodMeal' =>
                                array(
                                    'value' => '' . $queryData['meal'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'foodItem' =>
                                array(
                                    'name' =>
                                    array(
                                        'value' => '' . $queryData['name'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'calories' =>
                                    array(
                                        'value' => '' . $queryData['calories'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'cholesterol' =>
                                    array(
                                        'value' => '' . $queryData['cholesterol'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'carbs' =>
                                    array(
                                        'value' => '' . $queryData['carbs'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'dietaryFiber' =>
                                    array(
                                        'value' => '' . $queryData['dietaryFiber'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'totalFat' =>
                                    array(
                                        'value' => '' . $queryData['totalFat'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'sodium' =>
                                    array(
                                        'value' => '' . $queryData['sodium'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'sugars' =>
                                    array(
                                        'value' => '' . $queryData['sugars'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    ),
                                    'protein' =>
                                    array(
                                        'value' => '' . $queryData['protein'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    )
                                )
                            )
                );
                array_push($returnArray['foodRecords'], $returnData);
            }
            $returnArray = arrayToXml(collapseValidationArray($returnArray));
            // </editor-fold>
            // <editor-fold desc="RETURN RESULTS">
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnArray);
            }
        }
        // </editor-fold>
    }

    // </editor-fold>

    public function GET_CHART_DATA() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "31000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'datasetName' =>
                    array(
                        'value' => '',
                        'pattern' => '/' .
                        'MILES\_BY\_DAY|' .
                        'MINUTES\_BY\_DAY|' .
                        'MILES\_BY\_ACTIVITY|' .
                        'MINUTES\_BY\_ACTIVITY|' .
                        'VITALS\_BY\_DAY' .
                        '/',
                        'req' => 'true'
                    ),
                    'startDate' =>
                    array(
                        'value' => '1000-01-01',
                        'pattern' => '/\d\d\d\d\-\d\d\-\d\d/',
                        'req' => 'false'
                    ),
                    'endDate' =>
                    array(
                        'value' => '' . date('Y-m-d'),
                        'pattern' => '/\d\d\d\d\-\d\d\-\d\d/',
                        'req' => 'false'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(31002, $process, $vars);
        }
        // </editor-fold>
        // <editor-fold desc="EXECUTE LOGIC">
        if ($this->resultID == $STATUS_OK) {
            switch ($vars['datasetName']) {
                // <editor-fold desc="MILES_BY_DAY">
                case "MILES_BY_DAY":
                    $type = "line";
                    $legend = "Miles By Day";
                    $queryResults = runQuery(__CLASS__, 'select/MILES_BY_DAY.sql',
                                    $this->userId,
                                    $vars['startDate'],
                                    $vars['endDate']) or $this->reportResult(31001, $process);
                    break;
                // </editor-fold>
                // <editor-fold desc="MINUTES_BY_DAY">
                case "MINUTES_BY_DAY":
                    $type = "line";
                    $legend = "Minutes By Day";
                    $queryResults = runQuery(__CLASS__, 'select/MINUTES_BY_DAY.sql',
                                    $this->userId,
                                    $vars['startDate'],
                                    $vars['endDate']) or $this->reportResult(31001, $process);
                    break;
                // </editor-fold>
                // <editor-fold desc="MILES_BY_ACTIVITY">
                case "MILES_BY_ACTIVITY":
                    $type = "bar";
                    $legend = "Miles By Activity";
                    $queryResults = runQuery(__CLASS__, 'select/MILES_BY_ACTIVITY.sql',
                                    $this->userId,
                                    $vars['startDate'],
                                    $vars['endDate']) or $this->reportResult(31001, $process);
                    break;
                // </editor-fold>
                // <editor-fold desc="MINUTES_BY_ACTIVITY">
                case "MINUTES_BY_ACTIVITY":
                    $type = "bar";
                    $legend = "Minutes By Activity";
                    $queryResults = runQuery(__CLASS__, 'select/MINUTES_BY_ACTIVITY.sql',
                                    $this->userId,
                                    $vars['startDate'],
                                    $vars['endDate']) or $this->reportResult(31001, $process);
                    break;
                // </editor-fold>
                // <editor-fold desc="VITALS_BY_DAY">
                case "VITALS_BY_DAY":
                    $type = "line";
                    $legend = "Vitals By Day";
                    $queryResults = runQuery(__CLASS__, 'select/VITALS_BY_DAY.sql',
                                    $this->userId,
                                    $vars['startDate'],
                                    $vars['endDate']) or $this->reportResult(31001, $process);
                    break;
                // </editor-fold>
            }
        }
        // </editor-fold>
        // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
        switch ($vars['datasetName']) {
            // <editor-fold desc="MILES_BY_DAY">
            case "MILES_BY_DAY":
                $returnData =
                        "<graph>" .
                        "<type>" . $type . "</type>" .
                        "<legend>" . $legend . "</legend>" .
                        "<series>" .
                        "<label>All Activities</label>" .
                        "<dataSet>";
                while ($queryData = mysqli_fetch_array($queryResults)) {
                    $returnData .=
                            "<point>" .
                            "<x>" . $queryData['activityDate'] . "</x>" .
                            "<y>" . $queryData['totalMiles'] . "</y>" .
                            "</point>";
                }
                $returnData .=
                        "</dataSet>" .
                        "</series>" .
                        "</graph>";
                break;
            // </editor-fold>
            // <editor-fold desc="MINUTES_BY_DAY">
            case "MINUTES_BY_DAY":
                $returnData =
                        "<graph>" .
                        "<type>" . $type . "</type>" .
                        "<legend>" . $legend . "</legend>" .
                        "<series>" .
                        "<label>All Activities</label>" .
                        "<dataSet>";
                while ($queryData = mysqli_fetch_array($queryResults)) {
                    $returnData .=
                            "<point>" .
                            "<x>" . $queryData['activityDate'] . "</x>" .
                            "<y>" . $queryData['totalMinutes'] . "</y>" .
                            "</point>";
                }
                $returnData .=
                        "</dataSet>" .
                        "</series>" .
                        "</graph>";
                break;
            // </editor-fold>
            // <editor-fold desc="MILES_BY_ACTIVITY">
            case "MILES_BY_ACTIVITY":
                $returnData =
                        "<graph>" .
                        "<type>" . $type . "</type>" .
                        "<legend>" . $legend . "</legend>";
                while ($queryData = mysqli_fetch_array($queryResults)) {
                    $returnData .=
                            "<series>" .
                            "<name>" . $queryData['activityType'] . "</name>" .
                            "<value>" . $queryData['totalMiles'] . "</value>" .
                            "</series>";
                }
                $returnData .=
                        "</graph>";
                break;
            // </editor-fold>
            // <editor-fold desc="MINUTES_BY_ACTIVITY">
            case "MINUTES_BY_ACTIVITY":
                $returnData =
                        "<graph>" .
                        "<type>" . $type . "</type>" .
                        "<legend>" . $legend . "</legend>";
                while ($queryData = mysqli_fetch_array($queryResults)) {
                    $returnData .=
                            "<series>" .
                            "<name>" . $queryData['activityType'] . "</name>" .
                            "<value>" . $queryData['totalMinutes'] . "</value>" .
                            "</series>";
                }
                $returnData .=
                        "</graph>";
                break;
            // </editor-fold>
            // <editor-fold desc="VITALS_BY_DAY">
            case "VITALS_BY_DAY":
                $returnData =
                        "<graph>" .
                        "<type>" . $type . "</type>" .
                        "<legend>" . $legend . "</legend>";

                $glucoseSeries =
                        "<series>" .
                        "<label>Glucose</label>" .
                        "<dataSet>";
                $sycSeries =
                        "<series>" .
                        "<label>SYC</label>" .
                        "<dataSet>";
                $dyaSeries =
                        "<series>" .
                        "<label>DYA</label>" .
                        "<dataSet>";
                $ldlSeries =
                        "<series>" .
                        "<label>LDL</label>" .
                        "<dataSet>";
                $hdlSeries =
                        "<series>" .
                        "<label>HDL</label>" .
                        "<dataSet>";

                while ($queryData = mysqli_fetch_array($queryResults)) {
                    $glucoseSeries .=
                            "<point>" .
                            "<x>" . $queryData['date'] . "</x>" .
                            "<y>" . $queryData['glucose'] . "</y>" .
                            "</point>";
                    $sycSeries .=
                            "<point>" .
                            "<x>" . $queryData['date'] . "</x>" .
                            "<y>" . $queryData['syc'] . "</y>" .
                            "</point>";
                    $dyaSeries .=
                            "<point>" .
                            "<x>" . $queryData['date'] . "</x>" .
                            "<y>" . $queryData['dya'] . "</y>" .
                            "</point>";
                    $ldlSeries .=
                            "<point>" .
                            "<x>" . $queryData['date'] . "</x>" .
                            "<y>" . $queryData['ldl'] . "</y>" .
                            "</point>";
                    $hdlSeries .=
                            "<point>" .
                            "<x>" . $queryData['date'] . "</x>" .
                            "<y>" . $queryData['hdl'] . "</y>" .
                            "</point>";
                }

                $glucoseSeries .=
                        "</dataSet>" .
                        "</series>";
                $sycSeries .=
                        "</dataSet>" .
                        "</series>";
                $dyaSeries .=
                        "</dataSet>" .
                        "</series>";
                $ldlSeries .=
                        "</dataSet>" .
                        "</series>";
                $hdlSeries .=
                        "</dataSet>" .
                        "</series>";

                $returnData .=
                        $glucoseSeries .
                        $sycSeries .
                        $dyaSeries .
                        $ldlSeries .
                        $hdlSeries .
                        "</graph>";
                break;
            // </editor-fold>
        }
        //</editor-fold>
        // <editor-fold desc="RETURN RESULTS">
        if ($this->resultID == $STATUS_OK) {
            $this->reportResult($STATUS_OK, $process, $returnData);
        }
        // </editor-fold>
    }

}

?>
