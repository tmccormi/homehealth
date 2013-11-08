<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: oasis_discharge");
/* include api.inc. also required. */
require_once($GLOBALS['srcdir'].'/api.inc');
/* include our smarty derived controller class. */
require($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');
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
$formTable = "forms_oasis_discharge";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();


?>

<html>
<head>
<title>Oasis Discharge</title>
<style type="text/css">
.bold {
	font-weight: bold;
}
table label, input { display:inline !important; }
a { font-size:12px; }
ul { list-style:none; padding:0; margin:0px; margin:0px 10px; }
#oasis li { padding:5px 0px;}
#oasis li div { border-bottom:1px solid #000000; padding:5px 0px; }
#oasis li a#black { color:#000000; font-weight:bold; font-size:13px; }
#oasis li ul { display:none; }
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
<!--For Form Validaion--><script src="<?php echo $GLOBALS['webroot'] ?>/library/js/form_validation.js" type="text/javascript"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/css/jquery-ui-1.8.21.custom.css" type="text/css" media="all" />
<script>
	$(document).ready(function(){
	   $('#oasis li div').click(function(){ $(this).next('ul').slideToggle('fast'); 
		var text = ($(this).children('span').children('a').text() == '(Expand)') ? '(Collapse)' : '(Expand)';
		$(this).children('span').children('a').text(text);
	});
	});
	function fonChange(obj,code_type,condition) {
			$("#"+obj.id).autocomplete({
			minLength: 0,
			source: "../../../library/ajax/get_icd9codes.php?code_type="+code_type+"&condition="+condition,
			focus: function( event, ui ) {
			var id=$(this).attr('id');
			
				$(this).val( ui.item.code );
				return false;
			},
			select: function( event, ui ) {
			var id=$(this).attr('id');
			
				$(this).val( ui.item.code );
				return false;
			}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( '<a>'+item.code+'</a>')
				.appendTo( ul );
		};
		}
		
	function select_pain(scale)
	{
		$('input:radio[name=oasis_therapy_pain_scale]')[scale].checked = true;
		
	}
	
	function sum_braden_scale()
	{
		$("#braden_total").val(parseInt($("#braden_sensory").val())+parseInt($("#braden_moisture").val())+parseInt($("#braden_activity").val())+parseInt($("#braden_mobility").val())+parseInt($("#braden_nutrition").val())+parseInt($("#braden_friction").val()));
	}
	
	function sumfallrisk(box)
	{
		if(box.checked)
		{
		$("#oasis_therapy_fall_risk_assessment_total").val(parseInt($("#oasis_therapy_fall_risk_assessment_total").val())+1);
		}
		else
		{
		$("#oasis_therapy_fall_risk_assessment_total").val(parseInt($("#oasis_therapy_fall_risk_assessment_total").val())-1);
		}
	}
	function calc_avg()
	{
	$("#oasis_therapy_timed_up_average").val((parseInt($("#oasis_therapy_timed_up_trial1").val())+parseInt($("#oasis_therapy_timed_up_trial2").val()))/2);
	}





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
	
		
function nut_sum(box,valu){
var tot=parseInt($("#nutrition_total").val());
if(box.checked)
{
tot=tot+valu;
$("#nutrition_total").val(tot);
}
else
{
tot=tot-valu;
$("#nutrition_total").val(tot);
}
}

</script>

<script>
function requiredCheck(){
    var time_in = document.getElementById('time_in').value;
    var time_out = document.getElementById('time_out').value;
    
				if(time_in != "" && time_out != "") {
        return true;
    } else {
        alert("Please select a time in and time out before submitting.");
        return false;
    }
}
</script>
</head>
<body class="body_top">
<?php
$obj = formFetch("forms_oasis_discharge", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$oasis_system_review = explode("#",$obj{"oasis_system_review"});
$oasis_therapy_pain_relieving_factors = explode("#",$obj{"oasis_therapy_pain_relieving_factors"});
$oasis_nutrition_eat_patt1 = explode("#",$obj{"oasis_nutrition_eat_patt1"});
$oasis_nutrition_risks = explode("#",$obj{"oasis_nutrition_risks"});
$oasis_therapy_vital_sign_blood_pressure = explode("#",$obj{"oasis_therapy_vital_sign_blood_pressure"});
$oasis_therapy_vital_sign_pulse_type = explode("#",$obj{"oasis_therapy_vital_sign_pulse_type"});
$oasis_therapy_breath_sounds = explode("#",$obj{"oasis_therapy_breath_sounds"});
$oasis_therapy_heart_sounds = explode("#",$obj{"oasis_therapy_heart_sounds"});
$oasis_therapy_pressure_ulcer_a = explode("#",$obj{"oasis_therapy_pressure_ulcer_a"});
$oasis_therapy_pressure_ulcer_b = explode("#",$obj{"oasis_therapy_pressure_ulcer_b"});
$oasis_therapy_pressure_ulcer_c = explode("#",$obj{"oasis_therapy_pressure_ulcer_c"});
$oasis_therapy_pressure_ulcer_d1 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d1"});
$oasis_therapy_pressure_ulcer_d2 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d2"});
$oasis_therapy_pressure_ulcer_d3 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d3"});
$oasis_therapy_wound_lesion_location = explode("#",$obj{"oasis_therapy_wound_lesion_location"});
$oasis_therapy_wound_lesion_type = explode("#",$obj{"oasis_therapy_wound_lesion_type"});
$oasis_therapy_wound_lesion_status = explode("#",$obj{"oasis_therapy_wound_lesion_status"});
$oasis_therapy_wound_lesion_size_length = explode("#",$obj{"oasis_therapy_wound_lesion_size_length"});
$oasis_therapy_wound_lesion_size_width = explode("#",$obj{"oasis_therapy_wound_lesion_size_width"});
$oasis_therapy_wound_lesion_size_depth = explode("#",$obj{"oasis_therapy_wound_lesion_size_depth"});
$oasis_therapy_wound_lesion_stage = explode("#",$obj{"oasis_therapy_wound_lesion_stage"});
$oasis_therapy_wound_lesion_tunneling = explode("#",$obj{"oasis_therapy_wound_lesion_tunneling"});
$oasis_therapy_wound_lesion_odor = explode("#",$obj{"oasis_therapy_wound_lesion_odor"});
$oasis_therapy_wound_lesion_skin = explode("#",$obj{"oasis_therapy_wound_lesion_skin"});
$oasis_therapy_wound_lesion_edema = explode("#",$obj{"oasis_therapy_wound_lesion_edema"});
$oasis_therapy_wound_lesion_stoma = explode("#",$obj{"oasis_therapy_wound_lesion_stoma"});
$oasis_therapy_wound_lesion_appearance = explode("#",$obj{"oasis_therapy_wound_lesion_appearance"});
$oasis_therapy_wound_lesion_drainage = explode("#",$obj{"oasis_therapy_wound_lesion_drainage"});
$oasis_therapy_wound_lesion_color = explode("#",$obj{"oasis_therapy_wound_lesion_color"});
$oasis_therapy_wound_lesion_consistency = explode("#",$obj{"oasis_therapy_wound_lesion_consistency"});
$oasis_therapy_wound = explode("#",$obj{"oasis_therapy_wound"});
$oasis_therapy_respiratory_treatment = explode("#",$obj{"oasis_therapy_respiratory_treatment"});
$oasis_cardiac_status_heart_failure = explode("#",$obj{"oasis_cardiac_status_heart_failure"});
$oasis_neuro_cognitive_symptoms = explode("#",$obj{"oasis_neuro_cognitive_symptoms"});
$oasis_emergent_care_reason = explode("#",$obj{"oasis_emergent_care_reason"});
$non_oasis_infusion = explode("#",$obj{"non_oasis_infusion"});
$non_oasis_infusion_purpose = explode("#",$obj{"non_oasis_infusion_purpose"});
$non_oasis_enteral = explode("#",$obj{"non_oasis_enteral"});
$non_oasis_skilled_care = explode("#",$obj{"non_oasis_skilled_care"});
$non_oasis_summary_disciplines = explode("#",$obj{"non_oasis_summary_disciplines"});
$non_oasis_summary_medication_identified = explode("#",$obj{"non_oasis_summary_medication_identified"});
$patient_Admitted_to_a_Nursing_Home = explode("#",$obj{"patient_Admitted_to_a_Nursing_Home"});
$Reason_for_Hospitalization = explode("#",$obj{"Reason_for_Hospitalization"});
$oasis_mental_status = explode("#",$obj{"oasis_mental_status"});
$oasis_functional_limitations = explode("#",$obj{"oasis_functional_limitations"});
$oasis_safety_measures = explode("#",$obj{"oasis_safety_measures"});
$oasis_dme_iv_supplies = explode("#",$obj{"oasis_dme_iv_supplies"});
$oasis_dme_foley_supplies = explode("#",$obj{"oasis_dme_foley_supplies"});
?>



<form method="post" action="<?php echo $rootdir;?>/forms/oasis_discharge/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="oasis_discharge" id="oasis_discharge">
		<h3 align="center"><?php xl('OASIS-C DISCHARGE ASSESSMENT','e')?></h3>		
		
		


<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="left">
			<?php xl('Patient Name','e');?>
			<input type="text" name="oasis_patient_patient_name" value="<?php patientfullName();?>" readonly >
		</td>
		<td align="right">
			<table border="0" cellspacing="0" class="formtable" style="width:100%;">
				<tr>
					<td align="right">
						<?php xl('Caregiver: ','e');?>
						<input type="text" name="oasis_patient_caregiver" value="<?php echo $obj{"oasis_patient_caregiver"};?>">
					</td>

<td align="right">
<?php xl('Start of Care Date','e');?>
<input type='text' size='12' name='oasis_patient_visit_date' id='oasis_patient_visit_date' value="<?php echo $obj{"oasis_patient_visit_date"};?>" readonly /> 

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"oasis_patient_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

				</tr>
				<tr>
					<td align="right">
						<?php xl('Time In','e');?>
						<select name="time_in" id="time_in">
							<?php timeDropDown(stripslashes($obj{"time_in"})) ?>
						</select>
					</td><td align="right">
						<?php xl('Time Out','e');?>
						<select name="time_out" id="time_out">
							<?php timeDropDown(stripslashes($obj{"time_out"})) ?>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>

<ul id="oasis">
	<li>
		<div><a href="#" id="black">Patient Tracking Information, Clinical Record Items</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul id="patient_track_info">
				<li>	
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="center">
			<strong><?php xl('PATIENT TRACKING INFORMATION','e');?></strong>
		</td>
		<td align="center">
			<strong><?php xl('CLINICAL RECORD ITEMS','e');?></strong>
		</td>
	</tr>
	<tr>
		<td>
			<strong>
			<?php xl('<u>(M0010)</u> C M S Certification Number: ','e');?>
			<input type="text" name="oasis_therapy_cms_no" value="<?php echo $obj{"oasis_therapy_cms_no"};?>"><br>
			<?php xl('<u>(M0014)</u> Branch State: ','e');?>
			<input type="text" name="oasis_therapy_branch_state" value="<?php echo $obj{"oasis_therapy_branch_state"};?>"><br>
			<?php xl('<u>(M0016)</u> Branch ID Number: ','e');?>
			<input type="text" name="oasis_therapy_branch_id_no" value="<?php echo $obj{"oasis_therapy_branch_id_no"};?>"><br>
			<?php xl('<u>(M0018)</u> National Provider Identifier (N P I)</strong> for the attending physician who has signed the plan of care: ','e');?>
			<input type="text" name="oasis_therapy_npi" value="<?php echo $obj{"oasis_therapy_npi"};?>"><br>
			<strong>
			<label><input type="checkbox" name="oasis_therapy_npi_na" value="N/A" <?php if($obj{"oasis_therapy_npi_na"}=="N/A"){echo "checked";}?> ><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<?php xl('<u>(M0020)</u>Patient ID Number: ','e');?>
			<input type="text" name="oasis_therapy_patient_id" value="<?php patientName('pid');?>" readonly ><br>
			<?php xl('<u>(M0030)</u> Start of Care Date:','e');?>
				<input type='text' size='10' name='oasis_therapy_soc_date' id='oasis_therapy_soc_date' 
					title='<?php xl('Start of Care Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_soc_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_soc_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
					</script>
					<br>
			<?php xl('<u>(M0040)</u> Patient"s Name: ','e');?><br>
			</strong>
			<table cellspacing="0" border="0" class="formtable">
				<tr>
					<td align="right">
						<?php xl('First: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_name_first" value="<?php patientName('fname')?>" readonly>
					</td>
					<td align="right">
						<?php xl('MI: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_name_mi" value="<?php patientName('mname')?>" readonly>
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl('Last: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_name_last" value="<?php patientName('lname')?>" readonly>
					</td>
					<td align="right">
						<?php xl('Suffix: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_name_suffix" value="<?php patientName('title')?>" readonly>
					</td>
				</tr>
			</table>
			<br>
			
			<strong>
			<?php xl('Patient Address: ','e');?><br>
			</strong>
			<table cellspacing="0" border="0" class="formtable">
				<tr>
					<td align="right">
						<?php xl('Street: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_address_street" value="<?php patientName('street')?>" readonly>
					</td>
					<td align="right">
						<?php xl('City: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_address_city" value="<?php patientName('city')?>" readonly>
					</td>
				</tr>
			</table>
			<br>
			
			<strong>
			<?php xl('Patient Phone: ','e');?>
			<input type="text" name="oasis_therapy_patient_phone" value="<?php patientName('phone_home')?>" readonly><br>
			<?php xl('<u>(M0050)</u> Patient State of Residence: ','e');?>
			<input type="text" name="oasis_therapy_patient_state" value="<?php patientName('state')?>" readonly><br>
			<?php xl('<u>(M0060)</u> Patient Zip Code: ','e');?>
			<input type="text" name="oasis_therapy_patient_zip" value="<?php patientName('postal_code')?>" readonly><br>
			<?php xl('<u>(M0063)</u> Medicare Number: (including suffix) ','e');?>
			<input type="text" name="oasis_therapy_medicare_no" value="<?php echo $obj{"oasis_therapy_medicare_no"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_medicare_no_na" value="N/A" <?php if($obj{"oasis_therapy_medicare_no_na"}=="N/A"){echo "checked";}?> ><?php xl('N/A - No Medicare','e');?></label><br>
			<?php xl('<u>(M0064)</u> Social Security Number: ','e');?>
			<input type="text" name="oasis_therapy_ssn" value="<?php echo $obj{"oasis_therapy_ssn"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_ssn_na" value="UK" <?php if($obj{"oasis_therapy_ssn_na"}=="UK"){echo "checked";}?> ><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<?php xl('<u>(M0065)</u> Medicaid Number: ','e');?>
			<input type="text" name="oasis_therapy_medicaid_no" value="<?php echo $obj{"oasis_therapy_medicaid_no"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_medicaid_no_na" value="N/A" <?php if($obj{"oasis_therapy_medicaid_no_na"}=="N/A"){echo "checked";}?> ><?php xl('NA - No Medicaid','e');?></label><br>
			<?php xl('<u>(M0066)</u> Birth Date: ','e');?>
				<input type='text' size='10' name='oasis_therapy_birth_date' value="<?php patientName("DOB")?>" readonly/> 
					<br>
			<?php xl('<u>(M0069)</u> Gender: ','e');?></strong>
				<label><input type="radio" name="oasis_therapy_patient_gender" id="male" value="male" <?php if(patientGender("sex")=="Male"){echo "checked='checked'";}else{echo " onclick=\"this.checked = false;  $('#female').attr('checked','checked');\"";} ?> ><?php xl('Male','e');?></label>
				<label><input type="radio" name="oasis_therapy_patient_gender" id="female" value="female" <?php if(patientGender("sex")=="Female"){echo "checked='checked'";}else{echo " onclick=\"this.checked = false;  $('#male').attr('checked','checked');\"";} ?> ><?php xl('Female','e');?></label>
			
		</td>
		<td valign="top">
			<strong><?php xl('<u>(M0080)</u> Discipline of Person Completing Assessment:','e');?></strong><br>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="1" <?php if($obj{"oasis_therapy_discipline_person"}=="1"){echo "checked";}?> ><?php xl(' 1 - RN ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="2" <?php if($obj{"oasis_therapy_discipline_person"}=="2"){echo "checked";}?> ><?php xl(' 2 - PT ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="3" <?php if($obj{"oasis_therapy_discipline_person"}=="3"){echo "checked";}?> ><?php xl(' 3 - SLP/ST ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="4" <?php if($obj{"oasis_therapy_discipline_person"}=="4"){echo "checked";}?> ><?php xl(' 4 - OT ','e');?></label>
			<br>
			<hr>
			<strong><?php xl('<u>(M0090)</u> Date Assessment Completed: ','e');?></strong>
			<input type='text' size='10' name='oasis_therapy_date_assessment_completed' id='oasis_therapy_date_assessment_completed' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_date_assessment_completed"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_date_assessment_completed", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
					</script>
			<br>
			<hr>
			<strong><?php xl('<u>(M0100)</u> This Assessment is Currently Being Completed for the Following Reason: <u>Discharge from Agency - Not to an Inpatient Facility</u> ','e');?></strong><br>
			<label><input type="radio" id="m0100" name="oasis_therapy_follow_up" value="8" <?php if($obj{"oasis_therapy_follow_up"}=="8"){echo "checked";}?> ><?php xl(' 8 - Death at home <b><i>[ Go to M0903 ]</i></b>','e');?></label><br>
			<label><input type="radio" name="oasis_therapy_follow_up" value="9" <?php if($obj{"oasis_therapy_follow_up"}=="9"){echo "checked";}?> ><?php xl(' 9 - Discharge from agency <b><i>[ Go to M1040 ]</i></b>','e');?></label>
			<hr />
			<strong><?php xl('Certification:','e');?></strong><br>
				<label><input type="radio" name="oasis_therapy_certification" value="0" <?php if($obj{"oasis_therapy_certification"}=="0"){echo "checked";}?> ><?php xl(' Certification','e');?></label>
				<label><input type="radio" name="oasis_therapy_certification" value="1" <?php if($obj{"oasis_therapy_certification"}=="1"){echo "checked";}?> ><?php xl(' Recertification','e');?></label>
			<hr>
			<strong><?php xl('Date Last Contacted Physician: ','e');?></strong>
			<input type='text' size='10' name='oasis_therapy_date_last_contacted_physician' id='oasis_therapy_date_last_contacted_physician' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_date_last_contacted_physician"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date_sy1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_date_last_contacted_physician", ifFormat:"%Y-%m-%d", button:"img_curr_date_sy1"});
					</script>
			<hr>
			<strong><?php xl('Date Last Seen By Physician: ','e');?></strong>
			<input type='text' size='10' name='oasis_therapy_date_last_seen_by_physician' id='oasis_therapy_date_last_seen_by_physician' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_date_last_seen_by_physician"};?>"  readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date_sy2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_date_last_seen_by_physician", ifFormat:"%Y-%m-%d", button:"img_curr_date_sy2"});
					</script>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Patient History and diagnosis, Sensory Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul id="patient_history_diagnosis">
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="center" colspan="2">
			<strong><?php xl('PATIENT HISTORY AND DIAGNOSES','e');?></strong>
		</td>
	</tr>
	<tr>
		<td>
			<?php xl('<b><u>(M1040)</u> Influenza Vaccine:</b> Did the patient receive the influenza vaccine from your agency for this year\'s influenza season (October 1 through March 31) during this episode of care? ','e');?><br>
			<label><input type="radio" id="m1040" name="oasis_influenza_vaccine" value="0" <?php if($obj{"oasis_influenza_vaccine"}=="0"){echo "checked";}?> ><?php xl(' 0 - No','e');?></label><br>
			<label><input type="radio" name="oasis_influenza_vaccine" value="1" <?php if($obj{"oasis_influenza_vaccine"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes <b><i>[ Go to M1050 ]</i></b>','e');?></label><br>
			<label><input type="radio" name="oasis_influenza_vaccine" value="2" <?php if($obj{"oasis_influenza_vaccine"}=="2"){echo "checked";}?> ><?php xl(' 2 - NA - Does not apply because entire episode of care (SOC/ROC to Transfer/Discharge) is outside this influenza season. <b><i>[ Go to M1050 ]</i></b>','e');?></label><br>
		</td>
		<td valign="top">
			<?php xl('<b><u>(M1050)</u> Pneumococcal Vaccine:</b> Did the patient receive pneumococcal polysaccharide vaccine (PPV) from your agency during this episode of care (SOC/ROC to Transfer/Discharge)?','e');?><br>
			<label><input type="radio" id="m1050" name="oasis_pneumococcal_vaccine" value="0" <?php if($obj{"oasis_pneumococcal_vaccine"}=="0"){echo "checked";}?> ><?php xl(' 0 - No','e');?></label><br>
			<label><input type="radio" name="oasis_pneumococcal_vaccine" value="1" <?php if($obj{"oasis_pneumococcal_vaccine"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes <b><i>[ Go to M1500 at TRN; Go to M1230 at DC ]</i></b>','e');?></label><br>
		</td>
	</tr>
	<tr>
		<td>
			<?php xl('<b><u>(M1045)</u> Reason Influenza Vaccine not received:</b> If the patient did not receive the influenza vaccine from your agency during this episode of care, state reason:','e');?><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="1" <?php if($obj{"oasis_reason_influenza_vaccine"}=="1"){echo "checked";}?> ><?php xl(' 1 - Received from another health care provider (e.g., physician)','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="2" <?php if($obj{"oasis_reason_influenza_vaccine"}=="2"){echo "checked";}?> ><?php xl(' 2 - Received from your agency previously during this year\'s flu season','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="3" <?php if($obj{"oasis_reason_influenza_vaccine"}=="3"){echo "checked";}?> ><?php xl(' 3 - Offered and declined','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="4" <?php if($obj{"oasis_reason_influenza_vaccine"}=="4"){echo "checked";}?> ><?php xl(' 4 - Assessed and determined to have medical contraindication(s)','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="5" <?php if($obj{"oasis_reason_influenza_vaccine"}=="5"){echo "checked";}?> ><?php xl(' 5 - Not indicated; patient does not meet age/condition guidelines for influenza vaccine','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="6" <?php if($obj{"oasis_reason_influenza_vaccine"}=="6"){echo "checked";}?> ><?php xl(' 6 - Inability to obtain vaccine due to declared shortage','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="7" <?php if($obj{"oasis_reason_influenza_vaccine"}=="7"){echo "checked";}?> ><?php xl(' 7 - None of the above','e');?></label><br>
		</td>
		<td valign="top">
			<?php xl('<b><u>(M1055)</u> Reason PPV not received:</b> If patient did not receive the pneumococcal polysaccharide vaccine (PPV) from your agency during this episode of care (SOC/ROC to Transfer/Discharge), state reason:','e');?><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="1" <?php if($obj{"oasis_reason_ppv_not_received"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient has received PPV in the past','e');?></label><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="2" <?php if($obj{"oasis_reason_ppv_not_received"}=="2"){echo "checked";}?> ><?php xl(' 2 - Offered and declined','e');?></label><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="3" <?php if($obj{"oasis_reason_ppv_not_received"}=="3"){echo "checked";}?> ><?php xl(' 3 - Assessed and determined to have medical contraindication(s)','e');?></label><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="4" <?php if($obj{"oasis_reason_ppv_not_received"}=="4"){echo "checked";}?> ><?php xl(' 4 - Not indicated; patient does not meet age/condition guidelines for PPV','e');?></label><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="5" <?php if($obj{"oasis_reason_ppv_not_received"}=="5"){echo "checked";}?> ><?php xl(' 5 - None of the above','e');?></label><br>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<strong><?php xl('SENSORY STATUS','e');?></strong>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<strong><?php xl('<u>(M1230)</u> Speech and Oral (Verbal) Expression of Language (in patient\'s own language):','e');?></strong><br>
			<label><input type="radio" id="m1230" name="oasis_speech_and_oral" value="0" <?php if($obj{"oasis_speech_and_oral"}=="0"){echo "checked";}?> ><?php xl(' 0 - Expresses complex ideas, feelings, and needs clearly, completely, and easily in all situations with no observable impairment.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="1" <?php if($obj{"oasis_speech_and_oral"}=="1"){echo "checked";}?> ><?php xl(' 1 - Minimal difficulty in expressing ideas and needs (may take extra time; makes occasional errors in word choice, grammar or speech intelligibility; needs minimal prompting or assistance).','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="2" <?php if($obj{"oasis_speech_and_oral"}=="2"){echo "checked";}?> ><?php xl(' 2 - Expresses simple ideas or needs with moderate difficulty (needs prompting or assistance, errors in word choice, organization or speech intelligibility). Speaks in phrases or short sentences.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="3" <?php if($obj{"oasis_speech_and_oral"}=="3"){echo "checked";}?> ><?php xl(' 3 - Has severe difficulty expressing basic ideas or needs and requires maximal assistance or guessing by listener. Speech limited to single words or short phrases.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="4" <?php if($obj{"oasis_speech_and_oral"}=="4"){echo "checked";}?> ><?php xl(' 4 - <u>Unable</u> to express basic needs even with maximal prompting or assistance but is not comatose or unresponsive (e.g., speech is nonsensical or unintelligible).','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="5" <?php if($obj{"oasis_speech_and_oral"}=="5"){echo "checked";}?> ><?php xl(' 5 - Patient nonresponsive or unable to speak.','e');?></label><br>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Pain</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="center" colspan="2">
			<strong><?php xl('PAIN','e');?></strong>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong><?php xl('<u>(M1242)</u> Frequency of Pain Interfering </strong> with patient"s activity or movement:','e'); ?><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="0" <?php if($obj{"oasis_therapy_frequency_pain"}=="0"){echo "checked";}?> ><?php xl(' 0 - Patient has no pain','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="1" <?php if($obj{"oasis_therapy_frequency_pain"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient has pain that does not interfere with activity or movement','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="2" <?php if($obj{"oasis_therapy_frequency_pain"}=="2"){echo "checked";}?> ><?php xl(' 2 - Less often than daily','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="3" <?php if($obj{"oasis_therapy_frequency_pain"}=="3"){echo "checked";}?> ><?php xl(' 3 - Daily, but not constantly','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="4" <?php if($obj{"oasis_therapy_frequency_pain"}=="4"){echo "checked";}?> ><?php xl(' 4 - All of the time','e')?></label><br>
			
			<br>
			<center><strong><?php xl('SYSTEM REVIEW','e');?></strong></center>
			<?php xl('Weight:','e');?>
			<input type="text" name="oasis_system_review_weight" value="<?php echo $obj{"oasis_system_review_weight"};?>">
			<label><input type="checkbox" name="oasis_system_review_weight_detail" value="reported" <?php if($obj{"oasis_system_review_weight_detail"}=="reported"){echo "checked";}?> ><?php xl(' reported ','e')?></label>
			<label><input type="checkbox" name="oasis_system_review_weight_detail" value="actual" <?php if($obj{"oasis_system_review_weight_detail"}=="actual"){echo "checked";}?> ><?php xl(' actual ','e')?></label>
			
			<br>
			<?php xl('Blood sugars (range):','e');?>
			<input type="text" name="oasis_system_review_blood_sugar" value="<?php echo $obj{"oasis_system_review_blood_sugar"};?>">
			
			<br>
			<?php xl('Bowel:','e');?>
			<input type="text" name="oasis_system_review_bowel" value="<?php echo $obj{"oasis_system_review_bowel"};?>">
			<label><input type="checkbox" name="oasis_system_review_bowel_detail" value="WNL" <?php if($obj{"oasis_system_review_bowel_detail"}=="WNL"){echo "checked";}?> ><?php xl(' WNL ','e')?></label>
			<label><input type="checkbox" name="oasis_system_review_bowel_detail" value="Other" <?php if($obj{"oasis_system_review_bowel_detail"}=="Other"){echo "checked";}?> ><?php xl(' Other ','e')?></label>
			<input type="text" name="oasis_system_review_bowel_other" value="<?php echo $obj{"oasis_system_review_bowel_other"};?>">
			<?php xl('Bowel sounds','e');?>
			<input type="text" name="oasis_system_review_bowel_sounds" value="<?php echo $obj{"oasis_system_review_bowel_sounds"};?>">
			
			<br>
			<?php xl('Bladder:','e');?>
			<input type="text" name="oasis_system_review_bladder" value="<?php echo $obj{"oasis_system_review_bladder"};?>">
			<label><input type="checkbox" name="oasis_system_review_bladder_detail" value="WNL" <?php if($obj{"oasis_system_review_bladder_detail"}=="WNL"){echo "checked";}?> ><?php xl(' WNL ','e')?></label>
			<label><input type="checkbox" name="oasis_system_review_bladder_detail" value="Other" <?php if($obj{"oasis_system_review_bladder_detail"}=="Other"){echo "checked";}?> ><?php xl(' Other ','e')?></label>
			<input type="text" name="oasis_system_review_bladder_other" value="<?php echo $obj{"oasis_system_review_bladder_other"};?>">
			
			<br>
			<?php xl('Urinary output:','e');?>
			<input type="text" name="oasis_system_review_urinary_output" value="<?php echo $obj{"oasis_system_review_urinary_output"};?>">
			<label><input type="checkbox" name="oasis_system_review_urinary_output_detail" value="WNL" <?php if($obj{"oasis_system_review_urinary_output_detail"}=="WNL"){echo "checked";}?> ><?php xl(' WNL ','e')?></label>
			
			<br>
			<label><input type="checkbox" name="oasis_system_review[]" value="Foley catheter" <?php if(in_array("Foley catheter",$oasis_system_review)) echo "checked"; ?> ><?php xl(' Foley catheter change with ','e')?></label>
			<input type="text" name="oasis_system_review_foley_with" value="<?php echo $obj{"oasis_system_review_foley_with"};?>">
			<?php xl(' French Inflated balloon with ','e')?>
			<input type="text" name="oasis_system_review_foley_inflated" value="<?php echo $obj{"oasis_system_review_foley_inflated"};?>">
			<?php xl(' mL ','e')?>
			
			<br>
			<label><input type="checkbox" name="oasis_system_review[]" value="Suprapubic" <?php if(in_array("Suprapubic",$oasis_system_review)) echo "checked"; ?> ><?php xl(' Suprapubic ','e')?></label>
			
			<br>
			<?php xl('Tolerated procedure well: ','e')?>
			<label><input type="radio" name="oasis_system_review_tolerated" value="Yes" <?php if($obj{"oasis_system_review_tolerated"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_system_review_tolerated" value="No" <?php if($obj{"oasis_system_review_tolerated"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label>
			
			<br>
			<label><input type="checkbox" name="oasis_system_review[]" value="Other" <?php if(in_array("Other",$oasis_system_review)) echo "checked"; ?> ><?php xl(' Other (specify) ','e')?></label><br>
			<textarea name="oasis_system_review_other" rows="3" style="width:100%"><?php echo $obj{"oasis_system_review_other"};?></textarea>
		</td>
		<td width="60%" valign="top">
			<table border="0" cellspacing="0" class="formtable">
				<tr>
					<td colspan="2">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_0.png" border="0" onClick="select_pain(0)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_2.png" border="0" onClick="select_pain(1)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_4.png" border="0" onClick="select_pain(2)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_6.png" border="0" onClick="select_pain(3)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_8.png" border="0" onClick="select_pain(4)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_10.png" border="0" onClick="select_pain(5)">
					</td>
				</tr>
				<tr>
					<td>
						<strong><u><?php xl('Pain Rating Scale:','e')?></u></strong>
					</td>
					<td>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_1" value="0" <?php if($obj{"oasis_therapy_pain_scale"}=="0"){echo "checked";}?> ><?php xl(' 0-No Pain ','e')?></label>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_2" value="2" <?php if($obj{"oasis_therapy_pain_scale"}=="2"){echo "checked";}?> ><?php xl(' 2-Little Pain ','e')?></label>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_4" value="4" <?php if($obj{"oasis_therapy_pain_scale"}=="4"){echo "checked";}?> ><?php xl(' 4-Little More Pain ','e')?></label><br>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_6" value="6" <?php if($obj{"oasis_therapy_pain_scale"}=="6"){echo "checked";}?> ><?php xl(' 6-Even More Pain ','e')?></label>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_8" value="8" <?php if($obj{"oasis_therapy_pain_scale"}=="8"){echo "checked";}?> ><?php xl(' 8-Lots of Pain ','e')?></label>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_10" value="10" <?php if($obj{"oasis_therapy_pain_scale"}=="10"){echo "checked";}?> ><?php xl(' 10-Worst Pain ','e')?></label>
					</td>
				</tr>
			</table>
			<br>
			
			<strong><u><?php xl('Location:','e')?></u>
			<input type="text" name="oasis_therapy_pain_location" value="<?php echo $obj{"oasis_therapy_pain_location"};?>">
			<?php xl('Cause:','e')?></strong>
			<input type="text" name="oasis_therapy_pain_location_cause" value="<?php echo $obj{"oasis_therapy_pain_location_cause"};?>"><br>
			
			<strong><u><?php xl('Description:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("sharp","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="sharp"){echo "checked";}?> ><?php xl('sharp','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("dull","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="dull"){echo "checked";}?> ><?php xl('dull','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("cramping","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="cramping"){echo "checked";}?> ><?php xl('cramping','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("aching","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="aching"){echo "checked";}?> ><?php xl('aching','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("burning","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="burning"){echo "checked";}?> ><?php xl('burning','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("tingling","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="tingling"){echo "checked";}?> ><?php xl('tingling','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("throbbing","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="throbbing"){echo "checked";}?> ><?php xl('throbbing','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("shooting","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="shooting"){echo "checked";}?> ><?php xl('shooting','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("pinching","e");?>" <?php if($obj{"oasis_therapy_pain_description"}=="pinching"){echo "checked";}?> ><?php xl('pinching','e')?></label><br>
			
			<strong><u><?php xl('Frequency:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("occasional","e");?>" <?php if($obj{"oasis_therapy_pain_frequency"}=="occasional"){echo "checked";}?> ><?php xl('occasional','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("intermittent","e");?>" <?php if($obj{"oasis_therapy_pain_frequency"}=="intermittent"){echo "checked";}?> ><?php xl('intermittent','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("continuous","e");?>" <?php if($obj{"oasis_therapy_pain_frequency"}=="continuous"){echo "checked";}?> ><?php xl('continuous','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("at rest","e");?>" <?php if($obj{"oasis_therapy_pain_frequency"}=="at rest"){echo "checked";}?> ><?php xl('at rest','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("at night","e");?>" <?php if($obj{"oasis_therapy_pain_frequency"}=="at night"){echo "checked";}?> ><?php xl('at night','e')?></label><br>
			
			<strong><u><?php xl('Aggravating factors:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pain_aggravating_factors" value="<?php xl("movement","e");?>" <?php if($obj{"oasis_therapy_pain_aggravating_factors"}=="movement"){echo "checked";}?> ><?php xl('movement','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_aggravating_factors" value="<?php xl("time of day","e");?>" <?php if($obj{"oasis_therapy_pain_aggravating_factors"}=="time of day"){echo "checked";}?> ><?php xl('time of day','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_aggravating_factors" value="<?php xl("posture","e");?>" <?php if($obj{"oasis_therapy_pain_aggravating_factors"}=="posture"){echo "checked";}?> ><?php xl('posture','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_aggravating_factors" value="<?php xl("other","e");?>" <?php if($obj{"oasis_therapy_pain_aggravating_factors"}=="other"){echo "checked";}?> ><?php xl('other','e')?></label>
			<input type="text" name="oasis_therapy_pain_aggravating_factors_other" value="<?php echo $obj{"oasis_therapy_pain_aggravating_factors_other"};?>"><br>
			
			<strong><u><?php xl('Relieving factors:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("medication","e");?>" <?php if(in_array("medication",$oasis_therapy_pain_relieving_factors)) echo "checked"; ?> ><?php xl('medication','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("rest","e");?>" <?php if(in_array("rest",$oasis_therapy_pain_relieving_factors)) echo "checked"; ?> ><?php xl('rest','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("heat","e");?>" <?php if(in_array("heat",$oasis_therapy_pain_relieving_factors)) echo "checked"; ?> ><?php xl('heat','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("ice","e");?>" <?php if(in_array("ice",$oasis_therapy_pain_relieving_factors)) echo "checked"; ?> ><?php xl('ice','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("massage","e");?>" <?php if(in_array("massage",$oasis_therapy_pain_relieving_factors)) echo "checked"; ?> ><?php xl('massage','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("repositioning","e");?>" <?php if(in_array("repositioning",$oasis_therapy_pain_relieving_factors)) echo "checked"; ?> ><?php xl('repositioning','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("diversion","e");?>" <?php if(in_array("diversion",$oasis_therapy_pain_relieving_factors)) echo "checked"; ?> ><?php xl('diversion','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("other","e");?>" <?php if(in_array("other",$oasis_therapy_pain_relieving_factors)) echo "checked"; ?> ><?php xl('other','e')?></label>
			<input type="text" name="oasis_therapy_pain_relieving_factors_other" value="<?php echo $obj{"oasis_therapy_pain_relieving_factors_other"};?>"><br>
			
			<strong><u><?php xl('Activities limited:','e')?></u></strong><br>
			<textarea name="oasis_therapy_pain_activities_limited" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pain_activities_limited"};?></textarea>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Nutritional Status, Vital Signs</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<!--Nutritional Status-->
	
<tr valign="top">
<td width="50%">
<center><strong><?php xl('NUTRITIONAL STATUS','e')?></strong>
<label><input type="checkbox" name="oasis_nutrition_status_prob" value="No Problem"  id="oasis_nutrition_status_prob" <?php if($obj{"oasis_nutrition_status_prob"}=="No Problem") echo "checked"; ?>  /> <?php xl('No Problem','e')?></label></center><br />
<label><input type="checkbox" name="oasis_nutrition_status" value="NAS"  id="oasis_nutrition_status"  <?php if($obj{"oasis_nutrition_status"}=="NAS") echo "checked"; ?> /> <?php xl('NAS','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_status" value="NPO"  id="oasis_nutrition_status" <?php if($obj{"oasis_nutrition_status"}=="NPO") echo "checked"; ?>  /> <?php xl('NPO','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_status" value="No Concentrated Sweets"  id="oasis_nutrition_status" <?php if($obj{"oasis_nutrition_status"}=="No Concentrated Sweets") echo "checked"; ?>  /> <?php xl('No Concentrated Sweets','e')?></label> &nbsp;
<br/>
<label><input type="checkbox" name="oasis_nutrition_status" value="Other"  id="oasis_nutrition_status"  <?php if($obj{"oasis_nutrition_status"}=="Other") echo "checked"; ?> /> <?php xl('Other','e')?></label> &nbsp;
<input type="text" name="oasis_nutrition_status_other" id="oasis_nutrition_status_other"  style="width:80%"  value="<?php echo stripslashes($obj{"oasis_nutrition_status_other"});?>" />
<br />
<strong>
<?php xl('Nutritional Requirements (diet)','e')?></strong><br />
<label><input type="checkbox" name="oasis_nutrition_requirements" value="Increase fluids amt"  id="oasis_nutrition_requirements"  <?php if($obj{"oasis_nutrition_requirements"}=="Increase fluids amt") echo "checked"; ?> /> <?php xl('Increase fluids amt','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_requirements" value="Restrict fluids amt"  id="oasis_nutrition_requirements" <?php if($obj{"oasis_nutrition_requirements"}=="Restrict fluids amt") echo "checked"; ?>  /> <?php xl('Restrict fluids amt','e')?></label> &nbsp;

<br />
<strong><?php xl('Appetite','e')?></strong>
<label><input type="radio" name="oasis_nutrition_appetite" value="Good"  id="oasis_nutrition_appetite"  <?php if($obj{"oasis_nutrition_appetite"}=="Good") echo "checked"; ?> /> <?php xl('Good','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_appetite" value="Fair"  id="oasis_nutrition_appetite"  <?php if($obj{"oasis_nutrition_appetite"}=="Fair") echo "checked"; ?> /> <?php xl('Fair','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_appetite" value="Poor"  id="oasis_nutrition_appetite"  <?php if($obj{"oasis_nutrition_appetite"}=="Poor") echo "checked"; ?> /> <?php xl('Poor','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_appetite" value="Anorexic"  id="oasis_nutrition_appetite"  <?php if($obj{"oasis_nutrition_appetite"}=="Anorexic") echo "checked"; ?> /> <?php xl('Anorexic','e')?></label> &nbsp;

<br />
<strong><?php xl('Eating Patterns','e')?></strong>
<br /><textarea name="oasis_nutrition_eat_patt" rows="3"  style="width:100%;"><?php echo stripslashes($obj{"oasis_nutrition_eat_patt"});?></textarea>
<br /><br />
<label><input type="checkbox" name="oasis_nutrition_eat_patt1[]" value="Nausea/Vomiting"  id="oasis_nutrition_eat_patt1"  <?php if(in_array("Nausea/Vomiting",$oasis_nutrition_eat_patt1)) echo "checked"; ?> />
<?php xl('Nausea/Vomiting: ','e')?></label> &nbsp;
<label><?php xl('Frequency','e')?><input type="text" name="oasis_nutrition_eat_patt_freq" id="oasis_nutrition_eat_patt_freq" size="8" value="<?php echo stripslashes($obj{"oasis_nutrition_eat_patt_freq"});?>"  /></label> &nbsp;
<label><?php xl('Amount','e')?><input type="text" name="oasis_nutrition_eat_patt_amt" id="oasis_nutrition_eat_patt_amt" size="8"  value="<?php echo stripslashes($obj{"oasis_nutrition_eat_patt_amt"});?>" /></label> &nbsp;
<br />
<label><input type="checkbox" name="oasis_nutrition_eat_patt1[]" value="Heartburn (food intolerance)"  id="oasis_nutrition_eat_patt1" <?php if(in_array("Heartburn (food intolerance)",$oasis_nutrition_eat_patt1)) echo "checked"; ?>  />
<?php xl('Heartburn (food intolerance)','e')?></label> &nbsp;
<br />
<label><input type="checkbox" name="oasis_nutrition_eat_patt1[]" value="Weight Change:"  id="oasis_nutrition_eat_patt1" <?php if(in_array("Weight Change:",$oasis_nutrition_eat_patt1)) echo "checked"; ?>  />
<?php xl('Weight Change:','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_eat_gain_or_loss" value="gain" <?php if($obj{"oasis_nutrition_eat_gain_or_loss"}=="gain") echo "checked"; ?> />
<?php xl('Gain','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_eat_gain_or_loss" value="loss" <?php if($obj{"oasis_nutrition_eat_gain_or_loss"}=="loss") echo "checked"; ?> />
<?php xl('Loss','e')?></label> &nbsp;
<input type="text" name="oasis_nutrition_patt_gain" id="oasis_nutrition_patt_gain" size="10" value="<?php echo stripslashes($obj{"oasis_nutrition_patt_gain"});?>"  />&nbsp;
<?php xl('lb. X','e')?>&nbsp;
<label><input type="radio" name="oasis_nutrition_eat_patt1_gain_time" value="wk./"  id="oasis_nutrition_eat_patt1_gain_time"  <?php if($obj{"oasis_nutrition_eat_patt1_gain_time"}=="wk./") echo "checked"; ?> />
<?php xl('wk./','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_eat_patt1_gain_time" value="mo./"  id="oasis_nutrition_eat_patt1_gain_time"  <?php if($obj{"oasis_nutrition_eat_patt1_gain_time"}=="mo./") echo "checked"; ?> />
<?php xl('mo./','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_eat_patt1_gain_time" value="yr."  id="oasis_nutrition_eat_patt1_gain_time"  <?php if($obj{"oasis_nutrition_eat_patt1_gain_time"}=="yr.") echo "checked"; ?> />
<?php xl('yr.','e')?></label> &nbsp;<br />
<label><input type="checkbox" name="oasis_nutrition_eat_patt1[]" value="Other(Specify including history)"  id="oasis_nutrition_eat_patt1" <?php if(in_array("Other(Specify including history)",$oasis_nutrition_eat_patt1)) echo "checked"; ?>  />
<?php xl('Other(Specify including history)','e')?></label> &nbsp;
<input type="text" name="oasis_nutrition_patt1_other" id="oasis_nutrition_patt1_other" style="width:42%"  value="<?php echo stripslashes($obj{"oasis_nutrition_patt1_other"});?>"  />
<br /><br />
<center><strong><?php xl('NUTRITIONAL REQUIREMENTS','e')?></strong></center>
<label><input type="checkbox" name="oasis_nutrition_req" value="Regular Diet"  id="oasis_nutrition_req" <?php if($obj{"oasis_nutrition_req"}=="Regular Diet") echo "checked"; ?>  />
<?php xl('Regular Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Diet as Tolerated"  id="oasis_nutrition_req" <?php if($obj{"oasis_nutrition_req"}=="Diet as Tolerated") echo "checked"; ?>  />
<?php xl('Diet as Tolerated','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Soft Diet"  id="oasis_nutrition_req" <?php if($obj{"oasis_nutrition_req"}=="Soft Diet") echo "checked"; ?>  />
<?php xl('Soft Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="NCS"  id="oasis_nutrition_req" <?php if($obj{"oasis_nutrition_req"}=="NCS") echo "checked"; ?>  />
<?php xl('NCS','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Diabetic Diet # Calorie ADA"  id="oasis_nutrition_req" <?php if($obj{"oasis_nutrition_req"}=="Diabetic Diet # Calorie ADA") echo "checked"; ?>  />
<?php xl('Diabetic Diet # Calorie ADA','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Pureed Diet"  id="oasis_nutrition_req" <?php if($obj{"oasis_nutrition_req"}=="Pureed Diet") echo "checked"; ?>  />
<?php xl('Pureed Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="NAS"  id="oasis_nutrition_req"  <?php if($obj{"oasis_nutrition_req"}=="NAS") echo "checked"; ?> />
<?php xl('NAS','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Low Salt Gram Sodium"  id="oasis_nutrition_req"  <?php if($obj{"oasis_nutrition_req"}=="Low Salt Gram Sodium") echo "checked"; ?> />
<?php xl('Low Salt Gram Sodium','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Low Fat/Low Cholestrol Diet"  id="oasis_nutrition_req" <?php if($obj{"oasis_nutrition_req"}=="Low Fat/Low Cholestrol Diet") echo "checked"; ?>  />
<?php xl('Low Fat/Low Cholestrol Diet','e')?></label> &nbsp;
<br />
<label><input type="checkbox" name="oasis_nutrition_req" value="Other Special Diet"  id="oasis_nutrition_req"  <?php if($obj{"oasis_nutrition_req"}=="Other Special Diet") echo "checked"; ?> />
<?php xl('Other Special Diet','e')?></label> &nbsp;
<br />
<textarea name="oasis_nutrition_req_other" rows="3"  style="width:100%;" >
<?php echo stripslashes($obj{"oasis_nutrition_req_other"});?></textarea>

</td>


<td>
<center><strong><?php xl('NUTRITION','e')?></strong></center><br />
<strong><?php xl('Directions: Check each area with "yes" to assessment, then see total score to determine additional risk.','e')?></strong>

<TABLE width="100%" border="0" class="formtable">

<tr>
<TD width="90%"></TD>
<td width="5%"></td>
<td width="5%"><strong><?php echo "YES"; ?></strong></td>
</tr>
<tr>
<TD width="90%"><?php xl('Has an illness or condition that changed the kind and/or amount of food eaten','e')?></TD>
<td width="5%"><?php xl('2','e')?></td>
<td width="5%"><input type="checkbox" name="oasis_nutrition_risks[]" value="Has an illness or condition that changed the kind and/or amount of food eaten"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" 
<?php if(in_array("Has an illness or condition that changed the kind and/or amount of food eaten",$oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Eats fewer than 2 meals per day','e')?></td>
<td><?php xl('3','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Eats fewer than 2 meals per day"  id="oasis_nutrition_risks" onChange="nut_sum(this,3)" 
<?php if(in_array("Eats fewer than 2 meals per day",$oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Eats few fruits, vegetables or milk products','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Eats few fruits, vegetables or milk products"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" 
<?php if(in_array("Eats few fruits, vegetables or milk products",$oasis_nutrition_risks)) echo "checked"; ?>  /></td>
</tr>
<tr>
<td><?php xl('Has 3 or more drinks of beer, liquor or wine almost everyday','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Has 3 or more drinks of beer, liquor or wine almost everyday"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" 
<?php if(in_array("Has 3 or more drinks of beer, liquor or wine almost everyday",$oasis_nutrition_risks)) echo "checked"; ?>  /></td>
</tr>
<tr>
<td><?php xl('Has tooth or mouth problems that make it hard to eat','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Has tooth or mouth problems that make it hard to eat"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" 
<?php if(in_array("Has tooth or mouth problems that make it hard to eat",$oasis_nutrition_risks)) echo "checked"; ?>  /></td>
</tr>
<tr>
<td><?php xl('Does not always have the enough money to buy the food needed','e')?></td>
<td><?php xl('4','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Does not always have the enough money to buy the food needed"  id="oasis_nutrition_risks" onChange="nut_sum(this,4)" 
<?php if(in_array("Does not always have the enough money to buy the food needed",$oasis_nutrition_risks)) echo "checked"; ?>  /></td>
</tr>
<tr>
<td><?php xl('Eats alone most of the time','e')?></td>
<td><?php xl('1','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Eats alone most of the time"  id="oasis_nutrition_risks" onChange="nut_sum(this,1)" 
<?php if(in_array("Eats alone most of the time",$oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Takes 3 or more different prescribed or over-the-counter drugs a day','e')?></td>
<td><?php xl('1','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Takes 3 or more different prescribed or over-the-counter drugs a day"  id="oasis_nutrition_risks" onChange="nut_sum(this,1)" 
<?php if(in_array("Takes 3 or more different prescribed or over-the-counter drugs a day",$oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Without warning to, has lost or gained 10 pounds in the last 6 months','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Without warning to, has lost or gained 10 pounds in the last 6 months"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" 
<?php if(in_array("Without warning to, has lost or gained 10 pounds in the last 6 months",$oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Not always physically able to shop, cook and/or feed self','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Not always physically able to shop, cook and/or feed self"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" 
<?php if(in_array("Not always physically able to shop, cook and/or feed self",$oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr valign="top">
<TD colspan="2" align="right" width="70%">
<label><input type="checkbox" name="oasis_nutrition_risks_MD" value="MD aware or MD notified"  id="oasis_nutrition_risks_MD"  
<?php if($obj{"oasis_nutrition_risks_MD"}=="MD aware or MD notified") echo "checked"; ?> />
<?php xl('MD aware or MD notified','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('TOTAL','e')?></strong></label>
</TD>
<td width="30%">
<label><input type="text" name="nutrition_total" id="nutrition_total" size="2" readonly  value="<?php echo stripslashes($obj{"nutrition_total"});?>" /></label>
</td>
</tr>
</TABLE>
<strong><?php xl('INTERPRETATION: 0-2 Good. As appropriate reassess and/or provide information based on situation.','e')?><br />
<?php xl('3-5 Moderate risk. Educate, refer, monitor and reevaluate based on patient situation and organization policy.','e')?><br />
<?php xl('6 or more High risk. Coordinate with physician, dietitian, social service professional or nurse about how to improve nutritional health. Describe at risk intervention:','e')?>
<input type="text" name="oasis_nutrition_describe" id="oasis_nutrition_describe" value="<?php echo stripslashes($obj{"oasis_nutrition_describe"});?>"  /><br />
</strong>
</td>
</tr>
	<!--Nutritional Status-->
	<tr>
		<td colspan="2">
			<center><strong><?php xl("VITAL SIGNS","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0px" style="width:100%;" cellspacing="0" class="formtable">
				<tr>
					<td>
						<strong><?php xl("Blood Pressure:","e");?></strong>
					</td>
					<td align="center">
						<?php xl("Right","e");?>
					</td>
					<td align="center">
						<?php xl("Left","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Lying","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="<?php echo $oasis_therapy_vital_sign_blood_pressure[0];?>" >
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="<?php echo $oasis_therapy_vital_sign_blood_pressure[1];?>" >
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Sitting","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="<?php echo $oasis_therapy_vital_sign_blood_pressure[2];?>" >
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="<?php echo $oasis_therapy_vital_sign_blood_pressure[3];?>" >
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Standing","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="<?php echo $oasis_therapy_vital_sign_blood_pressure[4];?>" >
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="<?php echo $oasis_therapy_vital_sign_blood_pressure[5];?>" >
					</td>
				</tr>
			</table>
			
			<strong><?php xl("Temperature: &deg;F","e");?></strong>
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Oral" <?php if($obj{"oasis_therapy_vital_sign_temperature"}=="Oral"){echo "checked";}?> ><?php xl(' Oral ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Axillary" <?php if($obj{"oasis_therapy_vital_sign_temperature"}=="Axillary"){echo "checked";}?> ><?php xl(' Axillary ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Rectal" <?php if($obj{"oasis_therapy_vital_sign_temperature"}=="Rectal"){echo "checked";}?> ><?php xl(' Rectal ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Tympanic" <?php if($obj{"oasis_therapy_vital_sign_temperature"}=="Tympanic"){echo "checked";}?> ><?php xl(' Tympanic ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Temporal" <?php if($obj{"oasis_therapy_vital_sign_temperature"}=="Temporal"){echo "checked";}?> ><?php xl(' Temporal ','e')?></label> 
			
		</td>
		<td>
			<strong><?php xl("Pulse:","e");?></strong><br>
			<label><input type="radio" name="oasis_therapy_vital_sign_pulse" value="At Rest" <?php if($obj{"oasis_therapy_vital_sign_pulse"}=="At Rest"){echo "checked";}?> ><?php xl(' At Rest ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_pulse" value="Activity" <?php if($obj{"oasis_therapy_vital_sign_pulse"}=="Activity"){echo "checked";}?> ><?php xl(' Activity/Exercise ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_pulse" value="Regular" <?php if($obj{"oasis_therapy_vital_sign_pulse"}=="Regular"){echo "checked";}?> ><?php xl(' Regular ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_pulse" value="Irregular" <?php if($obj{"oasis_therapy_vital_sign_pulse"}=="Irregular"){echo "checked";}?> ><?php xl(' Irregular ','e')?></label> 
			<br>
				
			<label><input type="checkbox" name="oasis_therapy_vital_sign_pulse_type[]" value="Radial" <?php if(in_array("Radial",$oasis_therapy_vital_sign_pulse_type)) echo "checked"; ?> ><?php xl(' Radial ','e')?></label> 
			<label><input type="checkbox" name="oasis_therapy_vital_sign_pulse_type[]" value="Carotid" <?php if(in_array("Carotid",$oasis_therapy_vital_sign_pulse_type)) echo "checked"; ?> ><?php xl(' Carotid ','e')?></label> 
			<label><input type="checkbox" name="oasis_therapy_vital_sign_pulse_type[]" value="Apical" <?php if(in_array("Apical",$oasis_therapy_vital_sign_pulse_type)) echo "checked"; ?> ><?php xl(' Apical ','e')?></label> 
			<label><input type="checkbox" name="oasis_therapy_vital_sign_pulse_type[]" value="Brachial" <?php if(in_array("Brachial",$oasis_therapy_vital_sign_pulse_type)) echo "checked"; ?> ><?php xl(' Brachial ','e')?></label> 
			<br><br>			
			<strong><?php xl("Respiratory Rate:","e");?></strong>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_vital_sign_respiratory_rate" value="Normal" <?php if($obj{"oasis_therapy_vital_sign_respiratory_rate"}=="Normal"){echo "checked";}?> ><?php xl(' Normal ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_respiratory_rate" value="Cheynes" <?php if($obj{"oasis_therapy_vital_sign_respiratory_rate"}=="Cheynes"){echo "checked";}?> ><?php xl(' Cheynes Stokes ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_respiratory_rate" value="Death" <?php if($obj{"oasis_therapy_vital_sign_respiratory_rate"}=="Death"){echo "checked";}?> ><?php xl(' Death rattle ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_respiratory_rate" value="Apnea" <?php if($obj{"oasis_therapy_vital_sign_respiratory_rate"}=="Apnea"){echo "checked";}?> ><?php xl(' Apnea /sec.','e')?></label> 
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Cardiopulmonary</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2"> 
			<center><strong>
				<?php xl('CARDIOPULMONARY','e')?>
				<label><input type="checkbox" name="oasis_therapy_cardiopulmonary_problem" value="No" <?php if($obj{"oasis_therapy_cardiopulmonary_problem"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</strong></center>
		</td>
	</tr>
	<tr>
		<td width="50%"> 
			<strong><?php xl('Breath Sounds:','e')?></strong><br>
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Clear" <?php if($obj{"oasis_therapy_breath_sounds_type"}=="Clear"){echo "checked";}?> ><?php xl(' Clear ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Crackles/Rales" <?php if($obj{"oasis_therapy_breath_sounds_type"}=="Crackles/Rales"){echo "checked";}?> ><?php xl(' Crackles/Rales ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Wheezes/Rhonchi" <?php if($obj{"oasis_therapy_breath_sounds_type"}=="Wheezes/Rhonchi"){echo "checked";}?> ><?php xl(' Wheezes/Rhonchi ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Diminished" <?php if($obj{"oasis_therapy_breath_sounds_type"}=="Diminished"){echo "checked";}?> ><?php xl(' Diminished ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Absent" <?php if($obj{"oasis_therapy_breath_sounds_type"}=="Absent"){echo "checked";}?> ><?php xl(' Absent ','e')?></label> <br>
			
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Anterior","e");?>" <?php if(in_array("Anterior",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Anterior:','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_anterior" value="<?php xl("Right","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_anterior"}=="Right"){echo "checked";}?> ><?php xl('Right','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_anterior" value="<?php xl("Left","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_anterior"}=="Left"){echo "checked";}?> ><?php xl('Left','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_anterior" value="<?php xl("O2","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_anterior"}=="O2"){echo "checked";}?> ><?php xl('O2 saturation','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Posterior","e");?>" <?php if(in_array("Posterior",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Posterior:','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_posterior" value="<?php xl("Right Upper","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_posterior"}=="Right Upper"){echo "checked";}?> ><?php xl('Right Upper','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_posterior" value="<?php xl("Right Lower","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_posterior"}=="Right Lower"){echo "checked";}?> ><?php xl('Right Lower','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_posterior" value="<?php xl("Left Upper","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_posterior"}=="Left Upper"){echo "checked";}?> ><?php xl('Left Upper','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_posterior" value="<?php xl("Left Lower","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_posterior"}=="Left Lower"){echo "checked";}?> ><?php xl('Left Lower','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("O2 saturation","e");?>" <?php if(in_array("O2 saturation",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('O2 saturation:','e')?></label>
				<input type="text" name="oasis_therapy_breath_sounds_o2_saturation" value="<?php echo $obj{"oasis_therapy_breath_sounds_o2_saturation"};?>">%<br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Accessory muscles used","e");?>" <?php if(in_array("Accessory muscles used",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Accessory muscles used','e')?></label>
				<input type="text" name="oasis_therapy_breath_sounds_accessory_muscle" value="<?php echo $obj{"oasis_therapy_breath_sounds_accessory_muscle"};?>">
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_accessory_muscle_o2" value="<?php xl("O2","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_accessory_muscle_o2"}=="O2"){echo "checked";}?> ><?php xl('O2','e')?></label>
				<input type="text" name="oasis_therapy_breath_sounds_accessory_o2_detail" value="<?php echo $obj{"oasis_therapy_breath_sounds_accessory_o2_detail"};?>">
				<?php xl('LPM per','e')?><input type="text" name="oasis_therapy_breath_sounds_accessory_lpm" value="<?php echo $obj{"oasis_therapy_breath_sounds_accessory_lpm"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Pulse Oximetry per Symptomology","e");?>" <?php if(in_array("Pulse Oximetry per Symptomology",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Pulse Oximetry per Symptomology','e')?></label><br>
			<?php xl('Does this patient have a trach?','e')?>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach" value="Yes" <?php if($obj{"oasis_therapy_breath_sounds_trach"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach" value="No" <?php if($obj{"oasis_therapy_breath_sounds_trach"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
			<?php xl('Who manages?','e')?>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach_manages" value="Self" <?php if($obj{"oasis_therapy_breath_sounds_trach_manages"}=="Self"){echo "checked";}?> ><?php xl(' Self ','e')?></label>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach_manages" value="RN" <?php if($obj{"oasis_therapy_breath_sounds_trach_manages"}=="RN"){echo "checked";}?> ><?php xl(' RN ','e')?></label>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach_manages" value="Caregiver" <?php if($obj{"oasis_therapy_breath_sounds_trach_manages"}=="Caregiver"){echo "checked";}?> ><?php xl(' Caregiver/family ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Cough","e");?>" <?php if(in_array("Cough",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><b><?php xl('Cough:','e')?></b></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_cough" value="<?php xl("Dry","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_cough"}=="Dry"){echo "checked";}?> ><?php xl('Dry','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_cough" value="<?php xl("Acute","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_cough"}=="Acute"){echo "checked";}?> ><?php xl('Acute','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_cough" value="<?php xl("Chronic","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_cough"}=="Chronic"){echo "checked";}?> ><?php xl('Chronic','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Productive","e");?>" <?php if(in_array("Productive",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><b><?php xl('Productive:','e')?></b></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_productive" value="<?php xl("Thick","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_productive"}=="Thick"){echo "checked";}?> ><?php xl('Thick','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_productive" value="<?php xl("Thin","e");?>" <?php if($obj{"oasis_therapy_breath_sounds_productive"}=="Thin"){echo "checked";}?> ><?php xl('Thin','e')?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php xl('Color','e')?>
				<input type="text" name="oasis_therapy_breath_sounds_productive_color" value="<?php echo $obj{"oasis_therapy_breath_sounds_productive_color"};?>">
				<?php xl('Amount','e')?>
				<input type="text" name="oasis_therapy_breath_sounds_productive_amount" value="<?php echo $obj{"oasis_therapy_breath_sounds_productive_amount"};?>">
				<br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Dyspnea","e");?>" <?php if(in_array("Dyspnea",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><b><?php xl('Dyspnea:','e')?></b></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Rest","e");?>" <?php if(in_array("Rest",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Rest','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Exertion","e");?>" <?php if(in_array("Exertion",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Exertion','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Ambulation feet","e");?>" <?php if(in_array("Ambulation feet",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Ambulation feet','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("During ADL","e");?>" <?php if(in_array("During ADL",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('During ADL"s','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Orthopnea","e");?>" <?php if(in_array("Orthopnea",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Orthopnea','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Other","e");?>" <?php if(in_array("Other",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_therapy_breath_sounds_other" value="<?php echo $obj{"oasis_therapy_breath_sounds_other"};?>"><br>
			
			
		</td>
		<td valign="top"> 
			<strong><?php xl('Heart Sounds:','e')?></strong><br>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_type" value="<?php xl("Regular","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_type"}=="Regular"){echo "checked";}?> ><?php xl('Regular','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_type" value="<?php xl("Irregular","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_type"}=="Irregular"){echo "checked";}?> ><?php xl('Irregular','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_type" value="<?php xl("Murmur","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_type"}=="Murmur"){echo "checked";}?> ><?php xl('Murmur','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Pacemaker","e");?>" <?php if(in_array("Pacemaker",$oasis_therapy_heart_sounds)) echo "checked"; ?> ><?php xl('Pacemaker:','e')?></label>
				<input type="text" name="oasis_therapy_heart_sounds_pacemaker" value="<?php echo $obj{"oasis_therapy_heart_sounds_pacemaker"};?>">&nbsp;&nbsp;
				<?php xl('Date:','e')?><input type='text' size='10' name='oasis_therapy_heart_sounds_pacemaker_date' id='oasis_therapy_heart_sounds_pacemaker_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_heart_sounds_pacemaker_date"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date7' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_therapy_heart_sounds_pacemaker_date", ifFormat:"%Y-%m-%d", button:"img_curr_date7"});
						</script>
				<?php xl('Type:','e')?><input type="text" name="oasis_therapy_heart_sounds_pacemaker_type" value="<?php echo $obj{"oasis_therapy_heart_sounds_pacemaker_type"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Chest Pain","e");?>" <?php if(in_array("Chest Pain",$oasis_therapy_heart_sounds)) echo "checked"; ?> ><b><?php xl('Chest Pain:','e')?></b></label><br>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Anginal","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Anginal"){echo "checked";}?> ><?php xl('Anginal','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Postural","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Postural"){echo "checked";}?> ><?php xl('Postural','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Localized","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Localized"){echo "checked";}?> ><?php xl('Localized','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Substernal","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Substernal"){echo "checked";}?> ><?php xl('Substernal','e')?></label><br>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Radiating","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Radiating"){echo "checked";}?> ><?php xl('Radiating','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Dull","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Dull"){echo "checked";}?> ><?php xl('Dull','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Ache","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Ache"){echo "checked";}?> ><?php xl('Ache','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Sharp","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Sharp"){echo "checked";}?> ><?php xl('Sharp','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Vise-like","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_chest_pain"}=="Vise-like"){echo "checked";}?> ><?php xl('Vise-like','e')?></label><br>
			<b><?php xl('Associated with:','e')?></b>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_associated_with" value="<?php xl("Shortness","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_associated_with"}=="Shortness"){echo "checked";}?> ><?php xl('Shortness of breath','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_associated_with" value="<?php xl("Activity","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_associated_with"}=="Activity"){echo "checked";}?> ><?php xl('Activity','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_associated_with" value="<?php xl("Sweats","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_associated_with"}=="Sweats"){echo "checked";}?> ><?php xl('Sweats','e')?></label><br>
			<b><?php xl('Frequency/duration:','e')?></b>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_frequency" value="<?php xl("Palpitations","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_frequency"}=="Palpitations"){echo "checked";}?> ><?php xl('Palpitations','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_frequency" value="<?php xl("Fatigue","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_frequency"}=="Fatigue"){echo "checked";}?> ><?php xl('Fatigue','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Edema","e");?>" <?php if(in_array("Edema",$oasis_therapy_heart_sounds)) echo "checked"; ?> ><b><?php xl('Edema:','e')?></b></label><br>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_edema" value="<?php xl("Pedal","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_edema"}=="Pedal"){echo "checked";}?> ><?php xl('Pedal Right/Left','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_edema" value="<?php xl("Sacral","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_edema"}=="Sacral"){echo "checked";}?> ><?php xl('Sacral','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_edema" value="<?php xl("Dependent","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_edema"}=="Dependent"){echo "checked";}?> ><?php xl('Dependent:','e')?></label><br>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Pitting +1","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_edema_dependent"}=="Pitting +1"){echo "checked";}?> ><?php xl('Pitting +1','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Pitting +2","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_edema_dependent"}=="Pitting +2"){echo "checked";}?> ><?php xl('Pitting +2','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Pitting +3","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_edema_dependent"}=="Pitting +3"){echo "checked";}?> ><?php xl('Pitting +3','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Pitting +4","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_edema_dependent"}=="Pitting +4"){echo "checked";}?> ><?php xl('Pitting +4','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Non-pitting","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_edema_dependent"}=="Non-pitting"){echo "checked";}?> ><?php xl('Non-pitting','e')?></label><br>
			<?php xl("Site","e");?>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_site" value="<?php xl("Cramps","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_site"}=="Cramps"){echo "checked";}?> ><?php xl('Cramps','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_site" value="<?php xl("Claudication","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_site"}=="Claudication"){echo "checked";}?> ><?php xl('Claudication','e')?></label><br>
			<?php xl("Capillary refill","e");?>
				<label><input type="radio" name="oasis_therapy_heart_sounds_capillary" value="<?php xl("<3","e");?>" <?php if(htmlspecialchars_decode($obj{"oasis_therapy_heart_sounds_capillary"})=="<3"){echo "checked";}?> ><?php xl('less than 3 sec','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_capillary" value="<?php xl(">3","e");?>" <?php if(htmlspecialchars_decode($obj{"oasis_therapy_heart_sounds_capillary"})==">3"){echo "checked";}?> ><?php xl('greater than 3 sec','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Other","e");?>" <?php if(in_array("Other",$oasis_therapy_heart_sounds)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_therapy_heart_sounds_other" value="<?php echo $obj{"oasis_therapy_heart_sounds_other"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Weigh patient","e");?>" <?php if(in_array("Weigh patient",$oasis_therapy_heart_sounds)) echo "checked"; ?> ><?php xl('Weigh patient','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Notify MD","e");?>" <?php if(in_array("Notify MD",$oasis_therapy_heart_sounds)) echo "checked"; ?> ><?php xl('Notify MD of weight variations of','e')?></label>
				<input type="text" name="oasis_therapy_heart_sounds_notify" value="<?php echo $obj{"oasis_therapy_heart_sounds_notify"};?>">
				
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Integumentary Status, Respiratory Status, Cardiac Status, Elimination Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul id="integumentary_status">
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2"> 
			<center><strong><?php xl('INTEGUMENTARY STATUS','e')?></strong></center>
		</td>
	</tr>
	<tr>
		<td valign="top" width="50%">
			<strong><?php xl('<u>(M1306)</u> </strong> Does this patient have at least one <b>Unhealed Pressure Ulcer at Stage II or Higher</b> or designated as "unstageable"?','e'); ?><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status" value="0" <?php if($obj{"oasis_therapy_integumentary_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b>[ Go to M1322 ]</b>','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status" value="1" <?php if($obj{"oasis_therapy_integumentary_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes','e')?></label>
		</td>
		<td>
			<strong><?php xl('<u>(M1307)</u>  The Oldest Non-epithelialized Stage II Pressure Ulcer </strong>that is present at discharge','e'); ?><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status_stage2" value="1" <?php if($obj{"oasis_therapy_integumentary_status_stage2"}=="1"){echo "checked";}?> ><?php xl(' 1 - Was present at the most recent SOC/ROC assessment','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status_stage2" value="2" <?php if($obj{"oasis_therapy_integumentary_status_stage2"}=="2"){echo "checked";}?> ><?php xl(' 2 - Developed since the most recent SOC/ROC assessment: record date pressure ulcer first identified:','e')?></label>

<input type='text' size='10' name='oasis_therapy_integumentary_status_stage2_date' id='oasis_therapy_integumentary_status_stage2_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_integumentary_status_stage2_date"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date79' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_therapy_integumentary_status_stage2_date", ifFormat:"%Y-%m-%d", button:"img_curr_date79"});
						</script>

<br>
			<label><input type="radio" name="oasis_therapy_integumentary_status_stage2" value="NA" <?php if($obj{"oasis_therapy_integumentary_status_stage2"}=="NA"){echo "checked";}?> ><?php xl(' NA - No non-epithelialized Stage II pressure ulcers are present at discharge','e')?></label>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="1px" cellspacing="0" class="formtable">
				<tr>
					<td align="center" colspan="6">
						<strong><?php xl("BRADEN SCALE - For Predicting Pressure Sore Risk","e");?></strong><br>
						<?php xl("*Fill out per organizational policy","e");?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php xl("<strong>HIGH RISK:</strong> Total score less than or equal to 12 &nbsp;&nbsp;&nbsp;&nbsp;<strong>MODERATE RISK:</strong> Total score 13 - 14 <br><strong>LOW RISK:</strong> Total score 15 - 18","e");?>
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("RISK FACTOR","e");?></strong>
					</td>
					<td align="center" colspan="4">
						<strong><?php xl("DESCRIPTION","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("SCORE","e");?></strong>
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("SENSORY PERCEPTION","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("1. COMPLETELY LIMITED","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("2. VERY LIMITED","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("3. SLIGHTLY LIMITED","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("4. NO IMPAIRMENT","e");?></strong>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_braden_scale_sensory" onKeyUp="sum_braden_scale()" id="braden_sensory" value="<?php echo $obj{"oasis_therapy_braden_scale_sensory"};?>">
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("MOISTURE","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("1. CONSTANTLY MOIST","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("2. OFTEN MOIST","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("3. OCCASIONALLY MOIST","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("4. RARELY MOIST","e");?></strong>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_braden_scale_moisture" onKeyUp="sum_braden_scale()" id="braden_moisture" value="<?php echo $obj{"oasis_therapy_braden_scale_moisture"};?>">
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("ACTIVITY","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("1. BEDFAST","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("2. CHAIRFAST","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("3. WALKS OCCASIONALLY","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("4. WALKS FREQUENTLY","e");?></strong>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_braden_scale_activity" onKeyUp="sum_braden_scale()" id="braden_activity" value="<?php echo $obj{"oasis_therapy_braden_scale_activity"};?>">
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("MOBILITY","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("1. COMPLETELY IMMOBILE","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("2. VERY LIMITED","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("3. SLIGHTLY LIMITED","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("4. NO LIMITATIONS","e");?></strong>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_braden_scale_mobility" onKeyUp="sum_braden_scale()" id="braden_mobility" value="<?php echo $obj{"oasis_therapy_braden_scale_mobility"};?>">
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("NUTRITION","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("1. VERY POOR","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("2. PROBABLY INADEQUATE","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("3. ADEQUATE","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("4. EXCELLENT","e");?></strong>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_braden_scale_nutrition" onKeyUp="sum_braden_scale()" id="braden_nutrition" value="<?php echo $obj{"oasis_therapy_braden_scale_nutrition"};?>">
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("FRICTION AND SHEAR","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("1. PROBLEM","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("2. POTENTIAL PROBLEM","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("3. NO APPARENT PROBLEM","e");?></strong>
					</td>
					<td align="center">&nbsp;
						
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_braden_scale_friction" onKeyUp="sum_braden_scale()" id="braden_friction" value="<?php echo $obj{"oasis_therapy_braden_scale_friction"};?>">
					</td>
				</tr>
				<tr>
					<td align="center" colspan="4">
						<strong><?php xl("Total score of 12 or less represents HIGH RISK","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("TOTAL SCORE:","e");?></strong>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_braden_scale_total" id="braden_total" value="<?php echo $obj{"oasis_therapy_braden_scale_total"};?>" readonly>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php xl("<strong><u>(M1308)</u> Current Number of Unhealed (non-epithelialized) Pressure Ulcers at Each Stage:</strong> (Enter '0' if none; excludes Stage I pressure ulcers)","e");?><br>
			<table border="1px" style="width:100%;" cellspacing="0" class="formtable">
				<tr>
					<td width="50%" colspan="2">&nbsp;
						
					</td>
					<td width="25%" align="center">
						<strong><?php xl("Column 1 Complete at SOC/ROC/FU & D/C","e");?></strong>
					</td>
					<td width="25%" align="center">
						<strong><?php xl("Column 2 Complete at FU & D/C","e");?></strong>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<strong><?php xl("Stage description - unhealed pressure ulcers","e");?></strong>
					</td>
					<td align="center">
						<u><?php xl("Number Currently Present","e");?></u>
					</td>
					<td align="center">
						<u><?php xl("Number of those listed in Column 1 that were present on admission (most recent SOC / ROC)","e");?></u>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("a.","e");?>
					</td>
					<td>
						<strong><?php xl("Stage II:</strong> Partial thickness loss of dermis presenting as a shallow open ulcer with red pink wound bed, without slough. May also present as an intact or open/ruptured serum-filled blister.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_a[]" value="<?php echo $oasis_therapy_pressure_ulcer_a[0];?>">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_a[]" value="<?php echo $oasis_therapy_pressure_ulcer_a[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("b.","e");?>
					</td>
					<td>
						<strong><?php xl("Stage III:</strong> Full thickness tissue loss. Subcutaneous fat may be visible but bone, tendon, or muscles are not exposed. Slough may be present but does not obscure the depth of tissue loss. May include undermining and tunneling.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_b[]" value="<?php echo $oasis_therapy_pressure_ulcer_b[0];?>">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_b[]" value="<?php echo $oasis_therapy_pressure_ulcer_b[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("c.","e");?>
					</td>
					<td>
						<strong><?php xl("Stage IV:</strong> Full thickness tissue loss with visible bone, tendon, or muscle. Slough or eschar may be present on some parts of the wound bed. Often includes undermining and tunneling.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_c[]" value="<?php echo $oasis_therapy_pressure_ulcer_c[0];?>">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_c[]" value="<?php echo $oasis_therapy_pressure_ulcer_c[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("d1.","e");?>
					</td>
					<td>
						<?php xl("Unstageable: Known or likely but unstageable due to non-removable dressing or device","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d1[]" value="<?php echo $oasis_therapy_pressure_ulcer_d1[0];?>">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d1[]" value="<?php echo $oasis_therapy_pressure_ulcer_d1[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("d2.","e");?>
					</td>
					<td>
						<?php xl("Unstageable: Known or likely but unstageable due to coverage of wound bed by slough and/or eschar.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d2[]" value="<?php echo $oasis_therapy_pressure_ulcer_d2[0];?>">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d2[]" value="<?php echo $oasis_therapy_pressure_ulcer_d2[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("d3.","e");?>
					</td>
					<td>
						<?php xl("Unstageable: Suspected deep tissue injury in evolution.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d3[]" value="<?php echo $oasis_therapy_pressure_ulcer_d3[0];?>">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d3[]" value="<?php echo $oasis_therapy_pressure_ulcer_d3[1];?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="1px" cellspacing="0" class="formtable" width="100%">
				<tr>
					<td align="center">
						<strong><?php xl("WOUND/LESION (specify)","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("#","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("#","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("#","e");?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Location","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="<?php echo $oasis_therapy_wound_lesion_location[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="<?php echo $oasis_therapy_wound_lesion_location[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="<?php echo $oasis_therapy_wound_lesion_location[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Type","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="<?php echo $oasis_therapy_wound_lesion_type[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="<?php echo $oasis_therapy_wound_lesion_type[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="<?php echo $oasis_therapy_wound_lesion_type[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Status","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="<?php echo $oasis_therapy_wound_lesion_status[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="<?php echo $oasis_therapy_wound_lesion_status[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="<?php echo $oasis_therapy_wound_lesion_status[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Size (cm)","e");?>
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_length[0];?>">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_width[0];?>">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_depth[0];?>">
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_length[1];?>">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_width[1];?>">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_depth[1];?>">
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_length[2];?>">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_width[2];?>">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_depth[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Stage (pressure ulcers only)","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="<?php echo $oasis_therapy_wound_lesion_stage[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="<?php echo $oasis_therapy_wound_lesion_stage[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="<?php echo $oasis_therapy_wound_lesion_stage[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Tunneling/Undermining","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="<?php echo $oasis_therapy_wound_lesion_tunneling[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="<?php echo $oasis_therapy_wound_lesion_tunneling[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="<?php echo $oasis_therapy_wound_lesion_tunneling[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Odor","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="<?php echo $oasis_therapy_wound_lesion_odor[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="<?php echo $oasis_therapy_wound_lesion_odor[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="<?php echo $oasis_therapy_wound_lesion_odor[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Surrounding Skin","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="<?php echo $oasis_therapy_wound_lesion_skin[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="<?php echo $oasis_therapy_wound_lesion_skin[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="<?php echo $oasis_therapy_wound_lesion_skin[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Edema","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="<?php echo $oasis_therapy_wound_lesion_edema[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="<?php echo $oasis_therapy_wound_lesion_edema[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="<?php echo $oasis_therapy_wound_lesion_edema[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Stoma","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="<?php echo $oasis_therapy_wound_lesion_stoma[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="<?php echo $oasis_therapy_wound_lesion_stoma[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="<?php echo $oasis_therapy_wound_lesion_stoma[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Appearance of the Wound Bed","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="<?php echo $oasis_therapy_wound_lesion_appearance[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="<?php echo $oasis_therapy_wound_lesion_appearance[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="<?php echo $oasis_therapy_wound_lesion_appearance[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Drainage Amount","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="<?php echo $oasis_therapy_wound_lesion_drainage[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="<?php echo $oasis_therapy_wound_lesion_drainage[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="<?php echo $oasis_therapy_wound_lesion_drainage[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Color","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="<?php echo $oasis_therapy_wound_lesion_color[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="<?php echo $oasis_therapy_wound_lesion_color[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="<?php echo $oasis_therapy_wound_lesion_color[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Consistency","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="<?php echo $oasis_therapy_wound_lesion_consistency[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="<?php echo $oasis_therapy_wound_lesion_consistency[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="<?php echo $oasis_therapy_wound_lesion_consistency[2];?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<?php xl("<b>Directions for M1310, M1312, and M1314:</b> If the patient has one or more unhealed (non-epithelialized) <b>Stage III or IV pressure ulcers, identify the Stage III or IV pressure ulcer with the largest surface dimension (length x width)</b> and record in centimeters. If no Stage III or Stage IV pressure ulcers, go to M1320.","e");?><br><br>
			<?php xl("<b><u>(M1310)</u> Pressure Ulcer Length:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_length" value="<?php echo $obj{"oasis_therapy_pressure_ulcer_length"};?>"><br>
			<?php xl("Longest length \"head-to-toe\" (cm)","e");?>
			<br>
			<?php xl("<b><u>(M1312)</u> Pressure Ulcer Width:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_width" value="<?php echo $obj{"oasis_therapy_pressure_ulcer_width"};?>"><br>
			<?php xl("Width of the same pressure ulcer; greatest width perpendicular to the length (cm)","e");?>
			<br>
			<?php xl("<b><u>(M1314)</u> Pressure Ulcer Depth:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_depth" value="<?php echo $obj{"oasis_therapy_pressure_ulcer_depth"};?>"><br>
			<?php xl("Depth of the same pressure ulcer; from visible surface to the deepest area (cm)","e");?>
			<br>
			<hr>
			<strong><?php xl('<u>(M1320)</u> Status of Most Problematic (Observable) Pressure Ulcer:','e');?></strong><br>
			<label><input id="m1320" type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="0" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - Newly epithelialized','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - Fully granulating','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="2"){echo "checked";}?> ><?php xl(' 2 - Early/partial granulation','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="3"){echo "checked";}?> ><?php xl(' 3 - Not healing','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="NA" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="NA"){echo "checked";}?> ><?php xl(' NA - No observable pressure ulcer','e')?></label><br>
			<br>
			<hr>
			<?php xl('<b><u>(M1322)</u>Current Number of Stage I Pressure Ulcers:</b> Intact skin with non-blanchable redness of a localized area usually over a bony prominence. The area may be painful, firm, soft, warmer or cooler as compared to adjacent tissue.','e');?><br>
			<label><input type="radio" id="m1322" name="oasis_therapy_pressure_ulcer_current_no" value="0" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="4" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="4"){echo "checked";}?> ><?php xl(' 4 or more ','e')?></label>
			<br>
			<hr>
			<strong><?php xl('<u>(M1324)</u> Stage of Most Problematic Unhealed (Observable) Pressure Ulcer:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="1"){echo "checked";}?> ><?php xl(' 1 - Stage I ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="2"){echo "checked";}?> ><?php xl(' 2 - Stage II ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="3"){echo "checked";}?> ><?php xl(' 3 - Stage III ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="4" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="4"){echo "checked";}?> ><?php xl(' 4 - Stage IV ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="NA" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="NA"){echo "checked";}?> ><?php xl(' NA - No observable pressure ulcer or unhealed pressure ulcer ','e')?></label><br>
			
		</td>
		<td>
			<?php xl('<b><u>(M1330)</u></b> Does this patient have a <b>Stasis Ulcer?</b>','e');?><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer" value="0" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b><i>[ Go to M1340 ] </i></b>','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes, patient has BOTH observable and unobservable stasis ulcers ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer"}=="2"){echo "checked";}?> ><?php xl(' 2 - Yes, patient has observable stasis ulcers ONLY ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer"}=="3"){echo "checked";}?> ><?php xl(' 3 - Yes, patient has unobservable stasis ulcers ONLY (known but not observable due to non-removable dressing) <b><i>[ Go to M1340 ]</i></b> ','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('<u>(M1332)</u> Current Number of (Observable) Stasis Ulcer(s):','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_num" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer_num"}=="1"){echo "checked";}?> ><?php xl(' 1 - One ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_num" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer_num"}=="2"){echo "checked";}?> ><?php xl(' 2 - Two ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_num" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer_num"}=="3"){echo "checked";}?> ><?php xl(' 3 - Three ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_num" value="4" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer_num"}=="4"){echo "checked";}?> ><?php xl(' 4 - Four or more ','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('<u>(M1334)</u> Status of Most Problematic (Observable) Stasis Ulcer:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_status" value="0" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - Newly epithelialized ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_status" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - Fully granulating ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_status" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer_status"}=="2"){echo "checked";}?> ><?php xl(' 2 - Early/partial granulation ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_status" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_statis_ulcer_status"}=="3"){echo "checked";}?> ><?php xl(' 3 - Not healing ','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1340)</u></b> Does this patient have a <b>Surgical Wound?</b>','e');?><br>
			<label><input type="radio" id="m1340" name="oasis_therapy_surgical_wound" value="0" <?php if($obj{"oasis_therapy_surgical_wound"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b><i>[ Go to M1350 ] </i></b>','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="1" <?php if($obj{"oasis_therapy_surgical_wound"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes, patient has at least one (observable) surgical wound ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="2" <?php if($obj{"oasis_therapy_surgical_wound"}=="2"){echo "checked";}?> ><?php xl(' 2 - Surgical wound known but not observable due to non-removable dressing <b><i>[ Go to M1350 ] </i></b>','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('<u>(M1342)</u> Status of Most Problematic (Observable) Surgical Wound:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="0" <?php if($obj{"oasis_therapy_status_surgical_wound"}=="0"){echo "checked";}?> ><?php xl(' 0 - Newly epithelialized ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="1" <?php if($obj{"oasis_therapy_status_surgical_wound"}=="1"){echo "checked";}?> ><?php xl(' 1 - Fully granulating ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="2" <?php if($obj{"oasis_therapy_status_surgical_wound"}=="2"){echo "checked";}?> ><?php xl(' 2 - Early/partial granulation ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="3" <?php if($obj{"oasis_therapy_status_surgical_wound"}=="3"){echo "checked";}?> ><?php xl(' 3 - Not healing ','e')?></label><br>
			
		</td>
	</tr>
	<tr>
		<td valign="top">
			<?php xl('<b><u>(M1350)</u></b> Does this patient have a <b>Skin Lesion or Open Wound</b>, excluding bowel ostomy, other than those described above <u>that is receiving intervention</u> by the home health agency?','e');?><br>
			<label><input type="radio" id="m1350" name="oasis_therapy_skin_lesion" value="0" <?php if($obj{"oasis_therapy_skin_lesion"}=="0"){echo "checked";}?> ><?php xl(' 0 - No ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_skin_lesion" value="1" <?php if($obj{"oasis_therapy_skin_lesion"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes ','e')?></label><br>
			<br>
			<hr>
			<center><strong>
				<?php xl('INTEGUMENTARY STATUS','e')?>
				<label><input type="checkbox" name="oasis_therapy_integumentary_status_problem" value="<?php xl("No","e");?>" <?php if($obj{"oasis_therapy_integumentary_status_problem"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</strong></center>
			<?php xl('Wound care done:','e')?>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_wound_care_done" value="Yes" <?php if($obj{"oasis_therapy_wound_care_done"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_wound_care_done" value="No" <?php if($obj{"oasis_therapy_wound_care_done"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
			
			<?php xl('Location(s) if patient has more than one wound site:','e')?>
			<input type="text" name="oasis_therapy_wound_location" value="<?php echo $obj{"oasis_therapy_wound_location"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Soiled dressing removed","e");?>" <?php if(in_array("Soiled dressing removed",$oasis_therapy_wound)) echo "checked"; ?> ><?php xl('Soiled dressing removed','e')?></label>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php xl('By:','e')?>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_dressing_by" value="<?php xl("Patient","e");?>" <?php if($obj{"oasis_therapy_wound_soiled_dressing_by"}=="Patient"){echo "checked";}?> ><?php xl('Patient','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_dressing_by" value="<?php xl("Family/caregiver","e");?>" <?php if($obj{"oasis_therapy_wound_soiled_dressing_by"}=="Family/caregiver"){echo "checked";}?> ><?php xl('Family/caregiver','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_dressing_by" value="<?php xl("RN/PT","e");?>" <?php if($obj{"oasis_therapy_wound_soiled_dressing_by"}=="RN/PT"){echo "checked";}?> ><?php xl('RN/PT','e')?></label>
			<br>
			
			<?php xl('Technique:','e')?>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_technique" value="<?php xl("Sterile","e");?>" <?php if($obj{"oasis_therapy_wound_soiled_technique"}=="Sterile"){echo "checked";}?> ><?php xl('Sterile','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_technique" value="<?php xl("Clean","e");?>" <?php if($obj{"oasis_therapy_wound_soiled_technique"}=="Clean"){echo "checked";}?> ><?php xl('Clean','e')?></label>
			<br>
			
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Wound cleaned with","e");?>" <?php if(in_array("Wound cleaned with",$oasis_therapy_wound)) echo "checked"; ?> ><?php xl('Wound cleaned with (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_cleaned" value="<?php echo $obj{"oasis_therapy_wound_cleaned"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Wound irrigated with","e");?>" <?php if(in_array("Wound cleaned with",$oasis_therapy_wound)) echo "checked"; ?> ><?php xl('Wound irrigated with (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_irrigated" value="<?php echo $obj{"oasis_therapy_wound_irrigated"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Wound packed with","e");?>" <?php if(in_array("Wound packed with",$oasis_therapy_wound)) echo "checked"; ?> ><?php xl('Wound packed with (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_packed" value="<?php echo $obj{"oasis_therapy_wound_packed"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Wound dressing applied","e");?>" <?php if(in_array("Wound dressing applied",$oasis_therapy_wound)) echo "checked"; ?> ><?php xl('Wound dressing applied (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_dressing_apply" value="<?php echo $obj{"oasis_therapy_wound_dressing_apply"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Patient tolerated procedure well","e");?>" <?php if(in_array("Patient tolerated procedure well",$oasis_therapy_wound)) echo "checked"; ?> ><?php xl('Patient tolerated procedure well','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Incision care with","e");?>" <?php if(in_array("Incision care with",$oasis_therapy_wound)) echo "checked"; ?> ><?php xl('Incision care with (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_incision" value="<?php echo $obj{"oasis_therapy_wound_incision"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Staples present","e");?>" <?php if(in_array("Staples present",$oasis_therapy_wound)) echo "checked"; ?> ><?php xl('Staples present','e')?></label><br>
			<?php xl("Comments:","e");?>
			<textarea name="oasis_therapy_wound_comment" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_wound_comment"};?></textarea><br>
			
			<?php xl('Satisfactory return demo:','e')?>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_satisfactory_return_demo" value="Yes" <?php if($obj{"oasis_therapy_satisfactory_return_demo"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_satisfactory_return_demo" value="No" <?php if($obj{"oasis_therapy_satisfactory_return_demo"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
			<?php xl('Education: ','e')?>
			<label><input type="checkbox" name="oasis_therapy_wound_education" value="Yes" <?php if($obj{"oasis_therapy_wound_education"}=="Yes"){echo "checked";}?> ><?php xl('Yes','e')?></label><br>
			<?php xl("Comments:","e");?>
			<textarea name="oasis_therapy_wound_education_comment" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_wound_education_comment"};?></textarea>
			<br>
			<hr>
			<center><strong><?php xl("RESPIRATORY STATUS","e");?></strong></center>
			<strong><?php xl("<u>(M1400)</u>","e");?></strong>
			<?php xl(" When is the patient dyspneic or noticeably ","e");?> 
			<strong><?php xl(" Short of Breath?","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="0" <?php if($obj{"oasis_therapy_respiratory_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - Patient is not short of breath ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="1" <?php if($obj{"oasis_therapy_respiratory_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - When walking more than 20 feet, climbing stairs ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="2" <?php if($obj{"oasis_therapy_respiratory_status"}=="2"){echo "checked";}?> ><?php xl(' 2 - With moderate exertion (e.g., while dressing, using commode or bedpan, walking distances less than 20 feet) ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="3" <?php if($obj{"oasis_therapy_respiratory_status"}=="3"){echo "checked";}?> ><?php xl(' 3 - With minimal exertion (e.g., while eating, talking, or performing other ADLs) or with agitation ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="4" <?php if($obj{"oasis_therapy_respiratory_status"}=="4"){echo "checked";}?> ><?php xl(' 4 - At rest (during day or night) ','e')?></label> <br>
			<br><hr>
			<strong><?php xl("<b><u>(M1410)</u>Respiratory Treatments</b> utilized at home: <b>(Mark all that apply.)</b>","e");?></strong><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="1" <?php if(in_array("1",$oasis_therapy_respiratory_treatment)) echo "checked"; ?> ><?php xl(' 1 - Oxygen (intermittent or continuous) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="2" <?php if(in_array("2",$oasis_therapy_respiratory_treatment)) echo "checked"; ?> ><?php xl(' 2 - Ventilator (continually or at night) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="3" <?php if(in_array("3",$oasis_therapy_respiratory_treatment)) echo "checked"; ?> ><?php xl(' 3 - Continuous / Bi-level positive airway pressure ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="4" <?php if(in_array("4",$oasis_therapy_respiratory_treatment)) echo "checked"; ?> ><?php xl(' 4 - None of the above ','e')?></label>
			
			<br>
			<hr>
			<center><strong><?php xl("CARDIAC STATUS","e");?></strong></center>
			<strong><?php xl("<u>(M1500)</u>Symptoms in Heart Failure Patients:","e");?></strong>
			<?php xl(" If patient has been diagnosed with heart failure, did the patient exhibit symptoms indicated by clinical heart failure guidelines (including dyspnea, orthopnea, edema, or weight gain) at any point since the previous OASIS assessment? ","e");?><br>
			<label><input type="radio" id="m1500" name="oasis_cardiac_status_symptoms" value="0" <?php if($obj{"oasis_cardiac_status_symptoms"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b><i>[ Go to M2004 at TRN; Go to M1600 at DC ]</i></b> ','e')?></label><br>
			<label><input type="radio" name="oasis_cardiac_status_symptoms" value="1" <?php if($obj{"oasis_cardiac_status_symptoms"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes ','e')?></label><br>
			<label><input type="radio" name="oasis_cardiac_status_symptoms" value="2" <?php if($obj{"oasis_cardiac_status_symptoms"}=="2"){echo "checked";}?> ><?php xl(' 2 - Not assessed <b><i>[Go to M2004 at TRN; Go to M1600 at DC ]</i></b> ','e')?></label><br>
			<label><input type="radio" name="oasis_cardiac_status_symptoms" value="NA" <?php if($obj{"oasis_cardiac_status_symptoms"}=="NA"){echo "checked";}?> ><?php xl(' NA - Patient does not have diagnosis of heart failure <b><i>[Go to M2004 at TRN; Go to M1600 at DC ]</i></b> ','e')?></label><br>
			
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1510)</u> Heart Failure Follow-up:","e");?></strong>
			<?php xl(" If patient has been diagnosed with heart failure and has exhibited symptoms indicative of heart failure since the previous OASIS assessment, what action(s) has (have) been taken to respond? <b>(Mark all that apply.)</b>","e");?><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="0" <?php if(in_array("0",$oasis_cardiac_status_heart_failure)) echo "checked"; ?> ><?php xl(' 0 - No action taken ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="1" <?php if(in_array("1",$oasis_cardiac_status_heart_failure)) echo "checked"; ?> ><?php xl(' 1 - Patient\'s physician (or other primary care practitioner) contacted the same day ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="2" <?php if(in_array("2",$oasis_cardiac_status_heart_failure)) echo "checked"; ?> ><?php xl(' 2 - Patient advised to get emergency treatment (e.g., call 911 or go to emergency room) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="3" <?php if(in_array("3",$oasis_cardiac_status_heart_failure)) echo "checked"; ?> ><?php xl(' 3 - Implemented physician-ordered patient-specific established parameters for treatment ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="4" <?php if(in_array("4",$oasis_cardiac_status_heart_failure)) echo "checked"; ?> ><?php xl(' 4 - Patient education or other clinical interventions ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="5" <?php if(in_array("5",$oasis_cardiac_status_heart_failure)) echo "checked"; ?> ><?php xl(' 5 - Obtained change in care plan orders (e.g., increased monitoring by agency, change in visit frequency, telehealth, etc.) ','e')?></label><br>
			
			<br>
			<hr>
			<center><strong><?php xl("ELIMINATION STATUS","e");?></strong></center>
			<?php xl("<b><u>(M1600)</u></b> Has this patient been treated for a <b>Urinary Tract Infection</b> in the past 14 days?","e");?><br>
			<label><input type="radio" id="m1600" name="oasis_elimination_status_tract_infection" value="0" <?php if($obj{"oasis_elimination_status_tract_infection"}=="0"){echo "checked";}?> ><?php xl(' 0 - No ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="1" <?php if($obj{"oasis_elimination_status_tract_infection"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="NA" <?php if($obj{"oasis_elimination_status_tract_infection"}=="NA"){echo "checked";}?> ><?php xl(' NA - Patient on prophylactic treatment ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="UK" <?php if($obj{"oasis_elimination_status_tract_infection"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown <b>[Omit "UK" option on DC]</b> ','e')?></label> <br>
			
			<br>
			<hr>
			<strong><?php xl("<u>(M1610)</u> Urinary Incontinence or Urinary Catheter Presence:","e");?></strong><br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="0" <?php if($obj{"oasis_elimination_status_urinary_incontinence"}=="0"){echo "checked";}?> ><?php xl(' 0 - No incontinence or catheter (includes anuria or ostomy for urinary drainage) <b><i>[ Go to M1620 ] </i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="1" <?php if($obj{"oasis_elimination_status_urinary_incontinence"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient is incontinent ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="2" <?php if($obj{"oasis_elimination_status_urinary_incontinence"}=="2"){echo "checked";}?> ><?php xl(' 2 - Patient requires a urinary catheter (i.e., external, indwelling, intermittent, suprapubic) <b><i>[ Go to M1620 ]</i></b> ','e')?></label> <br>
			
			<br>
			<hr>
			<?php xl("<b><u>(M1615)</u> When</b> does <b>Urinary Incontinence</b> occur?","e");?><br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="0" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="0"){echo "checked";}?> ><?php xl(' 0 - Timed-voiding defers incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="1" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="1"){echo "checked";}?> ><?php xl(' 1 - Occasional stress incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="2" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="2"){echo "checked";}?> ><?php xl(' 2 - During the night only ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="3" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="3"){echo "checked";}?> ><?php xl(' 3 - During the day only ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="4" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="4"){echo "checked";}?> ><?php xl(' 4 - During the day and night ','e')?></label> <br>
			
			<br>
			<hr>
			<strong><?php xl("<u>(M1620)</u> Bowel Incontinence Frequency:","e");?></strong><br>
			<label><input type="radio" id="m1620" name="oasis_elimination_status_bowel_incontinence" value="0" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="0"){echo "checked";}?> ><?php xl(' 0 - Very rarely or never has bowel incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="1" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="1"){echo "checked";}?> ><?php xl(' 1 - Less than once weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="2" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="2"){echo "checked";}?> ><?php xl(' 2 - One to three times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="3" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="3"){echo "checked";}?> ><?php xl(' 3 - Four to six times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="4" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="4"){echo "checked";}?> ><?php xl(' 4 - On a daily basis ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="5" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="5"){echo "checked";}?> ><?php xl(' 5 - More often than once daily ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="NA" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="NA"){echo "checked";}?> ><?php xl(' NA - Patient has ostomy for bowel elimination ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="UK" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown <b>[Omit "UK" option on FU, DC]</b> ','e')?></label> <br>
			
			<br>
			<hr>
			<center><strong><?php xl("MENTAL STATUS","e");?></strong></center><br>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Oriented"
			<?php if(in_array("Oriented",$oasis_mental_status)) echo "checked"; ?> ><?php xl('Oriented','e')?></label>
						<label><input type="checkbox" name="oasis_mental_status[]" value="Comatose"
			<?php if(in_array("Comatose",$oasis_mental_status)) echo "checked"; ?> ><?php xl('Comatose','e')?></label>
						<label><input type="checkbox" name="oasis_mental_status[]" value="Forgetful"
			<?php if(in_array("Forgetful",$oasis_mental_status)) echo "checked"; ?> ><?php xl('Forgetful','e')?></label>
						<label><input type="checkbox" name="oasis_mental_status[]" value="Depressed"
			<?php if(in_array("Depressed",$oasis_mental_status)) echo "checked"; ?> ><?php xl('Depressed','e')?></label>
						<label><input type="checkbox" name="oasis_mental_status[]" value="Disoriented"
			<?php if(in_array("Disoriented",$oasis_mental_status)) echo "checked"; ?> ><?php xl('Disoriented','e')?></label>
						<label><input type="checkbox" name="oasis_mental_status[]" value="Lethargic"
			<?php if(in_array("Lethargic",$oasis_mental_status)) echo "checked"; ?> ><?php xl('Lethargic','e')?></label>
						<label><input type="checkbox" name="oasis_mental_status[]" value="Agitated"
			<?php if(in_array("Agitated",$oasis_mental_status)) echo "checked"; ?> ><?php xl('Agitated','e')?></label>
						<label><input type="checkbox" name="oasis_mental_status[]" value="Other"
			<?php if(in_array("Other",$oasis_mental_status)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_mental_status_other"  value="<?php echo stripslashes($obj{"oasis_mental_status_other"});?>" >

			<br>
			<hr>
			<center><strong><?php xl("FUNCTIONAL LIMITATIONS","e");?></strong></center><br>
			<table class="formtable">
				<tr valign="top">
					<td width="30%">
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Amputation"
			<?php if(in_array("Amputation",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Amputation','e')?></label><br>
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Hearing"
			<?php if(in_array("Hearing",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Hearing','e')?></label><br>
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Ambulation"
			<?php if(in_array("Ambulation",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Ambulation','e')?></label><br>
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Dyspnea with Minimal Exertion"
			<?php if(in_array("Dyspnea with Minimal Exertion",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Dyspnea with Minimal Exertion','e')?></label>
								</td>

								<td width="45%">
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Bowel/Bladder (Incontinence)"
			<?php if(in_array("Bowel/Bladder (Incontinence)",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Bowel/Bladder (Incontinence)','e')?></label><br>
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Paralysis"
			<?php if(in_array("Paralysis",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Paralysis','e')?></label><br>
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Speech"
			<?php if(in_array("Speech",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Speech','e')?></label><br>
										
								</td>

								<td width="25%">
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Contracture"
			<?php if(in_array("Contracture",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Contracture','e')?></label><br>
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Endurance"
			<?php if(in_array("Endurance",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Endurance','e')?></label><br>
									<label><input type="checkbox" name="oasis_functional_limitations[]" value="Legally Blind"
			<?php if(in_array("Legally Blind",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Legally Blind','e')?></label>
								</td>
							</tr>
							<tr>
							<td colspan="3">
							<label><input type="checkbox" name="oasis_functional_limitations[]" value="Other"
			<?php if(in_array("Other",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Other (specify):','e')?></label>
			<input type="text" name="oasis_functional_limitations_other"  value="<?php echo stripslashes($obj{"oasis_functional_limitations_other"});?>" size="15">
				</td>
				</tr>
			</table>

			<br>
			<hr>
			<center><strong><?php xl('PROGNOSIS','e')?></strong></center><br>
			<strong><?php xl('Prognosis:','e')?></strong>
			<label><input type="radio" name="oasis_prognosis" value="1"
			<?php if($obj{"oasis_prognosis"}=="1") echo "checked"; ?>  ><?php xl(' 1-Poor ','e')?></label>
						<label><input type="radio" name="oasis_prognosis" value="2"
			<?php if($obj{"oasis_prognosis"}=="2") echo "checked"; ?>  ><?php xl(' 2-Guarded ','e')?></label>
						<label><input type="radio" name="oasis_prognosis" value="3"
			<?php if($obj{"oasis_prognosis"}=="3") echo "checked"; ?>  ><?php xl(' 3-Fair ','e')?></label>
						<label><input type="radio" name="oasis_prognosis" value="4"
			<?php if($obj{"oasis_prognosis"}=="4") echo "checked"; ?>  ><?php xl(' 4-Good ','e')?></label>
						<label><input type="radio" name="oasis_prognosis" value="5"
			<?php if($obj{"oasis_prognosis"}=="5") echo "checked"; ?>  ><?php xl(' 5-Excellent ','e')?></label>

			<br>
			<hr>
			<center><strong><?php xl("SAFETY MEASURES","e");?></strong></center>
			<table class="formtable">
			    <tr>
				    <td width="50%">
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="911 Protocol"
		    <?php if(in_array("911 Protocol",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('911 Protocol','e')?></label><br>

					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Clear Pathways"
		    <?php if(in_array("Clear Pathways",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Clear Pathways','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Siderails up"
		    <?php if(in_array("Siderails up",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Siderails up','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Safe Transfers"
		    <?php if(in_array("Safe Transfers",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Safe Transfers','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Equipment Safety"
		    <?php if(in_array("Equipment Safety",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Equipment Safety','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Infection Control Measures"
		    <?php if(in_array("Infection Control Measures",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Infection Control Measures','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Bleeding Precautions"
		    <?php if(in_array("Bleeding Precautions",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Bleeding Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Fall Precautions"
		    <?php if(in_array("Fall Precautions",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Fall Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Seizure Precautions"
		    <?php if(in_array("Seizure Precautions",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Seizure Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Universal Precautions"
		    <?php if(in_array("Universal Precautions",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Universal Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Other"
		    <?php if(in_array("Other",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Other:','e')?></label>

						    <input type="text" name="oasis_safety_measures_other"  value="<?php echo stripslashes($obj{"oasis_safety_measures_other"});?>" ><br>

				    </td>
				    <td>

					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Hazard-Free Environment"
		    <?php if(in_array("Hazard-Free Environment",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Hazard-Free Environment','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Lock W/C with transfers"
		    <?php if(in_array("Lock W/C with transfers",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Lock W/C with transfers','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Elevate Head of Bed"
		    <?php if(in_array("Elevate Head of Bed",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Elevate Head of Bed','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Medication Safety/Storage"
		    <?php if(in_array("Medication Safety/Storage",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Medication Safety/Storage','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Hazardous Waste Disposal"
		    <?php if(in_array("Hazardous Waste Disposal",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Hazardous Waste Disposal','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="24 hr. supervision"
		    <?php if(in_array("24 hr. supervision",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('24 hr. supervision','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Neutropenic"
		    <?php if(in_array("Neutropenic",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Neutropenic','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="O2 Precautions"
		    <?php if(in_array("O2 Precautions",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('O2 Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Aspiration Precautions"
		    <?php if(in_array("Aspiration Precautions",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Aspiration Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasis_safety_measures[]" value="Walker/Cane"
		    <?php if(in_array("Walker/Cane",$oasis_safety_measures)) echo "checked"; ?> ><?php xl('Walker/Cane','e')?></label><br>
				    </td>
			    </tr>
			    </table>




			<br>
			<hr>
		    <strong><?php xl("IV SUPPLIES: ","e");?></strong><br />
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV start kit"
<?php if(in_array("IV start kit",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV start kit','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV pole"
<?php if(in_array("IV pole",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV pole','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV tubing" 
<?php if(in_array("IV tubing",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV tubing','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Alcohol swabs"
<?php if(in_array("Alcohol swabs",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Alcohol swabs','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Angiocatheter size"
<?php if(in_array("Angiocatheter size",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Angiocatheter size','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Tape"
<?php if(in_array("Tape",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Tape','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Extension tubings"
<?php if(in_array("Extension tubings",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Extension tubings','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Injection caps"
<?php if(in_array("Injection caps",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Injection caps','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Central line dressing"
<?php if(in_array("Central line dressing",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Central line dressing','e')?></label><br>
		    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Infusion pump"
<?php if(in_array("Infusion pump",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Infusion pump','e')?></label><br>
				    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Batteries size"
<?php if(in_array("Batteries size",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Batteries size','e')?></label><br>
				    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Syringes size"
<?php if(in_array("Syringes size",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Syringes size','e')?></label><br>
				    <label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Other"
<?php if(in_array("Other",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Other','e')?></label>


    <input type="text" name="oasis_dme_iv_supplies_other"  value="<?php echo stripslashes($obj{"oasis_dme_iv_supplies_other"});?>" >


			<br>
			<hr>
			<strong><?php xl("FOLEY SUPPLIES: ","e");?></strong><br />
			<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Fr catheter kit"
<?php if(in_array("Fr catheter kit",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Fr catheter kit','e')?></label><br>
			<?php xl("(tray, bag, foley) ","e");?><br>
			<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Straight catheter"
<?php if(in_array("Straight catheter",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Straight catheter','e')?></label><br>
			<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Irrigation tray"
<?php if(in_array("Irrigation tray",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Irrigation tray','e')?></label><br>
			<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Saline"
<?php if(in_array("Saline",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Saline','e')?></label><br>
			<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Acetic acid"
<?php if(in_array("Acetic acid",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Acetic acid','e')?></label><br>
			<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Other"
<?php if(in_array("Other",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Other','e')?></label><br>

<input type="text" name="oasis_dme_foley_supplies_other"  value="<?php echo stripslashes($obj{"oasis_dme_foley_supplies_other"});?>" >

					</td>
				</tr>
			</table>



		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Neuro/Emotional/Behavioral Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2"> 
			<center><strong><?php xl('NEURO / EMOTIONAL / BEHAVIORAL STATUS','e')?></strong></center>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl("<u>(M1700)</u>","e");?>
			<?php xl("Cognitive Functioning:","e");?></strong>
			<?php xl("Patient's current (day of assessment) level of alertness, orientation, comprehension, concentration, and immediate memory for simple commands.","e");?> 
			<br />
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="0" <?php if($obj{"oasis_neuro_cognitive_functioning"}=="0") echo "checked"; ?> ><?php xl(' 0 - Alert/oriented, able to focus and shift attention, comprehends and recalls task directions independently. ','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="1" <?php if($obj{"oasis_neuro_cognitive_functioning"}=="1") echo "checked"; ?> ><?php xl(' 1 - Requires prompting (cuing, repetition, reminders) only under stressful or unfamiliar conditions. ','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="2" <?php if($obj{"oasis_neuro_cognitive_functioning"}=="2") echo "checked"; ?> ><?php xl(' 2 - Requires assistance and some direction in specific situations (e.g., on all tasks involving shifting of attention), or consistently requires low stimulus environment due to distractibility.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="3" <?php if($obj{"oasis_neuro_cognitive_functioning"}=="3") echo "checked"; ?> ><?php xl(' 3 - Requires considerable assistance in routine situations. Is not alert and oriented or is unable to shift attention and recall directions more than half the time.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="4" <?php if($obj{"oasis_neuro_cognitive_functioning"}=="4") echo "checked"; ?> ><?php xl(' 4 - Totally dependent due to disturbances such as constant disorientation, coma, persistent vegetative state, or delirium.','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1710)</u>","e");?>
			<?php xl("When Confused (Reported or Observed Within the Last 14 Days):","e");?></strong>
			<br />
			<label><input type="radio" name="oasis_neuro_when_confused" value="0" <?php if($obj{"oasis_neuro_when_confused"}=="0") echo "checked"; ?> ><?php xl(' 0 - Never','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="1" <?php if($obj{"oasis_neuro_when_confused"}=="1") echo "checked"; ?> ><?php xl(' 1 - In new or complex situations only','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="2" <?php if($obj{"oasis_neuro_when_confused"}=="2") echo "checked"; ?> ><?php xl(' 2 - On awakening or at night only','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="3" <?php if($obj{"oasis_neuro_when_confused"}=="3") echo "checked"; ?> ><?php xl(' 3 - During the day and evening, but not constantly','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="4" <?php if($obj{"oasis_neuro_when_confused"}=="4") echo "checked"; ?> ><?php xl(' 4 - Constantly','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="NA" <?php if($obj{"oasis_neuro_when_confused"}=="NA") echo "checked"; ?> ><?php xl(' NA - Patient nonresponsive','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1720)</u>","e");?>
			<?php xl("When Anxious (Reported or Observed Within the Last 14 Days):","e");?></strong>
			<br />
			<label><input type="radio" name="oasis_neuro_when_anxious" value="0" <?php if($obj{"oasis_neuro_when_anxious"}=="0") echo "checked"; ?> ><?php xl(' 0 - None of the time','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_anxious" value="1" <?php if($obj{"oasis_neuro_when_anxious"}=="1") echo "checked"; ?> ><?php xl(' 1 - Less often than daily','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_anxious" value="2" <?php if($obj{"oasis_neuro_when_anxious"}=="2") echo "checked"; ?> ><?php xl(' 2 - Daily, but not constantly','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_anxious" value="3" <?php if($obj{"oasis_neuro_when_anxious"}=="3") echo "checked"; ?> ><?php xl(' 3 - All of the time','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_anxious" value="NA" <?php if($obj{"oasis_neuro_when_anxious"}=="NA") echo "checked"; ?> ><?php xl(' NA - Patient nonresponsive','e')?></label> <br>
			<br>
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1740)</u>","e");?></strong>
			<?php xl("<strong>Cognitive, behavioral, and psychiatric symptoms</strong> that are demonstrated <u>at least once a week</u> (Reported or Observed). <strong>(Mark all that apply.)</strong>","e");?> 
			<br />
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="1" <?php if(in_array("1",$oasis_neuro_cognitive_symptoms)) echo "checked"; ?> ><?php xl(' 1 - Memory deficit: failure to recognize familiar persons/places, inability to recall events of past 24 hours, significant memory loss so that supervision is required','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="2" <?php if(in_array("2",$oasis_neuro_cognitive_symptoms)) echo "checked"; ?> ><?php xl(' 2 - Impaired decision-making: failure to perform usual ADLs or IADLs, inability to appropriately stop activities, jeopardizes safety through actions','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="3" <?php if(in_array("3",$oasis_neuro_cognitive_symptoms)) echo "checked"; ?> ><?php xl(' 3 - Verbal disruption: yelling, threatening, excessive profanity, sexual references, etc.','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="4" <?php if(in_array("4",$oasis_neuro_cognitive_symptoms)) echo "checked"; ?> ><?php xl(' 4 - Physical aggression: aggressive or combative to self and others (e.g., hits self, throws objects, punches, dangerous maneuvers with wheelchair or other objects)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="5" <?php if(in_array("5",$oasis_neuro_cognitive_symptoms)) echo "checked"; ?> ><?php xl(' 5 - Disruptive, infantile, or socially inappropriate behavior ( <strong>excludes</strong> verbal actions)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="6" <?php if(in_array("6",$oasis_neuro_cognitive_symptoms)) echo "checked"; ?> ><?php xl(' 6 - Delusional, hallucinatory, or paranoid behaviors','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="7" <?php if(in_array("7",$oasis_neuro_cognitive_symptoms)) echo "checked"; ?> ><?php xl(' 7 - None of the above behaviors demonstrated','e')?></label> <br>
			<br><hr />
			
			
			<strong><?php xl("<u>(M1745)</u>","e");?></strong>
			<?php xl("<strong>Frequency of Disruptive Behavior Symptoms (Reported or Observed)</strong> Any physical, verbal, or other disruptive/dangerous symptoms that are injurious to self or others or jeopardize personal safety.","e");?> 
			<br />
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="0" <?php if($obj{"oasis_neuro_frequency_disruptive"}=="0") echo "checked"; ?> ><?php xl(' 0 - Never','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="1" <?php if($obj{"oasis_neuro_frequency_disruptive"}=="1") echo "checked"; ?> ><?php xl(' 1 - Less than once a month','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="2" <?php if($obj{"oasis_neuro_frequency_disruptive"}=="2") echo "checked"; ?> ><?php xl(' 2 - Once a month','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="3" <?php if($obj{"oasis_neuro_frequency_disruptive"}=="3") echo "checked"; ?> ><?php xl(' 3 - Several times each month.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="4" <?php if($obj{"oasis_neuro_frequency_disruptive"}=="4") echo "checked"; ?> ><?php xl(' 4 - Several times a week.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="5" <?php if($obj{"oasis_neuro_frequency_disruptive"}=="5") echo "checked"; ?> ><?php xl(' 5 - At least daily','e')?></label> <br>
			<br>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">ADL/IADLs, Medications</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul id="adl_iadls">
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2"> 
			<center><strong><?php xl('ADL/IADLs','e')?></strong></center>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong><?php xl("<u>(M1800)</u>","e");?></strong>
			<?php xl("<strong>Grooming:</strong> Current ability to tend safely to personal hygiene needs (i.e., washing face and hands, hair care, shaving or make up, teeth or denture care, fingernail care).","e");?> 
			<br />
			<label><input type="radio" name="oasis_adl_grooming" value="0" <?php if($obj{"oasis_adl_grooming"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to groom self unaided, with or without the use of assistive devices or adapted methods.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_grooming" value="1" <?php if($obj{"oasis_adl_grooming"}=="1") echo "checked"; ?> ><?php xl(' 1 - Grooming utensils must be placed within reach before able to complete grooming activities.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_grooming" value="2" <?php if($obj{"oasis_adl_grooming"}=="2") echo "checked"; ?> ><?php xl(' 2 - Someone must assist the patient to groom self.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_grooming" value="3" <?php if($obj{"oasis_adl_grooming"}=="3") echo "checked"; ?> ><?php xl(' 3 - Patient depends entirely upon someone else for grooming needs.','e')?></label> <br>
			<br><hr />
			
			
			<strong><u><?php xl("(M1810) ","e");?></u></strong>
			<?php xl("Current ","e");?>
			<strong><?php xl(" Ability to Dress <u>Upper</u> Body ","e");?></strong> 
			<?php xl(" safely (with or without dressing aids) including undergarments, pullovers, front-opening shirts and blouses, managing zippers, buttons, and snaps:","e");?><br />
			<label><input type="radio" name="oasis_adl_dress_upper" value="0" <?php if($obj{"oasis_adl_dress_upper"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to get clothes out of closets and drawers, put them on and remove them from the  upper body without assistance. ','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_upper" value="1" <?php if($obj{"oasis_adl_dress_upper"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to dress upper body without assistance if clothing is laid out or handed to the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_upper" value="2" <?php if($obj{"oasis_adl_dress_upper"}=="2") echo "checked"; ?> ><?php xl(' 2 - Someone must help the patient put on upper body clothing.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_upper" value="3" <?php if($obj{"oasis_adl_dress_upper"}=="3") echo "checked"; ?> ><?php xl(' 3 - Patient depends entirely upon another person to dress the upper body.','e')?></label> <br>
			<br><hr />
			
			
			<strong><u><?php xl("(M1820) ","e");?></u></strong>
			<?php xl("Current ","e");?>
			<strong><?php xl("Ability to Dress <u>Lower</u> Body ","e");?></strong> 
			<?php xl(" safely (with or without dressing aids) including undergarments, slacks, socks or nylons, shoes:","e");?><br />
			<label><input type="radio" name="oasis_adl_dress_lower" value="0" <?php if($obj{"oasis_adl_dress_lower"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to obtain, put on, and remove clothing and shoes without assistance.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_lower" value="1" <?php if($obj{"oasis_adl_dress_lower"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to dress lower body without assistance if clothing and shoes are laid out or handed to the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_lower" value="2" <?php if($obj{"oasis_adl_dress_lower"}=="2") echo "checked"; ?> ><?php xl(' 2 - Someone must help the patient put on undergarments, slacks, socks or nylons, and shoes.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_lower" value="3" <?php if($obj{"oasis_adl_dress_lower"}=="3") echo "checked"; ?> ><?php xl(' 3 - Patient depends entirely upon another person to dress lower body.','e')?></label> <br>
			<br>
		</td>
		<td>
			<strong><?php xl("<u>(M1830)</u> Bathing: ","e");?></strong>
			<?php xl("Current ability to wash entire body safely. ","e");?>
			<strong><?php xl("<u>Excludes</u> grooming (washing face, washing hands, and shampooing hair). ","e");?></strong> <br />
			<label><input type="radio" name="oasis_adl_wash" value="0" <?php if($obj{"oasis_adl_wash"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to bathe self in <u>shower or tub</u> independently, including getting in and out of tub/shower.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="1" <?php if($obj{"oasis_adl_wash"}=="1") echo "checked"; ?> ><?php xl(' 1 - With the use of devices, is able to bathe self in shower or tub independently, including getting in and out of the tub/shower.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="2" <?php if($obj{"oasis_adl_wash"}=="2") echo "checked"; ?> ><?php xl(' 2 - Able to bathe in shower or tub with the intermittent assistance of another person:<br>
(a) for intermittent supervision or encouragement or reminders, <u>OR</u><br>
(b) to get in and out of the shower or tub, <u>OR</u><br>
(c) for washing difficult to reach areas.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="3" <?php if($obj{"oasis_adl_wash"}=="3") echo "checked"; ?> ><?php xl(' 3 - Able to participate in bathing self in shower or tub, <u>but</u> requires presence of another person throughout the bath for assistance or supervision.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="4" <?php if($obj{"oasis_adl_wash"}=="4") echo "checked"; ?> ><?php xl(' 4 - Unable to use the shower or tub, but able to bathe self independently with or without the use of devices at the sink, in chair, or on commode.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="5" <?php if($obj{"oasis_adl_wash"}=="5") echo "checked"; ?> ><?php xl(' 5 - Unable to use the shower or tub, but able to participate in bathing self in bed, at the sink, in bedside chair, or on commode, with the assistance or supervision of another person throughout the bath.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="6" <?php if($obj{"oasis_adl_wash"}=="6") echo "checked"; ?> ><?php xl(' 6 - Unable to participate effectively in bathing and is bathed totally by another person.','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1840)</u> Toilet Transferring: ","e");?></strong>
			<?php xl("Current ability to get to and from the toilet or bedside commode safely <u>and</u> transfer on and off toilet/commode. ","e");?><br />
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="0" <?php if($obj{"oasis_adl_toilet_transfer"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to get to and from the toilet and transfer independently with or without a device.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="1" <?php if($obj{"oasis_adl_toilet_transfer"}=="1") echo "checked"; ?> ><?php xl(' 1 - When reminded, assisted, or supervised by another person, able to get to and from the toilet and transfer.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="2" <?php if($obj{"oasis_adl_toilet_transfer"}=="2") echo "checked"; ?> ><?php xl(' 2 - <u>Unable</u> to get to and from the toilet but is able to use a bedside commode (with or without assistance).','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="3" <?php if($obj{"oasis_adl_toilet_transfer"}=="3") echo "checked"; ?> ><?php xl(' 3 - <u>Unable</u> to get to and from the toilet or bedside commode but is able to use a bedpan/urinal independently.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="4" <?php if($obj{"oasis_adl_toilet_transfer"}=="4") echo "checked"; ?> ><?php xl(' 4 - Is totally dependent in toileting.','e')?></label> <br>
			<br>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl("<u>(M1845)</u> Toileting Hygiene: ","e");?></strong>
			<?php xl("Current ability to maintain perineal hygiene safely, adjust clothes and/or incontinence pads before and after using toilet, commode, bedpan, urinal. If managing ostomy, includes cleaning area around stoma, but not managing equipment.","e");?><br />
			<label><input type="radio" name="oasis_adl_toileting_hygiene" value="0" <?php if($obj{"oasis_adl_toileting_hygiene"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to manage toileting hygiene and clothing management without assistance.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toileting_hygiene" value="1" <?php if($obj{"oasis_adl_toileting_hygiene"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to manage toileting hygiene and clothing management without assistance if supplies/implements are laid out for the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toileting_hygiene" value="2" <?php if($obj{"oasis_adl_toileting_hygiene"}=="2") echo "checked"; ?> ><?php xl(' 2 - Someone must help the patient to maintain toileting hygiene and/or adjust clothing.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toileting_hygiene" value="3" <?php if($obj{"oasis_adl_toileting_hygiene"}=="3") echo "checked"; ?> ><?php xl(' 3 - Patient depends entirely upon another person to maintain toileting hygiene.','e')?></label> <br>
			<br>
			<hr />
			<strong><?php xl("<u>(M1850)</u> Transferring: ","e");?></strong>
			<?php xl("Current ability to move safely from bed to chair, or ability to turn and position self in bed if patient is bedfast.","e");?><br />
			<label><input type="radio" name="oasis_adl_transferring" value="0" <?php if($obj{"oasis_adl_transferring"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to independently transfer.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="1" <?php if($obj{"oasis_adl_transferring"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to transfer with minimal human assistance or with use of an assistive device.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="2" <?php if($obj{"oasis_adl_transferring"}=="2") echo "checked"; ?> ><?php xl(' 2 - Able to bear weight and pivot during the transfer process but unable to transfer self.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="3" <?php if($obj{"oasis_adl_transferring"}=="3") echo "checked"; ?> ><?php xl(' 3 - Unable to transfer self and is unable to bear weight or pivot when transferred by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="4" <?php if($obj{"oasis_adl_transferring"}=="4") echo "checked"; ?> ><?php xl(' 4 - Bedfast, unable to transfer but is able to turn and position self in bed','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="5" <?php if($obj{"oasis_adl_transferring"}=="5") echo "checked"; ?> ><?php xl(' 5 - Bedfast, unable to transfer and is unable to turn and position self.','e')?></label>
			<br><hr />
			
			<strong><?php xl("<u>(M1860)</u> Ambulation/Locomotion: ","e");?></strong>
			<?php xl("Current ability to walk safely, once in a standing position, or use a wheelchair, once in a seated position, on a variety of surfaces.","e");?><br />
			<label><input type="radio" name="oasis_adl_ambulation" value="0" <?php if($obj{"oasis_adl_ambulation"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to independently walk on even and uneven surfaces and negotiate stairs with or without railings (i.e., needs no human assistance or assistive device).','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="1" <?php if($obj{"oasis_adl_ambulation"}=="1") echo "checked"; ?> ><?php xl(' 1 - With the use of a one-handed device (e.g. cane, single crutch, hemi-walker), able to independently walk on even and uneven surfaces and negotiate stairs with or without railings.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="2" <?php if($obj{"oasis_adl_ambulation"}=="2") echo "checked"; ?> ><?php xl(' 2 - Requires use of a two-handed device (e.g., walker or crutches) to walk alone on a level surface and/or requires human supervision or assistance to negotiate stairs or steps or uneven surfaces.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="3" <?php if($obj{"oasis_adl_ambulation"}=="3") echo "checked"; ?> ><?php xl(' 3 - Able to walk only with the supervision or assistance of another person at all times.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="4" <?php if($obj{"oasis_adl_ambulation"}=="4") echo "checked"; ?> ><?php xl(' 4 - Chairfast, <u>unable</u> to ambulate but is able to wheel self independently.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="5" <?php if($obj{"oasis_adl_ambulation"}=="5") echo "checked"; ?> ><?php xl(' 5 - Chairfast, unable to ambulate and is <u>unable</u> to wheel self.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="6" <?php if($obj{"oasis_adl_ambulation"}=="6") echo "checked"; ?> ><?php xl(' 6 - Bedfast, unable to ambulate or be up in a chair.','e')?></label> <br>
			<br /><hr />
			
			
			<strong><?php xl("<u>(M1870)</u> Feeding or Eating: ","e");?></strong>
			<?php xl("Current ability to feed self meals and snacks safely. Note: This refers only to the process of <u>eating</u>, <u>chewing</u>, and <u>swallowing</u>, <u>not preparing</u> the food to be eaten.","e");?><br />
			<label><input type="radio" name="oasis_adl_feeding_eating" value="0" <?php if($obj{"oasis_adl_feeding_eating"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to independently feed self.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="1" <?php if($obj{"oasis_adl_feeding_eating"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to feed self independently but requires:<br />
(a) meal set-up; <u>OR</u><br />
(b) intermittent assistance or supervision from another person; <u>OR</u><br />
(c) a liquid, pureed or ground meat diet.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="2" <?php if($obj{"oasis_adl_feeding_eating"}=="2") echo "checked"; ?> ><?php xl(' 2 - <u>Unable</u> to feed self and must be assisted or supervised throughout the meal/snack.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="3" <?php if($obj{"oasis_adl_feeding_eating"}=="3") echo "checked"; ?> ><?php xl(' 3 - Able to take in nutrients orally <u>and</u> receives supplemental nutrients through a nasogastric tube or gastrostomy','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="4" <?php if($obj{"oasis_adl_feeding_eating"}=="4") echo "checked"; ?> ><?php xl(' 4 - <u>Unable</u> to take in nutrients orally and is fed nutrients through a nasogastric tube or gastrostomy.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="5" <?php if($obj{"oasis_adl_feeding_eating"}=="5") echo "checked"; ?> ><?php xl(' 5 - Unable to take in nutrients orally or by tube feeding.','e')?></label> <br>
			<br>
			
			<hr>
			<strong><?php xl("<u>(M1880)</u>","e");?></strong>
			<?php xl("Current <strong>Ability to Plan and Prepare Light Meals</strong> (e.g., cereal, sandwich) or reheat delivered meals safely:","e");?><br />
			<label><input type="radio" name="oasis_adl_current_ability" value="0" <?php if($obj{"oasis_adl_current_ability"}=="0") echo "checked"; ?> ><?php xl(' 0 - (a) Able to independently plan and prepare all light meals for self or reheat delivered meals; <u>OR</u><br />
(b) Is physically, cognitively, and mentally able to prepare light meals on a regular basis but has not routinely performed light meal preparation in the past (i.e., prior to this home care admission).','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_current_ability" value="1" <?php if($obj{"oasis_adl_current_ability"}=="1") echo "checked"; ?> ><?php xl(' 1 - <u>Unable</u> to prepare light meals on a regular basis due to physical, cognitive, or mental limitations.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_current_ability" value="2" <?php if($obj{"oasis_adl_current_ability"}=="2") echo "checked"; ?> ><?php xl(' 2 - Unable to prepare any light meals or reheat any delivered meals.','e')?></label> <br>
			<br />
			
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1890)</u>","e");?></strong>
			<?php xl("<strong>Ability to Use Telephone:</strong> Current ability to answer the phone safely, including dialing numbers, and <u>effectively</u> using the telephone to communicate.","e");?><br />
			<label><input type="radio" name="oasis_adl_use_telephone" value="0" <?php if($obj{"oasis_adl_use_telephone"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to dial numbers and answer calls appropriately and as desired.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="1" <?php if($obj{"oasis_adl_use_telephone"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to use a specially adapted telephone (i.e., large numbers on the dial, teletype phone for the deaf) and call essential numbers.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="2" <?php if($obj{"oasis_adl_use_telephone"}=="2") echo "checked"; ?> ><?php xl(' 2 - Able to answer the telephone and carry on a normal conversation but has difficulty with placing calls.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="3" <?php if($obj{"oasis_adl_use_telephone"}=="3") echo "checked"; ?> ><?php xl(' 3 - Able to answer the telephone only some of the time or is able to carry on only a limited conversation.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="4" <?php if($obj{"oasis_adl_use_telephone"}=="4") echo "checked"; ?> ><?php xl(' 4 - <u>Unable</u> to answer the telephone at all but can listen if assisted with equipment.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="5" <?php if($obj{"oasis_adl_use_telephone"}=="5") echo "checked"; ?> ><?php xl(' 5 - Totally unable to use the telephone.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="NA" <?php if($obj{"oasis_adl_use_telephone"}=="NA") echo "checked"; ?> ><?php xl(' NA - Patient does not have a telephone.','e')?></label> <br>
			<br />
			
			<hr>
			<center><strong><?php xl('MEDICATIONS','e')?></strong></center>
			<strong><?php xl("<u>(M2004)</u>","e");?></strong>
			<?php xl("<strong>Medication Intervention: </strong> If there were any clinically significant medication issues since the previous OASIS assessment, was a physician or the physician-designee contacted within one calendar day of the assessment to resolve clinically significant medication issues, including reconciliation?","e");?><br />
			<label><input type="radio" id="m2004" name="oasis_medication_intervention" value="0" <?php if($obj{"oasis_medication_intervention"}=="0") echo "checked"; ?> ><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_intervention" value="1" <?php if($obj{"oasis_medication_intervention"}=="1") echo "checked"; ?> ><?php xl(' 1 - Yes','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_intervention" value="NA" <?php if($obj{"oasis_medication_intervention"}=="NA") echo "checked"; ?> ><?php xl(' NA - No clinically significant medication issues identified since the previous OASIS assessment','e')?></label> <br>
			
			<br />
			
			<hr>
			<strong><?php xl("<u>(M2015)</u>","e");?></strong>
			<?php xl("<strong>Patient/Caregiver Drug Education Intervention: </strong> Since the previous OASIS assessment, was the patient/caregiver instructed by agency staff or other health care provider to monitor the effectiveness of drug therapy, drug reactions, and side effects, and how and when to report problems that may occur?","e");?><br />
			<label><input type="radio" name="oasis_medication_drug_education" value="0" <?php if($obj{"oasis_medication_drug_education"}=="0") echo "checked"; ?> ><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_drug_education" value="1" <?php if($obj{"oasis_medication_drug_education"}=="1") echo "checked"; ?> ><?php xl(' 1 - Yes','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_drug_education" value="NA" <?php if($obj{"oasis_medication_drug_education"}=="NA") echo "checked"; ?> ><?php xl(' NA - Patient not taking any drugs','e')?></label> <br>
			
			<br />
			<hr>
			<strong><?php xl("<u>(M2020)</u>","e");?></strong>
			<?php xl("<strong>Management of Oral Medications: </strong> <u>Patient's current ability</u> to prepare and take <u>all</u> oral medications reliably and safely, including administration of the correct dosage at the appropriate times/intervals. <b><u>Excludes</u> injectable and IV medications. (NOTE: This refers to ability, not compliance or willingness.)</b>","e");?><br />
			<label><input type="radio" name="oasis_medication_oral" value="0" <?php if($obj{"oasis_medication_oral"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to independently take the correct oral medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_oral" value="1" <?php if($obj{"oasis_medication_oral"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to take medication(s) at the correct times if:<br>
&nbsp;&nbsp;&nbsp;(a) individual dosages are prepared in advance by another person; <u>OR</u><br>
&nbsp;&nbsp;&nbsp;(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_oral" value="2" <?php if($obj{"oasis_medication_oral"}=="2") echo "checked"; ?> ><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person at the appropriate times','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_oral" value="3" <?php if($obj{"oasis_medication_oral"}=="3") echo "checked"; ?> ><?php xl(' 3 - <u>Unable</u> to take medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_oral" value="NA" <?php if($obj{"oasis_medication_oral"}=="NA") echo "checked"; ?> ><?php xl(' NA - No oral medications prescribed.','e')?></label> <br>
			
			<br />
			<hr>
			<strong><?php xl("<u>(M2030)</u>","e");?></strong>
			<?php xl("<strong>Management of Injectable Medications: </strong> <u>Patient's current ability</u> to prepare and take <u>all</u> prescribed injectable medications reliably and safely, including administration of correct dosage at the appropriate times/intervals. <b><u>Excludes</u> IV medications.</b>","e");?><br />
			<label><input type="radio" name="oasis_medication_injectable" value="0" <?php if($obj{"oasis_medication_injectable"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to independently take the correct medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_injectable" value="1" <?php if($obj{"oasis_medication_injectable"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to take injectable medication(s) at the correct times if:<br>
&nbsp;&nbsp;&nbsp;(a) individual syringes are prepared in advance by another person; <u>OR</u><br>
&nbsp;&nbsp;&nbsp;(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_injectable" value="2" <?php if($obj{"oasis_medication_injectable"}=="2") echo "checked"; ?> ><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person based on the frequency of the injection','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_injectable" value="3" <?php if($obj{"oasis_medication_injectable"}=="3") echo "checked"; ?> ><?php xl(' 3 - <u>Unable</u> to take injectable medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_injectable" value="NA" <?php if($obj{"oasis_medication_injectable"}=="NA") echo "checked"; ?> ><?php xl(' NA - No injectable medications prescribed.','e')?></label> <br>
			
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Care Management, Emergent Care, Data items collected</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul id="care_management">
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2"> 
			<center><strong><?php xl('CARE MANAGEMENT','e')?></strong></center>
			<table class="formtable" width="100%" border="1">
<tr>
		<td colspan="8">
		<strong><?php xl("<u>(M2100)</u>","e");?></strong>
			<?php xl("<strong> Types and Source of Assistance:</strong> Determine the level of caregiver ability and willingness to provide assistance for the following activities, if assistance is needed. (Check only <b><u>one</u></b> box in each row.)","e");?><br />
		</td>
		
</tr>

<tr align="center">
<td colspan="2">
<strong><?php xl("Type of Assistance","e");?></strong>
</td>
<td>
<strong><?php xl("No assistance needed in this area","e");?></strong>
</td>
<td>
<strong><?php xl("Caregiver(s) currently provide assistance","e");?></strong>
</td>
<td>
<strong><?php xl("Caregiver(s) need training/ supportive services to provide assistance","e");?></strong>
</td>
<td>
<strong><?php xl("Caregiver(s) <u>not likely</u> to provide assistance","e");?></strong>
</td>
<td>
<strong><?php xl("Unclear if Caregiver(s) will provide assistance","e");?></strong>
</td>
<td>
<strong><?php xl("Assistance needed, but no Caregiver(s) available","e");?></strong>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("a.","e");?>
</td>
<td>
<?php xl("<strong>ADL assistance</strong> (e.g., transfer/ ambulation, bathing, dressing, toileting, eating/feeding)","e");?>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="0" <?php if($obj{"oasis_care_adl_assistance"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="1" <?php if($obj{"oasis_care_adl_assistance"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="2" <?php if($obj{"oasis_care_adl_assistance"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="3" <?php if($obj{"oasis_care_adl_assistance"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="4" <?php if($obj{"oasis_care_adl_assistance"}=="4") echo "checked"; ?> ><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="5" <?php if($obj{"oasis_care_adl_assistance"}=="5") echo "checked"; ?> ><?php xl(' 5','e')?></label> <br>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("b.","e");?>
</td>
<td>
<?php xl("<strong>IADL assistance</strong> (e.g., meals, housekeeping, laundry, telephone, shopping, finances)","e");?>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="0" <?php if($obj{"oasis_care_iadl_assistance"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="1" <?php if($obj{"oasis_care_iadl_assistance"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="2" <?php if($obj{"oasis_care_iadl_assistance"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="3" <?php if($obj{"oasis_care_iadl_assistance"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="4" <?php if($obj{"oasis_care_iadl_assistance"}=="4") echo "checked"; ?> ><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="5" <?php if($obj{"oasis_care_iadl_assistance"}=="5") echo "checked"; ?> ><?php xl(' 5','e')?></label> <br>
</td>
</tr>


<tr>
<td valign="top">
<?php xl("c.","e");?>
</td>
<td>
<?php xl("<strong>Medication administration</strong> (e.g., oral, inhaled or injectable)","e");?>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="0" <?php if($obj{"oasis_care_medication_admin"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="1" <?php if($obj{"oasis_care_medication_admin"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="2" <?php if($obj{"oasis_care_medication_admin"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="3" <?php if($obj{"oasis_care_medication_admin"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="4" <?php if($obj{"oasis_care_medication_admin"}=="4") echo "checked"; ?> ><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="5" <?php if($obj{"oasis_care_medication_admin"}=="5") echo "checked"; ?> ><?php xl(' 5','e')?></label> <br>
</td>
</tr>


<tr>
<td valign="top">
<?php xl("d.","e");?>
</td>
<td>
<?php xl("<strong>Medical procedures/ treatments</strong> (e.g., changing wound dressing)","e");?>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="0" <?php if($obj{"oasis_care_medical_procedures"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="1" <?php if($obj{"oasis_care_medical_procedures"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="2" <?php if($obj{"oasis_care_medical_procedures"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="3" <?php if($obj{"oasis_care_medical_procedures"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="4" <?php if($obj{"oasis_care_medical_procedures"}=="4") echo "checked"; ?> ><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="5" <?php if($obj{"oasis_care_medical_procedures"}=="5") echo "checked"; ?> ><?php xl(' 5','e')?></label> <br>
</td>
</tr>


<tr>
<td valign="top">
<?php xl("e.","e");?>
</td>
<td>
<?php xl("<strong>Management of Equipment</strong> (includes oxygen, IV/infusion equipment, enteral/ parenteral nutrition, ventilator therapy equipment or supplies)","e");?>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="0" <?php if($obj{"oasis_care_management_equip"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="1" <?php if($obj{"oasis_care_management_equip"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="2" <?php if($obj{"oasis_care_management_equip"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="3" <?php if($obj{"oasis_care_management_equip"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="4" <?php if($obj{"oasis_care_management_equip"}=="4") echo "checked"; ?> ><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="5" <?php if($obj{"oasis_care_management_equip"}=="5") echo "checked"; ?> ><?php xl(' 5','e')?></label> <br>
</td>
</tr>


<tr>
<td valign="top">
<?php xl("f.","e");?>
</td>
<td>
<?php xl("<strong>Supervision and safety</strong> (e.g., due to cognitive impairment)","e");?>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="0" <?php if($obj{"oasis_care_supervision_safety"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="1" <?php if($obj{"oasis_care_supervision_safety"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="2" <?php if($obj{"oasis_care_supervision_safety"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="3" <?php if($obj{"oasis_care_supervision_safety"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="4" <?php if($obj{"oasis_care_supervision_safety"}=="4") echo "checked"; ?> ><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="5" <?php if($obj{"oasis_care_supervision_safety"}=="5") echo "checked"; ?> ><?php xl(' 5','e')?></label> <br>
</td>
</tr>


<tr>
<td valign="top">
<?php xl("g.","e");?>
</td>
<td>
<?php xl("<strong>Advocacy or facilitation</strong> of patient's participation in appropriate medical care (includes transportation to or from appointments).","e");?>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="0" <?php if($obj{"oasis_care_advocacy_facilitation"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="1" <?php if($obj{"oasis_care_advocacy_facilitation"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="2" <?php if($obj{"oasis_care_advocacy_facilitation"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="3" <?php if($obj{"oasis_care_advocacy_facilitation"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="4" <?php if($obj{"oasis_care_advocacy_facilitation"}=="4") echo "checked"; ?> ><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="5" <?php if($obj{"oasis_care_advocacy_facilitation"}=="5") echo "checked"; ?> ><?php xl(' 5','e')?></label> <br>
</td>
</tr>
</table>
			<br>
			<hr>
			<strong><?php xl("<u>(M2110)</u>","e");?></strong>
			<?php xl("<strong>How Often </strong> does the patient receive <strong>ADL or IADL assistance</strong> from any caregiver(s) (other than home health agency staff)?","e");?><br />
			<label><input type="radio" name="oasis_care_how_often" value="1" <?php if($obj{"oasis_care_how_often"}=="1") echo "checked"; ?> ><?php xl(' 1 - At least daily','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="2" <?php if($obj{"oasis_care_how_often"}=="2") echo "checked"; ?> ><?php xl(' 2 - Three or more times per week','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="3" <?php if($obj{"oasis_care_how_often"}=="3") echo "checked"; ?> ><?php xl(' 3 - One to two times per week','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="4" <?php if($obj{"oasis_care_how_often"}=="4") echo "checked"; ?> ><?php xl(' 4 - Received, but less often than weekly','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="5" <?php if($obj{"oasis_care_how_often"}=="5") echo "checked"; ?> ><?php xl(' 5 - No assistance received','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="UK" <?php if($obj{"oasis_care_how_often"}=="UK") echo "checked"; ?> ><?php xl(' UK - Unknown <b><i>[Omit "UK" option on DC]</i></b>','e')?></label> <br>
			<br />
			<hr>
			<center><strong><?php xl('EMERGENT CARE','e')?></strong></center>
			<strong><?php xl("<u>(M2300)</u>","e");?></strong>
			<?php xl("<strong>Emergent Care: </strong> Since the last time OASIS data were collected, has the patient utilized a hospital emergency department (includes holding/observation)?","e");?><br />
			<label><input type="radio" name="oasis_emergent_care" value="0" <?php if($obj{"oasis_emergent_care"}=="0") echo "checked"; ?> ><?php xl(' 0 - No <b><i>[ Go to M2400 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_emergent_care" value="1" <?php if($obj{"oasis_emergent_care"}=="1") echo "checked"; ?> ><?php xl(' 1 - Yes, used hospital emergency department WITHOUT hospital admission','e')?></label> <br>
			<label><input type="radio" name="oasis_emergent_care" value="2" <?php if($obj{"oasis_emergent_care"}=="2") echo "checked"; ?> ><?php xl(' 2 - Yes, used hospital emergency department WITH hospital admission','e')?></label> <br>
			<label><input type="radio" name="oasis_emergent_care" value="NA" <?php if($obj{"oasis_emergent_care"}=="NA") echo "checked"; ?> ><?php xl(' UK - Unknown <b><i>[ Go to M2400 ]</i></b>','e')?></label> <br>
			<br />
			<hr>
			<strong><?php xl("<u>(M2310)</u>","e");?></strong>
			<?php xl("<strong>Reason for Emergent Care: </strong> For what reason(s) did the patient receive emergent care (with or without hospitalization)? <b>(Mark all that apply.)</b>","e");?><br />
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="1" <?php if(in_array("1",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 1 - Improper medication administration, medication side effects, toxicity, anaphylaxis','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="2" <?php if(in_array("2",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 2 - Injury caused by fall','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="3" <?php if(in_array("3",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 3 - Respiratory infection (e.g., pneumonia, bronchitis)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="4" <?php if(in_array("4",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 4 - Other respiratory problem','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="5" <?php if(in_array("5",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 5 - Heart failure (e.g., fluid overload)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="6" <?php if(in_array("6",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 6 - Cardiac dysrhythmia (irregular heartbeat)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="7" <?php if(in_array("7",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 7 - Myocardial infarction or chest pain','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="8" <?php if(in_array("8",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 8 - Other heart disease','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="9" <?php if(in_array("9",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 9 - Stroke (CVA) or TIA','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="10" <?php if(in_array("10",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 10 - Hypo/Hyperglycemia, diabetes out of control','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="11" <?php if(in_array("11",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 11 - GI bleeding, obstruction, constipation, impaction','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="12" <?php if(in_array("12",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 12 - Dehydration, malnutrition','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="13" <?php if(in_array("13",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 13 - Urinary tract infection','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="14" <?php if(in_array("14",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 14 - IV catheter-related infection or complication','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="15" <?php if(in_array("15",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 15 - Wound infection or deterioration','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="16" <?php if(in_array("16",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 16 - Uncontrolled pain','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="17" <?php if(in_array("17",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 17 - Acute mental/behavioral health problem','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="18" <?php if(in_array("18",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 18 - Deep vein thrombosis, pulmonary embolus','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="19" <?php if(in_array("19",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' 19 - Other than above reasons','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="UK" <?php if(in_array("UK",$oasis_emergent_care_reason)) echo "checked"; ?> ><?php xl(' UK - Reason unknown','e')?></label> <br>
			<br />
			<hr>
			<center><strong><?php xl('DATA ITEMS COLLECTED','e')?></strong></center>
			 <table class="formtable" width="100%" border="1px">
				<tr>
					<td colspan="6">
						<strong><?php xl("<u>(M2400)</u>","e");?></strong>
						<?php xl("<strong>Intervention Synopsis: </strong> (Check only <b><u>one</u></b> box in each row.) Since the previous OASIS assessment, were the following interventions BOTH included in the physician-ordered plan of care AND implemented?","e");?><br />
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<strong><?php xl("Plan/Intervention","e");?></strong>
					</td>
					<td align="center" width="30px">
						<strong><?php xl("No","e");?></strong>
					</td>
					<td align="center" width="30px">
						<strong><?php xl("Yes","e");?></strong>
					</td>
					<td colspan="2">
						<strong><?php xl("Not Applicable","e");?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("a.","e");?>
					</td>
					<td>
						<?php xl("Diabetic foot care including monitoring for the presence of skin lesions on the lower extremities and patient/caregiver education on proper foot care","e");?>
					</td>
					<td>
						<label><input type="radio" id="m2400" name="oasis_data_items_a" value="0" <?php if($obj{"oasis_data_items_a"}=="0") echo "checked"; ?> >0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_a" value="1" <?php if($obj{"oasis_data_items_a"}=="1") echo "checked"; ?> >1</label>
					</td>
					<td width="40px">
						<label><input type="radio" name="oasis_data_items_a" value="na" <?php if($obj{"oasis_data_items_a"}=="na") echo "checked"; ?> >na</label>
					</td>
					<td>
						<?php xl("Patient is not diabetic or is bilateral amputee","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("b.","e");?>
					</td>
					<td>
						<?php xl("Falls prevention interventions","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_b" value="0" <?php if($obj{"oasis_data_items_b"}=="0") echo "checked"; ?> >0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_b" value="1" <?php if($obj{"oasis_data_items_b"}=="1") echo "checked"; ?> >1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_b" value="na" <?php if($obj{"oasis_data_items_b"}=="na") echo "checked"; ?> >na</label>
					</td>
					<td>
						<?php xl("Formal multi-factor Fall Risk Assessment indicates the patient was not at risk for falls since the last OASIS assessment","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("c.","e");?>
					</td>
					<td>
						<?php xl("Depression intervention(s) such as medication, referral for other treatment, or a monitoring plan for current treatment","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_c" value="0" <?php if($obj{"oasis_data_items_c"}=="0") echo "checked"; ?> >0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_c" value="1" <?php if($obj{"oasis_data_items_c"}=="1") echo "checked"; ?> >1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_c" value="na" <?php if($obj{"oasis_data_items_c"}=="na") echo "checked"; ?> >na</label>
					</td>
					<td>
						<?php xl("Formal assessment indicates patient did not meet criteria for depression AND patient did not have diagnosis of depression since the last OASIS assessment","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("d.","e");?>
					</td>
					<td>
						<?php xl("Intervention(s) to monitor and mitigate pain","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_d" value="0" <?php if($obj{"oasis_data_items_d"}=="0") echo "checked"; ?> >0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_d" value="1" <?php if($obj{"oasis_data_items_d"}=="1") echo "checked"; ?> >1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_d" value="na" <?php if($obj{"oasis_data_items_d"}=="na") echo "checked"; ?> >na</label>
					</td>
					<td>
						<?php xl("Formal assessment did not indicate pain since the last OASIS assessment","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("e.","e");?>
					</td>
					<td>
						<?php xl("Intervention(s) to prevent pressure ulcers","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_e" value="0" <?php if($obj{"oasis_data_items_e"}=="0") echo "checked"; ?> >0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_e" value="1" <?php if($obj{"oasis_data_items_e"}=="1") echo "checked"; ?> >1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_e" value="na" <?php if($obj{"oasis_data_items_e"}=="na") echo "checked"; ?> >na</label>
					</td>
					<td>
						<?php xl("Formal assessment indicates the patient was not at risk of pressure ulcers since the last OASIS assessment","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("f.","e");?>
					</td>
					<td>
						<?php xl("Pressure ulcer treatment based on principles of moist wound healing","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_f" value="0" <?php if($obj{"oasis_data_items_f"}=="0") echo "checked"; ?> >0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_f" value="1" <?php if($obj{"oasis_data_items_f"}=="1") echo "checked"; ?> >1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_f" value="na" <?php if($obj{"oasis_data_items_f"}=="na") echo "checked"; ?> >na</label>
					</td>
					<td>
						<?php xl("Dressings that support the principles of moist wound healing not indicated for this patient's pressure ulcers OR patient has no pressure ulcers with need for moist wound healing","e");?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong><?php xl("<u>(M2410)</u>","e");?></strong>
			<?php xl("To which <strong>Inpatient Facility </strong> has the patient been admitted?","e");?><br />
			<label><input type="radio" name="oasis_inpatient_facility" value="1" <?php if($obj{"oasis_inpatient_facility"}=="1") echo "checked"; ?> ><?php xl(' 1 - Hospital <b><i>[ Go to M2430 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_inpatient_facility" value="2" <?php if($obj{"oasis_inpatient_facility"}=="2") echo "checked"; ?> ><?php xl(' 2 - Rehabilitation facility <b><i>[ Go to M0903 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_inpatient_facility" value="3" <?php if($obj{"oasis_inpatient_facility"}=="3") echo "checked"; ?> ><?php xl(' 3 - Nursing home <b><i>[ Go to M2440 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_inpatient_facility" value="4" <?php if($obj{"oasis_inpatient_facility"}=="4") echo "checked"; ?> ><?php xl(' 4 - Hospice <b><i>[ Go to M0903 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_inpatient_facility" value="NA" <?php if($obj{"oasis_inpatient_facility"}=="NA") echo "checked"; ?> ><?php xl(' NA - No inpatient facility admission <b><i>[Omit "NA" option on TRN]</i></b>','e')?></label> <br>
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M2420)</u>","e");?></strong>
			<?php xl("<strong>Discharge Disposition: </strong> Where is the patient after discharge from your agency? <b>(Choose only one answer.)</b>","e");?><br />
			<label><input type="radio" name="oasis_discharge_disposition" value="1" <?php if($obj{"oasis_discharge_disposition"}=="1") echo "checked"; ?> ><?php xl(' 1 - Patient remained in the community (without formal assistive services)','e')?></label> <br>
			<label><input type="radio" name="oasis_discharge_disposition" value="2" <?php if($obj{"oasis_discharge_disposition"}=="2") echo "checked"; ?> ><?php xl(' 2 - Patient remained in the community (with formal assistive services)','e')?></label> <br>
			<label><input type="radio" name="oasis_discharge_disposition" value="3" <?php if($obj{"oasis_discharge_disposition"}=="3") echo "checked"; ?> ><?php xl(' 3 - Patient transferred to a non-institutional hospice','e')?></label> <br>
			<label><input type="radio" name="oasis_discharge_disposition" value="4" <?php if($obj{"oasis_discharge_disposition"}=="4") echo "checked"; ?> ><?php xl(' 4 - Unknown because patient moved to a geographic location not served by this agency','e')?></label> <br>
			<label><input type="radio" name="oasis_discharge_disposition" value="UK" <?php if($obj{"oasis_discharge_disposition"}=="UK") echo "checked"; ?> ><?php xl(' UK - Other unknown <b><i>[ Go to M0903 ]</i></b>','e')?></label> <br>
		</td>
	</tr>

	<tr>
<td valign="top"><strong>
<?php xl("(M2430)","e");?></strong><strong><?php xl(" Reason for Hospitalization:","e");?></strong><?php xl(" For what reason(s) did the patient require hospitalization? ","e");?><strong><?php xl("(Mark all that apply.)","e");?></strong><br>
<input type="checkbox" id="m2430" name="Reason_for_Hospitalization[]" value="Improper medication administration, medication side effects, toxicity, anaphylaxis" <?php if(in_array("Improper medication administration, medication side effects, toxicity, anaphylaxis",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("1 - Improper medication administration, medication side effects, toxicity, anaphylaxis","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Injury caused by fall" <?php if(in_array("Injury caused by fall",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("2 - Injury caused by fall","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Respiratory infection (e.g., pneumonia, bronchitis)" <?php if(in_array("Respiratory infection (e.g., pneumonia, bronchitis)",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("3 - Respiratory infection (e.g., pneumonia, bronchitis)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other respiratory problem" <?php if(in_array("Other respiratory problem",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("4 - Other respiratory problem","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Heart failure (e.g., fluid overload)" <?php if(in_array("Heart failure (e.g., fluid overload)",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("5 - Heart failure (e.g., fluid overload)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Cardiac dysrhythmia (irregular heartbeat)" <?php if(in_array("Cardiac dysrhythmia (irregular heartbeat)",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("6 - Cardiac dysrhythmia (irregular heartbeat)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Myocardial infarction or chest pain" <?php if(in_array("Myocardial infarction or chest pain",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("7 - Myocardial infarction or chest pain","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other heart disease" <?php if(in_array("Other heart disease",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("8 - Other heart disease","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Stroke (CVA) or TIA" <?php if(in_array("Stroke (CVA) or TIA",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("9 - Stroke (CVA) or TIA","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Hypo/Hyperglycemia, diabetes out of control" <?php if(in_array("Hypo/Hyperglycemia, diabetes out of control",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("10 - Hypo/Hyperglycemia, diabetes out of control","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="GI bleeding, obstruction, constipation, impaction" <?php if(in_array("GI bleeding, obstruction, constipation, impaction",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("11 - GI bleeding, obstruction, constipation, impaction","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Dehydration, malnutrition" <?php if(in_array("Dehydration, malnutrition",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("12 - Dehydration, malnutrition","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Urinary tract infection" <?php if(in_array("Urinary tract infection",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("13 - Urinary tract infection","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="IV catheter-related infection or complication" <?php if(in_array("IV catheter-related infection or complication",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("14 - IV catheter-related infection or complication","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Wound infection or deterioration" <?php if(in_array("Wound infection or deterioration",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("15 - Wound infection or deterioration","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Uncontrolled pain" <?php if(in_array("Uncontrolled pain",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("16 - Uncontrolled pain","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Acute mental/behavioral health problem" <?php if(in_array("Acute mental/behavioral health problem",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("17 - Acute mental/behavioral health problem","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Deep vein thrombosis, pulmonary embolus" <?php if(in_array("Deep vein thrombosis, pulmonary embolus",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("18 - Deep vein thrombosis, pulmonary embolus","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Scheduled treatment or procedure" <?php if(in_array("Scheduled treatment or procedure",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("19 - Scheduled treatment or procedure","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other than above reasons" <?php if(in_array("Other than above reasons",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("20 - Other than above reasons","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="UK - Reason unknown" <?php if(in_array("UK - Reason unknown",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("UK - Reason unknown","e");?>
<strong><i><?php xl("[ Go to M0903 ]","e");?></i></strong>
</td>
<td valign="top"><strong>
<?php xl("(M2440)","e");?></strong><?php xl(" For what ","e");?><strong><?php xl("Reason(s)","e");?></strong><?php xl(" was the patient ","e");?><strong><?php xl("Admitted","e");?></strong><?php xl(" to a ","e");?><strong><?php xl("Nursing Home? (Mark all that apply.)","e");?></strong><br>
<input type="checkbox" id="m2440" name="patient_Admitted_to_a_Nursing_Home[]" value="Therapy services" <?php if(in_array("Therapy services",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("1 - Therapy services","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Respite care" <?php if(in_array("Respite care",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("2 - Respite care","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Hospice care" <?php if(in_array("Hospice care",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("3 - Hospice care","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Permanent placement"<?php if(in_array("Permanent placement",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("4 - Permanent placement","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Unsafe for care at home"<?php if(in_array("Unsafe for care at home",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("5 - Unsafe for care at home","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Other" <?php if(in_array("Other",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("6 - Other","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Unknown" <?php if(in_array("Unknown",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("UK - Unknown","e");?>
<strong><i><?php xl("[ Go to M0903 ]","e");?></i></strong>
</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Infusion</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2"> 
			<center><strong><?php xl('INFUSION','e')?></strong></center>
		</td>
	</tr>
	<tr>
		<td>
			<!--For Infusion-->
			<label><input type="checkbox" name="non_oasis_infusion[]" value="Peripheral: (specify)"  id="non_oasis_infusion" 
<?php if(in_array("Peripheral: (specify)",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Peripheral: (specify)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_peripheral" id="non_oasis_infusion_peripheral" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_peripheral"});?>" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="PICC: (specify, size, brand)"  id="non_oasis_infusion" 
<?php if(in_array("PICC: (specify, size, brand)",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('PICC: (specify, size, brand)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_PICC" id="non_oasis_infusion_PICC" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_PICC"});?>" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Central"  id="non_oasis_infusion" 
<?php if(in_array("Central",$non_oasis_infusion)) echo "checked"; ?> /><?php xl('Central','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Midline/Midclavicular"  id="non_oasis_infusion" 
<?php if(in_array("Midline/Midclavicular",$non_oasis_infusion)) echo "checked"; ?> /><?php xl('Midline/Midclavicular','e')?></label><br />
&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Single lumen"  id="non_oasis_infusion_central" 
<?php if($obj{"non_oasis_infusion_central"}=="Single lumen") echo "checked"; ?> />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Double lumen"  id="non_oasis_infusion_central" 
<?php if($obj{"non_oasis_infusion_central"}=="Double lumen") echo "checked"; ?> />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Triple lumen"  id="non_oasis_infusion_central" 
<?php if($obj{"non_oasis_infusion_central"}=="Triple lumen") echo "checked"; ?> />
<?php xl('Triple lumen','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;

<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_central_date' id='non_oasis_infusion_central_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly 
value="<?php echo stripslashes($obj{"non_oasis_infusion_central_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date8' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_central_date", ifFormat:"%Y-%m-%d", button:"img_curr_date8"});
                        </script>
<br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="X-ray verification:"  id="non_oasis_infusion" 
<?php if(in_array("X-ray verification:",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('X-ray verification:','e')?></strong></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_xray" value="Yes"  id="non_oasis_infusion_xray" 
<?php if($obj{"non_oasis_infusion_xray"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_xray" value="No"  id="non_oasis_infusion_xray" 
<?php if($obj{"non_oasis_infusion_xray"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;

<br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Mid arm circumference in/cm"  id="non_oasis_infusion" 
<?php if(in_array("Mid arm circumference in/cm",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Mid arm circumference in/cm','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_circum" id="non_oasis_infusion_circum" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_circum"});?>" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="External catheter length in/cm"  id="non_oasis_infusion" 
<?php if(in_array("External catheter length in/cm",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('External catheter length in/cm','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_length" id="non_oasis_infusion_length" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_length"});?>" /><br />
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Hickman"  id="non_oasis_infusion" 
<?php if(in_array("Hickman",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Hickman','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Broviac"  id="non_oasis_infusion" 
<?php if(in_array("Broviac",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Broviac','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Groshong"  id="non_oasis_infusion" 
<?php if(in_array("Groshong",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Groshong','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Jugular"  id="non_oasis_infusion" 
<?php if(in_array("Jugular",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Jugular','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Subclavian"  id="non_oasis_infusion" 
<?php if(in_array("Subclavian",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Subclavian','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
<label><input type="radio" name="non_oasis_infusion_hickman" value="Single lumen"  id="non_oasis_infusion_hickman" 
<?php if($obj{"non_oasis_infusion_hickman"}=="Single lumen") echo "checked"; ?> />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_hickman" value="Double lumen"  id="non_oasis_infusion_hickman" 
<?php if($obj{"non_oasis_infusion_hickman"}=="Double lumen") echo "checked"; ?> />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_hickman" value="Triple lumen"  id="non_oasis_infusion_hickman" 
<?php if($obj{"non_oasis_infusion_hickman"}=="Triple lumen") echo "checked"; ?> />
<?php xl('Triple lumen','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_hickman_date' id='non_oasis_infusion_hickman_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_infusion_hickman_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date9' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_hickman_date", ifFormat:"%Y-%m-%d", button:"img_curr_date9"});
                        </script>
<br />



<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Epidural catheter"  id="non_oasis_infusion" 
<?php if(in_array("Epidural catheter",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Epidural catheter','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Tunneled"  id="non_oasis_infusion" 
<?php if(in_array("Tunneled",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Tunneled','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Port1"  id="non_oasis_infusion" 
<?php if(in_array("Port1",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Port','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_epidural_date' id='non_oasis_infusion_epidural_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_infusion_epidural_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date10' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_epidural_date", ifFormat:"%Y-%m-%d", button:"img_curr_date10"});
                        </script>
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Implanted VAD"  id="non_oasis_infusion" 
<?php if(in_array("Implanted VAD",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Implanted VAD','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Venous"  id="non_oasis_infusion" 
<?php if(in_array("Venous",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Venous','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Arterial"  id="non_oasis_infusion" 
<?php if(in_array("Arterial",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Arterial','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Peritoneal"  id="non_oasis_infusion" 
<?php if(in_array("Peritoneal",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Peritoneal','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_implanted_date' id='non_oasis_infusion_implanted_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_infusion_implanted_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date11' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_implanted_date", ifFormat:"%Y-%m-%d", button:"img_curr_date11"});
                        </script>
<br />



<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Intrathecal"  id="non_oasis_infusion" 
<?php if(in_array("Intrathecal",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Intrathecal','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Port2"  id="non_oasis_infusion" 
<?php if(in_array("Port2",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Port','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Reservoir"  id="non_oasis_infusion" 
<?php if(in_array("Reservoir",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Reservoir','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_intrathecal_date' id='non_oasis_infusion_intrathecal_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_infusion_intrathecal_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date12' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_intrathecal_date", ifFormat:"%Y-%m-%d", button:"img_curr_date12"});
                        </script>
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered1"  id="non_oasis_infusion" 
<?php if(in_array("Medication administered1",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med1_admin" id="non_oasis_infusion_med1_admin" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_admin"});?>" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_name" id="non_oasis_infusion_med1_name" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_name"});?>" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_dose" id="non_oasis_infusion_med1_dose" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_dose"});?>" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_dilution" id="non_oasis_infusion_med1_dilution" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_dilution"});?>" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_route" id="non_oasis_infusion_med1_route" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_route"});?>" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_frequency" id="non_oasis_infusion_med1_frequency" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_frequency"});?>" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_duration" id="non_oasis_infusion_med1_duration" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_duration"});?>" />
</label>



<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered2"  id="non_oasis_infusion" 
<?php if(in_array("Medication administered2",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med2_admin" id="non_oasis_infusion_med2_admin" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_admin"});?>" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_name" id="non_oasis_infusion_med2_name" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_name"});?>" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_dose" id="non_oasis_infusion_med2_dose" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_dose"});?>" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_dilution" id="non_oasis_infusion_med2_dilution" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_dilution"});?>" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_route" id="non_oasis_infusion_med2_route" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_route"});?>" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_frequency" id="non_oasis_infusion_med2_frequency" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_frequency"});?>" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_duration" id="non_oasis_infusion_med2_duration" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_duration"});?>" />
</label>


<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered3"  id="non_oasis_infusion" 
<?php if(in_array("Medication administered3",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med3_admin" id="non_oasis_infusion_med3_admin" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_admin"});?>" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_name" id="non_oasis_infusion_med3_name" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_name"});?>" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_dose" id="non_oasis_infusion_med3_dose" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_dose"});?>" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_dilution" id="non_oasis_infusion_med3_dilution" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_dilution"});?>" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_route" id="non_oasis_infusion_med3_route" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_route"});?>" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_frequency" id="non_oasis_infusion_med3_frequency" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_frequency"});?>" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_duration" id="non_oasis_infusion_med3_duration" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_duration"});?>" />
</label>
			<!--For Infusion-->
		</td>
		<td>
			<!--For Infusion-->
			<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Pump:(type, specify)"  id="non_oasis_infusion" 
<?php if(in_array("Pump:(type, specify)",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Pump:(type, specify)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_pump" id="non_oasis_infusion_pump" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_pump"});?>" />
<br />
<strong><?php xl('Administered by:','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Self"  id="non_oasis_infusion_admin_by" 
<?php if($obj{"non_oasis_infusion_admin_by"}=="Self") echo "checked"; ?>  />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Caregiver"  id="non_oasis_infusion_admin_by" 
<?php if($obj{"non_oasis_infusion_admin_by"}=="Caregiver") echo "checked"; ?>  />
<?php xl('Caregiver','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="RN"  id="non_oasis_infusion_admin_by" 
<?php if($obj{"non_oasis_infusion_admin_by"}=="RN") echo "checked"; ?>  />
<?php xl('RN','e')?></label> &nbsp;
<label><br />
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Other"  id="non_oasis_infusion_admin_by" 
<?php if($obj{"non_oasis_infusion_admin_by"}=="Other") echo "checked"; ?>  />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_admin_by_other" id="non_oasis_infusion_admin_by_other" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_admin_by_other"});?>" />

<br />
<strong><?php xl('Purpose of Intravenous Access:','e')?></strong></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Antibiotic therapy"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Antibiotic therapy",$non_oasis_infusion_purpose)) echo "checked"; ?>  />
<?php xl('Antibiotic therapy','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Pain Control"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Pain Control",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Pain Control','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Chemotherapy"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Chemotherapy",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Chemotherapy','e')?></label> &nbsp;
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Maintain venous access"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Maintain venous access",$non_oasis_infusion_purpose)) echo "checked"; ?>  />
<?php xl('Maintain venous access','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Hydration"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Hydration",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Hydration','e')?></label> &nbsp;
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Parenteral nutrition"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Parenteral nutrition",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Parenteral nutrition','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Other"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Other",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Other','e')?></label> &nbsp;
<br />
<textarea name="non_oasis_infusion_purpose_other" rows="3" style="width:100%;">
<?php echo stripslashes($obj{"non_oasis_infusion_purpose_other"});?></textarea>
<br /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Infusion care provided during visit"  id="non_oasis_infusion" 
<?php if(in_array("Infusion care provided during visit",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Infusion care provided during visit','e')?></label> &nbsp;
<br />
<textarea name="non_oasis_infusion_care_provided" rows="3" style="width:100%;">
<?php echo stripslashes($obj{"non_oasis_infusion_care_provided"});?></textarea>
<br /><br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Dressing change:"  id="non_oasis_infusion" 
<?php if(in_array("Dressing change:",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Dressing change:','e')?></strong></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_dressing" value="Sterile"  id="non_oasis_infusion_dressing" 
<?php if($obj{"non_oasis_infusion_dressing"}=="Sterile") echo "checked"; ?> />
<?php xl('Sterile','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_dressing" value="Clean"  id="non_oasis_infusion_dressing" 
<?php if($obj{"non_oasis_infusion_dressing"}=="Clean") echo "checked"; ?> />
<?php xl('Clean','e')?></label> &nbsp;
<br />

<strong><?php xl('Performed by:','e')?></strong> &nbsp;&nbsp;&nbsp;&nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Self"  id="non_oasis_infusion_performed_by" 
<?php if($obj{"non_oasis_infusion_performed_by"}=="Self") echo "checked"; ?>  />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="RN"  id="non_oasis_infusion_performed_by" 
<?php if($obj{"non_oasis_infusion_performed_by"}=="RN") echo "checked"; ?>  />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Caregiver"  id="non_oasis_infusion_performed_by" 
<?php if($obj{"non_oasis_infusion_performed_by"}=="Caregiver") echo "checked"; ?>  />
<?php xl('Caregiver','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Other"  id="non_oasis_infusion_performed_by" 
<?php if($obj{"non_oasis_infusion_performed_by"}=="Other") echo "checked"; ?>  />
<?php xl('Other','e')?></label> &nbsp;
<br />

<label><?php xl('Frequency (specify)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_frequency" id="non_oasis_infusion_frequency" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_frequency"});?>" />
</label>
<br />
<label><?php xl('Injection cap change (specify frequency)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_injection" id="non_oasis_infusion_injection" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_injection"});?>" />
</label>
<br />
<extarea><?php xl('Labs drawn','e')?> &nbsp;
<br />
<textarea name="non_oasis_infusion_labs_drawn" rows="3" style="width:100%;">
<?php echo stripslashes($obj{"non_oasis_infusion_labs_drawn"});?></textarea>
</label>
<br />
<label><?php xl('Interventions/Instructions/Comments','e')?> &nbsp;
<br />
<textarea name="non_oasis_infusion_interventions" rows="3" style="width:100%;">
<?php echo stripslashes($obj{"non_oasis_infusion_interventions"});?></textarea>
</label>

			<!--For Infusion-->
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">External Feedings, Skilled Care provided this visit</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td>
			<center><strong><?php xl('ENTERAL FEEDINGS - ACCESS DEVICE','e')?></strong></center>
			<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Nasogastric"  id="non_oasis_enteral" 
<?php if(in_array("Nasogastric",$non_oasis_enteral)) echo "checked"; ?> />
<?php xl('Nasogastric','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Gastrostomy"  id="non_oasis_enteral" 
<?php if(in_array("Gastrostomy",$non_oasis_enteral)) echo "checked"; ?> />
<?php xl('Gastrostomy','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Jejunostomy"  id="non_oasis_enteral" 
<?php if(in_array("Jejunostomy",$non_oasis_enteral)) echo "checked"; ?> />
<?php xl('Jejunostomy','e')?></label> &nbsp;<br />
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Other (specify)"  id="non_oasis_enteral" 
<?php if(in_array("Other (specify)",$non_oasis_enteral)) echo "checked"; ?> />
<?php xl('Other (specify)','e')?></label> &nbsp;

<input type="text" name="non_oasis_enteral_other" id="non_oasis_enteral_other" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_enteral_other"});?>" />
<br />

<label><strong><?php xl('Pump: (type/specify)','e')?></strong> &nbsp;
<input type="text" name="non_oasis_enteral_pump" id="non_oasis_enteral_pump" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_enteral_pump"});?>" />
</label>
<br />

<strong><?php xl('Feedings:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_feedings" value="Bolus"  id="non_oasis_enteral_feedings" 
<?php if($obj{"non_oasis_enteral_feedings"}=="Bolus") echo "checked"; ?>  />
<?php xl('Bolus','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_feedings" value="Continuous"  id="non_oasis_enteral_feedings" 
<?php if($obj{"non_oasis_enteral_feedings"}=="Continuous") echo "checked"; ?>  />
<?php xl('Continuous','e')?></label> &nbsp;

<label><?php xl('Rate:','e')?> &nbsp;
<input type="text" name="non_oasis_enteral_rate" id="non_oasis_enteral_rate" size="14" 
value="<?php echo stripslashes($obj{"non_oasis_enteral_rate"});?>" />
</label>
<br />

<label>
<strong><?php xl('Flush Protocol: (amt./specify)','e')?></strong> &nbsp;<br>
<textarea name="non_oasis_enteral_flush" rows="3" style="width:100%;" >
<?php echo stripslashes($obj{"non_oasis_enteral_flush"});?></textarea>
</label>
<br />


<strong><?php xl('Performed by:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Self"  id="non_oasis_enteral_performed_by" 
<?php if($obj{"non_oasis_enteral_performed_by"}=="Self") echo "checked"; ?>  />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="RN"  id="non_oasis_enteral_performed_by" 
<?php if($obj{"non_oasis_enteral_performed_by"}=="RN") echo "checked"; ?>  />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Caregiver"  id="non_oasis_enteral_performed_by" 
<?php if($obj{"non_oasis_enteral_performed_by"}=="Caregiver") echo "checked"; ?>  />
<?php xl('Caregiver','e')?></label> &nbsp;<br>
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Other"  id="non_oasis_enteral_performed_by" 
<?php if($obj{"non_oasis_enteral_performed_by"}=="Other") echo "checked"; ?>  />
<?php xl('Other','e')?></label> &nbsp;

<input type="text" name="non_oasis_enteral_performed_by_other" id="non_oasis_enteral_performed_by_other" size="45" 
value="<?php echo stripslashes($obj{"non_oasis_enteral_performed_by_other"});?>" />
<br />

<label>
<strong><?php xl('Dressing/Site care:(specify)','e')?></strong> &nbsp;
<textarea name="non_oasis_enteral_dressing" rows="3" style="width:100%;" >
<?php echo stripslashes($obj{"non_oasis_enteral_dressing"});?></textarea>
</label>
<br />

<b><label><?php xl('Interventions/Instructions/Comments','e')?></b> &nbsp;
<textarea name="non_oasis_enteral_interventions" rows="3" style="width:100%;" >
<?php echo stripslashes($obj{"non_oasis_enteral_interventions"});?></textarea>
</label>
		</td>
		<td valign="top">
			<center><strong><?php xl('SKILLED CARE PROVIDED THIS VISIT','e')?></strong></center>
			<strong><?php xl('CARE COORDINATION:','e')?></strong>
			<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="RN"  id="non_oasis_skilled_care" 
<?php if(in_array("RN",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('RN','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="PT"  id="non_oasis_skilled_care" 
<?php if(in_array("PT",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('PT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="OT"  id="non_oasis_skilled_care" 
<?php if(in_array("OT",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('OT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="ST"  id="non_oasis_skilled_care" 
<?php if(in_array("ST",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('ST','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="MSW"  id="non_oasis_skilled_care" 
<?php if(in_array("MSW",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('MSW','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="Aide"  id="non_oasis_skilled_care" 
<?php if(in_array("Aide",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('Aide','e')?>
</label>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Summary</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul id="summary">
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2"> 
			<center><strong><?php xl('SUMMARY','e')?></strong></center>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('<u>(M0903)</u> Date of Last (Most Recent) Home Visit: ','e');?></strong>
			<input type='text' size='10' name='oasis_discharge_date_last_visit' id='oasis_discharge_date_last_visit' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_discharge_date_last_visit"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date903' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_discharge_date_last_visit", ifFormat:"%Y-%m-%d", button:"img_curr_date903"});
					</script>
		</td>
		<td>
			<?php xl('<b><u>(M0906)</u> Discharge/Transfer/Death Date:</b> Enter the date of the discharge, transfer, or death (at home) of the patient. ','e');?>
			<input type='text' size='10' name='oasis_discharge_transfer_date' id='oasis_discharge_transfer_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_discharge_transfer_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date906' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_discharge_transfer_date", ifFormat:"%Y-%m-%d", button:"img_curr_date906"});
					</script>
		</td>
	</tr>
	<!--For Summary-->
	<tr>
<TD colspan="2">
<strong><?php xl('DISCIPLINES INVOLVED:','e')?></strong> &nbsp;<br />
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="SN"  id="non_oasis_summary_disciplines" 
<?php if(in_array("SN",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('SN','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="PT"  id="non_oasis_summary_disciplines" 
<?php if(in_array("PT",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('PT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="OT"  id="non_oasis_summary_disciplines" 
<?php if(in_array("OT",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('OT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="ST"  id="non_oasis_summary_disciplines" 
<?php if(in_array("ST",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('ST','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="MSW"  id="non_oasis_summary_disciplines" 
<?php if(in_array("MSW",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('MSW','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="CHHA"  id="non_oasis_summary_disciplines" 
<?php if(in_array("CHHA",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('CHHA','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="Other"  id="non_oasis_summary_disciplines" 
<?php if(in_array("Other",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('Other','e')?>
</label>
<input type="text" name="non_oasis_summary_disciplines_other" id="non_oasis_summary_disciplines_other" size="20" 
value="<?php echo stripslashes($obj{"non_oasis_summary_disciplines_other"});?>" />
<br />

<strong><?php xl('PHYSICIAN NOTIFIED:','e')?></strong> &nbsp;
<label><input type="radio" name="non_oasis_summary_physician" value="Yes"  id="non_oasis_summary_physician" 
<?php if($obj{"non_oasis_summary_physician"}=="Yes") echo "checked"; ?> >
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_physician" value="No"  id="non_oasis_summary_physician" 
<?php if($obj{"non_oasis_summary_physician"}=="No") echo "checked"; ?> >
<?php xl('No','e')?></label> &nbsp;
</TD>
</tr>

<tr>
<TD colspan="2">
<center><strong><?php xl('Complete this Section for Discharge Purposes (unless Summary is written elsewhere','e')?></strong>
<input type="checkbox" name="non_oasis_summary_elsewhere" value="Yes"  id="non_oasis_summary_elsewhere" 
<?php if($obj{"non_oasis_summary_elsewhere"}=="Yes") echo "checked"; ?>  />
<strong><?php xl(')','e')?></strong>
</center><br />

<label>
<strong><?php xl('REASON FOR ADMISSION / SUMMARY:','e')?></strong><br />
<textarea name="non_oasis_summary_reason" rows="10" style="width:100%" >
<?php echo stripslashes($obj{"non_oasis_summary_reason"});?></textarea>
</label>
</TD>
</tr>



<tr>
<TD colspan="2">
<strong><?php xl('MEDICATION STATUS','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_summary_medication" value="Medication regimen reviewed"  id="non_oasis_summary_medication" 
<?php if($obj{"non_oasis_summary_medication"}=="Medication regimen reviewed") echo "checked"; ?>  />
<?php xl('Medication regimen reviewed','e')?>
</label>
<br />

<?php xl('Check if any of the following were identified:','e')?>
<br />

<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Potential adverse effects/drug reactions"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Potential adverse effects/drug reactions",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Potential adverse effects/drug reactions','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Ineffective drug therapy"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Ineffective drug therapy",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Ineffective drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Significant side effects"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Significant side effects",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Significant side effects','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Significant drug interactions"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Significant drug interactions",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Significant drug interactions','e')?>
</label>
<br />

<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Duplicate drug therapy"  id="non_oasis_summary_medication_identified"  <?php if(in_array("Duplicate drug therapy",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Duplicate drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Non compliance with drug therapy"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Non compliance with drug therapy",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Non compliance with drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="No change"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("No change",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('No change','e')?>
</label>
<label>

</TD>
</tr>

<tr>
<TD colspan="2">
<strong><?php xl('INDICATE REASON FOR DISCHARGE','e')?></strong> &nbsp; &nbsp; &nbsp; &nbsp;
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient/Family request"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient/Family request") echo "checked"; ?>  />
<?php xl('Patient/Family request','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Failure to maintain services of an attending physician"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Failure to maintain services of an attending physician") echo "checked"; ?>  />
<?php xl('Failure to maintain services of an attending physician','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient-centered goals achieved"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient-centered goals achieved") echo "checked"; ?>  />
<?php xl('Patient-centered goals achieved','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Physician request"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Physician request") echo "checked"; ?>  />
<?php xl('Physician request','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Agency/Organization decision"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Agency/Organization decision") echo "checked"; ?>  />
<?php xl('Agency/Organization decision','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient expired"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient expired") echo "checked"; ?>  />
<?php xl('Patient expired','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Repeatedly not home/not found"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Repeatedly not home/not found") echo "checked"; ?>  />
<?php xl('Repeatedly not home/not found','e')?>
</label>&nbsp;&nbsp;&nbsp;
<label>
<?php xl('Explain:','e')?>
<input type="text" name="non_oasis_summary_reason_discharge_explain" id="non_oasis_summary_reason_discharge_explain" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_summary_reason_discharge_explain"});?>" />
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Geographic relocation"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Geographic relocation") echo "checked"; ?>  />
<?php xl('Geographic relocation','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient refused to accept care/treatments as ordered"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient refused to accept care/treatments as ordered") echo "checked"; ?>  />
<?php xl('Patient refused to accept care/treatments as ordered','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient refused further care"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient refused further care") echo "checked"; ?>  />
<?php xl('Patient refused further care','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Persistent noncompliance with POC"  id="non_oasis_summary_reason_discharge"  <?php if($obj{"non_oasis_summary_reason_discharge"}=="Persistent noncompliance with POC") echo "checked"; ?>  />
<?php xl('Persistent noncompliance with POC','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="No longer home bound"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="No longer home bound") echo "checked"; ?>  />
<?php xl('No longer home bound','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Other (specify)"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Other (specify)") echo "checked"; ?>  />
<?php xl('Other (specify)','e')?>
</label>
<input type="text" name="non_oasis_summary_reason_discharge_other" id="non_oasis_summary_reason_discharge_other" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_summary_reason_discharge_other"});?>" />
</TD>
</tr>

<tr><TD colspan="2">
<label>
<strong>
<?php xl('DISCHARGE INSTRUCTIONS','e')?></strong>
<?php xl('(specify future follow-up, referrals, etc.)','e')?>
<textarea name="non_oasis_summary_discharge_inst" rows="7" style="width:100%">
<?php echo stripslashes($obj{"non_oasis_summary_discharge_inst"});?></textarea>
</label>
<br />


<strong><?php xl('Reviewed:','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Home safety"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Home safety") echo "checked"; ?>  />
<?php xl('Home safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Fall safety"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Fall safety") echo "checked"; ?>  />
<?php xl('Fall safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Medication safety"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Medication safety") echo "checked"; ?>  />
<?php xl('Medication safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="When to contact physician"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="When to contact physician") echo "checked"; ?>  />
<?php xl('When to contact physician','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Next appointment physician"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Next appointment physician") echo "checked"; ?>  />
<?php xl('Next appointment physician','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Standard precautions"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Standard precautions") echo "checked"; ?>  />
<?php xl('Standard precautions','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Other (describe)"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Other (describe)") echo "checked"; ?>  />
<?php xl('Other (describe)','e')?>
</label>
<input type="text" name="non_oasis_summary_reviewed_other" id="non_oasis_summary_reviewed_other" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_summary_reviewed_other"});?>" />
<br />

<strong><?php xl('Immunizations current:','e')?> &nbsp;</strong>
<label><input type="radio" name="non_oasis_summary_immunization" value="Yes"  id="non_oasis_summary_immunization" 
<?php if($obj{"non_oasis_summary_immunization"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_immunization" value="No"  id="non_oasis_summary_immunization" 
<?php if($obj{"non_oasis_summary_immunization"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_immun_explain" id="non_oasis_summary_immun_explain" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_summary_immun_explain"});?>" />
</label>
<br />


<strong><?php xl('Written instructions given to patient/caregiver:','e')?> &nbsp;</strong>
<label><input type="radio" name="non_oasis_summary_written" value="Yes"  id="non_oasis_summary_written" 
<?php if($obj{"non_oasis_summary_written"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_written" value="No"  id="non_oasis_summary_written" 
<?php if($obj{"non_oasis_summary_written"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_written_explain" id="non_oasis_summary_written_explain" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_summary_written_explain"});?>" />
</label>
<br />


<strong><?php xl('Patient/Caregiver demonstrates understanding of instructions:','e')?></strong> &nbsp;
<label><input type="radio" name="non_oasis_summary_demonstrates" value="Yes"  id="non_oasis_summary_demonstrates" 
<?php if($obj{"non_oasis_summary_demonstrates"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_demonstrates" value="No"  id="non_oasis_summary_demonstrates" 
<?php if($obj{"non_oasis_summary_demonstrates"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_demonstrates_explain" id="non_oasis_summary_demonstrates_explain" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_summary_demonstrates_explain"});?>" />
</label>
<br />

</TD></tr>

	<!--For Summary-->
</table>
				
				
				
				</li>
			</ul>
		</li>
</ul>
<!--<a id="btn_save" href="javascript:void(0)" class="link_submit"><?php xl(' [Save]','e')?></a>-->
<a id="btn_save" href="javascript:top.restoreSession();form_validation('oasis_discharge');" class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
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
                    <?php } ?>
                    </form>
                    <input type="button" value="Back" onClick="top.restoreSession();window.location='<?php echo $GLOBALS['webroot'] ?>/interface/patient_file/encounter/encounter_top.php';"/>&nbsp;&nbsp;
                    <?php if($action == "review") { ?>
                    <input type="button" value="Sign" id="signoff" href="#login_form" <?php echo $signDisabled;?> />
                    <?php } ?>
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
