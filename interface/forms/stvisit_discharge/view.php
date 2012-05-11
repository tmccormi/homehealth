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
$obj = formFetch("forms_st_visit_discharge_note", $_GET["id"]);
?>
<form method=post action="<?php echo $rootdir;?>/forms/stvisit_discharge/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="visitdischarge">
<h3 align="center"><?php xl('SPEECH THERAPY VISIT/DISCHARGE NOTE','e');?></h3><br><br>
<a href="javascript:top.restoreSession();document.visitdischarge.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
 <br></br>
<table width="100%" padding="2px" border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
  <tr>

    <td scope="row"><strong><?php xl('Patient Name','e');?></strong></th>
    <td><input type="text" name="patient_name" id="patient_name" value="<?php patientName()?>" disabled/></td>
    <td ><p><strong><?php xl('Time In','e');?></strong></p></td>
    <td><select name="dischargeplan_Time_In" id="dischargeplan_Time_In">
    <?php timeDropDown(stripslashes($obj{"dischargeplan_Time_In"}))?></select></td>
    <td ><p><strong><?php xl('Time Out','e');?></strong></p></td>
    <td><select name="dischargeplan_Time_Out" id="dischargeplan_Time_Out">
    <?php timeDropDown(stripslashes($obj{"dischargeplan_Time_Out"}))?></select></td>
    <td ><strong><?php xl('Date','e');?></strong></td>
    <td ><strong>
    <input type='text' size='10' name='dischargeplan_date' id='dischargeplan_date'
    value='<?php echo stripslashes($obj{"dischargeplan_date"});?>'
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
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
<td>
<strong><?php xl('TYPE OF VISIT','e');?></strong>
 <input type="checkbox" name="dischargeplan_type_of_visit" value="Visit" id="dischargeplan_type_of_visit"  
    <?php if ($obj{"dischargeplan_type_of_visit"} == "Visit"){echo "checked";};?>/>
 <?php xl('Visit','e');?>
 <input type="checkbox" name="dischargeplan_type_of_visit" value="Visit And Supervisory" id="dischargeplan_type_of_visit" 
 <?php if ($obj{"dischargeplan_type_of_visit"} == "Visit And Supervisory"){echo "checked";};?>/>
 <?php xl('Visit and Supervisory Review','e');?> 
  &nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl('Other','e');?>
<input type="text"  size="30px" name="dischargeplan_type_of_visit_other" id="dischargeplan_type_of_visit_other" 
  value="<?php echo stripslashes($obj{"dischargeplan_type_of_visit_other"});?>"/>
</td>
</tr>


  <tr>
    <td scope="row"><p><strong><?php xl('Vital Signs','e');?></strong></p></tr>
  <tr>
    <td scope="row"></th>
      <?php xl('Pulse','e');?>
<label for="pulse"></label>
    <input type="text"  size="5px" name="dischargeplan_Vital_Signs_Pulse" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Pulse"});?>" id="dischargeplan_Vital_Signs_Pulse" />
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Pulse_Type" value="Regular" <?php if ($obj{"dischargeplan_Vital_Signs_Pulse_Type"} == "Regular"){echo "checked";};?> id="dischargeplan_Vital_Signs_Regular" />

        <?php xl('Regular','e');?></label>
    <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Pulse_Type" value="Irregular" <?php if ($obj{"dischargeplan_Vital_Signs_Pulse_Type"} == "Irregular"){echo "checked";};?> id="dischargeplan_Vital_Signs_Irregular" />
        <?php xl('Irregular','e');?></label>&nbsp; &nbsp; &nbsp;
     <?php xl('Temperature','e');?> <input size="5px" type="text" name ="dischargeplan_Vital_Signs_Temperature"  value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Temperature"});?>" id="dischargeplan_Vital_Signs_Temperature" />
     <label>

        <input type="checkbox" name="dischargeplan_Vital_Signs_Temperature_Type" value="Oral" <?php if ($obj{"dischargeplan_Vital_Signs_Temperature_Type"} == "Oral"){echo "checked";};?> id="dischargeplan_Vital_Signs_Temperature_Type" />
        <?php xl('Oral','e');?></label>
     <label>
        <input type="checkbox" name="dischargeplan_Vital_Signs_Temperature_Type" value="Temporal" <?php if ($obj{"dischargeplan_Vital_Signs_Temperature_Type"} == "Temporal"){echo "checked";};?> id="dischargeplan_Vital_Signs_Temperature_Type" />
        <?php xl('Temporal','e');?></label>
     
 <br/>  <?php xl('Other','e');?> 
 <input type="text" size="9px" name="dischargeplan_Vital_Signs_other" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_other"});?>" id="dischargeplan_Vital_Signs_other" /> 
 <?php xl('Respirations    ','e');?><input type="text" size="5px" name="dischargeplan_Vital_Signs_Respirations" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Respirations"});?>" id="dischargeplan_Vital_Signs_Respirations" /> <br/>
 <?php xl('Blood Pressure Systolic    ','e');?><input type="text" size="5px" name="dischargeplan_Vital_Signs_BP_Systolic" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_BP_Systolic"});?>" id="dischargeplan_Vital_Signs_BP_Systolic" />/

