<?php

class EventHandler {

    private $elapsedTime;
    private $startTime;
    
    private $outputMethod;
    private $redirects;
    public $outputXML;
    public $lastResult;
    public $finalDispo;

    function __construct() {
        $this->outputMethod = "ECHO";
    }

    public function openStream() {
        $this->startTime = microtime(true);
        $this->finalDispo = "OK";
        $this->outputXML = "<?xml version=\"1.0\" encoding=\"utf-8\"?><responses>";
    }

    public function closeStream() {
        $this->outputXML .= "</responses>" . urldecode("%0A");
        $this->startTime = 0;
        $this->elapsedTime = 0;
        switch ($this->outputMethod) {
            case "ECHO":
                $this->outputECHO();
                break;
            case "REDIRECT":
                $this->outputREDIRECT();
                break;
        }
    }

    public function setOutput($settingsXML = false) {
        // LOAD SETTINGS XML INTO MEMORY
        if ($settingsXML === false) {
            // IF settingsXML is not supplied set output method to Echo be deafult
            $this->outputMethod = "ECHO";
        } else {
            $this->outputMethod = (string) $settingsXML->method;
        }
        // IF REDIRECT OUTPUT METHOD IS SELECTED ADD URLS TO EVENT HANDLER
        if ($this->outputMethod == "REDIRECT") {
            foreach ($settingsXML->redirects as $redirect) {
                $this->redirects = array();
                foreach ($redirect as $result => $value) {
                    $this->redirects["$result"] = (string) $value;
                }
            }
        }
    }

    public function handle($module, $process, $errorid, $returnData = false) {
        $response = $this->getResponseInfo($module, $process, $errorid);
        $this->logResult($module,
                (string) $response->parent,
                (string) $response->errorid,
                (string) $response->description,
                (string) $response->message,
                (string) $response->result,
                $returnData);

        if ((string) $response->result == "FATAL") {
            $this->finalDispo = (string) $response->result;
        }
    }

    public function undefinedMethod($module, $process) {
        $XML =
                "<response>
                    <parent>eventmanager</parent>
                    <errorid>9000</errorid>
                    <description>REQUESTED METHOD NOT FOUND ($module:$process)</description>
                    <message>Process Failed</message>
                    <result>FATAL</result>
                 </response>";
        $result = simplexml_load_string($XML);

        $this->logResult($module . ".php",
                (string) $result->parent,
                (string) $result->errorid,
                (string) $result->description,
                (string) $result->message,
                (string) $result->event,
                "");

        if ((string) $result->event == "FATAL") {
            $this->finalDispo = (string) $result->event;
        }
    }

    private function logResult($module, $process, $errorid, $errorDescription, $errorMessage, $result, $returnData = false) {
        $endTime = microtime(true);
        $this->elapsedTime = $endTime - $this->startTime;
        $this->startTime = microtime(true);
        global $mysqlConnection;
        if($result == 'OK'){
            runQuery('framework','logResult.sql',
                date('Y-m-d H:i:s'),
                    $module,
                    $process,
                    $errorid,
                    $errorDescription,
                    $errorMessage,
                    $_SERVER['REMOTE_ADDR'],
                    $result,
                    $this->elapsedTime,
                    $_SESSION['MasterSession']->SESSION['usermanager']->user->userId,
                    '');
        } else { // IF THE EVENT IS NOT OK
            runQuery('framework', 'logResult.sql',
                    date('Y-m-d H:i:s'),
                    $module,
                    $process,
                    $errorid,
                    $errorDescription,
                    $errorMessage,
                    $_SERVER['REMOTE_ADDR'],
                    $result,
                    $this->elapsedTime,
                    $_SESSION['MasterSession']->SESSION['usermanager']->user->userId,
                    $returnData);
            // <editor-fold desc="CREATE REDMINE ISSUE TICKET IF REDMINE IS ENABLED">
            $settings = simplexml_load_file('framework/settings.xml');
            if ((string) $settings->redmine->enabled == 'true') {
                $issueXML =
                        '<?xml version="1.0"?>
            <issue>
                <subject>(EH) [M:' . $module . '][P:' . $process . '][E:' . $result . ']</subject>
                <project_id>' . (string) $settings->redmine->projectId . '</project_id>
                <priority_id>15</priority_id>
                <tracker_id>10</tracker_id>
                <description>
             *Date / Time (Y-m-d H:i:s) :* ' . date('Y-m-d H:i:s') . '
                                *Module :* ' . $module . '
                               *Process :* ' . $process . '
                              *Error Id :* ' . $errorid . '
                     *Error Description :* ' . $errorDescription . '
                         *Error Message :* ' . $errorMessage . '
                        *Remote Address :* ' . $_SERVER['REMOTE_ADDR'] . '
                                *Result :* ' . $result . '
                          *Elapsed Time :* ' . $this->elapsedTime . '
                               *User Id :* ' . $_SESSION['MasterSession']->SESSION['usermanager']->user->userId . '
                           *Return Data :*
                           ' . $returnData . '
                </description>
            </issue>';

                $request = curl_init("http://" . (string) $settings->redmine->apiKey . ":password@" .
                                (string) $settings->redmine->url . '/projects/' .
                                (string) $settings->redmine->projectName . '/issues.xml'); // initiate curl object
                curl_setopt($request, CURLOPT_HEADER, 0);  // set to 0 to eliminate header info from response
                curl_setopt($request, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
                curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);  // Returns response data instead of TRUE(1)
                curl_setopt($request, CURLOPT_POSTFIELDS, $issueXML);  // use HTTP POST to send form data
                curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);  // uncomment this line if you get no gateway response.
                $post_response = curl_exec($request);  // execute curl post and store results in $post_response
                curl_close($request); // close curl object
            }
            // </editor-fold>
        }

        $this->lastResult =
                "<response>" .
                "<module>$module</module>" .
                "<process>$process</process>" .
                "<errorid>$errorid</errorid>" .
                "<description>" . $errorDescription . "</description>" .
                "<message>" . $errorMessage . "</message>" .
                "<result>" . $result . "</result>";
        if ($returnData !== false) {
            $this->lastResult .= "<data>" . $returnData . "</data>";
        }
        $this->lastResult .= "</response>";
        $this->outputXML .= $this->lastResult;
    }

    private function getResponseInfo($module, $process, $errorid) {
        $foundErrorId = false;
        $defualtXML =
                "<response>
                    <parent>eventmanager</parent>
                    <errorid>9000</errorid>
                    <description>FAILED TO LOCATE REQUEST RESULT INFORMATION (Module:$module|Process:$process|ErrorId:$errorid)</description>
                    <message>Process Failed</message>
                    <result>WARNING</result>
                 </response>";
        if ($module == "CORE") {
            $responses = simplexml_load_file('framework/core.responses.xml');
        } else {
            $responses = simplexml_load_file($module . '/' . $module . '.responses.xml');
        }

        foreach ($responses as $response) {
            if ((string) $response->parent == $process AND (string) $response->errorid == $errorid) {
                $foundErrorId = true;
                return $response;
            }
        }
        if ($foundErrorId === false) {
            return simplexml_load_string($defualtXML);
        }
    }

    private function outputECHO() {
        header("content-type: text/xml");
        echo $this->outputXML;
    }

    private function outputREDIRECT() {
        header("Location: " . $this->redirects[$this->finalDispo]);
        exit;
    }

}

?>
