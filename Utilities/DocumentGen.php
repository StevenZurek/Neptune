<?php
if (preg_match('/localhost/', $_SERVER['SERVER_NAME']) == 1) {
?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Neptune Path <input type="text" name="neptunePath" value="C:/wamp/www/Azimuth/svn/marvslotmgr/branches/2.0.0/trunk/_modules/com/Neptune/model/"/><br/>
        Module Name <input type="text" name="moduleName"/><br/>
        Delete Old Doc Blocks <input type="checkbox" name="overwrite"/>
        <input type="submit"/>
    </form>
    <hr/>
<?php
    error_reporting(E_ALL ^ E_NOTICE);
    if (isset($_POST['neptunePath']) and isset($_POST['moduleName'])) {
        $neptunePath = $_POST['neptunePath'] .'/model/';
        $moduleName = $_POST['moduleName'];
        $docBlocks = array();
        $codeMap = array();
        $fileData = array();
        $inputs = array();
        $outputs = array();
        $currentFunction = '';
        if (is_dir($neptunePath . $moduleName)) {
// <editor-fold desc="RESPONSE PARSER">
            if (file_exists($neptunePath . $moduleName . '/' . $moduleName . '.responses.xml')) {
                $methods = array();
                $state = 1;
                $line = 0;
                $lineHolder = 0;
                $lastParent = '';
                $currentParent = '';
                $IOHandler = fopen($neptunePath . $moduleName . '/' . $moduleName . '.responses.xml', 'r+');
                if (filesize($neptunePath . $moduleName . '/' . $moduleName . '.responses.xml') > 0) {
                    echo "<b>Reading Responses File ... </b><br/>" . chr(10);
                    while (($buffer = fgets($IOHandler)) !== false) {
                        $line++;
                        if (preg_match('/\<response\>/', $buffer) == 1) {
                            //echo "Opening Response Node On Line " . $line . "... <br/>";
                            $lineHolder = $line;
                        }
                        if (preg_match('/\<parent\>.+\<\/parent\>/', $buffer) == 1) {
                            $parent = preg_split('/\<\/*parent\>/', $buffer);
                            $currentParent = $parent[1];
                            if ($lastParent != $currentParent AND isset($methods[$currentParent])) {
                                die('Error: parent (' . $currentParent . ') not properly grouped');
                            }
                            if (!isset($methods[$currentParent])) {
                                $methods[$currentParent] = array();
                                $methods[$currentParent]['occurence'] = 1;
                                $methods[$currentParent]['startLine'] = $lineHolder;
                                $methods[$currentParent]['length'] = 0;
                            } else {
                                $methods[$currentParent]['occurence']++;
                            }
                            //echo $methods[$currentParent] . ' Occurence of ' . $currentParent . ' on line ' . $line . ' with a line holder of ' . $lineHolder . '<br/>';
                        }
                        if (preg_match('/\<\/response\>/', $buffer) == 1) {
                            //echo "Closing Response Node On Line " . $line . " Response lenght is " . (($line - $lineHolder) + 1) . "... <br/>";
                            $methods[$currentParent]['length'] += ( ($line - $lineHolder) + 1);
                            $lastParent = $currentParent;
                        }
                    }

                    if (!feof($IOHandler)) {
                        echo "Error: unexpected fgets() fail\n";
                    }
                }
                fclose($IOHandler);
            } else {
                echo "Response File Does Not Exist";
            }
// </editor-fold>
// <editor-fold desc="EXAMPLE PARSER">
            if (file_exists($neptunePath . $moduleName . '/' . $moduleName . '.examples.php')) {
                $examples = array();
                $state = 1;
                $line = 0;
                $lineHolder = 0;
                $currentAction = '';
                $IOHandler = fopen($neptunePath . $moduleName . '/' . $moduleName . '.examples.php', 'r+');
                if (filesize($neptunePath . $moduleName . '/' . $moduleName . '.examples.php') > 0) {
                    echo "<b>Reading Examples File ... </b><br/>" . chr(10);
                    while (($buffer = fgets($IOHandler)) !== false) {
                        $line++;
                        if (preg_match('/\<request\>/', $buffer) == 1) {
                            //echo "Opening Response Node On Line " . $line . "... <br/>";
                            $lineHolder = $line;
                        }
                        if (preg_match('/\<action>.+\<\/action\>/', $buffer) == 1) {
                            $action = preg_split('/\<\/*action\>/', $buffer);
                            $currentAction = $action[1];
                            if (!isset($examples[$currentAction])) {
                                $examples[$currentAction] = array();
                                $examples[$currentAction]['occurence'] = 1;
                                $examples[$currentAction]['startLine'] = $lineHolder;
                                $examples[$currentAction]['length'] = 0;
                            } else {
                                $examples[$currentAction]['occurence']++;
                            }
                        }
                        if (preg_match('/\<\/request\>/', $buffer) == 1) {
                            $examples[$currentAction]['length'] += ( ($line - $lineHolder) + 1);
                        }
                    }
                    if (!feof($IOHandler)) {
                        echo "Error: unexpected fgets() fail\n";
                    }
                }
                fclose($IOHandler);
            } else {
                echo $neptunePath . $moduleName . '/' . $moduleName . '.examples.xml Example File Does Not Exist';
            }
// </editor-fold>
// <editor-fold desc="CREATE FILE MAP">
            if (file_exists($neptunePath . $moduleName . '/' . $moduleName . '.php')) {
                $line = 0;

                $lastDocBlockStart = 0;
                $docBlockOpen = false;
                $lastDocBlockClose = 0;

                $defaultVarsStart = 0;
                $defaultVarsOpen = false;
                $defaultVarsStop = 0;

                $returnVarsStart = 0;
                $returnVarsOpen = false;
                $returnVarsStop = 0;
                $returnVarsHasArray = false;

                $IOHandler = fopen($neptunePath . $moduleName . '/' . $moduleName . '.php', 'r+');
                if (filesize($neptunePath . $moduleName . '/' . $moduleName . '.php') > 0) {
                    echo "<b>Reading Module ... </b><br/>" . chr(10);
                    while (($buffer = fgets($IOHandler)) !== false) {
                        $line++;
                        // <editor-fold desc="LOCATE DOC BLOCKS">
                        if (preg_match('/\/\*\*/', $buffer) == 1) {
                            $lastDocBlockStart = $line;
                            $docBlockOpen = true;
                        }
                        if (preg_match('/\*\//', $buffer) == 1 AND $docBlockOpen) {
                            $lastDocBlockClose = $line;
                            $docBlockOpen = false;
                        }
                        // </editor-fold>
                        // <editor-fold desc="LOCATE FUNCTIONS">
                        if (preg_match('/public.function..+\(\)/', $buffer) == 1) {
                            $function = preg_split('/ +|\(\)/', $buffer);
                            if (isset($methods[$function[3]])) {
                                // <editor-fold desc="DELETE OLD DOC BLOCKS">
                                if ($_POST['overwrite'] == 'on' and $docBlockOpen == false and $lastDocBlockStart != 0 and $lastDocBlockClose != 0) {
                                    for ($count = $lastDocBlockStart; $count < $lastDocBlockClose + 1; $count++) {
                                        unset($fileData[$count]);
                                    }
                                    $line = $lastDocBlockStart;
                                    $lastDocBlockStart = 0;
                                    $lastDocBlockClose = 0;
                                }
                                // </editor-fold>
                                $currentFunction = $function[3];
                                $codeMap[$function[3]] = $line;
                            }
                        }
                        // </editor-fold>

                        $fileData[$line] = $buffer;

                        // <editor-fold desc="LOCATE DEFAULT VARS">
                        if (preg_match('/\$defaultVars.*\=/', $buffer) == 1) {
                            $defaultVarsOpen = true;
                            $defaultVarsStart = $line;
                        }
                        if (preg_match('/.*\;.*/', $buffer) == 1 and $defaultVarsOpen == true and $defaultVarsStart != 0) {
                            $defaultVarsStop = $line;
                            $defaultVarsOpen = false;
                            $code = '';
                            for ($count = $defaultVarsStart; $count < $line + 1; $count++) {
                                $code .= $fileData[$count];
                            }
                            stream_wrapper_register('var', 'VariableStream');
                            $code = '<?php ' . $code . '?>';
                            include('var://code');
                            stream_wrapper_unregister('var');
                            $inputs[$currentFunction] = arrayToDoc($defaultVars);
                            $code = '';
                            $defaultVarsStart = 0;
                            $defaultVarsStop = 0;
                            $defaultVarsOpen = false;
                        }
                        // </editor-fold>
                        // <editor-fold desc="LOCATE RETURN VARS">
                        if (preg_match('/\$returnData.*\=/', $buffer) == 1) {
                            $returnVarsOpen = true;
                            $returnVarsStart = $line;
                            $returnVarsHasArray = false;
                        }
                        
                        if(preg_match('/array\(/', $buffer) == 1 and $returnVarsOpen){
                            $returnVarsHasArray = true;
                        }

                        if (preg_match('/\)\;/', $buffer) == 1 and $returnVarsOpen == true and $returnVarsStart != 0 and $returnVarsHasArray == false) {
                            $returnVarsStart = 0;
                            $returnVarsStop = 0;
                            $returnVarsOpen = false;
                            $returnVarsHasArray = false;
                        }

                        if (preg_match('/\)\;/', $buffer) == 1 and $returnVarsOpen == true and $returnVarsStart != 0 and $returnVarsHasArray == true) {
                            $returnVarsStop = $line;
                            $returnVarsOpen = false;
                            $returnVarsHasArray = false;

                            $code = '';
                            for ($count = $returnVarsStart; $count < $line + 1; $count++) {
                                $code .= $fileData[$count];
                            }

                            $code = preg_replace('/mysqli_insert_id\(\$mysqlConnection\)/', "''", $code);
                            $code = preg_replace('/arrayToXml\(\$impoundObject\)/' , "''", $code);
                            $code = preg_replace('/arrayToXml\(collapseValidationArray\(\$returnData\)\)/' , "''", $code);

                            stream_wrapper_register('var', 'VariableStream');
                            $code = '<?php ' . $code . '?>';
                            include('var://code');
                            stream_wrapper_unregister('var');
                            if(gettype($returnData) == 'array'){
                                $outputs[$currentFunction] = arrayToDoc($returnData);
                            } else {
                                $outputs[$currentFunction] = " * <b> Object </b>";
                            }
                            
                            unset($returnData);
                            $code = '';
                            $returnVarsStart = 0;
                            $returnVarsStop = 0;
                            $returnVarsOpen = false;
                        }
                        // </editor-fold>
                    }
                    if (!feof($IOHandler)) {
                        echo "Error: unexpected fgets() fail\n";
                    }
                }
                fclose($IOHandler);
            } else {
                echo $neptunePath . $moduleName . '/' . $moduleName . '.php Example File Does Not Exist';
            }
// </editor-fold>
// <editor-fold desc="CREATE DOC BLOCKS">
            foreach ($methods AS $index => $value) {
                $docBlocks[$index] = '/**' . chr(10);
                $docBlocks[$index] .= ' * {PURPOSE}' . chr(10);
                $docBlocks[$index] .= ' *' . chr(10);
                $docBlocks[$index] .= ' * <b>Inputs:</b>' . chr(10);
                $docBlocks[$index] .= $inputs[$index];
                $docBlocks[$index] .= ' *' . chr(10);
                $docBlocks[$index] .= ' * <b>Return Data:</b>' . chr(10);
                $docBlocks[$index] .= $outputs[$index];
                $docBlocks[$index] .= ' *' . chr(10);
                $docBlocks[$index] .= ' * <b>Example XML Request:</b>' . chr(10);
                $docBlocks[$index] .= ' * {@example ./' . $moduleName . '/' . $moduleName . '.examples.php ' . $examples[$index]['startLine'] . ' ' . $examples[$index]['length'] . '}' . chr(10);
                $docBlocks[$index] .= ' *' . chr(10);
                $docBlocks[$index] .= ' * <b>Example XML Responses:</b>' . chr(10);
                $docBlocks[$index] .= ' * {@example ./' . $moduleName . '/' . $moduleName . '.responses.xml ' . $methods[$index]['startLine'] . ' ' . $methods[$index]['length'] . '}' . chr(10);
                $docBlocks[$index] .= " */ " . chr(10);
                echo "docBlock created for $index <br/>" . chr(10);
            }
// </editor-fold>
// <editor-fold desc="INSERT DOC BLOCKS">
            if (file_exists($neptunePath . $moduleName . '/' . $moduleName . '.php')) {
                $examples = array();
                $line = 0;
                $IOHandler = fopen($neptunePath . $moduleName . '/' . $moduleName . '.php', 'w+');
                if (filesize($neptunePath . $moduleName . '/' . $moduleName . '.php') > 0) {
                    echo "<b>Writing docBlocks to Module ... </b><br/>" . chr(10);
                    foreach ($fileData as $line => $data) {
                        foreach ($codeMap as $method => $methodLine) {
                            if ($line == $methodLine) {
                                fwrite($IOHandler, $docBlocks[$method]);
                                echo "Wrote $method docBlock <br/>" . chr(10);
                                //echo $docBlocks[$method];
                            }
                        }
                        fwrite($IOHandler, $data);
                        //echo $data;
                    }
                }
                fclose($IOHandler);
            } else {
                echo $neptunePath . $moduleName . '/' . $moduleName . '.php Example File Does Not Exist';
            }
// </editor-fold>
            //var_dump($docBlocks);
        } else {
            echo "Module Does Not Exist";
        }
    }
} else {
    echo '<h1><b><i><center>Neptune Utilities can only be run from a localhost</center></i></b></h1>';
}

