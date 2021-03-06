<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("functions.php");
formHeader("Form: visit_notes");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php html_header_show();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php xl('OCCUPATIONAL THERAPY VISIT NOTE','e')?></title>
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
		 	med_icd9.innerHTML= result['res'];	    	 
	    	   	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/visit_notes/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>

<script>
function requiredCheck(){
    var time_in = document.getElementById('visitnote_Time_In').value;
    var time_out = document.getElementById('visitnote_Time_Out').value;
				var date = document.getElementById('visitnote_date_curr').value;
    
				if(time_in != "" && time_out != "" && date != "") {
        return true;
    } else {
        alert("Please select a time in, time out, and encounter date before submitting.");
        return false;
    }
}
</script>
</head>

<body><h3 align="center"><?php xl('OCCUPATIONAL THERAPY VISIT NOTE','e'); ?></h3>
<form method=post action="<?php echo $rootdir;?>/forms/visit_notes/save.php?mode=new" name="visitnotes">

<br></br>
<table width="100%" border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row">
    <table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr>
        <td scope="row"><strong><?php xl('Patient Name','e'); ?></strong></td>
        <td align="center" valign="top">
        <input type="text" id="patient_name" value="<?php patientName()?>" readonly /></td>
        <td><strong><?php xl('Time In','e'); ?></strong></td>
        <td><select name="visitnote_Time_In" id="visitnote_Time_In"> <?php timeDropDown($GLOBALS['Selected']) ?></select></td>
        <td><strong><?php xl('Time Out','e'); ?></strong></td>
        <td><select name="visitnote_Time_Out" id="visitnote_Time_Out"> <?php timeDropDown($GLOBALS['Selected']) ?></select></td>
        <td><strong><?php xl('Encounter Date','e'); ?></strong></td>
        <td>
        <strong>
    <input type='text' size='20' name='visitnote_date_curr' id='visitnote_date_curr'
    value='<?php echo $date ?>'
    title='<?php xl('Encounter Date','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly />
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"visitnote_date_curr", ifFormat:"%Y-%m-%d", button:"img_date"});
   </script>

        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('TYPE OF VISIT','e'); ?> </strong>
      <input type="checkbox" name="visitnote_visit_type" value="visit" id="visitnote_TOV_Visit" />
