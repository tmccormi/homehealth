CREATE TABLE IF NOT EXISTS `forms_home_environment` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

home_environment_patient_name  varchar(100),
home_environment_SOC_date DATE,
home_environment_telephone varchar(10),
home_environment_gas_electrical varchar(10),
home_environment_smoke_alarm_condition varchar(10),
home_environment_fire_extinguisher varchar(10),
home_environment_outside_exit varchar(10),
home_environment_alternate_exit varchar(10),
home_environment_walking_pathway varchar(10),
home_environment_stairs varchar(10),
home_environment_lighting varchar(10),
home_environment_heating varchar(10),
home_environment_medicine varchar(10),
home_environment_bathroom varchar(10),
home_environment_kitchen varchar(10),
home_environment_eff_oxygen varchar(10),
home_environment_overall_sanitary varchar(10),
home_environment_sanitation_plumbing varchar(10),
home_environment_other varchar(10),
home_environment_see_additional_page varchar(50),
home_environment_action_plan_1 varchar(500),
home_environment_action_plan_2 varchar(500),
home_environment_action_plan_3 varchar(500),
home_environment_action_plan_4 varchar(500),
home_environment_action_plan_5 varchar(500),
home_environment_action_plan_6 varchar(500),
home_environment_action_plan_7 varchar(500),
home_environment_action_plan_8 varchar(500),
home_environment_action_plan_9 varchar(500),
home_environment_action_plan_10 varchar(500),
home_environment_action_plan_11 varchar(500),
home_environment_action_plan_12 varchar(500),
home_environment_action_plan_13 varchar(500),
home_environment_action_plan_14 varchar(500),
home_environment_action_plan_15 varchar(500),
home_environment_action_plan_16 varchar(500),
home_environment_action_plan_17 varchar(500),
home_environment_improve_safety varchar(500),
home_environment_improve_safety_other varchar(100),
home_environment_improve_safety_grab_bar varchar(100),
home_environment_improve_safety_smoke_alarm varchar(100),
home_environment_emergency varchar(10),
home_environment_emergency_explain varchar(100),
home_environment_person_title varchar(100),
home_environment_person_title_date DATE,
home_environment_patient_sig varchar(100),
home_environment_patient_sig_date DATE

) engine=MyISAM;