function arrayToDoc($defaultArray, $deep = 0, $parent = '') {
    $doc = '';
    $debug = false;
    $errors = false;
    $failedIndex = '';
    foreach ($defaultArray as $index => $value) { // For each index in $defaultArray
        if (gettype($defaultArray[$index]) == 'array') {  // If defaultIndex contains arrays
            if (isset($defaultArray[$index]['value'])) { // If the defaultIndex is a end node
                //
                $doc .= ' * <li><b>' . $index . '</b>' .
                        ' | Required(' . $defaultArray[$index]['req'] . ')' .
                        ' | Default Value(' . $defaultArray[$index] . ')';
                if ($parent != '') {
                    $doc .= ' | Parent Node(' . $parent . ')';
                }
                $doc .= '</li>' . chr(10);
                //
                // <editor-fold desc="DEBUG">
                if ($debug) {
                    echo $index . ' - ' . $defaultArray[$index]['pattern'] . ' = ' . preg_match($defaultArray[$index]['pattern'], $defaultArray[$index]['value']) . '<br/>';
                }
                // </editor-fold>
            } else { // If the defaultIndex is not an end node
                if ($debug) {
                    echo 'Recursion on index (' . $index . ') ... <br/>'; //getType($defaultArray) = ' . gettype($defaultArray) . '<br/>';
                }
                $doc .= ' * <li><b>' . $index . '</b> | Parent ';
                if ($parent != '') {
                    $doc .= ' | Parent Node(' . $parent . ')';
                }
                $doc .= '</li>' . chr(10);
                $doc .= arrayToDoc($defaultArray[$index], $deep + 1, $parent = $index); // Recurse
//                if (gettype($defaultArray[$index]) != 'array') {
//                    $errors = true;
//                    $failedIndex .= $defaultArray[$index];
//                    if ($debug) {
//                        echo 'NOT AN ARRAY!<br/>';
//                    }
//                }
            }
        }
    }
    if ($deep == 0) {
        $doc = ' * <ul>' . chr(10) . $doc . ' * </ul>' . chr(10);
    }
    return $doc;
}

