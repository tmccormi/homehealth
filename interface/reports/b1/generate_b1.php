<?php
ini_set("display_errors","0");
$result1=mysql_query("select * from $table_name where id='$form_id'");
while($row1=mysql_fetch_array($result1))
{
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_race_ethnicity = explode("#",$row1['oasis_patient_race_ethnicity']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_payment_source_homecare = explode("#",$row1['oasis_patient_payment_source_homecare']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_history_if_code = explode("#",$row1['oasis_patient_history_if_code']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_history_mrd_code = explode("#",$row1['oasis_patient_history_mrd_code']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_history_regimen_change = explode("#",$row1['oasis_patient_history_regimen_change']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_history_therapies = explode("#",$row1['oasis_patient_history_therapies']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_history_risk_factors = explode("#",$row1['oasis_patient_history_risk_factors']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_therapy_respiratory_treatment = explode("#",$row1['oasis_therapy_respiratory_treatment']);}
if($table_name=='forms_oasis_nursing_soc'){$oasis_neuro_cognitive_symptoms = explode("#",$row1['oasis_neuro_cognitive_symptoms']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_history_ip_code = explode("#",$row1['oasis_patient_history_ip_code']);}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$oasis_patient_history_risk_hospitalization = explode("#",$row1['oasis_patient_history_risk_hospitalization']);}
if($table_name=='forms_oasis_nursing_soc'){$oasis_therapy_pressure_ulcer_a = explode("#",$row1['oasis_therapy_pressure_ulcer_a']);}


$recordID='B1';
$correction_number_for_record='00';
$OASIS_data_set_version_code='C-072009';
$layout_submitted_version_code=02.00;
$patient_id=$row1['pid'];
$CMS_certification_number='123456';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$start_of_care_date=str_replace('-','',$row1['oasis_patient_soc_date']);}else{date("Ymd");}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$resumption_of_care_date=str_replace('-','',$row1['oasis_patient_resumption_care_date']);}else{date("Ymd");}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_resumption_care_date_na']=='N/A'){$no_resumption_of_care_date=1;}else{$no_resumption_of_care_date=0;}}else{date("Ymd");}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_first_name=$row1['oasis_patient_patient_name_first'];}else{$patient_first_name=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_middle_name=$row1['oasis_patient_patient_name_mi'];}else{$patient_middle_name=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_last_name=$row1['oasis_patient_patient_name_last'];}else{$patient_last_name=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_suffix=$row1['oasis_patient_patient_name_suffix'];}else{$patient_suffix=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_state_of_residence=$row1['oasis_patient_patient_state'];}else{$patient_state_of_residence=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_zip_code=$row1['oasis_patient_patient_zip'];}else{$patient_zip_code=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$medicare_number=$row1['oasis_patient_medicare_no'];}else{$medicare_number=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_medicare_no_na']=='N/A'){$no_medicare_number=1;}else{$no_medicare_number=0;}}else{$no_medicare_number=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$ssn=$row1['oasis_patient_ssn'];}else{$ssn=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_ssn_na']=='UK'){$no_ssn=1;}else{$no_ssn=0;}}else{$no_ssn=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$medicaid_number=$row1['oasis_patient_medicaid_no'];}else{$medicaid_number=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_medicaid_no_na']=='N/A'){$no_medicaid_number=1;}else{$no_medicaid_number=0;}}else{$no_medicaid_number=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$dob=str_replace('-','',$row1['oasis_patient_birth_date']);}else{date("Ymd");}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_patient_gender']=='male'){$gender='M';}else{$gender='F';}}else{$gender=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$primary_referring_physician_NPI=$row1['oasis_patient_referring_physician_id'];}else{$primary_referring_physician_NPI=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_referring_physician_id_na']=='N/A'){$primary_referring_physician_no_NPI=1;}else{$primary_referring_physician_no_NPI=0;}}else{$primary_referring_physician_no_NPI=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$discipline_of_person_completing_assessment='0'.$row1['oasis_patient_discipline_person'];}else{$discipline_of_person_completing_assessment=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$date_assessment_completed=str_replace('-','',$row1['oasis_patient_date_assessment_completed']);}else{date("Ymd");}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$reason_for_assessment=$row1['oasis_patient_follow_up'];}else{$reason_for_assessment='01';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("1",$oasis_patient_race_ethnicity)){$race_ethnicity_american='1';}else{$race_ethnicity_american='0';}}else{$race_ethnicity_american=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("2",$oasis_patient_race_ethnicity)){$race_ethnicity_asian='1';}else{$race_ethnicity_asian='0';}}else{$race_ethnicity_asian=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("3",$oasis_patient_race_ethnicity)){$race_ethnicity_black='1';}else{$race_ethnicity_black='0';}}else{$race_ethnicity_black=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("4",$oasis_patient_race_ethnicity)){$race_ethnicity_hispanic='1';}else{$race_ethnicity_hispanic='0';}}else{$race_ethnicity_hispanic=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("5",$oasis_patient_race_ethnicity)){$race_ethnicity_hawaiian='1';}else{$race_ethnicity_hawaiian='0';}}else{$race_ethnicity_hawaiian=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("6",$oasis_patient_race_ethnicity)){$race_ethnicity_white='1';}else{$race_ethnicity_white='0';}}else{$race_ethnicity_white=' ';}
$item_filler_2='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("0",$oasis_patient_payment_source_homecare)){$payment_source_no='1';}else{$payment_source_no='0';}}else{$payment_source_no='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("2",$oasis_patient_payment_source_homecare)){$payment_source_medicare='1';}else{$payment_source_medicare='0';}}else{$payment_source_medicare='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("3",$oasis_patient_payment_source_homecare)){$payment_source_medicaid_traditional='1';}else{$payment_source_medicaid_traditional='0';}}else{$payment_source_medicaid_traditional='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("4",$oasis_patient_payment_source_homecare)){$payment_source_medicaid='1';}else{$payment_source_medicaid='0';}}else{$payment_source_medicaid='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("5",$oasis_patient_payment_source_homecare)){$payment_source_worker_compensation='1';}else{$payment_source_worker_compensation='0';}}else{$payment_source_worker_compensation='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("6",$oasis_patient_payment_source_homecare)){$payment_source_title_programs='1';}else{$payment_source_title_programs='0';}}else{$payment_source_title_programs='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("7",$oasis_patient_payment_source_homecare)){$payment_source_other_government='1';}else{$payment_source_other_government='0';}}else{$payment_source_other_government='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("8",$oasis_patient_payment_source_homecare)){$payment_source_private_insurance='1';}else{$payment_source_private_insurance='0';}}else{$payment_source_private_insurance='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("9",$oasis_patient_payment_source_homecare)){$payment_source_private_hmo='1';}else{$payment_source_private_hmo='0';}}else{$payment_source_private_hmo='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("11",$oasis_patient_payment_source_homecare)){$payment_source_other='1';}else{$payment_source_other='0';}}else{$payment_source_other='0';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("UK",$oasis_patient_payment_source_homecare)){$payment_source_unknown='1';}else{$payment_source_unknown='0';}}else{$payment_source_unknown='0';}
$item_filler_3='';
$item_filler_4='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$recent_discharge_date=str_replace('-','',$row1['oasis_patient_history_discharge_date']);}else{date("Ymd");}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_history_discharge_date_na']=='UK'){$recent_discharge_date_unknown='1';}else{$recent_discharge_date_unknown='0';}}else{$recent_discharge_date_unknown=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_stay_icd_code_1=$oasis_patient_history_if_code[0];}else{$inpatient_stay_icd_code_1=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_stay_icd_code_2=$oasis_patient_history_if_code[1];}else{$inpatient_stay_icd_code_2=' ';}
$item_filler_5='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$regimen_change_icd_code_1=$oasis_patient_history_mrd_code[0];}else{$regimen_change_icd_code_1=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$regimen_change_icd_code_2=$oasis_patient_history_mrd_code[1];}else{$regimen_change_icd_code_2=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$regimen_change_icd_code_3=$oasis_patient_history_mrd_code[2];}else{$regimen_change_icd_code_3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$regimen_change_icd_code_4=$oasis_patient_history_mrd_code[3];}else{$regimen_change_icd_code_4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("1",$oasis_patient_history_regimen_change)){$prior_condition_urinary_incontinence='1';}else{$prior_condition_urinary_incontinence='0';}}else{$prior_condition_urinary_incontinence=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("2",$oasis_patient_history_regimen_change)){$prior_condition_indewelling='1';}else{$prior_condition_indewelling='0';}}else{$prior_condition_indewelling=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("3",$oasis_patient_history_regimen_change)){$prior_condition_intractable_pain='1';}else{$prior_condition_intractable_pain='0';}}else{$prior_condition_intractable_pain=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("4",$oasis_patient_history_regimen_change)){$prior_condition_impaired_decision_making='1';}else{$prior_condition_urinary_incontinence='0';}}else{$prior_condition_urinary_incontinence=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("5",$oasis_patient_history_regimen_change)){$prior_condition_disruptive='1';}else{$prior_condition_disruptive='0';}}else{$prior_condition_disruptive=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("6",$oasis_patient_history_regimen_change)){$prior_condition_memory_loss='1';}else{$prior_condition_memory_loss='0';}}else{$prior_condition_memory_loss=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("7",$oasis_patient_history_regimen_change)){$prior_condition_none='1';}else{$prior_condition_none='0';}}else{$prior_condition_none=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("NA",$oasis_patient_history_regimen_change)){$prior_condition_no_inpatient_discharge='1';}else{$prior_condition_no_inpatient_discharge='0';}}else{$prior_condition_no_inpatient_discharge=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("UK",$oasis_patient_history_regimen_change)){$prior_condition_unknown='1';}else{$prior_condition_unknown='0';}}else{$prior_condition_unknown=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$primary_diagnosis_icd_code=$row1['oasis_therapy_patient_diagnosis_2a'];}else{$primary_diagnosis_icd_code=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$primary_diagnosis_severity_rating='0'.$row1['oasis_therapy_patient_diagnosis_2a_sub'];}else{$primary_diagnosis_severity_rating=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_1_icd_code=$row1['oasis_therapy_patient_diagnosis_2b'];}else{$other_diagnosis_1_icd_code=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_1_severity_rating='0'.$row1['oasis_therapy_patient_diagnosis_2b_sub'];}else{$other_diagnosis_1_severity_rating=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_2_icd_code=$row1['oasis_therapy_patient_diagnosis_2c'];}else{$other_diagnosis_2_icd_code=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_2_severity_rating='0'.$row1['oasis_therapy_patient_diagnosis_2c_sub'];}else{$other_diagnosis_2_severity_rating=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_3_icd_code=$row1['oasis_therapy_patient_diagnosis_2d'];}else{$other_diagnosis_3_icd_code=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_3_severity_rating='0'.$row1['oasis_therapy_patient_diagnosis_2d_sub'];}else{$other_diagnosis_3_severity_rating=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_4_icd_code=$row1['oasis_therapy_patient_diagnosis_2e'];}else{$other_diagnosis_4_icd_code=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_4_severity_rating='0'.$row1['oasis_therapy_patient_diagnosis_2e_sub'];}else{$other_diagnosis_4_severity_rating=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_5_icd_code=$row1['oasis_therapy_patient_diagnosis_2f'];}else{$other_diagnosis_5_icd_code=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$other_diagnosis_5_severity_rating='0'.$row1['oasis_therapy_patient_diagnosis_2f_sub'];}else{$other_diagnosis_5_severity_rating=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("1",$oasis_patient_history_therapies)){$therapies_received_intravenous='1';}else{$therapies_received_intravenous='0';}}else{$therapies_received_intravenous=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("2",$oasis_patient_history_therapies)){$therapies_received_parenteral='1';}else{$therapies_received_parenteral='0';}}else{$therapies_received_parenteral=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("3",$oasis_patient_history_therapies)){$therapies_received_enternal='1';}else{$therapies_received_enternal='0';}}else{$therapies_received_enternal=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("4",$oasis_patient_history_therapies)){$therapies_received_none='1';}else{$therapies_received_none='0';}}else{$therapies_received_none=' ';}
$item_filler_6='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("1",$oasis_patient_history_risk_factors)){$high_risk_factor_smoking='1';}else{$high_risk_factor_smoking='0';}}else{$high_risk_factor_smoking=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("2",$oasis_patient_history_risk_factors)){$high_risk_factor_obesity='1';}else{$high_risk_factor_obesity='0';}}else{$high_risk_factor_obesity=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("3",$oasis_patient_history_risk_factors)){$high_risk_factor_alcoholism='1';}else{$high_risk_factor_alcoholism='0';}}else{$high_risk_factor_alcoholism=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("4",$oasis_patient_history_risk_factors)){$high_risk_factor_drugs='1';}else{$high_risk_factor_drugs='0';}}else{$high_risk_factor_drugs=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("5",$oasis_patient_history_risk_factors)){$high_risk_factor_none='1';}else{$high_risk_factor_none='0';}}else{$high_risk_factor_none=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("UK",$oasis_patient_history_risk_factors)){$high_risk_factor_unknown='1';}else{$high_risk_factor_unknown='0';}}else{$high_risk_factor_unknown=' ';}
$item_filler16='';
$item_filler4='';
$item_filler5='';
$item_filler17='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$sensory_status_vision='0'.$row1['oasis_sensory_status_vision'];}else{$sensory_status_vision=' ';}
$item_filler18='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$sensory_status_speech='0'.$row1['oasis_sensory_status_speech'];}else{$sensory_status_speech=' ';}
$item_filler19='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$number_pressure_ulcers='0'.$row1['oasis_therapy_pressure_ulcer_current_no'];}else{$number_pressure_ulcers=' ';}
$item_filler20='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_therapy_pressure_ulcer_stage_unhealed']=="NA"){$stage_pressure_ulcer="NA";}else{$stage_pressure_ulcer="0".$row1['oasis_therapy_pressure_ulcer_stage_unhealed'];}}else{$stage_pressure_ulcer=' ';}
$item_filler22='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$when_dyspenic='0'.$row1['oasis_therapy_respiratory_status'];}else{$when_dyspenic=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("1",$oasis_therapy_respiratory_treatment)){$resp_treatments_oxygen='1';}else{$resp_treatments_oxygen='0';}}else{$resp_treatments_oxygen=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("2",$oasis_therapy_respiratory_treatment)){$resp_treatments_ventilator='1';}else{$resp_treatments_ventilator='0';}}else{$resp_treatments_ventilator=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("3",$oasis_therapy_respiratory_treatment)){$resp_treatments_airway='1';}else{$resp_treatments_airway='0';}}else{$resp_treatments_airway=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("4",$oasis_therapy_respiratory_treatment)){$resp_treatments_none='1';}else{$resp_treatments_none='0';}}else{$resp_treatments_none=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_elimination_status_tract_infection']=="NA"||$row1['oasis_elimination_status_tract_infection']=="UK"){$treated_for_urinary_tract_infection=$row1['oasis_elimination_status_tract_infection'];}else{$treated_for_urinary_tract_infection="0".$row1['oasis_elimination_status_tract_infection'];}}else{$treated_for_urinary_tract_infection=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$urinary_incontinence='0'.$row1['oasis_elimination_status_urinary_incontinence'];}else{$urinary_incontinence=' ';}
$item_filler21='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_elimination_status_bowel_incontinence']=="NA"||$row1['oasis_elimination_status_bowel_incontinence']=="UK"){$bowel_incontinence_frequency=$row1['oasis_elimination_status_bowel_incontinence'];}else{$bowel_incontinence_frequency="0".$row1['oasis_elimination_status_bowel_incontinence'];}}else{$bowel_incontinence_frequency=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$ostomy_for_bowel_elimination='0'.$row1['oasis_elimination_status_ostomy_bowel'];}else{$ostomy_for_bowel_elimination=' ';}
if($table_name=='forms_oasis_nursing_soc'){$cognitive_functioning='0'.$row1['oasis_neuro_cognitive_functioning'];}else{$cognitive_functioning=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_neuro_when_confused']=="NA"){$when_confused="NA";}else{$when_confused="0".$row1['oasis_neuro_when_confused'];}}else{$when_confused=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_neuro_when_anxious']=="NA"){$when_anxious="NA";}else{$when_anxious="0".$row1['oasis_neuro_when_anxious'];}}else{$when_anxious=' ';}
$item_filler23='';
$item_filler7='';
if($table_name=='forms_oasis_nursing_soc'){if(in_array("1",$oasis_neuro_cognitive_symptoms)){$behaviour_memory_deficit='1';}else{$behaviour_memory_deficit='0';}}else{$behaviour_memory_deficit=' ';}
if($table_name=='forms_oasis_nursing_soc'){if(in_array("2",$oasis_neuro_cognitive_symptoms)){$behaviour_impaired='1';}else{$behaviour_impaired='0';}}else{$behaviour_impaired=' ';}
if($table_name=='forms_oasis_nursing_soc'){if(in_array("3",$oasis_neuro_cognitive_symptoms)){$behaviour_verbal_disruption='1';}else{$behaviour_verbal_disruption='0';}}else{$behaviour_verbal_disruption=' ';}
if($table_name=='forms_oasis_nursing_soc'){if(in_array("4",$oasis_neuro_cognitive_symptoms)){$behaviour_physically_aggression='1';}else{$behaviour_physically_aggression='0';}}else{$behaviour_physically_aggression=' ';}
if($table_name=='forms_oasis_nursing_soc'){if(in_array("5",$oasis_neuro_cognitive_symptoms)){$behaviour_socially_inappropriate='1';}else{$behaviour_socially_inappropriate='0';}}else{$behaviour_socially_inappropriate=' ';}
if($table_name=='forms_oasis_nursing_soc'){if(in_array("6",$oasis_neuro_cognitive_symptoms)){$behaviour_delusions='1';}else{$behaviour_delusions='0';}}else{$behaviour_delusions=' ';}
if($table_name=='forms_oasis_nursing_soc'){if(in_array("7",$oasis_neuro_cognitive_symptoms)){$behaviour_none='1';}else{$behaviour_none='0';}}else{$behaviour_none=' ';}
if($table_name=='forms_oasis_nursing_soc'){$frequency_of_behaviour_problems='0'.$row1['oasis_neuro_frequency_disruptive'];}else{$frequency_of_behaviour_problems=' ';}
if($table_name=='forms_oasis_nursing_soc'){$receives_psychiatric_nursing=$row1['oasis_neuro_psychiatric_nursing'];}else{$receives_psychiatric_nursing=' ';}
$item_filler24='';
if($table_name=='forms_oasis_nursing_soc'){$current_grooming='0'.$row1['oasis_adl_grooming'];}else{$current_grooming=' ';}
$item_filler25='';
if($table_name=='forms_oasis_nursing_soc'){$current_dress_upper_body='0'.$row1['oasis_adl_dress_upper'];}else{$current_dress_upper_body=' ';}
$item_filler26='';
if($table_name=='forms_oasis_nursing_soc'){$current_dress_lower_body='0'.$row1['oasis_adl_dress_lower'];}else{$current_dress_lower_body=' ';}
$item_filler27='';
if($table_name=='forms_oasis_nursing_soc'){$current_feeding='0'.$row1['oasis_adl_feeding_eating'];}else{$current_feeding=' ';}
$item_filler28='';
if($table_name=='forms_oasis_nursing_soc'){$current_prepare_light_meals='0'.$row1['oasis_adl_current_ability'];}else{$current_prepare_light_meals=' ';}
$item_filler29='';
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_adl_use_telephone']=="NA"){$current_telephone_use="NA";}else{$current_telephone_use="0".$row1['oasis_adl_use_telephone'];}}else{$current_telephone_use=' ';}
$item_filler30='';
$emergency_care_reason_medication='0';
$item_filler31='';
$emergency_care_reason_hypoglycemia='0';
$item_filler32='0';
$emergency_care_reason_unknown='0';
$inpatient_facility='NA';
$item_filler33='';
$hospitalized_medication='0';
$item_filler34='';
$hospitalized_hypoglycemia='0';
$item_filler3='';
$hospitalized_urinary_tract='0';
$item_filler36='';
$hospitalized_deep_vein='0';
$hospitalized_pain='0';
$item_filler37='';
$adimitted_to_nursing_home_therapy='0';
$adimitted_to_nursing_home_respite='0';
$adimitted_to_nursing_home_hospice='0';
$adimitted_to_nursing_home_permanent='0';
$adimitted_to_nursing_home_unsafe='0';
$adimitted_to_nursing_home_other='0';
$adimitted_to_nursing_home_unknown='0';
$last_home_visit_date=date("Ymd");
$discharge_transfer_death_date=date("Ymd");
$item_filler8='';
$item_filler9='';
$item_filler38='';
$discharged_skilled_nursing_facility='0';
$item_filler39='';
$not_discharged_skilled_nursing_facility='0';
$item_filler10='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$NPI=$row1['oasis_patient_npi'];}else{$NPI=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_episode_timing']=="NA"||$row1['oasis_patient_episode_timing']=="UK"){$episode_timing=$row1['oasis_patient_episode_timing'];}else{$episode_timing="0".$row1['oasis_patient_episode_timing'];}}else{$episode_timing=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_primary_col3=$row1['oasis_therapy_patient_diagnosis_3a'];}else{$case_mix_diag_primary_col3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_1_secondary_col3=$row1['oasis_therapy_patient_diagnosis_3b'];}else{$case_mix_diag_1_secondary_col3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_2_secondary_col3=$row1['oasis_therapy_patient_diagnosis_3c'];}else{$case_mix_diag_2_secondary_col3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_3_secondary_col3=$row1['oasis_therapy_patient_diagnosis_3d'];}else{$case_mix_diag_3_secondary_col3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_4_secondary_col3=$row1['oasis_therapy_patient_diagnosis_3e'];}else{$case_mix_diag_4_secondary_col3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_5_secondary_col3=$row1['oasis_therapy_patient_diagnosis_3f'];}else{$case_mix_diag_5_secondary_col3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_primary_col4=$row1['oasis_therapy_patient_diagnosis_4a'];}else{$case_mix_diag_primary_col4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_1_secondary_col4=$row1['oasis_therapy_patient_diagnosis_4b'];}else{$case_mix_diag_1_secondary_col4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_2_secondary_col4=$row1['oasis_therapy_patient_diagnosis_4c'];}else{$case_mix_diag_2_secondary_col4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_3_secondary_col4=$row1['oasis_therapy_patient_diagnosis_4d'];}else{$case_mix_diag_3_secondary_col4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_4_secondary_col4=$row1['oasis_therapy_patient_diagnosis_4e'];}else{$case_mix_diag_4_secondary_col4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$case_mix_diag_5_secondary_col4=$row1['oasis_therapy_patient_diagnosis_4f'];}else{$case_mix_diag_5_secondary_col4=' ';}
if($table_name=='forms_oasis_nursing_soc'){$therapy_need_no_of_visits=$row1['oasis_care_therapy_visits'];}else{$therapy_need_no_of_visits=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_therapy_need_applicable']=='NA'){$therapy_need_NA=1;}else{$therapy_need_NA=0;}}else{$therapy_need_NA=' ';}
$item_filler40='';
$phy_ordered_SOC_ROC_date=date("Ymd");
$phy_ordered_SOC_ROC_date_NA='1';
$phy_date_of_referral=date("Ymd");
$discharge_ltc_nh='0';
$discharge_short_stay='0';
$discharge_long_term='0';
$discharge_inpatient_rehab_facility='0';
$discharge_psychiatric_unit='0';
$discharge_other='0';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_icd_code3=$oasis_patient_history_if_code[2];}else{$inpatient_icd_code3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_icd_code4=$oasis_patient_history_if_code[3];}else{$inpatient_icd_code4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_icd_code5=$oasis_patient_history_if_code[4];}else{$inpatient_icd_code5=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_icd_code6=$oasis_patient_history_if_code[5];}else{$inpatient_icd_code6=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_icd_pro_code1=$oasis_patient_history_ip_code[0];}else{$inpatient_icd_pro_code1=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_icd_pro_code2=$oasis_patient_history_ip_code[1];}else{$inpatient_icd_pro_code2=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_icd_pro_code3=$oasis_patient_history_ip_code[2];}else{$inpatient_icd_pro_code3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$inpatient_icd_pro_code4=$oasis_patient_history_ip_code[3];}else{$inpatient_icd_pro_code4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_history_ip_diagnosis_na']=='NA'){$inpatient_icd_pro_code_NA=1;}else{$inpatient_icd_pro_code_NA=0;}}else{$inpatient_icd_pro_code_NA=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_history_ip_diagnosis_uk']=='UK'){$inpatient_icd_pro_code_UK=1;}else{$inpatient_icd_pro_code_UK=0;}}else{$inpatient_icd_pro_code_UK=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$regimen_icd_code5=$oasis_patient_history_mrd_code[4];}else{$regimen_icd_code5=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$regimen_icd_code6=$oasis_patient_history_mrd_code[5];}else{$regimen_icd_code6=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_patient_history_regimen_change']=='NA'){$regimen_NA=1;}else{$regimen_NA=0;}}else{$regimen_NA=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("1",$oasis_patient_history_risk_hospitalization)){$risk_hosp_recent='1';}else{$risk_hosp_recent='0';}}else{$risk_hosp_recent=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("2",$oasis_patient_history_risk_hospitalization)){$risk_hosp_multiple='1';}else{$risk_hosp_multiple='0';}}else{$risk_hosp_multiple=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("3",$oasis_patient_history_risk_hospitalization)){$risk_hosp_medications='1';}else{$risk_hosp_medications='0';}}else{$risk_hosp_medications=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("4",$oasis_patient_history_risk_hospitalization)){$risk_hosp_history='1';}else{$risk_hosp_history='0';}}else{$risk_hosp_history=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("5",$oasis_patient_history_risk_hospitalization)){$risk_hosp_fraility='1';}else{$risk_hosp_fraility='0';}}else{$risk_hosp_fraility=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("6",$oasis_patient_history_risk_hospitalization)){$risk_hosp_other='1';}else{$risk_hosp_other='0';}}else{$risk_hosp_other=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if(in_array("7",$oasis_patient_history_risk_hospitalization)){$risk_hosp_none='1';}else{$risk_hosp_none='0';}}else{$risk_hosp_none=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_overall_status='0'.$row1['oasis_patient_history_overall_status'];}else{$patient_overall_status=' ';}
$influenza_vaccine_received_or_not='';
$influenza_vaccine_not_received_reason='';
$pneumococcal_vaccine_received_or_not='';
$pneumococcal_vaccine_not_received_reason='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_living_arrangements_situation']>='10'){$patient_living_situation=$row1['oasis_living_arrangements_situation'];}else{$patient_living_situation='0'.$row1['oasis_living_arrangements_situation'];}}else{$patient_living_situation=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_sensory_status_hear']=="UK"){$ability_to_hear="UK";}else{$ability_to_hear="0".$row1['oasis_sensory_status_hear'];}}else{$ability_to_hear=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_sensory_status_understand_verbal']=="UK"){$understand_verbal="UK";}else{$understand_verbal="0".$row1['oasis_sensory_status_understand_verbal'];}}else{$understand_verbal=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$formal_pain_assessment='0'.$row1['oasis_pain_assessment_tool'];}else{$formal_pain_assessment=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$frequency_pain='0'.$row1['oasis_pain_frequency_interfering'];}else{$frequency_pain=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_assessed_risk_developing_pus='0'.$row1['oasis_pressure_ulcer_assessment'];}else{$patient_assessed_risk_developing_pus=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_have_risk_developing_pus=$row1['oasis_pressure_ulcer_risk'];}else{$patient_have_risk_developing_pus=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_have_unhealed_pu=$row1['oasis_pressure_ulcer_unhealed_s2'];}else{$patient_have_unhealed_pu=' ';}
$date_onset_stage2_pressure_ulcer=date("Ymd");
$status_stage2_pressure_ulcer='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$no_of_stage2_pressure_ulcer=$oasis_therapy_pressure_ulcer_a[0];}else{$no_of_stage2_pressure_ulcer=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$number_pu_stage2=$oasis_therapy_pressure_ulcer_a[1];}else{$number_pu_stage2=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$no_of_stage3_pressure_ulcer=$oasis_therapy_pressure_ulcer_b[0];}else{$no_of_stage3_pressure_ulcer=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$number_pu_stage3=$oasis_therapy_pressure_ulcer_b[1];}else{$number_pu_stage3=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$no_of_stage4_pressure_ulcer=$oasis_therapy_pressure_ulcer_c[0];}else{$no_of_stage4_pressure_ulcer=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$number_pu_stage4=$oasis_therapy_pressure_ulcer_c[1];}else{$number_pu_stage4=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$unstageable_dressing=$oasis_therapy_pressure_ulcer_d1[0];}else{$unstageable_dressing=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$unstageable_dressing_soc=$oasis_therapy_pressure_ulcer_d1[1];}else{$unstageable_dressing_soc=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$unstageable_coverage=$oasis_therapy_pressure_ulcer_d2[0];}else{$unstageable_coverage=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$unstageable_coverage_soc=$oasis_therapy_pressure_ulcer_d2[1];}else{$unstageable_coverage_soc=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$unstageable_suspected=$oasis_therapy_pressure_ulcer_d3[0];}else{$unstageable_suspected=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$unstageable_suspected_soc=$oasis_therapy_pressure_ulcer_d3[1];}else{$unstageable_suspected_soc=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$head_toe_length_stage3_pu=$row1['oasis_therapy_pressure_ulcer_length'];}else{$head_toe_length_stage3_pu=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$width_right_angles_stage3_pu=$row1['oasis_therapy_pressure_ulcer_width'];}else{$width_right_angles_stage3_pu=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$deap_stage3_pu=$row1['oasis_therapy_pressure_ulcer_depth'];}else{$deap_stage3_pu=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){if($row1['oasis_therapy_pressure_ulcer_problematic_status']=="NA"){$status_pressure_ulcer="NA";}else{$status_pressure_ulcer="0".$row1['oasis_therapy_pressure_ulcer_problematic_status'];}}else{$status_pressure_ulcer=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_have_stasis_ulcer='0'.$row1['oasis_therapy_pressure_ulcer_statis_ulcer'];}else{$patient_have_stasis_ulcer=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$no_of_stasis_ulcer='0'.$row1['oasis_therapy_pressure_ulcer_statis_ulcer_num'];}else{$no_of_stasis_ulcer=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$status_stasis_ulcer='0'.$row1['oasis_therapy_pressure_ulcer_statis_ulcer_status'];}else{$status_stasis_ulcer=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_have_surgical_wound='0'.$row1['oasis_therapy_surgical_wound'];}else{$patient_have_surgical_wound=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$status_surgical_wound='0'.$row1['oasis_therapy_status_surgical_wound'];}else{$status_surgical_wound=' ';}
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$patient_have_skin_lesion_open_wound=$row1['oasis_therapy_skin_lesion'];}else{$patient_have_skin_lesion_open_wound=' ';}
$symptoms_heart_failure='';
$heart_failure_no_action='';
$heart_failure_phy_contacted='';
$heart_failure_ER_treatment='';
$heart_failure_phy_treatment='';
$heart_failure_patient_edu='';
$heart_failure_change_plan='';
if($table_name=='forms_oasis_nursing_soc'||$table_name=='forms_oasis_nursing_resumption'){$urinary_incontinence_occurs='0'.$row1['oasis_elimination_status_urinary_incontinence_occur'];}else{$urinary_incontinence_occurs=' ';}
if($table_name=='forms_oasis_nursing_soc'){$patient_screened_depression='0'.$row1['oasis_neuro_depression_screening'];}else{$patient_screened_depression=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_neuro_little_interest']=="NA"){$phq2_pfizer_little_interest="NA";}else{$phq2_pfizer_little_interest="0".$row1['oasis_neuro_little_interest'];}}else{$phq2_pfizer_little_interest=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_neuro_feeling_down']=="NA"){$phq2_pfizer_little_depressed="NA";}else{$phq2_pfizer_little_depressed="0".$row1['oasis_neuro_feeling_down'];}}else{$phq2_pfizer_little_depressed=' ';}
if($table_name=='forms_oasis_nursing_soc'){$current_bathing='0'.$row1['oasis_adl_wash'];}else{$current_bathing=' ';}
if($table_name=='forms_oasis_nursing_soc'){$current_toileting='0'.$row1['oasis_adl_toilet_transfer'];}else{$current_toileting=' ';}
if($table_name=='forms_oasis_nursing_soc'){$current_toileting_hygiene='0'.$row1['oasis_adl_toileting_hygiene'];}else{$current_toileting_hygiene=' ';}
if($table_name=='forms_oasis_nursing_soc'){$current_transferring='0'.$row1['oasis_adl_transferring'];}else{$current_transferring=' ';}
if($table_name=='forms_oasis_nursing_soc'){$current_ambulation='0'.$row1['oasis_adl_ambulation'];}else{$current_ambulation=' ';}
$hipps_group_code_submitted='';
$item_filler11='';
$hipps_version_submitted='';
if($table_name=='forms_oasis_nursing_soc'){$prior_functioning_ADL_selfcare='0'.$row1['oasis_adl_func_self_care'];}else{$prior_functioning_ADL_selfcare=' ';}
if($table_name=='forms_oasis_nursing_soc'){$prior_functioning_ADL_ambulation='0'.$row1['oasis_adl_func_ambulation'];}else{$prior_functioning_ADL_ambulation=' ';}
if($table_name=='forms_oasis_nursing_soc'){$prior_functioning_ADL_transfer='0'.$row1['oasis_adl_func_transfer'];}else{$prior_functioning_ADL_transfer=' ';}
if($table_name=='forms_oasis_nursing_soc'){$prior_functioning_ADL_household='0'.$row1['oasis_adl_func_household'];}else{$prior_functioning_ADL_household=' ';}
if($table_name=='forms_oasis_nursing_soc'){$patient_had_multifactor_risk_assessment='0'.$row1['oasis_adl_fall_risk_assessment'];}else{$patient_had_multifactor_risk_assessment=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_adl_drug_regimen']=="NA"){$drug_regimen_review="NA";}else{$drug_regimen_review="0".$row1['oasis_adl_drug_regimen'];}}else{$drug_regimen_review=' ';}
if($table_name=='forms_oasis_nursing_soc'){$medication_follow_up=$row1['oasis_adl_medication_follow_up'];}else{$medication_follow_up=' ';}
$medication_intervention='01';
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_adl_patient_caregiver']=="NA"){$patient_high_risk_drug_education="NA";}else{$patient_high_risk_drug_education="0".$row1['oasis_adl_patient_caregiver'];}}else{$patient_high_risk_drug_education=' ';}
$patient_drug_education_intervention='';
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_adl_management_oral_medications']=="NA"){$current_mgmt_oral_medication="NA";}else{$current_mgmt_oral_medication="0".$row1['oasis_adl_management_oral_medications'];}}else{$current_mgmt_oral_medication=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_adl_management_injectable_medications']=="NA"){$current_mgmt_injectable_medications="NA";}else{$current_mgmt_injectable_medications="0".$row1['oasis_adl_management_injectable_medications'];}}else{$current_mgmt_injectable_medications=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_adl_func_oral_med']=="na"){$prior_med_mgmt_oral_medications="NA";}else{$prior_med_mgmt_oral_medications="0".$row1['oasis_adl_func_oral_med'];}}else{$prior_med_mgmt_oral_medications=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_adl_inject_med']=="na"){$prior_med_mgmt_injectable_medications="NA";}else{$prior_med_mgmt_injectable_medications="0".$row1['oasis_adl_inject_med'];}}else{$prior_med_mgmt_injectable_medications=' ';}
if($table_name=='forms_oasis_nursing_soc'){$care_mgmt_ADL='0'.$row1['oasis_care_adl_assistance'];}else{$care_mgmt_ADL=' ';}
if($table_name=='forms_oasis_nursing_soc'){$care_mgmt_IADL='0'.$row1['oasis_care_iadl_assistance'];}else{$care_mgmt_IADL=' ';}
if($table_name=='forms_oasis_nursing_soc'){$care_mgmt_medication_admin='0'.$row1['oasis_care_medication_admin'];}else{$care_mgmt_medication_admin=' ';}
if($table_name=='forms_oasis_nursing_soc'){$care_mgmt_med_tx='0'.$row1['oasis_care_medical_procedures'];}else{$care_mgmt_med_tx=' ';}
if($table_name=='forms_oasis_nursing_soc'){$care_mgmt_equipment='0'.$row1['oasis_care_management_equip'];}else{$care_mgmt_equipment=' ';}
if($table_name=='forms_oasis_nursing_soc'){$care_mgmt_supervision='0'.$row1['oasis_care_supervision_safety'];}else{$care_mgmt_supervision=' ';}
if($table_name=='forms_oasis_nursing_soc'){$care_mgmt_advocacy='0'.$row1['oasis_care_advocacy_facilitation'];}else{$care_mgmt_advocacy=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_how_often']=="UK"){$how_often_ADL_IADL_assistance="UK";}else{$how_often_ADL_IADL_assistance="0".$row1['oasis_care_how_often'];}}else{$how_often_ADL_IADL_assistance=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_diabetic_foot_care']=="na"){$poc_synopsis_diabetic_foot_care="NA";}else{$poc_synopsis_diabetic_foot_care="0".$row1['oasis_care_diabetic_foot_care'];}}else{$poc_synopsis_diabetic_foot_care=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_patient_parameter']=="na"){$poc_synopsis_patient_specific_parameters="NA";}else{$poc_synopsis_patient_specific_parameters="0".$row1['oasis_care_patient_parameter'];}}else{$poc_synopsis_patient_specific_parameters=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_falls_prevention']=="na"){$poc_synopsis_falls_prevention="NA";}else{$poc_synopsis_falls_prevention="0".$row1['oasis_care_falls_prevention'];}}else{$poc_synopsis_falls_prevention=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_depression_intervention']=="na"){$poc_synopsis_depression="NA";}else{$poc_synopsis_depression="0".$row1['oasis_care_depression_intervention'];}}else{$poc_synopsis_depression=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_intervention_monitor']=="na"){$poc_synopsis_pain="NA";}else{$poc_synopsis_pain="0".$row1['oasis_care_intervention_monitor'];}}else{$poc_synopsis_pain=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_intervention_prevent']=="na"){$poc_synopsis_PU_prevention="NA";}else{$poc_synopsis_PU_prevention="0".$row1['oasis_care_intervention_prevent'];}}else{$poc_synopsis_PU_prevention=' ';}
if($table_name=='forms_oasis_nursing_soc'){if($row1['oasis_care_pressure_ulcer']=="na"){$poc_synopsis_PU_moist="NA";}else{$poc_synopsis_PU_moist="0".$row1['oasis_care_pressure_ulcer'];}}else{$poc_synopsis_PU_moist=' ';}
$emergent_care_oasis_data_collection='';
$emergent_care_reason_injury_caused='';
$emergent_care_reason_respiratory_infection='';
$emergent_care_reason_respiratory_other='';
$emergent_care_reason_heart_failure='';
$emergent_care_reason_cardiac_dysrhythmia='';
$emergent_care_reason_chest_pain='';
$emergent_care_reason_other_heart_disease='';
$emergent_care_reason_stroke='';
$emergent_care_GI_bleeding='';
$emergent_care_reason_dehydration='';
$emergent_care_reason_urinary_track_infection='';
$emergent_care_reason_IV_catheter='';
$emergent_care_reason_wound_infection='';
$emergent_care_reason_uncontrolled_pain='';
$emergent_care_reason_acute_mental_health_problem='';
$emergent_care_reason_deep_vein='';
$emergent_care_reason_other='';
$intervention_synopsis_prevention='';
$intervention_synopsis_depression='';
$intervention_synopsis_diabetic_foot_care='';
$intervention_synopsis_monitor_mitigate_pain='';
$intervention_synopsis_prevent_pressure_ulcer='';
$intervention_synopsis_pressure_ulcer_treatment='';
$discharge_disposition='';
$hospitalized_injury='';
$hospitalized_respiratory='';
$hospitalized_other_respiratory='';
$hospitalized_heart_failure='';
$hospitalized_cardiac_dysrhythmia='';
$hospitalized_myocardial='';
$hospitalized_other_heart_disease='';
$hospitalized_stroke='';
$hospitalized_GI_bleeding='';
$hospitalized_dehydration='';
$hospitalized_IV_catheter='';
$hospitalized_wound_infection='';
$hospitalized_acute_health_problem='';
$hospitalized_scheduled_treatment='';
$hospitalized_other='';
$hospitalized_UK='';
$item_filler41='';
$CMS_use1='';
$item_filler42='';
$CMS_use2='';
$item_filler43='';
}





