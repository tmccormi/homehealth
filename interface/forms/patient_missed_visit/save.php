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
$newid = formSubmit("forms_patient_missed_visit", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Patient Missed Visit", $newid, "patient_missed_visit", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_patient_missed_visit set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
patient_name='".$_POST["patient_name"]."',
patient_mr='".$_POST["patient_mr"]."',
patient_missed_date ='".$_POST["patient_missed_date"]."',
descipline_who_category ='".$_POST["descipline_who_category"]."',
descipline_who ='".$_POST["descipline_who"]."',
descipline_who_other='".$_POST["descipline_who_other"]."',
reason_for_category ='".$_POST["reason_for_category"]."',
reason_for='".implode("#",$_POST["reason_for"])."',
reason_for_other='".$_POST["reason_for_other"]."',
actions_taken='".implode("#",$_POST["actions_taken"])."',
actions_taken_other ='".$_POST["actions_taken_other"]."',
patient_need_addressed ='".$_POST["patient_need_addressed"]."',
patient_need_addressed_other='".$_POST["patient_need_addressed_other"]."',
physician_name='".$_POST["physician_name"]."',
physician_fax_number ='".$_POST["physician_fax_number"]."',
physician_acknowledgment ='".$_POST["physician_acknowledgment"]."',
physician_acknowledgment_date='".$_POST["physician_acknowledgment_date"]."',
physician_signature ='".$_POST["physician_signature"]."',
physician_signature_date='".$_POST["physician_signature_date"]."',
physician_comments ='".$_POST["physician_comments"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
