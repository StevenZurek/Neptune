<?php
/**
 * @author Steven J. Zurek
 * @version 2.0.0rc1
 * @copyright 2011
 * @package Modules
 */

/**
 * The affiliatemanager class extends the Neptune Core Module class allowing any of the public functions to be accessed via HTTP Requests.
 */
class affiliatemanager extends Module {
/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>name</b> | Required(true) | Default Value(Array)</li>
 * <li><b>address</b> | Required(false) | Default Value(Array)</li>
 * <li><b>image</b> | Required(false) | Default Value(Array)</li>
 * <li><b>url</b> | Required(false) | Default Value(Array)</li>
 * <li><b>description</b> | Required(false) | Default Value(Array)</li>
 * <li><b>phone</b> | Required(false) | Default Value(Array)</li>
 * <li><b>category</b> | Required(false) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 * <ul>
 * <li><b>affiliateId</b> | Required(false) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Example XML Request:</b>
 * {@example ./affiliatemanager/affiliatemanager.examples.php 4 13}
 *
 * <b>Example XML Responses:</b>
 * {@example ./affiliatemanager/affiliatemanager.responses.xml 3 21}
 */ 
    public function CREATE_AFFILIATE() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "1000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'name' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'true'
                    ),
                    'address' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'image' =>
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
                    'description' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'phone' =>
                    array(
                        'value' => '',
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'category' =>
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
            $this->reportResult(1002, $process, $vars);
        }
        // </editor-fold>
        if ($this->resultID == $STATUS_OK) {
            runQuery('affiliatemanager','insert/createAffiliate.sql',
                    $vars['name'],
                    $vars['address'],
                    $vars['image'],
                    $vars['url'],
                    $vars['description'],
                    $vars['phone'],
                    $vars['category']) or $this->reportResult(1001, $process);
            if ($this->resultID == $STATUS_OK) {
                // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
                $returnData =
                        array(
                            'affiliateId' =>
                            array(
                                'value' => '' . mysqli_insert_id($mysqlConnection),
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                );
                //</editor-fold>
                $this->reportResult($STATUS_OK, __FUNCTION__, arrayToXml(collapseValidationArray($returnData)));
            }
        }
    }

