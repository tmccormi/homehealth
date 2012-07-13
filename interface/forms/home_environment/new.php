<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: home_environment");
?>

<html>
<head>
<title>Home Environment</title>
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script>
function appendrow(box,item)
{
	if(box.checked)
	{	
		htmlrow='<tr id="home_environment_action_plan_row_'+item+'"><td><input type="text" size="10" name="home_environment_action_plan_'+item+'[]" value="'+item+'" readonly></td>';
		htmlrow+='<td><input type="text" size="10" name="home_environment_action_plan_'+item+'[]" id="home_environment_action_plan_'+item+'" title="yyyy-mm-dd Start Date" onkeyup="datekeyup(this,mypcc)"  value="" readonly/><img src="../../pic/show_calendar.gif" align="absbottom" width="24" height="22" id="img_start_date'+item+'" border="0" alt="[?]" style="cursor: pointer; cursor: hand" title="Click here to choose a date"><script	LANGUAGE="JavaScript">Calendar.setup({inputField:"home_environment_action_plan_'+item+'", ifFormat:"%Y-%m-%d", button:"img_start_date'+item+'"}); <';
		htmlrow+='/script>';
		htmlrow+='</td>';
		htmlrow+='<td><input type="text" name="home_environment_action_plan_'+item+'[]" value=""></td><td><input type="text" name="home_environment_action_plan_'+item+'[]" value=""></td><td><input type="text" name="home_environment_action_plan_'+item+'[]" value=""></td></tr>'
		$("#tableforno").append(htmlrow);
		
	}
	else
	{
		$("#home_environment_action_plan_row_"+item).remove();
	}
}
</script>
</head>
<body>
<form method="post"
		action="<?php echo $rootdir;?>/forms/home_environment/save.php?mode=new" name="home_environment">
		<h3 align="center"><?php xl('HOME ENVIRONMENT SAFETY ASSESSMENT','e')?></h3>		
		


