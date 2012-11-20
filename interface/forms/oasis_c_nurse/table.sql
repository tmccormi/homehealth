CREATE TABLE IF NOT EXISTS `forms_oasis_c_nurse` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(100) default NULL,
groupname varchar(100) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,


detail varchar(100),
process varchar(100),
data varchar(100),
label varchar(100),


oasis_c_nurse_patient_name varchar(100) DEFAULT NULL,
oasis_c_nurse_caregiver varchar(100) DEFAULT NULL,
oasis_c_nurse_visit_date date default NULL,
oasis_c_nurse_time_in varchar(10) DEFAULT NULL,
oasis_c_nurse_time_out varchar(10) DEFAULT NULL,
oasis_c_nurse_cms_no varchar(10) DEFAULT NULL,
oasis_c_nurse_branch_state varchar(80) DEFAULT NULL,
oasis_c_nurse_branch_id_no varchar(10) DEFAULT NULL,
oasis_c_nurse_npi varchar(40) DEFAULT NULL,
oasis_c_nurse_npi_na varchar(5) DEFAULT NULL,
oasis_c_nurse_referring_physician_id varchar(10) DEFAULT NULL,
oasis_c_nurse_referring_physician_id_na varchar(5) DEFAULT NULL,
oasis_c_nurse_primary_physician_last varchar(100) DEFAULT NULL,
oasis_c_nurse_primary_physician_first varchar(100) DEFAULT NULL,
oasis_c_nurse_primary_physician_phone varchar(20) DEFAULT NULL,
oasis_c_nurse_primary_physician_address varchar(225) DEFAULT NULL,
oasis_c_nurse_primary_physician_city varchar(100) DEFAULT NULL,
oasis_c_nurse_primary_physician_state varchar(100) DEFAULT NULL,
oasis_c_nurse_primary_physician_zip varchar(20) DEFAULT NULL,
oasis_c_nurse_other_physician_last varchar(100) DEFAULT NULL,
oasis_c_nurse_other_physician_first varchar(100) DEFAULT NULL,
oasis_c_nurse_other_physician_phone varchar(20) DEFAULT NULL,
oasis_c_nurse_other_physician_address varchar(225) DEFAULT NULL,
oasis_c_nurse_other_physician_city varchar(50) DEFAULT NULL,
oasis_c_nurse_other_physician_state varchar(50) DEFAULT NULL,
oasis_c_nurse_other_physician_zip varchar(20) DEFAULT NULL,
oasis_c_nurse_patient_id varchar(10) DEFAULT NULL,
oasis_c_nurse_soc_date date default NULL,
oasis_c_nurse_patient_name_first varchar(100) DEFAULT NULL,
oasis_c_nurse_patient_name_mi varchar(100) DEFAULT NULL,
oasis_c_nurse_patient_name_last varchar(100) DEFAULT NULL,
oasis_c_nurse_patient_name_suffix varchar(50) DEFAULT NULL,
oasis_c_nurse_patient_address_street varchar(225) DEFAULT NULL,
oasis_c_nurse_patient_address_city varchar(80) DEFAULT NULL,
oasis_c_nurse_patient_phone varchar(20) DEFAULT NULL,
oasis_c_nurse_patient_state varchar(80) DEFAULT NULL,
oasis_c_nurse_patient_zip varchar(20) DEFAULT NULL,
oasis_c_nurse_medicare_no varchar(10) DEFAULT NULL,
oasis_c_nurse_medicare_no_na varchar(30) DEFAULT NULL,
oasis_c_nurse_ssn varchar(50) DEFAULT NULL,
oasis_c_nurse_ssn_na varchar(30) DEFAULT NULL,
oasis_c_nurse_medicaid_no varchar(50) DEFAULT NULL,
oasis_c_nurse_medicaid_no_na varchar(30) DEFAULT NULL,
oasis_c_nurse_birth_date date default NULL,
oasis_c_nurse_patient_gender varchar(10) DEFAULT NULL,
oasis_c_nurse_payment_source_homecare varchar(100) DEFAULT NULL,
oasis_c_nurse_discipline_person varchar(10) DEFAULT NULL,
oasis_c_nurse_date_assessment_completed date default NULL,
oasis_c_nurse_follow_up varchar(10) DEFAULT NULL,
oasis_c_nurse_episode_timing varchar(20) DEFAULT NULL,
oasis_c_nurse_certification_period_from date default NULL,
oasis_c_nurse_certification_period_to date default NULL,



