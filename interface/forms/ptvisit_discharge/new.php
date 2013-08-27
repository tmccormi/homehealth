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
	    obj.open("GET",site_root+"/forms/ptvisit_discharge/functions.php?code="+icd9code+"&Dx="+Dx,true);             obj.send(null);
	  }	 
	</script>

</head>

<body>
<form method=post action="<?php echo $rootdir;?>/forms/ptvisit_discharge/save.php?mode=new" name="visitdischarge">
<h3 align="center"><?php xl('PHYSICAL THERAPY REVISIT/DISCHARGE NOTE','e');?></h3><br>

<br/><br/>
	<table width="100%" padding="2px" border="1" cellpadding="2px" class="formtable">
	  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px"  class="formtable">
  <tr>
    <td scope="row"><strong><?php xl('Patient Name','e');?></strong></th>
    <td><input type="text" id="patient_name" value="<?php patientName()?>" readonly /></td>
    <td ><strong><?php xl('Time In','e');?></strong></td>
    <td><select name="dischargeplan_Time_In" id="dischargeplan_Time_In"><?php timeDropDown($GLOBALS['Selected'])?></select></td>
    <td ><strong><?php xl('Time Out','e');?></strong> <br /></td>
    <td><select name="dischargeplan_Time_Out" id="dischargeplan_Time_Out"><?php timeDropDown($GLOBALS['Selected'])?></select></td>
    <td ><strong><?php xl('Date','e');?></strong></td>
    <td ><strong>
    <input type='text' size='10' name='dischargeplan_date' id='dischargeplan_date'
    title='<?php xl('Date','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
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
    <td scope="row">
      <?php xl('Pulse','e');?>
