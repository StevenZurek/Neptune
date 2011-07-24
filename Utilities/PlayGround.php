<?php
error_reporting(E_ALL ^ E_NOTICE);
if (preg_match('/localhost/', $_SERVER['SERVER_NAME']) == 1) {
?>
    <html>
        <body style="padding: 0px; margin: 0px;overflow: hidden;" onload="resetQuery();">
            <script language="javascript" type="text/javascript">
                function addText(text) {
                    if(document.queryForm.query.value.search(/\<\/requests\>/) != -1){
                        document.queryForm.query.value = document.queryForm.query.value.replace(/\<\/requests\>/, text + '</requests>');
                    } else {
                        document.queryForm.query.value += text;
                    }
                }

                function sendQuery(){
                    //if(document.queryForm.query.value.search(/\<requests\>.*\<\/requests\>/) != -1){
                    //document.queryForm.query.style.color = '#729FCF';
                    document.getElementById('console').src = document.getElementById('processorURL').value + '?query=' +  encodeURI(document.queryForm.query.value);
                    //} else {
                    //document.queryForm.query.style.color = '#FF0000';
                    //document.queryForm.query.style.color = '#729FCF';
                    //}

                }
                function resetQuery(){
                    document.queryForm.query.value = '<requests>\n</requests>';
                }

                function setSelectionRange(input, selectionStart, selectionEnd) {
                    if (input.setSelectionRange) {
                        input.focus();
                        input.setSelectionRange(selectionStart, selectionEnd);
                    }
                    else if (input.createTextRange) {
                        var range = input.createTextRange();
                        range.collapse(true);
                        range.moveEnd('character', selectionEnd);
                        range.moveStart('character', selectionStart);
                        range.select();
                    }
                }
                function replaceSelection (input, replaceString) {
                    if (input.setSelectionRange) {
                        var selectionStart = input.selectionStart;
                        var selectionEnd = input.selectionEnd;
                        input.value = input.value.substring(0, selectionStart)+ replaceString + input.value.substring(selectionEnd);

                        if (selectionStart != selectionEnd){
                            setSelectionRange(input, selectionStart, selectionStart + 	replaceString.length);
                        }else{
                            setSelectionRange(input, selectionStart + replaceString.length, selectionStart + replaceString.length);
                        }

                    }else if (document.selection) {
                        var range = document.selection.createRange();

                        if (range.parentElement() == input) {
                            var isCollapsed = range.text == '';
                            range.text = replaceString;

                            if (!isCollapsed)  {
                                range.moveStart('character', -replaceString.length);
                                range.select();
                            }
                        }
                    }
                }
                function catchTab(item,e){
                    if(navigator.userAgent.match("Gecko")){
                        c=e.which;
                    }else{
                        c=e.keyCode;
                    }
                    if(c==9){
                        replaceSelection(item,String.fromCharCode(9));
                        setTimeout("document.getElementById('"+item.id+"').focus();",0);
                        return false;
                    }

                }
            </script>
            <div style="float: left; background-color: cadetblue; width: 20%; height: 100%; overflow: auto">
            <?php
            if (is_dir($_POST['neptuneURL']) and verifyNeptuneProcessor($_POST['processorURL'])) {
                echo getExamples();
            } else {
                if (!is_dir($_POST['neptuneURL'])) {
                    echo "<center><b> Invalid Neptune Folder</b></center><br/>";
                }
                if (!verifyNeptuneProcessor($_POST['processorURL'])) {
                    echo "<center><b> Invalid Neptune Processor URL</b></center><br/>";
                }
            }
            ?>
        </div>
        <div style="padding: 0; margin: 0;border-style: none; background-color: #465254; color: #729FCF; height: 60%; width: 80%; float: right;">
            <form name="queryForm">
                <textarea name="query" style="padding: 0; margin: 0;border-style: none; background-color: #465254; color: #729FCF; height: 100%; width: 100%" onkeydown="return catchTab(this,event)"><requests></requests></textarea>
            </form>
        </div>
        <div style="width: 80%; height: 10%;background-color: #00AA00; float: right;vertical-align: middle;" >
            <input type="reset" style="float: right; vertical-align: middle;margin-right: 5px" onclick="resetQuery();"/>
            <input type="submit" style="float: right; vertical-align: middle;margin-right: 5px;" onclick="sendQuery();"/>
            <form method="post" action="PlayGround.php" name="locationForm" id="locationForm">
                <table>
                    <tr>
                        <td>Neptune Folder Location (Directory Only): </td>
                        <td><input type="text" name="neptuneURL" id="neptuneURL" size="64" value="<?php echo $_POST['neptuneURL'] ?>"/></td>
                    </tr>
                    <tr>
                        <td>Neptune Processor (HTTP Only): </td>
                        <td><input type="text" name="processorURL" id="processorURL" size="64" value="<?php echo $_POST['processorURL'] ?>"/><input type="submit" value="Load Neptune" style="margin-left: 5px"/></td>
                    </tr>
                </table>
            </form>
        </div>
        <div style="width: 80%; height: 30%; background-color: #00FF00;float: right;">
            <iframe id="console" name="console" style="width: 100%; height: 100%"/>
        </div>
    </body>
</html>
<?php
        } else {
            echo '<h1><b><i><center>Neptune Utilities can only be run from a localhost</center></i></b></h1>';
        }

        function verifyNeptuneProcessor($domain) {
            $request = curl_init($domain); // initiate curl object
            curl_setopt($request, CURLOPT_HEADER, 0);  // set to 0 to eliminate header info from response
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);  // Returns response data instead of TRUE(1)
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);  // uncomment this line if you get no gateway response.
            $post_response = curl_exec($request);  // execute curl post and store results in $post_response
            curl_close($request); // close curl object
            if (preg_match('/PROCESSOR/', $post_response) != 0) {
                return true;
            } else {
                return false;
            }
        }

        function getExamples() {
            if (is_dir($_POST['neptuneURL'] . '/model/')) {
                $dir = scandir($_POST['neptuneURL'] . '/model/');
                foreach ($dir as $folder => $value) {
                    if (preg_match('/^\.|^\.\.|^\.svn|^framework|^admin/', $value) == 0) {
                        if (is_dir($_POST['neptuneURL'] . '/model/' . $value . '/')) {
                            $path = $_POST['neptuneURL'] . '/model/' . $value . '/';
                            $moduleFile = $path . $value . '.php';
                            $exampleFile = $path . $value . '.examples.php';
                            $responseFile = $path . $value . '.responses.xml';
                            if (file_exists($moduleFile) and file_exists($exampleFile) and file_exists($responseFile)) {
                                echo "<hr/><b><u><center> $value </center></u></b><hr/>";
                                // <editor-fold desc="EXAMPLE PARSER">
                                $examples = array();
                                $state = 0;
                                $line = 0;
                                $lineHolder = 0;
                                $currentAction = '';
                                $data = '';
                                $IOHandler = fopen($exampleFile, 'r+');
                                if (filesize($exampleFile) > 0) {
                                    while (($buffer = fgets($IOHandler)) !== false) {
                                        $line++;
                                        if (preg_match('/\<request\>/', $buffer) == 1) {
                                            //echo "Opening Response Node On Line " . $line . "... <br/>";
                                            $lineHolder = $line;
                                            $state = 1;
                                        }
                                        if (preg_match('/\<action>.+\<\/action\>/', $buffer) == 1) {
                                            $action = preg_split('/\<\/*action\>/', $buffer);
                                            $currentAction = $action[1];
                                        }
                                        if (preg_match('/\<\/request\>/', $buffer) == 1) {
                                            $data .= $buffer;
                                            $state = 0;
                                            $examples[$currentAction] = $data;
                                            $data = '';
                                        }
                                        if ($state == 1) {
                                            $data .= $buffer;
                                        }
                                    }
                                    foreach ($examples as $method => $code) {
                                        $code = preg_replace('/' . chr(10) . '/', '\n', $code);
                                        echo "<a href=\"#\" onclick=\"addText('" . $code . "');\"/>$method</a><br/>";
                                    }
                                    // <editor-fold desc="EOF ERRORS">
                                    if (!feof($IOHandler)) {
                                        echo "Error: unexpected fgets() fail\n";
                                    }
                                    // </editor-fold>
                                }
                                fclose($IOHandler);
                                //</editor-fold>
                            }
                        }
                    }
                }
            }
        }
?>