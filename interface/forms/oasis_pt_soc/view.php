<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: oasis_pt_soc");
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
$formTable = "forms_oasis_pt_soc";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();




?>

<html>
<head>
<title>Oasis Nursing SOC</title>
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
<!--For Form Validaion--><script src="<?php echo $GLOBALS['webroot'] ?>/library/js/form_validation.js" type="text/javascript"></script>
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
var tot=parseInt($("#nutrition_total").val())
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
$obj = formFetch("forms_oasis_pt_soc", $_GET["id"]);
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


$oasis_urinary = explode("#",$obj{"oasis_urinary"});
$oasis_bowels = explode("#",$obj{"oasis_bowels"});
$oasis_abdomen = explode("#",$obj{"oasis_abdomen"});
$oasis_genitalia = explode("#",$obj{"oasis_genitalia"});
$oasis_ng_enteral = explode("#",$obj{"oasis_ng_enteral"});
$oasis_endocrine = explode("#",$obj{"oasis_endocrine"});
$oasis_nutrition_eat_patt1 = explode("#",$obj{"oasis_nutrition_eat_patt1"});
$oasis_neuro_cognitive_symptoms = explode("#",$obj{"oasis_neuro_cognitive_symptoms"});
$oasis_neuro = explode("#",$obj{"oasis_neuro"});
$oasis_mental_status = explode("#",$obj{"oasis_mental_status"});
$oasis_psychosocial = explode("#",$obj{"oasis_psychosocial"});
$oasis_infusion = explode("#",$obj{"oasis_infusion"});
$oasis_activities_permitted = explode("#",$obj{"oasis_activities_permitted"});
$oasis_homebound_status = explode("#",$obj{"oasis_homebound_status"});
$oasis_instructions_materials = explode("#",$obj{"oasis_instructions_materials"});
$oasis_instructions_care_coordinated = explode("#",$obj{"oasis_instructions_care_coordinated"});
$oasis_instructions_copies_located = explode("#",$obj{"oasis_instructions_copies_located"});
$oasis_dme_diabetic = explode("#",$obj{"oasis_dme_diabetic"});
$oasis_dme_iv_supplies = explode("#",$obj{"oasis_dme_iv_supplies"});
$oasis_dme_miscellaneous = explode("#",$obj{"oasis_dme_miscellaneous"});
$oasis_dme_supplies = explode("#",$obj{"oasis_dme_supplies"});
$oasis_discharge_plan = explode("#",$obj{"oasis_discharge_plan"});
$oasis_discharge_plan_detail = explode("#",$obj{"oasis_discharge_plan_detail"});
$oasis_appliances_equipments = explode("#",$obj{"oasis_appliances_equipments"});

$oasis_nutrition_risks = explode("#",$obj{"oasis_nutrition_risks"});
$oasis_neuro_unequaled_pupils = explode("#",$obj{"oasis_neuro_unequaled_pupils"});
$oasis_neuro_dominant_side = explode("#",$obj{"oasis_neuro_dominant_side"});
$oasis_neuro_weakness = explode("#",$obj{"oasis_neuro_weakness"});
$oasis_dme_wound_care = explode("#",$obj{"oasis_dme_wound_care"});
$oasis_dme_urinary = explode("#",$obj{"oasis_dme_urinary"});
$oasis_dme_foley_supplies = explode("#",$obj{"oasis_dme_foley_supplies"});



$oasis_therapy_curr_level_bed_mobility = explode("#",$obj{"oasis_therapy_curr_level_bed_mobility"});
$oasis_therapy_curr_level_transfers = explode("#",$obj{"oasis_therapy_curr_level_transfers"});
$oasis_therapy_curr_level_wheelchair_mobility = explode("#",$obj{"oasis_therapy_curr_level_wheelchair_mobility"});
$oasis_therapy_curr_level_gait = explode("#",$obj{"oasis_therapy_curr_level_gait"});
$oasis_therapy_musculoskeletal_analysis_str_l = explode("#",$obj{"oasis_therapy_musculoskeletal_analysis_str_l"});
$oasis_therapy_musculoskeletal_analysis_str_r = explode("#",$obj{"oasis_therapy_musculoskeletal_analysis_str_r"});
$oasis_therapy_musculoskeletal_analysis_rom_l = explode("#",$obj{"oasis_therapy_musculoskeletal_analysis_rom_l"});
$oasis_therapy_musculoskeletal_analysis_rom_r = explode("#",$obj{"oasis_therapy_musculoskeletal_analysis_rom_r"});
$oasis_therapy_musculoskeletal_analysis_pain_l = explode("#",$obj{"oasis_therapy_musculoskeletal_analysis_pain_l"});
$oasis_therapy_musculoskeletal_analysis_pain_r = explode("#",$obj{"oasis_therapy_musculoskeletal_analysis_pain_r"});
$oasis_therapy_curr_level_risk_factor = explode("#",$obj{"oasis_therapy_curr_level_risk_factor"});





?>



