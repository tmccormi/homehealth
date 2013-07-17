<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: medication_profile");
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
<script>
var count=4;
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
<head>
<body>
<form method="post"
		action="<?php echo $rootdir;?>/forms/medication_profile/save.php?mode=new" name="medication_profile">
		<h3 align="center"><?php xl('Medication Profile','e')?></h3>	
		
		<div class="formtable">
		<b>
		<?php xl('Patient Name: ','e');?><input type="text" name="patient_name" value="<?php patientName();?>" readonly>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php xl('Medical Record Number: ','e');?><input type="text" name="patient_mr_no" value="<?php  echo $_SESSION['pid']?>" readonly><br>
		<?php xl('Chart: ','e');?><input type="text" name="chart" value="">&nbsp;&nbsp;&nbsp;&nbsp;
		<?php xl('Episode: ','e');?><input type="text" name="episode" value="">
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
						title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
					<?php xl('Certification Period: ','e');?>
						<input type='text' size='10' name='certification_period' id='certification_period' 
						title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
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
								<input type="text" name="pharmacy_name" value="">
							</td>
						</tr>
						<tr>
							<td align="left">
								<?php xl('Pharmacy Address: ','e');?>
							</td>
							<td align="left">
								<input type="text" name="pharmacy_address" value="">
							</td>
						</tr>
						<tr>
							<td align="left">
								<?php xl('Pharmacy Phone: ','e');?>
							</td>
							<td align="left">
								<input type="text" name="pharmacy_phone" value="">
							</td>
						</tr>
						<tr>
							<td align="left">
								<?php xl('Pharmacy Fax: ','e');?>
							</td>
							<td align="left">
								<input type="text" name="pharmacy_fax" value="">
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
				<tr>
					<td>
						<input type='text' size='10' name='medication_start_date[]' id='medication_start_date_1' 
						title='<?php xl('yyyy-mm-dd Start Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_start_date1' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_start_date_1", ifFormat:"%Y-%m-%d", button:"img_start_date1"});
						</script>
					</td>
					<td>
						<select name="medication_code[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('N','e');?>"><?php xl('N','e');?></option>
							<option value="<?php xl('Existing','e');?>"><?php xl('Existing','e');?></option>
							<option value="<?php xl('LS','e');?>"><?php xl('LS','e');?></option>
							<option value="<?php xl('OTC','e');?>"><?php xl('OTC','e');?></option>
							<option value="<?php xl('C','e');?>"><?php xl('C','e');?></option>
							<option value="<?php xl('Hold','e');?>"><?php xl('Hold','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_title[]" value="" size="10">
					</td>
					<td>
						<select name="medication_route[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('Oral','e');?>"><?php xl('Oral','e');?></option>
							<option value="<?php xl('Injection','e');?>"><?php xl('Injection','e');?></option>
							<option value="<?php xl('Sublingual','e');?>"><?php xl('Sublingual','e');?></option>
							<option value="<?php xl('Rectal','e');?>"><?php xl('Rectal','e');?></option>
							<option value="<?php xl('Ocular','e');?>"><?php xl('Ocular','e');?></option>
							<option value="<?php xl('Nasal','e');?>"><?php xl('Nasal','e');?></option>
							<option value="<?php xl('Inhalation','e');?>"><?php xl('Inhalation','e');?></option>
							<option value="<?php xl('Cutaneous','e');?>"><?php xl('Cutaneous','e');?></option>
							<option value="<?php xl('Transdermal','e');?>"><?php xl('Transdermal','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_dose[]" value="" size="10">
					</td>
					<td>
						<select name="medication_frequency[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('Daily','e');?>"><?php xl('Daily','e');?></option>
							<option value="<?php xl('Twice per day','e');?>"><?php xl('Twice per day','e');?></option>
							<option value="<?php xl('Three times per day','e');?>"><?php xl('Three times per day','e');?></option>
							<option value="<?php xl('Four times per day','e');?>"><?php xl('Four times per day','e');?></option>
							<option value="<?php xl('Every Morning','e');?>"><?php xl('Every Morning','e');?></option>
							<option value="<?php xl('Every Afternoon','e');?>"><?php xl('Every Afternoon','e');?></option>
							<option value="<?php xl('Every night at bedtime','e');?>"><?php xl('Every night at bedtime','e');?></option>
							<option value="<?php xl('Every Other day','e');?>"><?php xl('Every Other day','e');?></option>
							<option value="<?php xl('Weekly','e');?>"><?php xl('Weekly','e');?></option>
							<option value="<?php xl('PRN','e');?>"><?php xl('PRN','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_purpose[]" value="" size="10">
					</td>
					<td>
						<input type='text' size='10' name='medication_teaching_date[]' id='medication_teaching_date_1' 
						title='<?php xl('yyyy-mm-dd Teaching Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_teaching_date1' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_teaching_date_1", ifFormat:"%Y-%m-%d", button:"img_teaching_date1"});
						</script>
					</td>
					<td>
						<input type='text' size='10' name='medication_discharge_date[]' id='medication_discharge_date_1' 
						title='<?php xl('yyyy-mm-dd Discharge Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_discharge_date1' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_discharge_date_1", ifFormat:"%Y-%m-%d", button:"img_discharge_date1"});
						</script>
					</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='10' name='medication_start_date[]' id='medication_start_date_2' 
						title='<?php xl('yyyy-mm-dd Start Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_start_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_start_date_2", ifFormat:"%Y-%m-%d", button:"img_start_date2"});
						</script>
					</td>
					<td>
						<select name="medication_code[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('N','e');?>"><?php xl('N','e');?></option>
							<option value="<?php xl('Existing','e');?>"><?php xl('Existing','e');?></option>
							<option value="<?php xl('LS','e');?>"><?php xl('LS','e');?></option>
							<option value="<?php xl('OTC','e');?>"><?php xl('OTC','e');?></option>
							<option value="<?php xl('C','e');?>"><?php xl('C','e');?></option>
							<option value="<?php xl('Hold','e');?>"><?php xl('Hold','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_title[]" value="" size="10">
					</td>
					<td>
						<select name="medication_route[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('Oral','e');?>"><?php xl('Oral','e');?></option>
							<option value="<?php xl('Injection','e');?>"><?php xl('Injection','e');?></option>
							<option value="<?php xl('Sublingual','e');?>"><?php xl('Sublingual','e');?></option>
							<option value="<?php xl('Rectal','e');?>"><?php xl('Rectal','e');?></option>
							<option value="<?php xl('Ocular','e');?>"><?php xl('Ocular','e');?></option>
							<option value="<?php xl('Nasal','e');?>"><?php xl('Nasal','e');?></option>
							<option value="<?php xl('Inhalation','e');?>"><?php xl('Inhalation','e');?></option>
							<option value="<?php xl('Cutaneous','e');?>"><?php xl('Cutaneous','e');?></option>
							<option value="<?php xl('Transdermal','e');?>"><?php xl('Transdermal','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_dose[]" value="" size="10">
					</td>
					<td>
						<select name="medication_frequency[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('Daily','e');?>"><?php xl('Daily','e');?></option>
							<option value="<?php xl('Twice per day','e');?>"><?php xl('Twice per day','e');?></option>
							<option value="<?php xl('Three times per day','e');?>"><?php xl('Three times per day','e');?></option>
							<option value="<?php xl('Four times per day','e');?>"><?php xl('Four times per day','e');?></option>
							<option value="<?php xl('Every Morning','e');?>"><?php xl('Every Morning','e');?></option>
							<option value="<?php xl('Every Afternoon','e');?>"><?php xl('Every Afternoon','e');?></option>
							<option value="<?php xl('Every night at bedtime','e');?>"><?php xl('Every night at bedtime','e');?></option>
							<option value="<?php xl('Every Other day','e');?>"><?php xl('Every Other day','e');?></option>
							<option value="<?php xl('Weekly','e');?>"><?php xl('Weekly','e');?></option>
							<option value="<?php xl('PRN','e');?>"><?php xl('PRN','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_purpose[]" value="" size="10">
					</td>
					<td>
						<input type='text' size='10' name='medication_teaching_date[]' id='medication_teaching_date_2' 
						title='<?php xl('yyyy-mm-dd Teaching Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_teaching_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_teaching_date_2", ifFormat:"%Y-%m-%d", button:"img_teaching_date2"});
						</script>
					</td>
					<td>
						<input type='text' size='10' name='medication_discharge_date[]' id='medication_discharge_date_2' 
						title='<?php xl('yyyy-mm-dd Discharge Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_discharge_date2' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_discharge_date_2", ifFormat:"%Y-%m-%d", button:"img_discharge_date2"});
						</script>
					</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='10' name='medication_start_date[]' id='medication_start_date_3' 
						title='<?php xl('yyyy-mm-dd Start Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_start_date3' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_start_date_3", ifFormat:"%Y-%m-%d", button:"img_start_date3"});
						</script>
					</td>
					<td>
						<select name="medication_code[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('N','e');?>"><?php xl('N','e');?></option>
							<option value="<?php xl('Existing','e');?>"><?php xl('Existing','e');?></option>
							<option value="<?php xl('LS','e');?>"><?php xl('LS','e');?></option>
							<option value="<?php xl('OTC','e');?>"><?php xl('OTC','e');?></option>
							<option value="<?php xl('C','e');?>"><?php xl('C','e');?></option>
							<option value="<?php xl('Hold','e');?>"><?php xl('Hold','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_title[]" value="" size="10">
					</td>
					<td>
						<select name="medication_route[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('Oral','e');?>"><?php xl('Oral','e');?></option>
							<option value="<?php xl('Injection','e');?>"><?php xl('Injection','e');?></option>
							<option value="<?php xl('Sublingual','e');?>"><?php xl('Sublingual','e');?></option>
							<option value="<?php xl('Rectal','e');?>"><?php xl('Rectal','e');?></option>
							<option value="<?php xl('Ocular','e');?>"><?php xl('Ocular','e');?></option>
							<option value="<?php xl('Nasal','e');?>"><?php xl('Nasal','e');?></option>
							<option value="<?php xl('Inhalation','e');?>"><?php xl('Inhalation','e');?></option>
							<option value="<?php xl('Cutaneous','e');?>"><?php xl('Cutaneous','e');?></option>
							<option value="<?php xl('Transdermal','e');?>"><?php xl('Transdermal','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_dose[]" value="" size="10">
					</td>
					<td>
						<select name="medication_frequency[]">
							<option value=""><?php xl('Please Select','e');?></option>
							<option value="<?php xl('Daily','e');?>"><?php xl('Daily','e');?></option>
							<option value="<?php xl('Twice per day','e');?>"><?php xl('Twice per day','e');?></option>
							<option value="<?php xl('Three times per day','e');?>"><?php xl('Three times per day','e');?></option>
							<option value="<?php xl('Four times per day','e');?>"><?php xl('Four times per day','e');?></option>
							<option value="<?php xl('Every Morning','e');?>"><?php xl('Every Morning','e');?></option>
							<option value="<?php xl('Every Afternoon','e');?>"><?php xl('Every Afternoon','e');?></option>
							<option value="<?php xl('Every night at bedtime','e');?>"><?php xl('Every night at bedtime','e');?></option>
							<option value="<?php xl('Every Other day','e');?>"><?php xl('Every Other day','e');?></option>
							<option value="<?php xl('Weekly','e');?>"><?php xl('Weekly','e');?></option>
							<option value="<?php xl('PRN','e');?>"><?php xl('PRN','e');?></option>
						</select>
					</td>
					<td>
						<input type="text" name="medication_purpose[]" value="" size="10">
					</td>
					<td>
						<input type='text' size='10' name='medication_teaching_date[]' id='medication_teaching_date_3' 
						title='<?php xl('yyyy-mm-dd Teaching Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_teaching_date3' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_teaching_date_3", ifFormat:"%Y-%m-%d", button:"img_teaching_date3"});
						</script>
					</td>
					<td>
						<input type='text' size='10' name='medication_discharge_date[]' id='medication_discharge_date_3' 
						title='<?php xl('yyyy-mm-dd Discharge Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="" readonly/> 
						<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
						height='22' id='img_discharge_date3' border='0' alt='[?]'
						style='cursor: pointer; cursor: hand'
						title='<?php xl('Click here to choose a date','e'); ?>'> 
						<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"medication_discharge_date_3", ifFormat:"%Y-%m-%d", button:"img_discharge_date3"});
						</script>
					</td>
				</tr>
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
			<label><input type="checkbox" name="info_reviewed_with" value="<?php xl('Patient','e');?>"><?php xl('Patient','e');?></label>
			<label><input type="checkbox" name="info_reviewed_with" value="<?php xl('Caregiver','e');?>"><?php xl('Caregiver','e');?></label><br>
			<?php xl('Information Reviewed Included ','e');?>&nbsp;&nbsp;
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Medication Information','e');?>"><?php xl('Medication Information','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Medication Interactions (if Adverse)','e');?>"><?php xl('Medication Interactions (if Adverse)','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Prescription Refill Information','e');?>"><?php xl('Prescription Refill Information','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Disposal of unused and expired medications','e');?>"><?php xl('Disposal of unused and expired medications','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Actions to take when does are missed','e');?>"><?php xl('Actions to take when does are missed','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Avoidance of Contamination','e');?>"><?php xl('Avoidance of Contamination','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Role of Diet and Nutrition when taking medications','e');?>"><?php xl('Role of Diet and Nutrition when taking medications','e');?></label>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Refer to SN Visit Notes for additional medication information taught','e');?>"><?php xl('Refer to SN Visit Notes for additional medication information taught','e');?></label><br>
			<label><input type="checkbox" name="info_reviewed_included[]" value="<?php xl('Other','e');?>"><?php xl('Other','e');?></label>
			&nbsp;&nbsp;<input type="text" name="info_reviewed_included_other" style="width:80%" value="">
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

</body>
</html>