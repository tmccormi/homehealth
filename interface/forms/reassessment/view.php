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
$formTable = "forms_ot_Reassessment";

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
	    obj.open("GET",site_root+"/forms/reassessment/functions.php?code="+icd9code+"&Dx="+Dx,true);    
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
function requiredCheck() {
    var time_in = document.getElementById('Reassessment_Time_In').value;
    var time_out = document.getElementById('Reassessment_Time_Out').value;
	var date = document.getElementById('Reassessment_date').value;
    
	var isSelected = function() {
    var visit_checker = document.reassessment.Reassessment_Visit_Count;

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
<body class="body_top">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_ot_Reassessment", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>
<form method="post"
		action="<?php echo $rootdir;?>/forms/reassessment/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="reassessment">
		<h3 align="center"><?php xl('OCCUPATIONAL THERAPY REASSESSMENT','e'); ?>
		<br>
		<label>
        <input type="radio" name="Reassessment_Visit_Count" value="13th Visit" id="Reassessment_Visit_Count" 
        <?php if ($obj{"Reassessment_Visit_Count"} == "13th Visit") echo "checked";;?>/>
		<?php xl('13th Visit','e')?></label><label>
        <input type="radio" name="Reassessment_Visit_Count" value="19th Visit" id="Reassessment_Visit_Count" 
        <?php if ($obj{"Reassessment_Visit_Count"} == "19th Visit") echo "checked";;?>/>
        <?php xl('19th Visit','e')?></label><label>
        <input type="radio" name="Reassessment_Visit_Count" value="Other Visit" id="Reassessment_Visit_Count" 
        <?php if ($obj{"Reassessment_Visit_Count"} == "Other Visit") echo "checked";;?>/>
        <?php xl('Other Visit','e')?></label></h3>
		
 <br></br> 
<table  align="center" border="1" cellpadding="0px" cellspacing="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="0px" cellspacing="0px" class="formtable">
      <tr>

        <td width="5%" align="center" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
        <td width="15%" align="center" valign="top"><input type="text"
					id="patient_name" size="24" value="<?php patientName()?>"
					readonly /></td>
        <td width="06%" align="center"><strong><?php xl('MR#','e')?></strong></td>
        <td width="10%" align="center" valign="top" class="bold">
        <input type="text" name="mr" id="mr" size="10px" value="<?php  echo $_SESSION['pid']?>" readonly /></td>
        <td width="5%"><p><strong><?php xl('Time In','e');?></strong></p></td>
        <td width="9%"><select name="Reassessment_Time_In" id="Reassessment_Time_In"><?php timeDropDown(stripslashes($obj{"Reassessment_Time_In"}))?></select></td>
        <td width="5%"><p><strong><?php xl('Time Out','e');?></strong></p></td>
        <td width="9%"><select name="Reassessment_Time_Out" id="Reassessment_Time_Out"><?php timeDropDown(stripslashes($obj{"Reassessment_Time_Out"}))?></select></td>
	<td align="center" width="9%"><strong><?php xl('Encounter Date','e')?></strong></td>
        <td align="center">
        <input type='text' size='10' name='Reassessment_date' id='Reassessment_date' 
					title='<?php xl('Encounter Date','e'); ?>'
					value="<?php echo stripslashes($obj{"Reassessment_date"});?>" 
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
  <input type="text"  size="3px" name="Reassessment_Pulse" id="Reassessment_Pulse" value="<?php echo stripslashes($obj{"Reassessment_Pulse"});?>" />
  <label>
    <input type="checkbox" name="Reassessment_Pulse_State" value="Regular" id="Reassessment_Pulse_State" 
    <?php if ($obj{"Reassessment_Pulse_State"} == "Regular") echo "checked";;?>/>
    <?php xl('Regular','e')?></label>
  <label>
    <input type="checkbox" name="Reassessment_Pulse_State" value="Irregular" id="Reassessment_Pulse_State" 
     <?php if ($obj{"Reassessment_Pulse_State"} == "Irregular") echo "checked";;?>/>
    <?php xl('Irregular','e')?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <?php xl('Temperature','e')?>
     <input size="3px" type="text" name="Reassessment_Temperature" id="Reassessment_Temperature" 
      value="<?php echo stripslashes($obj{"Reassessment_Temperature"});?>" />
     <label>
       <input type="checkbox" name="Reassessment_Temperature_type" value="Oral" id="Reassessment_Temperature_type" 
        <?php if ($obj{"Reassessment_Temperature_type"} == "Oral") echo "checked";;?>/>
       <?php xl('Oral','e')?></label>
     <label>
       <input type="checkbox" name="Reassessment_Temperature_type" value="Temporal" id="Reassessment_Temperature_type" 
        <?php if ($obj{"Reassessment_Temperature_type"} == "Temporal") echo "checked";;?>/>
       <?php xl('Temporal','e')?></label> &nbsp;
       <?php xl('Other','e')?>
 <input type="text" size="3px" name="Reassessment_VS_other" id="Reassessment_VS_other"
  value="<?php echo stripslashes($obj{"Reassessment_VS_other"});?>" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Respirations','e')?>
<input type="text" size="3px" name="Reassessment_VS_Respirations" id="Reassessment_VS_Respirations" 
value="<?php echo stripslashes($obj{"Reassessment_VS_Respirations"});?>" />
<br />
<?php xl('Blood Pressure Systolic','e')?>
<input type="text" size="3px" name="Reassessment_VS_BP_Systolic" id="Reassessment_VS_BP_Systolic" 
value="<?php echo stripslashes($obj{"Reassessment_VS_BP_Systolic"});?>" />
/
<label>
  <input type="text" size="3px" name="Reassessment_VS_BP_Diastolic" id="Reassessment_VS_BP_Diastolic" 
  value="<?php echo stripslashes($obj{"Reassessment_VS_BP_Diastolic"});?>" />
    <?php xl('Diastolic','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_side" value="Right" id="right" 
  <?php if ($obj{"Reassessment_VS_BP_Body_side"} == "Right") echo "checked";;?>/>

  <?php xl('Right','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_side" value="Left" id="left" 
  <?php if ($obj{"Reassessment_VS_BP_Body_side"} == "Left") echo "checked";;?>/>
  <?php xl('Left','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Sitting" id="sitting" 
    <?php if ($obj{"Reassessment_VS_BP_Body_Position"} == "Sitting") echo "checked";;?>/>
  <?php xl('Sitting','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Standing" id="standing"
    <?php if ($obj{"Reassessment_VS_BP_Body_Position"} == "Standing") echo "checked";;?>/>
  <?php xl('Standing','e')?> </label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_Body_Position" value="Lying" id="lying" 
    <?php if ($obj{"Reassessment_VS_BP_Body_Position"} == "Lying") echo "checked";;?>/>
   <?php xl('Lying','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('*O','e'); ?><sub><?php xl('2','e'); ?></sub><?php xl('Sat','e'); ?>
   </label>  <input type="text" size="3px" name="Reassessment_VS_Sat" id="physician" 
  value="<?php echo stripslashes($obj{"Reassessment_VS_Sat"});?>" />

<?php xl('*Physician ordered','e')?></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
  <strong><?php xl('Pain','e')?></strong>
  <input type="checkbox" name="Reassessment_VS_Pain" value="No Pain" id="Reassessment_VS_Pain" 
   <?php if ($obj{"Reassessment_VS_Pain"} == "No Pain") echo "checked";;?>/>
<?php xl('No Pain','e')?>
<input type="checkbox" name="Reassessment_VS_Pain" value="Pain limits functional ability" id="Reassessment_VS_Pain" 
 <?php if ($obj{"Reassessment_VS_Pain"} == "Pain limits functional ability") echo "checked";;?>/>
<?php xl('Pain limits functional ability','e'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Intensity','e'); ?>&nbsp;
<input type="text" size="9px" name="Reassessment_VS_Pain_Intensity" id="Reassessment_VS_Pain_Intensity" 
value="<?php echo stripslashes($obj{"Reassessment_VS_Pain_Intensity"});?>" />
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="Improve" id="Reassessment_VS_Pain_Intensity_type" 
 <?php if ($obj{"Reassessment_VS_Pain_Intensity_type"} == "Improve") echo "checked";;?>/>
<?php xl('Improve','e')?>
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="Worse" id="Reassessment_VS_Pain_Intensity_type" 
 <?php if ($obj{"Reassessment_VS_Pain_Intensity_type"} == "Worse") echo "checked";;?>/>
<?php xl('Worse','e')?>
<input type="checkbox" name="Reassessment_VS_Pain_Intensity_type" value="No Change" id="Reassessment_VS_Pain_Intensity_type" 
 <?php if ($obj{"Reassessment_VS_Pain_Intensity_type"} == "No Change") echo "checked";;?>/>
<?php xl('No Change','e')?></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" class="formtable">
      <tr>
        <td width="50%" valign="top" scope="row"><strong><?php xl('HOMEBOUND REASON','e')?><br />
        </strong>
          <input type="checkbox" name="Reassessment_HR_Needs_assistance" id="Reassessment_HR_Needs_assistance" 
          <?php if ($obj{"Reassessment_HR_Needs_assistance"} == "on") echo "checked";;?>/>
<?php xl('Needs assistance in all activities','e')?><br />
<input type="checkbox" name="Reassessment_HR_Unable_to_leave_home" id="Reassessment_HR_Unable_to_leave_home" 
    <?php if ($obj{"Reassessment_HR_Unable_to_leave_home"} == "on") echo "checked";;?>/>
<?php xl('Unable to leave home safely unassisted','e')?><br />
<input type="checkbox" name="Reassessment_HR_Medical_Restrictions" id="Reassessment_HR_Medical_Restrictions" 
    <?php if ($obj{"Reassessment_HR_Medical_Restrictions"} == "on") echo "checked";;?>/>
<?php xl('Medical Restrictions in','e')?> 
<input type="text" style="width:260px" name="Reassessment_HR_Medical_Restrictions_In" id="Reassessment_HR_Medical_Restrictions_In"
 value="<?php echo stripslashes($obj{"Reassessment_HR_Medical_Restrictions_In"});?>" />
<br />
<input type="checkbox" name="Reassessment_HR_SOB_upon_exertion" id="Reassessment_HR_SOB_upon_exertion" 
    <?php if ($obj{"Reassessment_HR_SOB_upon_exertion"} == "on") echo "checked";;?>/>
<?php xl('SOB upon exertion','e')?>
<input type="checkbox" name="Reassessment_HR_Pain_with_Travel" id="Reassessment_HR_Pain_with_Travel" 
    <?php if ($obj{"Reassessment_HR_Pain_with_Travel"} == "on") echo "checked";;?>/>
<?php xl('Pain with Travel','e')?></td>
        <td width="50%" valign="top">
        <input type="checkbox" name="Reassessment_HR_Requires_assistance" id="Reassessment_HR_Requires_assistance" 
            <?php if ($obj{"Reassessment_HR_Requires_assistance"} == "on") echo "checked";;?>/>
<?php xl('Requires assistance in mobility and ambulation','e')?>
  <br />
  <input type="checkbox" name="Reassessment_HR_Arrhythmia" id="Reassessment_HR_Arrhythmia" 
      <?php if ($obj{"Reassessment_HR_Arrhythmia"} == "on") echo "checked";;?>/>
<?php xl('Arrhythmia','e')?>
<input type="checkbox" name="Reassessment_HR_Bed_Bound" id="Reassessment_HR_Bed_Bound" 
    <?php if ($obj{"Reassessment_HR_Bed_Bound"} == "on") echo "checked";;?>/>
<?php xl('Bed Bound','e')?>
<input type="checkbox" name="Reassessment_HR_Residual_Weakness" id="Reassessment_HR_Residual_Weakness" 
<?php if ($obj{"Reassessment_HR_Residual_Weakness"} == "on") echo "checked";;?>/>
<?php xl('Residual Weakness','e')?>
<br />
<input type="checkbox" name="Reassessment_HR_Confusion" id="Reassessment_HR_Confusion" 
<?php if ($obj{"Reassessment_HR_Confusion"} == "on") echo "checked";;?>/>
<?php xl('Confusion, unable to go out of home alone','e')?><br />
<?php xl('Other','e')?>&nbsp;
<input type="text" style="width:390px" name="Reassessment_HR_Other" id="Reassessment_HR_Other" 
 value="<?php echo stripslashes($obj{"Reassessment_HR_Other"});?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>

    <td scope="row" style="padding-left:8px; padding-right:8px; padding-bottom:8px;">
    <strong><?php xl('TREATMENT DX/Problem','e')?></strong> 
<input type="text" id="Reassessment_TREATMENT_DX_Problem" name="Reassessment_TREATMENT_DX_Problem" style="width:100%;" value="<?php echo stripslashes($obj{'Reassessment_TREATMENT_DX_Problem'}); ?>"/>
</td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
    <strong><?php xl('ADL/IADL REASSESSMENT','e')?></strong><br />
    <strong><?php xl('Scale','e')?>&nbsp;</strong>
    <?php xl('U=Unable*, Dep=Dependent, Max=needs 75-51% assist, Mod=needs 50-26%, Min=needs 25-1% assist, CG=constant contact guard, SBA=stand by assist, S=supervised, needs cues, Mod I=Independent with assistive devices, Independent=no assist required.','e')?><br>
   <strong><?php xl('Balance Scale','e')?>&nbsp;</strong>
   <?php xl('G=Good, F=Fair, P=Poor','e')?>
    </td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="2px" class="formtable">
      <tr>
        <td width="25%" align="center" scope="row"><strong><?php xl('Self Mgt. Skills','e')?></strong></td>
        <td width="13%" align="center"><strong><?php xl('Initial','e')?> </strong><strong>Status</strong></td>
        <td width="13%" align="center"><strong><?php xl('Current Status','e')?></strong></td>

        <td width="49%" align="center"><strong><?php xl('Describe progress related to mobility skills','e')?></strong><br />
        </td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Feeding','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Feeding_Initial_Status" id="Reassessment_ADL_Feeding_Initial_Status">
       <?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Feeding_Initial_Status"}))	?></select></strong></td>

        <td align="center"><strong><select name="Reassessment_ADL_Feeding_Current_Status" id="Reassessment_ADL_Feeding_Current_Status">
        <?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Feeding_Current_Status"}))	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Feeding_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Feeding_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Feeding_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Feeding_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Feeding_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Feeding_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Feeding_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Feeding_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Feeding_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Grooming/Oral Hygiene','e')?></td>

        <td align="center"><strong><select name="Reassessment_ADL_Grooming_Oral_Initial_Status" id="Reassessment_ADL_Grooming_Oral_Initial_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Grooming_Oral_Initial_Status"}))	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Grooming_Oral_Current_Status" id="Reassessment_ADL_Grooming_Oral_Current_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Grooming_Oral_Current_Status"}))	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills" 
    <?php if ($obj{"Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Grooming_Oral_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>

        <td scope="row"><?php xl('Toileting','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Toileting_Initial_Status" id="Reassessment_ADL_Toileting_Initial_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Toileting_Initial_Status"}))	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Toileting_Current_Status" id="Reassessment_ADL_Toileting_Current_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Toileting_Current_Status"}))	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Toileting_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Toileting_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Toileting_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Toileting_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Toileting_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Toileting_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Toileting_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Toileting_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Toileting_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>

      </tr>
      <tr>
        <td scope="row"><?php xl('Bath/shower','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Bath_shower_Initial_Status" id="Reassessment_ADL_Bath_shower_Initial_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Bath_shower_Initial_Status"}))	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Bath_shower_Current_Status" id="Reassessment_ADL_Bath_shower_Current_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Bath_shower_Current_Status"}))	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Bath_shower_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?> &nbsp;
  <input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Bath_shower_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Bath_shower_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Bath_shower_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Dressing UB/LB','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Dressing_UB_LB_Initial_Status" id="Reassessment_ADL_Dressing_UB_LB_Initial_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Dressing_UB_LB_Initial_Status"}))?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Dressing_UB_LB_Current_Status" id="Reassessment_ADL_Dressing_UB_LB_Current_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Dressing_UB_LB_Current_Status"}))?></select></strong></td>

        <td><input type="checkbox" name="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" 
         <?php if ($obj{"Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?> &nbsp;
  <input type="checkbox" name="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" 
   <?php if ($obj{"Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Dressing_UB_LB_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Functional Mobility','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Functional_Mobility_Initial_Status" id="Reassessment_ADL_Functional_Mobility_Initial_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Functional_Mobility_Initial_Status"}))?></select></strong></td>

        <td align="center"><strong><select name="Reassessment_ADL_Functional_Mobility_Current_Status" id="Reassessment_ADL_Functional_Mobility_Current_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Functional_Mobility_Current_Status"}))?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Functional_Mobility_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Home Mgt (Meals, Phone, Making Bed, Housekeeping)','e')?></td>

        <td align="center"><strong><select name="Reassessment_ADL_Home_Mgt_Initial_Status" id="Reassessment_ADL_Home_Mgt_Initial_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Home_Mgt_Initial_Status"}))?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Home_Mgt_Current_Status" id="Reassessment_ADL_Home_Mgt_Current_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Home_Mgt_Current_Status"}))?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Home_Mgt_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>

        <td scope="row"><?php xl('Transportation','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Transportation_Initial_Status" id="Reassessment_ADL_Transportation_Initial_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Transportation_Initial_Status"}))?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Transportation_Current_Status" id="Reassessment_ADL_Transportation_Current_Status"><?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Transportation_Current_Status"}))?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Transportation_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Transportation_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Transportation_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Transportation_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Transportation_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Transportation_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Transportation_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Transportation_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Transportation_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>

      </tr>
      <tr>
        <td scope="row"><?php xl('STANDING BALANCE STATIC/DYNAMIC','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_STANDING_BALANCE_Initial_Status" id="Reassessment_ADL_STANDING_BALANCE_Initial_Status"><?php Balance_skills(stripslashes($obj{"Reassessment_ADL_STANDING_BALANCE_Initial_Status"})) ?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_STANDING_BALANCE_Current_Status" id="Reassessment_ADL_STANDING_BALANCE_Current_Status"><?php Balance_skills(stripslashes($obj{"Reassessment_ADL_STANDING_BALANCE_Current_Status"})) ?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Transportation_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;
  <input type="checkbox" name="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_STANDING_BALANCE_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('SITTING BALANCE  STATIC/DYNAMIC','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_SITTING_BALANCE_Initial_Status" id="Reassessment_ADL_SITTING_BALANCE_Initial_Status"><?php Balance_skills(stripslashes($obj{"Reassessment_ADL_SITTING_BALANCE_Initial_Status"})) ?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_SITTING_BALANCE_Current_Status" id="Reassessment_ADL_SITTING_BALANCE_Current_Status"><?php Balance_skills(stripslashes($obj{"Reassessment_ADL_SITTING_BALANCE_Current_Status"})) ?></select></strong></td>

        <td><input type="checkbox" name="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;
  <input type="checkbox" name="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_SITTING_BALANCE_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>

	<input type="checkbox" name="Reassessment_Assistive_Devices" value="N/A" id="Reassessment_Assistive_Devices" 
	<?php if ($obj{"Reassessment_Assistive_Devices"} == "N/A") echo "checked";;?>/>
<strong><?php xl('N/A','e')?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong><?php xl('Assistive Devices','e')?></strong>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="None" id="Reassessment_Assistive_Devices" 
<?php if ($obj{"Reassessment_Assistive_Devices"} == "None") echo "checked";;?>/>
<?php xl('None','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="W/C" id="Reassessment_Assistive_Devices" 
<?php if ($obj{"Reassessment_Assistive_Devices"} == "W/C") echo "checked";;?>/>
<?php xl('W/C','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Cane" id="Reassessment_Assistive_Devices" 
<?php if ($obj{"Reassessment_Assistive_Devices"} == "Cane") echo "checked";?>/>
<?php xl('Cane Type','e')?>
<label for="textfield"></label>
  <input type="text" size="22px" name="Reassessment_Assistive_Devices_Cane_Type" id="Reassessment_Assistive_Devices_Cane_Type" 
   value="<?php echo stripslashes($obj{"Reassessment_Assistive_Devices_Cane_Type"});?>" />

<input type="checkbox" name="Reassessment_Assistive_Devices" value="Walker" id="Walker" 
<?php if ($obj{"Reassessment_Assistive_Devices"} == "Walker") echo "checked";;?>/>
<?php xl('Walker Type','e')?>&nbsp;
<input type="text" style="width:180px" name="Reassessment_Assistive_Devices_Walker_Type" id="Reassessment_Assistive_Devices_Walker_Type" 
 value="<?php echo stripslashes($obj{"Reassessment_Assistive_Devices_Walker_Type"});?>" /><br>
<?php xl('Other','e')?>&nbsp;
<input type="text" style="width:870px" name="Reassessment_Assistive_Devices_Other" id="Reassessment_Assistive_Devices_Other" 
 value="<?php echo stripslashes($obj{"Reassessment_Assistive_Devices_Other"});?>" /> <strong><br />
<?php xl('Timed Up and Go Score','e')?></strong>
<input type="text" style="width:170px" name="Reassessment_Timed_Up_Go_Score" id="Reassessment_Timed_Up_Go_Score" 
 value="<?php echo stripslashes($obj{"Reassessment_Timed_Up_Go_Score"});?>" />
<strong><?php xl('Interpretation','e')?></strong> 
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="No Fall Risk" id="Reassessment_Interpretation_Risk_Types" 
<?php if ($obj{"Reassessment_Interpretation_Risk_Types"} == "No Fall Risk") echo "checked";;?>/>
<strong><?php xl('Independent-No Fall Risk (','e')?>&lt; <?php xl('11 seconds)','e')?></strong>
<br />
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="Minimal Fall Risk" id="Reassessment_Interpretation_Risk_Types" 
<?php if ($obj{"Reassessment_Interpretation_Risk_Types"} == "Minimal Fall Risk") echo "checked";;?>/>
<strong><?php xl('Minimal Fall Risk (11- 13 seconds)','e')?> </strong>

<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="Moderate Fall Risk" id="Reassessment_Interpretation_Risk_Types" 
<?php if ($obj{"Reassessment_Interpretation_Risk_Types"} == "Moderate Fall Risk") echo "checked";;?>/>
<strong><?php xl('Moderate Fall Risk (13.5-19 seconds)','e')?></strong>
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="High Risk for Falls" id="Reassessment_Interpretation_Risk_Types" 
<?php if ($obj{"Reassessment_Interpretation_Risk_Types"} == "High Risk for Falls") echo "checked";;?>/>
<strong><?php xl('High Risk for Falls','e')?> <?php xl('(&gt;19 seconds)','e')?></strong><br />
<strong><?php xl('Other Tests/Scores/Interpretations','e')?></strong> 
<input type="text" style="width:640px" name="Reassessment_Other_Interpretations" id="Reassessment_Other_Interpretations" 
 value="<?php echo stripslashes($obj{"Reassessment_Other_Interpretations"});?>" />
<br /> 
<input type="checkbox" name="Reassessment_Interpretation_NA" value="N/A" id="Reassessment_Interpretation_NA" 
<?php if ($obj{"Reassessment_Interpretation_NA"} == "N/A") echo "checked";;?>/><strong>
<?php xl('N/A','e')?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong><?php xl('Patient/Caregiver Continues to Have the Following Problems Achieving Goals with ADLs/IDLs','e')?></strong>
<input type="text" style="width:910px" name="Reassessment_Problems_Achieving_Goals" id="Reassessment_Problems_Achieving_Goals" 
 value="<?php echo stripslashes($obj{"Reassessment_Problems_Achieving_Goals"});?>" /></td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
    <strong><?php xl('ENVIRONMENTAL BARRIERS/SAFETY ISSUES','e')?></strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<input type="checkbox" name="Reassessment_Environmental_Barriers" id="Reassessment_Environmental_Barriers" 
	value="No Issues" <?php if ($obj{"Reassessment_Environmental_Barriers"} == "No Issues") echo "checked";;?>/>
    <label for="checkbox"><?php xl('No environmental barriers in home','e')?>  
      <input type="checkbox" name="Reassessment_Environmental_Barriers" id="Reassessment_Environmental_Barriers" 
      value="Issues exists" <?php if ($obj{"Reassessment_Environmental_Barriers"} == "Issues exists") echo "checked";;?>/> 
     <?php xl(' The following environmental issues continue to exist','e')?><br />

    </label>
    <input type="text" style="width:910px" name="Reassessment_Environmental_Issues_Notes" id="Reassessment_Environmental_Issues_Notes" 
     value="<?php echo stripslashes($obj{"Reassessment_Environmental_Issues_Notes"});?>" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
    <strong><?php xl('COMPENSATORY SKILLS','e')?></strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1"  cellspacing="0px" cellpadding="2px" class="formtable">

      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Improved','e')?></strong></td>
        <td align="center"><strong><?php xl('No Change','e')?></strong></td>
        <td align="center"><strong><?php xl('N/A','e')?></strong></td>
        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>

        <td align="center"><strong><?php xl('Improved','e')?></strong></td>
        <td align="center"><strong><?php xl('No Change','e')?></strong></td>
        <td align="center"><strong><?php xl('N/A','e')?></strong></td>
        </tr>
      <tr>
        <td align="center" scope="row"><?php xl('SAFETY AWARENESS','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Safety_Awareness" id="Reassessment_Compensatory_Safety_Awareness" 
        value="Improved" <?php if ($obj{"Reassessment_Compensatory_Safety_Awareness"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Safety_Awareness" id="Reassessment_Compensatory_Safety_Awareness" 
        value="No Change" <?php if ($obj{"Reassessment_Compensatory_Safety_Awareness"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Safety_Awareness" id="Reassessment_Compensatory_Safety_Awareness" 
        value="N/A" <?php if ($obj{"Reassessment_Compensatory_Safety_Awareness"} == "N/A") echo "checked";;?>/></td>
        <td align="center"><?php xl('SHORT-TERM MEMORY','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Short_Term_Memory" id="Reassessment_Compensatory_Short_Term_Memory" 
        value="Improved" <?php if ($obj{"Reassessment_Compensatory_Short_Term_Memory"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Short_Term_Memory" id="Reassessment_Compensatory_Short_Term_Memory" 
        value="No Change" <?php if ($obj{"Reassessment_Compensatory_Short_Term_Memory"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Short_Term_Memory" id="Reassessment_Compensatory_Short_Term_Memory" 
        value="N/A" <?php if ($obj{"Reassessment_Compensatory_Short_Term_Memory"} == "N/A") echo "checked";;?>/></td>
        </tr>
      <tr>

        <td align="center" scope="row"><?php xl('ATTENTION SPAN','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Attention_Span" id="Reassessment_Compensatory_Attention_Span" 
         value="Improved" <?php if ($obj{"Reassessment_Compensatory_Attention_Span"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Attention_Span" id="Reassessment_Compensatory_Attention_Span" 
         value="No Change" <?php if ($obj{"Reassessment_Compensatory_Attention_Span"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Attention_Span" id="Reassessment_Compensatory_Attention_Span" 
         value="N/A" <?php if ($obj{"Reassessment_Compensatory_Attention_Span"} == "N/A") echo "checked";;?>/></td>
        <td align="center"><?php xl('LONG-TERM MEMORY','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Long_Term_Memory" id="Reassessment_Compensatory_Long_Term_Memory" 
  		 value="Improved" <?php if ($obj{"Reassessment_Compensatory_Long_Term_Memory"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Long_Term_Memory" id="Reassessment_Compensatory_Long_Term_Memory" 
  		 value="No Change" <?php if ($obj{"Reassessment_Compensatory_Long_Term_Memory"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_Long_Term_Memory" id="Reassessment_Compensatory_Long_Term_Memory" 
  		 value="N/A" <?php if ($obj{"Reassessment_Compensatory_Long_Term_Memory"} == "N/A") echo "checked";;?>/></td>

        </tr>
      <tr>
        <td colspan="8" align="center" scope="row"><strong><?php xl('COMPENSATORY SKILLS FOR','e')?>
        </strong></td>
        </tr>
      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Improved','e')?></strong></td>

        <td align="center"><strong><?php xl('No Change','e')?></strong></td>
        <td align="center"><strong><?php xl('N/A','e')?></strong></td>
        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('Improved','e')?></strong></td>
        <td align="center"><strong><?php xl('No Change','e')?></strong></td>
        <td align="center"><strong><?php xl('N/A','e')?></strong></td>

      </tr>
      <tr>
        <td align="center" scope="row"><?php xl('VISION','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Vision" id="Reassessment_Compensatory_For_Vision" 
value="Improved" <?php if ($obj{"Reassessment_Compensatory_For_Vision"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Vision" id="Reassessment_Compensatory_For_Vision" 
value="No Change" <?php if ($obj{"Reassessment_Compensatory_For_Vision"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Vision" id="Reassessment_Compensatory_For_Vision" 
  value="N/A" <?php if ($obj{"Reassessment_Compensatory_For_Vision"} == "N/A") echo "checked";;?>/></td>
        <td align="center"><?php xl('GROSS MOTOR COORD','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Gross_Motor" id="Reassessment_Compensatory_For_Gross_Motor" 
value="Improved" <?php if ($obj{"Reassessment_Compensatory_For_Gross_Motor"} == "Improved") echo "checked";;?>/></td>

        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Gross_Motor" id="Reassessment_Compensatory_For_Gross_Motor" 
value="No Change" <?php if ($obj{"Reassessment_Compensatory_For_Gross_Motor"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Gross_Motor" id="Reassessment_Compensatory_For_Gross_Motor" 
  value="N/A" <?php if ($obj{"Reassessment_Compensatory_For_Gross_Motor"} == "N/A") echo "checked";;?>/></td>
        </tr>
      <tr>
        <td align="center" scope="row"><?php xl('HEARING','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Hearing" id="Reassessment_Compensatory_For_Hearing" 
value="Improved" <?php if ($obj{"Reassessment_Compensatory_For_Hearing"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Hearing" id="Reassessment_Compensatory_For_Hearing" 
value="No Change" <?php if ($obj{"Reassessment_Compensatory_For_Hearing"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Hearing" id="Reassessment_Compensatory_For_Hearing" 
  value="N/A" <?php if ($obj{"Reassessment_Compensatory_For_Hearing"} == "N/A") echo "checked";;?>/></td>

        <td align="center"><?php xl('FINE MOTOR COORD','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Fine_Motor" id="Reassessment_Compensatory_For_Fine_Motor" 
value="Improved" <?php if ($obj{"Reassessment_Compensatory_For_Fine_Motor"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Fine_Motor" id="Reassessment_Compensatory_For_Fine_Motor" 
value="No Change" <?php if ($obj{"Reassessment_Compensatory_For_Fine_Motor"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Fine_Motor" id="Reassessment_Compensatory_For_Fine_Motor" 
  value="N/A" <?php if ($obj{"Reassessment_Compensatory_For_Fine_Motor"} == "N/A") echo "checked";;?>/></td>
        </tr>
      <tr>
        <td align="center" scope="row"><?php xl('ACTIVITY  TOLERANCE','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Activity_Tolerance" id="Reassessment_Compensatory_For_Activity_Tolerance" 
value="Improved" <?php if ($obj{"Reassessment_Compensatory_For_Activity_Tolerance"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Activity_Tolerance" id="Reassessment_Compensatory_For_Activity_Tolerance" 
value="No Change" <?php if ($obj{"Reassessment_Compensatory_For_Activity_Tolerance"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_Activity_Tolerance" id="Reassessment_Compensatory_For_Activity_Tolerance" 
value="N/A" <?php if ($obj{"Reassessment_Compensatory_For_Activity_Tolerance"} == "N/A") echo "checked";;?>/></td>
        <td align="center"><?php xl('USE OF ASSISTIVE-  ADAPTIVE DEVICES','e')?></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" id="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" 
value="Improved" <?php if ($obj{"Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices"} == "Improved") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" id="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" 
value="No Change" <?php if ($obj{"Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices"} == "No Change") echo "checked";;?>/></td>
        <td align="center"><input type="radio" name="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices" id="Reassessment_Compensatory_For_UseOf_Assistive_Adaptive_Devices"
value="N/A" <?php if ($obj{"Reassessment_Compensatory_For_Fine_Motor"} == "N/A") echo "checked";;?>/></td>
        </tr>
    </table></td>

  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<input type="checkbox" name="Reassessment_Compensatory_NA" id="Reassessment_Compensatory_NA" 
<?php if ($obj{"Reassessment_Compensatory_NA"} == "on") echo "checked";;?>/>
    <label for="checkbox5">
<strong><?php xl('N/A','e')?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong><?php xl('Patient/Caregiver Continues to Have the Following Problems Achieving Goals with the above skills','e')?><br />
      <input type="text" style="width:910px" name="Reassessment_Compensatory_Problems_Achieving_Goals" id="Reassessment_Compensatory_Problems_Achieving_Goals" 
 value="<?php echo stripslashes($obj{"Reassessment_Compensatory_Problems_Achieving_Goals"});?>" />
    </strong></label></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<strong><?php xl('MUSCLE STRENGTH/FUNCTIONAL ROM EVALUATION','e')?><br />
      <input type="checkbox" name="Reassessment_MS_ROM_All_Muscle_WFL"  id="Reassessment_MS_ROM_All_Muscle_WFL" 
<?php if ($obj{"Reassessment_MS_ROM_All_Muscle_WFL"} == "on") echo "checked";;?>/>
<?php xl('All Muscle Strength is WFL','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_MS_ROM_ALL_ROM_WFL" id="Reassessment_MS_ROM_ALL_ROM_WFL" 
<?php if ($obj{"Reassessment_MS_ROM_ALL_ROM_WFL"} == "on") echo "checked";;?>/>
<?php xl('All ROM is WFL','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_MS_ROM_Following_Problem_areas" id="Reassessment_MS_ROM_Following_Problem_areas"
<?php if ($obj{"Reassessment_MS_ROM_Following_Problem_areas"} == "on") echo "checked";;?>/>
<?php xl('The following problem areas are','e')?></strong></td></tr></table></td>
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
      <tr>
        <td align="center" scope="row"><strong>
          <input type="text" size="40px" name="Reassessment_MS_ROM_Problemarea_text" id="Reassessment_MS_ROM_Problemarea_text" 
 value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problemarea_text"});?>" />
        </strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right" 
 value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Right"});?>" />
        <?php xl('/5','e')?></strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left" 
value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Left"});?>" />
<?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM" id="Reassessment_MS_ROM_ROM" 
value="Right" <?php if ($obj{"Reassessment_MS_ROM_ROM"} == "Right") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM" id="Reassessment_MS_ROM_ROM" 
value="Left" <?php if ($obj{"Reassessment_MS_ROM_ROM"} == "Left") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" 
value="P" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type"} == "P") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" 
value="AA" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type"} == "AA") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type" id="Reassessment_MS_ROM_ROM_Type" 
value="A"<?php if ($obj{"Reassessment_MS_ROM_ROM_Type"} == "A") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity" id="Reassessment_MS_ROM_Tonicity" 
value="Hyper" <?php if ($obj{"Reassessment_MS_ROM_Tonicity"} == "Hyper") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity" id="Reassessment_MS_ROM_Tonicity" 
value="Hypo" <?php if ($obj{"Reassessment_MS_ROM_Tonicity"} == "Hypo") echo "checked";;?>/></td>
        <td align="center"><strong>
          <input type="text" size="40px" name="Reassessment_MS_ROM_Further_description" id="Reassessment_MS_ROM_Further_description" 
 value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Further_description"});?>" />
        </strong></td>
      </tr>
      <tr>
        <td align="center" scope="row"><strong>
          <input type="text" size="40px" name="Reassessment_MS_ROM_Problemarea_text1" id="Reassessment_MS_ROM_Problemarea_text1" 
 			value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problemarea_text1"});?>" />
        </strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right1" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right1" 
 value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Right1"});?>" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left1" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left1" 
 		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Left1"});?>" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM1" id="Reassessment_MS_ROM_ROM1" 
		value="Right" <?php if ($obj{"Reassessment_MS_ROM_ROM1"} == "Right") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM1" id="Reassessment_MS_ROM_ROM1" 
		value="Left" <?php if ($obj{"Reassessment_MS_ROM_ROM1"} == "Left") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" 
		value="P" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type1"} == "P") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" 
		value="AA" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type1"} == "AA") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type1" id="Reassessment_MS_ROM_ROM_Type1" 
		value="A" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type1"} == "A") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity1" id="Reassessment_MS_ROM_Tonicity1" 
		value="Hyper" <?php if ($obj{"Reassessment_MS_ROM_Tonicity1"} == "Hyper") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity1" id="Reassessment_MS_ROM_Tonicity1" 
		value="Hypo" <?php if ($obj{"Reassessment_MS_ROM_Tonicity1"} == "Hypo") echo "checked";;?>/></td>
        <td align="center"><strong>
          <input type="text" size="40px" name="Reassessment_MS_ROM_Further_description1" id="Reassessment_MS_ROM_Further_description1" 
          value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Further_description1"});?>" />
        </strong></td>
      </tr>

      <tr>
        <td rowspan="2" align="center" scope="row">&nbsp;</th>
          <strong><?php xl('CURRENT  PROBLEM  AREA(S)','e')?></strong>        </td>
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
        <td align="center" scope="row">&nbsp;</th>
          <strong>
            <input type="text" size="40px" name="Reassessment_MS_ROM_Problemarea_text2" id="Reassessment_MS_ROM_Problemarea_text2" 
 		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problemarea_text2"});?>" />
            </strong>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right2" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right2" 
 		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Right2"});?>" />
          <?php xl('/5','e')?></strong></td>

        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left2" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left2" 
 		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Left2"});?>" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM2" id="Reassessment_MS_ROM_ROM2" 
		value="Right" <?php if ($obj{"Reassessment_MS_ROM_ROM2"} == "Right") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM2" id="Reassessment_MS_ROM_ROM2" 
		value="Left" <?php if ($obj{"Reassessment_MS_ROM_ROM2"} == "Left") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2" 
		value="P" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type2"} == "P") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2"
		value="AA" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type2"} == "AA") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type2" id="Reassessment_MS_ROM_ROM_Type2" 
		value="A" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type2"} == "A") echo "checked";;?>/></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity2" id="Reassessment_MS_ROM_Tonicity2" 
		value="Hyper" <?php if ($obj{"Reassessment_MS_ROM_Tonicity2"} == "Hyper") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity2" id="Reassessment_MS_ROM_Tonicity2"
		value="Hypo" <?php if ($obj{"Reassessment_MS_ROM_Tonicity2"} == "Hypo") echo "checked";;?>/></td>
        <td align="center"><strong>
          <input type="text"  size="40px" name="Reassessment_MS_ROM_Further_description2" id="Reassessment_MS_ROM_Further_description2" 
 		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Further_description2"});?>" />
        </strong></td>
      </tr>
      <tr>
        <td align="center" scope="row">&nbsp;</th>
          <strong>

            <input type="text" size="40px" name="Reassessment_MS_ROM_Problemarea_text3" id="Reassessment_MS_ROM_Problemarea_text3"
 		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problemarea_text3"});?>" />
            </strong>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right3" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right3" 
 		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Right3"});?>" />
          <?php xl('/5','e')?></strong></td>
        <td align="center"><strong>
          <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left3" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left3" 
		 value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Left3"});?>" />
          <?php xl('/5','e')?></strong></td>

        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM3" id="Reassessment_MS_ROM_ROM3" 
		value="Right" <?php if ($obj{"Reassessment_MS_ROM_ROM3"} == "Right") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM3" id="Reassessment_MS_ROM_ROM3" 
		value="Left" <?php if ($obj{"Reassessment_MS_ROM_ROM3"} == "Left") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="cupcheck18" 
		value="P" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type3"} == "P") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="cupcheck19" 
		value="AA" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type3"} == "AA") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="cupcheck110" 
		value="A" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type3"} == "A") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity3" id="Reassessment_MS_ROM_Tonicity3" 
		value="Hyper" <?php if ($obj{"Reassessment_MS_ROM_Tonicity3"} == "Hyper") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity3" id="Reassessment_MS_ROM_Tonicity3" 
		value="Hypo" <?php if ($obj{"Reassessment_MS_ROM_Tonicity3"} == "Hypo") echo "checked";;?>/></td>
        <td align="center"><strong>
          <input type="text" size="40px" name="Reassessment_MS_ROM_Further_description3" id="Reassessment_MS_ROM_Further_description3"
 		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Further_description3"});?>" />

        </strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr>
	<td>
<input type="checkbox" name="Reassessment_MS_ROM_NA" value="N/A" id="Reassessment_MS_ROM_NA" 
<?php if ($obj{"Reassessment_MS_ROM_NA"} == "N/A") echo "checked";;?>/>
<strong><?php xl('N/A','e')?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
<strong><?php xl('Patient/Caregiver Continues to Have the Following Problems Achieving Goals with','e')?></strong>  
<input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="Strength" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" 
value="Hypo"<?php if ($obj{"Reassessment_MS_ROM_Problems_Achieving_Goals_Type"} == "Strength") echo "checked";;?>/>
<?php xl('Strength','e')?>
<input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="ROM" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" 
value="Hypo"<?php if ($obj{"Reassessment_MS_ROM_Problems_Achieving_Goals_Type"} == "ROM") echo "checked";;?>/>
<?php xl('ROM','e')?>
<input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="Tone" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" 
value="Hypo"<?php if ($obj{"Reassessment_MS_ROM_Problems_Achieving_Goals_Type"} == "Tone") echo "checked";;?>/>
<?php xl('Tone','e')?> <strong>
<input type="text" style="width:910px" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Note" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Note" 
value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problems_Achieving_Goals_Note"});?>" />
</strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable">
	<tr><td><strong><?php xl('REASSESSMENT OVERVIEW','e')?></strong></td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<input type="checkbox" name="Reassessment_RO_Patient_Prior_Level_Function" id="Reassessment_RO_Patient_Prior_Level_Function" 
 value="Yes" <?php if ($obj{"Reassessment_RO_Patient_Prior_Level_Function"} == "Yes") echo "checked";;?>/>
    <label for="checkbox13"><?php xl('Yes','e')?></label>
    <input type="checkbox" name="Reassessment_RO_Patient_Prior_Level_Function" id="Reassessment_RO_Patient_Prior_Level_Function" 
value="No" <?php if ($obj{"Reassessment_RO_Patient_Prior_Level_Function"} == "No") echo "checked";;?>/>
    <label for="checkbox14"><?php xl('No Has Patient Reached Their Prior Level of Function?','e')?>&nbsp;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('If No, Explain','e')?>&nbsp;
<input type="text" style="width:600px" name="Reassessment_RO_Patient_Prior_Level_Function_No1" id="Reassessment_RO_Patient_Prior_Level_Function_No1" value="<?php echo stripslashes($obj{"Reassessment_RO_Patient_Prior_Level_Function_No1"});?>" />
<br />
      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" 
value="Yes" <?php if ($obj{"Reassessment_RO_Patient_Long_Term_Goals"} == "Yes") echo "checked";;?>/>
      <?php xl('Yes','e')?>
      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" 
value="No" <?php if ($obj{"Reassessment_RO_Patient_Long_Term_Goals"} == "No") echo "checked";;?>/>
   <?php xl(' No Has Patient Reached Their Long  Term Goals Established on Admission?','e')?>&nbsp;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('If No, Explain','e')?>
<input type="text" style="width:600px" name="Reassessment_RO_Patient_Prior_Level_Function_No2" id="Reassessment_RO_Patient_Prior_Level_Function_No2" value="<?php echo stripslashes($obj{"Reassessment_RO_Patient_Prior_Level_Function_No2"});?>" />
<br /><br>
    <strong><?php xl('Skilled OT continues to be Reasonable and Necessary to','e')?></strong></label>
    <br />

    <input type="checkbox" name="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" id="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" 
value="Return to prior Level" <?php if ($obj{"Reassessment_Skilled_OT_Reasonable_And_Necessary_To"} == "Return to prior Level") echo "checked";;?>/>
<?php xl('Return Patient to Their Prior Level of Function','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_OT_Reasonable_And_Necessary_To"  id="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" 
value="Teach Patient" <?php if ($obj{"Reassessment_Skilled_OT_Reasonable_And_Necessary_To"} == "Teach Patient") echo "checked";;?>/>
<?php xl('Teach patient/caregiver compensatory strategies for mobility','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" id="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" 
value="Teach Patient New Skills" <?php if ($obj{"Reassessment_Skilled_OT_Reasonable_And_Necessary_To"} == "Teach Patient New Skills") echo "checked";;?>/>
<?php xl('Train patient/caregiver in learning new skill','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" id="Reassessment_Skilled_OT_Reasonable_And_Necessary_To" 
value="Make Modifications" <?php if ($obj{"Reassessment_Skilled_OT_Reasonable_And_Necessary_To"} == "Make Modifications") echo "checked";;?>/>
<?php xl('Make modifications to current program to achieve short term and long term goals*','e')?>
<label for="checkbox14"><br />
  <?php xl('Other','e')?>
    <strong>
    <input type="text" style="width:870px" name="Reassessment_Skilled_OT_Other" id="Reassessment_Skilled_OT_Other" 
value="<?php echo stripslashes($obj{"Reassessment_Skilled_OT_Other"});?>"/>

    </strong></label></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td><strong>
    <?php xl('*Goals Changed/Adapted for ADLs','e')?></strong> <strong>
      <input type="text" style="width:640px" name="Reassessment_Goals_Changed_Adapted_For_ADLs" id="Reassessment_Goals_Changed_Adapted_For_ADLs" 
value="<?php echo stripslashes($obj{"Reassessment_Goals_Changed_Adapted_For_ADLs"});?>"/> 

      <br />
    </strong>
    <strong><?php xl('ADLs','e')?></strong><strong>

    <input type="text" style="width:870px" name="Reassessment_Goals_Changed_Adapted_For_ADLs1" id="Reassessment_Goals_Changed_Adapted_For_ADLs1" 
value="<?php echo stripslashes($obj{"Reassessment_Goals_Changed_Adapted_For_ADLs1"});?>" />
    <br />
    </strong>
    <strong><?php xl('IDLs','e')?>&nbsp;</strong><strong>
    <input type="text" style="width:870px" name="Reassessment_Goals_Changed_Adapted_For_IDLs" id="Reassessment_Goals_Changed_Adapted_For_IDLs" 
 value="<?php echo stripslashes($obj{"Reassessment_Goals_Changed_Adapted_For_IDLs"});?>" />
    </strong>
    <strong><br />
    <?php xl('Other','e')?></strong><strong>

    <input type="text" style="width:860px" name="Reassessment_Goals_Changed_Adapted_For_Other" id="Reassessment_Goals_Changed_Adapted_For_Other" 
 value="<?php echo stripslashes($obj{"Reassessment_Goals_Changed_Adapted_For_Other"});?>" />
    </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td><strong><?php xl('OT continued treatment plan was communicated to and agreed upon by ','e')?></strong>
      <input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Patient" id="Reassessment_OT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_OT_communicated_and_agreed_upon_by"} == "Patient") echo "checked";;?>/>
<?php xl('Patient','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Physician" id="Reassessment_OT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_OT_communicated_and_agreed_upon_by"} == "Physician") echo "checked";;?>/>
<?php xl('Physician','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="PT/ST" id="Reassessment_OT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_OT_communicated_and_agreed_upon_by"} == "PT/ST") echo "checked";;?>/>
<?php xl('PT/ST','e')?><br />
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="PTA/COTA" id="Reassessment_OT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_OT_communicated_and_agreed_upon_by"} == "PTA/COTA") echo "checked";;?>/>
<?php xl('PTA/COTA','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Skilled Nursing" id="Reassessment_OT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_OT_communicated_and_agreed_upon_by"} == "Skilled Nursing") echo "checked";;?>/>
<?php xl('Skilled Nursing','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Caregiver/Family" id="Reassessment_OT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_OT_communicated_and_agreed_upon_by"} == "Caregiver/Family") echo "checked";;?>/>
<?php xl('Caregiver/Family','e')?>
<input type="checkbox" name="Reassessment_OT_communicated_and_agreed_upon_by" value="Case Manager" id="Reassessment_OT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_OT_communicated_and_agreed_upon_by"} == "Case Manager") echo "checked";;?>/>
<?php xl('Case Manager','e')?>&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Other','e')?>&nbsp;
<input type="text" style="width:310px" name="Reassessment_OT_communicated_and_agreed_upon_by_other" id="Reassessment_OT_communicated_and_agreed_upon_by_other" value="<?php echo stripslashes($obj{"Reassessment_OT_communicated_and_agreed_upon_by_other"});?>"/>
</td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td><strong>

	<?php xl('ADDITIONAL  SERVICES PROVIDED  THIS VISIT','e')?></strong><br> 
	<input type="checkbox" name="Reassessment_ADDITIONAL_SERVICES_Home_Exercise" id="Reassessment_ADDITIONAL_SERVICES_Home_Exercise" 
<?php if ($obj{"Reassessment_ADDITIONAL_SERVICES_Home_Exercise"} == "on") echo "checked";;?>/>
<?php xl('Home Exercise Program Upgraded','e')?><br>
  <input type="checkbox" name="Reassessment_ADDITIONAL_SERVICES_Recomme_Env_Adaptations"  id="Reassessment_ADDITIONAL_SERVICES_Recomme_Env_Adaptations" 
<?php if ($obj{"Reassessment_ADDITIONAL_SERVICES_Recomme_Env_Adaptations"} == "on") echo "checked";;?>/>
<?php xl('Recommendations for Environmental Adaptations Reviewed','e')?><br>
<input type="checkbox" name="Reassessment_ADDITIONAL_SERVICES_Recomme_SafetyIssues" id="Reassessment_ADDITIONAL_SERVICES_Recomme_SafetyIssues" 
<?php if ($obj{"Reassessment_ADDITIONAL_SERVICES_Recomme_SafetyIssues"} == "on") echo "checked";;?>/>
<?php xl('Recommendations for Safety Issues Implemented','e')?><br>
<input type="checkbox" name="Reassessment_ADDITIONAL_SERVICES_Treatment" id="Reassessment_ADDITIONAL_SERVICES_Treatment" 
<?php if ($obj{"Reassessment_ADDITIONAL_SERVICES_Treatment"} == "on") echo "checked";;?>/>

<label for="checkbox17"><?php xl('Treatment for','e')?></label>
<strong>
<input type="text" style="width:790px" name="Reassessment_ADDITIONAL_SERVICES_Treatment_for" id="Reassessment_ADDITIONAL_SERVICES_Treatment_for" 
value="<?php echo stripslashes($obj{"Reassessment_ADDITIONAL_SERVICES_Treatment_for"});?>" />
      <br />

</strong>
      <?php xl('Other Services Provided','e')?><strong>
      <input type="text" style="width:730px" name="Reassessment_Other_Services_Provided" id="Reassessment_Other_Services_Provided" 
value="<?php echo stripslashes($obj{"Reassessment_Other_Services_Provided"});?>" />
      </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td width="50%"><strong>
    <?php xl('Therapist Performing Reassessment(Name and Title)','e')?></strong></td>
    
    
   <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td></tr></table></td>

  </tr>
</table>
<a href="javascript:top.restoreSession();document.reassessment.submit();"	class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
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
