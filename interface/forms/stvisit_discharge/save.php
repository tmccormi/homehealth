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
$newid = formSubmit("forms_st_visit_discharge_note", $_POST, $_GET["id"],$userauthorized);
addForm($encounter, "Visit Discharge", $newid, "stvisit_discharge", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_st_visit_discharge_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1,date = NOW(), 
dischargeplan_Time_In ='".$_POST["dischargeplan_Time_In"]."',
dischargeplan_Time_Out ='".$_POST["dischargeplan_Time_Out"]."',
dischargeplan_date  ='".$_POST["dischargeplan_date"]."',
dischargeplan_type_of_visit  ='".$_POST["dischargeplan_type_of_visit"]."',
dischargeplan_type_of_visit_other ='".$_POST["dischargeplan_type_of_visit_other"]."',
dischargeplan_Vital_Signs_Pulse ='".$_POST["dischargeplan_Vital_Signs_Pulse"]."',
dischargeplan_Vital_Signs_Pulse_Type ='".$_POST["dischargeplan_Vital_Signs_Pulse_Type"]."',
dischargeplan_Vital_Signs_Temperature ='".$_POST["dischargeplan_Vital_Signs_Temperature"]."',
dischargeplan_Vital_Signs_Temperature_Type ='".$_POST["dischargeplan_Vital_Signs_Temperature_Type"]."',
dischargeplan_Vital_Signs_other ='".$_POST["dischargeplan_Vital_Signs_other"]."',
dischargeplan_Vital_Signs_Respirations ='".$_POST["dischargeplan_Vital_Signs_Respirations"]."',
dischargeplan_Vital_Signs_BP_Systolic ='".$_POST["dischargeplan_Vital_Signs_BP_Systolic"]."',
dischargeplan_Vital_Signs_BP_Diastolic ='".$_POST["dischargeplan_Vital_Signs_BP_Diastolic"]."',
dischargeplan_Vital_Signs_BP_side  ='".$_POST["dischargeplan_Vital_Signs_BP_side"]."',
dischargeplan_Vital_Signs_BP_Position  ='".$_POST["dischargeplan_Vital_Signs_BP_Position"]."',
dischargeplan_Vital_Signs_Sat  ='".$_POST["dischargeplan_Vital_Signs_Sat"]."',
dischargeplan_Vital_Signs_Pain  ='".$_POST["dischargeplan_Vital_Signs_Pain"]."',
dischargeplan_Vital_Signs_Pain_Intensity  ='".$_POST["dischargeplan_Vital_Signs_Pain_Intensity"]."',
dischargeplan_treatment_diagnosis_problem  ='".$_POST["dischargeplan_treatment_diagnosis_problem"]."',
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
dischargeplan_Specific_Training ='".$_POST["dischargeplan_Specific_Training"]."', 
dischargeplan_Improved_Oral_Stage ='".$_POST["dischargeplan_Improved_Oral_Stage"]."',
dischargeplan_Improved_Oral_Stage_In  ='".$_POST["dischargeplan_Improved_Oral_Stage_In"]."',
dischargeplan_Improved_Pharyngeal_Stage ='".$_POST["dischargeplan_Improved_Pharyngeal_Stage"]."',
dischargeplan_Improved_Pharyngeal_Stage_In  ='".$_POST["dischargeplan_Improved_Pharyngeal_Stage_In"]."',
dischargeplan_Improved_Verbal_Expression ='".$_POST["dischargeplan_Improved_Verbal_Expression"]."',
dischargeplan_Improved_Verbal_Expression_In  ='".$_POST["dischargeplan_Improved_Verbal_Expression_In"]."',
dischargeplan_Improved_Non_Verbal_Expression ='".$_POST["dischargeplan_Improved_Non_Verbal_Expression"]."',
dischargeplan_Improved_Non_Verbal_Expression_In ='".$_POST["dischargeplan_Improved_Non_Verbal_Expression_In"]."',
dischargeplan_Improved_Comprehension ='".$_POST["dischargeplan_Improved_Comprehension"]."',
dischargeplan_Improved_Comprehension_In ='".$_POST["dischargeplan_Improved_Comprehension_In"]."',
dischargeplan_Caregiver_Family_Performance ='".$_POST["dischargeplan_Caregiver_Family_Performance"]."',
dischargeplan_Caregiver_Family_Performance_In ='".$_POST["dischargeplan_Caregiver_Family_Performance_In"]."',
dischargeplan_Functional_Improvements_Other ='".$_POST["dischargeplan_Functional_Improvements_Other"]."',
dischargeplan_Functional_Improvements_Other_Note ='".$_POST["dischargeplan_Functional_Improvements_Other_Note"]."',
dischargeplan_Functional_Improvements_Comments ='".$_POST["dischargeplan_Functional_Improvements_Comments"]."',
dischargeplan_Functional_Ability_In  ='".$_POST["dischargeplan_Functional_Ability_In"]."',
dischargeplan_Comments_Recommendations  ='".$_POST["dischargeplan_Comments_Recommendations"]."',
dischargeplan_Followup_Recommendations ='".$_POST["dischargeplan_Followup_Recommendations"]."',
dischargeplan_Goals_identified_on_careplan  ='".$_POST["dischargeplan_Goals_identified_on_careplan"]."',
dischargeplan_Goals_notmet_explanation ='".$_POST["dischargeplan_Goals_notmet_explanation"]."',
dischargeplan_Additional_Comments ='".$_POST["dischargeplan_Additional_Comments"]."',
dischargeplan_Therapist_Signature  ='".$_POST["dischargeplan_Therapist_Signature"]."',
dischargeplan_md_printed_name  ='".$_POST["dischargeplan_md_printed_name"]."',
dischargeplan_md_signature  ='".$_POST["dischargeplan_md_signature"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>