oasis_patient_diagnosis_1a varchar(10),
oasis_patient_diagnosis_2a varchar(10),
oasis_patient_diagnosis_2a_sub varchar(10),
oasis_patient_diagnosis_3a varchar(10),
oasis_patient_diagnosis_4a varchar(10),
oasis_patient_diagnosis_1b varchar(10),
oasis_patient_diagnosis_2b varchar(10),
oasis_patient_diagnosis_2b_sub varchar(10),
oasis_patient_diagnosis_3b varchar(10),
oasis_patient_diagnosis_4b varchar(10),
oasis_patient_diagnosis_1c varchar(10),
oasis_patient_diagnosis_2c varchar(10),
oasis_patient_diagnosis_2c_sub varchar(10),
oasis_patient_diagnosis_3c varchar(10),
oasis_patient_diagnosis_4c varchar(10),
oasis_patient_diagnosis_1d varchar(10),
oasis_patient_diagnosis_2d varchar(10),
oasis_patient_diagnosis_2d_sub varchar(10),
oasis_patient_diagnosis_3d varchar(10),
oasis_patient_diagnosis_4d varchar(10),
oasis_patient_diagnosis_1e varchar(10),
oasis_patient_diagnosis_2e varchar(10),
oasis_patient_diagnosis_2e_sub varchar(10),
oasis_patient_diagnosis_3e varchar(10),
oasis_patient_diagnosis_4e varchar(10),
oasis_patient_diagnosis_1f varchar(10),
oasis_patient_diagnosis_2f varchar(10),
oasis_patient_diagnosis_2f_sub varchar(10),
oasis_patient_diagnosis_3f varchar(10),
oasis_patient_diagnosis_4f varchar(10),
oasis_patient_diagnosis_1g varchar(10),
oasis_patient_diagnosis_2g varchar(10),
oasis_patient_diagnosis_2g_sub varchar(10),
oasis_patient_diagnosis_3g varchar(10),
oasis_patient_diagnosis_4g varchar(10),
oasis_patient_diagnosis_1h varchar(10),
oasis_patient_diagnosis_2h varchar(10),
oasis_patient_diagnosis_2h_sub varchar(10),
oasis_patient_diagnosis_3h varchar(10),
oasis_patient_diagnosis_4h varchar(10),
oasis_patient_diagnosis_1i varchar(10),
oasis_patient_diagnosis_2i varchar(10),
oasis_patient_diagnosis_2i_sub varchar(10),
oasis_patient_diagnosis_3i varchar(10),
oasis_patient_diagnosis_4i varchar(10),
oasis_patient_diagnosis_1j varchar(10),
oasis_patient_diagnosis_2j varchar(10),
oasis_patient_diagnosis_2j_sub varchar(10),
oasis_patient_diagnosis_3j varchar(10),
oasis_patient_diagnosis_4j varchar(10),
oasis_patient_diagnosis_1k varchar(10),
oasis_patient_diagnosis_2k varchar(10),
oasis_patient_diagnosis_2k_sub varchar(10),
oasis_patient_diagnosis_3k varchar(10),
oasis_patient_diagnosis_4k varchar(10),
oasis_patient_diagnosis_1l varchar(10),
oasis_patient_diagnosis_2l varchar(10),
oasis_patient_diagnosis_2l_sub varchar(10),
oasis_patient_diagnosis_3l varchar(10),
oasis_patient_diagnosis_4l varchar(10),
oasis_patient_diagnosis_1m varchar(10),
oasis_patient_diagnosis_2m varchar(10),
oasis_patient_diagnosis_2m_sub varchar(10),
oasis_patient_diagnosis_3m varchar(10),
oasis_patient_diagnosis_4m varchar(10),
oasis_surgical_procedure_a varchar(10),
oasis_surgical_procedure_a_date date default NULL,
oasis_surgical_procedure_b varchar(10),
oasis_surgical_procedure_b_date date default NULL,



