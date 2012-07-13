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
$newid = formSubmit("forms_physician_orders", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Physician Orders", $newid, "physician_orders", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_physician_orders set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
physician_orders_patient_name='".$_POST["physician_orders_patient_name"]."',
physician_orders_mr ='".$_POST["physician_orders_mr"]."',
physician_orders_date ='".$_POST["physician_orders_date"]."',
physician_orders_patient_dob = '".$_POST["physician_orders_patient_dob"]."',
physician_orders_physician  = '".$_POST["physician_orders_physician"]."',
physician_orders_diagnosis  = '".$_POST["physician_orders_diagnosis"]."',
physician_orders_problem  = '".$_POST["physician_orders_problem"]."',
physician_orders_discipline  = '".implode("#",$_POST["physician_orders_discipline"])."',
physician_orders_discipline_other  = '".$_POST["physician_orders_discipline_other"]."',
physician_orders_specific_orders  = '".$_POST["physician_orders_specific_orders"]."',
physician_orders_effective_date  = '".$_POST["physician_orders_effective_date"]."',
physician_orders_communication  = '".implode("#",$_POST["physician_orders_communication"])."',
physician_orders_communication_other  = '".$_POST["physician_orders_communication_other"]."',
physician_orders_physician_signature  = '".$_POST["physician_orders_physician_signature"]."',
physician_orders_date1  = '".$_POST["physician_orders_date1"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
