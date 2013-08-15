<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: oasis_discharge");
/* include api.inc. also required. */
require_once($GLOBALS['srcdir'].'/api.inc');
/* include our smarty derived controller class. */
require($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');
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
</head>
<body>
<form method="post"
		action="<?php echo $rootdir;?>/forms/oasis_discharge/save.php?mode=new" name="oasis_discharge">
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
						<input type="text" name="oasis_patient_caregiver" value="">
					</td>

<td align="right">
<?php xl('Start of Care Date','e');?>
<input type='text' size='12' name='oasis_patient_visit_date' id='oasis_patient_visit_date' value="<?php VisitDate(); ?>" readonly/> 

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
						<select name="time_in">
							<?php timeDropDown($GLOBALS['Selected']) ?>
						</select>
					</td>
					<td align="right">
						<?php xl('Time Out','e');?>
						<select name="time_out">
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
			<input type="text" name="oasis_therapy_cms_no" value=""><br>
			<?php xl('<u>(M0014)</u>Branch State: ','e');?>
			<input type="text" name="oasis_therapy_branch_state" value=""><br>
			<?php xl('<u>(M0016)</u> Branch ID Number: ','e');?>
			<input type="text" name="oasis_therapy_branch_id_no" value=""><br>
			<?php xl('<u>(M0018)</u> National Provider Identifier (N P I)</strong> for the attending physician who has signed the plan of care: ','e');?>
			<input type="text" name="oasis_therapy_npi" value=""><br>
			<strong>
			<label><input type="checkbox" name="oasis_therapy_npi_na" value="N/A"><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<?php xl('<u>(M0020)</u>Patient ID Number: ','e');?>
			<input type="text" name="oasis_therapy_patient_id" value="<?php patientName('pid');?>" readonly><br>
			<?php xl('<u>(M0030)</u> Start of Care Date:','e');?>
				<input type='text' size='10' name='oasis_therapy_soc_date' id='oasis_therapy_soc_date' 
					title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
						<input type="text" name="oasis_therapy_patient_name_first" value="<?php patientName('fname');?>" readonly>
					</td>
					<td align="right">
						<?php xl('MI: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_name_mi" value="<?php patientName('mname');?>" readonly>
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl('Last: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_name_last" value="<?php patientName('lname');?>" readonly>
					</td>
					<td align="right">
						<?php xl('Suffix: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_name_suffix" value="<?php patientName('title');?>" readonly>
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
						<input type="text" name="oasis_therapy_patient_address_street" value="<?php patientName('street');?>" readonly>
					</td>
					<td align="right">
						<?php xl('City: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_therapy_patient_address_city" value="<?php patientName('city');?>" readonly>
					</td>
				</tr>
			</table>
			<br>
			
			<strong>
			<?php xl('Patient Phone: ','e');?>
			<input type="text" name="oasis_therapy_patient_phone" value="<?php patientName('phone_home');?>" readonly><br>
			<?php xl('<u>(M0050)</u> Patient State of Residence: ','e');?>
			<input type="text" name="oasis_therapy_patient_state" value="<?php patientName('state');?>" readonly><br>
			<?php xl('<u>(M0060)</u> Patient Zip Code: ','e');?>
			<input type="text" name="oasis_therapy_patient_zip" value="<?php patientName('postal_code');?>" readonly><br>
			<?php xl('<u>(M0063)</u> Medicare Number: (including suffix) ','e');?>
			<input type="text" name="oasis_therapy_medicare_no" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_medicare_no_na" value="N/A"><?php xl('N/A - No Medicare','e');?></label><br>
			<?php xl('<u>(M0064)</u> Social Security Number: ','e');?>
			<input type="text" name="oasis_therapy_ssn" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_ssn_na" value="UK"><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<?php xl('<u>(M0065)</u> Medicaid Number: ','e');?>
			<input type="text" name="oasis_therapy_medicaid_no" value=""><br>
			<label><input type="checkbox" name="oasis_therapy_medicaid_no_na" value="N/A"><?php xl('NA - No Medicaid','e');?></label><br>
			<?php xl('<u>(M0066)</u> Birth Date: ','e');?>
				<input type='text' size='10' name='oasis_therapy_birth_date' value="<?php patientName("DOB");?>" readonly /> 
					<br>
			<?php xl('<u>(M0069)</u> Gender: ','e');?></strong>
				<label><input type="radio" name="oasis_therapy_patient_gender" id="male" value="male" <?php if(patientGender("sex")=="Male"){echo "checked='checked'";}else{echo " onclick=\"this.checked = false;  $('#female').attr('checked','checked');\"";} ?> ><?php xl('Male','e');?></label>
				<label><input type="radio" name="oasis_therapy_patient_gender" id="female" value="female" <?php if(patientGender("sex")=="Female"){echo "checked='checked'";}else{echo " onclick=\"this.checked = false;  $('#male').attr('checked','checked');\"";} ?> ><?php xl('Female','e');?></label>
			
		</td>
		<td valign="top">
			<strong><?php xl('<u>(M0080)</u> Discipline of Person Completing Assessment:','e');?></strong><br>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="1" checked><?php xl(' 1 - RN ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="2"><?php xl(' 2 - PT ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="3"><?php xl(' 3 - SLP/ST ','e');?></label>
				<label><input type="radio" name="oasis_therapy_discipline_person" value="4"><?php xl(' 4 - OT ','e');?></label>
			<br>
			<hr>
			<strong><?php xl('<u>(M0090)</u> Date Assessment Completed: ','e');?></strong>
			<input type='text' size='10' name='oasis_therapy_date_assessment_completed' id='oasis_therapy_date_assessment_completed' 
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
				<label><input type="radio" id="m0100" name="oasis_therapy_follow_up" value="8" checked><?php xl(' 8 - Death at home <b><i>[ Go to M0903 ]</i></b>','e');?></label><br>
				<label><input type="radio" name="oasis_therapy_follow_up" value="9"><?php xl(' 9 - Discharge from agency <b><i>[ Go to M1040 ]</i></b>','e');?></label>
			<hr>
			<strong><?php xl('Certification:','e');?></strong><br>
				<label><input type="radio" name="oasis_therapy_certification" value="0" checked ><?php xl(' Certification','e');?></label>
				<label><input type="radio" name="oasis_therapy_certification" value="1"><?php xl(' Recertification','e');?></label>
			<hr>
			<strong><?php xl('Date Last Contacted Physician: ','e');?></strong>
			<input type='text' size='10' name='oasis_therapy_date_last_contacted_physician' id='oasis_therapy_date_last_contacted_physician' 
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
			<label><input type="radio" id="m1040" name="oasis_influenza_vaccine" value="0" checked><?php xl(' 0 - No','e');?></label><br>
			<label><input type="radio" name="oasis_influenza_vaccine" value="1"><?php xl(' 1 - Yes <b><i>[ Go to M1050 ]</i></b>','e');?></label><br>
			<label><input type="radio" name="oasis_influenza_vaccine" value="2"><?php xl(' 2 - NA - Does not apply because entire episode of care (SOC/ROC to Transfer/Discharge) is outside this influenza season. <b><i>[ Go to M1050 ]</i></b>','e');?></label><br>
		</td>
		<td valign="top">
			<?php xl('<b><u>(M1050)</u> Pneumococcal Vaccine:</b> Did the patient receive pneumococcal polysaccharide vaccine (PPV) from your agency during this episode of care (SOC/ROC to Transfer/Discharge)?','e');?><br>
			<label><input type="radio" id="m1050" name="oasis_pneumococcal_vaccine" value="0"><?php xl(' 0 - No','e');?></label><br>
			<label><input type="radio" name="oasis_pneumococcal_vaccine" value="1"><?php xl(' 1 - Yes <b><i>[ Go to M1500 at TRN; Go to M1230 at DC ]</i></b>','e');?></label><br>
		</td>
	</tr>
	<tr>
		<td>
			<?php xl('<b><u>(M1045)</u> Reason Influenza Vaccine not received:</b> If the patient did not receive the influenza vaccine from your agency during this episode of care, state reason:','e');?><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="1"><?php xl(' 1 - Received from another health care provider (e.g., physician)','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="2"><?php xl(' 2 - Received from your agency previously during this year\'s flu season','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="3"><?php xl(' 3 - Offered and declined','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="4"><?php xl(' 4 - Assessed and determined to have medical contraindication(s)','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="5"><?php xl(' 5 - Not indicated; patient does not meet age/condition guidelines for influenza vaccine','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="6"><?php xl(' 6 - Inability to obtain vaccine due to declared shortage','e');?></label><br>
			<label><input type="radio" name="oasis_reason_influenza_vaccine" value="7"><?php xl(' 7 - None of the above','e');?></label><br>
		</td>
		<td valign="top">
			<?php xl('<b><u>(M1055)</u> Reason PPV not received:</b> If patient did not receive the pneumococcal polysaccharide vaccine (PPV) from your agency during this episode of care (SOC/ROC to Transfer/Discharge), state reason:','e');?><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="1"><?php xl(' 1 - Patient has received PPV in the past','e');?></label><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="2"><?php xl(' 2 - Offered and declined','e');?></label><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="3"><?php xl(' 3 - Assessed and determined to have medical contraindication(s)','e');?></label><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="4"><?php xl(' 4 - Not indicated; patient does not meet age/condition guidelines for PPV','e');?></label><br>
			<label><input type="radio" name="oasis_reason_ppv_not_received" value="5"><?php xl(' 5 - None of the above','e');?></label><br>
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
			<label><input type="radio" id="m1230" name="oasis_speech_and_oral" value="0" checked><?php xl(' 0 - Expresses complex ideas, feelings, and needs clearly, completely, and easily in all situations with no observable impairment.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="1"><?php xl(' 1 - Minimal difficulty in expressing ideas and needs (may take extra time; makes occasional errors in word choice, grammar or speech intelligibility; needs minimal prompting or assistance).','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="2"><?php xl(' 2 - Expresses simple ideas or needs with moderate difficulty (needs prompting or assistance, errors in word choice, organization or speech intelligibility). Speaks in phrases or short sentences.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="3"><?php xl(' 3 - Has severe difficulty expressing basic ideas or needs and requires maximal assistance or guessing by listener. Speech limited to single words or short phrases.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="4"><?php xl(' 4 - <u>Unable</u> to express basic needs even with maximal prompting or assistance but is not comatose or unresponsive (e.g., speech is nonsensical or unintelligible).','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="5"><?php xl(' 5 - Patient nonresponsive or unable to speak.','e');?></label><br>
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
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="0" checked><?php xl(' 0 - Patient has no pain','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="1"><?php xl(' 1 - Patient has pain that does not interfere with activity or movement','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="2"><?php xl(' 2 - Less often than daily','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="3"><?php xl(' 3 - Daily, but not constantly','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_frequency_pain" value="4"><?php xl(' 4 - All of the time','e')?></label>
			
			<br>
			<center><strong><?php xl('SYSTEM REVIEW','e');?></strong></center>
			<?php xl('Weight:','e');?>
			<input type="text" name="oasis_system_review_weight" value="">
			<label><input type="checkbox" name="oasis_system_review_weight_detail" value="reported"><?php xl(' reported ','e')?></label>
			<label><input type="checkbox" name="oasis_system_review_weight_detail" value="actual"><?php xl(' actual ','e')?></label>
			
			<br>
			<?php xl('Blood sugars (range):','e');?>
			<input type="text" name="oasis_system_review_blood_sugar" value="">
			
			<br>
			<?php xl('Bowel:','e');?>
			<input type="text" name="oasis_system_review_bowel" value="">
			<label><input type="checkbox" name="oasis_system_review_bowel_detail" value="WNL"><?php xl(' WNL ','e')?></label>
			<label><input type="checkbox" name="oasis_system_review_bowel_detail" value="Other"><?php xl(' Other ','e')?></label>
			<input type="text" name="oasis_system_review_bowel_other" value="">
			<?php xl('Bowel sounds','e');?>
			<input type="text" name="oasis_system_review_bowel_sounds" value="">
			
			<br>
			<?php xl('Bladder:','e');?>
			<input type="text" name="oasis_system_review_bladder" value="">
			<label><input type="checkbox" name="oasis_system_review_bladder_detail" value="WNL"><?php xl(' WNL ','e')?></label>
			<label><input type="checkbox" name="oasis_system_review_bladder_detail" value="Other"><?php xl(' Other ','e')?></label>
			<input type="text" name="oasis_system_review_bladder_other" value="">
			
			<br>
			<?php xl('Urinary output:','e');?>
			<input type="text" name="oasis_system_review_urinary_output" value="">
			<label><input type="checkbox" name="oasis_system_review_urinary_output_detail" value="WNL"><?php xl(' WNL ','e')?></label>
			
			<br>
			<label><input type="checkbox" name="oasis_system_review[]" value="Foley catheter"><?php xl(' Foley catheter change with ','e')?></label>
			<input type="text" name="oasis_system_review_foley_with" value="">
			<?php xl(' French Inflated balloon with ','e')?>
			<input type="text" name="oasis_system_review_foley_inflated" value="">
			<?php xl(' mL ','e')?>
			
			<br>
			<label><input type="checkbox" name="oasis_system_review[]" value="Suprapubic"><?php xl(' Suprapubic ','e')?></label>
			
			<br>
			<?php xl('Tolerated procedure well: ','e')?>
			<label><input type="radio" name="oasis_system_review_tolerated" value="Yes"><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_system_review_tolerated" value="No"><?php xl(' No ','e')?></label>
			
			<br>
			<label><input type="checkbox" name="oasis_system_review[]" value="Other"><?php xl(' Other (specify) ','e')?></label><br>
			<textarea name="oasis_system_review_other" rows="3" style="width:100%"></textarea>
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
<br /><textarea name="oasis_nutrition_eat_patt" rows="3"  style="width:100%;" ></textarea>
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
<center><strong><?php xl('NUTRITIONAL REQUIREMENTS','e')?></strong></center>
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
<textarea name="oasis_nutrition_req_other" rows="3" style="width:100%;" ></textarea>

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
<input type="text" name="oasis_nutrition_describe" id="oasis_nutrition_describe" /><br />
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
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Sitting","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Standing","e");?>
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="">
					</td>
					<td>
						<input type="text" name="oasis_therapy_vital_sign_blood_pressure[]" value="">
					</td>
				</tr>
			</table>
			
			<strong><?php xl("Temperature: &deg;F","e");?></strong>
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Oral"><?php xl(' Oral ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Axillary"><?php xl(' Axillary ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Rectal"><?php xl(' Rectal ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Tympanic"><?php xl(' Tympanic ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_temperature" value="Temporal"><?php xl(' Temporal ','e')?></label> 
			
		</td>
		<td>
			<strong><?php xl("Pulse:","e");?></strong><br>
			<label><input type="radio" name="oasis_therapy_vital_sign_pulse" value="At Rest"><?php xl(' At Rest ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_pulse" value="Activity"><?php xl(' Activity/Exercise ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_pulse" value="Regular"><?php xl(' Regular ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_pulse" value="Irregular"><?php xl(' Irregular ','e')?></label> 
			<br>
				
			<label><input type="checkbox" name="oasis_therapy_vital_sign_pulse_type[]" value="Radial"><?php xl(' Radial ','e')?></label> 
			<label><input type="checkbox" name="oasis_therapy_vital_sign_pulse_type[]" value="Carotid"><?php xl(' Carotid ','e')?></label> 
			<label><input type="checkbox" name="oasis_therapy_vital_sign_pulse_type[]" value="Apical"><?php xl(' Apical ','e')?></label> 
			<label><input type="checkbox" name="oasis_therapy_vital_sign_pulse_type[]" value="Brachial"><?php xl(' Brachial ','e')?></label> 
			<br><br>
			
			<strong><?php xl("Respiratory Rate:","e");?></strong>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_therapy_vital_sign_respiratory_rate" value="Normal"><?php xl(' Normal ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_respiratory_rate" value="Cheynes"><?php xl(' Cheynes Stokes ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_respiratory_rate" value="Death"><?php xl(' Death rattle ','e')?></label> 
			<label><input type="radio" name="oasis_therapy_vital_sign_respiratory_rate" value="Apnea"><?php xl(' Apnea /sec.','e')?></label> 
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
				<label><input type="checkbox" name="oasis_therapy_cardiopulmonary_problem" value="No"><?php xl('No Problem','e')?></label>
			</strong></center>
		</td>
	</tr>
	<tr>
		<td width="50%"> 
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
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
			<label><input type="radio" name="oasis_therapy_integumentary_status" value="0"><?php xl(' 0 - No <b>[ Go to M1322 ]</b>','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status" value="1"><?php xl(' 1 - Yes','e')?></label>
		</td>
		<td>
			<strong><?php xl('<u>(M1307)</u> The Oldest Non-epithelialized Stage II Pressure Ulcer </strong> that is present at discharge','e'); ?><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status_stage2" value="1"><?php xl(' 1 - Was present at the most recent SOC/ROC assessment','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_integumentary_status_stage2" value="2"><?php xl(' 2 - Developed since the most recent SOC/ROC assessment: record date pressure ulcer first identified:','e')?></label>
<input type='text' size='10' name='oasis_therapy_integumentary_status_stage2_date' id='oasis_therapy_integumentary_status_stage2_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date79' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_therapy_integumentary_status_stage2_date", ifFormat:"%Y-%m-%d", button:"img_curr_date79"});
						</script>

<br>
			<label><input type="radio" name="oasis_therapy_integumentary_status_stage2" value="NA"><?php xl(' NA - No non-epithelialized Stage II pressure ulcers are present at discharge','e')?></label>
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
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<?php xl("<b>Directions for M1310, M1312, and M1314:</b> If the patient has one or more unhealed (non-epithelialized) <b>Stage III or IV pressure ulcers, identify the Stage III or IV pressure ulcer with the largest surface dimension (length x width)</b> and record in centimeters. If no Stage III or Stage IV pressure ulcers, go to M1320.","e");?><br><br>
			<?php xl("<b><u>(M1310)</u> Pressure Ulcer Length:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_length" value=""><br>
			<?php xl("Longest length \"head-to-toe\" (cm)","e");?>
			<br>
			<?php xl("<b><u>(M1312)</u> Pressure Ulcer Width:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_width" value=""><br>
			<?php xl("Width of the same pressure ulcer; greatest width perpendicular to the length (cm)","e");?>
			<br>
			<?php xl("<b><u>(M1314)</u> Pressure Ulcer Depth:</b>","e");?>
			<input type="text" name="oasis_therapy_pressure_ulcer_depth" value=""><br>
			<?php xl("Depth of the same pressure ulcer; from visible surface to the deepest area (cm)","e");?>
			<br>
			<hr>
			<strong><?php xl('<u>(M1320)</u> Status of Most Problematic (Observable) Pressure Ulcer:','e');?></strong><br>
			<label><input id="m1320" type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="0"><?php xl(' 0 - Newly epithelialized','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="1"><?php xl(' 1 - Fully granulating','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="2"><?php xl(' 2 - Early/partial granulation','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="3"><?php xl(' 3 - Not healing','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_problematic_status" value="NA"><?php xl(' NA - No observable pressure ulcer','e')?></label><br>
			<br>
			<hr>
			<?php xl('<b><u>(M1322)</u>Current Number of Stage I Pressure Ulcers:</b> Intact skin with non-blanchable redness of a localized area usually over a bony prominence. The area may be painful, firm, soft, warmer or cooler as compared to adjacent tissue.','e');?><br>
			<label><input type="radio" id="m1322" name="oasis_therapy_pressure_ulcer_current_no" value="0" checked><?php xl(' 0 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="1"><?php xl(' 1 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="2"><?php xl(' 2 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="3"><?php xl(' 3 ','e')?></label>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_current_no" value="4"><?php xl(' 4 or more ','e')?></label>
			<br>
			<hr>
			<strong><?php xl('<u>(M1324)</u> Stage of Most Problematic Unhealed (Observable) Pressure Ulcer:','e');?></strong><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="1"><?php xl(' 1 - Stage I ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="2"><?php xl(' 2 - Stage II ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="3"><?php xl(' 3 - Stage III ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="4"><?php xl(' 4 - Stage IV ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_pressure_ulcer_stage_unhealed" value="NA"><?php xl(' NA - No observable pressure ulcer or unhealed pressure ulcer ','e')?></label><br>
		</td>
		<td>
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
			
		</td>
	</tr>
	<tr>
		<td valign="top">
			<?php xl('<b><u>(M1350)</u></b> Does this patient have a <b>Skin Lesion or Open Wound</b>, excluding bowel ostomy, other than those described above <u>that is receiving intervention</u> by the home health agency?','e');?><br>
			<label><input type="radio" id="m1350" name="oasis_therapy_skin_lesion" value="0"><?php xl(' 0 - No ','e')?></label><br>
			<label><input type="radio" name="oasis_therapy_skin_lesion" value="1"><?php xl(' 1 - Yes ','e')?></label><br>
			<br>
			<hr>
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
			<br>
			<hr>
			<center><strong><?php xl("RESPIRATORY STATUS","e");?></strong></center>
			<strong><?php xl("<u>(M1400)</u>","e");?></strong>
			<?php xl(" When is the patient dyspneic or noticeably ","e");?> 
			<strong><?php xl(" Short of Breath?","e");?></strong> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="0" checked><?php xl(' 0 - Patient is not short of breath ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="1"><?php xl(' 1 - When walking more than 20 feet, climbing stairs ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="2"><?php xl(' 2 - With moderate exertion (e.g., while dressing, using commode or bedpan, walking distances less than 20 feet) ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="3"><?php xl(' 3 - With minimal exertion (e.g., while eating, talking, or performing other ADLs) or with agitation ','e')?></label> <br>
			<label><input type="radio" name="oasis_therapy_respiratory_status" value="4"><?php xl(' 4 - At rest (during day or night) ','e')?></label> <br>
			<br><hr>
			<?php xl("<b><u>(M1410)</u>Respiratory Treatments</b> utilized at home: <b>(Mark all that apply.)</b>","e");?><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="1"><?php xl(' 1 - Oxygen (intermittent or continuous) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="2"><?php xl(' 2 - Ventilator (continually or at night) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="3"><?php xl(' 3 - Continuous / Bi-level positive airway pressure ','e')?></label><br>
			<label><input type="checkbox" name="oasis_therapy_respiratory_treatment[]" value="4"><?php xl(' 4 - None of the above ','e')?></label>
			
			<br>
			<hr>
			<center><strong><?php xl("CARDIAC STATUS","e");?></strong></center>
			<strong><?php xl("<u>(M1500)</u>Symptoms in Heart Failure Patients:","e");?></strong>
			<?php xl(" If patient has been diagnosed with heart failure, did the patient exhibit symptoms indicated by clinical heart failure guidelines (including dyspnea, orthopnea, edema, or weight gain) at any point since the previous OASIS assessment? ","e");?><br>
			<label><input type="radio" id="m1500" name="oasis_cardiac_status_symptoms" value="0" checked><?php xl(' 0 - No <b><i>[ Go to M2004 at TRN; Go to M1600 at DC ]</i></b> ','e')?></label><br>
			<label><input type="radio" name="oasis_cardiac_status_symptoms" value="1"><?php xl(' 1 - Yes ','e')?></label><br>
			<label><input type="radio" name="oasis_cardiac_status_symptoms" value="2"><?php xl(' 2 - Not assessed <b><i>[Go to M2004 at TRN; Go to M1600 at DC ]</i></b> ','e')?></label><br>
			<label><input type="radio" name="oasis_cardiac_status_symptoms" value="NA"><?php xl(' NA - Patient does not have diagnosis of heart failure <b><i>[Go to M2004 at TRN; Go to M1600 at DC ]</i></b> ','e')?></label><br>
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M1510)</u> Heart Failure Follow-up:","e");?></strong>
			<?php xl(" If patient has been diagnosed with heart failure and has exhibited symptoms indicative of heart failure since the previous OASIS assessment, what action(s) has (have) been taken to respond? <b>(Mark all that apply.)</b>","e");?><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="0"><?php xl(' 0 - No action taken ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="1"><?php xl(' 1 - Patient\'s physician (or other primary care practitioner) contacted the same day ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="2"><?php xl(' 2 - Patient advised to get emergency treatment (e.g., call 911 or go to emergency room) ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="3"><?php xl(' 3 - Implemented physician-ordered patient-specific established parameters for treatment ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="4"><?php xl(' 4 - Patient education or other clinical interventions ','e')?></label><br>
			<label><input type="checkbox" name="oasis_cardiac_status_heart_failure[]" value="5"><?php xl(' 5 - Obtained change in care plan orders (e.g., increased monitoring by agency, change in visit frequency, telehealth, etc.) ','e')?></label><br>
			
			
			<br>
			<hr>
			<center><strong><?php xl("ELIMINATION STATUS","e");?></strong></center>
			<?php xl("<b><u>(M1600)</u></b> Has this patient been treated for a <b>Urinary Tract Infection</b> in the past 14 days?","e");?><br>
			<label><input type="radio" id="m1600" name="oasis_elimination_status_tract_infection" value="0"><?php xl(' 0 - No ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="1"><?php xl(' 1 - Yes ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="NA"><?php xl(' NA - Patient on prophylactic treatment ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="UK"><?php xl(' UK - Unknown <b>[Omit "UK" option on DC]</b> ','e')?></label> <br>
			
			<br>
			<hr>
			<strong><?php xl("<u>(M1610)</u> Urinary Incontinence or Urinary Catheter Presence:","e");?></strong><br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="0" checked><?php xl(' 0 - No incontinence or catheter (includes anuria or ostomy for urinary drainage) <b><i>[ Go to M1620 ]</i></b> ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="1"><?php xl(' 1 - Patient is incontinent ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence" value="2"><?php xl(' 2 - Patient requires a urinary catheter (i.e., external, indwelling, intermittent, suprapubic) <b><i>[ Go to M1620 ]</i></b> ','e')?></label> <br>
			
			<br>
			<hr>
			<?php xl("<b><u>(M1615)</u> When</b> does <b>Urinary Incontinence</b> occur?","e");?></strong><br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="0"><?php xl(' 0 - Timed-voiding defers incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="1"><?php xl(' 1 - Occasional stress incontinence ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="2"><?php xl(' 2 - During the night only ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="3"><?php xl(' 3 - During the day only ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_urinary_incontinence_occur" value="4"><?php xl(' 4 - During the day and night ','e')?></label> <br>
			
			<br>
			<hr>
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
			<hr>
			<center><strong><?php xl("MENTAL STATUS","e");?></strong></center><br>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Oriented"><?php xl('Oriented','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Comatose"><?php xl('Comatose','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Forgetful"><?php xl('Forgetful','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Depressed"><?php xl('Depressed','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Disoriented"><?php xl('Disoriented','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Lethargic"><?php xl('Lethargic','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Agitated"><?php xl('Agitated','e')?></label>
			<label><input type="checkbox" name="oasis_mental_status[]" value="Other"><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_mental_status_other" value="">

			<br>
			<hr>
			<center><strong><?php xl("FUNCTIONAL LIMITATIONS","e");?></strong></center><br>
			<table class="formtable">
				<tr valign="top">
					<td width="30%">
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Amputation"><?php xl('Amputation','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Hearing"><?php xl('Hearing','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Ambulation"><?php xl('Ambulation','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Dyspnea with Minimal Exertion"><?php xl('Dyspnea with Minimal Exertion','e')?></label>
					</td>
					<td width="45%">
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Bowel/Bladder (Incontinence)"><?php xl('Bowel/Bladder (Incontinence)','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Paralysis"><?php xl('Paralysis','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Speech"><?php xl('Speech','e')?></label><br>
						
					</td>
					<td width="25%">
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Contracture"><?php xl('Contracture','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Endurance"><?php xl('Endurance','e')?></label><br>
						<label><input type="checkbox" name="oasis_functional_limitations[]" value="Legally Blind"><?php xl('Legally Blind','e')?></label>
					</td>
				</tr>
				<tr>
				<td colspan="3">
				<label><input type="checkbox" name="oasis_functional_limitations[]" value="Other"><?php xl('Other (specify):','e')?></label>
				<input type="text" name="oasis_functional_limitations_other" value="" size="15">
				</td>
				</tr>
						</table>
			<br>
			<hr>
			<center><strong><?php xl('PROGNOSIS','e')?></strong></center><br>
			<strong><?php xl('Prognosis:','e')?></strong>
			<label><input type="radio" name="oasis_prognosis" value="1"><?php xl(' 1-Poor ','e')?></label>
			<label><input type="radio" name="oasis_prognosis" value="2"><?php xl(' 2-Guarded ','e')?></label>
			<label><input type="radio" name="oasis_prognosis" value="3"><?php xl(' 3-Fair ','e')?></label>
			<label><input type="radio" name="oasis_prognosis" value="4"><?php xl(' 4-Good ','e')?></label>
			<label><input type="radio" name="oasis_prognosis" value="5"><?php xl(' 5-Excellent ','e')?></label>


			<br>
			<hr>
					<center><strong><?php xl("SAFETY MEASURES","e");?></strong></center>
			<table class="formtable">
			<tr>
				<td width="50%">
					<label><input type="checkbox" name="oasis_safety_measures[]" value="911 Protocol"><?php xl('911 Protocol','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Clear Pathways"><?php xl('Clear Pathways','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Siderails up"><?php xl('Siderails up','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Safe Transfers"><?php xl('Safe Transfers','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Equipment Safety"><?php xl('Equipment Safety','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Infection Control Measures"><?php xl('Infection Control Measures','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Bleeding Precautions"><?php xl('Bleeding Precautions','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Fall Precautions"><?php xl('Fall Precautions','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Seizure Precautions"><?php xl('Seizure Precautions','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Universal Precautions"><?php xl('Universal Precautions','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Other"><?php xl('Other:','e')?></label>
						<input type="text" name="oasis_safety_measures_other" value=""><br>
				</td>
				<td>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Hazard-Free Environment"><?php xl('Hazard-Free Environment','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Lock W/C with transfers"><?php xl('Lock W/C with transfers','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Elevate Head of Bed"><?php xl('Elevate Head of Bed','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Medication Safety/Storage"><?php xl('Medication Safety/Storage','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Hazardous Waste Disposal"><?php xl('Hazardous Waste Disposal','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="24 hr. supervision"><?php xl('24 hr. supervision','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Neutropenic"><?php xl('Neutropenic','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="O2 Precautions"><?php xl('O2 Precautions','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Aspiration Precautions"><?php xl('Aspiration Precautions','e')?></label><br>
					<label><input type="checkbox" name="oasis_safety_measures[]" value="Walker/Cane"><?php xl('Walker/Cane','e')?></label><br>
				</td>
			</tr>
			</table>



			<br>
			<hr>
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
						<input type="text" name="oasis_dme_iv_supplies_other" value="">

			<br>
			<hr>
					<strong><?php xl("FOLEY SUPPLIES: ","e");?></strong><br />
					<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Fr catheter kit"><?php xl('Fr catheter kit','e')?></label><br>
					<?php xl("(tray, bag, foley) ","e");?><br>
					<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Straight catheter"><?php xl('Straight catheter','e')?></label><br>
					<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Irrigation tray"><?php xl('Irrigation tray','e')?></label><br>
					<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Saline"><?php xl('Saline','e')?></label><br>
					<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Acetic acid"><?php xl('Acetic acid','e')?></label><br>
					<label><input type="checkbox" name="oasis_dme_foley_supplies[]" value="Other"><?php xl('Other','e')?></label><br>
						<input type="text" name="oasis_dme_foley_supplies_other" value="">
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
			<br>
		</td>
		<td valign="top">
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
			<br>
		</td>
		<td>
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
	</tr>
	<tr>
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
			
			<hr>
			<strong><?php xl("<u>(M1880)</u>","e");?></strong>
			<?php xl("Current <strong>Ability to Plan and Prepare Light Meals</strong> (e.g., cereal, sandwich) or reheat delivered meals safely:","e");?><br />
			<label><input type="radio" name="oasis_adl_current_ability" value="0" checked><?php xl(' 0 - (a) Able to independently plan and prepare all light meals for self or reheat delivered meals; <u>OR</u><br />
(b) Is physically, cognitively, and mentally able to prepare light meals on a regular basis but has not routinely performed light meal preparation in the past (i.e., prior to this home care admission).','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_current_ability" value="1"><?php xl(' 1 - <u>Unable</u> to prepare light meals on a regular basis due to physical, cognitive, or mental limitations.','e')?></label> <br>
			<label><input type="radio" name="oasis_adl_current_ability" value="2"><?php xl(' 2 - Unable to prepare any light meals or reheat any delivered meals.','e')?></label> <br>
			<br />
			
		</td>
		<td valign="top">
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
			
			<hr>
			<center><strong><?php xl('MEDICATIONS','e')?></strong></center>
			<strong><?php xl("<u>(M2004)</u>","e");?></strong>
			<?php xl("<strong>Medication Intervention: </strong> If there were any clinically significant medication issues since the previous OASIS assessment, was a physician or the physician-designee contacted within one calendar day of the assessment to resolve clinically significant medication issues, including reconciliation?","e");?><br />
			<label><input type="radio" id="m2004" name="oasis_medication_intervention" value="0"><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_intervention" value="1"><?php xl(' 1 - Yes','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_intervention" value="NA"><?php xl(' NA - No clinically significant medication issues identified since the previous OASIS assessment','e')?></label> <br>
			
			<br />
			
			<hr>
			<strong><?php xl("<u>(M2015)</u>","e");?></strong>
			<?php xl("<strong>Patient/Caregiver Drug Education Intervention: </strong> Since the previous OASIS assessment, was the patient/caregiver instructed by agency staff or other health care provider to monitor the effectiveness of drug therapy, drug reactions, and side effects, and how and when to report problems that may occur?","e");?><br />
			<label><input type="radio" name="oasis_medication_drug_education" value="0" checked><?php xl(' 0 - No','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_drug_education" value="1"><?php xl(' 1 - Yes','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_drug_education" value="NA"><?php xl(' NA - Patient not taking any drugs','e')?></label> <br>
			
			<br />
			<hr>
			<strong><?php xl("<u>(M2020)</u>","e");?></strong>
			<?php xl("<strong>Management of Oral Medications: </strong> <u>Patient's current ability</u> to prepare and take <u>all</u> oral medications reliably and safely, including administration of the correct dosage at the appropriate times/intervals. <b><u>Excludes</u> injectable and IV medications. (NOTE: This refers to ability, not compliance or willingness.)</b>","e");?><br />
			<label><input type="radio" name="oasis_medication_oral" value="0"><?php xl(' 0 - Able to independently take the correct oral medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_oral" value="1"><?php xl(' 1 - Able to take medication(s) at the correct times if:<br>
&nbsp;&nbsp;&nbsp;(a) individual dosages are prepared in advance by another person; <u>OR</u><br>
&nbsp;&nbsp;&nbsp;(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_oral" value="2"><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person at the appropriate times','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_oral" value="3"><?php xl(' 3 - <u>Unable</u> to take medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_oral" value="NA"><?php xl(' NA - No oral medications prescribed.','e')?></label> <br>
			
			<br />
			<hr>
			<strong><?php xl("<u>(M2030)</u>","e");?></strong>
			<?php xl("<strong>Management of Injectable Medications: </strong> <u>Patient's current ability</u> to prepare and take <u>all</u> prescribed injectable medications reliably and safely, including administration of correct dosage at the appropriate times/intervals. <b><u>Excludes</u> IV medications.</b>","e");?><br />
			<label><input type="radio" name="oasis_medication_injectable" value="0"><?php xl(' 0 - Able to independently take the correct medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_injectable" value="1"><?php xl(' 1 - Able to take injectable medication(s) at the correct times if:<br>
&nbsp;&nbsp;&nbsp;(a) individual syringes are prepared in advance by another person; <u>OR</u><br>
&nbsp;&nbsp;&nbsp;(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_injectable" value="2"><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person based on the frequency of the injection','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_injectable" value="3"><?php xl(' 3 - <u>Unable</u> to take injectable medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_medication_injectable" value="NA"><?php xl(' NA - No injectable medications prescribed.','e')?></label> <br>
			
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
			<br>
			<hr>
			<strong><?php xl("<u>(M2110)</u>","e");?></strong>
			<?php xl("<strong>How Often </strong> does the patient receive <strong>ADL or IADL assistance</strong> from any caregiver(s) (other than home health agency staff)?","e");?><br />
			<label><input type="radio" name="oasis_care_how_often" value="1" checked><?php xl(' 1 - At least daily','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="2"><?php xl(' 2 - Three or more times per week','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="3"><?php xl(' 3 - One to two times per week','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="4"><?php xl(' 4 - Received, but less often than weekly','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="5"><?php xl(' 5 - No assistance received','e')?></label> <br>
			<label><input type="radio" name="oasis_care_how_often" value="UK"><?php xl(' UK - Unknown <strong>[Omit "UK" option on DC]</strong>','e')?></label> <br>
			<br />
			<hr>
			<center><strong><?php xl('EMERGENT CARE','e')?></strong></center>
			<strong><?php xl("<u>(M2300)</u>","e");?></strong>
			<?php xl("<strong>Emergent Care: </strong> Since the last time OASIS data were collected, has the patient utilized a hospital emergency department (includes holding/observation)?","e");?><br />
			<label><input type="radio" name="oasis_emergent_care" value="0" checked><?php xl(' 0 - No <b><i>[ Go to M2400 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_emergent_care" value="1"><?php xl(' 1 - Yes, used hospital emergency department WITHOUT hospital admission','e')?></label> <br>
			<label><input type="radio" name="oasis_emergent_care" value="2"><?php xl(' 2 - Yes, used hospital emergency department WITH hospital admission','e')?></label> <br>
			<label><input type="radio" name="oasis_emergent_care" value="NA"><?php xl(' UK - Unknown <b><i>[ Go to M2400 ]</i></b>','e')?></label> <br>
			<br />
			<hr>
			<strong><?php xl("<u>(M2310)</u>","e");?></strong>
			<?php xl("<strong>Reason for Emergent Care: </strong> For what reason(s) did the patient receive emergent care (with or without hospitalization)? <b>(Mark all that apply.)</b>","e");?><br />
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="1"><?php xl(' 1 - Improper medication administration, medication side effects, toxicity, anaphylaxis','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="2"><?php xl(' 2 - Injury caused by fall','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="3"><?php xl(' 3 - Respiratory infection (e.g., pneumonia, bronchitis)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="4"><?php xl(' 4 - Other respiratory problem','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="5"><?php xl(' 5 - Heart failure (e.g., fluid overload)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="6"><?php xl(' 6 - Cardiac dysrhythmia (irregular heartbeat)','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="7"><?php xl(' 7 - Myocardial infarction or chest pain','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="8"><?php xl(' 8 - Other heart disease','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="9"><?php xl(' 9 - Stroke (CVA) or TIA','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="10"><?php xl(' 10 - Hypo/Hyperglycemia, diabetes out of control','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="11"><?php xl(' 11 - GI bleeding, obstruction, constipation, impaction','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="12"><?php xl(' 12 - Dehydration, malnutrition','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="13"><?php xl(' 13 - Urinary tract infection','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="14"><?php xl(' 14 - IV catheter-related infection or complication','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="15"><?php xl(' 15 - Wound infection or deterioration','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="16"><?php xl(' 16 - Uncontrolled pain','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="17"><?php xl(' 17 - Acute mental/behavioral health problem','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="18"><?php xl(' 18 - Deep vein thrombosis, pulmonary embolus','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="19"><?php xl(' 19 - Other than above reasons','e')?></label> <br>
			<label><input type="checkbox" name="oasis_emergent_care_reason[]" value="UK"><?php xl(' UK - Reason unknown','e')?></label> <br>
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
						<label><input type="radio" id="m2400" name="oasis_data_items_a" value="0" checked>0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_a" value="1">1</label>
					</td>
					<td width="40px">
						<label><input type="radio" name="oasis_data_items_a" value="na">na</label>
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
						<label><input type="radio" name="oasis_data_items_b" value="0" checked>0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_b" value="1">1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_b" value="na">na</label>
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
						<label><input type="radio" name="oasis_data_items_c" value="0" checked>0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_c" value="1">1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_c" value="na">na</label>
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
						<label><input type="radio" name="oasis_data_items_d" value="0" checked>0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_d" value="1">1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_d" value="na">na</label>
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
						<label><input type="radio" name="oasis_data_items_e" value="0" checked>0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_e" value="1">1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_e" value="na">na</label>
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
						<label><input type="radio" name="oasis_data_items_f" value="0" checked>0</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_f" value="1">1</label>
					</td>
					<td>
						<label><input type="radio" name="oasis_data_items_f" value="na">na</label>
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
			<label><input type="radio" name="oasis_inpatient_facility" value="1" checked><?php xl(' 1 - Hospital <b><i>[ Go to M2430 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_inpatient_facility" value="2"><?php xl(' 2 - Rehabilitation facility <b><i>[ Go to M0903 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_inpatient_facility" value="3"><?php xl(' 3 - Nursing home <b><i>[ Go to M2440 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_inpatient_facility" value="4"><?php xl(' 4 - Hospice <b><i>[ Go to M0903 ]</i></b>','e')?></label> <br>
			<label><input type="radio" name="oasis_inpatient_facility" value="NA"><?php xl(' NA - No inpatient facility admission <b><i>[Omit "NA" option on TRN]</i></b>','e')?></label> <br>
		</td>
		<td valign="top">
			<strong><?php xl("<u>(M2420)</u>","e");?></strong>
			<?php xl("<strong>Discharge Disposition: </strong> Where is the patient after discharge from your agency? <b>(Choose only one answer.)</b>","e");?><br />
			<label><input type="radio" name="oasis_discharge_disposition" value="1" checked><?php xl(' 1 - Patient remained in the community (without formal assistive services)','e')?></label> <br>
			<label><input type="radio" name="oasis_discharge_disposition" value="2"><?php xl(' 2 - Patient remained in the community (with formal assistive services)','e')?></label> <br>
			<label><input type="radio" name="oasis_discharge_disposition" value="3"><?php xl(' 3 - Patient transferred to a non-institutional hospice','e')?></label> <br>
			<label><input type="radio" name="oasis_discharge_disposition" value="4"><?php xl(' 4 - Unknown because patient moved to a geographic location not served by this agency','e')?></label> <br>
			<label><input type="radio" name="oasis_discharge_disposition" value="UK"><?php xl(' UK - Other unknown <b><i>[ Go to M0903 ]</i></b>','e')?></label> <br>
			
		</td>
	</tr>
	<tr>
<td valign="top"><strong>
<?php xl("(M2430)","e");?></strong><strong><?php xl("Reason for Hospitalization:","e");?></strong><?php xl(" For what reason(s) did the patient require hospitalization? ","e");?><strong><?php xl("(Mark all that apply.)","e");?></strong><br>
<input type="checkbox" id="m2430" name="Reason_for_Hospitalization[]" value="Improper medication administration, medication side effects, toxicity, anaphylaxis" /> <?php xl("1 - Improper medication administration, medication side effects, toxicity, anaphylaxis","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Injury caused by fall" /> <?php xl("2 - Injury caused by fall","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Respiratory infection (e.g., pneumonia, bronchitis)" /> <?php xl("3 - Respiratory infection (e.g., pneumonia, bronchitis)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other respiratory problem" /> <?php xl("4 - Other respiratory problem","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Heart failure (e.g., fluid overload)" /> <?php xl("5 - Heart failure (e.g., fluid overload)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Cardiac dysrhythmia (irregular heartbeat)" /> <?php xl("6 - Cardiac dysrhythmia (irregular heartbeat)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Myocardial infarction or chest pain" /> <?php xl("7 - Myocardial infarction or chest pain","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other heart disease" /> <?php xl("8 - Other heart disease","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Stroke (CVA) or TIA" /> <?php xl("9 - Stroke (CVA) or TIA","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Hypo/Hyperglycemia, diabetes out of control" /> <?php xl("10 - Hypo/Hyperglycemia, diabetes out of control","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="GI bleeding, obstruction, constipation, impaction" /> <?php xl("11 - GI bleeding, obstruction, constipation, impaction","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Dehydration, malnutrition" /> <?php xl("12 - Dehydration, malnutrition","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Urinary tract infection" /> <?php xl("13 - Urinary tract infection","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="IV catheter-related infection or complication" /> <?php xl("14 - IV catheter-related infection or complication","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Wound infection or deterioration" /> <?php xl("15 - Wound infection or deterioration","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Uncontrolled pain" /> <?php xl("16 - Uncontrolled pain","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Acute mental/behavioral health problem" /> <?php xl("17 - Acute mental/behavioral health problem","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Deep vein thrombosis, pulmonary embolus" /> <?php xl("18 - Deep vein thrombosis, pulmonary embolus","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Scheduled treatment or procedure" /> <?php xl("19 - Scheduled treatment or procedure","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other than above reasons" /> <?php xl("20 - Other than above reasons","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="UK - Reason unknown" /> <?php xl("UK - Reason unknown","e");?>
<strong><i><?php xl("[ Go to M0903 ]","e");?></i></strong>
</td>

<td valign="top"><strong>
<?php xl("(M2440)","e");?></strong><?php xl("For what ","e");?><strong><?php xl("Reason(s)","e");?></strong><?php xl(" was the patient ","e");?><strong><?php xl("Admitted","e");?></strong><?php xl(" to a ","e");?><strong><?php xl("Nursing Home? (Mark all that apply.)","e");?></strong><br>
<input type="checkbox" id="m2440" name="patient_Admitted_to_a_Nursing_Home[]" value="Therapy services" /> <?php xl("1 - Therapy services","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Respite care" /> <?php xl("2 - Respite care","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Hospice care" /> <?php xl("3 - Hospice care","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Permanent placement" /> <?php xl("4 - Permanent placement","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Unsafe for care at home" /> <?php xl("5 - Unsafe for care at home","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Other" /> <?php xl("6 - Other","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Unknown" /> <?php xl("UK - Unknown","e");?>
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
			<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Peripheral: (specify)"  id="non_oasis_infusion" />
<strong><?php xl('Peripheral: (specify)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_peripheral" id="non_oasis_infusion_peripheral" size="25" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="PICC: (specify, size, brand)"  id="non_oasis_infusion" />
<strong><?php xl('PICC: (specify, size, brand)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_PICC" id="non_oasis_infusion_PICC" size="25" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Central"  id="non_oasis_infusion" /><?php xl('Central','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Midline/Midclavicular"  id="non_oasis_infusion" /><?php xl('Midline/Midclavicular','e')?></label><br />
&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Single lumen"  id="non_oasis_infusion_central" />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Double lumen"  id="non_oasis_infusion_central" />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Triple lumen"  id="non_oasis_infusion_central" />
<?php xl('Triple lumen','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;

<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_central_date' id='non_oasis_infusion_central_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date8' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_central_date", ifFormat:"%Y-%m-%d", button:"img_curr_date8"});
                        </script>
<br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="X-ray verification:"  id="non_oasis_infusion" />
<strong><?php xl('X-ray verification:','e')?></strong></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_xray" value="Yes"  id="non_oasis_infusion_xray" />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_xray" value="No"  id="non_oasis_infusion_xray" />
<?php xl('No','e')?></label> &nbsp;

<br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Mid arm circumference in/cm"  id="non_oasis_infusion" />
<?php xl('Mid arm circumference in/cm','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_circum" id="non_oasis_infusion_circum" size="25" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="External catheter length in/cm"  id="non_oasis_infusion" />
<?php xl('External catheter length in/cm','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_length" id="non_oasis_infusion_length" size="25" /><br />
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Hickman"  id="non_oasis_infusion" />
<?php xl('Hickman','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Broviac"  id="non_oasis_infusion" />
<?php xl('Broviac','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Groshong"  id="non_oasis_infusion" />
<?php xl('Groshong','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Jugular"  id="non_oasis_infusion" />
<?php xl('Jugular','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Subclavian"  id="non_oasis_infusion" />
<?php xl('Subclavian','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
<label><input type="radio" name="non_oasis_infusion_hickman" value="Single lumen"  id="non_oasis_infusion_hickman" />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_hickman" value="Double lumen"  id="non_oasis_infusion_hickman" />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_hickman" value="Triple lumen"  id="non_oasis_infusion_hickman" />
<?php xl('Triple lumen','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_hickman_date' id='non_oasis_infusion_hickman_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date9' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_hickman_date", ifFormat:"%Y-%m-%d", button:"img_curr_date9"});
                        </script>
<br />



<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Epidural catheter"  id="non_oasis_infusion" />
<?php xl('Epidural catheter','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Tunneled"  id="non_oasis_infusion" />
<?php xl('Tunneled','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Port1"  id="non_oasis_infusion" />
<?php xl('Port','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_epidural_date' id='non_oasis_infusion_epidural_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date10' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_epidural_date", ifFormat:"%Y-%m-%d", button:"img_curr_date10"});
                        </script>
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Implanted VAD"  id="non_oasis_infusion" />
<?php xl('Implanted VAD','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Venous"  id="non_oasis_infusion" />
<?php xl('Venous','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Arterial"  id="non_oasis_infusion" />
<?php xl('Arterial','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Peritoneal"  id="non_oasis_infusion" />
<?php xl('Peritoneal','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_implanted_date' id='non_oasis_infusion_implanted_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date11' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_implanted_date", ifFormat:"%Y-%m-%d", button:"img_curr_date11"});
                        </script>
<br />


<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Intrathecal"  id="non_oasis_infusion" />
<?php xl('Intrathecal','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Port2"  id="non_oasis_infusion" />
<?php xl('Port','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Reservoir"  id="non_oasis_infusion" />
<?php xl('Reservoir','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_intrathecal_date' id='non_oasis_infusion_intrathecal_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date12' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_intrathecal_date", ifFormat:"%Y-%m-%d", button:"img_curr_date12"});
                        </script>
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered1"  id="non_oasis_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med1_admin" id="non_oasis_infusion_med1_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_name" id="non_oasis_infusion_med1_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_dose" id="non_oasis_infusion_med1_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_dilution" id="non_oasis_infusion_med1_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_route" id="non_oasis_infusion_med1_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_frequency" id="non_oasis_infusion_med1_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_duration" id="non_oasis_infusion_med1_duration" size="10" />
</label>



<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered2"  id="non_oasis_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med2_admin" id="non_oasis_infusion_med2_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_name" id="non_oasis_infusion_med2_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_dose" id="non_oasis_infusion_med2_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_dilution" id="non_oasis_infusion_med2_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_route" id="non_oasis_infusion_med2_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_frequency" id="non_oasis_infusion_med2_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_duration" id="non_oasis_infusion_med2_duration" size="10" />
</label>


<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered3"  id="non_oasis_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med3_admin" id="non_oasis_infusion_med3_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_name" id="non_oasis_infusion_med3_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_dose" id="non_oasis_infusion_med3_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_dilution" id="non_oasis_infusion_med3_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_route" id="non_oasis_infusion_med3_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_frequency" id="non_oasis_infusion_med3_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_duration" id="non_oasis_infusion_med3_duration" size="10" />
</label>

			<!--For Infusion-->
		</td>
		<td>
			<!--For Infusion-->
			
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Pump:(type, specify)"  id="non_oasis_infusion" />
<strong><?php xl('Pump:(type, specify)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_pump" id="non_oasis_infusion_pump" size="25" />
<br />
<strong><?php xl('Administered by:','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Self"  id="non_oasis_infusion_admin_by" />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Caregiver"  id="non_oasis_infusion_admin_by" />
<?php xl('Caregiver','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="RN"  id="non_oasis_infusion_admin_by" />
<?php xl('RN','e')?></label> &nbsp;
<label><br />
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Other"  id="non_oasis_infusion_admin_by" />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_admin_by_other" id="non_oasis_infusion_admin_by_other"  style="width:100%"  />

<br />
</strong><?php xl('Purpose of Intravenous Access:','e')?></strong> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Antibiotic therapy"  id="non_oasis_infusion_purpose" />
<?php xl('Antibiotic therapy','e')?></label> &nbsp;
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Pain Control"  id="non_oasis_infusion_purpose" />
<?php xl('Pain Control','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Chemotherapy"  id="non_oasis_infusion_purpose" />
<?php xl('Chemotherapy','e')?></label> &nbsp;
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Maintain venous access"  id="non_oasis_infusion_purpose" />
<?php xl('Maintain venous access','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Hydration"  id="non_oasis_infusion_purpose" />
<?php xl('Hydration','e')?></label> &nbsp;
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Parenteral nutrition"  id="non_oasis_infusion_purpose" />
<?php xl('Parenteral nutrition','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Other"  id="non_oasis_infusion_purpose" />
<?php xl('Other','e')?></label> &nbsp;
<br />
<textarea name="non_oasis_infusion_purpose_other" rows="3" style="width:100%;"></textarea>
<br /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Infusion care provided during visit"  id="non_oasis_infusion" />
<?php xl('Infusion care provided during visit','e')?></label> &nbsp;
<br />
<textarea name="non_oasis_infusion_care_provided" rows="3" style="width:100%;"></textarea>
<br /><br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Dressing change:"  id="non_oasis_infusion" />
<strong><?php xl('Dressing change:','e')?></strong></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_dressing" value="Sterile"  id="non_oasis_infusion_dressing" />
<?php xl('Sterile','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_dressing" value="Clean"  id="non_oasis_infusion_dressing" />
<?php xl('Clean','e')?></label> &nbsp;
<br />

<strong><?php xl('Performed by:','e')?></strong> &nbsp;&nbsp;&nbsp;&nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Self"  id="non_oasis_infusion_performed_by" />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="RN"  id="non_oasis_infusion_performed_by" />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Caregiver"  id="non_oasis_infusion_performed_by" />
<?php xl('Caregiver','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Other"  id="non_oasis_infusion_performed_by" />
<?php xl('Other','e')?></label> &nbsp;
<br />

<label><?php xl('Frequency (specify)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_frequency" id="non_oasis_infusion_frequency" size="30" />
</label>
<br />
<label><?php xl('Injection cap change (specify frequency)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_injection" id="non_oasis_infusion_injection" size="30" />
</label>
<br />
<label><?php xl('Labs drawn','e')?> &nbsp;
<br />
<textarea name="non_oasis_infusion_labs_drawn" rows="3" style="width:100%;"></textarea>
</label>
<br />
<label><?php xl('Interventions/Instructions/Comments','e')?> &nbsp;
<br />
<textarea name="non_oasis_infusion_interventions" rows="3" style="width:100%;"></textarea>
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
<input type="checkbox" name="non_oasis_enteral[]" value="Nasogastric"  id="non_oasis_enteral" />
<?php xl('Nasogastric','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Gastrostomy"  id="non_oasis_enteral" />
<?php xl('Gastrostomy','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Jejunostomy"  id="non_oasis_enteral" />
<?php xl('Jejunostomy','e')?></label> &nbsp;<br />
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Other (specify)"  id="non_oasis_enteral" />
<?php xl('Other (specify)','e')?></label> &nbsp;

<input type="text" name="non_oasis_enteral_other" id="non_oasis_enteral_other" size="30" />
<br />

<label>
<strong><?php xl('Pump: (type/specify)','e')?></strong> &nbsp;
<input type="text" name="non_oasis_enteral_pump" id="non_oasis_enteral_pump" size="30" />
</label>
<br />

<strong><?php xl('Feedings:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_feedings" value="Bolus"  id="non_oasis_enteral_feedings" />
<?php xl('Bolus','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_feedings" value="Continuous"  id="non_oasis_enteral_feedings" />
<?php xl('Continuous','e')?></label> &nbsp;

<label><?php xl('Rate:','e')?> &nbsp;
<input type="text" name="non_oasis_enteral_rate" id="non_oasis_enteral_rate" size="14" />
</label>
<br />

<label>
<strong><?php xl('Flush Protocol: (amt./specify)','e')?></strong> &nbsp;<br>
<textarea name="non_oasis_enteral_flush" rows="3" style="width:100%;"></textarea>
</label>
<br />


<strong><?php xl('Performed by:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Self"  id="non_oasis_enteral_performed_by" />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="RN"  id="non_oasis_enteral_performed_by" />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Caregiver"  id="non_oasis_enteral_performed_by" />
<?php xl('Caregiver','e')?></label> &nbsp;<br>
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Other"  id="non_oasis_enteral_performed_by" />
<?php xl('Other','e')?></label> &nbsp;

<input type="text" name="non_oasis_enteral_performed_by_other" id="non_oasis_enteral_performed_by_other" size="45" />
<br />

<label>
<strong><?php xl('Dressing/Site care:(specify)','e')?></strong> &nbsp;
<textarea name="non_oasis_enteral_dressing" rows="3" style="width:100%;"></textarea>
</label>
<br />

<label><b><?php xl('Interventions/Instructions/Comments','e')?></b> &nbsp;
<textarea name="non_oasis_enteral_interventions" rows="3" style="width:100%;"></textarea>
</label>
		</td>
		<td valign="top">
			<center><strong><?php xl('SKILLED CARE PROVIDED THIS VISIT','e')?></strong></center>
			<strong><?php xl('CARE COORDINATION:','e')?></strong>
			<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="RN"  id="non_oasis_skilled_care" />
<?php xl('RN','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="PT"  id="non_oasis_skilled_care" />
<?php xl('PT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="OT"  id="non_oasis_skilled_care" />
<?php xl('OT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="ST"  id="non_oasis_skilled_care" />
<?php xl('ST','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="MSW"  id="non_oasis_skilled_care" />
<?php xl('MSW','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="Aide"  id="non_oasis_skilled_care" />
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
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="SN"  id="non_oasis_summary_disciplines" />
<?php xl('SN','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="PT"  id="non_oasis_summary_disciplines" />
<?php xl('PT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="OT"  id="non_oasis_summary_disciplines" />
<?php xl('OT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="ST"  id="non_oasis_summary_disciplines" />
<?php xl('ST','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="MSW"  id="non_oasis_summary_disciplines" />
<?php xl('MSW','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="CHHA"  id="non_oasis_summary_disciplines" />
<?php xl('CHHA','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="Other"  id="non_oasis_summary_disciplines" />
<?php xl('Other','e')?>
</label>
<input type="text" name="non_oasis_summary_disciplines_other" id="non_oasis_summary_disciplines_other" size="20" />
<br />

<strong><?php xl('PHYSICIAN NOTIFIED:','e')?></strong> &nbsp;
<label><input type="radio" name="non_oasis_summary_physician" value="Yes"  id="non_oasis_summary_physician" />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_physician" value="No"  id="non_oasis_summary_physician" />
<?php xl('No','e')?></label> &nbsp;
</TD>
</tr>

<tr>
<TD colspan="2">
<center><strong><?php xl('Complete this Section for Discharge Purposes (unless Summary is written elsewhere','e')?></strong>
<input type="checkbox" name="non_oasis_summary_elsewhere" value="Yes"  id="non_oasis_summary_elsewhere" />
<strong><?php xl(')','e')?></strong>
</center><br />

<label>
<strong><?php xl('REASON FOR ADMISSION / SUMMARY:','e')?></strong><br />
<textarea name="non_oasis_summary_reason" rows="10" style="width:100%"></textarea>
</label>
</TD>
</tr>



<tr>
<TD colspan="2">
<strong><?php xl('MEDICATION STATUS','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_summary_medication" value="Medication regimen reviewed"  id="non_oasis_summary_medication" />
<?php xl('Medication regimen reviewed','e')?>
</label>
<br />

<?php xl('Check if any of the following were identified:','e')?>
<br />

<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Potential adverse effects/drug reactions"  id="non_oasis_summary_medication_identified" />
<?php xl('Potential adverse effects/drug reactions','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Ineffective drug therapy"  id="non_oasis_summary_medication_identified" />
<?php xl('Ineffective drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Significant side effects"  id="non_oasis_summary_medication_identified" />
<?php xl('Significant side effects','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Significant drug interactions"  id="non_oasis_summary_medication_identified" />
<?php xl('Significant drug interactions','e')?>
</label>
<br />

<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Duplicate drug therapy"  id="non_oasis_summary_medication_identified" />
<?php xl('Duplicate drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Non compliance with drug therapy"  id="non_oasis_summary_medication_identified" />
<?php xl('Non compliance with drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="No change"  id="non_oasis_summary_medication_identified" />
<?php xl('No change','e')?>
</label>
<label>

</TD>
</tr>

<tr>
<TD colspan="2">
<strong><?php xl('INDICATE REASON FOR DISCHARGE','e')?></strong> &nbsp; &nbsp; &nbsp; &nbsp;
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient/Family request"  id="non_oasis_summary_reason_discharge" />
<?php xl('Patient/Family request','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Failure to maintain services of an attending physician"  id="non_oasis_summary_reason_discharge" />
<?php xl('Failure to maintain services of an attending physician','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient-centered goals achieved"  id="non_oasis_summary_reason_discharge" />
<?php xl('Patient-centered goals achieved','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Physician request"  id="non_oasis_summary_reason_discharge" />
<?php xl('Physician request','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Agency/Organization decision"  id="non_oasis_summary_reason_discharge" />
<?php xl('Agency/Organization decision','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient expired"  id="non_oasis_summary_reason_discharge" />
<?php xl('Patient expired','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Repeatedly not home/not found"  id="non_oasis_summary_reason_discharge" />
<?php xl('Repeatedly not home/not found','e')?>
</label>&nbsp;&nbsp;
&nbsp;<label>
<?php xl('Explain:','e')?>
<input type="text" name="non_oasis_summary_reason_discharge_explain" id="non_oasis_summary_reason_discharge_explain" size="30" />
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Geographic relocation"  id="non_oasis_summary_reason_discharge" />
<?php xl('Geographic relocation','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient refused to accept care/treatments as ordered"  id="non_oasis_summary_reason_discharge" />
<?php xl('Patient refused to accept care/treatments as ordered','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient refused further care"  id="non_oasis_summary_reason_discharge" />
<?php xl('Patient refused further care','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Persistent noncompliance with POC"  id="non_oasis_summary_reason_discharge" />
<?php xl('Persistent noncompliance with POC','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="No longer home bound"  id="non_oasis_summary_reason_discharge" />
<?php xl('No longer home bound','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Other (specify)"  id="non_oasis_summary_reason_discharge" />
<?php xl('Other (specify)','e')?>
</label>
<input type="text" name="non_oasis_summary_reason_discharge_other" id="non_oasis_summary_reason_discharge_other" size="30" />
</TD>
</tr>

<tr><TD colspan="2">
<label>
<strong>
<?php xl('DISCHARGE INSTRUCTIONS','e')?></strong>
<?php xl('(specify future follow-up, referrals, etc.)','e')?>
<textarea name="non_oasis_summary_discharge_inst" rows="7" style="width:100%"></textarea>
</label>
<br />


<strong><?php xl('Reviewed:','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Home safety"  id="non_oasis_summary_reviewed" />
<?php xl('Home safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Fall safety"  id="non_oasis_summary_reviewed" />
<?php xl('Fall safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Medication safety"  id="non_oasis_summary_reviewed" />
<?php xl('Medication safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="When to contact physician"  id="non_oasis_summary_reviewed" />
<?php xl('When to contact physician','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Next appointment physician"  id="non_oasis_summary_reviewed" />
<?php xl('Next appointment physician','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Standard precautions"  id="non_oasis_summary_reviewed" />
<?php xl('Standard precautions','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Other (describe)"  id="non_oasis_summary_reviewed" />
<?php xl('Other (describe)','e')?>
</label>
<input type="text" name="non_oasis_summary_reviewed_other" id="non_oasis_summary_reviewed_other" style="width:100%" />
<br />

<strong><?php xl('Immunizations current:','e')?></strong> &nbsp;
<label><input type="radio" name="non_oasis_summary_immunization" value="Yes"  id="non_oasis_summary_immunization" />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_immunization" value="No"  id="non_oasis_summary_immunization" />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_immun_explain" id="non_oasis_summary_immun_explain" style="width:100%" />
</label>
<br />


<strong><?php xl('Written instructions given to patient/caregiver:','e')?></strong> &nbsp;
<label><input type="radio" name="non_oasis_summary_written" value="Yes"  id="non_oasis_summary_written" />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_written" value="No"  id="non_oasis_summary_written" />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_written_explain" id="non_oasis_summary_written_explain" style="width:100%" />
</label>
<br />


<strong><?php xl('Patient/Caregiver demonstrates understanding of instructions:','e')?></strong> &nbsp;
<label><input type="radio" name="non_oasis_summary_demonstrates" value="Yes"  id="non_oasis_summary_demonstrates" />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_demonstrates" value="No"  id="non_oasis_summary_demonstrates" />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_demonstrates_explain" id="non_oasis_summary_demonstrates_explain" style="width:100%" />
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
<a id="btn_save" href="javascript:top.restoreSession();form_validation('oasis_discharge');"
class="link_submit"><?php xl(' [Save]','e')?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color:#483D8B;" onClick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>

</body>
</html>
