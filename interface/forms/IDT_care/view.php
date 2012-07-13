<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
include_once("$srcdir/api.inc");

$obj = formFetch("forms_idt_care", $_GET["id"]);
$care_coordination_involved_discipline = explode("#",$obj{"idt_care_care_coordination_involved_discipline"});
$topic_for_discussion = explode("#",$obj{"idt_care_topic_for_discussion"});


// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"|| strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";
    
$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_idt_care";

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
$obj = formFetch("forms_idt_care", $_GET["id"]);

?>
<form method="post"		action="<?php echo $rootdir;?>/forms/IDT_care/save.php?mode=update&&id=<?php echo $_GET['id']; ?>" name="IDT_care">
<h3 align="center"><?php xl('IDT-CARE COORDINATION NOTE','e') ?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td><b><?php xl('PATIENT NAME','e') ?></b></td>
<td><input type="text" name="idt_care_patient_name" size="40" value="<?php patientName(); ?>" readonly="readonly"  /></td>
<td width="10%" align="center" valign="top"><strong><?php xl('MR#','e')?>
                                </strong></td>
                                <td width="15%" align="center" valign="top" class="bold"><input
                                        type="text" name="idt_care_mr" id="idt_care_mr"
                                        value="<?php  echo $_SESSION['pid']?>" readonly/></td>
                                <td width="7%" align="center" valign="top">
                                <strong><?php xl('DATE','e')?></strong></td>
                                <td width="17%" align="center" valign="top" class="bold">
                                <input type='text' size='10' name='idt_care_date' id='idt_care_date'
										value='<?php echo stripslashes($obj{"idt_care_date"});?>'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"idt_care_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
                                </td>
</tr>

