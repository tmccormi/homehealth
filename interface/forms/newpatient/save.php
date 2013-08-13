<?php
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

require_once("../../globals.php");
require_once("$srcdir/forms.inc");
require_once("$srcdir/sql.inc");
require_once("$srcdir/encounter.inc");
require_once("$srcdir/acl.inc");
require_once("$srcdir/formatting.inc.php");
require_once("$srcdir/formdata.inc.php");
require_once("$srcdir/classes/POSRef.class.php");
ini_set("soap.wsdl_cache_enabled","0");

$conn = $GLOBALS['adodb']['db'];

$date             = formData('form_date');
$onset_date       = formData('form_onset_date');
$sensitivity      = formData('form_sensitivity');
$pc_catid         = formData('pc_catid');
$facility_id      = formData('facility_id');
$billing_facility = formData('billing_facility');
$reason           = formData('reason');
$mode             = formData('mode');
$referral_source  = formData('form_referral_source');
$episode_id       = formData('episode_id');
$caregiver     = formData('form_caregiver');
$time_in     = formData('form_time_in');
$time_out     = formData('form_time_out');
$billing_units     = formData('form_billing_units');
$billing_insurance     = formData('form_billing_insurance');
$notes_in     = formData('form_notes_in');
$verified     = formData('form_verified');
$type_of_service     = formData('form_type_of_service');
$modifier_1     = formData('form_modifier_1');
$modifier_2     = formData('form_modifier_2');
$modifier_3     = formData('form_modifier_3');
$modifier_4     = formData('form_modifier_4');

$facilityresult = sqlQuery("select name, pos_code FROM facility WHERE id = $facility_id");
$facility = $facilityresult['name'];


$pc = new POSRef();
foreach ($pc->get_pos_ref() as $pos) {
    if ($facilityresult['pos_code'] == $pos['code']) {
	$PlaceOfService = $pos['title'];
    }
}

if ($GLOBALS['concurrent_layout'])
  $normalurl = "patient_file/encounter/encounter_top.php";
else
  $normalurl = "$rootdir/patient_file/encounter/patient_encounter.php";

$nexturl = $normalurl;

