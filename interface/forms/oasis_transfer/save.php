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

foreach($_POST as $key => $value) {
    $_POST[$key] = mysql_real_escape_string($value);
}

$newid = formSubmit("forms_oasis_transfer", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "OASIS-C Transfer", $newid, "oasis_transfer", $pid, $userauthorized);

}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $val) {
	if(is_array($val)) { $val = implode("#",$val); }
	$_POST[$key] = mysql_real_escape_string($val);
}

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
oasistransfer_mental_status  ='".$_POST["oasistransfer_mental_status"]."',
oasistransfer_mental_status_other  ='".$_POST["oasistransfer_mental_status_other"]."',
oasistransfer_functional_limitations  ='".$_POST["oasistransfer_functional_limitations"]."',
oasistransfer_functional_limitations_other  ='".$_POST["oasistransfer_functional_limitations_other"]."',
oasistransfer_prognosis  ='".$_POST["oasistransfer_prognosis"]."',
oasistransfer_safety_measures  ='".$_POST["oasistransfer_safety_measures"]."',
oasistransfer_safety_measures_other  ='".$_POST["oasistransfer_safety_measures_other"]."',
oasistransfer_dme_iv_supplies  ='".$_POST["oasistransfer_dme_iv_supplies"]."',
oasistransfer_dme_iv_supplies_other  ='".$_POST["oasistransfer_dme_iv_supplies_other"]."',
oasistransfer_dme_foley_supplies  ='".$_POST["oasistransfer_dme_foley_supplies"]."',
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
oasistransfer_Discharge_Transfer_Death_Date ='".$_POST["oasistransfer_Discharge_Transfer_Death_Date"]."',
oasistransfer_certification ='".$_POST["oasistransfer_certification"]."',
oasistransfer_date_last_contacted_physician ='".$_POST["oasistransfer_date_last_contacted_physician"]."',
oasistransfer_date_last_seen_by_physician ='".$_POST["oasistransfer_date_last_seen_by_physician"]."',
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
