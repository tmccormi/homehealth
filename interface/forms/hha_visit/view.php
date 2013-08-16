<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
include_once("$srcdir/api.inc");



$obj = formFetch("forms_hha_visit", $_GET["id"]);


$hha_visit_activities = explode("#",$obj{"hha_visit_activities"});


// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"|| strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";
    
$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_hha_visit";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

?>

<html><head>
<?php html_header_show();?>
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
	<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
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
include_once("$srcdir/api.inc");
$obj = formFetch("forms_hha_visit", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

?>



<form method="post" action="<?php echo $rootdir;?>/forms/hha_visit/save.php?mode=update&&id=<?php echo $_GET['id']; ?>" name="hha_visit">
<h3 align="center"><?php xl('HHA VISIT NOTE','e') ?></h3>

<table class="formtable" width="100%" border="0">
<TR valign="top">
<TD>
<b><?php xl('Patient:','e') ?></b>
<input type="text" name="hha_visit_patient_name" size="30" value="<?php patientName(); ?>" readonly  /><br />
</TD>
<TD align="right">

<b><?php xl('Caregiver:','e') ?></b>
<input type="text" name="hha_visit_caregiver_name" size="30" 
value="<?php echo $obj{"hha_visit_caregiver_name"}; ?>"  />

<strong><?php xl('Start of Care Date:','e') ?></strong>
<input type="text" name="hha_visit_date" id="hha_visit_date" size="12" value="<?php echo $obj{"hha_visit_date"}; ?>"  readonly/><br />

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"hha_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>

<b><?php xl('Time In:','e') ?></b>
<select name="hha_visit_time_in" id="hha_visit_time_in">
<?php timeDropDown(stripslashes($obj{"hha_visit_time_in"}))?>
</select>

<b><?php xl('Time Out:','e') ?></b>
<select name="hha_visit_time_out" id="hha_visit_time_out">
<?php timeDropDown(stripslashes($obj{"hha_visit_time_out"}))?>
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
<input type="text" name="hha_visit_employee_name" size="10" value="<?php echo $obj{"hha_visit_employee_name"}; ?>"  /> </label><br />
<label><b><?php xl('EMPLOYEE NO:','e')?></b>
<input type="text" name="hha_visit_employee_no" size="10" value="<?php echo $obj{"hha_visit_employee_no"}; ?>"  /> </label>
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
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Bath - Tub/Shower','e')?>" 
 <?php if(in_array("Bath - Tub/Shower",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Bath - Tub/Shower','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_bath" size="50%" value="<?php echo $obj{"hha_visit_bath"}; ?>"  />
<?php echo goals_date('hha_visit_bath_date',$obj{"hha_visit_bath_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Bed Bath - Partial/Complete','e')?>" 
 <?php if(in_array("Bed Bath - Partial/Complete",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Bed Bath - Partial/Complete','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_bed_bath" size="50%" value="<?php echo $obj{"hha_visit_bed_bath"}; ?>"  />
<?php echo goals_date('hha_visit_bed_bath_date',$obj{"hha_visit_bed_bath_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Assist Bath - Chair','e')?>" 
 <?php if(in_array("Assist Bath - Chair",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Assist Bath - Chair','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_assist_bath" size="50%" value="<?php echo $obj{"hha_visit_assist_bath"}; ?>"  />
<?php echo goals_date('hha_visit_assist_bath_date',$obj{"hha_visit_assist_bath_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Personal Care','e')?>" 
 <?php if(in_array("Personal Care",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Personal Care','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_personal_care" size="50%" value="<?php echo $obj{"hha_visit_personal_care"}; ?>"  />
<?php echo goals_date('hha_visit_personal_care_date',$obj{"hha_visit_personal_care_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Assist with dressing','e')?>" 
 <?php if(in_array("Assist with dressing",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Assist with dressing','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_assist_with_dressing" size="50%" value="<?php echo $obj{"hha_visit_assist_with_dressing"}; ?>"  />
<?php echo goals_date('hha_visit_assist_with_dressing_date',$obj{"hha_visit_assist_with_dressing_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Hair care - brush/shampoo/other','e')?>" 
 <?php if(in_array("Hair care - brush/shampoo/other",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Hair care - brush/shampoo/other','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_hair_care" size="50%" value="<?php echo $obj{"hha_visit_hair_care"}; ?>"  />
<?php echo goals_date('hha_visit_hair_care_date',$obj{"hha_visit_hair_care_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Skin Care/Foot Care (Hygiene)','e')?>" 
 <?php if(in_array("Skin Care/Foot Care (Hygiene)",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Skin Care/Foot Care (Hygiene)','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_skin_care" size="50%" value="<?php echo $obj{"hha_visit_skin_care"}; ?>"  />
<?php echo goals_date('hha_visit_skin_care_date',$obj{"hha_visit_skin_care_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Check pressure areas','e')?>" 
 <?php if(in_array("Skin Care/Foot Care (Hygiene)",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Check pressure areas','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_check_pressure_areas" size="50%" value="<?php echo $obj{"hha_visit_check_pressure_areas"}; ?>"  />
<?php echo goals_date('hha_visit_check_pressure_areas_date',$obj{"hha_visit_check_pressure_areas_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Shave/Groom/Deodorant','e')?>" 
 <?php if(in_array("Shave/Groom/Deodorant",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Shave/Groom/Deodorant','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_shave_groom" size="50%" value="<?php echo $obj{"hha_visit_shave_groom"}; ?>"  />
<?php echo goals_date('hha_visit_shave_groom_date',$obj{"hha_visit_shave_groom_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Nail Hygiene - clean/file/report','e')?>" 
 <?php if(in_array("Nail Hygiene - clean/file/report",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Nail Hygiene - clean/file/report','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_nail_hygiene" size="50%" value="<?php echo $obj{"hha_visit_nail_hygiene"}; ?>"  />
<?php echo goals_date('hha_visit_nail_hygiene_date',$obj{"hha_visit_nail_hygiene_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Oral Care - brush/swab/dentures','e')?>" 
 <?php if(in_array("Oral Care - brush/swab/dentures",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Oral Care - brush/swab/dentures','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_oral_care" size="50%" value="<?php echo $obj{"hha_visit_oral_care"}; ?>"  />
<?php echo goals_date('hha_visit_oral_care_date',$obj{"hha_visit_oral_care_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Elimination Assist','e')?>" 
 <?php if(in_array("Elimination Assist",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Elimination Assist','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_elimination_assist" size="50%" value="<?php echo $obj{"hha_visit_elimination_assist"}; ?>"  />
<?php echo goals_date('hha_visit_elimination_assist_date',$obj{"hha_visit_elimination_assist_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Catheter Care','e')?>" 
 <?php if(in_array("Catheter Care",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Catheter Care','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_catheter_care" size="50%" value="<?php echo $obj{"hha_visit_catheter_care"}; ?>"  />
<?php echo goals_date('hha_visit_catheter_care_date',$obj{"hha_visit_catheter_care_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Ostomy Care','e')?>" 
 <?php if(in_array("Ostomy Care",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Ostomy Care','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_ostomy_care" size="50%" value="<?php echo $obj{"hha_visit_ostomy_care"}; ?>"  />
<?php echo goals_date('hha_visit_ostomy_care_date',$obj{"hha_visit_ostomy_care_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Record Output/Input','e')?>" 
 <?php if(in_array("Record Output/Input",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Record Output/Input','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_record" size="50%" value="<?php echo $obj{"hha_visit_record"}; ?>"  />
<?php echo goals_date('hha_visit_record_date',$obj{"hha_visit_record_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Inspect/Reinforce Dressing','e')?>" 
 <?php if(in_array("Inspect/Reinforce Dressing",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Inspect/Reinforce Dressing','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_inspect_reinforce" size="50%" value="<?php echo $obj{"hha_visit_inspect_reinforce"}; ?>"  />
<?php echo goals_date('hha_visit_inspect_reinforce_date',$obj{"hha_visit_inspect_reinforce_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Assist with Medications','e')?>" 
 <?php if(in_array("Assist with Medications",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Assist with Medications','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_assist_with_medications" size="50%" value="<?php echo $obj{"hha_visit_assist_with_medications"}; ?>"  />
<?php echo goals_date('hha_visit_assist_with_medications_date',$obj{"hha_visit_assist_with_medications_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('T - Oral/Axillary/Rectal','e')?>" 
 <?php if(in_array("T - Oral/Axillary/Rectal",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('T - Oral/Axillary/Rectal','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_T" size="50%" value="<?php echo $obj{"hha_visit_T"}; ?>"  />
<?php echo goals_date('hha_visit_T_date',$obj{"hha_visit_T_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Pulse - Site and Result','e')?>" 
 <?php if(in_array("Pulse - Site and Result",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Pulse - Site and Result','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_pulse" size="50%" value="<?php echo $obj{"hha_visit_pulse"}; ?>"  />
<?php echo goals_date('hha_visit_pulse_date',$obj{"hha_visit_pulse_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Respirations - Results','e')?>" 
 <?php if(in_array("Respirations - Results",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Respirations - Results','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_respirations" size="50%" value="<?php echo $obj{"hha_visit_respirations"}; ?>"  />
<?php echo goals_date('hha_visit_respirations_date',$obj{"hha_visit_respirations_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('BP - Site and Results','e')?>" 
 <?php if(in_array("BP - Site and Results",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('BP - Site and Results','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_BP" size="50%" value="<?php echo $obj{"hha_visit_BP"}; ?>"  />
<?php echo goals_date('hha_visit_BP_date',$obj{"hha_visit_BP_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Weight - Results','e')?>" 
 <?php if(in_array("Weight - Results",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Weight - Results','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_weight" size="50%" value="<?php echo $obj{"hha_visit_weight"}; ?>"  />
<?php echo goals_date('hha_visit_weight_date',$obj{"hha_visit_weight_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Ambulation Assist - WC/Walker/Cane','e')?>" 
 <?php if(in_array("Ambulation Assist - WC/Walker/Cane",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Ambulation Assist - WC/Walker/Cane','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_ambulation_assist" size="50%" value="<?php echo $obj{"hha_visit_ambulation_assist"}; ?>"  />
<?php echo goals_date('hha_visit_ambulation_assist_date',$obj{"hha_visit_ambulation_assist_date"}); ?>
</TD>
</TR>

<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Mobility Assist','e')?>" 
 <?php if(in_array("Mobility Assist",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Mobility Assist','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_mobility_assist" size="50%" value="<?php echo $obj{"hha_visit_mobility_assist"}; ?>"  />
<?php echo goals_date('hha_visit_mobility_assist_date',$obj{"hha_visit_mobility_assist_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('ROM - Active/Passive','e')?>" 
 <?php if(in_array("ROM - Active/Passive",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('ROM - Active/Passive','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_ROM" size="50%" value="<?php echo $obj{"hha_visit_ROM"}; ?>"  />
<?php echo goals_date('hha_visit_ROM_date',$obj{"hha_visit_ROM_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Positioning - Encourage/Assist to turn q hrs','e')?>" 
 <?php if(in_array("Positioning - Encourage/Assist to turn q hrs",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Positioning - Encourage/Assist to turn q hrs','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_positioning" size="50%" value="<?php echo $obj{"hha_visit_positioning"}; ?>"  />
<?php echo goals_date('hha_visit_positioning_date',$obj{"hha_visit_positioning_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Exercise - per PT/OT/SLP Care Plan','e')?>" 
 <?php if(in_array("Exercise - per PT/OT/SLP Care Plan",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Exercise - per PT/OT/SLP Care Plan','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_exercise" size="50%" value="<?php echo $obj{"hha_visit_exercise"}; ?>"  />
<?php echo goals_date('hha_visit_exercise_date',$obj{"hha_visit_exercise_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30"><label>
<input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Diet Order','e')?>" 
 <?php if(in_array("Diet Order",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Diet Order:','e')?> </label>
<input type="text" name="hha_visit_diet_order1" size="30%" value="<?php echo $obj{"hha_visit_diet_order1"}; ?>"  />
</TD>
<TD>
<input type="text" name="hha_visit_diet_order" size="50%" value="<?php echo $obj{"hha_visit_diet_order"}; ?>"  />
<?php echo goals_date('hha_visit_diet_order_date',$obj{"hha_visit_diet_order_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Meal Preparation','e')?>" 
 <?php if(in_array("Meal Preparation",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Meal Preparation','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_meal_preparation" size="50%" value="<?php echo $obj{"hha_visit_meal_preparation"}; ?>"  />
<?php echo goals_date('hha_visit_meal_preparation_date',$obj{"hha_visit_meal_preparation_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Assist with Feeding','e')?>" 
 <?php if(in_array("Assist with Feeding",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Assist with Feeding','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_assist_with_feeding" size="50%" value="<?php echo $obj{"hha_visit_assist_with_feeding"}; ?>"  />
<?php echo goals_date('hha_visit_assist_with_feeding_date',$obj{"hha_visit_assist_with_feeding_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Limit/Encourage Fluids','e')?>" 
 <?php if(in_array("Limit/Encourage Fluids",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Limit/Encourage Fluids','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_limit_encourage_fluids" size="50%" value="<?php echo $obj{"hha_visit_limit_encourage_fluids"}; ?>"  />
<?php echo goals_date('hha_visit_limit_encourage_fluids_date',$obj{"hha_visit_limit_encourage_fluids_date"}); ?>
</TD>
</TR>



<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Grocery Shopping','e')?>" 
 <?php if(in_array("Grocery Shopping",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Grocery Shopping','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_grocery_shopping" size="50%" value="<?php echo $obj{"hha_visit_grocery_shopping"}; ?>"  />
<?php echo goals_date('hha_visit_grocery_shopping_date',$obj{"hha_visit_grocery_shopping_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Wash Clothes','e')?>" 
 <?php if(in_array("Wash Clothes",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Wash Clothes','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_wash_clothes" size="50%" value="<?php echo $obj{"hha_visit_wash_clothes"}; ?>"  />
<?php echo goals_date('hha_visit_wash_clothes_date',$obj{"hha_visit_wash_clothes_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Light HouseKeeping - Bedroom/Bathroom/Kitchen - Change bed linen','e')?>" 
 <?php if(in_array("Light HouseKeeping - Bedroom/Bathroom/Kitchen - Change bed linen",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Light HouseKeeping - Bedroom/Bathroom/Kitchen - Change bed linen','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_light_housekeeping" size="50%" value="<?php echo $obj{"hha_visit_light_housekeeping"}; ?>"  />
<?php echo goals_date('hha_visit_light_housekeeping_date',$obj{"hha_visit_light_housekeeping_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Observe Universal Precautions','e')?>" 
 <?php if(in_array("Observe Universal Precautions",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Observe Universal Precautions','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_observe_universal_precaution" size="50%" value="<?php echo $obj{"hha_visit_observe_universal_precaution"}; ?>"  />
<?php echo goals_date('hha_visit_observe_universal_precaution_date',$obj{"hha_visit_observe_universal_precaution_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Equipment Care','e')?>" 
 <?php if(in_array("Equipment Care",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Equipment Care','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_equipment_care" size="50%" value="<?php echo $obj{"hha_visit_equipment_care"}; ?>"  />
<?php echo goals_date('hha_visit_equipment_care_date',$obj{"hha_visit_equipment_care_date"}); ?>
</TD>
</TR>


<tr>
<TD width="30">
<label> <input type="checkbox" name="hha_visit_activities[]" value="<?php xl('Washing hands before and after services','e')?>" 
 <?php if(in_array("Washing hands before and after services",$hha_visit_activities)) echo "checked"; ?> />
<?php xl('Washing hands before and after services','e')?> </label></TD>
<TD>
<input type="text" name="hha_visit_washing_hands" size="50%" value="<?php echo $obj{"hha_visit_washing_hands"}; ?>"  />
<?php echo goals_date('hha_visit_washing_hands_date',$obj{"hha_visit_washing_hands_date"}); ?>
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
<input type="text" name="hha_visit_patient_client_sign" size="50%"  value="<?php echo $obj{"hha_visit_patient_client_sign"}; ?>"  />
</TD>
<td rowspan="2">
<b><?php xl('Date','e')?></b>
<input type='text' size='10' name='hha_visit_patient_client_sign_date' id='hha_visit_patient_client_sign_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' 
 			value="<?php echo $obj{"hha_visit_patient_client_sign_date"}; ?>"  readonly/>
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
<?php xl('Supplies Used','e')?>
<label><input type="radio" name="hha_visit_supplies_used" value="Yes"  id="hha_visit_supplies_used" 
<?php if($obj{"hha_visit_supplies_used"}=="Yes") echo "checked"; ?> /> <?php xl('Yes','e')?></label>
<label><input type="radio" name="hha_visit_supplies_used" value="No"  id="hha_visit_supplies_used" 
<?php if($obj{"hha_visit_supplies_used"}=="No") echo "checked"; ?> /> <?php xl('No','e')?></label>
<br />
<textarea name="hha_visit_supplies_used_data" rows="4" cols="98">
<?php echo $obj{"hha_visit_supplies_used_data"}; ?>
</textarea>
</TD>
</tr>


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


<center>
        <table>
            <tr>
                <td align="center">
                    <?php if($action == "edit") { ?>
                    <input type="submit" name="Submit" value="Save Form" > &nbsp;&nbsp;
                    <? } ?>
                    </form>
                    <input type="button" value="Back" onClick="top.restoreSession();window.location='<?php echo $GLOBALS['webroot'] ?>/interface/patient_file/encounter/encounter_top.php';"/>&nbsp;&nbsp;
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

	
