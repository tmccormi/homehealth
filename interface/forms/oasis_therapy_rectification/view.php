<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: oasis_therapy_rectification");
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
$formTable = "forms_oasis_therapy_rectification";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();




?>

<html>
<head>
<title>Oasis Therapy Rectification</title>
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
</script>
</head>
<body class="body_top">
<?php
$obj = formFetch("forms_oasis_therapy_rectification", $_GET["id"]);
$oasis_therapy_payment_source_homecare = explode("#",$obj{"oasis_therapy_payment_source_homecare"});
$oasis_therapy_therapies_home = explode("#",$obj{"oasis_therapy_therapies_home"});
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
$oasis_therapy_pressure_ulcer_a = explode("#",$obj{"oasis_therapy_pressure_ulcer_a"});
$oasis_therapy_pressure_ulcer_b = explode("#",$obj{"oasis_therapy_pressure_ulcer_b"});
$oasis_therapy_pressure_ulcer_c = explode("#",$obj{"oasis_therapy_pressure_ulcer_c"});
$oasis_therapy_pressure_ulcer_d1 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d1"});
$oasis_therapy_pressure_ulcer_d2 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d2"});
$oasis_therapy_pressure_ulcer_d3 = explode("#",$obj{"oasis_therapy_pressure_ulcer_d3"});
$oasis_therapy_vital_sign_blood_pressure = explode("#",$obj{"oasis_therapy_vital_sign_blood_pressure"});
$oasis_therapy_vital_sign_pulse_type = explode("#",$obj{"oasis_therapy_vital_sign_pulse_type"});
$oasis_therapy_breath_sounds = explode("#",$obj{"oasis_therapy_breath_sounds"});
$oasis_therapy_heart_sounds = explode("#",$obj{"oasis_therapy_heart_sounds"});
$oasis_therapy_urinary = explode("#",$obj{"oasis_therapy_urinary"});
$oasis_therapy_bowels = explode("#",$obj{"oasis_therapy_bowels"});
$oasis_therapy_activities_permitted = explode("#",$obj{"oasis_therapy_activities_permitted"});
$oasis_therapy_fall_risk_assessment = explode("#",$obj{"oasis_therapy_fall_risk_assessment"});
$oasis_therapy_homebound_reason = explode("#",$obj{"oasis_therapy_homebound_reason"});
$oasis_therapy_summary_check_identified = explode("#",$obj{"oasis_therapy_summary_check_identified"});
$oasis_therapy_dme_wound_care = explode("#",$obj{"oasis_therapy_dme_wound_care"});
$oasis_therapy_dme_diabetic = explode("#",$obj{"oasis_therapy_dme_diabetic"});
$oasis_therapy_dme_iv_supplies = explode("#",$obj{"oasis_therapy_dme_iv_supplies"});
$oasis_therapy_dme_foley_supplies = explode("#",$obj{"oasis_therapy_dme_foley_supplies"});
$oasis_therapy_dme_urinary = explode("#",$obj{"oasis_therapy_dme_urinary"});
$oasis_therapy_dme_miscellaneous = explode("#",$obj{"oasis_therapy_dme_miscellaneous"});
$oasis_therapy_dme_supplies = explode("#",$obj{"oasis_therapy_dme_supplies"});
$oasis_therapy_safety_measures = explode("#",$obj{"oasis_therapy_safety_measures"});
$oasis_therapy_nutritional_requirement = explode("#",$obj{"oasis_therapy_nutritional_requirement"});
$oasis_therapy_allergies = explode("#",$obj{"oasis_therapy_allergies"});
$oasis_therapy_functional_limitations = explode("#",$obj{"oasis_therapy_functional_limitations"});
$oasis_therapy_mental_status = explode("#",$obj{"oasis_therapy_mental_status"});
$oasis_therapy_discharge_plan = explode("#",$obj{"oasis_therapy_discharge_plan"});
$oasis_therapy_discharge_plan_detail = explode("#",$obj{"oasis_therapy_discharge_plan_detail"});
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
$oasis_therapy_pt_orders = explode("#",$obj{"oasis_therapy_pt_orders"});
$oasis_therapy_pt_orders_degree_of_motion = explode("#",$obj{"oasis_therapy_pt_orders_degree_of_motion"});
$oasis_therapy_pt_goals_gait = explode("#",$obj{"oasis_therapy_pt_goals_gait"});
$oasis_therapy_pt_goals_bath = explode("#",$obj{"oasis_therapy_pt_goals_bath"});
$oasis_therapy_pt_goals_bed = explode("#",$obj{"oasis_therapy_pt_goals_bed"});
$oasis_therapy_pt_goals_car = explode("#",$obj{"oasis_therapy_pt_goals_car"});
$oasis_therapy_pt_goals_therapeutic = explode("#",$obj{"oasis_therapy_pt_goals_therapeutic"});
$oasis_therapy_pt_goals_transfers = explode("#",$obj{"oasis_therapy_pt_goals_transfers"});
$oasis_therapy_pt_goals_safety = explode("#",$obj{"oasis_therapy_pt_goals_safety"});
$oasis_therapy_pt_goals_wheelchair = explode("#",$obj{"oasis_therapy_pt_goals_wheelchair"});
$oasis_therapy_pt_goals_other = explode("#",$obj{"oasis_therapy_pt_goals_other"});
?>



<form method="post"
		action="<?php echo $rootdir;?>/forms/oasis_therapy_rectification/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="oasis_therapy_rectification">
		<h3 align="center"><?php xl('OASIS-C PT RECERT (V1)','e')?></h3>		
		
		


<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="left">
			<?php xl('Patient Name','e');?>
			<input type="text" name="oasis_therapy_patient_name" value="<?php patientfullName();?>" readonly >
		</td>
		<td align="right">
			<table border="0" cellspacing="0" class="formtable" style="width:100%;">
				<tr>
					<td align="right">
						<?php xl('Caregiver: ','e');?>
						<input type="text" name="oasis_therapy_caregiver" value="<?php echo $obj{"oasis_therapy_caregiver"};?>">
					</td>
					<td align="right">
						<?php xl('Visit Date','e');?>
						<input type='text' size='10' name='oasis_therapy_visit_date' value="<?php echo $obj{"oasis_therapy_visit_date"};?>" readonly /> 
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
		<div><a href="#" id="black">Patient Tracking Information</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>	

