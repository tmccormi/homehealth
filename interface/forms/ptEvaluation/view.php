<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"|| strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";
    
$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_pt_Evaluation";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

?>
<html><head>
<?php html_header_show();?>
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
	<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />


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
	  
	  //for signature
	  $(document).ready(function() {
        var status = "";
        
	$("#signoff").fancybox({
	'scrolling'		: 'no',
	'titleShow'		: false,
	'onClosed'		: function() {
	    $("#login_prompt").hide();
            
	}
        });

        $("#login_form").bind("submit", function() {

            document.getElementById("login_pass").value = SHA1(document.getElementById("login_pass").value);
            
            if ($("#login_pass").val().length < 1) {
                $("#login_prompt").show();
                $.fancybox.resize();
                return false;
            }

            $.fancybox.showActivity();

            $.ajax({
		type		: "POST",
		cache	: false,
		url		: "<?php echo $GLOBALS['rootdir'] . "/forms/$formDir/sign.php";?>",
		data		: $(this).serializeArray(),
		success: function(data) {
			$.fancybox(data);
		}
            });

            
            return false;
        });
    });

	</script>
</head>
<body class="body_top">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_pt_Evaluation", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>
<form method=post action="<?php echo $rootdir?>/forms/ptEvaluation/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="evaluation">
<h3 align="center"><?php xl('PHYSICAL THERAPY EVALUATION','e'); ?></h3></span>

<table align="center"  border="1" cellpadding="0px" cellspacing="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="5px" class="formtable">

        <tr>
          <td width="5%" align="center" scope="row"><strong><?php xl('Patient Name','e')?></strong></td>
         <td width="15%" align="center" valign="top"><input type="text"
					id="patient_name" value="<?php patientName()?>"
					readonly /></td>
          <td width="10%" align="center"><strong><?php xl('MR#','e')?></strong></td>
          <td width="15%" align="center" valign="top" class="bold"><input
				style="width:100%" type="text" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" readonly /></td>

		 <td width="5%"><strong><?php xl('Time In','e'); ?></strong></td>
        <td width="9%" ><select name="Evaluation_Time_In" id="Evaluation_Time_In"><?php timeDropDown(stripslashes($obj{"Evaluation_Time_In"})) ?></select></td>
        <td width="5%"><strong><?php xl('Time Out','e'); ?></strong></td>
        <td width="9%"><select name="Evaluation_Time_Out" id="Evaluation_Time_Out"><?php timeDropDown(stripslashes($obj{"Evaluation_Time_Out"})) ?></select></td>
        
          <td width="5%"align="center"><strong><?php xl('Date','e')?></strong></td>

          <td width="20%" align="center">
<input type='text' size='15' name='Evaluation_date' id='Evaluation_date' 
					title='<?php xl('Date','e'); ?>'
			value="<?php echo stripslashes($obj{"Evaluation_date"});?>"
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

        <input type="text" name="Evaluation_Pulse" size="3px" id="Evaluation_Pulse" value="<?php echo stripslashes($obj{"Evaluation_Pulse"});?>"/>
        
          <input type="checkbox" name="Evaluation_Pulse_State" value="Regular" id="Evaluation_Pulse_State" 
    <?php if ($obj{"Evaluation_Pulse_State"} == "Regular")  echo "checked";;?>>
                <?php xl('Regular','e')?>
      
          <input type="checkbox" name="Evaluation_Pulse_State" value="Irregular" id="Evaluation_Pulse_State" 
    <?php if ($obj{"Evaluation_Pulse_State"} == "Irregular")  echo "checked";;?>>
          <?php xl('Irregular','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Temperature','e')?> 
      <input type="text" size="5px"  name="Evaluation_Temperature" id="Evaluation_Temperature" value="<?php echo stripslashes($obj{"Evaluation_Temperature"});?>"/>
	  <input type="checkbox" name="Evaluation_Temperature_type" value="Oral" id="Evaluation_Temperature_type" 
  <?php if ($obj{"Evaluation_Temperature_type"} == "Oral")  echo "checked";;?>>
  <?php xl('Oral','e')?>
  <input type="checkbox" name="Evaluation_Temperature_type" value="Temporal" id="Evaluation_Temperature_type" 
  <?php if ($obj{"Evaluation_Temperature_type"} == "Temporal")  echo "checked";;?>>
  <?php xl('Temporal','e')?>&nbsp;  
     <?php xl('Other','e')?>
     <input type="text" style="width:70px" name="Evaluation_VS_other" id="Evaluation_VS_other" 
     value="<?php echo stripslashes($obj{"Evaluation_VS_other"});?>"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
    <?php xl('Respirations','e')?>
      <input type="text" style="width:60px" name="Evaluation_VS_Respirations" id="Evaluation_VS_Respirations" 
      value="<?php echo stripslashes($obj{"Evaluation_VS_Respirations"});?>"/>     
