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
$formTable = "forms_dietary_visit";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

?>
<html><head>
<title><?php xl('DIETARY VISIT','e')?></title>
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
$obj = formFetch("forms_dietary_visit", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}
$cardio_teach = explode("#",$obj{"careplan_SN_CARDIO_Teach"});
$cardio_pcg_goals = explode("#",$obj{"careplan_SN_CARDIO_PtPcgGoals"});
$endo_assess = explode("#",$obj{"careplan_SN_ENDO_Assess"});
$endo_teach = explode("#",$obj{"careplan_SN_ENDO_Teach"});
$endo_perform = explode("#",$obj{"careplan_SN_ENDO_Perform"});
?>
<form method="post"		action="<?php echo $rootdir;?>/forms/dietary_visit/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="dietary_visit">
		<h3 align="center"><?php xl('DIETARY VISIT','e')?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr><td style="padding : 0px;">
<table border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%" class="formtable"><tr>
<td align="center"><b><?php xl('Last Name','e')?></b></td>
<td><input type="text" name="dietary_visit_last_name" value="<?php patientName("lname"); ?>" readonly /></td>
<td align="center"><b><?php xl('First Name','e')?></b></td>
<td><input type="text" name="dietary_visit_first_name" value="<?php patientName("fname"); ?>" readonly /></td>

<td align="center"><b><?php xl('Start of Care Date','e')?></b></td>
<td>
<input type='text' size='20' title='Start of Care Date' name='dietary_visit_visit_date' id='dietary_visit_visit_date' value="<?php VisitDate(); ?>" readonly  />

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"dietary_visit_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr></table></td></tr>

<tr><td><font style="font-size: 13px;"><b><?php xl('Reason for Visit','e') ?></font></b></td></tr>
<tr><td><b><?php xl('Change in dietary status since last visit or assessment?','e')?></b><br/>
<textarea name="dietary_visit_change_dietary_status_since_last_visit" rows="3" cols="100"><?php echo stripslashes($obj{"dietary_visit_change_dietary_status_since_last_visit"});?></textarea>
</td></tr>

<tr><td>
<b><?php xl('How much weight has the patient lost since the last visit/assessment?','e')?></b>
<input type="radio" name="dietary_visit_patient_weight_lost_since_last_visit" <?php if ($obj{"dietary_visit_patient_weight_lost_since_last_visit"} == "No loss") echo "checked";;?> value="<?php xl('No loss','e') ?>" /><?php xl(' No loss','e') ?>
<input type="radio" name="dietary_visit_patient_weight_lost_since_last_visit" <?php if ($obj{"dietary_visit_patient_weight_lost_since_last_visit"} == "5 lbs. or less") echo "checked";;?> value="<?php xl('5 lbs. or less','e') ?>" /><?php xl(' 5 lbs. or less','e') ?>
<input type="radio" name="dietary_visit_patient_weight_lost_since_last_visit" <?php if ($obj{"dietary_visit_patient_weight_lost_since_last_visit"} == "6-10 lbs.") echo "checked";;?> value="<?php xl('6-10 lbs.','e') ?>" /><?php xl(' 6-10 lbs.','e') ?>
<input type="radio" name="dietary_visit_patient_weight_lost_since_last_visit" <?php if ($obj{"dietary_visit_patient_weight_lost_since_last_visit"} == "11-20 lbs.") echo "checked";;?> value="<?php xl('11-20 lbs.','e') ?>" /><?php xl(' 11-20 lbs.','e') ?>
<input type="radio" name="dietary_visit_patient_weight_lost_since_last_visit" <?php if ($obj{"dietary_visit_patient_weight_lost_since_last_visit"} == "More than 20 lbs.") echo "checked";;?> value="<?php xl('More than 20 lbs.','e') ?>" /><?php xl(' More than 20 lbs. Other','e') ?> 
<input type="text" name="dietary_visit_patient_weight_lost_since_last_visit_others" value="<?php echo stripslashes($obj{"dietary_visit_patient_weight_lost_since_last_visit_others"});?>" >
</td></tr>

<tr><td>
<b><?php xl('Are there any new factors affecting the patients decline in weight?','e') ?></b>
<input type="radio" name="dietary_visit_new_factors_affecting_patient_weight" <?php if ($obj{"dietary_visit_new_factors_affecting_patient_weight"} == "Yes") echo "checked";;?> value="<?php xl('Yes','e') ?>" /><?php xl(' Yes','e') ?>
<input type="radio" name="dietary_visit_new_factors_affecting_patient_weight" <?php if ($obj{"dietary_visit_new_factors_affecting_patient_weight"} == "No") echo "checked";;?> value="<?php xl('No','e') ?>" /><?php xl(' No','e') ?><br/>
<b><?php xl('If Yes what are the factors?','e') ?> </b>
<input type="text" name="dietary_visit_new_affecting_factors" style="width: 43%;" value="<?php echo stripslashes($obj{"dietary_visit_new_affecting_factors"});?>" />
</td></tr>

<tr><td>
<b><?php xl('Assessment Summary','e')?></b><br/>
<textarea name="dietary_visit_assessment_summary" rows="3" cols="100"><?php echo stripslashes($obj{"dietary_visit_assessment_summary"});?></textarea>
</td></tr>

<tr><td>
<b><?php xl('Treatment Plan/Recommendations','e')?></b><br/>
<textarea name="dietary_visit_treatment_plan" rows="3" cols="100"><?php echo stripslashes($obj{"dietary_visit_treatment_plan"});?></textarea>
</td></tr>

<tr><td style="padding : 0px;">
<table border="1px solid #000000" Style="border : 0px;" width="100%" cellpadding="5px" cellspacing="0px" class="formtable"><tr>
<td style="width :25%;"><b><?php xl('RD Signature','e')?></b></td>
<td style="width :25%;"></td>
<td style="width :25%;"><b><?php xl('Date','e')?></b></td>
<td style="width :25%;"></td>
</tr></table>
</td></tr>
</table>		
<a href="javascript:top.restoreSession();document.dietary_visit.submit();"
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

	