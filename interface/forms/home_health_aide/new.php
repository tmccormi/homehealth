<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: home_health_aide");
?>

<html>
<head>
<title>Home Health Aide Assessment</title>
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
		action="<?php echo $rootdir;?>/forms/home_health_aide/save.php?mode=new" name="home_health_aide">
		<h3 align="center"><?php xl('HOME HEALTH AIDE ASSIGNMENT SHEET','e')?></h3>		
		
		


<table width="100%" border="1px" class="formtable">
	<tr>
		<td><strong><?php xl('Patient Name','e');?></strong></td>
		<td><input type="text" name="home_health_patient_name" size="20" value="<?php patientName()?>" readonly ></td>
		<td><strong><?php xl('Patient Address','e');?></strong></td>
		<td><input type="text" name="home_health_patient_address" size="20" value="<?php patientAddress()?>" readonly ></td>
		<td><strong><?php xl('Patient Phone','e');?></strong></td>
		<td><input type="text" name="home_health_patient_phone" size="20" value="<?php patientPhone()?>" readonly ></td>
	</tr>
	<tr>
		<td colspan="6"><strong>
			<?php xl('CARE MANAGER COMPLETING HHA ASSIGNMENT SHEET','e');?><br>
			<?php xl('NAME/TITLE ','e');?>&nbsp;<input type="text" name="home_health_care_manager" style="width:90%" value="">
			</strong>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('AIDE VISITS','e');?><br>
			<?php xl('FREQUENCY: ','e');?><input type="text" name="home_health_aide_visit_frequency" style="width:25%;" value="">&nbsp;&nbsp;<?php xl('DURATION:','e');?> <input type="text" name="home_health_aide_visit_duration" style="width:25%;" value=""><br>
			<?php xl('EFFECTIVE DATE:','e');?>
			
					<input type='text' size='10' name='home_health_aide_visit_effective_date' id='home_health_aide_visit_effective_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"home_health_aide_visit_effective_date", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
					</script>
			
			</strong><br>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('Patient Problem (s)','e');?></strong><br>
			<textarea name="patient_problems" rows="3" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong>
			<?php xl('Goals for Care','e');?></strong><br>
			<label><input type="checkbox" name="home_health_goals_for_care" value="<?php xl('Patient Care Management','e');?>"><?php xl('Patient Care Management','e');?></label>
			<label><input type="checkbox" name="home_health_goals_for_care" value="<?php xl('ADL Assistance in Personal Care','e');?>"><?php xl('ADL Assistance in Personal Care','e');?></label><br>
			<label><?php xl('Other ','e');?>&nbsp;<input type="text" name="home_health_goals_for_care_other" style="width:90%" value=""></label>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('Patient Medical Issues/Precautions (Check all that apply)','e');?></strong><br>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('None','e');?>"><?php xl('None','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Full-Code','e');?>"><?php xl('Full-Code','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Do Not Resuscitate','e');?>"><?php xl('Do Not Resuscitate','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Seizures','e');?>"><?php xl('Seizures','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Bleeding','e');?>"><?php xl('Bleeding','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Prone to Fractures','e');?>"><?php xl('Prone to Fractures','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Hip Precautions','e');?>"><?php xl('Hip Precautions','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Non-Weight Bearing','e');?>"><?php xl('Non-Weight Bearing','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Falls Risks','e');?>"><?php xl('Falls Risks','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('SOB','e');?>"><?php xl('SOB','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('On Oxygen','e');?>"><?php xl('On Oxygen','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Watch for hyper/hypoglycemia','e');?>"><?php xl('Watch for hyper/hypoglycemia','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Diabetic','e');?>"><?php xl('Diabetic','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Do not cut nails','e');?>"><?php xl('Do not cut nails','e');?></label><br>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Diet','e');?>"><?php xl('Diet ','e');?></label>&nbsp;<input type="text" name="home_health_medical_issues_diet" style="width:90%" value=""><br>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Urinary Catheter','e');?>"><?php xl('Urinary Catheter','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Allergies','e');?>"><?php xl('Allergies ','e');?></label>&nbsp;<input type="text" name="home_health_medical_issues_allergies" style="width:75%" value=""><br>
			<label><?php xl('Other ','e');?>&nbsp;<input type="text" name="home_health_medical_issues_other" style="width:90%" value=""></label>
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Living Situation:','e');?></strong><?php xl(' Patient Lives: ','e');?>
			<label><input type="checkbox" name="home_health_living_situation" value="<?php xl('Alone','e');?>"><?php xl('Alone','e');?></label>
			<label><input type="checkbox" name="home_health_living_situation" value="<?php xl('With Spouse/Significant Other','e');?>"><?php xl('With Spouse/Significant Other','e');?></label>
			<label><input type="checkbox" name="home_health_living_situation" value="<?php xl('With Family','e');?>"><?php xl('With Family','e');?></label>
			<label><input type="checkbox" name="home_health_living_situation" value="<?php xl('With Paid Help','e');?>"><?php xl('With Paid Help','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="home_health_living_situation_other" style="width:80%" value=""></label><br>
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Type of Housing: ','e');?></strong>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('House','e');?>"><?php xl('House','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Apartment','e');?>"><?php xl('Apartment','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Mobile Home','e');?>"><?php xl('Mobile Home','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Retirement Community','e');?>"><?php xl('Retirement Community','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Assisted Living Facility','e');?>"><?php xl('Assisted Living Facility','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Board and Care','e');?>"><?php xl('Board and Care','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Public Housing','e');?>"><?php xl('Public Housing','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Subsidized Housing','e');?>"><?php xl('Subsidized Housing','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Group Home','e');?>"><?php xl('Group Home','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Homeless','e');?>"><?php xl('Homeless','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="home_health_type_of_housing_other" style="width:80%" value=""></label><br>
			<strong><?php xl('Condition of Housing: ','e');?></strong>
			<label><input type="checkbox" name="home_health_condition_of_housing" value="<?php xl('Adequate','e');?>"><?php xl('Adequate','e');?></label>
			<label><input type="checkbox" name="home_health_condition_of_housing" value="<?php xl('Inadequate','e');?>"><?php xl('Inadequate','e');?></label><br>
			<?php xl('Describe Problems/Safety Issues ','e');?><input type="text" name="home_health_problem_safety_issues" style="width:70%" value=""></label><br>
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Mental Status: ','e');?></strong>
			<label><input type="checkbox" name="mental_status" value="<?php xl('Alert','e');?>"><?php xl('Alert','e');?></label>
			<label><input type="checkbox" name="mental_status" value="<?php xl('Not Alerted','e');?>"><?php xl('Not Alerted','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<strong><?php xl('Oriented to: ','e');?></strong>
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
		<td colspan="6"><strong><?php xl('Patient ADL Status: ','e');?></strong>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Total Assistance','e');?>"><?php xl('Requires Total Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Moderate Assistance','e');?>"><?php xl('Requires Moderate Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Minimal Assistance','e');?>"><?php xl('Requires Minimal Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Supervision Only','e');?>"><?php xl('Requires Supervision Only','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Independent','e');?>"><?php xl('Independent','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="patient_adl_status_other" style="width:70%" value=""></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Ambulatory/Transfer Status: ','e');?></strong>
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
		<td colspan="6"><strong><?php xl('Communication Status: ','e');?></strong>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Good','e');?>"><?php xl('Good','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Average','e');?>"><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Poor','e');?>"><?php xl('Poor','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Needs Interpreter','e');?>"><?php xl('Needs Interpreter','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Non Verbal','e');?>"><?php xl('Non Verbal','e');?></label><br>
			<label><strong><?php xl('Other','e');?></strong><input type="text" name="communication_status_other" style="width:93%;" value=""></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Miscellaneous Abilities: ','e');?></strong>
			&nbsp;&nbsp;
			<strong><?php xl('Hearing: ','e');?></strong>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('Average','e');?>"><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('HOH','e');?>"><?php xl('HOH','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('Wears Hearing Aid','e');?>"><?php xl('Wears Hearing Aid','e');?></label><br>
			<strong><?php xl('Vision: ','e');?></strong>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Average','e');?>"><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Poor','e');?>"><?php xl('Poor','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Blind','e');?>"><?php xl('Blind','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Wearing Glasses','e');?>"><?php xl('Wearing Glasses','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Contacts','e');?>"><?php xl('Contacts','e');?></label><br>
			<strong><?php xl('Dentures: ','e');?></strong>
			<label><input type="checkbox" name="miscellaneous_abilities_dentures" value="<?php xl('Upper','e');?>"><?php xl('Upper','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_dentures" value="<?php xl('Lower','e');?>"><?php xl('Lower','e');?></label>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('Home Health Assignment-Check all tasks that the patient needs. Add specific directions at bottom of assignment list. Must be reviewed and revised at least every 62 days.','e');?></strong>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Bathing','e');?>"><?php xl('Bathing','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_bathing" value="<?php xl('From Bed to Tub/Shower','e');?>"><?php xl('From Bed to Tub/Shower','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_bathing" value="<?php xl('In Bed Bath','e');?>"><?php xl('In Bed Bath','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_bathing" value="<?php xl('In Chair Bath','e');?>"><?php xl('In Chair Bath','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Dressing','e');?>"><?php xl('Dressing','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_dressing[]" value="<?php xl('Upper Body','e');?>"><?php xl('Upper Body','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_dressing[]" value="<?php xl('Lower Body','e');?>"><?php xl('Lower Body','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Toileting','e');?>"><?php xl('Toileting','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Hair Care','e');?>"><?php xl('Hair Care','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_haircare[]" value="<?php xl('Brush','e');?>"><?php xl('Brush','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_haircare[]" value="<?php xl('Shampoo','e');?>"><?php xl('Shampoo','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Personal Hygiene','e');?>"><?php xl('Personal Hygiene','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Shave','e');?>"><?php xl('Shave','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Nail Care','e');?>"><?php xl('Nail Care','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Oral Care','e');?>"><?php xl('Oral Care','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Peri-Care','e');?>"><?php xl('Peri-Care','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Groom','e');?>"><?php xl('Groom','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Catheter Care','e');?>"><?php xl('Catheter Care','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Elimination Assistance','e');?>"><?php xl('Elimination Assistance','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Ambulation Assistance','e');?>"><?php xl('Ambulation Assistance','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Mobility Assist to','e');?>"><?php xl('Mobility Assist to','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Chair','e');?>"><?php xl('Chair','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Commode','e');?>"><?php xl('Commode','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Tub','e');?>"><?php xl('Tub','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Shower','e');?>"><?php xl('Shower','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Bed','e');?>"><?php xl('Bed','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Active Range of Motion Exercises','e');?>"><?php xl('Active Range of Motion Exercises','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Passive Range of Motion Exercises','e');?>"><?php xl('Passive Range of Motion Exercises','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Positioning','e');?>"><?php xl('Positioning','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_positioning[]" value="<?php xl('In Bed','e');?>"><?php xl('In Bed','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_positioning[]" value="<?php xl('In Wheelchair','e');?>"><?php xl('In Wheelchair','e');?></label>
			
		</td>
		<td colspan="3" valign="top">
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Check Pressure Areas','e');?>"><?php xl('Check Pressure Areas (Location)','e');?></label><br>
			<input type="text" name="home_health_patient_need_pressure_location" style="width:93%;" value=""><br>
			
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Meal Preparation','e');?>"><?php xl('Meal Preparation','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Assist with Feeding','e');?>"><?php xl('Assist with Feeding','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Limit','e');?>"><?php xl('Limit','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Encourage','e');?>"><?php xl('Encourage','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Fluids','e');?><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Grocery Shopping','e');?>"><?php xl('Grocery Shopping','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Wash Clothes','e');?>"><?php xl('Wash Clothes','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Light Housekeeping','e');?>"><?php xl('Light Housekeeping','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_housekeeping[]" value="<?php xl('Bedroom','e');?>"><?php xl('Bedroom','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_housekeeping[]" value="<?php xl('Bathroom','e');?>"><?php xl('Bathroom','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_housekeeping[]" value="<?php xl('Kitchen','e');?>"><?php xl('Kitchen','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Oxygen Care','e');?>"><?php xl('Oxygen Care','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Equipment Care','e');?>"><?php xl('Equipment Care','e');?></label><br>
			<input type="text" name="home_health_patient_need_equipment_care" style="width:93%;" value=""><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Medication Assist/Management','e');?>"><?php xl('Medication Assist/Management (Describe)','e');?></label><br>
			<input type="text" name="home_health_patient_need_medication_assist" style="width:93%;" value=""><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Record Intake/Output','e');?>"><?php xl('Record Intake/Output','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Record Weight Weekly','e');?>"><?php xl('Record Weight Weekly','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Record Vital Signs','e');?>"><?php xl('Record Vital Signs','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_record_sign" value="<?php xl('Per Visit','e');?>"><?php xl('Per Visit','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_record_sign" value="<?php xl('Weekly','e');?>"><?php xl('Weekly','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Wound care','e');?>"><?php xl('Wound care (Check and Reinforce Dressings) (Describe)','e');?></label><br>
			<input type="text" name="home_health_patient_need_wound_care" style="width:93%;" value="">
			
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('Additional Instructions','e');?></strong><br>
			<textarea name="additional_instructions" rows="3" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Reviewed/Revised Date: ','e');?></strong>
			<input type='text' size='10' name='review_date_1' id='review_date_1' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"review_date_1", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
					</script>
		</td>
		<td colspan="3">
			<strong><?php xl('Signature/Title: ','e');?></strong>
			<input type='text' size='10' name='signature_1' value="">
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Reviewed/Revised Date: ','e');?></strong>
			<input type='text' size='10' name='review_date_2' id='review_date_2' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"review_date_2", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
					</script>
		</td>
		<td colspan="3">
			<strong><?php xl('Signature/Title: ','e');?></strong>
			<input type='text' size='10' name='signature_2' value="">
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Reviewed/Revised Date: ','e');?></strong>
			<input type='text' size='10' name='review_date_3' id='review_date_3' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date3' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"review_date_3", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
					</script>
		</td>
		<td colspan="3">
			<strong><?php xl('Signature/Title: ','e');?></strong>
			<input type='text' size='10' name='signature_3' value="">
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Clinician Name/Title Completing Note','e');?></strong>
		</td>
		<td colspan="3">
			<strong><?php xl('Electronic Signature','e');?></strong>
		</td>
	</tr>
	
	
	

</table>
<a href="javascript:top.restoreSession();document.home_health_aide.submit();"
class="link_submit"><?php xl(' [Save]','e')?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B" onClick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>

</body>
</html>