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
$newid = formSubmit("forms_incident_report", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "INCIDENT REPORT", $newid, "incident_report", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_incident_report set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),

incident_report_notes ='".$_POST["incident_report_notes"]."',
incident_report_caregiver_name ='".$_POST["incident_report_caregiver_name"]."',
incident_visit_date ='".$_POST["incident_visit_date"]."',
incident_report_patient_name ='".$_POST["incident_report_patient_name"]."',
incident_report_date ='".$_POST["incident_report_date"]."',
incident_report_occurance_date ='".$_POST["incident_report_occurance_date"]."',
incident_report_patient_related ='".implode("#",$_POST["incident_report_patient_related"])."',
incident_report_patient_related_other ='".$_POST["incident_report_patient_related_other"]."',
incident_report_description_occurence ='".$_POST["incident_report_description_occurence"]."',
incident_report_notifications ='".implode("#",$_POST["incident_report_notifications"])."',
incident_report_not_physician_name ='".$_POST["incident_report_not_physician_name"]."',
incident_report_not_physician_date ='".$_POST["incident_report_not_physician_date"]."',
incident_report_not_supervisor_name ='".$_POST["incident_report_not_supervisor_name"]."',
incident_report_not_supervisor_date ='".$_POST["incident_report_not_supervisor_date"]."',
incident_report_not_caregiver_name ='".$_POST["incident_report_not_caregiver_name"]."',
incident_report_not_caregiver_date ='".$_POST["incident_report_not_caregiver_date"]."',
incident_report_not_manager_name ='".$_POST["incident_report_not_manager_name"]."',
incident_report_not_manager_date ='".$_POST["incident_report_not_manager_date"]."',
incident_report_physician_orders ='".$_POST["incident_report_physician_orders"]."',
incident_report_other_actions_taken ='".$_POST["incident_report_other_actions_taken"]."',
incident_report_administrative_review ='".$_POST["incident_report_administrative_review"]."',
incident_report_person_filing_report ='".$_POST["incident_report_person_filing_report"]."',
incident_report_filing_report_date ='".$_POST["incident_report_filing_report_date"]."',
incident_report_management_reviewer ='".$_POST["incident_report_management_reviewer"]."',
incident_report_management_reviewer_date ='".$_POST["incident_report_management_reviewer_date"]."',
incident_report_admin_reviewer ='".$_POST["incident_report_admin_reviewer"]."',
incident_report_admin_reviewer_date ='".$_POST["incident_report_admin_reviewer_date"]."',
incident_report_caregiver_sign ='".$_POST["incident_report_caregiver_sign"]."',
incident_report_caregiver_sign_date ='".$_POST["incident_report_caregiver_sign_date"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
