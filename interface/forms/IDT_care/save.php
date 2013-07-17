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
$newid = formSubmit("forms_idt_care", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "IDT-CARE COORDINATION NOTE", $newid, "IDT_care", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_idt_care set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
idt_care_patient_name='".$_POST["idt_care_patient_name"]."',
idt_care_mr ='".$_POST["idt_care_mr"]."',
idt_care_date ='".$_POST["idt_care_date"]."',
idt_care_care_coordination_involved_discipline ='".$_POST["idt_care_care_coordination_involved_discipline"]."',
idt_care_care_coordination_involved_other='".$_POST["idt_care_care_coordination_involved_other"]."',
idt_care_care_communicated_via='".$_POST["idt_care_care_communicated_via"]."',
idt_care_care_communicated_via_other='".$_POST["idt_care_care_communicated_via_other"]."',
idt_care_topic_for_discussion ='".$_POST["idt_care_topic_for_discussion"]."',
idt_care_topic_for_discussion_other='".$_POST["idt_care_topic_for_discussion_other"]."',
idt_care_details_of_discussion='".$_POST["idt_care_details_of_discussion"]."',
idt_care_details_for_resolutions='".$_POST["idt_care_details_for_resolutions"]."',
idt_care_people_descipline_attending='".$_POST["idt_care_people_descipline_attending"]."',
idt_care_clinical_name_title_completing ='".$_POST["idt_care_clinical_name_title_completing"]."' 
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
