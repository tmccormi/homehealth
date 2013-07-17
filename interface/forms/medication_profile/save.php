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
$newid = formSubmit("forms_medication_profile", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Medication Profile", $newid, "medication_profile", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_medication_profile set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
patient_name='".$_POST["patient_name"]."',
patient_mr_no='".$_POST["patient_mr_no"]."',
chart='".$_POST["chart"]."',
episode='".$_POST["episode"]."',
soc='".$_POST["soc"]."',
patient_height='".$_POST["patient_height"]."',
patient_dob='".$_POST["patient_dob"]."',
patient_weight='".$_POST["patient_weight"]."',
certification_period='".$_POST["certification_period"]."',
diagnoses='".$_POST["diagnoses"]."',
allergies='".$_POST["allergies"]."',
physician_contact='".$_POST["physician_contact"]."',
pharmacy_name='".$_POST["pharmacy_name"]."',
pharmacy_address='".$_POST["pharmacy_address"]."',
pharmacy_phone='".$_POST["pharmacy_phone"]."',
pharmacy_fax='".$_POST["pharmacy_fax"]."',
medication_start_date='".$_POST["medication_start_date"]."',
medication_code='".$_POST["medication_code"]."',
medication_title='".$_POST["medication_title"]."',
medication_route='".$_POST["medication_route"]."',
medication_dose='".$_POST["medication_dose"]."',
medication_frequency='".$_POST["medication_frequency"]."',
medication_purpose='".$_POST["medication_purpose"]."',
medication_teaching_date='".$_POST["medication_teaching_date"]."',
medication_discharge_date='".$_POST["medication_discharge_date"]."',
info_reviewed_with='".$_POST["info_reviewed_with"]."',
info_reviewed_included='".$_POST["info_reviewed_included"]."',
info_reviewed_included_other='".$_POST["info_reviewed_included_other"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
