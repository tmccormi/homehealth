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
$formTable = "forms_pt_careplan";

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


<style type="text/css">
.bold {
        font-weight: bold;
}
   
</style>

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
	    	 if(Dx=='careplan_PT_intervention')
	    	 {
		    	med_icd9.innerHTML= result['res'];
	    	 }
	    	 if(Dx=="careplan_Treatment_DX")
	    	 {
	    		 trmnt_icd9.innerHTML= result['res'];
	    	 }
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/ptcareplan/functions.php?code="+icd9code+"&Dx="+Dx,true);    
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
$obj = formFetch("forms_pt_careplan", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>
<form method="post"
		action="<?php echo $rootdir;?>/forms/ptcareplan/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="careplan">
		 <h3 align="center"><?php xl('PHYSICAL THERAPY CARE PLAN','e')?></h3>
	
	<h5 align="center">
		<?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
		</h5>
<table align="center"  border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
  <tr>
    <td align="left" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
    <td width="33%" align="center" valign="top"><input type="text" size="40"
					id="patient_name" value="<?php patientName()?>"
					readonly/></td>
    <td align="center"><strong><?php xl('Onset Date','e')?></strong></td><td width="21%" align="right">
   <input type='text' style="width:60%"  name='Onsetdate' id='Onsetdate'    				
					title='<?php xl('Date','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'
					value="<?php echo stripslashes($obj{"Onsetdate"});?>"  readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_onset_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"Onsetdate", ifFormat:"%Y-%m-%d", button:"img_onset_date"});
   </script></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">

<tr>
<td width="20%" align="left" scope="row"><strong>
<?php xl('Med DX/ Reason for PT intervention','e')?></strong></td>
<td width="30%" align="center">
<input type="text" id="careplan_PT_intervention" name="careplan_PT_intervention" style="width:100%;" value="<?php echo stripslashes($obj{'careplan_PT_intervention'}); ?>" />
</td>

<td align="center" width="20%"><strong><?php xl('Treatment Dx','e')?></strong></td>
<td width="30%" align="center" >
<input type="text" id="careplan_Treatment_DX" name="careplan_Treatment_DX" style="width:100%;" value="<?php echo stripslashes($obj{'careplan_Treatment_DX'}); ?>" /></td>
</tr>

    </table></td>

  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="50%" align="left" scope="row"><strong>
        <?php xl('PROBLEMS REQUIRING PT INTERVENTION','e')?></strong></td>         

