<?php
require_once('framework/library/lineitem.php');

class invoice implements dataObject {

    public $description;
    public $totals;
    public $gateway;
    public $lineItems;
    
    private $transactionId;
    public $invoiceId;
    private $saveState;
    private $status;

    /*
     * Invoice Status Enum
     *  Open
     *  Pending
     *  Returned
     *  Finalized
     *  Closed
     *
     */

    function __construct() {
        $this->totals = array(); // DEFINE TOTALS AS AN ARRAY, AND SET DEFAULT VALUES

        $this->description = $_SERVER['SERVER_NAME']; // SET DEFAULT INVOICE DESCRIPTION TO THE DOMAIN NAME
        $this->lineItems = array();
        $this->invoiceId = 'NEW INVOICE';
        $this->gateway = '';
        $this->saveState = 'NEW';  // SET Invoice Save State
        $this->transactionId = '';
        $this->status = 'OPEN';

        $this->calculateTotals();
    }

    public function save() {
        global $mysqlConnection;
        $this->calculateTotals();
        if ($this->saveState == 'NEW') {
            // INSERT
            runQuery('framework', '/invoice/insert/InsertInvoice.sql',
                    $_SESSION['MasterSession']->SESSION['usermanager']->user->userId,
                    $this->transactionId,
                    $this->gateway,
                    $this->totals['discount'],
                    $this->totals['subtotal'],
                    $this->totals['shipping'],
                    $this->totals['total'],
                    $_SERVER['SERVER_NAME'],
                    $_SERVER['REMOTE_ADDR'],
                    'status') or die(mysqli_error($mysqlConnection));
            $this->invoiceId = mysqli_insert_id($mysqlConnection); // SET THE invoiceId TO THE VALUE OF THE AUTO-INCREMENT FIELD IN THE DATABASE
        } else {
            // UPDATE
            runQuery('framework', '/invoice/update/updateInvoice.sql',
                    $this->invoiceId,
                    $this->transactionId,
                    $this->gateway,
                    $this->totals['discount'],
                    $this->totals['subtotal'],
                    $this->totals['shipping'],
                    $this->totals['total'],
                    $_SERVER['SERVER_NAME'],
                    $_SERVER['REMOTE_ADDR'],
                    'test') or die(mysqli_error($mysqlConnection));
        }
        foreach ($this->lineItems as $lineItem) {
            $lineItem->invoiceId = $this->invoiceId;
            $lineItem->save();
        }

        $this->saveState = 'SAVED';
        return $this->invoiceId;
    }

    public function delete() {
        runQuery('framework','/invoice/delete/deleteInvoice.sql', $this->invoiceId);
        unset($this);
    }

    public function load($invoiceId) {
        global $mysqlConnection;
        $queryResults = runQuery('framework', 'invoice/select/selectInvoice.sql', $invoiceId) or die(__LINE__ . __FILE__ . mysqli_error($mysqlConnection));
        $queryData = mysqli_fetch_assoc($queryResults);
        if (!empty($queryData['invoiceId'])) {
            $this->description = $queryData['description']; // SET DEFAULT INVOICE DESCRIPTION TO THE DOMAIN NAME
            $this->invoiceId = $queryData['invoiceId'];
            $this->gateway = $queryData['gateway'];
            $this->saveState = 'SAVED';
            $this->transactionId = $queryData['transactionId'];
            $this->status = $queryData['status'];

            $lineIds = explode(',', $queryData['lineIds']);
            foreach ($lineIds as $lineId) {
                if (!empty($lineId)) {
                    $newItem = new lineItem();
                    $newItem->loadLine($lineId);
                    array_push($this->lineItems, $newItem);
                }
            }
            $this->calculateTotals();
            return true;
        } else {
            return false;
        }
    }

    public function addLineItem($newItem) {
        $newItem->invoiceId = $this->invoiceId;
        array_push($this->lineItems, $newItem);
        $this->save();
        return $newItem->lineId;
     }

    public function updateLineItem($item, $lineId){
        foreach($this->lineItems as $key => $lineItem){
            if($lineItem->lineId == $lineId){
                $this->lineItems[$key] = $item;
            }
        }
        $this->save();
    }

    public function deleteLineItem($lineId){
        $deleted = false;
        foreach($this->lineItems as $key => $lineItem){
            if($lineItem->lineId == $lineId){
                $lineItem->delete();
                $deleted = true;
                unset($this->lineItems[$key]);
            }
        }
        if ($deleted) {
            $tempArray = array();
            foreach ($this->lineItems as $lineItem) {
                array_push($tempArray, $lineItem);
            }
            $this->lineItems = $tempArray;
            unset($tempArray);
        }
        $this->save();
        return $deleted;        
    }

    public function asXML() {
        $this->calculateTotals();
        $returnData = "<invoice>";
        $returnData .= '<invoiceId>'.$this->invoiceId.'</invoiceId>';
        foreach ($this->lineItems as $lineItem) {
            $returnData .= $lineItem->asXML();
        }
        // <editor-fold desc="OUTPUT TOTALS">
        $returnData .= "<totals>";
        $returnData .= arrayToXml($this->totals);
        $returnData .= "</totals>";
        // </editor-fold>
        $returnData .= "</invoice>";
        return $returnData;
    }

    public function  __get($name) {
        return $this->$name;
    }

    // PRIVATE FUNCTIONS

    private function calculateTotals() {
        $this->totals['totalDebit'] = 0;
        $this->totals['totalCredit'] = 0;

        foreach($this->lineItems as $item){
            $this->totals['totalDebit'] += $item->debitValue;
            $this->totals['totalCredit'] += $item->creditValue;
        }
        $this->totals['balance'] = $this->totals['totalCredit'] - $this->totals['totalDebit'];
    }

}
?>