<input type="text" size="5px" name="dischargeplan_Vital_Signs_BP_Diastolic" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_BP_Diastolic"});?>" id="dischargeplan_Vital_Signs_BP_Diastolic" />  <?php xl('Diastolic','e');?> 
 <label>
   <input type="checkbox" name="dischargeplan_Vital_Signs_BP_side" value="Right" <?php if ($obj{"dischargeplan_Vital_Signs_BP_side"} == "Right"){echo "checked";};?> id="dischargeplan_Vital_Signs_Right" />
      <?php xl('Right','e');?></label>

 <label>
   <input type="checkbox" name="dischargeplan_Vital_Signs_BP_side" value="Left" <?php if ($obj{"dischargeplan_Vital_Signs_BP_side"} == "Left"){echo "checked";};?> id="dischargeplan_Vital_Signs_Left" />
       <?php xl('Left','e');?></label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_BP_Position" value="Sitting" <?php if ($obj{"dischargeplan_Vital_Signs_BP_Position"} == "Sitting"){echo "checked";};?> id="dischargeplan_Vital_Signs_BP_Position" />
      <?php xl('Sitting','e');?></label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_BP_Position" value="Standing" <?php if ($obj{"dischargeplan_Vital_Signs_BP_Position"} == "Standing"){echo "checked";};?> id="dischargeplan_Vital_Signs_BP_Position" />

      <?php xl('Standing','e');?> </label>
     <label>
       <input type="checkbox" name="dischargeplan_Vital_Signs_BP_Position" value="Lying" <?php if ($obj{"dischargeplan_Vital_Signs_BP_Position"} == "Lying"){echo "checked";};?> id="dischargeplan_Vital_Signs_BP_Position" />
    <?php xl('Lying','e')?>
&nbsp;&nbsp;<?php xl('*O2 Sat','e');?> </label> 
     <input type="text" size="5px" name="dischargeplan_Vital_Signs_Sat" value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Sat"});?>" id="dischargeplan_Vital_Signs_Sat" />
    
     <?php xl('*Physician ordered','e');?> 
    </tr>



      <tr> <td>
      <strong> <?php xl('Pain','e');?> </strong>
      <input type="checkbox" name="dischargeplan_Vital_Signs_Pain" value="No Pain" id="dischargeplan_Vital_Signs_Pain"  
      <?php if ($obj{"dischargeplan_Vital_Signs_Pain"} == "No Pain"){echo "checked";};?>/>
       <?php xl('No Pain','e');?>
      <input type="checkbox" name="dischargeplan_Vital_Signs_Pain" value="Pain limits functional ability" id="dischargeplan_Vital_Signs_Pain" 
	<?php if ($obj{"dischargeplan_Vital_Signs_Pain"} == "Pain limits functional ability"){echo "checked";};?>/>
      <?php xl('Pain limits functional ability','e');?>
      &nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Intensity','e');?>
      <input type="text" size="5px" name="dischargeplan_Vital_Signs_Pain_Intensity" id="dischargeplan_Vital_Signs_Pain_Intensity"  
      value="<?php echo stripslashes($obj{"dischargeplan_Vital_Signs_Pain_Intensity"});?>"/>
      &nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="dischargeplan_Vital_Signs_Pain" value="Improve" id="dischargeplan_Vital_Signs_Pain"  
      <?php if ($obj{"dischargeplan_Vital_Signs_Pain"} == "Improve"){echo "checked";};?>/>
      <?php xl('Improve','e');?> </strong>
     <input type="checkbox" name="dischargeplan_Vital_Signs_Pain" value="Worse" id="dischargeplan_Vital_Signs_Pain" 
      <?php if ($obj{"dischargeplan_Vital_Signs_Pain"} == "Worse"){echo "checked";};?>/>
       <?php xl('Worse','e');?>
       <input type="checkbox" name="dischargeplan_Vital_Signs_Pain" value="No change" id="dischargeplan_Vital_Signs_Pain" 
      <?php if ($obj{"dischargeplan_Vital_Signs_Pain"} == "No change"){echo "checked";};?>/>
       <?php xl('No Change','e');?>
  </td> </tr>


