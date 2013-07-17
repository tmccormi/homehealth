<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: medication_profile");
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
$formTable = "forms_medication_profile";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();


$obj = formFetch("forms_medication_profile", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$medication_start_date = explode("#",$obj{"medication_start_date"});
$medication_code = explode("#",$obj{"medication_code"});
$medication_title = explode("#",$obj{"medication_title"});
$medication_route = explode("#",$obj{"medication_route"});
$medication_dose = explode("#",$obj{"medication_dose"});
$medication_frequency = explode("#",$obj{"medication_frequency"});
$medication_purpose = explode("#",$obj{"medication_purpose"});
$medication_teaching_date = explode("#",$obj{"medication_teaching_date"});
$medication_discharge_date = explode("#",$obj{"medication_discharge_date"});
$info_reviewed_included = explode("#",$obj{"info_reviewed_included"});

?>

<html>
<head>
<title>Medication Profile</title>
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
<script>
var count=<?php echo (count($medication_start_date)+2);?>;
function appendrow()
{
	var htmlrow="<tr>";
	htmlrow+="<td><input type='text' size='10' name='medication_start_date[]' id='medication_start_date_"+count+"' title='yyyy-mm-dd Start Date' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='' readonly/><img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_start_date"+count+"' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='Click here to choose a date'><script	LANGUAGE='JavaScript'>Calendar.setup({inputField:'medication_start_date_"+count+"', ifFormat:'%Y-%m-%d', button:'img_start_date"+count+"'}); <";
	htmlrow+="/script></td>";
	htmlrow+="<td><select name='medication_code[]'><option value=''>Please Select</option><option value='N'>N</option><option value='Existing'>Existing</option><option value='LS'>LS</option><option value='OTC'>OTC</option><option value='C'>C</option><option value='Hold'>Hold</option></select></td>";
	htmlrow+="<td><input type='text' name='medication_title[]' value='' size='10'></td>";
	htmlrow+="<td><select name='medication_route[]'><option value=''>Please Select</option><option value='Oral'>Oral</option><option value='Injection'>Injection</option><option value='Sublingual'>Sublingual</option><option value='Rectal'>Rectal</option><option value='Ocular'>Ocular</option><option value='Nasal'>Nasal</option><option value='Inhalation'>Inhalation</option><option value='Cutaneous'>Cutaneous</option><option value='Transdermal'>Transdermal</option></select></td>";
	htmlrow+="<td><input type='text' name='medication_dose[]' value='' size='10'></td>";
	htmlrow+="<td><select name='medication_frequency[]'><option value=''>Please Select</option><option value='Daily'>Daily</option><option value='Twice per day'>Twice per day</option><option value='Three times per day'>Three times per day</option><option value='Four times per day'>Four times per day</option><option value='Every Morning'>Every Morning</option><option value='Every Afternoon'>Every Afternoon</option><option value='Every night at bedtime'>Every night at bedtime</option><option value='Every Other day'>Every Other day</option><option value='Weekly'>Weekly</option><option value='PRN'>PRN</option></select></td>";
	htmlrow+="<td><input type='text' name='medication_purpose[]' value='' size='10'></td>";
	htmlrow+="<td><input type='text' size='10' name='medication_teaching_date[]' id='medication_teaching_date_"+count+"' title='yyyy-mm-dd Teaching Date' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='' readonly/> <img src='../../pic/show_calendar.gif' align='absbottom' width='24'height='22' id='img_teaching_date"+count+"' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='Click here to choose a date'> <script	LANGUAGE='JavaScript'>Calendar.setup({inputField:'medication_teaching_date_"+count+"', ifFormat:'%Y-%m-%d', button:'img_teaching_date"+count+"'});<";
	htmlrow+="/script></td>";
	htmlrow+="<td><input type='text' size='10' name='medication_discharge_date[]' id='medication_discharge_date_"+count+"' title='yyyy-mm-dd Discharge Date' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='' readonly/> <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_discharge_date"+count+"' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='Click here to choose a date'> <script	LANGUAGE='JavaScript'>Calendar.setup({inputField:'medication_discharge_date_"+count+"', ifFormat:'%Y-%m-%d', button:'img_discharge_date"+count+"'});<";
	htmlrow+="/script></td>";
	htmlrow+="</tr>";
	$("#medication_table").append(htmlrow);
	count++;
}
</script>
</head>
<body class="body_top">




<form method="post"
		action="<?php echo $rootdir;?>/forms/medication_profile/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="medication_profile">
		<h3 align="center"><?php xl('Medication Profile','e')?></h3>	
		
		<div class="formtable">
		<b>
		<?php xl('Patient Name: ','e');?><input type="text" name="patient_name" value="<?php patientName();?>" readonly>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php xl('Medical Record Number: ','e');?><input type="text" name="patient_mr_no" value="<?php  echo $_SESSION['pid']?>" readonly><br>
		<?php xl('Chart: ','e');?><input type="text" name="chart" value="<?php echo $obj{"chart"};?>">&nbsp;&nbsp;&nbsp;&nbsp;
		<?php xl('Episode: ','e');?><input type="text" name="episode" value="<?php echo $obj{"episode"};?>">
		</b>
		</div>


<table width="100%" border="1px" class="formtable">
	<tr>
		<td>
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td>
					<?php xl('SOC: ','e');?>
						<input type='text' size='10' name='soc' id='soc' 
						title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"soc"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date001' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"soc", ifFormat:"%Y-%m-%d", button:"img_curr_date001"});
						</script><br>
					<?php xl('Height: ','e');?><input type="text" name="patient_height" value="" readonly>
				</td>
				<td>
					<?php xl('DOB: ','e');?><input type="text" name="patient_dob" value="<?php patientDOB();?>" readonly><br>
					<?php xl('Weight: ','e');?><input type="text" name="patient_weight" value="" readonly>
				</td>
				<td>
					<?php xl('Certification Period: ','e');?><input type="text" name="certification_period" value="" readonly>
						<input type='text' size='10' name='certification_period' id='certification_period' 
						title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"certification_period"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date002' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"certification_period", ifFormat:"%Y-%m-%d", button:"img_curr_date002"});
						</script><br>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<?php xl('Diagnoses: ','e');?><input type="text" name="diagnoses" value="" readonly><br>
			<?php xl('Allergies: ','e');?><input type="text" name="allergies" value="" readonly>
		</td>
	</tr>
	<tr>
		<td>
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td width="40%">
					<?php xl('Physician Name and Contact Information ','e');?><br>
					<textarea name="physician_contact" rows="3" style="width:100%;" readonly><?php physicianContact();?></textarea>
				</td>
				<td width="60%">
					<table class="formtable">
						<tr>
							<td align="left">
								<?php xl('Pharmacy Name: ','e');?>
							</td>
							<td align="left">
								<input type="text" name="pharmacy_name" value="<?php echo $obj{"pharmacy_name"};?>">
							</td>
						</tr>
						<tr>
							<td align="left">
								<?php xl('Pharmacy Address: ','e');?>
							</td>
							<td align="left">
								<input type="text" name="pharmacy_address" value="<?php echo $obj{"pharmacy_address"};?>">
							</td>
						</tr>
						<tr>
							<td align="left">
								<?php xl('Pharmacy Phone: ','e');?>
							</td>
							<td align="left">
								<input type="text" name="pharmacy_phone" value="<?php echo $obj{"pharmacy_phone"};?>">
							</td>
						</tr>
						<tr>
							<td align="left">
								<?php xl('Pharmacy Fax: ','e');?>
							</td>
							<td align="left">
								<input type="text" name="pharmacy_fax" value="<?php echo $obj{"pharmacy_fax"};?>">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="1px" cellspacing="0" class="formtable" id="medication_table">
				<tr>
					<td align="center">
						<?php xl('Start Date','e');?>
					</td>
					<td align="center">
						<?php xl('Code','e');?>
					</td>
					<td align="center">
						<?php xl('Medications','e');?>
					</td>
					<td align="center">
						<?php xl('Route','e');?>
					</td>
					<td align="center">
						<?php xl('Dose/Amount','e');?>
					</td>
					<td align="center">
						<?php xl('Frequency','e');?>
					</td>
					<td align="center">
						<?php xl('Purpose','e');?>
					</td>
					<td align="center">
						<?php xl('Date Teaching Performed','e');?>
					</td>
					<td align="center">
						<?php xl('Discharge Date','e');?>
					</td>
				</tr>
				<?php
				for($i=0;$i<count($medication_start_date);$i++)
				{
				?>
				<tr>
					<td>
						<input type='text' size='10' name='medication_start_date[]' id='medication_start_date_<?php echo ($i+1);?>' 
						title='<?php xl('yyyy-mm-dd Start Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $medication_start_date[$i];?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_start_date<?php echo ($i+1);?>' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_start_date_<?php echo ($i+1);?>", ifFormat:"%Y-%m-%d", button:"img_start_date<?php echo ($i+1);?>"});
						</script>
					</td>
					<td>
						<select name="medication_code[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('N','e');?>" <?php if($medication_code[$i]=="N"){echo "selected";}?> ><?php xl('N','e');?></option>
							<option value="<?php xl('Existing','e');?>" <?php if($medication_code[$i]=="Existing"){echo "selected";}?> ><?php xl('Existing','e');?></option>
							<option value="<?php xl('LS','e');?>" <?php if($medication_code[$i]=="LS"){echo "selected";}?> ><?php xl('LS','e');?></option>
							<option value="<?php xl('OTC','e');?>" <?php if($medication_code[$i]=="OTC"){echo "selected";}?> ><?php xl('OTC','e');?></option>
							<option value="<?php xl('C','e');?>" <?php if($medication_code[$i]=="C"){echo "selected";}?> ><?php xl('C','e');?></option>
							<option value="<?php xl('Hold','e');?>" <?php if($medication_code[$i]=="Hold"){echo "selected";}?> ><?php xl('Hold','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_title[]" value="<?php echo $medication_title[$i];?>" size="10">
					</td>
					<td>
						<select name="medication_route[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('Oral','e');?>" <?php if($medication_route[$i]=="Oral"){echo "selected";}?> ><?php xl('Oral','e');?></option>
							<option value="<?php xl('Injection','e');?>" <?php if($medication_route[$i]=="Injection"){echo "selected";}?> ><?php xl('Injection','e');?></option>
							<option value="<?php xl('Sublingual','e');?>" <?php if($medication_route[$i]=="Sublingual"){echo "selected";}?> ><?php xl('Sublingual','e');?></option>
							<option value="<?php xl('Rectal','e');?>" <?php if($medication_route[$i]=="Rectal"){echo "selected";}?> ><?php xl('Rectal','e');?></option>
							<option value="<?php xl('Ocular','e');?>" <?php if($medication_route[$i]=="Ocular"){echo "selected";}?> ><?php xl('Ocular','e');?></option>
							<option value="<?php xl('Nasal','e');?>" <?php if($medication_route[$i]=="Nasal"){echo "selected";}?> ><?php xl('Nasal','e');?></option>
							<option value="<?php xl('Inhalation','e');?>" <?php if($medication_route[$i]=="Inhalation"){echo "selected";}?> ><?php xl('Inhalation','e');?></option>
							<option value="<?php xl('Cutaneous','e');?>" <?php if($medication_route[$i]=="Cutaneous"){echo "selected";}?> ><?php xl('Cutaneous','e');?></option>
							<option value="<?php xl('Transdermal','e');?>" <?php if($medication_route[$i]=="Transdermal"){echo "selected";}?> ><?php xl('Transdermal','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_dose[]" value="<?php echo $medication_dose[$i];?>" size="10">
					</td>
					<td>
						<select name="medication_frequency[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('Daily','e');?>" <?php if($medication_frequency[$i]=="Daily"){echo "selected";}?> ><?php xl('Daily','e');?></option>
							<option value="<?php xl('Twice per day','e');?>" <?php if($medication_frequency[$i]=="Twice per day"){echo "selected";}?> ><?php xl('Twice per day','e');?></option>
							<option value="<?php xl('Three times per day','e');?>" <?php if($medication_frequency[$i]=="Three times per day"){echo "selected";}?> ><?php xl('Three times per day','e');?></option>
							<option value="<?php xl('Four times per day','e');?>" <?php if($medication_frequency[$i]=="Four times per day"){echo "selected";}?> ><?php xl('Four times per day','e');?></option>
							<option value="<?php xl('Every Morning','e');?>" <?php if($medication_frequency[$i]=="Every Morning"){echo "selected";}?> ><?php xl('Every Morning','e');?></option>
							<option value="<?php xl('Every Afternoon','e');?>" <?php if($medication_frequency[$i]=="Every Afternoon"){echo "selected";}?> ><?php xl('Every Afternoon','e');?></option>
							<option value="<?php xl('Every night at bedtime','e');?>" <?php if($medication_frequency[$i]=="Every night at bedtime"){echo "selected";}?> ><?php xl('Every night at bedtime','e');?></option>
							<option value="<?php xl('Every Other day','e');?>" <?php if($medication_frequency[$i]=="Every Other day"){echo "selected";}?> ><?php xl('Every Other day','e');?></option>
							<option value="<?php xl('Weekly','e');?>" <?php if($medication_frequency[$i]=="Weekly"){echo "selected";}?> ><?php xl('Weekly','e');?></option>
							<option value="<?php xl('PRN','e');?>" <?php if($medication_frequency[$i]=="PRN"){echo "selected";}?> ><?php xl('PRN','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_purpose[]" value="<?php echo $medication_purpose[$i];?>" size="10">
					</td>
					<td>
						<input type='text' size='10' name='medication_teaching_date[]' id='medication_teaching_date_<?php echo ($i+1);?>' 
						title='<?php xl('yyyy-mm-dd Teaching Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $medication_teaching_date[$i];?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_teaching_date<?php echo ($i+1);?>' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_teaching_date_<?php echo ($i+1);?>", ifFormat:"%Y-%m-%d", button:"img_teaching_date<?php echo ($i+1);?>"});
						</script>
					</td>
					<td>
						<input type='text' size='10' name='medication_discharge_date[]' id='medication_discharge_date_<?php echo ($i+1);?>' 
						title='<?php xl('yyyy-mm-dd Discharge Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $medication_discharge_date[$i];?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_discharge_date<?php echo ($i+1);?>' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_discharge_date_<?php echo ($i+1);?>", ifFormat:"%Y-%m-%d", button:"img_discharge_date<?php echo ($i+1);?>"});
						</script>
					</td>
				</tr>
				<?php
				}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<input type="button" value="<?php xl('Add Medications','e');?>" onclick="appendrow();">
		</td>
	</tr>
	<tr>
		<td>
			<?php xl('Medication information and interactions have been reviewed with: ','e');?>
			<label><input type="checkbox" name="info_reviewed_with" value="<?php xl('Patient','e');?>" <?php if($obj{"info_reviewed_with"}=="Patient"){ echo "checked"; }?> ><?php xl('Patient','e');?></label>
			<label><input type="checkbox" name="info_reviewed_with" value="<?php xl('Caregiver','e');?>" <?php if($obj{"info_reviewed_with"}=="Caregiver"){ echo "checked"; }?> ><?php xl('Caregiver','e');?></label><br>
			<?php xl('Information Reviewed Included ','e');?>&nbsp;&nbsp;
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Medication Information','e');?>" <?php if(in_array("Medication Information",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Medication Information','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Medication Interactions (if Adverse)','e');?>" <?php if(in_array("Medication Interactions (if Adverse)",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Medication Interactions (if Adverse)','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Prescription Refill Information','e');?>" <?php if(in_array("Prescription Refill Information",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Prescription Refill Information','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Disposal of unused and expired medications','e');?>" <?php if(in_array("Disposal of unused and expired medications",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Disposal of unused and expired medications','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Actions to take when does are missed','e');?>" <?php if(in_array("Actions to take when does are missed",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Actions to take when does are missed','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Avoidance of Contamination','e');?>" <?php if(in_array("Avoidance of Contamination",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Avoidance of Contamination','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Role of Diet and Nutrition when taking medications','e');?>" <?php if(in_array("Role of Diet and Nutrition when taking medications",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Role of Diet and Nutrition when taking medications','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Refer to SN Visit Notes for additional medication information taught','e');?>" <?php if(in_array("Refer to SN Visit Notes for additional medication information taught",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Refer to SN Visit Notes for additional medication information taught','e');?></label><br>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Other','e');?>" <?php if(in_array("Other",$info_reviewed_included)) { echo "checked"; }?> ><?php xl('Other','e');?></label>
			&nbsp;&nbsp;<input type="text" name="info_reviewed_included_other" style="width:80%" value="<?php echo $obj{"info_reviewed_included_other"};?>">
		</td>
	</tr>
	<tr>
		<td>
			<table border="1px" class="formtable" width="100%">
				<tr>
					<td width="50%">
						<strong><?php xl('Code:','e');?></strong><br>
						<strong><?php xl('N = ','e');?></strong><u><?php xl('New ','e');?></u><?php xl('medication orders within the last 30 days.','e');?><br>
						<strong><?php xl('Existing = ','e');?></strong><u><?php xl('Existing Medications ','e');?></u><?php xl('patient was taking at the time of admission','e');?><br>
						<strong><?php xl('LS = ','e');?></strong><u><?php xl('Long standing ','e');?></u><?php xl('(60-Days or more)','e');?><br>
						<strong><?php xl('OTC = ','e');?></strong><u><?php xl('Over the counter ','e');?></u><?php xl('medication taken by patient.','e');?><br>
						<strong><?php xl('C = ','e');?></strong><u><?php xl('Change ','e');?></u><?php xl('orders either in dose, frequency or route Within the last 60 days.','e');?><br>
						<strong><?php xl('Hold = ','e');?></strong><u><?php xl('Hold','e');?></u><br>
						<br>
						<strong><?php xl('Frequency:','e');?></strong><br>
						<?php xl('Daily','e');?><br>
						<?php xl('Twice per day','e');?><br>
						<?php xl('Three times per day','e');?><br>
						<?php xl('Four times per day','e');?><br>
						<?php xl('Every Morning','e');?><br>
						<?php xl('Every Afternoon','e');?><br>
						<?php xl('Every night at bedtime','e');?><br>
						<?php xl('Every Other day','e');?><br>
						<?php xl('Weekly','e');?><br>
						<?php xl('PRN','e');?><br>
					</td>
					<td width="50%" valign="top">
						<strong><?php xl('Route:','e');?></strong><br>
						<ul>
							<li><?php xl('Oral=By Mouth','e');?></li>
							<li><?php xl('Injection=including Subcutaneous, Intramuscular, Intravenous, transdermal, Implantation','e');?></li>
							<li><?php xl('Sublingual =Under the Tongue','e');?></li>
							<li><?php xl('Rectal=E.g. Suppository','e');?></li>
							<li><?php xl('Ocular=drugs to treat eye disorders including liquid, gel and ointments','e');?></li>
							<li><?php xl('Nasal=Through Nose','e');?></li>
							<li><?php xl('Inhalation=Through Mouth','e');?></li>
							<li><?php xl('Cutaneous=Applied to Skin including lotion, cream, ointment, powder or gel.','e');?></li>
							<li><?php xl('Transdermal=Delivered body-wide through a patch on skin','e');?></li>
						</ul>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<a href="javascript:top.restoreSession();document.medication_profile.submit();"
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