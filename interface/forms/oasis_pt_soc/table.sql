CREATE TABLE IF NOT EXISTS `forms_oasis_pt_soc` (
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
oasis_patient_cms_no varchar(20),
oasis_patient_branch_state varchar(20),
oasis_patient_branch_id_no varchar(20),
oasis_patient_npi varchar(20),
oasis_patient_npi_na varchar(4),
oasis_patient_referring_physician_id varchar(20),
oasis_patient_referring_physician_id_na varchar(4),
oasis_patient_primary_physician_last varchar(20),
oasis_patient_primary_physician_first varchar(20),
oasis_patient_primary_physician_phone varchar(20),
oasis_patient_primary_physician_address varchar(40),
oasis_patient_primary_physician_city varchar(20),
oasis_patient_primary_physician_state varchar(20),
oasis_patient_primary_physician_zip varchar(10),
oasis_patient_other_physician_last varchar(20),
oasis_patient_other_physician_first varchar(20),
oasis_patient_other_physician_phone varchar(20),
oasis_patient_other_physician_address varchar(40),
oasis_patient_other_physician_city varchar(20),
oasis_patient_other_physician_state varchar(20),
oasis_patient_other_physician_zip varchar(10),
oasis_patient_patient_id varchar(10),
oasis_patient_soc_date DATE,
oasis_patient_resumption_care_date varchar(20),
oasis_patient_resumption_care_date_na varchar(4),
oasis_patient_patient_name_first varchar(20),
oasis_patient_patient_name_mi varchar(20),
oasis_patient_patient_name_last varchar(20),
oasis_patient_patient_name_suffix varchar(20),
oasis_patient_patient_address_street varchar(20),
oasis_patient_patient_address_city varchar(20),
oasis_patient_patient_phone varchar(20),
oasis_patient_patient_state varchar(20),
oasis_patient_patient_zip varchar(10),
oasis_patient_medicare_no varchar(20),
oasis_patient_medicare_no_na varchar(4),
oasis_patient_ssn varchar(20),
oasis_patient_ssn_na varchar(4),
oasis_patient_medicaid_no varchar(20),
oasis_patient_medicaid_no_na varchar(4),
oasis_patient_birth_date DATE,
oasis_patient_patient_gender varchar(6),
oasis_patient_race_ethnicity varchar(12),
oasis_patient_payment_source_homecare varchar(32),
oasis_patient_payment_source_homecare_other varchar(30),
oasis_patient_certification_period_from DATE,
oasis_patient_certification_period_to DATE,
oasis_patient_certification varchar(1),
oasis_patient_date_last_contacted_physician DATE,
oasis_patient_date_last_seen_by_physician DATE,
oasis_patient_discipline_person varchar(1),
oasis_patient_date_assessment_completed DATE,
oasis_patient_follow_up varchar(1),
oasis_patient_date_ordered_soc varchar(20),
oasis_patient_date_ordered_soc_na varchar(4),
oasis_patient_date_of_referral DATE,
oasis_patient_episode_timing varchar(2),
oasis_patient_history_impatient_facility varchar(20),
oasis_patient_history_impatient_facility_other varchar(20),
oasis_patient_history_discharge_date DATE,
oasis_patient_history_discharge_date_na varchar(2),
oasis_patient_history_if_diagnosis TEXT,
oasis_patient_history_if_code varchar(100),
oasis_patient_history_ip_diagnosis TEXT,
oasis_patient_history_ip_code varchar(100),
oasis_patient_history_ip_diagnosis_na varchar(2),
oasis_patient_history_ip_diagnosis_uk varchar(2),
oasis_patient_history_mrd_diagnosis TEXT,
oasis_patient_history_mrd_code varchar(100),
oasis_patient_history_mrd_diagnosis_na varchar(2),
oasis_patient_history_regimen_change varchar(22),
oasis_therapy_patient_diagnosis_1a varchar(10),
oasis_therapy_patient_diagnosis_2a varchar(10),
oasis_therapy_patient_diagnosis_2a_indicator varchar(1),
oasis_therapy_patient_diagnosis_2a_sub varchar(2),
oasis_therapy_patient_diagnosis_3a varchar(10),
oasis_therapy_patient_diagnosis_4a varchar(10),
oasis_therapy_patient_diagnosis_1b varchar(10),
oasis_therapy_patient_diagnosis_2b varchar(10),
oasis_therapy_patient_diagnosis_2b_indicator varchar(1),
oasis_therapy_patient_diagnosis_2b_sub varchar(2),
oasis_therapy_patient_diagnosis_3b varchar(10),
oasis_therapy_patient_diagnosis_4b varchar(10),
oasis_therapy_patient_diagnosis_1c varchar(10),
oasis_therapy_patient_diagnosis_2c varchar(10),
oasis_therapy_patient_diagnosis_2c_indicator varchar(1),
oasis_therapy_patient_diagnosis_2c_sub varchar(2),
oasis_therapy_patient_diagnosis_3c varchar(10),
oasis_therapy_patient_diagnosis_4c varchar(10),
oasis_therapy_patient_diagnosis_1d varchar(10),
oasis_therapy_patient_diagnosis_2d varchar(10),
oasis_therapy_patient_diagnosis_2d_indicator varchar(1),
oasis_therapy_patient_diagnosis_2d_sub varchar(2),
oasis_therapy_patient_diagnosis_3d varchar(10),
oasis_therapy_patient_diagnosis_4d varchar(10),
oasis_therapy_patient_diagnosis_1e varchar(10),
oasis_therapy_patient_diagnosis_2e varchar(10),
oasis_therapy_patient_diagnosis_2e_indicator varchar(1),
oasis_therapy_patient_diagnosis_2e_sub varchar(2),
oasis_therapy_patient_diagnosis_3e varchar(10),
oasis_therapy_patient_diagnosis_4e varchar(10),
oasis_therapy_patient_diagnosis_1f varchar(10),
oasis_therapy_patient_diagnosis_2f varchar(10),
oasis_therapy_patient_diagnosis_2f_indicator varchar(1),
oasis_therapy_patient_diagnosis_2f_sub varchar(2),
oasis_therapy_patient_diagnosis_3f varchar(10),
oasis_therapy_patient_diagnosis_4f varchar(10),
oasis_therapy_patient_diagnosis_1g varchar(10),
oasis_therapy_patient_diagnosis_2g varchar(10),
oasis_therapy_patient_diagnosis_2g_indicator varchar(1),
oasis_therapy_patient_diagnosis_2g_sub varchar(2),
oasis_therapy_patient_diagnosis_3g varchar(10),
oasis_therapy_patient_diagnosis_4g varchar(10),
oasis_therapy_patient_diagnosis_1h varchar(10),
oasis_therapy_patient_diagnosis_2h varchar(10),
oasis_therapy_patient_diagnosis_2h_indicator varchar(1),
oasis_therapy_patient_diagnosis_2h_sub varchar(2),
oasis_therapy_patient_diagnosis_3h varchar(10),
oasis_therapy_patient_diagnosis_4h varchar(10),
oasis_therapy_patient_diagnosis_1i varchar(10),
oasis_therapy_patient_diagnosis_2i varchar(10),
oasis_therapy_patient_diagnosis_2i_indicator varchar(1),
oasis_therapy_patient_diagnosis_2i_sub varchar(2),
oasis_therapy_patient_diagnosis_3i varchar(10),
oasis_therapy_patient_diagnosis_4i varchar(10),
oasis_therapy_patient_diagnosis_1j varchar(10),
oasis_therapy_patient_diagnosis_2j varchar(10),
oasis_therapy_patient_diagnosis_2j_indicator varchar(1),
oasis_therapy_patient_diagnosis_2j_sub varchar(2),
oasis_therapy_patient_diagnosis_3j varchar(10),
oasis_therapy_patient_diagnosis_4j varchar(10),
oasis_therapy_patient_diagnosis_1k varchar(10),
oasis_therapy_patient_diagnosis_2k varchar(10),
oasis_therapy_patient_diagnosis_2k_indicator varchar(1),
oasis_therapy_patient_diagnosis_2k_sub varchar(2),
oasis_therapy_patient_diagnosis_3k varchar(10),
oasis_therapy_patient_diagnosis_4k varchar(10),
oasis_therapy_patient_diagnosis_1l varchar(10),
oasis_therapy_patient_diagnosis_2l varchar(10),
oasis_therapy_patient_diagnosis_2l_indicator varchar(1),
oasis_therapy_patient_diagnosis_2l_sub varchar(2),
oasis_therapy_patient_diagnosis_3l varchar(10),
oasis_therapy_patient_diagnosis_4l varchar(10),
oasis_therapy_patient_diagnosis_1m varchar(10),
oasis_therapy_patient_diagnosis_2m varchar(10),
oasis_therapy_patient_diagnosis_2m_indicator varchar(1),
oasis_therapy_patient_diagnosis_2m_sub varchar(2),
oasis_therapy_patient_diagnosis_3m varchar(10),
oasis_therapy_patient_diagnosis_4m varchar(10),
oasis_therapy_surgical_procedure_a varchar(20),
oasis_therapy_surgical_procedure_a_date DATE,
oasis_therapy_surgical_procedure_b varchar(20),
oasis_therapy_surgical_procedure_b_date DATE,
oasis_patient_history_last_contact_date DATE,
oasis_patient_history_last_visit_date DATE,
oasis_patient_history_reason_home_health varchar(30),
oasis_patient_history_reason varchar(8),
oasis_patient_history_reason_other varchar(30),
oasis_patient_history_therapies varchar(8),
oasis_therapy_pragnosis varchar(1),
oasis_patient_history_advance_directives TEXT,
oasis_patient_history_family_informed varchar(3),
oasis_patient_history_family_informed_no varchar(30),
oasis_patient_history_risk_hospitalization varchar(14),
oasis_patient_history_previous_outcome TEXT,
oasis_patient_history_previous_outcome_cancer varchar(30),
oasis_patient_history_previous_outcome_other varchar(30),
oasis_patient_history_prior_hospitalization varchar(3),
oasis_patient_history_prior_hospitalization_no varchar(30),
oasis_patient_history_prior_hospitalization_reason varchar(100),
oasis_patient_history_immunizations varchar(10),
oasis_patient_history_immunizations_needs varchar(50),
oasis_patient_history_immunizations_needs_other varchar(30),
oasis_patient_history_allergies varchar(100),
oasis_patient_history_allergies_other varchar(30),
oasis_patient_history_overall_status varchar(2),
oasis_patient_history_risk_factors varchar(14),
oasis_therapy_safety_measures TEXT,
oasis_therapy_safety_measures_other varchar(30),
oasis_living_arrangements_situation varchar(2),
oasis_safety_emergency_planning1 varchar(1),
oasis_safety_emergency_planning2 varchar(1),
oasis_safety_emergency_planning3 varchar(1),
oasis_safety_emergency_planning4 varchar(1),
oasis_safety_emergency_planning5 varchar(1),
oasis_safety_emergency_planning6 varchar(1),
oasis_safety_emergency_planning7 varchar(1),
oasis_safety_emergency_planning8 varchar(1),
oasis_safety_oxygen_backup varchar(60),
oasis_safety_hazards TEXT,
oasis_safety_hazards_other varchar(30),
oasis_sanitation_hazards TEXT,
oasis_sanitation_hazards_other varchar(30),
oasis_primary_caregiver_name varchar(20),
oasis_primary_caregiver_relationship varchar(20),
oasis_primary_caregiver_phone varchar(20),
oasis_primary_caregiver_language varchar(50),
oasis_primary_caregiver_language_other varchar(30),
oasis_primary_caregiver_comments varchar(30),
oasis_primary_caregiver_able_care varchar(3),
oasis_primary_caregiver_no_reason varchar(30),
oasis_functional_limitations TEXT,
oasis_functional_limitations_other varchar(30),
oasis_sensory_status_vision_no varchar(2),
oasis_sensory_status_vision varchar(1),
oasis_sensory_status_vision_detail TEXT,
oasis_sensory_status_vision_detail_contact varchar(3),
oasis_sensory_status_vision_detail_prothesis varchar(3),
oasis_sensory_status_vision_site varchar(30),
oasis_sensory_status_vision_date DATE,
oasis_sensory_status_vision_detail_other varchar(30),
oasis_sensory_status_ears_no varchar(2),
oasis_sensory_status_hear varchar(2),
oasis_sensory_status_understand_verbal varchar(2),
oasis_sensory_status_hear_detail varchar(50),
oasis_sensory_status_hear_detail_hoh varchar(3),
oasis_sensory_status_hear_detail_vartigo varchar(3),
oasis_sensory_status_hear_detail_deaf varchar(3),
oasis_sensory_status_hear_detail_tinnitus varchar(3),
oasis_sensory_status_hear_detail_aid varchar(3),
oasis_sensory_status_hear_detail_other varchar(30),
oasis_sensory_status_musculoskeletal TEXT,
oasis_sensory_status_musculoskeletal_fracture varchar(30),
oasis_sensory_status_musculoskeletal_swollen varchar(30),
oasis_sensory_status_musculoskeletal_contractures varchar(30),
oasis_sensory_status_musculoskeletal_joint varchar(30),
oasis_sensory_status_musculoskeletal_location varchar(30),
oasis_sensory_status_musculoskeletal_amputation varchar(30),
oasis_sensory_status_musculoskeletal_other varchar(30),
oasis_sensory_status_nose_no varchar(2),
oasis_sensory_status_nose varchar(50),
oasis_sensory_status_nose_other varchar(30),
oasis_sensory_status_mouth_no varchar(2),
oasis_sensory_status_mouth varchar(100),
oasis_sensory_status_mouth_other varchar(30),
oasis_sensory_status_throat_no varchar(2),
oasis_sensory_status_throat varchar(60),
oasis_sensory_status_throat_other varchar(30),
oasis_sensory_status_speech varchar(1),
oasis_vital_sign_blood_pressure TEXT,
oasis_vital_sign_temperature varchar(10),
oasis_vital_sign_pulse varchar(10),
oasis_vital_sign_pulse_type varchar(50),
oasis_vital_sign_respiratory_rate varchar(10),
oasis_hw_height varchar(10),
oasis_hw_height_detail varchar(10),
oasis_hw_weight varchar(10),
oasis_hw_weight_detail varchar(10),
oasis_hw_weight_change varchar(3),
oasis_hw_weight_yes varchar(4),
oasis_hw_weight_lb varchar(10),
oasis_hw_weight_lb_in varchar(2),
oasis_pain_assessment_tool varchar(1),
oasis_pain_frequency_interfering varchar(1),
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
oasis_therapy_experiencing_pain varchar(3),
oasis_therapy_unable_to_communicate varchar(3),
oasis_therapy_non_verbal_demonstrated TEXT,
oasis_therapy_non_verbal_demonstrated_other varchar(30),
oasis_therapy_non_verbal_demonstrated_implications varchar(30),
oasis_therapy_breakthrough_medication varchar(21),
oasis_therapy_breakthrough_medication_other varchar(30),
oasis_therapy_implications_care_plan varchar(3),
oasis_therapy_fall_risk_assessment TEXT,
oasis_therapy_fall_risk_assessment_total varchar(2),
oasis_pressure_ulcer_assessment varchar(1),
oasis_pressure_ulcer_risk varchar(1),
oasis_pressure_ulcer_unhealed_s2 varchar(1),
oasis_therapy_timed_up_trial1 varchar(3),
oasis_therapy_timed_up_trial2 varchar(3),
oasis_therapy_timed_up_average varchar(10),
oasis_integumentary_status_turgur TEXT,
oasis_integumentary_status_turgur_edema varchar(30),
oasis_integumentary_status_turgur_other varchar(30),
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
oasis_therapy_heart_sounds_pacemaker varchar(30),
oasis_therapy_heart_sounds_pacemaker_date DATE,
oasis_therapy_heart_sounds_pacemaker_type varchar(30),
oasis_therapy_heart_sounds_other varchar(30),
oasis_therapy_heart_sounds_chest_pain varchar(10),
oasis_therapy_heart_sounds_associated_with varchar(10),
oasis_therapy_heart_sounds_frequency varchar(12),
oasis_therapy_heart_sounds_edema varchar(10),
oasis_therapy_heart_sounds_site varchar(12),
oasis_therapy_heart_sounds_edema_dependent varchar(12),
oasis_therapy_heart_sounds_capillary varchar(2),
oasis_therapy_heart_sounds_notify varchar(20),
oasis_therapy_respiratory_status varchar(1),
oasis_therapy_respiratory_treatment varchar(10),
oasis_elimination_status_tract_infection varchar(2),
oasis_elimination_status_urinary_incontinence varchar(1),
oasis_elimination_status_urinary_incontinence_occur varchar(1),
oasis_elimination_status_bowel_incontinence varchar(2),
oasis_elimination_status_ostomy_bowel varchar(1),

oasis_urinary_problem varchar(5) default NULL,
oasis_urinary text,
oasis_urinary_incontinence varchar(30) DEFAULT NULL,
oasis_urinary_management_strategy varchar(30) DEFAULT NULL,
oasis_urinary_diapers_other varchar(30) DEFAULT NULL,
oasis_urinary_color varchar(7) DEFAULT NULL,
oasis_urinary_color_other varchar(100) default NULL,
oasis_urinary_clarity varchar(10) default NULL,
oasis_urinary_odor varchar(5) default NULL,
oasis_urinary_catheter varchar(30) default NULL,
oasis_urinary_foley_date DATE default NULL,
oasis_urinary_foley_ml varchar(30) default NULL,
oasis_urinary_irrigation_solution varchar(30) default NULL,
oasis_urinary_irrigation_amount varchar(30) default NULL,
oasis_urinary_irrigation_ml varchar(30) default NULL,
oasis_urinary_irrigation_frequency varchar(30) default NULL,
oasis_urinary_irrigation_returns varchar(30) default NULL,
oasis_urinary_tolerated_procedure varchar(5) default NULL,
oasis_urinary_other varchar(30) default NULL,
oasis_bowels_problem varchar(5) default NULL,
oasis_bowels text,
oasis_bowel_regime varchar(30) default NULL,
oasis_bowels_lexative_enema varchar(10) default NULL,
oasis_bowels_lexative_enema_other varchar(30) default NULL,
oasis_bowels_incontinence mediumtext,
oasis_bowels_diapers_others varchar(30) default NULL,
oasis_bowels_ileostomy_site mediumtext,
oasis_bowels_ostomy_care varchar(15) default NULL,
oasis_bowels_other_site mediumtext,
oasis_bowels_urostomy mediumtext,
oasis_genitalia_problem varchar(5) default NULL,
oasis_genitalia text,
oasis_genitalia_discharge varchar(30) default NULL,
oasis_genitalia_imflammation varchar(30) default NULL,
oasis_genitalia_surgical_alteration varchar(30) default NULL,
oasis_genitalia_prostate_problem varchar(30) default NULL,
oasis_genitalia_date DATE default NULL,
oasis_genitalia_self_testicular_exam varchar(30) default NULL,
oasis_genitalia_frequency varchar(30) default NULL,
oasis_genitalia_date_last_PAP DATE default NULL,
oasis_genitalia_results varchar(30) default NULL,
oasis_genitalia_mastectomy varchar(30) default NULL,
oasis_genitalia_rl_date DATE default NULL,
oasis_genitalia_other varchar(30) default NULL,
oasis_abdomen_problem varchar(5) default NULL,
oasis_abdomen text,
oasis_abdomen_girth_inches varchar(30) default NULL,
oasis_abdomen_other varchar(30) default NULL,
oasis_ng_enteral_tube varchar(30) default NULL,
oasis_ng_enteral text,
oasis_ng_enteral_other varchar(30) default NULL,
oasis_endocrine_problem varchar(5) default NULL,
oasis_endocrine text,
oasis_endocrine_diabetes varchar(20) default NULL,
oasis_endocrine_diet varchar(30) default NULL,
oasis_endocrine_insulin varchar(30) default NULL,
oasis_endocrine_insulin_since DATE default NULL,
oasis_endocrine_admin_by varchar(10) default NULL,
oasis_endocrine_admin_by_other varchar(30) default NULL,
oasis_endocrine_monitored_by varchar(10) default NULL,
oasis_endocrine_monitored_by_other varchar(30) default NULL,
oasis_endocrine_blood_sugar_over varchar(30) default NULL,
oasis_endocrine_blood_sugar_under varchar(30) default NULL,
oasis_endocrine_renal varchar(30) default NULL,
oasis_endocrine_ophthalmic varchar(30) default NULL,
oasis_endocrine_neurologic varchar(30) default NULL,
oasis_endocrine_other varchar(30) default NULL,
oasis_endocrine_disease_management_problems varchar(30) default NULL,
oasis_endocrine_other1 varchar(30) default NULL,
oasis_endocrine_anemia varchar(30) default NULL,
oasis_endocrine_other2 varchar(30) default NULL,






oasis_nutrition_status_prob varchar(15) default NULL,
oasis_nutrition_status varchar(30) default NULL,
oasis_nutrition_status_other varchar(30) default NULL,
oasis_nutrition_requirements varchar(30) default NULL,
oasis_nutrition_appetite varchar(10) default NULL,
oasis_nutrition_eat_patt mediumtext,
oasis_nutrition_eat_patt1 text,
oasis_nutrition_eat_patt_freq varchar(30) default NULL,
oasis_nutrition_eat_patt_amt varchar(30) default NULL,

oasis_nutrition_weight_change varchar(10) default NULL,
oasis_nutrition_weight_change_value varchar(10) default NULL,

oasis_nutrition_eat_patt1_gain_time varchar(5) default NULL,
oasis_nutrition_patt1_other varchar(30) default NULL,
oasis_nutrition_req varchar(50) default NULL,
oasis_nutrition_req_other varchar(30) default NULL,
oasis_nutrition_risks text,
oasis_nutrition_risks_MD varchar(30) default NULL,
nutrition_total INT DEFAULT '0',
oasis_nutrition_describe varchar(30) default NULL,
oasis_neuro_cognitive_functioning varchar(2) default NULL,
oasis_neuro_when_confused varchar(2) default NULL,
oasis_neuro_when_anxious varchar(2) default NULL,
oasis_neuro_depression_screening varchar(2) default NULL,
oasis_neuro_little_interest varchar(2) default NULL,
oasis_neuro_feeling_down varchar(2) default NULL,
oasis_neuro_cognitive_symptoms text,
oasis_neuro_frequency_disruptive varchar(2) default NULL,
oasis_neuro_psychiatric_nursing varchar(2) default NULL,
oasis_neuro text,
oasis_neuro_location varchar(30) default NULL,
oasis_neuro_frequency varchar(30) default NULL,
oasis_neuro_unequaled_pupils varchar(15) default NULL,
oasis_neuro_aphasia varchar(15) default NULL,
oasis_neuro_motor_change varchar(20) default NULL,
oasis_neuro_dominant_side varchar(15) default NULL,
oasis_neuro_weakness varchar(20) default NULL,
oasis_neuro_weakness_location varchar(30) default NULL,
oasis_neuro_tremors varchar(10) default NULL,
oasis_neuro_handgrip_equal varchar(30) default NULL,
oasis_neuro_handgrip_unequal varchar(30) default NULL,
oasis_neuro_handgrip_strong varchar(30) default NULL,
oasis_neuro_handgrip_weak varchar(30) default NULL,
oasis_neuro_psychotropic_drug varchar(30) default NULL,
oasis_neuro_tremors_site varchar(30) default NULL,
oasis_neuro_dose_frequency varchar(30) default NULL,
oasis_neuro_other varchar(30) default NULL,
oasis_mental_status text,
oasis_mental_status_other varchar(30) default NULL,
oasis_psychosocial_edu_level varchar(30) default NULL,
oasis_psychosocial_primary_lang varchar(30) default NULL,
oasis_psychosocial text,
oasis_psychosocial_explain varchar(30) default NULL,
oasis_psychosocial_spiritual_resource varchar(30) default NULL,
oasis_psychosocial_phone_no varchar(50) default NULL,
oasis_psychosocial_treatment varchar(50) default NULL,
oasis_psychosocial_sleep_explain varchar(30) default NULL,
oasis_psychosocial_describe text,
oasis_psychosocial_comments text,



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
oasis_adl_func_self_care varchar(1) default NULL,
oasis_adl_func_ambulation varchar(1) default NULL,
oasis_adl_func_transfer varchar(1) default NULL,
oasis_adl_func_household varchar(1) default NULL,
oasis_activities_permitted text,
oasis_activities_permitted_other varchar(30) default NULL,
oasis_adl_fall_risk_assessment varchar(1) default NULL,
oasis_adl_drug_regimen varchar(2) default NULL,
oasis_adl_medication_follow_up varchar(1) default NULL,
oasis_adl_patient_caregiver varchar(2) default NULL,
oasis_adl_management_oral_medications varchar(2) default NULL,
oasis_adl_pay_for_medications varchar(5) default NULL,
oasis_adl_management_injectable_medications varchar(2) default NULL,
oasis_adl_func_oral_med varchar(2) default NULL,
oasis_adl_inject_med varchar(2) default NULL,






oasis_care_adl_assistance varchar(2) default NULL,
oasis_care_iadl_assistance varchar(2) default NULL,
oasis_care_medication_admin varchar(2) default NULL,
oasis_care_medical_procedures varchar(2) default NULL,
oasis_care_management_equip varchar(2) default NULL,
oasis_care_supervision_safety varchar(2) default NULL,
oasis_care_advocacy_facilitation varchar(2) default NULL,
oasis_care_how_often varchar(2) default NULL,
oasis_care_therapy_visits varchar(10) default NULL,
oasis_care_therapy_need_applicable varchar(2) default NULL,
oasis_care_patient_parameter varchar(2) default NULL,
oasis_care_diabetic_foot_care varchar(2) default NULL,
oasis_care_falls_prevention varchar(2) default NULL,
oasis_care_depression_intervention varchar(2) default NULL,
oasis_care_intervention_monitor varchar(2) default NULL,
oasis_care_intervention_prevent varchar(2) default NULL,
oasis_care_pressure_ulcer varchar(2) default NULL,







oasis_homebound_status text,
oasis_homebound_status_ambulation varchar(30) default NULL,
oasis_homebound_status_assist varchar(30) default NULL,
oasis_homebound_status_due_to varchar(30) default NULL,
oasis_homebound_status_other varchar(30) default NULL,
oasis_instructions_materials text,
oasis_instructions_materials_other varchar(30) default NULL,
oasis_instructions_skilled_care text,
oasis_instructions_care_coordinated text,
oasis_instructions_care_coordinated_other varchar(30) default NULL,
oasis_instructions_topic varchar(30) default NULL,
oasis_instructions_living_will varchar(5) default NULL,
oasis_instructions_copies_located varchar(50) default NULL,
oasis_instructions_bill_of_rights varchar(5) default NULL,
oasis_instructions_patient varchar(30) default NULL,
oasis_instructions_not_understand varchar(30) default NULL,
oasis_dme varchar(2) default NULL,
oasis_dme_wound_care text,
oasis_dme_wound_care_glove varchar(15) default NULL,
oasis_dme_wound_care_other varchar(30) default NULL,
oasis_dme_diabetic text,
oasis_dme_diabetic_other varchar(30) default NULL,
oasis_dme_iv_supplies text,
oasis_dme_iv_supplies_other varchar(30) default NULL,
oasis_dme_foley_supplies text,
oasis_dme_foley_supplies_other varchar(30) default NULL,
oasis_dme_urinary text,
oasis_dme_ostomy_pouch_brand varchar(30) default NULL,
oasis_dme_ostomy_pouch_size varchar(30) default NULL,
oasis_dme_ostomy_wafer_brand varchar(30) default NULL,
oasis_dme_ostomy_wafer_size varchar(30) default NULL,
oasis_dme_urinary_other varchar(30) default NULL,
oasis_dme_miscellaneous text,
oasis_dme_miscellaneous_type varchar(30) default NULL,
oasis_dme_miscellaneous_size varchar(30) default NULL,
oasis_dme_miscellaneous_other varchar(30) default NULL,
oasis_dme_supplies text,
oasis_dme_supplies_other varchar(30) default NULL,
oasis_discharge_plan text,
oasis_discharge_plan_other varchar(30) default NULL,
oasis_discharge_plan_detail text,
oasis_discharge_plan_detail_other varchar(30) default NULL,
oasis_appliances_brace varchar(30) default NULL,
oasis_appliances_equipments text,
oasis_appliances_equipments_needs text,
oasis_appliances_equipments_HME_co varchar(30) default NULL,
oasis_appliances_equipments_HME_rep varchar(30) default NULL,
oasis_appliances_equipments_phone varchar(30) default NULL,
oasis_appliances_equipments_other_organizations text,





oasis_therapy_curr_level_bed_mobility varchar(225),
oasis_therapy_curr_level_transfers varchar(225),
oasis_therapy_curr_level_wheelchair_mobility varchar(225),
oasis_therapy_curr_level_gait_status varchar(4),
oasis_therapy_curr_level_gait TEXT,
oasis_therapy_curr_level_assistive_device varchar(30),
oasis_therapy_curr_level_device_freq varchar(15),
oasis_therapy_musculoskeletal_analysis_str_l TEXT,
oasis_therapy_musculoskeletal_analysis_str_r TEXT,
oasis_therapy_musculoskeletal_analysis_rom_l TEXT,
oasis_therapy_musculoskeletal_analysis_rom_r TEXT,
oasis_therapy_musculoskeletal_analysis_pain_l TEXT,
oasis_therapy_musculoskeletal_analysis_pain_r TEXT,
oasis_therapy_curr_level_findings TEXT,
oasis_therapy_curr_level_gait_desc varchar(30),
oasis_therapy_curr_level_gait_desc_other varchar(30),
oasis_therapy_curr_level_risk_factor TEXT,
oasis_therapy_curr_level_risk_factor_other varchar(30),
oasis_therapy_curr_level_risk_factor_other_deviation TEXT,
synergy_id varchar(10)



 ) engine=MyISAM;
