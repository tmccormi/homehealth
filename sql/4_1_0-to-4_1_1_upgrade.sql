--
--  Comment Meta Language Constructs:
--
--  #IfNotTable
--    argument: table_name
--    behavior: if the table_name does not exist,  the block will be executed

--  #IfTable
--    argument: table_name
--    behavior: if the table_name does exist, the block will be executed

--  #IfMissingColumn
--    arguments: table_name colname
--    behavior:  if the table exists but the column does not,  the block will be executed

--  #IfNotColumnType
--    arguments: table_name colname value
--    behavior:  If the table table_name does not have a column colname with a data type equal to value, then the block will be executed

--  #IfNotRow
--    arguments: table_name colname value
--    behavior:  If the table table_name does not have a row where colname = value, the block will be executed.

--  #IfNotRow2D
--    arguments: table_name colname value colname2 value2
--    behavior:  If the table table_name does not have a row where colname = value AND colname2 = value2, the block will be executed.

--  #IfNotRow3D
--    arguments: table_name colname value colname2 value2 colname3 value3
--    behavior:  If the table table_name does not have a row where colname = value AND colname2 = value2 AND colname3 = value3, the block will be executed.

--  #IfNotRow4D
--    arguments: table_name colname value colname2 value2 colname3 value3 colname4 value4
--    behavior:  If the table table_name does not have a row where colname = value AND colname2 = value2 AND colname3 = value3 AND colname4 = value4, the block will be executed.

--  #IfNotRow2Dx2
--    desc:      This is a very specialized function to allow adding items to the list_options table to avoid both redundant option_id and title in each element.
--    arguments: table_name colname value colname2 value2 colname3 value3
--    behavior:  The block will be executed if both statements below are true:
--               1) The table table_name does not have a row where colname = value AND colname2 = value2.
--               2) The table table_name does not have a row where colname = value AND colname3 = value3.

--  #IfRow2D
--    arguments: table_name colname value colname2 value2
--    behavior:  If the table table_name does have a row where colname = value AND colname2 = value2, the block will be executed.

--  #IfIndex
--    desc:      This function is most often used for dropping of indexes/keys.
--    arguments: table_name colname
--    behavior:  If the table and index exist the relevant statements are executed, otherwise not.

--  #IfNotIndex
--    desc:      This function will allow adding of indexes/keys.
--    arguments: table_name colname
--    behavior:  If the index does not exist, it will be created

--  #EndIf
--    all blocks are terminated with a #EndIf statement.


#IfNotIndex lists type
CREATE INDEX `type` ON `lists` (`type`);
#EndIf

#IfNotIndex lists pid
CREATE INDEX `pid` ON `lists` (`pid`);
#EndIf

#IfNotIndex form_vitals pid
CREATE INDEX `pid` ON `form_vitals` (`pid`);
#EndIf

#IfIndex forms pid
DROP INDEX `pid` ON `forms`;
#EndIf

#IfIndex form_encounter pid
DROP INDEX `pid` ON `form_encounter`;
#EndIf

#IfNotIndex forms pid_encounter
CREATE INDEX `pid_encounter` ON `forms` (`pid`, `encounter`);
#EndIf

#IfNotIndex form_encounter pid_encounter
CREATE INDEX `pid_encounter` ON `form_encounter` (`pid`, `encounter`);
#EndIf

#IfNotIndex immunizations patient_id
CREATE INDEX `patient_id` ON `immunizations` (`patient_id`);
#EndIf

#IfNotIndex procedure_order patient_id
CREATE INDEX `patient_id` ON `procedure_order` (`patient_id`);
#EndIf

#IfNotIndex pnotes pid
CREATE INDEX `pid` ON `pnotes` (`pid`);
#EndIf

#IfNotIndex transactions pid
CREATE INDEX `pid` ON `transactions` (`pid`);
#EndIf

#IfNotIndex extended_log patient_id
CREATE INDEX `patient_id` ON `extended_log` (`patient_id`);
#EndIf

#IfNotIndex prescriptions patient_id
CREATE INDEX `patient_id` ON `prescriptions` (`patient_id`);
#EndIf

#IfNotIndex openemr_postcalendar_events pc_eventDate
CREATE INDEX `pc_eventDate` ON `openemr_postcalendar_events` (`pc_eventDate`);
#EndIf

#IfMissingColumn version v_realpatch
ALTER TABLE `version` ADD COLUMN `v_realpatch` int(11) NOT NULL DEFAULT 0;
#EndIf

#IfMissingColumn prescriptions drug_info_erx
ALTER TABLE `prescriptions` ADD COLUMN `drug_info_erx` TEXT DEFAULT NULL;
#EndIf

#IfNotRow2D list_options list_id lists option_id nation_notes_replace_buttons
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('lists','nation_notes_replace_buttons','Nation Notes Replace Buttons',1);
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('nation_notes_replace_buttons','Yes','Yes',10);
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('nation_notes_replace_buttons','No','No',20);
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('nation_notes_replace_buttons','Normal','Normal',30);
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('nation_notes_replace_buttons','Abnormal','Abnormal',40);
#EndIf

#IfMissingColumn insurance_data policy_type
ALTER TABLE `insurance_data` ADD COLUMN `policy_type` varchar(25) NOT NULL default '';
#EndIf

#IfMissingColumn drugs max_level
ALTER TABLE drugs ADD max_level float NOT NULL DEFAULT 0.0;
ALTER TABLE drugs CHANGE reorder_point reorder_point float NOT NULL DEFAULT 0.0;
#EndIf

#IfNotTable product_warehouse
CREATE TABLE `product_warehouse` (
  `pw_drug_id`   int(11) NOT NULL,
  `pw_warehouse` varchar(31) NOT NULL,
  `pw_min_level` float       DEFAULT 0,
  `pw_max_level` float       DEFAULT 0,
  PRIMARY KEY  (`pw_drug_id`,`pw_warehouse`)
) ENGINE=MyISAM;
#EndIf

#IfNotColumnType billing modifier varchar(12)
   ALTER TABLE `billing` MODIFY `modifier` varchar(12);
   UPDATE `code_types` SET `ct_mod` = '12' where ct_key = 'CPT4' OR ct_key = 'HCPCS';
#EndIf

#IfMissingColumn billing notecodes
ALTER TABLE `billing` ADD `notecodes` varchar(25) NOT NULL default '';
#EndIf

#IfNotTable dated_reminders
CREATE TABLE `dated_reminders` (
            `dr_id` int(11) NOT NULL AUTO_INCREMENT,
            `dr_from_ID` int(11) NOT NULL,
            `dr_message_text` varchar(160) NOT NULL,
            `dr_message_sent_date` datetime NOT NULL,
            `dr_message_due_date` date NOT NULL,
            `pid` int(11) NOT NULL,
            `message_priority` tinyint(1) NOT NULL,
            `message_processed` tinyint(1) NOT NULL DEFAULT '0',
            `processed_date` timestamp NULL DEFAULT NULL,
            `dr_processed_by` int(11) NOT NULL,
            PRIMARY KEY (`dr_id`),
            KEY `dr_from_ID` (`dr_from_ID`,`dr_message_due_date`)
          ) ENGINE=MyISAM AUTO_INCREMENT=1;
#EndIf

