<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
?>
<html><head>
<?php html_header_show();?>
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
	<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
</head>
<body class="body_top">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_pt_careplan", $_GET["id"]);
?>
<form method="post"
		action="<?php echo $rootdir;?>/forms/ptcareplan/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="careplan">
		 <h3 align="center"><?php xl('PHYSICAL THERAPY CARE PLAN','e')?></h3>
	
	<h5 align="center">
		<?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
		</h5>
		<a href="javascript:top.restoreSession();document.careplan.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
 <br> <br/>
<table align="center"  border="1px" cellspacing="0px" cellpadding="0px">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
  <tr>
    <td align="left" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
    <td width="33%" align="center" valign="top"><input type="text"
					name="patient_name" id="patient_name" value="<?php patientName()?>"
					disabled /></td>
    <td align="left"><strong><?php xl('Onset Date','e')?></strong></td><td width="21%" align="right">
   <input type='text' size='20' name='Onsetdate' id='Onsetdate'    				
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'
					value="<?php echo stripslashes($obj{"Onsetdate"});?>"  readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_onset_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"Onsetdate", ifFormat:"%Y-%m-%d", button:"img_onset_date"});
   </script></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">

      <tr>
        <td align="left" scope="row"><strong>
        <?php xl('Med DX/ Reason for PT intervention','e')?></strong></td>
        <td align="center"><select id="careplan_PT_intervention" name="careplan_PT_intervention">
        <?php ICD9_dropdown(stripslashes($obj{"careplan_PT_intervention"})) ?></select></td>
        <td align="left">
        <strong><?php xl('Treatment Dx','e')?></strong></td>
        <td align="left">
        <select id="careplan_Treatment_DX" name="careplan_Treatment_DX">
        <?php ICD9_dropdown(stripslashes($obj{"careplan_Treatment_DX"})) ?></select></td>
      </tr>
    </table></td>

  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
      <tr>
        <td width="46%" align="left" scope="row"><strong>
        <?php xl('PROBLEMS REQUIRING PT INTERVENTION','e')?></strong></td>         
        <td width="27%" align="left"><strong><?php xl('SOC Date','e')?></strong></td>
        <td width="27%" align="center">
        <input type='text' size='10' name='careplan_SOCDate' id='careplan_SOCDate' 
        			title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly   					 value="<?php echo stripslashes($obj{"careplan_SOCDate"});?>"  readonly/>					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_soc_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"careplan_SOCDate", ifFormat:"%Y-%m-%d", button:"img_soc_date"});
   </script></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" cellspacing="0px">
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Decline_in_mobility" id="careplan_PT_Decline_in_mobility" 
          <?php if ($obj{"careplan_PT_Decline_in_mobility"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Decline in mobility in','e')?><br /></td>
        <td valign="top"><input name="careplan_PT_Decline_in_mobility_Note" type="text" 
         value="<?php echo stripslashes($obj{"careplan_PT_Decline_in_mobility_Note"});?>" />
  &nbsp;</td>
        <td><input type="checkbox" name="careplan_PT_Decline_in_Balance" id="careplan_PT_Decline_in_Balance" 
        <?php if ($obj{"careplan_PT_Decline_in_Balance"} == "on") echo "checked";;?>/>
          <label for="techniques in others">
          <?php xl('Decline in Balance in','e')?></label></td>
        <td><input type="text" name="careplan_PT_Decline_in_Balance_Note" id="careplan_PT_Decline_in_Balance_Note" 
        value="<?php echo stripslashes($obj{"careplan_PT_Decline_in_Balance_Note"});?>" /></td>
      </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Decrease_in_ROM" id="careplan_PT_Decrease_in_ROM" 
           <?php if ($obj{"careplan_PT_Decrease_in_ROM"} == "on") echo "checked";;?>/>
        <?php xl('Decrease in ROM in','e')?></label> </td>
        <td valign="top"><label for="ROM in2"></label>
          <input type="text" name="careplan_PT_Decrease_in_ROM_Note" id="careplan_PT_Decrease_in_ROM_Note" 
          value="<?php echo stripslashes($obj{"careplan_PT_Decrease_in_ROM_Note"});?>" /></td>
        <td valign="top" scope="row">
        <input type="checkbox" name="careplan_PT_Decreased_Safety" id="careplan_PT_Decreased_Safety" 
        <?php if ($obj{"careplan_PT_Decreased_Safety"} == "on") echo "checked";;?>/>
          <label for="checkbox"><?php xl('Decreased Safety in','e')?></label></td>
        <td valign="top">
        <input type="text" name="careplan_PT_Decreased_Safety_Note" id="careplan_PT_Decreased_Safety_Note" 
         value="<?php echo stripslashes($obj{"careplan_PT_Decreased_Safety_Note"});?>" /></td>
        </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Decline_in_Strength" id="careplan_PT_Decline_in_Strength" 
          <?php if ($obj{"careplan_PT_Decline_in_Strength"} == "on") echo "checked";;?>/></label>
          <?php xl('Decline in Strength in','e')?></td>
        <td valign="top"><label for="IADL skills"></label>
          <input type="text" name="careplan_PT_Decline_in_Strength_Note" id="careplan_PT_Decline_in_Strength_Note" 
           value="<?php echo stripslashes($obj{"careplan_PT_Decline_in_Strength_Note"});?>" /></td>
        <td valign="top" scope="row"><?php xl('Other','e')?>
         </td>
        <td valign="top">
        <input type="text" name="careplan_PT_intervention_Other" id="careplan_PT_intervention_Other" 
         value="<?php echo stripslashes($obj{"careplan_PT_intervention_Other"});?>" /></td>
        </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Increased_Pain_with_Movement" id="careplan_PT_Increased_Pain_with_Movement" 
          <?php if ($obj{"careplan_PT_Increased_Pain_with_Movement"} == "on") echo "checked";;?>/>
          <?php xl('Increased Pain with Movement in','e')?></label></td>
        <td colspan="3" valign="top"><label for="Mobility in"></label>
          <input type="text" name="careplan_PT_Increased_Pain_with_Movement_Note" id="careplan_PT_Increased_Pain_with_Movement_Note" 
          value="<?php echo stripslashes($obj{"careplan_PT_Increased_Pain_with_Movement_Note"});?>" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px">
      <tr>
        <td scope="row"><strong><?php xl('TREATMENT PLAN       FREQUENCY','e')?></strong>                
          <input type="text" name="careplan_Treatment_Plan_Frequency" id="careplan_Treatment_Plan_Frequency" 
          value="<?php echo stripslashes($obj{"careplan_Treatment_Plan_Frequency"});?>" />
          <strong><?php xl('DURATION','e')?> </strong>
          <input type="text" name="careplan_Treatment_Plan_Duration" id="careplan_Treatment_Plan_Duration" 
          value="<?php echo stripslashes($obj{"careplan_Treatment_Plan_Duration"});?>" />
          <strong><?php xl('EFFECTIVE DATE','e')?>
          <input type="text" name="careplan_Treatment_Plan_EffectiveDate" id="careplan_Treatment_Plan_EffectiveDate" readonly
          value="<?php echo stripslashes($obj{"careplan_Treatment_Plan_EffectiveDate"});?>" />
 <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_effec_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'> 
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"careplan_Treatment_Plan_EffectiveDate", ifFormat:"%Y-%m-%d", button:"img_effec_date"});
   </script>
          </strong>
          </td>
      </tr>
     </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
      <tr>
        <td scope="row" valign="top" width="30%">
        <input type="checkbox" name="careplan_Evaluation" id="careplan_Evaluation" 
        <?php if ($obj{"careplan_Evaluation"} == "on") echo "checked";;?>/>
