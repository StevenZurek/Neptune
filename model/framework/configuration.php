<?php

class dbConfiguration {
    public $value;
    function __construct($module) {
        $value = array();
        $results = runQuery($module, 'getConfiguration.sql');
        while ($row = mysqli_fetch_array($results)) {
            $this->value[$row['attribute']] = $row['value'];
        }
    }
}

?>
