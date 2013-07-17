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
$newid = formSubmit("forms_dietary_visit", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Dietary Visit", $newid, "dietary_visit", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_dietary_visit set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
dietary_visit_last_name ='".$_POST["dietary_visit_last_name"]."',
dietary_visit_first_name ='".$_POST["dietary_visit_first_name"]."',
dietary_visit_visit_date ='".$_POST["dietary_visit_visit_date"]."',
dietary_visit_change_dietary_status_since_last_visit ='".$_POST["dietary_visit_change_dietary_status_since_last_visit"]."',
dietary_visit_patient_weight_lost_since_last_visit ='".$_POST["dietary_visit_patient_weight_lost_since_last_visit"]."',
dietary_visit_patient_weight_lost_since_last_visit_others ='".$_POST["dietary_visit_patient_weight_lost_since_last_visit_others"]."',
dietary_visit_new_factors_affecting_patient_weight ='".$_POST["dietary_visit_new_factors_affecting_patient_weight"]."',
dietary_visit_new_affecting_factors ='".$_POST["dietary_visit_new_affecting_factors"]."',
dietary_visit_assessment_summary ='".$_POST["dietary_visit_assessment_summary"]."',
dietary_visit_treatment_plan ='".$_POST["dietary_visit_treatment_plan"]."',
dietary_visit_rd_signature ='".$_POST["dietary_visit_rd_signature"]."',
dietary_visit_rd_signature_date ='".$_POST["dietary_visit_rd_signature_date"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