#IfNotTable dated_reminders_link
CREATE TABLE `dated_reminders_link` (
            `dr_link_id` int(11) NOT NULL AUTO_INCREMENT,
            `dr_id` int(11) NOT NULL,
            `to_id` int(11) NOT NULL,
            PRIMARY KEY (`dr_link_id`),
            KEY `to_id` (`to_id`),
            KEY `dr_id` (`dr_id`)
          ) ENGINE=MyISAM AUTO_INCREMENT=1;
#EndIf

#IfMissingColumn x12_partners x12_gs03
ALTER TABLE `x12_partners` ADD COLUMN `x12_gs03` VARCHAR(15) NOT NULL DEFAULT '';
#EndIf

#IfNotTable payment_gateway_details
CREATE TABLE `payment_gateway_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(100) DEFAULT NULL,
  `login_id` varchar(255) DEFAULT NULL,
  `transaction_key` varchar(255) DEFAULT NULL,
  `md5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
#EndIf

#IfNotRow2D list_options list_id lists option_id payment_gateways
insert into `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) values('lists','payment_gateways','Payment Gateways','297','1','0','','');
insert into `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) values('payment_gateways','authorize_net','Authorize.net','1','0','0','','');
#EndIf

#IfNotRow2D list_options list_id payment_method option_id authorize_net
insert into `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) values('payment_method','authorize_net','Authorize.net','60','0','0','','');
#EndIf

#IfMissingColumn patient_access_offsite authorize_net_id
ALTER TABLE `patient_access_offsite` ADD COLUMN `authorize_net_id` VARCHAR(20) COMMENT 'authorize.net profile id';
#EndIf

#IfMissingColumn facility website
ALTER TABLE `facility` ADD COLUMN `website` varchar(255) default NULL;
#EndIf

#IfMissingColumn facility email
ALTER TABLE `facility` ADD COLUMN `email` varchar(255) default NULL;
#EndIf

#IfMissingColumn code_types ct_active
ALTER TABLE `code_types` ADD COLUMN `ct_active` tinyint(1) NOT NULL default 1 COMMENT '1 if this is active';
#EndIf

#IfMissingColumn code_types ct_label
ALTER TABLE `code_types` ADD COLUMN `ct_label` varchar(31) NOT NULL default '' COMMENT 'label of this code type';
UPDATE `code_types` SET ct_label = ct_key;
#EndIf

#IfMissingColumn code_types ct_external
ALTER TABLE `code_types` ADD COLUMN `ct_external` tinyint(1) NOT NULL default 0 COMMENT '0 if stored codes in codes tables, 1 or greater if codes stored in external tables';
#EndIf

#IfNotRow code_types ct_key DSMIV
DROP TABLE IF EXISTS `temp_table_one`;
CREATE TABLE `temp_table_one` (
  `id` int(11) NOT NULL DEFAULT '0',
  `seq` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM ;
INSERT INTO `temp_table_one` (`id`, `seq`) VALUES ( IF( ((SELECT MAX(`ct_id`) FROM `code_types`)>=100), ((SELECT MAX(`ct_id`) FROM `code_types`) + 1), 100 ) , IF( ((SELECT MAX(`ct_seq`) FROM `code_types`)>=100), ((SELECT MAX(`ct_seq`) FROM `code_types`) + 1), 100 )  );
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('DSMIV' , (SELECT MAX(`id`) FROM `temp_table_one`), (SELECT MAX(`seq`) FROM `temp_table_one`), 2, '', 0, 0, 0, 1, 0, 'DSMIV', 0);
DROP TABLE `temp_table_one`;
#EndIf

#IfNotRow code_types ct_key ICD10
DROP TABLE IF EXISTS `temp_table_one`;
CREATE TABLE `temp_table_one` (
  `id` int(11) NOT NULL DEFAULT '0',
  `seq` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM ;
INSERT INTO `temp_table_one` (`id`, `seq`) VALUES ( IF( ((SELECT MAX(`ct_id`) FROM `code_types`)>=100), ((SELECT MAX(`ct_id`) FROM `code_types`) + 1), 100 ) , IF( ((SELECT MAX(`ct_seq`) FROM `code_types`)>=100), ((SELECT MAX(`ct_seq`) FROM `code_types`) + 1), 100 )  );
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('ICD10' , (SELECT MAX(`id`) FROM `temp_table_one`), (SELECT MAX(`seq`) FROM `temp_table_one`), 2, '', 0, 0, 0, 1, 0, 'ICD10', 1);
DROP TABLE `temp_table_one`;
#EndIf

#IfNotRow code_types ct_key SNOMED
DROP TABLE IF EXISTS `temp_table_one`;
CREATE TABLE `temp_table_one` (
  `id` int(11) NOT NULL DEFAULT '0',
  `seq` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM ;
INSERT INTO `temp_table_one` (`id`, `seq`) VALUES ( IF( ((SELECT MAX(`ct_id`) FROM `code_types`)>=100), ((SELECT MAX(`ct_id`) FROM `code_types`) + 1), 100 ) , IF( ((SELECT MAX(`ct_seq`) FROM `code_types`)>=100), ((SELECT MAX(`ct_seq`) FROM `code_types`) + 1), 100 )  );
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('SNOMED' , (SELECT MAX(`id`) FROM `temp_table_one`), (SELECT MAX(`seq`) FROM `temp_table_one`), 2, '', 0, 0, 0, 1, 0, 'SNOMED', 2);
DROP TABLE `temp_table_one`;
#EndIf

#IfMissingColumn ar_activity code_type
ALTER TABLE `ar_activity` ADD COLUMN `code_type` varchar(12) NOT NULL DEFAULT '';
#EndIf

#IfRow2D billing code_type COPAY activity 1
DROP TABLE IF EXISTS `temp_table_one`;
CREATE TABLE `temp_table_one` (
  id             int unsigned  NOT NULL AUTO_INCREMENT,
  session_id     int unsigned  NOT NULL,
  payer_id       int(11)       NOT NULL DEFAULT 0,
  user_id        int(11)       NOT NULL,
  pay_total      decimal(12,2) NOT NULL DEFAULT 0,
  payment_type varchar( 50 ) NOT NULL DEFAULT 'patient',
  description text NOT NULL,
  adjustment_code varchar( 50 ) NOT NULL DEFAULT 'patient_payment',
  post_to_date date NOT NULL,
  patient_id int( 11 ) NOT NULL,
  payment_method varchar( 25 ) NOT NULL DEFAULT 'cash',
  pid            int(11)       NOT NULL,
  encounter      int(11)       NOT NULL,
  code_type      varchar(12)   NOT NULL DEFAULT '',
  code           varchar(9)    NOT NULL,
  modifier       varchar(5)    NOT NULL DEFAULT '',
  payer_type     int           NOT NULL DEFAULT 0,
  post_time      datetime      NOT NULL,
  post_user      int(11)       NOT NULL,
  pay_amount     decimal(12,2) NOT NULL DEFAULT 0,
  account_code varchar(15) NOT NULL DEFAULT 'PCP',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1;
INSERT INTO `temp_table_one` (`user_id`, `pay_total`, `patient_id`, `post_to_date`, `pid`, `encounter`, `post_time`, `post_user`, `pay_amount`, `description`) SELECT `user`, (`fee`*-1), `pid`, `date`, `pid`, `encounter`, `date`, `user`, (`fee`*-1), 'COPAY' FROM `billing` WHERE `code_type`='COPAY' AND `activity`!=0;
UPDATE `temp_table_one` SET `session_id`= ((SELECT MAX(session_id) FROM ar_session)+`id`);
UPDATE `billing`, `code_types`, `temp_table_one` SET temp_table_one.code_type=billing.code_type, temp_table_one.code=billing.code, temp_table_one.modifier=billing.modifier WHERE billing.code_type=code_types.ct_key AND code_types.ct_fee=1 AND temp_table_one.pid=billing.pid AND temp_table_one.encounter=billing.encounter AND billing.activity!=0;
INSERT INTO `ar_session` (`payer_id`, `user_id`, `pay_total`, `payment_type`, `description`, `patient_id`, `payment_method`, `adjustment_code`, `post_to_date`) SELECT `payer_id`, `user_id`, `pay_total`, `payment_type`, `description`, `patient_id`, `payment_method`, `adjustment_code`, `post_to_date` FROM `temp_table_one`;
INSERT INTO `ar_activity` (`pid`, `encounter`, `code_type`, `code`, `modifier`, `payer_type`, `post_time`, `post_user`, `session_id`, `pay_amount`, `account_code`) SELECT `pid`, `encounter`, `code_type`, `code`, `modifier`, `payer_type`, `post_time`, `post_user`, `session_id`, `pay_amount`, `account_code` FROM `temp_table_one`;
UPDATE `billing` SET `activity`=0 WHERE `code_type`='COPAY';
DROP TABLE IF EXISTS `temp_table_one`;
#EndIf

#IfNotTable facility_user_ids
CREATE TABLE  `facility_user_ids` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `facility_id` bigint(20) DEFAULT NULL,
  `field_id`    varchar(31)  NOT NULL COMMENT 'references layout_options.field_id',
  `field_value` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`facility_id`,`field_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;
