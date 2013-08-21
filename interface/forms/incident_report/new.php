<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: incident_report");
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
<form method="post"		action="<?php echo $rootdir;?>/forms/incident_report/save.php?mode=new" name="incident_report">
		<h3 align="center"><?php xl('INCIDENT REPORT','e') ?></h3>

<table class="formtable" width="100%" border="0">
<TR valign="top">
<TD>
<b><?php xl('Notes','e') ?></b><br />
<textarea name="incident_report_notes" rows="2" cols="30"></textarea><br />
</TD>

<TD align="right">
<?php xl('(Select an Action)','e') ?><br /><br />
<b><?php xl('Caregiver:','e') ?></b>
<input type="text" name="incident_report_caregiver_name" size="30" />

<strong><?php xl('Start of Care Date:','e') ?></strong>
<input type="text" size="12" title="<?php xl('Start of Care Date','e'); ?>" name="incident_visit_date" id="incident_visit_date" value="<?php VisitDate(); ?>" readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"incident_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</TD>

</tr>
</TABLE>


<table class="formtable" width="100%" border="1" cellpadding="5px" cellspacing="0px">

<tr>
<td colspan="2">

<b><?php xl('Patient\'s  Name:','e') ?></b>
<input type="text" name="incident_report_patient_name" size="50" value="<?php patientName(); ?>" readonly  /><br />
</td>
</tr>

<tr>
<TD>
<b><?php xl('Date of Report:','e') ?></b>
<input type='text' size='10' name='incident_report_date' id='incident_report_date'
                                        title='<?php xl('Incident Report Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>

</TD>
<td>
<b><?php xl('Date of Occurence:','e') ?></b>
<input type='text' size='10' name='incident_report_occurance_date' id='incident_report_occurance_date'
                                        title='<?php xl('Incident Occurance Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date2' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_occurance_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
</td>


</tr>

<tr><TD colspan="2">



