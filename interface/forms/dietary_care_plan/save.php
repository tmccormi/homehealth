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
$newid = formSubmit("forms_dietary_care_plan", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Dietary Care Plan", $newid, "dietary_care_plan", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_dietary_care_plan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
dietary_care_plan_last_name ='".$_POST["dietary_care_plan_last_name"]."',
dietary_care_plan_first_name ='".$_POST["dietary_care_plan_first_name"]."',
dietary_care_plan_visit_date ='".$_POST["dietary_care_plan_visit_date"]."',
dietary_care_plan_dob ='".implode("#",$_POST["dietary_care_plan_dob"])."',
dietary_care_plan_sex ='".$_POST["dietary_care_plan_sex"]."',
dietary_care_plan_weight ='".$_POST["dietary_care_plan_weight"]."',
dietary_care_plan_height ='".$_POST["dietary_care_plan_height"]."',
dietary_care_plan_frequency_and_duration ='".$_POST["dietary_care_plan_frequency_and_duration"]."',
dietary_care_plan_short_term_goals ='".$_POST["dietary_care_plan_short_term_goals"]."',
dietary_care_plan_long_term_goals ='".$_POST["dietary_care_plan_long_term_goals"]."',
dietary_care_plan_treatment ='".$_POST["dietary_care_plan_treatment"]."',
dietary_care_plan_rd_signature ='".implode("#",$_POST["dietary_care_plan_rd_signature"])."',
dietary_care_plan_form_date ='".$_POST["dietary_care_plan_form_date"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
