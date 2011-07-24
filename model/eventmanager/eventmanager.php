<?php
/**
 * @author Steven J. Zurek
 * @version 2.0.0rc1
 * @copyright 2011
 * @package Modules
 */

/**
 * The eventmanager class extends the Neptune Core Module class allowing any of the public functions to be accessed via HTTP Requests.
 */
class eventmanager extends Module {

/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>title</b> | Required(true) | Default Value(Array)</li>
 * <li><b>date</b> | Required(true) | Default Value(Array)</li>
 * <li><b>timeHour</b> | Required(true) | Default Value(Array)</li>
 * <li><b>timeMinute</b> | Required(true) | Default Value(Array)</li>
 * <li><b>timeAMPM</b> | Required(true) | Default Value(Array)</li>
 * <li><b>location</b> | Required(true) | Default Value(Array)</li>
 * <li><b>image</b> | Required(false) | Default Value(Array)</li>
 * <li><b>description</b> | Required(false) | Default Value(Array)</li>
 * <li><b>url</b> | Required(false) | Default Value(Array)</li>
 * <li><b>recurring</b> | Required(false) | Default Value(Array)</li>
 * <li><b>category</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 * <ul>
 * <li><b>eventId</b> | Required(false) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Example XML Request:</b>
 * {@example ./eventmanager/eventmanager.examples.php 5 17}
 *
 * <b>Example XML Responses:</b>
 * {@example ./eventmanager/eventmanager.responses.xml 3 21}
 */ 
    public function CREATE_EVENT() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "1000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'title' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'date' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'timeHour' =>
                    array(
                        'value' => '',
                        'pattern' => '/(\d)?\d/',
                        'req' => 'true'
                    ),
                    'timeMinute' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d\d/',
                        'req' => 'true'
                    ),
                    'timeAMPM' =>
                    array(
                        'value' => '',
                        'pattern' => '/AM|am|PM|pm/',
                        'req' => 'true'
                    ),
                    'location' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'image' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'description' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'url' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'recurring' =>
                    array(
                        'value' => '',
                        'pattern' => '/true|false/',
                        'req' => 'false'
                    ),
                    'category' =>
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
            $this->reportResult(1002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('eventmanager', 'insert/createEvent.sql',
                            $vars['title'],
                            $vars['date'],
                            $vars['timeHour'],
                            $vars['timeMinute'],
                            $vars['timeAMPM'],
                            $vars['location'],
                            $vars['image'],
                            $vars['description'],
                            $vars['url'],
                            $vars['recurring'],
                            $vars['category']) or $this->reportResult(1001, $process);
            if ($this->resultID == $STATUS_OK) {
                // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
                $returnData =
                        array(
                            'eventId' =>
                            array(
                                'value' => '' . mysqli_insert_id($mysqlConnection),
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                );
                //</editor-fold>
                $this->reportResult($STATUS_OK, $process, arrayToXml(collapseValidationArray($returnData)));
            }
        }
    }