<tr>
<td>
<?php xl('Please Note Contact MD if Vital Signs are Pulse','e')?>
&lt; <?php xl('56 or','e')?> &gt; <?php xl('120; Temperature','e')?> &lt; <?php xl('56 or','e')?>
&gt; <?php xl('101; Respirations','e')?> &lt; <?php xl('10 or','e')?> &gt; <?php xl('30 SBP','e')?>
&lt; <?php xl('80 or','e')?> &gt; <?php xl('190; DBP','e')?> &lt; <?php xl('50 or','e')?>
&gt; <?php xl('100; Pain Significantly Impacts patients ability to participate. O2 Sat','e')?>
&lt; <?php xl('90% after rest','e')?>
</td> </tr>

       <tr>
    <td scope="row"></td></tr>
  <tr>
    <td scope="row"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM ','e');?></strong>
    <select name="dischargeplan_treatment_diagnosis_problem" id="dischargeplan_treatment_diagnosis_problem">
    <?php ICD9_dropdown(stripslashes($obj{"dischargeplan_treatment_diagnosis_problem"}))?></select>
  </tr>
 
    <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>
          <td height="29" colspan="3" align="left" scope="row"><p><strong><?php xl('Reason for Discharge (Check all that apply)','e');?></strong></p></td>
        </tr>

        <tr>
          <td width="31%" valign="top" scope="row">
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
          <td width="42%" valign="top">
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
          <td width="27%" valign="top">
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
            <input type="text" name="dischargeplan_RfD_other" value="<?php echo stripslashes($obj{"dischargeplan_RfD_other"});?>" id="dischargeplan_RfD_other" />
          </td>
        </tr>
         </table>
  </tr>
  
    <tr>
  <td scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e');?></strong><br />
  <textarea name="dischargeplan_Specific_Training" id="dischargeplan_Specific_Training" cols ="70" rows="2"  wrap="virtual name">
<?php echo stripslashes($obj{"dischargeplan_Specific_Training"});?></textarea>  

