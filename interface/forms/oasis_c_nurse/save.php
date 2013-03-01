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
addForm($encounter, "OASIS Recert-Nursing", $newid,'oasis_c_nurse', $pid, $userauthorized);









$table_name="forms_oasis_c_nurse";
$form_id = $newid;
require_once($GLOBALS['fileroot']."/interface/reports/b1/generate_b1.php");

//Passing OASIS-C DISCHARGE ASSESSMENT Data to Synergy

try{
$client = new SoapClient($GLOBALS['synergy_webservice']);
}
catch(Exception $e){
echo "<script language='javascript'>alert('Could not Connect to Synergy Webservice. More Details: ".$e->getMessage()."');</script>";
}

$s_result = sqlStatement("select *from patient_data where pid=".$pid."");
$s_result = sqlFetchArray($s_result);

$enc_result = sqlStatement("select facility_id, onset_date from form_encounter where encounter=".$encounter."");
$enc_result = sqlFetchArray($enc_result);

/*
$esign_result = sqlStatement("select uid from eSignatures where `tid`=".$newid." AND `table`='oasis_discharge'");
$esign_result = sqlFetchArray($esign_result);
*/
$currUser = $_SESSION['authUser'];
$user_result = sqlStatement("select street, streetb, city, id, fname, lname, mname, phone, state, upin, zip from users where username='".$currUser."'");
$user_result = sqlFetchArray($user_result);

/*
if($esign_result['uid']!=0){
$caregiverSigned = "True";
}
else{
$caregiverSigned = "False";
}
*/

if($s_result['agency_name'] == 0){
$AgencyName = '';
$AgencyCode = '';
}
else{
$agency = sqlStatement("select organization from users where id=".$s_result['agency_name']."");
$agency = sqlFetchArray($agency);
$AgencyName = $agency['organization'];
$AgencyCode = $s_result['agency_name'];
}


