<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: msw_careplan");
?>

<html>
<head>
<title>MSW Care Plan</title>
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
<form method="post"
		action="<?php echo $rootdir;?>/forms/msw_careplan/save.php?mode=new" name="msw_careplan">
		<h3 align="center"><?php xl('MEDICAL SOCIAL WORKER CARE PLAN','e')?></h3>		
		<h5 align="center">
		<?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
		</h5>
		


<table width="100%" border="1px" class="formtable">
	<tr>
		<td colspan="4">
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td><?php xl('Patient Name','e');?></td>
				<td width="50%"><input type="text" name="" style="width:100%" value="<?php patientName()?>" readonly ></td>
				
<td><?php xl('Start of Care Date','e');?></td>
<td width="17%" align="center" valign="top" class="bold">
<input type='text' size='12' name='SOC_date' id='SOC_date' title='<?php xl('Start of Care Date','e'); ?>'	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php VisitDate(); ?>' readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date' border='0' alt='[?]'	style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"SOC_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
</script>
<?php } else {echo '';} ?>
</td>

</tr>
		</table>
	</tr>
	<tr>
		<td colspan="4">
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td><strong><?php xl('Problem/Reason for Referral','e');?></strong></td>
				<td width="100%"><input type="text" name="problem_reason_for_referel" style="width:90%;" value=""></td>
			</tr>
		</table>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Spouse/Significant Others','e');?></strong></td>
	</tr>
	<tr>
		<td><strong><?php xl('Name</strong>','e');?></td>
		<td><strong><?php xl('Relationship','e');?></strong></td>
		<td><strong><?php xl('Address','e');?></strong></td>
		<td><strong><?php xl('Phone','e');?></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="spouse_significant_others_row1[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row1[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row1[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row1[]" style="width:90%"></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="spouse_significant_others_row2[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row2[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row2[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row2[]" style="width:90%"></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="spouse_significant_others_row3[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row3[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row3[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row3[]" style="width:90%"></strong></td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Caregiver(s) (if different from above)','e');?></strong></td>
	</tr>
	<tr>
		<td><strong><?php xl('Name','e');?></strong></td>
		<td><strong><?php xl('Relationship','e');?></strong></td>
		<td><strong><?php xl('Address','e');?></strong></td>
		<td><strong><?php xl('Phone','e');?></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="caregivers_row1[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="caregivers_row1[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="caregivers_row1[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="caregivers_row1[]" style="width:90%"></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="caregivers_row2[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="caregivers_row2[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="caregivers_row2[]" style="width:90%"></strong></td>
		<td><strong><input type="text" name="caregivers_row2[]" style="width:90%"></strong></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><strong><?php xl('SOCIAL, ENVIRONMENTAL, FINANCIAL FACTORS THAT IMPACT PATIENT\'S ILLNESS AND REQUIRE INTERVENTIONS','e');?></strong></td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Living Situation: Patient Lives: ','e');?></strong>
			<label><input type="checkbox" name="patient_lives" value="<?php xl('Alone','e');?>"><?php xl('Alone','e');?></label>
			<label><input type="checkbox" name="patient_lives" value="<?php xl('With Spouse/Significant Other','e');?>"><?php xl('With Spouse/Significant Other','e');?></label>
			<label><input type="checkbox" name="patient_lives" value="<?php xl('With Family','e');?>"><?php xl('With Family','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php xl('Who:','e');?><input type="text" name="patient_lives_with_who" size="20" value=""></label><br>
			<label><input type="checkbox" name="patient_lives" value="<?php xl('With Paid Help','e');?>"><?php xl('With Paid Help','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="patient_lives_other" style="width:80%" value=""></label><br>
			<label><?php xl('Number of Hours Patient is Alone Each Day/Why ','e');?><input type="text" name="no_of_hours_patient_alone" style="width:40%" value=""></label><br>
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Type of Housing: ','e');?></strong>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('House','e');?>"><?php xl('House','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Apartment','e');?>"><?php xl('Apartment','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Mobile Home','e');?>"><?php xl('Mobile Home','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Retirement Community','e');?>"><?php xl('Retirement Community','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Assisted Living Facility','e');?>"><?php xl('Assisted Living Facility','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Board and Care','e');?>"><?php xl('Board and Care','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Public Housing','e');?>"><?php xl('Public Housing','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Subsidized Housing','e');?>"><?php xl('Subsidized Housing','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Group Home','e');?>"><?php xl('Group Home','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Homeless','e');?>"><?php xl('Homeless','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="type_of_housing_other" style="width:80%" value=""></label><br>
			<strong><?php xl('Condition of Housing: ','e');?></strong>
			<label><input type="checkbox" name="condition_of_housing" value="<?php xl('Adequate','e');?>"><?php xl('Adequate','e');?></label>
			<label><input type="checkbox" name="condition_of_housing" value="<?php xl('Inadequate','e');?>"><?php xl('Inadequate','e');?></label><br>
			<?php xl('Describe Problems/Safety Issues ','e');?><input type="text" name="problem_safety_issues" style="width:70%" value=""></label><br>
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Mental Status: ','e');?></strong>
			<label><input type="checkbox" name="mental_status" value="<?php xl('Alert','e');?>"><?php xl('Alert','e');?></label>
			<label><input type="checkbox" name="mental_status" value="<?php xl('Not Alerted','e');?>"><?php xl('Not Alerted','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<?php xl('Oriented to: ','e');?>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Person','e');?>"><?php xl('Person','e');?></label>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Place','e');?>"><?php xl('Place','e');?></label>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Date','e');?>"><?php xl('Date','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="mental_status_disoriented" value="<?php xl('Disoriented','e');?>"><?php xl('Disoriented','e');?></label><br>
			<strong><?php xl('Impaired Mental Status Requires the following resources: ','e');?></strong>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('None','e');?>"><?php xl('None','e');?></label>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('Family/Cregiver Support','e');?>"><?php xl('Family/Cregiver Support','e');?></label>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('Guardian','e');?>"><?php xl('Guardian','e');?></label>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('Power of Attorney','e');?>"><?php xl('Power of Attorney','e');?></label>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('Public Conservator','e');?>"><?php xl('Public Conservator','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="impaired_mental_status_requires_resources_other" style="width:70%" value=""></label><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Patient ADL Status: ','e');?></strong>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Total Assistance','e');?>"><?php xl('Requires Total Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Moderate Assistance','e');?>"><?php xl('Requires Moderate Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Minimal Assistance','e');?>"><?php xl('Requires Minimal Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Supervision Only','e');?>"><?php xl('Requires Supervision Only','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Independent','e');?>"><?php xl('Independent','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="patient_adl_status_other" style="width:70%" value=""></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Ambulatory/Transfer Status: ','e');?></strong>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Independent in Ambulation','e');?>"><?php xl('Independent in Ambulation','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Wheelchair Bound','e');?>"><?php xl('Wheelchair Bound','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Bed Bound','e');?>"><?php xl('Bed Bound','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Transfers with Minimal Assistance','e');?>"><?php xl('Transfers with Minimal Assistance','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Transfers requires two people','e');?>"><?php xl('Transfers requires two people','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Use Assistive Device (Walker/Cane)','e');?>"><?php xl('Use Assistive Device (Walker/Cane)','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="ambulatory_transfer_status_other" style="width:93%" value=""></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Communication Status: ','e');?></strong>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Good','e');?>"><?php xl('Good','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Average','e');?>"><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Poor','e');?>"><?php xl('Poor','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Needs Interpreter','e');?>"><?php xl('Needs Interpreter','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Non Verbal','e');?>"><?php xl('Non Verbal','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="communication_status_other" style="width:93%;" value=""></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Miscellaneous Abilities: ','e');?></strong>
			&nbsp;&nbsp;
			<?php xl('Hearing: ','e');?>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('Average','e');?>"><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('HOH','e');?>"><?php xl('HOH','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('Wears Hearing Aid','e');?>"><?php xl('Wears Hearing Aid','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php xl('Other','e');?><input type="text" name="miscellaneous_abilities_hearing_other" style="width:30%;" value=""></label><br>
			<?php xl('Vision: ','e');?>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Average','e');?>"><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Poor','e');?>"><?php xl('Poor','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Blind','e');?>"><?php xl('Blind','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Wearing Glasses','e');?>"><?php xl('Wearing Glasses','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php xl('Other','e');?><input type="text" name="miscellaneous_abilities_vision_other" style="width:30%;" value=""></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Patient Needs Help With: ','e');?></strong>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Obtaining Food','e');?>"><?php xl('Obtaining Food','e');?></label>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Obtaining Medication','e');?>"><?php xl('Obtaining Medication','e');?></label>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Preparing meals','e');?>"><?php xl('Preparing meals','e');?></label>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Managing Finances','e');?>"><?php xl('Managing Finances','e');?></label>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Transportation for Medical care','e');?>"><?php xl('Transportation for Medical care','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="patient_needs_help_with_other" size="35" value=""></label><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="4" align="center"><strong><?php xl('POTENTIAL OUTCOMES','e');?></strong></td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" border="1px" class="formtable">
				<tr>
					<td align="center" valign="middle">
						<?php xl('Patient Desired','e');?>
					</td>
					<td align="center" valign="middle">
						<?php xl('Short Term','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Time Frame','e');?>
					</td>
					<td align="center" valign="middle">
						<?php xl('Long Term','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Time Frame','e');?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">
						<textarea rows="5" cols="20" name="patient_desired"></textarea>
					</td>
					<td align="center" valign="middle">
						<textarea rows="5" cols="20" name="short_term_time_frame"></textarea>
					</td>
					<td align="center" valign="middle">
						<textarea rows="5" cols="20" name="long_term_time_frame"></textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" border="1px" class="formtable">
				<tr>
					<td valign="middle" width="50%">
						<strong><?php xl('MEDICAL SOCIAL SERVICES INTERVENTIONS','e');?></strong>
					</td>
					<td align="center" valign="middle" width="20%">
						<strong><?php xl('Start of Care Date','e');?></strong>
					</td>
					<td align="center" valign="middle" width="30%">
						<input type='text' size='10' name='SOC_date2' id='SOC_date2' 
						title='<?php xl('Start of Care Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"SOC_date2", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
						</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" width="50%">
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Assessment Only of Social and Emotional Factors','e');?>"><?php xl('Assessment Only of Social and Emotional Factors','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Identification of eligibility for services/benefits','e');?>"><?php xl('Identification of eligibility for services/benefits','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Identification of Counseling for long-range, planning and decision making','e');?>"><?php xl('Identification of Counseling for long-range, planning and decision making','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Short term therapy','e');?>"><?php xl('Short term therapy','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Community Resource Planning','e');?>"><?php xl('Community Resource Planning','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Identification of Alternative Living Arrangement to a','e');?>"><?php xl('Identification of Alternative Living Arrangement to a','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Higher Level of Care','e');?>"><?php xl('Higher Level of Care','e');?></label>&nbsp;&nbsp; or
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Lower Level of Care','e');?>"><?php xl('Lower Level of Care','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Coordination of transportation for medical appointments','e');?>"><?php xl('Coordination of transportation for medical appointments','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Coordination of meal delivery services','e');?>"><?php xl('Coordination of meal delivery services','e');?></label><br>
		</td>
		<td colspan="2" width="50%">
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Facilitation of family interactions, discussion with patient and significant others','e');?>"><?php xl('Facilitation of family interactions, discussion with patient and significant others','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Teaching/Training about coping strategies, stress management, in managing disease process','e');?>"><?php xl('Teaching/Training about coping strategies, stress management, in managing disease process','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Grief/Bereavement identification of rist factors and training in adopting to loss','e');?>"><?php xl('Grief/Bereavement identification of rist factors and training in adopting to loss','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Crisis Intervention','e');?>"><?php xl('Crisis Intervention','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Financial resource identification and training','e');?>"><?php xl('Financial resource identification and training','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Facilitation and Education on advance directives, wills, funeral, burial plans','e');?>"><?php xl('Facilitation and Education on advance directives, wills, funeral, burial plans','e');?></label><br>
			Other Services: <input type="text" name="medical_social_services_interventions_other" style="width:50%;" value="">
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('ANALYSIS OF FINDINGS','e');?></strong><br>
			<textarea name="analysis_of_finding" rows="3" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('REVIEW OF INTERVENTIONS/RECOMMENDATIONS','e');?></strong><br>
			<textarea name="review_of_interventions" rows="3" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('EVALUATION OF PATIENT/CLIENT/CAREGIVER RESPONSE TO RECOMMENDATIONS(IF ANY)','e');?></strong><br>
			<textarea name="evaluation_of_patient" rows="3" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('CONTINUED TREATMENT PLAN ','e');?><br>
			<?php xl('FREQUENCY: ','e');?><input type="text" name="continued_treatmentplan_frequency" style="width:25%;" value="">&nbsp;&nbsp;<?php xl('DURATION:','e');?> <input type="text" name="continued_treatmentplan_duration" style="width:25%;" value=""><br>
			<?php xl('EFFECTIVE DATE:','e');?>
			
					<input type='text' size='10' name='continued_treatmentplan_effective_date' id='continued_treatmentplan_effective_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date3' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"continued_treatmentplan_effective_date", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
					</script>
			
			</strong><br>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('MSW Care Plan was communicated to and agreed upon by ','e');?></strong>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Patient','e');?>"><?php xl('Patient','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Physician','e');?>"><?php xl('Physician','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('PT/OT/ST','e');?>"><?php xl('PT/OT/ST','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Skilled Nursing','e');?>"><?php xl('Skilled Nursing','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Caregiver/Family','e');?>"><?php xl('Caregiver/Family','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Case Manager','e');?>"><?php xl('Case Manager','e');?></label><br>
			<?php xl('Other: ','e');?><input type="text" name="msw_careplan_communicated_agreed_other" style="width:25%;" value="">
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Patient/Caregiver/Family Response to Care Plan and Occupational Therapy','e');?></strong></td>
	</tr>
	<tr>
		<td colspan="2" width="50%">
			<strong><?php xl('Physician Orders','e');?></strong><br>
			<label><input type="checkbox" name="physician_order[]" value="<?php xl('MSW Evaluation Only Physician orders obtained','e');?>"><?php xl('MSW Evaluation Only Physician orders obtained','e');?></label><br>
			<label><input type="checkbox" name="physician_order[]" value="<?php xl('Physician orders needed for follow-up.','e');?>"><?php xl('Physician orders needed for follow-up.','e');?></label><br>
			<strong><?php xl('Will follow agency\'s procedures for obtaining verbal orders and completing the 485/POC or submitting supplemental orders for physician signature','e');?></strong>
		</td>
		<td colspan="2" width="50%">
			<?php xl('Other Comments','e');?>
			<textarea name="other_comments" rows="4" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2" width="50%">
			<strong><?php xl('Therapist Who Developed POC','e');?></strong><?php xl('(Name and Title)','e');?>
		</td>
		<td colspan="2" width="50%">
			<strong><?php xl('Electronic Signature','e');?></strong>
		</td>
	</tr>

</table>
<a href="javascript:top.restoreSession();document.msw_careplan.submit();"
class="link_submit"><?php xl(' [Save]','e')?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>

</body>
</html>