if ($mode == 'new')
{
  $provider_id = $userauthorized ? $_SESSION['authUserID'] : 0;
  $encounter = $conn->GenID("sequences");
  
  addForm($encounter, "New Patient Encounter",
    sqlInsert("INSERT INTO form_encounter SET " .
      "date = '".mysql_real_escape_string($date)."', " .
      "onset_date = '".mysql_real_escape_string($onset_date)."', " .
      "reason = '".mysql_real_escape_string($reason)."', " .
      "facility = '".mysql_real_escape_string($facility)."', " .
      "pc_catid = '".mysql_real_escape_string($pc_catid)."', " .
      "facility_id = '".mysql_real_escape_string($facility_id)."', " .
      "billing_facility = '".mysql_real_escape_string($billing_facility)."', " .
      "sensitivity = '".mysql_real_escape_string($sensitivity)."', " .
      "referral_source = '".mysql_real_escape_string($referral_source)."', " .
      "pid = '".mysql_real_escape_string($pid)."', " .
      "encounter = '".mysql_real_escape_string($encounter)."', " .
      "provider_id = '".mysql_real_escape_string($provider_id)."'," .
	  "caregiver = '".mysql_real_escape_string($caregiver)."'," .
	  "time_in = '".mysql_real_escape_string($time_in)."'," .
	  "time_out = '".mysql_real_escape_string($time_out)."'," .
	  "billing_units = '".mysql_real_escape_string($billing_units)."'," .
	  "billing_insurance = '".mysql_real_escape_string($billing_insurance)."'," .
	  "notes_in = '".mysql_real_escape_string($notes_in)."'," .
	  "verified = '".mysql_real_escape_string($verified)."'," .
	  "type_of_service = '".mysql_real_escape_string($type_of_service)."'," .
	  "modifier_1 = '".mysql_real_escape_string($modifier_1)."'," .
	  "modifier_2 = '".mysql_real_escape_string($modifier_2)."'," .
	  "modifier_3 = '".mysql_real_escape_string($modifier_3)."'," .
	  "modifier_4 = '".mysql_real_escape_string($modifier_4)."'," .
      "episode_id = '".mysql_real_escape_string($episode_id)."'"),
    "newpatient", mysql_real_escape_string($pid), mysql_real_escape_string($userauthorized), mysql_real_escape_string($date));

// initialize client to null. if synergy webservice not enabled, bypass all the remote calls§Œ  
$client = null;
if ( $GLOBALS['synergy_webservice_enable'] ) {
    try{
    $client = new SoapClient($GLOBALS['synergy_webservice'], array('cache_wsdl' => WSDL_CACHE_NONE));
    }
    catch(Exception $e){
    echo "<script language='javascript'>alert('Could not Connect to Synergy Webservice.');</script>";
    }
}

if( isset($client) && 
        $client != null ){

$s_result = sqlStatement("select *from patient_data where pid=".$pid."");
$s_result = sqlFetchArray($s_result);

$p_result = sqlStatement("select *from employer_data where pid=".$pid."");
$p_result = sqlFetchArray($p_result);

$error_flag = 0;
$error_msg = '';

if($s_result['agency_name'] == '0'){
$AgencyName = '';
$AgencyCode = '';
}
else{
$agency = sqlStatement("select synergy_id, organization from users where id=".$s_result['agency_name']."");
$agency = sqlFetchArray($agency);
$AgencyName = $agency['organization'];

if($agency['synergy_id'] != ''){
$AgencyCode = $agency['synergy_id'];
}
else{
$error_flag = 1;
$error_msg .= "\\nAgency\'s Synergy ID";
}

}

$caregiver_name = sqlFetchArray(sqlStatement("select fname, lname, mname, synergy_id, username from users where id=".$caregiver.""));
if($time_in!="")
$time_in.=':00';
if($time_out!="")
$time_out.=':00';

$caregiver = $caregiver_name['synergy_id'];

$tos = sqlFetchArray(sqlStatement("select title from list_options where list_id = 'typeofservice' AND option_id='".$type_of_service."'"));
$type_of_service_val = $tos['title'];

$coa_type = sqlFetchArray(sqlStatement("select name from gacl_aro_groups where id=(select group_id from gacl_groups_aro_map where aro_id=(select id from gacl_aro where value='".$caregiver_name['username']."'))"));

switch($coa_type['name']){

case 'Physical Therapist':
$chart_of_accounts = "421";
break;

case 'Speech Therapist':
$chart_of_accounts = "441";
break;

case 'Occupational Therapist':
$chart_of_accounts = "431";
break;

case 'Nurse':
$chart_of_accounts = "551";
break;

case 'Social Worker':
$chart_of_accounts = "561";
break;

case 'Home Health Aide':
$chart_of_accounts = "571";
break;

default:
$chart_of_accounts = "571";
break;

}


//New Changes

if($notes_in=="True")
{
$notes_in = "True";
}
else{
$notes_in = "False";
}

if($billing_insurance=="True")
{
$billing_insurance = "True";
}
else{
$billing_insurance = "False";
}

if($verified=="True")
{
$verified = "True";
}
else{
$verified = "False";
}

$yr = substr($date,0,4);
$mn = substr($date,5,2);
$dy = substr($date,8,2);
$PeriodStart = $dy."-".$mn."-".$yr;


$encounter_synergy = array(
0 => intval($AgencyCode), //Agency
1 => $AgencyName, //Agency
2 => $s_result['pubpid'],  //PatientCode
3 => $s_result['lname'] .', '. $s_result['fname'] .' '. $s_result['mname'],  //PatientsName
4 => $s_result['pubpid'],  //MedicalRecordNumber
5 => $date,  //StartOfCare
6 => $caregiver,  //CurrentPhysician **Pending
7 => $caregiver,  //Caregiver
8 => $caregiver_name['lname'] .', '. $caregiver_name['mname'] .' '. $caregiver_name['fname'],  //Caregiver
9 => $time_in,  //TimeIn
10 => $time_out,  //TimeOut
11 => floatval($billing_units),  //BillingUnits
12 => $billing_insurance,  //BillInsurance
13 => $notes_in,  //NotesIn
14 => $verified,  //Verified
15 => intval($facilityresult['pos_code']),  //PlaceOfService - Key
16 => $PlaceOfService,  //PlaceOfService - Value
17 => intval($type_of_service),  //TypeOfService - Key
18 => $type_of_service_val, //TypeOfService - Value
19 => $modifier_1,  //Modifier1
20 => $modifier_2,  //Modifier2
21 => $modifier_3,  //Modifier3
22 => $modifier_4,  //Modifier4
23 => $PeriodStart,  //PeriodStart
24 => $chart_of_accounts //Rev code in Synergy
);

$res1 = sqlFetchArray(sqlStatement("SELECT synergy_username, synergy_password FROM users WHERE id=".$s_result['agency_name']));

if($res1['synergy_username']!='' && $res1['synergy_password']!=''){
if($error_flag == 0){
try{
$result3 = $client->AddVisitNotesForPatient(array('username' => $res1['synergy_username'],'password' => $res1['synergy_password'], 'encounter_data' => $encounter_synergy));

$code = $result3->AddVisitNotesForPatientResult->Label->m_LedgerCode->m_ID;
if($code!=''){
$res = sqlStatement("UPDATE form_encounter SET synergy_id='".$code."' WHERE encounter = '".$encounter."'");
echo "<script language='javascript'>alert('Encounter Data Successfully Exported to Synergy');</script>";
}
}
catch(Exception $e){
echo "<script language='javascript'>alert('Problem when Exporting Data to Synergy. More Details: ".cleanSynergy($e->getMessage())."');</script>";
}
}else{
echo "<script language='javascript'>alert('The Following Details are Missing:".$error_msg."');</script>";
}
}else{
echo "<script language='javascript'>alert('Synergy Login Information Not Available for the Selected Agency');</script>";
}

}

}
else if ($mode == 'update')
{
  $id = $_POST["id"];
  $result = sqlQuery("SELECT encounter, sensitivity FROM form_encounter WHERE id = '$id'");
  if ($result['sensitivity'] && !acl_check('sensitivities', $result['sensitivity'])) {
   die("You are not authorized to see this encounter.");
  }
  $encounter = $result['encounter'];
  // See view.php to allow or disallow updates of the encounter date.
  $datepart = acl_check('encounters', 'date_a') ? "date = '$date', " : "";
  sqlStatement("UPDATE form_encounter SET " .
    $datepart .
    "onset_date = '".mysql_real_escape_string($onset_date)."', " .
    "reason = '".mysql_real_escape_string($reason)."', " .
    "facility = '".mysql_real_escape_string($facility)."', " .
    "pc_catid = '".mysql_real_escape_string($pc_catid)."', " .
    "facility_id = '".mysql_real_escape_string($facility_id)."', " .
    "billing_facility = '".mysql_real_escape_string($billing_facility)."', " .
    "sensitivity = '".mysql_real_escape_string($sensitivity)."', " .
    "referral_source = '".mysql_real_escape_string($referral_source)."', " .
	"caregiver = '".mysql_real_escape_string($caregiver)."'," .
	"time_in = '".mysql_real_escape_string($time_in)."'," .
	"time_out = '".mysql_real_escape_string($time_out)."'," .
	"billing_units = '".mysql_real_escape_string($billing_units)."'," .
	"billing_insurance = '".mysql_real_escape_string($billing_insurance)."'," .
	"notes_in = '".mysql_real_escape_string($notes_in)."'," .
	"verified = '".mysql_real_escape_string($verified)."'," .
	"type_of_service = '".mysql_real_escape_string($type_of_service)."'," .
	"modifier_1 = '".mysql_real_escape_string($modifier_1)."'," .
	"modifier_2 = '".mysql_real_escape_string($modifier_2)."'," .
	"modifier_3 = '".mysql_real_escape_string($modifier_3)."'," .
	"modifier_4 = '".mysql_real_escape_string($modifier_4)."'," .
    "episode_id = '".mysql_real_escape_string($episode_id)."' " .
    "WHERE id = '".mysql_real_escape_string($id)."'");

$id_for_synergy = sqlFetchArray(sqlStatement("SELECT synergy_id FROM form_encounter WHERE id=".$id.""));
$synergy_id = $id_for_synergy['synergy_id'];

$client = null;
if ( $GLOBALS['synergy_webservice_enable'] ) {
    try{
    $client = new SoapClient($GLOBALS['synergy_webservice'], array('cache_wsdl' => WSDL_CACHE_NONE));
    }
    catch(Exception $e){
    echo "<script language='javascript'>alert('Could not Connect to Synergy Webservice.');</script>";
    }
}

if ( isset($client) && 
        $client != null ) {

$s_result = sqlStatement("select *from patient_data where pid=".$pid."");
$s_result = sqlFetchArray($s_result);

$p_result = sqlStatement("select *from employer_data where pid=".$pid."");
$p_result = sqlFetchArray($p_result);

$error_flag = 0;
$error_msg = '';

if($s_result['agency_name'] == '0'){
$AgencyName = '';
$AgencyCode = '';
}
else{
$agency = sqlStatement("select synergy_id, organization from users where id=".$s_result['agency_name']."");
$agency = sqlFetchArray($agency);
$AgencyName = $agency['organization'];

if($agency['synergy_id'] != ''){
$AgencyCode = $agency['synergy_id'];
}
else{
$error_flag = 1;
$error_msg .= "\\nAgency\'s Synergy ID";
}

}

$caregiver_name = sqlFetchArray(sqlStatement("select fname, lname, mname, synergy_id, username from users where id=".$caregiver.""));
$time_in.=':00';
$time_out.=':00';

$caregiver = $caregiver_name['synergy_id'];

$tos = sqlFetchArray(sqlStatement("select title from list_options where list_id = 'typeofservice' AND option_id='".$type_of_service."'"));
$type_of_service_val = $tos['title'];

$coa_type = sqlFetchArray(sqlStatement("select name from gacl_aro_groups where id=(select group_id from gacl_groups_aro_map where aro_id=(select id from gacl_aro where value='".$caregiver_name['username']."'))"));


switch($coa_type['name']){

case 'Physical Therapist':
$chart_of_accounts = "421";
break;

case 'Speech Therapist':
$chart_of_accounts = "441";
break;

case 'Occupational Therapist':
$chart_of_accounts = "431";
break;

case 'Nurse':
$chart_of_accounts = "551";
break;

case 'Social Worker':
$chart_of_accounts = "561";
break;

case 'Home Health Aide':
$chart_of_accounts = "571";
break;

default:
$chart_of_accounts = "571";
break;

}

//New Changes

if($notes_in=="True")
{
$notes_in = "True";
}
else{
$notes_in = "False";
}

if($billing_insurance=="True")
{
$billing_insurance = "True";
}
else{
$billing_insurance = "False";
}

if($verified=="True")
{
$verified = "True";
}
else{
$verified = "False";
}

$yr = substr($date,0,4);
$mn = substr($date,5,2);
$dy = substr($date,8,2);
$PeriodStart = $dy."-".$mn."-".$yr;

$encounter_synergy = array(
0 => intval($AgencyCode), //Agency
1 => $AgencyName, //Agency
2 => $s_result['pubpid'],  //PatientCode
3 => $s_result['lname'] .', '. $s_result['fname'] .' '. $s_result['mname'],  //PatientsName
4 => $s_result['pubpid'],  //MedicalRecordNumber
5 => $date,  //StartOfCare
6 => $caregiver,  //CurrentPhysician **Pending
7 => $caregiver,  //Caregiver
8 => $caregiver_name['lname'] .', '. $caregiver_name['mname'] .' '. $caregiver_name['fname'],  //Caregiver
9 => $time_in,  //TimeIn
10 => $time_out,  //TimeOut
11 => floatval($billing_units),  //BillingUnits
12 => $billing_insurance,  //BillInsurance
13 => $notes_in,  //NotesIn
14 => $verified,  //Verified
15 => intval($facilityresult['pos_code']),  //PlaceOfService - Key
16 => $PlaceOfService,  //PlaceOfService - Value
17 => intval($type_of_service),  //TypeOfService - Key
18 => $type_of_service_val, //TypeOfService - Value
19 => $modifier_1,  //Modifier1
20 => $modifier_2,  //Modifier2
21 => $modifier_3,  //Modifier3
22 => $modifier_4,  //Modifier4
23 => $PeriodStart,  //PeriodStart
24 => $chart_of_accounts //Rev code in Synergy
);

$res1 = sqlFetchArray(sqlStatement("SELECT synergy_username, synergy_password FROM users WHERE id=".$s_result['agency_name']));

if($res1['synergy_username']!='' && $res1['synergy_password']!=''){
if($error_flag == 0){
try{
$result3 = $client->AddVisitNotesForPatient(array('username' => $res1['synergy_username'],'password' => $res1['synergy_password'], 'encounter_data' => $encounter_synergy, 'synergy_id' => $synergy_id));

$code = $result3->AddVisitNotesForPatientResult->Label->m_LedgerCode->m_ID;
if($code!=''){
$res = sqlStatement("UPDATE form_encounter SET synergy_id='".$code."' WHERE encounter = '".$encounter."'");
echo "<script language='javascript'>alert('Encounter Data Successfully Exported to Synergy');</script>";
}
}
catch(Exception $e){
echo "<script language='javascript'>alert('Problem when Exporting Data to Synergy. More Details: ".cleanSynergy($e->getMessage())."');</script>";
}
}else{
echo "<script language='javascript'>alert('The Following Details are Missing:".$error_msg."');</script>";
}
}else{
echo "<script language='javascript'>alert('Synergy Login Information Not Available for the Selected Agency');</script>";
}
}

}
else {
  die("Unknown mode '$mode'");
}

