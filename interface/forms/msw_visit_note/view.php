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
$formTable = "forms_msw_visit_note";

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

<script>
function requiredCheck(){
    var time_in = document.getElementById('msw_visit_note_time_in').value;
    var time_out = document.getElementById('msw_visit_note_time_out').value;
				var date = document.getElementById('msw_visit_note_date').value;
    
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
$obj = formFetch("forms_msw_visit_note", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$cardio_teach = explode("#",$obj{"careplan_SN_CARDIO_Teach"});
$cardio_pcg_goals = explode("#",$obj{"careplan_SN_CARDIO_PtPcgGoals"});
$endo_assess = explode("#",$obj{"careplan_SN_ENDO_Assess"});
$endo_teach = explode("#",$obj{"careplan_SN_ENDO_Teach"});
$endo_perform = explode("#",$obj{"careplan_SN_ENDO_Perform"});
?>
<form method="post"		action="<?php echo $rootdir;?>/forms/msw_visit_note/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="msw_visit_note" id="msw_visit_note">
		<h3 align="center"><?php xl('MEDICAL SOCIAL SERVICES VISIT NOTE','e')?></h3>

<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" class="formtable">
<tr>
<td>
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" class="formtable">
<td style="border : 0px; width : 30%;"></td>
<td style="border : 0px; width : 70%;">
<table width="100%" cellspacing="0px" cellpadding="5px"  Style="border : 0px;" class="formtable">
<tr>
<td>
<b><?php xl(' Time In ','e') ?></b>
<select name="msw_visit_note_time_in" id="msw_visit_note_time_in">
<?php timeDropDown(stripslashes($obj{"msw_visit_note_time_in"})) ?>
</select>
</td>
<td>
<b><?php xl(' Time Out ','e') ?></b>
<select name="msw_visit_note_time_out" id="msw_visit_note_time_out">
<?php timeDropDown(stripslashes($obj{"msw_visit_note_time_out"})) ?>
</select>
</td>
<td>
<b><?php xl('Encounter Date','e') ?></b>
<input type='text' size='10' name='msw_visit_note_date' id='msw_visit_note_date' title='<?php xl('Encounter Date','e'); ?>'
value="<?php echo stripslashes($obj{"msw_visit_note_date"});?>"
				onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly /> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"msw_visit_note_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
</td>
</tr>
</table>
</td>
</table>
</td>
</tr>

<tr><td style="padding : 0px;">
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" >
<tr>
<td align="center"><b><?php xl('PATIENT NAME','e') ?></b></td>
<td style="width: 32%;"><input type="text" style="width : 95%;" name="msw_visit_note_patient_name" value="<?php patientName(); ?>" readonly /></td>
<td align="center"><b><?php xl('MR#','e') ?></b></td>
<td><input type="text" name="msw_visit_note_mr" style="width : 15%;" value="<?php  echo $_SESSION['pid']?>" readonly></td>

<td align="center"><b><?php xl('Start of Care Date','e') ?></b></td>
<td><input type='text' size='12' name='msw_visit_note_soc' id='msw_visit_note_soc' title='<?php xl('Start of Care Date','e'); ?>' value="<?php echo stripslashes($obj{"msw_visit_note_soc"});?>" onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly /> 

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"msw_visit_note_soc", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr>
</table>
</td></tr>

<tr>
<td style="padding : 0px;">
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" class="formtable">
<tr>
<td>
<b><?php xl('HOMEBOUND REASON ','e') ?></b><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Needs assistance in all activities") echo "checked";;?> value="<?php xl('Needs assistance in all activities','e') ?>" /><?php xl(' Needs assistance in all activities ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Unable to leave home safely without assistance") echo "checked";;?> value="<?php xl('Unable to leave home safely without assistance','e') ?>" /><?php xl(' Unable to leave home safely without assistance ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Medical Restrictions") echo "checked";;?> value="<?php xl('Medical Restrictions','e') ?>" /><?php xl(' Medical Restrictions ','e') ?>
<?php xl(' in ','e') ?> <input type="text" name="msw_visit_note_homebound_reason_in" style="width : 50%;" value="<?php echo stripslashes($obj{"msw_visit_note_homebound_reason_in"});?>" /><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "SOB upon exertion") echo "checked";;?> value="<?php xl('SOB upon exertion','e') ?>" /><?php xl(' SOB upon exertion ','e') ?>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Pain with Travel") echo "checked";;?> value="<?php xl('Pain with Travel','e') ?>" /><?php xl(' Pain with Travel ','e') ?>
</td>
<td style="border-left : 1px solid #000000">
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Requires assistance in mobility and ambulation") echo "checked";;?> value="<?php xl('Requires assistance in mobility and ambulation','e') ?>" /><?php xl(' Requires assistance in mobility and ambulation ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Arrhythmia") echo "checked";;?> value="<?php xl('Arrhythmia','e') ?>" /><?php xl(' Arrhythmia ','e') ?>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Bed Bound") echo "checked";;?> value="<?php xl('Bed Bound','e') ?>" /><?php xl(' Bed Bound ','e') ?>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Residual Weakness") echo "checked";;?> value="<?php xl('Residual Weakness','e') ?>" /><?php xl(' Residual Weakness ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Confusion, unable to go out of home alone") echo "checked";;?> value="<?php xl('Confusion, unable to go out of home alone','e') ?>" /><?php xl(' Confusion, unable to go out of home alone ','e') ?><br/>
<input type="checkbox" name="msw_visit_note_homebound_reason" <?php if ($obj{"msw_visit_note_homebound_reason"} == "Multiple stairs to enter/exit home") echo "checked";;?> value="<?php xl('Multiple stairs to enter/exit home','e') ?>" /><?php xl(' Multiple stairs to enter/exit home ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" name="msw_visit_note_homebound_reason_other" style="width : 90%;" value="<?php echo stripslashes($obj{"msw_visit_note_homebound_reason_other"});?>" />
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td><b><?php xl('MEDICAL SOCIAL WORKER OBSERVATIONS/ASSESSMENT THIS VISIT ','e') ?></b></td>
</tr>

<tr>
<td>
<b><?php xl('Current Psychological, Social, Health, Financial and Environmental Situation for This Visit ','e')?></b><br/>
<textarea name="msw_visit_note_phychological_health_environmental_situation" rows="3" cols="100"><?php echo stripslashes($obj{"msw_visit_note_phychological_health_environmental_situation"});?></textarea>
</td>
</tr>

<tr>
<td><b><?php xl('MSW INTERVENTIONS THIS VISIT ','e') ?></b></td>
</tr>

<tr>
<td>
<b><?php xl('Assessment of current ','e') ?></b>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" <?php if ($obj{"msw_visit_note_asssessment_of_current"} == "Psychological") echo "checked";;?> value="<?php xl('Psychological','e') ?>" /><?php xl(' Psychological ','e') ?>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" <?php if ($obj{"msw_visit_note_asssessment_of_current"} == "Social") echo "checked";;?> value="<?php xl('Social','e') ?>" /><?php xl(' Social ','e') ?>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" <?php if ($obj{"msw_visit_note_asssessment_of_current"} == "Health") echo "checked";;?> value="<?php xl('Health','e') ?>" /><?php xl(' Health ','e') ?>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" <?php if ($obj{"msw_visit_note_asssessment_of_current"} == "Financial") echo "checked";;?> value="<?php xl('Financial','e') ?>" /><?php xl(' Financial ','e') ?>
<input type="checkbox" name="msw_visit_note_asssessment_of_current" <?php if ($obj{"msw_visit_note_asssessment_of_current"} == "Environmental /Living Situation") echo "checked";;?> value="<?php xl('Environmental /Living Situation','e') ?>" /><?php xl(' Environmental /Living Situation ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_asssessment_of_current_other" value="<?php echo stripslashes($obj{"msw_visit_note_asssessment_of_current_other"});?>" /><br/>
<b><?php xl('Patient/Caregiver Education: ','e') ?></b>
<input type="checkbox" name="msw_visit_note_patient_education" <?php if ($obj{"msw_visit_note_patient_education"} == "Community Support Groups") echo "checked";;?> value="<?php xl('Community Support Groups','e') ?>" /><?php xl(' Community Support Groups ','e') ?>
<input type="checkbox" name="msw_visit_note_patient_education" <?php if ($obj{"msw_visit_note_patient_education"} == "Financial Resources") echo "checked";;?> value="<?php xl('Financial Resources','e') ?>" /><?php xl(' Financial Resources ','e') ?>
<input type="checkbox" name="msw_visit_note_patient_education" <?php if ($obj{"msw_visit_note_patient_education"} == "Alternative Living Situations") echo "checked";;?> value="<?php xl('Alternative Living Situations','e') ?>" /><?php xl(' Alternative Living Situations ','e') ?>
<input type="checkbox" name="msw_visit_note_patient_education" <?php if ($obj{"msw_visit_note_patient_education"} == "Community Resources") echo "checked";;?> value="<?php xl('Community Resources','e') ?>" /><?php xl(' Community Resources ','e') ?>
<input type="checkbox" name="msw_visit_note_patient_education" <?php if ($obj{"msw_visit_note_patient_education"} == "Other") echo "checked";;?> value="<?php xl('Other','e') ?>" /><?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_patient_education_other" value="<?php echo stripslashes($obj{"msw_visit_note_patient_education_other"});?>" /><br/>
<b><?php xl('Interventions Including: ','e') ?></b>
<input type="checkbox" name="msw_visit_note_interventions_including" <?php if ($obj{"msw_visit_note_interventions_including"} == "Counseling for planning and decision making") echo "checked";;?> value="<?php xl('Counseling for planning and decision making','e') ?>" /><?php xl(' Counseling for planning and decision making ','e') ?>
<input type="checkbox" name="msw_visit_note_interventions_including" <?php if ($obj{"msw_visit_note_interventions_including"} == "Psychological/Emotional Counseling") echo "checked";;?> value="<?php xl('Psychological/Emotional Counseling','e') ?>" /><?php xl(' Psychological/Emotional Counseling ','e') ?>
<input type="checkbox" name="msw_visit_note_interventions_including" <?php if ($obj{"msw_visit_note_interventions_including"} == "Identification and Reporting of Potential Abuse") echo "checked";;?> value="<?php xl('Identification and Reporting of Potential Abuse','e') ?>" /><?php xl(' Identification and Reporting of Potential Abuse ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_interventions_including_other" value="<?php echo stripslashes($obj{"msw_visit_note_interventions_including_other"});?>" /><br/>
<b><?php xl('Planning and Organization for: ','e') ?></b>
<input type="checkbox" name="msw_visit_note_planning_and_organization" <?php if ($obj{"msw_visit_note_planning_and_organization"} == "Arrangement of Meal Services") echo "checked";;?> value="<?php xl('Arrangement of Meal Services','e') ?>" /><?php xl(' Arrangement of Meal Services ','e') ?>
<input type="checkbox" name="msw_visit_note_planning_and_organization" <?php if ($obj{"msw_visit_note_planning_and_organization"} == "Eligibility for State/Federal Services and Benefits") echo "checked";;?> value="<?php xl('Eligibility for State/Federal Services and Benefits','e') ?>" /><?php xl(' Eligibility for State/Federal Services and Benefits ','e') ?>
<input type="checkbox" name="msw_visit_note_planning_and_organization" <?php if ($obj{"msw_visit_note_planning_and_organization"} == "Arrangement for Transportation to Medical/Community Services") echo "checked";;?> value="<?php xl('Arrangement for Transportation to Medical/Community Services','e') ?>" /><?php xl(' Arrangement for Transportation to Medical/Community Services ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" style="width : 90%;" name="msw_visit_note_planning_and_organization_other" value="<?php echo stripslashes($obj{"msw_visit_note_planning_and_organization_other"});?>" /><br/>
</td>
</tr>

<tr>
<td>
<b><?php xl('ADDITIONAL COMMENTS ','e')?></b><br/>
<textarea name="msw_visit_note_additional_comments" rows="3" cols="100"><?php echo stripslashes($obj{"msw_visit_note_additional_comments"});?></textarea>
</td>
</tr>

<tr>
<td>
<b><?php xl('MSW Visit was communicated to ','e')?></b>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" <?php if ($obj{"msw_visit_note_msw_visit_communicated_to"} == "Patient") echo "checked";;?> value="<?php xl('Patient','e') ?>" /><?php xl(' Patient ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" <?php if ($obj{"msw_visit_note_msw_visit_communicated_to"} == "Caregiver/Family") echo "checked";;?> value="<?php xl('Caregiver/Family','e') ?>" /><?php xl(' Caregiver/Family ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" <?php if ($obj{"msw_visit_note_msw_visit_communicated_to"} == "Physician") echo "checked";;?> value="<?php xl('Physician','e') ?>" /><?php xl(' Physician ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" <?php if ($obj{"msw_visit_note_msw_visit_communicated_to"} == "PT/OT/ST") echo "checked";;?> value="<?php xl('PT/OT/ST','e') ?>" /><?php xl(' PT/OT/ST ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" <?php if ($obj{"msw_visit_note_msw_visit_communicated_to"} == "Skilled Nursing") echo "checked";;?> value="<?php xl('Skilled Nursing','e') ?>" /><?php xl(' Skilled Nursing ','e') ?>
<input type="checkbox" name="msw_visit_note_msw_visit_communicated_to" <?php if ($obj{"msw_visit_note_msw_visit_communicated_to"} == "Case Manager") echo "checked";;?> value="<?php xl('Case Manager','e') ?>" /><?php xl(' Case Manager ','e') ?><br/>
<?php xl(' Other ','e') ?>
<input type="text" name="msw_visit_note_msw_visit_communicated_to_other" style="width : 49%;" value="<?php echo stripslashes($obj{"msw_visit_note_msw_visit_communicated_to_other"});?>" />
</td>
</tr>


<tr><td style="padding : 0px;">
<table cellspacing="0px" cellpadding="5px"  border="1px solid #000000" Style="border : 0px;" width="100%" class="formtable" ><tr>
<td style="sidth : 50%;"><b><?php xl('MSW ','e') ?></b><?php xl(' (Name and Title) ','e') ?></td>
<td style="sidth : 50%;"></td>
</tr></table>
</td></tr>
</table>

<a href="javascript:top.restoreSession();document.msw_visit_note.submit();" class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
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

	