<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

foreach ($_POST as $k => $var) {
$_POST[$k] = mysql_escape_string($var);
}
if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_ot_visit_discharge_note", $_POST, $_GET["id"],$userauthorized);
addForm($encounter, "Visit Discharge", $newid, "visit_discharge_test", $pid, $userauthorized);

 }
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_ot_visit_discharge_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1,date = NOW(), 
dischargeplan_Time_In='".$_POST["dischargeplan_Time_In"]."',
dischargeplan_Time_Out='".$_POST["dischargeplan_Time_Out"]."',
dischargeplan_date='".$_POST["dischargeplan_date"]."',
dischargeplan_Vital_Signs_Pulse='".$_POST["dischargeplan_Vital_Signs_Pulse"]."',
dischargeplan_Vital_Signs_Regular='".$_POST["dischargeplan_Vital_Signs_Regular"]."',
dischargeplan_Vital_Signs_Irregular='".$_POST["dischargeplan_Vital_Signs_Irregular"]."',
dischargeplan_Vital_Signs_Temperature='".$_POST["dischargeplan_Vital_Signs_Temperature"]."',
dischargeplan_Vital_Signs_Oral='".$_POST["dischargeplan_Vital_Signs_Oral"]."',
dischargeplan_Vital_Signs_Temporal='".$_POST["dischargeplan_Vital_Signs_Temporal"]."',
dischargeplan_Vital_Signs_other='".$_POST["dischargeplan_Vital_Signs_other"]."',
dischargeplan_Vital_Signs_Respirations='".$_POST["dischargeplan_Vital_Signs_Respirations"]."',
dischargeplan_Vital_Signs_BP_Systolic='".$_POST["dischargeplan_Vital_Signs_BP_Systolic"]."',
dischargeplan_Vital_Signs_BP_Diastolic='".$_POST["dischargeplan_Vital_Signs_BP_Diastolic"]."',
dischargeplan_Vital_Signs_Right='".$_POST["dischargeplan_Vital_Signs_Right"]."',
dischargeplan_Vital_Signs_Left='".$_POST["dischargeplan_Vital_Signs_Left"]."',
dischargeplan_Vital_Signs_Sitting='".$_POST["dischargeplan_Vital_Signs_Sitting"]."',
dischargeplan_Vital_Signs_Standing='".$_POST["dischargeplan_Vital_Signs_Standing"]."',
dischargeplan_Vital_Signs_Lying='".$_POST["dischargeplan_Vital_Signs_Lying"]."',
dischargeplan_Vital_Signs_Sat='".$_POST["dischargeplan_Vital_Signs_Sat"]."',
dischargeplan_Vital_Signs_Pain_Intensity='".$_POST["dischargeplan_Vital_Signs_Pain_Intensity"]."',
dischargeplan_Vital_Signs_chronic_condition='".$_POST["dischargeplan_Vital_Signs_chronic_condition"]."',
dischargeplan_Vital_Signs_Patient_states='".$_POST["dischargeplan_Vital_Signs_Patient_states"]."',
dischargeplan_Vital_Signs_Patient_states_other='".$_POST["dischargeplan_Vital_Signs_Patient_states_other"]."',
dischargeplan_treatment_diagnosis_problem='".$_POST["dischargeplan_treatment_diagnosis_problem"]."',
dischargeplan_Mental_Status='".$_POST["dischargeplan_Mental_Status"]."',
dischargeplan_Mental_Status_Other='".$_POST["dischargeplan_Mental_Status_Other"]."',
dischargeplan_Mental_Status_MSS='".$_POST["dischargeplan_Mental_Status_MSS"]."',
dischargeplan_Mental_Status_CMT='".$_POST["dischargeplan_Mental_Status_CMT"]."',
dischargeplan_Mental_Status_CCT='".$_POST["dischargeplan_Mental_Status_CCT"]."',
dischargeplan_Mental_Status_Other1='".$_POST["dischargeplan_Mental_Status_Other1"]."',
dischargeplan_specific_training_this_visit='".$_POST["dischargeplan_specific_training_this_visit"]."',
dischargeplan_RfD_No_Further_Skilled='".$_POST["dischargeplan_RfD_No_Further_Skilled"]."',
dischargeplan_RfD_Short_Term_Goals='".$_POST["dischargeplan_RfD_Short_Term_Goals"]."',
dischargeplan_RfD_Long_Term_Goals='".$_POST["dischargeplan_RfD_Long_Term_Goals"]."',
dischargeplan_RfD_Patient_homebound='".$_POST["dischargeplan_RfD_Patient_homebound"]."',
dischargeplan_RfD_rehab_potential='".$_POST["dischargeplan_RfD_rehab_potential"]."',
dischargeplan_RfD_refused_services='".$_POST["dischargeplan_RfD_refused_services"]."',
dischargeplan_RfD_out_of_service_area='".$_POST["dischargeplan_RfD_out_of_service_area"]."',
dischargeplan_RfD_Admitted_to_Hospital='".$_POST["dischargeplan_RfD_Admitted_to_Hospital"]."',
dischargeplan_RfD_higher_level_of_care='".$_POST["dischargeplan_RfD_higher_level_of_care"]."',
dischargeplan_RfD_another_Agency='".$_POST["dischargeplan_RfD_another_Agency"]."',
dischargeplan_RfD_Death='".$_POST["dischargeplan_RfD_Death"]."',
dischargeplan_RfD_Transferred_Hospice='".$_POST["dischargeplan_RfD_Transferred_Hospice"]."',
dischargeplan_RfD_MD_Request='".$_POST["dischargeplan_RfD_MD_Request"]."',
dischargeplan_RfD_other='".$_POST["dischargeplan_RfD_other"]."',
dischargeplan_ToD_ADL='".$_POST["dischargeplan_ToD_ADL"]."',
dischargeplan_ToD_ADL_notes='".$_POST["dischargeplan_ToD_ADL_notes"]."',
dischargeplan_ToD_ADL1='".$_POST["dischargeplan_ToD_ADL1"]."',
dischargeplan_ToD_ADL1_notes='".$_POST["dischargeplan_ToD_ADL1_notes"]."',
dischargeplan_ToD_IADL='".$_POST["dischargeplan_ToD_IADL"]."',
dischargeplan_ToD_IADL_notes='".$_POST["dischargeplan_ToD_IADL_notes"]."',
dischargeplan_ToD_IADL1='".$_POST["dischargeplan_ToD_IADL1"]."',
dischargeplan_ToD_IADL1_notes='".$_POST["dischargeplan_ToD_IADL1_notes"]."',
dischargeplan_ToD_ROM='".$_POST["dischargeplan_ToD_ROM"]."',
dischargeplan_ToD_ROM_in='".$_POST["dischargeplan_ToD_ROM_in"]."',
dischargeplan_ToD_Safety_Management='".$_POST["dischargeplan_ToD_Safety_Management"]."',
dischargeplan_ToD_Safety_Management_in='".$_POST["dischargeplan_ToD_Safety_Management_in"]."',
dischargeplan_ToD_Env_Adaptations='".$_POST["dischargeplan_ToD_Env_Adaptations"]."',
dischargeplan_ToD_Env_Adaptations_inc='".$_POST["dischargeplan_ToD_Env_Adaptations_inc"]."',
dischargeplan_ToD_AE_Usage='".$_POST["dischargeplan_ToD_AE_Usage"]."',
dischargeplan_ToD_AE_Usage_for='".$_POST["dischargeplan_ToD_AE_Usage_for"]."',
dischargeplan_ToD_CF_Performance='".$_POST["dischargeplan_ToD_CF_Performance"]."',
dischargeplan_ToD_CF_Performance_in='".$_POST["dischargeplan_ToD_CF_Performance_in"]."',
dischargeplan_ToD_Per_Home_Exercises='".$_POST["dischargeplan_ToD_Per_Home_Exercises"]."',
dischargeplan_ToD_Per_Home_Exercises_for='".$_POST["dischargeplan_ToD_Per_Home_Exercises_for"]."',
dischargeplan_ToD_Other='".$_POST["dischargeplan_ToD_Other"]."',
dischargeplan_ToD_Status_of_Patient='".$_POST["dischargeplan_ToD_Status_of_Patient"]."',
dischargeplan_Functional_Ability_Timeof_Discharge='".$_POST["dischargeplan_Functional_Ability_Timeof_Discharge"]."',
dischargeplan_Discharge_anticipated='".$_POST["dischargeplan_Discharge_anticipated"]."',
dischargeplan_Discharge_not_anticipated='".$_POST["dischargeplan_Discharge_not_anticipated"]."',
dischargeplan_follow_up_treatment='".$_POST["dischargeplan_follow_up_treatment"]."',
dischargeplan_Recommendations_met='".$_POST["dischargeplan_Recommendations_met"]."',
dischargeplan_Recommendations_partially='".$_POST["dischargeplan_Recommendations_partially"]."',
dischargeplan_Recommendations_not_met='".$_POST["dischargeplan_Recommendations_not_met"]."',
dischargeplan_Recommendations_not_met_note='".$_POST["dischargeplan_Recommendations_not_met_note"]."',
dischargeplan_md_printed_name='".$_POST["dischargeplan_md_printed_name"]."',
dischargeplan_md_signature='".$_POST["dischargeplan_md_signature"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>
