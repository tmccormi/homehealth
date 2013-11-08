<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: oasis_nursing_soc");
/* include api.inc. also required. */
require_once($GLOBALS['srcdir'].'/api.inc');
/* include our smarty derived controller class. */
require($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');
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
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.7.2.min.js" type="text/javascript"></script>
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
<body>
<form method="post"	action="<?php echo $rootdir;?>/forms/oasis_nursing_soc/save.php?mode=new" name="oasis_nursing_soc">
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
						<input type="text" name="oasis_patient_caregiver" value="">
					</td>

<td align="right">
<?php xl('Start of Care Date','e');?>
<input type='text' size='12' id='oasis_patient_visit_date' name='oasis_patient_visit_date' value="<?php VisitDate(); ?>" readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_eff_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'>

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"oasis_patient_visit_date", ifFormat:"%Y-%m-%d", button:"img_eff_date"});
</script>
<?php } else {echo '';} ?>
</td>

				</tr>
				<tr>
					<td align="right">
						<?php xl('Time In','e');?>
						<select name="time_in" id="time_in">
							<?php timeDropDown($GLOBALS['Selected']) ?>
						</select>
					</td>
					<td align="right">
						<?php xl('Time Out','e');?>
						<select name="time_out" id="time_out">
							<?php timeDropDown($GLOBALS['Selected']) ?>
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
			<input type="text" name="oasis_patient_cms_no" value=""><br>
			<?php xl('<u>(M0014)</u>Branch State: ','e');?>
			<input type="text" name="oasis_patient_branch_state" value=""><br>
			<?php xl('<u>(M0016)</u> Branch ID Number: ','e');?>
			<input type="text" name="oasis_patient_branch_id_no" value=""><br>
			<?php xl('<u>(M0018)</u> National Provider Identifier (N P I)</strong> for the attending physician who has signed the plan of care: ','e');?>
			<input type="text" name="oasis_patient_npi" value=""><br>
			<strong>
			<label><input type="checkbox" name="oasis_patient_npi_na" value="N/A"><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<?php xl('Primary Referring Physician I.D.: ','e');?>
			<input type="text" name="oasis_patient_referring_physician_id" value=""><br>
			<label><input type="checkbox" name="oasis_patient_referring_physician_id_na" value="N/A"><?php xl('UK - Unknown or Not Available','e');?></label><br>
			</strong>
			<br>
			
			<strong><?php xl('Primary Referring Physician: ','e');?></strong><br>
			<table  class="formtable">
			<tr>
			<td>
			<?php xl('Last: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_last" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('First: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_first" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('Phone: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_phone" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('Address: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_address" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('City: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_city" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('State: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_state" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('Zip Code: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_primary_physician_zip" value=""><br>
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
			<input type="text" name="oasis_patient_other_physician_last" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('First: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_first" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('Phone: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_phone" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('Address: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_address" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('City: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_city" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('State: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_state" value=""><br>
			</td></tr>
			<tr><td>
			<?php xl('Zip Code: ','e');?>
			</td><td>
			<input type="text" name="oasis_patient_other_physician_zip" value=""><br>
			</td>
			</tr>
			</table>
			<br>
			
			<strong>
			<?php xl('<u>(M0020)</u>Patient ID Number: ','e');?>
			<input type="text" name="oasis_patient_patient_id" value="<?php patientName('pid');?>" readonly><br>
			<?php xl('<u>(M0030)</u> Start of Care Date:','e');?>
				<input type='text' size='10' name='oasis_patient_soc_date' id='oasis_patient_soc_date' 
					title='<?php xl('Start of Care Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly /> 
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
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly /> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2a' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_resumption_care_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2a"});
					</script>
					<br>
			<label><input type="checkbox" name="oasis_patient_resumption_care_date_na" value="N/A"><?php xl('NA - Not Applicable','e');?></label><br>
			<?php xl('<u>(M0040)</u> Patient"s Name: ','e');?><br>
			</strong>
			<table cellspacing="0" border="0" class="formtable">
				<tr>
					<td align="right">
						<?php xl('First: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_name_first" value="<?php patientName('fname');?>" readonly>
					</td>
					<td align="right">
						<?php xl('MI: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_name_mi" value="<?php patientName('mname');?>" readonly>
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl('Last: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_name_last" value="<?php patientName('lname');?>" readonly>
					</td>
					<td align="right">
						<?php xl('Suffix: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_name_suffix" value="<?php patientName('title');?>" readonly>
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
						<input type="text" name="oasis_patient_patient_address_street" value="<?php patientName('street');?>" readonly>
					</td>
					<td align="right">
						<?php xl('City: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_patient_patient_address_city" value="<?php patientName('city');?>" readonly>
					</td>
				</tr>
			</table>
			<br>
			
			<strong>
			<?php xl('Patient Phone: ','e');?>
			<input type="text" name="oasis_patient_patient_phone" value="<?php patientName('phone_home');?>" readonly><br>
			<?php xl('<u>(M0050)</u> Patient State of Residence: ','e');?>
			<input type="text" name="oasis_patient_patient_state" value="<?php patientName('state');?>" readonly><br>
			<?php xl('<u>(M0060)</u> Patient Zip Code: ','e');?>
			<input type="text" name="oasis_patient_patient_zip" value="<?php patientName('postal_code');?>" readonly><br>
			</strong>
		</td>
		<td valign="top">
			<b>
			<?php xl('<u>(M0063)</u> Medicare Number: (including suffix) ','e');?>
			<input type="text" name="oasis_patient_medicare_no" value=""><br>
			<label><input type="checkbox" name="oasis_patient_medicare_no_na" value="N/A"><?php xl('N/A - No Medicare','e');?></label><br>
			<?php xl('<u>(M0064)</u> Social Security Number: ','e');?>
			<input type="text" name="oasis_patient_ssn" value=""><br>
			<label><input type="checkbox" name="oasis_patient_ssn_na" value="UK"><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<?php xl('<u>(M0065)</u> Medicaid Number: ','e');?>
			<input type="text" name="oasis_patient_medicaid_no" value=""><br>
			<label><input type="checkbox" name="oasis_patient_medicaid_no_na" value="N/A"><?php xl('NA - No Medicaid','e');?></label><br>
			<?php xl('<u>(M0066)</u> Birth Date: ','e');?>
				<input type='text' size='10' name='oasis_patient_birth_date' value="<?php patientName("DOB");?>" readonly /> 
					<br>
			<?php xl('<u>(M0069)</u> Gender: ','e');?></b>
				<label><input type="radio" name="oasis_patient_patient_gender" id="male" value="male" <?php if(patientGender()=="Male"){echo "checked";}else{echo " onclick=\"this.checked = false;  $('#female').attr('checked','checked');\"";} ?> ><?php xl('Male','e');?></label>
				<label><input type="radio" name="oasis_patient_patient_gender" id="female" value="female" <?php if(patientGender()=="Female"){echo "checked";}else{echo " onclick=\"this.checked = false;  $('#male').attr('checked','checked');\"";} ?> ><?php xl('Female','e');?></label>
			
			<br>
			<strong><?php xl('<u>(M0140)</u> Race/Ethnicity: (Mark all that apply.)','e');?></strong><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="1"><?php xl(' 1 - American Indian or Alaska Native','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="2"><?php xl(' 2 - Asian','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="3"><?php xl(' 3 - Black or African-American','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="4"><?php xl(' 4 - Hispanic or Latino','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="5"><?php xl(' 5 - Native Hawaiian or Pacific Islander','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_race_ethnicity[]" value="6"><?php xl(' 6 - White','e')?></label><br>
			<br>
			
			<hr>
			<strong><?php xl('<u>(M0150)</u> Current Payment Sources for Home Care: (Mark all that apply.)','e');?></strong><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="0"><?php xl(' 0 - None; no charge for current services','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="1"><?php xl(' 1 - Medicare (traditional fee-for-service)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="2"><?php xl(' 2 - Medicare (HMO/managed care/Advantage plan)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="3"><?php xl(' 3 - Medicaid (traditional fee-for-service)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="4"><?php xl(' 4 - Medicaid (HMO/managed care)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="5"><?php xl(' 5 - Workers" compensation','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="6"><?php xl(' 6 - Title programs (e.g., Title III, V, or XX)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="7"><?php xl(' 7 - Other government (e.g., TriCare, VA, etc.)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="8"><?php xl(' 8 - Private insurance','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="9"><?php xl(' 9 - Private HMO/managed care','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="10"><?php xl(' 10 - Self-pay','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="11"><?php xl(' 11 - Other (specify)','e')?></label>
				<input type='text' name='oasis_patient_payment_source_homecare_other' value=""/><br>
			<label><input type="checkbox" name="oasis_patient_payment_source_homecare[]" value="UK"><?php xl(' UK - Unknown','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('Certification Period From: ','e');?></strong>
			<input type='text' size='10' name='oasis_patient_certification_period_from' id='oasis_patient_certification_period_from' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date5' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_certification_period_from", ifFormat:"%Y-%m-%d", button:"img_curr_date5"});
					</script>
			<?php xl(' To: ','e');?>
			<input type='text' size='10' name='oasis_patient_certification_period_to' id='oasis_patient_certification_period_to' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date5b' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_certification_period_to", ifFormat:"%Y-%m-%d", button:"img_curr_date5b"});
					</script>
			<hr>
			<strong><?php xl('Certification:','e');?></strong><br>
				<label><input type="radio" name="oasis_patient_certification" value="0" checked ><?php xl(' Certification','e');?></label>
				<label><input type="radio" name="oasis_patient_certification" value="1"><?php xl(' Recertification','e');?></label>
			<hr>
			<strong><?php xl('Date Last Contacted Physician: ','e');?></strong>
			<input type='text' size='10' name='oasis_patient_date_last_contacted_physician' id='oasis_patient_date_last_contacted_physician' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date_sy1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_date_last_contacted_physician", ifFormat:"%Y-%m-%d", button:"img_curr_date_sy1"});
					</script>
			<hr>
			<strong><?php xl('Date Last Seen By Physician: ','e');?></strong>
			<input type='text' size='10' name='oasis_patient_date_last_seen_by_physician' id='oasis_patient_date_last_seen_by_physician' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show	_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date_sy2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_date_last_seen_by_physician", ifFormat:"%Y-%m-%d", button:"img_curr_date_sy2"});
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
				<label><input type="radio" name="oasis_patient_discipline_person" value="1" checked><?php xl(' 1 - RN ','e');?></label>&nbsp;&nbsp;
				<label><input type="radio" name="oasis_patient_discipline_person" value="2"><?php xl(' 2 - PT ','e');?></label>&nbsp;&nbsp;
				<label><input type="radio" name="oasis_patient_discipline_person" value="3"><?php xl(' 3 - SLP/ST ','e');?></label>&nbsp;&nbsp;
				<label><input type="radio" name="oasis_patient_discipline_person" value="4"><?php xl(' 4 - OT ','e');?></label>
			<br>
			<hr>
			<strong><?php xl('<u>(M0090)</u> Date Assessment Completed: ','e');?></strong>
			<input type='text' size='10' name='oasis_patient_date_assessment_completed' id='oasis_patient_date_assessment_completed' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
				<label><input id="m0100" type="radio" name="oasis_patient_follow_up" value="1" checked><?php xl(' 1 - Start of care-further visits planned','e');?></label><br>
				<label><input type="radio" name="oasis_patient_follow_up" value="3"><?php xl(' 3 - Resumption of care (after inpatient stay)','e');?></label>
		</td>
		<td>
			<?php xl('<b><u>(M0102)</u> Date of Physician-ordered Start of Care (Resumption of Care):</b> If the physician indicated a specific start of care (resumption of care) date when the patient was referred for home health services, record the date specified. <b><i>(Go to M0110, if date entered)</i></b>','e');?>
			<input type='text' size='10' name='oasis_patient_date_ordered_soc' id='oasis_patient_date_ordered_soc' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4z' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_date_ordered_soc", ifFormat:"%Y-%m-%d", button:"img_curr_date4z"});
					</script>
			<br>
			<label><input type="checkbox" name="oasis_patient_date_ordered_soc_na" value="NA"><?php xl('NA - No specific SOC date ordered by physician','e');?></label><br>
			<hr>
			<?php xl('<b><u>(M0104)</u> Date of Referral:</b> Indicate the date that the written or verbal referral for initiation or resumption of care was received by the HHA.','e');?>
			<input type='text' size='10' name='oasis_patient_date_of_referral' id='oasis_patient_date_of_referral' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'readonly /> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4a' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_date_of_referral", ifFormat:"%Y-%m-%d", button:"img_curr_date4a"});
					</script>
			<br>
			<hr>
			<?php xl('<b><u>(M0110)</u> Episode Timing:</b> Is the Medicare home health payment episode for which this assessment will define a case mix group an "early" episode or a "later" episode in the patient"s current sequence of adjacent Medicare home health payment episodes? ','e');?></strong><br>
				<label><input type="radio" id="m0110" name="oasis_patient_episode_timing" value="1" checked><?php xl(' 1 - Early','e');?></label><br>
				<label><input type="radio" name="oasis_patient_episode_timing" value="2"><?php xl(' 2 - Later','e');?></label><br>
				<label><input type="radio" name="oasis_patient_episode_timing" value="UK"><?php xl(' UK - Unknown','e');?></label><br>
				<label><input type="radio" name="oasis_patient_episode_timing" value="NA"><?php xl(' NA - Not Applicable: No Medicare case mix group to be defined by this assessment.','e');?></label>
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
			<?php xl('<b><u>(M1000)</u></b> From which of the following <b>Inpatient Facilities</b> was the patient discharged <u>during the past 14 days? </u><b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="1"><?php xl(' 1 - Long-term nursing facility (NF)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="2"><?php xl(' 2 - Skilled nursing facility (SNF / TCU)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="3"><?php xl(' 3 - Short-stay acute hospital (IPP S)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="4"><?php xl(' 4 - Long-term care hospital (LTCH)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="5"><?php xl(' 5 - Inpatient rehabilitation hospital or unit (IRF)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="6"><?php xl(' 6 - Psychiatric hospital or unit','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="7"><?php xl(' 7 - Other (specify)','e')?></label>
				<input type='text' name='oasis_patient_history_impatient_facility_other' value=""/><br>
			<label><input type="checkbox" name="oasis_patient_history_impatient_facility[]" value="NA"><?php xl(' NA - Patient was not discharged from an inpatient facility <b><i>[Go to M1016 ]</i></b>','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1005)</u> Inpatient Discharge Date</b> (most recent):','e');?><br>
			<input type='text' size='10' name='oasis_patient_history_discharge_date' id='oasis_patient_history_discharge_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'readonly /> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4b' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_discharge_date", ifFormat:"%Y-%m-%d", button:"img_curr_date4b"});
					</script><br>
			<label><input type="checkbox" name="oasis_patient_history_discharge_date_na" value="UK"><?php xl('UK - Unknown','e');?></label><br>
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
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis1" value="" /> 
							<br>
						<?php xl('b.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis2" value="" />
							<br>
						<?php xl('c.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis3" value="" />
							<br>
						<?php xl('d.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis4" value="" />
							<br>
						<?php xl('e.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis5" value="" />
							<br>
						<?php xl('f.','e'); ?>&nbsp;&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_if_diagnosis[]" id="oasis_patient_history_if_diagnosis6" value="" />
					</td>
					<td align="center">
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code1" name="oasis_patient_history_if_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code2" name="oasis_patient_history_if_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code3" name="oasis_patient_history_if_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code4" name="oasis_patient_history_if_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code5" name="oasis_patient_history_if_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_if_code6" name="oasis_patient_history_if_code[]" onKeyDown="fonChange(this,2,'noev')" value="" >
						
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
							<input type="text" style="width:80%" name="oasis_patient_history_ip_diagnosis[]" id="oasis_patient_history_ip_diagnosis1" value="" /> 
							<br>
						<?php xl('b.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_ip_diagnosis[]" id="oasis_patient_history_ip_diagnosis2" value="" />
							<br>
						<?php xl('c.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_ip_diagnosis[]" id="oasis_patient_history_ip_diagnosis3" value="" />
							<br>
						<?php xl('d.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_ip_diagnosis[]" id="oasis_patient_history_ip_diagnosis4" value="" />
							<br>
					</td>
					<td align="center">
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code1" name="oasis_patient_history_ip_code[]" onKeyDown="fonChange(this,1,'no')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code2" name="oasis_patient_history_ip_code[]" onKeyDown="fonChange(this,1,'no')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code3" name="oasis_patient_history_ip_code[]" onKeyDown="fonChange(this,1,'no')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_ip_code4" name="oasis_patient_history_ip_code[]" onKeyDown="fonChange(this,1,'no')" value="" ><br>
					</td>
				</tr>
			</table>
			<label><input type="checkbox" name="oasis_patient_history_ip_diagnosis_na" value="NA"><?php xl(' NA - Not applicable','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_ip_diagnosis_uk" value="UK"><?php xl(' UK - Unknown','e')?></label><br>
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
							<input type="text" id="m1016" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis1" value="" />
							<br>
						<?php xl('b.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis2" value="" />
							<br>
						<?php xl('c.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis3" value="" />
							<br>
						<?php xl('d.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis4" value="" />
							<br>
						<?php xl('e.','e'); ?>&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis5" value="" />
							<br>
						<?php xl('f.','e'); ?>&nbsp;&nbsp;
							<input type="text" style="width:80%" name="oasis_patient_history_mrd_diagnosis[]" id="oasis_patient_history_mrd_diagnosis6" value="" />
							<br>
					</td>
					<td align="center">
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code1" name="oasis_patient_history_mrd_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code2" name="oasis_patient_history_mrd_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code3" name="oasis_patient_history_mrd_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code4" name="oasis_patient_history_mrd_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code5" name="oasis_patient_history_mrd_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
						&nbsp;<input type="text" style="width:40%" class="autosearch" id="oasis_patient_history_mrd_code6" name="oasis_patient_history_mrd_code[]" onKeyDown="fonChange(this,2,'noev')" value="" ><br>
					</td>
				</tr>
			</table>
			<label><input type="checkbox" name="oasis_patient_history_mrd_diagnosis_na" value="NA"><?php xl(' NA - Not applicable (no medical or treatment regimen changes within the past 14 days)','e')?></label><br>
			
			
			<br>
			<hr>
			<?php xl('<b><u>(M1018)</u> Conditions Prior to Medical or Treatment Regimen Change or Inpatient Stay Within Past 14 Days:</b> <br>If this patient experienced an inpatient facility discharge or change in medical or treatment regimen within the past 14 days, indicate any conditions which existed <u>prior to</u> the inpatient stay or change in medical or treatment regimen. <b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="1"><?php xl(' 1 - Urinary incontinence','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="2"><?php xl(' 2 - Indwelling/suprapubic catheter','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="3"><?php xl(' 3 - Intractable pain','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="4"><?php xl(' 4 - Impaired decision-making','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="5"><?php xl(' 5 - Disruptive or socially inappropriate behavior','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="6"><?php xl(' 6 - Memory loss to the extent that supervision required','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="7"><?php xl(' 7 - None of the above','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="NA"><?php xl(' NA - No inpatient facility discharge <u>and</u> no change in medical or treatment regimen in past 14 days','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_regimen_change[]" value="UK"><?php xl(' UK - Unknown','e')?></label><br>
			
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
						<strong><?php xl('(V-codes are allowed) | Indicators (O-Onset / E-Exacerbation)','e');?></strong>
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
						<input type="text" name="oasis_therapy_patient_diagnosis_1a" value="">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2a" size="15" class="autosearch" class="autosearch" id="oasis_therapy_patient_diagnosis_2a" value="" onkeydown="fonChange(this,2,'noe')">
						<select name="oasis_therapy_patient_diagnosis_2a_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2a_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3a" class="autosearch" id="oasis_therapy_patient_diagnosis_3a" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4a" class="autosearch" id="oasis_therapy_patient_diagnosis_4a" value="" onKeyDown="fonChange(this,2,'noev')">
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
						<input type="text" name="oasis_therapy_patient_diagnosis_1b" value="">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2b" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2b" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2b_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2b_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3b" class="autosearch" id="oasis_therapy_patient_diagnosis_3b" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4b" class="autosearch" id="oasis_therapy_patient_diagnosis_4b" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1c" value="">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2c" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2c" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2c_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2c_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3c" class="autosearch" id="oasis_therapy_patient_diagnosis_3c" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4c" class="autosearch" id="oasis_therapy_patient_diagnosis_4c" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1d" value="">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2d" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2d" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2d_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2d_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3d" class="autosearch" id="oasis_therapy_patient_diagnosis_3d" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4d" class="autosearch" id="oasis_therapy_patient_diagnosis_4d" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1e" value="">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2e" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2e" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2e_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2e_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3e" class="autosearch" id="oasis_therapy_patient_diagnosis_3e" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4e" class="autosearch" id="oasis_therapy_patient_diagnosis_4e" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1f" value="">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2f" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2f" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2f_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2f_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3f" class="autosearch" id="oasis_therapy_patient_diagnosis_3f" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4f" class="autosearch" id="oasis_therapy_patient_diagnosis_4f" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1g" value="">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2g" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2g" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2g_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2g_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3g" class="autosearch" id="oasis_therapy_patient_diagnosis_3g" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4g" class="autosearch" id="oasis_therapy_patient_diagnosis_4g" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1h" value="">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2h" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2h" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2h_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2h_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3h" class="autosearch" id="oasis_therapy_patient_diagnosis_3h" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4h" class="autosearch" id="oasis_therapy_patient_diagnosis_4h" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1i" value="">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2i" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2i" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2i_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2i_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3i" class="autosearch" id="oasis_therapy_patient_diagnosis_3i" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4i" class="autosearch" id="oasis_therapy_patient_diagnosis_4i" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1j" value="">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2j" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2j" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2j_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2j_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3j" class="autosearch" id="oasis_therapy_patient_diagnosis_3j" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4j" class="autosearch" id="oasis_therapy_patient_diagnosis_4j" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1k" value="">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2k" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2k" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2k_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2k_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3k" class="autosearch" id="oasis_therapy_patient_diagnosis_3k" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4k" class="autosearch" id="oasis_therapy_patient_diagnosis_4k" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1l" value="">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2l" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2l" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2l_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2l_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3l" class="autosearch" id="oasis_therapy_patient_diagnosis_3l" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4l" class="autosearch" id="oasis_therapy_patient_diagnosis_4l" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_1m" value="">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_2m" size="15" class="autosearch" id="oasis_therapy_patient_diagnosis_2m" value="" onKeyDown="fonChange(this,2,'all')">
						<select name="oasis_therapy_patient_diagnosis_2m_indicator">
						<option value=""></option>
						<option value="O"><?php xl('O','e');?></option>
						<option value="E"><?php xl('E','e');?></option>
						</select><br>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_therapy_patient_diagnosis_2m_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_3m" class="autosearch" id="oasis_therapy_patient_diagnosis_3m" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_therapy_patient_diagnosis_4m" class="autosearch" id="oasis_therapy_patient_diagnosis_4m" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<b><?php xl('Surgical Procedure ( V codes are allowed )','e');?></b><br>
			<?php xl('a. ','e');?>
			<input type="text" name="oasis_therapy_surgical_procedure_a" value="">
			<input type='text' size='10' name='oasis_therapy_surgical_procedure_a_date' id='oasis_therapy_surgical_procedure_a_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date6' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_surgical_procedure_a_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6"});
					</script><br>
			<?php xl('b. ','e');?>
			<input type="text" name="oasis_therapy_surgical_procedure_b" value="">
			<input type='text' size='10' name='oasis_therapy_surgical_procedure_b_date' id='oasis_therapy_surgical_procedure_b_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date6c' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_last_contact_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6c"});
					</script><br>
					
			<b><?php xl('PHYSICIAN DATE LAST VISITED:','e');?></b>
				<input type='text' size='10' name='oasis_patient_history_last_visit_date' id='oasis_patient_history_last_visit_date' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date6d' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_last_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6d"});
					</script><br>
					
			<b><?php xl('PRIMARY REASON FOR HOME HEALTH:','e');?></b>
				<input type="text" name="oasis_patient_history_reason_home_health" value="">
			<br>
			<label><input type="checkbox" name="oasis_patient_history_reason" value="To treat"><?php xl('To treat patient illness or injury due to the inherent complexity of the service and the condition of the patient.','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_reason" value="Other"><?php xl('Other:','e')?></label><br>
				<textarea name="oasis_patient_history_reason_other" rows="3" style="width:100%;"></textarea>
				
			<br><br>
			<?php xl('<b><u>(M1030)</u> Therapies</b> the patient receives <u>at home</u>: <b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_therapies[]" value="1"><?php xl(' 1 - Intravenous or infusion therapy (excludes TPN)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_therapies[]" value="2"><?php xl(' 2 - Parenteral nutrition (TPN or lipids)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_therapies[]" value="3"><?php xl(' 3 - Enteral nutrition (nasogastric, gastrostomy, jejunostomy, or any other artificial entry into the alimentary canal)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_therapies[]" value="4"><?php xl(' 4 - None of the above','e')?></label><br>
			
			<br>
			<center><strong><?php xl('PROGNOSIS','e')?></strong></center><br>
			<b><?php xl('Prognosis:','e')?></b>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="1"><?php xl(' 1-Poor ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="2"><?php xl(' 2-Guarded ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="3"><?php xl(' 3-Fair ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="4"><?php xl(' 4-Good ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pragnosis" value="5"><?php xl(' 5-Excellent ','e')?></label><br>
			
			<br>
			<center><strong><?php xl('ADVANCE DIRECTIVES','e')?></strong></center>
			<table class="formtable" border="0px" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Do not resuscitate"><?php xl('Do not resuscitate','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Copies on file"><?php xl('Copies on file','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Living Will"><?php xl('Living Will','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Organ Donor"><?php xl('Organ Donor','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Funeral arrangements made"><?php xl('Funeral arrangements made','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Education needed"><?php xl('Education needed','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_advance_directives[]" value="Durable Power of Attorney"><?php xl('Durable Power of Attorney (DPOA)','e')?></label><br>
					</td>
				</tr>
			</table>
			
			<br>
			<b><?php xl('Patient/Family informed:','e')?></b>
				<label><input type="radio" name="oasis_patient_history_family_informed" value="Yes"><?php xl(' Yes ','e')?></label>
				<label><input type="radio" name="oasis_patient_history_family_informed" value="No"><?php xl(' No ','e')?></label><br>
			<b><?php xl('(If No, please explain.)','e')?></b>
				<textarea name="oasis_patient_history_family_informed_no" rows="3" style="width:100%;"></textarea>
				
			<br><br>
			<hr>
			<?php xl('<b><u>(M1032)</u> Risk for Hospitalization:</b> Which of the following signs or symptoms characterize this patient as at risk for hospitalization? <b>(Mark all that apply.)</b>','e');?></strong><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="1"><?php xl(' 1 - Recent decline in mental, emotional, or behavioral status','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="2"><?php xl(' 2 - Multiple hospitalizations (2 or more) in the past 12 months','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="3"><?php xl(' 3 - History of falls (2 or more falls - or any fall with an injury - in the past year)','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="4"><?php xl(' 4 - Taking five or more medications','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="5"><?php xl(' 5 - Frailty indicators, e.g., weight loss, self-reported exhaustion','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="6"><?php xl(' 6 - Other','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_hospitalization[]" value="7"><?php xl(' 7 - None of the above','e')?></label><br>
			
		</td>
		<td valign="top">
			<strong><?php xl('PERTINENT HISTORY AND/OR PREVIOUS OUTCOMES (note dates of onset, exacerbation when known)','e');?></strong><br>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Hypertension"><?php xl(' Hypertension','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Respiratory"><?php xl(' Respiratory','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Cancer"><?php xl(' Cancer','e')?></label><br>
							<?php xl('(site:','e');?>
							<input type="text" name="oasis_patient_history_previous_outcome_cancer" size="5" value="">
							<?php xl(')','e');?><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Open Wound"><?php xl(' Open Wound','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Cardiac"><?php xl(' Cardiac','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Osteoporosis"><?php xl(' Osteoporosis','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Infection"><?php xl(' Infection','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Surgeries"><?php xl(' Surgeries','e')?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Diabetes"><?php xl(' Diabetes','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Fractures"><?php xl(' Fractures','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Immunosuppressed"><?php xl(' Immunosuppressed','e')?></label><br>
						<label><input type="checkbox" name="oasis_patient_history_previous_outcome[]" value="Other"><?php xl(' Other','e')?></label>
							<?php xl('(specify)','e');?><br>
							<input type="text" name="oasis_patient_history_previous_outcome_other" value="">
						
					</td>
				</tr>
			</table>
			
			<br>
			<hr>
			<strong><?php xl('PRIOR HOSPITALIZATIONS','e');?></strong><br>
				<label><input type="radio" name="oasis_patient_history_prior_hospitalization" value="No"><?php xl(' No ','e')?></label>
				<label><input type="radio" name="oasis_patient_history_prior_hospitalization" value="Yes"><?php xl(' Yes ','e')?></label>&nbsp;&nbsp;&nbsp;
			<?php xl('Number of times','e');?>
			<input type="text" name="oasis_patient_history_prior_hospitalization_no" value=""><br>
			<?php xl('Reason(s)/Date(s):','e');?><br>
				<input type="text" name="oasis_patient_history_prior_hospitalization_reason[]" size="40" value="">
				<input type='text' size='10' name='oasis_patient_history_prior_hospitalization_reason[]' id='oasis_patient_history_prior_hospitalization_reason1' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date10a' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_patient_history_prior_hospitalization_reason1", ifFormat:"%Y-%m-%d", button:"img_curr_date10a"});
					</script><br>
				<input type="text" name="oasis_patient_history_prior_hospitalization_reason[]" size="40" value="">
				<input type='text' size='10' name='oasis_patient_history_prior_hospitalization_reason[]' id='oasis_patient_history_prior_hospitalization_reason2' 
					title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
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
				<label><input type="checkbox" name="oasis_patient_history_immunizations" value="Up to date"><?php xl('Up to date','e')?></label><br>
			<?php xl('<b>Needs:</b>','e');?>
				<label><input type="checkbox" name="oasis_patient_history_immunizations_needs[]" value="Influenza"><?php xl('Influenza','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_immunizations_needs[]" value="Pneumonia"><?php xl('Pneumonia','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_immunizations_needs[]" value="Tetanus"><?php xl('Tetanus','e')?></label><br>
				<label><input type="checkbox" name="oasis_patient_history_immunizations_needs[]" value="Other"><?php xl('Other','e')?></label>
					<input type="text" name="oasis_patient_history_immunizations_needs_other" value=""><br>
					
			<br>
			<center><strong><?php xl('ALLERGIES','e');?></strong></center>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="NKDA"><?php xl(' NKDA','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Penicillin"><?php xl(' Penicillin','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Sulfa"><?php xl(' Sulfa','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Aspirin"><?php xl(' Aspirin','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Milk Products"><?php xl(' Milk Products','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Pollen"><?php xl(' Pollen','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Insect Bites"><?php xl(' Insect Bites','e')?></label>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Eggs"><?php xl(' Eggs','e')?></label><br>
				<label><input type="checkbox" name="oasis_patient_history_allergies[]" value="Other"><?php xl(' Other:','e')?></label>
					<input type="text" name="oasis_patient_history_allergies_other" value=""><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1034)</u> Overall Status:</b> Which description best fits the patient\'s overall status? <b>(Check one)</b>','e');?><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="0" checked><?php xl(' 0 - The patient is stable with no heightened risk(s) for serious complications and death (beyond those typical of the patient\'s age). ','e')?></label><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="1"><?php xl(' 1 - The patient is temporarily facing high health risk(s) but is likely to return to being stable without heightened risk(s) for serious complications and death (beyond those typical of the patient\'s age). ','e')?></label><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="2"><?php xl(' 2 - The patient is likely to remain in fragile health and have ongoing high risk(s) of serious complications and death. ','e')?></label><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="3"><?php xl(' 3 - The patient has serious progressive conditions that could lead to death within a year. ','e')?></label><br>
			<label><input type="radio" name="oasis_patient_history_overall_status" value="UK"><?php xl(' UK - The patient\'s situation is unknown or unclear. ','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1036)</u> Risk Factors,</b> either present or past, likely to affect current health status and/or outcome: <b>(Mark all that apply.)</b>','e');?><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="1"><?php xl(' 1 - Smoking','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="2"><?php xl(' 2 - Obesity','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="3"><?php xl(' 3 - Alcohol dependency','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="4"><?php xl(' 4 - Drug dependency','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="5"><?php xl(' 5 - None of the above','e')?></label><br>
			<label><input type="checkbox" name="oasis_patient_history_risk_factors[]" value="UK"><?php xl(' UK - Unknown','e')?></label><br>
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
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="911 Protocol"><?php xl('911 Protocol','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Clear Pathways"><?php xl('Clear Pathways','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Siderails up"><?php xl('Siderails up','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Safe Transfers"><?php xl('Safe Transfers','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Equipment Safety"><?php xl('Equipment Safety','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Infection Control Measures"><?php xl('Infection Control Measures','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Bleeding Precautions"><?php xl('Bleeding Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Fall Precautions"><?php xl('Fall Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Seizure Precautions"><?php xl('Seizure Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Universal Precautions"><?php xl('Universal Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Other"><?php xl('Other:','e')?></label>
							<input type="text" name="oasis_therapy_safety_measures_other" value=""><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Hazard-Free Environment"><?php xl('Hazard-Free Environment','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Lock W/C with transfers"><?php xl('Lock W/C with transfers','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Elevate Head of Bed"><?php xl('Elevate Head of Bed','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Medication Safety/Storage"><?php xl('Medication Safety/Storage','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Hazardous Waste Disposal"><?php xl('Hazardous Waste Disposal','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="24 hr. supervision"><?php xl('24 hr. supervision','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Neutropenic"><?php xl('Neutropenic','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="O2 Precautions"><?php xl('O2 Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Aspiration Precautions"><?php xl('Aspiration Precautions','e')?></label><br>
						<label><input type="checkbox" name="oasis_therapy_safety_measures[]" value="Walker/Cane"><?php xl('Walker/Cane','e')?></label><br>
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
						<label><input type="radio" name="oasis_living_arrangements_situation" value="01">01</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="02">02</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="03">03</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="04">04</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="05">05</label>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						b.&nbsp;&nbsp;<?php xl("Patient lives with other person(s) in the home","e");?>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="06">06</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="07">07</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="08">08</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="09">09</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="10">10</label>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						c.&nbsp;&nbsp;<?php xl("Patient lives in congregate situation (e.g., assisted living)","e");?>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="11">11</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="12">12</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="13">13</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="14">14</label>
					</td>
					<td valign="middle" align="center">
						<label><input type="radio" name="oasis_living_arrangements_situation" value="15">15</label>
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
						<label><input type="radio" name="oasis_safety_emergency_planning1" value="Y">Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning1" value="N">N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Smoke detectors on all levels of home","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning2" value="Y">Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning2" value="N">N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Tested and functioning","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning3" value="Y">Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning3" value="N">N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("More than one exit","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning4" value="Y">Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning4" value="N">N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Plan for exit","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning5" value="Y">Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning5" value="N">N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Plan for power failure","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning6" value="Y">Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning6" value="N">N</label>
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
						<label><input type="radio" name="oasis_safety_emergency_planning7" value="Y">Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning7" value="N">N</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Handles smoking / flammables safely","e");?>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning8" value="Y">Y</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_safety_emergency_planning8" value="N">N</label>
					</td>
				</tr>
			</table>
			<strong><?php xl("Oxygen back-up:","e");?></strong>
			<label><input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Available"><?php xl('Available','e')?></label>
			<label><input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Knows how to use"><?php xl('Knows how to use','e')?></label>
			<label><input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Electrical / fire safety"><?php xl('Electrical / fire safety','e')?></label><br>
			
			<br>
			<strong><?php xl("SAFETY HAZARDS found in the patient's current place of residence: (Mark all that apply.)","e");?></strong>
			<table class="formtable" width="100%">
				<tr>
					<td valign="top">
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="None"><?php xl('None','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate floor, roof, or windows"><?php xl('Inadequate floor, roof, or windows','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate lighting"><?php xl('Inadequate lighting','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="No telephone available and / or unable to use phone"><?php xl('No telephone available and / or unable to use phone','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe gas/electrical appliances/outlets"><?php xl('Unsafe gas/electrical appliances/outlets','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate heating/cooling/electricity"><?php xl('Inadequate heating/cooling/electricity','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate sanitation/plumbing"><?php xl('Inadequate sanitation/plumbing','e')?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsound structure"><?php xl('Unsound structure','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe placement of rugs/cords furniture"><?php xl('Unsafe placement of rugs/cords furniture','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe functional barriers (i.e., stairs)"><?php xl('Unsafe functional barriers (i.e., stairs)','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe storage of supplies / equipment"><?php xl('Unsafe storage of supplies / equipment','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Improperly stored hazardous materials"><?php xl('Improperly stored hazardous materials','e')?></label><br>
						<label><input type="checkbox" name="oasis_safety_hazards[]" value="Other"><?php xl('Other (specify)','e')?></label>
							<input type="text" name="oasis_safety_hazards_other" value=""><br>
					</td>
				</tr>
			</table>
			<br>
			<center><strong><?php xl("SANITATION HAZARDS","e");?></strong></center>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="None"><?php xl('None','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate/improper food storage"><?php xl('Inadequate/improper food storage','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate cooking refrigeration"><?php xl('Inadequate cooking refrigeration','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate running water"><?php xl('Inadequate running water','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Cluttered/soiled living room"><?php xl('Cluttered/soiled living room','e')?></label><br>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate toileting facility"><?php xl('Inadequate toileting facility','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate sewage"><?php xl('Inadequate sewage','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="No scheduled trash removal"><?php xl('No scheduled trash removal','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Insects/rodents present"><?php xl('Insects/rodents present','e')?></label><br>
						<label><input type="checkbox" name="oasis_sanitation_hazards[]" value="Other"><?php xl('Other','e')?></label>
							<input type="text" name="oasis_sanitation_hazards_other" value=""><br>
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
			<input type="text" name="oasis_primary_caregiver_name" value=""><br>
			<strong><?php xl("Relationship:","e");?></strong>
			<input type="text" name="oasis_primary_caregiver_relationship" value=""><br>
			<strong><?php xl("Phone Number (if different from patient) - ","e");?></strong>
			<input type="text" name="oasis_primary_caregiver_phone" value=""><br>
		</td>
		<td>
			<strong><?php xl("Language spoken:","e");?></strong>
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="English"><?php xl('English','e')?></label>
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="Spanish"><?php xl('Spanish','e')?></label>
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="Russian"><?php xl('Russian','e')?></label>
			<label><input type="checkbox" name="oasis_primary_caregiver_language[]" value="Other"><?php xl('Other','e')?></label>
				<input type="text" name="oasis_primary_caregiver_language_other" value=""><br>
			<strong><?php xl("Comments:","e");?></strong><br>
			<textarea name="oasis_primary_caregiver_comments" rows="3" style="width:100%;"></textarea><br>
			<strong><?php xl("Able to safely care for patient","e");?></strong>
			<label><input type="radio" name="oasis_primary_caregiver_able_care" value="Yes">Yes</label>
			<label><input type="radio" name="oasis_primary_caregiver_able_care" value="No">No</label><br>
			<strong><?php xl("If No, reason:","e");?></strong>
			<input type="text" name="oasis_primary_caregiver_no_reason" value="">
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
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Amputation"><?php xl('Amputation','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Hearing"><?php xl('Hearing','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Ambulation"><?php xl('Ambulation','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Dyspnea with Minimal Exertion"><?php xl('Dyspnea with Minimal Exertion','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Bowel/Bladder (Incontinence)"><?php xl('Bowel/Bladder <br>(Incontinence)','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Paralysis"><?php xl('Paralysis','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Speech"><?php xl('Speech','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Contracture"><?php xl('Contracture','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Endurance"><?php xl('Endurance','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Legally Blind"><?php xl('Legally Blind','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Other"><?php xl('Other (specify):','e')?></label>
							<input type="text" name="oasis_functional_limitations_other" value="">
					</td>
				</tr>
			</table>
			<br>
			<center><strong><?php xl("SENSORY STATUS","e");?></strong></center>
			<center><strong><?php xl("VISION","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_vision_no" value="No"><?php xl('No Problem','e')?></label>
			</center>
			<?php xl('<b><u>(M1200)</u> Vision </b>(with corrective lenses if the patient usually wears them):','e');?><br>
			<label><input type="radio" name="oasis_sensory_status_vision" value="0" checked><?php xl(' 0 - Normal vision: sees adequately in most situations; can see medication labels, newsprint. ','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_vision" value="1"><?php xl(' 1 - Partially impaired: cannot see medication labels or newsprint, but <u>can</u> see obstacles in path, and the surrounding layout; can count fingers at arm\'s length. ','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_vision" value="2"><?php xl(' 2 - Severely impaired: cannot locate objects without hearing or touching them or patient nonresponsive. ','e')?></label><br>
			<br>
			<hr>
			<table class="formtable" width="100%">
				<tr>
					<td valign="top">
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Glasses"><?php xl('Glasses','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Contacts"><?php xl('Contacts:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_vision_detail_contact[]" value="R"><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_vision_detail_contact[]" value="L"><?php xl('L','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Prosthesis"><?php xl('Prosthesis:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_vision_detail_prothesis[]" value="R"><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_vision_detail_prothesis[]" value="L"><?php xl('L','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Glaucoma"><?php xl('Glaucoma','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Blurred Vision"><?php xl('Blurred Vision','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Infections"><?php xl('Infections','e')?></label><br>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Jaundice"><?php xl('Jaundice','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Ptosis"><?php xl('Ptosis','e')?></label><br>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<label><input type="checkbox" name="oasis_sensory_status_vision_detail[]" value="Cataract surgery"><?php xl('Cataract surgery:','e')?></label>
						<?php xl("Site","e");?>
						<input type="text" name="oasis_sensory_status_vision_site" value="">
						<?php xl("Date:","e");?>
						<input type='text' size='10' name='oasis_sensory_status_vision_date' id='oasis_sensory_status_vision_date' 
							title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
							<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
							height='22' id='img_curr_date6e' border='0' alt='[?]'
							style='cursor: pointer; cursor: hand'
							title='<?php xl('Click here to choose a date','e'); ?>'> 
							<script	LANGUAGE="JavaScript">
								Calendar.setup({inputField:"oasis_sensory_status_vision_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6e"});
							</script><br>
						<?php xl("Other(specify)","e");?>
						<textarea name="oasis_sensory_status_vision_detail_other" rows="3" style="width:100%;"></textarea><br>
					</td>
				</tr>
			</table>
			
			<br>
			<hr>	
			<center><strong><?php xl("EARS","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_ears_no" value="No"><?php xl('No Problem','e')?></label>
			</center>
			<?php xl('<b><u>(M1210)</u> Ability to hear</b> (with hearing aid or hearing appliance if normally used):','e');?><br>
			<label><input type="radio" name="oasis_sensory_status_hear" value="0" checked><?php xl(' 0 - Adequate: hears normal conversation without difficulty.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_hear" value="1"><?php xl(' 1 - Mildly to Moderately Impaired: difficulty hearing in some environments or speaker may need to increase volume or speak distinctly.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_hear" value="2"><?php xl(' 2 - Severely Impaired: absence of useful hearing.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_hear" value="UK"><?php xl(' UK - Unable to assess hearing.','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1220)</u> Understanding of Verbal Content</b> in patient\'s own language (with hearing aid or device if used):','e');?><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="0" checked><?php xl(' 0 - Understands: clear comprehension without cues or repetitions.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="1"><?php xl(' 1 - Usually Understands: understands most conversations, but misses some part/intent of message. Requires cues at times to understand.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="2"><?php xl(' 2 - Sometimes Understands: understands only basic conversations or simple, direct phrases. Frequently requires cues to understand.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="3"><?php xl(' 3 - Rarely/Never Understands','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_understand_verbal" value="UK"><?php xl(' UK - Unable to assess understanding.','e')?></label><br>
			
			<br>
			<hr>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="HOH"><?php xl('HOH:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_hoh[]" value="R"><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_hoh[]" value="L"><?php xl('L','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="Vertigo"><?php xl('Vertigo:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_vartigo[]" value="R"><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_vartigo[]" value="L"><?php xl('L','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="Deaf"><?php xl('Deaf:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_deaf[]" value="R"><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_deaf[]" value="L"><?php xl('L','e')?></label><br>
						
					</td>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="Tinnitus"><?php xl('Tinnitus:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_tinnitus[]" value="R"><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_tinnitus[]" value="L"><?php xl('L','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_hear_detail[]" value="Hearing aid"><?php xl('Hearing aid:','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_aid[]" value="R"><?php xl('R','e')?></label>
							<label><input type="checkbox" name="oasis_sensory_status_hear_detail_aid[]" value="L"><?php xl('L','e')?></label><br>
					</td>
				</tr>
			</table>
			<?php xl("Other(specify)","e");?>
			<textarea name="oasis_sensory_status_hear_detail_other" rows="3" style="width:100%;"></textarea><br>
		</td>
		<td valign="top">
			<center><strong><?php xl("MUSCULOSKELETAL","e");?></strong></center>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="No Problem"><?php xl('No Problem','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Fracture (location)"><?php xl('Fracture (location)','e')?></label>
				<input type="text" name="oasis_sensory_status_musculoskeletal_fracture" value=""><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Swollen, painful joints"><?php xl('Swollen, painful joints (specify)','e')?></label>
				<input type="text" name="oasis_sensory_status_musculoskeletal_swollen" value=""><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Contractures"><?php xl('Contractures:','e')?></label>
				<input type="text" name="oasis_sensory_status_musculoskeletal_contractures" value="">
				<?php xl("Joint","e");?>
				<input type="text" name="oasis_sensory_status_musculoskeletal_joint" value=""><br>
				<?php xl("Location","e");?>
				<input type="text" name="oasis_sensory_status_musculoskeletal_location" value=""><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Atrophy"><?php xl('Atrophy','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Poor Conditioning"><?php xl('Poor Conditioning','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Decreased ROM"><?php xl('Decreased ROM','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Paresthesia"><?php xl('Paresthesia','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Shuffling/Wide-based gait"><?php xl('Shuffling/Wide-based gait','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Weakness"><?php xl('Weakness','e')?></label><br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Amputation"><?php xl('Amputation:','e')?></label><br>
				<?php xl("BK/AK/UE; R/L (specify)","e");?>
				<textarea name="oasis_sensory_status_musculoskeletal_amputation" rows="3" style="width:100%;"></textarea><br>
			<br>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Hemiplegia"><?php xl('Hemiplegia','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Paraplegia"><?php xl('Paraplegia','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Quadriplegia"><?php xl('Quadriplegia','e')?></label><br>	
			<label><input type="checkbox" name="oasis_sensory_status_musculoskeletal[]" value="Other"><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_sensory_status_musculoskeletal_other" value=""><br>
				
			<br>
			<center><strong><?php xl("NOSE","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_nose_no" value="No"><?php xl('No Problem','e')?></label>
			</center>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_nose[]" value="Congestion"><?php xl('Congestion','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_nose[]" value="Loss of smell"><?php xl('Loss of smell','e')?></label>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_nose[]" value="Epistaxis"><?php xl('Epistaxis','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_nose[]" value="Sinus problem"><?php xl('Sinus problem','e')?></label>
					</td>
				</tr>
			</table>
			<?php xl("Other(specify)","e");?>
			<textarea name="oasis_sensory_status_nose_other" rows="3" style="width:100%;"></textarea><br>
			
			<br>
			<center><strong><?php xl("MOUTH","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_mouth_no" value="No"><?php xl('No Problem','e')?></label>
			</center>
			<table class="formtable" width="100%">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Dentures"><?php xl('Dentures:','e')?></label>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Upper"><?php xl('Upper','e')?></label>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Lower"><?php xl('Lower','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Partial"><?php xl('Partial','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Gingivitis"><?php xl('Gingivitis','e')?></label>
					</td>
					<td valign="top">
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Masses/Tumors"><?php xl('Masses/Tumors','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Toothache"><?php xl('Toothache','e')?></label><br>
						<label><input type="checkbox" name="oasis_sensory_status_mouth[]" value="Ulcerations"><?php xl('Ulcerations','e')?></label>
					</td>
				</tr>
			</table>
			<?php xl("Other(specify)","e");?>
			<textarea name="oasis_sensory_status_mouth_other" rows="3" style="width:100%;"></textarea><br>
			
			<br>
			<center><strong><?php xl("THROAT","e");?></strong>
			<label><input type="checkbox" name="oasis_sensory_status_throat_no" value="No"><?php xl('No Problem','e')?></label>
			</center>
			<label><input type="checkbox" name="oasis_sensory_status_throat[]" value="Dysphagia"><?php xl('Dysphagia','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_throat[]" value="Hoarseness"><?php xl('Hoarseness','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_throat[]" value="Lesions"><?php xl('Lesions','e')?></label>
			<label><input type="checkbox" name="oasis_sensory_status_throat[]" value="Sore throat"><?php xl('Sore throat','e')?></label><br>
			<?php xl("Other(specify)","e");?>
			<textarea name="oasis_sensory_status_throat_other" rows="3" style="width:100%;"></textarea><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl("SPEECH","e");?></strong></center>
			<strong><?php xl('<u>(M1230)</u> Speech and Oral (Verbal) Expression of Language (in patient\'s own language):','e');?></strong><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="0" checked><?php xl(' 0 - Expresses complex ideas, feelings, and needs clearly, completely, and easily in all situations with no observable impairment.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="1"><?php xl(' 1 - Minimal difficulty in expressing ideas and needs (may take extra time; makes occasional errors in word choice, grammar or speech intelligibility; needs minimal prompting or assistance).','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="2"><?php xl(' 2 - Expresses simple ideas or needs with moderate difficulty (needs prompting or assistance, errors in word choice, organization or speech intelligibility). Speaks in phrases or short sentences.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="3"><?php xl(' 3 - Has severe difficulty expressing basic ideas or needs and requires maximal assistance or guessing by listener. Speech limited to single words or short phrases.','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="4"><?php xl(' 4 - <u>Unable</u> to express basic needs even with maximal prompting or assistance but is not comatose or unresponsive (e.g., speech is nonsensical or unintelligible).','e')?></label><br>
			<label><input type="radio" name="oasis_sensory_status_speech" value="5"><?php xl(' 5 - Patient nonresponsive or unable to speak.','e')?></label><br>
			
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
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Sitting","e");?>
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Standing","e");?>
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_vital_sign_blood_pressure[]" value="">
					</td>
				</tr>
			</table>
			
			<strong><?php xl("Temperature: &deg;F","e");?></strong>
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Oral"><?php xl(' Oral ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Axillary"><?php xl(' Axillary ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Rectal"><?php xl(' Rectal ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Tympanic"><?php xl(' Tympanic ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_temperature" value="Temporal"><?php xl(' Temporal ','e')?></label> 
			
		</td>
		<td>
			<strong><?php xl("Pulse:","e");?></strong><br>
			<label><input type="radio" name="oasis_vital_sign_pulse" value="At Rest"><?php xl(' At Rest ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_pulse" value="Activity"><?php xl(' Activity/Exercise ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_pulse" value="Regular"><?php xl(' Regular ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_pulse" value="Irregular"><?php xl(' Irregular ','e')?></label> 
			<br>
				
			<label><input type="checkbox" name="oasis_vital_sign_pulse_type[]" value="Radial"><?php xl(' Radial ','e')?></label> 
			<label><input type="checkbox" name="oasis_vital_sign_pulse_type[]" value="Carotid"><?php xl(' Carotid ','e')?></label> 
			<label><input type="checkbox" name="oasis_vital_sign_pulse_type[]" value="Apical"><?php xl(' Apical ','e')?></label> 
			<label><input type="checkbox" name="oasis_vital_sign_pulse_type[]" value="Brachial"><?php xl(' Brachial ','e')?></label> 
			<br><br>
			
			<strong><?php xl("Respiratory Rate:","e");?></strong>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_vital_sign_respiratory_rate" value="Normal"><?php xl(' Normal ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_respiratory_rate" value="Cheynes"><?php xl(' Cheynes Stokes ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_respiratory_rate" value="Death"><?php xl(' Death rattle ','e')?></label> 
			<label><input type="radio" name="oasis_vital_sign_respiratory_rate" value="Apnea"><?php xl(' Apnea /sec.','e')?></label> 
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
						<input type="text" name="oasis_hw_height" size="5" value="" >
					</td>
					<td>
						<label><input type="radio" name="oasis_hw_height_detail" value="actual"><?php xl(' actual ','e')?></label> <br>
						<label><input type="radio" name="oasis_hw_height_detail" value="reported"><?php xl(' reported ','e')?></label> 
					</td>
					<td>
						<?php xl("Weight:","e");?>
						<input type="text" name="oasis_hw_weight" size="5" value="" >
					</td>
					<td>
						<label><input type="radio" name="oasis_hw_weight_detail" value="actual"><?php xl(' actual ','e')?></label> <br>
						<label><input type="radio" name="oasis_hw_weight_detail" value="reported"><?php xl(' reported ','e')?></label> 
					</td>
				</tr>
			</table>
		</td>
		<td>
			<?php xl("Any Weight Changes?","e");?>
			<label><input type="radio" name="oasis_hw_weight_change" value="Yes"><?php xl(' Yes ','e')?></label> 
			<label><input type="radio" name="oasis_hw_weight_change" value="No"><?php xl(' No ','e')?></label><br>
			<?php xl("If yes:","e");?>
			<label><input type="radio" name="oasis_hw_weight_yes" value="Gain"><?php xl(' Gain ','e')?></label> 
			<label><input type="radio" name="oasis_hw_weight_yes" value="Loss"><?php xl(' Loss ','e')?></label> 
			<?php xl(" of ","e");?>
			<input type="text" name="oasis_hw_weight_lb" value="" >
			<?php xl(" lb. in ","e");?>
			<label><input type="radio" name="oasis_hw_weight_lb_in" value="wk"><?php xl(' wk./ ','e')?></label>
			<label><input type="radio" name="oasis_hw_weight_lb_in" value="mo"><?php xl(' mo./ ','e')?></label>
			<label><input type="radio" name="oasis_hw_weight_lb_in" value="yr"><?php xl(' yr. ','e')?></label><br>
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
			<?php xl('<b><u>(M1240)</u></b> Has this patient had a formal <b>Pain Assessment</b> using a standardized pain assessment tool (appropriate to the patient\'s ability to communicate the severity of pain)?','e');?></strong><br>
			<label><input type="radio" name="oasis_pain_assessment_tool" value="0" checked><?php xl(' 0 - No standardized assessment conducted','e')?></label><br>
			<label><input type="radio" name="oasis_pain_assessment_tool" value="1"><?php xl(' 1 - Yes, and it does not indicate severe pain','e')?></label><br>
			<label><input type="radio" name="oasis_pain_assessment_tool" value="2"><?php xl(' 2 - Yes, and it indicates severe pain','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1242)</u> Frequency of Pain Interfering</b> with patient\'s activity or movement:','e');?><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="0" checked><?php xl(' 0 - Patient has no pain','e')?></label><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="1"><?php xl(' 1 - Patient has pain that does not interfere with activity or movement','e')?></label><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="2"><?php xl(' 2 - Less often than daily','e')?></label><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="3"><?php xl(' 3 - Daily, but not constantly','e')?></label><br>
			<label><input type="radio" name="oasis_pain_frequency_interfering" value="4"><?php xl(' 4 - All of the time','e')?></label><br>
			
		</td>
		<td>
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
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_1" value="0"><?php xl(' 0-No Pain ','e')?></label>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_2" value="2"><?php xl(' 2-Little Pain ','e')?></label>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_4" value="4"><?php xl(' 4-Little More Pain ','e')?></label><br>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_6" value="6"><?php xl(' 6-Even More Pain ','e')?></label>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_8" value="8"><?php xl(' 8-Lots of Pain ','e')?></label>
						<label><input type="radio" name="oasis_therapy_pain_scale" id="painscale_10" value="10"><?php xl(' 10-Worst Pain ','e')?></label>
					</td>
				</tr>
			</table>
			<br>
			
			<strong><u><?php xl('Location:','e')?></u>
			<input type="text" name="oasis_therapy_pain_location" value="">
			<?php xl('Cause:','e')?></strong>
			<input type="text" name="oasis_therapy_pain_location_cause" value=""><br>
			
			<strong><u><?php xl('Description:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("sharp","e");?>"><?php xl('sharp','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("dull","e");?>"><?php xl('dull','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("cramping","e");?>"><?php xl('cramping','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("aching","e");?>"><?php xl('aching','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("burning","e");?>"><?php xl('burning','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("tingling","e");?>"><?php xl('tingling','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("throbbing","e");?>"><?php xl('throbbing','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("shooting","e");?>"><?php xl('shooting','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_description" value="<?php xl("pinching","e");?>"><?php xl('pinching','e')?></label><br>
			
			<strong><u><?php xl('Frequency:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("occasional","e");?>"><?php xl('occasional','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("intermittent","e");?>"><?php xl('intermittent','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("continuous","e");?>"><?php xl('continuous','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("at rest","e");?>"><?php xl('at rest','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_frequency" value="<?php xl("at night","e");?>"><?php xl('at night','e')?></label><br>
			
			<strong><u><?php xl('Aggravating factors:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pain_aggravating_factors" value="<?php xl("movement","e");?>"><?php xl('movement','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_aggravating_factors" value="<?php xl("time of day","e");?>"><?php xl('time of day','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_aggravating_factors" value="<?php xl("posture","e");?>"><?php xl('posture','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_aggravating_factors" value="<?php xl("other","e");?>"><?php xl('other','e')?></label>
			<input type="text" name="oasis_therapy_pain_aggravating_factors_other" value=""><br>
			
			<strong><u><?php xl('Relieving factors:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("medication","e");?>"><?php xl('medication','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("rest","e");?>"><?php xl('rest','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("heat","e");?>"><?php xl('heat','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("ice","e");?>"><?php xl('ice','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("massage","e");?>"><?php xl('massage','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("repositioning","e");?>"><?php xl('repositioning','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("diversion","e");?>"><?php xl('diversion','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_pain_relieving_factors[]" value="<?php xl("other","e");?>"><?php xl('other','e')?></label>
			<input type="text" name="oasis_therapy_pain_relieving_factors_other" value=""><br>
			
			<strong><u><?php xl('Activities limited:','e')?></u></strong><br>
			<textarea name="oasis_therapy_pain_activities_limited" rows="3" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<b><?php xl('Is patient experiencing pain?','e')?></b>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_experiencing_pain" value="Yes"><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_experiencing_pain" value="No"><?php xl(' No ','e')?></label><br>
			
			<label><input type="checkbox" name="oasis_therapy_unable_to_communicate" value="Yes"><?php xl('Unable to communicate','e')?></label><br>
			
			<b><?php xl('Non-verbals demonstrated: ','e')?></b>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Diaphoresis","e");?>"><?php xl('Diaphoresis','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Grimacing","e");?>"><?php xl('Grimacing','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Moaning/Crying","e");?>"><?php xl('Moaning/Crying','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Guarding","e");?>"><?php xl('Guarding','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Irritability","e");?>"><?php xl('Irritability','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Anger","e");?>"><?php xl('Anger','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Tense","e");?>"><?php xl('Tense','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Restlessness","e");?>"><?php xl('Restlessness','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Change in vital signs","e");?>"><?php xl('Change in vital signs','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Other","e");?>"><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_therapy_non_verbal_demonstrated_other" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Self-assessment","e");?>"><?php xl('Self-assessment','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_non_verbal_demonstrated[]" value="<?php xl("Implications","e");?>"><?php xl('Implications:','e')?></label>
			<input type="text" name="oasis_therapy_non_verbal_demonstrated_implications" value="">
		</td>
		<td valign="top">
			<b><?php xl('How often is breakthrough medication needed? ','e')?></b><br>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Never","e");?>"><?php xl('Never','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Less than daily","e");?>"><?php xl('Less than daily','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("2-3 times/day","e");?>"><?php xl('2-3 times/day','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("More than 3 times/day","e");?>"><?php xl('More than 3 times/day','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("Current adequate","e");?>"><?php xl('Current pain control medications adequate','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breakthrough_medication" value="<?php xl("other","e");?>"><?php xl('other:','e')?></label>
			<input type="text" name="oasis_therapy_breakthrough_medication_other" value=""><br>
			
			<b><?php xl('Implications Care Plan:','e')?></b>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_implications_care_plan" value="Yes"><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_implications_care_plan" value="No"><?php xl(' No ','e')?></label><br>
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
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Age 65+"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Diagnosis (3 or more co-existing) :</b> Assess for hypotension","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Diagnosis"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Prior History of fall within 3 months :</b> Fall Definition, 'An unintentional change in position resulting in coming to rest on the ground at a lower level.'","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Prior History of fall within 3 months"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Incontinence :</b> Inability to make it to the bathroom or commode in timely manner. Includes frequency, urgency, and/or nocturia","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Incontinence"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Visual impairment :</b> Includes macular degeneration, diabetic retinopathies, visual field loss, age related changes, decline in visual acuity, accommodation, glare tolerance, depth perception, and night vision or not wearing prescribed glasses or having the correct prescription.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Visual impairment"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Impaired functional mobility :</b> May include patients who need help with IADLS or ADLS or have gait or transfer problems, arthritis, pain, fear of falling, foot problems, impaired sensation, impaired coordination or improper use of assistive devices.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Impaired functional mobility"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Environmental hazards :</b> May include poor illumination, equipment tubing, inappropriate footwear, pets, hard to reach items, floor surfaces that are uneven or cluttered, or outdoor entry and exits.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Environmental hazards"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Poly Pharmacy (4 or more prescriptions) :</b> Drugs highly associated with fall risk include but not limited to, sedatives, anti-depressants, tranquilizers, narcotics, antihypertensives, cardiac meds, corticosteroids, anti-anxiety drugs, anticholinergic drugs, and hypoglycemic drugs.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Poly Pharmacy"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Pain affecting level of function :</b> Pain often affects an individual's desire or ability to move or pain can be a factor in depression or compliance with safety recommendations.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Pain affecting level of function"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Cognitive impairment :</b> Could include patients with dementia, Alzheimer's or stroke patients or patients who are confused, use poor judgment, have decreased comprehension, impulsivity, memory deficits. Consider patients ability to adhere to the plan of care.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_therapy_fall_risk_assessment[]" onChange="sumfallrisk(this);" value="Cognitive impairment"></label>
					</td>
				</tr>
				<tr>
					<td align="right">
						<b><?php xl("A score of 4 or more is considered at risk for falling  &nbsp;&nbsp;&nbsp;&nbsp;Total","e");?></b>
					</td>
					<td>
						<input type="text" name="oasis_therapy_fall_risk_assessment_total" id="oasis_therapy_fall_risk_assessment_total" value="0" readonly></label>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<?php xl('<b><u>(M1300)</u> Pressure Ulcer Assessment:</b> Was this patient assessed for <b>Risk of Developing Pressure Ulcers?</b>','e');?><br>
			<label><input type="radio" name="oasis_pressure_ulcer_assessment" value="0" checked><?php xl(' 0 - No assessment conducted <b><i>[ Go to M1306 ]</i></b>','e')?></label><br>
			<label><input type="radio" name="oasis_pressure_ulcer_assessment" value="1"><?php xl(' 1 - Yes, based on an evaluation of clinical factors, e.g., mobility, incontinence, nutrition, etc., without use of standardized tool','e')?></label><br>
			<label><input type="radio" name="oasis_pressure_ulcer_assessment" value="2"><?php xl(' 2 - Yes, using a standardized tool, e.g., Braden, Norton, other','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1302)</u></b> Does this patient have a <b>Risk of Developing Pressure Ulcers?</b>','e');?><br>
			<label><input type="radio" name="oasis_pressure_ulcer_risk" value="0"><?php xl(' 0 - No','e')?></label><br>
			<label><input type="radio" name="oasis_pressure_ulcer_risk" value="1"><?php xl(' 1 - Yes','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1306)</u></b> Does this patient have at least one <b>Unhealed Pressure Ulcer at Stage II or Higher</b> or designated as "unstageable"?','e');?></strong><br>
			<label><input type="radio" id="m1306" name="oasis_pressure_ulcer_unhealed_s2" value="0"><?php xl(' 0 - No <b><i>[ Go to M1322 ]</i></b>','e')?></label><br>
			<label><input type="radio" name="oasis_pressure_ulcer_unhealed_s2" value="1"><?php xl(' 1 - Yes','e')?></label><br>
			
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
				<?php xl("Trial 1:","e");?><input type="text" name="oasis_therapy_timed_up_trial1" id="oasis_therapy_timed_up_trial1" onKeyUp="calc_avg();" value="0"><?php xl("Seconds","e");?><br>
				<?php xl("Trial 2:","e");?><input type="text" name="oasis_therapy_timed_up_trial2" id="oasis_therapy_timed_up_trial2" onKeyUp="calc_avg();" value="0"><?php xl("Seconds","e");?><br>
				<?php xl("Average:","e");?><input type="text" name="oasis_therapy_timed_up_average" id="oasis_therapy_timed_up_average" value="0" readonly><?php xl("Seconds","e");?>
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
		<td colspan="2">
			<center><strong><?php xl("INTEGUMENTARY STATUS","e");?></strong></center>
			<?php xl("Mark all applicable conditions listed below:","e");?><br>
			<b><?php xl("Turgor:","e");?></b>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Good","e");?>"><?php xl('Good','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Poor","e");?>"><?php xl('Poor','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Edema","e");?>"><?php xl('Edema (specify if not otherwise in assessment)','e')?></label>
				<input type="text" name="oasis_integumentary_status_turgur_edema" value=""><br>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Itch","e");?>"><?php xl('Itch','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Rash","e");?>"><?php xl('Rash','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Dry","e");?>"><?php xl('Dry','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Scaling","e");?>"><?php xl('Scaling','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Redness","e");?>"><?php xl('Redness','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Bruises","e");?>"><?php xl('Bruises','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Ecchymosis","e");?>"><?php xl('Ecchymosis','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Pallor","e");?>"><?php xl('Pallor','e')?></label>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Jaundice","e");?>"><?php xl('Jaundice','e')?></label><br>
			<label><input type="checkbox" name="oasis_integumentary_status_turgur[]" value="<?php xl("Other","e");?>"><?php xl('Other (specify)','e')?></label>
				<input type="text" name="oasis_integumentary_status_turgur_other" value=""><br>
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
						<input type="text" name="oasis_therapy_braden_scale_sensory" onKeyUp="sum_braden_scale()" id="braden_sensory" value="0">
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
						<input type="text" name="oasis_therapy_braden_scale_moisture" onKeyUp="sum_braden_scale()" id="braden_moisture" value="0">
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
						<input type="text" name="oasis_therapy_braden_scale_activity" onKeyUp="sum_braden_scale()" id="braden_activity" value="0">
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
						<input type="text" name="oasis_therapy_braden_scale_mobility" onKeyUp="sum_braden_scale()" id="braden_mobility" value="0">
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
						<input type="text" name="oasis_therapy_braden_scale_nutrition" onKeyUp="sum_braden_scale()" id="braden_nutrition" value="0">
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
						<input type="text" name="oasis_therapy_braden_scale_friction" onKeyUp="sum_braden_scale()" id="braden_friction" value="0">
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
						<input type="text" name="oasis_therapy_braden_scale_total" id="braden_total" readonly>
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
						<input type="text" name="oasis_therapy_pressure_ulcer_a[]" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_a[]" value="">
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
						<input type="text" name="oasis_therapy_pressure_ulcer_b[]" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_b[]" value="">
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
						<input type="text" name="oasis_therapy_pressure_ulcer_c[]" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_c[]" value="">
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
						<input type="text" name="oasis_therapy_pressure_ulcer_d1[]" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d1[]" value="">
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
						<input type="text" name="oasis_therapy_pressure_ulcer_d2[]" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d2[]" value="">
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
						<input type="text" name="oasis_therapy_pressure_ulcer_d3[]" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_therapy_pressure_ulcer_d3[]" value="">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php xl("<b>Directions for M1310, M1312, and M1314:</b> If the patient has one or more unhealed (non-epithelialized) Stage III or IV pressure ulcers, identify the <b>Stage III or IV pressure ulcer with the largest surface dimension (length x width)</b> and record in centimeters. If no Stage III or Stage IV pressure ulcers, go to M1320.","e");?>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<?php xl("<b><u>(M1310)</u> Pressure Ulcer Length:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_length" value=""><br>
			<?php xl("Longest length \"head-to-toe\" (cm)","e");?>
		</td>
		<td>
			<?php xl("<b><u>(M1312)</u> Pressure Ulcer Width:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_width" value=""><br>
			<?php xl("Width of the same pressure ulcer; greatest width perpendicular to the length (cm)","e");?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php xl("<b><u>(M1314)</u> Pressure Ulcer Depth:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_depth" value=""><br>
			<?php xl("Depth of the same pressure ulcer; from visible surface to the deepest area (cm)","e");?>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('<u>(M1320)</u> Status of Most Problematic (Observable) Pressure Ulcer:','e');?></strong><br>
			<label><input id="m1320" type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="0"><?php xl(' 0 - Newly epithelialized','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="1"><?php xl(' 1 - Fully granulating','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="2"><?php xl(' 2 - Early/partial granulation','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="3"><?php xl(' 3 - Not healing','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="NA"><?php xl(' NA - No observable pressure ulcer','e')?></label><br>
		</td>
		<td valign="top">
			<?php xl('<b><u>(M1322)</u>Current Number of Stage I Pressure Ulcers:</b> Intact skin with non-blanchable redness of a localized area usually over a bony prominence. The area may be painful, firm, soft, warmer or cooler as compared to adjacent tissue.','e');?><br>
			<label><input id="m1322" type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="0" checked><?php xl(' 0 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="1"><?php xl(' 1 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="2"><?php xl(' 2 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="3"><?php xl(' 3 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="4"><?php xl(' 4 or more ','e')?></label>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong><?php xl('<u>(M1324)</u> Stage of Most Problematic Unhealed (Observable) Pressure Ulcer:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="1"><?php xl(' 1 - Stage I ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="2"><?php xl(' 2 - Stage II ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="3"><?php xl(' 3 - Stage III ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="4"><?php xl(' 4 - Stage IV ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="NA"><?php xl(' NA - No observable pressure ulcer or unhealed pressure ulcer ','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1330)</u></b> Does this patient have a <b>Stasis Ulcer</b>?','e');?><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer" value="0" checked><?php xl(' 0 - No <b><i>[ Go to M1340 ]</i></b> ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer" value="1"><?php xl(' 1 - Yes, patient has BOTH observable and unobservable stasis ulcers ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer" value="2"><?php xl(' 2 - Yes, patient has observable stasis ulcers ONLY ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer" value="3"><?php xl(' 3 - Yes, patient has unobservable stasis ulcers ONLY (known but not observable due to non-removable dressing) <b><i>[ Go to M1340 ]</i></b> ','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('<u>(M1332)</u> Current Number of (Observable) Stasis Ulcer(s):','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_num" value="1"><?php xl(' 1 - One ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_num" value="2"><?php xl(' 2 - Two ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_num" value="3"><?php xl(' 3 - Three ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_num" value="4"><?php xl(' 4 - Four or more ','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('<u>(M1334)</u> Status of Most Problematic (Observable) Stasis Ulcer:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_status" value="0"><?php xl(' 0 - Newly epithelialized ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_status" value="1"><?php xl(' 1 - Fully granulating ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_status" value="2"><?php xl(' 2 - Early/partial granulation ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_statis_ulcer_status" value="3"><?php xl(' 3 - Not healing ','e')?></label><br>
			
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
			<label><input type="radio" id="m1340" name="oasis_therapy_surgical_wound" value="0" checked><?php xl(' 0 - No <b><i>[ Go to M1350 ]</i></b> ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="1"><?php xl(' 1 - Yes, patient has at least one (observable) surgical wound ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_surgical_wound" value="2"><?php xl(' 2 - Surgical wound known but not observable due to non-removable dressing <b><i>[ Go to M1350 ] </i></b>','e')?></label><br>
			
			<br>
			<hr>
			<strong><?php xl('<u>(M1342)</u> Status of Most Problematic (Observable) Surgical Wound:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="0"><?php xl(' 0 - Newly epithelialized ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="1"><?php xl(' 1 - Fully granulating ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="2"><?php xl(' 2 - Early/partial granulation ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_status_surgical_wound" value="3"><?php xl(' 3 - Not healing ','e')?></label><br>
			
			<br>
			<hr>
			<?php xl('<b><u>(M1350)</u></b> Does this patient have a <b>Skin Lesion or Open Wound</b>, excluding bowel ostomy, other than those described above <u>that is receiving intervention</u> by the home health agency?','e');?><br>
			<label><input type="radio" id="m1350" name="oasis_therapy_skin_lesion" value="0"><?php xl(' 0 - No ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_skin_lesion" value="1"><?php xl(' 1 - Yes ','e')?></label><br>
			
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
				<label><input type="checkbox" name="oasis_therapy_integumentary_status_problem" value="<?php xl("No","e");?>"><?php xl('No Problem','e')?></label>
			</strong></center>
			<?php xl('Wound care done:','e')?>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_wound_care_done" value="Yes"><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_wound_care_done" value="No"><?php xl(' No ','e')?></label><br>
			
			<?php xl('Location(s) if patient has more than one wound site:','e')?>
			<input type="text" name="oasis_therapy_wound_location" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Soiled dressing removed","e");?>"><?php xl('Soiled dressing removed','e')?></label>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php xl('By:','e')?>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_dressing_by" value="<?php xl("Patient","e");?>"><?php xl('Patient','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_dressing_by" value="<?php xl("Family/caregiver","e");?>"><?php xl('Family/caregiver','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_dressing_by" value="<?php xl("RN/PT","e");?>"><?php xl('RN/PT','e')?></label>
			<br>
			
			<?php xl('Technique:','e')?>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_technique" value="<?php xl("Sterile","e");?>"><?php xl('Sterile','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_wound_soiled_technique" value="<?php xl("Clean","e");?>"><?php xl('Clean','e')?></label>
			<br>
			
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Wound cleaned with","e");?>"><?php xl('Wound cleaned with (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_cleaned" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Wound irrigated with","e");?>"><?php xl('Wound irrigated with (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_irrigated" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Wound packed with","e");?>"><?php xl('Wound packed with (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_packed" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Wound dressing applied","e");?>"><?php xl('Wound dressing applied (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_dressing_apply" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Patient tolerated procedure well","e");?>"><?php xl('Patient tolerated procedure well','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Incision care with","e");?>"><?php xl('Incision care with (specify):','e')?></label>
			<input type="text" name="oasis_therapy_wound_incision" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_wound[]" value="<?php xl("Staples present","e");?>"><?php xl('Staples present','e')?></label><br>
			<?php xl("Comments:","e");?>
			<textarea name="oasis_therapy_wound_comment" rows="3" style="width:100%;"></textarea><br>
			
			<?php xl('Satisfactory return demo:','e')?>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_satisfactory_return_demo" value="Yes"><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_therapy_satisfactory_return_demo" value="No"><?php xl(' No ','e')?></label><br>
			<?php xl('Education: ','e')?>
			<label><input type="checkbox" name="oasis_therapy_wound_education" value="Yes"><?php xl('Yes','e')?></label><br>
			<?php xl("Comments:","e");?>
			<textarea name="oasis_therapy_wound_education_comment" rows="3" style="width:100%;"></textarea>
		</td>
		<td>
			<center><strong><?php xl("WOUND LOCATIONS","e");?></strong></center>
			<?php
                /* Create a form object. */
                $c = new C_FormPainMap('oasis_nursing_soc','bodymap_man.png');
                /* Render a 'new form' page. */
                echo $c->default_action();
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
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Type","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Status","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Size (cm)","e");?>
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="">
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="">
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Stage (pressure ulcers only)","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Tunneling/Undermining","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Odor","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Surrounding Skin","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Edema","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Stoma","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Appearance of the Wound Bed","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Drainage Amount","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Color","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Consistency","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="">
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
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_location[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Type","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_type[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Status","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_status[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Size (cm)","e");?>
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="">
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="">
					</td>
					<td>
						<?php xl("Length","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_length[]" size="1" value="">
						<?php xl("Width","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_width[]" size="1" value="">
						<?php xl("Depth","e");?>
						<input type="text" name="oasis_therapy_wound_lesion_size_depth[]" size="1" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Stage (pressure ulcers only)","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stage[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Tunneling/Undermining","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_tunneling[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Odor","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_odor[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Surrounding Skin","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_skin[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Edema","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_edema[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Stoma","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_stoma[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Appearance of the Wound Bed","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_appearance[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Drainage Amount","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_drainage[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Color","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_color[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Consistency","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_wound_lesion_consistency[]" value="">
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
				<label><input type="checkbox" name="oasis_therapy_cardiopulmonary_problem" value="No"><?php xl('No Problem','e')?></label>
			</strong></center>
		</td>
	</tr>
	<tr>
		<td> 
			<strong><?php xl('Breath Sounds:','e')?></strong><br>
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Clear"><?php xl(' Clear ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Crackles/Rales"><?php xl(' Crackles/Rales ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Wheezes/Rhonchi"><?php xl(' Wheezes/Rhonchi ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Diminished"><?php xl(' Diminished ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_breath_sounds_type" value="Absent"><?php xl(' Absent ','e')?></label> <br>
			
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Anterior","e");?>"><?php xl('Anterior:','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_anterior" value="<?php xl("Right","e");?>"><?php xl('Right','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_anterior" value="<?php xl("Left","e");?>"><?php xl('Left','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_anterior" value="<?php xl("O2","e");?>"><?php xl('O2 saturation','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Posterior","e");?>"><?php xl('Posterior:','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_posterior" value="<?php xl("Right Upper","e");?>"><?php xl('Right Upper','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_posterior" value="<?php xl("Right Lower","e");?>"><?php xl('Right Lower','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_posterior" value="<?php xl("Left Upper","e");?>"><?php xl('Left Upper','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_posterior" value="<?php xl("Left Lower","e");?>"><?php xl('Left Lower','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("O2 saturation","e");?>"><?php xl('O2 saturation:','e')?></label>
				<input type="text" name="oasis_therapy_breath_sounds_o2_saturation" value="">%<br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Accessory muscles used","e");?>"><?php xl('Accessory muscles used','e')?></label>
				<input type="text" name="oasis_therapy_breath_sounds_accessory_muscle" value="">
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_accessory_muscle_o2" value="<?php xl("O2","e");?>"><?php xl('O2','e')?></label>
				<input type="text" name="oasis_therapy_breath_sounds_accessory_o2_detail" value="">
				<?php xl('LPM per','e')?><input type="text" name="oasis_therapy_breath_sounds_accessory_lpm" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Pulse Oximetry per Symptomology","e");?>"><?php xl('Pulse Oximetry per Symptomology','e')?></label><br>
			<?php xl('Does this patient have a trach?','e')?>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach" value="Yes"><?php xl(' Yes ','e')?></label>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach" value="No"><?php xl(' No ','e')?></label><br>
			<?php xl('Who manages?','e')?>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach_manages" value="Self"><?php xl(' Self ','e')?></label>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach_manages" value="RN"><?php xl(' RN ','e')?></label>
				<label><input type="radio" name="oasis_therapy_breath_sounds_trach_manages" value="Caregiver"><?php xl(' Caregiver/family ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Cough","e");?>"><b><?php xl('Cough:','e')?></b></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_cough" value="<?php xl("Dry","e");?>"><?php xl('Dry','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_cough" value="<?php xl("Acute","e");?>"><?php xl('Acute','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_cough" value="<?php xl("Chronic","e");?>"><?php xl('Chronic','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Productive","e");?>"><b><?php xl('Productive:','e')?></b></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_productive" value="<?php xl("Thick","e");?>"><?php xl('Thick','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_breath_sounds_productive" value="<?php xl("Thin","e");?>"><?php xl('Thin','e')?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php xl('Color','e')?>
				<input type="text" name="oasis_therapy_breath_sounds_productive_color" value="">
				<?php xl('Amount','e')?>
				<input type="text" name="oasis_therapy_breath_sounds_productive_amount" value="">
				<br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Dyspnea","e");?>"><b><?php xl('Dyspnea:','e')?></b></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Rest","e");?>"><?php xl('Rest','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Exertion","e");?>"><?php xl('Exertion','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Ambulation feet","e");?>"><?php xl('Ambulation feet','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("During ADL","e");?>"><?php xl('During ADL"s','e')?></label>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Orthopnea","e");?>"><?php xl('Orthopnea','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_breath_sounds[]" value="<?php xl("Other","e");?>"><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_therapy_breath_sounds_other" value=""><br>
			
			
		</td>
		<td valign="top"> 
			<strong><?php xl('Heart Sounds:','e')?></strong><br>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_type" value="<?php xl("Regular","e");?>"><?php xl('Regular','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_type" value="<?php xl("Irregular","e");?>"><?php xl('Irregular','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_type" value="<?php xl("Murmur","e");?>"><?php xl('Murmur','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Pacemaker","e");?>"><?php xl('Pacemaker:','e')?></label>
				<input type="text" name="oasis_therapy_heart_sounds_pacemaker" value="">&nbsp;&nbsp;
				<?php xl('Date:','e')?><input type='text' size='10' name='oasis_therapy_heart_sounds_pacemaker_date' id='oasis_therapy_heart_sounds_pacemaker_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date7' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_therapy_heart_sounds_pacemaker_date", ifFormat:"%Y-%m-%d", button:"img_curr_date7"});
						</script>
				<?php xl('Type:','e')?><input type="text" name="oasis_therapy_heart_sounds_pacemaker_type" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Chest Pain","e");?>"><b><?php xl('Chest Pain:','e')?></b></label><br>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Anginal","e");?>"><?php xl('Anginal','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Postural","e");?>"><?php xl('Postural','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Localized","e");?>"><?php xl('Localized','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Substernal","e");?>"><?php xl('Substernal','e')?></label><br>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Radiating","e");?>"><?php xl('Radiating','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Dull","e");?>"><?php xl('Dull','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Ache","e");?>"><?php xl('Ache','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Sharp","e");?>"><?php xl('Sharp','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_chest_pain" value="<?php xl("Vise-like","e");?>"><?php xl('Vise-like','e')?></label><br>
			<b><?php xl('Associated with:','e')?></b>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_associated_with" value="<?php xl("Shortness","e");?>"><?php xl('Shortness of breath','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_associated_with" value="<?php xl("Activity","e");?>"><?php xl('Activity','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_associated_with" value="<?php xl("Sweats","e");?>"><?php xl('Sweats','e')?></label><br>
			<b><?php xl('Frequency/duration:','e')?></b>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_frequency" value="<?php xl("Palpitations","e");?>"><?php xl('Palpitations','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_frequency" value="<?php xl("Fatigue","e");?>"><?php xl('Fatigue','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Edema","e");?>"><b><?php xl('Edema:','e')?></b></label><br>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_edema" value="<?php xl("Pedal","e");?>"><?php xl('Pedal Right/Left','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_edema" value="<?php xl("Sacral","e");?>"><?php xl('Sacral','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_edema" value="<?php xl("Dependent","e");?>"><?php xl('Dependent:','e')?></label><br>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Pitting +1","e");?>"><?php xl('Pitting +1','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Pitting +2","e");?>"><?php xl('Pitting +2','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Pitting +3","e");?>"><?php xl('Pitting +3','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Pitting +4","e");?>"><?php xl('Pitting +4','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_edema_dependent" value="<?php xl("Non-pitting","e");?>"><?php xl('Non-pitting','e')?></label><br>
			<?php xl("Site","e");?>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_site" value="<?php xl("Cramps","e");?>"><?php xl('Cramps','e')?></label>
				<label><input type="checkbox" name="oasis_therapy_heart_sounds_site" value="<?php xl("Claudication","e");?>"><?php xl('Claudication','e')?></label><br>
			<?php xl("Capillary refill","e");?>
				<label><input type="radio" name="oasis_therapy_heart_sounds_capillary" value="<?php xl("<3","e");?>"><?php xl('less than 3 sec','e')?></label>
				<label><input type="radio" name="oasis_therapy_heart_sounds_capillary" value="<?php xl(">3","e");?>"><?php xl('greater than 3 sec','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Other","e");?>"><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_therapy_heart_sounds_other" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Weigh patient","e");?>"><?php xl('Weigh patient','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_heart_sounds[]" value="<?php xl("Notify MD","e");?>"><?php xl('Notify MD of weight variations of','e')?></label>
				<input type="text" name="oasis_therapy_heart_sounds_notify" value="">
				
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
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="0" checked><?php xl(' 0 - Patient is not short of breath ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="1"><?php xl(' 1 - When walking more than 20 feet, climbing stairs ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="2"><?php xl(' 2 - With moderate exertion (e.g., while dressing, using commode or bedpan, walking distances less than 20 feet) ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="3"><?php xl(' 3 - With minimal exertion (e.g., while eating, talking, or performing other ADLs) or with agitation ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="4"><?php xl(' 4 - At rest (during day or night) ','e')?></label> <br>
			<br><br>
		</td>
		<td valign="top">
			<?php xl("<b><u>(M1410)</u>Respiratory Treatments</b> utilized at home: <b>(Mark all that apply.)</b>","e");?><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="1"><?php xl(' 1 - Oxygen (intermittent or continuous) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="2"><?php xl(' 2 - Ventilator (continually or at night) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="3"><?php xl(' 3 - Continuous / Bi-level positive airway pressure ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="4"><?php xl(' 4 - None of the above ','e')?></label>
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
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="0"><?php xl(' 0 - No ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="1"><?php xl(' 1 - Yes ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="NA"><?php xl(' NA - Patient on prophylactic treatment ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="UK"><?php xl(' UK - Unknown <b>[Omit "UK" option on DC]</b> ','e')?></label> <br>
			
			<br>
			<strong><?php xl("<u>(M1610)</u> Urinary Incontinence or Urinary Catheter Presence:","e");?></strong><br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="0" checked><?php xl(' 0 - No incontinence or catheter (includes anuria or ostomy for urinary drainage) <b><i>[ Go to M1620 ]</i></b> ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="1"><?php xl(' 1 - Patient is incontinent ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="2"><?php xl(' 2 - Patient requires a urinary catheter (i.e., external, indwelling, intermittent, suprapubic) <b><i>[ Go to M1620 ]</i></b> ','e')?></label> <br>
			
			<br>
			<?php xl("<b><u>(M1615)</u> When</b> does <b>Urinary Incontinence</b> occur?","e");?></strong><br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="0"><?php xl(' 0 - Timed-voiding defers incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="1"><?php xl(' 1 - Occasional stress incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="2"><?php xl(' 2 - During the night only ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="3"><?php xl(' 3 - During the day only ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="4"><?php xl(' 4 - During the day and night ','e')?></label> <br>
			
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1620)</u> Bowel Incontinence Frequency:","e");?></strong><br>
			<label><input type="radio" id="m1620" name="oasis_elimination_status_bowel_incontinence" value="0" checked><?php xl(' 0 - Very rarely or never has bowel incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="1"><?php xl(' 1 - Less than once weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="2"><?php xl(' 2 - One to three times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="3"><?php xl(' 3 - Four to six times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="4"><?php xl(' 4 - On a daily basis ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="5"><?php xl(' 5 - More often than once daily ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="NA"><?php xl(' NA - Patient has ostomy for bowel elimination ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_bowel_incontinence" value="UK"><?php xl(' UK - Unknown <b>[Omit "UK" option on FU, DC] </b>','e')?></label> <br>
			
			<br>
			<?php xl("<b><u>(M1630)</u> Ostomy for Bowel Elimination:</b> Does this patient have an ostomy for bowel elimination that (within the last 14 days): a) was related to an inpatient facility stay, <u>or</u> b) necessitated a change in medical or treatment regimen?","e");?><br>
			<label><input type="radio" name="oasis_elimination_status_ostomy_bowel" value="0" checked><?php xl(' 0 - Patient does not have an ostomy for bowel elimination. ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_ostomy_bowel" value="1"><?php xl(' 1 - Patient\'s ostomy was <u>not</u> related to an inpatient stay and did <u>not</u> necessitate change in medical or treatment regimen. ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_ostomy_bowel" value="2"><?php xl(' 2 - The ostomy <u>was</u> related to an inpatient stay or <u>did</u> necessitate change in medical or treatment regimen. ','e')?></label> <br>
			
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
				<label><input type="checkbox" name="oasis_urinary_problem" value="No"><?php xl('No Problem','e')?></label>
			</strong></center>
			<?php xl("(Check all applicable items)","e");?><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Urgency/frequency","e");?>"><?php xl('Urgency/frequency','e')?></label>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Burning/pain","e");?>"><?php xl('Burning/pain','e')?></label>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Hesitancy","e");?>"><?php xl('Hesitancy','e')?></label>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Nocturia","e");?>"><?php xl('Nocturia','e')?></label><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Hematuria","e");?>"><?php xl('Hematuria','e')?></label>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Oliguria/anuria","e");?>"><?php xl('Oliguria/anuria','e')?></label><br />
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Incontinence","e");?>"><?php xl('Incontinence (details if applicable)','e')?></label>
				<input type="text" name="oasis_urinary_incontinence" value=""><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Management Strategies","e");?>"><?php xl('Management Strategies:','e')?></label>
				<input type="text" name="oasis_urinary_management_strategy" value=""><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="<?php xl("Diapers/other:","e");?>"><?php xl('Diapers/other:','e')?></label>
				<input type="text" name="oasis_urinary_diapers_other" value=""><br>
			<b><?php xl("Color:","e");?></b>
				<label><input type="radio" name="oasis_urinary_color" value="Yellow"><?php xl('Yellow/straw','e')?></label>
				<label><input type="radio" name="oasis_urinary_color" value="Amber"><?php xl('Amber','e')?></label>
				<label><input type="radio" name="oasis_urinary_color" value="Brown"><?php xl('Brown/gray','e')?></label>
				<label><input type="radio" name="oasis_urinary_color" value="Blood"><?php xl('Blood-tinged','e')?></label>
				<label><input type="radio" name="oasis_urinary_color" value="Other"><?php xl('Other','e')?></label>
				<input type="text" name="oasis_urinary_color_other" value=""><br>
			<b><?php xl("Clarity:","e");?></b>
				<label><input type="radio" name="oasis_urinary_clarity" value="Clear"><?php xl('Clear','e')?></label>
				<label><input type="radio" name="oasis_urinary_clarity" value="Cloudy"><?php xl('Cloudy','e')?></label>
				<label><input type="radio" name="oasis_urinary_clarity" value="Sediment"><?php xl('Sediment/mucous','e')?></label><br>
			<b><?php xl("Odor:","e");?></b>
				<label><input type="radio" name="oasis_urinary_odor" value="Yes"><?php xl('Yes','e')?></label>
				<label><input type="radio" name="oasis_urinary_odor" value="No"><?php xl('No','e')?></label><br>
			<?php xl("<b>Urinary Catheter:</b> Type (specify)","e");?>
				<input type="text" name="oasis_urinary_catheter" value=""><br>
			<?php xl("Date last changed","e");?><br>
				<label><input type="checkbox" name="oasis_urinary[]" value="Foley inserted"><?php xl('Foley inserted','e')?></label>
				<input type='text' size='10' name='oasis_urinary_foley_date' id='oasis_urinary_foley_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date1' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_urinary_foley_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
						</script>
				<?php xl("with French Inflated balloon with","e");?>
				<input type="text" name="oasis_urinary_foley_ml" value=""><?php xl("ml","e");?>&nbsp;&nbsp;
				<label><input type="checkbox" name="oasis_urinary[]" value="without difficulty"><?php xl('without difficulty','e')?></label><br>
			<?php xl("<b>Irrigation solution:</b> Type (specify)","e");?>
				<input type="text" name="oasis_urinary_irrigation_solution" value=""><br>
				<?php xl("Amount","e");?>
				<input type="text" name="oasis_urinary_irrigation_amount" value="">
				<?php xl("ml","e");?>
				<input type="text" name="oasis_urinary_irrigation_ml" value="">
				<?php xl("Frequency","e");?>
				<input type="text" name="oasis_urinary_irrigation_frequency" value="">
				<?php xl("Returns","e");?>
				<input type="text" name="oasis_urinary_irrigation_returns" value=""><br>
			<?php xl("Patient tolerated procedure well","e");?>
				<label><input type="radio" name="oasis_urinary_tolerated_procedure" value="Yes"><?php xl('Yes','e')?></label>
				<label><input type="radio" name="oasis_urinary_tolerated_procedure" value="No"><?php xl('No','e')?></label><br>
			<label><input type="checkbox" name="oasis_urinary[]" value="Other"><?php xl('Other (specify)','e')?></label>
				<input type="text" name="oasis_urinary_other" value=""><br>
		
		
		</td>
		<td>
		
		
		<center><strong>
				<?php xl("BOWELS","e");?>
				<label><input type="checkbox" name="oasis_bowels_problem" value="No"><?php xl('No Problem','e')?></label>
			</strong></center>
			<label><input type="checkbox" name="oasis_bowels[]" value="Flatulence"><?php xl('Flatulence','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Constipation/impaction"><?php xl('Constipation/impaction','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Diarrhea"><?php xl('Diarrhea','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Rectal bleeding"><?php xl('Rectal bleeding','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Hemorrhoids"><?php xl('Hemorrhoids','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Last BM"><?php xl('Last BM','e')?></label>
				<label><input type="checkbox" name="oasis_bowels[]" value="Frequency of stools"><?php xl('Frequency of stools','e')?></label>
				<br />
			<?php xl("Bowel regime/program:","e");?>
				<input type="text" name="oasis_bowel_regime" value=""><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Laxative/Enema use"><?php xl('Laxative/Enema use:','e')?></label>
				<label><input type="radio" name="oasis_bowels_lexative_enema" value="Daily"><?php xl('Daily','e')?></label>
				<label><input type="radio" name="oasis_bowels_lexative_enema" value="Weekly"><?php xl('Weekly','e')?></label>
				<label><input type="radio" name="oasis_bowels_lexative_enema" value="Monthly"><?php xl('Monthly','e')?></label><br>
				<label><input type="radio" name="oasis_bowels_lexative_enema" value="Other"><?php xl('Other:','e')?></label>
					<input type="text" name="oasis_bowels_lexative_enema_other" value=""><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Incontinence"><?php xl('Incontinence (details if applicable)','e')?></label><br>
				<textarea name="oasis_bowels_incontinence" rows="3" style="width:100%;"></textarea><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Diapers/other"><?php xl('Diapers/other:','e')?></label>
				<input type="text" name="oasis_bowels_diapers_others" value=""><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Ileostomy/colostomy"><?php xl('Ileostomy/colostomy site (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_bowels_ileostomy_site"></textarea><br>
			<?php xl('Ostomy care managed by:','e')?>
				<label><input type="radio" name="oasis_bowels_ostomy_care" value="Self"><?php xl('Self','e')?></label>
				<label><input type="radio" name="oasis_bowels_ostomy_care" value="Caregiver"><?php xl('Caregiver','e')?></label><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Other site"><?php xl('Other site (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_bowels_other_site"></textarea><br>
			<label><input type="checkbox" name="oasis_bowels[]" value="Urostomy"><?php xl('Urostomy (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" style="width:100%;" name="oasis_bowels_urostomy"></textarea><br>

		</td>
		

		
	</tr>
	<tr valign="top">
	
	<td>
	<center><strong>
				<?php xl("GENITALIA","e");?>
				<label><input type="checkbox" name="oasis_genitalia_problem" value="No"><?php xl('No Problem','e')?></label>
			</strong></center>
	
	<label><input type="checkbox" name="oasis_genitalia[]" value="Discharge/Drainage:"><?php xl('Discharge/Drainage:','e')?></label>
	<input type="text" name="oasis_genitalia_discharge" value="">
	<br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Lesions/Blisters/Masses/Cysts"><?php xl('Lesions/Blisters/Masses/Cysts','e')?></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Imflammation:"><?php xl('Imflammation:','e')?></label>
	<input type="text" name="oasis_genitalia_imflammation" value=""><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Surgical Alteration:"><?php xl('Surgical Alteration:','e')?></label>
	<input type="text" name="oasis_genitalia_surgical_alteration" value=""><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Prostate Problem:"><?php xl('Prostate Problem:','e')?></label>
	<input type="text" name="oasis_genitalia_prostate_problem" value="">
		<?php xl('BPH/TURP Date','e')?>
	<input type='text' size='10' name='oasis_genitalia_date' id='oasis_genitalia_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_genitalia_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
						</script>
	<br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Self-testicular exam"><?php xl('Self-testicular exam','e')?></label>
	<input type="text" name="oasis_genitalia_self_testicular_exam" value="">
	<?php xl('Frequency','e')?>
	<input type="text" name="oasis_genitalia_frequency" value="">
	<br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Menopause"><?php xl('Menopause','e')?></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Hysterectomy Date"><?php xl('Hysterectomy Date','e')?></label><br />
	<label><?php xl('Date last PAP','e')?>	
	<input type='text' size='10' name='oasis_genitalia_date_last_PAP' id='oasis_genitalia_date_last_PAP' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date3' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_genitalia_date_last_PAP", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
						</script>
	</label>
	
	<label><?php xl('Results','e')?><input type="text" name="oasis_genitalia_results" value=""></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Breast self-exam frequency"><?php xl('Breast self-exam frequency','e')?></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Discharge:R/L"><?php xl('Discharge:R/L','e')?></label><br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Mastectomy:"><?php xl('Mastectomy:','e')?></label>
	<input type="text" name="oasis_genitalia_mastectomy" value="">
	<label><?php xl('R/L Date','e')?>
	<input type='text' size='10' name='oasis_genitalia_rl_date' id='oasis_genitalia_rl_date' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date45' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_genitalia_rl_date", ifFormat:"%Y-%m-%d", button:"img_curr_date45"});
						</script></label>
	<br />
	<label><input type="checkbox" name="oasis_genitalia[]" value="Other(specify)"><?php xl('Other(specify)','e')?></label>
	<input type="text" name="oasis_genitalia_other" value="">
	</td>


	<td>
	<center><strong>
				<?php xl("ABDOMEN","e");?>
				<label><input type="checkbox" name="oasis_abdomen_problem" value="No"><?php xl('No Problem','e')?></label>
			</strong></center>
			
			<label><input type="checkbox" name="oasis_abdomen[]" value="Tenderness"><?php xl('Tenderness','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Pain"><?php xl('Pain','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Distention"><?php xl('Distention','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Hard"><?php xl('Hard','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Soft"><?php xl('Soft','e')?></label>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Ascites"><?php xl('Ascites','e')?></label><br />
			<label><input type="checkbox" name="oasis_abdomen[]" value="Abdominal girth"><?php xl('Abdominal girth','e')?></label>
			<input type="text" name="oasis_abdomen_girth_inches" value="" size="3"><?php xl('inches','e')?>
			<label><input type="checkbox" name="oasis_abdomen[]" value="Other:"><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_abdomen_other" value=""><br />
			
			<?php xl("NG/enteral tube(type,size)","e");?>
			<input type="text" name="oasis_ng_enteral_tube" value="">
			<br />
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="Bowel Sounds:"><?php xl('Bowel Sounds:','e')?></label>
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="active"><?php xl('active','e')?></label>
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="absent"><?php xl('absent','e')?></label>
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="hypo"><?php xl('hypo','e')?></label>
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="hyperactive x quadrants"><?php xl('hyperactive x quadrants','e')?></label><br />
			<label><input type="checkbox" name="oasis_ng_enteral[]" value="Other:"><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_ng_enteral_other" value=""><br />
			<?php xl("(see Enteral Feedings section)","e");?>
			
	</td>
	
	</tr>
	
	<tr>
	<td colspan="2">
	<center><strong>
				<?php xl("ENDOCRINE/HEMATOLOGY","e");?>
				<label><input type="checkbox" name="oasis_endocrine_problem" value="No"><?php xl('No Problem','e')?></label>
			</strong></center>
	</td>
	</tr>
	
	<tr valign="top">
	<td>
	
	<label><input type="checkbox" name="oasis_endocrine[]" value="The patient has a history of diabetes, thyroid problems, anemia or gastrointestinal bleeding">
	<?php xl('The patient has a history of diabetes, thyroid problems, anemia or gastrointestinal bleeding','e')?></label><br />
	<?php xl('Competence with use of Glucometer<br />(Check all applicable items)','e')?><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Diabetes:"><?php xl('Diabetes:','e')?></label>
	<label><input type="radio" name="oasis_endocrine_diabetes" value="Juvenile/Type I"><?php xl('Juvenile/Type I','e')?></label>
	<label><input type="radio" name="oasis_endocrine_diabetes" value="Type II"><?php xl('Type II','e')?></label><br />
	<?php xl('Onset of diabetes','e')?><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Diet/Oral control (specify)"><?php xl('Diet/Oral control (specify)','e')?></label>
	<input type="text" name="oasis_endocrine_diet" value=""><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Insulin dose/frequency (specify)"><?php xl('Insulin dose/frequency (specify)','e')?></label><br />
	<input type="text" name="oasis_endocrine_insulin" value=""><br />
	<?php xl('On insulin since','e')?>
	<input type='text' size='10' name='oasis_endocrine_insulin_since' id='oasis_endocrine_insulin_since' 
						title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date41' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_endocrine_insulin_since", ifFormat:"%Y-%m-%d", button:"img_curr_date41"});
						</script>
	<br />
	<?php xl('Administered by:','e')?>
	<label><input type="checkbox" name="oasis_endocrine_admin_by" value="Self"><?php xl('Self','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_admin_by" value="Nurse"><?php xl('Nurse','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_admin_by" value="Caregiver"><?php xl('Caregiver','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_admin_by" value="Other"><?php xl('Other','e')?></label>
	<input type="text" name="oasis_endocrine_admin_by_other" value=""><br />
	
	<label><input type="checkbox" name="oasis_endocrine[]" value="Hyperglycemia: Glycosuria/Polyuria/Polydipsia"><?php xl('Hyperglycemia: Glycosuria/Polyuria/Polydipsia','e')?></label><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Hypoglycemia: Sweats/Polyphagia/Weak/Faint/Stupor"><?php xl('Hypoglycemia: Sweats/Polyphagia/Weak/Faint/Stupor','e')?></label><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Blood sugar ranges"><?php xl('Blood sugar ranges','e')?></label><br />
	<?php xl('Monitored by:','e')?>
	<label><input type="checkbox" name="oasis_endocrine_monitored_by" value="Self"><?php xl('Self','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_monitored_by" value="Caregiver"><?php xl('Caregiver','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_monitored_by" value="Nurse"><?php xl('Nurse','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine_monitored_by" value="Other"><?php xl('Other','e')?></label>
	<input type="text" name="oasis_endocrine_monitored_by_other" value=""><br />
	<?php xl('Frequency of monitoring','e')?><br />
	<?php xl('Notify physician if blood sugar over ','e')?>
	<input type="text" name="oasis_endocrine_blood_sugar_over" value="" size="5">
	<?php xl('and under ','e')?>
	<input type="text" name="oasis_endocrine_blood_sugar_under" value="" size="5">
	<?php xl('MG%','e')?><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Patient/Caregiver able to draw up insulin"><?php xl('Patient/Caregiver able to draw up insulin','e')?></label><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Patient/Caregiver able to administer insulin"><?php xl('Patient/Caregiver able to administer insulin','e')?></label><br />
	
	</td>
	
	<td>
	<label><input type="checkbox" name="oasis_endocrine[]" value="Any diagnosed manifestations (specify):"><?php xl('Any diagnosed manifestations (specify):','e')?></label><br />
	
	<?php xl('Renal','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="oasis_endocrine_renal" value=""><br />
	<?php xl('Ophthalmic','e')?>&nbsp;&nbsp;<input type="text" name="oasis_endocrine_ophthalmic" value=""><br />
	<?php xl('Neurologic','e')?>&nbsp;&nbsp;&nbsp;<input type="text" name="oasis_endocrine_neurologic" value=""><br />
	<?php xl('Other','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="oasis_endocrine_other" value=""><br />
	
	<label><input type="checkbox" name="oasis_endocrine[]" value="Disease Management Problems (Explain)"><?php xl('Disease Management Problems (Explain)','e')?></label>
	<br />
	<input type="text" name="oasis_endocrine_disease_management_problems" value="" size="50"><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Enlarged thyroid"><?php xl('Enlarged thyroid','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine[]" value="Fatigue"><?php xl('Fatigue','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine[]" value="Intolerance to heat/cold"><?php xl('Intolerance to heat/cold','e')?></label>
	<br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Other:"><?php xl('Other:','e')?></label>
	<input type="text" name="oasis_endocrine_other1" value=""><br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Anemia (specify if known)"><?php xl('Anemia (specify if known)','e')?></label>
	<input type="text" name="oasis_endocrine_anemia" value="">
	<br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Secondary bleed: GI/GU/GYN/unknown"><?php xl('Secondary bleed: GI/GU/GYN/unknown','e')?></label>
	<label><input type="checkbox" name="oasis_endocrine[]" value="Hemophilia"><?php xl('Hemophilia','e')?></label>
	<br />
	<label><input type="checkbox" name="oasis_endocrine[]" value="Other2:"><?php xl('Other:','e')?></label>
	<input type="text" name="oasis_endocrine_other2" value=""><br />
	
	
	</td>
	
	</tr>
	
</table>

                        </li>
                    </ul>
                </li>


<li>
                    <div><a href="#" id="black">Nutritional Status, Nutrition, Neuro/Emotional/Behavioral Status, Mental Status, Psychosocial &amp; Infusion</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                        <ul>
<!-- *********************  nutritional status   ******************** -->
                        <li>


<table width="100%" border="1" class="formtable">

<tr valign="top">
<td width="50%">
<center><strong><?php xl('NUTRITIONAL STATUS','e')?></strong>
<label><input type="checkbox" name="oasis_nutrition_status_prob" value="No Problem"  id="oasis_nutrition_status_prob" /> <?php xl('No Problem','e')?></label></center><br />
<label><input type="checkbox" name="oasis_nutrition_status" value="NAS"  id="oasis_nutrition_status" /> <?php xl('NAS','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_status" value="NPO"  id="oasis_nutrition_status" /> <?php xl('NPO','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_status" value="No Concentrated Sweets"  id="oasis_nutrition_status" /> <?php xl('No Concentrated Sweets','e')?></label> &nbsp;
<br/>
<label><input type="checkbox" name="oasis_nutrition_status" value="Other"  id="oasis_nutrition_status" /> <?php xl('Other','e')?></label> &nbsp;
<input type="text" name="oasis_nutrition_status_other" id="oasis_nutrition_status_other"  style="width:80%" />
<br />
<strong>
<?php xl('Nutritional Requirements (diet)','e')?></strong><br />
<label><input type="checkbox" name="oasis_nutrition_requirements" value="Increase fluids amt"  id="oasis_nutrition_requirements" /> <?php xl('Increase fluids amt','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_requirements" value="Restrict fluids amt"  id="oasis_nutrition_requirements" /> <?php xl('Restrict fluids amt','e')?></label> &nbsp;

<br />
<strong><?php xl('Appetite','e')?></strong>
<label><input type="radio" name="oasis_nutrition_appetite" value="Good"  id="oasis_nutrition_appetite" /> <?php xl('Good','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_appetite" value="Fair"  id="oasis_nutrition_appetite" /> <?php xl('Fair','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_appetite" value="Poor"  id="oasis_nutrition_appetite" /> <?php xl('Poor','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_appetite" value="Anorexic"  id="oasis_nutrition_appetite" /> <?php xl('Anorexic','e')?></label> &nbsp;

<br />
<strong><?php xl('Eating Patterns','e')?></strong>
<br /><textarea name="oasis_nutrition_eat_patt" rows="2" cols="48"></textarea>
<br /><br />
<label><input type="checkbox" name="oasis_nutrition_eat_patt1[]" value="Nausea/Vomiting"  id="oasis_nutrition_eat_patt1" />
<?php xl('Nausea/Vomiting: ','e')?></label> &nbsp;
<label><?php xl('Frequency','e')?><input type="text" name="oasis_nutrition_eat_patt_freq" id="oasis_nutrition_eat_patt_freq" size="8" /></label> &nbsp;
<label><?php xl('Amount','e')?><input type="text" name="oasis_nutrition_eat_patt_amt" id="oasis_nutrition_eat_patt_amt" size="8" /></label> &nbsp;
<br />
<label><input type="checkbox" name="oasis_nutrition_eat_patt1[]" value="Heartburn (food intolerance)"  id="oasis_nutrition_eat_patt1" />
<?php xl('Heartburn (food intolerance)','e')?></label> &nbsp;
<br />
<label><input type="checkbox" name="oasis_nutrition_eat_patt1[]" value="Weight Change:"  id="oasis_nutrition_eat_patt1" />
<?php xl('Weight Change:','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_eat_gain_or_loss" value="gain"/>
<?php xl('Gain','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_eat_gain_or_loss" value="loss" />
<?php xl('Loss','e')?></label> &nbsp;
<input type="text" name="oasis_nutrition_patt_gain" id="oasis_nutrition_patt_gain" size="10" />&nbsp;
<?php xl('lb. X','e')?>&nbsp;
<label><input type="radio" name="oasis_nutrition_eat_patt1_gain_time" value="wk./"  id="oasis_nutrition_eat_patt1_gain_time" />
<?php xl('wk./','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_eat_patt1_gain_time" value="mo./"  id="oasis_nutrition_eat_patt1_gain_time" />
<?php xl('mo./','e')?></label> &nbsp;
<label><input type="radio" name="oasis_nutrition_eat_patt1_gain_time" value="yr."  id="oasis_nutrition_eat_patt1_gain_time" />
<?php xl('yr.','e')?></label> &nbsp;<br />
<label><input type="checkbox" name="oasis_nutrition_eat_patt1[]" value="Other(Specify including history)"  id="oasis_nutrition_eat_patt1" />
<?php xl('Other(Specify including history)','e')?></label> &nbsp;
<input type="text" name="oasis_nutrition_patt1_other" id="oasis_nutrition_patt1_other" style="width:42%" />
<br /><br />
<center><strong><?php xl('NUTRITIONAL REQUIREMENTS','e')?></strong></center><br />
<label><input type="checkbox" name="oasis_nutrition_req" value="Regular Diet"  id="oasis_nutrition_req" />
<?php xl('Regular Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Diet as Tolerated"  id="oasis_nutrition_req" />
<?php xl('Diet as Tolerated','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Soft Diet"  id="oasis_nutrition_req" />
<?php xl('Soft Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="NCS"  id="oasis_nutrition_req" />
<?php xl('NCS','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Diabetic Diet # Calorie ADA"  id="oasis_nutrition_req" />
<?php xl('Diabetic Diet # Calorie ADA','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Pureed Diet"  id="oasis_nutrition_req" />
<?php xl('Pureed Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="NAS"  id="oasis_nutrition_req" />
<?php xl('NAS','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Low Salt Gram Sodium"  id="oasis_nutrition_req" />
<?php xl('Low Salt Gram Sodium','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_nutrition_req" value="Low Fat/Low Cholestrol Diet"  id="oasis_nutrition_req" />
<?php xl('Low Fat/Low Cholestrol Diet','e')?></label> &nbsp;
<br />
<label><input type="checkbox" name="oasis_nutrition_req" value="Other Special Diet"  id="oasis_nutrition_req" />
<?php xl('Other Special Diet','e')?></label> &nbsp;
<br />
<textarea name="oasis_nutrition_req_other" rows="2" cols="48" ></textarea>

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
<td width="5%"><input type="checkbox" name="oasis_nutrition_risks[]" value="Has an illness or condition that changed the kind and/or amount of food eaten"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" /></td>
</tr>
<tr>
<td><?php xl('Eats fewer than 2 meals per day','e')?></td>
<td><?php xl('3','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Eats fewer than 2 meals per day"  id="oasis_nutrition_risks" onChange="nut_sum(this,3)" /></td>
</tr>
<tr>
<td><?php xl('Eats few fruits, vegetables or milk products','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Eats few fruits, vegetables or milk products"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" /></td>
</tr>
<tr>
<td><?php xl('Has 3 or more drinks of beer, liquor or wine almost everyday','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Has 3 or more drinks of beer, liquor or wine almost everyday"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" /></td>
</tr>
<tr>
<td><?php xl('Has tooth or mouth problems that make it hard to eat','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Has tooth or mouth problems that make it hard to eat"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" /></td>
</tr>
<tr>
<td><?php xl('Does not always have the enough money to buy the food needed','e')?></td>
<td><?php xl('4','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Does not always have the enough money to buy the food needed"  id="oasis_nutrition_risks" onChange="nut_sum(this,4)" /></td>
</tr>
<tr>
<td><?php xl('Eats alone most of the time','e')?></td>
<td><?php xl('1','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Eats alone most of the time"  id="oasis_nutrition_risks" onChange="nut_sum(this,1)" /></td>
</tr>
<tr>
<td><?php xl('Takes 3 or more different prescribed or over-the-counter drugs a day','e')?></td>
<td><?php xl('1','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Takes 3 or more different prescribed or over-the-counter drugs a day"  id="oasis_nutrition_risks" onChange="nut_sum(this,1)" /></td>
</tr>
<tr>
<td><?php xl('Without warning to, has lost or gained 10 pounds in the last 6 months','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Without warning to, has lost or gained 10 pounds in the last 6 months"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" /></td>
</tr>
<tr>
<td><?php xl('Not always physically able to shop, cook and/or feed self','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="oasis_nutrition_risks[]" value="Not always physically able to shop, cook and/or feed self"  id="oasis_nutrition_risks" onChange="nut_sum(this,2)" /></td>
</tr>
<tr valign="top">
<TD colspan="2" align="right" width="70%">
<label><input type="checkbox" name="oasis_nutrition_risks_MD" value="MD aware or MD notified"  id="oasis_nutrition_req"  />
<?php xl('MD aware or MD notified','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('TOTAL','e')?></strong></label>
</TD>
<td width="30%">
<label><input type="text" name="nutrition_total" id="nutrition_total" size="2" value="0" readonly/></label>
</td>
</tr>
</TABLE>
<strong><?php xl('INTERPRETATION: 0-2 Good. As appropriate reassess and/or provide information based on situation.','e')?><br />
<?php xl('3-5 Moderate risk. Educate, refer, monitor and reevaluate based on patient situation and organization policy.','e')?><br />
<?php xl('6 or more High risk. Coordinate with physician, dietitian, social service professional or nurse about how to improve nutritional health. Describe at risk intervention:','e')?>
<input type="text" name="oasis_nutrition_describe" id="oasis_nutrition_describe" style="width:95%" /><br />
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
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="0" checked><?php xl(' 0 - Alert/oriented, able to focus and shift attention, comprehends and recalls task directions independently. ','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="1"><?php xl(' 1 - Requires prompting (cuing, repetition, reminders) only under stressful or unfamiliar conditions. ','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="2"><?php xl(' 2 - Requires assistance and some direction in specific situations (e.g., on all tasks involving shifting of attention), or consistently requires low stimulus environment due to distractibility.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="3"><?php xl(' 3 - Requires considerable assistance in routine situations. Is not alert and oriented or is unable to shift attention and recall directions more than half the time.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_cognitive_functioning" value="4"><?php xl(' 4 - Totally dependent due to disturbances such as constant disorientation, coma, persistent vegetative state, or delirium.','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1710)</u>","e");?>
			<?php xl("When Confused (Reported or Observed Within the Last 14 Days):","e");?></strong>
			<br />
			<label><input type="radio" name="oasis_neuro_when_confused" value="0" checked><?php xl(' 0 - Never','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="1"><?php xl(' 1 - In new or complex situations only','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="2"><?php xl(' 2 - On awakening or at night only','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="3"><?php xl(' 3 - During the day and evening, but not constantly','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="4"><?php xl(' 4 - Constantly','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_confused" value="NA"><?php xl(' NA - Patient nonresponsive','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1720)</u>","e");?>
			<?php xl("When Anxious (Reported or Observed Within the Last 14 Days):","e");?></strong>
			<br />
			<label><input type="radio" name="oasis_neuro_when_anxious" value="0" checked><?php xl(' 0 - None of the time','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_anxious" value="1"><?php xl(' 1 - Less often than daily','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_anxious" value="2"><?php xl(' 2 - Daily, but not constantly','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_anxious" value="3"><?php xl(' 3 - All of the time','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_when_anxious" value="NA"><?php xl(' NA - Patient nonresponsive','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1730)</u>","e");?></strong>
			<?php xl("<b>Depression Screening:</b> Has the patient been screened for depression, using a standardized depression screening tool?","e");?> 
			<br />
			<label><input type="radio" name="oasis_neuro_depression_screening" value="0" checked><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_depression_screening" value="1"><?php xl(' 1 - Yes, patient was screened using the PHQ-2&copy;* scale. (Instructions for this two-question tool: Ask patient: "Over the last two weeks, how often have you been bothered by any of the following problems")','e')?>
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
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="0"><?php xl(' 0','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="1"><?php xl(' 1','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="2"><?php xl(' 2','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="3"><?php xl(' 3','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_little_interest" value="NA"><?php xl(' NA','e')?></label></td>
			    </tr>
			    
			    <tr>
			    <td><?php xl("b) Feeling down, depressed, or hopeless?","e");?></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="0"><?php xl(' 0','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="1"><?php xl(' 1','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="2"><?php xl(' 2','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="3"><?php xl(' 3','e')?></label></td>
			    <td><label><input type="radio" name="oasis_neuro_feeling_down" value="NA"><?php xl(' NA','e')?></label></td>
			    </tr>
			    
			    </table>
			    
			</td></tr></table>
			
			
			
			
			
			
			
			
			
			
			<label><input type="radio" name="oasis_neuro_depression_screening" value="2"><?php xl(' 2 - Yes, with a different standardized assessment-and the patient meets criteria for further evaluation for depression.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_depression_screening" value="3"><?php xl(' 3 - Yes, patient was screened with a different standardized assessment-and the patient does not meet criteria for further evaluation for depression.','e')?></label> <br>
			<label><?php xl('* copyright&copy; Pfizer Inc. All rights reserved. Reproduced with permission.','e')?></label> <br>
			<br><hr />
			
			
			<strong><?php xl("<u>(M1740)</u>","e");?></strong>
			<?php xl("<strong>Cognitive, behavioral, and psychiatric symptoms</strong> that are demonstrated <u>at least once a week</u> (Reported or Observed). <strong>(Mark all that apply.)</strong>","e");?> 
			<br />
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="1"><?php xl(' 1 - Memory deficit: failure to recognize familiar persons/places, inability to recall events of past 24 hours, significant memory loss so that supervision is required','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="2"><?php xl(' 2 - Impaired decision-making: failure to perform usual ADLs or IADLs, inability to appropriately stop activities, jeopardizes safety through actions','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="3"><?php xl(' 3 - Verbal disruption: yelling, threatening, excessive profanity, sexual references, etc.','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="4"><?php xl(' 4 - Physical aggression: aggressive or combative to self and others (e.g., hits self, throws objects, punches, dangerous maneuvers with wheelchair or other objects)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="5"><?php xl(' 5 - Disruptive, infantile, or socially inappropriate behavior ( <strong>excludes</strong> verbal actions)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="6"><?php xl(' 6 - Delusional, hallucinatory, or paranoid behaviors','e')?></label> <br>
			<label><input type="checkbox" name="oasis_neuro_cognitive_symptoms[]" value="7"><?php xl(' 7 - None of the above behaviors demonstrated','e')?></label> <br>
			<br><hr />
			
			
			<strong><?php xl("<u>(M1745)</u>","e");?></strong>
			<?php xl("<strong>Frequency of Disruptive Behavior Symptoms (Reported or Observed)</strong> Any physical, verbal, or other disruptive/dangerous symptoms that are injurious to self or others or jeopardize personal safety.","e");?> 
			<br />
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="0" checked><?php xl(' 0 - Never','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="1"><?php xl(' 1 - Less than once a month','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="2"><?php xl(' 2 - Once a month','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="3"><?php xl(' 3 - Several times each month.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="4"><?php xl(' 4 - Several times a week.','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_frequency_disruptive" value="5"><?php xl(' 5 - At least daily','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1750)</u>","e");?></strong>
			<?php xl("Is the patient receiving <strong>Psychiatric Nursing Services</strong> at home provided by a qualified psychiatric nurse?","e");?> 
			<br />
			<label><input type="radio" name="oasis_neuro_psychiatric_nursing" value="0"><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_neuro_psychiatric_nursing" value="1"><?php xl(' 1 - Yes','e')?></label> <br>

			
			
			
			
			
</td>
<td>
			<label><input type="checkbox" name="oasis_neuro[]" value="Headache:"  id="oasis_neuro" />
			<?php xl('Headache:','e')?></label> &nbsp;
			<?php xl('Location','e')?>
			<input type="text" name="oasis_neuro_location" value=""/>
			<?php xl('Frequency','e')?>
			<input type="text" name="oasis_neuro_frequency" value=""/><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="PERRLA"  id="oasis_neuro" />
			<?php xl('PERRLA','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Unequal pupils:"  id="oasis_neuro" />
			<?php xl('Unequal pupils:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_unequaled_pupils[]" value="Right"  id="oasis_neuro_unequaled_pupils" />
			<?php xl('Right','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_unequaled_pupils[]" value="Left"  id="oasis_neuro_unequaled_pupils" />
			<?php xl('Left','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Aphasia:"  id="oasis_neuro" />
			<?php xl('Aphasia:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_aphasia" value="Receptive"  id="oasis_neuro_aphasia" />
			<?php xl('Receptive','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_aphasia" value="Expressive"  id="oasis_neuro_aphasia" />
			<?php xl('Expressive','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Motor change:"  id="oasis_neuro" />
			<?php xl('Motor change:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_motor_change" value="Fine"  id="oasis_neuro_motor_change" />
			<?php xl('Fine','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_motor_change" value="Gross Site"  id="oasis_neuro_motor_change" />
			<?php xl('Gross Site','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Dominant side:"  id="oasis_neuro" />
			<?php xl('Dominant side:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_dominant_side[]" value="Right"  id="oasis_neuro_dominant_side" />
			<?php xl('Right','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_dominant_side[]" value="Left"  id="oasis_neuro_dominant_side" />
			<?php xl('Left','e')?></label><br />
			<label><input type="checkbox" name="oasis_neuro[]" value="Weakness:"  id="oasis_neuro" />
			<?php xl('Weakness:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_weakness[]" value="UE"  id="oasis_neuro_weakness" />
			<?php xl('UE','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_weakness[]" value="LE"  id="oasis_neuro_weakness" />
			<?php xl('LE','e')?></label>
			&nbsp;&nbsp;&nbsp;
			<?php xl('Location','e')?>
			<input type="text" name="oasis_neuro_weakness_location" value=""/><br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Tremors:"  id="oasis_neuro" />
			<?php xl('Tremors:','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_tremors" value="Fine"  id="oasis_neuro_tremors" />
			<?php xl('Fine','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_tremors" value="Gross"  id="oasis_neuro_tremors" />
			<?php xl('Gross','e')?></label>
			<label><input type="checkbox" name="oasis_neuro_tremors" value="Paralysis"  id="oasis_neuro_tremors" />
			<?php xl('Paralysis','e')?></label>
			<br />
			<?php xl('Site','e')?>
			<input type="text" name="oasis_neuro_tremors_site" value=""/><br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Stuporous"  id="oasis_neuro" />
			<?php xl('Stuporous','e')?></label>
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Hallucinations"  id="oasis_neuro" />
			<?php xl('Hallucinations','e')?></label>
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Visual"  id="oasis_neuro" />
			<?php xl('Visual','e')?></label>
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Auditory"  id="oasis_neuro" />
			<?php xl('Auditory','e')?></label><br />
			
			
			<?php xl('Hand grips:','e')?><br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Equal (specify)"  id="oasis_neuro" />
			<?php xl('Equal (specify)','e')?></label>
			<input type="text" name="oasis_neuro_handgrip_equal" value=""/>
			<br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Unequal (specify)"  id="oasis_neuro" />
			<?php xl('Unequal (specify)','e')?></label>
			<input type="text" name="oasis_neuro_handgrip_unequal" value=""/>
			<br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Strong (specify)"  id="oasis_neuro" />
			<?php xl('Strong (specify)','e')?></label>
			<input type="text" name="oasis_neuro_handgrip_strong" value=""/>
			<br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Weak (specify)"  id="oasis_neuro" />
			<?php xl('Weak (specify)','e')?></label>
			<input type="text" name="oasis_neuro_handgrip_weak" value=""/>
			<br />
			
			
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Psychotropic drug use (specify)"  id="oasis_neuro" />
			<?php xl('Psychotropic drug use (specify)','e')?></label>
			<input type="text" name="oasis_neuro_psychotropic_drug" value=""/>
			<br />
			
			<?php xl('Dose/Frequency','e')?>
			<input type="text" name="oasis_neuro_dose_frequency" value=""/><br />
			
			<label><input type="checkbox" name="oasis_neuro[]" value="Other (specify)"  id="oasis_neuro" />
			<?php xl('Other (specify)','e')?></label>
			<input type="text" name="oasis_neuro_other" value=""/>
			
			<br /><br />
			
			<center><strong><?php xl('MENTAL STATUS','e')?></strong></center>
			
			<label><input type="checkbox" name="oasis_mental_status[]" value="Oriented"  id="oasis_neuro" />
			<?php xl('Oriented','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Comatose"  id="oasis_neuro" />
			<?php xl('Comatose','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Forgetful"  id="oasis_neuro" />
			<?php xl('Forgetful','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Depressed"  id="oasis_neuro" />
			<?php xl('Depressed','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Disoriented"  id="oasis_neuro" />
			<?php xl('Disoriented','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Lethargic"  id="oasis_neuro" />
			<?php xl('Lethargic','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Agitated"  id="oasis_neuro" />
			<?php xl('Agitated','e')?></label>
			<br />
			<label><input type="checkbox" name="oasis_mental_status[]" value="Other:"  id="oasis_neuro" />
			<?php xl('Other:','e')?></label>
			<input type="text" name="oasis_mental_status_other" value=""/>
			
			<br />
			<br />
			<center><strong><?php xl('PSYCHOSOCIAL','e')?></strong></center>
			
			<?php xl('Primary language','e')?>
			<input type="text" name="oasis_psychosocial_primary_lang" value=""/>
			<br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Language barrier"  id="oasis_psychosocial" />
			<?php xl('Language barrier','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Needs interpreter"  id="oasis_psychosocial" />
			<?php xl('Needs interpreter','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Learning Barrier:"  id="oasis_psychosocial" />
			<?php xl('Learning Barrier:','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Mental"  id="oasis_psychosocial" />
			<?php xl('Mental','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Psychosocial"  id="oasis_psychosocial" />
			<?php xl('Psychosocial','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Physical"  id="oasis_psychosocial" />
			<?php xl('Physical','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Functional"  id="oasis_psychosocial" />
			<?php xl('Functional','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Unable to read/write"  id="oasis_psychosocial" />
			<?php xl('Unable to read/write','e')?></label>
			
			<br />
			<?php xl('Educational Level','e')?>
			<input type="text" name="oasis_psychosocial_edu_level" value=""/>
			<br />
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Angry"  id="oasis_psychosocial" />
			<?php xl('Angry','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Difficulty coping"  id="oasis_psychosocial" />
			<?php xl('Difficulty coping','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Withdrawn"  id="oasis_psychosocial" />
			<?php xl('Withdrawn','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Discouraged"  id="oasis_psychosocial" />
			<?php xl('Discouraged','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Flat affect"  id="oasis_psychosocial" />
			<?php xl('Flat affect','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Disorganized"  id="oasis_psychosocial" />
			<?php xl('Disorganized','e')?></label><br />
			
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Spiritual/Cultural implications that impact care."  id="oasis_psychosocial" />
			<?php xl('Spiritual/Cultural implications that impact care.','e')?></label><br />
			<?php xl('Explain:','e')?>
			<input type="text" name="oasis_psychosocial_explain" value=""/><br />
			<?php xl('Spiritual resource:','e')?>
			<input type="text" name="oasis_psychosocial_spiritual_resource" value=""/><br />
			<?php xl('Phone No:','e')?>
			<input type="text" name="oasis_psychosocial_phone_no" value=""/><br />
			
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Depressed: Recent/Long term Treatment:"  id="oasis_psychosocial" />
			<?php xl('Depressed: Recent/Long term Treatment:','e')?></label>
			<input type="text" name="oasis_psychosocial_treatment" value=""/>
			<br />
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inability to cope with altered health status"  id="oasis_psychosocial" />
			<?php xl('Inability to cope with altered health status','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inability to recognize problems"  id="oasis_psychosocial" />
			<?php xl('Inability to recognize problems','e')?></label><br />
			
			<?php xl('Due to:','e')?>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Lack of motivation"  id="oasis_psychosocial" />
			<?php xl('Lack of motivation','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Unrealistic expectations"  id="oasis_psychosocial" />
			<?php xl('Unrealistic expectations','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Denial of problems"  id="oasis_psychosocial" />
			<?php xl('Denial of problems','e')?></label>
			
			<br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Sleep/Rest:"  id="oasis_psychosocial" />
			<?php xl('Sleep/Rest:','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Adequate"  id="oasis_psychosocial" />
			<?php xl('Adequate','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inadequate"  id="oasis_psychosocial" />
			<?php xl('Inadequate','e')?></label><br />
			<?php xl('Explain','e')?>
			<input type="text" name="oasis_psychosocial_sleep_explain" value="" size="50" />
			<br />
			
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inappropriate responses to caregivers/clinician"  id="oasis_psychosocial" />
			<?php xl('Inappropriate responses to caregivers/clinician','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Inappropriate follow-through in past"  id="oasis_psychosocial" />
			<?php xl('Inappropriate follow-through in past','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Evidence of"  id="oasis_psychosocial" />
			<?php xl('Evidence of','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Potential"  id="oasis_psychosocial" />
			<?php xl('Potential','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Actual"  id="oasis_psychosocial" />
			<?php xl('Actual','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Verbal/Emotional"  id="oasis_psychosocial" />
			<?php xl('Verbal/Emotional','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Physical1"  id="oasis_psychosocial" />
			<?php xl('Physical','e')?></label>
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Financial"  id="oasis_psychosocial" />
			<?php xl('Financial','e')?></label><br />
			<label><input type="checkbox" name="oasis_psychosocial[]" value="Describe:"  id="oasis_psychosocial" />
			<?php xl('Describe:','e')?></label><br />
			<textarea name="oasis_psychosocial_describe" rows="3" cols="48"></textarea><br />
			<?php xl('Comments:','e')?></label><br />
			<textarea name="oasis_psychosocial_comments" rows="3" cols="48"></textarea><br />
			
			
			<br />
			<hr />
			<center><strong><?php xl('INFUSION','e')?></strong>
<label>
<input type="checkbox" name="oasis_infusion[]" value="NA"  id="oasis_infusion" />
<?php xl('NA','e')?></label> &nbsp;
</center>
<label>
<input type="checkbox" name="oasis_infusion[]" value="Peripheral: (specify)"  id="oasis_infusion" />
<strong><?php xl('Peripheral: (specify)','e')?></strong></label> &nbsp;
<input type="text" name="oasis_infusion_peripheral" id="oasis_infusion_peripheral" size="25" /><br />
<label>
<input type="checkbox" name="oasis_infusion[]" value="PICC: (specify, size, brand)"  id="oasis_infusion" />
<strong><?php xl('PICC: (specify, size, brand)','e')?></strong></label> &nbsp;
<input type="text" name="oasis_infusion_PICC" id="oasis_infusion_PICC" size="25" /><br />
<label>
<input type="checkbox" name="oasis_infusion[]" value="Central"  id="oasis_infusion" /><?php xl('Central','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Midline/Midclavicular"  id="oasis_infusion" /><?php xl('Midline/Midclavicular','e')?></label><br />
&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" name="oasis_infusion_central" value="Single lumen"  id="oasis_infusion_central" />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="oasis_infusion_central" value="Double lumen"  id="oasis_infusion_central" />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="oasis_infusion_central" value="Triple lumen"  id="oasis_infusion_central" />
<?php xl('Triple lumen','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;

<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_infusion_central_date' id='oasis_infusion_central_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date99' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_infusion_central_date", ifFormat:"%Y-%m-%d", button:"img_curr_date99"});
                        </script>
<br />
<label>
<input type="checkbox" name="oasis_infusion[]" value="X-ray verification:"  id="oasis_infusion" />
<strong><?php xl('X-ray verification:','e')?></strong></label> &nbsp;
<label><input type="radio" name="oasis_infusion_xray" value="Yes"  id="oasis_infusion_xray" />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="oasis_infusion_xray" value="No"  id="oasis_infusion_xray" />
<?php xl('No','e')?></label> &nbsp;

<br />
<label>
<input type="checkbox" name="oasis_infusion[]" value="Mid arm circumference in/cm"  id="oasis_infusion" />
<?php xl('Mid arm circumference in/cm','e')?></label> &nbsp;
<input type="text" name="oasis_infusion_circum" id="oasis_infusion_circum" size="25" /><br />
<label>
<input type="checkbox" name="oasis_infusion[]" value="External catheter length in/cm"  id="oasis_infusion" />
<?php xl('External catheter length in/cm','e')?></label> &nbsp;
<input type="text" name="oasis_infusion_length" id="oasis_infusion_length" size="25" /><br />
<br />

<label>
<input type="checkbox" name="oasis_infusion[]" value="Hickman"  id="oasis_infusion" />
<?php xl('Hickman','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Broviac"  id="oasis_infusion" />
<?php xl('Broviac','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Groshong"  id="oasis_infusion" />
<?php xl('Groshong','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Jugular"  id="oasis_infusion" />
<?php xl('Jugular','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Subclavian"  id="oasis_infusion" />
<?php xl('Subclavian','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
<label><input type="radio" name="oasis_infusion_hickman" value="Single lumen"  id="oasis_infusion_hickman" />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="oasis_infusion_hickman" value="Double lumen"  id="oasis_infusion_hickman" />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="oasis_infusion_hickman" value="Triple lumen"  id="oasis_infusion_hickman" />
<?php xl('Triple lumen','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_infusion_hickman_date' id='oasis_infusion_hickman_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date19' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_infusion_hickman_date", ifFormat:"%Y-%m-%d", button:"img_curr_date19"});
                        </script>
<br />



<label>
<input type="checkbox" name="oasis_infusion[]" value="Epidural catheter"  id="oasis_infusion" />
<?php xl('Epidural catheter','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Tunneled"  id="oasis_infusion" />
<?php xl('Tunneled','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Port1"  id="oasis_infusion" />
<?php xl('Port','e')?></label> &nbsp;
<br />

<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_infusion_epidural_date' id='oasis_infusion_epidural_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date20' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_infusion_epidural_date", ifFormat:"%Y-%m-%d", button:"img_curr_date20"});
                        </script>
<br />

<label>
<input type="checkbox" name="oasis_infusion[]" value="Implanted VAD"  id="oasis_infusion" />
<?php xl('Implanted VAD','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Venous"  id="oasis_infusion" />
<?php xl('Venous','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Arterial"  id="oasis_infusion" />
<?php xl('Arterial','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Peritoneal"  id="oasis_infusion" />
<?php xl('Peritoneal','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_infusion_implanted_date' id='oasis_infusion_implanted_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date21' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_infusion_implanted_date", ifFormat:"%Y-%m-%d", button:"img_curr_date21"});
                        </script>
<br />


<label>
<input type="checkbox" name="oasis_infusion[]" value="Intrathecal"  id="oasis_infusion" />
<?php xl('Intrathecal','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Port2"  id="oasis_infusion" />
<?php xl('Port','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion[]" value="Reservoir"  id="oasis_infusion" />
<?php xl('Reservoir','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_infusion_intrathecal_date' id='oasis_infusion_intrathecal_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date22' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_infusion_intrathecal_date", ifFormat:"%Y-%m-%d", button:"img_curr_date22"});
                        </script>
<br />


<label>
<input type="checkbox" name="oasis_infusion[]" value="Medication administered1"  id="oasis_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="oasis_infusion_med1_admin" id="oasis_infusion_med1_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="oasis_infusion_med1_name" id="oasis_infusion_med1_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="oasis_infusion_med1_dose" id="oasis_infusion_med1_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="oasis_infusion_med1_dilution" id="oasis_infusion_med1_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="oasis_infusion_med1_route" id="oasis_infusion_med1_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="oasis_infusion_med1_frequency" id="oasis_infusion_med1_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="oasis_infusion_med1_duration" id="oasis_infusion_med1_duration" size="10" />
</label>

<!-- ********************************************************************* -->

<br />


<label>
<input type="checkbox" name="oasis_infusion[]" value="Medication administered2"  id="oasis_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="oasis_infusion_med2_admin" id="oasis_infusion_med2_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="oasis_infusion_med2_name" id="oasis_infusion_med2_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="oasis_infusion_med2_dose" id="oasis_infusion_med2_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="oasis_infusion_med2_dilution" id="oasis_infusion_med2_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="oasis_infusion_med2_route" id="oasis_infusion_med2_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="oasis_infusion_med2_frequency" id="oasis_infusion_med2_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="oasis_infusion_med2_duration" id="oasis_infusion_med2_duration" size="10" />
</label>


<br />

<label>
<input type="checkbox" name="oasis_infusion[]" value="Medication administered3"  id="oasis_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="oasis_infusion_med3_admin" id="oasis_infusion_med3_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="oasis_infusion_med3_name" id="oasis_infusion_med3_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="oasis_infusion_med3_dose" id="oasis_infusion_med3_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="oasis_infusion_med3_dilution" id="oasis_infusion_med3_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="oasis_infusion_med3_route" id="oasis_infusion_med3_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="oasis_infusion_med3_frequency" id="oasis_infusion_med3_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="oasis_infusion_med3_duration" id="oasis_infusion_med3_duration" size="10" />
</label>
<br />
<label>
<input type="checkbox" name="oasis_infusion[]" value="Pump:(type, specify)"  id="oasis_infusion" />
<strong><?php xl('Pump:(type, specify)','e')?></strong></label> &nbsp;
<input type="text" name="oasis_infusion_pump" id="oasis_infusion_pump" size="25" />
<br />
<strong><?php xl('Administered by:','e')?></strong>
<label>
<input type="checkbox" name="oasis_infusion_admin_by" value="Self"  id="oasis_infusion_admin_by" />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion_admin_by" value="Caregiver"  id="oasis_infusion_admin_by" />
<?php xl('Caregiver','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion_admin_by" value="RN"  id="oasis_infusion_admin_by" />
<?php xl('RN','e')?></label> &nbsp;
<label><br />
<input type="checkbox" name="oasis_infusion_admin_by" value="Other"  id="oasis_infusion_admin_by" />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="oasis_infusion_admin_by_other" id="oasis_infusion_admin_by_other"  width="40"  />
<br />
<label>
<input type="checkbox" name="oasis_infusion[]" value="Dressing change:"  id="oasis_infusion" />
<strong><?php xl('Dressing change:','e')?></strong></label> &nbsp;
<label><input type="radio" name="oasis_infusion_dressing" value="Sterile"  id="oasis_infusion_dressing" />
<?php xl('Sterile','e')?></label> &nbsp;
<label><input type="radio" name="oasis_infusion_dressing" value="Clean"  id="oasis_infusion_dressing" />
<?php xl('Clean','e')?></label> &nbsp;
<br />

<strong><?php xl('Performed by:','e')?></strong> &nbsp;&nbsp;&nbsp;&nbsp;
<label>
<input type="checkbox" name="oasis_infusion_performed_by" value="Self"  id="oasis_infusion_performed_by" />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion_performed_by" value="RN"  id="oasis_infusion_performed_by" />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_infusion_performed_by" value="Caregiver"  id="oasis_infusion_performed_by" />
<?php xl('Caregiver','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="oasis_infusion_performed_by" value="Other"  id="oasis_infusion_performed_by" />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="oasis_infusion_performed_by_other" id="oasis_infusion_performed_by_other" size="30" />
<br />

<label><?php xl('Frequency (specify)','e')?> &nbsp;
<input type="text" name="oasis_infusion_frequency" id="oasis_infusion_frequency" size="30" />
</label>
<br />
<label><?php xl('Injection cap change (specify frequency)','e')?> &nbsp;
<input type="text" name="oasis_infusion_injection" id="oasis_infusion_injection" size="20" />
</label>
<br />
<label><?php xl('Labs drawn','e')?> &nbsp;
<br />
<textarea name="oasis_infusion_labs_drawn" rows="2" cols="48"></textarea>
</label>


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
			<label><input type="radio" name="oasis_adl_grooming" value="0" checked><?php xl(' 0 - Able to groom self unaided, with or without the use of assistive devices or adapted methods.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_grooming" value="1"><?php xl(' 1 - Grooming utensils must be placed within reach before able to complete grooming activities.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_grooming" value="2"><?php xl(' 2 - Someone must assist the patient to groom self.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_grooming" value="3"><?php xl(' 3 - Patient depends entirely upon someone else for grooming needs.','e')?></label> <br>
			<br><hr />
			
			
			<strong><u><?php xl("(M1810) ","e");?></u></strong>
			<?php xl("Current ","e");?>
			<strong><?php xl(" Ability to Dress <u>Upper</u> Body ","e");?></strong> 
			<?php xl(" safely (with or without dressing aids) including undergarments, pullovers, front-opening shirts and blouses, managing zippers, buttons, and snaps:","e");?><br />
			<label><input type="radio" name="oasis_adl_dress_upper" value="0" checked><?php xl(' 0 - Able to get clothes out of closets and drawers, put them on and remove them from the  upper body without assistance. ','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_upper" value="1"><?php xl(' 1 - Able to dress upper body without assistance if clothing is laid out or handed to the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_upper" value="2"><?php xl(' 2 - Someone must help the patient put on upper body clothing.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_upper" value="3"><?php xl(' 3 - Patient depends entirely upon another person to dress the upper body.','e')?></label> <br>
			<br><hr />
			
			
			<strong><u><?php xl("(M1820) ","e");?></u></strong>
			<?php xl("Current ","e");?>
			<strong><?php xl("Ability to Dress <u>Lower</u> Body ","e");?></strong> 
			<?php xl(" safely (with or without dressing aids) including undergarments, slacks, socks or nylons, shoes:","e");?><br />
			<label><input type="radio" name="oasis_adl_dress_lower" value="0" checked><?php xl(' 0 - Able to obtain, put on, and remove clothing and shoes without assistance.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_lower" value="1"><?php xl(' 1 - Able to dress lower body without assistance if clothing and shoes are laid out or handed to the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_lower" value="2"><?php xl(' 2 - Someone must help the patient put on undergarments, slacks, socks or nylons, and shoes.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_dress_lower" value="3"><?php xl(' 3 - Patient depends entirely upon another person to dress lower body.','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1830)</u> Bathing: ","e");?></strong>
			<?php xl("Current ability to wash entire body safely. ","e");?>
			<strong><?php xl("<u>Excludes</u> grooming (washing face, washing hands, and shampooing hair). ","e");?></strong> <br />
			<label><input type="radio" name="oasis_adl_wash" value="0" checked><?php xl(' 0 - Able to bathe self in <u>shower or tub</u> independently, including getting in and out of tub/shower.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="1"><?php xl(' 1 - With the use of devices, is able to bathe self in shower or tub independently, including getting in and out of the tub/shower.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="2"><?php xl(' 2 - Able to bathe in shower or tub with the intermittent assistance of another person:<br>
(a) for intermittent supervision or encouragement or reminders, <u>OR</u><br>
(b) to get in and out of the shower or tub, <u>OR</u><br>
(c) for washing difficult to reach areas.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="3"><?php xl(' 3 - Able to participate in bathing self in shower or tub, <u>but</u> requires presence of another person throughout the bath for assistance or supervision.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="4"><?php xl(' 4 - Unable to use the shower or tub, but able to bathe self independently with or without the use of devices at the sink, in chair, or on commode.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="5"><?php xl(' 5 - Unable to use the shower or tub, but able to participate in bathing self in bed, at the sink, in bedside chair, or on commode, with the assistance or supervision of another person throughout the bath.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_wash" value="6"><?php xl(' 6 - Unable to participate effectively in bathing and is bathed totally by another person.','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1840)</u> Toilet Transferring: ","e");?></strong>
			<?php xl("Current ability to get to and from the toilet or bedside commode safely <u>and</u> transfer on and off toilet/commode. ","e");?><br />
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="0" checked><?php xl(' 0 - Able to get to and from the toilet and transfer independently with or without a device.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="1"><?php xl(' 1 - When reminded, assisted, or supervised by another person, able to get to and from the toilet and transfer.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="2"><?php xl(' 2 - <u>Unable</u> to get to and from the toilet but is able to use a bedside commode (with or without assistance).','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="3"><?php xl(' 3 - <u>Unable</u> to get to and from the toilet or bedside commode but is able to use a bedpan/urinal independently.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toilet_transfer" value="4"><?php xl(' 4 - Is totally dependent in toileting.','e')?></label> <br>
			<br>
			
	
	</td>
	
	<td>
			<strong><?php xl("<u>(M1845)</u> Toileting Hygiene: ","e");?></strong>
			<?php xl("Current ability to maintain perineal hygiene safely, adjust clothes and/or incontinence pads before and after using toilet, commode, bedpan, urinal. If managing ostomy, includes cleaning area around stoma, but not managing equipment.","e");?><br />
			<label><input type="radio" name="oasis_adl_toileting_hygiene" value="0" checked><?php xl(' 0 - Able to manage toileting hygiene and clothing management without assistance.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toileting_hygiene" value="1"><?php xl(' 1 - Able to manage toileting hygiene and clothing management without assistance if supplies/implements are laid out for the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toileting_hygiene" value="2"><?php xl(' 2 - Someone must help the patient to maintain toileting hygiene and/or adjust clothing.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_toileting_hygiene" value="3"><?php xl(' 3 - Patient depends entirely upon another person to maintain toileting hygiene.','e')?></label> <br>
			<br>
			<hr />
			<strong><?php xl("<u>(M1850)</u> Transferring: ","e");?></strong>
			<?php xl("Current ability to move safely from bed to chair, or ability to turn and position self in bed if patient is bedfast.","e");?><br />
			<label><input type="radio" name="oasis_adl_transferring" value="0" checked><?php xl(' 0 - Able to independently transfer.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="1"><?php xl(' 1 - Able to transfer with minimal human assistance or with use of an assistive device.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="2"><?php xl(' 2 - Able to bear weight and pivot during the transfer process but unable to transfer self.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="3"><?php xl(' 3 - Unable to transfer self and is unable to bear weight or pivot when transferred by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="4"><?php xl(' 4 - Bedfast, unable to transfer but is able to turn and position self in bed','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_transferring" value="5"><?php xl(' 5 - Bedfast, unable to transfer and is unable to turn and position self.','e')?></label>
			<br><hr />
			
			<strong><?php xl("<u>(M1860)</u> Ambulation/Locomotion: ","e");?></strong>
			<?php xl("Current ability to walk safely, once in a standing position, or use a wheelchair, once in a seated position, on a variety of surfaces.","e");?><br />
			<label><input type="radio" name="oasis_adl_ambulation" value="0" checked><?php xl(' 0 - Able to independently walk on even and uneven surfaces and negotiate stairs with or without railings (i.e., needs no human assistance or assistive device).','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="1"><?php xl(' 1 - With the use of a one-handed device (e.g. cane, single crutch, hemi-walker), able to independently walk on even and uneven surfaces and negotiate stairs with or without railings.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="2"><?php xl(' 2 - Requires use of a two-handed device (e.g., walker or crutches) to walk alone on a level surface and/or requires human supervision or assistance to negotiate stairs or steps or uneven surfaces.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="3"><?php xl(' 3 - Able to walk only with the supervision or assistance of another person at all times.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="4"><?php xl(' 4 - Chairfast, <u>unable</u> to ambulate but is able to wheel self independently.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="5"><?php xl(' 5 - Chairfast, unable to ambulate and is <u>unable</u> to wheel self.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_ambulation" value="6"><?php xl(' 6 - Bedfast, unable to ambulate or be up in a chair.','e')?></label> <br>
			<br /><hr />
			
			
			<strong><?php xl("<u>(M1870)</u> Feeding or Eating: ","e");?></strong>
			<?php xl("Current ability to feed self meals and snacks safely. Note: This refers only to the process of <u>eating</u>, <u>chewing</u>, and <u>swallowing</u>, <u>not preparing</u> the food to be eaten.","e");?><br />
			<label><input type="radio" name="oasis_adl_feeding_eating" value="0" checked><?php xl(' 0 - Able to independently feed self.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="1"><?php xl(' 1 - Able to feed self independently but requires:<br />
(a) meal set-up; <u>OR</u><br />
(b) intermittent assistance or supervision from another person; <u>OR</u><br />
(c) a liquid, pureed or ground meat diet.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="2"><?php xl(' 2 - <u>Unable</u> to feed self and must be assisted or supervised throughout the meal/snack.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="3"><?php xl(' 3 - Able to take in nutrients orally <u>and</u> receives supplemental nutrients through a nasogastric tube or gastrostomy','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="4"><?php xl(' 4 - <u>Unable</u> to take in nutrients orally and is fed nutrients through a nasogastric tube or gastrostomy.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_feeding_eating" value="5"><?php xl(' 5 - Unable to take in nutrients orally or by tube feeding.','e')?></label> <br>
			<br>
			
			<hr />
			<strong><?php xl("<u>(M1880)</u>","e");?></strong>
			<?php xl("Current <strong>Ability to Plan and Prepare Light Meals</strong> (e.g., cereal, sandwich) or reheat delivered meals safely:","e");?><br />
			<label><input type="radio" name="oasis_adl_current_ability" value="0" checked><?php xl(' 0 - (a) Able to independently plan and prepare all light meals for self or reheat delivered meals; <u>OR</u><br />
(b) Is physically, cognitively, and mentally able to prepare light meals on a regular basis but has not routinely performed light meal preparation in the past (i.e., prior to this home care admission).','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_current_ability" value="1"><?php xl(' 1 - <u>Unable</u> to prepare light meals on a regular basis due to physical, cognitive, or mental limitations.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_current_ability" value="2"><?php xl(' 2 - Unable to prepare any light meals or reheat any delivered meals.','e')?></label> <br>
			<br />
			
			
			
			
	
	</td>
	
	</tr>
	</table>
	
	

                        </li>
                    </ul>
                </li>





                
                
                
                
                
                
                



<li>
                    <div><a href="#" id="black">ADL/IADLs (CONTD), Medication</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                       <ul id="adl_iadls_contd">
<!-- ********************* ADL/IADLs (CONTD)   ******************** -->
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
			<label><input type="radio" name="oasis_adl_use_telephone" value="0" checked><?php xl(' 0 - Able to dial numbers and answer calls appropriately and as desired.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="1"><?php xl(' 1 - Able to use a specially adapted telephone (i.e., large numbers on the dial, teletype phone for the deaf) and call essential numbers.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="2"><?php xl(' 2 - Able to answer the telephone and carry on a normal conversation but has difficulty with placing calls.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="3"><?php xl(' 3 - Able to answer the telephone only some of the time or is able to carry on only a limited conversation.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="4"><?php xl(' 4 - <u>Unable</u> to answer the telephone at all but can listen if assisted with equipment.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="5"><?php xl(' 5 - Totally unable to use the telephone.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_use_telephone" value="NA"><?php xl(' NA - Patient does not have a telephone.','e')?></label> <br>
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
<label><input type="radio" name="oasis_adl_func_self_care" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_self_care" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_self_care" value="2"><?php xl(' 2','e')?></label> <br>
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
<label><input type="radio" name="oasis_adl_func_ambulation" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_ambulation" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_ambulation" value="2"><?php xl(' 2','e')?></label> <br>
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
<label><input type="radio" name="oasis_adl_func_transfer" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_transfer" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_transfer" value="2"><?php xl(' 2','e')?></label> <br>
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
<label><input type="radio" name="oasis_adl_func_household" value="0"><?php xl(' 0','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_household" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td valign="middle" align="center">
<label><input type="radio" name="oasis_adl_func_household" value="2"><?php xl(' 2','e')?></label> <br>
</td>
</tr>

</table>

<br />
<center><strong><?php xl("ACTIVITIES PERMITTED","e");?></strong></center><br>
			<table class="formtable" border="0" width="100%">
				<tr>
					<td width="50%">
						1. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Complete Bedrest"><?php xl('Complete Bedrest','e')?></label><br>
						2. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Bedrest w/ BRP"><?php xl('Bedrest w/ BRP','e')?></label><br>
						3. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Up as tolerated"><?php xl('Up as tolerated','e')?></label><br>
						4. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Transfer Bed/Chair"><?php xl('Transfer Bed/Chair','e')?></label><br>
						5. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Exercises Prescribed"><?php xl('Exercises Prescribed','e')?></label><br>
						6. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Partial Weight Bearing"><?php xl('Partial Weight Bearing','e')?></label><br>
						7. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Independent At Home"><?php xl('Independent At Home','e')?></label><br>
					</td>
					<td>
						8. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Crutches"><?php xl('Crutches','e')?></label><br>
						9. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Cane"><?php xl('Cane','e')?></label><br>
						A. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Wheelchair"><?php xl('Wheelchair','e')?></label><br>
						B. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Walker"><?php xl('Walker','e')?></label><br>
						C. <label><input type="checkbox" name="oasis_activities_permitted[]" value="No Restrictions"><?php xl('No Restrictions','e')?></label><br>
						D. <label><input type="checkbox" name="oasis_activities_permitted[]" value="Other"><?php xl('Other (specify):','e')?></label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						   <input type="text" name="oasis_activities_permitted_other" value=""><br>
					</td>
				</tr>
			</table>
			<br />

</td>

<td>
<strong><?php xl("<u>(M1910)</u>","e");?></strong>
			<?php xl("Has this patient had a multi-factor <strong>Fall Risk Assessment</strong> (such as falls history, use of multiple medications, mental impairment, toileting frequency, general mobility/transferring impairment, environmental hazards)?","e");?><br />
			<label><input type="radio" name="oasis_adl_fall_risk_assessment" value="0" checked><?php xl(' 0 - No multi-factor falls risk assessment conducted.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_fall_risk_assessment" value="1"><?php xl(' 1 - Yes, and it does not indicate a risk for falls.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_fall_risk_assessment" value="2"><?php xl(' 2 - Yes, and it indicates a risk for falls.','e')?></label> <br>
			<br /><hr />
			
			<center><strong><?php xl("MEDICATIONS","e");?></strong></center><br />
			<strong><?php xl("<u>(M2000)</u>","e");?></strong>
			<?php xl("<strong>Drug Regimen Review:</strong> Does a complete drug regimen review indicate potential clinically significant medication issues, e.g., drug reactions, ineffective drug therapy, side effects, drug interactions, duplicate therapy, omissions, dosage errors, or noncompliance?","e");?><br />
			<label><input type="radio" name="oasis_adl_drug_regimen" value="0" checked><?php xl(' 0 - Not assessed/reviewed <strong><i>[Go to M2010]</i></strong>','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_drug_regimen" value="1"><?php xl(' 1 - No problems found during review <strong><i>[Go to M2010]</i></strong>','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_drug_regimen" value="2"><?php xl(' 2 - Problems found during review','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_drug_regimen" value="NA"><?php xl(' NA - Patient is not taking any medications <strong><i>[Go to M2040]</i></strong>','e')?></label> <br>
			<br /><hr />
			
			<strong><?php xl("<u>(M2002)</u>","e");?></strong>
			<?php xl("<strong>Medication Follow-up:</strong> Was a physician or the physician-designee contacted within one calendar day to resolve clinically significant medication issues, including reconciliation?","e");?><br />
			<label><input type="radio" name="oasis_adl_medication_follow_up" value="0"><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_medication_follow_up" value="1"><?php xl(' 1 - Yes','e')?></label> <br>
			<br /><hr />
			
			<strong><?php xl("<u>(M2010)</u>","e");?></strong>
			<?php xl("<strong>Patient/Caregiver High Risk Drug Education:</strong> Has the patient/caregiver received instruction on special precautions for all high-risk medications (such as hypoglycemics, anticoagulants, etc.) and how and when to report problems that may occur?","e");?><br />
			<label><input type="radio" id="m2010" name="oasis_adl_patient_caregiver" value="0"><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_patient_caregiver" value="1"><?php xl(' 1 - Yes','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_patient_caregiver" value="NA"><?php xl(' NA - Patient not taking any high risk drugs OR patient/caregiver fully knowledgeable about special precautions associated with all high-risk medications','e')?></label> <br>
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
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="0"><?php xl(' 0 - Able to independently take the correct oral medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="1"><?php xl(' 1 - Able to take medication(s) at the correct times if:<br />(a) individual dosages are prepared in advance by another person; <u>OR</u><br />(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="2"><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person at the appropriate times','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="3"><?php xl(' 3 - <u>Unable</u> to take medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_oral_medications" value="NA"><?php xl(' NA - No oral medications prescribed.','e')?></label> <br>
			<br />
			<strong><?php xl("Financially able to pay for medications:","e");?></strong>
			<label><input type="checkbox" name="oasis_adl_pay_for_medications" value="Yes"><?php xl('Yes','e')?></label>
			<label><input type="checkbox" name="oasis_adl_pay_for_medications" value="No"><?php xl('No','e')?></label>
</td>

<td>
<strong><?php xl("<u>(M2030)</u>","e");?></strong>
			<?php xl("<strong>Management of Injectable Medications: </strong> <u>Patient's current ability</u> to prepare and take <u>all</u> prescribed injectable medications reliably and safely, including administration of correct dosage at the appropriate times/intervals. <strong><u>Excludes</u> IV medications.</strong>","e");?><br />
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="0"><?php xl(' 0 - Able to independently take the correct oral medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="1"><?php xl(' 1 - Able to take medication(s) at the correct times if:<br />(a) individual dosages are prepared in advance by another person; <u>OR</u><br />(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="2"><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person based on the frequency of the injection','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="3"><?php xl(' 3 - <u>Unable</u> to take injectable medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_management_injectable_medications" value="NA"><?php xl(' NA - No injectable medications prescribed.','e')?></label> <br>
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
<label><input type="radio" id="m2040" name="oasis_adl_func_oral_med" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_func_oral_med" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_func_oral_med" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_func_oral_med" value="na"><?php xl(' na','e')?></label> <br>
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
<label><input type="radio" name="oasis_adl_inject_med" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_inject_med" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_inject_med" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_adl_inject_med" value="na"><?php xl(' na','e')?></label> <br>
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
<!-- *********************  Care Management &amp; Therapy Need And Plan Of Care   ******************** -->
                        <li>

<table class="formtable" width="100%" border="1">
	
	<tr>
		<td> 
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
<label><input type="radio" name="oasis_care_adl_assistance" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="3"><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="4"><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_adl_assistance" value="5"><?php xl(' 5','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_iadl_assistance" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="3"><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="4"><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_iadl_assistance" value="5"><?php xl(' 5','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_medication_admin" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="3"><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="4"><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medication_admin" value="5"><?php xl(' 5','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_medical_procedures" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="3"><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="4"><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_medical_procedures" value="5"><?php xl(' 5','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_management_equip" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="3"><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="4"><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_management_equip" value="5"><?php xl(' 5','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_supervision_safety" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="3"><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="4"><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_supervision_safety" value="5"><?php xl(' 5','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="2"><?php xl(' 2','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="3"><?php xl(' 3','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="4"><?php xl(' 4','e')?></label> <br>
</td>
<td align="center">
<label><input type="radio" name="oasis_care_advocacy_facilitation" value="5"><?php xl(' 5','e')?></label> <br>
</td>
</tr>
</table>


	</td>
	</tr>
	
	
	<tr>
	<td>
	<strong><?php xl("<u>(M2110)</u>","e");?></strong>
			<?php xl("<strong>How Often </strong> does the patient receive <strong>ADL or IADL assistance</strong> from any caregiver(s) (other than home health agency staff)?","e");?><br />
			<label><input type="radio" name="oasis_care_how_often" value="1" checked><?php xl(' 1 - At least daily','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="2"><?php xl(' 2 - Three or more times per week','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="3"><?php xl(' 3 - One to two times per week','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="4"><?php xl(' 4 - Received, but less often than weekly','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="5"><?php xl(' 5 - No assistance received','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="UK"><?php xl(' UK - Unknown <strong>[Omit "UK" option on DC]</strong>','e')?></label> <br>
			<br />
			<br />
			<br />
			
			
			<center><strong><?php xl("THERAPY NEED AND PLAN OF CARE","e");?></strong></center>
			<?php xl("<strong><u>(M2200)</u> Therapy Need:</strong> In the home health plan of care for the Medicare payment episode for which this assessment will define a case mix group, what is the indicated need for therapy visits (total of reasonable and necessary physical, occupational, and speech-language pathology visits combined)?<strong>( Enter zero [ \"000\" ] if no therapy visits indicated.)</strong>","e");?><br /> 
			<label><input type="text" name="oasis_care_therapy_visits" value="" size="5"><?php xl(' - Number of therapy visits indicated (total of physical, occupational and speech-language pathology combined).','e')?></label>
			<br />
			<label><input type="checkbox" name="oasis_care_therapy_need_applicable" value="NA"><?php xl(' NA - Not Applicable: No case mix group defined by this assessment.','e')?></label> <br>

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
<label><input type="radio" name="oasis_care_patient_parameter" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_patient_parameter" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td width="10%">
<label><input type="radio" name="oasis_care_patient_parameter" value="na"><?php xl(' na','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_diabetic_foot_care" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_diabetic_foot_care" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_diabetic_foot_care" value="na"><?php xl(' na','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_falls_prevention" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_falls_prevention" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_falls_prevention" value="na"><?php xl(' na','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_depression_intervention" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_depression_intervention" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_depression_intervention" value="na"><?php xl(' na','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_intervention_monitor" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_monitor" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_monitor" value="na"><?php xl(' na','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_intervention_prevent" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_prevent" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_intervention_prevent" value="na"><?php xl(' na','e')?></label> <br>
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
<label><input type="radio" name="oasis_care_pressure_ulcer" value="0" checked><?php xl(' 0','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_pressure_ulcer" value="1"><?php xl(' 1','e')?></label> <br>
</td>
<td>
<label><input type="radio" name="oasis_care_pressure_ulcer" value="na"><?php xl(' na','e')?></label> <br>
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
<label><input type="checkbox" name="oasis_homebound_status[]" value="Needs assistance for all activities"><?php xl('Needs assistance for all activities','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Residual weakness"><?php xl('Residual weakness','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Requires assistance to ambulate"><?php xl('Requires assistance to ambulate','e')?></label><br>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Confusion, unable to go out of home alone"><?php xl('Confusion, unable to go out of home alone','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Unable to safely leave home unassisted"><?php xl('Unable to safely leave home unassisted','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Medical restrictions"><?php xl('Medical restrictions','e')?></label><br>
</td>
</tr>


<tr>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Bed Bound"><?php xl('Bed Bound','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="SOB"><?php xl('SOB','e')?></label><br>
</td>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Pain"><?php xl('Pain','e')?></label><br>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_homebound_status[]" value="Arrhythmia"><?php xl('Arrhythmia','e')?></label>
</td>
<td colspan="3">
<label><input type="checkbox" name="oasis_homebound_status[]" value="Other:"><?php xl('Other:','e')?></label>
<input type="text" name="oasis_homebound_status_other" value="">
</td>
</tr>


<tr>
<td colspan="3">
<label><input type="checkbox" name="oasis_homebound_status[]" value="Ambulation limited to"><?php xl('Ambulation limited to','e')?></label>
<input type="text" name="oasis_homebound_status_ambulation" value="" size="4"><?php xl(' ft. with assist of ','e')?>
<input type="text" name="oasis_homebound_status_assist" value="" size="5"><?php xl(' (device) due to ','e')?>
<input type="text" name="oasis_homebound_status_due_to" value="">
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
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Rights and responsibilities"><?php xl('Rights and responsibilities','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Do not resuscitate (DNR)"><?php xl('Do not resuscitate (DNR)','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="HIPAA Notice of Privacy Practices"><?php xl('HIPAA Notice of Privacy Practices','e')?></label>
</td>
<td width="28%">
<label><input type="checkbox" name="oasis_instructions_materials[]" value="When to contact physician and/or agency"><?php xl('When to contact physician and/or agency','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Disease Info"><?php xl('Disease Info','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Medication regimen/administration"><?php xl('Medication regimen/administration','e')?></label>
</td>
<td width="27%">
<label><input type="checkbox" name="oasis_instructions_materials[]" value="State hotline number"><?php xl('State hotline number','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Advance Directives"><?php xl('Advance Directives','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="OASIS Privacy Notice"><?php xl('OASIS Privacy Notice','e')?></label>
</td>
<td>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Standard precautions/hand washing"><?php xl('Standard precautions/hand washing','e')?></label><br>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Basic home safety"><?php xl('Basic home safety','e')?></label>
</td>
</tr>

<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Emergency planning in the event service is disrupted"><?php xl('Emergency planning in the event service is disrupted','e')?></label>
</td>
<td>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Agency phone number/after hours number"><?php xl('Agency phone number/after hours number','e')?></label>
</td>
<td>
<label><input type="checkbox" name="oasis_instructions_materials[]" value="Others"><?php xl('Others','e')?></label>
<input type="text" name="oasis_instructions_materials_other" id="oasis_instructions_materials_other" size="15" />
</td>  
</tr>

</table>


<strong><?php xl('Skilled care/Instructions provided this visit:','e')?></strong><br />
<textarea name="oasis_instructions_skilled_care" rows="3" cols="98"></textarea><br>

<strong><?php xl('Care coordinated with:','e')?></strong>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="CM"><?php xl('CM','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Physician"><?php xl('Physician','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="RN"><?php xl('RN','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="PT"><?php xl('PT','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="OT"><?php xl('OT','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="ST"><?php xl('ST','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="MSW"><?php xl('MSW','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="HHA"><?php xl('HHA','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="RD"><?php xl('RD','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Caregiver"><?php xl('Caregiver','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Family"><?php xl('Family','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Pharmacy"><?php xl('Pharmacy','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="DME/Medical Supplier"><?php xl('DME/Medical Supplier','e')?></label>
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Nursing Supervisor"><?php xl('Nursing Supervisor','e')?></label><br />
<label><input type="checkbox" name="oasis_instructions_care_coordinated[]" value="Other:"><?php xl('Other:','e')?></label>
<input type="text" name="oasis_instructions_care_coordinated_other" id="oasis_instructions_care_coordinated_other" size="50" /><br />

<?php xl('Topic:','e')?>
<input type="text" name="oasis_instructions_topic" id="oasis_instructions_topic" size="50" /><br />


<?php xl('Patient has the following :','e')?>
<?php xl('Living Will:','e')?>
<label><input type="radio" name="oasis_instructions_living_will" value="Yes"><?php xl(' Yes','e')?></label>
<label><input type="radio" name="oasis_instructions_living_will" value="No"><?php xl(' No','e')?></label> <br>

<?php xl('Copies located at:','e')?>
<label><input type="checkbox" name="oasis_instructions_copies_located[]" value="Patient Home"><?php xl('Patient Home','e')?></label>
<label><input type="checkbox" name="oasis_instructions_copies_located[]" value="Agency"><?php xl('Agency','e')?></label>
<label><input type="checkbox" name="oasis_instructions_copies_located[]" value="Family Member"><?php xl('Family Member','e')?></label>
<br />
<?php xl('Bill of Rights signed:','e')?>
<label><input type="radio" name="oasis_instructions_bill_of_rights" value="Yes"><?php xl(' Yes','e')?></label>
<label><input type="radio" name="oasis_instructions_bill_of_rights" value="No"><?php xl(' No','e')?></label>
&nbsp;&nbsp;&nbsp;
<?php xl('Patient:','e')?>
<label><input type="radio" name="oasis_instructions_patient" value="Understands"><?php xl(' Understands','e')?></label>
<label><input type="radio" name="oasis_instructions_patient" value="May not understand (explain)"><?php xl(' May not understand (explain)','e')?></label>
<input type="text" name="oasis_instructions_not_understand" />



<table class="formtable" border="0">
					<tr>
						<td colspan="4" align="center">
						<br />
							<strong><?php xl("DME/MEDICAL SUPPLIES ","e");?></strong>
							<label><input type="checkbox" name="oasis_dme" value="NA"><?php xl('NA','e')?></label>
						</td>
					</tr>
					<tr valign="top">
						<td>
							<strong><?php xl("WOUND CARE: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="2x2s"><?php xl('2x2s','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="4x4s"><?php xl('4x4s','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="ABDs"><?php xl('ABDs','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Cotton tipped applicators"><?php xl('Cotton tipped applicators','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Wound cleanser"><?php xl('Wound cleanser','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Wound gel"><?php xl('Wound gel','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Drain sponges"><?php xl('Drain sponges','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Gloves:"><?php xl('Gloves:','e')?></label>
								<label><input type="checkbox" name="oasis_dme_wound_care_glove" value="Sterile"><?php xl('Sterile','e')?></label>
								<label><input type="checkbox" name="oasis_dme_wound_care_glove" value="Non-Sterile"><?php xl('Non-Sterile','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Hydrocolloids"><?php xl('Hydrocolloids','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Kerlix size"><?php xl('Kerlix size','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Nu-gauze"><?php xl('Nu-gauze','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Saline"><?php xl('Saline','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Tape"><?php xl('Tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Transparent Dressings"><?php xl('Transparent Dressings','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_wound_care[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_wound_care_other" value=""><br><br>
								
							<strong><?php xl("DIABETIC: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_diabetic[]" value="Chemstrips"><?php xl('Chemstrips','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_diabetic[]" value="Syringes"><?php xl('Syringes','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_diabetic[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_diabetic_other" value=""><br><br>
						</td>
						<td>
							<strong><?php xl("IV SUPPLIES: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV start kit"><?php xl('IV start kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV pole"><?php xl('IV pole','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="IV tubing"><?php xl('IV tubing','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Alcohol swabs"><?php xl('Alcohol swabs','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Angiocatheter size"><?php xl('Angiocatheter size','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Tape"><?php xl('Tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Extension tubings"><?php xl('Extension tubings','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Injection caps"><?php xl('Injection caps','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Central line dressing"><?php xl('Central line dressing','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Infusion pump"><?php xl('Infusion pump','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Batteries size"><?php xl('Batteries size','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Syringes size"><?php xl('Syringes size','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_iv_supplies[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_iv_supplies_other" value=""><br><br>
							
							<strong><?php xl("FOLEY SUPPLIES: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Fr catheter kit"><?php xl('Fr catheter kit','e')?></label><br>
							<?php xl("(tray, bag, foley) ","e");?><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Straight catheter"><?php xl('Straight catheter','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Irrigation tray"><?php xl('Irrigation tray','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Saline"><?php xl('Saline','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Acetic acid"><?php xl('Acetic acid','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Other"><?php xl('Other','e')?></label><br>
								<input type="text" name="oasis_dme_foley_supplies_other" value=""><br><br>
						</td>
						<td>
							<strong><?php xl("URINARY/OSTOMY: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Underpads"><?php xl('Underpads','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="External catheters"><?php xl('External catheters','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Urinary bag/pouch"><?php xl('Urinary bag/pouch','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Ostomy pouch (brand, size)"><?php xl('Ostomy pouch (brand, size)','e')?></label><br>
							<input type="text" name="oasis_dme_ostomy_pouch_brand" value="" size="7">
							<input type="text" name="oasis_dme_ostomy_pouch_size" value="" size="7"><br />
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Ostomy wafer (brand, size)"><?php xl('Ostomy wafer (brand, size)','e')?></label><br>
							<input type="text" name="oasis_dme_ostomy_wafer_brand" value="" size="7">
							<input type="text" name="oasis_dme_ostomy_wafer_size" value="" size="7"><br />
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Stoma adhesive tape"><?php xl('Stoma adhesive tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Skin protectant"><?php xl('Skin protectant','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_urinary[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_urinary_other" value=""><br><br>
							
							<strong><?php xl("MISCELLANEOUS: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Enema supplies"><?php xl('Enema supplies','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Feeding tube"><?php xl('Feeding tube:','e')?></label><br>
							<?php xl('type','e')?><input type="text" name="oasis_dme_miscellaneous_type" value="" size="7">
							<?php xl('size','e')?><input type="text" name="oasis_dme_miscellaneous_size" value="" size="7"><br />
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Suture removal kit"><?php xl('Suture removal kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Staple removal kit"><?php xl('Staple removal kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Steri strips"><?php xl('Steri strips','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_miscellaneous[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_dme_miscellaneous_other" value=""><br>
						</td>
						<td>
							<strong><?php xl("SUPPLIES/EQUIPMENT: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Bathbench"><?php xl('Bathbench','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Cane"><?php xl('Cane','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Commode"><?php xl('Commode','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Special mattress overlay"><?php xl('Special mattress overlay','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Pressure relieving device"><?php xl('Pressure relieving device','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Eggcrate"><?php xl('Eggcrate','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Hospital bed"><?php xl('Hospital bed','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Hoyer lift"><?php xl('Hoyer lift','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Enteral feeding pump"><?php xl('Enteral feeding pump','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Nebulizer"><?php xl('Nebulizer','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Oxygen concentrator"><?php xl('Oxygen concentrator','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Suction machine"><?php xl('Suction machine','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Ventilator"><?php xl('Ventilator','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Walker"><?php xl('Walker','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Wheelchair"><?php xl('Wheelchair','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Tens unit"><?php xl('Tens unit','e')?></label><br>
							<label><input type="checkbox" name="oasis_dme_supplies[]" value="Other"><?php xl('Other:','e')?></label>
								<input type="text" name="oasis_dme_supplies_other" value=""><br>
						</td>
					</tr>
			</table>


<br />
<br />
<hr />


<strong><?php xl("DISCHARGE PLAN:","e");?></strong>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Assist Pt/Cg in attaining goals & DC"><?php xl('Assist Pt/Cg in attaining goals & DC','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Physician Supervision"><?php xl('Physician Supervision','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Cg Assistance"><?php xl('Cg Assistance','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Long Term Care"><?php xl('Long Term Care','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="ADHC"><?php xl('ADHC','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Nursing Home Placement"><?php xl('Nursing Home Placement','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Transfer to Hospice"><?php xl('Transfer to Hospice','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Ongoing Skilled Nursing - Tube Changes"><?php xl('Ongoing Skilled Nursing - Tube Changes','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan[]" value="Other"><?php xl('Other','e')?></label>
				<input type="text" name="oasis_discharge_plan_other" value=""><br />
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Patient to be discharged when skilled care no longer needed"><?php xl('Patient to be discharged when skilled care no longer needed','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Patient to be discharged to the care of"><?php xl('Patient to be discharged to the care of:','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Self"><?php xl('Self','e')?></label>
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Caregiver"><?php xl('Caregiver','e')?></label>
			<br />
			<label><input type="checkbox" name="oasis_discharge_plan_detail[]" value="Other"><?php xl('Other:','e')?></label>
<input type="text" name="oasis_discharge_plan_detail_other" value="">

<br />
<center><strong><?php xl("APPLIANCES/SPECIAL EQUIPMENT/ORGANIZATIONS","e");?></strong></center>

<table width="100%" border="0" class="formtable">
<tr>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Brace/Orthotics(specify)"><?php xl('Brace/Orthotics(specify)','e')?></label>
<input type="text" name="oasis_appliances_brace" value="">
</td>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Transfer equipment: Board/Lift"><?php xl('Transfer equipment: Board/Lift','e')?></label>
</td>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Bedside commode"><?php xl('Bedside commode','e')?></label>
</td>
</tr>


<tr>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Prosthesis: RUE/RLE/LUE/LLE/Other"><?php xl('Prosthesis: RUE/RLE/LUE/LLE/Other','e')?></label>
</td>
<td colspan="2">
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Grab bars: Bathroom/Other"><?php xl('Grab bars: Bathroom/Other','e')?></label>
</td>
</tr>


<tr>
<td>
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Hospital bed: Semi-elec /Crank/Spec."><?php xl('Hospital bed: Semi-elec /Crank/Spec.','e')?></label>
</td>
<td colspan="2">
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Lifeline"><?php xl('Lifeline','e')?></label>
</td>
</tr>

<tr>
<td colspan="3">
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Needs (specify)"><?php xl('Needs (specify)','e')?></label>
<br />
<textarea name="oasis_appliances_equipments_needs" rows="3" cols="98"></textarea>
</td>
</tr>

</table>


<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Oxygen:"><?php xl('Oxygen:','e')?></label>
<?php xl('  HME Co','e')?>
<input type="text" name="oasis_appliances_equipments_HME_co" value="" size="10">
<?php xl('  HME Rep','e')?>
<input type="text" name="oasis_appliances_equipments_HME_rep" value="" size="10">
<?php xl('  Phone','e')?>
<input type="text" name="oasis_appliances_equipments_phone" value="" size="20">
<br />
<label><input type="checkbox" name="oasis_appliances_equipments[]" value="Other organization providing service:"><?php xl('Other organization providing service:','e')?></label>
<br />
<textarea name="oasis_appliances_equipments_other_organizations" rows="3" cols="98"></textarea>


	</td>
	</tr>
	
	
	
	
</table>
				</li>
			</ul>
		</li>


		
		
		
		
<li>
	<div><a href="#" id="black">Professional Services</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			                    <ul>
				<li>



<h3 align="center"><?php xl('PROFESSIONAL SERVICES','e')?></h3>	


<table class="formtable" border="1">
<tr>
	<td colspan="2" align="center">
		<center><strong><?php xl("UTILIZE THIS SECTION TO ASSIST WITH COMPLETION OF THE 485 (OPTIONAL)","e");?></strong></center>
	</td>
</tr>
<tr>
	<td width="50%">
		<strong><?php xl("VITAL SIGNS PARAMETER","e");?></strong><br />
		<label><input type="radio" name="oasis_professional_vital_signs" value="Standard Protocol (will auto-fill text)"><?php xl(' Standard Protocol (will auto-fill text)','e')?></label>
		<label><input type="radio" name="oasis_professional_vital_signs" value="Special MD Orders"><?php xl(' Special MD Orders','e')?></label>	
	</td>
	<td>
		<strong><?php xl("SN TO PROVIDE SKILLED NURSING VISITS FOR:","e");?></strong>
		<input type="text" name="oasis_professional_sn" value="" size="50">
	</td>
</tr>
<tr valign="top">

	<td>
	
	
	<table class="formtable" border="1">
	<tr>
	<td width="30%">
	<label><input type="checkbox" name="oasis_professional_vital_parameter[]" value="Heart Rate/Pulse:"><?php xl('Heart Rate/Pulse:','e')?></label>
	</td>
	<td>
	<?php xl('Notify MD if heart rate','e')?>
	</td>
	<td>
	<input type="text" name="oasis_professional_heart_rate0" value="" size="3">
	<?php xl('> or <','e')?><input type="text" name="oasis_professional_heart_rate" value="" size="3">
	</td>
	</tr>
	<tr>
	<td>
	<label><input type="checkbox" name="oasis_professional_vital_parameter[]" value="Temperature:"><?php xl('Temperature:','e')?></label>
	</td>
	<td>
	<?php xl('Notify MD if temperature','e')?>
	</td>
	<td>
	<input type="text" name="oasis_professional_temperature0" value="" size="3">
	<?php xl('> or <','e')?><input type="text" name="oasis_professional_temperature" value="" size="3">
	</td>
	</tr>
	<tr>
	<td>
	<label><input type="checkbox" name="oasis_professional_vital_parameter[]" value="Blood Pressure:"><?php xl('Blood Pressure:','e')?></label>
	</td>
	<td align="right">
	<?php xl('Notify MD if &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; systolic','e')?>
	</td>
	<td>
	<input type="text" name="oasis_professional_BP_systolic0" value="" size="3">
	<?php xl('> or <','e')?><input type="text" name="oasis_professional_BP_systolic" value="" size="3">
	</td>
	</tr>
	<tr>
	<td>&nbsp;
	
	</td>
	<td align="right">
	<?php xl('diastolic','e')?>
	</td>
	<td>
	<input type="text" name="oasis_professional_BP_diastolic0" value="" size="3">
	<?php xl('> or <','e')?><input type="text" name="oasis_professional_BP_diastolic" value="" size="3">
	</td>
	</tr>
	<tr>
	<td>
	<label><input type="checkbox" name="oasis_professional_vital_parameter[]" value="Respirations:"><?php xl('Respirations:','e')?></label>
	</td>
	<td>
	<?php xl('Notify MD if respirations','e')?>
	</td>
	<td>
	<input type="text" name="oasis_professional_respirations0" value="" size="3">
	<?php xl('> or <','e')?><input type="text" name="oasis_professional_respirations" value="" size="3">
	</td>
	</tr>
	<tr>
	<td>
	<label><input type="checkbox" name="oasis_professional_vital_parameter[]" value="O2 sat level per random pulse oximetry:"><?php xl('O2 sat level per random pulse oximetry:','e')?></label>
	</td>
	<td>
	<?php xl('Notify MD if < 88%','e')?>
	</td>
	<td>
	<input type="text" name="oasis_professional_880" value="" size="3">
	<?php xl('> or <','e')?><input type="text" name="oasis_professional_88" value="" size="3">
	</td>
	</tr>
	
	<tr>
	<td colspan="3">
	<label><input type="checkbox" name="oasis_professional_vital_parameter[]" value="Other:"><?php xl('Other:','e')?></label>
	<input type="text" name="oasis_professional_vital_other" value="">
	</td>
	</tr>
	
	<tr>
	<td colspan="3">
	<strong><?php xl('BLOOD GLUCOSE PARAMETER','e')?></strong><br />
	<label><input type="radio" name="oasis_professional_blood_glucose" value="Standard Protocol (will auto-fill text)"><?php xl(' Standard Protocol (will auto-fill text)','e')?></label>
	<label><input type="radio" name="oasis_professional_blood_glucose" value="Special MD Orders"><?php xl(' Special MD Orders','e')?></label>
	</td>
	</tr>
	
	
	<tr>
	<td colspan="3">
	<label><input type="checkbox" name="oasis_professional_vital_parameter[]" value="Blood/Glucose:">
	<?php xl('Blood/Glucose: Notify MD if BS is > ','e')?></label>
	<input type="text" name="oasis_professional_blood_glucose_BS_gt" value="" size="3">
	<?php xl('or < ','e')?>
	<input type="text" name="oasis_professional_blood_glucose_BS_lt" value="" size="3">
	</td>
	</tr>
	
	<tr>
	<td colspan="3">
	<?php xl('May receive orders from:','e')?>
	<input type="text" name="oasis_professional_receive_orders_from" value="">
	</td>
	</tr>
	</table>
		
	</td>
	
	<td>
	
	<label><input type="checkbox" name="oasis_professional_sn_parameters[]" value="RESPIRATORY / MEDICAL CASES"><?php xl('<strong>RESPIRATORY / MEDICAL CASES</strong>','e')?></label><br />
	<label><input type="checkbox" name="oasis_professional_sn_parameters[]" value="O2 at liters per minute"><?php xl('O2 at liters per minute','e')?></label><br />
	<label><input type="radio" name="oasis_professional_sn1" value="Continuous"><?php xl(' Continuous','e')?></label>
	<label><input type="radio" name="oasis_professional_sn1" value="Intermittent"><?php xl(' Intermittent','e')?></label>
	<label><input type="radio" name="oasis_professional_sn1" value="PRN"><?php xl(' PRN','e')?></label><br />
	<label><input type="radio" name="oasis_professional_sn2" value="Pulse Oximetry: Every Visit"><?php xl(' Pulse Oximetry: Every Visit','e')?></label>
	<input type="text" name="oasis_professional_sn_every_visit" value=""><br />
	<label><input type="radio" name="oasis_professional_sn2" value="Pulse Oximetry: PRN Dyspnea"><?php xl(' Pulse Oximetry: PRN Dyspnea','e')?></label>
	<br />
	<textarea name="oasis_professional_sn_PRN_dyspnea" rows="3" cols="48"></textarea>
	<br />
	<label><input type="checkbox" name="oasis_professional_sn_parameters[]" value="Teach Oxygen Use / Precautions"><?php xl('Teach Oxygen Use / Precautions','e')?></label><br />
	<label><input type="checkbox" name="oasis_professional_sn_parameters[]" value="Teach Trach Care"><?php xl('Teach Trach Care','e')?></label><br />
	<label><input type="checkbox" name="oasis_professional_sn_parameters[]" value="Administer Trach Care"><?php xl('Administer Trach Care','e')?></label><br />
	<label><input type="checkbox" name="oasis_professional_sn_parameters[]" value="Other:"><?php xl('Other:','e')?></label>
	<input type="text" name="oasis_professional_sn_other" value="">
	</td>


</tr>
<tr>
<td colspan="2">
<center><strong><?php xl("SKILLED NURSE TO PROVIDE SKILLED NURSING VISITS FOR:","e");?></strong></center>

	<table class="formtable" border="1">
	<tr>
	<td>&nbsp;
	
	</td>
	<td colspan="2" align="center">
	<strong><?php xl(' GOALS','e')?></strong>
	</td>
	</tr>
	
	
	<tr>
	<td>
	<strong><?php xl('SN FREQUENCY/DURATION','e')?></strong><br />
	<label><input type="checkbox" name="oasis_professional_sn_frequency[]" value="+ 2 PRN Visits For"><?php xl('+ 2 PRN Visits For','e')?></label><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="oasis_professional_sn_frequency[]" value="IV Complications"><?php xl('IV Complications','e')?></label><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="oasis_professional_sn_frequency[]" value="Tube Feeding Complications"><?php xl('Tube Feeding Complications','e')?></label><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="oasis_professional_sn_frequency[]" value="Tracheostomy Care Complications"><?php xl('Tracheostomy Care Complications','e')?></label><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="oasis_professional_sn_frequency[]" value="Catheter Care Complications"><?php xl('Catheter Care Complications','e')?></label><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="oasis_professional_sn_frequency[]" value="Wound Care Complications"><?php xl('Wound Care Complications','e')?></label><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="oasis_professional_sn_frequency[]" value="Ostomy Care Complications"><?php xl('Ostomy Care Complications','e')?></label><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="oasis_professional_sn_frequency[]" value="Other"><?php xl('Other','e')?></label>
	<input type="text" name="oasis_professional_sn_frequency_other" value="">
	</td>
	
	<td valign="top">
	<label><input type="checkbox" name="oasis_professional_goals[]" value="OBSERVATION AND ASSESSMENT OF THE PATIENT CONDITION">
	<?php xl('<strong><u>OBSERVATION AND ASSESSMENT OF THE PATIENT\'S CONDITION</u></strong> (when there is a likelihood of a change in the patient\'s condition)','e')?>
	</label><br />
	</td>
	
	<td valign="top">
	<?php xl('Patient\'s clinical distress will be managed by reducing and or limiting symptoms through skilled nursing\'s identification of changes in condition and timely treatment modifications.','e')?>
	</td>
	</tr>
	
	
	<tr>
	<td>
	<strong><?php xl('SN TO PROVIDE SKILLED NURSING VISITS FOR:','e')?></strong><br />
	<label><input type="checkbox" name="oasis_professional_sn_provide[]" value="Management of disease process"><?php xl('Management of disease process to include (refer to page 3 of Oasis - M1020). Assess vital signs and all body systems, knowledge of disease process and its associated care and treatment, medication, regimen, knowledge, and S/S of complications necessitating medical attention.','e')?></label><br />
	<label><input type="checkbox" name="oasis_professional_sn_provide[]" value="Evaluate Cardiopulmonary Status"><?php xl('Evaluate Cardiopulmonary Status','e')?></label><br />
	<label><input type="checkbox" name="oasis_professional_sn_provide[]" value="Evaluate Nutrition/Hydration/Elimination"><?php xl('Evaluate Nutrition/Hydration/Elimination','e')?></label><br />
	<label><input type="checkbox" name="oasis_professional_sn_provide[]" value="Evaluate for S/S of Infections"><?php xl('Evaluate for S/S of Infections','e')?></label><br />
	<label><input type="checkbox" name="oasis_professional_sn_provide[]" value="Teach Disease Process"><?php xl('Teach Disease Process','e')?></label><br />
	</td>
	<td valign="top">
	<label><input type="checkbox" name="oasis_professional_goals[]" value="MANAGEMENT AND EVALUATION OF THE PATIENT CARE PLAN">
	<?php xl('<strong><u>MANAGEMENT AND EVALUATION OF THE PATIENT CARE PLAN</u></strong> (where underlying conditions or complications require that only a Registered Nurse can ensure that essential non skilled care is achieving its purpose).','e')?></label><br />
	</td>
	<td valign="top">
	<?php xl('Patient\'s essential non skilled care will achieve its purpose safely, adequately and correctly through skilled nursing interventions that manage and treat underlying conditions and complications to promote recovery and medical safety in view of the patient\'s overall condition.','e')?>
	</td>
	</tr>
	</table>


</td>


</tr>

<tr>
<td align="center">
<strong><?php xl('TEACHING AND TRAINING ACTIVITIES','e')?></strong>
</td>
<td align="center">
<strong><?php xl('GOALS','e')?></strong>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Complications of disease process"><?php xl('Complications of disease process','e')?></label>
</td>
<td>
<?php xl('Patient/caregiver will verbalize the understanding of nature and complications of disease process this cert period','e')?>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Rationale for compliance with diet / activities / medications / treatment regime"><?php xl('Rationale for compliance with diet / activities / medications / treatment regime','e')?></label>
</td>
<td>
<?php xl('Patient/caregiver will verbalize and demonstrate the importance of diet, activities, medications and treatment this cert period','e')?>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Safety with activities of ADLs and/or IADLs and falls prevention"><?php xl('Safety with activities of ADLs and/or IADLs and falls prevention','e')?></label>
</td>
<td>
<?php xl('Patient/caregiver will demonstrate safety measures with ambulation, ADLs and/or IADLs, and falls prevention','e')?>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Effective hygiene care"><?php xl('Effective hygiene care','e')?></label>
</td>
<td>
<?php xl('Patient/caregiver will demonstrate effective hygiene care this cert period','e')?>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Signs and symptoms of infection"><?php xl('Signs and symptoms of infection','e')?></label>
</td>
<td>
<?php xl('The patient will be free of infection this cert period','e')?>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Effective pain management"><?php xl('Effective pain management','e')?></label>
</td>
<td>
<?php xl('Patient/caregiver will demonstrate effective pain control at the patient\'s own comfort level as verbalized by patient/caregiver this cert period','e')?>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Wound care using aseptic technique"><?php xl('Wound care using aseptic technique','e')?></label>
</td>
<td>
<?php xl('Patient/caregiver will verbalize and demonstrate effective wound care application while observing proper aseptic technique by the end of this cert period','e')?>
</td>
</tr>

<tr>
<td align="right">
<input type="checkbox" name="oasis_professional_teaching_activities[]" value="The patient wound site will be decreased to % by the end of this cert period">
</td>
<td>
<?php xl('The patient\'s wound site will be decreased to ','e')?>
<input type="text" name="oasis_professional_decreased_to" value="" size="10">
<?php xl('% by the end of this cert period','e')?>
</td>
</tr>

<tr>
<td align="right">
<input type="checkbox" name="oasis_professional_teaching_activities[]" value="The patient wound site will be healed by the end of this cert period">
</td>
<td>
<?php xl('The patient\'s wound site will be healed by the end of this cert period','e')?>
</td>
</tr>

<tr>
<td align="right">
<input type="checkbox" name="oasis_professional_teaching_activities[]" value="The patient infection will be resolved by the end of this cert period">
</td>
<td>
<?php xl('The patient\'s infection will be resolved by the end of this cert period','e')?>
</td>
</tr>


<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Other"><?php xl('Other','e')?></label>
<input type="text" name="oasis_professional_goal_other1" value="">
</td>
<td>
<?php xl('Other:','e')?>
<input type="text" name="oasis_professional_goal_other" value="">
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Teach Pt/CG S/S of IV Complications"><?php xl('Teach Pt/CG S/S of IV Complications','e')?></label>
</td>
<td rowspan="4">
<?php xl('Patient/Caregiver will verbalize the understanding of nature, compliance, and competence of IV medication within this cert period','e')?>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Teach Pt/CG IV Site Care"><?php xl('Teach Pt/CG IV Site Care','e')?></label>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Teach Pt/CG Infusion Pump"><?php xl('Teach Pt/CG Infusion Pump','e')?></label>
</td>
</tr>

<tr>
<td>
<label><input type="checkbox" name="oasis_professional_teaching_activities[]" value="Teach Pt/CG Complete Parenteral Nutrition"><?php xl('Teach Pt/CG Complete Parenteral Nutrition','e')?></label>
</td>
</tr>

<tr>
<td colspan="2" align="center">
<strong><?php xl('SKILLED NURSE TO PROVIDE SKILLED NURSING VISITS FOR:','e')?></strong>
</td>
</tr>

<tr valign="top">
<td>
<label><input type="checkbox" name="oasis_professional_skilled_nurse1[]" value="PICC">
<strong><?php xl('PICC','e')?></strong>
</label>
<br />
<label><input type="radio" name="oasis_professional_nurse_PICC" value="Standard Protocol (will auto-fill text)"><?php xl(' Standard Protocol (will auto-fill text)','e')?></label>
<label><input type="radio" name="oasis_professional_nurse_PICC" value="Special MD Orders"><?php xl(' Special MD Orders','e')?></label><br />
<?php xl('Flush with','e')?>
<input type="text" name="oasis_PICC_socl_before" value="" size="4">

<?php xl(' CC of ','e')?>
<input type="text" name="oasis_PICC_socl_percent_before" value="" size="4">
<?php xl(' % Sodium Chloride before use,','e')?>

<input type="text" name="oasis_PICC_socl_after" value="" size="4">

<?php xl(' CC of ','e')?>
<input type="text" name="oasis_PICC_socl_percent_after" value="" size="4">
<?php xl(' % Sodium Chloride after Infusion, follow<br />with','e')?>

<input type="text" name="oasis_professional_heparin" value="" size="4">
<?php xl(' CC Heparin (100 units/ml) per Lumen<br />','e')?>

<?php xl('Dressing Change Week + PRN','e')?><input type="text" name="oasis_PICC_dressing_change" value="" size="10"><br />
<?php xl('Injections Cap Change Week + PRN','e')?><input type="text" name="oasis_PICC_injection_cap" value="" size="10"><br />
<?php xl('Extention Set Change Week + PRN','e')?><input type="text" name="oasis_PICC_extension_set" value="" size="10"><br />

<label><input type="checkbox" name="oasis_professional_skilled_nurse1[]" value="PERIPHERAL I. V.">
<strong><?php xl('PERIPHERAL I. V.','e')?></strong>
</label>
<label><input type="radio" name="oasis_professional_nurse_peripheral" value="Standard Protocol (will auto-fill text)"><?php xl(' Standard Protocol (will auto-fill text)','e')?></label>
<label><input type="radio" name="oasis_professional_nurse_peripheral" value="Special MD Orders"><?php xl(' Special MD Orders','e')?></label><br />

<?php xl('Flush with','e')?>
<input type="text" name="oasis_peripheral_socl_before" value="" size="4">

<?php xl(' CC of ','e')?>
<input type="text" name="oasis_peripheral_socl_percent_before" value="" size="4">
<?php xl(' % Sodium Chloride before use,','e')?>

<input type="text" name="oasis_peripheral_socl_after" value="" size="4">

<?php xl(' CC of ','e')?>
<input type="text" name="oasis_peripheral_socl_percent_after" value="" size="4">
<?php xl(' % Sodium Chloride after Infusion, follow<br />with','e')?>

<input type="text" name="oasis_peripheral_heparin" value="" size="4">
<?php xl(' CC Heparin (100 units/ml) per Lumen<br />','e')?>

<?php xl('Peripheral Catheters must be changed hours to hours to prevent swelling and irritation at the entrey site that can lead to infection.','e')?>
</td>
<td>
<label><input type="checkbox" name="oasis_professional_skilled_nurse1[]" value="PORT-A-CATH CARE">
<strong><?php xl('PORT-A-CATH CARE','e')?></strong>
</label>
<label><input type="radio" name="oasis_professional_nurse_port" value="Standard Protocol (will auto-fill text)"><?php xl(' Standard Protocol (will auto-fill text)','e')?></label><br />
<label><input type="radio" name="oasis_professional_nurse_port" value="Special MD Orders"><?php xl(' Special MD Orders','e')?></label><br />
<label><input type="radio" name="oasis_professional_nurse_use" value="IF IN USE, access every week."><?php xl(' <strong><u>IF IN USE,</u></strong> access every week.','e')?></label>

<?php xl('Flush with','e')?>
<input type="text" name="oasis_PORT_socl_before" value="" size="4">


<?php xl(' CC of ','e')?>
<input type="text" name="oasis_PORT_socl_percent_before" value="" size="4">
<?php xl(' % Sodium Chloride before use,','e')?>

<input type="text" name="oasis_PORT_socl_after" value="" size="4">

<?php xl(' CC of ','e')?>
<input type="text" name="oasis_PORT_socl_percent_after" value="" size="4">
<?php xl(' % Sodium Chloride after Infusion, follow<br />with','e')?>


<input type="text" name="oasis_PORT_heparin" value="" size="4">
<?php xl(' CC Heparin (100 units/ml) per Lumen<br />','e')?>

<?php xl('Dressing Change Week + PRN','e')?><input type="text" name="oasis_PORT_dressing_change" value="" size="10"><br />
<?php xl('Injections Cap Change Week + PRN','e')?><input type="text" name="oasis_PORT_injection_cap" value="" size="10"><br />
<?php xl('Extention Set Change Week + PRN','e')?><input type="text" name="oasis_PORT_extension_set" value="" size="10"><br />
<label><input type="radio" name="oasis_professional_nurse_use" value="IF NOT IN USE"><?php xl(' <strong><u>IF NOT IN USE</u></strong>, access q month and flush with','e')?></label>
<input type="text" name="oasis_access_socl_after" value="" size="4">


<?php xl(' CC of ','e')?>
<input type="text" name="oasis_access_socl_percent_after" value="" size="4">
<?php xl(' % Sodium Chloride after Infusion, follow with','e')?>


<input type="text" name="oasis_access_heparin" value="" size="4">
<?php xl(' CC Heparin (100 units/ml) per Lumen<br />','e')?>
</td>	
</tr>

<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_professional_skilled_nurse1[]" value="2 PRN Visits for IV Complications"><?php xl('2 PRN Visits for IV Complications','e')?></label>
<label><input type="checkbox" name="oasis_professional_skilled_nurse1[]" value="Anaphylaxis Protocol per M.D. Orders"><?php xl('Anaphylaxis Protocol per M.D. Orders','e')?></label>
</td>
</tr>

<tr>
<td colspan="2">
<center><strong><?php xl("SKILLED NURSE TO PROVIDE SKILLED VISITS FOR:","e");?></strong></center>
</td>
</tr>


<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_professional_skilled_nurse2[]" value="ADMINISTRATION OF MEDICATIONS (injections) TO TREAT PATIENT ILLNESS OR INJURY"><?php xl('<strong>ADMINISTRATION OF MEDICATIONS (injections) TO TREAT PATIENT\'S ILLNESS OR INJURY</strong>','e')?></label>
</td>
</tr>

<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_professional_skilled_nurse2[]" value="DNR - Do Not Resuscitate"><?php xl('<strong>DNR</strong> - Do Not Resuscitate','e')?></label><br />
<strong><?php xl('(must have MD order)','e')?></strong>
</td>
</tr>


<tr>
<td colspan="2">
<center><strong><?php xl("SN TO PROVIDE SKILLED NURSING VISITS FOR:","e");?></strong></center>
</td>
</tr>

<tr valign="top">
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="TUBE FEEDINGS">
<strong><?php xl('TUBE FEEDINGS','e')?></strong>
</label><br />
<label><input type="radio" name="oasis_professional_sn_nurse_tube" value="Nasogastric"><?php xl(' Nasogastric','e')?></label>
<label><input type="radio" name="oasis_professional_sn_nurse_tube" value="Gastrostomy"><?php xl(' Gastrostomy','e')?></label>
<label><input type="radio" name="oasis_professional_sn_nurse_tube" value="Jejunostomy"><?php xl(' Jejunostomy','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="Other (specify)"><?php xl('Other (specify)','e')?></label>
<input type="text" name="oasis_professional_sn_nurse_tube_other" value=""><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="Pump: (type / specify)"><?php xl('Pump: (type / specify)','e')?></label>
<input type="text" name="oasis_professional_sn_nurse_pump" value=""><br />
<?php xl('Feedings:','e')?>
<label><input type="checkbox" name="oasis_professional_sn_nurse_feedings" value="Bolus"><?php xl('Bolus','e')?></label>
<label><input type="checkbox" name="oasis_professional_sn_nurse_feedings" value="Continuous Rate:"><?php xl('Continuous Rate:','e')?></label>
<input type="text" name="oasis_professional_sn_nurse_continuous_rate" value="">
<br />
<?php xl('Flush Protocol: (amt./specify)','e')?>
<textarea name="oasis_professional_flush_protocol" rows="3" cols="48"></textarea><br>
<?php xl('Formula','e')?>
<input type="text" name="oasis_professional_formula" value=""><br />
<?php xl('Performed by:','e')?>
<label><input type="checkbox" name="oasis_sn_nurse_performed_by" value="Self"><?php xl('Self','e')?></label>
<label><input type="checkbox" name="oasis_sn_nurse_performed_by" value="RN"><?php xl('RN','e')?></label>
<label><input type="checkbox" name="oasis_sn_nurse_performed_by" value="CG"><?php xl('CG','e')?></label><br />
<label><input type="checkbox" name="oasis_sn_nurse_performed_by" value="Other"><?php xl('Other','e')?></label>
<input type="text" name="oasis_sn_nurse_performed_by_other" value="">
<br />
<?php xl('Dressing/Site care: (specify)','e')?>
<input type="text" name="oasis_sn_nurse_dressing" value="">
<br />
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="Other"><?php xl('Other','e')?></label>
<input type="text" name="oasis_sn_nurse_dressing_other" value="">
</td>

<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="WOUND CARE (See Initial Visit)"><?php xl('<strong>WOUND CARE</strong> (See Initial Visit)','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="Evaluate Wounds / Decubs Weekly"><?php xl('Evaluate Wounds / Decubs Weekly','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="Teach pt/cg Wound Care / Dressing change"><?php xl('Teach pt/cg Wound Care / Dressing change','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="Wound Vac (protocol):"><?php xl('Wound Vac (protocol):','e')?></label><br />
<input type="text" name="oasis_sn_nurse_wound_vac" value=""><br />
<?php xl('Using aseptic technique, irrigate with Normal Saline, pat dry, pack with black sponge and
white foam to tunneling, cover with transparent dressing, occlude with trac pad, connect to
125 mm/Hg continuous suction, Q visit','e')?><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse[]" value="Other"><?php xl('Other','e')?></label>
<input type="text" name="oasis_sn_nurse_dressing_other1" value="">
</td>

</tr>



</table>


                        </li>
                    </ul>
                </li>



<li>
	<div><a href="#" id="black">Skilled Nurse To Provide Skilled Nursing Visits, HHA, MSW</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			                    <ul>
				<li>
<table class="formtable" border="1">
<tr>
	<td colspan="2" align="center">
	<strong><?php xl('SKILLED NURSE TO PROVIDE SKILLED NURSING VISITS FOR (CONT)','e')?></strong>
	</td>
</tr>
<tr>
<td width="50%" align="center">
<strong><?php xl('SN TO PROVIDE SKILLED NURSING VISITS FOR:','e')?></strong>
</td>
<td align="center">
<strong><?php xl('SN TO PROVIDE SKILLED NURSING VISITS FOR:','e')?></strong>
</td>
</tr>

<tr valign="top">
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse1[]" value="NASOPHARYNGAL AND TRACHEOSTOMY ASPIRATION">
<strong><?php xl('NASOPHARYNGAL AND TRACHEOSTOMY ASPIRATION','e')?></strong></label><br />
</td>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse1[]" value="OSTOMY CARE"><?php xl('<strong>OSTOMY CARE</strong>','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse1[]" value="During the post-operative period and in the presence of associated complications."><?php xl('During the post-operative period and in the presence of associated complications.','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse1[]" value="Other"><?php xl('Other','e')?></label>
<input type="text" name="oasis_professional_sn_nurse1_other" value="">
<br />
</td>
</tr>

<tr>
<td align="center">
<strong><?php xl('SN TO PROVIDE SKILLED NURSING VISITS FOR:','e')?></strong>
</td>
<td align="center">
<strong><?php xl('SN TO PROVIDE SKILLED NURSING VISITS FOR:','e')?></strong>
</td>
</tr>


<tr valign="top">
<td>

<table class="formtable" border="1">
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="CATHETER CARE due to loss of bladder control"><?php xl('<strong>CATHETER CARE</strong> due to loss of bladder control','e')?></label>
<input type="text" name="oasis_professional_sn_nurse2_fr" value="" size="4">
<?php xl('Fr. with','e')?>
<input type="text" name="oasis_professional_sn_nurse2_ml" value="" size="4">
<?php xl('ml balloon','e')?>
</td>
</tr>
<tr>
<td>
<label><input type="radio" name="oasis_catheter_std_protocol" value="Standard Protocol (will auto-fill text)"><?php xl(' Standard Protocol (will auto-fill text)','e')?></label>
<label><input type="radio" name="oasis_catheter_std_protocol" value="Special MD Orders for Foley catheter"><?php xl(' Special MD Orders for Foley catheter','e')?></label>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Change Catheter Q"><?php xl('Change Catheter Q','e')?></label>
<input type="text" name="oasis_catheter_MD" value="" size="4">
<?php xl('per MD order','e')?>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Catheter Flush/Irrigation"><?php xl('Catheter Flush/Irrigation','e')?></label>
<input type="text" name="oasis_catheter_weeks" value="" size="4">
<?php xl('weeks with','e')?>
<input type="text" name="oasis_catheter_normal_saline_from" value="" size="4">
<?php xl('cc to','e')?>
<input type="text" name="oasis_catheter_normal_saline_to" value="" size="4">
<?php xl('cc of Normal Saline','e')?>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Skilled Nursing PRN">
<?php xl('Skilled Nursing PRN visits for Foley catheter problems','e')?></label>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Urinanalysis (UA)"><?php xl('Urinanalysis (UA) and Culture & Sensitivity (C&S) with monthly catheter changes & PRN','e')?></label>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Suprapubic Catheter Insertion"><?php xl('Suprapubic Catheter Insertion every','e')?></label>
<input type="text" name="oasis_catheter_insertion_weeks" value="" size="4">
<?php xl('(weeks) with','e')?>
<input type="text" name="oasis_catheter_insertion_fr" value="" size="4">
<?php xl('Fr. with','e')?>
<input type="text" name="oasis_catheter_insertion_ml" value="" size="4">
<?php xl('ml balloon.','e')?>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Teach Care of Indwelling Catheter"><?php xl('Teach Care of Indwelling Catheter','e')?></label>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Teach Self - Cath"><?php xl('Teach Self - Cath','e')?></label>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Catheter care provided by M.D."><?php xl('Catheter care provided by M.D.','e')?></label>
</td>
</tr>
<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Other"><?php xl('Other','e')?></label>
<input type="text" name="oasis_catheter_care_other" value="">
</td>
</tr>
</table>

</td>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="LABORATORY"><?php xl('<strong>LABORATORY</strong>','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Venipuncture for"><?php xl('Venipuncture for','e')?></label>
<input type="text" name="oasis_professional_sn_nurse2_venipuncture" value=""><br />
<?php xl('Frequency','e')?><input type="text" name="oasis_professional_sn_nurse2_frequency" value=""><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Other1"><?php xl('Other','e')?></label>
<input type="text" name="oasis_professional_sn_nurse2_other1" value=""><br />
<strong><?php xl('SN TO PROVIDE SKILLED NURSING VISITS FOR:','e')?></strong>
<br />
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="E. T. NURSE FOR CONSULTATION and EVAL"><?php xl('<strong>E. T. NURSE FOR CONSULTATION & EVAL</strong>','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="WOUND CARE EVALUATION"><?php xl('WOUND CARE EVALUATION','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="OSTOMY EVAL"><?php xl('OSTOMY EVAL','e')?></label><br />
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="Other2"><?php xl('Other','e')?></label>
<input type="text" name="oasis_professional_sn_nurse2_other2" value="">
</td>
</tr>

<tr>
<td colspan="2" align="center">
<strong><?php xl('HOME HEALTH AIDE/CERTIFIED NURSING ASSISTANT (HHA)','e')?></strong>
</td>
</tr>

<tr>
<td align="center">
<strong><?php xl('HHA VISIT FREQUENCY:','e')?></strong>
</td>
<td align="center">
<strong><?php xl('Goals','e')?></strong>
</td>
</tr>

<tr valign="top">
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="To provide hands-on Personal Care">
<?php xl('To provide hands-on Personal Care & assistance with patient\'s ADLs (to maintain the patient\'s
health or to facilitate treatment or to prevent deterioration of the patients health','e');?></label>
</td>
<td>
<?php xl('Patient will be able to maintain personal care and prevent deterioration of his/her health','e')?>
</td>
</tr>


<tr>
<td colspan="2" align="center">
<strong><?php xl('OTHER SERVICES ORDERED','e')?></strong>
</td>
</tr>

<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="PHYSICAL THERAPY ASSESSMENT"><?php xl('<strong>PHYSICAL THERAPY ASSESSMENT</strong> To determine further needs for P. T. services for home health related to the treatment of the patient\'s illness or injury.','e')?></label>
</td>
</tr>


<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="OCCUPATIONAL THERAPY ASSESSMENT"><?php xl('<strong>OCCUPATIONAL THERAPY ASSESSMENT</strong> To determine further needs for O. T. services for home health related to the treatment of the patient\'s illness or injury','e')?></label>
</td>
</tr>

<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="SPEECH LANGUAGE PATHLOGY ASSESSMENT"><?php xl('<strong>SPEECH LANGUAGE PATHLOGY ASSESSMENT</strong> To determine further needs for Speech Therapy services for home health related to the treatment of the patient\'s illness or injury.','e')?></label>
</td>
</tr>

<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="REGISTERED DIETICIAN ASSESSMENT"><?php xl('<strong>REGISTERED DIETICIAN ASSESSMENT</strong> To determine further needs for Dietary Nutritional Educational services for home health related to the treatment of the patient\'s illness or injury and to improve patient, family, and caregiver with knowledge related to all food groups.','e')?></label>
</td>
</tr>

<tr>
<td colspan="2" align="center">
<strong><?php xl('MEDICAL SOCIAL WORKER (MSW)','e')?></strong>
</td>
</tr>

<tr>
<td>&nbsp;

</td>
<td align="center">
<strong><?php xl('Goals','e')?></strong>
</td>
</tr>


<tr>
<td>
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="To Evaluate and or resolve patients social or emotional problems that are expected to impede the effective treatment of the patient medical condition or rate of recovery"><?php xl('To Evaluate and or resolve patients social or emotional problems that are expected to impede the effective treatment of the patient\'s medical condition or rate of recovery','e')?></label>
</td>
<td>
<?php xl('Patient\'s social and or emotional problems impeding rate of recovery and medical conditions will be limited or reduced through effective treatment by the Medical Social Worker','e')?>
</td>
</tr>

<tr>
<td colspan="2" align="center">
<strong><?php xl('ORDERS','e')?></strong>
</td>
</tr>

<tr>
<td colspan="2">
<label><input type="checkbox" name="oasis_professional_sn_nurse2[]" value="All homecare services to be placed on hold if patient is admitted to an in-patient facility and resumed when patient is discharged home from the facility."><?php xl('All homecare services to be placed on hold if patient is admitted to an in-patient facility and resumed when patient is discharged home from the facility.','e')?></label>
</td>
</tr>

<tr>
<td colspan="2">
<center><strong><?php xl('SIGNATURE/DATES','e')?></strong></center><br />
<?php xl('Patient/Caregiver (if applicable): Last Name: ','e')?>
<input type="text" name="oasis_signature_last_name" value="">
<?php xl(' First Name: ','e')?>
<input type="text" name="oasis_signature_first_name" value="">
<?php xl(' Middle Init: ','e')?>
<input type="text" name="oasis_signature_middle_init" value="">
</td>
</tr>



<tr>
<td colspan="2" align="center">
<strong><?php xl('ADDITIONAL NOTES ON SKILLED CARE PROVIDED THIS VISIT','e')?></strong>
</td>
</tr>


<tr>
<td colspan="2">
<textarea name="oasis_additional_notes" rows="10" cols="98"></textarea><br>
</td>
</tr>


</table>
				
				
				
				</li>
			</ul>
		</li>
</ul>
<!--<a id="btn_save" href="javascript:void(0)" class="link_submit"><?php xl(' [Save]','e')?></a>-->
<a id="btn_save" href="javascript:top.restoreSession();form_validation('oasis_nursing_soc');" class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color:#483D8B;"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>

</body>
</html>
