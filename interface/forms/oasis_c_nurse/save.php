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


$newid = formSubmit("forms_oasis_c_nurse", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Oasis-C Nurse Recertification", $newid,'oasis_c_nurse', $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
$search_qry = array();

$query = mysql_query("select column_name from information_schema.columns where table_name = 'forms_oasis_c_nurse'");
while($fields = mysql_fetch_array($query)) {
	$field_name[] = $fields['column_name'];
}
$array = array('id', 'date','pid','user','groupname','authorized','activity');
foreach($field_name as $key => $val) {
	if(in_array($val,$array)) { continue; } 
	$post_variable = $_POST[$val];
	if(is_array($post_variable)) { $post_variable = implode("#",$post_variable); }
	$search_qry[] = " $val = '$post_variable'";
}

//echo "update forms_nursing_visitnote set". implode(",", $search_qry) ." where id=$id";
//exit;

sqlInsert("update forms_oasis_c_nurse set". implode(",", $search_qry) ." where id=$id");
}

$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