/**
 * {PURPOSE}
 *
 * <b>Inputs:</b>
 * <ul>
 * <li><b>affiliateId</b> | Required(true) | Default Value(Array)</li>
 * <li><b>name</b> | Required(false) | Default Value(Array)</li>
 * <li><b>address</b> | Required(false) | Default Value(Array)</li>
 * <li><b>image</b> | Required(false) | Default Value(Array)</li>
 * <li><b>url</b> | Required(false) | Default Value(Array)</li>
 * <li><b>description</b> | Required(false) | Default Value(Array)</li>
 * <li><b>phone</b> | Required(false) | Default Value(Array)</li>
 * <li><b>category</b> | Required(false) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./affiliatemanager/affiliatemanager.examples.php 21 14}
 *
 * <b>Example XML Responses:</b>
 * {@example ./affiliatemanager/affiliatemanager.responses.xml 24 21}
 */ 
    public function UPDATE_AFFILIATE() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "2000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="GET CURRENT DATA">
        $vars = xmlToArray($this->requestData->asXML());
        $queryResults = runQuery('affiliatemanager', 'select/selectAffiliate.sql',
                        $vars['affiliateId']) or $this->reportResult(2001, __FUNCTION__);
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $current = mysqli_fetch_assoc($queryResults);
        $defaultVars =
                array(
                    'affiliateId' =>
                    array(
                        'value' => '',
                        'pattern' => '/\d+/',
                        'req' => 'true'
                    ),
                    'name' =>
                    array(
                        'value' => '' . $current['name'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'address' =>
                    array(
                        'value' => '' . $current['address'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'image' =>
                    array(
                        'value' => '' . $current['image'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'url' =>
                    array(
                        'value' => '' . $current['url'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'description' =>
                    array(
                        'value' => '' . $current['description'],
                        'pattern' => '/.+/',
                        'req' => 'false'
                    ),
                    'phone' =>
                    array(
                        'value' => '' . $current['phone'],
                        'pattern' => '/.+/',
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
            runQuery('affiliatemanager','update/updateAffiliate.sql',
                    $vars['affiliateId'],
                    $vars['name'],
                    $vars['address'],
                    $vars['image'],
                    $vars['url'],
                    $vars['description'],
                    $vars['phone'],
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
 * <li><b>affiliateId</b> | Required(true) | Default Value(Array)</li>
 * </ul>
 *
 * <b>Return Data:</b>
 *
 * <b>Example XML Request:</b>
 * {@example ./affiliatemanager/affiliatemanager.examples.php 39 7}
 *
 * <b>Example XML Responses:</b>
 * {@example ./affiliatemanager/affiliatemanager.responses.xml 45 21}
 */ 
    public function DELETE_AFFILIATE() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "3000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        // <editor-fold desc="SET DEFAULT VARIABLES">
        $defaultVars =
                array(
                    'affiliateId' =>
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
            runQuery('affiliatemanager','delete/deleteAffiliate.sql', $vars['affiliateId']) or $this->reportResult(3001, $process);
            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process);
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
 * <li><b>affiliate</b> | Parent </li>
 * <li><b>affiliateId</b> | Required(false) | Default Value(Array) | Parent Node(affiliate)</li>
 * <li><b>name</b> | Required(false) | Default Value(Array) | Parent Node(affiliate)</li>
 * <li><b>address</b> | Required(false) | Default Value(Array) | Parent Node(affiliate)</li>
 * <li><b>image</b> | Required(false) | Default Value(Array) | Parent Node(affiliate)</li>
 * <li><b>url</b> | Required(false) | Default Value(Array) | Parent Node(affiliate)</li>
 * <li><b>description</b> | Required(false) | Default Value(Array) | Parent Node(affiliate)</li>
 * <li><b>phone</b> | Required(false) | Default Value(Array) | Parent Node(affiliate)</li>
 * <li><b>category</b> | Required(false) | Default Value(Array) | Parent Node(affiliate)</li>
 * </ul>
 *
 * <b>Example XML Request:</b>
 * {@example ./affiliatemanager/affiliatemanager.examples.php 50 4}
 *
 * <b>Example XML Responses:</b>
 * {@example ./affiliatemanager/affiliatemanager.responses.xml 66 14}
 */ 
    public function GET_ALL_AFFILIATES() {
        // <editor-fold desc="SET METHOD DATA">
        global $mysqlConnection;
        $process = __FUNCTION__;
        $STATUS_OK = "4000";
        $this->resultID = $STATUS_OK;
        // </editor-fold>
        $queryResults = runQuery('affiliatemanager', 'select/selectAllAffiliates.sql') or $this->reportResult(4001, __FUNCTION__);
        
        if ($this->resultID == $STATUS_OK) {
            $returnArray['affiliates'] = array();
            while ($queryData = mysqli_fetch_array($queryResults)) {
                // <editor-fold desc="SET RETURN DATA FORMAT AND VALUES">
                $returnData =
                        array(
                            'affiliate' =>
                            array(
                                'affiliateId' =>
                                array(
                                    'value' => '' . $queryData['affiliateId'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'name' =>
                                array(
                                    'value' => '' . $queryData['name'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'address' =>
                                array(
                                    'value' => '' . $queryData['address'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'image' =>
                                array(
                                    'value' => '' . $queryData['image'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'url' =>
                                array(
                                    'value' => '' . $queryData['url'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'description' =>
                                array(
                                    'value' => '' . $queryData['description'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
                                ),
                                'phone' =>
                                array(
                                    'value' => '' . $queryData['phone'],
                                    'pattern' => '/.+/',
                                    'req' => 'false'
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
                array_push($returnArray['affiliates'], $returnData);
            }

            if ($this->resultID == $STATUS_OK) {
                $this->reportResult($STATUS_OK, $process, arrayToXml(collapseValidationArray($returnArray)));
            }
        }
    }
}

?>
