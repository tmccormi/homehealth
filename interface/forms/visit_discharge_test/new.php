<?php 
require_once("../../globals.php");
require_once ("functions.php");
include_once("$srcdir/api.inc");
include_once("../../calendar.inc");
formHeader("Form: visit_discharge");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php html_header_show();?>
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<style type="text/css">
    .formtable {
        font-size:14px;
		line-height: 24px;
    }    
	.formtable tr td {
		line-height: 24px;
    }
</style>
</head>

<body>
<form method=post action="<?php echo $rootdir;?>/forms/visit_discharge_test/save.php?mode=new" name="my_form">
<span class="title"><?php xl('Visit/Discharge Note','e');?></span><br><br>
<table width="100%" padding="2px"border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row"><strong><?php xl('Patient Name','e');?></strong></th>
    <td><input type="text" name="patient_name" id="patient_name" value="<?php patientName()?>" disabled/></td>
    <td width="70"><strong><?php xl('Time In','e');?></strong></td>
    <td><select name="dischargeplan_Time_In" id="dischargeplan_Time_In"><?php timeDropDown()?></select></td>
    <td width="70"><strong><?php xl('Time Out','e');?></strong> <br /></td>
    <td><select name="dischargeplan_Time_Out" id="dischargeplan_Time_Out"><?php timeDropDown()?></select></td>
    <td width="70"><strong><?php xl('Date','e');?></strong></td>
    <td><strong>
    <input type='text' size='20' name='dischargeplan_date' id='dischargeplan_date'
    value='<?php echo $date ?>'
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' />
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_curr_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"dischargeplan_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
                                </td> 
       </strong>
	</td>
  </tr>
</table>
  </tr>

  <tr>
    <td scope="row"><p><strong><?php xl('Vital Signs','e');?></strong></p></tr>
  <tr>
    <td scope="row"></th>
      <?php xl('Pulse','e');?>
<label for="pulse"></label>
    <input type="text"  size="5px" name="dischargeplan_Vital_Signs_Pulse" id="dischargeplan_Vital_Signs_Pulse" />
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Regular" value="Regular" id="dischargeplan_Vital_Signs_Regular" />

        <?php xl('Regular','e');?></label>
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Regular" value="Irregular" id="dischargeplan_Vital_Signs_Irregular" />
        <?php xl('Irregular','e');?></label>&nbsp; &nbsp; &nbsp;
     <?php xl('Temperature','e');?> <input size="5px" type="text" name ="dischargeplan_Vital_Signs_Temperature" id="dischargeplan_Vital_Signs_Temperature" />
     <label>

        <input type="checkbox" name="dischargeplan_Vital_Signs_Oral" value="Oral" id="dischargeplan_Vital_Signs_Oral" />
        <?php xl('Oral','e');?></label>
     <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Oral" value="Temporal" id="dischargeplan_Vital_Signs_Temporal" />
        <?php xl('Temporal','e');?></label>
     &nbsp;  &nbsp;
 &nbsp;   <?php xl('Other','e');?> 
 <input type="text" size="20px" name="dischargeplan_Vital_Signs_other" id="dischargeplan_Vital_Signs_other" />
 <?php xl('Respirations','e');?>    <input type="text" size="5px" name="dischargeplan_Vital_Signs_Respirations" id="dischargeplan_Vital_Signs_Respirations" /> <br/>
 <?php xl('Blood Pressure Systolic','e');?>   <input type="text" size="5px" name="dischargeplan_Vital_Signs_BP_Systolic" id="dischargeplan_Vital_Signs_BP_Systolic" />/