<b><?php xl('Patient Related:','e') ?></b><br />
<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('injury','e')?>" />
<?php xl('injury','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('fall/safety concern','e')?>" />
<?php xl('fall/safety concern','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('medication error','e')?>" />
<?php xl('medication error','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('suspected abuse','e')?>" />
<?php xl('suspected abuse','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('potential communicable disease','e')?>" />
<?php xl('potential communicable disease','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('adverse/allergic drug reaction','e')?>" />
<?php xl('adverse/allergic drug reaction','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('pharmacy/equipment/delivery error','e')?>" />
<?php xl('pharmacy/equipment/delivery error','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('venous access infection/sepsis','e')?>" />
<?php xl('venous access infection/sepsis','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('Other:','e')?>" />
<?php xl('Other:','e')?> </label>
<input type="text" name="incident_report_patient_related_other" size="70%"  />

</TD>
</tr>
<tr><TD colspan="2">
<b><?php xl('Description of Occurence','e') ?></b><br />
<textarea name="incident_report_description_occurence" rows="4" cols="98"></textarea><br />
<b><?php xl('Attach additional documentation as needed.','e') ?></b>
</TD></tr>

<tr>
<TD>
<b><?php xl('Notifications:','e') ?></b><br />
<label> <input type="checkbox" name="incident_report_notifications[]" value="<?php xl('Physician Name:','e')?>" />
<?php xl('Physician Name:','e')?> </label>
<input type="text" name="incident_report_not_physician_name" size="30%"  />
</TD>
<td>
<?php xl('Date/Time:','e') ?>
<input type='text' size='10' name='incident_report_not_physician_date' id='incident_report_not_physician_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date3' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_not_physician_date", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
   </script>
</td>
</tr>

<tr>
<TD>
<label> <input type="checkbox" name="incident_report_notifications[]" value="<?php xl('Clinical Supervisor Name:','e')?>" />
<?php xl('Clinical Supervisor Name:','e')?> </label>
<input type="text" name="incident_report_not_supervisor_name" size="30%"  />
</TD>
<td>
<?php xl('Date/Time:','e') ?>
<input type='text' size='10' name='incident_report_not_supervisor_date' id='incident_report_not_supervisor_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date4' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_not_supervisor_date", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
   </script>
</td>
</tr>

<tr>
<TD>
<label> <input type="checkbox" name="incident_report_notifications[]" value="<?php xl('Family/Caregiver Name:','e')?>" />
<?php xl('Family/Caregiver Name:','e')?> </label>
<input type="text" name="incident_report_not_caregiver_name" size="30%"  />
</TD>
<td>
<?php xl('Date/Time:','e') ?>
<input type='text' size='10' name='incident_report_not_caregiver_date' id='incident_report_not_caregiver_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date5' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_not_caregiver_date", ifFormat:"%Y-%m-%d", button:"img_curr_date5"});
   </script>
</td>
</tr>

<tr>
<TD>
<label> <input type="checkbox" name="incident_report_notifications[]" value="<?php xl('Administrative Manager Name:','e')?>" />
<?php xl('Administrative Manager Name:','e')?> </label>
<input type="text" name="incident_report_not_manager_name" size="30%"  />
</TD>
<td>
<?php xl('Date/Time:','e') ?>
<input type='text' size='10' name='incident_report_not_manager_date' id='incident_report_not_manager_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date6' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_not_manager_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6"});
   </script>
</td>
</tr>

<tr><TD colspan="3">
<b><?php xl('Physician Orders Received:','e')?></b>
<input type="text" name="incident_report_physician_orders" size="60%"  /><br />

<b><?php xl('Other actions taken:','e')?></b><br />
<textarea name="incident_report_other_actions_taken" rows="4" cols="98"></textarea><br />

<b><?php xl('Administrative Review/Plan:','e')?></b><br />
<textarea name="incident_report_administrative_review" rows="4" cols="98"></textarea>
</TD></tr>

<tr>
<TD>
<b><?php xl('Signature:','e')?></b><br />
<?php xl('Person Filing Report:','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="incident_report_person_filing_report" size="30%"  />
</TD>
<TD>

<?php xl('Date:','e') ?>
<input type='text' size='10' name='incident_report_filing_report_date' id='incident_report_filing_report_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date7' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_filing_report_date", ifFormat:"%Y-%m-%d", button:"img_curr_date7"});
   </script>
</TD>

</tr>

<tr>
<TD>
<?php xl('Management Reviewer:','e')?>&nbsp;&nbsp;&nbsp;
<input type="text" name="incident_report_management_reviewer" size="30%"  /><br />
</TD>
<TD>

<?php xl('Date:','e') ?>
<input type='text' size='10' name='incident_report_management_reviewer_date' id='incident_report_management_reviewer_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date8' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_management_reviewer_date", ifFormat:"%Y-%m-%d", button:"img_curr_date8"});
   </script>
</TD>

</tr>


<tr>
<TD>
<?php xl('Administrative Reviewer:','e')?>&nbsp;
<input type="text" name="incident_report_admin_reviewer" size="30%"  /><br />
</TD>
<TD>

<?php xl('Date:','e') ?>
<input type='text' size='10' name='incident_report_admin_reviewer_date' id='incident_report_admin_reviewer_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date9' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_admin_reviewer_date", ifFormat:"%Y-%m-%d", button:"img_curr_date9"});
   </script>
</TD>

</tr>

<tr><TD colspan="2">
<?php xl('Caregiver Signature:','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="incident_report_caregiver_sign" size="30%"  />

<input type='text' size='10' name='incident_report_caregiver_sign_date' id='incident_report_caregiver_sign_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date10' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_caregiver_sign_date", ifFormat:"%Y-%m-%d", button:"img_curr_date10"});
   </script>

</TD></tr>

</table>


<a href="javascript:top.restoreSession();document.incident_report.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>


