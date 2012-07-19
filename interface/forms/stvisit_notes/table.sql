CREATE TABLE IF NOT EXISTS `forms_st_visitnote` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
visitnote_Time_In varchar(40),
visitnote_Time_Out varchar(40),
visitnote_visitdate date,
visitnote_Type_of_Visit varchar(100),
visitnote_Type_of_Visit_Other varchar(255),
visitnote_VS_Pulse varchar(40),
visitnote_VS_Pulse_type varchar(40),
visitnote_VS_Temperature varchar(40),
visitnote_VS_Temperature_type varchar(40),
visitnote_VS_Other varchar(40),
visitnote_VS_Respirations varchar(40),
visitnote_VS_BP_Systolic varchar(40),
visitnote_VS_BP_Diastolic varchar(40),
visitnote_VS_BP_side varchar(40),
visitnote_VS_BP_Position varchar(40),
visitnote_VS_BP_Sat varchar(40),
visitnote_VS_Pain varchar(40),
visitnote_VS_Pain_paintype varchar(40),
visitnote_VS_Pain_Intensity varchar(40),
visitnote_VS_Pain_Location varchar(100),
visitnote_Treatment_Diagnosis_Problem varchar(255),
visitnote_Pat_Homebound_Needs_assistance varchar(100),
visitnote_Pat_Homebound_Unable_leave_home varchar(100),
visitnote_Pat_Homebound_Medical_Restrictions varchar(100),
visitnote_Pat_Homebound_Medical_Restrictions_In varchar(100),
visitnote_Pat_Homebound_SOB_upon_exertion varchar(100),
visitnote_Pat_Homebound_Pain_with_Travel varchar(100),
visitnote_Pat_Homebound_mobility_ambulation varchar(100),
visitnote_Pat_Homebound_Arrhythmia varchar(100),
visitnote_Pat_Homebound_Bed_Bound varchar(100),
visitnote_Pat_Homebound_Residual_Weakness varchar(100),
visitnote_Pat_Homebound_Confusion varchar(100),
visitnote_Pat_Homebound_Other varchar(255),
visitnote_Interventions varchar(100),
visitnote_Interventions_Other varchar(255),
visitnote_Evaluation varchar(40),
visitnote_Dysphagia_Compensatory varchar(40),
visitnote_Swallow_Exercise varchar(40),
visitnote_Safety_Training varchar(40),
visitnote_Cognitive_Impairment varchar(40),
visitnote_Communication_Strategies varchar(40),
visitnote_Cognitive_Compensatory varchar(40),
visitnote_Patient_Caregiver_Family_Education varchar(40),
visitnote_Other1 varchar(255),
visitnote_Specific_Training_Visit text,
visitnote_changes_in_medications varchar(30),
visitnote_Improved_Oral_Stage varchar(30),
visitnote_Improved_Oral_Stage_In varchar(255),
visitnote_Improved_Pharyngeal_Stage varchar(30),
visitnote_Improved_Pharyngeal_Stage_In varchar(255),
visitnote_Improved_Verbal_Expression varchar(30),
visitnote_Improved_Verbal_Expression_In varchar(255),
visitnote_Improved_Non_Verbal_Expression varchar(30),
visitnote_Improved_Non_Verbal_Expression_In text,
visitnote_Improved_Comprehension varchar(30),
visitnote_Improved_Comprehension_In text,
visitnote_Caregiver_Family_Performance varchar(30),
visitnote_Caregiver_Family_Performance_In text,
visitnote_Functional_Improvements_Other varchar(30),
visitnote_Functional_Improvements_Other_Note text,
visitnote_FI_Additional_Comments text,
visitnote_Response_To_Visit varchar(100),
visitnote_Response_To_Visit_Other text,
visitnote_Discharge_Discussed varchar(100),
visitnote_Discharge_Discussed_With varchar(100),
visitnote_CPRW_Other varchar(255),
visitnote_CarePlan_Modifications varchar(50),
visitnote_CarePlan_Modifications_Include text,
visitnote_Further_Skilled_Visits_Required varchar(255),
visitnote_Train_patient_Suchas_Notes varchar(100),
visitnote_FSVR_Other varchar(255),
visitnote_Date_of_Next_Visit date,
visitnote_Plan_Type varchar(255),
visitnote_Long_Term_Outcomes_Due_To varchar(255),
visitnote_Address_Above_Issues_By varchar(255),
visitnote_Therapist_Signature varchar(255)
) ENGINE=MyISAM;
