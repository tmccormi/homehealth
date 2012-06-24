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
$formTable = "forms_st_visitnote";

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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
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
	    obj.open("GET",site_root+"/forms/stvisit_notes/functions.php?code="+icd9code+"&Dx="+Dx,true);    
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
$obj = formFetch("forms_st_visitnote", $_GET["id"]);
?>
<form method=post action="<?php echo $rootdir?>/forms/stvisit_notes/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="visitnotes">
<h3 align="center"><?php xl('SPEECH THERAPY VISIT/DISCHARGE NOTE','e'); ?></h3> <br></br>
<table width="100%" border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row">
    <table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr>
        <td scope="row"><strong><?php xl('Patient Name','e'); ?></strong></td>
        <td align="center" valign="top">
        <input type="text" id="patient_name" value="<?php patientName()?>" readonly/></td>
        <td><strong><?php xl('Time In','e'); ?></strong></td>
        <td><select name="visitnote_Time_In" id="visitnote_Time_In">
<?php timeDropDown(stripslashes($obj{"visitnote_Time_In"})) ?></select></td>
        <td><strong><?php xl('Time Out','e'); ?></strong></td>
        <td><select name="visitnote_Time_Out" id="visitnote_Time_Out">
<?php timeDropDown(stripslashes($obj{"visitnote_Time_Out"})) ?></select></td>
        <td><strong><?php xl('Date','e'); ?></strong></td>
        <td>
         <input type='text' size='10' name="visitnote_visitdate" id='visitnote_visitdate' title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					value="<?php echo stripslashes($obj{"visitnote_visitdate"});?>"
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
						 disabled />
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
      <input type="checkbox" name="visitnote_Type_of_Visit" value="visit" id="visitnote_Type_of_Visit"  
      <?php if ($obj{"visitnote_Type_of_Visit"} == "visit")
				echo "checked";;?>/>
