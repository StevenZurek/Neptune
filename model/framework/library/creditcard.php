<?php

class creditcard {
    public $cardType;
    public $cardNumber;
    public $expirationMonth;
    public $expirationYear;
    public $ccv;

    function  __construct($paymentXML) {
        $paymentXML = simplexml_load_string($paymentXML);
        $this->cardType = (string)$paymentXML->cardType;
        $this->cardNumber = (string)$paymentXML->cardNumber;
        $this->expirationMonth = (string)$paymentXML->expirationMonth;
        $this->expirationYear = (string)$paymentXML->expirationYear;
        $this->ccv = (string)$paymentXML->ccv;
    }
    
}

?>
