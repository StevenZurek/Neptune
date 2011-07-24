<?php
// <editor-fold desc="CREATE_EVENT">
$CREATE_EVENT_QUERY =
    "<requests>
        <request>
            <module>eventmanager</module>
            <action>CREATE_EVENT</action>
            <data>
                <title>Azimuth360</title>
                <date>2011/05/01</date>
                <timeHour>12</timeHour>
                <timeMinute>30</timeMinute>
                <timeAMPM>PM</timeAMPM>
                <location>227 S. Fillmore Ave, Louisville, Co</location>
                <image>./images/logo.jpg</image>
                <description>IT Consulting</description>
                <url>http://www.azimuth360.com</url>
                <recurring>false</recurring>
                <category>run</category>
            </data>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="UPDATE_EVENT">
$UPDATE_EVENT_QUERY =
    "<requests>
        <request>
            <module>eventmanager</module>
            <action>UPDATE_EVENT</action>
            <data>
                <eventId>1</eventId>
                <title>Azimuth360</title>
                <date>2011/05/01</date>
                <timeHour>12</timeHour>
                <timeMinute>30</timeMinute>
                <timeAMPM>PM</timeAMPM>
                <location>227 S. Fillmore Ave, Louisville, Co</location>
                <image>./images/logo.jpg</image>
                <description>IT Consulting</description>
                <url>http://www.azimuth360.com</url>
                <recurring>false</recurring>
                <category>run</category>
            </data>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="DELETE_EVENT">
$DELETE_EVENT_QUERY =
    "<requests>
        <request>
            <module>eventmanager</module>
            <action>DELETE_EVENT</action>
            <data>
                <eventId>1</eventId>
            </data>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="GET_EVENT">
$GET_EVENT_QUERY =
    "<requests>
        <request>
            <module>eventmanager</module>
            <action>GET_EVENT</action>
            <data>
                <eventId>1</eventId>
            </data>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="GET_ALL_EVENTS">
$GET_ALL_EVENTS_QUERY =
    "<requests>
        <request>
            <module>eventmanager</module>
            <action>GET_ALL_EVENTS</action>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="RSVP">
$RSVP_QUERY =
    "<requests>
        <request>
            <module>eventmanager</module>
            <action>RSVP</action>
            <data>
                <eventId>1</eventId>
                <userId>1</userId>
            </data>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="CANCEL_RSVP">
$CANCEL_RSVP_QUERY =
    "<requests>
        <request>
            <module>eventmanager</module>
            <action>CANCEL_RSVP</action>
            <data>
                <eventId>1</eventId>
                <userId>1</userId>
            </data>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="GET_ALL_ATTENDEES">
$CANCEL_RSVP_QUERY =
    "<requests>
        <request>
            <module>eventmanager</module>
            <action>GET_ALL_ATTENDEES</action>
            <data>
                <eventId>1</eventId>
            </data>
        </request>
     </requests>";
// </editor-fold>
?>
