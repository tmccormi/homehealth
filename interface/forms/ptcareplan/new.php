<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: careplan");
?>

<html>
<head>
<title>Care Plan</title>
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
	
<script>	
	//Function to create an XMLHttp Object.
	function pullAjax(){
    var a;
    try{
      a=new XMLHttpRequest();
    }
    catch(b)
    {
      try
      {
        a=new ActiveXObject("Msxml2.XMLHTTP");
      }catch(b)
      {
        try
        {
          a=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(b)
        {
         return false;
        }
      }
    }
    return a;
  }
	
	function changeICDlist(dx,code,rootdir)
	  {
	    site_root = rootdir; 
	    Dx = dx.name;
	    icd9code = code.value;	   	   
	    obj=pullAjax();	   
	    obj.onreadystatechange=function()
	    {
	      if(obj.readyState==4)
	      {	
	    	 eval("result = "+obj.responseText);
	    	 if(Dx=='careplan_PT_intervention')
	    	 {
		    	med_icd9.innerHTML= result['res'];
	    	 }
	    	 if(Dx=="careplan_Treatment_DX")
	    	 {
	    		 trmnt_icd9.innerHTML= result['res'];
	    	 }
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/ptcareplan/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>

</head>

<body>
<form method="post"
		action="<?php echo $rootdir;?>/forms/ptcareplan/save.php?mode=new" name="careplan">
		<h3 align="center"><?php xl('PHYSICAL THERAPY CARE PLAN','e')?></h3>
		<h5 align="center">
		<?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
		</h5>
<table align="center"  border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
  <tr>
    <td align="left" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
    <td width="33%" align="center" valign="top"><input type="text" size='40' 
					id="patient_name" value="<?php patientName()?>"
					readonly/></td>
    <td align="center"><strong><?php xl('Onset Date','e')?></strong></td><td width="21%" align="left">
   <input type='text' style="width:60%"  name='Onsetdate' id='Onsetdate'
					title='<?php xl('Date','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">

<tr>
<td width="20%" align="left" scope="row"><strong><?php xl('Med DX/ Reason for PT intervention','e')?></strong></td>
<td width="30%" align="center">
<input type="text" id="careplan_PT_intervention" name="careplan_PT_intervention" style="width:100%;"/>
</td>

<td width="20%" align="center"><strong><?php xl('Treatment Dx','e')?></strong></td>
<td width="30%" align="center">
<input type="text" id="careplan_Treatment_DX" name="careplan_Treatment_DX" style="width:100%;"/>
</td>
</tr>

    </table></td>

  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="50%" align="left" scope="row"><strong>
        <?php xl('PROBLEMS REQUIRING PT INTERVENTION','e')?></strong></td>
         
<td width="15%" align="center"><strong><?php xl('Start of Care Date','e')?></strong></td>
<td width="35%" align="left">
<input type='text' size='12' name='careplan_SOCDate' id='careplan_SOCDate' title='<?php xl('Start of Care Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php VisitDate(); ?>' readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"careplan_SOCDate", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"  ><table width="100%" border="0px" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td  valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Decline_in_mobility" id="careplan_PT_Decline_in_mobility" />
          </label>
          <?php xl('Decline in mobility in','e')?><br /></td>

        <td  valign="top"><input style="width:270px"  name="careplan_PT_Decline_in_mobility_Note" type="text" />
</td>
        <td ><input type="checkbox" name="careplan_PT_Decline_in_Balance" id="careplan_PT_Decline_in_Balance" />
          <?php xl('Decline in Balance in','e')?></label></td>
        <td ><input type="text" style="width:270px"  name="careplan_PT_Decline_in_Balance_Note" id="careplan_PT_Decline_in_Balance_Note" /></td>
      </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Decrease_in_ROM" id="careplan_PT_Decrease_in_ROM" />
        <?php xl('Decrease in ROM in','e')?></label> </td>
        <td  valign="top"><label for="ROM in2"></label>
          <input style="width:270px" type="text" name="careplan_PT_Decrease_in_ROM_Note" id="careplan_PT_Decrease_in_ROM_Note" /></td>
        <td valign="top" scope="row"><input type="checkbox" name="careplan_PT_Decreased_Safety" id="careplan_PT_Decreased_Safety" />
          <label for="checkbox"><?php xl('Decreased Safety in','e')?></label></td>
        <td valign="top"><input type="text" style="width:270px"  name="careplan_PT_Decreased_Safety_Note" id="careplan_PT_Decreased_Safety_Note" /></td>

        </tr>
      <tr>
        <td  valign="top" scope="row">
      <input type="checkbox" name="careplan_PT_Decline_in_Strength" id="careplan_PT_Decline_in_Strength" />
          <?php xl('Decline in Strength in','e')?></td>
        <td valign="top"><label for="IADL skills"></label>
          <input type="text" style="width:270px"  name="careplan_PT_Decline_in_Strength_Note" id="careplan_PT_Decline_in_Strength_Note" /></td>
        <td valign="Right"><?php xl('Other','e')?></td>

        <td valign="top"><input type="text" style="width:270px"  name="careplan_PT_intervention_Other" id="careplan_PT_intervention_Other" /></td>
       </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Increased_Pain_with_Movement" id="careplan_PT_Increased_Pain_with_Movement" />
          <?php xl('Increased Pain with Movement in','e')?></label></td>
        <td colspan="3" valign="top">
          <input type="text" style="width:270px"  name="careplan_PT_Increased_Pain_with_Movement_Note" id="careplan_PT_Increased_Pain_with_Movement_Note" /></td>

        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">

<tr>
<td scope="row"><strong><?php xl('TREATMENT PLAN FREQUENCY','e')?></strong><br></td>
<tr>
<td><?php xl('Frequency & Duration: ','e')?>&nbsp;
<input type="text" name="careplan_Treatment_Plan_frequency" style="width:100%;" id="careplan_Treatment_Plan_frequency"/>
<br />
<?php xl('Effective Date: ','e')?>
<input type="text" name="careplan_Treatment_Plan_EffectiveDate" id="careplan_Treatment_Plan_EffectiveDate" size="12" readonly/>

<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_eff_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'> 

<script LANGUAGE="JavaScript">
Calendar.setup({inputField:"careplan_Treatment_Plan_EffectiveDate", ifFormat:"%Y-%m-%d", button:"img_eff_date"});
</script>

</td>
</tr>

     </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="25%" scope="row" valign="top" width="30%">
        <input type="checkbox" name="careplan_Evaluation" id="careplan_Evaluation" />
<?php xl('Evaluation','e')?>
  </label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Home_Therapeutic_Exercises" id="careplan_Home_Therapeutic_Exercises" />
    <?php xl('Home Therapeutic Exercises','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Gait_ReTraining" id="careplan_Gait_ReTraining" />
    </label>
  <?php xl('Gait Re-Training','e')?><br />
  <label>
    <input type="checkbox" name="careplan_Bed_Mobility_Training" id="careplan_Bed_Mobility_Training" />
   <?php xl(' Bed Mobility Training','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Transfer_Training"  id="careplan_Transfer_Training" />
    <?php xl('Transfer Training','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Balance_Training_Activities" id="careplan_Balance_Training_Activities" />
    <?php xl('Balance Training/Activities','e')?></label>
  <br />
  <input type="checkbox" name="careplan_Patient_Caregiver_Family_Education" id="careplan_Patient_Caregiver_Family_Education" />
  <label for="checkbox2"><?php xl('Patient/Caregiver/Family Education','e')?></label></td>

        <td valign="top" width="35%"><label>
          <input type="checkbox" name="careplan_Assistive_Device_Training" id="careplan_Assistive_Device_Training" />
          </label>
          <?php xl('Assistive Device Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Neuro_developmental_Training" id="careplan_Neuro_developmental_Training" />
            </label>
          <?php xl('Neuro-developmental Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Orthotics_Splinting" id="careplan_Orthotics_Splinting" />
            <?php xl('Orthotics/Splinting','e')?></label>
          <br/>
          <label>
            <input type="checkbox" name="careplan_Hip_Safety_Precaution_Training" id="careplan_Hip_Safety_Precaution_Training" />
            </label>
          <?php xl('Hip Safety Precaution Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Physical_Agents" id="careplan_Physical_Agents" />
            <?php xl('Physical Agents','e')?></label>
          <strong>
          <input type="text" style="width:55%" name="careplan_Physical_Agents_Name" id="careplan_Physical_Agents_Name" />
          </strong><br />
          &nbsp;  &nbsp;  &nbsp;<?php xl('for','e')?><strong>
          <input type="text" style="width:85%"  name="careplan_Physical_Agents_For" id="careplan_Physical_Agents_For" />
          </strong><br />
          <label>
            <input type="checkbox" name="careplan_Muscle_ReEducation" id="careplan_Muscle_ReEducation" />
          <?php xl('Muscle Re-Education','e')?></label></td>
        <td width="40%" valign="top">
          <label>
            <input type="checkbox" name="careplan_Safe_Stair_Climbing_Skills" id="careplan_Safe_Stair_Climbing_Skills" />
            </label>
          <?php xl('Safe Stair Climbing Skills','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Exercises_to_manage_pain" id="careplan_Exercises_to_manage_pain" />
            <?php xl('Exercises to manage pain','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Fall_Precautions_Training" id="careplan_Fall_Precautions_Training" /> </label>
<label>            <?php xl('Fall Precautions Training','e')?><br />


            <input type="checkbox" name="careplan_Exercises_Safety_Techniques_given_patient" id="careplan_Exercises_Safety_Techniques_given_patient" />
            <?php xl('Exercises/ Safety Techniques given to patient','e')?> <br />
          </label>
          <label>          </label>
                  <?php xl('Other','e')?>
            <input type="text" name="careplan_PT_Other" id="careplan_PT_Other" style="width:85%" />
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="2" class="formtable">
<tr><td colspan="6" valign="top">
<table width="100%" border="2" class="formtable">
      
<tr>
<td width="40%" ><strong><?php xl('Short Term Outcomes','e')?></strong></td>
<td width="10%" ><strong><?php xl('Time','e')?> </strong></td>
<td width="40%"><strong><?php xl('Short Term Outcomes','e')?></strong></td>
<td width="10%"><strong><?php xl('Time','e')?> </strong></td></tr>		
<tr>
<td valign="top" scope="row"><label>
<input type="checkbox" name="careplan_STO_Improve_mobility_skills"  id="careplan_STO_Improve_mobility_skills" /> <?php xl('Improve Mobility skills in','e')?></label> <input type="text" name="careplan_STO_Improve_mobility_skills_In" id="careplan_STO_Improve_mobility_skills_In" size="12"/>
<?php xl('to','e')?><input type="text" name="careplan_STO_Improve_mobility_skills_To" id="careplan_STO_Improve_mobility_skills_To" size="12" />	<?php xl('assist.','e')?>
</td><td  align="left" valign="center">
<input type="text" name="careplan_STO_Mobility_Skill_Time" id="careplan_STO_Mobility_Skill_Time" size="10px"></td>
<td scope="row">
<?php xl('Other','e')?>&nbsp;<input type="text" size="55px" name="careplan_STO_Other" id="careplan_STO_Other" />
<br>
</td>
<td  align="left" valign="center"><input type="text" name="careplan_STO_Other_Time" id="careplan_STO_Other_Time" size="10px">
</td></tr>
<tr>
<td valign="top" scope="row"><label> 
<input type="checkbox"	name="careplan_STO_Increase_ROM" id="careplan_STO_Increase_ROM" />
<?php xl('Increase ROM Of','e')?> </label>
<input type="checkbox" name="careplan_STO_Increase_ROM_Side" id="careplan_STO_Increase_ROM_Side" value="right"/> <?php xl('right','e')?>
<label><input type="checkbox" name="careplan_STO_Increase_ROM_Side" id="careplan_STO_Increase_ROM_Side" value="left"/> <?php xl('left','e')?> </label> 
<input type="text" name="careplan_STO_Increase_ROM_Note" id="careplan_STO_Increase_ROM_Note" size="12" /> <?php xl('(joints) to','e')?>
<input type="text" name="careplan_STO_Increase_ROM_To" id="careplan_STO_Increase_ROM_To" size="12" /> 
<?php xl('WFL','e')?>
</td><td align="left" valign="center">				
<input type="text" name="careplan_STO_ROM_Skill_Time" id="careplan_STO_ROM_Skill_Time" size="10px"></td>
<td align="left" colspan="2">
<strong><?php xl('Long Term Outcomes ','e')?></strong>
</td><td></td></tr>
<tr><td valign="top" scope="row"><label> <input type="checkbox"	name="careplan_STO_Increase_Strength" id="careplan_STO_Increase_Strength" /> <?php xl('Increase Strength Of','e')?> </label>
<input type="checkbox" name="careplan_STO_Increase_Strength_Side" id="careplan_STO_Increase_Strength_Side" value="right"/> <?php xl('right','e')?>
<label><input type="checkbox" name="careplan_STO_Increase_Strength_Side" id="careplan_STO_Increase_Strength_Side" value="left"/> <?php xl('left','e')?> </label> 
<input type="text" name="careplan_STO_Increase_Strength_Note" id="careplan_STO_Increase_Strength_Note" size="12" /> <?php xl(' to','e')?>
<input type="text" name="careplan_STO_Increase_Strength_To" id="careplan_STO_Increase_Strength_To" style="width:30%"/> <?php xl('/5','e')?>
</td><td align="left" valign="center">				
<input type="text" name="careplan_STO_WFL_Time" id="careplan_STO_WFL_Time" size="10px"></td>
<td>
<label> <input type="checkbox" name="careplan_LTO_Return_prior_level_function" id="careplan_LTO_Return_prior_level_function" /> <?php xl('Return to prior level of function in','e')?></label>
<input type="text" name="careplan_LTO_Return_prior_level_function_In" id="careplan_LTO_Return_prior_level_function_In" style="width:37%">
</td><td align="left" valign="center">
<input type="text" name="careplan_LTO_Return_prior_level_function_Time" id="careplan_LTO_Return_prior_level_function_Time" size="10px">
</td></tr>
<tr>
<td valign="top" scope="row"> 
 <input type="checkbox" name="careplan_STO_Exercises_using_written_handout" id="careplan_STO_Exercises_using_written_handout"/>

<?php xl('Exercises using written handout  with','e')?>
<input type="text" name="careplan_STO_Exercises_using_written_handout_with" id="careplan_STO_Exercises_using_written_handout_with" size="12" />
<?php xl('verbal/physical prompts','e')?></td>
<td align="left" valign="center">
<input type="text" name="careplan_STO_Excercise_Time" id="careplan_STO_Excercise_Time" size="10px">
</td>
<td><label>
<input type="checkbox" name="careplan_LTO_Demonstrate_ability_follow_home_exercise" id="careplan_LTO_Demonstrate_ability_follow_home_exercise" /> 
<?php xl('Demonstrate ability to follow home exercise program','e')?></label>
</td>
<td align="left" valign="center">
<input type="text" name="careplan_LTO_Demonstrate_ability_follow_home_exercise_Time" id="careplan_LTO_Demonstrate_ability_follow_home_exercise_Time" size="10px">
</td></tr>
<tr>
<td valign="top" scope="row"><label> 
<input type="checkbox" name="careplan_STO_Improve_home_safety_techniques" id="careplan_STO_Improve_home_safety_techniques" /> <?php xl('Improve home safety techniques in','e')?>
</label> 
<input type="text" name="careplan_STO_Improve_home_safety_techniques_In" id="careplan_STO_Improve_home_safety_techniques_In" size="12" />
 <?php xl('to','e')?>
<input	type="text" name="careplan_STO_Improve_home_safety_techniques_To"  id="careplan_STO_Improve_home_safety_techniques_To" size="12" />
 <?php xl('assist.','e')?>
</td> <td align="left" valign="center"> 
<input type="text" name="careplan_STO_Safety_Techniques_Time" id="careplan_STO_Safety_Techniques_Time" size="10px"></td><td width="60%" scope="row">
<input type="checkbox" name="careplan_LTO_Improve_mobility" id="careplan_LTO_Improve_mobility" />
<?php xl('Improve Mobility in','e')?>
<input type="checkbox" name="careplan_LTO_Improve_mobility_Type" id="careplan_LTO_Improve_mobility_Type" value="home"/>
<?php xl('Home','e')?>
<input type="checkbox" name="careplan_LTO_Improve_mobility_Type" id="careplan_LTO_Improve_mobility_Type" value="community"/>
<?php xl('Community','e')?>
</td>	<td align="left" valign="center">
<input type="text" name="careplan_LTO_Improve_mobility_Time" id="careplan_LTO_Improve_mobility_Time" size="10px">
</td></tr>
<tr><td scope="row"><br /> <label>
 <input	type="checkbox" name="careplan_STO_Demonstrate_independent_use_of_prosthesis" id="careplan_STO_Demonstrate_independent_use_of_prosthesis" /> <?php xl('Demonstrate independent use of prosthesis/brace/splint','e')?>
</label>
</td>
<td align="left" valign="center">
<input type="text" name="careplan_STO_Independant_Use_Of_Prosthesis_Time" id="careplan_STO_Independant_Use_Of_Prosthesis_Time" size="10px">
</td>
<td scope="row"><label>
<input type="checkbox" name="careplan_LTO_Improve_independence_safety_home" id="careplan_LTO_Improve_independence_safety_home" />
<?php xl('Implement in Independance in safety in home','e')?></label>
</td>
<td align="left" valign="center">
<input type="text" name="careplan_LTO_Improve_independence_safety_home_Time" id="careplan_LTO_Improve_independence_safety_home_Time" size="10px">
</td>
</tr>
<tr>
<td >&nbsp;</td><td>&nbsp;</td>
<td scope="row"><?php xl('Other','e')?> &nbsp;
<input type="text" size="55px" name="careplan_LTO_Other" id="careplan_LTO_Other" />
</td>
<td align="left" valign="center">
<input type="text" name="careplan_LTO_Other_Time" id="careplan_LTO_Other_Time" size="10px">
</td>	</tr></table> </td></tr>
<tr>
        
        <td><strong><?php xl('ADDITIONAL  COMMENTS','e')?></strong>
 <input type="text" name="careplan_Additional_comments" id="careplan_Additional_comments" style="width:95%
"/> </td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>

        <td width="40%" scope="row"><strong><?php xl('Rehab Potential','e')?></strong>
          
            <input type="checkbox" name="careplan_Rehab_Potential" value="Excellent" id="careplan_Rehab_Potential" />
            <?php xl('Excellent','e')?>
          
            <input type="checkbox" name="careplan_Rehab_Potential" value="Good" id="careplan_Rehab_Potential" />
            <?php xl('Good','e')?>
          
        <br/>    <input type="checkbox" name="careplan_Rehab_Potential" value="Fair" id="careplan_Rehab_Potential" />
            <?php xl('Fair','e')?>
          
            <input type="checkbox" name="careplan_Rehab_Potential" value="Poor" id="careplan_Rehab_Potential" />
          <?php xl('Poor','e')?></td>
        <td width="10%" ><strong><?php xl('Discharge Plan','e')?></strong></td>

        <td width="50%" ><input type="checkbox" name="careplan_DP_When_Goals_Are_Met" id="careplan_DP_When_Goals_Are_Met" />
		<?php xl('When Goals Are Met','e')?><br/> <?php xl('Other','e')?> 
      <input type="text" name="careplan_DP_Other" style="width:80%"  id="careplan_DP_Other" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td scope="row"><strong>
        <?php xl('PT Care Plan and Discharge was communicated to and agreed upon by','e')?> </strong>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Patient" id="careplan_PT_communicated_and_agreed_upon_by" />
           <?php xl(' Patient','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Physician" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('Physician','e')?></label>
         <br/> <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="PT/OT/ST" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('PT/OT/ST','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="COTA" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('PTA','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Skilled Nursing" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('Skilled Nursing','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Caregiver/Family" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('Caregiver/Family','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Case Manager" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('Case Manager','e')?><br />
            <?php xl('Other','e')?></label>

          <input type="text" name="careplan_PT_communicated_and_agreed_upon_Other" id="careplan_PT_communicated_and_agreed_upon_Other" style="width:90%"  /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td scope="row"><strong>
        <?php xl('Patient/Caregiver/Family Response to Care Plan and Physical Therapy','e')?></strong></td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="50%" scope="row"><label>
          <input type="checkbox" name="careplan_Agreeable_to_general_goals" id="careplan_Agreeable_to_general_goals" />
          <?php xl('Agreeable to general goals and treatment plan','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Highly_motivated_to_improve" id="careplan_Highly_motivated_to_improve" />
            <?php xl('Highly motivated to improve','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Supportive_family_caregiver" id="careplan_Supportive_family_caregiver" />
          <?php xl('Supportive family/caregiver likely to increase success','e')?></label></td>

        <td width="50%" rowspan="2">
        <input type="checkbox" name="careplan_May_require_additional_treatment" id="careplan_May_require_additional_treatment" />
          <label for="checkbox"></label>
		<?php xl('May require additional treatment session  to achieve Long Term Outcomes due to','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
value="Short Term Memory"/>
<?php xl('short term memory difficulties','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
value="Minimum support"/>
<?php xl('minimal support systems','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
value="Language Barrier"/> <?php xl('communication, language  barriers','e')?><br />
<input type="checkbox" name="careplan_Will_address_above_issues" id="careplan_Will_address_above_issues" />
       <?php xl(' Will address above issues by','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
  value="Written Directions"/>
        <?php xl('Providing written directions  and/or physical demonstration','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
  value="Community Support"/>
        <?php xl('establish community  support systems','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
  value="Home Adaptations"/>
        <?php xl('home/environmental adaptations','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
  value="Use Family"/>
       <?php xl(' use family/professionals for interpretations as needed','e')?>
<br/>        <?php xl('Other','e')?>
          <input type="text" name="careplan_Physician_Orders_Other" id="careplan_Physician_Orders_Other" style="width:80%"/>        </td>
      </tr>
      <tr>
      <td><strong><?php xl('Physician Orders','e')?> </strong>

        <input type="checkbox" name="careplan_Physician_Orders" id="careplan_Physician_Orders" value="Orders Obtained"/>
        <label for="Physician Orders Obtained"><?php xl('Physician Orders Obtained','e')?></label>
        <br />
  <input type="checkbox" name="careplan_Physician_Orders" id="careplan_Physician_Orders" value="Orders Needed"/>
        <label for="Physician orders needed"><?php xl('Physician orders needed','e')?></label>
        <strong><?php xl('Will follow agency&rsquo;s procedures for obtaining verbal orders and completing the 485/POC or submitting  supplemental orders for physician signature','e')?></strong></td>

      </tr>
    </table></td>
  
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="50%" scope="row"><strong><?php xl('Therapist Who Developed POC','e')?> </strong>(Name and Title)
          </td>
        <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td>

      </tr>
    </table></td>
  </tr>
  
</table>
<a href="javascript:top.restoreSession();document.careplan.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>
</body>
</html>
