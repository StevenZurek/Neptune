<?php

class user {

    public $userId;
    public $userInformation;

    function __construct() {
        $this->userInformation = array();
        $this->userId = 0;
        $this->status = 0;
        $this->userLevel = 0;
        $this->username = "";
    }

    public function loadUser($userId) {

        $queryResults = runQuery('usermanager', 'loadUser.sql', $userId);
        if (mysqli_num_rows($queryResults) == 1) {
            $this->userId = $userId;
            $queryData = mysqli_fetch_array($queryResults);
            // <editor-fold desc="SET DEFAULT VARIABLES">
            $this->userInformation =
                    array(
                        // <editor-fold desc="USER PROFILE">
                        'userProfile' =>
                        array(
                            'firstName' =>
                            array(
                                'value' => '' . $queryData['profile_firstName'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'lastName' =>
                            array(
                                'value' => '' . $queryData['profile_lastName'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'address1' =>
                            array(
                                'value' => '' . $queryData['profile_address1'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'address2' =>
                            array(
                                'value' => '' . $queryData['profile_address2'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'city' =>
                            array(
                                'value' => '' . $queryData['profile_city'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'state' =>
                            array(
                                'value' => '' . $queryData['profile_state'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'zip' =>
                            array(
                                'value' => '' . $queryData['profile_zip'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'country' =>
                            array(
                                'value' => '' . $queryData['profile_country'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'other' =>
                            array(
                                'value' => '' . $queryData['profile_other'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'phone' =>
                            array(
                                'value' => '' . $queryData['profile_phone'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'email' =>
                            array(
                                'value' => '' . $queryData['profile_email'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        ),
                        // </editor-fold>
                        // <editor-fold desc="SHIPPING PROFILE">
                        'shippingProfile' =>
                        array(
                            'firstName' =>
                            array(
                                'value' => '' . $queryData['shipping_firstName'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'lastName' =>
                            array(
                                'value' => '' . $queryData['shipping_lastName'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'address1' =>
                            array(
                                'value' => '' . $queryData['shipping_address1'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'address2' =>
                            array(
                                'value' => '' . $queryData['shipping_address2'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'city' =>
                            array(
                                'value' => '' . $queryData['shipping_city'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'state' =>
                            array(
                                'value' => '' . $queryData['shipping_state'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'zip' =>
                            array(
                                'value' => '' . $queryData['shipping_zip'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'country' =>
                            array(
                                'value' => '' . $queryData['shipping_country'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'other' =>
                            array(
                                'value' => '' . $queryData['shipping_other'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'phone' =>
                            array(
                                'value' => '' . $queryData['shipping_phone'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'email' =>
                            array(
                                'value' => '' . $queryData['shipping_email'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        ),
                        // </editor-fold>
                        // <editor-fold desc="BILLING PROFILE">
                        'billingProfile' =>
                        array(
                            'firstName' =>
                            array(
                                'value' => '' . $queryData['billing_firstName'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'lastName' =>
                            array(
                                'value' => '' . $queryData['billing_lastName'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'address1' =>
                            array(
                                'value' => '' . $queryData['billing_address1'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'address2' =>
                            array(
                                'value' => '' . $queryData['billing_address2'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'city' =>
                            array(
                                'value' => '' . $queryData['billing_city'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'state' =>
                            array(
                                'value' => '' . $queryData['billing_state'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'zip' =>
                            array(
                                'value' => '' . $queryData['billing_zip'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'country' =>
                            array(
                                'value' => '' . $queryData['billing_country'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'other' =>
                            array(
                                'value' => '' . $queryData['billing_other'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'phone' =>
                            array(
                                'value' => '' . $queryData['billing_phone'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'email' =>
                            array(
                                'value' => '' . $queryData['billing_email'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        ),
                        // </editor-fold>
                        // <editor-fold desc="ACCOUNT INFORMATION">
                        'accountInformation' =>
                        array(
                            'username' =>
                            array(
                                'value' => '' . $queryData['username'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'validated' =>
                            array(
                                'value' => '' . (bool)$queryData['validated'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'validationCode' =>
                            array(
                                'value' => '' . $queryData['validationCode'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            ),
                            'group' =>
                            array(
                                'value' => '' . $queryData['group'],
                                'pattern' => '/.+/',
                                'req' => 'false'
                            )
                        )
                        // </editor-fold>
                    );
            // </editor-fold>
            return true;
        } else {
            return false;
        }
    }
    
    public function asXML(){
        $infoArray = collapseValidationArray($this->userInformation);
        $returnData = '<user>';
        $returnData .= '<userId>'.$this->userId.'</userId>';
        $returnData .= "<profile>";
        $returnData .= arrayToXml($infoArray['userProfile']);
        $returnData .= '</profile>';
        $returnData .= '<billingProfile>';
        $returnData .= arrayToXml($infoArray['billingProfile']);
        $returnData .= '</billingProfile>';
        $returnData .= '<shippingProfile>';
        $returnData .= arrayToXml($infoArray['shippingProfile']);
        $returnData .= '</shippingProfile>';
        $returnData .= '<account>';
        $returnData .= arrayToXml($infoArray['accountInformation']);
        $returnData .= '</account>';
        $returnData .= '</user>';
        return $returnData;
    }
    
}
?>