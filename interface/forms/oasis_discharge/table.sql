CREATE TABLE IF NOT EXISTS `forms_oasis_discharge` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
detail varchar(100),
process varchar(100),
data varchar(100),
label varchar(100),
oasis_patient_patient_name varchar(30),
oasis_patient_caregiver varchar(30),
oasis_patient_visit_date DATE,
time_in varchar(10),
time_out varchar(10),
oasis_therapy_cms_no varchar(20),
oasis_therapy_branch_state varchar(20),
oasis_therapy_branch_id_no varchar(20),
oasis_therapy_npi varchar(20),
oasis_therapy_npi_na varchar(4),
oasis_therapy_patient_id varchar(10),
oasis_therapy_soc_date DATE,
oasis_therapy_patient_name_first varchar(20),
oasis_therapy_patient_name_mi varchar(20),
oasis_therapy_patient_name_last varchar(20),
oasis_therapy_patient_name_suffix varchar(20),
oasis_therapy_patient_address_street varchar(20),
oasis_therapy_patient_address_city varchar(20),
oasis_therapy_patient_phone varchar(20),
oasis_therapy_patient_state varchar(20),
oasis_therapy_patient_zip varchar(10),
oasis_therapy_medicare_no varchar(20),
oasis_therapy_medicare_no_na varchar(4),
oasis_therapy_ssn varchar(20),
oasis_therapy_ssn_na varchar(4),
oasis_therapy_medicaid_no varchar(20),
oasis_therapy_medicaid_no_na varchar(4),
oasis_therapy_birth_date DATE,
oasis_therapy_patient_gender varchar(6),
oasis_therapy_discipline_person varchar(1),
oasis_therapy_date_assessment_completed DATE,
oasis_therapy_follow_up varchar(1),
oasis_therapy_certification varchar(1),
oasis_therapy_date_last_contacted_physician DATE,
oasis_therapy_date_last_seen_by_physician DATE,
oasis_influenza_vaccine varchar(1),
oasis_pneumococcal_vaccine varchar(1),
oasis_reason_influenza_vaccine varchar(1),
oasis_reason_ppv_not_received varchar(1),
oasis_speech_and_oral varchar(1),
oasis_therapy_frequency_pain varchar(1),
oasis_system_review_weight varchar(30),
oasis_system_review_weight_detail varchar(10),
oasis_system_review_blood_sugar varchar(30),
oasis_system_review_bowel_detail varchar(10),
oasis_system_review_bowel_other varchar(30),
oasis_system_review_bowel_sounds varchar(30),
oasis_system_review_bladder_detail varchar(10),
oasis_system_review_bladder_other varchar(30),
oasis_system_review_urinary_output varchar(30),
oasis_system_review_urinary_output_detail varchar(3),
oasis_system_review varchar(50),
oasis_system_review_foley_with varchar(30),
oasis_system_review_foley_inflated varchar(30),
oasis_system_review_tolerated varchar(3),
oasis_system_review_other varchar(30),
oasis_therapy_pain_scale varchar(2),
oasis_therapy_pain_location varchar(20),
oasis_therapy_pain_location_cause varchar(20),
oasis_therapy_pain_description varchar(10),
oasis_therapy_pain_frequency varchar(15),
oasis_therapy_pain_aggravating_factors varchar(15),
oasis_therapy_pain_aggravating_factors_other varchar(20),
oasis_therapy_pain_relieving_factors varchar(100),
oasis_therapy_pain_relieving_factors_other varchar(20),
oasis_therapy_pain_activities_limited TEXT,
oasis_nutrition_status_prob varchar(15) default NULL,
oasis_nutrition_status varchar(30) default NULL,
oasis_nutrition_status_other varchar(30) default NULL,
oasis_nutrition_requirements varchar(30) default NULL,
oasis_nutrition_appetite varchar(10) default NULL,
oasis_nutrition_eat_patt mediumtext,
oasis_nutrition_eat_patt1 text,
oasis_nutrition_eat_patt_freq varchar(30) default NULL,
oasis_nutrition_eat_patt_amt varchar(30) default NULL,
oasis_nutrition_eat_gain_or_loss varchar(4),
oasis_nutrition_patt_gain varchar(30) default NULL,
oasis_nutrition_eat_patt1_gain_time varchar(5) default NULL,
oasis_nutrition_patt1_other varchar(30) default NULL,
oasis_nutrition_req varchar(50) default NULL,
oasis_nutrition_req_other varchar(30) default NULL,
oasis_nutrition_risks text,
oasis_nutrition_risks_MD varchar(30) default NULL,
nutrition_total varchar(3) default NULL,
oasis_nutrition_describe varchar(30) default NULL,
oasis_therapy_vital_sign_blood_pressure varchar(100),
oasis_therapy_vital_sign_temperature varchar(10),
oasis_therapy_vital_sign_pulse varchar(10),
oasis_therapy_vital_sign_pulse_type varchar(40),
oasis_therapy_vital_sign_respiratory_rate varchar(10),
oasis_therapy_vital_sign_pulse_textinput varchar(100),
oasis_therapy_vital_sign_respiratory_textinput varchar(100),
oasis_therapy_cardiopulmonary_problem varchar(2),
oasis_therapy_breath_sounds_type varchar(20),
oasis_therapy_breath_sounds TEXT,
oasis_therapy_breath_sounds_anterior varchar(5),
oasis_therapy_breath_sounds_posterior varchar(11),
oasis_therapy_breath_sounds_accessory_muscle_o2 varchar(2),
oasis_therapy_breath_sounds_cough varchar(7),
oasis_therapy_breath_sounds_productive varchar(5),
oasis_therapy_breath_sounds_o2_saturation varchar(30),
oasis_therapy_breath_sounds_accessory_muscle varchar(30),
oasis_therapy_breath_sounds_accessory_o2_detail varchar(30),
oasis_therapy_breath_sounds_accessory_lpm varchar(30),
oasis_therapy_breath_sounds_trach varchar(3),
oasis_therapy_breath_sounds_trach_manages varchar(10),
oasis_therapy_breath_sounds_productive_color varchar(20),
oasis_therapy_breath_sounds_productive_amount varchar(20),
oasis_therapy_breath_sounds_other varchar(30),
oasis_therapy_heart_sounds_type varchar(10),
oasis_therapy_heart_sounds TEXT,
oasis_therapy_heart_sounds_right TEXT,
oasis_therapy_heart_sounds_pacemaker varchar(30),
oasis_therapy_heart_sounds_pacemaker_date DATE,
oasis_therapy_heart_sounds_pacemaker_type varchar(30),
oasis_therapy_heart_sounds_other varchar(30),
oasis_therapy_heart_sounds_other_right varchar(30),
oasis_therapy_heart_sounds_chest_pain varchar(10),
oasis_therapy_heart_sounds_associated_with varchar(10),
oasis_therapy_heart_sounds_associated_with_other varchar(255),
oasis_therapy_heart_sounds_frequency varchar(12),
oasis_therapy_heart_sounds_edema varchar(10),
oasis_therapy_heart_sounds_edema_dependent varchar(12),
oasis_therapy_heart_sounds_capillary varchar(2),
oasis_therapy_heart_sounds_edema_right varchar(10),
oasis_therapy_heart_sounds_edema_dependent_right varchar(12),
oasis_therapy_heart_sounds_capillary_right varchar(2),
oasis_therapy_heart_sounds_notify varchar(20),
oasis_therapy_integumentary_status varchar(1),
oasis_therapy_integumentary_status_stage2 varchar(2),
oasis_therapy_integumentary_status_stage2_date DATE,
oasis_therapy_braden_scale_sensory varchar(2),
oasis_therapy_braden_scale_moisture varchar(2),
oasis_therapy_braden_scale_activity varchar(2),
oasis_therapy_braden_scale_mobility varchar(2),
oasis_therapy_braden_scale_nutrition varchar(2),
oasis_therapy_braden_scale_friction varchar(2),
oasis_therapy_braden_scale_total varchar(2),
oasis_therapy_pressure_ulcer_a TEXT,
oasis_therapy_pressure_ulcer_b TEXT,
oasis_therapy_pressure_ulcer_c TEXT,
oasis_therapy_pressure_ulcer_d1 TEXT,
oasis_therapy_pressure_ulcer_d2 TEXT,
oasis_therapy_pressure_ulcer_d3 TEXT,
oasis_therapy_wound_lesion_location TEXT,
oasis_therapy_wound_lesion_type TEXT,
oasis_therapy_wound_lesion_status TEXT,
oasis_therapy_wound_lesion_size_length varchar(20),
oasis_therapy_wound_lesion_size_width varchar(20),
oasis_therapy_wound_lesion_size_depth varchar(20),
oasis_therapy_wound_lesion_stage TEXT,
oasis_therapy_wound_lesion_tunneling TEXT,
oasis_therapy_wound_lesion_odor TEXT,
oasis_therapy_wound_lesion_skin TEXT,
oasis_therapy_wound_lesion_edema TEXT,
oasis_therapy_wound_lesion_stoma TEXT,
oasis_therapy_wound_lesion_appearance TEXT,
oasis_therapy_wound_lesion_drainage TEXT,
oasis_therapy_wound_lesion_color TEXT,
oasis_therapy_wound_lesion_consistency TEXT,
oasis_therapy_pressure_ulcer_length varchar(10),
oasis_therapy_pressure_ulcer_width varchar(10),
oasis_therapy_pressure_ulcer_depth varchar(10),
oasis_therapy_pressure_ulcer_problematic_status varchar(2),
oasis_therapy_pressure_ulcer_current_no varchar(1),
oasis_therapy_pressure_ulcer_stage_unhealed varchar(2),
oasis_therapy_pressure_ulcer_statis_ulcer varchar(1),
oasis_therapy_pressure_ulcer_statis_ulcer_num varchar(1),
oasis_therapy_pressure_ulcer_statis_ulcer_status varchar(1),
oasis_therapy_surgical_wound varchar(1),
oasis_therapy_status_surgical_wound varchar(1),
oasis_therapy_skin_lesion varchar(1),
oasis_therapy_integumentary_status_problem varchar(2),
oasis_therapy_wound_care_done varchar(3),
oasis_therapy_wound_location varchar(20),
oasis_therapy_wound TEXT,
oasis_therapy_wound_soiled_dressing_by varchar(20),
oasis_therapy_wound_soiled_technique varchar(10),
oasis_therapy_wound_cleaned varchar(20),
oasis_therapy_wound_irrigated varchar(20),
oasis_therapy_wound_packed varchar(20),
oasis_therapy_wound_dressing_apply varchar(20),
oasis_therapy_wound_incision varchar(20),
oasis_therapy_wound_comment TEXT,
oasis_therapy_satisfactory_return_demo varchar(3),
oasis_therapy_wound_education varchar(3),
oasis_therapy_wound_education_comment TEXT,
oasis_therapy_respiratory_status varchar(1),
oasis_therapy_respiratory_treatment varchar(10),
oasis_cardiac_status_symptoms varchar(2),
oasis_cardiac_status_heart_failure varchar(12),
oasis_elimination_status_tract_infection varchar(2),
oasis_elimination_status_urinary_incontinence varchar(1),
oasis_elimination_status_urinary_incontinence_occur varchar(1),
oasis_elimination_status_bowel_incontinence varchar(2),
oasis_mental_status varchar(150),
oasis_mental_status_other varchar(100) DEFAULT NULL,
oasis_functional_limitations varchar(225),
oasis_functional_limitations_other varchar(100) DEFAULT NULL,
oasis_prognosis varchar(10),
oasis_safety_measures text,
oasis_safety_measures_other varchar(150),
oasis_dme_iv_supplies varchar(225),
oasis_dme_iv_supplies_other varchar(150),
oasis_dme_foley_supplies varchar(225),
oasis_dme_foley_supplies_other varchar(150),



