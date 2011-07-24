<?php
class paypalPayer{
    public $token;
    public $payerId;
    public $stage;
    
    function  __construct($paymentXML) {
        $paymentXML = simplexml_load_string($paymentXML);
        $this->stage = (string)$paymentXML->stage;
        $this->token = (string)$paymentXML->token;
        $this->payerId = (string)$paymentXML->payerId;
    }
}
?>
