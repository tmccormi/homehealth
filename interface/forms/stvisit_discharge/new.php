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
	    obj.open("GET",site_root+"/forms/stvisit_discharge/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>
</head>

<body>
<form method=post action="<?php echo $rootdir;?>/forms/stvisit_discharge/save.php?mode=new" name="visitdischarge">
<h3 align="center"><?php xl('SPEECH THERAPY VISIT/DISCHARGE NOTE','e');?></h3><br>
<table width="100%" border="1" cellpadding="0px" cellspacing="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px"  cellpadding="5px" class="formtable">
  <tr>
    <td style="width:10%" align="center" scope="row"><strong><?php xl('Patient Name','e');?></strong></th>
    <td style="width:15%" ><input type="text" id="patient_name" value="<?php patientName()?>" readonly></td>
    <td style="width:10%" align="center"><strong><?php xl('Time In','e');?></strong></td>
    <td style="width:10%"><select name="dischargeplan_Time_In" id="dischargeplan_Time_In"><?php timeDropDown($GLOBALS['Selected'])?></select></td>
    <td style="width:10%" align="center" ><strong><?php xl('Time Out','e');?></strong> <br /></td>
    <td style="width:10%" > <select name="dischargeplan_Time_Out" id="dischargeplan_Time_Out"><?php timeDropDown($GLOBALS['Selected'])?></select></td>
    <td style="width:10%" align="center" ><strong><?php xl('Date','e');?></strong></td>
    <td style="width:25%" ><strong>
    <input type='text' size='15' name='dischargeplan_date' id='dischargeplan_date'
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
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
<td>
<strong> <?php xl('TYPE OF VISIT','e');?></strong>
 <input type="checkbox" name="dischargeplan_type_of_visit" value="Visit" id="dischargeplan_type_of_visit" />
 <?php xl('Visit','e');?>
 <input type="checkbox" name="dischargeplan_type_of_visit" value="Visit And Supervisory" id="dischargeplan_type_of_visit" />
 <?php xl('Visit and Supervisory Review','e');?> 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl('Other','e');?>&nbsp;
<input type="text"  style="width:50%" name="dischargeplan_type_of_visit_other" id="dischargeplan_type_of_visit_other" />
</td>
</tr>


  <tr>
    <td scope="row"><p><strong><?php xl('Vital Signs','e');?></strong></p></tr>
  <tr>
    <td scope="row"></th>
      <?php xl('Pulse','e');?>
<label for="pulse"></label>
    <input type="text"  size="5px" name="dischargeplan_Vital_Signs_Pulse" id="dischargeplan_Vital_Signs_Pulse" />
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Pulse_Type" value="Regular" id="dischargeplan_Vital_Signs_Pulse_Type" />
        <?php xl('Regular','e');?></label>
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Pulse_Type" value="Irregular" id="dischargeplan_Vital_Signs_Pulse_Type" />
        <?php xl('Irregular','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
     <?php xl('Temperature','e');?> <input size="5px" type="text" name ="dischargeplan_Vital_Signs_Temperature" id="dischargeplan_Vital_Signs_Temperature" />
     <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Temperature_Type" value="Oral" id="dischargeplan_Vital_Signs_Temperature_Type" />
        <?php xl('Oral','e');?></label>
     <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Temperature_Type" value="Temporal" id="dischargeplan_Vital_Signs_Temperature_Type" />
        <?php xl('Temporal','e');?></label>
&nbsp;&nbsp;<?php xl('Other','e');?> 
 <input type="text" style="width:30%" name="dischargeplan_Vital_Signs_other" id="dischargeplan_Vital_Signs_other" /><br>
 <?php xl('Respirations','e');?>&nbsp;<input type="text" size="7px" name="dischargeplan_Vital_Signs_Respirations" id="dischargeplan_Vital_Signs_Respirations" />&nbsp;&nbsp;&nbsp;&nbsp; 
 <?php xl('Blood Pressure Systolic','e');?>   <input type="text" size="6px" name="dischargeplan_Vital_Signs_BP_Systolic" id="dischargeplan_Vital_Signs_BP_Systolic" />/
<input type="text" size="6px" name="dischargeplan_Vital_Signs_BP_Diastolic" id="dischargeplan_Vital_Signs_BP_Diastolic" />  <?php xl('Diastolic','e');?>
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
     <?php xl('Lying','e')?><br>
      <?php xl('*O','e')?>
<sub> <?php xl('2','e')?></sub> <?php xl('Sat','e');?> </label> 
     <input type="text" size="5px" name="dischargeplan_Vital_Signs_Sat" id="dischargeplan_Vital_Signs_Sat" />
     
     <?php xl('*Physician ordered','e');?> 
     </tr>
      <tr>
    <td scope="row"></td></tr>


      <tr> <td>
      <strong> <?php xl('Pain','e');?> </strong>
      <input type="checkbox" name="dischargeplan_Pain" value="No Pain"  />
       <?php xl('No Pain','e');?>
      <input type="checkbox" name="dischargeplan_Pain" value="Pain limits functional ability"  />
      <?php xl('Pain limits functional ability','e');?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Intensity','e');?>
      <input type="text" size="5px" name="dischargeplan_Vital_Signs_Pain_Intensity" id="dischargeplan_Vital_Signs_Pain_Intensity"/>
      &nbsp;&nbsp;&nbsp;
 <input type="checkbox" name="dischargeplan_Vital_Signs_Pain" value="Improve" id="dischargeplan_Vital_Signs_Pain" />
      <?php xl('Improve','e');?> </strong>
     <input type="checkbox" name="dischargeplan_Vital_Signs_Pain" value="Worse" id="dischargeplan_Vital_Signs_Pain" />
       <?php xl('Worse','e');?>
       <input type="checkbox" name="dischargeplan_Vital_Signs_Pain" value="No change" id="dischargeplan_Vital_Signs_Pain" />
       <?php xl('No Change','e');?><br>
       <?php xl('Location(s)','e')?>
       <input type="text" style="width:30%" name="dischargeplan_Vital_Signs_Location" id="dischargeplan_Vital_Signs_Location" />
     </td> </tr>

<tr>
<td><strong>
<?php xl('Please Note: Contact MD if Vital Signs are Pulse','e')?>
&lt; <?php xl('56 or','e')?> &gt; <?php xl('120; Temperature','e')?> &lt; <?php xl('56 or','e')?>
&gt; <?php xl('101; Respirations','e')?> &lt; <?php xl('10 or','e')?> &gt; <?php xl('30 SBP','e')?>
&lt; <?php xl('80 or','e')?> &gt; <?php xl('190; DBP','e')?> &lt; <?php xl('50 or','e')?>
&gt; <?php xl('100; Pain Significantly Impacts patients ability to participate. O2 Sat','e')?>
&lt; <?php xl('90% after rest','e')?></strong>
</td> </tr>
  <tr>
    <td scope="row"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM','e');?> </strong>
   <input type="text" id="icd" size="15"/>
<input type="button" value="Search" onclick="javascript:changeICDlist(dischargeplan_treatment_diagnosis_problem,document.getElementById('icd'),'<?php echo $rootdir; ?>')"/>
<span id="med_icd9">
<select id="dischargeplan_treatment_diagnosis_problem" name="dischargeplan_treatment_diagnosis_problem" style="display:none"></select></span>
  </tr>  
  </tr>
 
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>
          <td height="29" colspan="3" align="left" scope="row"><p><strong><?php xl('Reason for Discharge (Check all that apply)','e');?></strong></p></td>
        </tr>

        <tr>
          <td width="30%" valign="top" scope="row">
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
          <td width="30%" valign="top">
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
          <td width="40%" valign="top">
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
            <input type="text" name="dischargeplan_RfD_other" id="dischargeplan_RfD_other" style="width:84%" />
          </td>
        </tr>
        </table>
  </tr>

 <tr>
  <td scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e');?></strong><br />
  <textarea name="dischargeplan_Specific_Training"  id="dischargeplan_Specific_Training" rows="2" cols="100" wrap="virtual name"></textarea>
  <tr>
    <td scope="row">&nbsp;</th>
  <strong><?php xl('Functional Improvements At Time of Discharge','e');?></strong></tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>

          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_Improved_Oral_Stage" id="dischargeplan_Improved_Oral_Stage" />
            <label><?php xl('Improved Oral Stage skills in','e');?></label>&nbsp;
            <input type="text" style="width:56%" name="dischargeplan_Improved_Oral_Stage_In" id="dischargeplan_Improved_Oral_Stage_In" /><br>
            <input type="checkbox" name="dischargeplan_Improved_Pharyngeal_Stage" id="dischargeplan_Improved_Pharyngeal_Stage">
            <label><?php xl('Improved Pharyngeal Stage Skills in','e');?></label>&nbsp;
            <input type="text" style="width:50%" name="dischargeplan_Improved_Pharyngeal_Stage_In" id="dischargeplan_Improved_Pharyngeal_Stage_In" />
            <br/>
	    <input type="checkbox" name="dischargeplan_Improved_Verbal_Expression" id="dischargeplan_Improved_Verbal_Expression" />
            <label><?php xl(' Improved Verbal Expression in','e');?></label>&nbsp;
            <input type="text" name="dischargeplan_Improved_Verbal_Expression_In" style="width:55%" id="dischargeplan_Improved_Verbal_Expression_In" /><br>
            <input type="checkbox" name="dischargeplan_Improved_Non_Verbal_Expression" id="dischargeplan_Improved_Non_Verbal_Expression" />
            <label><?php xl('Improved Non Verbal Expression in','e');?></label>&nbsp;
            <input type="text" name="dischargeplan_Improved_Non_Verbal_Expression_In" style="width:51%" id="dischargeplan_Improved_Non_Verbal_Expression_In" /> 

	    <br/>
            <input type="checkbox" name="dischargeplan_Improved_Comprehension" id="dischargeplan_Improved_Comprehension" />
            <label><?php xl('Improved Comprehension in','e');?></label> &nbsp;
            <input type="text" name="dischargeplan_Improved_Comprehension_In" style="width:56%" id="dischargeplan_Improved_Comprehension_In" />
            

	    <br/>
	    <input type="checkbox" name="dischargeplan_Caregiver_Family_Performance" id="dischargeplan_Caregiver_Family_Performance" />
            <label><?php xl('Caregiver/Family Performance in','e');?></label>&nbsp;
            <input type="text" name="dischargeplan_Caregiver_Family_Performance_In" style="width:52%" id="dischargeplan_Caregiver_Family_Performance_In" />
	    
	    <br/>
	    <input type="checkbox" name="dischargeplan_Functional_Improvements_Other" id="dischargeplan_Functional_Improvements_Other" />
	    <label><?php xl('Other','e');?></label>&nbsp;
	    <input type="text" name="dischargeplan_Functional_Improvements_Other_Note" style="width:90%" id="dischargeplan_Functional_Improvements_Other_Note" />

	    <br/>
                    <?php xl('Additional Comments Regarding Discharge Status of Patient','e');?>&nbsp;
            <input type="text" name="dischargeplan_Functional_Improvements_Comments" style="width:55%" id="dischargeplan_Functional_Improvements_Comments" />
          </td>

        </tr>
        </table>
 </tr>
  <tr>
    <td scope="row"><strong><?php xl('Functional Ability in','e');?>
	  <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="Swallow" id="dischargeplan_Functional_Ability_In" />
        <?php xl('Swallow','e');?></label>
	<label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="Communication" id="dischargeplan_Functional_Ability_In" />
        <?php xl('Communication','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('At Time of Discharge','e');?>

            <label>
              <input type="checkbox" name="dischargeplan_at_time_of_discharge" value="WFL" id="dischargeplan_at_time_of_discharge" />
        <?php xl('WFL = within functional limits;','e');?></label>
            <label>
              <input type="checkbox" name="dischargeplan_at_time_of_discharge" value="WFL with cues" id="dischargeplan_at_time_of_discharge" />
              <?php xl('WFL with cues;','e');?></label>
          <label>
              <input type="checkbox" name="dischargeplan_at_time_of_discharge" value="Mild impairment" id="dischargeplan_at_time_of_discharge" />
              <?php xl('Mild impairment;','e');?></label>

         <label>
              <input type="checkbox" name="dischargeplan_at_time_of_discharge" value="Moderate impairment" id="dischargeplan_at_time_of_discharge" />
              <?php xl('Moderate impairment;','e');?></label>

	    <label>
              <input type="checkbox" name="dischargeplan_at_time_of_discharge" value="Severe impairment" id="dischargeplan_at_time_of_discharge" />
              <?php xl('Severe impairment','e');?></label> </strong>     

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

<tr>
                        <td>
                        <table border="1px" width="100%" class="formtable">
                        <tr><td width="33%">
                        <strong><?php xl('MD PRINTED NAME','e');?></strong><br>
                        <input type="text" name="dischargeplan_md_printed_name" style="width:90%" value="<?php doctorname(); ?>" readonly="readonly">
                        </td>
                        <td width="33%">
                        <strong><?php xl('MD Signature','e');?></strong><br>
                        <input type="text" name="dischargeplan_md_signature" style="width:90%" >
                        </td>
                        <td width="33%">
                        <strong><?php xl('Date','e');?></strong><br>&nbsp;
                        <input type='text' size='16' name='dischargeplan_md_signature_date' id='dischargeplan_md_signature_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' />
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date2' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"dischargeplan_md_signature_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
                        </td>
                        </tr>
                        </table>
                        </td>
                        </tr>

</table></td></tr></table>
</table>
<a href="javascript:top.restoreSession();document.visitdischarge.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>
</body>
</html>