oasis_neuro_cognitive_functioning varchar(1),
oasis_neuro_when_confused varchar(2),
oasis_neuro_when_anxious varchar(2),
oasis_neuro_cognitive_symptoms varchar(20),
oasis_neuro_frequency_disruptive varchar(1),
oasis_adl_grooming varchar(1) default NULL,
oasis_adl_dress_upper varchar(1) default NULL,
oasis_adl_dress_lower varchar(1) default NULL,
oasis_adl_wash varchar(1) default NULL,
oasis_adl_toilet_transfer varchar(1) default NULL,
oasis_adl_toileting_hygiene varchar(1) default NULL,
oasis_adl_transferring varchar(1) default NULL,
oasis_adl_ambulation varchar(1) default NULL,
oasis_adl_feeding_eating varchar(1) default NULL,
oasis_adl_current_ability varchar(1) default NULL,
oasis_adl_use_telephone varchar(2) default NULL,
oasis_medication_intervention varchar(2),
oasis_medication_drug_education varchar(2),
oasis_medication_oral varchar(2),
oasis_medication_injectable varchar(2),
oasis_care_adl_assistance varchar(2) default NULL,
oasis_care_iadl_assistance varchar(2) default NULL,
oasis_care_medication_admin varchar(2) default NULL,
oasis_care_medical_procedures varchar(2) default NULL,
oasis_care_management_equip varchar(2) default NULL,
oasis_care_supervision_safety varchar(2) default NULL,
oasis_care_advocacy_facilitation varchar(2) default NULL,
oasis_care_how_often varchar(2) default NULL,
oasis_emergent_care varchar(2),
oasis_emergent_care_reason varchar(50),
oasis_data_items_a varchar(2),
oasis_data_items_b varchar(2),
oasis_data_items_c varchar(2),
oasis_data_items_d varchar(2),
oasis_data_items_e varchar(2),
oasis_data_items_f varchar(2),
oasis_inpatient_facility varchar(2),
oasis_discharge_disposition varchar(2),
Reason_for_Hospitalization text,
patient_Admitted_to_a_Nursing_Home text,
non_oasis_infusion_peripheral varchar(100) DEFAULT NULL,
non_oasis_infusion_PICC varchar(100) DEFAULT NULL,
non_oasis_infusion_central varchar(20) DEFAULT NULL,
non_oasis_infusion_central_date date DEFAULT NULL,
non_oasis_infusion_xray varchar(10) DEFAULT NULL,
non_oasis_infusion_circum INT DEFAULT '0',
non_oasis_infusion_length INT DEFAULT '0',
non_oasis_infusion_hickman varchar(20) DEFAULT NULL,
non_oasis_infusion_hickman_date date DEFAULT NULL,
non_oasis_infusion_epidural_date date DEFAULT NULL,
non_oasis_infusion_implanted_date date DEFAULT NULL,
non_oasis_infusion_med1_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_pump varchar(50) DEFAULT NULL,
non_oasis_infusion_admin_by varchar(50) DEFAULT NULL,
non_oasis_infusion_admin_by_other varchar(50) DEFAULT NULL,
non_oasis_infusion_purpose text,
non_oasis_infusion_purpose_other varchar(100) DEFAULT NULL,
non_oasis_infusion_care_provided text,
non_oasis_infusion_dressing varchar(20) DEFAULT NULL,
non_oasis_infusion_performed_by varchar(20) DEFAULT NULL,
non_oasis_infusion_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_injection varchar(50) DEFAULT NULL,
non_oasis_infusion_labs_drawn text,
non_oasis_infusion_interventions text,
non_oasis_enteral varchar(100) DEFAULT NULL,
non_oasis_enteral_other varchar(50) DEFAULT NULL,
non_oasis_enteral_pump varchar(50) DEFAULT NULL,
non_oasis_enteral_feedings varchar(20) DEFAULT NULL,
non_oasis_enteral_rate varchar(50) DEFAULT NULL,
non_oasis_enteral_flush text,
non_oasis_enteral_performed_by varchar(20) DEFAULT NULL,
non_oasis_enteral_performed_by_other varchar(50) DEFAULT NULL,
non_oasis_enteral_dressing text,
non_oasis_enteral_interventions text,
non_oasis_skilled_care varchar(50) DEFAULT NULL,
oasis_discharge_date_last_visit DATE,
oasis_discharge_transfer_date DATE,
non_oasis_summary_disciplines varchar(50) DEFAULT NULL,
non_oasis_summary_disciplines_other varchar(50) DEFAULT NULL,
non_oasis_summary_physician varchar(10) DEFAULT NULL,
non_oasis_summary_elsewhere varchar(5) DEFAULT NULL,
non_oasis_summary_reason mediumtext,
non_oasis_summary_medication varchar(50) DEFAULT NULL,
non_oasis_summary_medication_identified mediumtext DEFAULT NULL,
non_oasis_summary_reason_discharge text,
non_oasis_summary_reason_discharge_explain varchar(50) DEFAULT NULL,
non_oasis_summary_reason_discharge_other varchar(80) DEFAULT NULL,
non_oasis_summary_discharge_inst text,
non_oasis_summary_reviewed varchar(80) DEFAULT NULL,
non_oasis_summary_reviewed_other varchar(80) DEFAULT NULL,
non_oasis_summary_immunization varchar(10) DEFAULT NULL,
non_oasis_summary_immun_explain varchar(100) DEFAULT NULL,
non_oasis_summary_written varchar(10) DEFAULT NULL,
non_oasis_summary_written_explain varchar(100) DEFAULT NULL,
non_oasis_summary_demonstrates varchar(10) DEFAULT NULL,
non_oasis_summary_demonstrates_explain varchar(100) DEFAULT NULL,
synergy_id varchar(10)
 ) engine=MyISAM;
