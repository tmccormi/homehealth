<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
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
$formTable = "forms_nursing_careplan";

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
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>//library/js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<style type="text/css">
.bold {
	font-weight: bold;
}
table label, input { display:inherit !important; }

</style>
<script type="text/javascript">
$.noConflict();
  jQuery(document).ready(function($) {
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
$obj = formFetch("forms_nursing_careplan", $_GET["id"]);
$cardio_teach = explode("#",$obj{"careplan_SN_CARDIO_Teach"});
$cardio_pcg_goals = explode("#",$obj{"careplan_SN_CARDIO_PtPcgGoals"});
$endo_assess = explode("#",$obj{"careplan_SN_ENDO_Assess"});
$endo_teach = explode("#",$obj{"careplan_SN_ENDO_Teach"});
$endo_perform = explode("#",$obj{"careplan_SN_ENDO_Perform"});
$endo_pcggoals = explode("#",$obj{"careplan_SN_ENDO_PCgGoals"});
$gastro_teach = explode("#",$obj{"careplan_SN_GASTRO_Teach"});
$gastro_perform = explode("#",$obj{"careplan_SN_GASTRO_Perform"});
$gastro_pcgoals = explode("#",$obj{"careplan_SN_GASTRO_PcGoals"});
$genito_teach = explode("#",$obj{"careplan_SN_GENITO_Teach"});
$genito_perform = explode("#",$obj{"careplan_SN_GENITO_Perform"});
$genito_pcggoals = explode("#",$obj{"careplan_SN_GENITO_PcgGoals"});
$integu_pcggoals = explode("#",$obj{"careplan_SN_INTEGU_PcgGoals"});
$musculo_pcggoals = explode("#",$obj{"careplan_SN_MUSCULO_PcgGoals"});
$mental_pcggoals = explode("#",$obj{"careplan_SN_MENTAL_PcgGoals"});
$neuro_assess = explode("#",$obj{"careplan_SN_NEURO_Assess"});
$neuro_pcggoals = explode("#",$obj{"careplan_SN_NEURO_PcgGoals"});
$respir_pcggoals = explode("#",$obj{"careplan_SN_RESPIR_PcgGoals"});
$general_pcggoals = explode("#",$obj{"careplan_SN_GENERAL_PcgGoals"});
$wound_label = explode("#",$obj{"wound_label"});
$wound_label2 = explode("#",$obj{"wound_label2"});
$wound_value1 = explode("#",$obj{"wound_value1"});
$wound_value2 = explode("#",$obj{"wound_value2"});
$wound_value3 = explode("#",$obj{"wound_value3"});
$wound_value4 = explode("#",$obj{"wound_value4"});
$wound_value5 = explode("#",$obj{"wound_value5"});
$wound_value6 = explode("#",$obj{"wound_value6"});
$wound_value7 = explode("#",$obj{"wound_value7"});
$wound_value8 = explode("#",$obj{"wound_value8"});
$wound_comments = explode("#",$obj{"wound_comments"});
$Interventions = explode("#",$obj{"Interventions"});


?>

<form method="post" id="submitForm" 
		action="<?php echo $rootdir;?>/forms/nursing_careplan/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="nursing_careplan" onsubmit="return top.restoreSession();" enctype="multipart/form-data">
		<h3 align="center"> <?php xl('SKILLED NURSING CARE PLAN','e')?> </h3>
	      <h5 align="center">
		<?php xl('(Information from this form populates the Plan of Care/485)','e'); ?>
		</h5>
<table width="100%" border="1" class="formtable">
<tr><td>
<table width="100%"  align="center"  border="1px" cellspacing="0px" cellpadding="0px" >
   <tr>

        <td width="19%" align="center" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
        <td width="30%" align="left">&nbsp;<input type="text" style="width:70%"
				 id="patient_name" value="<?php patientName()?>"
				readonly/></td>
        <td width="10%" align="center"><strong><?php xl('Certification/Recertification Period','e')?></strong></td>
        <td width="10%" align="center" class="bold">&nbsp;</td>
					
       </tr>
</table>
</td>
  </tr>
  
   <tr>
    <td scope="row"><strong>
        <?php xl('SN To Assess Vital Signs','e')?></strong>&nbsp;&nbsp;
		<?php xl('( The Parameters chosen in this section should populate every nursing visit note and therapy note for that patient )','e')?>
		<br>
		<strong><?php xl('Contact MD if Vital Signs are:','e')?></strong>
		<?php
			$vital_signs = array("Pulse <56 or >120","Temperature <56 or >101","Respirations <10 or >30","SBP <80 or >190","DBP <50 or >100","Pain Significantly Impacts patients ability to participate","O2 Sat <90% after 2 minute rest","If parameters are different from above specify");
			
			foreach($vital_signs as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_Assess_Vital_Signs"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_Assess_Vital_Signs[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
		<input type="text" style="width:78%" name="careplan_Assess_Vital_Signs_Specify" id="careplan_Assess_Vital_Signs_Specify" value="<?php echo stripslashes($obj{"careplan_Assess_Vital_Signs_Specify"});?>" />
				
		</td>

  </tr>
   <tr>
  <td><strong>
   <?php xl('SN to Perform skilled assessment, management and education of all organ systems with emphasis on the following','e')?></strong><br>
   <?php 
        $skilled_asses = array("Cardiovascular","Endocrine","Gastrointestinal","Genitourinary","Integumentary","Mental/Emotional","Musculoskeletal/Mobility","Neurological","Respiratory","General Medical");
        foreach($skilled_asses as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_Skilled_Assessment"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_Skilled_Assessment[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?> <br>
   <?php xl('Other','e')?>&nbsp;
   <input type="text" style="width:93%" name="careplan_SN_Skilled_Assessment_Other" id="careplan_SN_Skilled_Assessment_Other" value="<?php echo stripslashes($obj{"careplan_SN_Skilled_Assessment_Other"});?>"/>
   </td></tr>
   <tr><td align="left">
    <strong><?php xl('SYSTEMS INTERVENTION GOALS: (Check all that apply)','e')?></strong>
     </td></tr>
	 <tr><td align="center">
	 <strong><?php xl('CARDIOVASCULAR','e')?></strong>
	 </td></tr>
  
	 <tr><td>
	 <strong><u><?php xl('SN TO ASSESS FOR','e')?></u></strong> &nbsp;
	 
	 <?php 
        $cardio_asses = array("Purpose, dose, frequency and SE of medications","Barriers to compliance","Orthostatic hyper/hypo tension","SOB","Cough","JVD/heptojugular reflex",
		"Peripheral pulses","Abnormal Lung Sounds","Weight","gain","loss","Abnormal Heart Sounds","Chest Pain","Edema/Fluid Retention","Neck/Vein Distention","Peripheral Pulses","Use of incentive spirometer");
        foreach($cardio_asses as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_CARDIO_Assess"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_CARDIO_Assess[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	<br><?php xl('Other','e')?>&nbsp;
   <input type="text" style="width:93%" name="careplan_SN_CARDIO_Assess_Other" id="careplan_SN_CARDIO_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_CARDIO_Assess_Other"});?>"/>
	 </td></tr>
	 
	 <tr><td>
	 <strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Fluid detection" <?php if (in_array("Fluid detection",$cardio_teach)) echo "checked";?>/><?php xl('Fluid detection','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Fluid restriction to" <?php if (in_array("Fluid restriction to",$cardio_teach)) echo "checked";?>/><?php xl('Fluid restriction to','e')?>&nbsp;
	 <input type="text" style="width:8%" name="careplan_SN_CARDIO_Teach_Fluid" id="careplan_SN_CARDIO_Teach_Fluid" value="<?php echo stripslashes($obj{"careplan_SN_CARDIO_Teach_Fluid"});?>" />
	 <?php xl('cc/day','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
	 <?php xl('Self monitoring of vital signs including','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Blood Pressure" <?php if (in_array("Blood Pressure",$cardio_teach)) echo "checked";?>/><?php xl('Blood Pressure','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Pulse" <?php if (in_array("Pulse",$cardio_teach)) echo "checked";?>/><?php xl('Pulse','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Weights" <?php if (in_array("Weights",$cardio_teach)) echo "checked";?>/><?php xl('Weights','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="S/Sxs of disease process" <?php if (in_array("S/Sxs of disease process",$cardio_teach)) echo "checked";?>/><?php xl('S/Sxs of disease process','e')?>&nbsp;
	 <?php xl(', including management, controlling risk factors and identification of complications of','e')?>&nbsp;
	 <input type="text" style="width:20%" name="careplan_SN_CARDIO_Teach_Complications" id="careplan_SN_CARDIO_Teach_Complications" value="<?php echo stripslashes($obj{"careplan_SN_CARDIO_Teach_Complications"});?>"/>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Benefits of lifestyle change including exercise, nutrition, and/or energy conservation" <?php if (in_array("Benefits of lifestyle change including exercise, nutrition, and/or energy conservation",$cardio_teach)) echo "checked";?>/><?php xl('Benefits of lifestyle change including exercise, nutrition, and/or energy conservation.','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Avoid straining" <?php if (in_array("Avoid straining",$cardio_teach)) echo "checked";?> /><?php xl('Avoid straining','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Avoid lifting > 10 lbs" <?php if (in_array("Avoid lifting > 10 lbs",$cardio_teach)) echo "checked";?>/><?php xl('Avoid lifting > 10 lbs','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Slow posture changes" <?php if (in_array("Slow posture changes",$cardio_teach)) echo "checked";?>/><?php xl('Slow posture changes','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Care of edematous extremities" <?php if (in_array("Care of edematous extremities",$cardio_teach)) echo "checked";?>/><?php xl('Care of edematous extremities','e')?>&nbsp;
	 <?php xl('Other','e')?>&nbsp;
     <input type="text" style="width:44%" name="careplan_SN_CARDIO_Teach_Other" id="careplan_SN_CARDIO_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_CARDIO_Teach_Other"});?>"/>
	 </td></tr>
	 
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_CARDIO_PtPcgGoals[]"  value="Demonstrate and verbalize and understanding about cardiovascular disease management by" <?php if (in_array("Demonstrate and verbalize and understanding about cardiovascular disease management by",$cardio_pcg_goals)) echo "checked";?>/><?php xl('Demonstrate and verbalize and understanding about cardiovascular disease management by','e')?>&nbsp;
	<?php echo goals_date('cardi0_cal1',$obj{"cardi0_cal1"}); ?>
	<br>
	<input type="checkbox" name="careplan_SN_CARDIO_PtPcgGoals[]"  value="Weigh q day and record by" <?php if (in_array("Weigh q day and record by",$cardio_pcg_goals)) echo "checked";?>/><?php xl('Weigh q day and record by','e')?>&nbsp;
	<?php echo goals_date('cardi0_cal2',$obj{"cardi0_cal2"}); ?>
	&nbsp;
	<input type="checkbox" name="careplan_SN_CARDIO_PtPcgGoals[]"  value="Verbalize understanding of benefits of lifestyle change including exercise, nutrition and/or energy conservation by" <?php if (in_array("Verbalize understanding of benefits of lifestyle change including exercise, nutrition and/or energy conservation by",$cardio_pcg_goals)) echo "checked";?>/><?php xl('Verbalize understanding of benefits of lifestyle change including exercise, nutrition and/or energy conservation by','e')?>&nbsp;
	<?php echo goals_date('cardi0_cal3',$obj{"cardi0_cal3"}); ?>
	&nbsp;
	<input type="checkbox" name="careplan_SN_CARDIO_PtPcgGoals[]"  value="Demonstrate understanding of avoiding straining, heavy lifting and/or slow postural changes by" <?php if (in_array("Demonstrate understanding of avoiding straining, heavy lifting and/or slow postural changes by",$cardio_pcg_goals)) echo "checked";?>/><?php xl('Demonstrate understanding of avoiding straining, heavy lifting and/or slow postural changes by','e')?>&nbsp;
	<?php echo goals_date('cardi0_cal4',$obj{"cardi0_cal4"}); ?>
	&nbsp;<?php xl('Other','e')?>&nbsp;
     <input type="text" style="width:68%" name="careplan_SN_CARDIO_PtPcgGoals_Other" id="careplan_SN_CARDIO_PtPcgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_CARDIO_PtPcgGoals_Other"});?>"/>
	 </td></tr>  
	 
	<tr><td align="center">
	<strong><?php xl('ENDOCRINE','e')?></strong>
	</td></tr>
	
		<tr><td>
	<strong><u><?php xl('SN TO ASSESS DIABETIC MANAGEMENT INCLUDING','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Glucometer Check every" <?php if (in_array("Glucometer Check every",$endo_assess)) echo "checked";?>/><?php xl('Glucometer Check every','e')?>&nbsp;
	<input type="text" style="width:8%" name="careplan_SN_ENDO_Assess_Hrs" id="careplan_SN_ENDO_Assess_Hrs" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_Assess_Hrs"});?>"/>
	<?php xl('Hrs','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Hyploglycemia" <?php if (in_array("Hyploglycemia",$endo_assess)) echo "checked";?>/><?php xl('Hyploglycemia','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Hyperglycemia" <?php if (in_array("Hyperglycemia",$endo_assess)) echo "checked";?>/><?php xl('Hyperglycemia','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Diet Compliance" <?php if (in_array("Diet Compliance",$endo_assess)) echo "checked";?>/><?php xl('Diet Compliance','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Insulin Adminitration by" <?php if (in_array("Insulin Adminitration by",$endo_assess)) echo "checked";?>/><?php xl('Insulin Adminitration by','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Self" <?php if (in_array("Self",$endo_assess)) echo "checked";?>/><?php xl('Self','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Caregiver" <?php if (in_array("Caregiver",$endo_assess)) echo "checked";?>/><?php xl('Caregiver','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Nurse" <?php if (in_array("Nurse",$endo_assess)) echo "checked";?>/><?php xl('Nurse','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
    <input type="text" style="width:23%" name="careplan_SN_ENDO_Admin_Other" id="careplan_SN_ENDO_Admin_Other" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_Admin_Other"});?>"/><br>
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Response to therapeutic regimen" <?php if (in_array("Response to therapeutic regimen",$endo_assess)) echo "checked";?>/><?php xl('Response to therapeutic regimen','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Compliance with dietary restrictions" <?php if (in_array("Compliance with dietary restrictions",$endo_assess)) echo "checked";?>/><?php xl('Compliance with dietary restrictions','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Weight loss/gain" <?php if (in_array("Weight loss/gain",$endo_assess)) echo "checked";?>/><?php xl('Weight loss/gain','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Monitoring Blood Sugar Ranges and Frequencies" <?php if (in_array("Monitoring Blood Sugar Ranges and Frequencies",$endo_assess)) echo "checked";?> /><?php xl('Monitoring Blood Sugar Ranges and Frequencies','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="S/Sxs of disease process" <?php if (in_array("S/Sxs of disease process",$endo_assess)) echo "checked";?>/><?php xl('S/Sxs of disease process, including management, controlling risk factors and identification of complications such as','e')?>&nbsp;
	<input type="text" style="width:30%" name="careplan_SN_ENDO_Assess_Suchas" id="careplan_SN_ENDO_Assess_Suchas" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_Assess_Suchas"});?>"/>
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:60%" name="careplan_SN_ENDO_Assess_Other" id="careplan_SN_ENDO_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_Assess_Other"});?>" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Pathophysiology of disease process" <?php if (in_array("Pathophysiology of disease process",$endo_teach)) echo "checked";?> /><?php xl('Pathophysiology of disease process','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Purpose, dose, frequency and SE of medications" <?php if (in_array("Purpose, dose, frequency and SE of medications",$endo_teach)) echo "checked";?> /><?php xl('Purpose, dose, frequency and SE of medications','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Diabetic regimen including" <?php if (in_array("Diabetic regimen including",$endo_teach)) echo "checked";?>/><?php xl('Diabetic regimen including','e')?>&nbsp; 
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Insulin preparation" <?php if (in_array("Insulin preparation",$endo_teach)) echo "checked";?>/><?php xl('Insulin preparation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Insulin injection" <?php if (in_array("Insulin injection",$endo_teach)) echo "checked";?>/><?php xl('Insulin injection','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Blood glucose testing, procedure and interpretation of results" <?php if (in_array("Blood glucose testing, procedure and interpretation of results",$endo_teach)) echo "checked";?>/><?php xl('Blood glucose testing, procedure and interpretation of results','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Diet" <?php if (in_array("Diet",$endo_teach)) echo "checked";?> /><?php xl('Diet','e')?>&nbsp;
	<input type="text" style="width:10%" name="careplan_SN_ENDO_cal_ada" id="careplan_SN_ENDO_cal_ada" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_cal_ada"});?>"/>
	<?php xl('cal ADA','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Other diet" <?php if (in_array("Other diet",$endo_teach)) echo "checked";?>/><?php xl('Other diet','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_ENDO_Other_Diet" id="careplan_SN_ENDO_Other_Diet" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_Other_Diet"});?>"/>
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Foot care" <?php if (in_array("Foot care",$endo_teach)) echo "checked";?>/><?php xl('Foot care','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Exercise" <?php if (in_array("Exercise",$endo_teach)) echo "checked";?>/><?php xl('Exercise','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="S/S to report to MD" <?php if (in_array("S/S to report to MD",$endo_teach)) echo "checked";?>/><?php xl('S/S to report to MD','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="S/S hyper-hypo glycemia and actions to take" <?php if (in_array("S/S hyper-hypo glycemia and actions to take",$endo_teach)) echo "checked";?>/><?php xl('S/S hyper-hypo glycemia and actions to take','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Long term disease management" <?php if (in_array("Long term disease management",$endo_teach)) echo "checked";?>/><?php xl('Long term disease management','e')?>&nbsp;
    </td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Perform[]"  value="Finger stick for blood glucose" <?php if (in_array("Finger stick for blood glucose",$endo_perform)) echo "checked";?>/><?php xl('Finger stick for blood glucose','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Perform[]"  value="Administer (SQ.)" <?php if (in_array("Administer (SQ.)",$endo_perform)) echo "checked";?>/><?php xl('Administer (SQ.)','e')?>&nbsp;
	<input type="text" style="width:10%" name="careplan_SN_ENDO_Perform_Insulin" id="careplan_SN_ENDO_Perform_Insulin" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_Perform_Insulin"});?>" />
	<?php xl('of insulin','e')?>&nbsp;&nbsp;&nbsp;
	<?php xl('Freq.','e')?>&nbsp;
	<input type="text" style="width:10%" name="careplan_SN_ENDO_Perform_Freq" id="careplan_SN_ENDO_Perform_Freq" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_Perform_Freq"});?>"/>
	<input type="checkbox" name="careplan_SN_ENDO_Perform[]"  value="Report significant changes to MD" <?php if (in_array("Report significant changes to MD",$endo_perform)) echo "checked";?>/><?php xl('Report significant changes to MD.','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:74%" name="careplan_SN_ENDO_Perform_Other" id="careplan_SN_ENDO_Perform_Other" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_Perform_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Demonstrate and verbalize an understanding about diabetic management" <?php if (in_array("Demonstrate and verbalize an understanding about diabetic management",$endo_pcggoals)) echo "checked";?>/><?php xl('Demonstrate and verbalize an understanding about diabetic management by','e')?>&nbsp;
	<?php echo goals_date('endo_cal1',$obj{"endo_cal1"}); ?><br>
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Demonstrate independence in managing diabetic regimen including insuling preparation" <?php if (in_array("Demonstrate independence in managing diabetic regimen including insuling preparation",$endo_pcggoals)) echo "checked";?> /><?php xl('Demonstrate independence in managing diabetic regimen including insuling preparation, injection, blood glucose testing and interpretation by','e')?>&nbsp;
	<?php echo goals_date('endo_cal2',$obj{"endo_cal2"}); ?><br>
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Verbalize an understanding that they must notify MD when blood sugar reaches" <?php if (in_array("Verbalize an understanding that they must notify MD when blood sugar reaches",$endo_pcggoals)) echo "checked";?>/><?php xl('Verbalize an understanding that they must notify MD when blood sugar reaches','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_ENDO_PCgGoals_text1" id="careplan_SN_ENDO_PCgGoals_text1" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_PCgGoals_text1"});?>"/>
	<?php xl('by','e')?>&nbsp;
	<?php echo goals_date('endo_cal3',$obj{"endo_cal3"}); ?><br>
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Demonstrate and verbalize understanding of S/Sx of hypo/hyperglycemia and appropriate actions to take" <?php if (in_array("Demonstrate and verbalize understanding of S/Sx of hypo/hyperglycemia and appropriate actions to take",$endo_pcggoals)) echo "checked";?>/><?php xl('Demonstrate and verbalize understanding of S/Sx of hypo/hyperglycemia and appropriate actions to take by','e')?>&nbsp;
	<?php echo goals_date('endo_cal4',$obj{"endo_cal4"}); ?><br>
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Demonstrate and verbalize understanding of long term disease management" <?php if (in_array("Demonstrate and verbalize understanding of long term disease management",$endo_pcggoals)) echo "checked";?>/><?php xl('Demonstrate and verbalize understanding of long term disease management including skin and foot care, s/sx of anemia, bleeding precautions, diet and exercise by','e')?>&nbsp;
	<?php echo goals_date('endo_cal5',$obj{"endo_cal5"}); ?><br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_ENDO_PCgGoals_Other" id="careplan_SN_ENDO_PCgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_ENDO_PCgGoals_Other"});?>"/>
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('GASTROINTESTINAL','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<?php 
        $gastro_asses = array("GT management including","site condition","tube size/type","flushing","Ostomy site management including","Stoma size, appearance, need for appliance",
		"Diet Management","Elimination patterns","Bowel sounds/distension/bloating","Pain,/nausea/vomiting","Compliance/effectiveness of bowel regimen");
        foreach($gastro_asses as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_GASTRO_Assess"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_GASTRO_Assess[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GASTRO_Other" id="careplan_SN_GASTRO_Other" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Bowel regimen to prevent constipation/diarrhea including dietary modification" <?php if (in_array("Bowel regimen to prevent constipation/diarrhea including dietary modification",$gastro_teach)) echo "checked";?> /><?php xl('Bowel regimen to prevent constipation/diarrhea including dietary modification','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="S/Sxs of disease process, including management" <?php if (in_array("S/Sxs of disease process, including management",$gastro_teach)) echo "checked";?>/><?php xl('S/Sxs of disease process, including management, controlling risk factors and identification of complications such as','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Suchas" id="careplan_SN_GASTRO_Suchas" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Suchas"});?>"/>
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Diarrhea/Vomiting" <?php if (in_array("Diarrhea/Vomiting",$gastro_teach)) echo "checked";?>/><?php xl('Diarrhea/Vomiting','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Nausea/Vomiting" <?php if (in_array("Nausea/Vomiting",$gastro_teach)) echo "checked";?>/><?php xl('Nausea/Vomiting','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Ostomy care" <?php if (in_array("Ostomy care",$gastro_teach)) echo "checked";?>/><?php xl('Ostomy care','e')?>&nbsp;
    <input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Administration of Ostomy Irrigation Freq" <?php if (in_array("Administration of Ostomy Irrigation Freq",$gastro_teach)) echo "checked";?>/><?php xl('Administration of Ostomy Irrigation Freq.','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Teach_Freq" id="careplan_SN_GASTRO_Teach_Freq" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Teach_Freq"});?>"/>
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="S/S GI bleed" <?php if (in_array("S/S GI bleed",$gastro_teach)) echo "checked";?>/><?php xl('S/S GI bleed','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Tube care and feeding" <?php if (in_array("Tube care and feeding",$gastro_teach)) echo "checked";?>/><?php xl('Tube care and feeding via.','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="GT" <?php if (in_array("GT",$gastro_teach)) echo "checked";?>/><?php xl('GT','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="JT" <?php if (in_array("JT",$gastro_teach)) echo "checked";?>/><?php xl('JT','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Pt/PCg on Dietary Options including" <?php if (in_array("Pt/PCg on Dietary Options including",$gastro_teach)) echo "checked";?>/><?php xl('Pt/PCg on Dietary Options including','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Low sodium" <?php if (in_array("Low sodium",$gastro_teach)) echo "checked";?>/><?php xl('Low sodium','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Low Fat" <?php if (in_array("Low Fat",$gastro_teach)) echo "checked";?>/><?php xl('Low Fat','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Calorie Restrictions" <?php if (in_array("Calorie Restrictions",$gastro_teach)) echo "checked";?>/><?php xl('Calorie Restrictions','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Renal Diet" <?php if (in_array("Renal Diet",$gastro_teach)) echo "checked";?>/><?php xl('Renal Diet','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GASTRO_Teach_Other" id="careplan_SN_GASTRO_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Teach_Other"});?>" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Ostomy irrigation Freq" <?php if (in_array("Ostomy irrigation Freq",$gastro_perform)) echo "checked";?> /><?php xl('Ostomy irrigation Freq.','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Perform_Freq" id="careplan_SN_GASTRO_Perform_Freq" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Perform_Freq"});?>"/>
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Perform rectal exam, manual removal of impaction" <?php if (in_array("Perform rectal exam, manual removal of impaction",$gastro_perform)) echo "checked";?>/><?php xl('Perform rectal exam, manual removal of impaction, follow up','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Perform_followup" id="careplan_SN_GASTRO_Perform_followup" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Perform_followup"});?>"/>
	<?php xl('enemas PRN.','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Administer tube feeding" <?php if (in_array("Administer tube feeding",$gastro_perform)) echo "checked";?> /><?php xl('Administer tube feeding','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Test stool for guaic" <?php if (in_array("Test stool for guaic",$gastro_perform)) echo "checked";?>/><?php xl('Test stool for guaic','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Administer B12"  <?php if (in_array("Administer B12",$gastro_perform)) echo "checked";?>/><?php xl('Administer B12','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Perform_admin" id="careplan_SN_GASTRO_Perform_admin" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Perform_admin"});?>"/>
	<?php xl('Freq.','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Perform_admin_freq" id="careplan_SN_GASTRO_Perform_admin_freq" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Perform_admin_freq"});?>"/>
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:75%" name="careplan_SN_GASTRO_Perform_Other" id="careplan_SN_GASTRO_Perform_Other" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_Perform_Other"});?>" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Demonstrate and verbalize an understanding about GI Management" <?php if (in_array("Demonstrate and verbalize an understanding about GI Management",$gastro_pcgoals)) echo "checked";?>/><?php xl('Demonstrate and verbalize an understanding about GI Management by','e')?>&nbsp;
	<?php echo goals_date('gastro_cal1',$obj{"gastro_cal1"}); ?>
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Demonstrate and verbalize understanding of bowel regimen" <?php if (in_array("Demonstrate and verbalize understanding of bowel regimen",$gastro_pcgoals)) echo "checked";?>/><?php xl('Demonstrate and verbalize understanding of bowel regimen','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Demonstrate and verbalize understanding of Ostomy care" <?php if (in_array("Demonstrate and verbalize understanding of Ostomy care",$gastro_pcgoals)) echo "checked";?>/><?php xl('Demonstrate and verbalize understanding of Ostomy care','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Demonstrate and verbalize understanding of tube care and feeding" <?php if (in_array("Demonstrate and verbalize understanding of tube care and feeding",$gastro_pcgoals)) echo "checked";?>/><?php xl('Demonstrate and verbalize understanding of tube care and feeding','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Verbalize understanding of dietary options" <?php if (in_array("Verbalize understanding of dietary options",$gastro_pcgoals)) echo "checked";?>/><?php xl('Verbalize understanding of dietary options','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Verbalize understanding and management of disease complications including GI bleed, Diarrhea" <?php if (in_array("Verbalize understanding and management of disease complications including GI bleed, Diarrhea",$gastro_pcgoals)) echo "checked";?> /><?php xl('Verbalize understanding and management of disease complications including GI bleed, Diarrhea','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Nausea" <?php if (in_array("Nausea",$gastro_pcgoals)) echo "checked";?>/><?php xl('Nausea','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Vomiting" <?php if (in_array("Vomiting",$gastro_pcgoals)) echo "checked";?>/><?php xl('Vomiting','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:55%" name="careplan_SN_GASTRO_PcGoals_Other" id="careplan_SN_GASTRO_PcGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_GASTRO_PcGoals_Other"});?>" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('GENITOURINARY','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
		<?php 
        $genito_asses = array("GU Status","Integumentary Status","Nutrition / hydration","S/S of UTI Incontinence","Bladder spasms: freq. & intensity","Retention/ Weakness");
        foreach($genito_asses as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_GENITO_Assess"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_GENITO_Assess[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:55%" name="careplan_SN_GENITO_Assess_Other" id="careplan_SN_GENITO_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_GENITO_Assess_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Pathophysiology of disease process" <?php if (in_array("Pathophysiology of disease process",$genito_teach)) echo "checked";?>/><?php xl('Pathophysiology of disease process','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Action and SE of medications" <?php if (in_array("Action and SE of medications",$genito_teach)) echo "checked";?>/><?php xl('Action and SE of medications','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Relationship of fluid intake to UTI" <?php if (in_array("Relationship of fluid intake to UTI",$genito_teach)) echo "checked";?>/><?php xl('Relationship of fluid intake to UTI','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="S/S of UTI" <?php if (in_array("S/S of UTI",$genito_teach)) echo "checked";?>/><?php xl('S/S of UTI','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="S/S to report to MD" <?php if (in_array("S/S to report to MD",$genito_teach)) echo "checked";?>/><?php xl('S/S to report to MD','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Maintenance of skin integrity" <?php if (in_array("Maintenance of skin integrity",$genito_teach)) echo "checked";?>/><?php xl('Maintenance of skin integrity','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Foley catheter care" <?php if (in_array("Foley catheter care",$genito_teach)) echo "checked";?>/><?php xl('Foley catheter care','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Condom catheter use and change" <?php if (in_array("Condom catheter use and change",$genito_teach)) echo "checked";?> /><?php xl('Condom catheter use and change','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Self Catheterization" <?php if (in_array("Self Catheterization",$genito_teach)) echo "checked";?> /><?php xl('Self Catheterization','e')?>&nbsp;
	&nbsp;&nbsp;&nbsp;<?php xl('Freq.','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_GENITO_Teach_Freq" id="careplan_SN_GENITO_Teach_Freq" value="<?php echo stripslashes($obj{"careplan_SN_GENITO_Teach_Freq"});?>"/>
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Urostomy/ileo-conduit care" <?php if (in_array("Urostomy/ileo-conduit care",$genito_teach)) echo "checked";?>/><?php xl('Urostomy/ileo-conduit care','e')?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GENITO_Teach_Other" id="careplan_SN_GENITO_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_GENITO_Teach_Other"});?>"/>
	</td></tr>
	
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Perform[]"  value="Insert/change Foley catheter" <?php if (in_array("Insert/change Foley catheter",$genito_perform)) echo "checked";?>/><?php xl('Insert/change Foley catheter','e')?>&nbsp;&nbsp;&nbsp;
	<?php xl('Size','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_GENITO_Perform_size" id="careplan_SN_GENITO_Perform_size" value="<?php echo stripslashes($obj{"careplan_SN_GENITO_Perform_size"});?>"/>
	<?php xl('Every 28 -32 days and PRN malfunction per sterile technique.','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Perform[]"  value="Obtain specimen UA, C& S" <?php if (in_array("Obtain specimen UA, C& S",$genito_perform)) echo "checked";?>/><?php xl('Obtain specimen UA, C& S as ','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_GENITO_Perform_ordered" id="careplan_SN_GENITO_Perform_ordered" value="<?php echo stripslashes($obj{"careplan_SN_GENITO_Perform_ordered"});?>"/>
	<?php xl('ordered','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Perform[]"  value="Perform straight catheterization for residual/obtain sterile specimen" <?php if (in_array("Perform straight catheterization for residual/obtain sterile specimen",$genito_perform)) echo "checked";?>/><?php xl('Perform straight catheterization for residual/obtain sterile specimen.','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:80%" name="careplan_SN_GENITO_Perform_Other" id="careplan_SN_GENITO_Perform_Other" value="<?php echo stripslashes($obj{"careplan_SN_GENITO_Perform_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_PcgGoals[]"  value="Urinary elimination will be WNL" <?php if (in_array("Urinary elimination will be WNL",$genito_pcggoals)) echo "checked";?>/><?php xl('Urinary elimination will be WNL by','e')?>&nbsp;
	<?php echo goals_date('genito_cal1',$obj{"genito_cal1"}); ?>
	<input type="checkbox" name="careplan_SN_GENITO_PcgGoals[]"  value="Will be free of s/sx of UTI" <?php if (in_array("Will be free of s/sx of UTI",$genito_pcggoals)) echo "checked";?>/><?php xl('Will be free of s/sx of UTI by','e')?>&nbsp;
	<?php echo goals_date('genito_cal2',$obj{"genito_cal2"}); ?>
	<input type="checkbox" name="careplan_SN_GENITO_PcgGoals[]"  value="Will verbalize understanding of incontinence without skin breakdown" <?php if (in_array("Will verbalize understanding of incontinence without skin breakdown",$genito_pcggoals)) echo "checked";?>/><?php xl('Will verbalize understanding of incontinence without skin breakdown by','e')?>&nbsp;
	<?php echo goals_date('genito_cal3',$obj{"genito_cal3"}); ?>
	<input type="checkbox" name="careplan_SN_GENITO_PcgGoals[]"  value="Will demonstrate ability to manage ostomy/catheter independently" <?php if (in_array("Will demonstrate ability to manage ostomy/catheter independently",$genito_pcggoals)) echo "checked";?>/><?php xl('Will demonstrate ability to manage ostomy/catheter independently by','e')?>&nbsp;
	<?php echo goals_date('genito_cal4',$obj{"genito_cal4"}); ?>
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:53%" name="careplan_SN_GENITO_PcgGoals_Other" id="careplan_SN_GENITO_PcgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_GENITO_PcgGoals_Other"});?>"/>
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('INTEGUMENTARY','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<?php 
        $integu_asses = array("Skin integrity","Potential for skin breakdown","Diaphoretic","Rash","Lesion","Turgor","Skin Tears","Wound(s) Characteristics (Refer to Wound Assessment )","Wound Healing and/or Infection");
        foreach($integu_asses as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_INTEGU_Assess"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_INTEGU_Assess[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_INTEGU_Assess_Other" id="careplan_SN_INTEGU_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Assess_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<?php 
        $integu_teach = array("Skin care","Positioning for comfort/pressure relief","Infection control/universal precautions","Protective dressings","Wound Care Management");
        foreach($integu_teach as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_INTEGU_Teach"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_INTEGU_Teach[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_INTEGU_Teach_Other" id="careplan_SN_INTEGU_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Teach_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Perform"  value="Wound/Decubitus Care" <?php if ($obj{"careplan_SN_INTEGU_Perform"} == "Wound/Decubitus Care") echo "checked";;?>/><?php xl('Wound/Decubitus Care to:','e')?>&nbsp;
	<?php xl('Locations','e')?>&nbsp;
	<input type="text" style="width:30%" name="careplan_SN_INTEGU_Perform_location" id="careplan_SN_INTEGU_Perform_location" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Perform_location"});?>"/>
	<?php xl('Freq','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_INTEGU_Perform_Freq" id="careplan_SN_INTEGU_Perform_Freq" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Perform_Freq"});?>"/>
	<?php xl('Clean/Irrigate With','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_INTEGU_Perform_Clean" id="careplan_SN_INTEGU_Perform_Clean" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Perform_Clean"});?>"/>
	<?php xl('Pack With','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_INTEGU_Perform_Pack" id="careplan_SN_INTEGU_Perform_Pack" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Perform_Pack"});?>"/>
	<?php xl('Apply','e')?>&nbsp;
	<input type="text" style="width:30%" name="careplan_SN_INTEGU_Perform_Apply" id="careplan_SN_INTEGU_Perform_Apply" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Perform_Apply"});?>"/>
	<?php xl('Cover With','e')?>&nbsp;
	<input type="text" style="width:30%" name="careplan_SN_INTEGU_Perform_Cover" id="careplan_SN_INTEGU_Perform_Cover" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Perform_Cover"});?>"/>
	<?php xl('Secure With','e')?>&nbsp;
	<input type="text" style="width:50%" name="careplan_SN_INTEGU_Perform_Secure" id="careplan_SN_INTEGU_Perform_Secure" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_Perform_Secure"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_PcgGoals[]"  value="Wound(s) will improve in the following areas" <?php if (in_array("Wound(s) will improve in the following areas",$integu_pcggoals)) echo "checked";?>/><?php xl('Wound(s) will improve in the following areas','e')?>&nbsp;
	<input type="text" style="width:32%" name="careplan_SN_INTEGU_PcgGoals_areas" id="careplan_SN_INTEGU_PcgGoals_areas" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_PcgGoals_areas"});?>"/>
	<?php xl('by','e')?>
	<?php echo goals_date('integu_cal1',$obj{"integu_cal1"}); ?><br>
	<input type="checkbox" name="careplan_SN_INTEGU_PcgGoals[]"  value="Wound will be free of s/sx of infection" <?php if (in_array("Wound will be free of s/sx of infection",$integu_pcggoals)) echo "checked";?> /><?php xl('Wound will be free of s/sx of infection by','e')?>&nbsp;
	<?php echo goals_date('integu_cal2',$obj{"integu_cal2"}); ?>&nbsp;&nbsp;&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_PcgGoals[]"  value="Will demonstrate proper skin/wound care and positioning" <?php if (in_array("Will demonstrate proper skin/wound care and positioning",$integu_pcggoals)) echo "checked";?> /><?php xl('Will demonstrate proper skin/wound care and positioning by','e')?>&nbsp;
	<?php echo goals_date('integu_cal3',$obj{"integu_cal3"}); ?>&nbsp;&nbsp;&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:77%" name="careplan_SN_INTEGU_PcgGoals_Other" id="careplan_SN_INTEGU_PcgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_INTEGU_PcgGoals_Other"});?>"/>
	</td></tr>
	
		<tr><td align="center">
	<strong><?php xl('MUSCULOSKELETAL/MOBILITY','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<?php 
        $musculo_assess = array("Musculo-skeletal status r/t mobility and endurance","Need for assistive devices","Ability to perform ADLs","Safety in Mobility","Need for PT, OT Intervention","Strength and Endurance in ADLs","Joint Range of Motion","Fall Risks");
        foreach($musculo_assess as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_MUSCULO_Assess"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_MUSCULO_Assess[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_MUSCULO_Assess_Other" id="careplan_SN_MUSCULO_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_MUSCULO_Assess_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<?php 
        $musculo_teach = array("Complications of decreased mobility","Safe transfers and ambulation","Purpose, proper admin. & S/E of pain control meds","S/S to report to M.D","ROM/Strength Exercises for Maintenance","Proper Body Alignment","Measures to Promote Circulation","Proper use of Adaptive Equipment and Assistive Devices","Educate on role of medications and safe practices to prevent falls");
        foreach($musculo_teach as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_MUSCULO_Teach"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_MUSCULO_Teach[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_MUSCULO_Teach_Other" id="careplan_SN_MUSCULO_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_MUSCULO_Teach_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Perform_Venipuncture"  value="Venipuncture for Lab work as ordered by M.D" <?php if ($obj{"careplan_SN_MUSCULO_Perform_Venipuncture"} == "Venipuncture for Lab work as ordered by M.D") echo "checked";;?> /><?php xl('Venipuncture for Lab work as ordered by M.D.','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Perform_staples"  value="Remove staples" <?php if ($obj{"careplan_SN_MUSCULO_Perform_staples"} == "Remove staples") echo "checked";;?>/><?php xl('Remove staples','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_MUSCULO_Perform_Other" id="careplan_SN_MUSCULO_Perform_Other" value="<?php echo stripslashes($obj{"careplan_SN_MUSCULO_Perform_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_PcgGoals[]"  value="Will be able to verbalize an understanding of falls prevention" <?php if (in_array("Will be able to verbalize an understanding of falls prevention",$musculo_pcggoals)) echo "checked";?>/><?php xl('Will be able to verbalize an understanding of falls prevention by','e')?>&nbsp;
	<?php echo goals_date('musculo_cal1',$obj{"musculo_cal1"}); ?>
	<input type="checkbox" name="careplan_SN_MUSCULO_PcgGoals[]"  value="Able to demonstrate safe transfers" <?php if (in_array("Able to demonstrate safe transfers",$musculo_pcggoals)) echo "checked";?>/><?php xl('Able to demonstrate safe transfers by','e')?>&nbsp;
	<?php echo goals_date('musculo_cal2',$obj{"musculo_cal2"}); ?>
	<input type="checkbox" name="careplan_SN_MUSCULO_PcgGoals[]"  value="Able to demonstrate proper circulatory care" <?php if (in_array("Able to demonstrate proper circulatory care",$musculo_pcggoals)) echo "checked";?>/><?php xl('Able to demonstrate proper circulatory care by','e')?>&nbsp;
	<?php echo goals_date('musculo_cal3',$obj{"musculo_cal3"}); ?>
	<input type="checkbox" name="careplan_SN_MUSCULO_PcgGoals[]"  value="Able to demonstrate proper use of Assistive devices and/or Adaptive Equipment" <?php if (in_array("Able to demonstrate proper use of Assistive devices and/or Adaptive Equipment",$musculo_pcggoals)) echo "checked";?>/><?php xl('Able to demonstrate proper use of Assistive devices and/or Adaptive Equipment by','e')?>&nbsp;
	<?php echo goals_date('musculo_cal4',$obj{"musculo_cal4"}); ?>
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:36%" name="careplan_SN_MUSCULO_PcgGoals_Other" id="careplan_SN_MUSCULO_PcgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_MUSCULO_PcgGoals_Other"});?>"/>
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('MENTAL/EMOTIONAL','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<?php 
        $mental_assess = array("Need for Medical Social Worker Intervention","Impact of Cognitive Impairment to independent living","Mood related to depression, isolation, and/or anxiety and impact on daily living","Suicidal Ideation","Schizo Affective Disorders impact on self and home management");
        foreach($mental_assess as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_MENTAL_Assess"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_MENTAL_Assess[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	&nbsp;&nbsp;&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:76%" name="careplan_SN_MENTAL_Assess_Other" id="careplan_SN_MENTAL_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_MENTAL_Assess_Other"});?>" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<?php 
        $mental_teach = array("Role of Medical Social Worker with mental/emotional issues","Compensatory strategies with cognitive impairment","Compensatory strategies in medication management","How Medication can impact mood disorders","Stress management techniques and coping skills");
        foreach($mental_teach as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_MENTAL_Teach"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_MENTAL_Teach[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	&nbsp;&nbsp;&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:60%" name="careplan_SN_MENTAL_Teach_Other" id="careplan_SN_MENTAL_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_MENTAL_Teach_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_PcgGoals[]"  value="Demonstrate organized method of remembering medications" <?php if (in_array("Demonstrate organized method of remembering medications",$mental_pcggoals)) echo "checked";?>/><?php xl('Demonstrate organized method of remembering medications by','e')?>&nbsp;
	<?php echo goals_date('mental_cal1',$obj{"mental_cal1"}); ?>
	<input type="checkbox" name="careplan_SN_MENTAL_PcgGoals[]"  value="Verbalize role of Medical Social Worker and how can assist with mood disorders" <?php if (in_array("Verbalize role of Medical Social Worker and how can assist with mood disorders",$mental_pcggoals)) echo "checked";?>/><?php xl('Verbalize role of Medical Social Worker and how can assist with mood disorders by','e')?>&nbsp;
	<?php echo goals_date('mental_cal2',$obj{"mental_cal2"}); ?>
	<input type="checkbox" name="careplan_SN_MENTAL_PcgGoals[]"  value="Verbalize understanding of role of medications and their impact on mood disorders" <?php if (in_array("Verbalize understanding of role of medications and their impact on mood disorders",$mental_pcggoals)) echo "checked";?>/><?php xl('Verbalize understanding of role of medications and their impact on mood disorders by','e')?>&nbsp;
	<?php echo goals_date('mental_cal3',$obj{"mental_cal3"}); ?>
	<input type="checkbox" name="careplan_SN_MENTAL_PcgGoals[]"  value="Demonstrate and verbalize understanding of incorporating stress management techniques in daily living" <?php if (in_array("Demonstrate and verbalize understanding of incorporating stress management techniques in daily living",$mental_pcggoals)) echo "checked";?>/><?php xl('Demonstrate and verbalize understanding of incorporating stress management techniques in daily living','e')?>&nbsp;
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:50%" name="careplan_SN_MENTAL_PcgGoals_Other" id="careplan_SN_MENTAL_PcgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_MENTAL_PcgGoals_Other"});?>"/>
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('NEUROLOGICAL','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="Seizure activity, notify MD for activity greater than" <?php if (in_array("Seizure activity, notify MD for activity greater than",$neuro_assess)) echo "checked";?>/><?php xl('Seizure activity, notify MD for activity greater than','e')?>&nbsp;
	<input type="text" style="width:10%" name="careplan_SN_NEURO_Assess_minutes" id="careplan_SN_NEURO_Assess_minutes" value="<?php echo stripslashes($obj{"careplan_SN_NEURO_Assess_minutes"});?>" />
	<?php xl('minutes','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="LOC/Orientation" <?php if (in_array("LOC/Orientation",$neuro_assess)) echo "checked";?>/><?php xl('LOC/Orientation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="Speech comprehension and expression" <?php if (in_array("Speech comprehension and expression",$neuro_assess)) echo "checked";?>/><?php xl('Speech comprehension and expression','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="Neurological motor and sensory system" <?php if (in_array("Neurological motor and sensory system",$neuro_assess)) echo "checked";?> /><?php xl('Neurological motor and sensory system','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="Swallow Difficulty" <?php if (in_array("Swallow Difficulty",$neuro_assess)) echo "checked";?>/><?php xl('Swallow Difficulty','e')?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_NEURO_Assess_Other" id="careplan_SN_NEURO_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_NEURO_Assess_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<?php 
        $neuro_teach = array("Seizure Precautions","Caregiver assessment of LOC with patient","Caregiver in Reality Orientation","Caregiver in S/Sx of CVA","Environmental Adaptations based on Visual Impairment","Compensatory Swallow Techniques");
        foreach($neuro_teach as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_NEURO_Teach"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_NEURO_Teach[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_NEURO_Teach_Other" id="careplan_SN_NEURO_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_NEURO_Teach_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Verbalize understanding of seizure management" <?php if (in_array("Verbalize understanding of seizure management",$neuro_pcggoals)) echo "checked";?>/><?php xl('Verbalize understanding of seizure management by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal1',$obj{"neuro_cal1"}); ?>
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Demontrate assessing LOC/Orientation" <?php if (in_array("Demontrate assessing LOC/Orientation",$neuro_pcggoals)) echo "checked";?> /><?php xl('Demontrate assessing LOC/Orientation by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal2',$obj{"neuro_cal2"}); ?>
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Demonstrating activities for Reality Orientation" <?php if (in_array("Demonstrating activities for Reality Orientation",$neuro_pcggoals)) echo "checked";?> /><?php xl('Demonstrating activities for Reality Orientation by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal3',$obj{"neuro_cal3"}); ?>
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Verbalize understanding of S/Sx of CVA"  <?php if (in_array("Verbalize understanding of S/Sx of CVA",$neuro_pcggoals)) echo "checked";?>/><?php xl('Verbalize understanding of S/Sx of CVA by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal4',$obj{"neuro_cal4"}); ?>
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Demonstrate Swallow Techniques during eating" <?php if (in_array("Demonstrate Swallow Techniques during eating",$neuro_pcggoals)) echo "checked";?>/><?php xl('Demonstrate Swallow Techniques during eating by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal5',$obj{"neuro_cal5"}); ?>
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_NEURO_PcgGoals_Other" id="careplan_SN_NEURO_PcgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_NEURO_PcgGoals_Other"});?>" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('RESPIRATORY','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<?php 
        $respir_assess = array("Pt. Increase/Decrease respiratory function","S/S of infection","Lung Sounds Clear","Abnormal Breath Sounds","Cough/Sputum","O2 Liters","Pallor/Cyanosis","Respiration Labored","Respiration Unlabored","Pulse Oximetry","Notify MD for pulse oximetry reading is less than 88% after 2 minute rest");
        foreach($respir_assess as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_RESPIR_Assess"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_RESPIR_Assess[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_RESPIR_Assess_Other" id="careplan_SN_RESPIR_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_RESPIR_Assess_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<?php 
        $respir_assess = array("Pulmonary hygiene","Pursed lip breathing","Use of nebulizer/aerosol inhaler","Postural drainage and percussion","Safe use of oxygen & care of equipment","Maintenance of patent airway","Suctioning","Anxiety management","Trach care","Maintaining nasal cannula and/or c-pap","Energy Conservation","S/Sx of respiratory distress");
        foreach($respir_assess as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_RESPIR_Teach"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_RESPIR_Teach[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_RESPIR_Teach_Other" id="careplan_SN_RESPIR_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_RESPIR_Teach_Other"});?>" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Perform"  value="Chest physio-therapy" <?php if ($obj{"careplan_SN_RESPIR_Perform"} == "Chest physio-therapy") echo "checked";;?>/><?php xl('Chest physio-therapy','e')?>&nbsp;
	&nbsp;<?php xl('frequency','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_RESPIR_Perform_Freq" id="careplan_SN_RESPIR_Perform_Freq" value="<?php echo stripslashes($obj{"careplan_SN_RESPIR_Perform_Freq"});?>"/>
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:31%" name="careplan_SN_RESPIR_Perform_Other" id="careplan_SN_RESPIR_Perform_Other" value="<?php echo stripslashes($obj{"careplan_SN_RESPIR_Perform_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Able to demonstrate clear lund sounds" <?php if (in_array("Able to demonstrate clear lund sounds",$respir_pcggoals)) echo "checked";?>/><?php xl('Able to demonstrate clear lund sounds by','e')?>&nbsp;
	<?php echo goals_date('respir_cal1',$obj{"respir_cal1"}); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Free of Respiratory Infection" <?php if (in_array("Free of Respiratory Infection",$respir_pcggoals)) echo "checked";?>/><?php xl('Free of Respiratory Infection by','e')?>&nbsp;
	<?php echo goals_date('respir_cal2',$obj{"respir_cal2"}); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Able to demonstrate Respiratory exercises including pursed lip breathing, cough and sputum management" <?php if (in_array("Able to demonstrate Respiratory exercises including pursed lip breathing, cough and sputum management",$respir_pcggoals)) echo "checked";?>/><?php xl('Able to demonstrate Respiratory exercises including pursed lip breathing, cough and sputum management by','e')?>&nbsp;
	<?php echo goals_date('respir_cal3',$obj{"respir_cal3"}); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Able to demonstrate proper suction technique" <?php if (in_array("Able to demonstrate proper suction technique",$respir_pcggoals)) echo "checked";?>/><?php xl('Able to demonstrate proper suction technique by','e')?>&nbsp;
	<?php echo goals_date('respir_cal4',$obj{"respir_cal4"}); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Able to verbalize understanding of oxygen safety and demonstrate oxygen equipment maintenance" <?php if (in_array("Able to verbalize understanding of oxygen safety and demonstrate oxygen equipment maintenance",$respir_pcggoals)) echo "checked";?>/><?php xl('Able to verbalize understanding of oxygen safety and demonstrate oxygen equipment maintenance by','e')?>&nbsp;
	<?php echo goals_date('respir_cal5',$obj{"respir_cal5"}); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="S/Sx of Dyspnea will decrease" <?php if (in_array("S/Sx of Dyspnea will decrease",$respir_pcggoals)) echo "checked";?>/><?php xl('S/Sx of Dyspnea will decrease by','e')?>&nbsp;
	<?php echo goals_date('respir_cal6',$obj{"respir_cal6"}); ?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_RESPIR_PcgGoals_Other" id="careplan_SN_RESPIR_PcgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_RESPIR_PcgGoals_Other"});?>" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('GENERAL MEDICAL','e')?></strong>
	</td></tr>
		
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<?php 
        $general_assess = array("Appetite","Weight Gain/Loss","Pain Level","Effectiveness of current pain regimen","Medication management");
        foreach($general_assess as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_GENERAL_Assess"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_GENERAL_Assess[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GENERAL_Assess_Other" id="careplan_SN_GENERAL_Assess_Other" value="<?php echo stripslashes($obj{"careplan_SN_GENERAL_Assess_Other"});?>" />
	</td></tr> 
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<?php 
        $general_teach = array("Medication management","Dietary resources","Pharmacological approaches to pain management","Non pharmacological approaches to pain management");
        foreach($general_teach as $key) {
				$c = "";
				if (in_array($key,explode("#",$obj{"careplan_SN_GENERAL_Teach"}))) { $c = "checked"; }
				echo "<input type='checkbox' name='careplan_SN_GENERAL_Teach[]'  value='$key' $c />";
				echo xl($key,'e').'&nbsp;';
				}
          ?>
	
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:56%" name="careplan_SN_GENERAL_Teach_Other" id="careplan_SN_GENERAL_Teach_Other" value="<?php echo stripslashes($obj{"careplan_SN_GENERAL_Teach_Other"});?>"/>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_PcgGoals[]"  value="Will be able to demonstrate ability to manage medications" <?php if (in_array("Will be able to demonstrate ability to manage medications",$general_pcggoals)) echo "checked";?> /><?php xl('Will be able to demonstrate ability to manage medications by','e')?>&nbsp;
	<?php echo goals_date('general_cal1',$obj{"general_cal1"}); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_PcgGoals[]"  value="Able to verbalize dietary options" <?php if (in_array("Able to verbalize dietary options",$general_pcggoals)) echo "checked";?>/><?php xl('Able to verbalize dietary options by','e')?>&nbsp;
	<?php echo goals_date('general_cal2',$obj{"general_cal2"}); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_PcgGoals[]"  value="Verbalize non-pharmacological approaches to pain management" <?php if (in_array("Verbalize non-pharmacological approaches to pain management",$general_pcggoals)) echo "checked";?>/><?php xl('Verbalize non-pharmacological approaches to pain management by','e')?>&nbsp;
	<?php echo goals_date('general_cal3',$obj{"general_cal3"}); ?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GENERAL_PcgGoals_Other" id="careplan_SN_GENERAL_PcgGoals_Other" value="<?php echo stripslashes($obj{"careplan_SN_GENERAL_PcgGoals_Other"});?>"/>
	</td></tr>
	
	
	
  </table>
  <?php
	  
		/* include api.inc. also required. */
		require_once($GLOBALS['srcdir'].'/api.inc');

		/* include our smarty derived controller class. */
		require('C_FormPainMap.class.php');

		/* Create a form object. */
		$c = new C_FormPainMap();

		/* Render a 'new form' page. */
		echo $c->view_action($_GET['id']);
	  ?>
	  
	 <table width="100%" border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
	 <tr>
	   <th scope="row"><?php xl('Wound','e')?>
         <td align="center"><strong><?php xl('#','e')?></strong></td>
         <td align="center"><strong><?php xl('#','e')?></strong></td>
         <td align="center"><strong><?php xl('#','e')?></strong></td>
         <td align="center"><strong><?php xl('#','e')?></strong></td>
         <td align="center"><strong><?php xl('Comments','e')?></strong></td>
        </tr>

	</tr>
  <tr>
    <th scope="row" align="right"><?php xl('Type of Wound','e')?> <input type="hidden" name="wound_label[]" value="Type of Wound" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[0];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[0];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[0];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[0];?>" size="12" /></td>
    <td rowspan="12"><textarea name="Interventions" cols="30" rows="15"><?php echo $Interventions[0];?></textarea></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Status','e')?> <input type="hidden" name="wound_label[]" value="Wound Status" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[1];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[1];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[1];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[1];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Measurements Length','e')?> <input type="hidden" name="wound_label[]" value="Measurements Length" /><br />
<?php xl('Width','e')?> <input type="hidden" name="wound_label[]" value="Measurements Width" /> <br />
<?php xl('Depth','e')?> <input type="hidden" name="wound_label[]" value="Measurements Depth" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[2];?>" size="12" /> <br /><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[3];?>" size="12" /> <br /><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[4];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[2];?>" size="12" /> <br /><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[3];?>" size="12" /> <br /><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[4];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[2];?>" size="12" /> <br /><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[3];?>" size="12" /> <br /><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[4];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[2];?>" size="12" /> <br /><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[3];?>" size="12" /> <br /><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[4];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Pressure Sore Stage','e')?> <input type="hidden" name="wound_label[]" value="Pressure Sore Stage" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[5];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[5];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[5];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[5];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tunneling','e')?> <input type="hidden" name="wound_label[]" value="Tunneling" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[6];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[6];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[6];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[6];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Undermining','e')?> <input type="hidden" name="wound_label[]" value="Undermining" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[7];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[7];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[7];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[7];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Drainage','e')?> <input type="hidden" name="wound_label[]" value="Drainage" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[8];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[8];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[8];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[8];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Amount of Drainage','e')?> <input type="hidden" name="wound_label[]" value="Amount of Drainage" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[9];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[9];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[9];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[9];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Odor','e')?> <input type="hidden" name="wound_label[]" value="Odor" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[10];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[10];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[10];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[10];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Wound Base','e')?> <input type="hidden" name="wound_label[]" value="Tissue of Wound Base" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[11];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[11];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[11];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[11];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Surround Wound','e')?> <input type="hidden" name="wound_label[]" value="Tissue of Surround Wound" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[12];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[12];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[12];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[12];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Level of Pain with Wound','e')?> <input type="hidden" name="wound_label[]" value="Level of Pain with Wound" /></th>
    <td><input name="wound_value1[]" type="text" value="<?php echo $wound_value1[13];?>" size="12" /></td>
    <td><input name="wound_value2[]" type="text" value="<?php echo $wound_value2[13];?>" size="12" /></td>
    <td><input name="wound_value3[]" type="text" value="<?php echo $wound_value3[13];?>" size="12" /></td>
    <td><input name="wound_value4[]" type="text" value="<?php echo $wound_value4[13];?>" size="12" /></td>
  </tr>
</table>			 

<table width="100%" border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
  <tr>
	<th scope="row"><?php xl('Wound','e')?>
         <td align="center"><strong><?php xl('#','e')?></strong></td>
         <td align="center"><strong><?php xl('#','e')?></strong></td>
         <td align="center"><strong><?php xl('#','e')?></strong></td>
         <td align="center"><strong><?php xl('#','e')?></strong></td>
         <td align="center"><strong><?php xl('Comments','e')?></strong></td>
        </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Type of Wound','e')?> </th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[0];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[0];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[0];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[0];?>" size="12" /></td>
    <td rowspan="12"><textarea name="wound_comments" cols="30" rows="15"><?php echo $wound_comments[0];?></textarea></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Status','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[1];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[1];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[1];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[1];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Measurements Length','e')?> <br />
<?php xl('Width','e')?>  <br />
<?php xl('Depth','e')?> </th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[2];?>" size="12" /> <br /><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[3];?>" size="12" /> <br /><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[4];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[2];?>" size="12" /> <br /><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[3];?>" size="12" /> <br /><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[4];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[2];?>" size="12" /> <br /><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[3];?>" size="12" /> <br /><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[4];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[2];?>" size="12" /> <br /><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[3];?>" size="12" /> <br /><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[4];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Pressure Sore Stage','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[5];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[5];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[5];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[5];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tunneling','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[6];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[6];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[6];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[6];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Undermining','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[7];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[7];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[7];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[7];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Drainage','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[8];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[8];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[8];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[8];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Amount of Drainage','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[9];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[9];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[9];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[9];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Odor','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[10];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[10];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[10];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[10];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Wound Base','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[11];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[11];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[11];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[11];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Surround Wound','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[12];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[12];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[12];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[12];?>" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Level of Pain with Wound','e')?></th>
    <td><input name="wound_value5[]" type="text" value="<?php echo $wound_value5[13];?>" size="12" /></td>
    <td><input name="wound_value6[]" type="text" value="<?php echo $wound_value6[13];?>" size="12" /></td>
    <td><input name="wound_value7[]" type="text" value="<?php echo $wound_value7[13];?>" size="12" /></td>
    <td><input name="wound_value8[]" type="text" value="<?php echo $wound_value8[13];?>" size="12" /></td>
  </tr>
</table>
<table width="100%" border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
<tr>
<td width="50%"><?php xl('Patient/Caregiver willing to provide wound care?','e')?>
<input type="checkbox" name="careplan_SN_WC_status" value="Yes" id="careplan_SN_WC_status" <?php if ($obj{"careplan_SN_WC_status"} == "Yes")	echo "checked";;?> />
<?php xl('Yes','e'); ?>
<input type="checkbox" name="careplan_SN_WC_status" value="No" id="careplan_SN_WC_status" <?php if ($obj{"careplan_SN_WC_status"} == "No")	echo "checked";;?> />
<?php xl('No','e'); ?> 
<br>&nbsp;
<?php xl('If, No explain','e'); ?> 
&nbsp;
<input type="text" style="width:72%" name="careplan_SN_provide_wound_care" id="careplan_SN_provide_wound_care" value="<?php echo stripslashes($obj{"careplan_SN_provide_wound_care"});?>"/>
</td>
<td width="50%">
<?php xl('Physician is notified every two weeks of wound status','e')?>
<br>&nbsp;
<input type="text" style="width:90%" name="careplan_SN_wound_status" id="careplan_SN_wound_status"  value="<?php echo stripslashes($obj{"careplan_SN_wound_status"});?>"/>
</td>
</tr></table>

<a id="btn_save" href="javascript:void(0)" class="link_submit">
<?php xl(' [Save]','e')?></a>
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
	<form id="login_form" method="post" action="" style="width:166px;">
            <center>
                        <div id="login_prompt" style="font-size:small;">Enter your password to sign:</div>
                        <input type="hidden" name="sig_status" value="approved" />
                        <input type="hidden" id="tid" name="tid" value="<?php echo $id;?>"/>
                        <input type="hidden" id="table_name" name="table_name" value="<?php echo $formTable;?>"/>
			<input type="hidden" id="signature_uid" name="signature_uid" value="<?php echo $_SESSION['authUserID'];?>"/>
                        <input type="hidden" id="signature_id" name="signature_id" value="<?php echo $sigId->getId();?>" />
                        <input type="hidden" id="exam_name" name="exam_name" value="<?php echo $registryRow['nickname'];?>" />
                        <input type="hidden" id="exam_pid" name="exam_pid" value="<?php echo $obj['pid'];?>" />
                        <input type="hidden" id="exam_date" name="exam_date" value="<?php echo $obj['date'];?>" /><br>
			<table><tr><td><label for="login_pass" style="font-size:small;">Password:</label></td><td> <input type="password" id="login_pass" name="login_pass" size="10" /></td></tr></table><br>
                    
                
		
			<input type="submit" value="Sign" />
		
		</center>
	</form>
</div>

</body>
</html>

	
