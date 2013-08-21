<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: supervisor_visit_note");
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
$formTable = "forms_supervisor_visit_note";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();




?>

<html>
<head>
<title>Supervisor Visit Note</title>
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
<?php
$obj = formFetch("forms_supervisor_visit_note", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>



<form method="post"
		action="<?php echo $rootdir;?>/forms/supervisor_visit_note/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="supervisor_visit_note">
		<h3 align="center"><?php xl('SUPERVISOR VISIT OF HOME HEALTH STAFF','e')?></h3>		
		
<table width="100%" border="1px" class="formtable">
	<tr>
		<td colspan="5">
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td><strong><?php xl('Patient Name','e');?></strong></td>
				<td><input type="text" name="patient_name" style="width:100%" value="<?php patientName()?>" readonly ></td>
				<td><strong><?php xl('Time In','e');?></strong></td>
				<td>
					<select name="time_in">
						<?php timeDropDown(stripslashes($obj{"time_in"})) ?>
					</select>
				</td>
				<td><strong><?php xl('Time Out','e');?></strong></td>
				<td>
					<select name="time_out">
						<?php timeDropDown(stripslashes($obj{"time_out"})) ?>
					</select>
				</td>
				<td><strong><?php xl('Date','e');?></strong></td>
				<td align="center" valign="top" class="bold">
					<input type='text' size='10' name='SOC_date' id='date' 
					title='<?php xl('Supervisor Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"SOC_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
					</script>
				</td>
			</tr>
		</table>
	</tr>
	<tr>
		<td colspan="5">
			<strong><?php xl('NAME OF STAFF MEMBER SUPERVISED: ','e');?></strong>&nbsp;&nbsp;
			<input type="text" name="staff_supervised" style="width:50%;" value="<?php echo $obj{"staff_supervised"};?>">
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<strong><?php xl('SUPERVISOR VISITS: ','e');?><br>
			<label><input type="checkbox" name="supervisor_visits" value="<?php xl('LPN/LVN (every 30 days)','e');?>" <?php if($obj{"supervisor_visits"}=="LPN/LVN (every 30 days)"){ echo "checked"; }?> ><?php xl('LPN/LVN (every 30 days)','e');?></label>&nbsp;&nbsp;
			<label><input type="checkbox" name="supervisor_visits" value="<?php xl('HHA (every 14 days)','e');?>" <?php if($obj{"supervisor_visits"}=="HHA (every 14 days)"){ echo "checked"; }?> ><?php xl('HHA (every 14 days)','e');?></label>&nbsp;&nbsp;
			<label><input type="checkbox" name="supervisor_visits" value="<?php xl('PTA','e');?>" <?php if($obj{"supervisor_visits"}=="PTA"){ echo "checked"; }?> ><?php xl('PTA','e');?></label>&nbsp;&nbsp;
			<label><input type="checkbox" name="supervisor_visits" value="<?php xl('COTA (Per State Guidelines)','e');?>" <?php if($obj{"supervisor_visits"}=="COTA (Per State Guidelines)"){ echo "checked"; }?> ><?php xl('COTA (Per State Guidelines)','e');?></label>&nbsp;&nbsp;
			</strong>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('EXCEEDS REQUIREMENTS','e');?></strong>
		</td>
		<td>
			<strong><?php xl('MEETS REQUIREMENTS','e');?></strong>
		</td>
		<td>
			<strong><?php xl('DOES NOT MEET REQUIREMENTS','e');?></strong>
		</td>
		<td>
			<strong><?php xl('NOT OBSERVED','e');?></strong>
		</td>
		<td>
			<strong><?php xl('OBSERVATIONS','e');?></strong>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="reported_to_patient_home" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"reported_to_patient_home"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="reported_to_patient_home" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"reported_to_patient_home"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="reported_to_patient_home" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"reported_to_patient_home"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="reported_to_patient_home" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"reported_to_patient_home"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Reported to patient home when scheduled','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="wearing_name_badge" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"wearing_name_badge"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="wearing_name_badge" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"wearing_name_badge"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="wearing_name_badge" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"wearing_name_badge"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="wearing_name_badge" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"wearing_name_badge"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Wearing name badge','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="using_two_identifiers" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"using_two_identifiers"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="using_two_identifiers" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"using_two_identifiers"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="using_two_identifiers" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"using_two_identifiers"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="using_two_identifiers" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"using_two_identifiers"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Using two identifiers for patient','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_behaviour" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_behaviour"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_behaviour" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_behaviour"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_behaviour" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_behaviour"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_behaviour" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"demonstrates_behaviour"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Demonstrates politeness, courteous and respectful behavior during visit','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="follow_home_health" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"follow_home_health"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="follow_home_health" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"follow_home_health"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="follow_home_health" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"follow_home_health"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="follow_home_health" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"follow_home_health"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Follows Home Health Aide Care Plan Assignment','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_communication" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_communication"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_communication" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_communication"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_communication" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_communication"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_communication" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"demonstrates_communication"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Demonstrates Adequate Communication Skills','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="aware_patient_code" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"aware_patient_code"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="aware_patient_code" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"aware_patient_code"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="aware_patient_code" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"aware_patient_code"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="aware_patient_code" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"aware_patient_code"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Aware of patient"s code status','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_clinical_skills" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_clinical_skills"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_clinical_skills" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_clinical_skills"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_clinical_skills" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_clinical_skills"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_clinical_skills" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"demonstrates_clinical_skills"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Demonstrates clinical skills appropriate to patient need','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="adheres_to_policies" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"adheres_to_policies"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="adheres_to_policies" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"adheres_to_policies"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="adheres_to_policies" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"adheres_to_policies"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="adheres_to_policies" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"adheres_to_policies"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Adheres to policies and procedures','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="identify_patient_issues" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"identify_patient_issues"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="identify_patient_issues" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"identify_patient_issues"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="identify_patient_issues" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"identify_patient_issues"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="identify_patient_issues" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"identify_patient_issues"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('If applicable, Identifies patient issues during visit','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="handling_skills" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"handling_skills"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="handling_skills" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"handling_skills"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="handling_skills" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"handling_skills"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="handling_skills" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"handling_skills"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Utilizes good patient handling skills','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_grooming" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_grooming"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_grooming" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_grooming"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_grooming" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"demonstrates_grooming"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="demonstrates_grooming" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"demonstrates_grooming"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Demonstrates appropriate grooming, hygiene and dressing skills','e');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<input type="checkbox" name="supervisor_visit_other" value="<?php xl('EXCEEDS REQUIREMENTS','e');?>" <?php if($obj{"supervisor_visit_other"}=="EXCEEDS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="supervisor_visit_other" value="<?php xl('MEETS REQUIREMENTS','e');?>" <?php if($obj{"supervisor_visit_other"}=="MEETS REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="supervisor_visit_other" value="<?php xl('DOES NOT MEET REQUIREMENTS','e');?>" <?php if($obj{"supervisor_visit_other"}=="DOES NOT MEET REQUIREMENTS"){ echo "checked"; }?> >
		</td>
		<td align="center" valign="middle">
			<input type="checkbox" name="supervisor_visit_other" value="<?php xl('NOT OBSERVED','e');?>" <?php if($obj{"supervisor_visit_other"}=="NOT OBSERVED"){ echo "checked"; }?> >
		</td>
		<td>
			<?php xl('Other','e');?>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<?php xl('Additional Notes','e');?><br>
			<textarea name="additional_notes" rows="3" style="width:100%;"><?php echo $obj{"additional_notes"};?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<?php xl('Clinician Signature','e');?><br>
			<input type="text" name="clinician_signature" value="<?php echo $obj{"clinician_signature"};?>">
		</td>
		<td>
			<?php xl('Date','e');?>
					<input type='text' size='10' name='clinician_signature_date' id='clinician_signature_date' 
					title='<?php xl('Clinician Signature Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"clinician_signature_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"clinician_signature_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
					</script>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Supervisor"s Signature','e');?></strong><?php xl('(Name/Title)','e');?>
		</td>
		<td colspan="2">
			<strong><?php xl('Electronic Signature','e');?></strong>
		</td>
	</tr>

</table>
<a href="javascript:top.restoreSession();document.supervisor_visit_note.submit();"
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