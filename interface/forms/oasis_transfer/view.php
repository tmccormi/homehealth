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
$formTable = "forms_oasis_transfer";

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
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/css/jquery-ui-1.8.21.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!--For Form Validaion--><script src="<?php echo $GLOBALS['webroot'] ?>/library/js/form_validation.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function($) {
        var status = "";

        $("#signoff").fancybox({
        'scrolling'             : 'no',
        'titleShow'             : false,
        'onClosed'              : function() {
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
                type            : "POST",
                cache   : false,
                url             : "<?php echo $GLOBALS['rootdir'] . "/forms/$formDir/sign.php";?>",
                data            : $(this).serializeArray(),
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
$obj = formFetch("forms_oasis_transfer", $_GET["id"]);

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$oasistransfer_mental_status = explode("#",$obj{"oasistransfer_mental_status"});
$oasistransfer_functional_limitations = explode("#",$obj{"oasistransfer_functional_limitations"});
$oasistransfer_safety_measures = explode("#",$obj{"oasistransfer_safety_measures"});
$oasistransfer_dme_iv_supplies = explode("#",$obj{"oasistransfer_dme_iv_supplies"});
$oasistransfer_dme_foley_supplies = explode("#",$obj{"oasistransfer_dme_foley_supplies"});

?>
<form method="post"	action="<?php echo $rootdir;?>/forms/oasis_transfer/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="oasistransfer">
		<h3 align="center"><?php xl('OASIS-C TRANSFER','e')?></h3>
		<div><span class="formtable"><strong><?php xl('Patient:','e')?></strong>&nbsp;&nbsp;<label><?php patientName()?></label> </span>
<span style="float:right" class="formtable"><strong><?php xl('Caregiver:','e')?></strong><input type="text" name="oasistransfer_Caregiver" size="20" 
 value="<?php echo stripslashes($obj{"oasistransfer_Caregiver"});?>"/>
&nbsp;&nbsp;

<strong><?php xl('Start of Care Date:','e')?></strong>&nbsp;
<input type="text" name="oasistransfer_Visit_Date" id="oasistransfer_Visit_Date" size="12" value="<?php echo stripslashes($obj{"oasistransfer_Visit_Date"});?>" readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"oasistransfer_Visit_Date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>

   </span></div>
<br/>
<div align="right" class="formtable"> <?php xl('Time In:','e')?>
<select name="oasistransfer_Time_In" id="oasistransfer_Time_In"><?php timeDropDown(stripslashes($obj{"oasistransfer_Time_In"})) ?></select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Time Out:','e')?>
<select name="oasistransfer_Time_Out" id="oasistransfer_Time_Out"><?php timeDropDown(stripslashes($obj{"oasistransfer_Time_Out"})) ?></select>
</div>
<br/>	
<table border="1px">
<tr>
<td width="50%" valign="top">
<table class="formtable"> 
<tr> <td align="center"><center><b><?php xl('CLINICAL RECORD ITEMS','e')?></b></center></td> </tr>
<tr><td><hr/></td></tr>
<tr><td><b><u><?php xl('(M0080)','e')?></u><?php xl('Discipline of Person Completing Assessment','e')?></b></td></tr>
<tr><td> <input type="radio" name="oasistransfer_Discipline_of_Person_completing_Assessment" value="RN" 
<?php if ($obj{"oasistransfer_Discipline_of_Person_completing_Assessment"} == "RN"){echo "checked";};?> /><?php xl('1-RN','e')?>  &nbsp;&nbsp;&nbsp;
 <input type="radio" name="oasistransfer_Discipline_of_Person_completing_Assessment" value="PT"
 <?php if ($obj{"oasistransfer_Discipline_of_Person_completing_Assessment"} == "PT"){echo "checked";};?>/><?php xl('2-PT','e')?>  &nbsp;&nbsp;&nbsp;
 <input type="radio" name="oasistransfer_Discipline_of_Person_completing_Assessment" value="SLP/ST"
 <?php if ($obj{"oasistransfer_Discipline_of_Person_completing_Assessment"} == "SLP/ST"){echo "checked";};?>/><?php xl('3-SLP/ST','e')?>  &nbsp;&nbsp;&nbsp;
<input type="radio" name="oasistransfer_Discipline_of_Person_completing_Assessment" value="OT"
<?php if ($obj{"oasistransfer_Discipline_of_Person_completing_Assessment"} == "OT"){echo "checked";};?>/><?php xl('4-OT','e')?> </td> 
</tr>
<tr><td><hr></td></tr>
<tr>
<td>
<strong>
<?php xl('<u>(M0030)</u> Start of Care Date:','e');?></strong>
				<input type='text' size='10' name='oasis_therapy_soc_date' id='oasis_therapy_soc_date' 
					title='<?php xl('yyyy-mm-dd SOC Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasis_therapy_soc_date"};?>" readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date2' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
						Calendar.setup({inputField:"oasis_therapy_soc_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
					</script>
					<br>
	 </td>
</tr>
<tr><td><hr></td></tr>
<tr>
<td><b><u><?php xl('(M0090)','e')?></u> <?php xl('Date Assessment Completed','e')?> </b>

<input type="text" name="oasistransfer_Assessment_Completed_Date" size="10" title='<?php xl('yyyy-mm-dd Assessment Completed Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Assessment_Completed_Date" 
	value="<?php echo stripslashes($obj{"oasistransfer_Assessment_Completed_Date"});?>" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_Assess_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Assessment_Completed_Date", ifFormat:"%Y-%m-%d", button:"img_Assess_date"});
   </script>
	 </td>
</tr>
<tr><td><hr></td></tr>
<tr>
<td><b><?php xl('(M0100)This Assessment is Currently Being Completed for the Following Reason:','e')?> </b></td>
</tr>
<tr><td><b><u><?php xl('Transfer to an Inpatient Facility','e');?></u></b></td></tr>
<tr><td>
<input type="radio" id="m0100" name="oasistransfer_Transfer_to_an_InPatient_Facility" value="Patient_Not_Discharged_from_Agency"
<?php if ($obj{"oasistransfer_Transfer_to_an_InPatient_Facility"} == "Patient_Not_Discharged_from_Agency"){echo "checked";};?>/>
<?php xl('6-Transfered to an InPatient Facility-patient not discharged from agency','e')?> <b><?php xl('[Go To M1040]','e')?></b><br/>
<input type="radio" name="oasistransfer_Transfer_to_an_InPatient_Facility" value="Patient_Discharged_from_Agency"
<?php if ($obj{"oasistransfer_Transfer_to_an_InPatient_Facility"} == "Patient_Discharged_from_Agency"){echo "checked";};?>/>
<?php xl('7-Transfered to an InPatient Facility-patient discharged from agency','e')?> <b><?php xl('[Go To M1040]','e')?></b><br/>
<input type="radio" name="oasistransfer_Transfer_to_an_InPatient_Facility" value="Death_at_Home"  
<?php if ($obj{"oasistransfer_Transfer_to_an_InPatient_Facility"} == "Death_at_Home"){echo "checked";};?>/>
<?php xl('8-Death at Home','e')?> <b><?php xl('[Go To M0903]','e')?></b>
</td></tr>
<tr><td><hr></td></tr>

<tr><td><center><b><?php xl('PATIENT HISTORY AND DIAGNOSES','e')?></b></center></td></tr>
<tr><td><b><u><?php xl('(M1040)','e')?></u> 
<?php xl("Influenza Vaccine:",'e')?></b> <?php xl("Did the patient receive the influenza vaccine from your agency for this 
year's influenza season (October 1 through March 31) during this episode of care?",'e')?></td></tr>
<tr><td> <input type="radio" name="oasistransfer_Influenza_Vaccine_received" value="No"
<?php if ($obj{"oasistransfer_Influenza_Vaccine_received"} == "No"){echo "checked";};?>/>
<?php xl('0 - No','e')?> <br/>
<input type="radio" name="oasistransfer_Influenza_Vaccine_received" value="Yes" 
<?php if ($obj{"oasistransfer_Influenza_Vaccine_received"} == "Yes"){echo "checked";};?>/>
<?php xl('1 - Yes','e')?> <b><?php xl('[ Go to M1050 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Influenza_Vaccine_received" value="NA" 
<?php if ($obj{"oasistransfer_Influenza_Vaccine_received"} == "NA"){echo "checked";};?>/>
<?php xl('2 - NA - Does not apply because entire episode of care (SOC/ROC to
Transfer/Discharge) is outside this influenza season.','e')?> <b><?php xl('[ Go to M1050 ]','e')?></b>
</td></tr>

<tr><td><hr/></td></tr>

<tr><td><b><?php xl('(M1045) Reason Influenza Vaccine not received:','e')?></b><?php xl('If the patient did not receive the
influenza vaccine from your agency during this episode of care, state reason:','e')?>
</td></tr>

<tr><td>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Received_from_another_health_care_provider" 
<?php if ($obj{"oasistransfer_Reason_For_Influenza_Vaccine_Not_Received"} == "Received_from_another_health_care_provider"){echo "checked";};?>/>
<?php xl('1 - Received from another health care provider (e.g., physician)','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Received_from_your_agency_previuosly" 
<?php if ($obj{"oasistransfer_Reason_For_Influenza_Vaccine_Not_Received"} == "Received_from_your_agency_previuosly"){echo "checked";};?>/>
<?php xl("2 - Received from your agency previously during this year's flu season",'e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Offered_and_Declined"  
<?php if ($obj{"oasistransfer_Reason_For_Influenza_Vaccine_Not_Received"} == "Offered_and_Declined"){echo "checked";};?>/>
<?php xl('3 - Offered and declined','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Assessed_and_determined" 
<?php if ($obj{"oasistransfer_Reason_For_Influenza_Vaccine_Not_Received"} == "Assessed_and_determined"){echo "checked";};?>/>
<?php xl('4 - Assessed and determined to have medical contraindication(s)','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Not_indicated"  
<?php if ($obj{"oasistransfer_Reason_For_Influenza_Vaccine_Not_Received"} == "Not_indicated"){echo "checked";};?>/>
<?php xl('5 - Not indicated; patient does not meet age/condition guidelines for influenza vaccine','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="Inability_to_Obtain_Vaccine"  
<?php if ($obj{"oasistransfer_Reason_For_Influenza_Vaccine_Not_Received"} == "Inability_to_Obtain_Vaccine"){echo "checked";};?>/>
<?php xl('6 - Inability to obtain vaccine due to declared shortage','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_Influenza_Vaccine_Not_Received" value="None" 
<?php if ($obj{"oasistransfer_Reason_For_Influenza_Vaccine_Not_Received"} == "None"){echo "checked";};?>/>
<?php xl('7 - None of the above','e')?><br/>
</td></tr>
<tr><td><hr/></td></tr>
<tr><td>
<b><u><?php xl('(M1050)','e')?></u><?php xl('Pneumococcal Vaccine:','e')?></b><?php xl('Did the patient receive pneumococcal polysaccharide
vaccine (PPV) from your agency during this episode of care (SOC/ROC to
Transfer/Discharge)?','e')?><br/>
<input type="radio" id="m1050" name="oasistransfer_Pneumococcal_Vaccine_Recieved" value="No" 
<?php if ($obj{"oasistransfer_Pneumococcal_Vaccine_Recieved"} == "No"){echo "checked";};?>/>
<?php xl('0 - No','e')?><br/>
<input type="radio" name="oasistransfer_Pneumococcal_Vaccine_Recieved" value="Yes" 
<?php if ($obj{"oasistransfer_Pneumococcal_Vaccine_Recieved"} == "Yes"){echo "checked";};?>/>
<?php xl('1 - Yes','e')?><b>
<?php xl(' [ Go to M1500 at TRN; Go to M1230 at DC ]','e')?></b>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td><center><b><?php xl('EMERGENT CARE','e')?></b></center></td></tr>

<tr><td><hr/></td></tr>
<tr><td><b><u><?php xl('(M2300)','e')?></u><?php xl('Emergent Care:','e')?></b><?php xl('Since the last time OASIS data were collected, has the patient
utilized a hospital emergency department (includes holding/observation)?','e')?> </td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Used_Emergent_Care" value="No" 
<?php if ($obj{"oasistransfer_Used_Emergent_Care"} == "No"){echo "checked";};?>/>
<?php xl('0 - No','e')?><b><?php xl('[ Go to M2400 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Used_Emergent_Care" value="Yes_Without_Hospital_Administration" 
<?php if ($obj{"oasistransfer_Used_Emergent_Care"} == "Yes_Without_Hospital_Administration"){echo "checked";};?>/>
<?php xl('1 - Yes, used hospital emergency department WITHOUT hospital admission','e')?><br/>
<input type="radio" name="oasistransfer_Used_Emergent_Care" value="Yes_With_Hospital_Administration" 
<?php if ($obj{"oasistransfer_Used_Emergent_Care"} == "Yes_With_Hospital_Administration"){echo "checked";};?>/>
<?php xl('2 - Yes, used hospital emergency department WITH hospital admission','e')?><br/>
<input type="radio" name="oasistransfer_Used_Emergent_Care" value="Unknown" 
<?php if ($obj{"oasistransfer_Used_Emergent_Care"} == "Unknown"){echo "checked";};?>/>
<?php xl('UK - Unknown','e')?> <b><?php xl('[ Go to M2400 ]','e')?></b>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr></td></tr>
<tr><td><b><u><?php xl('(M2310)','e')?></u><?php xl('Reason for Emergent Care:','e')?></b><?php xl('For what reason(s) did the patient receive
emergent care (with or without hospitalization)?','e')?> <b><?php xl('(Mark all that apply.)','e')?> </b>
</td></tr>
<tr><td>
<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Improper_medication" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Improper_medication"} == "on"){echo "checked";};?>/>
<?php xl('1 - Improper medication administration, medication side effects, toxicity,anaphylaxis','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Injury_caused_by_fall" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Injury_caused_by_fall"} == "on"){echo "checked";};?>/>
<?php xl('2 - Injury caused by fall','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Respiratory_infection" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Respiratory_infection"} == "on"){echo "checked";};?>/>
<?php xl('3 - Respiratory infection (e.g., pneumonia, bronchitis)','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Other_respiratory_problem" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Other_respiratory_problem"} == "on"){echo "checked";};?>/>
<?php xl('4 - Other respiratory problem','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Heart_failure" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Heart_failure"} == "on"){echo "checked";};?>/>
<?php xl('5 - Heart failure (e.g., fluid overload)','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Cardiac_dysrhythmia" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Cardiac_dysrhythmia"} == "on"){echo "checked";};?>/>
<?php xl('6 - Cardiac dysrhythmia (irregular heartbeat)','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Chest_Pain" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Chest_Pain"} == "on"){echo "checked";};?>/>
<?php xl('7 - Myocardial infarction or chest pain','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Other_heart_disease" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Other_heart_disease"} == "on"){echo "checked";};?>/>
<?php xl('8 - Other heart disease','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Stroke_or_TIA" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Stroke_or_TIA"} == "on"){echo "checked";};?>/>
<?php xl('9 - Stroke (CVA) or TIA','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Hypo_Hyperglycemia" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Hypo_Hyperglycemia"} == "on"){echo "checked";};?>/>
<?php xl('10 - Hypo/Hyperglycemia, diabetes out of control','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_GI_bleeding" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_GI_bleeding"} == "on"){echo "checked";};?>/>
<?php xl('11 - GI bleeding, obstruction, constipation, impaction','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Dehydration_malnutrition" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Dehydration_malnutrition"} == "on"){echo "checked";};?>/>
<?php xl('12 - Dehydration, malnutrition','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Urinary_tract_infection" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Urinary_tract_infection"} == "on"){echo "checked";};?>/>
<?php xl('13 - Urinary tract infection','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_IV_catheter_Complication" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_IV_catheter_Complication"} == "on"){echo "checked";};?>/>
<?php xl('14 - IV catheter-related infection or complication','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Wound_infection" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Wound_infection"} == "on"){echo "checked";};?>/>
<?php xl('15 - Wound infection or deterioration','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Uncontrolled_pain" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Uncontrolled_pain"} == "on"){echo "checked";};?>/>
<?php xl('16 - Uncontrolled pain','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Acute_health_problem" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Acute_health_problem"} == "on"){echo "checked";};?>/>
<?php xl('17 - Acute mental/behavioral health problem','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Deep_vein_thrombosis" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Deep_vein_thrombosis"} == "on"){echo "checked";};?>/>
<?php xl('18 - Deep vein thrombosis, pulmonary embolus','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Other_Reason" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Other_Reason"} == "on"){echo "checked";};?>/>
<?php xl('19 - Other than above reasons','e')?><br/>

<input type="checkbox" name="oasistransfer_In_Emergentcare_for_Reason_unknown" 
<?php if ($obj{"oasistransfer_In_Emergentcare_for_Reason_unknown"} == "on"){echo "checked";};?>/>
<?php xl('UK - Reason unknown','e')?><br/>
</td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td><center><b><?php xl('INPATIENT FACILITY ADMISSION','e')?></b></center></td></tr>

<tr><td>
<table border="1px" class="formtable">
<tr><td colspan="6"><b><u><?php xl('(M2400)','e')?></u><?php xl('Intervention Synopsis:','e')?></b>
<?php xl('(Check only','e')?><b><u><?php xl('one','e')?></u></b> <?php xl('box in each row.) Since the 
previous OASIS assessment, were the following interventions BOTH included in the
physician-ordered plan of care AND implemented?','e')?>
</td></tr>

<tr><td colspan="2"><center><b><?php xl('Plan/Intervention','e')?></b></center></td>
<td><b><?php xl('No','e')?></b></td><td><b><?php xl('Yes','e')?></b></td>
<td colspan="2"><center><b><?php xl('Not Applicable','e')?></b></center></td></tr>

<tr><td valign="top"><?php xl('a','e')?></td><td valign="top"><?php xl('Diabetic foot care including monitoring for the presence of skin lesions on the lower
extremities and patient/caregiver education on proper foot care','e')?></td><td>
<input type="radio" id="m2400" name="oasistransfer_Diabetic_foot_care" value="No" 
<?php if ($obj{"oasistransfer_Diabetic_foot_care"} == "No"){echo "checked";};?>/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Diabetic_foot_care" value="Yes" 
<?php if ($obj{"oasistransfer_Diabetic_foot_care"} == "Yes"){echo "checked";};?>/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Diabetic_foot_care" value="NA" 
<?php if ($obj{"oasistransfer_Diabetic_foot_care"} == "NA"){echo "checked";};?>/><center><?php xl('na','e')?></center></td>
<td valign="top"><?php xl('Patient is not diabetic or is bilateral amputee','e')?></td></tr>

<tr><td valign="top"><?php xl('b','e')?></td><td valign="top"><?php xl('Falls prevention interventions','e')?></td><td>
<input type="radio" name="oasistransfer_Falls_prevention_Intervention" value="No"  
<?php if ($obj{"oasistransfer_Falls_prevention_Intervention"} == "No"){echo "checked";};?>/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Falls_prevention_Intervention" value="Yes" 
<?php if ($obj{"oasistransfer_Falls_prevention_Intervention"} == "Yes"){echo "checked";};?>/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Falls_prevention_Intervention" value="na"  
<?php if ($obj{"oasistransfer_Falls_prevention_Intervention"} == "na"){echo "checked";};?>/><center><?php xl('na','e')?></center></td>
<td><?php xl('Formal multi-factor Fall Risk Assessment indicates the patient was not at risk for falls since the last OASIS assessment','e')?></td></tr>

<tr><td valign="top"><?php xl('c','e')?></td><td valign="top"><?php xl('Depression intervention(s) such as medication, referral for other treatment, or a
monitoring plan for current treatment','e')?></td><td>
<input type="radio" name="oasistransfer_Depression_intervention" value="No" 
<?php if ($obj{"oasistransfer_Depression_intervention"} == "No"){echo "checked";};?>/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Depression_intervention" value="Yes" 
<?php if ($obj{"oasistransfer_Depression_intervention"} == "Yes"){echo "checked";};?>/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Depression_intervention" value="na"  
<?php if ($obj{"oasistransfer_Depression_intervention"} == "na"){echo "checked";};?>/><center><?php xl('na','e')?></center></td>
<td><?php xl('Formal assessment indicates patient did not meet criteria for depression AND patient did not have diagnosis of
depression since the last OASIS assessment','e')?></td></tr>

<tr><td valign="top"><?php xl('d','e')?></td><td valign="top"><?php xl('Intervention(s) to monitor and mitigate pain','e')?></td>
<td>
<input type="radio" name="oasistransfer_Intervention_to_monitor_pain" value="No"  
<?php if ($obj{"oasistransfer_Intervention_to_monitor_pain"} == "No"){echo "checked";};?>/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Intervention_to_monitor_pain" value="Yes" 
<?php if ($obj{"oasistransfer_Intervention_to_monitor_pain"} == "Yes"){echo "checked";};?>/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Intervention_to_monitor_pain" value="na" 
<?php if ($obj{"oasistransfer_Intervention_to_monitor_pain"} == "na"){echo "checked";};?>/><center><?php xl('na','e')?></center></td>
<td><?php xl('Formal assessment did not indicate pain since the last OASIS assessment','e')?></td>
</tr>

<tr><td valign="top"><?php xl('e','e')?></td><td valign="top"><?php xl('Intervention(s) to prevent pressure ulcers','e')?></td>
<td>
<input type="radio" name="oasistransfer_Intervention_to_prevent_pressure_ulcers" value="No"  
<?php if ($obj{"oasistransfer_Intervention_to_prevent_pressure_ulcers"} == "No"){echo "checked";};?>/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Intervention_to_prevent_pressure_ulcers" value="Yes" 
<?php if ($obj{"oasistransfer_Intervention_to_prevent_pressure_ulcers"} == "Yes"){echo "checked";};?>/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Intervention_to_prevent_pressure_ulcers" value="na"  
<?php if ($obj{"oasistransfer_Intervention_to_prevent_pressure_ulcers"} == "na"){echo "checked";};?>/><center><?php xl('na','e')?></center></td>
<td><?php xl('Formal assessment indicates the patient was not at risk of pressure ulcers since the last OASIS assessment','e')?></td>
</tr>


<tr><td valign="top"><?php xl('f','e')?></td><td valign="top"><?php xl('Pressure ulcer treatment based on principles of moist wound healing','e')?></td>
<td>
<input type="radio" name="oasistransfer_Pressure_ulcer_treatment" value="No" 
<?php if ($obj{"oasistransfer_Pressure_ulcer_treatment"} == "No"){echo "checked";};?>/><center><?php xl('0','e')?></center></td>
<td><input type="radio" name="oasistransfer_Pressure_ulcer_treatment" value="Yes"  
<?php if ($obj{"oasistransfer_Pressure_ulcer_treatment"} == "Yes"){echo "checked";};?>/><center><?php xl('1','e')?></center></td>
<td><input type="radio" name="oasistransfer_Pressure_ulcer_treatment" value="na"  
<?php if ($obj{"oasistransfer_Pressure_ulcer_treatment"} == "na"){echo "checked";};?>/><center><?php xl('na','e')?></center></td>
<td><?php xl("Dressings that support the principles of moist wound healing not indicated for this patient's pressure ulcers OR
patient has no pressure ulcers with need for moist wound healing",'e')?></td></tr>
</table></td></tr>

<tr><td><hr/></td></tr>
<tr><td>
<center><strong><?php xl("MENTAL STATUS","e");?></strong></center><br>
<label><input type="checkbox" name="oasistransfer_mental_status[]" value="Oriented"
<?php if(in_array("Oriented",$oasistransfer_mental_status)) echo "checked"; ?> ><?php xl('Oriented','e')?></label>
<label><input type="checkbox" name="oasistransfer_mental_status[]" value="Comatose"
<?php if(in_array("Comatose",$oasistransfer_mental_status)) echo "checked"; ?> ><?php xl('Comatose','e')?></label>
<label><input type="checkbox" name="oasistransfer_mental_status[]" value="Forgetful"
<?php if(in_array("Forgetful",$oasistransfer_mental_status)) echo "checked"; ?> ><?php xl('Forgetful','e')?></label>
<label><input type="checkbox" name="oasistransfer_mental_status[]" value="Depressed"
<?php if(in_array("Depressed",$oasistransfer_mental_status)) echo "checked"; ?> ><?php xl('Depressed','e')?></label>
<label><input type="checkbox" name="oasistransfer_mental_status[]" value="Disoriented"
<?php if(in_array("Disoriented",$oasistransfer_mental_status)) echo "checked"; ?> ><?php xl('Disoriented','e')?></label>
<label><input type="checkbox" name="oasistransfer_mental_status[]" value="Lethargic"
<?php if(in_array("Lethargic",$oasistransfer_mental_status)) echo "checked"; ?> ><?php xl('Lethargic','e')?></label>
<label><input type="checkbox" name="oasistransfer_mental_status[]" value="Agitated"
<?php if(in_array("Agitated",$oasistransfer_mental_status)) echo "checked"; ?> ><?php xl('Agitated','e')?></label>
<label><input type="checkbox" name="oasistransfer_mental_status[]" value="Other"
<?php if(in_array("Other",$oasistransfer_mental_status)) echo "checked"; ?> ><?php xl('Other:','e')?></label>
<input type="text" name="oasistransfer_mental_status_other"  value="<?php echo stripslashes($obj{"oasistransfer_mental_status_other"});?>" >
</td></tr>
<tr><td>&nbsp;</td></tr>


<tr><td><hr/></td></tr>
<tr><td>
<center><strong><?php xl("FUNCTIONAL LIMITATIONS","e");?></strong></center><br>
<table class="formtable">
	<tr valign="top">
		<td width="30%">
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Amputation"
<?php if(in_array("Amputation",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Amputation','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Hearing"
<?php if(in_array("Hearing",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Hearing','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Ambulation"
<?php if(in_array("Ambulation",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Ambulation','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Dyspnea with Minimal Exertion"
<?php if(in_array("Dyspnea with Minimal Exertion",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Dyspnea with Minimal Exertion','e')?></label>
		</td>

		<td width="45%">
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Bowel/Bladder (Incontinence)"
<?php if(in_array("Bowel/Bladder (Incontinence)",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Bowel/Bladder (Incontinence)','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Paralysis"
<?php if(in_array("Paralysis",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Paralysis','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Speech"
<?php if(in_array("Speech",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Speech','e')?></label><br>
				
		</td>

		<td width="25%">
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Contracture"
<?php if(in_array("Contracture",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Contracture','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Endurance"
<?php if(in_array("Endurance",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Endurance','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Legally Blind"
<?php if(in_array("Legally Blind",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Legally Blind','e')?></label>
		</td>
	</tr>
	<tr>
	<td colspan="3">
	<label><input type="checkbox" name="oasistransfer_functional_limitations[]" value="Other"
<?php if(in_array("Other",$oasistransfer_functional_limitations)) echo "checked"; ?> ><?php xl('Other (specify):','e')?></label>
<input type="text" name="oasistransfer_functional_limitations_other"  value="<?php echo stripslashes($obj{"oasistransfer_functional_limitations_other"});?>" size="15">
	</td>
	</tr>
</table>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td><hr/></td></tr>
<tr><td>
<center><strong><?php xl('PROGNOSIS','e')?></strong></center><br>
<strong><?php xl('Prognosis:','e')?></strong>
<label><input type="radio" name="oasistransfer_prognosis" value="1"
<?php if($obj{"oasistransfer_prognosis"}=="1") echo "checked"; ?>  ><?php xl(' 1-Poor ','e')?></label>
			<label><input type="radio" name="oasistransfer_prognosis" value="2"
<?php if($obj{"oasistransfer_prognosis"}=="2") echo "checked"; ?>  ><?php xl(' 2-Guarded ','e')?></label>
			<label><input type="radio" name="oasistransfer_prognosis" value="3"
<?php if($obj{"oasistransfer_prognosis"}=="3") echo "checked"; ?>  ><?php xl(' 3-Fair ','e')?></label>
			<label><input type="radio" name="oasistransfer_prognosis" value="4"
<?php if($obj{"oasistransfer_prognosis"}=="4") echo "checked"; ?>  ><?php xl(' 4-Good ','e')?></label>
			<label><input type="radio" name="oasistransfer_prognosis" value="5"
<?php if($obj{"oasistransfer_prognosis"}=="5") echo "checked"; ?>  ><?php xl(' 5-Excellent ','e')?></label>
</td></tr>
<tr><td>&nbsp;</td></tr>


<tr><td><hr/></td></tr>
<tr><td>
			<center><strong><?php xl("SAFETY MEASURES","e");?></strong></center>
			<table class="formtable">
			    <tr>
				    <td width="50%">
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="911 Protocol"
		    <?php if(in_array("911 Protocol",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('911 Protocol','e')?></label><br>

					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Clear Pathways"
		    <?php if(in_array("Clear Pathways",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Clear Pathways','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Siderails up"
		    <?php if(in_array("Siderails up",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Siderails up','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Safe Transfers"
		    <?php if(in_array("Safe Transfers",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Safe Transfers','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Equipment Safety"
		    <?php if(in_array("Equipment Safety",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Equipment Safety','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Infection Control Measures"
		    <?php if(in_array("Infection Control Measures",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Infection Control Measures','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Bleeding Precautions"
		    <?php if(in_array("Bleeding Precautions",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Bleeding Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Fall Precautions"
		    <?php if(in_array("Fall Precautions",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Fall Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Seizure Precautions"
		    <?php if(in_array("Seizure Precautions",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Seizure Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Universal Precautions"
		    <?php if(in_array("Universal Precautions",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Universal Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Other"
		    <?php if(in_array("Other",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Other:','e')?></label>

						    <input type="text" name="oasistransfer_safety_measures_other"  value="<?php echo stripslashes($obj{"oasistransfer_safety_measures_other"});?>" ><br>

				    </td>
				    <td>

					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Hazard-Free Environment"
		    <?php if(in_array("Hazard-Free Environment",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Hazard-Free Environment','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Lock W/C with transfers"
		    <?php if(in_array("Lock W/C with transfers",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Lock W/C with transfers','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Elevate Head of Bed"
		    <?php if(in_array("Elevate Head of Bed",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Elevate Head of Bed','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Medication Safety/Storage"
		    <?php if(in_array("Medication Safety/Storage",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Medication Safety/Storage','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Hazardous Waste Disposal"
		    <?php if(in_array("Hazardous Waste Disposal",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Hazardous Waste Disposal','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="24 hr. supervision"
		    <?php if(in_array("24 hr. supervision",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('24 hr. supervision','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Neutropenic"
		    <?php if(in_array("Neutropenic",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Neutropenic','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="O2 Precautions"
		    <?php if(in_array("O2 Precautions",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('O2 Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Aspiration Precautions"
		    <?php if(in_array("Aspiration Precautions",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Aspiration Precautions','e')?></label><br>
					    <label><input type="checkbox" name="oasistransfer_safety_measures[]" value="Walker/Cane"
		    <?php if(in_array("Walker/Cane",$oasistransfer_safety_measures)) echo "checked"; ?> ><?php xl('Walker/Cane','e')?></label><br>
				    </td>
			    </tr>
			    </table>
</td></tr>
<tr><td>&nbsp;</td></tr>



<tr><td><hr/></td></tr>
<tr><td>
		    <strong><?php xl("IV SUPPLIES: ","e");?></strong><br />
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="IV start kit"
<?php if(in_array("IV start kit",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV start kit','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="IV pole"
<?php if(in_array("IV pole",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV pole','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="IV tubing" 
<?php if(in_array("IV tubing",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('IV tubing','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Alcohol swabs"
<?php if(in_array("Alcohol swabs",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Alcohol swabs','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Angiocatheter size"
<?php if(in_array("Angiocatheter size",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Angiocatheter size','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Tape"
<?php if(in_array("Tape",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Tape','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Extension tubings"
<?php if(in_array("Extension tubings",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Extension tubings','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Injection caps"
<?php if(in_array("Injection caps",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Injection caps','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Central line dressing"
<?php if(in_array("Central line dressing",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Central line dressing','e')?></label><br>
		    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Infusion pump"
<?php if(in_array("Infusion pump",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Infusion pump','e')?></label><br>
				    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Batteries size"
<?php if(in_array("Batteries size",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Batteries size','e')?></label><br>
				    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Syringes size"
<?php if(in_array("Syringes size",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Syringes size','e')?></label><br>
				    <label><input type="checkbox" name="oasistransfer_dme_iv_supplies[]" value="Other"
<?php if(in_array("Other",$oasistransfer_dme_iv_supplies)) echo "checked"; ?> ><?php xl('Other','e')?></label>


    <input type="text" name="oasistransfer_dme_iv_supplies_other"  value="<?php echo stripslashes($obj{"oasistransfer_dme_iv_supplies_other"});?>" >
</td></tr>
<tr><td>&nbsp;</td></tr>


<tr><td><hr/></td></tr>
<tr><td>
			<strong><?php xl("FOLEY SUPPLIES: ","e");?></strong><br />
			<label><input type="checkbox" name="oasistransfer_dme_foley_supplies[]" value="Fr catheter kit"
<?php if(in_array("Fr catheter kit",$oasistransfer_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Fr catheter kit','e')?></label><br>
			<?php xl("(tray, bag, foley) ","e");?><br>
			<label><input type="checkbox" name="oasistransfer_dme_foley_supplies[]" value="Straight catheter"
<?php if(in_array("Straight catheter",$oasistransfer_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Straight catheter','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_dme_foley_supplies[]" value="Irrigation tray"
<?php if(in_array("Irrigation tray",$oasistransfer_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Irrigation tray','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_dme_foley_supplies[]" value="Saline"
<?php if(in_array("Saline",$oasistransfer_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Saline','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_dme_foley_supplies[]" value="Acetic acid"
<?php if(in_array("Acetic acid",$oasistransfer_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Acetic acid','e')?></label><br>
			<label><input type="checkbox" name="oasistransfer_dme_foley_supplies[]" value="Other"
<?php if(in_array("Other",$oasistransfer_dme_foley_supplies)) echo "checked"; ?> ><?php xl('Other','e')?></label><br>

<input type="text" name="oasistransfer_dme_foley_supplies_other"  value="<?php echo stripslashes($obj{"oasistransfer_dme_foley_supplies_other"});?>" >
</td></tr>
<tr><td>&nbsp;</td></tr>






</table></td>


<td width="50%" valign="top">
<table class="formtable">
<tr><td><center><b><?php xl('PATIENT HISTORY AND DIAGNOSES (CONT.)','e')?></b></center></td></tr>
<tr><td><hr/></td></tr>
<tr><td><b><u><?php xl('(M1055)','e')?></u><?php xl('Reason PPV not received:','e')?></b><?php xl('If patient did not receive the pneumococcal
polysaccharide vaccine (PPV) from your agency during this episode of care (SOC/ROC to
Transfer/Discharge), state reason:','e')?></td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="Received_in_the_past" 
<?php if ($obj{"oasistransfer_Reason_For_PPV_Not_Received"} == "Received_in_the_past"){echo "checked";};?>/>
<?php xl('1 - Patient has received PPV in the past','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="Offered_and_declined" 
<?php if ($obj{"oasistransfer_Reason_For_PPV_Not_Received"} == "Offered_and_declined"){echo "checked";};?>/>
<?php xl('2 - Offered and declined','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="Assessed_and_determined"  
<?php if ($obj{"oasistransfer_Reason_For_PPV_Not_Received"} == "Assessed_and_determined"){echo "checked";};?>/>
<?php xl('3 - Assessed and determined to have medical contraindication(s)','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="Not_indicated" 
<?php if ($obj{"oasistransfer_Reason_For_PPV_Not_Received"} == "Not_indicated"){echo "checked";};?>/>
<?php xl('4 - Not indicated; patient does not meet age/condition guidelines for PPV','e')?><br/>
<input type="radio" name="oasistransfer_Reason_For_PPV_Not_Received" value="None"  
<?php if ($obj{"oasistransfer_Reason_For_PPV_Not_Received"} == "None"){echo "checked";};?>/>
<?php xl('5 - None of the above','e')?>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr>
		<td colspan="2">
			<strong><?php xl('<u>(M1230)</u> Speech and Oral (Verbal) Expression of Language (in patient\'s own language):','e');?></strong><br>
			<label><input type="radio" id="m1230" name="oasis_speech_and_oral" value="0" <?php if($obj{"oasis_speech_and_oral"}=="0"){echo "checked";}?> ><?php xl(' 0 - Expresses complex ideas, feelings, and needs clearly, completely, and easily in all situations with no observable impairment.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="1" <?php if($obj{"oasis_speech_and_oral"}=="1"){echo "checked";}?> ><?php xl(' 1 - Minimal difficulty in expressing ideas and needs (may take extra time; makes occasional errors in word choice, grammar or speech intelligibility; needs minimal prompting or assistance).','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="2" <?php if($obj{"oasis_speech_and_oral"}=="2"){echo "checked";}?> ><?php xl(' 2 - Expresses simple ideas or needs with moderate difficulty (needs prompting or assistance, errors in word choice, organization or speech intelligibility). Speaks in phrases or short sentences.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="3" <?php if($obj{"oasis_speech_and_oral"}=="3"){echo "checked";}?> ><?php xl(' 3 - Has severe difficulty expressing basic ideas or needs and requires maximal assistance or guessing by listener. Speech limited to single words or short phrases.','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="4" <?php if($obj{"oasis_speech_and_oral"}=="4"){echo "checked";}?> ><?php xl(' 4 - <u>Unable</u> to express basic needs even with maximal prompting or assistance but is not comatose or unresponsive (e.g., speech is nonsensical or unintelligible).','e');?></label><br>
			<label><input type="radio" name="oasis_speech_and_oral" value="5" <?php if($obj{"oasis_speech_and_oral"}=="5"){echo "checked";}?> ><?php xl(' 5 - Patient nonresponsive or unable to speak.','e');?></label><br>
		</td>
	</tr>
<tr><td><hr/></td></tr>
<tr><td><center><b><?php xl('CARDIAC STATUS','e')?></b></center></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><b><u><?php xl('(M1500)','e')?></u><?php xl('Symptoms in Heart Failure Patients:','e')?></b><?php xl('If patient has been diagnosed with
heart failure, did the patient exhibit symptoms indicated by clinical heart failure guidelines (including dyspnea, orthopnea, edema, 
or weight gain) at any point since the previous OASIS assessment?','e')?></td></tr>
<tr><td> 
<input type="radio" id="m1500" name="oasistransfer_Cardiac_Status" value="patient_didnot_Exhibit_Symptoms"
<?php if ($obj{"oasistransfer_Cardiac_Status"} == "patient_didnot_Exhibit_Symptoms"){echo "checked";};?>/>
<?php xl('0 - No','e')?>&nbsp;<b><?php xl('[ Go to M2004 at TRN; Go to M1600 at DC ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Cardiac_Status" value="patient_Exhibited_Symptoms"  
<?php if ($obj{"oasistransfer_Cardiac_Status"} == "patient_Exhibited_Symptoms"){echo "checked";};?>/>
<?php xl('1-Yes','e')?><br/>
<input type="radio" name="oasistransfer_Cardiac_Status" value="Not_Assessed"  
<?php if ($obj{"oasistransfer_Cardiac_Status"} == "Not_Assessed"){echo "checked";};?>/>
<?php xl('2 - Not assessed','e')?>&nbsp;<b><?php xl('[Go to M2004 at TRN; Go to M1600 at DC ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Cardiac_Status" value="NA"  
<?php if ($obj{"oasistransfer_Cardiac_Status"} == "NA"){echo "checked";};?>/>
<?php xl('NA - Patient does not have diagnosis of heart failure','e')?>&nbsp;<b><?php xl('[Go to M2004 at TRN; Go
to M1600 at DC ]','e')?></b>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td><hr/></td></tr>
<tr><td>
<center><strong><?php xl("ELIMINATION STATUS","e");?></strong></center>
			<?php xl("<b><u>(M1600)</u></b> Has this patient been treated for a <b>Urinary Tract Infection</b> in the past 14 days?","e");?><br>
			<label><input type="radio" id="m1600" name="oasis_elimination_status_tract_infection" value="0" <?php if($obj{"oasis_elimination_status_tract_infection"}=="0"){echo "checked";}?> ><?php xl(' 0 - No ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="1" <?php if($obj{"oasis_elimination_status_tract_infection"}=="1"){echo "checked";}?> ><?php xl(' 1 - Yes ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="NA" <?php if($obj{"oasis_elimination_status_tract_infection"}=="NA"){echo "checked";}?> ><?php xl(' NA - Patient on prophylactic treatment ','e')?></label> <br>
			<label><input type="radio" name="oasis_elimination_status_tract_infection" value="UK" <?php if($obj{"oasis_elimination_status_tract_infection"}=="UK"){echo "checked";}?> ><?php xl(' UK - Unknown <b>[Omit "UK" option on DC]</b> ','e')?></label> <br>
			
</td></tr>
<tr><td><hr/></td></tr>

<tr><td><b><u><?php xl('(M1510)','e')?></u><?php xl('Heart Failure Follow-up:','e')?></b><?php xl('If patient has been diagnosed with heart failure and has exhibited symptoms indicative 
of heart failure since the previous OASIS assessment,what action(s) has (have) been taken to respond?<strong> (Mark all that apply.</strong>)','e')?>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_no_Action" 
<?php if ($obj{"oasistransfer_Heart_Failure_FollowUp_no_Action"} == "on"){echo "checked";};?>/>
<?php xl('0 - No action taken','e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_patient_Contacted" 
<?php if ($obj{"oasistransfer_Heart_Failure_FollowUp_patient_Contacted"} == "on"){echo "checked";};?>/>
<?php xl("1 -Patient's physician (or other primary care practitioner) contacted the same day",'e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_Emergency_Treatment" 
<?php if ($obj{"oasistransfer_Heart_Failure_FollowUp_Emergency_Treatment"} == "on"){echo "checked";};?>/>
<?php xl('2 - Patient advised to get emergency treatment (e.g., call 911 or go to emergency room)','e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_Implemented_treatment" 
<?php if ($obj{"oasistransfer_Heart_Failure_FollowUp_Implemented_treatment"} == "on"){echo "checked";};?>/>
<?php xl('3 - Implemented physician-ordered patient-specific established parameters for treatment','e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_Patient_Education" 
<?php if ($obj{"oasistransfer_Heart_Failure_FollowUp_Patient_Education"} == "on"){echo "checked";};?>/>
<?php xl('4 - Patient education or other clinical interventions','e')?><br/>
<input type="checkbox" name="oasistransfer_Heart_Failure_FollowUp_change_in_carePlan_orders" 
<?php if ($obj{"oasistransfer_Heart_Failure_FollowUp_change_in_carePlan_orders"} == "on"){echo "checked";};?>/>
<?php xl('5 - Obtained change in care plan orders (e.g., increased monitoring by agency,
change in visit frequency, telehealth, etc.)','e')?><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>

<tr><td><center><b><?php xl('MEDICATIONS','e')?></b></center></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><b><u><?php xl('(M2004)','e')?></u><?php xl('Medication Intervention:','e')?> </b><?php xl('If there were any clinically significant medication issues since the previous OASIS 
assessment, was a physician or the physician-designee contacted within one calendar day of the assessment to resolve clinically significant
medication issues, including reconciliation?','e')?>
</td></tr>

<tr><td>
<input type="radio" id="m2004" name="oasistransfer_Medication_Intervention" value="reconcillation_NotDone" 
<?php if ($obj{"oasistransfer_Medication_Intervention"} == "reconcillation_NotDone"){echo "checked";};?>/>
<?php xl('0 - No','e')?><br/>
<input type="radio" name="oasistransfer_Medication_Intervention" value="reconcillation_Done" 
<?php if ($obj{"oasistransfer_Medication_Intervention"} == "reconcillation_Done"){echo "checked";};?>/>
<?php xl('1 - Yes','e')?><br/>
<input type="radio" name="oasistransfer_Medication_Intervention" value="reconcillation_NA" 
<?php if ($obj{"oasistransfer_Medication_Intervention"} == "reconcillation_NA"){echo "checked";};?>/>
<?php xl('NA - No clinically significant medication issues identified since the previous OASIS
assessment','e')?><br/>
</td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td>
<b><u><?php xl('(M2015)','e')?></u><?php xl('Patient/Caregiver Drug Education Intervention:','e')?></b><?php xl('Since the previous OASIS assessment, was the patient/caregiver 
instructed by agency staff or other health care provider to monitor the effectiveness of drug therapy, drug reactions, and side effects,
 and how and when to report problems that may occur?','e')?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Drug_Education_Intervention" value="patient_not_instructed"  
<?php if ($obj{"oasistransfer_Drug_Education_Intervention"} == "patient_not_instructed"){echo "checked";};?>/>
<?php xl('0 - No','e')?><br/>
<input type="radio" name="oasistransfer_Drug_Education_Intervention" value="patient_instructed" 
<?php if ($obj{"oasistransfer_Drug_Education_Intervention"} == "patient_instructed"){echo "checked";};?>/>
<?php xl('1 - Yes','e')?><br/>
<input type="radio" name="oasistransfer_Drug_Education_Intervention" value="NA" 
<?php if ($obj{"oasistransfer_Drug_Education_Intervention"} == "NA"){echo "checked";};?>/>
<?php xl('NA -  Patient not taking any drugs','e')?><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>

<tr><td>
<b><u><?php xl('(M2410)','e')?></u></b>&nbsp;<?php xl('To which','e')?><b>&nbsp;<?php xl('Inpatient Facility','e')?></b>&nbsp;<?php xl('has the patient been admitted?','e')?>
</td></tr>
<tr><td>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="Hospital" 
<?php if ($obj{"oasistransfer_Inpatient_Facility_patient_admitted"} == "Hospital"){echo "checked";};?>/><?php xl('1 - Hospital','e')?> &nbsp;<b><?php xl('[ Go to M2430 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="Rehabilitation_Facility" 
<?php if ($obj{"oasistransfer_Inpatient_Facility_patient_admitted"} == "Rehabilitation_Facility"){echo "checked";};?>/><?php xl('2 - Rehabilitation facility','e')?> &nbsp;<b><?php xl('[ Go to M0903 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="Nursing_home" 
<?php if ($obj{"oasistransfer_Inpatient_Facility_patient_admitted"} == "Nursing_home"){echo "checked";};?>/><?php xl('3 - Nursing home','e')?> &nbsp;<b><?php xl('[ Go to M2440 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="Hospice" 
<?php if ($obj{"oasistransfer_Inpatient_Facility_patient_admitted"} == "Hospice"){echo "checked";};?>/><?php xl('4 - Hospice','e')?> &nbsp;<b><?php xl(' [ Go to M0903 ]','e')?></b><br/>
<input type="radio" name="oasistransfer_Inpatient_Facility_patient_admitted" value="NA" 
<?php if ($obj{"oasistransfer_Inpatient_Facility_patient_admitted"} == "NA"){echo "checked";};?>/><?php xl('NA - No inpatient facility admission [Omit "NA" option on TRN]','e')?><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td>
<b><u><?php xl('(M2430)','e')?></u>&nbsp;<?php xl('Reason for Hospitalization:','e')?></b>&nbsp;<?php xl('For what reason(s) did the patient require
hospitalization?','e')?> &nbsp;<b><?php xl('(Mark all that apply.)','e')?></b>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<input type="checkbox" id="m2430" name="oasistransfer_Hospitalized_for_Improper_medication" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Improper_medication"} == "on"){echo "checked";};?>/>
<?php xl('1 - Improper medication administration, medication side effects, toxicity,anaphylaxis','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Injury_caused_by_fall" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Injury_caused_by_fall"} == "on"){echo "checked";};?>/>
<?php xl('2 - Injury caused by fall','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Respiratory_infection" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Respiratory_infection"} == "on"){echo "checked";};?>/>
<?php xl('3 - Respiratory infection (e.g., pneumonia, bronchitis)','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Other_respiratory_problem" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Other_respiratory_problem"} == "on"){echo "checked";};?>/>
<?php xl('4 - Other respiratory problem','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Heart_failure" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Heart_failure"} == "on"){echo "checked";};?>/>
<?php xl('5 - Heart failure (e.g., fluid overload)','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Cardiac_dysrhythmia" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Cardiac_dysrhythmia"} == "on"){echo "checked";};?>/>
<?php xl('6 - Cardiac dysrhythmia (irregular heartbeat)','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Chest_Pain" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Chest_Pain"} == "on"){echo "checked";};?>/>
<?php xl('7 - Myocardial infarction or chest pain','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Other_heart_disease" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Other_heart_disease"} == "on"){echo "checked";};?>/>
<?php xl('8 - Other heart disease','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Stroke_or_TIA" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Stroke_or_TIA"} == "on"){echo "checked";};?>/>
<?php xl('9 - Stroke (CVA) or TIA','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Hypo_Hyperglycemia" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Hypo_Hyperglycemia"} == "on"){echo "checked";};?>/>
<?php xl('10 - Hypo/Hyperglycemia, diabetes out of control','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_GI_bleeding" 
<?php if ($obj{"oasistransfer_Hospitalized_for_GI_bleeding"} == "on"){echo "checked";};?>/>
<?php xl('11 - GI bleeding, obstruction, constipation, impaction','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Dehydration_malnutrition" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Dehydration_malnutrition"} == "on"){echo "checked";};?>/>
<?php xl('12 - Dehydration, malnutrition','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Urinary_tract_infection" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Urinary_tract_infection"} == "on"){echo "checked";};?>/>
<?php xl('13 - Urinary tract infection','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_IV_catheter_related_infection" 
<?php if ($obj{"oasistransfer_Hospitalized_for_IV_catheter_related_infection"} == "on"){echo "checked";};?>/>
<?php xl('14 - IV catheter-related infection or complication','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Wound_infection" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Wound_infection"} == "on"){echo "checked";};?>/>
<?php xl('15 - Wound infection or deterioration','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Uncontrolled_pain" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Uncontrolled_pain"} == "on"){echo "checked";};?>/>
<?php xl('16 - Uncontrolled pain','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Acute_health_problem" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Acute_health_problem"} == "on"){echo "checked";};?>/>
<?php xl('17 - Acute mental/behavioral health problem','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Deep_vein_thrombosis" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Deep_vein_thrombosis"} == "on"){echo "checked";};?>/>
<?php xl('18 - Deep vein thrombosis, pulmonary embolus','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_scheduled_Treatment" 
<?php if ($obj{"oasistransfer_Hospitalized_for_scheduled_Treatment"} == "on"){echo "checked";};?>/>
<?php xl('19 - Scheduled treatment or procedure','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Other_Reason" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Other_Reason"} == "on"){echo "checked";};?>/>
<?php xl('20 - Other than above reasons','e')?><br/>

<input type="checkbox" name="oasistransfer_Hospitalized_for_Reason_unknown" 
<?php if ($obj{"oasistransfer_Hospitalized_for_Reason_unknown"} == "on"){echo "checked";};?>/>
<?php xl('UK - Reason unknown','e')?><b> <?php xl('[ Go to M0903 ]','e')?></b><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td>
<b><u><?php xl('(M2440)','e')?></u></b>&nbsp;<?php xl('For what','e')?>&nbsp;<b><?php xl('Reason(s)','e')?></b>&nbsp;
<?php xl('was the patient','e')?>&nbsp;<b><?php xl('Admitted','e')?></b> <?php xl('to a','e')?>
&nbsp;<b><?php xl('Nursing Home? (Mark all that apply.)','e')?></b>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<input type="checkbox" id="m2440" name="oasistransfer_Admitted_in_NursingHome_for_Theraphy_Services" 
<?php if ($obj{"oasistransfer_Admitted_in_NursingHome_for_Theraphy_Services"} == "on"){echo "checked";};?>/>
<?php xl('1 - Therapy services','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Respite_care" 
<?php if ($obj{"oasistransfer_Admitted_in_NursingHome_for_Respite_care"} == "on"){echo "checked";};?>/>
<?php xl('2 - Respite care','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Hospice_care" 
<?php if ($obj{"oasistransfer_Admitted_in_NursingHome_for_Hospice_care"} == "on"){echo "checked";};?>/>
<?php xl('3 - Hospice care','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Permanent_placement" 
<?php if ($obj{"oasistransfer_Admitted_in_NursingHome_for_Permanent_placement"} == "on"){echo "checked";};?>/>
<?php xl('4 - Permanent placement','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_as_Unsafe_at_home" 
<?php if ($obj{"oasistransfer_Admitted_in_NursingHome_as_Unsafe_at_home"} == "on"){echo "checked";};?>/>
<?php xl('5 - Unsafe for care at home','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Other_Reason" 
<?php if ($obj{"oasistransfer_Admitted_in_NursingHome_for_Other_Reason"} == "on"){echo "checked";};?>/>
<?php xl('6 - Other','e')?><br/>

<input type="checkbox" name="oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason" 
<?php if ($obj{"oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason"} == "on"){echo "checked";};?>/>
<?php xl('UK - Unknown','e')?><b><?php xl('[ Go to M0903 ]','e')?></b><br/>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>

<tr><td><b><?php xl('(M0903) Date of Last (Most Recent) Home Visit:','e')?> </b>
<input type="text" name="oasistransfer_Last_Home_Visit_Date" size="10" title='<?php xl('yyyy-mm-dd Last Home Visit Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Last_Home_Visit_Date" 
	value="<?php echo stripslashes($obj{"oasistransfer_Last_Home_Visit_Date"});?>" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_home_visit_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Last_Home_Visit_Date", ifFormat:"%Y-%m-%d", button:"img_home_visit_date"});
   </script>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td><b><?php xl('(M0906) Discharge/Transfer/Death Date:','e')?></b>&nbsp;
 <?php xl('Enter the date of the discharge, transfer, or death (at home) of the patient','e')?><br/>
<input type="text" name="oasistransfer_Discharge_Transfer_Death_Date" size="10" title='<?php xl('yyyy-mm-dd Discharge/Transfer/Death Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Discharge_Transfer_Death_Date" 
	value="<?php echo stripslashes($obj{"oasistransfer_Discharge_Transfer_Death_Date"});?>" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_discharge_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Discharge_Transfer_Death_Date", ifFormat:"%Y-%m-%d", button:"img_discharge_date"});
   </script>

<tr><td>&nbsp;</td></tr>
<tr><td><hr/></td></tr>
<tr><td><strong><?php xl('Certification:','e');?></strong><br>
<label><input type="radio" name="oasistransfer_certification" value="0" <?php if($obj{"oasistransfer_certification"}=="0"){echo "checked";}?> ><?php xl(' Certification','e');?></label>
<label><input type="radio" name="oasistransfer_certification" value="1" <?php if($obj{"oasistransfer_certification"}=="1"){echo "checked";}?> ><?php xl(' Recertification','e');?></label>
</td></tr>
<tr><td><hr/></td></tr>
<tr><td><strong><?php xl('Date Last Contacted Physician: ','e');?></strong>
<input type='text' size='10' name='oasistransfer_date_last_contacted_physician' id='oasistransfer_date_last_contacted_physician' 
	title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasistransfer_date_last_contacted_physician"};?>" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
	height='22' id='img_curr_date_sy1' border='0' alt='[?]'
	style='cursor: pointer; cursor: hand'
	title='<?php xl('Click here to choose a date','e'); ?>'> 
	<script	LANGUAGE="JavaScript">
		Calendar.setup({inputField:"oasistransfer_date_last_contacted_physician", ifFormat:"%Y-%m-%d", button:"img_curr_date_sy1"});
	</script>
</td></tr>
<tr><td><hr/></td></tr>
<tr><td><strong><?php xl('Date Last Seen By Physician: ','e');?></strong>
<input type='text' size='10' name='oasistransfer_date_last_seen_by_physician' id='oasistransfer_date_last_seen_by_physician' 
	title='<?php xl('yyyy-mm-dd Date Assessment Completed','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value="<?php echo $obj{"oasistransfer_date_last_seen_by_physician"};?>"  readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
	height='22' id='img_curr_date_sy2' border='0' alt='[?]'
	style='cursor: pointer; cursor: hand'
	title='<?php xl('Click here to choose a date','e'); ?>'> 
	<script	LANGUAGE="JavaScript">
		Calendar.setup({inputField:"oasistransfer_date_last_seen_by_physician", ifFormat:"%Y-%m-%d", button:"img_curr_date_sy2"});
	</script>
</td></tr>
</td></tr>
</table></td></tr>


<hr />

<hr>

<hr>


















<tr><td colspan="2">&nbsp;</td></tr>


<tr><td colspan="2">

<table border="0px">
<tr><td align="center" colspan="2" class="formtable"><b><?php xl('SUPPLEMENTAL INFORMATION','e')?></b></td></tr>
<tr><td colspan="2"><hr/></td></tr>
<tr><td colspan="2" class="formtable" ><b><?php xl('DISCIPLINES INVOLVED:','e')?></b></td></tr>
<tr><td colspan="2" class="formtable">
<input type="checkbox" name="oasistransfer_Disciplined_Involved_SN" 
<?php if ($obj{"oasistransfer_Disciplined_Involved_SN"} == "on"){echo "checked";};?>/><?php xl('SN','e')?> 
&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_PT"  
<?php if ($obj{"oasistransfer_Disciplined_Involved_PT"} == "on"){echo "checked";};?>/><?php xl('PT','e')?>
&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_OT"  
<?php if ($obj{"oasistransfer_Disciplined_Involved_OT"} == "on"){echo "checked";};?>/><?php xl('OT','e')?>
&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_ST"  
<?php if ($obj{"oasistransfer_Disciplined_Involved_ST"} == "on"){echo "checked";};?>/><?php xl('ST','e')?>
&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_MSW"  
<?php if ($obj{"oasistransfer_Disciplined_Involved_MSW"} == "on"){echo "checked";};?>/><?php xl('MSW','e')?>
&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_CHHA"  
<?php if ($obj{"oasistransfer_Disciplined_Involved_CHHA"} == "on"){echo "checked";};?>/><?php xl('CHHA','e')?>
&nbsp;&nbsp;
<input type="checkbox" name="oasistransfer_Disciplined_Involved_Other"  
<?php if ($obj{"oasistransfer_Disciplined_Involved_Other"} == "on"){echo "checked";};?>/><?php xl('Other','e')?>
</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable"><b>
<?php xl('PHYSICIAN NOTIFIED:','e')?></b>
<input type="radio" name="oasistransfer_Physician_notified" value="Yes" 
<?php if ($obj{"oasistransfer_Physician_notified"} == "Yes"){echo "checked";};?>/><?php xl('Yes','e')?>
<input type="radio" name="oasistransfer_Physician_notified" value="No" 
<?php if ($obj{"oasistransfer_Physician_notified"} == "No"){echo "checked";};?>/><?php xl('No','e')?>

</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable" ><b><?php xl('REASON FOR ADMISSION / SUMMARY:','e')?></b></td></tr>
<tr><td colspan="2" class="formtable">
<textarea name="oasistransfer_Reason_For_Admission" rows="10" cols="80"><?php echo stripslashes($obj{"oasistransfer_Reason_For_Admission"});?></textarea> </td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable"><b><?php xl('EMERGENT CARE / HOSPITALIZATION / FACILITY INFORMATION:','e')?></b></td></tr>
<tr><td colspan="2" class="formtable" >
<textarea name="oasistransfer_EmergentCare_Hospitalization_Information" rows="10" cols="80"><?php echo stripslashes($obj{"oasistransfer_EmergentCare_Hospitalization_Information"});?></textarea> </td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable" ><?php xl('Does Patient Have an Advance Directive?','e')?>
<input type="radio" name="oasistransfer_Patient_Have_Advance_Directive" value="Yes" 
<?php if ($obj{"oasistransfer_Patient_Have_Advance_Directive"} == "Yes"){echo "checked";};?>/><?php xl('Yes','e')?>
<input type="radio" name="oasistransfer_Patient_Have_Advance_Directive" value="No"  
<?php if ($obj{"oasistransfer_Patient_Have_Advance_Directive"} == "No"){echo "checked";};?>/><?php xl('No','e')?>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable" ><b><?php xl('Attachments:','e')?></b></td></tr>

<tr><td colspan="2" class="formtable" > <input type="checkbox" name="oasistransfer_List_Of_Medications_Attached" 
<?php if ($obj{"oasistransfer_List_Of_Medications_Attached"} == "on"){echo "checked";};?>/>
<?php xl('List of Medications','e')?> </td></tr>
<tr><td colspan="2" class="formtable"> <input type="checkbox" name="oasistransfer_Plan_Of_Care_Attached" 
<?php if ($obj{"oasistransfer_Plan_Of_Care_Attached"} == "on"){echo "checked";};?>/>
<?php xl('Plan of Care','e')?> </td></tr>
<tr><td colspan="2" class="formtable" > <input type="checkbox" name="oasistransfer_Advance_Directive_Attached" 
<?php if ($obj{"oasistransfer_Advance_Directive_Attached"} == "on"){echo "checked";};?>/><?php xl('Advance Directive','e')?> </td></tr>
<tr><td colspan="2" class="formtable" > <input type="checkbox" name="oasistransfer_DNR_Attached"  
<?php if ($obj{"oasistransfer_DNR_Attached"} == "on"){echo "checked";};?>/><?php xl('DNR','e')?> </td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable" ><b><?php xl('Copies sent to:','e')?></b></td></tr>
<tr><td colspan="2" class="formtable" > <input type="checkbox" name="oasistransfer_Copies_Sent_To_Physician"  
<?php if ($obj{"oasistransfer_Copies_Sent_To_Physician"} == "on"){echo "checked";};?>/><?php xl('Physician','e')?> </td></tr>
<tr><td colspan="2" class="formtable" > <input type="checkbox" name="oasistransfer_Copies_Sent_To_Facility"  
<?php if ($obj{"oasistransfer_Copies_Sent_To_Facility"} == "on"){echo "checked";};?>/><?php xl('Facility','e')?> </td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" class="formtable" ><?php xl('Name','e')?>&nbsp;&nbsp;
<input type="text" name="oasistransfer_name" size="15" value="<?php echo stripslashes($obj{"oasistransfer_name"});?>"/></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>


<tr><td colspan="2" class="formtable"><center><b><?php xl('OASIS INFORMATION','e')?></b></center></td></tr>
<tr><td colspan="2" class="formtable" >
<span style="float:left;">
<b><?php xl('Date Reviewed','e')?></b> 
<input type="text" name="oasistransfer_Reviewed_Date" size="10" title='<?php xl('yyyy-mm-dd Reviewed Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Reviewed_Date" 
	value="<?php echo stripslashes($obj{"oasistransfer_Reviewed_Date"});?>" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_Reviewed_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Reviewed_Date", ifFormat:"%Y-%m-%d", button:"img_Reviewed_date"});
   </script>
   </span>
   
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <b><?php xl('Date Entered and Locked','e')?></b> 
<input type="text" name="oasistransfer_Entered_Date" size="10" title='<?php xl('yyyy-mm-dd Entered Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Entered_Date" 
	value="<?php echo stripslashes($obj{"oasistransfer_Entered_Date"});?>" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_Entered_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Entered_Date", ifFormat:"%Y-%m-%d", button:"img_Entered_date"});
   </script>
  
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span style="float:right;">
   <b><?php xl('Date Transmitted','e')?></b> 
<input type="text" name="oasistransfer_Transmitted_Date" size="10" title='<?php xl('yyyy-mm-dd Transmitted Date','e'); ?>'
	onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' id="oasistransfer_Transmitted_Date" 
	value="<?php echo stripslashes($obj{"oasistransfer_Transmitted_Date"});?>" readonly/> 
	<img src='../../pic/show_calendar.gif' align='absbottom' width='24'	height='22' id='img_Transmitted_date'
	 border='0' alt='[?]' style='cursor: pointer; cursor: hand' 
	 title='<?php xl('Click here to choose a date','e'); ?>'> 
	 <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"oasistransfer_Transmitted_Date", ifFormat:"%Y-%m-%d", button:"img_Transmitted_date"});
   </script>
   </span>
   </td></tr>



</table>
</td></tr>

<tr><td>
</table>

<a href="javascript:top.restoreSession();form_validation('oasistransfer');"
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
                    <?php } ?>
                    </form>
                    <input type="button" value="Back" onClick="top.restoreSession();window.location='<?php echo $GLOBALS['webroot'] ?>/interface/patient_file/encounter/encounter_top.php';"/>&nbsp;&nbsp;
                    <?php if($action == "review") { ?>
                    <input type="button" value="Sign" id="signoff" href="#login_form" <?php echo $signDisabled;?> />
                    <?php } ?>
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
