<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: msw_visit_note");
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
<form method="post"		action="<?php echo $rootdir;?>/forms/msw_visit_note/save.php?mode=new" name="msw_visit_note">
		<h3 align="center"><?php xl('MEDICAL SOCIAL SERVICES VISIT NOTE','e')?></h3>
		
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" class="formtable">
<tr>
<td>
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" class="formtable" width="100%">
<td style="border : 0px; width : 30%;"></td>
<td style="border : 0px; width : 70%;">
<table cellspacing="0px" cellpadding="5px"  Style="border : 0px;" width="100%" class="formtable">
<tr>
<td>
<b><?php xl(' Time In ','e') ?></b>
<select name="msw_visit_note_time_in">
<?php timeDropDown($GLOBALS['Selected']) ?>
</select>
</td>
<td>
<b><?php xl(' Time Out ','e') ?></b>
<select name="msw_visit_note_time_out" >
<?php timeDropDown($GLOBALS['Selected']) ?>
</select>
</td>
<td>
<b><?php xl('Date','e') ?></b>
<input type='text' size='10' name='msw_visit_note_date' id='msw_visit_note_date' title='<?php xl('Visit Date','e'); ?>'
				onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"msw_visit_note_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
</td>
</tr>
</table>
</td>
</table>
</td>
</tr>

<tr><td style="padding : 0px;">
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" >
<tr>
<td align="center"><b><?php xl('PATIENT NAME','e') ?></b></td>
<td style="width: 32%;"><input type="text" style="width : 95%;" name="msw_visit_note_patient_name" value="<?php patientName(); ?>" readonly></td>
<td align="center"><b><?php xl('MR#','e') ?></b></td>
<td><input type="text" name="msw_visit_note_mr" style="width : 15%;" value="<?php  echo $_SESSION['pid']?>" readonly /></td>

<td align="center"><strong><?php xl('Start of Care Date','e') ?></strong></td>
<td>
<input type='text' size='12' name='msw_visit_note_soc' id='msw_visit_note_soc' title='<?php xl('Start of Care Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php VisitDate(); ?>' readonly/> 

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"msw_visit_note_soc", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr>
</table>
</td></tr>

