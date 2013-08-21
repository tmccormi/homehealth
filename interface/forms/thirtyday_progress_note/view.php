<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: thirtyday_progress_note");
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
$formTable = "forms_30_day_progress_note";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();

$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

$obj = formFetch("forms_30_day_progress_note", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$care_coordination_involved_discipline = explode("#",$obj{"thirty_day_progress_note_care_coordination_involved_discipline"});
$topic_for_discussion = explode("#",$obj{"thirty_day_progress_note_topic_for_discussion"});

?>

<html>
<head>
<title>Care Plan</title>
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
		action="<?php echo $rootdir;?>/forms/thirtyday_progress_note/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="thirtyday_progress_note">
		<h3 align="center"><?php xl('30 DAY PROGRESS REPORT','e')?></h3>		
		<br/>
		<table width="100%" border="1" cellpadding="2px" class="formtable">
			<tr>
				<td width="13%" align="center" valign="top" scope="row">
				<strong><?php xl('PATIENT NAME','e')?></strong></td>
				<td width="13%" align="center" valign="top"><input type="text" name="thirty_day_progress_note_patient_name"
					 id="thirty_day_progress_note_patient_name" value="<?php patientName()?>"
					readonly /></td>
				<td width="20%" align="center" valign="top"><strong><?php xl('MR#','e')?>
				</strong></td>
				<td width="15%" align="center" valign="top" class="bold"><input
					type="text" name="thirty_day_progress_note_mr" id="thirty_day_progress_note_mr"
					value="<?php  echo $_SESSION['pid']?>" readonly/></td>
				<td width="22%" align="center" valign="top">
				<strong><?php xl('DATE','e')?></strong></td>
				<td width="17%" align="center" valign="top" class="bold">
				<input type='text' size='10' name='thirty_day_progress_note_date' id='thirty_day_progress_note_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"thirty_day_progress_note_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"thirty_day_progress_note_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
				</td>

			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('CARE COORDINATION INVOLVED IN THE FOLLOWING DISCIPLINE(S)','e')?>
				</strong>
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="middle" scope="row"><label> <input
						type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]" value="<?php xl('Physician','e')?>" <?php if(in_array("Physician",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Physician','e')?>
				</label> <br /> <label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]" value="<?php xl('Director Patient Care','e')?>" <?php if(in_array("Director Patient Care",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Director Patient Care','e')?> </label>
					<br />	<?php xl('Services/DON','e')?>
					<br /> <label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('RN/LPN/LVN','e')?>" <?php if(in_array("RN/LPN/LVN",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('RN/LPN/LVN','e')?> </label>
					<br /> <label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Physical Therapy','e')?>" <?php if(in_array("Physical Therapy",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Physical Therapy','e')?> </label> <br />
					</td>
				<td colspan="2" valign="top">
					<p>
						<label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Occupational Therapy','e')?>" <?php if(in_array("Occupational Therapy",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Occupational Therapy','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Case Manager','e')?>" <?php if(in_array("Case Manager",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Case Manager','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Home Health Aide','e')?>" <?php if(in_array("Home Health Aide",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Home Health Aide','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Medical Social Worker','e')?>" <?php if(in_array("Medical Social Worker",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Medical Social Worker','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Speech Language Pathologist','e')?>" <?php if(in_array("Speech Language Pathologist",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Speech Language Pathologist','e')?>
						</label> 
					</p>
				</td>
				<td colspan="2" valign="top">
					<p>
						<label> <input type="checkbox" name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Pharmacist','e')?>" <?php if(in_array("Pharmacist",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Pharmacist','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('DME Vendor','e')?>" <?php if(in_array("DME Vendor",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('DME Vendor','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="thirty_day_progress_note_care_coordination_involved_discipline[]"  value="<?php xl('Dietician','e')?>" <?php if(in_array("Dietician",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Dietician','e')?>
						</label>
					</p>
					<p>
						<?php xl(' Other','e')?> <input type="text"
							name="thirty_day_progress_note_care_coordination_involved_other" rows="2" style="width:80%"  value="<?php echo $obj{"thirty_day_progress_note_care_coordination_involved_other"}; ?>"/>
					</p>
					<p>
						<br />
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('CARE COMMUNICATED VIA','e')?>
				</strong> <label> <input type="checkbox"
						name="thirty_day_progress_note_care_communicated_via"
						value="<?php xl('IDT Meeting','e')?>" <?php if($obj{"thirty_day_progress_note_care_communicated_via"}=="IDT Meeting") echo "checked"; ?> /> <?php xl('IDT Meeting','e')?> </label> <label> 
						<input type="checkbox" name="thirty_day_progress_note_care_communicated_via" value="<?php xl('1:1 Clinician/Clinical Supervisor','e')?>" <?php if($obj{"thirty_day_progress_note_care_communicated_via"}=="1:1 Clinician/Clinical Supervisor") echo "checked"; ?> /> <?php xl('1:1 Clinician/Clinical Supervisor','e')?>
				</label> <label> <input type="checkbox"
						name="thirty_day_progress_note_care_communicated_via"
						value="<?php xl('Phone Conference','e')?>" <?php if($obj{"thirty_day_progress_note_care_communicated_via"}=="Phone Conference") echo "checked"; ?> /> <?php xl('Phone Conference','e')?> </label> <label>
						 <input type="checkbox" name="thirty_day_progress_note_care_communicated_via"
						 value="<?php xl('Electronic Medical Records','e')?>" <?php if($obj{"thirty_day_progress_note_care_communicated_via"}=="Electronic Medical Records") echo "checked"; ?> /> <?php xl('Electronic Medical Records','e')?>
				</label> <label> <input type="checkbox"
						name="thirty_day_progress_note_care_communicated_via"
						value="<?php xl('Fax','e')?>" <?php if($obj{"thirty_day_progress_note_care_communicated_via"}=="Fax") echo "checked"; ?> /> <?php xl('Fax','e')?> </label> <label>
						<input type="checkbox" name="thirty_day_progress_note_care_communicated_via" value="<?php xl('Mail','e')?>" <?php if($obj{"thirty_day_progress_note_care_communicated_via"}=="Mail") echo "checked"; ?> /> <?php xl('Mail','e')?>
				</label><br>
				<label> 
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:93%;" name="thirty_day_progress_note_care_communicated_via_other"  value="<?php echo $obj{"thirty_day_progress_note_care_communicated_via_other"}; ?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('TOPIC FOR DISCUSSION(Check all that apply)','e')?>
				</strong> <label> <input type="checkbox"
						name="thirty_day_progress_note_topic_for_discussion[]"
						value="<?php xl('Review Patient Current Status','e')?>" <?php if(in_array("Review Patient Current Status",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Review Patient Current Status','e')?> </label> <label> 
						<input type="checkbox" name="thirty_day_progress_note_topic_for_discussion[]" value="<?php xl('Patient Change of Condition','e')?>" <?php if(in_array("Patient Change of Condition",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Patient Change of Condition','e')?>
				</label> <label> <input type="checkbox"
						name="thirty_day_progress_note_topic_for_discussion[]"
						value="<?php xl('Update Plan of Care','e')?>" <?php if(in_array("Update Plan of Care",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Update Plan of Care','e')?> </label> <label>
						 <input type="checkbox" name="thirty_day_progress_note_topic_for_discussion[]" value="<?php xl('Coordination between Disciplines','e')?>" <?php if(in_array("Coordination between Disciplines",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Coordination between Disciplines','e')?>
				</label> <label> <input type="checkbox"
						name="thirty_day_progress_note_topic_for_discussion[]"
						value="<?php xl('Recertification','e')?>" <?php if(in_array("Recertification",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Recertification','e')?> </label> <label>
						<input type="checkbox" name="thirty_day_progress_note_topic_for_discussion[]" value="<?php xl('Discharge Plans','e')?>" <?php if(in_array("Discharge Plans",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Discharge Plans','e')?>
				</label> <br>
				<label> 
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:93%" name="thirty_day_progress_note_topic_for_discussion_other" value="<?php echo $obj{"thirty_day_progress_note_topic_for_discussion_other"}; ?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('DETAILS OF DISCUSSION','e')?>
				</strong><textarea name="thirty_day_progress_note_details_of_discussion" rows="3" cols="100"><?php echo $obj{"thirty_day_progress_note_details_of_discussion"}; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('DETAILS FOR RESOLUTIONS/FOLLOW-UP','e')?>
				</strong><textarea name="thirty_day_progress_note_details_for_resolutions" rows="3" cols="100"><?php echo $obj{"thirty_day_progress_note_details_for_resolutions"}; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('PEOPLE/DISCIPLINES ATTENDING','e')?>
				</strong><textarea name="thirty_day_progress_note_people_descipline_attending" rows="3" cols="100"><?php echo $obj{"thirty_day_progress_note_people_descipline_attending"}; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top" scope="row"><strong><?php xl('Clinician Name/Title Completing Note','e')?>
				</strong></td>
				<td colspan="3" valign="top"><strong><?php xl('Electronic Signature','e')?>
				</strong></td>
			</tr>	
		</table>
		<a href="javascript:top.restoreSession();document.thirtyday_progress_note.submit();"
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
