<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");


if ($encounter == "")
$encounter = date("Ymd");

foreach($_POST as $key => $value) {
    $_POST[$key] = mysql_real_escape_string($value);
}

if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_pt_Reassessment", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "PT Reassessment", $newid, "ptreassessment", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

sqlInsert("update forms_pt_Reassessment set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
Reassessment_visit_type ='".$_POST["Reassessment_visit_type"]."',
Reassessment_Time_In='".$_POST["Reassessment_Time_In"]."',
Reassessment_Time_Out='".$_POST["Reassessment_Time_Out"]."',
Reassessment_date ='".$_POST["Reassessment_date"]."',
Reassessment_Pulse ='".$_POST["Reassessment_Pulse"]."',
Reassessment_Pulse_State ='".$_POST["Reassessment_Pulse_State"]."',
Reassessment_Temperature ='".$_POST["Reassessment_Temperature"]."',
Reassessment_Temperature_type ='".$_POST["Reassessment_Temperature_type"]."',
Reassessment_VS_other ='".$_POST["Reassessment_VS_other"]."',
Reassessment_VS_Respirations ='".$_POST["Reassessment_VS_Respirations"]."',
Reassessment_VS_BP_Systolic ='".$_POST["Reassessment_VS_BP_Systolic"]."',
Reassessment_VS_BP_Diastolic ='".$_POST["Reassessment_VS_BP_Diastolic"]."',
Reassessment_VS_BP_side ='".$_POST["Reassessment_VS_BP_side"]."',
Reassessment_VS_BP_Body_Position ='".$_POST["Reassessment_VS_BP_Body_Position"]."',
Reassessment_VS_Sat ='".$_POST["Reassessment_VS_Sat"]."',
Reassessment_VS_Pain ='".$_POST["Reassessment_VS_Pain"]."',
Reassessment_VS_Pain_Intensity ='".$_POST["Reassessment_VS_Pain_Intensity"]."',
Reassessment_VS_Pain_Intensity_type ='".$_POST["Reassessment_VS_Pain_Intensity_type"]."',
Reassessment_HR_Needs_assistance ='".$_POST["Reassessment_HR_Needs_assistance"]."',
Reassessment_HR_Unable_to_leave_home ='".$_POST["Reassessment_HR_Unable_to_leave_home"]."',
Reassessment_HR_Medical_Restrictions ='".$_POST["Reassessment_HR_Medical_Restrictions"]."',
Reassessment_HR_Medical_Restrictions_In ='".$_POST["Reassessment_HR_Medical_Restrictions_In"]."',
Reassessment_HR_SOB_upon_exertion ='".$_POST["Reassessment_HR_SOB_upon_exertion"]."',
Reassessment_HR_Pain_with_Travel ='".$_POST["Reassessment_HR_Pain_with_Travel"]."',
Reassessment_HR_Requires_assistance ='".$_POST["Reassessment_HR_Requires_assistance"]."',
Reassessment_HR_Arrhythmia ='".$_POST["Reassessment_HR_Arrhythmia"]."',
Reassessment_HR_Bed_Bound ='".$_POST["Reassessment_HR_Bed_Bound"]."',
Reassessment_HR_Residual_Weakness ='".$_POST["Reassessment_HR_Residual_Weakness"]."',
Reassessment_HR_Confusion ='".$_POST["Reassessment_HR_Confusion"]."',
Reassessment_HR_Multiple_stairs_enter_exit_home ='".$_POST["Reassessment_HR_Multiple_stairs_enter_exit_home"]."',
Reassessment_HR_Other ='".$_POST["Reassessment_HR_Other"]."',
Reassessment_TREATMENT_DX_Problem ='".$_POST["Reassessment_TREATMENT_DX_Problem"]."',
Reassessment_ADL_Rolling_Initial_Status ='".$_POST["Reassessment_ADL_Rolling_Initial_Status"]."',
Reassessment_ADL_Rolling_Current_Status ='".$_POST["Reassessment_ADL_Rolling_Current_Status"]."',
Reassessment_ADL_Rolling_Describe_Mobility_Skills ='".$_POST["Reassessment_ADL_Rolling_Describe_Mobility_Skills"]."',
Reassessment_ADL_Supine_Sit_Initial_Status ='".$_POST["Reassessment_ADL_Supine_Sit_Initial_Status"]."',
Reassessment_ADL_Supine_Sit_Current_Status ='".$_POST["Reassessment_ADL_Supine_Sit_Current_Status"]."',
Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills ='".$_POST["Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills"]."',
Reassessment_ADL_Sit_Stand_Initial_Status ='".$_POST["Reassessment_ADL_Sit_Stand_Initial_Status"]."',
Reassessment_ADL_Sit_Stand_Current_Status ='".$_POST["Reassessment_ADL_Sit_Stand_Current_Status"]."',
Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills ='".$_POST["Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills"]."',
Reassessment_ADL_Transfers_Initial_Status ='".$_POST["Reassessment_ADL_Transfers_Initial_Status"]."',
Reassessment_ADL_Transfers_Current_Status ='".$_POST["Reassessment_ADL_Transfers_Current_Status"]."',
Reassessment_ADL_Transfers_Describe_Mobility_Skills ='".$_POST["Reassessment_ADL_Transfers_Describe_Mobility_Skills"]."',
Reassessment_ADL_Fall_Recovery_Initial_Status ='".$_POST["Reassessment_ADL_Fall_Recovery_Initial_Status"]."',
Reassessment_ADL_Fall_Recovery_Current_Status ='".$_POST["Reassessment_ADL_Fall_Recovery_Current_Status"]."',
Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills ='".$_POST["Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills"]."',
Reassessment_ADL_Gait_Assistance_Initial_Status ='".$_POST["Reassessment_ADL_Gait_Assistance_Initial_Status"]."',
Reassessment_ADL_Gait_Assistance_Current_Status ='".$_POST["Reassessment_ADL_Gait_Assistance_Current_Status"]."',
Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills ='".$_POST["Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills"]."',
Reassessment_ADL_WC_Assistance_Initial_Status ='".$_POST["Reassessment_ADL_WC_Assistance_Initial_Status"]."',
Reassessment_ADL_WC_Assistance_Current_Status ='".$_POST["Reassessment_ADL_WC_Assistance_Current_Status"]."',
Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills ='".$_POST["Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills"]."',
Reassessment_Mobility_Reassessment_NA ='".$_POST["Reassessment_Mobility_Reassessment_NA"]."',
Reassessment_Assistive_Devices ='".$_POST["Reassessment_Assistive_Devices"]."',
Reassessment_Assistive_Devices_Other ='".$_POST["Reassessment_Assistive_Devices_Other"]."',
Reassessment_Timed_Up_Go_Score ='".$_POST["Reassessment_Timed_Up_Go_Score"]."',
Reassessment_Interpretation_Risk_Types ='".$_POST["Reassessment_Interpretation_Risk_Types"]."',
Reassessment_Other_Interpretations ='".$_POST["Reassessment_Other_Interpretations"]."',
Reassessment_Interpretation_NA ='".$_POST["Reassessment_Interpretation_NA"]."',
Reassessment_Problems_Achieving_Goals ='".$_POST["Reassessment_Problems_Achieving_Goals"]."',
Reassessment_MS_ENDURANCE_Initial ='".$_POST["Reassessment_MS_ENDURANCE_Initial"]."',
Reassessment_MS_ENDURANCE_Current ='".$_POST["Reassessment_MS_ENDURANCE_Current"]."',
Reassessment_MS_SAFETY_AWARENESS_Initial ='".$_POST["Reassessment_MS_SAFETY_AWARENESS_Initial"]."',
Reassessment_MS_SAFETY_AWARENESS_Current ='".$_POST["Reassessment_MS_SAFETY_AWARENESS_Current"]."',
Reassessment_MS_SITTING_BALANCE_Initial_S ='".$_POST["Reassessment_MS_SITTING_BALANCE_Initial_S"]."',
Reassessment_MS_SITTING_BALANCE_Initial_D ='".$_POST["Reassessment_MS_SITTING_BALANCE_Initial_D"]."',
Reassessment_MS_SITTING_BALANCE_Current_S ='".$_POST["Reassessment_MS_SITTING_BALANCE_Current_S"]."',
Reassessment_MS_SITTING_BALANCE_Current_D ='".$_POST["Reassessment_MS_SITTING_BALANCE_Current_D"]."',
Reassessment_MS_STANDING_BALANCE_Initial_S ='".$_POST["Reassessment_MS_STANDING_BALANCE_Initial_S"]."',
Reassessment_MS_STANDING_BALANCE_Initial_D ='".$_POST["Reassessment_MS_STANDING_BALANCE_Initial_D"]."',
Reassessment_MS_STANDING_BALANCE_Current_S ='".$_POST["Reassessment_MS_STANDING_BALANCE_Current_S"]."',
Reassessment_MS_STANDING_BALANCE_Current_D ='".$_POST["Reassessment_MS_STANDING_BALANCE_Current_D"]."',
Reassessment_Miscellaneous_NA ='".$_POST["Reassessment_Miscellaneous_NA"]."',
Reassessment_Problems_Achieving_Goals_With ='".$_POST["Reassessment_Problems_Achieving_Goals_With"]."',
Reassessment_Problems_Achieving_Goals_With_Notes ='".$_POST["Reassessment_Problems_Achieving_Goals_With_Notes"]."',
Reassessment_MS_ROM_All_Muscle_WFL ='".$_POST["Reassessment_MS_ROM_All_Muscle_WFL"]."',
Reassessment_MS_ROM_ALL_ROM_WFL ='".$_POST["Reassessment_MS_ROM_ALL_ROM_WFL"]."',
Reassessment_MS_ROM_Following_Problem_areas ='".$_POST["Reassessment_MS_ROM_Following_Problem_areas"]."',
Reassessment_MS_ROM_Following_Problem_areas_Notes ='".$_POST["Reassessment_MS_ROM_Following_Problem_areas_Notes"]."',
Reassessment_MS_ROM_Problemarea_text ='".$_POST["Reassessment_MS_ROM_Problemarea_text"]."',
Reassessment_MS_ROM_STRENGTH_Right ='".$_POST["Reassessment_MS_ROM_STRENGTH_Right"]."',
Reassessment_MS_ROM_STRENGTH_Left ='".$_POST["Reassessment_MS_ROM_STRENGTH_Left"]."',	
Reassessment_MS_ROM_ROM ='".$_POST["Reassessment_MS_ROM_ROM"]."',
Reassessment_MS_ROM_ROM_Type ='".$_POST["Reassessment_MS_ROM_ROM_Type"]."',
Reassessment_MS_ROM_Tonicity ='".$_POST["Reassessment_MS_ROM_Tonicity"]."',
Reassessment_MS_ROM_Further_description ='".$_POST["Reassessment_MS_ROM_Further_description"]."',
Reassessment_MS_ROM_Problemarea_text1 ='".$_POST["Reassessment_MS_ROM_Problemarea_text1"]."',
Reassessment_MS_ROM_STRENGTH_Right1 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Right1"]."',
Reassessment_MS_ROM_STRENGTH_Left1 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Left1"]."',
Reassessment_MS_ROM_ROM1 ='".$_POST["Reassessment_MS_ROM_ROM1"]."',
Reassessment_MS_ROM_ROM_Type1 ='".$_POST["Reassessment_MS_ROM_ROM_Type1"]."',
Reassessment_MS_ROM_Tonicity1 ='".$_POST["Reassessment_MS_ROM_Tonicity1"]."',
Reassessment_MS_ROM_Further_description1 ='".$_POST["Reassessment_MS_ROM_Further_description1"]."',
Reassessment_MS_ROM_Problemarea_text2 ='".$_POST["Reassessment_MS_ROM_Problemarea_text2"]."',
Reassessment_MS_ROM_STRENGTH_Right2 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Right2"]."',
Reassessment_MS_ROM_STRENGTH_Left2 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Left2"]."',
Reassessment_MS_ROM_ROM2 ='".$_POST["Reassessment_MS_ROM_ROM2"]."',
Reassessment_MS_ROM_ROM_Type2 ='".$_POST["Reassessment_MS_ROM_ROM_Type2"]."',
Reassessment_MS_ROM_Tonicity2 ='".$_POST["Reassessment_MS_ROM_Tonicity2"]."',
Reassessment_MS_ROM_Problemarea_text3 ='".$_POST["Reassessment_MS_ROM_Problemarea_text3"]."',
Reassessment_MS_ROM_STRENGTH_Right3 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Right3"]."',
Reassessment_MS_ROM_STRENGTH_Left3 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Left3"]."',
Reassessment_MS_ROM_ROM3 ='".$_POST["Reassessment_MS_ROM_ROM3"]."',
Reassessment_MS_ROM_ROM_Type3 ='".$_POST["Reassessment_MS_ROM_ROM_Type3"]."',
Reassessment_MS_ROM_Tonicity3 ='".$_POST["Reassessment_MS_ROM_Tonicity3"]."',
Reassessment_MS_ROM_Problemarea_text4 ='".$_POST["Reassessment_MS_ROM_Problemarea_text4"]."',
Reassessment_MS_ROM_STRENGTH_Right4 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Right4"]."',
Reassessment_MS_ROM_STRENGTH_Left4 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Left4"]."',
Reassessment_MS_ROM_ROM4 ='".$_POST["Reassessment_MS_ROM_ROM4"]."',
Reassessment_MS_ROM_ROM_Type4 ='".$_POST["Reassessment_MS_ROM_ROM_Type4"]."',
Reassessment_MS_ROM_Tonicity4 ='".$_POST["Reassessment_MS_ROM_Tonicity4"]."',
Reassessment_MS_ROM_Problemarea_text5 ='".$_POST["Reassessment_MS_ROM_Problemarea_text5"]."',
Reassessment_MS_ROM_STRENGTH_Right5 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Right5"]."',
Reassessment_MS_ROM_STRENGTH_Left5 ='".$_POST["Reassessment_MS_ROM_STRENGTH_Left5"]."',
Reassessment_MS_ROM_ROM5 ='".$_POST["Reassessment_MS_ROM_ROM5"]."',
Reassessment_MS_ROM_ROM_Type5 ='".$_POST["Reassessment_MS_ROM_ROM_Type5"]."',
Reassessment_MS_ROM_Tonicity5 ='".$_POST["Reassessment_MS_ROM_Tonicity5"]."',
Reassessment_MS_ROM_NA ='".$_POST["Reassessment_MS_ROM_NA"]."',
Reassessment_MS_ROM_Problems_Achieving_Goals_Type ='".$_POST["Reassessment_MS_ROM_Problems_Achieving_Goals_Type"]."',
Reassessment_MS_ROM_Problems_Achieving_Goals_Note ='".$_POST["Reassessment_MS_ROM_Problems_Achieving_Goals_Note"]."',
Reassessment_Environmental_Barriers ='".$_POST["Reassessment_Environmental_Barriers"]."',
Reassessment_Environmental_Issues_Notes ='".$_POST["Reassessment_Environmental_Issues_Notes"]."',
Reassessment_RO_Patient_Prior_Level_Function ='".$_POST["Reassessment_RO_Patient_Prior_Level_Function"]."',
Reassessment_RO_Prior_Level_Function_Not_Reached='".$_POST["Reassessment_RO_Prior_Level_Function_Not_Reached"]."',
Reassessment_RO_Patient_Long_Term_Goals ='".$_POST["Reassessment_RO_Patient_Long_Term_Goals"]."',
Reassessment_RO_Long_Term_Goal_Not_Reached='".$_POST["Reassessment_RO_Long_Term_Goal_Not_Reached"]."',
Reassessment_Skilled_PT_Reasonable_And_Necessary_To ='".$_POST["Reassessment_Skilled_PT_Reasonable_And_Necessary_To"]."',
Reassessment_Skilled_PT_Other ='".$_POST["Reassessment_Skilled_PT_Other"]."',
Reassessment_Goals_Changed_Adapted_For_Mobility ='".$_POST["Reassessment_Goals_Changed_Adapted_For_Mobility"]."',
Reassessment_Goals_Changed_Adapted_For_Mobility1 ='".$_POST["Reassessment_Goals_Changed_Adapted_For_Mobility1"]."',
Reassessment_Goals_Changed_Adapted_For_Other ='".$_POST["Reassessment_Goals_Changed_Adapted_For_Other"]."',
Reassessment_Goals_Changed_Adapted_For_Other1 ='".$_POST["Reassessment_Goals_Changed_Adapted_For_Other1"]."',
Reassessment_PT_communicated_and_agreed_upon_by ='".$_POST["Reassessment_PT_communicated_and_agreed_upon_by"]."',
Reassessment_PT_communicated_and_agreed_upon_by_Others ='".$_POST["Reassessment_PT_communicated_and_agreed_upon_by_Others"]."',
Reassessment_AS_Home_Exercise ='".$_POST["Reassessment_AS_Home_Exercise"]."',
Reassessment_AS_Falls_Management_Prevention ='".$_POST["Reassessment_AS_Falls_Management_Prevention"]."',
Reassessment_AS_Recommendations_for_SafetyIssues ='".$_POST["Reassessment_AS_Recommendations_for_SafetyIssues"]."',
Reassessment_AS_Recommendations_for_SafetyIssues_Notes ='".$_POST["Reassessment_AS_Recommendations_for_SafetyIssues_Notes"]."',
Reassessment_AS_Treatment ='".$_POST["Reassessment_AS_Treatment"]."',
Reassessment_AS_Treatment_for ='".$_POST["Reassessment_AS_Treatment_for"]."',
Reassessment_Other_Services_Provided ='".$_POST["Reassessment_Other_Services_Provided"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
