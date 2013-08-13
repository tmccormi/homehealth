<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: careplan");
?>

<html>
<head>
<title>SPEECH THERAPY CARE PLAN</title>
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
	    	 if(Dx=='careplan_ST_intervention')
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
	    obj.open("GET",site_root+"/forms/stcareplan/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>

</head>

<body>
<form method="post"
		action="<?php echo $rootdir;?>/forms/stcareplan/save.php?mode=new" name="careplan">
		<h3 align="center"><?php xl('SPEECH THERAPY CARE PLAN','e')?></h3>
		<h5 align="center">
		<?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
		</h5>
<table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
   <tr>

        <td width="19%" align="center" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
        <td width="25%" align="center"><input type="text"
					id="patient_name" value="<?php patientName()?>"
					readonly /></td>
        <td width="9%" align="center"><strong><?php xl('MR#','e')?></strong></td>
        <td width="16%" align="center" class="bold"><input
				type="text" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" readonly /></td>
	<td width="15%" align="center"><strong><?php xl('DATE','e')?></strong></td>
        <td width="20%" align="center">
        <input type='text' size='10' name='stdate' id='stdate' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/> 
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
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">

<tr>
<td width="18%" align="left" scope="row"><strong><?php xl('Med DX/ Reason for ST intervention','e')?></strong></td>
<td width="32%" >
<input type="text" id="careplan_ST_intervention" name="careplan_ST_intervention" style="width:100%;"/>
</td>

<td width="15%" align="center"><strong><?php xl('Treatment Dx','e')?></strong></td>
<td width="30%" align="left">
<input type="text" id="careplan_Treatment_DX" name="careplan_Treatment_DX" style="width:100%;"/>
</td>
</tr>

    </table></td>

  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="50%" align="left" scope="row"><strong>
        <?php xl('PROBLEMS REQUIRING ST INTERVENTION','e')?></strong></td>
         
        <td width="15%" align="center"><strong><?php xl('SOC Date','e')?></strong></td>
        <td width="30%" align="left">
        <input type='text' size='13' name='careplan_SOCDate' id='careplan_SOCDate' 
        			title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
    <td border="1" scope="row"><table width="100%" border="1px" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_ST_Decline_in_Oral_Stage_Skills" id="careplan_ST_Decline_in_Oral_Stage_Skills" />
          </label>
          <?php xl('Decline in Oral Stage Skills','e')?><br /></td>
        <td valign="top"><input name="careplan_ST_Decline_in_Oral_Stage_Skills_Notes" type="text" />
	</td> 

      <td valign="top" scope="row">
      <input type="checkbox" name="careplan_ST_Decreased_Comprehension" id="careplan_ST_Decreased_Comprehension" />
      <?php xl('Decreased Comprehension in','e')?>
          </td>
        <td valign="top"><input type="text" name="careplan_ST_Decreased_Comprehension_Note" id="careplan_ST_Decreased_Comprehension_Note" /></td>
     </tr>

      <tr>
	<td><input type="checkbox" name="careplan_ST_Decrease_in_Pharyngeal_Stage" id="careplan_ST_Decrease_in_Pharyngeal_Stage" />
        <label>
          <?php xl('Decrease in Pharyngeal Stage Skills','e')?></label></td>
        <td><input type="text" name="careplan_ST_Decrease_in_Pharyngeal_Stage_Note" id="careplan_ST_Decrease_in_Pharyngeal_Stage_Note" /></td>
	<td valign="top" scope="row">
	<?php xl('Others','e')?> </td>
	  <td>
	  <input type="text" name="careplan_ST_intervention_Other" id="careplan_ST_intervention_Other" />
          </td>
      	</tr>

	<tr>  <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_ST_Decline_in_Verbal_Expression" id="careplan_ST_Decline_in_Verbal_Expression" />
        <?php xl('Decline in Verbal Expression','e')?></label> </td>
        <td valign="top"><label for="ROM in2"></label>
          <input type="text"  name="careplan_ST_Decline_in_Verbal_Expression_Note" id="careplan_ST_Decline_in_Verbal_Expression_Note" /></td>
        <td valign="top" scope="row">
	<?php xl('Others','e')?> </td>
	  <td>
	  <input type="text"   name="careplan_ST_intervention_Other1" id="careplan_ST_intervention_Other1" />
          </td>
      	</tr>

	<tr>
	<td valign="top" scope="row"><input  type="checkbox" name="careplan_ST_Decline_in_NonVerbal_Expression" id="careplan_ST_Decline_in_NonVerbal_Expression" />
          <label for="checkbox"><?php xl('Decline in Non-Verbal Expression','e')?></label></td>
        <td valign="top"><input type="text" name="careplan_ST_Decline_in_NonVerbal_Expression_Note" id="careplan_ST_Decline_in_NonVerbal_Expression_Note" /></td>
        <td>&nbsp;</td><td>&nbsp;</td>
		</tr>
    </table></td>
  </tr>

<tr>
<td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
<tr>
<td scope="row"><strong><?php xl('TREATMENT PLAN FREQUENCY','e')?></strong> <br/>
<?php xl('Frequency and Duration: ','e')?>
<input type="text" name="careplan_Treatment_Plan_Frequency" style="width:100%;" id="careplan_Treatment_Plan_Frequency" />
<br />

<?php xl('Effective Date: ','e')?>
<input type="text" name="careplan_Treatment_Plan_EffectiveDate" id="careplan_Treatment_Plan_EffectiveDate" size="12" readonly>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_effec_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'>

<script LANGUAGE="JavaScript">
Calendar.setup({inputField:"careplan_Treatment_Plan_EffectiveDate", ifFormat:"%Y-%m-%d", button:"img_effec_date"});
</script>

</td>
</tr>

     </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td scope="row" valign="top" width="25%">
        <input type="checkbox" name="careplan_Evaluation" id="careplan_Evaluation" />
<?php xl('Evaluation','e')?>
  </label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Dysphagia_Compensatory_Strategies" id="careplan_Dysphagia_Compensatory_Strategies" />
    <?php xl('Dysphagia Compensatory Strategies','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Swallow_Exercise_Program" id="careplan_Swallow_Exercise_Program" />
    </label>
  <?php xl('Swallow Exercise Program','e')?><br />
  <label>
    <input type="checkbox" name="careplan_Safety_Training_in_Swallow" id="careplan_Safety_Training_in_Swallow" />
   <?php xl('Safety Training in Swallow Techniques','e')?></label>
  </td>

        <td valign="top" width="25%"><label>
          <input type="checkbox" name="careplan_Cognitive_Impairment" id="careplan_Cognitive_Impairment" />
          </label>
          <?php xl('Cognitive Impairment Management','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Communication_Strategies" id="careplan_Communication_Strategies" />
            </label>
          <?php xl('Communication Strategies','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Cognitive_Compensatory" id="careplan_Cognitive_Compensatory" />
            <?php xl('Cognitive Compensatory Skills','e')?></label>
          <br/>        
            <input type="checkbox" name="careplan_Patient_Caregiver_Family_Education" id="careplan_Patient_Caregiver_Family_Education" />
            <?php xl('Patient/Caregiver/Family Education','e')?>        
            </td>
        <td valign="top" width="50%" >
        <?php xl('Other','e')?> <input type="text" style="width:90%" name="careplan_ST_Other" id="careplan_ST_Other" />
        <br/>
         <?php xl('Other','e')?>   <input type="text" style="width:90%" name="careplan_ST_Other1" id="careplan_ST_Other1" />
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="40%" align="center" scope="row"><strong><?php xl('Short Term Outcomes','e')?> </strong>
         </td>
        <td width="10%"  align="center"><strong><?php xl('Time','e')?></strong></td>
        <td width="40%" align="center" scope="row"><strong><?php xl('Short Term Outcomes','e')?> </strong>
          </td>
        <td width="10%" align="center"><strong><?php xl('Time','e')?></strong></td>
        </tr>
      <tr>
        <td scope="row">
          <input type="checkbox" name="careplan_STO_Improve_OralStage_skills" id="careplan_STO_Improve_OralStage_skills" />
        <?php xl('Improve Oral skills in','e')?>
	<input type="text" style="width:50%" name="careplan_STO_Improve_OralStage_skills_In" id="careplan_STO_Improve_OralStage_skills_In" />
          <?php xl('to','e')?> &nbsp;
	    <input type="text" style="width:75%" name="careplan_STO_Improve_OralStage_skills_To" id="careplan_STO_Improve_OralStage_skills_To" />
	  <?php xl(' assist.','e')?>
</td>
<td><input type="text" style="width:90%"  name="careplan_STO_Improve_OralStage_skills_Time" id="careplan_STO_Improve_OralStage_skills_Time" /></td>
<td>
        <?php xl('Other','e')?>
          <input style="width:85%" type="text" name="careplan_STO_Other1" id="careplan_STO_Other1" />
          <br/><?php xl('Other','e')?>
          <input style="width:85%" type="text" name="careplan_STO_Other2" id="careplan_STO_Other2" /></td>
        <td>
        <input type="text" style="width:90%" name="careplan_STO_Time1" id="careplan_STO_Time1" />
	<br/> 
	<input type="text" style="width:90%" name="careplan_STO_Time2" id="careplan_STO_Time2" />
</td>
</tr>
<tr>
<td scope="row">
<input type="checkbox" name="careplan_STO_Improve_Pharyngeal_Stage" id="careplan_STO_Improve_Pharyngeal_Stage" />
    <?php xl('Improve Pharyngeal Stage Skills in','e')?>          
          <input type="text" style="width:35%" name="careplan_STO_Improve_Pharyngeal_Stage_In" id="careplan_STO_Improve_Pharyngeal_Stage_In" />
          <?php xl('to','e')?>
          <input type="text" style="width:56%" name="careplan_STO_Improve_Pharyngeal_Stage_To" id="careplan_STO_Improve_Pharyngeal_Stage_To" />
</td>      
<td><input type="text" style="width:90%"  name="careplan_STO_Improve_Pharyngeal_Stage_Time" id="careplan_STO_Improve_Pharyngeal_Stage_Time"/></td>
<td colspan="2" > <strong><?php xl('Long Term Outcomes','e')?></strong></td>
</tr>
<tr><td>
  <input type="checkbox" name="careplan_STO_Improve_Verbal_Expression" id="careplan_STO_Improve_Verbal_Expression" />        
	  <?php xl('Improve Verbal Expression in','e')?>  
	  <input type="text" style="width:35%" name="careplan_STO_Improve_Verbal_Expression_In" id="careplan_STO_Improve_Verbal_Expression_In" /> 
          <?php xl('to','e')?>
	  <input type="text" style="width:93%" name="careplan_STO_Improve_Verbal_Expression_To" id="careplan_STO_Improve_Verbal_Expression_To" /> 
</td>
<td>
<input type="text" style="width:90%"  name="careplan_STO_Improve_Verbal_Expression_Time" id="careplan_STO_Improve_Verbal_Expression_To"/>
</td>
<td>
 <input type="checkbox" name="careplan_LTO_Return_prior_level_function" id="careplan_LTO_Return_prior_level_function" />
          <?php xl('Return to prior level of function in','e')?></label><label>
            <input type="text" style="width:95%" name="careplan_LTO_Return_prior_level_function_In" id="careplan_LTO_Return_prior_level_function_In" />

</td>
<td>  <input type="text" style="width:90%"  name="careplan_LTO_Return_prior_level_function_Time" id="careplan_LTO_Return_prior_level_function_Time" /></td>
</tr>

<tr>
<td>
	  <input type="checkbox" name="careplan_STO_Improve_Non_Verbal_Expression" id="careplan_STO_Improve_Non_Verbal_Expression" />        
	  <?php xl('Improve Non Verbal Expression in','e')?>  
	  <input type="text" style="width:35%" name="careplan_STO_Improve_Non_Verbal_Expression_in" id="careplan_STO_Improve_Non_Verbal_Expression_in" /> 
          <?php xl('to','e')?>
	  <input type="text" style="width:56%" name="careplan_STO_Improve_Non_Verbal_Expression_to" id="careplan_STO_Improve_Non_Verbal_Expression_to" /> 
	 </td>
<td>
 <input type="text" style="width:90%"  name="careplan_STO_Improve_Non_Verbal_Expression_Time" id="careplan_STO_Improve_Non_Verbal_Expression_Time" />
</td>
<td>
  <input type="checkbox" name="careplan_LTO_Demonstrate_ability_follow_home_exercise" id="careplan_LTO_Demonstrate_ability_follow_home_exercise" />
 <?php xl('Demonstrate ability to follow swallow  exercise program','e')?>
</td>
<td>
<input type="text"  style="width:90%" name="careplan_LTO_Demonstrate_ability_follow_home_exercise_Time" id="careplan_LTO_Demonstrate_ability_follow_home_exercise_Time" />
</td>
</tr>
<tr>
<td><input type="checkbox" name="careplan_STO_Improve_Improve_Comprehension" id="careplan_STO_Improve_Improve_Comprehension" />        
	  <?php xl('Improve Comprehension in','e')?>  
	  <input type="text" style="width:39%"  name="careplan_STO_Improve_Improve_Comprehension_In" id="careplan_STO_Improve_Improve_Comprehension_In" /> 
          <?php xl('to','e')?>
	  <input type="text" style="width:92%" name="careplan_STO_Improve_Improve_Comprehension_To" id="careplan_STO_Improve_Improve_Comprehension_To" /> 
</td>
<td><input type="text" style="width:90%"  name="careplan_STO_Improve_Improve_Comprehension_Time" id="careplan_STO_Improve_Improve_Comprehension_Time" />
 </td>
<td><input type="checkbox" name="careplan_LTO_Improve_compensatory_techniques" id="careplan_LTO_Improve_compensatory_techniques" />
<?php xl('Improve compensatory techniques in swallow','e')?>
</td>
<td><input type="text" style="width:90%"  name="careplan_LTO_Improve_compensatory_techniques_Time" id="careplan_LTO_Improve_compensatory_techniques_Time" />
 </td>
</tr>
<tr> 
<td>
		 <input type="checkbox" name="careplan_STO_Improve_Caregiver_Family_Performance" id="careplan_STO_Improve_Caregiver_Family_Performance" />        
	  <?php xl('Improve Caregiver/Family Performance in','e')?>  
	  <input type="text" style="width:96%" name="careplan_STO_Improve_Caregiver_Family_Performance_In" id="careplan_STO_Improve_Caregiver_Family_Performance_In" /> 
          </td>
<td> <input type="text" style="width:90%"  name="careplan_STO_Improve_Caregiver_Family_Performance_Time" id="careplan_STO_Improve_Caregiver_Family_Performance_Time" />
 </td>
<td><input type="checkbox" name="careplan_LTO_Implement_adaptations" id="careplan_LTO_Implement_adaptations" />
          <?php xl('Implement adaptations in to improve communication skills','e')?>
 </td>
<td> <input type="text" style="width:90%" name="careplan_LTO_Implement_adaptations_Time" id="careplan_LTO_Implement_adaptations_Time"/></td>
      </tr>
      <tr>
     <td>&nbsp;  </td><td>&nbsp;  </td>
 <td>    <?php xl(' Other','e')?>
         <input type="text" style="width:82%" name="careplan_LTO_Other" id="careplan_LTO_Other" /></td>
 <td><input type="text" style="width:90%" name="careplan_LTO_Other_Time" id="careplan_LTO_Other_Time"></textarea></td>
    </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">

      <tr>
        
        <td><strong><?php xl('ADDITIONAL  COMMENTS','e')?></strong>
	<input type="text" style="width:79%" name="careplan_Additional_Comments" id="careplan_Additional_Comments" /> </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>

        <td width="50%" scope="row"><strong><?php xl('Rehab Potential','e')?></strong>
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Excellent" id="careplan_Rehab_Potential" />
            <?php xl('Excellent','e')?></label>&nbsp;&nbsp;
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Good" id="careplan_Rehab_Potential" />
            <?php xl('Good','e')?></label>&nbsp;&nbsp;
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Fair" id="careplan_Rehab_Potential" />
            <?php xl('Fair','e')?></label>&nbsp;&nbsp;
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Poor" id="careplan_Rehab_Potential" />
          <?php xl('Poor','e')?></label>&nbsp;</td>
        <td width="10%"><strong><?php xl('Discharge Plan','e')?></strong></td>
        <td width="40%"><input type="checkbox" name="careplan_DP_When_Goals_Are_Met" id="careplan_DP_When_Goals_Are_Met" />
		<?php xl('When Goals Are Met ','e')?>&nbsp;&nbsp;
                <br><?php xl('Other','e')?> 
      <input type="text" style="width:85%" name="careplan_DP_Other" id="careplan_DP_Other" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td scope="row"><strong>
        <?php xl('ST Care Plan and Discharge was communicated to and agreed upon by','e')?> </strong>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Patient" id="careplan_PT_communicated_and_agreed_upon_by" />
           <?php xl(' Patient','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Physician" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('Physician','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="PT/OT/ST" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('PT/OT/ST','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="COTA" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('PTA','e')?></label>
          <label><br>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Skilled Nursing" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('Skilled Nursing','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Caregiver/Family" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('Caregiver/Family','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Case Manager" id="careplan_PT_communicated_and_agreed_upon_by" />
            <?php xl('Case Manager','e')?><br />
            <?php xl('Other','e')?></label>
          <input type="text" style="width:94%"  name="careplan_PT_communicated_and_agreed_upon_Other" id="careplan_PT_communicated_and_agreed_upon_Other" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td scope="row"><strong>
        <?php xl('Patient/Caregiver/Family Response to Care Plan and Speech Therapy','e')?></strong></td>

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
value="Language Barrier" /> <?php xl('communication, language  barriers','e')?><br />
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
       <?php xl(' use family/professionals for interpretations as needed','e')?><br>
        <?php xl('Other','e')?>
          <input type="text" style="width:90%" name="careplan_Physician_Orders_Other" id="careplan_Physician_Orders_Other" />        </td>
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
        <td width="50%" scope="row"><strong><?php xl('Therapist Who Developed POC','e')?> </strong><?php xl('(Name and Title)','e')?>
          </td>
        <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td>

      </tr>
    </table>
<a href="javascript:top.restoreSession();document.careplan.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</td>
  </tr>
  
</table>
</form>
</body>
</html>