<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="center">
			<strong><?php xl('PATIENT TRACKING INFORMATION','e');?></strong>
		</td>
		<td align="center">
			<strong><?php xl('PATIENT TRACKING INFORMATION(CONTD)','e');?></strong>
		</td>
	</tr>
	<tr>
		<td rowspan="7">
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
			<?php xl('Primary Referring Physician I.D.: ','e');?>
			<input type="text" name="oasis_therapy_referring_physician_id" value="<?php echo $obj{"oasis_therapy_referring_physician_id"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_referring_physician_id_na" value="N/A" <?php if($obj{"oasis_therapy_referring_physician_id_na"}=="N/A"){echo "checked";}?> ><?php xl('UK - Unknown or Not Available','e');?></label><br>
			</strong>
			<br>
			
			<strong><?php xl('Primary Referring Physician: ','e');?></strong><br>
			<table  class="formtable">
			<tr>
			<td>
			<?php xl('Last: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_primary_physician_last" value="<?php echo $obj{"oasis_therapy_primary_physician_last"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('First: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_primary_physician_first" value="<?php echo $obj{"oasis_therapy_primary_physician_first"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Phone: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_primary_physician_phone" value="<?php echo $obj{"oasis_therapy_primary_physician_phone"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Address: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_primary_physician_address" value="<?php echo $obj{"oasis_therapy_primary_physician_address"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('City: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_primary_physician_city" value="<?php echo $obj{"oasis_therapy_primary_physician_city"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('State: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_primary_physician_state" value="<?php echo $obj{"oasis_therapy_primary_physician_state"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Zip Code: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_primary_physician_zip" value="<?php echo $obj{"oasis_therapy_primary_physician_zip"};?>"><br>
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
			<input type="text" name="oasis_therapy_other_physician_last" value="<?php echo $obj{"oasis_therapy_other_physician_last"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('First: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_other_physician_first" value="<?php echo $obj{"oasis_therapy_other_physician_first"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Phone: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_other_physician_phone" value="<?php echo $obj{"oasis_therapy_other_physician_phone"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Address: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_other_physician_address" value="<?php echo $obj{"oasis_therapy_other_physician_address"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('City: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_other_physician_city" value="<?php echo $obj{"oasis_therapy_other_physician_city"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('State: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_other_physician_state" value="<?php echo $obj{"oasis_therapy_other_physician_state"};?>"><br>
			</td></tr>
			<tr><td>
			<?php xl('Zip Code: ','e');?>
			</td><td>
			<input type="text" name="oasis_therapy_other_physician_zip" value="<?php echo $obj{"oasis_therapy_other_physician_zip"};?>"><br>
			</td>
			</tr>
			</table>
			<br>
			
			<strong>
			<?php xl('<u>(M0020)</u>Patient ID Number: ','e');?>
			<input type="text" name="oasis_therapy_patient_id" value="<?php patientName('pid');?>" readonly ><br>
			<?php xl('<u>(M0030)</u> Start of Care Date:','e');?>
				<input type='text' size='10' name='oasis_therapy_soc_date' id='oasis_therapy_soc_date' 
					title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_soc_date"};?>" readonly/> 
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
			<input type="text" name="oasis_therapy_medicare_no" value="<?php echo $obj{"oasis_therapy_medicare_no"};?>">
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
				<label><input type="radio" name="oasis_therapy_patient_gender" value="male" <?php if(patientName("sex")=="Male") echo "checked"; ?> ><?php xl('Male','e');?></label>
				<label><input type="radio" name="oasis_therapy_patient_gender" value="female" <?php if(patientName("sex")=="Female") echo "checked"; ?> ><?php xl('Female','e');?></label>
			
		</td>
		<td valign="top">
			<strong><?php xl('<u>(M0150)</u> Current Payment Sources for Home Care: (Mark all that apply.)','e');?><br></strong>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="0" <?php if(in_array("0",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 0 - None; no charge for current services','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="1" <?php if(in_array("1",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 1 - Medicare (traditional fee-for-service)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="2" <?php if(in_array("2",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 2 - Medicare (HMO/managed care/Advantage plan)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="3" <?php if(in_array("3",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 3 - Medicaid (traditional fee-for-service)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="4" <?php if(in_array("4",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 4 - Medicaid (HMO/managed care)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="5" <?php if(in_array("5",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 5 - Workers" compensation','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="6" <?php if(in_array("6",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 6 - Title programs (e.g., Title III, V, or XX)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="7" <?php if(in_array("7",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 7 - Other government (e.g., TriCare, VA, etc.)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="8" <?php if(in_array("8",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 8 - Private insurance','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="9" <?php if(in_array("9",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 9 - Private HMO/managed care','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="10" <?php if(in_array("10",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 10 - Self-pay','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="11" <?php if(in_array("11",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' 11 - Other (specify)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_payment_source_homecare[]" value="UK" <?php if(in_array("UK",$oasis_therapy_payment_source_homecare)) echo "checked"; ?> ><?php xl(' UK - Unknown','e')?></label><br>
		</td>
	</tr>
	<tr>
		<td align="center">
			<strong><?php xl('CLINICAL RECORD ITEMS','e');?></strong>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('<u>(M0080)</u> Discipline of Person Completing Assessment:','e');?></strong><br>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="1" <?php if($obj{"oasis_therapy_discipline_person"}=="1"){echo "checked";}?> ><?php xl(' 1 - RN ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="2" <?php if($obj{"oasis_therapy_discipline_person"}=="2"){echo "checked";}?> ><?php xl(' 2 - PT ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="3" <?php if($obj{"oasis_therapy_discipline_person"}=="3"){echo "checked";}?> ><?php xl(' 3 - SLP/ST ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="4" <?php if($obj{"oasis_therapy_discipline_person"}=="4"){echo "checked";}?> ><?php xl(' 4 - OT ','e');?></label>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('<u>(M0090)</u> Date Assessment Completed: ','e');?></strong>
			<input type='text' size='10' name='oasis_therapy_date_assessment_completed' id='oasis_therapy_date_assessment_completed' 
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_date_assessment_completed"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_date_assessment_completed", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
					</script>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('<u>(M0100)</u> This Assessment is Currently Being Completed for the Following Reason: <u>Follow-Up</u> ','e');?></strong><br>
				<label><input type="radio" name="oasis_therapy_follow_up" value="4" <?php if($obj{"oasis_therapy_follow_up"}=="4"){echo "checked";}?> ><?php xl(' 4 - Recertification (follow-up) reassessment <strong>[ Go to M0110 ]</strong>','e');?></label><br>
				<label><input type="radio" name="oasis_therapy_follow_up" value="5" <?php if($obj{"oasis_therapy_follow_up"}=="5"){echo "checked";}?> ><?php xl(' 5 - Other follow-up <strong>[ Go to M0110 ]</strong>','e');?></label>
		</td>
	</tr>
	<tr>
		<td>
			<?php xl('<b><u>(M0110)</u> Episode Timing:</b> Is the Medicare home health payment episode for which this assessment will define a case mix group an "early" episode or a "later" episode in the patient"s current sequence of adjacent Medicare home health payment episodes? ','e');?><br>
				<label><input type="radio" name="oasis_therapy_episode_timing" value="1" <?php if($obj{"oasis_therapy_episode_timing"}=="1"){echo "checked";}?> ><?php xl(' 1 - Early','e');?></label><br>
				<label><input type="radio" name="oasis_therapy_episode_timing" value="2" <?php if($obj{"oasis_therapy_episode_timing"}=="2"){echo "checked";}?> ><?php xl(' 2 - Later','e');?></label><br>
				<label><input type="radio" name="oasis_therapy_episode_timing" value="UK" <?php if($obj{"oasis_therapy_episode_timing"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown','e');?></label><br>
				<label><input type="radio" name="oasis_therapy_episode_timing" value="NA" <?php if($obj{"oasis_therapy_episode_timing"}=="NA"){echo "checked";}?> ><?php xl(' NA - Not Applicable: No Medicare case mix group to be defined by this assessment.','e');?></label>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('Certification Period From: ','e');?></strong>
			<input type='text' size='10' name='oasis_therapy_certification_period_from' id='oasis_therapy_certification_period_from' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_certification_period_from"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date5' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_certification_period_from", ifFormat:"%Y-%m-%d", button:"img_curr_date5"});
					</script>
			<?php xl(' To: ','e');?>
			<input type='text' size='10' name='oasis_therapy_certification_period_to' id='oasis_therapy_certification_period_to' 
					title='<?php xl('yyyy-mm-dd To','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_certification_period_to"};?> " readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date5b' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_certification_period_to", ifFormat:"%Y-%m-%d", button:"img_curr_date5b"});
					</script>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Patient History and diagnosis, Sensory Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td align="center" colspan="2">
			<strong><?php xl('PATIENT HISTORY AND DIAGNOSIS','e');?></strong>
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
		<td align="center">
			<strong><?php xl('PATIENT HISTORY AND DIAGNOSIS (CONTD)','e'); ?></strong>
		</td>
		<td align="center">
			<strong><?php xl('SENSORY STATUS','e'); ?></strong>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('<u>(M1030)</u></strong> Therapies the patient receives <u>at home</u>: <strong>(Mark all that apply.)</strong>','e'); ?><br>
			<label><input type="checkbox" name="oasis_therapy_therapies_home[]" value="1" <?php if(in_array("1",$oasis_therapy_therapies_home)) echo "checked"; ?> ><?php xl(' 1 - Intravenous or infusion therapy (excludes TPN)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_therapies_home[]" value="2" <?php if(in_array("2",$oasis_therapy_therapies_home)) echo "checked"; ?> ><?php xl(' 2 - Parenteral nutrition (TPN or lipids)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_therapies_home[]" value="3" <?php if(in_array("3",$oasis_therapy_therapies_home)) echo "checked"; ?> ><?php xl(' 3 - Enteral nutrition (nasogastric, gastrostomy, jejunostomy, or any other artificial entry into the alimentary canal)','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_therapies_home[]" value="4" <?php if(in_array("4",$oasis_therapy_therapies_home)) echo "checked"; ?> ><?php xl(' 4 - None of the above','e')?></label>
		</td>
		<td>
			<strong><?php xl('<u>(M1200)</u> Vision</strong> (with corrective lenses if the patient usually wears them):','e'); ?><br>
			<label><input type="radio" name="oasis_therapy_vision" value="0" <?php if($obj{"oasis_therapy_vision"}=="0"){echo "checked";}?> ><?php xl(' 0 - Normal vision: sees adequately in most situations; can see medication labels, newsprint.','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_vision" value="1" <?php if($obj{"oasis_therapy_vision"}=="1"){echo "checked";}?> ><?php xl(' 1 - Partially impaired: cannot see medication labels or newsprint, but <u>can</u> see obstacles in path, and the surrounding layout; can count fingers at arm"s length.','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_vision" value="2" <?php if($obj{"oasis_therapy_vision"}=="2"){echo "checked";}?> ><?php xl(' 2 - Severely impaired: cannot locate objects without hearing or touching them or patient nonresponsive.','e')?></label>
		</td>
	</tr>
	<tr>
		<td>
			<center><strong><?php xl('PROGNOSIS','e')?></strong></center><br>
			<b><?php xl('Prognosis:','e')?></b>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="1" <?php if($obj{"oasis_therapy_pragnosis"}=="1"){echo "checked";}?> ><?php xl(' 1-Poor ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="2" <?php if($obj{"oasis_therapy_pragnosis"}=="2"){echo "checked";}?> ><?php xl(' 2-Guarded ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="3" <?php if($obj{"oasis_therapy_pragnosis"}=="3"){echo "checked";}?> ><?php xl(' 3-Fair ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="4" <?php if($obj{"oasis_therapy_pragnosis"}=="4"){echo "checked";}?> ><?php xl(' 4-Good ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="5" <?php if($obj{"oasis_therapy_pragnosis"}=="5"){echo "checked";}?> ><?php xl(' 5-Excellent ','e')?></label>
		</td>
		<td>
			<strong><?php xl('<u>(M1242)</u> Frequency of Pain Interfering </strong> with patient"s activity or movement:','e'); ?><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="0" <?php if($obj{"oasis_therapy_frequency_pain"}=="0"){echo "checked";}?> ><?php xl(' 0 - Patient has no pain','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="1" <?php if($obj{"oasis_therapy_frequency_pain"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient has pain that does not interfere with activity or movement','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="2" <?php if($obj{"oasis_therapy_frequency_pain"}=="2"){echo "checked";}?> ><?php xl(' 2 - Less often than daily','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="3" <?php if($obj{"oasis_therapy_frequency_pain"}=="3"){echo "checked";}?> ><?php xl(' 3 - Daily, but not constantly','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="4" <?php if($obj{"oasis_therapy_frequency_pain"}=="4"){echo "checked";}?> ><?php xl(' 4 - All of the time','e')?></label>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Pain, Integumentary status and Wound Location</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl('PAIN','e')?></strong></center><br>
			<table border="0" cellspacing="0" class="formtable">
				<tr>
					<td></td>
					<td>
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_0.png" border="0" onclick="select_pain(0)">
					</td>
					<td>
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_2.png" border="0" onclick="select_pain(1)">
					</td>
					<td>
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_4.png" border="0" onclick="select_pain(2)">
					</td>
					<td>
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_6.png" border="0" onclick="select_pain(3)">
					</td>
					<td>
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_8.png" border="0" onclick="select_pain(4)">
					</td>
					<td>
						<img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_therapy_rectification/templates/scale_10.png" border="0" onclick="select_pain(5)">
					</td>
				</tr>
				<tr>
					<td>
						<strong><u><?php xl('Pain Rating Scale:','e')?></u></strong>
					</td>
					<td>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_1" value="0" <?php if($obj{"oasis_therapy_pain_scale"}=="0"){echo "checked";}?> ><?php xl(' 0-No Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_2" value="2" <?php if($obj{"oasis_therapy_pain_scale"}=="2"){echo "checked";}?> ><?php xl(' 2-Little Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_4" value="4" <?php if($obj{"oasis_therapy_pain_scale"}=="4"){echo "checked";}?> ><?php xl(' 4-Little More Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_6" value="6" <?php if($obj{"oasis_therapy_pain_scale"}=="6"){echo "checked";}?> ><?php xl(' 6-Even More Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_8" value="8" <?php if($obj{"oasis_therapy_pain_scale"}=="8"){echo "checked";}?> ><?php xl(' 8-Lots of Pain ','e')?></label>
					</td>
					<td>
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
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors" value="<?php xl("medication","e");?>" <?php if($obj{"oasis_therapy_pain_relieving_factors"}=="medication"){echo "checked";}?> ><?php xl('medication','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors" value="<?php xl("rest","e");?>" <?php if($obj{"oasis_therapy_pain_relieving_factors"}=="rest"){echo "checked";}?> ><?php xl('rest','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors" value="<?php xl("heat","e");?>" <?php if($obj{"oasis_therapy_pain_relieving_factors"}=="heat"){echo "checked";}?> ><?php xl('heat','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors" value="<?php xl("ice","e");?>" <?php if($obj{"oasis_therapy_pain_relieving_factors"}=="ice"){echo "checked";}?> ><?php xl('ice','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors" value="<?php xl("massage","e");?>" <?php if($obj{"oasis_therapy_pain_relieving_factors"}=="massage"){echo "checked";}?> ><?php xl('massage','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors" value="<?php xl("repositioning","e");?>" <?php if($obj{"oasis_therapy_pain_relieving_factors"}=="repositioning"){echo "checked";}?> ><?php xl('repositioning','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors" value="<?php xl("diversion","e");?>" <?php if($obj{"oasis_therapy_pain_relieving_factors"}=="diversion"){echo "checked";}?> ><?php xl('diversion','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors" value="<?php xl("other","e");?>" <?php if($obj{"oasis_therapy_pain_relieving_factors"}=="other"){echo "checked";}?> ><?php xl('other','e')?></label>
			<input type="text" name="oasis_therapy_pain_relieving_factors_other" value="<?php echo $obj{"oasis_therapy_pain_relieving_factors_other"};?>"><br>
			
			<strong><u><?php xl('Activities limited:','e')?></u></strong><br>
			<textarea name="oasis_therapy_pain_activities_limited" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pain_activities_limited"};?></textarea>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<b><?php xl('Is patient experiencing pain?','e')?></b>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_experiencing_pain" value="Yes" <?php if($obj{"oasis_therapy_experiencing_pain"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_experiencing_pain" value="No" <?php if($obj{"oasis_therapy_experiencing_pain"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_unable_to_communicate" value="Yes" <?php if($obj{"oasis_therapy_unable_to_communicate"}=="Yes"){echo "checked";}?> ><?php xl('Unable to communicate','e')?></label><br>
			
			<b><?php xl('Non-verbals demonstrated: ','e')?></b>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Diaphoresis","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Diaphoresis"){echo "checked";}?> ><?php xl('Diaphoresis','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Grimacing","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Grimacing"){echo "checked";}?> ><?php xl('Grimacing','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Moaning/Crying","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Moaning/Crying"){echo "checked";}?> ><?php xl('Moaning/Crying','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Guarding","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Guarding"){echo "checked";}?> ><?php xl('Guarding','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Irritability","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Irritability"){echo "checked";}?> ><?php xl('Irritability','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Anger","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Anger"){echo "checked";}?> ><?php xl('Anger','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Tense","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Tense"){echo "checked";}?> ><?php xl('Tense','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Restlessness","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Restlessness"){echo "checked";}?> ><?php xl('Restlessness','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Change in vital signs","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Change in vital signs"){echo "checked";}?> ><?php xl('Change in vital signs','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Other:","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Other:"){echo "checked";}?> ><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_therapy_non_verbal_demonstrated_other" value="<?php echo $obj{"oasis_therapy_non_verbal_demonstrated_other"};?>">
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Self-assessment","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Self-assessment"){echo "checked";}?> ><?php xl('Self-assessment','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated" value="<?php xl("Implications:","e");?>" <?php if($obj{"oasis_therapy_non_verbal_demonstrated"}=="Implications"){echo "checked";}?> ><?php xl('Implications:','e')?></label>
			<input type="text" name="oasis_therapy_non_verbal_demonstrated_implications" value="<?php echo $obj{"oasis_therapy_non_verbal_demonstrated_implications"};?>">
		</td>
		<td valign="top">
			<b><?php xl('How often is breakthrough medication needed? ','e')?></b><br>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Never","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="Never"){echo "checked";}?> ><?php xl('Never','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Less than daily","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="Less than daily"){echo "checked";}?> ><?php xl('Less than daily','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("2-3 times/day","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="2-3 times/day"){echo "checked";}?> ><?php xl('2-3 times/day','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("More than 3 times/day","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="More than 3 times/day"){echo "checked";}?> ><?php xl('More than 3 times/day','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Current adequate","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="Current adequate"){echo "checked";}?> ><?php xl('Current pain control medications adequate','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("other","e");?>" <?php if($obj{"oasis_therapy_breakthrough_medication"}=="other"){echo "checked";}?> ><?php xl('other:','e')?></label>
			<input type="text" name="oasis_therapy_breakthrough_medication_other" value="<?php echo $obj{"oasis_therapy_breakthrough_medication_other"};?>"><br>
			
			<b><?php xl('Implications Care Plan:','e')?></b>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_implications_care_plan" value="Yes" <?php if($obj{"oasis_therapy_implications_care_plan"}=="Yes"){echo "checked";}?> ><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_implications_care_plan" value="No" <?php if($obj{"oasis_therapy_implications_care_plan"}=="No"){echo "checked";}?> ><?php xl(' No ','e')?></label><br>
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
			<label><input type="checkbox" name="oasis_therapy_wound_education" value="Yes" <?php if($obj{"oasis_therapy_wound_education"}=="Yes"){echo "checked";}?> ><?php xl('Staples present','e')?></label><br>
			<?php xl("Comments:","e");?>
			<textarea name="oasis_therapy_wound_education_comment" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_wound_education_comment"};?></textarea>
		</td>
		<td>
			<center><strong><?php xl("WOUND LOCATIONS","e");?></strong></center>
			<?php
                /* Create a form object. */
                $c = new C_FormPainMap('oasis_therapy_rectification','bodymap_man.png');
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
			</table>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Integumentary Status, Braden Scale, Vital Signs</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("INTEGUMENTARY STATUS","e");?></strong></center><br>
			<strong><?php xl('<u>(M1306)</u> </strong> Does this patient have at least one <b>Unhealed Pressure Ulcer at Stage II or Higher</b> or designated as "unstageable"?','e'); ?><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status" value="0" <?php if($obj{"oasis_therapy_integumentary_status"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b>[ Go to M1322 ]</b>','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status" value="1" <?php if($obj{"oasis_therapy_integumentary_status"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes','e')?></label>
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
			<center><strong><?php xl("INTEGUMENTARY STATUS (CONTD)","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td valign="top" width="50%">
			<strong><?php xl("<u>(M1322)</u> Current Number of Stage I Pressure Ulcers: ","e");?></strong> <?php xl("Intact skin with non-blanchable redness of a localized area usually over a bony prominence. The area may be painful, firm, soft, warmer or cooler as compared to adjacent tissue.","e");?><br>
			<label><input type="radio" name="oasis_therapy_current_ulcer_stage1" value="0" <?php if($obj{"oasis_therapy_current_ulcer_stage1"}=="0"){echo "checked";}?> >0</label> 
			<label><input type="radio" name="oasis_therapy_current_ulcer_stage1" value="1" <?php if($obj{"oasis_therapy_current_ulcer_stage1"}=="1"){echo "checked";}?> >1</label> 
			<label><input type="radio" name="oasis_therapy_current_ulcer_stage1" value="2" <?php if($obj{"oasis_therapy_current_ulcer_stage1"}=="2"){echo "checked";}?> >2</label> 
			<label><input type="radio" name="oasis_therapy_current_ulcer_stage1" value="3" <?php if($obj{"oasis_therapy_current_ulcer_stage1"}=="3"){echo "checked";}?> >3</label> 
			<label><input type="radio" name="oasis_therapy_current_ulcer_stage1" value="4" <?php if($obj{"oasis_therapy_current_ulcer_stage1"}=="4"){echo "checked";}?> >4 or more</label>
		</td>
		<td>
			<strong><?php xl("<u>(M1334 )</u> Status of Most Problematic (Observable) Stasis Ulcer:","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_problematic_statis_ulcer" value="0" <?php if($obj{"oasis_therapy_problematic_statis_ulcer"}=="0"){echo "checked";}?> ><?php xl(' 0 - Newly epithelialized ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_problematic_statis_ulcer" value="1" <?php if($obj{"oasis_therapy_problematic_statis_ulcer"}=="1"){echo "checked";}?> ><?php xl(' 1 - Fully granulating ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_problematic_statis_ulcer" value="2" <?php if($obj{"oasis_therapy_problematic_statis_ulcer"}=="2"){echo "checked";}?> ><?php xl(' 2 - Early/partial granulation ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_problematic_statis_ulcer" value="3" <?php if($obj{"oasis_therapy_problematic_statis_ulcer"}=="3"){echo "checked";}?> ><?php xl(' 3 - Not healing ','e')?></label> <br>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl("<u>(M1324)</u> Stage of Most Problematic Unhealed (Observable) Pressure Ulcer:","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_stage_of_problematic_ulcer" value="1" <?php if($obj{"oasis_therapy_stage_of_problematic_ulcer"}=="1"){echo "checked";}?> ><?php xl(' 1 - Stage I ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_stage_of_problematic_ulcer" value="2" <?php if($obj{"oasis_therapy_stage_of_problematic_ulcer"}=="2"){echo "checked";}?> ><?php xl(' 2 - Stage II ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_stage_of_problematic_ulcer" value="3" <?php if($obj{"oasis_therapy_stage_of_problematic_ulcer"}=="3"){echo "checked";}?> ><?php xl(' 3 - Stage III ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_stage_of_problematic_ulcer" value="4" <?php if($obj{"oasis_therapy_stage_of_problematic_ulcer"}=="4"){echo "checked";}?> ><?php xl(' 4 - Stage IV ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_stage_of_problematic_ulcer" value="NA" <?php if($obj{"oasis_therapy_stage_of_problematic_ulcer"}=="NA"){echo "checked";}?> ><?php xl(' NA - No observable pressure ulcer or unhealed pressure ulcer ','e')?></label>
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1340)</u>","e");?></strong> <?php xl("Does this patient have a ","e");?> <strong><?php xl("Surgical Wound?","e");?></strong><br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="0" <?php if($obj{"oasis_therapy_surgical_wound"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b>[ Go to M1350 ]</b> ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="1" <?php if($obj{"oasis_therapy_surgical_wound"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes, patient has at least one (observable) surgical wound ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="2" <?php if($obj{"oasis_therapy_surgical_wound"}=="2"){echo "checked";}?> ><?php xl(' 2 - Surgical wound known but not observable due to non-removable dressing <b>[ Go to M1350 ]</b> ','e')?></label> <br>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong><?php xl("<u>(M1330)</u>","e");?></strong> <?php xl("Does this patient have a ","e");?> <strong><?php xl("Stasis Ulcer?","e");?></strong><br>
			<label><input type="radio" name="oasis_therapy_statis_ulcer" value="0" <?php if($obj{"oasis_therapy_statis_ulcer"}=="0"){echo "checked";}?> ><?php xl(' 0 - No <b>[ Go to M1340 ]</b> ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_statis_ulcer" value="1" <?php if($obj{"oasis_therapy_statis_ulcer"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes, patient has BOTH observable and unobservable stasis ulcers ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_statis_ulcer" value="2" <?php if($obj{"oasis_therapy_statis_ulcer"}=="2"){echo "checked";}?> ><?php xl(' 2 - Yes, patient has observable stasis ulcers ONLY ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_statis_ulcer" value="3" <?php if($obj{"oasis_therapy_statis_ulcer"}=="3"){echo "checked";}?> ><?php xl(' 3 - Yes, patient has unobservable stasis ulcers ONLY (known but not observable due to non-removable dressing) <b>[ Go to M1340 ]</b> ','e')?></label> <br>
		</td>
		<td>
			<strong><?php xl("<u>(M1342)</u> Status of Most Problematic (Observable) Surgical Wound:","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_problematic_surgical_wound" value="0" <?php if($obj{"oasis_therapy_problematic_surgical_wound"}=="0"){echo "checked";}?> ><?php xl(' 0 - Newly epithelialized ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_problematic_surgical_wound" value="1" <?php if($obj{"oasis_therapy_problematic_surgical_wound"}=="1"){echo "checked";}?> ><?php xl(' 1 - Fully granulating ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_problematic_surgical_wound" value="2" <?php if($obj{"oasis_therapy_problematic_surgical_wound"}=="2"){echo "checked";}?> ><?php xl(' 2 - Early/partial granulation ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_problematic_surgical_wound" value="3" <?php if($obj{"oasis_therapy_problematic_surgical_wound"}=="3"){echo "checked";}?> ><?php xl(' 3 - Not healing ','e')?></label> <br>
			<br><br>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl("<u>(M1332)</u> Current Number of (Observable) Stasis Ulcer(s):","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_current_no_statis_ulcer" value="1" <?php if($obj{"oasis_therapy_current_no_statis_ulcer"}=="1"){echo "checked";}?> ><?php xl(' 1 - One ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_current_no_statis_ulcer" value="2" <?php if($obj{"oasis_therapy_current_no_statis_ulcer"}=="2"){echo "checked";}?> ><?php xl(' 2 - Two ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_current_no_statis_ulcer" value="3" <?php if($obj{"oasis_therapy_current_no_statis_ulcer"}=="3"){echo "checked";}?> ><?php xl(' 3 - Three ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_current_no_statis_ulcer" value="4" <?php if($obj{"oasis_therapy_current_no_statis_ulcer"}=="4"){echo "checked";}?> ><?php xl(' 4 - Four or more ','e')?></label> <br>
		</td>
		<td>
			<strong><?php xl("<u>(M1350)</u>","e");?></strong>
			<?php xl("Does this patient have a ","e");?> 
			<strong><?php xl(" Skin Lesion or Open Wound, ","e");?></strong> 
			<?php xl("excluding bowel ostomy, other than those described above ","e");?><u><?php xl("that is receiving intervention","e");?></u><?php xl(" by the home health agency?","e");?><br>
			<label><input type="radio" name="oasis_therapy_skin_lesion" value="0" <?php if($obj{"oasis_therapy_skin_lesion"}=="0"){echo "checked";}?> ><?php xl(' 0 - No ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_skin_lesion" value="1" <?php if($obj{"oasis_therapy_skin_lesion"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes ','e')?></label> <br>
		</td>
	</tr>
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
					<td>
						<?php xl("Right","e");?>
					</td>
					<td>
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
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Ambulation feet","e");?>" <?php if(in_array("Ambulation feet",$oasis_therapy_breath_sounds)) echo "checked"; ?> ><?php xl('Ambulation feet','e')?></label><br>
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
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Edema","e");?>" <?php if(in_array("Edema",$oasis_therapy_heart_sounds)) echo "checked"; ?> ><b><?php xl('Edema:','e')?></b></label>
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
			<center><strong><?php xl("RESPIRATORY STATUS","e");?></strong></center><br>
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
		<td>
			<center><strong>
				<?php xl("GENITOURINARY / URINARY","e");?>
				<label><input type="checkbox" name="oasis_therapy_urinary_problem" value="No" <?php if($obj{"oasis_therapy_urinary_problem"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</strong></center>
			<?php xl("(Check all applicable items)","e");?><br>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Urgency/frequency","e");?>" <?php if(in_array("Urgency/frequency",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Urgency/frequency','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Burning/pain","e");?>" <?php if(in_array("Burning/pain",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Burning/pain','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Hesitancy","e");?>" <?php if(in_array("Hesitancy",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Hesitancy','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Nocturia","e");?>" <?php if(in_array("Nocturia",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Nocturia','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Hematuria","e");?>" <?php if(in_array("Hematuria",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Hematuria','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Oliguria/anuria","e");?>" <?php if(in_array("Oliguria/anuria",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Oliguria/anuria','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Incontinence","e");?>" <?php if(in_array("Incontinence",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Incontinence (details if applicable)','e')?></label>
				<input type="text" name="oasis_therapy_urinary_incontinence" value="<?php echo $obj{"oasis_therapy_urinary_incontinence"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Management Strategies","e");?>" <?php if(in_array("Management Strategies",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Management Strategies:','e')?></label>
				<input type="text" name="oasis_therapy_urinary_management_strategy" value="<?php echo $obj{"oasis_therapy_urinary_management_strategy"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="<?php xl("Diapers/other:","e");?>" <?php if(in_array("Diapers/other:",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Diapers/other:','e')?></label>
				<input type="text" name="oasis_therapy_urinary_diapers_other" value="<?php echo $obj{"oasis_therapy_urinary_diapers_other"};?>"><br>
			<b><?php xl("Color:","e");?></b>
				<label><input type="radio" name="oasis_therapy_urinary_color" value="Yellow" <?php if($obj{"oasis_therapy_urinary_color"}=="Yellow"){echo "checked";}?> ><?php xl('Yellow/straw','e')?></label>
				<label><input type="radio" name="oasis_therapy_urinary_color" value="Amber" <?php if($obj{"oasis_therapy_urinary_color"}=="Amber"){echo "checked";}?> ><?php xl('Amber','e')?></label>
				<label><input type="radio" name="oasis_therapy_urinary_color" value="Brown" <?php if($obj{"oasis_therapy_urinary_color"}=="Brown"){echo "checked";}?> ><?php xl('Brown/gray','e')?></label>
				<label><input type="radio" name="oasis_therapy_urinary_color" value="Blood" <?php if($obj{"oasis_therapy_urinary_color"}=="Blood"){echo "checked";}?> ><?php xl('Blood-tinged','e')?></label>
				<label><input type="radio" name="oasis_therapy_urinary_color" value="Other" <?php if($obj{"oasis_therapy_urinary_color"}=="Other"){echo "checked";}?> ><?php xl('Other','e')?></label>
				<input type="text" name="oasis_therapy_urinary_color_other" value="<?php echo $obj{"oasis_therapy_urinary_color_other"};?>"><br>
			<b><?php xl("Clarity:","e");?></b>
				<label><input type="radio" name="oasis_therapy_urinary_clarity" value="Clear" <?php if($obj{"oasis_therapy_urinary_clarity"}=="Clear"){echo "checked";}?> ><?php xl('Clear','e')?></label>
				<label><input type="radio" name="oasis_therapy_urinary_clarity" value="Cloudy" <?php if($obj{"oasis_therapy_urinary_clarity"}=="Cloudy"){echo "checked";}?> ><?php xl('Cloudy','e')?></label>
				<label><input type="radio" name="oasis_therapy_urinary_clarity" value="Sediment" <?php if($obj{"oasis_therapy_urinary_clarity"}=="Sediment"){echo "checked";}?> ><?php xl('Sediment/mucous','e')?></label><br>
			<b><?php xl("Odor:","e");?></b>
				<label><input type="radio" name="oasis_therapy_urinary_odor" value="Yes" <?php if($obj{"oasis_therapy_urinary_odor"}=="Yes"){echo "checked";}?> ><?php xl('Yes','e')?></label>
				<label><input type="radio" name="oasis_therapy_urinary_odor" value="No" <?php if($obj{"oasis_therapy_urinary_odor"}=="No"){echo "checked";}?> ><?php xl('No','e')?></label><br>
			<?php xl("<b>Urinary Catheter:</b> Type (specify)","e");?>
				<input type="text" name="oasis_therapy_urinary_catheter" value="<?php echo $obj{"oasis_therapy_urinary_catheter"};?>"><br>
			<?php xl("Date last changed","e");?><br>
				<label><input type="checkbox" name="oasis_therapy_urinary[]" value="Foley inserted" <?php if(in_array("Foley inserted",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Foley inserted','e')?></label>
				<input type='text' size='10' name='oasis_therapy_urinary_foley_date' id='oasis_therapy_urinary_foley_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_urinary_foley_date"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date8' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_therapy_urinary_foley_date", ifFormat:"%Y-%m-%d", button:"img_curr_date8"});
						</script>
				<?php xl("with French Inflated balloon with","e");?>
				<input type="text" name="oasis_therapy_urinary_foley_ml" value="<?php echo $obj{"oasis_therapy_urinary_foley_ml"};?>"><?php xl("ml","e");?>&nbsp;&nbsp;
				<label><input type="checkbox" name="oasis_therapy_urinary[]" value="without difficulty" <?php if(in_array("without difficulty",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('without difficulty','e')?></label><br>
			<?php xl("<b>Irrigation solution:</b> Type (specify)","e");?>
				<input type="text" name="oasis_therapy_urinary_irrigation_solution" value="<?php echo $obj{"oasis_therapy_urinary_irrigation_solution"};?>"><br>
				<?php xl("Amount","e");?>
				<input type="text" name="oasis_therapy_urinary_irrigation_amount" value="<?php echo $obj{"oasis_therapy_urinary_irrigation_amount"};?>">
				<?php xl("ml","e");?>
				<input type="text" name="oasis_therapy_urinary_irrigation_ml" value="<?php echo $obj{"oasis_therapy_urinary_irrigation_ml"};?>">
				<?php xl("Frequency","e");?>
				<input type="text" name="oasis_therapy_urinary_irrigation_frequency" value="<?php echo $obj{"oasis_therapy_urinary_irrigation_frequency"};?>">
				<?php xl("Returns","e");?>
				<input type="text" name="oasis_therapy_urinary_irrigation_returns" value="<?php echo $obj{"oasis_therapy_urinary_irrigation_returns"};?>"><br>
			<?php xl("Patient tolerated procedure well","e");?>
				<label><input type="radio" name="oasis_therapy_urinary_tolerated_procedure" value="Yes" <?php if($obj{"oasis_therapy_urinary_tolerated_procedure"}=="Yes"){echo "checked";}?> ><?php xl('Yes','e')?></label>
				<label><input type="radio" name="oasis_therapy_urinary_tolerated_procedure" value="No" <?php if($obj{"oasis_therapy_urinary_tolerated_procedure"}=="No"){echo "checked";}?> ><?php xl('No','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_urinary[]" value="Other" <?php if(in_array("Other",$oasis_therapy_urinary)) echo "checked"; ?> ><?php xl('Other (specify)','e')?></label>
				<input type="text" name="oasis_therapy_urinary_other" value="<?php echo $obj{"oasis_therapy_urinary_other"};?>"><br>
				
			<br><br>
			<center><strong>
				<?php xl("BOWELS","e");?>
				<label><input type="checkbox" name="oasis_therapy_bowels_problem" value="No" <?php if($obj{"oasis_therapy_bowels_problem"}=="No"){echo "checked";}?> ><?php xl('No Problem','e')?></label>
			</strong></center>
			<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Flatulence" <?php if(in_array("Flatulence",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Flatulence','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Constipation/impaction" <?php if(in_array("Constipation/impaction",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Constipation/impaction','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Diarrhea" <?php if(in_array("Diarrhea",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Diarrhea','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Rectal bleeding" <?php if(in_array("Rectal bleeding",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Rectal bleeding','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Hemorrhoids" <?php if(in_array("Hemorrhoids",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Hemorrhoids','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Last BM" <?php if(in_array("Last BM",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Last BM','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Frequency of stools" <?php if(in_array("Frequency of stools",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Frequency of stools','e')?></label>
			<?php xl("Bowel regime/program:","e");?>
				<input type="text" name="oasis_therapy_bowel_regime" value="<?php echo $obj{"oasis_therapy_bowel_regime"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Laxative/Enema use" <?php if(in_array("Laxative/Enema use",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Laxative/Enema use:','e')?></label>
				<label><input type="radio" name="oasis_therapy_bowels_lexative_enema" value="Daily" <?php if($obj{"oasis_therapy_bowels_lexative_enema"}=="Daily"){echo "checked";}?> ><?php xl('Daily','e')?></label>
				<label><input type="radio" name="oasis_therapy_bowels_lexative_enema" value="Weekly" <?php if($obj{"oasis_therapy_bowels_lexative_enema"}=="Weekly"){echo "checked";}?> ><?php xl('Weekly','e')?></label>
				<label><input type="radio" name="oasis_therapy_bowels_lexative_enema" value="Monthly" <?php if($obj{"oasis_therapy_bowels_lexative_enema"}=="Monthly"){echo "checked";}?> ><?php xl('Monthly','e')?></label><br>
				<label><input type="radio" name="oasis_therapy_bowels_lexative_enema" value="Other" <?php if($obj{"oasis_therapy_bowels_lexative_enema"}=="Other"){echo "checked";}?> ><?php xl('Other:','e')?></label>
					<input type="text" name="oasis_therapy_bowels_lexative_enema_other" value="<?php echo $obj{"oasis_therapy_bowels_lexative_enema_other"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Incontinence" <?php if(in_array("Incontinence",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Incontinence (details if applicable)','e')?></label><br>
				<textarea name="oasis_therapy_bowels_incontinence" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_bowels_incontinence"};?></textarea><br>
			<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Diapers/other" <?php if(in_array("Diapers/other",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Diapers/other:','e')?></label>
				<input type="text" name="oasis_therapy_bowels_diapers_others" value="<?php echo $obj{"oasis_therapy_bowels_diapers_others"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Ileostomy/colostomy" <?php if(in_array("Ileostomy/colostomy",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Ileostomy/colostomy site (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_therapy_bowels_ileostomy_site"><?php echo $obj{"oasis_therapy_bowels_ileostomy_site"};?></textarea><br>
			<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Ostomy care managed" <?php if(in_array("Ostomy care managed",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Ostomy care managed by:','e')?></label>
				<label><input type="radio" name="oasis_therapy_bowels_ostomy_care" value="Self" <?php if($obj{"oasis_therapy_bowels_ostomy_care"}=="Self"){echo "checked";}?> ><?php xl('Self','e')?></label>
				<label><input type="radio" name="oasis_therapy_bowels_ostomy_care" value="Caregiver" <?php if($obj{"oasis_therapy_bowels_ostomy_care"}=="Caregiver"){echo "checked";}?> ><?php xl('Caregiver','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Other site" <?php if(in_array("Other site",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Other site (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_therapy_bowels_other_site"><?php echo $obj{"oasis_therapy_bowels_other_site"};?></textarea><br>
			<label><input type="checkbox" name="oasis_therapy_bowels[]" value="Urostomy" <?php if(in_array("Urostomy",$oasis_therapy_bowels)) echo "checked"; ?> ><?php xl('Urostomy (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_therapy_bowels_urostomy"><?php echo $obj{"oasis_therapy_bowels_urostomy"};?></textarea><br>
				
			
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1610)</u> ","e");?></strong>
			<strong><?php xl(" Urinary Incontinence or Urinary Catheter Presence:","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_elimination_urinary_incontinence" value="0" <?php if($obj{"oasis_therapy_elimination_urinary_incontinence"}=="0"){echo "checked";}?> ><?php xl(' 0 - No incontinence or catheter (includes anuria or ostomy for urinary drainage) <b>[ Go to M1620 ] </b>','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_urinary_incontinence" value="1" <?php if($obj{"oasis_therapy_elimination_urinary_incontinence"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient is incontinent ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_urinary_incontinence" value="2" <?php if($obj{"oasis_therapy_elimination_urinary_incontinence"}=="2"){echo "checked";}?> ><?php xl(' 2 - Patient requires a urinary catheter (i.e., external, indwelling, intermittent, suprapubic) <b>[ Go to M1620 ]</b> ','e')?></label> <br>
			<br><br>
			
			<strong><?php xl("<u>(M1620)</u>","e");?></strong>
			<strong><?php xl(" Bowel Incontinence Frequency:","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_elimination_bowel_incontinence" value="0" <?php if($obj{"oasis_therapy_elimination_bowel_incontinence"}=="0"){echo "checked";}?> ><?php xl(' 0 - Very rarely or never has bowel incontinence','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_bowel_incontinence" value="1" <?php if($obj{"oasis_therapy_elimination_bowel_incontinence"}=="1"){echo "checked";}?> ><?php xl(' 1 - Less than once weekly','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_bowel_incontinence" value="2" <?php if($obj{"oasis_therapy_elimination_bowel_incontinence"}=="2"){echo "checked";}?> ><?php xl(' 2 - One to three times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_bowel_incontinence" value="3" <?php if($obj{"oasis_therapy_elimination_bowel_incontinence"}=="3"){echo "checked";}?> ><?php xl(' 3 - Four to six times weekly','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_bowel_incontinence" value="4" <?php if($obj{"oasis_therapy_elimination_bowel_incontinence"}=="4"){echo "checked";}?> ><?php xl(' 4 - On a daily basis','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_bowel_incontinence" value="5" <?php if($obj{"oasis_therapy_elimination_bowel_incontinence"}=="5"){echo "checked";}?> ><?php xl(' 5 - More often than once daily ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_bowel_incontinence" value="NA" <?php if($obj{"oasis_therapy_elimination_bowel_incontinence"}=="NA"){echo "checked";}?> ><?php xl(' NA - Patient has ostomy for bowel elimination','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_bowel_incontinence" value="UK" <?php if($obj{"oasis_therapy_elimination_bowel_incontinence"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown <b>[Omit "UK" option on FU, DC]</b>','e')?></label> <br>
			<br><br>
			
			<strong><?php xl("<u>(M1630)</u> ","e");?></strong>
			<strong><?php xl(" Ostomy for Bowel Elimination:","e");?></strong> 
			<?php xl(" Does this patient have an ostomy for bowel elimination that (within the last 14 days): a) was related to an inpatient facility stay, <u>or</u> b) necessitated a change in medical or treatment regimen?","e");?><br>
			<label><input type="radio" name="oasis_therapy_elimination_ostomy" value="0" <?php if($obj{"oasis_therapy_elimination_ostomy"}=="0"){echo "checked";}?> ><?php xl(' 0 - Patient does <u>not</u> have an ostomy for bowel elimination. ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_ostomy" value="1" <?php if($obj{"oasis_therapy_elimination_ostomy"}=="1"){echo "checked";}?> ><?php xl(' 1 - Patient"s ostomy was <u>not</u> related to an inpatient stay and did <u>not</u> necessitate change in medical or treatment regimen. ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_elimination_ostomy" value="2" <?php if($obj{"oasis_therapy_elimination_ostomy"}=="2"){echo "checked";}?> ><?php xl(' 2 - The ostomy <u>was</u> related to an inpatient stay or <u>did</u> necessitate change in medical or treatment regimen.','e')?></label> <br>
			<br><br>
			
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">ADL/IADLs</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("ADL/IADLs","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top">
			<strong><?php xl("<u>(M1810)</u> ","e");?></strong>
			<?php xl("Current ","e");?>
			<strong><?php xl(" Ability to Dress <u>Upper</u> Body ","e");?></strong> 
			<?php xl(" safely (with or without dressing aids) including undergarments, pullovers, front-opening shirts and blouses, managing zippers, buttons, and snaps:","e");?><br>
			<label><input type="radio" name="oasis_therapy_adl_dress_upper" value="0" <?php if($obj{"oasis_therapy_adl_dress_upper"}=="0"){echo "checked";}?> ><?php xl(' 0 - Able to get clothes out of closets and drawers, put them on and remove them from the  upper body without assistance. ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_dress_upper" value="1" <?php if($obj{"oasis_therapy_adl_dress_upper"}=="1"){echo "checked";}?> ><?php xl(' 1 - Able to dress upper body without assistance if clothing is laid out or handed to the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_dress_upper" value="2" <?php if($obj{"oasis_therapy_adl_dress_upper"}=="2"){echo "checked";}?> ><?php xl(' 2 - Someone must help the patient put on upper body clothing.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_dress_upper" value="3" <?php if($obj{"oasis_therapy_adl_dress_upper"}=="3"){echo "checked";}?> ><?php xl(' 3 - Patient depends entirely upon another person to dress the upper body.','e')?></label> <br>
			<br><br>
			
			<strong><?php xl("<u>(M1820)</u> ","e");?></strong>
			<?php xl("Current ","e");?>
			<strong><?php xl("Ability to Dress <u>Lower</u> Body ","e");?></strong> 
			<?php xl(" safely (with or without dressing aids) including undergarments, slacks, socks or nylons, shoes:","e");?><br>
			<label><input type="radio" name="oasis_therapy_adl_dress_lower" value="0" <?php if($obj{"oasis_therapy_adl_dress_lower"}=="0"){echo "checked";}?> ><?php xl(' 0 - Able to obtain, put on, and remove clothing and shoes without assistance.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_dress_lower" value="1" <?php if($obj{"oasis_therapy_adl_dress_lower"}=="1"){echo "checked";}?> ><?php xl(' 1 - Able to dress lower body without assistance if clothing and shoes are laid out or handed to the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_dress_lower" value="2" <?php if($obj{"oasis_therapy_adl_dress_lower"}=="2"){echo "checked";}?> ><?php xl(' 2 - Someone must help the patient put on undergarments, slacks, socks or nylons, and shoes.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_dress_lower" value="3" <?php if($obj{"oasis_therapy_adl_dress_lower"}=="3"){echo "checked";}?> ><?php xl(' 3 - Patient depends entirely upon another person to dress lower body.','e')?></label> <br>
			<br><br>
			
			<strong><?php xl("<u>(M1830)</u> Bathing: ","e");?></strong>
			<?php xl("Current ability to wash entire body safely. ","e");?>
			<strong><?php xl("<u>Excludes</u> grooming (washing face, washing hands, and shampooing hair). ","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_adl_wash" value="0" <?php if($obj{"oasis_therapy_adl_wash"}=="0"){echo "checked";}?> ><?php xl(' 0 - Able to bathe self in <u>shower or tub</u> independently, including getting in and out of tub/shower.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_wash" value="1" <?php if($obj{"oasis_therapy_adl_wash"}=="1"){echo "checked";}?> ><?php xl(' 1 - With the use of devices, is able to bathe self in shower or tub independently, including getting in and out of the tub/shower.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_wash" value="2" <?php if($obj{"oasis_therapy_adl_wash"}=="2"){echo "checked";}?> ><?php xl(' 2 - Able to bathe in shower or tub with the intermittent assistance of another person:<br>
&nbsp;&nbsp;&nbsp;&nbsp;(a) for intermittent supervision or encouragement or reminders, <u>OR</u><br>
&nbsp;&nbsp;&nbsp;&nbsp;(b) to get in and out of the shower or tub, <u>OR</u><br>
&nbsp;&nbsp;&nbsp;&nbsp;(c) for washing difficult to reach areas.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_wash" value="3" <?php if($obj{"oasis_therapy_adl_wash"}=="3"){echo "checked";}?> ><?php xl(' 3 - Able to participate in bathing self in shower or tub, but requires presence of another person throughout the bath for assistance or supervision.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_wash" value="4" <?php if($obj{"oasis_therapy_adl_wash"}=="4"){echo "checked";}?> ><?php xl(' 4 - Unable to use the shower or tub, but able to bathe self independently with or without the use of devices at the sink, in chair, or on commode.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_wash" value="5" <?php if($obj{"oasis_therapy_adl_wash"}=="5"){echo "checked";}?> ><?php xl(' 5 - Unable to use the shower or tub, but able to participate in bathing self in bed, at the sink, in bedside chair, or on commode, with the assistance or supervision of another person throughout the bath.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_wash" value="6" <?php if($obj{"oasis_therapy_adl_wash"}=="6"){echo "checked";}?> ><?php xl(' 6 - Unable to participate effectively in bathing and is bathed totally by another person.','e')?></label> <br>
			<br><br>
			
			<strong><?php xl("<u>(M1840)</u> Toilet Transferring: ","e");?></strong>
			<?php xl("Current ability to get to and from the toilet or bedside commode safely <u>and</u> transfer on and off toilet/commode. ","e");?><br>
			<label><input type="radio" name="oasis_therapy_adl_toilet_transfer" value="0" <?php if($obj{"oasis_therapy_adl_toilet_transfer"}=="0"){echo "checked";}?> ><?php xl(' 0 - Able to get to and from the toilet and transfer independently with or without a device.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_toilet_transfer" value="1" <?php if($obj{"oasis_therapy_adl_toilet_transfer"}=="1"){echo "checked";}?> ><?php xl(' 1 - When reminded, assisted, or supervised by another person, able to get to and from the toilet and transfer.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_toilet_transfer" value="2" <?php if($obj{"oasis_therapy_adl_toilet_transfer"}=="2"){echo "checked";}?> ><?php xl(' 2 - <u>Unable</u> to get to and from the toilet but is able to use a bedside commode (with or without assistance).','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_toilet_transfer" value="3" <?php if($obj{"oasis_therapy_adl_toilet_transfer"}=="3"){echo "checked";}?> ><?php xl(' 3 - <u>Unable</u> to get to and from the toilet or bedside commode but is able to use a bedpan/urinal independently.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_toilet_transfer" value="4" <?php if($obj{"oasis_therapy_adl_toilet_transfer"}=="4"){echo "checked";}?> ><?php xl(' 4 - Is totally dependent in toileting.','e')?></label> <br>
			<br><br>
			
		</td>
		<td>
			<strong><?php xl("<u>(M1850)</u> Transferring: ","e");?></strong>
			<?php xl("Current ability to move safely from bed to chair, or ability to turn and position self in bed if patient is bedfast.","e");?><br>
			<label><input type="radio" name="oasis_therapy_adl_transferring" value="0" <?php if($obj{"oasis_therapy_adl_transferring"}=="0"){echo "checked";}?> ><?php xl(' 0 - Able to independently transfer.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_transferring" value="1" <?php if($obj{"oasis_therapy_adl_transferring"}=="1"){echo "checked";}?> ><?php xl(' 1 - Able to transfer with minimal human assistance or with use of an assistive device.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_transferring" value="2" <?php if($obj{"oasis_therapy_adl_transferring"}=="2"){echo "checked";}?> ><?php xl(' 2 - Able to bear weight and pivot during the transfer process but unable to transfer self.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_transferring" value="3" <?php if($obj{"oasis_therapy_adl_transferring"}=="3"){echo "checked";}?> ><?php xl(' 3 - Unable to transfer self and is unable to bear weight or pivot when transferred by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_transferring" value="4" <?php if($obj{"oasis_therapy_adl_transferring"}=="4"){echo "checked";}?> ><?php xl(' 4 - Bedfast, unable to transfer but is able to turn and position self in bed','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_transferring" value="5" <?php if($obj{"oasis_therapy_adl_transferring"}=="5"){echo "checked";}?> ><?php xl(' 5 - Bedfast, unable to transfer and is unable to turn and position self.','e')?></label> <br>
			<br><br>
			
			<strong><?php xl("<u>(M1860)</u> Ambulation/Locomotion: ","e");?></strong>
			<?php xl("Current ability to walk safely, once in a standing position, or use a wheelchair, once in a seated position, on a variety of surfaces.","e");?><br>
			<label><input type="radio" name="oasis_therapy_adl_ambulation" value="0" <?php if($obj{"oasis_therapy_adl_ambulation"}=="0"){echo "checked";}?> ><?php xl(' 0 - Able to independently walk on even and uneven surfaces and negotiate stairs with or without railings (i.e., needs no human assistance or assistive device).','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_ambulation" value="1" <?php if($obj{"oasis_therapy_adl_ambulation"}=="1"){echo "checked";}?> ><?php xl(' 1 - With the use of a one-handed device (e.g. cane, single crutch, hemi-walker), able to independently walk on even and uneven surfaces and negotiate stairs with or without railings.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_ambulation" value="2" <?php if($obj{"oasis_therapy_adl_ambulation"}=="2"){echo "checked";}?> ><?php xl(' 2 - Requires use of a two-handed device (e.g., walker or crutches) to walk alone on a level surface and/or requires human supervision or assistance to negotiate stairs or steps or uneven surfaces.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_ambulation" value="3" <?php if($obj{"oasis_therapy_adl_ambulation"}=="3"){echo "checked";}?> ><?php xl(' 3 - Able to walk only with the supervision or assistance of another person at all times.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_ambulation" value="4" <?php if($obj{"oasis_therapy_adl_ambulation"}=="4"){echo "checked";}?> ><?php xl(' 4 - Chairfast, unable to ambulate but is able to wheel self independently.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_ambulation" value="5" <?php if($obj{"oasis_therapy_adl_ambulation"}=="5"){echo "checked";}?> ><?php xl(' 5 - Chairfast, unable to ambulate and is unable to wheel self.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_adl_ambulation" value="6" <?php if($obj{"oasis_therapy_adl_ambulation"}=="6"){echo "checked";}?> ><?php xl(' 6 - Bedfast, unable to ambulate or be up in a chair.','e')?></label> <br>
			<br><br>
			
			<center><strong><?php xl("ACTIVITIES PERMITTED","e");?></strong></center><br>
			<table class="formtable" border="0" width="100%">
				<tr>
					<td>
						1. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Complete Bedrest" <?php if(in_array("Complete Bedrest",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Complete Bedrest','e')?></label><br>
						2. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Bedrest w/ BRP" <?php if(in_array("Bedrest w/ BRP",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Bedrest w/ BRP','e')?></label><br>
						3. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Up as tolerated" <?php if(in_array("Up as tolerated",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Up as tolerated','e')?></label><br>
						4. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Transfer Bed/Chair" <?php if(in_array("Transfer Bed/Chair",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Transfer Bed/Chair','e')?></label><br>
						5. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Exercises Prescribed" <?php if(in_array("Exercises Prescribed",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Exercises Prescribed','e')?></label><br>
						6. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Partial Weight Bearing" <?php if(in_array("Partial Weight Bearing",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Partial Weight Bearing','e')?></label><br>
						7. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Independent At Home" <?php if(in_array("Independent At Home",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Independent At Home','e')?></label><br>
					</td>
					<td>
						8. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Crutches" <?php if(in_array("Crutches",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Crutches','e')?></label><br>
						9. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Cane" <?php if(in_array("Cane",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Cane','e')?></label><br>
						A. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Wheelchair" <?php if(in_array("Wheelchair",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Wheelchair','e')?></label><br>
						B. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Walker" <?php if(in_array("Walker",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Walker','e')?></label><br>
						C. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="No Restrictions" <?php if(in_array("No Restrictions",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('No Restrictions','e')?></label><br>
						D. <label><input type="checkbox" name="oasis_therapy_activities_permitted[]" value="Other" <?php if(in_array("Other",$oasis_therapy_activities_permitted)) echo "checked"; ?> ><?php xl('Other (specify):','e')?></label><br>
						   <input type="text" name="oasis_therapy_activities_permitted_other" value="<?php echo $obj{"oasis_therapy_activities_permitted_other"};?>"><br>
					</td>
				</tr>
			</table>
			<br><br>
			
			<center><strong><?php xl("MEDICATION","e");?></strong></center><br>
			<strong><?php xl("<u>(M2030)</u> Management of Injectable Medications: ","e");?></strong>
			<?php xl("<u>Patient's current ability</u> to prepare and take <u>all</u> prescribed injectable medications reliably and safely, including administration of correct dosage at the appropriate times/intervals. <u>Excludes</u> IV medications.","e");?><br>
			<label><input type="radio" name="oasis_therapy_medication" value="0" <?php if($obj{"oasis_therapy_medication"}=="0"){echo "checked";}?> ><?php xl(' 0 - Able to independently take the correct medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_medication" value="1" <?php if($obj{"oasis_therapy_medication"}=="1"){echo "checked";}?> ><?php xl(' 1 - Able to take injectable medication(s) at the correct times if:<br>
&nbsp;&nbsp;&nbsp;&nbsp;(a) individual syringes are prepared in advance by another person; <u>OR</u><br>
&nbsp;&nbsp;&nbsp;&nbsp;(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_medication" value="2" <?php if($obj{"oasis_therapy_medication"}=="2"){echo "checked";}?> ><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person based on the frequency of the injection','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_medication" value="3" <?php if($obj{"oasis_therapy_medication"}=="3"){echo "checked";}?> ><?php xl(' 3 - <u>Unable</u> to take injectable medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_medication" value="NA" <?php if($obj{"oasis_therapy_medication"}=="NA"){echo "checked";}?> ><?php xl(' NA - No injectable medications prescribed.','e')?></label> <br>
			<br><br>
			
			<center><strong><?php xl("THERAPY NEED","e");?></strong></center><br>
			<strong><?php xl("<u>(M2200)</u> Therapy Need: ","e");?></strong>
			<?php xl("In the home health plan of care for the Medicare payment episode for which this assessment will define a case mix group, what is the indicated need for therapy visits (total of reasonable and necessary physical, occupational, and speech-language pathology visits combined)? <b>( Enter zero [ '000' ] if no therapy visits indicated.)</b>","e");?><br>
			<input type="text" name="oasis_therapy_therapy_need_number" value="<?php echo $obj{"oasis_therapy_therapy_need_number"};?>"><?php xl('- Number of therapy visits indicated (total of physical, occupational and speech-language pathology combined).','e');?><br>
			<label><input type="checkbox" name="oasis_therapy_therapy_need" value="NA" <?php if($obj{"oasis_therapy_therapy_need"}=="NA"){echo "checked";}?> ><?php xl(' NA - Not Applicable: No case mix group defined by this assessment.','e')?></label><br>
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Fall Risk Assessment/Reassessment, Timed Up and Go Test, Amplification of Care, Homebound Reason</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("FALL RISK REASSESSMENT","e");?></strong></center><br>
			<?php xl("1. Any falls reported since last OASIS assessment?","e");?>
			<label><input type="radio" name="oasis_therapy_fall_risk_reported" value="No" <?php if($obj{"oasis_therapy_fall_risk_reported"}=="No"){echo "checked";}?> ><?php xl(' No','e')?></label>
			<label><input type="radio" name="oasis_therapy_fall_risk_reported" value="Yes" <?php if($obj{"oasis_therapy_fall_risk_reported"}=="Yes"){echo "checked";}?> ><?php xl(' Yes','e')?></label> <br>
				<textarea name="oasis_therapy_fall_risk_reported_details" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_fall_risk_reported_details"};?></textarea><br>
			
			<?php xl("2. Have fall risk factors changed since prior assessment?","e");?>
			<label><input type="radio" name="oasis_therapy_fall_risk_factors" value="No" <?php if($obj{"oasis_therapy_fall_risk_factors"}=="No"){echo "checked";}?> ><?php xl(' No','e')?></label>
			<label><input type="radio" name="oasis_therapy_fall_risk_factors" value="Yes" <?php if($obj{"oasis_therapy_fall_risk_factors"}=="Yes"){echo "checked";}?> ><?php xl(' Yes','e')?></label> <br>
				<textarea name="oasis_therapy_fall_risk_factors_details" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_fall_risk_factors_details"};?></textarea><br>
				
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
			<br>
			<b><?php xl("Plan/Comments:","e");?></b><br>
			<textarea name="oasis_therapy_fall_risk_assessment_comments" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_fall_risk_assessment_comments"};?></textarea><br>
		</td>
	</tr>
	<tr>
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
			
			<br><br>
			<center><strong><?php xl("AMPLIFICATION OF CARE PROVIDED/ANALYSIS OF FINDINGS","e");?></strong></center><br>
			<textarea name="oasis_therapy_amplification_care_provided" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_amplification_care_provided"};?></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<b><?php xl("Patient/Caregiver Response","e");?></b><br>
			<textarea name="oasis_therapy_amplification_patient_response" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_amplification_patient_response"};?></textarea><br>
		</td>
	</tr>
	<tr>
		<td>
			<center><strong><?php xl("HOMEBOUND REASON","e");?></strong></center><br>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Needs assistance for all activities" <?php if(in_array("Needs assistance for all activities",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Needs assistance for all activities','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Residual weakness" <?php if(in_array("Residual weakness",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Residual weakness','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Requires assistance to ambulate" <?php if(in_array("Requires assistance to ambulate",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Requires assistance to ambulate','e')?></label>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Confusion, unable to go out of home alone" <?php if(in_array("Confusion, unable to go out of home alone",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Confusion, unable to go out of home alone','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Unable to safely leave home unassisted" <?php if(in_array("Unable to safely leave home unassisted",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Unable to safely leave home unassisted','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Severe SOB, SOB upon exertion" <?php if(in_array("Severe SOB, SOB upon exertion",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Severe SOB, SOB upon exertion','e')?></label>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Dependent upon adaptive device" <?php if(in_array("Dependent upon adaptive device",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Dependent upon adaptive device(s)','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Medical restrictions" <?php if(in_array("Medical restrictions",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Medical restrictions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_homebound_reason[]" value="Other(specify)" <?php if(in_array("Other(specify)",$oasis_therapy_homebound_reason)) echo "checked"; ?> ><?php xl('Other','e')?></label>
							<input type="text" name="oasis_therapy_homebound_reason_other" value="<?php echo $obj{"oasis_therapy_homebound_reason_other"};?>">
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
			<div><a href="#" id="black">Summary Checklist, DME/Medical Supplies, Safety Measures</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("SUMMARY CHECKLIST","e");?></strong></center><br>
			<strong><?php xl("CARE PLAN:","e");?></strong>
			<label><input type="checkbox" name="oasis_therapy_summary_check_careplan" value="Reviewed" <?php if($obj{"oasis_therapy_summary_check_careplan"}=="Reviewed"){echo "checked";}?> ><?php xl('Reviewed/Revised with patient involvement','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_careplan" value="achieved" <?php if($obj{"oasis_therapy_summary_check_careplan"}=="achieved"){echo "checked";}?> ><?php xl('Outcome achieved','e')?></label><br>
			
			<strong><?php xl("MEDICATION STATUS:","e");?></strong>
			<label><input type="checkbox" name="oasis_therapy_summary_check_medication" value="completed" <?php if($obj{"oasis_therapy_summary_check_medication"}=="completed"){echo "checked";}?> ><?php xl('Medication regimen completed/reviewed (Locator #10)','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_medication" value="No change" <?php if($obj{"oasis_therapy_summary_check_medication"}=="No change"){echo "checked";}?> ><?php xl('No change','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_medication" value="obtained" <?php if($obj{"oasis_therapy_summary_check_medication"}=="obtained"){echo "checked";}?> ><?php xl('Order obtained','e')?></label><br>
			
			<?php xl("Check if any of the following were identified:","e");?><br>
			<label><input type="checkbox" name="oasis_therapy_summary_check_identified[]" value="Potential adverse effects/drug reactions" <?php if(in_array("Potential adverse effects/drug reactions",$oasis_therapy_summary_check_identified)) echo "checked"; ?> ><?php xl('Potential adverse effects/drug reactions','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_identified[]" value="Ineffective drug therapy" <?php if(in_array("Ineffective drug therapy",$oasis_therapy_summary_check_identified)) echo "checked"; ?> ><?php xl('Ineffective drug therapy','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_identified[]" value="Significant side effects" <?php if(in_array("Significant side effects",$oasis_therapy_summary_check_identified)) echo "checked"; ?> ><?php xl('Significant side effects','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_identified[]" value="Significant drug interactions" <?php if(in_array("Significant drug interactions",$oasis_therapy_summary_check_identified)) echo "checked"; ?> ><?php xl('Significant drug interactions','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_summary_check_identified[]" value="Duplicate drug therapy" <?php if(in_array("Duplicate drug therapy",$oasis_therapy_summary_check_identified)) echo "checked"; ?> ><?php xl('Duplicate drug therapy','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_identified[]" value="Non-compliance with drug therapy" <?php if(in_array("Non-compliance with drug therapy",$oasis_therapy_summary_check_identified)) echo "checked"; ?> ><?php xl('Non-compliance with drug therapy','e')?></label><br>
			
			<strong><?php xl("CARE COORDINATION:","e");?></strong>
			<label><input type="checkbox" name="oasis_therapy_summary_check_care_coordination" value="Physician" <?php if($obj{"oasis_therapy_summary_check_care_coordination"}=="Physician"){echo "checked";}?> ><?php xl('Physician','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_care_coordination" value="SN" <?php if($obj{"oasis_therapy_summary_check_care_coordination"}=="SN"){echo "checked";}?> ><?php xl('SN','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_care_coordination" value="PT" <?php if($obj{"oasis_therapy_summary_check_care_coordination"}=="PT"){echo "checked";}?> ><?php xl('PT','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_care_coordination" value="OT" <?php if($obj{"oasis_therapy_summary_check_care_coordination"}=="OT"){echo "checked";}?> ><?php xl('OT','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_care_coordination" value="ST" <?php if($obj{"oasis_therapy_summary_check_care_coordination"}=="ST"){echo "checked";}?> ><?php xl('ST','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_care_coordination" value="MSW" <?php if($obj{"oasis_therapy_summary_check_care_coordination"}=="MSW"){echo "checked";}?> ><?php xl('MSW','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_care_coordination" value="Aide" <?php if($obj{"oasis_therapy_summary_check_care_coordination"}=="Aide"){echo "checked";}?> ><?php xl('Aide','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_summary_check_care_coordination" value="Other" <?php if($obj{"oasis_therapy_summary_check_care_coordination"}=="Other"){echo "checked";}?> ><?php xl('Other(specify)','e')?></label>
				<input type="text" name="oasis_therapy_summary_check_carecordination_other" value="<?php echo $obj{"oasis_therapy_summary_check_carecordination_other"};?>"><br>
			
			<strong><?php xl("REFERRAL TO:","e");?></strong><input type="text" name="oasis_therapy_summary_check_referrel" value="<?php echo $obj{"oasis_therapy_summary_check_referrel"};?>">
			<strong><?php xl("APPROXIMATE NEXT VISIT DATE:","e");?></strong>
			<input type='text' size='10' name='oasis_therapy_summary_check_next_visit' id='oasis_therapy_summary_check_next_visit' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_summary_check_next_visit"};?>" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date9' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_therapy_summary_check_next_visit", ifFormat:"%Y-%m-%d", button:"img_curr_date9"});
						</script>
			<br>
			<strong><?php xl("RECERTIFICATION:","e");?></strong>
			<label><input type="radio" name="oasis_therapy_summary_check_recertification" value="No" <?php if($obj{"oasis_therapy_summary_check_recertification"}=="No"){echo "checked";}?> ><?php xl(' No, complete discharge summary','e')?></label>
			<label><input type="radio" name="oasis_therapy_summary_check_recertification" value="Yes" <?php if($obj{"oasis_therapy_summary_check_recertification"}=="Yes"){echo "checked";}?> ><?php xl(' Yes, complete remaining sections, as appropriate.','e')?></label><br>
			
			<strong><?php xl("Verbal Order obtained:","e");?></strong>
			<label><input type="radio" name="oasis_therapy_summary_check_verbal_order" value="No" <?php if($obj{"oasis_therapy_summary_check_verbal_order"}=="No"){echo "checked";}?> ><?php xl(' No','e')?></label>
			<label><input type="radio" name="oasis_therapy_summary_check_verbal_order" value="Yes" <?php if($obj{"oasis_therapy_summary_check_verbal_order"}=="Yes"){echo "checked";}?> ><?php xl(' Yes, specify date (Locator #23)','e')?></label><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="formtable" border="0">
					<tr>
						<td colspan="4" align="center">
							<strong><?php xl("DME/MEDICAL SUPPLIES ","e");?></strong>
							<label><input type="checkbox" name="oasis_therapy_dme" value="NA" <?php if($obj{"oasis_therapy_dme"}=="NA"){echo "checked";}?> ><?php xl('NA','e')?></label>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<strong><?php xl("WOUND CARE: ","e");?></strong><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="2x2s" <?php if(in_array("2x2s",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('2x2s','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="4x4s" <?php if(in_array("4x4s",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('4x4s','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="ABDs" <?php if(in_array("ABDs",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('ABDs','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Cotton tipped applicators" <?php if(in_array("Cotton tipped applicators",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Cotton tipped applicators','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Wound cleanser" <?php if(in_array("Wound cleanser",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Wound cleanser','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Wound gel" <?php if(in_array("Wound gel",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Wound gel','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Drain sponges" <?php if(in_array("Drain sponges",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Drain sponges','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Gloves:" <?php if(in_array("Gloves:",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Gloves:','e')?></label>
								<label><input type="checkbox" name="oasis_therapy_dme_wound_care_glove" value="Sterile" <?php if($obj{"oasis_therapy_dme_wound_care_glove"}=="Sterile"){echo "checked";}?> ><?php xl('Sterile','e')?></label>
								<label><input type="checkbox" name="oasis_therapy_dme_wound_care_glove" value="Non-Sterile" <?php if($obj{"oasis_therapy_dme_wound_care_glove"}=="Non-Sterile"){echo "checked";}?> ><?php xl('Non-Sterile','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Hydrocolloids" <?php if(in_array("Hydrocolloids",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Hydrocolloids','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Kerlix size" <?php if(in_array("Kerlix size",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Kerlix size','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Nu-gauze" <?php if(in_array("Nu-gauze",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Nu-gauze','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Saline" <?php if(in_array("Saline",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Saline','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Tape" <?php if(in_array("Tape",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Transparent Dressings" <?php if(in_array("Transparent Dressings",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Transparent Dressings','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_wound_care[]" value="Other" <?php if(in_array("Other",$oasis_therapy_dme_wound_care)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_therapy_dme_wound_care_other" value="<?php echo $obj{"oasis_therapy_dme_wound_care_other"};?>"><br><br>
								
							<strong><?php xl("DIABETIC: ","e");?></strong><br>
							<label><input type="checkbox" name="oasis_therapy_dme_diabetic[]" value="Chemstrips" <?php if(in_array("Chemstrips",$oasis_therapy_dme_diabetic)) echo "checked"; ?> ><?php xl('Chemstrips','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_diabetic[]" value="Syringes" <?php if(in_array("Syringes",$oasis_therapy_dme_diabetic)) echo "checked"; ?> ><?php xl('Syringes','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_diabetic[]" value="Other" <?php if(in_array("Other",$oasis_therapy_dme_diabetic)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_therapy_dme_diabetic_other" value="<?php echo $obj{"oasis_therapy_dme_diabetic_other"};?>"><br><br>
						</td>
						<td valign="top">
							<strong><?php xl("IV SUPPLIES: ","e");?></strong><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="IV start kit" <?php if(in_array("IV start kit",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV start kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="IV pole" <?php if(in_array("IV pole",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV pole','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="IV tubing" <?php if(in_array("IV tubing",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV tubing','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Alcohol swabs" <?php if(in_array("Alcohol swabs",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Alcohol swabs','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Angiocatheter size" <?php if(in_array("Angiocatheter size",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Angiocatheter size','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Tape" <?php if(in_array("Tape",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Extension tubings" <?php if(in_array("Extension tubings",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Extension tubings','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Injection caps" <?php if(in_array("Injection caps",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Injection caps','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Central line dressing" <?php if(in_array("Central line dressing",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Central line dressing','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Infusion pump" <?php if(in_array("Infusion pump",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Infusion pump','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Batteries size" <?php if(in_array("Batteries size",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Batteries size','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Syringes size" <?php if(in_array("Syringes size",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Syringes size','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_iv_supplies[]" value="Other" <?php if(in_array("Other",$oasis_therapy_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_therapy_dme_iv_supplies_other" value="<?php echo $obj{"oasis_therapy_dme_iv_supplies_other"};?>"><br><br>
							
							<strong><?php xl("FOLEY SUPPLIES: ","e");?></strong><br>
							<label><input type="checkbox" name="oasis_therapy_dme_foley_supplies[]" value="Fr catheter kit" <?php if(in_array("Fr catheter kit",$oasis_therapy_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Fr catheter kit','e')?></label><br>
							<?php xl("(tray, bag, foley) ","e");?><br>
							<label><input type="checkbox" name="oasis_therapy_dme_foley_supplies[]" value="Straight catheter" <?php if(in_array("Straight catheter",$oasis_therapy_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Straight catheter','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_foley_supplies[]" value="Irrigation tray" <?php if(in_array("Irrigation tray",$oasis_therapy_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Irrigation tray','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_foley_supplies[]" value="Saline" <?php if(in_array("Saline",$oasis_therapy_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Saline','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_foley_supplies[]" value="Acetic acid" <?php if(in_array("Acetic acid",$oasis_therapy_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Acetic acid','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_foley_supplies[]" value="Other" <?php if(in_array("Other",$oasis_therapy_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Other','e')?></label><br>
								<input type="text" name="oasis_therapy_dme_foley_supplies_other" value="<?php echo $obj{"oasis_therapy_dme_foley_supplies_other"};?>"><br><br>
						</td>
						<td valign="top">
							<strong><?php xl("URINARY/OSTOMY: ","e");?></strong><br>
							<label><input type="checkbox" name="oasis_therapy_dme_urinary[]" value="Underpads" <?php if(in_array("Underpads",$oasis_therapy_dme_urinary)) echo "checked"; ?> ><?php xl('Underpads','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_urinary[]" value="External catheters" <?php if(in_array("External catheters",$oasis_therapy_dme_urinary)) echo "checked"; ?> ><?php xl('External catheters','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_urinary[]" value="Urinary bag/pouch" <?php if(in_array("Urinary bag/pouch",$oasis_therapy_dme_urinary)) echo "checked"; ?> ><?php xl('Urinary bag/pouch','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_urinary[]" value="Ostomy pouch" <?php if(in_array("Ostomy pouch",$oasis_therapy_dme_urinary)) echo "checked"; ?> ><?php xl('Ostomy pouch (brand, size)','e')?></label>
							<input type="text" name="oasis_therapy_dme_urinary_ostomy_pouch" value="<?php echo $obj{"oasis_therapy_dme_urinary_ostomy_pouch"};?>"><br>
							<label><input type="checkbox" name="oasis_therapy_dme_urinary[]" value="Ostomy wafer" <?php if(in_array("Ostomy wafer",$oasis_therapy_dme_urinary)) echo "checked"; ?> ><?php xl('Ostomy wafer (brand, size)','e')?></label>
							<input type="text" name="oasis_therapy_dme_urinary_ostomy_wafer" value="<?php echo $obj{"oasis_therapy_dme_urinary_ostomy_wafer"};?>"><br>
							<label><input type="checkbox" name="oasis_therapy_dme_urinary[]" value="Stoma adhesive tape" <?php if(in_array("Stoma adhesive tape",$oasis_therapy_dme_urinary)) echo "checked"; ?> ><?php xl('Stoma adhesive tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_urinary[]" value="Skin protectant" <?php if(in_array("Skin protectant",$oasis_therapy_dme_urinary)) echo "checked"; ?> ><?php xl('Skin protectant','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_urinary[]" value="Other" <?php if(in_array("Other",$oasis_therapy_dme_urinary)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_therapy_dme_urinary_other" value="<?php echo $obj{"oasis_therapy_dme_urinary_other"};?>"><br><br>
							
							<strong><?php xl("MISCELLANEOUS: ","e");?></strong><br>
							<label><input type="checkbox" name="oasis_therapy_dme_miscellaneous[]" value="Enema supplies" <?php if(in_array("Enema supplies",$oasis_therapy_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Enema supplies','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_miscellaneous[]" value="Feeding tube" <?php if(in_array("Feeding tube",$oasis_therapy_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Feeding tube:','e')?></label><br>
							<?php xl('type','e')?><input type="text" name="oasis_therapy_dme_miscellaneous_type" value="<?php echo $obj{"oasis_therapy_dme_miscellaneous_type"};?>">
							<?php xl('size','e')?><input type="text" name="oasis_therapy_dme_miscellaneous_size" value="<?php echo $obj{"oasis_therapy_dme_miscellaneous_size"};?>"><br>
							<label><input type="checkbox" name="oasis_therapy_dme_miscellaneous[]" value="Suture removal kit" <?php if(in_array("Suture removal kit",$oasis_therapy_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Suture removal kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_miscellaneous[]" value="Staple removal kit" <?php if(in_array("Staple removal kit",$oasis_therapy_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Staple removal kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_miscellaneous[]" value="Steri strips" <?php if(in_array("Steri strips",$oasis_therapy_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Steri strips','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_miscellaneous[]" value="Other" <?php if(in_array("Other",$oasis_therapy_dme_miscellaneous)) echo "checked"; ?> ><?php xl('Other','e')?></label>
								<input type="text" name="oasis_therapy_dme_miscellaneous_other" value="<?php echo $obj{"oasis_therapy_dme_miscellaneous_other"};?>"><br>
						</td>
						<td valign="top">
							<strong><?php xl("SUPPLIES/EQUIPMENT: ","e");?></strong><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Bathbench" <?php if(in_array("Bathbench",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Bathbench','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Cane" <?php if(in_array("Cane",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Cane','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Commode" <?php if(in_array("Commode",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Commode','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Special mattress overlay" <?php if(in_array("Special mattress overlay",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Special mattress overlay','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Pressure relieving device" <?php if(in_array("Pressure relieving device",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Pressure relieving device','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Eggcrate" <?php if(in_array("Eggcrate",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Eggcrate','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Hospital bed" <?php if(in_array("Hospital bed",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Hospital bed','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Hoyer lift" <?php if(in_array("Hoyer lift",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Hoyer lift','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Enteral feeding pump" <?php if(in_array("Enteral feeding pump",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Enteral feeding pump','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Nebulizer" <?php if(in_array("Nebulizer",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Nebulizer','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Oxygen concentrator" <?php if(in_array("Oxygen concentrator",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Oxygen concentrator','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Suction machine" <?php if(in_array("Suction machine",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Suction machine','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Ventilator" <?php if(in_array("Ventilator",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Ventilator','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Walker" <?php if(in_array("Walker",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Walker','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Wheelchair" <?php if(in_array("Wheelchair",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Wheelchair','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Tens unit" <?php if(in_array("Tens unit",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Tens unit','e')?></label><br>
							<label><input type="checkbox" name="oasis_therapy_dme_supplies[]" value="Other" <?php if(in_array("Other",$oasis_therapy_dme_supplies)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
								<input type="text" name="oasis_therapy_dme_supplies_other" value="<?php echo $obj{"oasis_therapy_dme_supplies_other"};?>"><br>
						</td>
					</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<strong><?php xl("SAFETY MEASURES","e");?></strong><br>
		</td>
	</tr>
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
	<tr>
		<td valign="top">
			<center><strong><?php xl("NUTRITIONAL REQUIREMENTS ","e");?></strong></center>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="Regular Diet" <?php if(in_array("Regular Diet",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('Regular Diet','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="Diet as Tolerated" <?php if(in_array("Diet as Tolerated",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('Diet as Tolerated','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="Soft Diet" <?php if(in_array("Soft Diet",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('Soft Diet','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="NCS" <?php if(in_array("NCS",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('NCS','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="Diabetic Diet Calorie ADA" <?php if(in_array("Diabetic Diet Calorie ADA",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('Diabetic Diet # Calorie ADA','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="Pureed Diet" <?php if(in_array("Pureed Diet",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('Pureed Diet','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="NAS" <?php if(in_array("NAS",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('NAS','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="Low Salt Gram Sodium" <?php if(in_array("Low Salt Gram Sodium",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('Low Salt Gram Sodium','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="Low Fat/Low Cholesterol Diet" <?php if(in_array("Low Fat/Low Cholesterol Diet",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('Low Fat/Low Cholesterol Diet','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_nutritional_requirement[]" value="Other Special Diet" <?php if(in_array("Other Special Diet",$oasis_therapy_nutritional_requirement)) echo "checked"; ?> ><?php xl('Other Special Diet','e')?></label>
				<input type="text" name="oasis_therapy_nutritional_requirement_other" value="<?php echo $obj{"oasis_therapy_nutritional_requirement_other"};?>"><br>
			
			<br>
			<center><strong><?php xl("ALLERGIES","e");?></strong></center>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="NKDA" <?php if(in_array("NKDA",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('NKDA','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="Penicillin" <?php if(in_array("Penicillin",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('Penicillin','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="Sulfa" <?php if(in_array("Sulfa",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('Sulfa','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="Aspirin" <?php if(in_array("Aspirin",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('Aspirin','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="Milk Products" <?php if(in_array("Milk Products",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('Milk Products','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="Pollen" <?php if(in_array("Pollen",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('Pollen','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="Insect Bites" <?php if(in_array("Insect Bites",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('Insect Bites','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="Eggs" <?php if(in_array("Eggs",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('Eggs','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_allergies[]" value="Other" <?php if(in_array("Other",$oasis_therapy_allergies)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_therapy_nutritional_allergies_other" value="<?php echo $obj{"oasis_therapy_nutritional_allergies_other"};?>"><br>
		</td>
		<td>
			<center><strong><?php xl("FUNCTIONAL LIMITATIONS","e");?></strong></center>
			<table class="formtable">
				<tr>
					<td valign="top">
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Amputation" <?php if(in_array("Amputation",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Amputation','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Hearing" <?php if(in_array("Hearing",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Hearing','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Ambulation" <?php if(in_array("Ambulation",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Ambulation','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Dyspnea with Minimal Exertion" <?php if(in_array("Dyspnea with Minimal Exertion",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Dyspnea with Minimal Exertion','e')?></label>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Bowel/Bladder (Incontinence)" <?php if(in_array("Bowel/Bladder (Incontinence)",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Bowel/Bladder <br>(Incontinence)','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Paralysis" <?php if(in_array("Paralysis",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Paralysis','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Speech" <?php if(in_array("Speech",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Speech','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Other" <?php if(in_array("Other",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Other (specify):','e')?></label>
							<input type="text" name="oasis_therapy_functional_limitations_other" value="<?php echo $obj{"oasis_therapy_functional_limitations_other"};?>">
					</td>
					<td valign="top" width="30%">
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Contracture" <?php if(in_array("Contracture",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Contracture','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Endurance" <?php if(in_array("Endurance",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Endurance','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_functional_limitations[]" value="Legally Blind" <?php if(in_array("Legally Blind",$oasis_therapy_functional_limitations)) echo "checked"; ?> ><?php xl('Legally Blind','e')?></label>
					</td>
				</tr>
			</table>
			
			<br>
			<center><strong><?php xl("MENTAL STATUS","e");?></strong></center>
			<label><input type="checkbox" name="oasis_therapy_mental_status[]" value="Oriented" <?php if(in_array("Oriented",$oasis_therapy_mental_status)) echo "checked"; ?> ><?php xl('Oriented','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_mental_status[]" value="Comatose" <?php if(in_array("Comatose",$oasis_therapy_mental_status)) echo "checked"; ?> ><?php xl('Comatose','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_mental_status[]" value="Forgetful" <?php if(in_array("Forgetful",$oasis_therapy_mental_status)) echo "checked"; ?> ><?php xl('Forgetful','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_mental_status[]" value="Depressed" <?php if(in_array("Depressed",$oasis_therapy_mental_status)) echo "checked"; ?> ><?php xl('Depressed','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_mental_status[]" value="Disoriented" <?php if(in_array("Disoriented",$oasis_therapy_mental_status)) echo "checked"; ?> ><?php xl('Disoriented','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_mental_status[]" value="Lethargic" <?php if(in_array("Lethargic",$oasis_therapy_mental_status)) echo "checked"; ?> ><?php xl('Lethargic','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_mental_status[]" value="Agitated" <?php if(in_array("Agitated",$oasis_therapy_mental_status)) echo "checked"; ?> ><?php xl('Agitated','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_mental_status[]" value="Other" <?php if(in_array("Other",$oasis_therapy_mental_status)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_therapy_mental_status_other" value="<?php echo $obj{"oasis_therapy_mental_status_other"};?>">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<strong><?php xl("DISCHARGE PLAN:","e");?></strong>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="Assist Pt/Cg in attaining goals & DC" <?php if(in_array("Assist Pt/Cg in attaining goals & DC",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('Assist Pt/Cg in attaining goals & DC','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="Physician Supervision" <?php if(in_array("Physician Supervision",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('Physician Supervision','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="Cg Assistance" <?php if(in_array("Cg Assistance",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('Cg Assistance','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="Long Term Care" <?php if(in_array("Long Term Care",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('Long Term Care','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="ADHC" <?php if(in_array("ADHC",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('ADHC','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="Nursing Home Placement" <?php if(in_array("Nursing Home Placement",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('Nursing Home Placement','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="Transfer to Hospice" <?php if(in_array("Transfer to Hospice",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('Transfer to Hospice','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="Ongoing Skilled Nursing - Tube Changes" <?php if(in_array("Ongoing Skilled Nursing - Tube Changes",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('Ongoing Skilled Nursing - Tube Changes','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan[]" value="Other" <?php if(in_array("Other",$oasis_therapy_discharge_plan)) echo "checked"; ?> ><?php xl('Other','e')?></label>
				<input type="text" name="oasis_therapy_discharge_plan_other" value="<?php echo $obj{"oasis_therapy_discharge_plan_other"};?>"><br>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan_detail[]" value="Patient to be discharged when skilled care no longer needed" <?php if(in_array("Patient to be discharged when skilled care no longer needed",$oasis_therapy_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Patient to be discharged when skilled care no longer needed','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan_detail[]" value="Patient to be discharged to the care of" <?php if(in_array("Patient to be discharged to the care of",$oasis_therapy_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Patient to be discharged to the care of:','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan_detail[]" value="Self" <?php if(in_array("Self",$oasis_therapy_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Self','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan_detail[]" value="Caregiver" <?php if(in_array("Caregiver",$oasis_therapy_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Caregiver','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_discharge_plan_detail[]" value="Other" <?php if(in_array("Other",$oasis_therapy_discharge_plan_detail)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_therapy_discharge_plan_detail_other" value="<?php echo $obj{"oasis_therapy_discharge_plan_detail_other"};?>">
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
						<strong><?php xl("Strength: 0/5 — 5/5","e");?></strong>
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
						<strong><?php xl("Strength: 0/5 — 5/5","e");?></strong>
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
			<textarea name="oasis_therapy_curr_level_findings" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_curr_level_findings"};?></textarea>
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
						<label><input type="checkbox" name="oasis_therapy_curr_level_risk_factor[]" value="Vertigo / Dizziness" <?php if(in_array("Vertigo / Dizziness",$oasis_therapy_curr_level_risk_factor)) echo "checked"; ?> ><?php xl("Vertigo / Dizziness","e");?></label><br>
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
			<strong><?php xl("Frequency:","e");?></strong>
			<input type="text" name="oasis_therapy_curr_level_risk_factor_frequency" value="<?php echo $obj{"oasis_therapy_curr_level_risk_factor_frequency"};?>">
		</td>
	</tr>
</table>
				</li>
			</ul>
		</li>
		<li>
			<div><a href="#" id="black">Physical Therapy Orders and Goals</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			<ul>
				<li>
<table style="width:100%;" border="1px" class="formtable">
	<tr>
		<td>
			<center><strong><?php xl("PHYSICAL THERAPY ORDERS","e");?></strong></center><br>
			<strong><?php xl("STANDARDIZED/VALIDATED AND RELIABLE TEST AND MEASUREMENTS","e");?></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Gait Training" <?php if(in_array("Gait Training",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Gait Training - To improve materially patient's ability to walk /restore functional loss (Describe):","e");?></label><br>
			<textarea name="oasis_therapy_pt_orders_gait" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_orders_gait"};?></textarea><br>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Range of Motion" <?php if(in_array("Range of Motion",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Range of Motion - To restore loss of function or restriction of mobility (Describe) :","e");?></label><br>
			<textarea name="oasis_therapy_pt_orders_range_of_motion" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_orders_range_of_motion"};?></textarea><br>
			<label><input type="radio" name="oasis_therapy_pt_orders_range" value="ROM" <?php if($obj{"oasis_therapy_pt_orders_range"}=="ROM"){echo "checked";}?> ><?php xl("ROM","e");?></label>
			<label><input type="radio" name="oasis_therapy_pt_orders_range" value="PROM" <?php if($obj{"oasis_therapy_pt_orders_range"}=="PROM"){echo "checked";}?> ><?php xl("PROM","e");?></label>
			<label><input type="radio" name="oasis_therapy_pt_orders_range" value="AAROM" <?php if($obj{"oasis_therapy_pt_orders_range"}=="AAROM"){echo "checked";}?> ><?php xl("AAROM (Describe):","e");?></label><br>
			<textarea name="oasis_therapy_pt_orders_range_desc" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_orders_range_desc"};?></textarea><br>
			
			<?php xl("Degrees of Motion:","e");?>
				<input type="text" name="oasis_therapy_pt_orders_degree_of_motion[]" value="<?php echo $oasis_therapy_pt_orders_degree_of_motion[0];?>"><br>
			<?php xl("% of Movement: ","e");?>
				<input type="text" name="oasis_therapy_pt_orders_degree_of_motion[]" value="<?php echo $oasis_therapy_pt_orders_degree_of_motion[1];?>"><br>
			<?php xl("Degrees of Motion - to be restored ","e");?>
				<input type="text" name="oasis_therapy_pt_orders_degree_of_motion[]" value="<?php echo $oasis_therapy_pt_orders_degree_of_motion[2];?>"><br>
			<?php xl("% of Movement - to be restored:","e");?>
				<input type="text" name="oasis_therapy_pt_orders_degree_of_motion[]" value="<?php echo $oasis_therapy_pt_orders_degree_of_motion[3];?>"><br>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Maintenence Therapy" <?php if(in_array("Maintenence Therapy",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Maintenence Therapy - To maintain function to (e.g. Hip, Back, RUE, LLE, etc.)(Describe) :","e");?></label><br>
			<textarea name="oasis_therapy_pt_orders_maintenence_therapy" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_orders_maintenence_therapy"};?></textarea><br>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Ultrasound" <?php if(in_array("Ultrasound",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Ultrasound","e");?></label>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Shortwave" <?php if(in_array("Shortwave",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Shortwave","e");?></label>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Microwave Diarthermy Treatment" <?php if(in_array("Microwave Diarthermy Treatment",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Microwave Diarthermy Treatment (Describe) :","e");?></label><br>
			<textarea name="oasis_therapy_pt_orders_microwave_treatement" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_orders_microwave_treatement"};?></textarea><br>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Hot Packs" <?php if(in_array("Hot Packs",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Hot Packs","e");?></label>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Infra-red Treatments" <?php if(in_array("Infra-red Treatments",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Infra-red Treatments","e");?></label>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Paraffin Baths" <?php if(in_array("Paraffin Baths",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Paraffin Baths","e");?></label>
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Whirlpool Baths" <?php if(in_array("Whirlpool Baths",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Whirlpool Baths (Describe) :","e");?></label><br>
			<textarea name="oasis_therapy_pt_orders_whirlpool_baths" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_orders_whirlpool_baths"};?></textarea><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_orders[]" value="Wound Care" <?php if(in_array("Wound Care",$oasis_therapy_pt_orders)) echo "checked"; ?> ><?php xl("Wound Care - To provide essential treatment required to care for wounds, including, but not limited to, ulcers, burns, pressure sores, open surgical sites, fistulas, tube sites, and tumor erosion sites) in order to safely and effectively treat the illness or injury.","e");?></label><br>
			<?php xl("Wound Care Intervention/ TX:","e");?>
			<input type="text" name="oasis_therapy_pt_orders_wound_care" value="<?php echo $obj{"oasis_therapy_pt_orders_wound_care"};?>"><br>
			
			<br>
			<center><strong><?php xl("PHYSICAL THERAPY GOALS","e");?></strong></center>
			<strong><?php xl("A.GAIT","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_gait[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_gait)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_gait[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_gait)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			<label><input type="checkbox" name="oasis_therapy_pt_goals_gait[]" value="PTA1" <?php if(in_array("PTA1",$oasis_therapy_pt_goals_gait)) echo "checked"; ?> ><?php xl("PTA1. ","e");?></label>
			<?php xl("Patient will demonstrate material improvement for safe gait in home on ( ","e");?>
			<label><input type="checkbox" name="oasis_therapy_pt_goals_gait[]" value="level" <?php if(in_array("level",$oasis_therapy_pt_goals_gait)) echo "checked"; ?> ><?php xl("level, ","e");?></label>
			<label><input type="checkbox" name="oasis_therapy_pt_goals_gait[]" value="uneven" <?php if(in_array("uneven",$oasis_therapy_pt_goals_gait)) echo "checked"; ?> ><?php xl("uneven ","e");?></label>
			<?php xl(" ) surfaces within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_pta1_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_pta1_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_gait[]" value="PTA2" <?php if(in_array("PTA2",$oasis_therapy_pt_goals_gait)) echo "checked"; ?> ><?php xl("PTA2. ","e");?></label>
			<?php xl("Patient will demonstrate material improvement in fall frequency reduction within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_pta2_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_pta2_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_gait[]" value="PTA3" <?php if(in_array("PTA3",$oasis_therapy_pt_goals_gait)) echo "checked"; ?> ><?php xl("PTA3. ","e");?></label>
			<?php xl("Patient will demonstrate material improvement with use of prescribed assistive devices within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_pta3_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_pta3_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_gait[]" value="PTA4" <?php if(in_array("PTA4",$oasis_therapy_pt_goals_gait)) echo "checked"; ?> ><?php xl("PTA4. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for competence with prescibed techniques related to weight bearing status within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_pta4_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_pta4_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			<br><hr><br>
			
			
			<strong><?php xl("B.BATHING - TUB SHOWER - TOILETTING","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_bath_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_bath_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_bath[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_bath)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_bath_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_bath_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_bath[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_bath)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_bath[]" value="PTB1" <?php if(in_array("PTB1",$oasis_therapy_pt_goals_bath)) echo "checked"; ?> ><?php xl("PTB1. ","e");?></label>
			<?php xl("Patient will demonstrate material improvement in safe tub/shower transfer within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptb1_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptb1_visits"};?>">
			<?php xl(" Visits.(Describe):","e");?><br>
			<textarea name="oasis_therapy_pt_goals_no_ptb1_desc" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_goals_no_ptb1_desc"};?></textarea>
			<br><hr><br>
			
			
			<strong><?php xl("C.BED MOBILITY","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_bed_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_bed_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_bed[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_bed)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_bed_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_bed_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_bed[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_bed)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_bed[]" value="PTC1" <?php if(in_array("PTC1",$oasis_therapy_pt_goals_bed)) echo "checked"; ?> ><?php xl("PTC1. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for safe bed mobility and transfers within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptc1_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptc1_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_bed[]" value="PTC2" <?php if(in_array("PTC2",$oasis_therapy_pt_goals_bed)) echo "checked"; ?> ><?php xl("PTC2. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for competence with prescribed techniques during bed mobility activities within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptc2_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptc2_visits"};?>">
			<?php xl(" Visits.(Describe):","e");?><br>
			<textarea name="oasis_therapy_pt_goals_no_ptc2_desc" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_goals_no_ptc2_desc"};?></textarea>
			<br><br>
			
		</td>
		<td>
			<center><strong><?php xl("PHYSICAL THERAPY GOALS (Cont'd)","e");?></strong></center><br>
			<strong><?php xl("D. CAR TRANSFERS","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_car_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_car_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_car[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_car)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_car_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_car_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_car[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_car)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_car[]" value="PTD1" <?php if(in_array("PTD1",$oasis_therapy_pt_goals_car)) echo "checked"; ?> ><?php xl("PTD1. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for safe motor transfers within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptd1_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptd1_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_car[]" value="PTD2" <?php if(in_array("PTD2",$oasis_therapy_pt_goals_car)) echo "checked"; ?> ><?php xl("PTD2. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for competence with (prescribed techniques/weight bearing status) during motor vehicle transfers activities within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptd2_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptd2_visits"};?>">
			<?php xl(" Visits.(Describe):","e");?><br>
			<textarea name="oasis_therapy_pt_goals_no_ptd2_desc" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_goals_no_ptd2_desc"};?></textarea>
			<br><hr><br>
			
			
			<strong><?php xl("E. THERAPEUTIC EXERCISES","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_therapeutic_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_therapeutic_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_therapeutic[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_therapeutic)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_therapeutic_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_therapeutic_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_therapeutic[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_therapeutic)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_therapeutic[]" value="PTE1" <?php if(in_array("PTE1",$oasis_therapy_pt_goals_therapeutic)) echo "checked"; ?> ><?php xl("PTE1. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement with therapeutic exercise within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_pte1_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_pte1_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_therapeutic[]" value="PTE2" <?php if(in_array("PTE2",$oasis_therapy_pt_goals_therapeutic)) echo "checked"; ?> ><?php xl("PTE2. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for competence with therapeutic exercise within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_pte2_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_pte2_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			<br><hr><br>
			
			
			
			<strong><?php xl("F. TRANSFERS","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_transfers_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_transfers_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_transfers[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_transfers)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_transfers_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_transfers_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_transfers[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_transfers)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_transfers[]" value="PTF1" <?php if(in_array("PTF1",$oasis_therapy_pt_goals_transfers)) echo "checked"; ?> ><?php xl("PTF1. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for safe transfers / Sit ? Stand within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptf1_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptf1_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_transfers[]" value="PTF2" <?php if(in_array("PTF2",$oasis_therapy_pt_goals_transfers)) echo "checked"; ?> ><?php xl("PTF2. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement with transfer function from multisurfaces within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptf2_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptf2_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_transfers[]" value="PTF3" <?php if(in_array("PTF3",$oasis_therapy_pt_goals_transfers)) echo "checked"; ?> ><?php xl("PTF3. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement in the proper use of assistive device/adaptive/techniques for effective safe transfers within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptf3_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptf3_visits"};?>">
			<?php xl(" Visits.(Describe):","e");?><br>
			<textarea name="oasis_therapy_pt_goals_no_ptf3_desc" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_goals_no_ptf3_desc"};?></textarea>
			<br><hr><br>
			
			
			
			<strong><?php xl("G. SAFETY/FALL PREVENTION GOALS","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_safety_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_safety_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_safety[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_safety)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_safety_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_safety_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_safety[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_safety)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_safety[]" value="PTG1" <?php if(in_array("PTG1",$oasis_therapy_pt_goals_safety)) echo "checked"; ?> ><?php xl("PTG1. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for competence with fall prevention and home safety Within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_ptg1_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_ptg1_visits"};?>">
			<?php xl(" Visits.","e");?>
			<br><hr><br>
			
			
			<strong><?php xl("H. WHEELCHAIR FUNCTION","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_wheelchair_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_wheelchair_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_wheelchair[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_wheelchair)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_wheelchair_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_wheelchair_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_wheelchair[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_wheelchair)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_wheelchair[]" value="PTH1" <?php if(in_array("PTH1",$oasis_therapy_pt_goals_wheelchair)) echo "checked"; ?> ><?php xl("PTH1. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for safe and effective use of assistive protective devices/accessories for wheelchair functioning within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_pth1_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_pth1_visits"};?>">
			<?php xl(" Visits.","e");?><br>
			
			<label><input type="checkbox" name="oasis_therapy_pt_goals_wheelchair[]" value="PTH2" <?php if(in_array("PTH2",$oasis_therapy_pt_goals_wheelchair)) echo "checked"; ?> ><?php xl("PTH2. ","e");?></label>
			<?php xl("Patient/CG will demonstrate material improvement for safe and effective use of manaual/motorized wheelchair/scooter within #","e");?>
			<input type="text" name="oasis_therapy_pt_goals_no_pth2_visits" value="<?php echo $obj{"oasis_therapy_pt_goals_no_pth2_visits"};?>">
			<?php xl(" Visits to include the following:","e");?><br>
			<textarea name="oasis_therapy_pt_goals_no_pth2_desc" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_goals_no_pth2_desc"};?></textarea>
			<br><hr><br>
			
			
			<strong><?php xl("I. OTHER","e");?></strong><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_other_no_short" value="<?php echo $obj{"oasis_therapy_pt_goals_other_no_short"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_other[]" value="Short - Term" <?php if(in_array("Short - Term",$oasis_therapy_pt_goals_other)) echo "checked"; ?> ><?php xl("Short - Term","e");?></label><br>
			<?php xl("Measurable Goals:","e");?>
			<input type="text" name="oasis_therapy_pt_goals_other_no_long" value="<?php echo $obj{"oasis_therapy_pt_goals_other_no_long"};?>">
			<label><input type="checkbox" name="oasis_therapy_pt_goals_other[]" value="Long - Term" <?php if(in_array("Long - Term",$oasis_therapy_pt_goals_other)) echo "checked"; ?> ><?php xl("Long - Term","e");?></label><br>
			<?php xl(" Describe:","e");?><br>
			<textarea name="oasis_therapy_pt_goals_no_other_desc" rows="3" style="width:100%;"><?php echo $obj{"oasis_therapy_pt_goals_no_other_desc"};?></textarea>
			<br><br>
			
			<center><strong><?php xl("ORDERS","e");?></strong></center><br>
			<label><input type="checkbox" name="oasis_therapy_orders" value="in-patient facility" <?php if($obj{"oasis_therapy_orders"}=="in-patient facility"){echo "checked";}?> ><?php xl("All homecare services to be placed on hold if patient is admitted to an in-patient facility and resumed when patient is discharged home from the facility.","e");?></label><br>
		</td>
	</tr>
	
</table>
			</li>
		</ul>
	</li>
</ul>
<!--<a id="btn_save" href="javascript:void(0)" class="link_submit"><?php xl(' [Save]','e')?></a>-->
<a id="btn_save" href="javascript:top.restoreSession();document.oasis_therapy_rectification.submit();"
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