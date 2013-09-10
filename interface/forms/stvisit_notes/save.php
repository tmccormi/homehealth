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
$newid = formSubmit("forms_st_visitnote", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "ST Visit Notes", $newid, "stvisit_notes", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

sqlInsert("update forms_st_visitnote set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
visitnote_Time_In ='".$_POST["visitnote_Time_In"]."',
visitnote_Time_Out ='".$_POST["visitnote_Time_Out"]."',
visitnote_visitdate ='".$_POST["visitnote_visitdate"]."',
visitnote_Type_of_Visit ='".$_POST["visitnote_Type_of_Visit"]."',
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
visitnote_VS_Pain ='".$_POST["visitnote_VS_Pain"]."',
visitnote_VS_Pain_paintype ='".$_POST["visitnote_VS_Pain_paintype"]."',
visitnote_VS_Pain_Intensity ='".$_POST["visitnote_VS_Pain_Intensity"]."',
visitnote_VS_Pain_Location ='".$_POST["visitnote_VS_Pain_Location"]."',
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
visitnote_Pat_Homebound_Other ='".$_POST["visitnote_Pat_Homebound_Other"]."',
visitnote_Interventions ='".$_POST["visitnote_Interventions"]."',
visitnote_Interventions_Other ='".$_POST["visitnote_Interventions_Other"]."',
visitnote_Evaluation ='".$_POST["visitnote_Evaluation"]."',
visitnote_Dysphagia_Compensatory ='".$_POST["visitnote_Dysphagia_Compensatory"]."',
visitnote_Swallow_Exercise ='".$_POST["visitnote_Swallow_Exercise"]."',
visitnote_Safety_Training ='".$_POST["visitnote_Safety_Training"]."',
visitnote_Cognitive_Impairment ='".$_POST["visitnote_Cognitive_Impairment"]."',
visitnote_Communication_Strategies ='".$_POST["visitnote_Communication_Strategies"]."',
visitnote_Cognitive_Compensatory ='".$_POST["visitnote_Cognitive_Compensatory"]."',
visitnote_Patient_Caregiver_Family_Education ='".$_POST["visitnote_Patient_Caregiver_Family_Education"]."',
visitnote_Other1 ='".$_POST["visitnote_Other1"]."',
visitnote_Specific_Training_Visit ='".$_POST["visitnote_Specific_Training_Visit"]."',
visitnote_changes_in_medications ='".$_POST["visitnote_changes_in_medications"]."',
visitnote_Improved_Oral_Stage ='".$_POST["visitnote_Improved_Oral_Stage"]."',
visitnote_Improved_Oral_Stage_In ='".$_POST["visitnote_Improved_Oral_Stage_In"]."',
visitnote_Improved_Pharyngeal_Stage ='".$_POST["visitnote_Improved_Pharyngeal_Stage"]."',
visitnote_Improved_Pharyngeal_Stage_In ='".$_POST["visitnote_Improved_Pharyngeal_Stage_In"]."',
visitnote_Improved_Verbal_Expression ='".$_POST["visitnote_Improved_Verbal_Expression"]."',
visitnote_Improved_Verbal_Expression_In ='".$_POST["visitnote_Improved_Verbal_Expression_In"]."',
visitnote_Improved_Non_Verbal_Expression ='".$_POST["visitnote_Improved_Non_Verbal_Expression"]."',
visitnote_Improved_Non_Verbal_Expression_In ='".$_POST["visitnote_Improved_Non_Verbal_Expression_In"]."',
visitnote_Improved_Comprehension ='".$_POST["visitnote_Improved_Comprehension"]."',
visitnote_Improved_Comprehension_In ='".$_POST["visitnote_Improved_Comprehension_In"]."',
visitnote_Caregiver_Family_Performance ='".$_POST["visitnote_Caregiver_Family_Performance"]."',
visitnote_Caregiver_Family_Performance_In ='".$_POST["visitnote_Caregiver_Family_Performance_In"]."',
visitnote_Functional_Improvements_Other ='".$_POST["visitnote_Functional_Improvements_Other"]."',
visitnote_Functional_Improvements_Other_Note ='".$_POST["visitnote_Functional_Improvements_Other_Note"]."',
visitnote_FI_Additional_Comments ='".$_POST["visitnote_FI_Additional_Comments"]."',
visitnote_Response_To_Visit ='".$_POST["visitnote_Response_To_Visit"]."',
visitnote_Response_To_Visit_Other ='".$_POST["visitnote_Response_To_Visit_Other"]."',
visitnote_Discharge_Discussed ='".$_POST["visitnote_Discharge_Discussed"]."',
visitnote_Discharge_Discussed_With ='".$_POST["visitnote_Discharge_Discussed_With"]."',
visitnote_CPRW_Other ='".$_POST["visitnote_CPRW_Other"]."',
visitnote_CarePlan_Modifications ='".$_POST["visitnote_CarePlan_Modifications"]."',
visitnote_CarePlan_Modifications_Include ='".$_POST["visitnote_CarePlan_Modifications_Include"]."',
visitnote_further_Visit_Required_text ='".$_POST["visitnote_further_Visit_Required_text"]."',
visitnote_Further_Skilled_Visits_Required ='".$_POST["visitnote_Further_Skilled_Visits_Required"]."',
visitnote_Train_patient_Suchas_Notes ='".$_POST["visitnote_Train_patient_Suchas_Notes"]."',
visitnote_FSVR_Other ='".$_POST["visitnote_FSVR_Other"]."',
visitnote_Date_of_Next_Visit ='".$_POST["visitnote_Date_of_Next_Visit"]."',
visitnote_Plan_Type ='".$_POST["visitnote_Plan_Type"]."',
visitnote_Long_Term_Outcomes_Due_To ='".$_POST["visitnote_Long_Term_Outcomes_Due_To"]."',
visitnote_Address_Above_Issues_By ='".$_POST["visitnote_Address_Above_Issues_By"]."',
visitnote_Therapist_Signature ='".$_POST["visitnote_Therapist_Signature"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>
