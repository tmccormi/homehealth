<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: clinical_summary");
?>

<html>
<head>
<title><?php xl('CARE PLAN','e')?></title>
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
<form method="post" action="<?php echo $rootdir;?>/forms/clinical_summary/save.php?mode=new" name="clinical_summary">
		<h3 align="center"><?php xl('CLINICAL SUMMARY','e') ?></h3>

<table class="formtable" width="100%" border="0">
<TR valign="top">
<TD>
<u><?php xl('Patient Chart','e') ?></u>
<b><?php xl('Notes','e') ?></b><br />
<textarea name="clinical_summary_notes" rows="2" cols="30"></textarea><br />
</TD>
<TD align="right">
<?php xl('(Select an Action)','e') ?><br />
</TD>
</TR>
<tr>
<td>
<b><?php xl('Patient:','e') ?></b>
<input type="text" name="clinical_summary_patient_name" size="40" value="<?php patientName(); ?>" readonly  /><br />
<b><?php xl('Chart:','e') ?></b>
<input type="text" name="clinical_summary_chart" size="10" />
<b><?php xl('Episode:','e') ?></b>
<input type="text" name="clinical_summary_episode" size="10" />
</td>

<td align="right">
<b><?php xl('Caregiver:','e') ?></b>
<input type="text" name="clinical_summary_caregiver_name" size="25" />

<strong><?php xl('Start of Care Date:','e') ?></strong>
<input type="text" size="12" name="clinical_summary_visit_date" id="clinical_summary_visit_date" value="<?php VisitDate(); ?>" readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"clinical_summary_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr>
</TABLE>


<table class="formtable" width="100%" border="1" cellpadding="5px" cellspacing="0px">

<tr>
<td>
<center><b><?php xl('Background Information','e') ?></b></center>

<?php xl('Case Manager:','e') ?>
<select name="clinical_summary_case_manager" id="clinical_summary_case_manager">
<?php physicianNameDropDown($GLOBALS['Selected']) ?>
</select>
<br />

<?php xl('This is a ','e') ?>
<input type="text" name="clinical_summary_age" size="10" />
<?php xl(' year old ','e') ?>
<label><input type="radio" name="clinical_summary_gender" value="Male"  id="clinical_summary_gender" /> <?php xl('Male','e')?></label>
<label><input type="radio" name="clinical_summary_gender" value="Female"  id="clinical_summary_gender" /> <?php xl('Female','e')?></label>
<?php xl(' with ','e') ?>
<input type="text" name="clinical_summary_hospitalization" size="10" />
<?php xl(' recent hospitalizations.','e') ?><br />
<?php xl('Patient recently admitted to hospital/ rehab facility on ','e') ?>
<input type='text' size='10' name='clinical_summary_admission_date' id='clinical_summary_admission_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"clinical_summary_admission_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
<?php xl(' for ','e') ?>
<input type="text" name="clinical_summary_hospitalization_reason" size="60%" />
<br />
<?php xl('Patient referred to home health by MD for','e') ?>
<input type="text" name="clinical_summary_reffered_reason" size="60%" />
<br /><br />
<label><input type="radio" name="clinical_summary_homebound" value="Patient is homebound due to:"  id="clinical_summary_homebound" /> <?php xl('Patient is homebound due to:','e')?></label>
<input type="text" name="clinical_summary_homebound_due_to" size="60%" /><br />
<label><input type="radio" name="clinical_summary_homebound" value="Patient is NOT homebound - PAYOR SOURCE AWARE"  id="clinical_summary_homebound" /> <?php xl('Patient is NOT homebound - PAYOR SOURCE AWARE','e')?></label>
<BR />
<br />

<center><b><?php xl('Current Information','e') ?></b></center>
<b><?php xl('Patient\'s Current Condition/History of Illness: ','e') ?></b>
<?php xl('(Include pain status, exacerbations, tolerance for activity, cognition, wound sizes and description, neuro-motor deficits)','e') ?>
<br />
<textarea name="clinical_summary_patient_current_condition" rows="4" cols="98"></textarea><br />
<br />
<b><?php xl('Skilled Nurse Needed for: ','e') ?></b><br />

<?php xl('Teaching/Training r/t:','e') ?>
<br />
<textarea name="clinical_summary_teaching_training" rows="4" cols="98"></textarea><br />

<?php xl('Observation/Assessment r/t:','e') ?>
<br />
<textarea name="clinical_summary_observation_assessment" rows="4" cols="98"></textarea><br />

<?php xl('Treatment of:','e') ?>
<br />
<textarea name="clinical_summary_treatment_of" rows="4" cols="98"></textarea><br />

<?php xl('Case Management and Evaluation of:','e') ?>
<br />
<textarea name="clinical_summary_case_management" rows="4" cols="98"></textarea><br />


<?php xl('Patient has able and willing caregiver?:','e') ?>
<label><input type="radio" name="clinical_summary_willing_caregiver" value="Yes"  id="clinical_summary_willing_caregiver" /> <?php xl('Yes','e')?></label>
<label><input type="radio" name="clinical_summary_willing_caregiver" value="No"  id="clinical_summary_willing_caregiver" /> <?php xl('No','e')?></label>



</TD>
</tr>

<tr>
<TD>
<b><?php xl('Caregiver Signature:','e') ?></b>
<input type="text" name="clinical_summary_caregiver_sign" size="40" />
</TD>
</tr>

</table>


<a href="javascript:top.restoreSession();document.clinical_summary.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
