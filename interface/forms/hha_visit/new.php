<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: hha_visit");
?>

<html>
<head>
<title><?php xl('CARE PLAN','e')?></title>
<style type="text/css">
.bold {
	font-weight: bold;
}
.padd { padding-left:20px }

#bdr-right
{
border-right:none;
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


</head>

<body>
<form method="post"		action="<?php echo $rootdir;?>/forms/hha_visit/save.php?mode=new" name="hha_visit">
		<h3 align="center"><?php xl('HHA VISIT NOTE','e') ?></h3>

<table class="formtable" width="100%" border="0">
<TR valign="top">
<TD>
<b><?php xl('Patient:','e') ?></b>
<input type="text" name="hha_visit_patient_name" size="40" value="<?php patientName(); ?>" readonly="readonly"  /><br />
</TD>
<TD align="right">

<b><?php xl('Caregiver:','e') ?></b>
<input type="text" name="hha_visit_caregiver_name" size="30" />
<b><?php xl('Visit Date:','e') ?></b>
<input type="text" name="hha_visit_date" size="20" value="<?php VisitDate(); ?>" readonly/><br />

<b><?php xl('Time In:','e') ?></b>
<select name="hha_visit_time_in" id="hha_visit_time_in">
<?php timeDropDown($GLOBALS['Selected']) ?>
</select>

<b><?php xl('Time Out:','e') ?></b>
<select name="hha_visit_time_out" id="hha_visit_time_out">
<?php timeDropDown($GLOBALS['Selected']) ?>
</select>

</TD>
</TR>
</TABLE>

<table class="formtable" width="100%" border="1" cellpadding="5px" cellspacing="0px">

<tr><TD>
<table class="formtable" width="100%" border="0">
<tr border="0">
<td width="70%" align="right" style="border-right-style:none;">
<b><?php xl('When completing, be sure to follow the Aide Assignment Sheet (form 3574/3) codes.','e') ?></b>
</td>
<td align="right" width="30%" style="border-left-style:none;">
<label><b><?php xl('EMPLOYEE NAME:','e')?></b>
<input type="text" name="hha_visit_employee_name" size="10"  /> </label><br />
<label><b><?php xl('EMPLOYEE NO:','e')?></b>
<input type="text" name="hha_visit_employee_no" size="10"  /> </label>
</td>
</tr>
</table>
</TD></tr>

<tr>
<TD colspan="2">


<table width="95%" border="0" align="center" class="formtable">

<tr align="center">
<TD>
<b><?php xl('ACTIVITIES','e')?></b>
</td>
<TD>
<b><?php xl('COMMENTS(All comments must be dated)','e')?></b>
</td>
</tr>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Bath - Tub/Shower','e')?>" />
<?php xl('Bath - Tub/Shower','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_bath" size="50%"  />
<?php echo goals_date('hha_visit_bath_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Bed Bath - Partial/Complete','e')?>" />
<?php xl('Bed Bath - Partial/Complete','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_bed_bath" size="50%"  />
<?php echo goals_date('hha_visit_bed_bath_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Assist Bath - Chair','e')?>" />
<?php xl('Assist Bath - Chair','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_assist_bath" size="50%"  />
<?php echo goals_date('hha_visit_assist_bath_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Personal Care','e')?>" />
<?php xl('Personal Care','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_personal_care" size="50%"  />
<?php echo goals_date('hha_visit_personal_care_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Assist with dressing','e')?>" />
<?php xl('Assist with dressing','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_assist_with_dressing" size="50%"  />
<?php echo goals_date('hha_visit_assist_with_dressing_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Hair care - brush/shampoo/other','e')?>" />
<?php xl('Hair care - brush/shampoo/other','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_hair_care" size="50%"  />
<?php echo goals_date('hha_visit_hair_care_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Skin Care/Foot Care (Hygiene)','e')?>" />
<?php xl('Skin Care/Foot Care (Hygiene)','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_skin_care" size="50%"  />
<?php echo goals_date('hha_visit_skin_care_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Check pressure areas','e')?>" />
<?php xl('Check pressure areas','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_check_pressure_areas" size="50%"  />
<?php echo goals_date('hha_visit_check_pressure_areas_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Shave/Groom/Deodorant','e')?>" />
<?php xl('Shave/Groom/Deodorant','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_shave_groom" size="50%"  />
<?php echo goals_date('hha_visit_shave_groom_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Nail Hygiene - clean/file/report','e')?>" />
<?php xl('Nail Hygiene - clean/file/report','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_nail_hygiene" size="50%"  />
<?php echo goals_date('hha_visit_nail_hygiene_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Oral Care - brush/swab/dentures','e')?>" />
<?php xl('Oral Care - brush/swab/dentures','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_oral_care" size="50%"  />
<?php echo goals_date('hha_visit_oral_care_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Elimination Assist','e')?>" />
<?php xl('Elimination Assist','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_elimination_assist" size="50%"  />
<?php echo goals_date('hha_visit_elimination_assist_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Catheter Care','e')?>" />
<?php xl('Catheter Care','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_catheter_care" size="50%"  />
<?php echo goals_date('hha_visit_catheter_care_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Ostomy Care','e')?>" />
<?php xl('Ostomy Care','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_ostomy_care" size="50%"  />
<?php echo goals_date('hha_visit_ostomy_care_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Record Output/Input','e')?>" />
<?php xl('Record Output/Input','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_record" size="50%"  />
<?php echo goals_date('hha_visit_record_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Inspect/Reinforce Dressing','e')?>" />
<?php xl('Inspect/Reinforce Dressing','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_inspect_reinforce" size="50%"  />
<?php echo goals_date('hha_visit_inspect_reinforce_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Assist with Medications','e')?>" />
<?php xl('Assist with Medications','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_assist_with_medications" size="50%"  />
<?php echo goals_date('hha_visit_assist_with_medications_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('T - Oral/Axillary/Rectal','e')?>" />
<?php xl('T - Oral/Axillary/Rectal','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_T" size="50%"  />
<?php echo goals_date('hha_visit_T_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Pulse - Site and Result','e')?>" />
<?php xl('Pulse - Site and Result','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_pulse" size="50%"  />
<?php echo goals_date('hha_visit_pulse_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Respirations - Results','e')?>" />
<?php xl('Respirations - Results','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_respirations" size="50%"  />
<?php echo goals_date('hha_visit_respirations_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('BP - Site and Results','e')?>" />
<?php xl('BP - Site and Results','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_BP" size="50%"  />
<?php echo goals_date('hha_visit_BP_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Weight - Results','e')?>" />
<?php xl('Weight - Results','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_weight" size="50%"  />
<?php echo goals_date('hha_visit_weight_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Ambulation Assist - WC/Walker/Cane','e')?>" />
<?php xl('Ambulation Assist - WC/Walker/Cane','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_ambulation_assist" size="50%"  />
<?php echo goals_date('hha_visit_ambulation_assist_date'); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Mobility Assist','e')?>" />
<?php xl('Mobility Assist','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_mobility_assist" size="50%"  />
<?php echo goals_date('hha_visit_mobility_assist_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('ROM - Active/Passive','e')?>" />
<?php xl('ROM - Active/Passive','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_ROM" size="50%"  />
<?php echo goals_date('hha_visit_ROM_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Positioning - Encourage/Assist to turn q hrs','e')?>" />
<?php xl('Positioning - Encourage/Assist to turn q hrs','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_positioning" size="50%"  />
<?php echo goals_date('hha_visit_positioning_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Exercise - per PT/OT/SLP Care Plan','e')?>" />
<?php xl('Exercise - per PT/OT/SLP Care Plan','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_exercise" size="50%"  />
<?php echo goals_date('hha_visit_exercise_date'); ?>
</TD>
</TR>


<tr>
<TD width="30"><label>
<input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Diet Order','e')?>" />
<?php xl('Diet Order:','e')?> </label>
<input type="text" name="hha_visit_diet_order1" size="30%"  />
</TD>
<TD>
<input type="text" name="hha_visit_diet_order" size="50%"  />
<?php echo goals_date('hha_visit_diet_order_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Meal Preparation','e')?>" />
<?php xl('Meal Preparation','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_meal_preparation" size="50%"  />
<?php echo goals_date('hha_visit_meal_preparation_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Assist with Feeding','e')?>" />
<?php xl('Assist with Feeding','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_assist_with_feeding" size="50%"  />
<?php echo goals_date('hha_visit_assist_with_feeding_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Limit/Encourage Fluids','e')?>" />
<?php xl('Limit/Encourage Fluids','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_limit_encourage_fluids" size="50%"  />
<?php echo goals_date('hha_visit_limit_encourage_fluids_date'); ?>
</TD>
</TR>



<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Grocery Shopping','e')?>" />
<?php xl('Grocery Shopping','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_grocery_shopping" size="50%"  />
<?php echo goals_date('hha_visit_grocery_shopping_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Wash Clothes','e')?>" />
<?php xl('Wash Clothes','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_wash_clothes" size="50%"  />
<?php echo goals_date('hha_visit_wash_clothes_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Light HouseKeeping - Bedroom/Bathroom/Kitchen - Change bed linen','e')?>" />
<?php xl('Light HouseKeeping - Bedroom/Bathroom/Kitchen - Change bed linen','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_light_housekeeping" size="50%"  />
<?php echo goals_date('hha_visit_light_housekeeping_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Observe Universal Precautions','e')?>" />
<?php xl('Observe Universal Precautions','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_observe_universal_precaution" size="50%"  />
<?php echo goals_date('hha_visit_observe_universal_precaution_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Equipment Care','e')?>" />
<?php xl('Equipment Care','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_equipment_care" size="50%"  />
<?php echo goals_date('hha_visit_equipment_care_date'); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Washing hands before and after services','e')?>" />
<?php xl('Washing hands before and after services','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_washing_hands" size="50%"  />
<?php echo goals_date('hha_visit_washing_hands_date'); ?>
</TD>
</TR>


</table>

<table width="100%" class="formtable" border="0">
<TR>
<TD>
<b><?php xl('SIGNATURE/DATES','e')?></b>
</TD>
</TR>
<TR><TD>
<b><?php xl('Patient/ Client','e')?></b>
<input type="text" name="hha_visit_patient_client_sign" size="50%"  />
</TD>
<td rowspan="2">
<b><?php xl('Date','e')?></b>
<input type='text' size='10' name='hha_visit_patient_client_sign_date' id='hha_visit_patient_client_sign_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date7' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"hha_visit_patient_client_sign_date", ifFormat:"%Y-%m-%d", button:"img_curr_date7"});
                        </script>
</td>
</TR>
</table>

</TD>
</tr>


<tr><TD colspan="2">
<b><?php xl('Supplies Used','e')?></b>
<label><input type="radio" name="hha_visit_supplies_used" value="Yes"  id="hha_visit_supplies_used" /> <?php xl('Yes','e')?></label>
<label><input type="radio" name="hha_visit_supplies_used" value="No"  id="hha_visit_supplies_used" /> <?php xl('No','e')?></label>
<br />
<textarea name="hha_visit_supplies_used_data" rows="4" cols="98"></textarea>
</TD></tr>

<tr><TD>
<b><?php xl('This form has been electronically signed by:','e')?></b>
</TD></tr>

</table>
<br />

<a href="javascript:top.restoreSession();document.hha_visit.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
