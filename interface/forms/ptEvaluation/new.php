<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: evaluation");
?>

<html>
<head>
<title><?php xl('Evaluation','e')?></title>
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
	    	 if(Dx=='Evaluation_Reason_for_intervention')
	    	 {
		    	med_icd9.innerHTML= result['res'];
	    	 }
	    	 if(Dx=="Evaluation_TREATMENT_DX_PT_Problem")
	    	 {
	    		 trmnt_icd9.innerHTML= result['res'];
	    	 }
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/ptEvaluation/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>
 
<script>
function requiredCheck(){
    var time_in = document.getElementById('Evaluation_Time_In').value;
    var time_out = document.getElementById('Evaluation_Time_Out').value;
				var date = document.getElementById('Evaluation_date').value;
    
				if(time_in != "" && time_out != "" && date != "") {
        return true;
    } else {
        alert("Please select a time in, time out, and encounter date before submitting.");
        return false;
    }
}
</script>
</head>

<body>
	<form method="post"
		action="<?php echo $rootdir;?>/forms/ptEvaluation/save.php?mode=new" name="evaluation">
		<h3 align="center"><?php xl('PHYSICAL THERAPY EVALUATION','e'); ?></h3>
<table align="center"  border="1" cellpadding="0px" cellspacing="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="5px" class="formtable">

        <tr>
          <td width="5%"  align="center" scope="row"><strong><?php xl('Patient Name','e')?></strong></td>
         <td width="15%" align="center" valign="top"><input type="text"
					id="patient_name" value="<?php patientName()?>"
					readonly/></td>
          <td width="10%"  align="center"><strong><?php xl('MR#','e')?></strong></td>
          <td width="15%" align="center" valign="top" class="bold"><input
				style="width:100%" type="text" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" readonly /></td>

		 <td width="5%"><strong><?php xl('Time In','e'); ?></strong></td>
        <td width="9%"><select name="Evaluation_Time_In" id="Evaluation_Time_In"> <?php timeDropDown($GLOBALS['Selected']) ?></select></td>
        <td width="5%"><strong><?php xl('Time Out','e'); ?></strong></td>
        <td width="9%"> <select name="Evaluation_Time_Out" id="Evaluation_Time_Out"> <?php timeDropDown($GLOBALS['Selected']) ?></select></td>
 
          <td width="5%" align="center"><strong><?php xl('Encounter Date','e')?></strong></td>
<td width="20%" > <input type='text' size='10' name='Evaluation_date' id='Evaluation_date' 
					title='<?php xl('Encounter Date','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
	style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"Evaluation_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script></td>
        </tr>
      </table>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td>
<strong><?php xl('Vital Signs','e')?></strong></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table border="0" cellspacing="0px"  cellpadding="5px" class="formtable"><tr>
<td><?php xl('Pulse','e')?> 

        <input type="text" name="Evaluation_Pulse" size="3px" id="Evaluation_Pulse" />
        
          <input type="checkbox" name="Evaluation_Pulse_State" value="Regular" id="Evaluation_Pulse_State" />
                <?php xl('Regular','e')?>
      
          <input type="checkbox" name="Evaluation_Pulse_State" value="Irregular" id="Evaluation_Pulse_State" />
          <?php xl('Irregular','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Temperature','e')?> 

      <input type="text" size="5px" name="Evaluation_Temperature" id="Evaluation_Temperature" /> 
	  <input type="checkbox" name="Evaluation_Temperature_type" value="Oral" id="Evaluation_Temperature_type" />
<?php xl('Oral','e')?>
<input type="checkbox" name="Evaluation_Temperature_type" value="Temporal" id="Evaluation_Temperature_type" />
<?php xl('Temporal','e')?>&nbsp;  
     <?php xl('Other','e')?>
     <input type="text" style="width:70px" name="Evaluation_VS_other" id="Evaluation_VS_other" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