$B1string=
$recordID.
str_pad($Record_Type_code,2).
str_pad($Assessment_lock_date,8).
str_pad($correction_number_for_record,2).
str_pad($document_ID_code,8).
str_pad($OASIS_data_set_version_code,12).
str_pad($layout_submitted_version_code,5).
str_pad($agent_tax_id,9).
str_pad($software_version_code,5).
str_pad($HHA_agency_ID_code,16).
str_pad($patient_ID_code,14).
str_pad($state_ID_code,2).
str_pad($state_error_count,4).
str_pad($state_correction,1).
str_pad($state_payment_correction_indicator,1).
str_pad($state_key_correction_indicator,1).
str_pad($state_deleted_record_flag,1).
str_pad($medicare_correction,1).
str_pad($medicare_payment_correction_indicator,1).
str_pad($medicare_key_correction_indicator,1).
str_pad($masking_algorithm_version_code,20).
str_pad($control_section_filler,7).
str_pad($CMS_certification_number,6).
str_pad($item_filler,15).
str_pad($branch_state,2).
str_pad($branch_id,10).
str_pad($patient_id,20).
str_pad($start_of_care_date,8).
str_pad($resumption_of_care_date,8).
str_pad($no_resumption_of_care_date,1).
str_pad($patient_first_name,12).
str_pad($patient_middle_name,1).
str_pad($patient_last_name,18).
str_pad($patient_suffix,3).
str_pad($patient_state_of_residence,2).
str_pad($patient_zip_code,11).
str_pad($medicare_number,12).
str_pad($no_medicare_number,1).
str_pad($ssn,9).
str_pad($no_ssn,1).
str_pad($medicaid_number,14).
str_pad($no_medicaid_number,1).
str_pad($dob,8).
str_pad($item_filler_1,1).
str_pad($gender,1).
str_pad($primary_referring_physician_NPI,10).
str_pad($primary_referring_physician_no_NPI,1).
str_pad($discipline_of_person_completing_assessment,2).
str_pad($date_assessment_completed,8).
str_pad($reason_for_assessment,2).
str_pad($race_ethnicity_american,1).
str_pad($race_ethnicity_asian,1).
str_pad($race_ethnicity_black,1).
str_pad($race_ethnicity_hispanic,1).
str_pad($race_ethnicity_hawaiian,1).
str_pad($race_ethnicity_white,1).
str_pad($item_filler_2,1).
str_pad($payment_source_no,1).
str_pad($payment_source_medicare,1).
str_pad($payment_source_medicaid_traditional,1).
str_pad($payment_source_medicaid,1).
str_pad($payment_source_worker_compensation,1).
str_pad($payment_source_title_programs,1).
str_pad($payment_source_other_government,1).
str_pad($payment_source_private_insurance,1).
str_pad($payment_source_private_hmo,1).
str_pad($payment_source_other,1).
str_pad($payment_source_unknown,1).
str_pad($item_filler_3,6).
str_pad($item_filler_4,5).
str_pad($recent_discharge_date,8).
str_pad($recent_discharge_date_unknown,1).
str_pad($inpatient_stay_icd_code_1,7).
str_pad($inpatient_stay_icd_code_2,7).
str_pad($item_filler_5,1).
str_pad($regimen_change_icd_code_1,7).
str_pad($regimen_change_icd_code_2,7).
str_pad($regimen_change_icd_code_3,7).
str_pad($regimen_change_icd_code_4,7).
str_pad($prior_condition_urinary_incontinence,1).
str_pad($prior_condition_indewelling,1).
str_pad($prior_condition_intractable_pain,1).
str_pad($prior_condition_impaired_decision_making,1).
str_pad($prior_condition_disruptive,1).
str_pad($prior_condition_memory_loss,1).
str_pad($prior_condition_none,1).
str_pad($prior_condition_no_inpatient_discharge,1).
str_pad($prior_condition_unknown,1).
str_pad($primary_diagnosis_icd_code,7).
str_pad($primary_diagnosis_severity_rating,2).
str_pad($other_diagnosis_1_icd_code,7).
str_pad($other_diagnosis_1_severity_rating,2).
str_pad($other_diagnosis_2_icd_code,7).
str_pad($other_diagnosis_2_severity_rating,2).
str_pad($other_diagnosis_3_icd_code,7).
str_pad($other_diagnosis_3_severity_rating,2).
str_pad($other_diagnosis_4_icd_code,7).
str_pad($other_diagnosis_4_severity_rating,2).
str_pad($other_diagnosis_5_icd_code,7).
str_pad($other_diagnosis_5_severity_rating,2).
str_pad($therapies_received_intravenous,1).
str_pad($therapies_received_parenteral,1).
str_pad($therapies_received_enternal,1).
str_pad($therapies_received_none,1).
str_pad($item_filler_6,6).
str_pad($high_risk_factor_smoking,1).
str_pad($high_risk_factor_obesity,1).
str_pad($high_risk_factor_alcoholism,1).
str_pad($high_risk_factor_drugs,1).
str_pad($high_risk_factor_none,1).
str_pad($high_risk_factor_unknown,1).
str_pad($item_filler19,2).
str_pad($item_filler4,5).
str_pad($item_filler5,12).
str_pad($item_filler6,13).
str_pad($item_filler17,23).
str_pad($sensory_status_vision,2).
str_pad($item_filler18,2).
str_pad($sensory_status_speech,2).
str_pad($item_filler19,5).
str_pad($number_pressure_ulcers,2).
str_pad($item_filler20,7).
str_pad($stage_pressure_ulcer,2).
str_pad($item_filler22,14).
str_pad($when_dyspenic,2).
str_pad($resp_treatments_oxygen,1).
str_pad($resp_treatments_ventilator,1).
str_pad($resp_treatments_airway,1).
str_pad($resp_treatments_none,1).
str_pad($treated_for_urinary_tract_infection,2).
str_pad($urinary_incontinence,2).
str_pad($item_filler21,2).
str_pad($bowel_incontinence_frequency,2).
str_pad($ostomy_for_bowel_elimination,2).
str_pad($cognitive_functioning,2).
str_pad($when_confused,2).
str_pad($when_anxious,2).
str_pad($item_filler23,6).
str_pad($item_filler7,7).
str_pad($behaviour_memory_deficit,1).
str_pad($behaviour_impaired,1).
str_pad($behaviour_verbal_disruption,1).
str_pad($behaviour_physically_aggression,1).
str_pad($behaviour_socially_inappropriate,1).
str_pad($behaviour_delusions,1).
str_pad($behaviour_none,1).
str_pad($frequency_of_behaviour_problems,2).
str_pad($receives_psychiatric_nursing,1).
str_pad($item_filler24,2).
str_pad($current_grooming,2).
str_pad($item_filler25,2).
str_pad($current_dress_upper_body,2).
str_pad($item_filler26,2).
str_pad($current_dress_lower_body,2).
str_pad($item_filler27,18).
str_pad($current_feeding,2).
str_pad($item_filler28,2).
str_pad($current_prepare_light_meals,2).
str_pad($item_filler29,18).
str_pad($current_telephone_use,2).
str_pad($item_filler30,21).
str_pad($emergency_care_reason_medication,1).
str_pad($item_filler31,5).
str_pad($emergency_care_reason_hypoglycemia,1).
str_pad($item_filler32,2).
str_pad($emergency_care_reason_unknown,1).
str_pad($inpatient_facility,2).
str_pad($item_filler33,7).
str_pad($hospitalized_medication,1).
str_pad($item_filler34,3).
str_pad($hospitalized_hypoglycemia,1).
str_pad($item_filler35,5).
str_pad($hospitalized_urinary_tract,1).
str_pad($item_filler36,1).
str_pad($hospitalized_deep_vein,1).
str_pad($hospitalized_pain,1).
str_pad($item_filler37,2).
str_pad($adimitted_to_nursing_home_therapy,1).
str_pad($adimitted_to_nursing_home_respite,1).
str_pad($adimitted_to_nursing_home_hospice,1).
str_pad($adimitted_to_nursing_home_permanent,1).
str_pad($adimitted_to_nursing_home_unsafe,1).
str_pad($adimitted_to_nursing_home_other,1).
str_pad($adimitted_to_nursing_home_unknown,1).
str_pad($last_home_visit_date,8).
str_pad($discharge_transfer_death_date,8).
str_pad($item_filler8,2).
str_pad($item_filler9,2).
str_pad($item_filler38,2).
str_pad($discharged_skilled_nursing_facility,1).
str_pad($item_filler39,2).
str_pad($not_discharged_skilled_nursing_facility,1).
str_pad($item_filler10,14).
str_pad($NPI,10).
str_pad($episode_timing,2).
str_pad($case_mix_diag_primary_col3,7).
str_pad($case_mix_diag_1_secondary_col3,7).
str_pad($case_mix_diag_2_secondary_col3,7).
str_pad($case_mix_diag_3_secondary_col3,7).
str_pad($case_mix_diag_4_secondary_col3,7).
str_pad($case_mix_diag_5_secondary_col3,7).
str_pad($case_mix_diag_primary_col4,7).
str_pad($case_mix_diag_1_secondary_col4,7).
str_pad($case_mix_diag_2_secondary_col4,7).
str_pad($case_mix_diag_3_secondary_col4,7).
str_pad($case_mix_diag_4_secondary_col4,7).
str_pad($case_mix_diag_5_secondary_col4,7).
str_pad($therapy_need_no_of_visits,3).
str_pad($therapy_need_NA,1).
str_pad($item_filler40,1).
str_pad($phy_ordered_SOC_ROC_date,8).
str_pad($phy_ordered_SOC_ROC_date_NA,1).
str_pad($phy_date_of_referral,8).
str_pad($discharge_ltc_nh,1).
str_pad($discharge_short_stay,1).
str_pad($discharge_long_term,1).
str_pad($discharge_inpatient_rehab_facility,1).
str_pad($discharge_psychiatric_unit,1).
str_pad($discharge_other,1).
str_pad($inpatient_icd_code3,7).
str_pad($inpatient_icd_code4,7).
str_pad($inpatient_icd_code5,7).
str_pad($inpatient_icd_code6,7).
str_pad($inpatient_icd_pro_code1,7).
str_pad($inpatient_icd_pro_code2,7).
str_pad($inpatient_icd_pro_code3,7).
str_pad($inpatient_icd_pro_code4,7).
str_pad($inpatient_icd_pro_code_NA,1).
str_pad($inpatient_icd_pro_code_UK,1).
str_pad($regimen_icd_code5,7).
str_pad($regimen_icd_code6,7).
str_pad($regimen_NA,1).
str_pad($risk_hosp_recent,1).
str_pad($risk_hosp_multiple,1).
str_pad($risk_hosp_medications,1).
str_pad($risk_hosp_history,1).
str_pad($risk_hosp_fraility,1).
str_pad($risk_hosp_other,1).
str_pad($risk_hosp_none,1).
str_pad($patient_overall_status,2).
str_pad($influenza_vaccine_received_or_not,2).
str_pad($influenza_vaccine_not_received_reason,2).
str_pad($pneumococcal_vaccine_received_or_not,2).
str_pad($pneumococcal_vaccine_not_received_reason,2).
str_pad($patient_living_situation,2).
str_pad($ability_to_hear,2).
str_pad($understand_verbal,2).
str_pad($formal_pain_assessment,2).
str_pad($frequency_pain,2).
str_pad($patient_assessed_risk_developing_pus,2).
str_pad($patient_have_risk_developing_pus,1).
str_pad($patient_have_unhealed_pu,1).
str_pad($date_onset_stage2_pressure_ulcer,8).
str_pad($status_stage2_pressure_ulcer,2).
str_pad($no_of_stage2_pressure_ulcer,2).
str_pad($number_pu_stage2,2).
str_pad($no_of_stage3_pressure_ulcer,2).
str_pad($number_pu_stage3,2).
str_pad($no_of_stage4_pressure_ulcer,2).
str_pad($number_pu_stage4,2).
str_pad($unstageable_dressing,2).
str_pad($unstageable_dressing_soc,2).
str_pad($unstageable_coverage,2).
str_pad($unstageable_coverage_soc,2).
str_pad($unstageable_suspected,2).
str_pad($unstageable_suspected_soc,2).
str_pad($head_toe_length_stage3_pu,4).
str_pad($width_right_angles_stage3_pu,4).
str_pad($depth_stage3_pu,4).
str_pad($status_pressure_ulcer,2).
str_pad($patient_have_stasis_ulcer,2).
str_pad($no_of_stasis_ulcer,2).
str_pad($status_stasis_ulcer,2).
str_pad($patient_have_surgical_wound,2).
str_pad($status_surgical_wound,2).
str_pad($patient_have_skin_lesion_open_wound,1).
str_pad($symptoms_heart_failure,2).
str_pad($heart_failure_no_action,1).
str_pad($heart_failure_phy_contacted,1).
str_pad($heart_failure_ER_treatment,1).
str_pad($heart_failure_phy_treatment,1).
str_pad($heart_failure_patient_edu,1).
str_pad($heart_failure_change_plan,1).
str_pad($urinary_incontinence_occurs,2).
str_pad($patient_screened_depression,2).
str_pad($phq2_pfizer_little_interest,2).
str_pad($phq2_pfizer_little_depressed,2).
str_pad($current_bathing,2).
str_pad($current_toileting,2).
str_pad($current_toileting_hygiene,2).
str_pad($current_transferring,2).
str_pad($current_ambulation,2).
str_pad($hipps_group_code_submitted,5).
str_pad($item_filler11,5).
str_pad($hipps_version_submitted,5).
str_pad($prior_functioning_ADL_selfcare,2).
str_pad($prior_functioning_ADL_ambulation,2).
str_pad($prior_functioning_ADL_transfer,2).
str_pad($prior_functioning_ADL_household,2).
str_pad($patient_had_multifactor_risk_assessment,2).
str_pad($drug_regimen_review,2).
str_pad($medication_follow_up,1).
str_pad($medication_intervention,2).
str_pad($patient_high_risk_drug_education,2).
str_pad($patient_drug_education_intervention,2).
str_pad($current_mgmt_oral_medication,2).
str_pad($current_mgmt_injectable_medications,2).
str_pad($prior_med_mgmt_oral_medications,2).
str_pad($prior_med_mgmt_injectable_medications,2).
str_pad($care_mgmt_ADL,2).
str_pad($care_mgmt_IADL,2).
str_pad($care_mgmt_medication_admin,2).
str_pad($care_mgmt_med_tx,2).
str_pad($care_mgmt_equipment,2).
str_pad($care_mgmt_supervision,2).
str_pad($care_mgmt_advocacy,2).
str_pad($how_often_ADL_IADL_assistance,2).
str_pad($poc_synopsis_diabetic_foot_care,2).
str_pad($poc_synopsis_patient_specific_parameters,2).
str_pad($poc_synopsis_falls_prevention,2).
str_pad($poc_synopsis_depression,2).
str_pad($poc_synopsis_pain,2).
str_pad($poc_synopsis_PU_prevention,2).
str_pad($poc_synopsis_PU_moist,2).
str_pad($emergent_care_oasis_data_collection,2).
str_pad($emergent_care_reason_injury_caused,1).
str_pad($emergent_care_reason_respiratory_infection,1).
str_pad($emergent_care_reason_respiratory_other,1).
str_pad($emergent_care_reason_heart_failure,1).
str_pad($emergent_care_reason_cardiac_dysrhythmia,1).
str_pad($emergent_care_reason_chest_pain,1).
str_pad($emergent_care_reason_other_heart_disease,1).
str_pad($emergent_care_reason_stroke,1).
str_pad($emergent_care_GI_bleeding,1).
str_pad($emergent_care_reason_dehydration,1).
str_pad($emergent_care_reason_urinary_track_infection,1).
str_pad($emergent_care_reason_IV_catheter,1).
str_pad($emergent_care_reason_wound_infection,1).
str_pad($emergent_care_reason_uncontrolled_pain,1).
str_pad($emergent_care_reason_acute_mental_health_problem,1).
str_pad($emergent_care_reason_deep_vein,1).
str_pad($emergent_care_reason_other,1).
str_pad($intervention_synopsis_prevention,2).
str_pad($intervention_synopsis_depression,2).
str_pad($intervention_synopsis_diabetic_foot_care,2).
str_pad($intervention_synopsis_monitor_mitigate_pain,2).
str_pad($intervention_synopsis_prevent_pressure_ulcer,2).
str_pad($intervention_synopsis_pressure_ulcer_treatment,2).
str_pad($discharge_disposition,2).
str_pad($hospitalized_injury,1).
str_pad($hospitalized_respiratory,1).
str_pad($hospitalized_other_respiratory,1).
str_pad($hospitalized_heart_failure,1).
str_pad($hospitalized_cardiac_dysrhythmia,1).
str_pad($hospitalized_myocardial,1).
str_pad($hospitalized_other_heart_disease,1).
str_pad($hospitalized_stroke,1).
str_pad($hospitalized_GI_bleeding,1).
str_pad($hospitalized_dehydration,1).
str_pad($hospitalized_IV_catheter,1).
str_pad($hospitalized_wound_infection,1).
str_pad($hospitalized_acute_health_problem,1).
str_pad($hospitalized_scheduled_treatment,1).
str_pad($hospitalized_other,1).
str_pad($hospitalized_UK,1).
str_pad($item_filler41,137).
str_pad($CMS_use1,52).
str_pad($item_filler42,6).
str_pad($CMS_use2,46).
str_pad($item_filler43,3)."%";

//$myFile = '/tmp/B1_'.date('YmdHis').'.txt';
//$fh = fopen($myFile, 'w') or die("can't open file");
//fwrite($fh, $B1string); echo $myFile;
$b1_string=$B1string;
//echo $b1_string;
//header('Content-disposition: attachment; filename=B1string.txt');
//header('Content-type: text/plain');
//fclose($fh);
?>
