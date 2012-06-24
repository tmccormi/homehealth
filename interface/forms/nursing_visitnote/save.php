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
$newid = formSubmit("forms_nursing_visitnote", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Nursing Visitnote", $newid, "nursing_visitnote", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
$search_qry = array();
foreach($_POST as $key => $val) {
	if(is_array($val)) { $val = implode("#",$val); }
	$search_qry[] = " $key = '$val'";
}
//echo "update forms_nursing_visitnote set". implode(",", $search_qry) ." where id=$id";

sqlInsert("update forms_nursing_visitnote set". implode(",", $search_qry) ." where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
