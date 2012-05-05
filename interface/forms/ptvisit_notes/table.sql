CREATE TABLE IF NOT EXISTS `forms_pt_visitnote` (
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
visitnote_VS_Pain_paintype varchar(40),
visitnote_VS_Pain_Intensity varchar(40),
visitnote_VS_Pain_Level varchar(40),
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
visitnote_Therapeutic_Exercises varchar(40),
visitnote_Gait_Training varchar(40),
visitnote_Bed_Mobility varchar(40),
visitnote_Training_Transfer varchar(40),
visitnote_Balance_Training_Activities varchar(40),
visitnote_Patient_Caregiver_Family_Education varchar(40),
visitnote_Assistive_Device_Training varchar(40),
visitnote_Neuro_developmental_Training varchar(40),
visitnote_Orthotics_Splinting varchar(40),
visitnote_Hip_Safety_Precaution_Training varchar(40),
visitnote_Physical_Agents varchar(40),
visitnote_Physical_Agents_For varchar(255),
visitnote_Muscle_ReEducation varchar(40),
visitnote_Safe_Stair_Climbing_Skills varchar(40),
visitnote_Exercises_to_manage_pain varchar(40),
visitnote_Fall_Precautions_Training varchar(40),
visitnote_Exercises_Safety_Techniques varchar(40),
visitnote_Other1 varchar(255),
visitnote_Specific_Training_Visit text,
visitnote_changes_in_medications varchar(30),
visitnote_FI_Mobility varchar(100), 
visitnote_FI_ROM varchar(40),
visitnote_FI_ROM_In varchar(100),
visitnote_FI_Home_Safety_Techniques varchar(40),
visitnote_FI_Home_Safety_Techniques_In varchar(100),
visitnote_FI_Assistive_Device_Usage varchar(40),
visitnote_FI_Assistive_Device_Usage_With varchar(100),
visitnote_FI_Caregiver_Family_Performance varchar(40),
visitnote_FI_Caregiver_Family_Performance_In varchar(100),
visitnote_FI_Performance_of_Home_Exercises varchar(40),
visitnote_FI_Demonstrates varchar(40),
visitnote_FI_Demonstrates_Notes varchar(100),
visitnote_FI_Other varchar(255),
visitnote_Fall_since_Last_Visit_type varchar(40),
visitnote_Timed_Up_Go_Score varchar(100),
visitnote_Interpretation varchar(100),
visitnote_Other_Tests_Scores_Interpretations varchar(255),
visitnote_Response_To_Revisit varchar(100),
visitnote_Response_To_Revisit_Other varchar(255),
visitnote_CarePlan_Reviewed varchar(100),
visitnote_Discharge_Discussed varchar(100),
visitnote_Discharge_Discussed_With varchar(100),
visitnote_CPRW_Other varchar(255),
visitnote_Careplan_Revised varchar(100),
visitnote_Careplan_Revised_Notes varchar(255),
visitnote_Further_Skilled_Visits_Required varchar(255),
visitnote_Train_patient_Suchas_Notes varchar(100),
visitnote_FSVR_IADLs_Notes varchar(255),
visitnote_FSVR_ADLs_Notes varchar(255),
visitnote_FSVR_Other varchar(255),
visitnote_Date_of_Next_Visit date,
visitnote_Plan_Type varchar(255),
visitnote_Long_Term_Outcomes_Due_To varchar(255),
visitnote_Address_Above_Issues_By varchar(255),
visitnote_Supervisory_visit varchar(255),
visitnote_Supervisory_visit_Observed varchar(100),
visitnote_Supervisory_visit_Teaching_Training varchar(100),
visitnote_Supervisory_visit_Patient_Family_Discussion varchar(100),
visitnote_Therapist_Signature varchar(255)
) ENGINE=MyISAM;