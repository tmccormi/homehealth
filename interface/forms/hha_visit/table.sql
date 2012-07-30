CREATE TABLE IF NOT EXISTS `forms_hha_visit` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

hha_visit_patient_name varchar(225) DEFAULT NULL,
hha_visit_caregiver_name varchar(225) DEFAULT NULL,
hha_visit_date date default NULL,
hha_visit_time_in varchar(30) DEFAULT NULL,
hha_visit_time_out varchar(30) DEFAULT NULL,
hha_visit_employee_name varchar(225) DEFAULT NULL,
hha_visit_employee_no varchar(30) DEFAULT NULL,
hha_visit_activities mediumtext,
hha_visit_bath varchar(225) DEFAULT NULL,
hha_visit_bath_date date default NULL,
hha_visit_bed_bath varchar(225) DEFAULT NULL,
hha_visit_bed_bath_date date default NULL,
hha_visit_assist_bath varchar(225) DEFAULT NULL,
hha_visit_assist_bath_date date default NULL,
hha_visit_personal_care varchar(225) DEFAULT NULL,
hha_visit_personal_care_date date default NULL,
hha_visit_assist_with_dressing varchar(225) DEFAULT NULL,
hha_visit_assist_with_dressing_date date default NULL,
hha_visit_hair_care varchar(225) DEFAULT NULL,
hha_visit_hair_care_date date default NULL,
hha_visit_skin_care varchar(225) DEFAULT NULL,
hha_visit_skin_care_date date default NULL,
hha_visit_check_pressure_areas varchar(225) DEFAULT NULL,
hha_visit_check_pressure_areas_date date default NULL,
hha_visit_shave_groom varchar(225) DEFAULT NULL,
hha_visit_shave_groom_date date default NULL,
hha_visit_nail_hygiene varchar(225) DEFAULT NULL,
hha_visit_nail_hygiene_date date default NULL,
hha_visit_oral_care varchar(225) DEFAULT NULL,
hha_visit_oral_care_date date default NULL,
hha_visit_elimination_assist varchar(225) DEFAULT NULL,
hha_visit_elimination_assist_date date default NULL,
hha_visit_catheter_care varchar(225) DEFAULT NULL,
hha_visit_catheter_care_date date default NULL,
hha_visit_ostomy_care varchar(225) DEFAULT NULL,
hha_visit_ostomy_care_date date default NULL,
hha_visit_record varchar(225) DEFAULT NULL,
hha_visit_record_date date default NULL,
hha_visit_inspect_reinforce varchar(225) DEFAULT NULL,
hha_visit_inspect_reinforce_date date default NULL,
hha_visit_assist_with_medications varchar(225) DEFAULT NULL,
hha_visit_assist_with_medications_date date default NULL,
hha_visit_T varchar(225) DEFAULT NULL,
hha_visit_T_date date default NULL,
hha_visit_pulse varchar(225) DEFAULT NULL,
hha_visit_pulse_date date default NULL,
hha_visit_respirations varchar(225) DEFAULT NULL,
hha_visit_respirations_date date default NULL,
hha_visit_BP varchar(225) DEFAULT NULL,
hha_visit_BP_date date default NULL,
hha_visit_weight varchar(225) DEFAULT NULL,
hha_visit_weight_date date default NULL,
hha_visit_ambulation_assist varchar(225) DEFAULT NULL,
hha_visit_ambulation_assist_date date default NULL,
hha_visit_mobility_assist varchar(225) DEFAULT NULL,
hha_visit_mobility_assist_date date default NULL,
hha_visit_ROM varchar(225) DEFAULT NULL,
hha_visit_ROM_date date default NULL,
hha_visit_positioning varchar(225) DEFAULT NULL,
hha_visit_positioning_date date default NULL,
hha_visit_exercise varchar(225) DEFAULT NULL,
hha_visit_exercise_date date default NULL,
hha_visit_diet_order1 varchar(225) DEFAULT NULL,
hha_visit_diet_order varchar(225) DEFAULT NULL,
hha_visit_diet_order_date date default NULL,
hha_visit_meal_preparation varchar(225) DEFAULT NULL,
hha_visit_meal_preparation_date date default NULL,
hha_visit_assist_with_feeding varchar(225) DEFAULT NULL,
hha_visit_assist_with_feeding_date date default NULL,
hha_visit_limit_encourage_fluids varchar(225) DEFAULT NULL,
hha_visit_limit_encourage_fluids_date date default NULL,
hha_visit_grocery_shopping varchar(225) DEFAULT NULL,
hha_visit_grocery_shopping_date date default NULL,
hha_visit_wash_clothes varchar(225) DEFAULT NULL,
hha_visit_wash_clothes_date date default NULL,
hha_visit_light_housekeeping varchar(225) DEFAULT NULL,
hha_visit_light_housekeeping_date date default NULL,
hha_visit_observe_universal_precaution varchar(225) DEFAULT NULL,
hha_visit_observe_universal_precaution_date date default NULL,
hha_visit_equipment_care varchar(225) DEFAULT NULL,
hha_visit_equipment_care_date date default NULL,
hha_visit_washing_hands varchar(225) DEFAULT NULL,
hha_visit_washing_hands_date date default NULL,
hha_visit_patient_client_sign varchar(225) DEFAULT NULL,
hha_visit_patient_client_sign_date date default NULL,
hha_visit_supplies_used varchar(225) DEFAULT NULL,
hha_visit_supplies_used_data mediumtext

) ENGINE=MyISAM;	
