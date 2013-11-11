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
$formTable = "forms_pt_Reassessment";

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
	    obj.open("GET",site_root+"/forms/ptreassessment/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	  
	  //for schedule
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
<body class="body_top">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_pt_Reassessment", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>
<form method="post"
		action="<?php echo $rootdir;?>/forms/ptreassessment/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="reassessment">
		<h3 align="center"><?php xl('PHYSICAL THERAPY REASSESSMENT','e'); ?>
		<br>
		<label>
        <input type="radio" name="Reassessment_visit_type" value="13th Visit" id="Reassessment_visit_type" 
        <?php if ($obj{"Reassessment_visit_type"} == "13th Visit") echo "checked";;?>/>
		<?php xl('13th Visit','e')?></label><label>
        <input type="radio" name="Reassessment_visit_type" value="19th Visit" id="Reassessment_visit_type" 
        <?php if ($obj{"Reassessment_visit_type"} == "19th Visit") echo "checked";;?>/>
        <?php xl('19th Visit','e')?></label><label>
        <input type="radio" name="Reassessment_visit_type" value="Other Visit" id="Reassessment_visit_type" 
        <?php if ($obj{"Reassessment_visit_type"} == "Other Visit") echo "checked";;?>/>
        <?php xl('Other Visit','e')?></label></h3>
<table align="center" border="1" cellpadding="0px" cellspacing="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="0px" cellspacing="0px" class="formtable">
      <tr>

        <td width="10%" align="center" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
        <td width="15%" align="center" valign="top"><input type="text"
					id="patient_name" value="<?php patientName()?>"
				readonly /></td>
        <td width="5%" align="center"><strong><?php xl('MR#','e')?></strong></td>
        <td width="10%" align="center" valign="top" class="bold"><input
					type="text"  style="width:100%"  name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" readonly />

<td width="5%" ><p><strong><?php xl('Time In','e');?></strong></p></td>
    <td width="10%"><select name="Reassessment_Time_In" id="Reassessment_Time_In">
    <?php timeDropDown(stripslashes($obj{"Reassessment_Time_In"}))?></select></td>
    <td width="5%"><p><strong><?php xl('Time Out','e');?></strong></p></td>
    <td width="10%"><select name="Reassessment_Time_Out" id="Reassessment_Time_Out">
    <?php timeDropDown(stripslashes($obj{"Reassessment_Time_Out"}))?></select></td>
					<td  width="5%"align="center"><strong><?php xl('Encounter Date','e')?></strong></td>
       <td width="25%" align="center">
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
    <?php xl('Irregular','e')?></label>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
       <?php xl('Temporal','e')?></label>
&nbsp;   <?php xl('Other','e')?>
 <input type="text" size="10px" name="Reassessment_VS_other" id="Reassessment_VS_other"
  value="<?php echo stripslashes($obj{"Reassessment_VS_other"});?>" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Respirations','e')?>
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
  <input type="checkbox" name="Reassessment_VS_BP_side" value="Right" id="right" 
  <?php if ($obj{"Reassessment_VS_BP_side"} == "Right") echo "checked";;?>/>

  <?php xl('Right','e')?></label>
<label>
  <input type="checkbox" name="Reassessment_VS_BP_side" value="Left" id="left" 
  <?php if ($obj{"Reassessment_VS_BP_side"} == "Left") echo "checked";;?>/>
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
    <?php if ($obj{"Reassessment_VS_BP_Body_Position"} == "Lying") echo "checked";;?>/></label><label>
  <?php xl('Lying','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('*O','e')?>
<sub><?php xl('2','e')?></sub> <?php xl('Sat','e')?>
  <input type="text" size="3px" name="Reassessment_VS_Sat" id="physician" 
  value="<?php echo stripslashes($obj{"Reassessment_VS_Sat"});?>" />
</label>
<?php xl('*Physician ordered','e')?></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>

<strong><?php xl('Pain','e')?> </strong>
  <input type="checkbox" name="Reassessment_VS_Pain" value="No Pain" id="Reassessment_VS_Pain" 
   <?php if ($obj{"Reassessment_VS_Pain"} == "No Pain") echo "checked";;?>/>
<?php xl('No Pain','e')?>
<input type="checkbox" name="Reassessment_VS_Pain" value="Pain limits functional ability" id="Reassessment_VS_Pain" 
 <?php if ($obj{"Reassessment_VS_Pain"} == "Pain limits functional ability") echo "checked";;?>/>
<?php xl('Pain limits functional ability','e')?> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Intensity','e')?>

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
          <input type="checkbox" name="Reassessment_HR_Needs_assistance" id="Reassessment_HR_Needs_assistance" 
          <?php if ($obj{"Reassessment_HR_Needs_assistance"} == "on") echo "checked";;?>/>
<?php xl('Needs assistance in all activities','e')?><br />
<input type="checkbox" name="Reassessment_HR_Unable_to_leave_home" id="Reassessment_HR_Unable_to_leave_home" 
    <?php if ($obj{"Reassessment_HR_Unable_to_leave_home"} == "on") echo "checked";;?>/>
<?php xl('Unable to leave home safely unassisted','e')?><br />
<input type="checkbox" name="Reassessment_HR_Medical_Restrictions" id="Reassessment_HR_Medical_Restrictions" 
    <?php if ($obj{"Reassessment_HR_Medical_Restrictions"} == "on") echo "checked";;?>/>
<?php xl('Medical Restrictions in','e')?> 
<input type="text" style="width:58%" name="Reassessment_HR_Medical_Restrictions_In" id="Reassessment_HR_Medical_Restrictions_In"
 value="<?php echo stripslashes($obj{"Reassessment_HR_Medical_Restrictions_In"});?>" />
<br />
<input type="checkbox" name="Reassessment_HR_SOB_upon_exertion" id="Reassessment_HR_SOB_upon_exertion" 
    <?php if ($obj{"Reassessment_HR_SOB_upon_exertion"} == "on") echo "checked";;?>/>
<?php xl('SOB upon exertion','e')?> &nbsp;&nbsp;&nbsp;&nbsp;
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
<input type="checkbox" name="Reassessment_HR_Multiple_stairs_enter_exit_home" 
 id="Reassessment_HR_Multiple_stairs_enter_exit_home" 
<?php if ($obj{"Reassessment_HR_Multiple_stairs_enter_exit_home"} == "on") echo "checked";;?>/> 
<?php xl('Multiple stairs to enter/exit home','e')?><br />
<?php xl('Other','e')?>&nbsp;
<input type="text" style="width:80%" name="Reassessment_HR_Other" id="Reassessment_HR_Other" 
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
    <strong><?php xl('MOBILITY REASSESSMENT','e')?></strong><br />
    <strong><?php xl('Scale','e')?>  </strong>
    <?php xl('U=Unable*, Dep=Dependent, Max=needs 75-51% assist, Mod=needs 50-26%, Min=needs 25-1% assist, CG=constant  contact guard, SBA=stand by assist, S=supervised, needs cues, Mod I=Independent with assistive devices, Independent=no assist required.','e')?>
    </strong></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="2px" class="formtable">
      <tr>
        <td width="12%" align="center" scope="row"><strong><?php xl('Mobility Skills','e')?></strong></td>
        <td width="12%" align="center"><strong><?php xl('Initial','e')?> </strong><strong>Status</strong></td>
        <td width="12%" align="center"><strong><?php xl('Current Status','e')?></strong></td>

        <td width="64%" align="center"><strong><?php xl('Describe progress related to mobility skills','e')?></strong><br />
          </td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Rolling','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Rolling_Initial_Status" id="Reassessment_ADL_Rolling_Initial_Status">
       <?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Rolling_Initial_Status"}))	?></select></strong></td>

        <td align="center"><strong><select name="Reassessment_ADL_Rolling_Current_Status" id="Reassessment_ADL_Rolling_Current_Status">
        <?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Rolling_Current_Status"}))	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Rolling_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Rolling_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Rolling_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?> &nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Rolling_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Rolling_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Rolling_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Rolling_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Rolling_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Rolling_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Supine <-> Sit','e')?></td>

        <td align="center"><strong><select name="Reassessment_ADL_Supine_Sit_Initial_Status" id="Reassessment_ADL_Supine_Sit_Initial_Status">
        <?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Supine_Sit_Initial_Status"}))	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Supine_Sit_Current_Status" id="Reassessment_ADL_Supine_Sit_Current_Status">
        <?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Supine_Sit_Current_Status"}))	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" 
    <?php if ($obj{"Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Supine_Sit_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>

        <td scope="row"><?php xl('Sit <->Stand','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Sit_Stand_Initial_Status" id="Reassessment_ADL_Sit_Stand_Initial_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Sit_Stand_Initial_Status"}))	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Sit_Stand_Current_Status" id="Reassessment_ADL_Sit_Stand_Current_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Sit_Stand_Current_Status"}))	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Sit_Stand_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>

      </tr>
      <tr>
        <td scope="row"><?php xl('Transfers','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Transfers_Initial_Status" id="Reassessment_ADL_Transfers_Initial_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Transfers_Initial_Status"}))	?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Transfers_Current_Status" id="Reassessment_ADL_Transfers_Current_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Transfers_Current_Status"}))	?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Transfers_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Transfers_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Transfers_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Transfers_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Transfers_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Transfers_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Transfers_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Transfers_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Transfers_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Fall Recovery','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Fall_Recovery_Initial_Status" id="Reassessment_ADL_Fall_Recovery_Initial_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Fall_Recovery_Initial_Status"}))?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_Fall_Recovery_Current_Status" id="Reassessment_ADL_Fall_Recovery_Current_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Fall_Recovery_Current_Status"}))?></select></strong></td>

        <td><input type="checkbox" name="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" 
         <?php if ($obj{"Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" 
   <?php if ($obj{"Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Fall_Recovery_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('Gait Assistance','e')?></td>
        <td align="center"><strong><select name="Reassessment_ADL_Gait_Assistance_Initial_Status" id="Reassessment_ADL_Gait_Assistance_Initial_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Gait_Assistance_Initial_Status"}))?></select></strong></td>

        <td align="center"><strong><select name="Reassessment_ADL_Gait_Assistance_Current_Status" id="Reassessment_ADL_Gait_Assistance_Current_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_Gait_Assistance_Current_Status"}))?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_Gait_Assistance_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('W/C Assistance','e')?></td>

       <td align="center"><strong><select name="Reassessment_ADL_WC_Assistance_Initial_Status" id="Reassessment_ADL_WC_Assistance_Initial_Status"> 
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_WC_Assistance_Initial_Status"}))?></select></strong></td>
        <td align="center"><strong><select name="Reassessment_ADL_WC_Assistance_Current_Status" id="Reassessment_ADL_WC_Assistance_Current_Status">
<?php Mobility_status(stripslashes($obj{"Reassessment_ADL_WC_Assistance_Current_Status"}))?></select></strong></td>
        <td><input type="checkbox" name="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" value="N/A" id="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" 
        <?php if ($obj{"Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;&nbsp;
  <input type="checkbox" name="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" value="Goal met" id="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" 
  <?php if ($obj{"Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills"} == "Goal met") echo "checked";;?>/>
<?php xl('Goal met','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" value="Goals Not Met" id="Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills" 
<?php if ($obj{"Reassessment_ADL_WC_Assistance_Describe_Mobility_Skills"} == "Goals Not Met") echo "checked";;?>/>
<?php xl('Goals Not Met (see Goals/Changed Adapted)','e')?></td>
      </tr> 
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>


<input type="checkbox" name="Reassessment_Mobility_Reassessment_NA" id="Reassessment_Mobility_Reassessment_NA" 
<?php if ($obj{"Reassessment_Mobility_Reassessment_NA"} == "on") echo "checked";;?>/>
<strong><?php xl('N/A','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Assistive Devices','e')?></strong>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="None" id="Reassessment_Assistive_Devices"  
<?php if ($obj{"Reassessment_Assistive_Devices"} == "None") echo "checked";;?>/>
<?php xl('None','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Cane" id="Reassessment_Assistive_Devices"  
<?php if ($obj{"Reassessment_Assistive_Devices"} == "Cane") echo "checked";;?>/>
<?php xl('Cane','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Quad Cane" id="Reassessment_Assistive_Devices"  
<?php if ($obj{"Reassessment_Assistive_Devices"} == "Quad Cane") echo "checked";;?>/>
<?php xl('Quad Cane','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Front-Wheel Walker" id="Reassessment_Assistive_Devices" 
<?php if ($obj{"Reassessment_Assistive_Devices"} == "Front-Wheel Walker") echo "checked";;?>/>
<?php xl('Front-Wheel Walker','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Four Wheeled Walker" id="Reassessment_Assistive_Devices" 
<?php if ($obj{"Reassessment_Assistive_Devices"} == "Four Wheeled Walker") echo "checked";;?>/>
<?php xl('Four Wheeled Walker','e')?>
<input type="checkbox" name="Reassessment_Assistive_Devices" value="Standard Walker" id="Reassessment_Assistive_Devices" 
<?php if ($obj{"Reassessment_Assistive_Devices"} == "Standard Walker") echo "checked";;?>/>
<?php xl('Standard Walker','e')?> <br/>
<?php xl('Other','e')?>
<input type="text" style="width:92%"  name="Reassessment_Assistive_Devices_Other" id="Reassessment_Assistive_Devices_Other" 
 value="<?php echo stripslashes($obj{"Reassessment_Assistive_Devices_Other"});?>" /> <strong><br />
<?php xl('Timed Up and Go Score','e')?></strong>
<input type="text" name="Reassessment_Timed_Up_Go_Score" id="Reassessment_Timed_Up_Go_Score" 
 value="<?php echo stripslashes($obj{"Reassessment_Timed_Up_Go_Score"});?>" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('Interpretation','e')?></strong> 
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="No Fall Risk" id="Reassessment_Interpretation_Risk_Types" 
<?php if ($obj{"Reassessment_Interpretation_Risk_Types"} == "No Fall Risk") echo "checked";;?>/>
<strong><?php xl('Independent-No Fall Risk (','e')?> &lt; <?php xl('11 seconds)','e')?></strong>
<br />
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="Minimal Fall Risk" id="Reassessment_Interpretation_Risk_Types" 
<?php if ($obj{"Reassessment_Interpretation_Risk_Types"} == "Minimal Fall Risk") echo "checked";;?>/>
<strong><?php xl('Minimal Fall Risk (11- 13 seconds)','e')?> </strong>

<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="Moderate Fall Risk" id="Reassessment_Interpretation_Risk_Types" 
<?php if ($obj{"Reassessment_Interpretation_Risk_Types"} == "Moderate Fall Risk") echo "checked";;?>/>
<strong><?php xl('Moderate Fall Risk (13.5-19 seconds)','e')?></strong>
<input type="checkbox" name="Reassessment_Interpretation_Risk_Types" value="High Risk for Falls" id="Reassessment_Interpretation_Risk_Types" 
<?php if ($obj{"Reassessment_Interpretation_Risk_Types"} == "High Risk for Falls") echo "checked";;?>/>
<strong><?php xl('High Risk for Falls(','e')?>&gt;<?php xl('19 seconds)','e')?></strong>  <br />
<strong><?php xl('Other Tests/Scores/Interpretations','e')?></strong> 
<input type="text" name="Reassessment_Other_Interpretations" style="width:67%" id="Reassessment_Other_Interpretations" 
 value="<?php echo stripslashes($obj{"Reassessment_Other_Interpretations"});?>" />
<br /> 
<input type="checkbox" name="Reassessment_Interpretation_NA" value="N/A" id="Reassessment_Interpretation_NA" 
<?php if ($obj{"Reassessment_Interpretation_NA"} == "N/A") echo "checked";;?>/><strong>
<?php xl('N/A','e')?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Patient/Caregiver Continues to Have the Following Problems Achieving Goals with Mobility','e')?></strong>
<input type="text" name="Reassessment_Problems_Achieving_Goals" style="width:96%" id="Reassessment_Problems_Achieving_Goals" 
 value="<?php echo stripslashes($obj{"Reassessment_Problems_Achieving_Goals"});?>" /></td></tr></table></td>

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
        <td align="center"><input type="text" size="10" name="Reassessment_MS_ENDURANCE_Initial" id="Reassessment_MS_ENDURANCE_Initial" 
         value="<?php echo stripslashes($obj{"Reassessment_MS_ENDURANCE_Initial"});?>" /></td>
        <td align="center"><input type="text" size="10" name="Reassessment_MS_ENDURANCE_Current" id="Reassessment_MS_ENDURANCE_Current" 
          value="<?php echo stripslashes($obj{"Reassessment_MS_ENDURANCE_Current"});?>" /></td>
        <td align="left"><?php xl('SITTING BALANCE S/D','e')?></td>
        <td align="center">
	<input type="text" size="5"  name="Reassessment_MS_SITTING_BALANCE_Initial_S" id="Reassessment_MS_SITTING_BALANCE_Initial_S" 
  value="<?php echo stripslashes($obj{"Reassessment_MS_SITTING_BALANCE_Initial_S"});?>" />
	<strong><?php xl('/','e')?></strong>
	<input type="text" size="5"  name="Reassessment_MS_SITTING_BALANCE_Initial_D" id="Reassessment_MS_SITTING_BALANCE_Initial_D" 
  value="<?php echo stripslashes($obj{"Reassessment_MS_SITTING_BALANCE_Initial_D"});?>" /></td>
        <td align="center">
	<input type="text" size="5" name="Reassessment_MS_SITTING_BALANCE_Current_S" id="Reassessment_MS_SITTING_BALANCE_Current_S" 
  value="<?php echo stripslashes($obj{"Reassessment_MS_SITTING_BALANCE_Current_S"});?>" />
<strong><?php xl('/','e')?></strong>
	<input type="text" size="5" name="Reassessment_MS_SITTING_BALANCE_Current_D" id="Reassessment_MS_SITTING_BALANCE_Current_D" 
  value="<?php echo stripslashes($obj{"Reassessment_MS_SITTING_BALANCE_Current_D"});?>" /></td>
        </tr>
    <tr>
        <td align="left" scope="row"><?php xl('SAFETY AWARENESS','e')?></td>
        <td align="center"><input type="text" size="10" name="Reassessment_MS_SAFETY_AWARENESS_Initial" id="Reassessment_MS_SAFETY_AWARENESS_Initial" 
 value="<?php echo stripslashes($obj{"Reassessment_MS_SAFETY_AWARENESS_Initial"});?>" /></td>
        <td align="center"><input type="text" size="10" name="Reassessment_MS_SAFETY_AWARENESS_Current" id="Reassessment_MS_SAFETY_AWARENESS_Current" 
 value="<?php echo stripslashes($obj{"Reassessment_MS_SAFETY_AWARENESS_Current"});?>" /></td>
       
        <td align="left"><?php xl('STANDING BALANCE S/D','e')?></td>
        <td align="center">
	<input type="text" size="5"  name="Reassessment_MS_STANDING_BALANCE_Initial_S" id="Reassessment_MS_STANDING_BALANCE_Initial_S" 
value="<?php echo stripslashes($obj{"Reassessment_MS_STANDING_BALANCE_Initial_S"});?>" />
<strong><?php xl('/','e')?> </strong>
	<input type="text" size="5"  name="Reassessment_MS_STANDING_BALANCE_Initial_D" id="Reassessment_MS_STANDING_BALANCE_Initial_D" 
value="<?php echo stripslashes($obj{"Reassessment_MS_STANDING_BALANCE_Initial_D"});?>" /></td>
        <td align="center">
	<input type="text" size="5" name="Reassessment_MS_STANDING_BALANCE_Current_S" id="Reassessment_MS_STANDING_BALANCE_Current_S" 
value="<?php echo stripslashes($obj{"Reassessment_MS_STANDING_BALANCE_Current_S"});?>" />
<strong><?php xl('/','e')?></strong>
	<input type="text" size="5" name="Reassessment_MS_STANDING_BALANCE_Current_D" id="Reassessment_MS_STANDING_BALANCE_Current_D" 
value="<?php echo stripslashes($obj{"Reassessment_MS_STANDING_BALANCE_Current_D"});?>" /></td>
        </tr>      
    </table></td>

  </tr>
  <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<input type="checkbox" name="Reassessment_Miscellaneous_NA" id="Reassessment_Miscellaneous_NA" value="N/A"
<?php if ($obj{"Reassessment_Miscellaneous_NA"} == "N/A") echo "checked";;?>/>
    <label><strong>
    <?php xl('N/A','e')?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="Reassessment_Miscellaneous_NA" 
value="Endurance" <?php if ($obj{"Reassessment_Miscellaneous_NA"} == "Endurance") echo "checked";;?>/>
<label><?php xl('Endurance','e')?></label>
<br/>
<?php xl('Patient/Caregiver Continues to Have the Following Problems Achieving Goals with','e')?></label><br />

<input type="checkbox" name="Reassessment_Problems_Achieving_Goals_With" id="Reassessment_Problems_Achieving_Goals_With" 
value="Safety Awarness" <?php if ($obj{"Reassessment_Problems_Achieving_Goals_With"} == "Safety Awarness") echo "checked";;?>/>
<label><?php xl('Safety Awareness','e')?></label>

<input type="checkbox" name="Reassessment_Problems_Achieving_Goals_With" id="Reassessment_Problems_Achieving_Goals_With" 
value="Balance" <?php if ($obj{"Reassessment_Problems_Achieving_Goals_With"} == "Balance") echo "checked";;?>/>
<label><?php xl('Balance','e')?></label>
<input type="text" name="Reassessment_Problems_Achieving_Goals_With_Notes"  style="width:70%;" id="Reassessment_Problems_Achieving_Goals_With_Notes" 
value="<?php echo stripslashes($obj{"Reassessment_Problems_Achieving_Goals_With_Notes"});?>" />
</strong></label></td></tr></table></td>
</tr>

<tr>
<td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
<strong><?php xl('MUSCLE STRENGTH/FUNCTIONAL ROM EVALUATION','e')?><br />
<input type="checkbox" name="Reassessment_MS_ROM_All_Muscle_WFL" value="All Muscle Strength is WFL" id="Reassessment_MS_ROM_All_Muscle_WFL" 
<?php if ($obj{"Reassessment_MS_ROM_All_Muscle_WFL"} == "All Muscle Strength is WFL") echo "checked";;?>/>
<?php xl('All Muscle Strength is WFL','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_MS_ROM_All_Muscle_WFL" value="All ROM is WFL" id="Reassessment_MS_ROM_All_Muscle_WFL" 
<?php if ($obj{"Reassessment_MS_ROM_All_Muscle_WFL"} == "All ROM is WFL") echo "checked";;?>/>
<?php xl('All ROM is WFL','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Reassessment_MS_ROM_All_Muscle_WFL" value="other Problem" id="Reassessment_MS_ROM_All_Muscle_WFL"
<?php if ($obj{"Reassessment_MS_ROM_All_Muscle_WFL"} == "other Problem") echo "checked";;?>/>
<?php xl('The following problem areas are','e')?></strong>
<input type="text" name="Reassessment_MS_ROM_Following_Problem_areas_Notes" style="width:100%" id="Reassessment_MS_ROM_Following_Problem_areas_Notes" 
value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Following_Problem_areas_Notes"});?>" /></td></tr></table></td>
</tr>

<tr>
<td scope="row"><table width="100%" border="1" cellspacing="0px" cellpadding="2px" class="formtable">
<tr>
<td rowspan="2" align="center" scope="row"><strong><?php xl('INITIAL  PROBLEM  AREA(S)','e')?></strong></td>

<td colspan="2" align="center"><strong><?php xl('STRENGTH','e')?></strong></td>
<td colspan="2" align="center"><strong><?php xl('ROM','e')?></strong></td>
<td colspan="3" align="center"><strong><?php xl('ROM TYPE','e')?></strong></td>

<td colspan="2" align="center"><strong><?php xl('TONICITY','e')?>/strong></td>
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
  <input type="text" style="width:100%"  name="Reassessment_MS_ROM_Problemarea_text" id="Reassessment_MS_ROM_Problemarea_text" 
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
<td align="center" rowspan="3"><strong>
  <textarea name="Reassessment_MS_ROM_Further_description" id="Reassessment_MS_ROM_Further_description" 
rows="6" cols="30"><?php echo stripslashes($obj{"Reassessment_MS_ROM_Further_description"});?></textarea>
</strong></td>
</tr>
<tr>
<td align="center" scope="row"><strong>
  <input type="text" name="Reassessment_MS_ROM_Problemarea_text1" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text1" 
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

</tr>

<tr>
<td align="center" scope="row"><strong>
  <input type="text" name="Reassessment_MS_ROM_Problemarea_text2" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text2" 
		value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problemarea_text2"});?>" />
</strong></td>
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
<td align="center" scope="row">
  <strong>
    <input type="text" name="Reassessment_MS_ROM_Problemarea_text3" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text3" 
	value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problemarea_text3"});?>" />
    </strong></td>
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
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="Reassessment_MS_ROM_ROM_Type3" 
	value="P" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type3"} == "P") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="Reassessment_MS_ROM_ROM_Type3"
	value="AA" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type3"} == "AA") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type3" id="Reassessment_MS_ROM_ROM_Type3" 
	value="A" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type3"} == "A") echo "checked";;?>/></td>

<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity3" id="Reassessment_MS_ROM_Tonicity3" 
	value="Hyper" <?php if ($obj{"Reassessment_MS_ROM_Tonicity3"} == "Hyper") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity3" id="Reassessment_MS_ROM_Tonicity3"
	value="Hypo" <?php if ($obj{"Reassessment_MS_ROM_Tonicity3"} == "Hypo") echo "checked";;?>/></td>
<td align="center" rowspan="3"><textarea name="Reassessment_MS_ROM_Further_description1" id="Reassessment_MS_ROM_Further_description1" rows="6" cols="30"><?php echo stripslashes($obj{"Reassessment_MS_ROM_Further_description1"});?></textarea></td>
</tr>
<tr>
<td align="center" scope="row">
  <strong>

    <input type="text" name="Reassessment_MS_ROM_Problemarea_text4" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text4"
	value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problemarea_text4"});?>" />
    </strong></td>
<td align="center"><strong>
  <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right4" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right4" 
	value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Right4"});?>" />
  <?php xl('/5','e')?></strong></td>
<td align="center"><strong>
  <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left4" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left4" 
	 value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Left4"});?>" />
  <?php xl('/5','e')?></strong></td>

<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM4" id="Reassessment_MS_ROM_ROM4" 
	value="Right" <?php if ($obj{"Reassessment_MS_ROM_ROM4"} == "Right") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM4" id="Reassessment_MS_ROM_ROM4" 
	value="Left" <?php if ($obj{"Reassessment_MS_ROM_ROM4"} == "Left") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type4" id="Reassessment_MS_ROM_ROM_Type4" 
	value="P" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type4"} == "P") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type4" id="Reassessment_MS_ROM_ROM_Type4" 
	value="AA" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type4"} == "AA") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type4" id="Reassessment_MS_ROM_ROM_Type4" 
	value="A" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type4"} == "A") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity4" id="Reassessment_MS_ROM_Tonicity3" 
	value="Hyper" <?php if ($obj{"Reassessment_MS_ROM_Tonicity4"} == "Hyper") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity4" id="Reassessment_MS_ROM_Tonicity3" 
	value="Hypo" <?php if ($obj{"Reassessment_MS_ROM_Tonicity4"} == "Hypo") echo "checked";;?>/></td>

</tr>

<tr>
<td align="center" scope="row">
  <strong>

    <input type="text" name="Reassessment_MS_ROM_Problemarea_text5" style="width:100%" id="Reassessment_MS_ROM_Problemarea_text5"
	value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problemarea_text5"});?>" />
    </strong></td>
<td align="center"><strong>
  <input type="text" name="Reassessment_MS_ROM_STRENGTH_Right5" size="2px" id="Reassessment_MS_ROM_STRENGTH_Right5" 
	value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Right5"});?>" />
  <?php xl('/5','e')?></strong></td>
<td align="center"><strong>
  <input type="text" name="Reassessment_MS_ROM_STRENGTH_Left5" size="2px" id="Reassessment_MS_ROM_STRENGTH_Left5" 
	 value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_STRENGTH_Left5"});?>" />
  <?php xl('/5','e')?></strong></td>

<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM5" id="Reassessment_MS_ROM_ROM5" 
	value="Right" <?php if ($obj{"Reassessment_MS_ROM_ROM5"} == "Right") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM5" id="Reassessment_MS_ROM_ROM5" 
	value="Left" <?php if ($obj{"Reassessment_MS_ROM_ROM5"} == "Left") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type5" id="Reassessment_MS_ROM_ROM_Type5" 
	value="P" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type5"} == "P") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type5" id="Reassessment_MS_ROM_ROM_Type5" 
	value="AA" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type5"} == "AA") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_ROM_Type5" id="Reassessment_MS_ROM_ROM_Type5" 
	value="A" <?php if ($obj{"Reassessment_MS_ROM_ROM_Type5"} == "A") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity5" id="Reassessment_MS_ROM_Tonicity5" 
	value="Hyper" <?php if ($obj{"Reassessment_MS_ROM_Tonicity5"} == "Hyper") echo "checked";;?>/></td>
<td align="center"><input type="checkbox" name="Reassessment_MS_ROM_Tonicity5" id="Reassessment_MS_ROM_Tonicity5" 
	value="Hypo" <?php if ($obj{"Reassessment_MS_ROM_Tonicity5"} == "Hypo") echo "checked";;?>/></td>

</tr>
</table></td>
</tr>
<tr>
<td scope="row"><table width="100%"  border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr>
<td><strong><input type="checkbox" name="Reassessment_MS_ROM_NA" id="Reassessment_MS_ROM_NA"  value="N/A"
<?php if ($obj{"Reassessment_MS_ROM_NA"} == "N/A") echo "checked";;?>/>
<?php xl('N/A','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type="checkbox" name="Reassessment_MS_ROM_NA" value="Tonicity" 
<?php if ($obj{"Reassessment_MS_ROM_NA"} == "Tonicity") echo "checked";;?>/>

<?php xl('Tonicity','e')?>
<input type="text" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Note" style="width:80%" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Note" 
value="<?php echo stripslashes($obj{"Reassessment_MS_ROM_Problems_Achieving_Goals_Note"});?>" />
<br/>
<?php xl('Patient/Caregiver Continues to Have the Following Problems Achieving Goals with','e')?>
 <input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="Strength" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" 
<?php if ($obj{"Reassessment_MS_ROM_Problems_Achieving_Goals_Type"} == "Strength") echo "checked";;?>/>
<?php xl('Strength','e')?>

<input type="checkbox" name="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" value="ROM" id="Reassessment_MS_ROM_Problems_Achieving_Goals_Type" 
<?php if ($obj{"Reassessment_MS_ROM_Problems_Achieving_Goals_Type"} == "ROM") echo "checked";;?>/>
<?php xl('ROM','e')?></strong>
</td></tr></table></td>
  </tr>
 </tr>
 <tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
    <strong><?php xl('ENVIRONMENTAL BARRIERS/SAFETY ISSUES','e')?></strong></td></tr></table></td>
  </tr>
<tr>
    <td scope="row"><table border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
	<input type="checkbox" name="Reassessment_Environmental_Barriers" id="Reassessment_Environmental_Barriers" value="No Issues"
  <?php if ($obj{"Reassessment_Environmental_Barriers"} == "No Issues") echo "checked";;?>/>
    <label for="checkbox"><?php xl('No environmental barriers in home','e')?>  
      <input type="checkbox" name="Reassessment_Environmental_Barriers" id="Reassessment_Environmental_Barriers" value="Issues exists" 
  <?php if ($obj{"Reassessment_Environmental_Barriers"} == "Issues exists") echo "checked";;?>/>
     <?php xl(' The following environmental issues continue to exist','e')?><br />
    </label>
    <input type="text" name="Reassessment_Environmental_Issues_Notes"  style="width:900px"  id="Reassessment_Environmental_Issues_Notes"  
value="<?php echo stripslashes($obj{"Reassessment_Environmental_Issues_Notes"});?>" /></td></tr></table></td>
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
 value="Yes" <?php if ($obj{"Reassessment_RO_Patient_Prior_Level_Function"} == "Yes") echo "checked";;?>/>
    <label for="checkbox13"><?php xl('Yes','e')?></label>
    <input type="checkbox" name="Reassessment_RO_Patient_Prior_Level_Function" id="Reassessment_RO_Patient_Prior_Level_Function" 
value="No" <?php if ($obj{"Reassessment_RO_Patient_Prior_Level_Function"} == "No") echo "checked";;?>/>
    <?php xl('No Has Patient Reached Their Prior Level of Function?','e')?>
<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('If No, Explain','e')?> <input type="text" name="Reassessment_RO_Prior_Level_Function_Not_Reached" 
id="Reassessment_RO_Prior_Level_Function_Not_Reached" style="width:80%"
value="<?php echo stripslashes($obj{"Reassessment_RO_Prior_Level_Function_Not_Reached"});?>"/> <br/>
      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" 
value="Yes" <?php if ($obj{"Reassessment_RO_Patient_Long_Term_Goals"} == "Yes") echo "checked";;?>/>
      <?php xl('Yes','e')?>
      <input type="checkbox" name="Reassessment_RO_Patient_Long_Term_Goals" id="Reassessment_RO_Patient_Long_Term_Goals" 
value="No" <?php if ($obj{"Reassessment_RO_Patient_Long_Term_Goals"} == "No") echo "checked";;?>/>
   <?php xl(' No Has Patient Reached Their Long  Term Goals Established on Admission?','e')?><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('If No, Explain','e')?>  <input type="text" name="Reassessment_RO_Long_Term_Goal_Not_Reached" 
id="Reassessment_RO_Long_Term_Goal_Not_Reached" style="width:80%"
value="<?php echo stripslashes($obj{"Reassessment_RO_Long_Term_Goal_Not_Reached"});?>"/><br/>



    <strong><?php xl('Skilled PT continues to be Reasonable and Necessary to','e')?></strong></label>
    <br />

    <input type="checkbox" name="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" id="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" 
value="Return to prior Level" <?php if ($obj{"Reassessment_Skilled_PT_Reasonable_And_Necessary_To"} == "Return to prior Level") echo "checked";;?>/>
<?php xl('Return Patient to Their Prior Level of Function','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_PT_Reasonable_And_Necessary_To"  id="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" 
value="Teach Patient" <?php if ($obj{"Reassessment_Skilled_PT_Reasonable_And_Necessary_To"} == "Teach Patient") echo "checked";;?>/>
<?php xl('Teach patient/caregiver compensatory strategies for mobility','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" id="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" 
value="Teach Patient New Skills" <?php if ($obj{"Reassessment_Skilled_PT_Reasonable_And_Necessary_To"} == "Teach Patient New Skills") echo "checked";;?>/>
<?php xl('Train patient/caregiver in learning new skill','e')?>
<br />
<input type="checkbox" name="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" id="Reassessment_Skilled_PT_Reasonable_And_Necessary_To" 
value="Make Modifications" <?php if ($obj{"Reassessment_Skilled_PT_Reasonable_And_Necessary_To"} == "Make Modifications") echo "checked";;?>/>
<?php xl('Make modifications to current program to achieve short term and long term goals*','e')?>
<label for="checkbox14"><br />
  <?php xl('Other','e')?>
    <strong>
    <input type="text" name="Reassessment_Skilled_PT_Other" style="width:88%"  id="Reassessment_Skilled_PT_Other" 
value="<?php echo stripslashes($obj{"Reassessment_Skilled_PT_Other"});?>"/>

    </strong></label></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td><strong>
    <?php xl('*Goals Changed/Adapted for Mobility','e')?></strong> <strong>
      <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Mobility" style="width:62%" id="Reassessment_Goals_Changed_Adapted_For_Mobility" 
value="<?php echo stripslashes($obj{"Reassessment_Goals_Changed_Adapted_For_Mobility"});?>"/> 

      <br />
    </strong>
    <strong><?php xl('Mobility','e')?></strong><strong>

    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Mobility1" style="width:85.5%"  id="Reassessment_Goals_Changed_Adapted_For_Mobility1" 
value="<?php echo stripslashes($obj{"Reassessment_Goals_Changed_Adapted_For_Mobility1"});?>" />
    <br />
    </strong>
    <strong><?php xl('Other','e')?>&nbsp;</strong><strong>
    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Other" style="width:87%"  id="Reassessment_Goals_Changed_Adapted_For_Other" 
 value="<?php echo stripslashes($obj{"Reassessment_Goals_Changed_Adapted_For_Other"});?>" />
    </strong>
    <strong><br />
    <?php xl('Other','e')?></strong><strong>
    <input type="text" name="Reassessment_Goals_Changed_Adapted_For_Other1" style="width:87.5%" id="Reassessment_Goals_Changed_Adapted_For_Other1" 
 value="<?php echo stripslashes($obj{"Reassessment_Goals_Changed_Adapted_For_Other1"});?>" />
    </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%"  border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td>
<strong><?php xl('PT continued treatment plan was communicated to and agreed upon by ','e')?></strong>
      <input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Patient" id="Reassessment_PT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_PT_communicated_and_agreed_upon_by"} == "Patient") echo "checked";;?>/>
<?php xl('Patient','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Physician" id="Reassessment_PT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_PT_communicated_and_agreed_upon_by"} == "Physician") echo "checked";;?>/>
<?php xl('Physician','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="OT/ST" id="Reassessment_PT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_PT_communicated_and_agreed_upon_by"} == "OT/ST") echo "checked";;?>/>
<?php xl('OT/ST','e')?><br />
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="PTA" id="Reassessment_PT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_PT_communicated_and_agreed_upon_by"} == "PTA") echo "checked";;?>/>
<?php xl('PTA','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Skilled Nursing" id="Reassessment_PT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_PT_communicated_and_agreed_upon_by"} == "Skilled Nursing") echo "checked";;?>/>
<?php xl('Skilled Nursing','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Caregiver/Family" id="Reassessment_PT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_PT_communicated_and_agreed_upon_by"} == "Caregiver/Family") echo "checked";;?>/>
<?php xl('Caregiver/Family','e')?>
<input type="checkbox" name="Reassessment_PT_communicated_and_agreed_upon_by" value="Case Manager" id="Reassessment_PT_communicated_and_agreed_upon_by" 
<?php if ($obj{"Reassessment_PT_communicated_and_agreed_upon_by"} == "Case Manager") echo "checked";;?>/>
<?php xl('Case Manager','e')?>
<br/> <?php xl('Other','e')?>
<input type="text" name="Reassessment_PT_communicated_and_agreed_upon_by_Others" id="Reassessment_PT_communicated_and_agreed_upon_by_Others" style="width:87%" value="<?php echo stripslashes($obj{"Reassessment_PT_communicated_and_agreed_upon_by_Others"});?>"   />

<td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td><strong>

<?php xl('ADDITIONAL  SERVICES PROVIDED  THIS VISIT','e')?></strong> <br/> 
	<input type="checkbox" name="Reassessment_AS_Home_Exercise" id="Reassessment_AS_Home_Exercise" 
<?php if ($obj{"Reassessment_AS_Home_Exercise"} == "on") echo "checked";;?>/>
<?php xl('Home Exercise Program Upgraded','e')?><br>
  <input type="checkbox" name="Reassessment_AS_Falls_Management_Prevention" id="Reassessment_AS_Falls_Management_Prevention" 
<?php if ($obj{"Reassessment_AS_Falls_Management_Prevention"} == "on") echo "checked";;?>/>
<?php xl('Falls Management/Prevention Program Implemented','e')?><br>
<input type="checkbox" name="Reassessment_AS_Recommendations_for_SafetyIssues" id="Reassessment_AS_Recommendations_for_SafetyIssues" 
<?php if ($obj{"Reassessment_AS_Recommendations_for_SafetyIssues"} == "on") echo "checked";;?>/>
<?php xl('Recommendations for Safety Issues Implemented','e')?><br>
<input type="checkbox" name="Reassessment_AS_Treatment" id="Reassessment_AS_Treatment" 
<?php if ($obj{"Reassessment_AS_Treatment"} == "on") echo "checked";;?>/>
<label><?php xl('Treatment for','e')?></label>
<strong>
<input type="text" name="Reassessment_AS_Treatment_for" style="width:78%"  id="Reassessment_AS_Treatment_for" 
value="<?php echo stripslashes($obj{"Reassessment_AS_Treatment_for"});?>" />
      <br />

</strong>
      <?php xl('Other Services Provided','e')?><strong>
      <input type="text" name="Reassessment_Other_Services_Provided" style="width:72%"  id="Reassessment_Other_Services_Provided" 
value="<?php echo stripslashes($obj{"Reassessment_Other_Services_Provided"});?>" />
      </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="1px" cellpadding="5px" cellspacing="0px" class="formtable"><tr><td width="45%"><strong>
    <?php xl('Therapist Performing Reassessment (Name and Title)','e')?></strong></td>    
   <td align="center" width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td></tr></table></td>

  </tr>
</table>
<a href="javascript:top.restoreSession();document.reassessment.submit();" class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
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
