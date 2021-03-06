CREATE TABLE IF NOT EXISTS `forms_msw_evaluation` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

msw_evaluation_time_in varchar(40),
msw_evaluation_time_out varchar(40),
msw_evaluation_date date default NULL,
msw_evaluation_patient_name varchar(40),
msw_evaluation_mr varchar(40),
msw_evaluation_soc date default NULL,
msw_evaluation_homebound_reason varchar(50),
msw_evaluation_homebound_reason_in varchar(100),
msw_evaluation_homebound_reason_other varchar(100),
msw_evaluation_orders_for_evaluation varchar(40),
msw_evaluation_if_no_explain_orders varchar(100),
msw_evaluation_medical_diagnosis_problem text,
msw_evaluation_medical_diagnosis_problem_onset date default NULL,
msw_evaluation_psychosocial_history text,
msw_evaluation_prior_level_function text,
msw_evaluation_prior_caregiver_support varchar(40),
msw_evaluation_prior_caregiver_support_who varchar(40),
msw_evaluation_psychosocial varchar(40),
msw_evaluation_psychosocial_oriented varchar(40),
msw_evaluation_safety_awareness varchar(40),
msw_evaluation_safety_awareness_other text,
msw_evaluation_living_situation_support_system varchar(40),
msw_evaluation_health_factors text,
msw_evaluation_environmental_factors text,
msw_evaluation_financial_factors text,
msw_evaluation_additional_information text,
msw_evaluation_plan_ofc_are_and_discharge_was_communicated varchar(40),
msw_evaluation_plan_ofc_are_and_discharge_was_communicated_other text,
msw_evaluation_therapist_who_developed_poc varchar(40)
) ENGINE=MyISAM;	