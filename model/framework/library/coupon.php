<?php
class coupon {

    public $code;
    public $discountType;
    public $discountAmount;
    public $discountApplied;
    public $description;
    public $targetSKU;

    /**
     * COUPON CODE LOGIC
     * discountType (0 = Percentage, 1 = Flatrate, 2 = Free Shipping) <br/>
     * discountAmount( INT ) <br/>
     * discountApplied ( 0 = SubTotal, 1 = Shipping & Handeling, 2 = Total) <br/>
     */
    public function loadCoupon($couponCode) {
        unset($this->targetSKU);
        $this->targetSKU = array();
        $queryResults = runQuery('framework', 'getCoupon.sql', $couponCode);
        if (mysqli_num_rows($queryResults) == '1') {
            $queryData = mysqli_fetch_array($queryResults);
            $this->code = $queryData['code'];
            $this->discountType = $queryData['type'];
            $this->discountAmount = $queryData['amount'];
            $this->discountApplied = $queryData['applied'];
            $this->description = $queryData['description'];
            //<editor-fold desc="LOAD TARGET SKUS">
            $targetSku = explode(";", $queryData['targetsku']);
            foreach($targetSku as $sku => $target){
                array_push($this->targetSKU, $target);
            }
            //</editor-fold>
        } else {
            return false;
        }
        return true;
    }

    public function toXML() {
        // <editor-fold desc="CONVERT TYPE TO STRING">
        switch ($this->discountType) {
            case 0:
                $type = "Percentage";
                break;
            case 1:
                $type = "Flat Rate";
                break;
            case 2:
                $type = "Free Shipping";
                break;
            default :
                $type = "NULL";
                break;
        }
        // </editor-fold>
        // <editor-fold desc="CONVERT APPLIED TO STRING">
        switch ($this->discountApplied) {
            case 0:
                $applied = "Sub-Total";
                break;
            case 1:
                $applied = "Shipping & Handeling";
                break;
            case 2:
                $applied = "Total";
                break;
            default :
                $applied = "NULL";
                break;
        }
        // </editor-fold>
        // <editor-fold desc="CONVERT TARGET SKU'S TO XML">
        $targetSkuXML = "";
        foreach ($this->targetSKU as $targetSKU => $value) {
            $targetSkuXML .= "<sku>" . $value . "</sku>";
        }
// </editor-fold>
        $outputXML =
                "<coupon>" .
                "<code></code>" .
                "<description></description>" .
                "<type></type>" .
                "<applied></applied>" .
                "<amount></amount>" .
                "<targetskus>" .
                $targetSkuXML .
                "</targetskus>" .
                "</coupon>";
        return $outputXML;
    }

}
?>
