<?php
// <editor-fold desc="Activty Data">
$activityType = array('Running','Swimming','Walking', 'Aerobics');
// </editor-fold>


function getVin($vinLength = 17){
    $vinCharacters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $vin = "";
    for ($count = 1; $count <= $vinLength; $count+=1) {
        $vin .= substr($vinCharacters, mt_rand(0, strlen($vinCharacters) - 1), 1);
    }
    return $vin;
}

function getRandomIndex($array){
   return $array[rand(0,count($array)-1)];
}

function getRandomDate($days = 90) {
    $date = date_parse(date('Y-m-d'));
    return date('Y-m-d', mktime(0, 0, 0, $date['month'], $date['day'] - rand(0, $days), $date['year']));
}

$username = "Administrator";
$password = "password";

$numberOfExampleRecord = 100;
$neptuneProcessorURL = "http://localhost/azimuth/svn/enid/_modules/com/neptune/model/processor.php";

$APIRequest =
    "<requests>
        <request>
            <module>usermanager</module>
            <action>LOGIN</action>
            <data>
                <username>".$username."</username>
                <password>".$password."</password>
            </data>
        </request>";

while($numberOfExampleRecord > 0){
    set_time_limit(10);
    $date = getRandomDate();
    $APIRequest .= "
        <request>
            <module>healthjournal</module>
            <action>CREATE_ACTIVITIES_RECORD</action>
            <data>
                <activityLog>
                    <activityDate>".  $date ."</activityDate>
                    <activityType>Running</activityType>
                    <activityLevel>general</activityLevel>
                    <activityDistanceValue>".rand(0,10)."</activityDistanceValue>
                    <activityDistanceType>Miles</activityDistanceType>
                    <activityDurationHours>0</activityDurationHours>
                    <activityDurationMinutes>".rand(10,30)."</activityDurationMinutes>
                    <activityDurationSeconds>".rand(0,59)."</activityDurationSeconds>
                    <activityCalories>".rand(100,1000)."</activityCalories>
                </activityLog>
            </data>
        </request>
        <request>
            <module>healthjournal</module>
            <action>CREATE_VITAL_RECORD</action>
            <data>
                <vitalRecord>
                    <date>". $date ."</date>
                    <weight>".rand(150,250)."</weight>
                    <bloodPressure>
                        <syc>".rand(10,50)."</syc>
                        <dya>".rand(10,50)."</dya>
                        <pulse>".rand(50,115)."</pulse>
                    </bloodPressure>
                    <glucose>".rand(10,50)."</glucose>
                    <cholesterol>
                        <ldl>".rand(10,50)."</ldl>
                        <hdl>".rand(10,50)."</hdl>
                    </cholesterol>
                </vitalRecord>
            </data>
        </request>
        <request>
            <module>healthjournal</module>
            <action>CREATE_DIARY_RECORD</action>
            <data>
                <diaryRecord>
                    <diaryDate>". $date ."</diaryDate>
                    <diaryTitle>Example Data</diaryTitle>
                    <entry>This is an example journal entry</entry>
                    <feelings>
                        <mood></mood>
                        <energy></energy>
                        <stress></stress>
                        <anger></anger>
                        <appetite></appetite>
                        <clarity></clarity>
                        <health></health>
                        <sleep></sleep>
                    </feelings>
                </diaryRecord>
            </data>
        </request>
        <request>
            <module>healthjournal</module>
            <action>CREATE_BODY_RECORD</action>
            <data>
                <bodyRecord>
                    <date>".$date."</date>
                    <neck>".rand(5,10)."</neck>
                    <shoulders>".rand(5,10)."</shoulders>
                    <chest>".rand(5,10)."</chest>
                    <leftBicep>".rand(5,10)."</leftBicep>
                    <rightBicep>".rand(5,10)."</rightBicep>
                    <leftForearm>".rand(5,10)."</leftForearm>
                    <rightForearm>".rand(5,10)."</rightForearm>
                    <waist>".rand(20,30)."</waist>
                    <hips>".rand(20,30)."</hips>
                    <leftThigh>".rand(5,10)."</leftThigh>
                    <rightThigh>".rand(5,10)."</rightThigh>
                    <leftCalf>".rand(5,10)."</leftCalf>
                    <rightCalf>".rand(5,10)."</rightCalf>
                </bodyRecord>
            </data>
        </request>";
    $numberOfExampleRecord--;
}
set_time_limit(100);
$APIRequest .= $outputBlock . "
     </requests>";

    $request = curl_init($neptuneProcessorURL); // initiate curl object
    curl_setopt($request, CURLOPT_HEADER, 0); 	// set to 0 to eliminate header info from response
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); 	// Returns response data instead of TRUE(1)
    curl_setopt($request, CURLOPT_POSTFIELDS, "&query=".$APIRequest);	 // use HTTP POST to send form data
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); 	// uncomment this line if you get no gateway response.
    $post_response = curl_exec($request); 	// execute curl post and store results in $post_response
    curl_close ($request); // close curl object
    echo $post_response;
?>
