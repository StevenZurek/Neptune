<?php

class product {

    //<editor-fold desc="BASE INFORMATION BLOCK">
    public $sku; //
    public $name; //
    public $description; //
    public $attributes; //
    public $images;
    //</editor-fold>
    //<editor-fold desc="RETAIL INFORMATION BLOCK">
    public $retailPPU;
    //</editor-fold>
    // <editor-fold desc="WHOLESALE INFORMATION BLOCK">
    public $wholesalePPU;
    // </editor-fold>
    // <editor-fold desc="SHIPPING">
    public $shipping;
    public $internationalShipping;
    // </editor-fold>
    //<editor-fold desc="INVOICE VARIABLES">
    public $ppu;
    public $discount;
    public $subtotal;
    public $total;
    //</editor-fold>

    public $costModifer;
    public $salesType;
    public $qty;

    private $saveState;
    function __construct() {
        $this->costModifer = array();
        $this->attributes = array();
        $this->images = array();
        $this->saveState = 'NEW';
    }

    public function loadSku($sku, $qty, $salesType = true) {
        $returnValue = true;
        $this->salesType = $salesType;
        $this->qty = $qty;
        $queryResults = runQuery("framework", "getProduct.sql", $sku);
        if (mysqli_num_rows($queryResults) == '1') {
            $queryData = mysqli_fetch_array($queryResults);
            //<editor-fold desc="LOAD BASE INFO BLOCK">
            $this->sku = $queryData['sku'];
            $this->name = $queryData['name'];
            $this->description = $queryData['description'];
            //</editor-fold>
            // <editor-fold desc="LOAD ATTRIBUTES">
            if (!empty($queryData['attributes'])) {
                $attributesSetArray = explode(";", $queryData['attributes']);
                foreach ($attributesSetArray as $attributeSet => $attribute) {
                    $attributePair = explode(":", $attribute);
                    $this->attributes[$attributePair[0]] = $attributePair[1];
                }
            }
            // </editor-fold>
            // <editor-fold desc="LOAD IMAGES">
            $imageURIArray = explode(";", $queryData['images']);
            foreach ($imageURIArray as $image => $imageURI) {
                array_push($this->images, $imageURI);
            }
            // </editor-fold>            
            //<editor-fold desc="LOAD RETAIL INFORMATION BLOCK">
            $this->retailPPU = $queryData['ppu'];
            //</editor-fold>
            //<editor-fold desc="LOAD WHOLESALE INFORMATION BLOCK">
            $this->wholesalePPU = $queryData['wholesale_ppu'];
            //</editor-fold>
            // <editor-fold desc="LOAD SHIPPING">
            $this->shipping = $queryData['shipping'];
            $this->internationalShipping = $queryData['internationalShipping'];
            // </editor-fold>
            $this->saveState = 'SAVED';
            return true;
        } else {
            return false;
        }
    }

    public function saveSku(){
        if($this->saveState == 'NEW'){
            // INSERT
            runQuery('framework','/product/insert/InsertProduct.sql',
                    $this->sku,
                    $this->name,
                    $this->description,
                    $this->ppu);
        } else {
            // UPDATE
        }
    }

    public function setCostModifier($coupon) {
        foreach ($coupon->targetSKU as $targetSKU => $sku) {
            if ($this->sku == $sku) {
                $this->costModifer['discountType'] = $coupon->discountType;
                $this->costModifer['discountAmount'] = $coupon->discountAmount;
                $this->costModifer['discountApplied'] = $coupon->discountApplied;
            }
        }
    }

    public function removeCostModifier() {
        $this->discount = 0;
        unset($this->costModifer);
        $this->costModifer = false;
    }

    /**
     * COUPON CODE LOGIC
     * discountType (0 = Percentage, 1 = Flatrate) <br/>
     * discountAmount( INT ) <br/>
     * discountApplied ( 0 = SubTotal, 1 = Shipping & Handeling, 2 = Total) <br/>
     */
    public function calculateInvoice() {
        // <editor-fold desc="LOAD REAL COST VALUES">
        if ($this->salesType) { // LOAD RETAIL VALUES
            $this->ppu = $this->retailPPU;
        } else { // LOAD WHOLESALE VALUES
            $this->ppu = $this->wholesalePPU;
        }

        // </editor-fold>
        $this->subtotal = ($this->ppu * $this->qty);
        // <editor-fold desc="CALCULATE DISCOUNT">
        if ($this->costModifer !==  false) {
            switch ($this->costModifer['discountType']) {
                case 0: // Percentage
                    switch ($this->costModifer['discountApplied']) {
                        case 0:
                            $this->discount = $this->subtotal * $this->costModifer['discountAmount'];
                            break;
                        case 1:
                            $this->discount = $this->shipping * $this->costModifer['discountAmount'];
                            break;
                        case 2:
                            $this->discount = $this->total * $this->costModifer['discountAmount'];
                            break;
                    }                    
                    break;
                case 1: // Flate Rate
                    $this->discount = $this->costModifer['discountAmount'];
                    break;
                default:
                    break;
            }
        }
        //</editor-fold>
        $this->total = $this->subtotal - $this->discount + $this->shipping;
    }

    public function toXML() {
        $outputXML =
                "<product>" .
                "<name>" . $this->name . "</name>" .
                "<description>" . $this->description . "</description>" .
                "<cost>" .
                "<price>" . $this->ppu . "</price>" .
                //"<currency>".$this->."</currency>" .
                "<shipping>" . $this->shipping . "</shipping>" .
                "<international_shipping>" . $this->internationalShipping . "</international_shipping>" .
                "</cost>" .
                "<base_attributes>" .
                "<height>" . $this->height . "</height>" .
                "<width>" . $this->width . "</width>" .
                "<length>" . $this->length . "</length>" .
                "<weight>" . $this->weight . "</weight>" .
                "<weight_uom>" . $this->weightEOM . "</weight_uom>" .
                "<image>" . $this->image . "</image>" .
                "</base_attributes>" .
                //"<custom_attributes>" .
                //"</custom_attributes>" .
                "</product>";
        return $outputXML;
    }

}

?>
