<?php 
require_once("../../globals.php");
include_once("../../calendar.inc");
require_once ("functions.php");
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
	    obj.open("GET",site_root+"/forms/visit_discharge_test/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>
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

<body class="body_top">

<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_ot_visit_discharge_note", $_GET["id"]);
?>
<form method=post action="<?php echo $rootdir;?>/forms/visit_discharge_test/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="visitdischarge">
<h3 align="center"><?php xl('OCCUPATIONAL THERAPY VISIT/DISCHARGE NOTE','e');?></h3><br>
<a href="javascript:top.restoreSession();document.visitdischarge.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
 <br></br>
<table width="100%" padding="2px"border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
  <tr>

    <td scope="row"><strong><?php xl('Patient Name','e');?></strong></th>
    <td><input type="text" id="patient_name" value="<?php patientName()?>" readonly></td>
    <td width="70"><p><strong><?php xl('Time In','e');?></strong></p></td>
    <td><select name="dischargeplan_Time_In" id="dischargeplan_Time_In"><?php timeDropDown(stripslashes($obj{"dischargeplan_Time_In"}))?></select></td>
    <td width="70"><p><strong><?php xl('Time Out','e');?></strong></p></td>
    <td><select name="dischargeplan_Time_Out" id="dischargeplan_Time_Out"><?php timeDropDown(stripslashes($obj{"dischargeplan_Time_Out"}))?></select></td>
    <td width="70"><strong><?php xl('Date','e');?></strong></td>
    <td><strong>
    <input type='text' size='20' name='dischargeplan_date' id='dischargeplan_date'
    value='<?php echo stripslashes($obj{"dischargeplan_date"});?>'
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly />
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_curr_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"dischargeplan_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>

        </strong></td>
  </tr>
</table>
  </tr>

  <tr>
    <td scope="row"><p><strong><?php xl('Vital Signs','e');?></strong></p></tr>
  <tr>
    <td scope="row"></th>
      <?php xl('Pulse','e');?>
<label for="pulse"></label>
    <input type="text"  size="5px" name="dischargeplan_Vital_Signs_Pulse" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Pulse"});?>" id="dischargeplan_Vital_Signs_Pulse" />
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Regular" value="Regular" <?php if ($obj{"dischargeplan_Vital_Signs_Regular"} == "Regular"){echo "checked";};?> id="dischargeplan_Vital_Signs_Regular" />

        <?php xl('Regular','e');?></label>
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Regular" value="Irregular" <?php if ($obj{"dischargeplan_Vital_Signs_Regular"} == "Irregular"){echo "checked";};?> id="dischargeplan_Vital_Signs_Irregular" />
        <?php xl('Irregular','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <?php xl('Temperature','e');?> <input size="5px" type="text" name ="dischargeplan_Vital_Signs_Temperature"  value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Temperature"});?>" id="dischargeplan_Vital_Signs_Temperature" />
     <label>

        <input type="checkbox" name="dischargeplan_Vital_Signs_Oral" value="Oral" <?php if ($obj{"dischargeplan_Vital_Signs_Oral"} == "Oral"){echo "checked";};?> id="dischargeplan_Vital_Signs_Oral" />
        <?php xl('Oral','e');?></label>
     <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Oral" value="Temporal" <?php if ($obj{"dischargeplan_Vital_Signs_Oral"} == "Temporal"){echo "checked";};?> id="dischargeplan_Vital_Signs_Temporal" />
        <?php xl('Temporal','e');?></label>&nbsp;
       <?php xl('Other','e');?> 
 <input type="text" size="10px" name="dischargeplan_Vital_Signs_other" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_other"});?>" id="dischargeplan_Vital_Signs_other" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl('Respirations    ','e');?><input type="text" size="5px" name="dischargeplan_Vital_Signs_Respirations" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Respirations"});?>" id="dischargeplan_Vital_Signs_Respirations" /> <br/>
 <?php xl('Blood Pressure Systolic    ','e');?><input type="text" size="5px" name="dischargeplan_Vital_Signs_BP_Systolic" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_BP_Systolic"});?>" id="dischargeplan_Vital_Signs_BP_Systolic" />/

<input type="text" size="5px" name="dischargeplan_Vital_Signs_BP_Diastolic" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_BP_Diastolic"});?>" id="dischargeplan_Vital_Signs_BP_Diastolic" />  <?php xl('Diastolic','e');?> 
 <label>
   <input type="checkbox" name="dischargeplan_Vital_Signs_Right" value="Right" <?php if ($obj{"dischargeplan_Vital_Signs_Right"} == "Right"){echo "checked";};?> id="dischargeplan_Vital_Signs_Right" />
      <?php xl('Right','e');?></label>

 <label>
   <input type="checkbox" name="dischargeplan_Vital_Signs_Right" value="Left" <?php if ($obj{"dischargeplan_Vital_Signs_Right"} == "Left"){echo "checked";};?> id="dischargeplan_Vital_Signs_Left" />
       <?php xl('Left','e');?></label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_Sitting" value="Sitting" <?php if ($obj{"dischargeplan_Vital_Signs_Sitting"} == "Sitting"){echo "checked";};?> id="dischargeplan_Vital_Signs_Sitting" />
      <?php xl('Sitting','e');?></label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_Sitting" value="Standing" <?php if ($obj{"dischargeplan_Vital_Signs_Sitting"} == "Standing"){echo "checked";};?> id="dischargeplan_Vital_Signs_Standing" />

      <?php xl('Standing','e');?> </label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_Sitting" value="Lying" <?php if ($obj{"dischargeplan_Vital_Signs_Sitting"} == "Lying"){echo "checked";};?> id="dischargeplan_Vital_Signs_Lying" />
     <?php xl('Lying','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('*O','e'); ?><sub><?php xl('2','e'); ?></sub><?php xl('Sat','e'); ?>&nbsp;
      <input type="text" size="5px" name="dischargeplan_Vital_Signs_Sat" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Sat"});?>" id="dischargeplan_Vital_Signs_Sat" />
     </label> 
     <?php xl('*Physician ordered','e');?> 
     <br>
     <?php xl('Pain Intensity','e');?> <input type="text" size="7px" name="dischargeplan_Vital_Signs_Pain_Intensity"  value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Pain_Intensity"});?>" id="dischargeplan_Vital_Signs_Pain_Intensity" />
     
     <?php xl('Pain continues to persist at discharge due to','e');?>
          <label>
            <input type="checkbox" name="dischargeplan_Vital_Signs_chronic_condition" <?php if ($obj{"dischargeplan_Vital_Signs_chronic_condition"} == "on"){echo "checked";};?> id="dischargeplan_Vital_Signs_chronic_condition" />
            <?php xl('chronic condition under physicians care,','e');?></label>
          <label><br/>
            <input type="checkbox" name="dischargeplan_Vital_Signs_Patient_states"  <?php if ($obj{"dischargeplan_Vital_Signs_Patient_states"} == "on"){echo "checked";};?> id="dischargeplan_Vital_Signs_Patient_states" />
      <?php xl('Patient states current medical regime is managing his/her pain;','e');?></label>
      <?php xl('Other','e');?> <input type="text" style="width:450px" name="dischargeplan_Vital_Signs_Patient_states_other" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Patient_states_other"});?>" id="dischargeplan_Vital_Signs_Patient_states_other" />
      <br /></tr>
       <tr>
    <td scope="row"></td></tr>
  <tr>
    <td scope="row"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM ','e');?></strong>
    <input type="text" id="icd" size="15"/>
<input type="button" value="Search" onclick="javascript:changeICDlist(dischargeplan_treatment_diagnosis_problem,document.getElementById('icd'),'<?php echo $rootdir; ?>')"/>
<div id="med_icd9">
 <?php if ($obj{"dischargeplan_treatment_diagnosis_problem"} != "")
{
echo "<select id='dischargeplan_treatment_diagnosis_problem' name='dischargeplan_treatment_diagnosis_problem'>"; 
echo "<option value=".stripslashes($obj{'dischargeplan_treatment_diagnosis_problem'}).">". stripslashes($obj{'dischargeplan_treatment_diagnosis_problem'})."</option>";
echo "</select>";
 } 
 else 
 { 
 echo "<select id='dischargeplan_treatment_diagnosis_problem' name='dischargeplan_treatment_diagnosis_problem' style='display:none'> </select>";
 }?>   
</div>
  </tr>
  <tr>
         <td scope="row"><p><strong><?php xl('Mental Status','e');?></strong></p>
      <p>
          <label>
    <input type="checkbox" name="dischargeplan_Mental_Status"  id="dischargeplan_Mental_Status" value="Alert"
    <?php if ($obj{"dischargeplan_Mental_Status_Alert"} == "Alert"){echo "checked";};?> />
          <?php xl('Alert','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status" value="Oriented" <?php if ($obj{"dischargeplan_Mental_Status"} == "Oriented"){echo "checked";};?> id="dischargeplan_Mental_Status_Oriented" />
          <?php xl('Oriented','e');?></label>
          <label>
          <input type="checkbox" name="dischargeplan_Mental_Status" value="Forgetful" <?php if ($obj{"dischargeplan_Mental_Status"} == "Forgetful"){echo "checked";};?> id="dischargeplan_Mental_Status_Forgetful" />
          <?php xl('Forgetful','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status" value="Disoriented"  <?php if ($obj{"dischargeplan_Mental_Status"} == "Disoriented"){echo "checked";};?> id="dischargeplan_Mental_Status_Disoriented" />
          <?php xl('Disoriented','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status" value="Depressed" <?php if ($obj{"dischargeplan_Mental_Status"} == "Depressed"){echo "checked";};?> id="dischargeplan_Mental_Status_Depressed" />
          <?php xl('Depressed','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status" value="Agitated" <?php if ($obj{"dischargeplan_Mental_Status"} == "Agitated"){echo "checked";};?> id="dischargeplan_Mental_Status_Agitated" />
          <?php xl('Agitated','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php xl('Other','e');?>
          <input type="text" style="width:350px" name="dischargeplan_Mental_Status_Other" value="<?php echo stripslashes($obj{"dischargeplan_Mental_Status_Other"});?>" id="dischargeplan_Mental_Status_Other" /><br />
          <?php xl('Based on cognitive impairment the following interventions have been provided by the home health agency','e');?>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_MSS"  <?php if ($obj{"dischargeplan_Mental_Status_MSS"} == "on"){echo "checked";};?> id="dischargeplan_Mental_Status_MSS" />
            <?php xl('Medical Services','e');?></label>
          <label>
            <input type="checkbox" name="dischargeplan_Mental_Status_CMT"  <?php if ($obj{"dischargeplan_Mental_Status_CMT"} == "on"){echo "checked";};?> id="dischargeplan_Mental_Status_CMT" />
          <?php xl('Caregiver Management Training','e');?></label>
          <label>
           <input type="checkbox" name="dischargeplan_Mental_Status_CCT"  <?php if ($obj{"dischargeplan_Mental_Status_CCT"} == "on"){echo "checked";};?> id="dischargeplan_Mental_Status_CCT" />	
          <?php xl('Cognitive and/or Compensatory Training','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <br>
           <?php xl('Other','e');?>
          <input type="text" style="width:900px" name="dischargeplan_Mental_Status_Other1" value="<?php echo stripslashes($obj{"dischargeplan_Mental_Status_Other1"});?>" id="dischargeplan_Mental_Status_Other1" />
          <br />
        </p>

  </tr>
  <tr>
  <td scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e');?></strong><br />
  <textarea name="dischargeplan_specific_training_this_visit" id="dischargeplan_specific_training_this_visit" cols ="117" rows="2"  wrap="virtual name">
<?php echo stripslashes($obj{"dischargeplan_specific_training_this_visit"});?></textarea>  
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
                  <input type="checkbox" name="dischargeplan_RfD_No_Further_Skilled" <?php if ($obj{"dischargeplan_RfD_No_Further_Skilled"} == "on"){echo "checked";};?> id="dischargeplan_RfD_No_Further_Skilled" />
                  <?php xl('No Further Skilled Care Required','e');?></label></td>
              </tr>

              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Short_Term_Goals"  <?php if ($obj{"dischargeplan_RfD_Short_Term_Goals"} == "on"){echo "checked";};?> id="dischargeplan_RfD_Short_Term_Goals" />
                  <?php xl('Short-Term Goals were achieved','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Long_Term_Goals"  <?php if ($obj{"dischargeplan_RfD_Long_Term_Goals"} == "on"){echo "checked";};?> id="dischargeplan_RfD_Long_Term_Goals" />

                  <?php xl('Long-Term Goals were achieved','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
               <input type="checkbox" name="dischargeplan_RfD_Patient_homebound" <?php if ($obj{"dischargeplan_RfD_Patient_homebound"} == "on"){echo "checked";};?> id="CheckboxGroup7_3" />
                  <?php xl('Patient no longer homebound','e');?></label></td>
              </tr>
              <tr>

                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_rehab_potential" <?php if ($obj{"dischargeplan_RfD_rehab_potential"} == "on"){echo "checked";};?> id="dischargeplan_RfD_rehab_potential" />
                  <?php xl('Patient reached maximum rehab potential','e');?></label></td>
              </tr>
            </table>
          <td width="30%" valign="top">
            <table width="100%" class="formtable">

              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_refused_services"  <?php if ($obj{"dischargeplan_RfD_refused_services"} == "on"){echo "checked";};?> id="dischargeplan_RfD_refused_services" />
                  <?php xl('Family/Friends/Physician Assume Responsibility Patient/Family refused services','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_out_of_service_area"  <?php if ($obj{"dischargeplan_RfD_out_of_service_area"} == "on"){echo "checked";};?> id="dischargeplan_RfD_out_of_service_area" />

                  <?php xl('Moved out of service area','e');?></label></td>
              </tr>
 <tr>
          <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Admitted_to_Hospital"  <?php if ($obj{"dischargeplan_RfD_Admitted_to_Hospital"} == "on"){echo "checked";};?> id="dischargeplan_RfD_Admitted_to_Hospital" />
                  <?php xl('Admitted to Hospital','e');?></label></td>
              </tr>
              <tr>

                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_higher_level_of_care"  <?php if ($obj{"dischargeplan_RfD_higher_level_of_care"} == "on"){echo "checked";};?> id="dischargeplan_RfD_higher_level_of_care" />
                  <?php xl('Admitted to a higher level of care (SNF, ALF)','e');?></label></td>
              </tr>
            </table>
          </td>
          <td width="40%" valign="top">
            <table width="100%" class="formtable">

              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_another_Agency" <?php if ($obj{"dischargeplan_RfD_another_Agency"} == "on"){echo "checked";};?> id="dischargeplan_RfD_another_Agency" />
                  <?php xl('Transferred to another Agency','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Death"  <?php if ($obj{"dischargeplan_RfD_Death"} == "on"){echo "checked";};?> id="dischargeplan_RfD_Death" />

                  <?php xl('Death','e');?></label></td>
              </tr>
              <tr>
                <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_Transferred_Hospice"  <?php if ($obj{"dischargeplan_RfD_Transferred_Hospice"} == "on"){echo "checked";};?>  id="dischargeplan_RfD_Transferred_Hospice" />
                  <?php xl('Transferred to Hospice','e');?></label></td>
              </tr>
              <tr>
              <td align="left"><label>
                  <input type="checkbox" name="dischargeplan_RfD_MD_Request"  <?php if ($obj{"dischargeplan_RfD_MD_Request"} == "on"){echo "checked";};?> id="dischargeplan_RfD_MD_Request" />
                  <?php xl('MD Request','e');?></label></td>
              </tr>
            </table>
            <?php xl('Other','e');?>
            <input type="text" style="width:300px" name="dischargeplan_RfD_other" value="<?php echo stripslashes($obj{"dischargeplan_RfD_other"});?>" id="dischargeplan_RfD_other" />
          </td>
        </tr>
         </table>
  </tr>
  <tr>
    <td scope="row">&nbsp;</th>
  <strong><?php xl('Functional Improvements At Time of Discharge','e');?></strong></tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="2px" class="formtable">
        <tr>

          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_ADL" <?php if ($obj{"dischargeplan_ToD_ADL"} == "on"){echo "checked";};?> id="dischargeplan_ToD_ADL" />
            <label for="ADL"><?php xl('ADL','e');?></label>
            <input type="text" style="width:180px" name="dischargeplan_ToD_ADL_notes" value="<?php echo stripslashes($obj{"dischargeplan_ToD_ADL_notes"});?>" id="dischargeplan_ToD_ADL_notes" /><br>
            </th>
            <input type="checkbox" name="dischargeplan_ToD_ADL1"  <?php if ($obj{"dischargeplan_ToD_ADL1"} == "on"){echo "checked";};?> id="dischargeplan_ToD_ADL1" />
            <label for="adl2"><?php xl('ADL','e');?></label>

            <input type="text" style="width:200px" name="dischargeplan_ToD_ADL1_notes" value="<?php echo stripslashes($obj{"dischargeplan_ToD_ADL1_notes"});?>" id="dischargeplan_ToD_ADL1_notes" />
            <input type="checkbox" name="dischargeplan_ToD_IADL"  <?php if ($obj{"dischargeplan_ToD_IADL"} == "on"){echo "checked";};?> id="dischargeplan_ToD_IADL" />
            <label for="IADL"><?php xl('IADL','e');?></label>
            <input type="text" style="width:200px" name="dischargeplan_ToD_IADL_notes"  value="<?php echo stripslashes($obj{"dischargeplan_ToD_IADL_notes"});?>" id="dischargeplan_ToD_IADL_notes" />
            <input type="checkbox" name="dischargeplan_ToD_IADL1"  <?php if ($obj{"dischargeplan_ToD_IADL1"} == "on"){echo "checked";};?> id="dischargeplan_ToD_IADL1" />
            <label for="IADL2"><?php xl('IADL','e');?></label>
            <input type="text" name="dischargeplan_ToD_IADL1_notes" style="width:330px" value="<?php echo stripslashes($obj{"dischargeplan_ToD_IADL1_notes"});?>" id="dischargeplan_ToD_IADL1_notes" />

        </tr><tr><td>
           <input type="checkbox" name="dischargeplan_ToD_ROM"  <?php if ($obj{"dischargeplan_ToD_ROM"} == "on"){echo "checked";};?> id="dischargeplan_ToD_ROM" />
            <label for="ROM in"><?php xl('ROM in','e');?></label>
            <input type="text" name="dischargeplan_ToD_ROM_in" style="width:840px" value="<?php echo stripslashes($obj{"dischargeplan_ToD_ROM_in"});?>" id="dischargeplan_ToD_ROM_in" /><br>
            <input type="checkbox" name="dischargeplan_ToD_Safety_Management" <?php if ($obj{"dischargeplan_ToD_Safety_Management"} == "on"){echo "checked";};?> id="dischargeplan_ToD_Safety_Management" />
            <label for="Safety Management in"><?php xl('Safety Management in','e');?></label>
            <input type="text" name="dischargeplan_ToD_Safety_Management_in" style="width:740px" value="<?php echo stripslashes($obj{"dischargeplan_ToD_Safety_Management_in"});?>" id="dischargeplan_ToD_Safety_Management_in" />

          </tr>
        <tr>
          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_Env_Adaptations" <?php if ($obj{"dischargeplan_ToD_Env_Adaptations"} == "on"){echo "checked";};?> id="dischargeplan_ToD_Env_Adaptations" />
            <label for="Environment Adaptations including"><?php xl('Environment Adaptations including','e');?></label>
            <input type="text" name="dischargeplan_ToD_Env_Adaptations_inc" style="width:660px" value="<?php echo stripslashes($obj{"dischargeplan_ToD_Env_Adaptations_inc"});?>" id="dischargeplan_ToD_Env_Adaptations_inc" />
          </td>
        </tr>
        <tr>
          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_AE_Usage" <?php if ($obj{"dischargeplan_ToD_AE_Usage"} == "on"){echo "checked";};?> id="dischargeplan_ToD_AE_Usage" />
            <label for="Adaptive Equipment Usage for"><?php xl('Adaptive Equipment Usage for','e');?></label>
            <input type="text" name="dischargeplan_ToD_AE_Usage_for" style="width:690px" value="<?php echo stripslashes($obj{"dischargeplan_ToD_AE_Usage_for"});?>" id="dischargeplan_ToD_AE_Usage_for" /><br>
            <input type="checkbox" name="dischargeplan_ToD_CF_Performance" <?php if ($obj{"dischargeplan_ToD_CF_Performance"} == "on"){echo "checked";};?> id="dischargeplan_ToD_CF_Performance" />
            <label for="Caregiver/Family Performance in"><?php xl('Caregiver/Family Performance in','e');?></label>
            <input type="text" name="dischargeplan_ToD_CF_Performance_in" style="width:670px" value="<?php echo stripslashes($obj{"dischargeplan_ToD_CF_Performance_in"});?>" id="dischargeplan_ToD_CF_Performance_in" />

          </td>
        </tr>
        <tr>
          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_ToD_Per_Home_Exercises" <?php if ($obj{"dischargeplan_ToD_Per_Home_Exercises"} == "on"){echo "checked";};?> id="dischargeplan_ToD_Per_Home_Exercises" />
            <label for="Performance of Home Exercises for"><?php xl('Performance of Home Exercises for','e');?></label>
            <input type="text" name="dischargeplan_ToD_Per_Home_Exercises_for" style="width:650px" value="<?php echo stripslashes($obj{"dischargeplan_ToD_Per_Home_Exercises_for"});?>" id="dischargeplan_ToD_Per_Home_Exercises_for" />
          </td>

        </tr>
        <tr>
          <td align="left" scope="row"><p><?php xl('Other','e');?>
            <input type="text" name="dischargeplan_ToD_Other" style="width:870px" value="<?php echo stripslashes($obj{"dischargeplan_ToD_Other"});?>" id="dischargeplan_ToD_Other" />
          </p></td>
        </tr>
        <tr>
          <td align="left" scope="row"><p><?php xl('Additional Comments Regarding Discharge Status of Patient','e');?>
            <input type="text" name="dischargeplan_ToD_Status_of_Patient" style="width:520px"  value="<?php echo stripslashes($obj{"dischargeplan_ToD_Status_of_Patient"});?>" id="dischargeplan_ToD_Status_of_Patient" />
          </p></td>

        </tr>
        </table>
 </tr>
  <tr>
    <td scope="row"><strong><?php xl('Functional Ability at Time of Discharge','e');?></strong><br />

      <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_Timeof_Discharge" value="Independent" <?php if ($obj{"dischargeplan_Functional_Ability_Timeof_Discharge"} == "Independent"){echo "checked";};?> id="dischargeplan_Functional_Ability_Timeof_Discharge" />

        <?php xl('Independent','e');?></label>
       <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_Timeof_Discharge" value="Independent with Minimal Assistance" <?php if ($obj{"dischargeplan_Functional_Ability_Timeof_Discharge"} == "Independent with Minimal Assistance"){echo "checked";};?> id="dischargeplan_Functional_Ability_Timeof_Discharge" />
              <?php xl('Independent with Minimal Assistance','e');?></label>
          <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_Timeof_Discharge" value="Partially Dependent" <?php if ($obj{"dischargeplan_Functional_Ability_Timeof_Discharge"} == "Partially Dependent"){echo "checked";};?> id="dischargeplan_Functional_Ability_Timeof_Discharge" />
              <?php xl('Partially Dependent','e');?></label>

         <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_Timeof_Discharge" value="Totally Dependent" <?php if ($obj{"dischargeplan_Functional_Ability_Timeof_Discharge"} == "Totally Dependent"){echo "checked";};?> id="dischargeplan_Functional_Ability_Timeof_Discharge" />
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
            <input type="checkbox" name="dischargeplan_Discharge_anticipated" value="Discharge was anticipated" <?php if ($obj{"dischargeplan_Discharge_anticipated"} == "Discharge was anticipated"){echo "checked";};?> id="dischargeplan_Discharge_anticipated" />
            <?php xl('Discharge was anticipated and discussed in advance with patient/caregiver/family and MD','e');?></label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Discharge_anticipated" value="Discharge was not anticipated" <?php if ($obj{"dischargeplan_Discharge_anticipated"} == "Discharge was not anticipated"){echo "checked";};?> id="dischargeplan_Discharge_anticipated" />
            <?php xl('Discharge was not anticipated','e');?></label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Discharge_anticipated" value="A Recommend follow-up treatment when patient returns to home" <?php if ($obj{"dischargeplan_Discharge_anticipated"} == "A Recommend follow-up treatment when patient returns to home"){echo "checked";};?> id="dischargeplan_Discharge_anticipated" />
            <?php xl('Recommend follow-up treatment when patient returns to home.','e');?></label></td>
        </tr>

        <tr>
        <td><label>
            <?php xl('Goals identified on care plan were','e');?></label>
            <input type="checkbox" name="dischargeplan_Recommendations_met" value="met" <?php if ($obj{"dischargeplan_Recommendations_met"} == "met"){echo "checked";};?> id="dischargeplan_Recommendations_met" />
            <?php xl('met','e');?>
            <input type="checkbox" name="dischargeplan_Recommendations_met" value="partially met" <?php if ($obj{"dischargeplan_Recommendations_met"} == "partially met"){echo "checked";};?> id="dischargeplan_Recommendations_partially" />
            <?php xl('partially met','e');?>
  <input type="checkbox" name="dischargeplan_Recommendations_met" value="not met" <?php if ($obj{"dischargeplan_Recommendations_met"} == "not met"){echo "checked";};?> id="dischargeplan_Recommendations_not_met" />
            <?php xl('not met (If goals partially met or not met please explain)','e');?>
  <input type="text" name="dischargeplan_Recommendations_not_met_note" style="width:910px"  value="<?php echo stripslashes($obj{"dischargeplan_Recommendations_not_met_note"});?>" id="dischargeplan_Recommendations_not_met_note" />
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
</body>
</html>
