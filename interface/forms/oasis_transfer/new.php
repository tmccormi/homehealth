<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: oasis_transfer");
?>

<html>
<head>
<title>OASIS-C TRANSFER</title>
<style type="text/css">
.bold {
	font-weight: bold;
}
</style>
<style type="text/css">
@import url(<?php echo $GLOBALS['webroot']?>/library/dynarch_calendar.css);</style>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
</head>

<body>
<form method="post"	action="<?php echo $rootdir;?>/forms/oasis_transfer/save.php?mode=new" name="oasistransfer">
		<h3 align="center"><?php xl('OASIS-C TRANSFER','e')?></h3>	
		
<div><span class="formtable"><strong><?php xl('Patient:','e')?></strong>&nbsp;&nbsp;<label><?php patientName()?></label> </span>
<span class="formtable" style="float:right"><strong><?php xl('Caregiver:','e')?></strong> <input type="text" name="oasistransfer_Caregiver" size="20"/> &nbsp;&nbsp;
<strong class="formtable"><?php xl('Visit Date:','e')?></strong>
&nbsp;<input type="text" name="oasistransfer_Visit_Date" value="<?php VisitDate(); ?>" readonly/>
   </span></div>
<br/>
<div align="right" class="formtable"> <?php xl('Time In:','e')?>
<select name="oasistransfer_Time_In" id="oasistransfer_Time_In"><?php timeDropDown('new') ?></select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Time Out:','e')?>
<select name="oasistransfer_Time_Out" id="oasistransfer_Time_Out"><?php timeDropDown('new') ?></select>
</div>
<br/>
<table border="1px" class="formtable">
<tr>
<td width="50%" valign="top">
<table class="formtable">
<tr> <td><center><b><?php xl('CLINICAL RECORD ITEMS','e')?></b></center></td> </tr>
<tr><td><hr/></td></tr>
<tr><td><b><u><?php xl('(M0080)','e')?></u><?php xl('Discipline of Person Completing Assessment','e')?></b></td></tr>
<tr><td> <input type="radio" name="oasistransfer_Discipline_of_Person_completing_Assessment" value="RN"><?php xl('1-RN','e')?>  &nbsp;&nbsp;&nbsp;
 <input type="radio" name="oasistransfer_Discipline_of_Person_completing_Assessment" value="PT"><?php xl('2-PT','e')?>  &nbsp;&nbsp;&nbsp;
 <input type="radio" name="oasistransfer_Discipline_of_Person_completing_Assessment" value="SLP/ST"><?php xl('3-SLP/ST','e')?>  &nbsp;&nbsp;&nbsp;
<input type="radio" name="oasistransfer_Discipline_of_Person_completing_Assessment" value="OT"><?php xl('4-OT','e')?> </td> 
</tr>
<tr><td><hr></td></tr>
<tr>
<td><b><u><?php xl('(M0090)','e')?></u> <?php xl('Date Assessment Completed','e')?> </b>

<input type="text" name="oasistransfer_Assessment_Completed_Date" size="10" title='<?php xl('yyyy-mm-dd Assessment Completed Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Assessment_Completed_Date" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_Assess_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Assessment_Completed_Date", ifFormat:"%Y-%m-%d", button:"img_Assess_date"});
   </script>
	 </td>
</tr>
<tr><td><hr></td></tr>
<tr>
<td><b><?php xl('(M0100)This Assessment is Currently Being Completed for the Following Reason:','e')?> </b></td>
</tr>
<tr><td><b><u><?php xl('Transfer to an Inpatient Facility','e');?></u></b></td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Transfer_to_an_InPatient_Facility" value="Patient_Not_Discharged_from_Agency">
<?php xl('6-Transfered to an InPatient Facility-patient not discharged from agency','e')?> <b><?php xl('[Go To M1040]','e')?></b><br/>
<input type="radio" name="oasistransfer_Transfer_to_an_InPatient_Facility" value="Patient_Discharged_from_Agency">
<?php xl('7-Transfered to an InPatient Facility-patient discharged from agency','e')?> <b><?php xl('[Go To M1040]','e')?></b><br/>
<input type="radio" name="oasistransfer_Transfer_to_an_InPatient_Facility" value="Death_at_Home">
<?php xl('8-Death at Home','e')?> <b><?php xl('[Go To M0903]','e')?></b>
</td></tr>
<tr><td><hr></td></tr>