<td width="15%" align="center"><strong><?php xl('Start of Care Date','e')?></strong></td>
<td width="35%" align="left">
<input type='text' style="width:35%"  name='careplan_SOCDate' id='careplan_SOCDate' title='<?php xl('Start of Care Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo stripslashes($obj{"careplan_SOCDate"});?>"  readonly />

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"careplan_SOCDate", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0px" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Decline_in_mobility" id="careplan_PT_Decline_in_mobility" 
          <?php if ($obj{"careplan_PT_Decline_in_mobility"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Decline in mobility in','e')?><br /></td>
        <td valign="top"><input name="careplan_PT_Decline_in_mobility_Note" type="text" 
         value="<?php echo stripslashes($obj{"careplan_PT_Decline_in_mobility_Note"});?>" />
</td>
        <td><input type="checkbox" name="careplan_PT_Decline_in_Balance" id="careplan_PT_Decline_in_Balance" 
        <?php if ($obj{"careplan_PT_Decline_in_Balance"} == "on") echo "checked";;?>/>
          <label for="techniques in others">
          <?php xl('Decline in Balance in','e')?></label></td>
        <td><input type="text" name="careplan_PT_Decline_in_Balance_Note" id="careplan_PT_Decline_in_Balance_Note" style="width:270px"
        value="<?php echo stripslashes($obj{"careplan_PT_Decline_in_Balance_Note"});?>" /></td>
      </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Decrease_in_ROM" id="careplan_PT_Decrease_in_ROM" 
           <?php if ($obj{"careplan_PT_Decrease_in_ROM"} == "on") echo "checked";;?>/>
        <?php xl('Decrease in ROM in','e')?></label> </td>
        <td valign="top"><label for="ROM in2"></label>
          <input type="text" name="careplan_PT_Decrease_in_ROM_Note" id="careplan_PT_Decrease_in_ROM_Note" 
          value="<?php echo stripslashes($obj{"careplan_PT_Decrease_in_ROM_Note"});?>" /></td>
        <td valign="top" scope="row">
        <input type="checkbox" name="careplan_PT_Decreased_Safety" id="careplan_PT_Decreased_Safety" 
        <?php if ($obj{"careplan_PT_Decreased_Safety"} == "on") echo "checked";;?>/>
          <label for="checkbox"><?php xl('Decreased Safety in','e')?></label></td>
        <td valign="top">
        <input type="text" name="careplan_PT_Decreased_Safety_Note" id="careplan_PT_Decreased_Safety_Note" style="width:270px" 
         value="<?php echo stripslashes($obj{"careplan_PT_Decreased_Safety_Note"});?>" /></td>
        </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Decline_in_Strength" id="careplan_PT_Decline_in_Strength" 
          <?php if ($obj{"careplan_PT_Decline_in_Strength"} == "on") echo "checked";;?>/></label>
          <?php xl('Decline in Strength in','e')?></td>
        <td valign="top"><label for="IADL skills"></label>
          <input type="text" name="careplan_PT_Decline_in_Strength_Note" id="careplan_PT_Decline_in_Strength_Note" 
           value="<?php echo stripslashes($obj{"careplan_PT_Decline_in_Strength_Note"});?>" /></td>
        <td valign="top" scope="row"><?php xl('Other','e')?>
         </td>
        <td valign="top">
        <input type="text" name="careplan_PT_intervention_Other" id="careplan_PT_intervention_Other" style="width:270px"
         value="<?php echo stripslashes($obj{"careplan_PT_intervention_Other"});?>" /></td>
        </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_PT_Increased_Pain_with_Movement" id="careplan_PT_Increased_Pain_with_Movement" 
          <?php if ($obj{"careplan_PT_Increased_Pain_with_Movement"} == "on") echo "checked";;?>/>
          <?php xl('Increased Pain with Movement in','e')?></label></td>
        <td colspan="3" valign="top"><label for="Mobility in"></label>
          <input type="text" name="careplan_PT_Increased_Pain_with_Movement_Note" id="careplan_PT_Increased_Pain_with_Movement_Note" 
          value="<?php echo stripslashes($obj{"careplan_PT_Increased_Pain_with_Movement_Note"});?>" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">

<tr>
<td scope="row"><strong><?php xl('TREATMENT PLAN FREQUENCY','e')?></strong><br></td>
<tr>
<td><?php xl('Frequency & Duration: ','e')?>&nbsp;
<input type="text" name="careplan_Treatment_Plan_Frequency" style="width:100%;" id="frequency" value="<?php echo stripslashes($obj{"careplan_Treatment_Plan_Frequency"});?>"/>
<br />
<?php xl('Effective Date: ','e')?> 
<input type="text" name="careplan_Treatment_Plan_EffectiveDate" id="careplan_Treatment_Plan_EffectiveDate" value="<?php echo stripslashes($obj{"careplan_Treatment_Plan_EffectiveDate"});?>" size="12" readonly>

<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_eff_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'>

<script LANGUAGE="JavaScript">
Calendar.setup({inputField:"careplan_Treatment_Plan_EffectiveDate",ifFormat:"%Y-%m-%d", button:"img_eff_date"});
</script>   
</td>
</tr>

     </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td scope="row" valign="top" width="25%">
        <input type="checkbox" name="careplan_Evaluation" id="careplan_Evaluation" 
        <?php if ($obj{"careplan_Evaluation"} == "on") echo "checked";;?>/>
<?php xl('Evaluation','e')?>
  </label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Home_Therapeutic_Exercises" id="careplan_Home_Therapeutic_Exercises" 
    <?php if ($obj{"careplan_Home_Therapeutic_Exercises"} == "on") echo "checked";;?>/>
    <?php xl('Home Therapeutic Exercises','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Gait_ReTraining" id="careplan_Gait_ReTraining" 
    <?php if ($obj{"careplan_Gait_ReTraining"} == "on") echo "checked";;?>/>
    </label>
  <?php xl('Gait Re-Training','e')?><br />
  <label>
    <input type="checkbox" name="careplan_Bed_Mobility_Training" id="careplan_Bed_Mobility_Training" 
    <?php if ($obj{"careplan_Bed_Mobility_Training"} == "on") echo "checked";;?>/>
   <?php xl(' Bed Mobility Training','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Transfer_Training"  id="careplan_Transfer_Training" 
    <?php if ($obj{"careplan_Transfer_Training"} == "on") echo "checked";;?>/>
    <?php xl('Transfer Training','e')?></label>
  <br />
  <label>
    <input type="checkbox" name="careplan_Balance_Training_Activities" id="careplan_Balance_Training_Activities" 
    <?php if ($obj{"careplan_Balance_Training_Activities"} == "on") echo "checked";;?>/>
    <?php xl('Balance Training/Activities','e')?></label>
  <br />
  <input type="checkbox" name="careplan_Patient_Caregiver_Family_Education" id="careplan_Patient_Caregiver_Family_Education" 
  <?php if ($obj{"careplan_Patient_Caregiver_Family_Education"} == "on") echo "checked";;?>/>
  <label for="checkbox2"><?php xl('Patient/Caregiver/Family Education','e')?></label></td>
        <td valign="top" width="35%"><label>
          <input type="checkbox" name="careplan_Assistive_Device_Training" id="careplan_Assistive_Device_Training" 
          <?php if ($obj{"careplan_Assistive_Device_Training"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Assistive Device Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Neuro_developmental_Training" id="careplan_Neuro_developmental_Training" 
            <?php if ($obj{"careplan_Neuro_developmental_Training"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Neuro-developmental Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Orthotics_Splinting" id="careplan_Orthotics_Splinting" 
            <?php if ($obj{"careplan_Orthotics_Splinting"} == "on") echo "checked";;?>/>
            <?php xl('Orthotics/Splinting','e')?></label>
          <br/>
          <label>
            <input type="checkbox" name="careplan_Hip_Safety_Precaution_Training" id="careplan_Hip_Safety_Precaution_Training" 
            <?php if ($obj{"careplan_Hip_Safety_Precaution_Training"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Hip Safety Precaution Training','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Physical_Agents" id="careplan_Physical_Agents" 
            <?php if ($obj{"careplan_Physical_Agents"} == "on") echo "checked";;?>/>
            <?php xl('Physical Agents','e')?></label>
          <strong>
          <input type="text" style="width:55%" name="careplan_Physical_Agents_Name" id="careplan_Physical_Agents_Name" 
         value="<?php echo stripslashes($obj{"careplan_Physical_Agents_Name"});?>" />
          </strong><br />
          &nbsp;  &nbsp;  &nbsp; <?php xl('for','e')?> <strong>
          <input type="text" style="width:83%" name="careplan_Physical_Agents_For" id="careplan_Physical_Agents_For" 
           value="<?php echo stripslashes($obj{"careplan_Physical_Agents_For"});?>" />
          </strong><br />
          <label>
            <input type="checkbox" name="careplan_Muscle_ReEducation" id="careplan_Muscle_ReEducation" 
            <?php if ($obj{"careplan_Muscle_ReEducation"} == "on") echo "checked";;?>/>
          <?php xl('Muscle Re-Education','e')?></label></td>
        <td valign="top" width="40%">
          <label>
            <input type="checkbox" name="careplan_Safe_Stair_Climbing_Skills" id="careplan_Safe_Stair_Climbing_Skills" 
            <?php if ($obj{"careplan_Safe_Stair_Climbing_Skills"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Safe Stair Climbing Skills','e')?><br />
          <label>
            <input type="checkbox" name="careplan_Exercises_to_manage_pain" id="careplan_Exercises_to_manage_pain" 
            <?php if ($obj{"careplan_Exercises_to_manage_pain"} == "on") echo "checked";;?>/>
            <?php xl('Exercises to manage pain','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Fall_Precautions_Training" id="careplan_Fall_Precautions_Training" 
            <?php if ($obj{"careplan_Fall_Precautions_Training"} == "on") echo "checked";;?>/>
</label>
<label>            <?php xl('Fall Precautions Training','e')?><br />

            <input type="checkbox" name="careplan_Exercises_Safety_Techniques_given_patient" id="careplan_Exercises_Safety_Techniques_given_patient" 
            <?php if ($obj{"careplan_Exercises_Safety_Techniques_given_patient"} == "on") echo "checked";;?>/>
            <?php xl('Exercises/ Safety Techniques given to patient','e')?> <br />
          </label>
          <label>          </label>
                  <?php xl('Other','e')?>
            <input type="text" style="width:85%" name="careplan_PT_Other" id="careplan_PT_Other" value="<?php echo stripslashes($obj{"careplan_PT_Other"});?>" />
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
<td scope="row"><table width="100%" border="2" class="formtable">
<tr><td colspan="6" valign="top">
<table width="100%" border="2" class="formtable">

<tr>
        <td width="40%" align="center" scope="row"><strong><?php xl('Short Term Outcomes','e')?> </strong>
         </td>
        <td width="10%" align="center"><strong><?php xl('Time','e')?></strong></td>
        <td width="40%" align="center" scope="row"><strong><?php xl('Short Term Outcomes','e')?> </strong>
          </td>
        <td width="10%" align="center"><strong><?php xl('Time','e')?></strong></td>
        </tr>
      <tr>
        <td valign="top" scope="row"><label>
          <input type="checkbox" name="careplan_STO_Improve_mobility_skills" id="careplan_STO_Improve_mobility_skills" 
           <?php if ($obj{"careplan_STO_Improve_mobility_skills"} == "on") echo "checked";;?>/>
          </label>
          <?php xl('Improve mobility skills in','e')?>
  <label for="textfield2"></label>
          <input type="text" name="careplan_STO_Improve_mobility_skills_In" id="careplan_STO_Improve_mobility_skills_In" 
         size="12"  value="<?php echo stripslashes($obj{"careplan_STO_Improve_mobility_skills_In"});?>" />
          <?php xl('to','e')?> 
  &nbsp; &nbsp; &nbsp;
   <input type="text" name="careplan_STO_Improve_mobility_skills_To" size="12" id="careplan_STO_Improve_mobility_skills_To" 
  value="<?php echo stripslashes($obj{"careplan_STO_Improve_mobility_skills_To"});?>" />
         <?php xl(' assist.','e')?></td>

<td  align="left" valign="center">
<input type="text" name="careplan_STO_Mobility_Skill_Time" size="10px"  id="careplan_STO_Mobility_Skill_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_STO_Mobility_Skill_Time"});?>"></td>

 <td>
        <?php xl('Other','e')?> &nbsp;
          <input size="55px" type="text" name="careplan_STO_Other" id="careplan_STO_Other" 
          value="<?php echo stripslashes($obj{"careplan_STO_Other"});?>" /></td>
        <td>
<input type="text" name="careplan_STO_Other_Time" size="10px" id="careplan_STO_Other_Time" value="<?php echo stripslashes($obj{"careplan_STO_Other_Time"});?>"?/></td>

</tr>
  <tr>
<td><label>
    <input type="checkbox" name="careplan_STO_Increase_ROM" id="careplan_STO_Increase_ROM" 
    <?php if ($obj{"careplan_STO_Increase_ROM"} == "on") echo "checked";;?>/>
    </label>
          <?php xl('Increase ROM of','e')?>          
          <label>
            <input type="checkbox" name="careplan_STO_Increase_ROM_Side" value="right" id="careplan_STO_Increase_ROM_Side" 
            <?php if ($obj{"careplan_STO_Increase_ROM_Side"} == "right") echo "checked";;?>/>
            <?php xl('right','e')?></label>
          <label>
            <input type="checkbox" name="careplan_STO_Increase_ROM_Side" value="left" id="careplan_STO_Increase_ROM_Side" 
            <?php if ($obj{"careplan_STO_Increase_ROM_Side"} == "left") echo "checked";;?>/>
            <?php xl('left','e')?></label> 
          <input type="text" name="careplan_STO_Increase_ROM_Note" id="careplan_STO_Increase_ROM_Note" 
	size="12" value="<?php echo stripslashes($obj{"careplan_STO_Increase_ROM_Note"});?>" />
          <?php xl('(joints) to','e')?>
          <input type="text" name="careplan_STO_Increase_ROM_To" id="careplan_STO_Increase_ROM_To" 
         size="12" value="<?php echo stripslashes($obj{"careplan_STO_Increase_ROM_To"});?>" />
          <?php xl('/WFL','e')?> 
</td>
<td  align="left" valign="center">
<input type="text" name="careplan_STO_ROM_Skill_Time" id="careplan_STO_ROM_Skill_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_STO_ROM_Skill_Time"});?>"></td>
       <td colspan="2"><strong><?php xl('Long Term Outcomes','e')?></strong></td>
      </tr>

<tr><td>
          <label>
            <input type="checkbox" name="careplan_STO_Increase_Strength" id="careplan_STO_Increase_Strength" 
            <?php if ($obj{"careplan_STO_Increase_Strength"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Increase Strength','e')?>          
          <label>
            <input type="checkbox" name="careplan_STO_Increase_Strength_Side" value="right" id="careplan_STO_Increase_Strength_Side" 
            <?php if ($obj{"careplan_STO_Increase_Strength_Side"} == "right") echo "checked";;?>/>
            <?php xl('right','e')?></label>
          <label>
            <input type="checkbox" name="careplan_STO_Increase_Strength_Side" value="left" id="careplan_STO_Increase_Strength_Side" 
            <?php if ($obj{"careplan_STO_Increase_Strength_Side"} == "left") echo "checked";;?>/>
            <?php xl('left','e')?></label> 
  			<input type="text" name="careplan_STO_Increase_Strength_Note" id="careplan_STO_Increase_Strength_Note" 
  	size="12" 	value="<?php echo stripslashes($obj{"careplan_STO_Increase_Strength_Note"});?>" />
          <?php xl('to','e')?>
          &nbsp; &nbsp; &nbsp;
          <label for="textfield3"></label>
          <input type="text" name="careplan_STO_Increase_Strength_To" id="careplan_STO_Increase_Strength_To" 
        size="12"  value="<?php echo stripslashes($obj{"careplan_STO_Increase_Strength_To"});?>" /> 
          <?php xl('/ 5','e')?>
          </td>
<td  align="left" valign="center">
<input type="text" name="careplan_STO_WFL_Time" id="careplan_STO_WFL_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_STO_WFL_Time"});?>"></td>

<td>
 <input type="checkbox" name="careplan_LTO_Return_prior_level_function" id="careplan_LTO_Return_prior_level_function" 
          <?php if ($obj{"careplan_LTO_Return_prior_level_function"} == "on") echo "checked";;?>/>
          <?php xl('Return to prior level of function in','e')?></label><label>
            <input type="text" name="careplan_LTO_Return_prior_level_function_In" id="careplan_LTO_Return_prior_level_function_In" 
	style="width:37%"  value="<?php echo stripslashes($obj{"careplan_LTO_Return_prior_level_function_In"});?>" />

</td>

<td  align="left" valign="center">
<input type="text" name="careplan_LTO_Return_prior_level_function_Time" id="careplan_LTO_Return_prior_level_function_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_LTO_Return_prior_level_function_Time"});?>"></td>


</tr>
<tr><td>
            <input type="checkbox" name="careplan_STO_Exercises_using_written_handout" id="careplan_STO_Exercises_using_written_handout" 
             <?php if ($obj{"careplan_STO_Exercises_using_written_handout"} == "on") echo "checked";;?>/>
            </label>
          <?php xl('Exercises using written handout with','e')?>         
          <input type="text" name="careplan_STO_Exercises_using_written_handout_With" id="careplan_STO_Exercises_using_written_handout_With" 
      size="12"  value="<?php echo stripslashes($obj{"careplan_STO_Exercises_using_written_handout_With"});?>" />
          <?php xl('verbal/physical prompts','e')?>
         </td>
<td  align="left" valign="center">
<input type="text" name="careplan_STO_Excercise_Time" id="careplan_STO_Excercise_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_STO_Excercise_Time"});?>"></td>
<td> 
  <input type="checkbox" name="careplan_LTO_Demonstrate_ability_follow_home_exercise" id="careplan_LTO_Demonstrate_ability_follow_home_exercise" 
          <?php if ($obj{"careplan_LTO_Demonstrate_ability_follow_home_exercise"} == "on") echo "checked";;?>/>
          <?php xl('Demonstrate ability to follow home exercise program','e')?>
</td>

<td  align="left" valign="center">
<input type="text" name="careplan_LTO_Demonstrate_ability_follow_home_exercise_Time" id="careplan_LTO_Demonstrate_ability_follow_home_exercise_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_LTO_Demonstrate_ability_follow_home_exercise_Time"});?>"></td>


</tr>
<tr><td>    <input type="checkbox" name="careplan_STO_Improve_home_safety_techniques" id="careplan_STO_Improve_home_safety_techniques" 
    <?php if ($obj{"careplan_STO_Improve_home_safety_techniques"} == "on") echo "checked";;?>/>
    <?php xl('Improve home safety techniques in','e')?></label>
         <input type="text" name="careplan_STO_Improve_home_safety_techniques_In" id="careplan_STO_Improve_home_safety_techniques_In" 
      size="12" value="<?php echo stripslashes($obj{"careplan_STO_Improve_home_safety_techniques_In"});?>" />
          <?php xl('to','e')?>
          &nbsp; &nbsp; &nbsp;
          <input type="text" name="careplan_STO_Improve_home_safety_techniques_To" id="careplan_STO_Improve_home_safety_techniques_To" 
     size="12" value="<?php echo stripslashes($obj{"careplan_STO_Improve_home_safety_techniques_To"});?>" />
          <?php xl('assist.','e')?>        
</td>
<td  align="left" valign="center">
<input type="text" name="careplan_STO_Safety_Techniques_Time" id="careplan_STO_Safety_Techniques_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_STO_Safety_Techniques_Time"});?>"></td>

<td>
<input type="checkbox" name="careplan_LTO_Improve_mobility" id="careplan_LTO_Improve_mobility" 
            <?php if ($obj{"careplan_LTO_Improve_mobility"} == "on") echo "checked";;?>/>
          <?php xl('Improve mobility in','e')?>
<input type="checkbox" name="careplan_LTO_Improve_mobility_Type" value="home" id="careplan_LTO_Improve_mobility_Type" 
            <?php if ($obj{"careplan_LTO_Improve_mobility_Type"} == "home") echo "checked";;?>/>
           <?php xl('home','e')?>
          
            <input type="checkbox" name="careplan_LTO_Improve_mobility_Type" value="community" id="careplan_LTO_Improve_mobility_Type" 
            <?php if ($obj{"careplan_LTO_Improve_mobility_Type"} == "community") echo "checked";;?>/>          
            <?php xl('community','e')?>
</td>

<td  align="left" valign="center">
<input type="text" name="careplan_LTO_Improve_mobility_Time" id="careplan_LTO_Improve_mobility_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_LTO_Improve_mobility_Time"});?>"></td>

