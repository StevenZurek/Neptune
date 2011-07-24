<?php
require_once("../framework/framework.php");
$processorURL = "../processor.php";
// <editor-fold desc="OUTPUT BLOCK">
$outputBlock = "<output>
            <method>ECHO</method>
        </output>";
// </editor-fold>
// <editor-fold desc="CREATE USER QUERY">
$CREATE_USER_QUERY =
        "<requests>
        <request>
            <module>usermanager</module>
            <action>CREATE_USER</action>
        </request>
        " . $outputBlock . "
     </requests>";
// </editor-fold>
// <editor-fold desc="CREATE USER PROFILE QUERY">
$CREATE_USER_PROFILE_QUERY =
        "<requests>
        <request>
            <module>usermanager</module>
            <action>CREATE_USER_PROFILE</action>
            <data>
                <userId>21</userId>
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
        " . $outputBlock . "
     </requests>";
// </editor-fold>
// <editor-fold desc="CREATE BILLING PROFILE QUERY">
$CREATE_BILLING_PROFILE_QUERY =
        "<requests>
        <request>
            <module>usermanager</module>
            <action>CREATE_BILLING_PROFILE</action>
            <data>
                <userId>21</userId>
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
        " . $outputBlock . "
     </requests>";
// </editor-fold>
// <editor-fold desc="CREATE SHIPPING PROFILE QUERY">
$CREATE_SHIPPING_PROFILE_QUERY =
        "<requests>
        <request>
            <module>usermanager</module>
            <action>CREATE_SHIPPING_PROFILE</action>
            <data>
                <userId>21</userId>
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
        " . $outputBlock . "
     </requests>";
// </editor-fold>
// <editor-fold desc="CREATE ACCOUNT PROFILE QUERY">
$CREATE_ACCOUNT_PROFILE_QUERY =
        "<requests>
        <request>
            <module>usermanager</module>
            <action>CREATE_ACCOUNT_PROFILE</action>
            <data>
                <userId>1</userId>
                <username>Steven</username>
            </data>
        </request>
        " . $outputBlock . "
     </requests>";
// </editor-fold>
// <editor-fold desc="LOGIN QUERY">
$LOGIN_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>LOGIN</action>
                <data>
                    <username>Steven</username>
                    <password>k1kcrn</password>
                </data>
            </request>
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="LOGOUT QUERY">
$LOGOUT_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>LOGOUT</action>
            </request>
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="GET USERS QUERY">
$GET_USERS_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>GET_USERS</action>
            </request>
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="DELETE_USER QUERY">
$DELETE_USER_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>DELETE_USER</action>
                <data>
                    <userId>2</userId>
                </data>
            </request>
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="GET USER INFORMATION QUERY">
$GET_USER_INFORMATION_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>GET_USER_INFORMATION</action>
                <data>
                    <userId>1</userId>
                </data>
            </request>
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="SET PASSWORD QUERY">
$SET_PASSWORD_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>SET_PASSWORD</action>
                <data>
                    <userId>1</userId>
                    <password>MKO)nji9</password>
                </data>
            </request>
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="CHANGE PASSWORD QUERY">
$CHANGE_PASSWORD_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>CHANGE_PASSWORD</action>
                <data>
                    <username>derek.adair</username>
                    <oldpassword>zOinks12</oldpassword>
                    <password1>asdf</password1>
                    <password2>asdf</password2>
                </data>
            </request>
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="UPDATE USER PROFILE QUERY">
$UPDATE_USER_PROFILE_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>UPDATE_USER_PROFILE</action>
                <data>
                    <userId>1</userId>
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
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="UPDATE BILLING PROFILE QUERY">
$UPDATE_BILLING_PROFILE_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>UPDATE_BILLING_PROFILE</action>
                <data>
                    <userId>1</userId>
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
            " . $outputBlock . "
         </requests>";
// </editor-fold>
// <editor-fold desc="UPDATE SHIPPING PROFILE QUERY">
$UPDATE_SHIPPING_PROFILE_QUERY =
        "<requests>
            <request>
                <module>usermanager</module>
                <action>UPDATE_SHIPPING_PROFILE</action>
                <data>
                    <userId>1</userId>
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
            " . $outputBlock . "
         </requests>";
// </editor-fold>
?>
<h1>User Manager API </h1><hr>
<table border="2" width="100%">
    <tr>
        <td>CREATE_USER</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $CREATE_USER_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>CREATE_USER_PROFILE</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $CREATE_USER_PROFILE_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>CREATE_BILLING_PROFILE</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $CREATE_BILLING_PROFILE_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>CREATE_SHIPPING_PROFILE</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $CREATE_SHIPPING_PROFILE_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>CREATE_ACCOUNT_PROFILE</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $CREATE_ACCOUNT_PROFILE_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>LOGIN</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $LOGIN_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>LOGOUT</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $LOGOUT_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>GET_USERS</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $GET_USERS_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>DELETE_USER</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $DELETE_USER_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>GET_USER_INFORMATION</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $GET_USER_INFORMATION_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>SET_PASSWORD</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $SET_PASSWORD_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>CHANGE_PASSWORD</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $CHANGE_PASSWORD_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>UPDATE_USER_PROFILE</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $UPDATE_USER_PROFILE_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>UPDATE_BILLING_PROFILE</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $UPDATE_BILLING_PROFILE_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
    <tr>
        <td>UPDATE_SHIPPING_PROFILE</td>
        <td>
            <form action="<?= $processorURL; ?>" method="post">
                <input type="hidden" name="query" value="<?php echo $UPDATE_SHIPPING_PROFILE_QUERY; ?>" />
                <input type="submit" />
            </form>
        </td>
    </tr>
</table>
<h1>$_SESSION['MasterSession']->SESSION['usermanager']</h1>
<hr/>
<?php var_dump($_SESSION['MasterSession']->SESSION['usermanager']); ?>
