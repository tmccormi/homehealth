<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$addnew = array();

foreach($_POST as $key => $val) {
	if(is_array($val)) { $val = implode("#",$val); }
	$addnew[$key] = $val;
}
$topic_for_discussion=implode("#",$_POST["thirty_day_progress_note_topic_for_discussion"]);
$coordination_discipline=implode("#",$_POST["thirty_day_progress_note_care_coordination_involved_discipline"]);

if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_30_day_progress_note", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Thirty Day Progress Note", $newid, "thirtyday_progress_note", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_30_day_progress_note set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
thirty_day_progress_note_date ='".$_POST["thirty_day_progress_note_date"]."',
thirty_day_progress_note_mr='".$_POST["thirty_day_progress_note_mr"]."',
thirty_day_progress_note_date ='".$_POST["thirty_day_progress_note_date"]."',
thirty_day_progress_note_care_coordination_involved_discipline='".$coordination_discipline."',
thirty_day_progress_note_care_coordination_involved_other='".$_POST["thirty_day_progress_note_care_coordination_involved_other"]."',
thirty_day_progress_note_care_communicated_via='".$_POST["thirty_day_progress_note_care_communicated_via"]."',
thirty_day_progress_note_care_communicated_via_other='".$_POST["thirty_day_progress_note_care_communicated_via_other"]."',
thirty_day_progress_note_topic_for_discussion='".$topic_for_discussion."',
thirty_day_progress_note_topic_for_discussion_other='".$_POST["thirty_day_progress_note_topic_for_discussion_other"]."',
thirty_day_progress_note_details_of_discussion='".$_POST["thirty_day_progress_note_details_of_discussion"]."',
thirty_day_progress_note_details_for_resolutions='".$_POST["thirty_day_progress_note_details_for_resolutions"]."',
thirty_day_progress_note_people_descipline_attending='".$_POST["thirty_day_progress_note_people_descipline_attending"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
