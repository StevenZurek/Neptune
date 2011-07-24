<?php
require_once('framework/library/product.php');
require_once('framework/library/coupon.php');

class lineItem implements dataObject {

    public $categoryId;
    public $name;
    public $description;
    public $creditValue;
    public $debitValue;
    public $qty;
    public $invoiceId;
    public $lineId;

    private $productId;
    private $couponCode;

    private $saveState;

    public function __construct() {
        $this->categoryId = '';
        $this->name = '';
        $this->description = '';
        $this->creditValue = 0;
        $this->debitValue = 0;
        $this->qty = 0;

        $this->productId = '';
        $this->couponCode = '';
        $this->lineId = 0;
        $this->saveState = 'NEW';
    }

    public function loadProduct($productId) {

    }

    public function loadCoupon($couponCode) {

    }

    public function loadLine($lineId) {
        $queryResults = runQuery('framework','lineItem/select/selectLineItem.sql', $lineId) or die(mysqli_error($mysqlConnection));
        $queryData = mysqli_fetch_assoc($queryResults);
        $this->categoryId = $queryData['categoryId'];
        $this->name = $queryData['name'];
        $this->description = $queryData['description'];
        $this->creditValue = $queryData['creditValue'];
        $this->debitValue = $queryData['debitValue'];
        $this->qty = $queryData['qty'];
        $this->invoiceId = $queryData['invoiceId'];

        $this->productId = $queryData['productId'];
        $this->couponCode = $queryData['couponCode'];
        $this->lineId = $queryData['lineId'];
        $this->saveState = 'SAVED';
        return true;
    }

    public function delete() {
        global $mysqlConnection;
        runQuery('framework','lineitem/delete/deleteLineItem.sql',$this->lineId) or die(mysqli_error($mysqlConnection));
    }

    public function save() {
        global $mysqlConnection;
        if ($this->saveState == 'NEW') {
            runQuery('framework', 'lineItem/insert/insertLineItem.sql',
                            $this->invoiceId,
                            $this->productId,
                            $this->couponCode,
                            $this->categoryId,
                            $this->name,
                            $this->description,
                            $this->creditValue,
                            $this->debitValue,
                            $this->qty) or die(__LINE__ . __FILE__ . ' ' . mysqli_error($mysqlConnection));
            $this->lineId = mysqli_insert_id($mysqlConnection);
        } else {
            runQuery('framework', 'lineItem/update/updateLineItem.sql',
                            $this->lineId,
                            $this->invoiceId,
                            $this->productId,
                            $this->couponCode,
                            $this->categoryId,
                            $this->name,
                            $this->description,
                            $this->creditValue,
                            $this->debitValue,
                            $this->qty) or die(__LINE__ . __FILE__ . ' ' . mysqli_error($mysqlConnection));
        }
        $this->saveState = 'SAVED';
    }

    public function asXML() {
        $returnData = '<lineItem>';
        $returnData .= '<lineId>' . $this->lineId . '</lineId>';
        $returnData .= '<productId>' . $this->productId . '</productId>';
        $returnData .= '<couponCode>' . $this->couponCode . '</couponCode>';
        $returnData .= '<categoryId>' . $this->catagoryId . '</categoryId>';
        $returnData .= '<name>' . $this->name . '</name>';
        $returnData .= '<description>' . $this->description . '</description>';
        $returnData .= '<creditValue>' . $this->creditValue . '</creditValue>';
        $returnData .= '<debitValue>' . $this->debitValue . '</debitValue>';
        $returnData .= '<qty>'. $this->qty . '</qty>';
        $returnData .= '</lineItem>';
        return $returnData;
    }
}
?>