oasis_c_nurse_therapies_home  varchar(10) DEFAULT NULL,
oasis_c_nurse_vision varchar(2) DEFAULT NULL,
oasis_c_nurse_prognosis varchar(2) DEFAULT NULL,
oasis_c_nurse_frequency_pain varchar(2) DEFAULT NULL,
oasis_c_nurse_pain_scale varchar(2) DEFAULT NULL,
oasis_c_nurse_pain_location_cause varchar(100) DEFAULT NULL,
oasis_c_nurse_pain_description varchar(15) DEFAULT NULL,
oasis_c_nurse_pain_frequency varchar(15) DEFAULT NULL,
oasis_c_nurse_pain_aggravating_factors varchar(15) DEFAULT NULL,
oasis_c_nurse_pain_aggravating_factors_other text,
oasis_c_nurse_pain_relieving_factors varchar(15) DEFAULT NULL,
oasis_c_nurse_pain_relieving_factors_other text,
oasis_c_nurse_pain_activities_limited text,
oasis_c_nurse_experiencing_pain varchar(3) DEFAULT NULL,
oasis_c_nurse_unable_to_communicate varchar(30) DEFAULT NULL,
oasis_c_nurse_non_verbal_demonstrated varchar(30) DEFAULT NULL,
oasis_c_nurse_non_verbal_demonstrated_other text,
oasis_c_nurse_non_verbal_demonstrated_implications text,
oasis_c_nurse_breakthrough_medication varchar(50) DEFAULT NULL,
oasis_c_nurse_breakthrough_medication_other text,
oasis_c_nurse_implications_care_plan varchar(10) DEFAULT NULL,


oasis_integumentary_status_problem varchar(30),
oasis_wound_care_done varchar(10),
oasis_wound_location varchar(200),
oasis_wound text,
oasis_wound_soiled_dressing_by varchar(50),
oasis_wound_soiled_technique varchar(10),
oasis_wound_cleaned varchar(200),
oasis_wound_irrigated varchar(200),
oasis_wound_packed varchar(200),
oasis_wound_dressing_apply varchar(200),
oasis_wound_incision varchar(200),
oasis_wound_comment text,
oasis_satisfactory_return_demo varchar(10),
oasis_wound_education varchar(10),
oasis_wound_education_comment text,
oasis_wound_lesion_location text,
oasis_wound_lesion_type text,
oasis_wound_lesion_status text,
oasis_wound_lesion_size_length varchar(30),
oasis_wound_lesion_size_width varchar(30),
oasis_wound_lesion_size_depth varchar(30),
oasis_wound_lesion_stage text,
oasis_wound_lesion_tunneling text,
oasis_wound_lesion_odor text,
oasis_wound_lesion_skin text,
oasis_wound_lesion_edema text,
oasis_wound_lesion_stoma text,
oasis_wound_lesion_appearance text,
oasis_wound_lesion_drainage text,
oasis_wound_lesion_color text,
oasis_wound_lesion_consistency text,

oasis_integumentary_status varchar(10),
oasis_braden_scale_sensory INT(10) DEFAULT '0',
oasis_braden_scale_moisture INT(10) DEFAULT '0',
oasis_braden_scale_activity INT(10) DEFAULT '0',
oasis_braden_scale_mobility INT(10) DEFAULT '0',
oasis_braden_scale_nutrition INT(10) DEFAULT '0',
oasis_braden_scale_friction INT(10) DEFAULT '0',
oasis_braden_scale_total INT(10) DEFAULT '0',


oasis_c_nurse_stage2_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage2_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage3_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage3_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage4_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage4_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_non_removable_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_non_removable_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_coverage_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_coverage_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_suspected_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_suspected_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_current_ulcer_stage1 varchar(10),
oasis_c_nurse_stage_of_problematic_ulcer varchar(10),
oasis_c_nurse_statis_ulcer varchar(10),
oasis_c_nurse_current_no_statis_ulcer varchar(10),
oasis_c_nurse_problematic_statis_ulcer varchar(10),
oasis_c_nurse_surgical_wound varchar(10),
oasis_c_nurse_problematic_surgical_wound varchar(10),
oasis_c_nurse_skin_lesion varchar(10),


oasis_c_nurse_bp_lying_right varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_lying_left varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_sitting_right varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_sitting_left varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_standing_right varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_standing_left varchar(50) DEFAULT NULL,

