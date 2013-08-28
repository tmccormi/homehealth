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
	    obj.open("GET",site_root+"/forms/stvisit_notes/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>
</style>
</head>

<body><h3 align="center"><?php xl('SPEECH THERAPY VISIT/DISCHARGE NOTE','e'); ?></h3>
<form method=post action="<?php echo $rootdir;?>/forms/stvisit_notes/save.php?mode=new" name="visitnotes">
<table width="100%"  border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row">
    <table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr>
        <td scope="row"><strong><?php xl('Patient Name','e'); ?></strong></td>
        <td align="center" valign="top">
        <input type="text" id="patient_name" value="<?php patientName()?>" readonly /></td>
        <td><strong><?php xl('Time In','e'); ?></strong></td>
        <td><select name="visitnote_Time_In" id="visitnote_Time_In"><?php timeDropDown($GLOBALS['Selected']) ?></select></td>
        <td><strong><?php xl('Time Out','e'); ?></strong></td>
        <td><select name="visitnote_Time_Out" id="visitnote_Time_Out"><?php timeDropDown($GLOBALS['Selected']) ?></select></td>
        <td><strong><?php xl('Date','e'); ?></strong></td>
        <td>
        <input type='text' size='10' name="visitnote_visitdate" id='visitnote_visitdate' title='<?php xl('Date','e'); ?>'
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
<?php xl('Visit','e'); ?>
<input type="checkbox" name="visitnote_Type_of_Visit" value="visit_Supervisory" id="visitnote_Type_of_Visit" />
<?php xl('Visit and Supervisory Review','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> 
<input type="text" style="width:50%" name="visitnote_Type_of_Visit_Other" id="visitnote_Type_of_Visit_Other" /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('VITAL SIGNS','e'); ?></strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pulse','e'); ?> 
    <input type="text" size="5px" name="visitnote_VS_Pulse" id="visitnote_VS_Pulse" /> 
    <input type="checkbox" name="visitnote_VS_Pulse_type" value="regular" id="visitnote_VS_Pulse_type" />
<?php xl('Regular','e'); ?>
<input type="checkbox" name="visitnote_VS_Pulse_type" value="Irregular" id="visitnote_VS_Pulse_type" />
<?php xl('Irregular','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Temperature','e'); ?>
 <input type="text" size="5px" name="visitnote_VS_Temperature" id="visitnote_VS_Temperature" /> 
 <input type="checkbox" name="visitnote_VS_Temperature_type" value="Oral" id="visitnote_VS_Temperature_type" />
<?php xl('Oral','e'); ?>
<input type="checkbox" name="visitnote_VS_Temperature_type" value="Temporal" id="visitnote_VS_Temperature_type" />
<?php xl('Temporal','e'); ?>&nbsp;&nbsp;
<?php xl('Other','e'); ?>&nbsp;
<input type="text" style="width:31%" name="visitnote_VS_Other" id="visitnote_VS_Other"><br>
 <?php xl('Respirations','e'); ?>&nbsp;
<input type="text" size="7px" name="visitnote_VS_Respirations" id="visitnote_VS_Respirations" />&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Blood Pressure Systolic','e'); ?>
  <input type="text" size="6px" name="visitnote_VS_BP_Systolic" id="visitnote_VS_BP_Systolic" />
  /
<input type="text" size="6px" name="visitnote_VS_BP_Diastolic" id="visitnote_VS_BP_Diastolic" />
<?php xl('Diastolic','e');?>
<input type="checkbox" name="visitnote_VS_BP_side" value="Right" id="visitnote_VS_BP_side" />
<?php xl('Right','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_side" value="Left" id="visitnote_VS_BP_side" />
<?php xl('Left','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Sitting" id="visitnote_VS_BP_Sitting" />
<?php xl('Sitting','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Standing" id="visitnote_VS_BP_Standing" />
<?php xl('Standing','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Lying" id="visitnote_VS_BP_Lying" />
<?php xl('Lying','e')?><br>
<?php xl('*O','e')?>
<sub> <?php xl('2','e')?></sub>
<?php xl('Sat','e'); ?> 
<input type="text" size="7px" name="visitnote_VS_BP_Sat" id="visitnote_VS_BP_Sat" /> *<?php xl('Physician ordered','e'); ?></td>

  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('Pain','e'); ?></strong>
  <input type="checkbox" name="visitnote_VS_Pain" value="Nopain" id="visitnote_VS_Pain_Nopain" />
<?php xl('No Pain','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain" value="Pain limits functional ability" id="visitnote_VS_Pain_Pain_limits" />
<?php xl('Pain limits functional ability','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Intensity','e'); ?>
<input type="text" name="visitnote_VS_Pain_Intensity" id="visitnote_VS_Pain_Intensity" />
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="Improve" id="visitnote_VS_Pain_Intensity_Improve" />
<?php xl('Improve','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="Worse" id="visitnote_VS_Pain_Intensity_Worse" />
<?php xl('Worse','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="No Change" id="visitnote_VS_Pain_Intensity_No_Change" />
<?php xl('No Change','e'); ?><br>
<?php xl('Location(s)','e')?>&nbsp;
<input type="text" style="width:30%" name="visitnote_VS_Pain_Location" id="visitnote_VS_Pain_Location" />
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><p><strong><?php xl('Please Note: Contact MD if Vital Signs are Pulse &lt;56 or &gt;120; Temperature  &lt;56 or &gt;101; Respirations &lt;10 or &gt;30 SBP &lt;80 or &gt;190; DBP &lt;50  or  &gt;100; Pain  Significantly  Impacts patients ability to participate. Sat &lt;90% after rest','e'); ?></strong></p></td>
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
                  <input type="checkbox" name="visitnote_Pat_Homebound_Medical_Restrictions" id="visitnote_Pat_Homebound_Medical_Restrictions" />
                  <?php xl('Medical Restrictions in','e'); ?></label>
                  <input type="text" style="width:55%"  name="visitnote_Pat_Homebound_Medical_Restrictions_In" id="visitnote_Pat_Homebound_Medical_Restrictions_In" />
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
              <input type="text" style="width:87%" name="visitnote_Pat_Homebound_Other"  id="visitnote_Pat_Homebound_Other" />
            </p></td>
        </tr>
    </table>      
      <strong><?php xl('INTERVENTIONS','e'); ?> 
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" value="Patient"/>
<?php xl('Patient','e'); ?>
&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" value="Caregiver"/>
<?php xl('Caregiver','e'); ?>
&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" value="Patient and Caregiver"/>
<?php xl('Patient and Caregiver','e')?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Other','e'); ?>&nbsp;
<input type="text" style="width:35%" name="visitnote_Interventions_Other" id="visitnote_Interventions_Other" /></strong>
<br /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr valign="top">
        <td scope="row">
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Evaluation" id="visitnote_Evaluation" />
                <?php xl('Evaluation','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Dysphagia_Compensatory" id="visitnote_Dysphagia_Compensatory" />
                <?php xl('Dysphagia Compensatory Strategies','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Swallow_Exercise" id="visitnote_Swallow_Exercise" />
                <?php xl('Swallow Exercise Program','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Safety_Training" id="visitnote_Safety_Training" />
                <?php xl('Safety Training in Swallow Techniques','e'); ?></label></td>
            </tr>           
          </table>
        </td>
        <td>
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Cognitive_Impairment" id="visitnote_Cognitive_Impairment" />
               <?php xl('Cognitive Impairment Management','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Communication_Strategies" id="visitnote_Communication_Strategies" />
             <?php xl('Communication Strategies','e'); ?>   </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Cognitive_Compensatory" id="visitnote_Cognitive_Compensatory" />
               <?php xl('Cognitive Compensatory Skills','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Patient_Caregiver_Family_Education" id="visitnote_Patient_Caregiver_Family_Education" />
                <?php xl('Patient/Caregiver/Family Education','e'); ?></label></td>
            </tr>	 
          </table>
        </td>
        <td>
         <?php xl('Other','e'); ?> &nbsp;&nbsp; <div>
            <textarea rows="6" cols="40" name="visitnote_Other1" size="35px" id="visitnote_Other1"></textarea>
        </div> </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e'); ?></strong>
      <textarea  name="visitnote_Specific_Training_Visit" cols="100" id="visitnote_Specific_Training_Visit" ></textarea><br />
      <strong><?php xl('Has the patient had any changes in medications since the last visit?','e'); ?>
      <input type="checkbox" name="visitnote_changes_in_medications"  id="visitnote_changes_in_medications" value="Yes"/>
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_changes_in_medications" id="visitnote_changes_in_medications" value="No"/>
<?php xl('No','e'); ?>&nbsp;&nbsp;<?php xl('If yes, update medication profile','e'); ?> </strong><br />
    </td>
  </tr>
  
<tr>
    <td scope="row">&nbsp;</th>
  <strong><?php xl('FUNCTIONAL IMPROVEMENTS','e');?></strong></tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="2px" class="formtable">
        <tr>

          <td align="left" scope="row">
            <input type="checkbox" name="visitnote_Improved_Oral_Stage" id="visitnote_Improved_Oral_Stage" />
            <label><?php xl('Improved Oral Stage skills in','e');?></label>
            <input type="text" style="width:56%" name="visitnote_Improved_Oral_Stage_In" id="visitnote_Improved_Oral_Stage_In" /><br>
            <input type="checkbox" name="visitnote_Improved_Pharyngeal_Stage" id="visitnote_Improved_Pharyngeal_Stage" />
            <label><?php xl('Improved Pharyngeal Stage Skills in','e');?></label>
            <input type="text" style="width:50%" name="visitnote_Improved_Pharyngeal_Stage_In" id="visitnote_Improved_Pharyngeal_Stage_In" />
	    <br/>
	    <input type="checkbox" name="visitnote_Improved_Verbal_Expression" id="visitnote_Improved_Verbal_Expression" />
            <label><?php xl(' Improved Verbal Expression in','e');?></label>
            <input type="text" name="visitnote_Improved_Verbal_Expression_In" style="width:55%" id="visitnote_Improved_Verbal_Expression_In" /><br>
	    <input type="checkbox" name="visitnote_Improved_Non_Verbal_Expression" id="visitnote_Improved_Non_Verbal_Expression" />
            <label><?php xl('Improved Non Verbal Expression in','e');?></label>
            <input type="text" name="visitnote_Improved_Non_Verbal_Expression_In" style="width:51%" id="visitnote_Improved_Non_Verbal_Expression_In" /> 

	    <br/>
            <input type="checkbox" name="visitnote_Improved_Comprehension" id="visitnote_Improved_Comprehension" />
            <label><?php xl('Improved Comprehension in','e');?></label>
            <input type="text" name="visitnote_Improved_Comprehension_In" style="width:56%" id="visitnote_Improved_Comprehension_In" />
            

	    <br/>
	    <input type="checkbox" name="visitnote_Caregiver_Family_Performance" id="visitnote_Caregiver_Family_Performance" />
            <label><?php xl('Caregiver/Family Performance in','e');?></label>
            <input type="text" name="visitnote_Caregiver_Family_Performance_In" style="width:52%" id="visitnote_Caregiver_Family_Performance_In" />
	    
	    <br/>
	    <input type="checkbox" name="visitnote_Functional_Improvements_Other" id="visitnote_Functional_Improvements_Other" />
	    <label><?php xl('Other','e');?></label>
	    <input type="text" name="visitnote_Functional_Improvements_Other_Note" style="width:91%" id="visitnote_Functional_Improvements_Other_Note" />

	    <br/>
                    <?php xl('Additional Comments Regarding Discharge Status of Patient','e');?>
            <input type="text" name="visitnote_FI_Additional_Comments" style="width:56%" id="visitnote_FI_Additional_Comments" />
          </td>

        </tr>
        </table>
 </tr>
 
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PATIENT/CAREGIVER/FAMILY RESPONSE TO VISIT','e'); ?>&nbsp;</strong> 
    <input type="checkbox" name="visitnote_Response_To_Visit" value="Verbalized Understanding" id="visitnote_Response_To_Visit" />
<?php xl('Verbalized Understanding','e'); ?>
  <input type="checkbox" name="visitnote_Response_To_Visit" value="Demonstrated Task" id="visitnote_Response_To_Visit" />
<?php xl('Demonstrated Task','e'); ?>&nbsp;<br>
<input type="checkbox" name="visitnote_Response_To_Visit" value="Needed Guidance" id="visitnote_Response_To_Visit" />
<?php xl('Needed Guidance/Re-Instruction','e'); ?>&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> <strong>
<input type="text"  style="width:67%" name="visitnote_Response_To_Visit_Other" id="visitnote_Response_To_Visit_Other" />
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong>
    
<?php xl('CARE PLAN REVIEWED WITH','e'); ?> 
  <input type="checkbox" name="visitnote_Discharge_Discussed" id="visitnote_Discharge_Discussed" />
<?php xl('DISCHARGE DISCUSSED WITH','e'); ?></strong>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Patient" id="visitnote_DDW_Patient" />
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Physician" id="visitnote_DDW_Physician" />
<?php xl('Physician','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="PT/OT/ST" id="visitnote_DDW_PT_OT_ST" />
<?php xl('PTA','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="PTA" id="visitnote_DDW_PT_OT_ST" />
<?php xl('PT/OT/ST','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Skilled Nursing" id="visitnote_CPRW_Skilled_Nursing" />
<?php xl('Skilled Nursing','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Caregiver Family" id="visitnote_CPRW_Caregiver_Family" />
<?php xl('Caregiver/Family','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Case Manager" id="visitnote_CPRW_Case_Manager" /><?php xl('Case Manager','e'); ?><br>
<?php xl('Other','e'); ?>&nbsp;
<input type="text" name="visitnote_CPRW_Other" style="width:93%" id="visitnote_CPRW_Other" />

<br />
<input type="checkbox" name="visitnote_CarePlan_Modifications" id="visitnote_CarePlan_Modifications" />
<strong><?php xl('CARE PLANS MODIFICATIONS INCLUDE','e'); ?>&nbsp;
<input type="text" style="width:64%" name="visitnote_CarePlan_Modifications_Include" id="visitnote_CarePlan_Modifications_Include" />
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row">
    <strong><?php xl('FURTHER SKILLED VISITS REQUIRED TO','e'); ?></strong><br> 
    <input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Reprioritize exercise" id="visitnote_FSVR_Progress_Reprioritize_exercise" />
<?php xl('Progress/Re-prioritize exercise program','e'); ?><br>
  <input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Train patient" id="visitnote_FSVR_Train_patient" />
<?php xl('Train patient in additional skills such as','e'); ?>&nbsp;
<input type="text" style="width:66%" name="visitnote_Train_patient_Suchas_Notes" id="visitnote_Train_patient_Suchas_Notes" />
<br/>
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Caregiver/Family" id="visitnote_FSVR_Train_Caregiver_Family" />
<?php xl('Train Caregiver/Family','e'); ?>&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?>
<strong>
<input type="text" style="width:73%" name="visitnote_FSVR_Other" id="visitnote_FSVR_Other" />
</strong><br>
<?php xl('Approximate Date of Next Visit','e'); ?>&nbsp;
<input type='text' size='10' name='visitnote_Date_of_Next_Visit' id='visitnote_Date_of_Next_Visit' 
title='<?php xl('Date','e'); ?>'
onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
height='22' id='img_curr_date' border='0' alt='[?]'
style='cursor: pointer; cursor: hand'
title='<?php xl('Click here to choose a date','e'); ?>'> 
<script LANGUAGE="JavaScript">
Calendar.setup({inputField:"visitnote_Date_of_Next_Visit", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
 </script>


<br><input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Met Goals" id="visitnote_Date_of_Next_Visit" />
<?php xl('No further visits required Patient/Caregiver have met goals','e'); ?>
<br><input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Met max potential" id="visitnote_No_further_visits_PC_Met_max_potential" />
<?php xl('No further visits required. Patient/Caregiver have met maximum  potential that can be impacted by therapy.','e'); ?>
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PLAN','e'); ?></strong><br/>
      <input type="checkbox" name="visitnote_Plan_Type" value="Current Treatment Appropriate" id="visitnote_Plan_Current_Treatment_Plan" />
<?php xl('Current Treatment Plan Frequency and Duration is Appropriate','e'); ?><br>
<input type="checkbox" name="visitnote_Plan_Type" value="Initiate Discharge" id="visitnote_Plan_Initiate_Discharge" />
<?php xl('Initiate Discharge, physician order and summary of treatment','e'); ?><br>
<input type="checkbox" name="visitnote_Plan_Type" value="May require treatment" id="visitnote_Plan_Require_Additional_Treatment" />
<?php xl('May require additional treatment session(s) to achieve Long Term Outcomes due to ','e'); ?>
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="shortterm memory" id="visitnote_Plan_Short_term_memory" />&nbsp;<?php xl('short term memory difficulties','e'); ?><br>&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="Minimal Support" id="visitnote_Plan_minimal_support" />
<?php xl('minimal support systems','e'); ?>
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="Language barriers" id="visitnote_Plan_Communication_language_barriers" />
<?php xl('communication, language barriers','e'); ?><br>
<input type="checkbox" name="visitnote_Plan_Type" value="Will address issues by" id="visitnote_Plan_Address_above_issues" />
<?php xl('Will address above issues by','e'); ?>&nbsp;
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="physical demonstration" id="visitnote_Plan_Providing_written_directions" />
<?php xl('Providing written directions and/or physical demonstration','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="community support" id="visitnote_Plan_Establish_community_support" />
<?php xl('establish community support systems','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="home adaptations" id="visitnote_Plan_Home_env_adaptations" />
<?php xl('home/environmental adaptations','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="use family/professionals" id="visitnote_Plan_Use_family_professionals" />
<?php xl('use family/professionals for interpretations as needed','e'); ?>
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
<a href="javascript:top.restoreSession();document.visitnotes.submit();" class="link_submit">[<?php xl('Save','e'); ?>]</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
 </form>
</body>
</html>

