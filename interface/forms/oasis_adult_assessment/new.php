<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: OASIS_C");  
/* include api.inc. also required. */
require_once($GLOBALS['srcdir'].'/api.inc');
/* include our smarty derived controller class. */
require($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');
?>

<html>
<head>
<title>OASIS</title>
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
		
		function Go_test_average()
    {

$("#gotest_average").val(
(parseInt($("#gotest_trail1").val())+
parseInt($("#gotest_trail2").val()))/'2');
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

 </script>
 
<script>
function requiredCheck(){
    var time_in = document.getElementById('oasis_Time_In').value;
    var time_out = document.getElementById('oasis_Time_Out').value;
    
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
		<h3 align="center"><?php xl('ADULT ASSESSMENT','e')?></h3>
<form method="post" id="submitForm"
		action="<?php echo $rootdir;?>/forms/oasis_adult_assessment/save.php?mode=new" name="adult_assessment" onSubmit="return top.restoreSession();" enctype="multipart/form-data">
	
	
	<table width="100%" border="0" class="formtable">
<tr valign="top">
<TD align="left" width="40%">
<?php xl('Patient:','e')?>
<input type="text" name="oasis_patient"  style="width:40%" value="<?php patientFullName(); ?>" readonly />
</TD>
<td align="right">
<?php xl('Caregiver:','e')?>&nbsp;&nbsp;
<input type="text" name="oasis_caregiver" size="15" >
&nbsp;&nbsp;

<?php xl('Start of Care Date:','e')?>
<input type="text" size="12" name="oasis_visit_date" id="oasis_visit_date" value="<?php VisitDate(); ?>" readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"oasis_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>

<br />
<?php xl('Time In:','e')?>
<select name="oasis_Time_In" id="oasis_Time_In">
<?php timeDropDown($GLOBALS['Selected']) ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Time Out:','e')?>
<select name="oasis_Time_Out" id="oasis_Time_Out">
<?php timeDropDown($GLOBALS['Selected']) ?>
</select>

</td>
</tr>
</table>
						
		<ul id="oasis">
                <li>
                    <div><a href="#" id="black"><?php xl('Demographics And Patient History','e')?></a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
                            <h3 align="center"><?php xl('DEMOGRAPHICS AND PATIENT HISTORY','e')?></h3>

<table width="100%" border="1" class="formtable">
	<tr><td width="50%">
	<table width="100%" border="0" class="formtable">
<tr><td>
<b><u><?php xl('(M0040)','e')?></u>&nbsp;<?php xl('Patients Name:','e')?></b>
<br/>
&nbsp;&nbsp;<b><?php xl('First:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName('fname')?>" readonly >&nbsp;&nbsp;
<b><?php xl('MI:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName('mname')?>" readonly > <br>
&nbsp;&nbsp;<b><?php xl('Last:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName('lname')?>" readonly >&nbsp;&nbsp;
<b><?php xl('Suffix:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName('title')?>" readonly >
<br>
<b><?php xl('Patient Address:','e')?></b>&nbsp;<br>
<b><?php xl('Street:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName('street')?>" readonly >
<b><?php xl('City:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName('city')?>" readonly >
 <br/>
 <b><?php xl('Patient Phone:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName('phone_home')?>" readonly >
 <br/>
<b><u><?php xl('(M0050)','e')?></u><?php xl('Patient State of Residence:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName("state")?>" readonly ><br/>
<b><u><?php xl('(M0060)','e')?></u><?php xl('Patient Zip Code:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName("postal_code")?>" readonly ><br/>
<b><u><?php xl('(M0066)','e')?></u><?php xl('Birth Date:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName("DOB")?>" readonly ><br/>
<b><u><?php xl('(M0030)','e')?></u><?php xl('Start of Care Date:','e')?></b>&nbsp;<input type="text" name="" style="width:30%" value="<?php patientName("DOB")?>" readonly ><br/>
<b><?php xl('Certification Period From:','e')?></b>&nbsp;
<input type='text' size='10' name='oasis_certification_period_from' id='oasis_certification_period_from'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_certification_period_from", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
                                        </script>

<?php xl('To:','e')?>&nbsp;
<input type='text' size='10' name='oasis_certification_period_to' id='oasis_certification_period_to'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_certification_period_to", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
                                        </script>
<br/>
<b><?php xl('HEALTH INSURANCE CLAIM #:','e')?></b>&nbsp;<input type="text" name="oasisAdultAssess_Heath_Insurance_Claim" size="15"/>
<br><br/>
<hr />
<table width="100%" border="0" class="formtable">
<tr><td>
<strong><?php xl('PHYSICIAN DATE LAST CONTACTED:','e')?></strong>&nbsp;
<input type='text' size='10' name='oasis_physician_last_contacted' id='oasis_physician_last_contacted'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date2' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_physician_last_contacted", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
                                        </script>
<br/>
<strong><?php xl('PHYSICIAN DATE LAST VISITED:','e')?></strong>&nbsp;
<input type='text' size='10' name='oasis_physician_last_visited' id='oasis_physician_last_visited'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date3' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_physician_last_visited", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
                                        </script>
<br/>
<strong><?php xl('PRIMARY REASON FOR HOME HEALTH:','e')?></strong>&nbsp;
<input type="text" name="oasis_primary_reason_home_health" size="35"/>
<br/>
<input type="checkbox" name="oasis_treat_patient_illness" value="To treat patient illness or injury"><?php xl('To treat patient illness or injury due to the inherent complexity of the service and the condition of
the patient','e')?> <br/>
<input type="checkbox" name="oasis_treat_patient_illness_other" value="Other" ><?php xl('Other:','e')?><br/>
<textarea rows="6" cols="42" name="oasis_treat_patient_illness_other_text"></textarea>
<br><br><br>
</td></tr>
</table>


	</td>
	</tr>
	</table>
	
	</td>
	<td width="50%">
	<strong><?php xl('PERTINENT HISTORY AND/OR PREVIOUS OUTCOMES (note dates of onset, exacerbation when known)','e')?></strong><br/>
	<table width="100%" border="0" class="formtable" >
<tr>
<td width="33%">
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Hypertension"><?php xl('Hypertension','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Respiratory"><?php xl('Respiratory','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Cancer"><?php xl('Cancer','e')?>&nbsp;
<?php xl('site :','e')?>&nbsp;<input type="text" name="oasis_patient_history_previous_outcomes_site" size="15"/><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Open Wound"><?php xl('Open Wound','e')?><br/>
</td>
<td width="29%">
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Cardiac"><?php xl('Cardiac','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Osteoporosis"><?php xl('Osteoporosis','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Infection"><?php xl('Infection','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Surgeries"><?php xl('Surgeries','e')?><br/>
</td>
<td width="36%">
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Diabetes"><?php xl('Diabetes','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Fractures"><?php xl('Fractures','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Immunosuppressed"><?php xl('Immunosuppressed','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Other"><?php xl('Other','e')?>&nbsp;
<?php xl('(specify)','e')?>&nbsp;<input type="text" name="oasis_patient_history_previous_outcomes_other" size="19"/>
</td>

<tr><td colspan="3">
<strong><?php xl('PRIOR HOSPITALIZATIONS','e')?></strong><br/>
<input type="radio" name="oasis_prior_hospitalizations" value="No"><?php xl('No','e');?>
<input type="radio" name="oasis_prior_hospitalizations" value="Yes"><?php xl('Yes','e');?>&nbsp;&nbsp;&nbsp;
<?php xl('Number of times','e')?>&nbsp;
<input type="text" name="oasis_prior_hospitalizations_times" size="10" /><br/>
<?php xl('Reason(s)/Date(s):','e')?><br>
<input type="text" name="oasis_prior_hospitalizations_Reason1" size="40" />&nbsp;
<input type='text' size='10' name='oasis_prior_hospitalizations_date1' id='oasis_prior_hospitalizations_date1'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date4' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_prior_hospitalizations_date1", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
                                        </script><br/>

<input type="text" name="oasis_prior_hospitalizations_Reason2" size="40" />&nbsp;
<input type='text' size='10' name='oasis_prior_hospitalizations_date2' id='oasis_prior_hospitalizations_date2'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date5' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_prior_hospitalizations_date2", ifFormat:"%Y-%m-%d", button:"img_curr_date5"});
                                        </script><br/>										

</td></tr>
<tr>
<td colspan="3">
<strong><?php xl('IMMUNIZATIONS','e')?></strong>&nbsp;<input type="checkbox" value="Up to Date" name="oasis_immunizations"><?php xl('Up to Date','e')?><br/>
<strong><?php xl('Needs :','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_immunizations_needs[]" value="Influenza"><?php xl('Influenza','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasis_immunizations_needs[]" value="Pneumonia"><?php xl('Pneumonia','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasis_immunizations_needs[]" value="Tetanus"><?php xl('Tetanus','e')?>&nbsp;&nbsp;<br>
<input type="checkbox" name="oasis_immunizations_needs[]" value="Other"><?php xl('Other','e')?>&nbsp;
<input type="text" name="oasis_immunizations_needs_other" size="36"/>

<br/>
<strong><center><?php xl('ALLERGIES','e')?></center></strong>
<input type="checkbox" name="oasis_allergies[]" value="NKDA"><?php xl('NKDA','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Penicillin"><?php xl('Penicillin','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Sulfa"><?php xl('Sulfa','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Aspirin"><?php xl('Aspirin','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Milk Products"><?php xl('Milk Products','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Pollen"><?php xl('Pollen','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Insect Bites"><?php xl('Insect Bites','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Eggs"><?php xl('Eggs','e')?>&nbsp;<br/>
<input type="checkbox" name="oasis_allergies[]" value="Other"><?php xl('Other','e')?>&nbsp;
<input type="text" name="oasis_allergies_other" size="46"/>
<br/>

<strong><center><?php xl('PROGNOSIS','e')?></center></strong>
<strong><?php xl('Prognosis:','e')?></strong>
<input type="radio" name="oasis_prognosis" value="1-Poor"/><?php xl('1-Poor','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_prognosis" value="2-Guarded"/><?php xl('2-Guarded','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_prognosis" value="3-Fair"/><?php xl('3-Fair','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_prognosis" value="4-Good"/><?php xl('4-Good','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_prognosis" value="5-Excellent"/><?php xl('5-Excellent','e')?>&nbsp;&nbsp;
<br/>

<strong><center><?php xl('ADVANCE DIRECTIVES','e')?></center></strong>
<table border="0" class="formtable"><tr><td>
<input type="checkbox" name="oasis_advance_directives[]" value="Do not resuscitate"><?php xl('Do not resuscitate','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Organ Donor"><?php xl('Organ Donor','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Education needed"><?php xl('Education needed','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Copies on file"><?php xl('Copies on file','e')?> 
</td><td>
<input type="checkbox" name="oasis_advance_directives[]" value="Funeral arrangements made"><?php xl('Funeral arrangements made','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Durable Power of Attorney"><?php xl('Durable Power of Attorney (DPOA)','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Living Will"><?php xl('Living Will','e')?><br>
&nbsp;
</td></tr></table>

<br/>
<strong><?php xl('Patient/Family informed:','e')?></strong>
<input type="radio" name="oasis_patient_family_informed" value="Yes"/><?php xl('Yes','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_patient_family_informed" value="No"/><?php xl('No','e')?> <br/>
<strong><?php xl('(If No, please explain.)','e')?> </strong>&nbsp;
<input type="text" name="oasis_patient_family_informed_explain" size="34"/> <br/>
</td></tr>

</tr></table>

</td></tr>

<tr>
<td width="50%">
<table width="100%" border="0" class="formtable">
<tr><td colspan="2" align="center"><strong><?php xl('SAFETY MEASURES','e')?></strong></td></tr>
<tr><td width="50%">
<input type="checkbox" name="oasis_safety_measures[]" value="911 Protocol"><?php xl('911 Protocol','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Clear Pathways"><?php xl('Clear Pathways','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Siderails up"><?php xl('Siderails up','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Safe Transfers"><?php xl('Safe Transfers','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Equipment Safety"><?php xl('Equipment Safety','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Infection Control Measures"><?php xl('Infection Control Measures','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Bleeding Precautions"><?php xl('Bleeding Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Fall Precautions"><?php xl('Fall Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Seizure Precautions"><?php xl('Seizure Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Universal Precautions"><?php xl('Universal Precautions','e')?><br/>
</td>
<td width="50%" valign="top">
<input type="checkbox" name="oasis_safety_measures[]" value="Hazard-Free Environment"><?php xl('Hazard-Free Environment','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Lock W/C with transfers"><?php xl('Lock W/C with transfers','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Elevate Head of Bed"><?php xl('Elevate Head of Bed','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Medication Safety/Storage"><?php xl('Medication Safety/Storage','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Hazardous Waste Disposal"><?php xl('Hazardous Waste Disposal','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="24 hr. supervision"><?php xl('24 hr. supervision','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Neutropenic"><?php xl('Neutropenic','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="O2 Precautions"><?php xl('O2 Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Aspiration Precautions"><?php xl('Aspiration Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Walker/Cane"><?php xl('Walker/Cane','e')?><br/>
</td></tr>
<tr><td colspan="2">
<input type="checkbox" name="oasis_safety_measures[]" value="Other"><?php xl('Other:','e')?>&nbsp;
<input type="textbox" name="oasis_safety_measures_other" size="46"/>
<br><br/>
<hr/>
</td></tr>

<tr><td colspan="2" align="center"><b><?php xl('SANITATION HAZARDS','e')?></b></td></tr>
<tr><td colspan="2">
<input type="checkbox" name="oasis_sanitation_hazards[]" value="None"><?php xl('None','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate/improper food storage"><?php xl('Inadequate/improper food storage','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate cooking refrigeration"><?php xl('Inadequate cooking refrigeration','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate running water"><?php xl('Inadequate running water','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Cluttered/soiled living room"><?php xl('Cluttered/soiled living room','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate toileting facility"><?php xl('Inadequate toileting facility','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate sewage"><?php xl('Inadequate sewage','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="No scheduled trash removal"><?php xl('No scheduled trash removal','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Insects/rodents present"><?php xl('Insects/rodents present','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Other"><?php xl('Other','e')?>&nbsp;
<input type="textbox" name="oasis_sanitation_hazards_other" size="46"/>
<br/><br><br><br>
</td>
</tr>


</table>
</td>

<td width="50%">
<table width="100%" border="0" class="formtable">
<tr><td colspan="2"><b><center><?php xl('SAFETY','e')?></center></b></td></tr>
<tr>
<td colspan="2">&nbsp;&nbsp;<b><?php xl('Emergency planning/fire safety:','e')?></b><br/></td></tr>
<tr>
<td width="70%"><?php xl('Fire extinguisher','e')?><br/>
<?php xl('Smoke detectors on all levels of home','e')?><br/>
<?php xl('Tested and functioning','e')?><br/>
<?php xl('More than one exit','e')?><br/>
<?php xl('Plan for exit','e')?><br/>
<?php xl('Plan for power failure','e')?><br/>
&nbsp;&nbsp;<strong><?php xl('Oxygen use:','e')?></strong><br/>
<?php xl('Signs posted','e')?><br/>
<?php xl('Handles smoking / flammables safely','e')?><br/>
</td>
<td>
<input type="radio" name="oasis_safety_fire" value="Yes"/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_fire" value="No"/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_smoke" value="Yes"/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_smoke" value="No"/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_tested" value="Yes"/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_tested" value="No"/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_one_exit" value="Yes"/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_one_exit" value="No"/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_plan_exit" value="Yes"/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_plan_exit" value="No"/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_plan_power" value="Yes"/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_plan_power" value="No"/><?php xl('N','e')?><br/>
&nbsp;<br/>
<input type="radio" name="oasis_safety_signs_posted" value="Yes"/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_signs_posted" value="No"/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_handles_smoking" value="Yes"/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_handles_smoking" value="No"/><?php xl('N','e')?><br/>

</td></tr>

<tr><td colspan="2">
<b><?php xl('Oxygen back-up:','e')?></b>&nbsp;
<input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Available"><?php xl('Available','e')?>&nbsp;
<input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Knows how to use"><?php xl('Knows how to use','e')?>&nbsp;<br/>
<input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Electrical/fire safety"><?php xl('Electrical / fire safety','e')?>&nbsp;
<hr/>
</td></tr>

<tr><td colspan="2"><b><?php xl('SAFETY HAZARDS found in the patients current place of residence: (Mark all that apply.)','e')?></b></td></tr>

<tr><td colspan="2"><table border="0" class="formtable"><tr><td width="50%">
<input type="checkbox" name="oasis_safety_hazards[]" value="None"><?php xl('None','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate floor, roof, or windows"><?php xl('Inadequate floor, roof, or windows','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate lighting"><?php xl('Inadequate lighting','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="No telephone available and / or unable to use phone"><?php xl('No telephone available and / or unable to use phone','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe gas/electrical appliances/outlets"><?php xl('Unsafe gas/electrical appliances/outlets','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate heating/cooling/electricity"><?php xl('Inadequate heating/cooling/electricity','e')?><br/>
</td>
<td width="50%">
<input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate sanitation/plumbing"><?php xl('Inadequate sanitation/plumbing','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsound structure"><?php xl('Unsound structure','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe placement of rugs/cords furniture"><?php xl('Unsafe placement of rugs/cords furniture','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe functional barriers"><?php xl('Unsafe functional barriers (i.e., stairs)','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe storage of supplies / equipment"><?php xl('Unsafe storage of supplies / equipment','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Improperly stored hazardous materials"><?php xl('Improperly stored hazardous materials','e')?><br/>
</td>
</tr></table></td></tr>
<tr><td colspan="2">
<input type="checkbox" name="oasis_safety_hazards[]" value="Other"><?php xl('Other:','e')?>&nbsp;
<input type="textbox" name="oasis_safety_hazards_other" size="46"/>
</td></tr>


</table>
</td>
</tr>
</table>
</li>
                    </ul>
                </li>
	</ul>
	
<ul id="oasis">
                <li>
                    <div><a href="#" id="black"><?php xl('Patient History And Diagnoses','e');?></a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
						
						
						
						
						
						
						
						
	<table width="100%" border="1" class="formtable">
	<tr>
		<td align="center" colspan="2">
			<strong><?php xl('PATIENT HISTORY AND DIAGNOSIS','e');?></strong>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
		<table cellspacing="0" border="1" class="formtable">
		<tr>
					<td colspan="2" align="left">
		<?php xl('<strong>(M1020/1022/1024) Diagnosis, Symptom Control, and Payment Diagnosis:</strong> List each diagnosis for which the patient is receiving home care (Column 1) and enter its ICD-9-C M code at the level of highest
specificity (no surgical/procedure codes) (Column 2). Diagnosis are listed in the order that best reflect the seriousness of each condition and support the disciplines and services provided. Rate the degree of symptom
control for each condition (Column 2). Choose one value that represents the degree of symptom control appropriate for each diagnosis: V-codes (for M1020 or M1022) or E-codes (for M1022 only) may be used. ICD-9-C
M sequencing requirements must be followed if multiple coding is indicated for any Diagnosis. If a V-code is reported in place of a case mix diagnosis, then optional item M1024 Payment Diagnosis (Columns 3 and 4) may
be completed. A case mix diagnosis is a diagnosis that determines the Medicare P P S case mix group. Do not assign symptom control ratings for V- or E-codes.','e');?><br>
			</td>
			</tr>
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
		<td>
			<table border="1px" cellspacing="0" class="formtable">
				<tr>
					<td colspan="2" align="center" width="50%">
						<strong><?php xl('(M1020) Primary Diagnosis & (M1022) Other Diagnosis','e');?></strong>
					</td>
					<td colspan="2" align="center" width="50%">
						<strong><?php xl('(M1024) Payment Diagnosis (OPTIONAL)','e');?></strong>
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
					<td valign="top">
						<?php xl('Diagnosis (Sequencing of Diagnosis should reflect the seriousness of each condition and support the disciplines and services provided.)','e');?>
					</td>
					<td valign="top">
						<?php xl('ICD-9-C M and symptom control rating for each condition. Note that the sequencing of these ratings may not match the sequencing of the Diagnosis','e');?>
					</td>
					<td valign="top">
						<?php xl('Complete if a V-code is assigned under certain circumstances to Column 2 in place of a case mix diagnosis.','e');?>
					</td>
					<td valign="top">
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
						<strong><?php xl('(M1020) Primary Diagnosis','e');?></strong>
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
						<input type="text" name="oasis_patient_diagnosis_1a" value="">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2a" class="autosearch" class="autosearch" id="oasis_patient_diagnosis_2a" value="" onkeydown="fonChange(this,2,'noe')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3a" class="autosearch" id="oasis_patient_diagnosis_3a" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4a" class="autosearch" id="oasis_patient_diagnosis_4a" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td align="left" width="25%">
						<strong><?php xl('(M1022) Other Diagnosis','e');?></strong>
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
						<input type="text" name="oasis_patient_diagnosis_1b" value="">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2b" class="autosearch" id="oasis_patient_diagnosis_2b" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3b" class="autosearch" id="oasis_patient_diagnosis_3b" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4b" class="autosearch" id="oasis_patient_diagnosis_4b" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1c" value="">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2c" class="autosearch" id="oasis_patient_diagnosis_2c" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3c" class="autosearch" id="oasis_patient_diagnosis_3c" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4c" class="autosearch" id="oasis_patient_diagnosis_4c" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1d" value="">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2d" class="autosearch" id="oasis_patient_diagnosis_2d" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3d" class="autosearch" id="oasis_patient_diagnosis_3d" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4d" class="autosearch" id="oasis_patient_diagnosis_4d" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1e" value="">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2e" class="autosearch" id="oasis_patient_diagnosis_2e" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3e" class="autosearch" id="oasis_patient_diagnosis_3e" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4e" class="autosearch" id="oasis_patient_diagnosis_4e" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1f" value="">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2f" class="autosearch" id="oasis_patient_diagnosis_2f" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3f" class="autosearch" id="oasis_patient_diagnosis_3f" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4f" class="autosearch" id="oasis_patient_diagnosis_4f" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1g" value="">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2g" class="autosearch" id="oasis_patient_diagnosis_2g" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3g" class="autosearch" id="oasis_patient_diagnosis_3g" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4g" class="autosearch" id="oasis_patient_diagnosis_4g" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1h" value="">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2h" class="autosearch" id="oasis_patient_diagnosis_2h" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3h" class="autosearch" id="oasis_patient_diagnosis_3h" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4h" class="autosearch" id="oasis_patient_diagnosis_4h" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1i" value="">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2i" class="autosearch" id="oasis_patient_diagnosis_2i" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3i" class="autosearch" id="oasis_patient_diagnosis_3i" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4i" class="autosearch" id="oasis_patient_diagnosis_4i" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1j" value="">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2j" class="autosearch" id="oasis_patient_diagnosis_2j" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3j" class="autosearch" id="oasis_patient_diagnosis_3j" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4j" class="autosearch" id="oasis_patient_diagnosis_4j" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1k" value="">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2k" class="autosearch" id="oasis_patient_diagnosis_2k" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3k" class="autosearch" id="oasis_patient_diagnosis_3k" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4k" class="autosearch" id="oasis_patient_diagnosis_4k" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1l" value="">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2l" class="autosearch" id="oasis_patient_diagnosis_2l" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3l" class="autosearch" id="oasis_patient_diagnosis_3l" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4l" class="autosearch" id="oasis_patient_diagnosis_4l" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1m" value="">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2m" class="autosearch" id="oasis_patient_diagnosis_2m" value="" onKeyDown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="0"><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="1"><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="2"><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="3"><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="4"><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3m" class="autosearch" id="oasis_patient_diagnosis_3m" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4m" class="autosearch" id="oasis_patient_diagnosis_4m" value="" onKeyDown="fonChange(this,2,'noev')">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
		
	</li>
                    </ul>
                </li>
	</ul>
	
	
	<ul id="oasis">
                <li>
                    <div><a href="#" id="black"><?php xl('Primary Caregiver,Functional Limitations,Musculoskeletal,Vital Signs,Height And Weight','e');?></a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
	<table width="100%" border="1" class="formtable">
	<tr><td colspan="2" align="center"><strong><?php xl('PRIMARY CAREGIVER','e');?></strong></td></tr>
	<tr><td width="50%">
	<strong><?php xl('Name: ','e');?></strong>&nbsp;<input type="textbox" name="oasis_patient_history_caregiver" size="37"/>
	<br><strong><?php xl('Relationship: ','e');?></strong>&nbsp;<input type="textbox" name="oasis_caregiver_relationship" size="30"/>
	<br><strong><?php xl('Phone Number','e');?></strong>&nbsp;<strong><?php xl('(if different from patient) ','e');?></strong>
	<br><input type="textbox" name="oasis_caregiver_phonenumber" size="28"/><br>
	
	<br><br><br><br><br/><br>
	
	</td>
	<td width="50%">
	<strong><?php xl('Language spoken: ','e');?></strong>&nbsp;
	<input type="checkbox" name="oasis_language_spoken[]" value="English"><?php xl('English','e')?>&nbsp;
	<input type="checkbox" name="oasis_language_spoken[]" value="Spanish"><?php xl('Spanish','e')?>&nbsp;
	<input type="checkbox" name="oasis_language_spoken[]" value="Russian"><?php xl('Russian','e')?>&nbsp;
	<br/><input type="checkbox" name="oasis_language_spoken[]" value="Other"><?php xl('Other','e')?>&nbsp;
	<input type="textbox" name="oasis_language_spoken_other" size="45"/><br>
	<strong><?php xl('Comments: ','e');?></strong><br>
	<textarea rows="6" cols="42" name="oasis_patient_history_commnets"></textarea>
	<br>
	<strong><?php xl('Able to safely care for patient','e');?></strong>&nbsp;
	<input type="radio" name="oasis_able_to_care" value="Yes"/><?php xl('Yes','e')?>&nbsp;
    <input type="radio" name="oasis_able_to_care" value="No"/><?php xl('No','e')?><br/>
	<strong><?php xl('If No, reason:','e');?></strong>&nbsp;<input type="textbox" name="oasis_able_to_care_reason" size="41"/><br>
	
	
	</td></tr>
	<tr><td  width="50%">
<table width="100%" border="0" class="formtable">
<tr><td align="center" colspan="3"><strong><?php xl('FUNCTIONAL LIMITATIONS','e')?></strong></td></tr>
<tr>
<td width="33%">
<input type="checkbox" name="oasis_functional_limitations[]" value="Amputation" /><?php xl('Amputation','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Hearing" /><?php xl('Hearing','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Ambulation" /><?php xl('Ambulation','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Dyspnea with Minimal Exertion" /><?php xl('Dyspnea with Minimal Exertion','e')?><br/>
</td>

<td width="33%">
<input type="checkbox" name="oasis_functional_limitations[]" value="Bowel/Bladder" /><?php xl('Bowel/Bladder (Incontinence)','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Paralysis" /><?php xl('Paralysis','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Speech" /><?php xl('Speech','e')?><br/>
<br>
</td>

<td width="33%">
<input type="checkbox" name="oasis_functional_limitations[]" value="Contracture" /><?php xl('Contracture','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Endurance" /><?php xl('Endurance','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Legally Blind" /><?php xl('Legally Blind','e')?><br/>
<br><br></td>
</tr>
<tr><td width="33%" colspan="3">

<input type="checkbox" name="oasis_functional_limitations[]" value="Other" /><?php xl('Other (specify):','e')?>
<input type="textbox" name="oasis_functional_limitations_other" size="40"/>
<br><br>
</td></tr>

<tr><td colspan="3" align="center">
<strong><?php xl('MUSCULOSKELETAL','e')?></strong></td></tr>

<tr><td colspan="3">
<input type="checkbox" name="oasis_musculoskeletal[]" value="No Problem" /><?php xl('No Problem','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Fracture" /><?php xl('Fracture (location)','e')?>&nbsp;
<input type="textbox" name="oasis_musculoskeletal_fracture_location" size="37"/><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Swollen,painful joints" /><?php xl('Swollen, painful joints (specify)','e')?>&nbsp;
<input type="textbox" name="oasis_musculoskeletal_swollen" size="25"/><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Contractures" /><?php xl('Contractures: Joint Location','e')?>&nbsp;
<input type="textbox" name="oasis_musculoskeletal_contractures_joint" size="28"/><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Atrophy" /><?php xl('Atrophy','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Poor Conditioning" /><?php xl('Poor Conditioning','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Decreased ROM" /><?php xl('Decreased ROM','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Paresthesia" /><?php xl('Paresthesia','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Shuffling/Wide-based gait" /><?php xl('Shuffling/Wide-based gait','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Weakness" /><?php xl('Weakness','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Amputation" /><?php xl('Amputation: BK/AK/UE; R/L (specify)','e')?>&nbsp;
<br>&nbsp;&nbsp;
<input type="textbox" name="oasis_musculoskeletal_Amputation" size="45"/><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Hemiplegia" /><?php xl('Hemiplegia','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Paraplegia" /><?php xl('Paraplegia','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Quadriplegia" /><?php xl('Quadriplegia','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Other" /><?php xl('Other:','e')?>&nbsp;
<input type="textbox" name="oasis_musculoskeletal_other" size="49"/>
<br><br><br><br><br><br>
</td></tr>


</table>
</td>

<td width="50%">
<table width="100%" border="0" class="formtable">
<tr><td align="center" colspan="3"><strong><?php xl('VISION','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_vision[]" value="No Problem"/><?php xl('No Problem','e')?>
</td></tr>
<tr>
<td width="40%">

<input type="checkbox" name="oasis_vision[]" value="Glasses"/><?php xl('Glasses','e')?></br/>
<input type="checkbox" name="oasis_vision[]" value="Contacts"/><?php xl('Contacts:','e')?> 
<input type="checkbox" name="oasis_vision[]" value="R"/><?php xl('R','e')?>
<input type="checkbox" name="oasis_vision[]" value="L"/><?php xl('L','e')?><br/>
<input type="checkbox" name="oasis_vision[]" value="Prosthesis"/><?php xl('Prosthesis:','e')?>
<input type="checkbox" name="oasis_vision[]" value="R"/><?php xl('R','e')?>
<input type="checkbox" name="oasis_vision[]" value="L"/><?php xl('L','e')?><br>
</td>


<td width="30%">
<input type="checkbox" name="oasis_vision[]" value="Glaucoma"/><?php xl('Glaucoma','e')?></br/>
<input type="checkbox" name="oasis_vision[]" value="Blurred Vision"/><?php xl('Blurred Vision','e')?></br/>
<input type="checkbox" name="oasis_vision[]" value="Infections"/><?php xl('Infections','e')?> 
</td>

<td width="30%">
<input type="checkbox" name="oasis_vision[]" value="Jaundice"/><?php xl('Jaundice','e')?></br/>
<input type="checkbox" name="oasis_vision[]" value="Ptosis"/><?php xl('Ptosis','e')?></br/>
<br></td>
</tr>
<tr><td colspan="3">
<input type="checkbox" name="oasis_vision[]" value="Cataract surgery"/><?php xl('Cataract surgery: Site','e')?>&nbsp;
<input type="textbox" size="32" name="oasis_vision_cataract_surgery"/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Date','e')?>&nbsp;
<input type='text' size='10' name='oasis_vision_date' id='oasis_vision_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date6' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_vision_date", ifFormat:"%Y-%m-%d", button:"img_curr_date6"});
                                        </script>
</td></tr>
<tr><td colspan="3"> 
<?php xl('Other(Specify)','e')?>&nbsp;
<input type="textbox" name="oasis_vision_other" size="43"/>
<br><br>
</td>
</tr>

<tr><td align="center" colspan="3"><strong><?php xl('NOSE','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_nose[]" value="No Problem" /><?php xl('No Problem','e')?>
</td></tr>
<tr>
<td>
<input type="checkbox" name="oasis_nose[]" value="Congestion" /><?php xl('Congestion','e')?></br/>
<input type="checkbox" name="oasis_nose[]" value="Loss of smell" /><?php xl('Loss of smell','e')?> 
</td>
<td>
<input type="checkbox" name="oasis_nose[]" value="Epistaxis" /><?php xl('Epistaxis','e')?></br/>
<input type="checkbox" name="oasis_nose[]" value="Sinus problem" /><?php xl('Sinus problem','e')?></br/>
</td>
<td>&nbsp;</td>
</tr>
<tr><td colspan="3"><?php xl('Other(specify)','e')?>&nbsp;<input type="text" name="oasis_nose_other" size="40"/><br><br></td></tr>

<tr><td align="center" colspan="3"><strong><?php xl('EAR','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_ear[]"  value="No Problem"/><?php xl('No Problem','e')?></td>
</tr>
<tr>
<td width="40%" >
<input type="checkbox" name="oasis_ear[]" value="HOH" /><?php xl('HOH:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R" /><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L" /><?php xl('L','e')?> <br/>
<input type="checkbox" name="oasis_ear[]" value="Vertigo"/><?php xl('Vertigo:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R" /><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L"/><?php xl('L','e')?> <br/>
<input type="checkbox" name="oasis_ear[]" value="Deaf"/><?php xl('Deaf:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R"/><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L"/><?php xl('L','e')?> <br/>
</td>

<td width="60%" colspan="2">

<input type="checkbox" name="oasis_ear[]" value="Tinnitus"/><?php xl('Tinnitus:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R"/><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L"/><?php xl('L','e')?> <br/>
<input type="checkbox" name="oasis_ear[]" value="Hearing aid"/><?php xl('Hearing aid:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R"/><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L"/><?php xl('L','e')?> <br/>
</td>

</tr>
<tr><td colspan="3"><?php xl('Other(specify)','e')?>&nbsp;
<input type="text" name="oasis_ear_other" size="40"/><br><br></td></tr>

<tr><td align="center" colspan="3"><strong><?php xl('MOUTH','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_mouth[]" value="No Problem" /><?php xl('No Problem','e')?></td></tr>
<tr>
<td colspan="2">
<input type="checkbox" name="oasis_mouth[]" value="Dentures" /><?php xl('Dentures:','e')?>
<input type="checkbox" name="oasis_mouth[]" value="Upper"/><?php xl('Upper','e')?> 
<input type="checkbox" name="oasis_mouth[]" value="Lower" /><?php xl('Lower','e')?> 
<input type="checkbox" name="oasis_mouth[]" value="Partial"/><?php xl('Partial','e')?><br/>
<input type="checkbox" name="oasis_mouth[]" value="Gingivitis"/><?php xl('Gingivitis','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasis_mouth[]" value="Masses/Tumors"/><?php xl('Masses/Tumors','e')?><br/>
</td>

<td>
<input type="checkbox" name="oasis_mouth[]" value="Ulcerations"/><?php xl('Ulcerations','e')?> <br/>
<input type="checkbox" name="oasis_mouth[]" value="Toothache"/><?php xl('Toothache','e')?> 
</td>
</tr>

<tr><td colspan="3"><?php xl('Other(specify)','e')?>&nbsp;<input type="text" name="oasis_mouth_other" size="40"/><br><br></td></tr>

<tr><td align="center" colspan="3"><strong><?php xl('THROAT','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_throat[]"  value="No Problem"/><?php xl('No Problem','e')?></td></tr>
<tr>
<td>
<input type="checkbox" name="oasis_throat[]" value="Dysphagia" /><?php xl('Dysphagia','e')?><br/>
<input type="checkbox" name="oasis_throat[]" value="Hoarseness"/><?php xl('Hoarseness','e')?> 
</td>

<td  colspan="2">
<input type="checkbox" name="oasis_throat[]" value="Lesions" /><?php xl('Lesions','e')?><br/>
<input type="checkbox" name="oasis_throat[]" value="Sore throat" /><?php xl('Sore throat','e')?> 
</td>
</tr>

<tr><td colspan="3"><?php xl('Other(specify)','e')?><input type="text" name="oasis_throat_other" size="40"/><br><br></td></tr>

</table>
</td>
</tr>
<tr><td colspan="2" align="center">
<strong><?php xl('VITAL SIGNS','e')?></strong>
</td></tr>
<tr>
<td width="50%">
<table width="100%" border="0" class="formtable">
<tr>
<td align="center"><strong><?php xl('Blood Pressure:','e')?></strong></td>
<td align="center"><?php xl('Right','e')?></td>
<td align="center"><?php xl('Left','e')?></td>
</tr>
<tr>
<td align="center"><?php xl('Lying','e')?></td>
<td align="center"><input type="text" name="oasis_vital_lying_right" id="oasis_vital_lying_right" size="15" /></td>
<td align="center"><input type="text" name="oasis_vital_lying_left" id="oasis_vital_lying_left" size="15" /></td>
</tr>
<tr>
<td align="center"><?php xl('Sitting','e')?></td>
<td align="center"><input type="text" name="oasis_vital_sitting_right" id="oasis_vital_sitting_right" size="15" /></td>
<td align="center"><input type="text" name="oasis_vital_sitting_left" id="oasis_vital_sitting_left" size="15" /></td>
</tr>
<tr>
<td align="center"><?php xl('Standing','e')?></td>
<td align="center"><input type="text" name="oasis_vital_standing_right" id="oasis_vital_standing_right" size="15" /></td>
<td align="center"><input type="text" name="oasis_vital_standing_left" id="oasis_vital_standing_left" size="15" /></td>
</tr>
</table>

<strong><?php xl('Temperature: °F','e')?></strong>&nbsp;&nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Oral"  id="oasis_vital_temp" />
<?php xl('Oral','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Axillary"  id="oasis_vital_temp" />
<?php xl('Axillary','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Rectal"  id="oasis_vital_temp" />
<?php xl('Rectal','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Tympanic"  id="oasis_vital_temp" />
<?php xl('Tympanic','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Temporal"  id="oasis_vital_temp" />
<?php xl('Temporal','e')?></label> &nbsp;

</td>

<td>

<strong><?php xl('Pulse:','e')?></strong>
<br />
<label><input type="radio" name="oasis_vital_pulse[]" value="At Rest"  id="oasis_vital_pulse" />
<?php xl('At Rest','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_pulse[]" value="Activity/Exercise"  id="oasis_vital_pulse" />
<?php xl('Activity/Exercise','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_pulse[]" value="Regular"  id="oasis_vital_pulse" />
<?php xl('Regular','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_pulse[]" value="Irregular"  id="oasis_vital_pulse" />
<?php xl('Irregular','e')?></label> &nbsp;
<br />
<label><input type="checkbox" name="oasis_vital_pulse[]" value="Radial"  id="oasis_vital_pulse" /> <?php xl('Radial','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_vital_pulse[]" value="Carotid"  id="oasis_vital_pulse" /> <?php xl('Carotid','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_vital_pulse[]" value="Apical"  id="oasis_vital_pulse" /> <?php xl('Apical','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_vital_pulse[]" value="Brachial"  id="oasis_vital_pulse" /> <?php xl('Brachial','e')?></label> &nbsp;
<br />
<br>

<strong><?php xl('Respiratory Rate:','e')?></strong>&nbsp;&nbsp;&nbsp;
<label><input type="radio" name="oasis_vital_resp_rate" value="Normal"  id="oasis_vital_resp_rate" />
<?php xl('Normal','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_resp_rate" value="Cheynes Stokes"  id="oasis_vital_resp_rate" />
<?php xl('Cheynes Stokes','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_resp_rate" value="Death rattle"  id="oasis_vital_resp_rate" />
<?php xl('Death rattle','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_resp_rate" value="Apnea/sec"  id="oasis_vital_resp_rate" />
<?php xl('Apnea/sec','e')?></label> &nbsp;
<br>
</td>
</tr>
<tr><td colspan="2" align="center">
<strong><?php xl('HEIGHT AND WEIGHT','e')?></strong>
</td></tr>
<tr><td width="50%">

<table width="100%" border="0" class="formtable">
<tr><td width="25%">
<strong><?php xl('Height:','e')?></strong>&nbsp;<input type="text" name="oasis_height" size="6"/> &nbsp;
</td><td width="25%">
<label><input type="radio" name="oasis_height_check" value="actual" />
<?php xl('actual','e')?></label><br/>
<label><input type="radio" name="oasis_height_check" value="reported" />
<?php xl('reported','e')?></label> &nbsp;
</td>
<td width="25%">
<strong><?php xl('Weight:','e')?></strong>&nbsp;<input type="text" name="oasis_weight" size="6"/> &nbsp;
</td><td width="25%">
<label><input type="radio" name="oasis_weight_check" value="actual" />
<?php xl('actual','e')?></label> <br/>
<label><input type="radio" name="oasis_weight_check" value="reported" />
<?php xl('reported','e')?></label> &nbsp;

</td></tr></table>
</td>
<td width="50%">
<table width="100%" border="0" class="formtable">
<tr><td>
<?php xl('Any Weight Changes?','e')?>&nbsp;
<label><input type="radio" name="oasis_weight_changes" value="Yes" />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="oasis_weight_changes" value="No" />
<?php xl('No','e')?></label> &nbsp;<br/>
<?php xl('If yes:','e')?>&nbsp;
<label><input type="radio" name="oasis_weight_changes_yes" value="Gain" />
<?php xl('Gain','e')?></label> &nbsp;
<input type="text" name="oasis_weight_gain" size="10"/>&nbsp;
<label><input type="radio" name="oasis_weight_changes_yes" value="Loss" />
<?php xl('Loss','e')?></label> &nbsp;
<input type="text" name="oasis_weight_loss" size="10"/>&nbsp;
<?php xl('of lb. in','e')?>&nbsp;
<label><input type="radio" name="oasis_weight_changes_yes_lbin" value="wk" />
<?php xl('wk./','e')?></label> &nbsp;
<label><input type="radio" name="oasis_weight_changes_yes_lbin" value="mo" />
<?php xl('mo./','e')?></label> &nbsp;
<label><input type="radio" name="oasis_weight_changes_yes_lbin" value="yr" />
<?php xl('yr.','e')?></label> &nbsp;

</td></tr></table>
</td>
</tr>
	</table>
	
		</li>
               </ul>
                </li></ul>
				
				
<ul id="oasis">
                <li>
                    <div><a href="#" id="black"><?php xl('Pain,Timed Up And Go Test,Integumentary Status,Braden Scale','e')?></a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
		<table width="100%" border="1" class="formtable">
		<tr><td align="center" colspan="2">
		<strong><?php xl('PAIN','e')?></strong>
		</td></tr>
		<tr>		
		<td colspan="2">
            <table border="0" cellspacing="0" align="center" class="formtable">
                <tr>

                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_adult_assessment/templates/scale_0.png" border="0" onClick="select_pain(0)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_adult_assessment/templates/scale_2.png" border="0" onClick="select_pain(1)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_adult_assessment/templates/scale_4.png" border="0" onClick="select_pain(2)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_adult_assessment/templates/scale_6.png" border="0" onClick="select_pain(3)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_adult_assessment/templates/scale_8.png" border="0" onClick="select_pain(4)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/oasis_adult_assessment/templates/scale_10.png" border="0" onClick="select_pain(5)">
                    </td>
                </tr>
</table>

<strong><u><?php xl('Pain Rating Scale:','e')?></u></strong>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_1" value="0"><?php xl('0-No Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_2" value="2"><?php xl('2-Little Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_4" value="4"><?php xl('4-Little More Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_6" value="6"><?php xl('6-Even More Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_8" value="8"><?php xl('8-Lots of Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_10" value="10"><?php xl('10-Worst Pain ','e')?></label>
            <br />
           <label>
 <strong><u><?php xl('Location:','e')?></u></strong> <?php xl('Cause:','e')?>
            <input type="text" name="oasis_pain_location_cause" style="width:70%;" ><br>
           </label>
            <strong><u><?php xl('Description:','e')?></u></strong><br>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("sharp","e");?>"><?php xl('sharp','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("dull","e");?>"><?php xl('dull','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("cramping","e");?>"><?php xl('cramping','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("aching","e");?>"><?php xl('aching','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("burning","e");?>"><?php xl('burning','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("tingling","e");?>"><?php xl('tingling','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("throbbing","e");?>"><?php xl('throbbing','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("shooting","e");?>"><?php xl('shooting','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("pinching","e");?>"><?php xl('pinching','e')?></label><br>
<strong><u><?php xl('Frequency:','e')?></u></strong><br>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl("occasional","e");?>"><?php xl('occasional','e')?></label>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl("intermittent","e");?>">
        <?php xl('intermittent','e')?></label>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl("continuous","e");?>"><?php xl('continuous','e')?></label>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl('at rest','e');?>">
        <?php xl('at rest','e')?></label>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl('at night','e');?>"><?php xl('at night','e')?></label><br>

            <strong><u><?php xl('Aggravating factors:','e')?></u></strong><br>
            <label><input type="checkbox" name="oasis_pain_aggravating_factors" value="<?php xl("movement","e");?>"><?php xl('movement','e')?></label>
            <label><input type="checkbox" name="oasis_pain_aggravating_factors" value="<?php xl("time of day","e");?>"><?php xl('time of day','e')?></label>
            <label><input type="checkbox" name="oasis_pain_aggravating_factors" value="<?php xl("posture","e");?>"><?php xl('posture','e')?></label>
            <label><input type="checkbox" name="oasis_pain_aggravating_factors" value="<?php xl("other","e");?>"><?php xl('other','e')?></label>
<input type="text" name="oasis_pain_aggravating_factors_other" style="width:48%;" >
<br>

 <strong><u><?php xl('Relieving factors:','e')?></u></strong><br>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("medication","e");?>"><?php xl('medication','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("rest","e");?>"><?php xl('rest','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("heat","e");?>"><?php xl('heat','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("ice","e");?>"><?php xl('ice','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("massage","e");?>"><?php xl('massage','e')?></label>
			<label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("repositioning","e");?>"><?php xl('repositioning','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("diversion","e");?>"><?php xl('diversion','e')?></label>
<br />
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("other","e");?>"><?php xl('other','e')?>
</label>
<input type="text" name="oasis_pain_relieving_factors_other" style="width:78%;" >
<br>
<label>
            <strong><u><?php xl('Activities limited:','e')?></u></strong><br>
<textarea name="oasis_pain_activities_limited" rows="2" cols="82"></textarea>
</label>
	
		</td></tr>

		<tr><td width="50%">
		<?php xl('Is patient experiencing pain?','e')?>&nbsp;
		<label><input type="radio" name="oasis_pain_experiencing" value="Yes" />
		<?php xl('Yes','e')?></label> &nbsp;
		<label><input type="radio" name="oasis_pain_experiencing" value="No" />
		<?php xl('No','e')?></label> &nbsp;<br>
		<label><input type="checkbox" name="oasis_pain_unable_communicate" value="Unable to communicate"><?php xl('Unable to communicate','e')?></label><br>
		<strong><?php xl('Non-verbals demonstrated:','e')?></strong>&nbsp;<br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Diaphoresis"><?php xl('Diaphoresis','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Grimacing"><?php xl('Grimacing','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Moaning/Crying"><?php xl('Moaning/Crying','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Guarding"><?php xl('Guarding','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Irritability"><?php xl('Irritability','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Anger"><?php xl('Anger','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Tense"><?php xl('Tense','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Restlessness"><?php xl('Restlessness','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Change in vital signs"><?php xl('Change in vital signs','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Other"><?php xl('Other:','e')?></label>&nbsp;
		<input type="text" name="oasis_pain_non_verbals_other" style="width:50%;" > <br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Self-assessment"><?php xl('Self-assessment','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Implications"><?php xl('Implications:','e')?></label>&nbsp;
		<input type="text" name="oasis_pain_non_verbals_implications" style="width:50%;" >
				
		</td><td width="50%">
		<?php xl('How often is breakthrough medication needed?','e')?>&nbsp;<br/>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="Never"><?php xl('Never','e')?></label>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="Less than daily"><?php xl('Less than daily','e')?></label>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="2-3 times/day"><?php xl('2-3 times/day','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="More than 3 times/day"><?php xl('More than 3 times/day','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="Current pain control medications adequate"><?php xl('Current pain control medications adequate','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="other"><?php xl('other:','e')?></label>&nbsp;
		<input type="text" name="oasis_pain_breakthrough_medication_other" style="width:50%;" ><br/>
		<?php xl('Implications Care Plan:','e')?>&nbsp;
		<label><input type="radio" name="oasis_pain_breakthrough_implication" value="Yes" />
		<?php xl('Yes','e')?></label> &nbsp;
		<label><input type="radio" name="oasis_pain_breakthrough_implication" value="No" />
		<?php xl('No','e')?></label> &nbsp;
		<br><br><br><br>
		</td>
		</tr>
		<tr><td align="center" colspan="2">
		<strong><?php xl('Timed Up And Go Test','e')?></strong>
		</td></tr>
		
		<tr><td colspan="2">
		<strong><?php xl('Instructions for the Therapist:','e')?></strong>&nbsp;<br/>
		&nbsp;&nbsp;&nbsp;<?php xl('- Ask the patient to sit in a standard armchair. Measure out a distance of 10 feet from the patient & place a marker, for the patient, at this location.','e')?><br/>
		&nbsp;&nbsp;&nbsp;<?php xl('- (STOP the test if the patient is not safe to complete it).','e')?><br/>
		&nbsp;&nbsp;&nbsp;<?php xl('- Perform the test 2 times & average the scores to get the final score.','e')?><br/>
		</ul> <br/>
		<strong><?php xl('Instructions to the Patient:','e')?></strong>&nbsp;<br/>
		<?php xl('"On the word "Go" you are to get up & go & walk at a comfortable & safe pace to the marker, turn & return to the chair & sit down again."','e')?>&nbsp;
		<br>
		<table width="50%" border="0"  align="center" class="formtable">
		<tr><td width="33%" align="right"> 
		<?php xl('Trial 1:','e')?><br/>
		<?php xl('Trial 2:','e')?><br/>
		<?php xl('Average:','e')?><br/>
		</td><td width="33%">
		<input type="text" name="oasis_go_test_trail1" id="gotest_trail1" onKeyUp="Go_test_average()" style="width:100%;" ><br/>
		<input type="text" name="oasis_go_test_trail2" id="gotest_trail2" onKeyUp="Go_test_average()" style="width:100%;" ><br/>
		<input type="text" name="oasis_go_test_avg" id="gotest_average" style="width:100%;" readonly><br/>
		</td><td width="33%">
		<?php xl('Seconds','e')?><br/>
		<?php xl('Seconds','e')?><br/>
		<?php xl('Seconds','e')?><br/>
		</td></tr>
		</table>
				
		<strong><?php xl('Interpretation of Score:','e')?></strong>&nbsp;<br/>
		<?php xl('less than or equal to 10 seconds = free mobility','e')?>&nbsp;<br/>
		<?php xl('less than or equal to 14 seconds = decreased risk for falls','e')?>&nbsp;<br/>
		<?php xl('less than or equal to 20 seconds = patient is mostly independent','e')?>&nbsp;<br/>
		<?php xl('20 - 29 seconds = moderately impaired/ variable mobility','e')?>&nbsp;<br/>
		<?php xl('greater than or equal to 30 seconds = significant impaired mobility','e')?>&nbsp;<br/>
		</td></tr>
		
		<tr><td colspan="2" align="center">
		<strong><?php xl('INTEGUMENTARY STATUS','e')?></strong>
		</td></tr>
		<tr><td colspan="2">
		<?php xl('Mark all applicable conditions listed below:','e')?><br/>
		<strong><?php xl('Turgor:','e')?></strong>&nbsp;
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Good"><?php xl('Good','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Poor"><?php xl('Poor','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Edema"><?php xl('Edema (specify if not otherwise in assessment)','e')?></label>
		<br/>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Itch"><?php xl('Itch','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Rash"><?php xl('Rash','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Dry"><?php xl('Dry','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Scaling"><?php xl('Scaling','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Redness"><?php xl('Redness','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Bruises"><?php xl('Bruises','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Ecchymosis"><?php xl('Ecchymosis','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Pallor"><?php xl('Pallor','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Jaundice"><?php xl('Jaundice','e')?></label>
		<br/><label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Other"><?php xl('Other (specify)','e')?></label>&nbsp;
		<input type="text" name="oasis_integumentary_status_conditions_other" style="width:50%;" >
		
		</td>
		</tr>
		<tr><td colspan="2">
		
		 <table border="1px" cellspacing="0" class="formtable">
                <tr>
                    <td align="center" colspan="6">
       <strong><?php xl("BRADEN SCALE - For Predicting Pressure Sore Risk","e");?></strong><br>
                        <?php xl("*Fill out per organizational
policy","e");?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl("<strong>HIGH RISK:</strong> Total score less than or equal to 12","e") ?>&nbsp;&nbsp;&nbsp;
 <?php xl("<strong>MODERATE RISK:</strong> Total score 13 - 14","e") ?><br>
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
                    <td align="center">&nbsp;
                       
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
                </li></ul>

	<ul id="oasis">
                <li>
                    <div><a href="#" id="black"><?php xl('Integumentary Status,Wound Locations','e')?></a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
	
		
	
	<table width="100%" class="formtable" border="1">
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
                        $c = new C_FormPainMap('oasis_adult_assessment','bodymap_man.png');

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
</table>
                  </li>
                    </ul>
                </li>
	</ul>

<br>
<a id="btn_save" href="javascript:void(0)" class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a></form>
</body>
</html>
