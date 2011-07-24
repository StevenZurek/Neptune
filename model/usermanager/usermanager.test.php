<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("../framework/framework.php");
$processorURL = "../processor.php";
$DATABINDING_QUERY = "
    <requests>
        <request>
            <module>usermanager</module>
            <action>CREATE_USER</action>
            <bind>
                <userId>{symbol}</userId>
            </bind>
        </request>
        <request>
            <module>usermanager</module>
            <action>CREATE_USER_PROFILE</action>
            <data>
                <userId>{symbol}</userId>
                <firstName>Steven</firstName>
                <lastName>Zurek</lastName>
                <address1>227 S. Fillmore Ave</address1>
                <city>Louisville</city>
                <state>CO</state>
                <country>US</country>
                <zip>80027</zip>
                <phone>3039172360</phone>
                <email>steven.zurek@azimuth360.com</email>
                <other>Something Else</other>
            </data>
        </request>
     </requests>";

?>
<h1>Data Binding Test</h1><hr>
<table border="2" width="100%">
    <tr>
        <td>CREATE_USER</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $DATABINDING_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
</table>