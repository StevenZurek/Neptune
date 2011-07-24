<?php
$CREATE_AFFILIATE_QUERY =
    "<requests>
        <request>
            <module>affiliatemanager</module>
            <action>CREATE_AFFILIATE</action>
            <data>
                <name>Azimuth360</name>
                <address>227 S. Fillmore Ave, Louisville, Co</address>
                <image>./images/logo.jpg</image>
                <url>http://www.azimuth360.com</url>
                <description>IT Consulting</description>
                <phone>3032575190</phone>
                <category>sponsor</category>
            </data>
        </request>
     </requests>";

$UPDATE_AFFILIATE_QUERY =
    "<requests>
        <request>
            <module>affiliatemanager</module>
            <action>UPDATE_AFFILIATE</action>
            <data>
                <affiliateId>1</affiliateId>
                <name>Azimuth360</name>
                <address>227 S. Fillmore Ave, Louisville, Co</address>
                <image>./images/logo.jpg</image>
                <url>http://www.azimuth360.com</url>
                <description>IT Consulting</description>
                <phone>3032575190</phone>
                <category>sponsor</category>
            </data>
        </request>
     </requests>";

$DELETE_AFFILIATE_QUERY =
    "<requests>
        <request>
            <module>affiliatemanager</module>
            <action>DELETE_AFFILIATE</action>
            <data>
                <affiliateId>1</affiliateId>
            </data>
        </request>
     </requests>";

$GET_ALL_AFFILIATES_QUERY =
    "<requests>
        <request>
            <module>affiliatemanager</module>
            <action>GET_ALL_AFFILIATES</action>
        </request>
     </requests>";
?>
