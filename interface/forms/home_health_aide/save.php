<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$addnew = array();

foreach($_POST as $key => $val) {
	if(is_array($val)) {  $val = implode("#",$val); }
	$addnew[$key] = $val;
}

if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_home_health_aide", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Home Health Aide", $newid, "home_health_aide", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_home_health_aide set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
home_health_patient_name='".$_POST["home_health_patient_name"]."',
home_health_patient_address='".$_POST["home_health_patient_address"]."',
home_health_patient_phone='".$_POST["home_health_patient_phone"]."',
home_health_care_manager='".$_POST["home_health_care_manager"]."',
home_health_aide_visit_frequency='".$_POST["home_health_aide_visit_frequency"]."',
home_health_aide_visit_duration='".$_POST["home_health_aide_visit_duration"]."',
home_health_aide_visit_effective_date='".$_POST["home_health_aide_visit_effective_date"]."',
patient_problems='".$_POST["patient_problems"]."',
home_health_goals_for_care='".$_POST["home_health_goals_for_care"]."',
home_health_goals_for_care_other='".$_POST["home_health_goals_for_care_other"]."',
home_health_medical_issues='".implode("#",$_POST["home_health_medical_issues"])."',
home_health_medical_issues_diet='".$_POST["home_health_medical_issues_diet"]."',
home_health_medical_issues_allergies='".$_POST["home_health_medical_issues_allergies"]."',
home_health_medical_issues_other='".$_POST["home_health_medical_issues_other"]."',
home_health_living_situation='".$_POST["home_health_living_situation"]."',
home_health_living_situation_other='".$_POST["home_health_living_situation_other"]."',
home_health_type_of_housing='".$_POST["home_health_type_of_housing"]."',
home_health_type_of_housing_other='".$_POST["home_health_type_of_housing_other"]."',
home_health_condition_of_housing='".$_POST["home_health_condition_of_housing"]."',
home_health_problem_safety_issues='".$_POST["home_health_problem_safety_issues"]."',
mental_status='".$_POST["mental_status"]."',
mental_status_oriented_to='".$_POST["mental_status_oriented_to"]."',
mental_status_disoriented='".$_POST["mental_status_disoriented"]."',
impaired_mental_status_requires_resources='".$_POST["impaired_mental_status_requires_resources"]."',
impaired_mental_status_requires_resources_other='".$_POST["impaired_mental_status_requires_resources_other"]."',
patient_adl_status='".$_POST["patient_adl_status"]."',
patient_adl_status_other='".$_POST["patient_adl_status_other"]."',
ambulatory_transfer_status='".$_POST["ambulatory_transfer_status"]."',
ambulatory_transfer_status_other='".$_POST["ambulatory_transfer_status_other"]."',
communication_status='".$_POST["communication_status"]."',
communication_status_other='".$_POST["communication_status_other"]."',
miscellaneous_abilities_hearing='".$_POST["miscellaneous_abilities_hearing"]."',
miscellaneous_abilities_vision='".$_POST["miscellaneous_abilities_vision"]."',
miscellaneous_abilities_dentures='".$_POST["miscellaneous_abilities_dentures"]."',
home_health_patient_need='".implode("#",$_POST["home_health_patient_need"])."',
home_health_patient_need_bathing='".$_POST["home_health_patient_need_bathing"]."',
home_health_patient_need_dressing='".implode("#",$_POST["home_health_patient_need_dressing"])."',
home_health_patient_need_haircare='".implode("#",$_POST["home_health_patient_need_haircare"])."',
home_health_patient_need_hygiene='".implode("#",$_POST["home_health_patient_need_hygiene"])."',
home_health_patient_need_mobility='".implode("#",$_POST["home_health_patient_need_mobility"])."',
home_health_patient_need_positioning='".implode("#",$_POST["home_health_patient_need_positioning"])."',
home_health_patient_need_pressure_location='".$_POST["home_health_patient_need_pressure_location"]."',
home_health_patient_need_housekeeping='".implode("#",$_POST["home_health_patient_need_housekeeping"])."',
home_health_patient_need_equipment_care='".$_POST["home_health_patient_need_equipment_care"]."',
home_health_patient_need_medication_assist='".$_POST["home_health_patient_need_medication_assist"]."',
home_health_patient_need_record_sign='".$_POST["home_health_patient_need_record_sign"]."',
home_health_patient_need_wound_care='".$_POST["home_health_patient_need_wound_care"]."',
additional_instructions='".$_POST["additional_instructions"]."',
review_date_1='".$_POST["review_date_1"]."',
signature_1='".$_POST["signature_1"]."',
review_date_2='".$_POST["review_date_2"]."',
signature_2='".$_POST["signature_2"]."',
review_date_3='".$_POST["review_date_3"]."',
signature_3='".$_POST["signature_3"]."' 
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