$fl = explode("#", $addnew['oasis_c_nurse_functional_limitations']);
$fl_string = "";
if(in_array("Amputation",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Hearing",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Ambulation",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Dyspnea",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Bowel/Bladder (Incontinence)",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Paralysis",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Speech",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Contracture",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Endurance",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Legally Blind",$fl)){$fl_string.="1";}else{$fl_string.="0";}
if(in_array("Other",$fl)){$fl_string.="1";}else{$fl_string.="0";}

if($addnew['oasis_c_nurse_medicare_no']!=""){
$MedicareCovered = "True";
$Medication = $addnew['oasis_c_nurse_medicare_no'];
}
else{
$MedicareCovered = "False";
$Medication = "";
}

$ms = explode("#", $addnew['oasis_c_nurse_mental_status']);
$ms_string = "";
if(in_array("Oriented",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Comatose",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Forgetful",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Depressed",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Disoriented",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Lethargic",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Agitated",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Other",$ms)){$ms_string.="1";}else{$ms_string.="0";}

$Allergies = str_replace("#",", ",$addnew['oasis_c_nurse_allergies']);



$ap = explode("#", $addnew['oasis_c_nurse_activities_permitted']);
$ap_string = "";
if(in_array("Complete Bedrest",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Bedrest w/ BRP",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Up as tolerated",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Transfer Bed/Chair",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Exercises Prescribed",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Partial Weight Bearing",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Independent At Home",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Crutches",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Cane",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Wheelchair",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Walker",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("No Restrictions",$ap)){$ap_string.="1";}else{$ap_string.="0";}
if(in_array("Other",$ap)){$ap_string.="1";}else{$ap_string.="0";}



if($addnew['oasis_patient_diagnosis_2a']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2a'],8);}
if($addnew['oasis_patient_diagnosis_2b']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2b'],8);}
if($addnew['oasis_patient_diagnosis_2c']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2c'],8);}
if($addnew['oasis_patient_diagnosis_2d']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2d'],8);}
if($addnew['oasis_patient_diagnosis_2e']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2e'],8);}
if($addnew['oasis_patient_diagnosis_2f']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2f'],8);}
if($addnew['oasis_patient_diagnosis_2g']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2g'],8);}
if($addnew['oasis_patient_diagnosis_2h']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2h'],8);}
if($addnew['oasis_patient_diagnosis_2i']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2i'],8);}
if($addnew['oasis_patient_diagnosis_2j']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2j'],8);}
if($addnew['oasis_patient_diagnosis_2k']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2k'],8);}
if($addnew['oasis_patient_diagnosis_2l']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2l'],8);}
if($addnew['oasis_patient_diagnosis_2m']!=""){$DiagCodes .= str_pad(" ".$addnew['oasis_patient_diagnosis_2m'],8);}



if($addnew['oasis_patient_diagnosis_2a_indicator'] == "" || $addnew['oasis_patient_diagnosis_2a'] == ""){$DxIndicators = " ";}else{$DxIndicators = $addnew['oasis_patient_diagnosis_2a_indicator'];}
if($addnew['oasis_patient_diagnosis_2b_indicator'] == "" || $addnew['oasis_patient_diagnosis_2b'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2b_indicator'];}
if($addnew['oasis_patient_diagnosis_2c_indicator'] == "" || $addnew['oasis_patient_diagnosis_2c'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2c_indicator'];}
if($addnew['oasis_patient_diagnosis_2d_indicator'] == "" || $addnew['oasis_patient_diagnosis_2d'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2d_indicator'];}
if($addnew['oasis_patient_diagnosis_2e_indicator'] == "" || $addnew['oasis_patient_diagnosis_2e'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2e_indicator'];}
if($addnew['oasis_patient_diagnosis_2f_indicator'] == "" || $addnew['oasis_patient_diagnosis_2f'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2f_indicator'];}
if($addnew['oasis_patient_diagnosis_2g_indicator'] == "" || $addnew['oasis_patient_diagnosis_2g'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2g_indicator'];}
if($addnew['oasis_patient_diagnosis_2h_indicator'] == "" || $addnew['oasis_patient_diagnosis_2h'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2h_indicator'];}
if($addnew['oasis_patient_diagnosis_2i_indicator'] == "" || $addnew['oasis_patient_diagnosis_2i'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2i_indicator'];}
if($addnew['oasis_patient_diagnosis_2j_indicator'] == "" || $addnew['oasis_patient_diagnosis_2j'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2j_indicator'];}
if($addnew['oasis_patient_diagnosis_2k_indicator'] == "" || $addnew['oasis_patient_diagnosis_2k'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2k_indicator'];}
if($addnew['oasis_patient_diagnosis_2l_indicator'] == "" || $addnew['oasis_patient_diagnosis_2l'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2l_indicator'];}
if($addnew['oasis_patient_diagnosis_2m_indicator'] == "" || $addnew['oasis_patient_diagnosis_2m'] == ""){$DxIndicators .= " ";}else{$DxIndicators .= $addnew['oasis_patient_diagnosis_2m_indicator'];}


//$Nutrition = str_replace("#",", ",$addnew['oasis_nutrition_risks']); Not available in OASIS-C NURSE RECERTIFICATION


if($addnew['oasis_c_nurse_prognosis']!="")
$prognosis = $addnew['oasis_c_nurse_prognosis'] - 1;
$SafetyMeasures = str_replace("#",", ",$addnew['oasis_c_nurse_safety_measures']);

$Supplies = str_replace("#",", ",$addnew['oasis_c_nurse_dme_iv_supplies']);
if($Supplies=="")
$Supplies .= str_replace("#",", ",$addnew['oasis_c_nurse_dme_foley_supplies']);
else
$Supplies .= ", " . str_replace("#",", ",$addnew['oasis_c_nurse_dme_foley_supplies']);

$b1_string = substr_replace($b1_string,'',981,1);


$b1_string = b1_replacement(779,$b1_string);
$b1_string = b1_replacement(973,$b1_string);
$b1_string = b1_replacement(975,$b1_string);
$b1_string = b1_replacement(982,$b1_string);
$b1_string = b1_replacement(984,$b1_string);
$b1_string = b1_replacement(986,$b1_string);
$b1_string = b1_replacement(988,$b1_string);
$b1_string = b1_replacement(990,$b1_string);
$b1_string = b1_replacement(992,$b1_string);
$b1_string = b1_replacement(1042,$b1_string);
$b1_string = b1_replacement(1044,$b1_string);
$b1_string = b1_replacement(1046,$b1_string);
$b1_string = b1_replacement(1048,$b1_string);
$b1_string = b1_replacement(1050,$b1_string);
$b1_string = b1_replacement(1052,$b1_string);
$b1_string = b1_replacement(1055,$b1_string);
$b1_string = b1_replacement(1063,$b1_string);
$b1_string = b1_replacement(1065,$b1_string);
$b1_string = b1_replacement(1067,$b1_string);
$b1_string = b1_replacement(1069,$b1_string);
$b1_string = b1_replacement(1071,$b1_string);
$b1_string = b1_replacement(1073,$b1_string);
$b1_string = b1_replacement(1075,$b1_string);
$b1_string = b1_replacement(1077,$b1_string);
$b1_string = b1_replacement(1079,$b1_string);
$b1_string = b1_replacement(1096,$b1_string);
$b1_string = b1_replacement(1098,$b1_string);
$b1_string = b1_replacement(1100,$b1_string);
$b1_string = b1_replacement(1102,$b1_string);
$b1_string = b1_replacement(1104,$b1_string);
$b1_string = b1_replacement(1106,$b1_string);
$b1_string = b1_replacement(1109,$b1_string);
$b1_string = b1_replacement(1111,$b1_string);
$b1_string = b1_replacement(1113,$b1_string);
$b1_string = b1_replacement(1115,$b1_string);
$b1_string = b1_replacement(1117,$b1_string);
$b1_string = b1_replacement(1119,$b1_string);
$b1_string = b1_replacement(1121,$b1_string);
$b1_string = b1_replacement(1123,$b1_string);
$b1_string = b1_replacement(1125,$b1_string);
$b1_string = b1_replacement(1127,$b1_string);
$b1_string = b1_replacement(1129,$b1_string);
$b1_string = b1_replacement(1131,$b1_string);
$b1_string = b1_replacement(1133,$b1_string);
$b1_string = b1_replacement(1135,$b1_string);
$b1_string = b1_replacement(1137,$b1_string);
$b1_string = b1_replacement(1139,$b1_string);
$b1_string = b1_replacement(1141,$b1_string);
$b1_string = b1_replacement(1143,$b1_string);
$b1_string = b1_replacement(1145,$b1_string);
$b1_string = b1_replacement(1147,$b1_string);
$b1_string = b1_replacement(1149,$b1_string);
$b1_string = b1_replacement(1151,$b1_string);


$oasis_synergy = array(
0 => $AgencyCode, //Agency
1 => $s_result['pid'],  //PatientCode
2 => $enc_result['facility_id'],  //AdmissionSourceCode
3 => $Allergies,  //Allergies
4 => $ap_string,  //AP
5 => $addnew['oasis_c_nurse_activities_permitted_other'],  //AP_Desc
6 => -1,  //AssessmentFormType
7 => $b1_string,  //B1
8 => "False",  //Caregiver_Signed
9 => $addnew['oasis_c_nurse_certification_period_to'],  //CertEnd
10 => $addnew['oasis_c_nurse_certification'],  //Certification
11 => $addnew['oasis_c_nurse_certification_period_from'],  //CertStart
12 => $addnew['oasis_c_nurse_date_last_contacted_physician'],  //DateLastContactedPhysician
13 => $addnew['oasis_c_nurse_date_last_seen_by_physician'],  //DateLastSeenByPhysician
14 => $DiagCodes,  //DiagCodes
15 => "",  //DiagOnset
16 => $DxIndicators,  //DiagIndicators (DxIndicators)
17 => $user_result['street'],  //DR_ADDR1
18 => $user_result['streetb'],  //DR_ADDR2
19 => $user_result['city'],  //DR_CITY
20 => $user_result['id'],  //DR_ID
21 => $user_result['lname'] . ", " . $user_result['fname'] ." ". $user_result['mname'],  //DR_NAME
22 => $user_result['phone'],  //DR_PHONE
23 => $user_result['state'],  //DR_STATE
24 => $user_result['upin'],  //DR_UPIN
25 => $user_result['zip'],  //DR_ZIP
26 => $fl_string,  //FL
27 => $addnew['oasis_c_nurse_functional_limitations_other'],  //FL_Desc
28 => 0,  //FormType
29 => "",  //Goals
30 => "",  //GRS_Account_KEY
31 => "",  //GRS_OASIS_KEY
32 => "",  //IdentifyCaseAdministrator
33 => "",  //Item99
34 => "",  //LastInpatientStayAdmission
35 => "",  //LastInpatientStayDischarge
36 => $MedicareCovered,  //MedicareCovered
37 => $Medication,  //Medication
38 => $ms_string,  //MS
39 => $addnew['oasis_c_nurse_mental_status_other'],  //MS_Desc
40 => "",  //Nutrition
41 => "",  //Orders
42 => $s_result['street'],  //PatientAddress1
43 => $s_result['street2'],  //PatientAddress2
44 => $s_result['city'],  //PatientCity
45 => $s_result['phone_home'],  //PatientHomePhone
46 => 0,  //PatientReceivingCare
47 => "False",  //POTSign
48 => $prognosis,  //Prognosis
49 => $SafetyMeasures,  //Safety
50 => $Supplies,  //Supplies
51 => $addnew['oasis_c_nurse_soc_date']  //VerbalSOC

);


try{
$result3 = $client->ImportAnAssessment(array('username' => "SUPERVISOR",'password' => "SYNERGY", 'oasis_data' => $oasis_synergy));

$synergy_id = $result3->ImportAnAssessmentResult;
if($synergy_id!=''){
$res = sqlStatement("UPDATE forms_oasis_c_nurse SET synergy_id='".$synergy_id."' WHERE id = '".$newid."'");
}

}
catch(Exception $e){
echo "<script language='javascript'>alert('Problem when Exporting Data to Synergy. Make sure the Webservice is Running Properly. More Details: ".$e->getMessage()."');</script>";
}


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