</tr>
        
<tr> <td>
    <input type="checkbox" name="careplan_STO_Demonstrate_independent_use_of_prosthesis" id="careplan_STO_Demonstrate_independent_use_of_prosthesis" 
    <?php if ($obj{"careplan_STO_Demonstrate_independent_use_of_prosthesis"} == "on") echo "checked";;?>/>
    <?php xl('Demonstrate independent use of prosthesis/brace/splint','e')?> </td>
<td  align="left" valign="center">
<input type="text" name="careplan_STO_Independant_Use_Of_Prosthesis_Time" id="careplan_STO_Independant_Use_Of_Prosthesis_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_STO_Independant_Use_Of_Prosthesis_Time"});?>"></td>

<td>
<input type="checkbox" name="careplan_LTO_Improve_independence_safety_home" id="careplan_LTO_Improve_independence_safety_home" 
                 <?php if ($obj{"careplan_LTO_Improve_independence_safety_home"} == "on") echo "checked";;?>/> 
          <?php xl('Improve independence in safety in home','e')?>
</td>
<td  align="left" valign="center">
<input type="text" name="careplan_LTO_Improve_independence_safety_home_Time" id="careplan_LTO_Improve_independence_safety_home_Time" size="10px"
value="<?php echo stripslashes($obj{"careplan_LTO_Improve_independence_safety_home_Time"});?>"></td>

         </tr>
          
      <tr>
