<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: nursing_careplan");
?>

<html>
<head>
<title>SKILLED NURSING CARE PLAN</title>
<style type="text/css">
.bold {
	font-weight: bold;
}
table label, input { display:inherit !important; }

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
<form method="post" id="submitForm"
		action="<?php echo $rootdir;?>/forms/nursing_careplan/save.php?mode=new" name="nursing_careplan" onsubmit="return top.restoreSession();" enctype="multipart/form-data">
		<h3 align="center"><?php xl('SKILLED NURSING CARE PLAN','e')?></h3>
		<h5 align="center">
		<?php xl('(Information from this form populates the Plan of Care/485)','e'); ?>
		</h5>
<table width="100%" border="1" class="formtable">
<tr><td><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="0px" >
   <tr>

        <td width="19%" align="center" scope="row"><strong><?php xl('PATIENT NAME','e')?></strong></td>
        <td width="30%" align="left">&nbsp;<input type="text" style="width:70%"
					id="patient_name" value="<?php patientName()?>"
					readonly /></td>
        <td width="9%" align="center"><strong><?php xl('Certification/Recertification Period','e')?></strong></td>
        <td width="16%" align="center" class="bold">&nbsp;</td>
       </tr>
</table>
</td>
  </tr>
  <tr>
    <td scope="row">

        <strong><?php xl('SN To Assess Vital Signs','e')?></strong>&nbsp;&nbsp;
		<?php xl('( The Parameters chosen in this section should populate every nursing visit note and therapy note for that patient )','e')?>
		<br>
		<strong><?php xl('Contact MD if Vital Signs are:','e')?></strong>
		<input type="checkbox" name="careplan_Assess_Vital_Signs[]"  value="Pulse <56 or >120" /><?php xl('Pulse <56 or >120;','e')?>&nbsp;
		<input type="checkbox" name="careplan_Assess_Vital_Signs[]"  value="Temperature <56 or >101" /><?php xl('Temperature <56 or >101;','e')?>&nbsp;
		<input type="checkbox" name="careplan_Assess_Vital_Signs[]"  value="Respirations <10 or >30" /><?php xl('Respirations <10 or >30;','e')?>&nbsp;
		<input type="checkbox" name="careplan_Assess_Vital_Signs[]"  value="SBP <80 or >190" /><?php xl('SBP <80 or >190;','e')?>&nbsp;
		<input type="checkbox" name="careplan_Assess_Vital_Signs[]"  value="DBP <50 or >100" /><?php xl('DBP <50 or >100;','e')?>&nbsp;
		<input type="checkbox" name="careplan_Assess_Vital_Signs[]"  value="Pain Significantly Impacts patients ability to participate" /><?php xl('Pain Significantly Impacts patients ability to participate;','e')?>&nbsp;
		<input type="checkbox" name="careplan_Assess_Vital_Signs[]"  value="O2 Sat <90% after 2 minute rest" /><?php xl('O2 Sat <90% after 2 minute rest','e')?>&nbsp;
		<input type="checkbox" name="careplan_Assess_Vital_Signs[]"  value="If parameters are different from above specify" /><?php xl('If parameters are different from above specify','e')?>&nbsp;
		<input type="text" style="width:78%" name="careplan_Assess_Vital_Signs_Specify" id="careplan_Assess_Vital_Signs_Specify" />
		
	</td>

  </tr>
  <tr>
  <td><strong>
   <?php xl('SN to Perform skilled assessment, management and education of all organ systems with emphasis on the following','e')?></strong><br>
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Cardiovascular" /><?php xl('Cardiovascular','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Endocrine" /><?php xl('Endocrine','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Gastrointestinal" /><?php xl('Gastrointestinal','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Genitourinary" /><?php xl('Genitourinary','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Integumentary" /><?php xl('Integumentary','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Mental/Emotional" /><?php xl('Mental/Emotional','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Musculoskeletal/Mobility" /><?php xl('Musculoskeletal/Mobility','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Neurological" /><?php xl('Neurological','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="Respiratory" /><?php xl('Respiratory','e')?>&nbsp;
   <input type="checkbox" name="careplan_SN_Skilled_Assessment[]"  value="General Medical" /><?php xl('General Medical','e')?> <br>
   <?php xl('Other','e')?>&nbsp;
   <input type="text" style="width:93%" name="careplan_SN_Skilled_Assessment_Other" id="careplan_SN_Skilled_Assessment_Other" />
   </td></tr>
   <tr><td align="left">
    <strong><?php xl('SYSTEMS INTERVENTION GOALS: (Check all that apply)','e')?></strong>
     </td></tr>
	 <tr><td align="center">
	 <strong><?php xl('CARDIOVASCULAR','e')?></strong>
	 </td></tr>
	 
	 <tr><td>
	 <strong><u><?php xl('SN TO ASSESS FOR','e')?></u></strong> &nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Purpose, dose, frequency and SE of medications" /><?php xl('Purpose, dose, frequency and SE of medications','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Barriers to compliance" /><?php xl('Barriers to compliance','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Orthostatic hyper/hypo tension" /><?php xl('Orthostatic hyper/hypo tension','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="SOB" /><?php xl('SOB','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Cough" /><?php xl('Cough','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="JVD/heptojugular reflex" /><?php xl('JVD/heptojugular reflex','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Peripheral pulses" /><?php xl('Peripheral pulses','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Abnormal Lung Sounds" /><?php xl('Abnormal Lung Sounds','e')?>&nbsp;&nbsp;&nbsp;
	 <input type="checkbox" style="display:none;visibility:hidden;" name="careplan_SN_CARDIO_Assess[]"  value="Weight" /><?php xl('Weight','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="gain" /><?php xl('gain','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="loss" /><?php xl('loss','e')?>&nbsp;&nbsp;&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Abnormal Heart Sounds" /><?php xl('Abnormal Heart Sounds','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Chest Pain" /><?php xl('Chest Pain','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Edema/Fluid Retention" /><?php xl('Edema/Fluid Retention','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Neck/Vein Distention" /><?php xl('Neck/Vein Distention','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Peripheral Pulses" /><?php xl('Peripheral Pulses','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Assess[]"  value="Use of incentive spirometer" /><?php xl('Use of incentive spirometer','e')?>&nbsp;
	 <br>
	 <?php xl('Other','e')?>&nbsp;
     <input type="text" style="width:93%" name="careplan_SN_CARDIO_Assess_Other" id="careplan_SN_CARDIO_Assess_Other" />
	 </td></tr>
	 
	 <tr><td>
	 <strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Fluid detection" /><?php xl('Fluid detection','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Fluid restriction to" /><?php xl('Fluid restriction to','e')?>&nbsp;
	 <input type="text" style="width:8%" name="careplan_SN_CARDIO_Teach_Fluid" id="careplan_SN_CARDIO_Teach_Fluid" />
	 <?php xl('cc/day','e')?>&nbsp;&nbsp;&nbsp;&nbsp;
	 <?php xl('Self monitoring of vital signs including','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Blood Pressure" /><?php xl('Blood Pressure','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Pulse" /><?php xl('Pulse','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Weights" /><?php xl('Weights','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="S/Sxs of disease process" /><?php xl('S/Sxs of disease process','e')?>&nbsp;
	 <?php xl(', including management, controlling risk factors and identification of complications of','e')?>&nbsp;
	 <input type="text" style="width:20%" name="careplan_SN_CARDIO_Teach_Complications" id="careplan_SN_CARDIO_Teach_Complications" />&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Benefits of lifestyle change including exercise, nutrition, and/or energy conservation" /><?php xl('Benefits of lifestyle change including exercise, nutrition, and/or energy conservation.','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Avoid straining" /><?php xl('Avoid straining','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Avoid lifting > 10 lbs" /><?php xl('Avoid lifting > 10 lbs','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Slow posture changes" /><?php xl('Slow posture changes','e')?>&nbsp;
	 <input type="checkbox" name="careplan_SN_CARDIO_Teach[]"  value="Care of edematous extremities" /><?php xl('Care of edematous extremities','e')?>&nbsp;
	 <?php xl('Other','e')?>&nbsp;
     <input type="text" style="width:44%" name="careplan_SN_CARDIO_Teach_Other" id="careplan_SN_CARDIO_Teach_Other" />
	 </td></tr>
	 
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_CARDIO_PtPcgGoals[]"  value="Demonstrate and verbalize and understanding about cardiovascular disease management by" /><?php xl('Demonstrate and verbalize and understanding about cardiovascular disease management by','e')?>&nbsp;
	<?php echo goals_date('cardi0_cal1'); ?>
	<br>
	<input type="checkbox" name="careplan_SN_CARDIO_PtPcgGoals[]"  value="Weigh q day and record by" /><?php xl('Weigh q day and record by','e')?>&nbsp;
	<?php echo goals_date('cardi0_cal2'); ?>
	&nbsp;
	<input type="checkbox" name="careplan_SN_CARDIO_PtPcgGoals[]"  value="Verbalize understanding of benefits of lifestyle change including exercise, nutrition and/or energy conservation by" /><?php xl('Verbalize understanding of benefits of lifestyle change including exercise, nutrition and/or energy conservation by','e')?>&nbsp;
	<?php echo goals_date('cardi0_cal3'); ?>
	&nbsp;
	<input type="checkbox" name="careplan_SN_CARDIO_PtPcgGoals[]"  value="Demonstrate understanding of avoiding straining, heavy lifting and/or slow postural changes by" /><?php xl('Demonstrate understanding of avoiding straining, heavy lifting and/or slow postural changes by','e')?>&nbsp;
	<?php echo goals_date('cardi0_cal4'); ?>
	 &nbsp;<?php xl('Other','e')?>&nbsp;
    <input type="text" style="width:68%" name="careplan_SN_CARDIO_PtPcgGoals_Other" id="careplan_SN_CARDIO_PtPcgGoals_Other" />
	</td></tr>
	 
	<tr><td align="center">
	<strong><?php xl('ENDOCRINE','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS DIABETIC MANAGEMENT INCLUDING','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Glucometer Check every" /><?php xl('Glucometer Check every','e')?>&nbsp;
	<input type="text" style="width:8%" name="careplan_SN_ENDO_Assess_Hrs" id="careplan_SN_ENDO_Assess_Hrs" />
	<?php xl('Hrs','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Hyploglycemia" /><?php xl('Hyploglycemia','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Hyperglycemia" /><?php xl('Hyperglycemia','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Diet Compliance" /><?php xl('Diet Compliance','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Insulin Adminitration by" /><?php xl('Insulin Adminitration by','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Self" /><?php xl('Self','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Caregiver" /><?php xl('Caregiver','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Nurse" /><?php xl('Nurse','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
    <input type="text" style="width:35%" name="careplan_SN_ENDO_Admin_Other" id="careplan_SN_ENDO_Admin_Other" /><br>
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Response to therapeutic regimen" /><?php xl('Response to therapeutic regimen','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Compliance with dietary restrictions" /><?php xl('Compliance with dietary restrictions','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Weight loss/gain" /><?php xl('Weight loss/gain','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="Monitoring Blood Sugar Ranges and Frequencies" /><?php xl('Monitoring Blood Sugar Ranges and Frequencies','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Assess[]"  value="S/Sxs of disease process" /><?php xl('S/Sxs of disease process, including management, controlling risk factors and identification of complications such as','e')?>&nbsp;
	<input type="text" style="width:30%" name="careplan_SN_ENDO_Assess_Suchas" id="careplan_SN_ENDO_Assess_Suchas" />
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:60%" name="careplan_SN_ENDO_Assess_Other" id="careplan_SN_ENDO_Assess_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Pathophysiology of disease process" /><?php xl('Pathophysiology of disease process','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Purpose, dose, frequency and SE of medications" /><?php xl('Purpose, dose, frequency and SE of medications','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Diabetic regimen including" /><?php xl('Diabetic regimen including','e')?>&nbsp; 
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Insulin preparation" /><?php xl('Insulin preparation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Insulin injection" /><?php xl('Insulin injection','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Blood glucose testing, procedure and interpretation of results" /><?php xl('Blood glucose testing, procedure and interpretation of results','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Diet" /><?php xl('Diet','e')?>&nbsp;
	<input type="text" style="width:10%" name="careplan_SN_ENDO_cal_ada" id="careplan_SN_ENDO_cal_ada" />
	<?php xl('cal ADA','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Other diet" /><?php xl('Other diet','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_ENDO_Other_Diet" id="careplan_SN_ENDO_Other_Diet" />
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Foot care" /><?php xl('Foot care','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Exercise" /><?php xl('Exercise','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="S/S to report to MD" /><?php xl('S/S to report to MD','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="S/S hyper-hypo glycemia and actions to take" /><?php xl('S/S hyper-hypo glycemia and actions to take','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Teach[]"  value="Long term disease management" /><?php xl('Long term disease management','e')?>&nbsp;
    </td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Perform[]"  value="Finger stick for blood glucose" /><?php xl('Finger stick for blood glucose','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_Perform[]"  value="Administer (SQ.)" /><?php xl('Administer (SQ.)','e')?>&nbsp;
	<input type="text" style="width:10%" name="careplan_SN_ENDO_Perform_Insulin" id="careplan_SN_ENDO_Perform_Insulin" />
	<?php xl('of insulin','e')?>&nbsp;&nbsp;&nbsp;
	<?php xl('Freq.','e')?>&nbsp;
	<input type="text" style="width:10%" name="careplan_SN_ENDO_Perform_Freq" id="careplan_SN_ENDO_Perform_Freq" />
	<input type="checkbox" name="careplan_SN_ENDO_Perform[]"  value="Report significant changes to MD" /><?php xl('Report significant changes to MD.','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:74%" name="careplan_SN_ENDO_Perform_Other" id="careplan_SN_ENDO_Perform_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Demonstrate and verbalize an understanding about diabetic management" /><?php xl('Demonstrate and verbalize an understanding about diabetic management by','e')?>&nbsp;
	<?php echo goals_date('endo_cal1'); ?><br>
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Demonstrate independence in managing diabetic regimen including insuling preparation" /><?php xl('Demonstrate independence in managing diabetic regimen including insuling preparation, injection, blood glucose testing and interpretation by','e')?>&nbsp;
	<?php echo goals_date('endo_cal2'); ?><br>
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Verbalize an understanding that they must notify MD when blood sugar reaches" /><?php xl('Verbalize an understanding that they must notify MD when blood sugar reaches','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_ENDO_PCgGoals_text1" id="careplan_SN_ENDO_PCgGoals_text1" />
	<?php xl('by','e')?>&nbsp;
	<?php echo goals_date('endo_cal3'); ?><br>
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Demonstrate and verbalize understanding of S/Sx of hypo/hyperglycemia and appropriate actions to take" /><?php xl('Demonstrate and verbalize understanding of S/Sx of hypo/hyperglycemia and appropriate actions to take by','e')?>&nbsp;
	<?php echo goals_date('endo_cal4'); ?><br>
	<input type="checkbox" name="careplan_SN_ENDO_PCgGoals[]"  value="Demonstrate and verbalize understanding of long term disease management" /><?php xl('Demonstrate and verbalize understanding of long term disease management including skin and foot care, s/sx of anemia, bleeding precautions, diet and exercise by','e')?>&nbsp;
	<?php echo goals_date('endo_cal5'); ?><br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_ENDO_PCgGoals_Other" id="careplan_SN_ENDO_PCgGoals_Other" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('GASTROINTESTINAL','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="GT management including" /><?php xl('GT management including','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="site condition" /><?php xl('site condition','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="tube size/type" /><?php xl('tube size/type','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="flushing" /><?php xl('flushing','e')?>&nbsp;&nbsp;&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="Ostomy site management including" /><?php xl('Ostomy site management including','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="Stoma size, appearance, need for appliance" /><?php xl('Stoma size, appearance, need for appliance','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="Diet Management" /><?php xl('Diet Management','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="Elimination patterns" /><?php xl('Elimination patterns','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="Bowel sounds/distension/bloating" /><?php xl('Bowel sounds/distension/bloating','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="Pain,/nausea/vomiting" /><?php xl('Pain,/nausea/vomiting','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Assess[]"  value="Compliance/effectiveness of bowel regimen" /><?php xl('Compliance/effectiveness of bowel regimen','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GASTRO_Other" id="careplan_SN_GASTRO_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Bowel regimen to prevent constipation/diarrhea including dietary modification" /><?php xl('Bowel regimen to prevent constipation/diarrhea including dietary modification','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="S/Sxs of disease process, including management" /><?php xl('S/Sxs of disease process, including management, controlling risk factors and identification of complications such as','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Suchas" id="careplan_SN_GASTRO_Suchas" />
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Diarrhea/Vomiting" /><?php xl('Diarrhea/Vomiting','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Nausea/Vomiting" /><?php xl('Nausea/Vomiting','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Ostomy care" /><?php xl('Ostomy care','e')?>&nbsp;
    <input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Administration of Ostomy Irrigation Freq" /><?php xl('Administration of Ostomy Irrigation Freq.','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Teach_Freq" id="careplan_SN_GASTRO_Teach_Freq" />
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="S/S GI bleed" /><?php xl('S/S GI bleed','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Tube care and feeding" /><?php xl('Tube care and feeding via.','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="GT" /><?php xl('GT','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="JT" /><?php xl('JT','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Pt/PCg on Dietary Options including" /><?php xl('Pt/PCg on Dietary Options including','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Low sodium" /><?php xl('Low sodium','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Low Fat" /><?php xl('Low Fat','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Calorie Restrictions" /><?php xl('Calorie Restrictions','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Teach[]"  value="Renal Diet" /><?php xl('Renal Diet','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GASTRO_Teach_Other" id="careplan_SN_GASTRO_Teach_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Ostomy irrigation Freq" /><?php xl('Ostomy irrigation Freq.','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Perform_Freq" id="careplan_SN_GASTRO_Perform_Freq" />
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Perform rectal exam, manual removal of impaction" /><?php xl('Perform rectal exam, manual removal of impaction, follow up','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Perform_followup" id="careplan_SN_GASTRO_Perform_followup" />
	<?php xl('enemas PRN.','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Administer tube feeding" /><?php xl('Administer tube feeding','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Test stool for guaic" /><?php xl('Test stool for guaic','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_Perform[]"  value="Administer B12" /><?php xl('Administer B12','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Perform_admin" id="careplan_SN_GASTRO_Perform_admin" />
	<?php xl('Freq.','e')?>&nbsp;
	<input type="text" style="width:16%" name="careplan_SN_GASTRO_Perform_admin_freq" id="careplan_SN_GASTRO_Perform_admin_freq" />
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:75%" name="careplan_SN_GASTRO_Perform_Other" id="careplan_SN_GASTRO_Perform_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Demonstrate and verbalize an understanding about GI Management" /><?php xl('Demonstrate and verbalize an understanding about GI Management by','e')?>&nbsp;
	<?php echo goals_date('gastro_cal1'); ?>
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Demonstrate and verbalize understanding of bowel regimen" /><?php xl('Demonstrate and verbalize understanding of bowel regimen','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Demonstrate and verbalize understanding of Ostomy care" /><?php xl('Demonstrate and verbalize understanding of Ostomy care','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Demonstrate and verbalize understanding of tube care and feeding" /><?php xl('Demonstrate and verbalize understanding of tube care and feeding','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Verbalize understanding of dietary options" /><?php xl('Verbalize understanding of dietary options','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Verbalize understanding and management of disease complications including GI bleed, Diarrhea" /><?php xl('Verbalize understanding and management of disease complications including GI bleed, Diarrhea','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Nausea" /><?php xl('Nausea','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GASTRO_PcGoals[]"  value="Vomiting" /><?php xl('Vomiting','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:55%" name="careplan_SN_GASTRO_PcGoals_Other" id="careplan_SN_GASTRO_PcGoals_Other" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('GENITOURINARY','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Assess[]"  value="GU Status" /><?php xl('GU Status','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Assess[]"  value="Integumentary Status" /><?php xl('Integumentary Status','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Assess[]"  value="Nutrition / hydration" /><?php xl('Nutrition / hydration','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Assess[]"  value="S/S of UTI Incontinence" /><?php xl('S/S of UTI Incontinence','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Assess[]"  value="Bladder spasms: freq. & intensity" /><?php xl('Bladder spasms: freq. & intensity','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Assess[]"  value="Retention/ Weakness" /><?php xl('Retention/ Weakness','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:55%" name="careplan_SN_GENITO_Assess_Other" id="careplan_SN_GENITO_Assess_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Pathophysiology of disease process" /><?php xl('Pathophysiology of disease process','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Action and SE of medications" /><?php xl('Action and SE of medications','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Relationship of fluid intake to UTI" /><?php xl('Relationship of fluid intake to UTI','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="S/S of UTI" /><?php xl('S/S of UTI','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="S/S to report to MD" /><?php xl('S/S to report to MD','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Maintenance of skin integrity" /><?php xl('Maintenance of skin integrity','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Foley catheter care" /><?php xl('Foley catheter care','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Condom catheter use and change" /><?php xl('Condom catheter use and change','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Self Catheterization" /><?php xl('Self Catheterization','e')?>&nbsp;
	&nbsp;&nbsp;&nbsp;<?php xl('Freq.','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_GENITO_Teach_Freq" id="careplan_SN_GENITO_Teach_Freq" />
	<input type="checkbox" name="careplan_SN_GENITO_Teach[]"  value="Urostomy/ileo-conduit care" /><?php xl('Urostomy/ileo-conduit care','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GENITO_Teach_Other" id="careplan_SN_GENITO_Teach_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Perform[]"  value="Insert/change Foley catheter" /><?php xl('Insert/change Foley catheter','e')?>&nbsp;&nbsp;&nbsp;
	<?php xl('Size','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_GENITO_Perform_size" id="careplan_SN_GENITO_Perform_size" />
	<?php xl('Every 28 -32 days and PRN malfunction per sterile technique.','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Perform[]"  value="Obtain specimen UA, C& S" /><?php xl('Obtain specimen UA, C& S as ','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_GENITO_Perform_ordered" id="careplan_SN_GENITO_Perform_ordered" />
	<?php xl('ordered','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_Perform[]"  value="Perform straight catheterization for residual/obtain sterile specimen" /><?php xl('Perform straight catheterization for residual/obtain sterile specimen.','e')?>&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:80%" name="careplan_SN_GENITO_Perform_Other" id="careplan_SN_GENITO_Perform_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENITO_PcgGoals[]"  value="Urinary elimination will be WNL" /><?php xl('Urinary elimination will be WNL by','e')?>&nbsp;
	<?php echo goals_date('genito_cal1'); ?>
	<input type="checkbox" name="careplan_SN_GENITO_PcgGoals[]"  value="Will be free of s/sx of UTI" /><?php xl('Will be free of s/sx of UTI by','e')?>&nbsp;
	<?php echo goals_date('genito_cal2'); ?>
	<input type="checkbox" name="careplan_SN_GENITO_PcgGoals[]"  value="Will verbalize understanding of incontinence without skin breakdown" /><?php xl('Will verbalize understanding of incontinence without skin breakdown by','e')?>&nbsp;
	<?php echo goals_date('genito_cal3'); ?>
	<input type="checkbox" name="careplan_SN_GENITO_PcgGoals[]"  value="Will demonstrate ability to manage ostomy/catheter independently" /><?php xl('Will demonstrate ability to manage ostomy/catheter independently by','e')?>&nbsp;
	<?php echo goals_date('genito_cal4'); ?>
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:53%" name="careplan_SN_GENITO_PcgGoals_Other" id="careplan_SN_GENITO_PcgGoals_Other" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('INTEGUMENTARY','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Skin integrity" /><?php xl('Skin integrity','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Potential for skin breakdown" /><?php xl('Potential for skin breakdown','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Diaphoretic" /><?php xl('Diaphoretic','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Rash" /><?php xl('Rash','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Lesion" /><?php xl('Lesion','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Turgor" /><?php xl('Turgor','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Skin Tears" /><?php xl('Skin Tears','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Wound(s) Characteristics (Refer to Wound Assessment )" /><?php xl('Wound(s) Characteristics (Refer to Wound Assessment )','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Assess[]"  value="Wound Healing and/or Infection" /><?php xl('Wound Healing and/or Infection','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_INTEGU_Assess_Other" id="careplan_SN_INTEGU_Assess_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Teach[]"  value="Skin care" /><?php xl('Skin care','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Teach[]"  value="Positioning for comfort/pressure relief" /><?php xl('Positioning for comfort/pressure relief','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Teach[]"  value="Infection control/universal precautions" /><?php xl('Infection control/universal precautions','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Teach[]"  value="Protective dressings" /><?php xl('Protective dressings','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Teach[]"  value="Wound Care Management" /><?php xl('Wound Care Management','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_INTEGU_Teach_Other" id="careplan_SN_INTEGU_Teach_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_Perform"  value="Wound/Decubitus Care" /><?php xl('Wound/Decubitus Care to:','e')?>&nbsp;
	<?php xl('Locations','e')?>&nbsp;
	<input type="text" style="width:30%" name="careplan_SN_INTEGU_Perform_location" id="careplan_SN_INTEGU_Perform_location" />
	<?php xl('Freq','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_INTEGU_Perform_Freq" id="careplan_SN_INTEGU_Perform_Freq" />
	<?php xl('Clean/Irrigate With','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_INTEGU_Perform_Clean" id="careplan_SN_INTEGU_Perform_Clean" />
	<?php xl('Pack With','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_INTEGU_Perform_Pack" id="careplan_SN_INTEGU_Perform_Pack" />
	<?php xl('Apply','e')?>&nbsp;
	<input type="text" style="width:30%" name="careplan_SN_INTEGU_Perform_Apply" id="careplan_SN_INTEGU_Perform_Apply" />
	<?php xl('Cover With','e')?>&nbsp;
	<input type="text" style="width:30%" name="careplan_SN_INTEGU_Perform_Cover" id="careplan_SN_INTEGU_Perform_Cover" />
	<?php xl('Secure With','e')?>&nbsp;
	<input type="text" style="width:50%" name="careplan_SN_INTEGU_Perform_Secure" id="careplan_SN_INTEGU_Perform_Secure" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_PcgGoals[]"  value="Wound(s) will improve in the following areas" /><?php xl('Wound(s) will improve in the following areas','e')?>&nbsp;
	<input type="text" style="width:32%" name="careplan_SN_INTEGU_PcgGoals_areas" id="careplan_SN_INTEGU_PcgGoals_areas" />
	<?php xl('by','e')?>
	<?php echo goals_date('integu_cal1'); ?><br>
	<input type="checkbox" name="careplan_SN_INTEGU_PcgGoals[]"  value="Wound will be free of s/sx of infection" /><?php xl('Wound will be free of s/sx of infection by','e')?>&nbsp;
	<?php echo goals_date('integu_cal2'); ?>&nbsp;&nbsp;&nbsp;
	<input type="checkbox" name="careplan_SN_INTEGU_PcgGoals[]"  value="Will demonstrate proper skin/wound care and positioning" /><?php xl('Will demonstrate proper skin/wound care and positioning by','e')?>&nbsp;
	<?php echo goals_date('integu_cal3'); ?>
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:77%" name="careplan_SN_INTEGU_PcgGoals_Other" id="careplan_SN_INTEGU_PcgGoals_Other" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('MUSCULOSKELETAL/MOBILITY','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Assess[]"  value="Musculo-skeletal status r/t mobility and endurance" /><?php xl('Musculo-skeletal status r/t mobility and endurance','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Assess[]"  value="Need for assistive devices" /><?php xl('Need for assistive devices','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Assess[]"  value="Ability to perform ADLs" /><?php xl('Ability to perform ADLs','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Assess[]"  value="Safety in Mobility" /><?php xl('Safety in Mobility','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Assess[]"  value="Need for PT, OT Intervention" /><?php xl('Need for PT, OT Intervention','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Assess[]"  value="Strength and Endurance in ADLs" /><?php xl('Strength and Endurance in ADLs','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Assess[]"  value="Joint Range of Motion" /><?php xl('Joint Range of Motion','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Assess[]"  value="Fall Risks" /><?php xl('Fall Risks','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_MUSCULO_Assess_Other" id="careplan_SN_MUSCULO_Assess_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="Complications of decreased mobility" /><?php xl('Complications of decreased mobility','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="Safe transfers and ambulation" /><?php xl('Safe transfers and ambulation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="Purpose, proper admin. & S/E of pain control meds" /><?php xl('Purpose, proper admin. & S/E of pain control meds','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="S/S to report to M.D" /><?php xl('S/S to report to M.D','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="ROM/Strength Exercises for Maintenance" /><?php xl('ROM/Strength Exercises for Maintenance','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="Proper Body Alignment" /><?php xl('Proper Body Alignment','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="Measures to Promote Circulation" /><?php xl('Measures to Promote Circulation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="Proper use of Adaptive Equipment and Assistive Devices" /><?php xl('Proper use of Adaptive Equipment and Assistive Devices','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Teach[]"  value="Educate on role of medications and safe practices to prevent falls" /><?php xl('Educate on role of medications and safe practices to prevent falls','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_MUSCULO_Teach_Other" id="careplan_SN_MUSCULO_Teach_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Perform_Venipuncture"  value="Venipuncture for Lab work as ordered by M.D" /><?php xl('Venipuncture for Lab work as ordered by M.D.','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_Perform_staples"  value="Remove staples" /><?php xl('Remove staples','e')?>&nbsp;
	<br>
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_MUSCULO_Perform_Other" id="careplan_SN_MUSCULO_Perform_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MUSCULO_PcgGoals[]"  value="Will be able to verbalize an understanding of falls prevention" /><?php xl('Will be able to verbalize an understanding of falls prevention by','e')?>&nbsp;
	<?php echo goals_date('musculo_cal1'); ?>
	<input type="checkbox" name="careplan_SN_MUSCULO_PcgGoals[]"  value="Able to demonstrate safe transfers" /><?php xl('Able to demonstrate safe transfers by','e')?>&nbsp;
	<?php echo goals_date('musculo_cal2'); ?>
	<input type="checkbox" name="careplan_SN_MUSCULO_PcgGoals[]"  value="Able to demonstrate proper circulatory care" /><?php xl('Able to demonstrate proper circulatory care by','e')?>&nbsp;
	<?php echo goals_date('musculo_cal3'); ?>
	<input type="checkbox" name="careplan_SN_MUSCULO_PcgGoals[]"  value="Able to demonstrate proper use of Assistive devices and/or Adaptive Equipment" /><?php xl('Able to demonstrate proper use of Assistive devices and/or Adaptive Equipment by','e')?>&nbsp;
	<?php echo goals_date('musculo_cal4'); ?>
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:36%" name="careplan_SN_MUSCULO_PcgGoals_Other" id="careplan_SN_MUSCULO_PcgGoals_Other" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('MENTAL/EMOTIONAL','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Assess[]"  value="Need for Medical Social Worker Intervention" /><?php xl('Need for Medical Social Worker Intervention','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Assess[]"  value="Impact of Cognitive Impairment to independent living" /><?php xl('Impact of Cognitive Impairment to independent living','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Assess[]"  value="Mood related to depression, isolation, and/or anxiety and impact on daily living" /><?php xl('Mood related to depression, isolation, and/or anxiety and impact on daily living','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Assess[]"  value="Suicidal Ideation" /><?php xl('Suicidal Ideation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Assess[]"  value="Schizo Affective Disorders impact on self and home management" /><?php xl('Schizo Affective Disorders impact on self and home management','e')?>&nbsp;
	&nbsp;&nbsp;&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:76%" name="careplan_SN_MENTAL_Assess_Other" id="careplan_SN_MENTAL_Assess_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Teach[]"  value="Role of Medical Social Worker with mental/emotional issues" /><?php xl('Role of Medical Social Worker with mental/emotional issues','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Teach[]"  value="Compensatory strategies with cognitive impairment" /><?php xl('Compensatory strategies with cognitive impairment','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Teach[]"  value="Compensatory strategies in medication management" /><?php xl('Compensatory strategies in medication management','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Teach[]"  value="How Medication can impact mood disorders" /><?php xl('How Medication can impact mood disorders','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_Teach[]"  value="Stress management techniques and coping skills" /><?php xl('Stress management techniques and coping skills','e')?>&nbsp;
	&nbsp;&nbsp;&nbsp;
	<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:60%" name="careplan_SN_MENTAL_Teach_Other" id="careplan_SN_MENTAL_Teach_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_MENTAL_PcgGoals[]"  value="Demonstrate organized method of remembering medications" /><?php xl('Demonstrate organized method of remembering medications by','e')?>&nbsp;
	<?php echo goals_date('mental_cal1'); ?>
	<input type="checkbox" name="careplan_SN_MENTAL_PcgGoals[]"  value="Verbalize role of Medical Social Worker and how can assist with mood disorders" /><?php xl('Verbalize role of Medical Social Worker and how can assist with mood disorders by','e')?>&nbsp;
	<?php echo goals_date('mental_cal2'); ?>
	<input type="checkbox" name="careplan_SN_MENTAL_PcgGoals[]"  value="Verbalize understanding of role of medications and their impact on mood disorders" /><?php xl('Verbalize understanding of role of medications and their impact on mood disorders by','e')?>&nbsp;
	<?php echo goals_date('mental_cal3'); ?>
	<input type="checkbox" name="careplan_SN_MENTAL_PcgGoals[]"  value="Demonstrate and verbalize understanding of incorporating stress management techniques in daily living" /><?php xl('Demonstrate and verbalize understanding of incorporating stress management techniques in daily living','e')?>&nbsp;
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:50%" name="careplan_SN_MENTAL_PcgGoals_Other" id="careplan_SN_MENTAL_PcgGoals_Other" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('NEUROLOGICAL','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="Seizure activity, notify MD for activity greater than" /><?php xl('Seizure activity, notify MD for activity greater than','e')?>&nbsp;
	<input type="text" style="width:10%" name="careplan_SN_NEURO_Assess_minutes" id="careplan_SN_NEURO_Assess_minutes" />
	<?php xl('minutes','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="LOC/Orientation" /><?php xl('LOC/Orientation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="Speech comprehension and expression" /><?php xl('Speech comprehension and expression','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="Neurological motor and sensory system" /><?php xl('Neurological motor and sensory system','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Assess[]"  value="Swallow Difficulty" /><?php xl('Swallow Difficulty','e')?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_NEURO_Assess_Other" id="careplan_SN_NEURO_Assess_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Teach[]"  value="Seizure Precautions" /><?php xl('Seizure Precautions','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Teach[]"  value="Caregiver assessment of LOC with patient" /><?php xl('Caregiver assessment of LOC with patient','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Teach[]"  value="Caregiver in Reality Orientation" /><?php xl('Caregiver in Reality Orientation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Teach[]"  value="Caregiver in S/Sx of CVA" /><?php xl('Caregiver in S/Sx of CVA','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Teach[]"  value="Environmental Adaptations based on Visual Impairment" /><?php xl('Environmental Adaptations based on Visual Impairment','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_Teach[]"  value="Compensatory Swallow Techniques" /><?php xl('Compensatory Swallow Techniques','e')?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_NEURO_Teach_Other" id="careplan_SN_NEURO_Teach_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Verbalize understanding of seizure management" /><?php xl('Verbalize understanding of seizure management by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal1'); ?>
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Demontrate assessing LOC/Orientation" /><?php xl('Demontrate assessing LOC/Orientation by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal2'); ?>
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Demonstrating activities for Reality Orientation" /><?php xl('Demonstrating activities for Reality Orientation by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal3'); ?>
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Verbalize understanding of S/Sx of CVA" /><?php xl('Verbalize understanding of S/Sx of CVA by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal4'); ?>
	<input type="checkbox" name="careplan_SN_NEURO_PcgGoals[]"  value="Demonstrate Swallow Techniques during eating" /><?php xl('Demonstrate Swallow Techniques during eating by','e')?>&nbsp;
	<?php echo goals_date('neuro_cal5'); ?>
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_NEURO_PcgGoals_Other" id="careplan_SN_NEURO_PcgGoals_Other" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('RESPIRATORY','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Pt. Increase/Decrease respiratory function" /><?php xl('Pt. Increase/Decrease respiratory function','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="S/S of infection" /><?php xl('S/S of infection','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Lung Sounds Clear" /><?php xl('Lung Sounds Clear','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Abnormal Breath Sounds" /><?php xl('Abnormal Breath Sounds','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Cough/Sputum" /><?php xl('Cough/Sputum','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="O2 Liters" /><?php xl('O2 Liters','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Pallor/Cyanosis" /><?php xl('Pallor/Cyanosis','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Respiration Labored" /><?php xl('Respiration Labored','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Respiration Unlabored" /><?php xl('Respiration Unlabored','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Pulse Oximetry" /><?php xl('Pulse Oximetry','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Assess[]"  value="Notify MD for pulse oximetry reading is less than 88% after 2 minute rest" /><?php xl('Notify MD for pulse oximetry reading is <88% after 2 minute rest','e')?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_RESPIR_Assess_Other" id="careplan_SN_RESPIR_Assess_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Pulmonary hygiene" /><?php xl('Pulmonary hygiene','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Pursed lip breathing" /><?php xl('Pursed lip breathing','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Use of nebulizer/aerosol inhaler" /><?php xl('Use of nebulizer/aerosol inhaler','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Postural drainage and percussion" /><?php xl('Postural drainage and percussion','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Safe use of oxygen & care of equipment" /><?php xl('Safe use of oxygen & care of equipment','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Maintenance of patent airway" /><?php xl('Maintenance of patent airway','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Suctioning" /><?php xl('Suctioning','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Anxiety management" /><?php xl('Anxiety management','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Trach care" /><?php xl('Trach care','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Maintaining nasal cannula and/or c-pap" /><?php xl('Maintaining nasal cannula and/or c-pap','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="Energy Conservation" /><?php xl('Energy Conservation','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Teach[]"  value="S/Sx of respiratory distress" /><?php xl('S/Sx of respiratory distress','e')?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_RESPIR_Teach_Other" id="careplan_SN_RESPIR_Teach_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO PERFORM','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_Perform"  value="Chest physio-therapy" /><?php xl('Chest physio-therapy','e')?>&nbsp;
	&nbsp;<?php xl('frequency','e')?>&nbsp;
	<input type="text" style="width:20%" name="careplan_SN_RESPIR_Perform_Freq" id="careplan_SN_RESPIR_Perform_Freq" />
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:31%" name="careplan_SN_RESPIR_Perform_Other" id="careplan_SN_RESPIR_Perform_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Able to demonstrate clear lund sounds" /><?php xl('Able to demonstrate clear lund sounds by','e')?>&nbsp;
	<?php echo goals_date('respir_cal1'); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Free of Respiratory Infection" /><?php xl('Free of Respiratory Infection by','e')?>&nbsp;
	<?php echo goals_date('respir_cal2'); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Able to demonstrate Respiratory exercises including pursed lip breathing, cough and sputum management" /><?php xl('Able to demonstrate Respiratory exercises including pursed lip breathing, cough and sputum management by','e')?>&nbsp;
	<?php echo goals_date('respir_cal3'); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Able to demonstrate proper suction technique" /><?php xl('Able to demonstrate proper suction technique by','e')?>&nbsp;
	<?php echo goals_date('respir_cal4'); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="Able to verbalize understanding of oxygen safety and demonstrate oxygen equipment maintenance" /><?php xl('Able to verbalize understanding of oxygen safety and demonstrate oxygen equipment maintenance by','e')?>&nbsp;
	<?php echo goals_date('respir_cal5'); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_RESPIR_PcgGoals[]"  value="S/Sx of Dyspnea will decrease" /><?php xl('S/Sx of Dyspnea will decrease by','e')?>&nbsp;
	<?php echo goals_date('respir_cal6'); ?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_RESPIR_PcgGoals_Other" id="careplan_SN_RESPIR_PcgGoals_Other" />
	</td></tr>
	
	<tr><td align="center">
	<strong><?php xl('GENERAL MEDICAL','e')?></strong>
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('SN TO ASSESS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Assess[]"  value="Appetite" /><?php xl('Appetite','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Assess[]"  value="Weight Gain/Loss" /><?php xl('Weight Gain/Loss','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Assess[]"  value="Pain Level" /><?php xl('Pain Level','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Assess[]"  value="Effectiveness of current pain regimen" /><?php xl('Effectiveness of current pain regimen','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Assess[]"  value="Medication management" /><?php xl('Medication management','e')?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GENERAL_Assess_Other" id="careplan_SN_GENERAL_Assess_Other" />
	</td></tr> 
	
	<tr><td>
	<strong><u><?php xl('SN TO TEACH/TRAIN','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Teach[]"  value="Medication management" /><?php xl('Medication management','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Teach[]"  value="Dietary resources" /><?php xl('Dietary resources','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Teach[]"  value="Pharmacological approaches to pain management" /><?php xl('Pharmacological approaches to pain management','e')?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_Teach[]"  value="Non pharmacological approaches to pain management" /><?php xl('Non pharmacological approaches to pain management','e')?>&nbsp;
	&nbsp;&nbsp;&nbsp;<?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:56%" name="careplan_SN_GENERAL_Teach_Other" id="careplan_SN_GENERAL_Teach_Other" />
	</td></tr>
	
	<tr><td>
	<strong><u><?php xl('PT/PCg GOALS','e')?></u></strong> &nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_PcgGoals[]"  value="Will be able to demonstrate ability to manage medications" /><?php xl('Will be able to demonstrate ability to manage medications by','e')?>&nbsp;
	<?php echo goals_date('general_cal1'); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_PcgGoals[]"  value="Able to verbalize dietary options" /><?php xl('Able to verbalize dietary options by','e')?>&nbsp;
	<?php echo goals_date('general_cal2'); ?>&nbsp;
	<input type="checkbox" name="careplan_SN_GENERAL_PcgGoals[]"  value="Verbalize non-pharmacological approaches to pain management" /><?php xl('Verbalize non-pharmacological approaches to pain management by','e')?>&nbsp;
	<?php echo goals_date('general_cal3'); ?>&nbsp;
	<br><?php xl('Other','e')?>&nbsp;
	<input type="text" style="width:93%" name="careplan_SN_GENERAL_PcgGoals_Other" id="careplan_SN_GENERAL_PcgGoals_Other" />
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
			echo $c->default_action();
	  ?>
	<table width="100%" border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
	<tr>
	 <th scope="row"><?php xl('Wound','e')?>
	 <td align="center"><?php xl('#','e')?></td>
	 <td align="center"><?php xl('#','e')?></td>
	 <td align="center"><?php xl('#','e')?></td>
	 <td align="center"><?php xl('#','e')?></td>
	 <td align="center"><?php xl('Comments','e')?></td>
	</tr>
	
  <tr>
    <th scope="row" align="right"><?php xl('Type of Wound','e')?> <input type="hidden" name="wound_label[]" value="Type of Wound" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
    <td rowspan="12"><textarea name="Interventions" cols="30" rows="15"></textarea></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Status','e')?> <input type="hidden" name="wound_label[]" value="Wound Status" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Measurements Length','e')?> <input type="hidden" name="wound_label[]" value="Measurements Length" /><br />
 <?php xl('Width','e')?><input type="hidden" name="wound_label[]" value="Measurements Width" /> <br />
 <?php xl('Depth','e')?><input type="hidden" name="wound_label[]" value="Measurements Depth" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /> <br /><input name="wound_value1[]" type="text" size="12" /> <br /><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /> <br /><input name="wound_value2[]" type="text" size="12" /> <br /><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /> <br /><input name="wound_value3[]" type="text" size="12" /> <br /><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /> <br /><input name="wound_value4[]" type="text" size="12" /> <br /><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Pressure Sore Stage','e')?> <input type="hidden" name="wound_label[]" value="Pressure Sore Stage" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tunneling','e')?> <input type="hidden" name="wound_label[]" value="Tunneling" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Undermining','e')?> <input type="hidden" name="wound_label[]" value="Undermining" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Drainage','e')?> <input type="hidden" name="wound_label[]" value="Drainage" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Amount of Drainage','e')?> <input type="hidden" name="wound_label[]" value="Amount of Drainage" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Odor','e')?> <input type="hidden" name="wound_label[]" value="Odor" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Wound Base','e')?> <input type="hidden" name="wound_label[]" value="Tissue of Wound Base" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Surround Wound','e')?> <input type="hidden" name="wound_label[]" value="Tissue of Surround Wound" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Level of Pain with Wound','e')?> <input type="hidden" name="wound_label[]" value="Level of Pain with Wound" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
</table>			 

<table width="100%" border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
  <tr>
	 <th scope="row"><?php xl('Wound','e')?>
	 <td align="center"><?php xl('#','e')?></td>
	 <td align="center"><?php xl('#','e')?></td>
	 <td align="center"><?php xl('#','e')?></td>
	 <td align="center"><?php xl('#','e')?></td>
	 <td align="center"><?php xl('Comments','e')?></td>
	</tr>
  <tr>
    <th scope="row" align="right"><?php xl('Type of Wound','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
    <td rowspan="12"><textarea name="wound_comments" cols="30" rows="15"></textarea></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Status','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Measurements Length','e')?> <br />
<?php xl('Width','e')?>  <br />
<?php xl('Depth','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /> <br /><input name="wound_value5[]" type="text" size="12" /> <br /><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /> <br /><input name="wound_value6[]" type="text" size="12" /> <br /><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /> <br /><input name="wound_value7[]" type="text" size="12" /> <br /><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /> <br /><input name="wound_value8[]" type="text" size="12" /> <br /><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Pressure Sore Stage','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tunneling','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Undermining','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Drainage','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Amount of Drainage','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Odor','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Wound Base','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Surround Wound','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Level of Pain with Wound','e')?> </th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
</table>	 
<table width="100%" border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
<tr>
<td width="50%"><?php xl('Patient/Caregiver willing to provide wound care?','e')?>
<input type="checkbox" name="careplan_SN_WC_status" value="Yes" id="careplan_SN_WC_status" />
<?php xl('Yes','e'); ?>
<input type="checkbox" name="careplan_SN_WC_status" value="No" id="careplan_SN_WC_status" />
<?php xl('No','e'); ?> 
<br>&nbsp;
<?php xl('If, No explain','e'); ?> 
&nbsp;
<input type="text" style="width:72%" name="careplan_SN_provide_wound_care" id="careplan_SN_provide_wound_care" />
</td>
<td width="50%">
<?php xl('Physician is notified every two weeks of wound status','e')?>
<br>&nbsp;
<input type="text" style="width:90%" name="careplan_SN_wound_status" id="careplan_SN_wound_status" />
</td>
</tr></table>

<a id="btn_save" href="javascript:top.restoreSession();document.nursing_careplan.submit()" class="link_submit">
<?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
