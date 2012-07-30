<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: physician_face");
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
<form method="post"		action="<?php echo $rootdir;?>/forms/physician_face/save.php?mode=new" name="physician_face">
		<h3 align="center"><?php xl('PHYSICIAN FACE TO FACE ENCOUNTER','e') ?></h3>

<table class="formtable" width="100%" border="0">
<TR>
<TD>
<u><?php xl('Patient Chart','e') ?></u>
<b><?php xl('Notes','e') ?></b><br />
<textarea name="physician_face_notes" rows="2" cols="30"></textarea><br />
</TD>
<TD align="right">
<?php xl('(Select an Action)','e') ?><br />
</TD>
</TR>
<tr>
<TD>
<b><?php xl('Patient:','e') ?></b>
<input type="text" name="physician_face_patient_name" size="50" value="<?php patientName(); ?>" readonly="readonly"  /><br />
<b><?php xl('Chart:','e') ?></b>
<input type="text" name="physician_face_chart" size="10" />
<b><?php xl('Episode:','e') ?></b>
<input type="text" name="physician_face_episode" size="10" />
</TD>
<TD align="right">
<b><?php xl('Date:','e') ?></b>
<input type='text' size='10' name='physician_face_date' id='physician_face_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"physician_face_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
<br />
</TD>
</tr>
</TABLE>


<table class="formtable" width="100%" border="1" cellpadding="5px" cellspacing="0px">
<tr>
<td colspan="2">

<table width="100%" border="0" class="formtable">
<TR>
<TD width="170">
<b><?php xl('Physician Name:','e') ?></b>
</TD>
<td>
<select name="physician_face_physician_name" id="physician_face_physician_name">
<?php physicianNameDropDown($GLOBALS['Selected']) ?>
</select>
</td>
</TR>
<tr>
<TD width="170">
<b><?php xl('Patient Date of Birth:','e') ?></b>
</TD>
<td>
<input type="text" name="physician_face_patient_dob" size="20" value="<?php patientDOB(); ?>" readonly="readonly"  />
</td>
</tr>
<tr>
<TD width="170">
<b><?php xl('SOC Date:','e') ?></b>
</TD>
<td>
<input type="text" name="physician_face_patient_soc" size="20" value="<?php patientDOB(); ?>" readonly="readonly"  />
</td>
</tr>
</table>

<?php xl('I certify that this patient is under my care and that I, or a nurse practitioner or physician\'s assistant working with me, had a face-to-face encounter that meets the physician face-to-face encounter requirements with this patient on:','e') ?>

<input type='text' size='10' name='physician_face_patient_date' id='physician_face_patient_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"physician_face_patient_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
<br /><br />

<?php xl('The encounter with the patient was in whole, or in part, for the following medical condition, which is the primary reason for home health care(List medical condition):','e') ?><br />
<textarea name="physician_face_medical_condition" rows="4" cols="98"></textarea>
<br />
<?php xl('I certify that, based on my findings, the following services are medically necessary home health services:','e') ?>

<TABLE width="100%" class="formtable" border="0">
  <TD><TD>
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Nursing','e')?>" />
<?php xl('Nursing','e')?> </label><br />
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Speech Language Pathology','e')?>" />
<?php xl('Speech Language Pathology','e')?> </label><br />
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Other:','e')?>" />
<?php xl('Other:','e')?> </label>
<input type="text" style="width:60%" name="physician_face_services_other"/>
</TD>

<TD>
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Physical Therapy','e')?>" />
<?php xl('Physical Therapy','e')?> </label><br />
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Medical Social Worker','e')?>" />
<?php xl('Medical Social Worker','e')?> </label><br />
</TD>

<TD>
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Occupational Therapy','e')?>" />
<?php xl('Occupational Therapy','e')?> </label><br />
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Home Health Aide','e')?>" />
<?php xl('Home Health Aide','e')?> </label><br />
</TD>

</tr>
</TABLE>

<?php xl('My clinical findings support the need for the above services because:','e') ?><br />
<textarea name="physician_face_service_reason" rows="4" cols="98">
</textarea>
<br />

<?php xl('Further, I certify that my clinical findings support that this patient is homebound(i.e. absences from home require consikderable and taxing effort and are for medical reasons or religious services or infrequently or of short duration when for other reasons) because:','e') ?><br />
<textarea name="physician_face_clinical_homebound_reason" rows="4" cols="98">
</textarea>

</td>
</tr>

<tr>
<TD>
<b><?php xl('Physician Signature/Date','e') ?></b>
</TD>
<td>
<b><?php xl('Electronic Signature','e') ?></b>
</td>
</tr>

</table>

<a href="javascript:top.restoreSession();document.physician_face.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
