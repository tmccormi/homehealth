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
$formTable = "forms_dietary_assessment";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

?>
<html><head>
<title><?php xl('DIETARY ASSESSMENT','e')?></title>
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
$obj = formFetch("forms_dietary_assessment", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}
$cardio_teach = explode("#",$obj{"careplan_SN_CARDIO_Teach"});
$cardio_pcg_goals = explode("#",$obj{"careplan_SN_CARDIO_PtPcgGoals"});
$endo_assess = explode("#",$obj{"careplan_SN_ENDO_Assess"});
$endo_teach = explode("#",$obj{"careplan_SN_ENDO_Teach"});
$endo_perform = explode("#",$obj{"careplan_SN_ENDO_Perform"});
?>
<form method="post"		action="<?php echo $rootdir;?>/forms/dietary_assessment/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="dietary_assessment">
		<h3 align="center"><?php xl('DIETARY ASSESSMENT','e')?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;"  cellpadding="5px" cellspacing="0px">
<tr><td style="padding : 0px;">
<table class="formtable" width="100%"  border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr><td align="center"><b><?php xl('Last Name','e') ?></b></td>
<td><input type="text" style="width : 100%;" name="dietary_assessment_last_name" value="<?php patientName("lname"); ?>" readonly /></td>
<td align="center"><b><?php xl('First Name','e') ?></b></td>
<td><input type="text" style="width : 100%;" name="dietary_assessment_first_name" value="<?php patientName("fname"); ?>" readonly/></td>

<td align="center"><b><?php xl('Start of Care Date','e') ?></b></td>
<td>
<input type='text' size="20" name='dietary_assessment_visit_date' id='dietary_assessment_visit_date' value="<?php VisitDate(); ?>" readonly  />

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"dietary_assessment_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr>
</table>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%"  border="1px solid #000000" Style="border : 0px;"  cellpadding="5px" cellspacing="0px">
<tr><td align="center"><b><?php xl('DOB','e') ?></b></td>
<td><input type='text' size='10' name='dietary_assessment_dob' id='dietary_assessment_dob' value="<?php patientName("DOB"); ?>" readonly />
				</td>
<td align="center"><b><?php xl('Sex','e') ?></b></td>
<td><input type="text" name="dietary_assessment_sex" style="width : 52px;" value="<?php patientName("sex"); ?>" readonly /></td>
<td align="center"><b><?php xl('Weight','e') ?></b></td>
<td><input type="text" name="dietary_assessment_weight" value="<?php echo stripslashes($obj{"dietary_assessment_weight"});?>" /></td>
<td align="center"><b><?php xl('Height','e') ?></b></td>
<td><input type="text" name="dietary_assessment_height" value="<?php echo stripslashes($obj{"dietary_assessment_height"});?>" /></td></tr>
</table>
</td></tr>

<tr><td><b><?php xl('Reason for Referral','e') ?><b></td></tr>
<tr><td>
<b><?php xl('How much of a decline in food intake has occurred over the past 3 months due to loss of appetite, digestive problems, chewing or swallowing difficulties?','e') ?>
</b><br/>
<input type="checkbox" name="dietary_assessment_food_intake_occurred_past3month" <?php if ($obj{"dietary_assessment_food_intake_occurred_past3month"} == "severe decrease in food intake") echo "checked";;?> value="<?php xl('severe decrease in food intake','e') ?>"/><?php xl(' Severe decrease in food intake ', 'e') ?>
<input type="checkbox" name="dietary_assessment_food_intake_occurred_past3month" <?php if ($obj{"dietary_assessment_food_intake_occurred_past3month"} == "moderate decrease in food intake") echo "checked";;?> value="<?php xl('moderate decrease in food intake','e') ?>"/><?php xl(' Moderate decrease in food intake ', 'e') ?>
<input type="checkbox" name="dietary_assessment_food_intake_occurred_past3month" <?php if ($obj{"dietary_assessment_food_intake_occurred_past3month"} == "no decrease in food intake") echo "checked";;?> value="<?php xl('no decrease in food intake','e') ?>"/><?php xl(' No decrease in food intake ', 'e') ?>
</td></tr>

