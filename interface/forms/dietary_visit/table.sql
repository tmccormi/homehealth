CREATE TABLE IF NOT EXISTS `forms_dietary_visit` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

dietary_visit_last_name varchar(40),
dietary_visit_first_name varchar(40),
dietary_visit_visit_date date default NULL,
dietary_visit_change_dietary_status_since_last_visit text,
dietary_visit_patient_weight_lost_since_last_visit varchar(100),
dietary_visit_patient_weight_lost_since_last_visit_others text,
dietary_visit_new_factors_affecting_patient_weight varchar(20),
dietary_visit_new_affecting_factors text,
dietary_visit_assessment_summary text,
dietary_visit_treatment_plan text,
dietary_visit_rd_signature varchar(30),
dietary_visit_rd_signature_date date default NULL
) ENGINE=MyISAM;	