oasis_c_nurse_vital_sign_temperature varchar(50) DEFAULT NULL,
oasis_c_nurse_vital_pulse text,
oasis_c_nurse_vital_sign_respiratory_rate varchar(100) DEFAULT NULL,	

oasis_c_nurse_cardiopulmonary_problem varchar(20) DEFAULT NULL,
oasis_c_nurse_breath_sounds_type varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds text,
oasis_c_nurse_breath_sounds_anterior varchar(20) DEFAULT NULL,
oasis_c_nurse_breath_sounds_posterior varchar(20) DEFAULT NULL,
oasis_c_nurse_breath_sounds_o2_saturation varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_accessory_muscle varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_accessory_muscle_o2 varchar(30) DEFAULT NULL,
oasis_c_nurse_breath_sounds_o2 varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_accessory_lpm varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_trach varchar(15) DEFAULT NULL,
oasis_c_nurse_breath_sounds_trach_manages varchar(50) DEFAULT NULL,
oasis_c_nurse_breath_sounds_cough varchar(50) DEFAULT NULL,
oasis_c_nurse_breath_sounds_productive varchar(50) DEFAULT NULL,
oasis_c_nurse_cardio_breath_color varchar(100) DEFAULT NULL,
oasis_c_nurse_cardio_breath_amt varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_other varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_type varchar(50) DEFAULT NULL,
oasis_c_nurse_heart_sounds text,
oasis_c_nurse_heart_sounds_pacemaker varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_pacemaker_date date default NULL,
oasis_c_nurse_heart_sounds_pacemaker_type varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_chest_pain varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_associated_with varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_frequency varchar(50) DEFAULT NULL,
oasis_c_nurse_heart_sounds_edema varchar(50) DEFAULT NULL,
oasis_c_nurse_heart_sounds_edema_dependent varchar(80) DEFAULT NULL,
oasis_c_nurse_heart_sounds_site varchar(30) DEFAULT NULL,
oasis_c_nurse_heart_sounds_capillary varchar(50) DEFAULT NULL,
oasis_c_nurse_heart_sounds_other varchar(100) DEFAULT NULL,
oasis_c_nurse_weight_variation varchar(100) DEFAULT NULL,
oasis_c_nurse_respiratory_status varchar(10) DEFAULT NULL,
oasis_c_nurse_urinary_problem varchar(20) DEFAULT NULL,
oasis_c_nurse_urinary text,
oasis_c_nurse_urinary_incontinence varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_management_strategy varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_diapers_other varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_color varchar(75) DEFAULT NULL,
oasis_c_nurse_urinary_color_other varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_clarity varchar(50) DEFAULT NULL,
oasis_c_nurse_urinary_odor varchar(10) DEFAULT NULL,
oasis_c_nurse_urinary_catheter varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_foley_date date default NULL,
oasis_c_nurse_urinary_foley_ml varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_solution varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_amount varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_ml varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_frequency varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_returns varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_tolerated_procedure varchar(50) DEFAULT NULL,
oasis_c_nurse_urinary_other varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_problem varchar(20) DEFAULT NULL,
oasis_c_nurse_bowels text,
oasis_c_nurse_bowel_regime varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_lexative_enema varchar(20) DEFAULT NULL,
oasis_c_nurse_bowels_lexative_enema_other varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_incontinence varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_diapers_others varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_ileostomy_site text,
oasis_c_nurse_bowels_ostomy_care varchar(30) DEFAULT NULL,
oasis_c_nurse_bowels_other_site text,
oasis_c_nurse_bowels_urostomy text,
oasis_c_nurse_elimination_urinary_incontinence varchar(10) DEFAULT NULL,
oasis_c_nurse_elimination_bowel_incontinence varchar(10) DEFAULT NULL,
oasis_c_nurse_elimination_ostomy varchar(10) DEFAULT NULL,


