<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: msw_careplan");
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
$formTable = "forms_msw_careplan";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();




?>

<html>
<head>
<title>MSW Care Plan</title>
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
$obj = formFetch("forms_msw_careplan", $_GET["id"]);
$spouse_significant_others_row1 = explode("#",$obj{"spouse_significant_others_row1"});
$spouse_significant_others_row2 = explode("#",$obj{"spouse_significant_others_row2"});
$spouse_significant_others_row3 = explode("#",$obj{"spouse_significant_others_row3"});
$caregivers_row1 = explode("#",$obj{"caregivers_row1"});
$caregivers_row2 = explode("#",$obj{"caregivers_row2"});
$patient_needs_help_with = explode("#",$obj{"patient_needs_help_with"});
$medical_social_services_interventions = explode("#",$obj{"medical_social_services_interventions"});
$physician_order = explode("#",$obj{"physician_order"});
?>



<form method="post"
		action="<?php echo $rootdir;?>/forms/msw_careplan/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="msw_careplan">
		<h3 align="center"><?php xl('MEDICAL SOCIAL WORKER CARE PLAN','e')?></h3>		
		<h5 align="center">
		<?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
		</h5>
		


<table width="100%"  border="1px" class="formtable">
	<tr>
		<td colspan="4">
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td><?php xl('Patient Name','e');?></td>
				<td width="50%"><input type="text" name="" style="width:100%" value="<?php patientName()?>" readonly ></td>
				<td><?php xl('SOC Date','e');?></td>
				<td width="17%" align="center" valign="top" class="bold">
					<input type='text' size='10' name='SOC_date' id='SOC_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"SOC_date"};?>"  readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"SOC_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
					</script>
				</td>
			</tr>
		</table>
	</tr>
	<tr>
		<td colspan="4">
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td><strong><?php xl('Problem/Reason for Referral','e');?></strong></td>
				<td width="100%"><input type="text" name="problem_reason_for_referel" style="width:90%;" value="<?php echo stripslashes($obj{"problem_reason_for_referel"});?>"></td>
			</tr>
		</table>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Spouse/Significant Others','e');?></strong></td>
	</tr>
	<tr>
		<td><strong><?php xl('Name</strong>','e');?></td>
		<td><strong><?php xl('Relationship','e');?></strong></td>
		<td><strong><?php xl('Address','e');?></strong></td>
		<td><strong><?php xl('Phone','e');?></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="spouse_significant_others_row1[]" style="width:90%" value="<?php echo $spouse_significant_others_row1[0];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row1[]" style="width:90%" value="<?php echo $spouse_significant_others_row1[1];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row1[]" style="width:90%" value="<?php echo $spouse_significant_others_row1[2];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row1[]" style="width:90%" value="<?php echo $spouse_significant_others_row1[3];?>"></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="spouse_significant_others_row2[]" style="width:90%" value="<?php echo $spouse_significant_others_row2[0];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row2[]" style="width:90%" value="<?php echo $spouse_significant_others_row2[1];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row2[]" style="width:90%" value="<?php echo $spouse_significant_others_row2[2];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row2[]" style="width:90%" value="<?php echo $spouse_significant_others_row2[3];?>"></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="spouse_significant_others_row3[]" style="width:90%" value="<?php echo $spouse_significant_others_row3[0];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row3[]" style="width:90%" value="<?php echo $spouse_significant_others_row3[1];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row3[]" style="width:90%" value="<?php echo $spouse_significant_others_row3[2];?>"></strong></td>
		<td><strong><input type="text" name="spouse_significant_others_row3[]" style="width:90%" value="<?php echo $spouse_significant_others_row3[3];?>"></strong></td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Caregiver(s) (if different from above)','e');?></strong></td>
	</tr>
	<tr>
		<td><strong><?php xl('Name','e');?></strong></td>
		<td><strong><?php xl('Relationship','e');?></strong></td>
		<td><strong><?php xl('Address','e');?></strong></td>
		<td><strong><?php xl('Phone','e');?></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="caregivers_row1[]" style="width:90%" value="<?php echo $caregivers_row1[0];?>"></strong></td>
		<td><strong><input type="text" name="caregivers_row1[]" style="width:90%" value="<?php echo $caregivers_row1[1];?>"></strong></td>
		<td><strong><input type="text" name="caregivers_row1[]" style="width:90%" value="<?php echo $caregivers_row1[2];?>"></strong></td>
		<td><strong><input type="text" name="caregivers_row1[]" style="width:90%" value="<?php echo $caregivers_row1[3];?>"></strong></td>
	</tr>
	<tr>
		<td><strong><input type="text" name="caregivers_row2[]" style="width:90%" value="<?php echo $caregivers_row2[0];?>"></strong></td>
		<td><strong><input type="text" name="caregivers_row2[]" style="width:90%" value="<?php echo $caregivers_row2[1];?>"></strong></td>
		<td><strong><input type="text" name="caregivers_row2[]" style="width:90%" value="<?php echo $caregivers_row2[2];?>"></strong></td>
		<td><strong><input type="text" name="caregivers_row2[]" style="width:90%" value="<?php echo $caregivers_row2[3];?>"></strong></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><strong><?php xl('SOCIAL, ENVIRONMENTAL, FINANCIAL FACTORS THAT IMPACT PATIENT\'S ILLNESS AND REQUIRE INTERVENTIONS','e');?></strong></td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Living Situation: Patient Lives: ','e');?></strong>
			<label><input type="checkbox" name="patient_lives" value="<?php xl('Alone','e');?>" <?php if($obj{"patient_lives"}=="Alone") echo "checked"; ?> ><?php xl('Alone','e');?></label>
			<label><input type="checkbox" name="patient_lives" value="<?php xl('With Spouse/Significant Other','e');?>" <?php if($obj{"patient_lives"}=="With Spouse/Significant Other") echo "checked"; ?> ><?php xl('With Spouse/Significant Other','e');?></label>
			<label><input type="checkbox" name="patient_lives" value="<?php xl('With Family','e');?>" <?php if($obj{"patient_lives"}=="With Family") echo "checked"; ?> ><?php xl('With Family','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php xl('Who:','e');?><input type="text" name="patient_lives_with_who" size="20" value="<?php echo stripslashes($obj{"patient_lives_with_who"});?>"></label><br>
			<label><input type="checkbox" name="patient_lives" value="<?php xl('With Paid Help','e');?>" <?php if($obj{"patient_lives"}=="With Paid Help") echo "checked"; ?> ><?php xl('With Paid Help','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php xl('Other','e');?><input type="text" name="patient_lives_other" style="width:80%" value="<?php echo stripslashes($obj{"patient_lives_other"});?>"></label><br>
			<label><?php xl('Number of Hours Patient is Alone Each Day/Why ','e');?><input type="text" name="no_of_hours_patient_alone" style="width:40%" value="<?php echo stripslashes($obj{"no_of_hours_patient_alone"});?>"></label><br>
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Type of Housing: ','e');?></strong>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('House','e');?>" <?php if($obj{"type_of_housing"}=="House") echo "checked"; ?> ><?php xl('House','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Apartment','e');?>" <?php if($obj{"type_of_housing"}=="Appartment") echo "checked"; ?> ><?php xl('Appartment','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Mobile Home','e');?>" <?php if($obj{"type_of_housing"}=="Mobile Home") echo "checked"; ?> ><?php xl('Mobile Home','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Retirement Community','e');?>" <?php if($obj{"type_of_housing"}=="Retirement Community") echo "checked"; ?> ><?php xl('Retirement Community','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Assisted Living Facility','e');?>" <?php if($obj{"type_of_housing"}=="Assisted Living Facility") echo "checked"; ?> ><?php xl('Assisted Living Facility','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Board and Care','e');?>" <?php if($obj{"type_of_housing"}=="Board and Care") echo "checked"; ?> ><?php xl('Board and Care','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Public Housing','e');?>" <?php if($obj{"type_of_housing"}=="Public Housing") echo "checked"; ?> ><?php xl('Public Housing','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Subsidized Housing','e');?>" <?php if($obj{"type_of_housing"}=="Subsidized Housing") echo "checked"; ?> ><?php xl('Subsidized Housing','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Group Home','e');?>" <?php if($obj{"type_of_housing"}=="Group Home") echo "checked"; ?> ><?php xl('Group Home','e');?></label>
			<label><input type="checkbox" name="type_of_housing" value="<?php xl('Homeless','e');?>" <?php if($obj{"type_of_housing"}=="Homeless") echo "checked"; ?> ><?php xl('Homeless','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="type_of_housing_other" style="width:80%" value="<?php echo stripslashes($obj{"type_of_housing_other"});?>"></label><br>
			<strong><?php xl('Condition of Housing: ','e');?></strong>
			<label><input type="checkbox" name="condition_of_housing" value="<?php xl('Adequate','e');?>" <?php if($obj{"condition_of_housing"}=="Adequate") echo "checked"; ?> ><?php xl('Adequate','e');?></label>
			<label><input type="checkbox" name="condition_of_housing" value="<?php xl('Inadequate','e');?>" <?php if($obj{"condition_of_housing"}=="Inadequate") echo "checked"; ?> ><?php xl('Inadequate','e');?></label><br>
			<?php xl('Describe Problems/Safety Issues ','e');?><input type="text" name="problem_safety_issues" style="width:70%" value="<?php echo stripslashes($obj{"problem_safety_issues"});?>"></label><br>
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Mental Status: ','e');?></strong>
			<label><input type="checkbox" name="mental_status" value="<?php xl('Alert','e');?>" <?php if($obj{"mental_status"}=="Alert") echo "checked"; ?> ><?php xl('Alert','e');?></label>
			<label><input type="checkbox" name="mental_status" value="<?php xl('Not Alerted','e');?>" <?php if($obj{"mental_status"}=="Not Alerted") echo "checked"; ?> ><?php xl('Not Alerted','e');?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<?php xl('Oriented to: ','e');?>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Person','e');?>" <?php if($obj{"mental_status_oriented_to"}=="Person") echo "checked"; ?> ><?php xl('Person','e');?></label>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Place','e');?>" <?php if($obj{"mental_status_oriented_to"}=="Place") echo "checked"; ?> ><?php xl('Place','e');?></label>
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Date','e');?>" <?php if($obj{"mental_status_oriented_to"}=="Date") echo "checked"; ?> ><?php xl('Date','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="mental_status_oriented_to" value="<?php xl('Disoriented','e');?>" <?php if($obj{"mental_status_oriented_to"}=="Disoriented") echo "checked"; ?> ><?php xl('Disoriented','e');?></label><br>
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
		<td colspan="4"><strong><?php xl('Patient ADL Status: ','e');?></strong>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Total Assistance','e');?>" <?php if($obj{"patient_adl_status"}=="Requires Total Assistance") echo "checked"; ?> ><?php xl('Requires Total Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Moderate Assistance','e');?>" <?php if($obj{"patient_adl_status"}=="Requires Moderate Assistance") echo "checked"; ?> ><?php xl('Requires Moderate Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Minimal Assistance','e');?>" <?php if($obj{"patient_adl_status"}=="Requires Minimal Assistance") echo "checked"; ?> ><?php xl('Requires Minimal Assistance','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Requires Supervision Only','e');?>" <?php if($obj{"patient_adl_status"}=="Requires Supervision Only") echo "checked"; ?> ><?php xl('Requires Supervision Only','e');?></label>
			<label><input type="checkbox" name="patient_adl_status" value="<?php xl('Independent','e');?>" <?php if($obj{"patient_adl_status"}=="Independent") echo "checked"; ?> ><?php xl('Independent','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php xl('Other','e');?><input type="text" name="patient_adl_status_other" style="width:70%" value="<?php echo stripslashes($obj{"patient_adl_status_other"});?>"></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Ambulatory/Transfer Status: ','e');?></strong>
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
		<td colspan="4"><strong><?php xl('Communication Status: ','e');?></strong>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Good','e');?>" <?php if($obj{"communication_status"}=="Good") echo "checked"; ?> ><?php xl('Good','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Average','e');?>" <?php if($obj{"communication_status"}=="Average") echo "checked"; ?> ><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Poor','e');?>" <?php if($obj{"communication_status"}=="Poor") echo "checked"; ?> ><?php xl('Poor','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Needs Interpreter','e');?>" <?php if($obj{"communication_status"}=="Needs Interpreter") echo "checked"; ?> ><?php xl('Needs Interpreter','e');?></label>
			<label><input type="checkbox" name="communication_status" value="<?php xl('Non Verbal','e');?>" <?php if($obj{"communication_status"}=="Non Verbal") echo "checked"; ?> ><?php xl('Non Verbal','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="communication_status_other" style="width:93%;" value="<?php echo stripslashes($obj{"communication_status_other"});?>"></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Miscellaneous Abilities: ','e');?></strong>
			&nbsp;&nbsp;
			<?php xl('Hearing: ','e');?>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('Average','e');?>" <?php if($obj{"miscellaneous_abilities_hearing"}=="Average") echo "checked"; ?> ><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('HOH','e');?>" <?php if($obj{"miscellaneous_abilities_hearing"}=="HOH") echo "checked"; ?> ><?php xl('HOH','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_hearing" value="<?php xl('Wears Hearing Aid','e');?>" <?php if($obj{"miscellaneous_abilities_hearing"}=="Wears Hearing Aid") echo "checked"; ?> ><?php xl('Wears Hearing Aid','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php xl('Other','e');?><input type="text" name="miscellaneous_abilities_hearing_other" style="width:30%;" value="<?php echo stripslashes($obj{"miscellaneous_abilities_hearing_other"});?>"></label><br>
			<?php xl('Vision: ','e');?>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Average','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Average") echo "checked"; ?> ><?php xl('Average','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Poor','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Poor") echo "checked"; ?> ><?php xl('Poor','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Blind','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Blind") echo "checked"; ?> ><?php xl('Blind','e');?></label>
			<label><input type="checkbox" name="miscellaneous_abilities_vision" value="<?php xl('Wearing Glasses','e');?>" <?php if($obj{"miscellaneous_abilities_vision"}=="Wearing Glasses") echo "checked"; ?> ><?php xl('Wearing Glasses','e');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php xl('Other','e');?><input type="text" name="miscellaneous_abilities_vision_other" style="width:30%;" value="<?php echo stripslashes($obj{"miscellaneous_abilities_vision_other"});?>"></label>
			
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Patient Needs Help With: ','e');?></strong>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Obtaining Food','e');?>" <?php if(in_array("Obtaining Food",$patient_needs_help_with)) echo "checked"; ?> ><?php xl('Obtaining Food','e');?></label>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Obtaining Medication','e');?>" <?php if(in_array("Obtaining Medication",$patient_needs_help_with)) echo "checked"; ?> ><?php xl('Obtaining Medication','e');?></label>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Preparing meals','e');?>" <?php if(in_array("Preparing meals",$patient_needs_help_with)) echo "checked"; ?> ><?php xl('Preparing meals','e');?></label>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Managing Finances','e');?>" <?php if(in_array("Managing Finances",$patient_needs_help_with)) echo "checked"; ?> ><?php xl('Managing Finances','e');?></label>
			<label><input type="checkbox" name="patient_needs_help_with[]" value="<?php xl('Transportation for Medical care','e');?>" <?php if(in_array("Transportation for Medical care",$patient_needs_help_with)) echo "checked"; ?> ><?php xl('Transportation for Medical care','e');?></label><br>
			<label><?php xl('Other','e');?><input type="text" name="patient_needs_help_with_other" size="35" value="<?php echo stripslashes($obj{"patient_needs_help_with_other"});?>"></label><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="4" align="center"><strong><?php xl('POTENTIAL OUTCOMES','e');?></strong></td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" border="1px" class="formtable">
				<tr>
					<td align="center" valign="middle">
						<?php xl('Patient Desired','e');?>
					</td>
					<td align="center" valign="middle">
						<?php xl('Short Term','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php xl('Time Frame','e');?>
					</td>
					<td align="center" valign="middle">
						<?php xl('Long Term','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Time Frame','e');?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">
						<textarea rows="5" cols="20" name="patient_desired"><?php echo stripslashes($obj{"patient_desired"});?></textarea>
					</td>
					<td align="center" valign="middle">
						<textarea rows="5" cols="20" name="short_term_time_frame"><?php echo stripslashes($obj{"short_term_time_frame"});?></textarea>
					</td>
					<td align="center" valign="middle">
						<textarea rows="5" cols="20" name="long_term_time_frame"><?php echo stripslashes($obj{"long_term_time_frame"});?></textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" border="1px" class="formtable">
				<tr>
					<td valign="middle" width="50%">
						<strong><?php xl('MEDICAL SOCIAL SERVICES INTERVENTIONS','e');?></strong>
					</td>
					<td align="center" valign="middle" width="20%">
						<strong><?php xl('SOC Date','e');?></strong>
					</td>
					<td align="center" valign="middle" width="30%">
						<input type='text' size='10' name='SOC_date' id='SOC_date2' 
						title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"SOC_date"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"SOC_date2", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
						</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" width="50%">
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Assessment Only of Social and Emotional Factors','e');?>" <?php if(in_array("Assessment Only of Social and Emotional Factors",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Assessment Only of Social and Emotional Factors','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Identification of eligibility for services/benefits','e');?>" <?php if(in_array("Identification of eligibility for services/benefits",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Identification of eligibility for services/benefits','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Identification of Counseling for long-range, planning and decision making','e');?>" <?php if(in_array("Identification of Counseling for long-range, planning and decision making",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Identification of Counseling for long-range, planning and decision making','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Short term therapy','e');?>" <?php if(in_array("Short term therapy",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Short term therapy','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Community Resource Planning','e');?>" <?php if(in_array("Community Resource Planning",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Community Resource Planning','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Identification of Alternative Living Arrangement to a','e');?>" <?php if(in_array("Identification of Alternative Living Arrangement to a",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Identification of Alternative Living Arrangement to a','e');?></label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Higher Level of Care','e');?>" <?php if(in_array("Higher Level of Care",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Higher Level of Care','e');?></label>&nbsp;&nbsp;or
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Lower Level of Care','e');?>" <?php if(in_array("Lower Level of Care",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Lower Level of Care','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Coordination of transportation for medical appointments','e');?>" <?php if(in_array("Coordination of transportation for medical appointments",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Coordination of transportation for medical appointments','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Coordination of meal delivery services','e');?>" <?php if(in_array("Coordination of meal delivery services",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Coordination of meal delivery services','e');?></label><br>
		</td>
		<td colspan="2" width="50%">
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Facilitation of family interactions, discussion with patient and significant others','e');?>" <?php if(in_array("Facilitation of family interactions, discussion with patient and significant others",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Facilitation of family interactions, discussion with patient and significant others','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Teaching/Training about coping strategies, stress management, in managing disease process','e');?>" <?php if(in_array("Teaching/Training about coping strategies, stress management, in managing disease process",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Teaching/Training about coping strategies, stress management, in managing disease process','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Grief/Bereavement identification of rist factors and training in adopting to loss','e');?>" <?php if(in_array("Grief/Bereavement identification of rist factors and training in adopting to loss",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Grief/Bereavement identification of rist factors and training in adopting to loss','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Crisis Intervention','e');?>" <?php if(in_array("Crisis Intervention",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Crisis Intervention','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Financial resource identification and training','e');?>" <?php if(in_array("Financial resource identification and training",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Financial resource identification and training','e');?></label><br>
			<label><input type="checkbox" name="medical_social_services_interventions[]" value="<?php xl('Facilitation and Education on advance directives, wills, funeral, burial plans','e');?>" <?php if(in_array("Facilitation and Education on advance directives, wills, funeral, burial plans",$medical_social_services_interventions)) echo "checked"; ?> ><?php xl('Facilitation and Education on advance directives, wills, funeral, burial plans','e');?></label><br>
			Other Services: <input type="text" name="medical_social_services_interventions_other" style="width:50%;" value="<?php echo stripslashes($obj{"medical_social_services_interventions_other"});?>">
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('ANALYSIS OF FINDINGS','e');?></strong><br>
			<textarea name="analysis_of_finding" rows="3" style="width:100%;"><?php echo stripslashes($obj{"analysis_of_finding"});?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('REVIEW OF INTERVENTIONS/RECOMMENDATIONS','e');?></strong><br>
			<textarea name="review_of_interventions" rows="3" style="width:100%;"><?php echo stripslashes($obj{"review_of_interventions"});?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('EVALUATION OF PATIENT/CLIENT/CAREGIVER RESPONSE TO RECOMMENDATIONS(IF ANY)','e');?></strong><br>
			<textarea name="evaluation_of_patient" rows="3" style="width:100%;"><?php echo stripslashes($obj{"evaluation_of_patient"});?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('CONTINUED TREATMENT PLAN ','e');?><br>
			<?php xl('FREQUENCY: ','e');?><input type="text" name="continued_treatmentplan_frequency" style="width:25%;" value="<?php echo stripslashes($obj{"continued_treatmentplan_frequency"});?>">&nbsp;&nbsp;<?php xl('DURATION:','e');?> <input type="text" name="continued_treatmentplan_duration" style="width:25%;" value="<?php echo stripslashes($obj{"continued_treatmentplan_duration"});?>"><br>
			<?php xl('EFFECTIVE DATE:','e');?>
			
					<input type='text' size='10' name='continued_treatmentplan_effective_date' id='continued_treatmentplan_effective_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"continued_treatmentplan_effective_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date3' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"continued_treatmentplan_effective_date", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
					</script>
			
			</strong><br>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<strong><?php xl('MSW Care Plan was communicated to and agreed upon by ','e');?></strong>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Patient','e');?>" <?php if($obj{"msw_careplan_communicated_agreed"}=="Patient") echo "checked"; ?> ><?php xl('Patient','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Physician','e');?>" <?php if($obj{"msw_careplan_communicated_agreed"}=="Physician") echo "checked"; ?> ><?php xl('Physician','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('PT/OT/ST','e');?>" <?php if($obj{"msw_careplan_communicated_agreed"}=="PT/OT/ST") echo "checked"; ?> ><?php xl('PT/OT/ST','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Skilled Nursing','e');?>" <?php if($obj{"msw_careplan_communicated_agreed"}=="Skilled Nursing") echo "checked"; ?> ><?php xl('Skilled Nursing','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Caregiver/Family','e');?>" <?php if($obj{"msw_careplan_communicated_agreed"}=="Caregiver/Family") echo "checked"; ?> ><?php xl('Caregiver/Family','e');?></label>
			<label><input type="checkbox" name="msw_careplan_communicated_agreed" value="<?php xl('Case Manager','e');?>" <?php if($obj{"msw_careplan_communicated_agreed"}=="Case Manager") echo "checked"; ?> ><?php xl('Case Manager','e');?></label>
			<?php xl('Other: ','e');?><input type="text" name="msw_careplan_communicated_agreed_other" style="width:25%;" value="<?php echo stripslashes($obj{"msw_careplan_communicated_agreed_other"});?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="4"><strong><?php xl('Patient/Caregiver/Family Response to Care Plan and Occupational Therapy','e');?></strong></td>
	</tr>
	<tr>
		<td colspan="2" width="50%">
			<strong><?php xl('Physician Orders','e');?></strong><br>
			<label><input type="checkbox" name="physician_order[]" value="<?php xl('MSW Evaluation Only Physician orders obtained','e');?>" <?php if(in_array("MSW Evaluation Only Physician orders obtained",$physician_order)) echo "checked"; ?> ><?php xl('MSW Evaluation Only Physician orders obtained','e');?></label><br>
			<label><input type="checkbox" name="physician_order[]" value="<?php xl('Physician orders needed for follow-up.','e');?>" <?php if(in_array("Physician orders needed for follow-up.",$physician_order)) echo "checked"; ?> ><?php xl('Physician orders needed for follow-up.','e');?></label><br>
			<strong><?php xl('Will follow agency\'s procedures for obtaining verbal orders and completing the 485/POC or submitting supplemental orders for physician signature','e');?></strong>
		</td>
		<td colspan="2" width="50%">
			<?php xl('Other Comments','e');?>
			<textarea name="other_comments" rows="4" style="width:100%;"><?php echo stripslashes($obj{"other_comments"});?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2" width="50%">
			<strong><?php xl('Therapist Who Developed POC','e');?></strong><?php xl('(Name and Title)','e');?>
		</td>
		<td colspan="2" width="50%">
			<strong><?php xl('Electronic Signature','e');?></strong>
		</td>
	</tr>

</table>
<a href="javascript:top.restoreSession();document.msw_careplan.submit();"
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