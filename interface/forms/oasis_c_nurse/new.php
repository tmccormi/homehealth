<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");

formHeader("Form: oasis_c_nurse");


/* include api.inc. also required. */
require_once($GLOBALS['srcdir'].'/api.inc');
/* include our smarty derived controller class. */
require($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');
?>

<html>
<head>
<title>Oasis-C Nurse Recertification</title>
<style type="text/css">
.bold {
	font-weight: bold;
}

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
<link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/css/jquery-ui-1.8.21.custom.css" type="text/css" media="all" />

<style type="text/css">
label, input{
display:inline !important;
}
</style>

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
		$('input:radio[name=oasis_c_nurse_pain_scale]')[scale].checked = true;
		
	}


function sum_braden_scale()
    {
            
$("#braden_total").val(
parseInt($("#braden_sensory").val())+
parseInt($("#braden_moisture").val())+
parseInt($("#braden_activity").val())+
parseInt($("#braden_mobility").val())+
parseInt($("#braden_nutrition").val())+
parseInt($("#braden_friction").val()));
    }



	function sumfallrisk(box)
	{
		if(box.checked)
		{
		$("#oasis_c_nurse_fall_risk_assessment_total").val(parseInt($("#oasis_c_nurse_fall_risk_assessment_total").val())+1);
		}
		else
		{
		$("#oasis_c_nurse_fall_risk_assessment_total").val(parseInt($("#oasis_c_nurse_fall_risk_assessment_total").val())-1);
		}
	}



function calc_avg()
	{
	$("#oasis_c_nurse_timed_up_average").val((parseInt($("#oasis_c_nurse_timed_up_trial1").val())+parseInt($("#oasis_c_nurse_timed_up_trial2").val()))/2);
	}



 </script>
</head>
<body>


<h3 align="center"><?php xl('OASIS-C NURSE RECERTIFICATION','e')?></h3>		


<form method="post"
		action="<?php echo $rootdir;?>/forms/oasis_c_nurse/save.php?mode=new" name="oasis_c_nurse">
		

		
		
<table width="100%" border="1px" class="formtable">
	<tr>
		<td align="left">
			<?php xl('Patient Name','e');?>
			<input type="text" name="oasis_c_nurse_patient_name" value="<?php patientName1();?>" readonly >
		</td>
		<td align="right">
			<table border="0" cellspacing="0" class="formtable" width="100%">
				<tr>
					<td align="right">
						<?php xl('Caregiver: ','e');?>
						<input type="text" name="oasis_c_nurse_caregiver" value="">
					</td>



					<td align="right">


						<?php xl('Visit Date','e');?>
						<input type="text" name="oasis_c_nurse_visit_date" value="<?php VisitDate(); ?>" readonly="true">
					</td>
				</tr>
				<tr>
					<td align="right" colspan="2">
						<?php xl('Time In','e');?>
						<select name="oasis_c_nurse_time_in">
							<?php timeDropDown($GLOBALS['Selected']) ?>
						</select>
						<?php xl('Time Out','e');?>
						<select name="oasis_c_nurse_time_out">
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
                    <div><a href="#" id="black">Patient Tracking Information &amp; Clinical Record Items</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>


<!-- *********************  Pain & Nutrition   ******************** -->
                        <li>
                            <center><h3 align="center"><?php xl('Patient Tracking Information','e')?></h3></center>


