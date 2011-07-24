<?php
class securityMonitor {
    function __construct() {
        // $this->session_ipCheck();
    }

    public function session_ipCheck() {
        if(isset($_SESSION)) {
            if(!isset($_SESSION['clientIP'])) {
                $_SESSION['clientIP'] = $_SERVER['REMOTE_ADDR'];
            }
            if($_SESSION['clientIP'] != $_SERVER['REMOTE_ADDR']) {
                session_unset();
                session_destroy();
                die("<center><h1>Failed session integrity check </h1></center>
                     <hr/>
                     All IP Addresses have been logged and the administrator has been notified. ");
            }
        }
    }
    public function scrubArray(&$array) {
        foreach($array as $key => $value) {
            $array[$key] = mysqli_real_escape_string(stripslashes($value));
        }
    }
}
class validator {
    protected $characters = "abcdefghijklmnopqrstuvwxyz ";
    protected $symbols = "!@#$%^&*()_+-= {}|[]\;':,./<>?`~\"";
    protected $numbers = "1234567890";

    public function cc_mod10_check($input) {

        $work = str_split(trim($input),1);
        $secondDigit = false;
        for($i = count($work)-1; $i >= 0; $i--) {
            if($secondDigit) {
                $sum .= ($work[$i] * 2);
                $secondDigit = false;
            }
            else {
                $sum .= $work[$i];
                $secondDigit = true;
            }
        }
        $sum = str_split($sum, 1);
        $total = 0;
        foreach ($sum as $digit) {
            $total += $digit;
        }


        if ($total % 10 == 0) {
            return true;
        }else {
            return false;
        }
    }
    public function validInt($input, $min = false, $max = false) // Returns if it is a number and within range
    {
        $result = true;
        if($this->hasNot($input, $this->characters) !== true) {
            $result = 2;
        }
        if($this->hasNot($input, $this->symbols) !== true) {
            $result = 3;
        }
        if($min !== false) {
            if($input<$min) {
                $result = 4;
            }
        }

        if($max !== false) {
            if($input>$max) {
                $result = 5;
            }
        }

        if(empty($input)) {
            $result = 6;
        }
        return $result;
    }

    public function onlyCharacters($input) {
        $result = true;
        if($this->hasNot($input, $this->numbers) !== true) {
            $result = 2;
        }
        if($this->hasNot($input, $this->symbols) !== true) {
            $result = 3;
        }
        if(empty($input)) {
            $result = 4;
        }
        return $result;
    }

    public function validAddress($address) {
        $result = true;
        if(!empty($address)) {
            $splitAddress = explode(" ",$address);
            if($this->array_count_keys($splitAddress) <= 1) {
                $result = 2;
            }
        }else {
            $result=3;
        }
        return $result;
    }

    public function validEMail($email) {
        $result = true;
        if(!empty($email)) {
            if(strpos($email,"@") !== false) {
                if(strpos($email,".",strpos($email,"@")) !== false) {
                    $domain = array_pop(explode('@',$email));
                    if(!checkdnsrr($domain)) {
                        $result=4;
                    }
                }else {
                    $result=3;
                }
            }else {
                $result=2;
            }
        }else {
            $result=5;
        }
        return $result;
    }

    public function stripSymbols($input, $keepQuotes = false, $terminateQuotes = false) {
        $result = $input;
        for($pos = 0; $pos < strlen($this->symbols); $pos+=1) {
            $skip = false;
            if($keepQuotes === true and substr($this->symbols,$pos,1)=="'") {
                $skip = true;
            }
            if($keepQuotes === true and substr($this->symbols,$pos,1)=='"') {
                $skip = true;
            }
            if($skip == true and $terminateQuotes === true) {
                $result = str_replace(substr($this->symbols,$pos,1), '\\' . substr($this->symbols,$pos,1),$result);
            }
            if($skip !== true) {
                $result = str_replace(substr($this->symbols,$pos,1), "",$result);
            }
        }
        return $result;
    }


    public function hasNot($input, $invalidCharacters,  $offset = 0)  // RETURNS TRUE IF CHARACTERS ARE NOT FOUND
    {
        $result = true;
        $comparePos = 0;
        while($comparePos < strlen($invalidCharacters)) {
            if(strpos($input, substr($invalidCharacters,$comparePos,1),$offset) !== false) {
                $result = $comparePos;
            }
            $comparePos += 1;
        }
        return $result;
    }

    private function array_count_keys($array) {
        $count = 0;
        foreach($array as $key) {
            $count += 1;
        }
        return $count;
    }
}

?>
