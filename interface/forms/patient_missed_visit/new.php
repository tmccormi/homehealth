<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: patient_missed_visit");
?>

<html>
<head>
<title>PATIENT MISSED VISIT-PHYSICIAN NOTIFICATION</title>
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
		action="<?php echo $rootdir;?>/forms/patient_missed_visit/save.php?mode=new" name="patient_missed_visit">
		<h3 align="center"><?php xl('PATIENT MISSED VISIT-PHYSICIAN NOTIFICATION','e')?></h3>		
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
				<strong><?php xl('DATE OF MISSED VISIT','e')?></strong></td>
				<td align="center" valign="top" class="bold">
				<input type='text' size='10' name='patient_missed_date' id='patient_missed_date' 
					title='<?php xl('Date','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"patient_missed_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
				</td>
				</tr></table>
			</td>
			</tr>
			<tr>
				<td colspan="6">
					<strong>
						<?php xl('DISCIPLINE WHO','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="descipline_who_category" value="<?php xl("MISSED VISIT","e");?>"><?php xl("MISSED VISIT","e");?></label>
						<label><input type="checkbox" name="descipline_who_category" value="<?php xl("DELAYED INITIAL SOC/EVALUATION","e");?>"><?php xl("DELAYED INITIAL SOC/EVALUATION","e");?></label>
					</strong>
				</td>
			</tr>
			<tr>
				<td width="33%" colspan="2">
					<label><input type="checkbox" name="descipline_who" value="<?php xl("Skilled Nursing","e");?>"><?php xl("Skilled Nursing","e");?></label><br>
					<label><input type="checkbox" name="descipline_who" value="<?php xl("Physical Therapy","e");?>"><?php xl("Physical Therapy","e");?></label><br>
					<label><input type="checkbox" name="descipline_who" value="<?php xl("Occupational Therapy","e");?>"><?php xl("Occupational Therapy","e");?></label>
				</td>
				<td width="33%" colspan="2">
					<label><input type="checkbox" name="descipline_who" value="<?php xl("Home Health Aide","e");?>"><?php xl("Home Health Aide","e");?></label><br>
					<label><input type="checkbox" name="descipline_who" value="<?php xl("Medical Social Worker","e");?>"><?php xl("Medical Social Worker","e");?></label><br>
					<label><input type="checkbox" name="descipline_who" value="<?php xl("Speech Language Pathologist","e");?>"><?php xl("Speech Language Pathologist","e");?></label>
				</td>
				<td colspan="2">
					<label><input type="checkbox" name="descipline_who" value="<?php xl("Dietician","e");?>"><?php xl("Dietician","e");?></label><br>
					<table border="0px" cellspacing="0" width="100%" class="formtable"><tr><td valign="top">
					<label><input type="checkbox" name="descipline_who" value="<?php xl("Other","e");?>"><?php xl("Other ","e");?></label>
					</td><td valign="top">
					<textarea name="descipline_who_other" rows="3" style="width:100%;"></textarea>
					</td></tr></table>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<strong>
						<?php xl('REASON FOR','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="checkbox" name="reason_for_category" value="<?php xl("MISSED VISIT","e");?>"><?php xl("MISSED VISIT","e");?></label>
						<label><input type="checkbox" name="reason_for_category" value="<?php xl("DELAYED INITIAL EVALUATION","e");?>"><?php xl("DELAYED INITIAL EVALUATION","e");?></label>
						<?php xl("(check all that apply)","e");?>
					</strong>
				</td>
				<td colspan="3">
					<strong>
						<?php xl('ACTIONS TAKEN','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php xl("(check all that apply)","e");?>
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Phoned patient to confirm and was not home when clinician showed up at home","e");?>"><?php xl("Phoned patient to confirm and was not home when clinician showed up at home","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient was not home when clinician showed up at home","e");?>"><?php xl("Patient was not home when clinician showed up at home","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient had MD appointment and not available","e");?>"><?php xl("Patient had MD appointment and not available","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient had another appointment and not available","e");?>"><?php xl("Patient had another appointment and not available","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient refused-no reason given","e");?>"><?php xl("Patient refused-no reason given","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient refused secondary to transient illness (e.g. cold)","e");?>"><?php xl("Patient refused secondary to transient illness (e.g. cold)","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient c/o of fatigue and unable to participate","e");?>"><?php xl("Patient c/o of fatigue and unable to participate","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient c/o of pain and unable to participate","e");?>"><?php xl("Patient c/o of pain and unable to participate","e");?></label><br>
					<table border="0px" cellspacing="0" width="100%" class="formtable"><tr><td valign="top">
					<?php xl("Other: ","e");?></td><td valign="top"><textarea name="reason_for_other" rows="4" style="width:70%;"></textarea>
					</td></tr></table>
				</td>
				<td colspan="3">
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Documented on Clinicians Care Communication Note","e");?>"><?php xl("Documented on Clinicians Care Communication Note","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Message left for patient on answering machine","e");?>"><?php xl("Message left for patient on answering machine","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Message left for patient with authorized contact person","e");?>"><?php xl("Message left for patient with authorized contact person","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("No answering system-unable to leave message for patient","e");?>"><?php xl("No answering system-unable to leave message for patient","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician and Nursing notified of transient illness","e");?>"><?php xl("Physician and Nursing notified of transient illness","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician and Nursing notified of pain","e");?>"><?php xl("Physician and Nursing notified of pain","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician and Nursing notified of patient refusal","e");?>"><?php xl("Physician and Nursing notified of patient refusal","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician and Nursing notified of patient fatigue and unable to participate.","e");?>"><?php xl("Physician and Nursing notified of patient fatigue and unable to participate.","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician notified of other appointment and patient not seen according to order","e");?>"><?php xl("Physician notified of other appointment and patient not seen according to order","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Other","e");?>"><?php xl("Other ","e");?></label>
					<input type="text" name="actions_taken_other" style="width:80%;" value="">
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<strong>
						<?php xl('PATIENT"S NEEDS WERE ADDRESSED','e')?>
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<label><input type="checkbox" name="patient_need_addressed" value="<?php xl("Verified with authorized person/family/friends/neighbors who were in contact with patient","e");?>"><?php xl("Verified with authorized person/family/friends/neighbors who were in contact with patient","e");?></label><br>
					<label><input type="checkbox" name="patient_need_addressed" value="<?php xl("Able to contact patient and they refused assistance from discipline for this date but continues to want services and visit was rescheduled","e");?>"><?php xl("Able to contact patient and they refused assistance from discipline for this date but continues to want services and visit was rescheduled","e");?></label><br>
					<label><input type="checkbox" name="patient_need_addressed" value="<?php xl("Able to contact patient and they refused assistance from discipline at any time. Physician notified, other disciplines notified and discharge process initiated","e");?>"><?php xl("Able to contact patient and they refused assistance from discipline at any time. Physician notified, other disciplines notified and discharge process initiated","e");?></label><br>
					<label><input type="checkbox" name="patient_need_addressed" value="<?php xl("Clinician will follow-up with patient to determine if continued interventions are needed at this time and notify physician/other disciplines of outcome","e");?>"><?php xl("Clinician will follow-up with patient to determine if continued interventions are needed at this time and notify physician/other disciplines of outcome","e");?></label><br>
					<?php xl("Other: ","e");?>&nbsp;<input type="text" name="patient_need_addressed_other" style="width:90%;" value="">
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<strong>
						<?php xl('PHYSICIAN ACKNOWLEDGMENT OF MISSED VISIT BY DISCIPLINE','e')?>
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<strong>
						<label><?php xl('Physician ','e')?><input type="text" name="physician_name" value="<?php doctorname(); ?>" readonly></label>
						<label><?php xl('FAX NUMBER ','e')?><input type="text" name="physician_fax_number" value="<?php physicianfax(); ?>" readonly></label><br>
						<?php xl('Physician Signature acknowledges Home Health Agency"s communication of patient"s','e')?>
						<input type="checkbox" name="physician_acknowledgment" id="physician_acknowledgment_missed" value="<?php xl("MISSED VISIT","e");?>"><label for="physician_acknowledgment_missed"><?php xl("MISSED VISIT","e");?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="physician_acknowledgment" id="physician_acknowledgment_delayed" value="<?php xl("DELAYED INITIAL SOC/EVALUATION","e");?>"><label for="physician_acknowledgment_delayed"><?php xl("DELAYED INITIAL SOC/EVALUATION","e");?></label>
						<?php xl(' ON ','e')?>
						<input type='text' size='10' name='physician_acknowledgment_date' id='physician_acknowledgment_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"physician_acknowledgment_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
						</script>
						<br>
						<?php xl('PHYSICIAN SIGNATURE ','e')?><input type="text" name="physician_signature" value="">&nbsp;&nbsp;&nbsp;&nbsp;
						<?php xl('DATE ','e')?>
						<input type='text' size='10' name='physician_signature_date' id='physician_signature_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date3' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"physician_signature_date", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
						</script>
						<br>
						<?php xl('Additional Physician Comments: ','e')?><input type="text" name="physician_comments" style="width:50%" value="">&nbsp;&nbsp;&nbsp;&nbsp;
						
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<strong><?php xl('Clinician Name/Title ','e')?></strong>
				</td>
				<td colspan="3">
					<strong><?php xl('Electronic Signature','e')?></strong>
				</td>
			</tr>
		</table>
		<a href="javascript:top.restoreSession();document.patient_missed_visit.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
		</form>
</body>

</html>