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
$formTable = "forms_sixty_day_progress_note";

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
$obj = formFetch("forms_sixty_day_progress_note", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$clinical_pblm = explode("#",$obj{"sixty_day_progress_note_decline_no_change_clinical_pblm"});
$clinical_issues = explode("#",$obj{"sixty_day_progress_note_improvement_in_clinical_issues"});
?>
<form method="post"		action="<?php echo $rootdir;?>/forms/sixty_day_progress_note/save.php?mode=update&&id=<?php echo $_GET['id']; ?>" name="sixty_day_progress_note">
		<h3 align="center"><?php xl('60 DAY PROGRESS NOTE ','e') ?> &#45; <?php xl('CASE CONFERENCE','e')?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td><b><?php xl('PATIENT NAME','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_patient_name" size="50" value="<?php patientName(); ?>" readonly="readonly" /></td>
<td><b><?php xl('Certification Period','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_certification_period" size="50" readonly="readonly" value="<?php echo stripslashes($obj{"sixty_day_progress_note_certification_period"});?>" /></td>
</tr>
</table>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td><b><?php xl('Dear Dr:','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_dear_dr" size="50" value="<?php doctorname(); ?>" readonly="readonly" /></td>
</tr>
</table>
</td></tr>

<tr><td>
<b><?php xl('Your patient has been receiving care by the following discipline(s)','e') ?></b>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" <?php if ($obj{"sixty_day_progress_note_patient_receiving_care_first"} == "Skilled Nursing") echo "checked";;?> value="<?php xl('Skilled Nursing','e') ?>"/><?php xl('Skilled Nursing ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" <?php if ($obj{"sixty_day_progress_note_patient_receiving_care_first"} == "Physical Therapy") echo "checked";;?> value="<?php xl('Physical Therapy','e') ?>"/><?php xl('Physical Therapy ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" <?php if ($obj{"sixty_day_progress_note_patient_receiving_care_first"} == "Occupational Therapy") echo "checked";;?> value="<?php xl('Occupational Therapy','e') ?>"/><?php xl('Occupational Therapy ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" <?php if ($obj{"sixty_day_progress_note_patient_receiving_care_first"} == "Speech therapy") echo "checked";;?> value="<?php xl('Speech therapy','e') ?>"/><?php xl('Speech therapy ', 'e') ?>
</td>
<td>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" <?php if ($obj{"sixty_day_progress_note_patient_receiving_care_first"} == "Home Health Aide") echo "checked";;?> value="<?php xl('Home Health Aide','e') ?>"/><?php xl('Home Health Aide ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" <?php if ($obj{"sixty_day_progress_note_patient_receiving_care_first"} == "Medical Social Worker") echo "checked";;?> value="<?php xl('Medical Social Worker','e') ?>"/><?php xl('Medical Social Worker ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" <?php if ($obj{"sixty_day_progress_note_patient_receiving_care_first"} == "Dietician") echo "checked";;?> value="<?php xl('Dietician','e') ?>"/><?php xl('Dietician ', 'e') ?><br/>
<input type="checkbox" name="sixty_day_progress_note_patient_receiving_care_first" <?php if ($obj{"sixty_day_progress_note_patient_receiving_care_first"} == "Other") echo "checked";;?> value="<?php xl('Other','e') ?>"/>
<?php xl('Other ', 'e') ?>
<input type="text" name="sixty_day_progress_note_patient_receiving_care_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_patient_receiving_care_other"});?>" />
</td>
</tr>
</table>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td style="width: 42%;"><b><?php xl('DIAGNOSIS ON ADMISSION','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_diagnosis_admission" size="50px" value="<?php echo stripslashes($obj{"sixty_day_progress_note_diagnosis_admission"});?>"/></td>
</tr>
<tr>
<td><b><?php xl('ADDITIONAL DIAGNOSES OR ISSUES SINCE ADMISSION','e') ?></b></td>
<td><input type="text" name="sixty_day_progress_note_additional_diagnosis" size="50px" value="<?php echo stripslashes($obj{"sixty_day_progress_note_additional_diagnosis"});?>"/></td>
</tr>
</table>
</td></tr>

<tr><td>
<b><?php xl('DECLINE/NO CHANGE (NC) IN CLINICAL PROBLEMS (Check all that apply)','e') ?></b><br/>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Decline/NC in Neuro Status",$clinical_pblm)) echo "checked";?> value="<?php xl('Decline/NC in Neuro Status','e') ?>"/><?php xl('Decline/NC in Neuro Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Decline/NC in GI Status",$clinical_pblm)) echo "checked";?> value="<?php xl('Decline/NC in GI Status','e') ?>"/><?php xl('Decline/NC in GI Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Decline/NC in Cardiovascular Status",$clinical_pblm)) echo "checked";?> value="<?php xl('Decline/NC in Cardiovascular Status','e') ?>"/><?php xl('Decline/NC in Cardiovascular Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Decline/NC in Respiratory Status",$clinical_pblm)) echo "checked";?> value="<?php xl('Decline/NC in Respiratory Status','e') ?>"/><?php xl('Decline/NC in Respiratory Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Decline/NC in GU Status",$clinical_pblm)) echo "checked";?> value="<?php xl('Decline/NC in GU Status','e') ?>"/><?php xl('Decline/NC in GU Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Skin Integrity Alteration",$clinical_pblm)) echo "checked";?> value="<?php xl('Skin Integrity Alteration','e') ?>"/><?php xl('Skin Integrity Alteration ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Decline/NC in Musculoskeletal Status",$clinical_pblm)) echo "checked";?> value="<?php xl('Decline/NC in Musculoskeletal Status','e') ?>"/><?php xl('Decline/NC in Musculoskeletal Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Personal Safety Issues",$clinical_pblm)) echo "checked";?> value="<?php xl('Personal Safety Issues','e') ?>"/><?php xl('Personal Safety Issues ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_decline_no_change_clinical_pblm[]" <?php if (in_array("Decline/NC in Functional Skills",$clinical_pblm)) echo "checked";?> value="<?php xl('Decline/NC in Functional Skills','e') ?>"/><?php xl('Decline/NC in Functional Skills ', 'e') ?>
<br/><?php xl('Other ','e') ?><input type="text" name="sixty_day_progress_note_decline_clinical_pblm_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_decline_clinical_pblm_other"});?>"/><br/>
<?php xl('Provide Specific Details ','e') ?><input type="text" name="sixty_day_progress_note_decline_clinical_pblm_specific_details" style="width : 73%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_decline_clinical_pblm_specific_details"});?>"/>
</td></tr>

