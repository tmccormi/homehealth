<?php

function diagnosisFormat($inp_code){

if(substr($inp_code, 0 , 1)!='E' && substr($inp_code, 0 , 1)!=' '){
$result_code = ' '.$inp_code;
}

return $result_code;

}

function correctTherapyNeed($inp_num){

$len = strlen($inp_num);

if($len == 0){
$res_num = "000";
}
else if($len == 1){
$res_num = "00".$inp_num;
}
else if($len == 2){
$res_num = "0".$inp_num;
}
else{
$res_num = substr($inp_num,0,3);
}

}

ini_set("display_errors", "0");
$result1 = mysql_query("select * from $table_name where id='$form_id'");
while ($row1 = mysql_fetch_array($result1)) {
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_race_ethnicity = explode("#", $row1['oasis_patient_race_ethnicity']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_race_ethnicity = explode("#", $row1['OASIS_C_race_ethnicity']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_payment_source_homecare = explode("#", $row1['oasis_patient_payment_source_homecare']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_payment_source_homecare = explode("#", $row1['OASIS_C_current_payment_sources']);
  } else if ($table_name == 'forms_oasis_c_nurse') {$oasis_patient_payment_source_homecare = explode("#", $row1['oasis_c_nurse_payment_source_homecare']);
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$oasis_patient_payment_source_homecare = explode("#", $row1['oasis_therapy_payment_source_homecare']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_history_if_code = explode("#", $row1['oasis_patient_history_if_code']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_history_if_code = explode("#", $row1['OASIS_C_PHAD_ICDMcode6']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_history_mrd_code = explode("#", $row1['oasis_patient_history_mrd_code']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_history_mrd_code = explode("#", $row1['OASIS_C_PHAD_Procedure_Code']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_history_regimen_change = explode("#", $row1['oasis_patient_history_regimen_change']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_history_regimen_change = explode("#", $row1['OASIS_C_treatment_regimen_change']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_history_therapies = explode("#", $row1['oasis_patient_history_therapies']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_history_therapies = explode("#", $row1['OASIS_C_therapies_patient_received']);
  } else if ($table_name == 'forms_oasis_c_nurse') {$oasis_patient_history_therapies = explode("#", $row1['oasis_c_nurse_therapies_home']);
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$oasis_patient_history_therapies = explode("#", $row1['oasis_therapy_therapies_home']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_history_risk_factors = explode("#", $row1['oasis_patient_history_risk_factors']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_history_risk_factors = explode("#", $row1['OASIS_C_risk_factors_effects_health_status']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_therapy_respiratory_treatment = explode("#", $row1['oasis_therapy_respiratory_treatment']);
  } else if ($table_name == 'forms_OASIS') {$oasis_therapy_respiratory_treatment = explode("#", $row1['respiratory_status_treatments']);
  } else if ($table_name == 'forms_oasis_discharge') {$oasis_therapy_respiratory_treatment = explode("#", $row1['oasis_therapy_respiratory_treatment']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$oasis_neuro_cognitive_symptoms = explode("#", $row1['oasis_neuro_cognitive_symptoms']);
  } else if ($table_name == 'forms_OASIS') {$oasis_neuro_cognitive_symptoms = explode("#", $row1['neuro_status_cognitive_symptoms']);
  } else if ($table_name == 'forms_oasis_discharge') {$oasis_neuro_cognitive_symptoms = explode("#", $row1['oasis_neuro_cognitive_symptoms']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_history_ip_code = explode("#", $row1['oasis_patient_history_ip_code']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_history_ip_code = explode("#", $row1['OASIS_C_diagnosis_ICDMcode6']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_history_risk_hospitalization = explode("#", $row1['oasis_patient_history_risk_hospitalization']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_history_risk_hospitalization = explode("#", $row1['OASIS_C_risk_for_hospitalization']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$oasis_patient_history_impatient_facility = explode("#", $row1['oasis_patient_history_impatient_facility']);
  } else if ($table_name == 'forms_OASIS') {$oasis_patient_history_impatient_facility = explode("#", $row1['OASIS_C_PHAD_Inpatient_Facilities']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$oasis_therapy_pressure_ulcer_a = explode("#", $row1['oasis_therapy_pressure_ulcer_a']);
  } else if ($table_name == 'forms_OASIS') {$oasis_therapy_pressure_ulcer_a = explode("#", $row1['integumentary_status_current_no_a']);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$oasis_therapy_pressure_ulcer_a = explode("#", $row1['oasis_therapy_pressure_ulcer_a']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$oasis_therapy_pressure_ulcer_b = explode("#", $row1['oasis_therapy_pressure_ulcer_b']);
  } else if ($table_name == 'forms_OASIS') {$oasis_therapy_pressure_ulcer_b = explode("#", $row1['integumentary_status_current_no_b']);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$oasis_therapy_pressure_ulcer_b = explode("#", $row1['oasis_therapy_pressure_ulcer_b']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$oasis_therapy_pressure_ulcer_c = explode("#", $row1['oasis_therapy_pressure_ulcer_c']);
  } else if ($table_name == 'forms_OASIS') {$oasis_therapy_pressure_ulcer_c = explode("#", $row1['integumentary_status_current_no_c']);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$oasis_therapy_pressure_ulcer_c = explode("#", $row1['oasis_therapy_pressure_ulcer_c']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$oasis_therapy_pressure_ulcer_d1 = explode("#", $row1['oasis_therapy_pressure_ulcer_d1']);
  } else if ($table_name == 'forms_OASIS') {$oasis_therapy_pressure_ulcer_d1 = explode("#", $row1['integumentary_status_current_no_d1']);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$oasis_therapy_pressure_ulcer_d1 = explode("#", $row1['oasis_therapy_pressure_ulcer_d1']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$oasis_therapy_pressure_ulcer_d2 = explode("#", $row1['oasis_therapy_pressure_ulcer_d2']);
  } else if ($table_name == 'forms_OASIS') {$oasis_therapy_pressure_ulcer_d2 = explode("#", $row1['integumentary_status_current_no_d2']);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$oasis_therapy_pressure_ulcer_d2 = explode("#", $row1['oasis_therapy_pressure_ulcer_d2']);
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$oasis_therapy_pressure_ulcer_d3 = explode("#", $row1['oasis_therapy_pressure_ulcer_d3']);
  } else if ($table_name == 'forms_OASIS') {$oasis_therapy_pressure_ulcer_d3 = explode("#", $row1['integumentary_status_current_no_d3']);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$oasis_therapy_pressure_ulcer_d3 = explode("#", $row1['oasis_therapy_pressure_ulcer_d3']);
  }
  if ($table_name == 'forms_OASIS') {$adimitted_to_nursing_home = explode("#", $row1['patient_Admitted_to_a_Nursing_Home']);
  }
  if ($table_name == 'forms_OASIS') {$OASIS_C_PHAD_Inpatient_Procedure_other = explode("#", $row1['OASIS_C_PHAD_Inpatient_Procedure_other']);
  }
  if ($table_name == 'forms_OASIS') {$OASIS_C_reason_influenza_caccine_not_received = explode("#", $row1['OASIS_C_reason_influenza_caccine_not_received']);
  }
  if ($table_name == 'forms_OASIS') {$OASIS_C_reason_not_received_pneumocaccal_vaccine = explode("#", $row1['OASIS_C_reason_not_received_pneumocaccal_vaccine']);
  }
  if ($table_name == 'forms_OASIS') {$cardiac_status_follow_up = explode("#", $row1['cardiac_status_follow_up']);
  } else if ($table_name == 'forms_oasis_discharge') {$cardiac_status_follow_up = explode("#", $row1['oasis_cardiac_status_heart_failure']);
  }
  if ($table_name == 'forms_OASIS') {$OASIS_C_Reason_for_Emergent_Care = explode("#", $row1['OASIS_C_Reason_for_Emergent_Care']);
  } else if ($table_name == 'forms_oasis_discharge') {$OASIS_C_Reason_for_Emergent_Care = explode("#", $row1['oasis_emergent_care_reason']);
  }
  if ($table_name == 'forms_OASIS') {$Reason_for_Hospitalization = explode("#", $row1['Reason_for_Hospitalization']);
  }





  $recordID = 'B1';
  $correction_number_for_record = '00';
  $OASIS_data_set_version_code = 'C-072009';
  $layout_submitted_version_code = '02.00';
  $patient_id = $row1['pid'];
  $CMS_certification_number = '123456';

  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$branch_state = substr($row1['oasis_patient_branch_state'], 0, 2);
  } else if ($table_name == 'forms_oasis_discharge') {$branch_state = substr($row1['oasis_therapy_branch_state'], 0, 2);
  } else if ($table_name == 'forms_oasis_c_nurse') {$branch_state = substr($row1['oasis_c_nurse_branch_state'], 0, 2);
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$branch_state = substr($row1['oasis_therapy_branch_state'], 0, 2);
  } else {$branch_state = " ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$branch_id = substr($row1['oasis_patient_branch_id_no'], 0, 10);
  } else if ($table_name == 'forms_oasis_discharge') {$branch_id = substr($row1['oasis_therapy_branch_id_no'], 0, 10);
  } else if ($table_name == 'forms_oasis_c_nurse') {$branch_id = substr($row1['oasis_c_nurse_branch_id_no'], 0, 10);
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$branch_id = substr($row1['oasis_therapy_branch_id_no'], 0, 10);
  } else {$branch_id = " ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$start_of_care_date = str_replace('-', '', $row1['oasis_patient_soc_date']);
  } else if ($table_name == 'forms_OASIS') {$start_of_care_date = str_replace('-', '', $row1['OASIS_C_start_care_date']);
  } else if ($table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_transfer') {$start_of_care_date = str_replace('-', '', $row1['oasis_therapy_soc_date']);
  } else if ($table_name == 'forms_oasis_c_nurse') {$start_of_care_date = str_replace('-', '', $row1['oasis_c_nurse_soc_date']);
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$start_of_care_date = str_replace('-', '', $row1['oasis_therapy_soc_date']);
  } else {$start_of_care_date = "        ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$resumption_of_care_date = str_replace('-', '', $row1['oasis_patient_resumption_care_date']);
  } else if ($table_name == 'forms_OASIS') {$resumption_of_care_date = str_replace('-', '', $row1['OASIS_C_resumption_care_date']);
  } else {$resumption_of_care_date = "        ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_resumption_care_date_na'] == 'N/A') {$no_resumption_of_care_date = 1;
	  } else {$no_resumption_of_care_date = 0;
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_resumption_care_date_option'] == 'NA - Not Applicable') {$no_resumption_of_care_date = 1;
	  } else {$no_resumption_of_care_date = 0;
	  }
  } else {$no_resumption_of_care_date = " ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_first_name = substr($row1['oasis_patient_patient_name_first'], 0, 12);
  } else if ($table_name == 'forms_OASIS') {$patient_first_name = substr($row1['OASIS_C_first_name'], 0, 12);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$patient_first_name = substr($row1['oasis_therapy_patient_name_first'], 0, 12);
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_first_name = substr($row1['oasis_c_nurse_patient_name_first'], 0, 12);
  } else {$patient_first_name = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_middle_name = substr($row1['oasis_patient_patient_name_mi'], 0, 1);
  } else if ($table_name == 'forms_OASIS') {$patient_middle_name = substr($row1['OASIS_C_mi'], 0, 1);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$patient_middle_name = substr($row1['oasis_therapy_patient_name_mi'], 0, 1);
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_middle_name = substr($row1['oasis_c_nurse_patient_name_mi'], 0, 1);
  } else {$patient_middle_name = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_last_name = substr($row1['oasis_patient_patient_name_last'], 0, 18);
  } else if ($table_name == 'forms_OASIS') {$patient_last_name = substr($row1['OASIS_C_last_name'], 0, 18);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$patient_last_name = substr($row1['oasis_therapy_patient_name_last'], 0, 18);
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_last_name = substr($row1['oasis_c_nurse_patient_name_last'], 0, 18);
  } else {$patient_last_name = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_suffix = substr($row1['oasis_patient_patient_name_suffix'], 0, 3);
  } else if ($table_name == 'forms_OASIS') {$patient_suffix = substr($row1['OASIS_C_suffix'], 0, 3);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$patient_suffix = substr($row1['oasis_therapy_patient_name_suffix'], 0, 3);
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_suffix = substr($row1['oasis_c_nurse_patient_name_suffix'], 0, 3);
  } else {$patient_suffix = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_state_of_residence = $row1['oasis_patient_patient_state'];
  } else if ($table_name == 'forms_OASIS') {$patient_state_of_residence = $row1['OASIS_C_patient_residence'];
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$patient_state_of_residence = $row1['oasis_therapy_patient_state'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_state_of_residence = $row1['oasis_c_nurse_patient_state'];
  } else {$patient_state_of_residence = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_zip_code = substr($row1['oasis_patient_patient_zip'], 0, 9);
  } else if ($table_name == 'forms_OASIS') {$patient_zip_code = substr($row1['OASIS_C_patient_zip_code'], 0, 9);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$patient_zip_code = substr($row1['oasis_therapy_patient_zip'], 0, 9);
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_zip_code = substr($row1['oasis_c_nurse_patient_zip'], 0, 9);
  } else {$patient_zip_code = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$medicare_number = substr($row1['oasis_patient_medicare_no'], 0, 12);
  } else if ($table_name == 'forms_OASIS') {$medicare_number = substr($row1['OASIS_C_patient_medicare_number'], 0, 12);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$medicare_number = substr($row1['oasis_therapy_medicare_no'], 0, 12);
  } else if ($table_name == 'forms_oasis_c_nurse') {$medicare_number = substr($row1['oasis_c_nurse_medicare_no'], 0, 12);
  } else {$medicare_number = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_medicare_no_na'] == 'N/A') {$no_medicare_number = 1;
	  } else {$no_medicare_number = 0;
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_patient_medicare_number_option'] == 'NA - No Medicare') {$no_medicare_number = 1;
	  } else {$no_medicare_number = 0;
	  }
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_medicare_no_na'] == 'N/A') {$no_medicare_number = 1;
	  } else {$no_medicare_number = 0;
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_medicare_no_na'] == 'N/A') {$no_medicare_number = 1;
	  } else {$no_medicare_number = 0;
	  }
  } else {$no_medicare_number = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$ssn = substr($row1['oasis_patient_ssn'], 0, 9);
  } else if ($table_name == 'forms_OASIS') {$ssn = substr($row1['OASIS_C_patient_security_number'], 0, 9);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$ssn = substr($row1['oasis_therapy_ssn'], 0, 9);
  } else if ($table_name == 'forms_oasis_c_nurse') {$ssn = substr($row1['oasis_c_nurse_ssn'], 0, 9);
  } else {$ssn = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_ssn_na'] == 'UK') {$no_ssn = 1;
	  } else {$no_ssn = 0;
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_patient_security_number_option'] == 'UK - Unknown or Not Available') {$no_ssn = 1;
	  } else {$no_ssn = 0;
	  }
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_ssn_na'] == 'UK') {$no_ssn = 1;
	  } else {$no_ssn = 0;
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_ssn_na'] == 'UK') {$no_ssn = 1;
	  } else {$no_ssn = 0;
	  }
  } else {$no_ssn = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$medicaid_number = $row1['oasis_patient_medicaid_no'];
  } else if ($table_name == 'forms_OASIS') {$medicaid_number = $row1['OASIS_C_patient_medicaid_number'];
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$medicaid_number = $row1['oasis_therapy_medicaid_no'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$medicaid_number = $row1['oasis_c_nurse_medicaid_no'];
  } else {$medicaid_number = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_medicaid_no_na'] == 'N/A') {$no_medicaid_number = 1;
	  } else {$no_medicaid_number = 0;
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_patient_medicaid_number_option'] == 'NA - No Medicaid') {$no_medicaid_number = 1;
	  } else {$no_medicaid_number = 0;
	  }
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_medicaid_no_na'] == 'N/A') {$no_medicaid_number = 1;
	  } else {$no_medicaid_number = 0;
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_medicaid_no_na'] == 'N/A') {$no_medicaid_number = 1;
	  } else {$no_medicaid_number = 0;
	  }
  } else {$no_medicaid_number = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$dob = str_replace('-', '', $row1['oasis_patient_birth_date']);
  } else if ($table_name == 'forms_OASIS') {$dob = str_replace('-', '', $row1['OASIS_C_birth_date']);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$dob = str_replace('-', '', $row1['oasis_therapy_birth_date']);
  } else if ($table_name == 'forms_oasis_c_nurse') {$dob = str_replace('-', '', $row1['oasis_c_nurse_birth_date']);
  } else {$dob = "        ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_patient_gender'] == 'male' || $row1['oasis_patient_patient_gender'] == 'Male') {$gender = '1';
	  } else {$gender = '2';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_patient_gender'] == 'Male' || $row1['OASIS_C_patient_gender'] == 'male') {$gender = '1';
	  } else {$gender = '2';
	  }
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_patient_gender'] == 'Male' || $row1['oasis_therapy_patient_gender'] == 'male') {$gender = '1';
	  } else {$gender = '2';
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_patient_gender'] == 'male' || $row1['oasis_c_nurse_patient_gender'] == 'Male') {$gender = '1';
	  } else {$gender = '2';
	  }
  } else {$gender = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$primary_referring_physician_NPI = substr($row1['oasis_patient_referring_physician_id'], 0, 10);
  } else if ($table_name == 'forms_oasis_c_nurse') {$primary_referring_physician_NPI = substr($row1['oasis_c_nurse_referring_physician_id'], 0, 10);
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$primary_referring_physician_NPI = substr($row1['oasis_therapy_referring_physician_id'], 0, 10);
  } else {$primary_referring_physician_NPI = '          ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_referring_physician_id_na'] == 'N/A') {$primary_referring_physician_no_NPI = 1;
	  } else {$primary_referring_physician_no_NPI = 0;
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_referring_physician_id_na'] == 'N/A') {$primary_referring_physician_no_NPI = 1;
	  } else {$primary_referring_physician_no_NPI = 0;
	  }
  } else if ($table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_referring_physician_id_na'] == 'N/A') {$primary_referring_physician_no_NPI = 1;
	  } else {$primary_referring_physician_no_NPI = 0;
	  }
  } else {$primary_referring_physician_no_NPI = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	      if($row1['oasis_patient_discipline_person']!=''){$discipline_of_person_completing_assessment = '0' . $row1['oasis_patient_discipline_person'];}
	      else{
	      $discipline_of_person_completing_assessment=' ';
	      }
  } else if ($table_name == 'forms_OASIS') {
	      if($row1['OASIS_C_CRI_DoPCA']!=''){$discipline_of_person_completing_assessment = '0' . $row1['OASIS_C_CRI_DoPCA'];}
	      else{
	      $discipline_of_person_completing_assessment=' ';
	      }
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {
	      if($row1['oasis_therapy_discipline_person']!=''){$discipline_of_person_completing_assessment = '0' . $row1['oasis_therapy_discipline_person'];}
	      else{
	      $discipline_of_person_completing_assessment=' ';
	      }
  } else if ($table_name == 'forms_oasis_transfer') {
	    if ($row1['oasistransfer_Discipline_of_Person_completing_Assessment'] == 'RN') {$discipline_of_person_completing_assessment = '01';
	    } else if ($row1['oasistransfer_Discipline_of_Person_completing_Assessment'] == 'PT') {$discipline_of_person_completing_assessment = '02';
	    } else if ($row1['oasistransfer_Discipline_of_Person_completing_Assessment'] == 'SLP/ST') {$discipline_of_person_completing_assessment = '03';
	    } else if ($row1['oasistransfer_Discipline_of_Person_completing_Assessment'] == 'OT') {$discipline_of_person_completing_assessment = '04';
	    }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	      if($row1['oasis_c_nurse_discipline_person']!=''){$discipline_of_person_completing_assessment = '0' . $row1['oasis_c_nurse_discipline_person'];}
	      else{
	      $discipline_of_person_completing_assessment=' ';
	      }
  } else {$discipline_of_person_completing_assessment = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$date_assessment_completed = str_replace('-', '', $row1['oasis_patient_date_assessment_completed']);
  } else if ($table_name == 'forms_OASIS') {$date_assessment_completed = str_replace('-', '', $row1['OASIS_C_date_curr']);
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$date_assessment_completed = str_replace('-', '', $row1['oasis_therapy_date_assessment_completed']);
  } else if ($table_name == 'forms_oasis_transfer') {$date_assessment_completed = str_replace('-', '', $row1['oasistransfer_Assessment_Completed_Date']);
  } else if ($table_name == 'forms_oasis_c_nurse') {$date_assessment_completed = str_replace('-', '', $row1['oasis_c_nurse_date_assessment_completed']);
  } else {$date_assessment_completed = "        ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$reason_for_assessment = '0' . $row1['oasis_patient_follow_up'];
  } else if ($table_name == 'forms_OASIS') {$reason_for_assessment = $row1['OASIS_C_CRI_Resumption_Care'];
  } else if ($table_name == 'forms_oasis_discharge'||$table_name == 'forms_oasis_therapy_rectification') {$reason_for_assessment = '0' . $row1['oasis_therapy_follow_up'];
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Transfer_to_an_InPatient_Facility'] == 'Patient_Not_Discharged_from_Agency') {$reason_for_assessment = '06';
	  } else if ($row1['oasistransfer_Transfer_to_an_InPatient_Facility'] == 'Patient_Discharged_from_Agency') {$reason_for_assessment = '07';
	  } else if ($row1['oasistransfer_Transfer_to_an_InPatient_Facility'] == 'Death_at_Home') {$reason_for_assessment = '08';
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {$reason_for_assessment = '0' . $row1['oasis_c_nurse_follow_up'];
  } else {$reason_for_assessment = '01';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_patient_race_ethnicity)) {$race_ethnicity_american = '1';
	  } else {$race_ethnicity_american = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("American Indian or Alaska Native", $oasis_patient_race_ethnicity)) {$race_ethnicity_american = '1';
	  } else {$race_ethnicity_american = '0';
	  }
  } else {$race_ethnicity_american = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("2", $oasis_patient_race_ethnicity)) {$race_ethnicity_asian = '1';
	  } else {$race_ethnicity_asian = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Asian", $oasis_patient_race_ethnicity)) {$race_ethnicity_asian = '1';
	  } else {$race_ethnicity_asian = '0';
	  }
  } else {$race_ethnicity_asian = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_patient_race_ethnicity)) {$race_ethnicity_black = '1';
	  } else {$race_ethnicity_black = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Black or African-American", $oasis_patient_race_ethnicity)) {$race_ethnicity_black = '1';
	  } else {$race_ethnicity_black = '0';
	  }
  } else {$race_ethnicity_black = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_patient_race_ethnicity)) {$race_ethnicity_hispanic = '1';
	  } else {$race_ethnicity_hispanic = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Hispanic or Latino", $oasis_patient_race_ethnicity)) {$race_ethnicity_hispanic = '1';
	  } else {$race_ethnicity_hispanic = '0';
	  }
  } else {$race_ethnicity_hispanic = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("5", $oasis_patient_race_ethnicity)) {$race_ethnicity_hawaiian = '1';
	  } else {$race_ethnicity_hawaiian = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Native Hawaiian or Pacific Islander", $oasis_patient_race_ethnicity)) {$race_ethnicity_hawaiian = '1';
	  } else {$race_ethnicity_hawaiian = '0';
	  }
  } else {$race_ethnicity_hawaiian = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("6", $oasis_patient_race_ethnicity)) {$race_ethnicity_white = '1';
	  } else {$race_ethnicity_white = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("White", $oasis_patient_race_ethnicity)) {$race_ethnicity_white = '1';
	  } else {$race_ethnicity_white = '0';
	  }
  } else {$race_ethnicity_white = ' ';
  }
  $item_filler_2 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("0", $oasis_patient_payment_source_homecare)) {$payment_source_no = '1';
	  } else {$payment_source_no = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("None; no charge for current services", $oasis_patient_payment_source_homecare)) {$payment_source_no = '1';
	  } else {$payment_source_no = '0';
	  }
  } else {$payment_source_no = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_patient_payment_source_homecare)) {$payment_source_medicare_traditional = '1';
	  } else {$payment_source_medicare_traditional = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Medicare (traditional fee-for-service)", $oasis_patient_payment_source_homecare)) {$payment_source_medicare_traditional = '1';
	  } else {$payment_source_medicare_traditional = '0';
	  }
  } else {$payment_source_medicare_traditional = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("2", $oasis_patient_payment_source_homecare)) {$payment_source_medicare = '1';
	  } else {$payment_source_medicare = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Medicare (HMO/managed care/Advantage plan)", $oasis_patient_payment_source_homecare)) {$payment_source_medicare = '1';
	  } else {$payment_source_medicare = '0';
	  }
  } else {$payment_source_medicare = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_patient_payment_source_homecare)) {$payment_source_medicaid_traditional = '1';
	  } else {$payment_source_medicaid_traditional = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Medicaid (traditional fee-for-service)", $oasis_patient_payment_source_homecare)) {$payment_source_medicaid_traditional = '1';
	  } else {$payment_source_medicaid_traditional = '0';
	  }
  } else {$payment_source_medicaid_traditional = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_patient_payment_source_homecare)) {$payment_source_medicaid = '1';
	  } else {$payment_source_medicaid = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Medicaid (HMO/managed care)", $oasis_patient_payment_source_homecare)) {$payment_source_medicaid = '1';
	  } else {$payment_source_medicaid = '0';
	  }
  } else {$payment_source_medicaid = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("5", $oasis_patient_payment_source_homecare)) {$payment_source_worker_compensation = '1';
	  } else {$payment_source_worker_compensation = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Workers compensation", $oasis_patient_payment_source_homecare)) {$payment_source_worker_compensation = '1';
	  } else {$payment_source_worker_compensation = '0';
	  }
  } else {$payment_source_worker_compensation = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("6", $oasis_patient_payment_source_homecare)) {$payment_source_title_programs = '1';
	  } else {$payment_source_title_programs = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Title programs (e.g., Title III, V, or XX)", $oasis_patient_payment_source_homecare)) {$payment_source_title_programs = '1';
	  } else {$payment_source_title_programs = '0';
	  }
  } else {$payment_source_title_programs = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("7", $oasis_patient_payment_source_homecare)) {$payment_source_other_government = '1';
	  } else {$payment_source_other_government = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Other government (e.g., TriCare, VA, etc.)", $oasis_patient_payment_source_homecare)) {$payment_source_other_government = '1';
	  } else {$payment_source_other_government = '0';
	  }
  } else {$payment_source_other_government = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("8", $oasis_patient_payment_source_homecare)) {$payment_source_private_insurance = '1';
	  } else {$payment_source_private_insurance = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Private insurance", $oasis_patient_payment_source_homecare)) {$payment_source_private_insurance = '1';
	  } else {$payment_source_private_insurance = '0';
	  }
  } else {$payment_source_private_insurance = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("9", $oasis_patient_payment_source_homecare)) {$payment_source_private_hmo = '1';
	  } else {$payment_source_private_hmo = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Private HMO/managed care", $oasis_patient_payment_source_homecare)) {$payment_source_private_hmo = '1';
	  } else {$payment_source_private_hmo = '0';
	  }
  } else {$payment_source_private_hmo = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("10", $oasis_patient_payment_source_homecare)) {$payment_source_self = '1';
	  } else {$payment_source_self = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Self-pay", $oasis_patient_payment_source_homecare)) {$payment_source_self = '1';
	  } else {$payment_source_self = '0';
	  }
  } else {$payment_source_self = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("11", $oasis_patient_payment_source_homecare)) {$payment_source_other = '1';
	  } else {$payment_source_other = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Self-pay", $oasis_patient_payment_source_homecare)) {$payment_source_other = '1';
	  } else {$payment_source_other = '0';
	  }
  } else {$payment_source_other = '0';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("UK", $oasis_patient_payment_source_homecare)) {$payment_source_unknown = '1';
	  } else {$payment_source_unknown = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("UK - Unknown", $oasis_patient_payment_source_homecare)) {$payment_source_unknown = '1';
	  } else {$payment_source_unknown = '0';
	  }
  } else {$payment_source_unknown = '0';
  }
  $item_filler_3 = '';
  $item_filler_4 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$recent_discharge_date = str_replace('-', '', $row1['oasis_patient_history_discharge_date']);
  } else if ($table_name == 'forms_OASIS') {$recent_discharge_date = $row1['OASIS_C_PHAD_date_curr'];
  } else {$recent_discharge_date = "        ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_history_discharge_date_na'] == 'UK') {$recent_discharge_date_unknown = '1';
	  } else {$recent_discharge_date_unknown = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_PHAD_Inpatient_Discharge_UK'] == 'UK') {$recent_discharge_date_unknown = '1';
	  } else {$recent_discharge_date_unknown = '0';
	  }
  } else {$recent_discharge_date_unknown = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_stay_icd_code_1 = ' '.$oasis_patient_history_if_code[0];
  } else {$inpatient_stay_icd_code_1 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_stay_icd_code_2 = ' '.$oasis_patient_history_if_code[1];
  } else {$inpatient_stay_icd_code_2 = ' ';
  }
  $item_filler_5 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$regimen_change_icd_code_1 = ' '.$oasis_patient_history_mrd_code[0];
  } else {$regimen_change_icd_code_1 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$regimen_change_icd_code_2 = ' '.$oasis_patient_history_mrd_code[1];
  } else {$regimen_change_icd_code_2 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$regimen_change_icd_code_3 = ' '.$oasis_patient_history_mrd_code[2];
  } else {$regimen_change_icd_code_3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$regimen_change_icd_code_4 = ' '.$oasis_patient_history_mrd_code[3];
  } else {$regimen_change_icd_code_4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_patient_history_regimen_change)) {$prior_condition_urinary_incontinence = '1';
	  } else {$prior_condition_urinary_incontinence = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Urinary incontinence", $oasis_patient_history_regimen_change)) {$prior_condition_urinary_incontinence = '1';
	  } else {$prior_condition_urinary_incontinence = '0';
	  }
  } else {$prior_condition_urinary_incontinence = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("2", $oasis_patient_history_regimen_change)) {$prior_condition_indewelling = '1';
	  } else {$prior_condition_indewelling = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Indwelling/suprapubic catheter", $oasis_patient_history_regimen_change)) {$prior_condition_indewelling = '1';
	  } else {$prior_condition_indewelling = '0';
	  }
  } else {$prior_condition_indewelling = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_patient_history_regimen_change)) {$prior_condition_intractable_pain = '1';
	  } else {$prior_condition_intractable_pain = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Intractable pain", $oasis_patient_history_regimen_change)) {$prior_condition_intractable_pain = '1';
	  } else {$prior_condition_intractable_pain = '0';
	  }
  } else {$prior_condition_intractable_pain = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_patient_history_regimen_change)) {$prior_condition_impaired_decision_making = '1';
	  } else {$prior_condition_impaired_decision_making = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Impaired decision-making", $oasis_patient_history_regimen_change)) {$prior_condition_impaired_decision_making = '1';
	  } else {$prior_condition_impaired_decision_making = '0';
	  }
  } else {$prior_condition_impaired_decision_making = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("5", $oasis_patient_history_regimen_change)) {$prior_condition_disruptive = '1';
	  } else {$prior_condition_disruptive = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Disruptive or socially inappropriate behavior", $oasis_patient_history_regimen_change)) {$prior_condition_disruptive = '1';
	  } else {$prior_condition_disruptive = '0';
	  }
  } else {$prior_condition_disruptive = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("6", $oasis_patient_history_regimen_change)) {$prior_condition_memory_loss = '1';
	  } else {$prior_condition_memory_loss = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Memory loss to the extent that supervision required", $oasis_patient_history_regimen_change)) {$prior_condition_memory_loss = '1';
	  } else {$prior_condition_memory_loss = '0';
	  }
  } else {$prior_condition_memory_loss = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("7", $oasis_patient_history_regimen_change)) {$prior_condition_none = '1';
	  } else {$prior_condition_none = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("None of the above", $oasis_patient_history_regimen_change)) {$prior_condition_none = '1';
	  } else {$prior_condition_none = '0';
	  }
  } else {$prior_condition_none = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("NA", $oasis_patient_history_regimen_change)) {$prior_condition_no_inpatient_discharge = '1';
	  } else {$prior_condition_no_inpatient_discharge = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("NA - No inpatient facility discharge", $oasis_patient_history_regimen_change)) {$prior_condition_no_inpatient_discharge = '1';
	  } else {$prior_condition_no_inpatient_discharge = '0';
	  }
  } else {$prior_condition_no_inpatient_discharge = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("UK", $oasis_patient_history_regimen_change)) {$prior_condition_unknown = '1';
	  } else {$prior_condition_unknown = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("UK - Unknown", $oasis_patient_history_regimen_change)) {$prior_condition_unknown = '1';
	  } else {$prior_condition_unknown = '0';
	  }
  } else {$prior_condition_unknown = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$primary_diagnosis_icd_code = ' '.$row1['oasis_therapy_patient_diagnosis_2a'];
  } else if ($table_name == 'forms_OASIS') {$primary_diagnosis_icd_code = $row1['OASIS_C_primary_diagnosis_v_code'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$primary_diagnosis_icd_code = $row1['oasis_patient_diagnosis_2a'];
  } else {$primary_diagnosis_icd_code = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	      if($row1['oasis_therapy_patient_diagnosis_2a_sub']!=''){$primary_diagnosis_severity_rating = '0' . $row1['oasis_therapy_patient_diagnosis_2a_sub'];}
	      else{
	      $primary_diagnosis_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_OASIS') {
	      if($row1['OASIS_C_primary_diagnosis_v_code_options']!=''){$primary_diagnosis_severity_rating = '0' . $row1['OASIS_C_primary_diagnosis_v_code_options'];}
	      else{
	      $primary_diagnosis_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	      if($row1['oasis_patient_diagnosis_2a_sub']!=''){$primary_diagnosis_severity_rating = '0' . $row1['oasis_patient_diagnosis_2a_sub'];}
	      else{
	      $primary_diagnosis_severity_rating=' ';
	      }
  } else {$primary_diagnosis_severity_rating = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$other_diagnosis_1_icd_code = ' '.$row1['oasis_therapy_patient_diagnosis_2b'];
  } else if ($table_name == 'forms_OASIS') {$other_diagnosis_1_icd_code = $row1['OASIS_C_primary_diagnosis_v_code_e_code_b'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$other_diagnosis_1_icd_code = $row1['oasis_patient_diagnosis_2b'];
  } else {$other_diagnosis_1_icd_code = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	      if($row1['oasis_therapy_patient_diagnosis_2b_sub']!=''){$other_diagnosis_1_severity_rating = '0' . $row1['oasis_therapy_patient_diagnosis_2b_sub'];}
	      else{
	      $other_diagnosis_1_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_OASIS') {
	      if($row1['OASIS_C_primary_diagnosis_v_code_e_code_options_b']!=''){$other_diagnosis_1_severity_rating = '0' . $row1['OASIS_C_primary_diagnosis_v_code_e_code_options_b'];}
	      else{
	      $other_diagnosis_1_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	      if($row1['oasis_patient_diagnosis_2b_sub']!=''){$other_diagnosis_1_severity_rating = '0' . $row1['oasis_patient_diagnosis_2b_sub'];}
	      else{
	      $other_diagnosis_1_severity_rating=' ';
	      }
  } else {$other_diagnosis_1_severity_rating = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$other_diagnosis_2_icd_code = ' '.$row1['oasis_therapy_patient_diagnosis_2c'];
  } else if ($table_name == 'forms_OASIS') {$other_diagnosis_2_icd_code = $row1['OASIS_C_primary_diagnosis_v_code_e_code_c'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$other_diagnosis_2_icd_code = $row1['oasis_patient_diagnosis_2c'];
  } else {$other_diagnosis_2_icd_code = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	      if($row1['oasis_therapy_patient_diagnosis_2c_sub']!=''){$other_diagnosis_2_severity_rating = '0' . $row1['oasis_therapy_patient_diagnosis_2c_sub'];}
	      else{
	      $other_diagnosis_2_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_OASIS') {
	      if($row1['OASIS_C_primary_diagnosis_v_code_e_code_options_c']!=''){$other_diagnosis_2_severity_rating = '0' . $row1['OASIS_C_primary_diagnosis_v_code_e_code_options_c'];}
	      else{
	      $other_diagnosis_2_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	      if($row1['oasis_patient_diagnosis_2c_sub']!=''){$other_diagnosis_2_severity_rating = '0' . $row1['oasis_patient_diagnosis_2c_sub'];}
	      else{
	      $other_diagnosis_2_severity_rating=' ';
	      }
  } else {$other_diagnosis_2_severity_rating = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$other_diagnosis_3_icd_code = ' '.$row1['oasis_therapy_patient_diagnosis_2d'];
  } else if ($table_name == 'forms_OASIS') {$other_diagnosis_3_icd_code = $row1['OASIS_C_primary_diagnosis_v_code_e_code_d'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$other_diagnosis_3_icd_code = $row1['oasis_patient_diagnosis_2d'];
  } else {$other_diagnosis_3_icd_code = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	      if($row1['oasis_therapy_patient_diagnosis_2d_sub']!=''){$other_diagnosis_3_severity_rating = '0' . $row1['oasis_therapy_patient_diagnosis_2d_sub'];}
	      else{
	      $other_diagnosis_3_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_OASIS') {
	      if($row1['OASIS_C_primary_diagnosis_v_code_e_code_options_d']!=''){$other_diagnosis_3_severity_rating = '0' . $row1['OASIS_C_primary_diagnosis_v_code_e_code_options_d'];}
	      else{
	      $other_diagnosis_3_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	      if($row1['oasis_patient_diagnosis_2d_sub']!=''){$other_diagnosis_3_severity_rating = '0' . $row1['oasis_patient_diagnosis_2d_sub'];}
	      else{
	      $other_diagnosis_3_severity_rating=' ';
	      }
  } else {$other_diagnosis_3_severity_rating = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$other_diagnosis_4_icd_code = ' '.$row1['oasis_therapy_patient_diagnosis_2e'];
  } else if ($table_name == 'forms_OASIS') {$other_diagnosis_4_icd_code = $row1['OASIS_C_primary_diagnosis_v_code_e_code_e'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$other_diagnosis_4_icd_code = $row1['oasis_patient_diagnosis_2e'];
  } else {$other_diagnosis_4_icd_code = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	      if($row1['oasis_therapy_patient_diagnosis_2e_sub']!=''){$other_diagnosis_4_severity_rating = '0' . $row1['oasis_therapy_patient_diagnosis_2e_sub'];}
	      else{
	      $other_diagnosis_4_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_OASIS') {
	      if($row1['OASIS_C_primary_diagnosis_v_code_e_code_options_e']!=''){$other_diagnosis_4_severity_rating = '0' . $row1['OASIS_C_primary_diagnosis_v_code_e_code_options_e'];}
	      else{
	      $other_diagnosis_4_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	      if($row1['oasis_patient_diagnosis_2e_sub']!=''){$other_diagnosis_4_severity_rating = '0' . $row1['oasis_patient_diagnosis_2e_sub'];}
	      else{
	      $other_diagnosis_4_severity_rating=' ';
	      }
  } else {$other_diagnosis_4_severity_rating = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$other_diagnosis_5_icd_code = ' '.$row1['oasis_therapy_patient_diagnosis_2f'];
  } else if ($table_name == 'forms_OASIS') {$other_diagnosis_5_icd_code = $row1['OASIS_C_primary_diagnosis_v_code_e_code_f'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$other_diagnosis_5_icd_code = $row1['oasis_patient_diagnosis_2f'];
  } else {$other_diagnosis_5_icd_code = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	      if($row1['oasis_therapy_patient_diagnosis_2f_sub']!=''){$other_diagnosis_5_severity_rating = '0' . $row1['oasis_therapy_patient_diagnosis_2f_sub'];}
	      else{
	      $other_diagnosis_5_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_OASIS') {
	      if($row1['OASIS_C_primary_diagnosis_v_code_e_code_options_f']!=''){$other_diagnosis_5_severity_rating = '0' . $row1['OASIS_C_primary_diagnosis_v_code_e_code_options_f'];}
	      else{
	      $other_diagnosis_5_severity_rating=' ';
	      }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	      if($row1['oasis_patient_diagnosis_2f_sub']!=''){$other_diagnosis_5_severity_rating = '0' . $row1['oasis_patient_diagnosis_2f_sub'];}
	      else{
	      $other_diagnosis_5_severity_rating=' ';
	      }
  } else {$other_diagnosis_5_severity_rating = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_patient_history_therapies)) {$therapies_received_intravenous = '1';
	  } else {$therapies_received_intravenous = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Intravenous or infusion therapy (excludes TPN)", $oasis_patient_history_therapies)) {$therapies_received_intravenous = '1';
	  } else {$therapies_received_intravenous = '0';
	  }
  } else {$therapies_received_intravenous = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("2", $oasis_patient_history_therapies)) {$therapies_received_parenteral = '1';
	  } else {$therapies_received_parenteral = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Parenteral nutrition (TPN or lipids)", $oasis_patient_history_therapies)) {$therapies_received_parenteral = '1';
	  } else {$therapies_received_parenteral = '0';
	  }
  } else {$therapies_received_parenteral = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_patient_history_therapies)) {$therapies_received_enternal = '1';
	  } else {$therapies_received_enternal = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Enteral nutrition (nasogastric, gastrostomy, jejunostomy, or any other artificial entry into the alimentary canal)", $oasis_patient_history_therapies)) {$therapies_received_enternal = '1';
	  } else {$therapies_received_enternal = '0';
	  }
  } else {$therapies_received_enternal = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_c_nurse' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_patient_history_therapies)) {$therapies_received_none = '1';
	  } else {$therapies_received_none = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("None of the above", $oasis_patient_history_therapies)) {$therapies_received_none = '1';
	  } else {$therapies_received_none = '0';
	  }
  } else {$therapies_received_none = ' ';
  }
  $item_filler_6 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_patient_history_risk_factors)) {$high_risk_factor_smoking = '1';
	  } else {$high_risk_factor_smoking = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Smoking", $oasis_patient_history_risk_factors)) {$high_risk_factor_smoking = '1';
	  } else {$high_risk_factor_smoking = '0';
	  }
  } else {$high_risk_factor_smoking = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("2", $oasis_patient_history_risk_factors)) {$high_risk_factor_obesity = '1';
	  } else {$high_risk_factor_obesity = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Obesity", $oasis_patient_history_risk_factors)) {$high_risk_factor_obesity = '1';
	  } else {$high_risk_factor_obesity = '0';
	  }
  } else {$high_risk_factor_obesity = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_patient_history_risk_factors)) {$high_risk_factor_alcoholism = '1';
	  } else {$high_risk_factor_alcoholism = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Alcohol dependency", $oasis_patient_history_risk_factors)) {$high_risk_factor_alcoholism = '1';
	  } else {$high_risk_factor_alcoholism = '0';
	  }
  } else {$high_risk_factor_alcoholism = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_patient_history_risk_factors)) {$high_risk_factor_drugs = '1';
	  } else {$high_risk_factor_drugs = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Drug dependency", $oasis_patient_history_risk_factors)) {$high_risk_factor_drugs = '1';
	  } else {$high_risk_factor_drugs = '0';
	  }
  } else {$high_risk_factor_drugs = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("5", $oasis_patient_history_risk_factors)) {$high_risk_factor_none = '1';
	  } else {$high_risk_factor_none = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("None of the above", $oasis_patient_history_risk_factors)) {$high_risk_factor_none = '1';
	  } else {$high_risk_factor_none = '0';
	  }
  } else {$high_risk_factor_none = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("UK", $oasis_patient_history_risk_factors)) {$high_risk_factor_unknown = '1';
	  } else {$high_risk_factor_unknown = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Unknown", $oasis_patient_history_risk_factors)) {$high_risk_factor_unknown = '1';
	  } else {$high_risk_factor_unknown = '0';
	  }
  } else {$high_risk_factor_unknown = ' ';
  }
  $item_filler16 = '';
  $item_filler4 = '';
  $item_filler5 = '';
  $item_filler17 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$sensory_status_vision = '0' . $row1['oasis_sensory_status_vision'];
  } else if ($table_name == 'forms_OASIS') {$sensory_status_vision = '0' . $row1['sensory_status_vision'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$sensory_status_vision = '0' . $row1['oasis_c_nurse_vision'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$sensory_status_vision = '0' . $row1['oasis_therapy_vision'];
  } else {$sensory_status_vision = ' ';
  }
  $item_filler18 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$sensory_status_speech = '0' . $row1['oasis_sensory_status_speech'];
  } else if ($table_name == 'forms_OASIS') {$sensory_status_speech = '0' . $row1['sensory_stathius_speech_oral'];
  } else if ($table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_transfer') {$sensory_status_speech = '0' . $row1['oasis_speech_and_oral'];
  } else {$sensory_status_speech = ' ';
  }
  $item_filler19 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$number_pressure_ulcers = '0' . $row1['oasis_therapy_pressure_ulcer_current_no'];
  } else if ($table_name == 'forms_OASIS') {$number_pressure_ulcers = '0' . $row1['integumentary_status_current_ulcer_stage1'];
  } else if ($table_name == 'forms_oasis_discharge') {$number_pressure_ulcers = '0' . $row1['oasis_therapy_pressure_ulcer_current_no'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$number_pressure_ulcers = '0' . $row1['oasis_c_nurse_current_ulcer_stage1'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$number_pressure_ulcers = '0' . $row1['oasis_therapy_current_ulcer_stage1'];
  } else {$number_pressure_ulcers = ' ';
  }
  $item_filler20 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_therapy_pressure_ulcer_stage_unhealed'] == "NA") {$stage_pressure_ulcer = "NA";
	  } else {
	      if($row1['oasis_therapy_pressure_ulcer_stage_unhealed']!=''){$stage_pressure_ulcer = '0' . $row1['oasis_therapy_pressure_ulcer_stage_unhealed'];}
	      else{
	      $stage_pressure_ulcer=' ';
	      }
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['integumentary_status_stage_of_problematic_ulcer'] == "NA") {$stage_pressure_ulcer = "NA";
	  } else {
	      if($row1['integumentary_status_stage_of_problematic_ulcer']!=''){$stage_pressure_ulcer = '0' . $row1['integumentary_status_stage_of_problematic_ulcer'];}
	      else{
	      $stage_pressure_ulcer=' ';
	      }
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_therapy_pressure_ulcer_stage_unhealed'] == "NA") {$stage_pressure_ulcer = "NA";
	  } else {
	      if($row1['oasis_therapy_pressure_ulcer_stage_unhealed']!=''){$stage_pressure_ulcer = '0' . $row1['oasis_therapy_pressure_ulcer_stage_unhealed'];}
	      else{
	      $stage_pressure_ulcer=' ';
	      }
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_stage_of_problematic_ulcer'] == "NA or more") {$stage_pressure_ulcer = "NA";
	  } else {
	      if($row1['oasis_c_nurse_stage_of_problematic_ulcer']!=''){$stage_pressure_ulcer = '0' . $row1['oasis_c_nurse_stage_of_problematic_ulcer'];}
	      else{
	      $stage_pressure_ulcer=' ';
	      }
	  }
  } else if ($table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_stage_of_problematic_ulcer'] == "NA") {$stage_pressure_ulcer = "NA";
	  } else {
	      if($row1['oasis_therapy_stage_of_problematic_ulcer']!=''){$stage_pressure_ulcer = '0' . $row1['oasis_therapy_stage_of_problematic_ulcer'];}
	      else{
	      $stage_pressure_ulcer=' ';
	      }
	  }
  } else {$stage_pressure_ulcer = ' ';
  }
  $item_filler22 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$when_dyspenic = '0' . $row1['oasis_therapy_respiratory_status'];
  } else if ($table_name == 'forms_OASIS') {$when_dyspenic = '0' . $row1['respiratory_status_short_of_breath'];
  } else if ($table_name == 'forms_oasis_discharge') {$when_dyspenic = '0' . $row1['oasis_therapy_respiratory_status'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$when_dyspenic = '0' . $row1['oasis_c_nurse_respiratory_status'];
  } else {$when_dyspenic = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_therapy_respiratory_treatment)) {$resp_treatments_oxygen = '1';
	  } else {$resp_treatments_oxygen = '0';
	  }
  } else {$resp_treatments_oxygen = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("2", $oasis_therapy_respiratory_treatment)) {$resp_treatments_ventilator = '1';
	  } else {$resp_treatments_ventilator = '0';
	  }
  } else {$resp_treatments_ventilator = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_therapy_respiratory_treatment)) {$resp_treatments_airway = '1';
	  } else {$resp_treatments_airway = '0';
	  }
  } else {$resp_treatments_airway = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_therapy_respiratory_treatment)) {$resp_treatments_none = '1';
	  } else {$resp_treatments_none = '0';
	  }
  } else {$resp_treatments_none = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_elimination_status_tract_infection'] == "NA" || $row1['oasis_elimination_status_tract_infection'] == "UK") {$treated_for_urinary_tract_infection = $row1['oasis_elimination_status_tract_infection'];
	  } else {$treated_for_urinary_tract_infection = "0" . $row1['oasis_elimination_status_tract_infection'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['elimination_status_urinary_tract_infection'] == "NA" || $row1['elimination_status_urinary_tract_infection'] == "UK") {$treated_for_urinary_tract_infection = $row1['elimination_status_urinary_tract_infection'];
	  } else {$treated_for_urinary_tract_infection = "0" . $row1['elimination_status_urinary_tract_infection'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_elimination_status_tract_infection'] == "NA" || $row1['oasis_elimination_status_tract_infection'] == "UK") {$treated_for_urinary_tract_infection = $row1['oasis_elimination_status_tract_infection'];
	  } else {$treated_for_urinary_tract_infection = "0" . $row1['oasis_elimination_status_tract_infection'];
	  }
  } else {$treated_for_urinary_tract_infection = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$urinary_incontinence = '0' . $row1['oasis_elimination_status_urinary_incontinence'];
  } else if ($table_name == 'forms_OASIS') {$urinary_incontinence = '0' . $row1['elimination_status_urinary_incontinence'];
  } else if ($table_name == 'forms_oasis_discharge') {$urinary_incontinence = '0' . $row1['oasis_elimination_status_urinary_incontinence'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$urinary_incontinence = '0' . $row1['oasis_c_nurse_elimination_urinary_incontinence'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$urinary_incontinence = '0' . $row1['oasis_therapy_elimination_urinary_incontinence'];
  } else {$urinary_incontinence = ' ';
  }
  $item_filler21 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_elimination_status_bowel_incontinence'] == "NA" || $row1['oasis_elimination_status_bowel_incontinence'] == "UK") {$bowel_incontinence_frequency = $row1['oasis_elimination_status_bowel_incontinence'];
	  } else {$bowel_incontinence_frequency = "0" . $row1['oasis_elimination_status_bowel_incontinence'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['elimination_status_bowel_incontinence_frequency'] == "NA" || $row1['elimination_status_bowel_incontinence_frequency'] == "UK") {$bowel_incontinence_frequency = $row1['elimination_status_bowel_incontinence_frequency'];
	  } else {$bowel_incontinence_frequency = "0" . $row1['elimination_status_bowel_incontinence_frequency'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_elimination_status_bowel_incontinence'] == "NA" || $row1['oasis_elimination_status_bowel_incontinence'] == "UK") {$bowel_incontinence_frequency = $row1['oasis_elimination_status_bowel_incontinence'];
	  } else {$bowel_incontinence_frequency = "0" . $row1['oasis_elimination_status_bowel_incontinence'];
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_elimination_bowel_incontinence'] == "NA" || $row1['oasis_c_nurse_elimination_bowel_incontinence'] == "UK") {$bowel_incontinence_frequency = $row1['oasis_c_nurse_elimination_bowel_incontinence'];
	  } else {$bowel_incontinence_frequency = "0" . $row1['oasis_c_nurse_elimination_bowel_incontinence'];
	  }
  } else if ($table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_elimination_bowel_incontinence'] == "NA" || $row1['oasis_therapy_elimination_bowel_incontinence'] == "UK") {$bowel_incontinence_frequency = $row1['oasis_therapy_elimination_bowel_incontinence'];
	  } else {$bowel_incontinence_frequency = "0" . $row1['oasis_therapy_elimination_bowel_incontinence'];
	  }
  } else {$bowel_incontinence_frequency = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$ostomy_for_bowel_elimination = '0' . $row1['oasis_elimination_status_ostomy_bowel'];
  } else if ($table_name == 'forms_OASIS') {$ostomy_for_bowel_elimination = '0' . $row1['elimination_status_bowel_elimination'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$ostomy_for_bowel_elimination = '0' . $row1['oasis_c_nurse_elimination_ostomy'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$ostomy_for_bowel_elimination = '0' . $row1['oasis_therapy_elimination_ostomy'];
  } else {$ostomy_for_bowel_elimination = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$cognitive_functioning = '0' . $row1['oasis_neuro_cognitive_functioning'];
  } else if ($table_name == 'forms_OASIS') {$cognitive_functioning = '0' . $row1['neuro_status_cognitive_functioning'];
  } else if ($table_name == 'forms_oasis_discharge') {$cognitive_functioning = '0' . $row1['oasis_neuro_cognitive_functioning'];
  } else {$cognitive_functioning = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_neuro_when_confused'] == "NA") {$when_confused = "NA";
	  } else {$when_confused = "0" . $row1['oasis_neuro_when_confused'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['neuro_status_when_confused'] == "NA") {$when_confused = "NA";
	  } else {$when_confused = "0" . $row1['neuro_status_when_confused'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_neuro_when_confused'] == "NA") {$when_confused = "NA";
	  } else {$when_confused = "0" . $row1['oasis_neuro_when_confused'];
	  }
  } else {$when_confused = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_neuro_when_anxious'] == "NA") {$when_anxious = "NA";
	  } else {$when_anxious = "0" . $row1['oasis_neuro_when_anxious'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['neuro_status_when_anxious'] == "NA") {$when_anxious = "NA";
	  } else {$when_anxious = "0" . $row1['neuro_status_when_anxious'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_neuro_when_anxious'] == "NA") {$when_anxious = "NA";
	  } else {$when_anxious = "0" . $row1['oasis_neuro_when_anxious'];
	  }
  } else {$when_anxious = ' ';
  }
  $item_filler23 = '';
  $item_filler7 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_neuro_cognitive_symptoms)) {$behaviour_memory_deficit = '1';
	  } else {$behaviour_memory_deficit = '0';
	  }
  } else {$behaviour_memory_deficit = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("2", $oasis_neuro_cognitive_symptoms)) {$behaviour_impaired = '1';
	  } else {$behaviour_impaired = '0';
	  }
  } else {$behaviour_impaired = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_neuro_cognitive_symptoms)) {$behaviour_verbal_disruption = '1';
	  } else {$behaviour_verbal_disruption = '0';
	  }
  } else {$behaviour_verbal_disruption = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_neuro_cognitive_symptoms)) {$behaviour_physically_aggression = '1';
	  } else {$behaviour_physically_aggression = '0';
	  }
  } else {$behaviour_physically_aggression = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("5", $oasis_neuro_cognitive_symptoms)) {$behaviour_socially_inappropriate = '1';
	  } else {$behaviour_socially_inappropriate = '0';
	  }
  } else {$behaviour_socially_inappropriate = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("6", $oasis_neuro_cognitive_symptoms)) {$behaviour_delusions = '1';
	  } else {$behaviour_delusions = '0';
	  }
  } else {$behaviour_delusions = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("7", $oasis_neuro_cognitive_symptoms)) {$behaviour_none = '1';
	  } else {$behaviour_none = '0';
	  }
  } else {$behaviour_none = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$frequency_of_behaviour_problems = '0' . $row1['oasis_neuro_frequency_disruptive'];
  } else if ($table_name == 'forms_OASIS') {$frequency_of_behaviour_problems = '0' . $row1['neuro_status_freq_behaviour_symptoms'];
  } else if ($table_name == 'forms_oasis_discharge') {$frequency_of_behaviour_problems = '0' . $row1['oasis_neuro_frequency_disruptive'];
  } else {$frequency_of_behaviour_problems = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$receives_psychiatric_nursing = $row1['oasis_neuro_psychiatric_nursing'];
  } else if ($table_name == 'forms_OASIS') {$receives_psychiatric_nursing = $row1['neuro_status_psychiatric_nursing_service'];
  } else {$receives_psychiatric_nursing = ' ';
  }
  $item_filler24 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$current_grooming = '0' . $row1['oasis_adl_grooming'];
  } else if ($table_name == 'forms_OASIS') {$current_grooming = '0' . $row1['adl_iadl_grooming'];
  } else if ($table_name == 'forms_oasis_discharge') {$current_grooming = '0' . $row1['oasis_adl_grooming'];
  } else {$current_grooming = ' ';
  }
  $item_filler25 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$current_dress_upper_body = '0' . $row1['oasis_adl_dress_upper'];
  } else if ($table_name == 'forms_OASIS') {$current_dress_upper_body = '0' . $row1['adl_iadl_dress_upper'];
  } else if ($table_name == 'forms_oasis_discharge') {$current_dress_upper_body = '0' . $row1['oasis_adl_dress_upper'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$current_dress_upper_body = '0' . $row1['oasis_c_nurse_adl_dress_upper'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$current_dress_upper_body = '0' . $row1['oasis_therapy_adl_dress_upper'];
  } else {$current_dress_upper_body = ' ';
  }
  $item_filler26 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$current_dress_lower_body = '0' . $row1['oasis_adl_dress_lower'];
  } else if ($table_name == 'forms_OASIS') {$current_dress_lower_body = '0' . $row1['adl_iadl_dress_lower'];
  } else if ($table_name == 'forms_oasis_discharge') {$current_dress_lower_body = '0' . $row1['oasis_adl_dress_lower'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$current_dress_lower_body = '0' . $row1['oasis_c_nurse_adl_dress_lower'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$current_dress_lower_body = '0' . $row1['oasis_therapy_adl_dress_lower'];
  } else {$current_dress_lower_body = ' ';
  }
  $item_filler27 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$current_feeding = '0' . $row1['oasis_adl_feeding_eating'];
  } else if ($table_name == 'forms_OASIS') {$current_feeding = '0' . $row1['adl_iadl_feeding'];
  } else if ($table_name == 'forms_oasis_discharge') {$current_feeding = '0' . $row1['oasis_adl_feeding_eating'];
  } else {$current_feeding = ' ';
  }
  $item_filler28 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$current_prepare_light_meals = '0' . $row1['oasis_adl_current_ability'];
  } else if ($table_name == 'forms_OASIS') {$current_prepare_light_meals = '0' . $row1['adl_iadl_prepare_meal'];
  } else if ($table_name == 'forms_oasis_discharge') {$current_prepare_light_meals = '0' . $row1['oasis_adl_current_ability'];
  } else {$current_prepare_light_meals = ' ';
  }
  $item_filler29 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_adl_use_telephone'] == "NA") {$current_telephone_use = "NA";
	  } else {$current_telephone_use = "0" . $row1['oasis_adl_use_telephone'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['adl_iadl_use_telephone'] == "NA") {$current_telephone_use = "NA";
	  } else {$current_telephone_use = "0" . $row1['adl_iadl_use_telephone'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_adl_use_telephone'] == "NA") {$current_telephone_use = "NA";
	  } else {$current_telephone_use = "0" . $row1['oasis_adl_use_telephone'];
	  }
  } else {$current_telephone_use = ' ';
  }
  $item_filler30 = '';
  $emergency_care_reason_medication = '0';
  $item_filler31 = '';
  $emergency_care_reason_hypoglycemia = '0';
  $item_filler32 = '';
  $emergency_care_reason_unknown = '0';
  if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_inpatient_facility'] == "NA") {$inpatient_facility = "NA";
	  } else {$inpatient_facility = "0" . $row1['oasis_inpatient_facility'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Inpatient_Facility_patient_been_admitted'] == "Hospital") {$inpatient_facility = '01';
	  } else if ($row1['Inpatient_Facility_patient_been_admitted'] == "Rehabilitation facility") {$inpatient_facility = '02';
	  } else if ($row1['Inpatient_Facility_patient_been_admitted'] == "Nursing home") {$inpatient_facility = '03';
	  } else if ($row1['Inpatient_Facility_patient_been_admitted'] == "Hospice") {$inpatient_facility = '04';
	  } else if ($row1['Inpatient_Facility_patient_been_admitted'] == "NA - No inpatient facility admission") {$inpatient_facility = "NA";
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Inpatient_Facility_patient_admitted'] == "Hospital") {$inpatient_facility = '01';
	  } else if ($row1['oasistransfer_Inpatient_Facility_patient_admitted'] == "Rehabilitation_Facility") {$inpatient_facility = '02';
	  } else if ($row1['oasistransfer_Inpatient_Facility_patient_admitted'] == "Nursing_home") {$inpatient_facility = '03';
	  } else if ($row1['oasistransfer_Inpatient_Facility_patient_admitted'] == "Hospice") {$inpatient_facility = '04';
	  } else if ($row1['oasistransfer_Inpatient_Facility_patient_admitted'] == "NA") {$inpatient_facility = "NA";
	  }
  } else {$inpatient_facility = ' ';
  }
  $item_filler33 = '';
  $hospitalized_medication = '0';
  $item_filler34 = '';
  $hospitalized_hypoglycemia = '0';
  $item_filler3 = '';
  $hospitalized_urinary_tract = '0';
  $item_filler36 = '';
  $hospitalized_deep_vein = '0';
  $hospitalized_pain = '0';
  $item_filler37 = '';
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Therapy services", $adimitted_to_nursing_home)) {$adimitted_to_nursing_home_therapy = '1';
	  } else {$adimitted_to_nursing_home_therapy = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Admitted_in_NursingHome_for_Theraphy_Services'] == "on") {$adimitted_to_nursing_home_therapy = 1;
	  } else {$adimitted_to_nursing_home_therapy = 0;
	  }
  } else {$adimitted_to_nursing_home_therapy = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Respite care", $adimitted_to_nursing_home)) {$adimitted_to_nursing_home_respite = '1';
	  } else {$adimitted_to_nursing_home_respite = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Admitted_in_NursingHome_for_Respite_care'] == "on") {$adimitted_to_nursing_home_respite = 1;
	  } else {$adimitted_to_nursing_home_respite = 0;
	  }
  } else {$adimitted_to_nursing_home_respite = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Hospice care", $adimitted_to_nursing_home)) {$adimitted_to_nursing_home_hospice = '1';
	  } else {$adimitted_to_nursing_home_hospice = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Admitted_in_NursingHome_for_Hospice_care'] == "on") {$adimitted_to_nursing_home_hospice = 1;
	  } else {$adimitted_to_nursing_home_hospice = 0;
	  }
  } else {$adimitted_to_nursing_home_hospice = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Permanent placement", $adimitted_to_nursing_home)) {$adimitted_to_nursing_home_permanent = '1';
	  } else {$adimitted_to_nursing_home_permanent = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Admitted_in_NursingHome_for_Permanent_placement'] == "on") {$adimitted_to_nursing_home_permanent = 1;
	  } else {$adimitted_to_nursing_home_permanent = 0;
	  }
  } else {$adimitted_to_nursing_home_permanent = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Unsafe for care at home", $adimitted_to_nursing_home)) {$adimitted_to_nursing_home_unsafe = '1';
	  } else {$adimitted_to_nursing_home_unsafe = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Admitted_in_NursingHome_as_Unsafe_at_home'] == "on") {$adimitted_to_nursing_home_unsafe = 1;
	  } else {$adimitted_to_nursing_home_unsafe = 0;
	  }
  } else {$adimitted_to_nursing_home_unsafe = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Other", $adimitted_to_nursing_home)) {$adimitted_to_nursing_home_other = '1';
	  } else {$adimitted_to_nursing_home_other = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Admitted_in_NursingHome_for_Other_Reason'] == "on") {$adimitted_to_nursing_home_other = 1;
	  } else {$adimitted_to_nursing_home_other = 0;
	  }
  } else {$adimitted_to_nursing_home_other = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Unknown", $adimitted_to_nursing_home)) {$adimitted_to_nursing_home_unknown = '1';
	  } else {$adimitted_to_nursing_home_unknown = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason'] == "on") {$adimitted_to_nursing_home_unknown = 1;
	  } else {$adimitted_to_nursing_home_unknown = 0;
	  }
  } else {$adimitted_to_nursing_home_unknown = ' ';
  }
  if ($table_name == 'forms_OASIS') {$last_home_visit_date = str_replace('-', '', $row1['OASIS_C_Date_of_Last_Home_Visit']);
  } else if ($table_name == 'forms_oasis_discharge') {$last_home_visit_date = str_replace('-', '', $row1['oasis_discharge_date_last_visit']);
  } else if ($table_name == 'forms_oasis_transfer') {$last_home_visit_date = str_replace('-', '', $row1['oasistransfer_Last_Home_Visit_Date']);
  } else {$last_home_visit_date = "        ";
  }
  if ($table_name == 'forms_OASIS') {$discharge_transfer_death_date = str_replace('-', '', $row1['OASIS_C_Enter_the_date_of_the_discharge']);
  } else if ($table_name == 'forms_oasis_discharge') {$discharge_transfer_death_date = str_replace('-', '', $row1['oasis_discharge_transfer_date']);
  } else if ($table_name == 'forms_oasis_transfer') {$discharge_transfer_death_date = str_replace('-', '', $row1['oasistransfer_Discharge_Transfer_Death_Date']);
  } else {$discharge_transfer_death_date = "        ";
  }
  $item_filler8 = '';
  $item_filler9 = '';
  $item_filler38 = '';
  $discharged_skilled_nursing_facility = '0';
  $item_filler39 = '';
  $not_discharged_skilled_nursing_facility = '0';
  $item_filler10 = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$NPI = $row1['oasis_patient_npi'];
  } else if ($table_name == 'forms_OASIS') {$NPI = $row1['OASIS_C_provider_npi'];
  } else if ($table_name == 'forms_oasis_discharge' || $table_name='forms_oasis_therapy_rectification') {$NPI = $row1['oasis_therapy_npi'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$NPI = $row1['oasis_c_nurse_npi'];
  } else {$NPI = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_episode_timing'] == "NA" || $row1['oasis_patient_episode_timing'] == "UK") {$episode_timing = $row1['oasis_patient_episode_timing'];
	  } else {$episode_timing = "0" . $row1['oasis_patient_episode_timing'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_CRI_Episode_Timing'] == "NA" || $row1['OASIS_C_CRI_Episode_Timing'] == "UK") {$episode_timing = $row1['OASIS_C_CRI_Episode_Timing'];
	  } else {$episode_timing = "0" . $row1['OASIS_C_CRI_Episode_Timing'];
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_episode_timing'] == "NA" || $row1['oasis_c_nurse_episode_timing'] == "UK") {$episode_timing = $row1['oasis_c_nurse_episode_timing'];
	  } else {$episode_timing = "0" . $row1['oasis_c_nurse_episode_timing'];
	  }
  } else if ($table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_episode_timing'] == "NA" || $row1['oasis_therapy_episode_timing'] == "UK") {$episode_timing = $row1['oasis_therapy_episode_timing'];
	  } else {$episode_timing = "0" . $row1['oasis_therapy_episode_timing'];
	  }
  } else {$episode_timing = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_primary_col3 = ' '.$row1['oasis_therapy_patient_diagnosis_3a'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_primary_col3 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_a'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_primary_col3 = $row1['oasis_patient_diagnosis_3a'];
  } else {$case_mix_diag_primary_col3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_1_secondary_col3 = ' '.$row1['oasis_therapy_patient_diagnosis_3b'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_1_secondary_col3 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_b'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_1_secondary_col3 = $row1['oasis_patient_diagnosis_3b'];
  } else {$case_mix_diag_1_secondary_col3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_2_secondary_col3 = ' '.$row1['oasis_therapy_patient_diagnosis_3c'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_2_secondary_col3 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_c'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_2_secondary_col3 = $row1['oasis_patient_diagnosis_3c'];
  } else {$case_mix_diag_2_secondary_col3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_3_secondary_col3 = ' '.$row1['oasis_therapy_patient_diagnosis_3d'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_3_secondary_col3 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_e'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_3_secondary_col3 = $row1['oasis_patient_diagnosis_3d'];
  } else {$case_mix_diag_3_secondary_col3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_4_secondary_col3 = ' '.$row1['oasis_therapy_patient_diagnosis_3e'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_4_secondary_col3 = $row1['OASIS_payment_diagnosis_V_or_E_code_not_allowed_1_e'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_4_secondary_col3 = $row1['oasis_patient_diagnosis_3e'];
  } else {$case_mix_diag_4_secondary_col3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_5_secondary_col3 = ' '.$row1['oasis_therapy_patient_diagnosis_3f'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_5_secondary_col3 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_f'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_5_secondary_col3 = $row1['oasis_patient_diagnosis_3f'];
  } else {$case_mix_diag_5_secondary_col3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_primary_col4 = ' '.$row1['oasis_therapy_patient_diagnosis_4a'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_primary_col4 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_a'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_primary_col4 = $row1['oasis_patient_diagnosis_4a'];
  } else {$case_mix_diag_primary_col4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_1_secondary_col4 = ' '.$row1['oasis_therapy_patient_diagnosis_4b'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_1_secondary_col4 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_b'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_1_secondary_col4 = $row1['oasis_patient_diagnosis_4b'];
  } else {$case_mix_diag_1_secondary_col4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_2_secondary_col4 = ' '.$row1['oasis_therapy_patient_diagnosis_4c'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_2_secondary_col4 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_c'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_2_secondary_col4 = $row1['oasis_patient_diagnosis_4c'];
  } else {$case_mix_diag_2_secondary_col4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_3_secondary_col4 = ' '.$row1['oasis_therapy_patient_diagnosis_4d'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_3_secondary_col4 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_d'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_3_secondary_col4 = $row1['oasis_patient_diagnosis_4d'];
  } else {$case_mix_diag_3_secondary_col4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_4_secondary_col4 = ' '.$row1['oasis_therapy_patient_diagnosis_4e'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_4_secondary_col4 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_e'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_4_secondary_col4 = $row1['oasis_patient_diagnosis_4e'];
  } else {$case_mix_diag_4_secondary_col4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name='forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$case_mix_diag_5_secondary_col4 = ' '.$row1['oasis_therapy_patient_diagnosis_4f'];
  } else if ($table_name == 'forms_OASIS') {$case_mix_diag_5_secondary_col4 = $row1['OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_f'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$case_mix_diag_5_secondary_col4 = $row1['oasis_patient_diagnosis_4f'];
  } else {$case_mix_diag_5_secondary_col4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$therapy_need_no_of_visits = correctTherapyNeed($row1['oasis_care_therapy_visits']);
  } else if ($table_name == 'forms_OASIS') {$therapy_need_no_of_visits = correctTherapyNeed($row1['OASIS_C_Therapy_Need']);
  } else if ($table_name == 'forms_oasis_c_nurse') {$therapy_need_no_of_visits = correctTherapyNeed($row1['oasis_c_nurse_therapy_need_number']);
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$therapy_need_no_of_visits = correctTherapyNeed($row1['oasis_therapy_therapy_need_number']);
  } else {$therapy_need_no_of_visits = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_therapy_need_applicable'] == 'NA') {$therapy_need_NA = 1;
	  } else {$therapy_need_NA = 0;
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_Therapy_Need_other'] == 'NA') {$therapy_need_NA = 1;
	  } else {$therapy_need_NA = 0;
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_therapy_need'] == 'NA') {$therapy_need_NA = 1;
	  } else {$therapy_need_NA = 0;
	  }
  } else if ($table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_therapy_need'] == 'NA') {$therapy_need_NA = 1;
	  } else {$therapy_need_NA = 0;
	  }
  } else {$therapy_need_NA = ' ';
  }
  $item_filler40 = '';
  if ($table_name == 'forms_OASIS') {$phy_ordered_SOC_ROC_date = str_replace('-', '', $row1['OASIS_C_start_care']);
  } else if ($table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_transfer' || $table_name == 'forms_oasis_therapy_rectification') {$phy_ordered_SOC_ROC_date = str_replace('-', '', $row1['oasis_therapy_soc_date']);
  } else if ($table_name == 'forms_oasis_pt_soc') {$phy_ordered_SOC_ROC_date = str_replace('-', '', $row1['oasis_patient_date_ordered_soc']);
  } else {$phy_ordered_SOC_ROC_date = "        ";
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_CRI_No_specific_SOC'] == 'NA') {$phy_ordered_SOC_ROC_date_NA = 1;
	  } else {$phy_ordered_SOC_ROC_date_NA = 0;
	  }
  } else if ($table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_date_ordered_soc_na'] == 'NA') {$phy_ordered_SOC_ROC_date_NA = 1;
	  } else {$phy_ordered_SOC_ROC_date_NA = 0;
	  }
  } else {$phy_ordered_SOC_ROC_date_NA = ' ';
  }
  if ($table_name == 'forms_OASIS') {$phy_date_of_referral = str_replace('-', '', $row1['OASIS_C_Date_Referral']);
  } else if ($table_name == 'forms_oasis_pt_soc') {$phy_date_of_referral = str_replace('-', '', $row1['oasis_patient_date_of_referral']);
  } else {$phy_date_of_referral = "        ";
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_patient_history_impatient_facility)) {$discharge_ltc_nh = '1';
	  } else {$discharge_ltc_nh = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Long-term care hospital (LTCH)", $oasis_patient_history_impatient_facility)) {$discharge_ltc_nh = '1';
	  } else {$discharge_ltc_nh = '0';
	  }
  } else {$discharge_ltc_nh = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_patient_history_impatient_facility)) {$discharge_short_stay = '1';
	  } else {$discharge_short_stay = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Short-stay acute hospital (IPP S)", $oasis_patient_history_impatient_facility)) {$discharge_short_stay = '1';
	  } else {$discharge_short_stay = '0';
	  }
  } else {$discharge_short_stay = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_patient_history_impatient_facility)) {$discharge_long_term = '1';
	  } else {$discharge_long_term = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Long-term nursing facility", $oasis_patient_history_impatient_facility)) {$discharge_long_term = '1';
	  } else {$discharge_long_term = '0';
	  }
  } else {$discharge_long_term = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("5", $oasis_patient_history_impatient_facility)) {$discharge_inpatient_rehab_facility = '1';
	  } else {$discharge_inpatient_rehab_facility = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Inpatient rehabilitation hospital or unit (IRF)", $oasis_patient_history_impatient_facility)) {$discharge_inpatient_rehab_facility = '1';
	  } else {$discharge_inpatient_rehab_facility = '0';
	  }
  } else {$discharge_inpatient_rehab_facility = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("6", $oasis_patient_history_impatient_facility)) {$discharge_psychiatric_unit = '1';
	  } else {$discharge_psychiatric_unit = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Psychiatric hospital or unit", $oasis_patient_history_impatient_facility)) {$discharge_psychiatric_unit = '1';
	  } else {$discharge_psychiatric_unit = '0';
	  }
  } else {$discharge_psychiatric_unit = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("7", $oasis_patient_history_impatient_facility)) {$discharge_other = '1';
	  } else {$discharge_other = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Other (specify)", $oasis_patient_history_impatient_facility)) {$discharge_other = '1';
	  } else {$discharge_other = '0';
	  }
  } else {$discharge_other = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_icd_code3 = ' '.$oasis_patient_history_if_code[2];
  } else {$inpatient_icd_code3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_icd_code4 = ' '.$oasis_patient_history_if_code[3];
  } else {$inpatient_icd_code4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_icd_code5 = ' '.$oasis_patient_history_if_code[4];
  } else {$inpatient_icd_code5 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_icd_code6 = ' '.$oasis_patient_history_if_code[5];
  } else {$inpatient_icd_code6 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_icd_pro_code1 = ' '.$oasis_patient_history_ip_code[0];
  } else {$inpatient_icd_pro_code1 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_icd_pro_code2 = ' '.$oasis_patient_history_ip_code[1];
  } else {$inpatient_icd_pro_code2 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_icd_pro_code3 = ' '.$oasis_patient_history_ip_code[2];
  } else {$inpatient_icd_pro_code3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$inpatient_icd_pro_code4 = ' '.$oasis_patient_history_ip_code[3];
  } else {$inpatient_icd_pro_code4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption') {
	  if ($row1['oasis_patient_history_ip_diagnosis_na'] == 'NA') {$inpatient_icd_pro_code_NA = 1;
	  } else {$inpatient_icd_pro_code_NA = 0;
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("NA - Not applicable", $OASIS_C_PHAD_Inpatient_Procedure_other)) {$inpatient_icd_pro_code_NA = '1';
	  } else {$inpatient_icd_pro_code_NA = '0';
	  }
  } else if ($table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_date_ordered_soc_na'] == 'NA') {$inpatient_icd_pro_code_NA = 1;
	  } else {$inpatient_icd_pro_code_NA = '0';
	  }
  } else {$inpatient_icd_pro_code_NA = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption') {
	  if ($row1['oasis_patient_history_ip_diagnosis_uk'] == 'UK') {$inpatient_icd_pro_code_UK = 1;
	  } else {$inpatient_icd_pro_code_UK = 0;
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("UK - Unknown", $OASIS_C_PHAD_Inpatient_Procedure_other)) {$inpatient_icd_pro_code_UK = '1';
	  } else {$inpatient_icd_pro_code_UK = '0';
	  }
  } else {$inpatient_icd_pro_code_UK = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$regimen_icd_code5 = ' '.$oasis_patient_history_mrd_code[4];
  } else {$regimen_icd_code5 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc') {$regimen_icd_code6 = ' '.$oasis_patient_history_mrd_code[5];
  } else {$regimen_icd_code6 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_history_regimen_change'] == 'NA') {$regimen_NA = 1;
	  } else {$regimen_NA = 0;
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_treatment_regimen_change'] == 'NA') {$regimen_NA = 1;
	  } else {$regimen_NA = 0;
	  }
  } else {$regimen_NA = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("1", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_recent = '1';
	  } else {$risk_hosp_recent = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Recent decline in mental, emotional, or behavioral status", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_recent = '1';
	  } else {$risk_hosp_recent = '0';
	  }
  } else {$risk_hosp_recent = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("2", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_multiple = '1';
	  } else {$risk_hosp_multiple = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Multiple hospitalizations (2 or more) in the past 12 months", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_multiple = '1';
	  } else {$risk_hosp_multiple = '0';
	  }
  } else {$risk_hosp_multiple = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("3", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_medications = '1';
	  } else {$risk_hosp_medications = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("History of falls (2 or more falls - or any fall with an injury - in the past year)", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_medications = '1';
	  } else {$risk_hosp_medications = '0';
	  }
  } else {$risk_hosp_medications = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("4", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_history = '1';
	  } else {$risk_hosp_history = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Taking five or more medications", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_history = '1';
	  } else {$risk_hosp_history = '0';
	  }
  } else {$risk_hosp_history = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("5", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_fraility = '1';
	  } else {$risk_hosp_fraility = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Frailty indicators, e.g., weight loss, self-reported exhaustion", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_fraility = '1';
	  } else {$risk_hosp_fraility = '0';
	  }
  } else {$risk_hosp_fraility = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("6", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_other = '1';
	  } else {$risk_hosp_other = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("Other", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_other = '1';
	  } else {$risk_hosp_other = '0';
	  }
  } else {$risk_hosp_other = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if (in_array("7", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_none = '1';
	  } else {$risk_hosp_none = '0';
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if (in_array("None of the above", $oasis_patient_history_risk_hospitalization)) {$risk_hosp_none = '1';
	  } else {$risk_hosp_none = '0';
	  }
  } else {$risk_hosp_none = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_patient_history_overall_status'] == 'UK') {$patient_overall_status = 'UK';
	  } else {$patient_overall_status = '0' . $row1['oasis_patient_history_overall_status'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_best_fits_patient_overall_status'] == "The patient is stable with no heightened risk(s) for serious complications and death (beyond those typical of the patients age)." || $row1['OASIS_C_best_fits_patient_overall_status'] == "The patient is stable with no heightened risk(s) for serious complications and death (beyond those typical of the patient?s age).") {$patient_overall_status = '00';
	  } else if ($row1['OASIS_C_best_fits_patient_overall_status'] == "The patient is temporarily facing high health risk(s) but is likely to return to being stable without heightened risk(s) for serious complications and death (beyond those typical of the patients age)" || $row1['OASIS_C_best_fits_patient_overall_status'] == "The patient is temporarily facing high health risk(s) but is likely to return to being stable without heightened risk(s) for serious complications and death (beyond those typical of the patient?s age)") {$patient_overall_status = '01';
	  } else if ($row1['OASIS_C_best_fits_patient_overall_status'] == "The patient is likely to remain in fragile health and have ongoing high risk(s) of serious complications and death.") {$patient_overall_status = '02';
	  } else if ($row1['OASIS_C_best_fits_patient_overall_status'] == "The patient has serious progressive conditions that could lead to death within a year.") {$patient_overall_status = '03';
	  } else if ($row1['OASIS_C_best_fits_patient_overall_status'] == "UK") {$patient_overall_status = 'UK';
	  } else {$patient_overall_status = ' ';
	  }
  } else {$patient_overall_status = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_recieved_influenza_vaccine_from_agency'] == 'NA - Does not apply because entire episode of care (SOC/ROC to Transfer/Discharge) is outside this influenza season.') {$influenza_vaccine_received_or_not = 'NA';
	  } else {$influenza_vaccine_received_or_not = '0' . $row1['OASIS_C_recieved_influenza_vaccine_from_agency'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_influenza_vaccine'] == 2) {$influenza_vaccine_received_or_not = 'NA';
	  } else {$influenza_vaccine_received_or_not = '0' . $row1['oasis_influenza_vaccine'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Influenza_Vaccine_received'] == 'No') {$influenza_vaccine_received_or_not = '00';
	  } else if ($row1['oasistransfer_Influenza_Vaccine_received'] == 'Yes') {$influenza_vaccine_received_or_not = '01';
	  } else if ($row1['oasistransfer_Influenza_Vaccine_received'] == 'NA') {$influenza_vaccine_received_or_not = "NA";
	  }
  } else {$influenza_vaccine_received_or_not = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Received from another health care provider (e.g., physician)", $OASIS_C_reason_influenza_caccine_not_received)) {$influenza_vaccine_not_received_reason = '01';
	  } else if (in_array("Received from your agency previously during this years flu season", $OASIS_C_reason_influenza_caccine_not_received)) {$influenza_vaccine_not_received_reason = '02';
	  } else if (in_array("Offered and declined", $OASIS_C_reason_influenza_caccine_not_received)) {$influenza_vaccine_not_received_reason = '03';
	  } else if (in_array("Assessed and determined to have medical contraindication(s)", $OASIS_C_reason_influenza_caccine_not_received)) {$influenza_vaccine_not_received_reason = '04';
	  } else if (in_array("Not indicated; patient does not meet age/condition guidelines for influenza vaccine", $OASIS_C_reason_influenza_caccine_not_received)) {$influenza_vaccine_not_received_reason = '05';
	  } else if (in_array("Inability to obtain vaccine due to declared shortage", $OASIS_C_reason_influenza_caccine_not_received)) {$influenza_vaccine_not_received_reason = '06';
	  } else if (in_array("None of the above", $OASIS_C_reason_influenza_caccine_not_received)) {$influenza_vaccine_not_received_reason = '07';
	  } else {$influenza_vaccine_not_received_reason = '';
	  }
  } else if ($table_name == 'forms_oasis_discharge') {$influenza_vaccine_not_received_reason = '0' . $row1['oasis_reason_influenza_vaccine'];
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Reason_For_Influenza_Vaccine_Not_Received'] == 'Received_from_another_health_care_provider') {$influenza_vaccine_not_received_reason = '01';
	  } else if ($row1['oasistransfer_Reason_For_Influenza_Vaccine_Not_Received'] == 'Received_from_your_agency_previuosly') {$influenza_vaccine_not_received_reason = '02';
	  } else if ($row1['oasistransfer_Reason_For_Influenza_Vaccine_Not_Received'] == 'Offered_and_Declined') {$influenza_vaccine_not_received_reason = '03';
	  } else if ($row1['oasistransfer_Reason_For_Influenza_Vaccine_Not_Received'] == 'Assessed_and_determined') {$influenza_vaccine_not_received_reason = '04';
	  } else if ($row1['oasistransfer_Reason_For_Influenza_Vaccine_Not_Received'] == 'Not_indicated') {$influenza_vaccine_not_received_reason = '05';
	  } else if ($row1['oasistransfer_Reason_For_Influenza_Vaccine_Not_Received'] == 'Inability_to_Obtain_Vaccine') {$influenza_vaccine_not_received_reason = '06';
	  } else if ($row1['oasistransfer_Reason_For_Influenza_Vaccine_Not_Received'] == 'None') {$influenza_vaccine_not_received_reason = '07';
	  }
  } else {$influenza_vaccine_not_received_reason = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_received_pneumococcal_vaccine_from_agency'] == 'No') {$pneumococcal_vaccine_received_or_not = 0;
	  } else if ($row1['OASIS_C_received_pneumococcal_vaccine_from_agency'] == 'Yes') {$pneumococcal_vaccine_received_or_not = 1;
	  } else {$pneumococcal_vaccine_received_or_not = '';
	  }
  } else {$pneumococcal_vaccine_received_or_not = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Patient has received PPV in the past", $OASIS_C_reason_not_received_pneumocaccal_vaccine)) {$pneumococcal_vaccine_not_received_reason = '01';
	  } else if (in_array("Offered and declined", $OASIS_C_reason_not_received_pneumocaccal_vaccine)) {$pneumococcal_vaccine_not_received_reason = '02';
	  } else if (in_array("Assessed and determined to have medical contraindication(s)", $OASIS_C_reason_not_received_pneumocaccal_vaccine)) {$pneumococcal_vaccine_not_received_reason = '03';
	  } else if (in_array("Not indicated; patient does not meet age/condition guidelines for PPV", $OASIS_C_reason_not_received_pneumocaccal_vaccine)) {$pneumococcal_vaccine_not_received_reason = '04';
	  } else if (in_array("None of the above", $OASIS_C_reason_not_received_pneumocaccal_vaccine)) {$pneumococcal_vaccine_not_received_reason = '05';
	  } else {$pneumococcal_vaccine_not_received_reason = '';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Reason_For_PPV_Not_Received'] == "Received_in_the_past") {$pneumococcal_vaccine_not_received_reason = "01";
	  } else if ($row1['oasistransfer_Reason_For_PPV_Not_Received'] == "Offered_and_declined") {$pneumococcal_vaccine_not_received_reason = "02";
	  } else if ($row1['oasistransfer_Reason_For_PPV_Not_Received'] == "Assessed_and_determined") {$pneumococcal_vaccine_not_received_reason = "03";
	  } else if ($row1['oasistransfer_Reason_For_PPV_Not_Received'] == "Not_indicated") {$pneumococcal_vaccine_not_received_reason = "04";
	  } else if ($row1['oasistransfer_Reason_For_PPV_Not_Received'] == "None") {$pneumococcal_vaccine_not_received_reason = "05";
	  }
  } else {$pneumococcal_vaccine_not_received_reason = '';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_living_arrangements_situation'] >= '10') {$patient_living_situation = $row1['oasis_living_arrangements_situation'];
	  } else {$patient_living_situation = $row1['oasis_living_arrangements_situation'];
	  }
  } else if ($table_name == 'forms_OASIS') {$patient_living_situation = $row1['living_arrangements_situation'];
  } else {$patient_living_situation = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_sensory_status_hear'] == "UK") {$ability_to_hear = "UK";
	  } else {$ability_to_hear = "0" . $row1['oasis_sensory_status_hear'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['sensory_status_hearing'] == "UK") {$ability_to_hear = "UK";
	  } else {$ability_to_hear = "0" . $row1['sensory_status_hearing'];
	  }
  } else {$ability_to_hear = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_sensory_status_understand_verbal'] == "UK") {$understand_verbal = "UK";
	  } else {$understand_verbal = "0" . $row1['oasis_sensory_status_understand_verbal'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['sensory_status_verbal_content'] == "UK") {$understand_verbal = "UK";
	  } else {$understand_verbal = "0" . $row1['sensory_status_verbal_content'];
	  }
  } else {$understand_verbal = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$formal_pain_assessment = '0' . $row1['oasis_pain_assessment_tool'];
  } else if ($table_name == 'forms_OASIS') {$formal_pain_assessment = '0' . $row1['sensory_status_pain'];
  } else {$formal_pain_assessment = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$frequency_pain = '0' . $row1['oasis_pain_frequency_interfering'];
  } else if ($table_name == 'forms_OASIS') {$frequency_pain = '0' . $row1['sensory_status_frequency_pain'];
  } else if ($table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification') {$frequency_pain = '0' . $row1['oasis_therapy_frequency_pain'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$frequency_pain = '0' . $row1['oasis_c_nurse_frequency_pain'];
  } else {$frequency_pain = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_assessed_risk_developing_pus = '0' . $row1['oasis_pressure_ulcer_assessment'];
  } else if ($table_name == 'forms_OASIS') {$patient_assessed_risk_developing_pus = '0' . $row1['integumentary_status_pressure_ulcer_assess'];
  } else {$patient_assessed_risk_developing_pus = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_have_risk_developing_pus = $row1['oasis_pressure_ulcer_risk'];
  } else if ($table_name == 'forms_OASIS') {$patient_have_risk_developing_pus = $row1['integumentary_status_risk_pressure_ulcer'];
  } else {$patient_have_risk_developing_pus = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_have_unhealed_pu = $row1['oasis_pressure_ulcer_unhealed_s2'];
  } else if ($table_name == 'forms_OASIS') {$patient_have_unhealed_pu = $row1['integumentary_status_unhealed_pressure_ulcer'];
  } else if ($table_name == 'forms_oasis_discharge') {$patient_have_unhealed_pu = $row1['oasis_therapy_integumentary_status'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_have_unhealed_pu = $row1['oasis_integumentary_status'];
  } else {$patient_have_unhealed_pu = ' ';
  }
  if ($table_name == 'forms_OASIS') {$date_onset_stage2_pressure_ulcer = $row1['integumentary_status_date_unheal_stage2'];
  } else if ($table_name == 'forms_OASIS') {$date_onset_stage2_pressure_ulcer = $row1['oasis_therapy_integumentary_status_stage2_date'];
  } else {$date_onset_stage2_pressure_ulcer = "        ";
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['integumentary_status_date_unheal_stage2_status'] == 'UK') {$status_stage2_pressure_ulcer = 'UK';
	  } else if ($row1['integumentary_status_date_unheal_stage2_status'] == 'NA') {$status_stage2_pressure_ulcer = 'NA';
	  } else {$status_stage2_pressure_ulcer = '';
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_therapy_integumentary_status_stage2'] == 1) {$status_stage2_pressure_ulcer = 'UK';
	  } else if ($row1['oasis_therapy_integumentary_status_stage2'] == 'NA') {$status_stage2_pressure_ulcer = 'NA';
	  } else {$status_stage2_pressure_ulcer = '';
	  }
  } else {$status_stage2_pressure_ulcer = '';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$no_of_stage2_pressure_ulcer = $oasis_therapy_pressure_ulcer_a[0];
  } else if ($table_name == 'forms_oasis_c_nurse') {$no_of_stage2_pressure_ulcer = $row1['oasis_c_nurse_stage2_col1'];
  } else {$no_of_stage2_pressure_ulcer = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$number_pu_stage2 = $oasis_therapy_pressure_ulcer_a[1];
  } else if ($table_name == 'forms_oasis_c_nurse') {$number_pu_stage2 = $row1['oasis_c_nurse_stage2_col2'];
  } else {$number_pu_stage2 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$no_of_stage3_pressure_ulcer = $oasis_therapy_pressure_ulcer_b[0];
  } else if ($table_name == 'forms_oasis_c_nurse') {$no_of_stage3_pressure_ulcer = $row1['oasis_c_nurse_stage3_col1'];
  } else {$no_of_stage3_pressure_ulcer = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$number_pu_stage3 = $oasis_therapy_pressure_ulcer_b[1];
  } else if ($table_name == 'forms_oasis_c_nurse') {$number_pu_stage3 = $row1['oasis_c_nurse_stage3_col2'];
  } else {$number_pu_stage3 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$no_of_stage4_pressure_ulcer = $oasis_therapy_pressure_ulcer_c[0];
  } else if ($table_name == 'forms_oasis_c_nurse') {$no_of_stage4_pressure_ulcer = $row1['oasis_c_nurse_stage4_col1'];
  } else {$no_of_stage4_pressure_ulcer = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$number_pu_stage4 = $oasis_therapy_pressure_ulcer_c[1];
  } else if ($table_name == 'forms_oasis_c_nurse') {$number_pu_stage4 = $row1['oasis_c_nurse_stage4_col2'];
  } else {$number_pu_stage4 = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$unstageable_dressing = $oasis_therapy_pressure_ulcer_d1[0];
  } else if ($table_name == 'forms_oasis_c_nurse') {$unstageable_dressing = $row1['oasis_c_nurse_non_removable_col1'];
  } else {$unstageable_dressing = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$unstageable_dressing_soc = $oasis_therapy_pressure_ulcer_d1[1];
  } else if ($table_name == 'forms_oasis_c_nurse') {$unstageable_dressing_soc = $row1['oasis_c_nurse_non_removable_col2'];
  } else {$unstageable_dressing_soc = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$unstageable_coverage = $oasis_therapy_pressure_ulcer_d2[0];
  } else if ($table_name == 'forms_oasis_c_nurse') {$unstageable_coverage = $row1['oasis_c_nurse_coverage_col1'];
  } else {$unstageable_coverage = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$unstageable_coverage_soc = $oasis_therapy_pressure_ulcer_d2[1];
  } else if ($table_name == 'forms_oasis_c_nurse') {$unstageable_coverage_soc = $row1['oasis_c_nurse_coverage_col2'];
  } else {$unstageable_coverage_soc = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$unstageable_suspected = $oasis_therapy_pressure_ulcer_d3[0];
  } else if ($table_name == 'forms_oasis_c_nurse') {$unstageable_suspected = $row1['oasis_c_nurse_suspected_col1'];
  } else {$unstageable_suspected = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_therapy_rectification' || $table_name == 'forms_oasis_pt_soc') {$unstageable_suspected_soc = $oasis_therapy_pressure_ulcer_d3[1];
  } else if ($table_name == 'forms_oasis_c_nurse') {$unstageable_suspected_soc = $row1['oasis_c_nurse_suspected_col2'];
  } else {$unstageable_suspected_soc = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$head_toe_length_stage3_pu = $row1['oasis_therapy_pressure_ulcer_length'];
  } else if ($table_name == 'forms_OASIS') {$head_toe_length_stage3_pu = $row1['integumentary_status_pressure_ulcer_length'];
  } else if ($table_name == 'forms_oasis_discharge') {$head_toe_length_stage3_pu = $row1['oasis_therapy_pressure_ulcer_length'];
  } else {$head_toe_length_stage3_pu = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$width_right_angles_stage3_pu = $row1['oasis_therapy_pressure_ulcer_width'];
  } else if ($table_name == 'forms_OASIS') {$width_right_angles_stage3_pu = $row1['integumentary_status_pressure_ulcer_width'];
  } else if ($table_name == 'forms_oasis_discharge') {$width_right_angles_stage3_pu = $row1['oasis_therapy_pressure_ulcer_width'];
  } else {$width_right_angles_stage3_pu = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$deap_stage3_pu = $row1['oasis_therapy_pressure_ulcer_depth'];
  } else if ($table_name == 'forms_OASIS') {$deap_stage3_pu = $row1['integumentary_status_pressure_ulcer_depth'];
  } else if ($table_name == 'forms_oasis_discharge') {$deap_stage3_pu = $row1['oasis_therapy_pressure_ulcer_depth'];
  } else {$deap_stage3_pu = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_therapy_pressure_ulcer_problematic_status'] == "NA") {$status_pressure_ulcer = "NA";
	  } else {$status_pressure_ulcer = "0" . $row1['oasis_therapy_pressure_ulcer_problematic_status'];
	  }
  } else if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_pt_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['integumentary_status_problematic_ulcer'] == "NA") {$status_pressure_ulcer = "NA";
	  } else {$status_pressure_ulcer = "0" . $row1['integumentary_status_problematic_ulcer'];
	  }
  } else if ($table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_therapy_pressure_ulcer_problematic_status'] == "NA") {$status_pressure_ulcer = "NA";
	  } else {$status_pressure_ulcer = "0" . $row1['oasis_therapy_pressure_ulcer_problematic_status'];
	  }
  } else {$status_pressure_ulcer = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_have_stasis_ulcer = '0' . $row1['oasis_therapy_pressure_ulcer_statis_ulcer'];
  } else if ($table_name == 'forms_OASIS') {$patient_have_stasis_ulcer = '0' . $row1['integumentary_status_statis_ulcer'];
  } else if ($table_name == 'forms_oasis_discharge') {$patient_have_stasis_ulcer = '0' . $row1['oasis_therapy_pressure_ulcer_statis_ulcer'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_have_stasis_ulcer = '0' . $row1['oasis_c_nurse_statis_ulcer'];
  } else {$patient_have_stasis_ulcer = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$no_of_stasis_ulcer = '0' . $row1['oasis_therapy_pressure_ulcer_statis_ulcer_num'];
  } else if ($table_name == 'forms_OASIS') {$no_of_stasis_ulcer = '0' . $row1['integumentary_status_current_no_statis_ulcer'];
  } else if ($table_name == 'forms_oasis_discharge') {$no_of_stasis_ulcer = '0' . $row1['oasis_therapy_pressure_ulcer_statis_ulcer_num'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$no_of_stasis_ulcer = '0' . $row1['oasis_c_nurse_current_no_statis_ulcer'];
  } else {$no_of_stasis_ulcer = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$status_stasis_ulcer = '0' . $row1['oasis_therapy_pressure_ulcer_statis_ulcer_status'];
  } else if ($table_name == 'forms_OASIS') {$status_stasis_ulcer = '0' . $row1['integumentary_status_problematic_statis_ulcer'];
  } else if ($table_name == 'forms_oasis_discharge') {$status_stasis_ulcer = '0' . $row1['oasis_therapy_pressure_ulcer_statis_ulcer_status'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$status_stasis_ulcer = '0' . $row1['oasis_c_nurse_problematic_statis_ulcer'];
  } else {$status_stasis_ulcer = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_have_surgical_wound = '0' . $row1['oasis_therapy_surgical_wound'];
  } else if ($table_name == 'forms_OASIS') {$patient_have_surgical_wound = '0' . $row1['integumentary_status_surgical_wound'];
  } else if ($table_name == 'forms_oasis_discharge') {$patient_have_surgical_wound = '0' . $row1['oasis_therapy_surgical_wound'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_have_surgical_wound = '0' . $row1['oasis_c_nurse_surgical_wound'];
  } else {$patient_have_surgical_wound = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$status_surgical_wound = '0' . $row1['oasis_therapy_status_surgical_wound'];
  } else if ($table_name == 'forms_OASIS') {$status_surgical_wound = '0' . $row1['integumentary_status_problematic_surgical_wound'];
  } else if ($table_name == 'forms_oasis_discharge') {$status_surgical_wound = '0' . $row1['oasis_therapy_status_surgical_wound'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$status_surgical_wound = '0' . $row1['oasis_c_nurse_problematic_surgical_wound'];
  } else {$status_surgical_wound = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$patient_have_skin_lesion_open_wound = $row1['oasis_therapy_skin_lesion'];
  } else if ($table_name == 'forms_OASIS') {$patient_have_skin_lesion_open_wound = $row1['integumentary_status_skin_lesion'];
  } else if ($table_name == 'forms_oasis_discharge') {$patient_have_skin_lesion_open_wound = $row1['oasis_therapy_skin_lesion'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$patient_have_skin_lesion_open_wound = $row1['oasis_c_nurse_skin_lesion'];
  } else {$patient_have_skin_lesion_open_wound = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['cardiac_status_symptoms'] == "NA") {$symptoms_heart_failure = "NA";
	  } else {$symptoms_heart_failure = "0" . $row1['cardiac_status_symptoms'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_cardiac_status_symptoms'] == "NA") {$symptoms_heart_failure = "NA";
	  } else {$symptoms_heart_failure = "0" . $row1['oasis_cardiac_status_symptoms'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Cardiac_Status'] == "patient_didnot_Exhibit_Symptoms") {$symptoms_heart_failure = '00';
	  } else if ($row1['oasistransfer_Cardiac_Status'] == "patient_Exhibited_Symptoms") {$symptoms_heart_failure = '01';
	  } else if ($row1['oasistransfer_Cardiac_Status'] == "Not_Assessed") {$symptoms_heart_failure = '02';
	  } else if ($row1['oasistransfer_Cardiac_Status'] == "NA") {$symptoms_heart_failure = "NA";
	  }
  } else {$symptoms_heart_failure = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("0", $cardiac_status_follow_up)) {$heart_failure_no_action = '1';
	  } else {$heart_failure_no_action = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Heart_Failure_FollowUp_no_Action'] == 'on') {$heart_failure_no_action = 1;
	  } else {$heart_failure_no_action = 0;
	  }
  } else {$heart_failure_no_action = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("1", $cardiac_status_follow_up)) {$heart_failure_phy_contacted = '1';
	  } else {$heart_failure_phy_contacted = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Heart_Failure_FollowUp_patient_Contacted'] == 'on') {$heart_failure_phy_contacted = 1;
	  } else {$heart_failure_phy_contacted = 0;
	  }
  } else {$heart_failure_phy_contacted = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("2", $cardiac_status_follow_up)) {$heart_failure_ER_treatment = '1';
	  } else {$heart_failure_ER_treatment = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Heart_Failure_FollowUp_Emergency_Treatment'] == 'on') {$heart_failure_ER_treatment = 1;
	  } else {$heart_failure_ER_treatment = 0;
	  }
  } else {$heart_failure_ER_treatment = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("3", $cardiac_status_follow_up)) {$heart_failure_phy_treatment = '1';
	  } else {$heart_failure_phy_treatment = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Heart_Failure_FollowUp_Implemented_treatment'] == 'on') {$heart_failure_phy_treatment = 1;
	  } else {$heart_failure_phy_treatment = 0;
	  }
  } else {$heart_failure_phy_treatment = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("4", $cardiac_status_follow_up)) {$heart_failure_patient_edu = '1';
	  } else {$heart_failure_patient_edu = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Heart_Failure_FollowUp_Patient_Education'] == 'on') {$heart_failure_patient_edu = 1;
	  } else {$heart_failure_patient_edu = 0;
	  }
  } else {$heart_failure_patient_edu = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("5", $cardiac_status_follow_up)) {$heart_failure_change_plan = '1';
	  } else {$heart_failure_change_plan = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Heart_Failure_FollowUp_change_in_carePlan_orders'] == 'on') {$heart_failure_change_plan = 1;
	  } else {$heart_failure_change_plan = 0;
	  }
  } else {$heart_failure_change_plan = '';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_nursing_resumption' || $table_name == 'forms_oasis_pt_soc') {$urinary_incontinence_occurs = '0' . $row1['oasis_elimination_status_urinary_incontinence_occur'];
  } else if ($table_name == 'forms_OASIS') {$urinary_incontinence_occurs = '0' . $row1['elimination_status_when_urinary_incontinence_occur'];
  } else if ($table_name == 'forms_oasis_discharge') {$urinary_incontinence_occurs = '0' . $row1['oasis_elimination_status_urinary_incontinence_occur'];
  } else {$urinary_incontinence_occurs = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$patient_screened_depression = '0' . $row1['oasis_neuro_depression_screening'];
  } else if ($table_name == 'forms_OASIS') {$patient_screened_depression = '0' . $row1['neuro_status_depression_screening'];
  } else {$patient_screened_depression = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_neuro_little_interest'] == "NA") {$phq2_pfizer_little_interest = "NA";
	  } else {$phq2_pfizer_little_interest = "0" . $row1['oasis_neuro_little_interest'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['neuro_status_depression_screening_little_interest'] == "NA") {$phq2_pfizer_little_interest = "NA";
	  } else {$phq2_pfizer_little_interest = "0" . $row1['neuro_status_depression_screening_little_interest'];
	  }
  } else {$phq2_pfizer_little_interest = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_neuro_feeling_down'] == "NA") {$phq2_pfizer_little_depressed = "NA";
	  } else {$phq2_pfizer_little_depressed = "0" . $row1['oasis_neuro_feeling_down'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['neuro_status_depression_screening_feeling_down'] == "NA") {$phq2_pfizer_little_depressed = "NA";
	  } else {$phq2_pfizer_little_depressed = "0" . $row1['neuro_status_depression_screening_feeling_down'];
	  }
  } else {$phq2_pfizer_little_depressed = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$current_bathing = '0' . $row1['oasis_adl_wash'];
  } else if ($table_name == 'forms_OASIS') {$current_bathing = '0' . $row1['neuro_status_depression_screening_feeling_down'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$current_bathing = '0' . $row1['oasis_c_nurse_adl_wash'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$current_bathing = '0' . $row1['oasis_therapy_adl_wash'];
  } else {$current_bathing = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$current_toileting = '0' . $row1['oasis_adl_toilet_transfer'];
  } else if ($table_name == 'forms_OASIS') {$current_toileting = '0' . $row1['adl_iadl_toilet_transfer'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$current_toileting = '0' . $row1['oasis_c_nurse_adl_toilet_transfer'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$current_toileting = '0' . $row1['oasis_therapy_adl_toilet_transfer'];
  } else {$current_toileting = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$current_toileting_hygiene = '0' . $row1['oasis_adl_toileting_hygiene'];
  } else if ($table_name == 'forms_OASIS') {$current_toileting_hygiene = '0' . $row1['adl_iadl_toilet_hygiene'];
  } else {$current_toileting_hygiene = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$current_transferring = '0' . $row1['oasis_adl_transferring'];
  } else if ($table_name == 'forms_OASIS') {$current_transferring = '0' . $row1['adl_iadl_transferring'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$current_transferring = '0' . $row1['oasis_c_nurse_adl_transferring'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$current_transferring = '0' . $row1['oasis_therapy_adl_transferring'];
  } else {$current_transferring = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$current_ambulation = '0' . $row1['oasis_adl_ambulation'];
  } else if ($table_name == 'forms_OASIS') {$current_ambulation = '0' . $row1['adl_iadl_ambulation'];
  } else if ($table_name == 'forms_oasis_c_nurse') {$current_ambulation = '0' . $row1['oasis_c_nurse_adl_ambulation'];
  } else if ($table_name == 'forms_oasis_therapy_rectification') {$current_ambulation = '0' . $row1['oasis_therapy_adl_ambulation'];
  } else {$current_ambulation = ' ';
  }
  $hipps_group_code_submitted = '';
  $item_filler11 = '';
  $hipps_version_submitted = '';
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$prior_functioning_ADL_selfcare = '0' . $row1['oasis_adl_func_self_care'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['adl_iadl_functioning_selfcare'] == 'Independent') {$prior_functioning_ADL_selfcare = '00';
	  } else if ($row1['adl_iadl_functioning_selfcare'] == 'Needed Some Help') {$prior_functioning_ADL_selfcare = '01';
	  } else if ($row1['adl_iadl_functioning_selfcare'] == 'Dependent') {$prior_functioning_ADL_selfcare = '02';
	  } else {$prior_functioning_ADL_selfcare = ' ';
	  }
  } else {$prior_functioning_ADL_selfcare = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$prior_functioning_ADL_ambulation = '0' . $row1['oasis_adl_func_ambulation'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['adl_iadl_functioning_ambulation'] == 'Independent') {$prior_functioning_ADL_selfcare = '00';
	  } else if ($row1['adl_iadl_functioning_ambulation'] == 'Needed Some Help') {$prior_functioning_ADL_selfcare = '01';
	  } else if ($row1['adl_iadl_functioning_ambulation'] == 'Dependent') {$prior_functioning_ADL_selfcare = '02';
	  } else {$prior_functioning_ADL_selfcare = ' ';
	  }
  } else {$prior_functioning_ADL_ambulation = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$prior_functioning_ADL_transfer = '0' . $row1['oasis_adl_func_transfer'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['adl_iadl_functioning_transfer'] == 'Independent') {$prior_functioning_ADL_selfcare = '00';
	  } else if ($row1['adl_iadl_functioning_transfer'] == 'Needed Some Help') {$prior_functioning_ADL_selfcare = '01';
	  } else if ($row1['adl_iadl_functioning_transfer'] == 'Dependent') {$prior_functioning_ADL_selfcare = '02';
	  } else {$prior_functioning_ADL_selfcare = ' ';
	  }
  } else {$prior_functioning_ADL_transfer = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$prior_functioning_ADL_household = '0' . $row1['oasis_adl_func_household'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['adl_iadl_functioning_household'] == 'Independent') {$prior_functioning_ADL_selfcare = '00';
	  } else if ($row1['adl_iadl_functioning_household'] == 'Needed Some Help') {$prior_functioning_ADL_selfcare = '01';
	  } else if ($row1['adl_iadl_functioning_household'] == 'Dependent') {$prior_functioning_ADL_selfcare = '02';
	  } else {$prior_functioning_ADL_selfcare = ' ';
	  }
  } else {$prior_functioning_ADL_household = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$patient_had_multifactor_risk_assessment = '0' . $row1['oasis_adl_fall_risk_assessment'];
  } else if ($table_name == 'forms_OASIS') {$patient_had_multifactor_risk_assessment = '0' . $row1['adl_iadl_risk_assessment'];
  } else {$patient_had_multifactor_risk_assessment = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_adl_drug_regimen'] == "NA") {$drug_regimen_review = "NA";
	  } else {$drug_regimen_review = "0" . $row1['oasis_adl_drug_regimen'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['medications_drug_review'] == "NA") {$drug_regimen_review = "NA";
	  } else {$drug_regimen_review = "0" . $row1['medications_drug_review'];
	  }
  } else {$drug_regimen_review = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {$medication_follow_up = $row1['oasis_adl_medication_follow_up'];
  } else if ($table_name == 'forms_OASIS') {$medication_follow_up = $row1['medications_follow_up'];
  } else {$medication_follow_up = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['medications_intervention'] == "NA") {$medication_intervention = "NA";
	  } else {$medication_intervention = "0" . $row1['medications_intervention'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_medication_intervention'] == "NA") {$medication_intervention = "NA";
	  } else {$medication_intervention = "0" . $row1['oasis_medication_intervention'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Medication_Intervention'] == "reconcillation_NotDone") {$medication_intervention = '00';
	  } else if ($row1['oasistransfer_Medication_Intervention'] == "reconcillation_Done") {$medication_intervention = '01';
	  } else if ($row1['oasistransfer_Medication_Intervention'] == "reconcillation_NA") {$medication_intervention = "NA";
	  }
  } else {$medication_intervention = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_adl_patient_caregiver'] == "NA") {$patient_high_risk_drug_education = "NA";
	  } else {$patient_high_risk_drug_education = "0" . $row1['oasis_adl_patient_caregiver'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['medications_drug_education'] == "NA") {$patient_high_risk_drug_education = "NA";
	  } else {$patient_high_risk_drug_education = "0" . $row1['medications_drug_education'];
	  }
  } else {$patient_high_risk_drug_education = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['medications_drug_education_intervention'] == "NA") {$patient_drug_education_intervention = "NA";
	  } else {$patient_drug_education_intervention = "0" . $row1['medications_drug_education_intervention'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_medication_drug_education'] == "NA") {$patient_drug_education_intervention = "NA";
	  } else {$patient_drug_education_intervention = "0" . $row1['oasis_medication_drug_education'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Drug_Education_Intervention'] == "patient_not_instructed") {$patient_drug_education_intervention = '00';
	  } else if ($row1['oasistransfer_Drug_Education_Intervention'] == "patient_instructed") {$patient_drug_education_intervention = '01';
	  } else if ($row1['oasistransfer_Drug_Education_Intervention'] == "NA") {$patient_drug_education_intervention = "NA";
	  }
  } else {$patient_drug_education_intervention = '';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_adl_management_oral_medications'] == "NA") {$current_mgmt_oral_medication = "NA";
	  } else {$current_mgmt_oral_medication = "0" . $row1['oasis_adl_management_oral_medications'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['medications_management_oral'] == "NA") {$current_mgmt_oral_medication = "NA";
	  } else {$current_mgmt_oral_medication = "0" . $row1['medications_management_oral'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_medication_oral'] == "NA") {$current_mgmt_oral_medication = "NA";
	  } else {$current_mgmt_oral_medication = "0" . $row1['oasis_medication_oral'];
	  }
  } else {$current_mgmt_oral_medication = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_adl_management_injectable_medications'] == "NA") {$current_mgmt_injectable_medications = "NA";
	  } else {$current_mgmt_injectable_medications = "0" . $row1['oasis_adl_management_injectable_medications'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['medications_management_injectable'] == "NA") {$current_mgmt_injectable_medications = "NA";
	  } else {$current_mgmt_injectable_medications = "0" . $row1['medications_management_injectable'];
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_medication_injectable'] == "NA") {$current_mgmt_injectable_medications = "NA";
	  } else {$current_mgmt_injectable_medications = "0" . $row1['oasis_medication_injectable'];
	  }
  } else if ($table_name == 'forms_oasis_c_nurse') {
	  if ($row1['oasis_c_nurse_medication'] == "NA") {$current_mgmt_injectable_medications = "NA";
	  } else {$current_mgmt_injectable_medications = "0" . $row1['oasis_c_nurse_medication'];
	  }
  } else if ($table_name == 'forms_oasis_therapy_rectification') {
	  if ($row1['oasis_therapy_medication'] == "NA") {$current_mgmt_injectable_medications = "NA";
	  } else {$current_mgmt_injectable_medications = "0" . $row1['oasis_therapy_medication'];
	  }
  } else {$current_mgmt_injectable_medications = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_adl_func_oral_med'] == "na") {$prior_med_mgmt_oral_medications = "NA";
	  } else {$prior_med_mgmt_oral_medications = "0" . $row1['oasis_adl_func_oral_med'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['medications_prior_management_oral'] == "Independent") {$prior_med_mgmt_oral_medications = "00";
	  } else if ($row1['medications_prior_management_oral'] == "Needed Some Help") {$prior_med_mgmt_oral_medications = "01";
	  } else if ($row1['medications_prior_management_oral'] == "Dependent") {$prior_med_mgmt_oral_medications = "02";
	  } else if ($row1['medications_prior_management_oral'] == "Not Applicable") {$prior_med_mgmt_oral_medications = "NA";
	  }
  } else {$prior_med_mgmt_oral_medications = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_adl_inject_med'] == "na") {$prior_med_mgmt_injectable_medications = "NA";
	  } else {$prior_med_mgmt_injectable_medications = "0" . $row1['oasis_adl_inject_med'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['medications_prior_management_oral'] == "Independent") {$prior_med_mgmt_injectable_medications = "00";
	  } else if ($row1['medications_prior_management_oral'] == "Needed Some Help") {$prior_med_mgmt_injectable_medications = "01";
	  } else if ($row1['medications_prior_management_oral'] == "Dependent") {$prior_med_mgmt_injectable_medications = "02";
	  } else if ($row1['medications_prior_management_oral'] == "Not Applicable") {$prior_med_mgmt_injectable_medications = "NA";
	  }
  } else {$prior_med_mgmt_injectable_medications = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$care_mgmt_ADL = '0' . $row1['oasis_care_adl_assistance'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['ADL_assistance1'] == "No assistance needed in this area") {$care_mgmt_ADL = '00';
	  } else if ($row1['ADL_assistance1'] == "Caregiver(s) currently provides assistance") {$care_mgmt_ADL = '01';
	  } else if ($row1['ADL_assistance1'] == "Caregiver(s) need training/ supportive services to provide assistance") {$care_mgmt_ADL = '02';
	  } else if ($row1['ADL_assistance1'] == "Caregiver(s) not likely to provide assistance") {$care_mgmt_ADL = '03';
	  } else if ($row1['ADL_assistance1'] == "Unclear if Caregiver(s) will provide assistance") {$care_mgmt_ADL = '04';
	  } else if ($row1['ADL_assistance1'] == "Assistance needed, but no Caregiver(s) available") {$care_mgmt_ADL = '05';
	  }
  } else {$care_mgmt_ADL = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$care_mgmt_IADL = '0' . $row1['oasis_care_iadl_assistance'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['ADL_assistance12'] == "No assistance needed in this area") {$care_mgmt_IADL = '00';
	  } else if ($row1['ADL_assistance12'] == "Caregiver(s) currently provides assistance") {$care_mgmt_IADL = '01';
	  } else if ($row1['ADL_assistance12'] == "Caregiver(s) need training/ supportive services to provide assistance") {$care_mgmt_IADL = '02';
	  } else if ($row1['ADL_assistance12'] == "Caregiver(s) not likely to provide assistance") {$care_mgmt_IADL = '03';
	  } else if ($row1['ADL_assistance12'] == "Unclear if Caregiver(s) will provide assistance") {$care_mgmt_IADL = '04';
	  } else if ($row1['ADL_assistance12'] == "Assistance needed, but no Caregiver(s) available") {$care_mgmt_IADL = '05';
	  }
  } else {$care_mgmt_IADL = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$care_mgmt_medication_admin = '0' . $row1['oasis_care_medication_admin'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Medication_administration'] == "No assistance needed in this area") {$care_mgmt_medication_admin = '00';
	  } else if ($row1['Medication_administration'] == "Caregiver(s) currently provides assistance") {$care_mgmt_medication_admin = '01';
	  } else if ($row1['Medication_administration'] == "Caregiver(s) need training/ supportive services to provide assistance") {$care_mgmt_medication_admin = '02';
	  } else if ($row1['Medication_administration'] == "Caregiver(s) not likely to provide assistance") {$care_mgmt_medication_admin = '03';
	  } else if ($row1['Medication_administration'] == "Unclear if Caregiver(s) will provide assistance") {$care_mgmt_medication_admin = '04';
	  } else if ($row1['Medication_administration'] == "Assistance needed, but no Caregiver(s) available") {$care_mgmt_medication_admin = '05';
	  }
  } else {$care_mgmt_medication_admin = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$care_mgmt_med_tx = '0' . $row1['oasis_care_medical_procedures'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Medical_procedures_treatments'] == "No assistance needed in this area") {$care_mgmt_med_tx = '00';
	  } else if ($row1['Medical_procedures_treatments'] == "Caregiver(s) currently provides assistance") {$care_mgmt_med_tx = '01';
	  } else if ($row1['Medical_procedures_treatments'] == "Caregiver(s) need training/ supportive services to provide assistance") {$care_mgmt_med_tx = '02';
	  } else if ($row1['Medical_procedures_treatments'] == "Caregiver(s) not likely to provide assistance") {$care_mgmt_med_tx = '03';
	  } else if ($row1['Medical_procedures_treatments'] == "Unclear if Caregiver(s) will provide assistance") {$care_mgmt_med_tx = '04';
	  } else if ($row1['Medical_procedures_treatments'] == "Assistance needed, but no Caregiver(s) available") {$care_mgmt_med_tx = '05';
	  }
  } else {$care_mgmt_med_tx = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$care_mgmt_equipment = '0' . $row1['oasis_care_management_equip'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Management_of_Equipment'] == "No assistance needed in this area") {$care_mgmt_equipment = '00';
	  } else if ($row1['Management_of_Equipment'] == "Caregiver(s) currently provides assistance") {$care_mgmt_equipment = '01';
	  } else if ($row1['Management_of_Equipment'] == "Caregiver(s) need training/ supportive services to provide assistance") {$care_mgmt_equipment = '02';
	  } else if ($row1['Management_of_Equipment'] == "Caregiver(s) not likely to provide assistance") {$care_mgmt_equipment = '03';
	  } else if ($row1['Management_of_Equipment'] == "Unclear if Caregiver(s) will provide assistance") {$care_mgmt_equipment = '04';
	  } else if ($row1['Management_of_Equipment'] == "Assistance needed, but no Caregiver(s) available") {$care_mgmt_equipment = '05';
	  }
  } else {$care_mgmt_equipment = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$care_mgmt_supervision = '0' . $row1['oasis_care_supervision_safety'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Supervision_and_safety'] == "No assistance needed in this area") {$care_mgmt_supervision = '00';
	  } else if ($row1['Supervision_and_safety'] == "Caregiver(s) currently provides assistance") {$care_mgmt_supervision = '01';
	  } else if ($row1['Supervision_and_safety'] == "Caregiver(s) need training/ supportive services to provide assistance") {$care_mgmt_supervision = '02';
	  } else if ($row1['Supervision_and_safety'] == "Caregiver(s) not likely to provide assistance") {$care_mgmt_supervision = '03';
	  } else if ($row1['Supervision_and_safety'] == "Unclear if Caregiver(s) will provide assistance") {$care_mgmt_supervision = '04';
	  } else if ($row1['Supervision_and_safety'] == "Assistance needed, but no Caregiver(s) available") {$care_mgmt_supervision = '05';
	  }
  } else {$care_mgmt_supervision = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {$care_mgmt_advocacy = '0' . $row1['oasis_care_advocacy_facilitation'];
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Advocacy_or_facilitation'] == "No assistance needed in this area") {$care_mgmt_advocacy = '00';
	  } else if ($row1['Advocacy_or_facilitation'] == "Caregiver(s) currently provides assistance") {$care_mgmt_advocacy = '01';
	  } else if ($row1['Advocacy_or_facilitation'] == "Caregiver(s) need training/ supportive services to provide assistance") {$care_mgmt_advocacy = '02';
	  } else if ($row1['Advocacy_or_facilitation'] == "Caregiver(s) not likely to provide assistance") {$care_mgmt_advocacy = '03';
	  } else if ($row1['Advocacy_or_facilitation'] == "Unclear if Caregiver(s) will provide assistance") {$care_mgmt_advocacy = '04';
	  } else if ($row1['Advocacy_or_facilitation'] == "Assistance needed, but no Caregiver(s) available") {$care_mgmt_advocacy = '05';
	  }
  } else {$care_mgmt_advocacy = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_discharge' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_how_often'] == "UK") {$how_often_ADL_IADL_assistance = "UK";
	  } else {$how_often_ADL_IADL_assistance = "0" . $row1['oasis_care_how_often'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_receive_ADL_IADL_assistance'] == "At least daily") {$how_often_ADL_IADL_assistance = '01';
	  } else if ($row1['OASIS_C_receive_ADL_IADL_assistance'] == "Three or more times per week") {$how_often_ADL_IADL_assistance = '02';
	  } else if ($row1['OASIS_C_receive_ADL_IADL_assistance'] == "One to two times per week") {$how_often_ADL_IADL_assistance = '03';
	  } else if ($row1['OASIS_C_receive_ADL_IADL_assistance'] == "Received, but less often than weekly") {$how_often_ADL_IADL_assistance = '04';
	  } else if ($row1['OASIS_C_receive_ADL_IADL_assistance'] == "No assistance received") {$how_often_ADL_IADL_assistance = '05';
	  } else if ($row1['OASIS_C_receive_ADL_IADL_assistance'] == "UK - Unknown") {$how_often_ADL_IADL_assistance = "UK";
	  }
  } else {$how_often_ADL_IADL_assistance = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_diabetic_foot_care'] == "na") {$poc_synopsis_diabetic_foot_care = "NA";
	  } else {$poc_synopsis_diabetic_foot_care = "0" . $row1['oasis_care_diabetic_foot_care'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['presence_of_skin_lesions_on_the_lower_extremities2'] == "No") {$poc_synopsis_diabetic_foot_care = '00';
	  } else if ($row1['presence_of_skin_lesions_on_the_lower_extremities2'] == "Yes") {$poc_synopsis_diabetic_foot_care = '01';
	  } else if ($row1['presence_of_skin_lesions_on_the_lower_extremities2'] == "Not Applicable") {$poc_synopsis_diabetic_foot_care = "NA";
	  }
  } else {$poc_synopsis_diabetic_foot_care = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_patient_parameter'] == "na") {$poc_synopsis_patient_specific_parameters = "NA";
	  } else {$poc_synopsis_patient_specific_parameters = "0" . $row1['oasis_care_patient_parameter'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['parameters_for_notifying_physician_of_changes_in_vital_signs'] == "No") {$poc_synopsis_patient_specific_parameters = '00';
	  } else if ($row1['parameters_for_notifying_physician_of_changes_in_vital_signs'] == "Yes") {$poc_synopsis_patient_specific_parameters = '01';
	  } else if ($row1['parameters_for_notifying_physician_of_changes_in_vital_signs'] == "Not Applicable") {$poc_synopsis_patient_specific_parameters = "NA";
	  }
  } else {$poc_synopsis_patient_specific_parameters = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_falls_prevention'] == "na") {$poc_synopsis_falls_prevention = "NA";
	  } else {$poc_synopsis_falls_prevention = "0" . $row1['oasis_care_falls_prevention'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Falls_prevention_interventions2'] == "No") {$poc_synopsis_falls_prevention = '00';
	  } else if ($row1['Falls_prevention_interventions2'] == "Yes") {$poc_synopsis_falls_prevention = '01';
	  } else if ($row1['Falls_prevention_interventions2'] == "Not Applicable") {$poc_synopsis_falls_prevention = "NA";
	  }
  } else {$poc_synopsis_falls_prevention = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_depression_intervention'] == "na") {$poc_synopsis_depression = "NA";
	  } else {$poc_synopsis_depression = "0" . $row1['oasis_care_depression_intervention'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Depression_interventions_such_as_medication_referral'] == "No") {$poc_synopsis_depression = '00';
	  } else if ($row1['Depression_interventions_such_as_medication_referral'] == "Yes") {$poc_synopsis_depression = '01';
	  } else if ($row1['Depression_interventions_such_as_medication_referral'] == "Not Applicable") {$poc_synopsis_depression = "NA";
	  }
  } else {$poc_synopsis_depression = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_intervention_monitor'] == "na") {$poc_synopsis_pain = "NA";
	  } else {$poc_synopsis_pain = "0" . $row1['oasis_care_intervention_monitor'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Interventions_to_monitor_and_mitigate'] == "No") {$poc_synopsis_pain = '00';
	  } else if ($row1['Interventions_to_monitor_and_mitigate'] == "Yes") {$poc_synopsis_pain = '01';
	  } else if ($row1['Interventions_to_monitor_and_mitigate'] == "Not Applicable") {$poc_synopsis_pain = "NA";
	  }
  } else {$poc_synopsis_pain = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_intervention_prevent'] == "na") {$poc_synopsis_PU_prevention = "NA";
	  } else {$poc_synopsis_PU_prevention = "0" . $row1['oasis_care_intervention_prevent'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['Interventions_to_prevent_pressure_ulcers'] == "No") {$poc_synopsis_PU_prevention = '00';
	  } else if ($row1['Interventions_to_prevent_pressure_ulcers'] == "Yes") {$poc_synopsis_PU_prevention = '01';
	  } else if ($row1['Interventions_to_prevent_pressure_ulcers'] == "Not Applicable") {$poc_synopsis_PU_prevention = "NA";
	  }
  } else {$poc_synopsis_PU_prevention = ' ';
  }
  if ($table_name == 'forms_oasis_nursing_soc' || $table_name == 'forms_oasis_pt_soc') {
	  if ($row1['oasis_care_pressure_ulcer'] == "na") {$poc_synopsis_PU_moist = "NA";
	  } else {$poc_synopsis_PU_moist = "0" . $row1['oasis_care_pressure_ulcer'];
	  }
  } else if ($table_name == 'forms_OASIS') {
	  if ($row1['treatment_based_on_moist_wound_healing'] == "No") {$poc_synopsis_PU_moist = '00';
	  } else if ($row1['treatment_based_on_moist_wound_healing'] == "Yes") {$poc_synopsis_PU_moist = '01';
	  } else if ($row1['treatment_based_on_moist_wound_healing'] == "Not Applicable") {$poc_synopsis_PU_moist = "NA";
	  }
  } else {$poc_synopsis_PU_moist = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['OASIS_C_emergent_Care_since_last_time_oasis'] == "No") {$emergent_care_oasis_data_collection = '00';
	  } else if ($row1['OASIS_C_emergent_Care_since_last_time_oasis'] == "Yes, used hospital emergency department WITHOUT hospital admission") {$emergent_care_oasis_data_collection = '01';
	  } else if ($row1['OASIS_C_emergent_Care_since_last_time_oasis'] == "Yes, used hospital emergency department WITH hospital admission") {$emergent_care_oasis_data_collection = '02';
	  } else if ($row1['OASIS_C_emergent_Care_since_last_time_oasis'] == "UK - Unknown") {$emergent_care_oasis_data_collection = "UK";
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_emergent_care'] == "NA") {$emergent_care_oasis_data_collection = "NA";
	  } else {$emergent_care_oasis_data_collection = "0" . $row1['oasis_emergent_care'];
	  }
  } else {$emergent_care_oasis_data_collection = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Injury caused by fall", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_injury_caused = '1';
	  } else {$emergent_care_reason_injury_caused = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Injury_caused_by_fall'] == "on") {$emergent_care_reason_injury_caused = 1;
	  } else {$emergent_care_reason_injury_caused = 0;
	  }
  } else {$emergent_care_reason_injury_caused = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Respiratory infection (e.g., pneumonia, bronchitis)", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_respiratory_infection = '1';
	  } else {$emergent_care_reason_respiratory_infection = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Respiratory_infection'] == "on") {$emergent_care_reason_respiratory_infection = 1;
	  } else {$emergent_care_reason_respiratory_infection = 0;
	  }
  } else {$emergent_care_reason_respiratory_infection = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Other respiratory problem", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_respiratory_other = '1';
	  } else {$emergent_care_reason_respiratory_other = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Other_respiratory_problem'] == "on") {$emergent_care_reason_respiratory_other = 1;
	  } else {$emergent_care_reason_respiratory_other = 0;
	  }
  } else {$emergent_care_reason_respiratory_other = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Heart failure (e.g., fluid overload)", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_heart_failure = '1';
	  } else {$emergent_care_reason_heart_failure = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Heart_failure'] == "on") {$emergent_care_reason_heart_failure = 1;
	  } else {$emergent_care_reason_heart_failure = 0;
	  }
  } else {$emergent_care_reason_heart_failure = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Cardiac dysrhythmia (irregular heartbeat)", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_cardiac_dysrhythmia = '1';
	  } else {$emergent_care_reason_cardiac_dysrhythmia = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Cardiac_dysrhythmia'] == "on") {$emergent_care_reason_cardiac_dysrhythmia = 1;
	  } else {$emergent_care_reason_cardiac_dysrhythmia = 0;
	  }
  } else {$emergent_care_reason_cardiac_dysrhythmia = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Myocardial infarction or chest pain", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_chest_pain = '1';
	  } else {$emergent_care_reason_chest_pain = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Chest_Pain'] == "on") {$emergent_care_reason_chest_pain = 1;
	  } else {$emergent_care_reason_chest_pain = 0;
	  }
  } else {$emergent_care_reason_chest_pain = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Other heart disease", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_other_heart_disease = '1';
	  } else {$emergent_care_reason_other_heart_disease = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Other_heart_disease'] == "on") {$emergent_care_reason_other_heart_disease = 1;
	  } else {$emergent_care_reason_other_heart_disease = 0;
	  }
  } else {$emergent_care_reason_other_heart_disease = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Stroke (CVA) or TIA", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_stroke = '1';
	  } else {$emergent_care_reason_stroke = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Stroke_or_TIA'] == "on") {$emergent_care_reason_stroke = 1;
	  } else {$emergent_care_reason_stroke = 0;
	  }
  } else {$emergent_care_reason_stroke = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("GI bleeding, obstruction, constipation, impaction", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_GI_bleeding = '1';
	  } else {$emergent_care_GI_bleeding = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_GI_bleeding'] == "on") {$emergent_care_GI_bleeding = 1;
	  } else {$emergent_care_GI_bleeding = 0;
	  }
  } else {$emergent_care_GI_bleeding = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Dehydration, malnutrition", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_dehydration = '1';
	  } else {$emergent_care_reason_dehydration = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Dehydration_malnutrition'] == "on") {$emergent_care_reason_dehydration = 1;
	  } else {$emergent_care_reason_dehydration = 0;
	  }
  } else {$emergent_care_reason_dehydration = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Urinary tract infection", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_urinary_track_infection = '1';
	  } else {$emergent_care_reason_urinary_track_infection = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Urinary_tract_infection'] == "on") {$emergent_care_reason_urinary_track_infection = 1;
	  } else {$emergent_care_reason_urinary_track_infection = 0;
	  }
  } else {$emergent_care_reason_urinary_track_infection = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("IV catheter-related infection or complication", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_IV_catheter = '1';
	  } else {$emergent_care_reason_IV_catheter = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_IV_catheter_Complication'] == "on") {$emergent_care_reason_IV_catheter = 1;
	  } else {$emergent_care_reason_IV_catheter = 0;
	  }
  } else {$emergent_care_reason_IV_catheter = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Wound infection or deterioration", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_wound_infection = '1';
	  } else {$emergent_care_reason_wound_infection = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Wound_infection'] == "on") {$emergent_care_reason_wound_infection = 1;
	  } else {$emergent_care_reason_wound_infection = 0;
	  }
  } else {$emergent_care_reason_wound_infection = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Uncontrolled pain", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_uncontrolled_pain = '1';
	  } else {$emergent_care_reason_uncontrolled_pain = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Uncontrolled_pain'] == "on") {$emergent_care_reason_uncontrolled_pain = 1;
	  } else {$emergent_care_reason_uncontrolled_pain = 0;
	  }
  } else {$emergent_care_reason_uncontrolled_pain = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Acute mental/behavioral health problem", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_acute_mental_health_problem = '1';
	  } else {$emergent_care_reason_acute_mental_health_problem = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Acute_health_problem'] == "on") {$emergent_care_reason_acute_mental_health_problem = 1;
	  } else {$emergent_care_reason_acute_mental_health_problem = 0;
	  }
  } else {$emergent_care_reason_acute_mental_health_problem = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Deep vein thrombosis, pulmonary embolus", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_deep_vein = '1';
	  } else {$emergent_care_reason_deep_vein = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Deep_vein_thrombosis'] == "on") {$emergent_care_reason_deep_vein = 1;
	  } else {$emergent_care_reason_deep_vein = 0;
	  }
  } else {$emergent_care_reason_deep_vein = '';
  }
  if ($table_name == 'forms_OASIS' || $table_name == 'forms_oasis_discharge') {
	  if (in_array("Other than above reasons", $OASIS_C_Reason_for_Emergent_Care)) {$emergent_care_reason_other = '1';
	  } else {$emergent_care_reason_other = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_In_Emergentcare_for_Other_Reason'] == "on") {$emergent_care_reason_other = 1;
	  } else {$emergent_care_reason_other = 0;
	  }
  } else {$emergent_care_reason_other = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['Falls_prevention_interventions1'] == "no") {$intervention_synopsis_prevention = "00";
	  } else if ($row1['Falls_prevention_interventions1'] == "yes") {$intervention_synopsis_prevention = "01";
	  } else if ($row1['Falls_prevention_interventions1'] == "not applicable") {$intervention_synopsis_prevention = "NA";
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_data_items_b'] == "na") {$intervention_synopsis_prevention = "NA";
	  } else {$intervention_synopsis_prevention = "0" . $row1['oasis_data_items_b'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Falls_prevention_Intervention'] == "No") {$intervention_synopsis_prevention = "00";
	  } else if ($row1['oasistransfer_Falls_prevention_Intervention'] == "Yes") {$intervention_synopsis_prevention = "01";
	  } else if ($row1['oasistransfer_Falls_prevention_Intervention'] == "NA") {$intervention_synopsis_prevention = "NA";
	  }
  } else {$intervention_synopsis_prevention = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['Depression_intervention'] == "no") {$intervention_synopsis_depression = "00";
	  } else if ($row1['Depression_intervention'] == "yes") {$intervention_synopsis_depression = "01";
	  } else if ($row1['Depression_intervention'] == "not applicable") {$intervention_synopsis_depression = "NA";
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_data_items_c'] == "na") {$intervention_synopsis_depression = "NA";
	  } else {$intervention_synopsis_depression = "0" . $row1['oasis_data_items_c'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Depression_intervention'] == "No") {$intervention_synopsis_depression = "00";
	  } else if ($row1['oasistransfer_Depression_intervention'] == "Yes") {$intervention_synopsis_depression = "01";
	  } else if ($row1['oasistransfer_Depression_intervention'] == "NA") {$intervention_synopsis_depression = "NA";
	  }
  } else {$intervention_synopsis_depression = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['presence_of_skin_lesions_on_the_lower_extremities2'] == "no") {$intervention_synopsis_diabetic_foot_care = "00";
	  } else if ($row1['presence_of_skin_lesions_on_the_lower_extremities2'] == "yes") {$intervention_synopsis_diabetic_foot_care = "01";
	  } else if ($row1['presence_of_skin_lesions_on_the_lower_extremities2'] == "not applicable") {$intervention_synopsis_diabetic_foot_care = "NA";
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_data_items_a'] == "na") {$intervention_synopsis_diabetic_foot_care = "NA";
	  } else {$intervention_synopsis_diabetic_foot_care = "0" . $row1['oasis_data_items_a'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Diabetic_foot_care'] == "No") {$intervention_synopsis_diabetic_foot_care = "00";
	  } else if ($row1['oasistransfer_Diabetic_foot_care'] == "Yes") {$intervention_synopsis_diabetic_foot_care = "01";
	  } else if ($row1['oasistransfer_Diabetic_foot_care'] == "NA") {$intervention_synopsis_diabetic_foot_care = "NA";
	  }
  } else {$intervention_synopsis_diabetic_foot_care = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['intervention_to_monitor_migrate'] == "no") {$intervention_synopsis_monitor_mitigate_pain = "00";
	  } else if ($row1['intervention_to_monitor_migrate'] == "yes") {$intervention_synopsis_monitor_mitigate_pain = "01";
	  } else if ($row1['intervention_to_monitor_migrate'] == "not applicable") {$intervention_synopsis_monitor_mitigate_pain = "NA";
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_data_items_d'] == "na") {$intervention_synopsis_monitor_mitigate_pain = "NA";
	  } else {$intervention_synopsis_monitor_mitigate_pain = "0" . $row1['oasis_data_items_d'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Intervention_to_monitor_pain'] == "No") {$intervention_synopsis_monitor_mitigate_pain = "00";
	  } else if ($row1['oasistransfer_Intervention_to_monitor_pain'] == "Yes") {$intervention_synopsis_monitor_mitigate_pain = "01";
	  } else if ($row1['oasistransfer_Intervention_to_monitor_pain'] == "NA") {$intervention_synopsis_monitor_mitigate_pain = "NA";
	  }
  } else {$intervention_synopsis_monitor_mitigate_pain = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['intervention_to_prevent_pressure'] == "no") {$intervention_synopsis_prevent_pressure_ulcer = "00";
	  } else if ($row1['intervention_to_prevent_pressure'] == "yes") {$intervention_synopsis_prevent_pressure_ulcer = "01";
	  } else if ($row1['intervention_to_prevent_pressure'] == "not applicable") {$intervention_synopsis_prevent_pressure_ulcer = "NA";
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_data_items_e'] == "na") {$intervention_synopsis_prevent_pressure_ulcer = "NA";
	  } else {$intervention_synopsis_prevent_pressure_ulcer = "0" . $row1['oasis_data_items_e'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Intervention_to_prevent_pressure_ulcers'] == "No") {$intervention_synopsis_prevent_pressure_ulcer = "00";
	  } else if ($row1['oasistransfer_Intervention_to_prevent_pressure_ulcers'] == "Yes") {$intervention_synopsis_prevent_pressure_ulcer = "01";
	  } else if ($row1['oasistransfer_Intervention_to_prevent_pressure_ulcers'] == "NA") {$intervention_synopsis_prevent_pressure_ulcer = "NA";
	  }
  } else {$intervention_synopsis_prevent_pressure_ulcer = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['Pressure_ulcer_treatment_based_on_principles'] == "no") {$intervention_synopsis_pressure_ulcer_treatment = "00";
	  } else if ($row1['Pressure_ulcer_treatment_based_on_principles'] == "yes") {$intervention_synopsis_pressure_ulcer_treatment = "01";
	  } else if ($row1['Pressure_ulcer_treatment_based_on_principles'] == "not applicable") {$intervention_synopsis_pressure_ulcer_treatment = "NA";
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_data_items_f'] == "na") {$intervention_synopsis_pressure_ulcer_treatment = "NA";
	  } else {$intervention_synopsis_pressure_ulcer_treatment = "0" . $row1['oasis_data_items_f'];
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Pressure_ulcer_treatment'] == "No") {$intervention_synopsis_pressure_ulcer_treatment = "00";
	  } else if ($row1['oasistransfer_Pressure_ulcer_treatment'] == "Yes") {$intervention_synopsis_pressure_ulcer_treatment = "01";
	  } else if ($row1['oasistransfer_Pressure_ulcer_treatment'] == "NA") {$intervention_synopsis_pressure_ulcer_treatment = "NA";
	  }
  } else {$intervention_synopsis_pressure_ulcer_treatment = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if ($row1['patient_after_discharge_from_your_agency'] == "Patient remained in the community (without formal assistive services)") {$discharge_disposition = "01";
	  } else if ($row1['patient_after_discharge_from_your_agency'] == "Patient remained in the community (with formal assistive services)") {$discharge_disposition = "02";
	  } else if ($row1['patient_after_discharge_from_your_agency'] == "Patient transferred to a non-institutional hospice") {$discharge_disposition = "03";
	  } else if ($row1['patient_after_discharge_from_your_agency'] == "Unknown because patient moved to a geographic location not served by this agency") {$discharge_disposition = "04";
	  } else if ($row1['patient_after_discharge_from_your_agency'] == "UK - Other unknown") {$discharge_disposition = "UK";
	  }
  } else if ($table_name == 'forms_oasis_discharge') {
	  if ($row1['oasis_discharge_disposition'] == "UK") {$discharge_disposition = "UK";
	  } else {$discharge_disposition = "0" . $row1['oasis_discharge_disposition'];
	  }
  } else {$discharge_disposition = ' ';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Injury caused by fall", $Reason_for_Hospitalization)) {$hospitalized_injury = '1';
	  } else {$hospitalized_injury = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Injury_caused_by_fall'] == "on") {$hospitalized_injury = 1;
	  } else {$hospitalized_injury = 0;
	  }
  } else {$hospitalized_injury = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Respiratory infection (e.g., pneumonia, bronchitis)", $Reason_for_Hospitalization)) {$hospitalized_respiratory = '1';
	  } else {$hospitalized_respiratory = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Respiratory_infection'] == "on") {$hospitalized_respiratory = 1;
	  } else {$hospitalized_respiratory = 0;
	  }
  } else {$hospitalized_respiratory = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Other respiratory problem", $Reason_for_Hospitalization)) {$hospitalized_other_respiratory = '1';
	  } else {$hospitalized_other_respiratory = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Other_respiratory_problem'] == "on") {$hospitalized_other_respiratory = 1;
	  } else {$hospitalized_other_respiratory = 0;
	  }
  } else {$hospitalized_other_respiratory = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Heart failure (e.g., fluid overload)", $Reason_for_Hospitalization)) {$hospitalized_heart_failure = '1';
	  } else {$hospitalized_heart_failure = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Heart_failure'] == "on") {$hospitalized_heart_failure = 1;
	  } else {$hospitalized_heart_failure = 0;
	  }
  } else {$hospitalized_heart_failure = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Cardiac dysrhythmia (irregular heartbeat)", $Reason_for_Hospitalization)) {$hospitalized_cardiac_dysrhythmia = '1';
	  } else {$hospitalized_cardiac_dysrhythmia = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Cardiac_dysrhythmia'] == "on") {$hospitalized_cardiac_dysrhythmia = 1;
	  } else {$hospitalized_cardiac_dysrhythmia = 0;
	  }
  } else {$hospitalized_cardiac_dysrhythmia = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Myocardial infarction or chest pain", $Reason_for_Hospitalization)) {$hospitalized_myocardial = '1';
	  } else {$hospitalized_myocardial = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Chest_Pain'] == "on") {$hospitalized_myocardial = 1;
	  } else {$hospitalized_myocardial = 0;
	  }
  } else {$hospitalized_myocardial = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Other heart disease", $Reason_for_Hospitalization)) {$hospitalized_other_heart_disease = '1';
	  } else {$hospitalized_other_heart_disease = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Other_heart_disease'] == "on") {$hospitalized_other_heart_disease = 1;
	  } else {$hospitalized_other_heart_disease = 0;
	  }
  } else {$hospitalized_other_heart_disease = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Stroke (CVA) or TIA", $Reason_for_Hospitalization)) {$hospitalized_stroke = '1';
	  } else {$hospitalized_stroke = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Stroke_or_TIA'] == "on") {$hospitalized_stroke = 1;
	  } else {$hospitalized_stroke = 0;
	  }
  } else {$hospitalized_stroke = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("GI bleeding, obstruction, constipation, impaction", $Reason_for_Hospitalization)) {$hospitalized_GI_bleeding = '1';
	  } else {$hospitalized_GI_bleeding = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_GI_bleeding'] == "on") {$hospitalized_GI_bleeding = 1;
	  } else {$hospitalized_GI_bleeding = 0;
	  }
  } else {$hospitalized_GI_bleeding = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Dehydration, malnutrition", $Reason_for_Hospitalization)) {$hospitalized_dehydration = '1';
	  } else {$hospitalized_dehydration = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Dehydration_malnutrition'] == "on") {$hospitalized_dehydration = 1;
	  } else {$hospitalized_dehydration = 0;
	  }
  } else {$hospitalized_dehydration = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("IV catheter-related infection or complication", $Reason_for_Hospitalization)) {$hospitalized_IV_catheter = '1';
	  } else {$hospitalized_IV_catheter = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_IV_catheter_related_infection'] == "on") {$hospitalized_IV_catheter = 1;
	  } else {$hospitalized_IV_catheter = 0;
	  }
  } else {$hospitalized_IV_catheter = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Wound infection or deterioration", $Reason_for_Hospitalization)) {$hospitalized_wound_infection = '1';
	  } else {$hospitalized_wound_infection = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Wound_infection'] == "on") {$hospitalized_wound_infection = 1;
	  } else {$hospitalized_wound_infection = 0;
	  }
  } else {$hospitalized_wound_infection = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Acute mental/behavioral health problem", $Reason_for_Hospitalization)) {$hospitalized_acute_health_problem = '1';
	  } else {$hospitalized_acute_health_problem = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Acute_health_problem'] == "on") {$hospitalized_acute_health_problem = 1;
	  } else {$hospitalized_acute_health_problem = 0;
	  }
  } else {$hospitalized_acute_health_problem = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Scheduled treatment or procedure", $Reason_for_Hospitalization)) {$hospitalized_scheduled_treatment = '1';
	  } else {$hospitalized_scheduled_treatment = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_scheduled_Treatment'] == "on") {$hospitalized_scheduled_treatment = 1;
	  } else {$hospitalized_scheduled_treatment = 0;
	  }
  } else {$hospitalized_scheduled_treatment = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("Other than above reasons", $Reason_for_Hospitalization)) {$hospitalized_other = '1';
	  } else {$hospitalized_other = '0';
	  }
  } else if ($table_name == 'forms_oasis_transfer') {
	  if ($row1['oasistransfer_Hospitalized_for_Other_Reason'] == "on") {$hospitalized_other = 1;
	  } else {$hospitalized_other = 0;
	  }
  } else {$hospitalized_other = '';
  }
  if ($table_name == 'forms_OASIS') {
	  if (in_array("UK - Reason unknown", $Reason_for_Hospitalization)) {$hospitalized_UK = '1';
	  } else {$hospitalized_UK = '0';
	  }
  } else {$hospitalized_UK = '';
  }
  $item_filler41 = '';
  $CMS_use1 = '';
  $item_filler42 = '';
  $CMS_use2 = '';
  $item_filler43 = '';
}

