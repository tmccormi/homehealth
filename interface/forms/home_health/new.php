<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: home_health");
?>

<html>

<head>
<title><?php xl('Home Health Certification and Plan of Care','e')?></title>
<style type="text/css">
.bold {
	font-weight: bold;
}
.padd { padding-left:20px }
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


</script>

</head>

<body>

<form method="post" action="<?php echo $rootdir;?>/forms/home_health/save.php?mode=new" name="home_health">
		
<h3 align="center"><?php xl('Home Health Certification and Plan of Care','e') ?></h3><br /><br />



<table class="formtable" width="100%" border="1">

<tr>
<td colspan="2">
<b><?php xl('Patient:','e') ?></b>
<input type="text" name="home_health_patient_name" size="50" value="<?php patientName(); ?>" readonly="readonly"  />
</td>
</tr>


<tr>
<td colspan="2">

<table class="formtable" width="100%" border="1">
<tr>
<td>
<b><?php xl('1. Patient\'s HI Claim No:','e') ?></b><br />
<input type="text" name="home_health_patient_hi_claim_no" size="20"  />
</td>
<td>
<b><?php xl('2. Start of Care Date:','e') ?></b><br />
<input type='text' size='10' name='home_health_start_care_date' id='home_health_start_care_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date55' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_start_care_date", ifFormat:"%Y-%m-%d", button:"img_curr_date55"});
                        </script>

</td>
<td>
<b><?php xl('3. Certification Period:','e') ?></b><br />

<input type='text' size='10' name='home_health_cert_period_from' id='home_health_cert_period_from'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date61' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_cert_period_from", ifFormat:"%Y-%m-%d", button:"img_curr_date61"});
                        </script>
<?php xl(' -- ','e') ?>
<input type='text' size='10' name='home_health_cert_period_to' id='home_health_cert_period_to'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date73' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_cert_period_to", ifFormat:"%Y-%m-%d", button:"img_curr_date73"});
                        </script>

</td>
<td>
<b><?php xl('4. Medical Record No:','e') ?></b><br />
<input type="text" name="home_health_med_rec_no" size="10" value="<?php echo $_SESSION['pid']; ?>" readonly />
</td>
<td>
<b><?php xl('5. Provider No:','e') ?></b><br />
<input type="text" name="home_health_provider_no" size="20" />
</td>
</tr>
</table>

</td>
</tr>


<tr>
<td>
<b><?php xl('6. Patient\'s Name and Address:','e') ?></b><br />
<textarea name="home_health_patient_name_addr" rows="4" cols="60" readonly="true">
<?php patientNameAddr(); ?>
</textarea>
</td>
<td>
<b><?php xl('7. Provider\'s Name Address and Telephone Number:','e') ?></b><br />
<textarea name="home_health_provider_name_addr" rows="4" cols="60"></textarea>
</td>
</tr>



<tr>
<td width="50%">

<TABLE class="formtable" width="100%" border="1" style="padding:0; margin:0;">
<tr>
<td colspan="4">
<b><?php xl('8. Date of Birth:','e') ?></b>
<input type="text" name="home_health_dob" size="20" value="<?php patientDOB(); ?>" readonly="readonly"  />
&nbsp;&nbsp;&nbsp;

<b><?php xl('9. Sex:','e') ?></b>
<label><input type="radio" value="Male" <?php if(patientSex()=="Male") echo "checked"; ?> readonly="readonly" disabled />
<?php xl('Male','e')?></label> &nbsp;&nbsp;&nbsp;
<label><input type="radio" value="Female" <?php if(patientSex()=="Female") echo "checked"; ?>  readonly="readonly" disabled /> 
<?php xl('Female','e')?></label> &nbsp;

<input type="hidden" name="home_health_sex" 
value="<?php if(patientSex()=="Male") echo "Male"; else echo "Female"; ?>" />
</td>
</tr>
	
