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
$newid = formSubmit("forms_msw_visit_note", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "MSW Visit Note", $newid, "msw_visit_note", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_msw_visit_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
msw_visit_note_time_in ='".$_POST["msw_visit_note_time_in"]."',
msw_visit_note_time_out ='".$_POST["msw_visit_note_time_out"]."',
msw_visit_note_date ='".$_POST["msw_visit_note_date"]."',
msw_visit_note_patient_name ='".$_POST["msw_visit_note_patient_name"]."',
msw_visit_note_mr ='".$_POST["msw_visit_note_mr"]."',
msw_visit_note_soc ='".$_POST["msw_visit_note_soc"]."',
msw_visit_note_homebound_reason ='".$_POST["msw_visit_note_homebound_reason"]."',
msw_visit_note_homebound_reason_in ='".$_POST["msw_visit_note_homebound_reason_in"]."',
msw_visit_note_homebound_reason_other ='".$_POST["msw_visit_note_homebound_reason_other"]."',
msw_visit_note_phychological_health_environmental_situation ='".$_POST["msw_visit_note_phychological_health_environmental_situation"]."',
msw_visit_note_asssessment_of_current ='".$_POST["msw_visit_note_asssessment_of_current"]."',
msw_visit_note_asssessment_of_current_other ='".$_POST["msw_visit_note_asssessment_of_current_other"]."',
msw_visit_note_patient_education ='".$_POST["msw_visit_note_patient_education"]."',
msw_visit_note_patient_education_other ='".$_POST["msw_visit_note_patient_education_other"]."',
msw_visit_note_interventions_including ='".$_POST["msw_visit_note_interventions_including"]."',
msw_visit_note_interventions_including_other ='".$_POST["msw_visit_note_interventions_including_other"]."',
msw_visit_note_planning_and_organization ='".$_POST["msw_visit_note_planning_and_organization"]."',
msw_visit_note_planning_and_organization_other ='".$_POST["msw_visit_note_planning_and_organization_other"]."',
msw_visit_note_additional_comments ='".$_POST["msw_visit_note_additional_comments"]."',
msw_visit_note_msw_visit_communicated_to ='".$_POST["msw_visit_note_msw_visit_communicated_to"]."',
msw_visit_note_msw_visit_communicated_to_other ='".$_POST["msw_visit_note_msw_visit_communicated_to_other"]."',
msw_visit_note_msw ='".$_POST["msw_visit_note_msw"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