#EndIf

#IfNotRow layout_options form_id FACUSR
INSERT INTO `layout_options` (form_id, field_id, group_name, title, seq, data_type, uor, fld_length, max_length, list_id, titlecols, datacols, default_value, edit_options, description) VALUES ('FACUSR', 'provider_id', '1General', 'Provider ID', 1, 2, 1, 15, 63, '', 1, 1, '', '', 'Provider ID at Specified Facility');
#EndIf

#IfMissingColumn patient_data ref_providerID
ALTER TABLE `patient_data` ADD COLUMN `ref_providerID` int(11) default NULL;
UPDATE `patient_data` SET `ref_providerID`=`providerID`;
INSERT INTO `layout_options` (form_id, field_id, group_name, title, seq, data_type, uor, fld_length, max_length, list_id, titlecols, datacols, default_value, edit_options, description) VALUES ('DEM', 'ref_providerID', '3Choices', 'Referring Provider', 2, 11, 1, 0, 0, '', 1, 3, '', '', 'Referring Provider');
UPDATE `layout_options` SET `description`='Provider' WHERE `form_id`='DEM' AND `field_id`='providerID';
UPDATE `layout_options` SET `seq`=(1+`seq`) WHERE `form_id`='DEM' AND `group_name` LIKE '%Choices' AND `field_id` != 'providerID' AND `field_id` != 'ref_providerID';
#EndIf

#IfMissingColumn documents couch_docid
ALTER TABLE `documents` ADD COLUMN `couch_docid` VARCHAR(100) NULL;
#EndIf

#IfMissingColumn documents couch_revid
ALTER TABLE `documents` ADD COLUMN `couch_revid` VARCHAR(100) NULL;
#EndIf

#IfMissingColumn documents storagemethod
ALTER TABLE `documents` ADD COLUMN `storagemethod` TINYINT(4) DEFAULT '0' NOT NULL COMMENT '0->Harddisk,1->CouchDB';
#EndIf

#IfNotRow2D list_options list_id lists option_id ptlistcols
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('lists','ptlistcols','Patient List Columns','1','0','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','name'      ,'Full Name'     ,'10','3','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','phone_home','Home Phone'    ,'20','3','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','ss'        ,'SSN'           ,'30','3','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','DOB'       ,'Date of Birth' ,'40','3','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','pubpid'    ,'External ID'   ,'50','3','','');
#EndIf

#IfNotRow2D code_types ct_key DSMIV ct_mod 0
UPDATE `code_types` SET `ct_mod`=0 WHERE `ct_key`='DSMIV' OR `ct_key`='ICD9' OR `ct_key`='ICD10' OR `ct_key`='SNOMED';
#EndIf

#IfMissingColumn layout_options fld_rows
ALTER TABLE `layout_options` ADD COLUMN `fld_rows` int(11) NOT NULL default '0';
UPDATE `layout_options` SET `fld_rows`=max_length WHERE `data_type`='3';
UPDATE `layout_options` SET `max_length`='0' WHERE `data_type`='3';
UPDATE `layout_options` SET `max_length`='0' WHERE `data_type`='34';
UPDATE `layout_options` SET `max_length`='20' WHERE `field_id`='financial_review' AND `form_id`='DEM';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='history_father' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='history_mother' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='history_siblings' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='history_spouse' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='history_offspring' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_cancer' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_tuberculosis' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_diabetes' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_high_blood_pressure' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_heart_problems' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_stroke' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_epilepsy' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_mental_illness' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='relatives_suicide' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='coffee' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='tobacco' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='alcohol' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='recreational_drugs' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='counseling' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='exercise_patterns' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='hazardous_activities' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='sleep_patterns' AND `form_id`='HIS';
UPDATE `layout_options` SET `max_length`='0' WHERE `field_id`='seatbelt_use' AND `form_id`='HIS';
#EndIf

#IfNotColumnType history_data usertext11 TEXT
ALTER TABLE `history_data` CHANGE `usertext11` `usertext11` TEXT NOT NULL;
#EndIf

#IfMissingColumn x12_partners x12_isa01
ALTER TABLE x12_partners ADD COLUMN x12_isa01 VARCHAR( 2 ) NOT NULL DEFAULT '00' COMMENT 'User logon Required Indicator';
#EndIf

#IfMissingColumn x12_partners x12_isa02
ALTER TABLE x12_partners ADD COLUMN x12_isa02 VARCHAR( 10 ) NOT NULL DEFAULT '          ' COMMENT 'User Logon';
#EndIf

#IfMissingColumn x12_partners x12_isa03
ALTER TABLE x12_partners ADD COLUMN x12_isa03 VARCHAR( 2 ) NOT NULL DEFAULT '00' COMMENT 'User password required Indicator';
#EndIf

#IfMissingColumn x12_partners x12_isa04
ALTER TABLE x12_partners ADD COLUMN x12_isa04 VARCHAR( 10 ) NOT NULL DEFAULT '          ' COMMENT 'User Password';
#EndIf

#IfMissingColumn codes financial_reporting
ALTER TABLE `codes` ADD COLUMN `financial_reporting` TINYINT(1) DEFAULT 0 COMMENT '0 = negative, 1 = considered important code in financial reporting';
#EndIf

#IfNotRow2D list_options list_id lists option_id Branch
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('lists', 'Branch', 'Branch', 222, 1, 0, '', '');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('Branch', 'N', 'N', 1, 0, 0, '', '');
#EndIf

#IfNotRow2D list_options list_id lists option_id Branch_State
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('lists', 'Branch_State', 'Branch State', 223, 1, 0, '', '');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('Branch_State', 'NY', 'New York', 2, 0, 0, '', '');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('Branch_State', 'CA', 'California', 1, 0, 0, '', '');
#EndIf