<tr valign="top">
<td>
<b><?php xl('11. ICD-9-CM:','e') ?></b><br />
<input type="text" name="home_health_icd_9_cm1" id="home_health_icd_9_cm1" size="10"  onkeydown="fonChange(this,2,'noev')" />
</td>
<td>
<b><?php xl('Principal Diagnosis','e') ?></b><br />
<textarea name="home_health_principal_diagnosis" rows="2" cols="30"></textarea>
</td>
<td>
<b><?php xl('Date','e') ?></b><br />
<input type='text' size='10' name='home_health_principal_date' id='home_health_principal_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date15' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_principal_date", ifFormat:"%Y-%m-%d", button:"img_curr_date15"});
                        </script>
</td>
<td>
<b><?php xl('E/O','e') ?></b><br />
<input type="text" style="width:100%" name="home_health_principal_eo" id="home_health_principal_eo" size="5" />
</td>
</tr>

<tr valign="top">
<td>
<b><?php xl('12. ICD-9-CM:','e') ?></b><br />
<input type="text" name="home_health_icd_9_cm2" id="home_health_icd_9_cm2" size="10"  onkeydown="fonChange(this,2,'noev')" />
</td>
<td>
<b><?php xl('Surgical Procedure','e') ?></b><br />
<textarea name="home_health_surgical_procedure" rows="2" cols="30"></textarea>
</td>
<td>
<b><?php xl('Date','e') ?></b><br />
<input type='text' size='10' name='home_health_surgical_date' id='home_health_surgical_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date29' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_surgical_date", ifFormat:"%Y-%m-%d", button:"img_curr_date29"});
                        </script>
</td>
<td>
<b><?php xl('E/O','e') ?></b><br />
<input type="text" style="width:100%" name="home_health_surgical_eo" id="home_health_surgical_eo" size="5"  />
</td>
</tr>

<tr valign="top">
<td>
<b><?php xl('12. ICD-9-CM:','e') ?></b><br />
<input type="text" name="home_health_icd_9_cm3" id="home_health_icd_9_cm3" size="10" onkeydown="fonChange(this,2,'noev')"  />
</td>
<td>
<b><?php xl('Other Pertinent Diagnosis','e') ?></b><br />
<textarea name="home_health_other_pertinent_diagnosis" rows="2" cols="30"></textarea>
</td>
<td>
<b><?php xl('Date','e') ?></b><br />
<input type='text' size='10' name='home_health_other_date' id='home_health_other_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date34' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_other_date", ifFormat:"%Y-%m-%d", button:"img_curr_date34"});
                        </script>
</td>
<td>
<b><?php xl('E/O','e') ?></b><br />
<input type="text" style="width:100%" name="home_health_other_eo" id="home_health_other_eo" size="5"  />
</td>
</tr>

</TABLE>

</td>

<td width="50%">

<b><?php xl('10. Medications: Dose/Frequency/Route (N)ew (C)hanged','e') ?></b><br />
<textarea name="home_health_medications" rows="15" cols="50"></textarea>

</td>
</tr>



<tr>
<TD>
<b><?php xl('14. DME and supplies:','e') ?></b><br />
<input type="text" size="50" name="home_health_dme_supplies" id="home_health_dme_supplies" />
</TD>

<TD>
<b><?php xl('15. Safety Measures:','e') ?></b><br />
<input type="text" size="50" name="home_health_safety_measures" id="home_health_safety_measures" />
</TD>
</tr>

<tr>
<TD>
<b><?php xl('16. Nutritional Requirements:','e') ?></b><br />
<input type="text" size="50" name="home_health_nut_reqs" id="home_health_nut_reqs" />
</TD>

<TD>
<b><?php xl('17. Allergies:','e') ?></b><br />
<input type="text" size="50" name="home_health_allergies" id="home_health_allergies" />
</TD>
</tr>



<tr>
<TD colspan="2">
<table class="formtable" width="100%">

