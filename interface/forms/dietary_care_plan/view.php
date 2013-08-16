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
$formTable = "forms_dietary_care_plan";
if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();
?>
<html><head>
<title><?php xl('DIETARY CARE PLAN','e')?></title>
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
$obj = formFetch("forms_dietary_care_plan", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}
$cardio_teach = explode("#",$obj{"careplan_SN_CARDIO_Teach"});
$cardio_pcg_goals = explode("#",$obj{"careplan_SN_CARDIO_PtPcgGoals"});
$endo_assess = explode("#",$obj{"careplan_SN_ENDO_Assess"});
$endo_teach = explode("#",$obj{"careplan_SN_ENDO_Teach"});
$endo_perform = explode("#",$obj{"careplan_SN_ENDO_Perform"});
?>
<form method="post"		action="<?php echo $rootdir;?>/forms/dietary_care_plan/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="dietary_care_plan">
		<h3 align="center"><?php xl('DIETARY CARE PLAN','e')?></h3>
<table  class="formtable" cellspacing="0px" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" width="100%">
<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%"><tr>
<td align="center"><b><?php xl('Last Name','e')?></b></td>
<td><input style="width : 100%;" type="text" name="dietary_care_plan_last_name" value="<?php patientName("lname"); ?>" readonly/></td>
<td align="center"><b><?php xl('First Name','e')?></b></td>
<td><input style="width : 100%;" type="text" name="dietary_care_plan_first_name" value="<?php patientName("fname"); ?>" readonly/></td>

<td align="center"><b><?php xl('Start of Care Date','e')?></b></td>
<td>
<input type='text' size='20' title='Start of Care Date' name='dietary_care_plan_visit_date' id='dietary_care_plan_visit_date' value="<?php VisitDate(); ?>" readonly  />

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"dietary_care_plan_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr></table>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px" width="100%"><tr>
<td align="center"><b><?php xl('DOB','e')?></b></td>
<td><input type='text' size='10' name='dietary_care_plan_dob' id='dietary_care_plan_dob' value="<?php patientName("DOB"); ?>" readonly /></td>
<td align="center"><b><?php xl('Sex','e')?></b></td>
<td><input style="width : 52px;" type="text" name="dietary_care_plan_sex" value="<?php patientName("sex"); ?>" readonly/></td>
<td align="center"><b><?php xl('Weight','e')?></b></td>
<td><input type="text" name="dietary_care_plan_weight" value="<?php echo stripslashes($obj{"dietary_care_plan_weight"});?>"/></td>
<td align="center"><b><?php xl('Height','e')?></b></td>
<td><input type="text" name="dietary_care_plan_height" value="<?php echo stripslashes($obj{"dietary_care_plan_height"});?>"/></td>
</tr></table>
</td></tr>

<tr><td><font style="font-size: 13px;"><b><?php xl('DIAGNOSIS RELATED TO DIETARY ISSUES','e')?></b></font></td></tr>

<tr><td>
<b><?php xl('Frequency and Duration: ','e')?>
</b> <input type="text" style="width: 44%;" name="dietary_care_plan_frequency_and_duration" value="<?php echo stripslashes($obj{"dietary_care_plan_frequency_and_duration"});?>"/>
</td></tr>

<tr><td>
<b><?php xl('Short Term Goals','e')?></b><br/>
<textarea rows="3" cols="100" name="dietary_care_plan_short_term_goals"><?php echo stripslashes($obj{"dietary_care_plan_short_term_goals"});?></textarea>

</td></tr>

<tr><td>
<b><?php xl('Long Term Goals','e')?></b><br/>
<textarea rows="3" cols="100" name="dietary_care_plan_long_term_goals"><?php echo stripslashes($obj{"dietary_care_plan_long_term_goals"});?></textarea>
</td></tr>

<tr><td>
<b><?php xl('Treatment Plan','e')?></b><br/>
<textarea rows="3" cols="100" name="dietary_care_plan_treatment"><?php echo stripslashes($obj{"dietary_care_plan_treatment"});?></textarea>
</td></tr>

<tr><td style="padding : 0px;">
<table cellspacing="0px" cellpadding="5px" width="100%" border="1px solid #000000" Style="border : 0px;" class="formtable"><tr>
<td style="width : 25%;"><b><?php xl('RD Signature','e')?></b></td>
<td style="width : 25%;"></td>
<td style="width : 25%;"><b><?php xl('Date','e')?></b></td>
<td style="width : 25%;"></td>
</tr></table></td></tr>

</table>
<a href="javascript:top.restoreSession();document.dietary_care_plan.submit();"
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

	