<br/> 
      <?php xl('Blood Pressure Systolic','e')?>
      <input type="text" size="3px" name="Evaluation_VS_BP_Systolic" id="Evaluation_VS_BP_Systolic" 
     value="<?php echo stripslashes($obj{"Evaluation_VS_BP_Systolic"});?>"/>
      <?php xl('/ Diastolic','e')?> 
      <input type="text" size="3px" name="Evaluation_VS_BP_Diastolic" id="Evaluation_VS_BP_Diastolic" 
    value="<?php echo stripslashes($obj{"Evaluation_VS_BP_Diastolic"});?>"/> 
      
        <input type="checkbox" name="Evaluation_VS_BP_Body_side" value="Right" id="Evaluation_VS_BP_Body_side" 
    <?php if ($obj{"Evaluation_VS_BP_Body_side"} == "Right")  echo "checked";;?>>
            <?php xl('Right','e')?>
        
            <input type="checkbox" name="Evaluation_VS_BP_Body_side" value="Left" id="Evaluation_VS_BP_Body_side" 
       <?php if ($obj{"Evaluation_VS_BP_Body_side"} == "Left")  echo "checked";;?>>
            <?php xl('Left','e')?>          
          
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Sitting" id="Evaluation_VS_BP_Body_Position" 
       <?php if ($obj{"Evaluation_VS_BP_Body_Position"} == "Sitting")  echo "checked";;?>>
            <?php xl('Sitting','e')?>
          
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Standing" id="Evaluation_VS_BP_Body_Position" 
	 <?php if ($obj{"Evaluation_VS_BP_Body_Position"} == "Standing")  echo "checked";;?>>
            <?php xl('Standing','e')?>
      
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Lying" id="Evaluation_VS_BP_Body_Position" 
	 <?php if ($obj{"Evaluation_VS_BP_Body_Position"} == "Lying")  echo "checked";;?>>
      
 <?php xl('Lying','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('*O','e')?> <sub> <?php xl('2','e')?></sub> <?php xl('Sat','e')?>

<input type="text" name="Evaluation_VS_Sat" size="3px" id="Evaluation_VS_Sat" 
      value="<?php echo stripslashes($obj{"Evaluation_VS_Sat"});?>"/>  
  <?php xl('*Physician ordered','e')?></td></tr></table></td></tr>
<tr>
<td scope="row"><table border="0" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong><?php xl('Pain','e')?></strong>
  
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="Pain" id="Evaluation_VS_Pain" 
    <?php if ($obj{"Evaluation_VS_Pain"} == "Pain")  echo "checked";;?>/>
    <?php xl('No Pain','e')?>
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="No Pain" id="Evaluation_VS_Pain" 
    <?php if ($obj{"Evaluation_VS_Pain"} == "No Pain")  echo "checked";;?>/>
    <?php xl('Pain limits functional ability ','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl('Intensity ','e')?>

  <input type="text" size="5px" name="Evaluation_VS_Pain_Intensity" id="Evaluation_VS_Pain_Intensity" 
     value="<?php echo stripslashes($obj{"Evaluation_VS_Pain_Intensity"});?>"/>  
  <?php xl('(0-10)','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Location(s)','e')?>
  <input type="text" size="25px" name="Evaluation_VS_Location" id="Evaluation_VS_Location" 
  value="<?php echo stripslashes($obj{"Evaluation_VS_Location"});?>"/>  
  <br />
  
    <input type="checkbox" name="Evaluation_VS_Pain" value="pain due to recent injury" id="Evaluation_VS_Pain" 
     <?php if ($obj{"Evaluation_VS_Pain"} == "pain due to recent injury")  echo "checked";;?>/> 
  <?php xl('Pain due to recent illness/injury','e')?>
  
  <input type="checkbox" name="Evaluation_VS_Pain" value="Chronic pain" id="Evaluation_VS_Pain " 
 <?php if ($obj{"Evaluation_VS_Pain"} == "Chronic pain")  echo "checked";;?>/>
  <?php xl('Chronic pain','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <?php xl('Other','e')?>
  <input type="text" name="Evaluation_VS_Other1" style="width:480px" id="Evaluation_VS_Other1" 
    value="<?php echo stripslashes($obj{"Evaluation_VS_Other1"});?>"/>
  </td>
  </tr>
  </table>
  </td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong>
<?php xl('Please Note Contact MD if Vital Signs are Pulse','e')?>&lt;
<?php xl('56 or','e')?> &gt;<?php xl('120 Temperature','e')?>&lt;
<?php xl('56 or','e')?> &gt;<?php xl('101 Respirations','e')?> &lt;<?php xl('10 or','e')?>&gt;
<?php xl('30','e')?> <br /></strong>
<strong> <?php xl('SBP','e')?> &lt; <?php xl('80 or','e')?> &gt;<?php xl('190 DBP','e')?>&lt;
<?php xl('50 or','e')?>&gt;<?php xl('100 Pain Significantly Impacts patients ability to participate. O2 Sat','e')?>
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
                    <input type="checkbox" name="Evaluation_HR_Needs_assistance" id="Evaluation_HR_Needs_assistance" 
		    <?php if ($obj{"Evaluation_HR_Needs_assistance"} == "on")  echo "checked";;?>/> 
                    <?php xl('Needs assistance in all activities','e')?></td>
                </tr>
                <tr>
                  <td>
                    <input type="checkbox" name="Evaluation_HR_Unable_to_leave_home" id="Evaluation_HR_Unable_to_leave_home" 
	      <?php if ($obj{"Evaluation_HR_Unable_to_leave_home"} == "on")  echo "checked";;?>/> 
                    <?php xl('Unable to leave home safely without assistance','e')?></td>
                </tr>
                <tr>
                  <td>
                    <input type="checkbox" name="Evaluation_HR_Medical_Restrictions" id="Evaluation_HR_Medical_Restrictions" 
		 <?php if ($obj{"Evaluation_HR_Medical_Restrictions"} == "on")  echo "checked";;?>/> 
                    <?php xl('Medical Restrictions in','e')?>
                    <input type="text" name="Evaluation_HR_Medical_Restrictions_In" style="width:270px" id="Evaluation_HR_Medical_Restrictions_In" 
	    value="<?php echo stripslashes($obj{"Evaluation_HR_Medical_Restrictions_In"});?>"/>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="checkbox" name="Evaluation_HR_SOB_upon_exertion" id="Evaluation_HR_SOB_upon_exertion" 
	       <?php if ($obj{"Evaluation_HR_SOB_upon_exertion"} == "on")  echo "checked";;?>/> 
                    <?php xl('SOB upon exertion','e')?>
                    <input type="checkbox" name="Evaluation_HR_Pain_with_Travel" id="Evaluation_HR_Pain_with_Travel" 
	       <?php if ($obj{"Evaluation_HR_Pain_with_Travel"} == "on")  echo "checked";;?>/> 
		<?php xl('Pain with Travel','e')?></td>
                </tr>
              </table>
          <td width="50%" valign="top">
            <table width="100%" border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
              <tr>
                <td>
                  <input type="checkbox" name="Evaluation_HR_Requires_assistance" id="Evaluation_HR_Requires_assistance" 
	  <?php if ($obj{"Evaluation_HR_Requires_assistance"} == "on")  echo "checked";;?>/>
                  <?php xl('Requires assistance in mobility and ambulation','e')?></td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" name="Evaluation_HR_Arrhythmia" id="Evaluation_HR_Arrhythmia" 
	  <?php if ($obj{"Evaluation_HR_Arrhythmia"} == "on")  echo "checked";;?>/>
                  <?php xl('Arrhythmia','e')?>
                  <input type="checkbox" name="Evaluation_HR_Bed_Bound" id="Evaluation_HR_Bed_Bound" 
	  <?php if ($obj{"Evaluation_HR_Bed_Bound"} == "on")  echo "checked";;?>/>
		  <?php xl('Bed Bound','e')?>
	      <input type="checkbox" name="Evaluation_HR_Residual_Weakness" id="Evaluation_HR_Residual_Weakness" 
	  <?php if ($obj{"Evaluation_HR_Residual_Weakness"} == "on")  echo "checked";;?>/>
	    <?php xl('Residual Weakness','e')?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="Evaluation_HR_Confusion" id="Evaluation_HR_Confusion" 
	  <?php if ($obj{"Evaluation_HR_Confusion"} == "on")  echo "checked";;?>/>
		<?php xl('Confusion, unable to go out of home alone','e')?><br />
	  <input type="checkbox" name="Evaluation_HR_Multiple_Stairs_Home" id="Evaluation_HR_Multiple_Stairs_Home"
	  <?php if ($obj{"Evaluation_HR_Multiple_Stairs_Home"} == "on")  echo "checked";;?>/>
	  <?php xl('Multiple stairs to enter/exit home','e')?></td>
              </tr>
              <tr>
                <td><?php xl('Other','e')?>
                  <input type="text" name="Evaluation_HR_Other" style="width:350px" id="Evaluation_HR_Other" 
	value="<?php echo stripslashes($obj{"Evaluation_HR_Other"});?>"/></td>
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
<input type="text" id="Evaluation_Reason_for_intervention" name="Evaluation_Reason_for_intervention" style="width:100%;" value="<?php echo stripslashes($obj{'Evaluation_Reason_for_intervention'}); ?>"/>
</td>
          <td align="center"><strong><?php xl('TREATMENT DX/Problem','e')?></strong></td>
          <td align="center">
<input type="text" id="Evaluation_TREATMENT_DX_PT_Problem" name="Evaluation_TREATMENT_DX_PT_Problem" style="width:100%;" value="<?php echo stripslashes($obj{'Evaluation_TREATMENT_DX_PT_Problem'}); ?>"/>
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
        <td scope="row"><strong><?php xl('PERTINENT MEDICAL HISTORY','e')?> </strong>
          <input type="text" name="Evaluation_PERTINENT_MEDICAL_HISTORY" style="width:680px" id="Evaluation_PERTINENT_MEDICAL_HISTORY" 
	value="<?php echo stripslashes($obj{"Evaluation_PERTINENT_MEDICAL_HISTORY"});?>"/>
        </td>
      </tr>

      <tr>
        <td scope="row"><strong><?php xl('MEDICAL/FUNCTIONAL PRECAUTIONS','e')?></strong>
          <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="None" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" 
	 <?php if ($obj{"Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"} == "None")  echo "checked";;?>/>
          <?php xl('None','e')?>
  <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="WB Status" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" \
       <?php if ($obj{"Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"} == "WB Status")  echo "checked";;?>/>
          <?php xl('WB Status','e')?> 
  <input type="text" name="Evaluation_MFP_WB_status" id="Evaluation_MFP_WB_status" 
      value="<?php echo stripslashes($obj{"Evaluation_MFP_WB_status"});?>"/>
          <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="Falls Risks" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" 
     <?php if ($obj{"Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"} == "Falls Risks")  echo "checked";;?>/>
          <?php xl('Falls Risks','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="SOB" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" 
     <?php if ($obj{"Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"} == "SOB")  echo "checked";;?>/>
            <?php xl('SOB','e')?><br/><?php xl('Other','e')?>
            <strong>
            <input type="text" size="150px"  name="Evaluation_MFP_Other" id="Evaluation_MFP_Other" 
    value="<?php echo stripslashes($obj{"Evaluation_MFP_Other"});?>"/>
            <br />
            <?php xl('PRIOR LEVEL OF MOBILITY IN HOME','e')?>
            </strong>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Ambulated Independently" id="CheckboxGroup10_0" 
     <?php if ($obj{"Evaluation_Prior_level_Mobility_Home"} == "Ambulated Independently")  echo "checked";;?>/>
            <?php xl('Ambulated Independently','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Ambulated with assistive device" id="CheckboxGroup10_1" 
       <?php if ($obj{"Evaluation_Prior_level_Mobility_Home"} == "Ambulated with assistive device")  echo "checked";;?>/>
            <?php xl('Ambulated with assistive device','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Ambulated with assistance" id="CheckboxGroup10_2" 
       <?php if ($obj{"Evaluation_Prior_level_Mobility_Home"} == "Ambulated with assistance")  echo "checked";;?>/>
            <?php xl('Ambulated with assistance','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Ambulates on stairs" id="CheckboxGroup10_3" 
       <?php if ($obj{"Evaluation_Prior_level_Mobility_Home"} == "Ambulates on stairs")  echo "checked";;?>/>
            <?php xl('Ambulates on stairs','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Home" value="Wheelchair bound" id="CheckboxGroup10_4" 
       <?php if ($obj{"Evaluation_Prior_level_Mobility_Home"} == "Wheelchair bound")  echo "checked";;?>/>
            <?php xl('Wheelchair bound','e')?>
         <br/> 
            <?php xl('Other','e')?>
            <strong>
              <input type="text" name="Evaluation_Prior_level_Mobility_Other" id="Evaluation_Prior_level_Mobility_Other"  style="width:92%"
	value="<?php echo stripslashes($obj{"Evaluation_Prior_level_Mobility_Other"});?>"/>
              </strong><br />
            <?php xl('# Stairs to Enter Front of House','e')?>
            <strong>
              <input type="text" style="width:9%"  name="Evaluation_PLM_Stairs_Front_House" id="Evaluation_PLM_Stairs_Front_House" 
	value="<?php echo stripslashes($obj{"Evaluation_PLM_Stairs_Front_House"});?>"/>
              </strong>&nbsp;
            <?php xl('# Stairs to Enter Back of House','e')?>
            <strong>
              <input type="text" style="width:9%" name="Evaluation_PLM_Stairs_Back_House" id="Evaluation_PLM_Stairs_Back_House" 
	value="<?php echo stripslashes($obj{"Evaluation_PLM_Stairs_Back_House"});?>"/>
              </strong>&nbsp;<?php xl('# Stairs to Second Level','e')?>
            <strong>
              <input type="text" style="width:9%" name="Evaluation_PLM_Stairs_Second_Level" id="Evaluation_PLM_Stairs_Second_Level" 
	  value="<?php echo stripslashes($obj{"Evaluation_PLM_Stairs_Second_Level"});?>"/>
              <br />
              <?php xl('PRIOR LEVEL OF MOBILITY IN COMMUNITY','e')?></strong>
	    <input type="checkbox" name="Evaluation_Prior_level_Mobility_Community" value="Independent" id="CheckboxGroup10_5" 
	 <?php if ($obj{"Evaluation_Prior_level_Mobility_Community"} == "Independent")  echo "checked";;?>/>
            <?php xl('Independent','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Community" value="With Assistance" id="CheckboxGroup10_6" 
	 <?php if ($obj{"Evaluation_Prior_level_Mobility_Community"} == "With Assistance")  echo "checked";;?>/>
            <?php xl('With Assistance','e')?>
          
            <input type="checkbox" name="Evaluation_Prior_level_Mobility_Community" value="Unable" id="CheckboxGroup10_7" 
	 <?php if ($obj{"Evaluation_Prior_level_Mobility_Community"} == "Unable")  echo "checked";;?>/>
            <?php xl('Unable','e')?>
          <br />
      <strong>
	<?php xl('FAMILY/CAREGIVER SUPPORT','e')?></strong>
	<input type="checkbox" name="Evaluation_Family_Caregiver_Support" value="Yes" id="Evaluation_Family_Caregiver_Support" 
	 <?php if ($obj{"Evaluation_Family_Caregiver_Support"} == "Yes")  echo "checked";;?>/>
	<?php xl('Yes','e')?>
          
            <input type="checkbox" name="Evaluation_Family_Caregiver_Support" value="No" id="Evaluation_Family_Caregiver_Support" 
	 <?php if ($obj{"Evaluation_Family_Caregiver_Support"} == "No")  echo "checked";;?>/>
            <?php xl('No','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      
           <?php xl('Who','e')?> <strong>
              <input type="text" style="width:40%"  name="Evaluation_Family_Caregiver_Support_Who" id="Evaluation_Family_Caregiver_Support_Who" 
    value="<?php echo stripslashes($obj{"Evaluation_Family_Caregiver_Support_Who"});?>"/>
              </strong><br><?php xl('Previous # Visits into Community Weekly','e')?> <strong>
                <input type="text" name="Evaluation_FC_Visits_Community_Weekly" id="Evaluation_FC_Visits_Community_Weekly" 
      value="<?php echo stripslashes($obj{"Evaluation_FC_Visits_Community_Weekly"});?>"/>
                </strong><br />
            <?php xl('Additional Comments','e')?><strong>
              <input style="width:80%" type="text" name="Evaluation_FC_Additional_Comments" id="Evaluation_FC_Additional_Comments" 
	value="<?php echo stripslashes($obj{"Evaluation_FC_Additional_Comments"});?>"/>
            </strong></td>
      </tr>
    </table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong>
<?php xl('CURRENT MOBILITY STATUS','e')?> <br/><?php xl('Scale','e')?></strong>
<?php xl('U=Unable*, Dep=Dependent, Max=needs 75-51% assist, Mod=needs 50-26%, Min=needs 25-1% assist, CG=constant contact guard, SBA=stand by assist, S=supervised, needs cues, Mod I=Independent with assistive devices, Independent=no assist required','e')?>
</td></tr></table></td></tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>
        <td width="15%" align="center" scope="row"><strong><?php xl('TASK','e')?></strong>
          </th></td>
        <td width="10%" align="center"><strong><?php xl('STATUS','e')?></strong></td>
        <td width="30%" align="center"><strong><?php xl('TASK','e')?></strong></td>
        <td width="10%" align="center"><strong><?php xl('STATUS','e')?></strong></td>
        <td width="35%" align="center"><strong><?php xl('*COMMENTS','e')?></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('ROLLING RIGHT','e')?> </td>
        <td><strong><select id="Evaluation_CMS_ROLLING_RIGHT" name="Evaluation_CMS_ROLLING_RIGHT">
	<?php Mobility_status(stripslashes($obj{"Evaluation_CMS_ROLLING_RIGHT"})) ?></select></strong></td>
        <td><?php xl('SIT','e')?> <-> <?php xl('STAND','e')?></td>
        <td><strong><select id="Evaluation_CMS_SIT_STAND" name="Evaluation_CMS_SIT_STAND">
	<?php Mobility_status(stripslashes($obj{"Evaluation_CMS_SIT_STAND"})) ?></select></strong></td>
        <td rowspan="5" align="center">
	<textarea name="Evaluation_CMS_COMMENTS"  style="width: 315px; height: 115px;"  id="Evaluation_CMS_COMMENTS" cols="25" rows="5"><?php echo stripslashes($obj{"Evaluation_CMS_COMMENTS"});?></textarea></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('ROLLING LEFT','e')?></td>
        <td><strong><select id="Evaluation_CMS_ROLLING_LEFT" name="Evaluation_CMS_ROLLING_LEFT">
	<?php Mobility_status(stripslashes($obj{"Evaluation_CMS_ROLLING_LEFT"})) ?></select></strong></td>
        <td><?php xl('BED/CHAIR TRANSFERS','e')?></td>
        <td><strong><select id="Evaluation_CMS_BED_CHAIR_TRANSFERS" name="Evaluation_CMS_BED_CHAIR_TRANSFERS">
	<?php Mobility_status(stripslashes($obj{"Evaluation_CMS_BED_CHAIR_TRANSFERS"})) ?></select></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('BRIDGING/SCOOT','e')?></td>
        <td><strong><select id="Evaluation_CMS_BRIDGING_SCOOT" name="Evaluation_CMS_BRIDGING_SCOOT">
	<?php Mobility_status(stripslashes($obj{"Evaluation_CMS_BRIDGING_SCOOT"})) ?></select></strong></td>
        <td><?php xl('TOILET TRANSFERS','e')?></td>
        <td><strong><select id="Evaluation_CMS_TOILET_TRANSFERS" name="Evaluation_CMS_TOILET_TRANSFERS">
	<?php Mobility_status(stripslashes($obj{"Evaluation_CMS_TOILET_TRANSFERS"})) ?></select></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('SUPINE','e')?> <-><?php xl('SIT','e')?></td>
        <td><strong><select id="Evaluation_CMS_SUPINE_SIT" name="Evaluation_CMS_SUPINE_SIT">
	<?php Mobility_status(stripslashes($obj{"Evaluation_CMS_SUPINE_SIT"})) ?></select></strong></td>
        <td><?php xl('Other','e')?> <input type="text" style="width:80%" id="Evaluation_CMS_Other_text" name="Evaluation_CMS_Other_text" value="<?php echo stripslashes($obj{"Evaluation_CMS_Other_text"}) ?>"></td>
        <td><strong><select id="Evaluation_CMS_Other" name="Evaluation_CMS_Other">
	<?php Mobility_status(stripslashes($obj{"Evaluation_CMS_Other"})) ?></select></strong></td>
      </tr>     
  </table>    
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('GAIT SKILLS','e')?>
        <input type="checkbox" name="Evaluation_GAIT_SKILLS" id="Evaluation_GAIT_SKILLS" 
	<?php if ($obj{"Evaluation_GAIT_SKILLS"} == "on")  echo "checked";;?>/>
        <?php xl('Not Applicable, Patient Does Not Ambulate','e')?>
      </strong></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('Assistance','e')?></strong>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Dep" id="Evaluation_GS_Assistance" 
    <?php if ($obj{"Evaluation_GS_Assistance"} == "Dep")  echo "checked";;?>/>
          <?php xl('Dep','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Max Assist" id="Evaluation_GS_Assistance" 
    <?php if ($obj{"Evaluation_GS_Assistance"} == "Max Assist")  echo "checked";;?>/>
          <?php xl('Max Assist','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Mod Assist" id="Evaluation_GS_Assistance" 
    <?php if ($obj{"Evaluation_GS_Assistance"} == "Mod Assist")  echo "checked";;?>/>
          <?php xl('Mod Assist','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Min Assist" id="Evaluation_GS_Assistance" 
    <?php if ($obj{"Evaluation_GS_Assistance"} == "Min Assist")  echo "checked";;?>/>
          <?php xl('Min Assist','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="CGA" id="Evaluation_GS_Assistance"
    <?php if ($obj{"Evaluation_GS_Assistance"} == "CGA")  echo "checked";;?>/>
          <?php xl('CGA','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="SBA" id="Evaluation_GS_Assistance" 
    <?php if ($obj{"Evaluation_GS_Assistance"} == "SBA")  echo "checked";;?>/>
          <?php xl('SBA','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Supervised" id="Evaluation_GS_Assistance" 
    <?php if ($obj{"Evaluation_GS_Assistance"} == "Supervised")  echo "checked";;?>/>
          <?php xl('Supervised','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Mod I" id="Evaluation_GS_Assistance" 
    <?php if ($obj{"Evaluation_GS_Assistance"} == "Mod I")  echo "checked";;?>/>
          <?php xl('Mod I','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistance" value="Independent" id="Evaluation_GS_Assistance" 
    <?php if ($obj{"Evaluation_GS_Assistance"} == "Independent")  echo "checked";;?>/>
          <?php xl('Independent','e')?>
        <br />
      <strong>  <?php xl('Distance/Time','e')?></strong>

        <input type="text" id="Evaluation_GS_Distance_Time" name="Evaluation_GS_Distance_Time" 
      value="<?php echo stripslashes($obj{"Evaluation_GS_Distance_Time"});?>"/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><?php xl('Surfaces','e')?></strong>
      
          <input type="checkbox" name="Evaluation_GS_Surfaces" value="Level" id="Evaluation_GS_Surfaces" 
    <?php if ($obj{"Evaluation_GS_Surfaces"} == "Level")  echo "checked";;?>/>
          <?php xl('Level','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Surfaces" value="Uneven" id="Evaluation_GS_Surfaces" 
    <?php if ($obj{"Evaluation_GS_Surfaces"} == "Uneven")  echo "checked";;?>/>
          <?php xl('Uneven','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Surfaces" value="Stairs" id="Evaluation_GS_Surfaces" 
    <?php if ($obj{"Evaluation_GS_Surfaces"} == "Stairs")  echo "checked";;?>/>
          <?php xl('Stairs','e')?>
        <br />
       <strong><?php xl('Assistive Devices','e')?></strong>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="None" id="Evaluation_GS_Assistive_Devices" 
    <?php if ($obj{"Evaluation_GS_Assistive_Devices"} == "None")  echo "checked";;?>/>
          <?php xl('None','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="SP Cane" id="Evaluation_GS_Assistive_Devices" 
    <?php if ($obj{"Evaluation_GS_Assistive_Devices"} == "SP Cane")  echo "checked";;?>/>
          <?php xl('SP Cane','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="Quad Cane" id="Evaluation_GS_Assistive_Devices" 
    <?php if ($obj{"Evaluation_GS_Assistive_Devices"} == "Quad Cane")  echo "checked";;?>/>
          <?php xl('Quad Cane','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="Front-Wheel Walker" id="Evaluation_GS_Assistive_Devices" 
    <?php if ($obj{"Evaluation_GS_Assistive_Devices"} == "Front-Wheel Walker")  echo "checked";;?>/>
          <?php xl('Front-Wheel Walker','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="Four Wheeled Walker" id="Evaluation_GS_Assistive_Devices" 
    <?php if ($obj{"Evaluation_GS_Assistive_Devices"} == "Four Wheeled Walker")  echo "checked";;?>/>
          <?php xl('Four Wheeled Walker','e')?>
        
          <input type="checkbox" name="Evaluation_GS_Assistive_Devices" value="Standard Walker" id="Evaluation_GS_Assistive_Devices" 
    <?php if ($obj{"Evaluation_GS_Assistive_Devices"} == "Standard Walker")  echo "checked";;?>/>
          <?php xl('Standard Walker','e')?>
       <br />
        <?php xl('Other','e')?>       
        <input type="text" style="width:93%"  name="Evaluation_GS_Assistive_Devices_Other" id="Evaluation_GS_Assistive_Devices_Other" 
    value="<?php echo stripslashes($obj{"Evaluation_GS_Assistive_Devices_Other"});?>"/>
        <br />
        <strong><?php xl('Gait Deviations','e')?></strong> <?php xl('(E.g. Posture, Stride Length, Cadence, Foot Placement, Weight Shift)','e')?>
      <br/>
       <input type="text" style="width:98%"  id="Evaluation_GS_Gait_Deviations" name="Evaluation_GS_Gait_Deviations"  
    value="<?php echo stripslashes($obj{"Evaluation_GS_Gait_Deviations"});?>"/></td></tr></table></td></tr>
      <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td>
	<strong><?php xl('WHEELCHAIR SKILLS','e')?></strong>
      <input type="checkbox" name="Evaluation_WHEELCHAIR_SKILLS" id="Evaluation_WHEELCHAIR_SKILLS" 
      <?php if ($obj{"Evaluation_WHEELCHAIR_SKILLS"} == "on")  echo "checked";;?>/>
      <?php xl('Not Applicable, Patient Ambulates','e')?>
  </strong></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td>
  <strong> <?php xl('Assistance','e')?> </strong>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Dep" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "Dep")  echo "checked";;?>/>
        <?php xl('Dep','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Max Assist" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "Max Assist")  echo "checked";;?>/>
        <?php xl('Max Assist','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Mod Assist" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "Mod Assist")  echo "checked";;?>/>
        <?php xl('Mod Assist','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Min Assist" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "Min Assist")  echo "checked";;?>/>
        <?php xl('Min Assist','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="CGA" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "CGA")  echo "checked";;?>/>
        <?php xl('CGA','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="SBA" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "SBA")  echo "checked";;?>/>
        <?php xl('SBA','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Supervised" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "Supervised")  echo "checked";;?>/>
        <?php xl('Supervised','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Mod I" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "Mod I")  echo "checked";;?>/>
        <?php xl('Mod I','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Assistance" value="Independent" id="Evaluation_WS_Assistance" 
	   <?php if ($obj{"Evaluation_WS_Assistance"} == "Independent")  echo "checked";;?>/>
        <?php xl('Independent','e')?>
      <br />
      <strong> <?php xl('Distance/Time','e')?></strong>
      <input type="text" id="Evaluation_WS_Distance_Time" name="Evaluation_WS_Distance_Time" 
    value="<?php echo stripslashes($obj{"Evaluation_WS_Distance_Time"});?>"/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('Surfaces','e')?></strong>
      
        <input type="checkbox" name="Evaluation_WS_Surfaces" value="Level" id="Evaluation_WS_Surfaces" 
	   <?php if ($obj{"Evaluation_WS_Surfaces"} == "Level")  echo "checked";;?>/>
        <?php xl('Level','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Surfaces" value="Uneven" id="Evaluation_WS_Surfaces" 
	   <?php if ($obj{"Evaluation_WS_Surfaces"} == "Uneven")  echo "checked";;?>/>
        <?php xl('Uneven','e')?>      
     <br>
        <?php xl('Other','e')?>
        <input type="text" style="width:35%" id="Evaluation_WS_Surfaces_other" name="Evaluation_WS_Surfaces_other" 
     value="<?php echo stripslashes($obj{"Evaluation_WS_Surfaces_other"});?>"/>
        <br />
        <strong> <?php xl('Patient Can Remove Footrests','e')?></strong> 
      
        <input type="checkbox" name="Evaluation_WS_Remove_Footrests" value="Yes" id="Evaluation_WS_Remove_Footrests" 
     <?php if ($obj{"Evaluation_WS_Remove_Footrests"} == "Yes")  echo "checked";;?>/>
         <?php xl('Yes','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Remove_Footrests" value="No" id="Evaluation_WS_Remove_Footrests" 
     <?php if ($obj{"Evaluation_WS_Remove_Footrests"} == "No")  echo "checked";;?>/>
         <?php xl('No','e')?>            
 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong> <?php xl('Remove Armrests','e')?> </strong>
      
        <input type="checkbox" name="Evaluation_WS_Remove_Armrests" value="Yes" id="Evaluation_WS_Remove_Armrests" 
     <?php if ($obj{"Evaluation_WS_Remove_Armrests"} == "Yes")  echo "checked";;?>/>
        <?php xl('Yes','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Remove_Armrests" value="No" id="Evaluation_WS_Remove_Armrests" 
     <?php if ($obj{"Evaluation_WS_Remove_Armrests"} == "No")  echo "checked";;?>/>
        <?php xl('No','e')?>             
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><?php xl('Reposition in W/C','e')?></strong>
      <input type="checkbox" name="Evaluation_WS_Reposition_WC" value="Yes" id="Evaluation_WS_Reposition_WC" 
     <?php if ($obj{"Evaluation_WS_Reposition_WC"} == "Yes")  echo "checked";;?>/>
        <?php xl('Yes','e')?>
      
        <input type="checkbox" name="Evaluation_WS_Reposition_WC" value="No" id="Evaluation_WS_Reposition_WC" 
     <?php if ($obj{"Evaluation_WS_Reposition_WC"} == "No")  echo "checked";;?>/>
        <?php xl('No','e')?>  <br />
     <strong><?php xl('Posture/Alignment in Chair','e')?></strong> 
     
       <input type="checkbox" name="Evaluation_WS_Posture_Alignment_Chair" value="Normal" id="Evaluation_WS_Posture_Alignment_Chair" 
<?php if ($obj{"Evaluation_WS_Posture_Alignment_Chair"} == "Normal")  echo "checked";;?>/>
       <?php xl('Normal','e')?>
     
       <input type="checkbox" name="Evaluation_WS_Posture_Alignment_Chair" value="Kyphosis" id="Evaluation_WS_Posture_Alignment_Chair" 
<?php if ($obj{"Evaluation_WS_Posture_Alignment_Chair"} == "Kyphosis")  echo "checked";;?>/>
      <?php xl('Kyphosis','e')?>
     <input type="checkbox" name="Evaluation_WS_Posture_Alignment_Chair" value="Lordosis" id="Evaluation_WS_Posture_Alignment_Chair" 
<?php if ($obj{"Evaluation_WS_Posture_Alignment_Chair"} == "Lordosis")  echo "checked";;?>/>
      <?php xl('Lordosis','e')?><br />
      <?php xl('Other','e')?>
    <input type="text" style="width:93%"  name="Evaluation_WS_Other" id="Evaluation_WS_Other" 
    value="<?php echo stripslashes($obj{"Evaluation_WS_Other"});?>"/>
    </td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
      <tr>
        <td><strong><?php xl('COGNITION','e')?></strong></td>
      </tr>
      <tr><td><input type="checkbox" name="Evaluation_COG_Alert_type" value="Alert" id="Evaluation_COG_Alert_type" 
    <?php if ($obj{"Evaluation_COG_Alert_type"} == "Alert")  echo "checked";;?>/>
      <?php xl('Alert','e')?>
	<input type="checkbox" name="Evaluation_COG_Alert_type" value="Not Alert" id="Evaluation_COG_Alert_type" 
  <?php if ($obj{"Evaluation_COG_Alert_type"} == "Not Alert")  echo "checked";;?>/>
	<?php xl('Not Alert','e')?>  
    &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
<strong> <?php xl('Oriented to','e')?> </strong> 
      <input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Person" id="Evaluation_COG_Oriented_Type" 
  <?php if ($obj{"Evaluation_COG_Oriented_Type"} == "Person")  echo "checked";;?>/>
      <?php xl('Person','e')?>
      <input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Place" id="Evaluation_COG_Oriented_Type" 
  <?php if ($obj{"Evaluation_COG_Oriented_Type"} == "Place")  echo "checked";;?>/>
      <?php xl('Place','e')?>
	<input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Date" id="Evaluation_COG_Oriented_Type" 
  <?php if ($obj{"Evaluation_COG_Oriented_Type"} == "Date")  echo "checked";;?>/>
	<?php xl('Date','e')?>
	<input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Reason for Therapy" id="Evaluation_COG_Oriented_Type" 
<?php if ($obj{"Evaluation_COG_Oriented_Type"} == "Reason for Therapy")  echo "checked";;?>/>
      <?php xl('Reason for Therapy','e')?><br />
<strong> <?php xl('Can Follow','e')?> </strong>
      <input type="checkbox" name="Evaluation_COG_Canfollow" value="1" id="Evaluation_COG_Canfollow" 
<?php if ($obj{"Evaluation_COG_Canfollow"} == "1")  echo "checked";;?>/>
	<?php xl('1','e')?>
      <input type="checkbox" name="Evaluation_COG_Canfollow" value="2" id="Evaluation_COG_Canfollow" 
<?php if ($obj{"Evaluation_COG_Canfollow"} == "2")  echo "checked";;?>/>
      <?php xl('2','e')?>
      <input type="checkbox" name="Evaluation_COG_Canfollow" value="3" id="Evaluation_COG_Canfollow" 
<?php if ($obj{"Evaluation_COG_Canfollow"} == "3")  echo "checked";;?>/>
      <?php xl('3','e')?>    
     <?php xl('or more Step-Directions','e')?> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<strong> <?php xl('Safety Awareness','e')?> </strong>
     <input type="checkbox" name="Evaluation_COG_Safety_Awareness" value="Good" id="Evaluation_COG_Safety_Awareness" 
<?php if ($obj{"Evaluation_COG_Safety_Awareness"} == "Good")  echo "checked";;?>/> 
     <?php xl('Good','e')?>
     <input type="checkbox" name="Evaluation_COG_Safety_Awareness" value="Fair" id="Evaluation_COG_Safety_Awareness" 
<?php if ($obj{"Evaluation_COG_Safety_Awareness"} == "Fair")  echo "checked";;?>/>
      <?php xl('Fair','e')?>
      <input type="checkbox" name="Evaluation_COG_Safety_Awareness" value="Poor" id="Evaluation_COG_Safety_Awareness" 
<?php if ($obj{"Evaluation_COG_Safety_Awareness"} == "Poor")  echo "checked";;?>/>
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
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Endurance" id="Evaluation_Mis_skil_Endurance" value="Good" <?php if ($obj{"Evaluation_Mis_skil_Endurance"} == "Good") echo "checked"; ?>/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Endurance" id="Evaluation_Mis_skil_Endurance" value="Fair" <?php if ($obj{"Evaluation_Mis_skil_Endurance"} == "Fair")  echo "checked"; ?>/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Endurance" id="Evaluation_Mis_skil_Endurance" value="Poor" <?php if ($obj{"Evaluation_Mis_skil_Endurance"} == "Poor")  echo "checked"; ?>/></td>

<td><?php xl('HEARING','e')?></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Hearing" id="Evaluation_Mis_skil_Hearing" value="Good" <?php if ($obj{"Evaluation_Mis_skil_Hearing"} == "Good")  echo "checked"; ?>/></td>
<td align="center"><input type="radio" name="Evaluation_Mis_skil_Hearing" id="Evaluation_Mis_skil_Hearing" value="Fair" <?php if ($obj{"Evaluation_Mis_skil_Hearing"} == "Fair")  echo "checked"; ?>/></td>
<td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Hearing" id="Evaluation_Mis_skil_Hearing" value="Poor" <?php if ($obj{"Evaluation_Mis_skil_Hearing"} == "Poor")  echo "checked"; ?>/></td>
</tr>

<tr>
<td scope="row"><?php xl('COMMUNICATION','e')?></td>
<td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Communication" id="Evaluation_Mis_skil_Communication" value="Good" <?php if ($obj{"Evaluation_Mis_skil_Communication"} == "Good")  echo "checked"; ?>/></td>
<td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Communication" id="Evaluation_Mis_skil_Communication" value="Fair" <?php if ($obj{"Evaluation_Mis_skil_Communication"} == "Fair")  echo "checked"; ?>/></td>
<td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Communication" id="Evaluation_Mis_skil_Communication" value="Poor" <?php if ($obj{"Evaluation_Mis_skil_Communication"} == "Poor")  echo "checked"; ?>/></td>

<td><?php xl('VISION','e')?></td>
<td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Vision" id="Evaluation_Mis_skil_Vision" value="Good" <?php if ($obj{"Evaluation_Mis_skil_Vision"} == "Good")  echo "checked"; ?>/></td>
<td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Vision" id="Evaluation_Mis_skil_Vision" value="Fair" <?php if ($obj{"Evaluation_Mis_skil_Vision"} == "Fair")  echo "checked"; ?>/></td>
<td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Vision" id="Evaluation_Mis_skil_Vision" value="Poor" <?php if ($obj{"Evaluation_Mis_skil_Vision"} == "Poor")  echo "checked"; ?>/></td>
</tr>

</table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td>
    <strong><?php xl('CURRENT BALANCE SKILLS','e')?><br/><?php xl('Scale','e')?> </strong>
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
      <?php Balance_skills(stripslashes($obj{"Evaluation_CB_Skills_Dynamic_Sitting"})) ?></select></strong></td>
        <td><?php xl('DYNAMIC STANDING BALANCE','e')?></td>
        <td><strong><select id="Evaluation_CB_Skills_Dynamic_Standing" name="Evaluation_CB_Skills_Dynamic_Standing">
	  <?php Balance_skills(stripslashes($obj{"Evaluation_CB_Skills_Dynamic_Standing"})) ?></select></strong></td>
        </tr>
      <tr>
        <td scope="row"><?php xl('STATIC SITTING BALANCE','e')?></td>
        <td><strong><select id="Evaluation_CB_Skills_Static_Sitting" name="Evaluation_CB_Skills_Static_Sitting">
	<?php Balance_skills(stripslashes($obj{"Evaluation_CB_Skills_Static_Sitting"})) ?></select></strong></td>
        <td><?php xl('STATIC STANDING BALANCE','e')?></td>
        <td><strong><select id="Evaluation_CB_Skills_Static_Standing" name="Evaluation_CB_Skills_Static_Standing">
	 <?php Balance_skills(stripslashes($obj{"Evaluation_CB_Skills_Static_Standing"})) ?></select></strong></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%"  border="0px" cellspacing="0px" cellpadding="5px" class="formtable">
	<tr><td><strong><?php xl('MUSCLE STRENGTH/FUNCTIONAL ROM EVALUATION','e')?><br />
      <input type="checkbox" name="Evaluation_MS_ROM_All_Muscle_WFL" value="All Muscle Strength is WFL" id="Evaluation_MS_ROM_All_Muscle_WFL" 
<?php if ($obj{"Evaluation_MS_ROM_All_Muscle_WFL"} == "All Muscle Strength is WFL")  echo "checked";;?>/>
      <?php xl('All Muscle Strength is WFL','e')?> &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="Evaluation_MS_ROM_All_Muscle_WFL" value="All ROM is WFL" id="Evaluation_MS_ROM_All_Muscle_WFL" 
<?php if ($obj{"Evaluation_MS_ROM_All_Muscle_WFL"} == "All ROM is WFL")  echo "checked";;?>/>
    <?php xl('All ROM is WFL','e')?> &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="checkbox" name="Evaluation_MS_ROM_All_Muscle_WFL" value="other Problem" id="Evaluation_MS_ROM_All_Muscle_WFL" 
<?php if ($obj{"Evaluation_MS_ROM_All_Muscle_WFL"} == "other Problem")  echo "checked";;?>/>
    <?php xl('The following problem areas are','e')?> &nbsp;
<input type="text" style="width:22%"  name="Evaluation_MS_ROM_Following_Problem_areas" id="Evaluation_MS_ROM_Following_Problem_areas" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Following_Problem_areas"});?>"/>
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
      <input type="text" name="Evaluation_MS_ROM_Problemarea_text" id="Evaluation_MS_ROM_Problemarea_text" 
 value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Problemarea_text"});?>" size="35px" /></td>

        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right" id="Evaluation_MS_ROM_STRENGTH_Right" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Right"});?>"/>
          <?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left" id="Evaluation_MS_ROM_STRENGTH_Left" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Left"});?>"/>
	<?php xl('/ 5','e')?></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM" id="Evaluation_MS_ROM_ROM" value="Right"
 <?php if ($obj{"Evaluation_MS_ROM_ROM"} == "Right")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM" id="Evaluation_MS_ROM_ROM" value="Left" 
<?php if ($obj{"Evaluation_MS_ROM_ROM"} == "Left")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_ROM_Type" value="P" 
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type"} == "P")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_ROM_Type" value="AA" 
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type"} == "AA")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_ROM_Type" value="A" 
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type"} == "A")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity" id="Evaluation_MS_ROM_Tonicity" value="Hyper" 
<?php if ($obj{"Evaluation_MS_ROM_Tonicity"} == "Hyper")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity" id="Evaluation_MS_ROM_Tonicity" value="Hypo" 
<?php if ($obj{"Evaluation_MS_ROM_Tonicity"} == "Hypo")  echo "checked";;?>/></td>
        <td align="center" rowspan="4">
       <textarea name="Evaluation_MS_ROM_Further_description" id="Evaluation_MS_ROM_Further_description" cols="35" rows="10"><?php echo stripslashes($obj{"Evaluation_MS_ROM_Further_description"});?></textarea>
        </tr>
      <tr>
        <td align="center" scope="row"><input type="text" name="Evaluation_MS_ROM_Problemarea_text1" id="Evaluation_MS_ROM_Problemarea_text1" size="35px"
 value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Problemarea_text1"});?>"/></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right1" id="Evaluation_MS_ROM_STRENGTH_Right1" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Right1"});?>"/>
	<?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left1" id="Evaluation_MS_ROM_STRENGTH_Left1" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Left1"});?>"/>
	<?php xl('/ 5','e')?></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM1" id="Evaluation_MS_ROM_ROM1" value="Right" 
<?php if ($obj{"Evaluation_MS_ROM_ROM1"} == "Right")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM1" id="Evaluation_MS_ROM_ROM1" value="Left" 
<?php if ($obj{"Evaluation_MS_ROM_ROM1"} == "Left")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="P" 
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type1"} == "P")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="AA" 
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type1"} == "AA")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="A" 
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type1"} == "A")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity1" id="Evaluation_MS_ROM_Tonicity1" value="Hyper" 
<?php if ($obj{"Evaluation_MS_ROM_Tonicity1"} == "Hyper")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity1" id="Evaluation_MS_ROM_Tonicity1" value="Hypo" 
<?php if ($obj{"Evaluation_MS_ROM_Tonicity1"} == "Hypo")  echo "checked";;?>/></td>
        </tr>
      <tr>
        <td align="center" scope="row"><input type="text" name="Evaluation_MS_ROM_Problemarea_text2" id="Evaluation_MS_ROM_Problemarea_text2" size="35px"
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Problemarea_text2"});?>"/></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right2" id="Evaluation_MS_ROM_STRENGTH_Right2" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Right2"});?>"/>
      <?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left2" id="Evaluation_MS_ROM_STRENGTH_Left2" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Left2"});?>"/>
	<?php xl('/ 5','e')?></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM2" id="Evaluation_MS_ROM_ROM2" value="Right" 
<?php if ($obj{"Evaluation_MS_ROM_ROM2"} == "Right")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM2" id="Evaluation_MS_ROM_ROM2" value="Left"  
<?php if ($obj{"Evaluation_MS_ROM_ROM2"} == "Left")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="P" 
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type2"} == "P")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="AA"  
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type2"} == "AA")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="A"  
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type2"} == "A")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity2" id="Evaluation_MS_ROM_Tonicity2" value="Hyper"  
<?php if ($obj{"Evaluation_MS_ROM_Tonicity2"} == "Hyper")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity2" id="Evaluation_MS_ROM_Tonicity2" value="Hypo"  
<?php if ($obj{"Evaluation_MS_ROM_Tonicity2"} == "Hypo")  echo "checked";;?>/></td>
        </tr>
      <tr>
        <td align="center" scope="row">
	<input type="text" name="Evaluation_MS_ROM_Problemarea_text3" id="Evaluation_MS_ROM_Problemarea_text3" size="35px"
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Problemarea_text3"});?>"/></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right3" id="Evaluation_MS_ROM_STRENGTH_Right3" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Right3"});?>"/>
	<?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left3" id="Evaluation_MS_ROM_STRENGTH_Left3" 
value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Left3"});?>"/>
	<?php xl('/ 5','e')?></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM3" id="Evaluation_MS_ROM_ROM3" value="Right" 
<?php if ($obj{"Evaluation_MS_ROM_ROM3"} == "Right")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM3" id="Evaluation_MS_ROM_ROM3" value="Left"  
<?php if ($obj{"Evaluation_MS_ROM_ROM3"} == "Left")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="P"  
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type3"} == "P")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="AA"  
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type3"} == "AA")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="A"  
<?php if ($obj{"Evaluation_MS_ROM_ROM_Type3"} == "A")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity3" id="Evaluation_MS_ROM_Tonicity3" value="Hyper"  
<?php if ($obj{"Evaluation_MS_ROM_Tonicity3"} == "Hyper")  echo "checked";;?>/></td>
        <td align="center">
	<input type="checkbox" name="Evaluation_MS_ROM_Tonicity3" id="Evaluation_MS_ROM_Tonicity3" value="Hypo"  
<?php if ($obj{"Evaluation_MS_ROM_Tonicity3"} == "Hypo")  echo "checked";;?>/></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%"  border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td> <strong><?php xl('Comments','e')?>
        <input type="text" style="width:85%"  name="Evaluation_MS_ROM_Comments" id="Evaluation_MS_ROM_Comments" 
 value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Comments"});?>"/>
      </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><strong><?php xl('ENVIRONMENTAL BARRIERS/SAFETY ISSUES (Check all that apply)','e')?></strong></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>

        <td scope="row">
	<input type="checkbox" name="Evaluation_EnvBar_No_barriers" id="Evaluation_EnvBar_No_barriers"  
<?php if ($obj{"Evaluation_EnvBar_No_barriers"} == "on")  echo "checked";;?>/>
          <?php xl('No environmental barriers in home','e')?>
            <input type="checkbox" name="Evaluation_EnvBar_No_Safety_Issues" id="Evaluation_EnvBar_No_Safety_Issues"  
<?php if ($obj{"Evaluation_EnvBar_No_Safety_Issues"} == "on")  echo "checked";;?>/>
            <?php xl('No safety issues in home','e')?>
            <input type="checkbox" name="Evaluation_EnvBar_Bedroom_On_Second" id="Evaluation_EnvBar_Bedroom_On_Second" 
<?php if ($obj{"Evaluation_EnvBar_Bedroom_On_Second"} == "on")  echo "checked";;?>/>
            <?php xl('Bedroom on second floor','e')?> 
            <input type="checkbox" name="Evaluation_EnvBar_No_Inadequate_grab" id="Evaluation_EnvBar_No_Inadequate_grab"  
<?php if ($obj{"Evaluation_EnvBar_No_Inadequate_grab"} == "on")  echo "checked";;?>/>
            <?php xl('No or inadequate grab bars in bathroom/shower','e')?>
            <input type="checkbox" name="Evaluation_EnvBar_Throw_Rugs" id="Evaluation_EnvBar_Throw_Rugs" 
<?php if ($obj{"Evaluation_EnvBar_Throw_Rugs"} == "on")  echo "checked";;?>/>
	    <?php xl('Throw rugs in rooms','e')?>
	<input type="checkbox" name="Evaluation_EnvBar_No_Inadequate_smoke" id="Evaluation_EnvBar_No_Inadequate_smoke"  
<?php if ($obj{"Evaluation_EnvBar_No_Inadequate_smoke"} == "on")  echo "checked";;?>/>
	    <?php xl('No or inadequate smoke alarms','e')?>          
            <input type="checkbox" name="Evaluation_EnvBar_No_Emergency_Numbers" id="Evaluation_EnvBar_No_Emergency_Numbers" 
<?php if ($obj{"Evaluation_EnvBar_No_Emergency_Numbers"} == "on")  echo "checked";;?>/>
            <?php xl('No emergency numbers available','e')?>         
            <input type="checkbox" name="Evaluation_EnvBar_Lighting_Not_Adequate" id="Evaluation_EnvBar_Lighting_Not_Adequate" 
<?php if ($obj{"Evaluation_EnvBar_Lighting_Not_Adequate"} == "on")  echo "checked";;?>/>
            
	    <?php xl('Lighting is not adequate for safe mobility in home','e')?>
	    <input type="checkbox" name="Evaluation_EnvBar_No_Handrails" id="Evaluation_EnvBar_No_Handrails"  
<?php if ($obj{"Evaluation_EnvBar_No_Handrails"} == "on")  echo "checked";;?>/>
	    <?php xl('No handrails for stairs','e')?>
	    <input type="checkbox" name="Evaluation_EnvBar_Stairs_Disrepair" id="Evaluation_EnvBar_Stairs_Disrepair" 
<?php if ($obj{"Evaluation_EnvBar_Stairs_Disrepair"} == "on")  echo "checked";;?>/>
	    <?php xl('Stairs are in disrepair','e')?>
	    <input type="checkbox" name="Evaluation_EnvBar_Fire_Extinguishers" id="Evaluation_EnvBar_Fire_Extinguishers" 
<?php if ($obj{"Evaluation_EnvBar_Fire_Extinguishers"} == "on")  echo "checked";;?>/>
	    <?php xl('Fire extinguishers are not available','e')?>
<br/><?php xl('Other','e')?> 
	    <input type="text" style="width:90%"  size="46px" name="Evaluation_EnvBar_Other" id="Evaluation_EnvBar_Other" 
 value="<?php echo stripslashes($obj{"Evaluation_EnvBar_Other"});?>"/></td>
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
      <input type="checkbox" name="Evaluation_Summary_PT_Evaluation_Only" id="Evaluation_Summary_PT_Evaluation_Only"  
<?php if ($obj{"Evaluation_Summary_PT_Evaluation_Only"} == "on")  echo "checked";;?>/>
    <?php xl('PT Evaluation only. No further indications of service','e')?>
        <br />
        <input type="checkbox" name="Evaluation_Summary_Need_physician_Orders" id="Evaluation_Summary_Need_physician_Orders"  
<?php if ($obj{"Evaluation_Summary_Need_physician_Orders"} == "on")  echo "checked";;?>/>
    <?php xl('Need physician orders for PT services with specific treatments, frequency, and duration. See OT Care Plan and/or 485','e')?><br />
    <input type="checkbox" name="Evaluation_Summary_Received_Physician_Orders" id="Evaluation_Summary_Received_Physician_Orders" 
<?php if ($obj{"Evaluation_Summary_Received_Physician_Orders"} == "on")  echo "checked";;?>/>
    <?php xl('Received physician orders for PT treatment and approximate next visit date will be','e')?>
    <input type="text" style="width:10%" name="Evaluation_approximate_next_visit_date" id="Evaluation_approximate_next_visit_date" 
 value="<?php echo stripslashes($obj{"Evaluation_approximate_next_visit_date"});?>" title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_onset_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"Evaluation_approximate_next_visit_date", ifFormat:"%Y-%m-%d", button:"img_onset_date"});
   </script>
</td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('PT Care Plan and Evaluation was communicated to and agreed upon by','e')?></strong>
        <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Patient" id="Evaluation_PT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_PT_Evaulation_Communicated_Agreed"} == "Patient")  echo "checked";;?>/>
    <?php xl('Patient','e')?>
  <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Physician" id="Evaluation_PT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_PT_Evaulation_Communicated_Agreed"} == "Physician")  echo "checked";;?>/>
    <?php xl('Physician','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="PT/ST" id="Evaluation_PT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_PT_Evaulation_Communicated_Agreed"} == "PT/ST")  echo "checked";;?>/>
      <?php xl('PT/ST','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="COTA" id="Evaluation_PT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_PT_Evaulation_Communicated_Agreed"} == "COTA")  echo "checked";;?>/>
    <?php xl('PTA','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Skilled Nursing" id="Evaluation_PT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_PT_Evaulation_Communicated_Agreed"} == "Skilled Nursing")  echo "checked";;?>/>
    <?php xl('Skilled Nursing','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Caregiver/Family" id="Evaluation_PT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_PT_Evaulation_Communicated_Agreed"} == "Caregiver/Family")  echo "checked";;?>/>
    <?php xl('Caregiver/Family','e')?>
    <input type="checkbox" name="Evaluation_PT_Evaulation_Communicated_Agreed" value="Case Manager" id="Evaluation_PT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_PT_Evaulation_Communicated_Agreed"} == "Case Manager")  echo "checked";;?>/>
    <?php xl('Case Manager Others','e')?>
    <input type="text" size="77px" name="Evaluation_PT_Evaulation_Communicated_other" id="Evaluation_PT_Evaulation_Communicated_other"  
 value="<?php echo stripslashes($obj{"Evaluation_PT_Evaulation_Communicated_other"});?>"/></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('ADDITIONAL SERVICES PROVIDED','e')?>
      </strong>
        <input type="checkbox" name="Evaluation_ASP_Home_Exercise_Initiated" id="Evaluation_ASP_Home_Exercise_Initiated"  
<?php if ($obj{"Evaluation_ASP_Home_Exercise_Initiated"} == "on")  echo "checked";;?>/>
    <?php xl('Home Exercise Program Initiated','e')?>
    <input type="checkbox" name="Evaluation_ASP_Falls_Management_Discussed" id="Evaluation_ASP_Falls_Management_Discussed" 
<?php if ($obj{"Evaluation_ASP_Falls_Management_Discussed"} == "on")  echo "checked";;?>/>
    <?php xl('Falls Management Discussed','e')?>
    <input type="checkbox" name="Evaluation_ASP_Safety_Issues_Discussed" id="Evaluation_ASP_Safety_Issues_Discussed"  
<?php if ($obj{"Evaluation_ASP_Safety_Issues_Discussed"} == "on")  echo "checked";;?>/>
    <?php xl('Recommendations for Safety Issues Discussed','e')?>
    <input type="checkbox" name="Evaluation_ASP_Treatment_For" id="Evaluation_ASP_Treatment_For"  
<?php if ($obj{"Evaluation_ASP_Treatment_For"} == "on")  echo "checked";;?>/>
    <?php xl('Treatment for','e')?>
      <input type="text" size="88px" name="Evaluation_ASP_Treatment_For_text" id="Evaluation_ASP_Treatment_For_text" 
value="<?php echo stripslashes($obj{"Evaluation_ASP_Treatment_For_text"});?>"/> 
       <?php xl('Initiated','e')?>
<br/><?php xl('Other','e')?>
      <input type="text" style="width:92%" name="Evaluation_ASP_Other" id="Evaluation_ASP_Other"  
value="<?php echo stripslashes($obj{"Evaluation_ASP_Other"});?>"/> </td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
      <td><strong><?php xl('Skilled PT is Reasonable and Necessary to','e')?></strong>
            <br />
            <input type="checkbox" name="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" id="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" 
value="Return to Prior Level" <?php if ($obj{"Evaluation_Skilled_PT_Reasonable_And_Necessary_To"} == "Return to Prior Level")  echo "checked";;?>/>
    <?php xl('Return','e')?>    
    <?php xl('Return Patient to Their Prior Level of Function','e')?>
    <input type="checkbox" name="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" id="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" 
value="Teach Patient"  <?php if ($obj{"Evaluation_Skilled_PT_Reasonable_And_Necessary_To"} == "Teach Patient")  echo "checked";;?>/>
    <?php xl('Teach patient compensatory techniques for mobility','e')?>
  <input type="checkbox" name="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" id="Evaluation_Skilled_PT_Reasonable_And_Necessary_To" 
value="Train Patient New Skills"  <?php if ($obj{"Evaluation_Skilled_PT_Reasonable_And_Necessary_To"} == "Train Patient New Skills")  echo "checked";;?>/>
    <?php xl('Train patient in learning new skills','e')?>
<br/><?php xl('Other','e')?>
    <input type="text" style="width:92%" name="Evaluation_Skilled_PT_Other" id="Evaluation_Skilled_PT_Other"  
value="<?php echo stripslashes($obj{"Evaluation_Skilled_PT_Other"});?>"/></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellspacing="0px" cellpadding="5px" class="formtable"><tr><td><strong>
    <?php xl('ADDITIONAL COMMENTS','e')?>
      <input type="text" style="width:76%" name="Evaluation_Additional_Comments" id="Evaluation_Additional_Comments"  
value="<?php echo stripslashes($obj{"Evaluation_Additional_Comments"});?>"/>
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
<a href="javascript:top.restoreSession();document.evaluation.submit();" class="link_submit">[<?php xl('Save','e');?>]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save Changes','e');?>]</a>
</form>
<center>
        <table class="formtable">
            <tr>
                <td align="center">
                    <?php if($action == "edit") { ?>
                    <input type="submit" name="Submit" value="Save Form" > &nbsp;&nbsp;
                    <? } ?>
                    </form>
                    <input type="button" value="Back" onClick="top.restoreSession();window.location='<?php echo $GLOBALS['webroot'] ?>/interface/patient_file/encounter/encounter_top.php';"/>&nbsp;&nbsp;
                    <?php if($action == "review") { ?>
                    <input type="button" value="Sign" id="signoff" href="#login_form" <?php echo $signDisabled;?> />
                    <? } ?>
                </td>
            </tr>
            <tr><td>

                    <div id="signature_log" name="signature_log">
                        <?php $esign->getDefaultSignatureLog(true);?>
                    </div>
                </td></tr>
            </table>
        </center>
    </body>
    <div style="display:none">
	<form id="login_form" method="post" action="">
            <p><center><span style="font-size:small;">
                        <p id="login_prompt" style="font-size:small;">Enter your password to sign:</p>
                        <input type="hidden" name="sig_status" value="approved" />
                        <input type="hidden" id="tid" name="tid" value="<?php echo $id;?>"/>
                        <input type="hidden" id="table_name" name="table_name" value="<?php echo $formTable;?>"/>
			<input type="hidden" id="signature_uid" name="signature_uid" value="<?php echo $_SESSION['authUserID'];?>"/>
                        <input type="hidden" id="signature_id" name="signature_id" value="<?php echo $sigId->getId();?>" />
                        <input type="hidden" id="exam_name" name="exam_name" value="<?php echo $registryRow['nickname'];?>" />
                        <input type="hidden" id="exam_pid" name="exam_pid" value="<?php echo $obj['pid'];?>" />
                        <input type="hidden" id="exam_date" name="exam_date" value="<?php echo $obj['date'];?>" />
			<label for="login_pass">Password: </label>
			<input type="password" id="login_pass" name="login_pass" size="10" />
                    </span>
                </center></p>
		<p>
			<input type="submit" value="Sign" />
		</p>
	</form>
</div>

</body>
</html>