<tr><td>
<b><?php xl('IMPROVEMENT IN CLINICAL ISSUES (Check all that apply)','e') ?></b><br/>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improved in Neuro Status",$clinical_issues)) echo "checked";?> value="<?php xl('Improved in Neuro Status','e') ?>"/><?php xl('Improved in Neuro Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improved in GI Status",$clinical_issues)) echo "checked";?> value="<?php xl('Improved in GI Status','e') ?>"/><?php xl('Improved in GI Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improved in Cardiovascular Status",$clinical_issues)) echo "checked";?> value="<?php xl('Improved in Cardiovascular Status','e') ?>"/><?php xl('Improved in Cardiovascular Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improved in Respiratory Status",$clinical_issues)) echo "checked";?> value="<?php xl('Improved in Respiratory Status','e') ?>"/><?php xl('Improved in Respiratory Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improved in GU Status",$clinical_issues)) echo "checked";?> value="<?php xl('Improved in GU Status','e') ?>"/><?php xl('Improved in GU Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improved in Skin Integrity Alteration",$clinical_issues)) echo "checked";?> value="<?php xl('Improved in Skin Integrity Alteration','e') ?>"/><?php xl('Improved in Skin Integrity Alteration ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improved in Musculoskeletal Status",$clinical_issues)) echo "checked";?> value="<?php xl('Improved in Musculoskeletal Status','e') ?>"/><?php xl('Improved in Musculoskeletal Status ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improvement in Personal Safety",$clinical_issues)) echo "checked";?> value="<?php xl('Improvement in Personal Safety','e') ?>"/><?php xl('Improvement in Personal Safety ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_improvement_in_clinical_issues[]" <?php if (in_array("Improvement in Functional Skills",$clinical_issues)) echo "checked";?> value="<?php xl('Improvement in Functional Skills','e') ?>"/><?php xl('Improvement in Functional Skills ', 'e') ?>
<br/><?php xl('Other ','e') ?><input type="text" name="sixty_day_progress_note_improvement_issues_other" style="width : 80%"  value="<?php echo stripslashes($obj{"sixty_day_progress_note_improvement_issues_other"});?>"/><br/>
<?php xl('Provide Specific Details ','e') ?><input type="text" name="sixty_day_progress_note_improvement_issues_specific_details" style="width : 73%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_improvement_issues_specific_details"});?>"/>
</td></tr>

