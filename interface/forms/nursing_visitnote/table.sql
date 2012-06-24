-- MySQL dump 10.13  Distrib 5.1.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: emr4
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `forms_nursing_visitnote`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms_nursing_visitnote`
--

LOCK TABLES `forms_nursing_visitnote` WRITE;
/*!40000 ALTER TABLE `forms_nursing_visitnote` DISABLE KEYS */;
/*!40000 ALTER TABLE `forms_nursing_visitnote` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-06-22 18:35:16
