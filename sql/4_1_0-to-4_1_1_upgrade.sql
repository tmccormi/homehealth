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

--  #IfColumnDoesExist
--    arguments: table_name colname
--    behavior:  if the table exists and the column does exist,  the block will be executed

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

#IfMissingColumn patient_data hospital_nameALTER TABLE patient_data ADD hospital_name varchar(100), ADD hospital_phone varchar(50), ADD hospital_address varchar(100), ADD hospital_city varchar(20), ADD hospital_state varchar(20), ADD hospital_zip varchar(10), ADD hospital_admit_date DATE DEFAULT NULL, ADD hospital_dc_date DATE DEFAULT NULL;
#EndIf


#IfNotRow2D list_options list_id abook_type option_id agency
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','agency','Agency','45',0,1,'','');
#EndIf

#IfNotRow2D layout_options form_id DEM group_name 8Agency
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_name', '8Agency', 'Agency Name', '1','37','2','0','0','','1','3','','','Agency','0');
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


#IfNotRow2D layout_options field_id ref_providerID data_type 43
UPDATE layout_options SET title="Internal Referrer",data_type=43 WHERE field_id="ref_providerID";
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


#IfNotRow2D list_options list_id lists option_id agencyarea
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'agencyarea', 'Agency Area', '1', '0', '0', '', '');
#EndIf

#IfMissingColumn users agency_area
ALTER TABLE users ADD agency_area varchar(60);
#EndIf


#IfRow2D form_id DEM field_id admit_status
DELETE FROM layout_options WHERE field_id='admit_status' AND group_name='1Patient Info';
#EndIf


--  Installing forms and Categorizing it

#IfNotTable forms_supervisor_visit_note
CREATE TABLE IF NOT EXISTS `forms_supervisor_visit_note` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
patient_name varchar(100),
time_in varchar(100),
time_out varchar(100),
SOC_date DATE,
staff_supervised varchar(100),
supervisor_visits varchar(100),
reported_to_patient_home varchar(100),
wearing_name_badge varchar(100),
using_two_identifiers varchar(100),
demonstrates_behaviour varchar(100),
follow_home_health varchar(100),
demonstrates_communication varchar(100),
aware_patient_code varchar(100),
demonstrates_clinical_skills varchar(100),
adheres_to_policies varchar(100),
identify_patient_issues varchar(100),
handling_skills varchar(100),
demonstrates_grooming varchar(100),
supervisor_visit_other varchar(100),
additional_notes varchar(100),
clinician_signature varchar(100),
clinician_signature_date DATE
) engine=MyISAM;
#EndIf

#IfNotRow registry directory supervisor_visit_note
INSERT INTO `registry` VALUES ('HHA-Supervisor Visit', 1, 'supervisor_visit_note', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory supervisor_visit_note category 
UPDATE registry SET category='' WHERE directory='supervisor_visit_note';
#EndIf



#IfNotTable forms_home_environment
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
#EndIf


#IfNotRow registry directory home_environment
INSERT INTO `registry` VALUES ('Home Environment', 1, 'home_environment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory home_environment category 
UPDATE registry SET category='' WHERE directory='home_environment';
#EndIf


#IfNotTable forms_incident_report
CREATE TABLE IF NOT EXISTS `forms_incident_report` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
incident_report_notes text,
incident_report_caregiver_name varchar(225) DEFAULT NULL,
incident_visit_date date default NULL,
incident_report_patient_name varchar(225) DEFAULT NULL,
incident_report_date date default NULL,
incident_report_occurance_date date default NULL,
incident_report_patient_related text,
incident_report_patient_related_other varchar(225) DEFAULT NULL,
incident_report_description_occurence mediumtext,
incident_report_notifications text,
incident_report_not_physician_name varchar(225) DEFAULT NULL,
incident_report_not_physician_date date default NULL,
incident_report_not_supervisor_name varchar(225) DEFAULT NULL,
incident_report_not_supervisor_date date default NULL,
incident_report_not_caregiver_name varchar(225) DEFAULT NULL,
incident_report_not_caregiver_date date default NULL,
incident_report_not_manager_name varchar(225) DEFAULT NULL,
incident_report_not_manager_date date default NULL,
incident_report_physician_orders varchar(225) DEFAULT NULL,
incident_report_other_actions_taken mediumtext,
incident_report_administrative_review mediumtext,
incident_report_person_filing_report varchar(225) DEFAULT NULL,
incident_report_filing_report_date date default NULL,
incident_report_management_reviewer varchar(225) DEFAULT NULL,
incident_report_management_reviewer_date date default NULL,
incident_report_admin_reviewer varchar(225) DEFAULT NULL,
incident_report_admin_reviewer_date date default NULL,
incident_report_caregiver_sign varchar(225) DEFAULT NULL,
incident_report_caregiver_sign_date date default NULL
) ENGINE=MyISAM;
#EndIf


#IfNotRow registry directory incident_report
INSERT INTO `registry` VALUES ('Incident Report', 1, 'incident_report', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory incident_report category 
UPDATE registry SET category='' WHERE directory='incident_report';
#EndIf



#IfNotTable forms_non_oasis
CREATE TABLE IF NOT EXISTS `forms_non_oasis` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
non_oasis_patient varchar(100) DEFAULT NULL,
non_oasis_caregiver varchar(100) DEFAULT NULL,
non_oasis_visit_date datetime DEFAULT NULL,
non_oasis_time_in varchar(40) DEFAULT NULL,
non_oasis_time_out varchar(40) DEFAULT NULL,
non_oasis_pain_weight varchar(20) DEFAULT NULL,
non_oasis_pain_blood_sugar varchar(40) DEFAULT NULL,
non_oasis_pain_bowel varchar(15) DEFAULT NULL,
non_oasis_pain_bowel_other varchar(100) DEFAULT NULL,
non_oasis_pain_bowel_sounds varchar(100) DEFAULT NULL,
non_oasis_pain_bladder varchar(10) DEFAULT NULL,
non_oasis_pain_bladder_other varchar(100) DEFAULT NULL,
non_oasis_pain_urinary_output varchar(80) DEFAULT NULL,
non_oasis_pain_tolerated_procedure varchar(10) DEFAULT NULL,
non_oasis_pain_tolerated_procedure_ot varchar(10) DEFAULT NULL,
non_oasis_pain_tolerated_procedure_other mediumtext,
non_oasis_pain_scale varchar(20) DEFAULT NULL,
non_oasis_pain_location_cause varchar(150) DEFAULT NULL,
non_oasis_pain_description varchar(20) DEFAULT NULL,
non_oasis_pain_frequency varchar(20) DEFAULT NULL,
non_oasis_pain_aggravating_factors varchar(20) DEFAULT NULL,
non_oasis_pain_aggravating_factors_other varchar(50) DEFAULT NULL,
non_oasis_pain_relieving_factors varchar(20) DEFAULT NULL,
non_oasis_pain_relieving_factors_other varchar(50) DEFAULT NULL,
non_oasis_pain_activities_limited varchar(225) DEFAULT NULL,
non_oasis_nutrition_status_prob varchar(20) DEFAULT NULL,
non_oasis_nutrition_status varchar(100) DEFAULT NULL,
non_oasis_nutrition_status_other varchar(225) DEFAULT NULL,
non_oasis_nutrition_requirements varchar(30) DEFAULT NULL,
non_oasis_nutrition_appetite varchar(20) DEFAULT NULL,
non_oasis_nutrition_eat_patt text,
non_oasis_nutrition_eat_patt1 varchar(225) DEFAULT NULL,
non_oasis_nutrition_eat_patt_freq varchar(20) DEFAULT NULL,
non_oasis_nutrition_eat_patt_amt varchar(20) DEFAULT NULL,
non_oasis_nutrition_patt_gain varchar(10) DEFAULT NULL,
non_oasis_nutrition_eat_patt1_gain_time varchar(5) DEFAULT NULL,
non_oasis_nutrition_patt1_other varchar(50) DEFAULT NULL,
non_oasis_nutrition_req varchar(50) DEFAULT NULL,
non_oasis_nutrition_req_other varchar(80) DEFAULT NULL,
non_oasis_nutrition_risks text,
non_oasis_nutrition_risks_MD varchar(50) DEFAULT NULL,
nutrition_total INT DEFAULT '0',
non_oasis_nutrition_describe varchar(100) DEFAULT NULL,
non_oasis_vital_lying_right varchar(20) DEFAULT NULL,
non_oasis_vital_lying_left varchar(20) DEFAULT NULL,
non_oasis_vital_sitting_right varchar(20) DEFAULT NULL,
non_oasis_vital_sitting_left varchar(20) DEFAULT NULL,
non_oasis_vital_standing_right varchar(20) DEFAULT NULL,
non_oasis_vital_standing_left varchar(20) DEFAULT NULL,
non_oasis_vital_temp  varchar(15) DEFAULT NULL,
non_oasis_vital_pulse varchar(80) DEFAULT NULL,
non_oasis_vital_resp_rate varchar(15) DEFAULT NULL,
non_oasis_cardio varchar(15) DEFAULT NULL,
non_oasis_cardio_breath varchar(30) DEFAULT NULL,
non_oasis_cardio_breath1 varchar(150) DEFAULT NULL,
non_oasis_cardio_breath_anterior varchar(30) DEFAULT NULL,
non_oasis_cardio_breath_posterior varchar(30) DEFAULT NULL,
non_oasis_cardio_o2_sat varchar(15) DEFAULT NULL,
non_oasis_cardio_acc_muscles varchar(100) DEFAULT NULL,
non_oasis_cardio_o2 varchar(50) DEFAULT NULL,
non_oasis_cardio_lpm_per varchar(50) DEFAULT NULL,
non_oasis_cardio_trach varchar(5) DEFAULT NULL,
non_oasis_cardio_manages varchar(30) DEFAULT NULL,
non_oasis_cardio_breath_cough varchar(10) DEFAULT NULL,
non_oasis_cardio_breath_productive varchar(10) DEFAULT NULL,
non_oasis_cardio_breath_color varchar(30) DEFAULT NULL,
non_oasis_cardio_breath_amt varchar(10) DEFAULT NULL,
non_oasis_cardio_breath_dyspnea varchar(20) DEFAULT NULL,
non_oasis_cardio_breath_dyspnea_other varchar(100) DEFAULT NULL,
non_oasis_cardio_heart_sounds_type varchar(20) DEFAULT NULL,
non_oasis_cardio_heart_sounds text,
non_oasis_cardio_heart_sounds_pacemaker varchar(50) DEFAULT NULL,
non_oasis_cardio_heart_sounds_pacemaker_date date DEFAULT NULL,
non_oasis_cardio_heart_sounds_pacemaker_type varchar(50) DEFAULT NULL,
non_oasis_cardio_heart_sounds_chest_pain varchar(150) DEFAULT NULL,
non_oasis_cardio_heart_sounds_associated_with varchar(60) DEFAULT NULL,
non_oasis_cardio_heart_sounds_frequency varchar(50) DEFAULT NULL,
non_oasis_cardio_heart_sounds_edema varchar(50) DEFAULT NULL,
non_oasis_cardio_heart_sounds_edema_dependent varchar(100) DEFAULT NULL,
non_oasis_cardio_heart_sounds_site varchar(50) DEFAULT NULL,
non_oasis_cardio_heart_sounds_capillary varchar(50) DEFAULT NULL,
non_oasis_cardio_heart_sounds_other varchar(50) DEFAULT NULL,
non_oasis_cardio_heart_sounds_notify varchar(100) DEFAULT NULL,
non_oasis_braden_scale_sensory INT DEFAULT '0',
non_oasis_braden_scale_moisture INT DEFAULT '0',
non_oasis_braden_scale_activity INT DEFAULT '0',
non_oasis_braden_scale_mobility INT DEFAULT '0',
non_oasis_braden_scale_nutrition INT DEFAULT '0',
non_oasis_braden_scale_friction INT DEFAULT '0',
non_oasis_braden_scale_total INT DEFAULT '0',
non_oasis_wound_lesion_location varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_type varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_status varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_size_length varchar(30) DEFAULT NULL,
non_oasis_wound_lesion_size_width varchar(30) DEFAULT NULL,
non_oasis_wound_lesion_size_depth varchar(30) DEFAULT NULL,
non_oasis_wound_lesion_stage varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_tunneling varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_odor varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_skin varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_edema varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_stoma varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_appearance varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_drainage varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_color varchar(225) DEFAULT NULL,
non_oasis_wound_lesion_consistency varchar(225) DEFAULT NULL,
non_oasis_integumentary_status_problem varchar(15) DEFAULT NULL,
non_oasis_wound_care_done varchar(10) DEFAULT NULL,
non_oasis_wound_location varchar(50) DEFAULT NULL,
non_oasis_wound text,
non_oasis_wound_soiled_dressing_by varchar(50) DEFAULT NULL,
non_oasis_wound_soiled_technique varchar(10) DEFAULT NULL,
non_oasis_wound_cleaned varchar(50) DEFAULT NULL,
non_oasis_wound_irrigated varchar(50) DEFAULT NULL,
non_oasis_wound_packed varchar(50) DEFAULT NULL,
non_oasis_wound_dressing_apply varchar(50) DEFAULT NULL,
non_oasis_wound_incision varchar(50) DEFAULT NULL,
non_oasis_wound_comment varchar(225) DEFAULT NULL,
non_oasis_satisfactory_return_demo varchar(10) DEFAULT NULL,
non_oasis_wound_education varchar(10) DEFAULT NULL,
non_oasis_wound_education_comment varchar(225) DEFAULT NULL,
non_oasis_infusion text,
non_oasis_infusion_peripheral varchar(100) DEFAULT NULL,
non_oasis_infusion_PICC varchar(100) DEFAULT NULL,
non_oasis_infusion_central varchar(20) DEFAULT NULL,
non_oasis_infusion_central_date date DEFAULT NULL,
non_oasis_infusion_xray varchar(10) DEFAULT NULL,
non_oasis_infusion_circum INT DEFAULT '0',
non_oasis_infusion_length INT DEFAULT '0',
non_oasis_infusion_hickman varchar(20) DEFAULT NULL,
non_oasis_infusion_hickman_date date DEFAULT NULL,
non_oasis_infusion_epidural_date date DEFAULT NULL,
non_oasis_infusion_implanted_date date DEFAULT NULL,
non_oasis_infusion_intrathecal_date date DEFAULT NULL,
non_oasis_infusion_med1_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_pump varchar(50) DEFAULT NULL,
non_oasis_infusion_admin_by varchar(50) DEFAULT NULL,
non_oasis_infusion_admin_by_other varchar(50) DEFAULT NULL,
non_oasis_infusion_purpose text,
non_oasis_infusion_purpose_other varchar(100) DEFAULT NULL,
non_oasis_infusion_care_provided text,
non_oasis_infusion_dressing varchar(20) DEFAULT NULL,
non_oasis_infusion_performed_by varchar(20) DEFAULT NULL,
non_oasis_infusion_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_injection varchar(50) DEFAULT NULL,
non_oasis_infusion_labs_drawn text,
non_oasis_infusion_interventions text,
non_oasis_enteral varchar(100) DEFAULT NULL,
non_oasis_enteral_other varchar(50) DEFAULT NULL,
non_oasis_enteral_pump varchar(50) DEFAULT NULL,
non_oasis_enteral_feedings varchar(20) DEFAULT NULL,
non_oasis_enteral_rate varchar(50) DEFAULT NULL,
non_oasis_enteral_flush text,
non_oasis_enteral_performed_by varchar(20) DEFAULT NULL,
non_oasis_enteral_performed_by_other varchar(50) DEFAULT NULL,
non_oasis_enteral_dressing text,
non_oasis_enteral_interventions text,
non_oasis_skilled_care varchar(50) DEFAULT NULL,
non_oasis_summary_disciplines varchar(50) DEFAULT NULL,
non_oasis_summary_disciplines_other varchar(50) DEFAULT NULL,
non_oasis_summary_physician varchar(10) DEFAULT NULL,
non_oasis_summary_elsewhere varchar(5) DEFAULT NULL,
non_oasis_summary_reason mediumtext,
non_oasis_summary_medication varchar(50) DEFAULT NULL,
non_oasis_summary_medication_identified mediumtext DEFAULT NULL,
non_oasis_summary_reason_discharge text,
non_oasis_summary_reason_discharge_explain varchar(50) DEFAULT NULL,
non_oasis_summary_reason_discharge_other varchar(80) DEFAULT NULL,
non_oasis_summary_discharge_inst text,
non_oasis_summary_reviewed varchar(80) DEFAULT NULL,
non_oasis_summary_reviewed_other varchar(80) DEFAULT NULL,
non_oasis_summary_immunization varchar(10) DEFAULT NULL,
non_oasis_summary_immun_explain varchar(100) DEFAULT NULL,
non_oasis_summary_written varchar(10) DEFAULT NULL,
non_oasis_summary_written_explain varchar(100) DEFAULT NULL,
non_oasis_summary_demonstrates varchar(10) DEFAULT NULL,
non_oasis_summary_demonstrates_explain varchar(100) DEFAULT NULL,
detail varchar(100),
process varchar(100),
data varchar(100),
label varchar(100)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory non_oasis
INSERT INTO `registry` VALUES ('Non-OASIS Discharge Assessment', 1, 'non_oasis', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory non_oasis category 
UPDATE registry SET category='' WHERE directory='non_oasis';
#EndIf



#IfNotTable forms_patient_missed_visit
CREATE TABLE IF NOT EXISTS `forms_patient_missed_visit` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
patient_name varchar(100),
patient_mr varchar(100),
patient_missed_date DATE,
descipline_who_category varchar(100),
descipline_who varchar(100),
descipline_who_other varchar(100),
reason_for_category varchar(100),
reason_for varchar(1000),
reason_for_other varchar(100),
actions_taken varchar(1000),
actions_taken_other varchar(100),
patient_need_addressed varchar(500),
patient_need_addressed_other varchar(100),
physician_name varchar(100),
physician_fax_number varchar(100),
physician_acknowledgment varchar(100),
physician_acknowledgment_date DATE,
physician_signature varchar(100),
physician_signature_date DATE,
physician_comments varchar(100)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory patient_missed_visit
INSERT INTO `registry` VALUES ('Patient Missed Visit', 1, 'patient_missed_visit', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory patient_missed_visit category 
UPDATE registry SET category='' WHERE directory='patient_missed_visit';
#EndIf



#IfNotTable forms_physician_face
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
#EndIf

#IfNotRow registry directory physician_face
INSERT INTO `registry` VALUES ('Physician Face To Face Encounter', 1, 'physician_face', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory physician_face category 
UPDATE registry SET category='' WHERE directory='physician_face';
#EndIf



#IfNotTable forms_physician_orders
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
#EndIf

#IfNotRow registry directory physician_orders
INSERT INTO `registry` VALUES ('Physician Orders', 1, 'physician_orders', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory physician_orders category 
UPDATE registry SET category='' WHERE directory='physician_orders';
#EndIf



#IfNotTable forms_sixty_day_progress_note
CREATE TABLE IF NOT EXISTS `forms_sixty_day_progress_note` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
sixty_day_progress_note_patient_name varchar(40),
sixty_day_progress_note_certification_period varchar(40),
sixty_day_progress_note_dear_dr varchar(100),
sixty_day_progress_note_patient_receiving_care_first varchar(150),
sixty_day_progress_note_patient_receiving_care_other text,
sixty_day_progress_note_diagnosis_admission text,
sixty_day_progress_note_additional_diagnosis text,
sixty_day_progress_note_decline_no_change_clinical_pblm text,
sixty_day_progress_note_decline_clinical_pblm_other text,
sixty_day_progress_note_decline_clinical_pblm_specific_details text,
sixty_day_progress_note_improvement_in_clinical_issues text,
sixty_day_progress_note_improvement_issues_other text,
sixty_day_progress_note_improvement_issues_specific_details text,
sixty_day_progress_note_living_situation_patient_lives varchar(100),
sixty_day_progress_note_living_situation_patient_lives_who varchar(50),
sixty_day_progress_note_living_situation_patient_lives_other varchar(50),
sixty_day_progress_note_living_situation_no_hur_day_why text,
sixty_day_progress_note_mental_status varchar(30),
sixty_day_progress_note_mental_status_oriented varchar(30),
sixty_day_progress_note_mental_status_disoriented varchar(30),
sixty_day_progress_note_impaired_mental_sta_req_resou varchar(30),
sixty_day_progress_note_impaired_mental_sta_req_resou_other text,
sixty_day_progress_note_patient_adl_status varchar(30),
sixty_day_progress_note_patient_adl_status_other text,
sixty_day_progress_note_ambulatory_transfer_status varchar(100),
sixty_day_progress_note_ambulatory_transfer_status_other text,
sixty_day_progress_note_communication_status varchar(150),
sixty_day_progress_note_communication_status_other text,
sixty_day_progress_note_miscellaneous_abi_hear varchar(150),
sixty_day_progress_note_miscellaneous_abis_hear_other text,
sixty_day_progress_note_miscellaneous_abi_vis varchar(150),
sixty_day_progress_note_miscellaneous_abi_hear_vis_other text,
sixty_day_progress_note_patient_needs_help_with varchar(50),
sixty_day_progress_note_patient_needs_help_with_other text,
sixty_day_progress_note_additional_information text,
sixty_day_progress_note_clinician_name_title_completing_note varchar(30)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory sixty_day_progress_note
INSERT INTO `registry` VALUES ('Sixty Day Progress Note', 1, 'sixty_day_progress_note', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory sixty_day_progress_note category 
UPDATE registry SET category='' WHERE directory='sixty_day_progress_note';
#EndIf



#IfNotTable forms_30_day_progress_note
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
#EndIf

#IfNotRow registry directory thirtyday_progress_note
INSERT INTO `registry` VALUES ('Thirty Day Progress Note', 1, 'thirtyday_progress_note', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');
#EndIf

#IfNotRow2D registry directory thirtyday_progress_note category 
UPDATE registry SET category='' WHERE directory='thirtyday_progress_note';
#EndIf



#IfNotTable forms_dietary_assessment
CREATE TABLE IF NOT EXISTS `forms_dietary_assessment` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
dietary_assessment_last_name varchar(40),
dietary_assessment_first_name varchar(40),
dietary_assessment_visit_date date default NULL,
dietary_assessment_dob date default NULL,
dietary_assessment_sex varchar(10),
dietary_assessment_weight varchar(10),
dietary_assessment_height varchar(10),
dietary_assessment_food_intake_occurred_past3month varchar(100),
dietary_assessment_lost_weight_past3month varchar(50),
dietary_assessment_lost_weight_past3month_other text,
dietary_assessment_factors_affecting_food_intake varchar(200),
dietary_assessment_factors_affecting_food_intake_specify varchar(200),
dietary_assessment_factors_affecting_food_intake_other text,
dietary_assessment_patient_mobility_status varchar(100),
dietary_assessment_different_medications_per_day varchar(15),
dietary_assessment_pressure_ulcers_present varchar(15),
dietary_assessment_stage_ulcers varchar(15),
dietary_assessment_full_meals_per_day varchar(5),
dietary_assessment_assistance_patient_require_feed_self varchar(100),
dietary_assessment_past_food_drink text,
dietary_assessment_allergies_and_food_sensitivities text,
dietary_assessment_dietary_foods_patient_dislikes text,
dietary_assessment_assessment_summary text,
dietary_assessment_treatmentplan_recommendations text,
dietary_assessment_rd_signature varchar(30),
dietary_assessment_rd_signature_date date default NULL,
dietary_assessment_physician_signature varchar(100),
dietary_assessment_physician_signature_date date default NULL
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory dietary_assessment
INSERT INTO `registry` VALUES ('Dietary Assessment', 1, 'dietary_assessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Dietary', '');
#EndIf

#IfNotRow2D registry directory dietary_assessment category Dietary
UPDATE registry SET category='Dietary' WHERE directory='dietary_assessment';
#EndIf



#IfNotTable forms_dietary_care_plan
CREATE TABLE IF NOT EXISTS `forms_dietary_care_plan` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
dietary_care_plan_last_name varchar(40),
dietary_care_plan_first_name varchar(40),
dietary_care_plan_visit_date date default NULL,
dietary_care_plan_dob date default NULL,
dietary_care_plan_sex varchar(10),
dietary_care_plan_weight varchar(10),
dietary_care_plan_height varchar(10),
dietary_care_plan_frequency_and_duration text,
dietary_care_plan_short_term_goals text,
dietary_care_plan_long_term_goals text,
dietary_care_plan_treatment text,
dietary_care_plan_rd_signature varchar(40),
dietary_care_plan_form_date date default NULL
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory dietary_care_plan
INSERT INTO `registry` VALUES ('Dietary Care Plan', 1, 'dietary_care_plan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Dietary', '');
#EndIf

#IfNotRow2D registry directory dietary_care_plan category Dietary
UPDATE registry SET category='Dietary' WHERE directory='dietary_care_plan';
#EndIf



#IfNotTable forms_dietary_visit
CREATE TABLE IF NOT EXISTS `forms_dietary_visit` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
dietary_visit_last_name varchar(40),
dietary_visit_first_name varchar(40),
dietary_visit_visit_date date default NULL,
dietary_visit_change_dietary_status_since_last_visit text,
dietary_visit_patient_weight_lost_since_last_visit varchar(100),
dietary_visit_patient_weight_lost_since_last_visit_others text,
dietary_visit_new_factors_affecting_patient_weight varchar(20),
dietary_visit_new_affecting_factors text,
dietary_visit_assessment_summary text,
dietary_visit_treatment_plan text,
dietary_visit_rd_signature varchar(30),
dietary_visit_rd_signature_date date default NULL
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory dietary_visit
INSERT INTO `registry` VALUES ('Dietary Visit', 1, 'dietary_visit', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Dietary', '');
#EndIf

#IfNotRow2D registry directory dietary_visit category Dietary
UPDATE registry SET category='Dietary' WHERE directory='dietary_visit';
#EndIf



#IfNotTable forms_msw_careplan
CREATE TABLE IF NOT EXISTS `forms_msw_careplan` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
SOC_date DATE,
problem_reason_for_referel varchar(100),
spouse_significant_others_row1 varchar(500),
spouse_significant_others_row2 varchar(500),
spouse_significant_others_row3 varchar(500),
caregivers_row1 varchar(500),
caregivers_row2 varchar(500),
patient_lives varchar(100),
patient_lives_with_who varchar(100),
patient_lives_other varchar(100),
no_of_hours_patient_alone varchar(100),
type_of_housing varchar(100),
type_of_housing_other varchar(100),
condition_of_housing varchar(100),
problem_safety_issues varchar(100),
mental_status varchar(100),
mental_status_oriented_to varchar(100),
mental_status_disoriented varchar(100),
impaired_mental_status_requires_resources varchar(100),
impaired_mental_status_requires_resources_other varchar(100),
patient_adl_status varchar(100),
patient_adl_status_other varchar(100),
ambulatory_transfer_status varchar(100),
ambulatory_transfer_status_other varchar(100),
communication_status varchar(100),
communication_status_other varchar(100),
miscellaneous_abilities_hearing varchar(100),
miscellaneous_abilities_hearing_other varchar(100),
miscellaneous_abilities_vision varchar(100),
miscellaneous_abilities_vision_other varchar(100),
patient_needs_help_with varchar(255),
patient_needs_help_with_other varchar(100),
patient_desired varchar(255),
short_term_time_frame varchar(255),
long_term_time_frame varchar(255),
SOC_date2 DATE,
medical_social_services_interventions varchar(1000),
medical_social_services_interventions_other varchar(100),
analysis_of_finding varchar(255),
review_of_interventions varchar(255),
evaluation_of_patient varchar(255),
continued_treatmentplan_frequency varchar(100),
continued_treatmentplan_duration varchar(100),
continued_treatmentplan_effective_date DATE,
msw_careplan_communicated_agreed varchar(100),
msw_careplan_communicated_agreed_other varchar(100),
physician_order varchar(255),
other_comments varchar(100)
) engine=MyISAM;
#EndIf

#IfNotRow registry directory msw_careplan
INSERT INTO `registry` VALUES ('MSW Careplan', 1, 'msw_careplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'MSW', '');
#EndIf

#IfNotRow2D registry directory msw_careplan category MSW
UPDATE registry SET category='MSW' WHERE directory='msw_careplan';
#EndIf



#IfNotTable forms_msw_evaluation
CREATE TABLE IF NOT EXISTS `forms_msw_evaluation` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
msw_evaluation_time_in varchar(40),
msw_evaluation_time_out varchar(40),
msw_evaluation_date date default NULL,
msw_evaluation_patient_name varchar(40),
msw_evaluation_mr varchar(40),
msw_evaluation_soc date default NULL,
msw_evaluation_homebound_reason varchar(50),
msw_evaluation_homebound_reason_in varchar(100),
msw_evaluation_homebound_reason_other varchar(100),
msw_evaluation_orders_for_evaluation varchar(40),
msw_evaluation_if_no_explain_orders varchar(100),
msw_evaluation_medical_diagnosis_problem text,
msw_evaluation_medical_diagnosis_problem_onset date default NULL,
msw_evaluation_psychosocial_history text,
msw_evaluation_prior_level_function text,
msw_evaluation_prior_caregiver_support varchar(40),
msw_evaluation_prior_caregiver_support_who varchar(40),
msw_evaluation_psychosocial varchar(40),
msw_evaluation_psychosocial_oriented varchar(40),
msw_evaluation_safety_awareness varchar(40),
msw_evaluation_safety_awareness_other text,
msw_evaluation_living_situation_support_system varchar(40),
msw_evaluation_health_factors text,
msw_evaluation_environmental_factors text,
msw_evaluation_financial_factors text,
msw_evaluation_additional_information text,
msw_evaluation_plan_ofc_are_and_discharge_was_communicated varchar(40),
msw_evaluation_plan_ofc_are_and_discharge_was_communicated_other text,
msw_evaluation_therapist_who_developed_poc varchar(40)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory msw_evaluation
INSERT INTO `registry` VALUES ('MSW Evaluation', 1, 'msw_evaluation', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'MSW', '');
#EndIf

#IfNotRow2D registry directory msw_evaluation category MSW
UPDATE registry SET category='MSW' WHERE directory='msw_evaluation';
#EndIf



#IfNotTable forms_msw_visit_note
CREATE TABLE IF NOT EXISTS `forms_msw_visit_note` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
msw_visit_note_time_in varchar(40),
msw_visit_note_time_out varchar(40),
msw_visit_note_date date default NULL,
msw_visit_note_patient_name varchar(40),
msw_visit_note_mr varchar(40),
msw_visit_note_soc date default NULL,
msw_visit_note_homebound_reason varchar(50),
msw_visit_note_homebound_reason_in varchar(100),
msw_visit_note_homebound_reason_other varchar(100),
msw_visit_note_phychological_health_environmental_situation text,
msw_visit_note_asssessment_of_current varchar(40),
msw_visit_note_asssessment_of_current_other text,
msw_visit_note_patient_education varchar(40),
msw_visit_note_patient_education_other text,
msw_visit_note_interventions_including text,
msw_visit_note_interventions_including_other text,
msw_visit_note_planning_and_organization text,
msw_visit_note_planning_and_organization_other text,
msw_visit_note_additional_comments text,
msw_visit_note_msw_visit_communicated_to varchar(40),
msw_visit_note_msw_visit_communicated_to_other text,
msw_visit_note_msw varchar(40)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory msw_visit_note
INSERT INTO `registry` VALUES ('MSW Visit Note', 1, 'msw_visit_note', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'MSW', '');
#EndIf

#IfNotRow2D registry directory msw_visit_note category MSW
UPDATE registry SET category='MSW' WHERE directory='msw_visit_note';
#EndIf



#IfNotTable forms_oasis_discharge
CREATE TABLE IF NOT EXISTS `forms_oasis_discharge` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
detail varchar(100),
process varchar(100),
data varchar(100),
label varchar(100),
oasis_patient_patient_name varchar(30),
oasis_patient_caregiver varchar(30),
oasis_patient_visit_date DATE,
time_in varchar(10),
time_out varchar(10),
oasis_therapy_cms_no varchar(20),
oasis_therapy_branch_state varchar(20),
oasis_therapy_branch_id_no varchar(20),
oasis_therapy_npi varchar(20),
oasis_therapy_npi_na varchar(4),
oasis_therapy_patient_id varchar(10),
oasis_therapy_soc_date DATE,
oasis_therapy_patient_name_first varchar(20),
oasis_therapy_patient_name_mi varchar(20),
oasis_therapy_patient_name_last varchar(20),
oasis_therapy_patient_name_suffix varchar(20),
oasis_therapy_patient_address_street varchar(20),
oasis_therapy_patient_address_city varchar(20),
oasis_therapy_patient_phone varchar(20),
oasis_therapy_patient_state varchar(20),
oasis_therapy_patient_zip varchar(10),
oasis_therapy_medicare_no varchar(20),
oasis_therapy_medicare_no_na varchar(4),
oasis_therapy_ssn varchar(20),
oasis_therapy_ssn_na varchar(4),
oasis_therapy_medicaid_no varchar(20),
oasis_therapy_medicaid_no_na varchar(4),
oasis_therapy_birth_date DATE,
oasis_therapy_patient_gender varchar(6),
oasis_therapy_discipline_person varchar(1),
oasis_therapy_date_assessment_completed DATE,
oasis_therapy_follow_up varchar(1),
oasis_therapy_certification varchar(1),
oasis_therapy_date_last_contacted_physician DATE,
oasis_therapy_date_last_seen_by_physician DATE,
oasis_influenza_vaccine varchar(1),
oasis_pneumococcal_vaccine varchar(1),
oasis_reason_influenza_vaccine varchar(1),
oasis_reason_ppv_not_received varchar(1),
oasis_speech_and_oral varchar(1),
oasis_therapy_frequency_pain varchar(1),
oasis_system_review_weight varchar(30),
oasis_system_review_weight_detail varchar(10),
oasis_system_review_blood_sugar varchar(30),
oasis_system_review_bowel_detail varchar(10),
oasis_system_review_bowel_other varchar(30),
oasis_system_review_bowel_sounds varchar(30),
oasis_system_review_bladder_detail varchar(10),
oasis_system_review_bladder_other varchar(30),
oasis_system_review_urinary_output varchar(30),
oasis_system_review_urinary_output_detail varchar(3),
oasis_system_review varchar(50),
oasis_system_review_foley_with varchar(30),
oasis_system_review_foley_inflated varchar(30),
oasis_system_review_tolerated varchar(3),
oasis_system_review_other varchar(30),
oasis_therapy_pain_scale varchar(2),
oasis_therapy_pain_location varchar(20),
oasis_therapy_pain_location_cause varchar(20),
oasis_therapy_pain_description varchar(10),
oasis_therapy_pain_frequency varchar(15),
oasis_therapy_pain_aggravating_factors varchar(15),
oasis_therapy_pain_aggravating_factors_other varchar(20),
oasis_therapy_pain_relieving_factors varchar(100),
oasis_therapy_pain_relieving_factors_other varchar(20),
oasis_therapy_pain_activities_limited TEXT,
oasis_nutrition_status_prob varchar(15) default NULL,
oasis_nutrition_status varchar(30) default NULL,
oasis_nutrition_status_other varchar(30) default NULL,
oasis_nutrition_requirements varchar(30) default NULL,
oasis_nutrition_appetite varchar(10) default NULL,
oasis_nutrition_eat_patt mediumtext,
oasis_nutrition_eat_patt1 text,
oasis_nutrition_eat_patt_freq varchar(30) default NULL,
oasis_nutrition_eat_patt_amt varchar(30) default NULL,
oasis_nutrition_eat_gain_or_loss varchar(4),
oasis_nutrition_patt_gain varchar(30) default NULL,
oasis_nutrition_eat_patt1_gain_time varchar(5) default NULL,
oasis_nutrition_patt1_other varchar(30) default NULL,
oasis_nutrition_req varchar(50) default NULL,
oasis_nutrition_req_other varchar(30) default NULL,
oasis_nutrition_risks text,
oasis_nutrition_risks_MD varchar(30) default NULL,
nutrition_total varchar(3) default NULL,
oasis_nutrition_describe varchar(30) default NULL,
oasis_therapy_vital_sign_blood_pressure varchar(100),
oasis_therapy_vital_sign_temperature varchar(10),
oasis_therapy_vital_sign_pulse varchar(10),
oasis_therapy_vital_sign_pulse_type varchar(40),
oasis_therapy_vital_sign_respiratory_rate varchar(10),
oasis_therapy_cardiopulmonary_problem varchar(2),
oasis_therapy_breath_sounds_type varchar(20),
oasis_therapy_breath_sounds TEXT,
oasis_therapy_breath_sounds_anterior varchar(5),
oasis_therapy_breath_sounds_posterior varchar(11),
oasis_therapy_breath_sounds_accessory_muscle_o2 varchar(2),
oasis_therapy_breath_sounds_cough varchar(7),
oasis_therapy_breath_sounds_productive varchar(5),
oasis_therapy_breath_sounds_o2_saturation varchar(30),
oasis_therapy_breath_sounds_accessory_muscle varchar(30),
oasis_therapy_breath_sounds_accessory_o2_detail varchar(30),
oasis_therapy_breath_sounds_accessory_lpm varchar(30),
oasis_therapy_breath_sounds_trach varchar(3),
oasis_therapy_breath_sounds_trach_manages varchar(10),
oasis_therapy_breath_sounds_productive_color varchar(20),
oasis_therapy_breath_sounds_productive_amount varchar(20),
oasis_therapy_breath_sounds_other varchar(30),
oasis_therapy_heart_sounds_type varchar(10),
oasis_therapy_heart_sounds TEXT,
oasis_therapy_heart_sounds_pacemaker varchar(30),
oasis_therapy_heart_sounds_pacemaker_date DATE,
oasis_therapy_heart_sounds_pacemaker_type varchar(30),
oasis_therapy_heart_sounds_other varchar(30),
oasis_therapy_heart_sounds_chest_pain varchar(10),
oasis_therapy_heart_sounds_associated_with varchar(10),
oasis_therapy_heart_sounds_frequency varchar(12),
oasis_therapy_heart_sounds_edema varchar(10),
oasis_therapy_heart_sounds_site varchar(12),
oasis_therapy_heart_sounds_edema_dependent varchar(12),
oasis_therapy_heart_sounds_capillary varchar(2),
oasis_therapy_heart_sounds_notify varchar(20),
oasis_therapy_integumentary_status varchar(1),
oasis_therapy_integumentary_status_stage2 varchar(2),
oasis_therapy_integumentary_status_stage2_date DATE,
oasis_therapy_braden_scale_sensory varchar(2),
oasis_therapy_braden_scale_moisture varchar(2),
oasis_therapy_braden_scale_activity varchar(2),
oasis_therapy_braden_scale_mobility varchar(2),
oasis_therapy_braden_scale_nutrition varchar(2),
oasis_therapy_braden_scale_friction varchar(2),
oasis_therapy_braden_scale_total varchar(2),
oasis_therapy_pressure_ulcer_a TEXT,
oasis_therapy_pressure_ulcer_b TEXT,
oasis_therapy_pressure_ulcer_c TEXT,
oasis_therapy_pressure_ulcer_d1 TEXT,
oasis_therapy_pressure_ulcer_d2 TEXT,
oasis_therapy_pressure_ulcer_d3 TEXT,
oasis_therapy_wound_lesion_location TEXT,
oasis_therapy_wound_lesion_type TEXT,
oasis_therapy_wound_lesion_status TEXT,
oasis_therapy_wound_lesion_size_length varchar(20),
oasis_therapy_wound_lesion_size_width varchar(20),
oasis_therapy_wound_lesion_size_depth varchar(20),
oasis_therapy_wound_lesion_stage TEXT,
oasis_therapy_wound_lesion_tunneling TEXT,
oasis_therapy_wound_lesion_odor TEXT,
oasis_therapy_wound_lesion_skin TEXT,
oasis_therapy_wound_lesion_edema TEXT,
oasis_therapy_wound_lesion_stoma TEXT,
oasis_therapy_wound_lesion_appearance TEXT,
oasis_therapy_wound_lesion_drainage TEXT,
oasis_therapy_wound_lesion_color TEXT,
oasis_therapy_wound_lesion_consistency TEXT,
oasis_therapy_pressure_ulcer_length varchar(10),
oasis_therapy_pressure_ulcer_width varchar(10),
oasis_therapy_pressure_ulcer_depth varchar(10),
oasis_therapy_pressure_ulcer_problematic_status varchar(2),
oasis_therapy_pressure_ulcer_current_no varchar(1),
oasis_therapy_pressure_ulcer_stage_unhealed varchar(2),
oasis_therapy_pressure_ulcer_statis_ulcer varchar(1),
oasis_therapy_pressure_ulcer_statis_ulcer_num varchar(1),
oasis_therapy_pressure_ulcer_statis_ulcer_status varchar(1),
oasis_therapy_surgical_wound varchar(1),
oasis_therapy_status_surgical_wound varchar(1),
oasis_therapy_skin_lesion varchar(1),
oasis_therapy_integumentary_status_problem varchar(2),
oasis_therapy_wound_care_done varchar(3),
oasis_therapy_wound_location varchar(20),
oasis_therapy_wound TEXT,
oasis_therapy_wound_soiled_dressing_by varchar(20),
oasis_therapy_wound_soiled_technique varchar(10),
oasis_therapy_wound_cleaned varchar(20),
oasis_therapy_wound_irrigated varchar(20),
oasis_therapy_wound_packed varchar(20),
oasis_therapy_wound_dressing_apply varchar(20),
oasis_therapy_wound_incision varchar(20),
oasis_therapy_wound_comment TEXT,
oasis_therapy_satisfactory_return_demo varchar(3),
oasis_therapy_wound_education varchar(3),
oasis_therapy_wound_education_comment TEXT,
oasis_therapy_respiratory_status varchar(1),
oasis_therapy_respiratory_treatment varchar(10),
oasis_cardiac_status_symptoms varchar(2),
oasis_cardiac_status_heart_failure varchar(12),
oasis_elimination_status_tract_infection varchar(2),
oasis_elimination_status_urinary_incontinence varchar(1),
oasis_elimination_status_urinary_incontinence_occur varchar(1),
oasis_elimination_status_bowel_incontinence varchar(2),
oasis_neuro_cognitive_functioning varchar(1),
oasis_neuro_when_confused varchar(2),
oasis_neuro_when_anxious varchar(2),
oasis_neuro_cognitive_symptoms varchar(20),
oasis_neuro_frequency_disruptive varchar(1),
oasis_adl_grooming varchar(1) default NULL,
oasis_adl_dress_upper varchar(1) default NULL,
oasis_adl_dress_lower varchar(1) default NULL,
oasis_adl_wash varchar(1) default NULL,
oasis_adl_toilet_transfer varchar(1) default NULL,
oasis_adl_toileting_hygiene varchar(1) default NULL,
oasis_adl_transferring varchar(1) default NULL,
oasis_adl_ambulation varchar(1) default NULL,
oasis_adl_feeding_eating varchar(1) default NULL,
oasis_adl_current_ability varchar(1) default NULL,
oasis_adl_use_telephone varchar(2) default NULL,
oasis_medication_intervention varchar(2),
oasis_medication_drug_education varchar(2),
oasis_medication_oral varchar(2),
oasis_medication_injectable varchar(2),
oasis_care_adl_assistance varchar(2) default NULL,
oasis_care_iadl_assistance varchar(2) default NULL,
oasis_care_medication_admin varchar(2) default NULL,
oasis_care_medical_procedures varchar(2) default NULL,
oasis_care_management_equip varchar(2) default NULL,
oasis_care_supervision_safety varchar(2) default NULL,
oasis_care_advocacy_facilitation varchar(2) default NULL,
oasis_care_how_often varchar(2) default NULL,
oasis_emergent_care varchar(2),
oasis_emergent_care_reason varchar(50),
oasis_data_items_a varchar(2),
oasis_data_items_b varchar(2),
oasis_data_items_c varchar(2),
oasis_data_items_d varchar(2),
oasis_data_items_e varchar(2),
oasis_data_items_f varchar(2),
oasis_inpatient_facility varchar(2),
oasis_discharge_disposition varchar(2),
Reason_for_Hospitalization text,
patient_Admitted_to_a_Nursing_Home text,
non_oasis_infusion text,
non_oasis_infusion_peripheral varchar(100) DEFAULT NULL,
non_oasis_infusion_PICC varchar(100) DEFAULT NULL,
non_oasis_infusion_central varchar(20) DEFAULT NULL,
non_oasis_infusion_central_date date DEFAULT NULL,
non_oasis_infusion_xray varchar(10) DEFAULT NULL,
non_oasis_infusion_circum INT DEFAULT '0',
non_oasis_infusion_length INT DEFAULT '0',
non_oasis_infusion_hickman varchar(20) DEFAULT NULL,
non_oasis_infusion_hickman_date date DEFAULT NULL,
non_oasis_infusion_epidural_date date DEFAULT NULL,
non_oasis_infusion_implanted_date date DEFAULT NULL,
non_oasis_infusion_intrathecal_date date DEFAULT NULL,
non_oasis_infusion_med1_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med1_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med2_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_admin varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_name varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_dose varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_dilution varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_route varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_med3_duration varchar(50) DEFAULT NULL,
non_oasis_infusion_pump varchar(50) DEFAULT NULL,
non_oasis_infusion_admin_by varchar(50) DEFAULT NULL,
non_oasis_infusion_admin_by_other varchar(50) DEFAULT NULL,
non_oasis_infusion_purpose text,
non_oasis_infusion_purpose_other varchar(100) DEFAULT NULL,
non_oasis_infusion_care_provided text,
non_oasis_infusion_dressing varchar(20) DEFAULT NULL,
non_oasis_infusion_performed_by varchar(20) DEFAULT NULL,
non_oasis_infusion_frequency varchar(50) DEFAULT NULL,
non_oasis_infusion_injection varchar(50) DEFAULT NULL,
non_oasis_infusion_labs_drawn text,
non_oasis_infusion_interventions text,
non_oasis_enteral varchar(100) DEFAULT NULL,
non_oasis_enteral_other varchar(50) DEFAULT NULL,
non_oasis_enteral_pump varchar(50) DEFAULT NULL,
non_oasis_enteral_feedings varchar(20) DEFAULT NULL,
non_oasis_enteral_rate varchar(50) DEFAULT NULL,
non_oasis_enteral_flush text,
non_oasis_enteral_performed_by varchar(20) DEFAULT NULL,
non_oasis_enteral_performed_by_other varchar(50) DEFAULT NULL,
non_oasis_enteral_dressing text,
non_oasis_enteral_interventions text,
non_oasis_skilled_care varchar(50) DEFAULT NULL,
oasis_discharge_date_last_visit DATE,
oasis_discharge_transfer_date DATE,
non_oasis_summary_disciplines varchar(50) DEFAULT NULL,
non_oasis_summary_disciplines_other varchar(50) DEFAULT NULL,
non_oasis_summary_physician varchar(10) DEFAULT NULL,
non_oasis_summary_elsewhere varchar(5) DEFAULT NULL,
non_oasis_summary_reason mediumtext,
non_oasis_summary_medication varchar(50) DEFAULT NULL,
non_oasis_summary_medication_identified mediumtext DEFAULT NULL,
non_oasis_summary_reason_discharge text,
non_oasis_summary_reason_discharge_explain varchar(50) DEFAULT NULL,
non_oasis_summary_reason_discharge_other varchar(80) DEFAULT NULL,
non_oasis_summary_discharge_inst text,
non_oasis_summary_reviewed varchar(80) DEFAULT NULL,
non_oasis_summary_reviewed_other varchar(80) DEFAULT NULL,
non_oasis_summary_immunization varchar(10) DEFAULT NULL,
non_oasis_summary_immun_explain varchar(100) DEFAULT NULL,
non_oasis_summary_written varchar(10) DEFAULT NULL,
non_oasis_summary_written_explain varchar(100) DEFAULT NULL,
non_oasis_summary_demonstrates varchar(10) DEFAULT NULL,
non_oasis_summary_demonstrates_explain varchar(100) DEFAULT NULL
 ) engine=MyISAM;
#EndIf

#IfNotRow registry directory oasis_discharge
INSERT INTO `registry` VALUES ('OASIS Discharge', 1, 'oasis_discharge', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');
#EndIf

#IfNotRow2D registry directory oasis_discharge category OASIS
UPDATE registry SET category='OASIS' WHERE directory='oasis_discharge';
#EndIf



#IfNotTable forms_oasis_c_nurse
CREATE TABLE IF NOT EXISTS `forms_oasis_c_nurse` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(100) default NULL,
groupname varchar(100) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
detail varchar(100),
process varchar(100),
data varchar(100),
label varchar(100),
oasis_c_nurse_patient_name varchar(100) DEFAULT NULL,
oasis_c_nurse_caregiver varchar(100) DEFAULT NULL,
oasis_c_nurse_visit_date date default NULL,
oasis_c_nurse_time_in varchar(10) DEFAULT NULL,
oasis_c_nurse_time_out varchar(10) DEFAULT NULL,
oasis_c_nurse_cms_no varchar(10) DEFAULT NULL,
oasis_c_nurse_branch_state varchar(80) DEFAULT NULL,
oasis_c_nurse_branch_id_no varchar(10) DEFAULT NULL,
oasis_c_nurse_npi varchar(40) DEFAULT NULL,
oasis_c_nurse_npi_na varchar(5) DEFAULT NULL,
oasis_c_nurse_referring_physician_id varchar(10) DEFAULT NULL,
oasis_c_nurse_referring_physician_id_na varchar(5) DEFAULT NULL,
oasis_c_nurse_primary_physician_last varchar(100) DEFAULT NULL,
oasis_c_nurse_primary_physician_first varchar(100) DEFAULT NULL,
oasis_c_nurse_primary_physician_phone varchar(20) DEFAULT NULL,
oasis_c_nurse_primary_physician_address varchar(225) DEFAULT NULL,
oasis_c_nurse_primary_physician_city varchar(100) DEFAULT NULL,
oasis_c_nurse_primary_physician_state varchar(100) DEFAULT NULL,
oasis_c_nurse_primary_physician_zip varchar(20) DEFAULT NULL,
oasis_c_nurse_other_physician_last varchar(100) DEFAULT NULL,
oasis_c_nurse_other_physician_first varchar(100) DEFAULT NULL,
oasis_c_nurse_other_physician_phone varchar(20) DEFAULT NULL,
oasis_c_nurse_other_physician_address varchar(225) DEFAULT NULL,
oasis_c_nurse_other_physician_city varchar(50) DEFAULT NULL,
oasis_c_nurse_other_physician_state varchar(50) DEFAULT NULL,
oasis_c_nurse_other_physician_zip varchar(20) DEFAULT NULL,
oasis_c_nurse_patient_id varchar(10) DEFAULT NULL,
oasis_c_nurse_soc_date date default NULL,
oasis_c_nurse_patient_name_first varchar(100) DEFAULT NULL,
oasis_c_nurse_patient_name_mi varchar(100) DEFAULT NULL,
oasis_c_nurse_patient_name_last varchar(100) DEFAULT NULL,
oasis_c_nurse_patient_name_suffix varchar(50) DEFAULT NULL,
oasis_c_nurse_patient_address_street varchar(225) DEFAULT NULL,
oasis_c_nurse_patient_address_city varchar(80) DEFAULT NULL,
oasis_c_nurse_patient_phone varchar(20) DEFAULT NULL,
oasis_c_nurse_patient_state varchar(80) DEFAULT NULL,
oasis_c_nurse_patient_zip varchar(20) DEFAULT NULL,
oasis_c_nurse_medicare_no varchar(10) DEFAULT NULL,
oasis_c_nurse_medicare_no_na varchar(30) DEFAULT NULL,
oasis_c_nurse_ssn varchar(50) DEFAULT NULL,
oasis_c_nurse_ssn_na varchar(30) DEFAULT NULL,
oasis_c_nurse_medicaid_no varchar(50) DEFAULT NULL,
oasis_c_nurse_medicaid_no_na varchar(30) DEFAULT NULL,
oasis_c_nurse_birth_date date default NULL,
oasis_c_nurse_patient_gender varchar(10) DEFAULT NULL,
oasis_c_nurse_payment_source_homecare varchar(100) DEFAULT NULL,
oasis_c_nurse_discipline_person varchar(10) DEFAULT NULL,
oasis_c_nurse_date_assessment_completed date default NULL,
oasis_c_nurse_follow_up varchar(10) DEFAULT NULL,
oasis_c_nurse_episode_timing varchar(20) DEFAULT NULL,
oasis_c_nurse_certification_period_from date default NULL,
oasis_c_nurse_certification_period_to date default NULL,
oasis_patient_diagnosis_1a varchar(10),
oasis_patient_diagnosis_2a varchar(10),
oasis_patient_diagnosis_2a_sub varchar(10),
oasis_patient_diagnosis_3a varchar(10),
oasis_patient_diagnosis_4a varchar(10),
oasis_patient_diagnosis_1b varchar(10),
oasis_patient_diagnosis_2b varchar(10),
oasis_patient_diagnosis_2b_sub varchar(10),
oasis_patient_diagnosis_3b varchar(10),
oasis_patient_diagnosis_4b varchar(10),
oasis_patient_diagnosis_1c varchar(10),
oasis_patient_diagnosis_2c varchar(10),
oasis_patient_diagnosis_2c_sub varchar(10),
oasis_patient_diagnosis_3c varchar(10),
oasis_patient_diagnosis_4c varchar(10),
oasis_patient_diagnosis_1d varchar(10),
oasis_patient_diagnosis_2d varchar(10),
oasis_patient_diagnosis_2d_sub varchar(10),
oasis_patient_diagnosis_3d varchar(10),
oasis_patient_diagnosis_4d varchar(10),
oasis_patient_diagnosis_1e varchar(10),
oasis_patient_diagnosis_2e varchar(10),
oasis_patient_diagnosis_2e_sub varchar(10),
oasis_patient_diagnosis_3e varchar(10),
oasis_patient_diagnosis_4e varchar(10),
oasis_patient_diagnosis_1f varchar(10),
oasis_patient_diagnosis_2f varchar(10),
oasis_patient_diagnosis_2f_sub varchar(10),
oasis_patient_diagnosis_3f varchar(10),
oasis_patient_diagnosis_4f varchar(10),
oasis_patient_diagnosis_1g varchar(10),
oasis_patient_diagnosis_2g varchar(10),
oasis_patient_diagnosis_2g_sub varchar(10),
oasis_patient_diagnosis_3g varchar(10),
oasis_patient_diagnosis_4g varchar(10),
oasis_patient_diagnosis_1h varchar(10),
oasis_patient_diagnosis_2h varchar(10),
oasis_patient_diagnosis_2h_sub varchar(10),
oasis_patient_diagnosis_3h varchar(10),
oasis_patient_diagnosis_4h varchar(10),
oasis_patient_diagnosis_1i varchar(10),
oasis_patient_diagnosis_2i varchar(10),
oasis_patient_diagnosis_2i_sub varchar(10),
oasis_patient_diagnosis_3i varchar(10),
oasis_patient_diagnosis_4i varchar(10),
oasis_patient_diagnosis_1j varchar(10),
oasis_patient_diagnosis_2j varchar(10),
oasis_patient_diagnosis_2j_sub varchar(10),
oasis_patient_diagnosis_3j varchar(10),
oasis_patient_diagnosis_4j varchar(10),
oasis_patient_diagnosis_1k varchar(10),
oasis_patient_diagnosis_2k varchar(10),
oasis_patient_diagnosis_2k_sub varchar(10),
oasis_patient_diagnosis_3k varchar(10),
oasis_patient_diagnosis_4k varchar(10),
oasis_patient_diagnosis_1l varchar(10),
oasis_patient_diagnosis_2l varchar(10),
oasis_patient_diagnosis_2l_sub varchar(10),
oasis_patient_diagnosis_3l varchar(10),
oasis_patient_diagnosis_4l varchar(10),
oasis_patient_diagnosis_1m varchar(10),
oasis_patient_diagnosis_2m varchar(10),
oasis_patient_diagnosis_2m_sub varchar(10),
oasis_patient_diagnosis_3m varchar(10),
oasis_patient_diagnosis_4m varchar(10),
oasis_surgical_procedure_a varchar(10),
oasis_surgical_procedure_a_date date default NULL,
oasis_surgical_procedure_b varchar(10),
oasis_surgical_procedure_b_date date default NULL,
oasis_c_nurse_therapies_home  varchar(10) DEFAULT NULL,
oasis_c_nurse_vision varchar(2) DEFAULT NULL,
oasis_c_nurse_prognosis varchar(2) DEFAULT NULL,
oasis_c_nurse_frequency_pain varchar(2) DEFAULT NULL,
oasis_c_nurse_pain_scale varchar(2) DEFAULT NULL,
oasis_c_nurse_pain_location_cause varchar(100) DEFAULT NULL,
oasis_c_nurse_pain_description varchar(15) DEFAULT NULL,
oasis_c_nurse_pain_frequency varchar(15) DEFAULT NULL,
oasis_c_nurse_pain_aggravating_factors varchar(15) DEFAULT NULL,
oasis_c_nurse_pain_aggravating_factors_other text,
oasis_c_nurse_pain_relieving_factors varchar(15) DEFAULT NULL,
oasis_c_nurse_pain_relieving_factors_other text,
oasis_c_nurse_pain_activities_limited text,
oasis_c_nurse_experiencing_pain varchar(3) DEFAULT NULL,
oasis_c_nurse_unable_to_communicate varchar(30) DEFAULT NULL,
oasis_c_nurse_non_verbal_demonstrated varchar(30) DEFAULT NULL,
oasis_c_nurse_non_verbal_demonstrated_other text,
oasis_c_nurse_non_verbal_demonstrated_implications text,
oasis_c_nurse_breakthrough_medication varchar(50) DEFAULT NULL,
oasis_c_nurse_breakthrough_medication_other text,
oasis_c_nurse_implications_care_plan varchar(10) DEFAULT NULL,
oasis_integumentary_status_problem varchar(30),
oasis_wound_care_done varchar(10),
oasis_wound_location varchar(200),
oasis_wound text,
oasis_wound_soiled_dressing_by varchar(50),
oasis_wound_soiled_technique varchar(10),
oasis_wound_cleaned varchar(200),
oasis_wound_irrigated varchar(200),
oasis_wound_packed varchar(200),
oasis_wound_dressing_apply varchar(200),
oasis_wound_incision varchar(200),
oasis_wound_comment text,
oasis_satisfactory_return_demo varchar(10),
oasis_wound_education varchar(10),
oasis_wound_education_comment text,
oasis_wound_lesion_location text,
oasis_wound_lesion_type text,
oasis_wound_lesion_status text,
oasis_wound_lesion_size_length varchar(30),
oasis_wound_lesion_size_width varchar(30),
oasis_wound_lesion_size_depth varchar(30),
oasis_wound_lesion_stage text,
oasis_wound_lesion_tunneling text,
oasis_wound_lesion_odor text,
oasis_wound_lesion_skin text,
oasis_wound_lesion_edema text,
oasis_wound_lesion_stoma text,
oasis_wound_lesion_appearance text,
oasis_wound_lesion_drainage text,
oasis_wound_lesion_color text,
oasis_wound_lesion_consistency text,
oasis_integumentary_status varchar(10),
oasis_braden_scale_sensory INT(10) DEFAULT '0',
oasis_braden_scale_moisture INT(10) DEFAULT '0',
oasis_braden_scale_activity INT(10) DEFAULT '0',
oasis_braden_scale_mobility INT(10) DEFAULT '0',
oasis_braden_scale_nutrition INT(10) DEFAULT '0',
oasis_braden_scale_friction INT(10) DEFAULT '0',
oasis_braden_scale_total INT(10) DEFAULT '0',
oasis_c_nurse_stage2_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage2_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage3_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage3_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage4_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_stage4_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_non_removable_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_non_removable_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_coverage_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_coverage_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_suspected_col1 varchar(100) DEFAULT NULL,
oasis_c_nurse_suspected_col2 varchar(100) DEFAULT NULL,
oasis_c_nurse_current_ulcer_stage1 varchar(10),
oasis_c_nurse_stage_of_problematic_ulcer varchar(10),
oasis_c_nurse_statis_ulcer varchar(10),
oasis_c_nurse_current_no_statis_ulcer varchar(10),
oasis_c_nurse_problematic_statis_ulcer varchar(10),
oasis_c_nurse_surgical_wound varchar(10),
oasis_c_nurse_problematic_surgical_wound varchar(10),
oasis_c_nurse_skin_lesion varchar(10),
oasis_c_nurse_bp_lying_right varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_lying_left varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_sitting_right varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_sitting_left varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_standing_right varchar(50) DEFAULT NULL,
oasis_c_nurse_bp_standing_left varchar(50) DEFAULT NULL,
oasis_c_nurse_vital_sign_temperature varchar(50) DEFAULT NULL,
oasis_c_nurse_vital_pulse text,
oasis_c_nurse_vital_sign_respiratory_rate varchar(100) DEFAULT NULL,	
oasis_c_nurse_cardiopulmonary_problem varchar(20) DEFAULT NULL,
oasis_c_nurse_breath_sounds_type varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds text,
oasis_c_nurse_breath_sounds_anterior varchar(20) DEFAULT NULL,
oasis_c_nurse_breath_sounds_posterior varchar(20) DEFAULT NULL,
oasis_c_nurse_breath_sounds_o2_saturation varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_accessory_muscle varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_accessory_muscle_o2 varchar(30) DEFAULT NULL,
oasis_c_nurse_breath_sounds_o2 varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_accessory_lpm varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_trach varchar(15) DEFAULT NULL,
oasis_c_nurse_breath_sounds_trach_manages varchar(50) DEFAULT NULL,
oasis_c_nurse_breath_sounds_cough varchar(50) DEFAULT NULL,
oasis_c_nurse_breath_sounds_productive varchar(50) DEFAULT NULL,
oasis_c_nurse_cardio_breath_color varchar(100) DEFAULT NULL,
oasis_c_nurse_cardio_breath_amt varchar(100) DEFAULT NULL,
oasis_c_nurse_breath_sounds_other varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_type varchar(50) DEFAULT NULL,
oasis_c_nurse_heart_sounds text,
oasis_c_nurse_heart_sounds_pacemaker varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_pacemaker_date date default NULL,
oasis_c_nurse_heart_sounds_pacemaker_type varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_chest_pain varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_associated_with varchar(100) DEFAULT NULL,
oasis_c_nurse_heart_sounds_frequency varchar(50) DEFAULT NULL,
oasis_c_nurse_heart_sounds_edema varchar(50) DEFAULT NULL,
oasis_c_nurse_heart_sounds_edema_dependent varchar(80) DEFAULT NULL,
oasis_c_nurse_heart_sounds_site varchar(30) DEFAULT NULL,
oasis_c_nurse_heart_sounds_capillary varchar(50) DEFAULT NULL,
oasis_c_nurse_heart_sounds_other varchar(100) DEFAULT NULL,
oasis_c_nurse_weight_variation varchar(100) DEFAULT NULL,
oasis_c_nurse_respiratory_status varchar(10) DEFAULT NULL,
oasis_c_nurse_urinary_problem varchar(20) DEFAULT NULL,
oasis_c_nurse_urinary text,
oasis_c_nurse_urinary_incontinence varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_management_strategy varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_diapers_other varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_color varchar(75) DEFAULT NULL,
oasis_c_nurse_urinary_color_other varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_clarity varchar(50) DEFAULT NULL,
oasis_c_nurse_urinary_odor varchar(10) DEFAULT NULL,
oasis_c_nurse_urinary_catheter varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_foley_date date default NULL,
oasis_c_nurse_urinary_foley_ml varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_solution varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_amount varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_ml varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_frequency varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_irrigation_returns varchar(100) DEFAULT NULL,
oasis_c_nurse_urinary_tolerated_procedure varchar(50) DEFAULT NULL,
oasis_c_nurse_urinary_other varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_problem varchar(20) DEFAULT NULL,
oasis_c_nurse_bowels text,
oasis_c_nurse_bowel_regime varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_lexative_enema varchar(20) DEFAULT NULL,
oasis_c_nurse_bowels_lexative_enema_other varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_incontinence varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_diapers_others varchar(100) DEFAULT NULL,
oasis_c_nurse_bowels_ileostomy_site text,
oasis_c_nurse_bowels_ostomy_care varchar(30) DEFAULT NULL,
oasis_c_nurse_bowels_other_site text,
oasis_c_nurse_bowels_urostomy text,
oasis_c_nurse_elimination_urinary_incontinence varchar(10) DEFAULT NULL,
oasis_c_nurse_elimination_bowel_incontinence varchar(10) DEFAULT NULL,
oasis_c_nurse_elimination_ostomy varchar(10) DEFAULT NULL,
oasis_c_nurse_adl_dress_upper varchar(10) DEFAULT NULL,
oasis_c_nurse_adl_dress_lower varchar(10) DEFAULT NULL,
oasis_c_nurse_adl_wash varchar(5) DEFAULT NULL,
oasis_c_nurse_adl_toilet_transfer varchar(5) DEFAULT NULL,
oasis_c_nurse_adl_transferring varchar(5) DEFAULT NULL,
oasis_c_nurse_adl_ambulation varchar(5) DEFAULT NULL,
oasis_c_nurse_activities_permitted text,
oasis_c_nurse_activities_permitted_other varchar(100) DEFAULT NULL,
oasis_c_nurse_medication varchar(10) DEFAULT NULL,
oasis_c_nurse_therapy_need_number varchar(100) DEFAULT NULL,
oasis_c_nurse_therapy_need varchar(5) DEFAULT NULL,
oasis_c_nurse_fall_risk_reported varchar(5) DEFAULT NULL,
oasis_c_nurse_fall_risk_reported_details text,
oasis_c_nurse_fall_risk_factors varchar(5) DEFAULT NULL,
oasis_c_nurse_fall_risk_factors_details text,
oasis_c_nurse_fall_risk_assessment text,
oasis_c_nurse_fall_risk_assessment_total varchar(100) DEFAULT NULL,
oasis_c_nurse_fall_risk_assessment_comments text,
oasis_c_nurse_enteral text,
oasis_c_nurse_enteral_other varchar(100) DEFAULT NULL,
oasis_c_nurse_enteral_pump varchar(100) DEFAULT NULL,
oasis_c_nurse_enteral_feedings varchar(30) DEFAULT NULL,
oasis_c_nurse_enteral_rate varchar(100) DEFAULT NULL,
oasis_c_nurse_enteral_flush text,
oasis_c_nurse_enteral_performed_by varchar(30) DEFAULT NULL,
oasis_c_nurse_enteral_performed_by_other varchar(200) DEFAULT NULL,
oasis_c_nurse_enteral_dressing text,
oasis_c_nurse_infusion text,
oasis_c_nurse_infusion_peripheral varchar(200) DEFAULT NULL,
oasis_c_nurse_infusion_PICC varchar(200) DEFAULT NULL,
oasis_c_nurse_infusion_central varchar(30) DEFAULT NULL,
oasis_c_nurse_infusion_central_date date default NULL,
oasis_c_nurse_infusion_xray varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_circum varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_length varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_hickman varchar(20) DEFAULT NULL,
oasis_c_nurse_infusion_hickman_date date default NULL,
oasis_c_nurse_infusion_epidural_date date default NULL,
oasis_c_nurse_infusion_implanted_date date default NULL,
oasis_c_nurse_infusion_intrathecal_date date default NULL,
oasis_c_nurse_infusion_med1_admin varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med1_name varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med1_dose varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med1_dilution varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med1_route varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med1_frequency varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med1_duration varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med2_admin varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med2_name varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med2_dose varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med2_dilution varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med2_route varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med2_frequency varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med2_duration varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med3_admin varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med3_name varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med3_dose varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med3_dilution varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_med3_route varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_med3_frequency varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_med3_duration varchar(5) DEFAULT NULL,
oasis_c_nurse_infusion_pump varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_admin_by varchar(15) DEFAULT NULL,
oasis_c_nurse_infusion_admin_by_other varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_dressing varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_performed_by varchar(10) DEFAULT NULL,
oasis_c_nurse_infusion_performed_by_other varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_frequency varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_injection varchar(100) DEFAULT NULL,
oasis_c_nurse_infusion_labs_drawn text,
oasis_c_nurse_timed_up_trial1 varchar(5) DEFAULT NULL,
oasis_c_nurse_timed_up_trial2 varchar(5) DEFAULT NULL,
oasis_c_nurse_timed_up_average varchar(5) DEFAULT NULL,
oasis_c_nurse_amplification_care_provided text,
oasis_c_nurse_amplification_patient_response text,
oasis_c_nurse_homebound_reason text,
oasis_c_nurse_homebound_reason_other varchar(100) DEFAULT NULL,
oasis_c_nurse_summary_check_careplan varchar(50) DEFAULT NULL,
oasis_c_nurse_summary_check_medication varchar(80) DEFAULT NULL,
oasis_c_nurse_summary_check_identified text,
oasis_c_nurse_summary_check_care_coordination varchar(15) DEFAULT NULL,
oasis_c_nurse_summary_check_carecordination_other varchar(100) DEFAULT NULL,
oasis_c_nurse_summary_check_referrel varchar(100) DEFAULT NULL,
oasis_c_nurse_summary_check_next_visit date default NULL,
oasis_c_nurse_summary_check_recertification varchar(3) DEFAULT NULL,
oasis_c_nurse_summary_check_verbal_order varchar(3) DEFAULT NULL,
oasis_c_nurse_summary_verbal_order_date date default NULL,
oasis_c_nurse_dme varchar(2) DEFAULT NULL,
oasis_c_nurse_dme_wound_care text,
oasis_c_nurse_dme_wound_care_glove varchar(15) DEFAULT NULL,
oasis_c_nurse_dme_wound_care_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_diabetic text,
oasis_c_nurse_dme_diabetic_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_iv_supplies text,
oasis_c_nurse_dme_iv_supplies_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_foley_supplies text,
oasis_c_nurse_dme_foley_supplies_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_urinary text,
oasis_c_nurse_dme_ostomy_pouch_brand varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_ostomy_pouch_size varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_ostomy_wafer_brand varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_ostomy_wafer_size varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_urinary_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_miscellaneous text,
oasis_c_nurse_dme_miscellaneous_type varchar(80) DEFAULT NULL,
oasis_c_nurse_dme_miscellaneous_size varchar(20) DEFAULT NULL,
oasis_c_nurse_dme_miscellaneous_other varchar(100) DEFAULT NULL,
oasis_c_nurse_dme_supplies text,
oasis_c_nurse_dme_supplies_other varchar(100) DEFAULT NULL,
oasis_c_nurse_safety_measures text,
oasis_c_nurse_safety_measures_other varchar(100) DEFAULT NULL,
oasis_c_nurse_nutritional_requirement text,
oasis_c_nurse_nutritional_requirement_other varchar(100) DEFAULT NULL,
oasis_c_nurse_allergies text,
oasis_c_nurse_nutritional_allergies_other varchar(100) DEFAULT NULL,
oasis_c_nurse_functional_limitations text,
oasis_c_nurse_functional_limitations_other varchar(100) DEFAULT NULL,
oasis_c_nurse_mental_status text,
oasis_c_nurse_mental_status_other varchar(100) DEFAULT NULL,
oasis_c_nurse_discharge_plan text,
oasis_c_nurse_discharge_plan_other varchar(100) DEFAULT NULL,
oasis_c_nurse_discharge_plan_detail text,
oasis_c_nurse_discharge_plan_detail_other varchar(100) DEFAULT NULL,
 oasis_professional_vital_signs varchar(50) default NULL,
 oasis_professional_sn  varchar(30) default NULL,
 oasis_professional_vital_parameter text,
 oasis_professional_heart_rate0 varchar(10) default NULL,
 oasis_professional_heart_rate varchar(10) default NULL,
 oasis_professional_temperature0 varchar(10) default NULL,
 oasis_professional_temperature varchar(10) default NULL,
 oasis_professional_BP_systolic0 varchar(10) default NULL,
 oasis_professional_BP_systolic varchar(10) default NULL,
 oasis_professional_BP_diastolic0 varchar(10) default NULL,
 oasis_professional_BP_diastolic varchar(10) default NULL,
 oasis_professional_respirations0 varchar(10) default NULL,
 oasis_professional_respirations varchar(10) default NULL,
 oasis_professional_vital_other varchar(30) default NULL,
 oasis_professional_blood_glucose varchar(50) default NULL,
 oasis_professional_blood_glucose_BS_gt varchar(30) default NULL,
 oasis_professional_blood_glucose_BS_lt varchar(30) default NULL,
 oasis_professional_receive_orders_from varchar(30) default NULL,
 oasis_professional_sn_parameters text,
 oasis_professional_sn1 varchar(15) default NULL,
 oasis_professional_sn2 varchar(30) default NULL,
 oasis_professional_sn_every_visit varchar(30) default NULL,
 oasis_professional_sn_PRN_dyspnea text,
 oasis_professional_sn_other varchar(30) default NULL,
 oasis_professional_sn_frequency text,
 oasis_professional_PRN_visits_for varchar(30) default NULL,
 oasis_professional_sn_frequency_other varchar(30) default NULL,
 oasis_professional_goals text,
 oasis_professional_sn_provide text,
 oasis_professional_teaching_activities text,
 oasis_professional_goal_other varchar(30) default NULL,
 oasis_professional_decreased_to varchar(30) default NULL,
 oasis_professional_goal_other1 varchar(30) default NULL,
 oasis_professional_skilled_nurse1 text,
 oasis_professional_nurse_PICC varchar(50) default NULL,
 oasis_PICC_socl_before varchar(30) default NULL,
 oasis_PICC_socl_percent_before varchar(30) default NULL,
 oasis_PICC_socl_percent_after varchar(30) default NULL,
 oasis_PICC_socl_after varchar(30) default NULL,
 oasis_professional_heparin varchar(30) default NULL,
 oasis_PICC_dressing_change varchar(30) default NULL,
 oasis_PICC_injection_cap varchar(30) default NULL,
 oasis_PICC_extension_set varchar(30) default NULL,
 oasis_professional_nurse_peripheral varchar(50) default NULL,
 oasis_peripheral_socl_before varchar(30) default NULL,
 oasis_peripheral_socl_percent_before varchar(30) default NULL,
 oasis_peripheral_socl_after varchar(30) default NULL,
 oasis_peripheral_socl_percent_after varchar(30) default NULL,
 oasis_peripheral_heparin varchar(30) default NULL,
 oasis_professional_nurse_port varchar(50) default NULL,
 oasis_professional_nurse_use varchar(50) default NULL,
 oasis_PORT_socl_before varchar(30) default NULL,
 oasis_PORT_socl_percent_before varchar(30) default NULL,
 oasis_PORT_socl_percent_after varchar(30) default NULL,
 oasis_PORT_socl_after varchar(30) default NULL,
 oasis_PORT_heparin varchar(30) default NULL,
 oasis_PORT_dressing_change varchar(30) default NULL,
 oasis_PORT_injection_cap varchar(30) default NULL,
 oasis_PORT_extension_set varchar(30) default NULL,
 oasis_access_socl_after varchar(30) default NULL,
 oasis_access_socl_percent_after varchar(30) default NULL,
 oasis_access_heparin varchar(30) default NULL,
 oasis_professional_skilled_nurse2 text,
 oasis_professional_sn_nurse text,
 oasis_professional_sn_nurse_tube varchar(20) default NULL,
 oasis_professional_sn_nurse_tube_other varchar(30) default NULL,
 oasis_professional_sn_nurse_pump varchar(30) default NULL,
 oasis_professional_sn_nurse_feedings varchar(30) default NULL,
 oasis_professional_sn_nurse_continuous_rate varchar(30) default NULL,
 oasis_professional_flush_protocol varchar(30) default NULL,
 oasis_professional_formula varchar(30) default NULL,
 oasis_sn_nurse_performed_by varchar(30) default NULL,
 oasis_sn_nurse_performed_by_other varchar(30) default NULL,
 oasis_sn_nurse_dressing varchar(30) default NULL,
 oasis_sn_nurse_dressing_other varchar(30) default NULL,
 oasis_sn_nurse_wound_vac varchar(30) default NULL,
 oasis_sn_nurse_dressing_other1 varchar(30) default NULL,
 oasis_professional_sn_nurse1 text,
 oasis_professional_sn_nurse1_other varchar(30) default NULL,
 oasis_professional_sn_nurse2 text,
 oasis_professional_sn_nurse2_fr varchar(30) default NULL,
 oasis_professional_sn_nurse2_ml varchar(30) default NULL,
 oasis_catheter_std_protocol varchar(50) default NULL,
 oasis_catheter_MD varchar(50) default NULL,
 oasis_catheter_weeks varchar(10) default NULL,
 oasis_catheter_normal_saline_from varchar(10) default NULL,
 oasis_catheter_normal_saline_to varchar(10) default NULL,
 oasis_catheter_insertion_weeks varchar(10) default NULL,
 oasis_catheter_insertion_fr varchar(10) default NULL,
 oasis_catheter_insertion_ml varchar(10) default NULL,
 oasis_catheter_care_other varchar(30) default NULL,
 oasis_professional_sn_nurse2_venipuncture varchar(30) default NULL,
 oasis_professional_sn_nurse2_frequency varchar(30) default NULL,
 oasis_professional_sn_nurse2_other1 varchar(30) default NULL,
 oasis_professional_sn_nurse2_other2 varchar(30) default NULL,
 oasis_signature_last_name varchar(30) default NULL,
 oasis_signature_first_name varchar(30) default NULL,
 oasis_signature_middle_init varchar(30) default NULL
) engine=MyISAM;
#EndIf

#IfNotRow registry directory oasis_c_nurse
INSERT INTO `registry` VALUES ('OASIS Recert-Nursing', 1, 'oasis_c_nurse', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');
#EndIf

#IfNotRow2D registry directory oasis_c_nurse category OASIS
UPDATE registry SET category='OASIS' WHERE directory='oasis_c_nurse';
#EndIf



#IfNotTable forms_oasis_therapy_rectification
CREATE TABLE IF NOT EXISTS `forms_oasis_therapy_rectification` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
detail varchar(100),
process varchar(100),
data varchar(100),
label varchar(100),
oasis_therapy_patient_name varchar(50),
oasis_therapy_caregiver  varchar(50),
oasis_therapy_visit_date DATE,
time_in varchar(10),
time_out varchar(10),
oasis_therapy_cms_no varchar(20),
oasis_therapy_branch_state varchar(20),
oasis_therapy_branch_id_no varchar(20),
oasis_therapy_npi varchar(20),
oasis_therapy_npi_na varchar(4),
oasis_therapy_referring_physician_id varchar(20),
oasis_therapy_referring_physician_id_na varchar(4),
oasis_therapy_primary_physician_last varchar(20),
oasis_therapy_primary_physician_first varchar(20),
oasis_therapy_primary_physician_phone varchar(20),
oasis_therapy_primary_physician_address varchar(40),
oasis_therapy_primary_physician_city varchar(20),
oasis_therapy_primary_physician_state varchar(20),
oasis_therapy_primary_physician_zip varchar(10),
oasis_therapy_other_physician_last varchar(20),
oasis_therapy_other_physician_first varchar(20),
oasis_therapy_other_physician_phone varchar(20),
oasis_therapy_other_physician_address varchar(40),
oasis_therapy_other_physician_city varchar(20),
oasis_therapy_other_physician_state varchar(20),
oasis_therapy_other_physician_zip varchar(10),
oasis_therapy_patient_id varchar(10),
oasis_therapy_soc_date DATE,
oasis_therapy_patient_name_first varchar(20),
oasis_therapy_patient_name_mi varchar(20),
oasis_therapy_patient_name_last varchar(20),
oasis_therapy_patient_name_suffix varchar(20),
oasis_therapy_patient_address_street varchar(20),
oasis_therapy_patient_address_city varchar(20),
oasis_therapy_patient_phone varchar(20),
oasis_therapy_patient_state varchar(20),
oasis_therapy_patient_zip varchar(10),
oasis_therapy_medicare_no varchar(20),
oasis_therapy_medicare_no_na varchar(3),
oasis_therapy_ssn varchar(20),
oasis_therapy_ssn_na varchar(2),
oasis_therapy_medicaid_no varchar(20),
oasis_therapy_medicaid_no_na varchar(3),
oasis_therapy_birth_date DATE,
oasis_therapy_patient_gender  varchar(6),
oasis_therapy_payment_source_homecare varchar(32),
oasis_therapy_discipline_person varchar(1),
oasis_therapy_date_assessment_completed DATE,
oasis_therapy_follow_up varchar(1),
oasis_therapy_episode_timing varchar(2),
oasis_therapy_certification_period_from DATE,
oasis_therapy_certification_period_to DATE,
oasis_therapy_patient_diagnosis_1a varchar(10),
oasis_therapy_patient_diagnosis_2a varchar(10),
oasis_therapy_patient_diagnosis_2a_sub varchar(2),
oasis_therapy_patient_diagnosis_3a varchar(10),
oasis_therapy_patient_diagnosis_4a varchar(10),
oasis_therapy_patient_diagnosis_1b varchar(10),
oasis_therapy_patient_diagnosis_2b varchar(10),
oasis_therapy_patient_diagnosis_2b_sub varchar(2),
oasis_therapy_patient_diagnosis_3b varchar(10),
oasis_therapy_patient_diagnosis_4b varchar(10),
oasis_therapy_patient_diagnosis_1c varchar(10),
oasis_therapy_patient_diagnosis_2c varchar(10),
oasis_therapy_patient_diagnosis_2c_sub varchar(2),
oasis_therapy_patient_diagnosis_3c varchar(10),
oasis_therapy_patient_diagnosis_4c varchar(10),
oasis_therapy_patient_diagnosis_1d varchar(10),
oasis_therapy_patient_diagnosis_2d varchar(10),
oasis_therapy_patient_diagnosis_2d_sub varchar(2),
oasis_therapy_patient_diagnosis_3d varchar(10),
oasis_therapy_patient_diagnosis_4d varchar(10),
oasis_therapy_patient_diagnosis_1e varchar(10),
oasis_therapy_patient_diagnosis_2e varchar(10),
oasis_therapy_patient_diagnosis_2e_sub varchar(2),
oasis_therapy_patient_diagnosis_3e varchar(10),
oasis_therapy_patient_diagnosis_4e varchar(10),
oasis_therapy_patient_diagnosis_1f varchar(10),
oasis_therapy_patient_diagnosis_2f varchar(10),
oasis_therapy_patient_diagnosis_2f_sub varchar(2),
oasis_therapy_patient_diagnosis_3f varchar(10),
oasis_therapy_patient_diagnosis_4f varchar(10),
oasis_therapy_patient_diagnosis_1g varchar(10),
oasis_therapy_patient_diagnosis_2g varchar(10),
oasis_therapy_patient_diagnosis_2g_sub varchar(2),
oasis_therapy_patient_diagnosis_3g varchar(10),
oasis_therapy_patient_diagnosis_4g varchar(10),
oasis_therapy_patient_diagnosis_1h varchar(10),
oasis_therapy_patient_diagnosis_2h varchar(10),
oasis_therapy_patient_diagnosis_2h_sub varchar(2),
oasis_therapy_patient_diagnosis_3h varchar(10),
oasis_therapy_patient_diagnosis_4h varchar(10),
oasis_therapy_patient_diagnosis_1i varchar(10),
oasis_therapy_patient_diagnosis_2i varchar(10),
oasis_therapy_patient_diagnosis_2i_sub varchar(2),
oasis_therapy_patient_diagnosis_3i varchar(10),
oasis_therapy_patient_diagnosis_4i varchar(10),
oasis_therapy_patient_diagnosis_1j varchar(10),
oasis_therapy_patient_diagnosis_2j varchar(10),
oasis_therapy_patient_diagnosis_2j_sub varchar(2),
oasis_therapy_patient_diagnosis_3j varchar(10),
oasis_therapy_patient_diagnosis_4j varchar(10),
oasis_therapy_patient_diagnosis_1k varchar(10),
oasis_therapy_patient_diagnosis_2k varchar(10),
oasis_therapy_patient_diagnosis_2k_sub varchar(2),
oasis_therapy_patient_diagnosis_3k varchar(10),
oasis_therapy_patient_diagnosis_4k varchar(10),
oasis_therapy_patient_diagnosis_1l varchar(10),
oasis_therapy_patient_diagnosis_2l varchar(10),
oasis_therapy_patient_diagnosis_2l_sub varchar(2),
oasis_therapy_patient_diagnosis_3l varchar(10),
oasis_therapy_patient_diagnosis_4l varchar(10),
oasis_therapy_patient_diagnosis_1m varchar(10),
oasis_therapy_patient_diagnosis_2m varchar(10),
oasis_therapy_patient_diagnosis_2m_sub varchar(2),
oasis_therapy_patient_diagnosis_3m varchar(10),
oasis_therapy_patient_diagnosis_4m varchar(10),
oasis_therapy_surgical_procedure_a varchar(20),
oasis_therapy_surgical_procedure_a_date DATE,
oasis_therapy_surgical_procedure_b varchar(20),
oasis_therapy_surgical_procedure_b_date DATE,
oasis_therapy_therapies_home varchar(10),
oasis_therapy_vision varchar(1),
oasis_therapy_pragnosis varchar(1),
oasis_therapy_frequency_pain varchar(1),
oasis_therapy_pain_scale varchar(2),
oasis_therapy_pain_location varchar(20),
oasis_therapy_pain_location_cause varchar(20),
oasis_therapy_pain_description varchar(10),
oasis_therapy_pain_frequency varchar(15),
oasis_therapy_pain_aggravating_factors varchar(15),
oasis_therapy_pain_aggravating_factors_other varchar(20),
oasis_therapy_pain_relieving_factors varchar(15),
oasis_therapy_pain_relieving_factors_other varchar(20),
oasis_therapy_pain_activities_limited TEXT,
oasis_therapy_experiencing_pain varchar(3),
oasis_therapy_unable_to_communicate varchar(3),
oasis_therapy_non_verbal_demonstrated varchar(20),
oasis_therapy_non_verbal_demonstrated_other varchar(30),
oasis_therapy_non_verbal_demonstrated_implications varchar(30),
oasis_therapy_breakthrough_medication varchar(21),
oasis_therapy_breakthrough_medication_other varchar(30),
oasis_therapy_implications_care_plan varchar(3),
oasis_therapy_integumentary_status_problem varchar(2),
oasis_therapy_wound_care_done varchar(3),
oasis_therapy_wound_location varchar(20),
oasis_therapy_wound TEXT,
oasis_therapy_wound_soiled_dressing_by varchar(20),
oasis_therapy_wound_soiled_technique varchar(10),
oasis_therapy_wound_cleaned varchar(20),
oasis_therapy_wound_irrigated varchar(20),
oasis_therapy_wound_packed varchar(20),
oasis_therapy_wound_dressing_apply varchar(20),
oasis_therapy_wound_incision varchar(20),
oasis_therapy_wound_comment TEXT,
oasis_therapy_satisfactory_return_demo varchar(3),
oasis_therapy_wound_education varchar(3),
oasis_therapy_wound_education_comment TEXT,
oasis_therapy_wound_lesion_location TEXT,
oasis_therapy_wound_lesion_type TEXT,
oasis_therapy_wound_lesion_status TEXT,
oasis_therapy_wound_lesion_size_length varchar(20),
oasis_therapy_wound_lesion_size_width varchar(20),
oasis_therapy_wound_lesion_size_depth varchar(20),
oasis_therapy_wound_lesion_stage TEXT,
oasis_therapy_wound_lesion_tunneling TEXT,
oasis_therapy_wound_lesion_odor TEXT,
oasis_therapy_wound_lesion_skin TEXT,
oasis_therapy_wound_lesion_edema TEXT,
oasis_therapy_wound_lesion_stoma TEXT,
oasis_therapy_wound_lesion_appearance TEXT,
oasis_therapy_wound_lesion_drainage TEXT,
oasis_therapy_wound_lesion_color TEXT,
oasis_therapy_wound_lesion_consistency TEXT,
oasis_therapy_integumentary_status varchar(1),
oasis_therapy_braden_scale_sensory varchar(2),
oasis_therapy_braden_scale_moisture varchar(2),
oasis_therapy_braden_scale_activity varchar(2),
oasis_therapy_braden_scale_mobility varchar(2),
oasis_therapy_braden_scale_nutrition varchar(2),
oasis_therapy_braden_scale_friction varchar(2),
oasis_therapy_braden_scale_total varchar(2),
oasis_therapy_pressure_ulcer_a TEXT,
oasis_therapy_pressure_ulcer_b TEXT,
oasis_therapy_pressure_ulcer_c TEXT,
oasis_therapy_pressure_ulcer_d1 TEXT,
oasis_therapy_pressure_ulcer_d2 TEXT,
oasis_therapy_pressure_ulcer_d3 TEXT,
oasis_therapy_current_ulcer_stage1 varchar(1),
oasis_therapy_stage_of_problematic_ulcer varchar(2),
oasis_therapy_statis_ulcer varchar(1),
oasis_therapy_current_no_statis_ulcer varchar(1),
oasis_therapy_problematic_statis_ulcer varchar(1),
oasis_therapy_surgical_wound varchar(1),
oasis_therapy_problematic_surgical_wound varchar(1),
oasis_therapy_skin_lesion varchar(1),
oasis_therapy_vital_sign_blood_pressure varchar(100),
oasis_therapy_vital_sign_temperature varchar(10),
oasis_therapy_vital_sign_pulse varchar(10),
oasis_therapy_vital_sign_pulse_type varchar(40),
oasis_therapy_vital_sign_respiratory_rate varchar(10),
oasis_therapy_cardiopulmonary_problem varchar(2),
oasis_therapy_breath_sounds_type varchar(20),
oasis_therapy_breath_sounds TEXT,
oasis_therapy_breath_sounds_anterior varchar(5),
oasis_therapy_breath_sounds_posterior varchar(11),
oasis_therapy_breath_sounds_accessory_muscle_o2 varchar(2),
oasis_therapy_breath_sounds_cough varchar(7),
oasis_therapy_breath_sounds_productive varchar(5),
oasis_therapy_breath_sounds_o2_saturation varchar(30),
oasis_therapy_breath_sounds_accessory_muscle varchar(30),
oasis_therapy_breath_sounds_accessory_o2_detail varchar(30),
oasis_therapy_breath_sounds_accessory_lpm varchar(30),
oasis_therapy_breath_sounds_trach varchar(3),
oasis_therapy_breath_sounds_trach_manages varchar(10),
oasis_therapy_breath_sounds_productive_color varchar(20),
oasis_therapy_breath_sounds_productive_amount varchar(20),
oasis_therapy_breath_sounds_other varchar(30),
oasis_therapy_heart_sounds_type varchar(10),
oasis_therapy_heart_sounds TEXT,
oasis_therapy_heart_sounds_pacemaker varchar(30),
oasis_therapy_heart_sounds_pacemaker_date DATE,
oasis_therapy_heart_sounds_pacemaker_type varchar(30),
oasis_therapy_heart_sounds_other varchar(30),
oasis_therapy_heart_sounds_chest_pain varchar(10),
oasis_therapy_heart_sounds_associated_with varchar(10),
oasis_therapy_heart_sounds_frequency varchar(12),
oasis_therapy_heart_sounds_edema varchar(10),
oasis_therapy_heart_sounds_site varchar(12),
oasis_therapy_heart_sounds_edema_dependent varchar(12),
oasis_therapy_heart_sounds_capillary varchar(2),
oasis_therapy_heart_sounds_notify varchar(20),
oasis_therapy_respiratory_status varchar(1),
oasis_therapy_urinary_problem varchar(2),
oasis_therapy_urinary TEXT,
oasis_therapy_urinary_incontinence varchar(30),
oasis_therapy_urinary_management_strategy varchar(30),
oasis_therapy_urinary_diapers_other varchar(30),
oasis_therapy_urinary_color varchar(6),
oasis_therapy_urinary_color_other varchar(30),
oasis_therapy_urinary_clarity varchar(8),
oasis_therapy_urinary_odor varchar(3),
oasis_therapy_urinary_catheter varchar(30),
oasis_therapy_urinary_foley_date DATE,
oasis_therapy_urinary_foley_ml varchar(30),
oasis_therapy_urinary_irrigation_solution varchar(30),
oasis_therapy_urinary_irrigation_amount varchar(30),
oasis_therapy_urinary_irrigation_ml varchar(30),
oasis_therapy_urinary_irrigation_frequency varchar(30),
oasis_therapy_urinary_irrigation_returns varchar(30),
oasis_therapy_urinary_tolerated_procedure varchar(3),
oasis_therapy_urinary_other varchar(30),
oasis_therapy_bowels_problem varchar(2),
oasis_therapy_bowels TEXT,
oasis_therapy_bowel_regime varchar(30),
oasis_therapy_bowels_lexative_enema varchar(7),
oasis_therapy_bowels_lexative_enema_other varchar(30),
oasis_therapy_bowels_incontinence varchar(30),
oasis_therapy_bowels_diapers_others varchar(30),
oasis_therapy_bowels_ileostomy_site TEXT,
oasis_therapy_bowels_ostomy_care varchar(9),
oasis_therapy_bowels_other_site TEXT,
oasis_therapy_bowels_urostomy TEXT,
oasis_therapy_elimination_urinary_incontinence varchar(1),
oasis_therapy_elimination_bowel_incontinence varchar(2),
oasis_therapy_elimination_ostomy varchar(1),
oasis_therapy_adl_dress_upper varchar(1),
oasis_therapy_adl_dress_lower varchar(1),
oasis_therapy_adl_wash varchar(1),
oasis_therapy_adl_toilet_transfer varchar(1),
oasis_therapy_adl_transferring varchar(1),
oasis_therapy_adl_ambulation varchar(1),
oasis_therapy_activities_permitted TEXT,
oasis_therapy_activities_permitted_other varchar(30),
oasis_therapy_medication varchar(2),
oasis_therapy_therapy_need_number varchar(30),
oasis_therapy_therapy_need varchar(2),
oasis_therapy_fall_risk_reported varchar(3),
oasis_therapy_fall_risk_reported_details TEXT,
oasis_therapy_fall_risk_factors varchar(3),
oasis_therapy_fall_risk_factors_details TEXT,
oasis_therapy_fall_risk_assessment TEXT,
oasis_therapy_fall_risk_assessment_total varchar(2),
oasis_therapy_fall_risk_assessment_comments varchar(30),
oasis_therapy_timed_up_trial1 varchar(3),
oasis_therapy_timed_up_trial2 varchar(3),
oasis_therapy_timed_up_average varchar(10),
oasis_therapy_amplification_care_provided TEXT,
oasis_therapy_amplification_patient_response TEXT,
oasis_therapy_homebound_reason TEXT,
oasis_therapy_homebound_reason_other varchar(30),
oasis_therapy_summary_check_careplan varchar(10),
oasis_therapy_summary_check_medication varchar(10),
oasis_therapy_summary_check_identified TEXT,
oasis_therapy_summary_check_care_coordination varchar(10),
oasis_therapy_summary_check_carecordination_other varchar(30),
oasis_therapy_summary_check_referrel varchar(30),
oasis_therapy_summary_check_next_visit DATE,
oasis_therapy_summary_check_recertification varchar(3),
oasis_therapy_summary_check_verbal_order varchar(3),
oasis_therapy_dme varchar(2),
oasis_therapy_dme_wound_care TEXT,
oasis_therapy_dme_wound_care_glove varchar(11),
oasis_therapy_dme_wound_care_other varchar(30),
oasis_therapy_dme_diabetic varchar(30),
oasis_therapy_dme_diabetic_other varchar(30),
oasis_therapy_dme_iv_supplies TEXT,
oasis_therapy_dme_iv_supplies_other varchar(30),
oasis_therapy_dme_foley_supplies varchar(90),
oasis_therapy_dme_foley_supplies_other varchar(90),
oasis_therapy_dme_urinary varchar(130),
oasis_therapy_dme_urinary_ostomy_pouch varchar(30),
oasis_therapy_dme_urinary_ostomy_wafer varchar(30),
oasis_therapy_dme_urinary_other varchar(90),
oasis_therapy_dme_miscellaneous varchar(90),
oasis_therapy_dme_miscellaneous_type varchar(30),
oasis_therapy_dme_miscellaneous_size varchar(30),
oasis_therapy_dme_miscellaneous_other varchar(30),
oasis_therapy_dme_supplies TEXT,
oasis_therapy_dme_supplies_other varchar(30),
oasis_therapy_safety_measures TEXT,
oasis_therapy_safety_measures_other varchar(30),
oasis_therapy_nutritional_requirement TEXT,
oasis_therapy_nutritional_requirement_other varchar(30),
oasis_therapy_allergies varchar(100),
oasis_therapy_nutritional_allergies_other varchar(30),
oasis_therapy_functional_limitations varchar(150),
oasis_therapy_functional_limitations_other varchar(30),
oasis_therapy_mental_status varchar(80),
oasis_therapy_mental_status_other varchar(30),
oasis_therapy_discharge_plan TEXT,
oasis_therapy_discharge_plan_other varchar(30),
oasis_therapy_discharge_plan_detail TEXT,
oasis_therapy_discharge_plan_detail_other varchar(30),
oasis_therapy_curr_level_bed_mobility varchar(100),
oasis_therapy_curr_level_transfers varchar(200),
oasis_therapy_curr_level_wheelchair_mobility varchar(100),
oasis_therapy_curr_level_gait_status varchar(4),
oasis_therapy_curr_level_gait TEXT,
oasis_therapy_curr_level_assistive_device varchar(30),
oasis_therapy_curr_level_device_freq varchar(15),
oasis_therapy_musculoskeletal_analysis_str_l TEXT,
oasis_therapy_musculoskeletal_analysis_str_r TEXT,
oasis_therapy_musculoskeletal_analysis_rom_l TEXT,
oasis_therapy_musculoskeletal_analysis_rom_r TEXT,
oasis_therapy_musculoskeletal_analysis_pain_l TEXT,
oasis_therapy_musculoskeletal_analysis_pain_r TEXT,
oasis_therapy_curr_level_findings TEXT,
oasis_therapy_curr_level_gait_desc varchar(30),
oasis_therapy_curr_level_gait_desc_other varchar(30),
oasis_therapy_curr_level_risk_factor TEXT,
oasis_therapy_curr_level_risk_factor_other varchar(30),
oasis_therapy_curr_level_risk_factor_other_deviation TEXT,
oasis_therapy_curr_level_risk_factor_frequency varchar(20),
oasis_therapy_pt_orders TEXT,
oasis_therapy_pt_orders_gait varchar(100),
oasis_therapy_pt_orders_range_of_motion varchar(100),
oasis_therapy_pt_orders_range varchar(5),
oasis_therapy_pt_orders_range_desc varchar(100),
oasis_therapy_pt_orders_degree_of_motion TEXT,
oasis_therapy_pt_orders_maintenence_therapy varchar(100),
oasis_therapy_pt_orders_microwave_treatement varchar(100),
oasis_therapy_pt_orders_whirlpool_baths varchar(100),
oasis_therapy_pt_orders_wound_care varchar(30),
oasis_therapy_pt_goals_no_short varchar(5),
oasis_therapy_pt_goals_gait varchar(80),
oasis_therapy_pt_goals_no_long varchar(5),
oasis_therapy_pt_goals_no_pta1_visits varchar(5),
oasis_therapy_pt_goals_no_pta2_visits varchar(5),
oasis_therapy_pt_goals_no_pta3_visits varchar(5),
oasis_therapy_pt_goals_no_pta4_visits varchar(5),
oasis_therapy_pt_goals_bath_no_short varchar(5),
oasis_therapy_pt_goals_bath varchar(30),
oasis_therapy_pt_goals_bath_no_long varchar(5),
oasis_therapy_pt_goals_no_ptb1_visits varchar(5),
oasis_therapy_pt_goals_no_ptb1_desc varchar(30),
oasis_therapy_pt_goals_bed_no_short varchar(5),
oasis_therapy_pt_goals_bed varchar(40),
oasis_therapy_pt_goals_bed_no_long varchar(5),
oasis_therapy_pt_goals_no_ptc1_visits varchar(5),
oasis_therapy_pt_goals_no_ptc2_visits varchar(5),
oasis_therapy_pt_goals_no_ptc2_desc varchar(30),
oasis_therapy_pt_goals_car_no_short varchar(5),
oasis_therapy_pt_goals_car varchar(50),
oasis_therapy_pt_goals_car_no_long varchar(5),
oasis_therapy_pt_goals_no_ptd1_visits varchar(5),
oasis_therapy_pt_goals_no_ptd2_visits varchar(5),
oasis_therapy_pt_goals_no_ptd2_desc varchar(30),
oasis_therapy_pt_goals_therapeutic_no_short varchar(5),
oasis_therapy_pt_goals_therapeutic varchar(50),
oasis_therapy_pt_goals_therapeutic_no_long varchar(5),
oasis_therapy_pt_goals_no_pte1_visits varchar(5),
oasis_therapy_pt_goals_no_pte2_visits varchar(5),
oasis_therapy_pt_goals_transfers_no_short varchar(5),
oasis_therapy_pt_goals_transfers varchar(50),
oasis_therapy_pt_goals_transfers_no_long varchar(5),
oasis_therapy_pt_goals_no_ptf1_visits varchar(5),
oasis_therapy_pt_goals_no_ptf2_visits varchar(5),
oasis_therapy_pt_goals_no_ptf3_visits varchar(5),
oasis_therapy_pt_goals_no_ptf3_desc varchar(30),
oasis_therapy_pt_goals_safety_no_short varchar(5),
oasis_therapy_pt_goals_safety varchar(50),
oasis_therapy_pt_goals_safety_no_long varchar(5),
oasis_therapy_pt_goals_no_ptg1_visits varchar(5),
oasis_therapy_pt_goals_wheelchair_no_short varchar(5),
oasis_therapy_pt_goals_wheelchair varchar(50),
oasis_therapy_pt_goals_wheelchair_no_long varchar(5),
oasis_therapy_pt_goals_no_pth1_visits varchar(5),
oasis_therapy_pt_goals_no_pth2_visits varchar(5),
oasis_therapy_pt_goals_no_pth2_desc varchar(5),
oasis_therapy_pt_goals_other_no_short varchar(5),
oasis_therapy_pt_goals_other varchar(50),
oasis_therapy_pt_goals_other_no_long varchar(5),
oasis_therapy_pt_goals_no_other_desc varchar(50),
oasis_therapy_orders varchar(20)
) engine=MyISAM;
#EndIf

#IfNotRow registry directory oasis_therapy_rectification
INSERT INTO `registry` VALUES ('OASIS Recert-PT', 1, 'oasis_therapy_rectification', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');
#EndIf

#IfNotRow2D registry directory oasis_therapy_rectification category OASIS
UPDATE registry SET category='OASIS' WHERE directory='oasis_therapy_rectification';
#EndIf



#IfNotTable forms_oasis_nursing_soc
CREATE TABLE IF NOT EXISTS `forms_oasis_nursing_soc` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
detail varchar(100),
process varchar(100),
data varchar(100),
label varchar(100),
oasis_patient_patient_name varchar(30),
oasis_patient_caregiver varchar(30),
oasis_patient_visit_date DATE,
time_in varchar(10),
time_out varchar(10),
oasis_patient_cms_no varchar(20),
oasis_patient_branch_state varchar(20),
oasis_patient_branch_id_no varchar(20),
oasis_patient_npi varchar(20),
oasis_patient_npi_na varchar(4),
oasis_patient_referring_physician_id varchar(20),
oasis_patient_referring_physician_id_na varchar(4),
oasis_patient_primary_physician_last varchar(20),
oasis_patient_primary_physician_first varchar(20),
oasis_patient_primary_physician_phone varchar(20),
oasis_patient_primary_physician_address varchar(40),
oasis_patient_primary_physician_city varchar(20),
oasis_patient_primary_physician_state varchar(20),
oasis_patient_primary_physician_zip varchar(10),
oasis_patient_other_physician_last varchar(20),
oasis_patient_other_physician_first varchar(20),
oasis_patient_other_physician_phone varchar(20),
oasis_patient_other_physician_address varchar(40),
oasis_patient_other_physician_city varchar(20),
oasis_patient_other_physician_state varchar(20),
oasis_patient_other_physician_zip varchar(10),
oasis_patient_patient_id varchar(10),
oasis_patient_soc_date DATE,
oasis_patient_resumption_care_date varchar(20),
oasis_patient_resumption_care_date_na varchar(4),
oasis_patient_patient_name_first varchar(20),
oasis_patient_patient_name_mi varchar(20),
oasis_patient_patient_name_last varchar(20),
oasis_patient_patient_name_suffix varchar(20),
oasis_patient_patient_address_street varchar(20),
oasis_patient_patient_address_city varchar(20),
oasis_patient_patient_phone varchar(20),
oasis_patient_patient_state varchar(20),
oasis_patient_patient_zip varchar(10),
oasis_patient_medicare_no varchar(20),
oasis_patient_medicare_no_na varchar(4),
oasis_patient_ssn varchar(20),
oasis_patient_ssn_na varchar(4),
oasis_patient_medicaid_no varchar(20),
oasis_patient_medicaid_no_na varchar(4),
oasis_patient_birth_date DATE,
oasis_patient_patient_gender varchar(6),
oasis_patient_race_ethnicity varchar(12),
oasis_patient_payment_source_homecare varchar(32),
oasis_patient_payment_source_homecare_other varchar(30),
oasis_patient_certification_period_from DATE,
oasis_patient_certification_period_to DATE,
oasis_patient_discipline_person varchar(1),
oasis_patient_date_assessment_completed DATE,
oasis_patient_follow_up varchar(1),
oasis_patient_date_ordered_soc varchar(20),
oasis_patient_date_ordered_soc_na varchar(4),
oasis_patient_date_of_referral DATE,
oasis_patient_episode_timing varchar(2),
oasis_patient_history_impatient_facility varchar(20),
oasis_patient_history_impatient_facility_other varchar(20),
oasis_patient_history_discharge_date DATE,
oasis_patient_history_discharge_date_na varchar(2),
oasis_patient_history_if_diagnosis TEXT,
oasis_patient_history_if_code varchar(100),
oasis_patient_history_ip_diagnosis TEXT,
oasis_patient_history_ip_code varchar(100),
oasis_patient_history_ip_diagnosis_na varchar(2),
oasis_patient_history_ip_diagnosis_uk varchar(2),
oasis_patient_history_mrd_diagnosis TEXT,
oasis_patient_history_mrd_code varchar(100),
oasis_patient_history_mrd_diagnosis_na varchar(2),
oasis_patient_history_regimen_change varchar(22),
oasis_therapy_patient_diagnosis_1a varchar(10),
oasis_therapy_patient_diagnosis_2a varchar(10),
oasis_therapy_patient_diagnosis_2a_sub varchar(2),
oasis_therapy_patient_diagnosis_3a varchar(10),
oasis_therapy_patient_diagnosis_4a varchar(10),
oasis_therapy_patient_diagnosis_1b varchar(10),
oasis_therapy_patient_diagnosis_2b varchar(10),
oasis_therapy_patient_diagnosis_2b_sub varchar(2),
oasis_therapy_patient_diagnosis_3b varchar(10),
oasis_therapy_patient_diagnosis_4b varchar(10),
oasis_therapy_patient_diagnosis_1c varchar(10),
oasis_therapy_patient_diagnosis_2c varchar(10),
oasis_therapy_patient_diagnosis_2c_sub varchar(2),
oasis_therapy_patient_diagnosis_3c varchar(10),
oasis_therapy_patient_diagnosis_4c varchar(10),
oasis_therapy_patient_diagnosis_1d varchar(10),
oasis_therapy_patient_diagnosis_2d varchar(10),
oasis_therapy_patient_diagnosis_2d_sub varchar(2),
oasis_therapy_patient_diagnosis_3d varchar(10),
oasis_therapy_patient_diagnosis_4d varchar(10),
oasis_therapy_patient_diagnosis_1e varchar(10),
oasis_therapy_patient_diagnosis_2e varchar(10),
oasis_therapy_patient_diagnosis_2e_sub varchar(2),
oasis_therapy_patient_diagnosis_3e varchar(10),
oasis_therapy_patient_diagnosis_4e varchar(10),
oasis_therapy_patient_diagnosis_1f varchar(10),
oasis_therapy_patient_diagnosis_2f varchar(10),
oasis_therapy_patient_diagnosis_2f_sub varchar(2),
oasis_therapy_patient_diagnosis_3f varchar(10),
oasis_therapy_patient_diagnosis_4f varchar(10),
oasis_therapy_patient_diagnosis_1g varchar(10),
oasis_therapy_patient_diagnosis_2g varchar(10),
oasis_therapy_patient_diagnosis_2g_sub varchar(2),
oasis_therapy_patient_diagnosis_3g varchar(10),
oasis_therapy_patient_diagnosis_4g varchar(10),
oasis_therapy_patient_diagnosis_1h varchar(10),
oasis_therapy_patient_diagnosis_2h varchar(10),
oasis_therapy_patient_diagnosis_2h_sub varchar(2),
oasis_therapy_patient_diagnosis_3h varchar(10),
oasis_therapy_patient_diagnosis_4h varchar(10),
oasis_therapy_patient_diagnosis_1i varchar(10),
oasis_therapy_patient_diagnosis_2i varchar(10),
oasis_therapy_patient_diagnosis_2i_sub varchar(2),
oasis_therapy_patient_diagnosis_3i varchar(10),
oasis_therapy_patient_diagnosis_4i varchar(10),
oasis_therapy_patient_diagnosis_1j varchar(10),
oasis_therapy_patient_diagnosis_2j varchar(10),
oasis_therapy_patient_diagnosis_2j_sub varchar(2),
oasis_therapy_patient_diagnosis_3j varchar(10),
oasis_therapy_patient_diagnosis_4j varchar(10),
oasis_therapy_patient_diagnosis_1k varchar(10),
oasis_therapy_patient_diagnosis_2k varchar(10),
oasis_therapy_patient_diagnosis_2k_sub varchar(2),
oasis_therapy_patient_diagnosis_3k varchar(10),
oasis_therapy_patient_diagnosis_4k varchar(10),
oasis_therapy_patient_diagnosis_1l varchar(10),
oasis_therapy_patient_diagnosis_2l varchar(10),
oasis_therapy_patient_diagnosis_2l_sub varchar(2),
oasis_therapy_patient_diagnosis_3l varchar(10),
oasis_therapy_patient_diagnosis_4l varchar(10),
oasis_therapy_patient_diagnosis_1m varchar(10),
oasis_therapy_patient_diagnosis_2m varchar(10),
oasis_therapy_patient_diagnosis_2m_sub varchar(2),
oasis_therapy_patient_diagnosis_3m varchar(10),
oasis_therapy_patient_diagnosis_4m varchar(10),
oasis_therapy_surgical_procedure_a varchar(20),
oasis_therapy_surgical_procedure_a_date DATE,
oasis_therapy_surgical_procedure_b varchar(20),
oasis_therapy_surgical_procedure_b_date DATE,
oasis_patient_history_last_contact_date DATE,
oasis_patient_history_last_visit_date DATE,
oasis_patient_history_reason_home_health varchar(30),
oasis_patient_history_reason varchar(8),
oasis_patient_history_reason_other varchar(30),
oasis_patient_history_therapies varchar(8),
oasis_therapy_pragnosis varchar(1),
oasis_patient_history_advance_directives TEXT,
oasis_patient_history_family_informed varchar(3),
oasis_patient_history_family_informed_no varchar(30),
oasis_patient_history_risk_hospitalization varchar(14),
oasis_patient_history_previous_outcome TEXT,
oasis_patient_history_previous_outcome_cancer varchar(30),
oasis_patient_history_previous_outcome_other varchar(30),
oasis_patient_history_prior_hospitalization varchar(3),
oasis_patient_history_prior_hospitalization_no varchar(30),
oasis_patient_history_prior_hospitalization_reason varchar(100),
oasis_patient_history_immunizations varchar(10),
oasis_patient_history_immunizations_needs varchar(50),
oasis_patient_history_immunizations_needs_other varchar(30),
oasis_patient_history_allergies varchar(100),
oasis_patient_history_allergies_other varchar(30),
oasis_patient_history_overall_status varchar(2),
oasis_patient_history_risk_factors varchar(14),
oasis_therapy_safety_measures TEXT,
oasis_therapy_safety_measures_other varchar(30),
oasis_living_arrangements_situation varchar(2),
oasis_safety_emergency_planning1 varchar(1),
oasis_safety_emergency_planning2 varchar(1),
oasis_safety_emergency_planning3 varchar(1),
oasis_safety_emergency_planning4 varchar(1),
oasis_safety_emergency_planning5 varchar(1),
oasis_safety_emergency_planning6 varchar(1),
oasis_safety_emergency_planning7 varchar(1),
oasis_safety_emergency_planning8 varchar(1),
oasis_safety_oxygen_backup varchar(60),
oasis_safety_hazards TEXT,
oasis_safety_hazards_other varchar(30),
oasis_sanitation_hazards TEXT,
oasis_sanitation_hazards_other varchar(30),
oasis_primary_caregiver_name varchar(20),
oasis_primary_caregiver_relationship varchar(20),
oasis_primary_caregiver_phone varchar(20),
oasis_primary_caregiver_language varchar(50),
oasis_primary_caregiver_language_other varchar(30),
oasis_primary_caregiver_comments varchar(30),
oasis_primary_caregiver_able_care varchar(3),
oasis_primary_caregiver_no_reason varchar(30),
oasis_functional_limitations TEXT,
oasis_functional_limitations_other varchar(30),
oasis_sensory_status_vision_no varchar(2),
oasis_sensory_status_vision varchar(1),
oasis_sensory_status_vision_detail TEXT,
oasis_sensory_status_vision_detail_contact varchar(3),
oasis_sensory_status_vision_detail_prothesis varchar(3),
oasis_sensory_status_vision_site varchar(30),
oasis_sensory_status_vision_date DATE,
oasis_sensory_status_vision_detail_other varchar(30),
oasis_sensory_status_ears_no varchar(2),
oasis_sensory_status_hear varchar(2),
oasis_sensory_status_understand_verbal varchar(2),
oasis_sensory_status_hear_detail varchar(50),
oasis_sensory_status_hear_detail_hoh varchar(3),
oasis_sensory_status_hear_detail_vartigo varchar(3),
oasis_sensory_status_hear_detail_deaf varchar(3),
oasis_sensory_status_hear_detail_tinnitus varchar(3),
oasis_sensory_status_hear_detail_aid varchar(3),
oasis_sensory_status_hear_detail_other varchar(30),
oasis_sensory_status_musculoskeletal TEXT,
oasis_sensory_status_musculoskeletal_fracture varchar(30),
oasis_sensory_status_musculoskeletal_swollen varchar(30),
oasis_sensory_status_musculoskeletal_contractures varchar(30),
oasis_sensory_status_musculoskeletal_joint varchar(30),
oasis_sensory_status_musculoskeletal_location varchar(30),
oasis_sensory_status_musculoskeletal_amputation varchar(30),
oasis_sensory_status_musculoskeletal_other varchar(30),
oasis_sensory_status_nose_no varchar(2),
oasis_sensory_status_nose varchar(50),
oasis_sensory_status_nose_other varchar(30),
oasis_sensory_status_mouth_no varchar(2),
oasis_sensory_status_mouth varchar(100),
oasis_sensory_status_mouth_other varchar(30),
oasis_sensory_status_throat_no varchar(2),
oasis_sensory_status_throat varchar(60),
oasis_sensory_status_throat_other varchar(30),
oasis_sensory_status_speech varchar(1),
oasis_vital_sign_blood_pressure TEXT,
oasis_vital_sign_temperature varchar(10),
oasis_vital_sign_pulse varchar(10),
oasis_vital_sign_pulse_type varchar(50),
oasis_vital_sign_respiratory_rate varchar(10),
oasis_hw_height varchar(10),
oasis_hw_height_detail varchar(10),
oasis_hw_weight varchar(10),
oasis_hw_weight_detail varchar(10),
oasis_hw_weight_change varchar(3),
oasis_hw_weight_yes varchar(4),
oasis_hw_weight_lb varchar(10),
oasis_hw_weight_lb_in varchar(2),
oasis_pain_assessment_tool varchar(1),
oasis_pain_frequency_interfering varchar(1),
oasis_therapy_pain_scale varchar(2),
oasis_therapy_pain_location varchar(20),
oasis_therapy_pain_location_cause varchar(20),
oasis_therapy_pain_description varchar(10),
oasis_therapy_pain_frequency varchar(15),
oasis_therapy_pain_aggravating_factors varchar(15),
oasis_therapy_pain_aggravating_factors_other varchar(20),
oasis_therapy_pain_relieving_factors varchar(100),
oasis_therapy_pain_relieving_factors_other varchar(20),
oasis_therapy_pain_activities_limited TEXT,
oasis_therapy_experiencing_pain varchar(3),
oasis_therapy_unable_to_communicate varchar(3),
oasis_therapy_non_verbal_demonstrated TEXT,
oasis_therapy_non_verbal_demonstrated_other varchar(30),
oasis_therapy_non_verbal_demonstrated_implications varchar(30),
oasis_therapy_breakthrough_medication varchar(21),
oasis_therapy_breakthrough_medication_other varchar(30),
oasis_therapy_implications_care_plan varchar(3),
oasis_therapy_fall_risk_assessment TEXT,
oasis_therapy_fall_risk_assessment_total varchar(2),
oasis_pressure_ulcer_assessment varchar(1),
oasis_pressure_ulcer_risk varchar(1),
oasis_pressure_ulcer_unhealed_s2 varchar(1),
oasis_therapy_timed_up_trial1 varchar(3),
oasis_therapy_timed_up_trial2 varchar(3),
oasis_therapy_timed_up_average varchar(10),
oasis_integumentary_status_turgur TEXT,
oasis_integumentary_status_turgur_edema varchar(30),
oasis_integumentary_status_turgur_other varchar(30),
oasis_therapy_braden_scale_sensory varchar(2),
oasis_therapy_braden_scale_moisture varchar(2),
oasis_therapy_braden_scale_activity varchar(2),
oasis_therapy_braden_scale_mobility varchar(2),
oasis_therapy_braden_scale_nutrition varchar(2),
oasis_therapy_braden_scale_friction varchar(2),
oasis_therapy_braden_scale_total varchar(2),
oasis_therapy_pressure_ulcer_a TEXT,
oasis_therapy_pressure_ulcer_b TEXT,
oasis_therapy_pressure_ulcer_c TEXT,
oasis_therapy_pressure_ulcer_d1 TEXT,
oasis_therapy_pressure_ulcer_d2 TEXT,
oasis_therapy_pressure_ulcer_d3 TEXT,
oasis_therapy_pressure_ulcer_length varchar(10),
oasis_therapy_pressure_ulcer_width varchar(10),
oasis_therapy_pressure_ulcer_depth varchar(10),
oasis_therapy_pressure_ulcer_problematic_status varchar(2),
oasis_therapy_pressure_ulcer_current_no varchar(1),
oasis_therapy_pressure_ulcer_stage_unhealed varchar(2),
oasis_therapy_pressure_ulcer_statis_ulcer varchar(1),
oasis_therapy_pressure_ulcer_statis_ulcer_num varchar(1),
oasis_therapy_pressure_ulcer_statis_ulcer_status varchar(1),
oasis_therapy_surgical_wound varchar(1),
oasis_therapy_status_surgical_wound varchar(1),
oasis_therapy_skin_lesion varchar(1),
oasis_therapy_integumentary_status_problem varchar(2),
oasis_therapy_wound_care_done varchar(3),
oasis_therapy_wound_location varchar(20),
oasis_therapy_wound TEXT,
oasis_therapy_wound_soiled_dressing_by varchar(20),
oasis_therapy_wound_soiled_technique varchar(10),
oasis_therapy_wound_cleaned varchar(20),
oasis_therapy_wound_irrigated varchar(20),
oasis_therapy_wound_packed varchar(20),
oasis_therapy_wound_dressing_apply varchar(20),
oasis_therapy_wound_incision varchar(20),
oasis_therapy_wound_comment TEXT,
oasis_therapy_satisfactory_return_demo varchar(3),
oasis_therapy_wound_education varchar(3),
oasis_therapy_wound_education_comment TEXT,
oasis_therapy_wound_lesion_location TEXT,
oasis_therapy_wound_lesion_type TEXT,
oasis_therapy_wound_lesion_status TEXT,
oasis_therapy_wound_lesion_size_length varchar(20),
oasis_therapy_wound_lesion_size_width varchar(20),
oasis_therapy_wound_lesion_size_depth varchar(20),
oasis_therapy_wound_lesion_stage TEXT,
oasis_therapy_wound_lesion_tunneling TEXT,
oasis_therapy_wound_lesion_odor TEXT,
oasis_therapy_wound_lesion_skin TEXT,
oasis_therapy_wound_lesion_edema TEXT,
oasis_therapy_wound_lesion_stoma TEXT,
oasis_therapy_wound_lesion_appearance TEXT,
oasis_therapy_wound_lesion_drainage TEXT,
oasis_therapy_wound_lesion_color TEXT,
oasis_therapy_wound_lesion_consistency TEXT,
oasis_therapy_cardiopulmonary_problem varchar(2),
oasis_therapy_breath_sounds_type varchar(20),
oasis_therapy_breath_sounds TEXT,
oasis_therapy_breath_sounds_anterior varchar(5),
oasis_therapy_breath_sounds_posterior varchar(11),
oasis_therapy_breath_sounds_accessory_muscle_o2 varchar(2),
oasis_therapy_breath_sounds_cough varchar(7),
oasis_therapy_breath_sounds_productive varchar(5),
oasis_therapy_breath_sounds_o2_saturation varchar(30),
oasis_therapy_breath_sounds_accessory_muscle varchar(30),
oasis_therapy_breath_sounds_accessory_o2_detail varchar(30),
oasis_therapy_breath_sounds_accessory_lpm varchar(30),
oasis_therapy_breath_sounds_trach varchar(3),
oasis_therapy_breath_sounds_trach_manages varchar(10),
oasis_therapy_breath_sounds_productive_color varchar(20),
oasis_therapy_breath_sounds_productive_amount varchar(20),
oasis_therapy_breath_sounds_other varchar(30),
oasis_therapy_heart_sounds_type varchar(10),
oasis_therapy_heart_sounds TEXT,
oasis_therapy_heart_sounds_pacemaker varchar(30),
oasis_therapy_heart_sounds_pacemaker_date DATE,
oasis_therapy_heart_sounds_pacemaker_type varchar(30),
oasis_therapy_heart_sounds_other varchar(30),
oasis_therapy_heart_sounds_chest_pain varchar(10),
oasis_therapy_heart_sounds_associated_with varchar(10),
oasis_therapy_heart_sounds_frequency varchar(12),
oasis_therapy_heart_sounds_edema varchar(10),
oasis_therapy_heart_sounds_site varchar(12),
oasis_therapy_heart_sounds_edema_dependent varchar(12),
oasis_therapy_heart_sounds_capillary varchar(2),
oasis_therapy_heart_sounds_notify varchar(20),
oasis_therapy_respiratory_status varchar(1),
oasis_therapy_respiratory_treatment varchar(10),
oasis_elimination_status_tract_infection varchar(2),
oasis_elimination_status_urinary_incontinence varchar(1),
oasis_elimination_status_urinary_incontinence_occur varchar(1),
oasis_elimination_status_bowel_incontinence varchar(2),
oasis_elimination_status_ostomy_bowel varchar(1),
oasis_urinary_problem varchar(5) default NULL,
oasis_urinary text,
oasis_urinary_incontinence varchar(30) DEFAULT NULL,
oasis_urinary_management_strategy varchar(30) DEFAULT NULL,
oasis_urinary_diapers_other varchar(30) DEFAULT NULL,
oasis_urinary_color varchar(7) DEFAULT NULL,
oasis_urinary_color_other varchar(100) default NULL,
oasis_urinary_clarity varchar(10) default NULL,
oasis_urinary_odor varchar(5) default NULL,
oasis_urinary_catheter varchar(30) default NULL,
oasis_urinary_foley_date DATE default NULL,
oasis_urinary_foley_ml varchar(30) default NULL,
oasis_urinary_irrigation_solution varchar(30) default NULL,
oasis_urinary_irrigation_amount varchar(30) default NULL,
oasis_urinary_irrigation_ml varchar(30) default NULL,
oasis_urinary_irrigation_frequency varchar(30) default NULL,
oasis_urinary_irrigation_returns varchar(30) default NULL,
oasis_urinary_tolerated_procedure varchar(5) default NULL,
oasis_urinary_other varchar(30) default NULL,
oasis_bowels_problem varchar(5) default NULL,
oasis_bowels text,
oasis_bowel_regime varchar(30) default NULL,
oasis_bowels_lexative_enema varchar(10) default NULL,
oasis_bowels_lexative_enema_other varchar(30) default NULL,
oasis_bowels_incontinence mediumtext,
oasis_bowels_diapers_others varchar(30) default NULL,
oasis_bowels_ileostomy_site mediumtext,
oasis_bowels_ostomy_care varchar(15) default NULL,
oasis_bowels_other_site mediumtext,
oasis_bowels_urostomy mediumtext,
oasis_genitalia_problem varchar(5) default NULL,
oasis_genitalia text,
oasis_genitalia_discharge varchar(30) default NULL,
oasis_genitalia_imflammation varchar(30) default NULL,
oasis_genitalia_surgical_alteration varchar(30) default NULL,
oasis_genitalia_prostate_problem varchar(30) default NULL,
oasis_genitalia_date DATE default NULL,
oasis_genitalia_self_testicular_exam varchar(30) default NULL,
oasis_genitalia_frequency varchar(30) default NULL,
oasis_genitalia_date_last_PAP DATE default NULL,
oasis_genitalia_results varchar(30) default NULL,
oasis_genitalia_mastectomy varchar(30) default NULL,
oasis_genitalia_rl_date DATE default NULL,
oasis_genitalia_other varchar(30) default NULL,
oasis_abdomen_problem varchar(5) default NULL,
oasis_abdomen text,
oasis_abdomen_girth_inches varchar(30) default NULL,
oasis_abdomen_other varchar(30) default NULL,
oasis_ng_enteral_tube varchar(30) default NULL,
oasis_ng_enteral text,
oasis_ng_enteral_other varchar(30) default NULL,
oasis_endocrine_problem varchar(5) default NULL,
oasis_endocrine text,
oasis_endocrine_diabetes varchar(20) default NULL,
oasis_endocrine_diet varchar(30) default NULL,
oasis_endocrine_insulin varchar(30) default NULL,
oasis_endocrine_insulin_since DATE default NULL,
oasis_endocrine_admin_by varchar(10) default NULL,
oasis_endocrine_admin_by_other varchar(30) default NULL,
oasis_endocrine_monitored_by varchar(10) default NULL,
oasis_endocrine_monitored_by_other varchar(30) default NULL,
oasis_endocrine_blood_sugar_over varchar(30) default NULL,
oasis_endocrine_blood_sugar_under varchar(30) default NULL,
oasis_endocrine_renal varchar(30) default NULL,
oasis_endocrine_ophthalmic varchar(30) default NULL,
oasis_endocrine_neurologic varchar(30) default NULL,
oasis_endocrine_other varchar(30) default NULL,
oasis_endocrine_disease_management_problems varchar(30) default NULL,
oasis_endocrine_other1 varchar(30) default NULL,
oasis_endocrine_anemia varchar(30) default NULL,
oasis_endocrine_other2 varchar(30) default NULL,
oasis_nutrition_status_prob varchar(15) default NULL,
oasis_nutrition_status varchar(30) default NULL,
oasis_nutrition_status_other varchar(30) default NULL,
oasis_nutrition_requirements varchar(30) default NULL,
oasis_nutrition_appetite varchar(10) default NULL,
oasis_nutrition_eat_patt mediumtext,
oasis_nutrition_eat_patt1 text,
oasis_nutrition_eat_patt_freq varchar(30) default NULL,
oasis_nutrition_eat_patt_amt varchar(30) default NULL,
oasis_nutrition_eat_gain_or_loss varchar(4),
oasis_nutrition_patt_gain varchar(30) default NULL,
oasis_nutrition_eat_patt1_gain_time varchar(5) default NULL,
oasis_nutrition_patt1_other varchar(30) default NULL,
oasis_nutrition_req varchar(50) default NULL,
oasis_nutrition_req_other varchar(30) default NULL,
oasis_nutrition_risks text,
oasis_nutrition_risks_MD varchar(30) default NULL,
nutrition_total varchar(3) default NULL,
oasis_nutrition_describe varchar(30) default NULL,
oasis_neuro_cognitive_functioning varchar(2) default NULL,
oasis_neuro_when_confused varchar(2) default NULL,
oasis_neuro_when_anxious varchar(2) default NULL,
oasis_neuro_depression_screening varchar(2) default NULL,
oasis_neuro_little_interest varchar(2) default NULL,
oasis_neuro_feeling_down varchar(2) default NULL,
oasis_neuro_cognitive_symptoms text,
oasis_neuro_frequency_disruptive varchar(2) default NULL,
oasis_neuro_psychiatric_nursing varchar(2) default NULL,
oasis_neuro text,
oasis_neuro_location varchar(30) default NULL,
oasis_neuro_frequency varchar(30) default NULL,
oasis_neuro_unequaled_pupils varchar(15) default NULL,
oasis_neuro_aphasia varchar(15) default NULL,
oasis_neuro_motor_change varchar(20) default NULL,
oasis_neuro_dominant_side varchar(15) default NULL,
oasis_neuro_weakness varchar(20) default NULL,
oasis_neuro_weakness_location varchar(30) default NULL,
oasis_neuro_tremors varchar(10) default NULL,
oasis_neuro_handgrip_equal varchar(30) default NULL,
oasis_neuro_handgrip_unequal varchar(30) default NULL,
oasis_neuro_handgrip_strong varchar(30) default NULL,
oasis_neuro_handgrip_weak varchar(30) default NULL,
oasis_neuro_psychotropic_drug varchar(30) default NULL,
oasis_neuro_tremors_site varchar(30) default NULL,
oasis_neuro_dose_frequency varchar(30) default NULL,
oasis_neuro_other varchar(30) default NULL,
oasis_mental_status text,
oasis_mental_status_other varchar(30) default NULL,
oasis_psychosocial_edu_level varchar(30) default NULL,
oasis_psychosocial_primary_lang varchar(30) default NULL,
oasis_psychosocial text,
oasis_psychosocial_explain varchar(30) default NULL,
oasis_psychosocial_spiritual_resource varchar(30) default NULL,
oasis_psychosocial_phone_no varchar(50) default NULL,
oasis_psychosocial_treatment varchar(50) default NULL,
oasis_psychosocial_sleep_explain varchar(30) default NULL,
oasis_psychosocial_describe text,
oasis_psychosocial_comments text,
oasis_infusion text,
oasis_infusion_peripheral varchar(30) default NULL,
oasis_infusion_PICC varchar(30) default NULL,
oasis_infusion_central varchar(15) default NULL,
oasis_infusion_central_date DATE default NULL,
oasis_infusion_xray varchar(5) default NULL,
oasis_infusion_circum varchar(15) default NULL,
oasis_infusion_length varchar(15) default NULL,
oasis_infusion_hickman varchar(20) default NULL,
oasis_infusion_hickman_date DATE default NULL,
oasis_infusion_epidural_date DATE default NULL,
oasis_infusion_implanted_date DATE default NULL,
oasis_infusion_intrathecal_date DATE default NULL,
oasis_infusion_med1_admin varchar(30) default NULL,
oasis_infusion_med1_name varchar(30) default NULL,
oasis_infusion_med1_dose varchar(10) default NULL,
oasis_infusion_med1_dilution varchar(10) default NULL,
oasis_infusion_med1_route varchar(10) default NULL,
oasis_infusion_med1_frequency varchar(10) default NULL,
oasis_infusion_med1_duration varchar(10) default NULL,
oasis_infusion_med2_admin varchar(30) default NULL,
oasis_infusion_med2_name varchar(30) default NULL,
oasis_infusion_med2_dose varchar(10) default NULL,
oasis_infusion_med2_dilution varchar(10) default NULL,
oasis_infusion_med2_route varchar(10) default NULL,
oasis_infusion_med2_frequency varchar(10) default NULL,
oasis_infusion_med2_duration varchar(10) default NULL,
oasis_infusion_med3_admin varchar(30) default NULL,
oasis_infusion_med3_name varchar(30) default NULL,
oasis_infusion_med3_dose varchar(10) default NULL,
oasis_infusion_med3_dilution varchar(10) default NULL,
oasis_infusion_med3_route varchar(10) default NULL,
oasis_infusion_med3_frequency varchar(10) default NULL,
oasis_infusion_med3_duration varchar(10) default NULL,
oasis_infusion_pump varchar(50) default NULL,
oasis_infusion_admin_by varchar(30) default NULL,
oasis_infusion_admin_by_other varchar(30) default NULL,
oasis_infusion_dressing varchar(30) default NULL,
oasis_infusion_performed_by varchar(30) default NULL,
oasis_infusion_performed_by_other varchar(30) default NULL,
oasis_infusion_frequency varchar(10) default NULL,
oasis_infusion_injection varchar(10) default NULL,
oasis_infusion_labs_drawn varchar(10) default NULL,
oasis_adl_grooming varchar(1) default NULL,
oasis_adl_dress_upper varchar(1) default NULL,
oasis_adl_dress_lower varchar(1) default NULL,
oasis_adl_wash varchar(1) default NULL,
oasis_adl_toilet_transfer varchar(1) default NULL,
oasis_adl_toileting_hygiene varchar(1) default NULL,
oasis_adl_transferring varchar(1) default NULL,
oasis_adl_ambulation varchar(1) default NULL,
oasis_adl_feeding_eating varchar(1) default NULL,
oasis_adl_current_ability varchar(1) default NULL,
oasis_adl_use_telephone varchar(2) default NULL,
oasis_adl_func_self_care varchar(1) default NULL,
oasis_adl_func_ambulation varchar(1) default NULL,
oasis_adl_func_transfer varchar(1) default NULL,
oasis_adl_func_household varchar(1) default NULL,
oasis_activities_permitted text,
oasis_activities_permitted_other varchar(30) default NULL,
oasis_adl_fall_risk_assessment varchar(1) default NULL,
oasis_adl_drug_regimen varchar(2) default NULL,
oasis_adl_medication_follow_up varchar(1) default NULL,
oasis_adl_patient_caregiver varchar(2) default NULL,
oasis_adl_management_oral_medications varchar(2) default NULL,
oasis_adl_pay_for_medications varchar(5) default NULL,
oasis_adl_management_injectable_medications varchar(2) default NULL,
oasis_adl_func_oral_med varchar(2) default NULL,
oasis_adl_inject_med varchar(2) default NULL,
oasis_care_adl_assistance varchar(2) default NULL,
oasis_care_iadl_assistance varchar(2) default NULL,
oasis_care_medication_admin varchar(2) default NULL,
oasis_care_medical_procedures varchar(2) default NULL,
oasis_care_management_equip varchar(2) default NULL,
oasis_care_supervision_safety varchar(2) default NULL,
oasis_care_advocacy_facilitation varchar(2) default NULL,
oasis_care_how_often varchar(2) default NULL,
oasis_care_therapy_visits varchar(10) default NULL,
oasis_care_therapy_need_applicable varchar(2) default NULL,
oasis_care_patient_parameter varchar(2) default NULL,
oasis_care_diabetic_foot_care varchar(2) default NULL,
oasis_care_falls_prevention varchar(2) default NULL,
oasis_care_depression_intervention varchar(2) default NULL,
oasis_care_intervention_monitor varchar(2) default NULL,
oasis_care_intervention_prevent varchar(2) default NULL,
oasis_care_pressure_ulcer varchar(2) default NULL,
oasis_homebound_status text,
oasis_homebound_status_ambulation varchar(30) default NULL,
oasis_homebound_status_assist varchar(30) default NULL,
oasis_homebound_status_due_to varchar(30) default NULL,
oasis_homebound_status_other varchar(30) default NULL,
oasis_instructions_materials text,
oasis_instructions_materials_other varchar(30) default NULL,
oasis_instructions_skilled_care text,
oasis_instructions_care_coordinated text,
oasis_instructions_care_coordinated_other varchar(30) default NULL,
oasis_instructions_topic varchar(30) default NULL,
oasis_instructions_living_will varchar(5) default NULL,
oasis_instructions_copies_located varchar(50) default NULL,
oasis_instructions_bill_of_rights varchar(5) default NULL,
oasis_instructions_patient varchar(30) default NULL,
oasis_instructions_not_understand varchar(30) default NULL,
oasis_dme varchar(2) default NULL,
oasis_dme_wound_care text,
oasis_dme_wound_care_glove varchar(15) default NULL,
oasis_dme_wound_care_other varchar(30) default NULL,
oasis_dme_diabetic text,
oasis_dme_diabetic_other varchar(30) default NULL,
oasis_dme_iv_supplies text,
oasis_dme_iv_supplies_other varchar(30) default NULL,
oasis_dme_foley_supplies text,
oasis_dme_foley_supplies_other varchar(30) default NULL,
oasis_dme_urinary text,
oasis_dme_ostomy_pouch_brand varchar(30) default NULL,
oasis_dme_ostomy_pouch_size varchar(30) default NULL,
oasis_dme_ostomy_wafer_brand varchar(30) default NULL,
oasis_dme_ostomy_wafer_size varchar(30) default NULL,
oasis_dme_urinary_other varchar(30) default NULL,
oasis_dme_miscellaneous text,
oasis_dme_miscellaneous_type varchar(30) default NULL,
oasis_dme_miscellaneous_size varchar(30) default NULL,
oasis_dme_miscellaneous_other varchar(30) default NULL,
oasis_dme_supplies text,
oasis_dme_supplies_other varchar(30) default NULL,
oasis_discharge_plan text,
oasis_discharge_plan_other varchar(30) default NULL,
oasis_discharge_plan_detail text,
oasis_discharge_plan_detail_other varchar(30) default NULL,
oasis_appliances_brace varchar(30) default NULL,
oasis_appliances_equipments text,
oasis_appliances_equipments_needs text,
oasis_appliances_equipments_HME_co varchar(30) default NULL,
oasis_appliances_equipments_HME_rep varchar(30) default NULL,
oasis_appliances_equipments_phone varchar(30) default NULL,
oasis_appliances_equipments_other_organizations text,
 oasis_professional_vital_signs varchar(50) default NULL,
 oasis_professional_sn  varchar(30) default NULL,
 oasis_professional_vital_parameter text,
 oasis_professional_heart_rate0 varchar(10) default NULL,
 oasis_professional_heart_rate varchar(10) default NULL,
 oasis_professional_temperature0 varchar(10) default NULL,
 oasis_professional_temperature varchar(10) default NULL,
 oasis_professional_BP_systolic0 varchar(10) default NULL,
 oasis_professional_BP_systolic varchar(10) default NULL,
 oasis_professional_BP_diastolic0 varchar(10) default NULL,
 oasis_professional_BP_diastolic varchar(10) default NULL,
 oasis_professional_respirations0 varchar(10) default NULL,
 oasis_professional_respirations varchar(10) default NULL,
 oasis_professional_880 varchar(10) default NULL,
 oasis_professional_88 varchar(10) default NULL,
 oasis_professional_vital_other varchar(30) default NULL,
 oasis_professional_blood_glucose varchar(50) default NULL,
 oasis_professional_blood_glucose_BS_gt varchar(30) default NULL,
 oasis_professional_blood_glucose_BS_lt varchar(30) default NULL,
 oasis_professional_receive_orders_from varchar(30) default NULL,
 oasis_professional_sn_parameters text,
 oasis_professional_sn1 varchar(15) default NULL,
 oasis_professional_sn2 varchar(30) default NULL,
 oasis_professional_sn_every_visit varchar(30) default NULL,
 oasis_professional_sn_PRN_dyspnea text,
 oasis_professional_sn_other varchar(30) default NULL,
 oasis_professional_sn_frequency text,
 oasis_professional_PRN_visits_for varchar(30) default NULL,
 oasis_professional_sn_frequency_other varchar(30) default NULL,
 oasis_professional_goals text,
 oasis_professional_sn_provide text,
 oasis_professional_teaching_activities text,
 oasis_professional_goal_other varchar(30) default NULL,
 oasis_professional_decreased_to varchar(30) default NULL,
 oasis_professional_goal_other1 varchar(30) default NULL,
 oasis_professional_skilled_nurse1 text,
 oasis_professional_nurse_PICC varchar(50) default NULL,
 oasis_PICC_socl_before varchar(30) default NULL,
 oasis_PICC_socl_percent_before varchar(30) default NULL,
 oasis_PICC_socl_percent_after varchar(30) default NULL,
 oasis_PICC_socl_after varchar(30) default NULL,
 oasis_professional_heparin varchar(30) default NULL,
 oasis_PICC_dressing_change varchar(30) default NULL,
 oasis_PICC_injection_cap varchar(30) default NULL,
 oasis_PICC_extension_set varchar(30) default NULL,
 oasis_professional_nurse_peripheral varchar(50) default NULL,
 oasis_peripheral_socl_before varchar(30) default NULL,
 oasis_peripheral_socl_percent_before varchar(30) default NULL,
 oasis_peripheral_socl_after varchar(30) default NULL,
 oasis_peripheral_socl_percent_after varchar(30) default NULL,
 oasis_peripheral_heparin varchar(30) default NULL,
 oasis_professional_nurse_port varchar(50) default NULL,
 oasis_professional_nurse_use varchar(50) default NULL,
 oasis_PORT_socl_before varchar(30) default NULL,
 oasis_PORT_socl_percent_before varchar(30) default NULL,
 oasis_PORT_socl_percent_after varchar(30) default NULL,
 oasis_PORT_socl_after varchar(30) default NULL,
 oasis_PORT_heparin varchar(30) default NULL,
 oasis_PORT_dressing_change varchar(30) default NULL,
 oasis_PORT_injection_cap varchar(30) default NULL,
 oasis_PORT_extension_set varchar(30) default NULL,
 oasis_access_socl_after varchar(30) default NULL,
 oasis_access_socl_percent_after varchar(30) default NULL,
 oasis_access_heparin varchar(30) default NULL,
 oasis_professional_skilled_nurse2 text,
 oasis_professional_sn_nurse text,
 oasis_professional_sn_nurse_tube varchar(20) default NULL,
 oasis_professional_sn_nurse_tube_other varchar(30) default NULL,
 oasis_professional_sn_nurse_pump varchar(30) default NULL,
 oasis_professional_sn_nurse_feedings varchar(30) default NULL,
 oasis_professional_sn_nurse_continuous_rate varchar(30) default NULL,
 oasis_professional_flush_protocol varchar(30) default NULL,
 oasis_professional_formula varchar(30) default NULL,
 oasis_sn_nurse_performed_by varchar(30) default NULL,
 oasis_sn_nurse_performed_by_other varchar(30) default NULL,
 oasis_sn_nurse_dressing varchar(30) default NULL,
 oasis_sn_nurse_dressing_other varchar(30) default NULL,
 oasis_sn_nurse_wound_vac varchar(30) default NULL,
 oasis_sn_nurse_dressing_other1 varchar(30) default NULL,
 oasis_professional_sn_nurse1 text,
 oasis_professional_sn_nurse1_other varchar(30) default NULL,
 oasis_professional_sn_nurse2 text,
 oasis_professional_sn_nurse2_fr varchar(30) default NULL,
 oasis_professional_sn_nurse2_ml varchar(30) default NULL,
 oasis_catheter_std_protocol varchar(50) default NULL,
 oasis_catheter_MD varchar(50) default NULL,
 oasis_catheter_weeks varchar(10) default NULL,
 oasis_catheter_normal_saline_from varchar(10) default NULL,
 oasis_catheter_normal_saline_to varchar(10) default NULL,
 oasis_catheter_insertion_weeks varchar(10) default NULL,
 oasis_catheter_insertion_fr varchar(10) default NULL,
 oasis_catheter_insertion_ml varchar(10) default NULL,
 oasis_catheter_care_other varchar(30) default NULL,
 oasis_professional_sn_nurse2_venipuncture varchar(30) default NULL,
 oasis_professional_sn_nurse2_frequency varchar(30) default NULL,
 oasis_professional_sn_nurse2_other1 varchar(30) default NULL,
 oasis_professional_sn_nurse2_other2 varchar(30) default NULL,
 oasis_signature_last_name varchar(30) default NULL,
 oasis_signature_first_name varchar(30) default NULL,
 oasis_signature_middle_init varchar(30) default NULL,
 oasis_additional_notes text
 ) engine=MyISAM;
#EndIf

#IfNotRow registry directory oasis_nursing_soc
INSERT INTO `registry` VALUES ('OASIS SOC/ROC-Nursing', 1, 'oasis_nursing_soc', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');
#EndIf

#IfNotRow2D registry directory oasis_nursing_soc category OASIS
UPDATE registry SET category='OASIS' WHERE directory='oasis_nursing_soc';
#EndIf



#IfNotTable forms_oasis_pt_soc
CREATE TABLE IF NOT EXISTS `forms_oasis_pt_soc` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
detail varchar(100),
process varchar(100),
data varchar(100),
label varchar(100),
oasis_patient_patient_name varchar(30),
oasis_patient_caregiver varchar(30),
oasis_patient_visit_date DATE,
time_in varchar(10),
time_out varchar(10),
oasis_patient_cms_no varchar(20),
oasis_patient_branch_state varchar(20),
oasis_patient_branch_id_no varchar(20),
oasis_patient_npi varchar(20),
oasis_patient_npi_na varchar(4),
oasis_patient_referring_physician_id varchar(20),
oasis_patient_referring_physician_id_na varchar(4),
oasis_patient_primary_physician_last varchar(20),
oasis_patient_primary_physician_first varchar(20),
oasis_patient_primary_physician_phone varchar(20),
oasis_patient_primary_physician_address varchar(40),
oasis_patient_primary_physician_city varchar(20),
oasis_patient_primary_physician_state varchar(20),
oasis_patient_primary_physician_zip varchar(10),
oasis_patient_other_physician_last varchar(20),
oasis_patient_other_physician_first varchar(20),
oasis_patient_other_physician_phone varchar(20),
oasis_patient_other_physician_address varchar(40),
oasis_patient_other_physician_city varchar(20),
oasis_patient_other_physician_state varchar(20),
oasis_patient_other_physician_zip varchar(10),
oasis_patient_patient_id varchar(10),
oasis_patient_soc_date DATE,
oasis_patient_resumption_care_date varchar(20),
oasis_patient_resumption_care_date_na varchar(4),
oasis_patient_patient_name_first varchar(20),
oasis_patient_patient_name_mi varchar(20),
oasis_patient_patient_name_last varchar(20),
oasis_patient_patient_name_suffix varchar(20),
oasis_patient_patient_address_street varchar(20),
oasis_patient_patient_address_city varchar(20),
oasis_patient_patient_phone varchar(20),
oasis_patient_patient_state varchar(20),
oasis_patient_patient_zip varchar(10),
oasis_patient_medicare_no varchar(20),
oasis_patient_medicare_no_na varchar(4),
oasis_patient_ssn varchar(20),
oasis_patient_ssn_na varchar(4),
oasis_patient_medicaid_no varchar(20),
oasis_patient_medicaid_no_na varchar(4),
oasis_patient_birth_date DATE,
oasis_patient_patient_gender varchar(6),
oasis_patient_race_ethnicity varchar(12),
oasis_patient_payment_source_homecare varchar(32),
oasis_patient_payment_source_homecare_other varchar(30),
oasis_patient_certification_period_from DATE,
oasis_patient_certification_period_to DATE,
oasis_patient_discipline_person varchar(1),
oasis_patient_date_assessment_completed DATE,
oasis_patient_follow_up varchar(1),
oasis_patient_date_ordered_soc varchar(20),
oasis_patient_date_ordered_soc_na varchar(4),
oasis_patient_date_of_referral DATE,
oasis_patient_episode_timing varchar(2),
oasis_patient_history_impatient_facility varchar(20),
oasis_patient_history_impatient_facility_other varchar(20),
oasis_patient_history_discharge_date DATE,
oasis_patient_history_discharge_date_na varchar(2),
oasis_patient_history_if_diagnosis TEXT,
oasis_patient_history_if_code varchar(100),
oasis_patient_history_ip_diagnosis TEXT,
oasis_patient_history_ip_code varchar(100),
oasis_patient_history_ip_diagnosis_na varchar(2),
oasis_patient_history_ip_diagnosis_uk varchar(2),
oasis_patient_history_mrd_diagnosis TEXT,
oasis_patient_history_mrd_code varchar(100),
oasis_patient_history_mrd_diagnosis_na varchar(2),
oasis_patient_history_regimen_change varchar(22),
oasis_therapy_patient_diagnosis_1a varchar(10),
oasis_therapy_patient_diagnosis_2a varchar(10),
oasis_therapy_patient_diagnosis_2a_sub varchar(2),
oasis_therapy_patient_diagnosis_3a varchar(10),
oasis_therapy_patient_diagnosis_4a varchar(10),
oasis_therapy_patient_diagnosis_1b varchar(10),
oasis_therapy_patient_diagnosis_2b varchar(10),
oasis_therapy_patient_diagnosis_2b_sub varchar(2),
oasis_therapy_patient_diagnosis_3b varchar(10),
oasis_therapy_patient_diagnosis_4b varchar(10),
oasis_therapy_patient_diagnosis_1c varchar(10),
oasis_therapy_patient_diagnosis_2c varchar(10),
oasis_therapy_patient_diagnosis_2c_sub varchar(2),
oasis_therapy_patient_diagnosis_3c varchar(10),
oasis_therapy_patient_diagnosis_4c varchar(10),
oasis_therapy_patient_diagnosis_1d varchar(10),
oasis_therapy_patient_diagnosis_2d varchar(10),
oasis_therapy_patient_diagnosis_2d_sub varchar(2),
oasis_therapy_patient_diagnosis_3d varchar(10),
oasis_therapy_patient_diagnosis_4d varchar(10),
oasis_therapy_patient_diagnosis_1e varchar(10),
oasis_therapy_patient_diagnosis_2e varchar(10),
oasis_therapy_patient_diagnosis_2e_sub varchar(2),
oasis_therapy_patient_diagnosis_3e varchar(10),
oasis_therapy_patient_diagnosis_4e varchar(10),
oasis_therapy_patient_diagnosis_1f varchar(10),
oasis_therapy_patient_diagnosis_2f varchar(10),
oasis_therapy_patient_diagnosis_2f_sub varchar(2),
oasis_therapy_patient_diagnosis_3f varchar(10),
oasis_therapy_patient_diagnosis_4f varchar(10),
oasis_therapy_patient_diagnosis_1g varchar(10),
oasis_therapy_patient_diagnosis_2g varchar(10),
oasis_therapy_patient_diagnosis_2g_sub varchar(2),
oasis_therapy_patient_diagnosis_3g varchar(10),
oasis_therapy_patient_diagnosis_4g varchar(10),
oasis_therapy_patient_diagnosis_1h varchar(10),
oasis_therapy_patient_diagnosis_2h varchar(10),
oasis_therapy_patient_diagnosis_2h_sub varchar(2),
oasis_therapy_patient_diagnosis_3h varchar(10),
oasis_therapy_patient_diagnosis_4h varchar(10),
oasis_therapy_patient_diagnosis_1i varchar(10),
oasis_therapy_patient_diagnosis_2i varchar(10),
oasis_therapy_patient_diagnosis_2i_sub varchar(2),
oasis_therapy_patient_diagnosis_3i varchar(10),
oasis_therapy_patient_diagnosis_4i varchar(10),
oasis_therapy_patient_diagnosis_1j varchar(10),
oasis_therapy_patient_diagnosis_2j varchar(10),
oasis_therapy_patient_diagnosis_2j_sub varchar(2),
oasis_therapy_patient_diagnosis_3j varchar(10),
oasis_therapy_patient_diagnosis_4j varchar(10),
oasis_therapy_patient_diagnosis_1k varchar(10),
oasis_therapy_patient_diagnosis_2k varchar(10),
oasis_therapy_patient_diagnosis_2k_sub varchar(2),
oasis_therapy_patient_diagnosis_3k varchar(10),
oasis_therapy_patient_diagnosis_4k varchar(10),
oasis_therapy_patient_diagnosis_1l varchar(10),
oasis_therapy_patient_diagnosis_2l varchar(10),
oasis_therapy_patient_diagnosis_2l_sub varchar(2),
oasis_therapy_patient_diagnosis_3l varchar(10),
oasis_therapy_patient_diagnosis_4l varchar(10),
oasis_therapy_patient_diagnosis_1m varchar(10),
oasis_therapy_patient_diagnosis_2m varchar(10),
oasis_therapy_patient_diagnosis_2m_sub varchar(2),
oasis_therapy_patient_diagnosis_3m varchar(10),
oasis_therapy_patient_diagnosis_4m varchar(10),
oasis_therapy_surgical_procedure_a varchar(20),
oasis_therapy_surgical_procedure_a_date DATE,
oasis_therapy_surgical_procedure_b varchar(20),
oasis_therapy_surgical_procedure_b_date DATE,
oasis_patient_history_last_contact_date DATE,
oasis_patient_history_last_visit_date DATE,
oasis_patient_history_reason_home_health varchar(30),
oasis_patient_history_reason varchar(8),
oasis_patient_history_reason_other varchar(30),
oasis_patient_history_therapies varchar(8),
oasis_therapy_pragnosis varchar(1),
oasis_patient_history_advance_directives TEXT,
oasis_patient_history_family_informed varchar(3),
oasis_patient_history_family_informed_no varchar(30),
oasis_patient_history_risk_hospitalization varchar(14),
oasis_patient_history_previous_outcome TEXT,
oasis_patient_history_previous_outcome_cancer varchar(30),
oasis_patient_history_previous_outcome_other varchar(30),
oasis_patient_history_prior_hospitalization varchar(3),
oasis_patient_history_prior_hospitalization_no varchar(30),
oasis_patient_history_prior_hospitalization_reason varchar(100),
oasis_patient_history_immunizations varchar(10),
oasis_patient_history_immunizations_needs varchar(50),
oasis_patient_history_immunizations_needs_other varchar(30),
oasis_patient_history_allergies varchar(100),
oasis_patient_history_allergies_other varchar(30),
oasis_patient_history_overall_status varchar(2),
oasis_patient_history_risk_factors varchar(14),
oasis_therapy_safety_measures TEXT,
oasis_therapy_safety_measures_other varchar(30),
oasis_living_arrangements_situation varchar(2),
oasis_safety_emergency_planning1 varchar(1),
oasis_safety_emergency_planning2 varchar(1),
oasis_safety_emergency_planning3 varchar(1),
oasis_safety_emergency_planning4 varchar(1),
oasis_safety_emergency_planning5 varchar(1),
oasis_safety_emergency_planning6 varchar(1),
oasis_safety_emergency_planning7 varchar(1),
oasis_safety_emergency_planning8 varchar(1),
oasis_safety_oxygen_backup varchar(60),
oasis_safety_hazards TEXT,
oasis_safety_hazards_other varchar(30),
oasis_sanitation_hazards TEXT,
oasis_sanitation_hazards_other varchar(30),
oasis_primary_caregiver_name varchar(20),
oasis_primary_caregiver_relationship varchar(20),
oasis_primary_caregiver_phone varchar(20),
oasis_primary_caregiver_language varchar(50),
oasis_primary_caregiver_language_other varchar(30),
oasis_primary_caregiver_comments varchar(30),
oasis_primary_caregiver_able_care varchar(3),
oasis_primary_caregiver_no_reason varchar(30),
oasis_functional_limitations TEXT,
oasis_functional_limitations_other varchar(30),
oasis_sensory_status_vision_no varchar(2),
oasis_sensory_status_vision varchar(1),
oasis_sensory_status_vision_detail TEXT,
oasis_sensory_status_vision_detail_contact varchar(3),
oasis_sensory_status_vision_detail_prothesis varchar(3),
oasis_sensory_status_vision_site varchar(30),
oasis_sensory_status_vision_date DATE,
oasis_sensory_status_vision_detail_other varchar(30),
oasis_sensory_status_ears_no varchar(2),
oasis_sensory_status_hear varchar(2),
oasis_sensory_status_understand_verbal varchar(2),
oasis_sensory_status_hear_detail varchar(50),
oasis_sensory_status_hear_detail_hoh varchar(3),
oasis_sensory_status_hear_detail_vartigo varchar(3),
oasis_sensory_status_hear_detail_deaf varchar(3),
oasis_sensory_status_hear_detail_tinnitus varchar(3),
oasis_sensory_status_hear_detail_aid varchar(3),
oasis_sensory_status_hear_detail_other varchar(30),
oasis_sensory_status_musculoskeletal TEXT,
oasis_sensory_status_musculoskeletal_fracture varchar(30),
oasis_sensory_status_musculoskeletal_swollen varchar(30),
oasis_sensory_status_musculoskeletal_contractures varchar(30),
oasis_sensory_status_musculoskeletal_joint varchar(30),
oasis_sensory_status_musculoskeletal_location varchar(30),
oasis_sensory_status_musculoskeletal_amputation varchar(30),
oasis_sensory_status_musculoskeletal_other varchar(30),
oasis_sensory_status_nose_no varchar(2),
oasis_sensory_status_nose varchar(50),
oasis_sensory_status_nose_other varchar(30),
oasis_sensory_status_mouth_no varchar(2),
oasis_sensory_status_mouth varchar(100),
oasis_sensory_status_mouth_other varchar(30),
oasis_sensory_status_throat_no varchar(2),
oasis_sensory_status_throat varchar(60),
oasis_sensory_status_throat_other varchar(30),
oasis_sensory_status_speech varchar(1),
oasis_vital_sign_blood_pressure TEXT,
oasis_vital_sign_temperature varchar(10),
oasis_vital_sign_pulse varchar(10),
oasis_vital_sign_pulse_type varchar(50),
oasis_vital_sign_respiratory_rate varchar(10),
oasis_hw_height varchar(10),
oasis_hw_height_detail varchar(10),
oasis_hw_weight varchar(10),
oasis_hw_weight_detail varchar(10),
oasis_hw_weight_change varchar(3),
oasis_hw_weight_yes varchar(4),
oasis_hw_weight_lb varchar(10),
oasis_hw_weight_lb_in varchar(2),
oasis_pain_assessment_tool varchar(1),
oasis_pain_frequency_interfering varchar(1),
oasis_therapy_pain_scale varchar(2),
oasis_therapy_pain_location varchar(20),
oasis_therapy_pain_location_cause varchar(20),
oasis_therapy_pain_description varchar(10),
oasis_therapy_pain_frequency varchar(15),
oasis_therapy_pain_aggravating_factors varchar(15),
oasis_therapy_pain_aggravating_factors_other varchar(20),
oasis_therapy_pain_relieving_factors varchar(100),
oasis_therapy_pain_relieving_factors_other varchar(20),
oasis_therapy_pain_activities_limited TEXT,
oasis_therapy_experiencing_pain varchar(3),
oasis_therapy_unable_to_communicate varchar(3),
oasis_therapy_non_verbal_demonstrated TEXT,
oasis_therapy_non_verbal_demonstrated_other varchar(30),
oasis_therapy_non_verbal_demonstrated_implications varchar(30),
oasis_therapy_breakthrough_medication varchar(21),
oasis_therapy_breakthrough_medication_other varchar(30),
oasis_therapy_implications_care_plan varchar(3),
oasis_therapy_fall_risk_assessment TEXT,
oasis_therapy_fall_risk_assessment_total varchar(2),
oasis_pressure_ulcer_assessment varchar(1),
oasis_pressure_ulcer_risk varchar(1),
oasis_pressure_ulcer_unhealed_s2 varchar(1),
oasis_therapy_timed_up_trial1 varchar(3),
oasis_therapy_timed_up_trial2 varchar(3),
oasis_therapy_timed_up_average varchar(10),
oasis_integumentary_status_turgur TEXT,
oasis_integumentary_status_turgur_edema varchar(30),
oasis_integumentary_status_turgur_other varchar(30),
oasis_therapy_braden_scale_sensory varchar(2),
oasis_therapy_braden_scale_moisture varchar(2),
oasis_therapy_braden_scale_activity varchar(2),
oasis_therapy_braden_scale_mobility varchar(2),
oasis_therapy_braden_scale_nutrition varchar(2),
oasis_therapy_braden_scale_friction varchar(2),
oasis_therapy_braden_scale_total varchar(2),
oasis_therapy_pressure_ulcer_a TEXT,
oasis_therapy_pressure_ulcer_b TEXT,
oasis_therapy_pressure_ulcer_c TEXT,
oasis_therapy_pressure_ulcer_d1 TEXT,
oasis_therapy_pressure_ulcer_d2 TEXT,
oasis_therapy_pressure_ulcer_d3 TEXT,
oasis_therapy_pressure_ulcer_length varchar(10),
oasis_therapy_pressure_ulcer_width varchar(10),
oasis_therapy_pressure_ulcer_depth varchar(10),
oasis_therapy_pressure_ulcer_problematic_status varchar(2),
oasis_therapy_pressure_ulcer_current_no varchar(1),
oasis_therapy_pressure_ulcer_stage_unhealed varchar(2),
oasis_therapy_pressure_ulcer_statis_ulcer varchar(1),
oasis_therapy_pressure_ulcer_statis_ulcer_num varchar(1),
oasis_therapy_pressure_ulcer_statis_ulcer_status varchar(1),
oasis_therapy_surgical_wound varchar(1),
oasis_therapy_status_surgical_wound varchar(1),
oasis_therapy_skin_lesion varchar(1),
oasis_therapy_integumentary_status_problem varchar(2),
oasis_therapy_wound_care_done varchar(3),
oasis_therapy_wound_location varchar(20),
oasis_therapy_wound TEXT,
oasis_therapy_wound_soiled_dressing_by varchar(20),
oasis_therapy_wound_soiled_technique varchar(10),
oasis_therapy_wound_cleaned varchar(20),
oasis_therapy_wound_irrigated varchar(20),
oasis_therapy_wound_packed varchar(20),
oasis_therapy_wound_dressing_apply varchar(20),
oasis_therapy_wound_incision varchar(20),
oasis_therapy_wound_comment TEXT,
oasis_therapy_satisfactory_return_demo varchar(3),
oasis_therapy_wound_education varchar(3),
oasis_therapy_wound_education_comment TEXT,
oasis_therapy_wound_lesion_location TEXT,
oasis_therapy_wound_lesion_type TEXT,
oasis_therapy_wound_lesion_status TEXT,
oasis_therapy_wound_lesion_size_length varchar(20),
oasis_therapy_wound_lesion_size_width varchar(20),
oasis_therapy_wound_lesion_size_depth varchar(20),
oasis_therapy_wound_lesion_stage TEXT,
oasis_therapy_wound_lesion_tunneling TEXT,
oasis_therapy_wound_lesion_odor TEXT,
oasis_therapy_wound_lesion_skin TEXT,
oasis_therapy_wound_lesion_edema TEXT,
oasis_therapy_wound_lesion_stoma TEXT,
oasis_therapy_wound_lesion_appearance TEXT,
oasis_therapy_wound_lesion_drainage TEXT,
oasis_therapy_wound_lesion_color TEXT,
oasis_therapy_wound_lesion_consistency TEXT,
oasis_therapy_cardiopulmonary_problem varchar(2),
oasis_therapy_breath_sounds_type varchar(20),
oasis_therapy_breath_sounds TEXT,
oasis_therapy_breath_sounds_anterior varchar(5),
oasis_therapy_breath_sounds_posterior varchar(11),
oasis_therapy_breath_sounds_accessory_muscle_o2 varchar(2),
oasis_therapy_breath_sounds_cough varchar(7),
oasis_therapy_breath_sounds_productive varchar(5),
oasis_therapy_breath_sounds_o2_saturation varchar(30),
oasis_therapy_breath_sounds_accessory_muscle varchar(30),
oasis_therapy_breath_sounds_accessory_o2_detail varchar(30),
oasis_therapy_breath_sounds_accessory_lpm varchar(30),
oasis_therapy_breath_sounds_trach varchar(3),
oasis_therapy_breath_sounds_trach_manages varchar(10),
oasis_therapy_breath_sounds_productive_color varchar(20),
oasis_therapy_breath_sounds_productive_amount varchar(20),
oasis_therapy_breath_sounds_other varchar(30),
oasis_therapy_heart_sounds_type varchar(10),
oasis_therapy_heart_sounds TEXT,
oasis_therapy_heart_sounds_pacemaker varchar(30),
oasis_therapy_heart_sounds_pacemaker_date DATE,
oasis_therapy_heart_sounds_pacemaker_type varchar(30),
oasis_therapy_heart_sounds_other varchar(30),
oasis_therapy_heart_sounds_chest_pain varchar(10),
oasis_therapy_heart_sounds_associated_with varchar(10),
oasis_therapy_heart_sounds_frequency varchar(12),
oasis_therapy_heart_sounds_edema varchar(10),
oasis_therapy_heart_sounds_site varchar(12),
oasis_therapy_heart_sounds_edema_dependent varchar(12),
oasis_therapy_heart_sounds_capillary varchar(2),
oasis_therapy_heart_sounds_notify varchar(20),
oasis_therapy_respiratory_status varchar(1),
oasis_therapy_respiratory_treatment varchar(10),
oasis_elimination_status_tract_infection varchar(2),
oasis_elimination_status_urinary_incontinence varchar(1),
oasis_elimination_status_urinary_incontinence_occur varchar(1),
oasis_elimination_status_bowel_incontinence varchar(2),
oasis_elimination_status_ostomy_bowel varchar(1),
oasis_urinary_problem varchar(5) default NULL,
oasis_urinary text,
oasis_urinary_incontinence varchar(30) DEFAULT NULL,
oasis_urinary_management_strategy varchar(30) DEFAULT NULL,
oasis_urinary_diapers_other varchar(30) DEFAULT NULL,
oasis_urinary_color varchar(7) DEFAULT NULL,
oasis_urinary_color_other varchar(100) default NULL,
oasis_urinary_clarity varchar(10) default NULL,
oasis_urinary_odor varchar(5) default NULL,
oasis_urinary_catheter varchar(30) default NULL,
oasis_urinary_foley_date DATE default NULL,
oasis_urinary_foley_ml varchar(30) default NULL,
oasis_urinary_irrigation_solution varchar(30) default NULL,
oasis_urinary_irrigation_amount varchar(30) default NULL,
oasis_urinary_irrigation_ml varchar(30) default NULL,
oasis_urinary_irrigation_frequency varchar(30) default NULL,
oasis_urinary_irrigation_returns varchar(30) default NULL,
oasis_urinary_tolerated_procedure varchar(5) default NULL,
oasis_urinary_other varchar(30) default NULL,
oasis_bowels_problem varchar(5) default NULL,
oasis_bowels text,
oasis_bowel_regime varchar(30) default NULL,
oasis_bowels_lexative_enema varchar(10) default NULL,
oasis_bowels_lexative_enema_other varchar(30) default NULL,
oasis_bowels_incontinence mediumtext,
oasis_bowels_diapers_others varchar(30) default NULL,
oasis_bowels_ileostomy_site mediumtext,
oasis_bowels_ostomy_care varchar(15) default NULL,
oasis_bowels_other_site mediumtext,
oasis_bowels_urostomy mediumtext,
oasis_genitalia_problem varchar(5) default NULL,
oasis_genitalia text,
oasis_genitalia_discharge varchar(30) default NULL,
oasis_genitalia_imflammation varchar(30) default NULL,
oasis_genitalia_surgical_alteration varchar(30) default NULL,
oasis_genitalia_prostate_problem varchar(30) default NULL,
oasis_genitalia_date DATE default NULL,
oasis_genitalia_self_testicular_exam varchar(30) default NULL,
oasis_genitalia_frequency varchar(30) default NULL,
oasis_genitalia_date_last_PAP DATE default NULL,
oasis_genitalia_results varchar(30) default NULL,
oasis_genitalia_mastectomy varchar(30) default NULL,
oasis_genitalia_rl_date DATE default NULL,
oasis_genitalia_other varchar(30) default NULL,
oasis_abdomen_problem varchar(5) default NULL,
oasis_abdomen text,
oasis_abdomen_girth_inches varchar(30) default NULL,
oasis_abdomen_other varchar(30) default NULL,
oasis_ng_enteral_tube varchar(30) default NULL,
oasis_ng_enteral text,
oasis_ng_enteral_other varchar(30) default NULL,
oasis_endocrine_problem varchar(5) default NULL,
oasis_endocrine text,
oasis_endocrine_diabetes varchar(20) default NULL,
oasis_endocrine_diet varchar(30) default NULL,
oasis_endocrine_insulin varchar(30) default NULL,
oasis_endocrine_insulin_since DATE default NULL,
oasis_endocrine_admin_by varchar(10) default NULL,
oasis_endocrine_admin_by_other varchar(30) default NULL,
oasis_endocrine_monitored_by varchar(10) default NULL,
oasis_endocrine_monitored_by_other varchar(30) default NULL,
oasis_endocrine_blood_sugar_over varchar(30) default NULL,
oasis_endocrine_blood_sugar_under varchar(30) default NULL,
oasis_endocrine_renal varchar(30) default NULL,
oasis_endocrine_ophthalmic varchar(30) default NULL,
oasis_endocrine_neurologic varchar(30) default NULL,
oasis_endocrine_other varchar(30) default NULL,
oasis_endocrine_disease_management_problems varchar(30) default NULL,
oasis_endocrine_other1 varchar(30) default NULL,
oasis_endocrine_anemia varchar(30) default NULL,
oasis_endocrine_other2 varchar(30) default NULL,
oasis_nutrition_status_prob varchar(15) default NULL,
oasis_nutrition_status varchar(30) default NULL,
oasis_nutrition_status_other varchar(30) default NULL,
oasis_nutrition_requirements varchar(30) default NULL,
oasis_nutrition_appetite varchar(10) default NULL,
oasis_nutrition_eat_patt mediumtext,
oasis_nutrition_eat_patt1 text,
oasis_nutrition_eat_patt_freq varchar(30) default NULL,
oasis_nutrition_eat_patt_amt varchar(30) default NULL,
oasis_nutrition_weight_change varchar(10) default NULL,
oasis_nutrition_weight_change_value varchar(10) default NULL,
oasis_nutrition_eat_patt1_gain_time varchar(5) default NULL,
oasis_nutrition_patt1_other varchar(30) default NULL,
oasis_nutrition_req varchar(50) default NULL,
oasis_nutrition_req_other varchar(30) default NULL,
oasis_nutrition_risks text,
oasis_nutrition_risks_MD varchar(30) default NULL,
nutrition_total INT DEFAULT '0',
oasis_nutrition_describe varchar(30) default NULL,
oasis_neuro_cognitive_functioning varchar(2) default NULL,
oasis_neuro_when_confused varchar(2) default NULL,
oasis_neuro_when_anxious varchar(2) default NULL,
oasis_neuro_depression_screening varchar(2) default NULL,
oasis_neuro_little_interest varchar(2) default NULL,
oasis_neuro_feeling_down varchar(2) default NULL,
oasis_neuro_cognitive_symptoms text,
oasis_neuro_frequency_disruptive varchar(2) default NULL,
oasis_neuro_psychiatric_nursing varchar(2) default NULL,
oasis_neuro text,
oasis_neuro_location varchar(30) default NULL,
oasis_neuro_frequency varchar(30) default NULL,
oasis_neuro_unequaled_pupils varchar(15) default NULL,
oasis_neuro_aphasia varchar(15) default NULL,
oasis_neuro_motor_change varchar(20) default NULL,
oasis_neuro_dominant_side varchar(15) default NULL,
oasis_neuro_weakness varchar(20) default NULL,
oasis_neuro_weakness_location varchar(30) default NULL,
oasis_neuro_tremors varchar(10) default NULL,
oasis_neuro_handgrip_equal varchar(30) default NULL,
oasis_neuro_handgrip_unequal varchar(30) default NULL,
oasis_neuro_handgrip_strong varchar(30) default NULL,
oasis_neuro_handgrip_weak varchar(30) default NULL,
oasis_neuro_psychotropic_drug varchar(30) default NULL,
oasis_neuro_tremors_site varchar(30) default NULL,
oasis_neuro_dose_frequency varchar(30) default NULL,
oasis_neuro_other varchar(30) default NULL,
oasis_mental_status text,
oasis_mental_status_other varchar(30) default NULL,
oasis_psychosocial_edu_level varchar(30) default NULL,
oasis_psychosocial_primary_lang varchar(30) default NULL,
oasis_psychosocial text,
oasis_psychosocial_explain varchar(30) default NULL,
oasis_psychosocial_spiritual_resource varchar(30) default NULL,
oasis_psychosocial_phone_no varchar(50) default NULL,
oasis_psychosocial_treatment varchar(50) default NULL,
oasis_psychosocial_sleep_explain varchar(30) default NULL,
oasis_psychosocial_describe text,
oasis_psychosocial_comments text,
oasis_adl_grooming varchar(1) default NULL,
oasis_adl_dress_upper varchar(1) default NULL,
oasis_adl_dress_lower varchar(1) default NULL,
oasis_adl_wash varchar(1) default NULL,
oasis_adl_toilet_transfer varchar(1) default NULL,
oasis_adl_toileting_hygiene varchar(1) default NULL,
oasis_adl_transferring varchar(1) default NULL,
oasis_adl_ambulation varchar(1) default NULL,
oasis_adl_feeding_eating varchar(1) default NULL,
oasis_adl_current_ability varchar(1) default NULL,
oasis_adl_use_telephone varchar(2) default NULL,
oasis_adl_func_self_care varchar(1) default NULL,
oasis_adl_func_ambulation varchar(1) default NULL,
oasis_adl_func_transfer varchar(1) default NULL,
oasis_adl_func_household varchar(1) default NULL,
oasis_activities_permitted text,
oasis_activities_permitted_other varchar(30) default NULL,
oasis_adl_fall_risk_assessment varchar(1) default NULL,
oasis_adl_drug_regimen varchar(2) default NULL,
oasis_adl_medication_follow_up varchar(1) default NULL,
oasis_adl_patient_caregiver varchar(2) default NULL,
oasis_adl_management_oral_medications varchar(2) default NULL,
oasis_adl_pay_for_medications varchar(5) default NULL,
oasis_adl_management_injectable_medications varchar(2) default NULL,
oasis_adl_func_oral_med varchar(2) default NULL,
oasis_adl_inject_med varchar(2) default NULL,
oasis_care_adl_assistance varchar(2) default NULL,
oasis_care_iadl_assistance varchar(2) default NULL,
oasis_care_medication_admin varchar(2) default NULL,
oasis_care_medical_procedures varchar(2) default NULL,
oasis_care_management_equip varchar(2) default NULL,
oasis_care_supervision_safety varchar(2) default NULL,
oasis_care_advocacy_facilitation varchar(2) default NULL,
oasis_care_how_often varchar(2) default NULL,
oasis_care_therapy_visits varchar(10) default NULL,
oasis_care_therapy_need_applicable varchar(2) default NULL,
oasis_care_patient_parameter varchar(2) default NULL,
oasis_care_diabetic_foot_care varchar(2) default NULL,
oasis_care_falls_prevention varchar(2) default NULL,
oasis_care_depression_intervention varchar(2) default NULL,
oasis_care_intervention_monitor varchar(2) default NULL,
oasis_care_intervention_prevent varchar(2) default NULL,
oasis_care_pressure_ulcer varchar(2) default NULL,
oasis_homebound_status text,
oasis_homebound_status_ambulation varchar(30) default NULL,
oasis_homebound_status_assist varchar(30) default NULL,
oasis_homebound_status_due_to varchar(30) default NULL,
oasis_homebound_status_other varchar(30) default NULL,
oasis_instructions_materials text,
oasis_instructions_materials_other varchar(30) default NULL,
oasis_instructions_skilled_care text,
oasis_instructions_care_coordinated text,
oasis_instructions_care_coordinated_other varchar(30) default NULL,
oasis_instructions_topic varchar(30) default NULL,
oasis_instructions_living_will varchar(5) default NULL,
oasis_instructions_copies_located varchar(50) default NULL,
oasis_instructions_bill_of_rights varchar(5) default NULL,
oasis_instructions_patient varchar(30) default NULL,
oasis_instructions_not_understand varchar(30) default NULL,
oasis_dme varchar(2) default NULL,
oasis_dme_wound_care text,
oasis_dme_wound_care_glove varchar(15) default NULL,
oasis_dme_wound_care_other varchar(30) default NULL,
oasis_dme_diabetic text,
oasis_dme_diabetic_other varchar(30) default NULL,
oasis_dme_iv_supplies text,
oasis_dme_iv_supplies_other varchar(30) default NULL,
oasis_dme_foley_supplies text,
oasis_dme_foley_supplies_other varchar(30) default NULL,
oasis_dme_urinary text,
oasis_dme_ostomy_pouch_brand varchar(30) default NULL,
oasis_dme_ostomy_pouch_size varchar(30) default NULL,
oasis_dme_ostomy_wafer_brand varchar(30) default NULL,
oasis_dme_ostomy_wafer_size varchar(30) default NULL,
oasis_dme_urinary_other varchar(30) default NULL,
oasis_dme_miscellaneous text,
oasis_dme_miscellaneous_type varchar(30) default NULL,
oasis_dme_miscellaneous_size varchar(30) default NULL,
oasis_dme_miscellaneous_other varchar(30) default NULL,
oasis_dme_supplies text,
oasis_dme_supplies_other varchar(30) default NULL,
oasis_discharge_plan text,
oasis_discharge_plan_other varchar(30) default NULL,
oasis_discharge_plan_detail text,
oasis_discharge_plan_detail_other varchar(30) default NULL,
oasis_appliances_brace varchar(30) default NULL,
oasis_appliances_equipments text,
oasis_appliances_equipments_needs text,
oasis_appliances_equipments_HME_co varchar(30) default NULL,
oasis_appliances_equipments_HME_rep varchar(30) default NULL,
oasis_appliances_equipments_phone varchar(30) default NULL,
oasis_appliances_equipments_other_organizations text,
oasis_therapy_curr_level_bed_mobility varchar(225),
oasis_therapy_curr_level_transfers varchar(225),
oasis_therapy_curr_level_wheelchair_mobility varchar(225),
oasis_therapy_curr_level_gait_status varchar(4),
oasis_therapy_curr_level_gait TEXT,
oasis_therapy_curr_level_assistive_device varchar(30),
oasis_therapy_curr_level_device_freq varchar(15),
oasis_therapy_musculoskeletal_analysis_str_l TEXT,
oasis_therapy_musculoskeletal_analysis_str_r TEXT,
oasis_therapy_musculoskeletal_analysis_rom_l TEXT,
oasis_therapy_musculoskeletal_analysis_rom_r TEXT,
oasis_therapy_musculoskeletal_analysis_pain_l TEXT,
oasis_therapy_musculoskeletal_analysis_pain_r TEXT,
oasis_therapy_curr_level_findings TEXT,
oasis_therapy_curr_level_gait_desc varchar(30),
oasis_therapy_curr_level_gait_desc_other varchar(30),
oasis_therapy_curr_level_risk_factor TEXT,
oasis_therapy_curr_level_risk_factor_other varchar(30),
oasis_therapy_curr_level_risk_factor_other_deviation TEXT
) engine=MyISAM;
#EndIf

#IfNotRow registry directory oasis_pt_soc
INSERT INTO `registry` VALUES ('OASIS SOC/ROC-PT', 1, 'oasis_pt_soc', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');
#EndIf

#IfNotRow2D registry directory oasis_pt_soc category OASIS
UPDATE registry SET category='OASIS' WHERE directory='oasis_pt_soc';
#EndIf



#IfNotTable forms_oasis_transfer
CREATE TABLE IF NOT EXISTS `forms_oasis_transfer` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
oasistransfer_Caregiver varchar(100),
oasistransfer_Visit_Date date,
oasistransfer_Time_In varchar(40),
oasistransfer_Time_Out varchar(40),
oasistransfer_Discipline_of_Person_completing_Assessment varchar(50),
oasis_therapy_soc_date date,
oasistransfer_Assessment_Completed_Date date,
oasistransfer_Transfer_to_an_InPatient_Facility varchar(100),
oasistransfer_Influenza_Vaccine_received varchar(100),
oasistransfer_Reason_For_Influenza_Vaccine_Not_Received varchar(100),
oasistransfer_Pneumococcal_Vaccine_Recieved varchar(100),
oasistransfer_Used_Emergent_Care varchar(100),
oasistransfer_In_Emergentcare_for_Improper_medication varchar(40),
oasistransfer_In_Emergentcare_for_Injury_caused_by_fall varchar(40),
oasistransfer_In_Emergentcare_for_Respiratory_infection varchar(40),
oasistransfer_In_Emergentcare_for_Other_respiratory_problem varchar(40),
oasistransfer_In_Emergentcare_for_Heart_failure varchar(40),
oasistransfer_In_Emergentcare_for_Cardiac_dysrhythmia varchar(40),
oasistransfer_In_Emergentcare_for_Chest_Pain varchar(40),
oasistransfer_In_Emergentcare_for_Other_heart_disease varchar(40),
oasistransfer_In_Emergentcare_for_Stroke_or_TIA varchar(40),
oasistransfer_In_Emergentcare_for_Hypo_Hyperglycemia varchar(40),
oasistransfer_In_Emergentcare_for_GI_bleeding varchar(40),
oasistransfer_In_Emergentcare_for_Dehydration_malnutrition varchar(40),
oasistransfer_In_Emergentcare_for_Urinary_tract_infection varchar(40),
oasistransfer_In_Emergentcare_for_IV_catheter_Complication varchar(40),
oasistransfer_In_Emergentcare_for_Wound_infection varchar(40),
oasistransfer_In_Emergentcare_for_Uncontrolled_pain varchar(40),
oasistransfer_In_Emergentcare_for_Acute_health_problem varchar(40),
oasistransfer_In_Emergentcare_for_Deep_vein_thrombosis varchar(40),
oasistransfer_In_Emergentcare_for_Other_Reason varchar(40),
oasistransfer_In_Emergentcare_for_Reason_unknown varchar(40),
oasistransfer_Diabetic_foot_care varchar(40),
oasistransfer_Falls_prevention_Intervention varchar(40),
oasistransfer_Depression_intervention varchar(40),
oasistransfer_Intervention_to_monitor_pain varchar(40),
oasistransfer_Intervention_to_prevent_pressure_ulcers varchar(40),
oasistransfer_Pressure_ulcer_treatment varchar(40),
oasistransfer_Reason_For_PPV_Not_Received varchar(40),
oasis_speech_and_oral varchar(50),
oasistransfer_Cardiac_Status varchar(40),
oasistransfer_Heart_Failure_FollowUp_no_Action varchar(40),
oasistransfer_Heart_Failure_FollowUp_patient_Contacted varchar(40),
oasistransfer_Heart_Failure_FollowUp_Emergency_Treatment varchar(40),
oasistransfer_Heart_Failure_FollowUp_Implemented_treatment varchar(40),
oasistransfer_Heart_Failure_FollowUp_Patient_Education varchar(40),
oasistransfer_Heart_Failure_FollowUp_change_in_carePlan_orders varchar(40),
oasis_elimination_status_tract_infection varchar(50),
oasistransfer_Medication_Intervention varchar(40),
oasistransfer_Drug_Education_Intervention varchar(40),
oasistransfer_Inpatient_Facility_patient_admitted varchar(40),
oasistransfer_Hospitalized_for_Improper_medication varchar(40),
oasistransfer_Hospitalized_for_Injury_caused_by_fall varchar(40),
oasistransfer_Hospitalized_for_Respiratory_infection varchar(40),
oasistransfer_Hospitalized_for_Other_respiratory_problem varchar(40),
oasistransfer_Hospitalized_for_Heart_failure varchar(40),
oasistransfer_Hospitalized_for_Cardiac_dysrhythmia varchar(40),
oasistransfer_Hospitalized_for_Chest_Pain varchar(40),
oasistransfer_Hospitalized_for_Other_heart_disease varchar(40),
oasistransfer_Hospitalized_for_Stroke_or_TIA varchar(40),
oasistransfer_Hospitalized_for_Hypo_Hyperglycemia varchar(40),
oasistransfer_Hospitalized_for_GI_bleeding varchar(40),
oasistransfer_Hospitalized_for_Dehydration_malnutrition varchar(40),
oasistransfer_Hospitalized_for_Urinary_tract_infection varchar(40),
oasistransfer_Hospitalized_for_IV_catheter_related_infection varchar(40),
oasistransfer_Hospitalized_for_Wound_infection varchar(40),
oasistransfer_Hospitalized_for_Uncontrolled_pain varchar(40),
oasistransfer_Hospitalized_for_Acute_health_problem varchar(40),
oasistransfer_Hospitalized_for_Deep_vein_thrombosis varchar(40),
oasistransfer_Hospitalized_for_scheduled_Treatment varchar(40),
oasistransfer_Hospitalized_for_Other_Reason varchar(40),
oasistransfer_Hospitalized_for_Reason_unknown varchar(40),
oasistransfer_Admitted_in_NursingHome_for_Theraphy_Services varchar(40),
oasistransfer_Admitted_in_NursingHome_for_Respite_care varchar(40),
oasistransfer_Admitted_in_NursingHome_for_Hospice_care varchar(40),
oasistransfer_Admitted_in_NursingHome_for_Permanent_placement varchar(40),
oasistransfer_Admitted_in_NursingHome_as_Unsafe_at_home varchar(40),
oasistransfer_Admitted_in_NursingHome_for_Other_Reason varchar(40),
oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason varchar(40),
oasistransfer_Last_Home_Visit_Date date,
oasistransfer_Discharge_Transfer_Death_Date date,
oasistransfer_Disciplined_Involved_SN varchar(40),
oasistransfer_Disciplined_Involved_PT varchar(40),
oasistransfer_Disciplined_Involved_OT varchar(40),
oasistransfer_Disciplined_Involved_ST varchar(40),
oasistransfer_Disciplined_Involved_MSW varchar(40),
oasistransfer_Disciplined_Involved_CHHA varchar(40),
oasistransfer_Disciplined_Involved_Other varchar(40),
oasistransfer_Physician_notified varchar(40),
oasistransfer_Reason_For_Admission varchar(40),
oasistransfer_EmergentCare_Hospitalization_Information varchar(40),
oasistransfer_Patient_Have_Advance_Directive varchar(40),
oasistransfer_List_Of_Medications_Attached varchar(40),
oasistransfer_Plan_Of_Care_Attached varchar(40),
oasistransfer_Advance_Directive_Attached varchar(40),
oasistransfer_DNR_Attached varchar(40),
oasistransfer_Copies_Sent_To_Physician varchar(40),
oasistransfer_Copies_Sent_To_Facility varchar(40),
oasistransfer_name varchar(100),
oasistransfer_Reviewed_Date date,
oasistransfer_Entered_Date date,
oasistransfer_Transmitted_Date date
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory oasis_transfer
INSERT INTO `registry` VALUES ('OASIS-C Transfer', 1, 'oasis_transfer', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');
#EndIf

#IfNotRow2D registry directory oasis_transfer category OASIS
UPDATE registry SET category='OASIS' WHERE directory='oasis_transfer';
#EndIf



#IfNotTable forms_ot_careplan
CREATE TABLE IF NOT EXISTS `forms_ot_careplan` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
mr varchar(20) default NULL,
date_curr date default NULL,
med_dx_icd9 varchar(255),
trmnt_dx_icd9 varchar(255),
SOC_Date date,
adl_skills varchar(255),
adl_skills_text varchar(255),
dec_rom varchar(255),
dec_rom_txt varchar(255),
iadl_skills varchar(255),
iadl_skills_txt varchar(255),
dec_mobility varchar(255),
mobility_in varchar(255),
dec_safety_tech varchar(255),
safety_tech_txt varchar(255),
safety_tech_others1 varchar(255),
safety_tech_others2 varchar(255),
frequency varchar(255),
effective_date date default NULL,
evaluation varchar(255),
home_safety varchar(255),
adl_training varchar(255),
iadl_training varchar(255),
visual_comp varchar(255),
energy_copd varchar(255),
orthotics_mgmt varchar(255),
adaptive_equipment varchar(255),
cognitive_comp varchar(255),
homeue_exercise varchar(255),
patient_education varchar(255),
fine_compensatory varchar(255),
educate_safety varchar(255),
teach_bathing_skills varchar(255),
exercises_to_patient varchar(255),
exercises_others varchar(255),
imp_adl_skills varchar(255),
imp_adl_skills_in varchar(255),
imp_adl_skills_to varchar(255),
imp_iadl_skills varchar(255),
imp_iadl_skills_in varchar(255),
imp_iadl_skills_to varchar(255),
wfl_Increase varchar(40),
wfl_details varchar(255),
increase_to varchar(255),
perform varchar(255),
exercise_type varchar(255),
exercise_prompts varchar(255),
improve_safety varchar(255),
safety_technique_in varchar(255),
safety_technique_to varchar(255),
improve_mobility varchar(255),
improve_mobility_in varchar(255),
improve_mobility_to varchar(255),
shortterm_time varchar(100),
shortterm_time1 varchar(100),
shortterm_time2 varchar(100),
shortterm_time3 varchar(100),
shortterm_time4 varchar(100),
shortterm_time5 varchar(100),
shortterm_time6 varchar(100),
shortterm_time7 varchar(100),
time_others1 varchar(255),
time_others2 varchar(255),
time_others3 varchar(255),
return_to_priorlevel varchar(255),
return_priorlevel_in varchar(255),
longterm_time varchar(100),
longterm_time1 varchar(100),
longterm_time2 varchar(100),
longterm_time3 varchar(100),
longterm_time4 varchar(100),
home_exercise varchar(255),
safety_at_home varchar(255),
envrn_changes_home varchar(255),
longterm_others varchar(255),
rehabpotential varchar(100),
rehabpotential_goals_met varchar(10),
rehabpotential_others varchar(100),
careplan_discharge_comm varchar(100),
care_plan_discharge_other varchar(100),
careplan_response_agree varchar(100),
careplan_response_motivated varchar(100),
careplan_response_supp varchar(100),
addtn_treatment varchar(100),
addtn_treatment_req varchar(100),
physician_orders_obtained varchar(255),
physician_orders_needed varchar(255),
address_issues_by varchar(100),
address_issues_options varchar(255),
address_issues_others varchar(255),
additional_comments_text text,
therapist_name varchar(255)
) engine=MyISAM;
#EndIf

#IfNotRow registry directory careplan
INSERT INTO `registry` VALUES ('OT Care plan', 1, 'careplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');
#EndIf

#IfNotRow2D registry directory careplan category OT Forms
UPDATE registry SET category='OT Forms' WHERE directory='careplan';
#EndIf



#IfNotTable forms_ot_Evaluation
CREATE TABLE IF NOT EXISTS `forms_ot_Evaluation` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
mr varchar(40),
Evaluation_date date,
Evaluation_Time_In varchar(40),
Evaluation_Time_Out varchar(40), 
Evaluation_Pulse varchar(100),
Evaluation_Pulse_State varchar(40),
Evaluation_Temperature varchar(20),
Evaluation_Temperature_type varchar(40),
Evaluation_VS_other varchar(100),
Evaluation_VS_Respirations varchar(100),
Evaluation_VS_BP_Systolic varchar(40),
Evaluation_VS_BP_Diastolic varchar(40),
Evaluation_VS_BP_side varchar(40),
Evaluation_VS_BP_Body_Position varchar(40),
Evaluation_VS_BP_Body varchar(40),
Evaluation_VS_Sat varchar(40),
Evaluation_VS_Pain varchar(100),
Evaluation_VS_Pain_Intensity varchar(40),
Evaluation_VS_Location varchar(100),
Evaluation_VS_Other1 varchar(100),
Evaluation_HR_Needs_assistance varchar(10),
Evaluation_HR_Unable_to_leave_home varchar(10),
Evaluation_HR_Medical_Restrictions varchar(10),
Evaluation_HR_Medical_Restrictions_In varchar(100),
Evaluation_HR_SOB_upon_exertion varchar(10),
Evaluation_HR_Pain_with_Travel varchar(10),
Evaluation_HR_Requires_assistance varchar(10),
Evaluation_HR_Arrhythmia varchar(10),
Evaluation_HR_Bed_Bound varchar(10),
Evaluation_HR_Residual_Weakness varchar(10),
Evaluation_HR_Confusion varchar(10),
Evaluation_HR_Other varchar(255),
Evaluation_Reason_for_intervention varchar(255),
Evaluation_TREATMENT_DX_OT_Problem varchar(255),
Evaluation_PERTINENT_MEDICAL_HISTORY varchar(255),
Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS varchar(100),
Evaluation_MFP_WB_status varchar(40),
Evaluation_MFP_Other varchar(100),
Evaluation_PRIOR_LEVEL_OF_FUNCTIONING varchar(255),
Evaluation_PLOF_IADLs varchar(255),
Evaluation_FAMILY_CAREGIVER_SUPPORT varchar(100),
Evaluation_FCS_Relationship varchar(100),
Evaluation_Visits_in_Community varchar(40),
Evaluation_ADL_FEEDING varchar(100),
Evaluation_ADL_UTENSILCUP_USE varchar(100),
Evaluation_ADL_GROOMING varchar(100),
Evaluation_ADL_ORAL_HYGIENE varchar(100),
Evaluation_ADL_BED_WC_TRANSFERS varchar(100),
Evaluation_ADL_TOILET_TRANSFERS varchar(100),
Evaluation_ADL_OTHERS_TEXT varchar(255),
Evaluation_ADL_OTHERS varchar(100),
Evaluation_ADL_TOILETING varchar(100),
Evaluation_ADL_BATHING_SHOWER varchar(100),
Evaluation_ADL_UB_DRESSING varchar(100),
Evaluation_ADL_LB_DRESSING varchar(100),
Evaluation_ADL_TUB_SHOWER_TRANSFERS varchar(100),
Evaluation_CI_ADL_HOUSEKEEPING varchar(100),
Evaluation_CI_ADL_HOUSEKEEPING1 varchar(100),
Evaluation_CI_ADL_PHONE_USAGE varchar(100),
Evaluation_CI_ADL_COMMENTS varchar(255),
Evaluation_CI_ADL_COMMENTS1 varchar(255),
Evaluation_CI_ADL_LAUNDRY varchar(100),
Evaluation_CI_ADL_GROCERY_SHOPPING varchar(100),
Evaluation_CI_ADL_MEAL_PREPARATION varchar(100),
Evaluation_CI_ADL_MONEY_MANAGEMENT varchar(100),
Evaluation_CI_ADL_TRASH_MANAGEMENT varchar(100),
Evaluation_CI_ADL_TRANSPORTATION varchar(100),
Evaluation_CI_ADL_OTHERS_TEXT varchar(255),
Evaluation_CI_ADL_OTHERS varchar(100),
Evaluation_EnvBar_No_barriers varchar(10),
Evaluation_EnvBar_No_Safety_Issues varchar(10),
Evaluation_EnvBar_Bedroom_On_Second varchar(10),
Evaluation_EnvBar_No_Inadequate_grab varchar(10),
Evaluation_EnvBar_Throw_Rugs varchar(10),
Evaluation_EnvBar_No_Inadequate_smoke varchar(10),
Evaluation_EnvBar_Telephone_Not_Working varchar(10),
Evaluation_EnvBar_No_Emergency_Numbers varchar(10),
Evaluation_EnvBar_Lighting_Not_Adequate varchar(10),
Evaluation_EnvBar_No_Handrails varchar(10),
Evaluation_EnvBar_Stairs_Disrepair varchar(10),
Evaluation_EnvBar_Fire_Extinguishers varchar(10),
Evaluation_EnvBar_Other varchar(100),
Evaluation_COG_Alert_type varchar(40),
Evaluation_COG_Alert_note varchar(40),
Evaluation_COG_Oriented_Type varchar(40),
Evaluation_COG_Oriented_reason varchar(40),
Evaluation_COG_Canfollow varchar(10),
Evaluation_COG_Comments varchar(100),
Evaluation_Skil_Safety_Awareness varchar(40),
Evaluation_Skil_Attention_Span varchar(40),
Evaluation_skil_Shortterm_Memory varchar(40),
Evaluation_skil_Longterm_Memory varchar(40),
Evaluation_Mis_skil_Proprioception varchar(40),
Evaluation_Mis_skil_Visual_Tracking varchar(40),
Evaluation_Mis_skil_Peripheral_Vision varchar(40),
Evaluation_Mis_skil_Hearing varchar(40),
Evaluation_Mis_skil_Gross_Motor varchar(40),
Evaluation_Mis_skil_Fine_Motor varchar(40),
Evaluation_Mis_skil_Sensory varchar(40),
Evaluation_Mis_skil_Speech varchar(40),
Evaluation_Activity_Tolerance_Type varchar(40),
Evaluation_AT_Minutes_Participate_Note varchar(100),
Evaluation_AT_SOB varchar(40),
Evaluation_AT_RHC_Impacts_Activity varchar(40),
Evaluation_AT_Comments varchar(100),
Evaluation_Assist_devices_Walker varchar(40),
Evaluation_Assist_devices_Walker_Type varchar(40),
Evaluation_Assist_devices_Wheelchair varchar(40),
Evaluation_Assist_devices_Cane varchar(40),
Evaluation_Assist_devices_Cane_Type varchar(40),
Evaluation_Assist_devices_Glasses_For_Read varchar(100),
Evaluation_Assist_devices_Glasses_For_Distance varchar(40),
Evaluation_Assist_devices_Hearing_Aid varchar(40),
Evaluation_Assist_devices_Other varchar(100),
Evaluation_CB_Skills_Dynamic_Sitting varchar(255),
Evaluation_CB_Skills_Static_Sitting varchar(255),
Evaluation_CB_Skills_Dynamic_Standing varchar(255),
Evaluation_CB_Skills_Static_Standing varchar(255),
Evaluation_MS_ROM_All_Muscle_WFL varchar(100),
Evaluation_MS_ROM_Following_Problem_areas varchar(255),
Evaluation_MS_ROM_Problemarea_text varchar(100),
Evaluation_MS_ROM_STRENGTH_Right varchar(40),
Evaluation_MS_ROM_STRENGTH_Left varchar(40),
Evaluation_MS_ROM_ROM varchar(40),
Evaluation_MS_ROM_ROM_Type varchar(40),
Evaluation_MS_ROM_Tonicity varchar(40),
Evaluation_MS_ROM_Further_description varchar(100),
Evaluation_MS_ROM_Problemarea_text1 varchar(100),
Evaluation_MS_ROM_STRENGTH_Right1 varchar(40),
Evaluation_MS_ROM_STRENGTH_Left1 varchar(40),
Evaluation_MS_ROM_ROM1 varchar(40),
Evaluation_MS_ROM_ROM_Type1 varchar(40),
Evaluation_MS_ROM_Tonicity1 varchar(40),
Evaluation_MS_ROM_Further_description1 varchar(100),
Evaluation_MS_ROM_Problemarea_text2 varchar(100),
Evaluation_MS_ROM_STRENGTH_Right2 varchar(40),
Evaluation_MS_ROM_STRENGTH_Left2 varchar(40),
Evaluation_MS_ROM_ROM2 varchar(40),
Evaluation_MS_ROM_ROM_Type2 varchar(40),
Evaluation_MS_ROM_Tonicity2 varchar(40),
Evaluation_MS_ROM_Further_description2 varchar(100),
Evaluation_MS_ROM_Problemarea_text3 varchar(100),
Evaluation_MS_ROM_STRENGTH_Right3 varchar(40),
Evaluation_MS_ROM_STRENGTH_Left3 varchar(40),
Evaluation_MS_ROM_ROM3 varchar(40),
Evaluation_MS_ROM_ROM_Type3 varchar(40),
Evaluation_MS_ROM_Tonicity3 varchar(40),
Evaluation_MS_ROM_Further_description3 varchar(100),
Evaluation_MS_ROM_Comments varchar(255),
Evaluation_Summary_OT_Evaluation_Only varchar(255),
Evaluation_Summary_Need_physician_Orders varchar(255),
Evaluation_Summary_Received_Physician_Orders varchar(255),
Evaluation_approximate_next_visit_date date,
Evaluation_OT_Evaulation_Communicated_Agreed varchar(100),
Evaluation_OT_Evaulation_Communicated_other varchar(255),
Evaluation_ASP_Home_Exercise_Initiated varchar(100),
Evaluation_ASP_Environmental_Adaptations_Discussed varchar(100),
Evaluation_ASP_Safety_Issues_Discussed varchar(100),
Evaluation_ASP_Treatment_For varchar(100),
Evaluation_ASP_Treatment_For_text varchar(255),
Evaluation_ASP_Other varchar(255),
Evaluation_Skilled_OT_Reasonable_And_Necessary_To varchar(100),
Evaluation_Skilled_OT_Other varchar(255),
Evaluation_Additional_Comments varchar(255),
Evaluation_Therapist_Who_Developed_POC varchar(255)) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory evaluation
INSERT INTO `registry` VALUES ('OT Evaluation', 1, 'evaluation', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');
#EndIf

#IfNotRow2D registry directory evaluation category OT Forms
UPDATE registry SET category='OT Forms' WHERE directory='evaluation';
#EndIf



#IfNotTable forms_ot_Reassessment
CREATE TABLE IF NOT EXISTS `forms_ot_Reassessment` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
mr varchar(40),
Reassessment_Visit_Count varchar(40),
Reassessment_Time_In varchar(255),
Reassessment_Time_Out varchar(255),
Reassessment_date date,
Reassessment_Pulse varchar(100),
Reassessment_Pulse_State varchar(40),
Reassessment_Temperature varchar(20),
Reassessment_Temperature_type varchar(40),
Reassessment_VS_other varchar(100),
Reassessment_VS_Respirations varchar(100),
Reassessment_VS_BP_Systolic varchar(40),
Reassessment_VS_BP_Diastolic varchar(40),
Reassessment_VS_BP_Body_side varchar(40),
Reassessment_VS_BP_Body_Position varchar(40),
Reassessment_VS_Sat varchar(40),
Reassessment_VS_Pain varchar(100),
Reassessment_VS_Pain_Intensity varchar(40),
Reassessment_VS_Pain_Intensity_type varchar(40),
Reassessment_VS_Other1 varchar(100),
Reassessment_HR_Needs_assistance varchar(10),
Reassessment_HR_Unable_to_leave_home varchar(10),
Reassessment_HR_Medical_Restrictions varchar(10),
Reassessment_HR_Medical_Restrictions_In varchar(100),
Reassessment_HR_SOB_upon_exertion varchar(10),
Reassessment_HR_Pain_with_Travel varchar(10),
Reassessment_HR_Requires_assistance varchar(10),
Reassessment_HR_Arrhythmia varchar(10),
Reassessment_HR_Bed_Bound varchar(10),
Reassessment_HR_Residual_Weakness varchar(10),
Reassessment_HR_Confusion varchar(10),
Reassessment_HR_Other varchar(255),
Reassessment_TREATMENT_DX_Problem varchar(255),
Reassessment_ADL_Feeding_Initial_Status varchar(100),
Reassessment_ADL_Feeding_Current_Status varchar(100),
Reassessment_ADL_Feeding_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Grooming_Oral_Initial_Status varchar(100),
Reassessment_ADL_Grooming_Oral_Current_Status varchar(100),
Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Toileting_Initial_Status varchar(100),
Reassessment_ADL_Toileting_Current_Status varchar(100),
Reassessment_ADL_Toileting_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Bath_shower_Initial_Status varchar(100),
Reassessment_ADL_Bath_shower_Current_Status varchar(100),
Reassessment_ADL_Bath_shower_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Dressing_UB_LB_Initial_Status varchar(100),
Reassessment_ADL_Dressing_UB_LB_Current_Status varchar(100),
Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Functional_Mobility_Initial_Status varchar(100),
Reassessment_ADL_Functional_Mobility_Current_Status varchar(100),
Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Home_Mgt_Initial_Status varchar(100),
Reassessment_ADL_Home_Mgt_Current_Status varchar(100),
Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Transportation_Initial_Status varchar(100),
Reassessment_ADL_Transportation_Current_Status varchar(100),
Reassessment_ADL_Transportation_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_STANDING_BALANCE_Initial_Status varchar(100),
Reassessment_ADL_STANDING_BALANCE_Current_Status varchar(100),
Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_SITTING_BALANCE_Initial_Status varchar(100),
Reassessment_ADL_SITTING_BALANCE_Current_Status varchar(100),
Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills varchar(100),
Reassessment_Assistive_Devices varchar(40),
Reassessment_Assistive_Devices_Cane_Type varchar(40),
Reassessment_Assistive_Devices_Walker_Type varchar(40),
Reassessment_Assistive_Devices_Other varchar(100),
Reassessment_Timed_Up_Go_Score varchar(40),
Reassessment_Interpretation_Risk_Types varchar(40),
Reassessment_Other_Interpretations varchar(255),
Reassessment_Interpretation_NA varchar(10),
Reassessment_Problems_Achieving_Goals varchar(255),
Reassessment_Environmental_Barriers varchar(100),
Reassessment_Environmental_Issues_Notes varchar(255),
Reassessment_Compensatory_Safety_Awareness varchar(40),
Reassessment_Compensatory_Attention_Span  varchar(40),
Reassessment_Compensatory_Short_Term_Memory  varchar(40),
Reassessment_Compensatory_Long_Term_Memory varchar(40),
Reassessment_Compensatory_For_Vision varchar(40),
Reassessment_Compensatory_For_Hearing varchar(40),
Reassessment_Compensatory_For_Activity_Tolerance varchar(40),
Reassessment_Compensatory_For_Gross_Motor varchar(40),
Reassessment_Compensatory_For_Fine_Motor varchar(40),
Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices varchar(40),
Reassessment_Compensatory_NA varchar(10),
Reassessment_Compensatory_Problems_Achieving_Goals varchar(255),
Reassessment_MS_ROM_All_Muscle_WFL varchar(100),
Reassessment_MS_ROM_ALL_ROM_WFL varchar(100),
Reassessment_MS_ROM_Following_Problem_areas varchar(100),
Reassessment_MS_ROM_Problemarea_text varchar(100),
Reassessment_MS_ROM_STRENGTH_Right varchar(40),
Reassessment_MS_ROM_STRENGTH_Left varchar(40),
Reassessment_MS_ROM_ROM varchar(40),
Reassessment_MS_ROM_ROM_Type varchar(40),
Reassessment_MS_ROM_Tonicity varchar(40),
Reassessment_MS_ROM_Further_description varchar(100),
Reassessment_MS_ROM_Problemarea_text1 varchar(100),
Reassessment_MS_ROM_STRENGTH_Right1 varchar(40),
Reassessment_MS_ROM_STRENGTH_Left1 varchar(40),
Reassessment_MS_ROM_ROM1 varchar(40),
Reassessment_MS_ROM_ROM_Type1 varchar(40),
Reassessment_MS_ROM_Tonicity1 varchar(40),
Reassessment_MS_ROM_Further_description1 varchar(100),
Reassessment_MS_ROM_Problemarea_text2 varchar(100),
Reassessment_MS_ROM_STRENGTH_Right2 varchar(40),
Reassessment_MS_ROM_STRENGTH_Left2 varchar(40),
Reassessment_MS_ROM_ROM2 varchar(40),
Reassessment_MS_ROM_ROM_Type2 varchar(40),
Reassessment_MS_ROM_Tonicity2 varchar(40),
Reassessment_MS_ROM_Further_description2 varchar(100),
Reassessment_MS_ROM_Problemarea_text3 varchar(100),
Reassessment_MS_ROM_STRENGTH_Right3 varchar(40),
Reassessment_MS_ROM_STRENGTH_Left3 varchar(40),
Reassessment_MS_ROM_ROM3 varchar(40),
Reassessment_MS_ROM_ROM_Type3 varchar(40),
Reassessment_MS_ROM_Tonicity3 varchar(40),
Reassessment_MS_ROM_Further_description3 varchar(100),
Reassessment_MS_ROM_NA varchar(10),
Reassessment_MS_ROM_Problems_Achieving_Goals_Type varchar(40),
Reassessment_MS_ROM_Problems_Achieving_Goals_Note varchar(255),
Reassessment_RO_Patient_Prior_Level_Function varchar(10),
Reassessment_RO_Patient_Prior_Level_Function_No1 varchar(255),
Reassessment_RO_Patient_Prior_Level_Function_No2 varchar(255),
Reassessment_RO_Patient_Long_Term_Goals varchar(10),
Reassessment_Skilled_OT_Reasonable_And_Necessary_To varchar(100),
Reassessment_Skilled_OT_Other varchar(255),
Reassessment_Goals_Changed_Adapted_For_ADLs varchar(255),
Reassessment_Goals_Changed_Adapted_For_ADLs1 varchar(255),
Reassessment_Goals_Changed_Adapted_For_IDLs varchar(255),
Reassessment_Goals_Changed_Adapted_For_Other varchar(255),
Reassessment_OT_communicated_and_agreed_upon_by varchar(50),
Reassessment_OT_communicated_and_agreed_upon_by_other varchar(100),
Reassessment_ADDITIONAL_SERVICES_Home_Exercise varchar(40),
Reassessment_ADDITIONAL_SERVICES_Recomme_Env_Adaptations varchar(40),
Reassessment_ADDITIONAL_SERVICES_Recomme_SafetyIssues varchar(40),
Reassessment_ADDITIONAL_SERVICES_Treatment varchar(40),
Reassessment_ADDITIONAL_SERVICES_Treatment_for varchar(255),
Reassessment_Other_Services_Provided varchar(255),
Reassessment_Therapist_Performing_Reassessment varchar(255),
Reassessment_Therapist_name varchar(255)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory reassessment
INSERT INTO `registry` VALUES ('OT Reassessment', 1, 'reassessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');
#EndIf

#IfNotRow2D registry directory reassessment category OT Forms
UPDATE registry SET category='OT Forms' WHERE directory='reassessment';
#EndIf



#IfNotTable forms_ot_visit_discharge_note
CREATE TABLE IF NOT EXISTS `forms_ot_visit_discharge_note` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
dischargeplan_Time_In varchar(255),
dischargeplan_Time_Out varchar(255),
dischargeplan_date date,
dischargeplan_Vital_Signs_Pulse varchar(255),
dischargeplan_Vital_Signs_Regular varchar(255),
dischargeplan_Vital_Signs_Irregular varchar(255),
dischargeplan_Vital_Signs_Temperature varchar(255),
dischargeplan_Vital_Signs_Oral varchar(255),
dischargeplan_Vital_Signs_Temporal varchar(255),
dischargeplan_Vital_Signs_other varchar(255),
dischargeplan_Vital_Signs_Respirations varchar(255),
dischargeplan_Vital_Signs_BP_Systolic varchar(255),
dischargeplan_Vital_Signs_BP_Diastolic varchar(255),
dischargeplan_Vital_Signs_Right varchar(255),
dischargeplan_Vital_Signs_Left varchar(255),
dischargeplan_Vital_Signs_Sitting varchar(255),
dischargeplan_Vital_Signs_Standing varchar(255),
dischargeplan_Vital_Signs_Lying varchar(255),
dischargeplan_Vital_Signs_Sat varchar(255),
dischargeplan_Vital_Signs_Pain_Intensity varchar(255),
dischargeplan_Vital_Signs_chronic_condition varchar(255),
dischargeplan_Vital_Signs_Patient_states varchar(255),
dischargeplan_Vital_Signs_Patient_states_other varchar(255),
dischargeplan_treatment_diagnosis_problem varchar(255),
dischargeplan_Mental_Status varchar(255),
dischargeplan_Mental_Status_Other varchar(255),
dischargeplan_Mental_Status_MSS varchar(255),
dischargeplan_Mental_Status_CMT varchar(255), 
dischargeplan_Mental_Status_CCT varchar(255),
dischargeplan_Mental_Status_Other1 varchar(255),
dischargeplan_specific_training_this_visit longtext,
dischargeplan_RfD_No_Further_Skilled varchar(255),
dischargeplan_RfD_Short_Term_Goals varchar(255),
dischargeplan_RfD_Long_Term_Goals varchar(255),
dischargeplan_RfD_Patient_homebound varchar(255),
dischargeplan_RfD_rehab_potential varchar(255),
dischargeplan_RfD_refused_services varchar(255),
dischargeplan_RfD_out_of_service_area varchar(255),
dischargeplan_RfD_Admitted_to_Hospital varchar(255),
dischargeplan_RfD_higher_level_of_care varchar(255),
dischargeplan_RfD_another_Agency varchar(255),
dischargeplan_RfD_Death varchar(255),
dischargeplan_RfD_Transferred_Hospice varchar(255),
dischargeplan_RfD_MD_Request varchar(255),
dischargeplan_RfD_other varchar(255),
dischargeplan_ToD_ADL varchar(255),
dischargeplan_ToD_ADL_notes varchar(255),
dischargeplan_ToD_ADL1 varchar(255),
dischargeplan_ToD_ADL1_notes varchar(255),
dischargeplan_ToD_IADL varchar(255),
dischargeplan_ToD_IADL_notes varchar(255),
dischargeplan_ToD_IADL1 varchar(255),
dischargeplan_ToD_IADL1_notes varchar(255),
dischargeplan_ToD_ROM varchar(255),
dischargeplan_ToD_ROM_in varchar(255),
dischargeplan_ToD_Safety_Management varchar(255),
dischargeplan_ToD_Safety_Management_in varchar(255),
dischargeplan_ToD_Env_Adaptations varchar(255),
dischargeplan_ToD_Env_Adaptations_inc varchar(255),
dischargeplan_ToD_AE_Usage varchar(255),
dischargeplan_ToD_AE_Usage_for varchar(255),
dischargeplan_ToD_CF_Performance varchar(255),
dischargeplan_ToD_CF_Performance_in varchar(255),
dischargeplan_ToD_Per_Home_Exercises varchar(255),
dischargeplan_ToD_Per_Home_Exercises_for varchar(255),
dischargeplan_ToD_Other varchar(255),
dischargeplan_ToD_Status_of_Patient varchar(255),
dischargeplan_Functional_Ability_Timeof_Discharge varchar(255),
dischargeplan_Discharge_anticipated varchar(100),
dischargeplan_Discharge_not_anticipated varchar(100),
dischargeplan_follow_up_treatment varchar(100),
dischargeplan_Recommendations_met varchar(100),
dischargeplan_Recommendations_partially varchar(100),
dischargeplan_Recommendations_not_met varchar(100),
dischargeplan_Recommendations_not_met_note varchar(100),
dischargeplan_md_name varchar(255),
dischargeplan_md_signature varchar(255),
dischargeplan_md_date DATE
) engine=MyISAM;
#EndIf

#IfNotRow registry directory visit_discharge_test
INSERT INTO `registry` VALUES ('OT Visit Discharge', 1, 'visit_discharge_test', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');
#EndIf

#IfNotRow2D registry directory visit_discharge_test category OT Forms
UPDATE registry SET category='OT Forms' WHERE directory='visit_discharge_test';
#EndIf



#IfNotTable forms_ot_visitnote
CREATE TABLE IF NOT EXISTS `forms_ot_visitnote` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
visitnote_Time_In varchar(40),
visitnote_Time_Out varchar(40),
visitnote_date_curr date default NULL,
visitnote_visit_type varchar(100),
visitnote_TOV_Visit_Other varchar(255),
visitnote_VS_Pulse varchar(40),
visitnote_Pulse_Rate varchar(100),
visitnote_VS_Temperature varchar(40),
visitnote_Temperature varchar(100),
visitnote_VS_Other varchar(40),
visitnote_VS_Respirations varchar(40),
visitnote_VS_BP_Systolic varchar(40),
visitnote_VS_BP_Diastolic varchar(40),
visitnote_BloodPrerssure_side varchar(100),
visitnote_BloodPrerssure_position varchar(100),
visitnote_VS_BP_Sat varchar(40),
visitnote_Pain_Level varchar(100),
visitnote_VS_Pain_Intensity varchar(40),
visitnote_Pain_Intensity varchar(100),
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
visitnote_Interventions_Patient varchar(100),
visitnote_Interventions_Caregiver varchar(100),
visitnote_Interventions_Patient_Caregiver varchar(100),
visitnote_Interventions_Other varchar(255),
visitnote_Home_Safety_Evaluation varchar(100),
visitnote_IADL_ADL_Training varchar(100),
visitnote_Muscle_ReEducation varchar(100),
visitnote_Visual_Perceptual_Training varchar(100),
visitnote_Fine_Gross_Motor_Training varchar(100),
visitnote_Patient_Caregiver_Family_Education varchar(100),
visitnote_Therapeutic_Exercises varchar(100),
visitnote_Neuro_developmental_Training varchar(100),
visitnote_Sensory_Training varchar(100),
visitnote_Orthotics_Splinting varchar(100),
visitnote_Adaptive_Equipment_training varchar(100),
visitnote_Teach_Home_Fall_Safety_Precautions varchar(100),
visitnote_Teach_alternative_bathing_skills varchar(100),
visitnote_Exercises_Safety_Techniques varchar(100),
visitnote_Interventions_Other1 varchar(255),
visitnote_Specific_Training_Visit varchar(255),
visitnote_changes_in_medications_Yes varchar(100),
visitnote_changes_in_medications_No varchar(100),	
visitnote_Functional_Improvement_ADL varchar(100), 
visitnote_Functional_Improvement_ADL_Notes varchar(100),
visitnote_Functional_Improvement_ADL1 varchar(100),
visitnote_Functional_Improvement_ADL1_Notes varchar(100),
visitnote_Functional_Improvement_IADL varchar(100),
visitnote_Functional_Improvement_IADL_Notes varchar(100),
visitnote_Functional_Improvement_IADL1 varchar(100),
visitnote_Functional_Improvement_IADL1_Notes varchar(100),
visitnote_Functional_Improvement_ROM varchar(100),
visitnote_Functional_Improvement_ROM_In varchar(100),
visitnote_Functional_Improvement_SM varchar(100),
visitnote_Functional_Improvement_SM_In varchar(100),
visitnote_Functional_Improvement_EA varchar(100),
visitnote_Functional_Improvement_EA_including varchar(100),
visitnote_Functional_Improvement_AEU varchar(100),
visitnote_Functional_Improvement_AEU_For varchar(100),
visitnote_Functional_Improvement_Car_Fam_Perf varchar(100),
visitnote_Functional_Improvement_Car_Fam_Perf_In varchar(100),
visitnote_Functional_Improvement_Perf_Home_Exer varchar(100),
visitnote_Functional_Improvement_Perf_Home_Exer_For varchar(100),
visitnote_Functional_Improvement_Other varchar(255),
visitnote_Previous_fall varchar(100),
visitnote_Timed_Up_Go_Score varchar(100),
visitnote_Fall_Risk varchar(100),
visitnote_Other_Tests_Scores_Interpretations varchar(255),
visitnote_Response varchar(100),
visitnote_RT_Revisit_Other varchar(255),
visitnote_CarePlan_Reviewed_With varchar(100),
visitnote_Discharge_Discussed_With varchar(100),
visitnote_CarePlan_Reviewed_to varchar(100),
visitnote_CPRW_Other varchar(255),
visitnote_CP_Modifications_Include varchar(100),
visitnote_CP_Modifications_Include_Notes varchar(255),
visitnote_further_Visit_Required_text varchar(255),
visitnote_further_Visit_Required varchar(100),
visitnote_FSVR_Other varchar(255),
visitnote_Date_of_Next_Visit varchar(100),
visitnote_further_Visit_Required_text varchar(255),
visitnote_No_further_visits varchar(100),
treatment_Plan varchar(100),
Additional_Treatment varchar(100),
issues_Communication varchar(100),
supervisor_visit varchar(100),
visitnote_Supervisory_visit_Observed varchar(100),
visitnote_Supervisory_visit_Teaching_Training varchar(100),
visitnote_Supervisory_visit_Patient_Family_Discussion varchar(100)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory visit_notes
INSERT INTO `registry` VALUES ('OT Visit Notes', 1, 'visit_notes', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');
#EndIf

#IfNotRow2D registry directory visit_notes category OT Forms
UPDATE registry SET category='OT Forms' WHERE directory='visit_notes';
#EndIf



#IfNotTable forms_pt_careplan
CREATE TABLE IF NOT EXISTS `forms_pt_careplan` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
Onsetdate date,
careplan_PT_intervention varchar(255),
careplan_Treatment_DX varchar(255),
careplan_SOCDate date,
careplan_PT_Decline_in_mobility varchar(10),
careplan_PT_Decline_in_mobility_Note varchar(255),
careplan_PT_Decrease_in_ROM varchar(10),
careplan_PT_Decrease_in_ROM_Note varchar(255), 
careplan_PT_Decline_in_Strength varchar(10),
careplan_PT_Decline_in_Strength_Note varchar(255), 
careplan_PT_Increased_Pain_with_Movement varchar(10),
careplan_PT_Increased_Pain_with_Movement_Note varchar(255), 
careplan_PT_Decline_in_Balance varchar(10),
careplan_PT_Decline_in_Balance_Note varchar(255), 
careplan_PT_Decreased_Safety varchar(10),
careplan_PT_Decreased_Safety_Note varchar(255),
careplan_PT_intervention_Other varchar(255),
careplan_Treatment_Plan_Frequency varchar(50),
careplan_Treatment_Plan_EffectiveDate date,
careplan_Evaluation varchar(10),
careplan_Home_Therapeutic_Exercises varchar(10),
careplan_Gait_ReTraining varchar(10),
careplan_Bed_Mobility_Training varchar(10),
careplan_Transfer_Training varchar(10),
careplan_Balance_Training_Activities varchar(10),
careplan_Patient_Caregiver_Family_Education varchar(10),
careplan_Assistive_Device_Training varchar(10),
careplan_Neuro_developmental_Training varchar(10),
careplan_Orthotics_Splinting varchar(10),
careplan_Hip_Safety_Precaution_Training varchar(10),
careplan_Physical_Agents varchar(10),
careplan_Physical_Agents_Name varchar(10),
careplan_Physical_Agents_For varchar(10),
careplan_Muscle_ReEducation varchar(10),
careplan_Safe_Stair_Climbing_Skills varchar(10),
careplan_Exercises_to_manage_pain varchar(10),
careplan_Fall_Precautions_Training varchar(10), 
careplan_Exercises_Safety_Techniques_given_patient varchar(10),
careplan_PT_Other varchar(255),
careplan_STO_Improve_mobility_skills varchar(10),
careplan_STO_Improve_mobility_skills_In varchar(100),
careplan_STO_Improve_mobility_skills_To varchar(40),
careplan_STO_Increase_ROM varchar(10),
careplan_STO_Increase_ROM_Side varchar(40),
careplan_STO_Increase_ROM_Note varchar(50),
careplan_STO_Increase_ROM_To varchar(40),
careplan_STO_Increase_Strength varchar(10),
careplan_STO_Increase_Strength_Side varchar(40),
careplan_STO_Increase_Strength_Note varchar(100),
careplan_STO_Increase_Strength_To varchar(40),
careplan_STO_Exercises_using_written_handout varchar(10),
careplan_STO_Exercises_using_written_handout_With varchar(100),
careplan_STO_Improve_home_safety_techniques varchar(10),
careplan_STO_Improve_home_safety_techniques_In varchar(100),
careplan_STO_Improve_home_safety_techniques_To varchar(100),
careplan_STO_Demonstrate_independent_use_of_prosthesis varchar(10),
careplan_STO_Mobility_Skill_Time varchar(50),
careplan_STO_ROM_Skill_Time varchar(50),
careplan_STO_WFL_Time varchar(50),
careplan_STO_Excercise_Time varchar(50),
careplan_STO_Safety_Techniques_Time varchar(50),
careplan_STO_Independant_Use_Of_Prosthesis_Time varchar(50),
careplan_STO_Others_Time varchar(50),
careplan_STO_Other1 varchar(255),
careplan_LTO_Return_prior_level_function varchar(10),
careplan_LTO_Return_prior_level_function_In varchar(100),
careplan_LTO_Return_prior_level_function_Time varchar(50),
careplan_LTO_Demonstrate_ability_follow_home_exercise varchar(10),
careplan_LTO_Demonstrate_ability_follow_home_exercise_Time varchar(50),
careplan_LTO_Improve_mobility varchar(10),
careplan_LTO_Improve_mobility_Type varchar(50),
careplan_LTO_Improve_mobility_Time varchar(50),
careplan_LTO_Improve_independence_safety_home varchar(10),
careplan_LTO_Improve_independence_safety_home_Time varchar(50), 
careplan_LTO_Other varchar(255),
careplan_LTO_Other_Time varchar(50),
careplan_Rehab_Potential varchar(50),
careplan_DP_When_Goals_Are_Met varchar(40),
careplan_DP_Other varchar(255),
careplan_PT_communicated_and_agreed_upon_by varchar(50),
careplan_PT_communicated_and_agreed_upon_Other varchar(255),
careplan_Agreeable_to_general_goals varchar(30),
careplan_Highly_motivated_to_improve  varchar(30),
careplan_Supportive_family_caregiver varchar(30),
careplan_Physician_Orders varchar(50),
careplan_May_require_additional_treatment varchar(50),
careplan_May_require_additional_treatment_dueto varchar(255),
careplan_Will_address_above_issues varchar(50),
careplan_Will_address_above_issues_by varchar(255),
careplan_Physician_Orders_Other varchar(255),
careplan_Therapist_Who_Developed_POC varchar(255),
careplan_STO_Others2_Time varchar(50),
careplan_STO_Strength_Time varchar(50),
careplan_Additional_comments varchar(255),
careplan_STO_Other varchar(255),
careplan_STO_Other_Time varchar(50),
careplan_STO_Time varchar(50)
) engine=MyISAM;
#EndIf

#IfNotRow registry directory ptcareplan
INSERT INTO `registry` VALUES ('PT Care plan', 1, 'ptcareplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');
#EndIf

#IfNotRow2D registry directory ptcareplan category PT Forms
UPDATE registry SET category='PT Forms' WHERE directory='ptcareplan';
#EndIf



#IfNotTable forms_pt_Evaluation
CREATE TABLE IF NOT EXISTS `forms_pt_Evaluation` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
mr varchar(40),
Evaluation_date date,
Evaluation_Time_In varchar(40),
Evaluation_Time_Out varchar(40),
Evaluation_Pulse varchar(100),
Evaluation_Pulse_State varchar(40),
Evaluation_Temperature varchar(20),
Evaluation_Temperature_type varchar(40),
Evaluation_VS_other varchar(100),
Evaluation_VS_Respirations varchar(100),
Evaluation_VS_BP_Systolic varchar(40),
Evaluation_VS_BP_Diastolic varchar(40),
Evaluation_VS_BP_Body_side varchar(40),
Evaluation_VS_BP_Body_Position varchar(40),
Evaluation_VS_Sat varchar(40),
Evaluation_VS_Pain varchar(100),
Evaluation_VS_Pain_Intensity varchar(40),
Evaluation_VS_Location varchar(100),
Evaluation_VS_Other1 varchar(255),
Evaluation_HR_Needs_assistance varchar(10),
Evaluation_HR_Unable_to_leave_home varchar(10),
Evaluation_HR_Medical_Restrictions varchar(10),
Evaluation_HR_Medical_Restrictions_In varchar(100),
Evaluation_HR_SOB_upon_exertion varchar(10),
Evaluation_HR_Pain_with_Travel varchar(10),
Evaluation_HR_Requires_assistance varchar(10),
Evaluation_HR_Arrhythmia varchar(10),
Evaluation_HR_Bed_Bound varchar(10),
Evaluation_HR_Residual_Weakness varchar(10),
Evaluation_HR_Confusion varchar(10),
Evaluation_HR_Multiple_Stairs_Home varchar(10),
Evaluation_HR_Other varchar(255),
Evaluation_Reason_for_intervention varchar(255),
Evaluation_TREATMENT_DX_PT_Problem varchar(255),
Evaluation_PERTINENT_MEDICAL_HISTORY varchar(255),
Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS varchar(100),
Evaluation_MFP_WB_status varchar(40),
Evaluation_MFP_Other varchar(100),
Evaluation_Prior_level_Mobility_Home varchar(40),
Evaluation_Prior_level_Mobility_Other varchar(255),
Evaluation_PLM_Stairs_Front_House varchar(50),
Evaluation_PLM_Stairs_Back_House varchar(50),
Evaluation_PLM_Stairs_Second_Level varchar(50),
Evaluation_Prior_level_Mobility_Community varchar(40),
Evaluation_Family_Caregiver_Support varchar(10),
Evaluation_Family_Caregiver_Support_Who varchar(50),
Evaluation_FC_Visits_Community_Weekly varchar(40),
Evaluation_FC_Additional_Comments varchar(255),
Evaluation_CMS_ROLLING_RIGHT varchar(255),
Evaluation_CMS_ROLLING_LEFT varchar(255),
Evaluation_CMS_BRIDGING_SCOOT varchar(255),
Evaluation_CMS_SUPINE_SIT varchar(255),
Evaluation_CMS_SIT_STAND varchar(255),
Evaluation_CMS_BED_CHAIR_TRANSFERS varchar(255),
Evaluation_CMS_TOILET_TRANSFERS varchar(255),
Evaluation_CMS_Other_text varchar(255),
Evaluation_CMS_Other varchar(255),
Evaluation_CMS_COMMENTS text,
Evaluation_GAIT_SKILLS varchar(100),
Evaluation_GS_Assistance varchar(100),
Evaluation_GS_Distance_Time varchar(100),
Evaluation_GS_Surfaces varchar(50),
Evaluation_GS_Assistive_Devices varchar(100),
Evaluation_GS_Assistive_Devices_Other varchar(255),
Evaluation_GS_Gait_Deviations text,
Evaluation_WHEELCHAIR_SKILLS  varchar(100),
Evaluation_WS_Assistance varchar(100),
Evaluation_WS_Distance_Time varchar(100),
Evaluation_WS_Surfaces varchar(50),
Evaluation_WS_Surfaces_other varchar(50),
Evaluation_WS_Remove_Footrests varchar(40),
Evaluation_WS_Remove_Armrests varchar(40),
Evaluation_WS_Reposition_WC varchar(40),
Evaluation_WS_Posture_Alignment_Chair varchar(40),
Evaluation_WS_Other text,
Evaluation_COG_Alert_type varchar(40),
Evaluation_COG_Oriented_Type varchar(40),
Evaluation_COG_Canfollow varchar(10),
Evaluation_COG_Safety_Awareness varchar(40),
Evaluation_Mis_skil_Endurance varchar(40),
Evaluation_Mis_skil_Communication varchar(40),
Evaluation_Mis_skil_Hearing varchar(40),
Evaluation_Mis_skil_Vision varchar(40),
Evaluation_CB_Skills_Dynamic_Sitting varchar(255),
Evaluation_CB_Skills_Static_Sitting varchar(255),
Evaluation_CB_Skills_Dynamic_Standing varchar(255),
Evaluation_CB_Skills_Static_Standing varchar(255),
Evaluation_MS_ROM_All_Muscle_WFL varchar(100),
Evaluation_MS_ROM_ALL_ROM_WFL varchar(100),
Evaluation_MS_ROM_Following_Problem_areas varchar(100),
Evaluation_MS_ROM_Problemarea_text varchar(100),
Evaluation_MS_ROM_STRENGTH_Right varchar(40),
Evaluation_MS_ROM_STRENGTH_Left varchar(40),
Evaluation_MS_ROM_ROM varchar(40),
Evaluation_MS_ROM_ROM_Type varchar(40),
Evaluation_MS_ROM_Tonicity varchar(40),
Evaluation_MS_ROM_Problemarea_text1 varchar(100),
Evaluation_MS_ROM_STRENGTH_Right1 varchar(40),
Evaluation_MS_ROM_STRENGTH_Left1 varchar(40),
Evaluation_MS_ROM_ROM1 varchar(40),
Evaluation_MS_ROM_ROM_Type1 varchar(40),
Evaluation_MS_ROM_Tonicity1 varchar(40),
Evaluation_MS_ROM_Problemarea_text2 varchar(100),
Evaluation_MS_ROM_STRENGTH_Right2 varchar(40),
Evaluation_MS_ROM_STRENGTH_Left2 varchar(40),
Evaluation_MS_ROM_ROM2 varchar(40),
Evaluation_MS_ROM_ROM_Type2 varchar(40),
Evaluation_MS_ROM_Tonicity2 varchar(40),
Evaluation_MS_ROM_Problemarea_text3 varchar(100),
Evaluation_MS_ROM_STRENGTH_Right3 varchar(40),
Evaluation_MS_ROM_STRENGTH_Left3 varchar(40),
Evaluation_MS_ROM_ROM3 varchar(40),
Evaluation_MS_ROM_ROM_Type3 varchar(40),
Evaluation_MS_ROM_Tonicity3 varchar(40),
Evaluation_MS_ROM_Further_description text,
Evaluation_MS_ROM_Comments text,
Evaluation_EnvBar_No_barriers varchar(10),
Evaluation_EnvBar_No_Safety_Issues varchar(10),
Evaluation_EnvBar_Bedroom_On_Second varchar(10),
Evaluation_EnvBar_No_Inadequate_grab varchar(10),
Evaluation_EnvBar_Throw_Rugs varchar(10),
Evaluation_EnvBar_No_Inadequate_smoke varchar(10),
Evaluation_EnvBar_No_Emergency_Numbers varchar(10),
Evaluation_EnvBar_Lighting_Not_Adequate varchar(10),
Evaluation_EnvBar_No_Handrails varchar(10),
Evaluation_EnvBar_Stairs_Disrepair varchar(10),
Evaluation_EnvBar_Fire_Extinguishers varchar(10),
Evaluation_EnvBar_Other varchar(100),
Evaluation_Summary_PT_Evaluation_Only varchar(255),
Evaluation_Summary_Need_physician_Orders varchar(255),
Evaluation_Summary_Received_Physician_Orders varchar(255),
Evaluation_approximate_next_visit_date date,
Evaluation_PT_Evaulation_Communicated_Agreed varchar(100),
Evaluation_PT_Evaulation_Communicated_other varchar(255),
Evaluation_ASP_Home_Exercise_Initiated varchar(100),
Evaluation_ASP_Falls_Management_Discussed varchar(100),
Evaluation_ASP_Safety_Issues_Discussed varchar(100),
Evaluation_ASP_Treatment_For varchar(100),
Evaluation_ASP_Treatment_For_text varchar(255),
Evaluation_ASP_Other varchar(255),
Evaluation_Skilled_PT_Reasonable_And_Necessary_To varchar(100),
Evaluation_Skilled_PT_Other varchar(255),
Evaluation_Additional_Comments varchar(255),
Evaluation_Therapist_Who_Developed_POC varchar(255)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory ptEvaluation
INSERT INTO `registry` VALUES ('PT Evaluation', 1, 'ptEvaluation', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');
#EndIf

#IfNotRow2D registry directory ptEvaluation category PT Forms
UPDATE registry SET category='PT Forms' WHERE directory='ptEvaluation';
#EndIf



#IfNotTable forms_pt_Reassessment
CREATE TABLE IF NOT EXISTS `forms_pt_Reassessment` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
Reassessment_visit_type varchar(50),
mr varchar(40),
Reassessment_date date,
Reassessment_Pulse varchar(100),
Reassessment_Pulse_State varchar(40),
Reassessment_Temperature varchar(20),
Reassessment_Temperature_type varchar(40),
Reassessment_VS_other varchar(100),
Reassessment_VS_Respirations varchar(100),
Reassessment_VS_BP_Systolic varchar(40),
Reassessment_VS_BP_Diastolic varchar(40),
Reassessment_VS_BP_side varchar(40),
Reassessment_VS_BP_Body_Position varchar(40),
Reassessment_VS_Sat varchar(40),
Reassessment_VS_Pain varchar(100),
Reassessment_VS_Pain_Intensity varchar(40),
Reassessment_VS_Pain_Intensity_type varchar(40),
Reassessment_HR_Needs_assistance varchar(10),
Reassessment_HR_Unable_to_leave_home varchar(10),
Reassessment_HR_Medical_Restrictions varchar(10),
Reassessment_HR_Medical_Restrictions_In varchar(100),
Reassessment_HR_SOB_upon_exertion varchar(10),
Reassessment_HR_Pain_with_Travel varchar(10),
Reassessment_HR_Requires_assistance varchar(10),
Reassessment_HR_Arrhythmia varchar(10),
Reassessment_HR_Bed_Bound varchar(10),
Reassessment_HR_Residual_Weakness varchar(10),
Reassessment_HR_Confusion varchar(10),
Reassessment_HR_Multiple_stairs_enter_exit_home varchar(10),
Reassessment_HR_Other text,
Reassessment_TREATMENT_DX_Problem varchar(255),
Reassessment_ADL_Rolling_Initial_Status varchar(100),
Reassessment_ADL_Rolling_Current_Status varchar(100),
Reassessment_ADL_Rolling_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Supine_Sit_Initial_Status varchar(100),
Reassessment_ADL_Supine_Sit_Current_Status varchar(100),
Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Sit_Stand_Initial_Status varchar(100),
Reassessment_ADL_Sit_Stand_Current_Status varchar(100),
Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Transfers_Initial_Status varchar(100),
Reassessment_ADL_Transfers_Current_Status varchar(100),
Reassessment_ADL_Transfers_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Fall_Recovery_Initial_Status varchar(100),
Reassessment_ADL_Fall_Recovery_Current_Status varchar(100),
Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_Gait_Assistance_Initial_Status varchar(100),
Reassessment_ADL_Gait_Assistance_Current_Status varchar(100),
Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills varchar(100),
Reassessment_ADL_WC_Assistance_Initial_Status varchar(100),
Reassessment_ADL_WC_Assistance_Current_Status varchar(100),
Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills varchar(100),
Reassessment_Mobility_Reassessment_NA varchar(40),
Reassessment_Assistive_Devices varchar(40),
Reassessment_Assistive_Devices_Other varchar(100),
Reassessment_Timed_Up_Go_Score varchar(40),
Reassessment_Interpretation_Risk_Types varchar(40),
Reassessment_Other_Interpretations varchar(255),
Reassessment_Interpretation_NA varchar(10),
Reassessment_Problems_Achieving_Goals longtext,
Reassessment_MS_ENDURANCE_Initial varchar(40),
Reassessment_MS_ENDURANCE_Current varchar(40),
Reassessment_MS_SAFETY_AWARENESS_Initial varchar(40),
Reassessment_MS_SAFETY_AWARENESS_Current varchar(40),
Reassessment_MS_SITTING_BALANCE_Initial_S varchar(40),
Reassessment_MS_SITTING_BALANCE_Initial_D varchar(40),
Reassessment_MS_SITTING_BALANCE_Current_S varchar(40),
Reassessment_MS_SITTING_BALANCE_Current_D varchar(40),
Reassessment_MS_STANDING_BALANCE_Initial_S varchar(40),
Reassessment_MS_STANDING_BALANCE_Initial_D varchar(40),
Reassessment_MS_STANDING_BALANCE_Current_S varchar(40),
Reassessment_MS_STANDING_BALANCE_Current_D varchar(40),
Reassessment_Miscellaneous_NA varchar(10),
Reassessment_Problems_Achieving_Goals_With varchar(50),
Reassessment_Problems_Achieving_Goals_With_Notes longtext,
Reassessment_MS_ROM_All_Muscle_WFL varchar(100),
Reassessment_MS_ROM_ALL_ROM_WFL varchar(100),
Reassessment_MS_ROM_Following_Problem_areas varchar(100),
Reassessment_MS_ROM_Following_Problem_areas_Notes varchar(100),
Reassessment_MS_ROM_Problemarea_text varchar(100),
Reassessment_MS_ROM_STRENGTH_Right varchar(40),
Reassessment_MS_ROM_STRENGTH_Left varchar(40),	
Reassessment_MS_ROM_ROM varchar(40),
Reassessment_MS_ROM_ROM_Type varchar(40),
Reassessment_MS_ROM_Tonicity varchar(40),
Reassessment_MS_ROM_Further_description longtext,
Reassessment_MS_ROM_Problemarea_text1 varchar(100),
Reassessment_MS_ROM_STRENGTH_Right1 varchar(40),
Reassessment_MS_ROM_STRENGTH_Left1 varchar(40),
Reassessment_MS_ROM_ROM1 varchar(40),
Reassessment_MS_ROM_ROM_Type1 varchar(40),
Reassessment_MS_ROM_Tonicity1 varchar(40),
Reassessment_MS_ROM_Further_description1 longtext,
Reassessment_MS_ROM_Problemarea_text2 varchar(100),
Reassessment_MS_ROM_STRENGTH_Right2 varchar(40),
Reassessment_MS_ROM_STRENGTH_Left2 varchar(40),
Reassessment_MS_ROM_ROM2 varchar(40),
Reassessment_MS_ROM_ROM_Type2 varchar(40),
Reassessment_MS_ROM_Tonicity2 varchar(40),
Reassessment_MS_ROM_Problemarea_text3 varchar(100),
Reassessment_MS_ROM_STRENGTH_Right3 varchar(40),
Reassessment_MS_ROM_STRENGTH_Left3 varchar(40),
Reassessment_MS_ROM_ROM3 varchar(40),
Reassessment_MS_ROM_ROM_Type3 varchar(40),
Reassessment_MS_ROM_Tonicity3 varchar(40),
Reassessment_MS_ROM_Problemarea_text4 varchar(100),
Reassessment_MS_ROM_STRENGTH_Right4 varchar(40),
Reassessment_MS_ROM_STRENGTH_Left4 varchar(40),
Reassessment_MS_ROM_ROM4 varchar(40),
Reassessment_MS_ROM_ROM_Type4 varchar(40),
Reassessment_MS_ROM_Tonicity4 varchar(40),
Reassessment_MS_ROM_Problemarea_text5 varchar(100),
Reassessment_MS_ROM_STRENGTH_Right5 varchar(40),
Reassessment_MS_ROM_STRENGTH_Left5 varchar(40),
Reassessment_MS_ROM_ROM5 varchar(40),
Reassessment_MS_ROM_ROM_Type5 varchar(40),
Reassessment_MS_ROM_Tonicity5 varchar(40),
Reassessment_MS_ROM_NA varchar(10),
Reassessment_MS_ROM_Problems_Achieving_Goals_Type varchar(40),
Reassessment_MS_ROM_Problems_Achieving_Goals_Note longtext,
Reassessment_Environmental_Barriers varchar(255),
Reassessment_Environmental_Issues_Notes longtext,
Reassessment_RO_Patient_Prior_Level_Function varchar(10),
Reassessment_RO_Patient_Long_Term_Goals varchar(10),
Reassessment_Skilled_PT_Reasonable_And_Necessary_To varchar(100),
Reassessment_Skilled_PT_Other longtext,
Reassessment_Goals_Changed_Adapted_For_Mobility varchar(255),
Reassessment_Goals_Changed_Adapted_For_Mobility1 varchar(255),
Reassessment_Goals_Changed_Adapted_For_Other longtext,
Reassessment_Goals_Changed_Adapted_For_Other1 longtext,
Reassessment_PT_communicated_and_agreed_upon_by varchar(50),
Reassessment_PT_communicated_and_agreed_upon_by_other longtext,
Reassessment_AS_Home_Exercise varchar(40),
Reassessment_AS_Falls_Management_Prevention varchar(40),
Reassessment_AS_Recommendations_for_SafetyIssues varchar(40),
Reassessment_AS_Recommendations_for_SafetyIssues_Notes longtext,
Reassessment_AS_Treatment varchar(40),
Reassessment_AS_Treatment_for longtext,
Reassessment_Other_Services_Provided longtext,
Reassessment_Therapist_Who_Provided_Reassessment varchar(255),
Reassessment_Time_In varchar(100),
Reassessment_Time_Out varchar(100),
Reassessment_RO_Long_Term_Goal_Not_Reached varchar(255),
Reassessment_RO_Prior_Level_Function_Not_Reached varchar(255),
Reassessment_PT_communicated_and_agreed_upon_by_Others varchar(100)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory ptreassessment
INSERT INTO `registry` VALUES ('PT Reassessment', 1, 'ptreassessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');
#EndIf

#IfNotRow2D registry directory ptreassessment category PT Forms
UPDATE registry SET category='PT Forms' WHERE directory='ptreassessment';
#EndIf



#IfNotTable forms_pt_visit_discharge_note
CREATE TABLE IF NOT EXISTS `forms_pt_visit_discharge_note` (
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
dischargeplan_Vital_Signs_Pain_Intensity varchar(50),
dischargeplan_Vital_Signs_chronic_condition varchar(50),
dischargeplan_Vital_Signs_Patient_states varchar(30),
dischargeplan_Vital_Signs_Patient_states_other varchar(255),
dischargeplan_treatment_diagnosis_problem varchar(255),
dischargeplan_Mental_Status varchar(100),
dischargeplan_Mental_Status_Other varchar(255),
dischargeplan_specific_training_this_visit longtext,
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
dischargeplan_RfD_other varchar(30),
dischargeplan_ToD_Mobility varchar(30),
dischargeplan_ToD_Mobility_Notes text,
dischargeplan_ToD_ROM varchar(30),
dischargeplan_ToD_ROM_In text,
dischargeplan_ToD_Home_Safety_Techniques varchar(30),
dischargeplan_ToD_Home_Safety_Techniques_In varchar(100),
dischargeplan_ToD_Caregiver_Family_Performance varchar(30),
dischargeplan_ToD_Caregiver_Family_Performance_In varchar(100),
dischargeplan_ToD_Demonstrates varchar(30),
dischargeplan_ToD_Demonstrates_Notes varchar(100),
dischargeplan_ToD_Strength varchar(30),
dischargeplan_ToD_Strength_In varchar(100),
dischargeplan_ToD_Assistive_Device_Usage varchar(30),
dischargeplan_ToD_Assistive_Device_Usage_With varchar(100),
dischargeplan_ToD_Performance_of_Home_Exercises varchar(30),
dischargeplan_ToD_Other varchar(255),
dischargeplan_ToD_Discharge_Status_Patient varchar(255),
dischargeplan_Functional_Ability_Timeof_Discharge varchar(255),
dischargeplan_Comments_Recommendations varchar(255),
dischargeplan_Followup_Recommendations text,
dischargeplan_Goals_identified_on_careplan varchar(40),
dischargeplan_Goals_notmet_explanation text,
dischargeplan_Additional_Comments text,
dischargeplan_Therapist_Signature varchar(255),
dischargeplan_md_printed_name varchar(255),
dischargeplan_md_signature varchar(255),
dischargeplan_md_date DATE
) engine=MyISAM;
#EndIf

#IfNotRow registry directory ptvisit_discharge
INSERT INTO `registry` VALUES ('PT Visit Discharge', 1, 'ptvisit_discharge', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');
#EndIf

#IfNotRow2D registry directory ptvisit_discharge category PT Forms
UPDATE registry SET category='PT Forms' WHERE directory='ptvisit_discharge';
#EndIf



#IfNotTable forms_pt_visitnote
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
#EndIf

#IfNotRow registry directory ptvisit_notes
INSERT INTO `registry` VALUES ('PT Visit Notes', 1, 'ptvisit_notes', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');
#EndIf

#IfNotRow2D registry directory ptvisit_notes category PT Forms
UPDATE registry SET category='PT Forms' WHERE directory='ptvisit_notes';
#EndIf



#IfNotTable forms_st_careplan
CREATE TABLE IF NOT EXISTS `forms_st_careplan` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
mr varchar(100),
stdate date,
careplan_ST_intervention varchar(255),
careplan_Treatment_DX varchar(255),
careplan_SOCDate date,
careplan_ST_Decline_in_Oral_Stage_Skills varchar(10),
careplan_ST_Decline_in_Oral_Stage_Skills_Notes varchar(255),
careplan_ST_Decrease_in_Pharyngeal_Stage varchar(10),
careplan_ST_Decrease_in_Pharyngeal_Stage_Note varchar(255), 
careplan_ST_Decline_in_Verbal_Expression varchar(10),
careplan_ST_Decline_in_Verbal_Expression_Note varchar(255), 
careplan_ST_Decline_in_NonVerbal_Expression varchar(10),
careplan_ST_Decline_in_NonVerbal_Expression_Note varchar(255), 
careplan_ST_Decreased_Comprehension varchar(10),
careplan_ST_Decreased_Comprehension_Note varchar(255),
careplan_ST_intervention_Other varchar(255),
careplan_ST_intervention_Other1 varchar(255),
careplan_Treatment_Plan_Frequency varchar(50),
careplan_Treatment_Plan_EffectiveDate date,
careplan_Evaluation varchar(10),
careplan_Dysphagia_Compensatory_Strategies varchar(10),
careplan_Swallow_Exercise_Program varchar(10),
careplan_Safety_Training_in_Swallow varchar(10),
careplan_Cognitive_Impairment varchar(10),
careplan_Communication_Strategies varchar(10),
careplan_Cognitive_Compensatory varchar(10),
careplan_Patient_Caregiver_Family_Education varchar(10),
careplan_ST_Other varchar(255),
careplan_ST_Other1 varchar(255),
careplan_STO_Improve_OralStage_skills varchar(10),
careplan_STO_Improve_OralStage_skills_In varchar(100),
careplan_STO_Improve_OralStage_skills_To text,
careplan_STO_Time1 varchar(100),
careplan_STO_Time2 varchar(100),
careplan_STO_Improve_Pharyngeal_Stage varchar(10),
careplan_STO_Improve_Pharyngeal_Stage_In varchar(40),
careplan_STO_Improve_Pharyngeal_Stage_To text,
careplan_STO_Improve_Verbal_Expression varchar(10),
careplan_STO_Improve_Verbal_Expression_In varchar(100),
careplan_STO_Improve_Verbal_Expression_To text,
careplan_STO_Improve_Non_Verbal_Expression varchar(10),
careplan_STO_Improve_Non_Verbal_Expression_in varchar(10),
careplan_STO_Improve_Non_Verbal_Expression_to varchar(10),
careplan_STO_Improve_careplan_STO_Improve_In varchar(100),
careplan_STO_Improve_careplan_STO_Improve_To text,
careplan_STO_Improve_Improve_Comprehension varchar(10),
careplan_STO_Improve_Improve_Comprehension_In varchar(100),
careplan_STO_Improve_Improve_Comprehension_To text,
careplan_STO_Improve_Caregiver_Family_Performance varchar(10),
careplan_STO_Improve_Caregiver_Family_Performance_In text,
careplan_STO_Other1 text,
careplan_STO_Other2 text,
careplan_LTO_Return_prior_level_function varchar(10),
careplan_LTO_Return_prior_level_function_In varchar(100),
careplan_LTO_Demonstrate_ability_follow_home_exercise varchar(10),
careplan_LTO_Improve_compensatory_techniques varchar(10),
careplan_LTO_Implement_adaptations varchar(100),
careplan_LTO_Other text,
careplan_LTO_Other_Time varchar(50),
careplan_Rehab_Potential varchar(50),
careplan_DP_When_Goals_Are_Met varchar(40),
careplan_DP_Other text,
careplan_PT_communicated_and_agreed_upon_by varchar(50),
careplan_PT_communicated_and_agreed_upon_Other text,
careplan_Agreeable_to_general_goals varchar(30),
careplan_Highly_motivated_to_improve  varchar(30),
careplan_Supportive_family_caregiver varchar(30),
careplan_Physician_Orders varchar(50),
careplan_May_require_additional_treatment varchar(50),
careplan_May_require_additional_treatment_dueto varchar(255),
careplan_Will_address_above_issues varchar(50),
careplan_Will_address_above_issues_by varchar(255),
careplan_Physician_Orders_Other varchar(255),
careplan_Therapist_Who_Developed_POC varchar(255),
careplan_STO_Improve_Pharyngeal_Stage_Time varchar(100),
careplan_STO_Improve_Verbal_Expression_Time varchar(100),
careplan_LTO_Return_prior_level_function_Time varchar(100),
careplan_STO_Improve_Non_Verbal_Expression_Time varchar(100),
careplan_LTO_Demonstrate_ability_follow_home_exercise_Time varchar(100),
careplan_STO_Improve_Improve_Comprehension_Time varchar(100),
careplan_LTO_Improve_compensatory_techniques_Time varchar(50),
careplan_STO_Improve_Caregiver_Family_Performance_Time varchar(50),
careplan_LTO_Implement_adaptations_Time varchar(50),
careplan_STO_Improve_OralStage_skills_Time varchar(50),
careplan_Additional_Comments text
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory stcareplan
INSERT INTO `registry` VALUES ('ST Care plan', 1, 'stcareplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');
#EndIf

#IfNotRow2D registry directory stcareplan category ST Forms
UPDATE registry SET category='ST Forms' WHERE directory='stcareplan';
#EndIf



#IfNotTable forms_st_Evaluation
CREATE TABLE IF NOT EXISTS `forms_st_Evaluation` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
mr varchar(40),
Evaluation_date date,
Evaluation_Time_In varchar(40),
Evaluation_Time_Out varchar(40),
Evaluation_Pulse varchar(100),
Evaluation_Pulse_State varchar(40),
Evaluation_Temperature varchar(20),
Evaluation_Temperature_type varchar(40),
Evaluation_VS_other varchar(100),
Evaluation_VS_Respirations varchar(100),
Evaluation_VS_BP_Systolic varchar(40),
Evaluation_VS_BP_Diastolic varchar(40),
Evaluation_VS_BP_Body_side varchar(40),
Evaluation_VS_BP_Body_Position varchar(40),
Evaluation_VS_Sat varchar(40),
Evaluation_VS_Pain varchar(100),
Evaluation_VS_Pain_Intensity varchar(40),
Evaluation_VS_Location varchar(100),
Evaluation_VS_Other1 varchar(255),
Evaluation_HR_Needs_assistance varchar(10),
Evaluation_HR_Unable_to_leave_home varchar(10),
Evaluation_HR_Medical_Restrictions varchar(10),
Evaluation_HR_Medical_Restrictions_In varchar(100),
Evaluation_HR_SOB_upon_exertion varchar(10),
Evaluation_HR_Pain_with_Travel varchar(10),
Evaluation_HR_Requires_assistance varchar(10),
Evaluation_HR_Arrhythmia varchar(10),
Evaluation_HR_Bed_Bound varchar(10),
Evaluation_HR_Residual_Weakness varchar(10),
Evaluation_HR_Confusion varchar(10),
Evaluation_HR_Multiple_Stairs_Home varchar(10),
Evaluation_HR_Other varchar(255),
Evaluation_Reason_for_intervention varchar(255),
Evaluation_TREATMENT_DX_Problem varchar(255),
Evaluation_PERTINENT_MEDICAL_HISTORY text,
Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS varchar(100),
Evaluation_MFP_Swallow_status varchar(40),
Evaluation_MFP_Other varchar(100),
Evaluation_MFP_Handedness varchar(30),
Evaluation_MFP_Limitations varchar(30),
Evaluation_MFP_Current_Weight_Loss varchar(30),
Evaluation_MFP_Weight_Loss_Reason text,
Evaluation_Prior_Level_Of_Function text,
Evaluation_Family_Caregiver_Support varchar(30),
Evaluation_Family_Caregiver_Support_Who varchar(50),
Evaluation_FC_Visits_Community_Weekly varchar(40),
Evaluation_FC_Additional_Comments varchar(255),
Evaluation_Auditory_Comp varchar(100),
Evaluation_Reading_Comp varchar(100),
Evaluation_Verbal_Expression varchar(100),
Evaluation_Written_Expression varchar(100),
Evaluation_Gestural_Expression varchar(100),
Evaluation_Speech_Intelligibility varchar(100),
Evaluation_Diet_Level varchar(100),
Evaluation_Mastication varchar(100),
Evaluation_Lingual_Transfer varchar(100),
Evaluation_Pocketing varchar(100),
Evaluation_AP_Propulsion varchar(100),
Evaluation_Oral_Transit varchar(100),
Evaluation_Swallow_Timing varchar(100),
Evaluation_Mental_Status varchar(30),
Evaluation_Mental_Status_Oriented_to varchar(30),
Evaluation_MS_Additional_Comments text,
Evaluation_ST_Evaluation_Only varchar(30),
Evaluation_Need_Physician_Orders varchar(30),
Evaluation_Received_Physician_Orders varchar(30),
Evaluation_Approximate_Next_Visit_Date date,
Evaluation_ST_Communicated_And_Agreed_by varchar(100),
Evaluation_ST_Communicated_And_Agreed_By_Other text,
Evaluation_ADDITIONAL_SERVICES_Speech_Excersice  varchar(100),
Evaluation_ADDITIONAL_SERVICES_Swallow_technique varchar(100),
Evaluation_ADDITIONAL_SERVICES_Diet_Modifications varchar(100),
Evaluation_ADDITIONAL_SERVICES_Treatment varchar(100),
Evaluation_ASP_Treatment_For text,
Evaluation_Skilled_ST_Necessary_To varchar(100),
Evaluation_Skilled_ST_Other text,
Evaluation_Therapist_Who_Developed_POC varchar(255)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory stevaluation
INSERT INTO `registry` VALUES ('ST Evaluation', 1, 'stevaluation', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');
#EndIf

#IfNotRow2D registry directory stevaluation category ST Forms
UPDATE registry SET category='ST Forms' WHERE directory='stevaluation';
#EndIf



#IfNotTable forms_st_Reassessment
CREATE TABLE IF NOT EXISTS `forms_st_Reassessment` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
Reassessment_visit_type varchar(50),
mr varchar(40),
Reassessment_date date,
Reassessment_Time_In varchar(40),
Reassessment_Time_Out varchar(40),
Reassessment_Pulse varchar(100),
Reassessment_Pulse_State varchar(40),
Reassessment_Temperature varchar(20),
Reassessment_Temperature_type varchar(40),
Reassessment_VS_other varchar(100),
Reassessment_VS_Respirations varchar(100),
Reassessment_VS_BP_Systolic varchar(40),
Reassessment_VS_BP_Diastolic varchar(40),
Reassessment_VS_BP_side varchar(40),
Reassessment_VS_BP_Body_Position varchar(40),
Reassessment_VS_Sat varchar(40),
Reassessment_VS_Pain varchar(100),
Reassessment_VS_Pain_Intensity varchar(40),
Reassessment_VS_Pain_Intensity_type varchar(40),
Reassessment_HR_Needs_assistance varchar(10),
Reassessment_HR_Unable_to_leave_home varchar(10),
Reassessment_HR_Medical_Restrictions varchar(10),
Reassessment_HR_Medical_Restrictions_In varchar(100),
Reassessment_HR_SOB_upon_exertion varchar(10),
Reassessment_HR_Pain_with_Travel varchar(10),
Reassessment_HR_Requires_assistance varchar(10),
Reassessment_HR_Arrhythmia varchar(10),
Reassessment_HR_Bed_Bound varchar(10),
Reassessment_HR_Residual_Weakness varchar(10),
Reassessment_HR_Confusion varchar(10),
Reassessment_HR_Other text,
Reassessment_SDL_Oral_Stage_Initial_Status varchar(100),
Reassessment_SDL_Oral_Stage_Current_Status varchar(100),
Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills varchar(100),
Reassessment_SDL_Pharyngeal_Stage_Initial_Status varchar(100),
Reassessment_SDL_Pharyngeal_Stage_Current_Status varchar(100),
Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills varchar(100),
Reassessment_SDL_Space1_Initial_Status varchar(100),
Reassessment_SDL_Space1_Current_Status varchar(100),
Reassessment_SDL_Space1_Describe_Mobility_Skills varchar(100),
Reassessment_SDL_Verbal_Expression_Initial_Status varchar(100),
Reassessment_SDL_Verbal_Expression_Current_Status varchar(100),
Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills varchar(100),
Reassessment_SDL_NonVerbal_Expression_Initial_Status varchar(100),
Reassessment_SDL_NonVerbal_Expression_Current_Status varchar(100),
Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills varchar(100),
Reassessment_SDL_Auditory_Comprehension_Initial_Status varchar(100),
Reassessment_SDL_Auditory_Comprehension_Current_Status varchar(100),
Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills varchar(100),
Reassessment_SDL_Speech_Intelligibility_Initial_Status varchar(100),
Reassessment_SDL_Speech_Intelligibility_Current_Status varchar(100),
Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills varchar(100),
Reassessment_SDL_Space2_Initial_Status varchar(100),
Reassessment_SDL_Space2_Current_Status varchar(100),
Reassessment_SDL_Space2_Describe_Mobility_Skills varchar(100),
Reassessment_Dysphagia_Review_NA varchar(40),
Reassessment_Speech_Language_Dysphagia_Issues text,
Reassessment_Skills_SAFETY_AWARENESS varchar(40),
Reassessment_Skills_ATTENTION_SPAN varchar(40),
Reassessment_Skills_SHORTTERM_MEMORY varchar(40),
Reassessment_Skills_LONGTERM_MEMORY varchar(40),
Reassessment_COMPENSATORY_SKILLS_NA varchar(40),
Reassessment_CS_Problems_Achieving_Goals_With text,
Reassessment_RO_Patient_Prior_Level_Function varchar(10),
Reassessment_RO_Patient_Long_Term_Goals varchar(10),
Reassessment_Skilled_ST_Reasonable_And_Necessary_To varchar(100),
Reassessment_Skilled_ST_Compensatory_Strategies_Note text,
Reassessment_Skilled_ST_Learning_New_Skills text,
Reassessment_Skilled_ST_Other longtext,
Reassessment_Goals_Changed_Adapted_For_Dysphagia text,
Reassessment_Goals_Changed_Adapted_For_Communication text,
Reassessment_Goals_Changed_Adapted_For_Cognition text,
Reassessment_Goals_Changed_Adapted_For_Other text,
Reassessment_ST_communicated_and_agreed_upon_by varchar(50),
Reassessment_ST_communicated_and_agreed_upon_by_other longtext,
Reassessment_AS_Compensatory_Swallow_Program varchar(40),
Reassessment_AS_Recommendations_for_Communication varchar(40),
Reassessment_AS_Recommendations_for_Cognitive varchar(40),
Reassessment_AS_Treatment varchar(40),
Reassessment_AS_Treatment_for text,
Reassessment_Other_Services_Provided text,
Reassessment_ADDITIONAL_COMMENTS longtext,
Reassessment_Prior_Level_Function_Not_Reached text,
Reassessment_Long_Term_Goals_Not_Reached text,
Reassessment_Therapist_Who_Provided_Reassessment varchar(255)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory streassessment
INSERT INTO `registry` VALUES ('ST Reassessment', 1, 'streassessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');
#EndIf

#IfNotRow2D registry directory streassessment category ST Forms
UPDATE registry SET category='ST Forms' WHERE directory='streassessment';
#EndIf



#IfNotTable forms_st_visit_discharge_note
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
dischargeplan_Pain varchar(50),
dischargeplan_Vital_Signs_Pain varchar(50),
dischargeplan_Vital_Signs_Pain_Intensity varchar(50),
dischargeplan_Vital_Signs_Location varchar(100),
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
dischargeplan_at_time_of_discharge varchar(255),
dischargeplan_Comments_Recommendations varchar(255),
dischargeplan_Followup_Recommendations text,
dischargeplan_Goals_identified_on_careplan varchar(40),
dischargeplan_Goals_notmet_explanation text,
dischargeplan_Additional_Comments text,
dischargeplan_Therapist_Signature varchar(255),
dischargeplan_md_printed_name varchar(255),
dischargeplan_md_signature varchar(255),
dischargeplan_md_signature_date date
) engine=MyISAM;
#EndIf

#IfNotRow registry directory stvisit_discharge
INSERT INTO `registry` VALUES ('ST Visit Discharge', 1, 'stvisit_discharge', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');
#EndIf

#IfNotRow2D registry directory stvisit_discharge category ST Forms
UPDATE registry SET category='ST Forms' WHERE directory='stvisit_discharge';
#EndIf



#IfNotTable forms_st_visitnote
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
#EndIf

#IfNotRow registry directory stvisit_notes
INSERT INTO `registry` VALUES ('ST Visit Notes', 1, 'stvisit_notes', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');
#EndIf

#IfNotRow2D registry directory stvisit_notes category ST Forms
UPDATE registry SET category='ST Forms' WHERE directory='stvisit_notes';
#EndIf



#IfNotTable forms_oasis_adult_assessment
CREATE TABLE IF NOT EXISTS `forms_oasis_adult_assessment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `authorized` tinyint(4) DEFAULT NULL,
  `activity` tinyint(4) DEFAULT NULL,
  detail varchar(100),
  process varchar(100),
  data varchar(100),
  label varchar(100),
  oasis_patient varchar(50),
  oasis_caregiver varchar(50),
  oasis_visit_date datetime,
  oasis_Time_In varchar(40),
  oasis_Time_Out varchar(40),
  oasis_certification_period_from date,
  oasis_certification_period_to date,
  oasisAdultAssess_Heath_Insurance_Claim varchar(50),
  oasis_physician_last_contacted date,
  oasis_physician_last_visited date,
  oasis_primary_reason_home_health varchar(200),
  oasis_treat_patient_illness varchar(50),
  oasis_treat_patient_illness_other varchar(20),
  oasis_treat_patient_illness_other_text mediumtext,
  oasis_patient_history_previous_outcomes text,
  oasis_patient_history_previous_outcomes_site varchar(200),
  oasis_patient_history_previous_outcomes_other varchar(200),
  oasis_prior_hospitalizations varchar(20),
  oasis_prior_hospitalizations_times varchar(20),
  oasis_prior_hospitalizations_Reason1 varchar(200),
  oasis_prior_hospitalizations_date1 date,
  oasis_prior_hospitalizations_Reason2 varchar(200),
  oasis_prior_hospitalizations_date2 date,
  oasis_immunizations varchar(30),
  oasis_immunizations_needs text,
  oasis_immunizations_needs_other varchar(200),
  oasis_allergies text,
  oasis_allergies_other varchar(200),
  oasis_prognosis varchar(100),
  oasis_advance_directives text,
  oasis_patient_family_informed varchar(20),
  oasis_patient_family_informed_explain varchar(200),
  oasis_safety_measures mediumtext,
  oasis_safety_measures_other varchar(200),
  oasis_sanitation_hazards mediumtext,
  oasis_sanitation_hazards_other varchar(200),
  oasis_safety_fire varchar(10),
  oasis_safety_smoke varchar(10),
  oasis_safety_tested varchar(10),
  oasis_safety_one_exit varchar(10),
  oasis_safety_plan_exit varchar(10),
  oasis_safety_plan_power varchar(10),
  oasis_safety_signs_posted varchar(10),
  oasis_safety_handles_smoking varchar(10),
  oasis_safety_oxygen_backup varchar(255),
  oasis_safety_hazards mediumtext,
  oasis_safety_hazards_other varchar(255),
  oasis_patient_diagnosis_1a varchar(10),
oasis_patient_diagnosis_2a varchar(10),
oasis_patient_diagnosis_2a_sub varchar(10),
oasis_patient_diagnosis_3a varchar(10),
oasis_patient_diagnosis_4a varchar(10),
oasis_patient_diagnosis_1b varchar(10),
oasis_patient_diagnosis_2b varchar(10),
oasis_patient_diagnosis_2b_sub varchar(10),
oasis_patient_diagnosis_3b varchar(10),
oasis_patient_diagnosis_4b varchar(10),
oasis_patient_diagnosis_1c varchar(10),
oasis_patient_diagnosis_2c varchar(10),
oasis_patient_diagnosis_2c_sub varchar(10),
oasis_patient_diagnosis_3c varchar(10),
oasis_patient_diagnosis_4c varchar(10),
oasis_patient_diagnosis_1d varchar(10),
oasis_patient_diagnosis_2d varchar(10),
oasis_patient_diagnosis_2d_sub varchar(10),
oasis_patient_diagnosis_3d varchar(10),
oasis_patient_diagnosis_4d varchar(10),
oasis_patient_diagnosis_1e varchar(10),
oasis_patient_diagnosis_2e varchar(10),
oasis_patient_diagnosis_2e_sub varchar(10),
oasis_patient_diagnosis_3e varchar(10),
oasis_patient_diagnosis_4e varchar(10),
oasis_patient_diagnosis_1f varchar(10),
oasis_patient_diagnosis_2f varchar(10),
oasis_patient_diagnosis_2f_sub varchar(10),
oasis_patient_diagnosis_3f varchar(10),
oasis_patient_diagnosis_4f varchar(10),
oasis_patient_diagnosis_1g varchar(10),
oasis_patient_diagnosis_2g varchar(10),
oasis_patient_diagnosis_2g_sub varchar(10),
oasis_patient_diagnosis_3g varchar(10),
oasis_patient_diagnosis_4g varchar(10),
oasis_patient_diagnosis_1h varchar(10),
oasis_patient_diagnosis_2h varchar(10),
oasis_patient_diagnosis_2h_sub varchar(10),
oasis_patient_diagnosis_3h varchar(10),
oasis_patient_diagnosis_4h varchar(10),
oasis_patient_diagnosis_1i varchar(10),
oasis_patient_diagnosis_2i varchar(10),
oasis_patient_diagnosis_2i_sub varchar(10),
oasis_patient_diagnosis_3i varchar(10),
oasis_patient_diagnosis_4i varchar(10),
oasis_patient_diagnosis_1j varchar(10),
oasis_patient_diagnosis_2j varchar(10),
oasis_patient_diagnosis_2j_sub varchar(10),
oasis_patient_diagnosis_3j varchar(10),
oasis_patient_diagnosis_4j varchar(10),
oasis_patient_diagnosis_1k varchar(10),
oasis_patient_diagnosis_2k varchar(10),
oasis_patient_diagnosis_2k_sub varchar(10),
oasis_patient_diagnosis_3k varchar(10),
oasis_patient_diagnosis_4k varchar(10),
oasis_patient_diagnosis_1l varchar(10),
oasis_patient_diagnosis_2l varchar(10),
oasis_patient_diagnosis_2l_sub varchar(10),
oasis_patient_diagnosis_3l varchar(10),
oasis_patient_diagnosis_4l varchar(10),
oasis_patient_diagnosis_1m varchar(10),
oasis_patient_diagnosis_2m varchar(10),
oasis_patient_diagnosis_2m_sub varchar(10),
oasis_patient_diagnosis_3m varchar(10),
oasis_patient_diagnosis_4m varchar(10),
  oasis_patient_history_caregiver varchar(100),
  oasis_caregiver_relationship varchar(100),
  oasis_caregiver_phonenumber varchar(100),
  oasis_language_spoken varchar(255),
  oasis_language_spoken_other varchar(255),
  oasis_patient_history_commnets text,
  oasis_able_to_care varchar(20),
  oasis_able_to_care_reason varchar(200),
  oasis_functional_limitations mediumtext,
  oasis_functional_limitations_other varchar(200),
  oasis_musculoskeletal mediumtext,
  oasis_musculoskeletal_fracture_location varchar(100),
  oasis_musculoskeletal_swollen varchar(200),
  oasis_musculoskeletal_contractures_joint varchar(200),
  oasis_musculoskeletal_Amputation varchar(200),
  oasis_musculoskeletal_other varchar(200),
  oasis_vision mediumtext,
  oasis_vision_cataract_surgery varchar(200),
  oasis_vision_date date,
  oasis_vision_other varchar(200),
  oasis_nose text,
  oasis_nose_other varchar(200),
  oasis_ear mediumtext,
  oasis_ear_other varchar(200),
  oasis_mouth text,
  oasis_mouth_other varchar(200),
  oasis_throat text,
  oasis_throat_other varchar(200),
  oasis_vital_lying_right varchar(50),
  oasis_vital_lying_left varchar(50),
  oasis_vital_sitting_right varchar(50),
  oasis_vital_sitting_left varchar(50),
  oasis_vital_standing_right varchar(50),
  oasis_vital_standing_left varchar(50),
  oasis_vital_temp varchar(30),
  oasis_vital_pulse varchar(200),
  oasis_vital_resp_rate varchar(50),
  oasis_height varchar(20),
  oasis_height_check varchar(20),
  oasis_weight varchar(20),
  oasis_weight_check varchar(20),
  oasis_weight_changes varchar(15),
  oasis_weight_changes_yes varchar(20),
  oasis_weight_gain varchar(20),
  oasis_weight_loss varchar(20),
  oasis_weight_changes_yes_lbin varchar(20),
  oasis_pain_scale varchar(30),
  oasis_pain_location_cause varchar(255),
  oasis_pain_description varchar(30),
  oasis_pain_frequency varchar(30),
  oasis_pain_aggravating_factors varchar(30),
  oasis_pain_aggravating_factors_other varchar(255),
  oasis_pain_relieving_factors mediumtext,
  oasis_pain_relieving_factors_other varchar(200),
  oasis_pain_activities_limited text,
  oasis_pain_experiencing varchar(20),
  oasis_pain_unable_communicate varchar(30),
  oasis_pain_non_verbals text,
  oasis_pain_non_verbals_other varchar(200),
  oasis_pain_non_verbals_implications varchar(200),
  oasis_pain_breakthrough_medication varchar(60),
  oasis_pain_breakthrough_medication_other varchar(200),
  oasis_pain_breakthrough_implication varchar(20),
  oasis_go_test_trail1 float(15,2),
  oasis_go_test_trail2 float(15,2),
  oasis_go_test_avg float(15,2),
  oasis_integumentary_status_conditions text,
  oasis_integumentary_status_conditions_other varchar(200),
  oasis_braden_scale_sensory INT(10) DEFAULT '0',
  oasis_braden_scale_moisture INT(10) DEFAULT '0',
  oasis_braden_scale_activity INT(10) DEFAULT '0',
  oasis_braden_scale_mobility INT(10) DEFAULT '0',
  oasis_braden_scale_nutrition INT(10) DEFAULT '0',
  oasis_braden_scale_friction INT(10) DEFAULT '0',
  oasis_braden_scale_total INT(10) DEFAULT '0',
  oasis_integumentary_status_problem varchar(30),
  oasis_wound_care_done varchar(10),
  oasis_wound_location varchar(200),
  oasis_wound text,
  oasis_wound_soiled_dressing_by varchar(50),
  oasis_wound_soiled_technique varchar(10),
  oasis_wound_cleaned varchar(200),
  oasis_wound_irrigated varchar(200),
  oasis_wound_packed varchar(200),
  oasis_wound_dressing_apply varchar(200),
  oasis_wound_incision varchar(200),
  oasis_wound_comment text,
  oasis_satisfactory_return_demo varchar(10),
  oasis_wound_education varchar(10),
  oasis_wound_education_comment text,
  oasis_wound_lesion_location text,
  oasis_wound_lesion_type text,
  oasis_wound_lesion_status text,
  oasis_wound_lesion_size_length varchar(30),
  oasis_wound_lesion_size_width varchar(30),
  oasis_wound_lesion_size_depth varchar(30),
  oasis_wound_lesion_stage text,
  oasis_wound_lesion_tunneling text,
  oasis_wound_lesion_odor text,
  oasis_wound_lesion_skin text,
  oasis_wound_lesion_edema text,
  oasis_wound_lesion_stoma text,
  oasis_wound_lesion_appearance text,
  oasis_wound_lesion_drainage text,
  oasis_wound_lesion_color text,
  oasis_wound_lesion_consistency text,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory oasis_adult_assessment
INSERT INTO `registry` VALUES ('ADULT ASSESSMENT', 1, 'oasis_adult_assessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');
#EndIf

#IfNotRow2D registry directory oasis_adult_assessment category Skilled Nursing
UPDATE registry SET category='Skilled Nursing' WHERE directory='oasis_adult_assessment';
#EndIf



#IfNotTable forms_clinical_summary
CREATE TABLE IF NOT EXISTS `forms_clinical_summary` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
clinical_summary_notes text,
clinical_summary_patient_name varchar(225) DEFAULT NULL,
clinical_summary_chart varchar(225) DEFAULT NULL,
clinical_summary_episode varchar(225) DEFAULT NULL,
clinical_summary_caregiver_name varchar(225) DEFAULT NULL,
clinical_summary_visit_date date default NULL,
clinical_summary_case_manager varchar(225) DEFAULT NULL,
clinical_summary_age varchar(20) DEFAULT NULL,
clinical_summary_gender varchar(50) DEFAULT NULL,
clinical_summary_hospitalization varchar(225) DEFAULT NULL,
clinical_summary_admission_date date default NULL,
clinical_summary_hospitalization_reason text,
clinical_summary_reffered_reason text,
clinical_summary_homebound varchar(225) DEFAULT NULL,
clinical_summary_homebound_due_to text,
clinical_summary_patient_current_condition mediumtext,
clinical_summary_teaching_training mediumtext,
clinical_summary_observation_assessment mediumtext,
clinical_summary_treatment_of mediumtext,
clinical_summary_case_management mediumtext,
clinical_summary_willing_caregiver varchar(20) DEFAULT NULL,
clinical_summary_caregiver_sign varchar(225) DEFAULT NULL
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory clinical_summary
INSERT INTO `registry` VALUES ('Clinical Summary', 1, 'clinical_summary', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');
#EndIf

#IfNotRow2D registry directory clinical_summary category Skilled Nursing
UPDATE registry SET category='Skilled Nursing' WHERE directory='clinical_summary';
#EndIf



#IfNotTable forms_discharge_summary
CREATE TABLE IF NOT EXISTS `forms_discharge_summary` (
id bigint(20) NOT NULL auto_increment primary key,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
patient_name varchar(100),
patient_mr varchar(100),
patient_discharge_date DATE,
discharge_summary_discontinue_services text,
discharge_summary_discontinue_services_other varchar(255),
discharge_summary_mental_status varchar(100),
discharge_summary_mental_status_other varchar(255),
discharge_summary_provided_interventions text,
discharge_summary_provided_interventions_other varchar(255),
discharge_summary_discharge_reason mediumtext,
discharge_summary_discharge_reason_other varchar(255),
discharge_summary_functional_ability varchar(150),
discharge_summary_comments_recommendations text,
discharge_summary_service_recommended varchar(100),
discharge_summary_goals_identified varchar(50),
discharge_summary_goals_identified_explanation mediumtext,
discharge_summary_additional_comments mediumtext,
discharge_summary_md_name varchar(100),
discharge_summary_md_signature varchar(100),
discharge_summary_md_signature_date date
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory discharge_summary
INSERT INTO `registry` VALUES ('General Discharge Summary', 1, 'discharge_summary', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');
#EndIf

#IfNotRow2D registry directory discharge_summary category Skilled Nursing
UPDATE registry SET category='Skilled Nursing' WHERE directory='discharge_summary';
#EndIf



#IfNotTable forms_home_health_aide
CREATE TABLE IF NOT EXISTS `forms_home_health_aide` (
id bigint(20) NOT NULL auto_increment primary key,
pid bigint(20) default NULL,
date datetime default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,

home_health_patient_name varchar(100),
home_health_patient_address varchar(100),
home_health_patient_phone varchar(100),
home_health_care_manager varchar(100),
home_health_aide_visit_frequency varchar(100),
home_health_aide_visit_duration varchar(100),
home_health_aide_visit_effective_date DATE,
patient_problems varchar(100),
home_health_goals_for_care varchar(100),
home_health_goals_for_care_other varchar(100),
home_health_medical_issues varchar(500),
home_health_medical_issues_diet varchar(100),
home_health_medical_issues_allergies varchar(100),
home_health_medical_issues_other varchar(100),
home_health_living_situation varchar(100),
home_health_living_situation_other varchar(100),
home_health_type_of_housing varchar(100),
home_health_type_of_housing_other varchar(100),
home_health_condition_of_housing varchar(100),
home_health_problem_safety_issues varchar(100),
mental_status varchar(100),
mental_status_oriented_to varchar(100),
mental_status_disoriented varchar(100),
impaired_mental_status_requires_resources varchar(100),
impaired_mental_status_requires_resources_other varchar(100),
patient_adl_status varchar(100),
patient_adl_status_other varchar(100),
ambulatory_transfer_status varchar(100),
ambulatory_transfer_status_other varchar(100),
communication_status varchar(100),
communication_status_other varchar(100),
miscellaneous_abilities_hearing varchar(100),
miscellaneous_abilities_vision varchar(100),
miscellaneous_abilities_dentures varchar(100),
home_health_patient_need varchar(1000),
home_health_patient_need_bathing varchar(100),
home_health_patient_need_dressing varchar(100),
home_health_patient_need_haircare varchar(100),
home_health_patient_need_hygiene varchar(100),
home_health_patient_need_mobility varchar(100),
home_health_patient_need_positioning varchar(100),
home_health_patient_need_pressure_location varchar(100),
home_health_patient_need_housekeeping varchar(100),
home_health_patient_need_equipment_care varchar(100),
home_health_patient_need_medication_assist varchar(100),
home_health_patient_need_record_sign varchar(100),
home_health_patient_need_wound_care varchar(100),
additional_instructions varchar(100),
review_date_1 DATE,
signature_1 varchar(100),
review_date_2 DATE,
signature_2 varchar(100),
review_date_3 DATE,
signature_3 varchar(100)
) engine=MyISAM;
#EndIf

#IfNotRow registry directory home_health_aide
INSERT INTO `registry` VALUES ('HHA Referral', 1, 'home_health_aide', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');
#EndIf

#IfNotRow2D registry directory home_health_aide category Skilled Nursing
UPDATE registry SET category='Skilled Nursing' WHERE directory='home_health_aide';
#EndIf



#IfNotTable forms_hha_visit
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
#EndIf

#IfNotRow registry directory hha_visit
INSERT INTO `registry` VALUES ('HHA Visit Note', 1, 'hha_visit', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');
#EndIf

#IfNotRow2D registry directory hha_visit category 
UPDATE registry SET category='Skilled Nursing' WHERE directory='hha_visit';
#EndIf



#IfNotTable forms_idt_care
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
#EndIf

#IfNotRow registry directory IDT_care
INSERT INTO `registry` VALUES ('IDT-CARE COORDINATION NOTE', 1, 'IDT_care', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');
#EndIf

#IfNotRow2D registry directory IDT_care category Skilled Nursing
UPDATE registry SET category='Skilled Nursing' WHERE directory='IDT_care';
#EndIf



#IfNotTable forms_nursing_careplan
CREATE TABLE `forms_nursing_careplan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `authorized` tinyint(4) DEFAULT NULL,
  `activity` tinyint(4) DEFAULT NULL,
  `careplan_Assess_Vital_Signs` text,
  `careplan_Assess_Vital_Signs_Specify` text,
  `careplan_SN_Skilled_Assessment_Other` text,
  `careplan_SN_Skilled_Assessment` text,
  `careplan_SN_CARDIO_Assess` text,
  `careplan_SN_CARDIO_Assess_Other` text,
  `careplan_SN_CARDIO_Teach` text,
  `careplan_SN_CARDIO_Teach_Other` text,
  `careplan_SN_CARDIO_Teach_Fluid` varchar(50) DEFAULT NULL,
  careplan_SN_CARDIO_Teach_Complications varchar(200),
  `careplan_SN_CARDIO_PtPcgGoals` text,
  `cardi0_cal1` date DEFAULT NULL,
  `cardi0_cal2` date DEFAULT NULL,
  `cardi0_cal3` date DEFAULT NULL,
  `cardi0_cal4` date DEFAULT NULL,
  `careplan_SN_CARDIO_PtPcgGoals_Other` text,
  `careplan_SN_ENDO_Assess` text,
  `careplan_SN_ENDO_Assess_Hrs` varchar(20) DEFAULT NULL,
  `careplan_SN_ENDO_Admin_Other` varchar(100) DEFAULT NULL,
  `careplan_SN_ENDO_Assess_Suchas` varchar(100) DEFAULT NULL,
  `careplan_SN_ENDO_Assess_Other` text,
  `careplan_SN_ENDO_Teach` text,
  `careplan_SN_ENDO_cal_ada` varchar(50) DEFAULT NULL,
  `careplan_SN_ENDO_Other_Diet` varchar(50) DEFAULT NULL,
  `careplan_SN_ENDO_Perform` text,
  `careplan_SN_ENDO_Perform_Insulin` varchar(30) DEFAULT NULL,
  `careplan_SN_ENDO_Perform_Freq` varchar(30) DEFAULT NULL,
  `careplan_SN_ENDO_Perform_Other` text,
  `careplan_SN_ENDO_PCgGoals` text,
  `careplan_SN_ENDO_PCgGoals_text1` varchar(30) DEFAULT NULL,
  `careplan_SN_ENDO_PCgGoals_Other` text,
  `endo_cal1` date DEFAULT NULL,
  `endo_cal2` date DEFAULT NULL,
  `endo_cal3` date DEFAULT NULL,
  `endo_cal4` date DEFAULT NULL,
  `endo_cal5` date DEFAULT NULL,
  `careplan_SN_GASTRO_Assess` text,
  `careplan_SN_GASTRO_Other` text,
  `careplan_SN_GASTRO_Teach` text,
  `careplan_SN_GASTRO_Suchas` varchar(30) DEFAULT NULL,
  `careplan_SN_GASTRO_Teach_Freq` varchar(30) DEFAULT NULL,
  `careplan_SN_GASTRO_Teach_Other` text,
  `careplan_SN_GASTRO_Perform` text,
  `careplan_SN_GASTRO_Perform_Freq` varchar(30) DEFAULT NULL,
  `careplan_SN_GASTRO_Perform_followup` varchar(30) DEFAULT NULL,
  `careplan_SN_GASTRO_Perform_admin` varchar(30) DEFAULT NULL,
  `careplan_SN_GASTRO_Perform_admin_freq` varchar(30) DEFAULT NULL,
  `careplan_SN_GASTRO_Perform_Other` text,
  `careplan_SN_GASTRO_PcGoals` text,
  `careplan_SN_GASTRO_PcGoals_Other` text,
  `gastro_cal1` date DEFAULT NULL,
  `careplan_SN_GENITO_Assess_Other` text,
  `careplan_SN_GENITO_Assess` text,
  `careplan_SN_GENITO_Teach` text,
  `careplan_SN_GENITO_Teach_Freq` varchar(30) DEFAULT NULL,
  `careplan_SN_GENITO_Teach_Other` text,
  `careplan_SN_GENITO_Perform` text,
  `careplan_SN_GENITO_Perform_size` varchar(20) DEFAULT NULL,
  `careplan_SN_GENITO_Perform_ordered` varchar(20) DEFAULT NULL,
  `careplan_SN_GENITO_Perform_Other` text,
  `careplan_SN_GENITO_PcgGoals` text,
  `genito_cal1` date DEFAULT NULL,
  `genito_cal2` date DEFAULT NULL,
  `genito_cal3` date DEFAULT NULL,
  `genito_cal4` date DEFAULT NULL,
  `careplan_SN_GENITO_PcgGoals_Other` text,
  `careplan_SN_INTEGU_Assess` text,
  `careplan_SN_INTEGU_Assess_Other` text,
  `careplan_SN_INTEGU_Teach` text,
  `careplan_SN_INTEGU_Teach_Other` text,
  `careplan_SN_INTEGU_Perform` varchar(40) DEFAULT NULL,
  `careplan_SN_INTEGU_Perform_location` varchar(30) DEFAULT NULL,
  `careplan_SN_INTEGU_Perform_Freq` varchar(30) DEFAULT NULL,
  `careplan_SN_INTEGU_Perform_Clean` varchar(30) DEFAULT NULL,
  `careplan_SN_INTEGU_Perform_Pack` varchar(30) DEFAULT NULL,
  `careplan_SN_INTEGU_Perform_Apply` varchar(30) DEFAULT NULL,
  `careplan_SN_INTEGU_Perform_Cover` varchar(40) DEFAULT NULL,
  `careplan_SN_INTEGU_Perform_Secure` varchar(50) DEFAULT NULL,
  `careplan_SN_INTEGU_PcgGoals` text,
  `careplan_SN_INTEGU_PcgGoals_areas` varchar(30) DEFAULT NULL,
  `integu_cal1` date DEFAULT NULL,
  `integu_cal2` date DEFAULT NULL,
  `integu_cal3` date DEFAULT NULL,
  `careplan_SN_INTEGU_PcgGoals_Other` text,
  `careplan_SN_MUSCULO_Assess` text,
  `careplan_SN_MUSCULO_Assess_Other` text,
  `careplan_SN_MUSCULO_Teach` text,
  `careplan_SN_MUSCULO_Teach_Other` text,
  `careplan_SN_MUSCULO_Perform_Venipuncture` varchar(50) DEFAULT NULL,
  `careplan_SN_MUSCULO_Perform_staples` varchar(20) DEFAULT NULL,
  `careplan_SN_MUSCULO_Perform_Other` text,
  `careplan_SN_MUSCULO_PcgGoals` text,
  `musculo_cal1` date DEFAULT NULL,
  `musculo_cal2` date DEFAULT NULL,
  `musculo_cal3` date DEFAULT NULL,
  `musculo_cal4` date DEFAULT NULL,
  `careplan_SN_MUSCULO_PcgGoals_Other` text,
  `careplan_SN_MENTAL_Assess` text,
  `careplan_SN_MENTAL_Assess_Other` text,
  `careplan_SN_MENTAL_Teach` text,
  `careplan_SN_MENTAL_Teach_Other` text,
  `careplan_SN_MENTAL_PcgGoals` text,
  `mental_cal1` date DEFAULT NULL,
  `mental_cal2` date DEFAULT NULL,
  `mental_cal3` date DEFAULT NULL,
  `careplan_SN_MENTAL_PcgGoals_Other` text,
  `careplan_SN_NEURO_Assess` text,
  `careplan_SN_NEURO_Assess_minutes` varchar(30) DEFAULT NULL,
  `careplan_SN_NEURO_Assess_Other` text,
  `careplan_SN_NEURO_Teach` text,
  `careplan_SN_NEURO_Teach_Other` text,
  `careplan_SN_NEURO_PcgGoals` text,
  `neuro_cal1` date DEFAULT NULL,
  `neuro_cal2` date DEFAULT NULL,
  `neuro_cal3` date DEFAULT NULL,
  `neuro_cal4` date DEFAULT NULL,
  `neuro_cal5` date DEFAULT NULL,
  `careplan_SN_NEURO_PcgGoals_Other` text,
  `careplan_SN_RESPIR_Assess` text,
  `careplan_SN_RESPIR_Assess_Other` text,
  `careplan_SN_RESPIR_Teach` text,
  `careplan_SN_RESPIR_Teach_Other` text,
  `careplan_SN_RESPIR_Perform` varchar(30) DEFAULT NULL,
  `careplan_SN_RESPIR_Perform_Freq` varchar(30) DEFAULT NULL,
  `careplan_SN_RESPIR_Perform_Other` varchar(100) DEFAULT NULL,
  `careplan_SN_RESPIR_PcgGoals` text,
  `respir_cal1` date DEFAULT NULL,
  `respir_cal2` date DEFAULT NULL,
  `respir_cal3` date DEFAULT NULL,
  `respir_cal4` date DEFAULT NULL,
  `respir_cal5` date DEFAULT NULL,
  `respir_cal6` date DEFAULT NULL,
  `careplan_SN_RESPIR_PcgGoals_Other` text,
  `careplan_SN_GENERAL_Assess` text,
  `careplan_SN_GENERAL_Assess_Other` text,
  `careplan_SN_GENERAL_Teach` text,
  `careplan_SN_GENERAL_Teach_Other` text,
  `careplan_SN_GENERAL_PcgGoals` text,
  `general_cal1` date DEFAULT NULL,
  `general_cal2` date DEFAULT NULL,
  `general_cal3` date DEFAULT NULL,
  `careplan_SN_GENERAL_PcgGoals_Other` text,
  `detail` varchar(100) DEFAULT NULL,
  `label` varchar(100) NOT NULL,
  `process` varchar(100) DEFAULT NULL,
  `data` varchar(100) DEFAULT NULL,
  `wound_value1` text,
  `wound_value2` text,
  `wound_value3` text,
  `wound_value4` text,
  `wound_value5` text,
  `wound_value6` text,
  `wound_value7` text,
  `wound_value8` text,
  `Interventions` text,
  `wound_comments` text,
  `wound_label` text,
  `wound_label2` text,
  `careplan_SN_WC_status` varchar(20) DEFAULT NULL,
  `careplan_SN_provide_wound_care` varchar(30) DEFAULT NULL,
  `careplan_SN_wound_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#EndIf

#IfNotRow registry directory nursing_careplan
INSERT INTO `registry` VALUES ('Nursing Careplan', 1, 'nursing_careplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');
#EndIf

#IfNotRow2D registry directory nursing_careplan category Skilled Nursing
UPDATE registry SET category='Skilled Nursing' WHERE directory='nursing_careplan';
#EndIf



#IfNotTable forms_nursing_visitnote
CREATE TABLE `forms_nursing_visitnote` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `authorized` tinyint(4) DEFAULT NULL,
  `activity` tinyint(4) DEFAULT NULL,
  `visitnote_date` date DEFAULT NULL,
  `visitnote_Time_In` varchar(40) DEFAULT NULL,
  `visitnote_Time_Out` varchar(40) DEFAULT NULL,
  `visitnote_type_of_visit` varchar(50) DEFAULT NULL,
  `Visitnote_Evaluation_date` varchar(50) NOT NULL,
  `visitnote_type_of_visit_other` varchar(50) DEFAULT NULL,
  `visitnote_Pulse` varchar(100) DEFAULT NULL,
  `visitnote_Pulse_State` varchar(40) DEFAULT NULL,
  `visitnote_Temperature` varchar(255) DEFAULT NULL,
  `visitnote_Temperature_type` varchar(40) DEFAULT NULL,
  `visitnote_VS_other` varchar(100) DEFAULT NULL,
  `visitnote_VS_Respirations` varchar(100) DEFAULT NULL,
  `visitnote_VS_BP_Systolic` varchar(40) DEFAULT NULL,
  `visitnote_VS_BP_Diastolic` varchar(40) DEFAULT NULL,
  `visitnote_VS_BP_Body_side` varchar(40) DEFAULT NULL,
  `visitnote_VS_BP_Body_Position` varchar(40) DEFAULT NULL,
  `visitnote_VS_Sat` varchar(40) DEFAULT NULL,
  `visitnote_VS_Pain` varchar(100) DEFAULT NULL,
  `visitnote_VS_Pain_Intensity` varchar(40) DEFAULT NULL,
  `visitnote_VS_condition` varchar(30) DEFAULT NULL,
  `visitnote_VS_Condition_other` varchar(255) DEFAULT NULL,
  `visitnote_VS_Diagnosis` varchar(255) DEFAULT NULL,
  `visitnote_HR_Home_Bound` text,
  `visitnote_HR_Patient_Restriction` varchar(40) DEFAULT NULL,
  `visitnote_HR_others` varchar(40) DEFAULT NULL,
  `visitnote_Cardiovascular` text,
  `visitnote_Cardiovascular_other` varchar(50) DEFAULT NULL,
  `visitnote_endocrine` text,
  `visitnote_endocrine_other` varchar(50) DEFAULT NULL,
  `visitnote_endocrine_blood_sugar` varchar(50) DEFAULT NULL,
  `visitnote_endocrine_Risk_Factors` varchar(255) NOT NULL,
  `visitnote_endocrine_frequency` varchar(50) DEFAULT NULL,
  `visitnote_endocrine_comments` varchar(50) DEFAULT NULL,
  `visitnote_Gastrointestinal` text,
  `visitnote_Gastrointestinal_bm_date` varchar(50) DEFAULT NULL,
  `visitnote_Gastrointestinal_other` varchar(50) DEFAULT NULL,
  `visitnote_Genitourinary` varchar(100) NOT NULL,
  `visitnote_Genitourinary_Incontinence` text,
  `visitnote_Genitourinary_others` varchar(255) NOT NULL,
  `visitnote_Integumentary` text,
  `visitnote_Integumentary_other` varchar(50) DEFAULT NULL,
  `visitnote_Mental_Emotional` text,
  `visitnote_Mental_Emotional_other` varchar(50) DEFAULT NULL,
  `visitnote_Musculoskeletal` text,
  `visitnote_Musculoskeletal_ROM` varchar(50) DEFAULT NULL,
  `visitnote_Musculoskeletal_other` varchar(50) DEFAULT NULL,
  `visitnote_Neurological` text,
  `visitnote_Neurological_other` varchar(50) DEFAULT NULL,
  `visitnote_Respiratory` text,
  `visitnote_Respiratory_liters` varchar(50) DEFAULT NULL,
  `visitnote_Respiratory_other` varchar(50) DEFAULT NULL,
  `visitnote_General_medical` text,
  `visitnote_General_medical_lbs1` varchar(40) DEFAULT NULL,
  `visitnote_General_medical_lbs2` varchar(40) DEFAULT NULL,
  `visitnote_General_medical_other` varchar(40) DEFAULT NULL,
  `visitnote_services_provided` varchar(40) DEFAULT NULL,
  `visitnote_services_provided_other` varchar(40) DEFAULT NULL,
  `visitnote_services_provided_options` text,
  `visitnote_services_provided_options_other` varchar(255) DEFAULT NULL,
  `visitnote_g_codes` varchar(40) DEFAULT NULL,
  `visitnote_clinical_finding` varchar(255) DEFAULT NULL,
  `visitnote_training_visit` varchar(255) DEFAULT NULL,
  `visitnote_response_to_training` varchar(255) DEFAULT NULL,
  `visitnote_response_to_training_other` varchar(255) DEFAULT NULL,
  `visitnote_fall_since_last_visit` varchar(10) DEFAULT NULL,
  `visitnote_changes_in_medication` varchar(10) DEFAULT NULL,
  `visitnote_plot_for_next_visit` varchar(100) DEFAULT NULL,
  `visitnote_plot_for_next_visit_other` varchar(100) DEFAULT NULL,
  `visitnote_supervisor_visit` varchar(100) DEFAULT NULL,
  `visitnote_LPN_LVN_or_HHA_present` varchar(10) DEFAULT NULL,
  `visitnote_Follows_Care_Plan` varchar(10) DEFAULT NULL,
  `visitnote_time_necessary_to_meet_the_patients_needs` varchar(10) DEFAULT NULL,
  `visitnote_Follows_Infection_Control_Procedures` varchar(10) DEFAULT NULL,
  `visitnote_Aware_of_patients_code_status` varchar(10) DEFAULT NULL,
  `visitnote_polite_courteous_and_respectful` varchar(10) DEFAULT NULL,
  `visitnote_clinical_skills_appropriate_to_patient_need` varchar(10) DEFAULT NULL,
  `visitnote_Identifies_patient_issues` varchar(10) DEFAULT NULL,
  `visitnote_Additional_Instruction` varchar(255) DEFAULT NULL,
  `visitnote_Therapist_Who_Developed_POC` varchar(255) DEFAULT NULL,
  `data` text,
  `label` varchar(255) NOT NULL,
  `detail` varchar(50) NOT NULL,
  `process` varchar(255) NOT NULL,
  `wound_value1` text NOT NULL,
  `wound_label` text NOT NULL,
  `wound_value2` text NOT NULL,
  `wound_value3` text NOT NULL,
  `wound_value4` text NOT NULL,
  `wound_value5` text NOT NULL,
  `wound_value6` text NOT NULL,
  `wound_value7` text NOT NULL,
  `wound_value8` text NOT NULL,
  `wound_comments` varchar(255) NOT NULL,
  `wound_Interventions` varchar(255) NOT NULL,
  `visitnote_LPN_LVN_HHA_present` varchar(160) NOT NULL,
  `visitnote_Providing_wound` text NOT NULL,
  `careplan_SN_WC_status` varchar(255) NOT NULL,
  `careplan_SN_provide_wound_care` varchar(255) NOT NULL,
  `careplan_SN_wound_status` varchar(255) NOT NULL,
  `visitnote_RN_Training_and_Education` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#EndIf


#IfMissingColumn forms_oasis_discharge oasis_therapy_integumentary_status_stage2_date
ALTER TABLE forms_oasis_discharge ADD oasis_therapy_integumentary_status_stage2_date DATE;
#EndIf

#IfMissingColumn forms_oasis_discharge Reason_for_Hospitalization
ALTER TABLE forms_oasis_discharge ADD Reason_for_Hospitalization text;
#EndIf

#IfMissingColumn forms_oasis_discharge patient_Admitted_to_a_Nursing_Home
ALTER TABLE forms_oasis_discharge ADD patient_Admitted_to_a_Nursing_Home text;
#EndIf

#IfMissingColumn forms_oasis_transfer oasis_therapy_soc_date
ALTER TABLE forms_oasis_transfer ADD oasis_therapy_soc_date date;
#EndIf

#IfMissingColumn forms_oasis_transfer oasis_speech_and_oral
ALTER TABLE forms_oasis_transfer ADD oasis_speech_and_oral varchar(50);
#EndIf

#IfMissingColumn forms_oasis_transfer oasis_elimination_status_tract_infection
ALTER TABLE forms_oasis_transfer ADD oasis_elimination_status_tract_infection varchar(50);
ALTER TABLE forms_oasis_transfer MODIFY oasistransfer_Visit_Date DATE;
#EndIf


#IfNotRow registry directory nursing_visitnote
INSERT INTO `registry` VALUES ('Nursing Visit Note', 1, 'nursing_visitnote', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');
#EndIf

#IfNotRow2D registry directory nursing_visitnote category Skilled Nursing
UPDATE registry SET category='Skilled Nursing' WHERE directory='nursing_visitnote';
#EndIf

--  Insert Address 2 for Synergy
#IfNotRow2D layout_options field_id street2 group_name 1Patient Info
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'street2', '1Patient Info', 'Address 2', 17, 2, 1, 25, 63, '', 1, 1, '', 'C', 'Street and Place', 0);
UPDATE layout_options SET title='Address 1' WHERE field_id='street';
#EndIf

#IfMissingColumn patient_data street2
ALTER TABLE patient_data ADD street2 varchar(255) NOT NULL default '';
#EndIf

#IfMissingColumn form_encounter caregiver
ALTER TABLE form_encounter ADD caregiver varchar(150);
#EndIf

#IfMissingColumn form_encounter time_in
ALTER TABLE form_encounter ADD time_in varchar(10);
#EndIf

#IfMissingColumn form_encounter time_out
ALTER TABLE form_encounter ADD time_out varchar(10);
#EndIf

#IfMissingColumn form_encounter billing_units
ALTER TABLE form_encounter ADD billing_units varchar(50);
#EndIf

#IfMissingColumn form_encounter billing_insurance
ALTER TABLE form_encounter ADD billing_insurance varchar(10);
#EndIf

#IfMissingColumn form_encounter notes_in
ALTER TABLE form_encounter ADD notes_in varchar(10);
#EndIf

#IfMissingColumn form_encounter verified
ALTER TABLE form_encounter ADD verified varchar(10);
#EndIf

#IfMissingColumn form_encounter type_of_service
ALTER TABLE form_encounter ADD type_of_service varchar(50);
#EndIf

#IfMissingColumn form_encounter modifier_1
ALTER TABLE form_encounter ADD modifier_1 varchar(2);
#EndIf

#IfMissingColumn form_encounter modifier_2
ALTER TABLE form_encounter ADD modifier_2 varchar(2);
#EndIf

#IfMissingColumn form_encounter modifier_3
ALTER TABLE form_encounter ADD modifier_3 varchar(2);
#EndIf

#IfMissingColumn form_encounter modifier_4
ALTER TABLE form_encounter ADD modifier_4 varchar(2);
#EndIf


-- Added for Synergy

-- OASIS-C DISCHARGE ASSESSMENT

#IfMissingColumn forms_oasis_discharge oasis_therapy_certification
ALTER TABLE forms_oasis_discharge ADD oasis_therapy_certification varchar(1);
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_therapy_date_last_contacted_physician
ALTER TABLE forms_oasis_discharge ADD oasis_therapy_date_last_contacted_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_therapy_date_last_seen_by_physician
ALTER TABLE forms_oasis_discharge ADD oasis_therapy_date_last_seen_by_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_mental_status
ALTER TABLE forms_oasis_discharge ADD oasis_mental_status varchar(150);
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_mental_status_other
ALTER TABLE forms_oasis_discharge ADD oasis_mental_status_other varchar(100) DEFAULT NULL;
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_functional_limitations
ALTER TABLE forms_oasis_discharge ADD oasis_functional_limitations varchar(150);
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_functional_limitations_other
ALTER TABLE forms_oasis_discharge ADD oasis_functional_limitations_other varchar(100) DEFAULT NULL;
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_prognosis
ALTER TABLE forms_oasis_discharge ADD oasis_prognosis varchar(10);
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_safety_measures
ALTER TABLE forms_oasis_discharge ADD oasis_safety_measures text;
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_safety_measures_other
ALTER TABLE forms_oasis_discharge ADD oasis_safety_measures_other varchar(150);
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_dme_iv_supplies
ALTER TABLE forms_oasis_discharge ADD oasis_dme_iv_supplies varchar(225);
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_dme_iv_supplies_other
ALTER TABLE forms_oasis_discharge ADD oasis_dme_iv_supplies_other varchar(150);
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_dme_foley_supplies
ALTER TABLE forms_oasis_discharge ADD oasis_dme_foley_supplies varchar(225);
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_dme_foley_supplies_other
ALTER TABLE forms_oasis_discharge ADD oasis_dme_foley_supplies_other varchar(150);
#EndIf




-- OASIS-C NURSE RECERTIFICATION

#IfMissingColumn forms_oasis_c_nurse oasis_c_nurse_certification
ALTER TABLE forms_oasis_c_nurse ADD oasis_c_nurse_certification varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_c_nurse_date_last_contacted_physician
ALTER TABLE forms_oasis_c_nurse ADD oasis_c_nurse_date_last_contacted_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_c_nurse_date_last_seen_by_physician
ALTER TABLE forms_oasis_c_nurse ADD oasis_c_nurse_date_last_seen_by_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2a_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2a_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2b_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2b_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2c_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2c_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2d_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2d_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2e_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2e_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2f_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2f_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2g_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2g_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2h_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2h_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2i_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2i_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2j_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2j_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2k_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2k_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2l_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2l_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_c_nurse oasis_patient_diagnosis_2m_indicator
ALTER TABLE forms_oasis_c_nurse ADD oasis_patient_diagnosis_2m_indicator varchar(1);
#EndIf

-- OASIS-C PT RECERT (V1)

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_certification
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_certification varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_date_last_contacted_physician
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_date_last_contacted_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_date_last_seen_by_physician
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_date_last_seen_by_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2a_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2a_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2b_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2b_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2c_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2c_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2d_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2d_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2e_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2e_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2f_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2f_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2g_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2g_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2h_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2h_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2i_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2i_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2j_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2j_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2k_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2k_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2l_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2l_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification oasis_therapy_patient_diagnosis_2m_indicator
ALTER TABLE forms_oasis_therapy_rectification ADD oasis_therapy_patient_diagnosis_2m_indicator varchar(1);
#EndIf



-- Oasis Nursing SOC

#IfMissingColumn forms_oasis_nursing_soc oasis_patient_certification
ALTER TABLE forms_oasis_nursing_soc ADD oasis_patient_certification varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_patient_date_last_contacted_physician
ALTER TABLE forms_oasis_nursing_soc ADD oasis_patient_date_last_contacted_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_patient_date_last_seen_by_physician
ALTER TABLE forms_oasis_nursing_soc ADD oasis_patient_date_last_seen_by_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2a_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2a_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2b_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2b_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2c_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2c_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2d_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2d_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2e_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2e_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2f_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2f_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2g_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2g_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2h_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2h_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2i_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2i_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2j_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2j_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2k_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2k_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2l_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2l_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc oasis_therapy_patient_diagnosis_2m_indicator
ALTER TABLE forms_oasis_nursing_soc ADD oasis_therapy_patient_diagnosis_2m_indicator varchar(1);
#EndIf


-- OASIS-C PT SOC/ROC


#IfMissingColumn forms_oasis_pt_soc oasis_patient_certification
ALTER TABLE forms_oasis_pt_soc ADD oasis_patient_certification varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_patient_date_last_contacted_physician
ALTER TABLE forms_oasis_pt_soc ADD oasis_patient_date_last_contacted_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_patient_date_last_seen_by_physician
ALTER TABLE forms_oasis_pt_soc ADD oasis_patient_date_last_seen_by_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2a_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2a_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2b_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2b_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2c_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2c_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2d_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2d_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2e_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2e_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2f_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2f_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2g_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2g_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2h_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2h_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2i_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2i_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2j_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2j_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2k_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2k_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2l_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2l_indicator varchar(1);
#EndIf

#IfMissingColumn forms_oasis_pt_soc oasis_therapy_patient_diagnosis_2m_indicator
ALTER TABLE forms_oasis_pt_soc ADD oasis_therapy_patient_diagnosis_2m_indicator varchar(1);
#EndIf



-- OASIS-C TRANSFER


#IfMissingColumn forms_oasis_transfer oasistransfer_certification
ALTER TABLE forms_oasis_transfer ADD oasistransfer_certification varchar(1);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_date_last_contacted_physician
ALTER TABLE forms_oasis_transfer ADD oasistransfer_date_last_contacted_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_date_last_seen_by_physician
ALTER TABLE forms_oasis_transfer ADD oasistransfer_date_last_seen_by_physician DATE;
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_mental_status
ALTER TABLE forms_oasis_transfer ADD oasistransfer_mental_status varchar(150);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_mental_status_other
ALTER TABLE forms_oasis_transfer ADD oasistransfer_mental_status_other varchar(100);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_functional_limitations
ALTER TABLE forms_oasis_transfer ADD oasistransfer_functional_limitations varchar(150);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_functional_limitations_other
ALTER TABLE forms_oasis_transfer ADD oasistransfer_functional_limitations_other varchar(100) DEFAULT NULL;
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_prognosis
ALTER TABLE forms_oasis_transfer ADD oasistransfer_prognosis varchar(10);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_safety_measures
ALTER TABLE forms_oasis_transfer ADD oasistransfer_safety_measures text;
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_safety_measures_other
ALTER TABLE forms_oasis_transfer ADD oasistransfer_safety_measures_other varchar(150);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_dme_iv_supplies
ALTER TABLE forms_oasis_transfer ADD oasistransfer_dme_iv_supplies varchar(225);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_dme_iv_supplies_other
ALTER TABLE forms_oasis_transfer ADD oasistransfer_dme_iv_supplies_other varchar(150);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_dme_foley_supplies
ALTER TABLE forms_oasis_transfer ADD oasistransfer_dme_foley_supplies varchar(225);
#EndIf

#IfMissingColumn forms_oasis_transfer oasistransfer_dme_foley_supplies_other
ALTER TABLE forms_oasis_transfer ADD oasistransfer_dme_foley_supplies_other varchar(150);
#EndIf


#IfNotRow2D layout_options field_id ss uor 2
UPDATE layout_options SET uor=2 WHERE field_id='ss';
#EndIf

#IfNotRow2D layout_options field_id postal_code uor 2
UPDATE layout_options SET uor=2 WHERE field_id='postal_code';
#EndIf

-- Save Synergy ID for Encounter

#IfMissingColumn form_encounter synergy_id
ALTER TABLE form_encounter ADD synergy_id varchar(10);
#EndIf


-- Save Synergy ID for all OASIS Forms

#IfMissingColumn forms_oasis_discharge synergy_id
ALTER TABLE forms_oasis_discharge ADD synergy_id varchar(10);
#EndIf

#IfMissingColumn forms_oasis_c_nurse synergy_id
ALTER TABLE forms_oasis_c_nurse ADD synergy_id varchar(10);
#EndIf

#IfMissingColumn forms_oasis_therapy_rectification synergy_id
ALTER TABLE forms_oasis_therapy_rectification ADD synergy_id varchar(10);
#EndIf

#IfMissingColumn forms_oasis_nursing_soc synergy_id
ALTER TABLE forms_oasis_nursing_soc ADD synergy_id varchar(10);
#EndIf

#IfMissingColumn forms_oasis_pt_soc synergy_id
ALTER TABLE forms_oasis_pt_soc ADD synergy_id varchar(10);
#EndIf

#IfMissingColumn forms_oasis_transfer synergy_id
ALTER TABLE forms_oasis_transfer ADD synergy_id varchar(10);
#EndIf


-- Synergy Username and Password

#IfMissingColumn users synergy_username
ALTER TABLE users ADD synergy_username varchar(150);
#EndIf

#IfMissingColumn users synergy_password
ALTER TABLE users ADD synergy_password varchar(150);
#EndIf


-- Changes made in sequence of fields

#IfNotRow2D layout_options field_id genericname1 seq 34
UPDATE `layout_options` SET `seq`=34 WHERE `form_id`='DEM' AND `field_id`='genericname1';
#EndIf

#IfNotRow2D layout_options field_id genericval1 seq 35
UPDATE `layout_options` SET `seq`=35 WHERE `form_id`='DEM' AND `field_id`='genericval1';
#EndIf

#IfNotRow2D layout_options field_id genericname2 seq 36
UPDATE `layout_options` SET `seq`=36 WHERE `form_id`='DEM' AND `field_id`='genericname2';
#EndIf

#IfNotRow2D layout_options field_id genericval2 seq 37
UPDATE `layout_options` SET `seq`=37 WHERE `form_id`='DEM' AND `field_id`='genericval2';
#EndIf


-- New column for users table and facility table to store Synergy ID

#IfMissingColumn users synergy_id
ALTER TABLE users ADD synergy_id varchar(255) NOT NULL default '';
#EndIf

#IfMissingColumn facility synergy_id
ALTER TABLE facility ADD synergy_id varchar(255) NOT NULL default '';
#EndIf



-- New list_options entry to store the Type of Service

#IfNotRow2D list_options list_id lists option_id typeofservice
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'typeofservice', 'Type of Service', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '1', 'Blood Charges', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '2', 'Medical Care', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '3', 'Surgery', '3', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '4', 'Consultation', '4', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '5', 'Diagnostic X-Ray', '5', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '6', 'Diagnostic Lab', '6', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '7', 'Radiation Therapy', '7', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '8', 'Anesthesia', '8', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '9', 'Surgical Assistance', '9', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '10', 'Other Medical', '10', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '11', 'User DME', '11', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '12', 'Ambulance', '12', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '13', 'Chiropractic Services', '13', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '14', 'DME Purchase', '14', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '15', 'ASC Facility', '15', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '16', 'Psychiatry', '16', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '17', 'Hospice', '17', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '18', 'Interpretation', '18', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '19', 'Rental Supplies in the Home', '19', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '20', 'Alt Method Dialysis Payment', '20', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '21', 'CRD Equipment', '21', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '22', 'Pre-Admission Testing', '22', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '23', 'DME Rental', '23', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '24', 'Pneumonia Vaccine', '24', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '25', 'Second Surgical Opinion', '25', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('typeofservice', '26', 'Third Surgical Opinion', '26', '0', '1', '', '');
#EndIf


-- New Column to insurance_companies table to store the synergy ID

#IfMissingColumn insurance_companies synergy_id
ALTER TABLE insurance_companies ADD synergy_id varchar(255) NOT NULL default '';
#EndIf

-- Changes made for other_physician to display the Physician List

#IfNotRow2D layout_options field_id other_physician data_type 42
UPDATE `layout_options` SET `data_type`=42 WHERE `form_id`='DEM' AND `field_id`='other_physician';
#EndIf

-- Drops the duration, Freq_Duration1, and Freq_Duration2 columns from the table forms_ot_careplan

#IfColumnDoesExist forms_ot_careplan duration
ALTER TABLE `forms_ot_careplan` DROP COLUMN `duration`;
#EndIf

#IfColumnDoesExist forms_ot_careplan Freq_Duration1
ALTER TABLE `forms_ot_careplan` DROP COLUMN `Freq_Duration1`;
#EndIf

#IfColumnDoesExist forms_ot_careplan Freq_Duration2
ALTER TABLE `forms_ot_careplan` DROP COLUMN `Freq_Duration2`;
#EndIf

-- Drops the careplan_Treatment_Plan_Duration, careplan_Treatment_Plan_Freq_Duration1, and careplan_Treatment_Plan_Freq_Duration2 columns from the table forms_pt_careplan

#IfColumnDoesExist forms_pt_careplan careplan_Treatment_Plan_Duration
ALTER TABLE `forms_pt_careplan` DROP COLUMN `careplan_Treatment_Plan_Duration`;
#EndIf

#IfColumnDoesExist forms_pt_careplan careplan_Treatment_Plan_Freq_Duration1
ALTER TABLE `forms_pt_careplan` DROP COLUMN `careplan_Treatment_Plan_Freq_Duration1`;
#EndIf

#IfColumnDoesExist forms_pt_careplan careplan_Treatment_Plan_Freq_Duration2
ALTER TABLE `forms_pt_careplan` DROP COLUMN `careplan_Treatment_Plan_Freq_Duration2`;
#EndIf

-- Drops the careplan_Treatment_Plan_Duration, careplan_Treatment_Plan_Freq_Duration1, and careplan_Treatment_Plan_Freq_Duration2 columns from the table forms_st_careplan

#IfColumnDoesExist forms_st_careplan careplan_Treatment_Plan_Duration
ALTER TABLE `forms_st_careplan` DROP COLUMN `careplan_Treatment_Plan_Duration`;
#EndIf

#IfColumnDoesExist forms_st_careplan careplan_Treatment_Plan_Freq_Duration1
ALTER TABLE `forms_st_careplan` DROP COLUMN `careplan_Treatment_Plan_Freq_Duration1`;
#EndIf

#IfColumnDoesExist forms_st_careplan careplan_Treatment_Plan_Freq_Duration2
ALTER TABLE `forms_st_careplan` DROP COLUMN `careplan_Treatment_Plan_Freq_Duration2`;
#EndIf

-- Alters the forms_physician_orders table and changes data type from tinyint(4) to varchar(255)

ALTER TABLE `forms_physician_orders` MODIFY COLUMN `physician_orders_diagnosis` VARCHAR(255);

-- Alters the forms_physician_orders table and changes data type from tinyint(4) to varchar(255)

ALTER TABLE `forms_nursing_visitnote` MODIFY COLUMN `visitnote_VS_Diagnosis` VARCHAR(255);

-- New Column to forms_ot_visitnote table to store the further skills required text

#IfMissingColumn forms_ot_visitnote visitnote_further_Visit_Required_text
ALTER TABLE forms_ot_visitnote ADD visitnote_further_Visit_Required_text varchar(255) NOT NULL default '';
#EndIf

-- New Column to forms_pt_visitnote table to store the further skills required text

#IfMissingColumn forms_pt_visitnote visitnote_further_Visit_Required_text
ALTER TABLE forms_pt_visitnote ADD visitnote_further_Visit_Required_text varchar(255) NOT NULL default '';
#EndIf

-- New Column to forms_st_visitnote table to store the further skills required text

#IfMissingColumn forms_st_visitnote visitnote_further_Visit_Required_text
ALTER TABLE forms_st_visitnote ADD visitnote_further_Visit_Required_text varchar(255) NOT NULL default '';
#EndIf

-- Drops oasis_c_nurse_urinary_irrigation_returns, oasis_c_nurse_amplification_care_provided, oasis_c_nurse_amplification_patient_response from the table forms_oasis_c_nurse

#IfColumnDoesExist forms_oasis_c_nurse oasis_c_nurse_urinary_irrigation_returns
ALTER TABLE `forms_oasis_c_nurse` DROP COLUMN `oasis_c_nurse_urinary_irrigation_returns`;
#EndIf

#IfColumnDoesExist forms_oasis_c_nurse oasis_c_nurse_amplification_care_provided
ALTER TABLE `forms_oasis_c_nurse` DROP COLUMN `oasis_c_nurse_amplification_care_provided`;
#EndIf

#IfColumnDoesExist forms_oasis_c_nurse oasis_c_nurse_amplification_patient_response
ALTER TABLE `forms_oasis_c_nurse` DROP COLUMN `oasis_c_nurse_amplification_patient_response`;
#EndIf

-- Drops oasis_therapy_urinary_irrigation_returns, oasis_therapy_amplification_care_provided, oasis_therapy_amplification_patient_response from the table forms_oasis_therapy_rectification

#IfColumnDoesExist forms_oasis_therapy_rectification oasis_therapy_urinary_irrigation_returns
ALTER TABLE `forms_oasis_therapy_rectification` DROP COLUMN `oasis_therapy_urinary_irrigation_returns`;
#EndIf

#IfColumnDoesExist forms_oasis_therapy_rectification oasis_therapy_amplification_care_provided
ALTER TABLE `forms_oasis_therapy_rectification` DROP COLUMN `oasis_therapy_amplification_care_provided`;
#EndIf

#IfColumnDoesExist forms_oasis_therapy_rectification oasis_therapy_amplification_patient_response
ALTER TABLE `forms_oasis_therapy_rectification` DROP COLUMN `oasis_therapy_amplification_patient_response`;
#EndIf

-- Renames Nurse Visitnote to Nurse Visit Note in registry table
#IfColumnDoesExist registry name
UPDATE `registry` SET `name` = 'Nurse Visit Note' WHERE `name` = 'Nurse Visitnote';
#EndIf

-- Renames HHA-Supervisor Visit to Supervisor Visit in registry table
#IfColumnDoesExist registry name
UPDATE `registry` SET `name` = 'Supervisor Visit' WHERE `name` = 'HHA-Supervisor Visit';
#EndIf

-- Drops the oasis_therapy_heart_sounds_site, non_oasis_infusion, and non_oasis_infusion_intrathecal_date columns from the table forms_oasis_discharge
#IfColumnDoesExist forms_oasis_discharge oasis_therapy_heart_sounds_site
ALTER TABLE `forms_oasis_discharge` DROP COLUMN `oasis_therapy_heart_sounds_site`;
#EndIf

#IfColumnDoesExist forms_oasis_discharge non_oasis_infusion
ALTER TABLE `forms_oasis_discharge` DROP COLUMN `non_oasis_infusion`;
#EndIf

#IfColumnDoesExist forms_oasis_discharge non_oasis_infusion_intrathecal_date
ALTER TABLE `forms_oasis_discharge` DROP COLUMN `non_oasis_infusion_intrathecal_date`;
#EndIf

-- Adds new column to forms_oasis_discharge table to store oasis_therapy_heart_sounds_associated_with_other data
#IfMissingColumn forms_oasis_discharge oasis_therapy_heart_sounds_associated_with_other
ALTER TABLE `forms_oasis_discharge` ADD `oasis_therapy_heart_sounds_associated_with_other` varchar(255) NOT NULL default '';
#EndIf

-- Adds new column to forms_oasis_discharge table to store oasis_therapy_heart_sounds_edema_right data
#IfMissingColumn forms_oasis_discharge oasis_therapy_heart_sounds_edema_right
ALTER TABLE `forms_oasis_discharge` ADD `oasis_therapy_heart_sounds_edema_right` varchar(10) NOT NULL default '';
#EndIf

-- Adds new column to forms_oasis_discharge table to store oasis_therapy_heart_sounds_edema_dependent_right data
#IfMissingColumn forms_oasis_discharge oasis_therapy_heart_sounds_edema_dependent_right
ALTER TABLE `forms_oasis_discharge` ADD `oasis_therapy_heart_sounds_edema_dependent_right` varchar(12) NOT NULL default '';
#EndIf

-- Adds new column to forms_oasis_discharge table to store oasis_therapy_heart_sounds_capillary_right data
#IfMissingColumn forms_oasis_discharge oasis_therapy_heart_sounds_capillary_right
ALTER TABLE `forms_oasis_discharge` ADD `oasis_therapy_heart_sounds_capillary_right` varchar(2) NOT NULL default '';
#EndIf

-- Adds new column to forms_oasis_discharge table to store oasis_therapy_heart_sounds_right data
#IfMissingColumn forms_oasis_discharge oasis_therapy_heart_sounds_right
ALTER TABLE `forms_oasis_discharge` ADD `oasis_therapy_heart_sounds_right` TEXT;
#EndIf

-- Adds new column to forms_oasis_discharge table to store oasis_therapy_heart_sounds_other_right data
#IfMissingColumn forms_oasis_discharge oasis_therapy_heart_sounds_other_right
ALTER TABLE `forms_oasis_discharge` ADD `oasis_therapy_heart_sounds_other_right` varchar(30) NOT NULL default '';
#EndIf

-- Drops the columns oasis_system_review_bowel, and oasis_system_review_bladder from forms_oasis_discharge
#IfColumnDoesExist forms_oasis_discharge oasis_system_review_bowel
ALTER TABLE `forms_oasis_discharge` DROP COLUMN `oasis_system_review_bowel`;
#EndIf

#IfColumnDoesExist forms_oasis_discharge oasis_system_review_bladder
ALTER TABLE `forms_oasis_discharge` DROP COLUMN `oasis_system_review_bladder`;
#EndIf

-- Adds new columns in forms_oasis_discharge for newly added textboxes
#IfMissingColumn forms_oasis_discharge oasis_therapy_vital_sign_pulse_textinput
ALTER TABLE `forms_oasis_discharge` ADD `oasis_therapy_vital_sign_pulse_textinput` varchar(100) NOT NULL default '';
#EndIf

#IfMissingColumn forms_oasis_discharge oasis_therapy_vital_sign_respiratory_textinput
ALTER TABLE `forms_oasis_discharge` ADD `oasis_therapy_vital_sign_respiratory_textinput` varchar(100) NOT NULL default '';
#EndIf