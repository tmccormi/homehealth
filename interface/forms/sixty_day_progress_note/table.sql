CREATE TABLE IF NOT EXISTS `forms_sixty_day_progress_note` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

sixty_day_progress_note_patient_name varchar(40),
sixty_day_progress_note_certification_period varchar(40),
sixty_day_progress_note_dear_dr varchar(100),
sixty_day_progress_note_patient_receiving_care_first varchar(150),
sixty_day_progress_note_patient_receiving_care_other text,
sixty_day_progress_note_diagnosis_admission text,
sixty_day_progress_note_additional_diagnosis text,
sixty_day_progress_note_decline_no_change_clinical_pblm text,
sixty_day_progress_note_decline_clinical_pblm_other text,
sixty_day_progress_note_decline_clinical_pblm_specific_details text,
sixty_day_progress_note_improvement_in_clinical_issues text,
sixty_day_progress_note_improvement_issues_other text,
sixty_day_progress_note_improvement_issues_specific_details text,
sixty_day_progress_note_living_situation_patient_lives varchar(100),
sixty_day_progress_note_living_situation_patient_lives_who varchar(50),
sixty_day_progress_note_living_situation_patient_lives_other varchar(50),
sixty_day_progress_note_living_situation_no_hur_day_why text,
sixty_day_progress_note_mental_status varchar(30),
sixty_day_progress_note_mental_status_oriented varchar(30),
sixty_day_progress_note_mental_status_disoriented varchar(30),
sixty_day_progress_note_impaired_mental_sta_req_resou varchar(30),
sixty_day_progress_note_impaired_mental_sta_req_resou_other text,
sixty_day_progress_note_patient_adl_status varchar(30),
sixty_day_progress_note_patient_adl_status_other text,
sixty_day_progress_note_ambulatory_transfer_status varchar(100),
sixty_day_progress_note_ambulatory_transfer_status_other text,
sixty_day_progress_note_communication_status varchar(150),
sixty_day_progress_note_communication_status_other text,
sixty_day_progress_note_miscellaneous_abi_hear varchar(150),
sixty_day_progress_note_miscellaneous_abis_hear_other text,
sixty_day_progress_note_miscellaneous_abi_vis varchar(150),
sixty_day_progress_note_miscellaneous_abi_hear_vis_other text,
sixty_day_progress_note_patient_needs_help_with varchar(50),
sixty_day_progress_note_patient_needs_help_with_other text,
sixty_day_progress_note_additional_information text,
sixty_day_progress_note_clinician_name_title_completing_note varchar(30)
) ENGINE=MyISAM;	