<tr>
<td style="padding : 0px;">
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" class="formtable">
<tr>
<td>
<b><?php xl('HOMEBOUND REASON ','e') ?></b><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Needs assistance in all activities','e') ?>" /><?php xl(' Needs assistance in all activities ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Unable to leave home safely without assistance','e') ?>" /><?php xl(' Unable to leave home safely without assistance ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Medical Restrictions','e') ?>" /><?php xl(' Medical Restrictions ','e') ?>
<?php xl(' in ','e') ?> <input type="text" name="msw_visit_note_homebound_reason_in" style="width : 50%;" /><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('SOB upon exertion','e') ?>" /><?php xl(' SOB upon exertion ','e') ?>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Pain with Travel','e') ?>" /><?php xl(' Pain with Travel ','e') ?>
</td>
<td style="border-left : 1px solid #000000">
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Requires assistance in mobility and ambulation','e') ?>" /><?php xl(' Requires assistance in mobility and ambulation ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Arrhythmia','e') ?>" /><?php xl(' Arrhythmia ','e') ?>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Bed Bound','e') ?>" /><?php xl(' Bed Bound ','e') ?>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Residual Weakness','e') ?>" /><?php xl(' Residual Weakness ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Confusion, unable to go out of home alone','e') ?>" /><?php xl(' Confusion, unable to go out of home alone ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" value="<?php xl('Multiple stairs to enter/exit home','e') ?>" /><?php xl(' Multiple stairs to enter/exit home ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_homebound_reason_other" />
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td><b><?php xl('MEDICAL SOCIAL WORKER OBSERVATIONS/ASSESSMENT THIS VISIT ','e') ?></b></td>
</tr>

<tr>
<td>
<b><?php xl('Current Psychological, Social, Health, Financial and Environmental Situation for This Visit ','e')?></b><br/>
<textarea name="msw_visit_note_phychological_health_environmental_situation" rows="3" cols="100"></textarea>
</td>
</tr>

<tr>
<td><b><?php xl('MSW INTERVENTIONS THIS VISIT ','e') ?></b></td>
</tr>

<tr>
<td>
<b><?php xl('Assessment of current ','e') ?></b>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" value="<?php xl('Psychological','e') ?>" /><?php xl(' Psychological ','e') ?>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" value="<?php xl('Social','e') ?>" /><?php xl(' Social ','e') ?>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" value="<?php xl('Health','e') ?>" /><?php xl(' Health ','e') ?>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" value="<?php xl('Financial','e') ?>" /><?php xl(' Financial ','e') ?>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" value="<?php xl('Environmental /Living Situation','e') ?>" /><?php xl(' Environmental /Living Situation ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_asssessment_of_current_other" /><br/>
<b><?php xl('Patient/Caregiver Education: ','e') ?></b>
<input type="checkbox" name="msw_visit_note_patient_education" value="<?php xl('Community Support Groups','e') ?>" /><?php xl(' Community Support Groups ','e') ?>
<input type="checkbox" name="msw_visit_note_patient_education" value="<?php xl('Financial Resources','e') ?>" /><?php xl(' Financial Resources ','e') ?>
<input type="checkbox" name="msw_visit_note_patient_education" value="<?php xl('Alternative Living Situations','e') ?>" /><?php xl(' Alternative Living Situations ','e') ?>
<input type="checkbox" name="msw_visit_note_patient_education" value="<?php xl('Community Resources','e') ?>" /><?php xl(' Community Resources ','e') ?>
<input type="checkbox" name="msw_visit_note_patient_education" value="<?php xl('Other','e') ?>" /><?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_patient_education_other" /><br/>
<b><?php xl('Interventions Including: ','e') ?></b>
<input type="checkbox" name="msw_visit_note_interventions_including" value="<?php xl('Counseling for planning and decision making','e') ?>" /><?php xl(' Counseling for planning and decision making ','e') ?>
<input type="checkbox" name="msw_visit_note_interventions_including" value="<?php xl('Psychological/Emotional Counseling','e') ?>" /><?php xl(' Psychological/Emotional Counseling ','e') ?>
<input type="checkbox" name="msw_visit_note_interventions_including" value="<?php xl('Identification and Reporting of Potential Abuse','e') ?>" /><?php xl(' Identification and Reporting of Potential Abuse ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_interventions_including_other" /><br/>
<b><?php xl('Planning and Organization for: ','e') ?></b>
<input type="checkbox" name="msw_visit_note_planning_and_organization" value="<?php xl('Arrangement of Meal Services','e') ?>" /><?php xl(' Arrangement of Meal Services ','e') ?>
<input type="checkbox" name="msw_visit_note_planning_and_organization" value="<?php xl('Eligibility for State/Federal Services and Benefits','e') ?>" /><?php xl(' Eligibility for State/Federal Services and Benefits ','e') ?>
<input type="checkbox" name="msw_visit_note_planning_and_organization" value="<?php xl('Arrangement for Transportation to Medical/Community Services','e') ?>" /><?php xl(' Arrangement for Transportation to Medical/Community Services ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_planning_and_organization_other" /><br/>
</td>
</tr>

<tr>
<td>
<b><?php xl('ADDITIONAL COMMENTS ','e')?></b><br/>
<textarea name="msw_visit_note_additional_comments" rows="3" cols="100"></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('MSW Visit was communicated to ','e')?></b>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" value="<?php xl('Patient','e') ?>" /><?php xl(' Patient ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" value="<?php xl('Caregiver/Family','e') ?>" /><?php xl(' Caregiver/Family ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" value="<?php xl('Physician','e') ?>" /><?php xl(' Physician ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" value="<?php xl('PT/OT/ST','e') ?>" /><?php xl(' PT/OT/ST ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" value="<?php xl('Skilled Nursing','e') ?>" /><?php xl(' Skilled Nursing ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" value="<?php xl('Case Manager','e') ?>" /><?php xl(' Case Manager ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" name="msw_visit_note_msw_visit_communicated_to_other" style="width : 49%;" />
</td>
</tr>


<tr><td style="padding : 0px;">
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" class="formtable" ><tr>
<td style="width : 50%"><b><?php xl('MSW ','e') ?></b><?php xl(' (Name and Title) ','e') ?></td>
<td style="width : 50%"></td>
</tr></table>
</td></tr>
</table>

<a href="javascript:top.restoreSession();document.msw_visit_note.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
