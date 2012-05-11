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
$obj = formFetch("forms_st_careplan", $_GET["id"]);
?>
<form method="post"
		action="<?php echo $rootdir;?>/forms/stcareplan/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="careplan">
		<h3 align="center"> <?php xl('SPEECH THERAPY CARE PLAN','e')?> </h3>
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

        <td align="center" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
        <td width="13%" align="center" valign="top"><input type="text"
					name="patient_name" id="patient_name" value="<?php patientName()?>"
					disabled /></td>
        <td align="center"><strong><?php xl('MR#','e')?></strong></td>
        <td width="15%" align="center" valign="top" class="bold"><input
					type="text" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" disabled /></td>
					<td align="center"><strong><?php xl('DATE','e')?></strong></td>
        <td align="center">
        <input type='text' size='10' name='stdate' id='stdate' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  
value="<?php echo stripslashes($obj{"stdate"});?>"  readonly/>
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"stdate", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script></td>
       </tr>
</table>
</td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">

      <tr>
        <td align="left" scope="row"><strong>
        <?php xl('Med DX/ Reason for ST intervention','e')?></strong></td>
        <td align="center"><select id="careplan_ST_intervention" name="careplan_ST_intervention">
        <?php ICD9_dropdown(stripslashes($obj{"careplan_ST_intervention"})) ?></select></td>
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
        <?php xl('PROBLEMS REQUIRING ST INTERVENTION','e')?></strong></td>         
        <td width="27%" align="left"><strong><?php xl('SOC Date','e')?></strong></td>
        <td width="27%" align="center">
        <input type='text' size='10' name='careplan_SOCDate' id='careplan_SOCDate' 
        			title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'