<tr><td><b><?php xl('How much weight has the patient lost over the last 3 months?','e') ?></b>
<input type="checkbox" name="dietary_assessment_lost_weight_past3month" <?php if ($obj{"dietary_assessment_lost_weight_past3month"} == "No loss") echo "checked";;?> value="<?php xl('No loss','e') ?>"/><?php xl(' No loss ', 'e') ?>
<input type="checkbox" name="dietary_assessment_lost_weight_past3month" <?php if ($obj{"dietary_assessment_lost_weight_past3month"} == "5 lbs. or less") echo "checked";;?> value="<?php xl('5 lbs. or less','e') ?>"/><?php xl(' 5 lbs. or less ', 'e') ?>
<input type="checkbox" name="dietary_assessment_lost_weight_past3month" <?php if ($obj{"dietary_assessment_lost_weight_past3month"} == "6-10 lbs.") echo "checked";;?> value="<?php xl('6-10 lbs.','e') ?>"/><?php xl(' 6-10 lbs. ', 'e') ?>
<input type="checkbox" name="dietary_assessment_lost_weight_past3month" <?php if ($obj{"dietary_assessment_lost_weight_past3month"} == "11-20 lbs.") echo "checked";;?> value="<?php xl('11-20 lbs.','e') ?>"/><?php xl(' 11-20 lbs. ', 'e') ?>
<input type="checkbox" name="dietary_assessment_lost_weight_past3month" <?php if ($obj{"dietary_assessment_lost_weight_past3month"} == "More than 20 lbs.") echo "checked";;?> value="<?php xl('More than 20 lbs.','e') ?>"/><?php xl(' More than 20 lbs. ', 'e') ?>
<br/><?php xl(' Other ', 'e') ?> <input type="text" name="dietary_assessment_lost_weight_past3month_other" size="70px" value="<?php echo stripslashes($obj{"dietary_assessment_lost_weight_past3month_other"});?>" /> 
</td></tr>

<tr><td>
<b><?php xl('What are the factors affecting a decline in food intake?','e') ?></b>
<input type="checkbox" name="dietary_assessment_factors_affecting_food_intake" <?php if ($obj{"dietary_assessment_factors_affecting_food_intake"} == "Digestive Disorder") echo "checked";;?> value="<?php xl('Digestive Disorder','e') ?>"/><?php xl(' Digestive Disorder', 'e') ?>&nbsp; &nbsp;
<?php xl(' Specify ','e') ?> <input type="text" name="dietary_assessment_factors_affecting_food_intake_specify" value="<?php echo stripslashes($obj{"dietary_assessment_factors_affecting_food_intake_specify"});?>" /> &nbsp; &nbsp;
<input type="checkbox" name="dietary_assessment_factors_affecting_food_intake" <?php if ($obj{"dietary_assessment_factors_affecting_food_intake"} == "Dysphagia/Swallowing Difficulties") echo "checked";;?> value="<?php xl('Dysphagia/Swallowing Difficulties','e') ?>"/><?php xl(' Dysphagia/Swallowing Difficulties ', 'e') ?>
<input type="checkbox" name="dietary_assessment_factors_affecting_food_intake" <?php if ($obj{"dietary_assessment_factors_affecting_food_intake"} == "Nausea/Vomiting") echo "checked";;?> value="<?php xl('Nausea/Vomiting','e') ?>"/><?php xl(' Nausea/Vomiting', 'e') ?>
<input type="checkbox" name="dietary_assessment_factors_affecting_food_intake" <?php if ($obj{"dietary_assessment_factors_affecting_food_intake"} == "Emotional/Psychosocial Issues") echo "checked";;?> value="<?php xl('Emotional/Psychosocial Issues','e') ?>"/><?php xl(' Emotional/Psychosocial Issues ', 'e') ?>
<input type="checkbox" name="dietary_assessment_factors_affecting_food_intake" <?php if ($obj{"dietary_assessment_factors_affecting_food_intake"} == "Oral Hygiene/ Dental Care") echo "checked";;?> value="<?php xl('Oral Hygiene/ Dental Care','e') ?>"/><?php xl(' Oral Hygiene/ Dental Care ', 'e') ?>
<br/><input type="checkbox" name="dietary_assessment_factors_affecting_food_intake" <?php if ($obj{"dietary_assessment_factors_affecting_food_intake"} == "Environment for meals") echo "checked";;?> value="<?php xl('Environment for meals','e') ?>"/><?php xl(' Environment for meals ', 'e') ?>
<input type="checkbox" name="dietary_assessment_factors_affecting_food_intake" <?php if ($obj{"dietary_assessment_factors_affecting_food_intake"} == "Cognitive/Dementia Problems") echo "checked";;?> value="<?php xl('Cognitive/Dementia Problems','e') ?>"/><?php xl(' Cognitive/Dementia Problems ', 'e') ?>
<input type="checkbox" name="dietary_assessment_factors_affecting_food_intake" <?php if ($obj{"dietary_assessment_factors_affecting_food_intake"} == "Diarrhea/Constipation") echo "checked";;?> value="<?php xl('Diarrhea/Constipation','e') ?>"/><?php xl(' Diarrhea/Constipation ', 'e') ?>
<?php xl(' Other ', 'e') ?> <input type="text" name="dietary_assessment_factors_affecting_food_intake_other" size="70px" value="<?php echo stripslashes($obj{"dietary_assessment_factors_affecting_food_intake_other"});?>" />
</td></tr>