<?php xl('Visit','e'); ?>
<input type="checkbox" name="visitnote_Type_of_Visit" value="visit_Supervisory" id="visitnote_Type_of_Visit" 
<?php if ($obj{"visitnote_Type_of_Visit"} == "visit_Supervisory")	echo "checked";;?>/>
<?php xl('Visit and Supervisory Review','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> 
<input type="text" style="width:50%" name="visitnote_Type_of_Visit_Other" id="visitnote_Type_of_Visit_Other" 
  value="<?php echo stripslashes($obj{"visitnote_Type_of_Visit_Other"});?>" />
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('VITAL SIGNS','e'); ?></strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pulse','e'); ?> 
    <input type="text" size="5px" name="visitnote_VS_Pulse" id="visitnote_VS_Pulse" value="<?php echo stripslashes($obj{"visitnote_VS_Pulse"});?>" > 
<input type="checkbox" name="visitnote_VS_Pulse_type" value="regular" id="visitnote_VS_Pulse_Regular" 
     <?php if ($obj{"visitnote_VS_Pulse_type"} == "regular")	echo "checked";;?> />
<?php xl('Regular','e'); ?>
<input type="checkbox" name="visitnote_VS_Pulse_type" value="Irregular" id="visitnote_VS_Pulse_Irregular"
 <?php if ($obj{"visitnote_VS_Pulse_type"} == "Irregular")	echo "checked";;?> />
<?php xl('Irregular','e'); ?> &nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Temperature','e'); ?>
 <input type="text" size="5px" name="visitnote_VS_Temperature" id="visitnote_VS_Temperature" value="<?php echo stripslashes($obj{"visitnote_VS_Temperature"});?>" >  
 <input type="checkbox" name="visitnote_VS_Temperature_type" value="Oral" id="visitnote_VS_Temperature_type" 
  <?php if ($obj{"visitnote_VS_Temperature_type"} == "Oral")	echo "checked";;?> />
<?php xl('Oral','e'); ?>
<input type="checkbox" name="visitnote_VS_Temperature_type" value="Temporal" id="visitnote_VS_Temperature_type"
<?php if ($obj{"visitnote_VS_Temperature_type"} == "Temporal")	echo "checked";;?> />
<?php xl('Temporal','e'); ?>&nbsp;&nbsp;
<?php xl('Other','e'); ?>&nbsp;
<input type="text" style="width:30%" name="visitnote_VS_Other" id="visitnote_VS_Other" value="<?php echo stripslashes($obj{"visitnote_VS_Other"});?>"/>
 <?php xl('Respirations','e'); ?>&nbsp;
 <input type="text" size="6px" name="visitnote_VS_Respirations" id="visitnote_VS_Respirations" value="<?php echo stripslashes($obj{"visitnote_VS_Respirations"});?>" >&nbsp;&nbsp;&nbsp;&nbsp;
   <?php xl('Blood Pressure Systolic','e'); ?>
  <input type="text" size="6px" name="visitnote_VS_BP_Systolic" id="visitnote_VS_BP_Systolic" value="<?php echo stripslashes($obj{"visitnote_VS_BP_Systolic"});?>" >
  /
  <input type="text" size="3px" name="visitnote_VS_BP_Diastolic" id="visitnote_VS_BP_Diastolic" value="<?php echo stripslashes($obj{"visitnote_VS_BP_Diastolic"});?>" >
<?php xl('Diastolic','e');?>
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
<?php xl('Lying','e')?><br> 
<?php xl('*O','e')?>
<sub> <?php xl('2','e')?></sub> <?php xl('Sat','e'); ?> 
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
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="Pain limits functional ability" id="visitnote_VS_Pain_Pain_limits" 
 <?php if ($obj{"visitnote_VS_Pain_paintype"} == "Pain limits functional ability")	echo "checked";;?> />
<?php xl('Pain limits functional ability','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Intensity','e'); ?>
<input type="text" name="visitnote_VS_Pain_Intensity" id="visitnote_VS_Pain_Intensity" 
value="<?php echo stripslashes($obj{"visitnote_VS_Pain_Intensity"});?>" >
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="Improve" id="visitnote_VS_Pain_Intensity_Improve" 
<?php if ($obj{"visitnote_VS_Pain_paintype"} == "Improve")	echo "checked";;?> />
<?php xl('Improve','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="Worse" id="visitnote_VS_Pain_Intensity_Worse"
<?php if ($obj{"visitnote_VS_Pain_paintype"} == "Worse")	echo "checked";;?> />
<?php xl('Worse','e'); ?>
<input type="checkbox" name="visitnote_VS_Pain_paintype" value="No Change" id="visitnote_VS_Pain_Intensity_No_Change"
<?php if ($obj{"visitnote_VS_Pain_paintype"} == "No Change")	echo "checked";;?> />
<?php xl('No Change','e'); ?><br>
<?php xl('Location(s)','e')?>&nbsp;
       <input type="text" style="width:30%" name="visitnote_VS_Pain_Location" id="visitnote_VS_Pain_Location"
  value="<?php echo stripslashes($obj{"visitnote_VS_Pain_Location"});?>"/>
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><p><strong><?php xl('Please Note  Contact MD if Vital Signs are Pulse &lt;56 or &gt;120; Temperature &lt;56 or &gt;101; Respirations &lt;10 or &gt;30 SBP &lt;80 or &gt;190; DBP &lt;50  or  &gt;100; Pain  Significantly  Impacts patients ability to participate. O2 Sat &lt;90% after rest','e'); ?></strong></p></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('TREATMENT DIAGNOSIS/PROBLEM','e'); ?></strong>
   <input type="text" id="icd" size="25"/>
<input type="button" value="Search" onclick="javascript:changeICDlist(visitnote_Treatment_Diagnosis_Problem,document.getElementById('icd'),'<?php echo $rootdir; ?>')"/>
<div id="med_icd9">
<?php if ($obj{"visitnote_Treatment_Diagnosis_Problem"} != "")
{
echo "<select id='visitnote_Treatment_Diagnosis_Problem' name='visitnote_Treatment_Diagnosis_Problem'>"; 
echo "<option value=".stripslashes($obj{'visitnote_Treatment_Diagnosis_Problem'}).">". stripslashes($obj{'visitnote_Treatment_Diagnosis_Problem'})."</option>";
echo "</select>";
 } 
 else 
 { 
 echo "<select id='med_dx_icd9' name='med_dx_icd9' style='display:none'> </select>";
 }?></div>
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
                  <input type="text" style="width:55%" name="visitnote_Pat_Homebound_Medical_Restrictions_In" id="visitnote_Pat_Homebound_Medical_Restrictions_In" 
                 value="<?php echo stripslashes($obj{"visitnote_Pat_Homebound_Medical_Restrictions_In"});?>" >
                </label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="visitnote_Pat_Homebound_SOB_upon_exertion" id="visitnote_Pat_Homebound_SOB_upon_exertion" 
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
                <td>
                  <input type="checkbox" name="visitnote_Pat_Homebound_mobility_ambulation" id="visitnote_Pat_Homebound_mobility_ambulation" 
                   <?php if ($obj{"visitnote_Pat_Homebound_mobility_ambulation"} == "on")	echo "checked";;?> />
                  <?php xl('Requires assistance in mobility and ambulation','e'); ?></td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Arrhythmia" id="visitnote_Pat_Homebound_Arrhythmia"
                   <?php if ($obj{"visitnote_Pat_Homebound_Arrhythmia"} == "on")	echo "checked";;?> >
                  <?php xl('Arrhythmia','e'); ?>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Bed_Bound" id="visitnote_Pat_Homebound_Bed_Bound"
                  <?php if ($obj{"visitnote_Pat_Homebound_Bed_Bound"} == "on")	echo "checked";;?> >                 
<?php xl('Bed Bound','e'); ?>
<input type="checkbox" name="visitnote_Pat_Homebound_Residual_Weakness" id="visitnote_Pat_Homebound_Residual_Weakness" 
<?php if ($obj{"visitnote_Pat_Homebound_Residual_Weakness"} == "on")	echo "checked";;?> >
<?php xl('Residual Weakness','e'); ?></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="visitnote_Pat_Homebound_Confusion" id="visitnote_Pat_Homebound_Confusion" 
                <?php if ($obj{"visitnote_Pat_Homebound_Confusion"} == "on")	echo "checked";;?> >
                  <?php xl('Confusion, unable to go out of home alone','e'); ?></td>
              </tr>
            </table>
            <p><?php xl('Other','e'); ?> 
              <input type="text" style="width:87%" name="visitnote_Pat_Homebound_Other"  id="visitnote_Pat_Homebound_Other" value="<?php echo stripslashes($obj{"visitnote_Pat_Homebound_Other"});?>" >
            </p></td>
        </tr>
    </table>      
      <strong><?php xl('INTERVENTIONS','e'); ?> 
      <input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" 
      value="Patient" <?php if ($obj{"visitnote_Interventions"} == "Patient")	echo "checked";;?> >
<?php xl('Patient','e'); ?>&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" 
value="Caregiver" <?php if ($obj{"visitnote_Interventions"} == "Caregiver")	echo "checked";;?> >
<?php xl('Caregiver','e'); ?>
&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="visitnote_Interventions" id="visitnote_Interventions" 
value="Patient and Caregiver" <?php if ($obj{"visitnote_Interventions"} == "Patient and Caregiver")	echo "checked";;?> >
<?php xl('Patient and Caregiver','e')?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Other','e'); ?>&nbsp;
<input type="text" name="visitnote_Interventions_Other" style="width:35%" id="visitnote_Interventions_Other" value="<?php echo stripslashes($obj{"visitnote_Interventions_Other"});?>" >
</strong>
<br /></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr valign="top">
        <td scope="row">
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Evaluation" id="visitnote_Evaluation" 
                <?php if ($obj{"visitnote_Evaluation"} == "on")	echo "checked";;?> >
                <?php xl('Evaluation','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Dysphagia_Compensatory" id="visitnote_Dysphagia_Compensatory" 
                <?php if ($obj{"visitnote_Dysphagia_Compensatory"} == "on")	echo "checked";;?> >
                <?php xl('Dysphagia Compensatory Strategies','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Swallow_Exercise" id="visitnote_Swallow_Exercise" 
                  <?php if ($obj{"visitnote_Swallow_Exercise"} == "on")	echo "checked";;?> >
                <?php xl('Swallow Exercise Program','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Safety_Training" id="visitnote_Safety_Training" 
                <?php if ($obj{"visitnote_Safety_Training"} == "on")	echo "checked";;?> >
                <?php xl('Safety Training in Swallow Techniques','e'); ?></label></td>
            </tr>           
          </table>
        </td>
        <td>
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Cognitive_Impairment" id="visitnote_Cognitive_Impairment" 
                <?php if ($obj{"visitnote_Cognitive_Impairment"} == "on") echo "checked";;?> >
               <?php xl('Cognitive Impairment Management','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Communication_Strategies" id="visitnote_Communication_Strategies" 
                <?php if ($obj{"visitnote_Communication_Strategies"} == "on")	echo "checked";;?> >
             <?php xl('Communication Strategies','e'); ?>   </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Cognitive_Compensatory" id="visitnote_Cognitive_Compensatory" 
                <?php if ($obj{"visitnote_Cognitive_Compensatory"} == "on")	echo "checked";;?> >
               <?php xl('Cognitive Compensatory Skills','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Patient_Caregiver_Family_Education" id="visitnote_Patient_Caregiver_Family_Education" 
                <?php if ($obj{"visitnote_Patient_Caregiver_Family_Education"} == "on")	echo "checked";;?> >
                <?php xl('Patient/Caregiver/Family Education','e'); ?></label></td>
            </tr> 
          </table>
        </td>
        <td>
         <?php xl('Other','e'); ?>
	<div> <textarea rows="6" cols="40" name="visitnote_Other1" size="35px" id="visitnote_Other1"><?php echo stripslashes($obj{"visitnote_Other1"});?></textarea>
       </div> </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e'); ?></strong>
      <textarea name="visitnote_Specific_Training_Visit" cols="100" id="visitnote_Specific_Training_Visit" 
      value="<?php echo stripslashes($obj{"visitnote_Specific_Training_Visit"});?>" ></textarea>
      <br />
      <strong><?php xl('Has the patient had any changes in medications since the last visit?','e'); ?>
      <input type="checkbox" name="visitnote_changes_in_medications" id="visitnote_changes_in_medications" value="Yes"
<?php if ($obj{"visitnote_changes_in_medications"} == "Yes")	echo "checked";;?> >
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_changes_in_medications" id="visitnote_changes_in_medications" value="No"
  <?php if ($obj{"visitnote_changes_in_medications"} == "No")	echo "checked";;?> >
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
            <input type="checkbox" name="visitnote_Improved_Oral_Stage" <?php if ($obj{"visitnote_Improved_Oral_Stage"} == "on"){echo "checked";};?> id="visitnote_Improved_Oral_Stage" />
            <label><?php xl('Improved Oral Stage skills in','e');?></label>
            <input type="text" style="width:56%" name="visitnote_Improved_Oral_Stage_In" value="<?php echo stripslashes($obj{"visitnote_Improved_Oral_Stage_In"});?>" id="visitnote_Improved_Oral_Stage_In" /><br>
            <input type="checkbox" name="visitnote_Improved_Pharyngeal_Stage"  <?php if ($obj{"visitnote_Improved_Pharyngeal_Stage"} == "on"){echo "checked";};?> id="visitnote_Improved_Pharyngeal_Stage" />
            <label><?php xl('Improved Pharyngeal Stage Skills in','e');?></label>
            <input type="text" style="width:50%" name="visitnote_Improved_Pharyngeal_Stage_In" value="<?php echo stripslashes($obj{"visitnote_Improved_Pharyngeal_Stage_In"});?>" id="visitnote_Improved_Pharyngeal_Stage_In" />

	    <br/>
	    <input type="checkbox" name="visitnote_Improved_Verbal_Expression"  <?php if ($obj{"visitnote_Improved_Verbal_Expression"} == "on"){echo "checked";};?> id="visitnote_Improved_Verbal_Expression" />
            <label><?php xl(' Improved Verbal Expression in','e');?></label>
            <input type="text" name="visitnote_Improved_Verbal_Expression_In" style="width:55%" value="<?php echo stripslashes($obj{"visitnote_Improved_Verbal_Expression_In"});?>" id="visitnote_Improved_Verbal_Expression_In" /><br>
            <input type="checkbox" name="visitnote_Improved_Non_Verbal_Expression"  <?php if ($obj{"visitnote_Improved_Non_Verbal_Expression"} == "on"){echo "checked";};?> id="visitnote_Improved_Non_Verbal_Expression" />
            <label><?php xl('Improved Non Verbal Expression in','e');?></label>
            <input type="text" name="visitnote_Improved_Non_Verbal_Expression_In" style="width:51%" value="<?php echo stripslashes($obj{"visitnote_Improved_Non_Verbal_Expression_In"});?>" id="visitnote_Improved_Non_Verbal_Expression_In" />

	    <br/>
            <input type="checkbox" name="visitnote_Improved_Comprehension"  
	      <?php if ($obj{"visitnote_Improved_Comprehension"} == "on"){echo "checked";};?> 
	      id="visitnote_Improved_Comprehension" />
            <label><?php xl('Improved Comprehension in','e');?></label>
            <input type="text" name="visitnote_Improved_Comprehension_In" style="width:56%" value="<?php echo stripslashes($obj{"visitnote_Improved_Comprehension_In"});?>" id="visitnote_Improved_Comprehension_In" />

	    <br/>
            <input type="checkbox" name="visitnote_Caregiver_Family_Performance" <?php if ($obj{"visitnote_Caregiver_Family_Performance"} == "on"){echo "checked";};?> id="visitnote_Caregiver_Family_Performance" />
            <label><?php xl('Caregiver/Family Performance in','e');?></label>
            <input type="text" name="visitnote_Caregiver_Family_Performance_In" style="width:52%" value="<?php echo stripslashes($obj{"visitnote_Caregiver_Family_Performance_In"});?>" id="visitnote_Caregiver_Family_Performance_In" />
	                

	    <br/>
	    <input type="checkbox" name="visitnote_Functional_Improvements_Other" <?php if ($obj{"visitnote_Functional_Improvements_Other"} == "on"){echo "checked";};?> id="visitnote_Functional_Improvements_Other" />
	    <label><?php xl('Other','e');?></label>
	    <input type="text" name="visitnote_Functional_Improvements_Other_Note" style="width:91%" id="visitnote_Functional_Improvements_Other_Note" value="<?php echo stripslashes($obj{"visitnote_Functional_Improvements_Other_Note"});?>" />

	    <br/>
           <?php xl('Additional Comments Regarding Discharge Status of Patient','e');?>
            <input type="text" name="visitnote_FI_Additional_Comments" style="width:56%" value="<?php echo stripslashes($obj{"visitnote_FI_Additional_Comments"});?>" id="visitnote_FI_Additional_Comments" />
          </p></td>

        </tr>
        </table>
 </tr>
 
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PATIENT/CAREGIVER/FAMILY RESPONSE TO VISIT','e'); ?>&nbsp;</strong> 
    <input type="checkbox" name="visitnote_Response_To_Visit" value="Verbalized Understanding" id="visitnote_Response_To_Visit" 
    <?php if ($obj{"visitnote_Response_To_Visit"} == "Verbalized Understanding") echo "checked";;?> />
<?php xl('Verbalized Understanding','e'); ?>
  <input type="checkbox" name="visitnote_Response_To_Visit" value="Demonstrated Task" id="visitnote_Response_To_Visit" 
  <?php if ($obj{"visitnote_Response_To_Visit"} == "Demonstrated Task") echo "checked";;?> />
<?php xl('Demonstrated Task','e'); ?>&nbsp;<br>
<input type="checkbox" name="visitnote_Response_To_Visit" value="Needed Guidance" id="visitnote_Response_To_Visit" 
<?php if ($obj{"visitnote_Response_To_Visit"} == "Needed Guidance") echo "checked";;?> />
<?php xl('Needed Guidance/Re-Instruction','e'); ?>&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> <strong>
<input type="text" style="width:66%" name="visitnote_Response_To_Visit_Other" id="visitnote_Response_To_Visit_Other" 
value="<?php echo stripslashes($obj{"visitnote_Response_To_Visit_Other"});?>" >
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong>
    <input type="checkbox" name="visitnote_CarePlan_Reviewed" id="visitnote_CarePlan_Reviewed" 
    <?php if ($obj{"visitnote_CarePlan_Reviewed_With"} == "on") echo "checked";;?> />
<?php xl('CARE PLAN REVIEWED WITH','e'); ?>
  <input type="checkbox" name="visitnote_Discharge_Discussed" id="visitnote_Discharge_Discussed" 
  <?php if ($obj{"visitnote_Discharge_Discussed_With"} == "on") echo "checked";;?> />
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
<?php xl('Caregiver/Family','e');?>
<input type="checkbox" name="visitnote_Discharge_Discussed_With" value="Case Manager" id="visitnote_CPRW_Case_Manager" 
<?php if ($obj{"visitnote_Discharge_Discussed_With"} == "Case Manager") echo "checked";;?> />
<?php xl('Case Manager','e'); ?><br> 
 <?php xl('Other','e'); ?>&nbsp;
<input type="text" style="width:93%" name="visitnote_CPRW_Other" id="visitnote_CPRW_Other" 
value="<?php echo stripslashes($obj{"visitnote_CPRW_Other"});?>" >
<br />
<input type="checkbox" name="visitnote_CarePlan_Modifications" id="visitnote_CarePlan_Modifications" 
  <?php if ($obj{"visitnote_CarePlan_Modifications"} == "on") echo "checked";;?> />
<strong><?php xl('CARE PLANS MODIFICATIONS INCLUDE','e'); ?>&nbsp;
<input type="text" style="width:64%" name="visitnote_CarePlan_Modifications_Include" id="visitnote_CarePlan_Modifications_Include" 
value="<?php echo stripslashes($obj{"visitnote_CarePlan_Modifications_Include"});?>" >
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row">
    <strong><?php xl('FURTHER SKILLED VISITS REQUIRED TO','e'); ?></strong><br> 
    <input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Reprioritize exercise" id="visitnote_FSVR_Progress_Reprioritize_exercise" 
    <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Reprioritize exercise") echo "checked";;?> />
<?php xl('Progress/Re-prioritize exercise program','e'); ?><br>
  <input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Train patient" id="visitnote_FSVR_Train_patient" 
      <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Train patient") echo "checked";;?> />
<?php xl('Train patient in additional skills such as','e'); ?>&nbsp;
<input type="text" style="width:66%" name="visitnote_Train_patient_Suchas_Notes" id="visitnote_Train_patient_Suchas_Notes" 
value="<?php echo stripslashes($obj{"visitnote_Train_patient_Suchas_Notes"});?>" >
<br/>
<input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Caregiver/Family" id="visitnote_FSVR_Train_Caregiver_Family" 
<?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Caregiver/Family") echo "checked";;?> />
<?php xl('Train Caregiver/Family','e'); ?> &nbsp; &nbsp;&nbsp;
<?php xl('Other','e'); ?>
<strong>
<input type="text" style="width:73%" name="visitnote_FSVR_Other" id="visitnote_FSVR_Other" 
value="<?php echo stripslashes($obj{"visitnote_FSVR_Other"});?>" >
</strong><br>
 <?php xl('Approximate Date of Next Visit','e'); ?>
&nbsp;<input type='text' size='10' name='visitnote_Date_of_Next_Visit' id='visitnote_Date_of_Next_Visit' 
title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'
value="<?php echo stripslashes($obj{"visitnote_Date_of_Next_Visit"});?>"  readonly/> 
<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
height='22' id='img_curr_date' border='0' alt='[?]'
style='cursor: pointer; cursor: hand'
title='<?php xl('Click here to choose a date','e'); ?>'> 
<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"visitnote_Date_of_Next_Visit", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
 </script>

<br><input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Met Goals" id="visitnote_Date_of_Next_Visit" 
  <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Met Goals") echo "checked";;?> />
<?php xl('No further visits required Patient/Caregiver have met goals','e'); ?>
<br><input type="checkbox" name="visitnote_Further_Skilled_Visits_Required" value="Met max potential" id="visitnote_No_further_visits_PC_Met_max_potential" 
  <?php if ($obj{"visitnote_Further_Skilled_Visits_Required"} == "Met max potential") echo "checked";;?> />
<?php xl('No further visits required. Patient/Caregiver have met maximum  potential that can be impacted by therapy.','e'); ?>
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PLAN','e'); ?></strong><br/>
      <input type="checkbox" name="visitnote_Plan_Type" value="Current Treatment Appropriate" id="visitnote_Plan_Current_Treatment_Plan" 
      <?php if ($obj{"visitnote_Plan_Type"} == "Current Treatment Appropriate") echo "checked";;?> />
<?php xl('Current Treatment Plan Frequency and Duration is Appropriate','e'); ?><br>
<input type="checkbox" name="visitnote_Plan_Type" value="Initiate Discharge" id="visitnote_Plan_Initiate_Discharge" 
<?php if ($obj{"visitnote_Plan_Type"} == "Initiate Discharge") echo "checked";;?> />
<?php xl('Initiate Discharge, physician order and summary of treatment','e'); ?><br>
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
<?php xl('communication, language barriers','e'); ?><br>
<input type="checkbox" name="visitnote_Plan_Type" value="Will address issues by" id="visitnote_Plan_Address_above_issues"
<?php if ($obj{"visitnote_Plan_Type"} == "Will address issues by") echo "checked";;?> />
<?php xl('Will address above issues by','e'); ?>&nbsp;
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="physical demonstration" id="visitnote_Plan_Providing_written_directions" 
<?php if ($obj{"visitnote_Address_Above_Issues_By"} == "physical demonstration") echo "checked";;?> />
<?php xl('Providing written directions and/or physical demonstration','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="community support" id="visitnote_Plan_Establish_community_support" 
<?php if ($obj{"visitnote_Address_Above_Issues_By"} == "community support") echo "checked";;?> />
<?php xl('establish community support systems','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="home adaptations " id="visitnote_Plan_Home_env_adaptations" 
<?php if ($obj{"visitnote_Address_Above_Issues_By"} == "home adaptations") echo "checked";;?> />
<?php xl('home/environmental adaptations','e'); ?>
<input type="checkbox" name="visitnote_Address_Above_Issues_By" value="use family/professionals" id="visitnote_Plan_Use_family_professionals" 
<?php if ($obj{"visitnote_Address_Above_Issues_By"} == "use family/professionals") echo "checked";;?> />
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
<a href="javascript:top.restoreSession();document.visitnotes.submit();" class="link_submit">[<?php xl('Save','e');?>]</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                    <input type="button" value="Back" onclick="top.restoreSession();window.location='<?php echo $GLOBALS['webroot'] ?>/interface/patient_file/encounter/encounter_top.php';"/>&nbsp;&nbsp;
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

