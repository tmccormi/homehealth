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
$formTable = "forms_ot_careplan";

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
	    	 if(Dx=='med_dx_icd9')
	    	 {
		    	med_icd9.innerHTML= result['res'];
	    	 }
	    	 if(Dx=="trmnt_dx_icd9")
	    	 {
	    		 trmnt_icd9.innerHTML= result['res'];
	    	 }
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/careplan/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	  $(document).ready(function() {
        var status = "";
        
	$("#signoff").fancybox({
	'scrolling'		: 'no',
	'titleShow'		: false,
	'onClosed'		: function() {
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
$obj = formFetch("forms_ot_careplan", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>
<form method=post action="<?php echo $rootdir?>/forms/careplan/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="careplan">
<h3 align="center"><?php xl('OCCUPATIONAL THERAPY CARE PLAN','e')?></h3>
                <h5 align="center">
                <?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
                </h5>
 <br><br/>
<table width="100%" border="1" cellpadding="2px" class="formtable">
<tr> <td> </td></tr>
  <tr>
    <td width="13%" align="center" valign="top" scope="row">
    <strong><?php xl('PATIENT NAME','e')?></strong></td>
    <td width="13%" align="center" valign="top"> 
    <input type="text" id="patient_name" value="<?php patientName()?>" readonly /></td>
    <td width="20%" align="center" valign="top">
    <strong><?php xl('MR#','e')?></strong></td>
    <td width="15%" align="center" valign="top" class="bold" >
    <input type="text" name="mr" id="mr" value="<?php  echo $_SESSION['pid']?>" readonly/> </td>
    <td width="22%" align="center" valign="top"><strong>DATE</strong></td>
    <td width="17%" align="center" valign="top" class="bold">
      <input type='text' size='10' name='date_curr' id='date_curr'
    value="<?php echo stripslashes($obj{"date_curr"});?>"
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly />
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_curr_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"date_curr", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>   
    </td>

  </tr>
  
<tr>
<td width="20%" align="left" valign="top" scope="row"><strong><?php xl('Med Dx/ Reason for OT intervention','e')?></strong></td>
<td width="30%" colspan="2" align="left" valign="top" class="bold">
<input type="text" id="med_dx_icd9" name="med_dx_icd9" style="width:100%;" value="<?php echo stripslashes($obj{'med_dx_icd9'}); ?>" />
</td>

<td width="20%" align="left" valign="top" class="bold"><?php xl('Treatment Dx','e')?></td>
<td width="30%" colspan="2" align="left" valign="top" class="bold">
<input type="text" id="trmnt_dx_icd9" name="trmnt_dx_icd9" style="width:100%;" value="<?php echo stripslashes($obj{'trmnt_dx_icd9'}); ?>" />
</td>
</tr>

  <tr>
    <td colspan="3" valign="top" scope="row"><strong>
    <?php xl('PROBLEMS REQUIRING OT INTERVENTION','e')?></strong></td>
    <td valign="top"><strong><?php xl('SOC Date','e')?></strong></td>
    <td colspan="2" valign="top">
 <input type='text' size='10' name='SOC_Date' id='SOC_Date' 
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'
					 value="<?php echo stripslashes($obj{"SOC_Date"});?>" readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='soc_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"SOC_Date", ifFormat:"%Y-%m-%d", button:"soc_date"});
   </script>

</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" scope="row">
      <table width="100%" border="0" cellpadding="2px" class="formtable">

      <tr>
        <td scope="row"><table width="100%" border="0" cellpadding="2px" class="formtable">
          <tr>
            <td valign="top" scope="row"><label>
              <input type="checkbox" name="adl_skills" id="adl_skills" <?php if ($obj{"adl_skills"} == "on")
				echo "checked";;?>>
              <?php xl('Decline in ADL skills','e')?></label>
              <br /></td>
            <td valign="top">
            <input name="adl_skills_text" style="width:180px" id="adl_skills_text" type="text"  value="<?php echo stripslashes($obj{"adl_skills_text"});?>" >

              &nbsp;</td>
          </tr>
          <tr>
            <td valign="top" scope="row"><label>
              <input type="checkbox" name="dec_rom" id="dec_rom" <?php if ($obj{"dec_rom"} == "on")
echo "checked";;?>>
            </label>
              <?php xl('Decrease in ROM in','e')?> </td>
            <td valign="top"><label for="ROM in2"></label>
              <input type="text" style="width:180px" name="dec_rom_txt" id="dec_rom_txt" value="<?php echo $obj{"dec_rom_txt"};?>" ></td>
          </tr>
          <tr>
            <td valign="top" scope="row"><label>
              <input type="checkbox" name="iadl_skills" id="iadl_skills" <?php if ($obj{"iadl_skills"} == "on")
echo "checked";;?>>
            </label>
              <?php xl('Decline in IADL skills','e')?> </td>
            <td valign="top"><label for="IADL skills"></label>
              <input type="text" style="width:180px" name="iadl_skills_txt" id="iadl_skills_txt" value="<?php echo stripslashes($obj{"iadl_skills_txt"});?>" ></td>
          </tr>
          <tr>
            <td valign="top" scope="row"><label>
              <input type="checkbox" name="dec_mobility" id="dec_mobility" <?php if ($obj{"dec_mobility"} == "on")
echo "checked";;?>> 
              <?php xl('Decline in Functional Mobility in','e')?></label></td>
            <td valign="top"><label for="Mobility in"></label>
              <input type="text" style="width:180px" name="mobility_in" id="mobility_in" value="<?php echo stripslashes($obj{"mobility_in"});?>" >
</td>
          </tr>
        </table>        </tr>
      </table>
    <td colspan="3" valign="top"><table width="100%" border="0" cellpadding="2px" class="formtable">
      <tr>
        <td colspan="2" valign="top" scope="row">
          <input type="checkbox" name="dec_safety_tech" id="dec_safety_tech" <?php if ($obj{"dec_safety_tech"} == "on")
echo "checked";;?>>
          <label for="Decreased Safety Techniques in">
          <?php xl('Decreased Safety Techniques in','e')?></label> 
          <label for="techniques in others"></label>
            <input type="text" style="width:240px" name="safety_tech_txt" id="safety_tech_txt" value="<?php echo stripslashes($obj{"safety_tech_txt"});?>" >
        
      </tr>
      <tr>
        <td valign="top" scope="row"><?php xl('Other','e')?></td>
        <td valign="top">
          <label for="soc date_other_1"></label>
          <input type="text" style="width:60%" name="safety_tech_others1" id="safety_tech_others1"  value="<?php echo stripslashes($obj{"safety_tech_others1"});?>" >
        </td>
      </tr>
      <tr>
        <td valign="top" scope="row"><?php xl('Other','e')?></td>
        <td valign="top">
          <label for="soc date_other_2"></label>
          <input type="text" style="width:60%" name="safety_tech_others2" id="safety_tech_others2" value="<?php echo stripslashes($obj{"safety_tech_others2"});?>" >
</td> 
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6">
    <table width="100%" class="formtable">

<tr>
<td colspan="2" valign="top" scope="row"><strong><?php xl('TREATMENT PLAN FREQUENCY','e')?></strong><br></td>
<tr>
<td>
<?php xl('Frequency & Duration: ','e')?>&nbsp;
<input type="text" name="frequency" id="frequency" style="width:100%;" value="<?php echo stripslashes($obj{"frequency"});?>"/>
<br />
<?php xl('Effective Date: ','e')?>
<input type="text" name="effective_date" id="effective_date" size="12" value="<?php echo stripslashes($obj{"effective_date"});?>"  readonly>

<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_eff_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand' title='<?php xl('Click here to choose a date','e'); ?>'>

<script LANGUAGE="JavaScript">
Calendar.setup({inputField:"effective_date", ifFormat:"%Y-%m-%d", button:"img_eff_date"});
</script>
</td>        
</tr>

    </table>
    </td>
  </tr>
  <tr>
    <td colspan="6" valign="top" scope="row"><strong>
    <?php xl('Information such as  frequency, duration and effective date sh','e')?></strong><strong>ould be linked to a physician order due report.</strong>
      </td>
  </tr>
  <tr>
    <td colspan="2" valign="middle" scope="row">    
<label>
     <input type="checkbox" name="evaluation" id="evaluation" <?php if ($obj{"evaluation"} == "on")
echo "checked";;?>>
      <?php xl('Evaluation','e')?></label>
      <br />
      <label>
        <input type="checkbox" name="home_safety" id="home_safety" <?php if ($obj{"home_safety"} == "on")
echo "checked";;?>>
       <?php xl('Home Safety Assessment','e')?></label>
      <br />
      <label>
        <input type="checkbox" name="adl_training" id="adl_training" <?php if ($obj{"adl_training"} == "on")
echo "checked";;?>>
        <?php xl('Self Care ADL Training','e')?></label>
      <br />
      <label>
        <input type="checkbox" name="iadl_training" id="iadl_training" <?php if ($obj{"iadl_training"} == "on")
echo "checked";;?>>
       <?php xl(' IADL Training','e')?></label>
      <br />
      <label>
        <input type="checkbox" name="visual_comp" id="visual_comp" <?php if ($obj{"visual_comp"} == "on")
echo "checked";;?>>
        <?php xl('Visual/Perceptual Compensatory','e')?></label>
      <br />
      <label>
        <input type="checkbox" name="energy_copd" id="energy_copd" <?php if ($obj{"energy_copd"} == "on")
echo "checked";;?>>
    <?php xl('Energy Conservation for COPD/CHF','e')?></label></td>
    <td colspan="2" valign="top">
      <p>
        <label>
          <input type="checkbox" name="orthotics_mgmt" id="orthotics_mgmt" <?php if ($obj{"orthotics_mgmt"} == "on")
echo "checked";;?>>
          <?php xl('Orthotics/Splinting Management','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="adaptive_equipment" id="adaptive_equipment"  <?php if ($obj{"adaptive_equipment"} == "on")
echo "checked";;?>>
          <?php xl('Adaptive Equipment Training','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="cognitive_comp" id="cognitive_comp" <?php if ($obj{"cognitive_comp"} == "on")
echo "checked";;?>>
          <?php xl('Cognitive Compensatory Skills','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="homeue_exercise" id="homeue_exercise " <?php if ($obj{"homeue_exercise"} == "on")
echo "checked";;?>>
          <?php xl('Home UE Exercise Program','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="patient_education" id="patient_education" <?php if ($obj{"patient_education"} == "on")
echo "checked";;?>>
          <?php xl('Patient/Caregiver/Family Education','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="fine_compensatory" id="fine_compensatory" <?php if ($obj{"fine_compensatory"} == "on")
echo "checked";;?>>
         <?php xl(' Fine/Gross Motor Compensatory','e')?></label>
        <br />
      </p>
    </td>
    <td colspan="2" valign="top">
      <p>
        <label>
          <input type="checkbox" name="educate_safety" id="educate_safety" <?php if ($obj{"educate_safety"} == "on")
echo "checked";;?>>
          <?php xl('Educate Home/Fall Safety','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="teach_bathing_skills" id="teach_bathing_skills" <?php if ($obj{"teach_bathing_skills"} == "on")
echo "checked";;?>>
         <?php xl(' Teach compensatory bathing, skills','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="exercises_to_patient" id="exercises_to_patient" <?php if ($obj{"exercises_to_patient"} == "on")
echo "checked";;?>>
         <?php xl(' Exercises/ Safety Techniques given to patient','e')?></label>
        </p>
      <p> <?php xl(' Other','e')?>
        <label for="0checkbox_3_ther"></label>
        <input type="text" name="exercises_others" id="exercises_others" value="<?php echo stripslashes($obj{"exercises_others"});?>" style="width:300px">
      </p>
      <p><br />
      </p>
    </td>
  </tr>

  <tr>
    <td colspan="6" valign="top">
	
	<table width="100%" border="2" class="formtable">
						<tr>
							<td width="40%" align="cenetr" scope="row"><strong><?php xl('Short Term Outcomes','e')?>
							</strong>
							</td>
							<td width="10%" align="center"><strong><?php xl('Time','e')?> </strong></td>
							<td width="40%"><strong><?php xl('Short Term Outcomes','e')?></strong></td>
							<td width="10%" align="center"><strong><?php xl('Time','e')?> </strong></td>
						</tr>
							
						
	<tr>
	<td valign="top" scope="row"><label>
		<input type="checkbox" name="imp_adl_skills" id="imp_adl_skills" <?php if ($obj{"imp_adl_skills"} == "on") echo "checked";;?>>
	</label><?php xl('Improve ADL skills in','e')?>           
	<input type="text" size="12" name="imp_adl_skills_in" id="imp_adl_skills_in" value="<?php echo stripslashes($obj{"imp_adl_skills_in"});?>" >
	<?php xl('to','e')?> 
	<input type="text" size="12" name="imp_adl_skills_to" id="imp_adl_skills_to" value="<?php echo stripslashes($obj{"imp_adl_skills_to"});?>" >
    <?php xl('assist.','e')?>
	</td>
										<td  align="left" valign="center">
											<input type="text" name="shortterm_time" id="shortterm_time" size="10px" value="<?php echo stripslashes($obj{"shortterm_time"});?>">
										</td>
										<td scope="row">
										<?php xl('Other','e')?><input type="text" style="width:60%" name="time_others1" id="time_others1" value="<?php echo stripslashes($obj{"time_others1"});?>" />
										<br>
										<?php xl('Other','e')?><input type="text" style="width:60%" name="time_others2" id="time_others2" value="<?php echo stripslashes($obj{"time_others2"});?>" />
										</td>
										<td  align="left" valign="center">
											<input type="text" name="shortterm_time6" id="shortterm_time6" size="10px" value="<?php echo stripslashes($obj{"shortterm_time6"});?>">
<br/>											<input type="text" name="shortterm_time7" id="shortterm_time7" size="10px" value="<?php echo stripslashes($obj{"shortterm_time7"});?>">
										</td>
									</tr>
									
									<tr>
										<td valign="top" scope="row"><label>
										<input type="checkbox" name="imp_iadl_skills" id="imp_iadl_skills" <?php if ($obj{"imp_iadl_skills"} == "on")
      echo "checked";;?>> 
         <?php xl(' Improve IADL skills in','e')?></label>
          <input type="text" size="12" name="imp_iadl_skills_in" id="imp_iadl_skills_in" value="<?php echo stripslashes($obj{"imp_iadl_skills_in"});?>" >
          <?php xl('to','e')?>
          <input type="text" size="12" name="imp_iadl_skills_to" id="imp_iadl_skills_to" value="<?php echo stripslashes($obj{"imp_iadl_skills_to"});?>" >         
        <?php xl('assist.','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time1" id="shortterm_time1" size="10px" value="<?php echo stripslashes($obj{"shortterm_time1"});?>">
										</td>
										<td align="left" colspan="2">
										    <strong><?php xl('Long Term Outcomes ','e')?></strong>
										</td>
										<td></td>
										
									</tr>
									
									
									<tr>
										<td valign="top" scope="row"><label> 
										<input type="checkbox" name="wfl_Increase" id="wfl_Increase" <?php if ($obj{"wfl_Increase"} == "on")
      echo "checked";;?> > 
          <?php xl('Increase','e')?></label>             
              <input type="checkbox" name="wfl_details" id="wfl_details" <?php if ($obj{"wfl_details"} == "strength")
      echo "checked";;?> value="strength"> 
              <label><?php xl('Strength','e')?></label> 
            <label>
              <input type="checkbox" name="wfl_details" id="wfl_details" <?php if ($obj{"wfl_details"} == "ROMof")
      echo "checked";;?> value="ROMof"> 
              <?php xl('ROM of','e')?></label> 
            <label>
              <input type="checkbox" name="wfl_details" id="wfl_details" <?php if ($obj{"wfl_details"} == "right")
      echo "checked";;?> value="right"> 
              <?php xl('right','e')?></label> 
            <label>
              <input type="checkbox" name="wfl_details" id="wfl_details" <?php if ($obj{"wfl_details"} == "left")
      echo "checked";;?> value="left"> 
              <?php xl('left','e')?></label> 
            
          <input type="text" size="12" name="increase_to" id="increase_to" value="<?php echo stripslashes($obj{"increase_to"});?>" >  
          <?php xl('to WFL','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time2" id="shortterm_time2" size="10px" value="<?php echo stripslashes($obj{"shortterm_time2"});?>">
										</td>
										<td>
										<label>               
										<input type="checkbox" name="return_to_priorlevel" id="return_to_priorlevel" <?php if ($obj{"return_to_priorlevel"} == "on")
echo "checked";;?>>						<?php xl('Return to prior level of function in','e')?>
										</label>
										<input type="text" name="return_priorlevel_in" id="return_priorlevel_in" style="width:200px" value="<?php echo stripslashes($obj{"return_priorlevel_in"});?>">
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time" id="longterm_time" size="10px" value="<?php echo stripslashes($obj{"longterm_time"});?>">
										</td>
					
										
									</tr>
									<tr>
										<td valign="top" scope="row"><label> 
										<input type="checkbox" name="perform" id="perform" <?php if ($obj{"perform"} == "on")
echo "checked";;?>>
          <?php xl('Perform','e')?></label>
          <input type="text" size="12" name="exercise_type" id="exercise_type" value="<?php echo stripslashes($obj{"exercise_type"});?>" >
          <?php xl('Exercises using written handout  with','e')?>     
          <input type="text" size="12" name="exercise_prompts" id="exercise_prompts" value="<?php echo stripslashes($obj{"exercise_prompts"});?>" >
          <?php xl('verbal/physical prompts','e')?>
		  
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time3" id="shortterm_time3" size="10px" value="<?php echo stripslashes($obj{"shortterm_time3"});?>">
										</td>
										<td><label>
											<input type="checkbox" name="home_exercise" id="home_exercise" <?php if ($obj{"home_exercise"} == "on")
echo "checked";;?>> 
											<?php xl('Demonstrate ability to follow home exercise program','e')?></label>
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time1" id="longterm_time1" size="10px" value="<?php echo stripslashes($obj{"longterm_time1"});?>">
										</td>								
									</tr>
									
									
									<tr>
										<td valign="top" scope="row"><label> 
										<input type="checkbox" name="improve_safety" id="improve_safety" <?php if ($obj{"improve_safety"} == "on")
echo "checked";;?>>
          <?php xl('Improve safety techniques in','e')?></label>
          <input type="text" size="12" name="safety_technique_in" id="safety_technique_in" value="<?php echo stripslashes($obj{"safety_technique_in"});?>" >
          <?php xl('to','e')?>
          <input type="text" size="12" name="safety_technique_to" id="safety_technique_to" value="<?php echo stripslashes($obj{"safety_technique_to"});?>" >
          <?php xl('assist.','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time4" id="shortterm_time4" size="10px" value="<?php echo stripslashes($obj{"shortterm_time4"});?>">
										</td>
										<td width="60%" scope="row">
											<label><input type="checkbox" name="safety_at_home" id="safety_at_home" <?php if ($obj{"safety_at_home"} == "on")
echo "checked";;?>>
											<?php xl('Improve independence in safety awareness in home','e')?>
											</label>
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time2" id="longterm_time2" size="10px" value="<?php echo stripslashes($obj{"longterm_time2"});?>">
										</td>
									</tr>
									
									<tr>
										<td scope="row"><br /> <label> 
										<input type="checkbox" name="improve_mobility" id="improve_mobility" <?php if ($obj{"improve_mobility"} == "on")
echo "checked";;?>>
            <?php xl('Improve functional mobility in','e')?></label>
            <input type="text" size="12" name="improve_mobility_in" id="improve_mobility_in" value="<?php echo stripslashes($obj{"improve_mobility_in"});?>" >
          <?php xl('to','e')?>
          <input type="text" name="improve_mobility_to" id="improve_mobility_to" value="<?php echo stripslashes($obj{"improve_mobility_to"});?>" size="12" >
            <?php xl('assist.','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time5" id="shortterm_time5" size="10px" value="<?php echo stripslashes($obj{"shortterm_time5"});?>">
										</td>
										<td scope="row"><label>
											<input type="checkbox" name="envrn_changes_home"  id="envrn_changes_home" <?php if ($obj{"envrn_changes_home"} == "on")
echo "checked";;?>>
											<?php xl('Implement environmental changes in home to improve safety','e')?></label>
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time3" id="longterm_time3" size="10px" value="<?php echo stripslashes($obj{"longterm_time3"});?>">
										</td>
									</tr>
									
									<tr>
										<td >&nbsp;</td>
										<td>&nbsp;</td>
										<td scope="row"><?php xl('Other','e')?>
											<input type="text" style="width:60%" name="time_others3" id="time_others3" value="<?php echo stripslashes($obj{"time_others3"});?>"/>
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time4" id="longterm_time4" size="10px" value="<?php echo stripslashes($obj{"longterm_time4"});?>">
										</td>
									</tr>
							
							
									
					</table>
	
    
	</td>
    </td>
  </tr>
  <tr>
    <td colspan="6" valign="top" scope="row"><p>
    <strong><?php xl('ADDITIONAL COMMENTS','e')?>
    </strong>
	<input type="text" style="width:760px" name="additional_comments_text" id="additional_comments_text" value="<?php echo stripslashes($obj{"additional_comments_text"});?>" />
	</p></tr>
  <tr>
    <th colspan="3" align="left" valign="middle" scope="row">
    <strong><?php xl('Rehab Potential','e')?></strong>
      <label>
        <input type="checkbox" name="rehabpotential" id="rehabpotential" <?php if ($obj{"rehabpotential"} == "exlnt")
echo "checked";;?> value="exlnt">
        <?php xl('Excellent','e')?></label>
      <label>
        <input type="checkbox" name="rehabpotential" id="rehabpotential" <?php if ($obj{"rehabpotential"} == "good")
echo "checked";;?> value="good">
        <?php xl('Good','e')?></label>
      <label>
        <input type="checkbox" name="rehabpotential" id="rehabpotential" <?php if ($obj{"rehabpotential"} == "fair")
echo "checked";;?> value="fair">
        <?php xl('Fair','e')?></label>
      <label>
        <input type="checkbox" name="rehabpotential" id="rehabpotential" <?php if ($obj{"rehabpotential"} == "poor")
echo "checked";;?> value="poor">
        <?php xl('Poor','e')?></label>
      <br/></th>
    <td align="center" valign="middle"><strong><?php xl('Discharge Plan','e')?></strong></td>

    <td align="left" valign="middle">
      <label>
        <input type="checkbox" name="rehabpotential_goals_met" id="rehabpotential_goals_met" <?php if ($obj{"rehabpotential_goals_met"} == "on")
echo "checked";;?>>
        <?php xl('When Goals Are Met','e')?></label>
   </td>
    <td align="left" valign="middle"><p><?php xl('Other','e')?> 
      <input type="text" style="width:120px" name="rehabpotential_others" id="rehabpotential_others" value="<?php echo stripslashes($obj{"rehabpotential_others"});?>" >
    </p> </td>

  </tr>
  <tr>
    <td colspan="6" valign="top" scope="row"><strong>
    <?php xl('OT Care Plan and Discharge was communicated to and agreed upon by','e')?>
     </strong>
      <label>
          <input type="checkbox" name="careplan_discharge_comm" id="careplan_discharge_comm" <?php if ($obj{"careplan_discharge_comm"} == "patient")
echo "checked";;?> value="patient">
          <?php xl('Patient','e')?></label>
        <label>
          <input type="checkbox" name="careplan_discharge_comm" id="careplan_discharge_comm" <?php if ($obj{"careplan_discharge_comm"} == "physician")
echo "checked";;?> value="physician">

          <?php xl('Physician','e')?></label>
        <label>
          <input type="checkbox" name="careplan_discharge_comm" id="careplan_discharge_comm" <?php if ($obj{"careplan_discharge_comm"} == "pt/ot")
echo "checked";;?> value="pt/ot">
          <?php xl('PT/OT/ST','e')?></label>
        <label>
          <input type="checkbox" name="careplan_discharge_comm" id="careplan_discharge_comm" <?php if ($obj{"careplan_discharge_comm"} == "COTA")
echo "checked";;?> value="COTA">
          <?php xl('COTA','e')?></label>

        <label>
          <input type="checkbox" name="careplan_discharge_comm" id="careplan_discharge_comm" <?php if ($obj{"careplan_discharge_comm"} == "nurse")
echo "checked";;?> value="nurse">
          <?php xl('Skilled Nursing','e')?></label>
        <label>
          <input type="checkbox" name="careplan_discharge_comm" id="careplan_discharge_comm" <?php if ($obj{"careplan_discharge_comm"} == "family")
echo "checked";;?> value="family">
          <?php xl('Caregiver/Family','e')?></label>
        <label>
          <input type="checkbox" name="careplan_discharge_comm" id="careplan_discharge_comm" <?php if ($obj{"careplan_discharge_comm"} == "manager")
echo "checked";;?> value="manager">

          <?php xl('Case Manager','e')?><br>
          <?php xl('Other','e')?></label>
        <input type="text" style="width:90%" name="care_plan_discharge_other" id="careplan_discharge_comm" value="<?php echo stripslashes($obj{"care_plan_discharge_other"});?>" >
  </td>
  </tr>
  <tr>
    <td colspan="6" valign="top" scope="row"><p><strong>
    <?php xl(' Patient/Caregiver/Family Response to Care Plan and Occupational Therapy','e')?>
    </strong></p></tr>
  <tr>
    <td colspan="3" valign="middle" scope="row">
      <p>
        <label>
          <input type="checkbox" name="careplan_response_agree" id="response_agree"  <?php if ($obj{"careplan_response_agree"} == "on")
echo "checked";;?>>
          <?php xl('Agreeable to general goals and treatment plan','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="careplan_response_motivated" id="response_motivated"  <?php if ($obj{"careplan_response_motivated"} == "on")
echo "checked";;?>>
          <?php xl('Highly motivated to improve','e')?></label>
        <br />
        <label>
          <input type="checkbox" name="careplan_response_supp" id="response_suppotive"  <?php if ($obj{"careplan_response_supp"} == "on")
echo "checked";;?>>
          <?php xl('Supportive family/caregiver likely to increase success','e')?>
          </label></p><td colspan="3" valign="middle">
            <input type="checkbox" name="addtn_treatment"  id="addtn_treatment" <?php if ($obj{"addtn_treatment"} == "on")
echo "checked";;?>>
            <label for="checkbox">

          <?php xl('May require additional treatment session  to
          achieve Long Term Outcomes due to','e')?></label>
          <input type="checkbox" name="addtn_treatment_req" id="addtn_treatment_req" <?php if ($obj{"addtn_treatment_req"} == "memoryloss")
echo "checked";;?> value="memoryloss">
          <?php xl('short term memory difficulties','e')?>
          <input type="checkbox" name="addtn_treatment_req" id="addtn_treatment_req" <?php if ($obj{"addtn_treatment_req"} == "minsupport")
echo "checked";;?> value="minsupport">
          <?php xl('minimal support systems','e')?><br>
          <input type="checkbox" name="addtn_treatment_req" id="addtn_treatment_req" <?php if ($obj{"addtn_treatment_req"} == "langbarrier")
echo "checked";;?> value="langbarrier">
          <?php xl('communication, language  barriers','e')?>
          </td>
  </tr>
  <tr>
    <td colspan="3" valign="middle" scope="row">
      <p><strong><?php xl('Physician Orders','e')?> </strong>         
        <input type="checkbox" name="physician_orders_obtained" id="physician_orders_obtained" <?php if ($obj{"physician_orders_obtained"} == "on") echo "checked";;?>>
        <label for="Physician Orders Obtained">
        <?php xl('Physician Orders Obtained','e')?></label>
      </p>
      <p>
        <input type="checkbox" name="physician_orders_needed" id="physician_orders_needed" <?php if ($obj{"physician_orders_needed"} == "on") echo "checked";;?>>
        <label for="Physician orders needed">
        <?php xl('Physician orders needed','e')?></label>
        .  <strong><?php xl('Will follow agency&rsquo;s procedures for obtaining verbal orders and completing the 485/POC or submitting  supplemental orders for physician signature','e')?></strong> </p>

   
    <td colspan="3" valign="middle"><p>
        <input type="checkbox" name="address_issues_by" id="address_issues_by" <?php if ($obj{"address_issues_by"} == "on") echo "checked";;?>>
    <?php xl('Will address above issues by','e')?>
      <input type="checkbox" name="address_issues_options" id="writtendirections" <?php if ($obj{"address_issues_options"} == "writtendirections")
echo "checked";;?> value="writtendirections">
    <?php xl('Providing written directions  and/or physical demonstration','e')?> 
    <input type="checkbox" name="address_issues_options" id="communitysupport" <?php if ($obj{"address_issues_options"} == "communitysupport")
echo "checked";;?> value="communitysupport">
    <?php xl('establish community  support systems','e')?><br>
    <input type="checkbox" name="address_issues_options" id="adaptations" <?php if ($obj{"address_issues_options"} == "adaptations")
echo "checked";;?> value="adaptations">
    <?php xl('home/environmental adaptations','e')?>
    <input type="checkbox" name="address_issues_options" id="usefamily" <?php if ($obj{"address_issues_options"} == "usefamily")
echo "checked";;?> value="usefamily">
   <?php xl(' use family/professionals for interpretations as needed','e')?></p>
      <p><?php xl(' Other','e')?>
  <input type="text" style="width:430px" name="address_issues_others" id="address_issues_others" value="<?php echo stripslashes($obj{"address_issues_others"});?>" >
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top" scope="row"><strong>
    <?php xl('Therapist Who Developed POC','e')?> </strong>
    </td>
    <td colspan="3" valign="top"><strong>
    <?php xl('Electronic Signature','e')?></strong></td>
  </tr>  
</table>
<a href="javascript:top.restoreSession();document.careplan.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

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
<?php html_header_show();?>

</body>

</html>