#IfNotTable oasis_pdf
CREATE TABLE `oasis_pdf` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `pid` int(10) NOT NULL,
  `encounter` int(11) NOT NULL,
  `form_name` varchar(100) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `form_id` int(10) NOT NULL,
  `b1_string` text NOT NULL,
  `generated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `analyse` varchar(50) NOT NULL,
  `analyse_pdf` varchar(50) NOT NULL,
  `filename` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
#EndIf

#IfNotTable eSignatures
CREATE TABLE `eSignatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT 'Table row ID for signature',
  `table` varchar(255) NOT NULL COMMENT 'table name for the signature',
  `uid` int(11) NOT NULL COMMENT 'user id for the signing user',
  `datetime` datetime NOT NULL COMMENT 'datetime of the signature action',
  `signed` int(11) NOT NULL DEFAULT '0' COMMENT '0 or not 0 - reflects signature record signed/not signed/ or signed with some exception to be determined. ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
#EndIf




#IfMissingColumn patient_data soc
ALTER TABLE patient_data ADD soc DATE DEFAULT NULL, ADD attending_physician varchar(225), ADD age INT(5) DEFAULT 0, ADD primary_referal_source varchar(225), ADD area_director INT(11) DEFAULT 0, ADD case_manager INT(11) DEFAULT 0;
#EndIf


#IfNotRow2D list_options list_id ptlistcols option_id soc
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','soc','SOC','11',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','address','Address','31',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','age','Age','41',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','sex','Sex','51',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','attending_physician','Attending Physician','60',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','area_director1','Area Director','61',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','case_manager1','Case Manager','62',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','primary_referal_source','Primary Referal Source','63',0,0,'','');
#EndIf



#IfNotRow2D list_options list_id abook_type option_id hospital
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','hospital','Hospital','40',0,1,'','');
#EndIf

#IfNotRow2D layout_options form_id DEM group_name 7Hospitalization
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_name', '7Hospitalization', 'Hospital', '1','36','1','0','0','','1','3','','','Hospital','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_phone', '7Hospitalization', 'Phone #', '2','2','1','20','63','','1','3','','1','Hospital Phone Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_address', '7Hospitalization', 'Address', '3','2','1','20','225','','1','3','','1','Hospital Address','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_city', '7Hospitalization', 'City', '4','2','1','20','63','','1','3','','1','Hospital City','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_state', '7Hospitalization', 'State', '5','2','1','20','63','','1','3','','1','Hospital State','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_zip', '7Hospitalization', 'Zip Code', '6','2','1','20','63','','1','3','','1','Hospital Zip Code','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_admit_date', '7Hospitalization', 'Admit Date', '7','4','1','10','10','','1','3','','D','Hospital Admit Date','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_dc_date', '7Hospitalization', 'D/C Date', '8','4','1','10','10','','1','3','','D','Hospital D/C Date','0');
#EndIf

#IfMissingColumn patient_data hospital_name
ALTER TABLE patient_data ADD hospital_name varchar(100), ADD hospital_phone varchar(50), ADD hospital_address varchar(100), ADD hospital_city varchar(20), ADD hospital_state varchar(20), ADD hospital_zip varchar(10), ADD hospital_admit_date DATE DEFAULT NULL, ADD hospital_dc_date DATE DEFAULT NULL;
#EndIf


#IfNotRow2D list_options list_id abook_type option_id agency
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','agency','Agency','45',0,1,'','');
#EndIf

#IfNotRow2D layout_options form_id DEM group_name 8Agency
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_name', '8Agency', 'Agency Name', '1','37','1','0','0','','1','3','','','Agency','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_rate', '8Agency', 'Rate', '2','2','1','11','11','','1','3','','','Agency Rate','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_address', '8Agency', 'Address', '3','2','1','20','225','','1','3','','1','Agency Address','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_city', '8Agency', 'City', '4','2','1','20','63','','1','3','','1','Agency City','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_state', '8Agency', 'State', '5','2','1','20','63','','1','3','','1','Agency State','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_zip', '8Agency', 'Zip Code', '6','2','1','20','63','','1','3','','1','Agency Zip Code','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_phone', '8Agency', 'Phone', '7','2','1','20','63','','1','3','','1','Agency Phone Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_fax', '8Agency', 'Fax', '8','2','1','20','63','','1','3','','1','Agency Fax Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_email', '8Agency', 'Email', '9','2','1','20','63','','1','3','','1','Agency Email','0');
#EndIf


#IfMissingColumn patient_data agency_name
ALTER TABLE patient_data ADD agency_name varchar(100), ADD agency_rate varchar(100), ADD agency_address varchar(100), ADD agency_city varchar(20), ADD agency_state varchar(20), ADD agency_zip varchar(10), ADD agency_phone varchar(50), ADD agency_fax varchar(50), ADD agency_email varchar(100);
#EndIf


#IfNotRow2D list_options list_id abook_type option_id referring_physician
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','referring_physician','Referring Physician','50',0,1,'','');
#EndIf

#IfNotRow2D layout_options form_id DEM group_name 9Referral
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_date', '9Referral', 'Referral Date', '1','4','1','10','10','','1','3','','D','Referral Date','0');
UPDATE `layout_options` SET `group_name` = '9Referral',
`title` = 'Referrer' WHERE CONVERT( `layout_options`.`form_id` USING utf8 ) = 'DEM' AND CONVERT( `layout_options`.`field_id` USING utf8 ) = 'ref_providerID' AND `layout_options`.`seq` =2 LIMIT 1 ;
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_fname', '9Referral', 'Referrer First Name', '4','2','1','20','63','','1','3','','1','Referrer First Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_lname', '9Referral', 'Referrer Last Name', '4','2','1','20','63','','1','3','','1','Referrer Last Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_company_name', '9Referral', 'Referrer Company Name', '5','2','1','20','63','','1','3','','1','Referrer Company Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_phone_no', '9Referral', 'Phone', '6','2','1','20','63','','1','3','','1','Referrer Phone Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_fax_no', '9Referral', 'Fax', '7','2','1','20','63','','1','3','','1','Referrer Fax Number','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_source_facility_name', '9Referral', 'Facility Name', '9','27','1','5','225','facility_name','1','3','','','Facility Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_source_phone_no', '9Referral', 'Phone', '10','2','1','20','63','','1','3','','','Referral Source Phone Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_source_fax', '9Referral', 'Fax', '11','2','1','20','63','','1','3','','','Referral Source Fax Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_source_protocol', '9Referral', 'Protocol', '12','2','1','20','63','','1','3','','','Referral Source Protocol','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_admission_source', '9Referral', 'Admission Source', '13','2','1','20','63','','1','3','','','Referral Source Admission Source','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_taken_by', '9Referral', 'Referral Taken By', '14','2','1','20','63','','1','3','','','Referral Taken By','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_reason_not_visited', '9Referral', 'Reason If not visited within 48 hours', '15','2','1','20','63','','1','3','','','Reason If not visited within 48 hours','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_comments', '9Referral', 'Comments', '16','2','1','20','63','','1','3','','','Comments by Referral','0');
#EndIf


