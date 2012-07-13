<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: home_environment");
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
$formTable = "forms_home_environment";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

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
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
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
<script>
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
$obj = formFetch("forms_home_environment", $_GET["id"]);
$home_environment_action_plan_1=explode("#",$obj{"home_environment_action_plan_1"});
$home_environment_action_plan_2=explode("#",$obj{"home_environment_action_plan_2"});
$home_environment_action_plan_3=explode("#",$obj{"home_environment_action_plan_3"});
$home_environment_action_plan_4=explode("#",$obj{"home_environment_action_plan_4"});
$home_environment_action_plan_5=explode("#",$obj{"home_environment_action_plan_5"});
$home_environment_action_plan_6=explode("#",$obj{"home_environment_action_plan_6"});
$home_environment_action_plan_7=explode("#",$obj{"home_environment_action_plan_7"});
$home_environment_action_plan_8=explode("#",$obj{"home_environment_action_plan_8"});
$home_environment_action_plan_9=explode("#",$obj{"home_environment_action_plan_9"});
$home_environment_action_plan_10=explode("#",$obj{"home_environment_action_plan_10"});
$home_environment_action_plan_11=explode("#",$obj{"home_environment_action_plan_11"});
$home_environment_action_plan_12=explode("#",$obj{"home_environment_action_plan_12"});
$home_environment_action_plan_13=explode("#",$obj{"home_environment_action_plan_13"});
$home_environment_action_plan_14=explode("#",$obj{"home_environment_action_plan_14"});
$home_environment_action_plan_15=explode("#",$obj{"home_environment_action_plan_15"});
$home_environment_action_plan_16=explode("#",$obj{"home_environment_action_plan_16"});
$home_environment_action_plan_17=explode("#",$obj{"home_environment_action_plan_17"});
$home_environment_improve_safety=explode("#",$obj{"home_environment_improve_safety"});
?>
<form method="post"
		action="<?php echo $rootdir;?>/forms/home_environment/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="home_environment">
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
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"home_environment_SOC_date"};?>" readonly/> 
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
			<input type="checkbox" name="home_environment_telephone" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_telephone"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_telephone" value="<?php xl('No','e');?>" onchange="appendrow(this,1)" <?php if($obj{"home_environment_telephone"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_telephone" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_telephone"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_gas_electrical" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_gas_electrical"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_gas_electrical" value="<?php xl('No','e');?>" onchange="appendrow(this,2)" <?php if($obj{"home_environment_gas_electrical"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_gas_electrical" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_gas_electrical"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_smoke_alarm_condition" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_smoke_alarm_condition"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_smoke_alarm_condition" value="<?php xl('No','e');?>" onchange="appendrow(this,3)" <?php if($obj{"home_environment_smoke_alarm_condition"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_smoke_alarm_condition" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_smoke_alarm_condition"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_fire_extinguisher" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_fire_extinguisher"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_fire_extinguisher" value="<?php xl('No','e');?>" onchange="appendrow(this,4)" <?php if($obj{"home_environment_fire_extinguisher"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_fire_extinguisher" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_fire_extinguisher"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_outside_exit" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_outside_exit"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_outside_exit" value="<?php xl('No','e');?>" onchange="appendrow(this,5)" <?php if($obj{"home_environment_outside_exit"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_outside_exit" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_outside_exit"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_alternate_exit" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_alternate_exit"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_alternate_exit" value="<?php xl('No','e');?>" onchange="appendrow(this,6)" <?php if($obj{"home_environment_alternate_exit"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_alternate_exit" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_alternate_exit"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_walking_pathway" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_walking_pathway"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_walking_pathway" value="<?php xl('No','e');?>" onchange="appendrow(this,7)" <?php if($obj{"home_environment_walking_pathway"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_walking_pathway" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_walking_pathway"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_stairs" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_stairs"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_stairs" value="<?php xl('No','e');?>" onchange="appendrow(this,8)" <?php if($obj{"home_environment_stairs"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_stairs" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_stairs"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_lighting" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_lighting"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_lighting" value="<?php xl('No','e');?>" onchange="appendrow(this,9)" <?php if($obj{"home_environment_lighting"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_lighting" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_lighting"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_heating" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_heating"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_heating" value="<?php xl('No','e');?>" onchange="appendrow(this,10)" <?php if($obj{"home_environment_heating"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_heating" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_heating"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_medicine" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_medicine"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_medicine" value="<?php xl('No','e');?>" onchange="appendrow(this,11)" <?php if($obj{"home_environment_medicine"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_medicine" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_medicine"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_bathroom" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_bathroom"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_bathroom" value="<?php xl('No','e');?>" onchange="appendrow(this,12)" <?php if($obj{"home_environment_bathroom"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_bathroom" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_bathroom"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_kitchen" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_kitchen"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_kitchen" value="<?php xl('No','e');?>" onchange="appendrow(this,13)" <?php if($obj{"home_environment_kitchen"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_kitchen" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_kitchen"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_eff_oxygen" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_eff_oxygen"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_eff_oxygen" value="<?php xl('No','e');?>" onchange="appendrow(this,14)" <?php if($obj{"home_environment_eff_oxygen"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_eff_oxygen" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_eff_oxygen"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_overall_sanitary" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_overall_sanitary"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_overall_sanitary" value="<?php xl('No','e');?>" onchange="appendrow(this,15)" <?php if($obj{"home_environment_overall_sanitary"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_overall_sanitary" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_overall_sanitary"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_sanitation_plumbing" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_sanitation_plumbing"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_sanitation_plumbing" value="<?php xl('No','e');?>" onchange="appendrow(this,16)" <?php if($obj{"home_environment_sanitation_plumbing"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_sanitation_plumbing" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_sanitation_plumbing"}=="N/A"){echo "checked";};?> >
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
			<input type="checkbox" name="home_environment_other" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_other"}=="Yes"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_other" value="<?php xl('No','e');?>" onchange="appendrow(this,17)" <?php if($obj{"home_environment_other"}=="No"){echo "checked";};?> >
		</td>
		<td>
			<input type="checkbox" name="home_environment_other" value="<?php xl('N/A','e');?>" <?php if($obj{"home_environment_other"}=="N/A"){echo "checked";};?> >
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
					<?php xl('Action Plan','e');?> <input type="checkbox" name="home_environment_see_additional_page" value="<?php xl('See additional page for continued plan','e');?>" <?php if($obj{"home_environment_see_additional_page"}=="See additional page for continued plan"){echo "checked";};?> ><?php xl('See additional page for continued plan','e');?>
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
			<?php
			for($i=1;$i<=17;$i++)
			{
			$temp="home_environment_action_plan_".$i;
			if(${$temp}[0]!="")
			{
			?>
			<tr id="home_environment_action_plan_<?php echo ${$temp}[0];?>">
				<td>
					<input type="text" name="home_environment_action_plan_<?php echo ${$temp}[0];?>[]" value="<?php echo ${$temp}[0];?>" readonly>
				</td>
				<td>
					<input type="text" name="home_environment_action_plan_<?php echo ${$temp}[0];?>[]" value="<?php echo ${$temp}[1];?>">
				</td>
				<td>
					<input type="text" name="home_environment_action_plan_<?php echo ${$temp}[0];?>[]" value="<?php echo ${$temp}[2];?>">
				</td>
				<td>
					<input type="text" name="home_environment_action_plan_<?php echo ${$temp}[0];?>[]" value="<?php echo ${$temp}[3];?>">
				</td>
				<td>
					<input type="text" name="home_environment_action_plan_<?php echo ${$temp}[0];?>[]" value="<?php echo ${$temp}[4];?>">
				</td>
			</tr>
			<?
			}
			}
			?>
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
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('3 in 1 Commode','e');?>" <?php if(in_array("3 in 1 Commode",$home_environment_improve_safety)) echo "checked"; ?> ><?php xl('3 in 1 Commode','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('First Aid Kit','e');?>" <?php if(in_array("First Aid Kit",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('First Aid Kit','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Cabinet latches','e');?>" <?php if(in_array("Cabinet latches",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Cabinet latches','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Front Wheeled Walker','e');?>" <?php if(in_array("Front Wheeled Walker",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Front Wheeled Walker','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Grab bar','e');?>" <?php if(in_array("Grab bar",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Grab bar','e');?></label> #<input type="text" name="home_environment_improve_safety_grab_bar" value="<?php echo $obj{"home_environment_improve_safety_grab_bar"};?>">
				</td>
				<td width="33%">
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Ipecac syrup','e');?>" <?php if(in_array("Ipecac syrup",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Ipecac syrup','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Lifeline or other personal safety alarms Plug covers','e');?>" <?php if(in_array("Lifeline or other personal safety alarms Plug covers",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Lifeline or other personal safety alarms Plug covers','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Non-skid surface (bath)','e');?>" <?php if(in_array("Non-skid surface (bath)",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Non-skid surface (bath)','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Raised Toilet Seat','e');?>" <?php if(in_array("Raised Toilet Seat",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Raised Toilet Seat','e');?></label>
					
				</td>
				<td>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Tub seat','e');?>" <?php if(in_array("Tub seat",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Tub seat','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Smoke Alarm','e');?>" <?php if(in_array("Smoke Alarm",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Smoke Alarm','e');?></label> #<input type="text" name="home_environment_improve_safety_smoke_alarm" value="<?php echo $obj{"home_environment_improve_safety_smoke_alarm"};?>"><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Wheelchair','e');?>" <?php if(in_array("Wheelchair",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Wheelchair','e');?></label><br>
					<label><input type="checkbox" name="home_environment_improve_safety[]" value="<?php xl('Window locks','e');?>" <?php if(in_array("Window locks",$home_environment_improve_safety)) echo "checked"; ?>><?php xl('Window locks','e');?></label><br>
					<?php xl('Other:','e');?><input type="text" name="home_environment_improve_safety_other" style="width:80%" value="<?php echo $obj{"home_environment_improve_safety_other"};?>">
				</td>
				
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<?php xl('Emergency preparedness plan discussed with/provided to patient?','e');?>
			<label><input type="checkbox" name="home_environment_emergency" value="<?php xl('Yes','e');?>" <?php if($obj{"home_environment_emergency"}=="Yes"){echo "checked";};?> ><?php xl('Yes','e');?></label>
			<label><input type="checkbox" name="home_environment_emergency" value="<?php xl('No','e');?>" <?php if($obj{"home_environment_emergency"}=="No"){echo "checked";};?> ><?php xl('No','e');?></label>
			<?php xl(', explain:','e');?><input type="text" name="home_environment_emergency_explain" style="width:20%" value="<?php echo $obj{"home_environment_emergency_explain"};?>"><br>
			<?php xl('Person/Title Completing Evaluation','e');?>&nbsp;<input type="text" name="home_environment_person_title" style="width:20%" value="<?php echo $obj{"home_environment_person_title"};?>">
				<?php xl('Date:','e');?>
					<input type='text' size='10' name='home_environment_person_title_date' id='home_environment_person_title_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"home_environment_person_title_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date19' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"home_environment_person_title_date", ifFormat:"%Y-%m-%d", button:"img_curr_date19"});
					</script>
					<br>
			<?php xl('I have been instructed on the safety issues in my home','e');?><br>
			<?php xl('Patient/Caregiver Signature','e');?>&nbsp;<input type="text" name="home_environment_patient_sig" style="width:20%" value="<?php echo $obj{"home_environment_patient_sig"};?>">
				<?php xl('Date:','e');?>
					<input type='text' size='10' name='home_environment_patient_sig_date' id='home_environment_patient_sig_date' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"home_environment_patient_sig_date"};?>" readonly/> 
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