<table width="100%" border="1px" class="formtable">
	<tr>
		<td colspan="4">
		<table width="100%" border="1px" class="formtable">
			<tr>
				<td><?php xl('Patient Name','e');?></td>
				<td width="50%"><input type="text" name="home_environment_patient_name" style="width:100%" value="<?php patientName()?>" readonly ></td>
				<td><?php xl('SOC Date','e');?></td>
				<td width="17%" align="center" valign="top" class="bold">
					<input type='text' size='10' name='home_environment_SOC_date' id='home_environment_SOC_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date1' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"home_environment_SOC_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
					</script>
				</td>
			</tr>
		</table>
	</tr>
	<tr>
		<td colspan="5">
			<?php xl('Check Yes, No or N/A for each safety description. Identify all "No" responses, document # and action plan for addressing issue. Document the date the patient was informed of safety issues.','e')?>
		</td>
	</tr>
	<tr>
		<td>
			#
		</td>
		<td>
			<?php xl('Description','e');?>
		</td>
		<td>
			<?php xl('Yes','e');?>
		</td>
		<td>
			<?php xl('No','e');?>
		</td>
		<td>
			<?php xl('N/A','e');?>
		</td>
	</tr>
	<tr>
		<td>
			1.
		</td>
		<td>
			<?php xl('There is a working telephone and emergency numbers are accessible.','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_telephone" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_telephone" value="<?php xl('No','e');?>" onchange="appendrow(this,1)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_telephone" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			2.
		</td>
		<td>
			<?php xl('Gas/Electrical appliances and outlets appear in working condition','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_gas_electrical" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_gas_electrical" value="<?php xl('No','e');?>" onchange="appendrow(this,2)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_gas_electrical" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			3.
		</td>
		<td>
			<?php xl('There are functional smoke alarm(s) in working condition at all levels','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_smoke_alarm_condition" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_smoke_alarm_condition" value="<?php xl('No','e');?>" onchange="appendrow(this,3)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_smoke_alarm_condition" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			4.
		</td>
		<td>
			<?php xl('There is a fire extinguisher available and accessible','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_fire_extinguisher" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_fire_extinguisher" value="<?php xl('No','e');?>" onchange="appendrow(this,4)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_fire_extinguisher" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			5.
		</td>
		<td>
			<?php xl('Access to outside exits is free of obstructions.','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_outside_exit" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_outside_exit" value="<?php xl('No','e');?>" onchange="appendrow(this,5)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_outside_exit" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			6.
		</td>
		<td>
			<?php xl('Alternate exits are accessible in case of fire.','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_alternate_exit" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_alternate_exit" value="<?php xl('No','e');?>" onchange="appendrow(this,6)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_alternate_exit" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			7.
		</td>
		<td>
			<?php xl('Walking pathways are level, uncluttered and have non-skid surfaces.','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_walking_pathway" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_walking_pathway" value="<?php xl('No','e');?>" onchange="appendrow(this,7)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_walking_pathway" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			8.
		</td>
		<td>
			<?php xl('Stairs are in good repair, well lit, uncluttered and have non-skid surfaces. Handrails are present and secure.','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_stairs" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_stairs" value="<?php xl('No','e');?>" onchange="appendrow(this,8)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_stairs" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			9.
		</td>
		<td>
			<?php xl('Lighting is adequate for safe ambulation/mobility and ADL','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_lighting" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_lighting" value="<?php xl('No','e');?>" onchange="appendrow(this,9)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_lighting" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			10.
		</td>
		<td>
			<?php xl('Adequate heating and cooling systems available.','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_heating" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_heating" value="<?php xl('No','e');?>" onchange="appendrow(this,10)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_heating" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			11.
		</td>
		<td>
			<?php xl('Medicines and poisonous/toxic substances are clearly labeled and place where patient can reach, if needed, yet not within reach of children','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_medicine" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_medicine" value="<?php xl('No','e');?>" onchange="appendrow(this,11)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_medicine" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			12.
		</td>
		<td>
			<?php xl('Bathroom is safe for the provision of care (i.e. raised toilet seat, tub seat, grab bar, non-skid surface in tub, etc.)','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_bathroom" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_bathroom" value="<?php xl('No','e');?>" onchange="appendrow(this,12)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_bathroom" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			13.
		</td>
		<td>
			<?php xl('Kitchen is safe for the provision of care (i.e. working small appliances, adequate ventilation for cooking, working refrigerator, stove, oven)','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_kitchen" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_kitchen" value="<?php xl('No','e');?>" onchange="appendrow(this,13)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_kitchen" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			14.
		</td>
		<td>
			<?php xl('Environment is safe for effective oxygen use.','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_eff_oxygen" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_eff_oxygen" value="<?php xl('No','e');?>" onchange="appendrow(this,14)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_eff_oxygen" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			15.
		</td>
		<td>
			<?php xl('Overall environment is adequately sanitary for the provision of care.','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_overall_sanitary" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_overall_sanitary" value="<?php xl('No','e');?>" onchange="appendrow(this,15)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_overall_sanitary" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			16.
		</td>
		<td>
			<?php xl('Is there adequate sanitation/plumbing','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_sanitation_plumbing" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_sanitation_plumbing" value="<?php xl('No','e');?>" onchange="appendrow(this,16)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_sanitation_plumbing" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td>
			17.
		</td>
		<td>
			<?php xl('Other','e');?>
		</td>
		<td>
			<input type="checkbox" name="home_environment_other" value="<?php xl('Yes','e');?>">
		</td>
		<td>
			<input type="checkbox" name="home_environment_other" value="<?php xl('No','e');?>" onchange="appendrow(this,17)">
		</td>
		<td>
			<input type="checkbox" name="home_environment_other" value="<?php xl('N/A','e');?>">
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<?php xl('All items checked NO above, need to complete the following','e');?>
		</td>
	</tr>
	</tr>
		<td colspan="5">
		<table border="1px" class="formtable" id="tableforno" width="100%">
			<tr>
				<td rowspan="2">
					Item #
				</td>
				<td rowspan="2">
					<?php xl('Date Instructed','e');?>
				</td>
				<td colspan="2">
					<?php xl('Teaching Materials','e');?>
				</td>
				<td rowspan="2">
					<?php xl('Action Plan','e');?> <input type="checkbox" name="home_environment_see_additional_page" value="<?php xl('See additional page for continued plan','e');?>"><?php xl('See additional page for continued plan','e');?>
				</td>
			</tr>
			<tr>
				<td>
					<?php xl('Provided','e');?>
				</td>
				<td>
					<?php xl('Instructed','e');?>
				</td>
			</tr>
			
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<?php xl("Check all items that need to be obtained to improve the safety of the patient's environment","e");?>
		</td>
	</tr>
	<tr>
		<td colspan="5">
		<table border="1px" class="formtable" width="100%">
			<tr>
				<td width="33%">
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('3 in 1 Commode','e');?>"><?php xl('3 in 1 Commode','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('First Aid Kit','e');?>"><?php xl('First Aid Kit','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Cabinet latches','e');?>"><?php xl('Cabinet latches','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Front Wheeled Walker','e');?>"><?php xl('Front Wheeled Walker','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Grab bar','e');?>"><?php xl('Grab bar','e');?></label> #<input type="text" name="home_environment_improve_safety_grab_bar" value="">
				</td>
				<td width="33%">
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Ipecac syrup','e');?>"><?php xl('Ipecac syrup','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Lifeline or other personal safety alarms Plug covers','e');?>"><?php xl('Lifeline or other personal safety alarms Plug covers','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Non-skid surface (bath)','e');?>"><?php xl('Non-skid surface (bath)','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Raised Toilet Seat','e');?>"><?php xl('Raised Toilet Seat','e');?></label>
					
				</td>
				<td>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Tub seat','e');?>"><?php xl('Tub seat','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Smoke Alarm','e');?>"><?php xl('Smoke Alarm','e');?></label> #<input type="text" name="home_environment_improve_safety_smoke_alarm" value=""><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Wheelchair','e');?>"><?php xl('Wheelchair','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Window locks','e');?>"><?php xl('Window locks','e');?></label><br>
					<?php xl('Other:','e');?><input type="text" name="home_environment_improve_safety_other" style="width:80%" value="">
				</td>
				
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<?php xl('Emergency preparedness plan discussed with/provided to patient?','e');?>
			<label><input type="checkbox" name="home_environment_emergency" value="<?php xl('Yes','e');?>"><?php xl('Yes','e');?></label>
			<label><input type="checkbox" name="home_environment_emergency" value="<?php xl('No','e');?>"><?php xl('No','e');?></label>
			<?php xl(', explain:','e');?><input type="text" name="home_environment_emergency_explain" style="width:20%" value=""><br>
			<?php xl('Person/Title Completing Evaluation','e');?>&nbsp;<input type="text" name="home_environment_person_title" style="width:20%" value="">
				<?php xl('Date:','e');?>
					<input type='text' size='10' name='home_environment_person_title_date' id='home_environment_person_title_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date19' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"home_environment_person_title_date", ifFormat:"%Y-%m-%d", button:"img_curr_date19"});
					</script>
					<br>
			<?php xl('I have been instructed on the safety issues in my home','e');?><br>
			<?php xl('Patient/Caregiver Signature','e');?>&nbsp;<input type="text" name="home_environment_patient_sig" style="width:20%" value="">
				<?php xl('Date:','e');?>
					<input type='text' size='10' name='home_environment_patient_sig_date' id='home_environment_patient_sig_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date20' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"home_environment_patient_sig_date", ifFormat:"%Y-%m-%d", button:"img_curr_date20"});
					</script>
		</td>
	</tr>

</table>
<a href="javascript:top.restoreSession();document.home_environment.submit();"
class="link_submit"><?php xl(' [Save]','e')?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
</form>

</body>
</html>
