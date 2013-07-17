<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$addnew = array();
foreach($_POST as $key => $val) {
	if(is_array($val)) { $val = implode("#",$val); }
	$addnew[$key] = mysql_real_escape_string($val);
}
if ($encounter == "")
$encounter = date("Ymd");

if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_sixty_day_progress_note", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Sixty Day Progress Note", $newid, "sixty_day_progress_note", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_sixty_day_progress_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
sixty_day_progress_note_patient_name ='".$_POST["sixty_day_progress_note_patient_name"]."',
sixty_day_progress_note_certification_period ='".$_POST["sixty_day_progress_note_certification_period"]."',
sixty_day_progress_note_dear_dr ='".$_POST["sixty_day_progress_note_dear_dr"]."',
sixty_day_progress_note_patient_receiving_care_first ='".$_POST["sixty_day_progress_note_patient_receiving_care_first"]."',
sixty_day_progress_note_patient_receiving_care_other ='".$_POST["sixty_day_progress_note_patient_receiving_care_other"]."',
sixty_day_progress_note_diagnosis_admission ='".$_POST["sixty_day_progress_note_diagnosis_admission"]."',
sixty_day_progress_note_additional_diagnosis ='".$_POST["sixty_day_progress_note_additional_diagnosis"]."',
sixty_day_progress_note_decline_no_change_clinical_pblm ='".$_POST["sixty_day_progress_note_decline_no_change_clinical_pblm"]."',
sixty_day_progress_note_decline_clinical_pblm_other ='".$_POST["sixty_day_progress_note_decline_clinical_pblm_other"]."',
sixty_day_progress_note_decline_clinical_pblm_specific_details ='".$_POST["sixty_day_progress_note_decline_clinical_pblm_specific_details"]."',
sixty_day_progress_note_improvement_in_clinical_issues ='".$_POST["sixty_day_progress_note_improvement_in_clinical_issues"]."',
sixty_day_progress_note_improvement_issues_other ='".$_POST["sixty_day_progress_note_improvement_issues_other"]."',
sixty_day_progress_note_improvement_issues_specific_details ='".$_POST["sixty_day_progress_note_improvement_issues_specific_details"]."',
sixty_day_progress_note_living_situation_patient_lives ='".$_POST["sixty_day_progress_note_living_situation_patient_lives"]."',
sixty_day_progress_note_living_situation_patient_lives_who ='".$_POST["sixty_day_progress_note_living_situation_patient_lives_who"]."',
sixty_day_progress_note_living_situation_patient_lives_other ='".$_POST["sixty_day_progress_note_living_situation_patient_lives_other"]."',
sixty_day_progress_note_living_situation_no_hur_day_why ='".$_POST["sixty_day_progress_note_living_situation_no_hur_day_why"]."',
sixty_day_progress_note_mental_status ='".$_POST["sixty_day_progress_note_mental_status"]."',
sixty_day_progress_note_mental_status_oriented ='".$_POST["sixty_day_progress_note_mental_status_oriented"]."',
sixty_day_progress_note_mental_status_disoriented ='".$_POST["sixty_day_progress_note_mental_status_disoriented"]."',
sixty_day_progress_note_impaired_mental_sta_req_resou ='".$_POST["sixty_day_progress_note_impaired_mental_sta_req_resou"]."',
sixty_day_progress_note_impaired_mental_sta_req_resou_other ='".$_POST["sixty_day_progress_note_impaired_mental_sta_req_resou_other"]."',
sixty_day_progress_note_patient_adl_status ='".$_POST["sixty_day_progress_note_patient_adl_status"]."',
sixty_day_progress_note_patient_adl_status_other ='".$_POST["sixty_day_progress_note_patient_adl_status_other"]."',
sixty_day_progress_note_ambulatory_transfer_status ='".$_POST["sixty_day_progress_note_ambulatory_transfer_status"]."',
sixty_day_progress_note_ambulatory_transfer_status_other ='".$_POST["sixty_day_progress_note_ambulatory_transfer_status_other"]."',
sixty_day_progress_note_communication_status ='".$_POST["sixty_day_progress_note_communication_status"]."',
sixty_day_progress_note_communication_status_other ='".$_POST["sixty_day_progress_note_communication_status_other"]."',
sixty_day_progress_note_miscellaneous_abi_hear ='".$_POST["sixty_day_progress_note_miscellaneous_abi_hear"]."',
sixty_day_progress_note_miscellaneous_abis_hear_other ='".$_POST["sixty_day_progress_note_miscellaneous_abis_hear_other"]."',
sixty_day_progress_note_miscellaneous_abi_vis ='".$_POST["sixty_day_progress_note_miscellaneous_abi_vis"]."',
sixty_day_progress_note_miscellaneous_abi_hear_vis_other ='".$_POST["sixty_day_progress_note_miscellaneous_abi_hear_vis_other"]."',
sixty_day_progress_note_patient_needs_help_with ='".$_POST["sixty_day_progress_note_patient_needs_help_with"]."',
sixty_day_progress_note_patient_needs_help_with_other ='".$_POST["sixty_day_progress_note_patient_needs_help_with_other"]."',
sixty_day_progress_note_additional_information ='".$_POST["sixty_day_progress_note_additional_information"]."',
sixty_day_progress_note_clinician_name_title_completing_note ='".$_POST["sixty_day_progress_note_clinician_name_title_completing_note"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
