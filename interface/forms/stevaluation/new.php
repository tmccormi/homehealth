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
	    	 if(Dx=="Evaluation_TREATMENT_DX_Problem")
	    	 {
	    		 trmnt_icd9.innerHTML= result['res'];
	    	 }
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/stevaluation/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>
</style>
</head>

<body>
	<form method="post"
		action="<?php echo $rootdir;?>/forms/stevaluation/save.php?mode=new" name="evaluation">
		<h3 align="center"><?php xl('SPEECH THERAPY EVALUATION','e'); ?></h3>
<table align="center"  border="1" cellpadding="0px" cellspacing="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="5px" class="formtable">

        <tr>
          <td width="10%" align="center" scope="row"><strong><?php xl('Patient Name','e')?></strong></td>
         <td width="15%" align="center" valign="top"><input type="text"
					id="patient_name" value="<?php patientName()?>"
				readonly/></td>
          <td width="5%" align="center"><strong><?php xl('MR#','e')?></strong></td>
          <td width="10%" align="center" valign="top" class="bold"><input
					type="text" style="width:100%" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" readonly /></td>
	<td width="6%"><strong><?php xl('Time In','e'); ?></strong></td>
        <td width="7%"><select name="Evaluation_Time_In" id="Evaluation_Time_In"> <?php timeDropDown($GLOBALS['Selected']) ?></select></td>
        <td width="7%"><strong><?php xl('Time Out','e'); ?></strong></td>
        <td width="6%"><select name="Evaluation_Time_Out" id="Evaluation_Time_Out"> <?php timeDropDown($GLOBALS['Selected']) ?></select></td>
          <td width="5%" align="center"><strong><?php xl('Date','e')?></strong></td><td>

          <input type='text' size='10' name='Evaluation_date' id='Evaluation_date' 
					title='<?php xl('Date','e'); ?>'
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
<td width="91%"><?php xl('Pulse','e')?> 

        <input type="text" name="Evaluation_Pulse" size="3px" id="Evaluation_Pulse" />
        
          <input type="checkbox" name="Evaluation_Pulse_State" value="Regular" id="Evaluation_Pulse_State" />
                <?php xl('Regular','e')?>
      
          <input type="checkbox" name="Evaluation_Pulse_State" value="Irregular" id="Evaluation_Pulse_State" />
          <?php xl('Irregular','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Temperature','e')?> 

      <input type="text" size="5px" name="Evaluation_Temperature" id="Evaluation_Temperature" /> 
	  <input type="checkbox" name="Evaluation_Temperature_type" value="Oral" id="Evaluation_Temperature_type" />
<?php xl('Oral','e')?>
<input type="checkbox" name="Evaluation_Temperature_type" value="Temporal" id="Evaluation_Temperature_type" />
<?php xl('Temporal','e')?>&nbsp;  
     <?php xl('Other','e')?>
     <input type="text"  style="width:31%" name="Evaluation_VS_other" id="Evaluation_VS_other" /><br> 
<?php xl('Respirations','e')?>
      <input type="text" size="5px" name="Evaluation_VS_Respirations" id="Evaluation_VS_Respirations" />&nbsp;&nbsp;&nbsp;&nbsp;
      <?php xl('Blood Pressure Systolic','e')?>
      <input type="text" size="6px" name="Evaluation_VS_BP_Systolic" id="Evaluation_VS_BP_Systolic" />
      <?php xl('/ Diastolic','e')?> 
      <input type="text" size="6px" name="Evaluation_VS_BP_Diastolic" id="Evaluation_VS_BP_Diastolic" /> 
      
        <input type="checkbox" name="Evaluation_VS_BP_Body_side" value="Right" id="Evaluation_VS_BP_Body_side" />
            <?php xl('Right','e')?>
        
            <input type="checkbox" name="Evaluation_VS_BP_Body_side" value="Left" id="Evaluation_VS_BP_Body_side" />
            <?php xl('Left','e')?>          
          
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Sitting" id="Evaluation_VS_BP_Body_Position" />
            <?php xl('Sitting','e')?>
          
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Standing" id="Evaluation_VS_BP_Body_Position" />
            <?php xl('Standing','e')?>
      
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Lying" id="Evaluation_VS_BP_Body_Position" />
      
 <?php xl('Lying','e')?><br>
<?php xl('*O','e')?> <sub> <?php xl('2','e')?> </sub> <?php xl('Sat','e')?>

