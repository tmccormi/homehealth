CREATE TABLE IF NOT EXISTS `forms_clinical_summary` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,


clinical_summary_notes text,
clinical_summary_patient_name varchar(225) DEFAULT NULL,
clinical_summary_chart varchar(225) DEFAULT NULL,
clinical_summary_episode varchar(225) DEFAULT NULL,
clinical_summary_caregiver_name varchar(225) DEFAULT NULL,
clinical_summary_visit_date date default NULL,
clinical_summary_case_manager varchar(225) DEFAULT NULL,
clinical_summary_age varchar(20) DEFAULT NULL,
clinical_summary_gender varchar(50) DEFAULT NULL,
clinical_summary_hospitalization varchar(225) DEFAULT NULL,
clinical_summary_admission_date date default NULL,
clinical_summary_hospitalization_reason text,
clinical_summary_reffered_reason text,
clinical_summary_homebound varchar(225) DEFAULT NULL,
clinical_summary_homebound_due_to text,
clinical_summary_patient_current_condition mediumtext,
clinical_summary_teaching_training mediumtext,
clinical_summary_observation_assessment mediumtext,
clinical_summary_treatment_of mediumtext,
clinical_summary_case_management mediumtext,
clinical_summary_willing_caregiver varchar(20) DEFAULT NULL,
clinical_summary_caregiver_sign varchar(225) DEFAULT NULL
) ENGINE=MyISAM;	
