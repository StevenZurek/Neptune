<?php

class admin extends Module {

    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }

    public function GET_MODULES() {
        $returnData = "";
        $queryResults = runQuery('framework', 'getModules.sql');
        while ($module = mysqli_fetch_array($queryResults)) {
            $DAM = new $module['module'];
            $info = $DAM->getInfo();
            $returnData .= "<module>";
            $returnData .= "<name>" . $info['name'] . "</name>";
            $returnData .= "<title>" . $info['title'] . "</title>";
            $returnData .= "<version>" . $info['version'] . "</version>";
            $returnData .= "<admin_enabled>";
            if ($info['adminEnabled']) {
                $returnData .= "true";
            } else {
                $returnData .= "false";
            }
            $returnData .= "</admin_enabled>";
            $returnData .= "</module>";
            unset($info);
        }
        $this->reportResult(1000, __FUNCTION__, $returnData);
    }
}

?>
