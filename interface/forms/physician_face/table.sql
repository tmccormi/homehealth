CREATE TABLE IF NOT EXISTS `forms_physician_face` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,


physician_face_notes text,
physician_face_patient_name varchar(100),
physician_face_chart varchar(50),
physician_face_episode varchar(50),
physician_face_date date default NULL,
physician_face_physician_name varchar(100),
physician_face_patient_dob date default NULL,
physician_face_patient_soc date default NULL,
physician_face_patient_date varchar(100),
physician_face_medical_condition mediumtext,
physician_face_services text,
physician_face_services_other text,
physician_face_service_reason mediumtext,
physician_face_clinical_homebound_reason mediumtext

) ENGINE=MyISAM;	