$B1string = $recordID . str_pad($Record_Type_code, 2) . str_pad($Assessment_lock_date, 8) . str_pad($correction_number_for_record, 2) . str_pad($document_ID_code, 8) . str_pad($OASIS_data_set_version_code, 12) . str_pad($layout_submitted_version_code, 5) . str_pad($agent_tax_id, 9) . str_pad($software_version_code, 5) . str_pad($HHA_agency_ID_code, 16) . str_pad($patient_ID_code, 14) . str_pad($state_ID_code, 2) . str_pad($state_error_count, 4) . str_pad($state_correction, 1) . str_pad($state_payment_correction_indicator, 1) . str_pad($state_key_correction_indicator, 1) . str_pad($state_deleted_record_flag, 1) . str_pad($medicare_correction, 1) . str_pad($medicare_payment_correction_indicator, 1) . str_pad($medicare_key_correction_indicator, 1) . str_pad($masking_algorithm_version_code, 20) . str_pad($control_section_filler, 7) . str_pad($CMS_certification_number, 6) . str_pad($item_filler, 15) . str_pad($branch_state, 2) . str_pad($branch_id, 10) . str_pad($patient_id, 20) . str_pad($start_of_care_date, 8) . str_pad($resumption_of_care_date, 8) . str_pad($no_resumption_of_care_date, 1) . str_pad($patient_first_name, 12) . str_pad($patient_middle_name, 1) . str_pad($patient_last_name, 18) . str_pad($patient_suffix, 3) . str_pad($patient_state_of_residence, 2) . str_pad($patient_zip_code, 11) . str_pad($medicare_number, 12) . str_pad($no_medicare_number, 1) . str_pad($ssn, 9) . str_pad($no_ssn, 1) . str_pad($medicaid_number, 14) . str_pad($no_medicaid_number, 1) . str_pad($dob, 8) . str_pad($item_filler_1, 1) . str_pad($gender, 1) . str_pad($primary_referring_physician_NPI, 10) . str_pad($primary_referring_physician_no_NPI, 1) . str_pad($discipline_of_person_completing_assessment, 2) . str_pad($date_assessment_completed, 8) . str_pad($reason_for_assessment, 2) . str_pad($race_ethnicity_american, 1) . str_pad($race_ethnicity_asian, 1) . str_pad($race_ethnicity_black, 1) . str_pad($race_ethnicity_hispanic, 1) . str_pad($race_ethnicity_hawaiian, 1) . str_pad($race_ethnicity_white, 1) . str_pad($item_filler_2, 1) . str_pad($payment_source_no, 1) . str_pad($payment_source_medicare_traditional, 1) . str_pad($payment_source_medicare, 1) . str_pad($payment_source_medicaid_traditional, 1) . str_pad($payment_source_medicaid, 1) . str_pad($payment_source_worker_compensation, 1) . str_pad($payment_source_title_programs, 1) . str_pad($payment_source_other_government, 1) . str_pad($payment_source_private_insurance, 1) . str_pad($payment_source_private_hmo, 1) . str_pad($payment_source_self, 1) . str_pad($payment_source_other, 1) . str_pad($payment_source_unknown, 1) . str_pad($item_filler_3, 6) . str_pad($item_filler_4, 5) . str_pad($recent_discharge_date, 8) . str_pad($recent_discharge_date_unknown, 1) . str_pad(diagnosisFormat($inpatient_stay_icd_code_1), 7) . str_pad(diagnosisFormat($inpatient_stay_icd_code_2), 7) . str_pad($item_filler_5, 1) . str_pad(diagnosisFormat($regimen_change_icd_code_1), 7) . str_pad(diagnosisFormat($regimen_change_icd_code_2), 7) . str_pad(diagnosisFormat($regimen_change_icd_code_3), 7) . str_pad(diagnosisFormat($regimen_change_icd_code_4), 7) . str_pad($prior_condition_urinary_incontinence, 1) . str_pad($prior_condition_indewelling, 1) . str_pad($prior_condition_intractable_pain, 1) . str_pad($prior_condition_impaired_decision_making, 1) . str_pad($prior_condition_disruptive, 1) . str_pad($prior_condition_memory_loss, 1) . str_pad($prior_condition_none, 1) . str_pad($prior_condition_no_inpatient_discharge, 1) . str_pad($prior_condition_unknown, 1) . str_pad(diagnosisFormat($primary_diagnosis_icd_code), 7) . str_pad($primary_diagnosis_severity_rating, 2) . str_pad(diagnosisFormat($other_diagnosis_1_icd_code), 7) . str_pad($other_diagnosis_1_severity_rating, 2) . str_pad(diagnosisFormat($other_diagnosis_2_icd_code), 7) . str_pad($other_diagnosis_2_severity_rating, 2) . str_pad(diagnosisFormat($other_diagnosis_3_icd_code), 7) . str_pad($other_diagnosis_3_severity_rating, 2) . str_pad(diagnosisFormat($other_diagnosis_4_icd_code), 7) . str_pad($other_diagnosis_4_severity_rating, 2) . str_pad(diagnosisFormat($other_diagnosis_5_icd_code), 7) . str_pad($other_diagnosis_5_severity_rating, 2) . str_pad($therapies_received_intravenous, 1) . str_pad($therapies_received_parenteral, 1) . str_pad($therapies_received_enternal, 1) . str_pad($therapies_received_none, 1) . str_pad($item_filler_6, 6) . str_pad($high_risk_factor_smoking, 1) . str_pad($high_risk_factor_obesity, 1) . str_pad($high_risk_factor_alcoholism, 1) . str_pad($high_risk_factor_drugs, 1) . str_pad($high_risk_factor_none, 1) . str_pad($high_risk_factor_unknown, 1) . str_pad($item_filler19, 2) . str_pad($item_filler4, 5) . str_pad($item_filler5, 12) . str_pad($item_filler6, 13) . str_pad($item_filler17, 23) . str_pad($sensory_status_vision, 2) . str_pad($item_filler18, 2) . str_pad($sensory_status_speech, 2) . str_pad($item_filler19, 5) . str_pad($number_pressure_ulcers, 2) . str_pad($item_filler20, 7) . str_pad($stage_pressure_ulcer, 2) . str_pad($item_filler22, 14) . str_pad($when_dyspenic, 2) . str_pad($resp_treatments_oxygen, 1) . str_pad($resp_treatments_ventilator, 1) . str_pad($resp_treatments_airway, 1) . str_pad($resp_treatments_none, 1) . str_pad($treated_for_urinary_tract_infection, 2) . str_pad($urinary_incontinence, 2) . str_pad($item_filler21, 2) . str_pad($bowel_incontinence_frequency, 2) . str_pad($ostomy_for_bowel_elimination, 2) . str_pad($cognitive_functioning, 2) . str_pad($when_confused, 2) . str_pad($when_anxious, 2) . str_pad($item_filler23, 6) . str_pad($item_filler7, 7) . str_pad($behaviour_memory_deficit, 1) . str_pad($behaviour_impaired, 1) . str_pad($behaviour_verbal_disruption, 1) . str_pad($behaviour_physically_aggression, 1) . str_pad($behaviour_socially_inappropriate, 1) . str_pad($behaviour_delusions, 1) . str_pad($behaviour_none, 1) . str_pad($frequency_of_behaviour_problems, 2) . str_pad($receives_psychiatric_nursing, 1) . str_pad($item_filler24, 2) . str_pad($current_grooming, 2) . str_pad($item_filler25, 2) . str_pad($current_dress_upper_body, 2) . str_pad($item_filler26, 2) . str_pad($current_dress_lower_body, 2) . str_pad($item_filler27, 18) . str_pad($current_feeding, 2) . str_pad($item_filler28, 2) . str_pad($current_prepare_light_meals, 2) . str_pad($item_filler29, 18) . str_pad($current_telephone_use, 2) . str_pad($item_filler30, 21) . str_pad($emergency_care_reason_medication, 1) . str_pad($item_filler31, 5) . str_pad($emergency_care_reason_hypoglycemia, 1) . str_pad($item_filler32, 2) . str_pad($emergency_care_reason_unknown, 1) . str_pad($inpatient_facility, 2) . str_pad($item_filler33, 7) . str_pad($hospitalized_medication, 1) . str_pad($item_filler34, 3) . str_pad($hospitalized_hypoglycemia, 1) . str_pad($item_filler35, 5) . str_pad($hospitalized_urinary_tract, 1) . str_pad($item_filler36, 1) . str_pad($hospitalized_deep_vein, 1) . str_pad($hospitalized_pain, 1) . str_pad($item_filler37, 2) . str_pad($adimitted_to_nursing_home_therapy, 1) . str_pad($adimitted_to_nursing_home_respite, 1) . str_pad($adimitted_to_nursing_home_hospice, 1) . str_pad($adimitted_to_nursing_home_permanent, 1) . str_pad($adimitted_to_nursing_home_unsafe, 1) . str_pad($adimitted_to_nursing_home_other, 1) . str_pad($adimitted_to_nursing_home_unknown, 1) . str_pad($last_home_visit_date, 8) . str_pad($discharge_transfer_death_date, 8) . str_pad($item_filler8, 2) . str_pad($item_filler9, 2) . str_pad($item_filler38, 2) . str_pad($discharged_skilled_nursing_facility, 1) . str_pad($item_filler39, 2) . str_pad($not_discharged_skilled_nursing_facility, 1) . str_pad($item_filler10, 14) . str_pad($NPI, 10) . str_pad($episode_timing, 2) . str_pad(diagnosisFormat($case_mix_diag_primary_col3), 7) . str_pad(diagnosisFormat($case_mix_diag_1_secondary_col3), 7) . str_pad(diagnosisFormat($case_mix_diag_2_secondary_col3), 7) . str_pad(diagnosisFormat($case_mix_diag_3_secondary_col3), 7) . str_pad(diagnosisFormat($case_mix_diag_4_secondary_col3), 7) . str_pad(diagnosisFormat($case_mix_diag_5_secondary_col3), 7) . str_pad(diagnosisFormat($case_mix_diag_primary_col4), 7) . str_pad(diagnosisFormat($case_mix_diag_1_secondary_col4), 7) . str_pad(diagnosisFormat($case_mix_diag_2_secondary_col4), 7) . str_pad(diagnosisFormat($case_mix_diag_3_secondary_col4), 7) . str_pad(diagnosisFormat($case_mix_diag_4_secondary_col4), 7) . str_pad(diagnosisFormat($case_mix_diag_5_secondary_col4), 7) . str_pad($therapy_need_no_of_visits, 3) . str_pad($therapy_need_NA, 1) . str_pad($item_filler40, 1) . str_pad($phy_ordered_SOC_ROC_date, 8) . str_pad($phy_ordered_SOC_ROC_date_NA, 1) . str_pad($phy_date_of_referral, 8) . str_pad($discharge_ltc_nh, 1) . str_pad($discharge_short_stay, 1) . str_pad($discharge_long_term, 1) . str_pad($discharge_inpatient_rehab_facility, 1) . str_pad($discharge_psychiatric_unit, 1) . str_pad($discharge_other, 1) . str_pad(diagnosisFormat($inpatient_icd_code3), 7) . str_pad(diagnosisFormat($inpatient_icd_code4), 7) . str_pad(diagnosisFormat($inpatient_icd_code5), 7) . str_pad(diagnosisFormat($inpatient_icd_code6), 7) . str_pad(diagnosisFormat($inpatient_icd_pro_code1), 7) . str_pad(diagnosisFormat($inpatient_icd_pro_code2), 7) . str_pad(diagnosisFormat($inpatient_icd_pro_code3), 7) . str_pad(diagnosisFormat($inpatient_icd_pro_code4), 7) . str_pad($inpatient_icd_pro_code_NA, 1) . str_pad($inpatient_icd_pro_code_UK, 1) . str_pad(diagnosisFormat($regimen_icd_code5), 7) . str_pad(diagnosisFormat($regimen_icd_code6), 7) . str_pad($regimen_NA, 1) . str_pad($risk_hosp_recent, 1) . str_pad($risk_hosp_multiple, 1) . str_pad($risk_hosp_medications, 1) . str_pad($risk_hosp_history, 1) . str_pad($risk_hosp_fraility, 1) . str_pad($risk_hosp_other, 1) . str_pad($risk_hosp_none, 1) . str_pad($patient_overall_status, 2) . str_pad($influenza_vaccine_received_or_not, 2) . str_pad($influenza_vaccine_not_received_reason, 2) . str_pad($pneumococcal_vaccine_received_or_not, 2) . str_pad($pneumococcal_vaccine_not_received_reason, 2) . str_pad($patient_living_situation, 2) . str_pad($ability_to_hear, 2) . str_pad($understand_verbal, 2) . str_pad($formal_pain_assessment, 2) . str_pad($frequency_pain, 2) . str_pad($patient_assessed_risk_developing_pus, 2) . str_pad($patient_have_risk_developing_pus, 1) . str_pad($patient_have_unhealed_pu, 1) . str_pad($date_onset_stage2_pressure_ulcer, 8) . str_pad($status_stage2_pressure_ulcer, 2) . str_pad($no_of_stage2_pressure_ulcer, 2) . str_pad($number_pu_stage2, 2) . str_pad($no_of_stage3_pressure_ulcer, 2) . str_pad($number_pu_stage3, 2) . str_pad($no_of_stage4_pressure_ulcer, 2) . str_pad($number_pu_stage4, 2) . str_pad($unstageable_dressing, 2) . str_pad($unstageable_dressing_soc, 2) . str_pad($unstageable_coverage, 2) . str_pad($unstageable_coverage_soc, 2) . str_pad($unstageable_suspected, 2) . str_pad($unstageable_suspected_soc, 2) . str_pad($head_toe_length_stage3_pu, 4) . str_pad($width_right_angles_stage3_pu, 4) . str_pad($depth_stage3_pu, 4) . str_pad($status_pressure_ulcer, 2) . str_pad($patient_have_stasis_ulcer, 2) . str_pad($no_of_stasis_ulcer, 2) . str_pad($status_stasis_ulcer, 2) . str_pad($patient_have_surgical_wound, 2) . str_pad($status_surgical_wound, 2) . str_pad($patient_have_skin_lesion_open_wound, 1) . str_pad($symptoms_heart_failure, 2) . str_pad($heart_failure_no_action, 1) . str_pad($heart_failure_phy_contacted, 1) . str_pad($heart_failure_ER_treatment, 1) . str_pad($heart_failure_phy_treatment, 1) . str_pad($heart_failure_patient_edu, 1) . str_pad($heart_failure_change_plan, 1) . str_pad($urinary_incontinence_occurs, 2) . str_pad($patient_screened_depression, 2) . str_pad($phq2_pfizer_little_interest, 2) . str_pad($phq2_pfizer_little_depressed, 2) . str_pad($current_bathing, 2) . str_pad($current_toileting, 2) . str_pad($current_toileting_hygiene, 2) . str_pad($current_transferring, 2) . str_pad($current_ambulation, 2) . str_pad($hipps_group_code_submitted, 5) . str_pad($item_filler11, 5) . str_pad($hipps_version_submitted, 5) . str_pad($prior_functioning_ADL_selfcare, 2) . str_pad($prior_functioning_ADL_ambulation, 2) . str_pad($prior_functioning_ADL_transfer, 2) . str_pad($prior_functioning_ADL_household, 2) . str_pad($patient_had_multifactor_risk_assessment, 2) . str_pad($drug_regimen_review, 2) . str_pad($medication_follow_up, 1) . str_pad($medication_intervention, 2) . str_pad($patient_high_risk_drug_education, 2) . str_pad($patient_drug_education_intervention, 2) . str_pad($current_mgmt_oral_medication, 2) . str_pad($current_mgmt_injectable_medications, 2) . str_pad($prior_med_mgmt_oral_medications, 2) . str_pad($prior_med_mgmt_injectable_medications, 2) . str_pad($care_mgmt_ADL, 2) . str_pad($care_mgmt_IADL, 2) . str_pad($care_mgmt_medication_admin, 2) . str_pad($care_mgmt_med_tx, 2) . str_pad($care_mgmt_equipment, 2) . str_pad($care_mgmt_supervision, 2) . str_pad($care_mgmt_advocacy, 2) . str_pad($how_often_ADL_IADL_assistance, 2) . str_pad($poc_synopsis_diabetic_foot_care, 2) . str_pad($poc_synopsis_patient_specific_parameters, 2) . str_pad($poc_synopsis_falls_prevention, 2) . str_pad($poc_synopsis_depression, 2) . str_pad($poc_synopsis_pain, 2) . str_pad($poc_synopsis_PU_prevention, 2) . str_pad($poc_synopsis_PU_moist, 2) . str_pad($emergent_care_oasis_data_collection, 2) . str_pad($emergent_care_reason_injury_caused, 1) . str_pad($emergent_care_reason_respiratory_infection, 1) . str_pad($emergent_care_reason_respiratory_other, 1) . str_pad($emergent_care_reason_heart_failure, 1) . str_pad($emergent_care_reason_cardiac_dysrhythmia, 1) . str_pad($emergent_care_reason_chest_pain, 1) . str_pad($emergent_care_reason_other_heart_disease, 1) . str_pad($emergent_care_reason_stroke, 1) . str_pad($emergent_care_GI_bleeding, 1) . str_pad($emergent_care_reason_dehydration, 1) . str_pad($emergent_care_reason_urinary_track_infection, 1) . str_pad($emergent_care_reason_IV_catheter, 1) . str_pad($emergent_care_reason_wound_infection, 1) . str_pad($emergent_care_reason_uncontrolled_pain, 1) . str_pad($emergent_care_reason_acute_mental_health_problem, 1) . str_pad($emergent_care_reason_deep_vein, 1) . str_pad($emergent_care_reason_other, 1) . str_pad($intervention_synopsis_prevention, 2) . str_pad($intervention_synopsis_depression, 2) . str_pad($intervention_synopsis_diabetic_foot_care, 2) . str_pad($intervention_synopsis_monitor_mitigate_pain, 2) . str_pad($intervention_synopsis_prevent_pressure_ulcer, 2) . str_pad($intervention_synopsis_pressure_ulcer_treatment, 2) . str_pad($discharge_disposition, 2) . str_pad($hospitalized_injury, 1) . str_pad($hospitalized_respiratory, 1) . str_pad($hospitalized_other_respiratory, 1) . str_pad($hospitalized_heart_failure, 1) . str_pad($hospitalized_cardiac_dysrhythmia, 1) . str_pad($hospitalized_myocardial, 1) . str_pad($hospitalized_other_heart_disease, 1) . str_pad($hospitalized_stroke, 1) . str_pad($hospitalized_GI_bleeding, 1) . str_pad($hospitalized_dehydration, 1) . str_pad($hospitalized_IV_catheter, 1) . str_pad($hospitalized_wound_infection, 1) . str_pad($hospitalized_acute_health_problem, 1) . str_pad($hospitalized_scheduled_treatment, 1) . str_pad($hospitalized_other, 1) . str_pad($hospitalized_UK, 1) . str_pad($item_filler41, 137) . str_pad($CMS_use1, 52) . str_pad($item_filler42, 6) . str_pad($CMS_use2, 46) . str_pad($item_filler43, 3) . "%";

//$myFile = '/tmp/B1_'.date('YmdHis').'.txt';
//$fh = fopen($myFile, 'w') or die("can't open file");
//fwrite($fh, $B1string); echo $myFile;
$b1_string = $B1string;
//echo $b1_string;
//header('Content-disposition: attachment; filename=B1string.txt');
//header('Content-type: text/plain');
//fclose($fh);
?>
