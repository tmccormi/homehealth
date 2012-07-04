CREATE TABLE IF NOT EXISTS `forms_30_day_progress_note` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

thirty_day_progress_note_patient_name varchar(40),
thirty_day_progress_note_mr varchar(40),
thirty_day_progress_note_date date default NULL,
thirty_day_progress_note_care_coordination_involved_discipline text,
thirty_day_progress_note_care_coordination_involved_other varchar(100),
thirty_day_progress_note_care_communicated_via varchar(100),
thirty_day_progress_note_care_communicated_via_other varchar(100),
thirty_day_progress_note_topic_for_discussion text,
thirty_day_progress_note_topic_for_discussion_other varchar(100),
thirty_day_progress_note_details_of_discussion mediumtext,
thirty_day_progress_note_details_for_resolutions mediumtext,
thirty_day_progress_note_people_descipline_attending mediumtext,
thirty_day_progress_note_clinical_name_title_completing varchar(50)
) ENGINE=MyISAM;	
