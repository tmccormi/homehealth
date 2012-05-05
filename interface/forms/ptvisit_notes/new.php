<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("functions.php");
formHeader("Form: visit_notes");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php html_header_show();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php xl('PHYSICAL THERAPY REVISIT NOTE','e')?></title>
<style type="text/css">
@import url(<?php echo $GLOBALS['webroot']?>/library/dynarch_calendar.css);</style>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
</head>

<body><h3 align="center"><?php xl('PHYSICAL THERAPY REVISIT NOTE','e'); ?></h3>
<form method=post action="<?php echo $rootdir;?>/forms/ptvisit_notes/save.php?mode=new" name="visitnotes">
<a href="javascript:top.restoreSession();document.visitnotes.submit();" class="link_submit">[<?php xl('Save','e'); ?>]</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
<br></br>
<table width="100%" border="1" cellpadding="2px">
  <tr>
    <td scope="row">
    <table width="100%" border="1" cellpadding="2px">
      <tr>
        <td scope="row"><strong><?php xl('Patient Name','e'); ?></strong></td>
        <td align="center" valign="top">
        <input type="text" name="patient_name" id="patient_name" value="<?php patientName()?>" disabled /></td>
        <td><strong><?php xl('Time In','e'); ?></strong></td>
        <td><select name="visitnote_Time_In" id="visitnote_Time_In"><?php timeDropDown($GLOBALS['Selected']) ?></select></td>
        <td><strong><?php xl('Time Out','e'); ?></strong></td>
        <td><select name="visitnote_Time_Out" id="visitnote_Time_Out"><?php timeDropDown($GLOBALS['Selected']) ?></select></td>
        <td><strong><?php xl('Date','e'); ?></strong></td>
        <td>
        <input type='text' size='10' name="visitnote_visitdate" id='visitnote_visitdate' title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					 readonly/> 
		<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_visit_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
		<script	LANGUAGE="JavaScript">
        Calendar.setup({inputField:"visitnote_visitdate", ifFormat:"%Y-%m-%d", button:"img_visit_date"});
       </script>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('TYPE OF VISIT','e'); ?> </strong>
      <input type="checkbox" name="visitnote_Type_of_Visit" value="visit" id="visitnote_Type_of_Visit" />
<?php xl('ReVisit','e'); ?>
<input type="checkbox" name="visitnote_Type_of_Visit" value="visit_Supervisory" id="visitnote_Type_of_Visit" />
<?php xl('ReVisit and Supervisory Review Other','e'); ?> 
<input type="text" size="50px" name="visitnote_Type_of_Visit_Other" id="visitnote_Type_of_Visit_Other" /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('VITAL SIGNS','e'); ?></strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pulse','e'); ?> 
    <input type="text" size="3px" name="visitnote_VS_Pulse" id="visitnote_VS_Pulse" /> 
    <input type="checkbox" name="visitnote_VS_Pulse_type" value="regular" id="visitnote_VS_Pulse_type" />
<?php xl('Regular','e'); ?>
<input type="checkbox" name="visitnote_VS_Pulse_type" value="Irregular" id="visitnote_VS_Pulse_type" />
<?php xl('Irregular','e'); ?> &nbsp;
<?php xl('Temperature','e'); ?>
 <input type="text" size="3px" name="visitnote_VS_Temperature" id="visitnote_VS_Temperature" /> 
 <input type="checkbox" name="visitnote_VS_Temperature_type" value="Oral" id="visitnote_VS_Temperature_type" />
<?php xl('Oral','e'); ?>
<input type="checkbox" name="visitnote_VS_Temperature_type" value="Temporal" id="visitnote_VS_Temperature_type" />
<?php xl('Temporal','e'); ?>&nbsp;
<?php xl('Other','e'); ?> &nbsp;
<input type="text" size="10px" name="visitnote_VS_Other" id="visitnote_VS_Other" />
 <?php xl('Respirations','e'); ?>
 <input type="text" size="3px" name="visitnote_VS_Respirations" id="visitnote_VS_Respirations" />
  <p><?php xl('Blood Pressure Systolic','e'); ?>
  <input type="text" size="3px" name="visitnote_VS_BP_Systolic" id="visitnote_VS_BP_Systolic" />
  /
  <input type="text" size="3px" name="visitnote_VS_BP_Diastolic" id="visitnote_VS_BP_Diastolic" />