<tr><TD colspan="3" style="border-right:dashed thin;">
<b><?php xl('18.A. Functional Limitations:','e') ?></b><br />
</TD>
<TD colspan="3">
<b><?php xl('18.B. Activities Permitted:','e') ?></b><br />
</TD>
</tr>


<tr valign="top">
<td width="15%">
<?php xl('1','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Amputation"  id="home_health_functional_limitations" />
<?php xl('Amputation','e') ?>&nbsp;
</label><br />
<?php xl('2','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Bowel/Bladder (Incontinence)"  id="home_health_functional_limitations" />
<?php xl('Bowel/Bladder (Incontinence)','e') ?>&nbsp;
</label><br />
<?php xl('3','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Contracture"  id="home_health_functional_limitations" />
<?php xl('Contracture','e') ?>&nbsp;
</label><br />
<?php xl('4','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Hearing"  id="home_health_functional_limitations" />
<?php xl('Hearing','e') ?>&nbsp;
</label><br />
</TD>


<TD width="12%">
<?php xl('5','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Paralysis"  id="home_health_functional_limitations" />
<?php xl('Paralysis','e') ?>&nbsp;
</label><br />
<?php xl('6','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Endurance"  id="home_health_functional_limitations" />
<?php xl('Endurance','e') ?>&nbsp;
</label><br />
<?php xl('7','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Ambulation"  id="home_health_functional_limitations" />
<?php xl('Ambulation','e') ?>&nbsp;
</label><br />
<?php xl('8','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Speech"  id="home_health_functional_limitations" />
<?php xl('Speech','e') ?>&nbsp;
</label><br />
</TD>

<TD width="20%" style="border-right:dashed thin;">
<?php xl('9','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Legally Blind"  id="home_health_functional_limitations" />
<?php xl('Legally Blind','e') ?>&nbsp;
</label><br />
<?php xl('A','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Dyspnea with Min. Exertion"  id="home_health_functional_limitations" />
<?php xl('Dyspnea with Min. Exertion','e') ?>&nbsp;
</label><br />
<?php xl('B','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_functional_limitations[]" value="Other (Specify)"  id="home_health_functional_limitations" />
<?php xl('Other (Specify)','e') ?>&nbsp;
</label>
<input type="text" size="20" name="home_health_functional_limitations_other" id="home_health_functional_limitations_other" />
<br />
</TD>

<TD>
<?php xl('1','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Complete Bedrest"  id="home_health_activities_permitted" />
<?php xl('Complete Bedrest','e') ?>&nbsp;
</label><br />
<?php xl('2','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Bedrest BRP"  id="home_health_activities_permitted" />
<?php xl('Bedrest BRP','e') ?>&nbsp;
</label><br />
<?php xl('3','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Up As Tolerated"  id="home_health_activities_permitted" />
<?php xl('Up As Tolerated','e') ?>&nbsp;
</label><br />
<?php xl('4','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Transfer Bed/Chair"  id="home_health_activities_permitted" />
<?php xl('Transfer Bed/Chair','e') ?>&nbsp;
</label><br />
<?php xl('5','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Exercises Prescribed"  id="home_health_activities_permitted" />
<?php xl('Exercises Prescribed','e') ?>&nbsp;
</label><br />
</TD>

<TD>
<?php xl('6','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]" value="Partial Weight Bearing"   id="home_health_activities_permitted" />
<?php xl('Partial Weight Bearing','e') ?>&nbsp;
</label><br />
<?php xl('7','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Independent At Home"  id="home_health_activities_permitted" />
<?php xl('Independent At Home','e') ?>&nbsp;
</label><br />
<?php xl('8','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Crutches"  id="home_health_activities_permitted" />
<?php xl('Crutches','e') ?>&nbsp;
</label><br />
<?php xl('9','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Cane"  id="home_health_activities_permitted" />
<?php xl('Cane','e') ?>&nbsp;
</label><br />
</TD>

<TD>
<?php xl('A','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Wheelchair"  id="home_health_activities_permitted" />
<?php xl('Wheelchair','e') ?>&nbsp;
</label><br />
<?php xl('B','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]" value="Walker"   id="home_health_activities_permitted" />
<?php xl('Walker','e') ?>&nbsp;
</label><br />
<?php xl('C','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]" value="No Restrictions"   id="home_health_activities_permitted" />
<?php xl('No Restrictions','e') ?>&nbsp;
</label><br />
<?php xl('D','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_activities_permitted[]"  value="Other (specify)"  id="home_health_activities_permitted" />
<?php xl('Other (specify)','e') ?>&nbsp;
</label><br />
<input type="text" size="20" name="home_health_activities_permitted_other" id="home_health_activities_permitted_other" />
</TD>

</tr>
</table>
</td>
</tr>

<tr>
<TD colspan="2">
<table class="formtable" width="100%">
<tr>
<td>
<strong><?php xl('19. Mental Status','e') ?></strong>&nbsp;<br />
</TD>
<TD>
<?php xl('1','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_mental_status[]"  value="Oriented"  id="home_health_mental_status" />
<?php xl('Oriented','e') ?>&nbsp;
</label><br />
<?php xl('2','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_mental_status[]"  value="Comatose"  id="home_health_mental_status" />
<?php xl('Comatose','e') ?>&nbsp;
</label><br />
</TD>


<TD>
<?php xl('3','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_mental_status[]"  value="Forgetful"  id="home_health_mental_status" />
<?php xl('Forgetful','e') ?>&nbsp;
</label><br />
<?php xl('4','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_mental_status[]"  value="Depressed"  id="home_health_mental_status" />
<?php xl('Depressed','e') ?>&nbsp;
</label><br />
</TD>

<TD>
<?php xl('5','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_mental_status[]"  value="Disoriented"  id="home_health_mental_status" />
<?php xl('Disoriented','e') ?>&nbsp;
</label><br />
<?php xl('6','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_mental_status[]"  value="Lethargic"  id="home_health_mental_status" />
<?php xl('Lethargic','e') ?>&nbsp;
</label><br />
</TD>

<TD>
<?php xl('7','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_mental_status[]"  value="Agitated"  id="home_health_mental_status" />
<?php xl('Agitated','e') ?>&nbsp;
</label><br />
<?php xl('8','e') ?>&nbsp;
<label>
<input type="checkbox" name="home_health_mental_status[]"  value="Other"  id="home_health_mental_status" />
<?php xl('Other','e') ?>&nbsp;
</label>
<input type="text" size="30" name="home_health_mental_status_other" id="home_health_mental_status_other" />
</TD>

<td>
&nbsp;
</td>

</tr>
</table>
</td>
</tr>

<tr>
<TD colspan="2">
<table class="formtable" width="100%">
<TR>
<TD width="170">
<b><?php xl('20. Prognosis:','e') ?></b>
</TD>
<td width="140">
<?php xl('1','e') ?>&nbsp;
<label><input type="radio" name="home_health_prognosis" value="Poor"  id="home_health_prognosis" /> <?php xl('Poor','e')?></label>
</td>
<td width="140">
<?php xl('2','e') ?>&nbsp;
<label><input type="radio" name="home_health_prognosis" value="Guarded"  id="home_health_prognosis" /> <?php xl('Guarded','e')?></label>
</td>
<td width="150">
<?php xl('3','e') ?>&nbsp;
<label><input type="radio" name="home_health_prognosis" value="Fair"  id="home_health_prognosis" /> <?php xl('Fair','e')?></label>
</td>
<td>
<?php xl('4','e') ?>&nbsp;
<label><input type="radio" name="home_health_prognosis" value="Good"  id="home_health_prognosis" /> <?php xl('Good','e')?></label>
</td>
<td>
<?php xl('5','e') ?>&nbsp;
<label><input type="radio" name="home_health_prognosis" value="Excellent"  id="home_health_prognosis" /> <?php xl('Excellent','e')?></label>
</td>
<td>
&nbsp;
</td>
</TR>
</table>
</TD>
</tr>

<tr><TD colspan="2">
<b><?php xl('21. Orders for Discipline and Treatments:','e') ?></b><br />
<textarea name="home_health_orders_discipline" rows="4" cols="90"></textarea>
</TD></tr>

<tr><TD colspan="2">
<b><?php xl('22. Goals/Rehabiliation Potential/Discharge Plans:','e') ?></b><br />
<textarea name="home_health_goals" rows="4" cols="90"></textarea>
</TD></tr>

<tr><TD width="60%">
<b><?php xl('23. Nurse\'s Signature and Date Of Verbal SOC Where Applicable (See Below):','e') ?></b><br />
<input type="text" style="width:60%" name="home_health_nurse_sign" id="home_health_nurse_sign" />

<input type='text' size='10' name='home_health_nurse_sign_date' id='home_health_nurse_sign_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date82' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_nurse_sign_date", ifFormat:"%Y-%m-%d", button:"img_curr_date82"});
                        </script>

</TD>

<TD valign="top">
<b><?php xl('25. Date HHA Received Signed POT:','e') ?></b><br />
<input type='text' size='10' name='home_health_date_hha' id='home_health_date_hha'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date48' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_date_hha", ifFormat:"%Y-%m-%d", button:"img_curr_date48"});
                        </script>
</TD>


</tr>

<tr>
<TD width="50%">
<b><?php xl('24. Physician\'s Name and Address:','e') ?></b><br />
<textarea name="home_health_physician_name_addr" rows="4" cols="48" readonly="true">
<?php doctorNameAddr(); ?>
</textarea>
<br />
<b><?php xl('Physician\'s Phone #:','e') ?></b><br />
<input type="text" style="width:80%" name="home_health_physician_ph" id="home_health_physician_ph"
value="<?php doctorPhone(); ?>" readonly="true" /><br />
<b><?php xl('Physician\'s Fax #:','e') ?></b><br />
<input type="text" style="width:80%" name="home_health_physician_fax" id="home_health_physician_fax" 
value="<?php doctorFax(); ?>" readonly="true" /><br />
<b><?php xl('Physician\'s NPI #:','e') ?></b><br />
<input type="text" style="width:80%" name="home_health_physician_npi" id="home_health_physician_npi" 
value="<?php doctorNPI(); ?>" readonly="true" /><br />
</TD>
<TD valign="top">
<b><?php xl('26. I certify that this patient is confined to his/her home and needs intermittent skilled nursing care, physical therapy and/or her speech therapy or continues to need occupational therapy. The patient is under my care and i have authorized the services on this plan of care and will periodically review the plan.','e') ?></b><br />
</TD>
</tr>



<tr>
<TD>
<b><?php xl('27. Attending Physician\'s Signature and Date Signed:','e') ?></b><br />
<textarea name="home_health_attending_physician" rows="4" cols="48"></textarea>
<br />
<input type='text' size='10' name='home_health_attending_physician_date' id='home_health_attending_physician_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date97' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"home_health_attending_physician_date", ifFormat:"%Y-%m-%d", button:"img_curr_date97"});
                        </script>

</TD>
<td valign="top">
<b><?php xl('28. Anyone who misrepresents, falsifies, or conceals essential information required for payment of Federal funds may be subject to fine, imprisionment, or civil penalty under applicable federal laws.','e') ?></b><br />
</td>
</tr>

<tr><TD colspan="2">
<b><?php xl('Caregiver Signature:','e') ?></b>
<input type="text" style="width:60%" name="home_health_caregiver_sign" id="home_health_caregiver_sign" />
</TD></tr>



</table>




<a href="javascript:top.restoreSession();document.home_health.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