<tr><td><b>
<?php xl('What is patients mobility status?','e') ?></b>
<input type="checkbox" name="dietary_assessment_patient_mobility_status" <?php if ($obj{"dietary_assessment_patient_mobility_status"} == "Bed/Wheelchair Bound") echo "checked";;?> value="<?php xl('Bed/Wheelchair Bound','e') ?>"/><?php xl(' Bed/Wheelchair Bound ', 'e') ?>
<input type="checkbox" name="dietary_assessment_patient_mobility_status" <?php if ($obj{"dietary_assessment_patient_mobility_status"} == "Able to get out of bed but chooses not to") echo "checked";;?> value="<?php xl('Able to get out of bed but chooses not to','e') ?>"/><?php xl(' Able to get out of bed but chooses not to ', 'e') ?>
<input type="checkbox" name="dietary_assessment_patient_mobility_status" <?php if ($obj{"dietary_assessment_patient_mobility_status"} == "Able to Walk") echo "checked";;?> value="<?php xl('Able to Walk','e') ?>"/><?php xl(' Able to Walk ', 'e') ?>
</td></tr>

<tr><td>
<b><?php xl('Number of Different Medications Taken a Day?','e') ?></b>
<input type="checkbox" name="dietary_assessment_different_medications_per_day" <?php if ($obj{"dietary_assessment_different_medications_per_day"} == "0") echo "checked";;?> value="<?php xl('0','e') ?>"/><?php xl(' 0 ', 'e') ?>
<input type="checkbox" name="dietary_assessment_different_medications_per_day" <?php if ($obj{"dietary_assessment_different_medications_per_day"} == "1-3") echo "checked";;?> value="<?php xl('1-3','e') ?>"/><?php xl(' 1-3 ', 'e') ?>
<input type="checkbox" name="dietary_assessment_different_medications_per_day" <?php if ($obj{"dietary_assessment_different_medications_per_day"} == "4-8") echo "checked";;?> value="<?php xl('4-8','e') ?>"/><?php xl(' 4-8 ', 'e') ?>
<input type="checkbox" name="dietary_assessment_different_medications_per_day" <?php if ($obj{"dietary_assessment_different_medications_per_day"} == "9 or more") echo "checked";;?> value="<?php xl('9 or more','e') ?>"/><?php xl(' 9 or more ', 'e') ?>
</td></tr>

<tr><td>
<b><?php xl('Pressure Ulcers Present','e') ?></b>
<input type="checkbox" name="dietary_assessment_pressure_ulcers_present" <?php if ($obj{"dietary_assessment_pressure_ulcers_present"} == "0") echo "checked";;?> value="<?php xl('0','e') ?>"/><?php xl(' 0 ', 'e') ?>
<input type="checkbox" name="dietary_assessment_pressure_ulcers_present" <?php if ($obj{"dietary_assessment_pressure_ulcers_present"} == "1-3") echo "checked";;?> value="<?php xl('1-3','e') ?>"/><?php xl(' 1-3 ', 'e') ?>
<input type="checkbox" name="dietary_assessment_pressure_ulcers_present" <?php if ($obj{"dietary_assessment_pressure_ulcers_present"} == "more than 3") echo "checked";;?> value="<?php xl('more than 3','e') ?>"/><?php xl(' more than 3 ', 'e') ?><br/>
<b><?php xl('Stage of Ulcers','e') ?></b>
<input type="checkbox" name="dietary_assessment_stage_ulcers" <?php if ($obj{"dietary_assessment_stage_ulcers"} == "Stage 1") echo "checked";;?> value="<?php xl('Stage 1','e') ?>"/><?php xl(' Stage 1 ', 'e') ?>
<input type="checkbox" name="dietary_assessment_stage_ulcers" <?php if ($obj{"dietary_assessment_stage_ulcers"} == "Stage 2") echo "checked";;?> value="<?php xl('Stage 2','e') ?>"/><?php xl(' Stage 2 ', 'e') ?>
<input type="checkbox" name="dietary_assessment_stage_ulcers" <?php if ($obj{"dietary_assessment_stage_ulcers"} == "Stage 3") echo "checked";;?> value="<?php xl('Stage 3','e') ?>"/><?php xl(' Stage 3 ', 'e') ?>
<input type="checkbox" name="dietary_assessment_stage_ulcers" <?php if ($obj{"dietary_assessment_stage_ulcers"} == "Stage 4") echo "checked";;?> value="<?php xl('Stage 4','e') ?>"/><?php xl(' Stage 4 ', 'e') ?>
</td></tr>

