CREATE TABLE IF NOT EXISTS `forms_dietary_assessment` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

dietary_assessment_last_name varchar(40),
dietary_assessment_first_name varchar(40),
dietary_assessment_visit_date date default NULL,
dietary_assessment_dob date default NULL,
dietary_assessment_sex varchar(10),
dietary_assessment_weight varchar(10),
dietary_assessment_height varchar(10),
dietary_assessment_food_intake_occurred_past3month varchar(100),
dietary_assessment_lost_weight_past3month varchar(50),
dietary_assessment_lost_weight_past3month_other text,
dietary_assessment_factors_affecting_food_intake varchar(200),
dietary_assessment_factors_affecting_food_intake_specify varchar(200),
dietary_assessment_factors_affecting_food_intake_other text,
dietary_assessment_patient_mobility_status varchar(100),
dietary_assessment_different_medications_per_day varchar(15),
dietary_assessment_pressure_ulcers_present varchar(15),
dietary_assessment_stage_ulcers varchar(15),
dietary_assessment_full_meals_per_day varchar(5),
dietary_assessment_assistance_patient_require_feed_self varchar(100),
dietary_assessment_past_food_drink text,
dietary_assessment_allergies_and_food_sensitivities text,
dietary_assessment_dietary_foods_patient_dislikes text,
dietary_assessment_assessment_summary text,
dietary_assessment_treatmentplan_recommendations text,
dietary_assessment_rd_signature varchar(30),
dietary_assessment_rd_signature_date date default NULL,
dietary_assessment_physician_signature varchar(100),
dietary_assessment_physician_signature_date date default NULL

) ENGINE=MyISAM;	