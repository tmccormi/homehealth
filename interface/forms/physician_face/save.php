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
$newid = formSubmit("forms_physician_face", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "PHYSICIAN FACE TO FACE ENCOUNTER", $newid, "physician_face", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_physician_face set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),

physician_face_notes ='".$_POST["physician_face_notes"]."',
physician_face_patient_name ='".$_POST["physician_face_patient_name"]."',
physician_face_chart ='".$_POST["physician_face_chart"]."',
physician_face_episode ='".$_POST["physician_face_episode"]."',
physician_face_date ='".$_POST["physician_face_date"]."',
physician_face_physician_name ='".$_POST["physician_face_physician_name"]."',
physician_face_patient_dob ='".$_POST["physician_face_patient_dob"]."',
physician_face_patient_soc ='".$_POST["physician_face_patient_soc"]."',
physician_face_patient_date ='".$_POST["physician_face_patient_date"]."',
physician_face_medical_condition ='".$_POST["physician_face_medical_condition"]."',
physician_face_services ='".$_POST["physician_face_services"]."',
physician_face_services_other ='".$_POST["physician_face_services_other"]."',
physician_face_service_reason ='".$_POST["physician_face_service_reason"]."',
physician_face_clinical_homebound_reason ='".$_POST["physician_face_clinical_homebound_reason"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