<?php xl('Respirations','e')?>
      <input type="text" style="width:60px" name="Evaluation_VS_Respirations" id="Evaluation_VS_Respirations" />      <br/>
      <?php xl('Blood Pressure Systolic','e')?>
      <input type="text" size="3px" name="Evaluation_VS_BP_Systolic" id="Evaluation_VS_BP_Systolic" />
      <?php xl('/ Diastolic','e')?> 
      <input type="text" size="3px" name="Evaluation_VS_BP_Diastolic" id="Evaluation_VS_BP_Diastolic" /> 
      
        <input type="checkbox" name="Evaluation_VS_BP_Body_side" value="Right" id="Evaluation_VS_BP_Body_side" />
            <?php xl('Right','e')?>
        
            <input type="checkbox" name="Evaluation_VS_BP_Body_side" value="Left" id="Evaluation_VS_BP_Body_side" />
            <?php xl('Left','e')?>          
          
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Sitting" id="Evaluation_VS_BP_Body_Position" />
            <?php xl('Sitting','e')?>
          
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Standing" id="Evaluation_VS_BP_Body_Position" />
            <?php xl('Standing','e')?>
      
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Lying" id="Evaluation_VS_BP_Body_Position" />
            <?php xl('Lying','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('*O','e')?> <sub> <?php xl('2','e')?></sub> <?php xl('Sat','e')?>
      <input type="text" name="Evaluation_VS_Sat" size="3px" id="Evaluation_VS_Sat" /> 
<?php xl('*Physician ordered','e')?></td></tr></table></td></tr>

<tr>
<td scope="row"><table border="0" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong><?php xl('Pain','e')?></strong>
 
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="Pain" id="Evaluation_VS_Pain" />
    <?php xl('No Pain','e')?>
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="No Pain" id="Evaluation_VS_Pain" />
    <?php xl('Pain limits functional ability ','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Intensity ','e')?>

  <input type="text" size="5px" name="Evaluation_VS_Pain_Intensity" id="Evaluation_VS_Pain_Intensity" />
  <?php xl('(0-10)','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Location(s)','e')?>
  <input type="text" size="25px" name="Evaluation_VS_Location" id="Evaluation_VS_Location" />
  <br />
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="pain due to recent injury" id="Evaluation_VS_Pain" />
  <?php xl('Pain due to recent illness/injury','e')?>
  
  <input type="checkbox" name="Evaluation_VS_Pain" value="Chronic pain" id="Evaluation_VS_Pain " />
  <?php xl('Chronic pain','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <?php xl('Other','e')?>
  <input type="text" name="Evaluation_VS_Other1" style="width:480px" id="Evaluation_VS_Other1" />
  </td>
  </tr>
  </table>
  </td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong>
<?php xl('Please Note Contact MD if Vital Signs are Pulse','e')?>&lt;
<?php xl('56 or','e')?> &gt;<?php xl('120 Temperature ','e')?>&lt;
<?php xl('56 or','e')?> &gt;<?php xl('101 Respirations','e')?> &lt;<?php xl('10 or','e')?>&gt;
<?php xl('30','e')?> <br /></strong>
<strong> <?php xl('SBP','e')?> &lt; <?php xl('80 or','e')?> &gt;<?php xl('190 DBP','e')?>&lt;
<?php xl('50 or','e')?>&gt;<?php xl('100 Pain Significantly Impacts patients ability to participate. O2 Sat ','e')?>
&lt; <?php xl('90% after rest','e')?></strong>  
  </td></tr></table>
  </td></tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
        <tr>
          <td width="50%" valign="top" scope="row">
            <table width="100%" class="formtable">
                <tr>
                  <td>
                    <strong><?php xl('HOMEBOUND REASON','e')?></strong>
                    <br />
                    <input type="checkbox" name="Evaluation_HR_Needs_assistance" id="Evaluation_HR_Needs_assistance" />
                    <?php xl('Needs assistance in all activities','e')?></td>
                </tr>
                <tr>
                  <td>
                    <input type="checkbox" name="Evaluation_HR_Unable_to_leave_home" id="Evaluation_HR_Unable_to_leave_home" />
                    <?php xl('Unable to leave home safely without assistance','e')?></td>
                </tr>
                <tr>
                  <td>
                    <input type="checkbox" name="Evaluation_HR_Medical_Restrictions" id="Evaluation_HR_Medical_Restrictions" />
                    <?php xl('Medical Restrictions in','e')?>
                    <input type="text" name="Evaluation_HR_Medical_Restrictions_In" style="width:270px"  id="Evaluation_HR_Medical_Restrictions_In" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="checkbox" name="Evaluation_HR_SOB_upon_exertion" id="Evaluation_HR_SOB_upon_exertion" />
                    <?php xl('SOB upon exertion','e')?>
                    <input type="checkbox" name="Evaluation_HR_Pain_with_Travel" id="Evaluation_HR_Pain_with_Travel" />
		<?php xl('Pain with Travel','e')?></td>
                </tr>
              </table>
          <td width="50%" valign="top">
            <table width="100%" border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
              <tr>
                <td>
                  <input type="checkbox" name="Evaluation_HR_Requires_assistance" id="Evaluation_HR_Requires_assistance" />
                  <?php xl('Requires assistance in mobility and ambulation','e')?></td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" name="Evaluation_HR_Arrhythmia" id="Evaluation_HR_Arrhythmia" />
                  <?php xl('Arrhythmia','e')?>
                  <input type="checkbox" name="Evaluation_HR_Bed_Bound" id="Evaluation_HR_Bed_Bound" />
		  <?php xl('Bed Bound','e')?>
	      <input type="checkbox" name="Evaluation_HR_Residual_Weakness" id="Evaluation_HR_Residual_Weakness" />
	    <?php xl('Residual Weakness','e')?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="Evaluation_HR_Confusion" id="Evaluation_HR_Confusion" />
		<?php xl('Confusion, unable to go out of home alone','e')?><br />
	  <input type="checkbox" name="Evaluation_HR_Multiple_Stairs_Home" id="Evaluation_HR_Multiple_Stairs_Home" />
	  <?php xl('Multiple stairs to enter/exit home','e')?></td>
              </tr>
              <tr>
                <td><?php xl('Other','e')?>
                  <input type="text" name="Evaluation_HR_Other" style="width:350px" id="Evaluation_HR_Other" /></td>
              </tr>
              </table>
          </td>
        </tr>
      </table>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
        <tr>
          <td align="center" scope="row"><strong><?php xl('MED DX/ Reason for PT intervention','e')?></strong></td>
          <td align="center">
<input type="text" id="Evaluation_Reason_for_intervention" name="Evaluation_Reason_for_intervention" style="width:100%;"/>
	  	  </td>
          <td align="center"><strong><?php xl('TREATMENT DX/Problem','e')?></strong></td>
          <td align="center">
<input type="text" id="Evaluation_TREATMENT_DX_PT_Problem" name="Evaluation_TREATMENT_DX_PT_Problem" style="width:100%;"/>	
</td>
        </tr>
      </table>
  </tr>
  <tr>

    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
	<tr><td><strong><?php xl('MEDICAL HISTORY AND PRIOR LEVEL OF FUNCTION','e')?>
      </strong></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>
        <td scope="row"><strong><?php xl('PERTINENT MEDICAL HISTORY','e')?>
          <input type="text" name="Evaluation_PERTINENT_MEDICAL_HISTORY" style="width:680px" id="Evaluation_PERTINENT_MEDICAL_HISTORY" />
        </strong></td>
      </tr>

      <tr>
        <td scope="row"><strong><?php xl('MEDICAL/FUNCTIONAL PRECAUTIONS','e')?>&nbsp;</strong>
          <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="None" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" />
          <?php xl('None','e')?>
  <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="WB Status" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" />
          <?php xl('WB Status','e')?> 
  <input type="text" name="Evaluation_MFP_WB_status" id="Evaluation_MFP_WB_status" /> 
          <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="Falls Risks" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" />
          <?php xl('Falls Risks','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="SOB" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" />
          <?php xl('SOB','e')?><br/><?php xl('Other','e')?>
          <strong>
            <input type="text" size="150px"  name="Evaluation_MFP_Other" id="Evaluation_MFP_Other" />
            <br />
            <?php xl('PRIOR LEVEL OF MOBILITY IN HOME','e')?>
            </strong>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Ambulated Independently" id="CheckboxGroup10_0" />
            <?php xl('Ambulated Independently','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Ambulated with assistive device" id="CheckboxGroup10_1" />
            <?php xl('Ambulated with assistive device','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Ambulated with assistance" id="CheckboxGroup10_2" />
            <?php xl('Ambulated with assistance','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Ambulates on stairs" id="CheckboxGroup10_3" />
            <?php xl('Ambulates on stairs','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Wheelchair bound" id="CheckboxGroup10_4" />
            <?php xl('Wheelchair bound','e')?>
        <br/>  
            <?php xl('Other','e')?>
            <strong>
              <input type="text" name="Evaluation_Prior_level_Mobility_Other" id="Evaluation_Prior_level_Mobility_Other"  style="width:92%" />
              </strong><br />
            <?php xl('# Stairs to Enter Front of House','e')?>
            <strong>
              <input type="text"  style="width:9%"  name="Evaluation_PLM_Stairs_Front_House" id="Evaluation_PLM_Stairs_Front_House" />
              </strong>&nbsp;
            <?php xl('# Stairs to Enter Back of House','e')?>
            <strong>
              <input type="text" style="width:9%" name="Evaluation_PLM_Stairs_Back_House" id="Evaluation_PLM_Stairs_Back_House" />
             </strong>&nbsp;<?php xl('# Stairs to Second Level','e')?>
            <strong>
              <input type="text"  style="width:9%"  name="Evaluation_PLM_Stairs_Second_Level" id="Evaluation_PLM_Stairs_Second_Level" />
              <br />
              <?php xl('PRIOR LEVEL OF MOBILITY IN COMMUNITY','e')?></strong>
	    <input type="checkbox" name="Evaluation_Prior_level_Mobility_Community" value="Independent" id="CheckboxGroup10_5" />
            <?php xl('Independent','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Community" value="With Assistance" id="CheckboxGroup10_6" />
            <?php xl('With Assistance','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Community" value="Unable" id="CheckboxGroup10_7" />
            <?php xl('Unable','e')?>
          <br />
      <strong>
	<?php xl('FAMILY/CAREGIVER SUPPORT','e')?></strong>
	<input type="checkbox" name="Evaluation_Family_Caregiver_Support" value="Yes" id="Evaluation_Family_Caregiver_Support" />
	<?php xl('Yes','e')?>
          
            <input type="checkbox" name="Evaluation_Family_Caregiver_Support" value="No" id="Evaluation_Family_Caregiver_Support" />
            <?php xl('No','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      
           <?php xl('Who','e')?> <strong>
              <input type="text" style="width:40%"  name="Evaluation_Family_Caregiver_Support_Who" id="Evaluation_Family_Caregiver_Support_Who" />
              </strong><br><?php xl('Previous # Visits into Community Weekly','e')?> <strong>
                <input type="text" name="Evaluation_FC_Visits_Community_Weekly" id="Evaluation_FC_Visits_Community_Weekly" />
                </strong><br />
            <?php xl('Additional Comments','e')?><strong>
              <input style="width:80%" type="text" name="Evaluation_FC_Additional_Comments" id="Evaluation_FC_Additional_Comments" />
            </strong></td>
      </tr>
    </table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong>
<?php xl('CURRENT MOBILITY STATUS','e')?><br /> <?php xl('Scale','e')?> </strong>
<?php xl('U=Unable*, Dep=Dependent, Max=needs 75-51% assist, Mod=needs 50-26%, Min=needs 25-1% assist, CG=constant contact guard, SBA=stand by assist, S=supervised, needs cues, Mod I=Independent with assistive devices, Independent=no assist required','e')?>
</td></tr></table></td></tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>
        <td width="15%" align="center" scope="row"><strong><?php xl('TASK','e')?></strong></td>
        <td width="10%" align="center"><strong><?php xl('STATUS','e')?></strong></td>
        <td width="30%" align="center"><strong><?php xl('TASK','e')?></strong></td>
        <td width="10%" align="center"><strong><?php xl('STATUS','e')?></strong></td>
        <td width="25%"><strong><?php xl('*COMMENTS','e')?></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('ROLLING RIGHT','e')?> </td>
        <td><strong><select id="Evaluation_CMS_ROLLING_RIGHT" name="Evaluation_CMS_ROLLING_RIGHT">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('SIT','e')?> <-> <?php xl('STAND','e')?></td>
        <td><strong><select id="Evaluation_CMS_SIT_STAND" name="Evaluation_CMS_SIT_STAND">
	<?php Mobility_status($GLOBALS['Selected']) ?></strong></td>
        <td rowspan="5" align="center">
	<textarea name="Evaluation_CMS_COMMENTS" style="width: 315px; height: 115px;" id="Evaluation_CMS_COMMENTS" cols="25" rows="5"></textarea></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('ROLLING LEFT','e')?></td>
        <td><strong><select id="Evaluation_CMS_ROLLING_LEFT" name="Evaluation_CMS_ROLLING_LEFT">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('BED/CHAIR TRANSFERS','e')?></td>
        <td><strong><select id="Evaluation_CMS_BED_CHAIR_TRANSFERS" name="Evaluation_CMS_BED_CHAIR_TRANSFERS">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('BRIDGING/SCOOT','e')?></td>
        <td><strong><select id="Evaluation_CMS_BRIDGING_SCOOT" name="Evaluation_CMS_BRIDGING_SCOOT">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('TOILET TRANSFERS','e')?></td>
        <td><strong><select id="Evaluation_CMS_TOILET_TRANSFERS" name="Evaluation_CMS_TOILET_TRANSFERS">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('SUPINE','e')?> <-><?php xl('SIT','e')?></td>
        <td><strong><select id="Evaluation_CMS_SUPINE_SIT" name="Evaluation_CMS_SUPINE_SIT">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('Other','e')?> <input type="text" style="width:80%"  id="Evaluation_CMS_Other_text" name="Evaluation_CMS_Other_text"></td>
        <td><strong><select id="Evaluation_CMS_Other" name="Evaluation_CMS_Other">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
      </tr>     
  </table>    
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('GAIT SKILLS','e')?>
        <input type="checkbox" name="Evaluation_GAIT_SKILLS" id="Evaluation_GAIT_SKILLS" />
        <?php xl('Not Applicable, Patient Does Not Ambulate','e')?>
      </strong></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('Assistance','e')?></strong>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Dep" id="Evaluation_GS_Assistance" />
          <?php xl('Dep','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Max Assist" id="Evaluation_GS_Assistance" />
          <?php xl('Max Assist','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Mod Assist" id="Evaluation_GS_Assistance" />
          <?php xl('Mod Assist','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Min Assist" id="Evaluation_GS_Assistance" />
          <?php xl('Min Assist','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="CGA" id="Evaluation_GS_Assistance" />
          <?php xl('CGA','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="SBA" id="Evaluation_GS_Assistance" />
          <?php xl('SBA','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Supervised" id="Evaluation_GS_Assistance" />
          <?php xl('Supervised','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Mod I" id="Evaluation_GS_Assistance" />
          <?php xl('Mod I','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Independent" id="Evaluation_GS_Assistance" />
          <?php xl('Independent','e')?>
        <br />
      <strong>  <?php xl('Distance/Time','e')?></strong> 

        <input type="text" id="Evaluation_GS_Distance_Time" name="Evaluation_GS_Distance_Time" />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <strong><?php xl('Surfaces','e')?></strong>
      
          <input type="checkbox" name="Evaluation_GS_Surfaces" value="Level" id="Evaluation_GS_Surfaces" />
          <?php xl('Level','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Surfaces" value="Uneven" id="Evaluation_GS_Surfaces" />
          <?php xl('Uneven','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Surfaces" value="Stairs" id="Evaluation_GS_Surfaces" />
          <?php xl('Stairs','e')?>
        <br />
       <strong><?php xl('Assistive Devices','e')?></strong>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="None" id="Evaluation_GS_Assistive_Devices" />
          <?php xl('None','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="SP Cane" id="Evaluation_GS_Assistive_Devices" />
          <?php xl('SP Cane','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="Quad Cane" id="Evaluation_GS_Assistive_Devices" />
          <?php xl('Quad Cane','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="Front-Wheel Walker" id="Evaluation_GS_Assistive_Devices" />
          <?php xl('Front-Wheel Walker','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="Four Wheeled Walker" id="Evaluation_GS_Assistive_Devices" />
          <?php xl('Four Wheeled Walker','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="Standard Walker" id="Evaluation_GS_Assistive_Devices" />
          <?php xl('Standard Walker','e')?>
       <br />
        <?php xl('Other','e')?>       
        <input type="text" style="width:93%"   name="Evaluation_GS_Assistive_Devices_Other" id="Evaluation_GS_Assistive_Devices_Other" />
        <br />
        <strong><?php xl('Gait Deviations','e')?></strong> <?php xl('(E.g. Posture, Stride Length, Cadence, Foot Placement, Weight Shift)','e')?>
 <br/>
       <input type="text" style="width:98%"  id="Evaluation_GS_Gait_Deviations" name="Evaluation_GS_Gait_Deviations" />
      </td></tr></table></td></tr>
      <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td>
	<strong><?php xl('WHEELCHAIR SKILLS','e')?> </strong>
      <input type="checkbox" name="Evaluation_WHEELCHAIR_SKILLS" id="Evaluation_WHEELCHAIR_SKILLS" />
      <?php xl('Not Applicable, Patient Ambulates','e')?>
 </strong></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td>
	<strong> <?php xl('Assistance','e')?> </strong>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Dep" id="Evaluation_WS_Assistance" />
        <?php xl('Dep','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Max Assist" id="Evaluation_WS_Assistance" />
        <?php xl('Max Assist','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Mod Assist" id="Evaluation_WS_Assistance" />
        <?php xl('Mod Assist','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Min Assist" id="Evaluation_WS_Assistance" />
        <?php xl('Min Assist','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="CGA" id="Evaluation_WS_Assistance" />
        <?php xl('CGA','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="SBA" id="Evaluation_WS_Assistance" />
        <?php xl('SBA','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Supervised" id="Evaluation_WS_Assistance" />
        <?php xl('Supervised','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Mod I" id="Evaluation_WS_Assistance" />
        <?php xl('Mod I','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Independent" id="Evaluation_WS_Assistance" />
        <?php xl('Independent','e')?>
      <br />
      <strong> <?php xl('Distance/Time','e')?></strong>
      <input type="text" id="Evaluation_WS_Distance_Time" name="Evaluation_WS_Distance_Time" />
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><?php xl('Surfaces','e')?></strong>
      
        <input type="checkbox" name="Evaluation_WS_Surfaces" value="Level" id="Evaluation_WS_Surfaces" />
        <?php xl('Level','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Surfaces" value="Uneven" id="Evaluation_WS_Surfaces" />
        <?php xl('Uneven','e')?>      
      <br>
        <?php xl('Other','e')?>
        <input type="text" style="width:35%"  id="Evaluation_WS_Surfaces_other" name="Evaluation_WS_Surfaces_other" />
        <br />
        <strong> <?php xl('Patient Can Remove Footrests','e')?></strong> 
      
        <input type="checkbox" name="Evaluation_WS_Remove_Footrests" value="Yes" id="Evaluation_WS_Remove_Footrests" />
         <?php xl('Yes','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Remove_Footrests" value="No" id="Evaluation_WS_Remove_Footrests" />
         <?php xl('No','e')?>            
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> <?php xl('Remove Armrests','e')?>
        </strong>
      
        <input type="checkbox" name="Evaluation_WS_Remove_Armrests" value="Yes" id="Evaluation_WS_Remove_Armrests" />
        <?php xl('Yes','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Remove_Armrests" value="No" id="Evaluation_WS_Remove_Armrests" />
        <?php xl('No','e')?>             
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('Reposition in W/C','e')?></strong>
      <input type="checkbox" name="Evaluation_WS_Reposition_WC" value="Yes" id="Evaluation_WS_Reposition_WC" />
        <?php xl('Yes','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Reposition_WC" value="No" id="Evaluation_WS_Reposition_WC" />
        <?php xl('No','e')?>  <br />
     <strong><?php xl('Posture/Alignment in Chair','e')?></strong> 
     
       <input type="checkbox" name="Evaluation_WS_Posture_Alignment_Chair" value="Normal" id="Evaluation_WS_Posture_Alignment_Chair" />
       <?php xl('Normal','e')?>
     
       <input type="checkbox" name="Evaluation_WS_Posture_Alignment_Chair" value="Kyphosis" id="Evaluation_WS_Posture_Alignment_Chair" />
      <?php xl('Kyphosis','e')?>
     <input type="checkbox" name="Evaluation_WS_Posture_Alignment_Chair" value="Lordosis" id="Evaluation_WS_Posture_Alignment_Chair" />
      <?php xl('Lordosis','e')?><br />
      <?php xl('Other','e')?>
    <input type="text" style="width:93%"  name="Evaluation_WS_Other" id="Evaluation_WS_Other" />
    </td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>
        <td><strong><?php xl('COGNITION','e')?></strong></td>
      </tr>
      <tr><td><input type="checkbox" name="Evaluation_COG_Alert_type" value="Alert" id="Evaluation_COG_Alert_type" />
      <?php xl('Alert','e')?>
	<input type="checkbox" name="Evaluation_COG_Alert_type" value="Not Alert" id="Evaluation_COG_Alert_type" />
	<?php xl('Not Alert','e')?> 
    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<strong><?php xl('Oriented to','e')?> </strong>
      <input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Person" id="Evaluation_COG_Oriented_Type" />
      <?php xl('Person','e')?>
      <input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Place" id="Evaluation_COG_Oriented_Type" />
      <?php xl('Place','e')?>
	<input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Date" id="Evaluation_COG_Oriented_Type" />
	<?php xl('Date','e')?>
	<input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Reason for Therapy" id="Evaluation_COG_Oriented_Type" />
      <?php xl('Reason for Therapy','e')?><br />
<strong><?php xl('Can Follow','e')?> </strong>
      <input type="checkbox" name="Evaluation_COG_Canfollow" value="1" id="Evaluation_COG_Canfollow" />
	<?php xl('1','e')?>
      <input type="checkbox" name="Evaluation_COG_Canfollow" value="2" id="Evaluation_COG_Canfollow" />
      <?php xl('2','e')?>
      <input type="checkbox" name="Evaluation_COG_Canfollow" value="3" id="Evaluation_COG_Canfollow" />
      <?php xl('3','e')?>    
     <?php xl('or more Step-Directions','e')?> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> <?php xl('Safety Awareness','e')?> </strong>
     <input type="checkbox" name="Evaluation_COG_Safety_Awareness" value="Good" id="Evaluation_COG_Safety_Awareness" /> 
     <?php xl('Good','e')?>
     <input type="checkbox" name="Evaluation_COG_Safety_Awareness" value="Fair" id="Evaluation_COG_Safety_Awareness" />
      <?php xl('Fair','e')?>
      <input type="checkbox" name="Evaluation_COG_Safety_Awareness" value="Poor" id="Evaluation_COG_Safety_Awareness" />
      <?php xl('Poor','e')?></td></tr></table></td>
  </tr>

<tr>
<td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
<tr><td colspan="8"><strong><?php xl('MISCELLANEOUS SKILLS','e')?></strong></td></tr>
<tr>
	
<td align="center" scope="row">&nbsp;</th>
<strong><?php xl('SKILL','e')?></strong>
<td align="center"><strong><?php xl('GOOD','e')?></strong></td>
<td align="center"><strong><?php xl('FAIR','e')?></strong></td>
<td align="center"><strong><?php xl('POOR','e')?></strong></td>
<td align="center"><strong><?php xl('SKILL','e')?></strong></td>
<td align="center"><strong><?php xl('GOOD','e')?></strong></td>
<td align="center"><strong><?php xl('FAIR','e')?></strong></td>
<td align="center"><strong><?php xl('POOR','e')?> </strong></td>
</tr>

<tr>
<td scope="row"><?php xl('ENDURANCE','e')?></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Endurance" id="Evaluation_Mis_skil_Endurance" value="Good"/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Endurance" id="Evaluation_Mis_skil_Endurance" value="Fair"/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Endurance" id="Evaluation_Mis_skil_Endurance" value="Poor"/></td>

<td><?php xl('HEARING','e')?></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Hearing" id="Evaluation_Mis_skil_Hearing" value="Good"/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Hearing" id="Evaluation_Mis_skil_Hearing" value="Fair"/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Hearing" id="Evaluation_Mis_skil_Hearing" value="Poor"/></td>
</tr>

<tr>
<td scope="row"><?php xl('COMMUNICATION','e')?></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Communication" id="Evaluation_Mis_skil_Communication" value="Good"/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Communication" id="Evaluation_Mis_skil_Communication" value="Fair"/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Communication" id="Evaluation_Mis_skil_Communication" value="Poor"/></td>

<td><?php xl('VISION','e')?></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Vision" id="Evaluation_Mis_skil_Vision" value="Good"/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Vision" id="Evaluation_Mis_skil_Vision" value="Fair"/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Vision" id="Evaluation_Mis_skil_Vision" value="Poor"/></td>
</tr>

</table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td>
    <strong><?php xl('CURRENT BALANCE SKILLS','e')?><br/> <?php xl('Scale','e')?></strong>
      <?php xl('N=Normal, G=Good, takes moderate challenges, F=Fair, maintain balance without contact, P=Poor maintain balance for 15 seconds or less, 0 no balance reaction','e')?>
   </td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
          <td align="center"><strong><?php xl('STATUS','e')?> </strong></td>
        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('STATUS','e')?></strong></td>
        </tr>
      <tr>
        <td scope="row"><?php xl('DYNAMIC SITTING BALANCE','e')?></td>
        <td><strong>
      <select id="Evaluation_CB_Skills_Dynamic_Sitting" name="Evaluation_CB_Skills_Dynamic_Sitting">
      <?php Balance_skills($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('DYNAMIC STANDING BALANCE','e')?></td>
        <td><strong><select id="Evaluation_CB_Skills_Dynamic_Standing" name="Evaluation_CB_Skills_Dynamic_Standing">
	  <?php Balance_skills($GLOBALS['Selected']) ?></select></strong></td>
        </tr>
      <tr>
        <td scope="row"><?php xl('STATIC SITTING BALANCE','e')?></td>
        <td><strong><select id="Evaluation_CB_Skills_Static_Sitting" name="Evaluation_CB_Skills_Static_Sitting">
	<?php Balance_skills($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('STATIC STANDING BALANCE','e')?></td>
        <td><strong><select id="Evaluation_CB_Skills_Static_Standing" name="Evaluation_CB_Skills_Static_Standing">
	 <?php Balance_skills($GLOBALS['Selected']) ?></select></strong></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%;"  border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
	<tr><td width="100%" ><strong><?php xl('MUSCLE STRENGTH/FUNCTIONAL ROM EVALUATION','e')?><br />
      <input type="checkbox" name="Evaluation_MS_ROM_All_Muscle_WFL" value="All Muscle Strength is WFL" id="Evaluation_MS_ROM_All_Muscle_WFL" />
      <?php xl('All Muscle Strength is WFL','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="Evaluation_MS_ROM_All_Muscle_WFL" value="All ROM is WFL" id="Evaluation_MS_ROM_All_Muscle_WFL" />
    <?php xl('All ROM is WFL','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="checkbox" name="Evaluation_MS_ROM_All_Muscle_WFL" value="other Problem" id="Evaluation_MS_ROM_All_Muscle_WFL" />
    <?php xl('The following problem areas are','e')?> &nbsp;
<input type="text" style="width:25%" name="Evaluation_MS_ROM_Following_Problem_areas" id="Evaluation_MS_ROM_Following_Problem_areas" />
    </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>
        <td align="center" scope="row"><strong><?php xl('PROBLEM AREA','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('STRENGTH','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('ROM','e')?></strong></td>
        <td colspan="3" align="center"><strong><?php xl('ROM TYPE','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('TONICITY','e')?></strong></td>
        <td rowspan="2" align="center"><strong><?php xl('FURTHER DESCRIPTION','e')?></strong></td>
      </tr>
      <tr>
        <td align="center" scope="row">&nbsp;</td>
        <td align="center"><strong><?php xl('R','e')?></strong></td>
        <td align="center"><strong><?php xl('L','e')?></strong></td>
        <td align="center"><strong><?php xl('R','e')?></strong></td>
        <td align="center"><strong><?php xl('L','e')?></strong></td>
        <td align="center"><strong><?php xl('P','e')?></strong></td>
        <td align="center"><strong><?php xl('AA','e')?></strong></td>
        <td align="center"><strong><?php xl('A','e')?></strong></td>
        <td align="center"><strong><?php xl('Hyper','e')?></strong></td>
        <td align="center"><strong><?php xl('Hypo','e')?></strong></td>
        </tr>
      <tr>
        <td align="center" scope="row">
      <input type="text" name="Evaluation_MS_ROM_Problemarea_text" id="Evaluation_MS_ROM_Problemarea_text" size="35px" /></td>

        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right" id="Evaluation_MS_ROM_STRENGTH_Right" /> 
          <?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left" id="Evaluation_MS_ROM_STRENGTH_Left" />
	<?php xl('/ 5','e')?></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM" id="Evaluation_MS_ROM_ROM" value="Right"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM" id="Evaluation_MS_ROM_ROM" value="Left"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_ROM_Type" value="P"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_ROM_Type" value="AA"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_ROM_Type" value="A"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity" id="Evaluation_MS_ROM_Tonicity" value="Hyper"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity" id="Evaluation_MS_ROM_Tonicity" value="Hypo"/></td>
        <td align="center" rowspan="4">
        <textarea name="Evaluation_MS_ROM_Further_description" id="Evaluation_MS_ROM_Further_description" cols="35" rows="10"></textarea>
        </tr>
      <tr>
        <td align="center" scope="row"><input type="text" name="Evaluation_MS_ROM_Problemarea_text1" id="Evaluation_MS_ROM_Problemarea_text1" size="35px"/></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right1" id="Evaluation_MS_ROM_STRENGTH_Right1" />
	<?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left1" id="Evaluation_MS_ROM_STRENGTH_Left1" />
	<?php xl('/ 5','e')?></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM1" id="Evaluation_MS_ROM_ROM1" value="Right"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM1" id="Evaluation_MS_ROM_ROM1" value="Left"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="P"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="AA"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="A"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity1" id="Evaluation_MS_ROM_Tonicity1" value="Hyper"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity1" id="Evaluation_MS_ROM_Tonicity1" value="Hypo"/></td>
        </tr>
      <tr>
        <td align="center" scope="row"><input type="text" name="Evaluation_MS_ROM_Problemarea_text2" id="Evaluation_MS_ROM_Problemarea_text2" size="35px"/></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right2" id="Evaluation_MS_ROM_STRENGTH_Right2" />
      <?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left2" id="Evaluation_MS_ROM_STRENGTH_Left2" />
	<?php xl('/ 5','e')?></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM2" id="Evaluation_MS_ROM_ROM2" value="Right"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM2" id="Evaluation_MS_ROM_ROM2" value="Left"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="P"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="AA"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="A"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity2" id="Evaluation_MS_ROM_Tonicity2" value="Hyper"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity2" id="Evaluation_MS_ROM_Tonicity2" value="Hypo"/></td>
        </tr>
      <tr>
        <td align="center" scope="row">
	<input type="text" name="Evaluation_MS_ROM_Problemarea_text3" id="Evaluation_MS_ROM_Problemarea_text3" size="35px"/></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right3" id="Evaluation_MS_ROM_STRENGTH_Right3" />
	<?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left3" id="Evaluation_MS_ROM_STRENGTH_Left3" />
	<?php xl('/ 5','e')?></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM3" id="Evaluation_MS_ROM_ROM3" value="Right"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM3" id="Evaluation_MS_ROM_ROM3" value="Left"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="P"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="AA"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="A"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity3" id="Evaluation_MS_ROM_Tonicity3" value="Hyper"/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity3" id="Evaluation_MS_ROM_Tonicity3" value="Hypo"/></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%"  border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('Comments','e')?>
        <input type="text" style="width:85%"  name="Evaluation_MS_ROM_Comments" id="Evaluation_MS_ROM_Comments" />
      </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><strong><?php xl('ENVIRONMENTAL BARRIERS/SAFETY ISSUES (Check all that apply)','e')?></strong></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>

        <td scope="row">
	<input type="checkbox" name="Evaluation_EnvBar_No_barriers" id="Evaluation_EnvBar_No_barriers" />
          <?php xl('No environmental barriers in home','e')?>
            <input type="checkbox" name="Evaluation_EnvBar_No_Safety_Issues" id="Evaluation_EnvBar_No_Safety_Issues" />
            <?php xl('No safety issues in home','e')?>
            <input type="checkbox" name="Evaluation_EnvBar_Bedroom_On_Second" id="Evaluation_EnvBar_Bedroom_On_Second" />
            <?php xl('Bedroom on second floor','e')?> 
            <input type="checkbox" name="Evaluation_EnvBar_No_Inadequate_grab" id="Evaluation_EnvBar_No_Inadequate_grab" />
            <?php xl('No or inadequate grab bars in bathroom/shower','e')?>
            <input type="checkbox" name="Evaluation_EnvBar_Throw_Rugs" id="Evaluation_EnvBar_Throw_Rugs	" />
	    <?php xl('Throw rugs in rooms','e')?>
	<input type="checkbox" name="Evaluation_EnvBar_No_Inadequate_smoke" id="Evaluation_EnvBar_No_Inadequate_smoke" />
	    <?php xl('No or inadequate smoke alarms','e')?>          
            <input type="checkbox" name="Evaluation_EnvBar_No_Emergency_Numbers" id="Evaluation_EnvBar_No_Emergency_Numbers" />
            <?php xl('No emergency numbers available','e')?>         
            <input type="checkbox" name="Evaluation_EnvBar_Lighting_Not_Adequate" id="Evaluation_EnvBar_Lighting_Not_Adequate" />
            
	    <?php xl('Lighting is not adequate for safe mobility in home','e')?>
	    <input type="checkbox" name="Evaluation_EnvBar_No_Handrails" id="Evaluation_EnvBar_No_Handrails" />
	    <?php xl('No handrails for stairs','e')?>
	    <input type="checkbox" name="Evaluation_EnvBar_Stairs_Disrepair" id="Evaluation_EnvBar_Stairs_Disrepair" />
	    <?php xl('Stairs are in disrepair','e')?>
	    <input type="checkbox" name="Evaluation_EnvBar_Fire_Extinguishers" id="Evaluation_EnvBar_Fire_Extinguishers" />
	    <?php xl('Fire extinguishers are not available','e')?> 
<br/><?php xl('Other','e')?> 
	    <input type="text" style="width:90%" name="Evaluation_EnvBar_Other" id="Evaluation_EnvBar_Other" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td>
    <strong><?php xl('SUMMARY','e')?></strong></td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
	<tr><td>
      <input type="checkbox" name="Evaluation_Summary_PT_Evaluation_Only" id="Evaluation_Summary_PT_Evaluation_Only" />
    <?php xl('PT Evaluation only. No further indications of service','e')?>
        <br />
        <input type="checkbox" name="Evaluation_Summary_Need_physician_Orders" id="Evaluation_Summary_Need_physician_Orders" />
    <?php xl('Need physician orders for PT services with specific treatments, frequency, and duration. See OT Care Plan and/or 485','e')?><br />
    <input type="checkbox" name="Evaluation_Summary_Received_Physician_Orders" id="Evaluation_Summary_Received_Physician_Orders" />
    <?php xl('Received physician orders for PT treatment and approximate next visit date will be','e')?>
    <input type="text" style="width:10%" name="Evaluation_approximate_next_visit_date" id="Evaluation_approximate_next_visit_date"   title='<?php xl('Date','e'); ?>'  onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_onset_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
<script LANGUAGE="JavaScript"> 
Calendar.setup({inputField:"Evaluation_approximate_next_visit_date", ifFormat:"%Y-%m-%d", button:"img_onset_date"});
   </script>

</td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('PT Care Plan and Evaluation was communicated to and agreed upon by','e')?></strong>
        <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Patient" id="Evaluation_PT_Evaulation_Communicated_Agreed" />
    <?php xl('Patient','e')?>
  <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Physician" id="Evaluation_PT_Evaulation_Communicated_Agreed" />
    <?php xl('Physician','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="PT/ST" id="Evaluation_PT_Evaulation_Communicated_Agreed" />
      <?php xl('PT/ST','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="COTA" id="Evaluation_PT_Evaulation_Communicated_Agreed" />
    <?php xl('PTA','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Skilled Nursing" id="Evaluation_PT_Evaulation_Communicated_Agreed" />
    <?php xl('Skilled Nursing','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Caregiver/Family" id="Evaluation_PT_Evaulation_Communicated_Agreed" />
    <?php xl('Caregiver/Family','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Case Manager" id="Evaluation_PT_Evaulation_Communicated_Agreed" />
    <?php xl('Case Manager Others','e')?>
    <input type="text" size="77px" name="Evaluation_PT_Evaulation_Communicated_other" id="Evaluation_PT_Evaulation_Communicated_other" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('ADDITIONAL SERVICES PROVIDED','e')?>
      </strong>
        <input type="checkbox" name="Evaluation_ASP_Home_Exercise_Initiated" id="Evaluation_ASP_Home_Exercise_Initiated" />
    <?php xl('Home Exercise Program Initiated','e')?>
    <input type="checkbox" name="Evaluation_ASP_Falls_Management_Discussed" id="Evaluation_ASP_Falls_Management_Discussed" />
    <?php xl('Falls Management Discussed','e')?>
    <input type="checkbox" name="Evaluation_ASP_Safety_Issues_Discussed" id="Evaluation_ASP_Safety_Issues_Discussed" />
    <?php xl('Recommendations for Safety Issues Discussed','e')?>
    <input type="checkbox" name="Evaluation_ASP_Treatment_For" id="Evaluation_ASP_Treatment_For" />
    <?php xl('Treatment for','e')?>
      <input type="text" size="88px" name="Evaluation_ASP_Treatment_For_text" id="Evaluation_ASP_Treatment_For_text" /> 
       <?php xl('Initiated','e')?>
<br/><?php xl('Other','e')?>
      <input type="text" style="width:92%" name="Evaluation_ASP_Other" id="Evaluation_ASP_Other" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('Skilled PT is Reasonable and Necessary to','e')?></strong>
            <br />
            <input type="checkbox" name="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" id="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" 
value="Return to Prior Level"/>
    <?php xl('Return','e')?> 
       <?php xl('Return Patient to Their Prior Level of Function','e')?>
    <input type="checkbox" name="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" id="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" 
value="Teach Patient"/>
    <?php xl('Teach patient compensatory techniques for mobility','e')?>
  <input type="checkbox" name="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" id="Evaluation_Skilled_PT_Reasonable_And_Necessary_To"  
value="Train Patient New Skills"/>
    <?php xl('Train patient in learning new skills','e')?>
<br/><?php xl('Other','e')?>
    <input type="text" style="width:92%" name="Evaluation_Skilled_PT_Other" id="Evaluation_Skilled_PT_Other" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong>
    <?php xl('ADDITIONAL COMMENTS','e')?>
      <input type="text" style="width:76%" name="Evaluation_Additional_Comments" id="Evaluation_Additional_Comments" />
    </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>

        <td width="50%" scope="row"><strong><?php xl('Therapist Who Developed POC','e')?></strong>
    <?php xl('(Name and Title)','e')?></td>
        <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td>
      </tr>
    </table></td>
  </tr>
</table>
<a href="javascript:top.restoreSession();document.evaluation.submit();" class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>
</body>
</html>
