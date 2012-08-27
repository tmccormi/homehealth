CREATE TABLE IF NOT EXISTS `forms_medication_profile` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

patient_name varchar(100),
patient_mr_no varchar(100),
chart varchar(100),
episode varchar(100),
soc DATE,
patient_height varchar(100),
patient_dob DATE,
patient_weight varchar(100),
certification_period varchar(100),
diagnoses varchar(100),
allergies varchar(100),
physician_contact varchar(500),
pharmacy_name varchar(100),
pharmacy_address varchar(100),
pharmacy_phone varchar(100),
pharmacy_fax varchar(100),
medication_start_date varchar(1000),
medication_code varchar(1000),
medication_title varchar(1000),
medication_route varchar(1000),
medication_dose varchar(1000),
medication_frequency varchar(1000),
medication_purpose varchar(1000),
medication_teaching_date varchar(1000),
medication_discharge_date varchar(1000),
info_reviewed_with varchar(100),
info_reviewed_included varchar(1000),
info_reviewed_included_other varchar(100)
) engine=MyISAM;
