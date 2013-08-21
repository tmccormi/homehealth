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
$formTable = "forms_msw_evaluation";

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
$obj = formFetch("forms_msw_evaluation", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$cardio_teach = explode("#",$obj{"careplan_SN_CARDIO_Teach"});
$cardio_pcg_goals = explode("#",$obj{"careplan_SN_CARDIO_PtPcgGoals"});
$endo_assess = explode("#",$obj{"careplan_SN_ENDO_Assess"});
$endo_teach = explode("#",$obj{"careplan_SN_ENDO_Teach"});
$endo_perform = explode("#",$obj{"careplan_SN_ENDO_Perform"});
?>
<form method="post"		action="<?php echo $rootdir;?>/forms/msw_evaluation/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="msw_evaluation">
		<h3 align="center"><?php xl('MEDICAL SOCIAL WORKER EVALUATION','e')?></h3>

<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" class="formtable">
<tr>
<td>
<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" class="formtable">
<td style="border : 0px; width : 30%;"></td>
<td style="border : 0px; width : 70%;">
<table Style="border : 0px;" width="100%" cellpadding="5px" cellspacing="0px" class="formtable">
<tr>
<td>
<b><?php xl(' Time In ','e') ?></b>
<select name="msw_evaluation_time_in" >
<?php timeDropDown(stripslashes($obj{"msw_evaluation_time_in"})) ?>
</select>
</td>
<td>
<b><?php xl(' Time Out ','e') ?></b>
<select name="msw_evaluation_time_out" >
<?php timeDropDown(stripslashes($obj{"msw_evaluation_time_out"})) ?>
</select>
</td>
<td>
<b><?php xl('Date','e') ?></b>
<input type='text' size='10' name='msw_evaluation_date' id='msw_evaluation_date' title='<?php xl('Evaluation Date','e'); ?>'
value="<?php echo stripslashes($obj{"msw_evaluation_date"});?>"
				onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly /> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"msw_evaluation_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
</td>
</tr>
</table>
</td>
</table>
</td>
</tr>

<tr><td style="padding : 0px;">
<table cellspacing="0px" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td align="center"><b><?php xl('PATIENT NAME','e') ?></b></td>
<td><input type="text" style="width : 95%;" name="msw_evaluation_patient_name" value="<?php patientName(); ?>" readonly /></td>
<td align="center"><b><?php xl('MR#','e') ?></b></td>
<td><input type="text" name="msw_evaluation_mr" style="width : 15%;" value="<?php  echo $_SESSION['pid']?>" readonly></td>

<td align="center"><b><?php xl('Start of Care Date','e') ?></b></td>
<td><input type='text' size='12' name='msw_evaluation_soc' id='msw_evaluation_soc' title='<?php xl('Start of Care Date','e'); ?>' value="<?php echo stripslashes($obj{"msw_evaluation_soc"});?>" onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly />

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"msw_evaluation_soc", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr>
</table>
</td></tr>

<tr>
<td style="padding : 0px;">
<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" class="formtable">
<tr>
<td>
<b><?php xl('HOMEBOUND REASON ','e') ?></b><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Needs assistance in all activities") echo "checked";;?> value="<?php xl('Needs assistance in all activities','e') ?>" /><?php xl(' Needs assistance in all activities ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Unable to leave home safely without assistance") echo "checked";;?> value="<?php xl('Unable to leave home safely without assistance','e') ?>" /><?php xl(' Unable to leave home safely without assistance ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Medical Restrictions") echo "checked";;?> value="<?php xl('Medical Restrictions','e') ?>" /><?php xl(' Medical Restrictions ','e') ?>
<?php xl(' in ','e') ?> <input type="text" name="msw_evaluation_homebound_reason_in" style="width : 50%;" value="<?php echo stripslashes($obj{"msw_evaluation_homebound_reason_in"});?>" /><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "SOB upon exertion") echo "checked";;?> value="<?php xl('SOB upon exertion','e') ?>" /><?php xl(' SOB upon exertion ','e') ?>
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Pain with Travel") echo "checked";;?> value="<?php xl('Pain with Travel','e') ?>" /><?php xl(' Pain with Travel ','e') ?>
</td>
<td style="border-left : 1px solid #000000">
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Requires assistance in mobility and ambulation") echo "checked";;?> value="<?php xl('Requires assistance in mobility and ambulation','e') ?>" /><?php xl(' Requires assistance in mobility and ambulation ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Arrhythmia") echo "checked";;?> value="<?php xl('Arrhythmia','e') ?>" /><?php xl(' Arrhythmia ','e') ?>&nbsp; &nbsp;  &nbsp; 
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Bed Bound") echo "checked";;?> value="<?php xl('Bed Bound','e') ?>" /><?php xl(' Bed Bound ','e') ?>&nbsp; &nbsp;  &nbsp; 
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Residual Weakness") echo "checked";;?> value="<?php xl('Residual Weakness','e') ?>" /><?php xl(' Residual Weakness ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Confusion, unable to go out of home alone") echo "checked";;?> value="<?php xl('Confusion, unable to go out of home alone','e') ?>" /><?php xl(' Confusion, unable to go out of home alone ','e') ?><br/>
<input type="checkbox" name="msw_evaluation_homebound_reason" <?php if ($obj{"msw_evaluation_homebound_reason"} == "Multiple stairs to enter/exit home") echo "checked";;?> value="<?php xl('Multiple stairs to enter/exit home','e') ?>" /><?php xl(' Multiple stairs to enter/exit home ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" name="msw_evaluation_homebound_reason_other" style="width : 90%;" value="<?php echo stripslashes($obj{"msw_evaluation_homebound_reason_other"});?>" />
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td>
<b><?php xl('ORDERS FOR EVALUATION ONLY ','e') ?></b>
<input type="checkbox" name="msw_evaluation_orders_for_evaluation" <?php if ($obj{"msw_evaluation_orders_for_evaluation"} == "YES") echo "checked";;?> value="<?php xl('YES','e') ?>" /><b><?php xl(' YES ','e') ?></b>
<input type="checkbox" name="msw_evaluation_orders_for_evaluation" <?php if ($obj{"msw_evaluation_orders_for_evaluation"} == "NO") echo "checked";;?> value="<?php xl('NO','e') ?>" /><b><?php xl(' NO ','e') ?></b>&nbsp; &nbsp;  &nbsp; 
<b><?php xl(' IF NO EXPLAIN ORDERS ','e') ?></b>
<input type="text" name="msw_evaluation_if_no_explain_orders" style="width : 22%;" value="<?php echo stripslashes($obj{"msw_evaluation_if_no_explain_orders"});?>" />
</td>
</tr>

<tr>
<td><b><?php xl('PERTINENT BACKGROUND INFORMATION ','e') ?></b></td>
</tr>

<tr>
<td style="padding : 0px;">
<table width="100%" class="formtable" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td style="width :43%;"><b><?php xl('Medical Diagnosis/Problem ','e') ?></b></td>
<td style="width :57%;"><b><?php xl('Onset ','e') ?></b>
<input type='text' size='10' name='msw_evaluation_medical_diagnosis_problem_onset' id='msw_evaluation_medical_diagnosis_problem_onset' title='<?php xl('Onset Date','e'); ?>'
value="<?php echo stripslashes($obj{"msw_evaluation_medical_diagnosis_problem_onset"});?>"
				onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"msw_evaluation_medical_diagnosis_problem_onset", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
</td>
</tr>
<tr>
<td colspan="2"><textarea name="msw_evaluation_medical_diagnosis_problem" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_medical_diagnosis_problem"});?></textarea></td>
</tr>
</table>
</td>
</tr>

<tr>
<td>
<b><?php xl('Medical/Psychosocial History ','e') ?></b><br/>
<textarea name="msw_evaluation_psychosocial_history" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_psychosocial_history"});?></textarea><br/>
<b><?php xl('Prior Level of Function (ADL, Community Integration) ','e') ?></b><br/>
<textarea name="msw_evaluation_prior_level_function" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_prior_level_function"});?></textarea><br/>
<b><?php xl('PRIOR FAMILY/CAREGIVER SUPPORT ','e') ?></b>
<input type="checkbox" name="msw_evaluation_prior_caregiver_support" <?php if ($obj{"msw_evaluation_prior_caregiver_support"} == "YES") echo "checked";;?> value="<?php xl('YES','e') ?>" /><?php xl(' YES ','e') ?>
<input type="checkbox" name="msw_evaluation_prior_caregiver_support" <?php if ($obj{"msw_evaluation_prior_caregiver_support"} == "NO") echo "checked";;?> value="<?php xl('NO','e') ?>" /><?php xl(' NO ','e') ?>
&nbsp; &nbsp; &nbsp; <?php xl(' Who ','e') ?>
<input type="text" name="msw_evaluation_prior_caregiver_support_who" style="width : 26%;" value="<?php echo stripslashes($obj{"msw_evaluation_prior_caregiver_support_who"});?>" />
</td>
</tr>

<tr>
<td><b><?php xl('MEDICAL SOCIAL SERVICES ','e') ?></b></td>
</tr>

<tr>
<td>
<b><?php xl('Psychosocial ','e')?></b><?php xl(' (A description of mental status, coping mechanisms, safety awareness and potential issues, etc.)','e') ?><br/>
<input type="checkbox" name="msw_evaluation_psychosocial" <?php if ($obj{"msw_evaluation_psychosocial"} == "Alert") echo "checked";;?> value="<?php xl('Alert','e') ?>" /><?php xl(' Alert ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial" <?php if ($obj{"msw_evaluation_psychosocial"} == "Not Alert") echo "checked";;?> value="<?php xl('Not Alert','e') ?>" /><?php xl(' Not Alert ','e') ?>
&nbsp; &nbsp; &nbsp; <?php xl(' Oriented to ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial_oriented" <?php if ($obj{"msw_evaluation_psychosocial_oriented"} == "Person") echo "checked";;?> value="<?php xl('Person','e') ?>" /><?php xl(' Person ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial_oriented" <?php if ($obj{"msw_evaluation_psychosocial_oriented"} == "Place") echo "checked";;?> value="<?php xl('Place','e') ?>" /><?php xl(' Place ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial_oriented" <?php if ($obj{"msw_evaluation_psychosocial_oriented"} == "Date") echo "checked";;?> value="<?php xl('Date','e') ?>" /><?php xl(' Date ','e') ?>
<input type="checkbox" name="msw_evaluation_psychosocial_oriented" <?php if ($obj{"msw_evaluation_psychosocial_oriented"} == "Reason for MSW Intervention") echo "checked";;?> value="<?php xl('Reason for MSW Intervention','e') ?>" /><?php xl(' Reason for MSW Intervention ','e') ?><br/>
<b><?php xl('Safety Awareness ','e')?></b>
<input type="checkbox" name="msw_evaluation_safety_awareness" <?php if ($obj{"msw_evaluation_safety_awareness"} == "Good") echo "checked";;?> value="<?php xl('Good','e') ?>" /><?php xl(' Good ','e') ?>
<input type="checkbox" name="msw_evaluation_safety_awareness" <?php if ($obj{"msw_evaluation_safety_awareness"} == "Fair") echo "checked";;?> value="<?php xl('Fair','e') ?>" /><?php xl(' Fair ','e') ?>
<input type="checkbox" name="msw_evaluation_safety_awareness" <?php if ($obj{"msw_evaluation_safety_awareness"} == "Poor") echo "checked";;?> value="<?php xl('Poor','e') ?>" /><?php xl(' Poor ','e') ?><br/>
<textarea name="msw_evaluation_safety_awareness_other" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_safety_awareness_other"});?></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Current Living Situation/Support System ','e')?></b><?php xl(' (Assess relationships, interactions with support services, family communications, etc.) ','e') ?><br/>
<textarea name="msw_evaluation_living_situation_support_system" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_living_situation_support_system"});?></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Health Factors ','e')?></b><?php xl(' (Assess factors that may impede the Plan of Care from being implemented i.e. function, vision, hearing, vision, nutrition, etc.) ','e') ?><br/>
<textarea name="msw_evaluation_health_factors" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_health_factors"});?></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Environmental Factors ','e')?></b><?php xl(' (Describe factors that impact Plan of Care such as transportation, living situation, support services for environmental management e.g. can assist with upkeep) ','e') ?><br/>
<textarea name="msw_evaluation_environmental_factors" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_environmental_factors"});?></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Financial Factors ','e')?></b><?php xl(' (Assess income, assets/expenses, resources that impact Plan of Care) ','e') ?><br/>
<textarea name="msw_evaluation_financial_factors" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_financial_factors"});?></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('Additional Information ','e')?></b><br/>
<textarea name="msw_evaluation_additional_information" rows="3" cols="100"><?php echo stripslashes($obj{"msw_evaluation_additional_information"});?></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('MSW Plan of Care and Discharge was communicated to and agreed upon by ','e')?></b>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" <?php if ($obj{"msw_evaluation_plan_ofc_are_and_discharge_was_communicated"} == "Patient") echo "checked";;?> value="<?php xl('Patient','e') ?>" /><?php xl(' Patient ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" <?php if ($obj{"msw_evaluation_plan_ofc_are_and_discharge_was_communicated"} == "Caregiver/Family") echo "checked";;?> value="<?php xl('Caregiver/Family','e') ?>" /><?php xl(' Caregiver/Family ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" <?php if ($obj{"msw_evaluation_plan_ofc_are_and_discharge_was_communicated"} == "Physician") echo "checked";;?> value="<?php xl('Physician','e') ?>" /><?php xl(' Physician ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" <?php if ($obj{"msw_evaluation_plan_ofc_are_and_discharge_was_communicated"} == "PT/OT/ST") echo "checked";;?> value="<?php xl('PT/OT/ST','e') ?>" /><?php xl(' PT/OT/ST ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" <?php if ($obj{"msw_evaluation_plan_ofc_are_and_discharge_was_communicated"} == "Skilled Nursing") echo "checked";;?> value="<?php xl('Skilled Nursing','e') ?>" /><?php xl(' Skilled Nursing ','e') ?>
<input type="checkbox" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated" <?php if ($obj{"msw_evaluation_plan_ofc_are_and_discharge_was_communicated"} == "Case Manager") echo "checked";;?> value="<?php xl('Case Manager','e') ?>" /><?php xl(' Case Manager ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" name="msw_evaluation_plan_ofc_are_and_discharge_was_communicated_other" style="width : 49%;" value="<?php echo stripslashes($obj{"msw_evaluation_plan_ofc_are_and_discharge_was_communicated_other"});?>" />
</td>
</tr>


<tr><td style="padding : 0px;">
<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" class="formtable" ><tr>
<td style="width : 50px;"><b><?php xl('Therapist Who Developed POC ','e') ?></b></td>
<td style="width : 50px;"></td>
</tr></table>
</td></tr>
</table>
<a href="javascript:top.restoreSession();document.msw_evaluation.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
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

</body>
</html>

	