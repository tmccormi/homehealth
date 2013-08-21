<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
include_once("$srcdir/api.inc");



$obj = formFetch("forms_clinical_summary", $_GET["id"]);

// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"|| strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";
    
$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_clinical_summary";

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
$obj = formFetch("forms_clinical_summary", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}
?>

<form method="post" action="<?php echo $rootdir;?>/forms/clinical_summary/save.php?mode=update&&id=<?php echo $_GET['id']; ?>" name="clinical_summary">
<h3 align="center"><?php xl('CLINICAL SUMMARY','e') ?></h3>


<table class="formtable" width="100%" border="0">
<TR valign="top">
<TD>
<u><?php xl('Patient Chart','e') ?></u>
<b><?php xl('Notes','e') ?></b><br />
<textarea name="clinical_summary_notes" rows="2" cols="30">
<?php echo $obj{"clinical_summary_notes"}; ?>
</textarea><br />
</TD>
<TD align="right">
<?php xl('(Select an Action)','e') ?><br />
</TD>
</TR>
<tr>
<td>
<b><?php xl('Patient:','e') ?></b>
<input type="text" name="clinical_summary_patient_name" size="40" 
 value="<?php echo $obj{"clinical_summary_patient_name"}; ?>"
 readonly="readonly"  /><br />
<b><?php xl('Chart:','e') ?></b>
<input type="text" name="clinical_summary_chart" value="<?php echo $obj{"clinical_summary_chart"}; ?>" size="10" />
<b><?php xl('Episode:','e') ?></b>
<input type="text" name="clinical_summary_episode" 
 value="<?php echo $obj{"clinical_summary_episode"}; ?>" 
size="10" />
</td>

<td align="right">
<b><?php xl('Caregiver:','e') ?></b>
<input type="text" name="clinical_summary_caregiver_name" size="25"  value="<?php echo $obj{"clinical_summary_caregiver_name"}; ?>" />

<strong><?php xl('Start of Care Date:','e') ?></strong>
<input type="text" size="12" name="clinical_summary_visit_date" id="clinical_summary_visit_date" value="<?php echo $obj{"clinical_summary_visit_date"}; ?>"  readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"clinical_summary_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

</tr>
</TABLE>


<table class="formtable" width="100%" border="1" cellpadding="5px" cellspacing="0px">

<tr>
<td>
<center><b><?php xl('Background Information','e') ?></b></center>

<?php xl('Case Manager:','e') ?>
<select name="clinical_summary_case_manager" id="clinical_summary_case_manager">
<?php physicianNameDropDown(stripslashes($obj{"clinical_summary_case_manager"}))?>
</select>
<br />

<?php xl('This is a ','e') ?>
<input type="text" name="clinical_summary_age"  value="<?php echo $obj{"clinical_summary_age"}; ?>"  size="10" />
<?php xl(' year old ','e') ?>
<label><input type="radio" name="clinical_summary_gender" value="Male"  id="clinical_summary_gender" <?php if($obj{"clinical_summary_gender"}=="Male") echo "checked"; ?>  /> <?php xl('Male','e')?></label>
<label><input type="radio" name="clinical_summary_gender" value="Female"  id="clinical_summary_gender" <?php if($obj{"clinical_summary_gender"}=="Female") echo "checked"; ?>  /> <?php xl('Female','e')?></label>
<?php xl(' with ','e') ?>
<input type="text" name="clinical_summary_hospitalization" value="<?php echo $obj{"clinical_summary_hospitalization"}; ?>" size="10" />
<?php xl(' recent hospitalizations.','e') ?><br />
<?php xl('Patient recently admitted to hospital/ rehab facility on ','e') ?>
<input type='text' size='10' name='clinical_summary_admission_date' id='clinical_summary_admission_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
 value="<?php echo $obj{"clinical_summary_admission_date"}; ?>"  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"clinical_summary_admission_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