<tr><td>
<b><?php xl('Living Situation: Patient Lives: ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_living_situation_patient_lives" <?php if ($obj{"sixty_day_progress_note_living_situation_patient_lives"} == "Alone") echo "checked";;?> value="<?php xl('Alone','e') ?>"/><?php xl('Alone ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_living_situation_patient_lives" <?php if ($obj{"sixty_day_progress_note_living_situation_patient_lives"} == "With Spouse/Significant") echo "checked";;?> value="<?php xl('With Spouse/Significant','e') ?>"/><?php xl('With Spouse/Significant ', 'e') ?>
<?php xl(' Other ','e') ?>
<input type="checkbox" name="sixty_day_progress_note_living_situation_patient_lives" size="60px" <?php if ($obj{"sixty_day_progress_note_living_situation_patient_lives"} == "With Family") echo "checked";;?> value="<?php xl('With Family','e') ?>"/><?php xl('With Family ', 'e') ?>
<?php xl(' Who: ','e') ?>
<input type="text" name="sixty_day_progress_note_living_situation_patient_lives_who" style="width : 43%;" value="<?php echo stripslashes($obj{"sixty_day_progress_note_living_situation_patient_lives_who"});?>" /><br/>
<input type="checkbox" name="sixty_day_progress_note_living_situation_patient_lives" <?php if ($obj{"sixty_day_progress_note_living_situation_patient_lives"} == "With Paid Help") echo "checked";;?> value="<?php xl('With Paid Help','e') ?>"/><?php xl('With Paid Help ', 'e') ?>&nbsp; &nbsp; &nbsp;
<?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_living_situation_patient_lives_other" style="width : 72%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_living_situation_patient_lives_other"});?>" /><br/>
<?php xl('Number of Hours Patient is Alone Each Day/Why ','e') ?>
<input type="text" name="sixty_day_progress_note_living_situation_no_hur_day_why" style="width : 63%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_living_situation_no_hur_day_why"});?>" />
</td></tr>