<input type="text" size="5px" name="dischargeplan_Vital_Signs_BP_Diastolic" id="dischargeplan_Vital_Signs_BP_Diastolic" />  <?php xl('Diastolic','e');?>
 <label>
   <input type="checkbox" name="dischargeplan_Vital_Signs_Right" value="Right" id="dischargeplan_Vital_Signs_Right" />
      <?php xl('Right','e');?></label>

 <label>
   <input type="checkbox" name="dischargeplan_Vital_Signs_Right" value="Left" id="dischargeplan_Vital_Signs_Left" />
       <?php xl('Left','e');?></label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_Sitting" value="Sitting" id="dischargeplan_Vital_Signs_Sitting" />
      <?php xl('Sitting','e');?></label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_Sitting" value="Standing" id="dischargeplan_Vital_Signs_Standing" />

      <?php xl('Standing','e');?> </label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_Sitting" value="Lying" id="dischargeplan_Vital_Signs_Lying" />
     <?php xl('Lying *O2 Sat','e');?> 
     <input type="text" size="5px" name="dischargeplan_Vital_Signs_Sat" id="dischargeplan_Vital_Signs_Sat" />
     </label> 
     <?php xl('*Physician ordered','e');?> 
     <br>
     <?php xl('Pain Intensity','e');?> <input type="text" size="7px" name="dischargeplan_Vital_Signs_Pain_Intensity" id="dischargeplan_Vital_Signs_Pain_Intensity" />
     
     <?php xl('Pain continues to persist at discharge due to','e');?>
          <label>
            <input type="checkbox" name="dischargeplan_Vital_Signs_chronic_condition" id="dischargeplan_Vital_Signs_chronic_condition" />
            <?php xl('chronic condition under physicians care,','e');?></label>
  <br/>
          <label>
            <input type="checkbox" name="dischargeplan_Vital_Signs_Patient_states"  id="dischargeplan_Vital_Signs_Patient_states" />
    <?php xl('Patient states current medical regime is managing his/her pain;','e');?></label>
      <?php xl('Other','e');?> <input type="text" name="dischargeplan_Vital_Signs_Patient_states_other" id="dischargeplan_Vital_Signs_Patient_states_other" size="60px"/>
      <br /></tr>
      <tr>
    <td scope="row"></td></tr>
  <tr>
    <td scope="row"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM','e');?> </strong>
    <select name="dischargeplan_treatment_diagnosis_problem" id="dischargeplan_treatment_diagnosis_problem"><?php ICD9_dropdown()?></select>
  </tr>
  <tr>

    <td scope="row"><p><strong><?php xl('Mental Status','e');?></strong></p>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_Alert"  id="dischargeplan_Mental_Status_Alert" />
          <?php xl('Alert','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_Oriented"  id="dischargeplan_Mental_Status_Oriented" />

          <?php xl('Oriented','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_Forgetful"  id="dischargeplan_Mental_Status_Forgetful" />
          <?php xl('Forgetful','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_Disoriented"  id="dischargeplan_Mental_Status_Disoriented" />
          <?php xl('Disoriented','e');?></label>

          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_Depressed"  id="dischargeplan_Mental_Status_Depressed" />
          <?php xl('Depressed','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_Agitated" id="dischargeplan_Mental_Status_Agitated" />
          <?php xl('Agitated','e');?></label>
          <?php xl('Other','e');?>
          <input type="text" name="dischargeplan_Mental_Status_Other" id="dischargeplan_Mental_Status_Other" /><br />
		  <?php xl('Based on cognitive impairment the following interventions have been provided by the home health agency','e');?>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_MSS"  id="dischargeplan_Mental_Status_MSS" />
            <?php xl('Medical Services','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_CMT" id="dischargeplan_Mental_Status_CMT" />
          <?php xl('Caregiver Management Training','e');?></label>
          <label>
           <input type="checkbox" name="dischargeplan_Mental_Status_CCT" id="dischargeplan_Mental_Status_CCT" />
          <?php xl('Cognitive and/or Compensatory Training','e');?></label>
           <?php xl('Other','e');?>
           <input type="text" name="dischargeplan_Mental_Status_Other1" id="dischargeplan_Mental_Status_Other1" />
          <br />		  </td>  
		  
		  </tr>
  </tr>
  <tr>
  <td scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e');?></strong><br />
  <textarea name="dischargeplan_specific_training_this_visit"  id="dischargeplan_specific_training_this_visit" rows="2" cols="70" wrap="virtual name"></textarea>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>
          <td height="29" colspan="3" align="left" scope="row"><p><strong><?php xl('Reason for Discharge (Check all that apply)','e');?></strong></p></td>
        </tr>

        <tr>
          <td width="31%" valign="top" scope="row"><form id="form2" name="form2" method="post" action="">
            <table width="100%" class="formtable">
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_No_Further_Skilled"  id="dischargeplan_RfD_No_Further_Skilled" />
                  <?php xl('No Further Skilled Care Required','e');?></label></td>
              </tr>

              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Short_Term_Goals"  id="dischargeplan_RfD_Short_Term_Goals" />
                  <?php xl('Short-Term Goals were achieved','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Long_Term_Goals" id="dischargeplan_RfD_Long_Term_Goals" />

                  <?php xl('Long-Term Goals were achieved','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Patient_homebound"  id="CheckboxGroup7_3" />
                  <?php xl('Patient no longer homebound','e');?></label></td>
              </tr>
              <tr>

                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_rehab_potential" id="dischargeplan_RfD_rehab_potential" />
                  <?php xl('Patient reached maximum rehab potential','e');?></label></td>
              </tr>
            </table>
          <td width="42%" valign="top">
            <table width="100%" class="formtable">

              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_refused_services" id="dischargeplan_RfD_refused_services" />
                  <?php xl('Family/Friends/Physician Assume Responsibility Patient/Family refused services','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_out_of_service_area" id="dischargeplan_RfD_out_of_service_area" />

                  <?php xl('Moved out of service area','e');?></label></td>
              </tr>
 <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Admitted_to_Hospital"  id="dischargeplan_RfD_Admitted_to_Hospital" />
                  <?php xl('Admitted to Hospital','e');?></label></td>
              </tr>
              <tr>

                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_higher_level_of_care"  id="dischargeplan_RfD_higher_level_of_care" />
                  <?php xl('Admitted to a higher level of care (SNF, ALF)','e');?></label></td>
              </tr>
            </table>
          </td>
          <td width="27%" valign="top">
            <table width="100%" class="formtable">

              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_another_Agency"  id="dischargeplan_RfD_another_Agency" />
                  <?php xl('Transferred to another Agency','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Death"  id="dischargeplan_RfD_Death" />

                  <?php xl('Death','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Transferred_Hospice"  id="dischargeplan_RfD_Transferred_Hospice" />
                  <?php xl('Transferred to Hospice','e');?></label></td>
              </tr>
              <tr>
              <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_MD_Request"  id="dischargeplan_RfD_MD_Request" />
                  <?php xl('MD Request','e');?></label></td>
              </tr>
            </table>
            <?php xl('Other','e');?>
            <input type="text" name="dischargeplan_RfD_other" id="dischargeplan_RfD_other" size="20px" />
          </td>
        </tr>
        </table>
  </tr>
  <tr>
    <td scope="row">&nbsp;</th>
  <strong><?php xl('Functional Improvements At Time of Discharge','e');?></strong></tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>

          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_ADL" id="dischargeplan_ToD_ADL" />
            <label for="ADL"><?php xl('ADL','e');?></label>
            <input type="text" size="150%" name="dischargeplan_ToD_ADL_notes" id="dischargeplan_ToD_ADL_notes" /><br>
            </th>
            <input type="checkbox" name="dischargeplan_ToD_ADL1" id="dischargeplan_ToD_ADL1" />
            <label for="adl2"><?php xl('ADL','e');?></label>

            <input type="text" size="15px" name="dischargeplan_ToD_ADL1_notes" id="dischargeplan_ToD_ADL1_notes" />
            <input type="checkbox" name="dischargeplan_ToD_IADL" id="dischargeplan_ToD_IADL" />
            <label for="IADL"><?php xl('IADL','e');?></label>
            <input type="text" name="dischargeplan_ToD_IADL_notes" size="15px" id="dischargeplan_ToD_IADL_notes" />
            <input type="checkbox" name="dischargeplan_ToD_IADL1" id="dischargeplan_ToD_IADL1" />
            <label for="IADL2"><?php xl('IADL','e');?></label>
            <input type="text" name="dischargeplan_ToD_IADL1_notes" size="50px" id="dischargeplan_ToD_IADL1_notes" /> 
        </tr>

        <tr>
          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_ROM" id="dischargeplan_ToD_ROM" />
            <label for="ROM in"><?php xl('ROM in','e');?></label>
            <input type="text" name="dischargeplan_ToD_ROM_in" size="50px" id="dischargeplan_ToD_ROM_in" />
            <input type="checkbox" name="dischargeplan_ToD_Safety_Management" id="dischargeplan_ToD_Safety_Management" />
            <label for="Safety Management in"><?php xl('Safety Management in','e');?></label>
            <input type="text" name="dischargeplan_ToD_Safety_Management_in" size="50px" id="dischargeplan_ToD_Safety_Management_in" />

          </tr>
        <tr>
          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_Env_Adaptations" id="dischargeplan_ToD_Env_Adaptations" />
            <label for="Environment Adaptations including"><?php xl('Environment Adaptations including','e');?></label>
            <input type="text" name="dischargeplan_ToD_Env_Adaptations_inc" size="120%" id="dischargeplan_ToD_Env_Adaptations_inc" />
          </td>
        </tr>
	<tr>
          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_AE_Usage" id="dischargeplan_ToD_AE_Usage" />
            <label for="Adaptive Equipment Usage for"><?php xl('Adaptive Equipment Usage for','e');?></label>
            <input type="text" name="dischargeplan_ToD_AE_Usage_for" size="40px" id="dischargeplan_ToD_AE_Usage_for" />
            <input type="checkbox" name="" id="dischargeplan_ToD_CF_Performance" />
            <label for="Caregiver/Family Performance in"><?php xl('Caregiver/Family Performance in','e');?></label>
            <input type="text" name="dischargeplan_ToD_CF_Performance_in" size="40px" id="dischargeplan_ToD_CF_Performance_in" />

          </td>
        </tr>
        <tr>
          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_Per_Home_Exercises" id="dischargeplan_ToD_Per_Home_Exercises" />
            <label for="Performance of Home Exercises for"><?php xl('Performance of Home Exercises for','e');?></label>
            <input type="text" name="dischargeplan_ToD_Per_Home_Exercises_for" size="119%" id="dischargeplan_ToD_Per_Home_Exercises_for" />
          </td>

        </tr>
        <tr>
          <td align="left" scope="row"><?php xl('Other','e');?>
            <input type="text" name="dischargeplan_ToD_Other" size="150%" id="dischargeplan_ToD_Other" />
          </td>
        </tr>
        <tr>
          <td align="left" scope="row"><?php xl('Additional Comments Regarding Discharge Status of Patient','e');?>
            <input type="text" name="dischargeplan_ToD_Status_of_Patient" size="100%" id="dischargeplan_ToD_Status_of_Patient" />
          </td>

        </tr>
        </table>
 </tr>
  <tr>
    <td scope="row"><strong><?php xl('Functional Ability at Time of Discharge','e');?></strong><br />
      

            <label>
              <input type="checkbox" name="dischargeplan_ToD_Independent" value="Independent" id="dischargeplan_ToD_Independent" />

        <?php xl('Independent','e');?></label>
            <label>
              <input type="checkbox" name="dischargeplan_ToD_Independent" value="Independent with Minimal Assistance" id="dischargeplan_ToD_Ind_with_Minimal_Assist" />
              <?php xl('Independent with Minimal Assistance','e');?></label>
          <label>
              <input type="checkbox" name="dischargeplan_ToD_Independent" value="Partially Dependent" id="dischargeplan_ToD_Partially_Dependent" />
              <?php xl('Partially Dependent','e');?></label>

         <label>
              <input type="checkbox" name="dischargeplan_ToD_Independent" value="Totally Dependent" id="dischargeplan_ToD_Totally_Dependent" />
              <?php xl('Totally Dependent','e');?></label>
      
  </tr>
  <tr>
    <td scope="row"><p><strong><?php xl('COMMENTS/RECOMMENDATIONS','e');?></strong></p>
  </tr>
  <tr>
    <td scope="row">
      <table width="100%" class="formtable">
        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Discharge_anticipated" value="Discharge was anticipated" id="dischargeplan_Discharge_anticipated" />
            <?php xl('Discharge was anticipated and discussed in advance with patient/caregiver/family and MD','e');?></label></td>
        </tr>

        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Discharge_anticipated" value="Discharge was not anticipated" id="dischargeplan_Discharge_not_anticipated" />
            <?php xl('Discharge was not anticipated','e');?></label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Discharge_anticipated" value="A Recommend follow-up treatment when patient returns to home" id="dischargeplan_follow_up_treatment" />
            <?php xl('A Recommend follow-up treatment when patient returns to home.','e');?></label></td>
        </tr>

        <tr>
        <td><label>
            <?php xl('not met (If goals partially met or not met please explain)','e');?></label>
            <input type="checkbox" name="dischargeplan_Recommendations_met" value="met" id="dischargeplan_Recommendations_met" />
            <?php xl('met','e');?>
            <input type="checkbox" name="dischargeplan_Recommendations_met" value="partially met" id="dischargeplan_Recommendations_partially" />
            <?php xl('partially met','e');?>
  <input type="checkbox" name="dischargeplan_Recommendations_met" value="not met " id="dischargeplan_Recommendations_not_met" />
            <?php xl('not met (If goals partially met or not met please explain)','e');?>
  <input type="text" name="dischargeplan_Recommendations_not_met_note" size="50%" id="dischargeplan_Recommendations_not_met_note" />
            </td>
        </tr>
  
    </table>       
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr>
        <td width="57%" scope="row"><strong><?php xl('Visit and Discharge Completed by Therapist Signature (Name/Title)','e');?></th>
        <td width="43%"><strong><?php xl('Electronic Signature','e');?></strong></td>

      </tr>
    </table>    </tr>
</table>

<br /><br />
<table cellpadding="2px" border="1" width="100%" class="formtable"><tr><td><table width="100%" border="0" class="formtable">
<tr><td colspan=3><strong><?php xl('Physician Confirmation of Discharge Orders','e');?></strong></td></tr>
<tr><td colspan=3><strong><?php xl('By Signing below, MD agrees with discharge from Occupational Therapy services','e');?></strong></td></tr>
<tr><td width='35%'><strong><?php xl('MD PRINTED NAME','e');?></strong></td><td width='35%'><strong><?php xl('MD Signature','e');?></strong></td><td><strong><?php xl('Date','e');?></strong></td></tr></table></td></tr></table>
</table>
</form>
<a href="javascript:top.restoreSession();document.my_form.submit();" class="link_submit">[<?php xl('Save','e'); ?>]</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
<br>
<?php
formFooter();
?>

</body>
</html>