<?php xl(' for ','e') ?>
<input type="text" name="clinical_summary_hospitalization_reason" size="60%" value="<?php echo $obj{"clinical_summary_hospitalization_reason"}; ?>"  />
<br />
<?php xl('Patient referred to home health by MD for','e') ?>
<input type="text" name="clinical_summary_reffered_reason" size="60%"  value="<?php echo $obj{"clinical_summary_reffered_reason"}; ?>"  />
<br /><br />
<label><input type="radio" name="clinical_summary_homebound" value="Patient is homebound due to:"  id="clinical_summary_homebound" 
<?php if($obj{"clinical_summary_homebound"}=="Patient is homebound due to:") echo "checked"; ?>  /> <?php xl('Patient is homebound due to:','e')?></label>
<input type="text" name="clinical_summary_homebound_due_to" size="60%"  value="<?php echo $obj{"clinical_summary_homebound_due_to"}; ?>" /><br />

<label><input type="radio" name="clinical_summary_homebound" value="Patient is NOT homebound - PAYOR SOURCE AWARE"  id="clinical_summary_homebound" <?php if($obj{"clinical_summary_homebound"}=="Patient is NOT homebound - PAYOR SOURCE AWARE") echo "checked"; ?>  /> <?php xl('Patient is NOT homebound - PAYOR SOURCE AWARE','e')?></label>
<BR />
<br />

<center><b><?php xl('Current Information','e') ?></b></center>
<b><?php xl('Patient\'s Current Condition/History of Illness: ','e') ?></b>
<?php xl('(Include pain status, exacerbations, tolerance for activity, cognition, wound sizes and description, neuro-motor deficits)','e') ?>
<br />
<textarea name="clinical_summary_patient_current_condition" rows="4" cols="98">
<?php echo $obj{"clinical_summary_patient_current_condition"}; ?>
</textarea><br />
<br />
<b><?php xl('Skilled Nurse Needed for: ','e') ?></b><br />

<?php xl('Teaching/Training r/t:','e') ?>
<br />
<textarea name="clinical_summary_teaching_training" rows="4" cols="98">
<?php echo $obj{"clinical_summary_teaching_training"}; ?>
</textarea><br />

<?php xl('Observation/Assessment r/t:','e') ?>
<br />
<textarea name="clinical_summary_observation_assessment" rows="4" cols="98">
<?php echo $obj{"clinical_summary_observation_assessment"}; ?>
</textarea><br />

<?php xl('Treatment of:','e') ?>
<br />
<textarea name="clinical_summary_treatment_of" rows="4" cols="98">
<?php echo $obj{"clinical_summary_treatment_of"}; ?>
</textarea><br />

<?php xl('Case Management and Evaluation of:','e') ?>
<br />
<textarea name="clinical_summary_case_management" rows="4" cols="98">
<?php echo $obj{"clinical_summary_case_management"}; ?>
</textarea><br />


<?php xl('Patient has able and willing caregiver?:','e') ?>
<label><input type="radio" name="clinical_summary_willing_caregiver" value="Yes"  id="clinical_summary_willing_caregiver" <?php if($obj{"clinical_summary_willing_caregiver"}=="Yes") echo "checked"; ?>  />
<?php xl('Yes','e')?></label>
<label><input type="radio" name="clinical_summary_willing_caregiver" value="No"  id="clinical_summary_willing_caregiver" <?php if($obj{"clinical_summary_willing_caregiver"}=="No") echo "checked"; ?>  />
<?php xl('No','e')?></label>


</TD>
</tr>

<tr>
<TD>
<b><?php xl('Caregiver Signature:','e') ?></b>
<input type="text" name="clinical_summary_caregiver_sign" size="40" value="<?php echo $obj{"clinical_summary_caregiver_sign"}; ?>" />
</TD>
</tr>

</table>



<a href="javascript:top.restoreSession();document.clinical_summary.submit();"
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

	
