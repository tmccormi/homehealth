<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: patient_missed_visit");
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
$formTable = "forms_patient_missed_visit";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();

$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

$obj = formFetch("forms_patient_missed_visit", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$reason_for = explode("#",$obj{"reason_for"});
$actions_taken= explode("#",$obj{"actions_taken"});

?>

<html>
<head>
<title>PATIENT MISSED VISIT-PHYSICIAN NOTIFICATION</title>
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
		action="<?php echo $rootdir;?>/forms/patient_missed_visit/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="patient_missed_visit">
		<h3 align="center"><?php xl('PATIENT MISSED VISIT-PHYSICIAN NOTIFICATION','e')?></h3>		
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
				<strong><?php xl('DATE OF MISSED VISIT','e')?></strong></td>
				<td align="center" valign="top" class="bold">
				<input type='text' size='10' name='patient_missed_date' id='patient_missed_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"patient_missed_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"patient_missed_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
				</td>
				</tr></table>
			</td>
			</tr>
			<tr>
				<td colspan="6">
					<strong>
						<?php xl('DISCIPLINE WHO','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="radio" name="descipline_who_category" value="<?php xl("MISSED VISIT","e");?>" <?php if($obj{"descipline_who_category"}=="MISSED VISIT"){ echo "checked"; }?> ><?php xl("MISSED VISIT","e");?></label>
						<label><input type="radio" name="descipline_who_category" value="<?php xl("DELAYED INITIAL SOC/EVALUATION","e");?>" <?php if($obj{"descipline_who_category"}=="DELAYED INITIAL SOC/EVALUATION"){ echo "checked"; }?> ><?php xl("DELAYED INITIAL SOC/EVALUATION","e");?></label>
					</strong>
				</td>
			</tr>
			<tr>
				<td width="33%" colspan="2">
					<label><input type="radio" name="descipline_who" value="<?php xl("Skilled Nursing","e");?>" <?php if($obj{"descipline_who"}=="Skilled Nursing"){ echo "checked"; }?> ><?php xl("Skilled Nursing","e");?></label><br>
					<label><input type="radio" name="descipline_who" value="<?php xl("Physical Therapy","e");?>" <?php if($obj{"descipline_who"}=="Physical Therapy"){ echo "checked"; }?> ><?php xl("Physical Therapy","e");?></label><br>
					<label><input type="radio" name="descipline_who" value="<?php xl("Occupational Therapy","e");?>" <?php if($obj{"descipline_who"}=="Occupational Therapy"){ echo "checked"; }?> ><?php xl("Occupational Therapy","e");?></label>
				</td>
				<td width="33%" colspan="2">
					<label><input type="radio" name="descipline_who" value="<?php xl("Home Health Aide","e");?>" <?php if($obj{"descipline_who"}=="Home Health Aide"){ echo "checked"; }?> ><?php xl("Home Health Aide","e");?></label><br>
					<label><input type="radio" name="descipline_who" value="<?php xl("Medical Social Worker","e");?>" <?php if($obj{"descipline_who"}=="Medical Social Worker"){ echo "checked"; }?> ><?php xl("Medical Social Worker","e");?></label><br>
					<label><input type="radio" name="descipline_who" value="<?php xl("Speech Language Pathologist","e");?>" <?php if($obj{"descipline_who"}=="Speech Language Pathologist"){ echo "checked"; }?> ><?php xl("Speech Language Pathologist","e");?></label>
				</td>
				<td colspan="2">
					<label><input type="radio" name="descipline_who" value="<?php xl("Dietician","e");?>" <?php if($obj{"descipline_who"}=="Dietician"){ echo "checked"; }?> ><?php xl("Dietician","e");?></label><br>
					<table border="0px" cellspacing="0" width="100%" class="formtable"><tr><td valign="top">
					<label><input type="radio" name="descipline_who" value="<?php xl("Other","e");?>" <?php if($obj{"descipline_who"}=="Other"){ echo "checked"; }?> ><?php xl("Other ","e");?></label>
					</td><td valign="top">
					<textarea name="descipline_who_other" rows="3" style="width:60%;"><?php echo $obj{"descipline_who_other"};?></textarea>
					</td></tr></table>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<strong>
						<?php xl('REASON FOR','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
						<label><input type="radio" name="reason_for_category" value="<?php xl("MISSED VISIT","e");?>" <?php if($obj{"reason_for_category"}=="MISSED VISIT"){ echo "checked"; }?> ><?php xl("MISSED VISIT","e");?></label>
						<label><input type="rdaio" name="reason_for_category" value="<?php xl("DELAYED INITIAL EVALUATION","e");?>" <?php if($obj{"reason_for_category"}=="DELAYED INITIAL EVALUATION"){ echo "checked"; }?> ><?php xl("DELAYED INITIAL EVALUATION","e");?></label>
						<?php xl("(check all that apply)","e");?>
					</strong>
				</td>
				<td colspan="3">
					<strong>
						<?php xl('ACTIONS TAKEN','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php xl("(check all that apply)","e");?>
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient was not home when clinician arrived","e");?>" <?php if(in_array("Patient was not home when clinician arrived",$reason_for)) { echo "checked"; }?> ><?php xl("Patient was not home when clinician arrived","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient had MD appointment and not available","e");?>" <?php if(in_array("Patient had MD appointment and not available",$reason_for)) { echo "checked"; }?> ><?php xl("Patient had MD appointment and not available","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient had another appointment and not available","e");?>" <?php if(in_array("Patient had another appointment and not available",$reason_for)) { echo "checked"; }?> ><?php xl("Patient had another appointment and not available","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient refused-no reason given","e");?>" <?php if(in_array("Patient refused-no reason given",$reason_for)) { echo "checked"; }?> ><?php xl("Patient refused-no reason given","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient refused secondary to transient illness (e.g. cold)","e");?>" <?php if(in_array("Patient refused secondary to transient illness (e.g. cold)",$reason_for)) { echo "checked"; }?> ><?php xl("Patient refused secondary to transient illness (e.g. cold)","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient c/o of fatigue and unable to participate","e");?>" <?php if(in_array("Patient c/o of fatigue and unable to participate",$reason_for)) { echo "checked"; }?> ><?php xl("Patient c/o of fatigue and unable to participate","e");?></label><br>
					<label><input type="checkbox" name="reason_for[]" value="<?php xl("Patient c/o of pain and unable to participate","e");?>" <?php if(in_array("Patient c/o of pain and unable to participate",$reason_for)) { echo "checked"; }?> ><?php xl("Patient c/o of pain and unable to participate","e");?></label><br>
					<table border="0px" cellspacing="0" width="100%" class="formtable"><tr><td valign="top">
					<?php xl("Other: ","e");?></td><td valign="top"><textarea name="reason_for_other" rows="4" style="width:70%;"><?php echo $obj{"reason_for_other"};?></textarea>
					</td></tr></table>
				</td>
				<td colspan="3">
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Documented on Clinicians Care Communication Note","e");?>" <?php if(in_array("Documented on Clinicians Care Communication Note",$actions_taken)) { echo "checked"; }?> ><?php xl("Documented on Clinicians Care Communication Note","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Message left for patient on answering machine","e");?>" <?php if(in_array("Message left for patient on answering machine",$actions_taken)) { echo "checked"; }?> ><?php xl("Message left for patient on answering machine","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Message left for patient with authorized contact person","e");?>" <?php if(in_array("Message left for patient with authorized contact person",$actions_taken)) { echo "checked"; }?> ><?php xl("Message left for patient with authorized contact person","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("No answering system-unable to leave message for patient","e");?>" <?php if(in_array("No answering system-unable to leave message for patient",$actions_taken)) { echo "checked"; }?> ><?php xl("No answering system-unable to leave message for patient","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician and Nursing notified of transient illness","e");?>" <?php if(in_array("Physician and Nursing notified of transient illness",$actions_taken)) { echo "checked"; }?> ><?php xl("Physician and Nursing notified of transient illness","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician and Nursing notified of pain","e");?>" <?php if(in_array("Physician and Nursing notified of pain",$actions_taken)) { echo "checked"; }?> ><?php xl("Physician and Nursing notified of pain","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician and Nursing notified of patient refusal","e");?>" <?php if(in_array("Physician and Nursing notified of patient refusal",$actions_taken)) { echo "checked"; }?> ><?php xl("Physician and Nursing notified of patient refusal","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician and Nursing notified of patient fatigue and unable to participate.","e");?>" <?php if(in_array("Physician and Nursing notified of patient fatigue and unable to participate.",$actions_taken)) { echo "checked"; }?> ><?php xl("Physician and Nursing notified of patient fatigue and unable to participate.","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Physician notified of other appointment and patient not seen according to order","e");?>" <?php if(in_array("Physician notified of other appointment and patient not seen according to order",$actions_taken)) { echo "checked"; }?> ><?php xl("Physician notified of other appointment and patient not seen according to order","e");?></label><br>
					<label><input type="checkbox" name="actions_taken[]" value="<?php xl("Other","e");?>" <?php if(in_array("Other",$actions_taken)) { echo "checked"; }?> ><?php xl("Other ","e");?></label>
					<input type="text" name="actions_taken_other" style="width:80%;" value="<?php echo $obj{"actions_taken_other"};?>">
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<strong>
						<?php xl('PATIENT"S NEEDS WERE ADDRESSED','e')?>
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<label><input type="checkbox" name="patient_need_addressed" value="<?php xl("Verified with authorized person/family/friends/neighbors who were in contact with patient","e");?>" <?php if($obj{"patient_need_addressed"}=="Verified with authorized person/family/friends/neighbors who were in contact with patient"){ echo "checked"; }?> ><?php xl("Verified with authorized person/family/friends/neighbors who were in contact with patient","e");?></label><br>
					<label><input type="checkbox" name="patient_need_addressed" value="<?php xl("Able to contact patient and they refused assistance from discipline for this date but continues to want services and visit was rescheduled","e");?>" <?php if($obj{"patient_need_addressed"}=="Able to contact patient and they refused assistance from discipline for this date but continues to want services and visit was rescheduled"){ echo "checked"; }?> ><?php xl("Able to contact patient and they refused assistance from discipline for this date but continues to want services and visit was rescheduled","e");?></label><br>
					<label><input type="checkbox" name="patient_need_addressed" value="<?php xl("Able to contact patient and they refused assistance from discipline at any time. Physician notified, other disciplines notified and discharge process initiated","e");?>" <?php if($obj{"patient_need_addressed"}=="Able to contact patient and they refused assistance from discipline at any time. Physician notified, other disciplines notified and discharge process initiated"){ echo "checked"; }?> ><?php xl("Able to contact patient and they refused assistance from discipline at any time. Physician notified, other disciplines notified and discharge process initiated","e");?></label><br>
					<label><input type="checkbox" name="patient_need_addressed" value="<?php xl("Clinician will follow-up with patient to determine if continued interventions are needed at this time and notify physician/other disciplines of outcome","e");?>" <?php if($obj{"patient_need_addressed"}=="Clinician will follow-up with patient to determine if continued interventions are needed at this time and notify physician/other disciplines of outcome"){ echo "checked"; }?> ><?php xl("Clinician will follow-up with patient to determine if continued interventions are needed at this time and notify physician/other disciplines of outcome","e");?></label><br>
					<?php xl("Other: ","e");?>&nbsp;<input type="text" name="patient_need_addressed_other" style="width:90%;" value="<?php echo $obj{"patient_need_addressed_other"};?>">
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<strong>
						<?php xl('PHYSICIAN ACKNOWLEDGMENT OF MISSED VISIT BY DISCIPLINE','e')?>
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<strong>
						<label><?php xl('Physician ','e')?><input type="text" name="physician_name" value="<?php doctorname(); ?>" readonly></label>
						<label><?php xl('FAX NUMBER ','e')?><input type="text" name="physician_fax_number" value="<?php physicianfax(); ?>" readonly></label><br>
						<?php xl('Physician Signature acknowledges Home Health Agency"s communication of patient"s','e')?>
						<label><input type="checkbox" name="physician_acknowledgment" value="<?php xl("MISSED VISIT","e");?>" <?php if($obj{"physician_acknowledgment"}=="MISSED VISIT"){ echo "checked"; }?> ><?php xl("MISSED VISIT","e");?></label>
						<label><input type="checkbox" name="physician_acknowledgment" value="<?php xl("DELAYED INITIAL SOC/EVALUATION","e");?>" <?php if($obj{"physician_acknowledgment"}=="DELAYED INITIAL SOC/EVALUATION"){ echo "checked"; }?> ><?php xl("DELAYED INITIAL SOC/EVALUATION","e");?></label>
						<?php xl(' ON ','e')?>
						<input type='text' size='10' name='physician_acknowledgment_date' id='physician_acknowledgment_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"physician_acknowledgment_date"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"physician_acknowledgment_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
						</script>
						<br>
						<?php xl('PHYSICIAN SIGNATURE ','e')?><input type="text" name="physician_signature" value="<?php echo $obj{"physician_signature"};?>">&nbsp;&nbsp;&nbsp;&nbsp;
						<?php xl('DATE ','e')?>
						<input type='text' size='10' name='physician_signature_date' id='physician_signature_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"physician_signature_date"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date3' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"physician_signature_date", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
						</script>
						<br>
						<?php xl('Additional Physician Comments: ','e')?><input type="text" name="physician_comments" style="width:50%" value="<?php echo $obj{"physician_comments"};?>">&nbsp;&nbsp;&nbsp;&nbsp;
						
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<strong><?php xl('Clinician Name/Title ','e')?></strong>
				</td>
				<td colspan="3">
					<strong><?php xl('Electronic Signature','e')?></strong>
				</td>
			</tr>
		</table>
		<a href="javascript:top.restoreSession();document.patient_missed_visit.submit();"
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