<td>&nbsp; </td> <td>&nbsp;  </td>
<td>
         <?php xl(' Other','e')?> &nbsp;
         <input type="text" name="careplan_LTO_Other" id="careplan_LTO_Other" 
       size="55px" value="<?php echo stripslashes($obj{"careplan_LTO_Other"});?>" /></td>
        <td>
        <input type="text"  name="careplan_LTO_Other_Time" size="10px" id="careplan_LTO_Other_Time" value="<?php echo stripslashes($obj{"careplan_LTO_Other_Time"});?>"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">



<tr>        
        <td><strong><?php xl('ADDITIONAL  COMMENTS','e')?></strong>
<input type="text" name="careplan_Additional_comments" id="careplan_Additional_comments" style="width:95%" value="<?php echo stripslashes($obj{"careplan_Additional_comments"});?>"/> </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>

        <td scope="row" width="40%" ><strong><?php xl('Rehab Potential','e')?></strong>
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Excellent" id="careplan_Rehab_Potential" 
            <?php if ($obj{"careplan_Rehab_Potential"} == "Excellent") echo "checked";;?>/>
            <?php xl('Excellent','e')?></label>
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Good" id="careplan_Rehab_Potential" 
            <?php if ($obj{"careplan_Rehab_Potential"} == "Good") echo "checked";;?>/>
            <?php xl('Good','e')?></label>
          <label>
