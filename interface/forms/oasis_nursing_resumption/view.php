<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: oasis_nursing_resumption");
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
$formTable = "forms_oasis_nursing_resumption";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();




?>

<html>
<head>
<title>Oasis Nursing Resumption</title>
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
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
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
	
		
var tot=0;
function nut_sum(box,valu){
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
</head>
<body class="body_top">
<?php
$obj = formFetch("forms_oasis_nursing_resumption", $_GET["id"]);
$oasis_patient_race_ethnicity = explode("#",$obj{"oasis_patient_race_ethnicity"});
$oasis_patient_payment_source_homecare = explode("#",$obj{"oasis_patient_payment_source_homecare"});
$oasis_patient_history_impatient_facility = explode("#",$obj{"oasis_patient_history_impatient_facility"});
$oasis_patient_history_if_diagnosis = explode("#",$obj{"oasis_patient_history_if_diagnosis"});
$oasis_patient_history_if_code = explode("#",$obj{"oasis_patient_history_if_code"});
$oasis_patient_history_ip_diagnosis = explode("#",$obj{"oasis_patient_history_ip_diagnosis"});
$oasis_patient_history_ip_code = explode("#",$obj{"oasis_patient_history_ip_code"});
$oasis_patient_history_mrd_diagnosis = explode("#",$obj{"oasis_patient_history_mrd_diagnosis"});
$oasis_patient_history_mrd_code = explode("#",$obj{"oasis_patient_history_mrd_code"});
$oasis_patient_history_regimen_change = explode("#",$obj{"oasis_patient_history_regimen_change"});
$oasis_patient_history_therapies = explode("#",$obj{"oasis_patient_history_therapies"});
$oasis_patient_history_advance_directives = explode("#",$obj{"oasis_patient_history_advance_directives"});
$oasis_patient_history_risk_hospitalization = explode("#",$obj{"oasis_patient_history_risk_hospitalization"});
$oasis_patient_history_previous_outcome = explode("#",$obj{"oasis_patient_history_previous_outcome"});
$oasis_patient_history_prior_hospitalization_reason = explode("#",$obj{"oasis_patient_history_prior_hospitalization_reason"});
$oasis_patient_history_immunizations_needs = explode("#",$obj{"oasis_patient_history_immunizations_needs"});
$oasis_patient_history_allergies = explode("#",$obj{"oasis_patient_history_allergies"});
$oasis_patient_history_risk_factors = explode("#",$obj{"oasis_patient_history_risk_factors"});
$oasis_therapy_safety_measures = explode("#",$obj{"oasis_therapy_safety_measures"});
$oasis_safety_oxygen_backup = explode("#",$obj{"oasis_safety_oxygen_backup"});
$oasis_safety_hazards = explode("#",$obj{"oasis_safety_hazards"});
$oasis_sanitation_hazards = explode("#",$obj{"oasis_sanitation_hazards"});
$oasis_primary_caregiver_language = explode("#",$obj{"oasis_primary_caregiver_language"});
$oasis_functional_limitations = explode("#",$obj{"oasis_functional_limitations"});
$oasis_sensory_status_vision_detail = explode("#",$obj{"oasis_sensory_status_vision_detail"});
$oasis_sensory_status_vision_detail_contact = explode("#",$obj{"oasis_sensory_status_vision_detail_contact"});
$oasis_sensory_status_vision_detail_prothesis = explode("#",$obj{"oasis_sensory_status_vision_detail_prothesis"});
$oasis_sensory_status_hear_detail = explode("#",$obj{"oasis_sensory_status_hear_detail"});
$oasis_sensory_status_hear_detail_hoh = explode("#",$obj{"oasis_sensory_status_hear_detail_hoh"});
$oasis_sensory_status_hear_detail_vartigo = explode("#",$obj{"oasis_sensory_status_hear_detail_vartigo"});
$oasis_sensory_status_hear_detail_deaf = explode("#",$obj{"oasis_sensory_status_hear_detail_deaf"});
$oasis_sensory_status_hear_detail_tinnitus = explode("#",$obj{"oasis_sensory_status_hear_detail_tinnitus"});
$oasis_sensory_status_hear_detail_aid = explode("#",$obj{"oasis_sensory_status_hear_detail_aid"});
$oasis_sensory_status_musculoskeletal = explode("#",$obj{"oasis_sensory_status_musculoskeletal"});
$oasis_sensory_status_nose = explode("#",$obj{"oasis_sensory_status_nose"});
$oasis_sensory_status_mouth = explode("#",$obj{"oasis_sensory_status_mouth"});
$oasis_sensory_status_throat = explode("#",$obj{"oasis_sensory_status_throat"});
$oasis_vital_sign_blood_pressure = explode("#",$obj{"oasis_vital_sign_blood_pressure"});
$oasis_vital_sign_pulse_type = explode("#",$obj{"oasis_vital_sign_pulse_type"});
$oasis_therapy_pain_relieving_factors = explode("#",$obj{"oasis_therapy_pain_relieving_factors"});
$oasis_therapy_non_verbal_demonstrated = explode("#",$obj{"oasis_therapy_non_verbal_demonstrated"});
$oasis_therapy_fall_risk_assessment = explode("#",$obj{"oasis_therapy_fall_risk_assessment"});
$oasis_integumentary_status_turgur = explode("#",$obj{"oasis_integumentary_status_turgur"});
$oasis_therapy_pressure_ulcer_a = explode("#",$obj{"oasis_therapy_pressure_ulcer_a"});
$oasis_therapy_pressure_ulcer_b = explode("#",$obj{"oasis_therapy_pressure_ulcer_b"});
$oasis_therapy_pressure_ulcer_c = explode("#",$obj{"oasis_therapy_pressure_ulcer_c"});
$oasis_therapy_pressure_ulcer_d1 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d1"});
$oasis_therapy_pressure_ulcer_d2 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d2"});
$oasis_therapy_pressure_ulcer_d3 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d3"});
$oasis_therapy_wound = explode("#",$obj{"oasis_therapy_wound"});
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
$oasis_therapy_breath_sounds = explode("#",$obj{"oasis_therapy_breath_sounds"});
$oasis_therapy_heart_sounds = explode("#",$obj{"oasis_therapy_heart_sounds"});
$oasis_therapy_respiratory_treatment = explode("#",$obj{"oasis_therapy_respiratory_treatment"});

?>



<form method="post"
		action="<?php echo $rootdir;?>/forms/oasis_nursing_resumption/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="oasis_nursing_resumption">
		<h3 align="center"><?php xl('OASIS-C NURSING SERVICES SOC/ROC','e')?></h3>		
		
		


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
						<?php xl('Visit Date','e');?>
						<input type='text' size='10' name='oasis_patient_visit_date' value="<?php echo $obj{"oasis_patient_visit_date"};?>" readonly /> 
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl('Time In','e');?>
						<select name="time_in">
							<?php timeDropDown(stripslashes($obj{"time_in"})) ?>
						</select>
					</td><td align="right">
						<?php xl('Time Out','e');?>
						<select name="time_out">
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
			<ul>
				<li>	
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="center" colspan="2">
			<strong><?php xl('PATIENT TRACKING INFORMATION','e');?></strong>
		</td>
	</tr>
	<tr>
		<td>
			<strong>
			<?php xl('<u>(M0010)</u> C M S Certification Number: ','e');?>
			<input type="text" name="oasis_patient_cms_no" value="<?php echo $obj{"oasis_patient_cms_no"};?>"><br>
			<?php xl('<u>(M0014)</u> Branch State: ','e');?>
			<input type="text" name="oasis_patient_branch_state" value="<?php echo $obj{"oasis_patient_branch_state"};?>"><br>
			<?php xl('<u>(M0016)</u> Branch ID Number: ','e');?>
			<input type="text" name="oasis_patient_branch_id_no" value="<?php echo $obj{"oasis_patient_branch_id_no"};?>"><br>
			<?php xl('<u>(M0018)</u> National Provider Identifier (N P I)</strong> for the attending physician who has signed the plan of care: ','e');?>
			<input type="text" name="oasis_patient_npi" value="<?php echo $obj{"oasis_patient_npi"};?>"><br>
			<strong>
			<label><input type="checkbox" name="oasis_patient_npi_na" value="N/A" <?php if($obj{"oasis_patient_npi_na"}=="N/A"){echo "checked";}?> ><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<?php xl('Primary Referring Physician I.D.: ','e');?>
			<input type="text" name="oasis_patient_referring_physician_id" value="<?php echo $obj{"oasis_patient_referring_physician_id"};?>"><br>
			<label><input type="checkbox" name="oasis_patient_referring_physician_id_na" value="N/A" <?php if($obj{"oasis_patient_referring_physician_id_na"}=="N/A"){echo "checked";}?> ><?php xl('UK - Unknown or Not Available','e');?></label><br>
			</strong>
			<br>
			
			<strong><?php xl('Primary Referring Physician: ','e');?></strong><br>
			<table  class="formtable">
			<tr>
			<td>
			<?php xl('Last: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_last" value="<?php echo $obj{"oasis_patient_primary_physician_last"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('First: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_first" value="<?php echo $obj{"oasis_patient_primary_physician_first"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Phone: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_phone" value="<?php echo $obj{"oasis_patient_primary_physician_phone"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Address: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_address" value="<?php echo $obj{"oasis_patient_primary_physician_address"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('City: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_city" value="<?php echo $obj{"oasis_patient_primary_physician_city"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('State: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_state" value="<?php echo $obj{"oasis_patient_primary_physician_state"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Zip Code: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_zip" value="<?php echo $obj{"oasis_patient_primary_physician_zip"};?>"><br>
			</td>
			</tr>
			</table>
			<br>
			
			<strong><?php xl('Other Physician: ','e');?></strong><br>
			<table  class="formtable">
			<tr>
			<td>
			<?php xl('Last: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_last" value="<?php echo $obj{"oasis_patient_other_physician_last"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('First: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_first" value="<?php echo $obj{"oasis_patient_other_physician_first"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Phone: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_phone" value="<?php echo $obj{"oasis_patient_other_physician_phone"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Address: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_address" value="<?php echo $obj{"oasis_patient_other_physician_address"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('City: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_city" value="<?php echo $obj{"oasis_patient_other_physician_city"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('State: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_state" value="<?php echo $obj{"oasis_patient_other_physician_state"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Zip Code: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_zip" value="<?php echo $obj{"oasis_patient_other_physician_zip"};?>"><br>
			</td>
			</tr>
			</table>
			<br>
			
			<strong>
			<?php xl('<u>(M0020)</u>Patient ID Number: ','e');?>
			<input type="text" name="oasis_patient_patient_id" value="<?php patientName('pid');?>" readonly ><br>
			<?php xl('<u>(M0030)</u> Start of Care Date:','e');?>
				<input type='text' size='10' name='oasis_patient_soc_date' id='oasis_patient_soc_date' 
					title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_soc_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2b' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_soc_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2b"});
					</script>
					<br>
			<?php xl('<u>(M0032)</u> Resumption of Care Date: ','e');?>
				<input type='text' size='10' name='oasis_patient_resumption_care_date' id='oasis_patient_resumption_care_date' 
					title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_resumption_care_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2a' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_resumption_care_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2a"});
					</script>
					<br>
			<label><input type="checkbox" name="oasis_patient_resumption_care_date_na" value="N/A" <?php if($obj{"oasis_patient_resumption_care_date_na"}=="N/A"){echo "checked";}?> ><?php xl('NA - Not Applicable','e');?></label><br>
			<?php xl('<u>(M0040)</u> Patient"s Name: ','e');?><br>
			</strong>
			<table cellspacing="0" border="0" class="formtable">
				<tr>
					<td align="right">
						<?php xl('First: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_name_first" value="<?php patientName('fname')?>" readonly>
					</td>
					<td align="right">
						<?php xl('MI: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_name_mi" value="<?php patientName('mname')?>" readonly>
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl('Last: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_name_last" value="<?php patientName('lname')?>" readonly>
					</td>
					<td align="right">
						<?php xl('Suffix: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_name_suffix" value="<?php patientName('title')?>" readonly>
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
						<input type="text" name="oasis_patient_patient_address_street" value="<?php patientName('street')?>" readonly>
					</td>
					<td align="right">
						<?php xl('City: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_address_city" value="<?php patientName('city')?>" readonly>
					</td>
				</tr>
			</table>
			<br>
			
			<strong>
			<?php xl('Patient Phone: ','e');?>
			<input type="text" name="oasis_patient_patient_phone" value="<?php patientName('phone_home')?>" readonly><br>
			<?php xl('<u>(M0050)</u> Patient State of Residence: ','e');?>
			<input type="text" name="oasis_patient_patient_state" value="<?php patientName('state')?>" readonly><br>
			<?php xl('<u>(M0060)</u> Patient Zip Code: ','e');?>
			<input type="text" name="oasis_patient_patient_zip" value="<?php patientName('postal_code')?>" readonly><br>
			</strong>
		</td>
		<td valign="top">
			<b>
			<?php xl('<u>(M0063)</u> Medicare Number: (including suffix) ','e');?>
			<input type="text" name="oasis_patient_medicare_no" value="<?php echo $obj{"oasis_patient_medicare_no"};?>">
			<label><input type="checkbox" name="oasis_patient_medicare_no_na" value="N/A" <?php if($obj{"oasis_patient_medicare_no_na"}=="N/A"){echo "checked";}?> ><?php xl('N/A - No Medicare','e');?></label><br>
			<?php xl('<u>(M0064)</u> Social Security Number: ','e');?>
			<input type="text" name="oasis_patient_ssn" value="<?php echo $obj{"oasis_patient_ssn"};?>"><br>
			<label><input type="checkbox" name="oasis_patient_ssn_na" value="UK" <?php if($obj{"oasis_patient_ssn_na"}=="UK"){echo "checked";}?> ><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<?php xl('<u>(M0065)</u> Medicaid Number: ','e');?>
			<input type="text" name="oasis_patient_medicaid_no" value="<?php echo $obj{"oasis_patient_medicaid_no"};?>"><br>
			<label><input type="checkbox" name="oasis_patient_medicaid_no_na" value="N/A" <?php if($obj{"oasis_patient_medicaid_no_na"}=="N/A"){echo "checked";}?> ><?php xl('NA - No Medicaid','e');?></label><br>
			<?php xl('<u>(M0066)</u> Birth Date: ','e');?>
				<input type='text' size='10' name='oasis_patient_birth_date' value="<?php patientName("DOB")?>" readonly/> 
					<br>
			<?php xl('<u>(M0069)</u> Gender:','e');?></b>
				<label><input type="radio" value="Male" <?php if($obj{"oasis_patient_patient_gender"}=="Male") echo "checked"; ?> disabled /> <?php xl('Male','e')?></label>
				<label><input type="radio" value="Female" <?php if($obj{"oasis_patient_patient_gender"}=="Female") echo "checked"; ?> disabled /> <?php xl('Female','e')?></label>
				 
				<input type="hidden" name="oasis_patient_patient_gender" value="<?php echo stripslashes($obj{"oasis_patient_patient_gender"});?>" />
			
			<br>
			<strong><?php xl('<u>(M0140)</u> Race/Ethnicity: (Mark all that apply.)','e');?></strong><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="1" <?php if(in_array("1",$oasis_patient_race_ethnicity)) echo "checked"; ?> ><?php xl(' 1 - American Indian or Alaska Native','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="2" <?php if(in_array("2",$oasis_patient_race_ethnicity)) echo "checked"; ?> ><?php xl(' 2 - Asian','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="3" <?php if(in_array("3",$oasis_patient_race_ethnicity)) echo "checked"; ?> ><?php xl(' 3 - Black or African-American','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="4" <?php if(in_array("4",$oasis_patient_race_ethnicity)) echo "checked"; ?> ><?php xl(' 4 - Hispanic or Latino','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="5" <?php if(in_array("5",$oasis_patient_race_ethnicity)) echo "checked"; ?> ><?php xl(' 5 - Native Hawaiian or Pacific Islander','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="6" <?php if(in_array("6",$oasis_patient_race_ethnicity)) echo "checked"; ?> ><?php xl(' 6 - White','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('<u>(M0150)</u> Current Payment Sources for Home Care: (Mark all that apply.)','e');?><br></strong>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="0" <?php if(in_array("0",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 0 - None; no charge for current services','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="1" <?php if(in_array("1",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 1 - Medicare (traditional fee-for-service)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="2" <?php if(in_array("2",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 2 - Medicare (HMO/managed care/Advantage plan)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="3" <?php if(in_array("3",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 3 - Medicaid (traditional fee-for-service)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="4" <?php if(in_array("4",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 4 - Medicaid (HMO/managed care)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="5" <?php if(in_array("5",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 5 - Workers" compensation','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="6" <?php if(in_array("6",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 6 - Title programs (e.g., Title III, V, or XX)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="7" <?php if(in_array("7",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 7 - Other government (e.g., TriCare, VA, etc.)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="8" <?php if(in_array("8",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 8 - Private insurance','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="9" <?php if(in_array("9",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 9 - Private HMO/managed care','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="10" <?php if(in_array("10",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 10 - Self-pay','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="11" <?php if(in_array("11",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 11 - Other (specify)','e')?></label>
				<input type='text' name='oasis_patient_payment_source_homecare_other' value="<?php echo $obj{"oasis_patient_payment_source_homecare_other"};?>"/> <br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="UK" <?php if(in_array("UK",$oasis_patient_payment_source_homecare)) echo "checked"; ?> ><?php xl(' UK - Unknown','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('Certification Period From: ','e');?></strong>
			<input type='text' size='10' name='oasis_patient_certification_period_from' id='oasis_patient_certification_period_from' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_certification_period_from"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date5' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_certification_period_from", ifFormat:"%Y-%m-%d", button:"img_curr_date5"});
					</script>
			<?php xl(' To: ','e');?>
			<input type='text' size='10' name='oasis_patient_certification_period_to' id='oasis_patient_certification_period_to' 
					title='<?php xl('yyyy-mm-dd To','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_certification_period_to"};?> " readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date5b' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_certification_period_to", ifFormat:"%Y-%m-%d", button:"img_curr_date5b"});
					</script>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<strong><?php xl('CLINICAL RECORD ITEMS','e');?></strong>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong><?php xl('<u>(M0080)</u> Discipline of Person Completing Assessment:','e');?></strong><br>
				<label><input type="radio" name="oasis_patient_discipline_person" value="1" <?php if($obj{"oasis_patient_discipline_person"}=="1"){echo "checked";}?> ><?php xl(' 1 - RN ','e');?></label>&nbsp;&nbsp;
				<label><input type="radio" name="oasis_patient_discipline_person" value="2" <?php if($obj{"oasis_patient_discipline_person"}=="2"){echo "checked";}?> ><?php xl(' 2 - PT ','e');?></label>&nbsp;&nbsp;
				<label><input type="radio" name="oasis_patient_discipline_person" value="3" <?php if($obj{"oasis_patient_discipline_person"}=="3"){echo "checked";}?> ><?php xl(' 3 - SLP/ST ','e');?></label>&nbsp;&nbsp;
				<label><input type="radio" name="oasis_patient_discipline_person" value="4" <?php if($obj{"oasis_patient_discipline_person"}=="4"){echo "checked";}?> ><?php xl(' 4 - OT ','e');?></label>
			<br>
			<hr>
			<strong><?php xl('<u>(M0090)</u> Date Assessment Completed: ','e');?></strong>
			<input type='text' size='10' name='oasis_patient_date_assessment_completed' id='oasis_patient_date_assessment_completed' 
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_date_assessment_completed"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_date_assessment_completed", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
					</script>
			<br>
			<hr>
			<strong><?php xl('<u>(M0100)</u> This Assessment is Currently Being Completed for the Following Reason: <br><u>Start/Resumption of Care</u> ','e');?></strong><br>
				<label><input type="radio" name="oasis_patient_follow_up" value="1" <?php if($obj{"oasis_patient_follow_up"}=="1"){echo "checked";}?> ><?php xl(' 1 - Start of care-further visits planned','e');?></label><br>
				<label><input type="radio" name="oasis_patient_follow_up" value="3" <?php if($obj{"oasis_patient_follow_up"}=="3"){echo "checked";}?> ><?php xl(' 3 - Resumption of care (after inpatient stay)','e');?></label>
			
		</td>
		<td>
			<?php xl('<b><u>(M0102)</u> Date of Physician-ordered Start of Care (Resumption of Care):</b> If the physician indicated a specific start of care (resumption of care) date when the patient was referred for home health services, record the date specified. <b><i>(Go to M0110, if date entered)</i></b>','e');?>
			<input type='text' size='10' name='oasis_patient_date_ordered_soc' id='oasis_patient_date_ordered_soc' 
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_date_ordered_soc"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4z' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_date_ordered_soc", ifFormat:"%Y-%m-%d", button:"img_curr_date4z"});
					</script>
			<br>
			<label><input type="checkbox" name="oasis_patient_date_ordered_soc_na" value="NA" <?php if($obj{"oasis_patient_date_ordered_soc_na"}=="NA"){echo "checked";}?> ><?php xl('NA - No specific SOC date ordered by physician','e');?></label><br>
			<br>
			<hr>
			<?php xl('<b><u>(M0104)</u> Date of Referral:</b> Indicate the date that the written or verbal referral for initiation or resumption of care was received by the HHA.','e');?>
			<input type='text' size='10' name='oasis_patient_date_of_referral' id='oasis_patient_date_of_referral' 
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_date_of_referral"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4a' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_date_of_referral", ifFormat:"%Y-%m-%d", button:"img_curr_date4a"});
					</script>
			<br>
			<hr>
			<?php xl('<b><u>(M0110)</u> Episode Timing:</b> Is the Medicare home health payment episode for which this assessment will define a case mix group an "early" episode or a "later" episode in the patient"s current sequence of adjacent Medicare home health payment episodes? ','e');?><br>
				<label><input type="radio" name="oasis_patient_episode_timing" value="1" <?php if($obj{"oasis_patient_episode_timing"}=="1"){echo "checked";}?> ><?php xl(' 1 - Early','e');?></label><br>
				<label><input type="radio" name="oasis_patient_episode_timing" value="2" <?php if($obj{"oasis_patient_episode_timing"}=="2"){echo "checked";}?> ><?php xl(' 2 - Later','e');?></label><br>
				<label><input type="radio" name="oasis_patient_episode_timing" value="UK" <?php if($obj{"oasis_patient_episode_timing"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown','e');?></label><br>
				<label><input type="radio" name="oasis_patient_episode_timing" value="NA" <?php if($obj{"oasis_patient_episode_timing"}=="NA"){echo "checked";}?> ><?php xl(' NA - Not Applicable: No Medicare case mix group to be defined by this assessment.','e');?></label>
			<br>
			<br>
			<?php xl('<b>DEFINITION:</b> <u>Early</u> Episode is first or second episode in a sequence of adjacent episodes. <u>Later</u> is the third episode and beyond in sequence of adjacent episodes. Adjacent episodes are separated by 60 days or fewer between episodes.','e'); ?>
			
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Patient History and diagnosis</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="center" colspan="2">
			<strong><?php xl('PATIENT HISTORY AND DIAGNOSIS','e');?></strong>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<?php xl('<b><u>(M1000)</u></b> From which of the following <b>Inpatient Facilities</b> was the patient discharged <u>during the past 14 days?</u> <b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="1" <?php if(in_array("1",$oasis_patient_history_impatient_facility)) echo "checked"; ?> ><?php xl(' 1 - Long-term nursing facility (NF)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="2" <?php if(in_array("2",$oasis_patient_history_impatient_facility)) echo "checked"; ?> ><?php xl(' 2 - Skilled nursing facility (SNF / TCU)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="3" <?php if(in_array("3",$oasis_patient_history_impatient_facility)) echo "checked"; ?> ><?php xl(' 3 - Short-stay acute hospital (IPP S)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="4" <?php if(in_array("4",$oasis_patient_history_impatient_facility)) echo "checked"; ?> ><?php xl(' 4 - Long-term care hospital (LTCH)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="5" <?php if(in_array("5",$oasis_patient_history_impatient_facility)) echo "checked"; ?> ><?php xl(' 5 - Inpatient rehabilitation hospital or unit (IRF)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="6" <?php if(in_array("6",$oasis_patient_history_impatient_facility)) echo "checked"; ?> ><?php xl(' 6 - Psychiatric hospital or unit','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="7" <?php if(in_array("7",$oasis_patient_history_impatient_facility)) echo "checked"; ?> ><?php xl(' 7 - Other (specify)','e')?></label>
				<input type='text' name='oasis_patient_history_impatient_facility_other' value="<?php echo $obj{"oasis_patient_history_impatient_facility_other"};?>"/><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="NA" <?php if(in_array("NA",$oasis_patient_history_impatient_facility)) echo "checked"; ?> ><?php xl(' NA - Patient was not discharged from an inpatient facility <b><i>[Go to M1016 ]</i></b>','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1005)</u> Inpatient Discharge Date</b> (most recent):','e');?><br>
			<input type='text' size='10' name='oasis_patient_history_discharge_date' id='oasis_patient_history_discharge_date' 
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php echo $obj{"oasis_patient_history_discharge_date"};?>' readonly /> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4b' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_discharge_date", ifFormat:"%Y-%m-%d", button:"img_curr_date4b"});
					</script><br>
			<label><input type="checkbox" name="oasis_patient_history_discharge_date_na" value="UK" <?php if($obj{"oasis_patient_history_discharge_date_na"}=="UK"){echo "checked";}?> ><?php xl('UK - Unknown','e');?></label><br>
			<br>
			<hr>
			<?php xl('<b><u>(M1010)</u></b> List each <strong>Inpatient Diagnosis </strong>and ICD-9-C M code at the level of highest specificity for only those conditions treated during an inpatient stay within the last 14 days (no E-codes, or V-codes):','e'); ?><br>
			<table class="formtable" border="0px" width="100%">
				<tr>
					<td align="center">
						<u><?php xl('Inpatient Facility Diagnosis','e'); ?></u>
					</td>
					<td align="center">
						<u><?php xl('ICD-9-C M Code','e'); ?></u>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('a.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis1" value="<?php echo $oasis_patient_history_if_diagnosis[0]; ?>" />
							<br>
						<?php xl('b.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis2" value="<?php echo $oasis_patient_history_if_diagnosis[1]; ?>" />
							<br>
						<?php xl('c.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis3" value="<?php echo $oasis_patient_history_if_diagnosis[2];?>" />
							<br>
						<?php xl('d.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis4" value="<?php echo $oasis_patient_history_if_diagnosis[3];?>" />
							<br>
						<?php xl('e.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis5" value="<?php echo $oasis_patient_history_if_diagnosis[4];?>" />
							<br>
						<?php xl('f.','e'); ?>&nbsp;&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis6" value="<?php echo $oasis_patient_history_if_diagnosis[5];?>" />
					</td>
					<td align="center">
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code1" name="oasis_patient_history_if_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_if_code[0];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code2" name="oasis_patient_history_if_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_if_code[1];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code3" name="oasis_patient_history_if_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_if_code[2];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code4" name="oasis_patient_history_if_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_if_code[3];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code5" name="oasis_patient_history_if_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_if_code[4];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code6" name="oasis_patient_history_if_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_if_code[5];?>" >
						
					</td>
				</tr>
			</table>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1012)</u></b> List each <b>Inpatient Procedure</b> and the associated ICD-9-C M procedure code relevant to the plan of care.','e'); ?><br>
			<table class="formtable" border="0px" width="100%">
				<tr>
					<td align="center">
						<u><?php xl('Inpatient Procedure','e'); ?></u>
					</td>
					<td align="center">
						<u><?php xl('Procedure Code','e'); ?></u>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('a.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_ip_diagnosis[]" id="oasis_patient_history_ip_diagnosis1" value="<?php echo $oasis_patient_history_ip_diagnosis[0]; ?>" />
							<br>
						<?php xl('b.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_ip_diagnosis[]" id="oasis_patient_history_ip_diagnosis2" value="<?php echo $oasis_patient_history_ip_diagnosis[1]; ?>" />
							<br>
						<?php xl('c.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_ip_diagnosis[]" id="oasis_patient_history_ip_diagnosis3" value="<?php echo $oasis_patient_history_ip_diagnosis[2];?>" />
							<br>
						<?php xl('d.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_ip_diagnosis[]" id="oasis_patient_history_ip_diagnosis4" value="<?php echo $oasis_patient_history_ip_diagnosis[3];?>" />
							<br>
					</td>
					<td align="center">
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code1" name="oasis_patient_history_ip_code[]" onkeydown="fonChange(this,100,'no')" value="<?php echo $oasis_patient_history_ip_code[0];?>" /><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code2" name="oasis_patient_history_ip_code[]" onkeydown="fonChange(this,100,'no')" value="<?php echo $oasis_patient_history_ip_code[1];?>" /><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code3" name="oasis_patient_history_ip_code[]" onkeydown="fonChange(this,100,'no')" value="<?php echo $oasis_patient_history_ip_code[2];?>" /><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code4" name="oasis_patient_history_ip_code[]" onkeydown="fonChange(this,100,'no')" value="<?php echo $oasis_patient_history_ip_code[3];?>" /><br>
					</td>
				</tr>
			</table>
			<label><input type="checkbox" name="oasis_patient_history_ip_diagnosis_na" value="NA" <?php if($obj{"oasis_patient_history_ip_diagnosis_na"}=="NA"){echo "checked";}?> ><?php xl(' NA - Not applicable','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_ip_diagnosis_uk" value="UK" <?php if($obj{"oasis_patient_history_ip_diagnosis_uk"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown','e')?></label><br>
		</td>
		<td valign="top">
			<?php xl('<b><u>(M1016)</u> Diagnosis Requiring Medical or Treatment Regimen Change Within Past 14 Days:</b><br> List the patient\'s Medical Diagnosis and ICD-9-C M codes at the level of highest specificity for those conditions requiring changed medical or treatment regimen within the past 14 days (no surgical, E-codes, or V-codes):','e'); ?><br>
			<table class="formtable" border="0px" width="100%">
				<tr>
					<td align="center">
						<u><?php xl('Changed Medical Regimen Diagnosis','e'); ?></u>
					</td>
					<td align="center">
						<u><?php xl('ICD-9-C M Code','e'); ?></u>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('a.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis1" value="<?php echo $oasis_patient_history_mrd_diagnosis[0]; ?>" />
							<br>
						<?php xl('b.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis2" value="<?php echo $oasis_patient_history_mrd_diagnosis[1]; ?>" />
							<br>
						<?php xl('c.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis3" value="<?php echo $oasis_patient_history_mrd_diagnosis[2];?>" />
							<br>
						<?php xl('d.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis4" value="<?php echo $oasis_patient_history_mrd_diagnosis[3];?>" />
							<br>
						<?php xl('e.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis5" value="<?php echo $oasis_patient_history_mrd_diagnosis[4];?>" />
							<br>
						<?php xl('f.','e'); ?>&nbsp;&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis6" value="<?php echo $oasis_patient_history_mrd_diagnosis[5];?>" />
							<br>
					</td>
					<td align="center">
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code1" name="oasis_patient_history_mrd_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_mrd_code[0];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code2" name="oasis_patient_history_mrd_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_mrd_code[1];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code3" name="oasis_patient_history_mrd_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_mrd_code[2];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code4" name="oasis_patient_history_mrd_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_mrd_code[3];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code5" name="oasis_patient_history_mrd_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_mrd_code[4];?>" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code6" name="oasis_patient_history_mrd_code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $oasis_patient_history_mrd_code[5];?>" ><br>
					</td>
				</tr>
			</table>
			<label><input type="checkbox" name="oasis_patient_history_mrd_diagnosis_na" value="NA" <?php if($obj{"oasis_patient_history_mrd_diagnosis_na"}=="NA"){echo "checked";}?> ><?php xl(' NA - Not applicable (no medical or treatment regimen changes within the past 14 days)','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1018)</u> Conditions Prior to Medical or Treatment Regimen Change or Inpatient Stay Within Past 14 Days:</b> <br>If this patient experienced an inpatient facility discharge or change in medical or treatment regimen within the past 14 days, indicate any conditions which existed <u>prior to</u> the inpatient stay or change in medical or treatment regimen. <b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="1" <?php if(in_array("1",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' 1 - Urinary incontinence','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="2" <?php if(in_array("2",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' 2 - Indwelling/suprapubic catheter','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="3" <?php if(in_array("3",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' 3 - Intractable pain','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="4" <?php if(in_array("4",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' 4 - Impaired decision-making','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="5" <?php if(in_array("5",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' 5 - Disruptive or socially inappropriate behavior','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="6" <?php if(in_array("6",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' 6 - Memory loss to the extent that supervision required','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="7" <?php if(in_array("7",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' 7 - None of the above','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="NA" <?php if(in_array("NA",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' NA - No inpatient facility discharge <u>and</u> no change in medical or treatment regimen in past 14 days','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="UK" <?php if(in_array("UK",$oasis_patient_history_regimen_change)) echo "checked"; ?> ><?php xl(' UK - Unknown','e')?></label><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php xl('<strong><u>(M1020/1022/1024)</u> Diagnosis, Symptom Control, and Payment Diagnosis:</strong> List each diagnosis for which the patient is receiving home care (Column 1) and enter its ICD-9-C M code at the level of highest
specificity (no surgical/procedure codes) (Column 2). Diagnosis are listed in the order that best reflect the seriousness of each condition and support the disciplines and services provided. Rate the degree of symptom
control for each condition (Column 2). Choose one value that represents the degree of symptom control appropriate for each diagnosis: V-codes (for M1020 or M1022) or E-codes (for M1022 only) may be used. ICD-9-C
M sequencing requirements must be followed if multiple coding is indicated for any Diagnosis. If a V-code is reported in place of a case mix diagnosis, then optional item M1024 Payment Diagnosis (Columns 3 and 4) may
be completed. A case mix diagnosis is a diagnosis that determines the Medicare P P S case mix group. Do not assign symptom control ratings for V- or E-codes.','e');?><br>
			<table cellspacing="0" border="1px" class="formtable">
				<tr>
					<td colspan="2">
						<strong><?php xl('Code each row according to the following directions for each column:','e');?></strong>
					</td>
				</tr>
				<tr>
					<td width="80px" valign="top">
						<strong><?php xl('Column 1:','e');?></strong>
					</td>
					<td>
						<?php xl('Enter the description of the diagnosis.','e');?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<strong><?php xl('Column 2:','e');?></strong>
					</td>
					<td>
						<?php xl('Enter the ICD-9-C M code for the diagnosis described in Column 1;<br>
Rate the degree of symptom control for the condition listed in Column 1 using the following scale:<br>
0 - Asymptomatic, no treatment needed at this time<br>
1 - Symptoms well controlled with current therapy<br>
2 - Symptoms controlled with difficulty, affecting daily functioning; patient needs ongoing monitoring<br>
3 - Symptoms poorly controlled; patient needs frequent adjustment in treatment and dose monitoring<br>
4 - Symptoms poorly controlled; history of re-hospitalizations<br>
Note that in Column 2 the rating for symptom control of each diagnosis should not be used to determine the sequencing of the Diagnosis listed in Column 1. These are separate items
and sequencing may not coincide. Sequencing of Diagnosis should reflect the seriousness of each condition and support the disciplines and services provided.','e');?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<strong><?php xl('Column 3:','e');?></strong>
					</td>
					<td>
						<?php xl('(OPTIONAL) If a V-code is assigned to any row in Column 2, in place of a case mix diagnosis, it may be necessary to complete optional item M1024 Payment Diagnosis (Columns 3 and
4). See OASIS-C Guidance Manual.','e');?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<strong><?php xl('Column 4:','e');?></strong>
					</td>
					<td>
						<?php xl('(OPTIONAL) If a V-code in Column 2 is reported in place of a case mix diagnosis that requires multiple diagnosis codes under ICD-9-C M coding guidelines, enter the diagnosis
descriptions and the ICD-9-C M codes in the same row in Columns 3 and 4. For example, if the case mix diagnosis is a manifestation code, record the diagnosis description and ICD-9-C M
code for the underlying condition in Column 3 of that row and the diagnosis description and ICD-9-C M code for the manifestation in Column 4 of that row. Otherwise, leave Column 4
blank in that row.','e');?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="1px" cellspacing="0" class="formtable">
				<tr>
					<td colspan="2" align="center" width="50%">
						<strong><?php xl('<u>(M1020)</u> Primary Diagnosis & (M1022) Other Diagnosis','e');?></strong>
					</td>
					<td colspan="2" align="center" width="50%">
						<strong><?php xl('<u>(M1024)</u> Payment Diagnosis (OPTIONAL)','e');?></strong>
					</td>
				</tr>
				<tr>
					<td align="center" width="25%">
						<strong><?php xl('Column 1','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('Column 2','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('Column 3','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('Column 4','e');?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('Diagnosis (Sequencing of Diagnosis should reflect the seriousness of each condition and support the disciplines and services provided.)','e');?>
					</td>
					<td>
						<?php xl('ICD-9-C M and symptom control rating for each condition. Note that the sequencing of these ratings may not match the sequencing of the Diagnosis','e');?>
					</td>
					<td valign="top">
						<?php xl('Complete if a V-code is assigned under certain circumstances to Column 2 in place of a case mix diagnosis.','e');?>
					</td>
					<td>
						<?php xl('Complete <b><u>only if</u></b> the V-code in Column 2 is reported in place of a case mix diagnosis that is a multiple coding situation (e.g., a manifestation code).','e');?>
					</td>
				</tr>
				<tr>
					<td align="center" width="25%">
						<strong><?php xl('Description','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('ICD-9-C M / Symptom Control Rating','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('Description/ ICD-9-C M','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('Description/ ICD-9-C M','e');?></strong>
					</td>
				</tr>
				<tr>
					<td align="left" width="25%">
						<strong><?php xl('<u>(M1020)</u> Primary Diagnosis','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('(V-codes are allowed)','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('(V- or E-codes NOT allowed)','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('(V- or E-codes NOT allowed)','e');?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1a" id="oasis_therapy_patient_diagnosis_1a" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1a"};?>">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2a"  id="oasis_therapy_patient_diagnosis_2a" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2a"};?>" onkeydown="fonChange(this,2,'noe')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2a_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2a_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2a_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2a_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2a_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3a" id="oasis_therapy_patient_diagnosis_3a" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3a"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4a" id="oasis_therapy_patient_diagnosis_4a" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4a"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td align="left" width="25%">
						<strong><?php xl('<u>(M1022)</u> Other Diagnosis','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('(V- or E-codes are allowed)','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('(V- or E-codes NOT allowed)','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('(V- or E-codes NOT allowed)','e');?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1b" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1b"};?>">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2b" id="oasis_therapy_patient_diagnosis_2b" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2b"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2b_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2b_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2b_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2b_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2b_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3b" id="oasis_therapy_patient_diagnosis_3b"  value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3b"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4b" id="oasis_therapy_patient_diagnosis_4b" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4b"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1c" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1c"};?>">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2c" id="oasis_therapy_patient_diagnosis_2c" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2c"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2c_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2c_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2c_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2c_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2c_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3c" id="oasis_therapy_patient_diagnosis_3c" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3c"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4c" id="oasis_therapy_patient_diagnosis_4c" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4c"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1d" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1d"};?>">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2d" id="oasis_therapy_patient_diagnosis_2d" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2d"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2d_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2d_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2d_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2d_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2d_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3d" id="oasis_therapy_patient_diagnosis_3d" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3d"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4d" id="oasis_therapy_patient_diagnosis_4d" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4d"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1e" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1e"};?>">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2e" id="oasis_therapy_patient_diagnosis_2e" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2e"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2e_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2e_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2e_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2e_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2e_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3e" id="oasis_therapy_patient_diagnosis_3e" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3e"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4e" id="oasis_therapy_patient_diagnosis_4e" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4e"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1f" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1f"};?>">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2f" id="oasis_therapy_patient_diagnosis_2f" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2f"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2f_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2f_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2f_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2f_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2f_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3f" id="oasis_therapy_patient_diagnosis_3f" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3f"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4f" id="oasis_therapy_patient_diagnosis_4f" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4f"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1g" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1g"};?>">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2g" id="oasis_therapy_patient_diagnosis_2g" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2g"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2g_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2g_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2g_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2g_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2g_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3g" id="oasis_therapy_patient_diagnosis_3g" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3g"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4g"  id="oasis_therapy_patient_diagnosis_4g" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4g"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1h" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1h"};?>">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2h" id="oasis_therapy_patient_diagnosis_2h" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2h"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2h_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2h_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2h_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2h_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2h_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3h" id="oasis_therapy_patient_diagnosis_3h" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3h"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4h" id="oasis_therapy_patient_diagnosis_4h" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4h"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1i"  value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1i"};?>">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2i" id="oasis_therapy_patient_diagnosis_2i" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2i"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2i_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2i_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2i_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2i_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2i_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3i" id="oasis_therapy_patient_diagnosis_3i" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3i"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4i" id="oasis_therapy_patient_diagnosis_4i" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4i"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1j" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1j"};?>">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2j" id="oasis_therapy_patient_diagnosis_2j" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2j"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2j_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2j_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2j_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2j_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2j_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3j" id="oasis_therapy_patient_diagnosis_3j" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3j"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4j" id="oasis_therapy_patient_diagnosis_4j" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4j"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1k" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1k"};?>">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2k" id="oasis_therapy_patient_diagnosis_2k" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2k"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2k_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2k_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2k_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2k_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2k_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3k" id="oasis_therapy_patient_diagnosis_3k" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3k"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4k" id="oasis_therapy_patient_diagnosis_4k" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4k"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1l" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1l"};?>">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2l" id="oasis_therapy_patient_diagnosis_2l" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2l"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2l_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2l_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2l_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2l_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2l_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3l" id="oasis_therapy_patient_diagnosis_3l" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3l"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4l" id="oasis_therapy_patient_diagnosis_4l" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4l"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1m" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_1m"};?>">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2m" id="oasis_therapy_patient_diagnosis_2m" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_2m"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="0" <?php if($obj{"oasis_therapy_patient_diagnosis_2m_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="1" <?php if($obj{"oasis_therapy_patient_diagnosis_2m_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="2" <?php if($obj{"oasis_therapy_patient_diagnosis_2m_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="3" <?php if($obj{"oasis_therapy_patient_diagnosis_2m_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="4" <?php if($obj{"oasis_therapy_patient_diagnosis_2m_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3m" id="oasis_therapy_patient_diagnosis_3m" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_3m"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4m" id="oasis_therapy_patient_diagnosis_4m" value="<?php echo $obj{"oasis_therapy_patient_diagnosis_4m"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<b><?php xl('Surgical Procedure ( V codes are allowed )','e');?></b><br>
			<?php xl('a. ','e');?>
			<input type="text" name="oasis_therapy_surgical_procedure_a" value="<?php echo $obj{"oasis_therapy_surgical_procedure_a"};?> ">
			<input type='text' size='10' name='oasis_therapy_surgical_procedure_a_date' id='oasis_therapy_surgical_procedure_a_date' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_surgical_procedure_a_date"};?> " readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date6' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_surgical_procedure_a_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6"});
					</script><br>
			<?php xl('b. ','e');?>
			<input type="text" name="oasis_therapy_surgical_procedure_b" value="<?php echo $obj{"oasis_therapy_surgical_procedure_b"};?> ">
			<input type='text' size='10' name='oasis_therapy_surgical_procedure_b_date' id='oasis_therapy_surgical_procedure_b_date' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_surgical_procedure_b_date"};?> " readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date6b' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_surgical_procedure_b_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6b"});
					</script><br>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<b><?php xl('PHYSICIAN DATE LAST CONTACTED:','e');?></b>
				<input type='text' size='10' name='oasis_patient_history_last_contact_date' id='oasis_patient_history_last_contact_date' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_history_last_contact_date"};?> " readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date6c' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_last_contact_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6c"});
					</script><br>
					
			<b><?php xl('PHYSICIAN DATE LAST VISITED:','e');?></b>
				<input type='text' size='10' name='oasis_patient_history_last_visit_date' id='oasis_patient_history_last_visit_date' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_patient_history_last_visit_date"};?> " readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date6d' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_last_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6d"});
					</script><br>
					
			<b><?php xl('PRIMARY REASON FOR HOME HEALTH:','e');?></b>
				<input type="text" name="oasis_patient_history_reason_home_health" value="<?php echo $obj{"oasis_patient_history_reason_home_health"};?> ">
			<br>
			<label><input type="checkbox" name="oasis_patient_history_reason" value="To treat" <?php if($obj{"oasis_patient_history_reason"}=="To treat"){echo "checked";}?> ><?php xl('To treat patient illness or injury due to the inherent complexity of the service and the condition of the patient.','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_reason" value="Other" <?php if($obj{"oasis_patient_history_reason"}=="Other"){echo "checked";}?> ><?php xl('Other:','e')?></label><br>
				<textarea name="oasis_patient_history_reason_other" rows="3" style="width:100%;"><?php echo $obj{"oasis_patient_history_reason_other"};?></textarea>
				
			<br><br>
			<?php xl('<b><u>(M1030)</u> Therapies</b> the patient receives <u>at home</u>: <b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_therapies[]" value="1" <?php if(in_array("1",$oasis_patient_history_therapies)) echo "checked"; ?> ><?php xl(' 1 - Intravenous or infusion therapy (excludes TPN)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_therapies[]" value="2" <?php if(in_array("2",$oasis_patient_history_therapies)) echo "checked"; ?> ><?php xl(' 2 - Parenteral nutrition (TPN or lipids)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_therapies[]" value="3" <?php if(in_array("3",$oasis_patient_history_therapies)) echo "checked"; ?> ><?php xl(' 3 - Enteral nutrition (nasogastric, gastrostomy, jejunostomy, or any other artificial entry into the alimentary canal)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_therapies[]" value="4" <?php if(in_array("4",$oasis_patient_history_therapies)) echo "checked"; ?> ><?php xl(' 4 - None of the above','e')?></label><br>
			
			<br>
			<hr>
			<center><strong><?php xl('PROGNOSIS','e')?></strong></center>
			<b><?php xl('Prognosis:','e')?></b>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="1" <?php if($obj{"oasis_therapy_pragnosis"}=="1"){echo "checked";}?> ><?php xl(' 1-Poor ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="2" <?php if($obj{"oasis_therapy_pragnosis"}=="2"){echo "checked";}?> ><?php xl(' 2-Guarded ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="3" <?php if($obj{"oasis_therapy_pragnosis"}=="3"){echo "checked";}?> ><?php xl(' 3-Fair ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="4" <?php if($obj{"oasis_therapy_pragnosis"}=="4"){echo "checked";}?> ><?php xl(' 4-Good ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="5" <?php if($obj{"oasis_therapy_pragnosis"}=="5"){echo "checked";}?> ><?php xl(' 5-Excellent ','e')?></label><br>
			
			<br>
			<center><strong><?php xl('ADVANCE DIRECTIVES','e')?></strong></center>
			<table class="formtable" border="0px" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Do not resuscitate" <?php if(in_array("Do not resuscitate",$oasis_patient_history_advance_directives)) echo "checked"; ?> ><?php xl('Do not resuscitate','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Copies on file" <?php if(in_array("Copies on file",$oasis_patient_history_advance_directives)) echo "checked"; ?> ><?php xl('Copies on file','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Living Will" <?php if(in_array("Living Will",$oasis_patient_history_advance_directives)) echo "checked"; ?> ><?php xl('Living Will','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Organ Donor" <?php if(in_array("Organ Donor",$oasis_patient_history_advance_directives)) echo "checked"; ?> ><?php xl('Organ Donor','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Funeral arrangements made" <?php if(in_array("Funeral arrangements made",$oasis_patient_history_advance_directives)) echo "checked"; ?> ><?php xl('Funeral arrangements made','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Education needed" <?php if(in_array("Education needed",$oasis_patient_history_advance_directives)) echo "checked"; ?> ><?php xl('Education needed','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Durable Power of Attorney" <?php if(in_array("Durable Power of Attorney",$oasis_patient_history_advance_directives)) echo "checked"; ?> ><?php xl('Durable Power of Attorney (DPOA)','e')?></label><br>
					</td>
				</tr>
			</table>
			
			<br>
			<b><?php xl('Patient/Family informed:','e')?></b>
				<label><input type="radio" name="oasis_patient_history_family_informed" value="Yes" <?php if($obj{"oasis_patient_history_family_informed"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
				<label><input type="radio" name="oasis_patient_history_family_informed" value="No" <?php if($obj{"oasis_patient_history_family_informed"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
			<b><?php xl('(If No, please explain.)','e')?></b>
				<textarea name="oasis_patient_history_family_informed_no" rows="3" style="width:100%;"><?php echo $obj{"oasis_patient_history_family_informed_no"};?></textarea>
				
			<br><br>
			<hr>
			<?php xl('<b><u>(M1032)</u> Risk for Hospitalization:</b> Which of the following signs or symptoms characterize this patient as at risk for hospitalization? <b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="1" <?php if(in_array("1",$oasis_patient_history_risk_hospitalization)) echo "checked"; ?> ><?php xl(' 1 - Recent decline in mental, emotional, or behavioral status','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="2" <?php if(in_array("2",$oasis_patient_history_risk_hospitalization)) echo "checked"; ?> ><?php xl(' 2 - Multiple hospitalizations (2 or more) in the past 12 months','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="3" <?php if(in_array("3",$oasis_patient_history_risk_hospitalization)) echo "checked"; ?> ><?php xl(' 3 - History of falls (2 or more falls - or any fall with an injury - in the past year)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="4" <?php if(in_array("4",$oasis_patient_history_risk_hospitalization)) echo "checked"; ?> ><?php xl(' 4 - Taking five or more medications','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="5" <?php if(in_array("5",$oasis_patient_history_risk_hospitalization)) echo "checked"; ?> ><?php xl(' 5 - Frailty indicators, e.g., weight loss, self-reported exhaustion','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="6" <?php if(in_array("6",$oasis_patient_history_risk_hospitalization)) echo "checked"; ?> ><?php xl(' 6 - Other','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="7" <?php if(in_array("7",$oasis_patient_history_risk_hospitalization)) echo "checked"; ?> ><?php xl(' 7 - None of the above','e')?></label><br>
			
		</td>
		<td valign="top">
			<strong><?php xl('PERTINENT HISTORY AND/OR PREVIOUS OUTCOMES (note dates of onset, exacerbation when known)','e');?></strong><br>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Hypertension" <?php if(in_array("Hypertension",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Hypertension','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Respiratory" <?php if(in_array("Respiratory",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Respiratory','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Cancer" <?php if(in_array("Cancer",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Cancer','e')?></label><br>
							<?php xl('(site:','e');?>
							<input type="text" name="oasis_patient_history_previous_outcome_cancer" size="5" value="<?php echo $obj{"oasis_patient_history_previous_outcome_cancer"};?>">
							<?php xl(')','e');?><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Open Wound" <?php if(in_array("Open Wound",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Open Wound','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Cardiac" <?php if(in_array("Cardiac",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Cardiac','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Osteoporosis" <?php if(in_array("Osteoporosis",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Osteoporosis','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Infection" <?php if(in_array("Infection",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Infection','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Surgeries" <?php if(in_array("Surgeries",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Surgeries','e')?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Diabetes" <?php if(in_array("Diabetes",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Diabetes','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Fractures" <?php if(in_array("Fractures",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Fractures','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Immunosuppressed" <?php if(in_array("Immunosuppressed",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Immunosuppressed','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Other" <?php if(in_array("Other",$oasis_patient_history_previous_outcome)) echo "checked"; ?> ><?php xl(' Other','e')?></label>
							<?php xl('(specify)','e');?><br>
							<input type="text" name="oasis_patient_history_previous_outcome_other" value="<?php echo $obj{"oasis_patient_history_previous_outcome_other"};?>">
						
					</td>
				</tr>
			</table>
			
			<br>
			<hr>
			<strong><?php xl('PRIOR HOSPITALIZATIONS','e');?></strong><br>
				<label><input type="radio" name="oasis_patient_history_prior_hospitalization" value="No" <?php if($obj{"oasis_patient_history_prior_hospitalization"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label>
				<label><input type="radio" name="oasis_patient_history_prior_hospitalization" value="Yes" <?php if($obj{"oasis_patient_history_prior_hospitalization"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>&nbsp;&nbsp;&nbsp;
			<?php xl('Number of times','e');?>
			<input type="text" name="oasis_patient_history_prior_hospitalization_no" value="<?php echo $obj{"oasis_patient_history_prior_hospitalization_no"};?>"><br>
			<?php xl('Reason(s)/Date(s):','e');?><br>
				<input type="text" name="oasis_patient_history_prior_hospitalization_reason[]" size="40" value="<?php echo $oasis_patient_history_prior_hospitalization_reason[0];?>">
				<input type='text' size='10' name='oasis_patient_history_prior_hospitalization_reason[]' id='oasis_patient_history_prior_hospitalization_reason1' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $oasis_patient_history_prior_hospitalization_reason[1];?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date10a' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_prior_hospitalization_reason1", ifFormat:"%Y-%m-%d", button:"img_curr_date10a"});
					</script><br>
				<input type="text" name="oasis_patient_history_prior_hospitalization_reason[]" size="40" value="<?php echo $oasis_patient_history_prior_hospitalization_reason[2];?>">
				<input type='text' size='10' name='oasis_patient_history_prior_hospitalization_reason[]' id='oasis_patient_history_prior_hospitalization_reason2' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $oasis_patient_history_prior_hospitalization_reason[3];?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date10b' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_prior_hospitalization_reason2", ifFormat:"%Y-%m-%d", button:"img_curr_date10b"});
					</script><br>
				
			<br>
			<hr>
			<strong><?php xl('IMMUNIZATIONS','e');?></strong>
				<label><input type="checkbox" name="oasis_patient_history_immunizations" value="Up to date" <?php if($obj{"oasis_patient_history_immunizations"}=="Up to date"){echo "checked";}?> ><?php xl('Up to date','e')?></label><br>
			<?php xl('<b>Needs:</b>','e');?>
				<label><input type="checkbox" name="oasis_patient_history_immunizations_needs[]" value="Influenza" <?php if(in_array("Influenza",$oasis_patient_history_immunizations_needs)) echo "checked"; ?> ><?php xl('Influenza','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_immunizations_needs[]" value="Pneumonia" <?php if(in_array("Pneumonia",$oasis_patient_history_immunizations_needs)) echo "checked"; ?> ><?php xl('Pneumonia','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_immunizations_needs[]" value="Tetanus" <?php if(in_array("Tetanus",$oasis_patient_history_immunizations_needs)) echo "checked"; ?> ><?php xl('Tetanus','e')?></label><br>
				<label><input type="checkbox" name="oasis_patient_history_immunizations_needs[]" value="Other" <?php if(in_array("Other",$oasis_patient_history_immunizations_needs)) echo "checked"; ?> ><?php xl('Other','e')?></label>
					<input type="text" name="oasis_patient_history_immunizations_needs_other" value="<?php echo $obj{"oasis_patient_history_immunizations_needs_other"};?>"><br>
					
			<br>
			<center><strong><?php xl('ALLERGIES','e');?></strong></center>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="NKDA" <?php if(in_array("NKDA",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' NKDA','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Penicillin" <?php if(in_array("Penicillin",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' Penicillin','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Sulfa" <?php if(in_array("Sulfa",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' Sulfa','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Aspirin" <?php if(in_array("Aspirin",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' Aspirin','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Milk Products" <?php if(in_array("Milk Products",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' Milk Products','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Pollen" <?php if(in_array("Pollen",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' Pollen','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Insect Bites" <?php if(in_array("Insect Bites",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' Insect Bites','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Eggs" <?php if(in_array("Eggs",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' Eggs','e')?></label><br>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Other" <?php if(in_array("Other",$oasis_patient_history_allergies)) echo "checked"; ?> ><?php xl(' Other:','e')?></label>
					<input type="text" name="oasis_patient_history_allergies_other" value="<?php echo $obj{"oasis_patient_history_allergies_other"};?>"><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1034)</u> Overall Status:</b> Which description best fits the patient\'s overall status? <b>(Check one)</b>','e');?><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="0" <?php if($obj{"oasis_patient_history_overall_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - The patient is stable with no heightened risk(s) for serious complications and death (beyond those typical of the patient\'s age). ','e')?></label><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="1" <?php if($obj{"oasis_patient_history_overall_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - The patient is temporarily facing high health risk(s) but is likely to return to being stable without heightened risk(s) for serious complications and death (beyond those typical of the patient\'s age). ','e')?></label><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="2" <?php if($obj{"oasis_patient_history_overall_status"}=="2"){echo "checked";}?> ><?php xl(' 2 - The patient is likely to remain in fragile health and have ongoing high risk(s) of serious complications and death. ','e')?></label><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="3" <?php if($obj{"oasis_patient_history_overall_status"}=="3"){echo "checked";}?> ><?php xl(' 3 - The patient has serious progressive conditions that could lead to death within a year. ','e')?></label><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="UK" <?php if($obj{"oasis_patient_history_overall_status"}=="UK"){echo "checked";}?> ><?php xl(' UK - The patient\'s situation is unknown or unclear. ','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1036)</u> Risk Factors,</b> either present or past, likely to affect current health status and/or outcome: <b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="1" <?php if(in_array("1",$oasis_patient_history_risk_factors)) echo "checked"; ?> ><?php xl(' 1 - Smoking','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="2" <?php if(in_array("2",$oasis_patient_history_risk_factors)) echo "checked"; ?> ><?php xl(' 2 - Obesity','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="3" <?php if(in_array("3",$oasis_patient_history_risk_factors)) echo "checked"; ?> ><?php xl(' 3 - Alcohol dependency','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="4" <?php if(in_array("4",$oasis_patient_history_risk_factors)) echo "checked"; ?> ><?php xl(' 4 - Drug dependency','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="5" <?php if(in_array("5",$oasis_patient_history_risk_factors)) echo "checked"; ?> ><?php xl(' 5 - None of the above','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="UK" <?php if(in_array("UK",$oasis_patient_history_risk_factors)) echo "checked"; ?> ><?php xl(' UK - Unknown','e')?></label><br>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Safety measures, Living Arrangements, Safety & Sanitation Hazards</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td valign="top" width="50%">
			<center><strong><?php xl("SAFETY MEASURES","e");?></strong></center>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="911 Protocol" <?php if(in_array("911 Protocol",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('911 Protocol','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Clear Pathways" <?php if(in_array("Clear Pathways",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Clear Pathways','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Siderails up" <?php if(in_array("Siderails up",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Siderails up','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Safe Transfers" <?php if(in_array("Safe Transfers",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Safe Transfers','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Equipment Safety" <?php if(in_array("Equipment Safety",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Equipment Safety','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Infection Control Measures" <?php if(in_array("Infection Control Measures",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Infection Control Measures','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Bleeding Precautions" <?php if(in_array("Bleeding Precautions",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Bleeding Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Fall Precautions" <?php if(in_array("Fall Precautions",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Fall Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Seizure Precautions" <?php if(in_array("Seizure Precautions",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Seizure Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Universal Precautions" <?php if(in_array("Universal Precautions",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Universal Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Other" <?php if(in_array("Other",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
							<input type="text" name="oasis_therapy_safety_measures_other" value="<?php echo $obj{"oasis_therapy_safety_measures_other"};?>"><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Hazard-Free Environment" <?php if(in_array("Hazard-Free Environment",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Hazard-Free Environment','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Lock W/C with transfers" <?php if(in_array("Lock W/C with transfers",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Lock W/C with transfers','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Elevate Head of Bed" <?php if(in_array("Elevate Head of Bed",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Elevate Head of Bed','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Medication Safety/Storage" <?php if(in_array("Medication Safety/Storage",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Medication Safety/Storage','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Hazardous Waste Disposal" <?php if(in_array("Hazardous Waste Disposal",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Hazardous Waste Disposal','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="24 hr. supervision" <?php if(in_array("24 hr. supervision",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('24 hr. supervision','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Neutropenic" <?php if(in_array("Neutropenic",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Neutropenic','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="O2 Precautions" <?php if(in_array("O2 Precautions",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('O2 Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Aspiration Precautions" <?php if(in_array("Aspiration Precautions",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Aspiration Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Walker/Cane" <?php if(in_array("Walker/Cane",$oasis_therapy_safety_measures)) echo "checked"; ?> ><?php xl('Walker/Cane','e')?></label><br>
					</td>
				</tr>
			</table>
			
			<br><br>
			<center><strong><?php xl("LIVING ARRANGEMENTS","e");?></strong></center>
			<table class="formtable" width="100%" border="1px">
				<tr>
					<td colspan="6">
						<strong><?php xl("<u>(M1100)</u>Patient Living Situation:","e");?></strong> <?php xl("Which of the following best describes the patient's residential circumstance and availability of assistance?","e");?> <strong><?php xl("(Check one box only.)","e");?></strong>
					</td>
				</tr>
				<tr>
					<td valign="middle" rowspan="2">
						<strong><?php xl("Living Arrangement","e");?></strong>
					</td>
					<td valign="middle" align="center" colspan="5">
						<strong><?php xl("Availability of Assistance","e");?></strong>
					</td>
				</tr>
				<tr>
					<td valign="middle" align="center">
						<?php xl("Around the clock","e");?>
					</td>
					<td valign="middle" align="center">
						<?php xl("Regular daytime","e");?>
					</td>
					<td valign="middle" align="center">
						<?php xl("Regular nighttime","e");?>
					</td>
					<td valign="middle" align="center">
						<?php xl("Occasional / short-term assistance","e");?>
					</td>
					<td valign="middle" align="center">
						<?php xl("No assistance available","e");?>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						a.&nbsp;&nbsp;<?php xl("Patient lives alone","e");?>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="01" <?php if($obj{"oasis_living_arrangements_situation"}=="01") echo "checked"; ?> >01</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="02" <?php if($obj{"oasis_living_arrangements_situation"}=="02") echo "checked"; ?> >02</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="03" <?php if($obj{"oasis_living_arrangements_situation"}=="03") echo "checked"; ?> >03</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="04" <?php if($obj{"oasis_living_arrangements_situation"}=="04") echo "checked"; ?> >04</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="05" <?php if($obj{"oasis_living_arrangements_situation"}=="05") echo "checked"; ?> >05</label>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						b.&nbsp;&nbsp;<?php xl("Patient lives with other person(s) in the home","e");?>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="06" <?php if($obj{"oasis_living_arrangements_situation"}=="06") echo "checked"; ?> >06</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="07" <?php if($obj{"oasis_living_arrangements_situation"}=="07") echo "checked"; ?> >07</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="08" <?php if($obj{"oasis_living_arrangements_situation"}=="08") echo "checked"; ?> >08</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="09" <?php if($obj{"oasis_living_arrangements_situation"}=="09") echo "checked"; ?> >09</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="10" <?php if($obj{"oasis_living_arrangements_situation"}=="10") echo "checked"; ?> >10</label>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						c.&nbsp;&nbsp;<?php xl("Patient lives in congregate situation (e.g., assisted living)","e");?>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="11" <?php if($obj{"oasis_living_arrangements_situation"}=="11") echo "checked"; ?> >11</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="12" <?php if($obj{"oasis_living_arrangements_situation"}=="12") echo "checked"; ?> >12</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="13" <?php if($obj{"oasis_living_arrangements_situation"}=="13") echo "checked"; ?> >13</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="14" <?php if($obj{"oasis_living_arrangements_situation"}=="14") echo "checked"; ?> >14</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="15" <?php if($obj{"oasis_living_arrangements_situation"}=="15") echo "checked"; ?> >15</label>
					</td>
				</tr>
			</table>
			
		</td>
		<td>
			<center><strong><?php xl("SAFETY","e");?></strong></center>
			<table class="formtable" width="100%">
				<tr>
					<td colspan="3">
						<strong><?php xl("Emergency planning/fire safety:","e");?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Fire extinguisher","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning1" value="Y" <?php if($obj{"oasis_safety_emergency_planning1"}=="Y") echo "checked"; ?> >Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning1" value="N" <?php if($obj{"oasis_safety_emergency_planning1"}=="N") echo "checked"; ?> >N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Smoke detectors on all levels of home","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning2" value="Y" <?php if($obj{"oasis_safety_emergency_planning2"}=="Y") echo "checked"; ?> >Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning2" value="N" <?php if($obj{"oasis_safety_emergency_planning2"}=="N") echo "checked"; ?> >N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Tested and functioning","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning3" value="Y" <?php if($obj{"oasis_safety_emergency_planning3"}=="Y") echo "checked"; ?> >Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning3" value="N" <?php if($obj{"oasis_safety_emergency_planning3"}=="N") echo "checked"; ?> >N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("More than one exit","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning4" value="Y" <?php if($obj{"oasis_safety_emergency_planning4"}=="Y") echo "checked"; ?> >Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning4" value="N" <?php if($obj{"oasis_safety_emergency_planning4"}=="N") echo "checked"; ?> >N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Plan for exit","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning5" value="Y" <?php if($obj{"oasis_safety_emergency_planning5"}=="Y") echo "checked"; ?> >Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning5" value="N" <?php if($obj{"oasis_safety_emergency_planning5"}=="N") echo "checked"; ?> >N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Plan for power failure","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning6" value="Y" <?php if($obj{"oasis_safety_emergency_planning6"}=="Y") echo "checked"; ?> >Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning6" value="N" <?php if($obj{"oasis_safety_emergency_planning6"}=="N") echo "checked"; ?> >N</label>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<strong><?php xl("Oxygen use:","e");?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Signs posted","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning7" value="Y" <?php if($obj{"oasis_safety_emergency_planning7"}=="Y") echo "checked"; ?> >Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning7" value="N" <?php if($obj{"oasis_safety_emergency_planning7"}=="N") echo "checked"; ?> >N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Handles smoking / flammables safely","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning8" value="Y" <?php if($obj{"oasis_safety_emergency_planning8"}=="Y") echo "checked"; ?> >Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning8" value="N" <?php if($obj{"oasis_safety_emergency_planning8"}=="N") echo "checked"; ?> >N</label>
					</td>
				</tr>
			</table>
			<strong><?php xl("Oxygen back-up:","e");?></strong>
			<label><input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Available" <?php if(in_array("Available",$oasis_safety_oxygen_backup)) echo "checked"; ?> ><?php xl('Available','e')?></label>
			<label><input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Knows how to use" <?php if(in_array("Knows how to use",$oasis_safety_oxygen_backup)) echo "checked"; ?> ><?php xl('Knows how to use','e')?></label>
			<label><input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Electrical / fire safety" <?php if(in_array("Electrical / fire safety",$oasis_safety_oxygen_backup)) echo "checked"; ?> ><?php xl('Electrical / fire safety','e')?></label><br>
			
			<br>
			<strong><?php xl("SAFETY HAZARDS found in the patient's current place of residence: (Mark all that apply.)","e");?></strong>
			<table class="formtable" width="100%">
				<tr>
					<td valign="top">
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="None" <?php if(in_array("None",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('None','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate floor, roof, or windows" <?php if(in_array("Inadequate floor, roof, or windows",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Inadequate floor, roof, or windows','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate lighting" <?php if(in_array("Inadequate lighting",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Inadequate lighting','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="No telephone available and / or unable to use phone" <?php if(in_array("No telephone available and / or unable to use phone",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('No telephone available and / or unable to use phone','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe gas/electrical appliances/outlets" <?php if(in_array("Unsafe gas/electrical appliances/outlets",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Unsafe gas/electrical appliances/outlets','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate heating/cooling/electricity" <?php if(in_array("Inadequate heating/cooling/electricity",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Inadequate heating/cooling/electricity','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate sanitation/plumbing" <?php if(in_array("Inadequate sanitation/plumbing",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Inadequate sanitation/plumbing','e')?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsound structure" <?php if(in_array("Unsound structure",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Unsound structure','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe placement of rugs/cords furniture" <?php if(in_array("Unsafe placement of rugs/cords furniture",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Unsafe placement of rugs/cords furniture','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe functional barriers (i.e., stairs)" <?php if(in_array("Unsafe functional barriers (i.e., stairs)",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Unsafe functional barriers (i.e., stairs)','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe storage of supplies / equipment" <?php if(in_array("Unsafe storage of supplies / equipment",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Unsafe storage of supplies / equipment','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Improperly stored hazardous materials" <?php if(in_array("Improperly stored hazardous materials",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Improperly stored hazardous materials','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Other" <?php if(in_array("Other",$oasis_safety_hazards)) echo "checked"; ?> ><?php xl('Other (specify)','e')?></label>
							<input type="text" name="oasis_safety_hazards_other" value="<?php echo $obj{"oasis_safety_hazards_other"};?>"><br>
					</td>
				</tr>
			</table>
			<br>
			<center><strong><?php xl("SANITATION HAZARDS","e");?></strong></center>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="None" <?php if(in_array("None",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('None','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate/improper food storage" <?php if(in_array("Inadequate/improper food storage",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('Inadequate/improper food storage','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate cooking refrigeration" <?php if(in_array("Inadequate cooking refrigeration",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('Inadequate cooking refrigeration','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate running water" <?php if(in_array("Inadequate running water",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('Inadequate running water','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Cluttered/soiled living room" <?php if(in_array("Cluttered/soiled living room",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('Cluttered/soiled living room','e')?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate toileting facility" <?php if(in_array("Inadequate toileting facility",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('Inadequate toileting facility','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate sewage" <?php if(in_array("Inadequate sewage",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('Inadequate sewage','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="No scheduled trash removal" <?php if(in_array("No scheduled trash removal",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('No scheduled trash removal','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Insects/rodents present" <?php if(in_array("Insects/rodents present",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('Insects/rodents present','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Other" <?php if(in_array("Other",$oasis_sanitation_hazards)) echo "checked"; ?> ><?php xl('Other','e')?></label>
							<input type="text" name="oasis_sanitation_hazards_other" value="<?php echo $obj{"oasis_sanitation_hazards_other"};?>"><br>
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
			<div><a href="#" id="black">Primary Caregiver</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("PRIMARY CAREGIVER","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong><?php xl("Name:","e");?></strong>
			<input type="text" name="oasis_primary_caregiver_name" value="<?php echo $obj{"oasis_primary_caregiver_name"};?>"><br>
			<strong><?php xl("Relationship:","e");?></strong>
			<input type="text" name="oasis_primary_caregiver_relationship" value="<?php echo $obj{"oasis_primary_caregiver_relationship"};?>"><br>
			<strong><?php xl("Phone Number (if different from patient) - ","e");?></strong>
			<input type="text" name="oasis_primary_caregiver_phone" value="<?php echo $obj{"oasis_primary_caregiver_phone"};?>"><br>
		</td>
		<td>
			<strong><?php xl("Language spoken:","e");?></strong>
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="English" <?php if(in_array("English",$oasis_primary_caregiver_language)) echo "checked"; ?> ><?php xl('English','e')?></label>
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="Spanish" <?php if(in_array("Spanish",$oasis_primary_caregiver_language)) echo "checked"; ?> ><?php xl('Spanish','e')?></label>
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="Russian" <?php if(in_array("Russian",$oasis_primary_caregiver_language)) echo "checked"; ?> ><?php xl('Russian','e')?></label><br>
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="Other" <?php if(in_array("Other",$oasis_primary_caregiver_language)) echo "checked"; ?> ><?php xl('Other','e')?></label>
				<input type="text" name="oasis_primary_caregiver_language_other" value="<?php echo $obj{"oasis_primary_caregiver_language_other"};?>"><br>
			<strong><?php xl("Comments:","e");?></strong><br>
			<textarea name="oasis_primary_caregiver_comments" rows="3" style="width:100%;"><?php echo $obj{"oasis_primary_caregiver_comments"};?></textarea><br>
			<strong><?php xl("Able to safely care for patient","e");?></strong>
			<label><input type="radio" name="oasis_primary_caregiver_able_care" value="Yes" <?php if($obj{"oasis_primary_caregiver_able_care"}=="Yes") echo "checked"; ?> >Yes</label>
			<label><input type="radio" name="oasis_primary_caregiver_able_care" value="No" <?php if($obj{"oasis_primary_caregiver_able_care"}=="No") echo "checked"; ?> >No</label><br>
			<strong><?php xl("If No, reason:","e");?></strong>
			<input type="text" name="oasis_primary_caregiver_no_reason" value="<?php echo $obj{"oasis_primary_caregiver_no_reason"};?>">
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Functional Limitations, Sensory Status, Speech</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td width="50%">
			<center><strong><?php xl("FUNCTIONAL LIMITATIONS","e");?></strong></center>
			<table class="formtable" width="100%">
				<tr>
					<td valign="top">
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Amputation" <?php if(in_array("Amputation",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Amputation','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Hearing" <?php if(in_array("Hearing",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Hearing','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Ambulation" <?php if(in_array("Ambulation",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Ambulation','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Dyspnea with Minimal Exertion" <?php if(in_array("Dyspnea with Minimal Exertion",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Dyspnea with Minimal Exertion','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Bowel/Bladder (Incontinence)" <?php if(in_array("Bowel/Bladder (Incontinence)",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Bowel/Bladder <br>(Incontinence)','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Paralysis" <?php if(in_array("Paralysis",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Paralysis','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Speech" <?php if(in_array("Speech",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Speech','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Contracture" <?php if(in_array("Contracture",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Contracture','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Endurance" <?php if(in_array("Endurance",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Endurance','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Legally Blind" <?php if(in_array("Legally Blind",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Legally Blind','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Other" <?php if(in_array("Other",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Other (specify):','e')?></label>
							<input type="text" name="oasis_functional_limitations_other" value="<?php echo $obj{"oasis_functional_limitations_other"};?>">
					</td>
				</tr>
			</table>
			<br>
			<center><strong><?php xl("SENSORY STATUS","e");?></strong></center>
			<center><strong><?php xl("VISION","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_vision_no" value="No" <?php if($obj{"oasis_sensory_status_vision_no"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</center>
			<?php xl('<b><u>(M1200)</u> Vision </b>(with corrective lenses if the patient usually wears them):','e');?><br>
			<label><input type="radio" name="oasis_sensory_status_vision" value="0" <?php if($obj{"oasis_sensory_status_vision"}=="0"){echo "checked";}?> ><?php xl(' 0 - Normal vision: sees adequately in most situations; can see medication labels, newsprint. ','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_vision" value="1" <?php if($obj{"oasis_sensory_status_vision"}=="1"){echo "checked";}?> ><?php xl(' 1 - Partially impaired: cannot see medication labels or newsprint, but <u>can</u> see obstacles in path, and the surrounding layout; can count fingers at arm\'s length. ','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_vision" value="2" <?php if($obj{"oasis_sensory_status_vision"}=="2"){echo "checked";}?> ><?php xl(' 2 - Severely impaired: cannot locate objects without hearing or touching them or patient nonresponsive. ','e')?></label><br>
			<br>
			<hr>
			<table class="formtable" width="100%">
				<tr>
					<td valign="top">
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Glasses" <?php if(in_array("Glasses",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Glasses','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Contacts" <?php if(in_array("Contacts",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Contacts:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_vision_detail_contact[]" value="R" <?php if(in_array("R",$oasis_sensory_status_vision_detail_contact)) echo "checked"; ?> ><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_vision_detail_contact[]" value="L" <?php if(in_array("L",$oasis_sensory_status_vision_detail_contact)) echo "checked"; ?> ><?php xl('L','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Prosthesis" <?php if(in_array("Prosthesis",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Prosthesis:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_vision_detail_prothesis[]" value="R" <?php if(in_array("R",$oasis_sensory_status_vision_detail_prothesis)) echo "checked"; ?> ><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_vision_detail_prothesis[]" value="L" <?php if(in_array("L",$oasis_sensory_status_vision_detail_prothesis)) echo "checked"; ?> ><?php xl('L','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Glaucoma" <?php if(in_array("Glaucoma",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Glaucoma','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Blurred Vision" <?php if(in_array("Blurred Vision",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Blurred Vision','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Infections" <?php if(in_array("Infections",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Infections','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Jaundice" <?php if(in_array("Jaundice",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Jaundice','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Ptosis" <?php if(in_array("Ptosis",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Ptosis','e')?></label><br>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Cataract surgery" <?php if(in_array("Cataract surgery",$oasis_sensory_status_vision_detail)) echo "checked"; ?> ><?php xl('Cataract surgery:','e')?></label>
						<?php xl("Site","e");?>
						<input type="text" name="oasis_sensory_status_vision_site" value="<?php echo $obj{"oasis_sensory_status_vision_site"};?>">
						<?php xl("Date:","e");?>
						<input type='text' size='10' name='oasis_sensory_status_vision_date' id='oasis_sensory_status_vision_date' 
							title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_sensory_status_vision_date"};?> " readonly/> 
							<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
							height='22' id='img_curr_date6e' border='0' alt='[?]'
							style='cursor: pointer; cursor: hand'
							title='<?php xl('Click here to choose a date','e'); ?>'> 
							<script	LANGUAGE="JavaScript">
								Calendar.setup({inputField:"oasis_sensory_status_vision_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6e"});
							</script><br>
						<?php xl("Other(specify)","e");?>
						<textarea name="oasis_sensory_status_vision_detail_other" rows="3" style="width:100%;"><?php echo $obj{"oasis_sensory_status_vision_detail_other"};?></textarea><br>
					</td>
				</tr>
			</table>
			
			<br>
			<hr>
			<center><strong><?php xl("EARS","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_ears_no" value="No" <?php if($obj{"oasis_sensory_status_ears_no"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</center>
			<?php xl('<b><u>(M1210)</u> Ability to hear</b> (with hearing aid or hearing appliance if normally used):','e');?><br>
			<label><input type="radio" name="oasis_sensory_status_hear" value="0" <?php if($obj{"oasis_sensory_status_hear"}=="0"){echo "checked";}?> ><?php xl(' 0 - Adequate: hears normal conversation without difficulty.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_hear" value="1" <?php if($obj{"oasis_sensory_status_hear"}=="1"){echo "checked";}?> ><?php xl(' 1 - Mildly to Moderately Impaired: difficulty hearing in some environments or speaker may need to increase volume or speak distinctly.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_hear" value="2" <?php if($obj{"oasis_sensory_status_hear"}=="2"){echo "checked";}?> ><?php xl(' 2 - Severely Impaired: absence of useful hearing.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_hear" value="UK" <?php if($obj{"oasis_sensory_status_hear"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unable to assess hearing.','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1220)</u> Understanding of Verbal Content</b> in patient\'s own language (with hearing aid or device if used):','e');?><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="0" <?php if($obj{"oasis_sensory_status_understand_verbal"}=="0"){echo "checked";}?> ><?php xl(' 0 - Understands: clear comprehension without cues or repetitions.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="1" <?php if($obj{"oasis_sensory_status_understand_verbal"}=="1"){echo "checked";}?> ><?php xl(' 1 - Usually Understands: understands most conversations, but misses some part/intent of message. Requires cues at times to understand.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="2" <?php if($obj{"oasis_sensory_status_understand_verbal"}=="2"){echo "checked";}?> ><?php xl(' 2 - Sometimes Understands: understands only basic conversations or simple, direct phrases. Frequently requires cues to understand.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="3" <?php if($obj{"oasis_sensory_status_understand_verbal"}=="3"){echo "checked";}?> ><?php xl(' 3 - Rarely/Never Understands','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="UK" <?php if($obj{"oasis_sensory_status_understand_verbal"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unable to assess understanding.','e')?></label><br>
			
			<br>
			<hr>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="HOH" <?php if(in_array("HOH",$oasis_sensory_status_hear_detail)) echo "checked"; ?> ><?php xl('HOH:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_hoh[]" value="R" <?php if(in_array("R",$oasis_sensory_status_hear_detail_hoh)) echo "checked"; ?> ><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_hoh[]" value="L" <?php if(in_array("L",$oasis_sensory_status_hear_detail_hoh)) echo "checked"; ?> ><?php xl('L','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="Vertigo" <?php if(in_array("Vertigo",$oasis_sensory_status_hear_detail)) echo "checked"; ?> ><?php xl('Vertigo:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_vartigo[]" value="R" <?php if(in_array("R",$oasis_sensory_status_hear_detail_vartigo)) echo "checked"; ?> ><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_vartigo[]" value="L" <?php if(in_array("L",$oasis_sensory_status_hear_detail_vartigo)) echo "checked"; ?> ><?php xl('L','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="Deaf" <?php if(in_array("Deaf",$oasis_sensory_status_hear_detail)) echo "checked"; ?> ><?php xl('Deaf:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_deaf[]" value="R" <?php if(in_array("R",$oasis_sensory_status_hear_detail_deaf)) echo "checked"; ?> ><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_deaf[]" value="L" <?php if(in_array("L",$oasis_sensory_status_hear_detail_deaf)) echo "checked"; ?> ><?php xl('L','e')?></label><br>
						
					</td>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="Tinnitus" <?php if(in_array("Tinnitus",$oasis_sensory_status_hear_detail)) echo "checked"; ?> ><?php xl('Tinnitus:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_tinnitus[]" value="R" <?php if(in_array("R",$oasis_sensory_status_hear_detail_tinnitus)) echo "checked"; ?> ><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_tinnitus[]" value="L" <?php if(in_array("L",$oasis_sensory_status_hear_detail_tinnitus)) echo "checked"; ?> ><?php xl('L','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="Hearing aid" <?php if(in_array("Hearing aid",$oasis_sensory_status_hear_detail)) echo "checked"; ?> ><?php xl('Hearing aid:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_aid[]" value="R" <?php if(in_array("R",$oasis_sensory_status_hear_detail_aid)) echo "checked"; ?> ><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_aid[]" value="L" <?php if(in_array("L",$oasis_sensory_status_hear_detail_aid)) echo "checked"; ?> ><?php xl('L','e')?></label><br>
					</td>
				</tr>
			</table>
			<?php xl("Other(specify)","e");?>
			<textarea name="oasis_sensory_status_hear_detail_other" rows="3" style="width:100%;"><?php echo $obj{"oasis_sensory_status_hear_detail_other"};?></textarea><br>
		</td>
		<td valign="top">
			<center><strong><?php xl("MUSCULOSKELETAL","e");?></strong></center>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="No Problem" <?php if(in_array("No Problem",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('No Problem','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Fracture (location)" <?php if(in_array("Fracture (location)",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Fracture (location)','e')?></label>
				<input type="text" name="oasis_sensory_status_musculoskeletal_fracture" value="<?php echo $obj{"oasis_sensory_status_musculoskeletal_fracture"};?>"><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Swollen, painful joints" <?php if(in_array("Swollen, painful joints",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Swollen, painful joints (specify)','e')?></label>
				<input type="text" name="oasis_sensory_status_musculoskeletal_swollen" value="<?php echo $obj{"oasis_sensory_status_musculoskeletal_swollen"};?>"><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Contractures" <?php if(in_array("Contractures",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Contractures:','e')?></label>
				<input type="text" name="oasis_sensory_status_musculoskeletal_contractures" value="<?php echo $obj{"oasis_sensory_status_musculoskeletal_contractures"};?>">
				<?php xl("Joint","e");?>
				<input type="text" name="oasis_sensory_status_musculoskeletal_joint" value="<?php echo $obj{"oasis_sensory_status_musculoskeletal_joint"};?>"><br>
				<?php xl("Location","e");?>
				<input type="text" name="oasis_sensory_status_musculoskeletal_location" value="<?php echo $obj{"oasis_sensory_status_musculoskeletal_location"};?>"><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Atrophy" <?php if(in_array("Atrophy",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Atrophy','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Poor Conditioning" <?php if(in_array("Poor Conditioning",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Poor Conditioning','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Decreased ROM" <?php if(in_array("Decreased ROM",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Decreased ROM','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Paresthesia" <?php if(in_array("Paresthesia",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Paresthesia','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Shuffling/Wide-based gait" <?php if(in_array("Shuffling/Wide-based gait",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Shuffling/Wide-based gait','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Weakness" <?php if(in_array("Weakness",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Weakness','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Amputation" <?php if(in_array("Amputation",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Amputation:','e')?></label><br>
				<?php xl("BK/AK/UE; R/L (specify)","e");?>
				<textarea name="oasis_sensory_status_musculoskeletal_amputation" rows="3" style="width:100%;"><?php echo $obj{"oasis_sensory_status_musculoskeletal_amputation"};?></textarea><br>
			<br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Hemiplegia" <?php if(in_array("Hemiplegia",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Hemiplegia','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Paraplegia" <?php if(in_array("Paraplegia",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Paraplegia','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Quadriplegia" <?php if(in_array("Quadriplegia",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Quadriplegia','e')?></label><br>	
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Other" <?php if(in_array("Other",$oasis_sensory_status_musculoskeletal)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_sensory_status_musculoskeletal_other" value="<?php echo $obj{"oasis_sensory_status_musculoskeletal_other"};?>"><br>
				
			<br>
			<center><strong><?php xl("NOSE","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_nose_no" value="No" <?php if($obj{"oasis_sensory_status_nose_no"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</center>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_nose[]" value="Congestion" <?php if(in_array("Congestion",$oasis_sensory_status_nose)) echo "checked"; ?> ><?php xl('Congestion','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_nose[]" value="Loss of smell" <?php if(in_array("Loss of smell",$oasis_sensory_status_nose)) echo "checked"; ?> ><?php xl('Loss of smell','e')?></label>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_nose[]" value="Epistaxis" <?php if(in_array("Epistaxis",$oasis_sensory_status_nose)) echo "checked"; ?> ><?php xl('Epistaxis','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_nose[]" value="Sinus problem" <?php if(in_array("Sinus problem",$oasis_sensory_status_nose)) echo "checked"; ?> ><?php xl('Sinus problem','e')?></label>
					</td>
				</tr>
			</table>
			<?php xl("Other(specify)","e");?>
			<textarea name="oasis_sensory_status_nose_other" rows="3" style="width:100%;"><?php echo $obj{"oasis_sensory_status_nose_other"};?></textarea><br>
			
			<br>
			<center><strong><?php xl("MOUTH","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_mouth_no" value="No" <?php if($obj{"oasis_sensory_status_mouth_no"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</center>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Dentures" <?php if(in_array("Dentures",$oasis_sensory_status_mouth)) echo "checked"; ?> ><?php xl('Dentures:','e')?></label>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Upper" <?php if(in_array("Upper",$oasis_sensory_status_mouth)) echo "checked"; ?> ><?php xl('Upper','e')?></label>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Lower" <?php if(in_array("Lower",$oasis_sensory_status_mouth)) echo "checked"; ?> ><?php xl('Lower','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Partial" <?php if(in_array("Partial",$oasis_sensory_status_mouth)) echo "checked"; ?> ><?php xl('Partial','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Gingivitis" <?php if(in_array("Gingivitis",$oasis_sensory_status_mouth)) echo "checked"; ?> ><?php xl('Gingivitis','e')?></label>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Masses/Tumors" <?php if(in_array("Masses/Tumors",$oasis_sensory_status_mouth)) echo "checked"; ?> ><?php xl('Masses/Tumors','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Toothache" <?php if(in_array("Toothache",$oasis_sensory_status_mouth)) echo "checked"; ?> ><?php xl('Toothache','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Ulcerations" <?php if(in_array("Ulcerations",$oasis_sensory_status_mouth)) echo "checked"; ?> ><?php xl('Ulcerations','e')?></label>
					</td>
				</tr>
			</table>
			<?php xl("Other(specify)","e");?>
			<textarea name="oasis_sensory_status_mouth_other" rows="3" style="width:100%;"><?php echo $obj{"oasis_sensory_status_mouth_other"};?></textarea><br>
			
			<br>
			<center><strong><?php xl("THROAT","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_throat_no" value="No" <?php if($obj{"oasis_sensory_status_throat_no"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</center>
			<label><input type="checkbox" name="oasis_sensory_status_throat[]" value="Dysphagia" <?php if(in_array("Dysphagia",$oasis_sensory_status_throat)) echo "checked"; ?> ><?php xl('Dysphagia','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_throat[]" value="Hoarseness" <?php if(in_array("Hoarseness",$oasis_sensory_status_throat)) echo "checked"; ?> ><?php xl('Hoarseness','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_throat[]" value="Lesions" <?php if(in_array("Lesions",$oasis_sensory_status_throat)) echo "checked"; ?> ><?php xl('Lesions','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_throat[]" value="Sore throat" <?php if(in_array("Sore throat",$oasis_sensory_status_throat)) echo "checked"; ?> ><?php xl('Sore throat','e')?></label><br>
			<?php xl("Other(specify)","e");?>
			<textarea name="oasis_sensory_status_throat_other" rows="3" style="width:100%;"><?php echo $obj{"oasis_sensory_status_throat_other"};?></textarea><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl("SPEECH","e");?></strong></center>
			<strong><?php xl('<u>(M1230)</u> Speech and Oral (Verbal) Expression of Language (in patient\'s own language):','e');?></strong><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="0" <?php if($obj{"oasis_sensory_status_speech"}=="0"){echo "checked";}?> ><?php xl(' 0 - Expresses complex ideas, feelings, and needs clearly, completely, and easily in all situations with no observable impairment.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="1" <?php if($obj{"oasis_sensory_status_speech"}=="1"){echo "checked";}?> ><?php xl(' 1 - Minimal difficulty in expressing ideas and needs (may take extra time; makes occasional errors in word choice, grammar or speech intelligibility; needs minimal prompting or assistance).','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="2" <?php if($obj{"oasis_sensory_status_speech"}=="2"){echo "checked";}?> ><?php xl(' 2 - Expresses simple ideas or needs with moderate difficulty (needs prompting or assistance, errors in word choice, organization or speech intelligibility). Speaks in phrases or short sentences.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="3" <?php if($obj{"oasis_sensory_status_speech"}=="3"){echo "checked";}?> ><?php xl(' 3 - Has severe difficulty expressing basic ideas or needs and requires maximal assistance or guessing by listener. Speech limited to single words or short phrases.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="4" <?php if($obj{"oasis_sensory_status_speech"}=="4"){echo "checked";}?> ><?php xl(' 4 - <u>Unable</u> to express basic needs even with maximal prompting or assistance but is not comatose or unresponsive (e.g., speech is nonsensical or unintelligible).','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="5" <?php if($obj{"oasis_sensory_status_speech"}=="5"){echo "checked";}?> ><?php xl(' 5 - Patient nonresponsive or unable to speak.','e')?></label><br>
			
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Vital Signs, Height and Weight</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
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
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="<?php echo $oasis_vital_sign_blood_pressure[0];?>" >
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="<?php echo $oasis_vital_sign_blood_pressure[1];?>" >
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Sitting","e");?>
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="<?php echo $oasis_vital_sign_blood_pressure[2];?>" >
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="<?php echo $oasis_vital_sign_blood_pressure[3];?>" >
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Standing","e");?>
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="<?php echo $oasis_vital_sign_blood_pressure[4];?>" >
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="<?php echo $oasis_vital_sign_blood_pressure[5];?>" >
					</td>
				</tr>
			</table>
			
			<strong><?php xl("Temperature: &deg;F","e");?></strong>
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Oral" <?php if($obj{"oasis_vital_sign_temperature"}=="Oral"){echo "checked";}?> ><?php xl(' Oral ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Axillary" <?php if($obj{"oasis_vital_sign_temperature"}=="Axillary"){echo "checked";}?> ><?php xl(' Axillary ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Rectal" <?php if($obj{"oasis_vital_sign_temperature"}=="Rectal"){echo "checked";}?> ><?php xl(' Rectal ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Tympanic" <?php if($obj{"oasis_vital_sign_temperature"}=="Tympanic"){echo "checked";}?> ><?php xl(' Tympanic ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Temporal" <?php if($obj{"oasis_vital_sign_temperature"}=="Temporal"){echo "checked";}?> ><?php xl(' Temporal ','e')?></label> 
			
		</td>
		<td>
			<strong><?php xl("Pulse:","e");?></strong><br>
			<label><input type="radio" name="oasis_vital_sign_pulse" value="At Rest" <?php if($obj{"oasis_vital_sign_pulse"}=="At Rest"){echo "checked";}?> ><?php xl(' At Rest ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_pulse" value="Activity" <?php if($obj{"oasis_vital_sign_pulse"}=="Activity"){echo "checked";}?> ><?php xl(' Activity/Exercise ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_pulse" value="Regular" <?php if($obj{"oasis_vital_sign_pulse"}=="Regular"){echo "checked";}?> ><?php xl(' Regular ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_pulse" value="Irregular" <?php if($obj{"oasis_vital_sign_pulse"}=="Irregular"){echo "checked";}?> ><?php xl(' Irregular ','e')?></label> 
			<br>
				
			<label><input type="checkbox" name="oasis_vital_sign_pulse_type[]" value="Radial" <?php if(in_array("Radial",$oasis_vital_sign_pulse_type)) echo "checked"; ?> ><?php xl(' Radial ','e')?></label> 
			<label><input type="checkbox" name="oasis_vital_sign_pulse_type[]" value="Carotid" <?php if(in_array("Carotid",$oasis_vital_sign_pulse_type)) echo "checked"; ?> ><?php xl(' Carotid ','e')?></label> 
			<label><input type="checkbox" name="oasis_vital_sign_pulse_type[]" value="Apical" <?php if(in_array("Apical",$oasis_vital_sign_pulse_type)) echo "checked"; ?> ><?php xl(' Apical ','e')?></label> 
			<label><input type="checkbox" name="oasis_vital_sign_pulse_type[]" value="Brachial" <?php if(in_array("Brachial",$oasis_vital_sign_pulse_type)) echo "checked"; ?> ><?php xl(' Brachial ','e')?></label> 
			<br><br>			
			<strong><?php xl("Respiratory Rate:","e");?></strong>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_vital_sign_respiratory_rate" value="Normal" <?php if($obj{"oasis_vital_sign_respiratory_rate"}=="Normal"){echo "checked";}?> ><?php xl(' Normal ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_respiratory_rate" value="Cheynes" <?php if($obj{"oasis_vital_sign_respiratory_rate"}=="Cheynes"){echo "checked";}?> ><?php xl(' Cheynes Stokes ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_respiratory_rate" value="Death" <?php if($obj{"oasis_vital_sign_respiratory_rate"}=="Death"){echo "checked";}?> ><?php xl(' Death rattle ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_respiratory_rate" value="Apnea" <?php if($obj{"oasis_vital_sign_respiratory_rate"}=="Apnea"){echo "checked";}?> ><?php xl(' Apnea /sec.','e')?></label> 
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl("HEIGHT AND WEIGHT","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<?php xl("Height:","e");?>
						<input type="text" name="oasis_hw_height" size="5" value="<?php echo $obj{"oasis_hw_height"};?>" >
					</td>
					<td>
						<label><input type="radio" name="oasis_hw_height_detail" value="actual" <?php if($obj{"oasis_hw_height_detail"}=="actual"){echo "checked";}?> ><?php xl(' actual ','e')?></label> <br>
						<label><input type="radio" name="oasis_hw_height_detail" value="reported" <?php if($obj{"oasis_hw_height_detail"}=="reported"){echo "checked";}?> ><?php xl(' reported ','e')?></label> 
					</td>
					<td>
						<?php xl("Weight:","e");?>
						<input type="text" name="oasis_hw_weight" size="5" value="<?php echo $obj{"oasis_hw_weight"};?>" >
					</td>
					<td>
						<label><input type="radio" name="oasis_hw_weight_detail" value="actual" <?php if($obj{"oasis_hw_weight_detail"}=="actual"){echo "checked";}?> ><?php xl(' actual ','e')?></label> <br>
						<label><input type="radio" name="oasis_hw_weight_detail" value="reported" <?php if($obj{"oasis_hw_weight_detail"}=="reported"){echo "checked";}?> ><?php xl(' reported ','e')?></label> 
					</td>
				</tr>
			</table>
		</td>
		<td>
			<?php xl("Any Weight Changes?","e");?>
			<label><input type="radio" name="oasis_hw_weight_change" value="Yes" <?php if($obj{"oasis_hw_weight_change"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label> 
			<label><input type="radio" name="oasis_hw_weight_change" value="No" <?php if($obj{"oasis_hw_weight_change"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
			<?php xl("If yes:","e");?>
			<label><input type="radio" name="oasis_hw_weight_yes" value="Gain" <?php if($obj{"oasis_hw_weight_yes"}=="Gain"){echo "checked";}?> ><?php xl(' Gain ','e')?></label> 
			<label><input type="radio" name="oasis_hw_weight_yes" value="Loss" <?php if($obj{"oasis_hw_weight_yes"}=="Loss"){echo "checked";}?> ><?php xl(' Loss ','e')?></label> 
			<?php xl(" of ","e");?>
			<input type="text" name="oasis_hw_weight_lb" value="<?php echo $obj{"oasis_hw_weight_lb"};?>" >
			<?php xl(" lb. in ","e");?>
			<label><input type="radio" name="oasis_hw_weight_lb_in" value="wk" <?php if($obj{"oasis_hw_weight_lb_in"}=="wk"){echo "checked";}?> ><?php xl(' wk./ ','e')?></label>
			<label><input type="radio" name="oasis_hw_weight_lb_in" value="mo" <?php if($obj{"oasis_hw_weight_lb_in"}=="mo"){echo "checked";}?> ><?php xl(' mo./ ','e')?></label>
			<label><input type="radio" name="oasis_hw_weight_lb_in" value="yr" <?php if($obj{"oasis_hw_weight_lb_in"}=="yr"){echo "checked";}?> ><?php xl(' yr. ','e')?></label><br>
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
		<td colspan="2">
			<center><strong><?php xl("PAIN","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td valign="top" width="40%">
			<?php xl('<b><u>(M1240)</u></b> Has this patient had a formal <b>Pain Assessment</b> using a standardized pain assessment tool (appropriate to the patient\'s ability to communicate the severity of pain)?','e');?><br>
			<label><input type="radio" name="oasis_pain_assessment_tool" value="0" <?php if($obj{"oasis_pain_assessment_tool"}=="0"){echo "checked";}?> ><?php xl(' 0 - No standardized assessment conducted','e')?></label><br>
			<label><input type="radio" name="oasis_pain_assessment_tool" value="1" <?php if($obj{"oasis_pain_assessment_tool"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes, and it does not indicate severe pain','e')?></label><br>
			<label><input type="radio" name="oasis_pain_assessment_tool" value="2" <?php if($obj{"oasis_pain_assessment_tool"}=="2"){echo "checked";}?> ><?php xl(' 2 - Yes, and it indicates severe pain','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1242)</u> Frequency of Pain Interfering</b> with patient\'s activity or movement:','e');?><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="0" <?php if($obj{"oasis_pain_frequency_interfering"}=="0"){echo "checked";}?> ><?php xl(' 0 - Patient has no pain','e')?></label><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="1" <?php if($obj{"oasis_pain_frequency_interfering"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient has pain that does not interfere with activity or movement','e')?></label><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="2" <?php if($obj{"oasis_pain_frequency_interfering"}=="2"){echo "checked";}?> ><?php xl(' 2 - Less often than daily','e')?></label><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="3" <?php if($obj{"oasis_pain_frequency_interfering"}=="3"){echo "checked";}?> ><?php xl(' 3 - Daily, but not constantly','e')?></label><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="4" <?php if($obj{"oasis_pain_frequency_interfering"}=="4"){echo "checked";}?> ><?php xl(' 4 - All of the time','e')?></label><br>
			
		</td>
		<td>
			<table border="0" cellspacing="0" class="formtable">
				<tr>
					<td colspan="2">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_0.png" border="0" onclick="select_pain(0)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_2.png" border="0" onclick="select_pain(1)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_4.png" border="0" onclick="select_pain(2)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_6.png" border="0" onclick="select_pain(3)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_8.png" border="0" onclick="select_pain(4)">
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_10.png" border="0" onclick="select_pain(5)">
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
	<tr>
		<td>
			<b><?php xl('Is patient experiencing pain?','e')?></b>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_experiencing_pain" value="Yes" <?php if($obj{"oasis_therapy_experiencing_pain"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_experiencing_pain" value="No" <?php if($obj{"oasis_therapy_experiencing_pain"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_unable_to_communicate" value="Yes" <?php if($obj{"oasis_therapy_unable_to_communicate"}=="Yes"){echo "checked";}?> ><?php xl('Unable to communicate','e')?></label><br>
			
			<b><?php xl('Non-verbals demonstrated: ','e')?></b>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Diaphoresis","e");?>" <?php if(in_array("Diaphoresis",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Diaphoresis','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Grimacing","e");?>" <?php if(in_array("Grimacing",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Grimacing','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Moaning/Crying","e");?>" <?php if(in_array("Moaning/Crying",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Moaning/Crying','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Guarding","e");?>" <?php if(in_array("Guarding",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Guarding','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Irritability","e");?>" <?php if(in_array("Irritability",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Irritability','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Anger","e");?>" <?php if(in_array("Anger",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Anger','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Tense","e");?>" <?php if(in_array("Tense",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Tense','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Restlessness","e");?>" <?php if(in_array("Restlessness",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Restlessness','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Change in vital signs","e");?>" <?php if(in_array("Change in vital signs",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Change in vital signs','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Other","e");?>" <?php if(in_array("Other",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_therapy_non_verbal_demonstrated_other" value="<?php echo $obj{"oasis_therapy_non_verbal_demonstrated_other"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Self-assessment","e");?>" <?php if(in_array("Self-assessment",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Self-assessment','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Implications","e");?>" <?php if(in_array("Implications",$oasis_therapy_non_verbal_demonstrated)) echo "checked"; ?> ><?php xl('Implications:','e')?></label>
			<input type="text" name="oasis_therapy_non_verbal_demonstrated_implications" value="<?php echo $obj{"oasis_therapy_non_verbal_demonstrated_implications"};?>">
		</td>
		<td valign="top">
			<b><?php xl('How often is breakthrough medication needed? ','e')?></b><br>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Never","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="Never"){echo "checked";}?> ><?php xl('Never','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Less than daily","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="Less than daily"){echo "checked";}?> ><?php xl('Less than daily','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("2-3 times/day","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="2-3 times/day"){echo "checked";}?> ><?php xl('2-3 times/day','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("More than 3 times/day","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="More than 3 times/day"){echo "checked";}?> ><?php xl('More than 3 times/day','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Current adequate","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="Current adequate"){echo "checked";}?> ><?php xl('Current pain control medications adequate','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("other","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="other"){echo "checked";}?> ><?php xl('other:','e')?></label>
			<input type="text" name="oasis_therapy_breakthrough_medication_other" value="<?php echo $obj{"oasis_therapy_breakthrough_medication_other"};?>"><br>
			
			<b><?php xl('Implications Care Plan:','e')?></b>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_implications_care_plan" value="Yes" <?php if($obj{"oasis_therapy_implications_care_plan"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_implications_care_plan" value="No" <?php if($obj{"oasis_therapy_implications_care_plan"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
		</td>
		
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Fall Risk Assessment, Timed Up And Go Test</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
				
			<table class="formtable" border="1px">
				<tr>
					<td colspan="2">
						<center><strong><?php xl("FALL RISK ASSESSMENT","e");?></strong></center>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Required Core Elements. Assess one point for each core element 'yes'","e");?>
					</td>
					<td>
						<strong><?php xl("Points","e");?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Age 65+</b>","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Age 65+" <?php if(in_array("Age 65+",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Diagnosis (3 or more co-existing) :</b> Assess for hypotension","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Diagnosis" <?php if(in_array("Diagnosis",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Prior History of fall within 3 months :</b> Fall Definition, 'An unintentional change in position resulting in coming to rest on the ground at a lower level.'","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Prior History of fall within 3 months" <?php if(in_array("Prior History of fall within 3 months",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Incontinence :</b> Inability to make it to the bathroom or commode in timely manner. Includes frequency, urgency, and/or nocturia","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Incontinence" <?php if(in_array("Incontinence",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Visual impairment :</b> Includes macular degeneration, diabetic retinopathies, visual field loss, age related changes, decline in visual acuity, accommodation, glare tolerance, depth perception, and night vision or not wearing prescribed glasses or having the correct prescription.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Visual impairment" <?php if(in_array("Visual impairment",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Impaired functional mobility :</b> May include patients who need help with IADLS or ADLS or have gait or transfer problems, arthritis, pain, fear of falling, foot problems, impaired sensation, impaired coordination or improper use of assistive devices.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Impaired functional mobility" <?php if(in_array("Impaired functional mobility",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Environmental hazards :</b> May include poor illumination, equipment tubing, inappropriate footwear, pets, hard to reach items, floor surfaces that are uneven or cluttered, or outdoor entry and exits.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Environmental hazards" <?php if(in_array("Environmental hazards",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Poly Pharmacy (4 or more prescriptions) :</b> Drugs highly associated with fall risk include but not limited to, sedatives, anti-depressants, tranquilizers, narcotics, antihypertensives, cardiac meds, corticosteroids, anti-anxiety drugs, anticholinergic drugs, and hypoglycemic drugs.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Poly Pharmacy" <?php if(in_array("Poly Pharmacy",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Pain affecting level of function :</b> Pain often affects an individual's desire or ability to move or pain can be a factor in depression or compliance with safety recommendations.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Pain affecting level of function" <?php if(in_array("Pain affecting level of function",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Cognitive impairment :</b> Could include patients with dementia, Alzheimer's or stroke patients or patients who are confused, use poor judgment, have decreased comprehension, impulsivity, memory deficits. Consider patients ability to adhere to the plan of care.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Cognitive impairment" <?php if(in_array("Cognitive impairment",$oasis_therapy_fall_risk_assessment)) echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td align="right">
						<b><?php xl("A score of 4 or more is considered at risk for falling  &nbsp;&nbsp;&nbsp;&nbsp;Total","e");?></b>
					</td>
					<td>
						<input type="text" name="oasis_therapy_fall_risk_assessment_total" id="oasis_therapy_fall_risk_assessment_total" value="<?php echo $obj{"oasis_therapy_fall_risk_assessment_total"};?>" readonly></label>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<?php xl('<b><u>(M1300)</u> Pressure Ulcer Assessment:</b> Was this patient assessed for <b>Risk of Developing Pressure Ulcers?</b>','e');?></strong><br>
			<label><input type="radio" name="oasis_pressure_ulcer_assessment" value="0" <?php if($obj{"oasis_pressure_ulcer_assessment"}=="0"){echo "checked";}?> ><?php xl(' 0 - No assessment conducted <b><i>[ Go to M1306 ]</i></b>','e')?></label><br>
			<label><input type="radio" name="oasis_pressure_ulcer_assessment" value="1" <?php if($obj{"oasis_pressure_ulcer_assessment"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes, based on an evaluation of clinical factors, e.g., mobility, incontinence, nutrition, etc., without use of standardized tool','e')?></label><br>
			<label><input type="radio" name="oasis_pressure_ulcer_assessment" value="2" <?php if($obj{"oasis_pressure_ulcer_assessment"}=="2"){echo "checked";}?> ><?php xl(' 2 - Yes, using a standardized tool, e.g., Braden, Norton, other','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1302)</u></b> Does this patient have a <b>Risk of Developing Pressure Ulcers?</b>','e');?><br>
			<label><input type="radio" name="oasis_pressure_ulcer_risk" value="0" <?php if($obj{"oasis_pressure_ulcer_risk"}=="0"){echo "checked";}?> ><?php xl(' 0 - No','e')?></label><br>
			<label><input type="radio" name="oasis_pressure_ulcer_risk" value="1" <?php if($obj{"oasis_pressure_ulcer_risk"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1306)</u></b> Does this patient have at least one <b>Unhealed Pressure Ulcer at Stage II or Higher</b> or designated as "unstageable"?','e');?><br>
			<label><input type="radio" name="oasis_pressure_ulcer_unhealed_s2" value="0" <?php if($obj{"oasis_pressure_ulcer_unhealed_s2"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b><i>[ Go to M1322 ]</i></b>','e')?></label><br>
			<label><input type="radio" name="oasis_pressure_ulcer_unhealed_s2" value="1" <?php if($obj{"oasis_pressure_ulcer_unhealed_s2"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes','e')?></label><br>
			
		</td>
		<td>
			<center><strong><?php xl("Timed Up And Go Test","e");?></strong></center><br>
			<strong><?php xl("Instructions for the Therapist:","e");?></strong><br>
			<ul style="display:block;list-style-type:disc;margin-left:30px;">
				<li><?php xl("Ask the patient to sit in a standard armchair. Measure out a distance of 10 feet from the patient & place a marker, for the patient, at this location.","e");?></li>
				<li><?php xl("(STOP the test if the patient is not safe to complete it).","e");?></li>
				<li><?php xl("Perform the test 2 times & average the scores to get the final score.","e");?></li>
			</ul><br>
			<strong><?php xl("Instructions to the Patient:","e");?></strong><br>
			<?php xl("\"On the word 'Go' you are to get up & go & walk at a comfortable & safe pace to the marker, turn & return to the chair & sit down again.\"","e");?>
			<center>
				<?php xl("Trial 1:","e");?><input type="text" name="oasis_therapy_timed_up_trial1" id="oasis_therapy_timed_up_trial1" onkeyup="calc_avg();" value="<?php echo $obj{"oasis_therapy_timed_up_trial1"};?>"><?php xl("Seconds","e");?><br>
				<?php xl("Trial 2:","e");?><input type="text" name="oasis_therapy_timed_up_trial2" id="oasis_therapy_timed_up_trial2" onkeyup="calc_avg();" value="<?php echo $obj{"oasis_therapy_timed_up_trial2"};?>"><?php xl("Seconds","e");?><br>
				<?php xl("Average:","e");?><input type="text" name="oasis_therapy_timed_up_average" id="oasis_therapy_timed_up_average" value="<?php echo $obj{"oasis_therapy_timed_up_average"};?>" readonly><?php xl("Seconds","e");?>
			</center>
			<br>
			<strong><?php xl("Interpretation of Score:","e");?></strong><br>
			<?php xl("less than or equal to 10 seconds = free mobility","e");?><br>
			<?php xl("less than or equal to 14 seconds = decreased risk for falls","e");?><br>
			<?php xl("less than or equal to 20 seconds = patient is mostly independent","e");?><br>
			<?php xl("20 - 29 seconds = moderately impaired/ variable mobility","e");?><br>
			<?php xl("greater than or equal to 30 seconds = significant impaired mobility","e");?><br>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Integumentary Status, Wound Location</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan=2">
			<center><strong><?php xl("INTEGUMENTARY STATUS","e");?></strong></center>
			<?php xl("Mark all applicable conditions listed below:","e");?><br>
			<b><?php xl("Turgor:","e");?></b>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Good","e");?>" <?php if(in_array("Good",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Good','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Poor","e");?>" <?php if(in_array("Poor",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Poor','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Edema","e");?>" <?php if(in_array("Edema",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Edema (specify if not otherwise in assessment)','e')?></label>
				<input type="text" name="oasis_integumentary_status_turgur_edema" value="<?php echo $obj{"oasis_integumentary_status_turgur_edema"};?>"><br>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Itch","e");?>" <?php if(in_array("Itch",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Itch','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Rash","e");?>" <?php if(in_array("Rash",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Rash','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Dry","e");?>" <?php if(in_array("Dry",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Dry','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Scaling","e");?>" <?php if(in_array("Scaling",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Scaling','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Redness","e");?>" <?php if(in_array("Redness",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Redness','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Bruises","e");?>" <?php if(in_array("Bruises",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Bruises','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Ecchymosis","e");?>" <?php if(in_array("Ecchymosis",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Ecchymosis','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Pallor","e");?>" <?php if(in_array("Pallor",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Pallor','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Jaundice","e");?>" <?php if(in_array("Jaundice",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Jaundice','e')?></label><br>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Other","e");?>" <?php if(in_array("Other",$oasis_integumentary_status_turgur)) echo "checked"; ?> ><?php xl('Other (specify)','e')?></label>
				<input type="text" name="oasis_integumentary_status_turgur_other" value="<?php echo $obj{"oasis_integumentary_status_turgur_other"};?>"><br>
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
						<input type="text" name="oasis_therapy_braden_scale_sensory" onkeyup="sum_braden_scale()" id="braden_sensory" value="<?php echo $obj{"oasis_therapy_braden_scale_sensory"};?>">
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
						<input type="text" name="oasis_therapy_braden_scale_moisture" onkeyup="sum_braden_scale()" id="braden_moisture" value="<?php echo $obj{"oasis_therapy_braden_scale_moisture"};?>">
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
						<input type="text" name="oasis_therapy_braden_scale_activity" onkeyup="sum_braden_scale()" id="braden_activity" value="<?php echo $obj{"oasis_therapy_braden_scale_activity"};?>">
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
						<input type="text" name="oasis_therapy_braden_scale_mobility" onkeyup="sum_braden_scale()" id="braden_mobility" value="<?php echo $obj{"oasis_therapy_braden_scale_mobility"};?>">
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
						<input type="text" name="oasis_therapy_braden_scale_nutrition" onkeyup="sum_braden_scale()" id="braden_nutrition" value="<?php echo $obj{"oasis_therapy_braden_scale_nutrition"};?>">
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
					<td align="center">
						&nbsp;
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_braden_scale_friction" onkeyup="sum_braden_scale()" id="braden_friction" value="<?php echo $obj{"oasis_therapy_braden_scale_friction"};?>">
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
					<td width="50%" colspan="2">
						&nbsp;
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
			<?php xl("<b>Directions for M1310, M1312, and M1314:</b> If the patient has one or more unhealed (non-epithelialized) <b>Stage III or IV pressure ulcers, identify the Stage III or IV pressure ulcer with the largest surface dimension (length x width)</b> and record in centimeters. If no Stage III or Stage IV pressure ulcers, go to M1320.","e");?>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<?php xl("<b><u>(M1310)</u> Pressure Ulcer Length:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_length" value="<?php echo $obj{"oasis_therapy_pressure_ulcer_length"};?>"><br>
			<?php xl("Longest length \"head-to-toe\" (cm)","e");?>
		</td>
		<td>
			<?php xl("<b><u>(M1312)</u> Pressure Ulcer Width:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_width" value="<?php echo $obj{"oasis_therapy_pressure_ulcer_width"};?>"><br>
			<?php xl("Width of the same pressure ulcer; greatest width perpendicular to the length (cm)","e");?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php xl("<b><u>(M1314)</u> Pressure Ulcer Depth:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_depth" value="<?php echo $obj{"oasis_therapy_pressure_ulcer_depth"};?>"><br>
			<?php xl("Depth of the same pressure ulcer; from visible surface to the deepest area (cm)","e");?>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('<u>(M1320)</u> Status of Most Problematic (Observable) Pressure Ulcer:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="0" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - Newly epithelialized','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - Fully granulating','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="2"){echo "checked";}?> ><?php xl(' 2 - Early/partial granulation','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="3"){echo "checked";}?> ><?php xl(' 3 - Not healing','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="NA" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="NA"){echo "checked";}?> ><?php xl(' NA - No observable pressure ulcer','e')?></label><br>
		</td>
		<td valign="top">
			<?php xl('<b><u>(M1322)</u>Current Number of Stage I Pressure Ulcers:</b> Intact skin with non-blanchable redness of a localized area usually over a bony prominence. The area may be painful, firm, soft, warmer or cooler as compared to adjacent tissue.','e');?><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="0" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="4" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="4"){echo "checked";}?> ><?php xl(' 4 or more ','e')?></label>
			
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong><?php xl('<u>(M1324)</u> Stage of Most Problematic Unhealed (Observable) Pressure Ulcer:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="1"){echo "checked";}?> ><?php xl(' 1 - Stage I ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="2"){echo "checked";}?> ><?php xl(' 2 - Stage II ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="3"){echo "checked";}?> ><?php xl(' 3 - Stage III ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="4" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="4"){echo "checked";}?> ><?php xl(' 4 - Stage IV ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="NA" <?php if($obj{"oasis_therapy_pressure_ulcer_stage_unhealed"}=="NA"){echo "checked";}?> ><?php xl(' NA - No observable pressure ulcer or unhealed pressure ulcer ','e')?></label><br>
			
			<br>
			<hr>
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
			<center><strong><?php xl('DEFINITION: (M1320, M1330, M1332, M1334)','e');?></strong></center>
			<center><?php xl('WOCN Guidance','e');?></center>
			<ol>
				<li>
					<?php xl('Fully Granulating: Wound bed filled with granulation tissue to the level of the surrounding skin or
						new epithelium; no dead space, no avascular tissue (eschar and/or slough); no signs or symptoms of
						infection; wound edges are open.','e');?>
				</li>
				<li>
					<?php xl('Early/Partial Granulation: Greater than or equal to 25% of the wound bed is covered with granulation
						tissue; there is minimal avascular tissue (eschar and/or slough) (i.e., less than 25% of the wound
						bed is covered with avascular tissue); may have dead space; no signs or symptoms of infection;
						wound edges open.','e');?>
				</li>
				<li>
					<?php xl('Non-healing: Wound with greater than or equal to 25% avascular tissue (eschar and/or slough) or
								signs/symptoms of infection OR clean but non granulating wound bed OR closed/hyperkeratotic
								wound edges OR persistent failure to improve despite appropriate comprehensive wound
								management. Note: A new Stage I pressure ulcer is reported on OASIS as not healing.','e');?>
				</li>
			</ol>
		</td>
		<td>
			<?php xl('<b><u>(M1340)</u></b> Does this patient have a <b>Surgical Wound?</b>','e');?><br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="0" <?php if($obj{"oasis_therapy_surgical_wound"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b><i>[ Go to M1350 ] </i></b>','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="1" <?php if($obj{"oasis_therapy_surgical_wound"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes, patient has at least one (observable) surgical wound ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="2" <?php if($obj{"oasis_therapy_surgical_wound"}=="2"){echo "checked";}?> ><?php xl(' 2 - Surgical wound known but not observable due to non-removable dressing <b><i>[ Go to M1350 ] </i></b>','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('<u>(M1342)</u> Status of Most Problematic (Observable) Surgical Wound:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="0" <?php if($obj{"oasis_therapy_status_surgical_wound"}=="0"){echo "checked";}?> ><?php xl(' 0 - Newly epithelialized ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="1" <?php if($obj{"oasis_therapy_status_surgical_wound"}=="1"){echo "checked";}?> ><?php xl(' 1 - Fully granulating ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="2" <?php if($obj{"oasis_therapy_status_surgical_wound"}=="2"){echo "checked";}?> ><?php xl(' 2 - Early/partial granulation ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="3" <?php if($obj{"oasis_therapy_status_surgical_wound"}=="3"){echo "checked";}?> ><?php xl(' 3 - Not healing ','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1350)</u></b> Does this patient have a <b>Skin Lesion or Open Wound</b>, excluding bowel ostomy, other than those described above <u>that is receiving intervention</u> by the home health agency?','e');?><br>
			<label><input type="radio" name="oasis_therapy_skin_lesion" value="0" <?php if($obj{"oasis_therapy_skin_lesion"}=="0"){echo "checked";}?> ><?php xl(' 0 - No ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_skin_lesion" value="1" <?php if($obj{"oasis_therapy_skin_lesion"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes ','e')?></label><br>
			
			<br>
			<hr>
			<center><strong><?php xl('DEFINITION: (M1340, M1342)','e');?></strong></center>
			<center><?php xl('WOCN Guidance','e');?></center>
			<strong><?php xl('Description/classification of wounds healing by primary intention<br> (i.e., approximated incisions)','e');?></strong>
				<ul style="display:block;list-style-type:disc;margin-left:30px;">
					<li>
						<?php xl('Fully granulating/healing: Incision well-approximated with complete epithelialization of incision; no signs or systems of infection','e');?>
					</li>
					<li>
						<?php xl('Early/partial granulation: Incision well-approximated but not completely epithelialized; no signs or symptoms of infection','e');?>
					</li>
					<li>
						<?php xl('Non-healing: Incisional separation OR incisional necrosis OR signs or symptoms of infection.','e');?>
					</li>
				</ul>
			<br>
			<strong><?php xl('Description/classification of wounds healing by secondary intention<br> (i.e., healing of dehisced wound by granulation, contraction and epithelialization)','e');?></strong>
				<ul style="display:block;list-style-type:disc;margin-left:30px;">
					<li>
						<?php xl('Fully granulating: Wound bed filled with granulation tissue to the level of the surrounding skin or
							new epithelium; no dead space, no avascular tissue (eschar and/or slough); no signs or symptoms of
							infection; wound edges open.','e');?>
					</li>
					<li>
						<?php xl('Early/Partial Granulation: Greater than or equal to 25% of the wound bed is covererd with
							granulation tissue; there is minimal avascular tissue (eschar and/or slough) (i.e. less than 25% of the
							wound bed is covered with avascular tissue); may have dead space; no signs or symptioms of
							infection; wound edges open.','e');?>
					</li>
					<li>
						<?php xl('Non-healing: wound with greater than or equal to 25% avascular tissue (eschar and/or slough) OR
							signs/symptoms of infection OR clean but non-granulating wound bed OR closed/hyperkeratotic
							wound edges or persistent failure to improve despite comprehensive appropriate wound
							management.','e');?>
					</li>
				</ul>
		</td>
	</tr>
	<tr>
		<td>
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
		</td>
		<td>
			<center><strong><?php xl("WOUND LOCATIONS","e");?></strong></center>
			<?php
                /* Create a form object. */
                $c = new C_FormPainMap('oasis_nursing_resumption','bodymap_man.png');
                /* Render a 'new form' page. */
                echo $c->view_action($_GET['id']);
			?>
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
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="<?php echo $oasis_therapy_wound_lesion_location[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="<?php echo $oasis_therapy_wound_lesion_location[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="<?php echo $oasis_therapy_wound_lesion_location[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Type","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="<?php echo $oasis_therapy_wound_lesion_type[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="<?php echo $oasis_therapy_wound_lesion_type[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="<?php echo $oasis_therapy_wound_lesion_type[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Status","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="<?php echo $oasis_therapy_wound_lesion_status[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="<?php echo $oasis_therapy_wound_lesion_status[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="<?php echo $oasis_therapy_wound_lesion_status[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Size (cm)","e");?>
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_length[3];?>">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_width[3];?>">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_depth[3];?>">
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_length[4];?>">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_width[4];?>">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_depth[4];?>">
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_length[5];?>">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_width[5];?>">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="<?php echo $oasis_therapy_wound_lesion_size_depth[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Stage (pressure ulcers only)","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="<?php echo $oasis_therapy_wound_lesion_stage[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="<?php echo $oasis_therapy_wound_lesion_stage[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="<?php echo $oasis_therapy_wound_lesion_stage[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Tunneling/Undermining","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="<?php echo $oasis_therapy_wound_lesion_tunneling[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="<?php echo $oasis_therapy_wound_lesion_tunneling[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="<?php echo $oasis_therapy_wound_lesion_tunneling[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Odor","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="<?php echo $oasis_therapy_wound_lesion_odor[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="<?php echo $oasis_therapy_wound_lesion_odor[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="<?php echo $oasis_therapy_wound_lesion_odor[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Surrounding Skin","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="<?php echo $oasis_therapy_wound_lesion_skin[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="<?php echo $oasis_therapy_wound_lesion_skin[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="<?php echo $oasis_therapy_wound_lesion_skin[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Edema","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="<?php echo $oasis_therapy_wound_lesion_edema[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="<?php echo $oasis_therapy_wound_lesion_edema[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="<?php echo $oasis_therapy_wound_lesion_edema[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Stoma","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="<?php echo $oasis_therapy_wound_lesion_stoma[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="<?php echo $oasis_therapy_wound_lesion_stoma[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="<?php echo $oasis_therapy_wound_lesion_stoma[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Appearance of the Wound Bed","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="<?php echo $oasis_therapy_wound_lesion_appearance[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="<?php echo $oasis_therapy_wound_lesion_appearance[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="<?php echo $oasis_therapy_wound_lesion_appearance[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Drainage Amount","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="<?php echo $oasis_therapy_wound_lesion_drainage[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="<?php echo $oasis_therapy_wound_lesion_drainage[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="<?php echo $oasis_therapy_wound_lesion_drainage[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Color","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="<?php echo $oasis_therapy_wound_lesion_color[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="<?php echo $oasis_therapy_wound_lesion_color[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="<?php echo $oasis_therapy_wound_lesion_color[5];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Consistency","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="<?php echo $oasis_therapy_wound_lesion_consistency[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="<?php echo $oasis_therapy_wound_lesion_consistency[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="<?php echo $oasis_therapy_wound_lesion_consistency[5];?>">
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
			<div><a href="#" id="black">Cardiopulmunary</a> <span id="mod"><a href="#">(Expand)</a></span></div>
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
		<td valign="top"> 
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
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_heart_sounds_pacemaker_date"};?>" readonly/> 
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
				<label><input type="radio" name="oasis_therapy_heart_sounds_capillary" value="<?php xl("<3","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_capillary"}=="<3"){echo "checked";}?> ><?php xl('less than 3 sec','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_capillary" value="<?php xl(">3","e");?>" <?php if($obj{"oasis_therapy_heart_sounds_capillary"}==">3"){echo "checked";}?> ><?php xl('greater than 3 sec','e')?></label><br>
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
			<div><a href="#" id="black">Respiratory Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("RESPIRATORY STATUS","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<strong><?php xl("<u>(M1400)</u>","e");?></strong>
			<?php xl(" When is the patient dyspneic or noticeably ","e");?> 
			<strong><?php xl(" Short of Breath?","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="0" <?php if($obj{"oasis_therapy_respiratory_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - Patient is not short of breath ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="1" <?php if($obj{"oasis_therapy_respiratory_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - When walking more than 20 feet, climbing stairs ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="2" <?php if($obj{"oasis_therapy_respiratory_status"}=="2"){echo "checked";}?> ><?php xl(' 2 - With moderate exertion (e.g., while dressing, using commode or bedpan, walking distances less than 20 feet) ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="3" <?php if($obj{"oasis_therapy_respiratory_status"}=="3"){echo "checked";}?> ><?php xl(' 3 - With minimal exertion (e.g., while eating, talking, or performing other ADLs) or with agitation ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="4" <?php if($obj{"oasis_therapy_respiratory_status"}=="4"){echo "checked";}?> ><?php xl(' 4 - At rest (during day or night) ','e')?></label> <br>
			<br><br>
		</td>
		<td valign="top">
			<strong><?php xl("<b><u>(M1410)</u>Respiratory Treatments</b> utilized at home: <b>(Mark all that apply.)</b>","e");?></strong><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="1" <?php if(in_array("1",$oasis_therapy_respiratory_treatment)) echo "checked"; ?> ><?php xl(' 1 - Oxygen (intermittent or continuous) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="2" <?php if(in_array("2",$oasis_therapy_respiratory_treatment)) echo "checked"; ?> ><?php xl(' 2 - Ventilator (continually or at night) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="3" <?php if(in_array("3",$oasis_therapy_respiratory_treatment)) echo "checked"; ?> ><?php xl(' 3 - Continuous / Bi-level positive airway pressure ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="4" <?php if(in_array("4",$oasis_therapy_respiratory_treatment)) echo "checked"; ?> ><?php xl(' 4 - None of the above ','e')?></label>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Elimination Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("ELIMINATION STATUS","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<?php xl("<b><u>(M1600)</u></b> Has this patient been treated for a <b>Urinary Tract Infection</b> in the past 14 days?","e");?><br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="0" <?php if($obj{"oasis_elimination_status_tract_infection"}=="0"){echo "checked";}?> ><?php xl(' 0 - No ','e')?></label> <br>
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
			
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1620)</u> Bowel Incontinence Frequency:","e");?></strong><br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="0" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="0"){echo "checked";}?> ><?php xl(' 0 - Very rarely or never has bowel incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="1" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="1"){echo "checked";}?> ><?php xl(' 1 - Less than once weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="2" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="2"){echo "checked";}?> ><?php xl(' 2 - One to three times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="3" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="3"){echo "checked";}?> ><?php xl(' 3 - Four to six times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="4" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="4"){echo "checked";}?> ><?php xl(' 4 - On a daily basis ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="5" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="5"){echo "checked";}?> ><?php xl(' 5 - More often than once daily ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="NA" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="NA"){echo "checked";}?> ><?php xl(' NA - Patient has ostomy for bowel elimination ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="UK" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown <b>[Omit "UK" option on FU, DC]</b> ','e')?></label> <br>
			
			<br>
			<hr>
			<?php xl("<b><u>(M1630)</u> Ostomy for Bowel Elimination:</b> Does this patient have an ostomy for bowel elimination that (within the last 14 days): a) was related to an inpatient facility stay, <u>or</u> b) necessitated a change in medical or treatment regimen?","e");?><br>
			<label><input type="radio" name="oasis_elimination_status_ostomy_bowel" value="0" <?php if($obj{"oasis_elimination_status_ostomy_bowel"}=="0"){echo "checked";}?> ><?php xl(' 0 - Patient does not have an ostomy for bowel elimination. ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_ostomy_bowel" value="1" <?php if($obj{"oasis_elimination_status_ostomy_bowel"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient\'s ostomy was <u>not</u> related to an inpatient stay and did <u>not</u> necessitate change in medical or treatment regimen. ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_ostomy_bowel" value="2" <?php if($obj{"oasis_elimination_status_ostomy_bowel"}=="2"){echo "checked";}?> ><?php xl(' 2 - The ostomy <u>was</u> related to an inpatient stay or <u>did</u> necessitate change in medical or treatment regimen. ','e')?></label> <br>
			
		</td>
	</tr>
</table>

			</li>
		</ul>
	</li>
</ul>
<!--<a id="btn_save" href="javascript:void(0)" class="link_submit"><?php xl(' [Save]','e')?></a>-->
<a id="btn_save" href="javascript:top.restoreSession();document.oasis_nursing_resumption.submit();"
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