<?php xl('Evaluation','e')?>
  </label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Home_Therapeutic_Exercises" id="careplan_Home_Therapeutic_Exercises" 
    <?php if ($obj{"careplan_Home_Therapeutic_Exercises"} == "on") echo "checked";;?>/>
    <?php xl('Home Therapeutic Exercises','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Gait_ReTraining" id="careplan_Gait_ReTraining" 
    <?php if ($obj{"careplan_Gait_ReTraining"} == "on") echo "checked";;?>/>
    </label>
  <?php xl('Gait Re-Training','e')?><br />
  <label>
    <input type="checkbox" name="careplan_Bed_Mobility_Training" id="careplan_Bed_Mobility_Training" 
    <?php if ($obj{"careplan_Bed_Mobility_Training"} == "on") echo "checked";;?>/>
   <?php xl(' Bed Mobility Training','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Transfer_Training"  id="careplan_Transfer_Training" 
    <?php if ($obj{"careplan_Transfer_Training"} == "on") echo "checked";;?>/>
    <?php xl('Transfer Training','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Balance_Training_Activities" id="careplan_Balance_Training_Activities" 
    <?php if ($obj{"careplan_Balance_Training_Activities"} == "on") echo "checked";;?>/>
    <?php xl('Balance Training/Activities','e')?></label>
  <br />
  <input type="checkbox" name="careplan_Patient_Caregiver_Family_Education" id="careplan_Patient_Caregiver_Family_Education" 
  <?php if ($obj{"careplan_Patient_Caregiver_Family_Education"} == "on") echo "checked";;?>/>
  <label for="checkbox2"><?php xl('Patient/Caregiver/Family Education','e')?></label></td>
        <td valign="top" width="33%"><label>
          <input type="checkbox" name="careplan_Assistive_Device_Training" id="careplan_Assistive_Device_Training" 
          <?php if ($obj{"careplan_Assistive_Device_Training"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Assistive Device Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Neuro_developmental_Training" id="careplan_Neuro_developmental_Training" 
            <?php if ($obj{"careplan_Neuro_developmental_Training"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Neuro-developmental Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Orthotics_Splinting" id="careplan_Orthotics_Splinting" 
            <?php if ($obj{"careplan_Orthotics_Splinting"} == "on") echo "checked";;?>/>
            <?php xl('Orthotics/Splinting','e')?></label>
          <br/>
          <label>
            <input type="checkbox" name="careplan_Hip_Safety_Precaution_Training" id="careplan_Hip_Safety_Precaution_Training" 
            <?php if ($obj{"careplan_Hip_Safety_Precaution_Training"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Hip Safety Precaution Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Physical_Agents" id="careplan_Physical_Agents" 
            <?php if ($obj{"careplan_Physical_Agents"} == "on") echo "checked";;?>/>
            <?php xl('Physical Agents','e')?></label>
          <strong>
          <input type="text" name="careplan_Physical_Agents_Name" id="careplan_Physical_Agents_Name" 
         value="<?php echo stripslashes($obj{"careplan_Physical_Agents_Name"});?>" />
          </strong><br />
          &nbsp;  &nbsp;  &nbsp; <?php xl('for','e')?> <strong>
          <input type="text" name="careplan_Physical_Agents_For" id="careplan_Physical_Agents_For" 
           value="<?php echo stripslashes($obj{"careplan_Physical_Agents_For"});?>" />
          </strong><br />
          <label>
            <input type="checkbox" name="careplan_Muscle_ReEducation" id="careplan_Muscle_ReEducation" 
            <?php if ($obj{"careplan_Muscle_ReEducation"} == "on") echo "checked";;?>/>
          <?php xl('Muscle Re-Education','e')?></label></td>
        <td valign="top">
          <label>
            <input type="checkbox" name="careplan_Safe_Stair_Climbing_Skills" id="careplan_Safe_Stair_Climbing_Skills" 
            <?php if ($obj{"careplan_Safe_Stair_Climbing_Skills"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Safe Stair Climbing Skills','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Exercises_to_manage_pain" id="careplan_Exercises_to_manage_pain" 
            <?php if ($obj{"careplan_Exercises_to_manage_pain"} == "on") echo "checked";;?>/>
            <?php xl('Exercises to manage pain','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Fall_Precautions_Training" id="careplan_Fall_Precautions_Training" 
            <?php if ($obj{"careplan_Fall_Precautions_Training"} == "on") echo "checked";;?>/>
</label>
<label>            <?php xl('Fall Precautions Training','e')?><br />

            <input type="checkbox" name="careplan_Exercises_Safety_Techniques_given_patient" id="careplan_Exercises_Safety_Techniques_given_patient" 
            <?php if ($obj{"careplan_Exercises_Safety_Techniques_given_patient"} == "on") echo "checked";;?>/>
            <?php xl('Exercises/ Safety Techniques given to patient','e')?> <br />
          </label>
          <label>          </label>
                  <?php xl('Other','e')?>
            <label for="0checkbox_3_ther"></label>
            <input type="text" name="careplan_PT_Other" id="careplan_PT_Other" value="<?php echo stripslashes($obj{"careplan_PT_Other"});?>" />
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
      <tr>
        <td align="center" scope="row"><strong><?php xl('Short Term Outcomes','e')?> </strong>
         </td>
        <td align="center"><strong><?php xl('Time','e')?></strong></td>
        <td align="center" scope="row"><strong><?php xl('Short Term Outcomes','e')?> </strong>
          </td>
        <td align="center"><strong><?php xl('Time','e')?></strong></td>
        </tr>
      <tr>
        <td rowspan="3" valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_STO_Improve_mobility_skills" id="careplan_STO_Improve_mobility_skills" 
           <?php if ($obj{"careplan_STO_Improve_mobility_skills"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Improve mobility skills in','e')?>
  <label for="textfield2"></label>
          <input type="text" name="careplan_STO_Improve_mobility_skills_In" id="careplan_STO_Improve_mobility_skills_In" 
           value="<?php echo stripslashes($obj{"careplan_STO_Improve_mobility_skills_In"});?>" />
          <?php xl('to','e')?> 
  &nbsp; &nbsp; &nbsp;
  <label for="textfield3"></label>
  <input type="text" name="careplan_STO_Improve_mobility_skills_To" id="careplan_STO_Improve_mobility_skills_To" 
  value="<?php echo stripslashes($obj{"careplan_STO_Improve_mobility_skills_To"});?>" />
         <?php xl(' assist.','e')?><br />
  <label>
    <input type="checkbox" name="careplan_STO_Increase_ROM" id="careplan_STO_Increase_ROM" 
    <?php if ($obj{"careplan_STO_Increase_ROM"} == "on") echo "checked";;?>/>
    </label>
          <?php xl('Increase ROM of','e')?>          
          <label>
            <input type="checkbox" name="careplan_STO_Increase_ROM_Side" value="right" id="careplan_STO_Increase_ROM_Side" 
            <?php if ($obj{"careplan_STO_Increase_ROM_Side"} == "right") echo "checked";;?>/>
            <?php xl('right','e')?></label>
          <label>
            <input type="checkbox" name="careplan_STO_Increase_ROM_Side" value="left" id="careplan_STO_Increase_ROM_Side" 
            <?php if ($obj{"careplan_STO_Increase_ROM_Side"} == "left") echo "checked";;?>/>
            <?php xl('left','e')?></label> 
          <input type="text" name="careplan_STO_Increase_ROM_Note" id="careplan_STO_Increase_ROM_Note" 
          value="<?php echo stripslashes($obj{"careplan_STO_Increase_ROM_Note"});?>" />
          <?php xl('(joints) to','e')?>
          <input type="text" name="careplan_STO_Increase_ROM_To" id="careplan_STO_Increase_ROM_To" 
          value="<?php echo stripslashes($obj{"careplan_STO_Increase_ROM_To"});?>" />
          <?php xl('/WFL','e')?> <br />
          <label>
            <input type="checkbox" name="careplan_STO_Increase_Strength" id="careplan_STO_Increase_Strength" 
            <?php if ($obj{"careplan_STO_Increase_Strength"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Increase Strength','e')?>          
          <label>
            <input type="checkbox" name="careplan_STO_Increase_Strength_Side" value="right" id="careplan_STO_Increase_Strength_Side" 
            <?php if ($obj{"careplan_STO_Increase_Strength_Side"} == "right") echo "checked";;?>/>
            <?php xl('right','e')?></label>
          <label>
            <input type="checkbox" name="careplan_STO_Increase_Strength_Side" value="left" id="careplan_STO_Increase_Strength_Side" 
            <?php if ($obj{"careplan_STO_Increase_Strength_Side"} == "left") echo "checked";;?>/>
            <?php xl('left','e')?></label> 
  			<input type="text" name="careplan_STO_Increase_Strength_Note" id="careplan_STO_Increase_Strength_Note" 
  			value="<?php echo stripslashes($obj{"careplan_STO_Increase_Strength_Note"});?>" />
          <?php xl('to','e')?>
          &nbsp; &nbsp; &nbsp;
          <label for="textfield3"></label>
          <input type="text" name="careplan_STO_Increase_Strength_To" id="careplan_STO_Increase_Strength_To" 
          value="<?php echo stripslashes($obj{"careplan_STO_Increase_Strength_To"});?>" /> 
          <?php xl('/ 5','e')?>
          <label><br />
            <input type="checkbox" name="careplan_STO_Exercises_using_written_handout" id="careplan_STO_Exercises_using_written_handout" 
             <?php if ($obj{"careplan_STO_Exercises_using_written_handout"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Exercises using written handout with','e')?>         
          <input type="text" name="careplan_STO_Exercises_using_written_handout_With" id="careplan_STO_Exercises_using_written_handout_With" 
          value="<?php echo stripslashes($obj{"careplan_STO_Exercises_using_written_handout_With"});?>" />
          <?php xl('verbal/physical prompts','e')?>
          <br />
  <label>
    <input type="checkbox" name="careplan_STO_Improve_home_safety_techniques" id="careplan_STO_Improve_home_safety_techniques" 
    <?php if ($obj{"careplan_STO_Improve_home_safety_techniques"} == "on") echo "checked";;?>/>
    <?php xl('Improve home safety techniques in','e')?></label>
         <input type="text" name="careplan_STO_Improve_home_safety_techniques_In" id="careplan_STO_Improve_home_safety_techniques_In" 
         value="<?php echo stripslashes($obj{"careplan_STO_Improve_home_safety_techniques_In"});?>" />
          <?php xl('to','e')?>
          &nbsp; &nbsp; &nbsp;
          <label for="textfield3"></label>
          <input type="text" name="careplan_STO_Improve_home_safety_techniques_To" id="careplan_STO_Improve_home_safety_techniques_To" 
          value="<?php echo stripslashes($obj{"careplan_STO_Improve_home_safety_techniques_To"});?>" />
          <?php xl('assist.','e')?>        
          <br />
          <label>
    <input type="checkbox" name="careplan_STO_Demonstrate_independent_use_of_prosthesis" id="careplan_STO_Demonstrate_independent_use_of_prosthesis" 
    <?php if ($obj{"careplan_STO_Demonstrate_independent_use_of_prosthesis"} == "on") echo "checked";;?>/>
    <?php xl('Demonstrate independent use of prosthesis/brace/splint','e')?></label>         
          
          
           </td>
        <td rowspan="3">
        <textarea name="careplan_STO_Time" id="careplan_STO_Time" cols="7" rows="18"><?php echo stripslashes($obj{"careplan_STO_Time"});?></textarea></td>
        <td><?php xl('Other','e')?>       
          <input size="20px" type="text" name="careplan_STO_Other" id="careplan_STO_Other" 
          value="<?php echo stripslashes($obj{"careplan_STO_Other"});?>" /></td>
        <td>        
        <textarea name="careplan_STO_Other_Time" id="careplan_STO_Other_Time" cols="7" rows="5"><?php echo stripslashes($obj{"careplan_STO_Other_Time"});?></textarea></td>
      </tr>
      <tr>
        <td colspan="2"><strong><?php xl('Long Term Outcomes','e')?></strong></td>
      </tr>
      <tr>
        <td valign="top"><label>
          <input type="checkbox" name="careplan_LTO_Return_prior_level_function" id="careplan_LTO_Return_prior_level_function" 
          <?php if ($obj{"careplan_LTO_Return_prior_level_function"} == "on") echo "checked";;?>/>
          <?php xl('Return to prior level of function in','e')?></label><label> 
            <input type="text" name="careplan_LTO_Return_prior_level_function_In" id="careplan_LTO_Return_prior_level_function_In" 
             value="<?php echo stripslashes($obj{"careplan_LTO_Return_prior_level_function_In"});?>" />
            <br />
          </label>
          <input type="checkbox" name="careplan_LTO_Demonstrate_ability_follow_home_exercise" id="careplan_LTO_Demonstrate_ability_follow_home_exercise" 
          <?php if ($obj{"careplan_LTO_Demonstrate_ability_follow_home_exercise"} == "on") echo "checked";;?>/>
          <?php xl('Demonstrate ability to follow home exercise program','e')?>
          <br />
          <label>
            <input type="checkbox" name="careplan_LTO_Improve_mobility" id="careplan_LTO_Improve_mobility" 
            <?php if ($obj{"careplan_LTO_Improve_mobility"} == "on") echo "checked";;?>/>
            <?php xl('I','e')?></label>
          <?php xl('Improve mobility in','e')?>
          <label>
            <input type="checkbox" name="careplan_LTO_Improve_mobility_Type" value="home" id="careplan_LTO_Improve_mobility_Type" 
            <?php if ($obj{"careplan_LTO_Improve_mobility_Type"} == "home") echo "checked";;?>/>
           <?php xl('home','e')?></label>
          <label>
            <input type="checkbox" name="careplan_LTO_Improve_mobility_Type" value="community" id="careplan_LTO_Improve_mobility_Type" 
            <?php if ($obj{"careplan_LTO_Improve_mobility_Type"} == "community") echo "checked";;?>/>            
            <?php xl('community','e')?></label>
          <br />
		<input type="checkbox" name="careplan_LTO_Improve_independence_safety_home" id="careplan_LTO_Improve_independence_safety_home" 
		 <?php if ($obj{"careplan_LTO_Improve_independence_safety_home"} == "on") echo "checked";;?>/> 
          <?php xl('Improve independence in safety in home','e')?>
          <br />
         <?php xl(' Others','e')?>
         <input type="text" name="careplan_LTO_Other" id="careplan_LTO_Other" 
          value="<?php echo stripslashes($obj{"careplan_LTO_Other"});?>" /></td>
        <td>
        <textarea name="careplan_LTO_Improve_independence_safety_home_Time" id="careplan_LTO_Improve_independence_safety_home_Time" cols="7" rows="8"><?php echo stripslashes($obj{"careplan_LTO_Improve_independence_safety_home_Time"});?></textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px">
      <tr>        
        <td><strong><?php xl('ADDITIONAL  COMMENTS','e')?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
      <tr>

        <td scope="row"><strong><?php xl('Rehab Potential','e')?></strong>
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Excellent" id="careplan_Rehab_Potential" 
            <?php if ($obj{"careplan_Rehab_Potential"} == "Excellent") echo "checked";;?>/>
            <?php xl('Excellent','e')?></label>
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Good" id="careplan_Rehab_Potential" 
            <?php if ($obj{"careplan_Rehab_Potential"} == "Good") echo "checked";;?>/>
            <?php xl('Good','e')?></label>
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Fair" id="careplan_Rehab_Potential" 
            <?php if ($obj{"careplan_Rehab_Potential"} == "Fair") echo "checked";;?>/>
            <?php xl('Fair','e')?></label>
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Poor" id="careplan_Rehab_Potential" 
            <?php if ($obj{"careplan_Rehab_Potential"} == "Poor") echo "checked";;?>/>
          <?php xl('Poor','e')?></label></td>
        <td><strong><?php xl('Discharge','e')?></strong> <strong>Plan</strong></td>
        <td><input type="checkbox" name="careplan_DP_When_Goals_Are_Met" id="careplan_DP_When_Goals_Are_Met" 
        <?php if ($obj{"careplan_DP_When_Goals_Are_Met"} == "on") echo "checked";;?>/>
		<?php xl('When Goals Are Met Other','e')?> 
      <input type="text" name="careplan_DP_Other" id="careplan_DP_Other" 
      value="<?php echo stripslashes($obj{"careplan_DP_Other"});?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px"">
      <tr>
        <td scope="row"><strong>
        <?php xl('PT Care Plan and Discharge was communicated to and agreed upon by','e')?> </strong>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Patient" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Patient") echo "checked";;?>/>
           <?php xl(' Patient','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Physician" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Physician") echo "checked";;?>/>
            <?php xl('Physician','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="PT/OT/ST" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "PT/OT/ST") echo "checked";;?>/>
            <?php xl('PT/OT/ST','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="COTA" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "COTA") echo "checked";;?>/>
            <?php xl('PTA','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Skilled Nursing" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Skilled Nursing") echo "checked";;?>/>
            <?php xl('Skilled Nursing','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Caregiver/Family" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"Reassessment_Temperature_type"} == "Caregiver/Family") echo "checked";;?>/>
            <?php xl('Caregiver/Family','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Case Manager" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Case Manager") echo "checked";;?>/>
            <?php xl('Case Manager','e')?><br />
            <?php xl('Other','e')?></label>

          <input type="text" name="careplan_PT_communicated_and_agreed_upon_Other" id="careplan_PT_communicated_and_agreed_upon_Other" 
           value="<?php echo stripslashes($obj{"careplan_PT_communicated_and_agreed_upon_Other"});?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px">
      <tr>
        <td scope="row"><strong>
        <?php xl('Patient/Caregiver/Family Response to Care Plan and Occupational Therapy','e')?></strong></td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
      <tr>
        <td width="50%" scope="row"><label>
          <input type="checkbox" name="careplan_Agreeable_to_general_goals" id="careplan_Agreeable_to_general_goals" 
           <?php if ($obj{"careplan_Agreeable_to_general_goals"} == "on") echo "checked";;?>/>
          <?php xl('Agreeable to general goals and treatment plan','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Highly_motivated_to_improve" id="careplan_Highly_motivated_to_improve" 
             <?php if ($obj{"careplan_Highly_motivated_to_improve"} == "on") echo "checked";;?>/>
            <?php xl('Highly motivated to improve','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Supportive_family_caregiver" id="careplan_Supportive_family_caregiver" 
             <?php if ($obj{"careplan_Supportive_family_caregiver"} == "on") echo "checked";;?>/>
          <?php xl('Supportive family/caregiver likely to increase success','e')?></label></td>

        <td width="50%" rowspan="2">
        <input type="checkbox" name="careplan_May_require_additional_treatment" id="careplan_May_require_additional_treatment" 
         <?php if ($obj{"careplan_May_require_additional_treatment"} == "on") echo "checked";;?>/>
          <label for="checkbox"></label>
		<?php xl('May require additional treatment session  to achieve Long Term Outcomes due to','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
 value="Short Term Memory" <?php if ($obj{"careplan_May_require_additional_treatment_dueto"} == "Short Term Memory") echo "checked";;?>/>
<?php xl('short term memory difficulties','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
 value="Minimum support" <?php if ($obj{"careplan_May_require_additional_treatment_dueto"} == "Minimum support") echo "checked";;?>/>
<?php xl('minimal support systems','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
 value="Language Barrier" <?php if ($obj{"careplan_May_require_additional_treatment_dueto"} == "Language Barrier") echo "checked";;?>/>
<?php xl('communication, language  barriers','e')?><br />
<input type="checkbox" name="careplan_Will_address_above_issues" id="careplan_Will_address_above_issues" 
 <?php if ($obj{"careplan_Will_address_above_issues"} == "on") echo "checked";;?>/>
       <?php xl(' Will address above issues by','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
   value="Written Directions" <?php if ($obj{"careplan_Will_address_above_issues_by"} == "Written Directions") echo "checked";;?>/>
        <?php xl('Providing written directions  and/or physical demonstration','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
   value="Community Support" <?php if ($obj{"careplan_Will_address_above_issues_by"} == "Community Support") echo "checked";;?>/>
        <?php xl('establish community  support systems','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
   value="Home Adaptations" <?php if ($obj{"careplan_Will_address_above_issues_by"} == "Home Adaptations") echo "checked";;?>/>
        <?php xl('home/environmental adaptations','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
   value="Use Family" <?php if ($obj{"careplan_Will_address_above_issues_by"} == "Use Family") echo "checked";;?>/>
       <?php xl(' use family/professionals for interpretations as needed','e')?>
        <?php xl('Other','e')?>
          <input type="text" name="careplan_Physician_Orders_Other" id="careplan_Physician_Orders_Other" 
           value="<?php echo stripslashes($obj{"careplan_Physician_Orders_Other"});?>" />   </td>
      </tr>
      <tr>
      <td><strong><?php xl('Physician Orders','e')?> </strong>

        <input type="checkbox" name="careplan_Physician_Orders" id="careplan_Physician_Orders" 
   value="Orders Obtained"  <?php if ($obj{"careplan_Physician_Orders"} == "Orders Obtained") echo "checked";;?>/>
        <label for="Physician Orders Obtained"><?php xl('Physician Orders Obtained','e')?></label>
        <br />
  <input type="checkbox" name="careplan_Physician_Orders" id="careplan_Physician_Orders" 
value="Orders Needed"  <?php if ($obj{"careplan_Physician_Orders"} == "Orders Needed") echo "checked";;?>/>
        <label for="Physician orders needed"><?php xl('Physician orders needed','e')?></label>
        . <strong><?php xl('Will follow agency&rsquo;s procedures for obtaining verbal orders and completing the 485/POC or submitting  supplemental orders for physician signature','e')?></strong></td>

      </tr>
    </table></td>
  
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
      <tr>
        <td width="50%" scope="row"><strong><?php xl('Therapist Who Developed POC','e')?> </strong>(Name and Title)
          </td>
        <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td>

      </tr>
    </table></td>
  </tr>
  
</table>
</form>
</body>
</html>