setencounter($encounter);

// Update the list of issues associated with this encounter.
sqlStatement("DELETE FROM issue_encounter WHERE " .
  "pid = '$pid' AND encounter = '$encounter'");
if (is_array($_POST['issues'])) {
  foreach ($_POST['issues'] as $issue) {
    $query = "INSERT INTO issue_encounter ( " .
      "pid, list_id, encounter " .
      ") VALUES ( " .
      "'$pid', '$issue', '$encounter'" .
    ")";
    sqlStatement($query);
  }
}

// Custom for Chelsea FC.
//
if ($mode == 'new' && $GLOBALS['default_new_encounter_form'] == 'football_injury_audit') {

  // If there are any "football injury" issues (medical problems without
  // "illness" in the title) linked to this encounter, but no encounter linked
  // to such an issue has the injury form in it, then present that form.

  $lres = sqlStatement("SELECT list_id " .
    "FROM issue_encounter, lists WHERE " .
    "issue_encounter.pid = '$pid' AND " .
    "issue_encounter.encounter = '$encounter' AND " .
    "lists.id = issue_encounter.list_id AND " .
    "lists.type = 'medical_problem' AND " .
    "lists.title NOT LIKE '%Illness%'");

  if (mysql_num_rows($lres)) {
    $nexturl = "patient_file/encounter/load_form.php?formname=" .
      $GLOBALS['default_new_encounter_form'];
    while ($lrow = sqlFetchArray($lres)) {
      $frow = sqlQuery("SELECT count(*) AS count " .
         "FROM issue_encounter, forms WHERE " .
         "issue_encounter.list_id = '" . $lrow['list_id'] . "' AND " .
         "forms.pid = issue_encounter.pid AND " .
         "forms.encounter = issue_encounter.encounter AND " .
         "forms.formdir = '" . $GLOBALS['default_new_encounter_form'] . "'");
      if ($frow['count']) $nexturl = $normalurl;
    }
  }
}
$result4 = sqlStatement("SELECT fe.encounter,fe.date,openemr_postcalendar_categories.pc_catname FROM form_encounter AS fe ".
	" left join openemr_postcalendar_categories on fe.pc_catid=openemr_postcalendar_categories.pc_catid  WHERE fe.pid = '$pid' order by fe.date desc");
