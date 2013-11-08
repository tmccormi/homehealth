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
$formTable = "forms_pt_visitnote";

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
	    	   	med_icd9.innerHTML= result['res'];
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/ptvisit_notes/functions.php?code="+icd9code+"&Dx="+Dx,true);    
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

<script>
function requiredCheck(){
    var time_in = document.getElementById('visitnote_Time_In').value;
    var time_out = document.getElementById('visitnote_Time_Out').value;
				var date = document.getElementById('visitnote_visitdate').value;
    
				if(time_in != "" && time_out != "" && date != "") {
        return true;
    } else {
        alert("Please select a time in, time out, and encounter date before submitting.");
        return false;
    }
}
</script>
</head>
<body class="body_top">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_pt_visitnote", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>
<form method=post action="<?php echo $rootdir?>/forms/ptvisit_notes/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="visitnotes">
<h3 align="center"><?php xl('PHYSICAL THERAPY REVISIT NOTE','e'); ?></h3>

<br></br>
<table width="100%" border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row">
    <table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr>
        <td scope="row"><strong><?php xl('Patient Name','e'); ?></strong></td>
        <td align="center" valign="top">
        <input type="text" name="patient_name" id="patient_name" value="<?php patientName()?>" readonly /></td>
        <td><strong><?php xl('Time In','e'); ?></strong></td>
        <td><select name="visitnote_Time_In" id="visitnote_Time_In">
<?php timeDropDown(stripslashes($obj{"visitnote_Time_In"})) ?></select></td>
        <td><strong><?php xl('Time Out','e'); ?></strong></td>
        <td><select name="visitnote_Time_Out" id="visitnote_Time_Out">
<?php timeDropDown(stripslashes($obj{"visitnote_Time_Out"})) ?></select></td>
        <td><strong><?php xl('Encounter Date','e'); ?></strong></td>
        <td>
         <input type='text' size='10' name="visitnote_visitdate" id='visitnote_visitdate' title='<?php xl('Encounter Date','e'); ?>' value="<?php echo stripslashes($obj{"visitnote_visitdate"});?>" onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
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
    <td valign="top" scope="row"><strong><?php xl('TYPE OF REVISIT','e'); ?> </strong>
      <input type="checkbox" name="visitnote_Type_of_Visit" value="visit" id="visitnote_Type_of_Visit"  
      <?php if ($obj{"visitnote_Type_of_Visit"} == "visit")
				echo "checked";;?>/>
