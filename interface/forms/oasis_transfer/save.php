<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
include_once ("functions.php");

if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){

$_POST["oasistransfer_mental_status"]  = implode("#",$_POST["oasistransfer_mental_status"]);
$_POST["oasistransfer_functional_limitations"]  = implode("#",$_POST["oasistransfer_functional_limitations"]);
$_POST["oasistransfer_safety_measures"]  = implode("#",$_POST["oasistransfer_safety_measures"]);
$_POST["oasistransfer_dme_iv_supplies"]  = implode("#",$_POST["oasistransfer_dme_iv_supplies"]);
$_POST["oasistransfer_dme_foley_supplies"]  = implode("#",$_POST["oasistransfer_dme_foley_supplies"]);

$newid = formSubmit("forms_oasis_transfer", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "OASIS-C Transfer", $newid, "oasis_transfer", $pid, $userauthorized);


$table_name="forms_oasis_transfer";
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


$fl = explode("#", $_POST['oasistransfer_functional_limitations']);
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

/*
if($_POST['oasis_therapy_medicare_no']!=""){
$MedicareCovered = "True";
$Medication = $_POST['oasis_therapy_medicare_no'];
}
else{
$MedicareCovered = "False";
$Medication = "";
}
*/


$ms = explode("#", $_POST['oasistransfer_mental_status']);
$ms_string = "";
if(in_array("Oriented",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Comatose",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Forgetful",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Depressed",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Disoriented",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Lethargic",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Agitated",$ms)){$ms_string.="1";}else{$ms_string.="0";}
if(in_array("Other",$ms)){$ms_string.="1";}else{$ms_string.="0";}

//$Nutrition = str_replace("#",", ",$_POST['oasis_nutrition_risks']);
if($_POST['oasistransfer_prognosis']!="")
$prognosis = $_POST['oasistransfer_prognosis'] - 1;
$SafetyMeasures = str_replace("#",", ",$_POST['oasistransfer_safety_measures']);

$Supplies = str_replace("#",", ",$_POST['oasistransfer_dme_iv_supplies']);
if($Supplies=="")
$Supplies .= str_replace("#",", ",$_POST['oasistransfer_dme_foley_supplies']);
else
$Supplies .= ", " . str_replace("#",", ",$_POST['oasistransfer_dme_foley_supplies']);

$b1_string = substr_replace($b1_string,'',981,1);


$pt_name = returnpatientName();
$b1_string = substr_replace($b1_string,str_pad(substr($pt_name,0,34),34),193,34);

if(substr($b1_string,728,8)=="00000000")
$b1_string = substr_replace($b1_string,'        ',728,8);


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
3 => "",  //Allergies
4 => "",  //AP
5 => "",  //AP_Desc
6 => -1,  //AssessmentFormType
7 => $b1_string,  //B1
8 => "False",  //Caregiver_Signed
9 => "",  //CertEnd
10 => $_POST['oasistransfer_certification'],  //Certification
11 => "",  //CertStart
12 => $_POST['oasistransfer_date_last_contacted_physician'],  //DateLastContactedPhysician
13 => $_POST['oasistransfer_date_last_seen_by_physician'],  //DateLastSeenByPhysician
14 => "",  //DiagCodes
15 => "",  //DiagOnset
16 => "",  //DiagIndicators (DxIndicators)
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
27 => $_POST['oasistransfer_functional_limitations_other'],  //FL_Desc
28 => 0,  //FormType
29 => "",  //Goals
30 => "",  //GRS_Account_KEY
31 => "",  //GRS_OASIS_KEY
32 => "",  //IdentifyCaseAdministrator
33 => "",  //Item99
34 => "",  //LastInpatientStayAdmission
35 => "",  //LastInpatientStayDischarge
36 => "False",  //MedicareCovered
37 => "",  //Medication
38 => $ms_string,  //MS
39 => $_POST['oasistransfer_mental_status_other'],  //MS_Desc
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
51 => $_POST['oasis_therapy_soc_date']  //VerbalSOC

);

