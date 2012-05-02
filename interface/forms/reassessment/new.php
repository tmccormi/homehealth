<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: evaluation");
?>

<html>
<head>
<title>OCCUPATIONAL THERAPY REASSESSMENT</title>
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
		action="<?php echo $rootdir;?>/forms/reassessment/save.php?mode=new" name="reassessment">
		<h3 align="center"><?php xl('OCCUPATIONAL THERAPY REASSESSMENT','e'); ?>
		<br>
		<label>
        <input type="checkbox" name="Reassessment_Visit_Count" value="13th Visit" id="Reassessment_Visit_Count" />
		<?php xl('13th Visit','e')?></label><label>
        <input type="checkbox" name="Reassessment_Visit_Count" value="19th Visit" id="Reassessment_Visit_Count" />
        <?php xl('19th Visit','e')?></label><label>
        <input type="checkbox" name="Reassessment_Visit_Count" value="Other Visit" id="Reassessment_Visit_Count" />
        <?php xl('Other Visit','e')?></label></h3>
		<a href="javascript:top.restoreSession();document.reassessment.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
 <br></br> 
<table align="center" border="1" cellpadding="0px" cellspacing="0px">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="0px" cellspacing="0px">
      <tr>

        <td align="center" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
        <td width="13%" align="center" valign="top"><input type="text"
					name="patient_name" id="patient_name" value="<?php patientName()?>"
					disabled /></td>
        <td align="center"><strong><?php xl('MR#','e')?></strong></td>
        <td width="15%" align="center" valign="top" class="bold"><input
					type="text" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" disabled /></td>
					<td align="center"><strong><?php xl('REASSESS DATE','e')?></strong></td>
        <td align="center">
        <input type='text' size='10' name='Reassessment_date' id='Reassessment_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"Reassessment_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script></td>
       </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
<?php xl('Pulse','e')?>
  <label for="pulse"></label>
  <input type="text"  size="3px" name="Reassessment_Pulse" id="Reassessment_Pulse" />
  <label>
    <input type="checkbox" name="Reassessment_Pulse_State" value="Regular" id="Reassessment_Pulse_State" />
    <?php xl('Regular','e')?></label>
  <label>
    <input type="checkbox" name="Reassessment_Pulse_State" value="Irregular" id="Reassessment_Pulse_State" />
    <?php xl('Irregular','e')?></label>
  &nbsp; &nbsp; &nbsp;
     <?php xl('Temperature','e')?>
     <input size="3px" type="text" name="Reassessment_Temperature" id="Reassessment_Temperature" />

     <label>
       <input type="checkbox" name="Reassessment_Temperature_type" value="Oral" id="Reassessment_Temperature_type" />
       <?php xl('Oral','e')?></label>
     <label>
       <input type="checkbox" name="Reassessment_Temperature_type" value="Temporal" id="Reassessment_Temperature_type" />
       <?php xl('Temporal','e')?></label>
&nbsp;  &nbsp;
 &nbsp;   <?php xl('Other','e')?>
 <input type="text" size="3px" name="Reassessment_VS_other" id="Reassessment_VS_other" />