<input type="text" name="Evaluation_VS_Sat" size="5px" id="Evaluation_VS_Sat" /> 
<?php xl('*Physician ordered','e')?></td></tr></table></td></tr>

<tr>
<td width="100%" scope="row"><table border="0" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td width="87%" class="formtable"><strong><?php xl('Pain','e')?>
 </strong>
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="Pain" id="Evaluation_VS_Pain" />
    <?php xl('No Pain','e')?>
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="No Pain" id="Evaluation_VS_Pain" />
    <?php xl('Pain limits functional ability ','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Intensity ','e')?>

  <input type="text" size="5px" name="Evaluation_VS_Pain_Intensity" id="Evaluation_VS_Pain_Intensity" />
  <?php xl('(0-10)','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Location(s)','e')?>
  <input type="text" style="width:31%" name="Evaluation_VS_Location" id="Evaluation_VS_Location" />
  <br />
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="pain due to recent injury" id="Evaluation_VS_Pain" />
  <?php xl('Pain due to recent illness/injury','e')?>
  
  <input type="checkbox" name="Evaluation_VS_Pain" value="Chronic pain" id="Evaluation_VS_Pain " />
  <?php xl('Chronic pain','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <?php xl('Other','e')?>
  <input type="text" style="width:54%" name="Evaluation_VS_Other1"  id="Evaluation_VS_Other1" />
  </td>
  </tr>
  </table>
  </td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong>
<?php xl('Please Note : Contact MD if Vital Signs are Pulse','e')?>&lt;
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
          <td width="47%" valign="top" scope="row">
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
                    <input type="text" style="width:57%" name="Evaluation_HR_Medical_Restrictions_In" id="Evaluation_HR_Medical_Restrictions_In" />
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
          <td width="53%" valign="top">
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
                  <input type="text" style="width:89%" name="Evaluation_HR_Other"  id="Evaluation_HR_Other" /></td>
              </tr>
              </table>
          </td>
        </tr>
      </table>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
        <tr>
          <td align="center" scope="row"><strong><?php xl('MED DX/ Reason for ST intervention','e')?></strong></td>
          <td align="center">
	<input type="text" id="icd" size="15"/>
	<input type="button" value="Search" onClick="javascript:changeICDlist(Evaluation_Reason_for_intervention,document.getElementById('icd'),'<?php echo $rootdir; ?>')"/>
<span id="med_icd9">
<select id="Evaluation_Reason_for_intervention" name="Evaluation_Reason_for_intervention" style="display:none"></select></span>  
	</td>
          <td align="center"><strong><?php xl('TREATMENT DX/Problem','e')?></strong></td>
          <td align="center">
	<input type="text" id="icd9" size="15"/>
        <input type="button" value="Search" onClick="javascript:changeICDlist(Evaluation_TREATMENT_DX_Problem,document.getElementById('icd9'),'<?php echo $rootdir; ?>')"/>
<span id="trmnt_icd9">
<select id="Evaluation_TREATMENT_DX_Problem" name="Evaluation_TREATMENT_DX_Problem" style="display:none"></select></span> 
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
          <input type="text" style="width:74%" name="Evaluation_PERTINENT_MEDICAL_HISTORY"  id="Evaluation_PERTINENT_MEDICAL_HISTORY" />
        </strong></td>
      </tr>

      <tr>
        <td scope="row"><strong><?php xl('MEDICAL/FUNCTIONAL PRECAUTIONS','e')?></strong>&nbsp; &nbsp;
          <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="None" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" />
          <?php xl('None','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="Swallow Status" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" />
          <?php xl('Swallow Status','e')?> 
  <input type="text" style="width:35%" name="Evaluation_MFP_Swallow_status" id="Evaluation_MFP_Swallow_status" />&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="SOB" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" />
          <?php xl('SOB','e')?><br><?php xl('Other','e')?>
         
            <input type="text" style="width:94%" name="Evaluation_MFP_Other" id="Evaluation_MFP_Other" />
            <br />
             <strong><?php xl('Handedness','e')?></strong>
            
          
            <input type="checkbox" name="Evaluation_MFP_Handedness" value="Right" id="Evaluation_MFP_Handedness" />
            <?php xl('Right','e')?>
          
            <input type="checkbox" name="Evaluation_MFP_Handedness" value="Left" id="Evaluation_MFP_Handedness" />
            <?php xl('Left','e')?>
          
            <input type="checkbox" name="Evaluation_MFP_Handedness" value="Ambidextrous" id="Evaluation_MFP_Handedness" />
            <?php xl('Ambidextrous','e')?>
          
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('Limitations:','e')?></strong>

            <input type="checkbox" name="Evaluation_MFP_Limitations" value="Glasses" id="Evaluation_MFP_Limitations" />
            <?php xl('Glasses','e')?>
          
            <input type="checkbox" name="Evaluation_MFP_Limitations" value="Dentures" id="Evaluation_MFP_Limitations" />
            <?php xl('Dentures','e')?>
          
	     <input type="checkbox" name="Evaluation_MFP_Limitations" value="Hearing Aide" id="Evaluation_MFP_Limitations" />
            <?php xl('Hearing Aide','e')?>
	      
	      <br />           
            <strong>
	     <?php xl('Current Weight Loss:','e')?></strong>
	    <input type="checkbox" name="Evaluation_MFP_Current_Weight_Loss" value="Yes" id="Evaluation_MFP_Current_Weight_Loss" />
            <?php xl('Yes','e')?>
          
            <input type="checkbox" name="Evaluation_MFP_Current_Weight_Loss" value="No" id="Evaluation_MFP_Current_Weight_Loss" />
            <?php xl('No','e')?>

	       &nbsp;&nbsp;<?php xl('If yes, describe why:','e')?> 
	      <input type="text" style="width:55%" name="Evaluation_MFP_Weight_Loss_Reason" id="Evaluation_MFP_Weight_Loss_Reason" />
             <br />


	    <strong>
	<?php xl('PRIOR LEVEL OF SWALLOW/SPEECH FUNCTION','e')?></strong><br/>
	   <input type="text" style="width:98%" name="Evaluation_Prior_Level_Of_Function" id="Evaluation_Prior_Level_Of_Function" />
      <br/>

      <strong>
	<?php xl('FAMILY/CAREGIVER SUPPORT','e')?></strong>&nbsp;
	<input type="checkbox" name="Evaluation_Family_Caregiver_Support" value="Yes" id="Evaluation_Family_Caregiver_Support" />
	<?php xl('Yes','e')?>
          
            <input type="checkbox" name="Evaluation_Family_Caregiver_Support" value="No" id="Evaluation_Family_Caregiver_Support" />
            <?php xl('No','e')?>&nbsp;&nbsp;&nbsp;
            <?php xl('Who','e')?> <strong>
              <input type="text" style="width:45%" name="Evaluation_Family_Caregiver_Support_Who" id="Evaluation_Family_Caregiver_Support_Who" />
              </strong><br><?php xl('Previous # Visits into Community Weekly','e')?> <strong>
                <input type="text" style="width:20%" name="Evaluation_FC_Visits_Community_Weekly" id="Evaluation_FC_Visits_Community_Weekly" />
                </strong><br />
            <?php xl('Additional Comments','e')?><strong>
              <input style="width:82%" type="text" name="Evaluation_FC_Additional_Comments" id="Evaluation_FC_Additional_Comments" />
            </strong></td>
      </tr>
    </table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
   <td><strong><?php xl('Scale Grades','e')?></strong> <?php xl(' 5 = WFL(within functional limits); 4 = WFL with cues; 3 = Mild impairment; 2 = Moderate impairment; 1 = Severe impairment; 0 = Unable or Not Tested','e')?>
</td></tr></table></td></tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>
        <td width="20%" align="center"><strong><?php xl('Skill Component (Use Rating Above)','e')?></strong></td>
        <td width="15%" align="center"><strong><?php xl('Status','e')?></strong></td>
        <td width="20%" align="center"><strong><?php xl('Skill Component (Use Rating Above)','e')?></strong></td>
        <td width="15%" align="center"><strong><?php xl('Status','e')?></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Auditory Comp','e')?> </td>
        <td><strong><select id="Evaluation_Auditory_Comp" name="Evaluation_Auditory_Comp">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('Mastication','e')?></td>
        <td><strong><select id="Evaluation_Mastication" name="Evaluation_Mastication">
	<?php Mobility_status($GLOBALS['Selected']) ?></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Reading Comp','e')?></td>
        <td><strong><select id="Evaluation_Reading_Comp" name="Evaluation_Reading_Comp">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('Lingual Transfer','e')?></td>
        <td><strong><select id="Evaluation_Lingual_Transfer" name="Evaluation_Lingual_Transfer">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Verbal Expression','e')?></td>
        <td><strong><select id="Evaluation_Verbal_Expression" name="Evaluation_Verbal_Expression">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('Pocketing','e')?></td>
        <td><strong><select id="Evaluation_Pocketing" name="Evaluation_Pocketing">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Written Expression','e')?></td>
        <td><strong><select id="Evaluation_Written_Expression" name="Evaluation_Written_Expression">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('A/P Propulsion','e')?> </td>
        <td><strong><select id="Evaluation_AP_Propulsion" name="Evaluation_AP_Propulsion">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
      </tr>   

      <tr>
        <td scope="row"><?php xl('Gestural Expression','e')?> </td>
        <td><strong><select id="Evaluation_Gestural_Expression" name="Evaluation_Gestural_Expression">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('Oral Transit','e')?> </td>
        <td><strong><select id="Evaluation_Oral_Transit" name="Evaluation_Oral_Transit">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
      </tr>     

      <tr>
        <td scope="row"><?php xl('Speech Intelligibility','e')?> </td>
        <td><strong><select id="Evaluation_Speech_Intelligibility" name="Evaluation_Speech_Intelligibility">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
        <td><?php xl('Swallow Timing','e')?> </td>
        <td><strong><select id="Evaluation_Swallow_Timing" name="Evaluation_Swallow_Timing">
	<?php Mobility_status($GLOBALS['Selected']) ?></select></strong></td>
      </tr>     
      
  </table>    
  </tr>

  <tr> 
  <td> 
  <strong><?php xl('Diet Level','e')?> </strong> 
<input type="text" name="Evaluation_Diet_Level" id="Evaluation_Diet_Level" style="width:88%" />
  </td>
  </tr>

<tr> 
  <td> 
  <strong><?php xl('Mental Status','e')?></strong>  

  <input type="checkbox" name="Evaluation_Mental_Status" value="Alert" id="Evaluation_Mental_Status" />
  <?php xl('Alert','e')?>

  <input type="checkbox" name="Evaluation_Mental_Status" value="Not Alert" id="Evaluation_Mental_Status" />
  <?php xl('Not Alert','e')?>

 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('Oriented to','e')?></strong>
  
  <input type="checkbox" name="Evaluation_Mental_Status_Oriented_to" value="Person" id="Evaluation_Mental_Status_Oriented_to" />
  <?php xl('Person','e')?>

  <input type="checkbox" name="Evaluation_Mental_Status_Oriented_to" value="Place" id="Evaluation_Mental_Status_Oriented_to" />
  <?php xl('Place','e')?>

  <input type="checkbox" name="Evaluation_Mental_Status_Oriented_to" value="Date" id="Evaluation_Mental_Status_Oriented_to" />
  <?php xl('Date','e')?>

  <input type="checkbox" name="Evaluation_Mental_Status_Oriented_to" value="Reason for Therapy" id="Evaluation_Mental_Status_Oriented_to" />
  <?php xl('Reason for Therapy','e')?>

  </td>
  </tr>

<tr> 
  <td> 
  <strong><?php xl('ADDITIONAL COMMENTS','e')?> </strong>
  <input type="text" style="width:77%" name="Evaluation_MS_Additional_Comments" id="Evaluation_MS_Additional_Comments" />
  </td>
  </tr>


     <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td>
    <strong><?php xl('SUMMARY','e')?></strong></td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
	<tr><td>
      <input type="checkbox" name="Evaluation_ST_Evaluation_Only" id="Evaluation_ST_Evaluation_Only" />
    <?php xl('ST Evaluation only. No further indications of service','e')?>
        <br />
        <input type="checkbox" name="Evaluation_Need_Physician_Orders" id="Evaluation_Need_Physician_Orders" />
    <?php xl('Need physician orders for ST services with specific treatments, frequency, and duration. See ST Care Plan and/or 485','e')?><br />
    <input type="checkbox" name="Evaluation_Received_Physician_Orders" id="Evaluation_Received_Physician_Orders" />
    <?php xl('Received physician orders for ST treatment and approximate next visit date will be','e')?>
    <input type="text" size="10" name="Evaluation_Approximate_Next_Visit_Date" id="Evaluation_Approximate_Next_Visit_Date" title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_next_visit_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"Evaluation_Approximate_Next_Visit_Date", ifFormat:"%Y-%m-%d", button:"img_next_visit_date"});
   </script>