value="<?php echo stripslashes($obj{"careplan_SOCDate"});?>"  readonly/>					
<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
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
    <td border="1" scope="row"><table width="100%" border="0px" cellpadding="5px" cellspacing="0px">
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_ST_Decline_in_Oral_Stage_Skills" id="careplan_ST_Decline_in_Oral_Stage_Skills" 
          <?php if ($obj{"careplan_ST_Decline_in_Oral_Stage_Skills"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Decline in Oral Stage Skills','e')?><br /></td>
        <td valign="top"><input name="careplan_ST_Decline_in_Oral_Stage_Skills_Notes" type="text" 
         value="<?php echo stripslashes($obj{"careplan_ST_Decline_in_Oral_Stage_Skills_Notes"});?>" />
  &nbsp;</td>
 <td valign="top" scope="row">
      <input type="checkbox" name="careplan_ST_Decreased_Comprehension" id="careplan_ST_Decreased_Comprehension" 
<?php if ($obj{"careplan_ST_Decreased_Comprehension"} == "on") echo "checked";;?>/>
      <?php xl('Decreased Comprehension in','e')?>
          </td>
        <td valign="top"><input type="text" name="careplan_ST_Decreased_Comprehension_Note" id="careplan_ST_Decreased_Comprehension_Note" 
 value="<?php echo stripslashes($obj{"careplan_ST_Decreased_Comprehension_Note"});?>" /></td>
     </tr>
<tr>
        <td><input type="checkbox" name="careplan_ST_Decrease_in_Pharyngeal_Stage" id="careplan_ST_Decrease_in_Pharyngeal_Stage" 
        <?php if ($obj{"careplan_ST_Decrease_in_Pharyngeal_Stage"} == "on") echo "checked";;?>/>
          <label for="techniques in others">
          <?php xl('Decrease in Pharyngeal Stage Skills','e')?></label></td>
        <td><input type="text" name="careplan_ST_Decrease_in_Pharyngeal_Stage_Note" id="careplan_ST_Decrease_in_Pharyngeal_Stage_Note" 
        value="<?php echo stripslashes($obj{"careplan_ST_Decrease_in_Pharyngeal_Stage_Note"});?>" /></td>
      <td valign="top" scope="row">
	<?php xl('Others','e')?> </td>
	  <td>
	  <input type="text" name="careplan_ST_intervention_Other" id="careplan_ST_intervention_Other" 
    value="<?php echo stripslashes($obj{"careplan_ST_intervention_Other"});?>" />
          </td>
      	</tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_ST_Decline_in_Verbal_Expression" id="careplan_ST_Decline_in_Verbal_Expression" 
           <?php if ($obj{"careplan_ST_Decline_in_Verbal_Expression"} == "on") echo "checked";;?>/>
        <?php xl('Decline in Verbal Expression','e')?></label> </td>
        <td valign="top"><label for="ROM in2"></label>
          <input type="text" name="careplan_ST_Decline_in_Verbal_Expression_Note" id="careplan_ST_Decline_in_Verbal_Expression_Note" 
          value="<?php echo stripslashes($obj{"careplan_ST_Decline_in_Verbal_Expression_Note"});?>" /></td>
	    <td valign="top" scope="row">
	<?php xl('Others','e')?> </td>
	  <td>
	  <input type="text" name="careplan_ST_intervention_Other1" id="careplan_ST_intervention_Other1" 
     value="<?php echo stripslashes($obj{"careplan_ST_intervention_Other1"});?>" />
          </td>
      </tr> 

      <tr> 
 <td valign="top" scope="row">
        <input type="checkbox" name="careplan_ST_Decline_in_NonVerbal_Expression" id="careplan_ST_Decline_in_NonVerbal_Expression" 
        <?php if ($obj{"careplan_ST_Decline_in_NonVerbal_Expression"} == "on") echo "checked";;?>/>
          <label for="checkbox"><?php xl('Decline in Non-Verbal Expression','e')?></label></td>
        <td valign="top">
        <input type="text" name="careplan_ST_Decline_in_NonVerbal_Expression_Note" id="careplan_ST_Decline_in_NonVerbal_Expression_Note" 
         value="<?php echo stripslashes($obj{"careplan_ST_Decline_in_NonVerbal_Expression_Note"});?>" /></td>
        </tr>
     
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
      <tr>
        <td scope="row"><strong><?php xl('TREATMENT PLAN  FREQUENCY','e')?></strong>                
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
    <input type="checkbox" name="careplan_Dysphagia_Compensatory_Strategies" id="careplan_Dysphagia_Compensatory_Strategies" 
    <?php if ($obj{"careplan_Dysphagia_Compensatory_Strategies"} == "on") echo "checked";;?>/>
    <?php xl('Dysphagia Compensatory Strategies','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Swallow_Exercise_Program" id="careplan_Swallow_Exercise_Program" 
    <?php if ($obj{"careplan_Swallow_Exercise_Program"} == "on") echo "checked";;?>/>
    </label>
  <?php xl('Swallow Exercise Program','e')?><br />
  <label>
    <input type="checkbox" name="careplan_Safety_Training_in_Swallow" id="careplan_Safety_Training_in_Swallow" 
    <?php if ($obj{"careplan_Safety_Training_in_Swallow"} == "on") echo "checked";;?>/>
   <?php xl('Safety Training in Swallow Techniques','e')?></label>
  </td>

        <td valign="top" width="33%"><label>
          <input type="checkbox" name="careplan_Cognitive_Impairment" id="careplan_Cognitive_Impairment" 
          <?php if ($obj{"careplan_Cognitive_Impairment"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Cognitive Impairment Management','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Communication_Strategies" id="careplan_Communication_Strategies" 
            <?php if ($obj{"careplan_Communication_Strategies"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Communication Strategies','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Cognitive_Compensatory" id="careplan_Cognitive_Compensatory" 
            <?php if ($obj{"careplan_Cognitive_Compensatory"} == "on") echo "checked";;?>/>
            <?php xl('Cognitive Compensatory Skills','e')?></label>
          <br/>
          <label>
            <input type="checkbox" name="careplan_Patient_Caregiver_Family_Education" id="careplan_Patient_Caregiver_Family_Education" 
            <?php if ($obj{"careplan_Patient_Caregiver_Family_Education"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Patient/Caregiver/Family Education','e')?><br />
         </td>

       <td valign="top">
          <?php xl('Other','e')?>  <input type="text" name="careplan_ST_Other" id="careplan_ST_Other" 
	      value="<?php echo stripslashes($obj{"careplan_ST_Other"});?>" />
          <br/>
	 <?php xl('Other','e')?>   <input type="text" name="careplan_ST_Other1" id="careplan_ST_Other1"
	  value="<?php echo stripslashes($obj{"careplan_ST_Other1"});?>" />
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
          <input type="checkbox" name="careplan_STO_Improve_OralStage_skills" id="careplan_STO_Improve_OralStage_skills" 
     <?php if ($obj{"careplan_STO_Improve_OralStage_skills"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Improve Oral skills in','e')?>
	    <label for="textfield2"></label>
          <input type="text" name="careplan_STO_Improve_OralStage_skills_In" id="careplan_STO_Improve_OralStage_skills_In" 
       value="<?php echo stripslashes($obj{"careplan_STO_Improve_OralStage_skills_In"});?>" />
          <?php xl('to','e')?> &nbsp; &nbsp; &nbsp;
	    <input type="text" name="careplan_STO_Improve_OralStage_skills_To" id="careplan_STO_Improve_OralStage_skills_To" 
	 value="<?php echo stripslashes($obj{"careplan_STO_Improve_OralStage_skills_To"});?>" />
	  <?php xl(' assist.','e')?>
	  
	  <br />
	  <label>
	  <input type="checkbox" name="careplan_STO_Improve_Pharyngeal_Stage" id="careplan_STO_Improve_Pharyngeal_Stage" 
	<?php if ($obj{"careplan_STO_Improve_Pharyngeal_Stage"} == "on") echo "checked";;?>/>
	    </label>
          <?php xl('Improve Pharyngeal Stage Skills in','e')?>          
          <input type="text" name="careplan_STO_Improve_Pharyngeal_Stage_In" id="careplan_STO_Improve_Pharyngeal_Stage_In" 
	 value="<?php echo stripslashes($obj{"careplan_STO_Improve_Pharyngeal_Stage_In"});?>" />
          <?php xl('to','e')?>
          <input type="text" name="careplan_STO_Improve_Pharyngeal_Stage_To" id="careplan_STO_Improve_Pharyngeal_Stage_To" 
	   value="<?php echo stripslashes($obj{"careplan_STO_Improve_Pharyngeal_Stage_To"});?>" />
          <br/>        

	  <input type="checkbox" name="careplan_STO_Improve_Verbal_Expression" id="careplan_STO_Improve_Verbal_Expression" 
	  <?php if ($obj{"careplan_STO_Improve_Verbal_Expression"} == "on") echo "checked";;?>/>
	  <?php xl('Improve Verbal Expression in','e')?>  
	  <input type="text" name="careplan_STO_Improve_Verbal_Expression_In" id="careplan_STO_Improve_Verbal_Expression_In"
	  value="<?php echo stripslashes($obj{"careplan_STO_Improve_Verbal_Expression_In"});?>" />
          <?php xl('to','e')?>
	  <input type="text" name="careplan_STO_Improve_Verbal_Expression_To" id="careplan_STO_Improve_Verbal_Expression_To"
	   value="<?php echo stripslashes($obj{"careplan_STO_Improve_Verbal_Expression_To"});?>" />
	 <br/>

	  <input type="checkbox" name="careplan_STO_Improve_Non_Verbal_Expression" id="careplan_STO_Improve_Non_Verbal_Expression" 
	    <?php if ($obj{"careplan_STO_Improve_Non_Verbal_Expression"} == "on") echo "checked";;?>/>
	  <?php xl('Improve Non Verbal Expression in','e')?>  
	  <input type="text" name="careplan_STO_Improve_Non_Verbal_Expression_in" id="careplan_STO_Improve_Non_Verbal_Expression_in" 
	   value="<?php echo stripslashes($obj{"careplan_STO_Improve_Non_Verbal_Expression_in"});?>" />
          <?php xl('to','e')?>
	  <input type="text" name="careplan_STO_Improve_Non_Verbal_Expression_to" id="careplan_STO_Improve_Non_Verbal_Expression_to" 
	   value="<?php echo stripslashes($obj{"careplan_STO_Improve_Non_Verbal_Expression_to"});?>" />
	 <br/>

	 <input type="checkbox" name="careplan_STO_Improve_Improve_Comprehension" id="careplan_STO_Improve_Improve_Comprehension" 
	  <?php if ($obj{"careplan_STO_Improve_Improve_Comprehension"} == "on") echo "checked";;?>/>
	  <?php xl('Improve Comprehension in','e')?>  
	  <input type="text" name="careplan_STO_Improve_Improve_Comprehension_In" id="careplan_STO_Improve_Improve_Comprehension_In"  
	   value="<?php echo stripslashes($obj{"careplan_STO_Improve_Improve_Comprehension_In"});?>" />
          <?php xl('to','e')?>
	  <input type="text" name="careplan_STO_Improve_Improve_Comprehension_To" id="careplan_STO_Improve_Improve_Comprehension_To" 
	   value="<?php echo stripslashes($obj{"careplan_STO_Improve_Improve_Comprehension_To"});?>" />
	 <br/>

	 <input type="checkbox" name="careplan_STO_Improve_Caregiver_Family_Performance" id="careplan_STO_Improve_Caregiver_Family_Performance" 
	    <?php if ($obj{"careplan_STO_Improve_Caregiver_Family_Performance"} == "on") echo "checked";;?>/>
	  <?php xl('Improve Caregiver/Family Performance in','e')?>  
	  <input type="text" name="careplan_STO_Improve_Caregiver_Family_Performance_In" id="careplan_STO_Improve_Caregiver_Family_Performance_In" 
	    value="<?php echo stripslashes($obj{"careplan_STO_Improve_Caregiver_Family_Performance_In"});?>" />
          </td>

        <td rowspan="3">
        <textarea name="careplan_STO_Time" id="careplan_STO_Time" cols="7" rows="18"><?php echo stripslashes($obj{"careplan_STO_Time"});?></textarea></td>
        <td><?php xl('Other','e')?>       
          <input size="20px" type="text" name="careplan_STO_Other" id="careplan_STO_Other" 
          value="<?php echo stripslashes($obj{"careplan_STO_Other"});?>" />
	 <br/><?php xl('Other','e')?>       
          <input size="20px" type="text" name="careplan_STO_Other1" id="careplan_STO_Other1" 
	    value="<?php echo stripslashes($obj{"careplan_STO_Other1"});?>" /></td>
        <td>        
        <textarea name="careplan_STO_Time1" id="careplan_STO_Time1" cols="7" rows="5"><?php echo stripslashes($obj{"careplan_STO_Time1"});?></textarea></td>
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
          <?php xl('Demonstrate ability to follow swallow exercise program','e')?>
          <br />
          <label>
            <input type="checkbox" name="careplan_LTO_Improve_compensatory_techniques" id="careplan_LTO_Improve_compensatory_techniques" 
            <?php if ($obj{"careplan_LTO_Improve_compensatory_techniques"} == "on") echo "checked";;?>/>
          <?php xl('Improve compensatory techniques in swallow','e')?>
          <br />
		<input type="checkbox" name="careplan_LTO_Implement_adaptations" id="careplan_LTO_Implement_adaptations" 
		 <?php if ($obj{"careplan_LTO_Implement_adaptations"} == "on") echo "checked";;?>/> 
          <?php xl('Implement adaptations in to improve communication skills','e')?>
          <br />
         <?php xl(' Other','e')?>
         <input type="text" name="careplan_LTO_Other" id="careplan_LTO_Other" 
          value="<?php echo stripslashes($obj{"careplan_LTO_Other"});?>" /></td>
        <td>
        <textarea name="careplan_LTO_Other_Time" id="careplan_LTO_Other_Time" cols="7" rows="8"><?php echo stripslashes($obj{"careplan_LTO_Other_Time"});?></textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
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
        <td><strong><?php xl('Discharge','e')?></strong> <strong><?php xl('Plan','e')?></strong></td>
        <td><input type="checkbox" name="careplan_DP_When_Goals_Are_Met" id="careplan_DP_When_Goals_Are_Met" 
        <?php if ($obj{"careplan_DP_When_Goals_Are_Met"} == "on") echo "checked";;?>/>
		<?php xl('When Goals Are Met Other','e')?> 
      <input type="text" name="careplan_DP_Other" id="careplan_DP_Other" 
      value="<?php echo stripslashes($obj{"careplan_DP_Other"});?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px"">
      <tr>
        <td scope="row"><strong>
        <?php xl('ST Care Plan and Discharge was communicated to and agreed upon by','e')?> </strong>
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
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px">
      <tr>
        <td scope="row"><strong>
        <?php xl('Patient/Caregiver/Family Response to Care Plan and Speech Therapy','e')?></strong></td>

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