<tr><td><center><b><?php xl('PATIENT HISTORY AND DIAGNOSES','e')?></b></center></td></tr>
<tr><td><b><u><?php xl('(M1040)','e')?></u> 
<?php xl("Influenza Vaccine:",'e')?></b> <?php xl("Did the patient receive the influenza vaccine from your agency for this 
year's influenza season (October 1 through March 31) during this episode of care?",'e')?></td></tr>
<tr><td> <input type="radio" name="oasistransfer_Influenza_Vaccine_received" value="No"/>
<?php xl('0 - No','e')?> <br/>
<input type="radio" name="oasistransfer_Influenza_Vaccine_received" value="Yes"/>
<?php xl('1 - Yes','e')?> <b>
<?php xl('[ Go to M1050 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Influenza_Vaccine_received" value="NA"/>
<?php xl('2 - NA - Does not apply because entire episode of care (SOC/ROC to
Transfer/Discharge) is outside this influenza season.','e')?><b><?php xl('[ Go to M1050 ]','e')?></b>
</td></tr>

<tr><td><hr/></td></tr>

<tr><td><b><?php xl('(M1045) Reason Influenza Vaccine not received:','e')?></b><?php xl('If the patient did not receive the
influenza vaccine from your agency during this episode of care, state reason:','e')?>
</td></tr>

<tr><td>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Received_from_another_health_care_provider"/>
<?php xl('1 - Received from another health care provider (e.g., physician)','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Received_from_your_agency_previuosly"/>
<?php xl("2 - Received from your agency previously during this year's flu season",'e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Offered_and_Declined"/>
<?php xl('3 - Offered and declined','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Assessed_and_determined"/>
<?php xl('4 - Assessed and determined to have medical contraindication(s)','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Not_indicated"/>
<?php xl('5 - Not indicated; patient does not meet age/condition guidelines for influenza vaccine','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Inability_to_Obtain_Vaccine"/>
<?php xl('6 - Inability to obtain vaccine due to declared shortage','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="None"/>
<?php xl('7 - None of the above','e')?><br/>
</td></tr>
<tr><td><hr/></td></tr>
<tr><td>
<b><u><?php xl('(M1050)','e')?></u><?php xl('Pneumococcal Vaccine:','e')?></b><?php xl('Did the patient receive pneumococcal polysaccharide
vaccine (PPV) from your agency during this episode of care (SOC/ROC to
Transfer/Discharge)?','e')?><br/>
<input type="radio" name="oasistransfer_Pneumococcal_Vaccine_Recieved" value="No"/>
<?php xl('0 - No','e')?><br/>
<input type="radio" name="oasistransfer_Pneumococcal_Vaccine_Recieved" value="Yes"/>
<?php xl('1 - Yes','e')?><b>
<?php xl(' [ Go to M1500 at TRN; Go to M1230 at DC ]','e')?></b>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td><center><b><?php xl('EMERGENT CARE','e')?></b></center></td></tr>

<tr><td><hr/></td></tr>
<tr><td><b><u><?php xl('(M2300)','e')?></u><?php xl('Emergent Care:','e')?></b><?php xl('Since the last time OASIS data were collected, has the patient
utilized a hospital emergency department (includes holding/observation)?','e')?> </td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Used_Emergent_Care" value="No"/>
<?php xl('0 - No','e')?><b><?php xl('[ Go to M2400 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Used_Emergent_Care" value="Yes_Without_Hospital_Administration"/>
<?php xl('1 - Yes, used hospital emergency department WITHOUT hospital admission','e')?><br/>
<input type="radio" name="oasistransfer_Used_Emergent_Care" value="Yes_With_Hospital_Administration"/>
<?php xl('2 - Yes, used hospital emergency department WITH hospital admission','e')?><br/>
<input type="radio" name="oasistransfer_Used_Emergent_Care" value="Unknown"/>
<?php xl('UK - Unknown','e')?><b><?php xl('[ Go to M2400 ]','e')?> </b>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr></td></tr>
<tr><td><b><u><?php xl('(M2310)','e')?></u><?php xl('Reason for Emergent Care:','e')?></b><?php xl('For what reason(s) did the patient receive
emergent care (with or without hospitalization)?','e')?> <b><?php xl('(Mark all that apply.)','e')?> </b>
</td></tr>
<tr><td>
<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Improper_medication">
<?php xl('1 - Improper medication administration, medication side effects, toxicity,anaphylaxis','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Injury_caused_by_fall">
<?php xl('2 - Injury caused by fall','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Respiratory_infection">
<?php xl('3 - Respiratory infection (e.g., pneumonia, bronchitis)','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Other_respiratory_problem">
<?php xl('4 - Other respiratory problem','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Heart_failure">
<?php xl('5 - Heart failure (e.g., fluid overload)','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Cardiac_dysrhythmia">
<?php xl('6 - Cardiac dysrhythmia (irregular heartbeat)','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Chest_Pain">
<?php xl('7 - Myocardial infarction or chest pain','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Other_heart_disease">
<?php xl('8 - Other heart disease','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Stroke_or_TIA">
<?php xl('9 - Stroke (CVA) or TIA','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Hypo_Hyperglycemia">
<?php xl('10 - Hypo/Hyperglycemia, diabetes out of control','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_GI_bleeding">
<?php xl('11 - GI bleeding, obstruction, constipation, impaction','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Dehydration_malnutrition">
<?php xl('12 - Dehydration, malnutrition','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Urinary_tract_infection">
<?php xl('13 - Urinary tract infection','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_IV_catheter_Complication">
<?php xl('14 - IV catheter-related infection or complication','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Wound_infection">
<?php xl('15 - Wound infection or deterioration','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Uncontrolled_pain">
<?php xl('16 - Uncontrolled pain','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Acute_health_problem">
<?php xl('17 - Acute mental/behavioral health problem','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Deep_vein_thrombosis">
<?php xl('18 - Deep vein thrombosis, pulmonary embolus','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Other_Reason">
<?php xl('19 - Other than above reasons','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Reason_unknown">
<?php xl('UK - Reason unknown','e')?><br/>
</td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td><center><b><?php xl('INPATIENT FACILITY ADMISSION','e')?></b></center></td></tr>

<tr><td>
<table border="1px" class="formtable">
<tr><td colspan="6"><b><u><?php xl('(M2400)','e')?></u><?php xl('Intervention Synopsis:','e')?></b>
<?php xl('(Check only','e')?><b><u><?php xl('one','e')?></u></b> <?php xl('box in each row.) Since the  the 
previous OASIS assessment, were the following interventions BOTH included in the
physician-ordered plan of care AND implemented?','e')?>
</td></tr>

<tr><td colspan="2"><center><b><?php xl('Plan/Intervention','e')?></b></center></td>
<td><b><?php xl('No','e')?></b></td><td><b><?php xl('Yes','e')?></b></td>
<td colspan="2"><center><b><?php xl('Not Applicable','e')?></b></center></td></tr>

<tr><td valign="top"><?php xl('a','e')?></td><td valign="top"><?php xl('Diabetic foot care including monitoring for the presence of skin lesions on the lower
extremities and patient/caregiver education on proper foot care','e')?></td><td>
<input type="radio" name="oasistransfer_Diabetic_foot_care" value="No"/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Diabetic_foot_care" value="Yes"/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Diabetic_foot_care" value="NA"/><center><?php xl('na','e')?></center></td>
<td valign="top"><?php xl('Patient is not diabetic or is bilateral amputee','e')?></td></tr>

<tr><td valign="top"><?php xl('b','e')?></td><td valign="top"><?php xl('Falls prevention interventions','e')?></td><td>
<input type="radio" name="oasistransfer_Falls_prevention_Intervention" value="No"/> <center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Falls_prevention_Intervention" value="Yes"/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Falls_prevention_Intervention" value="na"/><center><?php xl('na','e')?></center></td>
<td><?php xl('Formal multi-factor Fall Risk Assessment indicates the patient was not at risk for falls since the last OASIS assessment','e')?></td></tr>

<tr><td valign="top"><?php xl('c','e')?></td><td valign="top"><?php xl('Depression intervention(s) such as medication, referral for other treatment, or a
monitoring plan for current treatment','e')?></td><td>
<input type="radio" name="oasistransfer_Depression_intervention" value="No"/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Depression_intervention" value="Yes"/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Depression_intervention" value="na"/><center><?php xl('na','e')?></center></td>
<td><?php xl('Formal assessment indicates patient did not meet criteria for depression AND patient did not have diagnosis of
depression since the last OASIS assessment','e')?></td></tr>

<tr><td valign="top"><?php xl('d','e')?></td><td valign="top"><?php xl('Intervention(s) to monitor and mitigate pain','e')?></td>
<td>
<input type="radio" name="oasistransfer_Intervention_to_monitor_pain" value="No"/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Intervention_to_monitor_pain" value="Yes"/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Intervention_to_monitor_pain" value="na"/><center><?php xl('na','e')?></center></td>
<td><?php xl('Formal assessment did not indicate pain since the last OASIS assessment','e')?></td>
</tr>

<tr><td valign="top"><?php xl('e','e')?></td><td valign="top"><?php xl('Intervention(s) to prevent pressure ulcers','e')?></td>
<td>
<input type="radio" name="oasistransfer_Intervention_to_prevent_pressure_ulcers" value="No"/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Intervention_to_prevent_pressure_ulcers" value="Yes"/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Intervention_to_prevent_pressure_ulcers" value="na"/><center><?php xl('na','e')?></center></td>
<td><?php xl('Formal assessment indicates the patient was not at risk of pressure ulcers since the last OASIS assessment','e')?></td>
</tr>


<tr><td valign="top"><?php xl('f','e')?></td><td valign="top"><?php xl('Pressure ulcer treatment based on principles of moist wound healing','e')?></td>
<td>
<input type="radio" name="oasistransfer_Pressure_ulcer_treatment" value="No"/> <center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Pressure_ulcer_treatment" value="Yes"/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Pressure_ulcer_treatment" value="na"/><center><?php xl('na','e')?></center></td>
<td><?php xl("Dressings that support the principles of moist wound healing not indicated for this patient's pressure ulcers OR
patient has no pressure ulcers with need for moist wound healing",'e')?></td></tr>
</table></td></tr>
</table></td>


<td width="50%" valign="top">
<table class="formtable">
<tr><td><center><b><?php xl('PATIENT HISTORY AND DIAGNOSES (CONT.)','e')?></b></center></td></tr>
<tr><td><hr/></td></tr>
<tr><td><b><u><?php xl('(M1055)','e')?></u><?php xl('Reason PPV not received:','e')?></b><?php xl('If patient did not receive the pneumococcal
polysaccharide vaccine (PPV) from your agency during this episode of care (SOC/ROC to
Transfer/Discharge), state reason:','e')?></td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="Received_in_the_past"/>
<?php xl('1 - Patient has received PPV in the past','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="Offered_and_declined"/>
<?php xl('2 - Offered and declined','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="Assessed_and_determined"/>
<?php xl('3 - Assessed and determined to have medical contraindication(s)','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="Not_indicated"/>
<?php xl('4 - Not indicated; patient does not meet age/condition guidelines for PPV','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="None"/>
<?php xl('5 - None of the above','e')?>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td><center><b><?php xl('CARDIAC STATUS','e')?></b></center></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><b><u><?php xl('(M1500)','e')?></u><?php xl('Symptoms in Heart Failure Patients:','e')?></b><?php xl('If patient has been diagnosed with
heart failure, did the patient exhibit symptoms indicated by clinical heart failure guidelines (including dyspnea, orthopnea, edema, 
or weight gain) at any point since the previous OASIS assessment?','e')?></td></tr>
<tr><td> 
<input type="radio" name="oasistransfer_Cardiac_Status" value="patient_didnot_Exhibit_Symptoms"/>
<?php xl('0 - No','e')?>&nbsp;<b><?php xl('[ Go to M2004 at TRN; Go to M1600 at DC ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Cardiac_Status" value="patient_Exhibited_Symptoms"/>
<?php xl('1-Yes','e')?><br/>
<input type="radio" name="oasistransfer_Cardiac_Status" value="Not_Assessed"/>
<?php xl('2 - Not assessed','e')?>&nbsp;<b><?php xl('[Go to M2004 at TRN; Go to M1600 at DC ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Cardiac_Status" value="NA"/>
<?php xl('NA - Patient does not have diagnosis of heart failure','e')?>&nbsp;<b><?php xl('[Go to M2004 at TRN; Go
to M1600 at DC ]','e')?></b>
</td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>

<tr><td><b><u><?php xl('(M1510)','e')?></u><?php xl('Heart Failure Follow-up:','e')?></b><?php xl('If patient has been diagnosed with heart failure and has exhibited symptoms indicative 
of heart failure since the previous OASIS assessment,what action(s) has (have) been taken to respond? <strong>(Mark all that apply.</strong>)','e')?>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_no_Action">
<?php xl('0 - No action taken','e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_patient_Contacted">
<?php xl("1 -Patient's physician (or other primary care practitioner) contacted the same day",'e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_Emergency_Treatment">
<?php xl('2 - Patient advised to get emergency treatment (e.g., call 911 or go to emergency room)','e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_Implemented_treatment">
<?php xl('3 - Implemented physician-ordered patient-specific established parameters for
treatment','e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_Patient_Education">
<?php xl('4 - Patient education or other clinical interventions','e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_change_in_carePlan_orders">
<?php xl('5 - Obtained change in care plan orders (e.g., increased monitoring by agency,
change in visit frequency, telehealth, etc.)','e')?><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>

<tr><td><center><b><?php xl('MEDICATIONS','e')?></b></center></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><b><u><?php xl('(M2004)','e')?></u><?php xl('Medication Intervention:','e')?> </b><?php xl('If there were any clinically significant medication issues since the previous OASIS 
assessment, was a physician or the physician-designee contacted within one calendar day of the assessment to resolve clinically significant
medication issues, including reconciliation?','e')?>
</td></tr>

<tr><td>
<input type="radio" name="oasistransfer_Medication_Intervention" value="reconcillation_NotDone"/>
<?php xl('0 - No','e')?><br/>
<input type="radio" name="oasistransfer_Medication_Intervention" value="reconcillation_Done"/>
<?php xl('1 - Yes','e')?><br/>
<input type="radio" name="oasistransfer_Medication_Intervention" value="reconcillation_NA"/>
<?php xl('NA - No clinically significant medication issues identified since the previous OASIS
assessment','e')?><br/>
</td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td>
<b><u><?php xl('(M2015)','e')?></u><?php xl('Patient/Caregiver Drug Education Intervention:','e')?></b><?php xl('Since the previous OASIS assessment, was the patient/caregiver 
instructed by agency staff or other health care provider to monitor the effectiveness of drug therapy, drug reactions, and side effects,
 and how and when to report problems that may occur?','e')?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Drug_Education_Intervention" value="patient_not_instructed"/>
<?php xl('0 - No','e')?><br/>
<input type="radio" name="oasistransfer_Drug_Education_Intervention" value="patient_instructed"/>
<?php xl('1 - Yes','e')?><br/>
<input type="radio" name="oasistransfer_Drug_Education_Intervention" value="NA"/>
<?php xl('NA -  Patient not taking any drugs','e')?><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>

<tr><td>
<b><u><?php xl('(M2410)','e')?></u></b>&nbsp;<?php xl('To which','e')?><b>&nbsp;<?php xl('Inpatient Facility','e')?></b>&nbsp;<?php xl('has the patient been admitted?','e')?>
</td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="Hospital"/>
<?php xl('1 - Hospital','e')?> &nbsp;<b><?php xl('[ Go to M2430 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="Rehabilitation_Facility"/>
<?php xl('2 - Rehabilitation facility','e')?> &nbsp;<b><?php xl('[ Go to M0903 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="Nursing_home"/>
<?php xl('3 - Nursing home','e')?> &nbsp;<b><?php xl('[ Go to M2440 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="Hospice"/>
<?php xl('4 - Hospice','e')?> &nbsp;<b><?php xl('[ Go to M0903 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="NA"/>
<?php xl('NA - No inpatient facility admission [Omit "NA" option on TRN]','e')?><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td>
<b><u><?php xl('(M2430)','e')?></u>&nbsp;<?php xl('Reason for Hospitalization:','e')?></b>&nbsp;<?php xl('For what reason(s) did the patient require
hospitalization?','e')?> <b><?php xl(' (Mark all that apply.)','e')?></b>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<input type="checkbox" name="oasistransfer_Hospitalized_for_Improper_medication">
<?php xl('1 - Improper medication administration, medication side effects, toxicity,anaphylaxis','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Injury_caused_by_fall">
<?php xl('2 - Injury caused by fall','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Respiratory_infection">
<?php xl('3 - Respiratory infection (e.g., pneumonia, bronchitis)','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Other_respiratory_problem">
<?php xl('4 - Other respiratory problem','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Heart_failure">
<?php xl('5 - Heart failure (e.g., fluid overload)','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Cardiac_dysrhythmia">
<?php xl('6 - Cardiac dysrhythmia (irregular heartbeat)','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Chest_Pain">
<?php xl('7 - Myocardial infarction or chest pain','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Other_heart_disease">
<?php xl('8 - Other heart disease','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Stroke_or_TIA">
<?php xl('9 - Stroke (CVA) or TIA','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Hypo_Hyperglycemia">
<?php xl('10 - Hypo/Hyperglycemia, diabetes out of control','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_GI_bleeding">
<?php xl('11 - GI bleeding, obstruction, constipation, impaction','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Dehydration_malnutrition">
<?php xl('12 - Dehydration, malnutrition','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Urinary_tract_infection">
<?php xl('13 - Urinary tract infection','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_IV_catheter_related_infection">
<?php xl('14 - IV catheter-related infection or complication','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Wound_infection">
<?php xl('15 - Wound infection or deterioration','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Uncontrolled_pain">
<?php xl('16 - Uncontrolled pain','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Acute_health_problem">
<?php xl('17 - Acute mental/behavioral health problem','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Deep_vein_thrombosis">
<?php xl('18 - Deep vein thrombosis, pulmonary embolus','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_scheduled_Treatment">
<?php xl('19 - Scheduled treatment or procedure','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Other_Reason">
<?php xl('20 - Other than above reasons','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Reason_unknown">
<?php xl('UK - Reason unknown','e')?><b> <?php xl('[ Go to M0903 ]','e')?></b><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td>
<b><u><?php xl('(M2440)','e')?></u></b>&nbsp;<?php xl('For what','e')?>&nbsp;<b><?php xl('Reason(s)','e')?></b>&nbsp;
<?php xl('was the patient','e')?>&nbsp;<b><?php xl('Admitted','e')?></b> <?php xl('to a','e')?>
&nbsp;<b><?php xl('Nursing Home? (Mark all that apply.)','e')?></b>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Theraphy_Services">
<?php xl('1 - Therapy services','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Respite_care">
<?php xl('2 - Respite care','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Hospice_care">
<?php xl('3 - Hospice care','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Permanent_placement">
<?php xl('4 - Permanent placement','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_as_Unsafe_at_home">
<?php xl('5 - Unsafe for care at home','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Other_Reason">
<?php xl('6 - Other','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason">
<?php xl('UK - Unknown','e')?><b><?php xl('[ Go to M0903 ]','e')?></b><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>

<tr><td><b><?php xl('(M0903) Date of Last (Most Recent) Home Visit:','e')?> </b>
<input type="text" name="oasistransfer_Last_Home_Visit_Date" size="10" title='<?php xl('yyyy-mm-dd Last home Visit Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Last_Home_Visit_Date" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_home_visit_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Last_Home_Visit_Date", ifFormat:"%Y-%m-%d", button:"img_home_visit_date"});
   </script>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td><b><?php xl('(M0906) Discharge/Transfer/Death Date:','e')?></b>&nbsp;
 <?php xl('Enter the date of the discharge, transfer, or death (at home) of the patient','e')?><br/>
<input type="text" name="oasistransfer_Discharge_Transfer_Death_Date" size="10" title='<?php xl('yyyy-mm-dd Discharge/Transfer/Death Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Discharge_Transfer_Death_Date" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_discharge_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Discharge_Transfer_Death_Date", ifFormat:"%Y-%m-%d", button:"img_discharge_date"});
   </script>

</td></tr>
</table></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>


<tr><td colspan="2">

<table border="0px">
<tr><td align="center" colspan="2" class="formtable"><b><?php xl('SUPPLEMENTAL INFORMATION','e')?></b></td></tr>
<tr><td colspan="2"><hr/></td></tr>
<tr><td colspan="2" class="formtable"><b><?php xl('DISCIPLINES INVOLVED:','e')?></b></td></tr>
<tr><td colspan="2">
<input type="checkbox" name="oasistransfer_Disciplined_Involved_SN"><?php xl('SN','e')?> &nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_PT"><?php xl('PT','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_OT"><?php xl('OT','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_ST"><?php xl('ST','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_MSW"><?php xl('MSW','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_CHHA"><?php xl('CHHA','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_Other"><?php xl('Other','e')?>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2" class="formtable">
<b><?php xl('PHYSICIAN NOTIFIED:','e')?></b>
<input type="radio" name="oasistransfer_Physician_notified" value="Yes"/><?php xl('Yes','e')?>
<input type="radio" name="oasistransfer_Physician_notified" value="No"/><?php xl('No','e')?>
</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2" class="formtable"><b><?php xl('REASON FOR ADMISSION / SUMMARY:','e')?></b></td></tr>
<tr><td colspan="2" class="formtable"><textarea name="oasistransfer_Reason_For_Admission" rows="10" cols="80"></textarea> </td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable"><b><?php xl('EMERGENT CARE / HOSPITALIZATION / FACILITY INFORMATION:','e')?></b></td></tr>
<tr><td colspan="2" class="formtable"><textarea name="oasistransfer_EmergentCare_Hospitalization_Information" rows="10" cols="80"></textarea> </td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable"><b><?php xl('Does Patient Have an Advance Directive?','e')?></b>
<input type="radio" name="oasistransfer_Patient_Have_Advance_Directive" value="Yes"/><?php xl('Yes','e')?>
<input type="radio" name="oasistransfer_Patient_Have_Advance_Directive" value="No"/><?php xl('No','e')?>
</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable"><b><?php xl('Attachments:','e')?></b></td></tr>

<tr><td colspan="2" class="formtable"> <input type="checkbox" name="oasistransfer_List_Of_Medications_Attached"><?php xl('List of Medications','e')?> </td></tr>
<tr><td colspan="2" class="formtable"> <input type="checkbox" name="oasistransfer_Plan_Of_Care_Attached"><?php xl('Plan of Care','e')?> </td></tr>
<tr><td colspan="2" class="formtable"> <input type="checkbox" name="oasistransfer_Advance_Directive_Attached"><?php xl('Advance Directive','e')?> </td></tr>
<tr><td colspan="2" class="formtable"> <input type="checkbox" name="oasistransfer_DNR_Attached"><?php xl('DNR','e')?> </td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable"><b><?php xl('Copies sent to:','e')?></b></td></tr>
<tr><td colspan="2" class="formtable"> <input type="checkbox" name="oasistransfer_Copies_Sent_To_Physician"><?php xl('Physician','e')?> </td></tr>
<tr><td colspan="2" class="formtable"> <input type="checkbox" name="oasistransfer_Copies_Sent_To_Facility"><?php xl('Facility','e')?> </td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable"><?php xl('Name','e')?>&nbsp;&nbsp;
<input type="text" name="oasistransfer_name" size="15"/></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2" class="formtable"><center><b><?php xl('OASIS INFORMATION','e')?></b></center></td></tr>

<tr><td colspan="2">
<span style="float:left;">
<b class="formtable" ><?php xl('Date Reviewed','e')?></b> 
<input type="text" class="formtable"  name="oasistransfer_Reviewed_Date" size="10" title='<?php xl('yyyy-mm-dd Reviewed Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Reviewed_Date" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_Reviewed_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Reviewed_Date", ifFormat:"%Y-%m-%d", button:"img_Reviewed_date"});
   </script>
   </span>
   
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <b class="formtable" ><?php xl('Date Entered and Locked','e')?></b> 
<input type="text" name="oasistransfer_Entered_Date" class="formtable"  size="10" title='<?php xl('yyyy-mm-dd Entered Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Entered_Date" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_Entered_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Entered_Date", ifFormat:"%Y-%m-%d", button:"img_Entered_date"});
   </script>
  
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span style="float:right;">
   <b class="formtable" ><?php xl('Date Transmitted','e')?></b> 
<input type="text" name="oasistransfer_Transmitted_Date" size="10" class="formtable" title='<?php xl('yyyy-mm-dd Transmitted Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Transmitted_Date" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_Transmitted_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Transmitted_Date", ifFormat:"%Y-%m-%d", button:"img_Transmitted_date"});
   </script>
   </span>
   </td></tr>

</table>


</td></tr>


</table>

<a href="javascript:top.restoreSession();document.oasistransfer.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>
</body>
</html>
