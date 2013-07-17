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
$newid = formSubmit("forms_st_Reassessment", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "ST Reassessment", $newid, "streassessment", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

sqlInsert("update forms_st_Reassessment set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
Reassessment_visit_type='".$_POST["Reassessment_visit_type"]."',
Reassessment_Time_In='".$_POST["Reassessment_Time_In"]."',
Reassessment_Time_Out='".$_POST["Reassessment_Time_Out"]."',
Reassessment_date ='".$_POST["Reassessment_date"]."',
Reassessment_Pulse ='".$_POST["Reassessment_Pulse"]."',
Reassessment_Pulse_State='".$_POST["Reassessment_Pulse_State"]."',
Reassessment_Temperature ='".$_POST["Reassessment_Temperature"]."',
Reassessment_Temperature_type='".$_POST["Reassessment_Temperature_type"]."',
Reassessment_VS_other ='".$_POST["Reassessment_VS_other"]."',
Reassessment_VS_Respirations ='".$_POST["Reassessment_VS_Respirations"]."',
Reassessment_VS_BP_Systolic='".$_POST["Reassessment_VS_BP_Systolic"]."',
Reassessment_VS_BP_Diastolic='".$_POST["Reassessment_VS_BP_Diastolic"]."',
Reassessment_VS_BP_side='".$_POST["Reassessment_VS_BP_side"]."',
Reassessment_VS_BP_Body_Position='".$_POST["Reassessment_VS_BP_Body_Position"]."',
Reassessment_VS_Sat='".$_POST["Reassessment_VS_Sat"]."',
Reassessment_VS_Pain ='".$_POST["Reassessment_VS_Pain"]."',
Reassessment_VS_Pain_Intensity='".$_POST["Reassessment_VS_Pain_Intensity"]."',
Reassessment_VS_Pain_Intensity_type='".$_POST["Reassessment_VS_Pain_Intensity_type"]."',
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
Reassessment_HR_Other='".$_POST["Reassessment_HR_Other"]."',
Reassessment_SDL_Oral_Stage_Initial_Status ='".$_POST["Reassessment_SDL_Oral_Stage_Initial_Status"]."',
Reassessment_SDL_Oral_Stage_Current_Status ='".$_POST["Reassessment_SDL_Oral_Stage_Current_Status"]."',
Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills ='".$_POST["Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills"]."',
Reassessment_SDL_Pharyngeal_Stage_Initial_Status ='".$_POST["Reassessment_SDL_Pharyngeal_Stage_Initial_Status"]."',
Reassessment_SDL_Pharyngeal_Stage_Current_Status ='".$_POST["Reassessment_SDL_Pharyngeal_Stage_Current_Status"]."',
Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills ='".$_POST["Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills"]."',
Reassessment_SDL_Space1_Initial_Status ='".$_POST["Reassessment_SDL_Space1_Initial_Status"]."',
Reassessment_SDL_Space1_Current_Status ='".$_POST["Reassessment_SDL_Space1_Current_Status"]."',
Reassessment_SDL_Space1_Describe_Mobility_Skills ='".$_POST["Reassessment_SDL_Space1_Describe_Mobility_Skills"]."',
Reassessment_SDL_Verbal_Expression_Initial_Status ='".$_POST["Reassessment_SDL_Verbal_Expression_Initial_Status"]."',
Reassessment_SDL_Verbal_Expression_Current_Status ='".$_POST["Reassessment_SDL_Verbal_Expression_Current_Status"]."',
Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills ='".$_POST["Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills"]."',
Reassessment_SDL_NonVerbal_Expression_Initial_Status ='".$_POST["Reassessment_SDL_NonVerbal_Expression_Initial_Status"]."',
Reassessment_SDL_NonVerbal_Expression_Current_Status ='".$_POST["Reassessment_SDL_NonVerbal_Expression_Current_Status"]."',
Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills ='".$_POST["Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills"]."',
Reassessment_SDL_Auditory_Comprehension_Initial_Status ='".$_POST["Reassessment_SDL_Auditory_Comprehension_Initial_Status"]."',
Reassessment_SDL_Auditory_Comprehension_Current_Status ='".$_POST["Reassessment_SDL_Auditory_Comprehension_Current_Status"]."',
Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills ='".$_POST["Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills"]."',
Reassessment_SDL_Speech_Intelligibility_Initial_Status ='".$_POST["Reassessment_SDL_Speech_Intelligibility_Initial_Status"]."',
Reassessment_SDL_Speech_Intelligibility_Current_Status ='".$_POST["Reassessment_SDL_Speech_Intelligibility_Current_Status"]."',
Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills ='".$_POST["Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills"]."',
Reassessment_SDL_Space2_Initial_Status ='".$_POST["Reassessment_SDL_Space2_Initial_Status"]."',
Reassessment_SDL_Space2_Current_Status ='".$_POST["Reassessment_SDL_Space2_Current_Status"]."',
Reassessment_SDL_Space2_Describe_Mobility_Skills ='".$_POST["Reassessment_SDL_Space2_Describe_Mobility_Skills"]."',
Reassessment_Dysphagia_Review_NA='".$_POST["Reassessment_Dysphagia_Review_NA"]."',
Reassessment_Speech_Language_Dysphagia_Issues='".$_POST["Reassessment_Speech_Language_Dysphagia_Issues"]."',
Reassessment_Skills_SAFETY_AWARENESS='".$_POST["Reassessment_Skills_SAFETY_AWARENESS"]."',
Reassessment_Skills_ATTENTION_SPAN='".$_POST["Reassessment_Skills_ATTENTION_SPAN"]."',
Reassessment_Skills_SHORTTERM_MEMORY='".$_POST["Reassessment_Skills_SHORTTERM_MEMORY"]."',
Reassessment_Skills_LONGTERM_MEMORY='".$_POST["Reassessment_Skills_LONGTERM_MEMORY"]."',
Reassessment_COMPENSATORY_SKILLS_NA='".$_POST["Reassessment_COMPENSATORY_SKILLS_NA"]."',
Reassessment_CS_Problems_Achieving_Goals_With='".$_POST["Reassessment_CS_Problems_Achieving_Goals_With"]."',
Reassessment_RO_Patient_Prior_Level_Function ='".$_POST["Reassessment_RO_Patient_Prior_Level_Function"]."',
Reassessment_Prior_Level_Function_Not_Reached='".$_POST["Reassessment_Prior_Level_Function_Not_Reached"]."',
Reassessment_RO_Patient_Long_Term_Goals ='".$_POST["Reassessment_RO_Patient_Long_Term_Goals"]."',
Reassessment_Long_Term_Goals_Not_Reached='".$_POST["Reassessment_Long_Term_Goals_Not_Reached"]."',
Reassessment_Skilled_ST_Reasonable_And_Necessary_To ='".$_POST["Reassessment_Skilled_ST_Reasonable_And_Necessary_To"]."',
Reassessment_Skilled_ST_Compensatory_Strategies_Note='".$_POST["Reassessment_Skilled_ST_Compensatory_Strategies_Note"]."',
Reassessment_Skilled_ST_Learning_New_Skills='".$_POST["Reassessment_Skilled_ST_Learning_New_Skills"]."',
Reassessment_Skilled_ST_Other ='".$_POST["Reassessment_Skilled_ST_Other"]."',
Reassessment_Goals_Changed_Adapted_For_Dysphagia='".$_POST["Reassessment_Goals_Changed_Adapted_For_Dysphagia"]."',
Reassessment_Goals_Changed_Adapted_For_Communication='".$_POST["Reassessment_Goals_Changed_Adapted_For_Communication"]."',
Reassessment_Goals_Changed_Adapted_For_Cognition='".$_POST["Reassessment_Goals_Changed_Adapted_For_Cognition"]."',
Reassessment_Goals_Changed_Adapted_For_Other='".$_POST["Reassessment_Goals_Changed_Adapted_For_Other"]."',
Reassessment_ST_communicated_and_agreed_upon_by='".$_POST["Reassessment_ST_communicated_and_agreed_upon_by"]."',
Reassessment_ST_communicated_and_agreed_upon_by_other ='".$_POST["Reassessment_ST_communicated_and_agreed_upon_by_other"]."',
Reassessment_AS_Compensatory_Swallow_Program='".$_POST["Reassessment_AS_Compensatory_Swallow_Program"]."',
Reassessment_AS_Recommendations_for_Communication='".$_POST["Reassessment_AS_Recommendations_for_Communication"]."',
Reassessment_AS_Recommendations_for_Cognitive='".$_POST["Reassessment_AS_Recommendations_for_Cognitive"]."',
Reassessment_AS_Treatment='".$_POST["Reassessment_AS_Treatment"]."',
Reassessment_AS_Treatment_for='".$_POST["Reassessment_AS_Treatment_for"]."',
Reassessment_Other_Services_Provided='".$_POST["Reassessment_Other_Services_Provided"]."',
Reassessment_ADDITIONAL_COMMENTS ='".$_POST["Reassessment_ADDITIONAL_COMMENTS"]."',
Reassessment_Therapist_Who_Provided_Reassessment ='".$_POST["Reassessment_Therapist_Who_Provided_Reassessment"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
