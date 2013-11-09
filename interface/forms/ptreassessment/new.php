<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: reassessment");
?>

<html>
<head>
<title>PHYSICAL THERAPY REASSESSMENT</title>
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
	    	med_icd9.innerHTML= result['res'];
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/ptreassessment/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>
 
<script>
function requiredCheck() {
    var time_in = document.getElementById('Reassessment_Time_In').value;
    var time_out = document.getElementById('Reassessment_Time_Out').value;
	var date = document.getElementById('Reassessment_date').value;
    
	var isSelected = function() {
    var visit_checker = document.reassessment.Reassessment_visit_type;

    for(var i=0; i<visit_checker.length; i++) {
        if( visit_checker[i].checked ) {
            return true;
        }
    }
    return false;
	};

	if(!isSelected()) {
		alert("Please select a 13th visit, 19th visit, or other visit before submitting.");
		return false;
	}   
            
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
		action="<?php echo $rootdir;?>/forms/ptreassessment/save.php?mode=new" name="reassessment">
		<h3 align="center"><?php xl('PHYSICAL THERAPY REASSESSMENT','e'); ?>
		<br>
		<label>
        <input type="radio" name="Reassessment_visit_type" value="13th Visit" id="Reassessment_visit_type" />
		<?php xl('13th Visit','e')?></label><label>
        <input type="radio" name="Reassessment_visit_type" value="19th Visit" id="Reassessment_visit_type" />
        <?php xl('19th Visit','e')?></label><label>
        <input type="radio" name="Reassessment_visit_type" value="Other Visit" id="Reassessment_visit_type" />
        <?php xl('Other Visit','e')?></label></h3>
<table width="100%"  align="center" border="1" cellpadding="0px" cellspacing="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="0px" cellspacing="0px" class="formtable">
      <tr>

        <td width="10%" align="center" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
        <td width="15%" align="center" ><input type="text"
					id="patient_name" value="<?php patientName()?>"
					readonly/></td>
        <td width="5%" align="center"><strong><?php xl('MR#','e')?></strong></td>
        <td width="10%" align="center" class="bold"><input
					type="text" style="width:100%" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" readonly /></td>
<td width="5%"><strong><?php xl('Time In','e');?></strong></td>
    <td width="10%"><select name="Reassessment_Time_In" id="Reassessment_Time_In"><?php timeDropDown($GLOBALS['Selected'])?></select></td>
    <td width="5%"><strong><?php xl('Time Out','e');?></strong> <br /></td>
    <td width="10%"><select name="Reassessment_Time_Out" id="Reassessment_Time_Out"><?php timeDropDown($GLOBALS['Selected'])?></select></td>

<td width="5%" align="center"><strong><?php xl('Encounter Date','e')?></strong></td>

        <td width="25%" align="center">
        <input type='text' size='10' name='Reassessment_date' id='Reassessment_date' 
					title='<?php xl('Encounter Date','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"Reassessment_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script></td>
       </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
<strong><?php xl('Vital Signs','e')?></strong><br>
<?php xl('Pulse','e')?>
  <label for="pulse"></label>
  <input type="text"  size="3px" name="Reassessment_Pulse" id="Reassessment_Pulse" />
  <label>
    <input type="checkbox" name="Reassessment_Pulse_State" value="Regular" id="Reassessment_Pulse_State" />
    <?php xl('Regular','e')?></label>
  <label>
    <input type="checkbox" name="Reassessment_Pulse_State" value="Irregular" id="Reassessment_Pulse_State" />
    <?php xl('Irregular','e')?></label>
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
     <?php xl('Temperature','e')?>
     <input size="3px" type="text" name="Reassessment_Temperature" id="Reassessment_Temperature" />

     <label>
       <input type="checkbox" name="Reassessment_Temperature_type" value="Oral" id="Reassessment_Temperature_type" />
       <?php xl('Oral','e')?></label>
     <label>
       <input type="checkbox" name="Reassessment_Temperature_type" value="Temporal" id="Reassessment_Temperature_type" />
       <?php xl('Temporal','e')?></label>
&nbsp;<?php xl('Other','e')?>
 <input type="text" size="10px" name="Reassessment_VS_other" id="Reassessment_VS_other" />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Respirations','e')?>
<input type="text" size="3px" name="Reassessment_VS_Respirations" id="Reassessment_VS_Respirations" />
<br />
<?php xl('Blood Pressure Systolic','e')?>
<input type="text" size="3px" name="Reassessment_VS_BP_Systolic" id="Reassessment_VS_BP_Systolic" />
/
<label>
  <input type="text" size="3px" name="Reassessment_VS_BP_Diastolic" id="Reassessment_VS_BP_Diastolic" />
    <?php xl('Diastolic','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_side" value="Right" id="right" />

  <?php xl('Right','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_side" value="Left" id="left" />
  <?php xl('Left','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Sitting" id="sitting" />
  <?php xl('Sitting','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Standing " id="standing" />

  <?php xl('Standing','e')?> </label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Lying" id="lying" /></label><label>
 <?php xl('Lying','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('*O','e')?>
<sub><?php xl('2','e')?></sub> <?php xl('Sat','e')?>

  <input type="text" size="3px" name="Reassessment_VS_Sat" id="physician" />
</label>
<?php xl('*Physician ordered','e')?></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>

<strong><?php xl('Pain','e')?></strong>
  <input type="checkbox" name="Reassessment_VS_Pain" value="No Pain" id="Reassessment_VS_Pain" />
<?php xl('No Pain','e')?>
<input type="checkbox" name="Reassessment_VS_Pain" value="Pain limits functional ability" id="Reassessment_VS_Pain" />
<?php xl('Pain limits functional ability','e')?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Intensity','e')?>
<input type="text" size="9px" name="Reassessment_VS_Pain_Intensity" id="Reassessment_VS_Pain_Intensity" />
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="Improve" id="Reassessment_VS_Pain_Intensity_type" />
<?php xl('Improve','e')?>
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="Worse" id="Reassessment_VS_Pain_Intensity_type" />
<?php xl('Worse','e')?>
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="No Change" id="Reassessment_VS_Pain_Intensity_type" />
<?php xl('No Change','e')?></td>
</tr>
<tr>
<td><strong>
<?php xl('Please Note Contact MD if Vital Signs are Pulse <56 or >120 Temperature <56 or >101 Respirations <10 or >30
SBP <80 or >190 DBP <50 or >100 Pain Significantly Impacts patients ability to participate. O2 Sat <90% after rest','e')?>
</strong></td>
</tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" class="formtable">
      <tr>
        <td width="50%" valign="top" scope="row"><strong><?php xl('HOMEBOUND REASON','e')?><br />
        </strong>
          <input type="checkbox" name="Reassessment_HR_Needs_assistance" id="Reassessment_HR_Needs_assistance" />
<?php xl('Needs assistance in all activities','e')?><br />
<input type="checkbox" name="Reassessment_HR_Unable_to_leave_home" id="Reassessment_HR_Unable_to_leave_home" />
<?php xl('Unable to leave home safely unassisted','e')?><br />

<input type="checkbox" name="Reassessment_HR_Medical_Restrictions" id="Reassessment_HR_Medical_Restrictions" />
<?php xl('Medical Restrictions in','e')?> <input type="text" style="width:58%" name="Reassessment_HR_Medical_Restrictions_In" id="Reassessment_HR_Medical_Restrictions_In" />
<br />
<input type="checkbox" name="Reassessment_HR_SOB_upon_exertion" id="Reassessment_HR_SOB_upon_exertion" />
<?php xl('SOB upon exertion','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_HR_Pain_with_Travel" id="Reassessment_HR_Pain_with_Travel" />
<?php xl('Pain with Travel','e')?></td>
        <td width="50%" valign="top">
 <input type="checkbox" name="Reassessment_HR_Requires_assistance" id="Reassessment_HR_Requires_assistance" />
<?php xl('Requires assistance in mobility and ambulation','e')?>
  <br />
  <input type="checkbox" name="Reassessment_HR_Arrhythmia" id="Reassessment_HR_Arrhythmia" />
<?php xl('Arrhythmia','e')?>
<input type="checkbox" name="Reassessment_HR_Bed_Bound" id="Reassessment_HR_Bed_Bound" />

<?php xl('Bed Bound','e')?>
<input type="checkbox" name="Reassessment_HR_Residual_Weakness" id="Reassessment_HR_Residual_Weakness" />
<?php xl('Residual Weakness','e')?>
<br />
<input type="checkbox" name="Reassessment_HR_Confusion"  id="Reassessment_HR_Confusion" />
<?php xl('Confusion, unable to go out of home alone','e')?><br />
<input type="checkbox" name="Reassessment_HR_Multiple_stairs_enter_exit_home"  id="Reassessment_HR_Multiple_stairs_enter_exit_home" />
<?php xl('Multiple stairs to enter/exit home','e')?><br />
<?php xl('Other','e')?>&nbsp;
<input type="text" style="width:80%"  name="Reassessment_HR_Other" id="Reassessment_HR_Other" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>

    <td scope="row" style="padding-left:8px; padding-right:8px; padding-bottom:8px;">
    <strong><?php xl('TREATMENT DX/Problem','e')?></strong> 
<input type="text" id="Reassessment_TREATMENT_DX_Problem" name="Reassessment_TREATMENT_DX_Problem" style="width:100%;"/>
</td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
    <strong><?php xl('MOBILITY REASSESSMENT','e')?></strong><br />
    <strong><?php xl('Scale','e')?>  </strong>
    <?php xl('U=Unable*, Dep=Dependent, Max=needs 75-51% assist, Mod=needs 50-26%, Min=needs 25-1% assist, CG=constant  contact guard, SBA=stand by assist, S=supervised, needs cues, Mod I=Independent with assistive devices, Independent=no assist required.','e')?>
    </strong></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="2px" class="formtable">
      <tr>
        <td width="12%" align="center" scope="row"><strong><?php xl('Mobility Skills','e')?></strong></td>
        <td width="12%" align="center"><strong><?php xl('Initial','e')?> </strong><strong><?php xl('Status','e')?></strong></td>
        <td width="12%" align="center"><strong><?php xl('Current Status','e')?></strong></td>
        <td width="64%" align="center"><strong><?php xl('Describe progress related to mobility skills','e')?></strong><br />
          </td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Rolling','e')?></td>
        <td align="center"><strong>
        <select name="Reassessment_ADL_Rolling_Initial_Status" id="Reassessment_ADL_Rolling_Initial_Status">
       <?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>

        <td align="center"><strong>
        <select name="Reassessment_ADL_Rolling_Current_Status" id="Reassessment_ADL_Rolling_Current_Status">
        <?php Mobility_status($GLOBALS['Selected'])	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Rolling_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Rolling_Describe_Mobility_Skills" />
<?php xl('N/A','e')?> &nbsp;
  <input type="checkbox" name="Reassessment_ADL_Rolling_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Rolling_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Rolling_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Rolling_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Supine <-> Sit','e')?></td>

        <td align="center"><strong><select name="Reassessment_ADL_Supine_Sit_Initial_Status" id="Reassessment_ADL_Supine_Sit_Initial_Status">
<?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Supine_Sit_Current_Status" id="Reassessment_ADL_Supine_Sit_Current_Status">
<?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>

        <td scope="row"><?php xl('Sit <->Stand','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Sit_Stand_Initial_Status" id="Reassessment_ADL_Sit_Stand_Initial_Status">
<?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Sit_Stand_Current_Status" id="Reassessment_ADL_Sit_Stand_Current_Status">
<?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>

      </tr>
      <tr>
        <td scope="row"><?php xl('Transfers','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Transfers_Initial_Status" id="Reassessment_ADL_Transfers_Initial_Status">
<?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Transfers_Current_Status" id="Reassessment_ADL_Transfers_Current_Status">
<?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Transfers_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Transfers_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Transfers_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Transfers_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Transfers_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Transfers_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Fall Recovery','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Fall_Recovery_Initial_Status" id="Reassessment_ADL_Fall_Recovery_Initial_Status">
<?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Fall_Recovery_Current_Status" id="Reassessment_ADL_Fall_Recovery_Current_Status">
<?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>

        <td><input type="checkbox" name="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Gait Assistance','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Gait_Assistance_Initial_Status" id="Reassessment_ADL_Gait_Assistance_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>

        <td align="center"><strong><select name="Reassessment_ADL_Gait_Assistance_Current_Status" id="Reassessment_ADL_Gait_Assistance_Current_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('W/C Assistance','e')?></td>

        <td align="center"><strong><select name="Reassessment_ADL_WC_Assistance_Initial_Status" id="Reassessment_ADL_WC_Assistance_Initial_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_WC_Assistance_Current_Status" id="Reassessment_ADL_WC_Assistance_Current_Status"><?php Mobility_status($GLOBALS['Selected'])?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" />
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" />
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" />
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>         
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>

<input type="checkbox" name="Reassessment_Mobility_Reassessment_NA" id="Reassessment_Mobility_Reassessment_NA" />
<strong><?php xl('N/A','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Assistive Devices','e')?></strong>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="None" id="Reassessment_Assistive_Devices" />
<?php xl('None','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Cane" id="Reassessment_Assistive_Devices" />
<?php xl('Cane','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Quad Cane" id="Reassessment_Assistive_Devices" />
<?php xl('Quad Cane','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Front-Wheel Walker" id="Reassessment_Assistive_Devices" />
<?php xl('Front-Wheel Walker','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Four Wheeled Walker" id="Reassessment_Assistive_Devices" />
<?php xl('Four Wheeled Walker','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Standard Walker" id="Reassessment_Assistive_Devices" />
<?php xl('Standard Walker','e')?> <br/>
<?php xl('Other','e')?>
<input type="text" style="width:92%"  name="Reassessment_Assistive_Devices_Other" id="Reassessment_Assistive_Devices_Other" /> <strong><br />
<?php xl('Timed Up and Go Score','e')?></strong>
<input type="text" name="Reassessment_Timed_Up_Go_Score" id="Reassessment_Timed_Up_Go_Score" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('Interpretation','e')?></strong> 
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="No Fall Risk" id="Reassessment_Interpretation_Risk_Types" />
<strong><?php xl('Independent-No Fall Risk (','e')?> &lt;<?php xl('11 seconds)','e')?> </strong>
<br />
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="Minimal Fall Risk" id="Reassessment_Interpretation_Risk_Types" />
<strong><?php xl('Minimal Fall Risk (11- 13 seconds)','e')?> </strong>

<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="Moderate Fall Risk" id="Reassessment_Interpretation_Risk_Types" />
<strong><?php xl('Moderate Fall Risk (13.5-19 seconds)','e')?> </strong>
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="High Risk for Falls" id="Reassessment_Interpretation_Risk_Types" />
<strong><?php xl('High Risk for Falls(','e')?> &gt;<?php xl('19 seconds)','e')?></strong><br />
<strong><?php xl('Other Tests/Scores/Interpretations','e')?></strong> 
<input type="text" name="Reassessment_Other_Interpretations" style="width:67%"  id="Reassessment_Other_Interpretations" />
<br /> 
<input type="checkbox" name="Reassessment_Interpretation_NA" value="N/A" id="Reassessment_Interpretation_NA" /><strong>
<?php xl('N/A','e')?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Patient/Caregiver Continues to Have the Following Problems Achieving Goals with Mobility','e')?></strong>
<input type="text" name="Reassessment_Problems_Achieving_Goals" style="width:96%" id="Reassessment_Problems_Achieving_Goals" /></td></tr></table></td>
 
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
    <strong><?php xl('MISCELLANEOUS SKILLS','e')?></strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1"  cellspacing="0px" cellpadding="2px" class="formtable">

      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Initial','e')?></strong></td>
        <td align="center"><strong><?php xl('Current','e')?></strong></td> 
      
        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Initial','e')?></strong></td>
        <td align="center"><strong><?php xl('Current','e')?></strong></td>
       </tr>
      <tr>
        <td align="left" scope="row"><?php xl('ENDURANCE','e')?></td>
        <td align="center"><input type="text" size="10" name="Reassessment_MS_ENDURANCE_Initial" id="Reassessment_MS_ENDURANCE_Initial" /></td>
        <td align="center"><input type="text" size="10" name="Reassessment_MS_ENDURANCE_Current" id="Reassessment_MS_ENDURANCE_Current"/></td>
       
        <td align="left"><?php xl('SITTING BALANCE S/D','e')?></td>
        <td align="center">
	<input type="text" size="5"  name="Reassessment_MS_SITTING_BALANCE_Initial_S" id="Reassessment_MS_SITTING_BALANCE_Initial_S" />
	<input type="text" size="5"  name="Reassessment_MS_SITTING_BALANCE_Initial_D" id="Reassessment_MS_SITTING_BALANCE_Initial_D" /></td>
        <td align="center">
	<input type="text" size="5" name="Reassessment_MS_SITTING_BALANCE_Current_S" id="Reassessment_MS_SITTING_BALANCE_Current_S" />
	<input type="text" size="5" name="Reassessment_MS_SITTING_BALANCE_Current_D" id="Reassessment_MS_SITTING_BALANCE_Current_D" /></td>
        </tr>
       <tr>
        <td align="left" scope="row"><?php xl('SAFETY AWARENESS','e')?></td>
        <td align="center"><input type="text" size="10" name="Reassessment_MS_SAFETY_AWARENESS_Initial" id="Reassessment_MS_SAFETY_AWARENESS_Initial" /></td>
        <td align="center"><input type="text" size="10" name="Reassessment_MS_SAFETY_AWARENESS_Current" id="Reassessment_MS_SAFETY_AWARENESS_Current"/></td>
       
        <td align="left"><?php xl('STANDING BALANCE S/D','e')?></td>
        <td align="center">
	<input type="text" size="5"  name="Reassessment_MS_STANDING_BALANCE_Initial_S" id="Reassessment_MS_SITTING_BALANCE_Initial_S" />
	<input type="text" size="5"  name="Reassessment_MS_STANDING_BALANCE_Initial_D" id="Reassessment_MS_SITTING_BALANCE_Initial_D" /></td>
        <td align="center">
	<input type="text" size="5" name="Reassessment_MS_STANDING_BALANCE_Current_S" id="Reassessment_MS_SITTING_BALANCE_Current_S" />
	<input type="text" size="5" name="Reassessment_MS_STANDING_BALANCE_Current_D" id="Reassessment_MS_SITTING_BALANCE_Current_D" /></td>
        </tr>
         </table></td>

  </tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<input type="checkbox" name="Reassessment_Miscellaneous_NA" id="Reassessment_Miscellaneous_NA" value="N/A"/>
    <label><strong>
    <?php xl('N/A','e')?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   
     
<input type="checkbox" name="Reassessment_Miscellaneous_NA" id="Reassessment_Problems_Achieving_Goals_With" value="Endurance"/>
 <label><?php xl('Endurance','e')?></label>
<br/> 
<?php xl('Patient/Caregiver Continues to Have the Following Problems Achieving Goals with','e')?>
<br/>    
      <input type="checkbox" name="Reassessment_Problems_Achieving_Goals_With" id="Reassessment_Problems_Achieving_Goals_With" value="Safety Awarness"/>
 <label><?php xl('Safety Awareness','e')?></label>
      
      <input type="checkbox" name="Reassessment_Problems_Achieving_Goals_With" id="Reassessment_Problems_Achieving_Goals_With" value="Balance"/>
<label><?php xl('Balance','e')?></label>
      <input type="text" name="Reassessment_Problems_Achieving_Goals_With_Notes" style="width:70%;" id="Reassessment_Problems_Achieving_Goals_With_Notes" />
    </strong></label></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<strong><?php xl('MUSCLE STRENGTH/FUNCTIONAL ROM EVALUATION','e')?><br />
      <input type="checkbox" name="Reassessment_MS_ROM_All_Muscle_WFL" value="All Muscle Strength is WFL" id="Reassessment_MS_ROM_All_Muscle_WFL" />
<?php xl('All Muscle Strength is WFL','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_MS_ROM_All_Muscle_WFL" value="All ROM is WFL" id="Reassessment_MS_ROM_All_Muscle_WFL" />
<?php xl('All ROM is WFL','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_MS_ROM_All_Muscle_WFL" value="other Problem" id="Reassessment_MS_ROM_All_Muscle_WFL" />
<?php xl('The following problem areas are','e')?></strong>
 <input type="text" name="Reassessment_MS_ROM_Following_Problem_areas_Notes" style="width:100%"  id="Reassessment_MS_ROM_Following_Problem_areas_Notes" /></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="2px" class="formtable">
      <tr>
        <td rowspan="2" align="center" scope="row"><strong><?php xl('INITIAL  PROBLEM  AREA(S)','e')?></strong></td>
        
        <td colspan="2" align="center"><strong><?php xl('STRENGTH','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('ROM','e')?></strong></td>
        <td colspan="3" align="center"><strong><?php xl('ROM TYPE','e')?></strong></td>

        <td colspan="2" align="center"><strong><?php xl('TONICITY','e')?></strong></td>
         <td rowspan="2" align="center"><strong><?php xl('FURTHER DESCRIPTION','e')?></strong></td>
      </tr>
      <tr>
        <td align="center"><?php xl('R','e')?></td>
        <td align="center"><?php xl('L','e')?></td>
        <td align="center"><?php xl('R','e')?></td>

        <td align="center"><?php xl('L','e')?></td>
        <td align="center"><?php xl('P','e')?></td>
        <td align="center"><?php xl('AA','e')?></td>
        <td align="center"><?php xl('A','e')?></td>
        <td align="center"><strong><?php xl('Hyper','e')?></strong></td>
        <td align="center"><strong><?php xl('Hypo','e')?></strong></td>

        </tr>
</strong></td>      <tr>
        <td align="center" scope="row"><strong>
          <input type="text" name="Reassessment_MS_ROM_Problemarea_text" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text" />
        </strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right" />
        <?php xl('/5','e')?></strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left" />
<?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM" id="Reassessment_MS_ROM_ROM" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM" id="Reassessment_MS_ROM_ROM" value="Left"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" value="A"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity" id="Reassessment_MS_ROM_Tonicity" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity" id="Reassessment_MS_ROM_Tonicity" value="Hypo"/></td>
        <td align="center" rowspan="3" ><strong>
          <textarea name="Reassessment_MS_ROM_Further_description" id="Reassessment_MS_ROM_Further_description"
rows="6" cols="30"></textarea>
        </strong></td>
      </tr>
      <tr>
        <td align="center" scope="row"><strong>
          <input type="text" name="Reassessment_MS_ROM_Problemarea_text1" style="width:100%"  id="Reassessment_MS_ROM_Problemarea_text1" />
        </strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right1" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right1" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left1" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left1" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM1" id="Reassessment_MS_ROM_ROM1" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM1" id="Reassessment_MS_ROM_ROM1" value="Left"/></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" value="A"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity1" id="Reassessment_MS_ROM_Tonicity1" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity1" id="Reassessment_MS_ROM_Tonicity1" value="Hypo"/></td>
        
      </tr>


 <tr>
        <td align="center" scope="row"><strong>
          <input type="text" name="Reassessment_MS_ROM_Problemarea_text2" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text2" />
        </strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right2" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right2" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left2" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left2" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM2" id="Reassessment_MS_ROM_ROM2" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM2" id="Reassessment_MS_ROM_ROM2" value="Left"/></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2" value="A"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity2" id="Reassessment_MS_ROM_Tonicity2" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity2" id="Reassessment_MS_ROM_Tonicity2" value="Hypo"/></td>
        </tr>
      <tr>
        <td rowspan="2" align="center" scope="row">&nbsp;</th>
          <strong><?php xl('CURRENT PROBLEM AREA(S)','e')?></strong>        </td>
        <td colspan="2" align="center"><strong><?php xl('STRENGTH','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('ROM','e')?></strong></td>
        <td colspan="3" align="center"><strong><?php xl('ROM TYPE','e')?></strong></td>

        <td colspan="2" align="center"><strong><?php xl('TONICITY','e')?></strong></td>
        <td rowspan="2" align="center"><strong><?php xl('FURTHER DESCRIPTION','e')?></strong></td>
      </tr>
      <tr>
        <td align="center"><?php xl('R','e')?></td>
        <td align="center"><?php xl('L','e')?></td>
        <td align="center"><?php xl('R','e')?></td>

        <td align="center"><?php xl('L','e')?></td>
        <td align="center"><?php xl('P','e')?></td>
        <td align="center"><?php xl('AA','e')?></td>
        <td align="center"><?php xl('A','e')?></td>
        <td align="center"><strong><?php xl('Hyper','e')?></strong></td>
        <td align="center"><strong><?php xl('Hypo','e')?></strong></td>

        </tr>
      <tr>
  <td align="center" scope="row">
          <strong>
            <input type="text" name="Reassessment_MS_ROM_Problemarea_text3" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text3" />
            </strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right3" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right3" />
          <?php xl('/5','e')?></strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left3" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left3" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM3" id="Reassessment_MS_ROM_ROM3" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM3" id="Reassessment_MS_ROM_ROM3" value="Left"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="Reassessment_MS_ROM_ROM_Type3" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="Reassessment_MS_ROM_ROM_Type3" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="Reassessment_MS_ROM_ROM_Type3" value="A"/></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity3" id="Reassessment_MS_ROM_Tonicity3" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity3" id="Reassessment_MS_ROM_Tonicity3" value="Hypo"/></td>
 <td align="center" rowspan="3"><textarea name="Reassessment_MS_ROM_Further_description1" id="Reassessment_MS_ROM_Further_description1" 
rows="6" cols="30" ></textarea></td>
        </tr>
      <tr>
        <td align="center" scope="row">
          <strong>

            <input type="text" name="Reassessment_MS_ROM_Problemarea_text4" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text4" />
            </strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right4" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right4" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left4" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left4" />
          <?php xl('/5','e')?></strong></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM4" id="Reassessment_MS_ROM_ROM4" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM4" id="Reassessment_MS_ROM_ROM4" value="Left"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type4" id="Reassessment_MS_ROM_ROM_Type4" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type4" id="Reassessment_MS_ROM_ROM_Type4" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type4" id="Reassessment_MS_ROM_ROM_Type4" value="A"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity4" id="Reassessment_MS_ROM_Tonicity4" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity4" id="Reassessment_MS_ROM_Tonicity4" value="Hypo"/></td>
        </tr>

      <tr>
        <td align="center" scope="row"></th>
          <strong>

            <input type="text" name="Reassessment_MS_ROM_Problemarea_text5" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text5" />
            </strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right5" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right5" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left5" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left5" />
          <?php xl('/5','e')?></strong></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM5" id="Reassessment_MS_ROM_ROM5" value="Right"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM5" id="Reassessment_MS_ROM_ROM5" value="Left"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type5" id="Reassessment_MS_ROM_ROM_Type5" value="P"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type5" id="Reassessment_MS_ROM_ROM_Type5" value="AA"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type5" id="Reassessment_MS_ROM_ROM_Type5" value="A"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity5" id="Reassessment_MS_ROM_Tonicity5" value="Hyper"/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity5" id="Reassessment_MS_ROM_Tonicity5" value="Hypo"/></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr>
	<td><strong><input type="checkbox" name="Reassessment_MS_ROM_NA" id="Reassessment_MS_ROM_NA" value="N/A" />
<?php xl('N/A','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_MS_ROM_NA" value="Tonicity" /> 
<?php xl('Tonicity','e')?> 
<input type="text" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Note" style="width:80%" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Note" />
<br/>
<?php xl(' Patient/Caregiver Continues to Have the Following Problems Achieving Goals with','e')?>
<input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="Strength" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" />
<?php xl('Strength','e')?>

<input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="ROM" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" />
<?php xl('ROM','e')?></strong><br />
</td>

</tr></table></td>
  </tr>
 <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
    <strong><?php xl('ENVIRONMENTAL BARRIERS/SAFETY ISSUES','e')?></strong></td></tr></table></td>
  </tr>
<tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<input type="checkbox" name="Reassessment_Environmental_Barriers" id="Reassessment_Environmental_Barriers" value="No Issues"/>
    <label for="checkbox"><?php xl('No environmental barriers in home','e')?>  
      <input type="checkbox" name="Reassessment_Environmental_Barriers" id="Reassessment_Environmental_Barriers" value="Issues exists"/> 
     <?php xl(' The following environmental issues continue to exist','e')?><br />
    </label>
    <input type="text" name="Reassessment_Environmental_Issues_Notes" style="width:900px"  id="Reassessment_Environmental_Issues_Notes" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable">
	<tr><td><strong><?php xl('REASSESSMENT OVERVIEW','e')?></strong></td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%"  border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<input type="checkbox" name="Reassessment_RO_Patient_Prior_Level_Function" id="Reassessment_RO_Patient_Prior_Level_Function" 
	value="Yes" />
    <label for="checkbox13"><?php xl('Yes','e')?></label>
    <input type="checkbox" name="Reassessment_RO_Patient_Prior_Level_Function" id="Reassessment_RO_Patient_Prior_Level_Function" value="No"/>
    <label for="checkbox14"><?php xl('No Has Patient Reached Their Prior Level of Function?','e')?></label><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('If No, Explain','e')?> <input type="text" name="Reassessment_RO_Prior_Level_Function_Not_Reached" 
id="Reassessment_RO_Prior_Level_Function_Not_Reached" style="width:80%"/> <br/>

      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" value="Yes" />
      <?php xl('Yes','e')?>
      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" value="No"/>
   <?php xl(' No Has Patient Reached Their Long  Term Goals Established on Admission?','e')?><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('If No, Explain','e')?> <input type="text" name="Reassessment_RO_Long_Term_Goal_Not_Reached" 
id="eassessment_RO_Long_Term_Goal_Not_Reached" style="width:80%"/><br/>
    <strong><?php xl('Skilled PT continues to be Reasonable and Necessary to','e')?></strong>
    <br />

    <input type="checkbox" name="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" value="Return to prior Level" id="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" />
<?php xl('Return Patient to Their Prior Level of Function','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" value="Teach Patient" id="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" />
<?php xl('Teach patient/caregiver compensatory strategies for mobility','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" value="Teach Patient New Skills" id="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" />
<?php xl('Train patient/caregiver in learning new skill','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" value="Make Modifications" id="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" />
<?php xl('Make modifications to current program to achieve short term and long term goals*','e')?>
<label for="checkbox14"><br />
  <?php xl('Other','e')?>
    <strong>
    <input type="text" name="Reassessment_Skilled_PT_Other" style="width:88%" id="Reassessment_Skilled_PT_Other" />

    </strong></label></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%"  border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td><strong>
    <?php xl('*Goals Changed/Adapted for Mobility','e')?></strong> <strong>
      <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Mobility" style="width:62%" id="Reassessment_Goals_Changed_Adapted_For_Mobility" />
      <br />
    </strong>
    <strong><?php xl('Mobility','e')?></strong><strong>

    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Mobility1" style="width:85.5%" id="Reassessment_Goals_Changed_Adapted_For_Mobility1" />
    <br />
    </strong>
    <strong><?php xl('Other','e')?>&nbsp;</strong><strong>
    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Other" style="width:87%" id="Reassessment_Goals_Changed_Adapted_For_Other" />
    </strong>
    <strong><br />
    <?php xl('Other','e')?></strong><strong>
    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Other1" style="width:87.5%" id="Reassessment_Goals_Changed_Adapted_For_Other1" />
    </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td><strong><?php xl('PT continued treatment plan was communicated to and agreed upon by ','e')?></strong>
      <input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Patient" id="Reassessment_PT_communicated_and_agreed_upon_by" />
<?php xl('Patient','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Physician" id="Reassessment_PT_communicated_and_agreed_upon_by" />
<?php xl('Physician','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="OT/ST" id="Reassessment_PT_communicated_and_agreed_upon_by" />
<?php xl('OT/ST','e')?><br />
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="PTA" id="Reassessment_PT_communicated_and_agreed_upon_by" />
<?php xl('PTA','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Skilled Nursing" id="Reassessment_PT_communicated_and_agreed_upon_by" />
<?php xl('Skilled Nursing','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Caregiver/Family" id="Reassessment_PT_communicated_and_agreed_upon_by" />
<?php xl('Caregiver/Family','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Case Manager" id="Reassessment_PT_communicated_and_agreed_upon_by" />
<?php xl('Case Manager','e')?><br/> <?php xl('Other','e')?>
<input type="text" name="Reassessment_PT_communicated_and_agreed_upon_by_Others" id="Reassessment_PT_communicated_and_agreed_upon_by_Others" style="width:87%"/>
</td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table  width="100%" border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td><strong>

	<?php xl('ADDITIONAL  SERVICES PROVIDED  THIS VISIT','e')?></strong> <br/> 
	<input type="checkbox" name="Reassessment_AS_Home_Exercise" id="Reassessment_AS_Home_Exercise" />
<?php xl('Home Exercise Program Upgraded','e')?><br>
  <input type="checkbox" name="Reassessment_AS_Falls_Management_Prevention" id="Reassessment_AS_Falls_Management_Prevention" />
<?php xl('Falls Management/Prevention Program Implemented','e')?><br>
<input type="checkbox" name="Reassessment_AS_Recommendations_for_SafetyIssues" id="Reassessment_AS_Recommendations_for_SafetyIssues" />
<?php xl('Recommendations for Safety Issues Implemented','e')?><br>
<input type="checkbox" name="Reassessment_AS_Treatment" id="Reassessment_AS_Treatment" />
<label><?php xl('Treatment for','e')?></label>
<strong>
<input type="text" name="Reassessment_AS_Treatment_for" style="width:78%"  id="Reassessment_AS_Treatment_for" />
      <br />

</strong>
      <?php xl('Other Services Provided','e')?><strong>
      <input type="text" name="Reassessment_Other_Services_Provided" style="width:72%" id="Reassessment_Other_Services_Provided" />
      </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="1px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td width="45%"><strong>
    <?php xl('Therapist Performing Reassessment(Name and Title)','e')?></strong>   </td> 
    <td align="center" width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td></tr></table></td>
  </tr>
</table>
<a href="javascript:top.restoreSession();document.reassessment.submit();" class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>
</body>
</html>
