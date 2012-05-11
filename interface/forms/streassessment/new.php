<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: reassessment");
?>

<html>
<head>
<title>SPEECH THERAPY REASSESSMENT</title>
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
		action="<?php echo $rootdir;?>/forms/streassessment/save.php?mode=new" name="reassessment">
		<h3 align="center"><?php xl('SPEECH THERAPY REASSESSMENT','e'); ?>
		<br>
		<label>
        <input type="checkbox" name="Reassessment_visit_type" value="13th Visit" id="Reassessment_visit_type" />
		<?php xl('13th Visit','e')?></label><label>
        <input type="checkbox" name="Reassessment_visit_type" value="19th Visit" id="Reassessment_visit_type" />
        <?php xl('19th Visit','e')?></label><label>
        <input type="checkbox" name="Reassessment_visit_type" value="Other Visit" id="Reassessment_visit_type" />
        <?php xl('Other Visit','e')?></label></h3>
		<a href="javascript:top.restoreSession();document.reassessment.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
 <br></br> 
<table  align="center" border="1" cellpadding="0px" cellspacing="0px">
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
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/> 
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
  <input type="checkbox" name="Reassessment_VS_BP_side" value="Right" id="right" />

  <?php xl('Right','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_side" value="Left" id="left" />
  <?php xl('Left','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Sitting" id="sitting" />
  <?php xl('Sitting','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Standing " id="standing" />

  <?php xl('Standing','e')?> </label>

  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Lying" id="lying" />
  <?php xl('Lying *O2 Sat','e')?>
  <input type="text" size="3px" name="Reassessment_VS_Sat" id="physician" />

<?php xl('*Physician ordered','e')?></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>

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
<br />
<?php xl('Other','e')?>
<input type="text" size="35px" name="Reassessment_HR_Other" id="Reassessment_HR_Other" /></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>

   <strong><?php xl('SPEECH/LANGUAGE/DYSPHAGIA REVIEW','e')?></strong><br />
    <strong><?php xl('Drop Down Scale Grades','e')?>  </strong>
    <?php xl('5 = WFL = within functional limits 4 = WFL with cues 3 = Mild impairment 2 = Moderate impairment 1 = Severe impairment 0 = Unable or Not Tested','e')?>
    </strong></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="2px">
      <tr>
        <td width="25%" align="center" scope="row"><strong><?php xl('Swallow/Communication Skills','e')?></strong></td>
        <td width="13%" align="center"><strong><?php xl('Initial','e')?> </strong><strong><?php xl('Status','e')?></strong></td>
        <td width="13%" align="center"><strong><?php xl('Current Status','e')?></strong></td>
        <td width="49%" align="center"><strong><?php xl('Describe progress related to mobility skills','e')?></strong><br />
        </td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Oral Stage Mgmt','e')?></td>
        <td align="center"><strong>
        <select name="Reassessment_SDL_Oral_Stage_Initial_Status" id="Reassessment_SDL_Oral_Stage_Initial_Status">
       <?php Communication_status($GLOBALS['Selected'])?></select></strong></td>

        <td align="center"><strong>
        <select name="Reassessment_SDL_Oral_Stage_Current_Status" id="Reassessment_SDL_Oral_Stage_Current_Status">
        <?php Communication_status($GLOBALS['Selected'])	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills" value="N/A" id="Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills" value="Goal met" id="Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_SDL_Oral_Stage_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Pharyngeal Stage Mgmt','e')?></td>

        <td align="center"><strong><select name="Reassessment_SDL_Pharyngeal_Stage_Initial_Status" id="Reassessment_SDL_Pharyngeal_Stage_Initial_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_SDL_Pharyngeal_Stage_Current_Status" id="Reassessment_SDL_Pharyngeal_Stage_Current_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills" value="N/A" id="Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills" value="Goal met" id="Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_SDL_Pharyngeal_Stage_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>

 <tr>
        <td scope="row"><?php xl('','e')?></td>
        <td align="center"><strong><select name="Reassessment_SDL_Space1_Initial_Status" id="Reassessment_SDL_Space1_Initial_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_SDL_Space1_Current_Status" id="Reassessment_SDL_Space1_Current_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_SDL_Space1_Describe_Mobility_Skills" value="N/A" id="Reassessment_SDL_Space1_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_SDL_Space1_Describe_Mobility_Skills" value="Goal met" id="Reassessment_SDL_Space1_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_SDL_Space1_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_SDL_Space1_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>


      <tr>
        <td scope="row"><?php xl('Verbal Expression','e')?></td>
        <td align="center"><strong><select name="Reassessment_SDL_Verbal_Expression_Initial_Status" id="Reassessment_SDL_Verbal_Expression_Initial_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_SDL_Verbal_Expression_Current_Status" id="Reassessment_SDL_Verbal_Expression_Current_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills" value="N/A" id="Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills" value="Goal met" id="Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_SDL_Verbal_Expression_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>

      </tr>
     
      <tr>
        <td scope="row"><?php xl('Non-Verbal Expression','e')?></td>
        <td align="center"><strong><select name="Reassessment_SDL_NonVerbal_Expression_Initial_Status" id="Reassessment_SDL_NonVerbal_Expression_Initial_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_SDL_NonVerbal_Expression_Current_Status" id="Reassessment_SDL_NonVerbal_Expression_Current_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>

        <td><input type="checkbox" name="Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills" value="N/A" id="Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills" value="Goal met" id="Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_SDL_NonVerbal_Expression_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>

      <tr>
        <td scope="row"><?php xl('Auditory Comprehension','e')?></td>
        <td align="center"><strong><select name="Reassessment_SDL_Auditory_Comprehension_Initial_Status" id="Reassessment_SDL_Auditory_Comprehension_Initial_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>

        <td align="center"><strong><select name="Reassessment_SDL_Auditory_Comprehension_Current_Status" id="Reassessment_SDL_Auditory_Comprehension_Current_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills" value="N/A" id="Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills" value="Goal met" id="Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_SDL_Auditory_Comprehension_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Speech Intelligibility','e')?></td>

        <td align="center"><strong><select name="Reassessment_SDL_Speech_Intelligibility_Initial_Status" id="Reassessment_SDL_Speech_Intelligibility_Initial_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_SDL_Speech_Intelligibility_Current_Status" id="Reassessment_SDL_Speech_Intelligibility_Current_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills" value="N/A" id="Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills" value="Goal met" id="Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_SDL_Speech_Intelligibility_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>    


<tr>
        <td scope="row"><?php xl('','e')?></td>

        <td align="center"><strong><select name="Reassessment_SDL_Space2_Initial_Status" id="Reassessment_SDL_Space2_Initial_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_SDL_Space2_Current_Status" id="Reassessment_SDL_Space2_Current_Status">
<?php Communication_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_SDL_Space2_Describe_Mobility_Skills" value="N/A" id="Reassessment_SDL_Space2_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>
  <input type="checkbox" name="Reassessment_SDL_Space2_Describe_Mobility_Skills" value="Goal met" id="Reassessment_SDL_Space2_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>
<input type="checkbox" name="Reassessment_SDL_Space2_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_SDL_Space2_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>       
    </table></td>
  </tr>

<tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
	<input type="checkbox" name="Reassessment_Dysphagia_Review_NA" id="Reassessment_Dysphagia_Review_NA" />
    <?php xl('N/A Patient/Caregiver Continues to Have the Following Problems Achieving Goals with','e')?>
<br/>
<?php xl('Speech/Language/Dysphagia Issues','e')?>
      <input type="text" name="Reassessment_Speech_Language_Dysphagia_Issues" size="50%" id="Reassessment_Speech_Language_Dysphagia_Issues" />
    </strong></label></td></tr></table></td>
  </tr>

 
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td>
    <strong><?php xl('COMPENSATORY SKILLS FOR','e')?></strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1"  cellspacing="0px" cellpadding="2px">

      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Improved','e')?></strong></td>
        <td align="center"><strong><?php xl('No Change','e')?></strong></td> 
	<td align="center"><strong><?php xl('N/A','e')?></strong></td>
      
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Improved','e')?></strong></td>
        <td align="center"><strong><?php xl('No Change','e')?></strong></td> 
	<td align="center"><strong><?php xl('N/A','e')?></strong></td>
       </tr>
      <tr>
        <td align="center" scope="row"><?php xl('SAFETY AWARENESS','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_SAFETY_AWARENESS" value="Improved" id="Reassessment_Skills_SAFETY_AWARENESS" /></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_SAFETY_AWARENESS" value="No Change" id="Reassessment_Skills_SAFETY_AWARENESS"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_SAFETY_AWARENESS" value="N/A" id="Reassessment_Skills_SAFETY_AWARENESS"/></td>


	<td align="center" scope="row"><?php xl('SHORT-TERM MEMORY','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_SHORTTERM_MEMORY" value="Improved" id="Reassessment_Skills_SHORTTERM_MEMORY" /></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_SHORTTERM_MEMORY" value="No Change" id="Reassessment_Skills_SHORTTERM_MEMORY"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_SHORTTERM_MEMORY" value="N/A" id="Reassessment_Skills_SHORTTERM_MEMORY"/></td>
        </tr>

       <tr>
         <td align="center" scope="row"><?php xl('ATTENTION SPAN','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_ATTENTION_SPAN" value="Improved" id="Reassessment_Skills_ATTENTION_SPAN" /></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_ATTENTION_SPAN" value="No Change" id="Reassessment_Skills_ATTENTION_SPAN"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_ATTENTION_SPAN" value="N/A" id="Reassessment_Skills_ATTENTION_SPAN"/></td>


	<td align="center" scope="row"><?php xl('LONG-TERM MEMORY','e')?></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_LONGTERM_MEMORY" value="Improved" id="Reassessment_Skills_LONGTERM_MEMORY" /></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_LONGTERM_MEMORY" value="No Change" id="Reassessment_Skills_LONGTERM_MEMORY"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_Skills_LONGTERM_MEMORY" value="N/A" id="Reassessment_Skills_LONGTERM_MEMORY"/></td>
        </tr>
         </table></td>

  </tr>
  
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr>
	<td>
<input type="checkbox" name="Reassessment_COMPENSATORY_SKILLS_NA" id="Reassessment_COMPENSATORY_SKILLS_NA" />
<?php xl('N/A   Patient/Caregiver Continues to Have the Following Problems Achieving Goals with the above skills','e')?>
 <br/>
<textarea name="Reassessment_CS_Problems_Achieving_Goals_With" rows="3" cols="100" id="Reassessment_CS_Problems_Achieving_Goals_With"></textarea>
</td></tr></table></td>
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
    <label for="checkbox14"><?php xl('No Has Patient Reached Their Prior Level of Function?','e')?></label><br />

      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" value="Yes" />
      <?php xl('Yes','e')?>
      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" value="No"/>
   <?php xl(' No Has Patient Reached Their Long  Term Goals Established on Admission?','e')?><br />
    <strong><?php xl('Skilled ST continues to be Reasonable and Necessary to','e')?></strong>
    <br />

    <input type="checkbox" name="Reassessment_Skilled_ST_Reasonable_And_Necessary_To" value="Return to prior Level" id="Reassessment_Skilled_ST_Reasonable_And_Necessary_To" />
<?php xl('Return Patient to Their Prior Level of Function','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_ST_Reasonable_And_Necessary_To" value="Teach Patient" id="Reassessment_Skilled_ST_Reasonable_And_Necessary_To" />
<?php xl('Teach patient/caregiver compensatory strategies for mobility','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" size="30%" name="Reassessment_Skilled_ST_Compensatory_Strategies_Note" id="Reassessment_Skilled_ST_Compensatory_Strategies_Note"/>
<br />
<input type="checkbox" name="Reassessment_Skilled_ST_Reasonable_And_Necessary_To" value="Teach Patient New Skills" id="Reassessment_Skilled_ST_Reasonable_And_Necessary_To" />
<?php xl('Train patient/caregiver in learning new skills','e')?> &nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" size="40%" name="Reassessment_Skilled_ST_Learning_New_Skills" id="Reassessment_Skilled_ST_Learning_New_Skills"/>
<br />
<input type="checkbox" name="Reassessment_Skilled_ST_Reasonable_And_Necessary_To" value="Make Modifications" id="Reassessment_Skilled_ST_Reasonable_And_Necessary_To" />
<?php xl('Make modifications to current program to achieve short term and long term goals*','e')?>
<label for="checkbox14"><br />
  <?php xl('Other','e')?>
    <strong>
    <input type="text" name="Reassessment_Skilled_ST_Other" size="70%" id="Reassessment_Skilled_ST_Other" />

    </strong></label></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td><strong>
    <?php xl('*Goals Changed/Adapted for Dysphagia','e')?></strong> <strong>
      <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Dysphagia" size="45%" id="Reassessment_Goals_Changed_Adapted_For_Dysphagia" />
      <br />
    </strong>
    <strong><?php xl('Communication','e')?></strong><strong>

    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Communication" size="70%" id="Reassessment_Goals_Changed_Adapted_For_Communication" />
    <br />
    </strong>
    <strong><?php xl('Cognition','e')?>&nbsp;</strong><strong>
    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Cognition" size="75%" id="Reassessment_Goals_Changed_Adapted_For_Cognition" />
    </strong>
    <strong><br />
    <?php xl('Other','e')?></strong><strong>
    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Other" size="80%" id="Reassessment_Goals_Changed_Adapted_For_Other" />
    </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td><strong><?php xl('ST continued treatment plan was communicated to and agreed upon by ','e')?></strong>
      <input type="checkbox" name="Reassessment_ST_communicated_and_agreed_upon_by" value="Patient" id="Reassessment_ST_communicated_and_agreed_upon_by" />
<?php xl('Patient','e')?>
<input type="checkbox" name="Reassessment_ST_communicated_and_agreed_upon_by" value="Physician" id="Reassessment_ST_communicated_and_agreed_upon_by" />
<?php xl('Physician','e')?>
<input type="checkbox" name="Reassessment_ST_communicated_and_agreed_upon_by" value="PT/OT" id="Reassessment_ST_communicated_and_agreed_upon_by" />
<?php xl('PT/OT','e')?>
<input type="checkbox" name="Reassessment_ST_communicated_and_agreed_upon_by" value="PTA/COTA" id="Reassessment_ST_communicated_and_agreed_upon_by" />
<?php xl('PTA/COTA','e')?>
<input type="checkbox" name="Reassessment_ST_communicated_and_agreed_upon_by" value="Skilled Nursing" id="Reassessment_ST_communicated_and_agreed_upon_by" />
<?php xl('Skilled Nursing','e')?>
<input type="checkbox" name="Reassessment_ST_communicated_and_agreed_upon_by" value="Caregiver/Family" id="Reassessment_ST_communicated_and_agreed_upon_by" />
<?php xl('Caregiver/Family','e')?>
<input type="checkbox" name="Reassessment_ST_communicated_and_agreed_upon_by" value="Case Manager" id="Reassessment_ST_communicated_and_agreed_upon_by" />
<?php xl('Case Manager','e')?><br/>
<?php xl('Other','e')?> <input type="text" name="Reassessment_ST_communicated_and_agreed_upon_by_other"  id="Reassessment_ST_communicated_and_agreed_upon_by_other"/></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px"><tr><td><strong>

	<?php xl('ADDITIONAL  SERVICES PROVIDED  THIS VISIT','e')?></strong> 
	<input type="checkbox" name="Reassessment_AS_Compensatory_Swallow_Program" id="Reassessment_AS_Compensatory_Swallow_Program" />
<?php xl('Compensatory Swallow Program Upgraded','e')?>
 <br/> <input type="checkbox" name="Reassessment_AS_Recommendations_for_Communication" id="Reassessment_AS_Recommendations_for_Communication" />
<?php xl('Recommendations for for Communication Strategies Reviewed','e')?>
<input type="checkbox" name="Reassessment_AS_Recommendations_for_Cognitive" id="Reassessment_AS_Recommendations_for_Cognitive" />
<?php xl('Recommendations for Cognitive Impairment Management','e')?>
<br/><input type="checkbox" name="Reassessment_AS_Treatment" id="Reassessment_AS_Treatment" />
<?php xl('Treatment for','e')?>
<strong>
<input type="text" name="Reassessment_AS_Treatment_for" size="60%" id="Reassessment_AS_Treatment_for" />
      <br />

</strong>
      <?php xl('Other Services Provided','e')?><strong>
      <input type="text" name="Reassessment_Other_Services_Provided" size="60%" id="Reassessment_Other_Services_Provided" />
      </strong></td></tr></table></td>
  </tr>

<tr>
<td>
<strong><?php xl('ADDITIONAL COMMENTS','e')?></strong>
<textarea name="Reassessment_ADDITIONAL_COMMENTS" rows="5" cols="100" id="Reassessment_ADDITIONAL_COMMENTS"></textarea>
</td>
</tr>

  <tr>
    <td scope="row"><table border="1px" cellpadding="5px" cellspacing="0px" width="100%"><tr><td width="57%"><strong>
    <?php xl('Therapist Performing Reassessment(Name and Title)','e')?></strong>   </td> 
    <td><strong><?php xl('Electronic Signature','e')?></strong></td></tr></table></td>
  </tr>
</table>
</form>
</body>
</html>
