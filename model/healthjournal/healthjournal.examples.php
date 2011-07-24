<?php
// <editor-fold desc="*_ACTIVITIES_RECORD">
$CREATE_ACTIVITIES_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>CREATE_ACTIVITIES_RECORD</action>
            <data>
                <activityLog>
                    <activityDate>4/19/2011</activityDate>
                    <activityType>Running</activityType>
                    <activityLevel>general</activityLevel>
                    <activityDistanceValue>5</activityDistanceValue>
                    <activityDistanceType>Miles</activityDistanceType>
                    <activityDurationHours>0</activityDurationHours>
                    <activityDurationMinutes>20</activityDurationMinutes>
                    <activityDurationSeconds>37</activityDurationSeconds>
                    <activityCalories>200</activityCalories>
                </activityLog>
            </data>
        </request>
     </requests>";

$UPDATE_ACTIVITIES_RECORD  =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>UPDATE_ACTIVITIES_RECORD</action>
            <data>
                <recordId>1</recordId>
                <activityLog>
                    <activityDate>4/19/2011</activityDate>
                    <activityType>Running</activityType>
                    <activityLevel>general</activityLevel>
                    <activityDistanceValue>5</activityDistanceValue>
                    <activityDistanceType>Miles</activityDistanceType>
                    <activityDurationHours>0</activityDurationHours>
                    <activityDurationMinutes>20</activityDurationMinutes>
                    <activityDurationSeconds>37</activityDurationSeconds>
                    <activityCalories>200</activityCalories>
                </activityLog>
            </data>
        </request>
</requests>";
$DELETE_ACTIVITIES_RECORD  =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>DELETE_ACTIVITIES_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";
$GET_ACTIVITIES_RECORD  =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_ACTIVITIES_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";
$GET_ALL_ACTIVITIES_RECORDS  =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_ALL_ACTIVITIES_RECORDS</action>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="*_VITAL_RECORD">
$CREATE_VITAL_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>CREATE_VITAL_RECORD</action>
            <data>
                <vitalRecord>
                    <date>04/29/2011</date>
                    <weight>160</weight>
                    <bloodPressure>
                        <syc>0</syc>
                        <dya>0</dya>
                        <pulse>80</pulse>
                    </bloodPressure>
                    <glucose>50</glucose>
                    <cholesterol>
                        <ldl>50</ldl>
                        <hdl>50</hdl>
                    </cholesterol>
                </vitalRecord>
            </data>
        </request>
     </requests>";

$UPDATE_VITAL_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>UPDATE_VITAL_RECORD</action>
            <data>
                <recordId>1</recordId>
                <vitalRecord>
                    <date>04/29/2011</date>
                    <weight>160</weight>
                    <bloodPressure>
                        <syc>0</syc>
                        <dya>0</dya>
                        <pulse>80</pulse>
                    </bloodPressure>
                    <glucose>50</glucose>
                    <cholesterol>
                        <ldl>50</ldl>
                        <hdl>50</hdl>
                    </cholesterol>
                </vitalRecord>
            </data>
        </request>
     </requests>";

$DELETE_VITAL_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>DELETE_VITAL_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_VITAL_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_VITAL_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_ALL_VITAL_RECORDS =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_ALL_VITAL_RECORDS</action>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="*_DIARY_RECORD">
$CREATE_DIARY_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>CREATE_DIARY_RECORD</action>
            <data>
                <diaryRecord>
                    <diaryDate>2011-04-29</diaryDate>
                    <diaryTitle>Work in progress</diaryTitle>
                    <entry>Working on diary record api call</entry>
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
     </requests>";

$UPDATE_DIARY_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>UPDATE_DIARY_RECORD</action>
            <data>
                <recordId>1</recordId>
                <diaryRecord>
                    <diaryDate>2011-04-29</diaryDate>
                    <diaryTitle>Work in progress</diaryTitle>
                    <entry>Working on diary record api call</entry>
                    <feelings>
                        <mood>Good</mood>
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
     </requests>";