<br/>            <input type="checkbox" name="careplan_Rehab_Potential" value="Fair" id="careplan_Rehab_Potential" 
            <?php if ($obj{"careplan_Rehab_Potential"} == "Fair") echo "checked";;?>/>
            <?php xl('Fair','e')?></label>
          <label>
            <input type="checkbox" name="careplan_Rehab_Potential" value="Poor" id="careplan_Rehab_Potential" 
            <?php if ($obj{"careplan_Rehab_Potential"} == "Poor") echo "checked";;?>/>
          <?php xl('Poor','e')?></label></td>
        <td width="10%" ><strong><?php xl('Discharge Plan','e')?></strong></td>
        <td width="50%" ><input type="checkbox" name="careplan_DP_When_Goals_Are_Met" id="careplan_DP_When_Goals_Are_Met"   <?php if ($obj{"careplan_DP_When_Goals_Are_Met"} == "on") echo "checked";;?>/>
		<?php xl('When Goals Are Met','e')?>
	<br/>	<?php xl('Other','e')?> 
      <input type="text" name="careplan_DP_Other" id="careplan_DP_Other" 
      value="<?php echo stripslashes($obj{"careplan_DP_Other"});?>" style="width:80%"  /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td scope="row"><strong>
        <?php xl('PT Care Plan and Discharge was communicated to and agreed upon by','e')?> </strong>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Patient" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Patient") echo "checked";;?>/>
           <?php xl(' Patient','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Physician" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Physician") echo "checked";;?>/>
            <?php xl('Physician','e')?></label>
<br/>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="PT/OT/ST" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "PT/OT/ST") echo "checked";;?>/>
            <?php xl('PT/OT/ST','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="COTA" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "COTA") echo "checked";;?>/>
            <?php xl('PTA','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Skilled Nursing" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Skilled Nursing") echo "checked";;?>/>
            <?php xl('Skilled Nursing','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Caregiver/Family" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Caregiver/Family") echo "checked";;?>/>
            <?php xl('Caregiver/Family','e')?></label>
          <label>
            <input type="checkbox" name="careplan_PT_communicated_and_agreed_upon_by" value="Case Manager" id="careplan_PT_communicated_and_agreed_upon_by" 
             <?php if ($obj{"careplan_PT_communicated_and_agreed_upon_by"} == "Case Manager") echo "checked";;?>/>
            <?php xl('Case Manager','e')?><br />
            <?php xl('Other','e')?></label>

          <input type="text" name="careplan_PT_communicated_and_agreed_upon_Other" id="careplan_PT_communicated_and_agreed_upon_Other" 
style="width:90%"  value="<?php echo stripslashes($obj{"careplan_PT_communicated_and_agreed_upon_Other"});?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="0" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td scope="row"><strong>
        <?php xl('Patient/Caregiver/Family Response to Care Plan and Physical Therapy','e')?></strong></td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="50%" scope="row"><label>
          <input type="checkbox" name="careplan_Agreeable_to_general_goals" id="careplan_Agreeable_to_general_goals" 
           <?php if ($obj{"careplan_Agreeable_to_general_goals"} == "on") echo "checked";;?>/>
          <?php xl('Agreeable to general goals and treatment plan','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Highly_motivated_to_improve" id="careplan_Highly_motivated_to_improve" 
             <?php if ($obj{"careplan_Highly_motivated_to_improve"} == "on") echo "checked";;?>/>
            <?php xl('Highly motivated to improve','e')?></label>
          <br />
          <label>
            <input type="checkbox" name="careplan_Supportive_family_caregiver" id="careplan_Supportive_family_caregiver" 
             <?php if ($obj{"careplan_Supportive_family_caregiver"} == "on") echo "checked";;?>/>
          <?php xl('Supportive family/caregiver likely to increase success','e')?></label></td>

        <td width="50%" rowspan="2">
        <input type="checkbox" name="careplan_May_require_additional_treatment" id="careplan_May_require_additional_treatment" 
         <?php if ($obj{"careplan_May_require_additional_treatment"} == "on") echo "checked";;?>/>
          <label for="checkbox"></label>
		<?php xl('May require additional treatment session  to achieve Long Term Outcomes due to','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
 value="Short Term Memory" <?php if ($obj{"careplan_May_require_additional_treatment_dueto"} == "Short Term Memory") echo "checked";;?>/>
<?php xl('short term memory difficulties','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
 value="Minimum support" <?php if ($obj{"careplan_May_require_additional_treatment_dueto"} == "Minimum support") echo "checked";;?>/>
<?php xl('minimal support systems','e')?>
<input type="checkbox" name="careplan_May_require_additional_treatment_dueto" id="careplan_May_require_additional_treatment_dueto" 
 value="Language Barrier" <?php if ($obj{"careplan_May_require_additional_treatment_dueto"} == "Language Barrier") echo "checked";;?>/>
<?php xl('communication, language  barriers','e')?><br />
<input type="checkbox" name="careplan_Will_address_above_issues" id="careplan_Will_address_above_issues" 
 <?php if ($obj{"careplan_Will_address_above_issues"} == "on") echo "checked";;?>/>
       <?php xl(' Will address above issues by','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
   value="Written Directions" <?php if ($obj{"careplan_Will_address_above_issues_by"} == "Written Directions") echo "checked";;?>/>
        <?php xl('Providing written directions  and/or physical demonstration','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
   value="Community Support" <?php if ($obj{"careplan_Will_address_above_issues_by"} == "Community Support") echo "checked";;?>/>
        <?php xl('establish community  support systems','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
   value="Home Adaptations" <?php if ($obj{"careplan_Will_address_above_issues_by"} == "Home Adaptations") echo "checked";;?>/>
        <?php xl('home/environmental adaptations','e')?>
  <input type="checkbox" name="careplan_Will_address_above_issues_by" id="careplan_Will_address_above_issues_by" 
   value="Use Family" <?php if ($obj{"careplan_Will_address_above_issues_by"} == "Use Family") echo "checked";;?>/>
       <?php xl(' use family/professionals for interpretations as needed','e')?>
	<br/><?php xl('Other','e')?>
          <input type="text" name="careplan_Physician_Orders_Other" id="careplan_Physician_Orders_Other" 
           style="width:80%" value="<?php echo stripslashes($obj{"careplan_Physician_Orders_Other"});?>" />   </td>
      </tr>
      <tr>
      <td><strong><?php xl('Physician Orders','e')?> </strong>

        <input type="checkbox" name="careplan_Physician_Orders" id="careplan_Physician_Orders" 
   value="Orders Obtained"  <?php if ($obj{"careplan_Physician_Orders"} == "Orders Obtained") echo "checked";;?>/>
        <label for="Physician Orders Obtained"><?php xl('Physician Orders Obtained','e')?></label>
        <br />
  <input type="checkbox" name="careplan_Physician_Orders" id="careplan_Physician_Orders" 
value="Orders Needed"  <?php if ($obj{"careplan_Physician_Orders"} == "Orders Needed") echo "checked";;?>/>
        <label for="Physician orders needed"><?php xl('Physician orders needed','e')?></label>
        . <strong><?php xl('Will follow agency&rsquo;s procedures for obtaining verbal orders and completing the 485/POC or submitting  supplemental orders for physician signature','e')?></strong></td>

      </tr>
    </table></td>
  
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1" cellpadding="5px" cellspacing="0px" class="formtable">
      <tr>
        <td width="50%" scope="row"><strong><?php xl('Therapist Who Developed POC','e')?> </strong>(Name and Title)
          </td>
        <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td>

      </tr>
    </table></td>
  </tr>
  
</table>
<a href="javascript:top.restoreSession();document.careplan.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
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
