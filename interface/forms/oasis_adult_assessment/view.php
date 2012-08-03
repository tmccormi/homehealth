<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: OASIS_C"); 
/* include api.inc. also required. */
require_once($GLOBALS['srcdir'].'/api.inc');
/* include our smarty derived controller class. */
require($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');
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
$formTable = "forms_oasis_adult_assessment";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();
?>

<html>
<head>
<title>OASIS</title>
<style type="text/css">
.bold {
	font-weight: bold;
}
table label ,input { display:inline !important; }
a { font-size:12px; }
ul { list-style:none; padding:0; margin:0px; margin:0px 10px; }
#oasis li { padding:5px 0px;}
#oasis li div { border-bottom:1px solid #000000; padding:5px 0px; }
#oasis li a#black { color:#000000; font-weight:bold; font-size:13px; }
#oasis li ul { display:none; }

</style>
<?php html_header_show();?>

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
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
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
<?php
$obj = formFetch("forms_oasis_adult_assessment", $_GET["id"]);

$val = array();
foreach($obj as $k => $v) {
	$key = $k;
	$$key = explode('#',$v);
}


?>
<body class="body_top">
		<h3 align="center"><?php xl('ADULT ASSESSMENT','e')?></h3>
<form method="post" id="submitForm"
		action="<?php echo $rootdir?>/forms/oasis_adult_assessment/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="adult_assessment" onsubmit="return top.restoreSession();" enctype="multipart/form-data">

	
	<table width="100%" border="0" class="formtable">
<tr valign="top">
<td align="left" width="40%">
<?php xl('Patient:','e')?>
<input type="text" name="oasis_patient"  size="40" value="<?php echo stripslashes($obj{"oasis_patient"});?>" readonly/>
</td>
<td align="right">
<?php xl('Caregiver:','e')?>&nbsp;&nbsp;
<input type="text" name="oasis_caregiver" size="15" value="<?php echo stripslashes($obj{"oasis_caregiver"});?>"/>
&nbsp;&nbsp;&nbsp;&nbsp;

<?php xl('Visit Date:','e')?>
<input type="text" name="oasis_visit_date" value="<?php echo stripslashes($obj{"oasis_visit_date"});?>" readonly/>

<br />
<?php xl('Time In:','e')?>
<select name="oasis_Time_In" id="oasis_Time_In">
<?php timeDropDown(stripslashes($obj{"oasis_Time_In"}))?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Time Out:','e')?>
<select name="oasis_Time_Out" id="oasis_Time_Out">
 <?php timeDropDown(stripslashes($obj{"oasis_Time_Out"}))?>
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
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' 
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  value='<?php echo $obj{"oasis_certification_period_from"};?>' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_certification_period_from", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
                                        </script>

<?php xl('To:','e')?>&nbsp;
<input type='text' size='10' name='oasis_certification_period_to' id='oasis_certification_period_to'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php echo $obj{"oasis_certification_period_to"};?>' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_certification_period_to", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
                                        </script>
<br/>
<b><?php xl('HEALTH INSURANCE CLAIM #:','e')?></b>&nbsp;<input type="text" name="oasisAdultAssess_Heath_Insurance_Claim" size="15" value="<?php echo stripslashes($obj{"oasisAdultAssess_Heath_Insurance_Claim"});?>"/>
<br><br/>
<hr />
<table width="100%" border="0" class="formtable">
<tr><td>
<strong><?php xl('PHYSICIAN DATE LAST CONTACTED:','e')?></strong>&nbsp;
<input type='text' size='10' name='oasis_physician_last_contacted' id='oasis_physician_last_contacted'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php echo $obj{"oasis_physician_last_contacted"};?>' readonly/>
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
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php echo $obj{"oasis_physician_last_visited"};?>' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date3' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_physician_last_visited", ifFormat:"%Y-%m-%d", button:"img_curr_date3"});
                                        </script>
<br/>
<strong><?php xl('PRIMARY REASON FOR HOME HEALTH:','e')?></strong>&nbsp;
<input type="text" name="oasis_primary_reason_home_health" size="35" value="<?php echo stripslashes($obj{"oasis_primary_reason_home_health"});?>"/>
<br/>
<input type="checkbox" name="oasis_treat_patient_illness" value="To treat patient illness or injury" <?php if($obj{"oasis_treat_patient_illness"}=="To treat patient illness or injury") echo "checked"; ?> > <?php xl('To treat patient illness or injury due to the inherent complexity of the service and the condition of
the patient','e')?> <br/>
<input type="checkbox" name="oasis_treat_patient_illness_other" value="Other" <?php if($obj{"oasis_treat_patient_illness_other"}=="Other") echo "checked"; ?> ><?php xl('Other:','e')?><br/>
<textarea rows="6" cols="42" name="oasis_treat_patient_illness_other_text"><?php echo stripslashes($obj{"oasis_treat_patient_illness_other_text"});?></textarea>
<br><br><br><br><br><br/>
</td>

</tr>
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
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Hypertension" <?php if (in_array("Hypertension",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Hypertension','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Respiratory" <?php if (in_array("Respiratory",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Respiratory','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Cancer" <?php if (in_array("Cancer",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Cancer','e')?>&nbsp;
<?php xl('site :','e')?>&nbsp;<input type="text" name="oasis_patient_history_previous_outcomes_site" size="15" value="<?php echo stripslashes($obj{"oasis_patient_history_previous_outcomes_site"});?>"/><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Open Wound" <?php if (in_array("Open Wound",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Open Wound','e')?><br/>
</td>
<td width="29%">
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Cardiac" <?php if (in_array("Cardiac",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Cardiac','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Osteoporosis" <?php if (in_array("Osteoporosis",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Osteoporosis','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Infection" <?php if (in_array("Infection",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Infection','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Surgeries" <?php if (in_array("Surgeries",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Surgeries','e')?><br/>
</td>
<td width="36%">
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Diabetes" <?php if (in_array("Diabetes",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Diabetes','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Fractures" <?php if (in_array("Fractures",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Fractures','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Immunosuppressed" <?php if (in_array("Immunosuppressed",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Immunosuppressed','e')?><br/>
<input type="checkbox" name="oasis_patient_history_previous_outcomes[]" value="Other" <?php if (in_array("Other",$oasis_patient_history_previous_outcomes)) echo "checked";?>><?php xl('Other','e')?>&nbsp;
<?php xl('(specify)','e')?>&nbsp;<input type="text" name="oasis_patient_history_previous_outcomes_other" size="19" value="<?php echo stripslashes($obj{"oasis_patient_history_previous_outcomes_other"});?>"/>
</td>
</tr>
<tr><td colspan="3">
<strong><?php xl('PRIOR HOSPITALIZATIONS','e')?></strong><br/>
<input type="radio" name="oasis_prior_hospitalizations" value="No" <?php if ($obj{"oasis_prior_hospitalizations"} == "No"){echo "checked";};?>><?php xl('No','e');?>
<input type="radio" name="oasis_prior_hospitalizations" value="Yes" <?php if ($obj{"oasis_prior_hospitalizations"} == "Yes"){echo "checked";};?> ><?php xl('Yes','e');?>&nbsp;&nbsp;&nbsp;
<?php xl('Number of times','e')?>&nbsp;
<input type="text" name="oasis_prior_hospitalizations_times" size="10" value="<?php echo stripslashes($obj{"oasis_prior_hospitalizations_times"});?>"/><br/>
<?php xl('Reason(s)/Date(s):','e')?><br>

<input type="text" name="oasis_prior_hospitalizations_Reason1" size="40" value="<?php echo stripslashes($obj{"oasis_prior_hospitalizations_Reason1"});?>"/>&nbsp;
<input type='text' size='10' name='oasis_prior_hospitalizations_date1' id='oasis_prior_hospitalizations_date1'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php echo $obj{"oasis_prior_hospitalizations_date1"};?>' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date4' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
                                                Calendar.setup({inputField:"oasis_prior_hospitalizations_date1", ifFormat:"%Y-%m-%d", button:"img_curr_date4"});
                                        </script><br/>

<input type="text" name="oasis_prior_hospitalizations_Reason2" size="40" value="<?php echo stripslashes($obj{"oasis_prior_hospitalizations_Reason2"});?>"/>&nbsp;
<input type='text' size='10' name='oasis_prior_hospitalizations_date2' id='oasis_prior_hospitalizations_date2'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php echo $obj{"oasis_prior_hospitalizations_date2"};?>' readonly/>
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
<strong><?php xl('IMMUNIZATIONS','e')?></strong>&nbsp;<input type="checkbox" name="oasis_immunizations" value="Up to Date" <?php if($obj{"oasis_immunizations"}=="Up to Date") echo "checked"; ?>><?php xl('Up to Date','e')?><br/>
<strong><?php xl('Needs :','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_immunizations_needs[]" value="Influenza" <?php if (in_array("Influenza",$oasis_immunizations_needs)) echo "checked";?>><?php xl('Influenza','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasis_immunizations_needs[]" value="Pneumonia" <?php if (in_array("Pneumonia",$oasis_immunizations_needs)) echo "checked";?>><?php xl('Pneumonia','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasis_immunizations_needs[]" value="Tetanus" <?php if (in_array("Tetanus",$oasis_immunizations_needs)) echo "checked";?>><?php xl('Tetanus','e')?>&nbsp;&nbsp;<br/>
<input type="checkbox" name="oasis_immunizations_needs[]" value="Other" <?php if (in_array("Other",$oasis_immunizations_needs)) echo "checked";?>><?php xl('Other','e')?>&nbsp;
<input type="text" name="oasis_immunizations_needs_other" size="36" value="<?php echo stripslashes($obj{"oasis_immunizations_needs_other"});?>"/>

<br/>
<strong><center><?php xl('ALLERGIES','e')?></center></strong>
<input type="checkbox" name="oasis_allergies[]" value="NKDA" <?php if (in_array("NKDA",$oasis_allergies)) echo "checked";?>><?php xl('NKDA','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Penicillin" <?php if (in_array("Penicillin",$oasis_allergies)) echo "checked";?>><?php xl('Penicillin','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Sulfa" <?php if (in_array("Sulfa",$oasis_allergies)) echo "checked";?>><?php xl('Sulfa','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Aspirin" <?php if (in_array("Aspirin",$oasis_allergies)) echo "checked";?>><?php xl('Aspirin','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Milk Products" <?php if (in_array("Milk Products",$oasis_allergies)) echo "checked";?>><?php xl('Milk Products','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Pollen" <?php if (in_array("Pollen",$oasis_allergies)) echo "checked";?>><?php xl('Pollen','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Insect Bites" <?php if (in_array("Insect Bites",$oasis_allergies)) echo "checked";?>><?php xl('Insect Bites','e')?>&nbsp;
<input type="checkbox" name="oasis_allergies[]" value="Eggs" <?php if (in_array("Eggs",$oasis_allergies)) echo "checked";?>><?php xl('Eggs','e')?>&nbsp;<br/>
<input type="checkbox" name="oasis_allergies[]" value="Other" <?php if (in_array("Other",$oasis_allergies)) echo "checked";?>><?php xl('Other','e')?>&nbsp;
<input type="text" name="oasis_allergies_other" size="46" value="<?php echo stripslashes($obj{"oasis_allergies_other"});?>"/> <br/>

<strong><center><?php xl('PROGNOSIS','e')?></center></strong>
<strong><?php xl('Prognosis:','e')?></strong>
<input type="radio" name="oasis_prognosis" value="1-Poor" <?php if ($obj{"oasis_prognosis"} == "1-Poor"){echo "checked";};?>/><?php xl('1-Poor','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_prognosis" value="2-Guarded" <?php if ($obj{"oasis_prognosis"} == "2-Guarded"){echo "checked";};?>/><?php xl('2-Guarded','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_prognosis" value="3-Fair" <?php if ($obj{"oasis_prognosis"} == "3-Fair"){echo "checked";};?>/><?php xl('3-Fair','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_prognosis" value="4-Good" <?php if ($obj{"oasis_prognosis"} == "4-Good"){echo "checked";};?>/><?php xl('4-Good','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_prognosis" value="5-Excellent" <?php if ($obj{"oasis_prognosis"} == "5-Excellent"){echo "checked";};?>/><?php xl('5-Excellent','e')?>&nbsp;&nbsp;
<br/>

<strong><center><?php xl('ADVANCE DIRECTIVES','e')?></center></strong>
<table border="0" class="formtable"><tr><td>
<input type="checkbox" name="oasis_advance_directives[]" value="Do not resuscitate" <?php if (in_array("Do not resuscitate",$oasis_advance_directives)) echo "checked";?>><?php xl('Do not resuscitate','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Organ Donor" <?php if (in_array("Organ Donor",$oasis_advance_directives)) echo "checked";?>><?php xl('Organ Donor','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Education needed" <?php if (in_array("Education needed",$oasis_advance_directives)) echo "checked";?>><?php xl('Education needed','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Copies on file" <?php if (in_array("Copies on file",$oasis_advance_directives)) echo "checked";?>><?php xl('Copies on file','e')?> 
</td><td>
<input type="checkbox" name="oasis_advance_directives[]" value="Funeral arrangements made" <?php if (in_array("Funeral arrangements made",$oasis_advance_directives)) echo "checked";?>><?php xl('Funeral arrangements made','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Durable Power of Attorney" <?php if (in_array("Durable Power of Attorney",$oasis_advance_directives)) echo "checked";?>><?php xl('Durable Power of Attorney (DPOA)','e')?><br>
<input type="checkbox" name="oasis_advance_directives[]" value="Living Will" <?php if (in_array("Living Will",$oasis_advance_directives)) echo "checked";?>><?php xl('Living Will','e')?><br>
&nbsp;
</td></tr></table>

<br/>
<strong><?php xl('Patient/Family informed:','e')?></strong>
<input type="radio" name="oasis_patient_family_informed" value="Yes" <?php if ($obj{"oasis_patient_family_informed"} == "Yes"){echo "checked";};?>/><?php xl('Yes','e')?>&nbsp;&nbsp;
<input type="radio" name="oasis_patient_family_informed" value="No" <?php if ($obj{"oasis_patient_family_informed"} == "No"){echo "checked";};?>/><?php xl('No','e')?> <br/>
<strong><?php xl('(If No, please explain.)','e')?> </strong>&nbsp;
<input type="text" name="oasis_patient_family_informed_explain" size="34" value="<?php echo stripslashes($obj{"oasis_patient_family_informed_explain"});?>"/> <br/>
</td></tr>

</table>
	</td></tr>
	
<tr>
<td width="50%">
<table width="100%" border="0" class="formtable">
<tr><td colspan="2" align="center"><strong><?php xl('SAFETY MEASURES','e')?></strong></td></tr>
<tr><td width="50%">
<input type="checkbox" name="oasis_safety_measures[]" value="911 Protocol" <?php if (in_array("911 Protocol",$oasis_safety_measures)) echo "checked";?>><?php xl('911 Protocol','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Clear Pathways" <?php if (in_array("Clear Pathways",$oasis_safety_measures)) echo "checked";?>><?php xl('Clear Pathways','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Siderails up" <?php if (in_array("Siderails up",$oasis_safety_measures)) echo "checked";?>><?php xl('Siderails up','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Safe Transfers" <?php if (in_array("Safe Transfers",$oasis_safety_measures)) echo "checked";?>><?php xl('Safe Transfers','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Equipment Safety" <?php if (in_array("Equipment Safety",$oasis_safety_measures)) echo "checked";?>><?php xl('Equipment Safety','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Infection Control Measures" <?php if (in_array("Infection Control Measures",$oasis_safety_measures)) echo "checked";?>><?php xl('Infection Control Measures','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Bleeding Precautions" <?php if (in_array("Bleeding Precautions",$oasis_safety_measures)) echo "checked";?>><?php xl('Bleeding Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Fall Precautions" <?php if (in_array("Fall Precautions",$oasis_safety_measures)) echo "checked";?>><?php xl('Fall Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Seizure Precautions" <?php if (in_array("Seizure Precautions",$oasis_safety_measures)) echo "checked";?>><?php xl('Seizure Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Universal Precautions" <?php if (in_array("Universal Precautions",$oasis_safety_measures)) echo "checked";?>><?php xl('Universal Precautions','e')?><br/>
</td>
<td width="50%" valign="top">
<input type="checkbox" name="oasis_safety_measures[]" value="Hazard-Free Environment" <?php if (in_array("Hazard-Free Environment",$oasis_safety_measures)) echo "checked";?>><?php xl('Hazard-Free Environment','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Lock W/C with transfers" <?php if (in_array("Lock W/C with transfers",$oasis_safety_measures)) echo "checked";?>><?php xl('Lock W/C with transfers','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Elevate Head of Bed" <?php if (in_array("Elevate Head of Bed",$oasis_safety_measures)) echo "checked";?>><?php xl('Elevate Head of Bed','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Medication Safety/Storage" <?php if (in_array("Medication Safety/Storage",$oasis_safety_measures)) echo "checked";?>><?php xl('Medication Safety/Storage','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Hazardous Waste Disposal" <?php if (in_array("Hazardous Waste Disposal",$oasis_safety_measures)) echo "checked";?>><?php xl('Hazardous Waste Disposal','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="24 hr. supervision" <?php if (in_array("24 hr. supervision",$oasis_safety_measures)) echo "checked";?>><?php xl('24 hr. supervision','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Neutropenic" <?php if (in_array("Neutropenic",$oasis_safety_measures)) echo "checked";?>><?php xl('Neutropenic','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="O2 Precautions" <?php if (in_array("O2 Precautions",$oasis_safety_measures)) echo "checked";?>><?php xl('O2 Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Aspiration Precautions" <?php if (in_array("Aspiration Precautions",$oasis_safety_measures)) echo "checked";?>><?php xl('Aspiration Precautions','e')?><br/>
<input type="checkbox" name="oasis_safety_measures[]" value="Walker/Cane" <?php if (in_array("Walker/Cane",$oasis_safety_measures)) echo "checked";?>><?php xl('Walker/Cane','e')?><br/>
</td></tr>
<tr><td colspan="2">
<input type="checkbox" name="oasis_safety_measures[]" value="Other" <?php if (in_array("Other",$oasis_safety_measures)) echo "checked";?>><?php xl('Other:','e')?>&nbsp;
<input type="textbox" name="oasis_safety_measures_other" size="46" value="<?php echo stripslashes($obj{"oasis_safety_measures_other"});?>" />
<br><br/>
<hr/>
</td></tr>
<tr><td colspan="2" align="center"><b><?php xl('SANITATION HAZARDS','e')?></b></td></tr>
<tr><td colspan="2">
<input type="checkbox" name="oasis_sanitation_hazards[]" value="None" <?php if (in_array("None",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('None','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate/improper food storage" <?php if (in_array("Inadequate/improper food storage",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('Inadequate/improper food storage','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate cooking refrigeration" <?php if (in_array("Inadequate cooking refrigeration",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('Inadequate cooking refrigeration','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate running water" <?php if (in_array("Inadequate running water",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('Inadequate running water','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Cluttered/soiled living room" <?php if (in_array("Cluttered/soiled living room",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('Cluttered/soiled living room','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate toileting facility" <?php if (in_array("Inadequate toileting facility",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('Inadequate toileting facility','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Inadequate sewage" <?php if (in_array("Inadequate sewage",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('Inadequate sewage','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="No scheduled trash removal" <?php if (in_array("No scheduled trash removal",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('No scheduled trash removal','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Insects/rodents present" <?php if (in_array("Insects/rodents present",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('Insects/rodents present','e')?><br/>
<input type="checkbox" name="oasis_sanitation_hazards[]" value="Other" <?php if (in_array("Other",$oasis_sanitation_hazards)) echo "checked";?>><?php xl('Other','e')?>&nbsp;
<input type="textbox" name="oasis_sanitation_hazards_other" size="46" value="<?php echo stripslashes($obj{"oasis_sanitation_hazards_other"});?>"/>
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
<input type="radio" name="oasis_safety_fire" value="Yes" <?php if ($obj{"oasis_safety_fire"} == "Yes"){echo "checked";};?>/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_fire" value="No" <?php if ($obj{"oasis_safety_fire"} == "No"){echo "checked";};?>/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_smoke" value="Yes" <?php if ($obj{"oasis_safety_smoke"} == "Yes"){echo "checked";};?>/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_smoke" value="No" <?php if ($obj{"oasis_safety_smoke"} == "No"){echo "checked";};?>/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_tested" value="Yes" <?php if ($obj{"oasis_safety_tested"} == "Yes"){echo "checked";};?>/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_tested" value="No" <?php if ($obj{"oasis_safety_tested"} == "No"){echo "checked";};?>/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_one_exit" value="Yes" <?php if ($obj{"oasis_safety_one_exit"} == "Yes"){echo "checked";};?>/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_one_exit" value="No" <?php if ($obj{"oasis_safety_one_exit"} == "No"){echo "checked";};?>/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_plan_exit" value="Yes" <?php if ($obj{"oasis_safety_plan_exit"} == "Yes"){echo "checked";};?>/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_plan_exit" value="No" <?php if ($obj{"oasis_safety_plan_exit"} == "No"){echo "checked";};?>/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_plan_power" value="Yes" <?php if ($obj{"oasis_safety_plan_power"} == "Yes"){echo "checked";};?>/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_plan_power" value="No" <?php if ($obj{"oasis_safety_plan_power"} == "No"){echo "checked";};?>/><?php xl('N','e')?><br/>
&nbsp;<br/>
<input type="radio" name="oasis_safety_signs_posted" value="Yes" <?php if ($obj{"oasis_safety_signs_posted"} == "Yes"){echo "checked";};?>/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_signs_posted" value="No" <?php if ($obj{"oasis_safety_signs_posted"} == "No"){echo "checked";};?>/><?php xl('N','e')?><br/>
<input type="radio" name="oasis_safety_handles_smoking" value="Yes" <?php if ($obj{"oasis_safety_handles_smoking"} == "Yes"){echo "checked";};?>/><?php xl('Y','e')?>&nbsp;
<input type="radio" name="oasis_safety_handles_smoking" value="No" <?php if ($obj{"oasis_safety_handles_smoking"} == "No"){echo "checked";};?>/><?php xl('N','e')?><br/>

</td></tr>

<tr><td colspan="2">
<b><?php xl('Oxygen back-up:','e')?></b>&nbsp;
<input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Available" <?php if (in_array("Available",$oasis_safety_oxygen_backup)) echo "checked";?>><?php xl('Available','e')?>&nbsp;
<input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Knows how to use" <?php if (in_array("Knows how to use",$oasis_safety_oxygen_backup)) echo "checked";?>><?php xl('Knows how to use','e')?>&nbsp;<br/>
<input type="checkbox" name="oasis_safety_oxygen_backup[]" value="Electrical/fire safety" <?php if (in_array("Electrical/fire safety",$oasis_safety_oxygen_backup)) echo "checked";?>><?php xl('Electrical / fire safety','e')?>&nbsp;
<hr/>
</td></tr>

<tr><td width="50%" colspan="2"><b><?php xl('SAFETY HAZARDS found in the patients current place of residence: (Mark all that apply.)','e')?></b></td></tr>

<tr><td colspan="2"><table border="0" class="formtable"><tr><td width="50%">
<input type="checkbox" name="oasis_safety_hazards[]" value="None" <?php if (in_array("None",$oasis_safety_hazards)) echo "checked";?>><?php xl('None','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate floor, roof, or windows" <?php if (in_array("Inadequate floor, roof, or windows",$oasis_safety_hazards)) echo "checked";?>><?php xl('Inadequate floor, roof, or windows','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate lighting" <?php if (in_array("Inadequate lighting",$oasis_safety_hazards)) echo "checked";?>><?php xl('Inadequate lighting','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="No telephone available and / or unable to use phone" <?php if (in_array("No telephone available and / or unable to use phone",$oasis_safety_hazards)) echo "checked";?>><?php xl('No telephone available and / or unable to use phone','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe gas/electrical appliances/outlets" <?php if (in_array("Unsafe gas/electrical appliances/outlets",$oasis_safety_hazards)) echo "checked";?>><?php xl('Unsafe gas/electrical appliances/outlets','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate heating/cooling/electricity" <?php if (in_array("Inadequate heating/cooling/electricity",$oasis_safety_hazards)) echo "checked";?>><?php xl('Inadequate heating/cooling/electricity','e')?><br/>
</td>
<td width="50%">
<input type="checkbox" name="oasis_safety_hazards[]" value="Inadequate sanitation/plumbing" <?php if (in_array("Inadequate sanitation/plumbing",$oasis_safety_hazards)) echo "checked";?>><?php xl('Inadequate sanitation/plumbing','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsound structure" <?php if (in_array("Unsound structure",$oasis_safety_hazards)) echo "checked";?>><?php xl('Unsound structure','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe placement of rugs/cords furniture" <?php if (in_array("Unsafe placement of rugs/cords furniture",$oasis_safety_hazards)) echo "checked";?>><?php xl('Unsafe placement of rugs/cords furniture','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe functional barriers" <?php if (in_array("Unsafe functional barriers",$oasis_safety_hazards)) echo "checked";?>><?php xl('Unsafe functional barriers (i.e., stairs)','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Unsafe storage of supplies / equipment" <?php if (in_array("Unsafe storage of supplies / equipment",$oasis_safety_hazards)) echo "checked";?>><?php xl('Unsafe storage of supplies / equipment','e')?><br/>
<input type="checkbox" name="oasis_safety_hazards[]" value="Improperly stored hazardous materials" <?php if (in_array("Improperly stored hazardous materials",$oasis_safety_hazards)) echo "checked";?>><?php xl('Improperly stored hazardous materials','e')?><br/>
</td>
</tr></table></td></tr>
<tr><td colspan="2">
<input type="checkbox" name="oasis_safety_hazards[]" value="Other" <?php if (in_array("Other",$oasis_safety_hazards)) echo "checked";?>><?php xl('Other:','e')?>&nbsp;
<input type="textbox" name="oasis_safety_hazards_other" size="46" value="<?php echo stripslashes($obj{"oasis_safety_hazards_other"});?>"/>
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
						<input type="text" name="oasis_patient_diagnosis_1a" id="oasis_patient_diagnosis_1a" value="<?php echo $obj{"oasis_patient_diagnosis_1a"};?>">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2a"  id="oasis_patient_diagnosis_2a" value="<?php echo $obj{"oasis_patient_diagnosis_2a"};?>" onkeydown="fonChange(this,2,'noe')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2a_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2a_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2a_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2a_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2a_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2a_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3a" id="oasis_patient_diagnosis_3a" value="<?php echo $obj{"oasis_patient_diagnosis_3a"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('a. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4a" id="oasis_patient_diagnosis_4a" value="<?php echo $obj{"oasis_patient_diagnosis_4a"};?>" onkeydown="fonChange(this,2,'noev')">
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
						<input type="text" name="oasis_patient_diagnosis_1b" value="<?php echo $obj{"oasis_patient_diagnosis_1b"};?>">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2b" id="oasis_patient_diagnosis_2b" value="<?php echo $obj{"oasis_patient_diagnosis_2b"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2b_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2b_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2b_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2b_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2b_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2b_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3b" id="oasis_patient_diagnosis_3b"  value="<?php echo $obj{"oasis_patient_diagnosis_3b"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('b. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4b" id="oasis_patient_diagnosis_4b" value="<?php echo $obj{"oasis_patient_diagnosis_4b"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1c" value="<?php echo $obj{"oasis_patient_diagnosis_1c"};?>">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2c" id="oasis_patient_diagnosis_2c" value="<?php echo $obj{"oasis_patient_diagnosis_2c"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2c_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2c_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2c_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2c_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2c_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2c_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3c" id="oasis_patient_diagnosis_3c" value="<?php echo $obj{"oasis_patient_diagnosis_3c"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('c. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4c" id="oasis_patient_diagnosis_4c" value="<?php echo $obj{"oasis_patient_diagnosis_4c"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1d" value="<?php echo $obj{"oasis_patient_diagnosis_1d"};?>">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2d" id="oasis_patient_diagnosis_2d" value="<?php echo $obj{"oasis_patient_diagnosis_2d"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2d_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2d_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2d_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2d_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2d_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2d_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3d" id="oasis_patient_diagnosis_3d" value="<?php echo $obj{"oasis_patient_diagnosis_3d"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('d. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4d" id="oasis_patient_diagnosis_4d" value="<?php echo $obj{"oasis_patient_diagnosis_4d"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1e" value="<?php echo $obj{"oasis_patient_diagnosis_1e"};?>">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2e" id="oasis_patient_diagnosis_2e" value="<?php echo $obj{"oasis_patient_diagnosis_2e"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2e_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2e_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2e_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2e_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2e_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2e_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3e" id="oasis_patient_diagnosis_3e" value="<?php echo $obj{"oasis_patient_diagnosis_3e"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('e. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4e" id="oasis_patient_diagnosis_4e" value="<?php echo $obj{"oasis_patient_diagnosis_4e"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1f" value="<?php echo $obj{"oasis_patient_diagnosis_1f"};?>">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2f" id="oasis_patient_diagnosis_2f" value="<?php echo $obj{"oasis_patient_diagnosis_2f"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2f_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2f_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2f_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2f_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2f_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2f_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3f" id="oasis_patient_diagnosis_3f" value="<?php echo $obj{"oasis_patient_diagnosis_3f"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('f. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4f" id="oasis_patient_diagnosis_4f" value="<?php echo $obj{"oasis_patient_diagnosis_4f"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1g" value="<?php echo $obj{"oasis_patient_diagnosis_1g"};?>">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2g" id="oasis_patient_diagnosis_2g" value="<?php echo $obj{"oasis_patient_diagnosis_2g"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2g_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2g_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2g_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2g_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2g_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2g_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3g" id="oasis_patient_diagnosis_3g" value="<?php echo $obj{"oasis_patient_diagnosis_3g"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('g. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4g"  id="oasis_patient_diagnosis_4g" value="<?php echo $obj{"oasis_patient_diagnosis_4g"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1h" value="<?php echo $obj{"oasis_patient_diagnosis_1h"};?>">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2h" id="oasis_patient_diagnosis_2h" value="<?php echo $obj{"oasis_patient_diagnosis_2h"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2h_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2h_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2h_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2h_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2h_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2h_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3h" id="oasis_patient_diagnosis_3h" value="<?php echo $obj{"oasis_patient_diagnosis_3h"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('h. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4h" id="oasis_patient_diagnosis_4h" value="<?php echo $obj{"oasis_patient_diagnosis_4h"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1i"  value="<?php echo $obj{"oasis_patient_diagnosis_1i"};?>">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2i" id="oasis_patient_diagnosis_2i" value="<?php echo $obj{"oasis_patient_diagnosis_2i"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2i_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2i_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2i_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2i_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2i_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2i_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3i" id="oasis_patient_diagnosis_3i" value="<?php echo $obj{"oasis_patient_diagnosis_3i"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('i. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4i" id="oasis_patient_diagnosis_4i" value="<?php echo $obj{"oasis_patient_diagnosis_4i"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1j" value="<?php echo $obj{"oasis_patient_diagnosis_1j"};?>">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2j" id="oasis_patient_diagnosis_2j" value="<?php echo $obj{"oasis_patient_diagnosis_2j"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2j_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2j_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2j_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2j_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2j_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2j_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3j" id="oasis_patient_diagnosis_3j" value="<?php echo $obj{"oasis_patient_diagnosis_3j"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('j. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4j" id="oasis_patient_diagnosis_4j" value="<?php echo $obj{"oasis_patient_diagnosis_4j"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1k" value="<?php echo $obj{"oasis_patient_diagnosis_1k"};?>">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2k" id="oasis_patient_diagnosis_2k" value="<?php echo $obj{"oasis_patient_diagnosis_2k"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2k_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2k_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2k_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2k_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2k_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2k_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3k" id="oasis_patient_diagnosis_3k" value="<?php echo $obj{"oasis_patient_diagnosis_3k"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('k. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4k" id="oasis_patient_diagnosis_4k" value="<?php echo $obj{"oasis_patient_diagnosis_4k"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1l" value="<?php echo $obj{"oasis_patient_diagnosis_1l"};?>">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2l" id="oasis_patient_diagnosis_2l" value="<?php echo $obj{"oasis_patient_diagnosis_2l"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2l_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2l_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2l_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2l_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2l_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2l_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3l" id="oasis_patient_diagnosis_3l" value="<?php echo $obj{"oasis_patient_diagnosis_3l"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('l. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4l" id="oasis_patient_diagnosis_4l" value="<?php echo $obj{"oasis_patient_diagnosis_4l"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
				</tr>
				<tr>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_1m" value="<?php echo $obj{"oasis_patient_diagnosis_1m"};?>">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_2m" id="oasis_patient_diagnosis_2m" value="<?php echo $obj{"oasis_patient_diagnosis_2m"};?>" onkeydown="fonChange(this,2,'all')"><br>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="0" <?php if($obj{"oasis_patient_diagnosis_2m_sub"}=="0"){echo "checked";}?> ><?php xl(' 0 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="1" <?php if($obj{"oasis_patient_diagnosis_2m_sub"}=="1"){echo "checked";}?> ><?php xl(' 1 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="2" <?php if($obj{"oasis_patient_diagnosis_2m_sub"}=="2"){echo "checked";}?> ><?php xl(' 2 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="3" <?php if($obj{"oasis_patient_diagnosis_2m_sub"}=="3"){echo "checked";}?> ><?php xl(' 3 ','e');?></label>
						<label><input type="radio" name="oasis_patient_diagnosis_2m_sub" value="4" <?php if($obj{"oasis_patient_diagnosis_2m_sub"}=="4"){echo "checked";}?> ><?php xl(' 4 ','e');?></label>
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_3m" id="oasis_patient_diagnosis_3m" value="<?php echo $obj{"oasis_patient_diagnosis_3m"};?>" onkeydown="fonChange(this,2,'noev')">
					</td>
					<td>
						<?php xl('m. ','e');?>
						<input type="text" name="oasis_patient_diagnosis_4m" id="oasis_patient_diagnosis_4m" value="<?php echo $obj{"oasis_patient_diagnosis_4m"};?>" onkeydown="fonChange(this,2,'noev')">
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
	<strong><?php xl('Name: ','e');?></strong>&nbsp;<input type="textbox" name="oasis_patient_history_caregiver" size="37" value="<?php echo stripslashes($obj{"oasis_patient_history_caregiver"});?>"/>
	<br><strong><?php xl('Relationship: ','e');?></strong>&nbsp;<input type="textbox" name="oasis_caregiver_relationship" size="30" value="<?php echo stripslashes($obj{"oasis_caregiver_relationship"});?>"/>
	<br><strong><?php xl('Phone Number ','e');?></strong>&nbsp;<strong><?php xl('(if different from patient) ','e');?></strong>
	<br><input type="textbox" name="oasis_caregiver_phonenumber" size="28" value="<?php echo stripslashes($obj{"oasis_caregiver_phonenumber"});?>"/>
	<br><br><br><br><br/><br>
	</td>
	<td width="50%">
	<strong><?php xl('Language spoken: ','e');?></strong>&nbsp;
	<input type="checkbox" name="oasis_language_spoken[]" value="English" <?php if (in_array("English",$oasis_language_spoken)) echo "checked";?>><?php xl('English','e')?>&nbsp;
	<input type="checkbox" name="oasis_language_spoken[]" value="Spanish" <?php if (in_array("Spanish",$oasis_language_spoken)) echo "checked";?>><?php xl('Spanish','e')?>&nbsp;
	<input type="checkbox" name="oasis_language_spoken[]" value="Russian" <?php if (in_array("Russian",$oasis_language_spoken)) echo "checked";?>><?php xl('Russian','e')?>&nbsp;
	<br/><input type="checkbox" name="oasis_language_spoken[]" value="Other" <?php if (in_array("Other",$oasis_language_spoken)) echo "checked";?>><?php xl('Other','e')?>&nbsp;
	<input type="textbox" name="oasis_language_spoken_other" size="45" value="<?php echo stripslashes($obj{"oasis_language_spoken_other"});?>"/><br>
	<strong><?php xl('Comments: ','e');?></strong><br>
	<textarea rows="6" cols="42" name="oasis_patient_history_commnets"><?php echo stripslashes($obj{"oasis_patient_history_commnets"});?></textarea>
	<br>
	<strong><?php xl('Able to safely care for patient','e');?></strong>&nbsp;
	<input type="radio" name="oasis_able_to_care" value="Yes" <?php if ($obj{"oasis_able_to_care"} == "Yes"){echo "checked";};?>/><?php xl('Yes','e')?>&nbsp;
    <input type="radio" name="oasis_able_to_care" value="No" <?php if ($obj{"oasis_able_to_care"} == "No"){echo "checked";};?>/><?php xl('No','e')?><br/>
	<strong><?php xl('If No, reason:','e');?></strong>&nbsp;<input type="textbox" name="oasis_able_to_care_reason" size="41" value="<?php echo stripslashes($obj{"oasis_able_to_care_reason"});?>"/><br>
	
	
	</td></tr>
		<tr><td  width="50%">
<table width="100%" border="0" class="formtable">
<tr><td align="center" colspan="3"><strong><?php xl('FUNCTIONAL LIMITATIONS','e')?></strong></td></tr>
<tr>
<td width="33%">
<input type="checkbox" name="oasis_functional_limitations[]" value="Amputation" <?php if (in_array("Amputation",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Amputation','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Hearing" <?php if (in_array("Hearing",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Hearing','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Ambulation" <?php if (in_array("Ambulation",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Ambulation','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Dyspnea with Minimal Exertion" <?php if (in_array("Dyspnea with Minimal Exertion",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Dyspnea with Minimal Exertion','e')?><br/>
</td>

<td width="33%">
<input type="checkbox" name="oasis_functional_limitations[]" value="Bowel/Bladder" <?php if (in_array("Bowel/Bladder",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Bowel/Bladder (Incontinence)','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Paralysis" <?php if (in_array("Paralysis",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Paralysis','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Speech" <?php if (in_array("Speech",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Speech','e')?><br/>
<br></td>

<td width="33%">
<input type="checkbox" name="oasis_functional_limitations[]" value="Contracture" <?php if (in_array("Contracture",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Contracture','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Endurance" <?php if (in_array("Endurance",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Endurance','e')?><br/>
<input type="checkbox" name="oasis_functional_limitations[]" value="Legally Blind" <?php if (in_array("Legally Blind",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Legally Blind','e')?><br/>
<br><br></td>
</tr>
<tr><td width="33%" colspan="3">
<input type="checkbox" name="oasis_functional_limitations[]" value="Other" <?php if (in_array("Other",$oasis_functional_limitations)) echo "checked";?>/><?php xl('Other (specify):','e')?>
<input type="textbox" name="oasis_functional_limitations_other" size="40" value="<?php echo stripslashes($obj{"oasis_functional_limitations_other"});?>"/>
<br><br>
</td></tr>

<tr><td colspan="3" align="center">
<strong><?php xl('MUSCULOSKELETAL','e')?></strong></td></tr>

<tr><td colspan="3">
<input type="checkbox" name="oasis_musculoskeletal[]" value="No Problem" <?php if (in_array("No Problem",$oasis_musculoskeletal)) echo "checked";?> /><?php xl('No Problem','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Fracture" <?php if (in_array("Fracture",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Fracture (location)','e')?>&nbsp;
<input type="textbox" name="oasis_musculoskeletal_fracture_location" size="37" value="<?php echo stripslashes($obj{"oasis_musculoskeletal_fracture_location"});?>"/><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Swollen,painful joints" <?php if (in_array("Swollen,painful joints",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Swollen, painful joints (specify)','e')?>&nbsp;
<input type="textbox" name="oasis_musculoskeletal_swollen" size="25" value="<?php echo stripslashes($obj{"oasis_musculoskeletal_swollen"});?>"/><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Contractures" <?php if (in_array("Contractures",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Contractures: Joint Location','e')?>&nbsp;
<input type="textbox" name="oasis_musculoskeletal_contractures_joint" size="28" value="<?php echo stripslashes($obj{"oasis_musculoskeletal_contractures_joint"});?>"/><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Atrophy" <?php if (in_array("Atrophy",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Atrophy','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Poor Conditioning" <?php if (in_array("Poor Conditioning",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Poor Conditioning','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Decreased ROM" <?php if (in_array("Decreased ROM",$oasis_musculoskeletal)) echo "checked";?> /><?php xl('Decreased ROM','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Paresthesia" <?php if (in_array("Paresthesia",$oasis_musculoskeletal)) echo "checked";?> /><?php xl('Paresthesia','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Shuffling/Wide-based gait" <?php if (in_array("Shuffling/Wide-based gait",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Shuffling/Wide-based gait','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Weakness" <?php if (in_array("Weakness",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Weakness','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Amputation" <?php if (in_array("Amputation",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Amputation: BK/AK/UE; R/L (specify)','e')?>&nbsp;
<br>&nbsp;&nbsp;
<input type="textbox" name="oasis_musculoskeletal_Amputation" size="45" value="<?php echo stripslashes($obj{"oasis_musculoskeletal_Amputation"});?>"/><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Hemiplegia" <?php if (in_array("Hemiplegia",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Hemiplegia','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Paraplegia" <?php if (in_array("Paraplegia",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Paraplegia','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Quadriplegia" <?php if (in_array("Quadriplegia",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Quadriplegia','e')?><br/>
<input type="checkbox" name="oasis_musculoskeletal[]" value="Other" <?php if (in_array("Other",$oasis_musculoskeletal)) echo "checked";?>/><?php xl('Other:','e')?>&nbsp;
<input type="textbox" name="oasis_musculoskeletal_other" size="49" value="<?php echo stripslashes($obj{"oasis_musculoskeletal_other"});?>"/>
<br><br><br><br><br><br>
</td></tr>

</table>
</td>

<td width="50%">

<table width="100%" border="0" class="formtable">
<tr><td align="center" colspan="3"><strong><?php xl('VISION','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_vision[]" value="No Problem" <?php if (in_array("No Problem",$oasis_vision)) echo "checked";?>/><?php xl('No Problem','e')?>
</td></tr>
<tr>
<td width="40%">

<input type="checkbox" name="oasis_vision[]" value="Glasses" <?php if (in_array("Glasses",$oasis_vision)) echo "checked";?>/><?php xl('Glasses','e')?></br/>
<input type="checkbox" name="oasis_vision[]" value="Contacts" <?php if (in_array("Contacts",$oasis_vision)) echo "checked";?>/><?php xl('Contacts:','e')?> 
<input type="checkbox" name="oasis_vision[]" value="R" <?php if (in_array("R",$oasis_vision)) echo "checked";?>/><?php xl('R','e')?>
<input type="checkbox" name="oasis_vision[]" value="L" <?php if (in_array("L",$oasis_vision)) echo "checked";?>/><?php xl('L','e')?><br/>
<input type="checkbox" name="oasis_vision[]" value="Prosthesis" <?php if (in_array("Prosthesis",$oasis_vision)) echo "checked";?>/><?php xl('Prosthesis:','e')?>
<input type="checkbox" name="oasis_vision[]" value="R" <?php if (in_array("R",$oasis_vision)) echo "checked";?>/><?php xl('R','e')?>
<input type="checkbox" name="oasis_vision[]" value="L" <?php if (in_array("L",$oasis_vision)) echo "checked";?>/><?php xl('L','e')?><br>
</td>


<td width="30%">
<input type="checkbox" name="oasis_vision[]" value="Glaucoma" <?php if (in_array("Glaucoma",$oasis_vision)) echo "checked";?>/><?php xl('Glaucoma','e')?></br/>
<input type="checkbox" name="oasis_vision[]" value="Blurred Vision" <?php if (in_array("Blurred Vision",$oasis_vision)) echo "checked";?>/><?php xl('Blurred Vision','e')?></br/>
<input type="checkbox" name="oasis_vision[]" value="Infections" <?php if (in_array("Infections",$oasis_vision)) echo "checked";?>/><?php xl('Infections','e')?> 
</td>

<td width="30%">
<input type="checkbox" name="oasis_vision[]" value="Jaundice" <?php if (in_array("Jaundice",$oasis_vision)) echo "checked";?>/><?php xl('Jaundice','e')?></br/>
<input type="checkbox" name="oasis_vision[]" value="Ptosis" <?php if (in_array("Ptosis",$oasis_vision)) echo "checked";?>/><?php xl('Ptosis','e')?></br/>
<br>
</td>
</tr>
<tr><td colspan="3">
<input type="checkbox" name="oasis_vision[]" value="Cataract surgery" <?php if (in_array("Cataract surgery",$oasis_vision)) echo "checked";?>/><?php xl('Cataract surgery: Site','e')?>&nbsp;
<input type="textbox" size="32" name="oasis_vision_cataract_surgery" value="<?php echo stripslashes($obj{"oasis_vision_cataract_surgery"});?>"/>
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('Date','e')?>&nbsp;
<input type='text' size='10' name='oasis_vision_date' id='oasis_vision_date'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php echo $obj{"oasis_vision_date"};?>' readonly/>
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
<input type="textbox" name="oasis_vision_other" size="43" value="<?php echo stripslashes($obj{"oasis_vision_other"});?>"/>
<br><br></td>
</tr>

<tr><td align="center" colspan="3"><strong><?php xl('NOSE','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_nose[]" value="No Problem" <?php if (in_array("No Problem",$oasis_nose)) echo "checked";?> /><?php xl('No Problem','e')?>
</td></tr>
<tr>
<td>
<input type="checkbox" name="oasis_nose[]" value="Congestion" <?php if (in_array("Congestion",$oasis_nose)) echo "checked";?> /><?php xl('Congestion','e')?></br/>
<input type="checkbox" name="oasis_nose[]" value="Loss of smell"  <?php if (in_array("Loss of smell",$oasis_nose)) echo "checked";?>/><?php xl('Loss of smell','e')?> 
</td>
<td>
<input type="checkbox" name="oasis_nose[]" value="Epistaxis" <?php if (in_array("Epistaxis",$oasis_nose)) echo "checked";?> /><?php xl('Epistaxis','e')?></br/>
<input type="checkbox" name="oasis_nose[]" value="Sinus problem" <?php if (in_array("Sinus problem",$oasis_nose)) echo "checked";?>/><?php xl('Sinus problem','e')?></br/>
</td>
<td>&nbsp;</td>
</tr>
<tr><td colspan="3"><?php xl('Other(specify)','e')?>&nbsp;<input type="text" name="oasis_nose_other" size="40" value="<?php echo stripslashes($obj{"oasis_nose_other"});?>"/><br><br></td></tr>

<tr><td align="center" colspan="3 "><strong><?php xl('EAR','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_ear[]"  value="No Problem" <?php if (in_array("No Problem",$oasis_ear)) echo "checked";?>/><?php xl('No Problem','e')?></br/>
</td></tr>
<tr>
<td width="40%" >
<input type="checkbox" name="oasis_ear[]" value="HOH" <?php if (in_array("HOH",$oasis_ear)) echo "checked";?> /><?php xl('HOH:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R" <?php if (in_array("R",$oasis_ear)) echo "checked";?>/><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L" <?php if (in_array("L",$oasis_ear)) echo "checked";?>/><?php xl('L','e')?> <br/>
<input type="checkbox" name="oasis_ear[]" value="Vertigo" <?php if (in_array("Vertigo",$oasis_ear)) echo "checked";?>/><?php xl('Vertigo:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R" <?php if (in_array("R",$oasis_ear)) echo "checked";?>/><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L" <?php if (in_array("L",$oasis_ear)) echo "checked";?>/><?php xl('L','e')?> <br/>
<input type="checkbox" name="oasis_ear[]" value="Deaf" <?php if (in_array("Deaf",$oasis_ear)) echo "checked";?>/><?php xl('Deaf:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R" <?php if (in_array("R",$oasis_ear)) echo "checked";?>/><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L" <?php if (in_array("L",$oasis_ear)) echo "checked";?>/><?php xl('L','e')?> <br/>

</td>

<td width="60%" colspan="2">

<input type="checkbox" name="oasis_ear[]" value="Tinnitus" <?php if (in_array("Tinnitus",$oasis_ear)) echo "checked";?>/><?php xl('Tinnitus:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R" <?php if (in_array("R",$oasis_ear)) echo "checked";?>/><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L" <?php if (in_array("L",$oasis_ear)) echo "checked";?>/><?php xl('L','e')?> <br/>
<input type="checkbox" name="oasis_ear[]" value="Hearing aid" <?php if (in_array("Hearing aid",$oasis_ear)) echo "checked";?>/><?php xl('Hearing aid:','e')?>
<input type="checkbox" name="oasis_ear[]" value="R" <?php if (in_array("R",$oasis_ear)) echo "checked";?>/><?php xl('R','e')?> 
<input type="checkbox" name="oasis_ear[]" value="L" <?php if (in_array("L",$oasis_ear)) echo "checked";?>/><?php xl('L','e')?>
</td>


</tr>
<tr><td colspan="3"><?php xl('Other(specify)','e')?>&nbsp;
<input type="text" name="oasis_ear_other" size="40" value="<?php echo stripslashes($obj{"oasis_ear_other"});?>"/><br><br></td></tr>

<tr><td align="center" colspan="3"><strong><?php xl('MOUTH','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_mouth[]" value="No Problem" <?php if (in_array("No Problem",$oasis_mouth)) echo "checked";?>/><?php xl('No Problem','e')?></td></tr>
<tr>
<td colspan="2">
<input type="checkbox" name="oasis_mouth[]" value="Dentures" <?php if (in_array("Dentures",$oasis_mouth)) echo "checked";?> /><?php xl('Dentures:','e')?>
<input type="checkbox" name="oasis_mouth[]" value="Upper" <?php if (in_array("Upper",$oasis_mouth)) echo "checked";?>/><?php xl('Upper','e')?> 
<input type="checkbox" name="oasis_mouth[]" value="Lower" <?php if (in_array("Lower",$oasis_mouth)) echo "checked";?>/><?php xl('Lower','e')?> 
<input type="checkbox" name="oasis_mouth[]" value="Partial" <?php if (in_array("Partial",$oasis_mouth)) echo "checked";?>/><?php xl('Partial','e')?><br/>
<input type="checkbox" name="oasis_mouth[]" value="Gingivitis" <?php if (in_array("Gingivitis",$oasis_mouth)) echo "checked";?>/><?php xl('Gingivitis','e')?>&nbsp;&nbsp;
<input type="checkbox" name="oasis_mouth[]" value="Masses/Tumors" <?php if (in_array("Masses/Tumors",$oasis_mouth)) echo "checked";?>/><?php xl('Masses/Tumors','e')?><br/>
</td>

<td>
<input type="checkbox" name="oasis_mouth[]" value="Ulcerations" <?php if (in_array("Ulcerations",$oasis_mouth)) echo "checked";?>/><?php xl('Ulcerations','e')?> <br/>
<input type="checkbox" name="oasis_mouth[]" value="Toothache" <?php if (in_array("Toothache",$oasis_mouth)) echo "checked";?>/><?php xl('Toothache','e')?> 
</td>
</tr>

<tr><td colspan="3"><?php xl('Other(specify)','e')?>&nbsp;
<input type="text" name="oasis_mouth_other" size="40" value="<?php echo stripslashes($obj{"oasis_mouth_other"});?>"/><br><br></td></tr>

<tr><td align="center" colspan="3"><strong><?php xl('THROAT','e')?></strong>&nbsp;
<input type="checkbox" name="oasis_throat[]"  value="No Problem" <?php if (in_array("No Problem",$oasis_throat)) echo "checked";?>/><?php xl('No Problem','e')?></td></tr>
<tr>
<td >
<input type="checkbox" name="oasis_throat[]" value="Dysphagia" <?php if (in_array("Dysphagia",$oasis_throat)) echo "checked";?> /><?php xl('Dysphagia','e')?><br/>
<input type="checkbox" name="oasis_throat[]" value="Hoarseness" <?php if (in_array("Hoarseness",$oasis_throat)) echo "checked";?>/><?php xl('Hoarseness','e')?> 
</td>

<td  colspan="2">
<input type="checkbox" name="oasis_throat[]" value="Lesions" <?php if (in_array("Lesions",$oasis_throat)) echo "checked";?>/><?php xl('Lesions','e')?><br/>
<input type="checkbox" name="oasis_throat[]" value="Sore throat" <?php if (in_array("Sore throat",$oasis_throat)) echo "checked";?>/><?php xl('Sore throat','e')?> 
</td>
</tr>

<tr><td colspan="3"><?php xl('Other(specify)','e')?>&nbsp;
<input type="text" name="oasis_throat_other" size="40" value="<?php echo stripslashes($obj{"oasis_throat_other"});?>"/><br><br></td></tr>

</table>


</td>
</tr>
<tr><td colspan="2" align="center">
<strong><?php xl('VITAL SIGNS','e')?></strong>
</td></tr>
<tr>
<td width="50%">
<table width="100%" border="0"  class="formtable">
<tr valign="top">
<td align="center"><strong><?php xl('Blood Pressure:','e')?></strong></td>
<td align="center"><?php xl('Right','e')?></td>
<td align="center"><?php xl('Left','e')?></td>
</tr>

<tr>
<td align="center"><?php xl('Lying','e')?></td>
<td align="center"><input type="text" name="oasis_vital_lying_right" id="oasis_vital_lying_right" size="15"
value="<?php echo stripslashes($obj{"oasis_vital_lying_right"});?>" /></td>
<td align="center"><input type="text" name="oasis_vital_lying_left" id="oasis_vital_lying_left" size="15"
value="<?php echo stripslashes($obj{"oasis_vital_lying_left"});?>" /></td>
</tr>
<tr>
<td align="center"><?php xl('Sitting','e')?></td>
<td align="center"><input type="text" name="oasis_vital_sitting_right" id="oasis_vital_sitting_right" size="15"
value="<?php echo stripslashes($obj{"oasis_vital_sitting_right"});?>" /></td>
<td align="center"><input type="text" name="oasis_vital_sitting_left" id="oasis_vital_sitting_left" size="15"
value="<?php echo stripslashes($obj{"oasis_vital_sitting_left"});?>" /></td>
</tr>
<tr>
<td align="center"><?php xl('Standing','e')?></td>
<td align="center"><input type="text" name="oasis_vital_standing_right" id="oasis_vital_standing_right" size="15"
value="<?php echo stripslashes($obj{"oasis_vital_standing_right"});?>" /></td>
<td align="center"><input type="text" name="oasis_vital_standing_left" id="oasis_vital_standing_left" size="15"
value="<?php echo stripslashes($obj{"oasis_vital_standing_left"});?>" /></td>
</tr>
</table>

<strong><?php xl('Temperature: Â°F','e')?></strong>&nbsp;&nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Oral"  id="oasis_vital_temp"
<?php if($obj{"oasis_vital_temp"}=="Oral") echo "checked"; ?> />
<?php xl('Oral','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Axillary"  id="oasis_vital_temp"
<?php if($obj{"oasis_vital_temp"}=="Axillary") echo "checked"; ?> />
<?php xl('Axillary','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Rectal"  id="oasis_vital_temp"
<?php if($obj{"oasis_vital_temp"}=="Rectal") echo "checked"; ?> />
<?php xl('Rectal','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Tympanic"  id="oasis_vital_temp"
<?php if($obj{"oasis_vital_temp"}=="Tympanic") echo "checked"; ?> />
<?php xl('Tympanic','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_temp" value="Temporal"  id="oasis_vital_temp"
<?php if($obj{"oasis_vital_temp"}=="Temporal") echo "checked"; ?> />
<?php xl('Temporal','e')?></label> &nbsp;

</td>

<td>

<strong><?php xl('Pulse:','e')?></strong>
<br />
<label><input type="radio" name="oasis_vital_pulse[]" value="At Rest"  id="oasis_vital_pulse"
<?php if(in_array("At Rest",$oasis_vital_pulse)) echo "checked"; ?> />
<?php xl('At Rest','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_pulse[]" value="Activity/Exercise"  id="oasis_vital_pulse"
<?php if(in_array("Activity/Exercise",$oasis_vital_pulse)) echo "checked"; ?> />
<?php xl('Activity/Exercise','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_pulse[]" value="Regular"  id="oasis_vital_pulse"
<?php if(in_array("Regular",$oasis_vital_pulse)) echo "checked"; ?> />
<?php xl('Regular','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_pulse[]" value="Irregular"  id="oasis_vital_pulse"
<?php if(in_array("Irregular",$oasis_vital_pulse)) echo "checked"; ?> />
<?php xl('Irregular','e')?></label> &nbsp;
<br />
<label><input type="checkbox" name="oasis_vital_pulse[]" value="Radial"  id="oasis_vital_pulse"
<?php if(in_array("Radial",$oasis_vital_pulse)) echo "checked"; ?> /> <?php xl('Radial','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_vital_pulse[]" value="Carotid"  id="oasis_vital_pulse"
<?php if(in_array("Carotid",$oasis_vital_pulse)) echo "checked"; ?> /> <?php xl('Carotid','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_vital_pulse[]" value="Apical"  id="oasis_vital_pulse"
<?php if(in_array("Apical",$oasis_vital_pulse)) echo "checked"; ?> /> <?php xl('Apical','e')?></label> &nbsp;
<label><input type="checkbox" name="oasis_vital_pulse[]" value="Brachial"  id="oasis_vital_pulse"
<?php if(in_array("Brachial",$oasis_vital_pulse)) echo "checked"; ?> /> <?php xl('Brachial','e')?></label> &nbsp;
<br /><br>
<strong><?php xl('Respiratory Rate:','e')?></strong>&nbsp;&nbsp;&nbsp;
<label><input type="radio" name="oasis_vital_resp_rate" value="Normal"  id="oasis_vital_resp_rate"
<?php if($obj{"oasis_vital_resp_rate"}=="Normal") echo "checked"; ?> />
<?php xl('Normal','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_resp_rate" value="Cheynes Stokes"  id="oasis_vital_resp_rate"
<?php if($obj{"oasis_vital_resp_rate"}=="Cheynes Stokes") echo "checked"; ?> />
<?php xl('Cheynes Stokes','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_resp_rate" value="Death rattle"  id="oasis_vital_resp_rate"
<?php if($obj{"oasis_vital_resp_rate"}=="Death rattle") echo "checked"; ?> />
<?php xl('Death rattle','e')?></label> &nbsp;
<label><input type="radio" name="oasis_vital_resp_rate" value="Apnea/sec"  id="oasis_vital_resp_rate"
<?php if($obj{"oasis_vital_resp_rate"}=="Apnea/sec") echo "checked"; ?> />
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
<strong><?php xl('Height:','e')?></strong>&nbsp;<input type="text" name="oasis_height" size="6" value="<?php echo stripslashes($obj{"oasis_height"});?>"/> &nbsp;
</td><td width="25%">
<label><input type="radio" name="oasis_height_check" value="actual" <?php if($obj{"oasis_height_check"}=="actual") echo "checked"; ?>/>
<?php xl('actual','e')?></label> &nbsp;<br/>
<label><input type="radio" name="oasis_height_check" value="reported" <?php if($obj{"oasis_height_check"}=="reported") echo "checked"; ?> />
<?php xl('reported','e')?></label> &nbsp;
</td>
<td width="25%">
<strong><?php xl('Weight:','e')?></strong>&nbsp;<input type="text" name="oasis_weight" size="6" value="<?php echo stripslashes($obj{"oasis_weight"});?>"/> &nbsp;
</td><td width="25%">
<label><input type="radio" name="oasis_weight_check" value="actual" <?php if($obj{"oasis_weight_check"}=="actual") echo "checked"; ?> />
<?php xl('actual','e')?></label> &nbsp;<br/>
<label><input type="radio" name="oasis_weight_check" value="reported"  <?php if($obj{"oasis_weight_check"}=="reported") echo "checked"; ?>/>
<?php xl('reported','e')?></label> &nbsp;

</td></tr></table>
</td>
<td width="50%">
<table width="100%" border="0" class="formtable">
<tr><td>
<?php xl('Any Weight Changes?','e')?>&nbsp;
<label><input type="radio" name="oasis_weight_changes" value="Yes" <?php if($obj{"oasis_weight_changes"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="oasis_weight_changes" value="No" <?php if($obj{"oasis_weight_changes"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;<br/>
<?php xl('If yes:','e')?>&nbsp;
<label><input type="radio" name="oasis_weight_changes_yes" value="Gain"  <?php if($obj{"oasis_weight_changes_yes"}=="Gain") echo "checked"; ?>/>
<?php xl('Gain','e')?></label> &nbsp;
<input type="text" name="oasis_weight_gain" size="10" value="<?php echo stripslashes($obj{"oasis_weight_gain"});?>"/>&nbsp;
<label><input type="radio" name="oasis_weight_changes_yes" value="Loss"  <?php if($obj{"oasis_weight_changes_yes"}=="Loss") echo "checked"; ?>/>
<?php xl('Loss','e')?></label> &nbsp;
<input type="text" name="oasis_weight_loss" size="10" value="<?php echo stripslashes($obj{"oasis_weight_loss"});?>"/>&nbsp;
<?php xl('of lb. in','e')?>&nbsp;
<label><input type="radio" name="oasis_weight_changes_yes_lbin" value="wk"  <?php if($obj{"oasis_weight_changes_yes_lbin"}=="wk") echo "checked"; ?>/>
<?php xl('wk./','e')?></label> &nbsp;
<label><input type="radio" name="oasis_weight_changes_yes_lbin" value="mo" <?php if($obj{"oasis_weight_changes_yes_lbin"}=="mo") echo "checked"; ?> />
<?php xl('mo./','e')?></label> &nbsp;
<label><input type="radio" name="oasis_weight_changes_yes_lbin" value="yr" <?php if($obj{"oasis_weight_changes_yes_lbin"}=="yr") echo "checked"; ?> />
<?php xl('yr.','e')?></label> &nbsp;

</td></tr></table>
</td>
</tr></table>
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
      <strong><br /><u><?php xl('Pain Rating Scale:','e')?></u></strong>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_1" value="0"
 <?php if($obj{"oasis_pain_scale"}=="0") echo "checked"; ?> ><?php xl('0-No Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_2" value="2"
 <?php if($obj{"oasis_pain_scale"}=="2") echo "checked"; ?> ><?php xl('2-Little Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_4" value="4"
 <?php if($obj{"oasis_pain_scale"}=="4") echo "checked"; ?> ><?php xl('4-Little More Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_6" value="6"
 <?php if($obj{"oasis_pain_scale"}=="6") echo "checked"; ?> ><?php xl('6-Even More Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_8" value="8"
 <?php if($obj{"oasis_pain_scale"}=="8") echo "checked"; ?> ><?php xl('8-Lots of Pain ','e')?></label>
                        <label><input type="radio" name="oasis_pain_scale" id="painscale_10" value="10"
 <?php if($obj{"oasis_pain_scale"}=="10") echo "checked"; ?> ><?php xl('10-Worst Pain ','e')?></label>

            <br>
			
            <strong><u><?php xl('Location:','e')?></u></strong> <?php xl('Cause:','e')?>
            <input type="text" name="oasis_pain_location_cause" value="<?php echo stripslashes($obj{"oasis_pain_location_cause"});?>" style="width:50%;" ><br>
            <strong><u><?php xl('Description:','e')?></u></strong><br>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("sharp","e");?>"
<?php if($obj{"oasis_pain_description"}=="sharp") echo "checked"; ?> ><?php xl('sharp','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("dull","e");?>"
<?php if($obj{"oasis_pain_description"}=="dull") echo "checked"; ?> ><?php xl('dull','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("cramping","e");?>"
<?php if($obj{"oasis_pain_description"}=="cramping") echo "checked"; ?> ><?php xl('cramping','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("aching","e");?>"
 <?php if($obj{"oasis_pain_description"}=="aching") echo "checked"; ?> ><?php xl('aching','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("burning","e");?>"
 <?php if($obj{"oasis_pain_description"}=="burning") echo "checked"; ?> ><?php xl('burning','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("tingling","e");?>"
 <?php if($obj{"oasis_pain_description"}=="tingling") echo "checked"; ?> ><?php xl('tingling','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("throbbing","e");?>"
 <?php if($obj{"oasis_pain_description"}=="throbbing") echo "checked"; ?> ><?php xl('throbbing','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("shooting","e");?>"
 <?php if($obj{"oasis_pain_description"}=="shooting") echo "checked"; ?> ><?php xl('shooting','e')?></label>
            <label><input type="checkbox" name="oasis_pain_description" value="<?php xl("pinching","e");?>"
 <?php if($obj{"oasis_pain_description"}=="pinching") echo "checked"; ?> ><?php xl('pinching','e')?></label><br>

             <strong><u><?php xl('Frequency:','e')?></u></strong><br>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl('occasional','e');?>"
 <?php if($obj{"oasis_pain_frequency"}=="occasional") echo "checked"; ?> ><?php xl('occasional','e')?></label>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl("intermittent","e");?>"
 <?php if($obj{"oasis_pain_frequency"}=="intermittent") echo "checked"; ?> ><?php xl('intermittent','e')?></label>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl("continuous","e");?>"
 <?php if($obj{"oasis_pain_frequency"}=="continuous") echo "checked"; ?> ><?php xl('continuous','e')?></label>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl('at rest','e');?>"
 <?php if($obj{"oasis_pain_frequency"}=="at rest") echo "checked"; ?> ><?php xl('at rest','e')?></label>
            <label><input type="checkbox" name="oasis_pain_frequency" value="<?php xl('at night','e');?>"
 <?php if($obj{"oasis_pain_frequency"}=="at night") echo "checked"; ?> ><?php xl('at night','e')?></label><br>

            <strong><u><?php xl('Aggravating factors:','e')?></u></strong><br>
            <label><input type="checkbox" name="oasis_pain_aggravating_factors" value="<?php xl("movement","e");?>"
 <?php if($obj{"oasis_pain_aggravating_factors"}=="movement") echo "checked"; ?> ><?php xl('movement','e')?></label>
  <label><input type="checkbox" name="oasis_pain_aggravating_factors" value="<?php xl('time of day','e');?>"
 <?php if($obj{"oasis_pain_aggravating_factors"}=="time of day") echo "checked"; ?> ><?php xl('time of day','e')?></label>
            <label><input type="checkbox" name="oasis_pain_aggravating_factors" value="<?php xl("posture","e");?>"
 <?php if($obj{"oasis_pain_aggravating_factors"}=="posture") echo "checked"; ?> ><?php xl('posture','e')?></label>
<label><input type="checkbox" name="oasis_pain_aggravating_factors" value="<?php xl("other","e");?>"
 <?php if($obj{"oasis_pain_aggravating_factors"}=="other") echo "checked"; ?> ><?php xl('other','e')?></label>
<input type="text" name="oasis_pain_aggravating_factors_other" style="width:48%;" value="<?php echo stripslashes($obj{"oasis_pain_aggravating_factors_other"});?>"  ><br>

            <strong><u><?php xl('Relieving factors:','e')?></u></strong><br>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("medication","e");?>"
 <?php if(in_array("medication",$oasis_pain_relieving_factors)) echo "checked"; ?> ><?php xl('medication','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("rest","e");?>"
 <?php if(in_array("rest",$oasis_pain_relieving_factors)) echo "checked"; ?> ><?php xl('rest','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("heat","e");?>"
 <?php if(in_array("heat",$oasis_pain_relieving_factors)) echo "checked"; ?> ><?php xl('heat','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("ice","e");?>"
 <?php if(in_array("ice",$oasis_pain_relieving_factors)) echo "checked"; ?> ><?php xl('ice','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("massage","e");?>"
 <?php if(in_array("massage",$oasis_pain_relieving_factors)) echo "checked"; ?> ><?php xl('massage','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("repositioning","e");?>"
 <?php if(in_array("repositioning",$oasis_pain_relieving_factors)) echo "checked"; ?> ><?php xl('repositioning','e')?></label>
            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("diversion","e");?>"
 <?php if(in_array("diversion",$oasis_pain_relieving_factors)) echo "checked"; ?> ><?php xl('diversion','e')?></label>
<br/>            <label><input type="checkbox" name="oasis_pain_relieving_factors[]" value="<?php xl("other","e");?>"
 <?php if(in_array("other",$oasis_pain_relieving_factors)) echo "checked"; ?> ><?php xl('other','e')?></label>
<input type="text" name="oasis_pain_relieving_factors_other" style="width:78%;"
value="<?php echo stripslashes($obj{"oasis_pain_relieving_factors_other"});?>"  ><br>

<strong><u><?php xl('Activities limited:','e')?></u></strong><br>
<textarea name="oasis_pain_activities_limited" rows="2" cols="82">
<?php echo stripslashes($obj{"oasis_pain_activities_limited"});?>
</textarea>
		
		
		</td></tr>
		
		<tr><td width="50%">
		<?php xl('Is patient experiencing pain?','e')?>&nbsp;
		<label><input type="radio" name="oasis_pain_experiencing" value="Yes" <?php if($obj{"oasis_pain_experiencing"}=="Yes") echo "checked"; ?>/>
		<?php xl('Yes','e')?></label> &nbsp;
		<label><input type="radio" name="oasis_pain_experiencing" value="No" <?php if($obj{"oasis_pain_experiencing"}=="No") echo "checked"; ?>/>
		<?php xl('No','e')?></label> &nbsp;<br>
		<label><input type="checkbox" name="oasis_pain_unable_communicate" value="Unable to communicate" <?php if($obj{"oasis_pain_unable_communicate"}=="Unable to communicate") echo "checked"; ?>><?php xl('Unable to communicate','e')?></label><br>
		<strong><?php xl('Non-verbals demonstrated:','e')?></strong>&nbsp;<br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Diaphoresis" <?php if(in_array("Diaphoresis",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Diaphoresis','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Grimacing" <?php if(in_array("Grimacing",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Grimacing','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Moaning/Crying" <?php if(in_array("Moaning/Crying",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Moaning/Crying','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Guarding" <?php if(in_array("Guarding",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Guarding','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Irritability" <?php if(in_array("Irritability",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Irritability','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Anger" <?php if(in_array("Anger",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Anger','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Tense" <?php if(in_array("Tense",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Tense','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Restlessness" <?php if(in_array("Restlessness",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Restlessness','e')?></label>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Change in vital signs" <?php if(in_array("Change in vital signs",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Change in vital signs','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Other" <?php if(in_array("Other",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Other:','e')?></label>&nbsp;
		<input type="text" name="oasis_pain_non_verbals_other" style="width:50%;" value="<?php echo stripslashes($obj{"oasis_pain_non_verbals_other"});?>"> <br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Self-assessment" <?php if(in_array("Self-assessment",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Self-assessment','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_non_verbals[]" value="Implications" <?php if(in_array("Implications",$oasis_pain_non_verbals)) echo "checked"; ?>><?php xl('Implications:','e')?></label>&nbsp;
		<input type="text" name="oasis_pain_non_verbals_implications" style="width:50%;" value="<?php echo stripslashes($obj{"oasis_pain_non_verbals_implications"});?>" >
				
		</td><td width="50%">
		<?php xl('How often is breakthrough medication needed?','e')?>&nbsp;<br/>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="Never" <?php if($obj{"oasis_pain_breakthrough_medication"}=="Never") echo "checked"; ?>><?php xl('Never','e')?></label>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="Less than daily" <?php if($obj{"oasis_pain_breakthrough_medication"}=="Less than daily") echo "checked"; ?>><?php xl('Less than daily','e')?></label>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="2-3 times/day" <?php if($obj{"oasis_pain_breakthrough_medication"}=="2-3 times/day") echo "checked"; ?>><?php xl('2-3 times/day','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="More than 3 times/day" <?php if($obj{"oasis_pain_breakthrough_medication"}=="More than 3 times/day") echo "checked"; ?> ><?php xl('More than 3 times/day','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="Current pain control medications adequate" <?php if($obj{"oasis_pain_breakthrough_medication"}=="Current pain control medications adequate") echo "checked"; ?> ><?php xl('Current pain control medications adequate','e')?></label><br/>
		<label><input type="checkbox" name="oasis_pain_breakthrough_medication" value="other" <?php if($obj{"oasis_pain_breakthrough_medication"}=="other") echo "checked"; ?>><?php xl('other:','e')?></label>&nbsp;
		<input type="text" name="oasis_pain_breakthrough_medication_other" style="width:50%;" value="<?php echo stripslashes($obj{"oasis_pain_breakthrough_medication_other"});?>" ><br/>
		<?php xl('Implications Care Plan:','e')?>&nbsp;
		<label><input type="radio" name="oasis_pain_breakthrough_implication" value="Yes" <?php if($obj{"oasis_pain_breakthrough_implication"}=="Yes") echo "checked"; ?> />
		<?php xl('Yes','e')?></label> &nbsp;
		<label><input type="radio" name="oasis_pain_breakthrough_implication" value="No" <?php if($obj{"oasis_pain_breakthrough_implication"}=="No") echo "checked"; ?> />
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
		<input type="text" name="oasis_go_test_trail1" id="gotest_trail1" onKeyUp="Go_test_average()" style="width:100%;" value="<?php echo stripslashes($obj{"oasis_go_test_trail1"});?>"><br/>
		<input type="text" name="oasis_go_test_trail2" id="gotest_trail2" onKeyUp="Go_test_average()" style="width:100%;" value="<?php echo stripslashes($obj{"oasis_go_test_trail2"});?>"><br/>
		<input type="text" name="oasis_go_test_avg" id="gotest_average" style="width:100%;" value="<?php echo stripslashes($obj{"oasis_go_test_avg"});?>" readonly ><br/>
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
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Good" <?php if(in_array("Good",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Good','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Poor" <?php if(in_array("Poor",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Poor','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Edema" <?php if(in_array("Edema",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Edema (specify if not otherwise in assessment)','e')?></label>
		<br/>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Itch" <?php if(in_array("Itch",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Itch','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Rash" <?php if(in_array("Rash",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Rash','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Dry" <?php if(in_array("Dry",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Dry','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Scaling" <?php if(in_array("Scaling",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Scaling','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Redness" <?php if(in_array("Redness",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Redness','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Bruises" <?php if(in_array("Bruises",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Bruises','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Ecchymosis" <?php if(in_array("Ecchymosis",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Ecchymosis','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Pallor" <?php if(in_array("Pallor",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Pallor','e')?></label>
		<label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Jaundice" <?php if(in_array("Jaundice",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Jaundice','e')?></label>
		<br/><label><input type="checkbox" name="oasis_integumentary_status_conditions[]" value="Other" <?php if(in_array("Other",$oasis_integumentary_status_conditions)) echo "checked"; ?>><?php xl('Other (specify)','e')?></label>&nbsp;
		<input type="text" name="oasis_integumentary_status_conditions_other" style="width:50%;" value="<?php echo stripslashes($obj{"oasis_integumentary_status_conditions_other"});?>">
		
		</td>
		</tr>
		
		<tr><td colspan="2">
		
		 <table border="1px" cellspacing="0" class="formtable">
                <tr>
                    <td align="center" colspan="6">
       <strong><?php xl("BRADEN SCALE - For Predicting Pressure Sore Risk","e");?></strong><br>
                        <?php xl("*Fill out per organizational policy","e");?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                        <input type="text" name="oasis_braden_scale_sensory" onKeyUp="sum_braden_scale()"
id="braden_sensory"
value="<?php echo stripslashes($obj{"oasis_braden_scale_sensory"});?>" />
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("MOISTURE","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("1. CONSTANTLY
MOIST","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("2. OFTEN MOIST","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("3. OCCASIONALLY
MOIST","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("4. RARELY MOIST","e");?></strong>
                    </td>
                    <td align="center">
                        <input type="text"
name="oasis_braden_scale_moisture" onKeyUp="sum_braden_scale()"
id="braden_moisture" value="<?php echo stripslashes($obj{"oasis_braden_scale_moisture"});?>" >
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
                        <input type="text" name="oasis_braden_scale_activity" onKeyUp="sum_braden_scale()"
id="braden_activity" value="<?php echo stripslashes($obj{"oasis_braden_scale_activity"});?>" >
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
                        <input type="text" name="oasis_braden_scale_mobility" onKeyUp="sum_braden_scale()" id="braden_mobility" value="<?php echo stripslashes($obj{"oasis_braden_scale_mobility"});?>" >
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
                        <input type="text" name="oasis_braden_scale_nutrition" onKeyUp="sum_braden_scale()" id="braden_nutrition" value="<?php echo stripslashes($obj{"oasis_braden_scale_nutrition"});?>" >
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
                    <td align="center">
                       &nbsp;
                    </td>
                    <td align="center">
                        <input type="text" name="oasis_braden_scale_friction" onKeyUp="sum_braden_scale()" id="braden_friction" value="<?php echo stripslashes($obj{"oasis_braden_scale_friction"});?>" >
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
               <input type="text" name="oasis_braden_scale_total" id="braden_total" value="<?php echo stripslashes($obj{"oasis_braden_scale_total"});?>" readonly>
                    </td>
                </tr>
            </table>

		
		</td>
		</tr>
		
		
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
	
	<td>
            <center><strong>
                <?php xl('INTEGUMENTARY STATUS','e')?>
                <label><input type="checkbox" name="oasis_integumentary_status_problem" value="<?php xl('No Problem',"e");?>"
<?php if($obj{"oasis_integumentary_status_problem"}=="No Problem") echo "checked"; ?> ><?php xl('No Problem','e')?></label>
            </strong></center>
            <?php xl('Wound care done:','e')?>
            <label><input type="radio" name="oasis_wound_care_done" value="Yes" <?php if($obj{"oasis_wound_care_done"}=="Yes") echo "checked"; ?> >
			<?php xl(' Yes ','e')?></label>
            <label><input type="radio" name="oasis_wound_care_done" value="No" <?php if($obj{"oasis_wound_care_done"}=="No") echo "checked"; ?> >
			<?php xl(' No ','e')?></label><br>

            <?php xl('Location(s) if patient has more than one wound site:','e')?>
            <input type="text" name="oasis_wound_location"  value="<?php echo stripslashes($obj{"oasis_wound_location"});?>" style="width:70%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Soiled dressing removed","e");?>" <?php if(in_array("Soiled dressing removed",$oasis_wound)) echo "checked"; ?> >
			<?php xl('Soiled dressing removed','e')?></label>
            <?php xl('By:','e')?>
            <label><input type="checkbox" name="oasis_wound_soiled_dressing_by" value="<?php xl("Patient","e");?>" <?php if($obj{"oasis_wound_soiled_dressing_by"}=="Patient") echo "checked"; ?> >
			<?php xl('Patient','e')?></label>
            <label><input type="checkbox" name="oasis_wound_soiled_dressing_by" value="<?php xl("Family/caregiver","e");?>" <?php if($obj{"oasis_wound_soiled_dressing_by"}=="Family/caregiver") echo "checked"; ?> >
			<?php xl('Family/caregiver','e')?></label>
            <label><input type="checkbox" name="oasis_wound_soiled_dressing_by" value="<?php xl("RN/PT","e");?>" <?php if($obj{"oasis_wound_soiled_dressing_by"}=="RN/PT") echo "checked"; ?> >
			<?php xl('RN/PT','e')?></label>
            <br>
            <?php xl('Technique:','e')?>
            <label><input type="checkbox" name="oasis_wound_soiled_technique" value="<?php xl("Sterile","e");?>" <?php if($obj{"oasis_wound_soiled_technique"}=="Sterile") echo "checked"; ?> >
			<?php xl('Sterile','e')?></label>
            <label><input type="checkbox" name="oasis_wound_soiled_technique" value="<?php xl("Clean","e");?>"
			<?php if($obj{"oasis_wound_soiled_technique"}=="Clean") echo "checked"; ?> ><?php xl('Clean','e')?></label>
            <br>

            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Wound cleaned with (specify):","e");?>" <?php if(in_array("Wound cleaned with (specify):",$oasis_wound)) echo "checked"; ?>  >
			<?php xl('Wound cleaned with (specify):','e')?></label>
            <input type="text" name="oasis_wound_cleaned"  value="<?php echo stripslashes($obj{"oasis_wound_cleaned"});?>"  style="width:45%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Wound irrigated with (specify):","e");?>"
			<?php if(in_array("Wound irrigated with (specify):",$oasis_wound)) echo "checked"; ?>  >
			<?php xl('Wound irrigated with (specify):','e')?></label>
            <input type="text" name="oasis_wound_irrigated" value="<?php echo stripslashes($obj{"oasis_wound_irrigated"});?>"  style="width:45%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Wound packed with (specify):","e");?>"
			<?php if(in_array("Wound packed with (specify):",$oasis_wound)) echo "checked"; ?>   >
			<?php xl('Wound packed with (specify):','e')?></label>
            <input type="text" name="oasis_wound_packed" value="<?php echo stripslashes($obj{"oasis_wound_packed"});?>"  style="width:45%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Wound dressing applied (specify):","e");?>" <?php if(in_array("Wound dressing applied (specify):",$oasis_wound)) echo "checked"; ?>   >
			<?php xl('Wound dressing applied (specify):','e')?></label>
            <input type="text" name="oasis_wound_dressing_apply" value="<?php echo stripslashes($obj{"oasis_wound_dressing_apply"});?>"  style="width:40%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Patient tolerated procedure well","e");?>" <?php if(in_array("Patient tolerated procedure well",$oasis_wound)) echo "checked"; ?> >
			<?php xl('Patient tolerated procedure well','e')?></label><br />
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Incision care with (specify):","e");?>" <?php if(in_array("Incision care with (specify):",$oasis_wound)) echo "checked"; ?>  >
			<?php xl('Incision care with (specify):','e')?></label>
            <input type="text" name="oasis_wound_incision" value="<?php echo stripslashes($obj{"oasis_wound_incision"});?>"  style="width:45%" ><br>
            <label><input type="checkbox" name="oasis_wound[]" value="<?php xl("Staples present","e");?>" <?php if(in_array("Staples present",$oasis_wound)) echo "checked"; ?> >
			<?php xl('Staples present','e')?></label><br>
            <?php xl("Comments:","e");?>
            <textarea name="oasis_wound_comment" rows="3" style="width:100%"><?php echo stripslashes($obj{"oasis_wound_comment"});?></textarea><br>
            <?php xl('Satisfactory return demo:','e')?>
            <label><input type="radio" name="oasis_satisfactory_return_demo" value="Yes" <?php if($obj{"oasis_satisfactory_return_demo"}=="Yes") echo "checked"; ?> >
			<?php xl(' Yes','e')?></label>
            <label><input type="radio"name="oasis_satisfactory_return_demo" value="No" <?php if($obj{"oasis_satisfactory_return_demo"}=="No") echo "checked"; ?> >
			<?php xl(' No','e')?></label><br>
            <?php xl('Education: ','e')?>
            <label><input type="checkbox" name="oasis_wound_education" value="<?php xl("Yes","e");?>"
			<?php if($obj{"oasis_wound_education"}=="Yes") echo "checked"; ?> ><?php xl('Yes','e')?></label><br>
            <?php xl("Comments:","e");?>
            <textarea name="oasis_wound_education_comment" rows="3" style="width:100%;"><?php echo stripslashes($obj{"oasis_wound_education_comment"});?></textarea>
        </td></tr></table>

	
	</td>
	<td width="50%">
	<center><strong><?php xl("WOUND LOCATIONS","e");?></strong></center><br>
	
	<?php

                /* Create a form object. */
                $c = new C_FormPainMap('oasis_adult_assessment','bodymap_man.png');

                /* Render a 'new form' page. */
                echo $c->view_action($_GET['id']);
          ?>

	
	</td></tr>
	
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
                        <input type="text" name="oasis_wound_lesion_location[]" value="<?php echo stripslashes($oasis_wound_lesion_location[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_location[]" value="<?php echo stripslashes($oasis_wound_lesion_location[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_location[]" value="<?php echo stripslashes($oasis_wound_lesion_location[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Type","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="<?php echo stripslashes($oasis_wound_lesion_type[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="<?php echo stripslashes($oasis_wound_lesion_type[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="<?php echo stripslashes($oasis_wound_lesion_type[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Status","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="<?php echo stripslashes($oasis_wound_lesion_status[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="<?php echo stripslashes($oasis_wound_lesion_status[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="<?php echo stripslashes($oasis_wound_lesion_status[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Size (cm)","e");?>
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_length[0]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_width[0]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_depth[0]);?>" >
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_length[1]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_width[1]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_depth[1]);?>" >
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_length[2]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_width[2]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_depth[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Stage (pressure ulcers only)","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="<?php echo stripslashes($oasis_wound_lesion_stage[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="<?php echo stripslashes($oasis_wound_lesion_stage[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="<?php echo stripslashes($oasis_wound_lesion_stage[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Tunneling/Undermining","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="<?php echo stripslashes($oasis_wound_lesion_tunneling[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="<?php echo stripslashes($oasis_wound_lesion_tunneling[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="<?php echo stripslashes($oasis_wound_lesion_tunneling[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Odor","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value="<?php echo stripslashes($oasis_wound_lesion_odor[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value="<?php echo stripslashes($oasis_wound_lesion_odor[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value="<?php echo stripslashes($oasis_wound_lesion_odor[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Surrounding Skin","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="<?php echo stripslashes($oasis_wound_lesion_skin[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="<?php echo stripslashes($oasis_wound_lesion_skin[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="<?php echo stripslashes($oasis_wound_lesion_skin[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Edema","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="<?php echo stripslashes($oasis_wound_lesion_edema[0]);?>" > 
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="<?php echo stripslashes($oasis_wound_lesion_edema[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="<?php echo stripslashes($oasis_wound_lesion_edema[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Stoma","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="<?php echo stripslashes($oasis_wound_lesion_stoma[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="<?php echo stripslashes($oasis_wound_lesion_stoma[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="<?php echo stripslashes($oasis_wound_lesion_stoma[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Appearance of the Wound Bed","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="<?php echo stripslashes($oasis_wound_lesion_appearance[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="<?php echo stripslashes($oasis_wound_lesion_appearance[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="<?php echo stripslashes($oasis_wound_lesion_appearance[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Drainage Amount","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="<?php echo stripslashes($oasis_wound_lesion_drainage[0]);?>" >
                    </td>
                    <td> 
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="<?php echo stripslashes($oasis_wound_lesion_drainage[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="<?php echo stripslashes($oasis_wound_lesion_drainage[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Color","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="<?php echo stripslashes($oasis_wound_lesion_color[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="<?php echo stripslashes($oasis_wound_lesion_color[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="<?php echo stripslashes($oasis_wound_lesion_color[2]);?>" >
                    </td>
                </tr>
               <tr>
                    <td>
                        <?php xl("Consistency","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="<?php echo stripslashes($oasis_wound_lesion_consistency[0]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="<?php echo stripslashes($oasis_wound_lesion_consistency[1]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="<?php echo stripslashes($oasis_wound_lesion_consistency[2]);?>" >
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
                        <input type="text" name="oasis_wound_lesion_location[]" value="<?php echo stripslashes($oasis_wound_lesion_location[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_location[]" value="<?php echo stripslashes($oasis_wound_lesion_location[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_location[]" value="<?php echo stripslashes($oasis_wound_lesion_location[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Type","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="<?php echo stripslashes($oasis_wound_lesion_type[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="<?php echo stripslashes($oasis_wound_lesion_type[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_type[]" value="<?php echo stripslashes($oasis_wound_lesion_type[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Status","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="<?php echo stripslashes($oasis_wound_lesion_status[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="<?php echo stripslashes($oasis_wound_lesion_status[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_status[]" value="<?php echo stripslashes($oasis_wound_lesion_status[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Size (cm)","e");?>
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_length[3]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_width[3]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_depth[3]);?>" >
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_length[4]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_width[4]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_depth[4]);?>" >
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" name="oasis_wound_lesion_size_length[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_length[5]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" name="oasis_wound_lesion_size_width[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_width[5]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" name="oasis_wound_lesion_size_depth[]" size="5" value="<?php echo stripslashes($oasis_wound_lesion_size_depth[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Stage (pressure ulcers only)","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="<?php echo stripslashes($oasis_wound_lesion_stage[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="<?php echo stripslashes($oasis_wound_lesion_stage[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stage[]" value="<?php echo stripslashes($oasis_wound_lesion_stage[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Tunneling/Undermining","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="<?php echo stripslashes($oasis_wound_lesion_tunneling[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="<?php echo stripslashes($oasis_wound_lesion_tunneling[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_tunneling[]" value="<?php echo stripslashes($oasis_wound_lesion_tunneling[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Odor","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value="<?php echo stripslashes($oasis_wound_lesion_odor[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value="<?php echo stripslashes($oasis_wound_lesion_odor[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_odor[]" value="<?php echo stripslashes($oasis_wound_lesion_odor[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Surrounding Skin","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="<?php echo stripslashes($oasis_wound_lesion_skin[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="<?php echo stripslashes($oasis_wound_lesion_skin[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_skin[]" value="<?php echo stripslashes($oasis_wound_lesion_skin[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Edema","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="<?php echo stripslashes($oasis_wound_lesion_edema[3]);?>" > 
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="<?php echo stripslashes($oasis_wound_lesion_edema[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_edema[]" value="<?php echo stripslashes($oasis_wound_lesion_edema[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Stoma","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="<?php echo stripslashes($oasis_wound_lesion_stoma[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="<?php echo stripslashes($oasis_wound_lesion_stoma[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_stoma[]" value="<?php echo stripslashes($oasis_wound_lesion_stoma[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Appearance of the Wound Bed","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="<?php echo stripslashes($oasis_wound_lesion_appearance[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="<?php echo stripslashes($oasis_wound_lesion_appearance[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_appearance[]" value="<?php echo stripslashes($oasis_wound_lesion_appearance[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Drainage Amount","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="<?php echo stripslashes($oasis_wound_lesion_drainage[3]);?>" >
                    </td>
                    <td> 
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="<?php echo stripslashes($oasis_wound_lesion_drainage[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_drainage[]" value="<?php echo stripslashes($oasis_wound_lesion_drainage[5]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Color","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="<?php echo stripslashes($oasis_wound_lesion_color[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="<?php echo stripslashes($oasis_wound_lesion_color[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_color[]" value="<?php echo stripslashes($oasis_wound_lesion_color[5]);?>" >
                    </td>
                </tr>
               <tr>
                    <td>
                        <?php xl("Consistency","e");?>
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="<?php echo stripslashes($oasis_wound_lesion_consistency[3]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="<?php echo stripslashes($oasis_wound_lesion_consistency[4]);?>" >
                    </td>
                    <td>
                        <input type="text" name="oasis_wound_lesion_consistency[]" value="<?php echo stripslashes($oasis_wound_lesion_consistency[5]);?>" >
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
      <a id="btn_save" href="javascript:void(0)"
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
