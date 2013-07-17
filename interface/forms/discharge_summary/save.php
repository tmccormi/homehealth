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
$newid = formSubmit("forms_discharge_summary", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "General Discharge Summary", $newid, "discharge_summary", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_discharge_summary set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
patient_name='".$_POST["patient_name"]."',
patient_mr='".$_POST["patient_mr"]."',
patient_discharge_date ='".$_POST["patient_discharge_date"]."',
discharge_summary_discontinue_services ='".$_POST["discharge_summary_discontinue_services"]."',
discharge_summary_discontinue_services_other ='".$_POST["discharge_summary_discontinue_services_other"]."',
discharge_summary_mental_status ='".$_POST["discharge_summary_mental_status"]."',
discharge_summary_mental_status_other ='".$_POST["discharge_summary_mental_status_other"]."',
discharge_summary_provided_interventions ='".$_POST["discharge_summary_provided_interventions"]."',
discharge_summary_provided_interventions_other ='".$_POST["discharge_summary_provided_interventions_other"]."',
discharge_summary_discharge_reason ='".$_POST["discharge_summary_discharge_reason"]."',
discharge_summary_discharge_reason_other ='".$_POST["discharge_summary_discharge_reason_other"]."',
discharge_summary_functional_ability ='".$_POST["discharge_summary_functional_ability"]."',
discharge_summary_comments_recommendations ='".$_POST["discharge_summary_comments_recommendations"]."',
discharge_summary_service_recommended ='".$_POST["discharge_summary_service_recommended"]."',
discharge_summary_goals_identified ='".$_POST["discharge_summary_goals_identified"]."',
discharge_summary_goals_identified_explanation ='".$_POST["discharge_summary_goals_identified_explanation"]."',
discharge_summary_additional_comments ='".$_POST["discharge_summary_additional_comments"]."',
discharge_summary_md_name ='".$_POST["discharge_summary_md_name"]."',
discharge_summary_md_signature ='".$_POST["discharge_summary_md_signature"]."',
discharge_summary_md_signature_date  ='".$_POST["discharge_summary_md_signature_date"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
