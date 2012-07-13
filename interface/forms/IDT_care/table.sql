CREATE TABLE IF NOT EXISTS `forms_idt_care` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

idt_care_patient_name varchar(40),
idt_care_mr varchar(40),
idt_care_date date default NULL,
idt_care_care_coordination_involved_discipline text,
idt_care_care_coordination_involved_other text,
idt_care_care_communicated_via varchar(100),
idt_care_care_communicated_via_other text,
idt_care_topic_for_discussion text,
idt_care_topic_for_discussion_other text,
idt_care_details_of_discussion mediumtext,
idt_care_details_for_resolutions mediumtext,
idt_care_people_descipline_attending mediumtext,
idt_care_clinical_name_title_completing varchar(50)
) ENGINE=MyISAM;	
