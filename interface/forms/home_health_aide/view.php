<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: home_health_aide");
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
$formTable = "forms_home_health_aide";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();




?>

<html>
<head>
<title>Home Health Aide</title>
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
$obj = formFetch("forms_home_health_aide", $_GET["id"]);

$home_health_medical_issues=explode("#",$obj{"home_health_medical_issues"});
$home_health_patient_need=explode("#",$obj{"home_health_patient_need"});
$home_health_patient_need_dressing=explode("#",$obj{"home_health_patient_need_dressing"});
$home_health_patient_need_haircare=explode("#",$obj{"home_health_patient_need_haircare"});
$home_health_patient_need_hygiene=explode("#",$obj{"home_health_patient_need_hygiene"});
$home_health_patient_need_mobility=explode("#",$obj{"home_health_patient_need_mobility"});
$home_health_patient_need_positioning=explode("#",$obj{"home_health_patient_need_positioning"});
$home_health_patient_need_housekeeping=explode("#",$obj{"home_health_patient_need_housekeeping"});

?>



<form method="post"
		action="<?php echo $rootdir;?>/forms/home_health_aide/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="home_health_aide">
		<h3 align="center"><?php xl('HOME HEALTH AIDE ASSIGNMENT SHEET','e')?></h3>		
		
		