<form method="post"
		action="<?php echo $rootdir;?>/forms/oasis_pt_soc/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="oasis_pt_soc">
		<h3 align="center"><?php xl('OASIS-C PT SOC/ROC','e')?></h3>		
		
		


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
			<ul id="patient_track_info">
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
				<label><input type="radio" name="oasis_patient_patient_gender" id="male" value="Male" <?php if(patientGender("sex")=="Male"){echo "checked";}else{echo " onclick=\"this.checked = false;  $('#female').attr('checked','checked');\"";} ?> ><?php xl('Male','e');?></label>
				<label><input type="radio" name="oasis_patient_patient_gender" id="female" value="Female" <?php if(patientGender("sex")=="Female"){echo "checked";}else{echo " onclick=\"this.checked = false;  $('#male').attr('checked','checked');\"";} ?> ><?php xl('Female','e');?></label>
			
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
				<label><input id="m0100" type="radio" name="oasis_patient_follow_up" value="1" <?php if($obj{"oasis_patient_follow_up"}=="1"){echo "checked";}?> ><?php xl(' 1 - Start of care-further visits planned','e');?></label><br>
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
				<label><input id="m0110" type="radio" name="oasis_patient_episode_timing" value="1" <?php if($obj{"oasis_patient_episode_timing"}=="1"){echo "checked";}?> ><?php xl(' 1 - Early','e');?></label><br>
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
			<ul id="patient_history_diagnosis">
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
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code1" name="oasis_patient_history_ip_code[]" onkeydown="fonChange(this,1,'no')" value="<?php echo $oasis_patient_history_ip_code[0];?>" /><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code2" name="oasis_patient_history_ip_code[]" onkeydown="fonChange(this,1,'no')" value="<?php echo $oasis_patient_history_ip_code[1];?>" /><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code3" name="oasis_patient_history_ip_code[]" onkeydown="fonChange(this,1,'no')" value="<?php echo $oasis_patient_history_ip_code[2];?>" /><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code4" name="oasis_patient_history_ip_code[]" onkeydown="fonChange(this,1,'no')" value="<?php echo $oasis_patient_history_ip_code[3];?>" /><br>
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
							<input id="m1016" type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis1" value="<?php echo $oasis_patient_history_mrd_diagnosis[0]; ?>" />
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
						<?php xl('Complete only if the V-code in Column 2 is reported in place of a case mix diagnosis that is a multiple coding situation (e.g., a manifestation code).','e');?>
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
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="Russian" <?php if(in_array("Russian",$oasis_primary_caregiver_language)) echo "checked"; ?> ><?php xl('Russian','e')?></label>
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
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Paralysis" <?php if(in_array("Paralysis",$oasis_functional_limitations)) echo "checked"; ?> ><?php xl('Paralysis','e')?></label><br>
					</td>
					<td valign="top">
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
			<ul id="fall_risk_assessment">
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
			<label><input id="m1306" type="radio" name="oasis_pressure_ulcer_unhealed_s2" value="0" <?php if($obj{"oasis_pressure_ulcer_unhealed_s2"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b><i>[ Go to M1322 ]</i></b>','e')?></label><br>
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
			<ul id="integumentary_status">
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
			<label><input id="m1320" type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="0" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - Newly epithelialized','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="1" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - Fully granulating','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="2" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="2"){echo "checked";}?> ><?php xl(' 2 - Early/partial granulation','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="3" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="3"){echo "checked";}?> ><?php xl(' 3 - Not healing','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="NA" <?php if($obj{"oasis_therapy_pressure_ulcer_problematic_status"}=="NA"){echo "checked";}?> ><?php xl(' NA - No observable pressure ulcer','e')?></label><br>
		</td>
		<td valign="top">
			<?php xl('<b><u>(M1322)</u>Current Number of Stage I Pressure Ulcers:</b> Intact skin with non-blanchable redness of a localized area usually over a bony prominence. The area may be painful, firm, soft, warmer or cooler as compared to adjacent tissue.','e');?><br>
			<label><input id="m1322" type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="0" <?php if($obj{"oasis_therapy_pressure_ulcer_current_no"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e')?></label>
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
			<label><input id="m1340" type="radio" name="oasis_therapy_surgical_wound" value="0" <?php if($obj{"oasis_therapy_surgical_wound"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b><i>[ Go to M1350 ] </i></b>','e')?></label><br>
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
			<label><input id="m1350" type="radio" name="oasis_therapy_skin_lesion" value="0" <?php if($obj{"oasis_therapy_skin_lesion"}=="0"){echo "checked";}?> ><?php xl(' 0 - No ','e')?></label><br>
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
                $c = new C_FormPainMap('oasis_pt_soc','bodymap_man.png');
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
		<td> 
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
			<ul id="elimination_status">
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
			<strong><?php xl("<u>(M1610)</u> Urinary Incontinence or Urinary Catheter Presence:","e");?></strong><br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="0" <?php if($obj{"oasis_elimination_status_urinary_incontinence"}=="0"){echo "checked";}?> ><?php xl(' 0 - No incontinence or catheter (includes anuria or ostomy for urinary drainage) <b><i>[ Go to M1620 ] </i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="1" <?php if($obj{"oasis_elimination_status_urinary_incontinence"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient is incontinent ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="2" <?php if($obj{"oasis_elimination_status_urinary_incontinence"}=="2"){echo "checked";}?> ><?php xl(' 2 - Patient requires a urinary catheter (i.e., external, indwelling, intermittent, suprapubic) <b><i>[ Go to M1620 ]</i></b> ','e')?></label> <br>
			
			<br>
			<?php xl("<b><u>(M1615)</u> When</b> does <b>Urinary Incontinence</b> occur?","e");?><br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="0" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="0"){echo "checked";}?> ><?php xl(' 0 - Timed-voiding defers incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="1" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="1"){echo "checked";}?> ><?php xl(' 1 - Occasional stress incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="2" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="2"){echo "checked";}?> ><?php xl(' 2 - During the night only ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="3" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="3"){echo "checked";}?> ><?php xl(' 3 - During the day only ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="4" <?php if($obj{"oasis_elimination_status_urinary_incontinence_occur"}=="4"){echo "checked";}?> ><?php xl(' 4 - During the day and night ','e')?></label> <br>
			
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1620)</u> Bowel Incontinence Frequency:","e");?></strong><br>
			<label><input id="m1620" type="radio" name="oasis_elimination_status_bowel_incontinence" value="0" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="0"){echo "checked";}?> ><?php xl(' 0 - Very rarely or never has bowel incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="1" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="1"){echo "checked";}?> ><?php xl(' 1 - Less than once weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="2" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="2"){echo "checked";}?> ><?php xl(' 2 - One to three times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="3" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="3"){echo "checked";}?> ><?php xl(' 3 - Four to six times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="4" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="4"){echo "checked";}?> ><?php xl(' 4 - On a daily basis ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="5" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="5"){echo "checked";}?> ><?php xl(' 5 - More often than once daily ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="NA" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="NA"){echo "checked";}?> ><?php xl(' NA - Patient has ostomy for bowel elimination ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="UK" <?php if($obj{"oasis_elimination_status_bowel_incontinence"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown <b>[Omit "UK" option on FU, DC]</b> ','e')?></label> <br>
			
			<br>
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
	<li>
                    <div><a href="#" id="black">Genitourinary/Urinary, Bowels, Genitalia, Abdomen, Endocrine/Hematology</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>


<!-- *********************  Genitourinary, Bowels, Genitalia, Abdomen, Endocrine   ******************** -->
                        <li>
                  
<table width="100%" border="1" class="formtable">

	<tr valign="top">
		<td width="50%">
		
		<center><strong>
				<?php xl("GENITOURINARY / URINARY","e");?>
				<label><input type="checkbox" name="oasis_urinary_problem" value="No" <?php if($obj{"oasis_urinary_problem"}=="No") echo "checked"; ?> ><?php xl('No Problem','e')?></label>
			</strong></center>
<!-- 			<?php xl("(Check all applicable items)","e");?><br> -->
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Urgency/frequency","e");?>" <?php if(in_array("Urgency/frequency",$oasis_urinary)) echo "checked"; ?> ><?php xl('Urgency/frequency','e')?></label>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Burning/pain","e");?>" <?php if(in_array("Burning/pain",$oasis_urinary)) echo "checked"; ?> ><?php xl('Burning/pain','e')?></label>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Hesitancy","e");?>" <?php if(in_array("Hesitancy",$oasis_urinary)) echo "checked"; ?> ><?php xl('Hesitancy','e')?></label>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Nocturia","e");?>" <?php if(in_array("Nocturia",$oasis_urinary)) echo "checked"; ?> ><?php xl('Nocturia','e')?></label><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Hematuria","e");?>" <?php if(in_array("Hematuria",$oasis_urinary)) echo "checked"; ?> ><?php xl('Hematuria','e')?></label>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Oliguria/anuria","e");?>" <?php if(in_array("Oliguria/anuria",$oasis_urinary)) echo "checked"; ?> ><?php xl('Oliguria/anuria','e')?></label><br />
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Incontinence","e");?>" <?php if(in_array("Incontinence",$oasis_urinary)) echo "checked"; ?> ><?php xl('Incontinence (details if applicable)','e')?></label>
				<input type="text" name="oasis_urinary_incontinence"  value="<?php echo stripslashes($obj{"oasis_urinary_incontinence"});?>" ><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Management Strategies","e");?>" <?php if(in_array("Management Strategies",$oasis_urinary)) echo "checked"; ?> ><?php xl('Management Strategies:','e')?></label>
				<input type="text" name="oasis_urinary_management_strategy"  value="<?php echo stripslashes($obj{"oasis_urinary_management_strategy"});?>" ><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Diapers/other:","e");?>" <?php if(in_array("Diapers/other:",$oasis_urinary)) echo "checked"; ?> ><?php xl('Diapers/other:','e')?></label>
				<input type="text" name="oasis_urinary_diapers_other"  value="<?php echo stripslashes($obj{"oasis_urinary_diapers_other"});?>" ><br>
			<b><?php xl("Color:","e");?></b>
				<label><input type="radio" name="oasis_urinary_color" value="Yellow" <?php if($obj{"oasis_urinary_color"}=="Yellow") echo "checked"; ?> ><?php xl('Yellow/straw','e')?></label>
				<label><input type="radio" name="oasis_urinary_color" value="Amber" <?php if($obj{"oasis_urinary_color"}=="Amber") echo "checked"; ?> ><?php xl('Amber','e')?></label>
				<label><input type="radio" name="oasis_urinary_color" value="Brown" <?php if($obj{"oasis_urinary_color"}=="Brown") echo "checked"; ?> ><?php xl('Brown/gray','e')?></label>
				<label><input type="radio" name="oasis_urinary_color" value="Blood" <?php if($obj{"oasis_urinary_color"}=="Blood") echo "checked"; ?> ><?php xl('Blood-tinged','e')?></label>
				<label><input type="radio" name="oasis_urinary_color" value="Other" <?php if($obj{"oasis_urinary_color"}=="Other") echo "checked"; ?> ><?php xl('Other','e')?></label>
				<input type="text" name="oasis_urinary_color_other"  value="<?php echo stripslashes($obj{"oasis_urinary_color_other"});?>" ><br>
			<b><?php xl("Clarity:","e");?></b>
				<label><input type="radio" name="oasis_urinary_clarity" value="Clear" <?php if($obj{"oasis_urinary_clarity"}=="Clear") echo "checked"; ?> ><?php xl('Clear','e')?></label>
				<label><input type="radio" name="oasis_urinary_clarity" value="Cloudy" <?php if($obj{"oasis_urinary_clarity"}=="Cloudy") echo "checked"; ?> ><?php xl('Cloudy','e')?></label>
				<label><input type="radio" name="oasis_urinary_clarity" value="Sediment" <?php if($obj{"oasis_urinary_clarity"}=="Sediment") echo "checked"; ?> ><?php xl('Sediment/mucous','e')?></label><br>
			<b><?php xl("Odor:","e");?></b>
				<label><input type="radio" name="oasis_urinary_odor" value="Yes" <?php if($obj{"oasis_urinary_odor"}=="Yes") echo "checked"; ?> ><?php xl('Yes','e')?></label>
				<label><input type="radio" name="oasis_urinary_odor" value="No" <?php if($obj{"oasis_urinary_odor"}=="No") echo "checked"; ?> ><?php xl('No','e')?></label><br>
			<?php xl("<b>Urinary Catheter:</b> Type (specify)","e");?>
				<input type="text" name="oasis_urinary_catheter"  value="<?php echo stripslashes($obj{"oasis_urinary_catheter"});?>" ><br>
			<?php xl("Date last changed","e");?><br>
				<label><input type="checkbox" name="oasis_urinary[]" value="Foley inserted" <?php if(in_array("Foley inserted",$oasis_urinary)) echo "checked"; ?> ><?php xl('Foley inserted','e')?></label>
				<input type='text' size='10' name='oasis_urinary_foley_date' id='oasis_urinary_foley_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
						 value="<?php echo stripslashes($obj{"oasis_urinary_foley_date"});?>" 
						readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date1' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_urinary_foley_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
						</script>
				<?php xl("with French Inflated balloon with","e");?>
				<input type="text" name="oasis_urinary_foley_ml"  value="<?php echo stripslashes($obj{"oasis_urinary_foley_ml"});?>" ><?php xl("ml","e");?>&nbsp;&nbsp;
				<label><input type="checkbox" name="oasis_urinary[]" value="without difficulty" <?php if(in_array("without difficulty",$oasis_urinary)) echo "checked"; ?> ><?php xl('without difficulty','e')?></label><br>
			<?php xl("<b>Irrigation solution:</b> Type (specify)","e");?>
				<input type="text" name="oasis_urinary_irrigation_solution"  value="<?php echo stripslashes($obj{"oasis_urinary_irrigation_solution"});?>" ><br>
				<?php xl("Amount","e");?>
				<input type="text" name="oasis_urinary_irrigation_amount"  value="<?php echo stripslashes($obj{"oasis_urinary_irrigation_amount"});?>" >
				<?php xl("ml","e");?>
				<input type="text" name="oasis_urinary_irrigation_ml"  value="<?php echo stripslashes($obj{"oasis_urinary_irrigation_ml"});?>" >
				<?php xl("Frequency","e");?>
				<input type="text" name="oasis_urinary_irrigation_frequency"  value="<?php echo stripslashes($obj{"oasis_urinary_irrigation_frequency"});?>" >
				<?php xl("Returns","e");?>
				<input type="text" name="oasis_urinary_irrigation_returns" value="<?php echo stripslashes($obj{"oasis_urinary_irrigation_returns"});?>" ><br>
			<?php xl("Patient tolerated procedure well","e");?>
				<label><input type="radio" name="oasis_urinary_tolerated_procedure" value="Yes" <?php if($obj{"oasis_urinary_tolerated_procedure"}=="Yes") echo "checked"; ?> ><?php xl('Yes','e')?></label>
				<label><input type="radio" name="oasis_urinary_tolerated_procedure" value="No" <?php if($obj{"oasis_urinary_tolerated_procedure"}=="No") echo "checked"; ?> ><?php xl('No','e')?></label><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="Other" <?php if(in_array("Other",$oasis_urinary)) echo "checked"; ?> ><?php xl('Other (specify)','e')?></label>
				<input type="text" name="oasis_urinary_other"  value="<?php echo stripslashes($obj{"oasis_urinary_other"});?>" ><br>
		
		
		</td>
		<td>
		
		
		<center><strong>
				<?php xl("BOWELS","e");?>
				<label><input type="checkbox" name="oasis_bowels_problem" value="No" <?php if($obj{"oasis_bowels_problem"}=="No") echo "checked"; ?> ><?php xl('No Problem','e')?></label>
			</strong></center>
			<label><input type="checkbox" name="oasis_bowels[]" value="Flatulence" <?php if(in_array("Flatulence",$oasis_bowels)) echo "checked"; ?> ><?php xl('Flatulence','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Constipation/impaction" <?php if(in_array("Constipation/impaction",$oasis_bowels)) echo "checked"; ?> ><?php xl('Constipation/impaction','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Diarrhea" <?php if(in_array("Diarrhea",$oasis_bowels)) echo "checked"; ?> ><?php xl('Diarrhea','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Rectal bleeding" <?php if(in_array("Rectal bleeding",$oasis_bowels)) echo "checked"; ?> ><?php xl('Rectal bleeding','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Hemorrhoids" <?php if(in_array("Hemorrhoids",$oasis_bowels)) echo "checked"; ?> ><?php xl('Hemorrhoids','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Last BM" <?php if(in_array("Last BM",$oasis_bowels)) echo "checked"; ?> ><?php xl('Last BM','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Frequency of stools" <?php if(in_array("Frequency of stools",$oasis_bowels)) echo "checked"; ?> ><?php xl('Frequency of stools','e')?></label>
			<br />
			<?php xl("Bowel regime/program:","e");?>
				<input type="text" name="oasis_bowel_regime"  value="<?php echo stripslashes($obj{"oasis_bowel_regime"});?>" ><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Laxative/Enema use" <?php if(in_array("Laxative/Enema use",$oasis_bowels)) echo "checked"; ?> ><?php xl('Laxative/Enema use:','e')?></label>
				<label><input type="radio" name="oasis_bowels_lexative_enema" value="Daily" <?php if($obj{"oasis_bowels_lexative_enema"}=="Daily") echo "checked"; ?> ><?php xl('Daily','e')?></label>
				<label><input type="radio" name="oasis_bowels_lexative_enema" value="Weekly" <?php if($obj{"oasis_bowels_lexative_enema"}=="Weekly") echo "checked"; ?> ><?php xl('Weekly','e')?></label>
				<label><input type="radio" name="oasis_bowels_lexative_enema" value="Monthly" <?php if($obj{"oasis_bowels_lexative_enema"}=="Monthly") echo "checked"; ?> ><?php xl('Monthly','e')?></label><br>
				<label><input type="radio" name="oasis_bowels_lexative_enema" value="Other" <?php if($obj{"oasis_bowels_lexative_enema"}=="Other") echo "checked"; ?> ><?php xl('Other:','e')?></label>
					<input type="text" name="oasis_bowels_lexative_enema_other"  value="<?php echo stripslashes($obj{"oasis_bowels_lexative_enema_other"});?>" ><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Incontinence" <?php if(in_array("Incontinence",$oasis_bowels)) echo "checked"; ?> ><?php xl('Incontinence (details if applicable)','e')?></label><br>
				<textarea name="oasis_bowels_incontinence" rows="3" style="width:100%;"><?php echo stripslashes($obj{"oasis_bowels_incontinence"});?></textarea><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Diapers/other" <?php if(in_array("Diapers/other",$oasis_bowels)) echo "checked"; ?> ><?php xl('Diapers/other:','e')?></label>
				<input type="text" name="oasis_bowels_diapers_others"  value="<?php echo stripslashes($obj{"oasis_bowels_diapers_others"});?>" ><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Ileostomy/colostomy" <?php if(in_array("Ileostomy/colostomy",$oasis_bowels)) echo "checked"; ?> ><?php xl('Ileostomy/colostomy site (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_bowels_ileostomy_site"><?php echo stripslashes($obj{"oasis_bowels_ileostomy_site"});?></textarea><br>
			<?php xl('Ostomy care managed by:','e')?>
				<label><input type="radio" name="oasis_bowels_ostomy_care" value="Self" <?php if($obj{"oasis_bowels_ostomy_care"}=="Self") echo "checked"; ?> ><?php xl('Self','e')?></label>
				<label><input type="radio" name="oasis_bowels_ostomy_care" value="Caregiver" <?php if($obj{"oasis_bowels_ostomy_care"}=="Caregiver") echo "checked"; ?> ><?php xl('Caregiver','e')?></label><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Other site" <?php if(in_array("Other site",$oasis_bowels)) echo "checked"; ?> ><?php xl('Other site (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_bowels_other_site"><?php echo stripslashes($obj{"oasis_bowels_other_site"});?></textarea><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Urostomy" <?php if(in_array("Urostomy",$oasis_bowels)) echo "checked"; ?> ><?php xl('Urostomy (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_bowels_urostomy"><?php echo stripslashes($obj{"oasis_bowels_urostomy"});?></textarea><br>
				
		
		
		</td>
		

		
	</tr>
	<tr valign="top">
	
	<td>
	<center><strong>
				<?php xl("GENITALIA","e");?>
				<label><input type="checkbox" name="oasis_genitalia_problem" value="No" <?php if($obj{"oasis_genitalia_problem"}=="No") echo "checked"; ?> ><?php xl('No Problem','e')?></label>
			</strong></center>
	
	<label><input type="checkbox" name="oasis_genitalia[]" value="Discharge/Drainage:" <?php if(in_array("Discharge/Drainage:",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Discharge/Drainage:','e')?></label>
	<input type="text" name="oasis_genitalia_discharge"  value="<?php echo stripslashes($obj{"oasis_genitalia_discharge"});?>" ><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Lesions/Blisters/Masses/Cysts" <?php if(in_array("Lesions/Blisters/Masses/Cysts",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Lesions/Blisters/Masses/Cysts','e')?></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Imflammation:" <?php if(in_array("Imflammation:",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Imflammation:','e')?></label>
	<input type="text" name="oasis_genitalia_imflammation"  value="<?php echo stripslashes($obj{"oasis_genitalia_imflammation"});?>" ><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Surgical Alteration:" <?php if(in_array("Surgical Alteration:",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Surgical Alteration:','e')?></label>
	<input type="text" name="oasis_genitalia_surgical_alteration"  value="<?php echo stripslashes($obj{"oasis_genitalia_surgical_alteration"});?>" ><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Prostate Problem:" <?php if(in_array("Prostate Problem:",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Prostate Problem:','e')?></label>
	<input type="text" name="oasis_genitalia_prostate_problem"  value="<?php echo stripslashes($obj{"oasis_genitalia_prostate_problem"});?>" >
		<?php xl('BPH/TURP Date','e')?>
	<input type='text' size='10' name='oasis_genitalia_date' id='oasis_genitalia_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
						 value="<?php echo stripslashes($obj{"oasis_genitalia_date"});?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_genitalia_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
						</script>
	<br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Self-testicular exam" <?php if(in_array("Self-testicular exam",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Self-testicular exam','e')?></label>
	<input type="text" name="oasis_genitalia_self_testicular_exam"  value="<?php echo stripslashes($obj{"oasis_genitalia_self_testicular_exam"});?>" >
	<?php xl('Frequency','e')?>
	<input type="text" name="oasis_genitalia_frequency"  value="<?php echo stripslashes($obj{"oasis_genitalia_frequency"});?>" >
	<br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Menopause" <?php if(in_array("Menopause",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Menopause','e')?></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Hysterectomy Date" <?php if(in_array("Hysterectomy Date",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Hysterectomy Date','e')?></label><br />
	<label><?php xl('Date last PAP','e')?>	
	<input type='text' size='10' name='oasis_genitalia_date_last_PAP' id='oasis_genitalia_date_last_PAP' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
						 value="<?php echo stripslashes($obj{"oasis_genitalia_date_last_PAP"});?>" 
						readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date3' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_genitalia_date_last_PAP", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
						</script>
	</label>
	
	<label><?php xl('Results','e')?><input type="text" name="oasis_genitalia_results"  value="<?php echo stripslashes($obj{"oasis_genitalia_results"});?>" ></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Breast self-exam frequency" <?php if(in_array("Breast self-exam frequency",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Breast self-exam frequency','e')?></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Discharge:R/L" <?php if(in_array("Discharge:R/L",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Discharge:R/L','e')?></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Mastectomy:" <?php if(in_array("Mastectomy:",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Mastectomy:','e')?></label>
	<input type="text" name="oasis_genitalia_mastectomy"  value="<?php echo stripslashes($obj{"oasis_genitalia_mastectomy"});?>" >
	<label><?php xl('R/L Date','e')?>
	<input type='text' size='10' name='oasis_genitalia_rl_date' id='oasis_genitalia_rl_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
						 value="<?php echo stripslashes($obj{"oasis_genitalia_rl_date"});?>" 
						readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date45' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_genitalia_rl_date", ifFormat:"%Y-%m-%d", button:"img_curr_date45"});
						</script></label>
	<br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Other(specify)" <?php if(in_array("Other(specify)",$oasis_genitalia)) echo "checked"; ?> ><?php xl('Other(specify)','e')?></label>
	<input type="text" name="oasis_genitalia_other"  value="<?php echo stripslashes($obj{"oasis_genitalia_other"});?>" >
	</td>


	<td>
	<center><strong>
				<?php xl("ABDOMEN","e");?>
				<label><input type="checkbox" name="oasis_abdomen_problem" value="No" <?php if($obj{"oasis_abdomen_problem"}=="No") echo "checked"; ?> ><?php xl('No Problem','e')?></label>
			</strong></center>
			
			<label><input type="checkbox" name="oasis_abdomen[]" value="Tenderness" <?php if(in_array("Tenderness",$oasis_abdomen)) echo "checked"; ?> ><?php xl('Tenderness','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Pain" <?php if(in_array("Pain",$oasis_abdomen)) echo "checked"; ?> ><?php xl('Pain','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Distention" <?php if(in_array("Distention",$oasis_abdomen)) echo "checked"; ?> ><?php xl('Distention','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Hard" <?php if(in_array("Hard",$oasis_abdomen)) echo "checked"; ?> ><?php xl('Hard','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Soft" <?php if(in_array("Soft",$oasis_abdomen)) echo "checked"; ?> ><?php xl('Soft','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Ascites" <?php if(in_array("Ascites",$oasis_abdomen)) echo "checked"; ?> ><?php xl('Ascites','e')?></label><br />
			<label><input type="checkbox" name="oasis_abdomen[]" value="Abdominal girth" <?php if(in_array("Abdominal girth",$oasis_abdomen)) echo "checked"; ?> ><?php xl('Abdominal girth','e')?></label>
			<input type="text" name="oasis_abdomen_girth_inches"  value="<?php echo stripslashes($obj{"oasis_abdomen_girth_inches"});?>" >
			<?php xl('inches','e')?>
			<br />
			<label><input type="checkbox" name="oasis_abdomen[]" value="Other:" <?php if(in_array("Other:",$oasis_abdomen)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_abdomen_other"  value="<?php echo stripslashes($obj{"oasis_abdomen_other"});?>" ><br />
			
			<?php xl("NG/enteral tube(type,size)","e");?>
			<input type="text" name="oasis_ng_enteral_tube" value="<?php echo stripslashes($obj{"oasis_ng_enteral_tube"});?>" >
			<br />
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="Bowel Sounds:" <?php if(in_array("Bowel Sounds:",$oasis_ng_enteral)) echo "checked"; ?> ><?php xl('Bowel Sounds:','e')?></label>
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="active" <?php if(in_array("active",$oasis_ng_enteral)) echo "checked"; ?> ><?php xl('active','e')?></label>
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="absent" <?php if(in_array("absent",$oasis_ng_enteral)) echo "checked"; ?> ><?php xl('absent','e')?></label>
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="hypo" <?php if(in_array("hypo",$oasis_ng_enteral)) echo "checked"; ?> ><?php xl('hypo','e')?></label>
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="hyperactive x quadrants" <?php if(in_array("hyperactive x quadrants",$oasis_ng_enteral)) echo "checked"; ?> ><?php xl('hyperactive x quadrants','e')?></label><br />
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="Other:" <?php if(in_array("Other:",$oasis_ng_enteral)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_ng_enteral_other"  value="<?php echo stripslashes($obj{"oasis_ng_enteral_other"});?>" ><br />
			<?php xl("(see Enteral Feedings section)","e");?>
			
	</td>
	
	</tr>
	
	<tr>
	<td colspan="2">
	<center><strong>
				<?php xl("ENDOCRINE/HEMATOLOGY","e");?>
				<label><input type="checkbox" name="oasis_endocrine_problem" value="No" <?php if($obj{"oasis_endocrine_problem"}=="No") echo "checked"; ?> ><?php xl('No Problem','e')?></label>
			</strong></center>
	</td>
	</tr>
	
	<tr valign="top">
	<td>
	
	<label><input type="checkbox" name="oasis_endocrine[]" value="The patient has a history of diabetes, thyroid problems, anemia or gastrointestinal bleeding" <?php if(in_array("The patient has a history of diabetes, thyroid problems, anemia or gastrointestinal bleeding",$oasis_endocrine)) echo "checked"; ?> >
	<?php xl('The patient has a history of diabetes, thyroid problems, anemia or gastrointestinal bleeding','e')?></label><br />
	<?php xl('Competence with use of Glucometer<br />(Check all applicable items)','e')?><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Diabetes:" <?php if(in_array("Diabetes:",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Diabetes:','e')?></label>
	<label><input type="radio" name="oasis_endocrine_diabetes" value="Juvenile/Type I" <?php if($obj{"oasis_endocrine_diabetes"}=="Juvenile/Type I") echo "checked"; ?> ><?php xl('Juvenile/Type I','e')?></label>
	<label><input type="radio" name="oasis_endocrine_diabetes" value="Type II" <?php if($obj{"oasis_endocrine_diabetes"}=="Type II") echo "checked"; ?> ><?php xl('Type II','e')?></label><br />
	<?php xl('Onset of diabetes','e')?><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Diet/Oral control (specify)" <?php if(in_array("Diet/Oral control (specify)",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Diet/Oral control (specify)','e')?></label>
	<input type="text" name="oasis_endocrine_diet"  value="<?php echo stripslashes($obj{"oasis_endocrine_diet"});?>" >
	<br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Insulin dose/frequency (specify)" <?php if(in_array("Insulin dose/frequency (specify)",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Insulin dose/frequency (specify)','e')?></label><br />
	<input type="text" name="oasis_endocrine_insulin"  value="<?php echo stripslashes($obj{"oasis_endocrine_insulin"});?>" ><br />
	<?php xl('On insulin since','e')?>
	<input type='text' size='10' name='oasis_endocrine_insulin_since' id='oasis_endocrine_insulin_since' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
						 value="<?php echo stripslashes($obj{"oasis_endocrine_insulin_since"});?>" 
						readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date41' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_endocrine_insulin_since", ifFormat:"%Y-%m-%d", button:"img_curr_date41"});
						</script>
	<br />
	<?php xl('Administered by:','e')?>
	<label><input type="checkbox" name="oasis_endocrine_admin_by" value="Self" <?php if($obj{"oasis_endocrine_admin_by"}=="Self") echo "checked"; ?> ><?php xl('Self','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_admin_by" value="Nurse" <?php if($obj{"oasis_endocrine_admin_by"}=="Nurse") echo "checked"; ?> ><?php xl('Nurse','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_admin_by" value="Caregiver" <?php if($obj{"oasis_endocrine_admin_by"}=="Caregiver") echo "checked"; ?> ><?php xl('Caregiver','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_admin_by" value="Other" <?php if($obj{"oasis_endocrine_admin_by"}=="Other") echo "checked"; ?> ><?php xl('Other','e')?></label>
	<input type="text" name="oasis_endocrine_admin_by_other"  value="<?php echo stripslashes($obj{"oasis_endocrine_admin_by_other"});?>" ><br />
	
	<label><input type="checkbox" name="oasis_endocrine[]" value="Hyperglycemia: Glycosuria/Polyuria/Polydipsia" <?php if(in_array("Hyperglycemia: Glycosuria/Polyuria/Polydipsia",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Hyperglycemia: Glycosuria/Polyuria/Polydipsia','e')?></label><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Hypoglycemia: Sweats/Polyphagia/Weak/Faint/Stupor" <?php if(in_array("Hypoglycemia: Sweats/Polyphagia/Weak/Faint/Stupor",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Hypoglycemia: Sweats/Polyphagia/Weak/Faint/Stupor','e')?></label><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Blood sugar ranges" <?php if(in_array("Blood sugar ranges",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Blood sugar ranges','e')?></label><br />
	<?php xl('Monitored by:','e')?>
	<label><input type="checkbox" name="oasis_endocrine_monitored_by" value="Self" <?php if($obj{"oasis_endocrine_monitored_by"}=="Self") echo "checked"; ?> ><?php xl('Self','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_monitored_by" value="Caregiver" <?php if($obj{"oasis_endocrine_monitored_by"}=="Caregiver") echo "checked"; ?> ><?php xl('Caregiver','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_monitored_by" value="Nurse" <?php if($obj{"oasis_endocrine_monitored_by"}=="Nurse") echo "checked"; ?> ><?php xl('Nurse','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_monitored_by" value="Other" <?php if($obj{"oasis_endocrine_monitored_by"}=="Other") echo "checked"; ?> ><?php xl('Other','e')?></label>
	<input type="text" name="oasis_endocrine_monitored_by_other"  value="<?php echo stripslashes($obj{"oasis_endocrine_monitored_by_other"});?>" ><br />
	<?php xl('Frequency of monitoring','e')?><br />
	<?php xl('Notify physician if blood sugar over ','e')?>
	<input type="text" name="oasis_endocrine_blood_sugar_over"  value="<?php echo stripslashes($obj{"oasis_endocrine_blood_sugar_over"});?>"  size="5">
	<?php xl('and under ','e')?>
	<input type="text" name="oasis_endocrine_blood_sugar_under"  value="<?php echo stripslashes($obj{"oasis_endocrine_blood_sugar_under"});?>"  size="5">
	<?php xl('MG%','e')?><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Patient/Caregiver able to draw up insulin" <?php if(in_array("Patient/Caregiver able to draw up insulin",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Patient/Caregiver able to draw up insulin','e')?></label><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Patient/Caregiver able to administer insulin" <?php if(in_array("Patient/Caregiver able to administer insulin",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Patient/Caregiver able to administer insulin','e')?></label><br />
	
	</td>
	
	<td>
	<label><input type="checkbox" name="oasis_endocrine[]" value="Any diagnosed manifestations (specify):" <?php if(in_array("Any diagnosed manifestations (specify):",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Any diagnosed manifestations (specify):','e')?></label><br />
	
	<?php xl('Renal','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="oasis_endocrine_renal"  value="<?php echo stripslashes($obj{"oasis_endocrine_renal"});?>" ><br />
	<?php xl('Ophthalmic','e')?>&nbsp;&nbsp;<input type="text" name="oasis_endocrine_ophthalmic"  value="<?php echo stripslashes($obj{"oasis_endocrine_ophthalmic"});?>" ><br />
	<?php xl('Neurologic','e')?>&nbsp;&nbsp;&nbsp;<input type="text" name="oasis_endocrine_neurologic"  value="<?php echo stripslashes($obj{"oasis_endocrine_neurologic"});?>" ><br />
	<?php xl('Other','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="oasis_endocrine_other"  value="<?php echo stripslashes($obj{"oasis_endocrine_other"});?>" ><br />
	
	<label><input type="checkbox" name="oasis_endocrine[]" value="Disease Management Problems (Explain)" <?php if(in_array("Disease Management Problems (Explain)",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Disease Management Problems (Explain)','e')?></label>
	<br />
	<input type="text" name="oasis_endocrine_disease_management_problems"  value="<?php echo stripslashes($obj{"oasis_endocrine_disease_management_problems"});?>" size="50"><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Enlarged thyroid" <?php if(in_array("Enlarged thyroid",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Enlarged thyroid','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine[]" value="Fatigue" <?php if(in_array("Fatigue",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Fatigue','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine[]" value="Intolerance to heat/cold" <?php if(in_array("Intolerance to heat/cold",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Intolerance to heat/cold','e')?></label>
	<br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Other:" <?php if(in_array("Other:",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
	<input type="text" name="oasis_endocrine_other1"  value="<?php echo stripslashes($obj{"oasis_endocrine_other1"});?>" ><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Anemia (specify if known)" <?php if(in_array("Anemia (specify if known)",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Anemia (specify if known)','e')?></label>
	<input type="text" name="oasis_endocrine_anemia" value="<?php echo stripslashes($obj{"oasis_endocrine_anemia"});?>" >
	<br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Secondary bleed: GI/GU/GYN/unknown" <?php if(in_array("Secondary bleed: GI/GU/GYN/unknown",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Secondary bleed: GI/GU/GYN/unknown','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine[]" value="Hemophilia" <?php if(in_array("Hemophilia",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Hemophilia','e')?></label>
	<br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Other2:" <?php if(in_array("Other2:",$oasis_endocrine)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
	<input type="text" name="oasis_endocrine_other2"  value="<?php echo stripslashes($obj{"oasis_endocrine_other2"});?>" ><br />
	
	
	</td>
	
	</tr>
	
</table>

                        </li>
                    </ul>
                </li>


<li>
                    <div><a href="#" id="black">Nutritional Status, Nutrition, Neuro/Emotional/Behavioral Status, Mental Status &amp; Psychosocial</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                        <ul>
<!-- *********************  Nutritional Status  ******************** -->
                        <li>


<table width="100%" border="1" class="formtable">

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
<br /><textarea name="oasis_nutrition_eat_patt" rows="2" cols="48"><?php echo stripslashes($obj{"oasis_nutrition_eat_patt"});?></textarea>
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




<label><input type="radio" name="oasis_nutrition_weight_change" value="Gain"  id="oasis_nutrition_weight_change" 
 <?php if($obj{"oasis_nutrition_weight_change"}=="Gain") echo "checked"; ?> />
<?php xl('Gain','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_weight_change" value="Loss"  id="oasis_nutrition_weight_change" 
 <?php if($obj{"oasis_nutrition_weight_change"}=="Loss") echo "checked"; ?> />
<?php xl('Loss','e')?></label> &nbsp;


<input type="text" name="oasis_nutrition_weight_change_value" id="oasis_nutrition_weight_change_value" size="10" 
 value="<?php echo stripslashes($obj{"oasis_nutrition_weight_change_value"});?>" />&nbsp;
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
<center><strong><?php xl('NUTRITIONAL REQUIREMENTS','e')?></strong></center><br />
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
<textarea name="oasis_nutrition_req_other" rows="2" cols="48" >
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
<label><input type="text" name="nutrition_total" id="nutrition_total" size="2" readonly="true"  value="<?php echo stripslashes($obj{"nutrition_total"});?>" /></label>
</td>
</tr>
</TABLE>
<strong><?php xl('INTERPRETATION: 0-2 Good. As appropriate reassess and/or provide information based on situation.','e')?><br />
<?php xl('3-5 Moderate risk. Educate, refer, monitor and reevaluate based on patient situation and organization policy.','e')?><br />
<?php xl('6 or more High risk. Coordinate with physician, dietitian, social service professional or nurse about how to improve nutritional health. Describe at risk intervention:','e')?>
<input type="text" name="oasis_nutrition_describe" id="oasis_nutrition_describe" style="width:95%"  value="<?php echo stripslashes($obj{"oasis_nutrition_describe"});?>"  /><br />
</strong>
</td>
</tr>

<tr>
<td colspan="2">
<center><strong><?php xl('NEURO/EMOTIONAL/BEHAVIORAL STATUS','e')?></strong></center>
</td>
</tr>

<tr valign="top">
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
			<br><hr />
			
			<strong><?php xl("<u>(M1730)</u>","e");?></strong>
			<?php xl("<b>Depression Screening:</b> Has the patient been screened for depression, using a standardized depression screening tool?","e");?> 
			<br />
			<label><input type="radio" name="oasis_neuro_depression_screening" value="0" <?php if($obj{"oasis_neuro_depression_screening"}=="0") echo "checked"; ?> ><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_depression_screening" value="1" <?php if($obj{"oasis_neuro_depression_screening"}=="1") echo "checked"; ?> ><?php xl(' 1 - Yes, patient was screened using the PHQ-2&copy;* scale. (Instructions for this two-question tool: Ask patient: "Over the last two weeks, how often have you been bothered by any of the following problems")','e')?>
				</label> <br>
				
			<table><tr><td>
			    <table width="100%" class="formtable" align="right" border="1" >
			    
			    <tr valign="middle" align="center">
			    <td><strong><?php xl("PHQ-2 &copy;* Pfizer","e");?></strong></td>
			    <td><strong><?php xl("Not at all 0-1 day","e");?></strong></td>
			    <td><strong><?php xl("Several days 2-6 days","e");?></strong></td>
			    <td><strong><?php xl("More than half of the days 7-11 days","e");?></strong></td>
			    <td><strong><?php xl("Nearly every day 12-14 days","e");?></strong></td>
			    <td><strong><?php xl("N/A Unable to respond","e");?></strong></td>
			    </tr>
			    
			    <tr>
			    <td><?php xl("a) Little interest or pleasure in doing things","e");?></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="0" <?php if($obj{"oasis_neuro_little_interest"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="1" <?php if($obj{"oasis_neuro_little_interest"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="2" <?php if($obj{"oasis_neuro_little_interest"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="3" <?php if($obj{"oasis_neuro_little_interest"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="NA" <?php if($obj{"oasis_neuro_little_interest"}=="NA") echo "checked"; ?> ><?php xl(' NA','e')?></label></td>
			    </tr>
			    
			    <tr>
			    <td><?php xl("b) Feeling down, depressed, or hopeless?","e");?></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="0" <?php if($obj{"oasis_neuro_feeling_down"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="1" <?php if($obj{"oasis_neuro_feeling_down"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="2" <?php if($obj{"oasis_neuro_feeling_down"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="3" <?php if($obj{"oasis_neuro_feeling_down"}=="3") echo "checked"; ?> ><?php xl(' 3','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="NA" <?php if($obj{"oasis_neuro_feeling_down"}=="NA") echo "checked"; ?> ><?php xl(' NA','e')?></label></td>
			    </tr>
			    
			    </table>
			    
			</td></tr></table>
			
			
		

			
			
			<br />
			
			<label><input type="radio" name="oasis_neuro_depression_screening" value="2" <?php if($obj{"oasis_neuro_depression_screening"}=="2") echo "checked"; ?> ><?php xl(' 2 - Yes, with a different standardized assessment-and the patient meets criteria for further evaluation for depression.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_depression_screening" value="3" <?php if($obj{"oasis_neuro_depression_screening"}=="3") echo "checked"; ?> ><?php xl(' 3 - Yes, patient was screened with a different standardized assessment-and the patient does not meet criteria for further evaluation for depression.','e')?></label> <br>
			<label><?php xl('* copyright&copy; Pfizer Inc. All rights reserved. Reproduced with permission.','e')?></label> <br>
			<br><hr />
			
			
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
			<br><hr />
			
			<strong><?php xl("<u>(M1750)</u>","e");?></strong>
			<?php xl("Is the patient receiving <strong>Psychiatric Nursing Services</strong> at home provided by a qualified psychiatric nurse?","e");?> 
			<br />
			<label><input type="radio" name="oasis_neuro_psychiatric_nursing" value="0" <?php if($obj{"oasis_neuro_psychiatric_nursing"}=="0") echo "checked"; ?> ><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_psychiatric_nursing" value="1" <?php if($obj{"oasis_neuro_psychiatric_nursing"}=="1") echo "checked"; ?> ><?php xl(' 1 - Yes','e')?></label> <br>

			
			
			
			
			
</td>
<td>
			<label><input type="checkbox" name="oasis_neuro[]" value="Headache:"  id="oasis_neuro"  <?php if(in_array("Headache:",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('Headache:','e')?></label> &nbsp;
			<?php xl('Location','e')?>
			<input type="text" name="oasis_neuro_location"  value="<?php echo stripslashes($obj{"oasis_neuro_location"});?>" />
			<?php xl('Frequency','e')?>
			<input type="text" name="oasis_neuro_frequency"  value="<?php echo stripslashes($obj{"oasis_neuro_frequency"});?>" /><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="PERRLA"  id="oasis_neuro"  <?php if(in_array("PERRLA",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('PERRLA','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Unequal pupils:"  id="oasis_neuro"  <?php if(in_array("Unequal pupils:",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('Unequal pupils:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_unequaled_pupils[]" value="Right"  id="oasis_neuro_unequaled_pupils" <?php if(in_array("Right",$oasis_neuro_unequaled_pupils)) echo "checked"; ?>  />
			<?php xl('Right','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_unequaled_pupils[]" value="Left"  id="oasis_neuro_unequaled_pupils"  <?php if(in_array("Left",$oasis_neuro_unequaled_pupils)) echo "checked"; ?> />
			<?php xl('Left','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Aphasia:"  id="oasis_neuro"  <?php if(in_array("Aphasia:",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('Aphasia:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_aphasia" value="Receptive"  id="oasis_neuro_aphasia" <?php if($obj{"oasis_neuro_aphasia"}=="Receptive") echo "checked"; ?>  />
			<?php xl('Receptive','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_aphasia" value="Expressive"  id="oasis_neuro_aphasia"  <?php if($obj{"oasis_neuro_aphasia"}=="Expressive") echo "checked"; ?> />
			<?php xl('Expressive','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Motor change:"  id="oasis_neuro"  <?php if(in_array("Motor change:",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('Motor change:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_motor_change" value="Fine"  id="oasis_neuro_motor_change"  <?php if($obj{"oasis_neuro_motor_change"}=="Fine") echo "checked"; ?> />
			<?php xl('Fine','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_motor_change" value="Gross Site"  id="oasis_neuro_motor_change"  <?php if($obj{"oasis_neuro_motor_change"}=="Gross Site") echo "checked"; ?> />
			<?php xl('Gross Site','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Dominant side:"  id="oasis_neuro" <?php if(in_array("Dominant side:",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Dominant side:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_dominant_side[]" value="Right"  id="oasis_neuro_dominant_side" <?php if(in_array("Right",$oasis_neuro_dominant_side)) echo "checked"; ?>  />
			<?php xl('Right','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_dominant_side[]" value="Left"  id="oasis_neuro_dominant_side"  <?php if(in_array("Left",$oasis_neuro_dominant_side)) echo "checked"; ?>  />
			<?php xl('Left','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Weakness:"  id="oasis_neuro"  <?php if(in_array("Weakness:",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('Weakness:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_weakness[]" value="UE"  id="oasis_neuro_weakness"  <?php if(in_array("UE",$oasis_neuro_weakness)) echo "checked"; ?>  />
			<?php xl('UE','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_weakness[]" value="LE"  id="oasis_neuro_weakness"  <?php if(in_array("LE",$oasis_neuro_weakness)) echo "checked"; ?>  />
			<?php xl('LE','e')?></label>
			&nbsp;&nbsp;&nbsp;
			<?php xl('Location','e')?>
			<input type="text" name="oasis_neuro_weakness_location"  value="<?php echo stripslashes($obj{"oasis_neuro_weakness_location"});?>" /><br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Tremors:"  id="oasis_neuro"  <?php if(in_array("Tremors:",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('Tremors:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_tremors" value="Fine"  id="oasis_neuro_tremors" <?php if($obj{"oasis_neuro_tremors"}=="Fine") echo "checked"; ?>  />
			<?php xl('Fine','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_tremors" value="Gross"  id="oasis_neuro_tremors"  <?php if($obj{"oasis_neuro_tremors"}=="Gross") echo "checked"; ?> />
			<?php xl('Gross','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_tremors" value="Paralysis"  id="oasis_neuro_tremors" <?php if($obj{"oasis_neuro_tremors"}=="Paralysis") echo "checked"; ?>  />
			<?php xl('Paralysis','e')?></label>
			<br />
			<?php xl('Site','e')?>
			<input type="text" name="oasis_neuro_tremors_site"  value="<?php echo stripslashes($obj{"oasis_neuro_tremors_site"});?>" /><br />
			
			
			
			
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Stuporous"  id="oasis_neuro"  <?php if(in_array("Stuporous",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Stuporous','e')?></label>
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Hallucinations"  id="oasis_neuro"  <?php if(in_array("Hallucinations",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Hallucinations','e')?></label>
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Visual"  id="oasis_neuro"  <?php if(in_array("Visual",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Visual','e')?></label>
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Auditory"  id="oasis_neuro"  <?php if(in_array("Auditory",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Auditory','e')?></label><br />
			
			
			<?php xl('Hand grips:','e')?><br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Equal (specify)"  id="oasis_neuro"  <?php if(in_array("Equal (specify)",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Equal (specify)','e')?></label>
			<input type="text" name="oasis_neuro_handgrip_equal" value="<?php echo stripslashes($obj{"oasis_neuro_handgrip_equal"});?>"/>
			<br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Unequal (specify)"  id="oasis_neuro"  <?php if(in_array("Unequal (specify)",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Unequal (specify)','e')?></label>
			<input type="text" name="oasis_neuro_handgrip_unequal" value="<?php echo stripslashes($obj{"oasis_neuro_handgrip_unequal"});?>"/>
			<br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Strong (specify)"  id="oasis_neuro"  <?php if(in_array("Strong (specify)",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Strong (specify)','e')?></label>
			<input type="text" name="oasis_neuro_handgrip_strong" value="<?php echo stripslashes($obj{"oasis_neuro_handgrip_strong"});?>"/>
			<br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Weak (specify)"  id="oasis_neuro"  <?php if(in_array("Weak (specify)",$oasis_neuro)) echo "checked"; ?>  />
			<?php xl('Weak (specify)','e')?></label>
			<input type="text" name="oasis_neuro_handgrip_weak" value="<?php echo stripslashes($obj{"oasis_neuro_handgrip_weak"});?>"/>
			<br />
			
		
			
			
			
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Psychotropic drug use (specify)"  id="oasis_neuro"  <?php if(in_array("Psychotropic drug use (specify)",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('Psychotropic drug use (specify)','e')?></label>
			<input type="text" name="oasis_neuro_psychotropic_drug" value="<?php echo stripslashes($obj{"oasis_neuro_psychotropic_drug"});?>"/>
			<br />

			<?php xl('Dose/Frequency','e')?>
			<input type="text" name="oasis_neuro_dose_frequency"  value="<?php echo stripslashes($obj{"oasis_neuro_dose_frequency"});?>" /><br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Other (specify)"  id="oasis_neuro"  <?php if(in_array("Other (specify)",$oasis_neuro)) echo "checked"; ?> />
			<?php xl('Other (specify)','e')?></label>
			<input type="text" name="oasis_neuro_other"  value="<?php echo stripslashes($obj{"oasis_neuro_other"});?>" />
			
			<br /><br />
			
			<center><strong><?php xl('MENTAL STATUS','e')?></strong></center>
			
			<label><input type="checkbox" name="oasis_mental_status[]" value="Oriented"  id="oasis_neuro"  <?php if(in_array("Oriented",$oasis_mental_status)) echo "checked"; ?> />
			<?php xl('Oriented','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Comatose"  id="oasis_neuro" <?php if(in_array("Comatose",$oasis_mental_status)) echo "checked"; ?>  />
			<?php xl('Comatose','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Forgetful"  id="oasis_neuro"  <?php if(in_array("Forgetful",$oasis_mental_status)) echo "checked"; ?> />
			<?php xl('Forgetful','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Depressed"  id="oasis_neuro"  <?php if(in_array("Depressed",$oasis_mental_status)) echo "checked"; ?> />
			<?php xl('Depressed','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Disoriented"  id="oasis_neuro" <?php if(in_array("Disoriented",$oasis_mental_status)) echo "checked"; ?>  />
			<?php xl('Disoriented','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Lethargic"  id="oasis_neuro" <?php if(in_array("Lethargic",$oasis_mental_status)) echo "checked"; ?>  />
			<?php xl('Lethargic','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Agitated"  id="oasis_neuro"  <?php if(in_array("Agitated",$oasis_mental_status)) echo "checked"; ?> />
			<?php xl('Agitated','e')?></label>
			<br />
			<label><input type="checkbox" name="oasis_mental_status[]" value="Other:"  id="oasis_neuro"  <?php if(in_array("Other:",$oasis_mental_status)) echo "checked"; ?> />
			<?php xl('Other:','e')?></label>
			<input type="text" name="oasis_mental_status_other"  value="<?php echo stripslashes($obj{"oasis_mental_status_other"});?>" />
			
			<br />
			<br />
			<center><strong><?php xl('PSYCHOSOCIAL','e')?></strong></center>
			
			<?php xl('Primary language','e')?>
			<input type="text" name="oasis_psychosocial_primary_lang" value="<?php echo stripslashes($obj{"oasis_psychosocial_primary_lang"});?>"/>
			<br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Language barrier"  id="oasis_psychosocial" <?php if(in_array("Language barrier",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Language barrier','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Needs interpreter"  id="oasis_psychosocial" <?php if(in_array("Needs interpreter",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Needs interpreter','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Learning Barrier:"  id="oasis_psychosocial"  <?php if(in_array("Learning Barrier:",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Learning Barrier:','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Mental"  id="oasis_psychosocial"  <?php if(in_array("Mental",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Mental','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Psychosocial"  id="oasis_psychosocial" <?php if(in_array("Psychosocial",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Psychosocial','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Physical"  id="oasis_psychosocial"  <?php if(in_array("Physical",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Physical','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Functional"  id="oasis_psychosocial"  <?php if(in_array("Functional",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Functional','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Unable to read/write"  id="oasis_psychosocial"  <?php if(in_array("Unable to read/write",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Unable to read/write','e')?></label>
			
			<br />
			<?php xl('Educational Level','e')?>
			<input type="text" name="oasis_psychosocial_edu_level" value="<?php echo stripslashes($obj{"oasis_psychosocial_edu_level"});?>" />
			<br />
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Angry"  id="oasis_psychosocial" <?php if(in_array("Angry",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Angry','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Difficulty coping"  id="oasis_psychosocial"  <?php if(in_array("Difficulty coping",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Difficulty coping','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Withdrawn"  id="oasis_psychosocial"  <?php if(in_array("Withdrawn",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Withdrawn','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Discouraged"  id="oasis_psychosocial"  <?php if(in_array("Discouraged",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Discouraged','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Flat affect"  id="oasis_psychosocial"  <?php if(in_array("Flat affect",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Flat affect','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Disorganized"  id="oasis_psychosocial"  <?php if(in_array("Disorganized",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Disorganized','e')?></label><br />
			
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Spiritual/Cultural implications that impact care."  id="oasis_psychosocial"  <?php if(in_array("Spiritual/Cultural implications that impact care.",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Spiritual/Cultural implications that impact care.','e')?></label><br />
			<?php xl('Explain:','e')?>
			<input type="text" name="oasis_psychosocial_explain"  value="<?php echo stripslashes($obj{"oasis_psychosocial_explain"});?>" /><br />
			<?php xl('Spiritual resource:','e')?>
			<input type="text" name="oasis_psychosocial_spiritual_resource"  value="<?php echo stripslashes($obj{"oasis_psychosocial_spiritual_resource"});?>" /><br />
			<?php xl('Phone No:','e')?>
			<input type="text" name="oasis_psychosocial_phone_no"  value="<?php echo stripslashes($obj{"oasis_psychosocial_phone_no"});?>" /><br />
			
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Depressed: Recent/Long term Treatment:"  id="oasis_psychosocial"  <?php if(in_array("Depressed: Recent/Long term Treatment:",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Depressed: Recent/Long term Treatment:','e')?></label>
			<input type="text" name="oasis_psychosocial_treatment"  value="<?php echo stripslashes($obj{"oasis_psychosocial_treatment"});?>" />
			<br />
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inability to cope with altered health status"  id="oasis_psychosocial"  <?php if(in_array("Inability to cope with altered health status",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Inability to cope with altered health status','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inability to recognize problems"  id="oasis_psychosocial"  <?php if(in_array("Inability to recognize problems",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Inability to recognize problems','e')?></label><br />
			
			<?php xl('Due to:','e')?>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Lack of motivation"  id="oasis_psychosocial" <?php if(in_array("Lack of motivation",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Lack of motivation','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Unrealistic expectations"  id="oasis_psychosocial"  <?php if(in_array("Unrealistic expectations",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Unrealistic expectations','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Denial of problems"  id="oasis_psychosocial"  <?php if(in_array("Denial of problems",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Denial of problems','e')?></label>
			
			<br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Sleep/Rest:"  id="oasis_psychosocial"  <?php if(in_array("Sleep/Rest:",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Sleep/Rest:','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Adequate"  id="oasis_psychosocial"  <?php if(in_array("Adequate",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Adequate','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inadequate"  id="oasis_psychosocial" <?php if(in_array("Inadequate",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Inadequate','e')?></label><br />
			<?php xl('Explain','e')?>
			<input type="text" name="oasis_psychosocial_sleep_explain"  value="<?php echo stripslashes($obj{"oasis_psychosocial_sleep_explain"});?>" size="50" />
			<br />
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inappropriate responses to caregivers/clinician"  id="oasis_psychosocial"  <?php if(in_array("Inappropriate responses to caregivers/clinician",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Inappropriate responses to caregivers/clinician','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inappropriate follow-through in past"  id="oasis_psychosocial" <?php if(in_array("Inappropriate follow-through in past",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Inappropriate follow-through in past','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Evidence of"  id="oasis_psychosocial"  <?php if(in_array("Evidence of",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Evidence of','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Potential"  id="oasis_psychosocial" <?php if(in_array("Potential",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Potential','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Actual"  id="oasis_psychosocial"  <?php if(in_array("Actual",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Actual','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Verbal/Emotional"  id="oasis_psychosocial"  <?php if(in_array("Verbal/Emotional",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Verbal/Emotional','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Physical1"  id="oasis_psychosocial" <?php if(in_array("Physical1",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Physical','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Financial"  id="oasis_psychosocial" <?php if(in_array("Financial",$oasis_psychosocial)) echo "checked"; ?>  />
			<?php xl('Financial','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Describe:"  id="oasis_psychosocial"  <?php if(in_array("Describe:",$oasis_psychosocial)) echo "checked"; ?> />
			<?php xl('Describe:','e')?></label><br />
			<textarea name="oasis_psychosocial_describe" rows="3" cols="48"><?php echo stripslashes($obj{"oasis_psychosocial_describe"});?></textarea><br />
			<?php xl('Comments:','e')?></label><br />
			<textarea name="oasis_psychosocial_comments" rows="3" cols="48"><?php echo stripslashes($obj{"oasis_psychosocial_comments"});?></textarea><br />
			
			

</td>
</tr>




</table>

                        </li>
                    </ul>
                </li>








<li>
                    <div><a href="#" id="black">ADL/IADLs</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                        <ul>
<!-- *********************  ADL/IADLs   ******************** -->
                        <li>


	<table class="formtable" width="100%" border="1">
	<tr valign="top">
	<td width="50%">
	
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
			<br><hr />
			
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
			
			<hr />
			<strong><?php xl("<u>(M1880)</u>","e");?></strong>
			<?php xl("Current <strong>Ability to Plan and Prepare Light Meals</strong> (e.g., cereal, sandwich) or reheat delivered meals safely:","e");?><br />
			<label><input type="radio" name="oasis_adl_current_ability" value="0" <?php if($obj{"oasis_adl_current_ability"}=="0") echo "checked"; ?> ><?php xl(' 0 - (a) Able to independently plan and prepare all light meals for self or reheat delivered meals; <u>OR</u><br />
(b) Is physically, cognitively, and mentally able to prepare light meals on a regular basis but has not routinely performed light meal preparation in the past (i.e., prior to this home care admission).','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_current_ability" value="1" <?php if($obj{"oasis_adl_current_ability"}=="1") echo "checked"; ?> ><?php xl(' 1 - <u>Unable</u> to prepare light meals on a regular basis due to physical, cognitive, or mental limitations.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_current_ability" value="2" <?php if($obj{"oasis_adl_current_ability"}=="2") echo "checked"; ?> ><?php xl(' 2 - Unable to prepare any light meals or reheat any delivered meals.','e')?></label> <br>
			<br />
			
			
			
	
	</td>
	
	</tr>
	</table>
	
	

                        </li>
                    </ul>
                </li>






<!-- ****************************   ####################################  **************************** -->








<li>
                    <div><a href="#" id="black">ADL/IADLs (CONTD), Medication</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                       <ul id="adl_iadls_contd">
<!-- *********************  ADL/IADLs (CONTD)   ******************** -->
                        <li>


<table class="formtable" width="100%" border="1">
<tr>
		<td colspan="2"> 
		<center><strong><?php xl("ADL/IADLs (CONTD)","e");?></strong></center>
		</td>
		
</tr>
<tr valign="top">
<td width="50%">
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

<table class="formtable" width="100%" border="1">
<tr>
		<td colspan="5">
		<strong><?php xl("<u>(M1900)</u>","e");?></strong>
			<?php xl("<strong>Prior Functioning ADL/IADL:</strong> Indicate the patient's usual ability with everyday activities prior to this current illness, exacerbation, or injury. Check only <strong><u>one</u></strong> box in each row.","e");?><br />
		</td>
		
</tr>
<tr valign="top">
<td colspan="2" valign="middle" align="center">
<strong><?php xl("Functional Area","e");?></strong>
</td>
<td valign="middle" align="center">
<strong><?php xl("Independent","e");?></strong>
</td>
<td valign="middle" align="center">
<strong><?php xl("Needed Some Help","e");?></strong>
</td>
<td valign="middle" align="center">
<strong><?php xl("Dependent","e");?></strong>
</td>
</tr>

<tr>
<td>
<?php xl("a.","e");?>
</td>
<td>
<?php xl("Self-Care (e.g., grooming, dressing, and bathing)","e");?>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_self_care" value="0" <?php if($obj{"oasis_adl_func_self_care"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_self_care" value="1" <?php if($obj{"oasis_adl_func_self_care"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_self_care" value="2" <?php if($obj{"oasis_adl_func_self_care"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
</tr>

<tr>
<td>
<?php xl("b.","e");?>
</td>
<td>
<?php xl("Ambulation","e");?>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_ambulation" value="0" <?php if($obj{"oasis_adl_func_ambulation"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_ambulation" value="1" <?php if($obj{"oasis_adl_func_ambulation"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_ambulation" value="2" <?php if($obj{"oasis_adl_func_ambulation"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
</tr>

<tr>
<td>
<?php xl("c.","e");?>
</td>
<td>
<?php xl("Transfer","e");?>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_transfer" value="0" <?php if($obj{"oasis_adl_func_transfer"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_transfer" value="1" <?php if($obj{"oasis_adl_func_transfer"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_transfer" value="2" <?php if($obj{"oasis_adl_func_transfer"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
</tr>

<tr>
<td>
<?php xl("d.","e");?>
</td>
<td>
<?php xl("Household tasks (e.g., light meal preparation, laundry, shopping )","e");?>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_household" value="0" <?php if($obj{"oasis_adl_func_household"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_household" value="1" <?php if($obj{"oasis_adl_func_household"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_household" value="2" <?php if($obj{"oasis_adl_func_household"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
</tr>

</table>

<br />
<center><strong><?php xl("ACTIVITIES PERMITTED","e");?></strong></center><br>
			<table class="formtable" border="0" width="100%">
				<tr>
					<td width="50%">
						1. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Complete Bedrest" <?php if(in_array("Complete Bedrest",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Complete Bedrest','e')?></label><br>
						2. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Bedrest w/ BRP" <?php if(in_array("Bedrest w/ BRP",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Bedrest w/ BRP','e')?></label><br>
						3. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Up as tolerated" <?php if(in_array("Up as tolerated",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Up as tolerated','e')?></label><br>
						4. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Transfer Bed/Chair" <?php if(in_array("Transfer Bed/Chair",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Transfer Bed/Chair','e')?></label><br>
						5. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Exercises Prescribed" <?php if(in_array("Exercises Prescribed",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Exercises Prescribed','e')?></label><br>
						6. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Partial Weight Bearing" <?php if(in_array("Partial Weight Bearing",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Partial Weight Bearing','e')?></label><br>
						7. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Independent At Home" <?php if(in_array("Independent At Home",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Independent At Home','e')?></label><br>
					</td>
					<td>
						8. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Crutches" <?php if(in_array("Crutches",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Crutches','e')?></label><br>
						9. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Cane" <?php if(in_array("Cane",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Cane','e')?></label><br>
						A. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Wheelchair" <?php if(in_array("Wheelchair",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Wheelchair','e')?></label><br>
						B. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Walker" <?php if(in_array("Walker",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Walker','e')?></label><br>
						C. <label><input type="checkbox" name="oasis_activities_permitted[]" value="No Restrictions" <?php if(in_array("No Restrictions",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('No Restrictions','e')?></label><br>
						D. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Other" <?php if(in_array("Other",$oasis_activities_permitted)) echo "checked"; ?> ><?php xl('Other (specify):','e')?></label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						   <input type="text" name="oasis_activities_permitted_other"  value="<?php echo stripslashes($obj{"oasis_activities_permitted_other"});?>" ><br>
					</td>
				</tr>
			</table>
			<br />

</td>

<td>
<strong><?php xl("<u>(M1910)</u>","e");?></strong>
			<?php xl("Has this patient had a multi-factor <strong>Fall Risk Assessment</strong> (such as falls history, use of multiple medications, mental impairment, toileting frequency, general mobility/transferring impairment, environmental hazards)?","e");?><br />
			<label><input type="radio" name="oasis_adl_fall_risk_assessment" value="0" <?php if($obj{"oasis_adl_fall_risk_assessment"}=="0") echo "checked"; ?> ><?php xl(' 0 - No multi-factor falls risk assessment conducted.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_fall_risk_assessment" value="1" <?php if($obj{"oasis_adl_fall_risk_assessment"}=="1") echo "checked"; ?> ><?php xl(' 1 - Yes, and it does not indicate a risk for falls.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_fall_risk_assessment" value="2" <?php if($obj{"oasis_adl_fall_risk_assessment"}=="2") echo "checked"; ?> ><?php xl(' 2 - Yes, and it indicates a risk for falls.','e')?></label> <br>
			<br /><hr />
			
			<center><strong><?php xl("MEDICATIONS","e");?></strong></center><br />
			<strong><?php xl("<u>(M2000)</u>","e");?></strong>
			<?php xl("<strong>Drug Regimen Review:</strong> Does a complete drug regimen review indicate potential clinically significant medication issues, e.g., drug reactions, ineffective drug therapy, side effects, drug interactions, duplicate therapy, omissions, dosage errors, or noncompliance?","e");?><br />
			<label><input type="radio" name="oasis_adl_drug_regimen" value="0" <?php if($obj{"oasis_adl_drug_regimen"}=="0") echo "checked"; ?> ><?php xl(' 0 - Not assessed/reviewed <strong><i>[Go to M2010]</i></strong>','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_drug_regimen" value="1" <?php if($obj{"oasis_adl_drug_regimen"}=="1") echo "checked"; ?> ><?php xl(' 1 - No problems found during review <strong><i>[Go to M2010]</i></strong>','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_drug_regimen" value="2" <?php if($obj{"oasis_adl_drug_regimen"}=="2") echo "checked"; ?> ><?php xl(' 2 - Problems found during review','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_drug_regimen" value="NA" <?php if($obj{"oasis_adl_drug_regimen"}=="NA") echo "checked"; ?> ><?php xl(' NA - Patient is not taking any medications <strong><i>[Go to M2040]</i></strong>','e')?></label> <br>
			<br /><hr />
			
			<strong><?php xl("<u>(M2002)</u>","e");?></strong>
			<?php xl("<strong>Medication Follow-up:</strong> Was a physician or the physician-designee contacted within one calendar day to resolve clinically significant medication issues, including reconciliation?","e");?><br />
			<label><input type="radio" name="oasis_adl_medication_follow_up" value="0" <?php if($obj{"oasis_adl_medication_follow_up"}=="0") echo "checked"; ?> ><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_medication_follow_up" value="1" <?php if($obj{"oasis_adl_medication_follow_up"}=="1") echo "checked"; ?> ><?php xl(' 1 - Yes','e')?></label> <br>
			<br /><hr />
			
			<strong><?php xl("<u>(M2010)</u>","e");?></strong>
			<?php xl("<strong>Patient/Caregiver High Risk Drug Education:</strong> Has the patient/caregiver received instruction on special precautions for all high-risk medications (such as hypoglycemics, anticoagulants, etc.) and how and when to report problems that may occur?","e");?><br />
			<label><input id="m2010" type="radio" name="oasis_adl_patient_caregiver" value="0" <?php if($obj{"oasis_adl_patient_caregiver"}=="0") echo "checked"; ?> ><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_patient_caregiver" value="1" <?php if($obj{"oasis_adl_patient_caregiver"}=="1") echo "checked"; ?> ><?php xl(' 1 - Yes','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_patient_caregiver" value="NA" <?php if($obj{"oasis_adl_patient_caregiver"}=="NA") echo "checked"; ?> ><?php xl(' NA - Patient not taking any high risk drugs OR patient/caregiver fully knowledgeable about special precautions associated with all high-risk medications','e')?></label> <br>
			<br />


</td>
</tr>

<tr>
<td colspan="2" align="center">
<strong><?php xl("MEDICATIONS (CONTD)","e");?></strong>
</td>
</tr>

<tr>
<td>
<strong><?php xl("<u>(M2020)</u>","e");?></strong>
			<?php xl("<strong>Management of Oral Medications:</strong> <u>Patient's current ability</u> to prepare and take <u>all</u> oral medications reliably and safely, including administration of the correct dosage at the appropriate times/intervals. <strong><u>Excludes</u> injectable and IV medications. (NOTE: This refers to ability, not compliance or willingness.)</strong>","e");?><br />
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="0" <?php if($obj{"oasis_adl_management_oral_medications"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to independently take the correct oral medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="1" <?php if($obj{"oasis_adl_management_oral_medications"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to take medication(s) at the correct times if:<br />(a) individual dosages are prepared in advance by another person; <u>OR</u><br />(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="2" <?php if($obj{"oasis_adl_management_oral_medications"}=="2") echo "checked"; ?> ><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person at the appropriate times','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="3" <?php if($obj{"oasis_adl_management_oral_medications"}=="3") echo "checked"; ?> ><?php xl(' 3 - <u>Unable</u> to take medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="NA" <?php if($obj{"oasis_adl_management_oral_medications"}=="NA") echo "checked"; ?> ><?php xl(' NA - No oral medications prescribed.','e')?></label> <br>
			<br />
			<strong><?php xl("Financially able to pay for medications:","e");?></strong>
			<label><input type="checkbox" name="oasis_adl_pay_for_medications" value="Yes" <?php if($obj{"oasis_adl_pay_for_medications"}=="Yes") echo "checked"; ?> ><?php xl('Yes','e')?></label>
			<label><input type="checkbox" name="oasis_adl_pay_for_medications" value="No" <?php if($obj{"oasis_adl_pay_for_medications"}=="No") echo "checked"; ?> ><?php xl('No','e')?></label>
</td>

<td>
<strong><?php xl("<u>(M2030)</u>","e");?></strong>
			<?php xl("<strong>Management of Injectable Medications: </strong> <u>Patient's current ability</u> to prepare and take <u>all</u> prescribed injectable medications reliably and safely, including administration of correct dosage at the appropriate times/intervals. <strong><u>Excludes</u> IV medications.</strong>","e");?><br />
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="0" <?php if($obj{"oasis_adl_management_injectable_medications"}=="0") echo "checked"; ?> ><?php xl(' 0 - Able to independently take the correct oral medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="1" <?php if($obj{"oasis_adl_management_injectable_medications"}=="1") echo "checked"; ?> ><?php xl(' 1 - Able to take injectable medication(s) at the correct times if:<br />(a) individual syringes are prepared in advance by another person; <u>OR</u><br />(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="2" <?php if($obj{"oasis_adl_management_injectable_medications"}=="2") echo "checked"; ?> ><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person based on the frequency of the injection','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="3" <?php if($obj{"oasis_adl_management_injectable_medications"}=="3") echo "checked"; ?> ><?php xl(' 3 - <u>Unable</u> to take injectable medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="NA" <?php if($obj{"oasis_adl_management_injectable_medications"}=="NA") echo "checked"; ?> ><?php xl(' NA - No injectable medications prescribed.','e')?></label> <br>
			<br />

</td>
</tr>

<tr>
<td colspan="2">
<table class="formtable" width="100%" border="1">
<tr>
		<td colspan="6">
			<?php xl("<strong><u>(M2040)</u> Prior Medication Management:</strong> Indicate the patient's usual ability with managing oral and injectable medications prior to this current illness, exacerbation, or injury. Check only <strong><u>one</u></strong> box in each row.","e");?><br />
		</td>
		
</tr>

<tr>
<td colspan="2" align="center">
<strong><?php xl("Functional Area","e");?></strong>
</td>
<td align="center">
<strong><?php xl("Independent","e");?></strong>
</td>
<td align="center">
<strong><?php xl("Needed Some Help","e");?></strong>
</td>
<td align="center">
<strong><?php xl("Dependent","e");?></strong>
</td>
<td align="center">
<strong><?php xl("Not Applicable","e");?></strong>
</td>
</tr>

<tr>
<td>
<?php xl("a.","e");?>
</td>
<td>
<?php xl("Oral medications","e");?>
</td>
<td>
<label><input id="m2040" type="radio" name="oasis_adl_func_oral_med" value="0" <?php if($obj{"oasis_adl_func_oral_med"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_func_oral_med" value="1" <?php if($obj{"oasis_adl_func_oral_med"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_func_oral_med" value="2" <?php if($obj{"oasis_adl_func_oral_med"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_func_oral_med" value="na" <?php if($obj{"oasis_adl_func_oral_med"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
</td>
</tr>

<tr>
<td>
<?php xl("b.","e");?>
</td>
<td>
<?php xl("Injectable medications","e");?>
</td>
<td>
<label><input type="radio" name="oasis_adl_inject_med" value="0" <?php if($obj{"oasis_adl_inject_med"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_inject_med" value="1" <?php if($obj{"oasis_adl_inject_med"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_inject_med" value="2" <?php if($obj{"oasis_adl_inject_med"}=="2") echo "checked"; ?> ><?php xl(' 2','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_inject_med" value="na" <?php if($obj{"oasis_adl_inject_med"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
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
                    <div><a href="#" id="black">Care Management &amp; Therapy Need And Plan Of Care </a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                       <ul>
<!-- *********************  Care Management &amp; Therapy Need And Plan Of Care    ******************** -->
                        <li>

<table class="formtable" width="100%" border="1">

	<tr>
		<td colspan="2"> 
			<center><strong><?php xl("CARE MANAGEMENT","e");?></strong></center>
		</td>
	</tr>

	<tr valign="top">
	<td>
	<table class="formtable" width="100%" border="1">
<tr>
		<td colspan="8">
		<strong><?php xl("<u>(M2100)</u>","e");?></strong>
			<?php xl("<strong> Types and Source of Assistance:</strong> Determine the level of caregiver ability and willingness to provide assistance for the following activities, if assistance is needed. (Check only <strong><u>one</u></strong> box in each row.)","e");?><br />
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

	</td>
	</tr>
	
	<tr>
	<td>
	<strong><?php xl("<u>(M2110)</u>","e");?></strong>
			<?php xl("<strong>How Often </strong> does the patient receive <strong>ADL or IADL assistance</strong> from any caregiver(s) (other than home health agency staff)?","e");?><br />
			<label><input type="radio" name="oasis_care_how_often" value="1" <?php if($obj{"oasis_care_how_often"}=="1") echo "checked"; ?> ><?php xl(' 1 - At least daily','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="2" <?php if($obj{"oasis_care_how_often"}=="2") echo "checked"; ?> ><?php xl(' 2 - Three or more times per week','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="3" <?php if($obj{"oasis_care_how_often"}=="3") echo "checked"; ?> ><?php xl(' 3 - One to two times per week','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="4" <?php if($obj{"oasis_care_how_often"}=="4") echo "checked"; ?> ><?php xl(' 4 - Received, but less often than weekly','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="5" <?php if($obj{"oasis_care_how_often"}=="5") echo "checked"; ?> ><?php xl(' 5 - No assistance received','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="UK" <?php if($obj{"oasis_care_how_often"}=="UK") echo "checked"; ?> ><?php xl(' UK - Unknown <strong>[Omit "UK" option on DC]</strong>','e')?></label> <br>
			<br />
			<br />
			<br />
			
			
			<center><strong><?php xl("THERAPY NEED AND PLAN OF CARE","e");?></strong></center>
			<?php xl("<strong><u>(M2200)</u> Therapy Need:</strong> In the home health plan of care for the Medicare payment episode for which this assessment will define a case mix group, what is the indicated need for therapy visits (total of reasonable and necessary physical, occupational, and speech-language pathology visits combined)?<strong>( Enter zero [ \"000\" ] if no therapy visits indicated.)</strong>","e");?><br /> 
			<label><input type="text" name="oasis_care_therapy_visits"  value="<?php echo stripslashes($obj{"oasis_care_therapy_visits"});?>"  size="5"><?php xl(' - Number of therapy visits indicated (total of physical, occupational and speech-language pathology combined).','e')?></label>
			<br />
			<label><input type="checkbox" name="oasis_care_therapy_need_applicable" value="NA" <?php if($obj{"oasis_care_therapy_need_applicable"}=="NA") echo "checked"; ?> ><?php xl(' NA - Not Applicable: No case mix group defined by this assessment.','e')?></label> <br>

			<br />
			<br />
			

			
			

<table class="formtable" width="100%" border="1">
<tr>
<td colspan="6">
<strong><?php xl("<u>(M2250)</u>","e");?></strong>
<?php xl("<strong>Plan of Care Synopsis:</strong> (Check only <strong><u>one</u></strong> box in each row.) Does the physician-ordered plan of care include the following:","e");?><br />
</td>
</tr>

<tr>
<td colspan="2" align="center">
<strong><?php xl("Plan/Intervention","e");?></strong>
</td>
<td width="9%" align="center">
<strong><?php xl("No","e");?></strong>
</td>
<td width="9%" align="center">
<strong><?php xl("Yes","e");?></strong>
</td>
<td colspan="2">
<strong><?php xl("Not Applicable","e");?></strong>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("a.","e");?>
</td>
<td valign="top">
<?php xl("Patient-specific parameters for notifying physician of changes in vital signs or other clinical findings","e");?>
</td>
<td>
<label><input type="radio" name="oasis_care_patient_parameter" value="0" <?php if($obj{"oasis_care_patient_parameter"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_patient_parameter" value="1" <?php if($obj{"oasis_care_patient_parameter"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td width="10%">
<label><input type="radio" name="oasis_care_patient_parameter" value="na" <?php if($obj{"oasis_care_patient_parameter"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
</td>
<td>
<?php xl("Physician has chosen not to establish patient-specific parameters for this patient. Agency will use standardized clinical guidelines accessible for all care providers to reference","e");?>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("b.","e");?>
</td>
<td>
<?php xl("Diabetic foot care including monitoring for the presence of skin lesions on the lower extremities and patient/caregiver education on proper foot care","e");?>
</td>
<td>
<label><input type="radio" name="oasis_care_diabetic_foot_care" value="0" <?php if($obj{"oasis_care_diabetic_foot_care"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_diabetic_foot_care" value="1" <?php if($obj{"oasis_care_diabetic_foot_care"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_diabetic_foot_care" value="na" <?php if($obj{"oasis_care_diabetic_foot_care"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
</td>
<td>
<?php xl("Patient is not diabetic or is bilateral amputee","e");?>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("c.","e");?>
</td>
<td>
<?php xl("Falls prevention interventions","e");?>
</td>
<td>
<label><input type="radio" name="oasis_care_falls_prevention" value="0" <?php if($obj{"oasis_care_falls_prevention"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_falls_prevention" value="1" <?php if($obj{"oasis_care_falls_prevention"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_falls_prevention" value="na" <?php if($obj{"oasis_care_falls_prevention"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
</td>
<td>
<?php xl("Patient is not assessed to be at risk for falls","e");?>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("d.","e");?>
</td>
<td>
<?php xl("Depression intervention(s) such as medication, referral for other treatment, or a monitoring plan for current treatment","e");?>
</td>
<td>
<label><input type="radio" name="oasis_care_depression_intervention" value="0" <?php if($obj{"oasis_care_depression_intervention"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_depression_intervention" value="1" <?php if($obj{"oasis_care_depression_intervention"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_depression_intervention" value="na" <?php if($obj{"oasis_care_depression_intervention"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
</td>
<td>
<?php xl("Patient has no diagnosis or symptoms of depression","e");?>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("e.","e");?>
</td>
<td>
<?php xl("Intervention(s) to monitor and mitigate pain","e");?>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_monitor" value="0" <?php if($obj{"oasis_care_intervention_monitor"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_monitor" value="1" <?php if($obj{"oasis_care_intervention_monitor"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_monitor" value="na" <?php if($obj{"oasis_care_intervention_monitor"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
</td>
<td>
<?php xl("No pain identified","e");?>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("f.","e");?>
</td>
<td valign="top">
<?php xl("Intervention(s) to prevent pressure ulcers","e");?>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_prevent" value="0" <?php if($obj{"oasis_care_intervention_prevent"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_prevent" value="1" <?php if($obj{"oasis_care_intervention_prevent"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_prevent" value="na" <?php if($obj{"oasis_care_intervention_prevent"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
</td>
<td>
<?php xl("Patient is not assessed to be at risk for pressure ulcers","e");?>
</td>
</tr>

<tr>
<td valign="top">
<?php xl("g.","e");?>
</td>
<td>
<?php xl("Pressure ulcer treatment based on principles of moist wound healing OR order for treatment based on moist wound healing has been requested from physician","e");?>
</td>
<td>
<label><input type="radio" name="oasis_care_pressure_ulcer" value="0" <?php if($obj{"oasis_care_pressure_ulcer"}=="0") echo "checked"; ?> ><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_pressure_ulcer" value="1" <?php if($obj{"oasis_care_pressure_ulcer"}=="1") echo "checked"; ?> ><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_pressure_ulcer" value="na" <?php if($obj{"oasis_care_pressure_ulcer"}=="na") echo "checked"; ?> ><?php xl(' na','e')?></label> <br>
</td>
<td>
<?php xl("Patient has no pressure ulcers with need for moist wound healing","e");?>
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
			<div><a href="#" id="black">Homebound Status, Instructions/Materials Provided, DME/Medical Supplies, Discharge, Appliances/Special Equipment/Organizations Plan</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			                    <ul>
				<li>
<table width="100%" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("HOMEBOUND STATUS","e");?></strong></center><br />
			
<table width="100%" border="0" class="formtable">
<tr>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Needs assistance for all activities" <?php if(in_array("Needs assistance for all activities",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Needs assistance for all activities','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Residual weakness" <?php if(in_array("Residual weakness",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Residual weakness','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Requires assistance to ambulate" <?php if(in_array("Requires assistance to ambulate",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Requires assistance to ambulate','e')?></label><br>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Confusion, unable to go out of home alone" <?php if(in_array("Confusion, unable to go out of home alone",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Confusion, unable to go out of home alone','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Unable to safely leave home unassisted" <?php if(in_array("Unable to safely leave home unassisted",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Unable to safely leave home unassisted','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Medical restrictions" <?php if(in_array("Medical restrictions",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Medical restrictions','e')?></label><br>
</td>
</tr>


<tr>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Bed Bound" <?php if(in_array("Bed Bound",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Bed Bound','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="SOB" <?php if(in_array("SOB",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('SOB','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Pain" <?php if(in_array("Pain",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Pain','e')?></label><br>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Arrhythmia" <?php if(in_array("Arrhythmia",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Arrhythmia','e')?></label>
</td>
<td colspan="3">
<label><input type="checkbox" name="oasis_homebound_status[]" value="Other:" <?php if(in_array("Other:",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
<input type="text" name="oasis_homebound_status_other"  value="<?php echo stripslashes($obj{"oasis_homebound_status_other"});?>" >
</td>
</tr>


<tr>
<td colspan="3">
<label><input type="checkbox" name="oasis_homebound_status[]" value="Ambulation limited to" <?php if(in_array("Ambulation limited to",$oasis_homebound_status)) echo "checked"; ?> ><?php xl('Ambulation limited to','e')?></label>
<input type="text" name="oasis_homebound_status_ambulation"  value="<?php echo stripslashes($obj{"oasis_homebound_status_ambulation"});?>"  size="4"><?php xl(' ft. with assist of ','e')?>
<input type="text" name="oasis_homebound_status_assist"  value="<?php echo stripslashes($obj{"oasis_homebound_status_assist"});?>"  size="5"><?php xl(' (device) due to ','e')?>
<input type="text" name="oasis_homebound_status_due_to"  value="<?php echo stripslashes($obj{"oasis_homebound_status_due_to"});?>" >
</td>
</tr>


</table>


</td>
	</tr>
	
	<tr>
	<td>
	<center><strong><?php xl("INSTRUCTIONS/MATERIALS PROVIDED (MARK ALL THAT APPLY)","e");?></strong></center><br />
	
<table width="100%" border="0" class="formtable">
<tr valign="top">
<td width="23%">
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Rights and responsibilities" <?php if(in_array("Rights and responsibilities",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Rights and responsibilities','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Do not resuscitate (DNR)" <?php if(in_array("Do not resuscitate (DNR)",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Do not resuscitate (DNR)','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="HIPAA Notice of Privacy Practices" <?php if(in_array("HIPAA Notice of Privacy Practices",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('HIPAA Notice of Privacy Practices','e')?></label><br>
</td>
<td width="28%">
<label><input type="checkbox" name="oasis_instructions_materials[]" value="When to contact physician and/or agency" <?php if(in_array("When to contact physician and/or agency",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('When to contact physician and/or agency','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Disease Info" <?php if(in_array("Disease Info",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Disease Info','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Medication regimen/administration" <?php if(in_array("Medication regimen/administration",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Medication regimen/administration','e')?></label><br>
</td>
<td width="27%">
<label><input type="checkbox" name="oasis_instructions_materials[]" value="State hotline number" <?php if(in_array("State hotline number",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('State hotline number','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Advance Directives" <?php if(in_array("Advance Directives",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Advance Directives','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="OASIS Privacy Notice" <?php if(in_array("OASIS Privacy Notice",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('OASIS Privacy Notice','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Standard precautions/hand washing" <?php if(in_array("Standard precautions/hand washing",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Standard precautions/hand washing','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Basic home safety" <?php if(in_array("Basic home safety",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Basic home safety','e')?></label><br>
</td>
</tr>

<tr valign="top">
<td colspan="2">
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Emergency planning in the event service is disrupted" <?php if(in_array("Emergency planning in the event service is disrupted",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Emergency planning in the event service is disrupted','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Agency phone number/after hours number" <?php if(in_array("Agency phone number/after hours number",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Agency phone number/after hours number','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Others" <?php if(in_array("Others",$oasis_instructions_materials)) echo "checked"; ?> ><?php xl('Others','e')?></label>
<input type="text" name="oasis_instructions_materials_other" id="oasis_instructions_materials_other" size="15"  value="<?php echo stripslashes($obj{"oasis_instructions_materials_other"});?>" />
</td>
</tr>

</table>


<strong><?php xl('Skilled care/Instructions provided this visit:','e')?></strong><br />
<textarea name="oasis_instructions_skilled_care" rows="3" cols="98">
<?php echo stripslashes($obj{"oasis_instructions_skilled_care"});?>
</textarea><br>

<strong><?php xl('Care coordinated with:','e')?></strong>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="CM" <?php if(in_array("CM",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('CM','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Physician" <?php if(in_array("Physician",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('Physician','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="RN" <?php if(in_array("RN",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('RN','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="PT" <?php if(in_array("PT",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('PT','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="OT" <?php if(in_array("OT",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('OT','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="ST" <?php if(in_array("ST",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('ST','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="MSW" <?php if(in_array("MSW",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('MSW','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="HHA" <?php if(in_array("HHA",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('HHA','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="RD" <?php if(in_array("RD",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('RD','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Caregiver" <?php if(in_array("Caregiver",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('Caregiver','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Family" <?php if(in_array("Family",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('Family','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Pharmacy" <?php if(in_array("Pharmacy",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('Pharmacy','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="DME/Medical Supplier" <?php if(in_array("DME/Medical Supplier",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('DME/Medical Supplier','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Nursing Supervisor" <?php if(in_array("Nursing Supervisor",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('Nursing Supervisor','e')?></label><br />
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Other:" <?php if(in_array("Other:",$oasis_instructions_care_coordinated)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
<input type="text" name="oasis_instructions_care_coordinated_other" id="oasis_instructions_care_coordinated_other" size="60"  value="<?php echo stripslashes($obj{"oasis_instructions_care_coordinated_other"});?>" /><br />

<?php xl('Topic:','e')?>
<input type="text" name="oasis_instructions_topic" id="oasis_instructions_topic" size="60" value="<?php echo stripslashes($obj{"oasis_instructions_topic"});?>"  /><br />


<?php xl('Patient has the following :','e')?>
<?php xl('Living Will:','e')?>
<label><input type="radio" name="oasis_instructions_living_will" value="Yes" <?php if($obj{"oasis_instructions_living_will"}=="Yes") echo "checked"; ?> ><?php xl(' Yes','e')?></label>
<label><input type="radio" name="oasis_instructions_living_will" value="No" <?php if($obj{"oasis_instructions_living_will"}=="No") echo "checked"; ?> ><?php xl(' No','e')?></label> <br>

<?php xl('Copies located at:','e')?>
<label><input type="checkbox" name="oasis_instructions_copies_located[]" value="Patient Home" <?php if(in_array("Patient Home",$oasis_instructions_copies_located)) echo "checked"; ?> ><?php xl('Patient Home','e')?></label>
<label><input type="checkbox" name="oasis_instructions_copies_located[]" value="Agency" <?php if(in_array("Agency",$oasis_instructions_copies_located)) echo "checked"; ?> ><?php xl('Agency','e')?></label>
<label><input type="checkbox" name="oasis_instructions_copies_located[]" value="Family Member" <?php if(in_array("Family Member",$oasis_instructions_copies_located)) echo "checked"; ?> ><?php xl('Family Member','e')?></label>
<br />
<?php xl('Bill of Rights signed:','e')?>
<label><input type="radio" name="oasis_instructions_bill_of_rights" value="Yes" <?php if($obj{"oasis_instructions_bill_of_rights"}=="Yes") echo "checked"; ?> ><?php xl(' Yes','e')?></label>
<label><input type="radio" name="oasis_instructions_bill_of_rights" value="No" <?php if($obj{"oasis_instructions_bill_of_rights"}=="No") echo "checked"; ?> ><?php xl(' No','e')?></label>
&nbsp;&nbsp;&nbsp;
<?php xl('Patient:','e')?>
<label><input type="radio" name="oasis_instructions_patient" value="Understands" <?php if($obj{"oasis_instructions_patient"}=="Understands") echo "checked"; ?> ><?php xl(' Understands','e')?></label>
<label><input type="radio" name="oasis_instructions_patient" value="May not understand (explain)" <?php if($obj{"oasis_instructions_patient"}=="May not understand (explain)") echo "checked"; ?> ><?php xl(' May not understand (explain)','e')?></label>
<input type="text" name="oasis_instructions_not_understand"  value="<?php echo stripslashes($obj{"oasis_instructions_not_understand"});?>" />



<table class="formtable" border="0">
					<tr>
						<td colspan="4" align="center">
						<br />
							<strong><?php xl("DME/MEDICAL SUPPLIES ","e");?></strong>
							<label><input type="checkbox" name="oasis_dme" value="NA" <?php if($obj{"oasis_dme"}=="NA") echo "checked"; ?> ><?php xl('NA','e')?></label>
						</td>
					</tr>
					<tr valign="top">
						<td>
							<strong><?php xl("WOUND CARE: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="2x2s" <?php if(in_array("2x2s",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('2x2s','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="4x4s" <?php if(in_array("4x4s",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('4x4s','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="ABDs" <?php if(in_array("ABDs",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('ABDs','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Cotton tipped applicators" <?php if(in_array("Cotton tipped applicators",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Cotton tipped applicators','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Wound cleanser" <?php if(in_array("Wound cleanser",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Wound cleanser','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Wound gel" <?php if(in_array("Wound gel",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Wound gel','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Drain sponges" <?php if(in_array("Drain sponges",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Drain sponges','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Gloves:" <?php if(in_array("Gloves:",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Gloves:','e')?></label>
								<label><input type="checkbox" name="oasis_dme_wound_care_glove" value="Sterile" <?php if($obj{"oasis_dme_wound_care_glove"}=="Sterile") echo "checked"; ?> ><?php xl('Sterile','e')?></label>
								<label><input type="checkbox" name="oasis_dme_wound_care_glove" value="Non-Sterile" <?php if($obj{"oasis_dme_wound_care_glove"}=="Non-Sterile") echo "checked"; ?> ><?php xl('Non-Sterile','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Hydrocolloids" <?php if(in_array("Hydrocolloids",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Hydrocolloids','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Kerlix size" <?php if(in_array("Kerlix size",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Kerlix size','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Nu-gauze" <?php if(in_array("Nu-gauze",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Nu-gauze','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Saline" <?php if(in_array("Saline",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Saline','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Tape" <?php if(in_array("Tape",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Transparent Dressings" <?php if(in_array("Transparent Dressings",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Transparent Dressings','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Other" <?php if(in_array("Other",$oasis_dme_wound_care)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_wound_care_other" value="<?php echo stripslashes($obj{"oasis_dme_wound_care_other"});?>" ><br><br>
								
							<strong><?php xl("DIABETIC: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_diabetic[]" value="Chemstrips" <?php if(in_array("Chemstrips",$oasis_dme_diabetic)) echo "checked"; ?> ><?php xl('Chemstrips','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_diabetic[]" value="Syringes" <?php if(in_array("Syringes",$oasis_dme_diabetic)) echo "checked"; ?> ><?php xl('Syringes','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_diabetic[]" value="Other" <?php if(in_array("Other",$oasis_dme_diabetic)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_diabetic_other" value="<?php echo stripslashes($obj{"oasis_dme_diabetic_other"});?>" ><br><br>
						</td>
						<td>
							<strong><?php xl("IV SUPPLIES: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV start kit" <?php if(in_array("IV start kit",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV start kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV pole" <?php if(in_array("IV pole",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV pole','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV tubing" <?php if(in_array("IV tubing",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV tubing','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Alcohol swabs" <?php if(in_array("Alcohol swabs",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Alcohol swabs','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Angiocatheter size" <?php if(in_array("Angiocatheter size",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Angiocatheter size','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Tape" <?php if(in_array("Tape",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Extension tubings" <?php if(in_array("Extension tubings",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Extension tubings','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Injection caps" <?php if(in_array("Injection caps",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Injection caps','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Central line dressing" <?php if(in_array("Central line dressing",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Central line dressing','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Infusion pump" <?php if(in_array("Infusion pump",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Infusion pump','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Batteries size" <?php if(in_array("Batteries size",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Batteries size','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Syringes size" <?php if(in_array("Syringes size",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Syringes size','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Other" <?php if(in_array("Other",$oasis_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_iv_supplies_other" value="<?php echo stripslashes($obj{"oasis_dme_iv_supplies_other"});?>" ><br><br>
							
							<strong><?php xl("FOLEY SUPPLIES: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Fr catheter kit" <?php if(in_array("Fr catheter kit",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Fr catheter kit','e')?></label><br>
							<?php xl("(tray, bag, foley) ","e");?><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Straight catheter" <?php if(in_array("Straight catheter",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Straight catheter','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Irrigation tray" <?php if(in_array("Irrigation tray",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Irrigation tray','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Saline" <?php if(in_array("Saline",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Saline','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Acetic acid" <?php if(in_array("Acetic acid",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Acetic acid','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Other" <?php if(in_array("Other",$oasis_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Other','e')?></label><br>
								<input type="text" name="oasis_dme_foley_supplies_other" value="<?php echo stripslashes($obj{"oasis_dme_foley_supplies_other"});?>" ><br><br>
						</td>
						<td>
							<strong><?php xl("URINARY/OSTOMY: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Underpads" <?php if(in_array("Underpads",$oasis_dme_urinary)) echo "checked"; ?> ><?php xl('Underpads','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="External catheters" <?php if(in_array("External catheters",$oasis_dme_urinary)) echo "checked"; ?> ><?php xl('External catheters','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Urinary bag/pouch" <?php if(in_array("Urinary bag/pouch",$oasis_dme_urinary)) echo "checked"; ?> ><?php xl('Urinary bag/pouch','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Ostomy pouch (brand, size)" <?php if(in_array("Ostomy pouch (brand, size)",$oasis_dme_urinary)) echo "checked"; ?> ><?php xl('Ostomy pouch (brand, size)','e')?></label><br>
							<input type="text" name="oasis_dme_ostomy_pouch_brand"  value="<?php echo stripslashes($obj{"oasis_dme_ostomy_pouch_brand"});?>"  size="7">
							<input type="text" name="oasis_dme_ostomy_pouch_size"  value="<?php echo stripslashes($obj{"oasis_dme_ostomy_pouch_size"});?>"  size="7"><br />
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Ostomy wafer (brand, size)" <?php if(in_array("Ostomy wafer (brand, size)",$oasis_dme_urinary)) echo "checked"; ?> ><?php xl('Ostomy wafer (brand, size)','e')?></label><br>
							<input type="text" name="oasis_dme_ostomy_wafer_brand"  value="<?php echo stripslashes($obj{"oasis_dme_ostomy_wafer_brand"});?>"  size="7">
							<input type="text" name="oasis_dme_ostomy_wafer_size"  value="<?php echo stripslashes($obj{"oasis_dme_ostomy_wafer_size"});?>"  size="7"><br />
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Stoma adhesive tape" <?php if(in_array("Stoma adhesive tape",$oasis_dme_urinary)) echo "checked"; ?> ><?php xl('Stoma adhesive tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Skin protectant" <?php if(in_array("Skin protectant",$oasis_dme_urinary)) echo "checked"; ?> ><?php xl('Skin protectant','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Other" <?php if(in_array("Other",$oasis_dme_urinary)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_urinary_other"  value="<?php echo stripslashes($obj{"oasis_dme_urinary_other"});?>" ><br><br>
							
							<strong><?php xl("MISCELLANEOUS: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Enema supplies" <?php if(in_array("Enema supplies",$oasis_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Enema supplies','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Feeding tube" <?php if(in_array("Feeding tube",$oasis_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Feeding tube:','e')?></label><br>
							<?php xl('type','e')?><input type="text" name="oasis_dme_miscellaneous_type"  value="<?php echo stripslashes($obj{"oasis_dme_miscellaneous_type"});?>"  size="7">
							<?php xl('size','e')?><input type="text" name="oasis_dme_miscellaneous_size"  value="<?php echo stripslashes($obj{"oasis_dme_miscellaneous_size"});?>"  size="7"><br />
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Suture removal kit" <?php if(in_array("Suture removal kit",$oasis_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Suture removal kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Staple removal kit" <?php if(in_array("Staple removal kit",$oasis_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Staple removal kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Steri strips" <?php if(in_array("Steri strips",$oasis_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Steri strips','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Other" <?php if(in_array("Other",$oasis_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_miscellaneous_other"  value="<?php echo stripslashes($obj{"oasis_dme_miscellaneous_other"});?>" ><br>
						</td>
						<td>
							<strong><?php xl("SUPPLIES/EQUIPMENT: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Bathbench" <?php if(in_array("Bathbench",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Bathbench','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Cane" <?php if(in_array("Cane",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Cane','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Commode" <?php if(in_array("Commode",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Commode','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Special mattress overlay" <?php if(in_array("Special mattress overlay",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Special mattress overlay','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Pressure relieving device" <?php if(in_array("Pressure relieving device",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Pressure relieving device','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Eggcrate" <?php if(in_array("Eggcrate",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Eggcrate','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Hospital bed" <?php if(in_array("Hospital bed",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Hospital bed','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Hoyer lift" <?php if(in_array("Hoyer lift",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Hoyer lift','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Enteral feeding pump" <?php if(in_array("Enteral feeding pump",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Enteral feeding pump','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Nebulizer" <?php if(in_array("Nebulizer",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Nebulizer','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Oxygen concentrator" <?php if(in_array("Oxygen concentrator",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Oxygen concentrator','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Suction machine" <?php if(in_array("Suction machine",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Suction machine','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Ventilator" <?php if(in_array("Ventilator",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Ventilator','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Walker" <?php if(in_array("Walker",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Walker','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Wheelchair" <?php if(in_array("Wheelchair",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Wheelchair','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Tens unit" <?php if(in_array("Tens unit",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Tens unit','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Other" <?php if(in_array("Other",$oasis_dme_supplies)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
								<input type="text" name="oasis_dme_supplies_other"  value="<?php echo stripslashes($obj{"oasis_dme_supplies_other"});?>" "><br>
						</td>
					</tr>
			</table>


<br />
<br />
<hr />


<strong><?php xl("DISCHARGE PLAN:","e");?></strong>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Assist Pt/Cg in attaining goals & DC" <?php if(in_array("Assist Pt/Cg in attaining goals & DC",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('Assist Pt/Cg in attaining goals & DC','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Physician Supervision" <?php if(in_array("Physician Supervision",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('Physician Supervision','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Cg Assistance" <?php if(in_array("Cg Assistance",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('Cg Assistance','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Long Term Care" <?php if(in_array("Long Term Care",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('Long Term Care','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="ADHC" <?php if(in_array("ADHC",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('ADHC','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Nursing Home Placement" <?php if(in_array("Nursing Home Placement",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('Nursing Home Placement','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Transfer to Hospice" <?php if(in_array("Transfer to Hospice",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('Transfer to Hospice','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Ongoing Skilled Nursing - Tube Changes" <?php if(in_array("Ongoing Skilled Nursing - Tube Changes",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('Ongoing Skilled Nursing - Tube Changes','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Other" <?php if(in_array("Other",$oasis_discharge_plan)) echo "checked"; ?> ><?php xl('Other','e')?></label>
				<input type="text" name="oasis_discharge_plan_other"  value="<?php echo stripslashes($obj{"oasis_discharge_plan_other"});?>" ><br />
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Patient to be discharged when skilled care no longer needed" <?php if(in_array("Patient to be discharged when skilled care no longer needed",$oasis_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Patient to be discharged when skilled care no longer needed','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Patient to be discharged to the care of" <?php if(in_array("Patient to be discharged to the care of",$oasis_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Patient to be discharged to the care of:','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Self" <?php if(in_array("Self",$oasis_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Self','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Caregiver" <?php if(in_array("Caregiver",$oasis_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Caregiver','e')?></label>
			<br />
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Other" <?php if(in_array("Other",$oasis_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
<input type="text" name="oasis_discharge_plan_detail_other"  value="<?php echo stripslashes($obj{"oasis_discharge_plan_detail_other"});?>" >

<br />
<center><strong><?php xl("APPLIANCES/SPECIAL EQUIPMENT/ORGANIZATIONS","e");?></strong></center>

<table width="100%" border="0" class="formtable">
<tr>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Brace/Orthotics(specify)" <?php if(in_array("Brace/Orthotics(specify)",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Brace/Orthotics(specify)','e')?></label>
<input type="text" name="oasis_appliances_brace"  value="<?php echo stripslashes($obj{"oasis_appliances_brace"});?>" >
</td>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Transfer equipment: Board/Lift" <?php if(in_array("Transfer equipment: Board/Lift",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Transfer equipment: Board/Lift','e')?></label>
</td>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Bedside commode" <?php if(in_array("Bedside commode",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Bedside commode','e')?></label>
</td>
</tr>


<tr>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Prosthesis: RUE/RLE/LUE/LLE/Other" <?php if(in_array("Prosthesis: RUE/RLE/LUE/LLE/Other",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Prosthesis: RUE/RLE/LUE/LLE/Other','e')?></label>
</td>
<td colspan="2">
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Grab bars: Bathroom/Other" <?php if(in_array("Grab bars: Bathroom/Other",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Grab bars: Bathroom/Other','e')?></label>
</td>
</tr>


<tr>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Hospital bed: Semi-elec /Crank/Spec." <?php if(in_array("Hospital bed: Semi-elec /Crank/Spec.",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Hospital bed: Semi-elec /Crank/Spec.','e')?></label>
</td>
<td colspan="2">
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Lifeline" <?php if(in_array("Lifeline",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Lifeline','e')?></label>
</td>
</tr>

<tr>
<td colspan="3">
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Needs (specify)" <?php if(in_array("Needs (specify)",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Needs (specify)','e')?></label>
<br />
<textarea name="oasis_appliances_equipments_needs" rows="3" cols="98">
<?php echo stripslashes($obj{"oasis_appliances_equipments_needs"});?>
</textarea>
</td>
</tr>

</table>


<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Oxygen:" <?php if(in_array("Oxygen:",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Oxygen:','e')?></label>
<?php xl('  HME Co','e')?>
<input type="text" name="oasis_appliances_equipments_HME_co"  value="<?php echo stripslashes($obj{"oasis_appliances_equipments_HME_co"});?>"  size="10">
<?php xl('  HME Rep','e')?>
<input type="text" name="oasis_appliances_equipments_HME_rep"  value="<?php echo stripslashes($obj{"oasis_appliances_equipments_HME_rep"});?>"  size="10">
<?php xl('  Phone','e')?>
<input type="text" name="oasis_appliances_equipments_phone"  value="<?php echo stripslashes($obj{"oasis_appliances_equipments_phone"});?>"  size="20">
<br />
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Other organization providing service:" <?php if(in_array("Other organization providing service:",$oasis_appliances_equipments)) echo "checked"; ?> ><?php xl('Other organization providing service:','e')?></label>
<br />
<textarea name="oasis_appliances_equipments_other_organizations" rows="3" cols="98">
<?php echo stripslashes($obj{"oasis_appliances_equipments_other_organizations"});?>
</textarea>


	</td>
	</tr>
	
	
	
	
</table>
				</li>
			</ul>
		</li>
<li>
			<div><a href="#" id="black">Current level of Function and Physical assist</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong>
				<?php xl("CURRENT LEVEL OF FUNCTION AND PHYSICAL ASSIST","e");?><br>
				<?php xl("IND = Independent &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VC = Verbal Cues &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SBA = Standby Assist &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CGA = Contact Guard Assist","e");?><br>
				<?php xl("Min A = Minimum Assist &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mod A = Moderate Assist &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Max A = Maximum Assist &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unable N/A","e");?><br>
			</strong></center>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="formtable" border="1px" width="100%">
				<tr>
					<td colspan="2">
						<strong><?php xl("A. BED MOBILITY","e");?></strong>
					</td>
					<td colspan="4">
						<strong><?php xl("B. TRANSFERS Assistive Device Used:","e");?></strong>
					</td>
					<td colspan="2">
						<strong><?php xl("C. WHEELCHAIR MOBILITY","e");?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Turn/Roll","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_bed_mobility[]" value="<?php echo $oasis_therapy_curr_level_bed_mobility[0];?>">
					</td>
					<td>
						<?php xl("Sit to Stand","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[0];?>">
					</td>
					<td>
						<?php xl("Shower Tub","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[1];?>">
					</td>
					<td>
						<?php xl("Propulsion Level Surfaces","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_wheelchair_mobility[]" value="<?php echo $oasis_therapy_curr_level_wheelchair_mobility[0];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Scoot / Bridge","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_bed_mobility[]" value="<?php echo $oasis_therapy_curr_level_bed_mobility[1];?>">
					</td>
					<td>
						<?php xl("Stand to Sit","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[2];?>">
					</td>
					<td>
						<?php xl("Fall Recovery","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[3];?>">
					</td>
					<td>
						<?php xl("Propulsion Uneven Surfaces","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_wheelchair_mobility[]" value="<?php echo $oasis_therapy_curr_level_wheelchair_mobility[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Sit to Supine","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_bed_mobility[]" value="<?php echo $oasis_therapy_curr_level_bed_mobility[2];?>">
					</td>
					<td>
						<?php xl("Stand / Pivot","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[4];?>">
					</td>
					<td>
						<?php xl("Motor Vehicle","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[5];?>">
					</td>
					<td>
						<?php xl("Safety Locks","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_wheelchair_mobility[]" value="<?php echo $oasis_therapy_curr_level_wheelchair_mobility[2];?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Supine to Sit","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_bed_mobility[]" value="<?php echo $oasis_therapy_curr_level_bed_mobility[3];?>">
					</td>
					<td>
						<?php xl("Toilet","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[6];?>">
					</td>
					<td>
						<?php xl("Sliding Board","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[7];?>">
					</td>
					<td>
						<?php xl("Foot / Leg Rests","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_wheelchair_mobility[]" value="<?php echo $oasis_therapy_curr_level_wheelchair_mobility[3];?>">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php xl("Describe:","e");?>
						<input type="text" name="oasis_therapy_curr_level_bed_mobility[]" value="<?php echo $oasis_therapy_curr_level_bed_mobility[4];?>">
					</td>
					<td colspan="2">
						<?php xl("Describe:","e");?>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[8];?>">
					</td>
					<td colspan="2">
						<?php xl("Other:","e");?>
						<input type="text" name="oasis_therapy_curr_level_transfers[]" value="<?php echo $oasis_therapy_curr_level_transfers[9];?>">
					</td>
					<td colspan="2">
						<?php xl("Other:","e");?>
						<input type="text" name="oasis_therapy_curr_level_wheelchair_mobility[]" value="<?php echo $oasis_therapy_curr_level_wheelchair_mobility[4];?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<strong><?php xl("D. GAIT / AMBULATION Assistive Device Used:","e");?></strong>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="formtable" border="1px">
				<tr>
					<td>
						<?php xl("Wt Bearing Status(Describe):","e");?>
					</td>
					<td colspan="2">
						<b><?php xl("Surfaces","e");?></b>
					</td>
					<td>
						<b><?php xl("Assist","e");?></b>
					</td>
					<td>
						<b><?php xl("Distance","e");?></b>
					</td>
					<td>
						<b><?php xl("Assistive Device","e");?></b>
					</td>
					<td colspan="2">
						<b><?php xl("Surfaces","e");?></b>
					</td>
					<td>
						<b><?php xl("Assist","e");?></b>
					</td>
					<td>
						<b><?php xl("Distance","e");?></b>
					</td>
					<td>
						<b><?php xl("Assistive Device","e");?></b>
					</td>
				</tr>
				<tr>
					<td>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="FWB" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="FWB"){echo "checked";}?> ><?php xl(' FWB','e')?></label>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="PWB" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="PWB"){echo "checked";}?> ><?php xl(' PWB','e')?></label>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="WBA" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="WBA"){echo "checked";}?> ><?php xl(' WBA','e')?></label>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="NWB" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="NWB"){echo "checked";}?> ><?php xl(' NWB','e')?></label>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="TTWB" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="TTWB"){echo "checked";}?> ><?php xl(' TTWB','e')?></label>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="RLE" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="RLE"){echo "checked";}?> ><?php xl(' RLE','e')?></label>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="RUE" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="RUE"){echo "checked";}?> ><?php xl(' RUE','e')?></label>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="LLE" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="LLE"){echo "checked";}?> ><?php xl(' LLE','e')?></label>
						<label><input type="radio" name="oasis_therapy_curr_level_gait_status" value="LUE" <?php if($obj{"oasis_therapy_curr_level_gait_status"}=="LUE"){echo "checked";}?> ><?php xl(' LUE','e')?></label>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[0];?>">
					</td>
					<td>
						<?php xl("Level","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[2];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[4];?>">
					</td>
					<td>
						<?php xl("Stairs","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[5];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[6];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[7];?>">
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[8];?>">
					</td>
					<td>
						<?php xl("Uneven","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[9];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[10];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[11];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[12];?>">
					</td>
					<td>
						<?php xl("Ramp","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[13];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[14];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_curr_level_gait[]" value="<?php echo $oasis_therapy_curr_level_gait[15];?>">
					</td>
				</tr>
				<tr>
					<td colspan="11">
						<strong>
							<?php xl("Assistive Device (Describe):","e");?>
							<input type="text" name="oasis_therapy_curr_level_assistive_device" value="<?php echo $obj{"oasis_therapy_curr_level_assistive_device"};?>">
							<?php xl("How Frequently Used:","e");?>
							<label><input type="checkbox" name="oasis_therapy_curr_level_device_freq" value="Daily" <?php if($obj{"oasis_therapy_curr_level_device_freq"}=="Daily"){echo "checked";}?> ><?php xl('Daily','e')?></label>
							<label><input type="checkbox" name="oasis_therapy_curr_level_device_freq" value="Constantly" <?php if($obj{"oasis_therapy_curr_level_device_freq"}=="Constantly"){echo "checked";}?> ><?php xl('Constantly','e')?></label>
							<label><input type="checkbox" name="oasis_therapy_curr_level_device_freq" value="Intermittently" <?php if($obj{"oasis_therapy_curr_level_device_freq"}=="Intermittently"){echo "checked";}?> ><?php xl('Intermittently','e')?></label>
						</strong>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="formtable" border="1px" style="width:100%;">
				<tr>
					<td colspan="14">
						<strong><?php xl("MUSCULOSKELETAL ANALYSIS ASSESSMENT: STRENGTH & ROM ASSESSMENT","e");?></strong>
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("KEY","e");?></strong>
					</td>
					<td colspan="2" align="center">
						<strong><?php xl("STRENGTH","e");?></strong>
					</td>
					<td colspan="2" align="center">
						<strong><?php xl("ROM","e");?></strong>
					</td>
					<td colspan="2" align="center">
						<strong><?php xl("PAIN 0 / 10","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("KEY","e");?></strong>
					</td>
					<td colspan="2" align="center">
						<strong><?php xl("STRENGTH","e");?></strong>
					</td>
					<td colspan="2" align="center">
						<strong><?php xl("ROM","e");?></strong>
					</td>
					<td colspan="2" align="center">
						<strong><?php xl("PAIN 0 / 10","e");?></strong>
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong><?php xl("Strength: 0/5 ? 5/5","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("L","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("R","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("L","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("R","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("L","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("R","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("Strength: 0/5 ? 5/5","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("L","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("R","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("L","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("R","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("L","e");?></strong>
					</td>
					<td align="center">
						<strong><?php xl("R","e");?></strong>
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("<b>SHOULDER</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[0];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[0];?>">
					</td>
					<td align="right">
						<?php xl("Hand Grip Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[1];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[1];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[2];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[2];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[2];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[2];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[2];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[2];?>">
					</td>
					<td align="right">
						<?php xl("<b>HIP</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[3];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[3];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("ABD / ADD","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[4];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[4];?>">
					</td>
					<td align="right">
						<?php xl("Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[5];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[5];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[5];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[5];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[5];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[5];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("IR","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[6];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[6];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[6];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[6];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[6];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[6];?>">
					</td>
					<td align="right">
						<?php xl("ABD / ADD","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[7];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[7];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[7];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[7];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[7];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[7];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("ER","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[8];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[8];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[8];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[8];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[8];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[8];?>">
					</td>
					<td align="right">
						<?php xl("IR/ER","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[9];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[9];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[9];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[9];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[9];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[9];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("<b>ELBOW</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[10];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[10];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[10];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[10];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[10];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[10];?>">
					</td>
					<td align="right">
						<?php xl("<b>Knee</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[11];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[11];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[11];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[11];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[11];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[11];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[12];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[12];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[12];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[12];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[12];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[12];?>">
					</td>
					<td align="right">
						<?php xl("Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[13];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[13];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[13];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[13];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[13];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[13];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("<b>FOREARM</b> Pronation","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[14];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[14];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[14];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[14];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[14];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[14];?>">
					</td>
					<td align="right">
						<?php xl("<b>ANKLE</b> Dorsiflexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[15];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[15];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[15];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[15];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[15];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[15];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("Supination","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[16];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[16];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[16];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[16];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[16];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[16];?>">
					</td>
					<td align="right">
						<?php xl("Plantar Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[17];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[17];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[17];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[17];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[17];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[17];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("<b>WRIST</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[18];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[18];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[18];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[18];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[18];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[18];?>">
					</td>
					<td align="right">
						<?php xl("Inv / Eversion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[19];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[19];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[19];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[19];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[19];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[19];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[20];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[20];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[20];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[20];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[20];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[20];?>">
					</td>
					<td align="right">
						<?php xl("<b>NECK</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[21];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[21];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[21];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[21];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[21];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[21];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("<b>HAND</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[22];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[22];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[22];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[22];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[22];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[22];?>">
					</td>
					<td align="right">
						<?php xl("Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[23];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[23];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[23];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[23];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[23];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[23];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[24];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[24];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[24];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[24];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[24];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[24];?>">
					</td>
					<td align="right">
						<?php xl("Rotation","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[25];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[25];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[25];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[25];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[25];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[25];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("Grip Strength","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[26];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[26];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[26];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[26];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[26];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[26];?>">
					</td>
					<td align="right">
						<?php xl("<b>Trunk</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[27];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[27];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[27];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[27];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[27];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[27];?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl("<b>HAND GRIP</b> Flexion","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[28];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[28];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[28];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[28];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[28];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[28];?>">
					</td>
					<td align="right">
						<?php xl("Extension","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_l[29];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_str_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_str_r[29];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_l[29];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_rom_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_rom_r[29];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_l[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_l[29];?>">
					</td>
					<td>
						<input type="text" name="oasis_therapy_musculoskeletal_analysis_pain_r[]" size="5" value="<?php echo $oasis_therapy_musculoskeletal_analysis_pain_r[29];?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<strong><?php xl("CLINICAL FINDINGS:","e");?></strong><br>
			<textarea name="oasis_therapy_curr_level_findings" rows="3" cols="98"><?php echo $obj{"oasis_therapy_curr_level_findings"};?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl("PATIENT'S ABNORMALITY OF GAIT DESCRIPTION","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="1px" class="formtable">
				<tr>
					<td>
						<input type="checkbox" name="oasis_therapy_curr_level_gait_desc" value="SPASTIC GAIT" <?php if($obj{"oasis_therapy_curr_level_gait_desc"}=="SPASTIC GAIT"){echo "checked";}?> >
					</td>
					<td>
						<?php xl("SPASTIC GAIT - stiff movement in that, the toes seem to catch and drag, the legs are held together","e");?>
					</td>
					<td>
						<input type="checkbox" name="oasis_therapy_curr_level_gait_desc" value="STAGGERING GAIT" <?php if($obj{"oasis_therapy_curr_level_gait_desc"}=="STAGGERING GAIT"){echo "checked";}?> >
					</td>
					<td>
						<?php xl("STAGGERING GAIT - sudden and unexpected lateral losses of balance","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="oasis_therapy_curr_level_gait_desc" value="ATAXIC GAIT" <?php if($obj{"oasis_therapy_curr_level_gait_desc"}=="ATAXIC GAIT"){echo "checked";}?> >
					</td>
					<td>
						<?php xl("ATAXIC GAIT - gait marked by staggering and unsteadiness","e");?>
					</td>
					<td>
						<input type="checkbox" name="oasis_therapy_curr_level_gait_desc" value="RETROPULSION AMBULATION" <?php if($obj{"oasis_therapy_curr_level_gait_desc"}=="RETROPULSION AMBULATION"){echo "checked";}?> >
					</td>
					<td>
						<?php xl("RETROPULSION AMBULATION - backwards walking tendency","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="oasis_therapy_curr_level_gait_desc" value="PARALYTIC GAIT" <?php if($obj{"oasis_therapy_curr_level_gait_desc"}=="PARALYTIC GAIT"){echo "checked";}?> >
					</td>
					<td>
						<?php xl("PARALYTIC GAIT - FLACCID","e");?>
					</td>
					<td>
						<input type="checkbox" name="oasis_therapy_curr_level_gait_desc" value="SHUFFLING" <?php if($obj{"oasis_therapy_curr_level_gait_desc"}=="SHUFFLING"){echo "checked";}?> >
					</td>
					<td>
						<?php xl("SHUFFLING","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="oasis_therapy_curr_level_gait_desc" value="ANTALGIC" <?php if($obj{"oasis_therapy_curr_level_gait_desc"}=="ANTALGIC"){echo "checked";}?> >
					</td>
					<td>
						<?php xl("ANTALGIC - Due to pain / painful limping","e");?>
					</td>
					<td>
						<input type="checkbox" name="oasis_therapy_curr_level_gait_desc" value="OTHER" <?php if($obj{"oasis_therapy_curr_level_gait_desc"}=="OTHER"){echo "checked";}?> >
					</td>
					<td>
						<?php xl("OTHER (Describe):","e");?>
						<input type="text" name="oasis_therapy_curr_level_gait_desc_other" value="<?php echo $obj{"oasis_therapy_curr_level_gait_desc_other"};?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<strong><?php xl("RISK FACTORS PREDISPOSING FOR FALL:","e");?></strong><br>
			<table border="0" class="formtable">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Improper use of Assistive Device" <?php if(in_array("Improper use of Assistive Device",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Improper use of Assistive Device","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Prosthesis / Orthotics" <?php if(in_array("Prosthesis / Orthotics",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Prosthesis / Orthotics","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="(Age over 65)" <?php if(in_array("(Age over 65)",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("(Age over 65)","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Confusion" <?php if(in_array("Confusion",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Confusion","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Postural Hypotension with Dizziness" <?php if(in_array("Postural Hypotension with Dizziness",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Postural Hypotension with Dizziness","e");?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Home Safety issues / Structural Barriers" <?php if(in_array("Home Safety issues / Structural Barriers",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Home Safety issues / Structural Barriers","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Weakness / Pain" <?php if(in_array("Weakness / Pain",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Weakness / Pain","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Assistive Device Malfunction" <?php if(in_array("Assistive Device Malfunction",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Assistive Device Malfunction","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Incontinence / Urgency" <?php if(in_array("Incontinence / Urgency",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Incontinence / Urgency","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Unable to ambulate independently" <?php if(in_array("Unable to ambulate independently",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Unable to ambulate independently <br>(Needs to use ambulatory aide, chairboard, etc)","e");?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="History of Falls" <?php if(in_array("History of Falls",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("History of Falls (Past 3 Months)","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Vertigo / Dizziness" <?php if(in_array("Vertigo / Dizziness",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Vertigo / Dizziness","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Sensory Deficit (Vision and/or Hearing)" <?php if(in_array("Sensory Deficit (Vision and/or Hearing)",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Sensory Deficit (Vision and/or Hearing)","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Gait / Balance / Coordination" <?php if(in_array("Gait / Balance / Coordination",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Gait / Balance / Coordination","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Impaired Judgment / Poor safety Awareness" <?php if(in_array("Impaired Judgment / Poor safety Awareness",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Impaired Judgment / Poor safety Awareness","e");?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Decreased Level of Cooperation" <?php if(in_array("Decreased Level of Cooperation",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Decreased Level of Cooperation","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Lack of Home Modifications" <?php if(in_array("Lack of Home Modifications",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Lack of Home Modifications(Bathroom, kitchen, Stairs Entries, & Safety bars, etc.)","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Alcohol Use" <?php if(in_array("Alcohol Use",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Alcohol Use","e");?></label><br>
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Other" <?php if(in_array("Other",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Other:","e");?></label>
							<input type="text" name="oasis_therapy_curr_level_risk_factor_other" value="<?php echo $obj{"oasis_therapy_curr_level_risk_factor_other"};?>">
					</td>
				</tr>
			</table>
			<br>
			<strong><?php xl("OTHER OBSERVED GAIT DEVIATION (Describe):","e");?></strong><br>
			<textarea name="oasis_therapy_curr_level_risk_factor_other_deviation" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_curr_level_risk_factor_other_deviation"};?></textarea><br>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>



</ul>



<!--<a id="btn_save" href="javascript:void(0)" class="link_submit"><?php xl(' [Save]','e')?></a>-->
<a id="btn_save" href="javascript:top.restoreSession();form_validation('oasis_pt_soc');"
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