<?php xl('Respirations','e')?>
<input type="text" size="3px" name="Reassessment_VS_Respirations" id="Reassessment_VS_Respirations" />
<br />
<?php xl('Blood Pressure Systolic','e')?>
<input type="text" size="3px" name="Reassessment_VS_BP_Systolic" id="Reassessment_VS_BP_Systolic" />
/
<label>
  <input type="text" size="3px" name="Reassessment_VS_BP_Diastolic" id="Reassessment_VS_BP_Diastolic" />
    <?php xl('Diastolic','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_side" value="Right" id="right" />

  <?php xl('Right','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_side" value="Left" id="left" />
  <?php xl('Left','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Sitting" id="sitting" />
  <?php xl('Sitting','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Standing " id="standing" />

  <?php xl('Standing','e')?> </label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Lying" id="lying" />
  <?php xl('Lying *O2 Sat','e')?>
  <input type="text" size="3px" name="Reassessment_VS_Sat" id="physician" />
</label>
<?php xl('*Physician ordered','e')?></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>

	<input type="checkbox" name="Reassessment_VS_Pain" value="Pain" id="Reassessment_VS_Pain" />
<?php xl('Pain','e')?>
  <input type="checkbox" name="Reassessment_VS_Pain" value="No Pain" id="Reassessment_VS_Pain" />
<?php xl('No Pain','e')?>
<input type="checkbox" name="Reassessment_VS_Pain" value="Pain limits functional ability" id="Reassessment_VS_Pain" />
<?php xl('Pain limits functional ability Intensity','e')?>
<input type="text" size="9px" name="Reassessment_VS_Pain_Intensity" id="Reassessment_VS_Pain_Intensity" />
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="Improve" id="Reassessment_VS_Pain_Intensity_type" />
<?php xl('Improve','e')?>
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="Worse" id="Reassessment_VS_Pain_Intensity_type" />
<?php xl('Worse','e')?>
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="No Change" id="Reassessment_VS_Pain_Intensity_type" />
<?php xl('No Change','e')?></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px">
      <tr>
        <td width="50%" valign="top" scope="row"><strong><?php xl('HOMEBOUND REASON','e')?><br />
        </strong>
          <input type="checkbox" name="Reassessment_HR_Needs_assistance" id="Reassessment_HR_Needs_assistance" />
<?php xl('Needs assistance in all activities','e')?><br />
<input type="checkbox" name="Reassessment_HR_Unable_to_leave_home" id="Reassessment_HR_Unable_to_leave_home" />
<?php xl('Unable to leave home safely unassisted','e')?><br />

<input type="checkbox" name="Reassessment_HR_Medical_Restrictions" id="Reassessment_HR_Medical_Restrictions" />
<?php xl('Medical Restrictions in','e')?> <input type="text" size="30px" name="Reassessment_HR_Medical_Restrictions_In" id="Reassessment_HR_Medical_Restrictions_In" />
<br />
<input type="checkbox" name="Reassessment_HR_SOB_upon_exertion" id="Reassessment_HR_SOB_upon_exertion" />
<?php xl('SOB upon exertion','e')?>
<input type="checkbox" name="Reassessment_HR_Pain_with_Travel" id="Reassessment_HR_Pain_with_Travel" />
<?php xl('Pain with Travel','e')?></td>
        <td width="50%" valign="top">
 <input type="checkbox" name="Reassessment_HR_Requires_assistance" id="Reassessment_HR_Requires_assistance" />
<?php xl('Requires assistance in mobility and ambulation','e')?>
  <br />
  <input type="checkbox" name="Reassessment_HR_Arrhythmia" id="Reassessment_HR_Arrhythmia" />
<?php xl('Arrhythmia','e')?>
<input type="checkbox" name="Reassessment_HR_Bed_Bound" id="Reassessment_HR_Bed_Bound" />

<?php xl('Bed Bound','e')?>
<input type="checkbox" name="Reassessment_HR_Residual_Weakness" id="Reassessment_HR_Residual_Weakness" />
<?php xl('Residual Weakness','e')?>
<br />
<input type="checkbox" name="Reassessment_HR_Confusion"  id="Reassessment_HR_Confusion" />
<?php xl('Confusion, unable to go out of home alone','e')?><br />
<?php xl('Other','e')?>
<input type="text" size="35px" name="Reassessment_HR_Other" id="Reassessment_HR_Other" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>

    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
    <strong><?php xl('TREATMENT DX/Problem','e')?></strong> 
    <select id="Reassessment_TREATMENT_DX_Problem" name="Reassessment_TREATMENT_DX_Problem"><?php ICD9_dropdown($GLOBALS['Selected']) ?></select></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
    <strong><?php xl('ADL/IADL REASSESSMENT','e')?></strong><br />
    </td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="2px">
      <tr>
        <td width="25%" align="center" scope="row"><strong><?php xl('Self Mgt. Skills','e')?></strong></td>
        <td width="13%" align="center"><strong><?php xl('Initial','e')?> </strong><strong>Status</strong></td>
        <td width="13%" align="center"><strong><?php xl('Current Status','e')?></strong></td>

        <td width="49%" align="center"><strong><?php xl('Describe progress related to mobility skills','e')?></strong><br />
          </td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Feeding','e')?></td>
        <td align="center"><strong>
        <select name="Reassessment_ADL_Feeding_Initial_Status" id="Reassessment_ADL_Feeding_Initial_Status">
       <?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>

        <td align="center"><strong>
        <select name="Reassessment_ADL_Feeding_Current_Status" id="Reassessment_ADL_Feeding_Current_Status">
        <?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Feeding_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Feeding_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_Feeding_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Feeding_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_Feeding_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Feeding_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Grooming/Oral Hygiene','e')?></td>

        <td align="center"><strong><select name="Reassessment_ADL_Grooming_Oral_Initial_Status" id="Reassessment_ADL_Grooming_Oral_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Grooming_Oral_Current_Status" id="Reassessment_ADL_Grooming_Oral_Current_Status"><?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Toileting_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Toileting_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_Toileting_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Toileting_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_Toileting_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Toileting_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>

        <td scope="row"><?php xl('Toileting','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Toileting_Initial_Status" id="Reassessment_ADL_Toileting_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Toileting_Current_Status" id="Reassessment_ADL_Toileting_Current_Status"><?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>

      </tr>
      <tr>
        <td scope="row"><?php xl('Bath/shower','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Bath_shower_Initial_Status" id="Reassessment_ADL_Bath_shower_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Bath_shower_Current_Status" id="Reassessment_ADL_Bath_shower_Current_Status"><?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Dressing UB/LB','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Dressing_UB_LB_Initial_Status" id="Reassessment_ADL_Dressing_UB_LB_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Dressing_UB_LB_Current_Status" id="Reassessment_ADL_Dressing_UB_LB_Current_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>

        <td><input type="checkbox" name="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Functional Mobility','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Functional_Mobility_Initial_Status" id="Reassessment_ADL_Functional_Mobility_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>

        <td align="center"><strong><select name="Reassessment_ADL_Functional_Mobility_Current_Status" id="Reassessment_ADL_Functional_Mobility_Current_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Home Mgt (Meals, Phone, Making Bed, Housekeeping)','e')?></td>

        <td align="center"><strong><select name="Reassessment_ADL_Home_Mgt_Initial_Status" id="Reassessment_ADL_Home_Mgt_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Home_Mgt_Current_Status" id="Reassessment_ADL_Home_Mgt_Current_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>

        <td scope="row"><?php xl('Transportation','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Transportation_Initial_Status" id="Reassessment_ADL_Transportation_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Transportation_Current_Status" id="Reassessment_ADL_Transportation_Current_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Transportation_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Transportation_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_Transportation_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Transportation_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_Transportation_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Transportation_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>

      </tr>
      <tr>
        <td scope="row"><?php xl('STANDING BALANCE STATIC/DYNAMIC','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_STANDING_BALANCE_Initial_Status" id="Reassessment_ADL_STANDING_BALANCE_Initial_Status"><?php Balance_skills($GLOBALS['Selected']) ?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_STANDING_BALANCE_Current_Status" id="Reassessment_ADL_STANDING_BALANCE_Current_Status"><?php Balance_skills($GLOBALS['Selected']) ?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('SITTING BALANCE  STATIC/DYNAMIC','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_SITTING_BALANCE_Initial_Status" id="Reassessment_ADL_SITTING_BALANCE_Initial_Status"><?php Balance_skills($GLOBALS['Selected']) ?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_SITTING_BALANCE_Current_Status" id="Reassessment_ADL_SITTING_BALANCE_Current_Status"><?php Balance_skills($GLOBALS['Selected']) ?></select></strong></td>

        <td><input type="checkbox" name="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>

	<input type="checkbox" name="Reassessment_Assistive_Devices" value="N/A" id="Reassessment_Assistive_Devices" />
<strong><?php xl('N/A  Assistive Devices','e')?></strong>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="None" id="Reassessment_Assistive_Devices" />
<?php xl('None','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="W/C" id="Reassessment_Assistive_Devices" />
<?php xl('W/C','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Cane" id="Reassessment_Assistive_Devices" />
<?php xl('Cane Type','e')?>
<label for="textfield"></label>
  <input type="text" size="13px" name="Reassessment_Assistive_Devices_Cane_Type" id="Reassessment_Assistive_Devices_Cane_Type" />

<input type="checkbox" name="Reassessment_Assistive_Devices" value="Walker" id="Walker" />
<?php xl('Walker Type','e')?>
<input type="text" size="13px" name="Reassessment_Assistive_Devices_Walker_Type" id="Reassessment_Assistive_Devices_Walker_Type" />
<?php xl('Other','e')?>
<input type="text" size="13px" name="Reassessment_Assistive_Devices_Other" id="Reassessment_Assistive_Devices_Other" /> <strong><br />
<?php xl('Timed Up and Go Score','e')?></strong>
<input type="text" name="Reassessment_Timed_Up_Go_Score" id="Reassessment_Timed_Up_Go_Score" />
<strong><?php xl('Interpretation','e')?></strong> 
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="No Fall Risk" id="Reassessment_Interpretation_Risk_Types" />
<?php xl('Independent-No Fall Risk (&lt; 11 seconds)','e')?>
<br />
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="Minimal Fall Risk" id="Reassessment_Interpretation_Risk_Types" />
<strong><?php xl('Minimal Fall Risk</strong> (11- 13 seconds)','e')?>

<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="Moderate Fall Risk" id="Reassessment_Interpretation_Risk_Types" />
<strong><?php xl('Moderate Fall Risk </strong>(13.5-19 seconds)','e')?>
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="High Risk for Falls" id="Reassessment_Interpretation_Risk_Types" />
<strong><?php xl('High Risk for Falls','e')?></strong> <?php xl('(&gt;19 seconds)','e')?><br />
<strong><?php xl('Other Tests/Scores/Interpretations','e')?></strong> 
<input type="text" name="Reassessment_Other_Interpretations" size="109px" id="Reassessment_Other_Interpretations" />
<br /> 
<input type="checkbox" name="Reassessment_Interpretation_NA" value="N/A" id="Reassessment_Interpretation_NA" /><strong>
<?php xl('N/A  Patient/Caregiver Continues to Have the Following Problems Achieving Goals with ADLs/IDLs','e')?></strong>
<input type="text" name="Reassessment_Problems_Achieving_Goals" size="149px" id="Reassessment_Problems_Achieving_Goals" /></td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
    <strong><?php xl('ENVIRONMENTAL BARRIERS/SAFETY ISSUES','e')?></strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
	<input type="checkbox" name="Reassessment_Environmental_Barriers" id="Reassessment_Environmental_Barriers" value="No Issues"/>
    <label for="checkbox"><?php xl('No environmental barriers in home','e')?>  
      <input type="checkbox" name="Reassessment_Environmental_Barriers" id="Reassessment_Environmental_Barriers" value="Issues exists"/> 
     <?php xl(' The following environmental issues continue to exist','e')?><br />
    </label>
    <input type="text" name="Reassessment_Environmental_Issues_Notes" size="149px" id="Reassessment_Environmental_Issues_Notes" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
    <strong><?php xl('COMPENSATORY SKILLS','e')?></strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1"  cellspacing="0px" cellpadding="2px">

      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Improved','e')?></strong></td>
        <td align="center"><strong><?php xl('No Change','e')?></strong></td>
        <td align="center"><strong><?php xl('N/A','e')?></strong></td>
        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>

        <td align="center"><strong><?php xl('Improved','e')?></strong></td>
        <td align="center"><strong><?php xl('No Change','e')?></strong></td>
        <td align="center"><strong><?php xl('N/A','e')?></strong></td>
        </tr>
      <tr>
        <td align="center" scope="row"><?php xl('SAFETY AWARENESS','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Safety_Awareness" id="Reassessment_Compensatory_Safety_Awareness" value="Improved"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Safety_Awareness" id="Reassessment_Compensatory_Safety_Awareness" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Safety_Awareness" id="Reassessment_Compensatory_Safety_Awareness" value="N/A"/></td>
        <td align="center"><?php xl('SHORT-TERM MEMORY','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Short_Term_Memory" id="Reassessment_Compensatory_Short_Term_Memory" value="Improved"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Short_Term_Memory" id="Reassessment_Compensatory_Short_Term_Memory" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Short_Term_Memory" id="Reassessment_Compensatory_Short_Term_Memory" value="N/A"/></td>
        </tr>
      <tr>

        <td align="center" scope="row"><?php xl('ATTENTION SPAN','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Attention_Span" id="Reassessment_Compensatory_Attention_Span" value="Improved"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Attention_Span" id="Reassessment_Compensatory_Attention_Span" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Attention_Span" id="Reassessment_Compensatory_Attention_Span" value="N/A"/></td>
        <td align="center"><?php xl('LONG-TERM MEMORY','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Long_Term_Memory" id="Reassessment_Compensatory_Long_Term_Memory" value="Improved"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Long_Term_Memory" id="Reassessment_Compensatory_Long_Term_Memory" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_Long_Term_Memory" id="Reassessment_Compensatory_Long_Term_Memory" value="N/A"/></td>

        </tr>
      <tr>
        <td colspan="8" align="center" scope="row"><strong><?php xl('COMPENSATORY SKILLS FOR','e')?>
        </strong></td>
        </tr>
      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Improved','e')?></strong></td>

        <td align="center"><strong><?php xl('No Change','e')?></strong></td>
        <td align="center"><strong><?php xl('N/A','e')?></strong></td>
        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Improved','e')?></strong></td>
        <td align="center"><strong><?php xl('No Change','e')?></strong></td>
        <td align="center"><strong><?php xl('N/A','e')?></strong></td>

      </tr>
      <tr>
        <td align="center" scope="row"><?php xl('VISION','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Vision" id="Reassessment_Compensatory_For_Vision" value="Improved"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Vision" id="Reassessment_Compensatory_For_Vision" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Vision" id="Reassessment_Compensatory_For_Vision" value="N/A"/></td>
        <td align="center"><?php xl('GROSS MOTOR COORD','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Gross_Motor" id="Reassessment_Compensatory_For_Gross_Motor" value="Improved"/></td>

        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Gross_Motor" id="Reassessment_Compensatory_For_Gross_Motor" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Gross_Motor" id="Reassessment_Compensatory_For_Gross_Motor" value="N/A"/></td>
        </tr>
      <tr>
        <td align="center" scope="row"><?php xl('HEARING','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Hearing" id="Reassessment_Compensatory_For_Hearing" value="Improved"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Hearing" id="Reassessment_Compensatory_For_Hearing" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Hearing" id="Reassessment_Compensatory_For_Hearing" value="N/A"/></td>

        <td align="center"><?php xl('FINE MOTOR COORD','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Fine_Motor" id="Reassessment_Compensatory_For_Fine_Motor" value="Improved"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Fine_Motor" id="Reassessment_Compensatory_For_Fine_Motor" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Fine_Motor" id="Reassessment_Compensatory_For_Fine_Motor" value="N/A"/></td>
        </tr>
      <tr>
        <td align="center" scope="row"><?php xl('ACTIVITY  TOLERANCE','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Activity_Tolerance" id="Reassessment_Compensatory_For_Activity_Tolerance" value="Improved"/></td>

        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Activity_Tolerance" id="Reassessment_Compensatory_For_Activity_Tolerance" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_Activity_Tolerance" id="Reassessment_Compensatory_For_Activity_Tolerance" value="N/A"/></td>
        <td align="center"><?php xl('USE OF ASSISTIVE-  ADAPTIVE DEVICES','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" id="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" value="Improved"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" id="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" value="No Change"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" id="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" value="N/A"/></td>
        </tr>
    </table></td>

  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
	<input type="checkbox" name="Reassessment_Compensatory_NA" id="Reassessment_Compensatory_NA" />
    <label for="checkbox5"><strong>
    <?php xl('N/A   Patient/Caregiver Continues to Have the Following Problems Achieving Goals with the above skills','e')?><br />
      <input type="text" name="Reassessment_Compensatory_Problems_Achieving_Goals" size="149px" id="Reassessment_Compensatory_Problems_Achieving_Goals" />
    </strong></label></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
	<strong><?php xl('MUSCLE STRENGTH/FUNCTIONAL ROM EVALUATION','e')?><br />
      <input type="checkbox" name="Reassessment_MS_ROM_All_Muscle_WFL" value="All Muscle Strength is WFL" id="Reassessment_MS_ROM_All_Muscle_WFL" />
<?php xl('All Muscle Strength is WFL','e')?>
<input type="checkbox" name="Reassessment_MS_ROM_ALL_ROM_WFL" value="All ROM is WFL" id="Reassessment_MS_ROM_ALL_ROM_WFL" />
<?php xl('All ROM is WFL','e')?>
<input type="checkbox" name="Reassessment_MS_ROM_Following_Problem_areas" value="The following problem areas are" id="Reassessment_MS_ROM_Following_Problem_areas" />
<?php xl('The following problem areas are','e')?></strong></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="2px">
      <tr>
        <td rowspan="2" align="center" scope="row"><strong><?php xl('INITIAL  PROBLEM  AREA(S)','e')?></strong></td>
        
        <td colspan="2" align="center"><strong><?php xl('STRENGTH','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('ROM','e')?></strong></td>
        <td colspan="3" align="center"><strong><?php xl('ROM TYPE','e')?></strong></td>

        <td colspan="2" align="center"><strong><?php xl('TONICITY','e')?></strong></td>
        <td rowspan="2" align="center"><strong><?php xl('FURTHER DESCRIPTION','e')?></strong></td>
      </tr>
      <tr>
        <td align="center"><?php xl('R','e')?></td>
        <td align="center"><?php xl('L','e')?></td>
        <td align="center"><?php xl('R','e')?></td>

        <td align="center"><?php xl('L','e')?></td>
        <td align="center"><?php xl('P','e')?></td>
        <td align="center"><?php xl('AA','e')?></td>
        <td align="center"><?php xl('A','e')?></td>
        <td align="center"><strong><?php xl('Hyper','e')?></strong></td>
        <td align="center"><strong><?php xl('Hypo','e')?></strong></td>

        </tr>
      <tr>
        <td align="center" scope="row"><strong>
          <input type="text" name="Reassessment_MS_ROM_Problemarea_text" id="Reassessment_MS_ROM_Problemarea_text" />
        </strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right" />
        <?php xl('/5','e')?></strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left" />
<?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM" id="Reassessment_MS_ROM_ROM" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM" id="Reassessment_MS_ROM_ROM" value="Left"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" value="A"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity" id="Reassessment_MS_ROM_Tonicity" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity" id="Reassessment_MS_ROM_Tonicity" value="Hypo"/></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_Further_description" id="Reassessment_MS_ROM_Further_description" />
        </strong></td>
      </tr>
      <tr>
        <td align="center" scope="row"><strong>
          <input type="text" name="Reassessment_MS_ROM_Problemarea_text1" id="Reassessment_MS_ROM_Problemarea_text1" />
        </strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right1" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right1" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left1" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left1" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM1" id="Reassessment_MS_ROM_ROM1" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM1" id="Reassessment_MS_ROM_ROM1" value="Left"/></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" value="A"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity1" id="Reassessment_MS_ROM_Tonicity1" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity1" id="Reassessment_MS_ROM_Tonicity1" value="Hypo"/></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_Further_description1" id="Reassessment_MS_ROM_Further_description1" />
        </strong></td>
      </tr>

      <tr>
        <td rowspan="2" align="center" scope="row">&nbsp;</th>
          <strong><?php xl('CURRENT  PROBLEM  AREA(S)','e')?></strong>        </td>
        <td colspan="2" align="center"><strong><?php xl('STRENGTH','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('ROM','e')?></strong></td>
        <td colspan="3" align="center"><strong><?php xl('ROM TYPE','e')?></strong></td>

        <td colspan="2" align="center"><strong><?php xl('TONICITY','e')?></strong></td>
        <td rowspan="2" align="center"><strong><?php xl('FURTHER DESCRIPTION','e')?></strong></td>
      </tr>
      <tr>
        <td align="center"><?php xl('R','e')?></td>
        <td align="center"><?php xl('L','e')?></td>
        <td align="center"><?php xl('R','e')?></td>

        <td align="center"><?php xl('L','e')?></td>
        <td align="center"><?php xl('P','e')?></td>
        <td align="center"><?php xl('AA','e')?></td>
        <td align="center"><?php xl('A','e')?></td>
        <td align="center"><strong><?php xl('Hyper','e')?></strong></td>
        <td align="center"><strong><?php xl('Hypo','e')?></strong></td>
		
        </tr>
      <tr>
        <td align="center" scope="row">&nbsp;</th>
          <strong>
            <input type="text" name="Reassessment_MS_ROM_Problemarea_text2" id="Reassessment_MS_ROM_Problemarea_text2" />
            </strong>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right2" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right2" />
          <?php xl('/5','e')?></strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left2" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left2" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM2" id="Reassessment_MS_ROM_ROM2" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM2" id="Reassessment_MS_ROM_ROM2" value="Left"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2" value="A"/></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity2" id="Reassessment_MS_ROM_Tonicity2" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity2" id="Reassessment_MS_ROM_Tonicity2" value="Hypo"/></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_Further_description2" id="Reassessment_MS_ROM_Further_description2" />
        </strong></td>
      </tr>
      <tr>
        <td align="center" scope="row">&nbsp;</th>
          <strong>

            <input type="text" name="Reassessment_MS_ROM_Problemarea_text3" id="Reassessment_MS_ROM_Problemarea_text3" />
            </strong>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right3" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right3" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left3" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left3" />
          <?php xl('/5','e')?></strong></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM3" id="Reassessment_MS_ROM_ROM3" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM3" id="Reassessment_MS_ROM_ROM3" value="Left"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="cupcheck18" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="cupcheck19" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="cupcheck110" value="A"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity3" id="Reassessment_MS_ROM_Tonicity3" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity3" id="Reassessment_MS_ROM_Tonicity3" value="Hypo"/></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_Further_description3" id="Reassessment_MS_ROM_Further_description3" />

        </strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr>
	<td><input type="checkbox" name="Reassessment_MS_ROM_NA" value="N/A" id="Reassessment_MS_ROM_NA" />
<?php xl('N/A  Patient/Caregiver Continues to Have the Following Problems Achieving Goals with','e')?>
  <input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="Strength" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" />
<?php xl('Strength','e')?>

<input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="ROM" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" />
<?php xl('ROM','e')?><br />
<input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="Tone" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" />

<?php xl('Tone','e')?> <strong>
<input type="text" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Note" size="138px" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Note" />
</strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px">
	<tr><td><strong><?php xl('REASSESSMENT OVERVIEW','e')?></strong></td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
	<input type="checkbox" name="Reassessment_RO_Patient_Prior_Level_Function" id="Reassessment_RO_Patient_Prior_Level_Function" 
	value="Yes" />
    <label for="checkbox13"><?php xl('Yes','e')?></label>

    <input type="checkbox" name="Reassessment_RO_Patient_Prior_Level_Function" id="Reassessment_RO_Patient_Prior_Level_Function" value="No"/>
    <label for="checkbox14"><?php xl('No Has Patient Reached Their Prior Level of Function?','e')?><br />
      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" value="Yes" />
      <?php xl('Yes','e')?>
      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" value="No"/>
   <?php xl(' No Has Patient Reached Their Long  Term Goals Established on Admission?','e')?><br />
    <strong><?php xl('Skilled OT continues to be Reasonable and Necessary to','e')?></strong></label>
    <br />

    <input type="checkbox" name="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" value="Return to prior Level" id="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" />
<?php xl('Return Patient to Their Prior Level of Function','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" value="Teach Patient" id="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" />
<?php xl('Teach patient/caregiver compensatory strategies for mobility','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" value="Teach Patient New Skills" id="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" />
<?php xl('Train patient/caregiver in learning new skill','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" value="Make Modifications" id="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" />
<?php xl('Make modifications to current program to achieve short term and long term goals*','e')?>
<label for="checkbox14"><br />
  <?php xl('Other','e')?>
    <strong>
    <input type="text" name="Reassessment_Skilled_OT_Other" size="142px" id="Reassessment_Skilled_OT_Other" />

    </strong></label></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td><strong>
    <?php xl('*Goals Changed/Adapted for ADLs','e')?></strong> <strong>
      <input type="text" name="Reassessment_Goals_Changed_Adapted_For_ADLs" size="108px" id="Reassessment_Goals_Changed_Adapted_For_ADLs" />
      <br />
    </strong>
    <strong><?php xl('ADLs','e')?></strong><strong>

    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_ADLs1" size="141px" id="Reassessment_Goals_Changed_Adapted_For_ADLs1" />
    <br />
    </strong>
    <strong><?php xl('IDLs','e')?>&nbsp;</strong><strong>
    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_IDLs" size="141px" id="Reassessment_Goals_Changed_Adapted_For_IDLs" />
    </strong>
    <strong><br />
    <?php xl('Other','e')?></strong><strong>

    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Other" size="141px" id="Reassessment_Goals_Changed_Adapted_For_Other" />
    </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td><strong>
<?php xl('OT continued treatment plan was communicated to and agreed upon by ','e')?></strong>
      <input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Patient" id="Reassessment_OT_communicated_and_agreed_upon_by" />
<?php xl('Patient','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Physician" id="Reassessment_OT_communicated_and_agreed_upon_by" />
<?php xl('Physician','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="PT/ST" id="Reassessment_OT_communicated_and_agreed_upon_by" />
<?php xl('PT/ST','e')?><br />
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="PTA/COTA" id="Reassessment_OT_communicated_and_agreed_upon_by" />
<?php xl('PTA/COTA','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Skilled Nursing" id="Reassessment_OT_communicated_and_agreed_upon_by" />
<?php xl('Skilled Nursing','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Caregiver/Family" id="Reassessment_OT_communicated_and_agreed_upon_by" />
<?php xl('Caregiver/Family','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Case Manager" id="Reassessment_OT_communicated_and_agreed_upon_by" />
<?php xl('Case Manager Other','e')?></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td><strong>

	<?php xl('ADDITIONAL  SERVICES PROVIDED  THIS VISIT','e')?></strong> 
	<input type="checkbox" name="Reassessment_ADDITIONAL_SERVICES_Home_Exercise" id="Reassessment_ADDITIONAL_SERVICES_Home_Exercise" />
<?php xl('Home Exercise Program Upgraded','e')?>
  <input type="checkbox" name="Reassessment_ADDITIONAL_SERVICES_Recomme_Env_Adaptations"  id="Reassessment_ADDITIONAL_SERVICES_Recomme_Env_Adaptations" />
<?php xl('Recommendations for Environmental Adaptations Reviewed','e')?>
<input type="checkbox" name="Reassessment_ADDITIONAL_SERVICES_Recomme_SafetyIssues" id="Reassessment_ADDITIONAL_SERVICES_Recomme_SafetyIssues" />
<?php xl('Recommendations for Safety Issues Implemented','e')?><br />
<input type="checkbox" name="Reassessment_ADDITIONAL_SERVICES_Treatment" id="Reassessment_ADDITIONAL_SERVICES_Treatment" />

<label for="checkbox17"><?php xl('Treatment for','e')?></label>
<strong>
<input type="text" name="Reassessment_ADDITIONAL_SERVICES_Treatment_for" size="134px" id="Reassessment_ADDITIONAL_SERVICES_Treatment_for" />
      <br />

</strong>
      <?php xl('Other Services Provided','e')?><strong>
      <input type="text" name="Reassessment_Other_Services_Provided" size="123px" id="Reassessment_Other_Services_Provided" />
      </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellpadding="5px" cellspacing="0px"><tr><td width="50%"><strong>
    <?php xl('Therapist Performing Reassessment(Name and Title)','e')?></strong></td>
     
    <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td></tr></table></td>

  </tr>
</table>
</form>
</body>
</html>