#IfNotRow2D list_options list_id lists option_id facility_name
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'facility_name', 'Facility Name', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'hospital', 'Hospital', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'alf', 'ALF', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'snf', 'SNF', '3', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'md', 'MD', '4', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'infusion_co', 'Infusion Co', '5', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'rehab', 'Rehab', '6', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'clinic', 'Clinic', '7', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'acute_care_facility', 'Acute Care Facility', '8', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('facility_name', 'other', 'Other', '9', '0', '1', '', '');
#EndIf

#IfMissingColumn patient_data referral_date
ALTER TABLE patient_data ADD referral_date DATE DEFAULT NULL, ADD referral_fname varchar(100), ADD referral_lname varchar(100), ADD referral_company_name varchar(100), ADD referral_phone_no varchar(50), ADD referral_fax_no varchar(50), ADD referral_source_facility_name varchar(100), ADD referral_source_phone_no varchar(50), ADD referral_source_fax varchar(50), ADD referral_source_protocol varchar(100), ADD referral_admission_source varchar(100), ADD referral_taken_by varchar(100), ADD referral_reason_not_visited varchar(100), ADD referral_comments varchar(225);
#EndIf



#IfNotRow2D layout_options form_id DEM group_name 9Physician(s)
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_first_name', '9Physician(s)', 'Physician First Name', '2','2','1','20','63','','1','3','','1','Physician First Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_last_name', '9Physician(s)', 'Physician Last Name', '3','2','1','20','63','','1','3','','1','Physician Last Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'pecos_status', '9Physician(s)', 'Pecos Status', '4','2','1','20','63','','1','3','','','Pecos Status','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_upin', '9Physician(s)', 'UPIN #', '5','2','1','20','63','','1','3','','1','Physician UPIN Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_npi', '9Physician(s)', 'NPI #', '6','2','1','20','63','','1','3','','1','Physician NPI Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_address', '9Physician(s)', 'Address', '7','2','1','20','225','','1','3','','1','Physician Address','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_city', '9Physician(s)', 'City', '8','2','1','20','63','','1','3','','1','Physician City','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_state', '9Physician(s)', 'State', '9','2','1','20','63','','1','3','','1','Physician State','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_zip', '9Physician(s)', 'Zip Code', '10','2','1','20','63','','1','3','','1','Physician Zip Code','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_phone', '9Physician(s)', 'Phone', '11','2','1','20','63','','1','3','','1','Physician Phone','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'physician_fax', '9Physician(s)', 'Fax', '12','2','1','20','63','','1','5','','1','Physician Fax','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'other_physician', '9Physician(s)', 'Other Physician', '13','39','1','20','63','','1','3','','1','Other Physician','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_fname', '9Physician(s)', 'Physician First Name', '14','2','1','20','63','','1','3','','1','Other Physician First Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_lname', '9Physician(s)', 'Physician Last Name', '15','2','1','20','63','','1','3','','1','Other Physician Last Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_pecos_status', '9Physician(s)', 'Pecos Status', '16','2','1','20','63','','1','3','','','Other Pecos Status','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_upin', '9Physician(s)', 'UPIN #', '17','2','1','20','63','','1','3','','1','Other Physician UPIN Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_npi', '9Physician(s)', 'NPI #', '18','2','1','20','63','','1','3','','1','Other Physician NPI Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_address', '9Physician(s)', 'Address', '19','2','1','20','225','','1','3','','1','Other Physician Address','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_city', '9Physician(s)', 'City', '20','2','1','20','63','','1','3','','1','Other Physician City','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_state', '9Physician(s)', 'State', '21','2','1','20','63','','1','3','','1','Other Physician State','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_zip', '9Physician(s)', 'Zip Code', '22','2','1','20','63','','1','3','','1','Other Physician Zip Code','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_phone', '9Physician(s)', 'Phone', '23','2','1','20','63','','1','3','','1','Other Physician Phone','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_fax', '9Physician(s)', 'Fax', '24','2','1','20','63','','1','5','','1','Other Physician Fax','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'otphy_comments', '9Physician(s)', 'Comments', '25','2','1','20','63','','1','3','','','Other Physician Comments','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attending_physician1', '9Physician(s)', 'Attending Physician', '26','39','1','20','63','','1','3','','1','Attending Physician','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_fname', '9Physician(s)', 'Physician First Name', '27','2','1','20','63','','1','3','','1','Attending Physician First Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_lname', '9Physician(s)', 'Physician Last Name', '28','2','1','20','63','','1','3','','1','Attending Physician Last Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_pecos_status', '9Physician(s)', 'Pecos Status', '29','2','1','20','63','','1','3','','','Attending Pecos Status','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_upin', '9Physician(s)', 'UPIN #', '30','2','1','20','63','','1','3','','1','Attending Physician UPIN Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_npi', '9Physician(s)', 'NPI #', '31','2','1','20','63','','1','3','','1','Attending Physician NPI Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_address', '9Physician(s)', 'Address', '32','2','1','20','225','','1','3','','1','Attending Physician Address','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_city', '9Physician(s)', 'City', '33','2','1','20','63','','1','3','','1','Attending Physician City','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_state', '9Physician(s)', 'State', '34','2','1','20','63','','1','3','','1','Attending Physician State','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_zip', '9Physician(s)', 'Zip Code', '35','2','1','20','63','','1','3','','1','Attending Physician Zip Code','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_phone', '9Physician(s)', 'Phone', '36','2','1','20','63','','1','3','','1','Attending Physician Phone','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_fax', '9Physician(s)', 'Fax', '37','2','1','20','63','','1','5','','1','Attending Physician Fax','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attphy_comments', '9Physician(s)', 'Comments', '38','2','1','20','63','','1','3','','','Attending Physician Comments','0');
#EndIf


#IfNotRow2D list_options list_id abook_type option_id physician
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','physician','Physician','55',0,1,'','');
UPDATE `layout_options` SET `group_name` = '9Physician(s)',
`title` = 'Primary Referring Physician' WHERE CONVERT( `layout_options`.`form_id` USING utf8 ) = 'DEM' AND CONVERT( `layout_options`.`field_id` USING utf8 ) = 'providerID' AND `layout_options`.`seq` =1 LIMIT 1 ;
#EndIf


#IfNotRow2D layout_options field_id other_physician data_type 39
UPDATE layout_options SET data_type=39, fld_length=20 WHERE field_id='other_physician';
#EndIf

#IfNotRow2D layout_options field_id attending_physician1 data_type 39
UPDATE layout_options SET data_type=39, fld_length=20 WHERE field_id='attending_physician1';
#EndIf

#IfNotRow2D layout_options field_id hospital_name data_type 36
UPDATE layout_options SET data_type=36 WHERE field_id='hospital_name';
#EndIf

#IfNotRow2D layout_options field_id agency_name data_type 37
UPDATE layout_options SET data_type=37 WHERE field_id='agency_name';
#EndIf


#IfNotRow2D layout_options field_id providerID group_name 3Choices
UPDATE layout_options SET group_name="3Choices", seq=1, title="Provider" WHERE field_id="providerID";
#EndIf

#IfNotRow2D layout_options field_id ref_providerID group_name 9Referral
UPDATE layout_options SET group_name="9Referral", seq=2, description="Internal Referrer" WHERE field_id="ref_providerID";
#EndIf


#IfNotRow2D layout_options field_id primary_ref_physician group_name 9Physician(s)
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'primary_ref_physician', '9Physician(s)', 'Primary Referring Physician', '1','39','1','20','63','','1','3','','1','Primary Referring Physician','0');
#EndIf

