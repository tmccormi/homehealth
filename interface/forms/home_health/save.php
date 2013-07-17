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
$newid = formSubmit("forms_home_health", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "HOME HEALTH CERTIFICATION AND PLAN OF CARE", $newid, "home_health", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_home_health set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),


home_health_patient_name ='".$_POST["home_health_patient_name"]."',
home_health_patient_hi_claim_no ='".$_POST["home_health_patient_hi_claim_no"]."',
home_health_start_care_date ='".$_POST["home_health_start_care_date"]."',
home_health_cert_period_from ='".$_POST["home_health_cert_period_from"]."',
home_health_cert_period_to ='".$_POST["home_health_cert_period_to"]."',
home_health_med_rec_no ='".$_POST["home_health_med_rec_no"]."',
home_health_provider_no ='".$_POST["home_health_provider_no"]."',
home_health_patient_name_addr ='".$_POST["home_health_patient_name_addr"]."',
home_health_provider_name_addr ='".$_POST["home_health_provider_name_addr"]."',
home_health_dob ='".$_POST["home_health_dob"]."',
home_health_sex ='".$_POST["home_health_sex"]."',
home_health_icd_9_cm1 ='".$_POST["home_health_icd_9_cm1"]."',
home_health_principal_diagnosis ='".$_POST["home_health_principal_diagnosis"]."',
home_health_principal_date ='".$_POST["home_health_principal_date"]."',
home_health_principal_eo ='".$_POST["home_health_principal_eo"]."',
home_health_icd_9_cm2 ='".$_POST["home_health_icd_9_cm2"]."',
home_health_surgical_procedure ='".$_POST["home_health_surgical_procedure"]."',
home_health_surgical_date ='".$_POST["home_health_surgical_date"]."',
home_health_surgical_eo ='".$_POST["home_health_surgical_eo"]."',
home_health_icd_9_cm3 ='".$_POST["home_health_icd_9_cm3"]."',
home_health_other_pertinent_diagnosis ='".$_POST["home_health_other_pertinent_diagnosis"]."',
home_health_other_date ='".$_POST["home_health_other_date"]."',
home_health_other_eo ='".$_POST["home_health_other_eo"]."',
home_health_medications ='".$_POST["home_health_medications"]."',
home_health_dme_supplies ='".$_POST["home_health_dme_supplies"]."',
home_health_safety_measures ='".$_POST["home_health_safety_measures"]."',
home_health_nut_reqs ='".$_POST["home_health_nut_reqs"]."',
home_health_allergies ='".$_POST["home_health_allergies"]."',
home_health_functional_limitations ='".$_POST["home_health_functional_limitations"]."',
home_health_functional_limitations_other ='".$_POST["home_health_functional_limitations_other"]."',
home_health_activities_permitted ='".$_POST["home_health_activities_permitted"]."',
home_health_activities_permitted_other ='".$_POST["home_health_activities_permitted_other"]."',
home_health_mental_status ='".$_POST["home_health_mental_status"]."',
home_health_mental_status_other ='".$_POST["home_health_mental_status_other"]."',
home_health_prognosis ='".$_POST["home_health_prognosis"]."',
home_health_orders_discipline ='".$_POST["home_health_orders_discipline"]."',
home_health_goals ='".$_POST["home_health_goals"]."',
home_health_nurse_sign ='".$_POST["home_health_nurse_sign"]."',
home_health_nurse_sign_date ='".$_POST["home_health_nurse_sign_date"]."',
home_health_date_hha ='".$_POST["home_health_date_hha"]."',
home_health_physician_name_addr ='".$_POST["home_health_physician_name_addr"]."',
home_health_physician_ph ='".$_POST["home_health_physician_ph"]."',
home_health_physician_fax ='".$_POST["home_health_physician_fax"]."',
home_health_physician_npi ='".$_POST["home_health_physician_npi"]."',
home_health_attending_physician ='".$_POST["home_health_attending_physician"]."',
home_health_attending_physician_date ='".$_POST["home_health_attending_physician_date"]."',
home_health_caregiver_sign ='".$_POST["home_health_caregiver_sign"]."'


where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
