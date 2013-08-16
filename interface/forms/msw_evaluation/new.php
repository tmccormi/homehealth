<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: msw_evaluation");
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
<form method="post"		action="<?php echo $rootdir;?>/forms/msw_evaluation/save.php?mode=new" name="msw_evaluation">
		<h3 align="center"><?php xl('MEDICAL SOCIAL WORKER EVALUATION','e')?></h3>
		
<table cellspacing="0px"  border="1px solid #000000" Style="border : 0px;" width="100%" class="formtable">
<tr>
<td>
<table  border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" class="formtable" width="100%">
<td style="border : 0px; width : 30%;"></td>
<td style="border : 0px; width : 70%;">
<table border="0px" width="100%" class="formtable">
<tr>
<td>
<b><?php xl(' Time In ','e') ?></b>
<select name="msw_evaluation_time_in">
<?php timeDropDown($GLOBALS['Selected']) ?>
</select>
</td>
<td>
<b><?php xl(' Time Out ','e') ?></b>
<select name="msw_evaluation_time_out" >
<?php timeDropDown($GLOBALS['Selected']) ?>
</select>
</td>
<td>
<b><?php xl('Date','e') ?></b>
<input type='text' size='10' name='msw_evaluation_date' id='msw_evaluation_date' title='<?php xl('Evaluation Date','e'); ?>'
				onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"msw_evaluation_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
</td>
</tr>
</table>
</td>
</table>
</td>
</tr>

<tr><td style="padding : 0px;"> 
<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" border="1px solid #000000">
<tr>
<td align="center"><b><?php xl('PATIENT NAME','e') ?></b></td>
<td><input type="text" style="width : 95%;" name="msw_evaluation_patient_name" value="<?php patientName(); ?>" readonly></td>
<td align="center"><b><?php xl('MR#','e') ?></b></td>
<td><input type="text" name="msw_evaluation_mr" style="width : 15%;" value="<?php  echo $_SESSION['pid']?>" readonly /></td>

<td align="center" ><strong><?php xl('Start of Care Date','e') ?></strong></td>
<td>
<input type='text' size='12' name='msw_evaluation_soc' id='msw_evaluation_soc' title='<?php xl('Start of Care Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php VisitDate(); ?>' readonly/> 

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"msw_evaluation_soc", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr>
</table>
</td></tr>

<tr>
<td style="padding : 0px;">
<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" class="formtable">
<tr>
<td>
<b><?php xl('HOMEBOUND REASON ','e') ?></b><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Needs assistance in all activities','e') ?>" /><?php xl(' Needs assistance in all activities ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Unable to leave home safely without assistance','e') ?>" /><?php xl(' Unable to leave home safely without assistance ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Medical Restrictions','e') ?>" /><?php xl(' Medical Restrictions ','e') ?>
<?php xl(' in ','e') ?> <input type="text" name="msw_evaluation_homebound_reason_in" style="width : 50%;" /><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('SOB upon exertion','e') ?>" /><?php xl(' SOB upon exertion ','e') ?>
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Pain with Travel','e') ?>" /><?php xl(' Pain with Travel ','e') ?>
</td>
<td style="border-left : 1px solid #000000">
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Requires assistance in mobility and ambulation','e') ?>" /><?php xl(' Requires assistance in mobility and ambulation ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Arrhythmia','e') ?>" /><?php xl(' Arrhythmia ','e') ?> &nbsp; &nbsp;  &nbsp; 
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Bed Bound','e') ?>" /><?php xl(' Bed Bound ','e') ?>&nbsp; &nbsp;  &nbsp; 
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Residual Weakness','e') ?>" /><?php xl(' Residual Weakness ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Confusion, unable to go out of home alone','e') ?>" /><?php xl(' Confusion, unable to go out of home alone ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" value="<?php xl('Multiple stairs to enter/exit home','e') ?>" /><?php xl(' Multiple stairs to enter/exit home ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_evaluation_homebound_reason_other" />
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td>
<b><?php xl('ORDERS FOR EVALUATION ONLY ','e') ?></b>
<input type="checkbox" name="msw_evaluation_orders_for_evaluation" value="<?php xl('YES','e') ?>" /><b><?php xl(' YES ','e') ?></b>
<input type="checkbox" name="msw_evaluation_orders_for_evaluation" value="<?php xl('NO','e') ?>" /><b><?php xl(' NO ','e') ?></b>&nbsp; &nbsp;  &nbsp; 
<b><?php xl(' IF NO EXPLAIN ORDERS ','e') ?></b>
<input type="text" name="msw_evaluation_if_no_explain_orders" style="width : 22%;" />
</td>
</tr>

<tr>
<td><b><?php xl('PERTINENT BACKGROUND INFORMATION ','e') ?></b></td>
</tr>

<tr>
<td  style="padding : 0px;">
<table width="100%" class="formtable" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td style="width :43%;"><b><?php xl('Medical Diagnosis/Problem ','e') ?></b></td>
<td style="width :57%;"><b><?php xl('Onset ','e') ?></b>
<input type='text' size='10' name='msw_evaluation_medical_diagnosis_problem_onset' id='msw_evaluation_medical_diagnosis_problem_onset' title='<?php xl('Onset Date','e'); ?>'
				onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"msw_evaluation_medical_diagnosis_problem_onset", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
