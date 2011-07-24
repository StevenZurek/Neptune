<?php
// -------------------------------------------------------------------------------------
// Copyright (c) 2010 Azimuth 360, LLC
// Author - Steven J. Zurek
// All rights reserved.
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
require_once("framework/framework.php");
class processor extends eventDriver {
    function __construct() {
        parent::__construct();
        $this->parent = "CORE";
        $symbols = array();
        //<editor-fold desc="OPEN EVENT HANDLER STREAM">
        $_SESSION['MasterSession']->SESSION['EventHandler']->openStream();
        $_SESSION['MasterSession']->SESSION['EventHandler']->setOutput();
        //</editor-fold>
        if (isset($_POST['query'])) {
            // <editor-fold desc="LOAD REQUEST XML">
            $requestXML = simplexml_load_string($_POST['query']) or $this->reportResult(1002, 'PROCESSOR');
            // </editor-fold>
            //<editor-fold desc="SET EVENT HANDLER OUTPUT">
            if (isset($requestXML->output)) {
                $_SESSION['MasterSession']->SESSION['EventHandler']->setOutput($requestXML->output);
            }
            //</editor-fold>
            // <editor-fold desc="MAKE API CALLS">
            foreach ($requestXML->request as $request) {
                set_time_limit(10);
                if ($_SESSION['MasterSession']->SESSION['EventHandler']->finalDispo !== "FATAL") {  // CHECK FOR FATAL ERROR ON LAST REQUEST
                    $requestModule = (string) $request->module;
                    $requestAction = (string) $request->action;
                    if (authenticateRequest($requestModule, $requestAction)) { // CHECK IF USER HAS API PERMISSIONS
                        // <editor-fold desc="REPLACE BINDING SYMBOLS">
                        $request = replaceSymbols($request, $symbols);
                        // </editor-fold>
                        // <editor-fold desc="EXEC REQUEST">
                        if (method_exists($requestModule, $requestAction)) {
                            if (isset($_SESSION['MasterSession']->SESSION[$requestModule])) {
                                // <editor-fold desc="SESSION ACCESS METHODS (SAM)">
                                if (isset($request->data)) {
                                    $_SESSION['MasterSession']->SESSION[$requestModule]->requestData = $request->data;
                                }
                                $_SESSION['MasterSession']->SESSION[$requestModule]->$requestAction();
                                // </editor-fold>
                            } else {
                                // <editor-fold desc="DIRECT ACCESS METHODS (DAM)">
                                $DAM = new $requestModule;
                                if (isset($request->data)) {
                                    $DAM->requestData = $request->data;
                                }
                                if (function_exists($DAM->$requestAction())) {
                                    $DAM->$requestAction();
                                }
                                // </editor-fold>
                            }
                            
                        } else {
                            // <editor-fold desc="REPORT UNDEFINED METHOD">
                            $_SESSION['MasterSession']->SESSION['EventHandler']->undefinedMethod($requestModule, $requestAction);
                            // </editor-fold>
                        }
                        // </editor-fold>
                    } else {
                        // <editor-fold desc="REPORT UNAUTHORIZED REQUEST">
                        $returnData = '<module>'.$requestModule.'</module>';
                        $returnData .= '<action>'.$requestAction.'</action>';
                        $this->reportResult(1001, "PROCESSOR",$returnData);
                        // </editor-fold>
                    }
                    // <editor-fold desc="EXTRACT BINDINGS">
                    if(isset($request->bind)) {
                        foreach ($request->bind as $binding) {
                            foreach ($binding as $node => $symbol) {
                                if (preg_match('/\<'.$node.'\>/', $_SESSION['MasterSession']->SESSION['EventHandler']->lastResult) == 1) {
                                    $dataArray = preg_split('/\<\/*'.$node.'\>/', $_SESSION['MasterSession']->SESSION['EventHandler']->lastResult);
                                    $symbols["$symbol"] = $dataArray[1];
                                }
                            }
                        }
                    }
                    // </editor-fold>                        
                }
            }
            // </editor-fold>
        } else {
            $this->reportResult(1000, "PROCESSOR");
        }
        // <editor-fold desc="CLOSE EVENT HANDLER STREAM">
        $_SESSION['MasterSession']->SESSION['EventHandler']->closeStream();
        // </editor-fold>        
    }
}
$processor = new processor();
?>
