<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$addnew = array();

foreach($_POST as $key => $val) {
	if(is_array($val)) {  $val = implode("#",$val); }
	$addnew[$key] = mysql_real_escape_string($val);
}

if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_msw_careplan", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "MSW Careplan", $newid, "msw_careplan", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_msw_careplan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
SOC_date ='".$_POST["SOC_date"]."',
problem_reason_for_referel='".$_POST["problem_reason_for_referel"]."',
spouse_significant_others_row1='".$_POST["spouse_significant_others_row1"]."',
spouse_significant_others_row2='".$_POST["spouse_significant_others_row2"]."',
spouse_significant_others_row3='".$_POST["spouse_significant_others_row3"]."',
caregivers_row1='".$_POST["caregivers_row1"]."',
caregivers_row2='".$_POST["caregivers_row1"]."',
patient_lives='".$_POST["patient_lives"]."',
patient_lives_with_who='".$_POST["patient_lives_with_who"]."',
patient_lives_other ='".$_POST["patient_lives_other"]."',
no_of_hours_patient_alone ='".$_POST["no_of_hours_patient_alone"]."',
type_of_housing ='".$_POST["type_of_housing"]."',
type_of_housing_other ='".$_POST["type_of_housing_other"]."',
condition_of_housing ='".$_POST["condition_of_housing"]."',
problem_safety_issues='".$_POST["problem_safety_issues"]."',
mental_status ='".$_POST["mental_status"]."',
mental_status_oriented_to ='".$_POST["mental_status_oriented_to"]."',
mental_status_disoriented ='".$_POST["mental_status_disoriented"]."',
impaired_mental_status_requires_resources  ='".$_POST["impaired_mental_status_requires_resources"]."',
impaired_mental_status_requires_resources_other  ='".$_POST["impaired_mental_status_requires_resources_other"]."',
patient_adl_status  ='".$_POST["patient_adl_status"]."',
patient_adl_status_other  ='".$_POST["patient_adl_status_other"]."',
ambulatory_transfer_status  ='".$_POST["ambulatory_transfer_status"]."',
ambulatory_transfer_status_other  ='".$_POST["ambulatory_transfer_status_other"]."',
communication_status  ='".$_POST["communication_status"]."',
communication_status_other  ='".$_POST["communication_status_other"]."',
miscellaneous_abilities_hearing  ='".$_POST["miscellaneous_abilities_hearing"]."',
miscellaneous_abilities_hearing_other  ='".$_POST["miscellaneous_abilities_hearing_other"]."',
miscellaneous_abilities_vision  ='".$_POST["miscellaneous_abilities_vision"]."',
miscellaneous_abilities_vision_other  ='".$_POST["miscellaneous_abilities_vision_other"]."',
patient_needs_help_with  ='".$_POST["patient_needs_help_with"]."',
patient_needs_help_with_other  ='".$_POST["patient_needs_help_with_other"]."',
patient_desired  ='".$_POST["patient_desired"]."',
short_term_time_frame  ='".$_POST["short_term_time_frame"]."',
long_term_time_frame ='".$_POST["long_term_time_frame"]."',
SOC_date2 ='".$_POST["SOC_date2"]."',
medical_social_services_interventions  ='".$_POST["medical_social_services_interventions"]."',
medical_social_services_interventions_other  ='".$_POST["medical_social_services_interventions_other"]."',
analysis_of_finding  ='".$_POST["analysis_of_finding"]."',
review_of_interventions  ='".$_POST["review_of_interventions"]."',
evaluation_of_patient  ='".$_POST["evaluation_of_patient"]."',
continued_treatmentplan_frequency  ='".$_POST["continued_treatmentplan_frequency"]."',
continued_treatmentplan_duration  ='".$_POST["continued_treatmentplan_duration"]."',
continued_treatmentplan_effective_date  ='".$_POST["continued_treatmentplan_effective_date"]."',
msw_careplan_communicated_agreed  ='".$_POST["msw_careplan_communicated_agreed"]."',
msw_careplan_communicated_agreed_other  ='".$_POST["msw_careplan_communicated_agreed_other"]."',
physician_order  ='".$_POST["physician_order"]."',
other_comments  ='".$_POST["other_comments"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
