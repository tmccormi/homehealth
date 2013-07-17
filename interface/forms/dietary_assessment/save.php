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
$newid = formSubmit("forms_dietary_assessment", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Dietary Assessment", $newid, "dietary_assessment", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_dietary_assessment set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
dietary_assessment_last_name ='".$_POST["dietary_assessment_last_name"]."',
dietary_assessment_first_name ='".$_POST["dietary_assessment_first_name"]."',
dietary_assessment_visit_date ='".$_POST["dietary_assessment_visit_date"]."',
dietary_assessment_dob ='".$_POST["dietary_assessment_dob"]."',
dietary_assessment_sex ='".$_POST["dietary_assessment_sex"]."',
dietary_assessment_weight ='".$_POST["dietary_assessment_weight"]."',
dietary_assessment_height ='".$_POST["dietary_assessment_height"]."',
dietary_assessment_food_intake_occurred_past3month ='".$_POST["dietary_assessment_food_intake_occurred_past3month"]."',
dietary_assessment_lost_weight_past3month ='".$_POST["dietary_assessment_lost_weight_past3month"]."',
dietary_assessment_lost_weight_past3month_other ='".$_POST["dietary_assessment_lost_weight_past3month_other"]."',
dietary_assessment_factors_affecting_food_intake ='".$_POST["dietary_assessment_factors_affecting_food_intake"]."',
dietary_assessment_factors_affecting_food_intake_specify ='".$_POST["dietary_assessment_factors_affecting_food_intake_specify"]."',
dietary_assessment_factors_affecting_food_intake_other ='".$_POST["dietary_assessment_factors_affecting_food_intake_other"]."',
dietary_assessment_patient_mobility_status ='".$_POST["dietary_assessment_patient_mobility_status"]."',
dietary_assessment_different_medications_per_day ='".$_POST["dietary_assessment_different_medications_per_day"]."',
dietary_assessment_pressure_ulcers_present ='".$_POST["dietary_assessment_pressure_ulcers_present"]."',
dietary_assessment_stage_ulcers ='".$_POST["dietary_assessment_stage_ulcers"]."',
dietary_assessment_full_meals_per_day ='".$_POST["dietary_assessment_full_meals_per_day"]."',
dietary_assessment_assistance_patient_require_feed_self ='".$_POST["dietary_assessment_assistance_patient_require_feed_self"]."',
dietary_assessment_past_food_drink ='".$_POST["dietary_assessment_past_food_drink"]."',
dietary_assessment_allergies_and_food_sensitivities ='".$_POST["dietary_assessment_allergies_and_food_sensitivities"]."',
dietary_assessment_dietary_foods_patient_dislikes ='".$_POST["dietary_assessment_dietary_foods_patient_dislikes"]."',
dietary_assessment_assessment_summary ='".$_POST["dietary_assessment_assessment_summary"]."',
dietary_assessment_treatmentplan_recommendations ='".$_POST["dietary_assessment_treatmentplan_recommendations"]."',
dietary_assessment_rd_signature ='".$_POST["dietary_assessment_rd_signature"]."',
dietary_assessment_rd_signature_date ='".$_POST["dietary_assessment_rd_signature_date"]."',
dietary_assessment_physician_signature ='".$_POST["dietary_assessment_physician_signature"]."',
dietary_assessment_physician_signature_date ='".$_POST["dietary_assessment_physician_signature_date"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