oasis_c_nurse_adl_dress_upper varchar(10) DEFAULT NULL,
oasis_c_nurse_adl_dress_lower varchar(10) DEFAULT NULL,
oasis_c_nurse_adl_wash varchar(5) DEFAULT NULL,
oasis_c_nurse_adl_toilet_transfer varchar(5) DEFAULT NULL,
oasis_c_nurse_adl_transferring varchar(5) DEFAULT NULL,
oasis_c_nurse_adl_ambulation varchar(5) DEFAULT NULL,
oasis_c_nurse_activities_permitted text,
oasis_c_nurse_activities_permitted_other varchar(100) DEFAULT NULL,
oasis_c_nurse_medication varchar(10) DEFAULT NULL,
oasis_c_nurse_therapy_need_number varchar(100) DEFAULT NULL,
oasis_c_nurse_therapy_need varchar(5) DEFAULT NULL,


oasis_c_nurse_fall_risk_reported varchar(5) DEFAULT NULL,
oasis_c_nurse_fall_risk_reported_details text,
oasis_c_nurse_fall_risk_factors varchar(5) DEFAULT NULL,
oasis_c_nurse_fall_risk_factors_details text,
oasis_c_nurse_fall_risk_assessment text,
oasis_c_nurse_fall_risk_assessment_total varchar(100) DEFAULT NULL,
oasis_c_nurse_fall_risk_assessment_comments text,
oasis_c_nurse_enteral text,
oasis_c_nurse_enteral_other varchar(100) DEFAULT NULL,
oasis_c_nurse_enteral_pump varchar(100) DEFAULT NULL,
oasis_c_nurse_enteral_feedings varchar(30) DEFAULT NULL,
oasis_c_nurse_enteral_rate varchar(100) DEFAULT NULL,
oasis_c_nurse_enteral_flush text,
oasis_c_nurse_enteral_performed_by varchar(30) DEFAULT NULL,
oasis_c_nurse_enteral_performed_by_other varchar(200) DEFAULT NULL,
oasis_c_nurse_enteral_dressing text,
oasis_c_nurse_infusion text,
oasis_c_nurse_infusion_peripheral varchar(200) DEFAULT NULL,
oasis_c_nurse_infusion_PICC varchar(200) DEFAULT NULL,
oasis_c_nurse_infusion_central varchar(30) DEFAULT NULL,
oasis_c_nurse_infusion_central_date date default NULL,
oasis_c_nurse_infusion_xray varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_circum varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_length varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_hickman varchar(20) DEFAULT NULL,
oasis_c_nurse_infusion_hickman_date date default NULL,
oasis_c_nurse_infusion_epidural_date date default NULL,
oasis_c_nurse_infusion_implanted_date date default NULL,
oasis_c_nurse_infusion_intrathecal_date date default NULL,
oasis_c_nurse_infusion_med1_admin varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med1_name varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med1_dose varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med1_dilution varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med1_route varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med1_frequency varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med1_duration varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med2_admin varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med2_name varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med2_dose varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med2_dilution varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med2_route varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med2_frequency varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med2_duration varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med3_admin varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med3_name varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med3_dose varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med3_dilution varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med3_route varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med3_frequency varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med3_duration varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_pump varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_admin_by varchar(15) DEFAULT NULL,
oasis_c_nurse_infusion_admin_by_other varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_dressing varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_performed_by varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_performed_by_other varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_frequency varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_injection varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_labs_drawn text,
oasis_c_nurse_timed_up_trial1 varchar(5) DEFAULT NULL,
oasis_c_nurse_timed_up_trial2 varchar(5) DEFAULT NULL,
oasis_c_nurse_timed_up_average varchar(5) DEFAULT NULL,
oasis_c_nurse_amplification_care_provided text,
oasis_c_nurse_amplification_patient_response text,
oasis_c_nurse_homebound_reason text,
oasis_c_nurse_homebound_reason_other varchar(100) DEFAULT NULL,
oasis_c_nurse_summary_check_careplan varchar(50) DEFAULT NULL,
oasis_c_nurse_summary_check_medication varchar(80) DEFAULT NULL,
oasis_c_nurse_summary_check_identified text,
oasis_c_nurse_summary_check_care_coordination varchar(15) DEFAULT NULL,
oasis_c_nurse_summary_check_carecordination_other varchar(100) DEFAULT NULL,
oasis_c_nurse_summary_check_referrel varchar(100) DEFAULT NULL,
oasis_c_nurse_summary_check_next_visit date default NULL,
oasis_c_nurse_summary_check_recertification varchar(3) DEFAULT NULL,
oasis_c_nurse_summary_check_verbal_order varchar(3) DEFAULT NULL,
oasis_c_nurse_summary_verbal_order_date date default NULL,
oasis_c_nurse_dme varchar(2) DEFAULT NULL,
oasis_c_nurse_dme_wound_care text,
oasis_c_nurse_dme_wound_care_glove varchar(15) DEFAULT NULL,
oasis_c_nurse_dme_wound_care_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_diabetic text,
oasis_c_nurse_dme_diabetic_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_iv_supplies text,
oasis_c_nurse_dme_iv_supplies_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_foley_supplies text,
oasis_c_nurse_dme_foley_supplies_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_urinary text,
oasis_c_nurse_dme_ostomy_pouch_brand varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_ostomy_pouch_size varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_ostomy_wafer_brand varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_ostomy_wafer_size varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_urinary_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_miscellaneous text,
oasis_c_nurse_dme_miscellaneous_type varchar(80) DEFAULT NULL,
oasis_c_nurse_dme_miscellaneous_size varchar(20) DEFAULT NULL,
oasis_c_nurse_dme_miscellaneous_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_supplies text,
oasis_c_nurse_dme_supplies_other varchar(100) DEFAULT NULL,
oasis_c_nurse_safety_measures text,
oasis_c_nurse_safety_measures_other varchar(100) DEFAULT NULL,
oasis_c_nurse_nutritional_requirement text,
oasis_c_nurse_nutritional_requirement_other varchar(100) DEFAULT NULL,
oasis_c_nurse_allergies text,
oasis_c_nurse_nutritional_allergies_other varchar(100) DEFAULT NULL,
oasis_c_nurse_functional_limitations text,
oasis_c_nurse_functional_limitations_other varchar(100) DEFAULT NULL,
oasis_c_nurse_mental_status text,
oasis_c_nurse_mental_status_other varchar(100) DEFAULT NULL,
oasis_c_nurse_discharge_plan text,
oasis_c_nurse_discharge_plan_other varchar(100) DEFAULT NULL,
oasis_c_nurse_discharge_plan_detail text,
oasis_c_nurse_discharge_plan_detail_other varchar(100) DEFAULT NULL,




 oasis_professional_vital_signs varchar(50) default NULL,
 oasis_professional_sn  varchar(30) default NULL,
 oasis_professional_vital_parameter text,
 oasis_professional_heart_rate0 varchar(10) default NULL,
 oasis_professional_heart_rate varchar(10) default NULL,
 oasis_professional_temperature0 varchar(10) default NULL,
 oasis_professional_temperature varchar(10) default NULL,
 oasis_professional_BP_systolic0 varchar(10) default NULL,
 oasis_professional_BP_systolic varchar(10) default NULL,
 oasis_professional_BP_diastolic0 varchar(10) default NULL,
 oasis_professional_BP_diastolic varchar(10) default NULL,
 oasis_professional_respirations0 varchar(10) default NULL,
 oasis_professional_respirations varchar(10) default NULL,
 
 oasis_professional_vital_other varchar(30) default NULL,
 oasis_professional_blood_glucose varchar(50) default NULL,
 oasis_professional_blood_glucose_BS_gt varchar(30) default NULL,
 oasis_professional_blood_glucose_BS_lt varchar(30) default NULL,
 oasis_professional_receive_orders_from varchar(30) default NULL,
 oasis_professional_sn_parameters text,
 oasis_professional_sn1 varchar(15) default NULL,
 oasis_professional_sn2 varchar(30) default NULL,
 oasis_professional_sn_every_visit varchar(30) default NULL,
 oasis_professional_sn_PRN_dyspnea text,
 oasis_professional_sn_other varchar(30) default NULL,
 oasis_professional_sn_frequency text,
 oasis_professional_PRN_visits_for varchar(30) default NULL,
 oasis_professional_sn_frequency_other varchar(30) default NULL,
 oasis_professional_goals text,
 oasis_professional_sn_provide text,
 oasis_professional_teaching_activities text,
 oasis_professional_goal_other varchar(30) default NULL,
 oasis_professional_decreased_to varchar(30) default NULL,
 oasis_professional_goal_other1 varchar(30) default NULL,
 oasis_professional_skilled_nurse1 text,
 oasis_professional_nurse_PICC varchar(50) default NULL,
 oasis_PICC_socl_before varchar(30) default NULL,
 oasis_PICC_socl_percent_before varchar(30) default NULL,
 oasis_PICC_socl_percent_after varchar(30) default NULL,
 oasis_PICC_socl_after varchar(30) default NULL,
 oasis_professional_heparin varchar(30) default NULL,
 oasis_PICC_dressing_change varchar(30) default NULL,
 oasis_PICC_injection_cap varchar(30) default NULL,
 oasis_PICC_extension_set varchar(30) default NULL,
 oasis_professional_nurse_peripheral varchar(50) default NULL,
 oasis_peripheral_socl_before varchar(30) default NULL,
 oasis_peripheral_socl_percent_before varchar(30) default NULL,
 oasis_peripheral_socl_after varchar(30) default NULL,
 oasis_peripheral_socl_percent_after varchar(30) default NULL,
 oasis_peripheral_heparin varchar(30) default NULL,
 oasis_professional_nurse_port varchar(50) default NULL,
 oasis_professional_nurse_use varchar(50) default NULL,
 oasis_PORT_socl_before varchar(30) default NULL,
 oasis_PORT_socl_percent_before varchar(30) default NULL,
 oasis_PORT_socl_percent_after varchar(30) default NULL,
 oasis_PORT_socl_after varchar(30) default NULL,
 oasis_PORT_heparin varchar(30) default NULL,
 oasis_PORT_dressing_change varchar(30) default NULL,
 oasis_PORT_injection_cap varchar(30) default NULL,
 oasis_PORT_extension_set varchar(30) default NULL,
 oasis_access_socl_after varchar(30) default NULL,
 oasis_access_socl_percent_after varchar(30) default NULL,
 oasis_access_heparin varchar(30) default NULL,
 oasis_professional_skilled_nurse2 text,
 oasis_professional_sn_nurse text,
 oasis_professional_sn_nurse_tube varchar(20) default NULL,
 oasis_professional_sn_nurse_tube_other varchar(30) default NULL,
 oasis_professional_sn_nurse_pump varchar(30) default NULL,
 oasis_professional_sn_nurse_feedings varchar(30) default NULL,
 oasis_professional_sn_nurse_continuous_rate varchar(30) default NULL,
 oasis_professional_flush_protocol varchar(30) default NULL,
 oasis_professional_formula varchar(30) default NULL,
 oasis_sn_nurse_performed_by varchar(30) default NULL,
 oasis_sn_nurse_performed_by_other varchar(30) default NULL,
 oasis_sn_nurse_dressing varchar(30) default NULL,
 oasis_sn_nurse_dressing_other varchar(30) default NULL,
 oasis_sn_nurse_wound_vac varchar(30) default NULL,
 oasis_sn_nurse_dressing_other1 varchar(30) default NULL,
 oasis_professional_sn_nurse1 text,
 oasis_professional_sn_nurse1_other varchar(30) default NULL,
 oasis_professional_sn_nurse2 text,
 oasis_professional_sn_nurse2_fr varchar(30) default NULL,
 oasis_professional_sn_nurse2_ml varchar(30) default NULL,
 oasis_catheter_std_protocol varchar(50) default NULL,
 oasis_catheter_MD varchar(50) default NULL,
 oasis_catheter_weeks varchar(10) default NULL,
 oasis_catheter_normal_saline_from varchar(10) default NULL,
 oasis_catheter_normal_saline_to varchar(10) default NULL,
 oasis_catheter_insertion_weeks varchar(10) default NULL,
 oasis_catheter_insertion_fr varchar(10) default NULL,
 oasis_catheter_insertion_ml varchar(10) default NULL,
 oasis_catheter_care_other varchar(30) default NULL,
 oasis_professional_sn_nurse2_venipuncture varchar(30) default NULL,
 oasis_professional_sn_nurse2_frequency varchar(30) default NULL,
 oasis_professional_sn_nurse2_other1 varchar(30) default NULL,
 oasis_professional_sn_nurse2_other2 varchar(30) default NULL,
 oasis_signature_last_name varchar(30) default NULL,
 oasis_signature_first_name varchar(30) default NULL,
 oasis_signature_middle_init varchar(30) default NULL




) engine=MyISAM;