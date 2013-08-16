<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: dietary_visit");
?>

<html>
<head>
<title><?php xl('DIETARY VISIT','e')?></title>
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
<form method="post"		action="<?php echo $rootdir;?>/forms/dietary_visit/save.php?mode=new" name="dietary_visit">
		<h3 align="center"><?php xl('DIETARY VISIT','e')?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr><td style="padding : 0px;">
<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" class="formtable"><tr>
<td align="center"><b><?php xl('Last Name','e')?></b></td>
<td><input type="text" name="dietary_visit_last_name" value="<?php patientName("lname"); ?>" readonly /></td>
<td align="center"><b><?php xl('First Name','e')?></b></td>
<td><input type="text" name="dietary_visit_first_name" value="<?php patientName("fname"); ?>" readonly></td>

<td align="center"><strong><?php xl('Start of Care Date','e')?></strong></td>
<td>
<input type='text' size='20' title='Start of Care Date' name='dietary_visit_visit_date' id='dietary_visit_visit_date' value="<?php VisitDate(); ?>" readonly  />

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"dietary_visit_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr></table></td></tr>

<tr><td><font style="font-size: 13px;"><b><?php xl('Reason for Visit','e') ?></font></b></td></tr>
<tr><td><b><?php xl('Change in dietary status since last visit or assessment?','e')?></b><br/>
<textarea name="dietary_visit_change_dietary_status_since_last_visit" rows="3" cols="100"></textarea>
</td></tr>

<tr><td><b><?php xl('How much weight has the patient lost since the last visit/assessment?','e')?></b>
<input type="checkbox" name="dietary_visit_patient_weight_lost_since_last_visit" value="<?php xl('No loss','e') ?>"><?php xl('No loss','e') ?>
<input type="checkbox" name="dietary_visit_patient_weight_lost_since_last_visit" value="<?php xl('5 lbs. or less','e') ?>"><?php xl('5 lbs. or less','e') ?>
<input type="checkbox" name="dietary_visit_patient_weight_lost_since_last_visit" value="<?php xl('6-10 lbs.','e') ?>"><?php xl('6-10 lbs.','e') ?>
<input type="checkbox" name="dietary_visit_patient_weight_lost_since_last_visit" value="<?php xl('11-20 lbs.','e') ?>"><?php xl('11-20 lbs.','e') ?>
<input type="checkbox" name="dietary_visit_patient_weight_lost_since_last_visit" value="<?php xl('More than 20 lbs.','e') ?>"><?php xl('More than 20 lbs. Other','e') ?> 
<input type="text" name="dietary_visit_patient_weight_lost_since_last_visit_others">
</td></tr>

<tr><td><b><?php xl('Are there any new factors affecting the patients decline in weight?','e') ?></b>
<input type="checkbox" name="dietary_visit_new_factors_affecting_patient_weight" value="<?php xl('Yes','e') ?>"><?php xl('Yes','e') ?>
<input type="checkbox" name="dietary_visit_new_factors_affecting_patient_weight" value="<?php xl('No','e') ?>"><?php xl('No','e') ?><br/>
<b><?php xl('If Yes what are the factors?','e') ?></b>
<input type="text" name="dietary_visit_new_affecting_factors" style="width: 43%;" />
</td></tr>

<tr><td>
<b><?php xl('Assessment Summary','e')?></b><br/>
<textarea name="dietary_visit_assessment_summary" rows="3" cols="100"></textarea>
</td></tr>

<tr><td>
<b><?php xl('Treatment Plan/Recommendations','e')?></b><br/>
<textarea name="dietary_visit_treatment_plan" rows="3" cols="100"></textarea>
</td></tr>

<tr><td style="padding : 0px;">
<table border="1px solid #000000" Style="border : 0px;" cellspacing="0px" cellpadding="5px" width="100%" class="formtable"><tr>
<td style="width :25%;"><b><?php xl('RD Signature','e')?></b></td>
<td style="width :25%;"></td>
<td style="width :25%;"><b><?php xl('Date','e')?></b></td>
<td style="width :25%;"></td>
</tr></table>
</td></tr>

</table>
<a href="javascript:top.restoreSession();document.dietary_visit.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
