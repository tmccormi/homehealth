CREATE TABLE IF NOT EXISTS `forms_st_visit_discharge_note` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
dischargeplan_Time_In varchar(100),
dischargeplan_Time_Out varchar(100),
dischargeplan_date date,
dischargeplan_type_of_visit varchar(50),
dischargeplan_type_of_visit_other text,
dischargeplan_Vital_Signs_Pulse varchar(30),
dischargeplan_Vital_Signs_Pulse_Type varchar(30),
dischargeplan_Vital_Signs_Temperature varchar(30),
dischargeplan_Vital_Signs_Temperature_Type varchar(30),
dischargeplan_Vital_Signs_other varchar(100),
dischargeplan_Vital_Signs_Respirations varchar(30),
dischargeplan_Vital_Signs_BP_Systolic varchar(30),
dischargeplan_Vital_Signs_BP_Diastolic varchar(30),
dischargeplan_Vital_Signs_BP_side varchar(50),
dischargeplan_Vital_Signs_BP_Position varchar(50),
dischargeplan_Vital_Signs_Sat varchar(50),
dischargeplan_Vital_Signs_Pain varchar(50),
dischargeplan_Vital_Signs_Pain_Intensity varchar(50),
dischargeplan_treatment_diagnosis_problem varchar(255),
dischargeplan_RfD_No_Further_Skilled varchar(30),
dischargeplan_RfD_Short_Term_Goals varchar(30),
dischargeplan_RfD_Long_Term_Goals varchar(30),
dischargeplan_RfD_Patient_homebound varchar(30),
dischargeplan_RfD_rehab_potential varchar(30),
dischargeplan_RfD_refused_services varchar(30),
dischargeplan_RfD_out_of_service_area varchar(30),
dischargeplan_RfD_Admitted_to_Hospital varchar(30),
dischargeplan_RfD_higher_level_of_care varchar(30),
dischargeplan_RfD_another_Agency varchar(30),
dischargeplan_RfD_Death varchar(30),
dischargeplan_RfD_Transferred_Hospice varchar(30),
dischargeplan_RfD_MD_Request varchar(30),
dischargeplan_RfD_other text,
dischargeplan_Specific_Training text, 
dischargeplan_Improved_Oral_Stage varchar(30),
dischargeplan_Improved_Oral_Stage_In varchar(255),
dischargeplan_Improved_Pharyngeal_Stage varchar(30),
dischargeplan_Improved_Pharyngeal_Stage_In varchar(255),
dischargeplan_Improved_Verbal_Expression varchar(30),
dischargeplan_Improved_Verbal_Expression_In varchar(255),
dischargeplan_Improved_Non_Verbal_Expression varchar(30),
dischargeplan_Improved_Non_Verbal_Expression_In text,
dischargeplan_Improved_Comprehension varchar(30),
dischargeplan_Improved_Comprehension_In text,
dischargeplan_Caregiver_Family_Performance varchar(30),
dischargeplan_Caregiver_Family_Performance_In text,
dischargeplan_Functional_Improvements_Other varchar(30),
dischargeplan_Functional_Improvements_Other_Note text,
dischargeplan_Functional_Improvements_Comments text,
dischargeplan_Functional_Ability_In varchar(50),
dischargeplan_Comments_Recommendations varchar(255),
dischargeplan_Followup_Recommendations text,
dischargeplan_Goals_identified_on_careplan varchar(40),
dischargeplan_Goals_notmet_explanation text,
dischargeplan_Additional_Comments text,
dischargeplan_Therapist_Signature varchar(255),
dischargeplan_md_printed_name varchar(255),
dischargeplan_md_signature varchar(255)
) engine=MyISAM;