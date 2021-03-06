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
$newid = formSubmit("forms_non_oasis", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Non Oasis Discharge Assessment", $newid, "non_oasis", $pid, $userauthorized);
}

elseif ($_GET["mode"] == "update") {


foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_non_oasis set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),


non_oasis_patient  = '".$_POST["non_oasis_patient"]."',
non_oasis_caregiver  = '".$_POST["non_oasis_caregiver"]."',
non_oasis_visit_date  = '".$_POST["non_oasis_visit_date"]."',
non_oasis_time_in  = '".$_POST["non_oasis_time_in"]."',
non_oasis_time_out  = '".$_POST["non_oasis_time_out"]."',
non_oasis_pain_weight  = '".$_POST["non_oasis_pain_weight"]."',
non_oasis_pain_blood_sugar  = '".$_POST["non_oasis_pain_blood_sugar"]."',
non_oasis_pain_bowel  = '".$_POST["non_oasis_pain_bowel"]."',
non_oasis_pain_bowel_other  = '".$_POST["non_oasis_pain_bowel_other"]."',
non_oasis_pain_bowel_sounds  = '".$_POST["non_oasis_pain_bowel_sounds"]."',
non_oasis_pain_bladder  = '".$_POST["non_oasis_pain_bladder"]."',
non_oasis_pain_bladder_other  = '".$_POST["non_oasis_pain_bladder_other"]."',
non_oasis_pain_urinary_output  = '".$_POST["non_oasis_pain_urinary_output"]."',
non_oasis_pain_tolerated_procedure  = '".$_POST["non_oasis_pain_tolerated_procedure"]."',
non_oasis_pain_tolerated_procedure_ot  = '".$_POST["non_oasis_pain_tolerated_procedure_ot"]."',
non_oasis_pain_tolerated_procedure_other  = '".$_POST["non_oasis_pain_tolerated_procedure_other"]."',
non_oasis_pain_scale  = '".$_POST["non_oasis_pain_scale"]."',
non_oasis_pain_location_cause  = '".$_POST["non_oasis_pain_location_cause"]."',
non_oasis_pain_description  = '".$_POST["non_oasis_pain_description"]."',
non_oasis_pain_frequency  = '".$_POST["non_oasis_pain_frequency"]."',
non_oasis_pain_aggravating_factors  = '".$_POST["non_oasis_pain_aggravating_factors"]."',
non_oasis_pain_aggravating_factors_other  = '".$_POST["non_oasis_pain_aggravating_factors_other"]."',
non_oasis_pain_relieving_factors  = '".$_POST["non_oasis_pain_relieving_factors"]."',
non_oasis_pain_relieving_factors_other  = '".$_POST["non_oasis_pain_relieving_factors_other"]."',
non_oasis_pain_activities_limited  = '".$_POST["non_oasis_pain_activities_limited"]."',
non_oasis_nutrition_status_prob  = '".$_POST["non_oasis_nutrition_status_prob"]."',
non_oasis_nutrition_status  = '".$_POST["non_oasis_nutrition_status"]."',
non_oasis_nutrition_status_other  = '".$_POST["non_oasis_nutrition_status_other"]."',
non_oasis_nutrition_requirements  = '".$_POST["non_oasis_nutrition_requirements"]."',
non_oasis_nutrition_appetite  = '".$_POST["non_oasis_nutrition_appetite"]."',
non_oasis_nutrition_eat_patt  = '".$_POST["non_oasis_nutrition_eat_patt"]."',
non_oasis_nutrition_eat_patt1  = '".$_POST["non_oasis_nutrition_eat_patt1"]."',
non_oasis_nutrition_eat_patt_freq  = '".$_POST["non_oasis_nutrition_eat_patt_freq"]."',
non_oasis_nutrition_eat_patt_amt  = '".$_POST["non_oasis_nutrition_eat_patt_amt"]."',
non_oasis_nutrition_patt_gain  = '".$_POST["non_oasis_nutrition_patt_gain"]."',
non_oasis_nutrition_eat_patt1_gain_time  = '".$_POST["non_oasis_nutrition_eat_patt1_gain_time"]."',
non_oasis_nutrition_patt1_other  = '".$_POST["non_oasis_nutrition_patt1_other"]."',
non_oasis_nutrition_req  = '".$_POST["non_oasis_nutrition_req"]."',
non_oasis_nutrition_req_other  = '".$_POST["non_oasis_nutrition_req_other"]."',
non_oasis_nutrition_risks  = '".$_POST["non_oasis_nutrition_risks"]."',
non_oasis_nutrition_risks_MD  = '".$_POST["non_oasis_nutrition_risks_MD"]."',
nutrition_total  = '".$_POST["nutrition_total"]."',
non_oasis_nutrition_describe  = '".$_POST["non_oasis_nutrition_describe"]."',
non_oasis_vital_lying_right  = '".$_POST["non_oasis_vital_lying_right"]."',
non_oasis_vital_lying_left  = '".$_POST["non_oasis_vital_lying_left"]."',
non_oasis_vital_sitting_right  = '".$_POST["non_oasis_vital_sitting_right"]."',
non_oasis_vital_sitting_left  = '".$_POST["non_oasis_vital_sitting_left"]."',
non_oasis_vital_standing_right  = '".$_POST["non_oasis_vital_standing_right"]."',
non_oasis_vital_standing_left  = '".$_POST["non_oasis_vital_standing_left"]."',
non_oasis_vital_temp  = '".$_POST["non_oasis_vital_temp"]."',
non_oasis_vital_pulse  = '".$_POST["non_oasis_vital_pulse"]."',
non_oasis_vital_resp_rate  = '".$_POST["non_oasis_vital_resp_rate"]."',
non_oasis_cardio  = '".$_POST["non_oasis_cardio"]."',
non_oasis_cardio_breath  = '".$_POST["non_oasis_cardio_breath"]."',
non_oasis_cardio_breath1  = '".$_POST["non_oasis_cardio_breath1"]."',
non_oasis_cardio_breath_anterior  = '".$_POST["non_oasis_cardio_breath_anterior"]."',
non_oasis_cardio_breath_posterior   = '".$_POST["non_oasis_cardio_breath_posterior"]."',
non_oasis_cardio_o2_sat  = '".$_POST["non_oasis_cardio_o2_sat"]."',
non_oasis_cardio_acc_muscles  = '".$_POST["non_oasis_cardio_acc_muscles"]."',
non_oasis_cardio_o2  = '".$_POST["non_oasis_cardio_o2"]."',
non_oasis_cardio_lpm_per  = '".$_POST["non_oasis_cardio_lpm_per"]."',
non_oasis_cardio_trach  = '".$_POST["non_oasis_cardio_trach"]."',
non_oasis_cardio_manages  = '".$_POST["non_oasis_cardio_manages"]."',
non_oasis_cardio_breath_cough  = '".$_POST["non_oasis_cardio_breath_cough"]."',
non_oasis_cardio_breath_productive  = '".$_POST["non_oasis_cardio_breath_productive"]."',
non_oasis_cardio_breath_color  = '".$_POST["non_oasis_cardio_breath_color"]."',
non_oasis_cardio_breath_amt  = '".$_POST["non_oasis_cardio_breath_amt"]."',
non_oasis_cardio_breath_dyspnea  = '".$_POST["non_oasis_cardio_breath_dyspnea"]."',
non_oasis_cardio_breath_dyspnea_other  = '".$_POST["non_oasis_cardio_breath_dyspnea_other"]."',
non_oasis_cardio_heart_sounds_type  = '".$_POST["non_oasis_cardio_heart_sounds_type"]."',
non_oasis_cardio_heart_sounds  = '".$_POST["non_oasis_cardio_heart_sounds"]."',
non_oasis_cardio_heart_sounds_pacemaker  = '".$_POST["non_oasis_cardio_heart_sounds_pacemaker"]."',
non_oasis_cardio_heart_sounds_pacemaker_date  = '".$_POST["non_oasis_cardio_heart_sounds_pacemaker_date"]."',
non_oasis_cardio_heart_sounds_pacemaker_type  = '".$_POST["non_oasis_cardio_heart_sounds_pacemaker_type"]."',
non_oasis_cardio_heart_sounds_chest_pain  = '".$_POST["non_oasis_cardio_heart_sounds_chest_pain"]."',
non_oasis_cardio_heart_sounds_associated_with  = '".$_POST["non_oasis_cardio_heart_sounds_associated_with"]."',
non_oasis_cardio_heart_sounds_frequency  = '".$_POST["non_oasis_cardio_heart_sounds_frequency"]."',
non_oasis_cardio_heart_sounds_edema  = '".$_POST["non_oasis_cardio_heart_sounds_edema"]."',
non_oasis_cardio_heart_sounds_edema_dependent  = '".$_POST["non_oasis_cardio_heart_sounds_edema_dependent"]."',
non_oasis_cardio_heart_sounds_site  = '".$_POST["non_oasis_cardio_heart_sounds_site"]."',
non_oasis_cardio_heart_sounds_capillary  = '".$_POST["non_oasis_cardio_heart_sounds_capillary"]."',
non_oasis_cardio_heart_sounds_other  = '".$_POST["non_oasis_cardio_heart_sounds_other"]."',
non_oasis_cardio_heart_sounds_notify  = '".$_POST["non_oasis_cardio_heart_sounds_notify"]."',
non_oasis_braden_scale_sensory  = '".$_POST["non_oasis_braden_scale_sensory"]."',
non_oasis_braden_scale_moisture  = '".$_POST["non_oasis_braden_scale_moisture"]."',
non_oasis_braden_scale_activity  = '".$_POST["non_oasis_braden_scale_activity"]."',
non_oasis_braden_scale_mobility  = '".$_POST["non_oasis_braden_scale_mobility"]."',
non_oasis_braden_scale_nutrition  = '".$_POST["non_oasis_braden_scale_nutrition"]."',
non_oasis_braden_scale_friction  = '".$_POST["non_oasis_braden_scale_friction"]."',
non_oasis_braden_scale_total  = '".$_POST["non_oasis_braden_scale_total"]."',
non_oasis_wound_lesion_location  = '".$_POST["non_oasis_wound_lesion_location"]."',
non_oasis_wound_lesion_type  = '".$_POST["non_oasis_wound_lesion_type"]."',
non_oasis_wound_lesion_status  = '".$_POST["non_oasis_wound_lesion_status"]."',
non_oasis_wound_lesion_size_length  = '".$_POST["non_oasis_wound_lesion_size_length"]."',
non_oasis_wound_lesion_size_width  = '".$_POST["non_oasis_wound_lesion_size_width"]."',
non_oasis_wound_lesion_size_depth  = '".$_POST["non_oasis_wound_lesion_size_depth"]."',
non_oasis_wound_lesion_stage  = '".$_POST["non_oasis_wound_lesion_stage"]."',
non_oasis_wound_lesion_tunneling  = '".$_POST["non_oasis_wound_lesion_tunneling"]."',
non_oasis_wound_lesion_odor  = '".$_POST["non_oasis_wound_lesion_odor"]."',
non_oasis_wound_lesion_skin  = '".$_POST["non_oasis_wound_lesion_skin"]."',
non_oasis_wound_lesion_edema  = '".$_POST["non_oasis_wound_lesion_edema"]."',
non_oasis_wound_lesion_stoma  = '".$_POST["non_oasis_wound_lesion_stoma"]."',
non_oasis_wound_lesion_appearance  = '".$_POST["non_oasis_wound_lesion_appearance"]."',
non_oasis_wound_lesion_drainage  = '".$_POST["non_oasis_wound_lesion_drainage"]."',
non_oasis_wound_lesion_color  = '".$_POST["non_oasis_wound_lesion_color"]."',
non_oasis_wound_lesion_consistency  = '".$_POST["non_oasis_wound_lesion_consistency"]."',
non_oasis_integumentary_status_problem  = '".$_POST["non_oasis_integumentary_status_problem"]."',
non_oasis_wound_care_done  = '".$_POST["non_oasis_wound_care_done"]."',
non_oasis_wound_location  = '".$_POST["non_oasis_wound_location"]."',
non_oasis_wound  = '".$_POST["non_oasis_wound"]."',
non_oasis_wound_soiled_dressing_by  = '".$_POST["non_oasis_wound_soiled_dressing_by"]."',
non_oasis_wound_soiled_technique  = '".$_POST["non_oasis_wound_soiled_technique"]."',
non_oasis_wound_cleaned  = '".$_POST["non_oasis_wound_cleaned"]."',
non_oasis_wound_irrigated  = '".$_POST["non_oasis_wound_irrigated"]."',
non_oasis_wound_packed  = '".$_POST["non_oasis_wound_packed"]."',
non_oasis_wound_dressing_apply  = '".$_POST["non_oasis_wound_dressing_apply"]."',
non_oasis_wound_incision  = '".$_POST["non_oasis_wound_incision"]."',
non_oasis_wound_comment  = '".$_POST["non_oasis_wound_comment"]."',
non_oasis_satisfactory_return_demo  = '".$_POST["non_oasis_satisfactory_return_demo"]."',
non_oasis_wound_education  = '".$_POST["non_oasis_wound_education"]."',
non_oasis_wound_education_comment  = '".$_POST["non_oasis_wound_education_comment"]."',
non_oasis_infusion  = '".$_POST["non_oasis_infusion"]."',
non_oasis_infusion_peripheral  = '".$_POST["non_oasis_infusion_peripheral"]."',
non_oasis_infusion_PICC  = '".$_POST["non_oasis_infusion_PICC"]."',
non_oasis_infusion_central  = '".$_POST["non_oasis_infusion_central"]."',
non_oasis_infusion_central_date  = '".$_POST["non_oasis_infusion_central_date"]."',
non_oasis_infusion_xray  = '".$_POST["non_oasis_infusion_xray"]."',
non_oasis_infusion_circum  = '".$_POST["non_oasis_infusion_circum"]."',
non_oasis_infusion_length  = '".$_POST["non_oasis_infusion_length"]."',
non_oasis_infusion_hickman  = '".$_POST["non_oasis_infusion_hickman"]."',
non_oasis_infusion_hickman_date  = '".$_POST["non_oasis_infusion_hickman_date"]."',
non_oasis_infusion_epidural_date  = '".$_POST["non_oasis_infusion_epidural_date"]."',
non_oasis_infusion_implanted_date  = '".$_POST["non_oasis_infusion_implanted_date"]."',
non_oasis_infusion_intrathecal_date  = '".$_POST["non_oasis_infusion_intrathecal_date"]."',
non_oasis_infusion_med1_admin  = '".$_POST["non_oasis_infusion_med1_admin"]."',
non_oasis_infusion_med1_name  = '".$_POST["non_oasis_infusion_med1_name"]."',
non_oasis_infusion_med1_dose  = '".$_POST["non_oasis_infusion_med1_dose"]."',
non_oasis_infusion_med1_dilution  = '".$_POST["non_oasis_infusion_med1_dilution"]."',
non_oasis_infusion_med1_route  = '".$_POST["non_oasis_infusion_med1_route"]."',
non_oasis_infusion_med1_frequency  = '".$_POST["non_oasis_infusion_med1_frequency"]."',
non_oasis_infusion_med1_duration  = '".$_POST["non_oasis_infusion_med1_duration"]."',
non_oasis_infusion_med2_admin  = '".$_POST["non_oasis_infusion_med2_admin"]."',
non_oasis_infusion_med2_name  = '".$_POST["non_oasis_infusion_med2_name"]."',
non_oasis_infusion_med2_dose  = '".$_POST["non_oasis_infusion_med2_dose"]."',
non_oasis_infusion_med2_dilution  = '".$_POST["non_oasis_infusion_med2_dilution"]."',
non_oasis_infusion_med2_route  = '".$_POST["non_oasis_infusion_med2_route"]."',
non_oasis_infusion_med2_frequency  = '".$_POST["non_oasis_infusion_med2_frequency"]."',
non_oasis_infusion_med2_duration  = '".$_POST["non_oasis_infusion_med2_duration"]."',
non_oasis_infusion_med3_admin  = '".$_POST["non_oasis_infusion_med3_admin"]."',
non_oasis_infusion_med3_name  = '".$_POST["non_oasis_infusion_med3_name"]."',
non_oasis_infusion_med3_dose  = '".$_POST["non_oasis_infusion_med3_dose"]."',
non_oasis_infusion_med3_dilution  = '".$_POST["non_oasis_infusion_med3_dilution"]."',
non_oasis_infusion_med3_route  = '".$_POST["non_oasis_infusion_med3_route"]."',
non_oasis_infusion_med3_frequency  = '".$_POST["non_oasis_infusion_med3_frequency"]."',
non_oasis_infusion_med3_duration  = '".$_POST["non_oasis_infusion_med3_duration"]."',
non_oasis_infusion_pump  = '".$_POST["non_oasis_infusion_pump"]."',
non_oasis_infusion_admin_by  = '".$_POST["non_oasis_infusion_admin_by"]."',
non_oasis_infusion_admin_by_other  = '".$_POST["non_oasis_infusion_admin_by_other"]."',
non_oasis_infusion_purpose  = '".$_POST["non_oasis_infusion_purpose"]."',
non_oasis_infusion_purpose_other  = '".$_POST["non_oasis_infusion_purpose_other"]."',
non_oasis_infusion_care_provided  = '".$_POST["non_oasis_infusion_care_provided"]."',
non_oasis_infusion_dressing  = '".$_POST["non_oasis_infusion_dressing"]."',
non_oasis_infusion_performed_by  = '".$_POST["non_oasis_infusion_performed_by"]."',
non_oasis_infusion_frequency  = '".$_POST["non_oasis_infusion_frequency"]."',
non_oasis_infusion_injection  = '".$_POST["non_oasis_infusion_injection"]."',
non_oasis_infusion_labs_drawn  = '".$_POST["non_oasis_infusion_labs_drawn"]."',
non_oasis_infusion_interventions  = '".$_POST["non_oasis_infusion_interventions"]."',
non_oasis_enteral  = '".$_POST["non_oasis_enteral"]."',
non_oasis_enteral_other  = '".$_POST["non_oasis_enteral_other"]."',
non_oasis_enteral_pump  = '".$_POST["non_oasis_enteral_pump"]."',
non_oasis_enteral_feedings  = '".$_POST["non_oasis_enteral_feedings"]."',
non_oasis_enteral_rate  = '".$_POST["non_oasis_enteral_rate"]."',
non_oasis_enteral_flush  = '".$_POST["non_oasis_enteral_flush"]."',
non_oasis_enteral_performed_by  = '".$_POST["non_oasis_enteral_performed_by"]."',
non_oasis_enteral_performed_by_other  = '".$_POST["non_oasis_enteral_performed_by_other"]."',
non_oasis_enteral_dressing  = '".$_POST["non_oasis_enteral_dressing"]."',
non_oasis_enteral_interventions  = '".$_POST["non_oasis_enteral_interventions"]."',
non_oasis_skilled_care  = '".$_POST["non_oasis_skilled_care"]."',
non_oasis_summary_disciplines  = '".$_POST["non_oasis_summary_disciplines"]."',
non_oasis_summary_disciplines_other  = '".$_POST["non_oasis_summary_disciplines_other"]."',
non_oasis_summary_physician  = '".$_POST["non_oasis_summary_physician"]."',
non_oasis_summary_elsewhere  = '".$_POST["non_oasis_summary_elsewhere"]."',
non_oasis_summary_reason  = '".$_POST["non_oasis_summary_reason"]."',
non_oasis_summary_medication  = '".$_POST["non_oasis_summary_medication"]."',
non_oasis_summary_medication_identified  = '".$_POST["non_oasis_summary_medication_identified"]."',
non_oasis_summary_reason_discharge  = '".$_POST["non_oasis_summary_reason_discharge"]."',
non_oasis_summary_reason_discharge_explain  = '".$_POST["non_oasis_summary_reason_discharge_explain"]."',
non_oasis_summary_reason_discharge_other  = '".$_POST["non_oasis_summary_reason_discharge_other"]."',
non_oasis_summary_discharge_inst  = '".$_POST["non_oasis_summary_discharge_inst"]."',
non_oasis_summary_reviewed  = '".$_POST["non_oasis_summary_reviewed"]."',
non_oasis_summary_reviewed_other  = '".$_POST["non_oasis_summary_reviewed_other"]."',
non_oasis_summary_immunization  = '".$_POST["non_oasis_summary_immunization"]."',
non_oasis_summary_immun_explain  = '".$_POST["non_oasis_summary_immun_explain"]."',
non_oasis_summary_written  = '".$_POST["non_oasis_summary_written"]."',
non_oasis_summary_written_explain  = '".$_POST["non_oasis_summary_written_explain"]."',
non_oasis_summary_demonstrates  = '".$_POST["non_oasis_summary_demonstrates"]."',
detail ='".$_POST["detail"]."',
label ='".$_POST["label"]."',
process ='".$_POST["process"]."',
data ='".$_POST["data"]."',
non_oasis_summary_demonstrates_explain  = '".$_POST["non_oasis_summary_demonstrates_explain"]."' 

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>