try{
$result3 = $client->ImportAnAssessment(array('username' => "SUPERVISOR",'password' => "SYNERGY", 'oasis_data' => $oasis_synergy));

$synergy_id = $result3->ImportAnAssessmentResult;
if($synergy_id!=''){
$res = sqlStatement("UPDATE forms_oasis_transfer SET synergy_id='".$synergy_id."' WHERE id = '".$newid."'");
}

}
catch(Exception $e){
echo "<script language='javascript'>alert('Problem when Exporting Data to Synergy. Make sure the Webservice is Running Properly. More Details: ".$e->getMessage()."');</script>";
}

}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_oasis_transfer set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
oasistransfer_Caregiver ='".$_POST["oasistransfer_Caregiver"]."',
oasistransfer_Visit_Date  ='".$_POST["oasistransfer_Visit_Date"]."',
oasistransfer_Time_In  ='".$_POST["oasistransfer_Time_In"]."',
oasistransfer_Time_Out  ='".$_POST["oasistransfer_Time_Out"]."',
oasistransfer_Discipline_of_Person_completing_Assessment  ='".$_POST["oasistransfer_Discipline_of_Person_completing_Assessment"]."',
oasis_therapy_soc_date  ='".$_POST["oasis_therapy_soc_date"]."',
oasistransfer_Assessment_Completed_Date  ='".$_POST["oasistransfer_Assessment_Completed_Date"]."',
oasistransfer_Transfer_to_an_InPatient_Facility ='".$_POST["oasistransfer_Transfer_to_an_InPatient_Facility"]."',
oasistransfer_Influenza_Vaccine_received ='".$_POST["oasistransfer_Influenza_Vaccine_received"]."',
oasistransfer_Reason_For_Influenza_Vaccine_Not_Received  ='".$_POST["oasistransfer_Reason_For_Influenza_Vaccine_Not_Received"]."',
oasistransfer_Pneumococcal_Vaccine_Recieved  ='".$_POST["oasistransfer_Pneumococcal_Vaccine_Recieved"]."',
oasistransfer_Used_Emergent_Care  ='".$_POST["oasistransfer_Used_Emergent_Care"]."',
oasistransfer_In_Emergentcare_for_Improper_medication  ='".$_POST["oasistransfer_In_Emergentcare_for_Improper_medication"]."',
oasistransfer_In_Emergentcare_for_Injury_caused_by_fall  ='".$_POST["oasistransfer_In_Emergentcare_for_Injury_caused_by_fall"]."',
oasistransfer_In_Emergentcare_for_Respiratory_infection  ='".$_POST["oasistransfer_In_Emergentcare_for_Respiratory_infection"]."',
oasistransfer_In_Emergentcare_for_Other_respiratory_problem  ='".$_POST["oasistransfer_In_Emergentcare_for_Other_respiratory_problem"]."',
oasistransfer_In_Emergentcare_for_Heart_failure  ='".$_POST["oasistransfer_In_Emergentcare_for_Heart_failure"]."',
oasistransfer_In_Emergentcare_for_Cardiac_dysrhythmia  ='".$_POST["oasistransfer_In_Emergentcare_for_Cardiac_dysrhythmia"]."',
oasistransfer_In_Emergentcare_for_Chest_Pain  ='".$_POST["oasistransfer_In_Emergentcare_for_Chest_Pain"]."',
oasistransfer_In_Emergentcare_for_Other_heart_disease  ='".$_POST["oasistransfer_In_Emergentcare_for_Other_heart_disease"]."',
oasistransfer_In_Emergentcare_for_Stroke_or_TIA  ='".$_POST["oasistransfer_In_Emergentcare_for_Stroke_or_TIA"]."',
oasistransfer_In_Emergentcare_for_Hypo_Hyperglycemia  ='".$_POST["oasistransfer_In_Emergentcare_for_Hypo_Hyperglycemia"]."',
oasistransfer_In_Emergentcare_for_GI_bleeding  ='".$_POST["oasistransfer_In_Emergentcare_for_GI_bleeding"]."',
oasistransfer_In_Emergentcare_for_Dehydration_malnutrition  ='".$_POST["oasistransfer_In_Emergentcare_for_Dehydration_malnutrition"]."',
oasistransfer_In_Emergentcare_for_Urinary_tract_infection  ='".$_POST["oasistransfer_In_Emergentcare_for_Urinary_tract_infection"]."',
oasistransfer_In_Emergentcare_for_IV_catheter_Complication  ='".$_POST["oasistransfer_In_Emergentcare_for_IV_catheter_Complication"]."',
oasistransfer_In_Emergentcare_for_Wound_infection  ='".$_POST["oasistransfer_In_Emergentcare_for_Wound_infection"]."',
oasistransfer_In_Emergentcare_for_Uncontrolled_pain  ='".$_POST["oasistransfer_In_Emergentcare_for_Uncontrolled_pain"]."',
oasistransfer_In_Emergentcare_for_Acute_health_problem  ='".$_POST["oasistransfer_In_Emergentcare_for_Acute_health_problem"]."',
oasistransfer_In_Emergentcare_for_Deep_vein_thrombosis  ='".$_POST["oasistransfer_In_Emergentcare_for_Deep_vein_thrombosis"]."',
oasistransfer_In_Emergentcare_for_Other_Reason  ='".$_POST["oasistransfer_In_Emergentcare_for_Other_Reason"]."',
oasistransfer_In_Emergentcare_for_Reason_unknown  ='".$_POST["oasistransfer_In_Emergentcare_for_Reason_unknown"]."',
oasistransfer_Diabetic_foot_care  ='".$_POST["oasistransfer_Diabetic_foot_care"]."',
oasistransfer_Falls_prevention_Intervention  ='".$_POST["oasistransfer_Falls_prevention_Intervention"]."',
oasistransfer_Depression_intervention  ='".$_POST["oasistransfer_Depression_intervention"]."',
oasistransfer_Intervention_to_monitor_pain  ='".$_POST["oasistransfer_Intervention_to_monitor_pain"]."',
oasistransfer_Intervention_to_prevent_pressure_ulcers  ='".$_POST["oasistransfer_Intervention_to_prevent_pressure_ulcers"]."',
oasistransfer_Pressure_ulcer_treatment  ='".$_POST["oasistransfer_Pressure_ulcer_treatment"]."',
oasistransfer_mental_status  ='".implode("#",$_POST["oasistransfer_mental_status"])."',
oasistransfer_mental_status_other  ='".$_POST["oasistransfer_mental_status_other"]."',
oasistransfer_functional_limitations  ='".implode("#",$_POST["oasistransfer_functional_limitations"])."',
oasistransfer_functional_limitations_other  ='".$_POST["oasistransfer_functional_limitations_other"]."',
oasistransfer_prognosis  ='".$_POST["oasis_prognosis"]."',
oasistransfer_safety_measures  ='".implode("#",$_POST["oasistransfer_safety_measures"])."',
oasistransfer_safety_measures_other  ='".$_POST["oasistransfer_safety_measures_other"]."',
oasistransfer_dme_iv_supplies  ='".implode("#",$_POST["oasistransfer_dme_iv_supplies"])."',
oasistransfer_dme_iv_supplies_other  ='".$_POST["oasistransfer_dme_iv_supplies_other"]."',
oasistransfer_dme_foley_supplies  ='".implode("#",$_POST["oasistransfer_dme_foley_supplies"])."',
oasistransfer_dme_foley_supplies_other  ='".$_POST["oasistransfer_dme_foley_supplies_other"]."',