<table width="100%" border="1px" class="formtable">
	<tr>
		<td><strong><?php xl('Patient Name','e');?></strong></td>
		<td><input type="text" name="home_health_patient_name" style="width:100%" value="<?php patientName()?>" readonly ></td>
		<td><strong><?php xl('Patient Address','e');?></strong></td>
		<td><input type="text" name="home_health_patient_address" style="width:100%" value="<?php patientAddress()?>" readonly ></td>
		<td><strong><?php xl('Patient Phone','e');?></strong></td>
		<td><input type="text" name="home_health_patient_phone" style="width:100%" value="<?php patientPhone()?>" readonly ></td>
	</tr>
	<tr>
		<td colspan="6"><strong>
			<?php xl('CARE MANAGER COMPLETING HHA ASSIGNMENT SHEET','e');?><br>
			<?php xl('NAME/TITLE ','e');?>&nbsp;<input type="text" name="home_health_care_manager" style="width:90%" value="<?php echo $obj{"home_health_care_manager"};?>">
			</strong>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('AIDE VISITS','e');?><br>
			<?php xl('FREQUENCY: ','e');?><input type="text" name="home_health_aide_visit_frequency" style="width:25%;" value="<?php echo $obj{"home_health_aide_visit_frequency"};?>">&nbsp;&nbsp;<?php xl('DURATION:','e');?> <input type="text" name="home_health_aide_visit_duration" style="width:25%;" value="<?php echo $obj{"home_health_aide_visit_duration"};?>"><br>
			<?php xl('EFFECTIVE DATE:','e');?>
			
					<input type='text' size='10' name='home_health_aide_visit_effective_date' id='home_health_aide_visit_effective_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"home_health_aide_visit_effective_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"home_health_aide_visit_effective_date", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
					</script>
			
			</strong><br>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('Patient Problem (s)','e');?></strong><br>
			<textarea name="patient_problems" rows="3" style="width:100%;"><?php echo $obj{"patient_problems"};?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong>
			<?php xl('Goals for Care','e');?></strong><br>
			<label><input type="checkbox" name="home_health_goals_for_care" value="<?php xl('Patient Care Management','e');?>" <?php if($obj{"home_health_goals_for_care"}=="Patient Care Management"){ echo "checked"; }?> ><?php xl('Patient Care Management','e');?></label>
			<label><input type="checkbox" name="home_health_goals_for_care" value="<?php xl('ADL Assistance in Personal Care','e');?>" <?php if($obj{"home_health_goals_for_care"}=="ADL Assistance in Personal Care"){ echo "checked"; }?> ><?php xl('ADL Assistance in Personal Care','e');?></label><br>
			<label><?php xl('Other ','e');?>&nbsp;<input type="text" name="home_health_goals_for_care_other" style="width:90%" value="<?php echo $obj{"home_health_goals_for_care_other"};?>"></label>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('Patient Medical Issues/Precautions (Check all that apply)','e');?></strong><br>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('None','e');?>"  <?php if(in_array("None",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('None','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Full-Code','e');?>"  <?php if(in_array("Full-Code",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Full-Code','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Do Not Resuscitate','e');?>"  <?php if(in_array("Do Not Resuscitate",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Do Not Resuscitate','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Seizures','e');?>"  <?php if(in_array("Seizures",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Seizures','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Bleeding','e');?>"  <?php if(in_array("Bleeding",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Bleeding','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Prone to Fractures','e');?>"  <?php if(in_array("Prone to Fractures",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Prone to Fractures','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Hip Precautions','e');?>"  <?php if(in_array("Hip Precautions",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Hip Precautions','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Non-Weight Bearing','e');?>"  <?php if(in_array("Non-Weight Bearing",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Non-Weight Bearing','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Falls Risks','e');?>"  <?php if(in_array("Falls Risks",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Falls Risks','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('SOB','e');?>"  <?php if(in_array("SOB",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('SOB','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('On Oxygen','e');?>"  <?php if(in_array("On Oxygen",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('On Oxygen','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Watch for hyper/hypoglycemia','e');?>"  <?php if(in_array("Watch for hyper/hypoglycemia",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Watch for hyper/hypoglycemia','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Diabetic','e');?>"  <?php if(in_array("Diabetic",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Diabetic','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Do not cut nails','e');?>"  <?php if(in_array("Do not cut nails",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Do not cut nails','e');?></label><br>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Diet','e');?>"  <?php if(in_array("Diet",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Diet ','e');?></label>&nbsp;<input type="text" name="home_health_medical_issues_diet" style="width:90%" value="<?php echo $obj{"home_health_medical_issues_diet"};?>"><br>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Urinary Catheter','e');?>"  <?php if(in_array("Urinary Catheter",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Urinary Catheter','e');?></label>
			<label><input type="checkbox" name="home_health_medical_issues[]" value="<?php xl('Allergies','e');?>"  <?php if(in_array("Allergies",$home_health_medical_issues)) { echo "checked"; }?> ><?php xl('Allergies ','e');?></label>&nbsp;<input type="text" name="home_health_medical_issues_allergies" style="width:75%" value="<?php echo $obj{"home_health_medical_issues_allergies"};?>"><br>
			<label><?php xl('Other ','e');?>&nbsp;<input type="text" name="home_health_medical_issues_other" style="width:90%" value="<?php echo $obj{"home_health_medical_issues_other"};?>"></label>
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Living Situation:','e');?></strong><?php xl(' Patient Lives: ','e');?>
			<label><input type="checkbox" name="home_health_living_situation" value="<?php xl('Alone','e');?>"  <?php if($obj{"home_health_living_situation"}=="Alone"){ echo "checked"; }?> ><?php xl('Alone','e');?></label>
			<label><input type="checkbox" name="home_health_living_situation" value="<?php xl('With Spouse/Significant Other','e');?>" <?php if($obj{"home_health_living_situation"}=="With Spouse/Significant Other"){ echo "checked"; }?> ><?php xl('With Spouse/Significant Other','e');?></label>
			<label><input type="checkbox" name="home_health_living_situation" value="<?php xl('With Family','e');?>" <?php if($obj{"home_health_living_situation"}=="With Family"){ echo "checked"; }?> ><?php xl('With Family','e');?></label>
			<label><input type="checkbox" name="home_health_living_situation" value="<?php xl('With Paid Help','e');?>" <?php if($obj{"home_health_living_situation"}=="With Paid Help"){ echo "checked"; }?> ><?php xl('With Paid Help','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="home_health_living_situation_other" style="width:80%" value="<?php echo $obj{"home_health_living_situation_other"};?>"></label><br>
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Type of Housing: ','e');?></strong>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('House','e');?>"  <?php if($obj{"home_health_type_of_housing"}=="House"){ echo "checked"; }?> ><?php xl('House','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Apartment','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Apartment"){ echo "checked"; }?> ><?php xl('Apartment','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Mobile Home','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Mobile Home"){ echo "checked"; }?> ><?php xl('Mobile Home','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Retirement Community','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Retirement Community"){ echo "checked"; }?> ><?php xl('Retirement Community','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Assisted Living Facility','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Assisted Living Facility"){ echo "checked"; }?> ><?php xl('Assisted Living Facility','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Board and Care','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Board and Care"){ echo "checked"; }?> ><?php xl('Board and Care','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Public Housing','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Public Housing"){ echo "checked"; }?> ><?php xl('Public Housing','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Subsidized Housing','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Subsidized Housing"){ echo "checked"; }?> ><?php xl('Subsidized Housing','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Group Home','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Group Home"){ echo "checked"; }?> ><?php xl('Group Home','e');?></label>
			<label><input type="checkbox" name="home_health_type_of_housing" value="<?php xl('Homeless','e');?>" <?php if($obj{"home_health_type_of_housing"}=="Homeless"){ echo "checked"; }?> ><?php xl('Homeless','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="home_health_type_of_housing_other" style="width:80%" value="<?php echo $obj{"home_health_type_of_housing_other"};?>"></label><br>
			<strong><?php xl('Condition of Housing: ','e');?></strong>
			<label><input type="checkbox" name="home_health_condition_of_housing" value="<?php xl('Adequate','e');?>"  <?php if($obj{"home_health_condition_of_housing"}=="Adequate"){ echo "checked"; }?> ><?php xl('Adequate','e');?></label>
			<label><input type="checkbox" name="home_health_condition_of_housing" value="<?php xl('Inadequate','e');?>" <?php if($obj{"home_health_condition_of_housing"}=="Inadequate"){ echo "checked"; }?> ><?php xl('Inadequate','e');?></label><br>
			<?php xl('Describe Problems/Safety Issues ','e');?><input type="text" name="home_health_problem_safety_issues" style="width:70%" value="<?php echo $obj{"home_health_problem_safety_issues"};?>"></label><br>
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Mental Status: ','e');?></strong>
			<label><input type="checkbox" name="mental_status" value="<?php xl('Alert','e');?>" <?php if($obj{"mental_status"}=="Alert") echo "checked"; ?> ><?php xl('Alert','e');?></label>
			<label><input type="checkbox" name="mental_status" value="<?php xl('Not Alerted','e');?>" <?php if($obj{"mental_status"}=="Not Alerted") echo "checked"; ?> ><?php xl('Not Alerted','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<strong><?php xl('Oriented to: ','e');?></strong>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Person','e');?>" <?php if($obj{"mental_status_oriented_to"}=="Person") echo "checked"; ?> ><?php xl('Person','e');?></label>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Place','e');?>" <?php if($obj{"mental_status_oriented_to"}=="Place") echo "checked"; ?> ><?php xl('Place','e');?></label>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Date','e');?>" <?php if($obj{"mental_status_oriented_to"}=="Date") echo "checked"; ?> ><?php xl('Date','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="mental_status_disoriented" value="<?php xl('Disoriented','e');?>" <?php if($obj{"mental_status_disoriented"}=="Disoriented") echo "checked"; ?> ><?php xl('Disoriented','e');?></label><br>
			<strong><?php xl('Impaired Mental Status Requires the following resources: ','e');?></strong>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('None','e');?>" <?php if($obj{"impaired_mental_status_requires_resources"}=="None") echo "checked"; ?> ><?php xl('None','e');?></label>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('Family/Cregiver Support','e');?>" <?php if($obj{"impaired_mental_status_requires_resources"}=="Family/Cregiver Support") echo "checked"; ?> ><?php xl('Family/Cregiver Support','e');?></label>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('Guardian','e');?>" <?php if($obj{"impaired_mental_status_requires_resources"}=="Guardian") echo "checked"; ?> ><?php xl('Guardian','e');?></label>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('Power of Attorney','e');?>" <?php if($obj{"impaired_mental_status_requires_resources"}=="Power of Attorney") echo "checked"; ?> ><?php xl('Power of Attorney','e');?></label>
			<label><input type="checkbox" name="impaired_mental_status_requires_resources" value="<?php xl('Public Conservator','e');?>" <?php if($obj{"impaired_mental_status_requires_resources"}=="Public Conservator") echo "checked"; ?> ><?php xl('Public Conservator','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="impaired_mental_status_requires_resources_other" style="width:70%" value="<?php echo stripslashes($obj{"impaired_mental_status_requires_resources_other"});?>"></label><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Patient ADL Status: ','e');?></strong>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Total Assistance','e');?>" <?php if($obj{"patient_adl_status"}=="Requires Total Assistance") echo "checked"; ?> ><?php xl('Requires Total Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Moderate Assistance','e');?>" <?php if($obj{"patient_adl_status"}=="Requires Moderate Assistance") echo "checked"; ?> ><?php xl('Requires Moderate Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Minimal Assistance','e');?>" <?php if($obj{"patient_adl_status"}=="Requires Minimal Assistance") echo "checked"; ?> ><?php xl('Requires Minimal Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Supervision Only','e');?>" <?php if($obj{"patient_adl_status"}=="Requires Supervision Only") echo "checked"; ?> ><?php xl('Requires Supervision Only','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Independent','e');?>" <?php if($obj{"patient_adl_status"}=="Independent") echo "checked"; ?> ><?php xl('Independent','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="patient_adl_status_other" style="width:70%" value="<?php echo stripslashes($obj{"patient_adl_status_other"});?>"></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Ambulatory/Transfer Status: ','e');?></strong>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Independent in Ambulation','e');?>" <?php if($obj{"ambulatory_transfer_status"}=="Independent in Ambulation") echo "checked"; ?> ><?php xl('Independent in Ambulation','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Wheelchair Bound','e');?>" <?php if($obj{"ambulatory_transfer_status"}=="Wheelchair Bound") echo "checked"; ?> ><?php xl('Wheelchair Bound','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Bed Bound','e');?>" <?php if($obj{"ambulatory_transfer_status"}=="Bed Bound") echo "checked"; ?> ><?php xl('Bed Bound','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Transfers with Minimal Assistance','e');?>" <?php if($obj{"ambulatory_transfer_status"}=="Transfers with Minimal Assistance") echo "checked"; ?> ><?php xl('Transfers with Minimal Assistance','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Transfers requires two people','e');?>" <?php if($obj{"ambulatory_transfer_status"}=="Transfers requires two people") echo "checked"; ?> ><?php xl('Transfers requires two people','e');?></label>
			<label><input type="checkbox" name="ambulatory_transfer_status" value="<?php xl('Use Assistive Device (Walker/Cane)','e');?>" <?php if($obj{"ambulatory_transfer_status"}=="Use Assistive Device (Walker/Cane)") echo "checked"; ?> ><?php xl('Use Assistive Device (Walker/Cane)','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="ambulatory_transfer_status_other" style="width:93%" value="<?php echo stripslashes($obj{"ambulatory_transfer_status_other"});?>"></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Communication Status: ','e');?></strong>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Good','e');?>" <?php if($obj{"communication_status"}=="Good") echo "checked"; ?> ><?php xl('Good','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Average','e');?>" <?php if($obj{"communication_status"}=="Average") echo "checked"; ?> ><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Poor','e');?>" <?php if($obj{"communication_status"}=="Poor") echo "checked"; ?> ><?php xl('Poor','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Needs Interpreter','e');?>" <?php if($obj{"communication_status"}=="Needs Interpreter") echo "checked"; ?> ><?php xl('Needs Interpreter','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Non Verbal','e');?>" <?php if($obj{"communication_status"}=="Non Verbal") echo "checked"; ?> ><?php xl('Non Verbal','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="communication_status_other" style="width:93%;" value="<?php echo stripslashes($obj{"communication_status_other"});?>"></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="6"><strong><?php xl('Miscellaneous Abilities: ','e');?></strong>
			&nbsp;&nbsp;
			<strong><?php xl('Hearing: ','e');?></strong>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('Average','e');?>" <?php if($obj{"miscellaneous_abilities_hearing"}=="Average") echo "checked"; ?> ><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('HOH','e');?>" <?php if($obj{"miscellaneous_abilities_hearing"}=="HOH") echo "checked"; ?> ><?php xl('HOH','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('Wears Hearing Aid','e');?>" <?php if($obj{"miscellaneous_abilities_hearing"}=="Wears Hearing Aid") echo "checked"; ?> ><?php xl('Wears Hearing Aid','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong><?php xl('Vision: ','e');?></strong>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Average','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Average") echo "checked"; ?> ><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Poor','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Poor") echo "checked"; ?> ><?php xl('Poor','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Blind','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Blind") echo "checked"; ?> ><?php xl('Blind','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Wearing Glasses','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Wearing Glasses") echo "checked"; ?> ><?php xl('Wearing Glasses','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Contacts','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Contacts") echo "checked"; ?> ><?php xl('Contacts','e');?></label><br>
			<strong><?php xl('Dentures: ','e');?></strong>
			<label><input type="checkbox" name="miscellaneous_abilities_dentures" value="<?php xl('Upper','e');?>" <?php if($obj{"miscellaneous_abilities_dentures"}=="Upper") echo "checked"; ?> ><?php xl('Upper','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_dentures" value="<?php xl('Lower','e');?>" <?php if($obj{"miscellaneous_abilities_dentures"}=="Lower") echo "checked"; ?> ><?php xl('Lower','e');?></label>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('Home Health Assignment-Check all tasks that the patient needs. Add specific directions at bottom of assignment list. Must be reviewed and revised at least every 62 days.','e');?></strong>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Bathing','e');?>" <?php if(in_array("Bathing",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Bathing','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_bathing" value="<?php xl('From Bed to Tub/Shower','e');?>" <?php if($obj{"home_health_patient_need_bathing"}=="From Bed to Tub/Shower"){ echo "checked"; }?> ><?php xl('From Bed to Tub/Shower','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_bathing" value="<?php xl('In Bed Bath','e');?>" <?php if($obj{"home_health_patient_need_bathing"}=="In Bed Bath"){ echo "checked"; }?> ><?php xl('In Bed Bath','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_bathing" value="<?php xl('In Chair Bath','e');?>" <?php if($obj{"home_health_patient_need_bathing"}=="In Chair Bath"){ echo "checked"; }?> ><?php xl('In Chair Bath','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Dressing','e');?>" <?php if(in_array("Dressing",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Dressing','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_dressing[]" value="<?php xl('Upper Body','e');?>" <?php if(in_array("Upper Body",$home_health_patient_need_dressing)) { echo "checked"; }?> ><?php xl('Upper Body','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_dressing[]" value="<?php xl('Lower Body','e');?>" <?php if(in_array("Lower Body",$home_health_patient_need_dressing)) { echo "checked"; }?> ><?php xl('Lower Body','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Toileting','e');?>" <?php if(in_array("Toileting",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Toileting','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Hair Care','e');?>" <?php if(in_array("Hair Care",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Hair Care','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_haircare[]" value="<?php xl('Brush','e');?>" <?php if(in_array("Brush",$home_health_patient_need_haircare)) { echo "checked"; }?> ><?php xl('Brush','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_haircare[]" value="<?php xl('Shampoo','e');?>" <?php if(in_array("Shampoo",$home_health_patient_need_haircare)) { echo "checked"; }?> ><?php xl('Shampoo','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Personal Hygiene','e');?>" <?php if(in_array("Personal Hygiene",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Personal Hygiene','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Shave','e');?>" <?php if(in_array("Shave",$home_health_patient_need_hygiene)) { echo "checked"; }?> ><?php xl('Shave','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Nail Care','e');?>" <?php if(in_array("Nail Care",$home_health_patient_need_hygiene)) { echo "checked"; }?> ><?php xl('Nail Care','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Oral Care','e');?>" <?php if(in_array("Oral Care",$home_health_patient_need_hygiene)) { echo "checked"; }?> ><?php xl('Oral Care','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Peri-Care','e');?>" <?php if(in_array("Peri-Care",$home_health_patient_need_hygiene)) { echo "checked"; }?> ><?php xl('Peri-Care','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_hygiene[]" value="<?php xl('Groom','e');?>" <?php if(in_array("Groom",$home_health_patient_need_hygiene)) { echo "checked"; }?> ><?php xl('Groom','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Catheter Care','e');?>" <?php if(in_array("Catheter Care",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Catheter Care','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Elimination Assistance','e');?>" <?php if(in_array("Elimination Assistance",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Elimination Assistance','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Ambulation Assistance','e');?>" <?php if(in_array("Ambulation Assistance",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Ambulation Assistance','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Mobility Assist to','e');?>" <?php if(in_array("Mobility Assist to",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Mobility Assist to','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Chair','e');?>" <?php if(in_array("Chair",$home_health_patient_need_mobility)) { echo "checked"; }?> ><?php xl('Chair','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Commode','e');?>" <?php if(in_array("Commode",$home_health_patient_need_mobility)) { echo "checked"; }?> ><?php xl('Commode','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Tub','e');?>" <?php if(in_array("Tub",$home_health_patient_need_mobility)) { echo "checked"; }?> ><?php xl('Tub','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Shower','e');?>" <?php if(in_array("Shower",$home_health_patient_need_mobility)) { echo "checked"; }?> ><?php xl('Shower','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_mobility[]" value="<?php xl('Bed','e');?>" <?php if(in_array("Bed",$home_health_patient_need_mobility)) { echo "checked"; }?> ><?php xl('Bed','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Active Range of Motion Exercises','e');?>" <?php if(in_array("Active Range of Motion Exercises",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Active Range of Motion Exercises','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Passive Range of Motion Exercises','e');?>" <?php if(in_array("Passive Range of Motion Exercises",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Passive Range of Motion Exercises','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Positioning','e');?>" <?php if(in_array("Positioning",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Positioning','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_positioning[]" value="<?php xl('In Bed','e');?>" <?php if(in_array("In Bed",$home_health_patient_need_positioning)) { echo "checked"; }?> ><?php xl('In Bed','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_positioning[]" value="<?php xl('In Wheelchair','e');?>" <?php if(in_array("In Wheelchair",$home_health_patient_need_positioning)) { echo "checked"; }?> ><?php xl('In Wheelchair','e');?></label>
			
		</td>
		<td colspan="3" valign="top">
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Check Pressure Areas','e');?>" <?php if(in_array("Check Pressure Areas",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Check Pressure Areas (Location)','e');?></label><br>
			<input type="text" name="home_health_patient_need_pressure_location" style="width:93%;" value="<?php echo $obj{"home_health_patient_need_pressure_location"};?>"><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Meal Preparation','e');?>" <?php if(in_array("Meal Preparation",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Meal Preparation','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Assist with Feeding','e');?>" <?php if(in_array("Assist with Feeding",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Assist with Feeding','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Limit','e');?>" <?php if(in_array("Limit",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Limit','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Encourage','e');?>" <?php if(in_array("Encourage",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Encourage','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Fluids','e');?><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Grocery Shopping','e');?>" <?php if(in_array("Grocery Shopping",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Grocery Shopping','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Wash Clothes','e');?>" <?php if(in_array("Wash Clothes",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Wash Clothes','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Light Housekeeping','e');?>" <?php if(in_array("Light Housekeeping",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Light Housekeeping','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_housekeeping[]" value="<?php xl('Bedroom','e');?>" <?php if(in_array("Bedroom",$home_health_patient_need_housekeeping)) { echo "checked"; }?> ><?php xl('Bedroom','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_housekeeping[]" value="<?php xl('Bathroom','e');?>" <?php if(in_array("Bathroom",$home_health_patient_need_housekeeping)) { echo "checked"; }?> ><?php xl('Bathroom','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_housekeeping[]" value="<?php xl('Kitchen','e');?>" <?php if(in_array("Kitchen",$home_health_patient_need_housekeeping)) { echo "checked"; }?> ><?php xl('Kitchen','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Oxygen Care','e');?>" <?php if(in_array("Oxygen Care",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Oxygen Care','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Equipment Care','e');?>" <?php if(in_array("Equipment Care",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Equipment Care','e');?></label><br>
			<input type="text" name="home_health_patient_need_equipment_care" style="width:93%;" value="<?php echo $obj{"home_health_patient_need_equipment_care"};?>"><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Medication Assist/Management','e');?>" <?php if(in_array("Medication Assist/Management",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Medication Assist/Management (Describe)','e');?></label><br>
			<input type="text" name="home_health_patient_need_medication_assist" style="width:93%;" value="<?php echo $obj{"home_health_patient_need_medication_assist"};?>"><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Record Intake/Output','e');?>" <?php if(in_array("Record Intake/Output",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Record Intake/Output','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Record Weight Weekly','e');?>" <?php if(in_array("Record Weight Weekly",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Record Weight Weekly','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Record Vital Signs','e');?>" <?php if(in_array("Record Vital Signs",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Record Vital Signs','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_record_sign" value="<?php xl('Per Visit','e');?>" <?php if($obj{"home_health_patient_need_record_sign"}=="Per Visit"){ echo "checked"; }?> ><?php xl('Per Visit','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="home_health_patient_need_record_sign" value="<?php xl('Weekly','e');?>" <?php if($obj{"home_health_patient_need_record_sign"}=="Weekly"){ echo "checked"; }?> ><?php xl('Weekly','e');?></label><br>
			<label><input type="checkbox" name="home_health_patient_need[]" value="<?php xl('Wound care','e');?>" <?php if(in_array("Wound care",$home_health_patient_need)) { echo "checked"; }?> ><?php xl('Wound care (Check and Reinforce Dressings) (Describe)','e');?></label><br>
			<input type="text" name="home_health_patient_need_wound_care" style="width:93%;" value="<?php echo $obj{"home_health_patient_need_wound_care"};?>">
			
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<strong><?php xl('Additional Instructions','e');?></strong><br>
			<textarea name="additional_instructions" rows="3" style="width:100%;"><?php echo $obj{"additional_instructions"};?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Reviewed/Revised Date: ','e');?></strong>
			<input type='text' size='10' name='review_date_1' id='review_date_1' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"review_date_1"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"review_date_1", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
					</script>
		</td>
		<td colspan="3">
			<strong><?php xl('Signature/Title: ','e');?></strong>
			<input type='text' size='10' name='signature_1' value="<?php echo $obj{"signature_1"};?>">
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Reviewed/Revised Date: ','e');?></strong>
			<input type='text' size='10' name='review_date_2' id='review_date_2' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"review_date_2"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"review_date_2", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
					</script>
		</td>
		<td colspan="3">
			<strong><?php xl('Signature/Title: ','e');?></strong>
			<input type='text' size='10' name='signature_2' value="<?php echo $obj{"signature_2"};?>">
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Reviewed/Revised Date: ','e');?></strong>
			<input type='text' size='10' name='review_date_3' id='review_date_3' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"review_date_3"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date3' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"review_date_3", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
					</script>
		</td>
		<td colspan="3">
			<strong><?php xl('Signature/Title: ','e');?></strong>
			<input type='text' size='10' name='signature_3' value="<?php echo $obj{"signature_3"};?>">
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<strong><?php xl('Clinician Name/Title Completing Note','e');?></strong>
		</td>
		<td colspan="3">
			<strong><?php xl('Electronic Signature','e');?></strong>
		</td>
	</tr>
	
	
	

</table>
<a href="javascript:top.restoreSession();document.home_health_aide.submit();"
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