#IfNotRow2D layout_options field_id primary_ref_physician data_type 39
UPDATE layout_options SET data_type=39, fld_length=20 WHERE field_id='primary_ref_physician';
#EndIf

#IfNotRow2D layout_options field_id attending_physician1 group_name 9Physician(s)
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'attending_physician1', '9Physician(s)', 'Attending Physician', '26','39','1','20','63','','1','3','','1','Attending Physician','0');
#EndIf

#IfMissingColumn patient_data primary_ref_physician
ALTER TABLE patient_data ADD primary_ref_physician varchar(100);
#EndIf


#IfMissingColumn patient_data physician_first_name
ALTER TABLE patient_data ADD physician_first_name varchar(100), ADD physician_last_name varchar(100), ADD pecos_status varchar(100), ADD physician_upin varchar(20), ADD physician_npi varchar(20), ADD physician_address varchar(225), ADD physician_city varchar(20), ADD physician_state varchar(20), ADD physician_zip varchar(50), ADD physician_phone varchar(50), ADD physician_fax varchar(50), ADD other_physician varchar(100), ADD otphy_fname varchar(100), ADD otphy_lname varchar(100), ADD otphy_pecos_status varchar(100), ADD otphy_upin varchar(20), ADD otphy_npi varchar(20), ADD otphy_address varchar(225), ADD otphy_city varchar(20), ADD otphy_state varchar(20), ADD otphy_zip varchar(10), ADD otphy_phone varchar(50), ADD otphy_fax varchar(50), ADD otphy_comments varchar(225), ADD attending_physician1 varchar(100), ADD attphy_fname varchar(100), ADD attphy_lname varchar(100), ADD attphy_pecos_status varchar(100), ADD attphy_upin varchar(10), ADD attphy_npi varchar(10), ADD attphy_address varchar(225), ADD attphy_city varchar(20), ADD attphy_state varchar(20), ADD attphy_zip varchar(20), ADD attphy_phone varchar(50), ADD attphy_fax varchar(50), ADD attphy_comments varchar(225);
#EndIf


#IfNotRow2D list_options list_id abook_type option_id outside_case_manager
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','outside_case_manager','Outside Case Manager','60',0,1,'','');
#EndIf


#IfNotRow2D layout_options field_id referral_source group_name 9Referral
UPDATE layout_options SET group_name='9Referral', seq=8, datacols=3, edit_options=1 WHERE field_id='referral_source';
DELETE FROM layout_options WHERE field_id='referral_source1';
DELETE FROM list_options WHERE option_id='referral_source1';
#EndIf


#IfNotRow2D list_options list_id lists option_id admit_status
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'admit_status', 'Admit Status', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('admit_status', 'pre_admit', 'Pre-Admit', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('admit_status', 'admit', 'Admit', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('admit_status', 'discharge', 'Discharge', '3', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('admit_status', 'non_admit', 'Non-Admit', '4', '0', '1', '', '');
#EndIf



#IfNotRow2D layout_options field_id primary_ref_physician group_name 9Physician(s)
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'primary_ref_physician', '9Physician(s)', 'Primary Referring Physician', '1','39','1','20','63','','1','3','','1','Primary Referring Physician','0');
#EndIf

#IfNotRow2D layout_options field_id admit_status group_name 1Patient Info
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ('DEM', 'admit_status', '1Patient Info', 'Admit Status', 30, 1, 1, 0, 0, 'admit_status', 1, 3, '', '', 'Admit Status', 0);
DELETE FROM layout_options WHERE field_id='admit_status' AND group_name='7Hospitalization';
#EndIf



#IfNotRow2D layout_options field_id hospital_admit_date seq 8
UPDATE layout_options SET seq=8 WHERE field_id='hospital_admit_date';
#EndIf

#IfNotRow2D layout_options field_id hospital_dc_date seq 9
UPDATE layout_options SET seq=9 WHERE field_id='hospital_dc_date';
#EndIf

#IfMissingColumn patient_data admit_status
ALTER TABLE patient_data ADD admit_status varchar(100);
#EndIf

#IfNotRow2D layout_options form_id DEM field_id area_director
INSERT INTO `layout_options` (`form_id` ,`field_id` ,`group_name` ,`title` ,`seq` ,`data_type` ,`uor` ,`fld_length` ,`max_length` ,`list_id` ,`titlecols` ,`datacols` ,`default_value` ,`edit_options` ,`description` ,`fld_rows`)VALUES ('DEM', 'area_director', '6Misc', 'Area Director', '19', '10', '1', '0', '0', '', '1', '3', '', '', 'Area Director', '0');
#EndIf


#IfNotRow2D layout_options form_id DEM field_id case_manager
INSERT INTO `layout_options` (`form_id` ,`field_id` ,`group_name` ,`title` ,`seq` ,`data_type` ,`uor` ,`fld_length` ,`max_length` ,`list_id` ,`titlecols` ,`datacols` ,`default_value` ,`edit_options` ,`description` ,`fld_rows`)VALUES ('DEM', 'case_manager', '6Misc', 'Case Manager', '20', '11', '1', '0', '0', '', '1', '3', '', '', 'Case Manager', '0');
#EndIf


#IfNotRow2D layout_options form_id DEM group_name 1Patient Info
UPDATE layout_options SET group_name="1Patient Info" WHERE group_name="1Who" OR group_name="2Contact";
UPDATE layout_options SET seq=17 WHERE title="Address" AND group_name="1Patient Info";
UPDATE layout_options SET seq=18 WHERE title="City" AND group_name="1Patient Info";
UPDATE layout_options SET seq=19 WHERE title="State" AND group_name="1Patient Info";
UPDATE layout_options SET seq=20 WHERE title="Postal Code" AND group_name="1Patient Info";
UPDATE layout_options SET seq=21 WHERE title="Country" AND group_name="1Patient Info";
UPDATE layout_options SET seq=22 WHERE title="Mother's Name" AND group_name="1Patient Info";
UPDATE layout_options SET seq=23 WHERE title="Guardian's Name" AND group_name="1Patient Info";
UPDATE layout_options SET seq=24 WHERE title="Emergency Contact" AND group_name="1Patient Info";
UPDATE layout_options SET seq=25 WHERE title="Emergency Phone" AND group_name="1Patient Info";
UPDATE layout_options SET seq=26 WHERE title="Home Phone" AND group_name="1Patient Info";
UPDATE layout_options SET seq=27 WHERE title="Work Phone" AND group_name="1Patient Info";
UPDATE layout_options SET seq=28 WHERE title="Mobile Phone" AND group_name="1Patient Info";
UPDATE layout_options SET seq=29 WHERE title="Contact Email" AND group_name="1Patient Info";
#EndIf


#IfNotRow2D layout_options field_id ref_providerID data_type 41
UPDATE layout_options SET title="Internal Referrer",data_type=41 WHERE field_id="ref_providerID";
#EndIf

#IfNotRow2D list_options list_id abook_type option_id internal_referrer
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','internal_referrer','Internal Referrer','70',0,1,'','');
#EndIf




#IfNotRow2D registry state 0 directory oasis_nursing_resumption
UPDATE registry SET name='HHA Referral', category='Skilled Nursing' WHERE name='Home Health Aide';
UPDATE registry SET category='Skilled Nursing' WHERE name='HHA Visit Note';
UPDATE registry SET category='Skilled Nursing' WHERE name='Clinical Summary';
UPDATE registry SET name='HHA-Supervisor Visit' WHERE name='Supervisor Visit of Home Health Staff';
UPDATE registry SET state=0, category='' WHERE category='Administrative';
UPDATE registry SET category='' WHERE name='Vitals';
UPDATE registry SET category='' WHERE category='Clinical';
UPDATE registry SET category='MSW' WHERE category='Medsocialworker';
UPDATE registry SET name='OASIS_C' WHERE directory='OASIS_C';
UPDATE registry SET name='OASIS SOC/ROC-PT' WHERE directory='oasis_pt_soc';
UPDATE registry SET name='OASIS SOC/ROC-Nursing' WHERE directory='oasis_nursing_soc';
UPDATE registry SET name='OASIS Recert-Nursing' WHERE directory='oasis_c_nurse';
UPDATE registry SET name='OASIS-C Transfer' WHERE directory='oasis_transfer';
UPDATE registry SET name='OASIS Nursing Resumptions' WHERE directory='oasis_nursing_resumption';
UPDATE registry SET name='OASIS Discharge' WHERE directory='oasis_discharge';
UPDATE registry SET name='OASIS Recert-PT' WHERE directory='oasis_therapy_rectification';
UPDATE registry SET name='OASIS Therapy Resumption' WHERE directory='oasis_therapy_resumption';
UPDATE registry SET name='Non-OASIS Discharge Assessment',category='' WHERE directory='non_oasis';
UPDATE registry SET name='OASIS_C' WHERE directory='OASIS_C';
UPDATE registry SET category='Skilled Nursing' WHERE directory='oasis_adult_assessment';
UPDATE registry SET state=0 WHERE directory='oasis_nursing_resumption';
UPDATE registry SET state=0 WHERE directory='oasis_therapy_resumption';
UPDATE registry SET state=0 WHERE directory='OASIS_C';
UPDATE registry SET category='' WHERE category='Progress Notes';
UPDATE registry SET category='Skilled Nursing' WHERE directory='discharge_summary';
UPDATE registry SET category='Skilled Nursing' WHERE directory='IDT_care';
#EndIf




#IfNotRow2D layout_options field_id providerID data_type 42
UPDATE layout_options SET data_type=42 WHERE field_id="providerID";
#EndIf




#IfNotRow gacl_aro_groups value phytherapist
UPDATE gacl_aro_groups_id_seq SET id=id+1;
UPDATE gacl_acl_seq SET id=id+1;
INSERT INTO gacl_aro_groups (id, parent_id, lft, rgt, name, value) SELECT (SELECT id FROM gacl_aro_groups_id_seq), 12, MAX(lft)+2, MAX(rgt)+2, 'Physical Therapist', 'phytherapist' FROM gacl_aro_groups;
CREATE TEMPORARY TABLE max_rgt (SELECT MAX(rgt) AS rgt FROM gacl_aro_groups);
UPDATE gacl_aro_groups SET rgt=(SELECT rgt FROM max_rgt)+1 WHERE parent_id=0;
DROP TABLE max_rgt;

INSERT INTO gacl_acl (id,section_value,allow,enabled,return_value,note,updated_date) VALUES((SELECT id FROM gacl_acl_seq),'system',1,1,'write','Things that sub clinicians can read and modify',UNIX_TIMESTAMP(NOW()));
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','notes');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','relaxed');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','demo');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','docs');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','med');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','notes');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'sensitivities','normal');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'admin','drugs');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','coding');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','appt');
INSERT INTO gacl_aro_groups_map (acl_id,group_id) VALUES ((SELECT id FROM gacl_acl_seq),(SELECT id FROM gacl_aro_groups_id_seq));
#EndIf

