<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
include_once("$srcdir/api.inc");

$obj = formFetch("forms_physician_face", $_GET["id"]);

$physician_face_services = explode("#",$obj{"physician_face_services"});


// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"|| strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";
    
$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_physician_face";

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
$obj = formFetch("forms_physician_face", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>

<form method="post" action="<?php echo $rootdir;?>/forms/physician_face/save.php?mode=update&&id=<?php echo $_GET['id']; ?>" name="physician_face">
<h3 align="center"><?php xl('PHYSICIAN FACE TO FACE ENCOUNTER','e') ?></h3>


<table class="formtable" width="100%" border="0">
<TR>
<TD>
<u><?php xl('Patient Chart','e') ?></u>
<b><?php xl('Notes','e') ?></b><br />
<textarea name="physician_face_notes" rows="2" cols="30">
<?php echo stripslashes($obj{"physician_face_notes"});?></textarea><br />
</TD>
<TD align="right">
<?php xl('(Select an Action)','e') ?><br />
</TD>
</TR>
<tr>
<TD>
<b><?php xl('Patient:','e') ?></b>
<input type="text" name="physician_face_patient_name" size="50" value="<?php patientName(); ?>" readonly  /><br />
<b><?php xl('Chart:','e') ?></b>
<input type="text" name="physician_face_chart" size="10" value='<?php echo stripslashes($obj{"physician_face_chart"});?>' />
<b><?php xl('Episode:','e') ?></b>
<input type="text" name="physician_face_episode" size="10" value='<?php echo stripslashes($obj{"physician_face_episode"});?>' />
</TD>
<TD align="right">
<b><?php xl('Date:','e') ?></b>
<input type='text' size='10' name='physician_face_date' id='physician_face_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
					 value='<?php echo stripslashes($obj{"physician_face_date"});?>'
					 readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"physician_face_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
<br />
</TD>
</tr>
</TABLE>


<table class="formtable" width="100%" border="1" cellpadding="5px" cellspacing="0px">
<tr>
<td colspan="2">

<table width="100%" border="0" class="formtable">
<TR>
<TD width="170">
<b><?php xl('Physician Name:','e') ?></b>
</td>
<td>
<select name="physician_face_physician_name" id="physician_face_physician_name">
<?php physicianNameDropDown(stripslashes($obj{"physician_face_physician_name"}))?>
</select>
</td>
</TR>
<tr>
<TD width="170">
<b><?php xl('Patient Date of Birth:','e') ?></b>
</TD>
<td>
<input type="text" name="physician_face_patient_dob" size="20" value="<?php patientDOB(); ?>" readonly  />
</td>
</tr>
<tr>
<td width="170"><strong><?php xl('Start of Care Date:','e') ?></strong></td>
<td>
<input type="text" name="physician_face_patient_soc" id="physician_face_patient_soc" size="20" value="<?php VisitDate(); ?>" readonly  />

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"physician_face_patient_soc", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>
</tr>
</table>

<?php xl('I certify that this patient is under my care and that I, or a nurse practitioner or physician\'s assistant working with me, had a face-to-face encounter that meets the physician face-to-face encounter requirements with this patient on:','e') ?>

<input type='text' size='10' name='physician_face_patient_date' id='physician_face_patient_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
                                        value='<?php echo stripslashes($obj{"physician_face_patient_date"});?>' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"physician_face_patient_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
<br /><br />

<?php xl('The encounter with the patient was in whole, or in part, for the following medical condition, which is the primary reason for home health care(List medical condition):','e') ?><br />
<textarea name="physician_face_medical_condition" rows="4" cols="98">
<?php echo stripslashes($obj{"physician_face_medical_condition"});?>
</textarea>
<br />
<?php xl('I certify that, based on my findings, the following services are medically necessary home health services:','e') ?>

<TABLE width="100%" class="formtable" border="0">

  <TD><TD>
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Nursing','e')?>"  
<?php if(in_array("Nursing",$physician_face_services)) echo "checked"; ?> 
/>
<?php xl('Nursing','e')?> </label><br />
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Speech Language Pathology','e')?>" 
<?php if(in_array("Speech Language Pathology",$physician_face_services)) echo "checked"; ?> />
<?php xl('Speech Language Pathology','e')?> </label><br />
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Other:','e')?>" 
<?php if(in_array("Other:",$physician_face_services)) echo "checked"; ?> />
<?php xl('Other:','e')?> </label>
<input type="text" style="width:60%" name="physician_face_services_other" 
value='<?php echo stripslashes($obj{"physician_face_services_other"});?>' />
</TD>

<TD>
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Physical Therapy','e')?>" 
<?php if(in_array("Physical Therapy",$physician_face_services)) echo "checked"; ?> />
<?php xl('Physical Therapy','e')?> </label><br />
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Medical Social Worker','e')?>" 
<?php if(in_array("Medical Social Worker",$physician_face_services)) echo "checked"; ?> />
<?php xl('Medical Social Worker','e')?> </label><br />
</TD>

<TD>
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Occupational Therapy','e')?>" 
<?php if(in_array("Occupational Therapy",$physician_face_services)) echo "checked"; ?> />
<?php xl('Occupational Therapy','e')?> </label><br />
<label> <input type="checkbox" name="physician_face_services[]" value="<?php xl('Home Health Aide','e')?>" 
<?php if(in_array("Home Health Aide",$physician_face_services)) echo "checked"; ?> />
<?php xl('Home Health Aide','e')?> </label><br />
</TD>

</tr>
</TABLE>

<?php xl('My clinical findings support the need for the above services because:','e') ?><br />
<textarea name="physician_face_service_reason" rows="4" cols="98">
<?php echo stripslashes($obj{"physician_face_service_reason"});?>
</textarea>
<br />

<?php xl('Further, I certify that my clinical findings support that this patient is homebound(i.e. absences from home require consikderable and taxing effort and are for medical reasons or religious services or infrequently or of short duration when for other reasons) because:','e') ?><br />
<textarea name="physician_face_clinical_homebound_reason" rows="4" cols="98">
<?php echo stripslashes($obj{"physician_face_clinical_homebound_reason"});?>
</textarea>

</td>
</tr>

<tr>
<TD>
<b><?php xl('Physician Signature/Date','e') ?></b>
</TD>
<td>
<b><?php xl('Electronic Signature','e') ?></b>
</td>
</tr>
</table>



<a href="javascript:top.restoreSession();document.physician_face.submit();"
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

	