<table width="100%" border="1px" class="formtable">

	<tr>
		<td align="center">
			<strong><?php xl('PATIENT TRACKING INFORMATION','e');?></strong>
		</td>
		<td align="center">
			<strong><?php xl('PATIENT TRACKING INFORMATION(CONTD)','e');?></strong>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php xl('(M0010) C M S Certification Number: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_cms_no" value=""><br>
			<strong><?php xl('(M0014)Branch State: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_branch_state" value=""><br>
			<strong><?php xl('(M0016) Branch ID Number: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_branch_id_no" value=""><br>
			<strong><?php xl('(M0018) National Provider Identifier (N P I) ','e') ?></strong><?php xl('for the attending physician who has signed the plan of care: ','e');?>
			<input type="text" name="oasis_c_nurse_npi" value="">
<br />
			<label><input type="checkbox" name="oasis_c_nurse_npi_na" value="N/A"><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<strong><?php xl('Primary Referring Physician I.D.: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_referring_physician_id" value="">
<br />
			<label><input type="checkbox" name="oasis_c_nurse_referring_physician_id_na" value="N/A"><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<br>
			
			<strong><?php xl('Primary Referring Physician: ','e');?></strong><br>
			<?php xl('Last: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_primary_physician_last" value=""><br>
			<?php xl('First: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_primary_physician_first" value=""><br>
			<?php xl('Phone: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_primary_physician_phone" value=""><br>
			<?php xl('Address: ','e');?>&nbsp;
			<input type="text" name="oasis_c_nurse_primary_physician_address" value=""><br>
			<?php xl('City: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_primary_physician_city" value=""><br>
			<?php xl('State: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_primary_physician_state" value=""><br>
			<?php xl('Zip Code: ','e');?>
			<input type="text" name="oasis_c_nurse_primary_physician_zip" value=""><br>
			<br>
			
			<strong><?php xl('Other Physician: ','e');?></strong><br>
			<?php xl('Last: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_other_physician_last" value=""><br>
			<?php xl('First: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_other_physician_first" value=""><br>
			<?php xl('Phone: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_other_physician_phone" value=""><br>
			<?php xl('Address: ','e');?>&nbsp;
			<input type="text" name="oasis_c_nurse_other_physician_address" value=""><br>
			<?php xl('City: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_other_physician_city" value=""><br>
			<?php xl('State: ','e');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="oasis_c_nurse_other_physician_state" value=""><br>
			<?php xl('Zip Code: ','e');?>
			<input type="text" name="oasis_c_nurse_other_physician_zip" value=""><br>
			<br>
			
			<strong><?php xl('(M0020)Patient ID Number: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_patient_id" value="<?php patientName('pid')?>" readonly><br>
			
			
					
			<strong><?php xl('(M0030) Start of Care Date:','e');?></strong>
				<input type='text' size='10' name='oasis_c_nurse_soc_date' id='oasis_c_nurse_soc_date' 
					title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_c_nurse_soc_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
					</script>
					<br>
			<strong><?php xl('(M0040) Patient"s Name: ','e');?></strong><br>
			<table cellspacing="0" border="0" class="formtable">
				<tr>
					<td align="right">
						<?php xl('First: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_c_nurse_patient_name_first" value="<?php patientName('fname')?>" readonly="true">
					</td>
					<td align="right">
						<?php xl('MI: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_c_nurse_patient_name_mi" value="<?php patientName('mname')?>" readonly="true">
					</td>
				</tr>
				<tr>
					<td align="right">
						<?php xl('Last: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_c_nurse_patient_name_last" value="<?php patientName('lname')?>" readonly="true">
					</td>
					<td align="right">
						<?php xl('Suffix: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_c_nurse_patient_name_suffix" value="<?php patientName('title')?>" readonly="true">
					</td>
				</tr>
			</table>
			<br>
			
			<strong><?php xl('Patient Address: ','e');?></strong><br>
			<table cellspacing="0" border="0" class="formtable">
				<tr>
					<td align="right">
						<?php xl('Street: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_c_nurse_patient_address_street" value="<?php patientName('street')?>" readonly="true">
					</td>
					<td align="right">
						<?php xl('City: ','e');?>
					</td>
					<td align="left">
						<input type="text" name="oasis_c_nurse_patient_address_city" value="<?php patientName('city')?>" readonly="true">
					</td>
				</tr>
			</table>
			<br>
			
			<strong><?php xl('Patient Phone: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_patient_phone" value="<?php patientName('phone_home')?>" readonly="true"><br>
			<strong><?php xl('(M0050) Patient State of Residence: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_patient_state" value="<?php patientName("state")?>" readonly="true"><br>
			<strong><?php xl('(M0060) Patient Zip Code: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_patient_zip" value="<?php patientName("postal_code")?>" readonly="true"><br>
			<strong><?php xl('(M0063) Medicare Number: (including suffix) ','e');?></strong>
			<input type="text" name="oasis_c_nurse_medicare_no" value="">
<br />
			<label><input type="checkbox" name="oasis_c_nurse_medicare_no_na" value="N/A"><?php xl('N/A - No Medicare','e');?></label><br>
			<strong><?php xl('(M0064) Social Security Number: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_ssn" value="">
<br />
			<label><input type="checkbox" name="oasis_c_nurse_ssn_na" value="UK"><?php xl('UK - Unknown or Not Available','e');?></label><br>
			<strong><?php xl('(M0065) Medicaid Number: ','e');?></strong>
			<input type="text" name="oasis_c_nurse_medicaid_no" value="">
<br />
			<label><input type="checkbox" name="oasis_c_nurse_medicaid_no_na" value="N/A"><?php xl('NA - No Medicaid','e');?></label><br>
			<strong><?php xl('(M0066) Birth Date: ','e');?></strong>
<input type="text" name="oasis_c_nurse_birth_date" value="<?php patientName("DOB")?>" readonly="true">
					<br>
			<strong><?php xl('(M0069) Gender: ','e');?></strong>
				<label><input type="radio" name="oasis_c_nurse_patient_gender" value="male" 
<?php if(patientGender("sex")=="Male") echo "checked"; ?> ><?php xl('Male','e');?></label>
				<label><input type="radio" name="oasis_c_nurse_patient_gender" value="female" 
<?php if(patientGender("sex")=="Female") echo "checked"; ?> ><?php xl('Female','e');?></label>
			
		</td>




		<td valign="top">


			<strong><?php xl('(M0150) Current Payment Sources for Home Care: (Mark all that apply.)','e');?></strong><br>
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="0"><?php xl(' 0 - None; no charge for current services','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="1"><?php xl(' 1 - Medicare (traditional fee-for-service)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="2"><?php xl(' 2 - Medicare (HMO/managed care/Advantage plan)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="3"><?php xl(' 3 - Medicaid (traditional fee-for-service)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="4"><?php xl(' 4 - Medicaid (HMO/managed care)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="5"><?php xl(' 5 - Workers" compensation','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="6"><?php xl(' 6 - Title programs (e.g., Title III, V, or XX)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="7"><?php xl(' 7 - Other government (e.g., TriCare, VA, etc.)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="8"><?php xl(' 8 - Private insurance','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="9"><?php xl(' 9 - Private HMO/managed care','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="10"><?php xl(' 10 - Self-pay','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="11"><?php xl(' 11 - Other (specify)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_payment_source_homecare[]" value="UK"><?php xl(' UK - Unknown','e')?></label>
<hr />
			<center><strong><?php xl('CLINICAL RECORD ITEMS','e');?></strong></center>
<hr />
			<strong><?php xl('(M0080) Discipline of Person Completing Assessment:','e');?></strong><br />
				<label><input type="radio" name="oasis_c_nurse_discipline_person" value="1"><?php xl(' 1 - RN ','e');?></label>
				<label><input type="radio" name="oasis_c_nurse_discipline_person" value="2"><?php xl(' 2 - PT ','e');?></label>
				<label><input type="radio" name="oasis_c_nurse_discipline_person" value="3"><?php xl(' 3 - SLP/ST ','e');?></label>
				<label><input type="radio" name="oasis_c_nurse_discipline_person" value="4"><?php xl(' 4 - OT ','e');?></label>
<hr />
			<strong><?php xl('(M0090) Date Assessment Completed: ','e');?></strong>
			<input type='text' size='10' name='oasis_c_nurse_date_assessment_completed' id='oasis_c_nurse_date_assessment_completed' 
					title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date4' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_c_nurse_date_assessment_completed", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
					</script>
<hr />
<b><?php xl('(M0100) This Assessment is Currently Being Completed for the Following Reason: ','e');?></b>
<br />
<u><b><?php xl('Follow-Up ','e');?></b></u><br />
				<label><input type="radio" name="oasis_c_nurse_follow_up" value="4"><?php xl(' 4 - Recertification (follow-up) reassessment <strong>[Go to M0110]</strong>','e');?></label><br />
				<label><input type="radio" name="oasis_c_nurse_follow_up" value="5"><?php xl(' 5 - Other follow-up <strong>[Go to M0110]</strong>','e');?></label>
<hr />
			<strong><?php xl('(M0110) Episode Timing:','e') ?></strong><?php xl(' Is the Medicare home health payment episode for which this assessment will define a case mix group an "early" episode or a "later" episode in the patient"s current sequence of adjacent Medicare home health payment episodes? ','e');?><br />
				<label><input type="radio" name="oasis_c_nurse_episode_timing" value="1"><?php xl(' 1 - Early','e');?></label><br />
				<label><input type="radio" name="oasis_c_nurse_episode_timing" value="2"><?php xl(' 2 - Later','e');?></label><br />
				<label><input type="radio" name="oasis_c_nurse_episode_timing" value="UK"><?php xl(' UK - Unknown','e');?></label><br />
				<label><input type="radio" name="oasis_c_nurse_episode_timing" value="NA"><?php xl(' NA - Not Applicable: No Medicare case mix group to be defined by this assessment.','e');?></label>
<hr />
			<strong><?php xl('Certification Period From: ','e');?></strong>
			<input type='text' size='10' name='oasis_c_nurse_certification_period_from' id='oasis_c_nurse_certification_period_from' 
					title='<?php xl('yyyy-mm-dd From','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date5' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_c_nurse_certification_period_from", ifFormat:"%Y-%m-%d", button:"img_curr_date5"});
					</script>
			<strong><?php xl(' To: ','e');?></strong>
			<input type='text' size='10' name='oasis_c_nurse_certification_period_to' id='oasis_c_nurse_certification_period_to' 
					title='<?php xl('yyyy-mm-dd To','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date6' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_c_nurse_certification_period_to", ifFormat:"%Y-%m-%d", button:"img_curr_date6"});
					</script>
		</td>
	</tr>	

</table>



                        </li>
                    </ul>
                </li>


<li>
                    <div><a href="#" id="black">Patient History And Diagnosis</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                        <ul>
<!-- *********************  PATIENT HISTORY AND DIAGNOSIS   ******************** -->
                        <li>

<h3 align="center"><?php xl('PATIENT HISTORY AND DIAGNOSIS','e')?></h3>


<table width="100%" border="1" class="formtable">

	<tr>
		<td colspan="2">
			<?php xl('<strong><u>(M1020/1022/1024)</u> Diagnosis, Symptom Control, and Payment Diagnosis:</strong> List each diagnosis for which the patient is receiving home care (Column 1) and enter its ICD-9-C M code at the level of highest
specificity (no surgical/procedure codes) (Column 2). Diagnosis are listed in the order that best reflect the seriousness of each condition and support the disciplines and services provided. Rate the degree of symptom
control for each condition (Column 2). Choose one value that represents the degree of symptom control appropriate for each diagnosis: V-codes (for M1020 or M1022) or E-codes (for M1022 only) may be used. ICD-9-C
M sequencing requirements must be followed if multiple coding is indicated for any Diagnosis. If a V-code is reported in place of a case mix diagnosis, then optional item M1024 Payment Diagnosis (Columns 3 and 4) may
be completed. A case mix diagnosis is a diagnosis that determines the Medicare P P S case mix group. Do not assign symptom control ratings for V- or E-codes.','e');?><br>
			<table cellspacing="0" border="1" class="formtable">
				<tr>
					<td colspan="2">
						<strong><?php xl('Code each row according to the following directions for each column:','e');?></strong>
					</td>
				</tr>
				<tr>
					<td width="10%">
						<strong><?php xl('Column 1:','e');?></strong>
					</td>
					<td>
						<?php xl('Enter the description of the diagnosis.','e');?>
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php xl('Column 2:','e');?></strong>
					</td>
					<td>
						<?php xl('Enter the ICD-9-C M code for the diagnosis described in Column 1;<br />
Rate the degree of symptom control for the condition listed in Column 1 using the following scale:<br />
0 - Asymptomatic, no treatment needed at this time<br />
1 - Symptoms well controlled with current therapy<br />
2 - Symptoms controlled with difficulty, affecting daily functioning; patient needs ongoing monitoring<br />
3 - Symptoms poorly controlled; patient needs frequent adjustment in treatment and dose monitoring<br />
4 - Symptoms poorly controlled; history of re-hospitalizations<br />
Note that in Column 2 the rating for symptom control of each diagnosis should not be used to determine the sequencing of the Diagnosis listed in Column 1. These are separate items
and sequencing may not coincide. Sequencing of Diagnosis should reflect the seriousness of each condition and support the disciplines and services provided.','e');?>
					</td>
				</tr>
				<tr>
					<td>
						<strong><?php xl('Column 3:','e');?></strong>
					</td>
					<td>
						<?php xl('(OPTIONAL) If a V-code is assigned to any row in Column 2, in place of a case mix diagnosis, it may be necessary to complete optional item M1024 Payment Diagnosis (Columns 3 and
4). See OASIS-C Guidance Manual.','e');?>
					</td>
				</tr>
				<tr>
					<td>
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
						<strong><?php xl('<u>(M1020)</u> Primary Diagnosis & <u>(M1022)</u> Other Diagnosis','e');?></strong>
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
				<tr valign="top">
					<td>
						<?php xl('Diagnosis (Sequencing of Diagnosis should reflect the seriousness of each condition and support the disciplines and services provided.)','e');?>
					</td>
					<td>
						<?php xl('ICD-9-C M and symptom control rating for each condition. Note that the sequencing of these ratings may not match the sequencing of the Diagnosis','e');?>
					</td>
					<td>
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
						<strong><?php xl('<u>(V-codes are allowed)</u>','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('<u>(V- or E-codes NOT allowed)</u>','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('<u>(V- or E-codes NOT allowed)</u>','e');?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1a" value="">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2a" id="oasis_patient_diagnosis_2a" value="" onkeydown="fonChange(this,2,'noe')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3a" id="oasis_patient_diagnosis_3a" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4a" id="oasis_patient_diagnosis_4a" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td align="left" width="25%">
						<strong><?php xl('<u>(M1022)</u> Other Diagnosis','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('<u>(V- or E-codes are allowed)</u>','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('<u>(V- or E-codes NOT allowed)</u>','e');?></strong>
					</td>
					<td align="center" width="25%">
						<strong><?php xl('<u>(V- or E-codes NOT allowed)</u>','e');?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1b" value="">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2b" id="oasis_patient_diagnosis_2b" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3b" id="oasis_patient_diagnosis_3b" value=""  onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4b" id="oasis_patient_diagnosis_4b" value=""  onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1c" value="">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2c" id="oasis_patient_diagnosis_2c" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3c" id="oasis_patient_diagnosis_3c" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4c" id="oasis_patient_diagnosis_4c" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1d" value="">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2d" id="oasis_patient_diagnosis_2d" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3d" id="oasis_patient_diagnosis_3d" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4d" id="oasis_patient_diagnosis_4d" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1e" value="">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2e" id="oasis_patient_diagnosis_2e" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3e" id="oasis_patient_diagnosis_3e" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4e" id="oasis_patient_diagnosis_4e" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1f" value="">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2f" id="oasis_patient_diagnosis_2f" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3f" id="oasis_patient_diagnosis_3f" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4f" id="oasis_patient_diagnosis_4f" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1g" value="">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2g" id="oasis_patient_diagnosis_2g" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3g" id="oasis_patient_diagnosis_3g" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4g" id="oasis_patient_diagnosis_4g" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1h" value="">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2h" id="oasis_patient_diagnosis_2h" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3h" id="oasis_patient_diagnosis_3h" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4h" id="oasis_patient_diagnosis_4h" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1i" value="">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2i" id="oasis_patient_diagnosis_2i" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3i" id="oasis_patient_diagnosis_3i" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4i" id="oasis_patient_diagnosis_4i" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1j" value="">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2j" id="oasis_patient_diagnosis_2j" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3j" id="oasis_patient_diagnosis_3j" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4j" id="oasis_patient_diagnosis_4j" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1k" value="">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2k" id="oasis_patient_diagnosis_2k" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3k" id="oasis_patient_diagnosis_3k" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4k" id="oasis_patient_diagnosis_4k" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1l" value="">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2l" id="oasis_patient_diagnosis_2l" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3l" id="oasis_patient_diagnosis_3l" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4l" id="oasis_patient_diagnosis_4l" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1m" value="">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2m" id="oasis_patient_diagnosis_2m" value="" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3m" id="oasis_patient_diagnosis_3m" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4m" id="oasis_patient_diagnosis_4m" value="" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
			</table>
		</td>
	</tr>


<tr><TD colspan="2">
<u><?php xl('Surgical Procedure ( V codes are allowed )','e');?></u><br />
<?php xl('a. ','e');?>
<input type="text" name="oasis_surgical_procedure_a" id="oasis_surgical_procedure_a" value="" onkeydown="fonChange(this,2,'noe')">
<?php xl('Date:','e');?>
						<input type='text' size='10' name='oasis_surgical_procedure_a_date' id='oasis_surgical_procedure_a_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date7' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_surgical_procedure_a_date", ifFormat:"%Y-%m-%d", button:"img_curr_date7"});
</script>

<br />
<?php xl('b. ','e');?>
<input type="text" name="oasis_surgical_procedure_b" id="oasis_surgical_procedure_b" value="" onkeydown="fonChange(this,2,'noe')">
<?php xl('Date:','e');?>
						<input type='text' size='10' name='oasis_surgical_procedure_b_date' id='oasis_surgical_procedure_b_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date8' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_surgical_procedure_b_date", ifFormat:"%Y-%m-%d", button:"img_curr_date8"});
</script>

<br />
</TD></tr>


<!-- ***************************************    Patient History and Diagnosis (Contd)    ***************************************** -->

<tr>

		<td align="center">
			<strong><?php xl('PATIENT HISTORY AND DIAGNOSIS (CONTD)','e'); ?></strong>
		</td>
		<td align="center">
			<strong><?php xl('SENSORY STATUS','e'); ?></strong>
		</td>
	</tr>
	<tr valign="top">
		<td width="50%">
			<?php xl('<strong><u>(M1030)</u> Therapies</strong> the patient receives <u>at home:</u> <strong>(Mark all that apply.)</strong>','e'); ?><br>
			<label><input type="checkbox" name="oasis_c_nurse_therapies_home[]" value="1"><?php xl(' 1 - Intravenous or infusion therapy (excludes TPN)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_therapies_home[]" value="2"><?php xl(' 2 - Parenteral nutrition (TPN or lipids)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_therapies_home[]" value="3"><?php xl(' 3 - Enteral nutrition (nasogastric, gastrostomy, jejunostomy, or any other artificial entry into the alimentary canal)','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_therapies_home[]" value="4"><?php xl(' 4 - None of the above','e')?></label>
		</td>
		<td>
			<?php xl('<strong><u>(M1200)</u> Vision</strong> (with corrective lenses if the patient usually wears them):','e'); ?><br>
			<label><input type="radio" name="oasis_c_nurse_vision" value="0"><?php xl(' 0 - Normal vision: sees adequately in most situations; can see medication labels, newsprint.','e')?></label><br />
			<label><input type="radio" name="oasis_c_nurse_vision" value="1"><?php xl(' 1 - Partially impaired: cannot see medication labels or newsprint, but <u>can</u> see obstacles in path, and the surrounding layout; can count fingers at arm"s length.','e')?></label><br />
			<label><input type="radio" name="oasis_c_nurse_vision" value="2"><?php xl(' 2 - Severely impaired: cannot locate objects without hearing or touching them or patient nonresponsive.','e')?></label>
		</td>
	</tr>
	<tr valign="top">
		<td width="50%">
			<center><strong><?php xl('PROGNOSIS','e')?></strong></center><br>
			<strong><?php xl('Prognosis:','e')?></strong>
			<label><input type="radio" name="oasis_c_nurse_prognosis" value="1"><?php xl(' 1-Poor ','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_prognosis" value="2"><?php xl(' 2-Guarded ','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_prognosis" value="3"><?php xl(' 3-Fair ','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_prognosis" value="4"><?php xl(' 4-Good ','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_prognosis" value="5"><?php xl(' 5-Excellent ','e')?></label>
		</td>
		<td>
			<strong><?php xl('<strong><u>(M1242)</u> Frequency of Pain Interfering </strong> with patient"s activity or movement:','e'); ?></strong><br>
			<label><input type="radio" name="oasis_c_nurse_frequency_pain" value="0"><?php xl(' 0 - Patient has no pain','e')?></label><br />
			<label><input type="radio" name="oasis_c_nurse_frequency_pain" value="1"><?php xl(' 1 - Patient has pain that does not interfere with activity or movement','e')?></label><br />
			<label><input type="radio" name="oasis_c_nurse_frequency_pain" value="2"><?php xl(' 2 - Less often than daily','e')?></label><br />
			<label><input type="radio" name="oasis_c_nurse_frequency_pain" value="3"><?php xl(' 3 - Daily, but not constantly','e')?></label><br />
			<label><input type="radio" name="oasis_c_nurse_frequency_pain" value="4"><?php xl(' 4 - All of the time','e')?></label>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl('PAIN','e')?></strong></center><br>
			<table border="0" cellspacing="0" class="formtable">
				<tr align="center">
					<td></td>
					<td>
						<img src="../../clickmap/pain_scale/scale_0.png" border="0" onclick="select_pain(0)">
					</td>
					<td>
						<img src="../../clickmap/pain_scale/scale_2.png" border="0" onclick="select_pain(1)">
					</td>
					<td>
						<img src="../../clickmap/pain_scale/scale_4.png" border="0" onclick="select_pain(2)">
					</td>
					<td>
						<img src="../../clickmap/pain_scale/scale_6.png" border="0" onclick="select_pain(3)">
					</td>
					<td>
						<img src="../../clickmap/pain_scale/scale_8.png" border="0" onclick="select_pain(4)">
					</td>
					<td>
						<img src="../../clickmap/pain_scale/scale_10.png" border="0" onclick="select_pain(5)">
					</td>
				</tr>
				<tr>
					<td>
						<strong><u><?php xl('Pain Rating Scale:','e')?></u></strong>
					</td>
					<td>
						<label><input type="radio" name="oasis_c_nurse_pain_scale" id="painscale_1" value="0"><?php xl(' 0-No Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_c_nurse_pain_scale" id="painscale_2" value="2"><?php xl(' 2-Little Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_c_nurse_pain_scale" id="painscale_4" value="4"><?php xl(' 4-Little More Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_c_nurse_pain_scale" id="painscale_6" value="6"><?php xl(' 6-Even More Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_c_nurse_pain_scale" id="painscale_8" value="8"><?php xl(' 8-Lots of Pain ','e')?></label>
					</td>
					<td>
						<label><input type="radio" name="oasis_c_nurse_pain_scale" id="painscale_10" value="10"><?php xl(' 10-Worst Pain ','e')?></label>
					</td>
				</tr>
			</table>
			<br>
			
			<strong><u><?php xl('Location:','e')?></u></strong> <?php xl('Cause:','e')?>
			<input type="text" name="oasis_c_nurse_pain_location_cause" value="" size="50%"><br>
			
			<strong><u><?php xl('Description:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("sharp","e");?>"><?php xl('sharp','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("dull","e");?>"><?php xl('dull','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("cramping","e");?>"><?php xl('cramping','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("aching","e");?>"><?php xl('aching','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("burning","e");?>"><?php xl('burning','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("tingling","e");?>"><?php xl('tingling','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("throbbing","e");?>"><?php xl('throbbing','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("shooting","e");?>"><?php xl('shooting','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_description" value="<?php xl("pinching","e");?>"><?php xl('pinching','e')?></label><br>
			
			<strong><u><?php xl('Frequency:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_c_nurse_pain_frequency" value="<?php xl("occasional","e");?>"><?php xl('occasional','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_frequency" value="<?php xl("intermittent","e");?>"><?php xl('intermittent','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_frequency" value="<?php xl("continuous","e");?>"><?php xl('continuous','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_frequency" value="<?php xl("at rest","e");?>"><?php xl('at rest','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_frequency" value="<?php xl("at night","e");?>"><?php xl('at night','e')?></label><br>
			
			<strong><u><?php xl('Aggravating factors:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_c_nurse_pain_aggravating_factors" value="<?php xl("movement","e");?>"><?php xl('movement','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_aggravating_factors" value="<?php xl("time of day","e");?>"><?php xl('time of day','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_aggravating_factors" value="<?php xl("posture","e");?>"><?php xl('posture','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_aggravating_factors" value="<?php xl("other","e");?>"><?php xl('other','e')?></label>
			<input type="text" name="oasis_c_nurse_pain_aggravating_factors_other" value="" size="50%"><br>
			
			<strong><u><?php xl('Relieving factors:','e')?></u></strong><br>
			<label><input type="checkbox" name="oasis_c_nurse_pain_relieving_factors" value="<?php xl("medication","e");?>"><?php xl('medication','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_relieving_factors" value="<?php xl("rest","e");?>"><?php xl('rest','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_relieving_factors" value="<?php xl("heat","e");?>"><?php xl('heat','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_relieving_factors" value="<?php xl("ice","e");?>"><?php xl('ice','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_relieving_factors" value="<?php xl("massage","e");?>"><?php xl('massage','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_relieving_factors" value="<?php xl("repositioning","e");?>"><?php xl('repositioning','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_relieving_factors" value="<?php xl("diversion","e");?>"><?php xl('diversion','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_pain_relieving_factors" value="<?php xl("other","e");?>"><?php xl('other','e')?></label>
			<input type="text" name="oasis_c_nurse_pain_relieving_factors_other" value="" size="50%"><br>
			
			<strong><u><?php xl('Activities limited:','e')?></u></strong><br>
			<textarea name="oasis_c_nurse_pain_activities_limited" rows="3" style="width:100%;"></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<?php xl('Is patient experiencing pain?','e')?>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_c_nurse_experiencing_pain" value="Yes"><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_experiencing_pain" value="No"><?php xl(' No ','e')?></label><br>
			
			<label><input type="checkbox" name="oasis_c_nurse_unable_to_communicate" value="<?php xl("Unable to communicate","e");?>"><?php xl('Unable to communicate','e')?></label><br>
			
			<strong><?php xl('Non-verbals demonstrated: ','e')?></strong>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Diaphoresis","e");?>"><?php xl('Diaphoresis','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Grimacing","e");?>"><?php xl('Grimacing','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Moaning/Crying","e");?>"><?php xl('Moaning/Crying','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Guarding","e");?>"><?php xl('Guarding','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Irritability","e");?>"><?php xl('Irritability','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Anger","e");?>"><?php xl('Anger','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Tense","e");?>"><?php xl('Tense','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Restlessness","e");?>"><?php xl('Restlessness','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Change in vital signs","e");?>"><?php xl('Change in vital signs','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Other:","e");?>"><?php xl('Other:','e')?></label>
			<input type="text" name="oasis_c_nurse_non_verbal_demonstrated_other" value="">
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Self-assessment","e");?>"><?php xl('Self-assessment','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_non_verbal_demonstrated" value="<?php xl("Implications:","e");?>"><?php xl('Implications:','e')?></label>
			<input type="text" name="oasis_c_nurse_non_verbal_demonstrated_implications" value="">
		</td>
		<td>
			<?php xl('How often is breakthrough medication needed? ','e')?><br>
			<label><input type="checkbox" name="oasis_c_nurse_breakthrough_medication" value="<?php xl("Never","e");?>"><?php xl('Never','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breakthrough_medication" value="<?php xl("Less than daily","e");?>"><?php xl('Less than daily','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breakthrough_medication" value="<?php xl("2-3 times/day","e");?>"><?php xl('2-3 times/day','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breakthrough_medication" value="<?php xl("More than 3 times/day","e");?>"><?php xl('More than 3 times/day','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breakthrough_medication" value="<?php xl("Current pain control medications adequate","e");?>"><?php xl('Current pain control medications adequate','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breakthrough_medication" value="<?php xl("other:","e");?>"><?php xl('other:','e')?></label>
			<input type="text" name="oasis_c_nurse_breakthrough_medication_other" value=""><br>
			
			<?php xl('Implications Care Plan:?','e')?>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_c_nurse_implications_care_plan" value="Yes"><?php xl(' Yes ','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_implications_care_plan" value="No"><?php xl(' No ','e')?></label><br>
		</td>
		
	</tr>


	</table>

                        </li>
                    </ul>
                </li>








<li>
                    <div><a href="#" id="black">Integumentary Status, Wound/Lesion &amp; Braden Scale</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                        <ul>
<!-- *********************  Integumentary Status, Wound/Lesion & Braden Scale   ******************** -->
                        <li>


	<table class="formtable" width="100%" border="1">
	<tr>
	<td width="50%"><table class="formtable"><tr>
	<td width="100%">
            <center><strong>
                <?php xl('INTEGUMENTARY STATUS','e')?>
                <label><input type="checkbox" name="oasis_integumentary_status_problem" value="<?php xl('No Problem',"e");?>">
			<?php xl('No Problem','e')?></label>
            </strong></center>
            <?php xl('Wound care done:','e')?>
            <label><input type="radio" name="oasis_wound_care_done" value="Yes"><?php xl('Yes','e')?></label>
            <label><input type="radio" name="oasis_wound_care_done" value="No"><?php xl('No','e')?></label><br>
            <?php xl('Location(s) if patient has more than one wound site:','e')?>
            <input type="text" name="oasis_wound_location" style="width:70%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Soiled dressing removed","e");?>"><?php xl('Soiled dressing removed','e')?></label>
            <?php xl('By:','e')?>
            <label><input type="checkbox" name="oasis_wound_soiled_dressing_by" value="<?php xl("Patient","e");?>"><?php xl('Patient','e')?></label>
            <label><input type="checkbox" name="oasis_wound_soiled_dressing_by" value="<?php xl("Family/caregiver","e");?>">
			<?php xl('Family/caregiver','e')?></label>
            <label><input type="checkbox" name="oasis_wound_soiled_dressing_by" value="<?php xl("RN/PT","e");?>"><?php xl('RN/PT','e')?></label>
            <br>
            <?php xl('Technique:','e')?>
            <label><input type="checkbox" name="oasis_wound_soiled_technique" value="<?php xl("Sterile","e");?>"><?php xl('Sterile','e')?></label>
            <label><input type="checkbox" name="oasis_wound_soiled_technique" value="<?php xl("Clean","e");?>"><?php xl('Clean','e')?></label>
            <br>
            <label>
            <input type="checkbox" name="oasis_wound[]" value="<?php xl("Wound cleaned with (specify):","e");?>"  >
			<?php xl('Wound cleaned with (specify):','e')?></label>
            <input type="text" name="oasis_wound_cleaned"  style="width:45%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Wound irrigated with (specify):","e");?>"  >
			<?php xl('Wound irrigated with (specify):','e')?></label>
            <input type="text" name="oasis_wound_irrigated"  style="width:45%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Wound packed with (specify):","e");?>"  >
			<?php xl('Wound packed with (specify):','e')?></label>
            <input type="text" name="oasis_wound_packed"  style="width:45%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Wound dressing applied (specify):","e");?>"  >
			<?php xl('Wound dressing applied (specify):','e')?></label>
            <input type="text" name="oasis_wound_dressing_apply"  style="width:40%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Patient tolerated procedure well","e");?>"  >
			<?php xl('Patient tolerated procedure well','e')?></label><br />
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Incision care with (specify):","e");?>"  >
			<?php xl('Incision care with (specify):','e')?></label>
            <input type="text" name="oasis_wound_incision"  style="width:45%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Staples present","e");?>"><?php xl('Staples present','e')?></label><br>
            <?php xl("Comments:","e");?>
            <textarea name="oasis_wound_comment" rows="3" style="width:100%"></textarea><br>
            <?php xl('Satisfactory return demo:','e')?>
            <label><input type="radio" name="oasis_satisfactory_return_demo" value="Yes"><?php xl(' Yes ','e')?></label>
            <label><input type="radio" name="oasis_satisfactory_return_demo" value="No"><?php xl('No','e')?></label><br>
            <?php xl('Education: ','e')?>
            <label><input type="checkbox" name="oasis_wound_education" value="<?php xl("Yes","e");?>"><?php xl('Yes','e')?></label><br>
            <?php xl("Comments:","e");?>
            <textarea name="oasis_wound_education_comment" rows="3" style="width:100%;"></textarea>
        </td></tr></table>


	
	
	</td>
	<td width="50%">
	<center><strong><?php xl("WOUND LOCATIONS","e");?></strong></center><br>

	<?php

                        /* Create a form object. */
                        $c = new C_FormPainMap('oasis_c_nurse','bodymap_man.png');

                        /* Render a 'new form' page. */
                        echo $c->default_action();
          ?>

	</td>
	
	</tr>
	<tr><td colspan="2">
	<table border="1" width="100%" class="formtable">
	
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
                        <input type="text" name="oasis_wound_lesion_location[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_location[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_location[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Type","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Status","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Size (cm)","e");?>
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="">
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="">
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="">
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="">
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="">
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="">
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="">
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="">
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="">
                    </td>
                </tr>
                <tr>
                   <td>
                        <?php xl("Stage (pressure ulcers only)","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Tunneling/Undermining","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Odor","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value= "">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Surrounding Skin","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Edema","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Stoma","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Appearance of the Wound Bed","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Drainage Amount","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Color","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Consistency","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="">
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="">
                    </td>
				</tr>
					
	
	</table>
	</td>
	</tr>




<tr class="formtable">
		<td colspan="2">
			<center><strong><?php xl("INTEGUMENTARY STATUS","e");?></strong></center><br>
			<?php xl('<strong><u>(M1306)</u></strong> Does this patient have at least one <b>Unhealed Pressure Ulcer at Stage II or Higher</b> or designated as "unstageable"?','e'); ?><br>
			<label><input type="radio" name="oasis_integumentary_status" value="0"><?php xl(' 0 - No <b>[Go to M1322]</b>','e')?></label><br />
			<label><input type="radio" name="oasis_integumentary_status" value="1"><?php xl(' 1 - Yes','e')?></label>
		</td>
</tr>


<tr><td colspan="2">
		
		 <table border="1px" cellspacing="0" class="formtable">
                <tr>
                    <td align="center" colspan="6">
       <strong><?php xl("BRADEN SCALE - For Predicting Pressure Sore Risk","e");?></strong><br>
                        <?php xl("*Fill out per organizational
policy","e");?>    &nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl("<strong>HIGH RISK:</strong> Total score less than or equal to 12","e") ?>&nbsp;&nbsp;&nbsp;
 <?php xl("<strong>MODERATE RISK:</strong> Total score 13 - 14","e") ?>&nbsp;&nbsp;&nbsp;<br />
 <?php xl("<strong>LOW RISK:</strong> Total score 15 - 18","e") ?>

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
                        <input type="text" name="oasis_braden_scale_sensory" onKeyUp="sum_braden_scale()" id="braden_sensory" value="0">
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
                        <input type="text" name="oasis_braden_scale_moisture" onKeyUp="sum_braden_scale()" id="braden_moisture" value="0">
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
                        <input type="text" name="oasis_braden_scale_activity" onKeyUp="sum_braden_scale()" id="braden_activity" value="0">
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
                        <input type="text" name="oasis_braden_scale_mobility" onKeyUp="sum_braden_scale()" id="braden_mobility" value="0">
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
                        <input type="text" name="oasis_braden_scale_nutrition" onKeyUp="sum_braden_scale()" id="braden_nutrition" value="0">
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
                        <input type="text" name="oasis_braden_scale_friction" onKeyUp="sum_braden_scale()" id="braden_friction" value="0">
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
               <input type="text" name="oasis_braden_scale_total" id="braden_total" readonly>
                    </td>
                </tr>
            </table>

</td></tr>
		

</table>

                        </li>
                    </ul>
                </li>








<li>
                    <div><a href="#" id="black">Integumentary Status(Contd) &amp; Vital Signs</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                       <ul>
<!-- *********************  Integumentary Status(Contd) & Vital Signs   ******************** -->
                        <li>


<table class="formtable" width="100%" border="1">
<tr>
		<td colspan="2">
			<?php xl("<strong><u>(M1308)</u> Current Number of Unhealed (non-epithelialized) Pressure Ulcers at Each Stage:</strong> (Enter '0' if none; excludes Stage I pressure ulcers)","e");?><br>
			<table border="1px" width="100%" cellspacing="0" class="formtable">
				<tr>
					<td width="50%" colspan="2">&nbsp;
					</td>
					<td width="25%">
						<strong><?php xl("Column 1 Complete at SOC/ROC/FU & D/C","e");?></strong>
					</td>
					<td width="25%">
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
					<td valign="top">
						<?php xl("a.","e");?>
					</td>
					<td>
						<?php xl("<strong>Stage II:</strong> Partial thickness loss of dermis presenting as a shallow open ulcer with red pink wound bed, without slough. May also present as an intact or open/ruptured serum-filled blister.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_stage2_col1" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_stage2_col2" value="">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<?php xl("b.","e");?>
					</td>
					<td>
						<?php xl("<strong>Stage III:</strong> Full thickness tissue loss. Subcutaneous fat may be visible but bone, tendon, or muscles are not exposed. Slough may be present but does not obscure the depth of tissue loss. May include undermining and tunneling.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_stage3_col1" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_stage3_col2" value="">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<?php xl("c.","e");?>
					</td>
					<td>
						<?php xl("<strong>Stage IV:</strong> Full thickness tissue loss with visible bone, tendon, or muscle. Slough or eschar may be present on some parts of the wound bed. Often includes undermining and tunneling.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_stage4_col1" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_stage4_col2" value="">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<?php xl("d1.","e");?>
					</td>
					<td>
						<?php xl("Unstageable: Known or likely but unstageable due to non-removable dressing or device","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_non_removable_col1" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_non_removable_col2" value="">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<?php xl("d2.","e");?>
					</td>
					<td>
						<?php xl("Unstageable: Known or likely but unstageable due to coverage of wound bed by slough and/or eschar.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_coverage_col1" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_coverage_col2" value="">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<?php xl("d3.","e");?>
					</td>
					<td>
						<?php xl("Unstageable: Suspected deep tissue injury in evolution.","e");?>
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_suspected_col1" value="">
					</td>
					<td align="center">
						<input type="text" name="oasis_c_nurse_suspected_col2" value="">
					</td>
				</tr>
			</table>
			<center><strong><?php xl("INTEGUMENTARY STATUS (CONTD)","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<strong><?php xl("<u>(M1322)</u> Current Number of Stage I Pressure Ulcers: ","e");?></strong> <?php xl("Intact skin with non-blanchable redness of a localized area usually over a bony prominence. The area may be painful, firm, soft, warmer or cooler as compared to adjacent tissue.","e");?><br>
			<label><input type="radio" name="oasis_c_nurse_current_ulcer_stage1" value="0">0</label> 
			<label><input type="radio" name="oasis_c_nurse_current_ulcer_stage1" value="1">1</label> 
			<label><input type="radio" name="oasis_c_nurse_current_ulcer_stage1" value="2">2</label> 
			<label><input type="radio" name="oasis_c_nurse_current_ulcer_stage1" value="3">3</label> 
			<label><input type="radio" name="oasis_c_nurse_current_ulcer_stage1" value="4 or more">4 or more</label>
			<br><hr />
			
			<strong><?php xl("<u>(M1324)</u> Stage of Most Problematic Unhealed (Observable) Pressure Ulcer:","e");?></strong> <br>
			<label><input type="radio" name="oasis_c_nurse_stage_of_problematic_ulcer" value="1"><?php xl(' 1 - Stage I ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_stage_of_problematic_ulcer" value="2"><?php xl(' 2 - Stage II ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_stage_of_problematic_ulcer" value="3"><?php xl(' 3 - Stage III ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_stage_of_problematic_ulcer" value="4"><?php xl(' 4 - Stage IV ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_stage_of_problematic_ulcer" value="NA or more"><?php xl(' NA - No observable pressure ulcer or unhealed pressure ulcer ','e')?></label>
			<br><hr />
			
			<strong><?php xl("<u>(M1330)</u>","e");?></strong> <?php xl("Does this patient have a ","e");?> <strong><?php xl("Stasis Ulcer?","e");?></strong><br>
			<label><input type="radio" name="oasis_c_nurse_statis_ulcer" value="0"><?php xl(' 0 - No <b>[Go to M1340]</b> ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_statis_ulcer" value="1"><?php xl(' 1 - Yes, patient has BOTH observable and unobservable stasis ulcers ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_statis_ulcer" value="2"><?php xl(' 2 - Yes, patient has observable stasis ulcers ONLY ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_statis_ulcer" value="3"><?php xl(' 3 - Yes, patient has unobservable stasis ulcers ONLY (known but not observable due to non-removable dressing) <b>[Go to M1340]</b> ','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1332)</u> Current Number of (Observable) Stasis Ulcer(s):","e");?></strong> <br>
			<label><input type="radio" name="oasis_c_nurse_current_no_statis_ulcer" value="1"><?php xl(' 1 - One ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_current_no_statis_ulcer" value="2"><?php xl(' 2 - Two ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_current_no_statis_ulcer" value="3"><?php xl(' 3 - Three ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_current_no_statis_ulcer" value="4"><?php xl(' 4 - Four or more ','e')?></label> <br>
			
		</td>
		<td>
			<strong><?php xl("<u>(M1334 )</u> Status of Most Problematic (Observable) Stasis Ulcer:","e");?></strong> <br>
			<label><input type="radio" name="oasis_c_nurse_problematic_statis_ulcer" value="0"><?php xl(' 0 - Newly epithelialized ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_problematic_statis_ulcer" value="1"><?php xl(' 1 - Fully granulating ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_problematic_statis_ulcer" value="2"><?php xl(' 2 - Early/partial granulation ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_problematic_statis_ulcer" value="3"><?php xl(' 3 - Not healing ','e')?></label>
			<br><hr />
			
			<strong><?php xl("<u>(M1340)</u>","e");?></strong> <?php xl("Does this patient have a ","e");?> <strong><?php xl("Surgical Wound?","e");?></strong><br>
			<label><input type="radio" name="oasis_c_nurse_surgical_wound" value="0"><?php xl(' 0 - No <b>[Go to M1350]</b> ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_surgical_wound" value="1"><?php xl(' 1 - Yes, patient has at least one (observable) surgical wound ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_surgical_wound" value="2"><?php xl(' 2 - Surgical wound known but not observable due to non-removable dressing <b>[Go to M1350]</b> ','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1342)</u> Status of Most Problematic (Observable) Surgical Wound:","e");?></strong> <br>
			<label><input type="radio" name="oasis_c_nurse_problematic_surgical_wound" value="0"><?php xl(' 0 - Newly epithelialized ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_problematic_surgical_wound" value="1"><?php xl(' 1 - Fully granulating ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_problematic_surgical_wound" value="2"><?php xl(' 2 - Early/partial granulation ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_problematic_surgical_wound" value="3"><?php xl(' 3 - Not healing ','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1350)</u>","e");?></strong>
			<?php xl("Does this patient have a ","e");?> 
			<strong><?php xl(" Skin Lesion or Open Wound, ","e");?></strong> 
			<?php xl("excluding bowel ostomy, other than those described above ","e");?><u><?php xl("that is receiving intervention","e");?></u><?php xl(" by the home health agency?","e");?><br>
			<label><input type="radio" name="oasis_c_nurse_skin_lesion" value="0"><?php xl(' 0 - No ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_skin_lesion" value="1"><?php xl(' 1 - Yes ','e')?></label> <br>
			<br><br>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl("VITAL SIGNS","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0px" width="100%" cellspacing="0" class="formtable">
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
						<input type="text" name="oasis_c_nurse_bp_lying_right">
					</td>
					<td>
						<input type="text" name="oasis_c_nurse_bp_lying_left">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Sitting","e");?>
					</td>
					<td>
						<input type="text" name="oasis_c_nurse_bp_sitting_right">
					</td>
					<td>
						<input type="text" name="oasis_c_nurse_bp_sitting_left">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("Standing","e");?>
					</td>
					<td>
						<input type="text" name="oasis_c_nurse_bp_standing_right">
					</td>
					<td>
						<input type="text" name="oasis_c_nurse_bp_standing_left">
					</td>
				</tr>
			</table>
			
			<strong><?php xl("Temperature: &deg;F","e");?></strong>
			<label><input type="radio" name="oasis_c_nurse_vital_sign_temperature" value="Oral"><?php xl(' Oral ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_vital_sign_temperature" value="Axillary"><?php xl(' Axillary ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_vital_sign_temperature" value="Rectal"><?php xl(' Rectal ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_vital_sign_temperature" value="Tympanic"><?php xl(' Tympanic ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_vital_sign_temperature" value="Temporal"><?php xl(' Temporal ','e')?></label> 
			
		</td>
		<td><strong><?php xl("Pulse:","e");?></strong>
			<table border="0px" width="100%" cellspacing="0" class="formtable">
				<tr>
					<td>
						<label><input type="radio" name="oasis_c_nurse_vital_pulse[]" value="At Rest"><?php xl(' At Rest ','e')?></label> 
						<label><input type="radio" name="oasis_c_nurse_vital_pulse[]" value="Activity/Exercise"><?php xl(' Activity/Exercise ','e')?></label> 
						<label><input type="radio" name="oasis_c_nurse_vital_pulse[]" value="Regular"><?php xl(' Regular ','e')?></label> 
						<label><input type="radio" name="oasis_c_nurse_vital_pulse[]" value="Irregular"><?php xl(' Irregular ','e')?></label> 
						<br>
						
						<label><input type="checkbox" name="oasis_c_nurse_vital_pulse[]" value="Radial"><?php xl(' Radial ','e')?></label> 
						<label><input type="checkbox" name="oasis_c_nurse_vital_pulse[]" value="Carotid"><?php xl(' Carotid ','e')?></label> 
						<label><input type="checkbox" name="oasis_c_nurse_vital_pulse[]" value="Apical"><?php xl(' Apical ','e')?></label> 
						<label><input type="checkbox" name="oasis_c_nurse_vital_pulse[]" value="Brachial"><?php xl(' Brachial ','e')?></label> 
						
					</td>
				</tr>
			</table>
			
			<strong><?php xl("Respiratory Rate:","e");?></strong>&nbsp;&nbsp;
			<label><input type="radio" name="oasis_c_nurse_vital_sign_respiratory_rate" value="Normal"><?php xl(' Normal ','e')?></label> 
				<label><input type="radio" name="oasis_c_nurse_vital_sign_respiratory_rate" value="Cheynes Stokes"><?php xl(' Cheynes Stokes ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_vital_sign_respiratory_rate" value="Death rattle"><?php xl(' Death rattle ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_vital_sign_respiratory_rate" value="Apnea"><?php xl(' Apnea /sec.','e')?></label> 
		</td>
	</tr>

</table>
</strong>
</td>
</tr>
</strong>
</td>
</tr>
</table>


                        </li>
                    </ul>
                </li>







<li>
                    <div><a href="#" id="black">Cardiopulmonary, Respiration Status &amp; Elimination Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                                       <ul>
<!-- *********************  Cardiopulmonary, Respiration Status and Elimination Status   ******************** -->
                        <li>

<table class="formtable" width="100%" border="1">
<tr>
		<td colspan="2"> 
			<center><strong>
				<?php xl('CARDIOPULMONARY','e')?>
				<label><input type="checkbox" name="oasis_c_nurse_cardiopulmonary_problem" value="<?php xl("No Problem","e");?>"><?php xl('No Problem','e')?></label>
			</strong></center>
		</td>
	</tr>
	<tr>
		<td width="50%"> 
			<strong><?php xl('Breath Sounds:','e')?></strong><br>
			<label><input type="radio" name="oasis_c_nurse_breath_sounds_type" value="Clear"><?php xl(' Clear ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_breath_sounds_type" value="Crackles/Rales"><?php xl(' Crackles/Rales ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_breath_sounds_type" value="Wheezes/Rhonchi"><?php xl(' Wheezes/Rhonchi ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_breath_sounds_type" value="Diminished"><?php xl(' Diminished ','e')?></label> 
			<label><input type="radio" name="oasis_c_nurse_breath_sounds_type" value="Absent"><?php xl(' Absent ','e')?></label> <br>
			
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Anterior","e");?>"><?php xl('Anterior:','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_anterior" value="<?php xl("Right","e");?>"><?php xl('Right','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_anterior" value="<?php xl("Left","e");?>"><?php xl('Left','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_anterior" value="<?php xl("O2 saturation","e");?>"><?php xl('O2 saturation','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Posterior","e");?>"><?php xl('Posterior:','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_posterior" value="<?php xl("Right Upper","e");?>"><?php xl('Right Upper','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_posterior" value="<?php xl("Right Lower","e");?>"><?php xl('Right Lower','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_posterior" value="<?php xl("Left Upper","e");?>"><?php xl('Left Upper','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_posterior" value="<?php xl("Left Lower","e");?>"><?php xl('Left Lower','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("O2 saturation","e");?>"><?php xl('O2 saturation:','e')?></label>
				<input type="text" name="oasis_c_nurse_breath_sounds_o2_saturation" value="">%<br>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Accessory muscles used","e");?>"><?php xl('Accessory muscles used','e')?></label>
				<input type="text" name="oasis_c_nurse_breath_sounds_accessory_muscle" value=""><br />
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_accessory_muscle_o2" value="<?php xl("O2","e");?>"><?php xl('O2','e')?></label>
				<input type="text" name="oasis_c_nurse_breath_sounds_o2"  value="" size="8">
				<?php xl('LPM per','e')?><input type="text" name="oasis_c_nurse_breath_sounds_accessory_lpm" value="">
				<br />
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Pulse Oximetry per Symptomology","e");?>"><?php xl('Pulse Oximetry per Symptomology','e')?></label><br>
			<?php xl('Does this patient have a trach?','e')?>
				<label><input type="radio" name="oasis_c_nurse_breath_sounds_trach" value="Yes"><?php xl(' Yes ','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_breath_sounds_trach" value="No"><?php xl(' No ','e')?></label><br />
			<?php xl('Who manages?','e')?>
				<label><input type="radio" name="oasis_c_nurse_breath_sounds_trach_manages" value="Self"><?php xl(' Self ','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_breath_sounds_trach_manages" value="RN"><?php xl(' RN ','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_breath_sounds_trach_manages" value="Caregiver/family"><?php xl(' Caregiver/family ','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Cough","e");?>">
<strong><?php xl('Cough:','e')?></strong></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_cough" value="<?php xl("Dry","e");?>"><?php xl('Dry','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_cough" value="<?php xl("Acute","e");?>"><?php xl('Acute','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_cough" value="<?php xl("Chronic","e");?>"><?php xl('Chronic','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Productive","e");?>"><b><?php xl('Productive:','e')?></b></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_productive" value="<?php xl("Thick","e");?>"><?php xl('Thick','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_breath_sounds_productive" value="<?php xl("Thin","e");?>"><?php xl('Thin','e')?></label>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><?php xl('Color','e')?>
<input type="text" name="oasis_c_nurse_cardio_breath_color" id="oasis_c_nurse_cardio_breath_color" size="10" />
</label> &nbsp;
<label><?php xl('Amount','e')?>
<input type="text" name="oasis_c_nurse_cardio_breath_amt" id="oasis_c_nurse_cardio_breath_amt" size="10" />
</label> &nbsp;<br />
				
				
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Dyspnea","e");?>">
<strong><?php xl('Dyspnea:','e')?></strong></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Rest","e");?>"><?php xl('Rest','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Exertion","e");?>"><?php xl('Exertion','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Ambulation feet","e");?>"><?php xl('Ambulation feet','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("During ADLs","e");?>"><?php xl('During ADL"s','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Orthopnea","e");?>"><?php xl('Orthopnea','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_breath_sounds[]" value="<?php xl("Other","e");?>"><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_c_nurse_breath_sounds_other" value=""><br>
			
			
		</td>
		<td> 
			<strong><?php xl('Heart Sounds:','e')?></strong><br>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_type" value="<?php xl("Regular","e");?>"><?php xl('Regular','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_type" value="<?php xl("Irregular","e");?>"><?php xl('Irregular','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_type" value="<?php xl("Murmur","e");?>"><?php xl('Murmur','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_heart_sounds[]" value="<?php xl("Pacemaker","e");?>"><?php xl('Pacemaker:','e')?></label>
				<input type="text" name="oasis_c_nurse_heart_sounds_pacemaker" value="">&nbsp;&nbsp;
				<?php xl('Date:','e')?><input type='text' size='10' name='oasis_c_nurse_heart_sounds_pacemaker_date' id='oasis_c_nurse_heart_sounds_pacemaker_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date16' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_c_nurse_heart_sounds_pacemaker_date", ifFormat:"%Y-%m-%d", button:"img_curr_date16"});
						</script>

	
				<?php xl('Type:','e')?><input type="text" name="oasis_c_nurse_heart_sounds_pacemaker_type" value=""><br>
			<label><input type="checkbox" name="oasis_c_nurse_heart_sounds[]" value="<?php xl("Chest Pain","e");?>">
<strong><?php xl('Chest Pain:','e')?></strong></label><br />
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Anginal","e");?>"><?php xl('Anginal','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Postural","e");?>"><?php xl('Postural','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Localized","e");?>"><?php xl('Localized','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Substernal","e");?>"><?php xl('Substernal','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Radiating","e");?>"><?php xl('Radiating','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Dull","e");?>"><?php xl('Dull','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Ache","e");?>"><?php xl('Ache','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Sharp","e");?>"><?php xl('Sharp','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_chest_pain" value="<?php xl("Vise-like","e");?>"><?php xl('Vise-like','e')?></label><br>
			<b><?php xl('Associated with:','e')?></b>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_associated_with" value="<?php xl("Shortness of breath","e");?>"><?php xl('Shortness of breath','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_associated_with" value="<?php xl("Activity","e");?>"><?php xl('Activity','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_associated_with" value="<?php xl("Sweats","e");?>"><?php xl('Sweats','e')?></label><br>
			<b><?php xl('Frequency/duration:','e')?></b>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_frequency" value="<?php xl("Palpitations","e");?>"><?php xl('Palpitations','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_frequency" value="<?php xl("Fatigue","e");?>"><?php xl('Fatigue','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_heart_sounds[]" value="<?php xl("Edema","e");?>">
<strong><?php xl('Edema:','e')?></strong></label><br />
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_edema" value="<?php xl("Pedal Right/Left","e");?>"><?php xl('Pedal Right/Left','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_edema" value="<?php xl("Sacral","e");?>"><?php xl('Sacral','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_edema" value="<?php xl("Dependent","e");?>"><?php xl('Dependent:','e')?></label>
				<br />
				<label><input type="radio" name="oasis_c_nurse_heart_sounds_edema_dependent" value="<?php xl("Pitting +1","e");?>"><?php xl('Pitting +1','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_heart_sounds_edema_dependent" value="<?php xl("Pitting +2","e");?>"><?php xl('Pitting +2','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_heart_sounds_edema_dependent" value="<?php xl("Pitting +3","e");?>"><?php xl('Pitting +3','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_heart_sounds_edema_dependent" value="<?php xl("Pitting +4","e");?>"><?php xl('Pitting +4','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_heart_sounds_edema_dependent" value="<?php xl("Non-pitting","e");?>"><?php xl('Non-pitting','e')?></label><br>
			<b><?php xl("Site","e");?></b>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_site" value="<?php xl("Cramps","e");?>"><?php xl('Cramps','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_heart_sounds_site" value="<?php xl("Claudication","e");?>"><?php xl('Claudication','e')?></label><br>
			<?php xl("Capillary refill","e");?>
				<label><input type="radio" name="oasis_c_nurse_heart_sounds_capillary" value="<?php xl("less than 3 sec","e");?>"><?php xl('less than 3 sec','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_heart_sounds_capillary" value="<?php xl("greater than 3 sec","e");?>"><?php xl('greater than 3 sec','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_heart_sounds[]" value="<?php xl("Other","e");?>"><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_c_nurse_heart_sounds_other" value=""><br>
			<label><input type="checkbox" name="oasis_c_nurse_heart_sounds[]" value="<?php xl("Weigh patient","e");?>"><?php xl('Weigh patient','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_heart_sounds[]" value="<?php xl("Notify MD of weight variations of","e");?>"><?php xl('Notify MD of weight variations of','e')?></label>
			<input type="text" name="oasis_c_nurse_weight_variation" value="">
				
				
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl("RESPIRATORY STATUS","e");?></strong></center><br>
			<strong><?php xl("(M1400)","e");?></strong>
			<?php xl(" When is the patient dyspneic or noticeably ","e");?> 
			<strong><?php xl(" Short of Breath?","e");?></strong> <br />
			<label><input type="radio" name="oasis_c_nurse_respiratory_status" value="0"><?php xl(' 0 - Patient is not short of breath ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_respiratory_status" value="1"><?php xl(' 1 - When walking more than 20 feet, climbing stairs ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_respiratory_status" value="2"><?php xl(' 2 - With moderate exertion (e.g., while dressing, using commode or bedpan, walking distances less than 20 feet) ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_respiratory_status" value="3"><?php xl(' 3 - With minimal exertion (e.g., while eating, talking, or performing other ADLs) or with agitation ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_respiratory_status" value="4"><?php xl(' 4 - At rest (during day or night) ','e')?></label> <br>
			<br><br>
			
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl("ELIMINATION STATUS","e");?></strong></center>
		</td>
	</tr>
	<tr valign="top">
		<td width="50%">
			<center><strong>
				<?php xl("GENITOURINARY / URINARY","e");?>
				<label><input type="checkbox" name="oasis_c_nurse_urinary_problem" value="<?php xl("No Problem","e");?>"><?php xl('No Problem','e')?></label>
			</strong></center>
			<?php xl("(Check all applicable items)","e");?><br>
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Urgency/frequency","e");?>"><?php xl('Urgency/frequency','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Burning/pain","e");?>"><?php xl('Burning/pain','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Hesitancy","e");?>"><?php xl('Hesitancy','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Nocturia","e");?>"><?php xl('Nocturia','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Hematuria","e");?>"><?php xl('Hematuria','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Oliguria/anuria","e");?>"><?php xl('Oliguria/anuria','e')?></label><br />
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Incontinence","e");?>"><?php xl('Incontinence (details if applicable)','e')?></label><br />
				<input type="text" name="oasis_c_nurse_urinary_incontinence" value=""><br>
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Management Strategies","e");?>"><?php xl('Management Strategies:','e')?></label>
				<input type="text" name="oasis_c_nurse_urinary_management_strategy" value=""><br>
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="<?php xl("Diapers/other:","e");?>"><?php xl('Diapers/other:','e')?></label>
				<input type="text" name="oasis_c_nurse_urinary_diapers_other" value=""><br>
			<b><?php xl("Color:","e");?></b>
				<label><input type="radio" name="oasis_c_nurse_urinary_color" value="Yellow/straw"><?php xl('Yellow/straw','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_urinary_color" value="Amber"><?php xl('Amber','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_urinary_color" value="Brown/gray"><?php xl('Brown/gray','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_urinary_color" value="Blood-tinged"><?php xl('Blood-tinged','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_urinary_color" value="Other"><?php xl('Other','e')?></label>
				<input type="text" name="oasis_c_nurse_urinary_color_other" value=""><br>
			<b><?php xl("Clarity:","e");?></b>
				<label><input type="radio" name="oasis_c_nurse_urinary_clarity" value="Clear"><?php xl('Clear','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_urinary_clarity" value="Cloudy"><?php xl('Cloudy','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_urinary_clarity" value="Sediment/mucous"><?php xl('Sediment/mucous','e')?></label>
				<br />
			<b><?php xl("Odor:","e");?></b>
				<label><input type="radio" name="oasis_c_nurse_urinary_odor" value="Yes"><?php xl('Yes','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_urinary_odor" value="No"><?php xl('No','e')?></label>
			
<br /><?php xl("<b>Urinary Catheter:</b> Type (specify)","e");?>
				<input type="text" name="oasis_c_nurse_urinary_catheter" value=""><br>
			<?php xl("Date last changed","e");?><br>
				<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="Foley inserted"><?php xl('Foley inserted','e')?></label>
				<input type='text' size='10' name='oasis_c_nurse_urinary_foley_date' id='oasis_c_nurse_urinary_foley_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date17' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_c_nurse_urinary_foley_date", ifFormat:"%Y-%m-%d", button:"img_curr_date17"});
						</script>
				<?php xl("with French Inflated balloon with","e");?>
				<input type="text" name="oasis_c_nurse_urinary_foley_ml" value=""><?php xl("ml","e");?>&nbsp;&nbsp;
				<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="without difficulty"><?php xl('without difficulty','e')?></label><br>
			<?php xl("<b>Irrigation solution:</b> Type (specify)","e");?>
				<input type="text" name="oasis_c_nurse_urinary_irrigation_solution" value=""><br>
				<?php xl("Amount","e");?>
				<input type="text" name="oasis_c_nurse_urinary_irrigation_amount" value="">
				<?php xl("ml","e");?>
				<input type="text" name="oasis_c_nurse_urinary_irrigation_ml" value="">
				<?php xl("Frequency","e");?>
				<input type="text" name="oasis_c_nurse_urinary_irrigation_frequency" value="">
				<?php xl("Returns","e");?>
				<input type="text" name="oasis_c_nurse_urinary_irrigation_returns" value=""><br>
			<?php xl("Patient tolerated procedure well","e");?>
				<label><input type="radio" name="oasis_c_nurse_urinary_tolerated_procedure" value="Yes"><?php xl('Yes','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_urinary_tolerated_procedure" value="No"><?php xl('No','e')?></label>
				<br />
			<label><input type="checkbox" name="oasis_c_nurse_urinary[]" value="Other"><?php xl('Other (specify)','e')?></label>
				<input type="text" name="oasis_c_nurse_urinary_other" value=""><br>
				
			<center><strong>
				<?php xl("BOWELS","e");?>
				<label><input type="checkbox" name="oasis_c_nurse_bowels_problem" value="<?php xl("No Problem","e");?>"><?php xl('No Problem','e')?></label>
			</strong></center>
			<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Flatulence"><?php xl('Flatulence','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Constipation/impaction"><?php xl('Constipation/impaction','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Diarrhea"><?php xl('Diarrhea','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Rectal bleeding"><?php xl('Rectal bleeding','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Hemorrhoids"><?php xl('Hemorrhoids','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Last BM"><?php xl('Last BM','e')?></label>
				<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Frequency of stools"><?php xl('Frequency of stools','e')?></label>
			<br />
			<?php xl("Bowel regime/program:","e");?>
				<input type="text" name="oasis_c_nurse_bowel_regime" value=""><br>
			<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Laxative/Enema use"><?php xl('Laxative/Enema use:','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_bowels_lexative_enema" value="Daily"><?php xl('Daily','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_bowels_lexative_enema" value="Weekly"><?php xl('Weekly','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_bowels_lexative_enema" value="Monthly"><?php xl('Monthly','e')?></label><br>
				<label><input type="radio" name="oasis_c_nurse_bowels_lexative_enema" value="Other"><?php xl('Other:','e')?></label>
					<input type="text" name="oasis_c_nurse_bowels_lexative_enema_other" value=""><br>
			<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Incontinence"><?php xl('Incontinence (details if applicable)','e')?></label>
				<input type="text" name="oasis_c_nurse_bowels_incontinence" value=""><br>
			<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Diapers/other"><?php xl('Diapers/other:','e')?></label>
				<input type="text" name="oasis_c_nurse_bowels_diapers_others" value=""><br>
			<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Ileostomy/colostomy"><?php xl('Ileostomy/colostomy site (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" cols="48" name="oasis_c_nurse_bowels_ileostomy_site"></textarea><br>
			<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Ostomy care managed"><?php xl('Ostomy care managed by:','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_bowels_ostomy_care" value="Self"><?php xl('Self','e')?></label>
				<label><input type="radio" name="oasis_c_nurse_bowels_ostomy_care" value="Caregiver"><?php xl('Caregiver','e')?></label>
			<br />
			<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Other site"><?php xl('Other site (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" cols="48" name="oasis_c_nurse_bowels_other_site"></textarea><br>
			<label><input type="checkbox" name="oasis_c_nurse_bowels[]" value="Urostomy"><?php xl('Urostomy (describe skin around stoma):','e')?></label><br>
				<textarea rows="3" cols="48" name="oasis_c_nurse_bowels_urostomy"></textarea><br>
				
			
		</td>
		<td>
			<strong><?php xl("(M1610) ","e");?></strong>
			<strong><?php xl(" Urinary Incontinence or Urinary Catheter Presence:","e");?></strong> <br />
			<label><input type="radio" name="oasis_c_nurse_elimination_urinary_incontinence" value="0"><?php xl(' 0 - No incontinence or catheter (includes anuria or ostomy for urinary drainage) <b>[Go to M1620]</b> ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_urinary_incontinence" value="1"><?php xl(' 1 - Patient is incontinent ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_urinary_incontinence" value="2"><?php xl(' 2 - Patient requires a urinary catheter (i.e., external, indwelling, intermittent, suprapubic) <b>[Go to M1620]</b> ','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("(M1620)","e");?></strong>
			<strong><?php xl(" Bowel Incontinence Frequency:","e");?></strong> <br />
			<label><input type="radio" name="oasis_c_nurse_elimination_bowel_incontinence" value="0"><?php xl(' 0 - Very rarely or never has bowel incontinence','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_bowel_incontinence" value="1"><?php xl(' 1 - Less than once weekly','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_bowel_incontinence" value="2"><?php xl(' 2 - One to three times weekly ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_bowel_incontinence" value="3"><?php xl(' 3 - Four to six times weekly','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_bowel_incontinence" value="4"><?php xl(' 4 - On a daily basis','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_bowel_incontinence" value="5"><?php xl(' 5 - More often than once daily ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_bowel_incontinence" value="NA"><?php xl(' NA - Patient has ostomy for bowel elimination','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_bowel_incontinence" value="UK"><?php xl(' UK - Unknown <b>[Omit "UK" option on FU, DC]</b>','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("(M1630) ","e");?></strong>
			<strong><?php xl(" Ostomy for Bowel Elimination:","e");?></strong> <br />
			<?php xl(" Does this patient have an ostomy for bowel elimination that (within the last 14 days): a) was related to an inpatient facility stay, <u>or</u> b) necessitated a change in medical or treatment regimen?","e");?><br />
			<label><input type="radio" name="oasis_c_nurse_elimination_ostomy" value="0"><?php xl(' 0 - Patient does <u>not</u> have an ostomy for bowel elimination. ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_ostomy" value="1"><?php xl(' 1 - Patient"s ostomy was <u>not</u> related to an inpatient stay and did <u>not</u> necessitate change in medical or treatment regimen. ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_elimination_ostomy" value="2"><?php xl(' 2 - The ostomy <u>was</u> related to an inpatient stay or <u>did</u> necessitate change in medical or treatment regimen.','e')?></label> <br>
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
<table width="100%" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("ADL/IADLs","e");?></strong></center>
		</td>
	</tr>
	<tr valign="top">
		<td width="50%">
			<strong><u><?php xl("(M1810) ","e");?></u></strong>
			<?php xl("Current ","e");?>
			<strong><?php xl(" Ability to Dress <u>Upper</u> Body ","e");?></strong> 
			<?php xl(" safely (with or without dressing aids) including undergarments, pullovers, front-opening shirts and blouses, managing zippers, buttons, and snaps:","e");?><br />
			<label><input type="radio" name="oasis_c_nurse_adl_dress_upper" value="0"><?php xl(' 0 - Able to get clothes out of closets and drawers, put them on and remove them from the  upper body without assistance. ','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_dress_upper" value="1"><?php xl(' 1 - Able to dress upper body without assistance if clothing is laid out or handed to the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_dress_upper" value="2"><?php xl(' 2 - Someone must help the patient put on upper body clothing.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_dress_upper" value="3"><?php xl(' 3 - Patient depends entirely upon another person to dress the upper body.','e')?></label> <br>
			<br><hr />
			
			<strong><u><?php xl("(M1820) ","e");?></u></strong>
			<?php xl("Current ","e");?>
			<strong><?php xl("Ability to Dress <u>Lower</u> Body ","e");?></strong> 
			<?php xl(" safely (with or without dressing aids) including undergarments, slacks, socks or nylons, shoes:","e");?><br />
			<label><input type="radio" name="oasis_c_nurse_adl_dress_lower" value="0"><?php xl(' 0 - Able to obtain, put on, and remove clothing and shoes without assistance.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_dress_lower" value="1"><?php xl(' 1 - Able to dress lower body without assistance if clothing and shoes are laid out or handed to the patient.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_dress_lower" value="2"><?php xl(' 2 - Someone must help the patient put on undergarments, slacks, socks or nylons, and shoes.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_dress_lower" value="3"><?php xl(' 3 - Patient depends entirely upon another person to dress lower body.','e')?></label> <br>
			<br><hr />
			
			<strong><?php xl("<u>(M1830)</u> Bathing: ","e");?></strong>
			<?php xl("Current ability to wash entire body safely. ","e");?>
			<strong><?php xl("<u>Excludes</u> grooming (washing face, washing hands, and shampooing hair). ","e");?></strong> <br />
			<label><input type="radio" name="oasis_c_nurse_adl_wash" value="0"><?php xl(' 0 - Able to bathe self in <u>shower or tub</u> independently, including getting in and out of tub/shower.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_wash" value="1"><?php xl(' 1 - With the use of devices, is able to bathe self in shower or tub independently, including getting in and out of the tub/shower.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_wash" value="2"><?php xl(' 2 - Able to bathe in shower or tub with the intermittent assistance of another person:<br>
(a) for intermittent supervision or encouragement or reminders, <u>OR</u><br>
(b) to get in and out of the shower or tub, <u>OR</u><br>
(c) for washing difficult to reach areas.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_wash" value="3"><?php xl(' 3 - Able to participate in bathing self in shower or tub, <u>but</u> requires presence of another person throughout the bath for assistance or supervision.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_wash" value="4"><?php xl(' 4 - Unable to use the shower or tub, but able to bathe self independently with or without the use of devices at the sink, in chair, or on commode.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_wash" value="5"><?php xl(' 5 - Unable to use the shower or tub, but able to participate in bathing self in bed, at the sink, in bedside chair, or on commode, with the assistance or supervision of another person throughout the bath.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_wash" value="6"><?php xl(' 6 - Unable to participate effectively in bathing and is bathed totally by another person.','e')?></label> <br>
			<br><hr />

			<strong><?php xl("<u>(M1840)</u> Toilet Transferring: ","e");?></strong>
			<?php xl("Current ability to get to and from the toilet or bedside commode safely <u>and</u> transfer on and off toilet/commode. ","e");?><br />
			<label><input type="radio" name="oasis_c_nurse_adl_toilet_transfer" value="0"><?php xl(' 0 - Able to get to and from the toilet and transfer independently with or without a device.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_toilet_transfer" value="1"><?php xl(' 1 - When reminded, assisted, or supervised by another person, able to get to and from the toilet and transfer.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_toilet_transfer" value="2"><?php xl(' 2 - <u>Unable</u> to get to and from the toilet but is able to use a bedside commode (with or without assistance).','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_toilet_transfer" value="3"><?php xl(' 3 - <u>Unable</u> to get to and from the toilet or bedside commode but is able to use a bedpan/urinal independently.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_toilet_transfer" value="4"><?php xl(' 4 - Is totally dependent in toileting.','e')?></label> <br>
			<br>
			
		</td>
<td>


			
			<strong><?php xl("<u>(M1850)</u> Transferring: ","e");?></strong>
			<?php xl("Current ability to move safely from bed to chair, or ability to turn and position self in bed if patient is bedfast.","e");?><br />
			<label><input type="radio" name="oasis_c_nurse_adl_transferring" value="0"><?php xl(' 0 - Able to independently transfer.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_transferring" value="1"><?php xl(' 1 - Able to transfer with minimal human assistance or with use of an assistive device.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_transferring" value="2"><?php xl(' 2 - Able to bear weight and pivot during the transfer process but unable to transfer self.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_transferring" value="3"><?php xl(' 3 - Unable to transfer self and is unable to bear weight or pivot when transferred by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_transferring" value="4"><?php xl(' 4 - Bedfast, unable to transfer but is able to turn and position self in bed','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_transferring" value="5"><?php xl(' 5 - Bedfast, unable to transfer and is unable to turn and position self.','e')?></label>
			<br><hr />
			
			<strong><?php xl("<u>(M1860)</u> Ambulation/Locomotion: ","e");?></strong>
			<?php xl("Current ability to walk safely, once in a standing position, or use a wheelchair, once in a seated position, on a variety of surfaces.","e");?><br />
			<label><input type="radio" name="oasis_c_nurse_adl_ambulation" value="0"><?php xl(' 0 - Able to independently walk on even and uneven surfaces and negotiate stairs with or without railings (i.e., needs no human assistance or assistive device).','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_ambulation" value="1"><?php xl(' 1 - With the use of a one-handed device (e.g. cane, single crutch, hemi-walker), able to independently walk on even and uneven surfaces and negotiate stairs with or without railings.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_ambulation" value="2"><?php xl(' 2 - Requires use of a two-handed device (e.g., walker or crutches) to walk alone on a level surface and/or requires human supervision or assistance to negotiate stairs or steps or uneven surfaces.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_ambulation" value="3"><?php xl(' 3 - Able to walk only with the supervision or assistance of another person at all times.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_ambulation" value="4"><?php xl(' 4 - Chairfast, <u>unable</u> to ambulate but is able to wheel self independently.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_ambulation" value="5"><?php xl(' 5 - Chairfast, unable to ambulate and is <u>unable</u> to wheel self.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_adl_ambulation" value="6"><?php xl(' 6 - Bedfast, unable to ambulate or be up in a chair.','e')?></label> <br>
			<br /><hr />
			
			<center><strong><?php xl("ACTIVITIES PERMITTED","e");?></strong></center><br>
			<table class="formtable" border="0">
				<tr>
					<td>
						1. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Complete Bedrest"><?php xl('Complete Bedrest','e')?></label><br>
						2. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Bedrest w/ BRP"><?php xl('Bedrest w/ BRP','e')?></label><br>
						3. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Up as tolerated"><?php xl('Up as tolerated','e')?></label><br>
						4. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Transfer Bed/Chair"><?php xl('Transfer Bed/Chair','e')?></label><br>
						5. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Exercises Prescribed"><?php xl('Exercises Prescribed','e')?></label><br>
						6. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Partial Weight Bearing"><?php xl('Partial Weight Bearing','e')?></label><br>
						7. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Independent At Home"><?php xl('Independent At Home','e')?></label><br>
					</td>
					<td>
						8. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Crutches"><?php xl('Crutches','e')?></label><br>
						9. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Cane"><?php xl('Cane','e')?></label><br>
						A. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Wheelchair"><?php xl('Wheelchair','e')?></label><br>
						B. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Walker"><?php xl('Walker','e')?></label><br>
						C. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="No Restrictions"><?php xl('No Restrictions','e')?></label><br>
						D. <label><input type="checkbox" name="oasis_c_nurse_activities_permitted[]" value="Other"><?php xl('Other (specify):','e')?></label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						   <input type="text" name="oasis_c_nurse_activities_permitted_other" value=""><br>
					</td>
				</tr>
			</table>
			<br /><hr />
			
			<center><strong><?php xl("MEDICATION","e");?></strong></center><br>
			<strong><?php xl("(M2030) Management of Injectable Medications: ","e");?></strong>
			<?php xl("<u>Patient's current ability</u> to prepare and take <u>all</u> prescribed injectable medications reliably and safely, including administration of correct dosage at the appropriate times/intervals. <b><u>Excludes</u> IV medications.</b>","e");?><br />
			<label><input type="radio" name="oasis_c_nurse_medication" value="0"><?php xl(' 0 - Able to independently take the correct medication(s) and proper dosage(s) at the correct times.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_medication" value="1"><?php xl(' 1 - Able to take injectable medication(s) at the correct times if:<br>
(a) individual syringes are prepared in advance by another person; <u>OR</u><br>
(b) another person develops a drug diary or chart.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_medication" value="2"><?php xl(' 2 - Able to take medication(s) at the correct times if given reminders by another person based on the frequency of the injection','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_medication" value="3"><?php xl(' 3 - <u>Unable</u> to take injectable medication unless administered by another person.','e')?></label> <br>
			<label><input type="radio" name="oasis_c_nurse_medication" value="NA"><?php xl(' NA - No injectable medications prescribed.','e')?></label> <br>
			<br /><hr />
			
			<center><strong><?php xl("THERAPY NEED","e");?></strong></center><br>
			<strong><?php xl("(M2200) Therapy Need: ","e");?></strong>
			<?php xl("In the home health plan of care for the Medicare payment episode for which this assessment will define a case mix group, what is the indicated need for therapy visits (total of reasonable and necessary physical, occupational, and speech-language pathology visits combined)? <b>( Enter zero [ '000' ] if no therapy visits indicated.)</b>","e");?><br>
			<input type="text" name="oasis_c_nurse_therapy_need_number" value=""><?php xl('- Number of therapy visits indicated (total of physical, occupational and speech-language pathology combined).','e');?><br>
			<label><input type="checkbox" name="oasis_c_nurse_therapy_need" value="NA"><?php xl('NA - Not Applicable: No case mix group defined by this assessment.','e')?></label><br>


</td>
	</tr>
</table>
				</li>
			</ul>
		</li>






<li>

<div><a href="#" id="black">Fall Risk Assessment/Reassessment, Enteral Feeding, Infusion, Time Up and Go Test, Amplification of Care, Homebound Reason</a> <span id="mod"><a href="#">(Expand)</a></span></div>

			                    <ul>
				<li>
<table width="100%" border="1px" class="formtable">
	<tr valign="top">
		<td width="50%">

<center><strong><?php xl("FALL RISK REASSESSMENT","e");?></strong></center><br>
			<?php xl("1. Any falls reported since last OASIS assessment?","e");?>
			<label><input type="radio" name="oasis_c_nurse_fall_risk_reported" value="No"><?php xl(' No','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_fall_risk_reported" value="Yes"><?php xl(' Yes','e')?></label> <br>
				<textarea name="oasis_c_nurse_fall_risk_reported_details" rows="3" cols="48"></textarea><br>
			
			<?php xl("2. Have fall risk factors changed since prior assessment?","e");?><br />
			<label><input type="radio" name="oasis_c_nurse_fall_risk_factors" value="No"><?php xl(' No','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_fall_risk_factors" value="Yes"><?php xl(' Yes','e')?></label> <br>
				<textarea name="oasis_c_nurse_fall_risk_factors_details" rows="3" cols="48"></textarea><br>
				
			<table class="formtable" width="100%" border="1">
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
						<b><?php xl("Age 65+","e");?></b>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Age 65+"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Diagnosis (3 or more co-existing) :</b> Assess for hypotension","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Diagnosis"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Prior History of fall within 3 months :</b> Fall Definition, 'An unintentional change in position resulting in coming to rest on the ground or at a lower level.'","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Prior History of fall within 3 months"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Incontinence :</b> Inability to make it to the bathroom or commode in timely manner. Includes frequency, urgency, and/or nocturia","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Incontinence"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Visual impairment :</b> Includes macular degeneration, diabetic retinopathies, visual field loss, age related changes, decline in visual acuity, accommodation, glare tolerance, depth perception, and night vision or not wearing prescribed glasses or having the correct prescription.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Visual impairment"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Impaired functional mobility :</b> May include patients who need help with IADLS or ADLS or have gait or transfer problems, arthritis, pain, fear of falling, foot problems, impaired sensation, impaired coordination or improper use of assistive devices.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Impaired functional mobility"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Environmental hazards :</b> May include poor illumination, equipment tubing, inappropriate footwear, pets, hard to reach items, floor surfaces that are uneven or cluttered, or outdoor entry and exits.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Environmental hazards"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Poly Pharmacy (4 or more prescriptions) :</b> Drugs highly associated with fall risk include but not limited to, sedatives, anti-depressants, tranquilizers, narcotics, antihypertensives, cardiac meds, corticosteroids, anti-anxiety drugs, anticholinergic drugs, and hypoglycemic drugs.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Poly Pharmacy"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Pain affecting level of function :</b> Pain often affects an individual's desire or ability to move or pain can be a factor in depression or compliance with safety recommendations.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Pain affecting level of function"></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("<b>Cognitive impairment :</b> Could include patients with dementia, Alzheimer's or stroke patients or patients who are confused, use poor judgment, have decreased comprehension, impulsivity, memory deficits. Consider patients ability to adhere to the plan of care.","e");?>
					</td>
					<td>
						<label><?php xl('Yes - 1','e')?><input type="checkbox" name="oasis_c_nurse_fall_risk_assessment[]" onchange="sumfallrisk(this);" value="Cognitive impairment"></label>
					</td>
				</tr>
				<tr>
					<td align="right">
						<b><?php xl("A score of 4 or more is considered at risk for falling<br />Total","e");?></b>
					</td>
					<td>
						<input type="text" name="oasis_c_nurse_fall_risk_assessment_total" id="oasis_c_nurse_fall_risk_assessment_total" value="0" size="5" readonly></label>
					</td>
				</tr>
			</table>
			<br>
			<b><?php xl("Plan/Comments:","e");?></b><br>
			<textarea name="oasis_c_nurse_fall_risk_assessment_comments" rows="3" cols="48"></textarea><br>
<br />
<center><strong><?php xl('ENTERAL FEEDINGS - ACCESS DEVICE','e')?></strong></center>
<br />
<label>
<input type="checkbox" name="oasis_c_nurse_enteral[]" value="Nasogastric"  id="oasis_c_nurse_enteral" />
<?php xl('Nasogastric','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_enteral[]" value="Gastrostomy"  id="oasis_c_nurse_enteral" />
<?php xl('Gastrostomy','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_enteral[]" value="Jejunostomy"  id="oasis_c_nurse_enteral" />
<?php xl('Jejunostomy','e')?></label> &nbsp;<br />
<label>
<input type="checkbox" name="oasis_c_nurse_enteral[]" value="Other (specify)"  id="oasis_c_nurse_enteral" />
<?php xl('Other (specify)','e')?></label> &nbsp;

<input type="text" name="oasis_c_nurse_enteral_other" id="oasis_c_nurse_enteral_other" size="30" />
<br />

<label>
<strong><?php xl('Pump: (type/specify)','e')?></strong> &nbsp;
<input type="text" name="oasis_c_nurse_enteral_pump" id="oasis_c_nurse_enteral_pump" size="30" />
</label>
<br />

<strong><?php xl('Feedings:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_enteral_feedings" value="Bolus"  id="oasis_c_nurse_enteral_feedings" />
<?php xl('Bolus','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_enteral_feedings" value="Continuous"  id="oasis_c_nurse_enteral_feedings" />
<?php xl('Continuous','e')?></label> &nbsp;

<label><?php xl('Rate:','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_enteral_rate" id="oasis_c_nurse_enteral_rate" size="14" />
</label>
<br />

<label>
<strong><?php xl('Flush Protocol: (amt./specify)','e')?></strong> &nbsp;
<textarea name="oasis_c_nurse_enteral_flush" rows="2" cols="48"></textarea>
</label>
<br />


<strong><?php xl('Performed by:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_enteral_performed_by" value="Self"  id="oasis_c_nurse_enteral_performed_by" />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_enteral_performed_by" value="RN"  id="oasis_c_nurse_enteral_performed_by" />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_enteral_performed_by" value="Caregiver"  id="oasis_c_nurse_enteral_performed_by" />
<?php xl('Caregiver','e')?></label> &nbsp;
<br />
<label>

<input type="checkbox" name="oasis_c_nurse_enteral_performed_by" value="Other"  id="oasis_c_nurse_enteral_performed_by" />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="oasis_c_nurse_enteral_performed_by_other" id="oasis_c_nurse_enteral_performed_by_other" size="45" />
<br />

<label>
<strong><?php xl('Dressing/Site care:(specify)','e')?></strong> &nbsp;
<textarea name="oasis_c_nurse_enteral_dressing" rows="2" cols="48"></textarea>
</label>
<br />



</td>


<!-- **************************************   second Column   ************************************ -->


<td>
<center><strong><?php xl('INFUSION','e')?></strong>
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="NA"  id="oasis_c_nurse_infusion" />
<?php xl('NA','e')?></label> &nbsp;
</center>
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Peripheral: (specify)"  id="oasis_c_nurse_infusion" />
<strong><?php xl('Peripheral: (specify)','e')?></strong></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_peripheral" id="oasis_c_nurse_infusion_peripheral" size="25" /><br />
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="PICC: (specify, size, brand)"  id="oasis_c_nurse_infusion" />
<strong><?php xl('PICC: (specify, size, brand)','e')?></strong></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_PICC" id="oasis_c_nurse_infusion_PICC" size="25" /><br />
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Central"  id="oasis_c_nurse_infusion" /><?php xl('Central','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Midline/Midclavicular"  id="oasis_c_nurse_infusion" /><?php xl('Midline/Midclavicular','e')?></label><br />
&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_central" value="Single lumen"  id="oasis_c_nurse_infusion_central" />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_central" value="Double lumen"  id="oasis_c_nurse_infusion_central" />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_central" value="Triple lumen"  id="oasis_c_nurse_infusion_central" />
<?php xl('Triple lumen','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;

<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_c_nurse_infusion_central_date' id='oasis_c_nurse_infusion_central_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date99' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_c_nurse_infusion_central_date", ifFormat:"%Y-%m-%d", button:"img_curr_date99"});
                        </script>
<br />
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="X-ray verification:"  id="oasis_c_nurse_infusion" />
<strong><?php xl('X-ray verification:','e')?></strong></label> &nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_xray" value="Yes"  id="oasis_c_nurse_infusion_xray" />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_xray" value="No"  id="oasis_c_nurse_infusion_xray" />
<?php xl('No','e')?></label> &nbsp;

<br />
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Mid arm circumference in/cm"  id="oasis_c_nurse_infusion" />
<?php xl('Mid arm circumference in/cm','e')?></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_circum" id="oasis_c_nurse_infusion_circum" size="25" /><br />
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="External catheter length in/cm"  id="oasis_c_nurse_infusion" />
<?php xl('External catheter length in/cm','e')?></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_length" id="oasis_c_nurse_infusion_length" size="25" /><br />
<br />

<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Hickman"  id="oasis_c_nurse_infusion" />
<?php xl('Hickman','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Broviac"  id="oasis_c_nurse_infusion" />
<?php xl('Broviac','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Groshong"  id="oasis_c_nurse_infusion" />
<?php xl('Groshong','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Jugular"  id="oasis_c_nurse_infusion" />
<?php xl('Jugular','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Subclavian"  id="oasis_c_nurse_infusion" />
<?php xl('Subclavian','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
<label><input type="radio" name="oasis_c_nurse_infusion_hickman" value="Single lumen"  id="oasis_c_nurse_infusion_hickman" />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_hickman" value="Double lumen"  id="oasis_c_nurse_infusion_hickman" />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_hickman" value="Triple lumen"  id="oasis_c_nurse_infusion_hickman" />
<?php xl('Triple lumen','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_c_nurse_infusion_hickman_date' id='oasis_c_nurse_infusion_hickman_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date19' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_c_nurse_infusion_hickman_date", ifFormat:"%Y-%m-%d", button:"img_curr_date19"});
                        </script>
<br />



<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Epidural catheter"  id="oasis_c_nurse_infusion" />
<?php xl('Epidural catheter','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Tunneled"  id="oasis_c_nurse_infusion" />
<?php xl('Tunneled','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Port1"  id="oasis_c_nurse_infusion" />
<?php xl('Port','e')?></label> &nbsp;
<br />

<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_c_nurse_infusion_epidural_date' id='oasis_c_nurse_infusion_epidural_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date20' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_c_nurse_infusion_epidural_date", ifFormat:"%Y-%m-%d", button:"img_curr_date20"});
                        </script>
<br />

<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Implanted VAD"  id="oasis_c_nurse_infusion" />
<?php xl('Implanted VAD','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Venous"  id="oasis_c_nurse_infusion" />
<?php xl('Venous','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Arterial"  id="oasis_c_nurse_infusion" />
<?php xl('Arterial','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Peritoneal"  id="oasis_c_nurse_infusion" />
<?php xl('Peritoneal','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_c_nurse_infusion_implanted_date' id='oasis_c_nurse_infusion_implanted_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date21' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_c_nurse_infusion_implanted_date", ifFormat:"%Y-%m-%d", button:"img_curr_date21"});
                        </script>
<br />


<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Intrathecal"  id="oasis_c_nurse_infusion" />
<?php xl('Intrathecal','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Port2"  id="oasis_c_nurse_infusion" />
<?php xl('Port','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Reservoir"  id="oasis_c_nurse_infusion" />
<?php xl('Reservoir','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='oasis_c_nurse_infusion_intrathecal_date' id='oasis_c_nurse_infusion_intrathecal_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date22' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"oasis_c_nurse_infusion_intrathecal_date", ifFormat:"%Y-%m-%d", button:"img_curr_date22"});
                        </script>
<br />


<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Medication administered1"  id="oasis_c_nurse_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med1_admin" id="oasis_c_nurse_infusion_med1_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med1_name" id="oasis_c_nurse_infusion_med1_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med1_dose" id="oasis_c_nurse_infusion_med1_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med1_dilution" id="oasis_c_nurse_infusion_med1_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med1_route" id="oasis_c_nurse_infusion_med1_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med1_frequency" id="oasis_c_nurse_infusion_med1_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med1_duration" id="oasis_c_nurse_infusion_med1_duration" size="10" />
</label>

<!-- ********************************************************************* -->

<br />


<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Medication administered2"  id="oasis_c_nurse_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med2_admin" id="oasis_c_nurse_infusion_med2_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med2_name" id="oasis_c_nurse_infusion_med2_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med2_dose" id="oasis_c_nurse_infusion_med2_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med2_dilution" id="oasis_c_nurse_infusion_med2_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med2_route" id="oasis_c_nurse_infusion_med2_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med2_frequency" id="oasis_c_nurse_infusion_med2_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med2_duration" id="oasis_c_nurse_infusion_med2_duration" size="10" />
</label>


<br />

<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Medication administered3"  id="oasis_c_nurse_infusion" />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med3_admin" id="oasis_c_nurse_infusion_med3_admin" size="25" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med3_name" id="oasis_c_nurse_infusion_med3_name" size="25" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med3_dose" id="oasis_c_nurse_infusion_med3_dose" size="10" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med3_dilution" id="oasis_c_nurse_infusion_med3_dilution" size="10" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med3_route" id="oasis_c_nurse_infusion_med3_route" size="10" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med3_frequency" id="oasis_c_nurse_infusion_med3_frequency" size="10" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_med3_duration" id="oasis_c_nurse_infusion_med3_duration" size="10" />
</label>
<br />
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Pump:(type, specify)"  id="oasis_c_nurse_infusion" />
<strong><?php xl('Pump:(type, specify)','e')?></strong></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_pump" id="oasis_c_nurse_infusion_pump" size="25" />
<br />
<strong><?php xl('Administered by:','e')?></strong>
<label>
<input type="checkbox" name="oasis_c_nurse_infusion_admin_by" value="Self"  id="oasis_c_nurse_infusion_admin_by" />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion_admin_by" value="Caregiver"  id="oasis_c_nurse_infusion_admin_by" />
<?php xl('Caregiver','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion_admin_by" value="RN"  id="oasis_c_nurse_infusion_admin_by" />
<?php xl('RN','e')?></label> &nbsp;
<label><br />
<input type="checkbox" name="oasis_c_nurse_infusion_admin_by" value="Other"  id="oasis_c_nurse_infusion_admin_by" />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_admin_by_other" id="oasis_c_nurse_infusion_admin_by_other"  width="40"  />
<br />
<label>
<input type="checkbox" name="oasis_c_nurse_infusion[]" value="Dressing change:"  id="oasis_c_nurse_infusion" />
<strong><?php xl('Dressing change:','e')?></strong></label> &nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_dressing" value="Sterile"  id="oasis_c_nurse_infusion_dressing" />
<?php xl('Sterile','e')?></label> &nbsp;
<label><input type="radio" name="oasis_c_nurse_infusion_dressing" value="Clean"  id="oasis_c_nurse_infusion_dressing" />
<?php xl('Clean','e')?></label> &nbsp;
<br />

<strong><?php xl('Performed by:','e')?></strong> &nbsp;&nbsp;&nbsp;&nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion_performed_by" value="Self"  id="oasis_c_nurse_infusion_performed_by" />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion_performed_by" value="RN"  id="oasis_c_nurse_infusion_performed_by" />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="oasis_c_nurse_infusion_performed_by" value="Caregiver"  id="oasis_c_nurse_infusion_performed_by" />
<?php xl('Caregiver','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="oasis_c_nurse_infusion_performed_by" value="Other"  id="oasis_c_nurse_infusion_performed_by" />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_performed_by_other" id="oasis_c_nurse_infusion_performed_by_other" size="30" />
<br />

<label><?php xl('Frequency (specify)','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_frequency" id="oasis_c_nurse_infusion_frequency" size="30" />
</label>
<br />
<label><?php xl('Injection cap change (specify frequency)','e')?> &nbsp;
<input type="text" name="oasis_c_nurse_infusion_injection" id="oasis_c_nurse_infusion_injection" size="30" />
</label>
<br />
<label><?php xl('Labs drawn','e')?> &nbsp;
<br />
<textarea name="oasis_c_nurse_infusion_labs_drawn" rows="2" cols="48"></textarea>
</label>

<br /><br /><br />

<center><strong><?php xl("Timed Up And Go Test","e");?></strong></center><br>
			<strong><?php xl("Instructions for the Therapist:","e");?></strong><br>

			<ul style="display:block; list-style-type:disc; margin-left:40px;">
				<li><?php xl("Ask the patient to sit in a standard armchair. Measure out a distance of 10 feet from the patient & place a marker, for the patient, at this location.","e");?></li>
				<li><?php xl("(STOP the test if the patient is not safe to complete it).","e");?></li>
				<li><?php xl("Perform the test 2 times & average the scores to get the final score.","e");?></li>
			</ul><br>

			<strong><?php xl("Instructions to the Patient:","e");?></strong><br>
			<?php xl("\"On the word 'Go' you are to get up & go & walk at a comfortable & safe pace to the marker, turn & return to the chair & sit down again.\"","e");?>
			<center>
				<?php xl("Trial 1:","e");?><input type="text" name="oasis_c_nurse_timed_up_trial1" id="oasis_c_nurse_timed_up_trial1" onkeyup="calc_avg();" value=""><?php xl("Seconds","e");?><br>
				<?php xl("Trial 2:","e");?><input type="text" name="oasis_c_nurse_timed_up_trial2" id="oasis_c_nurse_timed_up_trial2" onkeyup="calc_avg();" value=""><?php xl("Seconds","e");?><br>
				<?php xl("Average:","e");?><input type="text" name="oasis_c_nurse_timed_up_average" id="oasis_c_nurse_timed_up_average" value="" readonly><?php xl("Seconds","e");?>
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



<tr>
<TD colspan="2">
<center><strong><?php xl("AMPLIFICATION OF CARE PROVIDED/ANALYSIS OF FINDINGS","e");?></strong></center><br>
</td>
</tr>
<tr>
<TD>
			<textarea name="oasis_c_nurse_amplification_care_provided" rows="4" cols="48"></textarea><br>
</TD>

<td>
<?php xl("Patient/Caregiver Response","e");?><br>
			<textarea name="oasis_c_nurse_amplification_patient_response" rows="3" cols="48"></textarea><br>

</TD>
</tr>


<tr>
		<td colspan="2">
			<center><strong><?php xl("HOMEBOUND REASON","e");?></strong></center>
			<table class="formtable">
				<tr>
					<td>
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Needs assistance for all activities"><?php xl('Needs assistance for all activities','e')?></label><br />
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Residual weakness"><?php xl('Residual weakness','e')?></label><br />
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Requires assistance to ambulate"><?php xl('Requires assistance to ambulate','e')?></label>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Confusion, unable to go out of home alone"><?php xl('Confusion, unable to go out of home alone','e')?></label><br />
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Unable to safely leave home unassisted"><?php xl('Unable to safely leave home unassisted','e')?></label><br />
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Severe SOB, SOB upon exertion"><?php xl('Severe SOB, SOB upon exertion','e')?></label>
					</td>
					<td>
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Dependent upon adaptive device"><?php xl('Dependent upon adaptive device(s)','e')?></label><br />
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Medical restrictions"><?php xl('Medical restrictions','e')?></label><br />
						<label><input type="checkbox" name="oasis_c_nurse_homebound_reason[]" value="Other(specify)"><?php xl('Other','e')?></label>
							<input type="text" name="oasis_c_nurse_homebound_reason_other" value="">
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
	<div><a href="#" id="black">Summary Checklist, DME/Medical Supplies, Safety Measures, Nutritional Requirements, Functional
Limitations, Allergies, Mental Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
			                    <ul>
				<li>
<table width="100%" border="1px" class="formtable">
	<tr>
		<td colspan="2">
			<center><strong><?php xl("SUMMARY CHECKLIST","e");?></strong></center><br>
			<strong><?php xl("CARE PLAN:","e");?></strong>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_careplan" value="Reviewed/Revised with patient involvement"><?php xl('Reviewed/Revised with patient involvement','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_careplan" value="Outcome achieved"><?php xl('Outcome achieved','e')?></label><br>
			
			<strong><?php xl("MEDICATION STATUS:","e");?></strong>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_medication" value="Medication regimen completed/reviewed (Locator #10)"><?php xl('Medication regimen completed/reviewed (Locator #10)','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_medication" value="No change"><?php xl('No change','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_medication" value="Order obtained"><?php xl('Order obtained','e')?></label><br>
			
			<?php xl("Check if any of the following were identified:","e");?><br>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_identified[]" value="Potential adverse effects/drug reactions"><?php xl('Potential adverse effects/drug reactions','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_identified[]" value="Ineffective drug therapy"><?php xl('Ineffective drug therapy','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_identified[]" value="Significant side effects"><?php xl('Significant side effects','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_identified[]" value="Significant drug interactions"><?php xl('Significant drug interactions','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_identified[]" value="Duplicate drug therapy"><?php xl('Duplicate drug therapy','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_identified[]" value="Non-compliance with drug therapy"><?php xl('Non-compliance with drug therapy','e')?></label><br>
			
			<strong><?php xl("CARE COORDINATION:","e");?></strong>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_care_coordination" value="Physician"><?php xl('Physician','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_care_coordination" value="SN"><?php xl('SN','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_care_coordination" value="PT"><?php xl('PT','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_care_coordination" value="OT"><?php xl('OT','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_care_coordination" value="ST"><?php xl('ST','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_care_coordination" value="MSW"><?php xl('MSW','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_care_coordination" value="Aide"><?php xl('Aide','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_summary_check_care_coordination" value="Other"><?php xl('Other(specify)','e')?></label>
				<input type="text" name="oasis_c_nurse_summary_check_carecordination_other" value=""><br>
			
			<strong><?php xl("REFERRAL TO:","e");?></strong><input type="text" name="oasis_c_nurse_summary_check_referrel" value="">
			<strong><?php xl("APPROXIMATE NEXT VISIT DATE:","e");?></strong>
			<input type='text' size='10' name='oasis_c_nurse_summary_check_next_visit' id='oasis_c_nurse_summary_check_next_visit' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date23' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_c_nurse_summary_check_next_visit", ifFormat:"%Y-%m-%d", button:"img_curr_date23"});
						</script>
			<br>
			<strong><?php xl("RECERTIFICATION:","e");?></strong>
			<label><input type="radio" name="oasis_c_nurse_summary_check_recertification" value="No"><?php xl(' No, complete discharge summary','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_summary_check_recertification" value="Yes"><?php xl(' Yes, complete remaining sections, as appropriate.','e')?></label><br>
			
			<strong><?php xl("Verbal Order obtained:","e");?></strong>
			<label><input type="radio" name="oasis_c_nurse_summary_check_verbal_order" value="No"><?php xl(' No','e')?></label>
			<label><input type="radio" name="oasis_c_nurse_summary_check_verbal_order" value="Yes"><?php xl(' Yes, specify date (Locator #23)','e')?></label>
			
			<input type='text' size='10' name='oasis_c_nurse_summary_verbal_order_date' id='oasis_c_nurse_summary_verbal_order_date' 
						title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_curr_date52' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
							Calendar.setup({inputField:"oasis_c_nurse_summary_verbal_order_date", ifFormat:"%Y-%m-%d", button:"img_curr_date52"});
						</script>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="formtable" border="0">
					<tr>
						<td colspan="4" align="center">
							<strong><?php xl("DME/MEDICAL SUPPLIES ","e");?></strong>
							<label><input type="checkbox" name="oasis_c_nurse_dme" value="NA"><?php xl('NA','e')?></label>
						</td>
					</tr>
					<tr valign="top">
						<td>
							<strong><?php xl("WOUND CARE: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="2x2s"><?php xl('2x2s','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="4x4s"><?php xl('4x4s','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="ABDs"><?php xl('ABDs','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Cotton tipped applicators"><?php xl('Cotton tipped applicators','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Wound cleanser"><?php xl('Wound cleanser','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Wound gel"><?php xl('Wound gel','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Drain sponges"><?php xl('Drain sponges','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Gloves:"><?php xl('Gloves:','e')?></label>
								<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care_glove" value="Sterile"><?php xl('Sterile','e')?></label>
								<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care_glove" value="Non-Sterile"><?php xl('Non-Sterile','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Hydrocolloids"><?php xl('Hydrocolloids','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Kerlix size"><?php xl('Kerlix size','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Nu-gauze"><?php xl('Nu-gauze','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Saline"><?php xl('Saline','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Tape"><?php xl('Tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Transparent Dressings"><?php xl('Transparent Dressings','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_wound_care[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_c_nurse_dme_wound_care_other" value=""><br><br>
								
							<strong><?php xl("DIABETIC: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_diabetic[]" value="Chemstrips"><?php xl('Chemstrips','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_diabetic[]" value="Syringes"><?php xl('Syringes','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_diabetic[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_c_nurse_dme_diabetic_other" value=""><br><br>
						</td>
						<td>
							<strong><?php xl("IV SUPPLIES: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="IV start kit"><?php xl('IV start kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="IV pole"><?php xl('IV pole','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="IV tubing"><?php xl('IV tubing','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Alcohol swabs"><?php xl('Alcohol swabs','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Angiocatheter size"><?php xl('Angiocatheter size','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Tape"><?php xl('Tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Extension tubings"><?php xl('Extension tubings','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Injection caps"><?php xl('Injection caps','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Central line dressing"><?php xl('Central line dressing','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Infusion pump"><?php xl('Infusion pump','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Batteries size"><?php xl('Batteries size','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Syringes size"><?php xl('Syringes size','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_iv_supplies[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_c_nurse_dme_iv_supplies_other" value=""><br><br>
							
							<strong><?php xl("FOLEY SUPPLIES: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_foley_supplies[]" value="Fr catheter kit"><?php xl('Fr catheter kit','e')?></label><br>
							<?php xl("(tray, bag, foley) ","e");?><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_foley_supplies[]" value="Straight catheter"><?php xl('Straight catheter','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_foley_supplies[]" value="Irrigation tray"><?php xl('Irrigation tray','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_foley_supplies[]" value="Saline"><?php xl('Saline','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_foley_supplies[]" value="Acetic acid"><?php xl('Acetic acid','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_foley_supplies[]" value="Other"><?php xl('Other','e')?></label><br>
								<input type="text" name="oasis_c_nurse_dme_foley_supplies_other" value=""><br><br>
						</td>
						<td>
							<strong><?php xl("URINARY/OSTOMY: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_urinary[]" value="Underpads"><?php xl('Underpads','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_urinary[]" value="External catheters"><?php xl('External catheters','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_urinary[]" value="Urinary bag/pouch"><?php xl('Urinary bag/pouch','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_urinary[]" value="Ostomy pouch (brand, size)"><?php xl('Ostomy pouch (brand, size)','e')?></label><br>
							<input type="text" name="oasis_c_nurse_dme_ostomy_pouch_brand" value="" size="7">
							<input type="text" name="oasis_c_nurse_dme_ostomy_pouch_size" value="" size="7"><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_urinary[]" value="Ostomy wafer (brand, size)"><?php xl('Ostomy wafer (brand, size)','e')?></label><br>
							<input type="text" name="oasis_c_nurse_dme_ostomy_wafer_brand" value="" size="7">
							<input type="text" name="oasis_c_nurse_dme_ostomy_wafer_size" value="" size="7"><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_urinary[]" value="Stoma adhesive tape"><?php xl('Stoma adhesive tape','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_urinary[]" value="Skin protectant"><?php xl('Skin protectant','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_urinary[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_c_nurse_dme_urinary_other" value=""><br><br>
							
							<strong><?php xl("MISCELLANEOUS: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_miscellaneous[]" value="Enema supplies"><?php xl('Enema supplies','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_miscellaneous[]" value="Feeding tube"><?php xl('Feeding tube:','e')?></label><br>
							<?php xl('type','e')?><input type="text" name="oasis_c_nurse_dme_miscellaneous_type" value="" size="7">
							<?php xl('size','e')?><input type="text" name="oasis_c_nurse_dme_miscellaneous_size" value="" size="7"><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_miscellaneous[]" value="Suture removal kit"><?php xl('Suture removal kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_miscellaneous[]" value="Staple removal kit"><?php xl('Staple removal kit','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_miscellaneous[]" value="Steri strips"><?php xl('Steri strips','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_miscellaneous[]" value="Other"><?php xl('Other','e')?></label>
								<input type="text" name="oasis_c_nurse_dme_miscellaneous_other" value=""><br>
						</td>
						<td>
							<strong><?php xl("SUPPLIES/EQUIPMENT: ","e");?></strong><br />
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Bathbench"><?php xl('Bathbench','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Cane"><?php xl('Cane','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Commode"><?php xl('Commode','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Special mattress overlay"><?php xl('Special mattress overlay','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Pressure relieving device"><?php xl('Pressure relieving device','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Eggcrate"><?php xl('Eggcrate','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Hospital bed"><?php xl('Hospital bed','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Hoyer lift"><?php xl('Hoyer lift','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Enteral feeding pump"><?php xl('Enteral feeding pump','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Nebulizer"><?php xl('Nebulizer','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Oxygen concentrator"><?php xl('Oxygen concentrator','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Suction machine"><?php xl('Suction machine','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Ventilator"><?php xl('Ventilator','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Walker"><?php xl('Walker','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Wheelchair"><?php xl('Wheelchair','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Tens unit"><?php xl('Tens unit','e')?></label><br>
							<label><input type="checkbox" name="oasis_c_nurse_dme_supplies[]" value="Other"><?php xl('Other:','e')?></label>
								<input type="text" name="oasis_c_nurse_dme_supplies_other" value=""><br>
						</td>
					</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<center><strong><?php xl("SAFETY MEASURES","e");?></strong></center>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="911 Protocol"><?php xl('911 Protocol','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Clear Pathways"><?php xl('Clear Pathways','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Siderails up"><?php xl('Siderails up','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Safe Transfers"><?php xl('Safe Transfers','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Equipment Safety"><?php xl('Equipment Safety','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Infection Control Measures"><?php xl('Infection Control Measures','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Bleeding Precautions"><?php xl('Bleeding Precautions','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Fall Precautions"><?php xl('Fall Precautions','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Seizure Precautions"><?php xl('Seizure Precautions','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Universal Precautions"><?php xl('Universal Precautions','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Other"><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_c_nurse_safety_measures_other" value=""><br>
		</td>
		<td>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Hazard-Free Environment"><?php xl('Hazard-Free Environment','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Lock W/C with transfers"><?php xl('Lock W/C with transfers','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Elevate Head of Bed"><?php xl('Elevate Head of Bed','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Medication Safety/Storage"><?php xl('Medication Safety/Storage','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Hazardous Waste Disposal"><?php xl('Hazardous Waste Disposal','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="24 hr. supervision"><?php xl('24 hr. supervision','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Neutropenic"><?php xl('Neutropenic','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="O2 Precautions"><?php xl('O2 Precautions','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Aspiration Precautions"><?php xl('Aspiration Precautions','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_safety_measures[]" value="Walker/Cane"><?php xl('Walker/Cane','e')?></label><br>
		</td>
	</tr>
	<tr valign="top">
		<td>
			<center><strong><?php xl("NUTRITIONAL REQUIREMENTS ","e");?></strong></center><br>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="Regular Diet"><?php xl('Regular Diet','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="Diet as Tolerated"><?php xl('Diet as Tolerated','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="Soft Diet"><?php xl('Soft Diet','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="NCS"><?php xl('NCS','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="Diabetic Diet Calorie ADA"><?php xl('Diabetic Diet # Calorie ADA','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="Pureed Diet"><?php xl('Pureed Diet','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="NAS"><?php xl('NAS','e')?></label><br>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="Low Salt Gram Sodium"><?php xl('Low Salt Gram Sodium','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="Low Fat/Low Cholesterol Diet"><?php xl('Low Fat/Low Cholesterol Diet','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_nutritional_requirement[]" value="Other Special Diet"><?php xl('Other Special Diet','e')?></label>
				<input type="text" name="oasis_c_nurse_nutritional_requirement_other" value=""><br>
				<br /><br />
			<center><strong><?php xl("ALLERGIES","e");?></strong></center><br>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="NKDA"><?php xl('NKDA','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="Penicillin"><?php xl('Penicillin','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="Sulfa"><?php xl('Sulfa','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="Aspirin"><?php xl('Aspirin','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="Milk Products"><?php xl('Milk Products','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="Pollen"><?php xl('Pollen','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="Insect Bites"><?php xl('Insect Bites','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="Eggs"><?php xl('Eggs','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_allergies[]" value="Other"><?php xl('Other:','e')?></label>
				<input type="text" name="oasis_c_nurse_nutritional_allergies_other" value=""><br>
		</td>
		<td>
			<center><strong><?php xl("FUNCTIONAL LIMITATIONS","e");?></strong></center><br>
			<table class="formtable">
				<tr valign="top">
					<td width="30%">
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Amputation"><?php xl('Amputation','e')?></label><br>
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Hearing"><?php xl('Hearing','e')?></label><br>
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Ambulation"><?php xl('Ambulation','e')?></label><br>
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Dyspnea with Minimal Exertion"><?php xl('Dyspnea with Minimal Exertion','e')?></label>
					</td>
					<td width="45%">
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Bowel/Bladder (Incontinence)"><?php xl('Bowel/Bladder (Incontinence)','e')?></label><br>
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Paralysis"><?php xl('Paralysis','e')?></label><br>
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Speech"><?php xl('Speech','e')?></label><br>
						
					</td>
					<td width="25%">
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Contracture"><?php xl('Contracture','e')?></label><br>
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Endurance"><?php xl('Endurance','e')?></label><br>
						<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Legally Blind"><?php xl('Legally Blind','e')?></label>
					</td>
				</tr>
				<tr>
				<td colspan="3">
				<label><input type="checkbox" name="oasis_c_nurse_functional_limitations[]" value="Other"><?php xl('Other (specify):','e')?></label>
				<input type="text" name="oasis_c_nurse_functional_limitations_other" value="" size="15">
				</td>
				</tr>
			</table>
			<br /><br />
			<center><strong><?php xl("MENTAL STATUS","e");?></strong></center><br>
			<label><input type="checkbox" name="oasis_c_nurse_mental_status[]" value="Oriented"><?php xl('Oriented','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_mental_status[]" value="Comatose"><?php xl('Comatose','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_mental_status[]" value="Forgetful"><?php xl('Forgetful','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_mental_status[]" value="Depressed"><?php xl('Depressed','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_mental_status[]" value="Disoriented"><?php xl('Disoriented','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_mental_status[]" value="Lethargic"><?php xl('Lethargic','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_mental_status[]" value="Agitated"><?php xl('Agitated','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_mental_status[]" value="Other"><?php xl('Other:','e')?></label>
<input type="text" name="oasis_c_nurse_mental_status_other" value="">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<strong><?php xl("DISCHARGE PLAN:","e");?></strong>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="Assist Pt/Cg in attaining goals & DC"><?php xl('Assist Pt/Cg in attaining goals & DC','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="Physician Supervision"><?php xl('Physician Supervision','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="Cg Assistance"><?php xl('Cg Assistance','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="Long Term Care"><?php xl('Long Term Care','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="ADHC"><?php xl('ADHC','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="Nursing Home Placement"><?php xl('Nursing Home Placement','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="Transfer to Hospice"><?php xl('Transfer to Hospice','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="Ongoing Skilled Nursing - Tube Changes"><?php xl('Ongoing Skilled Nursing - Tube Changes','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan[]" value="Other"><?php xl('Other','e')?></label>
				<input type="text" name="oasis_c_nurse_discharge_plan_other" value=""><br />
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan_detail[]" value="Patient to be discharged when skilled care no longer needed"><?php xl('Patient to be discharged when skilled care no longer needed','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan_detail[]" value="Patient to be discharged to the care of"><?php xl('Patient to be discharged to the care of:','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan_detail[]" value="Self"><?php xl('Self','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan_detail[]" value="Caregiver"><?php xl('Caregiver','e')?></label>
			<label><input type="checkbox" name="oasis_c_nurse_discharge_plan_detail[]" value="Other"><?php xl('Other:','e')?></label>
<input type="text" name="oasis_c_nurse_discharge_plan_detail_other" value="">
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
	<td>
	&nbsp;
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
	&nbsp;
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
	<td>
	&nbsp;
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
<br />
<?php xl('Flush with','e')?>
<input type="text" name="oasis_PORT_socl_before" value="" size="4">


<?php xl(' CC of ','e')?>
<input type="text" name="oasis_PORT_socl_percent_before" value="" size="4">
<?php xl(' % Sodium Chloride before use,','e')?>

<input type="text" name="oasis_PORT_socl_after" value="" size="4">

<?php xl(' CC of ','e')?>
<input type="text" name="oasis_PORT_socl_percent_after" value="" size="4">
<?php xl(' % Sodium Chloride after Infusion, follow with','e')?>


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
<td>
&nbsp;
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



</table>
				
				
				
				</li>
			</ul>
		</li>



<!--

<li>
                    <div><a href="#" id="black">Vital Signs, Cardiopulmonary &amp; Braden Scale</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>

                        <li>







                        </li>
                    </ul>
                </li>


-->

</ul>

<a href="javascript:top.restoreSession();document.oasis_c_nurse.submit();" id="btn_save" 
class="link_submit"><?php xl(' [Save]','e')?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color:#483D8B;"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>

</body>
</html>