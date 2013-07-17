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
$newid = formSubmit("forms_pt_visitnote", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "PT Visit Notes", $newid, "ptvisit_notes", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

sqlInsert("update forms_pt_visitnote set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
visitnote_Time_In ='".$_POST["visitnote_Time_In"]."',
visitnote_Time_Out  ='".$_POST["visitnote_Time_Out"]."',
visitnote_visitdate ='".$_POST["visitnote_visitdate"]."',
visitnote_Type_of_Visit  ='".$_POST["visitnote_Type_of_Visit"]."',
visitnote_Type_of_Visit_Other ='".$_POST["visitnote_Type_of_Visit_Other"]."',
visitnote_VS_Pulse ='".$_POST["visitnote_VS_Pulse"]."',
visitnote_VS_Pulse_type ='".$_POST["visitnote_VS_Pulse_type"]."',
visitnote_VS_Temperature ='".$_POST["visitnote_VS_Temperature"]."',
visitnote_VS_Temperature_type ='".$_POST["visitnote_VS_Temperature_type"]."',
visitnote_VS_Other ='".$_POST["visitnote_VS_Other"]."',
visitnote_VS_Respirations ='".$_POST["visitnote_VS_Respirations"]."',
visitnote_VS_BP_Systolic ='".$_POST["visitnote_VS_BP_Systolic"]."',
visitnote_VS_BP_Diastolic ='".$_POST["visitnote_VS_BP_Diastolic"]."',
visitnote_VS_BP_side ='".$_POST["visitnote_VS_BP_side"]."',
visitnote_VS_BP_Position ='".$_POST["visitnote_VS_BP_Position"]."',
visitnote_VS_BP_Sat ='".$_POST["visitnote_VS_BP_Sat"]."',
visitnote_VS_Pain_paintype ='".$_POST["visitnote_VS_Pain_paintype"]."',
visitnote_VS_Pain_Intensity ='".$_POST["visitnote_VS_Pain_Intensity"]."',
visitnote_VS_Pain_Level ='".$_POST["visitnote_VS_Pain_Level"]."',
visitnote_Treatment_Diagnosis_Problem ='".$_POST["visitnote_Treatment_Diagnosis_Problem"]."',
visitnote_Pat_Homebound_Needs_assistance ='".$_POST["visitnote_Pat_Homebound_Needs_assistance"]."',
visitnote_Pat_Homebound_Unable_leave_home ='".$_POST["visitnote_Pat_Homebound_Unable_leave_home"]."',
visitnote_Pat_Homebound_Medical_Restrictions ='".$_POST["visitnote_Pat_Homebound_Medical_Restrictions"]."',
visitnote_Pat_Homebound_Medical_Restrictions_In ='".$_POST["visitnote_Pat_Homebound_Medical_Restrictions_In"]."',
visitnote_Pat_Homebound_SOB_upon_exertion ='".$_POST["visitnote_Pat_Homebound_SOB_upon_exertion"]."',
visitnote_Pat_Homebound_Pain_with_Travel ='".$_POST["visitnote_Pat_Homebound_Pain_with_Travel"]."',
visitnote_Pat_Homebound_mobility_ambulation ='".$_POST["visitnote_Pat_Homebound_mobility_ambulation"]."',
visitnote_Pat_Homebound_Arrhythmia ='".$_POST["visitnote_Pat_Homebound_Arrhythmia"]."',
visitnote_Pat_Homebound_Bed_Bound ='".$_POST["visitnote_Pat_Homebound_Bed_Bound"]."',
visitnote_Pat_Homebound_Residual_Weakness ='".$_POST["visitnote_Pat_Homebound_Residual_Weakness"]."',
visitnote_Pat_Homebound_Confusion ='".$_POST["visitnote_Pat_Homebound_Confusion"]."',
visitnote_Pat_Homebound_Other='".$_POST["visitnote_Pat_Homebound_Other"]."',
visitnote_Interventions ='".$_POST["visitnote_Interventions"]."',
visitnote_Interventions_Other ='".$_POST["visitnote_Interventions_Other"]."',
visitnote_Evaluation ='".$_POST["visitnote_Evaluation"]."',
visitnote_Therapeutic_Exercises ='".$_POST["visitnote_Therapeutic_Exercises"]."',
visitnote_Gait_Training ='".$_POST["visitnote_Gait_Training"]."',
visitnote_Bed_Mobility ='".$_POST["visitnote_Bed_Mobility"]."',
visitnote_Training_Transfer ='".$_POST["visitnote_Training_Transfer"]."',
visitnote_Balance_Training_Activities ='".$_POST["visitnote_Balance_Training_Activities"]."',
visitnote_Patient_Caregiver_Family_Education ='".$_POST["visitnote_Patient_Caregiver_Family_Education"]."',
visitnote_Assistive_Device_Training ='".$_POST["visitnote_Assistive_Device_Training"]."',
visitnote_Neuro_developmental_Training ='".$_POST["visitnote_Neuro_developmental_Training"]."',
visitnote_Orthotics_Splinting ='".$_POST["visitnote_Orthotics_Splinting"]."',
visitnote_Hip_Safety_Precaution_Training ='".$_POST["visitnote_Hip_Safety_Precaution_Training"]."',
visitnote_Physical_Agents ='".$_POST["visitnote_Physical_Agents"]."',
visitnote_Physical_Agents_For ='".$_POST["visitnote_Physical_Agents_For"]."',	
visitnote_Muscle_ReEducation ='".$_POST["visitnote_Muscle_ReEducation"]."', 
visitnote_Safe_Stair_Climbing_Skills ='".$_POST["visitnote_Safe_Stair_Climbing_Skills"]."',
visitnote_Exercises_to_manage_pain ='".$_POST["visitnote_Exercises_to_manage_pain"]."',
visitnote_Fall_Precautions_Training ='".$_POST["visitnote_Fall_Precautions_Training"]."',
visitnote_Exercises_Safety_Techniques ='".$_POST["visitnote_Exercises_Safety_Techniques"]."',
visitnote_Other1 ='".$_POST["visitnote_Other1"]."',
visitnote_Specific_Training_Visit ='".$_POST["visitnote_Specific_Training_Visit"]."',
visitnote_changes_in_medications ='".$_POST["visitnote_changes_in_medications"]."',
visitnote_FI_Mobility ='".$_POST["visitnote_FI_Mobility"]."',
visitnote_FI_ROM ='".$_POST["visitnote_FI_ROM"]."',
visitnote_FI_ROM_In ='".$_POST["visitnote_FI_ROM_In"]."',
visitnote_FI_Home_Safety_Techniques ='".$_POST["visitnote_FI_Home_Safety_Techniques"]."',
visitnote_FI_Home_Safety_Techniques_In ='".$_POST["visitnote_FI_Home_Safety_Techniques_In"]."',
visitnote_FI_Assistive_Device_Usage ='".$_POST["visitnote_FI_Assistive_Device_Usage"]."',
visitnote_FI_Assistive_Device_Usage_With ='".$_POST["visitnote_FI_Assistive_Device_Usage_With"]."',
visitnote_FI_Caregiver_Family_Performance ='".$_POST["visitnote_FI_Caregiver_Family_Performance"]."',
visitnote_FI_Caregiver_Family_Performance_In ='".$_POST["visitnote_FI_Caregiver_Family_Performance_In"]."',
visitnote_FI_Performance_of_Home_Exercises ='".$_POST["visitnote_FI_Performance_of_Home_Exercises"]."',
visitnote_FI_Demonstrates ='".$_POST["visitnote_FI_Demonstrates"]."',
visitnote_FI_Demonstrates_Notes ='".$_POST["visitnote_FI_Demonstrates_Notes"]."',
visitnote_FI_Other ='".$_POST["visitnote_FI_Other"]."',
visitnote_Fall_since_Last_Visit_type ='".$_POST["visitnote_Fall_since_Last_Visit_type"]."',
visitnote_Timed_Up_Go_Score ='".$_POST["visitnote_Timed_Up_Go_Score"]."',
visitnote_Interpretation ='".$_POST["visitnote_Interpretation"]."',
visitnote_Other_Tests_Scores_Interpretations ='".$_POST["visitnote_Other_Tests_Scores_Interpretations"]."',
visitnote_Response_To_Revisit ='".$_POST["visitnote_Response_To_Revisit"]."',
visitnote_Response_To_Revisit_Other ='".$_POST["visitnote_Response_To_Revisit_Other"]."',
visitnote_CarePlan_Reviewed ='".$_POST["visitnote_CarePlan_Reviewed"]."',
visitnote_Discharge_Discussed ='".$_POST["visitnote_Discharge_Discussed"]."',
visitnote_Discharge_Discussed_With ='".$_POST["visitnote_Discharge_Discussed_With"]."',
visitnote_CPRW_Other ='".$_POST["visitnote_CPRW_Other"]."',
visitnote_Careplan_Revised ='".$_POST["visitnote_Careplan_Revised"]."',
visitnote_Careplan_Revised_Notes ='".$_POST["visitnote_Careplan_Revised_Notes"]."',
visitnote_Further_Skilled_Visits_Required ='".$_POST["visitnote_Further_Skilled_Visits_Required"]."',
visitnote_Train_patient_Suchas_Notes ='".$_POST["visitnote_Train_patient_Suchas_Notes"]."',
visitnote_FSVR_IADLs_Notes ='".$_POST["visitnote_FSVR_IADLs_Notes"]."',
visitnote_FSVR_ADLs_Notes ='".$_POST["visitnote_FSVR_ADLs_Notes"]."',
visitnote_FSVR_Other ='".$_POST["visitnote_FSVR_Other"]."',
visitnote_Date_of_Next_Visit ='".$_POST["visitnote_Date_of_Next_Visit"]."',
visitnote_Plan_Type ='".$_POST["visitnote_Plan_Type"]."',
visitnote_Long_Term_Outcomes_Due_To ='".$_POST["visitnote_Long_Term_Outcomes_Due_To"]."',
visitnote_Address_Above_Issues_By ='".$_POST["visitnote_Address_Above_Issues_By"]."',
visitnote_Supervisory_visit ='".$_POST["visitnote_Supervisory_visit"]."',
visitnote_Supervisory_visit_Observed ='".$_POST["visitnote_Supervisory_visit_Observed"]."',
visitnote_Supervisory_visit_Teaching_Training ='".$_POST["visitnote_Supervisory_visit_Teaching_Training"]."',
visitnote_Supervisory_visit_Patient_Family_Discussion ='".$_POST["visitnote_Supervisory_visit_Patient_Family_Discussion"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>