<label for="pulse"></label>
    <input type="text"  size="5px" name="dischargeplan_Vital_Signs_Pulse" id="dischargeplan_Vital_Signs_Pulse" />
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Pulse_Type" value="Regular" id="dischargeplan_Vital_Signs_Pulse_Type" />

        <?php xl('Regular','e');?></label>
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Pulse_Type" value="Irregular" id="dischargeplan_Vital_Signs_Pulse_Type" />
        <?php xl('Irregular','e');?></label>&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
     <?php xl('Temperature','e');?> <input size="5px" type="text" name ="dischargeplan_Vital_Signs_Temperature" id="dischargeplan_Vital_Signs_Temperature" />
     <label>

        <input type="checkbox" name="dischargeplan_Vital_Signs_Temperature_Type" value="Oral" id="dischargeplan_Vital_Signs_Temperature_Type" />
        <?php xl('Oral','e');?></label>
     <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Temperature_Type" value="Temporal" id="dischargeplan_Vital_Signs_Temperature_Type" />
        <?php xl('Temporal','e');?></label>
     &nbsp; <?php xl('Other','e');?> 
 <input type="text" size="10px" name="dischargeplan_Vital_Signs_other" id="dischargeplan_Vital_Signs_other" />
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Respirations','e');?>    <input type="text" size="5px" name="dischargeplan_Vital_Signs_Respirations" id="dischargeplan_Vital_Signs_Respirations" /> 
<br/> <?php xl('Blood Pressure','e')?>&nbsp;&nbsp;<?php xl('Systolic','e');?>   <input type="text" size="5px" name="dischargeplan_Vital_Signs_BP_Systolic" id="dischargeplan_Vital_Signs_BP_Systolic" />/
<input type="text" size="5px" name="dischargeplan_Vital_Signs_BP_Diastolic" id="dischargeplan_Vital_Signs_BP_Diastolic" />  <?php xl('Diastolic','e');?>
 <label>
   <input type="checkbox" name="dischargeplan_Vital_Signs_BP_side" value="Right" id="dischargeplan_Vital_Signs_BP_side" />
      <?php xl('Right','e');?></label>

 <label>
   <input type="checkbox" name="dischargeplan_Vital_Signs_BP_side" value="Left" id="dischargeplan_Vital_Signs_BP_side" />
       <?php xl('Left','e');?></label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_BP_Position" value="Sitting" id="dischargeplan_Vital_Signs_BP_Position" />
      <?php xl('Sitting','e');?></label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_BP_Position" value="Standing" id="dischargeplan_Vital_Signs_BP_Position" />

      <?php xl('Standing','e');?> </label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_BP_Position" value="Lying" id="dischargeplan_Vital_Signs_BP_Position" />
     <?php xl('Lying','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
<?php xl('*O','e'); ?><sub><?php xl('2','e'); ?></sub><?php xl('Sat','e'); ?>&nbsp;
     <input type="text" size="5px" name="dischargeplan_Vital_Signs_Sat" id="dischargeplan_Vital_Signs_Sat" />
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
    <?php xl('Patient states current medical regime is managing his/her pain;','e');?></label> &nbsp;&nbsp;
      <?php xl('Other','e');?> <input type="text" style="width:40%"  name="dischargeplan_Vital_Signs_Patient_states_other" id="dischargeplan_Vital_Signs_Patient_states_other" />
      <br /></tr>
      <tr>
    <td scope="row"></td></tr>
  <tr>
    <td scope="row" style="padding-left:8px; padding-right:8px; padding-bottom:8px;"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM','e');?> </strong>
	<input type="text" id="dischargeplan_treatment_diagnosis_problem" name="dischargeplan_treatment_diagnosis_problem" style="width:100%;"/>
  </tr>
  <tr>

    <td scope="row"><p><strong><?php xl('Mental Status','e');?></strong></p>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status"  id="dischargeplan_Mental_Status" value="Alert"/>
          <?php xl('Alert','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status"  id="dischargeplan_Mental_Status" value="Oriented"/>
          <?php xl('Oriented','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status"  id="dischargeplan_Mental_Status" value="Forgetful"/>
          <?php xl('Forgetful','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status"  id="dischargeplan_Mental_Status" value="Disoriented"/>
          <?php xl('Disoriented','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status"  id="dischargeplan_Mental_Status" value="Depressed"/>
          <?php xl('Depressed','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status" id="dischargeplan_Mental_Status" value="Agitated"/>
          <?php xl('Agitated','e');?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php xl('Other','e');?>
          <input type="text" style="width:30%"  name="dischargeplan_Mental_Status_Other" id="dischargeplan_Mental_Status_Other" /><br />
		  </td>  
		  
		  </tr>
  </tr>
  <tr>
  <td scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e');?></strong><br />
  <textarea name="dischargeplan_specific_training_this_visit"  id="dischargeplan_specific_training_this_visit" rows="2" cols="115" wrap="virtual name" ></textarea>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>
          <td height="29" colspan="3" align="left" scope="row"><p><strong><?php xl('Reason for Discharge (Check all that apply)','e');?></strong></p></td>
        </tr>

        <tr>
          <td width="33%" valign="top" scope="row"><form id="form2" name="form2" method="post" action="">
            <table width="100%"  class="formtable">
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
          <td width="33%" valign="top">
            <table width="100%"  class="formtable">

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
          <td valign="top">
            <table width="100%"  class="formtable">

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
            <input type="text" style="width:80%"  name="dischargeplan_RfD_other" id="dischargeplan_RfD_other"  />
          </td>
        </tr>
        </table>
  </tr>
  <tr>
    <td scope="row">&nbsp;</th>
  <strong><?php xl('Functional Improvements At Time of Discharge','e');?></strong></tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px"  class="formtable">
        <tr>

          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_Mobility" id="dischargeplan_ToD_Mobility" />
            <label><?php xl('Mobility','e');?></label>
            <input type="text" style="width:90%"  name="dischargeplan_ToD_Mobility_Notes" id="dischargeplan_ToD_Mobility_Notes" /><br>
            
	    <input type="checkbox" name="dischargeplan_ToD_ROM" id="dischargeplan_ToD_ROM" />
            <label><?php xl('ROM in','e');?></label>
            <input type="text" style="width:40%" name="dischargeplan_ToD_ROM_In" id="dischargeplan_ToD_ROM_In" />
            <input type="checkbox" name="dischargeplan_ToD_Strength" id="dischargeplan_ToD_Strength" />
            <label><?php xl('Strength in','e');?></label>
            <input type="text" style="width:38%"  name="dischargeplan_ToD_Strength_In" id="dischargeplan_ToD_Strength_In" />

	    <br/>
            <input type="checkbox" name="dischargeplan_ToD_Home_Safety_Techniques" id="dischargeplan_ToD_Home_Safety_Techniques" />
            <label><?php xl('Home Safety Techniques in','e');?></label>
            <input type="text" style="width:26%" name="dischargeplan_ToD_Home_Safety_Techniques_In" id="dischargeplan_ToD_Home_Safety_Techniques_In" /> 
            <input type="checkbox" name="dischargeplan_ToD_Assistive_Device_Usage" id="dischargeplan_ToD_Assistive_Device_Usage" />
            <label><?php xl('Assistive Device Usage with','e');?></label>
            <input type="text" style="width:25%" name="dischargeplan_ToD_Assistive_Device_Usage_With" id="dischargeplan_ToD_Assistive_Device_Usage_With" />
            

	    <br/>
	    <input type="checkbox" name="dischargeplan_ToD_Caregiver_Family_Performance" id="dischargeplan_ToD_Caregiver_Family_Performance" />
            <label><?php xl('Caregiver/Family Performance in','e');?></label>
            <input type="text" size="33px" name="dischargeplan_ToD_Caregiver_Family_Performance_In" id="dischargeplan_ToD_Caregiver_Family_Performance_In" />
	    <input type="checkbox" name="dischargeplan_ToD_Performance_of_Home_Exercises" id="dischargeplan_ToD_Performance_of_Home_Exercises" />
	     <label><?php xl('Performance of Home Exercises','e');?></label>

	    <br/>
	    <input type="checkbox" name="dischargeplan_ToD_Demonstrates" id="dischargeplan_ToD_Demonstrates" />
	      <label><?php xl('Demonstrates','e');?></label>
            <input type="text" name="dischargeplan_ToD_Demonstrates_Notes" size="20px" id="dischargeplan_ToD_Demonstrates_Notes" />
	    <label><?php xl('use of prosthesis/brace/splint','e');?></label>
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php xl('Other','e');?></label>
	    <input type="text" style="width:40%"  name="dischargeplan_ToD_Other" id="dischargeplan_ToD_Other" />

	    <br/>
                    <?php xl('Additional Comments Regarding Discharge Status of Patient','e');?>
            <input type="text" style="width:53%" name="dischargeplan_ToD_Discharge_Status_Patient" id="dischargeplan_ToD_Discharge_Status_Patient" />
          </td>

        </tr>
        </table>
 </tr>
  <tr>
    <td scope="row"><strong><?php xl('Functional Ability at Time of Discharge','e');?></strong><br />
      

            <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_Timeof_Discharge" value="Independent" id="dischargeplan_Functional_Ability_Timeof_Discharge" />
        <?php xl('Independent','e');?></label>
            <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_Timeof_Discharge" value="Independent with Minimal Assistance" id="dischargeplan_Functional_Ability_Timeof_Discharge" />
              <?php xl('Independent with Minimal Assistance','e');?></label>
          <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_Timeof_Discharge" value="Partially Dependent" id="dischargeplan_Functional_Ability_Timeof_Discharge" />
              <?php xl('Partially Dependent','e');?></label>

         <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_Timeof_Discharge" value="Totally Dependent" id="dischargeplan_Functional_Ability_Timeof_Discharge" />
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
            <input type="checkbox" name="dischargeplan_Comments_Recommendations" value="Discharge was anticipated" id="dischargeplan_Comments_Recommendations" />
            <?php xl('Discharge was anticipated and discussed in advance with patient/caregiver/family and MD','e');?></label></td>
        </tr>

        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Comments_Recommendations" value="Discharge was not anticipated" id="dischargeplan_Comments_Recommendations" />
            <?php xl('Discharge was not anticipated','e');?></label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Comments_Recommendations" value="Recommend follow-up treatment" id="dischargeplan_Comments_Recommendations" />
            <?php xl('A Recommend follow-up treatment when patient returns to home.','e');?></label></td>
        </tr>
	
  <tr>
          <td><label>
	<?php xl('Follow-up Recommendations','e');?></label>
      <input type="text" style="width:77%"  name="dischargeplan_Followup_Recommendations" id="dischargeplan_Followup_Recommendations" />
      </td>
      </tr>

        <tr>
        <td><label>
            <?php xl('Goals identified on care plan were','e');?></label>
            <input type="checkbox" name="dischargeplan_Goals_identified_on_careplan" value="met" id="dischargeplan_Goals_identified_on_careplan" />
            <?php xl('met*','e');?>
            <input type="checkbox" name="dischargeplan_Goals_identified_on_careplan" value="partially met" id="dischargeplan_Goals_identified_on_careplan" />
            <?php xl('partially met*','e');?>
  <input type="checkbox" name="dischargeplan_Goals_identified_on_careplan" value="not met" id="dischargeplan_Goals_identified_on_careplan" />
            <?php xl('not met* (*If goals partially met or not met please explain)','e');?>
  <input type="text" style="width:98%" name="dischargeplan_Goals_notmet_explanation" id="dischargeplan_Goals_notmet_explanation" />
            </td>
        </tr>
  
      <tr>
    <td>
    <?php xl('Additional Comments','e');?>
      <input type="text" style="width:82%"   name="dischargeplan_Additional_Comments" id="dischargeplan_Additional_Comments" />
    </td>
      </tr>

    </table>       
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px"  class="formtable">
      <tr>
        <td width="57%" scope="row"><strong><?php xl('Visit and Discharge Completed by Therapist Signature (Name/Title)','e');?></th>
        <td width="43%"><strong><?php xl('Electronic Signature','e');?></strong></td>

      </tr>
    </table>    </tr>
</table>

<table cellpadding="2px" border="1" width="100%" class="formtable"><tr><td><table width="100%" border="0" class="formtable">
<tr><td colspan=3><strong><?php xl('Physician Confirmation of Discharge Orders','e');?></strong></td></tr>
<tr><td colspan=3><strong><?php xl('By Signing below, MD agrees with discharge from Occupational Therapy services','e');?></strong></td></tr>
<tr><td width='35%'>
<strong><?php xl('MD PRINTED NAME','e');?></strong>
<input type="text" name="dischargeplan_md_printed_name" value="<?php doctorname();?>" readonly>
</td><td width='35%'>
<strong><?php xl('MD Signature','e');?></strong>
<input type="text" name="dischargeplan_md_signature" value="">
</td><td>
<strong><?php xl('Date','e');?></strong>
<input type="text" name="dischargeplan_md_date" value="" id='dischargeplan_md_date'
    title='<?php xl('Date','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_curr_date2' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"dischargeplan_md_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
</td></tr></table>
</td></tr></table>
</table>
<a href="javascript:top.restoreSession();document.visitdischarge.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>
</body>
</html>
