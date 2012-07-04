<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: sixty_day_progress_note");
?>

<html>
<head>
<title><?php xl('SKILLED NURSING CARE PLAN','e')?></title>
<style type="text/css">
.bold {
	font-weight: bold;
}
.padd { padding-left:20px }
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
<form method="post"		action="<?php echo $rootdir;?>/forms/sixty_day_progress_note/save.php?mode=new" name="sixty_day_progress_note">
		<h3 align="center"><?php xl('60 DAY PROGRESS NOTE ','e') ?> &#45; <?php xl('CASE CONFERENCE','e')?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td><b><?php xl('PATIENT NAME','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_patient_name" size="50" value="<?php patientName(); ?>" readonly="readonly"  /></td>
<td><b><?php xl('Certification Period','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_certification_period" size="50" readonly="readonly" /></td>
</tr>
</table>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td><b><?php xl('Dear Dr:','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_dear_dr" value="<?php doctorname(); ?>" size="50" readonly="readonly" size="50" /></td>
</tr>
</table>
</td></tr>

<tr><td>
<b><?php xl('Your patient has been receiving care by the following discipline(s)','e') ?></b>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" value="<?php xl('Skilled Nursing','e') ?>"/><?php xl('Skilled Nursing ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" value="<?php xl('Physical Therapy','e') ?>"/><?php xl('Physical Therapy ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" value="<?php xl('Occupational Therapy','e') ?>"/><?php xl('Occupational Therapy ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" value="<?php xl('Speech therapy','e') ?>"/><?php xl('Speech therapy ', 'e') ?>
</td>
<td>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" value="<?php xl('Home Health Aide','e') ?>"/><?php xl('Home Health Aide ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" value="<?php xl('Medical Social Worker','e') ?>"/><?php xl('Medical Social Worker ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" value="<?php xl('Dietician','e') ?>"/><?php xl('Dietician ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" value="<?php xl('Other','e') ?>"/><?php xl('Other ', 'e') ?>
<input type="text" name="sixty_day_progress_note_patient_receiving_care_other" style="width : 80%">
</td>
</tr>
</table>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td style="width: 42%;"><b><?php xl('DIAGNOSIS ON ADMISSION','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_diagnosis_admission" size="50px"/></td>
</tr>
<tr>
<td><b><?php xl('ADDITIONAL DIAGNOSES OR ISSUES SINCE ADMISSION','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_additional_diagnosis" size="50px"/></td>
</tr>
</table>
</td></tr>

<tr><td>
<b><?php xl('DECLINE/NO CHANGE (NC) IN CLINICAL PROBLEMS (Check all that apply)','e') ?></b><br/>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Decline/NC in Neuro Status','e') ?>"/><?php xl('Decline/NC in Neuro Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Decline/NC in GI Status','e') ?>"/><?php xl('Decline/NC in GI Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Decline/NC in Cardiovascular Status','e') ?>"/><?php xl('Decline/NC in Cardiovascular Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Decline/NC in Respiratory Status','e') ?>"/><?php xl('Decline/NC in Respiratory Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Decline/NC in GU Status','e') ?>"/><?php xl('Decline/NC in GU Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Skin Integrity Alteration','e') ?>"/><?php xl('Skin Integrity Alteration ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Decline/NC in Musculoskeletal Status','e') ?>"/><?php xl('Decline/NC in Musculoskeletal Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Personal Safety Issues','e') ?>"/><?php xl('Personal Safety Issues ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" value="<?php xl('Decline/NC in Functional Skills','e') ?>"/><?php xl('Decline/NC in Functional Skills ', 'e') ?>
<br/><?php xl('Other ','e') ?><input type="text" name="sixty_day_progress_note_decline_clinical_pblm_other" style="width : 80%"/><br/>
<?php xl('Provide Specific Details ','e') ?><input type="text" name="sixty_day_progress_note_decline_clinical_pblm_specific_details" style="width : 73%"/>
</td></tr>

<tr><td>
<b><?php xl('IMPROVEMENT IN CLINICAL ISSUES (Check all that apply)','e') ?></b><br/>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improved in Neuro Status','e') ?>"/><?php xl('Improved in Neuro Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improved in GI Status','e') ?>"/><?php xl('Improved in GI Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improved in Cardiovascular Status','e') ?>"/><?php xl('Improved in Cardiovascular Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improved in Respiratory Status','e') ?>"/><?php xl('Improved in Respiratory Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improved in GU Status','e') ?>"/><?php xl('Improved in GU Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improved in Skin Integrity Alteration','e') ?>"/><?php xl('Improved in Skin Integrity Alteration ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improved in Musculoskeletal Status','e') ?>"/><?php xl('Improved in Musculoskeletal Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improvement in Personal Safety','e') ?>"/><?php xl('Improvement in Personal Safety ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" value="<?php xl('Improvement in Functional Skills','e') ?>"/><?php xl('Improvement in Functional Skills ', 'e') ?>
<br/><?php xl('Other ','e') ?><input type="text" name="sixty_day_progress_note_improvement_issues_other" style="width : 80%"/><br/>
<?php xl('Provide Specific Details ','e') ?><input type="text" name="sixty_day_progress_note_improvement_issues_specific_details" style="width : 73%"/>
</td></tr>

<tr><td>
<b><?php xl('Living Situation: Patient Lives : ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_living_situation_patient_lives" value="<?php xl('Alone','e') ?>"/><?php xl('Alone ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_living_situation_patient_lives" value="<?php xl('With Spouse/Significant','e') ?>"/>
<?php xl('With Spouse/Significant Other ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_living_situation_patient_lives" value="<?php xl('With Family','e') ?>"/><?php xl('With Family ', 'e') ?>
<?php xl(' Who: ','e') ?>
<input type="text" name="sixty_day_progress_note_living_situation_patient_lives_who" style="width : 43%;" /><br/>
<input type="checkbox" name="sixty_day_progress_note_living_situation_patient_lives" value="<?php xl('With Paid Help','e') ?>"/><?php xl('With Paid Help ', 'e') ?>&nbsp; &nbsp; &nbsp;
<?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_living_situation_patient_lives_other" style="width : 72%" /><br/>
<?php xl('Number of Hours Patient is Alone Each Day/Why ','e') ?>
<input type="text" name="sixty_day_progress_note_living_situation_no_hur_day_why" style="width : 63%" />
</td></tr>

<tr><td>
<b><?php xl('Mental Status ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_mental_status" value="<?php xl('Alert','e') ?>"/><?php xl('Alert ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_mental_status" value="<?php xl('Not Alerted','e') ?>"/><?php xl('Not Alerted ', 'e') ?> &nbsp; &nbsp; &nbsp; 
<?php xl('Oriented to','e') ?>
<input type="checkbox" name="sixty_day_progress_note_mental_status_oriented" value="<?php xl('Person','e') ?>"/><?php xl('Person ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_mental_status_oriented" value="<?php xl('Place','e') ?>"/><?php xl('Place ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_mental_status_oriented" value="<?php xl('Date','e') ?>"/><?php xl('Date ', 'e') ?> &nbsp; &nbsp;
<input type="checkbox" name="sixty_day_progress_note_mental_status_disoriented" value="<?php xl('Disoriented','e') ?>"/><?php xl('Disoriented ', 'e') ?><br/>
<b><?php xl('Impaired Mental Status Requires the following resources ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" value="<?php xl('None','e') ?>"/><?php xl('None ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" value="<?php xl('Family/Caregiver Support','e') ?>"/><?php xl('Family/Caregiver Support ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" value="<?php xl('Guardian','e') ?>"/><?php xl('Guardian ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" value="<?php xl('Power of Attorney','e') ?>"/><?php xl('Power of Attorney ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" value="<?php xl('Public Conservator','e') ?>"/><?php xl('Public Conservator ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_impaired_mental_sta_req_resou_other" style="width : 80%" />
</td></tr>

<tr><td>
<b><?php xl('Patient ADL Status: ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" value="<?php xl('Requires Total Assistance','e') ?>"/><?php xl('Requires Total Assistance ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" value="<?php xl('Requires Moderate Assistance','e') ?>"/><?php xl('Requires Moderate Assistance ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" value="<?php xl('Requires Minimal Assistance','e') ?>"/><?php xl('Requires Minimal Assistance ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" value="<?php xl('Requires Supervision Only','e') ?>"/><?php xl('Requires Supervision Only ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" value="<?php xl('Independent','e') ?>"/><?php xl('Independent ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_patient_adl_status_other" style="width : 80%" />
</td></tr>

<tr><td>
<b><?php xl('Ambulatory/Transfer Status: ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" value="<?php xl('Independent in Ambulation','e') ?>"/><?php xl('Independent in Ambulation ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" value="<?php xl('Wheelchair Bound','e') ?>"/><?php xl('Wheelchair Bound ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" value="<?php xl('Bed Bound','e') ?>"/><?php xl('Bed Bound ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" value="<?php xl('Transfers with Minimal Assistance','e') ?>"/><?php xl('Transfers with Minimal Assistance ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" value="<?php xl('Transfers requires two people','e') ?>"/><?php xl('Transfers requires two people ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" value="<?php xl('Uses Assistive Device','e') ?>"/><?php xl('Uses Assistive Device (walker/cane) ', 'e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_ambulatory_transfer_status_other" style="width : 80%" />
</td></tr>

<tr><td>
<b><?php xl('Communication Status: ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_communication_status" value="<?php xl('Good','e') ?>"/><?php xl('Good ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_communication_status" value="<?php xl('Average','e') ?>"/><?php xl('Average ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_communication_status" value="<?php xl('Poor','e') ?>"/><?php xl('Poor ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_communication_status" value="<?php xl('Needs Interpreter','e') ?>"/><?php xl('Needs Interpreter ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_communication_status" value="<?php xl('Non-Verbal','e') ?>"/><?php xl('Non-Verbal ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_communication_status_other" style="width : 80%" />
</td></tr>

<tr><td>
<b><?php xl('Miscellaneous Abilities: ','e') ?></b><b><?php xl(' Hearing ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_hear" value="<?php xl('Average','e') ?>"/><?php xl('Average ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_hear" value="<?php xl('HOH','e') ?>"/><?php xl('HOH ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_hear" value="<?php xl('Wears Hearing Aide','e') ?>"/><?php xl('Wears Hearing Aide ', 'e') ?>
<br/><?php xl(' Other ','e') ?><input type="text" style="width : 80%" name="sixty_day_progress_note_miscellaneous_abis_hear_other" /><br/>
<b><?php xl(' Vision ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_vis" value="<?php xl('Average','e') ?>"/><?php xl('Average ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_vis" value="<?php xl('Poor','e') ?>"/><?php xl('Poor ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_vis" value="<?php xl('Blind','e') ?>"/><?php xl('Blind ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_vis" value="<?php xl('Wearing Glasses','e') ?>"/><?php xl('Wearing Glasses ', 'e') ?>
<br/><?php xl(' Other ','e') ?><input type="text" style="width : 80%" name="sixty_day_progress_note_miscellaneous_abi_hear_vis_other" /><br/>
</td></tr>

<tr><td>
<b><?php xl('Patient Needs Help With ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" value="<?php xl('Obtaining Food','e') ?>"/><?php xl('Obtaining Food ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" value="<?php xl('Obtaining Medication','e') ?>"/><?php xl('Obtaining Medication ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" value="<?php xl('Preparing Meals','e') ?>"/><?php xl('Preparing Meals ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" value="<?php xl('Managing Finances','e') ?>"/><?php xl('Managing Finances ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" value="<?php xl('Transportation for medical care','e') ?>"/><?php xl('Transportation for medical care ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" style="width : 80%" name="sixty_day_progress_note_patient_needs_help_with_other" />
</td></tr>

<tr><td>
<b><?php xl('ADDITIONAL INFORMATION','e') ?><br/>
<textarea name="sixty_day_progress_note_additional_information" rows="3" cols="100"></textarea>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr><td style="width : 50%"><b><?php xl('Clinician Name/Title Completing Note','e') ?></td>
<td atyle="width : 50%"></td></tr>
</table>
</td></tr>

</table>
<a href="javascript:top.restoreSession();document.sixty_day_progress_note.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