oasistransfer_Reason_For_PPV_Not_Received  ='".$_POST["oasistransfer_Reason_For_PPV_Not_Received"]."',
oasis_speech_and_oral  ='".$_POST["oasis_speech_and_oral"]."',
oasistransfer_Cardiac_Status  ='".$_POST["oasistransfer_Cardiac_Status"]."',
oasistransfer_Heart_Failure_FollowUp_no_Action  ='".$_POST["oasistransfer_Heart_Failure_FollowUp_no_Action"]."',
oasistransfer_Heart_Failure_FollowUp_patient_Contacted  ='".$_POST["oasistransfer_Heart_Failure_FollowUp_patient_Contacted"]."',
oasistransfer_Heart_Failure_FollowUp_Emergency_Treatment  ='".$_POST["oasistransfer_Heart_Failure_FollowUp_Emergency_Treatment"]."',
oasistransfer_Heart_Failure_FollowUp_Implemented_treatment  ='".$_POST["oasistransfer_Heart_Failure_FollowUp_Implemented_treatment"]."',
oasistransfer_Heart_Failure_FollowUp_Patient_Education  ='".$_POST["oasistransfer_Heart_Failure_FollowUp_Patient_Education"]."',
oasistransfer_Heart_Failure_FollowUp_change_in_carePlan_orders  ='".$_POST["oasistransfer_Heart_Failure_FollowUp_change_in_carePlan_orders"]."',
oasis_elimination_status_tract_infection  ='".$_POST["oasis_elimination_status_tract_infection"]."',
oasistransfer_Medication_Intervention  ='".$_POST["oasistransfer_Medication_Intervention"]."',
oasistransfer_Drug_Education_Intervention  ='".$_POST["oasistransfer_Drug_Education_Intervention"]."',
oasistransfer_Inpatient_Facility_patient_admitted  ='".$_POST["oasistransfer_Inpatient_Facility_patient_admitted"]."',
oasistransfer_Hospitalized_for_Improper_medication  ='".$_POST["oasistransfer_Hospitalized_for_Improper_medication"]."',
oasistransfer_Hospitalized_for_Injury_caused_by_fall  ='".$_POST["oasistransfer_Hospitalized_for_Injury_caused_by_fall"]."',
oasistransfer_Hospitalized_for_Respiratory_infection  ='".$_POST["oasistransfer_Hospitalized_for_Respiratory_infection"]."',
oasistransfer_Hospitalized_for_Other_respiratory_problem  ='".$_POST["oasistransfer_Hospitalized_for_Other_respiratory_problem"]."',
oasistransfer_Hospitalized_for_Heart_failure  ='".$_POST["oasistransfer_Hospitalized_for_Heart_failure"]."',
oasistransfer_Hospitalized_for_Cardiac_dysrhythmia  ='".$_POST["oasistransfer_Hospitalized_for_Cardiac_dysrhythmia"]."',
oasistransfer_Hospitalized_for_Chest_Pain  ='".$_POST["oasistransfer_Hospitalized_for_Chest_Pain"]."',
oasistransfer_Hospitalized_for_Other_heart_disease  ='".$_POST["oasistransfer_Hospitalized_for_Other_heart_disease"]."',
oasistransfer_Hospitalized_for_Stroke_or_TIA  ='".$_POST["oasistransfer_Hospitalized_for_Stroke_or_TIA"]."',
oasistransfer_Hospitalized_for_Hypo_Hyperglycemia  ='".$_POST["oasistransfer_Hospitalized_for_Hypo_Hyperglycemia"]."',
oasistransfer_Hospitalized_for_GI_bleeding  ='".$_POST["oasistransfer_Hospitalized_for_GI_bleeding"]."',
oasistransfer_Hospitalized_for_Dehydration_malnutrition  ='".$_POST["oasistransfer_Hospitalized_for_Dehydration_malnutrition"]."',
oasistransfer_Hospitalized_for_Urinary_tract_infection  ='".$_POST["oasistransfer_Hospitalized_for_Urinary_tract_infection"]."',
oasistransfer_Hospitalized_for_IV_catheter_related_infection  ='".$_POST["oasistransfer_Hospitalized_for_IV_catheter_related_infection"]."',
oasistransfer_Hospitalized_for_Wound_infection  ='".$_POST["oasistransfer_Hospitalized_for_Wound_infection"]."',
oasistransfer_Hospitalized_for_Uncontrolled_pain  ='".$_POST["oasistransfer_Hospitalized_for_Uncontrolled_pain"]."',
oasistransfer_Hospitalized_for_Acute_health_problem  ='".$_POST["oasistransfer_Hospitalized_for_Acute_health_problem"]."',
oasistransfer_Hospitalized_for_Deep_vein_thrombosis  ='".$_POST["oasistransfer_Hospitalized_for_Deep_vein_thrombosis"]."',
oasistransfer_Hospitalized_for_scheduled_Treatment  ='".$_POST["oasistransfer_Hospitalized_for_scheduled_Treatment"]."',
oasistransfer_Hospitalized_for_Other_Reason='".$_POST["oasistransfer_Hospitalized_for_Other_Reason"]."',
oasistransfer_Hospitalized_for_Reason_unknown  ='".$_POST["oasistransfer_Hospitalized_for_Reason_unknown"]."',
oasistransfer_Admitted_in_NursingHome_for_Theraphy_Services  ='".$_POST["oasistransfer_Admitted_in_NursingHome_for_Theraphy_Services"]."',
oasistransfer_Admitted_in_NursingHome_for_Respite_care  ='".$_POST["oasistransfer_Admitted_in_NursingHome_for_Respite_care"]."',
oasistransfer_Admitted_in_NursingHome_for_Hospice_care  ='".$_POST["oasistransfer_Admitted_in_NursingHome_for_Hospice_care"]."',
oasistransfer_Admitted_in_NursingHome_for_Permanent_placement  ='".$_POST["oasistransfer_Admitted_in_NursingHome_for_Permanent_placement"]."',
oasistransfer_Admitted_in_NursingHome_as_Unsafe_at_home  ='".$_POST["oasistransfer_Admitted_in_NursingHome_as_Unsafe_at_home"]."',
oasistransfer_Admitted_in_NursingHome_for_Other_Reason  ='".$_POST["oasistransfer_Admitted_in_NursingHome_for_Other_Reason"]."',
oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason  ='".$_POST["oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason"]."',
oasistransfer_Last_Home_Visit_Date  ='".$_POST["oasistransfer_Last_Home_Visit_Date"]."',
oasistransfer_Discharge_Transfer_Death_Date='".$_POST["oasistransfer_Discharge_Transfer_Death_Date"]."',
oasistransfer_Disciplined_Involved_SN  ='".$_POST["oasistransfer_Disciplined_Involved_SN"]."',
oasistransfer_Disciplined_Involved_PT  ='".$_POST["oasistransfer_Disciplined_Involved_PT"]."',
oasistransfer_Disciplined_Involved_OT  ='".$_POST["oasistransfer_Disciplined_Involved_OT"]."',
oasistransfer_Disciplined_Involved_ST  ='".$_POST["oasistransfer_Disciplined_Involved_ST"]."',
oasistransfer_Disciplined_Involved_MSW  ='".$_POST["oasistransfer_Disciplined_Involved_MSW"]."',
oasistransfer_Disciplined_Involved_CHHA  ='".$_POST["oasistransfer_Disciplined_Involved_CHHA"]."',
oasistransfer_Disciplined_Involved_Other  ='".$_POST["oasistransfer_Disciplined_Involved_Other"]."',
oasistransfer_Physician_notified  ='".$_POST["oasistransfer_Physician_notified"]."',
oasistransfer_Reason_For_Admission  ='".$_POST["oasistransfer_Reason_For_Admission"]."',
oasistransfer_EmergentCare_Hospitalization_Information  ='".$_POST["oasistransfer_EmergentCare_Hospitalization_Information"]."',
oasistransfer_Patient_Have_Advance_Directive  ='".$_POST["oasistransfer_Patient_Have_Advance_Directive"]."',
oasistransfer_List_Of_Medications_Attached  ='".$_POST["oasistransfer_List_Of_Medications_Attached"]."',
oasistransfer_Plan_Of_Care_Attached  ='".$_POST["oasistransfer_Plan_Of_Care_Attached"]."',
oasistransfer_Advance_Directive_Attached  ='".$_POST["oasistransfer_Advance_Directive_Attached"]."',
oasistransfer_DNR_Attached  ='".$_POST["oasistransfer_DNR_Attached"]."',
oasistransfer_Copies_Sent_To_Physician  ='".$_POST["oasistransfer_Copies_Sent_To_Physician"]."',
oasistransfer_Copies_Sent_To_Facility  ='".$_POST["oasistransfer_Copies_Sent_To_Facility"]."',
oasistransfer_name ='".$_POST["oasistransfer_name"]."',
oasistransfer_Reviewed_Date ='".$_POST["oasistransfer_Reviewed_Date"]."',
oasistransfer_Entered_Date ='".$_POST["oasistransfer_Entered_Date"]."',
oasistransfer_Transmitted_Date ='".$_POST["oasistransfer_Transmitted_Date"]."'
where id=$id");

}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