#IfNotRow gacl_aro_groups value sptherapist
UPDATE gacl_aro_groups_id_seq SET id=id+1;
UPDATE gacl_acl_seq SET id=id+1;
INSERT INTO gacl_aro_groups (id, parent_id, lft, rgt, name, value) SELECT (SELECT id FROM gacl_aro_groups_id_seq), 12, MAX(lft)+2, MAX(rgt)+2, 'Speech Therapist', 'sptherapist' FROM gacl_aro_groups;
CREATE TEMPORARY TABLE max_rgt (SELECT MAX(rgt) AS rgt FROM gacl_aro_groups);
UPDATE gacl_aro_groups SET rgt=(SELECT rgt FROM max_rgt)+1 WHERE parent_id=0;
DROP TABLE max_rgt;

INSERT INTO gacl_acl (id,section_value,allow,enabled,return_value,note,updated_date) VALUES((SELECT id FROM gacl_acl_seq),'system',1,1,'write','Things that sub clinicians can read and modify',UNIX_TIMESTAMP(NOW()));
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','notes');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','relaxed');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','demo');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','docs');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','med');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','notes');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'sensitivities','normal');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'admin','drugs');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','coding');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','appt');
INSERT INTO gacl_aro_groups_map (acl_id,group_id) VALUES ((SELECT id FROM gacl_acl_seq),(SELECT id FROM gacl_aro_groups_id_seq));
#EndIf

#IfNotRow gacl_aro_groups value nurse
UPDATE gacl_aro_groups_id_seq SET id=id+1;
UPDATE gacl_acl_seq SET id=id+1;
INSERT INTO gacl_aro_groups (id, parent_id, lft, rgt, name, value) SELECT (SELECT id FROM gacl_aro_groups_id_seq), 12, MAX(lft)+2, MAX(rgt)+2, 'Nurse', 'nurse' FROM gacl_aro_groups;
CREATE TEMPORARY TABLE max_rgt (SELECT MAX(rgt) AS rgt FROM gacl_aro_groups);
UPDATE gacl_aro_groups SET rgt=(SELECT rgt FROM max_rgt)+1 WHERE parent_id=0;
DROP TABLE max_rgt;

INSERT INTO gacl_acl (id,section_value,allow,enabled,return_value,note,updated_date) VALUES((SELECT id FROM gacl_acl_seq),'system',1,1,'write','Things that sub clinicians can read and modify',UNIX_TIMESTAMP(NOW()));
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','notes');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','relaxed');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','demo');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','docs');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','med');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','notes');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'sensitivities','normal');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'admin','drugs');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'encounters','coding');
INSERT INTO gacl_aco_map (acl_id,section_value,value) VALUES ((SELECT id FROM gacl_acl_seq),'patients','appt');
INSERT INTO gacl_aro_groups_map (acl_id,group_id) VALUES ((SELECT id FROM gacl_acl_seq),(SELECT id FROM gacl_aro_groups_id_seq));
#EndIf


#IfNotTable episodes
CREATE TABLE `episodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `updatedate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `episode_number` TINYINT NOT NULL,
  `description` varchar(60) DEFAULT NULL,
  `episode_start_date` DATE DEFAULT NULL,
  `episode_length` TINYINT DEFAULT 60,
  `episode_end_date` DATE DEFAULT NULL,
  `admit_status` varchar(30) DEFAULT NULL,
  `active` varchar(10) DEFAULT NULL,
  `reminder` varchar(10) DEFAULT NULL,
  `pid` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
#EndIf