<input type="checkbox" name="visitnote_VS_BP_side" value="Right" id="visitnote_VS_BP_side" />
<?php xl('Right','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_side" value="Left" id="visitnote_VS_BP_side" />
<?php xl('Left','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Sitting" id="visitnote_VS_BP_Sitting" />
<?php xl('Sitting','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Standing" id="visitnote_VS_BP_Standing" />
<?php xl('Standing','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Lying" id="visitnote_VS_BP_Lying" />
<?php xl('Lying *O2 Sat','e'); ?> 
<input type="text" size="7px" name="visitnote_VS_BP_Sat" id="visitnote_VS_BP_Sat" /> *<?php xl('Physician ordered','e'); ?> </p></td>

  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pain','e'); ?>
  <input type="checkbox" name="visitnote_VS_Pain_paintype" value="NoPain" id="visitnote_VS_Pain_Nopain" />
<?php xl('No Pain','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="Pain" id="visitnote_VS_Pain_Pain_limits" />
<?php xl('Pain limits functional ability Intensity','e'); ?>
<input type="text" name="visitnote_VS_Pain_Intensity" id="visitnote_VS_Pain_Intensity" />
<input type="checkbox" name="visitnote_VS_Pain_Level" value="Improve" id="visitnote_VS_Pain_Intensity_Improve" />
<?php xl('Improve','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_Level" value="Worse" id="visitnote_VS_Pain_Intensity_Worse" />
<?php xl('Worse','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_Level" value="No_Change" id="visitnote_VS_Pain_Intensity_No_Change" />
<?php xl('No Change','e'); ?></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><p><strong><?php xl('Please Note   Contact MD if Vital Signs are   Pulse &lt;56 or &gt;120;   Temperature   &lt;56 or &gt;101;   Respirations  &lt;10 or &gt;30<br />SBP &lt;80 or &gt;190; DBP &lt;50  or  &gt;100;  Pain   Significantly  Impacts patients ability to participate.    O2 Sat &lt;90% after rest','e'); ?></strong></p></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM','e'); ?></strong>
    <select id="visitnote_Treatment_Diagnosis_Problem" name="visitnote_Treatment_Diagnosis_Problem">
					<?php ICD9_dropdown($GLOBALS['Selected']) ?>
				</select></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px">
        <tr>
          <td valign="top" scope="row"><table width="100%">
              <tr>
                <td><label>
                  <strong><?php xl('PATIENT CONTINUES TO BE HOMEBOUND DUE TO','e'); ?></strong><br />
                  <input type="checkbox" name="visitnote_Pat_Homebound_Needs_assistance" id="visitnote_Pat_Homebound_Needs_assistance" />
                  <?php xl('Needs assistance in all activities of daily living','e'); ?></label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Unable_leave_home" id="visitnote_Pat_Homebound_Unable_leave_home" />
                 <?php xl('Unable to leave home safely without assistance','e'); ?> </label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Medical_Restrictions"id="visitnote_Pat_Homebound_Medical_Restrictions" />
                  <?php xl('Medical Restrictions in','e'); ?></label>
                  <input type="text" name="visitnote_Pat_Homebound_Medical_Restrictions_In" size="35px" id="visitnote_Pat_Homebound_Medical_Restrictions_In" />
                </td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_SOB_upon_exertion" id="visitnote_Pat_Homebound_SOB_upon_exertion" />
                  <?php xl('SOB upon exertion','e'); ?></label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Pain_with_Travel" id="visitnote_Pat_Homebound_Pain_with_Travel" />
                  <label><?php xl('Pain with Travel','e'); ?></label></td>
              </tr>
            </table>
          <td valign="top">
            <table width="100%">
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_mobility_ambulation" id="visitnote_Pat_Homebound_mobility_ambulation" />
                  <?php xl('Requires assistance in mobility and ambulation','e'); ?></label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Arrhythmia" id="visitnote_Pat_Homebound_Arrhythmia" />
                  </label>
<label><?php xl('Arrhythmia','e'); ?>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Bed_Bound" id="visitnote_Pat_Homebound_Bed_Bound" />
</label>
<label><?php xl('Bed Bound','e'); ?>
<input type="checkbox" name="visitnote_Pat_Homebound_Residual_Weakness" id="visitnote_Pat_Homebound_Residual_Weakness" />
<?php xl('Residual Weakness','e'); ?></label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="visitnote_Pat_Homebound_Confusion" id="visitnote_Pat_Homebound_Confusion" />
                  <?php xl('Confusion, unable to go out of home alone','e'); ?></td>
              </tr>
            </table>
            <p><?php xl('Other','e'); ?> 
              <input type="text" name="visitnote_Pat_Homebound_Other" size="35px" id="visitnote_Pat_Homebound_Other" />
            </p></td>
        </tr>
    </table>      
      <strong><?php xl('INTERVENTIONS','e'); ?> 
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" value="Patient"/>
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" value="Caregiver"/>
<?php xl('Caregiver','e'); ?>
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" value="Patient and Caregiver"/>
<?php xl('Patient and Caregiver Other','e'); ?>
<input type="text" name="visitnote_Interventions_Other" size="35px" id="visitnote_Interventions_Other" /></strong>
<br /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px">
      <tr valign="top">
        <td scope="row">
          <table width="100%">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Evaluation" id="visitnote_Evaluation" />
                <?php xl('Evaluation','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Therapeutic_Exercises" id="visitnote_Therapeutic_Exercises" />
                <?php xl('Therapeutic Exercises','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Gait_Training" id="visitnote_Gait_Training" />
                <?php xl('Gait Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Bed_Mobility" id="visitnote_Bed_Mobility" />
                <?php xl('Bed Mobility','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Training_Transfer" id="visitnote_Training_Transfer" />
                <?php xl('Training Transfer Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Balance_Training_Activities" id="visitnote_Balance_Training_Activities" />
               <?php xl('Balance Training/Activities','e'); ?> </label></td>
            </tr>
	      <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Patient_Caregiver_Family_Education" id="visitnote_Patient_Caregiver_Family_Education" />
               <?php xl('Patient/Caregiver/Family Education','e'); ?> </label></td>
            </tr>
          </table>
        </td>
        <td>
          <table width="100%">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Assistive_Device_Training" id="visitnote_Assistive_Device_Training" />
               <?php xl('Assistive Device Training','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Neuro_developmental_Training" id="visitnote_Neuro_developmental_Training" />
             <?php xl('Neuro-developmental Training','e'); ?>   </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Orthotics_Splinting" id="visitnote_Orthotics_Splinting" />
               <?php xl('Orthotics/Splinting','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Hip_Safety_Precaution_Training" id="visitnote_Hip_Safety_Precaution_Training" />
                <?php xl('Hip Safety Precaution Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Physical_Agents" id="visitnote_Physical_Agents" />
               <?php xl('Physical Agents','e'); ?> </label></td>
            </tr>
	      <tr>
	  <td> <label> <?php xl('for','e')?>
	  <input type="text" name="visitnote_Physical_Agents_For" size="35px" id="visitnote_Physical_Agents_For" />
	  </td></tr>
	    <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Muscle_ReEducation" id="visitnote_Muscle_ReEducation" />
               <?php xl('Muscle Re-Education','e'); ?> </label></td>
            </tr>
          </table>
        </form></td>
        <td>
          <table width="100%">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Safe_Stair_Climbing_Skills" id="visitnote_Safe_Stair_Climbing_Skills" />
                <?php xl('Safe Stair Climbing Skills','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Exercises_to_manage_pain" id="visitnote_Exercises_to_manage_pain" />
                <?php xl('Exercises to manage pain','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Fall_Precautions_Training" id="visitnote_Fall_Precautions_Training" />
               <?php xl('Fall Precautions Training','e'); ?> </label></td>
            </tr>
	      <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Exercises_Safety_Techniques" id="visitnote_Exercises_Safety_Techniques" />
               <?php xl('Exercises/ Safety Techniques given to patient','e'); ?> </label></td>
            </tr>
          </table>
          <p><?php xl('Other','e'); ?>
            <input type="text" name="visitnote_Other1" size="35px" id="visitnote_Other1" />
          </p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SP','e'); ?></strong><strong><?php xl('ECIFIC TRAINING THIS VISIT','e'); ?></strong>
      <input type="text" name="visitnote_Specific_Training_Visit" size="100px" id="visitnote_Specific_Training_Visit" /><br />
      <strong><?php xl('Has the patient had any changes in medications since the last visit?','e'); ?>
      <input type="checkbox" name="visitnote_changes_in_medications"  id="visitnote_changes_in_medications" value="Yes"/>
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_changes_in_medications" id="visitnote_changes_in_medications" value="No"/>
<?php xl('No','e'); ?>
      <br />     <?php xl('If yes, update medication profile','e'); ?> </strong><br />
    </td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('FUNCTIONAL IMPROVEMENTS IN THE FOLLOWING AREAS','e'); ?><br />
    </strong>
     <input type="checkbox" name="visitnote_FI_Mobility" id="visitnote_FI_Mobility" />
<?php xl('Mobility','e'); ?> 
<input type="checkbox" name="visitnote_FI_ROM" id="visitnote_FI_ROM" />
<?php xl('ROM in','e'); ?> 
<input type="text" size="25px" name="visitnote_FI_ROM_In" id="visitnote_FI_ROM_In" /> 

<input type="checkbox" name="visitnote_FI_Home_Safety_Techniques" id="visitnote_FI_Home_Safety_Techniques" />
<?php xl('Home Safety Techniques in','e'); ?>
<input type="text" size="50px" name="visitnote_FI_Home_Safety_Techniques_In" id="visitnote_FI_Home_Safety_Techniques_In" /> 
<br />
<input type="checkbox" name="visitnote_FI_Assistive_Device_Usage" id="visitnote_FI_Assistive_Device_Usage" />
<?php xl('Assistive Device Usage with','e'); ?>
<input type="text" size="20px" name="visitnote_FI_Assistive_Device_Usage_With" size="50px" id="visitnote_FI_Assistive_Device_Usage_With" />
<input type="checkbox" name="visitnote_FI_Caregiver_Family_Performance" id="visitnote_FI_Caregiver_Family_Performance" />
<?php xl('Caregiver/Family Performance in','e'); ?>
<input type="text" size="50px" name="visitnote_FI_Caregiver_Family_Performance_In" id="visitnote_FI_Caregiver_Family_Performance_In" /> 
<br />
<input type="checkbox" name="visitnote_FI_Performance_of_Home_Exercises" id="visitnote_FI_Performance_of_Home_Exercises" />
<?php xl('Performance of Home Exercises','e'); ?>

<input type="checkbox" name="visitnote_FI_Demonstrates" id="visitnote_FI_Demonstrates" />
<?php xl('Demonstrates','e'); ?>
<input type="text" name="visitnote_FI_Demonstrates_Notes" size="35px" id="visitnote_FI_Demonstrates_Notes" />
<lable> <?php xl('use of prosthesis/brace/splint','e')?> </label>
<br />
 <?php xl('Other','e'); ?>
<input type="text" size="100px" name="visitnote_FI_Other" id="visitnote_FI_Other" /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('Has the patient had a fall since the last visit? ','e'); ?>
      <input type="checkbox" name="visitnote_Fall_since_Last_Visit_type" value="yes" id="visitnote_Fall_since_Last_Visit_type" />
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_Fall_since_Last_Visit_type" value="no" id="visitnote_Fall_since_Last_Visit_type" />
<?php xl('No If Yes, complete incident report.','e'); ?><br />
<?php xl('Timed Up and Go Score ','e'); ?>
<input type="text" name="visitnote_Timed_Up_Go_Score" id="visitnote_Timed_Up_Go_Score" /> 
    </strong> <strong> <?php xl('Interpretation','e'); ?> </strong>
    <input type="checkbox" name="visitnote_Interpretation" value="No_Fall_Risk" id="visitnote_Interpretation" />
<?php xl('Independent-No Fall Risk (&lt; 11 seconds)','e'); ?> 
<input type="checkbox" name="visitnote_Interpretation" value="Minimal_Fall_Risk" id="visitnote_Interpretation" />
<strong><?php xl('Minimal Fall Risk (11- 13 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Interpretation" value="Moderate_Fall_Risk" id="visitnote_Interpretation" />
<strong><?php xl('Moderate Fall Risk (13.5-19 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Interpretation" value="High_Fall_Risk" id="visitnote_Interpretation" />
<strong><?php xl('High Risk for Falls (&gt;19 seconds)','e'); ?> </strong><br />
<strong><?php xl('Other Tests/Scores/Interpretations','e'); ?> 
<input type="text" name="visitnote_Other_Tests_Scores_Interpretations" size="100px" id="visitnote_Other_Tests_Scores_Interpretations" />
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PATIENT/CAREGIVER/FAMILY RESPONSE TO REVISIT','e'); ?></strong> 
    <input type="checkbox" name="visitnote_Response_To_Revisit" value="Verbalized_Understanding" id="visitnote_Response_To_Revisit" />
<?php xl('Verbalized Understanding','e'); ?>
  <input type="checkbox" name="visitnote_Response_To_Revisit" value="Demonstrated_Task" id="visitnote_Response_To_Revisit" />
<?php xl('Demonstrated Task','e'); ?>
<input type="checkbox" name="visitnote_Response_To_Revisit" value="Needed_Guidance" id="visitnote_Response_To_Revisit" />
<?php xl('Needed Guidance/Re-Instruction','e'); ?><br />
<?php xl('Other','e'); ?> <strong>
<input type="text" size="100px" name="visitnote_Response_To_Revisit_Other" id="visitnote_Response_To_Revisit_Other" />
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong>
    <input type="checkbox" name="visitnote_CarePlan_Reviewed" id="visitnote_CarePlan_Reviewed" />
<?php xl('CARE PLAN REVIEWED WITH','e'); ?>
  <input type="checkbox" name="visitnote_Discharge_Discussed" id="visitnote_Discharge_Discussed" />
<?php xl('DISCHARGE DISCUSSED WITH','e'); ?></strong>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Patient" id="visitnote_DDW_Patient" />
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Physician" id="visitnote_DDW_Physician" />
<?php xl('Physician','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="PT_OT_ST" id="visitnote_DDW_PT_OT_ST" />
<?php xl('PTA','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="PTA" id="visitnote_DDW_PT_OT_ST" />
<?php xl('PT/OT/ST','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Skilled_Nursing" id="visitnote_CPRW_Skilled_Nursing" />
<?php xl('Skilled Nursing','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Caregiver_Family" id="visitnote_CPRW_Caregiver_Family" />
<?php xl('Caregiver/Family','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Case_Manager" id="visitnote_CPRW_Case_Manager" />
<?php xl('Case Manager','e'); ?>
<br /> <?php xl('Other','e'); ?>
<input type="text" name="visitnote_CPRW_Other" size="75px" id="visitnote_CPRW_Other" />

<br />
<input type="checkbox" name="visitnote_Careplan_Revised" id="visitnote_Careplan_Revised" />
<strong><?php xl('CARE PLANS REVISED','e'); ?>
<input type="text" size="75px" name="visitnote_Careplan_Revised_Notes" id="visitnote_Careplan_Revised_Notes" />
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row">
    <p><strong><?php xl('FURTHER SKILLED VISITS REQUIRED TO','e'); ?></strong> 
    <input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Reprioritize_exercise" id="visitnote_FSVR_Progress_Reprioritize_exercise" />
<?php xl('Progress/Re-prioritize exercise program','e'); ?>
  <input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Train_patient" id="visitnote_FSVR_Train_patient" />
<?php xl('Train patient in additional skills such as','e'); ?>
<input type="text" name="visitnote_Train_patient_Suchas_Notes" id="visitnote_Train_patient_Suchas_Notes" />
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Begin_Practice" id="visitnote_FSVR_Begin_Practice" />
<?php xl('Begin/Practice','e'); ?>
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="IADLs" id="visitnote_FSVR_IADLs" />
<?php xl('IADLs','e'); ?>
<input type="text" name="visitnote_FSVR_IADLs_Notes" id="visitnote_FSVR_IADLs_Notes" />
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="ADLs" id="visitnote_FSVR_ADLs" />
<?php xl('ADLs','e'); ?>
<input type="text" name="visitnote_FSVR_ADLs_Notes" id="visitnote_FSVR_ADLs_Notes" />
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Caregiver/Family" id="visitnote_FSVR_Train_Caregiver_Family" />
<?php xl('Train Caregiver/Family','e'); ?> &nbsp; &nbsp;&nbsp;
<br/><?php xl('Other','e'); ?>
<strong>
<input type="text" size="150px" name="visitnote_FSVR_Other" id="visitnote_FSVR_Other" />
</strong>
</p>
<p>
 <?php xl('Approximate Date of Next Visit','e'); ?>
<input type="text" name="visitnote_Date_of_Next_Visit" id="visitnote_Date_of_Next_Visit" />
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value=Met_Goals" id="visitnote_Date_of_Next_Visit" />
<?php xl('No further visits required Patient/Caregiver have met goals','e'); ?>
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Met_max_potential" id="visitnote_No_further_visits_PC_Met_max_potential" />
<?php xl('No further visits required. Patient/Caregiver have met maximum  potential that can be impacted by therapy.','e'); ?>
</p></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PLAN','e'); ?></strong><br/>
    <p>
      <input type="checkbox" name="visitnote_Plan_Type" value="Curr_Treatment_Appropriate" id="visitnote_Plan_Current_Treatment_Plan" />
<?php xl('Current Treatment Plan Frequency and Duration is Appropriate','e'); ?>
</p>
<p>
<input type="checkbox" name="visitnote_Plan_Type" value="Initiate_Discharge" id="visitnote_Plan_Initiate_Discharge" />
<?php xl('Initiate Discharge, physician order','e'); ?>
</p>
<p>
<input type="checkbox" name="visitnote_Plan_Type" value="May_require_treatment" id="visitnote_Plan_Require_Additional_Treatment" />
<?php xl('May require additional treatment session(s) to achieve Long Term Outcomes due to ','e'); ?>
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="shortterm_memory" id="visitnote_Plan_Short_term_memory" />
<?php xl('short term memory difficulties','e'); ?>
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="Minimal_Support" id="visitnote_Plan_minimal_support" />
<?php xl('minimal support systems','e'); ?>
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="language_barriers" id="visitnote_Plan_Communication_language_barriers" />
<?php xl('communication, language barriers','e'); ?>
</p>
<p>
<input type="checkbox" name="visitnote_Plan_Type" value="Will_address_issues_by" id="visitnote_Plan_Address_above_issues" />
<?php xl('Will address above issues by','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="physical_demonstration" id="visitnote_Plan_Providing_written_directions" />
<?php xl('Providing written directions and/or physical demonstration','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="community_support" id="visitnote_Plan_Establish_community_support" />
<?php xl('establish community support systems','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="home_adaptations" id="visitnote_Plan_Home_env_adaptations" />
<?php xl('home/environmental adaptations','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="use_family/professionals" id="visitnote_Plan_Use_family_professionals" />
<?php xl('use family/professionals for interpretations as needed','e'); ?>
</p> </td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SUPERVISOR VISIT (if  applicable)','e'); ?> </strong>
      <input type="checkbox" name="visitnote_Supervisory_visit" value="ot_Assistant" id="visitnote_Supervisorvisit_OT_Assistant" />
<?php xl('OT Assistant','e'); ?>
<input type="checkbox" name="visitnote_Supervisory_visit" value="Aide" id="visitnote_Supervisorvisit_Aide" />
<?php xl('Aide /','e'); ?>
<input type="checkbox" name="visitnote_Supervisory_visit" value="Present" id="visitnote_Supervisorvisit_Present" />
<?php xl('Present','e'); ?>
<input type="checkbox" name="visitnote_Supervisory_visit" value="Not_Present" id="visitnote_Supervisorvisit_Not_Present" />
<?php xl('Not Present','e'); ?>
<input type="checkbox" name="visitnote_Supervisory_visit" value="Contacted_visit" id="visitnote_Supervisorvisit_Contacted_regarding_visit" />
<?php xl('Contacted regarding visit','e'); ?>
<br><label> <?php xl('Observed','e')?> </label>
<input type="text" name="visitnote_Supervisory_visit_Observed" id="visitnote_Supervisory_visit_Observed" />
<label> <?php xl('Teaching/Training','e')?> </label>
<input type="text" name="visitnote_Supervisory_visit_Teaching_Training" id="visitnote_Supervisory_visit_Teaching_Training" />
<label> <?php xl('Patient/Family Discussion','e')?> </label>
<input type="text" name="visitnote_Supervisory_visit_Patient_Family_Discussion" id="visitnote_Supervisory_visit_Patient_Family_Discussion" />
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px">
      <tr>
        <td width="50%" scope="row"><strong><?php xl('Therapist Signature ','e'); ?></strong><?php xl('(Name/Title)','e'); ?></td>
        <td width="50%"><strong><?php xl('Electronic Signature','e'); ?></strong></td>
      </tr>
    </table></td>
  </tr>
  </table>
 </form>
</body>
</html>