<?php xl('Visit','e'); ?>
<input type="checkbox" name="visitnote_visit_type" value="visit_Supervisory" id="visitnote_TOV_Visit_Supervisory" />
<?php xl('Visit and Supervisory Review','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> 
<input type="text" style="width:460px" name="visitnote_TOV_Visit_Other" id="visitnote_TOV_Visit_Other" /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('VITAL SIGNS','e'); ?></strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pulse','e'); ?> 
    <input type="text" size="3px" name="visitnote_VS_Pulse" id="visitnote_VS_Pulse" /> 
    <input type="checkbox" name="visitnote_Pulse_Rate" value="regular" id="visitnote_VS_Pulse_Regular" />
<?php xl('Regular','e'); ?>
<input type="checkbox" name="visitnote_Pulse_Rate" value="Irregular" id="visitnote_VS_Pulse_Irregular" />
<?php xl('Irregular','e'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Temperature','e'); ?>
 <input type="text" size="3px" name="visitnote_VS_Temperature" id="visitnote_VS_Temperature" /> 
 <input type="checkbox" name="visitnote_Temperature" value="Oral" id="visitnote_VS_Temperature_Oral" />
<?php xl('Oral','e'); ?>
<input type="checkbox" name="visitnote_Temperature" value="Temporal" id="visitnote_VS_Temperature_Temporal" />
<?php xl('Temporal','e'); ?>&nbsp;
<?php xl('Other','e'); ?> 
<input type="text" size="10px" name="visitnote_VS_Other" id="visitnote_VS_Other" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl('Respirations','e'); ?>
 <input type="text" size="3px" name="visitnote_VS_Respirations" id="visitnote_VS_Respirations" />
  <p><?php xl('Blood Pressure Systolic','e'); ?>
  <input type="text" size="3px" name="visitnote_VS_BP_Systolic" id="visitnote_VS_BP_Systolic" />
  /
  <input type="text" size="3px" name="visitnote_VS_BP_Diastolic" id="visitnote_VS_BP_Diastolic" />
<input type="checkbox" name="visitnote_BloodPrerssure_side" value="Right" id="visitnote_VS_BP_Right" />
<?php xl('Right','e'); ?>
<input type="checkbox" name="visitnote_BloodPrerssure_side" value="Left" id="visitnote_VS_BP_Left" />
<?php xl('Left','e'); ?>
<input type="checkbox" name="visitnote_BloodPrerssure_position" value="Sitting" id="visitnote_VS_BP_Sitting" />
<?php xl('Sitting','e'); ?>
<input type="checkbox" name="visitnote_BloodPrerssure_position" value="Standing" id="visitnote_VS_BP_Standing" />
<?php xl('Standing','e'); ?>
<input type="checkbox" name="visitnote_BloodPrerssure_position" value="Lying" id="visitnote_VS_BP_Lying" />
<?php xl('Lying','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('*O','e'); ?><sub><?php xl('2','e'); ?></sub><?php xl('Sat','e'); ?>&nbsp;
<input type="text" size="7px" name="visitnote_VS_BP_Sat" id="visitnote_VS_BP_Sat" /> *<?php xl('Physician ordered','e'); ?> </p></td>

  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pain','e'); ?>
  <input type="checkbox" name="visitnote_Pain_Level" value="NoPain" id="visitnote_VS_Pain_Nopain" />
<?php xl('No Pain','e'); ?>
<input type="checkbox" name="visitnote_Pain_Level" value="Pain limits functional ability" id="visitnote_VS_Pain_Pain_limits" />
<?php xl('Pain limits functional ability','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Intensity','e'); ?>
<input type="text" name="visitnote_VS_Pain_Intensity" id="visitnote_VS_Pain_Intensity" />
<input type="checkbox" name="visitnote_Pain_Intensity" value="Improve" id="visitnote_VS_Pain_Intensity_Improve" />
<?php xl('Improve','e'); ?>
<input type="checkbox" name="visitnote_Pain_Intensity" value="Worse" id="visitnote_VS_Pain_Intensity_Worse" />
<?php xl('Worse','e'); ?>
<input type="checkbox" name="visitnote_Pain_Intensity" value="No_Change" id="visitnote_VS_Pain_Intensity_No_Change" />
<?php xl('No Change','e'); ?></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><p><strong><?php xl('Please Note   Contact MD if Vital Signs are   Pulse &lt;56 or &gt;120;   Temperature   &lt;56 or &gt;101;   Respirations  &lt;10 or &gt;30<br />SBP &lt;80 or &gt;190; DBP &lt;50  or  &gt;100;  Pain   Significantly  Impacts patients ability to participate.    O2 Sat &lt;90% after rest','e'); ?></strong></p></td>
  </tr>
  <tr>
    <td valign="top" scope="row" style="padding-left:8px; padding-right:8px; padding-bottom:8px;"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM','e'); ?></strong>
<input type="text" id="visitnote_Treatment_Diagnosis_Problem" name="visitnote_Treatment_Diagnosis_Problem" style="width:100%;"/>
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>
          <td valign="top" scope="row"><table width="100%" class="formtable">
              <tr>
                <td><label>
                  <strong><?php xl('PATIENT CONTINUES TO BE HOMEBOUND DUE TO','e'); ?></strong><br />
                  <input type="checkbox" name="visitnote_Pat_Homebound_Needs_assistance"id="visitnote_Pat_Homebound_Needs_assistance" />
                  <?php xl('Needs assistance in all activities of daily living','e'); ?></label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Unable_leave_home" id="visitnote_Pat_Homebound_Unable_leave_home" />
                 <?php xl('Unable to leave home safely without assistance','e'); ?> </label></td>
              </tr>
              <tr>
                <td >
                  <input type="checkbox" name="visitnote_Pat_Homebound_Medical_Restrictions"id="visitnote_Pat_Homebound_Medical_Restrictions" />
                  <?php xl('Medical Restrictions in','e'); ?>
                  <input type="text" name="visitnote_Pat_Homebound_Medical_Restrictions_In" style="width:280px" id="visitnote_Pat_Homebound_Medical_Restrictions_In" />
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" name="visitnote_Pat_Homebound_SOB_upon_exertion" id="visitnote_Pat_Homebound_SOB_upon_exertion" />
                  <?php xl('SOB upon exertion','e'); ?>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Pain_with_Travel" id="visitnote_Pat_Homebound_Pain_with_Travel" />
                  <?php xl('Pain with Travel','e'); ?></td>
              </tr>
            </table>
          <td valign="top">
            <table width="100%" class="formtable">
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_mobility_ambulation" id="visitnote_Pat_Homebound_mobility_ambulation" />
                  <?php xl('Requires assistance in mobility and ambulation','e'); ?></label></td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Arrhythmia" id="visitnote_Pat_Homebound_Arrhythmia" />
                  <?php xl('Arrhythmia','e'); ?>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Bed_Bound" id="visitnote_Pat_Homebound_Bed_Bound" />
<?php xl('Bed Bound','e'); ?>
<input type="checkbox" name="visitnote_Pat_Homebound_Residual_Weakness" id="visitnote_Pat_Homebound_Residual_Weakness" />
<?php xl('Residual Weakness','e'); ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="visitnote_Pat_Homebound_Confusion" id="visitnote_Pat_Homebound_Confusion" />
                  <?php xl('Confusion, unable to go out of home alone','e'); ?></td>
              </tr>
            </table>
            <p><?php xl('Other','e'); ?> 
              <input type="text" name="visitnote_Pat_Homebound_Other" style="width:370px" id="visitnote_Pat_Homebound_Other" />
            </p></td>
        </tr>
    </table>      
      <strong><?php xl('INTERVENTIONS','e'); ?> <input type="checkbox" name="visitnote_Interventions_Patient" id="visitnote_Interventions_Patient" />
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_Interventions_Caregiver" id="visitnote_Interventions_Caregiver" />
<?php xl('Caregiver','e'); ?>
<input type="checkbox" name="visitnote_Interventions_Patient_Caregiver" id="visitnote_Interventions_Patient_Caregiver" />
<?php xl('Patient and Caregiver','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?>
<input type="text" name="visitnote_Interventions_Other" style="width:340px" id="visitnote_Interventions_Other" /></strong>
<br /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr valign="top">
        <td scope="row">
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Home_Safety_Evaluation" id="visitnote_Home_Safety_Evaluation" />
                <?php xl('Home Safety Evaluation/Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_IADL_ADL_Training" id="visitnote_IADL_ADL_Training" />
                <?php xl('IADL/ADL Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Muscle_ReEducation" id="visitnote_Muscle_ReEducation" />
                <?php xl('Muscle Re-Education','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Visual_Perceptual_Training" id="visitnote_Visual_Perceptual_Training" />
                <?php xl('Visual/Perceptual Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Fine_Gross_Motor_Training" id="visitnote_Fine_Gross_Motor_Training" />
                <?php xl('Fine/Gross Motor Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Patient_Caregiver_Family_Education" id="visitnote_Patient_Caregiver_Family_Education" />
               <?php xl('Patient/Caregiver/Family Education','e'); ?> </label></td>
            </tr>
          </table>
        </td>
        <td>
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Therapeutic_Exercises" id="visitnote_Therapeutic_Exercises" />
               <?php xl('Therapeutic Exercises for UEs','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Neuro_developmental_Training" id="visitnote_Neuro_developmental_Training" />
             <?php xl('Neuro-developmental Training','e'); ?>   </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Sensory_Training" id="visitnote_Sensory_Training" />
               <?php xl('Sensory Training','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Orthotics_Splinting" id="visitnote_Orthotics_Splinting" />
                <?php xl('Orthotics/Splinting','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Adaptive_Equipment_training" id="visitnote_Adaptive_Equipment_training" />
               <?php xl('Adaptive Equipment training','e'); ?> </label></td>
            </tr>
          </table>
        </form></td>
        <td>
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Teach_Home_Fall_Safety_Precautions" id="visitnote_Teach_Home_Fall_Safety_Precautions" />
                <?php xl('Teach Home/Fall Safety Precautions','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Teach_alternative_bathing_skills" id="visitnote_Teach_alternative_bathing_skills" />
                <?php xl('Teach alternative bathing, skills (unable to use tub/shower safely)','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Exercises_Safety_Techniques" id="visitnote_Exercises_Safety_Techniques" />
               <?php xl('Exercises/ Safety Techniques given to patient','e'); ?> </label></td>
            </tr>
          </table>
          <p><?php xl('Other','e'); ?>
            <input type="text" name="visitnote_Interventions_Other1" style="width:340px" id="visitnote_Interventions_Other1" />
          </p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e'); ?></strong><br>
      <textarea name="visitnote_Specific_Training_Visit" id="visitnote_Specific_Training_Visit" cols="118" rows="2"></textarea>
      <br><strong><?php xl('Has the patient had any changes in medications since the last visit?','e'); ?>
      <input type="checkbox" name="visitnote_changes_in_medications_Yes"  id="visitnote_changes_in_medications_Yes" value="Yes"/>
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_changes_in_medications_Yes" id="visitnote_changes_in_medications_No" value="No"/>
<?php xl('No','e'); ?>

<br/> <?php xl('If yes, update medication profile','e'); ?> </strong><br />
    </td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('FUNCTIONAL IMPROVEMENTS IN THE FOLLOWING AREAS','e'); ?><br />
    </strong>
      <input type="checkbox" name="visitnote_Functional_Improvement_ADL" id="visitnote_Functional_Improvement_ADL" />
<?php xl('ADL','e'); ?> 
<input type="text" style="width:158px" name="visitnote_Functional_Improvement_ADL_Notes" id="visitnote_Functional_Improvement_ADL_Notes" />
<input type="checkbox" name="visitnote_Functional_Improvement_ADL1" id="visitnote_Functional_Improvement_ADL1" />
<?php xl('ADL','e'); ?>
<input type="text" style="width:158px" name="visitnote_Functional_Improvement_ADL1_Notes" id="visitnote_Functional_Improvement_ADL1_Notes" />
<input type="checkbox" name="visitnote_Functional_Improvement_IADL" id="visitnote_Functional_Improvement_IADL" />
<?php xl('IADL','e'); ?> 
<input type="text" style="width:158px" name="visitnote_Functional_Improvement_IADL_Notes" id="visitnote_Functional_Improvement_IADL_Notes" />
<input type="checkbox" name="visitnote_Functional_Improvement_IADL1" id="visitnote_Functional_Improvement_IADL1" />
<?php xl('IADL','e'); ?> 
<input type="text" style="width:158px" name="visitnote_Functional_Improvement_IADL1_Notes" id="visitnote_Functional_Improvement_IADL1_Notes" /> 
<br />
<input type="checkbox" name="visitnote_Functional_Improvement_ROM" id="visitnote_Functional_Improvement_ROM" />
<?php xl('ROM in','e'); ?>&nbsp;
<input type="text" style="width:800px" name="visitnote_Functional_Improvement_ROM_In" id="visitnote_Functional_Improvement_ROM_In" /><br>
<input type="checkbox" name="visitnote_Functional_Improvement_SM" id="visitnote_Functional_Improvement_SM" />
<?php xl('Safety Management in','e'); ?>&nbsp;
<input type="text" style="width:700px" name="visitnote_Functional_Improvement_SM_In" id="visitnote_Functional_Improvement_SM_In" />
<br />
<input type="checkbox" name="visitnote_Functional_Improvement_EA" id="visitnote_Functional_Improvement_EA" />
<?php xl('Environment Adaptations including','e'); ?>&nbsp;
<input type="text" style="width:615px" name="visitnote_Functional_Improvement_EA_including" id="visitnote_Functional_Improvement_EA_including" /> 
<br />
<input type="checkbox" name="visitnote_Functional_Improvement_AEU" id="visitnote_Functional_Improvement_AEU" />
<?php xl('Adaptive Equipment Usage for','e'); ?>&nbsp;
<input type="text" style="width:640px" name="visitnote_Functional_Improvement_AEU_For" id="visitnote_Functional_Improvement_AEU_For" /><br>
<input type="checkbox" name="visitnote_Functional_Improvement_Car_Fam_Perf" id="visitnote_Functional_Improvement_Car_Fam_Perf" />
<?php xl('Caregiver/Family Performance in','e'); ?>&nbsp;
<input type="text" style="width:620px" name="visitnote_Functional_Improvement_Car_Fam_Perf_In"  id="visitnote_Functional_Improvement_Car_Fam_Perf_In" />
<br />
<input type="checkbox" name="visitnote_Functional_Improvement_Perf_Home_Exer" id="visitnote_Functional_Improvement_Perf_Home_Exer" />
<?php xl('Performance of Home Exercises for','e'); ?>&nbsp;
 <input type="text" style="width:602px" name="visitnote_Functional_Improvement_Perf_Home_Exer_For" id="visitnote_Functional_Improvement_Perf_Home_Exer_For" />
 <br /> 
 <?php xl('Other','e'); ?>&nbsp;
<input type="text" style="width:900px" name="visitnote_Functional_Improvement_Other" id="visitnote_Functional_Improvement_Other" /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('Has the patient had a fall since the last visit? ','e'); ?>
      <input type="checkbox" name="visitnote_Previous_fall" value="yes" id="visitnote_Fall_since_Last_Visit_Yes" />
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_Previous_fall" value="no" id="visitnote_Fall_since_Last_Visit_No" />
<?php xl('No If Yes, complete incident report.','e'); ?><br />
<?php xl('Timed Up and Go Score ','e'); ?>
<input type="text" name="visitnote_Timed_Up_Go_Score" id="visitnote_Timed_Up_Go_Score" /> 
    </strong> <strong> <?php xl('Interpretation','e'); ?> </strong>
    <input type="checkbox" name="visitnote_Fall_Risk" value="No Fall Risk" id="visitnote_Interpretation_No_Fall_Risk" />
<strong><?php xl('Independent-No Fall Risk (&lt; 11 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Fall_Risk" value="Minimal Fall Risk" id="visitnote_Interpretation_Minimal_Fall_Risk" />
<strong><?php xl('Minimal Fall Risk (11- 13 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Fall_Risk" value="Moderate Fall Risk" id="visitnote_Interpretation_Moderate_Fall_Risk" />
<strong><?php xl('Moderate Fall Risk (13.5-19 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Fall_Risk" value="High Fall Risk" id="visitnote_Interpretation_High_Fall_Risk" />
<strong><?php xl('High Risk for Falls (&gt;19 seconds)','e'); ?> </strong><br />
<strong><?php xl('Other Tests/Scores/Interpretations','e'); ?> 
<input type="text" name="visitnote_Other_Tests_Scores_Interpretations" style="width:670px" id="visitnote_Other_Tests_Scores_Interpretations" />
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PATIENT/CAREGIVER/FAMILY RESPONSE TO REVISIT','e'); ?></strong> 
    <input type="checkbox" name="visitnote_Response" value="Verbalized Understanding" id="visitnote_RT_Revisit_Verbalized_Understanding" />
<?php xl('Verbalized Understanding','e'); ?>
  <input type="checkbox" name="visitnote_Response" value="Demonstrated Task" id="visitnote_RT_Revisit_Demonstrated_Task" />
<?php xl('Demonstrated Task','e'); ?>
<input type="checkbox" name="visitnote_Response" value="Needed Guidance" id="visitnote_RT_Revisit_Needed_Guidance" />
<?php xl('Needed Guidance/Re-Instruction','e'); ?><br />
<?php xl('Other','e'); ?> <strong>
<input type="text" style="width:900px" name="visitnote_RT_Revisit_Other" id="visitnote_RT_Revisit_Other" />
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong>
    <input type="checkbox" name="visitnote_CarePlan_Reviewed_With" id="visitnote_CarePlan_Reviewed_With" />
<?php xl('CARE PLAN REVIEWED WITH','e'); ?>
  <input type="checkbox" name="visitnote_Discharge_Discussed_With" id="visitnote_Discharge_Discussed_With" />
<?php xl('DISCHARGE DISCUSSED WITH','e'); ?></strong>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Patient" id="visitnote_DDW_Patient" />
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Physician" id="visitnote_DDW_Physician" />
<?php xl('Physician','e'); ?>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="PT_OT_ST" id="visitnote_DDW_PT_OT_ST" />
<?php xl('PT/OT/ST','e'); ?><br />
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Skilled Nursing" id="visitnote_CPRW_Skilled_Nursing" />
<?php xl('Skilled Nursing','e'); ?>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Caregiver Family" id="visitnote_CPRW_Caregiver_Family" />
<?php xl('Caregiver/Family','e'); ?>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Case Manager" id="visitnote_CPRW_Case_Manager" />
<?php xl('Case Manager','e'); ?> &nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> <strong>
<input type="text" name="visitnote_CPRW_Other" style="width:465px" id="visitnote_CPRW_Other" />
</strong>
<br />
<input type="checkbox" name="visitnote_CP_Modifications_Include" id="visitnote_CP_Modifications_Include" />
<strong><?php xl('CARE PLANS MODIFICATIONS INCLUDE','e'); ?>&nbsp;
<input type="text" style="width:610px" name="visitnote_CP_Modifications_Include_Notes" id="visitnote_CP_Modifications_Include_Notes" />
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row">
    <p><strong><?php xl('FURTHER SKILLED VISITS REQUIRED TO: ','e'); ?></strong> 
    <input type="text" name="visitnote_further_Visit_Required_text" id="visitnote_further_Visit_Required_text" value="" style="width:465px;" />
    <input type="checkbox" name="visitnote_further_Visit_Required" value="Reprioritize exercise" id="visitnote_FSVR_Progress_Reprioritize_exercise" />
<?php xl('Progress/Re-prioritize exercise program','e'); ?>
  <input type="checkbox" name="visitnote_further_Visit_Required" value="Train patient in additional skills" id="visitnote_FSVR_Train_patient" />
<?php xl('Train patient in additional skills such as','e'); ?><br>
<input type="checkbox" name="visitnote_further_Visit_Required" value="Begin Practice" id="visitnote_FSVR_Begin_Practice" />
<?php xl('Begin/Practice','e'); ?>
<input type="checkbox" name="visitnote_further_Visit_Required" value="IADLs" id="visitnote_FSVR_IADLs" />
<?php xl('IADLs','e'); ?>
<input type="checkbox" name="visitnote_further_Visit_Required" value="ADLs" id="visitnote_FSVR_ADLs" />
<?php xl('ADLs','e'); ?>
<input type="checkbox" name="visitnote_further_Visit_Required" value="Caregiver/Family" id="visitnote_FSVR_Train_Caregiver_Family" />
<?php xl('Train Caregiver/Family','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?>
<strong>
<input type="text" style="width:420px" name="visitnote_FSVR_Other" id="visitnote_FSVR_Other" />
</strong>
</p>
<p>
 <?php xl('Approximate Date of Next Visit','e'); ?>
    <input type='text' size='20' name='visitnote_Date_of_Next_Visit' id='visitnote_Date_of_Next_Visit'
    value='<?php echo $date ?>'
    title='<?php xl('Date','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly />
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_curr_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"visitnote_Date_of_Next_Visit", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>

<input type="checkbox" name="visitnote_No_further_visits" value="Met Goals" id="visitnote_No_further_visits" />
<?php xl('No further visits required Patient/Caregiver have met goals','e'); ?>
<input type="checkbox" name="visitnote_No_further_visits" value="Met max potential" id="visitnote_No_further_visits_PC_Met_max_potential" />
<?php xl('No further visits required. Patient/Caregiver have met maximum  potential that can be impacted by therapy.','e'); ?>
</p></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PLAN','e'); ?></strong><br/>
    <p>
      <input type="checkbox" name="treatment_Plan" value="Current Treatment Plan Frequency and Duration is Appropriate" id="visitnote_Plan_Current_Treatment_Plan" />
<?php xl('Current Treatment Plan Frequency and Duration is Appropriate','e'); ?>
</p>
<p>
<input type="checkbox" name="treatment_Plan" value="Initiate Discharge, physician order and summary of treatment" id="visitnote_Plan_Initiate_Discharge" />
<?php xl('Initiate Discharge, physician order and summary of treatment','e'); ?>
</p>
<p>
<input type="checkbox" name="treatment_Plan" value="May require additional treatment session" id="visitnote_Plan_Require_Additional_Treatment" />
<?php xl('May require additional treatment session(s) to achieve Long Term Outcomes due to ','e'); ?>
<input type="checkbox" name="Additional_Treatment" value="short term memory difficulties" id="visitnote_Plan_Short_term_memory" />
<?php xl('short term memory difficulties','e'); ?>
<input type="checkbox" name="Additional_Treatment" value="minimal support systems" id="visitnote_Plan_minimal_support" />
<?php xl('minimal support systems','e'); ?>
<input type="checkbox" name="Additional_Treatment" value="communication, language barriers" id="visitnote_Plan_Communication_language_barriers" />
<?php xl('communication, language barriers','e'); ?>
</p>
<p>
<input type="checkbox" name="treatment_Plan" value="Will address above issues" id="visitnote_Plan_Address_above_issues" />
<?php xl('Will address above issues by','e'); ?>
<input type="checkbox" name="issues_Communication" value="Providing written directions" id="visitnote_Plan_Providing_written_directions" />
<?php xl('Providing written directions and/or physical demonstration','e'); ?>
<input type="checkbox" name="issues_Communication" value="establish community support systems" id="visitnote_Plan_Establish_community_support" />
<?php xl('establish community support systems','e'); ?>
<input type="checkbox" name="issues_Communication" value="home/environmental adaptations" id="visitnote_Plan_Home_env_adaptations" />
<?php xl('home/environmental adaptations','e'); ?>
<input type="checkbox" name="issues_Communication" value="use_family/professionals" id="visitnote_Plan_Use_family_professionals" />
<?php xl('use family/professionals for interpretations as needed','e'); ?>
</p> </td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SUPERVISOR VISIT (if  applicable)','e'); ?> </strong>
      <input type="checkbox" name="supervisor_visit" value="OTAssistant" id="visitnote_Supervisorvisit_OT_Assistant" />
<?php xl('OT Assistant','e'); ?>
<input type="checkbox" name="supervisor_visit" value="Aide" id="visitnote_Supervisorvisit_Aide" />
<?php xl('Aide /','e'); ?>
<input type="checkbox" name="supervisor_visit" value="Present" id="visitnote_Supervisorvisit_Present" />
<?php xl('Present','e'); ?>
<input type="checkbox" name="supervisor_visit" value="Not Present" id="visitnote_Supervisorvisit_Not_Present" />
<?php xl('Not Present','e'); ?>
<input type="checkbox" name="supervisor_visit" value="Contacted visit" id="visitnote_Supervisorvisit_Contacted_regarding_visit" />
<?php xl('Contacted regarding visit','e'); ?>
<br><label> <?php xl('Observed','e')?> </label>
<input type="text" style="width:40%"  name="visitnote_Supervisory_visit_Observed" id="visitnote_Supervisory_visit_Observed" />
<label> <?php xl('Teaching/Training','e')?> </label>
<input type="text" style="width:37%"  name="visitnote_Supervisory_visit_Teaching_Training" id="visitnote_Supervisory_visit_Teaching_Training" />
<label> <?php xl('Patient/Family Discussion','e')?> </label>
<input type="text" style="width:40%"  name="visitnote_Supervisory_visit_Patient_Family_Discussion" id="visitnote_Supervisory_visit_Patient_Family_Discussion" />

</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr>
        <td width="50%" scope="row"><strong><?php xl('Therapist Signature ','e'); ?></strong><?php xl('(Name/Title)','e'); ?></td>
        <td width="50%"><strong><?php xl('Electronic Signature','e'); ?></strong></td>
      </tr>
    </table></td>
  </tr>
  </table>
  <a href="javascript:top.restoreSession();document.visitnotes.submit();" class="link_submit" onClick="return requiredCheck()">[<?php xl('Save','e'); ?>]</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

 </form>
</body>
</html>