<?php xl('ReVisit','e'); ?>&nbsp;
<input type="checkbox" name="visitnote_Type_of_Visit" value="visit_Supervisory" id="visitnote_Type_of_Visit" 
<?php if ($obj{"visitnote_Type_of_Visit"} == "visit_Supervisory")	echo "checked";;?>/>
<?php xl('ReVisit and Supervisory Visit','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> 
<input type="text" style="width:42%" name="visitnote_Type_of_Visit_Other" id="visitnote_Type_of_Visit_Other" 
  value="<?php echo stripslashes($obj{"visitnote_Type_of_Visit_Other"});?>" />
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('VITAL SIGNS','e'); ?></strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pulse','e'); ?> 
    <input type="text" size="3px" name="visitnote_VS_Pulse" id="visitnote_VS_Pulse" value="<?php echo stripslashes($obj{"visitnote_VS_Pulse"});?>" > 
    <input type="checkbox" name="visitnote_VS_Pulse_type" value="regular" id="visitnote_VS_Pulse_Regular" 
     <?php if ($obj{"visitnote_VS_Pulse_type"} == "regular")	echo "checked";;?> />
<?php xl('Regular','e'); ?>
<input type="checkbox" name="visitnote_VS_Pulse_type" value="Irregular" id="visitnote_VS_Pulse_Irregular"
 <?php if ($obj{"visitnote_VS_Pulse_type"} == "Irregular")	echo "checked";;?> />
<?php xl('Irregular','e'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Temperature','e'); ?>
 <input type="text" size="3px" name="visitnote_VS_Temperature" id="visitnote_VS_Temperature" value="<?php echo stripslashes($obj{"visitnote_VS_Temperature"});?>" >  
 <input type="checkbox" name="visitnote_VS_Temperature_type" value="Oral" id="visitnote_VS_Temperature_type" 
  <?php if ($obj{"visitnote_VS_Temperature_type"} == "Oral")	echo "checked";;?> />
<?php xl('Oral','e'); ?>
<input type="checkbox" name="visitnote_VS_Temperature_type" value="Temporal" id="visitnote_VS_Temperature_type"
<?php if ($obj{"visitnote_VS_Temperature_type"} == "Temporal")	echo "checked";;?> />
<?php xl('Temporal','e'); ?>&nbsp;
<?php xl('Other','e'); ?> &nbsp;
<input type="text" size="10px" name="visitnote_VS_Other" id="visitnote_VS_Other" value="<?php echo stripslashes($obj{"visitnote_VS_Other"});?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl('Respirations','e'); ?> 
 <input type="text" size="3px" name="visitnote_VS_Respirations" id="visitnote_VS_Respirations" value="<?php echo stripslashes($obj{"visitnote_VS_Respirations"});?>" >
 <p>
  <?php xl('Blood Pressure Systolic','e'); ?>
  <input type="text" size="3px" name="visitnote_VS_BP_Systolic" id="visitnote_VS_BP_Systolic" value="<?php echo stripslashes($obj{"visitnote_VS_BP_Systolic"});?>" >
  /
  <input type="text" size="3px" name="visitnote_VS_BP_Diastolic" id="visitnote_VS_BP_Diastolic" value="<?php echo stripslashes($obj{"visitnote_VS_BP_Diastolic"});?>" >
<input type="checkbox" name="visitnote_VS_BP_side" value="Right" id="visitnote_VS_BP_Right" 
<?php if ($obj{"visitnote_VS_BP_side"} == "Right")	echo "checked";;?> />
<?php xl('Right','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_side" value="Left" id="visitnote_VS_BP_Left" 
<?php if ($obj{"visitnote_VS_BP_side"} == "Left")	echo "checked";;?> />
<?php xl('Left','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Sitting" id="visitnote_VS_BP_Sitting" 
<?php if ($obj{"visitnote_VS_BP_Position"} == "Sitting")	echo "checked";;?> />
<?php xl('Sitting','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Standing" id="visitnote_VS_BP_Standing" 
<?php if ($obj{"visitnote_VS_BP_Position"} == "Standing")	echo "checked";;?> />
<?php xl('Standing','e'); ?>
<input type="checkbox" name="visitnote_VS_BP_Position" value="Lying" id="visitnote_VS_BP_Lying"
<?php if ($obj{"visitnote_VS_BP_Position"} == "Lying")	echo "checked";;?> />
<?php xl('Lying','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('*O','e'); ?><sub><?php xl('2','e'); ?></sub><?php xl('Sat','e'); ?>&nbsp;
<input type="text" size="7px" name="visitnote_VS_BP_Sat" id="visitnote_VS_BP_Sat" 
value="<?php echo stripslashes($obj{"visitnote_VS_BP_Sat"});?>" >
  *<?php xl('Physician ordered','e'); ?> </td>
</p>
  </tr>
  <tr>
<td valign="top" scope="row"><strong><?php xl('Pain','e'); ?></strong>
  <input type="checkbox" name="visitnote_VS_Pain_paintype" value="Nopain" id="visitnote_VS_Pain_Nopain" 
  <?php if ($obj{"visitnote_VS_Pain_paintype"} == "Nopain")	echo "checked";;?> />
<?php xl('No Pain','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="Pain" id="visitnote_VS_Pain_Pain_limits" 
 <?php if ($obj{"visitnote_VS_Pain_paintype"} == "Pain")	echo "checked";;?> />
<?php xl('Pain limits functional ability','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Intensity','e'); ?>
<input type="text" name="visitnote_VS_Pain_Intensity" id="visitnote_VS_Pain_Intensity" 
value="<?php echo stripslashes($obj{"visitnote_VS_Pain_Intensity"});?>" >
<input type="checkbox" name="visitnote_VS_Pain_Level" value="Improve" id="visitnote_VS_Pain_Intensity_Improve" 
<?php if ($obj{"visitnote_VS_Pain_Level"} == "Improve")	echo "checked";;?> />
<?php xl('Improve','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_Level" value="Worse" id="visitnote_VS_Pain_Intensity_Worse"
<?php if ($obj{"visitnote_VS_Pain_Level"} == "Worse")	echo "checked";;?> />
<?php xl('Worse','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_Level" value="No_Change" id="visitnote_VS_Pain_Intensity_No_Change"
<?php if ($obj{"visitnote_VS_Pain_Level"} == "No_Change")	echo "checked";;?> />
<?php xl('No Change','e'); ?></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><p><strong><?php xl('Please Note   Contact MD if Vital Signs are   Pulse &lt;56 or &gt;120;   Temperature   &lt;56 or &gt;101;   Respirations  &lt;10 or &gt;30<br />SBP &lt;80 or &gt;190; DBP &lt;50  or  &gt;100;  Pain   Significantly  Impacts patients ability to participate.    O2 Sat &lt;90% after rest','e'); ?></strong></p></td>
  </tr>
  <tr>
    <td valign="top" scope="row" style="padding-left:8px; padding-right:8px; padding-bottom:8px;"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM','e'); ?></strong>
<input type="text" id="visitnote_Treatment_Diagnosis_Problem" name="visitnote_Treatment_Diagnosis_Problem" style="width:100%;" value="<?php echo stripslashes($obj{'visitnote_Treatment_Diagnosis_Problem'}); ?>"/>				
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
        <tr>
          <td valign="top" scope="row"><table width="100%" class="formtable">
              <tr>
                <td><label>
                  <strong><?php xl('PATIENT CONTINUES TO BE HOMEBOUND DUE TO','e'); ?></strong><br />
                  <input type="checkbox" name="visitnote_Pat_Homebound_Needs_assistance" id="visitnote_Pat_Homebound_Needs_assistance" 
                  <?php if ($obj{"visitnote_Pat_Homebound_Needs_assistance"} == "on")	echo "checked";;?> />
                  <?php xl('Needs assistance in all activities of daily living','e'); ?></label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Unable_leave_home" id="visitnote_Pat_Homebound_Unable_leave_home" 
                   <?php if ($obj{"visitnote_Pat_Homebound_Unable_leave_home"} == "on")	echo "checked";;?> />
                 <?php xl('Unable to leave home safely without assistance','e'); ?> </label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Medical_Restrictions" id="visitnote_Pat_Homebound_Medical_Restrictions" 
                  <?php if ($obj{"visitnote_Pat_Homebound_Medical_Restrictions"} == "on")	echo "checked";;?> />
                  <?php xl('Medical Restrictions in','e'); ?></label><label>
                  <input type="text" name="visitnote_Pat_Homebound_Medical_Restrictions_In" style="width:280px" id="visitnote_Pat_Homebound_Medical_Restrictions_In" 
                 value="<?php echo stripslashes($obj{"visitnote_Pat_Homebound_Medical_Restrictions_In"});?>" >
                </label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_SOB_upon_exertion" id="visitnote_Pat_Homebound_SOB_upon_exertion" value="on"
                   <?php if ($obj{"visitnote_Pat_Homebound_SOB_upon_exertion"} == "on")	echo "checked";;?> />
                  <?php xl('SOB upon exertion','e'); ?></label><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Pain_with_Travel" id="visitnote_Pat_Homebound_Pain_with_Travel" 
                  <?php if ($obj{"visitnote_Pat_Homebound_Pain_with_Travel"} == "on")	echo "checked";;?> />
                  <?php xl('Pain with Travel','e'); ?></label></td>
              </tr>
            </table>
          <td valign="top">
            <table width="100%" class="formtable">
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_mobility_ambulation" id="visitnote_Pat_Homebound_mobility_ambulation" 
                   <?php if ($obj{"visitnote_Pat_Homebound_mobility_ambulation"} == "on")	echo "checked";;?> />
                  <?php xl('Requires assistance in mobility and ambulation','e'); ?></label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Arrhythmia" id="visitnote_Pat_Homebound_Arrhythmia"
                   <?php if ($obj{"visitnote_Pat_Homebound_Arrhythmia"} == "on")	echo "checked";;?> >
                  <?php xl('Arrhythmia','e'); ?></label><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Bed_Bound" id="visitnote_Pat_Homebound_Bed_Bound"
                  <?php if ($obj{"visitnote_Pat_Homebound_Bed_Bound"} == "on")	echo "checked";;?> >                 
<?php xl('Bed Bound','e'); ?></label><label>
<input type="checkbox" name="visitnote_Pat_Homebound_Residual_Weakness" id="visitnote_Pat_Homebound_Residual_Weakness" 
<?php if ($obj{"visitnote_Pat_Homebound_Residual_Weakness"} == "on")	echo "checked";;?> >
<?php xl('Residual Weakness','e'); ?></label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="visitnote_Pat_Homebound_Confusion" id="visitnote_Pat_Homebound_Confusion" 
                <?php if ($obj{"visitnote_Pat_Homebound_Confusion"} == "on")	echo "checked";;?> >
                  <?php xl('Confusion, unable to go out of home alone','e'); ?></td>
              </tr>
            </table>
            <p><?php xl('Other','e'); ?> 
              <input type="text" style="width:370px" name="visitnote_Pat_Homebound_Other" size="35px" id="visitnote_Pat_Homebound_Other" value="<?php echo stripslashes($obj{"visitnote_Pat_Homebound_Other"});?>" >
            </p></td>
        </tr>
    </table>      
      <strong><?php xl('INTERVENTIONS','e'); ?> 
      <input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" 
      value="Patient" <?php if ($obj{"visitnote_Interventions"} == "Patient")	echo "checked";;?> >
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" 
value="Caregiver" <?php if ($obj{"visitnote_Interventions"} == "Caregiver")	echo "checked";;?> >
<?php xl('Caregiver','e'); ?>
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" 
value="Patient and Caregiver" <?php if ($obj{"visitnote_Interventions"} == "Patient and Caregiver")	echo "checked";;?> >
<?php xl('Patient and Caregiver','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?>&nbsp;
<input type="text" style="width:340px" name="visitnote_Interventions_Other" id="visitnote_Interventions_Other" value="<?php echo stripslashes($obj{"visitnote_Interventions_Other"});?>" >
</strong>
<br /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr valign="top">
        <td scope="row" width="25%" >
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Evaluation" id="visitnote_Evaluation" 
                <?php if ($obj{"visitnote_Evaluation"} == "on")	echo "checked";;?> >
                <?php xl('Evaluation','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Therapeutic_Exercises" id="visitnote_Therapeutic_Exercises" 
                <?php if ($obj{"visitnote_Therapeutic_Exercises"} == "on")	echo "checked";;?> >
                <?php xl('Therapeutic Exercises','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Gait_Training" id="visitnote_Gait_Training" 
                  <?php if ($obj{"visitnote_Gait_Training"} == "on")	echo "checked";;?> >
                <?php xl('Gait Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Bed_Mobility" id="visitnote_Bed_Mobility" 
                <?php if ($obj{"visitnote_Bed_Mobility"} == "on")	echo "checked";;?> >
                <?php xl('Bed Mobility','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Training_Transfer" id="visitnote_Training_Transfer" 
                <?php if ($obj{"visitnote_Training_Transfer"} == "on")	echo "checked";;?> >
                <?php xl('Training Transfer Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Balance_Training_Activities" id="visitnote_Balance_Training_Activities" 
                <?php if ($obj{"visitnote_Balance_Training_Activities"} == "on")	echo "checked";;?> >
               <?php xl('Balance Training/Activities','e'); ?> </label></td>
            </tr>
	      <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Patient_Caregiver_Family_Education" id="visitnote_Patient_Caregiver_Family_Education" 
	<?php if ($obj{"visitnote_Patient_Caregiver_Family_Education"} == "on")	echo "checked";;?> >
               <?php xl('Patient/Caregiver/Family Education','e'); ?> </label></td>
            </tr>
          </table>
        </td>
        <td width="30%" >
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Assistive_Device_Training" id="visitnote_Assistive_Device_Training" 
                <?php if ($obj{"visitnote_Assistive_Device_Training"} == "on")	echo "checked";;?> >
               <?php xl('Assistive Device Training','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Neuro_developmental_Training" id="visitnote_Neuro_developmental_Training" 
                <?php if ($obj{"visitnote_Neuro_developmental_Training"} == "on")	echo "checked";;?> >
             <?php xl('Neuro-developmental Training','e'); ?>   </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Orthotics_Splinting" id="visitnote_Orthotics_Splinting" 
                <?php if ($obj{"visitnote_Orthotics_Splinting"} == "on")	echo "checked";;?> >
               <?php xl('Orthotics/Splinting','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Hip_Safety_Precaution_Training" id="visitnote_Hip_Safety_Precaution_Training" 
                <?php if ($obj{"visitnote_Hip_Safety_Precaution_Training"} == "on")	echo "checked";;?> >
                <?php xl('Hip Safety Precaution Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Physical_Agents" id="visitnote_Physical_Agents" 
                <?php if ($obj{"visitnote_Physical_Agents"} == "on")	echo "checked";;?> >
               <?php xl('Physical Agents','e'); ?> </label></td>
            </tr>
	    <tr>
	  <td> <label> <?php xl('for','e')?>
	  <input type="text" style="width:250px" name="visitnote_Physical_Agents_For" id="visitnote_Physical_Agents_For" 
    value="<?php echo stripslashes($obj{"visitnote_Physical_Agents_For"});?>" >
	  </td></tr>
	    <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Muscle_ReEducation" id="visitnote_Muscle_ReEducation" 
       <?php if ($obj{"visitnote_Muscle_ReEducation"} == "on")	echo "checked";;?> >
               <?php xl('Muscle Re-Education','e'); ?> </label></td>
            </tr>
          </table>
        </td>
        <td width="45%" >
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Safe_Stair_Climbing_Skills" id="visitnote_Safe_Stair_Climbing_Skills" 
                <?php if ($obj{"visitnote_Safe_Stair_Climbing_Skills"} == "on")	echo "checked";;?> >
                <?php xl('Safe Stair Climbing Skills','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Exercises_to_manage_pain" id="visitnote_Exercises_to_manage_pain" 
                <?php if ($obj{"visitnote_Exercises_to_manage_pain"} == "on")	echo "checked";;?> >
                <?php xl('Exercises to manage pain','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Fall_Precautions_Training" id="visitnote_Fall_Precautions_Training" 
                <?php if ($obj{"visitnote_Fall_Precautions_Training"} == "on")	echo "checked";;?> >
               <?php xl('Fall Precautions Training','e'); ?> </label></td>
            </tr>
	      <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Exercises_Safety_Techniques" id="visitnote_Exercises_Safety_Techniques" 
	    <?php if ($obj{"visitnote_Exercises_Safety_Techniques"} == "on")	echo "checked";;?> >
               <?php xl('Exercises/ Safety Techniques given to patient','e'); ?> </label></td>
            </tr>
          </table>
          <p><?php xl('Other','e'); ?>
            <input type="text" style="width:310px" name="visitnote_Other1" id="visitnote_Other1" value="<?php echo stripslashes($obj{"visitnote_Other1"});?>" >
          </p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SPECIFIC TRAINING THIS REVISIT','e'); ?></strong><br/>
      <textarea name="visitnote_Specific_Training_Visit" id="visitnote_Specific_Training_Visit" 
      style="width:100%" rows="2" ><?php echo stripslashes($obj{"visitnote_Specific_Training_Visit"});?></textarea>
      <br />
      <strong><?php xl('Has the patient had any changes in medications since the last visit?','e'); ?>
      <input type="checkbox" name="visitnote_changes_in_medications" id="visitnote_changes_in_medications" value="Yes"
<?php if ($obj{"visitnote_changes_in_medications"} == "Yes")	echo "checked";;?> >
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_changes_in_medications" id="visitnote_changes_in_medications" value="No"
  <?php if ($obj{"visitnote_changes_in_medications"} == "No")	echo "checked";;?> >
<?php xl('No','e'); ?>
      <br />     <?php xl('If yes, update medication profile','e'); ?> </strong><br />
    </td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('FUNCTIONAL IMPROVEMENTS IN THE FOLLOWING AREAS','e'); ?><br />
    </strong>
   <input type="checkbox" name="visitnote_FI_Mobility" id="visitnote_FI_Mobility" 
<?php if ($obj{"visitnote_FI_Mobility"} == "on")	echo "checked";;?> >
<?php xl('Mobility','e'); ?> 
<input type="checkbox" name="visitnote_FI_ROM" id="visitnote_FI_ROM" 
<?php if ($obj{"visitnote_FI_ROM"} == "on")	echo "checked";;?> >
<?php xl('ROM in','e'); ?> 
<input type="text" style="width:190px" name="visitnote_FI_ROM_In" id="visitnote_FI_ROM_In" 
value="<?php echo stripslashes($obj{"visitnote_FI_ROM_In"});?>" >

<input type="checkbox" name="visitnote_FI_Home_Safety_Techniques" id="visitnote_FI_Home_Safety_Techniques" 
<?php if ($obj{"visitnote_FI_Home_Safety_Techniques"} == "on")	echo "checked";;?> >
<?php xl('Home Safety Techniques in','e'); ?>
<input type="text" style="width:340px" name="visitnote_FI_Home_Safety_Techniques_In" id="visitnote_FI_Home_Safety_Techniques_In" 
value="<?php echo stripslashes($obj{"visitnote_FI_Home_Safety_Techniques_In"});?>" >
<br />  
<input type="checkbox" name="visitnote_FI_Assistive_Device_Usage" id="visitnote_FI_Assistive_Device_Usage" 
<?php if ($obj{"visitnote_FI_Assistive_Device_Usage"} == "on")	echo "checked";;?> >
<?php xl('Assistive Device Usage with','e'); ?>
<input type="text" size="20px" name="visitnote_FI_Assistive_Device_Usage_With" size="50px" id="visitnote_FI_Assistive_Device_Usage_With" 
value="<?php echo stripslashes($obj{"visitnote_FI_Assistive_Device_Usage_With"});?>" > 
<input type="checkbox" name="visitnote_FI_Caregiver_Family_Performance" id="visitnote_FI_Caregiver_Family_Performance" 
<?php if ($obj{"visitnote_FI_Caregiver_Family_Performance"} == "on")	echo "checked";;?> >
<?php xl('Caregiver/Family Performance in','e'); ?> &nbsp;
<input type="text" style="width:31%" name="visitnote_FI_Caregiver_Family_Performance_In" id="visitnote_FI_Caregiver_Family_Performance_In" 
value="<?php echo stripslashes($obj{"visitnote_FI_Caregiver_Family_Performance_In"});?>" >  
<br />
<input type="checkbox" name="visitnote_FI_Performance_of_Home_Exercises" id="visitnote_FI_Performance_of_Home_Exercises" 
<?php if ($obj{"visitnote_FI_Performance_of_Home_Exercises"} == "on")	echo "checked";;?> >
<?php xl('Performance of Home Exercises','e'); ?>
<input type="checkbox" name="visitnote_FI_Demonstrates" id="visitnote_FI_Demonstrates" 
<?php if ($obj{"visitnote_FI_Demonstrates"} == "on")	echo "checked";;?> >
<?php xl('Demonstrates','e'); ?>
<input type="text" name="visitnote_FI_Demonstrates_Notes" size="35px" id="visitnote_FI_Demonstrates_Notes" 
value="<?php echo stripslashes($obj{"visitnote_FI_Demonstrates_Notes"});?>" >
<lable> <?php xl('use of prosthesis/brace/splint','e')?> </label>  
 <br /> 
 <?php xl('Other','e'); ?>
<input type="text" style="width:93%"  name="visitnote_FI_Other" id="visitnote_FI_Other" 
 value="<?php echo stripslashes($obj{"visitnote_FI_Other"});?>" >  </td>

  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('Has the patient had a fall since the last visit? ','e'); ?>
      <input type="checkbox" name="visitnote_Fall_since_Last_Visit_type" value="yes" id="visitnote_Fall_since_Last_Visit_type" 
      <?php if ($obj{"visitnote_Fall_since_Last_Visit_type"} == "yes") echo "checked";;?> />
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_Fall_since_Last_Visit_type" value="no" id="visitnote_Fall_since_Last_Visit_type" 
<?php if ($obj{"visitnote_Fall_since_Last_Visit_type"} == "no") echo "checked";;?> />
<?php xl('No If Yes, complete incident report.','e'); ?><br />
<?php xl('Timed Up and Go Score ','e'); ?>
<input type="text" name="visitnote_Timed_Up_Go_Score" id="visitnote_Timed_Up_Go_Score" 
 value="<?php echo stripslashes($obj{"visitnote_Timed_Up_Go_Score"});?>" > 
    </strong> <strong> <?php xl('Interpretation','e'); ?> </strong>
    <input type="checkbox" name="visitnote_Interpretation" value="No Fall Risk" id="visitnote_Interpretation"
    <?php if ($obj{"visitnote_Interpretation"} == "No Fall Risk") echo "checked";;?> />
<strong><?php xl('Independent-No Fall Risk (&lt; 11 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Interpretation" value="Minimal Fall Risk" id="visitnote_Interpretation" 
 <?php if ($obj{"visitnote_Interpretation"} == "Minimal Fall Risk") echo "checked";;?> />
<strong><?php xl('Minimal Fall Risk (11- 13 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Interpretation" value="Moderate Fall Risk" id="visitnote_Interpretation" 
 <?php if ($obj{"visitnote_Interpretation"} == "Moderate Fall Risk") echo "checked";;?> />
<strong><?php xl('Moderate Fall Risk (13.5-19 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Interpretation" value="High Fall Risk" id="visitnote_Interpretation" 
 <?php if ($obj{"visitnote_Interpretation"} == "High Fall Risk") echo "checked";;?> />
<strong><?php xl('High Risk for Falls (&gt;19 seconds)','e'); ?> </strong><br />
<strong><?php xl('Other Tests/Scores/Interpretations','e'); ?> 
<input type="text" name="visitnote_Other_Tests_Scores_Interpretations" style="width:68%"  id="visitnote_Other_Tests_Scores_Interpretations" 
value="<?php echo stripslashes($obj{"visitnote_Other_Tests_Scores_Interpretations"});?>" >
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PATIENT/CAREGIVER/FAMILY RESPONSE TO REVISIT','e'); ?></strong> 
    <input type="checkbox" name="visitnote_Response_To_Revisit" value="Verbalized Understanding" id="visitnote_Response_To_Revisit" 
    <?php if ($obj{"visitnote_Response_To_Revisit"} == "Verbalized Understanding") echo "checked";;?> />
<?php xl('Verbalized Understanding','e'); ?>
  <input type="checkbox" name="visitnote_Response_To_Revisit" value="Demonstrated Task" id="visitnote_Response_To_Revisit" 
  <?php if ($obj{"visitnote_Response_To_Revisit"} == "Demonstrated Task") echo "checked";;?> />
<?php xl('Demonstrated Task','e'); ?>
<input type="checkbox" name="visitnote_Response_To_Revisit" value="Needed Guidance" id="visitnote_Response_To_Revisit" 
<?php if ($obj{"visitnote_Response_To_Revisit"} == "Needed Guidance") echo "checked";;?> />
<?php xl('Needed Guidance/Re-Instruction','e'); ?><br />
<?php xl('Other','e'); ?> <strong>
<input type="text" style="width:92%"  name="visitnote_Response_To_Revisit_Other" id="visitnote_Response_To_Revisit_Other" 
value="<?php echo stripslashes($obj{"visitnote_Response_To_Revisit_Other"});?>" >
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong>
    <input type="checkbox" name="visitnote_CarePlan_Reviewed" id="visitnote_CarePlan_Reviewed" 
    <?php if ($obj{"visitnote_CarePlan_Reviewed"} == "on") echo "checked";;?> />
<?php xl('CARE PLAN REVIEWED WITH','e'); ?>
  <input type="checkbox" name="visitnote_Discharge_Discussed" id="visitnote_Discharge_Discussed" 
  <?php if ($obj{"visitnote_Discharge_Discussed"} == "on") echo "checked";;?> />
<?php xl('DISCHARGE DISCUSSED WITH','e'); ?></strong>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Patient" id="visitnote_DDW_Patient" 
<?php if ($obj{"visitnote_Discharge_Discussed_With"} == "Patient") echo "checked";;?> />
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Physician" id="visitnote_DDW_Physician" 
<?php if ($obj{"visitnote_Discharge_Discussed_With"} == "Physician") echo "checked";;?> />
<?php xl('Physician','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="PT/OT/ST" id="visitnote_DDW_PT_OT_ST" 
<?php if ($obj{"visitnote_Discharge_Discussed_With"} == "PT/OT/ST") echo "checked";;?> />
<?php xl('PTA','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="PTA" id="visitnote_CPRW_Skilled_Nursing" 
<?php if ($obj{"visitnote_Discharge_Discussed_With"} == "PTA") echo "checked";;?> />
<?php xl('PT/OT/ST','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Skilled Nursing" id="visitnote_CPRW_Skilled_Nursing" 
<?php if ($obj{"visitnote_Discharge_Discussed_With"} == "Skilled Nursing") echo "checked";;?> />
<?php xl('Skilled Nursing','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Caregiver Family" id="visitnote_CPRW_Caregiver_Family" 
<?php if ($obj{"visitnote_Discharge_Discussed_With"} == "Caregiver Family") echo "checked";;?> />
<?php xl('Caregiver/Family','e'); ?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Case Manager" id="visitnote_CPRW_Case_Manager" 
<?php if ($obj{"visitnote_Discharge_Discussed_With"} == "Case Manager") echo "checked";;?> />
<?php xl('Case Manager','e'); ?> 
<br /> <?php xl('Other','e'); ?>
<input type="text" name="visitnote_CPRW_Other" style="width:92%" id="visitnote_CPRW_Other" 
value="<?php echo stripslashes($obj{"visitnote_CPRW_Other"});?>" >
<br />
<input type="checkbox" name="visitnote_Careplan_Revised" id="visitnote_Careplan_Revised" 
  <?php if ($obj{"visitnote_Careplan_Revised"} == "on") echo "checked";;?> />
<strong><?php xl('CARE PLANS REVISED','e'); ?>
<input type="text" style="width:76%" name="visitnote_Careplan_Revised_Notes" id="visitnote_Careplan_Revised_Notes" 
value="<?php echo stripslashes($obj{"visitnote_Careplan_Revised_Notes"});?>" >
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row">
    <p><strong><?php xl('FURTHER SKILLED VISITS REQUIRED TO: ','e'); ?></strong>
    <input type="text" name="visitnote_further_Visit_Required_text" id="visitnote_further_Visit_Required_text" value="<?php echo stripslashes($obj{"visitnote_further_Visit_Required_text"});?>" style="width:465px;" />
    <input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Reprioritize exercise" id="visitnote_FSVR_Progress_Reprioritize_exercise" 
    <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Reprioritize exercise") echo "checked";;?> />
<?php xl('Progress/Re-prioritize exercise program','e'); ?>
  <input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Train patient" id="visitnote_FSVR_Train_patient" 
      <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Train patient") echo "checked";;?> />
<?php xl('Train patient in additional skills such as','e'); ?>
<input type="text" name="visitnote_Train_patient_Suchas_Notes" id="visitnote_Train_patient_Suchas_Notes" 
value="<?php echo stripslashes($obj{"visitnote_Train_patient_Suchas_Notes"});?>" >
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Begin Practice" id="visitnote_FSVR_Begin_Practice" 
    <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Begin Practice") echo "checked";;?> />
<?php xl('Begin/Practice','e'); ?>&nbsp;
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="IADLs" id="visitnote_FSVR_IADLs" 
    <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "IADLs") echo "checked";;?> />
<?php xl('Mobility','e'); ?>&nbsp;
<input type="text" name="visitnote_FSVR_IADLs_Notes" id="visitnote_FSVR_IADLs_Notes"   
value="<?php echo stripslashes($obj{"visitnote_FSVR_IADLs_Notes"});?>" >
<!-- Chnaged 'Mobility' instead of IADLS and ADLS   -->
<!--
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="ADLs" id="visitnote_FSVR_ADLs" 
    <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "ADLs") echo "checked";;?> />
<?php xl('Mobility','e'); ?>
<input type="text" name="visitnote_FSVR_ADLs_Notes" id="visitnote_FSVR_ADLs_Notes"   
value="<?php echo stripslashes($obj{"visitnote_FSVR_ADLs_Notes"});?>" > -->
<br/><input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Caregiver/Family" id="visitnote_FSVR_Train_Caregiver_Family" 
    <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Caregiver/Family") echo "checked";;?> />

<?php xl('Train Caregiver/Family','e'); ?> 
<br/><?php xl('Other','e'); ?>
<strong>
<input type="text" style="width:90%" name="visitnote_FSVR_Other" id="visitnote_FSVR_Other" 
value="<?php echo stripslashes($obj{"visitnote_FSVR_Other"});?>" >
</strong>
</p>
<p>
 <?php xl('Approximate Date of Next Visit','e'); ?>
<input type="text" name="visitnote_Date_of_Next_Visit" id="visitnote_Date_of_Next_Visit"
value="<?php echo stripslashes($obj{"visitnote_Date_of_Next_Visit"});?>" 
onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' style="width:150px" readonly/>
                <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_Next_visit_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'>
                <script LANGUAGE="JavaScript">
        Calendar.setup({inputField:"visitnote_Date_of_Next_Visit", ifFormat:"%Y-%m-%d", button:"img_Next_visit_date"});
       </script>
<br>
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Met Goals" id="visitnote_Date_of_Next_Visit" 
  <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Met Goals") echo "checked";;?> />
<?php xl('No further visits required Patient/Caregiver have met goals','e'); ?><br>
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Met max potential" id="visitnote_No_further_visits_PC_Met_max_potential" 
  <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Met max potential") echo "checked";;?> />
<?php xl('No further visits required. Patient/Caregiver have met maximum  potential that can be impacted by therapy.','e'); ?>
</p></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PLAN','e'); ?></strong><br/>
    <p>
      <input type="checkbox" name="visitnote_Plan_Type" value="Current Treatment Appropriate" id="visitnote_Plan_Current_Treatment_Plan" 
      <?php if ($obj{"visitnote_Plan_Type"} == "Current Treatment Appropriate") echo "checked";;?> />
<?php xl('Current Treatment Plan Frequency and Duration is Appropriate','e'); ?>
</p>
<p>
<input type="checkbox" name="visitnote_Plan_Type" value="Initiate Discharge" id="visitnote_Plan_Initiate_Discharge" 
<?php if ($obj{"visitnote_Plan_Type"} == "Initiate Discharge") echo "checked";;?> />
<?php xl('Initiate Discharge, physician order','e'); ?>
</p>
<p>
<input type="checkbox" name="visitnote_Plan_Type" value="May require treatment" id="visitnote_Plan_Require_Additional_Treatment" 
<?php if ($obj{"visitnote_Plan_Type"} == "May require treatment") echo "checked";;?> />
<?php xl('May require additional treatment session(s) to achieve Long Term Outcomes due to ','e'); ?>
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="shortterm memory" id="visitnote_Plan_Short_term_memory" 
<?php if ($obj{"visitnote_Long_Term_Outcomes_Due_To"} == "shortterm memory") echo "checked";;?> />
<?php xl('short term memory difficulties','e'); ?>
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="Minimal Support" id="visitnote_Plan_minimal_support" 
<?php if ($obj{"visitnote_Long_Term_Outcomes_Due_To"} == "Minimal Support") echo "checked";;?> />
<?php xl('minimal support systems','e'); ?>
<input type="checkbox" name="visitnote_Long_Term_Outcomes_Due_To" value="Language barriers" id="visitnote_Plan_Communication_language_barriers" 
<?php if ($obj{"visitnote_Long_Term_Outcomes_Due_To"} == "Language barriers") echo "checked";;?> />
<?php xl('communication, language barriers','e'); ?>
</p>
<p>
<input type="checkbox" name="visitnote_Plan_Type" value="Will address issues by" id="visitnote_Plan_Address_above_issues"
<?php if ($obj{"visitnote_Plan_Type"} == "Will address issues by") echo "checked";;?> />
<?php xl('Will address above issues by','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="physical demonstration" id="visitnote_Plan_Providing_written_directions" 
<?php if ($obj{"visitnote_Address_Above_Issues_By"} == "physical demonstration") echo "checked";;?> />
<?php xl('Providing written directions and/or physical demonstration','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="community support" id="visitnote_Plan_Establish_community_support" 
<?php if ($obj{"visitnote_Address_Above_Issues_By"} == "community support") echo "checked";;?> />
<?php xl('establish community support systems','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="home adaptations" id="visitnote_Plan_Home_env_adaptations" 
<?php if ($obj{"visitnote_Address_Above_Issues_By"} == "home adaptations") echo "checked";;?> />
<?php xl('home/environmental adaptations','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="use family/professionals" id="visitnote_Plan_Use_family_professionals" 
<?php if ($obj{"visitnote_Address_Above_Issues_By"} == "use family/professionals") echo "checked";;?> />
<?php xl('use family/professionals for interpretations as needed','e'); ?>
</p> </td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SUPERVISOR VISIT (if  applicable)','e'); ?> </strong>
      <input type="checkbox" name="visitnote_Supervisory_visit" value="ot_Assistant" id="visitnote_Supervisorvisit_OT_Assistant" 
<?php if ($obj{"visitnote_Supervisory_visit"} == "ot_Assistant") echo "checked";;?> />
<?php xl('OT Assistant','e'); ?>
<input type="checkbox" name="visitnote_Supervisory_visit" value="Aide" id="visitnote_Supervisorvisit_Aide" 
<?php if ($obj{"visitnote_Supervisory_visit"} == "Aide") echo "checked";;?> />
<?php xl('Aide /','e'); ?>
<input type="checkbox" name="visitnote_Supervisory_visit" value="Present" id="visitnote_Supervisorvisit_Present" 
<?php if ($obj{"visitnote_Supervisory_visit"} == "Present") echo "checked";;?> />
<?php xl('Present','e'); ?>
<input type="checkbox" name="visitnote_Supervisory_visit" value="Not_Present" id="visitnote_Supervisorvisit_Not_Present" 
<?php if ($obj{"visitnote_Supervisory_visit"} == "Not_Present") echo "checked";;?> />
<?php xl('Not Present','e'); ?>
<input type="checkbox" name="visitnote_Supervisory_visit" value="Contacted_visit" id="visitnote_Supervisorvisit_Contacted_regarding_visit" 
<?php if ($obj{"visitnote_Supervisory_visit"} == "Contacted_visit") echo "checked";;?> />
<?php xl('Contacted regarding visit','e'); ?>
<br/><label> <?php xl('Observed','e')?> </label>
<input type="text" style="width:40%"  name="visitnote_Supervisory_visit_Observed" id="visitnote_Supervisory_visit_Observed" 
value="<?php echo stripslashes($obj{"visitnote_Supervisory_visit_Observed"});?>" >
<label> <?php xl('Teaching/Training','e')?> </label>
<input type="text" style="width:37%"  name="visitnote_Supervisory_visit_Teaching_Training" id="visitnote_Supervisory_visit_Teaching_Training" 
value="<?php echo stripslashes($obj{"visitnote_Supervisory_visit_Teaching_Training"});?>" >
<label> <?php xl('Patient/Family Discussion','e')?> </label>
<input type="text" style="width:40%"  name="visitnote_Supervisory_visit_Patient_Family_Discussion" id="visitnote_Supervisory_visit_Patient_Family_Discussion" 
value="<?php echo stripslashes($obj{"visitnote_Supervisory_visit_Patient_Family_Discussion"});?>" >
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
  
<a href="javascript:top.restoreSession();document.visitnotes.submit();" class="link_submit" onClick="return requiredCheck()">[<?php xl('Save','e');?>]</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e');?>]</a>
 </form>
</body>
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

</html>