function arrayToXml($array, $deep = 0) {
    $start = ' *';
    $tab = chr(32) . chr(32) . chr(32) . chr(32) . chr(32);
    $br = chr(10);
    $indent = '';
    for ($count = 0; $count < $deep + 1; $count++) {
        $indent .= $tab;
    }
    $XML = "";
    foreach ($array as $index => $value) {
        if (gettype($array[$index]) == 'array') {
            if (!isArrayEmpty($array[$index])) {
                $XML .= $start . $indent . "<$index>" . $br;
                if (gettype($array[$index]) == 'array') {
                    if (!isArrayEmpty($array[$index])) {
                        $XML .= arrayToXml($array[$index], $deep + 1);
                    }
                } else {
                    $XML .= $start . $indent . $tab . urlencode($value) . $br;
                }
                $XML .= $start . $indent . "</$index>" . $br;
            } else {
                $XML .= $start . $indent . "<$index/>" . $br;
            }
        } else {
            if (!empty($array[$index])) {
                $XML .= $start . $indent . "<$index>" . $br;
                if (gettype($array[$index]) == 'array') {
                    if (!isArrayEmpty($array[$index])) {
                        $XML .= arrayToXml($array[$index], $deep + 1);
                    }
                } else {
                    $XML .= $start . $indent . $tab . urlencode($value) . $br;
                }
                $XML .= $start . $indent . "</$index>" . $br;
            } else {
                $XML .= $start . $indent . "<$index/>" . $br;
            }
        }
    }
    return $XML;
}