<tr><td>
<b><?php xl('How many full meals does the patient eat daily?','e') ?></b>
<input type="checkbox" name="dietary_assessment_full_meals_per_day" <?php if ($obj{"dietary_assessment_full_meals_per_day"} == "0") echo "checked";;?> value="<?php xl('0','e') ?>"/><?php xl(' 0', 'e') ?>
<input type="checkbox" name="dietary_assessment_full_meals_per_day" <?php if ($obj{"dietary_assessment_full_meals_per_day"} == "1") echo "checked";;?> value="<?php xl('1','e') ?>"/><?php xl(' 1', 'e') ?>
<input type="checkbox" name="dietary_assessment_full_meals_per_day" <?php if ($obj{"dietary_assessment_full_meals_per_day"} == "2") echo "checked";;?> value="<?php xl('2','e') ?>"/><?php xl(' 2', 'e') ?>
<input type="checkbox" name="dietary_assessment_full_meals_per_day" <?php if ($obj{"dietary_assessment_full_meals_per_day"} == "3") echo "checked";;?> value="<?php xl('3','e') ?>"/><?php xl(' 3', 'e') ?>
</td></tr>

<tr><td>
<b><?php xl('How much assistance does the patient require to feed self?','e') ?></b>
<input type="checkbox" name="dietary_assessment_assistance_patient_require_feed_self" <?php if ($obj{"dietary_assessment_assistance_patient_require_feed_self"} == "unable to feed self without assistance") echo "checked";;?> value="<?php xl('unable to feed self without assistance','e') ?>" /><?php xl(' Unable to feed self without assistance', 'e') ?>
<input type="checkbox" name="dietary_assessment_assistance_patient_require_feed_self" <?php if ($obj{"dietary_assessment_assistance_patient_require_feed_self"} == "can feed self but needs reminders") echo "checked";;?> value="<?php xl('can feed self but needs reminders','e') ?>"/><?php xl(' Can feed self but needs reminders', 'e') ?>
<input type="checkbox" name="dietary_assessment_assistance_patient_require_feed_self" <?php if ($obj{"dietary_assessment_assistance_patient_require_feed_self"} == "can feed self independently") echo "checked";;?> value="<?php xl('can feed self independently','e') ?>"/><?php xl(' Can feed self independently', 'e') ?>
</td></tr>

<tr><td>
<b><?php xl('In the past what were the patients favorite foods/drink?','e') ?></b><br/>
<textarea name="dietary_assessment_past_food_drink" rows="3" cols="100"><?php echo stripslashes($obj{"dietary_assessment_past_food_drink"});?></textarea>
</td></tr>

<tr><td>
<b><?php xl('List Allergies and Food Sensitivities','e') ?></b><br/>
<textarea name="dietary_assessment_allergies_and_food_sensitivities" rows="3" cols="100" ><?php echo stripslashes($obj{"dietary_assessment_allergies_and_food_sensitivities"});?></textarea>
</td></tr>

<tr><td>
<b><?php xl('Dietary Foods the patient dislikes','e') ?></b><br/>
<textarea name="dietary_assessment_dietary_foods_patient_dislikes" rows="3" cols="100"><?php echo stripslashes($obj{"dietary_assessment_dietary_foods_patient_dislikes"});?></textarea>
</td></tr>

<tr><td>
<b><?php xl('Assessment Summary','e') ?></b><br/>
<textarea name="dietary_assessment_assessment_summary" rows="3" cols="100"><?php echo stripslashes($obj{"dietary_assessment_assessment_summary"});?></textarea>
</td></tr>

<tr><td>
<b><?php xl('Treatment Plan/Recommendations','e') ?></b><br/>
<textarea name="dietary_assessment_treatmentplan_recommendations" rows="3" cols="100"><?php echo stripslashes($obj{"dietary_assessment_treatmentplan_recommendations"});?></textarea>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" border="1px solid #000000" Style="border : 0px;" cellpadding="2px" cellspacing="0px" width="100%">
<tr><td style="width : 25%;"><b><?php xl('RD Signature','e') ?></b></td>
<td  style="width : 25%;"></td>
<td  style="width : 25%;"><b><?php xl('Date','e') ?></b></td>
<td  style="width : 25%;"></td></tr>
<tr><td><b><?php xl('Physician Signature','e') ?></b></td>
<td></td>
<td><b><?php xl('Date','e') ?></b></td></td>
<td></td></tr>
</table>
</td></tr>
</table>
<a href="javascript:top.restoreSession();document.dietary_assessment.submit();"
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

	