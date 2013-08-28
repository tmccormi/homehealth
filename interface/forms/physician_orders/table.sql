CREATE TABLE IF NOT EXISTS `forms_physician_orders` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

physician_orders_patient_name varchar(40),
physician_orders_mr varchar(40),
physician_orders_date date default NULL,
physician_orders_patient_dob date default NULL,
physician_orders_physician varchar(40),
physician_orders_diagnosis varchar(255),
physician_orders_problem varchar(50),
physician_orders_discipline text,
physician_orders_discipline_other text,
physician_orders_specific_orders mediumtext,
physician_orders_effective_date date default NULL,
physician_orders_communication text,
physician_orders_communication_other text,
physician_orders_physician_signature varchar(100),
physician_orders_date1 date default NULL

) ENGINE=MyISAM;	