function isArrayEmpty($array) {
    $empty = true;
    foreach ($array as $index => $value) {
        if (gettype($array[$index]) == 'array') {
            $empty = isArrayEmpty($array[$index]);
        } else {
            if (!empty($array[$index])) {
                $empty = false;
            }
        }
    }
    return $empty;
}

class VariableStream {

    var $position;
    var $varname;

    function stream_stat() {
        return true;
    }

    function stream_open($path, $mode, $options, &$opened_path) {
        $url = parse_url($path);
        $this->varname = $url["host"];
        $this->position = 0;

        return true;
    }

    function stream_read($count) {
        $ret = substr($GLOBALS[$this->varname], $this->position, $count);
        $this->position += strlen($ret);
        return $ret;
    }

    function stream_write($data) {
        $left = substr($GLOBALS[$this->varname], 0, $this->position);
        $right = substr($GLOBALS[$this->varname], $this->position + strlen($data));
        $GLOBALS[$this->varname] = $left . $data . $right;
        $this->position += strlen($data);
        return strlen($data);
    }

    function stream_tell() {
        return $this->position;
    }

    function stream_eof() {
        return $this->position >= strlen($GLOBALS[$this->varname]);
    }

    function stream_seek($offset, $whence) {
        switch ($whence) {
            case SEEK_SET:
                if ($offset < strlen($GLOBALS[$this->varname]) && $offset >= 0) {
                    $this->position = $offset;
                    return true;
                } else {
                    return false;
                }
                break;

            case SEEK_CUR:
                if ($offset >= 0) {
                    $this->position += $offset;
                    return true;
                } else {
                    return false;
                }
                break;

            case SEEK_END:
                if (strlen($GLOBALS[$this->varname]) + $offset >= 0) {
                    $this->position = strlen($GLOBALS[$this->varname]) + $offset;
                    return true;
                } else {
                    return false;
                }
                break;

            default:
                return false;
        }
    }

}
?>