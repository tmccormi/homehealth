<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"||strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";

$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_ot_visitnote";

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
	    obj.open("GET",site_root+"/forms/visit_notes/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
  
     $(document).ready(function() {
        var status = "";

        $("#signoff").fancybox({
        'scrolling'             : 'no',
        'titleShow'             : false,
        'onClosed'              : function() {
            $("#login_prompt").hide();

        }
        });

                //for Signature
        $("#login_form").bind("submit", function() {

            document.getElementById("login_pass").value = SHA1(document.getElementById("login_pass").value);

            if ($("#login_pass").val().length < 1) {
                $("#login_prompt").show();
                $.fancybox.resize();
                return false;
            }

            $.fancybox.showActivity();

            $.ajax({
                type            : "POST",
                cache   : false,
                url             : "<?php echo $GLOBALS['rootdir'] . "/forms/$formDir/sign.php";?>",
                data            : $(this).serializeArray(),
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
$obj = formFetch("forms_ot_visitnote", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>
<form method=post action="<?php echo $rootdir?>/forms/visit_notes/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="visitnotes">
<h3 align="center"><?php xl('OCCUPATIONAL THERAPY VISIT NOTE','e'); ?></h3>

<br></br>
<table width="100%" border="1" cellpadding="2px" class="formtable">
  <tr>
    <td scope="row">
    <table width="100%" border="1" cellpadding="2px" class="formtable">
      <tr>
        <td scope="row"><strong><?php xl('Patient Name','e'); ?></strong></td>
        <td align="center" valign="top">
        <input type="text" id="patient_name" value="<?php patientName()?>" readonly/></td>
        <td><strong><?php xl('Time In','e'); ?></strong></td>
        <td><select name="visitnote_Time_In" id="visitnote_Time_In"><?php timeDropDown(stripslashes($obj{"visitnote_Time_In"})) ?></select></td>
        <td><strong><?php xl('Time Out','e'); ?></strong></td>
        <td><select name="visitnote_Time_Out" id="visitnote_Time_Out"><?php timeDropDown(stripslashes($obj{"visitnote_Time_Out"})) ?></select></td>
        <td><strong><?php xl('Date','e'); ?></strong></td>
        <td>
        <strong>
    <input type='text' size='20' name='visitnote_date_curr' id='visitnote_date_curr'
    value='<?php echo stripslashes($obj{"visitnote_date_curr"});?>'
    title='<?php xl('Date','e'); ?>'
   onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/>
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"visitnote_date_curr", ifFormat:"%Y-%m-%d", button:"img_date"});
   </script>
        </strong>
       </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('TYPE OF VISIT','e'); ?> </strong>
      <input type="checkbox" name="visitnote_visit_type" value="visit" id="visitnote_TOV_Visit"  
      <?php if ($obj{"visitnote_visit_type"} == "visit")
				echo "checked";;?>/>
<?php xl('Visit','e'); ?>
<input type="checkbox" name="visitnote_visit_type" value="visit_Supervisory" id="visitnote_TOV_Visit_Supervisory" 
<?php if ($obj{"visitnote_visit_type"} == "visit_Supervisory")	echo "checked";;?>/>
<?php xl('Visit and Supervisory Review','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> 
<input type="text" style="width:460px" name="visitnote_TOV_Visit_Other" id="visitnote_TOV_Visit_Other" value="<?php echo stripslashes($obj{"visitnote_TOV_Visit_Other"});?>" />
</td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('VITAL SIGNS','e'); ?></strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pulse','e'); ?> 
    <input type="text" size="3px" name="visitnote_VS_Pulse" id="visitnote_VS_Pulse" value="<?php echo stripslashes($obj{"visitnote_VS_Pulse"});?>" > 
    <input type="checkbox" name="visitnote_Pulse_Rate" value="regular" id="visitnote_VS_Pulse_Regular" 
     <?php if ($obj{"visitnote_Pulse_Rate"} == "regular")	echo "checked";;?> />
<?php xl('Regular','e'); ?>
<input type="checkbox" name="visitnote_Pulse_Rate" value="Irregular" id="visitnote_VS_Pulse_Irregular"
 <?php if ($obj{"visitnote_Pulse_Rate"} == "Irregular")	echo "checked";;?> />
<?php xl('Irregular','e'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Temperature','e'); ?>
 <input type="text" size="3px" name="visitnote_VS_Temperature" id="visitnote_VS_Temperature" value="<?php echo stripslashes($obj{"visitnote_VS_Temperature"});?>" >  
 <input type="checkbox" name="visitnote_Temperature" value="Oral" id="visitnote_VS_Temperature_Oral" 
  <?php if ($obj{"visitnote_Temperature"} == "Oral")	echo "checked";;?> />
<?php xl('Oral','e'); ?>
<input type="checkbox" name="visitnote_Temperature" value="Temporal" id="visitnote_VS_Temperature_Temporal"
<?php if ($obj{"visitnote_Temperature"} == "Temporal")	echo "checked";;?> />
<?php xl('Temporal','e'); ?>&nbsp;
<?php xl('Other','e'); ?>
<input type="text" size="10px" name="visitnote_VS_Other" id="visitnote_VS_Other" value="<?php echo stripslashes($obj{"visitnote_VS_Other"});?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
 <?php xl('Respirations','e'); ?> 
 <input type="text" size="3px" name="visitnote_VS_Respirations" id="visitnote_VS_Respirations" value="<?php echo stripslashes($obj{"visitnote_VS_Respirations"});?>" >
 <p>
  <?php xl('Blood Pressure Systolic','e'); ?>
  <input type="text" size="3px" name="visitnote_VS_BP_Systolic" id="visitnote_VS_BP_Systolic" value="<?php echo stripslashes($obj{"visitnote_VS_BP_Systolic"});?>" >
  /
  <input type="text" size="3px" name="visitnote_VS_BP_Diastolic" id="visitnote_VS_BP_Diastolic" value="<?php echo stripslashes($obj{"visitnote_VS_BP_Diastolic"});?>" >
<input type="checkbox" name="visitnote_BloodPrerssure_side" value="Right" id="visitnote_VS_BP_Right" 
<?php if ($obj{"visitnote_BloodPrerssure_side"} == "Right")	echo "checked";;?> />
<?php xl('Right','e'); ?>
<input type="checkbox" name="visitnote_BloodPrerssure_side" value="Left" id="visitnote_VS_BP_Left" 
<?php if ($obj{"visitnote_BloodPrerssure_side"} == "Left")	echo "checked";;?> />
<?php xl('Left','e'); ?>
<input type="checkbox" name="visitnote_BloodPrerssure_position" value="Sitting" id="visitnote_VS_BP_Sitting" 
<?php if ($obj{"visitnote_BloodPrerssure_position"} == "Sitting")	echo "checked";;?> />
<?php xl('Sitting','e'); ?>
<input type="checkbox" name="visitnote_BloodPrerssure_position" value="Standing" id="visitnote_VS_BP_Standing" 
<?php if ($obj{"visitnote_BloodPrerssure_position"} == "Standing")	echo "checked";;?> />
<?php xl('Standing','e'); ?>
<input type="checkbox" name="visitnote_BloodPrerssure_position" value="Lying" id="visitnote_VS_BP_Lying"
<?php if ($obj{"visitnote_BloodPrerssure_position"} == "Lying")	echo "checked";;?> />
<?php xl('Lying','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('*O','e'); ?><sub><?php xl('2','e'); ?></sub><?php xl('Sat','e'); ?>&nbsp;
<input type="text" size="7px" name="visitnote_VS_BP_Sat" id="visitnote_VS_BP_Sat" 
value="<?php echo stripslashes($obj{"visitnote_VS_BP_Sat"});?>" >
  *<?php xl('Physician ordered','e'); ?> </td>
</p>
  </tr>
  <tr>
    <td valign="top" scope="row"><?php xl('Pain','e'); ?>
  <input type="checkbox" name="visitnote_Pain_Level" value="Nopain" id="visitnote_VS_Pain_Nopain" 
  <?php if ($obj{"visitnote_Pain_Level"} == "Nopain")	echo "checked";;?> />
<?php xl('No Pain','e'); ?>
<input type="checkbox" name="visitnote_Pain_Level" value="Pain limits functional ability" id="visitnote_VS_Pain_Pain_limits" 
 <?php if ($obj{"visitnote_Pain_Level"} == "Pain limits functional ability")	echo "checked";;?> />
<?php xl('Pain limits functional ability','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Intensity','e'); ?>
<input type="text" name="visitnote_VS_Pain_Intensity" id="visitnote_VS_Pain_Intensity" 
value="<?php echo stripslashes($obj{"visitnote_VS_Pain_Intensity"});?>" >
<input type="checkbox" name="visitnote_Pain_Intensity" value="Improve" id="visitnote_VS_Pain_Intensity_Improve" 
<?php if ($obj{"visitnote_Pain_Intensity"} == "Improve")	echo "checked";;?> />
<?php xl('Improve','e'); ?>
<input type="checkbox" name="visitnote_Pain_Intensity" value="Worse" id="visitnote_VS_Pain_Intensity_Worse"
<?php if ($obj{"visitnote_Pain_Intensity"} == "Worse")	echo "checked";;?> />
<?php xl('Worse','e'); ?>
<input type="checkbox" name="visitnote_Pain_Intensity" value="No_Change" id="visitnote_VS_Pain_Intensity_No_Change"
<?php if ($obj{"visitnote_Pain_Intensity"} == "No_Change")	echo "checked";;?> />
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
                <td>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Medical_Restrictions" id="visitnote_Pat_Homebound_Medical_Restrictions" 
                  <?php if ($obj{"visitnote_Pat_Homebound_Medical_Restrictions"} == "on")	echo "checked";;?> />
                  <?php xl('Medical Restrictions in','e'); ?>
                  <input type="text" name="visitnote_Pat_Homebound_Medical_Restrictions_In" style="width:280px" id="visitnote_Pat_Homebound_Medical_Restrictions_In" 
                 value="<?php echo stripslashes($obj{"visitnote_Pat_Homebound_Medical_Restrictions_In"});?>" >
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" name="visitnote_Pat_Homebound_SOB_upon_exertion" id="visitnote_Pat_Homebound_SOB_upon_exertion" 
                   <?php if ($obj{"visitnote_Pat_Homebound_SOB_upon_exertion"} == "on")	echo "checked";;?> />
                  <?php xl('SOB upon exertion','e'); ?>
                  <input type="checkbox" name="visitnote_Pat_Homebound_Pain_with_Travel" id="visitnote_Pat_Homebound_Pain_with_Travel" 
                  <?php if ($obj{"visitnote_Pat_Homebound_Pain_with_Travel"} == "on")	echo "checked";;?> />
                  <?php xl('Pain with Travel','e'); ?></td>
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
              <input type="text" name="visitnote_Pat_Homebound_Other" style="width:370px" id="visitnote_Pat_Homebound_Other" value="<?php echo stripslashes($obj{"visitnote_Pat_Homebound_Other"});?>" >
            </p></td>
        </tr>
    </table>      
      <strong><?php xl('INTERVENTIONS','e'); ?> 
      <input type="checkbox" name="visitnote_Interventions_Patient" id="visitnote_Interventions_Patient" 
      <?php if ($obj{"visitnote_Interventions_Patient"} == "on")	echo "checked";;?> >
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_Interventions_Caregiver" id="visitnote_Interventions_Caregiver" 
<?php if ($obj{"visitnote_Interventions_Caregiver"} == "on")	echo "checked";;?> >
<?php xl('Caregiver','e'); ?>
<input type="checkbox" name="visitnote_Interventions_Patient_Caregiver" id="visitnote_Interventions_Patient_Caregiver" 
<?php if ($obj{"visitnote_Interventions_Patient_Caregiver"} == "on")	echo "checked";;?> >
<?php xl('Patient and Caregiver','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?>
<input type="text" name="visitnote_Interventions_Other" style="width:340px" id="visitnote_Interventions_Other" value="<?php echo stripslashes($obj{"visitnote_Interventions_Other"});?>" >
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
                <input type="checkbox" name="visitnote_Home_Safety_Evaluation" id="visitnote_Home_Safety_Evaluation" 
                <?php if ($obj{"visitnote_Home_Safety_Evaluation"} == "on")	echo "checked";;?> >
                <?php xl('Home Safety Evaluation/Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_IADL_ADL_Training" id="visitnote_IADL_ADL_Training" 
                <?php if ($obj{"visitnote_IADL_ADL_Training"} == "on")	echo "checked";;?> >
                <?php xl('IADL/ADL Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Muscle_ReEducation" id="visitnote_Muscle_ReEducation" 
                  <?php if ($obj{"visitnote_Muscle_ReEducation"} == "on")	echo "checked";;?> >
                <?php xl('Muscle Re-Education','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Visual_Perceptual_Training" id="visitnote_Visual_Perceptual_Training" 
                <?php if ($obj{"visitnote_Visual_Perceptual_Training"} == "on")	echo "checked";;?> >
                <?php xl('Visual/Perceptual Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Fine_Gross_Motor_Training" id="visitnote_Fine_Gross_Motor_Training" 
                <?php if ($obj{"visitnote_Fine_Gross_Motor_Training"} == "on")	echo "checked";;?> >
                <?php xl('Fine/Gross Motor Training','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Patient_Caregiver_Family_Education" id="visitnote_Patient_Caregiver_Family_Education" 
                <?php if ($obj{"visitnote_Patient_Caregiver_Family_Education"} == "on")	echo "checked";;?> >
               <?php xl('Patient/Caregiver/Family Education','e'); ?> </label></td>
            </tr>
          </table>
        </td>
        <td>
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Therapeutic_Exercises" id="visitnote_Therapeutic_Exercises" 
                <?php if ($obj{"visitnote_Therapeutic_Exercises"} == "on")	echo "checked";;?> >
               <?php xl('Therapeutic Exercises for UEs','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Neuro_developmental_Training" id="visitnote_Neuro_developmental_Training" 
                <?php if ($obj{"visitnote_Neuro_developmental_Training"} == "on")	echo "checked";;?> >
             <?php xl('Neuro-developmental Training','e'); ?>   </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Sensory_Training" id="visitnote_Sensory_Training" 
                <?php if ($obj{"visitnote_Sensory_Training"} == "on")	echo "checked";;?> >
               <?php xl('Sensory Training','e'); ?> </label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Orthotics_Splinting" id="visitnote_Orthotics_Splinting" 
                <?php if ($obj{"visitnote_Orthotics_Splinting"} == "on")	echo "checked";;?> >
                <?php xl('Orthotics/Splinting','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Adaptive_Equipment_training" id="visitnote_Adaptive_Equipment_training" 
                <?php if ($obj{"visitnote_Adaptive_Equipment_training"} == "on")	echo "checked";;?> >
               <?php xl('Adaptive Equipment training','e'); ?> </label></td>
            </tr>
          </table>
        </td>
        <td>
          <table width="100%" class="formtable">
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Teach_Home_Fall_Safety_Precautions" id="visitnote_Teach_Home_Fall_Safety_Precautions" 
                <?php if ($obj{"visitnote_Teach_Home_Fall_Safety_Precautions"} == "on")	echo "checked";;?> >
                <?php xl('Teach Home/Fall Safety Precautions','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Teach_alternative_bathing_skills" id="visitnote_Teach_alternative_bathing_skills" 
                <?php if ($obj{"visitnote_Teach_alternative_bathing_skills"} == "on")	echo "checked";;?> >
                <?php xl('Teach alternative bathing, skills (unable to use tub/shower safely)','e'); ?></label></td>
            </tr>
            <tr>
              <td><label>
                <input type="checkbox" name="visitnote_Exercises_Safety_Techniques" id="visitnote_Exercises_Safety_Techniques" 
                <?php if ($obj{"visitnote_Exercises_Safety_Techniques"} == "on")	echo "checked";;?> >
               <?php xl('Exercises/ Safety Techniques given to patient','e'); ?> </label></td>
            </tr>
          </table>
          <p><?php xl('Other','e'); ?>
            <input type="text" name="visitnote_Interventions_Other1" style="width:340px" id="visitnote_Interventions_Other1" value="<?php echo stripslashes($obj{"visitnote_Interventions_Other1"});?>" >
          </p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SPECIFIC TRAINING THIS VISIT','e'); ?></strong><br>
      <textarea name="visitnote_Specific_Training_Visit" id="visitnote_Specific_Training_Visit" cols="118" rows="2"><?php echo stripslashes($obj{"visitnote_Specific_Training_Visit"});?></textarea>
      <br />
      <strong><?php xl('Has the patient had any changes in medications since the last visit?','e'); ?>
      <input type="checkbox" name="visitnote_changes_in_medications_Yes" id="visitnote_changes_in_medications_Yes"  value="Yes" <?php if($obj{"visitnote_changes_in_medications_Yes"}=="Yes"){ echo "checked"; }?> />
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_changes_in_medications_Yes" id="visitnote_changes_in_medications_No" value="No" <?php if($obj{"visitnote_changes_in_medications_Yes"}=="No"){ echo "checked"; }?>  />
<?php xl('No','e'); ?>
      <br />     <?php xl('If yes, update medication profile','e'); ?> </strong><br />
    </td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('FUNCTIONAL IMPROVEMENTS IN THE FOLLOWING AREAS','e'); ?><br />
    </strong>
      <input type="checkbox" name="visitnote_Functional_Improvement_ADL" id="visitnote_Functional_Improvement_ADL" 
      <?php if ($obj{"visitnote_Functional_Improvement_ADL"} == "on")	echo "checked";;?> >
<?php xl('ADL','e'); ?> 
<input type="text" style="width:158px" name="visitnote_Functional_Improvement_ADL_Notes" id="visitnote_Functional_Improvement_ADL_Notes" value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_ADL_Notes"});?>" >
<input type="checkbox" name="visitnote_Functional_Improvement_ADL1" id="visitnote_Functional_Improvement_ADL1" 
<?php if ($obj{"visitnote_Functional_Improvement_ADL1"} == "on")	echo "checked";;?> >
<?php xl('ADL','e'); ?>
<input type="text" style="width:158px" name="visitnote_Functional_Improvement_ADL1_Notes" id="visitnote_Functional_Improvement_ADL1_Notes" 
value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_ADL1_Notes"});?>" >
<input type="checkbox" name="visitnote_Functional_Improvement_IADL" id="visitnote_Functional_Improvement_IADL" 
<?php if ($obj{"visitnote_Functional_Improvement_IADL"} == "on")	echo "checked";;?> >
<?php xl('IADL','e'); ?> 
<input type="text" style="width:158px" name="visitnote_Functional_Improvement_IADL_Notes" id="visitnote_Functional_Improvement_IADL_Notes" 
value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_IADL_Notes"});?>" >
<input type="checkbox" name="visitnote_Functional_Improvement_IADL1" id="visitnote_Functional_Improvement_IADL1" 
<?php if ($obj{"visitnote_Functional_Improvement_IADL1"} == "on")	echo "checked";;?> >
<?php xl('IADL','e'); ?> 
<input type="text" style="width:158px" name="visitnote_Functional_Improvement_IADL1_Notes" id="visitnote_Functional_Improvement_IADL1_Notes" 
value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_IADL1_Notes"});?>" > 
<br />
<input type="checkbox" name="visitnote_Functional_Improvement_ROM" id="visitnote_Functional_Improvement_ROM" 
<?php if ($obj{"visitnote_Functional_Improvement_ROM"} == "on")	echo "checked";;?> >
<?php xl('ROM in','e'); ?>&nbsp;
<input type="text" style="width:800px" name="visitnote_Functional_Improvement_ROM_In" id="visitnote_Functional_Improvement_ROM_In" 
value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_ROM_In"});?>" ><br>  
<input type="checkbox" name="visitnote_Functional_Improvement_SM" id="visitnote_Functional_Improvement_SM" 
<?php if ($obj{"visitnote_Functional_Improvement_SM"} == "on")	echo "checked";;?> >
<?php xl('Safety Management in','e'); ?>&nbsp;
<input type="text" style="width:700px" name="visitnote_Functional_Improvement_SM_In" id="visitnote_Functional_Improvement_SM_In" 
value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_SM_In"});?>" > 
<br />
<input type="checkbox" name="visitnote_Functional_Improvement_EA" id="visitnote_Functional_Improvement_EA" 
<?php if ($obj{"visitnote_Functional_Improvement_EA"} == "on")	echo "checked";;?> >
<?php xl('Environment Adaptations including','e'); ?>&nbsp;
<input type="text" style="width:615px" name="visitnote_Functional_Improvement_EA_including" id="visitnote_Functional_Improvement_EA_including" 
value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_EA_including"});?>" >  
<br />
<input type="checkbox" name="visitnote_Functional_Improvement_AEU" id="visitnote_Functional_Improvement_AEU" 
<?php if ($obj{"visitnote_Functional_Improvement_AEU"} == "on")	echo "checked";;?> >
<?php xl('Adaptive Equipment Usage for','e'); ?>&nbsp;
<input type="text" style="width:640px" name="visitnote_Functional_Improvement_AEU_For" id="visitnote_Functional_Improvement_AEU_For" 
value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_AEU_For"});?>" ><br>
<input type="checkbox" name="visitnote_Functional_Improvement_Car_Fam_Perf" id="visitnote_Functional_Improvement_Car_Fam_Perf" 
<?php if ($obj{"visitnote_Functional_Improvement_Car_Fam_Perf"} == "on")	echo "checked";;?> >
<?php xl('Caregiver/Family Performance in','e'); ?>&nbsp;
<input type="text" style="width:620px" name="visitnote_Functional_Improvement_Car_Fam_Perf_In" id="visitnote_Functional_Improvement_Car_Fam_Perf_In" 
value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_Car_Fam_Perf_In"});?>" >  
<br />
<input type="checkbox" name="visitnote_Functional_Improvement_Perf_Home_Exer" id="visitnote_Functional_Improvement_Perf_Home_Exer" 
<?php if ($obj{"visitnote_Functional_Improvement_Perf_Home_Exer"} == "on")	echo "checked";;?> >
<?php xl('Performance of Home Exercises for','e'); ?>&nbsp;
 <input type="text" style="width:602px" name="visitnote_Functional_Improvement_Perf_Home_Exer_For" id="visitnote_Functional_Improvement_Perf_Home_Exer_For" 
 value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_Perf_Home_Exer_For"});?>" >  
 <br /> 
 <?php xl('Other','e'); ?>&nbsp;
<input type="text" style="width:900px" name="visitnote_Functional_Improvement_Other" id="visitnote_Functional_Improvement_Other" 
 value="<?php echo stripslashes($obj{"visitnote_Functional_Improvement_Other"});?>" >  </td>

  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('Has the patient had a fall since the last visit? ','e'); ?>
      <input type="checkbox" name="visitnote_Previous_fall" value="yes" id="visitnote_Fall_since_Last_Visit_Yes" 
      <?php if ($obj{"visitnote_Previous_fall"} == "yes") echo "checked";;?> />
<?php xl('Yes','e'); ?>
<input type="checkbox" name="visitnote_Previous_fall" value="no" id="visitnote_Fall_since_Last_Visit_No" 
<?php if ($obj{"visitnote_Previous_fall"} == "no") echo "checked";;?> />
<?php xl('No If Yes, complete incident report.','e'); ?><br />
<?php xl('Timed Up and Go Score ','e'); ?>
<input type="text" name="visitnote_Timed_Up_Go_Score" id="visitnote_Timed_Up_Go_Score" 
 value="<?php echo stripslashes($obj{"visitnote_Timed_Up_Go_Score"});?>" > 
    </strong> <strong> <?php xl('Interpretation','e'); ?> </strong>
    <input type="checkbox" name="visitnote_Fall_Risk" value="No Fall Risk" id="visitnote_Interpretation_No_Fall_Risk"
    <?php if ($obj{"visitnote_Fall_Risk"} == "No Fall Risk") echo "checked";;?> />
<strong><?php xl('Independent-No Fall Risk (&lt; 11 seconds)','e'); ?></strong>
<input type="checkbox" name="visitnote_Fall_Risk" value="Minimal Fall Risk" id="visitnote_Interpretation_Minimal_Fall_Risk" 
 <?php if ($obj{"visitnote_Fall_Risk"} == "Minimal Fall Risk") echo "checked";;?> />
<strong><?php xl('Minimal Fall Risk (11- 13 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Fall_Risk" value="Moderate Fall Risk" id="visitnote_Interpretation_Moderate_Fall_Risk"
 <?php if ($obj{"visitnote_Fall_Risk"} == "Moderate Fall Risk") echo "checked";;?> />
<strong><?php xl('Moderate Fall Risk (13.5-19 seconds)','e'); ?> </strong>
<input type="checkbox" name="visitnote_Fall_Risk" value="High Fall Risk" id="visitnote_Interpretation_High_Fall_Risk" 
 <?php if ($obj{"visitnote_Fall_Risk"} == "High Fall Risk") echo "checked";;?> />
<strong><?php xl('High Risk for Falls (&gt;19 seconds)','e'); ?> </strong><br />
<strong><?php xl('Other Tests/Scores/Interpretations','e'); ?> 
<input type="text" name="visitnote_Other_Tests_Scores_Interpretations" style="width:670px" id="visitnote_Other_Tests_Scores_Interpretations" 
value="<?php echo stripslashes($obj{"visitnote_Other_Tests_Scores_Interpretations"});?>" >
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PATIENT/CAREGIVER/FAMILY RESPONSE TO REVISIT','e'); ?></strong> 
    <input type="checkbox" name="visitnote_Response" value="Verbalized Understanding" id="visitnote_RT_Revisit_Verbalized_Understanding" 
    <?php if ($obj{"visitnote_Response"} == "Verbalized Understanding") echo "checked";;?> />
<?php xl('Verbalized Understanding','e'); ?>
  <input type="checkbox" name="visitnote_Response" value="Demonstrated Task" id="visitnote_RT_Revisit_Demonstrated_Task" 
  <?php if ($obj{"visitnote_Response"} == "Demonstrated Task") echo "checked";;?> />
<?php xl('Demonstrated Task','e'); ?>
<input type="checkbox" name="visitnote_Response" value="Needed Guidance" id="visitnote_RT_Revisit_Needed_Guidance" 
<?php if ($obj{"visitnote_Response"} == "Needed Guidance") echo "checked";;?> />
<?php xl('Needed Guidance/Re-Instruction','e'); ?><br />
<?php xl('Other','e'); ?> <strong>
<input type="text" style="width:900px" name="visitnote_RT_Revisit_Other" id="visitnote_RT_Revisit_Other" 
value="<?php echo stripslashes($obj{"visitnote_RT_Revisit_Other"});?>" >
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong>
    <input type="checkbox" name="visitnote_CarePlan_Reviewed_With" id="visitnote_CarePlan_Reviewed_With" 
    <?php if ($obj{"visitnote_CarePlan_Reviewed_With"} == "on") echo "checked";;?> />
<?php xl('CARE PLAN REVIEWED WITH','e'); ?>
  <input type="checkbox" name="visitnote_Discharge_Discussed_With" id="visitnote_Discharge_Discussed_With" 
  <?php if ($obj{"visitnote_Discharge_Discussed_With"} == "on") echo "checked";;?> />
<?php xl('DISCHARGE DISCUSSED WITH','e'); ?></strong>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Patient" id="visitnote_DDW_Patient" 
<?php if ($obj{"visitnote_CarePlan_Reviewed_to"} == "Patient") echo "checked";;?> />
<?php xl('Patient','e'); ?>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Physician" id="visitnote_DDW_Physician" 
<?php if ($obj{"visitnote_CarePlan_Reviewed_to"} == "Physician") echo "checked";;?> />
<?php xl('Physician','e'); ?>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="PT_OT_ST" id="visitnote_DDW_PT_OT_ST" 
<?php if ($obj{"visitnote_CarePlan_Reviewed_to"} == "PT_OT_ST") echo "checked";;?> />
<?php xl('PT/OT/ST','e'); ?><br />
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Skilled Nursing" id="visitnote_CPRW_Skilled_Nursing" 
<?php if ($obj{"visitnote_CarePlan_Reviewed_to"} == "Skilled Nursing") echo "checked";;?> />
<?php xl('Skilled Nursing','e'); ?>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Caregiver Family" id="visitnote_CPRW_Caregiver_Family" 
<?php if ($obj{"visitnote_CarePlan_Reviewed_to"} == "Caregiver Family") echo "checked";;?> />
<?php xl('Caregiver/Family','e'); ?>
<input type="checkbox" name="visitnote_CarePlan_Reviewed_to" value="Case Manager" id="visitnote_CPRW_Case_Manager" 
<?php if ($obj{"visitnote_CarePlan_Reviewed_to"} == "Case Manager") echo "checked";;?> />
<?php xl('Case Manager','e'); ?> &nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?> <strong>
<input type="text" name="visitnote_CPRW_Other" style="width:465px" id="visitnote_CPRW_Other" 
value="<?php echo stripslashes($obj{"visitnote_CPRW_Other"});?>" >
</strong>
<br />
<input type="checkbox" name="visitnote_CP_Modifications_Include" id="visitnote_CP_Modifications_Include" 
<?php if ($obj{"visitnote_CP_Modifications_Include"} == "on") echo "checked";;?> />
<strong><?php xl('CARE PLANS MODIFICATIONS INCLUDE','e'); ?>&nbsp;
<input type="text" style="width:610px" name="visitnote_CP_Modifications_Include_Notes" id="visitnote_CP_Modifications_Include_Notes" 
value="<?php echo stripslashes($obj{"visitnote_CP_Modifications_Include_Notes"});?>" >
</strong></td>
  </tr>
  <tr>
    <td valign="top" scope="row">
    <p><strong><?php xl('FURTHER SKILLED VISITS REQUIRED TO','e'); ?></strong> 
    <input type="checkbox" name="visitnote_further_Visit_Required" value="Reprioritize exercise" id="visitnote_FSVR_Progress_Reprioritize_exercise" 
    <?php if ($obj{"visitnote_further_Visit_Required"} == "Reprioritize exercise") echo "checked";;?> />
<?php xl('Progress/Re-prioritize exercise program','e'); ?>
  <input type="checkbox" name="visitnote_further_Visit_Required" value="Train patient" id="visitnote_FSVR_Train_patient" 
      <?php if ($obj{"visitnote_further_Visit_Required"} == "Train patient") echo "checked";;?> />
<?php xl('Train patient in additional skills such as','e'); ?><br>
<input type="checkbox" name="visitnote_further_Visit_Required" value="Begin Practice" id="visitnote_FSVR_Begin_Practice" 
    <?php if ($obj{"visitnote_further_Visit_Required"} == "Begin Practice") echo "checked";;?> />
<?php xl('Begin/Practice','e'); ?>
<input type="checkbox" name="visitnote_further_Visit_Required" value="IADLs" id="visitnote_FSVR_IADLs" 
    <?php if ($obj{"visitnote_further_Visit_Required"} == "IADLs") echo "checked";;?> />
<?php xl('IADLs','e'); ?>
<input type="checkbox" name="visitnote_further_Visit_Required" value="ADLs" id="visitnote_FSVR_ADLs" 
    <?php if ($obj{"visitnote_further_Visit_Required"} == "ADLs") echo "checked";;?> />
<?php xl('ADLs','e'); ?>
<input type="checkbox" name="visitnote_further_Visit_Required" value="Caregiver/Family" id="visitnote_FSVR_Train_Caregiver_Family" 
    <?php if ($obj{"visitnote_further_Visit_Required"} == "Caregiver/Family") echo "checked";;?> />
<?php xl('Train Caregiver/Family','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e'); ?>
<strong>
<input type="text" style="width:420px" name="visitnote_FSVR_Other" id="visitnote_FSVR_Other" 
value="<?php echo stripslashes($obj{"visitnote_FSVR_Other"});?>" >
</strong>
</p>
<p>
 <?php xl('Approximate Date of Next Visit','e'); ?>
<input type='text' size='20' name='visitnote_Date_of_Next_Visit' id='visitnote_Date_of_Next_Visit'
    value='<?php echo stripslashes($obj{"visitnote_Date_of_Next_Visit"});?>'
    title='<?php xl('Date','e'); ?>'
   onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/>
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_curr_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"visitnote_Date_of_Next_Visit", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
<input type="checkbox" name="visitnote_No_further_visits" value="Met Goals" id="visitnote_Date_of_Next_Visit" 
  <?php if ($obj{"visitnote_No_further_visits"} == "Met Goals") echo "checked";;?> />
<?php xl('No further visits required Patient/Caregiver have met goals','e'); ?>
<input type="checkbox" name="visitnote_No_further_visits" value="Met max potential" id="visitnote_No_further_visits_PC_Met_max_potential" 
  <?php if ($obj{"visitnote_No_further_visits"} == "Met max potential") echo "checked";;?> />
<?php xl('No further visits required. Patient/Caregiver have met maximum  potential that can be impacted by therapy.','e'); ?>
</p></td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('PLAN','e'); ?></strong><br/>
    <p>
      <input type="checkbox" name="treatment_Plan" value="Current Treatment Plan Frequency and Duration is Appropriate" id="visitnote_Plan_Current_Treatment_Plan" 
      <?php if ($obj{"treatment_Plan"} == "Current Treatment Plan Frequency and Duration is Appropriate") echo "checked";;?> />
<?php xl('Current Treatment Plan Frequency and Duration is Appropriate','e'); ?>
</p>
<p>
<input type="checkbox" name="treatment_Plan" value="Initiate Discharge, physician order and summary of treatment" id="visitnote_Plan_Initiate_Discharge" 
<?php if ($obj{"treatment_Plan"} == "Initiate Discharge, physician order and summary of treatment") echo "checked";;?> />
<?php xl('Initiate Discharge, physician order and summary of treatment','e'); ?>
</p>
<p>
<input type="checkbox" name="treatment_Plan" value="May require additional treatment session" id="visitnote_Plan_Require_Additional_Treatment" 
<?php if ($obj{"treatment_Plan"} == "May require additional treatment session") echo "checked";;?> />
<?php xl('May require additional treatment session(s) to achieve Long Term Outcomes due to ','e'); ?>
<input type="checkbox" name="Additional_Treatment" value="short term memory difficulties" id="visitnote_Plan_Short_term_memory" 
<?php if ($obj{"Additional_Treatment"} == "short term memory difficulties") echo "checked";;?> />
<?php xl('short term memory difficulties','e'); ?>
<input type="checkbox" name="Additional_Treatment" value="minimal support systems" id="visitnote_Plan_minimal_support" 
<?php if ($obj{"Additional_Treatment"} == "minimal support systems") echo "checked";;?> />
<?php xl('minimal support systems','e'); ?>
<input type="checkbox" name="Additional_Treatment" value="communication, language barriers" id="visitnote_Plan_Communication_language_barriers" 
<?php if ($obj{"Additional_Treatment"} == "communication, language barriers") echo "checked";;?> />
<?php xl('communication, language barriers','e'); ?>
</p>
<p>
<input type="checkbox" name="treatment_Plan" value="Will address above issues" id="visitnote_Plan_Address_above_issues"
<?php if ($obj{"treatment_Plan"} == "Will address above issues") echo "checked";;?> />
<?php xl('Will address above issues by','e'); ?>
<input type="checkbox" name="issues_Communication" value="Providing written directions" id="visitnote_Plan_Providing_written_directions" 
<?php if ($obj{"issues_Communication"} == "Providing written directions") echo "checked";;?> />
<?php xl('Providing written directions and/or physical demonstration','e'); ?>
<input type="checkbox" name="issues_Communication" value="establish community support systems" id="visitnote_Plan_Establish_community_support" 
<?php if ($obj{"issues_Communication"} == "establish community support systems") echo "checked";;?> />
<?php xl('establish community support systems','e'); ?>
<input type="checkbox" name="issues_Communication" value="home/environmental adaptations" id="visitnote_Plan_Home_env_adaptations" 
<?php if ($obj{"issues_Communication"} == "home/environmental adaptations") echo "checked";;?> />
<?php xl('home/environmental adaptations','e'); ?>
<input type="checkbox" name="issues_Communication" value="use_family/professionals" id="visitnote_Plan_Use_family_professionals" 
<?php if ($obj{"issues_Communication"} == "use_family/professionals") echo "checked";;?> />
<?php xl('use family/professionals for interpretations as needed','e'); ?>
</p> </td>
  </tr>
  <tr>
    <td valign="top" scope="row"><strong><?php xl('SUPERVISOR VISIT (if  applicable)','e'); ?> </strong>
      <input type="checkbox" name="supervisor_visit" value="OTAssistant" id="visitnote_Supervisorvisit_OT_Assistant" <?php if ($obj{"supervisor_visit"} == "OTAssistant") echo "checked";;?> />
<?php xl('OT Assistant','e'); ?>
<input type="checkbox" name="supervisor_visit" value="Aide" id="visitnote_Supervisorvisit_Aide" 
<?php if ($obj{"supervisor_visit"} == "Aide") echo "checked";;?> />
<?php xl('Aide /','e'); ?>
<input type="checkbox" name="supervisor_visit" value="Present" id="visitnote_Supervisorvisit_Present" 
<?php if ($obj{"supervisor_visit"} == "Present") echo "checked";;?> />
<?php xl('Present','e'); ?>
<input type="checkbox" name="supervisor_visit" value="Not Present" id="visitnote_Supervisorvisit_Not_Present" 
<?php if ($obj{"supervisor_visit"} == "Not Present") echo "checked";;?> />
<?php xl('Not Present','e'); ?>
<input type="checkbox" name="supervisor_visit" value="Contacted visit" id="visitnote_Supervisorvisit_Contacted_regarding_visit" 
<?php if ($obj{"supervisor_visit"} == "Contacted visit") echo "checked";;?> />
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
  <br></br>
<a href="javascript:top.restoreSession();document.visitnotes.submit();" class="link_submit">[<?php xl('Save','e');?>]</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e');?>]</a>
 </form>

<!--for signature-->
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

