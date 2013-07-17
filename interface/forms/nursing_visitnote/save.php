<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$addnew = array();
if ($_GET["mode"] == "new"){
foreach($_POST as $key => $val) {
	if(is_array($val)) { $val = implode("#",$val); }
	$addnew[$key] = mysql_real_escape_string($val);
}
if ($encounter == "")
$encounter = date("Ymd");

$newid = formSubmit("forms_nursing_visitnote", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Nursing Visitnote", $newid, "nursing_visitnote", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
$search_qry = array();

$query = mysql_query("show columns from forms_nursing_visitnote");
while($fields = mysql_fetch_array($query)) {
	$field_name[] = $fields['Field'];
}
$array = array('id', 'date','pid','user','groupname','authorized','activity','visitnote_date','visitnote_Time_In','visitnote_Time_Out');
foreach($field_name as $key => $val) {
	if(in_array($val,$array)) { continue; } 
	$post_variable = $_POST[$val];
	if(is_array($post_variable)) { $post_variable = implode("#",$post_variable); }
	$search_qry[] = " $val = '".mysql_real_escape_string($post_variable)."'";
}
//echo "update forms_nursing_visitnote set". implode(",", $search_qry) ." where id=$id";

sqlInsert("update forms_nursing_visitnote set". implode(",", $search_qry) ." where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
