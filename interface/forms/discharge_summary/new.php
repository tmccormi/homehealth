<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: general_discharge_summary");
?>

<html>
<head>
<title>GENERAL DISCHARGE SUMMARY</title>
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
		action="<?php echo $rootdir;?>/forms/discharge_summary/save.php?mode=new" name="general_discharge_summary">
		<h3 align="center"><?php xl('GENERAL DISCHARGE SUMMARY','e')?></h3>		
		 <br/>
		<table width="100%" border="1" cellpadding="2px" class="formtable">
			<tr>
			<td colspan="6">
				<table border="1px" class="formtable" width="100%"><tr>
				<td align="center" valign="top" scope="row">
				<strong><?php xl('PATIENT NAME','e')?></strong></td>
				<td align="center" valign="top"><input type="text" name="patient_name"
					 id="patient_name" value="<?php patientName()?>"
					readonly /></td>
				<td  align="center" valign="top"><strong><?php xl('MR#','e')?>
				</strong></td>
				<td align="center" valign="top" class="bold"><input
					type="text" name="patient_mr" id="patient_mr"
					value="<?php  echo $_SESSION['pid']?>" readonly/></td>
				<td align="center" valign="top">
				<strong><?php xl('DATE','e')?></strong></td>
				<td align="center" valign="top" class="bold">
				<input type='text' size='10' name='patient_discharge_date' id='patient_discharge_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"patient_discharge_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
				</td>
				</tr></table>
			</td>
			</tr>
			<tr>
				<td >
				<strong><?php xl('DISCONTINUE FURTHER SERVICES FOR:','e');?></strong>&nbsp;&nbsp;
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" value="Skilled Nursing"><?php xl('Skilled Nursing','e');?></label>
			    <label><input type="checkbox" name="discharge_summary_discontinue_services[]" value="Physical Therapy"><?php xl('Physical Therapy','e');?></label>
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" value="Occupational Therapy"><?php xl('Occupational Therapy','e');?></label>
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" value="Speech Therapy"><?php xl('Speech Therapy','e');?></label>
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" value="Home Health Aide"><?php xl('Home Health Aide','e');?></label>
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" value="Medical Social Worker"><?php xl('Medical Social Worker','e');?></label>
				&nbsp;&nbsp;&nbsp;
				<?php xl('Other ','e');?>&nbsp;<input type="text" name="discharge_summary_discontinue_services_other" style="width:63%" >
				</td>
			</tr>
			<tr>
			<td>
			<strong><?php xl('Mental Status','e');?></strong><br>
			<label><input type="checkbox" name="discharge_summary_mental_status" value="Alert"><?php xl('Alert','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" value="Oriented"><?php xl('Oriented','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" value="Forgetful"><?php xl('Forgetful','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" value="Disoriented"><?php xl('Disoriented','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" value="Depressed"><?php xl('Depressed','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" value="Agitated"><?php xl('Agitated','e');?></label>
			&nbsp;&nbsp;&nbsp;
			<?php xl('Other ','e');?>&nbsp;<input type="text" name="discharge_summary_mental_status_other" style="width:36%" >
			<br>
			<?php xl('Based on cognitive, medical and functional impairments the following interventions have been provided by the home
health agency (Check all that apply)','e');?>&nbsp;&nbsp;
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" value="Skilled Nursing"><?php xl('Skilled Nursing','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" value="Medical Social Services"><?php xl('Medical Social Services','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" value="Caregiver Management Training"><?php xl('Caregiver Management Training','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" value="Home Health Aide Support"><?php xl('Home Health Aide Support','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" value="PT"><?php xl('PT','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" value="OT"><?php xl('OT','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" value="ST"><?php xl('ST','e');?></label>
			&nbsp;&nbsp;&nbsp;
			<?php xl('Other ','e');?>&nbsp;<input type="text" name="discharge_summary_provided_interventions_other" style="width:85%" >
			</td>
			</tr>
			
			<tr>
			<td>
			<table width="100%" border="1px" class="formtable"><tr>
			<td colspan="3">
			<strong><?php xl('Reason for Discharge (Check all that apply)','e');?></strong>
			</td></tr>
			<tr>
			<td width="33%">
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="No Further Skilled Care Required"><?php xl('No Further Skilled Care Required','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Short-Term Goals were achieved"><?php xl('Short-Term Goals were achieved','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Long-Term Goals were achieved"><?php xl('Long-Term Goals were achieved','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Patient no longer homebound"><?php xl('Patient no longer homebound','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Patient reached maximum rehab potential"><?php xl('Patient reached maximum rehab potential','e');?></label>
			</td width="33%">
			<td>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Family/Friends/Physician Assume Responsibility Patient/Family refused services"><?php xl('Family/Friends/Physician Assume Responsibility Patient/Family refused services','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Moved out of service area"><?php xl('Moved out of service area','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Admitted to Hospital"><?php xl('Admitted to Hospital','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Admitted to a higher level of care (SNF,ALF)"><?php xl('Admitted to a higher level of care (SNF,ALF)','e');?></label>
			</td>
			<td width="33%">
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Transferred to another Agency"><?php xl('Transferred to another Agency','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Death"><?php xl('Death','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="Transferred to Hospice"><?php xl('Transferred to Hospice','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" value="MD Request"><?php xl('MD Request','e');?></label><br>
			<?php xl('Other ','e');?>&nbsp;<input type="text" name="discharge_summary_discharge_reason_other" style="width:75%" >
			</td>
			</tr>
			</table></td>
			</tr>
			
			<tr>
			<td>
			<strong><?php xl('Functional Ability at Time of Discharge','e');?></strong><br>
			<label><input type="checkbox" name="discharge_summary_functional_ability" value="Independent"><?php xl('Independent','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_functional_ability" value="Independent with Minimal Assistance"><?php xl('Independent with Minimal Assistance','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_functional_ability" value="Partially Dependent"><?php xl('Partially Dependent','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_functional_ability" value="Totally Dependent"><?php xl('Totally Dependent','e');?></label>&nbsp;
			</td>
			</tr>
			
			<tr>
			<td>
			<strong><?php xl('COMMENTS/RECOMMENDATIONS','e');?></strong><br>
			<label><input type="checkbox" name="discharge_summary_comments_recommendations" value="Discharge was anticipated"><?php xl('Discharge was anticipated and discussed in advance with patient/caregiver/family and MD','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_comments_recommendations" value="Discharge was not anticipated"><?php xl('Discharge was not anticipated','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_comments_recommendations" value="No longer homebound but would benefit from outpatient services"><?php xl('No longer homebound but would benefit from outpatient services','e');?></label>&nbsp;
			&nbsp;<?php xl('Services recommended','e');?>&nbsp;<input type="text" name="discharge_summary_service_recommended" style="width:30%" ><br>
			<label><input type="checkbox" name="discharge_summary_comments_recommendations" value="Recommend follow-up treatment when patient returns to home"><?php xl('Recommend follow-up treatment when patient returns to home.','e');?></label><br>
			<?php xl('Goals identified on care plan were','e');?>&nbsp;&nbsp;
			<label><input type="checkbox" name="discharge_summary_goals_identified" value="met"><?php xl('met','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_goals_identified" value="partially met"><?php xl('partially met','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_goals_identified" value="not met"><?php xl('not met (If goals partially met or not met please explain)','e');?></label>
			<br>
			<input type="text" name="discharge_summary_goals_identified_explanation" style="width:96%" >
			</td>
			</tr>
			
			<tr>
			<td>
			<strong><?php xl('Additional Comments','e');?></strong><br>
			<textarea name="discharge_summary_additional_comments" rows="3" cols="98" ></textarea>
			</td>
			</tr>
			
			<tr>
			<td>
			<table border="1px" width="100%" class="formtable"><tr><td width="70%">
			<?php xl('<b>Visit and Discharge Completed by Clinician Signature<b> (Name/Title)','e');?>
			</td>
			<td width="30%">
			<?php xl('Electronic Signature','e');?>
			</td></tr></table>
			</td>
			</tr>
			
			<tr>
			<td>
			<table border="1px" width="100%" class="formtable">
			<tr><td width="33%">
			<strong><?php xl('MD PRINTED NAME','e');?></strong><br>
			<input type="text" name="discharge_summary_md_name" style="width:90%" value="<?php doctorname(); ?>" readonly="readonly">
			</td>
			<td width="33%">
			<strong><?php xl('MD Signature','e');?></strong><br>
			<input type="text" name="discharge_summary_md_signature" style="width:90%" >
			</td>
			<td width="33%">
			<strong><?php xl('Date','e');?></strong><br>&nbsp;
			<input type='text' size='16' name='discharge_summary_md_signature_date' id='discharge_summary_md_signature_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' /> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"discharge_summary_md_signature_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			
		</table>
		<a href="javascript:top.restoreSession();document.general_discharge_summary.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
		</form>
</body>

</html>