<tr>
	<td colspan="6" valign="top" scope="row"><strong> <?php xl('CARE COORDINATION INVOLVED IN THE FOLLOWING DISCIPLINE(S)','e')?>
				</strong>
				</td>
			</tr>

			<tr><td colspan="6">
			<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
			<tr>
				<td  valign="top" scope="row" width="33%">
			  <label> <input type="checkbox" name="idt_care_care_coordination_involved_discipline[]" value="<?php xl('Skilled Nursing','e')?>" <?php if(in_array("Skilled Nursing",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Skilled Nursing','e')?> </label>
					<br /> <label> <input type="checkbox" name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Physical Therapy','e')?>" <?php if(in_array("Physical Therapy",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Physical Therapy','e')?> </label>
					<br /> <label> <input type="checkbox" name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Occupational Therapy','e')?>" <?php if(in_array("Occupational Therapy",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Occupational Therapy','e')?> </label> <br />
					</td>


				<td  valign="top">
					<p>
	 <label> <input type="checkbox"
							name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Home Health Aide','e')?>" <?php if(in_array("Home Health Aide",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Home Health Aide','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Medical Social Worker','e')?>" <?php if(in_array("Medical Social Worker",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Medical Social Worker','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Speech Language Pathologist','e')?>" <?php if(in_array("Speech Language Pathologist",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Speech Language Pathologist','e')?>
						</label> 
					</p>
				</td>
				<td  valign="top">
					<p>
		<label> <input type="checkbox"	name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Dietician','e')?>" <?php if(in_array("Dietician",$care_coordination_involved_discipline)) echo "checked"; ?>/> <?php xl('Dietician','e')?>
						</label>
					</p>
					<p>
						<?php xl(' Other','e')?> <input type="text"
							name="idt_care_care_coordination_involved_other" rows="2" style="width:75%"  value="<?php echo $obj{"idt_care_care_coordination_involved_other"}; ?>"/>
					</p>

				</td>
				</tr>
				</table></td>
			</tr>

<!-- Care Communicated Via -->
<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('CARE COMMUNICATED VIA','e')?>
</strong> <label> <input type="checkbox" name="idt_care_care_communicated_via" value="<?php xl('IDT Meeting','e')?>" <?php if($obj{"idt_care_care_communicated_via"}=="IDT Meeting") echo "checked"; ?> /> <?php xl('IDT Meeting','e')?> </label> <label> 
						<input type="checkbox" name="idt_care_care_communicated_via" value="<?php xl('1:1 Clinician/Clinical Supervisor','e')?>" <?php if($obj{"idt_care_care_communicated_via"}=="1:1 Clinician/Clinical Supervisor") echo "checked"; ?> /> <?php xl('1:1 Clinician/Clinical Supervisor','e')?>
				</label> <label> <input type="checkbox"
						name="idt_care_care_communicated_via"
						value="<?php xl('Phone Conference','e')?>" <?php if($obj{"idt_care_care_communicated_via"}=="Phone Conference") echo "checked"; ?> /> <?php xl('Phone Conference','e')?> </label> <label>
						 <input type="checkbox" name="idt_care_care_communicated_via"
						 value="<?php xl('Electronic Medical Records','e')?>" <?php if($obj{"idt_care_care_communicated_via"}=="Electronic Medical Records") echo "checked"; ?> /> <?php xl('Electronic Medical Records','e')?>
				</label> <label> <input type="checkbox"
						name="idt_care_care_communicated_via"
						value="<?php xl('Fax','e')?>" <?php if($obj{"idt_care_care_communicated_via"}=="Fax") echo "checked"; ?> /> <?php xl('Fax','e')?> </label> <label>
						<input type="checkbox" name="idt_care_care_communicated_via" value="<?php xl('Mail','e')?>" <?php if($obj{"idt_care_care_communicated_via"}=="Mail") echo "checked"; ?> /> <?php xl('Mail','e')?>
				</label><label>&nbsp;&nbsp;
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:81%;" name="idt_care_care_communicated_via_other"  value="<?php echo $obj{"idt_care_care_communicated_via_other"}; ?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('TOPIC FOR DISCUSSION(Check all that apply)','e')?>
				</strong> 
<br />
<label> <input type="checkbox"
						name="idt_care_topic_for_discussion[]"
						value="<?php xl('Review Patient Current Status','e')?>" <?php if(in_array("Review Patient Current Status",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Review Patient Current Status','e')?> </label> <label> 
						<input type="checkbox" name="idt_care_topic_for_discussion[]" value="<?php xl('Patient Change of Condition','e')?>" <?php if(in_array("Patient Change of Condition",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Patient Change of Condition','e')?>
				</label> <label> <input type="checkbox"
						name="idt_care_topic_for_discussion[]"
						value="<?php xl('Update Plan of Care','e')?>" <?php if(in_array("Update Plan of Care",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Update Plan of Care','e')?> </label> <label>
						 <input type="checkbox" name="idt_care_topic_for_discussion[]" value="<?php xl('Coordination between Disciplines','e')?>" <?php if(in_array("Coordination between Disciplines",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Coordination between Disciplines','e')?>
				</label> <label> <input type="checkbox"
						name="idt_care_topic_for_discussion[]"
						value="<?php xl('Recertification','e')?>" <?php if(in_array("Recertification",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Recertification','e')?> </label> <label>
						<input type="checkbox" name="idt_care_topic_for_discussion[]" value="<?php xl('Discharge Plans','e')?>" <?php if(in_array("Discharge Plans",$topic_for_discussion)) echo "checked"; ?>/> <?php xl('Discharge Plans','e')?>
				</label> <label> &nbsp;&nbsp;&nbsp;
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:65%" name="idt_care_topic_for_discussion_other" value="<?php echo $obj{"idt_care_topic_for_discussion_other"}; ?>"/>
				</td>
			</tr>

<!-- Details for discussion, resolution, people -->

			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('DETAILS OF DISCUSSION','e')?>
				</strong><br /><textarea name="idt_care_details_of_discussion" rows="3" cols="98"><?php echo $obj{"idt_care_details_of_discussion"}; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('DETAILS FOR RESOLUTIONS/FOLLOW-UP','e')?>
				</strong><br /><textarea name="idt_care_details_for_resolutions" rows="4" cols="98"><?php echo $obj{"idt_care_details_for_resolutions"}; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('PEOPLE/DISCIPLINES ATTENDING','e')?>
				</strong><br /><textarea name="idt_care_people_descipline_attending" rows="3" cols="98"><?php echo $obj{"idt_care_details_for_resolutions"}; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top" scope="row"><strong><?php xl('Clinician Name/Title Completing Note','e')?>
				</strong><input type="text" name="idt_care_clinical_name_title_completing" value="<?php echo $obj{"idt_care_details_for_resolutions"}; ?>"></td>
				<td colspan="3" valign="top"><strong><?php xl('Electronic Signature','e')?>
				</strong></td>
			</tr>

<!-- End of form -->


</table>
<a href="javascript:top.restoreSession();document.IDT_care.submit();"
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

	
