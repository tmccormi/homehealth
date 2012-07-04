CREATE TABLE IF NOT EXISTS `forms_dietary_care_plan` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,


dietary_care_plan_last_name varchar(40),
dietary_care_plan_first_name varchar(40),
dietary_care_plan_visit_date date default NULL,
dietary_care_plan_dob date default NULL,
dietary_care_plan_sex varchar(10),
dietary_care_plan_weight varchar(10),
dietary_care_plan_height varchar(10),
dietary_care_plan_frequency_and_duration text,
dietary_care_plan_short_term_goals text,
dietary_care_plan_long_term_goals text,
dietary_care_plan_treatment text,
dietary_care_plan_rd_signature varchar(40),
dietary_care_plan_form_date date default NULL

) ENGINE=MyISAM;	
