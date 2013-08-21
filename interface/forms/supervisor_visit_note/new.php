<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: supervisor_visit_note");
?>

<html>
<head>
<title>Supervisor Visit Note</title>
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
		action="<?php echo $rootdir;?>/forms/supervisor_visit_note/save.php?mode=new" name="supervisor_visit_note">
		<h3 align="center"><?php xl('SUPERVISOR VISIT OF HOME HEALTH STAFF','e')?></h3>		
		
<table width="100%" border="1px" class="formtable">
	<tr>
		<td colspan="5">
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td><strong><?php xl('Patient Name','e');?></strong></td>
				<td><input type="text" name="patient_name" style="width:100%" value="<?php patientName()?>" readonly ></td>
				<td><strong><?php xl('Time In','e');?></strong></td>
				<td>
					<select name="time_in">
						<?php timeDropDown($GLOBALS['Selected']) ?>
					</select>
				</td>
				<td><strong><?php xl('Time Out','e');?></strong></td>
				<td>
					<select name="time_out">
						<?php timeDropDown($GLOBALS['Selected']) ?>
					</select>
				</td>
				<td><strong><?php xl('Date','e');?></strong></td>
				<td align="center" valign="top" class="bold">
					<input type='text' size='10' name='SOC_date' id='date' 
					title='<?php xl('Supervisor Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
					</script>
				</td>
			</tr>
		</table>
	</tr>
	<tr>
		<td colspan="5">
			<strong><?php xl('NAME OF STAFF MEMBER SUPERVISED: ','e');?></strong>&nbsp;&nbsp;
			<input type="text" name="staff_supervised" style="width:50%;" value="">
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<strong><?php xl('SUPERVISOR VISITS: ','e');?><br>
			<label><input type="checkbox" name="supervisor_visits" value="<?php xl('LPN/LVN (every 30 days)','e');?>"><?php xl('LPN/LVN (every 30 days)','e');?></label>&nbsp;&nbsp;
			<label><input type="checkbox" name="supervisor_visits" value="<?php xl('HHA (every 14 days)','e');?>"><?php xl('HHA (every 14 days)','e');?></label>&nbsp;&nbsp;
			<label><input type="checkbox" name="supervisor_visits" value="<?php xl('PTA','e');?>"><?php xl('PTA','e');?></label>&nbsp;&nbsp;
			<label><input type="checkbox" name="supervisor_visits" value="<?php xl('COTA (Per State Guidelines)','e');?>"><?php xl('COTA (Per State Guidelines)','e');?></label>&nbsp;&nbsp;
			</strong>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('EXCEEDS REQUIREMENTS','e');?></strong>
		</td>
		<td>
			<strong><?php xl('MEETS REQUIREMENTS','e');?></strong>
		</td>
		<td>
			<strong><?php xl('DOES NOT MEET REQUIREMENTS','e');?></strong>
		</td>
		<td>
			<strong><?php xl('NOT OBSERVED','e');?></strong>
		</td>
		<td>
			<strong><?php xl('OBSERVATIONS','e');?></strong>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="reported_to_patient_home" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="reported_to_patient_home" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="reported_to_patient_home" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="reported_to_patient_home" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Reported to patient home when scheduled','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="wearing_name_badge" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="wearing_name_badge" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="wearing_name_badge" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="wearing_name_badge" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Wearing name badge','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="using_two_identifiers" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="using_two_identifiers" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="using_two_identifiers" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="using_two_identifiers" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Using two identifiers for patient','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_behaviour" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_behaviour" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_behaviour" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_behaviour" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Demonstrates politeness, courteous and respectful behavior during visit','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="follow_home_health" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="follow_home_health" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="follow_home_health" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="follow_home_health" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Follows Home Health Aide Care Plan Assignment','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_communication" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_communication" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_communication" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_communication" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Demonstrates Adequate Communication Skills','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="aware_patient_code" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="aware_patient_code" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="aware_patient_code" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="aware_patient_code" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Aware of patient"s code status','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_clinical_skills" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_clinical_skills" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_clinical_skills" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_clinical_skills" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Demonstrates clinical skills appropriate to patient need','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="adheres_to_policies" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="adheres_to_policies" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="adheres_to_policies" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="adheres_to_policies" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Adheres to policies and procedures','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="identify_patient_issues" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="identify_patient_issues" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="identify_patient_issues" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="identify_patient_issues" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('If applicable, Identifies patient issues during visit','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="handling_skills" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="handling_skills" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="handling_skills" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="handling_skills" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Utilizes good patient handling skills','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_grooming" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_grooming" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_grooming" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_grooming" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Demonstrates appropriate grooming, hygiene and dressing skills','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="supervisor_visit_other" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="supervisor_visit_other" value="<?php xl('MEETS REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="supervisor_visit_other" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>">
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="supervisor_visit_other" value="<?php xl('NOT OBSERVED','e');?>">
		</td>
		<td>
			<?php xl('Other','e');?>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<?php xl('Additional Notes','e');?><br>
			<textarea name="additional_notes" rows="3" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<?php xl('Clinician Signature','e');?><br>
			<input type="text" name="clinician_signature" value="">
		</td>
		<td>
			<?php xl('Date','e');?>
					<input type='text' size='10' name='clinician_signature_date' id='clinician_signature_date' 
					title='<?php xl('Clinician Signature Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"clinician_signature_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
					</script>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Supervisor"s Signature','e');?></strong><?php xl('(Name/Title)','e');?>
		</td>
		<td colspan="2">
			<strong><?php xl('Electronic Signature','e');?></strong>
		</td>
	</tr>

</table>
<a href="javascript:top.restoreSession();document.supervisor_visit_note.submit();"
class="link_submit"><?php xl(' [Save]','e')?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>

</body>
</html>