</td>
</tr>
<tr>
<td colspan="2"><textarea name="msw_evaluation_medical_diagnosis_problem" rows="3" cols="100"></textarea></td>
</tr>
</table>
</td>
</tr>

<tr>
<td>
<b><?php xl('Medical/Psychosocial History ','e') ?></b><br/>
<textarea name="msw_evaluation_psychosocial_history" rows="3" cols="100"></textarea><br/>
<b><?php xl('Prior Level of Function (ADL, Community Integration) ','e') ?></b><br/>
<textarea name="msw_evaluation_prior_level_function" rows="3" cols="100"></textarea><br/>
<b><?php xl('PRIOR FAMILY/CAREGIVER SUPPORT ','e') ?></b>
<input type="checkbox" name="msw_evaluation_prior_caregiver_support" value="<?php xl('YES','e') ?>" /><?php xl(' YES ','e') ?>
<input type="checkbox" name="msw_evaluation_prior_caregiver_support" value="<?php xl('NO','e') ?>" /><?php xl(' NO ','e') ?>
&nbsp; &nbsp; &nbsp; <?php xl(' Who ','e') ?>
<input type="text" name="msw_evaluation_prior_caregiver_support_who" style="width : 25%;" />
</td>
</tr>

<tr>
<td><b><?php xl('MEDICAL SOCIAL SERVICES ','e') ?></b></td>
</tr>

<tr>
<td>
<b><?php xl('Psychosocial ','e')?></b><?php xl(' (A description of mental status, coping mechanisms, safety awareness and potential issues, etc.)','e') ?><br/>
<input type="checkbox" name="msw_evaluation_psychosocial" value="<?php xl('Alert','e') ?>" /><?php xl(' Alert ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial" value="<?php xl('Not Alert','e') ?>" /><?php xl(' Not Alert ','e') ?>
&nbsp; &nbsp; &nbsp; <?php xl(' Oriented to ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial_oriented" value="<?php xl('Person','e') ?>" /><?php xl(' Person ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial_oriented" value="<?php xl('Place','e') ?>" /><?php xl(' Place ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial_oriented" value="<?php xl('Date','e') ?>" /><?php xl(' Date ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial_oriented" value="<?php xl('Reason for MSW Intervention','e') ?>" /><?php xl(' Reason for MSW Intervention ','e') ?><br/>
<b><?php xl('Safety Awareness ','e')?></b>
<input type="checkbox" name="msw_evaluation_safety_awareness" value="<?php xl('Good','e') ?>" /><?php xl(' Good ','e') ?>
<input type="checkbox" name="msw_evaluation_safety_awareness" value="<?php xl('Fair','e') ?>" /><?php xl(' Fair ','e') ?>
<input type="checkbox" name="msw_evaluation_safety_awareness" value="<?php xl('Poor','e') ?>" /><?php xl(' Poor ','e') ?><br/>
<textarea name="msw_evaluation_safety_awareness_other" rows="3" cols="100"></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Current Living Situation/Support System ','e')?></b><?php xl(' (Assess relationships, interactions with support services, family communications, etc.) ','e') ?><br/>
<textarea name="msw_evaluation_living_situation_support_system" rows="3" cols="100"></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Health Factors ','e')?></b><?php xl(' (Assess factors that may impede the Plan of Care from being implemented i.e. function, vision, hearing, vision, nutrition, etc.) ','e') ?><br/>
<textarea name="msw_evaluation_health_factors" rows="3" cols="100"></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Environmental Factors ','e')?></b><?php xl(' (Describe factors that impact Plan of Care such as transportation, living situation, support services for environmental management e.g. can assist with upkeep) ','e') ?><br/>
<textarea name="msw_evaluation_environmental_factors" rows="3" cols="100"></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Financial Factors ','e')?></b><?php xl(' (Assess income, assets/expenses, resources that impact Plan of Care) ','e') ?><br/>
<textarea name="msw_evaluation_financial_factors" rows="3" cols="100"></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Additional Information ','e')?></b><br/>
<textarea name="msw_evaluation_additional_information" rows="3" cols="100"></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('MSW Plan of Care and Discharge was communicated to and agreed upon by ','e')?></b>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" value="<?php xl('Patient','e') ?>" /><?php xl(' Patient ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" value="<?php xl('Caregiver/Family','e') ?>" /><?php xl(' Caregiver/Family ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" value="<?php xl('Physician','e') ?>" /><?php xl(' Physician ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" value="<?php xl('PT/OT/ST','e') ?>" /><?php xl(' PT/OT/ST ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" value="<?php xl('Skilled Nursing','e') ?>" /><?php xl(' Skilled Nursing ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" value="<?php xl('Case Manager','e') ?>" /><?php xl(' Case Manager ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated_other" style="width : 49%;" />
</td>
</tr>


<tr><td style="padding : 0px;">
<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" class="formtable"><tr>
<td style="width : 50px;"><b><?php xl('Therapist Who Developed POC ','e') ?></b></td>
<td style="width : 50px;"></td>
</tr></table>
</td></tr>
</table>
<a href="javascript:top.restoreSession();document.msw_evaluation.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
