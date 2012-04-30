<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
foreach ($_POST as $k => $var) {
$_POST[$k] = mysql_escape_string($var);
echo "$var\n";

}
if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_ot_visitnote", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "Visit Notes", $newid, "visit_notes", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_ot_visitnote set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
visitnote_Time_In ='".$_POST["visitnote_Time_In"]."',
visitnote_Time_Out  ='".$_POST["visitnote_Time_Out"]."',
visitnote_date_curr ='".$_POST["visitnote_date_curr"]."',
visitnote_visit_type  ='".$_POST["visitnote_visit_type"]."',
visitnote_TOV_Visit_Other  ='".$_POST["visitnote_TOV_Visit_Other"]."',
visitnote_VS_Pulse ='".$_POST["visitnote_VS_Pulse"]."',
visitnote_Pulse_Rate ='".$_POST["visitnote_Pulse_Rate"]."',
visitnote_VS_Temperature ='".$_POST["visitnote_VS_Temperature"]."',
visitnote_Temperature ='".$_POST["visitnote_Temperature"]."',
visitnote_VS_Other ='".$_POST["visitnote_VS_Other"]."',
visitnote_VS_Respirations ='".$_POST["visitnote_VS_Respirations"]."',
visitnote_VS_BP_Systolic ='".$_POST["visitnote_VS_BP_Systolic"]."',
visitnote_VS_BP_Diastolic ='".$_POST["visitnote_VS_BP_Diastolic"]."',
visitnote_BloodPrerssure_side ='".$_POST["visitnote_BloodPrerssure_side"]."',
visitnote_BloodPrerssure_position ='".$_POST["visitnote_BloodPrerssure_position"]."',
visitnote_VS_BP_Sat ='".$_POST["visitnote_VS_BP_Sat"]."',
visitnote_Pain_Level ='".$_POST["visitnote_Pain_Level"]."',
visitnote_VS_Pain_Intensity ='".$_POST["visitnote_VS_Pain_Intensity"]."',
visitnote_Pain_Intensity ='".$_POST["visitnote_Pain_Intensity"]."',
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
visitnote_Interventions_Patient ='".$_POST["visitnote_Interventions_Patient"]."',
visitnote_Interventions_Caregiver ='".$_POST["visitnote_Interventions_Caregiver"]."',
visitnote_Interventions_Patient_Caregiver ='".$_POST["visitnote_Interventions_Patient_Caregiver"]."',
visitnote_Interventions_Other ='".$_POST["visitnote_Interventions_Other"]."',
visitnote_Home_Safety_Evaluation ='".$_POST["visitnote_Home_Safety_Evaluation"]."',
visitnote_IADL_ADL_Training ='".$_POST["visitnote_IADL_ADL_Training"]."',
visitnote_Muscle_ReEducation ='".$_POST["visitnote_Muscle_ReEducation"]."',
visitnote_Visual_Perceptual_Training ='".$_POST["visitnote_Visual_Perceptual_Training"]."',
visitnote_Fine_Gross_Motor_Training ='".$_POST["visitnote_Fine_Gross_Motor_Training"]."',
visitnote_Patient_Caregiver_Family_Education ='".$_POST["visitnote_Patient_Caregiver_Family_Education"]."',
visitnote_Therapeutic_Exercises ='".$_POST["visitnote_Therapeutic_Exercises"]."',
visitnote_Neuro_developmental_Training ='".$_POST["visitnote_Neuro_developmental_Training"]."',
visitnote_Sensory_Training ='".$_POST["visitnote_Sensory_Training"]."',
visitnote_Orthotics_Splinting ='".$_POST["visitnote_Orthotics_Splinting"]."',
visitnote_Adaptive_Equipment_training ='".$_POST["visitnote_Adaptive_Equipment_training"]."',
visitnote_Teach_Home_Fall_Safety_Precautions ='".$_POST["visitnote_Teach_Home_Fall_Safety_Precautions"]."',
visitnote_Teach_alternative_bathing_skills ='".$_POST["visitnote_Teach_alternative_bathing_skills"]."',
visitnote_Exercises_Safety_Techniques ='".$_POST["visitnote_Exercises_Safety_Techniques"]."',
visitnote_Interventions_Other1 ='".$_POST["visitnote_Interventions_Other1"]."',
visitnote_Specific_Training_Visit ='".$_POST["visitnote_Specific_Training_Visit"]."',
visitnote_changes_in_medications_Yes ='".$_POST["visitnote_changes_in_medications_Yes"]."',
visitnote_changes_in_medications_No ='".$_POST["visitnote_changes_in_medications_No"]."',	
visitnote_Functional_Improvement_ADL ='".$_POST["visitnote_Functional_Improvement_ADL"]."', 
visitnote_Functional_Improvement_ADL_Notes ='".$_POST["visitnote_Functional_Improvement_ADL_Notes"]."',
visitnote_Functional_Improvement_ADL1 ='".$_POST["visitnote_Functional_Improvement_ADL1"]."',
visitnote_Functional_Improvement_ADL1_Notes ='".$_POST["visitnote_Functional_Improvement_ADL1_Notes"]."',
visitnote_Functional_Improvement_IADL ='".$_POST["visitnote_Functional_Improvement_IADL"]."',
visitnote_Functional_Improvement_IADL_Notes ='".$_POST["visitnote_Functional_Improvement_IADL_Notes"]."',
visitnote_Functional_Improvement_IADL1 ='".$_POST["visitnote_Functional_Improvement_IADL1"]."',
visitnote_Functional_Improvement_IADL1_Notes ='".$_POST["visitnote_Functional_Improvement_IADL1_Notes"]."',
visitnote_Functional_Improvement_ROM ='".$_POST["visitnote_Functional_Improvement_ROM"]."',
visitnote_Functional_Improvement_ROM_In ='".$_POST["visitnote_Functional_Improvement_ROM_In"]."',
visitnote_Functional_Improvement_SM ='".$_POST["visitnote_Functional_Improvement_SM"]."',
visitnote_Functional_Improvement_SM_In ='".$_POST["visitnote_Functional_Improvement_SM_In"]."',
visitnote_Functional_Improvement_EA ='".$_POST["visitnote_Functional_Improvement_EA"]."',
visitnote_Functional_Improvement_EA_including ='".$_POST["visitnote_Functional_Improvement_EA_including"]."',
visitnote_Functional_Improvement_AEU ='".$_POST["visitnote_Functional_Improvement_AEU"]."',
visitnote_Functional_Improvement_AEU_For ='".$_POST["visitnote_Functional_Improvement_AEU_For"]."',
visitnote_Functional_Improvement_Car_Fam_Perf ='".$_POST["visitnote_Functional_Improvement_Car_Fam_Perf"]."',
visitnote_Functional_Improvement_Car_Fam_Perf_In ='".$_POST["visitnote_Functional_Improvement_Car_Fam_Perf_In"]."',
visitnote_Functional_Improvement_Perf_Home_Exer ='".$_POST["visitnote_Functional_Improvement_Perf_Home_Exer"]."',
visitnote_Functional_Improvement_Perf_Home_Exer_For ='".$_POST["visitnote_Functional_Improvement_Perf_Home_Exer_For"]."',
visitnote_Functional_Improvement_Other ='".$_POST["visitnote_Functional_Improvement_Other"]."',
visitnote_Previous_fall ='".$_POST["visitnote_Previous_fall"]."',
visitnote_Timed_Up_Go_Score ='".$_POST["visitnote_Timed_Up_Go_Score"]."',
visitnote_Fall_Risk ='".$_POST["visitnote_Fall_Risk"]."',
visitnote_Other_Tests_Scores_Interpretations ='".$_POST["visitnote_Other_Tests_Scores_Interpretations"]."',
visitnote_Response ='".$_POST["visitnote_Response"]."',
visitnote_RT_Revisit_Other ='".$_POST["visitnote_RT_Revisit_Other"]."',
visitnote_CarePlan_Reviewed_With ='".$_POST["visitnote_CarePlan_Reviewed_With"]."',
visitnote_Discharge_Discussed_With ='".$_POST["visitnote_Discharge_Discussed_With"]."',
visitnote_CarePlan_Reviewed_to ='".$_POST["visitnote_CarePlan_Reviewed_to"]."',
visitnote_CPRW_Other ='".$_POST["visitnote_CPRW_Other"]."',
visitnote_CP_Modifications_Include ='".$_POST["visitnote_CP_Modifications_Include"]."',
visitnote_CP_Modifications_Include_Notes ='".$_POST["visitnote_CP_Modifications_Include_Notes"]."',
visitnote_further_Visit_Required ='".$_POST["visitnote_further_Visit_Required"]."',
visitnote_FSVR_Other ='".$_POST["visitnote_FSVR_Other"]."',
visitnote_Date_of_Next_Visit ='".$_POST["visitnote_Date_of_Next_Visit"]."',
visitnote_No_further_visits ='".$_POST["visitnote_No_further_visits"]."',
treatment_Plan ='".$_POST["treatment_Plan"]."',
Additional_Treatment ='".$_POST["Additional_Treatment"]."',
issues_Communication ='".$_POST["issues_Communication"]."',
supervisor_visit ='".$_POST["supervisor_visit"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>
