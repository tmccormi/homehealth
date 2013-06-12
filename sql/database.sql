--
-- Database: `openemr`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `addresses`
-- 

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `id` int(11) NOT NULL default '0',
  `line1` varchar(255) default NULL,
  `line2` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(35) default NULL,
  `zip` varchar(10) default NULL,
  `plus_four` varchar(4) default NULL,
  `country` varchar(255) default NULL,
  `foreign_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `foreign_id` (`foreign_id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `amc_misc_data`
--

DROP TABLE IF EXISTS `amc_misc_data`;
CREATE TABLE `amc_misc_data` (
  `amc_id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Unique and maps to list_options list clinical_rules',
  `pid` bigint(20) default NULL,
  `map_category` varchar(255) NOT NULL default '' COMMENT 'Maps to an object category (such as prescriptions etc.)',
  `map_id` bigint(20) NOT NULL default '0' COMMENT 'Maps to an object id (such as prescription id etc.)',
  `date_created` datetime default NULL,
  `date_completed` datetime default NULL,
  KEY  (`amc_id`,`pid`,`map_id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `array`
-- 

DROP TABLE IF EXISTS `array`;
CREATE TABLE `array` (
  `array_key` varchar(255) default NULL,
  `array_value` longtext
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `audit_master`
--

DROP TABLE IF EXISTS `audit_master`;
CREATE TABLE `audit_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'The Id of the user who approves or denies',
  `approval_status` tinyint(4) NOT NULL COMMENT '1-Pending,2-Approved,3-Denied,4-Appointment directly updated to calendar table,5-Cancelled appointment',
  `comments` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_time` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1-new patient,2-existing patient,3-change is only in the document,5-random key,10-Appointment',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

--
-- Table structure for table `audit_details`
--

DROP TABLE IF EXISTS `audit_details`;
CREATE TABLE `audit_details` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `table_name` VARCHAR(100) NOT NULL COMMENT 'openemr table name',
  `field_name` VARCHAR(100) NOT NULL COMMENT 'openemr table''s field name',
  `field_value` TEXT NOT NULL COMMENT 'openemr table''s field value',
  `audit_master_id` BIGINT(20) NOT NULL COMMENT 'Id of the audit_master table',
  `entry_identification` VARCHAR(255) NOT NULL DEFAULT '1' COMMENT 'Used when multiple entry occurs from the same table.1 means no multiple entry',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;
-- 
-- Table structure for table `batchcom`
-- 

DROP TABLE IF EXISTS `batchcom`;
CREATE TABLE `batchcom` (
  `id` bigint(20) NOT NULL auto_increment,
  `patient_id` int(11) NOT NULL default '0',
  `sent_by` bigint(20) NOT NULL default '0',
  `msg_type` varchar(60) default NULL,
  `msg_subject` varchar(255) default NULL,
  `msg_text` mediumtext,
  `msg_date_sent` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `billing`
-- 

DROP TABLE IF EXISTS `billing`;
CREATE TABLE `billing` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime default NULL,
  `code_type` varchar(7) default NULL,
  `code` varchar(9) default NULL,
  `pid` int(11) default NULL,
  `provider_id` int(11) default NULL,
  `user` int(11) default NULL,
  `groupname` varchar(255) default NULL,
  `authorized` tinyint(1) default NULL,
  `encounter` int(11) default NULL,
  `code_text` longtext,
  `billed` tinyint(1) default NULL,
  `activity` tinyint(1) default NULL,
  `payer_id` int(11) default NULL,
  `bill_process` tinyint(2) NOT NULL default '0',
  `bill_date` datetime default NULL,
  `process_date` datetime default NULL,
  `process_file` varchar(255) default NULL,
  `modifier` varchar(12) default NULL,
  `units` tinyint(3) default NULL,
  `fee` decimal(12,2) default NULL,
  `justify` varchar(255) default NULL,
  `target` varchar(30) default NULL,
  `x12_partner_id` int(11) default NULL,
  `ndc_info` varchar(255) default NULL,
  `notecodes` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `categories`
-- 

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `value` varchar(255) default NULL,
  `parent` int(11) NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `rght` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent` (`parent`),
  KEY `lft` (`lft`,`rght`)
) ENGINE=MyISAM;

-- 
-- Dumping data for table `categories`
-- 

INSERT INTO `categories` VALUES (1, 'Categories', '', 0, 0, 23);
INSERT INTO `categories` VALUES (2, 'Lab Report', '', 1, 1, 2);
INSERT INTO `categories` VALUES (3, 'Medical Record', '', 1, 3, 4);
INSERT INTO `categories` VALUES (4, 'Patient Information', '', 1, 5, 10);
INSERT INTO `categories` VALUES (5, 'Patient ID card', '', 4, 6, 7);
INSERT INTO `categories` VALUES (6, 'Advance Directive', '', 1, 11, 18);
INSERT INTO `categories` VALUES (7, 'Do Not Resuscitate Order', '', 6, 12, 13);
INSERT INTO `categories` VALUES (8, 'Durable Power of Attorney', '', 6, 14, 15);
INSERT INTO `categories` VALUES (9, 'Living Will', '', 6, 16, 17);
INSERT INTO `categories` VALUES (10, 'Patient Photograph', '', 4, 8, 9);
INSERT INTO `categories` VALUES (11, 'CCR', '', 1, 19, 20);
INSERT INTO `categories` VALUES (12, 'CCD', '', 1, 21, 22);

-- --------------------------------------------------------

-- 
-- Table structure for table `categories_seq`
-- 

DROP TABLE IF EXISTS `categories_seq`;
CREATE TABLE `categories_seq` (
  `id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- 
-- Dumping data for table `categories_seq`
-- 

INSERT INTO `categories_seq` VALUES (12);

-- --------------------------------------------------------

-- 
-- Table structure for table `categories_to_documents`
-- 

DROP TABLE IF EXISTS `categories_to_documents`;
CREATE TABLE `categories_to_documents` (
  `category_id` int(11) NOT NULL default '0',
  `document_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`category_id`,`document_id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `claims`
-- 

DROP TABLE IF EXISTS `claims`;
CREATE TABLE `claims` (
  `patient_id` int(11) NOT NULL,
  `encounter_id` int(11) NOT NULL,
  `version` int(10) unsigned NOT NULL auto_increment,
  `payer_id` int(11) NOT NULL default '0',
  `status` tinyint(2) NOT NULL default '0',
  `payer_type` tinyint(4) NOT NULL default '0',
  `bill_process` tinyint(2) NOT NULL default '0',
  `bill_time` datetime default NULL,
  `process_time` datetime default NULL,
  `process_file` varchar(255) default NULL,
  `target` varchar(30) default NULL,
  `x12_partner_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`patient_id`,`encounter_id`,`version`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinical_plans`
--

DROP TABLE IF EXISTS `clinical_plans`;
CREATE TABLE `clinical_plans` (
  `id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Unique and maps to list_options list clinical_plans',
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '0 is default for all patients, while > 0 is id from patient_data table',
  `normal_flag` tinyint(1) COMMENT 'Normal Activation Flag',
  `cqm_flag` tinyint(1) COMMENT 'Clinical Quality Measure flag (unable to customize per patient)',
  `cqm_measure_group` varchar(10) NOT NULL default '' COMMENT 'Clinical Quality Measure Group Identifier',
  PRIMARY KEY  (`id`,`pid`)
) ENGINE=MyISAM ;

--
-- Clinical Quality Measure (CMQ) plans
--
-- Measure Group A: Diabetes Mellitus
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('dm_plan_cqm', 0, 0, 1, 'A');
-- Measure Group C: Chronic Kidney Disease (CKD)
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('ckd_plan_cqm', 0, 0, 1, 'C');
-- Measure Group D: Preventative Care
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('prevent_plan_cqm', 0, 0, 1, 'D');
-- Measure Group E: Perioperative Care
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('periop_plan_cqm', 0, 0, 1, 'E');
-- Measure Group F: Rheumatoid Arthritis
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('rheum_arth_plan_cqm', 0, 0, 1, 'F');
-- Measure Group G: Back Pain
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('back_pain_plan_cqm', 0, 0, 1, 'G');
-- Measure Group H: Coronary Artery Bypass Graft (CABG)
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('cabg_plan_cqm', 0, 0, 1, 'H');
--
-- Standard clinical plans
--
-- Diabetes Mellitus
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('dm_plan', 0, 1, 0, '');
INSERT INTO `clinical_plans` ( `id`, `pid`, `normal_flag`, `cqm_flag`, `cqm_measure_group` ) VALUES ('prevent_plan', 0, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `clinical_plans_rules`
--

DROP TABLE IF EXISTS `clinical_plans_rules`;
CREATE TABLE `clinical_plans_rules` (
  `plan_id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Unique and maps to list_options list clinical_plans',
  `rule_id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Unique and maps to list_options list clinical_rules',
  PRIMARY KEY  (`plan_id`,`rule_id`)
) ENGINE=MyISAM ;

--
-- Clinical Quality Measure (CMQ) plans to rules mappings
--
-- Measure Group A: Diabetes Mellitus
--   NQF 0059 (PQRI 1)   Diabetes: HbA1c Poor Control
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan_cqm', 'rule_dm_a1c_cqm');
--   NQF 0064 (PQRI 2)   Diabetes: LDL Management & Control
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan_cqm', 'rule_dm_ldl_cqm');
--   NQF 0061 (PQRI 3)   Diabetes: Blood Pressure Management
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan_cqm', 'rule_dm_bp_control_cqm');
--   NQF 0055 (PQRI 117) Diabetes: Eye Exam
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan_cqm', 'rule_dm_eye_cqm');
--   NQF 0056 (PQRI 163) Diabetes: Foot Exam
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan_cqm', 'rule_dm_foot_cqm');
-- Measure Group D: Preventative Care
--   NQF 0041 (PQRI 110) Influenza Immunization for Patients >= 50 Years Old
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan_cqm', 'rule_influenza_ge_50_cqm');
--   NQF 0043 (PQRI 111) Pneumonia Vaccination Status for Older Adults
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan_cqm', 'rule_pneumovacc_ge_65_cqm');
--   NQF 0421 (PQRI 128) Adult Weight Screening and Follow-Up
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan_cqm', 'rule_adult_wt_screen_fu_cqm');
--
-- Standard clinical plans to rules mappings
--
-- Diabetes Mellitus
--   Hemoglobin A1C
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan', 'rule_dm_hemo_a1c');
--   Urine Microalbumin
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan', 'rule_dm_urine_alb');
--   Eye Exam
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan', 'rule_dm_eye');
--   Foot Exam
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('dm_plan', 'rule_dm_foot');
-- Preventative Care
--   Hypertension: Blood Pressure Measurement
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_htn_bp_measure');
--   Tobacco Use Assessment
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_tob_use_assess');
--   Tobacco Cessation Intervention
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_tob_cess_inter');
--   Adult Weight Screening and Follow-Up
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_adult_wt_screen_fu');
--   Weight Assessment and Counseling for Children and Adolescents
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_wt_assess_couns_child');
--   Influenza Immunization for Patients >= 50 Years Old
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_influenza_ge_50');
--   Pneumonia Vaccination Status for Older Adults
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_pneumovacc_ge_65');
--   Cancer Screening: Mammogram
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_cs_mammo');
--   Cancer Screening: Pap Smear
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_cs_pap');
--   Cancer Screening: Colon Cancer Screening
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_cs_colon');
--   Cancer Screening: Prostate Cancer Screening
INSERT INTO `clinical_plans_rules` ( `plan_id`, `rule_id` ) VALUES ('prevent_plan', 'rule_cs_prostate');

-- --------------------------------------------------------

--
-- Table structure for table `clinical_rules`
--

DROP TABLE IF EXISTS `clinical_rules`;
CREATE TABLE `clinical_rules` (
  `id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Unique and maps to list_options list clinical_rules',
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '0 is default for all patients, while > 0 is id from patient_data table',
  `active_alert_flag` tinyint(1) COMMENT 'Active Alert Widget Module flag - note not yet utilized',
  `passive_alert_flag` tinyint(1) COMMENT 'Passive Alert Widget Module flag',
  `cqm_flag` tinyint(1) COMMENT 'Clinical Quality Measure flag (unable to customize per patient)',
  `cqm_nqf_code` varchar(10) NOT NULL default '' COMMENT 'Clinical Quality Measure NQF identifier',
  `cqm_pqri_code` varchar(10) NOT NULL default '' COMMENT 'Clinical Quality Measure PQRI identifier',
  `amc_flag` tinyint(1) COMMENT 'Automated Measure Calculation flag (unable to customize per patient)',
  `amc_code` varchar(10) NOT NULL default '' COMMENT 'Automated Measure Calculation indentifier (MU rule)',
  `patient_reminder_flag` tinyint(1) COMMENT 'Clinical Reminder Module flag',
  PRIMARY KEY  (`id`,`pid`)
) ENGINE=MyISAM ;

--
-- Automated Measure Calculation (AMC) rules
--
-- MU 170.302(c) Maintain an up-to-date problem list of current and active diagnoses
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('problem_list_amc', 0, 0, 0, 0, '', '', 1, '170.302(c)', 0);
-- MU 170.302(d) Maintain active medication list
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('med_list_amc', 0, 0, 0, 0, '', '', 1, '170.302(d)', 0);
-- MU 170.302(e) Maintain active medication allergy list
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('med_allergy_list_amc', 0, 0, 0, 0, '', '', 1, '170.302(e)', 0);
-- MU 170.302(f) Record and chart changes in vital signs
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('record_vitals_amc', 0, 0, 0, 0, '', '', 1, '170.302(f)', 0);
-- MU 170.302(g) Record smoking status for patients 13 years old or older
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('record_smoke_amc', 0, 0, 0, 0, '', '', 1, '170.302(g)', 0);
-- MU 170.302(h) Incorporate clinical lab-test results into certified EHR technology as
--               structured data
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('lab_result_amc', 0, 0, 0, 0, '', '', 1, '170.302(h)', 0);
-- MU 170.302(j) The EP, eligible hospital or CAH who receives a patient from another
--               setting of care or provider of care or believes an encounter is relevant
--               should perform medication reconciliation
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('med_reconc_amc', 0, 0, 0, 0, '', '', 1, '170.302(j)', 0);
-- MU 170.302(m) Use certified EHR technology to identify patient-specific education resources
--              and provide those resources to the patient if appropriate
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('patient_edu_amc', 0, 0, 0, 0, '', '', 1, '170.302(m)', 0);
-- MU 170.304(a) Use CPOE for medication orders directly entered by any licensed healthcare
--              professional who can enter orders into the medical record per state, local
--              and professional guidelines
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('cpoe_med_amc', 0, 0, 0, 0, '', '', 1, '170.304(a)', 0);
-- MU 170.304(b) Generate and transmit permissible prescriptions electronically (eRx)
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('e_prescribe_amc', 0, 0, 0, 0, '', '', 1, '170.304(b)', 0);
-- MU 170.304(c) Record demographics
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('record_dem_amc', 0, 0, 0, 0, '', '', 1, '170.304(c)', 0);
-- MU 170.304(d) Send reminders to patients per patient preference for preventive/follow up care
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('send_reminder_amc', 0, 0, 0, 0, '', '', 1, '170.304(d)', 0);
-- MU 170.304(f) Provide patients with an electronic copy of their health information
--               (including diagnostic test results, problem list, medication lists,
--               medication allergies), upon request
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('provide_rec_pat_amc', 0, 0, 0, 0, '', '', 1, '170.304(f)', 0);
-- MU 170.304(g) Provide patients with timely electronic access to their health information
--              (including lab results, problem list, medication lists, medication allergies)
--              within four business days of the information being available to the EP
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('timely_access_amc', 0, 0, 0, 0, '', '', 1, '170.304(g)', 0);
-- MU 170.304(h) Provide clinical summaries for patients for each office visit
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('provide_sum_pat_amc', 0, 0, 0, 0, '', '', 1, '170.304(h)', 0);
-- MU 170.304(i) The EP, eligible hospital or CAH who transitions their patient to
--               another setting of care or provider of care or refers their patient to
--               another provider of care should provide summary of care record for
--               each transition of care or referral
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('send_sum_amc', 0, 0, 0, 0, '', '', 1, '170.304(i)', 0);
--
-- Clinical Quality Measure (CQM) rules
--
-- NQF 0013 Hypertension: Blood Pressure Measurement
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_htn_bp_measure_cqm', 0, 0, 0, 1, '0013', '', 0, '', 0);
-- NQF 0028a Tobacco Use Assessment
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_tob_use_assess_cqm', 0, 0, 0, 1, '0028a', '', 0, '', 0);
-- NQF 0028b Tobacco Cessation Intervention
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_tob_cess_inter_cqm', 0, 0, 0, 1, '0028b', '', 0, '', 0);
-- NQF 0421 (PQRI 128) Adult Weight Screening and Follow-Up
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_adult_wt_screen_fu_cqm', 0, 0, 0, 1, '0421', '128', 0, '', 0);
-- NQF 0024 Weight Assessment and Counseling for Children and Adolescents
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_wt_assess_couns_child_cqm', 0, 0, 0, 1, '0024', '', 0, '', 0);
-- NQF 0041 (PQRI 110) Influenza Immunization for Patients >= 50 Years Old
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_influenza_ge_50_cqm', 0, 0, 0, 1, '0041', '110', 0, '', 0);
-- NQF 0038 Childhood immunization Status
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_child_immun_stat_cqm', 0, 0, 0, 1, '0038', '', 0, '', 0);
-- NQF 0043 (PQRI 111) Pneumonia Vaccination Status for Older Adults
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_pneumovacc_ge_65_cqm', 0, 0, 0, 1, '0043', '111', 0, '', 0);
-- NQF 0055 (PQRI 117) Diabetes: Eye Exam
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_eye_cqm', 0, 0, 0, 1, '0055', '117', 0, '', 0);
-- NQF 0056 (PQRI 163) Diabetes: Foot Exam
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_foot_cqm', 0, 0, 0, 1, '0056', '163', 0, '', 0);
-- NQF 0059 (PQRI 1) Diabetes: HbA1c Poor Control
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_a1c_cqm', 0, 0, 0, 1, '0059', '1', 0, '', 0);
-- NQF 0061 (PQRI 3) Diabetes: Blood Pressure Management
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_bp_control_cqm', 0, 0, 0, 1, '0061', '3', 0, '', 0);
-- NQF 0064 (PQRI 2) Diabetes: LDL Management & Control
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_ldl_cqm', 0, 0, 0, 1, '0064', '2', 0, '', 0);
--
-- Standard clinical rules
--
-- Hypertension: Blood Pressure Measurement
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_htn_bp_measure', 0, 0, 1, 0, '', '', 0, '', 0);
-- Tobacco Use Assessment
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_tob_use_assess', 0, 0, 1, 0, '', '', 0, '', 0);
-- Tobacco Cessation Intervention
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_tob_cess_inter', 0, 0, 1, 0, '', '', 0, '', 0);
-- Adult Weight Screening and Follow-Up
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_adult_wt_screen_fu', 0, 0, 1, 0, '', '', 0, '', 0);
-- Weight Assessment and Counseling for Children and Adolescents
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_wt_assess_couns_child', 0, 0, 1, 0, '', '', 0, '', 0);
-- Influenza Immunization for Patients >= 50 Years Old
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_influenza_ge_50', 0, 0, 1, 0, '', '', 0, '', 0);
-- Pneumonia Vaccination Status for Older Adults
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_pneumovacc_ge_65', 0, 0, 1, 0, '', '', 0, '', 0);
-- Diabetes: Hemoglobin A1C
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_hemo_a1c', 0, 0, 1, 0, '', '', 0, '', 0);
-- Diabetes: Urine Microalbumin
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_urine_alb', 0, 0, 1, 0, '', '', 0, '', 0);
-- Diabetes: Eye Exam
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_eye', 0, 0, 1, 0, '', '', 0, '', 0);
-- Diabetes: Foot Exam
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_dm_foot', 0, 0, 1, 0, '', '', 0, '', 0);
-- Cancer Screening: Mammogram
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_cs_mammo', 0, 0, 1, 0, '', '', 0, '', 0);
-- Cancer Screening: Pap Smear
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_cs_pap', 0, 0, 1, 0, '', '', 0, '', 0);
-- Cancer Screening: Colon Cancer Screening
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_cs_colon', 0, 0, 1, 0, '', '', 0, '', 0);
-- Cancer Screening: Prostate Cancer Screening
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_cs_prostate', 0, 0, 1, 0, '', '', 0, '', 0);
--
-- Rules to specifically demonstrate passing of NIST criteria
--
-- Coumadin Management - INR Monitoring
INSERT INTO `clinical_rules` ( `id`, `pid`, `active_alert_flag`, `passive_alert_flag`, `cqm_flag`, `cqm_nqf_code`, `cqm_pqri_code`, `amc_flag`, `amc_code`, `patient_reminder_flag` ) VALUES ('rule_inr_monitor', 0, 0, 1, 0, '', '', 0, '', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `codes`
-- 

DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `id` int(11) NOT NULL auto_increment,
  `code_text` varchar(255) NOT NULL default '',
  `code_text_short` varchar(24) NOT NULL default '',
  `code` varchar(10) NOT NULL default '',
  `code_type` tinyint(2) default NULL,
  `modifier` varchar(5) NOT NULL default '',
  `units` tinyint(3) default NULL,
  `fee` decimal(12,2) default NULL,
  `superbill` varchar(31) NOT NULL default '',
  `related_code` varchar(255) NOT NULL default '',
  `taxrates` varchar(255) NOT NULL default '',
  `cyp_factor` float NOT NULL DEFAULT 0 COMMENT 'quantity representing a years supply',
  `active` TINYINT(1) DEFAULT 1 COMMENT '0 = inactive, 1 = active',
  `reportable` TINYINT(1) DEFAULT 0 COMMENT '0 = non-reportable, 1 = reportable',
  `financial_reporting` TINYINT(1) DEFAULT 0 COMMENT '0 = negative, 1 = considered important code in financial reporting',
  PRIMARY KEY  (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

-- 
-- Table structure for table `syndromic_surveillance`
-- 

DROP TABLE IF EXISTS `syndromic_surveillance`;
CREATE TABLE `syndromic_surveillance` (
  `id` bigint(20) NOT NULL auto_increment,
  `lists_id` bigint(20) NOT NULL,
  `submission_date` datetime NOT NULL,
  `filename` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY (`lists_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `config`
-- 

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `value` varchar(255) default NULL,
  `parent` int(11) NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `rght` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent` (`parent`),
  KEY `lft` (`lft`,`rght`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `config_seq`
-- 

DROP TABLE IF EXISTS `config_seq`;
CREATE TABLE `config_seq` (
  `id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- 
-- Dumping data for table `config_seq`
-- 

INSERT INTO `config_seq` VALUES (0);

-- --------------------------------------------------------

--
-- Table structure for table `dated_reminders`
--

DROP TABLE IF EXISTS `dated_reminders`;
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
  `episode_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`dr_id`),
  KEY `dr_from_ID` (`dr_from_ID`,`dr_message_due_date`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `dated_reminders_link`
--

DROP TABLE IF EXISTS `dated_reminders_link`;
CREATE TABLE `dated_reminders_link` (           
  `dr_link_id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  PRIMARY KEY (`dr_link_id`),
  KEY `to_id` (`to_id`),
  KEY `dr_id` (`dr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `documents`
-- 

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL default '0',
  `type` enum('file_url','blob','web_url') default NULL,
  `size` int(11) default NULL,
  `date` datetime default NULL,
  `url` varchar(255) default NULL,
  `mimetype` varchar(255) default NULL,
  `pages` int(11) default NULL,
  `owner` int(11) default NULL,
  `revision` timestamp NOT NULL,
  `foreign_id` int(11) default NULL,
  `docdate` date default NULL,
  `hash` varchar(40) DEFAULT NULL COMMENT '40-character SHA-1 hash of document',
  `list_id` bigint(20) NOT NULL default '0',
  `couch_docid` VARCHAR(100) DEFAULT NULL,
  `couch_revid` VARCHAR(100) DEFAULT NULL,
  `storagemethod` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0->Harddisk,1->CouchDB',
  PRIMARY KEY  (`id`),
  KEY `revision` (`revision`),
  KEY `foreign_id` (`foreign_id`),
  KEY `owner` (`owner`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `documents_legal_detail`
--

DROP TABLE IF EXISTS `documents_legal_detail`;
CREATE TABLE `documents_legal_detail` (
  `dld_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dld_pid` int(10) unsigned DEFAULT NULL,
  `dld_facility` int(10) unsigned DEFAULT NULL,
  `dld_provider` int(10) unsigned DEFAULT NULL,
  `dld_encounter` int(10) unsigned DEFAULT NULL,
  `dld_master_docid` int(10) unsigned NOT NULL,
  `dld_signed` smallint(5) unsigned NOT NULL COMMENT '0-Not Signed or Cannot Sign(Layout),1-Signed,2-Ready to sign,3-Denied(Pat Regi),10-Save(Layout)',
  `dld_signed_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dld_filepath` varchar(75) DEFAULT NULL,
  `dld_filename` varchar(45) NOT NULL,
  `dld_signing_person` varchar(50) NOT NULL,
  `dld_sign_level` int(11) NOT NULL COMMENT 'Sign flow level',
  `dld_content` varchar(50) NOT NULL COMMENT 'Layout sign position',
  `dld_file_for_pdf_generation` blob NOT NULL COMMENT 'The filled details in the fdf file is stored here.Patient Registration Screen',
  `dld_denial_reason` longtext NOT NULL,
  PRIMARY KEY (`dld_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `documents_legal_master`
--

DROP TABLE IF EXISTS `documents_legal_master`;
CREATE TABLE `documents_legal_master` (
  `dlm_category` int(10) unsigned DEFAULT NULL,
  `dlm_subcategory` int(10) unsigned DEFAULT NULL,
  `dlm_document_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dlm_document_name` varchar(75) NOT NULL,
  `dlm_filepath` varchar(75) NOT NULL,
  `dlm_facility` int(10) unsigned DEFAULT NULL,
  `dlm_provider` int(10) unsigned DEFAULT NULL,
  `dlm_sign_height` double NOT NULL,
  `dlm_sign_width` double NOT NULL,
  `dlm_filename` varchar(45) NOT NULL,
  `dlm_effective_date` datetime NOT NULL,
  `dlm_version` int(10) unsigned NOT NULL,
  `content` varchar(255) NOT NULL,
  `dlm_savedsign` varchar(255) DEFAULT NULL COMMENT '0-Yes 1-No',
  `dlm_review` varchar(255) DEFAULT NULL COMMENT '0-Yes 1-No',
  PRIMARY KEY (`dlm_document_id`)
) ENGINE=MyISAM COMMENT='List of Master Docs to be signed' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `documents_legal_categories`
--

DROP TABLE IF EXISTS `documents_legal_categories`;
CREATE TABLE `documents_legal_categories` (
  `dlc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dlc_category_type` int(10) unsigned NOT NULL COMMENT '1 category 2 subcategory',
  `dlc_category_name` varchar(45) NOT NULL,
  `dlc_category_parent` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`dlc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 ;

--
-- Dumping data for table `documents_legal_categories`
--

INSERT INTO `documents_legal_categories` (`dlc_id`, `dlc_category_type`, `dlc_category_name`, `dlc_category_parent`) VALUES
(3, 1, 'Category', NULL),
(4, 2, 'Sub Category', 1),
(5, 1, 'Layout Form', 0),
(6, 2, 'Layout Signed', 5);

-- 
-- Table structure for table `drug_inventory`
-- 

DROP TABLE IF EXISTS `drug_inventory`;
CREATE TABLE `drug_inventory` (
  `inventory_id` int(11) NOT NULL auto_increment,
  `drug_id` int(11) NOT NULL,
  `lot_number` varchar(20) default NULL,
  `expiration` date default NULL,
  `manufacturer` varchar(255) default NULL,
  `on_hand` int(11) NOT NULL default '0',
  `warehouse_id` varchar(31) NOT NULL DEFAULT '',
  `vendor_id` bigint(20) NOT NULL DEFAULT 0,
  `last_notify` date NOT NULL default '0000-00-00',
  `destroy_date` date default NULL,
  `destroy_method` varchar(255) default NULL,
  `destroy_witness` varchar(255) default NULL,
  `destroy_notes` varchar(255) default NULL,
  PRIMARY KEY  (`inventory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `drug_sales`
-- 

DROP TABLE IF EXISTS `drug_sales`;
CREATE TABLE `drug_sales` (
  `sale_id` int(11) NOT NULL auto_increment,
  `drug_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL default '0',
  `pid` int(11) NOT NULL default '0',
  `encounter` int(11) NOT NULL default '0',
  `user` varchar(255) default NULL,
  `sale_date` date NOT NULL,
  `quantity` int(11) NOT NULL default '0',
  `fee` decimal(12,2) NOT NULL default '0.00',
  `billed` tinyint(1) NOT NULL default '0' COMMENT 'indicates if the sale is posted to accounting',
  `xfer_inventory_id` int(11) NOT NULL DEFAULT 0,
  `distributor_id` bigint(20) NOT NULL DEFAULT 0 COMMENT 'references users.id',
  `notes` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`sale_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `drug_templates`
-- 

DROP TABLE IF EXISTS `drug_templates`;
CREATE TABLE `drug_templates` (
  `drug_id` int(11) NOT NULL,
  `selector` varchar(255) NOT NULL default '',
  `dosage` varchar(10) default NULL,
  `period` int(11) NOT NULL default '0',
  `quantity` int(11) NOT NULL default '0',
  `refills` int(11) NOT NULL default '0',
  `taxrates` varchar(255) default NULL,
  PRIMARY KEY  (`drug_id`,`selector`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `drugs`
-- 

DROP TABLE IF EXISTS `drugs`;
CREATE TABLE `drugs` (
  `drug_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL DEFAULT '',
  `ndc_number` varchar(20) NOT NULL DEFAULT '',
  `on_order` int(11) NOT NULL default '0',
  `reorder_point` float NOT NULL DEFAULT 0.0,
  `max_level` float NOT NULL DEFAULT 0.0,
  `last_notify` date NOT NULL default '0000-00-00',
  `reactions` text,
  `form` int(3) NOT NULL default '0',
  `size` float unsigned NOT NULL default '0',
  `unit` int(11) NOT NULL default '0',
  `route` int(11) NOT NULL default '0',
  `substitute` int(11) NOT NULL default '0',
  `related_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'may reference a related codes.code',
  `cyp_factor` float NOT NULL DEFAULT 0 COMMENT 'quantity representing a years supply',
  `active` TINYINT(1) DEFAULT 1 COMMENT '0 = inactive, 1 = active',
  `allow_combining` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = allow filling an order from multiple lots',
  `allow_multiple`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = allow multiple lots at one warehouse',
  PRIMARY KEY  (`drug_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `eligibility_response`
--

DROP TABLE IF EXISTS `eligibility_response`;
CREATE TABLE `eligibility_response` (
  `response_id` bigint(20) NOT NULL auto_increment,
  `response_description` varchar(255) default NULL,
  `response_status` enum('A','D') NOT NULL default 'A',
  `response_vendor_id` bigint(20) default NULL,
  `response_create_date` date default NULL,
  `response_modify_date` date default NULL,
  PRIMARY KEY  (`response_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `eligibility_verification`
--

DROP TABLE IF EXISTS `eligibility_verification`;
CREATE TABLE `eligibility_verification` (
  `verification_id` bigint(20) NOT NULL auto_increment,
  `response_id` bigint(20) default NULL,
  `insurance_id` bigint(20) default NULL,
  `eligibility_check_date` datetime default NULL,
  `copay` int(11) default NULL,
  `deductible` int(11) default NULL,
  `deductiblemet` enum('Y','N') default 'Y',
  `create_date` date default NULL,
  PRIMARY KEY  (`verification_id`),
  KEY `insurance_id` (`insurance_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `employer_data`
-- 

DROP TABLE IF EXISTS `employer_data`;
CREATE TABLE `employer_data` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `street` varchar(255) default NULL,
  `postal_code` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(255) default NULL,
  `country` varchar(255) default NULL,
  `date` datetime default NULL,
  `pid` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `enc_category_map`
--
-- Mapping of rule encounter categories to category ids from the event category in openemr_postcalendar_categories
--

DROP TABLE IF EXISTS `enc_category_map`;
CREATE TABLE `enc_category_map` (
  `rule_enc_id` varchar(31) NOT NULL DEFAULT '' COMMENT 'encounter id from rule_enc_types list in list_options',
  `main_cat_id` int(11) NOT NULL DEFAULT 0 COMMENT 'category id from event category in openemr_postcalendar_categories',
  KEY  (`rule_enc_id`,`main_cat_id`)
) ENGINE=MyISAM ;

INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_outpatient', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_outpatient', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_outpatient', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nurs_fac', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nurs_fac', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nurs_fac', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_off_vis', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_off_vis', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_off_vis', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_hea_and_beh', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_hea_and_beh', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_hea_and_beh', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_occ_ther', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_occ_ther', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_occ_ther', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_psych_and_psych', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_psych_and_psych', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_psych_and_psych', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_ser_18_older', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_ser_18_older', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_ser_18_older', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_ser_40_older', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_ser_40_older', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_ser_40_older', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_ind_counsel', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_ind_counsel', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_ind_counsel', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_group_counsel', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_group_counsel', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_group_counsel', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_other_serv', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_other_serv', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pre_med_other_serv', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_out_pcp_obgyn', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_out_pcp_obgyn', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_out_pcp_obgyn', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pregnancy', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pregnancy', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_pregnancy', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nurs_discharge', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nurs_discharge', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nurs_discharge', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_acute_inp_or_ed', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_acute_inp_or_ed', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_acute_inp_or_ed', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nonac_inp_out_or_opth', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nonac_inp_out_or_opth', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_nonac_inp_out_or_opth', 10);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_influenza', 5);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_influenza', 9);
INSERT INTO `enc_category_map` ( `rule_enc_id`, `main_cat_id` ) VALUES ('enc_influenza', 10);

-- --------------------------------------------------------

--
-- Table structure for table `standardized_tables_track`
--

DROP TABLE IF EXISTS `standardized_tables_track`;
CREATE TABLE `standardized_tables_track` (
  `id` int(11) NOT NULL auto_increment,
  `imported_date` datetime default NULL,
  `name` varchar(255) NOT NULL default '' COMMENT 'name of standardized tables such as RXNORM',
  `revision_version` varchar(255) NOT NULL default '' COMMENT 'revision of standardized tables that were imported',
  `revision_date` datetime default NULL COMMENT 'revision of standardized tables that were imported',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `facility`
-- 

DROP TABLE IF EXISTS `facility`;
CREATE TABLE `facility` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `phone` varchar(30) default NULL,
  `fax` varchar(30) default NULL,
  `street` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(50) default NULL,
  `postal_code` varchar(11) default NULL,
  `country_code` varchar(10) default NULL,
  `federal_ein` varchar(15) default NULL,
  `website` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `service_location` tinyint(1) NOT NULL default '1',
  `billing_location` tinyint(1) NOT NULL default '0',
  `accepts_assignment` tinyint(1) NOT NULL default '0',
  `pos_code` tinyint(4) default NULL,
  `x12_sender_id` varchar(25) default NULL,
  `attn` varchar(65) default NULL,
  `domain_identifier` varchar(60) default NULL,
  `facility_npi` varchar(15) default NULL,
  `tax_id_type` VARCHAR(31) NOT NULL DEFAULT '',
  `color` VARCHAR(7) NOT NULL DEFAULT '',
  `primary_business_entity` INT(10) NOT NULL DEFAULT '0' COMMENT '0-Not Set as business entity 1-Set as business entity',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `facility`
-- 

INSERT INTO `facility` VALUES (3, 'Your Clinic Name Here', '000-000-0000', '000-000-0000', '', '', '', '', '', '', NULL, NULL, 1, 1, 0, NULL, '', '', '', '', '','#99FFFF','0');


-- --------------------------------------------------------

-- 
-- Table structure for table `facility_user_ids`
-- 

DROP TABLE IF EXISTS `facility_user_ids`;
CREATE TABLE  `facility_user_ids` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `facility_id` bigint(20) DEFAULT NULL,
  `field_id`    varchar(31)  NOT NULL COMMENT 'references layout_options.field_id',
  `field_value` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`facility_id`,`field_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `fee_sheet_options`
-- 

DROP TABLE IF EXISTS `fee_sheet_options`;
CREATE TABLE `fee_sheet_options` (
  `fs_category` varchar(63) default NULL,
  `fs_option` varchar(63) default NULL,
  `fs_codes` varchar(255) default NULL
) ENGINE=MyISAM;

-- 
-- Dumping data for table `fee_sheet_options`
-- 

INSERT INTO `fee_sheet_options` VALUES ('1New Patient', '1Brief', 'CPT4|99201|');
INSERT INTO `fee_sheet_options` VALUES ('1New Patient', '2Limited', 'CPT4|99202|');
INSERT INTO `fee_sheet_options` VALUES ('1New Patient', '3Detailed', 'CPT4|99203|');
INSERT INTO `fee_sheet_options` VALUES ('1New Patient', '4Extended', 'CPT4|99204|');
INSERT INTO `fee_sheet_options` VALUES ('1New Patient', '5Comprehensive', 'CPT4|99205|');
INSERT INTO `fee_sheet_options` VALUES ('2Established Patient', '1Brief', 'CPT4|99211|');
INSERT INTO `fee_sheet_options` VALUES ('2Established Patient', '2Limited', 'CPT4|99212|');
INSERT INTO `fee_sheet_options` VALUES ('2Established Patient', '3Detailed', 'CPT4|99213|');
INSERT INTO `fee_sheet_options` VALUES ('2Established Patient', '4Extended', 'CPT4|99214|');
INSERT INTO `fee_sheet_options` VALUES ('2Established Patient', '5Comprehensive', 'CPT4|99215|');


-- --------------------------------------------------------

-- 
-- Table structure for table `form_encounter`
-- 

DROP TABLE IF EXISTS `form_encounter`;
CREATE TABLE `form_encounter` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `reason` longtext,
  `facility` longtext,
  `facility_id` int(11) NOT NULL default '0',
  `pid` bigint(20) default NULL,
  `encounter` bigint(20) default NULL,
  `onset_date` datetime default NULL,
  `sensitivity` varchar(30) default NULL,
  `billing_note` text,
  `pc_catid` int(11) NOT NULL default '5' COMMENT 'event category from openemr_postcalendar_categories',
  `last_level_billed` int  NOT NULL DEFAULT 0 COMMENT '0=none, 1=ins1, 2=ins2, etc',
  `last_level_closed` int  NOT NULL DEFAULT 0 COMMENT '0=none, 1=ins1, 2=ins2, etc',
  `last_stmt_date`    date DEFAULT NULL,
  `stmt_count`        int  NOT NULL DEFAULT 0,
  `provider_id` INT(11) DEFAULT '0' COMMENT 'default and main provider for this visit',
  `supervisor_id` INT(11) DEFAULT '0' COMMENT 'supervising provider, if any, for this visit',
  `invoice_refno` varchar(31) NOT NULL DEFAULT '',
  `referral_source` varchar(31) NOT NULL DEFAULT '',
  `billing_facility` INT(11) NOT NULL DEFAULT 0,
  `episode_id` int(11),
  `caregiver` varchar(150) NOT NULL DEFAULT '',
  `time_in` varchar(10) NOT NULL DEFAULT '',
  `time_out` varchar(10) NOT NULL DEFAULT '',
  `billing_units` varchar(50) NOT NULL DEFAULT '',
  `billing_insurance` varchar(10) NOT NULL DEFAULT '',
  `notes_in` varchar(10) NOT NULL DEFAULT '',
  `verified` varchar(10) NOT NULL DEFAULT '',
  `type_of_service` varchar(60) NOT NULL DEFAULT '',
  `modifier_1` varchar(2) NOT NULL DEFAULT '',
  `modifier_2` varchar(2) NOT NULL DEFAULT '',
  `modifier_3` varchar(2) NOT NULL DEFAULT '',
  `modifier_4` varchar(2) NOT NULL DEFAULT '',
  `synergy_id` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `pid_encounter` (`pid`, `encounter`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `form_misc_billing_options`
-- 

DROP TABLE IF EXISTS `form_misc_billing_options`;
CREATE TABLE `form_misc_billing_options` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `pid` bigint(20) default NULL,
  `user` varchar(255) default NULL,
  `groupname` varchar(255) default NULL,
  `authorized` tinyint(4) default NULL,
  `activity` tinyint(4) default NULL,
  `employment_related` tinyint(1) default NULL,
  `auto_accident` tinyint(1) default NULL,
  `accident_state` varchar(2) default NULL,
  `other_accident` tinyint(1) default NULL,
  `outside_lab` tinyint(1) default NULL,
  `lab_amount` decimal(5,2) default NULL,
  `is_unable_to_work` tinyint(1) default NULL,
  `date_initial_treatment` date default NULL,
  `off_work_from` date default NULL,
  `off_work_to` date default NULL,
  `is_hospitalized` tinyint(1) default NULL,
  `hospitalization_date_from` date default NULL,
  `hospitalization_date_to` date default NULL,
  `medicaid_resubmission_code` varchar(10) default NULL,
  `medicaid_original_reference` varchar(15) default NULL,
  `prior_auth_number` varchar(20) default NULL,
  `comments` varchar(255) default NULL,
  `replacement_claim` tinyint(1) default 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `form_vitals`
-- 

DROP TABLE IF EXISTS `form_vitals`;
CREATE TABLE `form_vitals` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `pid` bigint(20) default '0',
  `user` varchar(255) default NULL,
  `groupname` varchar(255) default NULL,
  `authorized` tinyint(4) default '0',
  `activity` tinyint(4) default '0',
  `bps` varchar(40) default NULL,
  `bpd` varchar(40) default NULL,
  `weight` float(5,2) default '0.00',
  `height` float(5,2) default '0.00',
  `temperature` float(5,2) default '0.00',
  `temp_method` varchar(255) default NULL,
  `pulse` float(5,2) default '0.00',
  `respiration` float(5,2) default '0.00',
  `note` varchar(255) default NULL,
  `BMI` float(4,1) default '0.0',
  `BMI_status` varchar(255) default NULL,
  `waist_circ` float(5,2) default '0.00',
  `head_circ` float(4,2) default '0.00',
  `oxygen_saturation` float(5,2) default '0.00',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `forms`
-- 

DROP TABLE IF EXISTS `forms`;
CREATE TABLE `forms` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `encounter` bigint(20) default NULL,
  `form_name` longtext,
  `form_id` bigint(20) default NULL,
  `pid` bigint(20) default NULL,
  `user` varchar(255) default NULL,
  `groupname` varchar(255) default NULL,
  `authorized` tinyint(4) default NULL,
  `deleted` tinyint(4) DEFAULT '0' NOT NULL COMMENT 'flag indicates form has been deleted',
  `formdir` longtext,
  PRIMARY KEY  (`id`),
  KEY `pid_encounter` (`pid`, `encounter`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `geo_country_reference`
-- 

DROP TABLE IF EXISTS `geo_country_reference`;
CREATE TABLE `geo_country_reference` (
  `countries_id` int(5) NOT NULL auto_increment,
  `countries_name` varchar(64) default NULL,
  `countries_iso_code_2` char(2) NOT NULL default '',
  `countries_iso_code_3` char(3) NOT NULL default '',
  PRIMARY KEY  (`countries_id`),
  KEY `IDX_COUNTRIES_NAME` (`countries_name`)
) ENGINE=MyISAM AUTO_INCREMENT=240 ;

-- 
-- Dumping data for table `geo_country_reference`
-- 

INSERT INTO `geo_country_reference` VALUES (1, 'Afghanistan', 'AF', 'AFG');
INSERT INTO `geo_country_reference` VALUES (2, 'Albania', 'AL', 'ALB');
INSERT INTO `geo_country_reference` VALUES (3, 'Algeria', 'DZ', 'DZA');
INSERT INTO `geo_country_reference` VALUES (4, 'American Samoa', 'AS', 'ASM');
INSERT INTO `geo_country_reference` VALUES (5, 'Andorra', 'AD', 'AND');
INSERT INTO `geo_country_reference` VALUES (6, 'Angola', 'AO', 'AGO');
INSERT INTO `geo_country_reference` VALUES (7, 'Anguilla', 'AI', 'AIA');
INSERT INTO `geo_country_reference` VALUES (8, 'Antarctica', 'AQ', 'ATA');
INSERT INTO `geo_country_reference` VALUES (9, 'Antigua and Barbuda', 'AG', 'ATG');
INSERT INTO `geo_country_reference` VALUES (10, 'Argentina', 'AR', 'ARG');
INSERT INTO `geo_country_reference` VALUES (11, 'Armenia', 'AM', 'ARM');
INSERT INTO `geo_country_reference` VALUES (12, 'Aruba', 'AW', 'ABW');
INSERT INTO `geo_country_reference` VALUES (13, 'Australia', 'AU', 'AUS');
INSERT INTO `geo_country_reference` VALUES (14, 'Austria', 'AT', 'AUT');
INSERT INTO `geo_country_reference` VALUES (15, 'Azerbaijan', 'AZ', 'AZE');
INSERT INTO `geo_country_reference` VALUES (16, 'Bahamas', 'BS', 'BHS');
INSERT INTO `geo_country_reference` VALUES (17, 'Bahrain', 'BH', 'BHR');
INSERT INTO `geo_country_reference` VALUES (18, 'Bangladesh', 'BD', 'BGD');
INSERT INTO `geo_country_reference` VALUES (19, 'Barbados', 'BB', 'BRB');
INSERT INTO `geo_country_reference` VALUES (20, 'Belarus', 'BY', 'BLR');
INSERT INTO `geo_country_reference` VALUES (21, 'Belgium', 'BE', 'BEL');
INSERT INTO `geo_country_reference` VALUES (22, 'Belize', 'BZ', 'BLZ');
INSERT INTO `geo_country_reference` VALUES (23, 'Benin', 'BJ', 'BEN');
INSERT INTO `geo_country_reference` VALUES (24, 'Bermuda', 'BM', 'BMU');
INSERT INTO `geo_country_reference` VALUES (25, 'Bhutan', 'BT', 'BTN');
INSERT INTO `geo_country_reference` VALUES (26, 'Bolivia', 'BO', 'BOL');
INSERT INTO `geo_country_reference` VALUES (27, 'Bosnia and Herzegowina', 'BA', 'BIH');
INSERT INTO `geo_country_reference` VALUES (28, 'Botswana', 'BW', 'BWA');
INSERT INTO `geo_country_reference` VALUES (29, 'Bouvet Island', 'BV', 'BVT');
INSERT INTO `geo_country_reference` VALUES (30, 'Brazil', 'BR', 'BRA');
INSERT INTO `geo_country_reference` VALUES (31, 'British Indian Ocean Territory', 'IO', 'IOT');
INSERT INTO `geo_country_reference` VALUES (32, 'Brunei Darussalam', 'BN', 'BRN');
INSERT INTO `geo_country_reference` VALUES (33, 'Bulgaria', 'BG', 'BGR');
INSERT INTO `geo_country_reference` VALUES (34, 'Burkina Faso', 'BF', 'BFA');
INSERT INTO `geo_country_reference` VALUES (35, 'Burundi', 'BI', 'BDI');
INSERT INTO `geo_country_reference` VALUES (36, 'Cambodia', 'KH', 'KHM');
INSERT INTO `geo_country_reference` VALUES (37, 'Cameroon', 'CM', 'CMR');
INSERT INTO `geo_country_reference` VALUES (38, 'Canada', 'CA', 'CAN');
INSERT INTO `geo_country_reference` VALUES (39, 'Cape Verde', 'CV', 'CPV');
INSERT INTO `geo_country_reference` VALUES (40, 'Cayman Islands', 'KY', 'CYM');
INSERT INTO `geo_country_reference` VALUES (41, 'Central African Republic', 'CF', 'CAF');
INSERT INTO `geo_country_reference` VALUES (42, 'Chad', 'TD', 'TCD');
INSERT INTO `geo_country_reference` VALUES (43, 'Chile', 'CL', 'CHL');
INSERT INTO `geo_country_reference` VALUES (44, 'China', 'CN', 'CHN');
INSERT INTO `geo_country_reference` VALUES (45, 'Christmas Island', 'CX', 'CXR');
INSERT INTO `geo_country_reference` VALUES (46, 'Cocos (Keeling) Islands', 'CC', 'CCK');
INSERT INTO `geo_country_reference` VALUES (47, 'Colombia', 'CO', 'COL');
INSERT INTO `geo_country_reference` VALUES (48, 'Comoros', 'KM', 'COM');
INSERT INTO `geo_country_reference` VALUES (49, 'Congo', 'CG', 'COG');
INSERT INTO `geo_country_reference` VALUES (50, 'Cook Islands', 'CK', 'COK');
INSERT INTO `geo_country_reference` VALUES (51, 'Costa Rica', 'CR', 'CRI');
INSERT INTO `geo_country_reference` VALUES (52, 'Cote D Ivoire', 'CI', 'CIV');
INSERT INTO `geo_country_reference` VALUES (53, 'Croatia', 'HR', 'HRV');
INSERT INTO `geo_country_reference` VALUES (54, 'Cuba', 'CU', 'CUB');
INSERT INTO `geo_country_reference` VALUES (55, 'Cyprus', 'CY', 'CYP');
INSERT INTO `geo_country_reference` VALUES (56, 'Czech Republic', 'CZ', 'CZE');
INSERT INTO `geo_country_reference` VALUES (57, 'Denmark', 'DK', 'DNK');
INSERT INTO `geo_country_reference` VALUES (58, 'Djibouti', 'DJ', 'DJI');
INSERT INTO `geo_country_reference` VALUES (59, 'Dominica', 'DM', 'DMA');
INSERT INTO `geo_country_reference` VALUES (60, 'Dominican Republic', 'DO', 'DOM');
INSERT INTO `geo_country_reference` VALUES (61, 'East Timor', 'TP', 'TMP');
INSERT INTO `geo_country_reference` VALUES (62, 'Ecuador', 'EC', 'ECU');
INSERT INTO `geo_country_reference` VALUES (63, 'Egypt', 'EG', 'EGY');
INSERT INTO `geo_country_reference` VALUES (64, 'El Salvador', 'SV', 'SLV');
INSERT INTO `geo_country_reference` VALUES (65, 'Equatorial Guinea', 'GQ', 'GNQ');
INSERT INTO `geo_country_reference` VALUES (66, 'Eritrea', 'ER', 'ERI');
INSERT INTO `geo_country_reference` VALUES (67, 'Estonia', 'EE', 'EST');
INSERT INTO `geo_country_reference` VALUES (68, 'Ethiopia', 'ET', 'ETH');
INSERT INTO `geo_country_reference` VALUES (69, 'Falkland Islands (Malvinas)', 'FK', 'FLK');
INSERT INTO `geo_country_reference` VALUES (70, 'Faroe Islands', 'FO', 'FRO');
INSERT INTO `geo_country_reference` VALUES (71, 'Fiji', 'FJ', 'FJI');
INSERT INTO `geo_country_reference` VALUES (72, 'Finland', 'FI', 'FIN');
INSERT INTO `geo_country_reference` VALUES (73, 'France', 'FR', 'FRA');
INSERT INTO `geo_country_reference` VALUES (74, 'France, MEtropolitan', 'FX', 'FXX');
INSERT INTO `geo_country_reference` VALUES (75, 'French Guiana', 'GF', 'GUF');
INSERT INTO `geo_country_reference` VALUES (76, 'French Polynesia', 'PF', 'PYF');
INSERT INTO `geo_country_reference` VALUES (77, 'French Southern Territories', 'TF', 'ATF');
INSERT INTO `geo_country_reference` VALUES (78, 'Gabon', 'GA', 'GAB');
INSERT INTO `geo_country_reference` VALUES (79, 'Gambia', 'GM', 'GMB');
INSERT INTO `geo_country_reference` VALUES (80, 'Georgia', 'GE', 'GEO');
INSERT INTO `geo_country_reference` VALUES (81, 'Germany', 'DE', 'DEU');
INSERT INTO `geo_country_reference` VALUES (82, 'Ghana', 'GH', 'GHA');
INSERT INTO `geo_country_reference` VALUES (83, 'Gibraltar', 'GI', 'GIB');
INSERT INTO `geo_country_reference` VALUES (84, 'Greece', 'GR', 'GRC');
INSERT INTO `geo_country_reference` VALUES (85, 'Greenland', 'GL', 'GRL');
INSERT INTO `geo_country_reference` VALUES (86, 'Grenada', 'GD', 'GRD');
INSERT INTO `geo_country_reference` VALUES (87, 'Guadeloupe', 'GP', 'GLP');
INSERT INTO `geo_country_reference` VALUES (88, 'Guam', 'GU', 'GUM');
INSERT INTO `geo_country_reference` VALUES (89, 'Guatemala', 'GT', 'GTM');
INSERT INTO `geo_country_reference` VALUES (90, 'Guinea', 'GN', 'GIN');
INSERT INTO `geo_country_reference` VALUES (91, 'Guinea-bissau', 'GW', 'GNB');
INSERT INTO `geo_country_reference` VALUES (92, 'Guyana', 'GY', 'GUY');
INSERT INTO `geo_country_reference` VALUES (93, 'Haiti', 'HT', 'HTI');
INSERT INTO `geo_country_reference` VALUES (94, 'Heard and Mc Donald Islands', 'HM', 'HMD');
INSERT INTO `geo_country_reference` VALUES (95, 'Honduras', 'HN', 'HND');
INSERT INTO `geo_country_reference` VALUES (96, 'Hong Kong', 'HK', 'HKG');
INSERT INTO `geo_country_reference` VALUES (97, 'Hungary', 'HU', 'HUN');
INSERT INTO `geo_country_reference` VALUES (98, 'Iceland', 'IS', 'ISL');
INSERT INTO `geo_country_reference` VALUES (99, 'India', 'IN', 'IND');
INSERT INTO `geo_country_reference` VALUES (100, 'Indonesia', 'ID', 'IDN');
INSERT INTO `geo_country_reference` VALUES (101, 'Iran (Islamic Republic of)', 'IR', 'IRN');
INSERT INTO `geo_country_reference` VALUES (102, 'Iraq', 'IQ', 'IRQ');
INSERT INTO `geo_country_reference` VALUES (103, 'Ireland', 'IE', 'IRL');
INSERT INTO `geo_country_reference` VALUES (104, 'Israel', 'IL', 'ISR');
INSERT INTO `geo_country_reference` VALUES (105, 'Italy', 'IT', 'ITA');
INSERT INTO `geo_country_reference` VALUES (106, 'Jamaica', 'JM', 'JAM');
INSERT INTO `geo_country_reference` VALUES (107, 'Japan', 'JP', 'JPN');
INSERT INTO `geo_country_reference` VALUES (108, 'Jordan', 'JO', 'JOR');
INSERT INTO `geo_country_reference` VALUES (109, 'Kazakhstan', 'KZ', 'KAZ');
INSERT INTO `geo_country_reference` VALUES (110, 'Kenya', 'KE', 'KEN');
INSERT INTO `geo_country_reference` VALUES (111, 'Kiribati', 'KI', 'KIR');
INSERT INTO `geo_country_reference` VALUES (112, 'Korea, Democratic Peoples Republic of', 'KP', 'PRK');
INSERT INTO `geo_country_reference` VALUES (113, 'Korea, Republic of', 'KR', 'KOR');
INSERT INTO `geo_country_reference` VALUES (114, 'Kuwait', 'KW', 'KWT');
INSERT INTO `geo_country_reference` VALUES (115, 'Kyrgyzstan', 'KG', 'KGZ');
INSERT INTO `geo_country_reference` VALUES (116, 'Lao Peoples Democratic Republic', 'LA', 'LAO');
INSERT INTO `geo_country_reference` VALUES (117, 'Latvia', 'LV', 'LVA');
INSERT INTO `geo_country_reference` VALUES (118, 'Lebanon', 'LB', 'LBN');
INSERT INTO `geo_country_reference` VALUES (119, 'Lesotho', 'LS', 'LSO');
INSERT INTO `geo_country_reference` VALUES (120, 'Liberia', 'LR', 'LBR');
INSERT INTO `geo_country_reference` VALUES (121, 'Libyan Arab Jamahiriya', 'LY', 'LBY');
INSERT INTO `geo_country_reference` VALUES (122, 'Liechtenstein', 'LI', 'LIE');
INSERT INTO `geo_country_reference` VALUES (123, 'Lithuania', 'LT', 'LTU');
INSERT INTO `geo_country_reference` VALUES (124, 'Luxembourg', 'LU', 'LUX');
INSERT INTO `geo_country_reference` VALUES (125, 'Macau', 'MO', 'MAC');
INSERT INTO `geo_country_reference` VALUES (126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD');
INSERT INTO `geo_country_reference` VALUES (127, 'Madagascar', 'MG', 'MDG');
INSERT INTO `geo_country_reference` VALUES (128, 'Malawi', 'MW', 'MWI');
INSERT INTO `geo_country_reference` VALUES (129, 'Malaysia', 'MY', 'MYS');
INSERT INTO `geo_country_reference` VALUES (130, 'Maldives', 'MV', 'MDV');
INSERT INTO `geo_country_reference` VALUES (131, 'Mali', 'ML', 'MLI');
INSERT INTO `geo_country_reference` VALUES (132, 'Malta', 'MT', 'MLT');
INSERT INTO `geo_country_reference` VALUES (133, 'Marshall Islands', 'MH', 'MHL');
INSERT INTO `geo_country_reference` VALUES (134, 'Martinique', 'MQ', 'MTQ');
INSERT INTO `geo_country_reference` VALUES (135, 'Mauritania', 'MR', 'MRT');
INSERT INTO `geo_country_reference` VALUES (136, 'Mauritius', 'MU', 'MUS');
INSERT INTO `geo_country_reference` VALUES (137, 'Mayotte', 'YT', 'MYT');
INSERT INTO `geo_country_reference` VALUES (138, 'Mexico', 'MX', 'MEX');
INSERT INTO `geo_country_reference` VALUES (139, 'Micronesia, Federated States of', 'FM', 'FSM');
INSERT INTO `geo_country_reference` VALUES (140, 'Moldova, Republic of', 'MD', 'MDA');
INSERT INTO `geo_country_reference` VALUES (141, 'Monaco', 'MC', 'MCO');
INSERT INTO `geo_country_reference` VALUES (142, 'Mongolia', 'MN', 'MNG');
INSERT INTO `geo_country_reference` VALUES (143, 'Montserrat', 'MS', 'MSR');
INSERT INTO `geo_country_reference` VALUES (144, 'Morocco', 'MA', 'MAR');
INSERT INTO `geo_country_reference` VALUES (145, 'Mozambique', 'MZ', 'MOZ');
INSERT INTO `geo_country_reference` VALUES (146, 'Myanmar', 'MM', 'MMR');
INSERT INTO `geo_country_reference` VALUES (147, 'Namibia', 'NA', 'NAM');
INSERT INTO `geo_country_reference` VALUES (148, 'Nauru', 'NR', 'NRU');
INSERT INTO `geo_country_reference` VALUES (149, 'Nepal', 'NP', 'NPL');
INSERT INTO `geo_country_reference` VALUES (150, 'Netherlands', 'NL', 'NLD');
INSERT INTO `geo_country_reference` VALUES (151, 'Netherlands Antilles', 'AN', 'ANT');
INSERT INTO `geo_country_reference` VALUES (152, 'New Caledonia', 'NC', 'NCL');
INSERT INTO `geo_country_reference` VALUES (153, 'New Zealand', 'NZ', 'NZL');
INSERT INTO `geo_country_reference` VALUES (154, 'Nicaragua', 'NI', 'NIC');
INSERT INTO `geo_country_reference` VALUES (155, 'Niger', 'NE', 'NER');
INSERT INTO `geo_country_reference` VALUES (156, 'Nigeria', 'NG', 'NGA');
INSERT INTO `geo_country_reference` VALUES (157, 'Niue', 'NU', 'NIU');
INSERT INTO `geo_country_reference` VALUES (158, 'Norfolk Island', 'NF', 'NFK');
INSERT INTO `geo_country_reference` VALUES (159, 'Northern Mariana Islands', 'MP', 'MNP');
INSERT INTO `geo_country_reference` VALUES (160, 'Norway', 'NO', 'NOR');
INSERT INTO `geo_country_reference` VALUES (161, 'Oman', 'OM', 'OMN');
INSERT INTO `geo_country_reference` VALUES (162, 'Pakistan', 'PK', 'PAK');
INSERT INTO `geo_country_reference` VALUES (163, 'Palau', 'PW', 'PLW');
INSERT INTO `geo_country_reference` VALUES (164, 'Panama', 'PA', 'PAN');
INSERT INTO `geo_country_reference` VALUES (165, 'Papua New Guinea', 'PG', 'PNG');
INSERT INTO `geo_country_reference` VALUES (166, 'Paraguay', 'PY', 'PRY');
INSERT INTO `geo_country_reference` VALUES (167, 'Peru', 'PE', 'PER');
INSERT INTO `geo_country_reference` VALUES (168, 'Philippines', 'PH', 'PHL');
INSERT INTO `geo_country_reference` VALUES (169, 'Pitcairn', 'PN', 'PCN');
INSERT INTO `geo_country_reference` VALUES (170, 'Poland', 'PL', 'POL');
INSERT INTO `geo_country_reference` VALUES (171, 'Portugal', 'PT', 'PRT');
INSERT INTO `geo_country_reference` VALUES (172, 'Puerto Rico', 'PR', 'PRI');
INSERT INTO `geo_country_reference` VALUES (173, 'Qatar', 'QA', 'QAT');
INSERT INTO `geo_country_reference` VALUES (174, 'Reunion', 'RE', 'REU');
INSERT INTO `geo_country_reference` VALUES (175, 'Romania', 'RO', 'ROM');
INSERT INTO `geo_country_reference` VALUES (176, 'Russian Federation', 'RU', 'RUS');
INSERT INTO `geo_country_reference` VALUES (177, 'Rwanda', 'RW', 'RWA');
INSERT INTO `geo_country_reference` VALUES (178, 'Saint Kitts and Nevis', 'KN', 'KNA');
INSERT INTO `geo_country_reference` VALUES (179, 'Saint Lucia', 'LC', 'LCA');
INSERT INTO `geo_country_reference` VALUES (180, 'Saint Vincent and the Grenadines', 'VC', 'VCT');
INSERT INTO `geo_country_reference` VALUES (181, 'Samoa', 'WS', 'WSM');
INSERT INTO `geo_country_reference` VALUES (182, 'San Marino', 'SM', 'SMR');
INSERT INTO `geo_country_reference` VALUES (183, 'Sao Tome and Principe', 'ST', 'STP');
INSERT INTO `geo_country_reference` VALUES (184, 'Saudi Arabia', 'SA', 'SAU');
INSERT INTO `geo_country_reference` VALUES (185, 'Senegal', 'SN', 'SEN');
INSERT INTO `geo_country_reference` VALUES (186, 'Seychelles', 'SC', 'SYC');
INSERT INTO `geo_country_reference` VALUES (187, 'Sierra Leone', 'SL', 'SLE');
INSERT INTO `geo_country_reference` VALUES (188, 'Singapore', 'SG', 'SGP');
INSERT INTO `geo_country_reference` VALUES (189, 'Slovakia (Slovak Republic)', 'SK', 'SVK');
INSERT INTO `geo_country_reference` VALUES (190, 'Slovenia', 'SI', 'SVN');
INSERT INTO `geo_country_reference` VALUES (191, 'Solomon Islands', 'SB', 'SLB');
INSERT INTO `geo_country_reference` VALUES (192, 'Somalia', 'SO', 'SOM');
INSERT INTO `geo_country_reference` VALUES (193, 'south Africa', 'ZA', 'ZAF');
INSERT INTO `geo_country_reference` VALUES (194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS');
INSERT INTO `geo_country_reference` VALUES (195, 'Spain', 'ES', 'ESP');
INSERT INTO `geo_country_reference` VALUES (196, 'Sri Lanka', 'LK', 'LKA');
INSERT INTO `geo_country_reference` VALUES (197, 'St. Helena', 'SH', 'SHN');
INSERT INTO `geo_country_reference` VALUES (198, 'St. Pierre and Miquelon', 'PM', 'SPM');
INSERT INTO `geo_country_reference` VALUES (199, 'Sudan', 'SD', 'SDN');
INSERT INTO `geo_country_reference` VALUES (200, 'Suriname', 'SR', 'SUR');
INSERT INTO `geo_country_reference` VALUES (201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM');
INSERT INTO `geo_country_reference` VALUES (202, 'Swaziland', 'SZ', 'SWZ');
INSERT INTO `geo_country_reference` VALUES (203, 'Sweden', 'SE', 'SWE');
INSERT INTO `geo_country_reference` VALUES (204, 'Switzerland', 'CH', 'CHE');
INSERT INTO `geo_country_reference` VALUES (205, 'Syrian Arab Republic', 'SY', 'SYR');
INSERT INTO `geo_country_reference` VALUES (206, 'Taiwan, Province of China', 'TW', 'TWN');
INSERT INTO `geo_country_reference` VALUES (207, 'Tajikistan', 'TJ', 'TJK');
INSERT INTO `geo_country_reference` VALUES (208, 'Tanzania, United Republic of', 'TZ', 'TZA');
INSERT INTO `geo_country_reference` VALUES (209, 'Thailand', 'TH', 'THA');
INSERT INTO `geo_country_reference` VALUES (210, 'Togo', 'TG', 'TGO');
INSERT INTO `geo_country_reference` VALUES (211, 'Tokelau', 'TK', 'TKL');
INSERT INTO `geo_country_reference` VALUES (212, 'Tonga', 'TO', 'TON');
INSERT INTO `geo_country_reference` VALUES (213, 'Trinidad and Tobago', 'TT', 'TTO');
INSERT INTO `geo_country_reference` VALUES (214, 'Tunisia', 'TN', 'TUN');
INSERT INTO `geo_country_reference` VALUES (215, 'Turkey', 'TR', 'TUR');
INSERT INTO `geo_country_reference` VALUES (216, 'Turkmenistan', 'TM', 'TKM');
INSERT INTO `geo_country_reference` VALUES (217, 'Turks and Caicos Islands', 'TC', 'TCA');
INSERT INTO `geo_country_reference` VALUES (218, 'Tuvalu', 'TV', 'TUV');
INSERT INTO `geo_country_reference` VALUES (219, 'Uganda', 'UG', 'UGA');
INSERT INTO `geo_country_reference` VALUES (220, 'Ukraine', 'UA', 'UKR');
INSERT INTO `geo_country_reference` VALUES (221, 'United Arab Emirates', 'AE', 'ARE');
INSERT INTO `geo_country_reference` VALUES (222, 'United Kingdom', 'GB', 'GBR');
INSERT INTO `geo_country_reference` VALUES (223, 'United States', 'US', 'USA');
INSERT INTO `geo_country_reference` VALUES (224, 'United States Minor Outlying Islands', 'UM', 'UMI');
INSERT INTO `geo_country_reference` VALUES (225, 'Uruguay', 'UY', 'URY');
INSERT INTO `geo_country_reference` VALUES (226, 'Uzbekistan', 'UZ', 'UZB');
INSERT INTO `geo_country_reference` VALUES (227, 'Vanuatu', 'VU', 'VUT');
INSERT INTO `geo_country_reference` VALUES (228, 'Vatican City State (Holy See)', 'VA', 'VAT');
INSERT INTO `geo_country_reference` VALUES (229, 'Venezuela', 'VE', 'VEN');
INSERT INTO `geo_country_reference` VALUES (230, 'Viet Nam', 'VN', 'VNM');
INSERT INTO `geo_country_reference` VALUES (231, 'Virgin Islands (British)', 'VG', 'VGB');
INSERT INTO `geo_country_reference` VALUES (232, 'Virgin Islands (U.S.)', 'VI', 'VIR');
INSERT INTO `geo_country_reference` VALUES (233, 'Wallis and Futuna Islands', 'WF', 'WLF');
INSERT INTO `geo_country_reference` VALUES (234, 'Western Sahara', 'EH', 'ESH');
INSERT INTO `geo_country_reference` VALUES (235, 'Yemen', 'YE', 'YEM');
INSERT INTO `geo_country_reference` VALUES (236, 'Yugoslavia', 'YU', 'YUG');
INSERT INTO `geo_country_reference` VALUES (237, 'Zaire', 'ZR', 'ZAR');
INSERT INTO `geo_country_reference` VALUES (238, 'Zambia', 'ZM', 'ZMB');
INSERT INTO `geo_country_reference` VALUES (239, 'Zimbabwe', 'ZW', 'ZWE');

-- --------------------------------------------------------

-- 
-- Table structure for table `geo_zone_reference`
-- 

DROP TABLE IF EXISTS `geo_zone_reference`;
CREATE TABLE `geo_zone_reference` (
  `zone_id` int(5) NOT NULL auto_increment,
  `zone_country_id` int(5) NOT NULL default '0',
  `zone_code` varchar(5) default NULL,
  `zone_name` varchar(32) default NULL,
  PRIMARY KEY  (`zone_id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 ;

-- 
-- Dumping data for table `geo_zone_reference`
-- 

INSERT INTO `geo_zone_reference` VALUES (1, 223, 'AL', 'Alabama');
INSERT INTO `geo_zone_reference` VALUES (2, 223, 'AK', 'Alaska');
INSERT INTO `geo_zone_reference` VALUES (3, 223, 'AS', 'American Samoa');
INSERT INTO `geo_zone_reference` VALUES (4, 223, 'AZ', 'Arizona');
INSERT INTO `geo_zone_reference` VALUES (5, 223, 'AR', 'Arkansas');
INSERT INTO `geo_zone_reference` VALUES (6, 223, 'AF', 'Armed Forces Africa');
INSERT INTO `geo_zone_reference` VALUES (7, 223, 'AA', 'Armed Forces Americas');
INSERT INTO `geo_zone_reference` VALUES (8, 223, 'AC', 'Armed Forces Canada');
INSERT INTO `geo_zone_reference` VALUES (9, 223, 'AE', 'Armed Forces Europe');
INSERT INTO `geo_zone_reference` VALUES (10, 223, 'AM', 'Armed Forces Middle East');
INSERT INTO `geo_zone_reference` VALUES (11, 223, 'AP', 'Armed Forces Pacific');
INSERT INTO `geo_zone_reference` VALUES (12, 223, 'CA', 'California');
INSERT INTO `geo_zone_reference` VALUES (13, 223, 'CO', 'Colorado');
INSERT INTO `geo_zone_reference` VALUES (14, 223, 'CT', 'Connecticut');
INSERT INTO `geo_zone_reference` VALUES (15, 223, 'DE', 'Delaware');
INSERT INTO `geo_zone_reference` VALUES (16, 223, 'DC', 'District of Columbia');
INSERT INTO `geo_zone_reference` VALUES (17, 223, 'FM', 'Federated States Of Micronesia');
INSERT INTO `geo_zone_reference` VALUES (18, 223, 'FL', 'Florida');
INSERT INTO `geo_zone_reference` VALUES (19, 223, 'GA', 'Georgia');
INSERT INTO `geo_zone_reference` VALUES (20, 223, 'GU', 'Guam');
INSERT INTO `geo_zone_reference` VALUES (21, 223, 'HI', 'Hawaii');
INSERT INTO `geo_zone_reference` VALUES (22, 223, 'ID', 'Idaho');
INSERT INTO `geo_zone_reference` VALUES (23, 223, 'IL', 'Illinois');
INSERT INTO `geo_zone_reference` VALUES (24, 223, 'IN', 'Indiana');
INSERT INTO `geo_zone_reference` VALUES (25, 223, 'IA', 'Iowa');
INSERT INTO `geo_zone_reference` VALUES (26, 223, 'KS', 'Kansas');
INSERT INTO `geo_zone_reference` VALUES (27, 223, 'KY', 'Kentucky');
INSERT INTO `geo_zone_reference` VALUES (28, 223, 'LA', 'Louisiana');
INSERT INTO `geo_zone_reference` VALUES (29, 223, 'ME', 'Maine');
INSERT INTO `geo_zone_reference` VALUES (30, 223, 'MH', 'Marshall Islands');
INSERT INTO `geo_zone_reference` VALUES (31, 223, 'MD', 'Maryland');
INSERT INTO `geo_zone_reference` VALUES (32, 223, 'MA', 'Massachusetts');
INSERT INTO `geo_zone_reference` VALUES (33, 223, 'MI', 'Michigan');
INSERT INTO `geo_zone_reference` VALUES (34, 223, 'MN', 'Minnesota');
INSERT INTO `geo_zone_reference` VALUES (35, 223, 'MS', 'Mississippi');
INSERT INTO `geo_zone_reference` VALUES (36, 223, 'MO', 'Missouri');
INSERT INTO `geo_zone_reference` VALUES (37, 223, 'MT', 'Montana');
INSERT INTO `geo_zone_reference` VALUES (38, 223, 'NE', 'Nebraska');
INSERT INTO `geo_zone_reference` VALUES (39, 223, 'NV', 'Nevada');
INSERT INTO `geo_zone_reference` VALUES (40, 223, 'NH', 'New Hampshire');
INSERT INTO `geo_zone_reference` VALUES (41, 223, 'NJ', 'New Jersey');
INSERT INTO `geo_zone_reference` VALUES (42, 223, 'NM', 'New Mexico');
INSERT INTO `geo_zone_reference` VALUES (43, 223, 'NY', 'New York');
INSERT INTO `geo_zone_reference` VALUES (44, 223, 'NC', 'North Carolina');
INSERT INTO `geo_zone_reference` VALUES (45, 223, 'ND', 'North Dakota');
INSERT INTO `geo_zone_reference` VALUES (46, 223, 'MP', 'Northern Mariana Islands');
INSERT INTO `geo_zone_reference` VALUES (47, 223, 'OH', 'Ohio');
INSERT INTO `geo_zone_reference` VALUES (48, 223, 'OK', 'Oklahoma');
INSERT INTO `geo_zone_reference` VALUES (49, 223, 'OR', 'Oregon');
INSERT INTO `geo_zone_reference` VALUES (50, 223, 'PW', 'Palau');
INSERT INTO `geo_zone_reference` VALUES (51, 223, 'PA', 'Pennsylvania');
INSERT INTO `geo_zone_reference` VALUES (52, 223, 'PR', 'Puerto Rico');
INSERT INTO `geo_zone_reference` VALUES (53, 223, 'RI', 'Rhode Island');
INSERT INTO `geo_zone_reference` VALUES (54, 223, 'SC', 'South Carolina');
INSERT INTO `geo_zone_reference` VALUES (55, 223, 'SD', 'South Dakota');
INSERT INTO `geo_zone_reference` VALUES (56, 223, 'TN', 'Tenessee');
INSERT INTO `geo_zone_reference` VALUES (57, 223, 'TX', 'Texas');
INSERT INTO `geo_zone_reference` VALUES (58, 223, 'UT', 'Utah');
INSERT INTO `geo_zone_reference` VALUES (59, 223, 'VT', 'Vermont');
INSERT INTO `geo_zone_reference` VALUES (60, 223, 'VI', 'Virgin Islands');
INSERT INTO `geo_zone_reference` VALUES (61, 223, 'VA', 'Virginia');
INSERT INTO `geo_zone_reference` VALUES (62, 223, 'WA', 'Washington');
INSERT INTO `geo_zone_reference` VALUES (63, 223, 'WV', 'West Virginia');
INSERT INTO `geo_zone_reference` VALUES (64, 223, 'WI', 'Wisconsin');
INSERT INTO `geo_zone_reference` VALUES (65, 223, 'WY', 'Wyoming');
INSERT INTO `geo_zone_reference` VALUES (66, 38, 'AB', 'Alberta');
INSERT INTO `geo_zone_reference` VALUES (67, 38, 'BC', 'British Columbia');
INSERT INTO `geo_zone_reference` VALUES (68, 38, 'MB', 'Manitoba');
INSERT INTO `geo_zone_reference` VALUES (69, 38, 'NF', 'Newfoundland');
INSERT INTO `geo_zone_reference` VALUES (70, 38, 'NB', 'New Brunswick');
INSERT INTO `geo_zone_reference` VALUES (71, 38, 'NS', 'Nova Scotia');
INSERT INTO `geo_zone_reference` VALUES (72, 38, 'NT', 'Northwest Territories');
INSERT INTO `geo_zone_reference` VALUES (73, 38, 'NU', 'Nunavut');
INSERT INTO `geo_zone_reference` VALUES (74, 38, 'ON', 'Ontario');
INSERT INTO `geo_zone_reference` VALUES (75, 38, 'PE', 'Prince Edward Island');
INSERT INTO `geo_zone_reference` VALUES (76, 38, 'QC', 'Quebec');
INSERT INTO `geo_zone_reference` VALUES (77, 38, 'SK', 'Saskatchewan');
INSERT INTO `geo_zone_reference` VALUES (78, 38, 'YT', 'Yukon Territory');
INSERT INTO `geo_zone_reference` VALUES (79, 61, 'QLD', 'Queensland');
INSERT INTO `geo_zone_reference` VALUES (80, 61, 'SA', 'South Australia');
INSERT INTO `geo_zone_reference` VALUES (81, 61, 'ACT', 'Australian Capital Territory');
INSERT INTO `geo_zone_reference` VALUES (82, 61, 'VIC', 'Victoria');

-- --------------------------------------------------------

-- 
-- Table structure for table `groups`
-- 

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` longtext,
  `user` longtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `history_data`
-- 

DROP TABLE IF EXISTS `history_data`;
CREATE TABLE `history_data` (
  `id` bigint(20) NOT NULL auto_increment,
  `coffee` longtext,
  `tobacco` longtext,
  `alcohol` longtext,
  `sleep_patterns` longtext,
  `exercise_patterns` longtext,
  `seatbelt_use` longtext,
  `counseling` longtext,
  `hazardous_activities` longtext,
  `recreational_drugs` longtext,
  `last_breast_exam` varchar(255) default NULL,
  `last_mammogram` varchar(255) default NULL,
  `last_gynocological_exam` varchar(255) default NULL,
  `last_rectal_exam` varchar(255) default NULL,
  `last_prostate_exam` varchar(255) default NULL,
  `last_physical_exam` varchar(255) default NULL,
  `last_sigmoidoscopy_colonoscopy` varchar(255) default NULL,
  `last_ecg` varchar(255) default NULL,
  `last_cardiac_echo` varchar(255) default NULL,
  `last_retinal` varchar(255) default NULL,
  `last_fluvax` varchar(255) default NULL,
  `last_pneuvax` varchar(255) default NULL,
  `last_ldl` varchar(255) default NULL,
  `last_hemoglobin` varchar(255) default NULL,
  `last_psa` varchar(255) default NULL,
  `last_exam_results` varchar(255) default NULL,
  `history_mother` longtext,
  `history_father` longtext,
  `history_siblings` longtext,
  `history_offspring` longtext,
  `history_spouse` longtext,
  `relatives_cancer` longtext,
  `relatives_tuberculosis` longtext,
  `relatives_diabetes` longtext,
  `relatives_high_blood_pressure` longtext,
  `relatives_heart_problems` longtext,
  `relatives_stroke` longtext,
  `relatives_epilepsy` longtext,
  `relatives_mental_illness` longtext,
  `relatives_suicide` longtext,
  `cataract_surgery` datetime default NULL,
  `tonsillectomy` datetime default NULL,
  `cholecystestomy` datetime default NULL,
  `heart_surgery` datetime default NULL,
  `hysterectomy` datetime default NULL,
  `hernia_repair` datetime default NULL,
  `hip_replacement` datetime default NULL,
  `knee_replacement` datetime default NULL,
  `appendectomy` datetime default NULL,
  `date` datetime default NULL,
  `pid` bigint(20) NOT NULL default '0',
  `name_1` varchar(255) default NULL,
  `value_1` varchar(255) default NULL,
  `name_2` varchar(255) default NULL,
  `value_2` varchar(255) default NULL,
  `additional_history` text,
  `exams`      text         NOT NULL DEFAULT '',
  `usertext11` TEXT NOT NULL,
  `usertext12` varchar(255) NOT NULL DEFAULT '',
  `usertext13` varchar(255) NOT NULL DEFAULT '',
  `usertext14` varchar(255) NOT NULL DEFAULT '',
  `usertext15` varchar(255) NOT NULL DEFAULT '',
  `usertext16` varchar(255) NOT NULL DEFAULT '',
  `usertext17` varchar(255) NOT NULL DEFAULT '',
  `usertext18` varchar(255) NOT NULL DEFAULT '',
  `usertext19` varchar(255) NOT NULL DEFAULT '',
  `usertext20` varchar(255) NOT NULL DEFAULT '',
  `usertext21` varchar(255) NOT NULL DEFAULT '',
  `usertext22` varchar(255) NOT NULL DEFAULT '',
  `usertext23` varchar(255) NOT NULL DEFAULT '',
  `usertext24` varchar(255) NOT NULL DEFAULT '',
  `usertext25` varchar(255) NOT NULL DEFAULT '',
  `usertext26` varchar(255) NOT NULL DEFAULT '',
  `usertext27` varchar(255) NOT NULL DEFAULT '',
  `usertext28` varchar(255) NOT NULL DEFAULT '',
  `usertext29` varchar(255) NOT NULL DEFAULT '',
  `usertext30` varchar(255) NOT NULL DEFAULT '',
  `userdate11` date DEFAULT NULL,
  `userdate12` date DEFAULT NULL,
  `userdate13` date DEFAULT NULL,
  `userdate14` date DEFAULT NULL,
  `userdate15` date DEFAULT NULL,
  `userarea11` text NOT NULL DEFAULT '',
  `userarea12` text NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `immunizations`
-- 

DROP TABLE IF EXISTS `immunizations`;
CREATE TABLE `immunizations` (
  `id` bigint(20) NOT NULL auto_increment,
  `patient_id` int(11) default NULL,
  `administered_date` date default NULL,
  `immunization_id` int(11) default NULL,
  `cvx_code` int(11) default NULL,
  `manufacturer` varchar(100) default NULL,
  `lot_number` varchar(50) default NULL,
  `administered_by_id` bigint(20) default NULL,
  `administered_by` VARCHAR( 255 ) default NULL COMMENT 'Alternative to administered_by_id',
  `education_date` date default NULL,
  `vis_date` date default NULL COMMENT 'Date of VIS Statement', 
  `note` text,
  `create_date` datetime default NULL,
  `update_date` timestamp NOT NULL,
  `created_by` bigint(20) default NULL,
  `updated_by` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `insurance_companies`
-- 

DROP TABLE IF EXISTS `insurance_companies`;
CREATE TABLE `insurance_companies` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `attn` varchar(255) default NULL,
  `cms_id` varchar(15) default NULL,
  `freeb_type` tinyint(2) default NULL,
  `x12_receiver_id` varchar(25) default NULL,
  `x12_default_partner_id` int(11) default NULL,
  `alt_cms_id` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `insurance_data`
-- 

DROP TABLE IF EXISTS `insurance_data`;
CREATE TABLE `insurance_data` (
  `id` bigint(20) NOT NULL auto_increment,
  `type` enum('primary','secondary','tertiary') default NULL,
  `provider` varchar(255) default NULL,
  `plan_name` varchar(255) default NULL,
  `policy_number` varchar(255) default NULL,
  `group_number` varchar(255) default NULL,
  `subscriber_lname` varchar(255) default NULL,
  `subscriber_mname` varchar(255) default NULL,
  `subscriber_fname` varchar(255) default NULL,
  `subscriber_relationship` varchar(255) default NULL,
  `subscriber_ss` varchar(255) default NULL,
  `subscriber_DOB` date default NULL,
  `subscriber_street` varchar(255) default NULL,
  `subscriber_postal_code` varchar(255) default NULL,
  `subscriber_city` varchar(255) default NULL,
  `subscriber_state` varchar(255) default NULL,
  `subscriber_country` varchar(255) default NULL,
  `subscriber_phone` varchar(255) default NULL,
  `subscriber_employer` varchar(255) default NULL,
  `subscriber_employer_street` varchar(255) default NULL,
  `subscriber_employer_postal_code` varchar(255) default NULL,
  `subscriber_employer_state` varchar(255) default NULL,
  `subscriber_employer_country` varchar(255) default NULL,
  `subscriber_employer_city` varchar(255) default NULL,
  `copay` varchar(255) default NULL,
  `date` date NOT NULL default '0000-00-00',
  `pid` bigint(20) NOT NULL default '0',
  `subscriber_sex` varchar(25) default NULL,
  `accept_assignment` varchar(5) NOT NULL DEFAULT 'TRUE',
  `policy_type` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `pid_type_date` (`pid`,`type`,`date`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `insurance_numbers`
-- 

DROP TABLE IF EXISTS `insurance_numbers`;
CREATE TABLE `insurance_numbers` (
  `id` int(11) NOT NULL default '0',
  `provider_id` int(11) NOT NULL default '0',
  `insurance_company_id` int(11) default NULL,
  `provider_number` varchar(20) default NULL,
  `rendering_provider_number` varchar(20) default NULL,
  `group_number` varchar(20) default NULL,
  `provider_number_type` varchar(4) default NULL,
  `rendering_provider_number_type` varchar(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `integration_mapping`
-- 

DROP TABLE IF EXISTS `integration_mapping`;
CREATE TABLE `integration_mapping` (
  `id` int(11) NOT NULL default '0',
  `foreign_id` int(11) NOT NULL default '0',
  `foreign_table` varchar(125) default NULL,
  `local_id` int(11) NOT NULL default '0',
  `local_table` varchar(125) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `foreign_id` (`foreign_id`,`foreign_table`,`local_id`,`local_table`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `issue_encounter`
-- 

DROP TABLE IF EXISTS `issue_encounter`;
CREATE TABLE `issue_encounter` (
  `pid` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `encounter` int(11) NOT NULL,
  `resolved` tinyint(1) NOT NULL,
  PRIMARY KEY  (`pid`,`list_id`,`encounter`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `lang_constants`
-- 

DROP TABLE IF EXISTS `lang_constants`;
CREATE TABLE `lang_constants` (
  `cons_id` int(11) NOT NULL auto_increment,
  `constant_name` varchar(255) BINARY default NULL,
  UNIQUE KEY `cons_id` (`cons_id`),
  KEY `constant_name` (`constant_name`)
) ENGINE=MyISAM ;

-- 
-- Table structure for table `lang_definitions`
-- 

DROP TABLE IF EXISTS `lang_definitions`;
CREATE TABLE `lang_definitions` (
  `def_id` int(11) NOT NULL auto_increment,
  `cons_id` int(11) NOT NULL default '0',
  `lang_id` int(11) NOT NULL default '0',
  `definition` mediumtext,
  UNIQUE KEY `def_id` (`def_id`),
  KEY `cons_id` (`cons_id`)
) ENGINE=MyISAM ;

-- 
-- Table structure for table `lang_languages`
-- 

DROP TABLE IF EXISTS `lang_languages`;
CREATE TABLE `lang_languages` (
  `lang_id` int(11) NOT NULL auto_increment,
  `lang_code` char(2) NOT NULL default '',
  `lang_description` varchar(100) default NULL,
  UNIQUE KEY `lang_id` (`lang_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `lang_languages`
-- 

INSERT INTO `lang_languages` VALUES (1, 'en', 'English');

-- --------------------------------------------------------

--
-- Table structure for table `lang_custom`
--

DROP TABLE IF EXISTS `lang_custom`;
CREATE TABLE `lang_custom` (
  `lang_description` varchar(100) NOT NULL default '',
  `lang_code` char(2) NOT NULL default '',
  `constant_name` varchar(255) NOT NULL default '',
  `definition` mediumtext NOT NULL default ''
) ENGINE=MyISAM ;

-- --------------------------------------------------------

-- 
-- Table structure for table `layout_options`
-- 

DROP TABLE IF EXISTS `layout_options`;
CREATE TABLE `layout_options` (
  `form_id` varchar(31) NOT NULL default '',
  `field_id` varchar(31) NOT NULL default '',
  `group_name` varchar(31) NOT NULL default '',
  `title` varchar(63) NOT NULL default '',
  `seq` int(11) NOT NULL default '0',
  `data_type` tinyint(3) NOT NULL default '0',
  `uor` tinyint(1) NOT NULL default '1',
  `fld_length` int(11) NOT NULL default '15',
  `max_length` int(11) NOT NULL default '0',
  `list_id` varchar(31) NOT NULL default '',
  `titlecols` tinyint(3) NOT NULL default '1',
  `datacols` tinyint(3) NOT NULL default '1',
  `default_value` varchar(255) NOT NULL default '',
  `edit_options` varchar(36) NOT NULL default '',
  `description` text,
  `fld_rows` int(11) NOT NULL default '0',
  PRIMARY KEY  (`form_id`,`field_id`,`seq`)
) ENGINE=MyISAM;

-- 
-- Dumping data for table `layout_options`
-- 
INSERT INTO `layout_options` VALUES ('DEM', 'title', '1Who', 'Name', 1, 1, 1, 0, 0, 'titles', 1, 1, '', 'N', 'Title', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'fname', '1Who', '', 2, 2, 2, 10, 63, '', 0, 0, '', 'CD', 'First Name', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'mname', '1Who', '', 3, 2, 1, 2, 63, '', 0, 0, '', 'C', 'Middle Name', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'lname', '1Who', '', 4, 2, 2, 10, 63, '', 0, 0, '', 'CD', 'Last Name', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'pubpid', '1Who', 'External ID', 5, 2, 1, 10, 15, '', 1, 1, '', 'ND', 'External identifier', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'DOB', '1Who', 'DOB', 6, 4, 2, 10, 10, '', 1, 1, '', 'D', 'Date of Birth', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'sex', '1Who', 'Sex', 7, 1, 2, 0, 0, 'sex', 1, 1, '', 'N', 'Sex', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'ss', '1Who', 'S.S.', 8, 2, 1, 11, 11, '', 1, 1, '', '', 'Social Security Number', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'drivers_license', '1Who', 'License/ID', 9, 2, 1, 15, 63, '', 1, 1, '', '', 'Drivers License or State ID', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'status', '1Who', 'Marital Status', 10, 1, 1, 0, 0, 'marital', 1, 3, '', '', 'Marital Status', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'genericname1', '1Who', 'User Defined', 34, 2, 1, 15, 63, '', 1, 3, '', '', 'User Defined Field', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'genericval1', '1Who', '', 35, 2, 1, 15, 63, '', 0, 0, '', '', 'User Defined Field', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'genericname2', '1Who', '', 36, 2, 1, 15, 63, '', 0, 0, '', '', 'User Defined Field', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'genericval2', '1Who', '', 37, 2, 1, 15, 63, '', 0, 0, '', '', 'User Defined Field', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'squad', '1Who', 'Squad', 15, 13, 0, 0, 0, '', 1, 3, '', '', 'Squad Membership', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'pricelevel', '1Who', 'Price Level', 16, 1, 0, 0, 0, 'pricelevel', 1, 1, '', '', 'Discount Level', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'street', '2Contact', 'Address 1', 17, 2, 1, 25, 63, '', 1, 1, '', 'C', 'Street and Number', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'city', '2Contact', 'City', 2, 2, 1, 15, 63, '', 1, 1, '', 'C', 'City Name', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'state', '2Contact', 'State', 3, 26, 1, 0, 0, 'state', 1, 1, '', '', 'State/Locality', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'postal_code', '2Contact', 'Postal Code', 4, 2, 1, 6, 63, '', 1, 1, '', '', 'Postal Code', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'country_code', '2Contact', 'Country', 5, 26, 1, 0, 0, 'country', 1, 1, '', '', 'Country', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'mothersname', '2Contact', 'Mother''s Name', 6, 2, 1, 20, 63, '', 1, 1, '', '', '', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'guardiansname', '2Contact', 'Guardian''s Name', 7, 2, 1, 20, 63, '', 1, 1, '', '', '', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'contact_relationship', '2Contact', 'Emergency Contact', 8, 2, 1, 10, 63, '', 1, 1, '', 'C', 'Emergency Contact Person', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'phone_contact', '2Contact', 'Emergency Phone', 9, 2, 1, 20, 63, '', 1, 1, '', 'P', 'Emergency Contact Phone Number', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'phone_home', '2Contact', 'Home Phone', 10, 2, 1, 20, 63, '', 1, 1, '', 'P', 'Home Phone Number', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'phone_biz', '2Contact', 'Work Phone', 11, 2, 1, 20, 63, '', 1, 1, '', 'P', 'Work Phone Number', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'phone_cell', '2Contact', 'Mobile Phone', 12, 2, 1, 20, 63, '', 1, 1, '', 'P', 'Cell Phone Number', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'email', '2Contact', 'Contact Email', 13, 2, 1, 30, 95, '', 1, 1, '', '', 'Contact Email Address', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'providerID', '3Choices', 'Physician', 1, 42, 1, 0, 0, '', 1, 3, '', '', 'Physician', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'ref_providerID', '9Referral', 'Internal Referrer', 2, 11, 1, 0, 0, '', 1, 3, '', '', 'Internal Referrer', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'pharmacy_id', '3Choices', 'Pharmacy', 3, 12, 1, 0, 0, '', 1, 3, '', '', 'Preferred Pharmacy', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'hipaa_notice', '3Choices', 'HIPAA Notice Received', 4, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Did you receive a copy of the HIPAA Notice?', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'hipaa_voice', '3Choices', 'Allow Voice Message', 5, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Allow telephone messages?', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'hipaa_message', '3Choices', 'Leave Message With', 6, 2, 1, 20, 63, '', 1, 1, '', '', 'With whom may we leave a message?', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'hipaa_mail', '3Choices', 'Allow Mail Message', 7, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Allow email messages?', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'hipaa_allowsms'  , '3Choices', 'Allow SMS'  , 8, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Allow SMS (text messages)?', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'hipaa_allowemail', '3Choices', 'Allow Email', 9, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Allow Email?', 0);

INSERT INTO `layout_options` VALUES ('DEM', 'allow_imm_reg_use', '3Choices', 'Allow Immunization Registry Use', 10, 1, 1, 0, 0, 'yesno', 1, 1, '', '', '', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'allow_imm_info_share', '3Choices', 'Allow Immunization Info Sharing', 11, 1, 1, 0, 0, 'yesno', 1, 1, '', '', '', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'allow_health_info_ex', '3Choices', 'Allow Health Information Exchange', 12, 1, 1, 0, 0, 'yesno', 1, 1, '', '', '', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'allow_patient_portal', '3Choices', 'Allow Patient Portal', 13, 1, 1, 0, 0, 'yesno', 1, 1, '', '', '', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'occupation', '4Employer', 'Occupation', 1, 2, 1, 20, 63, '', 1, 1, '', 'C', 'Occupation', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'em_name', '4Employer', 'Employer Name', 2, 2, 1, 20, 63, '', 1, 1, '', 'C', 'Employer Name', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'em_street', '4Employer', 'Employer Address', 3, 2, 1, 25, 63, '', 1, 1, '', 'C', 'Street and Number', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'em_city', '4Employer', 'City', 4, 2, 1, 15, 63, '', 1, 1, '', 'C', 'City Name', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'em_state', '4Employer', 'State', 5, 26, 1, 0, 0, 'state', 1, 1, '', '', 'State/Locality', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'em_postal_code', '4Employer', 'Postal Code', 6, 2, 1, 6, 63, '', 1, 1, '', '', 'Postal Code', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'em_country', '4Employer', 'Country', 7, 26, 1, 0, 0, 'country', 1, 1, '', '', 'Country', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'language', '5Stats', 'Language', 1, 26, 1, 0, 0, 'language', 1, 1, '', '', 'Preferred Language', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'ethnicity', '5Stats', 'Ethnicity', 2, 33, 1, 0, 0, 'ethnicity', 1, 1, '', '', 'Ethnicity', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'race', '5Stats', 'Race', 3, 33, 1, 0, 0, 'race', 1, 1, '', '', 'Race', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'financial_review', '5Stats', 'Financial Review Date', 4, 2, 1, 10, 20, '', 1, 1, '', 'D', 'Financial Review Date', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'family_size', '5Stats', 'Family Size', 4, 2, 1, 20, 63, '', 1, 1, '', '', 'Family Size', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'monthly_income', '5Stats', 'Monthly Income', 5, 2, 1, 20, 63, '', 1, 1, '', '', 'Monthly Income', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'homeless', '5Stats', 'Homeless, etc.', 6, 2, 1, 20, 63, '', 1, 1, '', '', 'Homeless or similar?', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'interpretter', '5Stats', 'Interpreter', 7, 2, 1, 20, 63, '', 1, 1, '', '', 'Interpreter needed?', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'migrantseasonal', '5Stats', 'Migrant/Seasonal', 8, 2, 1, 20, 63, '', 1, 1, '', '', 'Migrant or seasonal worker?', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'contrastart', '5Stats', 'Contraceptives Start',9,4,0,10,10,'',1,1,'','','Date contraceptive services initially provided', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'referral_source', '9Referral', 'Referral Source',8, 26, 1, 0, 0, 'refsource', 1, 3, '', '1', 'How did they hear about us', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'vfc', '5Stats', 'VFC', 12, 1, 1, 20, 0, 'eligibility', 1, 1, '', '', 'Eligibility status for Vaccine for Children supplied vaccine', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'deceased_date', '6Misc', 'Date Deceased', 1, 4, 1, 20, 20, '', 1, 3, '', 'D', 'If person is deceased, then enter date of death.', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'deceased_reason', '6Misc', 'Reason Deceased', 2, 2, 1, 30, 255, '', 1, 3, '', '', 'Reason for Death', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'usertext1', '6Misc', 'User Defined Text 1', 3, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'usertext2', '6Misc', 'User Defined Text 2', 4, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'usertext3', '6Misc', 'User Defined Text 3', 5,2,0,10,63,'',1,1,'','','User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'usertext4', '6Misc', 'User Defined Text 4', 6,2,0,10,63,'',1,1,'','','User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'usertext5', '6Misc', 'User Defined Text 5', 7,2,0,10,63,'',1,1,'','','User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'usertext6', '6Misc', 'User Defined Text 6', 8,2,0,10,63,'',1,1,'','','User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'usertext7', '6Misc', 'User Defined Text 7', 9,2,0,10,63,'',1,1,'','','User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'usertext8', '6Misc', 'User Defined Text 8',10,2,0,10,63,'',1,1,'','','User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'userlist1', '6Misc', 'User Defined List 1',11, 1, 0, 0, 0, 'userlist1', 1, 1, '', '', 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'userlist2', '6Misc', 'User Defined List 2',12, 1, 0, 0, 0, 'userlist2', 1, 1, '', '', 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'userlist3', '6Misc', 'User Defined List 3',13, 1, 0, 0, 0, 'userlist3', 1, 1, '', '' , 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'userlist4', '6Misc', 'User Defined List 4',14, 1, 0, 0, 0, 'userlist4', 1, 1, '', '' , 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'userlist5', '6Misc', 'User Defined List 5',15, 1, 0, 0, 0, 'userlist5', 1, 1, '', '' , 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'userlist6', '6Misc', 'User Defined List 6',16, 1, 0, 0, 0, 'userlist6', 1, 1, '', '' , 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'userlist7', '6Misc', 'User Defined List 7',17, 1, 0, 0, 0, 'userlist7', 1, 1, '', '' , 'User Defined', 0);
INSERT INTO `layout_options` VALUES ('DEM', 'regdate'  , '6Misc', 'Registration Date'  ,18, 4, 0,10,10, ''         , 1, 1, '', 'D', 'Start Date at This Clinic', 0);


INSERT INTO layout_options VALUES ('REF','refer_date'      ,'1Referral','Referral Date'                  , 1, 4,2, 0,  0,''         ,1,1,'C','D','Date of referral', 0);
INSERT INTO layout_options VALUES ('REF','refer_from'      ,'1Referral','Refer By'                       , 2,10,2, 0,  0,''         ,1,1,'' ,'' ,'Referral By', 0);
INSERT INTO layout_options VALUES ('REF','refer_external'  ,'1Referral','External Referral'              , 3, 1,1, 0,  0,'boolean'  ,1,1,'' ,'' ,'External referral?', 0);
INSERT INTO layout_options VALUES ('REF','refer_to'        ,'1Referral','Refer To'                       , 4,14,2, 0,  0,''         ,1,1,'' ,'' ,'Referral To', 0);
INSERT INTO layout_options VALUES ('REF','body'            ,'1Referral','Reason'                         , 5, 3,2,30,  0,''         ,1,1,'' ,'' ,'Reason for referral', 3);
INSERT INTO layout_options VALUES ('REF','refer_diag'      ,'1Referral','Referrer Diagnosis'             , 6, 2,1,30,255,''         ,1,1,'' ,'X','Referrer diagnosis', 0);
INSERT INTO layout_options VALUES ('REF','refer_risk_level','1Referral','Risk Level'                     , 7, 1,1, 0,  0,'risklevel',1,1,'' ,'' ,'Level of urgency', 0);
INSERT INTO layout_options VALUES ('REF','refer_vitals'    ,'1Referral','Include Vitals'                 , 8, 1,1, 0,  0,'boolean'  ,1,1,'' ,'' ,'Include vitals data?', 0);
INSERT INTO layout_options VALUES ('REF','refer_related_code','1Referral','Requested Service'            , 9,15,1,30,255,''         ,1,1,'' ,'' ,'Billing Code for Requested Service', 0);
INSERT INTO layout_options VALUES ('REF','reply_date'      ,'2Counter-Referral','Reply Date'             ,10, 4,1, 0,  0,''         ,1,1,'' ,'D','Date of reply', 0);
INSERT INTO layout_options VALUES ('REF','reply_from'      ,'2Counter-Referral','Reply From'             ,11, 2,1,30,255,''         ,1,1,'' ,'' ,'Who replied?', 0);
INSERT INTO layout_options VALUES ('REF','reply_init_diag' ,'2Counter-Referral','Presumed Diagnosis'     ,12, 2,1,30,255,''         ,1,1,'' ,'' ,'Presumed diagnosis by specialist', 0);
INSERT INTO layout_options VALUES ('REF','reply_final_diag','2Counter-Referral','Final Diagnosis'        ,13, 2,1,30,255,''         ,1,1,'' ,'' ,'Final diagnosis by specialist', 0);
INSERT INTO layout_options VALUES ('REF','reply_documents' ,'2Counter-Referral','Documents'              ,14, 2,1,30,255,''         ,1,1,'' ,'' ,'Where may related scanned or paper documents be found?', 0);
INSERT INTO layout_options VALUES ('REF','reply_findings'  ,'2Counter-Referral','Findings'               ,15, 3,1,30,  0,''         ,1,1,'' ,'' ,'Findings by specialist', 3);
INSERT INTO layout_options VALUES ('REF','reply_services'  ,'2Counter-Referral','Services Provided'      ,16, 3,1,30,  0,''         ,1,1,'' ,'' ,'Service provided by specialist', 3);
INSERT INTO layout_options VALUES ('REF','reply_recommend' ,'2Counter-Referral','Recommendations'        ,17, 3,1,30,  0,''         ,1,1,'' ,'' ,'Recommendations by specialist', 3);
INSERT INTO layout_options VALUES ('REF','reply_rx_refer'  ,'2Counter-Referral','Prescriptions/Referrals',18, 3,1,30,  0,''         ,1,1,'' ,'' ,'Prescriptions and/or referrals by specialist', 3);

INSERT INTO layout_options VALUES ('HIS','usertext11','1General','Risk Factors',1,21,1,0,0,'riskfactors',1,1,'','' ,'Risk Factors', 0);
INSERT INTO layout_options VALUES ('HIS','exams'     ,'1General','Exams/Tests' ,2,23,1,0,0,'exams'      ,1,1,'','' ,'Exam and test results', 0);
INSERT INTO layout_options VALUES ('HIS','history_father'   ,'2Family History','Father'   ,1, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','history_mother'   ,'2Family History','Mother'   ,2, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','history_siblings' ,'2Family History','Siblings' ,3, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','history_spouse'   ,'2Family History','Spouse'   ,4, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','history_offspring','2Family History','Offspring',5, 2,1,20,0,'',1,3,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_cancer'             ,'3Relatives','Cancer'             ,1, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_tuberculosis'       ,'3Relatives','Tuberculosis'       ,2, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_diabetes'           ,'3Relatives','Diabetes'           ,3, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_high_blood_pressure','3Relatives','High Blood Pressure',4, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_heart_problems'     ,'3Relatives','Heart Problems'     ,5, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_stroke'             ,'3Relatives','Stroke'             ,6, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_epilepsy'           ,'3Relatives','Epilepsy'           ,7, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_mental_illness'     ,'3Relatives','Mental Illness'     ,8, 2,1,20,0,'',1,1,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','relatives_suicide'            ,'3Relatives','Suicide'            ,9, 2,1,20,0,'',1,3,'','' ,'', 0);
INSERT INTO layout_options VALUES ('HIS','coffee'              ,'4Lifestyle','Coffee'              ,2,28,1,20,0,'',1,3,'','' ,'Caffeine consumption', 0);
INSERT INTO layout_options VALUES ('HIS','tobacco'             ,'4Lifestyle','Tobacco'             ,1,32,1,0,0,'smoking_status',1,3,'','' ,'Tobacco use', 0);
INSERT INTO layout_options VALUES ('HIS','alcohol'             ,'4Lifestyle','Alcohol'             ,3,28,1,20,0,'',1,3,'','' ,'Alcohol consumption', 0);
INSERT INTO layout_options VALUES ('HIS','recreational_drugs'  ,'4Lifestyle','Recreational Drugs'  ,4,28,1,20,0,'',1,3,'','' ,'Recreational drug use', 0);
INSERT INTO layout_options VALUES ('HIS','counseling'          ,'4Lifestyle','Counseling'          ,5,28,1,20,0,'',1,3,'','' ,'Counseling activities', 0);
INSERT INTO layout_options VALUES ('HIS','exercise_patterns'   ,'4Lifestyle','Exercise Patterns'   ,6,28,1,20,0,'',1,3,'','' ,'Exercise patterns', 0);
INSERT INTO layout_options VALUES ('HIS','hazardous_activities','4Lifestyle','Hazardous Activities',7,28,1,20,0,'',1,3,'','' ,'Hazardous activities', 0);
INSERT INTO layout_options VALUES ('HIS','sleep_patterns'      ,'4Lifestyle','Sleep Patterns'      ,8, 2,1,20,0,'',1,3,'','' ,'Sleep patterns', 0);
INSERT INTO layout_options VALUES ('HIS','seatbelt_use'        ,'4Lifestyle','Seatbelt Use'        ,9, 2,1,20,0,'',1,3,'','' ,'Seatbelt use', 0);
INSERT INTO layout_options VALUES ('HIS','name_1'            ,'5Other','Name/Value'        ,1, 2,1,10,255,'',1,1,'','' ,'Name 1', 0);
INSERT INTO layout_options VALUES ('HIS','value_1'           ,'5Other',''                  ,2, 2,1,10,255,'',0,0,'','' ,'Value 1', 0);
INSERT INTO layout_options VALUES ('HIS','name_2'            ,'5Other','Name/Value'        ,3, 2,1,10,255,'',1,1,'','' ,'Name 2', 0);
INSERT INTO layout_options VALUES ('HIS','value_2'           ,'5Other',''                  ,4, 2,1,10,255,'',0,0,'','' ,'Value 2', 0);
INSERT INTO layout_options VALUES ('HIS','additional_history','5Other','Additional History',5, 3,1,30,  0,'',1,3,'' ,'' ,'Additional history notes', 3);
INSERT INTO layout_options VALUES ('HIS','userarea11'        ,'5Other','User Defined Area 11',6,3,0,30,0,'',1,3,'','','User Defined', 3);
INSERT INTO layout_options VALUES ('HIS','userarea12'        ,'5Other','User Defined Area 12',7,3,0,30,0,'',1,3,'','','User Defined', 3);

INSERT INTO `layout_options` VALUES ('FACUSR', 'provider_id', '1General', 'Provider ID', 1, 2, 1, 15, 63, '', 1, 1, '', '', 'Provider ID at Specified Facility', 0);



INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_name', '7Hospitalization', 'Hospital', '1','36','1','0','0','','1','3','','','Hospital','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_phone', '7Hospitalization', 'Phone #', '2','2','1','20','63','','1','3','','1','Hospital Phone Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_address', '7Hospitalization', 'Address', '3','2','1','20','225','','1','3','','1','Hospital Address','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_city', '7Hospitalization', 'City', '4','2','1','20','63','','1','3','','1','Hospital City','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_state', '7Hospitalization', 'State', '5','2','1','20','63','','1','3','','1','Hospital State','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_zip', '7Hospitalization', 'Zip Code', '6','2','1','20','63','','1','3','','1','Hospital Zip Code','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_admit_date', '7Hospitalization', 'Admit Date', '8','4','1','10','10','','1','3','','D','Hospital Admit Date','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hospital_dc_date', '7Hospitalization', 'D/C Date', '9','4','1','10','10','','1','3','','D','Hospital D/C Date','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_name', '8Agency', 'Agency Name', '1','37','1','0','0','','1','3','','','Agency','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_rate', '8Agency', 'Rate', '2','2','1','11','11','','1','3','','','Agency Rate','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_address', '8Agency', 'Address', '3','2','1','20','225','','1','3','','1','Agency Address','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_city', '8Agency', 'City', '4','2','1','20','63','','1','3','','1','Agency City','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_state', '8Agency', 'State', '5','2','1','20','63','','1','3','','1','Agency State','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_zip', '8Agency', 'Zip Code', '6','2','1','20','63','','1','3','','1','Agency Zip Code','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_phone', '8Agency', 'Phone', '7','2','1','20','63','','1','3','','1','Agency Phone Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_fax', '8Agency', 'Fax', '8','2','1','20','63','','1','3','','1','Agency Fax Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'agency_email', '8Agency', 'Email', '9','2','1','20','63','','1','3','','1','Agency Email','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_date', '9Referral', 'Referral Date', '1','4','1','10','10','','1','3','','D','Referral Date','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_fname', '9Referral', 'Referrer First Name', '4','2','1','20','63','','1','3','','1','Referrer First Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_lname', '9Referral', 'Referrer Last Name', '4','2','1','20','63','','1','3','','1','Referrer Last Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_company_name', '9Referral', 'Referrer Company Name', '5','2','1','20','63','','1','3','','1','Referrer Company Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_phone_no', '9Referral', 'Phone', '6','2','1','20','63','','1','3','','1','Referrer Phone Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_fax_no', '9Referral', 'Fax', '7','2','1','20','63','','1','3','','1','Referrer Fax Number','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_source_facility_name', '9Referral', 'Facility Name', '9','27','1','5','225','facility_name','1','3','','','Facility Name','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_source_phone_no', '9Referral', 'Phone', '10','2','1','20','63','','1','3','','','Referral Source Phone Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_source_fax', '9Referral', 'Fax', '11','2','1','20','63','','1','3','','','Referral Source Fax Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_source_protocol', '9Referral', 'Protocol', '12','2','1','20','63','','1','3','','','Referral Source Protocol','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_taken_by', '9Referral', 'Referral Taken By', '14','2','1','20','63','','1','3','','','Referral Taken By','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_reason_not_visited', '9Referral', 'Reason If not visited within 48 hours', '15','2','1','20','63','','1','3','','','Reason If not visited within 48 hours','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'referral_comments', '9Referral', 'Comments', '16','2','1','20','63','','1','3','','','Comments by Referral','0');



INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'primary_ref_physician', '9Physician(s)', 'Primary Referring Physician', '1','39','1','20','63','','1','3','','1','Primary Referring Physician','0');
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


INSERT INTO `layout_options` (`form_id` ,`field_id` ,`group_name` ,`title` ,`seq` ,`data_type` ,`uor` ,`fld_length` ,`max_length` ,`list_id` ,`titlecols` ,`datacols` ,`default_value` ,`edit_options` ,`description` ,`fld_rows`) VALUES ('DEM', 'area_director', '6Misc', 'Area Director', '19', '10', '1', '0', '0', '', '1', '3', '', '', 'Area Director', '0');
INSERT INTO `layout_options` (`form_id` ,`field_id` ,`group_name` ,`title` ,`seq` ,`data_type` ,`uor` ,`fld_length` ,`max_length` ,`list_id` ,`titlecols` ,`datacols` ,`default_value` ,`edit_options` ,`description` ,`fld_rows`) VALUES ('DEM', 'case_manager', '6Misc', 'Case Manager', '20', '11', '1', '0', '0', '', '1', '3', '', '', 'Case Manager', '0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'medicare_number', '1Patient Info', 'Medicare Number', '31','2','1','20','63','','1','1','','','Medicare Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'medicaid_number', '1Patient Info', 'Medicaid Number', '32','2','1','20','63','','1','1','','','Medicaid Number','0');
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'hmo_ppo_number', '1Patient Info', 'HMO/PPO Number', '33','2','1','20','63','','1','1','','','HMO/PPO Number','0');

UPDATE layout_options SET group_name='9Referral', data_type=43, seq=4  WHERE field_id='ref_providerID';

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


UPDATE layout_options SET group_name="3Preferences" WHERE group_name="3Choices";
DELETE FROM layout_options WHERE field_id='hipaa_notice' AND group_name='3Preferences';
DELETE FROM layout_options WHERE field_id='allow_imm_reg_use' AND group_name='3Preferences';
DELETE FROM layout_options WHERE field_id='allow_health_info_ex' AND group_name='3Preferences';
DELETE FROM layout_options WHERE field_id='allow_imm_info_share' AND group_name='3Preferences';

UPDATE layout_options SET group_name="3Preferences", seq=1, title="Physician" WHERE field_id="providerID";
UPDATE layout_options SET group_name="5Background" WHERE group_name="5Stats";

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'emp_off_num', '4Employer', 'Office Number', '8','2','1','20','63','','1','1','','','Office Number','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'emp_fax_num', '4Employer', 'Fax Number', '9','2','1','20','63','','1','1','','','Fax Number','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'ok_to_contact', '4Employer', 'OK to Contact', '10','1','1','0','0','yesnona','1','1','','','OK to Contact','0');

UPDATE layout_options SET group_name="5Background", seq=1, title="Primary Language Spoken" WHERE field_id="language";

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'secondary_language', '5Background', 'Secondary Language Spoken', '2','26','1','0','0','language','1','1','','','Secondary Language Spoken','0');

UPDATE layout_options SET group_name="5Background", title="Number of Children" WHERE field_id="family_size";

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'grand_childrens', '5Background', 'Number of Grand Children', '5','2','1','20','63','','1','1','','','Number of Grand Children','0');

UPDATE layout_options SET group_name="7Hospitalization", title="Last Admission Date" WHERE field_id="hospital_admit_date";

UPDATE layout_options SET group_name="7Hospitalization", title="Last Discharge Date" WHERE field_id="hospital_dc_date";

UPDATE layout_options SET group_name="9Referral", seq=0 WHERE field_id="area_director";

UPDATE layout_options SET group_name="9Referral", seq=0 WHERE field_id="case_manager";

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'type_of_referral', '9Referral', 'Type of Referral', '2','1','1','0','0','referraltype','1','1','','','Type of Referral','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'type_of_referral_other', '9Referral', 'Other', '3','2','1','20','63','','1','1','','1','Other','0');

INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'pref_other', '3Preferences', 'Other', '15','2','1','20','63','','1','3','','','Other Preferences','0');


-- --------------------------------------------------------

-- 
-- Table structure for table `list_options`
-- 

DROP TABLE IF EXISTS `list_options`;
CREATE TABLE `list_options` (
  `list_id` varchar(31) NOT NULL default '',
  `option_id` varchar(31) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `seq` int(11) NOT NULL default '0',
  `is_default` tinyint(1) NOT NULL default '0',
  `option_value` float NOT NULL default '0',
  `mapping` varchar(31) NOT NULL DEFAULT '',
  `notes` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`list_id`,`option_id`)
) ENGINE=MyISAM;

-- 
-- Dumping data for table `list_options`
-- 

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('yesno', 'NO', 'NO', 1, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('yesno', 'YES', 'YES', 2, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('titles', 'Mr.', 'Mr.', 1, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('titles', 'Mrs.', 'Mrs.', 2, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('titles', 'Ms.', 'Ms.', 3, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('titles', 'Dr.', 'Dr.', 4, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('sex', 'Female', 'Female', 1, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('sex', 'Male', 'Male', 2, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('marital', 'married', 'Married', 1, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('marital', 'single', 'Single', 2, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('marital', 'divorced', 'Divorced', 3, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('marital', 'widowed', 'Widowed', 4, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('marital', 'separated', 'Separated', 5, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('marital', 'domestic partner', 'Domestic Partner', 6, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'armenian', 'Armenian', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'chinese', 'Chinese', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'danish', 'Danish', 30, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'deaf', 'Deaf', 40, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'English', 'English', 50, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'farsi', 'Farsi', 60, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'french', 'French', 70, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'german', 'German', 80, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'greek', 'Greek', 90, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'hmong', 'Hmong', 100, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'italian', 'Italian', 110, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'japanese', 'Japanese', 120, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'korean', 'Korean', 130, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'laotian', 'Laotian', 140, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'mien', 'Mien', 150, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'norwegian', 'Norwegian', 160, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'othrs', 'Others', 170, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'portuguese', 'Portuguese', 180, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'punjabi', 'Punjabi', 190, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'russian', 'Russian', 200, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'Spanish', 'Spanish', 210, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'tagalog', 'Tagalog', 220, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'turkish', 'Turkish', 230, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'vietnamese', 'Vietnamese', 240, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'yiddish', 'Yiddish', 250, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('language', 'zulu', 'Zulu', 260, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'aleut', 'ALEUT', 10,  0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'amer_indian', 'American Indian', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'Asian', 'Asian', 30, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'Black', 'Black', 40, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'cambodian', 'Cambodian', 50, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'Caucasian', 'Caucasian', 60, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'cs_american', 'Central/South American', 70, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'chinese', 'Chinese', 80, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'cuban', 'Cuban', 90, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'eskimo', 'Eskimo', 100, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'filipino', 'Filipino', 110, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'guamanian', 'Guamanian', 120, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'hawaiian', 'Hawaiian', 130, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'Hispanic', 'Hispanic', 140, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'othr_us', 'Hispanic - Other (Born in US)', 150, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'othr_non_us', 'Hispanic - Other (Born outside US)', 160, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'hmong', 'Hmong', 170, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'indian', 'Indian', 180, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'japanese', 'Japanese', 190, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'korean', 'Korean', 200, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'laotian', 'Laotian', 210, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'mexican', 'Mexican/MexAmer/Chicano', 220, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'mlt-race', 'Multiracial', 230, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'othr', 'Other', 240, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'othr_spec', 'Other - Specified', 250, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'pac_island', 'Pacific Islander', 260, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'puerto_rican', 'Puerto Rican', 270, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'refused', 'Refused To State', 280, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'samoan', 'Samoan', 290, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'spec', 'Specified', 300, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'thai', 'Thai', 310, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'unknown', 'Unknown', 320, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'unspec', 'Unspecified', 330, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'vietnamese', 'Vietnamese', 340, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'white', 'White', 350, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethrace', 'withheld', 'Withheld', 360, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('userlist1', 'sample', 'Sample', 1, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('userlist2', 'sample', 'Sample', 1, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('userlist3','sample','Sample',1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('userlist4','sample','Sample',1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('userlist5','sample','Sample',1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('userlist6','sample','Sample',1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('userlist7','sample','Sample',1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('pricelevel', 'standard', 'Standard', 1, 1);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('risklevel', 'low', 'Low', 1, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('risklevel', 'medium', 'Medium', 2, 1);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('risklevel', 'high', 'High', 3, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('boolean', '0', 'No', 1, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('boolean', '1', 'Yes', 2, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('country', 'USA', 'USA', 1, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','AL','Alabama'             , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','AK','Alaska'              , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','AZ','Arizona'             , 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','AR','Arkansas'            , 4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','CA','California'          , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','CO','Colorado'            , 6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','CT','Connecticut'         , 7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','DE','Delaware'            , 8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','DC','District of Columbia', 9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','FL','Florida'             ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','GA','Georgia'             ,11,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','HI','Hawaii'              ,12,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','ID','Idaho'               ,13,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','IL','Illinois'            ,14,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','IN','Indiana'             ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','IA','Iowa'                ,16,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','KS','Kansas'              ,17,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','KY','Kentucky'            ,18,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','LA','Louisiana'           ,19,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','ME','Maine'               ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','MD','Maryland'            ,21,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','MA','Massachusetts'       ,22,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','MI','Michigan'            ,23,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','MN','Minnesota'           ,24,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','MS','Mississippi'         ,25,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','MO','Missouri'            ,26,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','MT','Montana'             ,27,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','NE','Nebraska'            ,28,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','NV','Nevada'              ,29,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','NH','New Hampshire'       ,30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','NJ','New Jersey'          ,31,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','NM','New Mexico'          ,32,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','NY','New York'            ,33,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','NC','North Carolina'      ,34,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','ND','North Dakota'        ,35,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','OH','Ohio'                ,36,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','OK','Oklahoma'            ,37,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','OR','Oregon'              ,38,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','PA','Pennsylvania'        ,39,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','RI','Rhode Island'        ,40,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','SC','South Carolina'      ,41,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','SD','South Dakota'        ,42,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','TN','Tennessee'           ,43,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','TX','Texas'               ,44,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','UT','Utah'                ,45,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','VT','Vermont'             ,46,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','VA','Virginia'            ,47,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','WA','Washington'          ,48,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','WV','West Virginia'       ,49,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','WI','Wisconsin'           ,50,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('state','WY','Wyoming'             ,51,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Patient'      ,'Patient'      , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Employee'     ,'Employee'     , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Walk-In'      ,'Walk-In'      , 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Newspaper'    ,'Newspaper'    , 4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Radio'        ,'Radio'        , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','T.V.'         ,'T.V.'         , 6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Direct Mail'  ,'Direct Mail'  , 7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Coupon'       ,'Coupon'       , 8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Referral Card','Referral Card', 9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('refsource','Other'        ,'Other'        ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','vv' ,'Varicose Veins'                      , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','ht' ,'Hypertension'                        , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','db' ,'Diabetes'                            , 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','sc' ,'Sickle Cell'                         , 4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','fib','Fibroids'                            , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','pid','PID (Pelvic Inflammatory Disease)'   , 6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','mig','Severe Migraine'                     , 7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','hd' ,'Heart Disease'                       , 8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','str','Thrombosis/Stroke'                   , 9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','hep','Hepatitis'                           ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','gb' ,'Gall Bladder Condition'              ,11,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','br' ,'Breast Disease'                      ,12,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','dpr','Depression'                          ,13,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','all','Allergies'                           ,14,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','inf','Infertility'                         ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','ast','Asthma'                              ,16,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','ep' ,'Epilepsy'                            ,17,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','cl' ,'Contact Lenses'                      ,18,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','coc','Contraceptive Complication (specify)',19,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('riskfactors','oth','Other (specify)'                     ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'brs','Breast Exam'          , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'cec','Cardiac Echo'         , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'ecg','ECG'                  , 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'gyn','Gynecological Exam'   , 4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'mam','Mammogram'            , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'phy','Physical Exam'        , 6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'pro','Prostate Exam'        , 7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'rec','Rectal Exam'          , 8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'sic','Sigmoid/Colonoscopy'  , 9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'ret','Retinal Exam'         ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'flu','Flu Vaccination'      ,11,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'pne','Pneumonia Vaccination',12,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'ldl','LDL'                  ,13,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'hem','Hemoglobin'           ,14,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('exams' ,'psa','PSA'                  ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','0',''           ,0,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','1','suspension' ,1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','2','tablet'     ,2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','3','capsule'    ,3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','4','solution'   ,4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','5','tsp'        ,5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','6','ml'         ,6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','7','units'      ,7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','8','inhalations',8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','9','gtts(drops)',9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','10','cream'   ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_form','11','ointment',11,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','0',''          ,0,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','1','mg'    ,1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','2','mg/1cc',2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','3','mg/2cc',3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','4','mg/3cc',4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','5','mg/4cc',5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','6','mg/5cc',6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','7','mcg'   ,7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_units','8','grams' ,8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '0',''                 , 0,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '1','Per Oris'         , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '2','Per Rectum'       , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '3','To Skin'          , 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '4','To Affected Area' , 4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '5','Sublingual'       , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '6','OS'               , 6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '7','OD'               , 7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '8','OU'               , 8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route', '9','SQ'               , 9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route','10','IM'               ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route','11','IV'               ,11,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route','12','Per Nostril'      ,12,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route','13','Both Ears',13,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route','14','Left Ear' ,14,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_route','15','Right Ear',15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','0',''      ,0,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','1','b.i.d.',1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','2','t.i.d.',2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','3','q.i.d.',3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','4','q.3h'  ,4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','5','q.4h'  ,5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','6','q.5h'  ,6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','7','q.6h'  ,7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','8','q.8h'  ,8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','9','q.d.'  ,9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','10','a.c.'  ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','11','p.c.'  ,11,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','12','a.m.'  ,12,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','13','p.m.'  ,13,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','14','ante'  ,14,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','15','h'     ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','16','h.s.'  ,16,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','17','p.r.n.',17,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('drug_interval','18','stat'  ,18,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('chartloc','fileroom','File Room'              ,1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'boolean'      ,'Boolean'            , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'chartloc'     ,'Chart Storage Locations',1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'country'      ,'Country'            , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'drug_form'    ,'Drug Forms'         , 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'drug_units'   ,'Drug Units'         , 4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'drug_route'   ,'Drug Routes'        , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'drug_interval','Drug Intervals'     , 6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'exams'        ,'Exams/Tests'        , 7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'feesheet'     ,'Fee Sheet'          , 8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'language'     ,'Language'           , 9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'lbfnames'     ,'Layout-Based Visit Forms',9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'marital'      ,'Marital Status'     ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'pricelevel'   ,'Price Level'        ,11,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'ethrace'      ,'Race/Ethnicity'     ,12,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'refsource'    ,'Referral Source'    ,13,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'riskfactors'  ,'Risk Factors'       ,14,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'risklevel'    ,'Risk Level'         ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'superbill'    ,'Service Category'   ,16,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'sex'          ,'Sex'                ,17,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'state'        ,'State'              ,18,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'taxrate'      ,'Tax Rate'           ,19,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'titles'       ,'Titles'             ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'yesno'        ,'Yes/No'             ,21,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'userlist1'    ,'User Defined List 1',22,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'userlist2'    ,'User Defined List 2',23,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'userlist3'    ,'User Defined List 3',24,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'userlist4'    ,'User Defined List 4',25,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'userlist5'    ,'User Defined List 5',26,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'userlist6'    ,'User Defined List 6',27,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists' ,'userlist7'    ,'User Defined List 7',28,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'    ,'adjreason'      ,'Adjustment Reasons',1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Adm adjust'     ,'Adm adjust'     , 5,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','After hrs calls','After hrs calls',10,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Bad check'      ,'Bad check'      ,15,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Bad debt'       ,'Bad debt'       ,20,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Coll w/o'       ,'Coll w/o'       ,25,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Discount'       ,'Discount'       ,30,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Hardship w/o'   ,'Hardship w/o'   ,35,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Ins adjust'     ,'Ins adjust'     ,40,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Ins bundling'   ,'Ins bundling'   ,45,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Ins overpaid'   ,'Ins overpaid'   ,50,5);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Ins refund'     ,'Ins refund'     ,55,5);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Pt overpaid'    ,'Pt overpaid'    ,60,5);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Pt refund'      ,'Pt refund'      ,65,5);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Pt released'    ,'Pt released'    ,70,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Sm debt w/o'    ,'Sm debt w/o'    ,75,1);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','To copay'       ,'To copay'       ,80,2);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','To ded\'ble'    ,'To ded\'ble'    ,85,3);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('adjreason','Untimely filing','Untimely filing',90,1);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'       ,'sub_relation','Subscriber Relationship',18,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('sub_relation','self'        ,'Self'                   , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('sub_relation','spouse'      ,'Spouse'                 , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('sub_relation','child'       ,'Child'                  , 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('sub_relation','other'       ,'Other'                  , 4,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'     ,'occurrence','Occurrence'                  ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('occurrence','0'         ,'Unknown or N/A'              , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('occurrence','1'         ,'First'                       ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('occurrence','6'         ,'Early Recurrence (<2 Mo)'    ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('occurrence','7'         ,'Late Recurrence (2-12 Mo)'   ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('occurrence','8'         ,'Delayed Recurrence (> 12 Mo)',25,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('occurrence','4'         ,'Chronic/Recurrent'           ,30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('occurrence','5'         ,'Acute on Chronic'            ,35,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'  ,'outcome','Outcome'         ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('outcome','0'      ,'Unassigned'      , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('outcome','1'      ,'Resolved'        , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('outcome','2'      ,'Improved'        ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('outcome','3'      ,'Status quo'      ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('outcome','4'      ,'Worse'           ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('outcome','5'      ,'Pending followup',25,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'    ,'note_type'      ,'Patient Note Types',10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Unassigned'     ,'Unassigned'        , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Chart Note'     ,'Chart Note'        , 2,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Insurance'      ,'Insurance'         , 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','New Document'   ,'New Document'      , 4,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Pharmacy'       ,'Pharmacy'          , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Prior Auth'     ,'Prior Auth'        , 6,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Referral'       ,'Referral'          , 7,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Test Scheduling','Test Scheduling'   , 8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Bill/Collect'   ,'Bill/Collect'      , 9,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Other'          ,'Other'             ,10,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'        ,'immunizations','Immunizations'           ,  8,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','1'            ,'DTaP 1'                  , 30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','2'            ,'DTaP 2'                  , 35,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','3'            ,'DTaP 3'                  , 40,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','4'            ,'DTaP 4'                  , 45,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','5'            ,'DTaP 5'                  , 50,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','6'            ,'DT 1'                    ,  5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','7'            ,'DT 2'                    , 10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','8'            ,'DT 3'                    , 15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','9'            ,'DT 4'                    , 20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','10'           ,'DT 5'                    , 25,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','11'           ,'IPV 1'                   ,110,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','12'           ,'IPV 2'                   ,115,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','13'           ,'IPV 3'                   ,120,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','14'           ,'IPV 4'                   ,125,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','15'           ,'Hib 1'                   , 80,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','16'           ,'Hib 2'                   , 85,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','17'           ,'Hib 3'                   , 90,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','18'           ,'Hib 4'                   , 95,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','19'           ,'Pneumococcal Conjugate 1',140,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','20'           ,'Pneumococcal Conjugate 2',145,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','21'           ,'Pneumococcal Conjugate 3',150,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','22'           ,'Pneumococcal Conjugate 4',155,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','23'           ,'MMR 1'                   ,130,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','24'           ,'MMR 2'                   ,135,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','25'           ,'Varicella 1'             ,165,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','26'           ,'Varicella 2'             ,170,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','27'           ,'Hepatitis B 1'           , 65,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','28'           ,'Hepatitis B 2'           , 70,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','29'           ,'Hepatitis B 3'           , 75,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','30'           ,'Influenza 1'             ,100,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','31'           ,'Influenza 2'             ,105,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','32'           ,'Td'                      ,160,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','33'           ,'Hepatitis A 1'           , 55,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','34'           ,'Hepatitis A 2'           , 60,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('immunizations','35'           ,'Other'                   ,175,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'apptstat','Appointment Statuses', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','-'       ,'- None'              , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','*'       ,'* Reminder done'     ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','+'       ,'+ Chart pulled'      ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','x'       ,'x Canceled'          ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','?'       ,'? No show'           ,25,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','@'       ,'@ Arrived'           ,30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','~'       ,'~ Arrived late'      ,35,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','!'       ,'! Left w/o visit'    ,40,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','#'       ,'# Ins/fin issue'     ,45,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','<'       ,'< In exam room'      ,50,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','>'       ,'> Checked out'       ,55,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','$'       ,'$ Coding done'       ,60,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('apptstat','%'       ,'% Canceled < 24h'    ,65,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'    ,'warehouse','Warehouses',21,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('warehouse','onsite'   ,'On Site'   , 5,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','abook_type'  ,'Address Book Types'  , 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('abook_type','ord_img','Imaging Service'     , 5,3);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('abook_type','ord_imm','Immunization Service',10,3);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('abook_type','ord_lab','Lab Service'         ,15,3);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('abook_type','spe'    ,'Specialist'          ,20,2);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('abook_type','vendor' ,'Vendor'              ,25,3);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('abook_type','dist'   ,'Distributor'         ,30,3);
INSERT INTO list_options ( list_id, option_id, title, seq, option_value ) VALUES ('abook_type','oth'    ,'Other'               ,95,1);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_type','Procedure Types', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_type','grp','Group'          ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_type','ord','Procedure Order',20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_type','res','Discrete Result',30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_type','rec','Recommendation' ,40,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_body_site','Procedure Body Sites', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_body_site','arm'    ,'Arm'    ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_body_site','buttock','Buttock',20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_body_site','oth'    ,'Other'  ,90,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_specimen','Procedure Specimen Types', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_specimen','blood' ,'Blood' ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_specimen','saliva','Saliva',20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_specimen','urine' ,'Urine' ,30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_specimen','oth'   ,'Other' ,90,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_route','Procedure Routes', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_route','inj' ,'Injection',10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_route','oral','Oral'     ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_route','oth' ,'Other'    ,90,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_lat','Procedure Lateralities', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_lat','left' ,'Left'     ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_lat','right','Right'    ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_lat','bilat','Bilateral',30,0);

INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('lists','proc_unit','Procedure Units', 1);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','bool'       ,'Boolean'    ,  5);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','cu_mm'      ,'CU.MM'      , 10);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','fl'         ,'FL'         , 20);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','g_dl'       ,'G/DL'       , 30);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','gm_dl'      ,'GM/DL'      , 40);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','hmol_l'     ,'HMOL/L'     , 50);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','iu_l'       ,'IU/L'       , 60);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','mg_dl'      ,'MG/DL'      , 70);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','mil_cu_mm'  ,'Mil/CU.MM'  , 80);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','percent'    ,'Percent'    , 90);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','percentile' ,'Percentile' ,100);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','pg'         ,'PG'         ,110);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','ratio'      ,'Ratio'      ,120);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','thous_cu_mm','Thous/CU.MM',130);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','units'      ,'Units'      ,140);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','units_l'    ,'Units/L'    ,150);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','days'       ,'Days'       ,600);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','weeks'      ,'Weeks'      ,610);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','months'     ,'Months'     ,620);
INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('proc_unit','oth'        ,'Other'      ,990);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','ord_priority','Order Priorities', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ord_priority','high'  ,'High'  ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ord_priority','normal','Normal',20,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','ord_status','Order Statuses', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ord_status','pending' ,'Pending' ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ord_status','routed'  ,'Routed'  ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ord_status','complete','Complete',30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ord_status','canceled','Canceled',40,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_rep_status','Procedure Report Statuses', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_rep_status','final'  ,'Final'      ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_rep_status','review' ,'Reviewed'   ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_rep_status','prelim' ,'Preliminary',30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_rep_status','cancel' ,'Canceled'   ,40,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_rep_status','error'  ,'Error'      ,50,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_rep_status','correct','Corrected'  ,60,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_res_abnormal','Procedure Result Abnormal', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_abnormal','no'  ,'No'  ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_abnormal','yes' ,'Yes' ,20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_abnormal','high','High',30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_abnormal','low' ,'Low' ,40,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_res_status','Procedure Result Statuses', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_status','final'     ,'Final'      ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_status','prelim'    ,'Preliminary',20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_status','cancel'    ,'Canceled'   ,30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_status','error'     ,'Error'      ,40,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_status','correct'   ,'Corrected'  ,50,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_status','incomplete','Incomplete' ,60,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists','proc_res_bool','Procedure Boolean Results', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_bool','neg' ,'Negative',10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('proc_res_bool','pos' ,'Positive',20,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'         ,'message_status','Message Status',45,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('message_status','Done'           ,'Done'         , 5,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('message_status','Forwarded'      ,'Forwarded'    ,10,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('message_status','New'            ,'New'          ,15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('message_status','Read'           ,'Read'         ,20,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Lab Results' ,'Lab Results', 15,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','New Orders' ,'New Orders', 20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('note_type','Patient Reminders' ,'Patient Reminders', 25,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'irnpool','Invoice Reference Number Pools', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default, notes ) VALUES ('irnpool','main','Main',1,1,'000001');

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists', 'eligibility', 'Eligibility', 60, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('eligibility', 'eligible', 'Eligible', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('eligibility', 'ineligible', 'Ineligible', 20, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists', 'transactions', 'Transactions', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('transactions', 'Referral', 'Referral', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('transactions', 'Patient Request', 'Patient Request', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('transactions', 'Physician Request', 'Physician Request', 30, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('transactions', 'Legal', 'Legal', 40, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('transactions', 'Billing', 'Billing', 50, 0);


INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'payment_adjustment_code','Payment Adjustment Code', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_adjustment_code', 'family_payment', 'Family Payment', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_adjustment_code', 'group_payment', 'Group Payment', 30, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_adjustment_code', 'insurance_payment', 'Insurance Payment', 40, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_adjustment_code', 'patient_payment', 'Patient Payment', 50, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_adjustment_code', 'pre_payment', 'Pre Payment', 60, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'payment_ins','Payment Ins', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_ins', '0', 'Pat', 40, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_ins', '1', 'Ins1', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_ins', '2', 'Ins2', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_ins', '3', 'Ins3', 30, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'payment_method','Payment Method', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_method', 'bank_draft', 'Bank Draft', 50, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_method', 'cash', 'Cash', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_method', 'check_payment', 'Check Payment', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_method', 'credit_card', 'Credit Card', 30, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_method', 'electronic', 'Electronic', 40, 0);
insert into `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) values('payment_method','authorize_net','Authorize.net','60','0','0','','');

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'payment_sort_by','Payment Sort By', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_sort_by', 'check_date', 'Check Date', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_sort_by', 'payer_id', 'Ins Code', 40, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_sort_by', 'payment_method', 'Payment Method', 50, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_sort_by', 'payment_type', 'Paying Entity', 30, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_sort_by', 'pay_total', 'Amount', 70, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_sort_by', 'reference', 'Check Number', 60, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_sort_by', 'session_id', 'Id', 10, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'payment_status','Payment Status', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_status', 'fully_paid', 'Fully Paid', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_status', 'unapplied', 'Unapplied', 20, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'payment_type','Payment Type', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_type', 'insurance', 'Insurance', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_type', 'patient', 'Patient', 20, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists', 'date_master_criteria', 'Date Master Criteria', 33, 1);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('date_master_criteria', 'all', 'All', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('date_master_criteria', 'today', 'Today', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('date_master_criteria', 'this_month_to_date', 'This Month to Date', 30, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('date_master_criteria', 'last_month', 'Last Month', 40, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('date_master_criteria', 'this_week_to_date', 'This Week to Date', 50, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('date_master_criteria', 'this_calendar_year', 'This Calendar Year', 60, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('date_master_criteria', 'last_calendar_year', 'Last Calendar Year', 70, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('date_master_criteria', 'custom', 'Custom', 80, 0);

-- Clinical Plan Titles
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'clinical_plans','Clinical Plans', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'dm_plan_cqm', 'Diabetes Mellitus', 5, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'ckd_plan_cqm', 'Chronic Kidney Disease (CKD)', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'prevent_plan_cqm', 'Preventative Care', 15, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'periop_plan_cqm', 'Perioperative Care', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'rheum_arth_plan_cqm', 'Rheumatoid Arthritis', 25, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'back_pain_plan_cqm', 'Back Pain', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'cabg_plan_cqm', 'Coronary Artery Bypass Graft (CABG)', 35, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'dm_plan', 'Diabetes Mellitus', 500, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_plans', 'prevent_plan', 'Preventative Care', 510, 0);

-- Clinical Rule Titles
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'clinical_rules','Clinical Rules', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'problem_list_amc', 'Maintain an up-to-date problem list of current and active diagnoses.', 5, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'med_list_amc', 'Maintain active medication list.', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'med_allergy_list_amc', 'Maintain active medication allergy list.', 15, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'record_vitals_amc', 'Record and chart changes in vital signs.', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'record_smoke_amc', 'Record smoking status for patients 13 years old or older.', 25, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'lab_result_amc', 'Incorporate clinical lab-test results into certified EHR technology as structured data.', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'med_reconc_amc', 'The EP, eligible hospital or CAH who receives a patient from another setting of care or provider of care or believes an encounter is relevant should perform medication reconciliation.', 35, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'patient_edu_amc', 'Use certified EHR technology to identify patient-specific education resources and provide those resources to the patient if appropriate.', 40, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'cpoe_med_amc', 'Use CPOE for medication orders directly entered by any licensed healthcare professional who can enter orders into the medical record per state, local and professional guidelines.', 45, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'e_prescribe_amc', 'Generate and transmit permissible prescriptions electronically.', 50, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'record_dem_amc', 'Record demographics.', 55, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'send_reminder_amc', 'Send reminders to patients per patient preference for preventive/follow up care.', 60, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'provide_rec_pat_amc', 'Provide patients with an electronic copy of their health information (including diagnostic test results, problem list, medication lists, medication allergies), upon request.', 65, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'timely_access_amc', 'Provide patients with timely electronic access to their health information (including lab results, problem list, medication lists, medication allergies) within four business days of the information being available to the EP.', 70, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'provide_sum_pat_amc', 'Provide clinical summaries for patients for each office visit.', 75, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'send_sum_amc', 'The EP, eligible hospital or CAH who transitions their patient to another setting of care or provider of care or refers their patient to another provider of care should provide summary of care record for each transition of care or referral.', 80, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_htn_bp_measure_cqm', 'Hypertension: Blood Pressure Measurement (CQM)', 200, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_tob_use_assess_cqm', 'Tobacco Use Assessment (CQM)', 205, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_tob_cess_inter_cqm', 'Tobacco Cessation Intervention (CQM)', 210, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_adult_wt_screen_fu_cqm', 'Adult Weight Screening and Follow-Up (CQM)', 220, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_wt_assess_couns_child_cqm', 'Weight Assessment and Counseling for Children and Adolescents (CQM)', 230, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_influenza_ge_50_cqm', 'Influenza Immunization for Patients >= 50 Years Old (CQM)', 240, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_child_immun_stat_cqm', 'Childhood immunization Status (CQM)', 250, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_pneumovacc_ge_65_cqm', 'Pneumonia Vaccination Status for Older Adults (CQM)', 260, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_eye_cqm', 'Diabetes: Eye Exam (CQM)', 270, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_foot_cqm', 'Diabetes: Foot Exam (CQM)', 280, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_a1c_cqm', 'Diabetes: HbA1c Poor Control (CQM)', 285, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_bp_control_cqm', 'Diabetes: Blood Pressure Management (CQM)', 290, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_ldl_cqm', 'Diabetes: LDL Management & Control (CQM)', 300, 0);

INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_htn_bp_measure', 'Hypertension: Blood Pressure Measurement', 500, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_tob_use_assess', 'Tobacco Use Assessment', 510, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_tob_cess_inter', 'Tobacco Cessation Intervention', 520, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_adult_wt_screen_fu', 'Adult Weight Screening and Follow-Up', 530, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_wt_assess_couns_child', 'Weight Assessment and Counseling for Children and Adolescents', 540, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_influenza_ge_50', 'Influenza Immunization for Patients >= 50 Years Old', 550, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_pneumovacc_ge_65', 'Pneumonia Vaccination Status for Older Adults', 570, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_hemo_a1c', 'Diabetes: Hemoglobin A1C', 570, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_urine_alb', 'Diabetes: Urine Microalbumin', 590, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_eye', 'Diabetes: Eye Exam', 600, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_dm_foot', 'Diabetes: Foot Exam', 610, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_cs_mammo', 'Cancer Screening: Mammogram', 620, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_cs_pap', 'Cancer Screening: Pap Smear', 630, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_cs_colon', 'Cancer Screening: Colon Cancer Screening', 640, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_cs_prostate', 'Cancer Screening: Prostate Cancer Screening', 650, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_inr_monitor', 'Coumadin Management - INR Monitoring', 1000, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('clinical_rules', 'rule_appt_reminder', 'Appointment Reminder Rule', 2000, 0);

-- Clinical Rule Target Methods
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_targets', 'Clinical Rule Target Methods', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_targets' ,'target_database', 'Database', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_targets' ,'target_interval', 'Interval', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_targets' ,'target_proc', 'Procedure', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_targets' ,'target_appt', 'Appointment', 30, 0);

-- Clinical Rule Target Intervals
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_target_intervals', 'Clinical Rules Target Intervals', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_target_intervals' ,'year', 'Year', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_target_intervals' ,'month', 'Month', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_target_intervals' ,'week', 'Week', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_target_intervals' ,'day', 'Day', 40, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_target_intervals' ,'hour', 'Hour', 50, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_target_intervals' ,'minute', 'Minute', 60, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_target_intervals' ,'second', 'Second', 70, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_target_intervals' ,'flu_season', 'Flu Season', 80, 0);

-- Clinical Rule Comparisons
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_comparisons', 'Clinical Rules Comparisons', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_comparisons' ,'EXIST', 'Exist', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_comparisons' ,'lt', 'Less Than', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_comparisons' ,'le', 'Less Than or Equal To', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_comparisons' ,'gt', 'Greater Than', 40, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_comparisons' ,'ge', 'Greater Than or Equal To', 50, 0);

-- Clinical Rule Filter Methods
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_filters','Clinical Rule Filter Methods', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_filters', 'filt_database', 'Database', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_filters', 'filt_diagnosis', 'Diagnosis', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_filters', 'filt_sex', 'Gender', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_filters', 'filt_age_max', 'Maximum Age', 40, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_filters', 'filt_age_min', 'Minimum Age', 50, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_filters', 'filt_proc', 'Procedure', 60, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_filters', 'filt_lists', 'Lists', 70, 0);

-- Clinical Rule Age Intervals
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_age_intervals', 'Clinical Rules Age Intervals', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_age_intervals' ,'year', 'Year', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_age_intervals' ,'month', 'Month', 20, 0);

-- Encounter Types (needed for mapping encounters for CQM rules)
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_enc_types', 'Clinical Rules Encounter Types', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_outpatient', 'encounter outpatient', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_nurs_fac', 'encounter nursing facility', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_off_vis', 'encounter office visit', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_hea_and_beh', 'encounter health and behavior assessment', 40, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_occ_ther', 'encounter occupational therapy', 50, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_psych_and_psych', 'encounter psychiatric & psychologic', 60, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_pre_med_ser_18_older', 'encounter preventive medicine services 18 and older', 70, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_pre_med_ser_40_older', 'encounter preventive medicine 40 and older', 75, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_pre_ind_counsel', 'encounter preventive medicine - individual counseling', 80, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_pre_med_group_counsel', 'encounter preventive medicine group counseling', 90, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_pre_med_other_serv', 'encounter preventive medicine other services', 100, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_out_pcp_obgyn', 'encounter outpatient w/PCP & obgyn', 110, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_pregnancy', 'encounter pregnancy', 120, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_nurs_discharge', 'encounter nursing discharge', 130, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_acute_inp_or_ed', 'encounter acute inpatient or ED', 130, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_nonac_inp_out_or_opth', 'Encounter: encounter non-acute inpt, outpatient, or ophthalmology', 140, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_enc_types' ,'enc_influenza', 'encounter influenza', 150, 0);

-- Clinical Rule Action Categories
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_action_category', 'Clinical Rule Action Category', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action_category' ,'act_cat_assess', 'Assessment', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action_category' ,'act_cat_edu', 'Education', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action_category' ,'act_cat_exam', 'Examination', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action_category' ,'act_cat_inter', 'Intervention', 40, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action_category' ,'act_cat_measure', 'Measurement', 50, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action_category' ,'act_cat_treat', 'Treatment', 60, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action_category' ,'act_cat_remind', 'Reminder', 70, 0);

-- Clinical Rule Action Items
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_action', 'Clinical Rule Action Item', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_bp', 'Blood Pressure', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_influvacc', 'Influenza Vaccine', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_tobacco', 'Tobacco', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_wt', 'Weight', 40, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_bmi', 'BMI', 43, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_nutrition', 'Nutrition', 45, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_exercise', 'Exercise', 47, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_pneumovacc', 'Pneumococcal Vaccine', 60, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_hemo_a1c', 'Hemoglobin A1C', 70, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_urine_alb', 'Urine Microalbumin', 80, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_eye', 'Opthalmic', 90, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_foot', 'Podiatric', 100, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_mammo', 'Mammogram', 110, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_pap', 'Pap Smear', 120, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_colon_cancer_screen', 'Colon Cancer Screening', 130, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_prostate_cancer_screen', 'Prostate Cancer Screening', 140, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_lab_inr', 'INR', 150, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_action' ,'act_appointment', 'Appointment', 160, 0);

-- Clinical Rule Reminder Intervals
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_reminder_intervals', 'Clinical Rules Reminder Intervals', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_intervals' ,'month', 'Month', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_intervals' ,'week', 'Week', 20, 0);

-- Clinical Rule Reminder Methods
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_reminder_methods', 'Clinical Rules Reminder Methods', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_methods' ,'clinical_reminder_pre', 'Past Due Interval (Clinical Reminders)', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_methods' ,'patient_reminder_pre', 'Past Due Interval (Patient Reminders)', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_methods' ,'clinical_reminder_post', 'Soon Due Interval (Clinical Reminders)', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_methods' ,'patient_reminder_post', 'Soon Due Interval (Patient Reminders)', 40, 0);

-- Clinical Rule Reminder Due Options
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_reminder_due_opt', 'Clinical Rules Reminder Due Options', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_due_opt' ,'due', 'Due', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_due_opt' ,'soon_due', 'Due Soon', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_due_opt' ,'past_due', 'Past Due', 30, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_due_opt' ,'not_due', 'Not Due', 30, 0);

-- Clinical Rule Reminder Inactivate Options
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('lists' ,'rule_reminder_inactive_opt', 'Clinical Rules Reminder Inactivation Options', 3, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_inactive_opt' ,'auto', 'Automatic', 10, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_inactive_opt' ,'due_status_update', 'Due Status Update', 20, 0);
INSERT INTO `list_options` ( `list_id`, `option_id`, `title`, `seq`, `is_default` ) VALUES ('rule_reminder_inactive_opt' ,'manual', 'Manual', 20, 0);

-- eRx User Roles
INSERT INTO list_options (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('newcrop_erx_role','erxadmin','NewCrop Admin','5','0','0','','');
INSERT INTO list_options (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('newcrop_erx_role','erxdoctor','NewCrop Doctor','20','0','0','','');
INSERT INTO list_options (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('newcrop_erx_role','erxmanager','NewCrop Manager','15','0','0','','');
INSERT INTO list_options (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('newcrop_erx_role','erxmidlevelPrescriber','NewCrop Midlevel Prescriber','25','0','0','','');
INSERT INTO list_options (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('newcrop_erx_role','erxnurse','NewCrop Nurse','10','0','0','','');
INSERT INTO list_options (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('newcrop_erx_role','erxsupervisingDoctor','NewCrop Supervising Doctor','30','0','0','','');
INSERT INTO list_options (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('lists','newcrop_erx_role','NewCrop eRx Role','221','0','0','','');

-- MSP remit codes
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('lists','msp_remit_codes','MSP Remit Codes','221','0','0','','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '1', '1', 1, 0, 0, '', 'Deductible Amount');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '2', '2', 2, 0, 0, '', 'Coinsurance Amount');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '3', '3', 3, 0, 0, '', 'Co-payment Amount');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '4', '4', 4, 0, 0, '', 'The procedure code is inconsistent with the modifier used or a required modifier is missing. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '9', '9', 9, 0, 0, '', 'The diagnosis is inconsistent with the patient''s age. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '10', '10', 10, 0, 0, '', 'The diagnosis is inconsistent with the patient''s gender. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '11', '11', 11, 0, 0, '', 'The diagnosis is inconsistent with the procedure. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '12', '12', 12, 0, 0, '', 'The diagnosis is inconsistent with the provider type. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '13', '13', 13, 0, 0, '', 'The date of death precedes the date of service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '14', '14', 14, 0, 0, '', 'The date of birth follows the date of service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '15', '15', 15, 0, 0, '', 'The authorization number is missing, invalid, or does not apply to the billed services or provider.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '16', '16', 16, 0, 0, '', 'Claim/service lacks information which is needed for adjudication. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '18', '18', 17, 0, 0, '', 'Duplicate claim/service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '19', '19', 18, 0, 0, '', 'This is a work-related injury/illness and thus the liability of the Worker''s Compensation Carrier.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '20', '20', 19, 0, 0, '', 'This injury/illness is covered by the liability carrier.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '21', '21', 20, 0, 0, '', 'This injury/illness is the liability of the no-fault carrier.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '22', '22', 21, 0, 0, '', 'This care may be covered by another payer per coordination of benefits.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '23', '23', 22, 0, 0, '', 'The impact of prior payer(s) adjudication including payments and/or adjustments.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '24', '24', 23, 0, 0, '', 'Charges are covered under a capitation agreement/managed care plan.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '26', '26', 24, 0, 0, '', 'Expenses incurred prior to coverage.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '27', '27', 25, 0, 0, '', 'Expenses incurred after coverage terminated.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '29', '29', 26, 0, 0, '', 'The time limit for filing has expired.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '31', '31', 27, 0, 0, '', 'Patient cannot be identified as our insured.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '32', '32', 28, 0, 0, '', 'Our records indicate that this dependent is not an eligible dependent as defined.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '33', '33', 29, 0, 0, '', 'Insured has no dependent coverage.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '34', '34', 30, 0, 0, '', 'Insured has no coverage for newborns.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '35', '35', 31, 0, 0, '', 'Lifetime benefit maximum has been reached.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '38', '38', 32, 0, 0, '', 'Services not provided or authorized by designated (network/primary care) providers.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '39', '39', 33, 0, 0, '', 'Services denied at the time authorization/pre-certification was requested.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '40', '40', 34, 0, 0, '', 'Charges do not meet qualifications for emergent/urgent care. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '44', '44', 35, 0, 0, '', 'Prompt-pay discount.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '45', '45', 36, 0, 0, '', 'Charge exceeds fee schedule/maximum allowable or contracted/legislated fee arrangement. (Use Group Codes PR or CO depending upon liability).');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '49', '49', 37, 0, 0, '', 'These are non-covered services because this is a routine exam or screening procedure done in conjunction with a routine exam. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '50', '50', 38, 0, 0, '', 'These are non-covered services because this is not deemed a ''medical necessity'' by the payer. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '51', '51', 39, 0, 0, '', 'These are non-covered services because this is a pre-existing condition. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '53', '53', 40, 0, 0, '', 'Services by an immediate relative or a member of the same household are not covered.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '54', '54', 41, 0, 0, '', 'Multiple physicians/assistants are not covered in this case. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '55', '55', 42, 0, 0, '', 'Procedure/treatment is deemed experimental/investigational by the payer. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '56', '56', 43, 0, 0, '', 'Procedure/treatment has not been deemed ''proven to be effective'' by the payer. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '58', '58', 44, 0, 0, '', 'Treatment was deemed by the payer to have been rendered in an inappropriate or invalid place of service. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '59', '59', 45, 0, 0, '', 'Processed based on multiple or concurrent procedure rules. (For example multiple surgery or diagnostic imaging, concurrent anesthesia.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '60', '60', 46, 0, 0, '', 'Charges for outpatient services are not covered when performed within a period of time prior to or after inpatient services.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '61', '61', 47, 0, 0, '', 'Penalty for failure to obtain second surgical opinion. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '66', '66', 48, 0, 0, '', 'Blood Deductible.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '69', '69', 49, 0, 0, '', 'Day outlier amount.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '70', '70', 50, 0, 0, '', 'Cost outlier - Adjustment to compensate for additional costs.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '74', '74', 51, 0, 0, '', 'Indirect Medical Education Adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '75', '75', 52, 0, 0, '', 'Direct Medical Education Adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '76', '76', 53, 0, 0, '', 'Disproportionate Share Adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '78', '78', 54, 0, 0, '', 'Non-Covered days/Room charge adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '85', '85', 55, 0, 0, '', 'Patient Interest Adjustment (Use Only Group code PR)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '87', '87', 56, 0, 0, '', 'Transfer amount.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '89', '89', 57, 0, 0, '', 'Professional fees removed from charges.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '90', '90', 58, 0, 0, '', 'Ingredient cost adjustment. Note: To be used for pharmaceuticals only.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '91', '91', 59, 0, 0, '', 'Dispensing fee adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '94', '94', 60, 0, 0, '', 'Processed in Excess of charges.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '95', '95', 61, 0, 0, '', 'Plan procedures not followed.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '96', '96', 62, 0, 0, '', 'Non-covered charge(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.) Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 S');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '97', '97', 63, 0, 0, '', 'The benefit for this service is included in the payment/allowance for another service/procedure that has already been adjudicated. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '100', '100', 64, 0, 0, '', 'Payment made to patient/insured/responsible party/employer.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '101', '101', 65, 0, 0, '', 'Predetermination: anticipated payment upon completion of services or claim adjudication.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '102', '102', 66, 0, 0, '', 'Major Medical Adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '103', '103', 67, 0, 0, '', 'Provider promotional discount (e.g., Senior citizen discount).');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '104', '104', 68, 0, 0, '', 'Managed care withholding.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '105', '105', 69, 0, 0, '', 'Tax withholding.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '106', '106', 70, 0, 0, '', 'Patient payment option/election not in effect.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '107', '107', 71, 0, 0, '', 'The related or qualifying claim/service was not identified on this claim. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '108', '108', 72, 0, 0, '', 'Rent/purchase guidelines were not met. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '109', '109', 73, 0, 0, '', 'Claim not covered by this payer/contractor. You must send the claim to the correct payer/contractor.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '110', '110', 74, 0, 0, '', 'Billing date predates service date.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '111', '111', 75, 0, 0, '', 'Not covered unless the provider accepts assignment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '112', '112', 76, 0, 0, '', 'Service not furnished directly to the patient and/or not documented.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '114', '114', 77, 0, 0, '', 'Procedure/product not approved by the Food and Drug Administration.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '115', '115', 78, 0, 0, '', 'Procedure postponed, canceled, or delayed.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '116', '116', 79, 0, 0, '', 'The advance indemnification notice signed by the patient did not comply with requirements.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '117', '117', 80, 0, 0, '', 'Transportation is only covered to the closest facility that can provide the necessary care.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '118', '118', 81, 0, 0, '', 'ESRD network support adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '119', '119', 82, 0, 0, '', 'Benefit maximum for this time period or occurrence has been reached.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '121', '121', 83, 0, 0, '', 'Indemnification adjustment - compensation for outstanding member responsibility.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '122', '122', 84, 0, 0, '', 'Psychiatric reduction.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '125', '125', 85, 0, 0, '', 'Submission/billing error(s). At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '128', '128', 86, 0, 0, '', 'Newborn''s services are covered in the mother''s Allowance.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '129', '129', 87, 0, 0, '', 'Prior processing information appears incorrect. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '130', '130', 88, 0, 0, '', 'Claim submission fee.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '131', '131', 89, 0, 0, '', 'Claim specific negotiated discount.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '132', '132', 90, 0, 0, '', 'Prearranged demonstration project adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '133', '133', 91, 0, 0, '', 'The disposition of this claim/service is pending further review.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '134', '134', 92, 0, 0, '', 'Technical fees removed from charges.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '135', '135', 93, 0, 0, '', 'Interim bills cannot be processed.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '136', '136', 94, 0, 0, '', 'Failure to follow prior payer''s coverage rules. (Use Group Code OA).');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '137', '137', 95, 0, 0, '', 'Regulatory Surcharges, Assessments, Allowances or Health Related Taxes.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '138', '138', 96, 0, 0, '', 'Appeal procedures not followed or time limits not met.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '139', '139', 97, 0, 0, '', 'Contracted funding agreement - Subscriber is employed by the provider of services.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '140', '140', 98, 0, 0, '', 'Patient/Insured health identification number and name do not match.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '141', '141', 99, 0, 0, '', 'Claim spans eligible and ineligible periods of coverage.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '142', '142', 100, 0, 0, '', 'Monthly Medicaid patient liability amount.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '143', '143', 101, 0, 0, '', 'Portion of payment deferred.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '144', '144', 102, 0, 0, '', 'Incentive adjustment, e.g. preferred product/service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '146', '146', 103, 0, 0, '', 'Diagnosis was invalid for the date(s) of service reported.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '147', '147', 104, 0, 0, '', 'Provider contracted/negotiated rate expired or not on file.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '148', '148', 105, 0, 0, '', 'Information from another provider was not provided or was insufficient/incomplete. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '149', '149', 106, 0, 0, '', 'Lifetime benefit maximum has been reached for this service/benefit category.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '150', '150', 107, 0, 0, '', 'Payer deems the information submitted does not support this level of service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '151', '151', 108, 0, 0, '', 'Payment adjusted because the payer deems the information submitted does not support this many/frequency of services.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '152', '152', 109, 0, 0, '', 'Payer deems the information submitted does not support this length of service. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '153', '153', 110, 0, 0, '', 'Payer deems the information submitted does not support this dosage.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '154', '154', 111, 0, 0, '', 'Payer deems the information submitted does not support this day''s supply.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '155', '155', 112, 0, 0, '', 'Patient refused the service/procedure.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '157', '157', 113, 0, 0, '', 'Service/procedure was provided as a result of an act of war.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '158', '158', 114, 0, 0, '', 'Service/procedure was provided outside of the United States.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '159', '159', 115, 0, 0, '', 'Service/procedure was provided as a result of terrorism.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '160', '160', 116, 0, 0, '', 'Injury/illness was the result of an activity that is a benefit exclusion.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '161', '161', 117, 0, 0, '', 'Provider performance bonus');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '162', '162', 118, 0, 0, '', 'State-mandated Requirement for Property and Casualty, see Claim Payment Remarks Code for specific explanation.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '163', '163', 119, 0, 0, '', 'Attachment referenced on the claim was not received.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '164', '164', 120, 0, 0, '', 'Attachment referenced on the claim was not received in a timely fashion.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '165', '165', 121, 0, 0, '', 'Referral absent or exceeded.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '166', '166', 122, 0, 0, '', 'These services were submitted after this payers responsibility for processing claims under this plan ended.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '167', '167', 123, 0, 0, '', 'This (these) diagnosis(es) is (are) not covered. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '168', '168', 124, 0, 0, '', 'Service(s) have been considered under the patient''s medical plan. Benefits are not available under this dental plan.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '169', '169', 125, 0, 0, '', 'Alternate benefit has been provided.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '170', '170', 126, 0, 0, '', 'Payment is denied when performed/billed by this type of provider. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '171', '171', 127, 0, 0, '', 'Payment is denied when performed/billed by this type of provider in this type of facility. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '172', '172', 128, 0, 0, '', 'Payment is adjusted when performed/billed by a provider of this specialty. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '173', '173', 129, 0, 0, '', 'Service was not prescribed by a physician.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '174', '174', 130, 0, 0, '', 'Service was not prescribed prior to delivery.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '175', '175', 131, 0, 0, '', 'Prescription is incomplete.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '176', '176', 132, 0, 0, '', 'Prescription is not current.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '177', '177', 133, 0, 0, '', 'Patient has not met the required eligibility requirements.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '178', '178', 134, 0, 0, '', 'Patient has not met the required spend down requirements.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '179', '179', 135, 0, 0, '', 'Patient has not met the required waiting requirements. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '180', '180', 136, 0, 0, '', 'Patient has not met the required residency requirements.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '181', '181', 137, 0, 0, '', 'Procedure code was invalid on the date of service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '182', '182', 138, 0, 0, '', 'Procedure modifier was invalid on the date of service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '183', '183', 139, 0, 0, '', 'The referring provider is not eligible to refer the service billed. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '184', '184', 140, 0, 0, '', 'The prescribing/ordering provider is not eligible to prescribe/order the service billed. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '185', '185', 141, 0, 0, '', 'The rendering provider is not eligible to perform the service billed. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '186', '186', 142, 0, 0, '', 'Level of care change adjustment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '187', '187', 143, 0, 0, '', 'Consumer Spending Account payments (includes but is not limited to Flexible Spending Account, Health Savings Account, Health Reimbursement Account, etc.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '188', '188', 144, 0, 0, '', 'This product/procedure is only covered when used according to FDA recommendations.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '189', '189', 145, 0, 0, '', '''''Not otherwise classified'' or ''unlisted'' procedure code (CPT/HCPCS) was billed when there is a specific procedure code for this procedure/service''');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '190', '190', 146, 0, 0, '', 'Payment is included in the allowance for a Skilled Nursing Facility (SNF) qualified stay.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '191', '191', 147, 0, 0, '', 'Not a work related injury/illness and thus not the liability of the workers'' compensation carrier Note: If adjustment is at the Claim Level, the payer must send and the provider should refer to the 835 Insurance Policy Number Segment (Loop 2100 Other Clai');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '192', '192', 148, 0, 0, '', 'Non standard adjustment code from paper remittance. Note: This code is to be used by providers/payers providing Coordination of Benefits information to another payer in the 837 transaction only. This code is only used when the non-standard code cannot be ');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '193', '193', 149, 0, 0, '', 'Original payment decision is being maintained. Upon review, it was determined that this claim was processed properly.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '194', '194', 150, 0, 0, '', 'Anesthesia performed by the operating physician, the assistant surgeon or the attending physician.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '195', '195', 151, 0, 0, '', 'Refund issued to an erroneous priority payer for this claim/service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '197', '197', 152, 0, 0, '', 'Precertification/authorization/notification absent.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '198', '198', 153, 0, 0, '', 'Precertification/authorization exceeded.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '199', '199', 154, 0, 0, '', 'Revenue code and Procedure code do not match.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '200', '200', 155, 0, 0, '', 'Expenses incurred during lapse in coverage');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '201', '201', 156, 0, 0, '', 'Workers Compensation case settled. Patient is responsible for amount of this claim/service through WC ''Medicare set aside arrangement'' or other agreement. (Use group code PR).');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '202', '202', 157, 0, 0, '', 'Non-covered personal comfort or convenience services.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '203', '203', 158, 0, 0, '', 'Discontinued or reduced service.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '204', '204', 159, 0, 0, '', 'This service/equipment/drug is not covered under the patient?s current benefit plan');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '205', '205', 160, 0, 0, '', 'Pharmacy discount card processing fee');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '206', '206', 161, 0, 0, '', 'National Provider Identifier - missing.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '207', '207', 162, 0, 0, '', 'National Provider identifier - Invalid format');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '208', '208', 163, 0, 0, '', 'National Provider Identifier - Not matched.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '209', '209', 164, 0, 0, '', 'Per regulatory or other agreement. The provider cannot collect this amount from the patient. However, this amount may be billed to subsequent payer. Refund to patient if collected. (Use Group code OA)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '210', '210', 165, 0, 0, '', 'Payment adjusted because pre-certification/authorization not received in a timely fashion');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '211', '211', 166, 0, 0, '', 'National Drug Codes (NDC) not eligible for rebate, are not covered.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '212', '212', 167, 0, 0, '', 'Administrative surcharges are not covered');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '213', '213', 168, 0, 0, '', 'Non-compliance with the physician self referral prohibition legislation or payer policy.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '214', '214', 169, 0, 0, '', 'Workers'' Compensation claim adjudicated as non-compensable. This Payer not liable for claim or service/treatment. Note: If adjustment is at the Claim Level, the payer must send and the provider should refer to the 835 Insurance Policy Number Segment (Loop');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '215', '215', 170, 0, 0, '', 'Based on subrogation of a third party settlement');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '216', '216', 171, 0, 0, '', 'Based on the findings of a review organization');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '217', '217', 172, 0, 0, '', 'Based on payer reasonable and customary fees. No maximum allowable defined by legislated fee arrangement. (Note: To be used for Workers'' Compensation only)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '218', '218', 173, 0, 0, '', 'Based on entitlement to benefits. Note: If adjustment is at the Claim Level, the payer must send and the provider should refer to the 835 Insurance Policy Number Segment (Loop 2100 Other Claim Related Information REF qualifier ''IG'') for the jurisdictional');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '219', '219', 174, 0, 0, '', 'Based on extent of injury. Note: If adjustment is at the Claim Level, the payer must send and the provider should refer to the 835 Insurance Policy Number Segment (Loop 2100 Other Claim Related Information REF qualifier ''IG'') for the jurisdictional regula');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '220', '220', 175, 0, 0, '', 'The applicable fee schedule does not contain the billed code. Please resubmit a bill with the appropriate fee schedule code(s) that best describe the service(s) provided and supporting documentation if required. (Note: To be used for Workers'' Compensation');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '221', '221', 176, 0, 0, '', 'Workers'' Compensation claim is under investigation. Note: If adjustment is at the Claim Level, the payer must send and the provider should refer to the 835 Insurance Policy Number Segment (Loop 2100 Other Claim Related Information REF qualifier ''IG'') for ');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '222', '222', 177, 0, 0, '', 'Exceeds the contracted maximum number of hours/days/units by this provider for this period. This is not patient specific. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '223', '223', 178, 0, 0, '', 'Adjustment code for mandated federal, state or local law/regulation that is not already covered by another code and is mandated before a new code can be created.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '224', '224', 179, 0, 0, '', 'Patient identification compromised by identity theft. Identity verification required for processing this and future claims.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '225', '225', 180, 0, 0, '', 'Penalty or Interest Payment by Payer (Only used for plan to plan encounter reporting within the 837)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '226', '226', 181, 0, 0, '', 'Information requested from the Billing/Rendering Provider was not provided or was insufficient/incomplete. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '227', '227', 182, 0, 0, '', 'Information requested from the patient/insured/responsible party was not provided or was insufficient/incomplete. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is ');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '228', '228', 183, 0, 0, '', 'Denied for failure of this provider, another provider or the subscriber to supply requested information to a previous payer for their adjudication');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '229', '229', 184, 0, 0, '', 'Partial charge amount not considered by Medicare due to the initial claim Type of Bill being 12X. Note: This code can only be used in the 837 transaction to convey Coordination of Benefits information when the secondary payer?s cost avoidance policy allow');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '230', '230', 185, 0, 0, '', 'No available or correlating CPT/HCPCS code to describe this service. Note: Used only by Property and Casualty.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '231', '231', 186, 0, 0, '', 'Mutually exclusive procedures cannot be done in the same day/setting. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '232', '232', 187, 0, 0, '', 'Institutional Transfer Amount. Note - Applies to institutional claims only and explains the DRG amount difference when the patient care crosses multiple institutions.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '233', '233', 188, 0, 0, '', 'Services/charges related to the treatment of a hospital-acquired condition or preventable medical error.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '234', '234', 189, 0, 0, '', 'This procedure is not paid separately. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '235', '235', 190, 0, 0, '', 'Sales Tax');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '236', '236', 191, 0, 0, '', 'This procedure or procedure/modifier combination is not compatible with another procedure or procedure/modifier combination provided on the same day according to the National Correct Coding Initiative.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', '237', '237', 192, 0, 0, '', 'Legislated/Regulatory Penalty. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'A0', 'A0', 193, 0, 0, '', 'Patient refund amount.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'A1', 'A1', 194, 0, 0, '', 'Claim/Service denied. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'A5', 'A5', 195, 0, 0, '', 'Medicare Claim PPS Capital Cost Outlier Amount.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'A6', 'A6', 196, 0, 0, '', 'Prior hospitalization or 30 day transfer requirement not met.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'A7', 'A7', 197, 0, 0, '', 'Presumptive Payment Adjustment');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'A8', 'A8', 198, 0, 0, '', 'Ungroupable DRG.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B1', 'B1', 199, 0, 0, '', 'Non-covered visits.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B10', 'B10', 200, 0, 0, '', 'Allowed amount has been reduced because a component of the basic procedure/test was paid. The beneficiary is not liable for more than the charge limit for the basic procedure/test.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B11', 'B11', 201, 0, 0, '', 'The claim/service has been transferred to the proper payer/processor for processing. Claim/service not covered by this payer/processor.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B12', 'B12', 202, 0, 0, '', 'Services not documented in patients'' medical records.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B13', 'B13', 203, 0, 0, '', 'Previously paid. Payment for this claim/service may have been provided in a previous payment.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B14', 'B14', 204, 0, 0, '', 'Only one visit or consultation per physician per day is covered.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B15', 'B15', 205, 0, 0, '', 'This service/procedure requires that a qualifying service/procedure be received and covered. The qualifying other service/procedure has not been received/adjudicated. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payme');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B16', 'B16', 206, 0, 0, '', '''''New Patient'' qualifications were not met.''');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B20', 'B20', 207, 0, 0, '', 'Procedure/service was partially or fully furnished by another provider.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B22', 'B22', 208, 0, 0, '', 'This payment is adjusted based on the diagnosis.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B23', 'B23', 209, 0, 0, '', 'Procedure billed is not authorized per your Clinical Laboratory Improvement Amendment (CLIA) proficiency test.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B4', 'B4', 210, 0, 0, '', 'Late filing penalty.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B5', 'B5', 211, 0, 0, '', 'Coverage/program guidelines were not met or were exceeded.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B7', 'B7', 212, 0, 0, '', 'This provider was not certified/eligible to be paid for this procedure/service on this date of service. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B8', 'B8', 213, 0, 0, '', 'Alternative services were available, and should have been utilized. Note: Refer to the 835 Healthcare Policy Identification Segment (loop 2110 Service Payment Information REF), if present.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'B9', 'B9', 214, 0, 0, '', 'Patient is enrolled in a Hospice.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'D23', 'D23', 215, 0, 0, '', 'This dual eligible patient is covered by Medicare Part D per Medicare Retro-Eligibility. At least one Remark Code must be provided (may be comprised of either the NCPDP Reject Reason Code, or Remittance Advice Remark Code that is not an ALERT.)');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'W1', 'W1', 216, 0, 0, '', 'Workers'' compensation jurisdictional fee schedule adjustment. Note: If adjustment is at the Claim Level, the payer must send and the provider should refer to the 835 Class of Contract Code Identification Segment (Loop 2100 Other Claim Related Information ');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('msp_remit_codes', 'W2', 'W2', 217, 0, 0, '', 'Payment reduced or denied based on workers'' compensation jurisdictional regulations or payment policies, use only if no other code is applicable. Note: If adjustment is at the Claim Level, the payer must send and the provider should refer to the 835 Insur');

INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('lists','nation_notes_replace_buttons','Nation Notes Replace Buttons',1);
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('nation_notes_replace_buttons','Yes','Yes',10);
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('nation_notes_replace_buttons','No','No',20);
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('nation_notes_replace_buttons','Normal','Normal',30);
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`) VALUES ('nation_notes_replace_buttons','Abnormal','Abnormal',40);
insert into `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) values('lists','payment_gateways','Payment Gateways','297','1','0','','');
insert into `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) values('payment_gateways','authorize_net','Authorize.net','1','0','0','','');

insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('lists','ptlistcols','Patient List Columns','1','0','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','name'      ,'Full Name'     ,'10','3','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','phone_home','Home Phone'    ,'20','3','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','ss'        ,'SSN'           ,'30','3','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','DOB'       ,'Date of Birth' ,'40','3','','');
insert into list_options (list_id, option_id, title, seq, option_value, mapping, notes) values('ptlistcols','pubpid'    ,'External ID'   ,'50','3','','');

INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('lists', 'Branch', 'Branch', 222, 1, 0, '', '');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('Branch', 'N', 'N', 1, 0, 0, '', '');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('lists', 'Branch_State', 'Branch State', 223, 1, 0, '', '');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('Branch_State', 'NY', 'New York', 2, 0, 0, '', '');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('Branch_State', 'CA', 'California', 1, 0, 0, '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `lists`
-- 

DROP TABLE IF EXISTS `lists`;
CREATE TABLE `lists` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `type` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `begdate` date default NULL,
  `enddate` date default NULL,
  `returndate` date default NULL,
  `occurrence` int(11) default '0',
  `classification` int(11) default '0',
  `referredby` varchar(255) default NULL,
  `extrainfo` varchar(255) default NULL,
  `diagnosis` varchar(255) default NULL,
  `activity` tinyint(4) default NULL,
  `comments` longtext,
  `pid` bigint(20) default NULL,
  `user` varchar(255) default NULL,
  `groupname` varchar(255) default NULL,
  `outcome` int(11) NOT NULL default '0',
  `destination` varchar(255) default NULL,
  `reinjury_id` bigint(20)  NOT NULL DEFAULT 0,
  `injury_part` varchar(31) NOT NULL DEFAULT '',
  `injury_type` varchar(31) NOT NULL DEFAULT '',
  `injury_grade` varchar(31) NOT NULL DEFAULT '',
  `reaction` varchar(255) NOT NULL DEFAULT '',
  `external_allergyid` INT(11) DEFAULT NULL,
  `erx_source` ENUM('0','1') DEFAULT '0' NOT NULL  COMMENT '0-OpenEMR 1-External',
  `erx_uploaded` ENUM('0','1') DEFAULT '0' NOT NULL  COMMENT '0-Pending NewCrop upload 1-Uploaded TO NewCrop',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lists_touch`
--

DROP TABLE IF EXISTS `lists_touch`;
CREATE TABLE `lists_touch` (
  `pid` bigint(20) default NULL,
  `type` varchar(255) default NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`pid`,`type`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

-- 
-- Table structure for table `log`
-- 

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `event` varchar(255) default NULL,
  `user` varchar(255) default NULL,
  `groupname` varchar(255) default NULL,
  `comments` longtext,
  `user_notes` longtext,
  `patient_id` bigint(20) default NULL,
  `success` tinyint(1) default 1,
  `checksum` longtext default NULL,
  `crt_user` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `notes`
-- 

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL default '0',
  `foreign_id` int(11) NOT NULL default '0',
  `note` varchar(255) default NULL,
  `owner` int(11) default NULL,
  `date` datetime default NULL,
  `revision` timestamp NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `foreign_id` (`owner`),
  KEY `foreign_id_2` (`foreign_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `onotes`
-- 

DROP TABLE IF EXISTS `onotes`;
CREATE TABLE `onotes` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `body` longtext,
  `user` varchar(255) default NULL,
  `groupname` varchar(255) default NULL,
  `activity` tinyint(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `openemr_module_vars`
-- 

DROP TABLE IF EXISTS `openemr_module_vars`;
CREATE TABLE `openemr_module_vars` (
  `pn_id` int(11) unsigned NOT NULL auto_increment,
  `pn_modname` varchar(64) default NULL,
  `pn_name` varchar(64) default NULL,
  `pn_value` longtext,
  PRIMARY KEY  (`pn_id`),
  KEY `pn_modname` (`pn_modname`),
  KEY `pn_name` (`pn_name`)
) ENGINE=MyISAM AUTO_INCREMENT=235 ;

-- 
-- Dumping data for table `openemr_module_vars`
-- 

INSERT INTO `openemr_module_vars` VALUES (234, 'PostCalendar', 'pcNotifyEmail', '');
INSERT INTO `openemr_module_vars` VALUES (233, 'PostCalendar', 'pcNotifyAdmin', '0');
INSERT INTO `openemr_module_vars` VALUES (232, 'PostCalendar', 'pcCacheLifetime', '3600');
INSERT INTO `openemr_module_vars` VALUES (231, 'PostCalendar', 'pcUseCache', '0');
INSERT INTO `openemr_module_vars` VALUES (230, 'PostCalendar', 'pcDefaultView', 'day');
INSERT INTO `openemr_module_vars` VALUES (229, 'PostCalendar', 'pcTimeIncrement', '5');
INSERT INTO `openemr_module_vars` VALUES (228, 'PostCalendar', 'pcAllowUserCalendar', '1');
INSERT INTO `openemr_module_vars` VALUES (227, 'PostCalendar', 'pcAllowSiteWide', '1');
INSERT INTO `openemr_module_vars` VALUES (226, 'PostCalendar', 'pcTemplate', 'default');
INSERT INTO `openemr_module_vars` VALUES (225, 'PostCalendar', 'pcEventDateFormat', '%Y-%m-%d');
INSERT INTO `openemr_module_vars` VALUES (224, 'PostCalendar', 'pcDisplayTopics', '0');
INSERT INTO `openemr_module_vars` VALUES (223, 'PostCalendar', 'pcListHowManyEvents', '15');
INSERT INTO `openemr_module_vars` VALUES (222, 'PostCalendar', 'pcAllowDirectSubmit', '1');
INSERT INTO `openemr_module_vars` VALUES (221, 'PostCalendar', 'pcUsePopups', '0');
INSERT INTO `openemr_module_vars` VALUES (220, 'PostCalendar', 'pcDayHighlightColor', '#EEEEEE');
INSERT INTO `openemr_module_vars` VALUES (219, 'PostCalendar', 'pcFirstDayOfWeek', '1');
INSERT INTO `openemr_module_vars` VALUES (218, 'PostCalendar', 'pcUseInternationalDates', '0');
INSERT INTO `openemr_module_vars` VALUES (217, 'PostCalendar', 'pcEventsOpenInNewWindow', '0');
INSERT INTO `openemr_module_vars` VALUES (216, 'PostCalendar', 'pcTime24Hours', '0');

-- --------------------------------------------------------

-- 
-- Table structure for table `openemr_modules`
-- 

DROP TABLE IF EXISTS `openemr_modules`;
CREATE TABLE `openemr_modules` (
  `pn_id` int(11) unsigned NOT NULL auto_increment,
  `pn_name` varchar(64) default NULL,
  `pn_type` int(6) NOT NULL default '0',
  `pn_displayname` varchar(64) default NULL,
  `pn_description` varchar(255) default NULL,
  `pn_regid` int(11) unsigned NOT NULL default '0',
  `pn_directory` varchar(64) default NULL,
  `pn_version` varchar(10) default NULL,
  `pn_admin_capable` tinyint(1) NOT NULL default '0',
  `pn_user_capable` tinyint(1) NOT NULL default '0',
  `pn_state` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`pn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 ;

-- 
-- Dumping data for table `openemr_modules`
-- 

INSERT INTO `openemr_modules` VALUES (46, 'PostCalendar', 2, 'PostCalendar', 'PostNuke Calendar Module', 0, 'PostCalendar', '4.0.0', 1, 1, 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `openemr_postcalendar_categories`
-- 

DROP TABLE IF EXISTS `openemr_postcalendar_categories`;
CREATE TABLE `openemr_postcalendar_categories` (
  `pc_catid` int(11) unsigned NOT NULL auto_increment,
  `pc_catname` varchar(100) default NULL,
  `pc_catcolor` varchar(50) default NULL,
  `pc_catdesc` text,
  `pc_recurrtype` int(1) NOT NULL default '0',
  `pc_enddate` date default NULL,
  `pc_recurrspec` text,
  `pc_recurrfreq` int(3) NOT NULL default '0',
  `pc_duration` bigint(20) NOT NULL default '0',
  `pc_end_date_flag` tinyint(1) NOT NULL default '0',
  `pc_end_date_type` int(2) default NULL,
  `pc_end_date_freq` int(11) NOT NULL default '0',
  `pc_end_all_day` tinyint(1) NOT NULL default '0',
  `pc_dailylimit` int(2) NOT NULL default '0',
  `pc_cattype` INT( 11 ) NOT NULL COMMENT 'Used in grouping categories',
  PRIMARY KEY  (`pc_catid`),
  KEY `basic_cat` (`pc_catname`,`pc_catcolor`)
) ENGINE=MyISAM AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `openemr_postcalendar_categories`
-- 

INSERT INTO `openemr_postcalendar_categories` VALUES (5, 'Office Visit', '#FFFFCC', 'Normal Office Visit', 0, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 900, 0, 0, 0, 0, 0,0);
INSERT INTO `openemr_postcalendar_categories` VALUES (4, 'Vacation', '#EFEFEF', 'Reserved for use to define Scheduled Vacation Time', 0, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 0, 0, 0, 0, 1, 0, 1);
INSERT INTO `openemr_postcalendar_categories` VALUES (1, 'No Show', '#DDDDDD', 'Reserved to define when an event did not occur as specified.', 0, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `openemr_postcalendar_categories` VALUES (2, 'In Office', '#99CCFF', 'Reserved todefine when a provider may haveavailable appointments after.', 1, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"1";s:22:"event_repeat_freq_type";s:1:"4";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 0, 1, 3, 2, 0, 0, 1);
INSERT INTO `openemr_postcalendar_categories` VALUES (3, 'Out Of Office', '#99FFFF', 'Reserved to define when a provider may not have available appointments after.', 1, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"1";s:22:"event_repeat_freq_type";s:1:"4";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 0, 1, 3, 2, 0, 0, 1);
INSERT INTO `openemr_postcalendar_categories` VALUES (8, 'Lunch', '#FFFF33', 'Lunch', 1, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"1";s:22:"event_repeat_freq_type";s:1:"4";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 3600, 0, 3, 2, 0, 0, 1);
INSERT INTO `openemr_postcalendar_categories` VALUES (9, 'Established Patient', '#CCFF33', '', 0, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 900, 0, 0, 0, 0, 0, 0);
INSERT INTO `openemr_postcalendar_categories` VALUES (10,'New Patient', '#CCFFFF', '', 0, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 1800, 0, 0, 0, 0, 0, 0);
INSERT INTO `openemr_postcalendar_categories` VALUES (11,'Reserved','#FF7777','Reserved',1,NULL,'a:5:{s:17:\"event_repeat_freq\";s:1:\"1\";s:22:\"event_repeat_freq_type\";s:1:\"4\";s:19:\"event_repeat_on_num\";s:1:\"1\";s:19:\"event_repeat_on_day\";s:1:\"0\";s:20:\"event_repeat_on_freq\";s:1:\"0\";}',0,900,0,3,2,0,0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `openemr_postcalendar_events`
-- 

DROP TABLE IF EXISTS `openemr_postcalendar_events`;
CREATE TABLE `openemr_postcalendar_events` (
  `pc_eid` int(11) unsigned NOT NULL auto_increment,
  `pc_catid` int(11) NOT NULL default '0',
  `pc_multiple` int(10) unsigned NOT NULL,
  `pc_aid` varchar(30) default NULL,
  `pc_pid` varchar(11) default NULL,
  `pc_title` varchar(150) default NULL,
  `pc_time` datetime default NULL,
  `pc_hometext` text,
  `pc_comments` int(11) default '0',
  `pc_counter` mediumint(8) unsigned default '0',
  `pc_topic` int(3) NOT NULL default '1',
  `pc_informant` varchar(20) default NULL,
  `pc_eventDate` date NOT NULL default '0000-00-00',
  `pc_endDate` date NOT NULL default '0000-00-00',
  `pc_duration` bigint(20) NOT NULL default '0',
  `pc_recurrtype` int(1) NOT NULL default '0',
  `pc_recurrspec` text,
  `pc_recurrfreq` int(3) NOT NULL default '0',
  `pc_startTime` time default NULL,
  `pc_endTime` time default NULL,
  `pc_alldayevent` int(1) NOT NULL default '0',
  `pc_location` text,
  `pc_conttel` varchar(50) default NULL,
  `pc_contname` varchar(50) default NULL,
  `pc_contemail` varchar(255) default NULL,
  `pc_website` varchar(255) default NULL,
  `pc_fee` varchar(50) default NULL,
  `pc_eventstatus` int(11) NOT NULL default '0',
  `pc_sharing` int(11) NOT NULL default '0',
  `pc_language` varchar(30) default NULL,
  `pc_apptstatus` varchar(15) NOT NULL default '-',
  `pc_prefcatid` int(11) NOT NULL default '0',
  `pc_facility` smallint(6) NOT NULL default '0' COMMENT 'facility id for this event',
  `pc_sendalertsms` VARCHAR(3) NOT NULL DEFAULT 'NO',
  `pc_sendalertemail` VARCHAR( 3 ) NOT NULL DEFAULT 'NO',
  `pc_billing_location` SMALLINT (6) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`pc_eid`),
  KEY `basic_event` (`pc_catid`,`pc_aid`,`pc_eventDate`,`pc_endDate`,`pc_eventstatus`,`pc_sharing`,`pc_topic`),
  KEY `pc_eventDate` (`pc_eventDate`)
) ENGINE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `openemr_postcalendar_events`
-- 

INSERT INTO `openemr_postcalendar_events` VALUES (3, 2, 0, '1', '', 'In Office', '2005-03-03 12:22:31', ':text:', 0, 0, 0, '1', '2005-03-03', '2007-03-03', 0, 1, 'a:5:{s:17:"event_repeat_freq";s:1:"1";s:22:"event_repeat_freq_type";s:1:"4";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, '09:00:00', '09:00:00', 0, 'a:6:{s:14:"event_location";N;s:13:"event_street1";N;s:13:"event_street2";N;s:10:"event_city";N;s:11:"event_state";N;s:12:"event_postal";N;}', '', '', '', '', '', 1, 1, '', '-', 0, 0, 'NO', 'NO');
INSERT INTO `openemr_postcalendar_events` VALUES (5, 3, 0, '1', '', 'Out Of Office', '2005-03-03 12:22:52', ':text:', 0, 0, 0, '1', '2005-03-03', '2007-03-03', 0, 1, 'a:5:{s:17:"event_repeat_freq";s:1:"1";s:22:"event_repeat_freq_type";s:1:"4";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, '17:00:00', '17:00:00', 0, 'a:6:{s:14:"event_location";N;s:13:"event_street1";N;s:13:"event_street2";N;s:10:"event_city";N;s:11:"event_state";N;s:12:"event_postal";N;}', '', '', '', '', '', 1, 1, '', '-', 0, 0, 'NO', 'NO');
INSERT INTO `openemr_postcalendar_events` VALUES (6, 8, 0, '1', '', 'Lunch', '2005-03-03 12:23:31', ':text:', 0, 0, 0, '1', '2005-03-03', '2007-03-03', 3600, 1, 'a:5:{s:17:"event_repeat_freq";s:1:"1";s:22:"event_repeat_freq_type";s:1:"4";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, '12:00:00', '13:00:00', 0, 'a:6:{s:14:"event_location";N;s:13:"event_street1";N;s:13:"event_street2";N;s:10:"event_city";N;s:11:"event_state";N;s:12:"event_postal";N;}', '', '', '', '', '', 1, 1, '', '-', 0, 0, 'NO', 'NO');

-- --------------------------------------------------------

-- 
-- Table structure for table `openemr_postcalendar_limits`
-- 

DROP TABLE IF EXISTS `openemr_postcalendar_limits`;
CREATE TABLE `openemr_postcalendar_limits` (
  `pc_limitid` int(11) NOT NULL auto_increment,
  `pc_catid` int(11) NOT NULL default '0',
  `pc_starttime` time NOT NULL default '00:00:00',
  `pc_endtime` time NOT NULL default '00:00:00',
  `pc_limit` int(11) NOT NULL default '1',
  PRIMARY KEY  (`pc_limitid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `openemr_postcalendar_topics`
-- 

DROP TABLE IF EXISTS `openemr_postcalendar_topics`;
CREATE TABLE `openemr_postcalendar_topics` (
  `pc_catid` int(11) unsigned NOT NULL auto_increment,
  `pc_catname` varchar(100) default NULL,
  `pc_catcolor` varchar(50) default NULL,
  `pc_catdesc` text,
  PRIMARY KEY  (`pc_catid`),
  KEY `basic_cat` (`pc_catname`,`pc_catcolor`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `openemr_session_info`
-- 

DROP TABLE IF EXISTS `openemr_session_info`;
CREATE TABLE `openemr_session_info` (
  `pn_sessid` varchar(32) NOT NULL default '',
  `pn_ipaddr` varchar(20) default NULL,
  `pn_firstused` int(11) NOT NULL default '0',
  `pn_lastused` int(11) NOT NULL default '0',
  `pn_uid` int(11) NOT NULL default '0',
  `pn_vars` blob,
  PRIMARY KEY  (`pn_sessid`)
) ENGINE=MyISAM;

-- 
-- Dumping data for table `openemr_session_info`
-- 

INSERT INTO `openemr_session_info` VALUES ('978d31441dccd350d406bfab98978f20', '127.0.0.1', 1109233952, 1109234177, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_access_onsite`
--

DROP TABLE IF EXISTS `patient_access_onsite`;
CREATE TABLE `patient_access_onsite`(
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pid` INT(11),
  `portal_username` VARCHAR(100) ,
  `portal_pwd` VARCHAR(100) ,
  `portal_pwd_status` TINYINT DEFAULT '1' COMMENT '0=>Password Created Through Demographics by The provider or staff. Patient Should Change it at first time it.1=>Pwd updated or created by patient itself',
  PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `patient_data`
-- 

DROP TABLE IF EXISTS `patient_data`;
CREATE TABLE `patient_data` (
  `id` bigint(20) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `language` varchar(255) NOT NULL default '',
  `financial` varchar(255) NOT NULL default '',
  `fname` varchar(255) NOT NULL default '',
  `lname` varchar(255) NOT NULL default '',
  `mname` varchar(255) NOT NULL default '',
  `DOB` date default NULL,
  `street` varchar(255) NOT NULL default '',
  `street2` varchar(255) NOT NULL default '',
  `postal_code` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `state` varchar(255) NOT NULL default '',
  `country_code` varchar(255) NOT NULL default '',
  `drivers_license` varchar(255) NOT NULL default '',
  `ss` varchar(255) NOT NULL default '',
  `occupation` longtext,
  `phone_home` varchar(255) NOT NULL default '',
  `phone_biz` varchar(255) NOT NULL default '',
  `phone_contact` varchar(255) NOT NULL default '',
  `phone_cell` varchar(255) NOT NULL default '',
  `pharmacy_id` int(11) NOT NULL default '0',
  `status` varchar(255) NOT NULL default '',
  `contact_relationship` varchar(255) NOT NULL default '',
  `date` datetime default NULL,
  `sex` varchar(255) NOT NULL default '',
  `referrer` varchar(255) NOT NULL default '',
  `referrerID` varchar(255) NOT NULL default '',
  `providerID` int(11) default NULL,
  `ref_providerID` int(11) default NULL,
  `email` varchar(255) NOT NULL default '',
  `ethnoracial` varchar(255) NOT NULL default '',
  `race` varchar(255) NOT NULL default '',
  `ethnicity` varchar(255) NOT NULL default '',
  `interpretter` varchar(255) NOT NULL default '',
  `migrantseasonal` varchar(255) NOT NULL default '',
  `family_size` varchar(255) NOT NULL default '',
  `monthly_income` varchar(255) NOT NULL default '',
  `homeless` varchar(255) NOT NULL default '',
  `financial_review` datetime default NULL,
  `pubpid` varchar(255) NOT NULL default '',
  `pid` bigint(20) NOT NULL default '0',
  `genericname1` varchar(255) NOT NULL default '',
  `genericval1` varchar(255) NOT NULL default '',
  `genericname2` varchar(255) NOT NULL default '',
  `genericval2` varchar(255) NOT NULL default '',
  `hipaa_mail` varchar(3) NOT NULL default '',
  `hipaa_voice` varchar(3) NOT NULL default '',
  `hipaa_notice` varchar(3) NOT NULL default '',
  `hipaa_message` varchar(20) NOT NULL default '',
  `hipaa_allowsms` VARCHAR(3) NOT NULL DEFAULT 'NO',
  `hipaa_allowemail` VARCHAR(3) NOT NULL DEFAULT 'NO',
  `squad` varchar(32) NOT NULL default '',
  `fitness` int(11) NOT NULL default '0',
  `referral_source` varchar(30) NOT NULL default '',
  `usertext1` varchar(255) NOT NULL DEFAULT '',
  `usertext2` varchar(255) NOT NULL DEFAULT '',
  `usertext3` varchar(255) NOT NULL DEFAULT '',
  `usertext4` varchar(255) NOT NULL DEFAULT '',
  `usertext5` varchar(255) NOT NULL DEFAULT '',
  `usertext6` varchar(255) NOT NULL DEFAULT '',
  `usertext7` varchar(255) NOT NULL DEFAULT '',
  `usertext8` varchar(255) NOT NULL DEFAULT '',
  `userlist1` varchar(255) NOT NULL DEFAULT '',
  `userlist2` varchar(255) NOT NULL DEFAULT '',
  `userlist3` varchar(255) NOT NULL DEFAULT '',
  `userlist4` varchar(255) NOT NULL DEFAULT '',
  `userlist5` varchar(255) NOT NULL DEFAULT '',
  `userlist6` varchar(255) NOT NULL DEFAULT '',
  `userlist7` varchar(255) NOT NULL DEFAULT '',
  `pricelevel` varchar(255) NOT NULL default 'standard',
  `regdate`     date DEFAULT NULL COMMENT 'Registration Date',
  `contrastart` date DEFAULT NULL COMMENT 'Date contraceptives initially used',
  `completed_ad` VARCHAR(3) NOT NULL DEFAULT 'NO',
  `ad_reviewed` date DEFAULT NULL,
  `vfc` varchar(255) NOT NULL DEFAULT '',
  `mothersname` varchar(255) NOT NULL DEFAULT '',
  `guardiansname` varchar(255) NOT NULL DEFAULT '',
  `allow_imm_reg_use` varchar(255) NOT NULL DEFAULT '',
  `allow_imm_info_share` varchar(255) NOT NULL DEFAULT '',
  `allow_health_info_ex` varchar(255) NOT NULL DEFAULT '',
  `allow_patient_portal` varchar(31) NOT NULL DEFAULT '',
  `deceased_date` datetime default NULL,
  `deceased_reason` varchar(255) NOT NULL default '',
  `soap_import_status` TINYINT(4) DEFAULT NULL COMMENT '1-Prescription Press 2-Prescription Import 3-Allergy Press 4-Allergy Import',
  `soc` DATE DEFAULT NULL,
  `attending_physician` varchar(225),
  `age` INT(5) DEFAULT 0,
  `primary_referal_source` varchar(225),
  `area_director` INT(11) DEFAULT 0,
  `case_manager` INT(11) DEFAULT 0,
  `hospital_name` varchar(100),
  `hospital_phone` varchar(50),
  `hospital_address` varchar(100),
  `hospital_city` varchar(20),
  `hospital_state` varchar(20),
  `hospital_zip` varchar(10),
  `admit_status` varchar(100),
  `hospital_admit_date` DATE DEFAULT NULL,
  `hospital_dc_date` DATE DEFAULT NULL,
  `agency_name` varchar(100),
  `agency_rate` varchar(100),
  `agency_address` varchar(100),
  `agency_city` varchar(20),
  `agency_state` varchar(20),
  `agency_zip` varchar(10),
  `agency_phone` varchar(50),
  `agency_fax` varchar(50),
  `agency_email` varchar(100),
  `referral_date` DATE DEFAULT NULL,
  `referral_fname` varchar(100),
  `referral_lname` varchar(100),
  `referral_company_name` varchar(100),
  `referral_phone_no` varchar(50),
  `referral_fax_no` varchar(50),
  `referral_source_facility_name` varchar(100),
  `referral_source_phone_no` varchar(50),
  `referral_source_fax` varchar(50),
  `referral_source_protocol` varchar(100),
  `referral_admission_source` varchar(100),
  `referral_taken_by` varchar(100),
  `referral_reason_not_visited` varchar(100),
  `referral_comments` varchar(225),
  `primary_ref_physician` varchar(100),
  `physician_first_name` varchar(100),
  `physician_last_name` varchar(100),
  `pecos_status` varchar(100),
  `physician_upin` varchar(20),
  `physician_npi` varchar(20),
  `physician_address` varchar(225),
  `physician_city` varchar(20),
  `physician_state` varchar(20),
  `physician_zip` varchar(50),
  `physician_phone` varchar(50),
  `physician_fax` varchar(50),
  `other_physician` varchar(100),
  `otphy_fname` varchar(100),
  `otphy_lname` varchar(100),
  `otphy_pecos_status` varchar(100),
  `otphy_upin` varchar(20),
  `otphy_npi` varchar(20),
  `otphy_address` varchar(225),
  `otphy_city` varchar(20),
  `otphy_state` varchar(20),
  `otphy_zip` varchar(10),
  `otphy_phone` varchar(50),
  `otphy_fax` varchar(50),
  `otphy_comments` varchar(225),
  `attending_physician1` varchar(100),
  `attphy_fname` varchar(100),
  `attphy_lname` varchar(100),
  `attphy_pecos_status` varchar(100),
  `attphy_upin` varchar(10),
  `attphy_npi` varchar(10),
  `attphy_address` varchar(225),
  `attphy_city` varchar(20),
  `attphy_state` varchar(20),
  `attphy_zip` varchar(20),
  `attphy_phone` varchar(50),
  `attphy_fax` varchar(50),
  `attphy_comments` varchar(225),
  `medicare_number` varchar(10),
  `medicaid_number` varchar(10),
  `hmo_ppo_number` varchar(10),
  `emp_off_num` varchar(10),
  `emp_fax_num` varchar(10),
  `ok_to_contact` varchar(10),
  `secondary_language` varchar(100),
  `grand_childrens` varchar(10),
  `type_of_referral` varchar(70),
  `type_of_referral_other` varchar(100),
  `pref_other` varchar(100),
  UNIQUE KEY `pid` (`pid`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_reminders`
--

DROP TABLE IF EXISTS `patient_reminders`;
CREATE TABLE `patient_reminders` (
  `id` bigint(20) NOT NULL auto_increment,
  `active` tinyint(1) NOT NULL default 1 COMMENT '1 if active and 0 if not active',
  `date_inactivated` datetime DEFAULT NULL,
  `reason_inactivated` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list rule_reminder_inactive_opt',
  `due_status` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list rule_reminder_due_opt',
  `pid` bigint(20) NOT NULL COMMENT 'id from patient_data table',
  `category` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the category item in the rule_action_item table',
  `item` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the item column in the rule_action_item table',
  `date_created` datetime DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `voice_status` tinyint(1) NOT NULL default 0 COMMENT '0 if not sent and 1 if sent',
  `sms_status` tinyint(1) NOT NULL default 0 COMMENT '0 if not sent and 1 if sent',
  `email_status` tinyint(1) NOT NULL default 0 COMMENT '0 if not sent and 1 if sent',
  `mail_status` tinyint(1) NOT NULL default 0 COMMENT '0 if not sent and 1 if sent',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY (`category`,`item`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `patient_access_offsite`
--

DROP TABLE IF EXISTS `patient_access_offsite`;
CREATE TABLE  `patient_access_offsite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `portal_username` varchar(100) NOT NULL,
  `portal_pwd` varchar(100) NOT NULL,
  `portal_pwd_status` tinyint(4) DEFAULT '1' COMMENT '0=>Password Created Through Demographics by The provider or staff. Patient Should Change it at first time it.1=>Pwd updated or created by patient itself',
  `authorize_net_id` VARCHAR(20) COMMENT 'authorize.net profile id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

-- 
-- Table structure for table `payments`
-- 

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL auto_increment,
  `pid` bigint(20) NOT NULL default '0',
  `dtime` datetime NOT NULL,
  `encounter` bigint(20) NOT NULL default '0',
  `user` varchar(255) default NULL,
  `method` varchar(255) default NULL,
  `source` varchar(255) default NULL,
  `amount1` decimal(12,2) NOT NULL default '0.00',
  `amount2` decimal(12,2) NOT NULL default '0.00',
  `posted1` decimal(12,2) NOT NULL default '0.00',
  `posted2` decimal(12,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway_details`
--
CREATE TABLE `payment_gateway_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(100) DEFAULT NULL,
  `login_id` varchar(255) DEFAULT NULL,
  `transaction_key` varchar(255) DEFAULT NULL,
  `md5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `pharmacies`
-- 

DROP TABLE IF EXISTS `pharmacies`;
CREATE TABLE `pharmacies` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `transmit_method` int(11) NOT NULL default '1',
  `email` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `phone_numbers`
-- 

DROP TABLE IF EXISTS `phone_numbers`;
CREATE TABLE `phone_numbers` (
  `id` int(11) NOT NULL default '0',
  `country_code` varchar(5) default NULL,
  `area_code` char(3) default NULL,
  `prefix` char(3) default NULL,
  `number` varchar(4) default NULL,
  `type` int(11) default NULL,
  `foreign_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `foreign_id` (`foreign_id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `pma_bookmark`
-- 

DROP TABLE IF EXISTS `pma_bookmark`;
CREATE TABLE `pma_bookmark` (
  `id` int(11) NOT NULL auto_increment,
  `dbase` varchar(255) default NULL,
  `user` varchar(255) default NULL,
  `label` varchar(255) default NULL,
  `query` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM COMMENT='Bookmarks' AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `pma_bookmark`
-- 

INSERT INTO `pma_bookmark` VALUES (2, 'openemr', 'openemr', 'Aggregate Race Statistics', 'SELECT ethnoracial as "Race/Ethnicity", count(*) as Count FROM  `patient_data` WHERE 1 group by ethnoracial');
INSERT INTO `pma_bookmark` VALUES (9, 'openemr', 'openemr', 'Search by Code', 'SELECT  b.code, concat(pd.fname," ", pd.lname) as "Patient Name", concat(u.fname," ", u.lname) as "Provider Name", en.reason as "Encounter Desc.", en.date\r\nFROM billing as b\r\nLEFT JOIN users AS u ON b.user = u.id\r\nLEFT JOIN patient_data as pd on b.pid = pd.pid\r\nLEFT JOIN form_encounter as en on b.encounter = en.encounter and b.pid = en.pid\r\nWHERE 1 /* and b.code like ''%[VARIABLE]%'' */ ORDER BY b.code');
INSERT INTO `pma_bookmark` VALUES (8, 'openemr', 'openemr', 'Count No Shows By Provider since Interval ago', 'SELECT concat( u.fname,  " ", u.lname )  AS  "Provider Name", u.id AS  "Provider ID", count(  DISTINCT ev.pc_eid )  AS  "Number of No Shows"/* , concat(DATE_FORMAT(NOW(),''%Y-%m-%d''), '' and '',DATE_FORMAT(DATE_ADD(now(), INTERVAL [VARIABLE]),''%Y-%m-%d'') ) as "Between Dates" */ FROM  `openemr_postcalendar_events`  AS ev LEFT  JOIN users AS u ON ev.pc_aid = u.id WHERE ev.pc_catid =1/* and ( ev.pc_eventDate >= DATE_SUB(now(), INTERVAL [VARIABLE]) )  */\r\nGROUP  BY u.id;');
INSERT INTO `pma_bookmark` VALUES (6, 'openemr', 'openemr', 'Appointments By Race/Ethnicity from today plus interval', 'SELECT  count(pd.ethnoracial) as "Number of Appointments", pd.ethnoracial AS  "Race/Ethnicity" /* , concat(DATE_FORMAT(NOW(),''%Y-%m-%d''), '' and '',DATE_FORMAT(DATE_ADD(now(), INTERVAL [VARIABLE]),''%Y-%m-%d'') ) as "Between Dates" */ FROM openemr_postcalendar_events AS ev LEFT  JOIN   `patient_data`  AS pd ON  pd.pid = ev.pc_pid where ev.pc_eventstatus=1 and ev.pc_catid = 5 and ev.pc_eventDate >= now()  /* and ( ev.pc_eventDate <= DATE_ADD(now(), INTERVAL [VARIABLE]) )  */ group by pd.ethnoracial');

-- --------------------------------------------------------

-- 
-- Table structure for table `pma_column_info`
-- 

DROP TABLE IF EXISTS `pma_column_info`;
CREATE TABLE `pma_column_info` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `db_name` varchar(64) default NULL,
  `table_name` varchar(64) default NULL,
  `column_name` varchar(64) default NULL,
  `comment` varchar(255) default NULL,
  `mimetype` varchar(255) default NULL,
  `transformation` varchar(255) default NULL,
  `transformation_options` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`)
) ENGINE=MyISAM COMMENT='Column Information for phpMyAdmin' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `pma_history`
-- 

DROP TABLE IF EXISTS `pma_history`;
CREATE TABLE `pma_history` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(64) default NULL,
  `db` varchar(64) default NULL,
  `table` varchar(64) default NULL,
  `timevalue` timestamp NOT NULL,
  `sqlquery` text,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`,`db`,`table`,`timevalue`)
) ENGINE=MyISAM COMMENT='SQL history' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `pma_pdf_pages`
-- 

DROP TABLE IF EXISTS `pma_pdf_pages`;
CREATE TABLE `pma_pdf_pages` (
  `db_name` varchar(64) default NULL,
  `page_nr` int(10) unsigned NOT NULL auto_increment,
  `page_descr` varchar(50) default NULL,
  PRIMARY KEY  (`page_nr`),
  KEY `db_name` (`db_name`)
) ENGINE=MyISAM COMMENT='PDF Relationpages for PMA' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `pma_relation`
-- 

DROP TABLE IF EXISTS `pma_relation`;
CREATE TABLE `pma_relation` (
  `master_db` varchar(64) NOT NULL default '',
  `master_table` varchar(64) NOT NULL default '',
  `master_field` varchar(64) NOT NULL default '',
  `foreign_db` varchar(64) default NULL,
  `foreign_table` varchar(64) default NULL,
  `foreign_field` varchar(64) default NULL,
  PRIMARY KEY  (`master_db`,`master_table`,`master_field`),
  KEY `foreign_field` (`foreign_db`,`foreign_table`)
) ENGINE=MyISAM COMMENT='Relation table';

-- --------------------------------------------------------

-- 
-- Table structure for table `pma_table_coords`
-- 

DROP TABLE IF EXISTS `pma_table_coords`;
CREATE TABLE `pma_table_coords` (
  `db_name` varchar(64) NOT NULL default '',
  `table_name` varchar(64) NOT NULL default '',
  `pdf_page_number` int(11) NOT NULL default '0',
  `x` float unsigned NOT NULL default '0',
  `y` float unsigned NOT NULL default '0',
  PRIMARY KEY  (`db_name`,`table_name`,`pdf_page_number`)
) ENGINE=MyISAM COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

-- 
-- Table structure for table `pma_table_info`
-- 

DROP TABLE IF EXISTS `pma_table_info`;
CREATE TABLE `pma_table_info` (
  `db_name` varchar(64) NOT NULL default '',
  `table_name` varchar(64) NOT NULL default '',
  `display_field` varchar(64) default NULL,
  PRIMARY KEY  (`db_name`,`table_name`)
) ENGINE=MyISAM COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

-- 
-- Table structure for table `pnotes`
-- 

DROP TABLE IF EXISTS `pnotes`;
CREATE TABLE `pnotes` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `body` longtext,
  `pid` bigint(20) default NULL,
  `user` varchar(255) default NULL,
  `groupname` varchar(255) default NULL,
  `activity` tinyint(4) default NULL,
  `authorized` tinyint(4) default NULL,
  `title` varchar(255) default NULL,
  `assigned_to` varchar(255) default NULL,
  `deleted` tinyint(4) default 0 COMMENT 'flag indicates note is deleted',
  `message_status` VARCHAR(20) NOT NULL DEFAULT 'New',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `prescriptions`
-- 

DROP TABLE IF EXISTS `prescriptions`;
CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL auto_increment,
  `patient_id` int(11) default NULL,
  `filled_by_id` int(11) default NULL,
  `pharmacy_id` int(11) default NULL,
  `date_added` date default NULL,
  `date_modified` date default NULL,
  `provider_id` int(11) default NULL,
  `encounter` int(11) default NULL,
  `start_date` date default NULL,
  `drug` varchar(150) default NULL,
  `drug_id` int(11) NOT NULL default '0',
  `rxnorm_drugcode` INT(11) DEFAULT NULL,
  `form` int(3) default NULL,
  `dosage` varchar(100) default NULL,
  `quantity` varchar(31) default NULL,
  `size` float unsigned default NULL,
  `unit` int(11) default NULL,
  `route` int(11) default NULL,
  `interval` int(11) default NULL,
  `substitute` int(11) default NULL,
  `refills` int(11) default NULL,
  `per_refill` int(11) default NULL,
  `filled_date` date default NULL,
  `medication` int(11) default NULL,
  `note` text,
  `active` int(11) NOT NULL default '1',
  `datetime` DATETIME DEFAULT NULL,
  `user` VARCHAR(50) DEFAULT NULL,
  `site` VARCHAR(50) DEFAULT NULL,
  `prescriptionguid` VARCHAR(50) DEFAULT NULL,
  `erx_source` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0-OpenEMR 1-External',
  `erx_uploaded` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0-Pending NewCrop upload 1-Uploaded to NewCrop',
  `drug_info_erx` TEXT DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `prices`
-- 

DROP TABLE IF EXISTS `prices`;
CREATE TABLE `prices` (
  `pr_id` varchar(11) NOT NULL default '',
  `pr_selector` varchar(255) NOT NULL default '' COMMENT 'template selector for drugs, empty for codes',
  `pr_level` varchar(31) NOT NULL default '',
  `pr_price` decimal(12,2) NOT NULL default '0.00' COMMENT 'price in local currency',
  PRIMARY KEY  (`pr_id`,`pr_selector`,`pr_level`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `registry`
-- 

DROP TABLE IF EXISTS `registry`;
CREATE TABLE `registry` (
  `name` varchar(255) default NULL,
  `state` tinyint(4) default NULL,
  `directory` varchar(255) default NULL,
  `id` bigint(20) NOT NULL auto_increment,
  `sql_run` tinyint(4) default NULL,
  `unpackaged` tinyint(4) default NULL,
  `date` datetime default NULL,
  `priority` int(11) default '0',
  `category` varchar(255) default NULL,
  `nickname` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `registry`
-- 

INSERT INTO `registry` VALUES ('Vitals', 1, 'vitals', 12, 1, 1, '2005-03-03 00:16:34', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `rule_action`
--

DROP TABLE IF EXISTS `rule_action`;
CREATE TABLE `rule_action` (
  `id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the id column in the clinical_rules table',
  `group_id` bigint(20) NOT NULL DEFAULT 1 COMMENT 'Contains group id to identify collection of targets in a rule',
  `category` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the category item in the rule_action_item table',
  `item` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the item column in the rule_action_item table',
  KEY  (`id`)
) ENGINE=MyISAM ;

--
-- Standard clinical rule actions
--
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_htn_bp_measure', 1, 'act_cat_measure', 'act_bp');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_tob_use_assess', 1, 'act_cat_assess', 'act_tobacco');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_tob_cess_inter', 1, 'act_cat_inter', 'act_tobacco');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_adult_wt_screen_fu', 1, 'act_cat_measure', 'act_wt');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_wt_assess_couns_child', 1, 'act_cat_measure', 'act_wt');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_wt_assess_couns_child', 2, 'act_cat_edu', 'act_wt');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_wt_assess_couns_child', 3, 'act_cat_edu', 'act_nutrition');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_wt_assess_couns_child', 4, 'act_cat_edu', 'act_exercise');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_wt_assess_couns_child', 5, 'act_cat_measure', 'act_bmi');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_influenza_ge_50', 1, 'act_cat_treat', 'act_influvacc');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_pneumovacc_ge_65', 1, 'act_cat_treat', 'act_pneumovacc');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_dm_hemo_a1c', 1, 'act_cat_measure', 'act_hemo_a1c');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_dm_urine_alb', 1, 'act_cat_measure', 'act_urine_alb');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_dm_eye', 1, 'act_cat_exam', 'act_eye');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_dm_foot', 1, 'act_cat_exam', 'act_foot');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_cs_mammo', 1, 'act_cat_measure', 'act_mammo');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_cs_pap', 1, 'act_cat_exam', 'act_pap');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_cs_colon', 1, 'act_cat_assess', 'act_colon_cancer_screen');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_cs_prostate', 1, 'act_cat_assess', 'act_prostate_cancer_screen');
INSERT INTO `rule_action` ( `id`, `group_id`, `category`, `item` ) VALUES ('rule_inr_monitor', 1, 'act_cat_measure', 'act_lab_inr');

-- --------------------------------------------------------

--
-- Table structure for table `rule_action_item`
--

DROP TABLE IF EXISTS `rule_action_item`;
CREATE TABLE `rule_action_item` (
  `category` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list rule_action_category',
  `item` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list rule_action',
  `clin_rem_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'Custom html link in clinical reminder widget',
  `reminder_message` text  NOT NULL DEFAULT '' COMMENT 'Custom message in patient reminder',
  `custom_flag` tinyint(1) NOT NULL default 0 COMMENT '1 indexed to rule_patient_data, 0 indexed within main schema',
  PRIMARY KEY  (`category`,`item`)
) ENGINE=MyISAM ;

INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_measure', 'act_bp', '', '', 0);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_assess', 'act_tobacco', '', '', 0);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_inter', 'act_tobacco', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_measure', 'act_wt', '', '', 0);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_edu', 'act_wt', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_measure', 'act_bmi', '', '', 0);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_edu', 'act_nutrition', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_edu', 'act_exercise', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_treat', 'act_influvacc', '', '', 0);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_treat', 'act_pneumovacc', '', '', 0);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_measure', 'act_hemo_a1c', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_measure', 'act_urine_alb', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_exam', 'act_eye', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_exam', 'act_foot', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_measure', 'act_mammo', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_exam', 'act_pap', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_assess', 'act_colon_cancer_screen', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_assess', 'act_prostate_cancer_screen', '', '', 1);
INSERT INTO `rule_action_item` ( `category`, `item`, `clin_rem_link`, `reminder_message`, `custom_flag` ) VALUES ('act_cat_measure', 'act_lab_inr', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rule_filter`
--

DROP TABLE IF EXISTS `rule_filter`;
CREATE TABLE `rule_filter` (
  `id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the id column in the clinical_rules table',
  `include_flag` tinyint(1) NOT NULL default 0 COMMENT '0 is exclude and 1 is include',
  `required_flag` tinyint(1) NOT NULL default 0 COMMENT '0 is required and 1 is optional',
  `method` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list rule_filters',
  `method_detail` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options lists rule__intervals',
  `value` varchar(255) NOT NULL DEFAULT '',
  KEY  (`id`)
) ENGINE=MyISAM ;

--
-- Standard clinical rule filters
--
-- Hypertension: Blood Pressure Measurement
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'CUSTOM::HTN');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::401.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::401.1');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::401.9');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::402.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::402.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::402.10');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::402.11');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::402.90');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::402.91');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::403.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::403.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::403.10');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::403.11');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::403.90');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::403.91');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.10');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.11');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.12');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.13');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.90');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.91');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.92');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::404.93');
-- Tobacco Use Assessment
-- no filters
-- Tobacco Cessation Intervention
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_cess_inter', 1, 1, 'filt_database', '', 'LIFESTYLE::tobacco::current');
-- Adult Weight Screening and Follow-Up
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_adult_wt_screen_fu', 1, 1, 'filt_age_min', 'year', '18');
-- Weight Assessment and Counseling for Children and Adolescents
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_wt_assess_couns_child', 1, 1, 'filt_age_max', 'year', '18');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_wt_assess_couns_child', 1, 1, 'filt_age_min', 'year', '2');
-- Influenza Immunization for Patients >= 50 Years Old
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_influenza_ge_50', 1, 1, 'filt_age_min', 'year', '50');
-- Pneumonia Vaccination Status for Older Adults
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_pneumovacc_ge_65', 1, 1, 'filt_age_min', 'year', '65');
-- Diabetes: Hemoglobin A1C
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'CUSTOM::diabetes');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.10');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.11');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.12');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.13');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.20');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.21');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.22');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.23');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.30');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.31');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.32');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.33');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.4');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.40');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.41');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.42');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.43');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.50');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.51');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.52');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.53');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.60');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.61');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.62');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.63');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.7');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.70');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.71');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.72');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.73');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.80');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.81');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.82');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.83');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.9');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.90');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.91');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.92');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.93');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::357.2');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.04');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.05');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.06');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::366.41');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.04');
-- Diabetes: Urine Microalbumin
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'CUSTOM::diabetes');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.10');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.11');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.12');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.13');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.20');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.21');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.22');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.23');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.30');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.31');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.32');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.33');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.4');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.40');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.41');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.42');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.43');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.50');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.51');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.52');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.53');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.60');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.61');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.62');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.63');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.7');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.70');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.71');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.72');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.73');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.80');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.81');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.82');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.83');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.9');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.90');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.91');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.92');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.93');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::357.2');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.04');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.05');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.06');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::366.41');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.04');
-- Diabetes: Eye Exam
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'CUSTOM::diabetes');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.10');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.11');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.12');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.13');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.20');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.21');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.22');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.23');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.30');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.31');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.32');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.33');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.4');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.40');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.41');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.42');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.43');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.50');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.51');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.52');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.53');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.60');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.61');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.62');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.63');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.7');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.70');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.71');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.72');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.73');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.80');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.81');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.82');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.83');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.9');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.90');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.91');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.92');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.93');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::357.2');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.04');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.05');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.06');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::366.41');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.04');
-- Diabetes: Foot Exam
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'CUSTOM::diabetes');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.10');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.11');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.12');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.13');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.20');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.21');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.22');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.23');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.30');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.31');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.32');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.33');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.4');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.40');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.41');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.42');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.43');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.50');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.51');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.52');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.53');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.60');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.61');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.62');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.63');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.7');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.70');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.71');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.72');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.73');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.80');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.81');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.82');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.83');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.9');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.90');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.91');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.92');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::250.93');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::357.2');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.04');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.05');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::362.06');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::366.41');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.0');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.00');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.01');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.02');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.03');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 1, 0, 'filt_lists', 'medical_problem', 'ICD9::648.04');
-- Cancer Screening: Mammogram
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_mammo', 1, 1, 'filt_age_min', 'year', '40');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_mammo', 1, 1, 'filt_sex', '', 'Female');
-- Cancer Screening: Pap Smear
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_pap', 1, 1, 'filt_age_min', 'year', '18');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_pap', 1, 1, 'filt_sex', '', 'Female');
-- Cancer Screening: Colon Cancer Screening
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_colon', 1, 1, 'filt_age_min', 'year', '50');
-- Cancer Screening: Prostate Cancer Screening
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_prostate', 1, 1, 'filt_age_min', 'year', '50');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_prostate', 1, 1, 'filt_sex', '', 'Male');
--
-- Rule filters to specifically demonstrate passing of NIST criteria
--
-- Coumadin Management - INR Monitoring
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_inr_monitor', 1, 0, 'filt_lists', 'medication', 'coumadin');
INSERT INTO `rule_filter` ( `id`, `include_flag`, `required_flag`, `method`, `method_detail`, `value` ) VALUES ('rule_inr_monitor', 1, 0, 'filt_lists', 'medication', 'warfarin');

-- --------------------------------------------------------

--
-- Table structure for table `rule_patient_data`
--

DROP TABLE IF EXISTS `rule_patient_data`;
CREATE TABLE `rule_patient_data` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime DEFAULT NULL,
  `pid` bigint(20) NOT NULL,
  `category` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the category item in the rule_action_item table',
  `item` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the item column in the rule_action_item table',
  `complete` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list yesno',
  `result` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY (`pid`),
  KEY (`category`,`item`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rule_reminder`
--

DROP TABLE IF EXISTS `rule_reminder`;
CREATE TABLE `rule_reminder` (
  `id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the id column in the clinical_rules table',
  `method` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list rule_reminder_methods',
  `method_detail` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list rule_reminder_intervals',
  `value` varchar(255) NOT NULL DEFAULT '',
  KEY  (`id`)
) ENGINE=MyISAM ;

-- Hypertension: Blood Pressure Measurement
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_htn_bp_measure', 'patient_reminder_post', 'month', '1');
-- Tobacco Use Assessment
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_use_assess', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_use_assess', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_use_assess', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_use_assess', 'patient_reminder_post', 'month', '1');
-- Tobacco Cessation Intervention
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_cess_inter', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_cess_inter', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_cess_inter', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_tob_cess_inter', 'patient_reminder_post', 'month', '1');
-- Adult Weight Screening and Follow-Up
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_adult_wt_screen_fu', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_adult_wt_screen_fu', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_adult_wt_screen_fu', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_adult_wt_screen_fu', 'patient_reminder_post', 'month', '1');
-- Weight Assessment and Counseling for Children and Adolescents
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_wt_assess_couns_child', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_wt_assess_couns_child', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_wt_assess_couns_child', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_wt_assess_couns_child', 'patient_reminder_post', 'month', '1');
-- Influenza Immunization for Patients >= 50 Years Old
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_influenza_ge_50', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_influenza_ge_50', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_influenza_ge_50', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_influenza_ge_50', 'patient_reminder_post', 'month', '1');
-- Pneumonia Vaccination Status for Older Adults
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_pneumovacc_ge_65', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_pneumovacc_ge_65', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_pneumovacc_ge_65', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_pneumovacc_ge_65', 'patient_reminder_post', 'month', '1');
-- Diabetes: Hemoglobin A1C
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_hemo_a1c', 'patient_reminder_post', 'month', '1');
-- Diabetes: Urine Microalbumin
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_urine_alb', 'patient_reminder_post', 'month', '1');
-- Diabetes: Eye Exam
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_eye', 'patient_reminder_post', 'month', '1');
-- Diabetes: Foot Exam
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_dm_foot', 'patient_reminder_post', 'month', '1');
-- Cancer Screening: Mammogram
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_mammo', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_mammo', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_mammo', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_mammo', 'patient_reminder_post', 'month', '1');
-- Cancer Screening: Pap Smear
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_pap', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_pap', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_pap', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_pap', 'patient_reminder_post', 'month', '1');
-- Cancer Screening: Colon Cancer Screening
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_colon', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_colon', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_colon', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_colon', 'patient_reminder_post', 'month', '1');
-- Cancer Screening: Prostate Cancer Screening
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_prostate', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_prostate', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_prostate', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_cs_prostate', 'patient_reminder_post', 'month', '1');
-- Coumadin Management - INR Monitoring
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_inr_monitor', 'clinical_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_inr_monitor', 'clinical_reminder_post', 'month', '1');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_inr_monitor', 'patient_reminder_pre', 'week', '2');
INSERT INTO `rule_reminder` ( `id`, `method`, `method_detail`, `value` ) VALUES ('rule_inr_monitor', 'patient_reminder_post', 'month', '1');

-- --------------------------------------------------------

--
-- Table structure for table `rule_target`
--

DROP TABLE IF EXISTS `rule_target`;
CREATE TABLE `rule_target` (
  `id` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to the id column in the clinical_rules table',
  `group_id` bigint(20) NOT NULL DEFAULT 1 COMMENT 'Contains group id to identify collection of targets in a rule',
  `include_flag` tinyint(1) NOT NULL default 0 COMMENT '0 is exclude and 1 is include',
  `required_flag` tinyint(1) NOT NULL default 0 COMMENT '0 is required and 1 is optional',
  `method` varchar(31) NOT NULL DEFAULT '' COMMENT 'Maps to list_options list rule_targets', 
  `value` varchar(255) NOT NULL DEFAULT '' COMMENT 'Data is dependent on the method',
  `interval` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Only used in interval entries', 
  KEY  (`id`)
) ENGINE=MyISAM ;

--
-- Standard clinical rule targets
--
-- Hypertension: Blood Pressure Measurement
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_htn_bp_measure', 1, 1, 1, 'target_interval', 'year', 1);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_htn_bp_measure', 1, 1, 1, 'target_database', '::form_vitals::bps::::::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_htn_bp_measure', 1, 1, 1, 'target_database', '::form_vitals::bpd::::::ge::1', 0);
-- Tobacco Use Assessment
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_tob_use_assess', 1, 1, 1, 'target_database', 'LIFESTYLE::tobacco::', 0);
-- Tobacco Cessation Intervention
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_tob_cess_inter', 1, 1, 1, 'target_interval', 'year', 1);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_tob_cess_inter', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_inter::act_tobacco::YES::ge::1', 0);
-- Adult Weight Screening and Follow-Up
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_adult_wt_screen_fu', 1, 1, 1, 'target_database', '::form_vitals::weight::::::ge::1', 0);
-- Weight Assessment and Counseling for Children and Adolescents
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 1, 1, 1, 'target_database', '::form_vitals::weight::::::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 1, 1, 1, 'target_interval', 'year', 3);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 2, 1, 1, 'target_database', 'CUSTOM::act_cat_edu::act_wt::YES::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 2, 1, 1, 'target_interval', 'year', 3);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 3, 1, 1, 'target_database', 'CUSTOM::act_cat_edu::act_nutrition::YES::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 3, 1, 1, 'target_interval', 'year', 3);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 4, 1, 1, 'target_database', 'CUSTOM::act_cat_edu::act_exercise::YES::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 4, 1, 1, 'target_interval', 'year', 3);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 5, 1, 1, 'target_database', '::form_vitals::BMI::::::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_wt_assess_couns_child', 5, 1, 1, 'target_interval', 'year', 3);
-- Influenza Immunization for Patients >= 50 Years Old
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 1, 'target_interval', 'flu_season', 1);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::15::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::16::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::88::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::111::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::125::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::126::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::127::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::128::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::135::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::140::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::141::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_influenza_ge_50', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::144::ge::1', 0);
-- Pneumonia Vaccination Status for Older Adults
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_pneumovacc_ge_65', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::33::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_pneumovacc_ge_65', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::100::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_pneumovacc_ge_65', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::109::ge::1', 0);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_pneumovacc_ge_65', 1, 1, 0, 'target_database', '::immunizations::cvx_code::eq::133::ge::1', 0);
-- Diabetes: Hemoglobin A1C
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_dm_hemo_a1c', 1, 1, 1, 'target_interval', 'month', 3);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_dm_hemo_a1c', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_measure::act_hemo_a1c::YES::ge::1', 0);
-- Diabetes: Urine Microalbumin
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_dm_urine_alb', 1, 1, 1, 'target_interval', 'year', 1);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_dm_urine_alb', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_measure::act_urine_alb::YES::ge::1', 0);
-- Diabetes: Eye Exam
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_dm_eye', 1, 1, 1, 'target_interval', 'year', 1);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_dm_eye', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_exam::act_eye::YES::ge::1', 0);
-- Diabetes: Foot Exam
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_dm_foot', 1, 1, 1, 'target_interval', 'year', 1);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_dm_foot', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_exam::act_foot::YES::ge::1', 0);
-- Cancer Screening: Mammogram
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_cs_mammo', 1, 1, 1, 'target_interval', 'year', 1);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_cs_mammo', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_measure::act_mammo::YES::ge::1', 0);
-- Cancer Screening: Pap Smear
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_cs_pap', 1, 1, 1, 'target_interval', 'year', 1);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_cs_pap', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_exam::act_pap::YES::ge::1', 0);
-- Cancer Screening: Colon Cancer Screening
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_cs_colon', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_assess::act_colon_cancer_screen::YES::ge::1', 0);
-- Cancer Screening: Prostate Cancer Screening
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_cs_prostate', 1, 1, 1, 'target_database', 'CUSTOM::act_cat_assess::act_prostate_cancer_screen::YES::ge::1', 0);
--
-- Rule targets to specifically demonstrate passing of NIST criteria
--
-- Coumadin Management - INR Monitoring
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_inr_monitor', 1, 1, 1, 'target_interval', 'week', 3);
INSERT INTO `rule_target` ( `id`, `group_id`, `include_flag`, `required_flag`, `method`, `value`, `interval` ) VALUES ('rule_inr_monitor', 1, 1, 1, 'target_proc', 'INR::CPT4:85610::::::ge::1', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `sequences`
-- 

DROP TABLE IF EXISTS `sequences`;
CREATE TABLE `sequences` (
  `id` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM;

-- 
-- Dumping data for table `sequences`
-- 

INSERT INTO `sequences` VALUES (1);

-- --------------------------------------------------------

-- 
-- Table structure for table `transactions`
-- 

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id`                      bigint(20)   NOT NULL auto_increment,
  `date`                    datetime     default NULL,
  `title`                   varchar(255) NOT NULL DEFAULT '',
  `body`                    longtext     NOT NULL DEFAULT '',
  `pid`                     bigint(20)   default NULL,
  `user`                    varchar(255) NOT NULL DEFAULT '',
  `groupname`               varchar(255) NOT NULL DEFAULT '',
  `authorized`              tinyint(4)   default NULL,
  `refer_date`              date         DEFAULT NULL,
  `refer_from`              int(11)      NOT NULL DEFAULT 0,
  `refer_to`                int(11)      NOT NULL DEFAULT 0,
  `refer_diag`              varchar(255) NOT NULL DEFAULT '',
  `refer_risk_level`        varchar(255) NOT NULL DEFAULT '',
  `refer_vitals`            tinyint(1)   NOT NULL DEFAULT 0,
  `refer_external`          tinyint(1)   NOT NULL DEFAULT 0,
  `refer_related_code`      varchar(255) NOT NULL DEFAULT '',
  `refer_reply_date`        date         DEFAULT NULL,
  `reply_date`              date         DEFAULT NULL,
  `reply_from`              varchar(255) NOT NULL DEFAULT '',
  `reply_init_diag`         varchar(255) NOT NULL DEFAULT '',
  `reply_final_diag`        varchar(255) NOT NULL DEFAULT '',
  `reply_documents`         varchar(255) NOT NULL DEFAULT '',
  `reply_findings`          text         NOT NULL DEFAULT '',
  `reply_services`          text         NOT NULL DEFAULT '',
  `reply_recommend`         text         NOT NULL DEFAULT '',
  `reply_rx_refer`          text         NOT NULL DEFAULT '',
  `reply_related_code`      varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` longtext,
  `authorized` tinyint(4) default NULL,
  `info` longtext,
  `source` tinyint(4) default NULL,
  `fname` varchar(255) default NULL,
  `mname` varchar(255) default NULL,
  `lname` varchar(255) default NULL,
  `federaltaxid` varchar(255) default NULL,
  `federaldrugid` varchar(255) default NULL,
  `upin` varchar(255) default NULL,
  `facility` varchar(255) default NULL,
  `facility_id` int(11) NOT NULL default '0',
  `see_auth` int(11) NOT NULL default '1',
  `active` tinyint(1) NOT NULL default '1',
  `npi` varchar(15) default NULL,
  `title` varchar(30) default NULL,
  `specialty` varchar(255) default NULL,
  `billname` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `assistant` varchar(255) default NULL,
  `organization` varchar(255) default NULL,
  `valedictory` varchar(255) default NULL,
  `street` varchar(60) default NULL,
  `streetb` varchar(60) default NULL,
  `city` varchar(30) default NULL,
  `state` varchar(30) default NULL,
  `zip` varchar(20) default NULL,
  `street2` varchar(60) default NULL,
  `streetb2` varchar(60) default NULL,
  `city2` varchar(30) default NULL,
  `state2` varchar(30) default NULL,
  `zip2` varchar(20) default NULL,
  `phone` varchar(30) default NULL,
  `fax` varchar(30) default NULL,
  `phonew1` varchar(30) default NULL,
  `phonew2` varchar(30) default NULL,
  `phonecell` varchar(30) default NULL,
  `notes` text,
  `cal_ui` tinyint(4) NOT NULL default '1',
  `taxonomy` varchar(30) NOT NULL DEFAULT '207Q00000X',
  `ssi_relayhealth` varchar(64) NULL,
  `calendar` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = appears in calendar',
  `abook_type` varchar(31) NOT NULL DEFAULT '',
  `pwd_expiration_date` date default NULL,
  `pwd_history1` longtext default NULL,
  `pwd_history2` longtext default NULL,
  `default_warehouse` varchar(31) NOT NULL DEFAULT '',
  `irnpool` varchar(31) NOT NULL DEFAULT '',
  `state_license_number` VARCHAR(25) DEFAULT NULL,
  `newcrop_user_role` VARCHAR(30) DEFAULT NULL,
  `agency_area` VARCHAR(60) DEFAULT NULL,
  `synergy_username` VARCHAR(150) DEFAULT NULL,
  `synergy_password` VARCHAR(150) DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `setting_user`  bigint(20)   NOT NULL DEFAULT 0,
  `setting_label` varchar(63)  NOT NULL,
  `setting_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`setting_user`, `setting_label`)
) ENGINE=MyISAM;

--
-- Dumping data for table `user_settings`
--

INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'allergy_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'appointments_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'billing_ps_expand', '0');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'clinical_reminders_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'demographics_ps_expand', '0');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'dental_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'directives_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'disclosures_ps_expand', '0');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'immunizations_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'insurance_ps_expand', '0');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'medical_problem_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'medication_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'patient_reminders_ps_expand', '0');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'pnotes_ps_expand', '0');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'prescriptions_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'surgery_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'vitals_ps_expand', '1');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (0, 'gacl_protect', '0');
INSERT INTO user_settings ( setting_user, setting_label, setting_value ) VALUES (1, 'gacl_protect', '1');

-- --------------------------------------------------------

-- 
-- Table structure for table `x12_partners`
-- 

DROP TABLE IF EXISTS `x12_partners`;
CREATE TABLE `x12_partners` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `id_number` varchar(255) default NULL,
  `x12_sender_id` varchar(255) default NULL,
  `x12_receiver_id` varchar(255) default NULL,
  `x12_version` varchar(255) default NULL,
  `processing_format` enum('standard','medi-cal','cms','proxymed') default NULL,
  `x12_isa01` VARCHAR( 2 ) NOT NULL DEFAULT '00' COMMENT 'User logon Required Indicator',
  `x12_isa02` VARCHAR( 10 ) NOT NULL DEFAULT '          ' COMMENT 'User Logon',
  `x12_isa03` VARCHAR( 2 ) NOT NULL DEFAULT '00' COMMENT 'User password required Indicator',
  `x12_isa04` VARCHAR( 10 ) NOT NULL DEFAULT '          ' COMMENT 'User Password',
  `x12_isa05` char(2)     NOT NULL DEFAULT 'ZZ',
  `x12_isa07` char(2)     NOT NULL DEFAULT 'ZZ',
  `x12_isa14` char(1)     NOT NULL DEFAULT '0',
  `x12_isa15` char(1)     NOT NULL DEFAULT 'P',
  `x12_gs02`  varchar(15) NOT NULL DEFAULT '',
  `x12_per06` varchar(80) NOT NULL DEFAULT '',
  `x12_gs03`  varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- -----------------------------------------------------------------------------------
-- Table structure for table `automatic_notification`
-- 

DROP TABLE IF EXISTS `automatic_notification`;
CREATE TABLE `automatic_notification` (
  `notification_id` int(5) NOT NULL auto_increment,
  `sms_gateway_type` varchar(255) NOT NULL,
  `next_app_date` date NOT NULL,
  `next_app_time` varchar(10) NOT NULL,
  `provider_name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `email_sender` varchar(100) NOT NULL,
  `email_subject` varchar(100) NOT NULL,
  `type` enum('SMS','Email') NOT NULL default 'SMS',
  `notification_sent_date` datetime NOT NULL,
  PRIMARY KEY  (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `automatic_notification`
-- 

INSERT INTO `automatic_notification` (`notification_id`, `sms_gateway_type`, `next_app_date`, `next_app_time`, `provider_name`, `message`, `email_sender`, `email_subject`, `type`, `notification_sent_date`) VALUES (1, 'CLICKATELL', '0000-00-00', ':', 'EMR GROUP 1 .. SMS', 'Welcome to EMR GROUP 1.. SMS', '', '', 'SMS', '0000-00-00 00:00:00'),
(2, '', '2007-10-02', '05:50', 'EMR GROUP', 'Welcome to EMR GROUP . Email', 'EMR Group', 'Welcome to EMR GROUP', 'Email', '2007-09-30 00:00:00');

-- --------------------------------------------------------

-- 
-- Table structure for table `notification_log`
-- 

DROP TABLE IF EXISTS `notification_log`;
CREATE TABLE `notification_log` (
  `iLogId` int(11) NOT NULL auto_increment,
  `pid` int(7) NOT NULL,
  `pc_eid` int(11) unsigned NULL,
  `sms_gateway_type` varchar(50) NOT NULL,
  `smsgateway_info` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `email_sender` varchar(255) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `type` enum('SMS','Email') NOT NULL,
  `patient_info` text NOT NULL,
  `pc_eventDate` date NOT NULL,
  `pc_endDate` date NOT NULL,
  `pc_startTime` time NOT NULL,
  `pc_endTime` time NOT NULL,
  `dSentDateTime` datetime NOT NULL,
  PRIMARY KEY  (`iLogId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `notification_settings`
-- 

DROP TABLE IF EXISTS `notification_settings`;
CREATE TABLE `notification_settings` (
  `SettingsId` int(3) NOT NULL auto_increment,
  `Send_SMS_Before_Hours` int(3) NOT NULL,
  `Send_Email_Before_Hours` int(3) NOT NULL,
  `SMS_gateway_username` varchar(100) NOT NULL,
  `SMS_gateway_password` varchar(100) NOT NULL,
  `SMS_gateway_apikey` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY  (`SettingsId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `notification_settings`
-- 

INSERT INTO `notification_settings` (`SettingsId`, `Send_SMS_Before_Hours`, `Send_Email_Before_Hours`, `SMS_gateway_username`, `SMS_gateway_password`, `SMS_gateway_apikey`, `type`) VALUES (1, 150, 150, 'sms username', 'sms password', 'sms api key', 'SMS/Email Settings');

-- -------------------------------------------------------------------

CREATE TABLE chart_tracker (
  ct_pid            int(11)       NOT NULL,
  ct_when           datetime      NOT NULL,
  ct_userid         bigint(20)    NOT NULL DEFAULT 0,
  ct_location       varchar(31)   NOT NULL DEFAULT '',
  PRIMARY KEY (ct_pid, ct_when)
) ENGINE=MyISAM;

CREATE TABLE ar_session (
  session_id     int unsigned  NOT NULL AUTO_INCREMENT,
  payer_id       int(11)       NOT NULL            COMMENT '0=pt else references insurance_companies.id',
  user_id        int(11)       NOT NULL            COMMENT 'references users.id for session owner',
  closed         tinyint(1)    NOT NULL DEFAULT 0  COMMENT '0=no, 1=yes',
  reference      varchar(255)  NOT NULL DEFAULT '' COMMENT 'check or EOB number',
  check_date     date          DEFAULT NULL,
  deposit_date   date          DEFAULT NULL,
  pay_total      decimal(12,2) NOT NULL DEFAULT 0,
  created_time timestamp NOT NULL default CURRENT_TIMESTAMP,
  modified_time datetime NOT NULL,
  global_amount decimal( 12, 2 ) NOT NULL ,
  payment_type varchar( 50 ) NOT NULL ,
  description text NOT NULL ,
  adjustment_code varchar( 50 ) NOT NULL ,
  post_to_date date NOT NULL ,
  patient_id int( 11 ) NOT NULL ,
  payment_method varchar( 25 ) NOT NULL,
  PRIMARY KEY (session_id),
  KEY user_closed (user_id, closed),
  KEY deposit_date (deposit_date)
) ENGINE=MyISAM;

CREATE TABLE ar_activity (
  pid            int(11)       NOT NULL,
  encounter      int(11)       NOT NULL,
  sequence_no    int unsigned  NOT NULL AUTO_INCREMENT,
  `code_type`    varchar(12)   NOT NULL DEFAULT '',
  code           varchar(9)    NOT NULL            COMMENT 'empty means claim level',
  modifier       varchar(5)    NOT NULL DEFAULT '',
  payer_type     int           NOT NULL            COMMENT '0=pt, 1=ins1, 2=ins2, etc',
  post_time      datetime      NOT NULL,
  post_user      int(11)       NOT NULL            COMMENT 'references users.id',
  session_id     int unsigned  NOT NULL            COMMENT 'references ar_session.session_id',
  memo           varchar(255)  NOT NULL DEFAULT '' COMMENT 'adjustment reasons go here',
  pay_amount     decimal(12,2) NOT NULL DEFAULT 0  COMMENT 'either pay or adj will always be 0',
  adj_amount     decimal(12,2) NOT NULL DEFAULT 0,
  modified_time datetime NOT NULL,
  follow_up char(1) NOT NULL,
  follow_up_note text NOT NULL,
  account_code varchar(15) NOT NULL,
  reason_code varchar(255) DEFAULT NULL COMMENT 'Use as needed to show the primary payer adjustment reason code',
  PRIMARY KEY (pid, encounter, sequence_no),
  KEY session_id (session_id)
) ENGINE=MyISAM;

CREATE TABLE `users_facility` (
  `tablename` varchar(64) NOT NULL,
  `table_id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL,
  PRIMARY KEY (`tablename`,`table_id`,`facility_id`)
) ENGINE=InnoDB COMMENT='joins users or patient_data to facility table';

CREATE TABLE `lbf_data` (
  `form_id`     int(11)      NOT NULL AUTO_INCREMENT COMMENT 'references forms.form_id',
  `field_id`    varchar(31)  NOT NULL COMMENT 'references layout_options.field_id',
  `field_value` TEXT NOT NULL,
  PRIMARY KEY (`form_id`,`field_id`)
) ENGINE=MyISAM COMMENT='contains all data from layout-based forms';

CREATE TABLE gprelations (
  type1 int(2)     NOT NULL,
  id1   bigint(20) NOT NULL,
  type2 int(2)     NOT NULL,
  id2   bigint(20) NOT NULL,
  PRIMARY KEY (type1,id1,type2,id2),
  KEY key2  (type2,id2)
) ENGINE=MyISAM COMMENT='general purpose relations';

CREATE TABLE `procedure_type` (
  `procedure_type_id`   bigint(20)   NOT NULL AUTO_INCREMENT,
  `parent`              bigint(20)   NOT NULL DEFAULT 0  COMMENT 'references procedure_type.procedure_type_id',
  `name`                varchar(63)  NOT NULL DEFAULT '' COMMENT 'name for this category, procedure or result type',
  `lab_id`              bigint(20)   NOT NULL DEFAULT 0  COMMENT 'references users.id, 0 means default to parent',
  `procedure_code`      varchar(31)  NOT NULL DEFAULT '' COMMENT 'code identifying this procedure',
  `procedure_type`      varchar(31)  NOT NULL DEFAULT '' COMMENT 'see list proc_type',
  `body_site`           varchar(31)  NOT NULL DEFAULT '' COMMENT 'where to do injection, e.g. arm, buttok',
  `specimen`            varchar(31)  NOT NULL DEFAULT '' COMMENT 'blood, urine, saliva, etc.',
  `route_admin`         varchar(31)  NOT NULL DEFAULT '' COMMENT 'oral, injection',
  `laterality`          varchar(31)  NOT NULL DEFAULT '' COMMENT 'left, right, ...',
  `description`         varchar(255) NOT NULL DEFAULT '' COMMENT 'descriptive text for procedure_code',
  `standard_code`       varchar(255) NOT NULL DEFAULT '' COMMENT 'industry standard code type and code (e.g. CPT4:12345)',
  `related_code`        varchar(255) NOT NULL DEFAULT '' COMMENT 'suggested code(s) for followup services if result is abnormal',
  `units`               varchar(31)  NOT NULL DEFAULT '' COMMENT 'default for procedure_result.units',
  `range`               varchar(255) NOT NULL DEFAULT '' COMMENT 'default for procedure_result.range',
  `seq`                 int(11)      NOT NULL default 0  COMMENT 'sequence number for ordering',
  PRIMARY KEY (`procedure_type_id`),
  KEY parent (parent)
) ENGINE=MyISAM;

CREATE TABLE `procedure_order` (
  `procedure_order_id`     bigint(20)   NOT NULL AUTO_INCREMENT,
  `procedure_type_id`      bigint(20)   NOT NULL            COMMENT 'references procedure_type.procedure_type_id',
  `provider_id`            bigint(20)   NOT NULL DEFAULT 0  COMMENT 'references users.id',
  `patient_id`             bigint(20)   NOT NULL            COMMENT 'references patient_data.pid',
  `encounter_id`           bigint(20)   NOT NULL DEFAULT 0  COMMENT 'references form_encounter.encounter',
  `date_collected`         datetime     DEFAULT NULL        COMMENT 'time specimen collected',
  `date_ordered`           date         DEFAULT NULL,
  `order_priority`         varchar(31)  NOT NULL DEFAULT '',
  `order_status`           varchar(31)  NOT NULL DEFAULT '' COMMENT 'pending,routed,complete,canceled',
  `patient_instructions`   text         NOT NULL DEFAULT '',
  `activity`               tinyint(1)   NOT NULL DEFAULT 1  COMMENT '0 if deleted',
  `control_id`             bigint(20)   NOT NULL            COMMENT 'This is the CONTROL ID that is sent back from lab',
  PRIMARY KEY (`procedure_order_id`),
  KEY datepid (date_ordered, patient_id),
  KEY `patient_id` (`patient_id`)
) ENGINE=MyISAM;

CREATE TABLE `procedure_report` (
  `procedure_report_id` bigint(20)     NOT NULL AUTO_INCREMENT,
  `procedure_order_id`  bigint(20)     DEFAULT NULL   COMMENT 'references procedure_order.procedure_order_id',
  `date_collected`      datetime       DEFAULT NULL,
  `date_report`         date           DEFAULT NULL,
  `source`              bigint(20)     NOT NULL DEFAULT 0  COMMENT 'references users.id, who entered this data',
  `specimen_num`        varchar(63)    NOT NULL DEFAULT '',
  `report_status`       varchar(31)    NOT NULL DEFAULT '' COMMENT 'received,complete,error',
  `review_status`       varchar(31)    NOT NULL DEFAULT 'received' COMMENT 'panding reivew status: received,reviewed',  
  PRIMARY KEY (`procedure_report_id`),
  KEY procedure_order_id (procedure_order_id)
) ENGINE=MyISAM; 

CREATE TABLE `procedure_result` (
  `procedure_result_id` bigint(20)   NOT NULL AUTO_INCREMENT,
  `procedure_report_id` bigint(20)   NOT NULL            COMMENT 'references procedure_report.procedure_report_id',
  `procedure_type_id`   bigint(20)   NOT NULL            COMMENT 'references procedure_type.procedure_type_id',
  `date`                datetime     DEFAULT NULL        COMMENT 'lab-provided date specific to this result',
  `facility`            varchar(255) NOT NULL DEFAULT '' COMMENT 'lab-provided testing facility ID',
  `units`               varchar(31)  NOT NULL DEFAULT '',
  `result`              varchar(255) NOT NULL DEFAULT '',
  `range`               varchar(255) NOT NULL DEFAULT '',
  `abnormal`            varchar(31)  NOT NULL DEFAULT '' COMMENT 'no,yes,high,low',
  `comments`            text         NOT NULL DEFAULT '' COMMENT 'comments from the lab',
  `document_id`         bigint(20)   NOT NULL DEFAULT 0  COMMENT 'references documents.id if this result is a document',
  `result_status`       varchar(31)  NOT NULL DEFAULT '' COMMENT 'preliminary, cannot be done, final, corrected, incompete...etc.',
  PRIMARY KEY (`procedure_result_id`),
  KEY procedure_report_id (procedure_report_id)
) ENGINE=MyISAM; 

CREATE TABLE `globals` (
  `gl_name`             varchar(63)    NOT NULL,
  `gl_index`            int(11)        NOT NULL DEFAULT 0,
  `gl_value`            varchar(255)   NOT NULL DEFAULT '',
  PRIMARY KEY (`gl_name`, `gl_index`)
) ENGINE=MyISAM; 

CREATE TABLE code_types (
  ct_key  varchar(15) NOT NULL           COMMENT 'short alphanumeric name',
  ct_id   int(11)     UNIQUE NOT NULL    COMMENT 'numeric identifier',
  ct_seq  int(11)     NOT NULL DEFAULT 0 COMMENT 'sort order',
  ct_mod  int(11)     NOT NULL DEFAULT 0 COMMENT 'length of modifier field',
  ct_just varchar(15) NOT NULL DEFAULT ''COMMENT 'ct_key of justify type, if any',
  ct_mask varchar(9)  NOT NULL DEFAULT ''COMMENT 'formatting mask for code values',
  ct_fee  tinyint(1)  NOT NULL default 0 COMMENT '1 if fees are used',
  ct_rel  tinyint(1)  NOT NULL default 0 COMMENT '1 if can relate to other code types',
  ct_nofs tinyint(1)  NOT NULL default 0 COMMENT '1 if to be hidden in the fee sheet',
  ct_diag tinyint(1)  NOT NULL default 0 COMMENT '1 if this is a diagnosis type',
  ct_active tinyint(1) NOT NULL default 1 COMMENT '1 if this is active',
  ct_label varchar(31) NOT NULL default '' COMMENT 'label of this code type',
  ct_external tinyint(1) NOT NULL default 0 COMMENT '0 if stored codes in codes tables, 1 or greater if codes stored in external tables',
  PRIMARY KEY (ct_key)
) ENGINE=MyISAM;
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('ICD9' , 2, 1, 0, ''    , 0, 0, 0, 1, 1, 'ICD9', 0);
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('CPT4' , 1, 2, 12, 'ICD9', 1, 0, 0, 0, 1, 'CPT4', 0);
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('HCPCS', 3, 3, 12, 'ICD9', 1, 0, 0, 0, 1, 'HCPCS', 0);
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('CVX'  , 100, 100, 0, '', 0, 0, 1, 0, 1, 'CVX', 0);
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('DSMIV' , 101, 101, 0, '', 0, 0, 0, 1, 0, 'DSMIV', 0);
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('ICD10' , 102, 102, 0, '', 0, 0, 0, 1, 0, 'ICD10', 1);
INSERT INTO code_types (ct_key, ct_id, ct_seq, ct_mod, ct_just, ct_fee, ct_rel, ct_nofs, ct_diag, ct_active, ct_label, ct_external ) VALUES ('SNOMED' , 103, 103, 0, '', 0, 0, 0, 1, 0, 'SNOMED', 2);

INSERT INTO list_options ( list_id, option_id, title, seq ) VALUES ('lists', 'code_types', 'Code Types', 1);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'disclosure_type','Disclosure Type', 3,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('disclosure_type', 'disclosure-treatment', 'Treatment', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('disclosure_type', 'disclosure-payment', 'Payment', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('disclosure_type', 'disclosure-healthcareoperations', 'Health Care Operations', 30, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'smoking_status','Smoking Status', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('smoking_status', '1', 'Current every day smoker', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('smoking_status', '2', 'Current some day smoker', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('smoking_status', '3', 'Former smoker', 30, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('smoking_status', '4', 'Never smoker', 40, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('smoking_status', '5', 'Smoker, current status unknown', 50, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('smoking_status', '9', 'Unknown if ever smoked', 60, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'race','Race', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('race', 'amer_ind_or_alaska_native', 'American Indian or Alaska Native', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('race', 'Asian', 'Asian',20,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('race', 'black_or_afri_amer', 'Black or African American',30,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('race', 'native_hawai_or_pac_island', 'Native Hawaiian or Other Pacific Islander',40,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('race', 'white', 'White',50,0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'ethnicity','Ethnicity', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethnicity', 'hisp_or_latin', 'Hispanic or Latino', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('ethnicity', 'not_hisp_or_latin', 'Not Hispanic or Latino', 10, 0);

INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('lists'   ,'payment_date','Payment Date', 1,0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_date', 'date_val', 'Date', 10, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_date', 'post_to_date', 'Post To Date', 20, 0);
INSERT INTO list_options ( list_id, option_id, title, seq, is_default ) VALUES ('payment_date', 'deposit_date', 'Deposit Date', 30, 0);


INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','soc','SOC','11',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','address','Address','31',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','age','Age','41',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','sex','Sex','51',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','attending_physician','Attending Physician','60',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','area_director1','Area Director','61',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','case_manager1','Case Manager','62',0,0,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','primary_referal_source','Primary Referal Source','63',0,0,'','');


INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','hospital','Hospital','40',0,1,'','');

INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','agency','Agency','45',0,1,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','referring_physician','Referring Physician','50',0,1,'','');

INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('lists', 'facility_name', 'Facility Name', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'hospital', 'Hospital', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'alf', 'ALF', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'snf', 'SNF', '3', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'md', 'MD', '4', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'infusion_co', 'Infusion Co', '5', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'rehab', 'Rehab', '6', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'clinic', 'Clinic', '7', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'acute_care_facility', 'Acute Care Facility', '8', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`) VALUES('facility_name', 'other', 'Other', '9', '0', '1', '', '');

INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','physician','Physician','55',0,1,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','outside_case_manager','Outside Case Manager','60',0,1,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','internal_referrer','Internal Referrer','70',0,1,'','');


INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'admit_status', 'Admit Status', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('admit_status', 'pre_admit', 'Pre-Admit', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('admit_status', 'admit', 'Admit', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('admit_status', 'discharge', 'Discharge', '3', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('admit_status', 'non_admit', 'Non-Admit', '4', '0', '1', '', '');

INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('ptlistcols','admit_status','Admit Status','12',0,1,'','');
DELETE FROM list_options WHERE option_id='pubpid';

INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'referraltype', 'Type of Referral', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'physician', 'Physician', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'hospital', 'Hospital', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'snf', 'SNF', '3', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'alf', 'ALF', '4', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'board_care', 'Board and Care', '5', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'vendor', 'Vendor', '6', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'family', 'Family', '7', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'self', 'Self', '8', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'internal_referrer', 'Internal Referrer', '9', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('referraltype', 'other', 'Other', '10', '0', '1', '', '');

INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'yesnona', 'Yes No NA', '1', '0', '0', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('yesnona', 'yes', 'Yes', '1', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('yesnona', 'no', 'No', '2', '0', '1', '', '');
INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('yesnona', 'na', 'N/A', '3', '0', '1', '', '');

INSERT INTO `list_options` (`list_id` ,`option_id` ,`title` ,`seq` ,`is_default` ,`option_value` ,`mapping` ,`notes`)VALUES ('lists', 'agencyarea', 'Agency Area', '1', '0', '0', '', '');

INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','snf','SNF','72',0,1,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','alf','ALF','74',0,1,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','board_care','Board and Care','76',0,1,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','family','Family','78',0,1,'','');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES('abook_type','self','Self','80',0,1,'','');

-- --------------------------------------------------------

-- 
-- Table structure for table `extended_log`
--

DROP TABLE IF EXISTS `extended_log`;
CREATE TABLE `extended_log` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime default NULL,
  `event` varchar(255) default NULL,
  `user` varchar(255) default NULL,
  `recipient` varchar(255) default NULL,
  `description` longtext,
  `patient_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

CREATE TABLE version (
  v_major    int(11)     NOT NULL DEFAULT 0,
  v_minor    int(11)     NOT NULL DEFAULT 0,
  v_patch    int(11)     NOT NULL DEFAULT 0,
  v_realpatch int(11)    NOT NULL DEFAULT 0,
  v_tag      varchar(31) NOT NULL DEFAULT '',
  v_database int(11)     NOT NULL DEFAULT 0
) ENGINE=MyISAM;
INSERT INTO version (v_major, v_minor, v_patch, v_realpatch, v_tag, v_database) VALUES (0, 0, 0, 0, '', 0);
-- --------------------------------------------------------

--
-- Table structure for table `customlists`
--

CREATE TABLE `customlists` (
  `cl_list_slno` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cl_list_id` int(10) unsigned NOT NULL COMMENT 'ID OF THE lIST FOR NEW TAKE SELECT MAX(cl_list_id)+1',
  `cl_list_item_id` int(10) unsigned DEFAULT NULL COMMENT 'ID OF THE lIST FOR NEW TAKE SELECT MAX(cl_list_item_id)+1',
  `cl_list_type` int(10) unsigned NOT NULL COMMENT '0=>List Name 1=>list items 2=>Context 3=>Template 4=>Sentence 5=> SavedTemplate 6=>CustomButton',
  `cl_list_item_short` varchar(10) DEFAULT NULL,
  `cl_list_item_long` text NOT NULL,
  `cl_list_item_level` int(11) DEFAULT NULL COMMENT 'Flow level for List Designation',
  `cl_order` int(11) DEFAULT NULL,
  `cl_deleted` tinyint(1) DEFAULT '0',
  `cl_creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`cl_list_slno`)
) ENGINE=InnoDB AUTO_INCREMENT=1;
INSERT INTO customlists(cl_list_id,cl_list_type,cl_list_item_long) VALUES (1,2,'Subjective');
INSERT INTO customlists(cl_list_id,cl_list_type,cl_list_item_long) VALUES (2,2,'Objective');
INSERT INTO customlists(cl_list_id,cl_list_type,cl_list_item_long) VALUES (3,2,'Assessment');
INSERT INTO customlists(cl_list_id,cl_list_type,cl_list_item_long) VALUES (4,2,'Plan');
-- --------------------------------------------------------

--
-- Table structure for table `template_users`
--

CREATE TABLE `template_users` (
  `tu_id` int(11) NOT NULL AUTO_INCREMENT,
  `tu_user_id` int(11) DEFAULT NULL,
  `tu_facility_id` int(11) DEFAULT NULL,
  `tu_template_id` int(11) DEFAULT NULL,
  `tu_template_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`tu_id`),
  UNIQUE KEY `templateuser` (`tu_user_id`,`tu_template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE `product_warehouse` (
  `pw_drug_id`   int(11) NOT NULL,
  `pw_warehouse` varchar(31) NOT NULL,
  `pw_min_level` float       DEFAULT 0,
  `pw_max_level` float       DEFAULT 0,
  PRIMARY KEY  (`pw_drug_id`,`pw_warehouse`)
) ENGINE=MyISAM;

--
-- Table structure for table `oasis_pdf`
--

CREATE TABLE IF NOT EXISTS `oasis_pdf` (
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

--
-- Table structure for table `eSignatures`
--

CREATE TABLE IF NOT EXISTS `eSignatures` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT 'Table row ID for signature',
  `table` varchar(255) NOT NULL COMMENT 'table name for the signature',
  `uid` int(11) NOT NULL COMMENT 'user id for the signing user',
  `datetime` datetime NOT NULL COMMENT 'datetime of the signature action',
  `signed` int(11) NOT NULL DEFAULT '0' COMMENT '0 or not 0 - reflects signature record signed/not signed/ or signed with some exception to be determined. ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `episodes`;
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


DROP TABLE IF EXISTS `episode_num`;
CREATE TABLE `episode_num` (
  `id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO episode_num VALUES();

DELETE FROM layout_options WHERE group_name='6Misc';


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


DROP TABLE IF EXISTS `forms_supervisor_visit_note`;
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

INSERT INTO `registry` VALUES ('HHA-Supervisor Visit', 1, 'supervisor_visit_note', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');


DROP TABLE IF EXISTS `forms_home_environment`;
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

INSERT INTO `registry` VALUES ('Home Environment', 1, 'home_environment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');


DROP TABLE IF EXISTS `forms_incident_report`;
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

INSERT INTO `registry` VALUES ('Incident Report', 1, 'incident_report', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');

DROP TABLE IF EXISTS `forms_non_oasis`;
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

INSERT INTO `registry` VALUES ('Non-OASIS Discharge Assessment', 1, 'non_oasis', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');


DROP TABLE IF EXISTS `forms_patient_missed_visit`;
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

INSERT INTO `registry` VALUES ('Patient Missed Visit', 1, 'patient_missed_visit', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');


DROP TABLE IF EXISTS `forms_physician_face`;
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

INSERT INTO `registry` VALUES ('Physician Face To Face Encounter', 1, 'physician_face', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');


DROP TABLE IF EXISTS `forms_physician_orders`;
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
physician_orders_diagnosis tinyint(4) default NULL,
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

INSERT INTO `registry` VALUES ('Physician Orders', 1, 'physician_orders', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');

DROP TABLE IF EXISTS `forms_sixty_day_progress_note`;
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

INSERT INTO `registry` VALUES ('Sixty Day Progress Note', 1, 'sixty_day_progress_note', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');


DROP TABLE IF EXISTS `forms_30_day_progress_note`;
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

INSERT INTO `registry` VALUES ('Thirty Day Progress Note', 1, 'thirtyday_progress_note', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, '', '');


DROP TABLE IF EXISTS `forms_dietary_assessment`;
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

INSERT INTO `registry` VALUES ('Dietary Assessment', 1, 'dietary_assessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Dietary', '');


DROP TABLE IF EXISTS `forms_dietary_care_plan`;
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

INSERT INTO `registry` VALUES ('Dietary Care Plan', 1, 'dietary_care_plan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Dietary', '');


DROP TABLE IF EXISTS `forms_dietary_visit`;
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

INSERT INTO `registry` VALUES ('Dietary Visit', 1, 'dietary_visit', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Dietary', '');



DROP TABLE IF EXISTS `forms_msw_careplan`;
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

INSERT INTO `registry` VALUES ('MSW Careplan', 1, 'msw_careplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'MSW', '');


DROP TABLE IF EXISTS `forms_msw_evaluation`;
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

INSERT INTO `registry` VALUES ('MSW Evaluation', 1, 'msw_evaluation', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'MSW', '');

DROP TABLE IF EXISTS `forms_msw_visit_note`;
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

INSERT INTO `registry` VALUES ('MSW Visit Note', 1, 'msw_visit_note', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'MSW', '');


DROP TABLE IF EXISTS `forms_oasis_discharge`;
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
oasis_system_review_bowel varchar(30),
oasis_system_review_bowel_detail varchar(10),
oasis_system_review_bowel_other varchar(30),
oasis_system_review_bowel_sounds varchar(30),
oasis_system_review_bladder varchar(30),
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
oasis_mental_status varchar(150),
oasis_mental_status_other varchar(100) DEFAULT NULL,
oasis_functional_limitations varchar(225),
oasis_functional_limitations_other varchar(100) DEFAULT NULL,
oasis_prognosis varchar(10),
oasis_safety_measures text,
oasis_safety_measures_other varchar(150),
oasis_dme_iv_supplies varchar(225),
oasis_dme_iv_supplies_other varchar(150),
oasis_dme_foley_supplies varchar(225),
oasis_dme_foley_supplies_other varchar(150),



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
non_oasis_summary_demonstrates_explain varchar(100) DEFAULT NULL,
synergy_id varchar(10)
 ) engine=MyISAM;

INSERT INTO `registry` VALUES ('OASIS Discharge', 1, 'oasis_discharge', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');



DROP TABLE IF EXISTS `forms_oasis_c_nurse`;
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
oasis_c_nurse_certification varchar(1),
oasis_c_nurse_date_last_contacted_physician DATE,
oasis_c_nurse_date_last_seen_by_physician DATE,
oasis_patient_diagnosis_1a varchar(10),
oasis_patient_diagnosis_2a varchar(10),
oasis_patient_diagnosis_2a_indicator varchar(1),
oasis_patient_diagnosis_2a_sub varchar(10),
oasis_patient_diagnosis_3a varchar(10),
oasis_patient_diagnosis_4a varchar(10),
oasis_patient_diagnosis_1b varchar(10),
oasis_patient_diagnosis_2b varchar(10),
oasis_patient_diagnosis_2b_indicator varchar(1),
oasis_patient_diagnosis_2b_sub varchar(10),
oasis_patient_diagnosis_3b varchar(10),
oasis_patient_diagnosis_4b varchar(10),
oasis_patient_diagnosis_1c varchar(10),
oasis_patient_diagnosis_2c varchar(10),
oasis_patient_diagnosis_2c_indicator varchar(1),
oasis_patient_diagnosis_2c_sub varchar(10),
oasis_patient_diagnosis_3c varchar(10),
oasis_patient_diagnosis_4c varchar(10),
oasis_patient_diagnosis_1d varchar(10),
oasis_patient_diagnosis_2d varchar(10),
oasis_patient_diagnosis_2d_indicator varchar(1),
oasis_patient_diagnosis_2d_sub varchar(10),
oasis_patient_diagnosis_3d varchar(10),
oasis_patient_diagnosis_4d varchar(10),
oasis_patient_diagnosis_1e varchar(10),
oasis_patient_diagnosis_2e varchar(10),
oasis_patient_diagnosis_2e_indicator varchar(1),
oasis_patient_diagnosis_2e_sub varchar(10),
oasis_patient_diagnosis_3e varchar(10),
oasis_patient_diagnosis_4e varchar(10),
oasis_patient_diagnosis_1f varchar(10),
oasis_patient_diagnosis_2f varchar(10),
oasis_patient_diagnosis_2f_indicator varchar(1),
oasis_patient_diagnosis_2f_sub varchar(10),
oasis_patient_diagnosis_3f varchar(10),
oasis_patient_diagnosis_4f varchar(10),
oasis_patient_diagnosis_1g varchar(10),
oasis_patient_diagnosis_2g varchar(10),
oasis_patient_diagnosis_2g_indicator varchar(1),
oasis_patient_diagnosis_2g_sub varchar(10),
oasis_patient_diagnosis_3g varchar(10),
oasis_patient_diagnosis_4g varchar(10),
oasis_patient_diagnosis_1h varchar(10),
oasis_patient_diagnosis_2h varchar(10),
oasis_patient_diagnosis_2h_indicator varchar(1),
oasis_patient_diagnosis_2h_sub varchar(10),
oasis_patient_diagnosis_3h varchar(10),
oasis_patient_diagnosis_4h varchar(10),
oasis_patient_diagnosis_1i varchar(10),
oasis_patient_diagnosis_2i varchar(10),
oasis_patient_diagnosis_2i_indicator varchar(1),
oasis_patient_diagnosis_2i_sub varchar(10),
oasis_patient_diagnosis_3i varchar(10),
oasis_patient_diagnosis_4i varchar(10),
oasis_patient_diagnosis_1j varchar(10),
oasis_patient_diagnosis_2j varchar(10),
oasis_patient_diagnosis_2j_indicator varchar(1),
oasis_patient_diagnosis_2j_sub varchar(10),
oasis_patient_diagnosis_3j varchar(10),
oasis_patient_diagnosis_4j varchar(10),
oasis_patient_diagnosis_1k varchar(10),
oasis_patient_diagnosis_2k varchar(10),
oasis_patient_diagnosis_2k_indicator varchar(1),
oasis_patient_diagnosis_2k_sub varchar(10),
oasis_patient_diagnosis_3k varchar(10),
oasis_patient_diagnosis_4k varchar(10),
oasis_patient_diagnosis_1l varchar(10),
oasis_patient_diagnosis_2l varchar(10),oasistransfer_prognosis
oasis_patient_diagnosis_2l_indicator varchar(1),
oasis_patient_diagnosis_2l_sub varchar(10),
oasis_patient_diagnosis_3l varchar(10),
oasis_patient_diagnosis_4l varchar(10),
oasis_patient_diagnosis_1m varchar(10),
oasis_patient_diagnosis_2m varchar(10),
oasis_patient_diagnosis_2m_indicator varchar(1),
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
 oasis_signature_middle_init varchar(30) default NULL,
synergy_id varchar(10)
) engine=MyISAM;

INSERT INTO `registry` VALUES ('OASIS Recert-Nursing', 1, 'oasis_c_nurse', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');


DROP TABLE IF EXISTS `forms_oasis_therapy_rectification`;
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
oasis_therapy_certification varchar(1),
oasis_therapy_date_last_contacted_physician DATE,
oasis_therapy_date_last_seen_by_physician DATE,
oasis_therapy_patient_diagnosis_1a varchar(10),
oasis_therapy_patient_diagnosis_2a varchar(10),
oasis_therapy_patient_diagnosis_2a_indicator varchar(1),
oasis_therapy_patient_diagnosis_2a_sub varchar(2),
oasis_therapy_patient_diagnosis_3a varchar(10),
oasis_therapy_patient_diagnosis_4a varchar(10),
oasis_therapy_patient_diagnosis_1b varchar(10),
oasis_therapy_patient_diagnosis_2b varchar(10),
oasis_therapy_patient_diagnosis_2b_indicator varchar(1),
oasis_therapy_patient_diagnosis_2b_sub varchar(2),
oasis_therapy_patient_diagnosis_3b varchar(10),
oasis_therapy_patient_diagnosis_4b varchar(10),
oasis_therapy_patient_diagnosis_1c varchar(10),
oasis_therapy_patient_diagnosis_2c varchar(10),
oasis_therapy_patient_diagnosis_2c_indicator varchar(1),
oasis_therapy_patient_diagnosis_2c_sub varchar(2),
oasis_therapy_patient_diagnosis_3c varchar(10),
oasis_therapy_patient_diagnosis_4c varchar(10),
oasis_therapy_patient_diagnosis_1d varchar(10),
oasis_therapy_patient_diagnosis_2d varchar(10),
oasis_therapy_patient_diagnosis_2d_indicator varchar(1),
oasis_therapy_patient_diagnosis_2d_sub varchar(2),
oasis_therapy_patient_diagnosis_3d varchar(10),
oasis_therapy_patient_diagnosis_4d varchar(10),
oasis_therapy_patient_diagnosis_1e varchar(10),
oasis_therapy_patient_diagnosis_2e varchar(10),
oasis_therapy_patient_diagnosis_2e_indicator varchar(1),
oasis_therapy_patient_diagnosis_2e_sub varchar(2),
oasis_therapy_patient_diagnosis_3e varchar(10),
oasis_therapy_patient_diagnosis_4e varchar(10),
oasis_therapy_patient_diagnosis_1f varchar(10),
oasis_therapy_patient_diagnosis_2f varchar(10),
oasis_therapy_patient_diagnosis_2f_indicator varchar(1),
oasis_therapy_patient_diagnosis_2f_sub varchar(2),
oasis_therapy_patient_diagnosis_3f varchar(10),
oasis_therapy_patient_diagnosis_4f varchar(10),
oasis_therapy_patient_diagnosis_1g varchar(10),
oasis_therapy_patient_diagnosis_2g varchar(10),
oasis_therapy_patient_diagnosis_2g_indicator varchar(1),
oasis_therapy_patient_diagnosis_2g_sub varchar(2),
oasis_therapy_patient_diagnosis_3g varchar(10),
oasis_therapy_patient_diagnosis_4g varchar(10),
oasis_therapy_patient_diagnosis_1h varchar(10),
oasis_therapy_patient_diagnosis_2h varchar(10),
oasis_therapy_patient_diagnosis_2h_indicator varchar(1),
oasis_therapy_patient_diagnosis_2h_sub varchar(2),
oasis_therapy_patient_diagnosis_3h varchar(10),
oasis_therapy_patient_diagnosis_4h varchar(10),
oasis_therapy_patient_diagnosis_1i varchar(10),
oasis_therapy_patient_diagnosis_2i varchar(10),
oasis_therapy_patient_diagnosis_2i_indicator varchar(1),
oasis_therapy_patient_diagnosis_2i_sub varchar(2),
oasis_therapy_patient_diagnosis_3i varchar(10),
oasis_therapy_patient_diagnosis_4i varchar(10),
oasis_therapy_patient_diagnosis_1j varchar(10),
oasis_therapy_patient_diagnosis_2j varchar(10),
oasis_therapy_patient_diagnosis_2j_indicator varchar(1),
oasis_therapy_patient_diagnosis_2j_sub varchar(2),
oasis_therapy_patient_diagnosis_3j varchar(10),
oasis_therapy_patient_diagnosis_4j varchar(10),
oasis_therapy_patient_diagnosis_1k varchar(10),
oasis_therapy_patient_diagnosis_2k varchar(10),
oasis_therapy_patient_diagnosis_2k_indicator varchar(1),
oasis_therapy_patient_diagnosis_2k_sub varchar(2),
oasis_therapy_patient_diagnosis_3k varchar(10),
oasis_therapy_patient_diagnosis_4k varchar(10),
oasis_therapy_patient_diagnosis_1l varchar(10),
oasis_therapy_patient_diagnosis_2l varchar(10),
oasis_therapy_patient_diagnosis_2l_indicator varchar(1),
oasis_therapy_patient_diagnosis_2l_sub varchar(2),
oasis_therapy_patient_diagnosis_3l varchar(10),
oasis_therapy_patient_diagnosis_4l varchar(10),
oasis_therapy_patient_diagnosis_1m varchar(10),
oasis_therapy_patient_diagnosis_2m varchar(10),
oasis_therapy_patient_diagnosis_2m_indicator varchar(1),
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
oasis_therapy_orders varchar(20),
synergy_id varchar(10)
) engine=MyISAM;

INSERT INTO `registry` VALUES ('OASIS Recert-PT', 1, 'oasis_therapy_rectification', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');


DROP TABLE IF EXISTS `forms_oasis_nursing_soc`;
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
oasis_patient_certification varchar(1),
oasis_patient_date_last_contacted_physician DATE,
oasis_patient_date_last_seen_by_physician DATE,
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
oasis_therapy_patient_diagnosis_2a_indicator varchar(1),
oasis_therapy_patient_diagnosis_2a_sub varchar(2),
oasis_therapy_patient_diagnosis_3a varchar(10),
oasis_therapy_patient_diagnosis_4a varchar(10),
oasis_therapy_patient_diagnosis_1b varchar(10),
oasis_therapy_patient_diagnosis_2b varchar(10),
oasis_therapy_patient_diagnosis_2b_indicator varchar(1),
oasis_therapy_patient_diagnosis_2b_sub varchar(2),
oasis_therapy_patient_diagnosis_3b varchar(10),
oasis_therapy_patient_diagnosis_4b varchar(10),
oasis_therapy_patient_diagnosis_1c varchar(10),
oasis_therapy_patient_diagnosis_2c varchar(10),
oasis_therapy_patient_diagnosis_2c_indicator varchar(1),
oasis_therapy_patient_diagnosis_2c_sub varchar(2),
oasis_therapy_patient_diagnosis_3c varchar(10),
oasis_therapy_patient_diagnosis_4c varchar(10),
oasis_therapy_patient_diagnosis_1d varchar(10),
oasis_therapy_patient_diagnosis_2d varchar(10),
oasis_therapy_patient_diagnosis_2d_indicator varchar(1),
oasis_therapy_patient_diagnosis_2d_sub varchar(2),
oasis_therapy_patient_diagnosis_3d varchar(10),
oasis_therapy_patient_diagnosis_4d varchar(10),
oasis_therapy_patient_diagnosis_1e varchar(10),
oasis_therapy_patient_diagnosis_2e varchar(10),
oasis_therapy_patient_diagnosis_2e_indicator varchar(1),
oasis_therapy_patient_diagnosis_2e_sub varchar(2),
oasis_therapy_patient_diagnosis_3e varchar(10),
oasis_therapy_patient_diagnosis_4e varchar(10),
oasis_therapy_patient_diagnosis_1f varchar(10),
oasis_therapy_patient_diagnosis_2f varchar(10),
oasis_therapy_patient_diagnosis_2f_indicator varchar(1),
oasis_therapy_patient_diagnosis_2f_sub varchar(2),
oasis_therapy_patient_diagnosis_3f varchar(10),
oasis_therapy_patient_diagnosis_4f varchar(10),
oasis_therapy_patient_diagnosis_1g varchar(10),
oasis_therapy_patient_diagnosis_2g varchar(10),
oasis_therapy_patient_diagnosis_2g_indicator varchar(1),
oasis_therapy_patient_diagnosis_2g_sub varchar(2),
oasis_therapy_patient_diagnosis_3g varchar(10),
oasis_therapy_patient_diagnosis_4g varchar(10),
oasis_therapy_patient_diagnosis_1h varchar(10),
oasis_therapy_patient_diagnosis_2h varchar(10),
oasis_therapy_patient_diagnosis_2h_indicator varchar(1),
oasis_therapy_patient_diagnosis_2h_sub varchar(2),
oasis_therapy_patient_diagnosis_3h varchar(10),
oasis_therapy_patient_diagnosis_4h varchar(10),
oasis_therapy_patient_diagnosis_1i varchar(10),
oasis_therapy_patient_diagnosis_2i varchar(10),
oasis_therapy_patient_diagnosis_2i_indicator varchar(1),
oasis_therapy_patient_diagnosis_2i_sub varchar(2),
oasis_therapy_patient_diagnosis_3i varchar(10),
oasis_therapy_patient_diagnosis_4i varchar(10),
oasis_therapy_patient_diagnosis_1j varchar(10),
oasis_therapy_patient_diagnosis_2j varchar(10),
oasis_therapy_patient_diagnosis_2j_indicator varchar(1),
oasis_therapy_patient_diagnosis_2j_sub varchar(2),
oasis_therapy_patient_diagnosis_3j varchar(10),
oasis_therapy_patient_diagnosis_4j varchar(10),
oasis_therapy_patient_diagnosis_1k varchar(10),
oasis_therapy_patient_diagnosis_2k varchar(10),
oasis_therapy_patient_diagnosis_2k_indicator varchar(1),
oasis_therapy_patient_diagnosis_2k_sub varchar(2),
oasis_therapy_patient_diagnosis_3k varchar(10),
oasis_therapy_patient_diagnosis_4k varchar(10),
oasis_therapy_patient_diagnosis_1l varchar(10),
oasis_therapy_patient_diagnosis_2l varchar(10),
oasis_therapy_patient_diagnosis_2l_indicator varchar(1),
oasis_therapy_patient_diagnosis_2l_sub varchar(2),
oasis_therapy_patient_diagnosis_3l varchar(10),
oasis_therapy_patient_diagnosis_4l varchar(10),
oasis_therapy_patient_diagnosis_1m varchar(10),
oasis_therapy_patient_diagnosis_2m varchar(10),
oasis_therapy_patient_diagnosis_2m_indicator varchar(1),
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
 oasis_additional_notes text,
synergy_id varchar(10)
 ) engine=MyISAM;

INSERT INTO `registry` VALUES ('OASIS SOC/ROC-Nursing', 1, 'oasis_nursing_soc', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');


DROP TABLE IF EXISTS `forms_oasis_pt_soc`;
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
oasis_patient_certification varchar(1),
oasis_patient_date_last_contacted_physician DATE,
oasis_patient_date_last_seen_by_physician DATE,
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
oasis_therapy_patient_diagnosis_2a_indicator varchar(1),
oasis_therapy_patient_diagnosis_2a_sub varchar(2),
oasis_therapy_patient_diagnosis_3a varchar(10),
oasis_therapy_patient_diagnosis_4a varchar(10),
oasis_therapy_patient_diagnosis_1b varchar(10),
oasis_therapy_patient_diagnosis_2b varchar(10),
oasis_therapy_patient_diagnosis_2b_indicator varchar(1),
oasis_therapy_patient_diagnosis_2b_sub varchar(2),
oasis_therapy_patient_diagnosis_3b varchar(10),
oasis_therapy_patient_diagnosis_4b varchar(10),
oasis_therapy_patient_diagnosis_1c varchar(10),
oasis_therapy_patient_diagnosis_2c varchar(10),
oasis_therapy_patient_diagnosis_2c_indicator varchar(1),
oasis_therapy_patient_diagnosis_2c_sub varchar(2),
oasis_therapy_patient_diagnosis_3c varchar(10),
oasis_therapy_patient_diagnosis_4c varchar(10),
oasis_therapy_patient_diagnosis_1d varchar(10),
oasis_therapy_patient_diagnosis_2d varchar(10),
oasis_therapy_patient_diagnosis_2d_indicator varchar(1),
oasis_therapy_patient_diagnosis_2d_sub varchar(2),
oasis_therapy_patient_diagnosis_3d varchar(10),
oasis_therapy_patient_diagnosis_4d varchar(10),
oasis_therapy_patient_diagnosis_1e varchar(10),
oasis_therapy_patient_diagnosis_2e varchar(10),
oasis_therapy_patient_diagnosis_2e_indicator varchar(1),
oasis_therapy_patient_diagnosis_2e_sub varchar(2),
oasis_therapy_patient_diagnosis_3e varchar(10),
oasis_therapy_patient_diagnosis_4e varchar(10),
oasis_therapy_patient_diagnosis_1f varchar(10),
oasis_therapy_patient_diagnosis_2f varchar(10),
oasis_therapy_patient_diagnosis_2f_indicator varchar(1),
oasis_therapy_patient_diagnosis_2f_sub varchar(2),
oasis_therapy_patient_diagnosis_3f varchar(10),
oasis_therapy_patient_diagnosis_4f varchar(10),
oasis_therapy_patient_diagnosis_1g varchar(10),
oasis_therapy_patient_diagnosis_2g varchar(10),
oasis_therapy_patient_diagnosis_2g_indicator varchar(1),
oasis_therapy_patient_diagnosis_2g_sub varchar(2),
oasis_therapy_patient_diagnosis_3g varchar(10),
oasis_therapy_patient_diagnosis_4g varchar(10),
oasis_therapy_patient_diagnosis_1h varchar(10),
oasis_therapy_patient_diagnosis_2h varchar(10),
oasis_therapy_patient_diagnosis_2h_indicator varchar(1),
oasis_therapy_patient_diagnosis_2h_sub varchar(2),
oasis_therapy_patient_diagnosis_3h varchar(10),
oasis_therapy_patient_diagnosis_4h varchar(10),
oasis_therapy_patient_diagnosis_1i varchar(10),
oasis_therapy_patient_diagnosis_2i varchar(10),
oasis_therapy_patient_diagnosis_2i_indicator varchar(1),
oasis_therapy_patient_diagnosis_2i_sub varchar(2),
oasis_therapy_patient_diagnosis_3i varchar(10),
oasis_therapy_patient_diagnosis_4i varchar(10),
oasis_therapy_patient_diagnosis_1j varchar(10),
oasis_therapy_patient_diagnosis_2j varchar(10),
oasis_therapy_patient_diagnosis_2j_indicator varchar(1),
oasis_therapy_patient_diagnosis_2j_sub varchar(2),
oasis_therapy_patient_diagnosis_3j varchar(10),
oasis_therapy_patient_diagnosis_4j varchar(10),
oasis_therapy_patient_diagnosis_1k varchar(10),
oasis_therapy_patient_diagnosis_2k varchar(10),
oasis_therapy_patient_diagnosis_2k_indicator varchar(1),
oasis_therapy_patient_diagnosis_2k_sub varchar(2),
oasis_therapy_patient_diagnosis_3k varchar(10),
oasis_therapy_patient_diagnosis_4k varchar(10),
oasis_therapy_patient_diagnosis_1l varchar(10),
oasis_therapy_patient_diagnosis_2l varchar(10),
oasis_therapy_patient_diagnosis_2l_indicator varchar(1),
oasis_therapy_patient_diagnosis_2l_sub varchar(2),
oasis_therapy_patient_diagnosis_3l varchar(10),
oasis_therapy_patient_diagnosis_4l varchar(10),
oasis_therapy_patient_diagnosis_1m varchar(10),
oasis_therapy_patient_diagnosis_2m varchar(10),
oasis_therapy_patient_diagnosis_2m_indicator varchar(1),
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
oasis_therapy_curr_level_risk_factor_other_deviation TEXT,
synergy_id varchar(10)
) engine=MyISAM;

INSERT INTO `registry` VALUES ('OASIS SOC/ROC-PT', 1, 'oasis_pt_soc', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');


DROP TABLE IF EXISTS `forms_oasis_transfer`;
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
oasistransfer_mental_status varchar(150),
oasistransfer_mental_status_other varchar(100),
oasistransfer_functional_limitations varchar(225),
oasistransfer_functional_limitations_other varchar(100) DEFAULT NULL,
oasistransfer_prognosis varchar(10),
oasistransfer_safety_measures text,
oasistransfer_safety_measures_other varchar(150),
oasistransfer_dme_iv_supplies varchar(225),
oasistransfer_dme_iv_supplies_other varchar(150),
oasistransfer_dme_foley_supplies varchar(225),
oasistransfer_dme_foley_supplies_other varchar(150),


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
oasistransfer_certification varchar(1),
oasistransfer_date_last_contacted_physician DATE,
oasistransfer_date_last_seen_by_physician DATE,
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
oasistransfer_Transmitted_Date date,
synergy_id varchar(10)
) ENGINE=MyISAM;

INSERT INTO `registry` VALUES ('OASIS-C Transfer', 1, 'oasis_transfer', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OASIS', '');


DROP TABLE IF EXISTS `forms_ot_careplan`;
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
duration varchar(255),
Freq_Duration1 varchar(100),
Freq_Duration2 varchar(100),
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

INSERT INTO `registry` VALUES ('OT Care plan', 1, 'careplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');


DROP TABLE IF EXISTS `forms_ot_Evaluation`;
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

INSERT INTO `registry` VALUES ('OT Evaluation', 1, 'evaluation', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');


DROP TABLE IF EXISTS `forms_ot_Reassessment`;
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

INSERT INTO `registry` VALUES ('OT Reassessment', 1, 'reassessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');


DROP TABLE IF EXISTS `forms_ot_visit_discharge_note`;
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

INSERT INTO `registry` VALUES ('OT Visit Discharge', 1, 'visit_discharge_test', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');


DROP TABLE IF EXISTS `forms_ot_visitnote`;
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
visitnote_further_Visit_Required varchar(100),
visitnote_FSVR_Other varchar(255),
visitnote_Date_of_Next_Visit varchar(100),
visitnote_No_further_visits varchar(100),
treatment_Plan varchar(100),
Additional_Treatment varchar(100),
issues_Communication varchar(100),
supervisor_visit varchar(100),
visitnote_Supervisory_visit_Observed varchar(100),
visitnote_Supervisory_visit_Teaching_Training varchar(100),
visitnote_Supervisory_visit_Patient_Family_Discussion varchar(100)
) ENGINE=MyISAM;

INSERT INTO `registry` VALUES ('OT Visit Notes', 1, 'visit_notes', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'OT Forms', '');



DROP TABLE IF EXISTS `forms_pt_careplan`;
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
careplan_Treatment_Plan_Duration varchar(50),
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
careplan_Treatment_Plan_Freq_Duration1 varchar(100),
careplan_Treatment_Plan_Freq_Duration2 varchar(100),
careplan_STO_Others2_Time varchar(50),
careplan_STO_Strength_Time varchar(50),
careplan_Additional_comments varchar(255),
careplan_STO_Other varchar(255),
careplan_STO_Other_Time varchar(50),
careplan_STO_Time varchar(50)
) engine=MyISAM;

INSERT INTO `registry` VALUES ('PT Care plan', 1, 'ptcareplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');


DROP TABLE IF EXISTS `forms_pt_Evaluation`;
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

INSERT INTO `registry` VALUES ('PT Evaluation', 1, 'ptEvaluation', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');


DROP TABLE IF EXISTS `forms_pt_Reassessment`;
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

INSERT INTO `registry` VALUES ('PT Reassessment', 1, 'ptreassessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');



DROP TABLE IF EXISTS `forms_pt_visit_discharge_note`;
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

INSERT INTO `registry` VALUES ('PT Visit Discharge', 1, 'ptvisit_discharge', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');



DROP TABLE IF EXISTS `forms_pt_visitnote`;
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

INSERT INTO `registry` VALUES ('PT Visit Notes', 1, 'ptvisit_notes', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'PT Forms', '');



DROP TABLE IF EXISTS `forms_st_careplan`;
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
careplan_Treatment_Plan_Duration varchar(50),
careplan_Treatment_Plan_EffectiveDate date,
careplan_Treatment_Plan_Freq_Duration1 varchar(50),
careplan_Treatment_Plan_Freq_Duration2 varchar(50),
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

INSERT INTO `registry` VALUES ('ST Care plan', 1, 'stcareplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');



DROP TABLE IF EXISTS `forms_st_Evaluation`;
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

INSERT INTO `registry` VALUES ('ST Evaluation', 1, 'stevaluation', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');



DROP TABLE IF EXISTS `forms_st_Reassessment`;
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

INSERT INTO `registry` VALUES ('ST Reassessment', 1, 'streassessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');


DROP TABLE IF EXISTS `forms_st_visit_discharge_note`;
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

INSERT INTO `registry` VALUES ('ST Visit Discharge', 1, 'stvisit_discharge', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');



DROP TABLE IF EXISTS `forms_st_visitnote`;
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

INSERT INTO `registry` VALUES ('ST Visit Notes', 1, 'stvisit_notes', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'ST Forms', '');



DROP TABLE IF EXISTS `forms_oasis_adult_assessment`;
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

INSERT INTO `registry` VALUES ('ADULT ASSESSMENT', 1, 'oasis_adult_assessment', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');



DROP TABLE IF EXISTS `forms_clinical_summary`;
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

INSERT INTO `registry` VALUES ('Clinical Summary', 1, 'clinical_summary', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');


DROP TABLE IF EXISTS `forms_discharge_summary`;
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

INSERT INTO `registry` VALUES ('General Discharge Summary', 1, 'discharge_summary', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');



DROP TABLE IF EXISTS `forms_home_health_aide`;
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

INSERT INTO `registry` VALUES ('HHA Referral', 1, 'home_health_aide', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');



DROP TABLE IF EXISTS `forms_hha_visit`;
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

INSERT INTO `registry` VALUES ('HHA Visit Note', 1, 'hha_visit', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');



DROP TABLE IF EXISTS `forms_idt_care`;
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

INSERT INTO `registry` VALUES ('IDT-CARE COORDINATION NOTE', 1, 'IDT_care', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');



DROP TABLE IF EXISTS `forms_nursing_careplan`;
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

INSERT INTO `registry` VALUES ('Nursing Careplan', 1, 'nursing_careplan', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');



DROP TABLE IF EXISTS `forms_nursing_visitnote`;
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
  `visitnote_VS_Diagnosis` varchar(100) DEFAULT NULL,
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

INSERT INTO `registry` VALUES ('Nursing Visitnote', 1, 'nursing_visitnote', id=id+1, 1, 1, CURRENT_TIMESTAMP, 0, 'Skilled Nursing', '');

--  Insert Address 2 for Synergy
INSERT INTO layout_options (`form_id`, `field_id`,`group_name`, `title`, `seq`, `data_type`, `uor`, `fld_length`, `max_length`, `list_id`, `titlecols`, `datacols`, `default_value`, `edit_options`, `description`, `fld_rows`) VALUES ( 'DEM', 'street2', '1Patient Info', 'Address 2', 17, 2, 1, 25, 63, '', 1, 1, '', 'C', 'Street and Place', 0);


UPDATE layout_options SET uor=2 WHERE field_id='ss';
UPDATE layout_options SET uor=2 WHERE field_id='postal_code';


