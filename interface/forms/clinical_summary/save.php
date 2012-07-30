<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$addnew = array();

foreach($_POST as $key => $val) {
	if(is_array($val)) { $val = implode("#",$val); }
	$addnew[$key] = $val;
}

if ($encounter == "")
$encounter = date("Ymd");

if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_clinical_summary", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Clinical Summary", $newid, "clinical_summary", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_clinical_summary set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),


clinical_summary_notes ='".$_POST["clinical_summary_notes"]."',
clinical_summary_patient_name ='".$_POST["clinical_summary_patient_name"]."',
clinical_summary_chart ='".$_POST["clinical_summary_chart"]."',
clinical_summary_episode ='".$_POST["clinical_summary_episode"]."',
clinical_summary_caregiver_name ='".$_POST["clinical_summary_caregiver_name"]."',
clinical_summary_visit_date ='".$_POST["clinical_summary_visit_date"]."',
clinical_summary_case_manager ='".$_POST["clinical_summary_case_manager"]."',
clinical_summary_age ='".$_POST["clinical_summary_age"]."',
clinical_summary_gender ='".$_POST["clinical_summary_gender"]."',
clinical_summary_hospitalization ='".$_POST["clinical_summary_hospitalization"]."',
clinical_summary_admission_date ='".$_POST["clinical_summary_admission_date"]."',
clinical_summary_hospitalization_reason ='".$_POST["clinical_summary_hospitalization_reason"]."',
clinical_summary_reffered_reason ='".$_POST["clinical_summary_reffered_reason"]."',
clinical_summary_homebound ='".$_POST["clinical_summary_homebound"]."',
clinical_summary_homebound_due_to ='".$_POST["clinical_summary_homebound_due_to"]."',
clinical_summary_patient_current_condition ='".$_POST["clinical_summary_patient_current_condition"]."',
clinical_summary_teaching_training ='".$_POST["clinical_summary_teaching_training"]."',
clinical_summary_observation_assessment ='".$_POST["clinical_summary_observation_assessment"]."',
clinical_summary_treatment_of ='".$_POST["clinical_summary_treatment_of"]."',
clinical_summary_case_management ='".$_POST["clinical_summary_case_management"]."',
clinical_summary_willing_caregiver ='".$_POST["clinical_summary_willing_caregiver"]."',
clinical_summary_caregiver_sign ='".$_POST["clinical_summary_caregiver_sign"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