</td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('ST Care Plan and Evaluation was communicated to and agreed upon by','e')?></strong>
        <input type="checkbox" name="Evaluation_ST_Communicated_And_Agreed_by" value="Patient" id="Evaluation_ST_Communicated_And_Agreed_by" />
    <?php xl('Patient','e')?>
  <input type="checkbox" name="Evaluation_ST_Communicated_And_Agreed_by" value="Physician" id="Evaluation_ST_Communicated_And_Agreed_by" />
    <?php xl('Physician','e')?>
    <input type="checkbox" name="Evaluation_ST_Communicated_And_Agreed_by" value="PT/ST" id="Evaluation_ST_Communicated_And_Agreed_by" />
      <?php xl('PT/ST','e')?>
    <input type="checkbox" name="Evaluation_ST_Communicated_And_Agreed_by" value="COTA" id="Evaluation_ST_Communicated_And_Agreed_by" />
    <?php xl('PTA','e')?>
    <input type="checkbox" name="Evaluation_ST_Communicated_And_Agreed_by" value="Skilled Nursing" id="Evaluation_ST_Communicated_And_Agreed_by" />
    <?php xl('Skilled Nursing','e')?>
    <input type="checkbox" name="Evaluation_ST_Communicated_And_Agreed_by" value="Caregiver/Family" id="Evaluation_ST_Communicated_And_Agreed_by" />
    <?php xl('Caregiver/Family','e')?>
    <input type="checkbox" name="Evaluation_ST_Communicated_And_Agreed_by" value="Case Manager" id="Evaluation_ST_Communicated_And_Agreed_by" />
    <?php xl('Case Manager','e')?><br>
   <?php xl('Others','e')?>
    <input type="text" style="width:92%" name="Evaluation_ST_Communicated_And_Agreed_By_Other" id="Evaluation_ST_Communicated_And_Agreed_By_Other" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td width="48%"><strong><?php xl('ADDITIONAL SERVICES PROVIDED','e')?>
      </strong> <br/>
        <input type="checkbox" name="Evaluation_ADDITIONAL_SERVICES_Speech_Excersice" id="Evaluation_ADDITIONAL_SERVICES_Speech_Excersice" />
    <?php xl('Speech/Lingual Exercise Program Initiated','e')?>&nbsp;&nbsp;
    <input type="checkbox" name="Evaluation_ADDITIONAL_SERVICES_Swallow_technique" id="Evaluation_ADDITIONAL_SERVICES_Swallow_technique" />
    <?php xl('Recommendations for Compensatory Swallow Techniques','e')?><br>
    <input type="checkbox" name="Evaluation_ADDITIONAL_SERVICES_Diet_Modifications" id="Evaluation_ADDITIONAL_SERVICES_Diet_Modifications" />
    <?php xl('Recommendations for Diet Modification Discussed','e')?><br>
    <input type="checkbox" name="Evaluation_ADDITIONAL_SERVICES_Treatment" id="Evaluation_ADDITIONAL_SERVICES_Treatment" />
     <?php xl('Treatment for','e')?>&nbsp;<input type="text" style="width:84%" name="Evaluation_ASP_Treatment_For" id="Evaluation_ASP_Treatment_For" /> 
      </td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('Skilled ST is Reasonable and Necessary to','e')?></strong>
            <br />
            <input type="checkbox" name="Evaluation_Skilled_ST_Necessary_To" id="Evaluation_Skilled_ST_Necessary_To" 
value="Return to Prior Level"/>
       <?php xl('Return Patient to Their Prior Level of Function','e')?>&nbsp;&nbsp;
    <input type="checkbox" name="Evaluation_Skilled_ST_Necessary_To" id="Evaluation_Skilled_ST_Necessary_To" 
value="Teach Patient"/>
    <?php xl('Teach patient compensatory techniques for mobility','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Evaluation_Skilled_ST_Necessary_To" id="Evaluation_Skilled_ST_Necessary_To"  
value="Train Patient New Skills"/>
    <?php xl('Train patient in learning new skills','e')?><br>
    <?php xl('Other','e')?>
    <input type="text" style="width:92%" name="Evaluation_Skilled_ST_Other" id="Evaluation_Skilled_ST_Other" /></td></tr></table></td>
  </tr>  
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>

        <td width="50%" scope="row"><strong><?php xl('Therapist Who Developed POC','e')?></strong>
    <?php xl('(Name and Title)','e')?></td>
        <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td>
      </tr>
    </table></td></tr></table>
<a href="javascript:top.restoreSession();document.evaluation.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>
</body>
</html>