<tr>
    <td scope="row">&nbsp;</th>
  <strong><?php xl('Functional Improvements At Time of Discharge','e');?></strong></tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>

          <td align="left" scope="row">
            <input type="checkbox" name="dischargeplan_Improved_Oral_Stage" <?php if ($obj{"dischargeplan_Improved_Oral_Stage"} == "on"){echo "checked";};?> id="dischargeplan_Improved_Oral_Stage" />
            <label><?php xl('Improved Oral Stage skills in','e');?></label>
            <input type="text" size="15%" name="dischargeplan_Improved_Oral_Stage_In" value="<?php echo stripslashes($obj{"dischargeplan_Improved_Oral_Stage_In"});?>" id="dischargeplan_Improved_Oral_Stage_In" />
            <input type="checkbox" name="dischargeplan_Improved_Pharyngeal_Stage"  <?php if ($obj{"dischargeplan_Improved_Pharyngeal_Stage"} == "on"){echo "checked";};?> id="dischargeplan_Improved_Pharyngeal_Stage" />
            <label><?php xl('Improved Pharyngeal Stage Skills in','e');?></label>
            <input type="text" size="15%" name="dischargeplan_Improved_Pharyngeal_Stage_In" value="<?php echo stripslashes($obj{"dischargeplan_Improved_Pharyngeal_Stage_In"});?>" id="dischargeplan_Improved_Pharyngeal_Stage_In" />

	    <br/>
	    <input type="checkbox" name="dischargeplan_Improved_Verbal_Expression"  <?php if ($obj{"dischargeplan_Improved_Verbal_Expression"} == "on"){echo "checked";};?> id="dischargeplan_Improved_Verbal_Expression" />
            <label><?php xl(' Improved Verbal Expression in','e');?></label>
            <input type="text" name="dischargeplan_Improved_Verbal_Expression_In" size="15%" value="<?php echo stripslashes($obj{"dischargeplan_Improved_Verbal_Expression_In"});?>" id="dischargeplan_Improved_Verbal_Expression_In" />
            <input type="checkbox" name="dischargeplan_Improved_Non_Verbal_Expression"  <?php if ($obj{"dischargeplan_Improved_Non_Verbal_Expression"} == "on"){echo "checked";};?> id="dischargeplan_Improved_Non_Verbal_Expression" />
            <label><?php xl('Improved Non Verbal Expression in','e');?></label>
            <input type="text" name="dischargeplan_Improved_Non_Verbal_Expression_In" size="15%" value="<?php echo stripslashes($obj{"dischargeplan_Improved_Non_Verbal_Expression_In"});?>" id="dischargeplan_Improved_Non_Verbal_Expression_In" />

	    <br/>
            <input type="checkbox" name="dischargeplan_Improved_Comprehension"  
	      <?php if ($obj{"dischargeplan_Improved_Comprehension"} == "on"){echo "checked";};?> 
	      id="dischargeplan_Improved_Comprehension" />
            <label><?php xl('Improved Comprehension in','e');?></label>
            <input type="text" name="dischargeplan_Improved_Comprehension_In" size="60%" value="<?php echo stripslashes($obj{"dischargeplan_Improved_Comprehension_In"});?>" id="dischargeplan_Caregiver_Family_Performance" />

	    <br/>
            <input type="checkbox" name="dischargeplan_Caregiver_Family_Performance" <?php if ($obj{"dischargeplan_Caregiver_Family_Performance"} == "on"){echo "checked";};?> id="dischargeplan_ToD_Caregiver_Family_Performance" />
            <label><?php xl('Caregiver/Family Performance in','e');?></label>
            <input type="text" name="dischargeplan_Caregiver_Family_Performance_In" size="60%" value="<?php echo stripslashes($obj{"dischargeplan_Caregiver_Family_Performance_In"});?>" id="dischargeplan_Caregiver_Family_Performance_In" />
	                

	    <br/>
	    <input type="checkbox" name="dischargeplan_Functional_Improvements_Other" <?php if ($obj{"dischargeplan_Functional_Improvements_Other"} == "on"){echo "checked";};?> id="dischargeplan_Functional_Improvements_Other" />
	    <label><?php xl('Other','e');?></label>
	    <input type="text" name="dischargeplan_Functional_Improvements_Other_Note" size="60%" id="dischargeplan_Functional_Improvements_Other_Note" value="<?php echo stripslashes($obj{"dischargeplan_Functional_Improvements_Other_Note"});?>" />

	    <br/>
           <?php xl('Additional Comments Regarding Discharge Status of Patient','e');?>
            <input type="text" name="dischargeplan_Functional_Improvements_Comments" size="40%" value="<?php echo stripslashes($obj{"dischargeplan_Functional_Improvements_Comments"});?>" id="dischargeplan_Functional_Improvements_Comments" />
          </p></td>

        </tr>
        </table>
 </tr>
  <tr>
    <td scope="row"><strong><?php xl('Functional Ability in','e');?>
	 <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="Swallow" id="dischargeplan_Functional_Ability_In"  
	      <?php if ($obj{"dischargeplan_Functional_Ability_In"} == "Swallow"){echo "checked";};?>/>
        <?php xl('Swallow','e');?></label>
	<label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="Communication at discharge" id="dischargeplan_Functional_Ability_In" 
	    <?php if ($obj{"dischargeplan_Functional_Ability_In"} == "Communication at discharge"){echo "checked";};?>/>
        <?php xl('Communication at Time of Discharge','e');?></label><br />

            <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="WFL" 
