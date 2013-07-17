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
$newid = formSubmit("forms_oasis_nursing_resumption", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Oasis Nursing Resumption", $newid,'oasis_nursing_resumption', $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
$search_qry = array();

$query = mysql_query("show columns from forms_oasis_nursing_resumption");
while($fields = mysql_fetch_array($query)) {
	$field_name[] = $fields['Field'];
}
$array = array('id', 'date','pid','user','groupname','authorized','activity');
foreach($field_name as $key => $val) {
	if(in_array($val,$array)) { continue; } 
	$post_variable = $_POST[$val];
	if(is_array($post_variable)) { $post_variable = implode("#",$post_variable); }
	$search_qry[] = " $val = '".mysql_real_escape_string($post_variable)."'";
}

sqlInsert("update forms_oasis_nursing_resumption set". implode(",", $search_qry) ." where id=$id");
}

$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
