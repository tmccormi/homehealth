<?php

include_once(dirname(__file__)."/../../globals.php");

function newpatient_report( $pid, $encounter, $cols, $id) {
	$res = sqlStatement("select * from form_encounter where pid='$pid' and id='$id'");
	print "<table><tr><td>\n";
	while($result = sqlFetchArray($res)) {
		print "<span class=bold>" . xl('Reason') . ": </span><span class=text>" . $result{"reason"} . "<br>\n";
		print "<span class=bold>" . xl('Facility') . ": </span><span class=text>" . $result{"facility"} . "<br>\n";
		print "<span class=bold>" . xl('Onset/hosp. date') . ": </span><span class=text>" . $result{"onset_date"} . "<br>\n";
$caregiver = sqlFetchArray(sqlStatement("select lname, fname, mname from users where id=".$result{"caregiver"}.""));
		print "<span class=bold>" . xl('Caregiver') . ": </span><span class=text>" . $caregiver['fname'] ." ". $caregiver['lname'] . "<br>\n";
		print "<span class=bold>" . xl('Time In') . ": </span><span class=text>" . $result{"time_in"} . "<br>\n";
		print "<span class=bold>" . xl('Time Out') . ": </span><span class=text>" . $result{"time_out"} . "<br>\n";
		print "<span class=bold>" . xl('Billing Units') . ": </span><span class=text>" . $result{"billing_units"} . "<br>\n";
if($result{"billing_insurance"} == "True"){$billing_insurance = "Yes";}else if($result{"billing_insurance"} == "False"){$billing_insurance = "No";}
		print "<span class=bold>" . xl('Billing Insurance') . ": </span><span class=text>" . $billing_insurance . "<br>\n";
if($result{"notes_in"} == "True"){$notes_in = "Yes";}else if($result{"notes_in"} == "False"){$notes_in = "No";}
		print "<span class=bold>" . xl('Notes In') . ": </span><span class=text>" . $notes_in . "<br>\n";
if($result{"verified"} == "True"){$verified = "Yes";}else if($result{"verified"} == "False"){$verified = "No";}
		print "<span class=bold>" . xl('Verified') . ": </span><span class=text>" . $verified . "<br>\n";
if($result{"type_of_service"} != ''){
$res = sqlFetchArray(sqlStatement("select title from list_options where list_id = 'typeofservice' AND option_id = '".$result{"type_of_service"}."'"));
$service_type = $res['title'];
		print "<span class=bold>" . xl('Type of Service') . ": </span><span class=text>" . $service_type . "<br>\n";
}
if($result{"chart_of_accounts"} != ''){
$res = sqlFetchArray(sqlStatement("select title from list_options where list_id = 'chartofaccounts' AND option_id = '".$result{"chart_of_accounts"}."'"));
$coa = $res['title'];
		print "<span class=bold>" . xl('Chart of Accounts') . ": </span><span class=text>" . $coa . "<br>\n";
}
		print "<span class=bold>" . xl('Modifier 1') . ": </span><span class=text>" . $result{"modifier_1"} . "<br>\n";
		print "<span class=bold>" . xl('Modifier 2') . ": </span><span class=text>" . $result{"modifier_2"} . "<br>\n";
		print "<span class=bold>" . xl('Modifier 3') . ": </span><span class=text>" . $result{"modifier_3"} . "<br>\n";
		print "<span class=bold>" . xl('Modifier 4') . ": </span><span class=text>" . $result{"modifier_4"} . "<br>\n";

	}
	print "</td></tr></table>\n";
}

?>
