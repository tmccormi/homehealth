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
$newid = formSubmit("forms_home_environment", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Home Environment", $newid, "home_environment", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_home_environment set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
home_environment_patient_name='".$_POST["home_environment_patient_name"]."',
home_environment_SOC_date ='".$_POST["home_environment_SOC_date"]."',
home_environment_telephone ='".$_POST["home_environment_telephone"]."',
home_environment_gas_electrical ='".$_POST["home_environment_gas_electrical"]."',
home_environment_smoke_alarm_condition ='".$_POST["home_environment_smoke_alarm_condition"]."',
home_environment_fire_extinguisher ='".$_POST["home_environment_fire_extinguisher"]."',
home_environment_outside_exit ='".$_POST["home_environment_outside_exit"]."',
home_environment_alternate_exit ='".$_POST["home_environment_alternate_exit"]."',
home_environment_walking_pathway ='".$_POST["home_environment_walking_pathway"]."',
home_environment_stairs ='".$_POST["home_environment_stairs"]."',
home_environment_lighting ='".$_POST["home_environment_lighting"]."',
home_environment_heating ='".$_POST["home_environment_heating"]."',
home_environment_medicine ='".$_POST["home_environment_medicine"]."',
home_environment_bathroom ='".$_POST["home_environment_bathroom"]."',
home_environment_kitchen ='".$_POST["home_environment_kitchen"]."',
home_environment_eff_oxygen ='".$_POST["home_environment_eff_oxygen"]."',
home_environment_overall_sanitary ='".$_POST["home_environment_overall_sanitary"]."',
home_environment_sanitation_plumbing ='".$_POST["home_environment_sanitation_plumbing"]."',
home_environment_other ='".$_POST["home_environment_other"]."',
home_environment_see_additional_page ='".$_POST["home_environment_see_additional_page"]."',
home_environment_action_plan_1 ='".$_POST["home_environment_action_plan_1"]."',
home_environment_action_plan_2 ='".$_POST["home_environment_action_plan_2"]."',
home_environment_action_plan_3 ='".$_POST["home_environment_action_plan_3"]."',
home_environment_action_plan_4 ='".$_POST["home_environment_action_plan_4"]."',
home_environment_action_plan_5 ='".$_POST["home_environment_action_plan_5"]."',
home_environment_action_plan_6 ='".$_POST["home_environment_action_plan_6"]."',
home_environment_action_plan_7 ='".$_POST["home_environment_action_plan_7"]."',
home_environment_action_plan_8 ='".$_POST["home_environment_action_plan_8"]."',
home_environment_action_plan_9 ='".$_POST["home_environment_action_plan_9"]."',
home_environment_action_plan_10 ='".$_POST["home_environment_action_plan_10"]."',
home_environment_action_plan_11 ='".$_POST["home_environment_action_plan_11"]."',
home_environment_action_plan_12 ='".$_POST["home_environment_action_plan_12"]."',
home_environment_action_plan_13 ='".$_POST["home_environment_action_plan_13"]."',
home_environment_action_plan_14 ='".$_POST["home_environment_action_plan_14"]."',
home_environment_action_plan_15 ='".$_POST["home_environment_action_plan_15"]."',
home_environment_action_plan_16 ='".$_POST["home_environment_action_plan_16"]."',
home_environment_action_plan_17 ='".$_POST["home_environment_action_plan_17"]."',
home_environment_improve_safety ='".$_POST["home_environment_improve_safety"]."',
home_environment_improve_safety_other ='".$_POST["home_environment_improve_safety_other"]."',
home_environment_improve_safety_grab_bar ='".$_POST["home_environment_improve_safety_grab_bar"]."',
home_environment_improve_safety_smoke_alarm ='".$_POST["home_environment_improve_safety_smoke_alarm"]."',
home_environment_emergency ='".$_POST["home_environment_emergency"]."',
home_environment_emergency_explain ='".$_POST["home_environment_emergency_explain"]."',
home_environment_person_title ='".$_POST["home_environment_person_title"]."',
home_environment_person_title_date ='".$_POST["home_environment_person_title_date"]."',
home_environment_patient_sig ='".$_POST["home_environment_patient_sig"]."',
home_environment_patient_sig_date ='".$_POST["home_environment_patient_sig_date"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
