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
$newid = formSubmit("forms_pt_visit_discharge_note", $_POST, $_GET["id"],$userauthorized);
addForm($encounter, "PT Visit Discharge", $newid, "ptvisit_discharge", $pid, $userauthorized);

}
elseif ($_GET["mode"] == "update") {

sqlInsert("update forms_pt_visit_discharge_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1,date = NOW(), 
dischargeplan_Time_In='".$_POST["dischargeplan_Time_In"]."',
dischargeplan_Time_Out='".$_POST["dischargeplan_Time_Out"]."',
dischargeplan_date ='".$_POST["dischargeplan_date"]."',
dischargeplan_Vital_Signs_Pulse ='".$_POST["dischargeplan_Vital_Signs_Pulse"]."',
dischargeplan_Vital_Signs_Pulse_Type ='".$_POST["dischargeplan_Vital_Signs_Pulse_Type"]."',
dischargeplan_Vital_Signs_Temperature ='".$_POST["dischargeplan_Vital_Signs_Temperature"]."',
dischargeplan_Vital_Signs_Temperature_Type ='".$_POST["dischargeplan_Vital_Signs_Temperature_Type"]."',
dischargeplan_Vital_Signs_other='".$_POST["dischargeplan_Vital_Signs_other"]."',
dischargeplan_Vital_Signs_Respirations ='".$_POST["dischargeplan_Vital_Signs_Respirations"]."',
dischargeplan_Vital_Signs_BP_Systolic ='".$_POST["dischargeplan_Vital_Signs_BP_Systolic"]."',
dischargeplan_Vital_Signs_BP_Diastolic ='".$_POST["dischargeplan_Vital_Signs_BP_Diastolic"]."',
dischargeplan_Vital_Signs_BP_side ='".$_POST["dischargeplan_Vital_Signs_BP_side"]."',
dischargeplan_Vital_Signs_BP_Position ='".$_POST["dischargeplan_Vital_Signs_BP_Position"]."',
dischargeplan_Vital_Signs_Sat ='".$_POST["dischargeplan_Vital_Signs_Sat"]."',
dischargeplan_Vital_Signs_Pain_Intensity ='".$_POST["dischargeplan_Vital_Signs_Pain_Intensity"]."',
dischargeplan_Vital_Signs_chronic_condition ='".$_POST["dischargeplan_Vital_Signs_chronic_condition"]."',
dischargeplan_Vital_Signs_Patient_states ='".$_POST["dischargeplan_Vital_Signs_Patient_states"]."',
dischargeplan_Vital_Signs_Patient_states_other='".$_POST["dischargeplan_Vital_Signs_Patient_states_other"]."',
dischargeplan_treatment_diagnosis_problem='".$_POST["dischargeplan_treatment_diagnosis_problem"]."',
dischargeplan_Mental_Status='".$_POST["dischargeplan_Mental_Status"]."',
dischargeplan_Mental_Status_Other='".$_POST["dischargeplan_Mental_Status_Other"]."',
dischargeplan_specific_training_this_visit ='".$_POST["dischargeplan_specific_training_this_visit"]."',
dischargeplan_RfD_No_Further_Skilled ='".$_POST["dischargeplan_RfD_No_Further_Skilled"]."',
dischargeplan_RfD_Short_Term_Goals ='".$_POST["dischargeplan_RfD_Short_Term_Goals"]."',
dischargeplan_RfD_Long_Term_Goals ='".$_POST["dischargeplan_RfD_Long_Term_Goals"]."',
dischargeplan_RfD_Patient_homebound ='".$_POST["dischargeplan_RfD_Patient_homebound"]."',
dischargeplan_RfD_rehab_potential ='".$_POST["dischargeplan_RfD_rehab_potential"]."',
dischargeplan_RfD_refused_services ='".$_POST["dischargeplan_RfD_refused_services"]."',
dischargeplan_RfD_out_of_service_area ='".$_POST["dischargeplan_RfD_out_of_service_area"]."',
dischargeplan_RfD_Admitted_to_Hospital ='".$_POST["dischargeplan_RfD_Admitted_to_Hospital"]."',
dischargeplan_RfD_higher_level_of_care ='".$_POST["dischargeplan_RfD_higher_level_of_care"]."',
dischargeplan_RfD_another_Agency ='".$_POST["dischargeplan_RfD_another_Agency"]."',
dischargeplan_RfD_Death ='".$_POST["dischargeplan_RfD_Death"]."',
dischargeplan_RfD_Transferred_Hospice ='".$_POST["dischargeplan_RfD_Transferred_Hospice"]."',
dischargeplan_RfD_MD_Request ='".$_POST["dischargeplan_RfD_MD_Request"]."',
dischargeplan_RfD_other ='".$_POST["dischargeplan_RfD_other"]."',
dischargeplan_ToD_Mobility ='".$_POST["dischargeplan_ToD_Mobility"]."',
dischargeplan_ToD_Mobility_Notes ='".$_POST["dischargeplan_ToD_Mobility_Notes"]."',
dischargeplan_ToD_ROM ='".$_POST["dischargeplan_ToD_ROM"]."',
dischargeplan_ToD_ROM_In ='".$_POST["dischargeplan_ToD_ROM_In"]."',
dischargeplan_ToD_Home_Safety_Techniques ='".$_POST["dischargeplan_ToD_Home_Safety_Techniques"]."',
dischargeplan_ToD_Home_Safety_Techniques_In='".$_POST["dischargeplan_ToD_Home_Safety_Techniques_In"]."',
dischargeplan_ToD_Caregiver_Family_Performance ='".$_POST["dischargeplan_ToD_Caregiver_Family_Performance"]."',
dischargeplan_ToD_Caregiver_Family_Performance_In='".$_POST["dischargeplan_ToD_Caregiver_Family_Performance_In"]."',
dischargeplan_ToD_Demonstrates ='".$_POST["dischargeplan_ToD_Demonstrates"]."',
dischargeplan_ToD_Demonstrates_Notes='".$_POST["dischargeplan_ToD_Demonstrates_Notes"]."',
dischargeplan_ToD_Strength ='".$_POST["dischargeplan_ToD_Strength"]."',
dischargeplan_ToD_Strength_In='".$_POST["dischargeplan_ToD_Strength_In"]."',
dischargeplan_ToD_Assistive_Device_Usage ='".$_POST["dischargeplan_ToD_Assistive_Device_Usage"]."',
dischargeplan_ToD_Assistive_Device_Usage_With='".$_POST["dischargeplan_ToD_Assistive_Device_Usage_With"]."',
dischargeplan_ToD_Performance_of_Home_Exercises ='".$_POST["dischargeplan_ToD_Performance_of_Home_Exercises"]."',
dischargeplan_ToD_Other='".$_POST["dischargeplan_ToD_Other"]."',
dischargeplan_ToD_Discharge_Status_Patient='".$_POST["dischargeplan_ToD_Discharge_Status_Patient"]."',
dischargeplan_Functional_Ability_Timeof_Discharge='".$_POST["dischargeplan_Functional_Ability_Timeof_Discharge"]."',
dischargeplan_Comments_Recommendations='".$_POST["dischargeplan_Comments_Recommendations"]."',
dischargeplan_Followup_Recommendations ='".$_POST["dischargeplan_Followup_Recommendations"]."',
dischargeplan_Goals_identified_on_careplan='".$_POST["dischargeplan_Goals_identified_on_careplan"]."',
dischargeplan_Goals_notmet_explanation ='".$_POST["dischargeplan_Goals_notmet_explanation"]."',
dischargeplan_Additional_Comments ='".$_POST["dischargeplan_Additional_Comments"]."',
dischargeplan_md_printed_name='".$_POST["dischargeplan_md_name"]."',
dischargeplan_md_signature ='".$_POST["dischargeplan_md_signature"]."',
dischargeplan_md_date ='".$_POST["dischargeplan_md_date"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>