?>
<html>
<body>
<script language='JavaScript'>
<?php if ($GLOBALS['concurrent_layout'])
 {//Encounter details are stored to javacript as array.
?>
	EncounterDateArray=new Array;
	CalendarCategoryArray=new Array;
	EncounterIdArray=new Array;
	Count=0;
	 <?php
			   if(sqlNumRows($result4)>0)
				while($rowresult4 = sqlFetchArray($result4))
				 {
	?>
					EncounterIdArray[Count]='<?php echo htmlspecialchars($rowresult4['encounter'], ENT_QUOTES); ?>';
					EncounterDateArray[Count]='<?php echo htmlspecialchars(oeFormatShortDate(date("Y-m-d", strtotime($rowresult4['date']))), ENT_QUOTES); ?>';
					CalendarCategoryArray[Count]='<?php echo htmlspecialchars( xl_appt_category($rowresult4['pc_catname']), ENT_QUOTES); ?>';
					Count++;
	 <?php
				 }
	 ?>
	 top.window.parent.left_nav.setPatientEncounter(EncounterIdArray,EncounterDateArray,CalendarCategoryArray);
<?php } ?>
 top.restoreSession();
<?php if ($GLOBALS['concurrent_layout']) { ?>
<?php if ($mode == 'new') { ?>
 parent.left_nav.setEncounter(<?php echo "'" . oeFormatShortDate($date) . "', $encounter, window.name"; ?>);
 parent.left_nav.setRadio(window.name, 'enc');
<?php } // end if new encounter ?>
 parent.left_nav.loadFrame('enc2', window.name, '<?php echo $nexturl; ?>');
<?php } else { // end if concurrent layout ?>
 window.location="<?php echo $nexturl; ?>";
<?php } // end not concurrent layout ?>
</script>

</body>
</html>