#IfNotTable episode_num
CREATE TABLE `episode_num` (
  `id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO episode_num VALUES();
#EndIf

#IfMissingColumn form_encounter episode_id
ALTER TABLE form_encounter ADD episode_id int(11);
#EndIf

#IfMissingColumn dated_reminders episode_id
ALTER TABLE dated_reminders ADD episode_id int(11) DEFAULT NULL;
#EndIf



#IfNotRow2D layout_options field_id medicare_number group_name 1Patient Info
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'medicare_number', '1Patient Info', 'Medicare Number', '31','2','1','20','63','','1','1','','','Medicare Number','0');
#EndIf

#IfMissingColumn patient_data medicare_number
ALTER TABLE patient_data ADD medicare_number varchar(10);
#EndIf


#IfNotRow2D layout_options field_id medicaid_number group_name 1Patient Info
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'medicaid_number', '1Patient Info', 'Medicaid Number', '32','2','1','20','63','','1','1','','','Medicaid Number','0');
#EndIf

#IfMissingColumn patient_data medicaid_number
ALTER TABLE patient_data ADD medicaid_number varchar(10);
#EndIf

#IfNotRow2D layout_options field_id hmo_ppo_number group_name 1Patient Info
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hmo_ppo_number', '1Patient Info', 'HMO/PPO Number', '33','2','1','20','63','','1','1','','','HMO/PPO Number','0');
#EndIf

#IfMissingColumn patient_data hmo_ppo_number
ALTER TABLE patient_data ADD hmo_ppo_number varchar(10);
#EndIf



#IfNotRow2D list_options list_id ptlistcols option_id admit_status
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','admit_status','Admit Status','12',0,1,'','');
DELETE FROM list_options WHERE option_id='pubpid';
#EndIf



#IfNotRow2D layout_options form_id DEM group_name 3Preferences
UPDATE layout_options SET group_name="3Preferences" WHERE group_name="3Choices";
DELETE FROM layout_options WHERE field_id='hipaa_notice' AND group_name='3Preferences';
DELETE FROM layout_options WHERE field_id='allow_imm_reg_use' AND group_name='3Preferences';
DELETE FROM layout_options WHERE field_id='allow_health_info_ex' AND group_name='3Preferences';
DELETE FROM layout_options WHERE field_id='allow_imm_info_share' AND group_name='3Preferences';
#EndIf


#IfNotRow2D layout_options field_id providerID title Physician
UPDATE layout_options SET group_name="3Preferences", seq=1, title="Physician" WHERE field_id="providerID";
#EndIf



#IfNotRow2D layout_options field_id emp_off_num group_name 4Employer
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'emp_off_num', '4Employer', 'Office Number', '8','2','1','20','63','','1','1','','','Office Number','0');
#EndIf

#IfMissingColumn patient_data emp_off_num
ALTER TABLE patient_data ADD emp_off_num varchar(10);
#EndIf


#IfNotRow2D layout_options field_id emp_fax_num group_name 4Employer
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'emp_fax_num', '4Employer', 'Fax Number', '9','2','1','20','63','','1','1','','','Fax Number','0');
#EndIf

#IfMissingColumn patient_data emp_fax_num
ALTER TABLE patient_data ADD emp_fax_num varchar(10);
#EndIf

#IfNotRow2D layout_options field_id ok_to_contact group_name 4Employer
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'ok_to_contact', '4Employer', 'OK to Contact', '10','1','1','0','0','yesnona','1','1','','','OK to Contact','0');
#EndIf

#IfMissingColumn patient_data ok_to_contact
ALTER TABLE patient_data ADD ok_to_contact varchar(10);
#EndIf


#IfNotRow2D layout_options form_id DEM group_name 5Background
UPDATE layout_options SET group_name="5Background" WHERE group_name="5Stats";
#EndIf

#IfNotRow2D layout_options field_id language title Primary Language Spoken
UPDATE layout_options SET group_name="5Background", seq=1, title="Primary Language Spoken" WHERE field_id="language";
#EndIf


#IfNotRow2D layout_options field_id secondary_language group_name 5Background
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'secondary_language', '5Background', 'Secondary Language Spoken', '2','26','1','0','0','language','1','1','','','Secondary Language Spoken','0');
#EndIf

#IfMissingColumn patient_data secondary_language
ALTER TABLE patient_data ADD secondary_language varchar(100);
#EndIf


#IfNotRow2D layout_options field_id family_size title Number of Children
UPDATE layout_options SET group_name="5Background", title="Number of Children" WHERE field_id="family_size";
#EndIf



#IfNotRow2D layout_options field_id grand_childrens group_name 5Background
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'grand_childrens', '5Background', 'Number of Grand Children', '5','2','1','20','63','','1','1','','','Number of Grand Children','0');
#EndIf

#IfMissingColumn patient_data grand_childrens
ALTER TABLE patient_data ADD grand_childrens varchar(10);
#EndIf


#IfNotRow2D layout_options field_id hospital_admit_date title Last Admission Date
UPDATE layout_options SET group_name="7Hospitalization", title="Last Admission Date" WHERE field_id="hospital_admit_date";
#EndIf

#IfNotRow2D layout_options field_id hospital_dc_date title Last Discharge Date
UPDATE layout_options SET group_name="7Hospitalization", title="Last Discharge Date" WHERE field_id="hospital_dc_date";
#EndIf

#IfNotRow2D layout_options group_name 9Referral field_id area_director
UPDATE layout_options SET group_name="9Referral", seq=0 WHERE field_id="area_director";
#EndIf

#IfNotRow2D layout_options group_name 9Referral field_id case_manager
UPDATE layout_options SET group_name="9Referral", seq=0 WHERE field_id="case_manager";
DELETE FROM layout_options WHERE group_name='6Misc';
DELETE FROM layout_options WHERE field_id='referral_admission_source' AND group_name='9Referral';
#EndIf

#IfNotRow2D list_options list_id lists option_id referraltype
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'referraltype', 'Type of Referral', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'physician', 'Physician', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'hospital', 'Hospital', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'snf', 'SNF', '3', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'alf', 'ALF', '4', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'board_care', 'Board and Care', '5', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'vendor', 'Vendor', '6', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'family', 'Family', '7', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'self', 'Self', '8', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'other', 'Other', '9', '0', '1', '', '');
#EndIf



#IfNotRow2D layout_options field_id type_of_referral group_name 9Referral
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'type_of_referral', '9Referral', 'Type of Referral', '2','1','1','0','0','referraltype','1','1','','','Type of Referral','0');
#EndIf

#IfMissingColumn patient_data type_of_referral
ALTER TABLE patient_data ADD type_of_referral varchar(10);
#EndIf

#IfNotRow2D layout_options field_id type_of_referral_other group_name 9Referral
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'type_of_referral_other', '9Referral', 'Other', '3','2','1','20','63','','1','3','','1','Other','0');
#EndIf

#IfMissingColumn patient_data type_of_referral_other
ALTER TABLE patient_data ADD type_of_referral_other varchar(100);
#EndIf

#IfNotRow2D layout_options field_id referral_fname seq 4
UPDATE layout_options SET seq=4 WHERE field_id="referral_fname";
#EndIf


#IfNotRow2D list_options list_id lists option_id yesnona
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'yesnona', 'Yes No NA', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('yesnona', 'yes', 'Yes', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('yesnona', 'no', 'No', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('yesnona', 'na', 'N/A', '3', '0', '1', '', '');
#EndIf