<?php if ($obj{"dischargeplan_Functional_Ability_In"} == "WFL"){echo "checked";};?> id="dischargeplan_Functional_Ability_In" />
        <?php xl('WFL = within functional limits;','e');?></label> 
       <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="WFL with cues" 
<?php if ($obj{"dischargeplan_Functional_Ability_In"} == "WFL with cues"){echo "checked";};?> id="dischargeplan_Functional_Ability_In" />
              <?php xl('WFL with cues;','e');?></label>
          <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="Mild impairment" 
<?php if ($obj{"dischargeplan_Functional_Ability_In"} == "Mild impairment"){echo "checked";};?> id="dischargeplan_Functional_Ability_In" />
              <?php xl('Mild impairment;','e');?></label>

         <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="Moderate impairment" 
<?php if ($obj{"dischargeplan_Functional_Ability_In"} == "Moderate impairment"){echo "checked";};?> id="dischargeplan_Functional_Ability_In" />
              <?php xl('Moderate impairment;','e');?></label>

	     <br/> <label>
              <input type="checkbox" name="dischargeplan_Functional_Ability_In" value="Severe impairment" id="dischargeplan_Functional_Ability_In" 
		<?php if ($obj{"dischargeplan_Functional_Ability_In"} == "Severe impairment"){echo "checked";};?>/>
              <?php xl('Severe impairment','e');?></label>  </strong> 

  </tr>
  <tr>
    <td scope="row"><p><strong><?php xl('COMMENTS/RECOMMENDATIONS','e');?></strong></p>
  </tr>
  <tr>
    <td scope="row">
      <table width="100%" class="formtable">
        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Comments_Recommendations" value="Discharge was anticipated" <?php if ($obj{"dischargeplan_Comments_Recommendations"} == "Discharge was anticipated"){echo "checked";};?> id="dischargeplan_Comments_Recommendations" />
            <?php xl('Discharge was anticipated and discussed in advance with patient/caregiver/family and MD','e');?></label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Comments_Recommendations" value="Discharge was not anticipated" <?php if ($obj{"dischargeplan_Comments_Recommendations"} == "Discharge was not anticipated"){echo "checked";};?> id="dischargeplan_Comments_Recommendations" />
            <?php xl('Discharge was not anticipated','e');?></label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="dischargeplan_Comments_Recommendations" value="Recommend follow-up treatment" <?php if ($obj{"dischargeplan_Comments_Recommendations"} == "Recommend follow-up treatment"){echo "checked";};?> id="dischargeplan_Comments_Recommendations" />
            <?php xl('A Recommend follow-up treatment when patient returns to home.','e');?></label></td>
        </tr>


        <tr>
        <td><label>
            <?php xl('Goals identified on care plan were','e');?></label>
            <input type="checkbox" name="dischargeplan_Goals_identified_on_careplan" value="met" <?php if ($obj{"dischargeplan_Goals_identified_on_careplan"} == "met"){echo "checked";};?> id="dischargeplan_Goals_identified_on_careplan" />
            <?php xl('met*','e');?>
            <input type="checkbox" name="dischargeplan_Goals_identified_on_careplan" value="partially met" <?php if ($obj{"dischargeplan_Goals_identified_on_careplan"} == "partially met"){echo "checked";};?> id="dischargeplan_Goals_identified_on_careplan" />
            <?php xl('partially met*','e');?>
  <input type="checkbox" name="dischargeplan_Goals_identified_on_careplan" value="not met" <?php if ($obj{"dischargeplan_Goals_identified_on_careplan"} == "not met"){echo "checked";};?> id="dischargeplan_Goals_identified_on_careplan" />
            <?php xl('not met* (*If goals partially met or not met please explain)','e');?>
  <input type="text" name="dischargeplan_Goals_notmet_explanation" size="70%" value="<?php echo stripslashes($obj{"dischargeplan_Goals_notmet_explanation"});?>" id="dischargeplan_Goals_notmet_explanation" />
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