/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>eventId</b> | Required(true) | Default Value(Array)</li>
 * <li><b>title</b> | Required(false) | Default Value(Array)</li>
 * <li><b>date</b> | Required(false) | Default Value(Array)</li>
 * <li><b>timeHour</b> | Required(false) | Default Value(Array)</li>
 * <li><b>timeMinute</b> | Required(false) | Default Value(Array)</li>
 * <li><b>timeAMPM</b> | Required(false) | Default Value(Array)</li>
 * <li><b>location</b> | Required(false) | Default Value(Array)</li>
 * <li><b>image</b> | Required(false) | Default Value(Array)</li>
 * <li><b>description</b> | Required(false) | Default Value(Array)</li>
 * <li><b>url</b> | Required(false) | Default Value(Array)</li>
 * <li><b>recurring</b> | Required(false) | Default Value(Array)</li>
 * <li><b>category</b> | Required(false) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./eventmanager/eventmanager.examples.php 27 18}
 *
 * <b>Example XML Responses:</b>
 * {@example ./eventmanager/eventmanager.responses.xml 24 21}
 */ 
    public function UPDATE_EVENT() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "2000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="GET CURRENT DATA">
        $vars = xmlToArray($this->requestData->asXML());
        $queryResults = runQuery('eventmanager', 'select/selectEvent.sql',
                        $vars['eventId']) or $this->reportResult(2001, __FUNCTION__);
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $current = mysqli_fetch_assoc($queryResults);
        $defaultVars =
                array(
                    'eventId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    ),
                    'title' =>
                    array(
                        'value' => '' . $current['title'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'date' =>
                    array(
                        'value' => '' . $current['date'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'timeHour' =>
                    array(
                        'value' => '' . $current['timeHour'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'timeMinute' =>
                    array(
                        'value' => '' . $current['timeMinute'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'timeAMPM' =>
                    array(
                        'value' => '' . $current['timeAMPM'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'location' =>
                    array(
                        'value' => '' . $current['location'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'image' =>
                    array(
                        'value' => '' . $current['image'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'description' =>
                    array(
                        'value' => '' . $current['description'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'url' =>
                    array(
                        'value' => '' . $current['url'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'recurring' =>
                    array(
                        'value' => '' . $current['recurring'],
                        'pattern' => '/true|false/',
                        'req' => 'false'
                    ),
                    'category' =>
                    array(
                        'value' => '' . $current['category'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    )
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(2002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('eventmanager', 'update/updateEvent.sql',
                            $vars['eventId'],
                            $vars['title'],
                            $vars['date'],
                            $vars['timeHour'],
                            $vars['timeMinute'],
                            $vars['timeAMPM'],
                            $vars['location'],
                            $vars['image'],
                            $vars['description'],
                            $vars['url'],
                            $vars['recurring'],
                            $vars['category']) or $this->reportResult(2001, $process);
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
 * <li><b>eventId</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./eventmanager/eventmanager.examples.php 50 7}
 *
 * <b>Example XML Responses:</b>
 * {@example ./eventmanager/eventmanager.responses.xml 45 21}
 */ 
    public function DELETE_EVENT() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "3000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'eventId' =>
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
        if ($this->resultID == $STATUS_OK) {
            runQuery('eventmanager', 'delete/deleteEvent.sql', $vars['eventId']) or $this->reportResult(3001, $process);
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
 * <li><b>eventId</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 * <ul>
 * <li><b>event</b> | Parent </li>
 * <li><b>eventId</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>title</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>date</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>timeHour</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>timeMinute</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>timeAMPM</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>location</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>image</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>description</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>url</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>recurring</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>category</b> | Required(false) | Default Value(Array) | Parent Node(event)</li>
 * </ul>
 *
 * <b>Example XML Request:</b>
 * {@example ./eventmanager/eventmanager.examples.php 62 7}
 *
 * <b>Example XML Responses:</b>
 * {@example ./eventmanager/eventmanager.responses.xml 66 21}
 */ 
    public function GET_EVENT() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "4000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'eventId' =>
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
            $this->reportResult(4002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery('eventmanager', 'select/selectEvent.sql', $vars['eventId']) or $this->reportResult(4001, $process);
            $queryData = mysqli_fetch_array($queryResults);
            // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
            $returnData =
                    array(
                        'event' =>
                        array(
                            'eventId' =>
                            array(
                                'value' => '' . $queryData['eventId'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'title' =>
                            array(
                                'value' => '' . $queryData['title'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'date' =>
                            array(
                                'value' => '' . $queryData['date'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'timeHour' =>
                            array(
                                'value' => '' . $queryData['timeHour'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'timeMinute' =>
                            array(
                                'value' => '' . $queryData['timeMinute'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'timeAMPM' =>
                            array(
                                'value' => '' . $queryData['timeAMPM'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'location' =>
                            array(
                                'value' => '' . $queryData['location'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'image' =>
                            array(
                                'value' => '' . $queryData['image'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'description' =>
                            array(
                                'value' => '' . $queryData['description'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'url' =>
                            array(
                                'value' => '' . $queryData['url'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'recurring' =>
                            array(
                                'value' => '' . $queryData['recurring'],
                                'pattern' => '/true|false/',
                                'req' => 'true'
                            ),
                            'category' =>
                            array(
                                'value' => '' . $queryData['category'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
                    );
            $returnData = arrayToXml(collapseValidationArray($returnData));
            //</editor-fold>
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, $returnData);
            }
        }
    }

/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 *
 * <b>Return Data:</b>
 * <ul>
 * <li><b>event</b> | Parent </li>
 * <li><b>eventId</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>title</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>date</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>timeHour</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>timeMinute</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>timeAMPM</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>location</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>image</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>description</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>url</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>recurring</b> | Required(true) | Default Value(Array) | Parent Node(event)</li>
 * <li><b>category</b> | Required(false) | Default Value(Array) | Parent Node(event)</li>
 * </ul>
 *
 * <b>Example XML Request:</b>
 * {@example ./eventmanager/eventmanager.examples.php 74 4}
 *
 * <b>Example XML Responses:</b>
 * {@example ./eventmanager/eventmanager.responses.xml 87 21}
 */ 
    public function GET_ALL_EVENTS() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "5000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery('eventmanager', 'select/selectAllEvents.sql') or $this->reportResult(5001, $process);
            $returnArray['events'] = array();
            while ($queryData = mysqli_fetch_array($queryResults)) {
                // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
                $returnData =
                    array(
                        'event' =>
                        array(
                            'eventId' =>
                            array(
                                'value' => '' . $queryData['eventId'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'title' =>
                            array(
                                'value' => '' . $queryData['title'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'date' =>
                            array(
                                'value' => '' . $queryData['date'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'timeHour' =>
                            array(
                                'value' => '' . $queryData['timeHour'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'timeMinute' =>
                            array(
                                'value' => '' . $queryData['timeMinute'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'timeAMPM' =>
                            array(
                                'value' => '' . $queryData['timeAMPM'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'location' =>
                            array(
                                'value' => '' . $queryData['location'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'image' =>
                            array(
                                'value' => '' . $queryData['image'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'description' =>
                            array(
                                'value' => '' . $queryData['description'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'url' =>
                            array(
                                'value' => '' . $queryData['url'],
                                'pattern' => '/.+/',
                                'req' => 'true'
                            ),
                            'recurring' =>
                            array(
                                'value' => '' . $queryData['recurring'],
                                'pattern' => '/true|false/',
                                'req' => 'true'
                            ),
                            'category' =>
                            array(
                                'value' => '' . $queryData['category'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
                    );
                //</editor-fold>
                array_push($returnArray['events'], $returnData);
            }
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, arrayToXml(collapseValidationArray($returnArray)));
            }
        }
    }

/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>userId</b> | Required(false) | Default Value(Array)</li>
 * <li><b>eventId</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./eventmanager/eventmanager.examples.php 83 8}
 *
 * <b>Example XML Responses:</b>
 * {@example ./eventmanager/eventmanager.responses.xml 108 21}
 */ 
    public function RSVP() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "6000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        if (isset($_SESSION['MasterSession']->SESSION['usermanager']->user->userId)) {
            $userId = $_SESSION['MasterSession']->SESSION['usermanager']->user->userId;
        } else {
            $userId = 0;
        }
        $defaultVars =
                array(
                    'userId' =>
                    array(
                        'value' => '' . $userId,
                        'pattern' => '/\d+/',
                        'req' => 'false'
                    ),
                    'eventId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    ),
        );
        // </editor-fold>
        // <editor-fold desc="VALIDATE REQUEST">
        $vars = validateRequestData($defaultVars, xmlToArray($this->requestData->asXML()));
        if (gettype($vars) != 'array') {
            $this->reportResult(6002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('eventmanager', 'insert/createRsvp.sql', $vars['eventId'], $vars['userId']) or $this->reportResult(6001, $process);
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
 * <li><b>eventId</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./eventmanager/eventmanager.examples.php 96 8}
 *
 * <b>Example XML Responses:</b>
 * {@example ./eventmanager/eventmanager.responses.xml 129 21}
 */ 
    public function CANCEL_RSVP() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "7000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        if (isset($_SESSION['MasterSession']->SESSION['usermanager']->user->userId)) {
            $userId = $_SESSION['MasterSession']->SESSION['usermanager']->user->userId;
        } else {
            $userId = 0;
        }
        $defaultVars =
                array(
                    'eventId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    ),
                    'userId' =>
                    array(
                        'value' => '' . $userId,
                        'pattern' => '/\d+/',
                        'req' => 'false'
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
            
            runQuery('eventmanager', 'delete/deleteRsvp.sql', $vars['eventId'], $vars['userId']) or $this->reportResult(7001, $process);
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
 * <li><b>eventId</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 * <ul>
 * <li><b>attendee</b> | Parent </li>
 * <li><b>userId</b> | Required(false) | Default Value(Array) | Parent Node(attendee)</li>
 * </ul>
 *
 * <b>Example XML Request:</b>
 * {@example ./eventmanager/eventmanager.examples.php 109 7}
 *
 * <b>Example XML Responses:</b>
 * {@example ./eventmanager/eventmanager.responses.xml 150 21}
 */ 
    public function GET_ALL_ATTENDEES() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "8000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'eventId' =>
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
        if ($this->resultID == $STATUS_OK) {
            $queryResults = runQuery('eventmanager', 'select/selectAllAttendees.sql', $vars['eventId']) or $this->reportResult(8002, $process);
            if ($this->resultID == $STATUS_OK) {
                $returnArray['attendees'] = array();
                while ($queryData = mysqli_fetch_array($queryResults)) {
                    // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
                    $returnData =
                            array(
                                'attendee' =>
                                array(
                                    'userId' =>
                                    array(
                                        'value' => '' . $queryData['userId'],
                                        'pattern' => '/.+/',
                                        'req' => 'false'
                                    )
                                )
                            );
                    //</editor-fold>
                    array_push($returnArray['attendees'], $returnData);
                }
                $this->reportResult($STATUS_OK, $process, arrayToXml(collapseValidationArray($returnArray)));
            }
        }
    }

}

?>
