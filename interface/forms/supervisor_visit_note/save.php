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
$newid = formSubmit("forms_supervisor_visit_note", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Supervisor Visit of Home Health Staff", $newid, "supervisor_visit_note", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_supervisor_visit_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
patient_name='".$_POST["patient_name"]."',
time_in='".$_POST["time_in"]."',
time_out='".$_POST["time_out"]."',
SOC_date='".$_POST["SOC_date"]."',
staff_supervised='".$_POST["staff_supervised"]."',
supervisor_visits='".$_POST["supervisor_visits"]."',
reported_to_patient_home='".$_POST["reported_to_patient_home"]."',
wearing_name_badge='".$_POST["wearing_name_badge"]."',
using_two_identifiers='".$_POST["using_two_identifiers"]."',
demonstrates_behaviour='".$_POST["demonstrates_behaviour"]."',
follow_home_health='".$_POST["follow_home_health"]."',
demonstrates_communication='".$_POST["demonstrates_communication"]."',
aware_patient_code='".$_POST["aware_patient_code"]."',
demonstrates_clinical_skills='".$_POST["demonstrates_clinical_skills"]."',
adheres_to_policies='".$_POST["adheres_to_policies"]."',
identify_patient_issues='".$_POST["identify_patient_issues"]."',
handling_skills='".$_POST["handling_skills"]."',
demonstrates_grooming='".$_POST["demonstrates_grooming"]."',
supervisor_visit_other='".$_POST["supervisor_visit_other"]."',
additional_notes='".$_POST["additional_notes"]."',
clinician_signature='".$_POST["clinician_signature"]."',
clinician_signature_date='".$_POST["clinician_signature_date"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
