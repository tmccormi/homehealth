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
$newid = formSubmit("forms_msw_evaluation", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "MSW Evaluaion", $newid, "msw_evaluation", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_msw_evaluation set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
msw_evaluation_time_in ='".$_POST["msw_evaluation_time_in"]."',
msw_evaluation_time_out ='".$_POST["msw_evaluation_time_out"]."',
msw_evaluation_date ='".$_POST["msw_evaluation_date"]."',
msw_evaluation_patient_name ='".$_POST["msw_evaluation_patient_name"]."',
msw_evaluation_mr ='".$_POST["msw_evaluation_mr"]."',
msw_evaluation_soc ='".$_POST["msw_evaluation_soc"]."',
msw_evaluation_homebound_reason ='".$_POST["msw_evaluation_homebound_reason"]."',
msw_evaluation_homebound_reason_in ='".$_POST["msw_evaluation_homebound_reason_in"]."',
msw_evaluation_homebound_reason_other ='".$_POST["msw_evaluation_homebound_reason_other"]."',
msw_evaluation_orders_for_evaluation ='".$_POST["msw_evaluation_orders_for_evaluation"]."',
msw_evaluation_if_no_explain_orders ='".$_POST["msw_evaluation_if_no_explain_orders"]."',
msw_evaluation_medical_diagnosis_problem ='".$_POST["msw_evaluation_medical_diagnosis_problem"]."',
msw_evaluation_medical_diagnosis_problem_onset ='".$_POST["msw_evaluation_medical_diagnosis_problem_onset"]."',
msw_evaluation_psychosocial_history ='".$_POST["msw_evaluation_psychosocial_history"]."',
msw_evaluation_prior_level_function ='".$_POST["msw_evaluation_prior_level_function"]."',
msw_evaluation_prior_caregiver_support ='".$_POST["msw_evaluation_prior_caregiver_support"]."',
msw_evaluation_prior_caregiver_support_who ='".$_POST["msw_evaluation_prior_caregiver_support_who"]."',
msw_evaluation_psychosocial ='".$_POST["msw_evaluation_psychosocial"]."',
msw_evaluation_psychosocial_oriented ='".$_POST["msw_evaluation_psychosocial_oriented"]."',
msw_evaluation_safety_awareness ='".$_POST["msw_evaluation_safety_awareness"]."',
msw_evaluation_safety_awareness_other ='".$_POST["msw_evaluation_safety_awareness_other"]."',
msw_evaluation_living_situation_support_system ='".$_POST["msw_evaluation_living_situation_support_system"]."',
msw_evaluation_health_factors ='".$_POST["msw_evaluation_health_factors"]."',
msw_evaluation_environmental_factors ='".$_POST["msw_evaluation_environmental_factors"]."',
msw_evaluation_financial_factors ='".$_POST["msw_evaluation_financial_factors"]."',
msw_evaluation_additional_information ='".$_POST["msw_evaluation_additional_information"]."',
msw_evaluation_plan_ofc_are_and_discharge_was_communicated ='".$_POST["msw_evaluation_plan_ofc_are_and_discharge_was_communicated"]."',
msw_evaluation_plan_ofc_are_and_discharge_was_communicated_other ='".$_POST["msw_evaluation_plan_ofc_are_and_discharge_was_communicated_other"]."',
msw_evaluation_therapist_who_developed_poc ='".$_POST["msw_evaluation_therapist_who_developed_poc"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