<tr><td>
<b><?php xl('Mental Status ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_mental_status" <?php if ($obj{"sixty_day_progress_note_mental_status"} == "Alert") echo "checked";;?> value="<?php xl('Alert','e') ?>"/><?php xl('Alert ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_mental_status" <?php if ($obj{"sixty_day_progress_note_mental_status"} == "Not Alerted") echo "checked";;?> value="<?php xl('Not Alerted','e') ?>"/><?php xl('Not Alerted ', 'e') ?> &nbsp; &nbsp; &nbsp; 
<?php xl('Oriented to','e') ?>
<input type="checkbox" name="sixty_day_progress_note_mental_status_oriented" <?php if ($obj{"sixty_day_progress_note_mental_status_oriented"} == "Person") echo "checked";;?> value="<?php xl('Person','e') ?>"/><?php xl('Person ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_mental_status_oriented" <?php if ($obj{"sixty_day_progress_note_mental_status_oriented"} == "Place") echo "checked";;?> value="<?php xl('Place','e') ?>"/><?php xl('Place ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_mental_status_oriented" <?php if ($obj{"sixty_day_progress_note_mental_status_oriented"} == "Date") echo "checked";;?> value="<?php xl('Date','e') ?>"/><?php xl('Date ', 'e') ?> &nbsp; &nbsp;
<input type="checkbox" name="sixty_day_progress_note_mental_status_disoriented" <?php if ($obj{"sixty_day_progress_note_mental_status_disoriented"} == "Disoriented") echo "checked";;?> value="<?php xl('Disoriented','e') ?>"/><?php xl('Disoriented ', 'e') ?><br/>
<b><?php xl('Impaired Mental Status Requires the following resources ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" <?php if ($obj{"sixty_day_progress_note_impaired_mental_sta_req_resou"} == "None") echo "checked";;?> value="<?php xl('None','e') ?>"/><?php xl('None ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" <?php if ($obj{"sixty_day_progress_note_impaired_mental_sta_req_resou"} == "Family/Caregiver Support") echo "checked";;?> value="<?php xl('Family/Caregiver Support','e') ?>"/><?php xl('Family/Caregiver Support ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" <?php if ($obj{"sixty_day_progress_note_impaired_mental_sta_req_resou"} == "Guardian") echo "checked";;?> value="<?php xl('Guardian','e') ?>"/><?php xl('Guardian ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" <?php if ($obj{"sixty_day_progress_note_impaired_mental_sta_req_resou"} == "Power of Attorney") echo "checked";;?> value="<?php xl('Power of Attorney','e') ?>"/><?php xl('Power of Attorney ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_impaired_mental_sta_req_resou" <?php if ($obj{"sixty_day_progress_note_impaired_mental_sta_req_resou"} == "Public Conservator") echo "checked";;?> value="<?php xl('Public Conservator','e') ?>"/><?php xl('Public Conservator ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_impaired_mental_sta_req_resou_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_impaired_mental_sta_req_resou_other"});?>" />
</td></tr>

<tr><td>
<b><?php xl('Patient ADL Status: ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" <?php if ($obj{"sixty_day_progress_note_patient_adl_status"} == "Requires Total Assistance") echo "checked";;?> value="<?php xl('Requires Total Assistance','e') ?>"/><?php xl('Requires Total Assistance ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" <?php if ($obj{"sixty_day_progress_note_patient_adl_status"} == "Requires Moderate Assistance") echo "checked";;?> value="<?php xl('Requires Moderate Assistance','e') ?>"/><?php xl('Requires Moderate Assistance ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" <?php if ($obj{"sixty_day_progress_note_patient_adl_status"} == "Requires Minimal Assistance") echo "checked";;?> value="<?php xl('Requires Minimal Assistance','e') ?>"/><?php xl('Requires Minimal Assistance ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" <?php if ($obj{"sixty_day_progress_note_patient_adl_status"} == "Requires Supervision Only") echo "checked";;?> value="<?php xl('Requires Supervision Only','e') ?>"/><?php xl('Requires Supervision Only ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_adl_status" <?php if ($obj{"sixty_day_progress_note_patient_adl_status"} == "Independent") echo "checked";;?> value="<?php xl('Independent','e') ?>"/><?php xl('Independent ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_patient_adl_status_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_patient_adl_status_other"});?>" />
</td></tr>

<tr><td>
<b><?php xl('Ambulatory/Transfer Status: ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" <?php if ($obj{"sixty_day_progress_note_ambulatory_transfer_status"} == "Independent in Ambulation") echo "checked";;?> value="<?php xl('Independent in Ambulation','e') ?>"/><?php xl('Independent in Ambulation ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" <?php if ($obj{"sixty_day_progress_note_ambulatory_transfer_status"} == "Wheelchair Bound") echo "checked";;?> value="<?php xl('Wheelchair Bound','e') ?>"/><?php xl('Wheelchair Bound ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" <?php if ($obj{"sixty_day_progress_note_ambulatory_transfer_status"} == "Bed Bound") echo "checked";;?> value="<?php xl('Bed Bound','e') ?>"/><?php xl('Bed Bound ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" <?php if ($obj{"sixty_day_progress_note_ambulatory_transfer_status"} == "Transfers with Minimal Assistance") echo "checked";;?> value="<?php xl('Transfers with Minimal Assistance','e') ?>"/><?php xl('Transfers with Minimal Assistance ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" <?php if ($obj{"sixty_day_progress_note_ambulatory_transfer_status"} == "Transfers requires two people") echo "checked";;?> value="<?php xl('Transfers requires two people','e') ?>"/><?php xl('Transfers requires two people ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_ambulatory_transfer_status" <?php if ($obj{"sixty_day_progress_note_ambulatory_transfer_status"} == "Uses Assistive Device") echo "checked";;?> value="<?php xl('Uses Assistive Device','e') ?>"/><?php xl('Uses Assistive Device (walker/cane) ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_ambulatory_transfer_status_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_ambulatory_transfer_status_other"});?>" />
</td></tr>

<tr><td>
<b><?php xl('Communication Status: ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_communication_status" <?php if ($obj{"sixty_day_progress_note_communication_status"} == "Good") echo "checked";;?> value="<?php xl('Good','e') ?>"/><?php xl('Good ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_communication_status" <?php if ($obj{"sixty_day_progress_note_communication_status"} == "Average") echo "checked";;?> value="<?php xl('Average','e') ?>"/><?php xl('Average ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_communication_status" <?php if ($obj{"sixty_day_progress_note_communication_status"} == "Poor") echo "checked";;?> value="<?php xl('Poor','e') ?>"/><?php xl('Poor ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_communication_status" <?php if ($obj{"sixty_day_progress_note_communication_status"} == "Needs Interpreter") echo "checked";;?> value="<?php xl('Needs Interpreter','e') ?>"/><?php xl('Needs Interpreter ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_communication_status" <?php if ($obj{"sixty_day_progress_note_communication_status"} == "Non-Verbal") echo "checked";;?> value="<?php xl('Non-Verbal','e') ?>"/><?php xl('Non-Verbal ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_communication_status_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_communication_status_other"});?>" />
</td></tr>

<tr><td>
<b><?php xl('Miscellaneous Abilities: ','e') ?></b><b><?php xl(' Hearing ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_hear" <?php if ($obj{"sixty_day_progress_note_miscellaneous_abi_hear"} == "Average") echo "checked";;?> value="<?php xl('Average','e') ?>"/><?php xl('Average ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_hear" <?php if ($obj{"sixty_day_progress_note_miscellaneous_abi_hear"} == "HOH") echo "checked";;?> value="<?php xl('HOH','e') ?>"/><?php xl('HOH ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_hear" <?php if ($obj{"sixty_day_progress_note_miscellaneous_abi_hear"} == "Wears Hearing Aide") echo "checked";;?> value="<?php xl('Wears Hearing Aide','e') ?>"/><?php xl('Wears Hearing Aide ', 'e') ?>
<br/><?php xl(' Other ','e') ?><input type="text" name="sixty_day_progress_note_miscellaneous_abis_hear_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_miscellaneous_abis_hear_other"});?>" /><br/>
<b><?php xl(' Vision ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_vis" <?php if ($obj{"sixty_day_progress_note_miscellaneous_abi_vis"} == "Average") echo "checked";;?> value="<?php xl('Average','e') ?>"/><?php xl('Average ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_vis" <?php if ($obj{"sixty_day_progress_note_miscellaneous_abi_vis"} == "Poor") echo "checked";;?> value="<?php xl('Poor','e') ?>"/><?php xl('Poor ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_vis" <?php if ($obj{"sixty_day_progress_note_miscellaneous_abi_vis"} == "Blind") echo "checked";;?> value="<?php xl('Blind','e') ?>"/><?php xl('Blind ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_miscellaneous_abi_vis" <?php if ($obj{"sixty_day_progress_note_miscellaneous_abi_vis"} == "Wearing Glasses") echo "checked";;?> value="<?php xl('Wearing Glasses','e') ?>"/><?php xl('Wearing Glasses ', 'e') ?>
<br/><?php xl(' Other ','e') ?><input type="text" name="sixty_day_progress_note_miscellaneous_abi_hear_vis_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_miscellaneous_abi_hear_vis_other"});?>" /><br/>
</td></tr>

<tr><td>
<b><?php xl('Patient Needs Help With ','e') ?></b>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" <?php if ($obj{"sixty_day_progress_note_patient_needs_help_with"} == "Obtaining Food") echo "checked";;?> value="<?php xl('Obtaining Food','e') ?>"/><?php xl('Obtaining Food ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" <?php if ($obj{"sixty_day_progress_note_patient_needs_help_with"} == "Obtaining Medication") echo "checked";;?> value="<?php xl('Obtaining Medication','e') ?>"/><?php xl('Obtaining Medication ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" <?php if ($obj{"sixty_day_progress_note_patient_needs_help_with"} == "Preparing Meals") echo "checked";;?> value="<?php xl('Preparing Meals','e') ?>"/><?php xl('Preparing Meals ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" <?php if ($obj{"sixty_day_progress_note_patient_needs_help_with"} == "Managing Finances") echo "checked";;?> value="<?php xl('Managing Finances','e') ?>"/><?php xl('Managing Finances ', 'e') ?>
<input type="checkbox" name="sixty_day_progress_note_patient_needs_help_with" <?php if ($obj{"sixty_day_progress_note_patient_needs_help_with"} == "Transportation for medical care") echo "checked";;?> value="<?php xl('Transportation for medical care','e') ?>"/><?php xl('Transportation for medical care ', 'e') ?>
<br/><?php xl(' Other ','e') ?>
<input type="text" name="sixty_day_progress_note_patient_needs_help_with_other" style="width : 80%" value="<?php echo stripslashes($obj{"sixty_day_progress_note_patient_needs_help_with_other"});?>" />
</td></tr>

<tr><td>
<b><?php xl('ADDITIONAL INFORMATION','e') ?><br/>
<textarea name="sixty_day_progress_note_additional_information" rows="3" cols="100"><?php echo stripslashes($obj{"sixty_day_progress_note_additional_information"});?></textarea>
</td></tr>

<tr><td style="padding : 0px;">
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr><td style="width : 50%;"><b><?php xl('Clinician Name/Title Completing Note','e') ?></td>
<td style="width : 50%;"></td></tr>
</table>
</td></tr>

</table>
<a href="javascript:top.restoreSession();document.sixty_day_progress_note.submit();"
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

	
