<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
include_once("$srcdir/api.inc");



$obj = formFetch("forms_incident_report", $_GET["id"]);


$incident_report_patient_related = explode("#",$obj{"incident_report_patient_related"});
$incident_report_notifications = explode("#",$obj{"incident_report_notifications"});


// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"|| strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";
    
$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_incident_report";

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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
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
$obj = formFetch("forms_incident_report", $_GET["id"]);
?>

<form method="post" action="<?php echo $rootdir;?>/forms/incident_report/save.php?mode=update&&id=<?php echo $_GET['id']; ?>" name="incident_report">
<h3 align="center"><?php xl('INCIDENT REPORT','e') ?></h3>


<table class="formtable" width="100%" border="0">
<TR valign="top">
<TD>
<b><?php xl('Notes','e') ?></b><br />
<textarea name="incident_report_notes" rows="2" cols="30">
<?php echo stripslashes($obj{"incident_report_notes"});?></textarea><br />
</TD>
<TD align="right">
<?php xl('(Select an Action)','e') ?><br /><br />
<b><?php xl('Caregiver:','e') ?></b>
<input type="text" name="incident_report_caregiver_name" size="30" value='<?php echo stripslashes($obj{"incident_report_caregiver_name"});?>'  />
<b><?php xl('Visit Date:','e') ?></b>
<input type="text" name="incident_visit_date" value="<?php echo stripslashes($obj{"incident_visit_date"});?>" readonly/>
</TD>
</tr>
</TABLE>


<table class="formtable" width="100%" border="1" cellpadding="5px" cellspacing="0px">
<tr>
<td colspan="2">

<b><?php xl('Patient\'s  Name:','e') ?></b>
<input type="text" name="incident_report_patient_name" size="50" value="<?php patientName(); ?>" readonly="readonly"  /><br />
</td>
</tr>
<tr><TD>
<b><?php xl('Date of Report:','e') ?></b>
<input type='text' size='10' name='incident_report_date' id='incident_report_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
					value='<?php echo stripslashes($obj{"incident_report_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>

</TD>
<td>
<b><?php xl('Date of Occurence:','e') ?></b>
<input type='text' size='10' name='incident_report_occurance_date' id='incident_report_occurance_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
					value='<?php echo stripslashes($obj{"incident_report_occurance_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date2' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_occurance_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
</td>


</tr>

<tr><TD colspan="2">



