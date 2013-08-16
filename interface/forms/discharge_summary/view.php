<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: general_discharge_summary");
include_once("$srcdir/api.inc");
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
$formTable = "forms_discharge_summary";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();

$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

$obj = formFetch("forms_discharge_summary", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$discontinue_services = explode("#",$obj{"discharge_summary_discontinue_services"});
$provided_interventions = explode("#",$obj{"discharge_summary_provided_interventions"});
$discharge_reason = explode("#",$obj{"discharge_summary_discharge_reason"});

?>

<html>
<head>
<title>GENERAL DISCHARGE SUMMARY</title>
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
	<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<script>
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
	<form method="post"
		action="<?php echo $rootdir;?>/forms/discharge_summary/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="general_discharge_summary">
		<h3 align="center"><?php xl('GENERAL DISCHARGE SUMMARY','e')?></h3>		
		 <br/>
		<table width="100%" border="1" cellpadding="2px" class="formtable">
			<tr>
			<td colspan="6">
				<table border="1px" class="formtable" width="100%"><tr>
				<td align="center" valign="top" scope="row">
				<strong><?php xl('PATIENT NAME','e')?></strong></td>
				<td align="center" valign="top"><input type="text" name="patient_name"
					 id="patient_name" value="<?php patientName()?>"
					readonly /></td>
				<td  align="center" valign="top"><strong><?php xl('MR#','e')?>
				</strong></td>
				<td align="center" valign="top" class="bold"><input
					type="text" name="patient_mr" id="patient_mr"
					value="<?php  echo $_SESSION['pid']?>" readonly/></td>
				<td align="center" valign="top">
				<strong><?php xl('DATE','e')?></strong></td>
				<td align="center" valign="top" class="bold">
				<input type='text' size='10' name='patient_discharge_date' id='patient_discharge_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"patient_discharge_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"patient_discharge_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
				</td>
				</tr></table>
			</td>
			</tr>
		<tr>
				<td >
				<strong><?php xl('DISCONTINUE FURTHER SERVICES FOR:','e');?></strong>&nbsp;&nbsp;
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" <?php if (in_array("Skilled Nursing",$discontinue_services)) echo "checked";?> value="Skilled Nursing"><?php xl('Skilled Nursing','e');?></label>
			    <label><input type="checkbox" name="discharge_summary_discontinue_services[]" <?php if (in_array("Physical Therapy",$discontinue_services)) echo "checked";?> value="Physical Therapy"><?php xl('Physical Therapy','e');?></label>
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" <?php if (in_array("Occupational Therapy",$discontinue_services)) echo "checked";?> value="Occupational Therapy"><?php xl('Occupational Therapy','e');?></label>
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" <?php if (in_array("Speech Therapy",$discontinue_services)) echo "checked";?> value="Speech Therapy"><?php xl('Speech Therapy','e');?></label>
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" <?php if (in_array("Home Health Aide",$discontinue_services)) echo "checked";?> value="Home Health Aide"><?php xl('Home Health Aide','e');?></label>
				<label><input type="checkbox" name="discharge_summary_discontinue_services[]" <?php if (in_array("Medical Social Worker",$discontinue_services)) echo "checked";?> value="Medical Social Worker"><?php xl('Medical Social Worker','e');?></label>
				&nbsp;&nbsp;&nbsp;
				<?php xl('Other ','e');?>&nbsp;<input type="text" name="discharge_summary_discontinue_services_other" style="width:63%" value="<?php echo stripslashes($obj{"discharge_summary_discontinue_services_other"});?>">
				</td>
			</tr>
			<tr>
			<td>
			<strong><?php xl('Mental Status','e');?></strong><br>
			<label><input type="checkbox" name="discharge_summary_mental_status" <?php if ($obj{"discharge_summary_mental_status"} == "Alert") echo "checked";;?> value="Alert"><?php xl('Alert','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" <?php if ($obj{"discharge_summary_mental_status"} == "Oriented") echo "checked";;?> value="Oriented"><?php xl('Oriented','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" <?php if ($obj{"discharge_summary_mental_status"} == "Forgetful") echo "checked";;?> value="Forgetful"><?php xl('Forgetful','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" <?php if ($obj{"discharge_summary_mental_status"} == "Disoriented") echo "checked";;?> value="Disoriented"><?php xl('Disoriented','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" <?php if ($obj{"discharge_summary_mental_status"} == "Depressed") echo "checked";;?> value="Depressed"><?php xl('Depressed','e');?></label>
			<label><input type="checkbox" name="discharge_summary_mental_status" <?php if ($obj{"discharge_summary_mental_status"} == "Agitated") echo "checked";;?> value="Agitated"><?php xl('Agitated','e');?></label>
			&nbsp;&nbsp;&nbsp;
			<?php xl('Other ','e');?>&nbsp;<input type="text" name="discharge_summary_mental_status_other" style="width:36%" value="<?php echo stripslashes($obj{"discharge_summary_mental_status_other"});?>" >
			<br>
			<?php xl('Based on cognitive, medical and functional impairments the following interventions have been provided by the home
health agency (Check all that apply)','e');?>&nbsp;&nbsp;
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" <?php if (in_array("Skilled Nursing",$provided_interventions)) echo "checked";?> value="Skilled Nursing"><?php xl('Skilled Nursing','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" <?php if (in_array("Medical Social Services",$provided_interventions)) echo "checked";?> value="Medical Social Services"><?php xl('Medical Social Services','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" <?php if (in_array("Caregiver Management Training",$provided_interventions)) echo "checked";?> value="Caregiver Management Training"><?php xl('Caregiver Management Training','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" <?php if (in_array("Home Health Aide Support",$provided_interventions)) echo "checked";?> value="Home Health Aide Support"><?php xl('Home Health Aide Support','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" <?php if (in_array("PT",$provided_interventions)) echo "checked";?> value="PT"><?php xl('PT','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" <?php if (in_array("OT",$provided_interventions)) echo "checked";?> value="OT"><?php xl('OT','e');?></label>
			<label><input type="checkbox" name="discharge_summary_provided_interventions[]" <?php if (in_array("ST",$provided_interventions)) echo "checked";?> value="ST"><?php xl('ST','e');?></label>
			&nbsp;&nbsp;&nbsp;
			<?php xl('Other ','e');?>&nbsp;<input type="text" name="discharge_summary_provided_interventions_other" style="width:85%" value="<?php echo stripslashes($obj{"discharge_summary_provided_interventions_other"});?>">
			</td>
			</tr>
			
			<tr>
			<td>
			<table width="100%" border="1px" class="formtable"><tr>
			<td colspan="3">
			<strong><?php xl('Reason for Discharge (Check all that apply)','e');?></strong>
			</td></tr>
			<tr>
			<td width="33%">
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("No Further Skilled Care Required",$discharge_reason)) echo "checked";?> value="No Further Skilled Care Required"><?php xl('No Further Skilled Care Required','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Short-Term Goals were achieved",$discharge_reason)) echo "checked";?> value="Short-Term Goals were achieved"><?php xl('Short-Term Goals were achieved','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Long-Term Goals were achieved",$discharge_reason)) echo "checked";?> value="Long-Term Goals were achieved"><?php xl('Long-Term Goals were achieved','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Patient no longer homebound",$discharge_reason)) echo "checked";?> value="Patient no longer homebound"><?php xl('Patient no longer homebound','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Patient reached maximum rehab potential",$discharge_reason)) echo "checked";?> value="Patient reached maximum rehab potential"><?php xl('Patient reached maximum rehab potential','e');?></label>
			</td>
			<td width="33%">
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Family/Friends/Physician Assume Responsibility Patient/Family refused services",$discharge_reason)) echo "checked";?> value="Family/Friends/Physician Assume Responsibility Patient/Family refused services"><?php xl('Family/Friends/Physician Assume Responsibility Patient/Family refused services','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Moved out of service area",$discharge_reason)) echo "checked";?> value="Moved out of service area"><?php xl('Moved out of service area','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Admitted to Hospital",$discharge_reason)) echo "checked";?> value="Admitted to Hospital"><?php xl('Admitted to Hospital','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Admitted to a higher level of care (SNF,ALF)",$discharge_reason)) echo "checked";?> value="Admitted to a higher level of care (SNF,ALF)"><?php xl('Admitted to a higher level of care (SNF,ALF)','e');?></label>
			</td>
			<td width="33%">
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Transferred to another Agency",$discharge_reason)) echo "checked";?> value="Transferred to another Agency"><?php xl('Transferred to another Agency','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Death",$discharge_reason)) echo "checked";?> value="Death"><?php xl('Death','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("Transferred to Hospice",$discharge_reason)) echo "checked";?> value="Transferred to Hospice"><?php xl('Transferred to Hospice','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_discharge_reason[]" <?php if (in_array("MD Request",$discharge_reason)) echo "checked";?> value="MD Request"><?php xl('MD Request','e');?></label><br>
			<?php xl('Other ','e');?>&nbsp;<input type="text" name="discharge_summary_discharge_reason_other" style="width:75%" value="<?php echo stripslashes($obj{"discharge_summary_discharge_reason_other"});?>" >
			</td>
			</tr>
			</table></td>
			</tr>
			
			<tr>
			<td>
			<strong><?php xl('Functional Ability at Time of Discharge','e');?></strong><br>
			<label><input type="checkbox" name="discharge_summary_functional_ability" <?php if ($obj{"discharge_summary_functional_ability"} == "Independent") echo "checked";;?> value="Independent"><?php xl('Independent','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_functional_ability" <?php if ($obj{"discharge_summary_functional_ability"} == "Independent with Minimal Assistance") echo "checked";;?> value="Independent with Minimal Assistance"><?php xl('Independent with Minimal Assistance','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_functional_ability" <?php if ($obj{"discharge_summary_functional_ability"} == "Partially Dependent") echo "checked";;?> value="Partially Dependent"><?php xl('Partially Dependent','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_functional_ability" <?php if ($obj{"discharge_summary_functional_ability"} == "Totally Dependent") echo "checked";;?> value="Totally Dependent"><?php xl('Totally Dependent','e');?></label>&nbsp;
			</td>
			</tr>
			
			<tr>
			<td>
			<strong><?php xl('COMMENTS/RECOMMENDATIONS','e');?></strong><br>
			<label><input type="checkbox" name="discharge_summary_comments_recommendations" <?php if ($obj{"discharge_summary_comments_recommendations"} == "Discharge was anticipated") echo "checked";;?> value="Discharge was anticipated"><?php xl('Discharge was anticipated and discussed in advance with patient/caregiver/family and MD','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_comments_recommendations" <?php if ($obj{"discharge_summary_comments_recommendations"} == "Discharge was not anticipated") echo "checked";;?> value="Discharge was not anticipated"><?php xl('Discharge was not anticipated','e');?></label><br>
			<label><input type="checkbox" name="discharge_summary_comments_recommendations" <?php if ($obj{"discharge_summary_comments_recommendations"} == "No longer homebound but would benefit from outpatient services") echo "checked";;?> value="No longer homebound but would benefit from outpatient services"><?php xl('No longer homebound but would benefit from outpatient services','e');?></label>&nbsp;
			&nbsp;<?php xl('Services recommended','e');?>&nbsp;<input type="text" name="discharge_summary_service_recommended" style="width:30%" value="<?php echo stripslashes($obj{"discharge_summary_service_recommended"});?>"><br>
			<label><input type="checkbox" name="discharge_summary_comments_recommendations" <?php if ($obj{"discharge_summary_comments_recommendations"} == "Recommend follow-up treatment when patient returns to home") echo "checked";;?> value="Recommend follow-up treatment when patient returns to home"><?php xl('Recommend follow-up treatment when patient returns to home.','e');?></label><br>
			<?php xl('Goals identified on care plan were','e');?>&nbsp;&nbsp;
			<label><input type="checkbox" name="discharge_summary_goals_identified" <?php if ($obj{"discharge_summary_goals_identified"} == "met") echo "checked";;?> value="met"><?php xl('met','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_goals_identified" <?php if ($obj{"discharge_summary_goals_identified"} == "partially met") echo "checked";;?> value="partially met"><?php xl('partially met','e');?></label>&nbsp;
			<label><input type="checkbox" name="discharge_summary_goals_identified" <?php if ($obj{"discharge_summary_goals_identified"} == "not met") echo "checked";;?> value="not met"><?php xl('not met (If goals partially met or not met please explain)','e');?></label>
			<br>
			<input type="text" name="discharge_summary_goals_identified_explanation" style="width:96%" value="<?php echo stripslashes($obj{"discharge_summary_goals_identified_explanation"});?>" >
			</td>
			</tr>
			
			<tr>
			<td>
			<strong><?php xl('Additional Comments','e');?></strong><br>
			<textarea name="discharge_summary_additional_comments" rows="3" cols="98" ><?php echo $obj{"discharge_summary_additional_comments"};?></textarea>
			</td>
			</tr>
			
			<tr>
			<td>
			<table border="1px" width="100%" class="formtable"><tr><td width="70%">
			<?php xl('<b>Visit and Discharge Completed by Clinician Signature<b> (Name/Title)','e');?>
			</td>
			<td width="30%">
			<?php xl('Electronic Signature','e');?>
			</td></tr></table>
			</td>
			</tr>
			
			<tr>
			<td>
			<strong><?php xl('Physician Confirmation of Discharge Orders','e');?></strong><br>
			<strong><?php xl('By Signing below, MD agrees with discharge from these Home Health Services','e');?></strong><br>
			</td>
			</tr>
			
			<tr>
			<td>
			<table border="1px" width="100%" class="formtable">
			<tr><td width="33%">
			<strong><?php xl('MD PRINTED NAME','e');?></strong><br>
			<input type="text" name="discharge_summary_md_name" style="width:90%" value="<?php doctorname(); ?>" readonly >
			</td>
			<td width="33%">
			<strong><?php xl('MD Signature','e');?></strong><br>
			<input type="text" name="discharge_summary_md_signature" style="width:90%" value="<?php echo stripslashes($obj{"discharge_summary_md_signature"});?>" >
			</td>
			<td width="33%">
			<strong><?php xl('Date','e');?></strong><br>&nbsp;
			<input type='text' size='16' name='discharge_summary_md_signature_date' id='discharge_summary_md_signature_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"discharge_summary_md_signature_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"discharge_summary_md_signature_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			
			
			
			
			
			
		</table>
		<a href="javascript:top.restoreSession();document.general_discharge_summary.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
		</form>
</body>
<center>
        <table>
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