$DELETE_DIARY_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>DELETE_DIARY_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_DIARY_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_DIARY_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_ALL_DIARY_RECORDS =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_ALL_DIARY_RECORDS</action>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="*_BODY_RECORD">
$CREATE_BODY_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>CREATE_BODY_RECORD</action>
            <data>
                <bodyRecord>
                    <date>2011-05-02</date>
                    <neck>10.5</neck>
                    <shoulders>10.5</shoulders>
                    <chest>10.5</chest>
                    <leftBicep>10.0</leftBicep>
                    <rightBicep>10.0</rightBicep>
                    <leftForearm>10.0</leftForearm>
                    <rightForearm>10.0</rightForearm>
                    <waist>20.0</waist>
                    <hips>30.0</hips>
                    <leftThigh>15.0</leftThigh>
                    <rightThigh>15.0</rightThigh>
                    <leftCalf>5.0</leftCalf>
                    <rightCalf>5.0</rightCalf>
                </bodyRecord>
            </data>
        </request>
     </requests>";

$UPDATE_BODY_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>UPDATE_BODY_RECORD</action>
            <data>
                <recordId>1</recordId>
                <bodyRecord>
                    <date>2011-05-02</date>
                    <neck>10.5</neck>
                    <shoulders>10.5</shoulders>
                    <chest>10.5</chest>
                    <leftBicep>10.0</leftBicep>
                    <rightBicep>10.0</rightBicep>
                    <leftForearm>10.0</leftForearm>
                    <rightForearm>10.0</rightForearm>
                    <waist>20.0</waist>
                    <hips>30.0</hips>
                    <leftThigh>15.0</leftThigh>
                    <rightThigh>15.0</rightThigh>
                    <leftCalf>5.0</leftCalf>
                    <rightCalf>5.0</rightCalf>
                </bodyRecord>
            </data>
        </request>
     </requests>";

$DELETE_BODY_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>DELETE_BODY_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_BODY_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_BODY_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_ALL_BODY_RECORDS =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_ALL_BODY_RECORDS</action>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="*_FOOD_ITEM_RECORD">
$CREATE_FOOD_ITEM_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>CREATE_FOOD_ITEM_RECORD</action>
            <data>
                <userId>0</userId>
                <foodItem>
                    <name>Pepsi Throwback</name>
                    <calories>150</calories>
                    <cholesterol>0</cholesterol>
                    <carbs>40</carbs>
                    <dietaryFiber>0</dietaryFiber>
                    <totalFat>0</totalFat>
                    <sodium>40</sodium>
                    <sugars>40</sugars>
                    <protein>0</protein>
                </foodItem>
            </data>
        </request>
     </requests>";

$UPDATE_FOOD_ITEM_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>UPDATE_FOOD_ITEM_RECORD</action>
            <data>
                <recordId>1</recordId>
                <foodItem>
                    <name>Pepsi Throwback</name>
                    <calories>150</calories>
                    <cholesterol>0</cholesterol>
                    <carbs>40</carbs>
                    <dietaryFiber>0</dietaryFiber>
                    <totalFat>0</totalFat>
                    <sodium>40</sodium>
                    <sugars>40</sugars>
                    <protein>0</protein>
                </foodItem>
            </data>
        </request>
     </requests>";

$DELETE_FOOD_ITEM_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>DELETE_FOOD_ITEM_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_FOOD_ITEM_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_FOOD_ITEM_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_ALL_FOOD_ITEM_RECORDS =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_ALL_FOOD_ITEM_RECORDS</action>
        </request>
     </requests>";
// </editor-fold>
// <editor-fold desc="*_FOOD_RECORD">
$CREATE_FOOD_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>CREATE_FOOD_RECORD</action>
            <data>
                <foodLog>
                    <foodDate>2011-05-05</foodDate>
                    <foodMeal>Dinner</foodMeal>
                    <foodItem>1</foodItem>
                </foodLog>
            </data>
        </request>
     </requests>";

$UPDATE_FOOD_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>UPDATE_FOOD_RECORD</action>
            <data>
                <recordId>1</recordId>
                <foodLog>
                    <foodDate>2011-05-05</foodDate>
                    <foodMeal>Dinner</foodMeal>
                    <foodItem>1</foodItem>
                </foodLog>
            </data>
        </request>
     </requests>";

$DELETE_FOOD_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>DELETE_FOOD_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_FOOD_RECORD =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_FOOD_RECORD</action>
            <data>
                <recordId>1</recordId>
            </data>
        </request>
     </requests>";

$GET_ALL_FOOD_RECORDS =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_ALL_FOOD_RECORDS</action>
            <data>
                <date>2011-05-05</date>
            </data>
        </request>
     </requests>";
// </editor-fold>
$GET_CHART_DATA =
    "<requests>
        <request>
            <module>healthjournal</module>
            <action>GET_CHART_DATA</action>
            <data>
                <datasetName>MILES_BY_DAY</datasetName>
            </data>
        </request>
     </requests>";
?>