<b><?php xl('Patient Related:','e') ?></b><br />
<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('injury','e')?>" 
<?php if(in_array("injury",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('injury','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('fall/safety concern','e')?>" 
<?php if(in_array("fall/safety concern",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('fall/safety concern','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('medication error','e')?>" 
<?php if(in_array("medication error",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('medication error','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('suspected abuse','e')?>" 
<?php if(in_array("suspected abuse",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('suspected abuse','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('potential communicable disease','e')?>" 
<?php if(in_array("potential communicable disease",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('potential communicable disease','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('adverse/allergic drug reaction','e')?>" 
<?php if(in_array("adverse/allergic drug reaction",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('adverse/allergic drug reaction','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('pharmacy/equipment/delivery error','e')?>" 
<?php if(in_array("pharmacy/equipment/delivery error",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('pharmacy/equipment/delivery error','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('venous access infection/sepsis','e')?>" 
<?php if(in_array("venous access infection/sepsis",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('venous access infection/sepsis','e')?> </label><br />

<label> <input type="checkbox" name="incident_report_patient_related[]" value="<?php xl('Other:','e')?>" 
<?php if(in_array("Other:",$incident_report_patient_related)) echo "checked"; ?> />
<?php xl('Other:','e')?> </label>
<input type="text" name="incident_report_patient_related_other" size="70%" 
value='<?php echo stripslashes($obj{"incident_report_patient_related_other"});?>' />

</TD>
</tr>
<tr><TD colspan="2">
<b><?php xl('Description of Occurence','e') ?></b><br />
<textarea name="incident_report_description_occurence" rows="4" cols="98">
<?php echo stripslashes($obj{"incident_report_description_occurence"});?>
</textarea>
<br />
<b><?php xl('Attach additional documentation as needed.','e') ?></b>
</TD></tr>

<tr>
<TD>
<b><?php xl('Notifications:','e') ?></b><br />
<label> <input type="checkbox" name="incident_report_notifications[]" value="<?php xl('Physician Name:','e')?>" 
<?php if(in_array("Physician Name:",$incident_report_notifications)) echo "checked"; ?> />
<?php xl('Physician Name:','e')?> </label>
<input type="text" name="incident_report_not_physician_name" size="30%" 
value='<?php echo stripslashes($obj{"incident_report_not_physician_name"});?>'  />
</TD>
<td>
<?php xl('Date/Time:','e') ?>
<input type='text' size='10' name='incident_report_not_physician_date' id='incident_report_not_physician_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
value='<?php echo stripslashes($obj{"incident_report_not_physician_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date3' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_not_physician_date", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
   </script>
</td>
</tr>

<tr>
<TD>
<label> <input type="checkbox" name="incident_report_notifications[]" value="<?php xl('Clinical Supervisor Name:','e')?>" 
<?php if(in_array("Clinical Supervisor Name:",$incident_report_notifications)) echo "checked"; ?> />
<?php xl('Clinical Supervisor Name:','e')?> </label>
<input type="text" name="incident_report_not_supervisor_name" size="30%" 
value='<?php echo stripslashes($obj{"incident_report_not_supervisor_name"});?>'  />
</TD>
<td>
<?php xl('Date/Time:','e') ?>
<input type='text' size='10' name='incident_report_not_supervisor_date' id='incident_report_not_supervisor_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
value='<?php echo stripslashes($obj{"incident_report_not_supervisor_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date4' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_not_supervisor_date", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
   </script>
</td>
</tr>

<tr>
<TD>
<label> <input type="checkbox" name="incident_report_notifications[]" value="<?php xl('Family/Caregiver Name:','e')?>" 
<?php if(in_array("Family/Caregiver Name:",$incident_report_notifications)) echo "checked"; ?> />
<?php xl('Family/Caregiver Name:','e')?> </label>
<input type="text" name="incident_report_not_caregiver_name" size="30%" 
value='<?php echo stripslashes($obj{"incident_report_not_caregiver_name"});?>'  />
</TD>
<td>
<?php xl('Date/Time:','e') ?>
<input type='text' size='10' name='incident_report_not_caregiver_date' id='incident_report_not_caregiver_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
value='<?php echo stripslashes($obj{"incident_report_not_caregiver_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date5' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_not_caregiver_date", ifFormat:"%Y-%m-%d", button:"img_curr_date5"});
   </script>
</td>
</tr>

<tr>
<TD>
<label> <input type="checkbox" name="incident_report_notifications[]" value="<?php xl('Administrative Manager Name:','e')?>" 
<?php if(in_array("Administrative Manager Name:",$incident_report_notifications)) echo "checked"; ?> />
<?php xl('Administrative Manager Name:','e')?> </label>
<input type="text" name="incident_report_not_manager_name" size="30%" 
value='<?php echo stripslashes($obj{"incident_report_not_manager_name"});?>'  />
</TD>
<td>
<?php xl('Date/Time:','e') ?>
<input type='text' size='10' name='incident_report_not_manager_date' id='incident_report_not_manager_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
value='<?php echo stripslashes($obj{"incident_report_not_manager_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date6' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_not_manager_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6"});
   </script>
</td>
</tr>

<tr><TD colspan="2">
<b><?php xl('Physician Orders Received:','e')?></b>
<input type="text" name="incident_report_physician_orders" size="60%" 
value='<?php echo stripslashes($obj{"incident_report_physician_orders"});?>'  /><br />

<b><?php xl('Other actions taken:','e')?></b><br />
<textarea name="incident_report_other_actions_taken" rows="4" cols="98">
<?php echo stripslashes($obj{"incident_report_other_actions_taken"});?></textarea><br />

<b><?php xl('Administrative Review/Plan:','e')?></b><br />
<textarea name="incident_report_administrative_review" rows="4" cols="98">
<?php echo stripslashes($obj{"incident_report_administrative_review"});?></textarea>
</TD></tr>

<tr>
<TD>
<b><?php xl('Signature:','e')?></b><br />
<?php xl('Person Filing Report:','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="incident_report_person_filing_report" size="30%" 
value='<?php echo stripslashes($obj{"incident_report_person_filing_report"});?>'  /><br />
</TD>
<TD>

<?php xl('Date:','e') ?>
<input type='text' size='10' name='incident_report_filing_report_date' id='incident_report_filing_report_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
value='<?php echo stripslashes($obj{"incident_report_filing_report_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date7' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_filing_report_date", ifFormat:"%Y-%m-%d", button:"img_curr_date7"});
   </script>
</TD>

</tr>



<tr>
<TD>
<?php xl('Management Reviewer:','e')?>&nbsp;&nbsp;&nbsp;
<input type="text" name="incident_report_management_reviewer" size="30%" 
value='<?php echo stripslashes($obj{"incident_report_management_reviewer"});?>'  /><br />
</TD>
<TD>

<?php xl('Date:','e') ?>
<input type='text' size='10' name='incident_report_management_reviewer_date' id='incident_report_management_reviewer_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
value='<?php echo stripslashes($obj{"incident_report_management_reviewer_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date8' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_management_reviewer_date", ifFormat:"%Y-%m-%d", button:"img_curr_date8"});
   </script>
</TD>

</tr>


<tr>
<TD>
<?php xl('Administrative Reviewer:','e')?>&nbsp;
<input type="text" name="incident_report_admin_reviewer" size="30%" 
value='<?php echo stripslashes($obj{"incident_report_admin_reviewer"});?>'  /><br />
</TD>
<TD>

<?php xl('Date:','e') ?>
<input type='text' size='10' name='incident_report_admin_reviewer_date' id='incident_report_admin_reviewer_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
value='<?php echo stripslashes($obj{"incident_report_admin_reviewer_date"});?>'  readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date9' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_admin_reviewer_date", ifFormat:"%Y-%m-%d", button:"img_curr_date9"});
   </script>
</TD>

</tr>

<tr><TD colspan="2">
<?php xl('Caregiver Signature:','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="text" name="incident_report_caregiver_sign" size="30%" value='<?php echo stripslashes($obj{"incident_report_caregiver_sign"});?>'  />

<input type='text' size='10' name='incident_report_caregiver_sign_date' id='incident_report_caregiver_sign_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
value='<?php echo stripslashes($obj{"incident_report_caregiver_sign_date"});?>' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date10' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"incident_report_caregiver_sign_date", ifFormat:"%Y-%m-%d", button:"img_curr_date10"});
   </script>







</TD></tr>

</table>



<a href="javascript:top.restoreSession();document.incident_report.submit();"
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
                    <input type="button" value="Back" onclick="top.restoreSession();window.location='<?php echo $GLOBALS['webroot'] ?>/interface/patient_file/encounter/encounter_top.php';"/>&nbsp;&nbsp;
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


