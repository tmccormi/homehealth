<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: thirtyday_progress_note");
?>

<html>
<head>
<title>Care Plan</title>
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
		action="<?php echo $rootdir;?>/forms/thirtyday_progress_note/save.php?mode=new" name="thirtyday_progress_note">
		<h3 align="center"><?php xl('30 DAY PROGRESS REPORT','e')?></h3>		
		<h5 align="center">
		<?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
		</h5>
		<br> <br/>
		<table width="100%" border="1" cellpadding="2px" class="formtable">
			<tr>
				<td width="13%" align="center" valign="top" scope="row">
				<strong><?php xl('PATIENT NAME','e')?></strong></td>
				<td width="13%" align="center" valign="top"><input type="text" name="thirty_day_progress_note_patient_name"
					 id="thirty_day_progress_note_patient_name" value="<?php patientName()?>"
					readonly /></td>
				<td width="20%" align="center" valign="top"><strong><?php xl('MR#','e')?>
				</strong></td>
				<td width="15%" align="center" valign="top" class="bold"><input
					type="text" name="thirty_day_progress_note_mr" id="thirty_day_progress_note_mr"
					value="<?php  echo $_SESSION['pid']?>" readonly/></td>
				<td width="22%" align="center" valign="top">
				<strong><?php xl('DATE','e')?></strong></td>
				<td width="17%" align="center" valign="top" class="bold">
				<input type='text' size='10' name='thirty_day_progress_note_date' id='thirty_day_progress_note_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"thirty_day_progress_note_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
				</td>

			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('CARE COORDINATION INVOLVED IN THE FOLLOWING DISCIPLINE(S)','e')?>
				</strong>
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="middle" scope="row"><label> <input
						type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]" value="<?php xl('Physician','e')?>"/> <?php xl('Physician','e')?>
				</label> <br /> <label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]" value="<?php xl('Director Patient Care','e')?>"/> <?php xl('Director Patient Care','e')?> </label>
					<br />	<?php xl('Services/DON','e')?>
					<br /> <label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('RN/LPN/LVN','e')?>"/> <?php xl('RN/LPN/LVN','e')?> </label>
					<br /> <label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Physical Therapy','e')?>"/> <?php xl('Physical Therapy','e')?> </label> <br />
					</td>
				<td colspan="2" valign="top">
					<p>
						<label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Occupational Therapy','e')?>"/> <?php xl('Occupational Therapy','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Case Manager','e')?>"/> <?php xl('Case Manager','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Home Health Aide','e')?>"/> <?php xl('Home Health Aide','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Medical Social Worker','e')?>"/> <?php xl('Medical Social Worker','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Speech Language Pathologist','e')?>"/> <?php xl('Speech Language Pathologist','e')?>
						</label> 
					</p>
				</td>
				<td colspan="2" valign="top">
					<p>
						<label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl(' Pharmacist','e')?>"/> <?php xl(' Pharmacist','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('DME Vendor','e')?>"/> <?php xl('DME Vendor','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Dietician','e')?>"/> <?php xl('Dietician','e')?>
						</label>
					</p>
					<p>
						<?php xl(' Other','e')?> <input type="text"
							name="thirty_day_progress_note_care_coordination_involved_other" rows="2" style="width:80%"  value=""/>
					</p>
					<p>
						<br />
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('CARE COMMUNICATED VIA','e')?>
				</strong> <label> <input type="checkbox"
						name="thirty_day_progress_note_care_communicated_via"
						value="<?php xl('IDT Meeting','e')?>" /> <?php xl('IDT Meeting','e')?> </label> <label> 
						<input type="checkbox" name="thirty_day_progress_note_care_communicated_via" value="<?php xl('1:1 Clinician/Clinical Supervisor','e')?>" /> <?php xl('1:1 Clinician/Clinical Supervisor','e')?>
				</label> <label> <input type="checkbox"
						name="thirty_day_progress_note_care_communicated_via"
						value="<?php xl('Phone Conference','e')?>" /> <?php xl('Phone Conference','e')?> </label> <label>
						 <input type="checkbox" name="thirty_day_progress_note_care_communicated_via"
						 value="<?php xl('Electronic Medical Records','e')?>" /> <?php xl('Electronic Medical Records','e')?>
				</label> <label> <input type="checkbox"
						name="thirty_day_progress_note_care_communicated_via"
						value="<?php xl('Fax','e')?>" /> <?php xl('Fax','e')?> </label> <label>
						<input type="checkbox" name="thirty_day_progress_note_care_communicated_via" value="<?php xl('Mail','e')?>" /> <?php xl('Mail','e')?>
				</label><br>
				<label> 
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:93%" name="thirty_day_progress_note_care_communicated_via_other"  value=""/>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('TOPIC FOR DISCUSSION(Check all that apply)','e')?>
				</strong> <label> <input type="checkbox"
						name="thirty_day_progress_note_topic_for_discussion[]"
						value="<?php xl('Review Patient Current Status','e')?>" /> <?php xl('Review Patient Current Status','e')?> </label> <label> 
						<input type="checkbox" name="thirty_day_progress_note_topic_for_discussion[]" value="<?php xl('Patient Change of Condition','e')?>" /> <?php xl('Patient Change of Condition','e')?>
				</label> <label> <input type="checkbox"
						name="thirty_day_progress_note_topic_for_discussion[]"
						value="<?php xl('Update Plan of Care','e')?>" /> <?php xl('Update Plan of Care','e')?> </label> <label>
						 <input type="checkbox" name="thirty_day_progress_note_topic_for_discussion[]" value="<?php xl('Coordination between Disciplines','e')?>" /> <?php xl('Coordination between Disciplines','e')?>
				</label> <label> <input type="checkbox"
						name="thirty_day_progress_note_topic_for_discussion[]"
						value="<?php xl('Recertification','e')?>" /> <?php xl('Recertification','e')?> </label> <label>
						<input type="checkbox" name="thirty_day_progress_note_topic_for_discussion[]" value="<?php xl('Discharge Plans','e')?>" /> <?php xl('Discharge Plans','e')?>
				</label><br>
				<label> 
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:93%" name="thirty_day_progress_note_topic_for_discussion_other" />
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('DETAILS OF DISCUSSION','e')?>
				</strong><textarea name="thirty_day_progress_note_details_of_discussion" rows="3" cols="100"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('DETAILS FOR RESOLUTIONS/FOLLOW-UP','e')?>
				</strong><textarea name="thirty_day_progress_note_details_for_resolutions" rows="3" cols="100"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('PEOPLE/DISCIPLINES ATTENDING','e')?>
				</strong><textarea name="thirty_day_progress_note_people_descipline_attending" rows="3" cols="100"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top" scope="row"><strong><?php xl('Clinician Name/Title Completing Note','e')?>
				</strong> <input type="text" name="thirty_day_progress_note_clinical_name_title_completing" value=""></td>
				<td colspan="3" valign="top"><strong><?php xl('Electronic Signature','e')?>
				</strong></td>
			</tr>	
		</table>
		<a href="javascript:top.restoreSession();document.thirtyday_progress_note.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
		</form>
</body>

</html>