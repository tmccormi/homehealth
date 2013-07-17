<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: OASIS_C");
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
$formTable = "forms_OASIS";

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
table label, input { display:inherit !important; }
a { font-size:12px; }
ul { list-style:none; padding:0; margin:0px; margin:0px 10px; }
#oasis li { padding:5px 0px;}
#oasis li div { border-bottom:1px solid #000000; padding:5px 0px; }
#oasis li a#black { color:#000000; font-weight:bold; font-size:13px; }
#oasis li ul { display:none; }

</style>
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
$obj = formFetch("forms_OASIS", $_GET["id"]);

$val = array();
foreach($obj as $k => $v) {
	$key = $k;
	$$key = explode('#',$v);
}

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$integumentary_status_current_no_a = explode("#",$obj{"integumentary_status_current_no_a"});
$integumentary_status_current_no_b = explode("#",$obj{"integumentary_status_current_no_b"});
$integumentary_status_current_no_c = explode("#",$obj{"integumentary_status_current_no_c"});
$integumentary_status_current_no_d1 = explode("#",$obj{"integumentary_status_current_no_d1"});
$integumentary_status_current_no_d2 = explode("#",$obj{"integumentary_status_current_no_d2"});
$integumentary_status_current_no_d3 = explode("#",$obj{"integumentary_status_current_no_d3"});
$respiratory_status_treatments = explode("#",$obj{"respiratory_status_treatments"});
$cardiac_status_follow_up=explode("#",$obj{"cardiac_status_follow_up"});
$neuro_status_cognitive_symptoms=explode("#",$obj{"neuro_status_cognitive_symptoms"});
?>
<body class="body_top">
		<h3 align="center"><?php xl('Index','e')?></h3>
<form method="post" id="submitForm"
		action="<?php echo $rootdir?>/forms/OASIS_C/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="OASIS_C" onsubmit="return top.restoreSession();" enctype="multipart/form-data">

		<ul id="oasis">
                <li>
                    <div><a href="#" id="black">Home Health Patient Tracking Sheet</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
                            <h3 align="center"><?php xl('Home Health Patient Tracking Sheet','e')?></h3>

<table width="100%" border="1" class="formtable">
<tr><td><strong><?php xl('(M0010) C M S Certification Number:','e')?></strong>&nbsp;&nbsp;<input type="text" name="OASIS_C_certification_number" id="certification_number" value="<?php echo $OASIS_C_certification_number[0];?>" />
</td>
  </tr>
  <tr>
    <td scope="row">
        <strong><?php xl('(M0014) Branch State:','e')?></strong>&nbsp;&nbsp;
		<input type="text" name="OASIS_C_branch_state" value="<?php echo $OASIS_C_branch_state[0];?>" />
	</td>
  </tr>
  <tr>
  <td><strong>
   <?php xl('(M0016) Branch ID Number:','e')?></strong>&nbsp;&nbsp;
   <input type="text" style="width:10%" name="OASIS_C_branch_id_number" id="branch_id_number" value="<?php echo $OASIS_C_branch_id_number[0];?>" />
   </td></tr>
   <tr><td align="left">
    <strong><?php xl('(M0018) National Provider Identifier (NPI) for the attending physician who has signed the plan of care:','e')?></strong>&nbsp;&nbsp;
   <input type="text" style="width:20%" name="OASIS_C_provider_npi" id="provider_npi" value="<?php echo $OASIS_C_provider_npi[0];?>" /> <br> <input type="checkbox" name="OASIS_C_provider_npi_option" id="provider_npi_option" <?php if(in_array("UK - Unknown or Not Available",$OASIS_C_provider_npi_option)) { echo "checked"; };?>  value="UK - Unknown or Not Available" />&nbsp;&nbsp;<strong><?php xl('UK - Unknown or Not Available','e')?></strong> 
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0020) Patient ID Number:','e')?></strong>&nbsp;&nbsp;
	  <input type="text" style="width:10%" name="OASIS_C_patient_id_number" id="patient_id_number" value="<?php echo $OASIS_C_patient_id_number[0];?>" />
	 </td></tr>
	 
	 <tr><td>
	 <strong><?php xl('(M0030) Start of Care Date:','e')?></strong> &nbsp;&nbsp;
     <?php echo goals_date('OASIS_C_start_care_date',$OASIS_C_start_care_date[0]); ?>
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0032) Resumption of Care Date:','e')?></strong>&nbsp;&nbsp;
     <?php echo goals_date('OASIS_C_resumption_care_date',$OASIS_C_resumption_care_date[0]); ?>
	<input type="checkbox" name="OASIS_C_resumption_care_date_option"  value="NA - Not Applicable" <?php if(in_array("NA - Not Applicable",$OASIS_C_resumption_care_date_option)) { echo "checked"; };?> /> <strong><?php xl('NA - Not Applicable','e')?></strong>
	 </td></tr>
	 <tr><td>
	<table width="80%" cellpadding="0" cellspacing="0" class="formtable">
	<tr><td><strong><?php xl('(M0040) Patient Name:','e')?></strong></td><td><input name="OASIS_C_first_name" type="text" id="first_name" size="20" value="<?php echo $OASIS_C_first_name[0];?>" /></td><td><input name="OASIS_C_mi" type="text" id="middle_i" size="2"  value="<?php echo $OASIS_C_mi[0];?>" /></td><td><input name="OASIS_C_last_name" type="text" id="last_name" size="30" value="<?php echo $OASIS_C_last_name[0];?>" /></td><td><input name="OASIS_C_suffix" type="text" id="suffix" size="6" value="<?php echo $OASIS_C_suffix[0];?>" /></td></tr>
	<tr><td width="20%">&nbsp;</td><td width="20%"><strong><?php xl('First name:','e')?></strong></td><td width="2%"><strong><?php xl('M I','e')?></strong></td><td width="20%"><strong><?php xl('Last Name','e')?></strong></td><td width="10%"><strong><?php xl('Suffix','e')?></strong></td></tr> 
	</table>
	</td></tr>
 	 <tr><td>
	 <strong><?php xl('(M0050) Patient State of Residence:','e')?></strong>&nbsp;&nbsp;
     <input type="text" name="OASIS_C_patient_residence" id="patient_residence" value="<?php echo $OASIS_C_patient_residence[0];?>" />
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0060) Patient Zip Code:','e')?></strong>&nbsp;&nbsp;
     <input type="text" name="OASIS_C_patient_zip_code" id="patient_zip_code" value="<?php echo $OASIS_C_patient_zip_code[0];?>" />
	 </td></tr>
	 <tr><td>
	 <table class="formtable"><tr><td>
	 <strong><?php xl('(M0063) Medicare Number:','e')?></strong>&nbsp;&nbsp;</td>
     <td><input type="text" name="OASIS_C_patient_medicare_number" id="patient_medicare_number" value="<?php echo $OASIS_C_patient_medicare_number[0];?>" /></td>
     <td><input type="checkbox" name="OASIS_C_patient_medicare_number_option"  value="NA - No Medicare" <?php if(in_array("NA - No Medicare",$OASIS_C_patient_medicare_number_option)) { echo "checked"; };?> /> 
     <strong><?php xl('NA - No Medicare','e')?></strong>  
	 </td></tr>
	 <tr><td></td><td><?php xl('(including suffix)','e')?></td><td></td>
	 </table>
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0064) Social Security Number:','e')?></strong>&nbsp;&nbsp;
     <input type="text" name="OASIS_C_patient_security_number" id="patient_security_number" value="<?php echo $OASIS_C_patient_security_number[0];?>" />
     <input type="checkbox" name="OASIS_C_patient_security_number_option"  value="UK - Unknown or Not Available" <?php if(in_array("UK - Unknown or Not Available",$OASIS_C_patient_security_number_option)) { echo "checked"; };?> /> 
     <strong><?php xl('UK - Unknown or Not Available','e')?>  </strong>
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0065) Medicaid Number:','e')?></strong>&nbsp;&nbsp;
     <input type="text" name="OASIS_C_patient_medicaid_number" id="patient_medicare_number" value="<?php echo $OASIS_C_patient_medicaid_number[0];?>" />
     <input type="checkbox" name="OASIS_C_patient_medicaid_number_option"  value="NA - No Medicaid" <?php if(in_array("NA - No Medicaid",$OASIS_C_patient_medicaid_number_option)) { echo "checked"; };?> /> 
     <strong><?php xl('NA - No Medicaid','e')?> </strong> 
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0066) Birth Date:','e')?></strong>&nbsp;&nbsp;
     <?php echo goals_date('OASIS_C_birth_date',$OASIS_C_birth_date[0]); ?>
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0069) Gender:','e')?></strong>&nbsp;&nbsp;
      <input type="checkbox" name="OASIS_C_patient_gender"  value="Male" <?php if(in_array("Male",$OASIS_C_patient_gender)) { echo "checked"; };?> /> <?php xl('1 - Male','e')?>  <input type="checkbox" name="OASIS_C_patient_gender"  value="Female" <?php if(in_array("Female",$OASIS_C_patient_gender)) { echo "checked"; };?> />  2 - <?php xl('Female','e')?>
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0140) Race/Ethnicity: (Mark all that apply.)','e')?></strong>&nbsp;&nbsp;  <br />
     <table cellpadding="0" cellspacing="0" border="0" style="padding-left:15px" class="formtable">
	 <tr><td><input type="checkbox" name="OASIS_C_race_ethnicity[]" <?php if(in_array("American Indian or Alaska Native",$OASIS_C_race_ethnicity)) { echo "checked"; };?>  value="American Indian or Alaska Native" /> <?php xl('1 - American Indian or Alaska Native','e')?>    <br />
      <input type="checkbox" name="OASIS_C_race_ethnicity[]" <?php if(in_array("Asian",$OASIS_C_race_ethnicity)) { echo "checked"; };?>  value="Asian" />  <?php xl('2 - Asian','e')?>   <br />
      <input type="checkbox" name="OASIS_C_race_ethnicity[]" <?php if(in_array("Black or African-American",$OASIS_C_race_ethnicity)) { echo "checked"; };?>  value="Black or African-American" />  <?php xl('3 - Black or African-American','e')?>   <br />
      <input type="checkbox" name="OASIS_C_race_ethnicity[]" <?php if(in_array("Hispanic or Latino",$OASIS_C_race_ethnicity)) { echo "checked"; };?>  value="Hispanic or Latino" />  <?php xl('4 - Hispanic or Latino','e')?>   <br />
      <input type="checkbox" name="OASIS_C_race_ethnicity[]" <?php if(in_array("Native Hawaiian or Pacific Islander",$OASIS_C_race_ethnicity)) { echo "checked"; };?>  value="Native Hawaiian or Pacific Islander" />  <?php xl('5 - Native Hawaiian or Pacific Islander','e')?>   <br />
      <input type="checkbox" name="OASIS_C_race_ethnicity[]" <?php if(in_array("White",$OASIS_C_race_ethnicity)) { echo "checked"; };?>  value="White" />  <?php xl('6 - White','e')?></td></tr></table>
	 </td></tr>
	 <tr><td>
	 <strong><?php xl('(M0150) Current Payment Sources for Home Care: (Mark all that apply.)','e')?></strong>&nbsp;&nbsp;  <br />
<table cellpadding="0" cellspacing="0" border="0" style="padding-left:15px" class="formtable">  <tr><td>   
	 <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("None; no charge for current services",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="None; no charge for current services" /> <?php xl('0 - None; no charge for current services','e')?>    <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Medicare (traditional fee-for-service)",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Medicare (traditional fee-for-service)" />  <?php xl('1 - Medicare (traditional fee-for-service)','e')?>   <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Medicare (HMO/managed care/Advantage plan)",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Medicare (HMO/managed care/Advantage plan)" />  <?php xl('2 - Medicare (HMO/managed care/Advantage plan)','e')?>   <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Medicaid (traditional fee-for-service)",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Medicaid (traditional fee-for-service)" />  <?php xl('3 - Medicaid (traditional fee-for-service)','e')?>   <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Medicaid (HMO/managed care)",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Medicaid (HMO/managed care)" />  <?php xl('4 - Medicaid (HMO/managed care)','e')?>   <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Workers compensation",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Workers compensation" />  <?php xl('5 - Workers compensation','e')?>  <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Title programs (e.g., Title III, V, or XX)",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Title programs (e.g., Title III, V, or XX)" />  <?php xl('6 - Title programs (e.g., Title III, V, or XX)','e')?>  <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Other government (e.g., TriCare, VA, etc.)",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Other government (e.g., TriCare, VA, etc.)" />  <?php xl('7 - Other government (e.g., TriCare, VA, etc.)','e')?>  <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Private insurance",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Private insurance" />  <?php xl('8 - Private insurance','e')?>  <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Private HMO/managed care",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Private HMO/managed care" />  <?php xl('9 - Private HMO/managed care','e')?>  <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Self-pay",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Self-pay" />  <?php xl('10 - Self-pay','e')?>  <br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("Other (specify)",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="Other (specify)" />  <?php xl('11 - Other (specify)','e')?>  <input type="text" name="OASIS_C_current_payment_sources_others" value="<?php echo $OASIS_C_current_payment_sources_others[0];?>" id="OASIS_current_payment_sources_others" /><br />
      <input type="checkbox" name="OASIS_C_current_payment_sources[]" <?php if(in_array("UK - Unknown",$OASIS_C_current_payment_sources)) { echo "checked"; };?>   value="UK - Unknown" />  <?php xl('UK - Unknown','e')?></td></tr></table>
	 </td></tr>
	</table>
                        </li>
                    </ul>
                </li>
                 <li>
					 <div><a href="#" id="black">Outcome and Assessment Information Set (OASIS-C draft)</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
						<center>
						<h3 align="center"><?php xl('Outcome and Assessment Information Set (OASIS-C draft)','e')?></h3>
						<h3 align="center"><?php xl('Items to be Used at Specific Time Points','e')?></h3></center>
							<table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
<tr>
	<td>
	<strong><u><?php xl('Start of Care','e'); ?></u></strong><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php xl('Start of care - further visits planned','e'); ?>
	</td>
	<td>
	<?php xl('M0010-M0030, M0040- M0150, M1000-M1036, M1100-M1242,','e'); ?><br>
	<?php xl(' M1300-M1302, M1306, M1308-M1324, M1330-M1350,M1400, M1410,','e'); ?><br>
	<?php xl(' M1600-M1730, M1740-M1910, M2000, M2002, M2010, M2020-M2250','e'); ?>
	</td>
</tr>
<tr>
        <td>
        <strong><u><?php xl('Resumption of Care','e'); ?></u></strong><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('Resumption of care (after inpatient stay)','e'); ?>
        </td>
        <td>
        <?php xl('M0032, M0080-M0110, M1000-M1036, M1100-M1242, M1300-M1302,','e'); ?><br>
	<?php xl(' M1306, M1308-M1324, M1330-M1350, M1400, M1410,','e'); ?><br>
	<?php xl(' M1600-M1730, M1740-M1910, M2000, M2002, M2010, M2020-M2250','e'); ?>
        </td>
</tr>
<tr>
        <td>
        <strong><u><?php xl('Follow-Up','e'); ?></u></strong><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('Recertification (follow-up) assessment','e'); ?><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('Other follow-up assessment','e'); ?>
        </td>
        <td>
        <?php xl('M0080-M0100, M0110, M1020-M1030, M1200, M1242,','e'); ?><br>
        <?php xl(' M1306, M1308, M1322-M1324, M1330-M1350, M1400,','e'); ?><br>
        <?php xl(' M1610, M1620, M1630, M1810-M1860, M2030, M2200','e'); ?>
        </td>
</tr>
<tr>
        <td>
        <strong><u><?php xl('Transfer to an Inpatient Facility','e'); ?></u></strong><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('Transferred to an inpatient facility - patient not','e'); ?><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('discharged from an agency','e'); ?><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('Transferred to an inpatient facility - patient','e'); ?><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('discharged from agency','e'); ?><br>
        </td>
        <td>
        <?php xl('M0080-M0100, M1040-M1055, M1500, M1510, M2004,','e'); ?><br>
        <?php xl(' M2015, M2300-M2410, M2430-M2440, M0903, M0906','e'); ?>
        </td>
</tr>
<tr>
        <td>
        <strong><u><?php xl('Discharge from Agency - Not to an Inpatient Facility','e'); ?></u></strong><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('Death at home','e'); ?><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php xl('Discharge from agency','e'); ?><br>
        </td>
        <td>
	<br><br><br>
        <?php xl('M0080-M0100, M0903, M0906','e'); ?><br>
        <?php xl('M0080-M0100, M1032-M1100, M1230, M1242, M1306-M1350,','e'); ?><br>
        <?php xl('M1400-M1620, M1700-M1890, M2004, M2015-M2030, M2100-M2110,','e'); ?><br>
	<?php xl('M2300-M2420, M0903, M0906','e'); ?>
        </td>
</tr>



</table>

                        </li>
                    </ul>
                </li>
                <li>
					<div><a href="#" id="black">Clinical Record Items</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
						<center>
						<h3 align="center"><?php xl('CLINICAL RECORD ITEMS','e')?></h3>
						</center>
<table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="0px" class="formtable">
<tr>
            <td>
            <strong><?php xl('(M0080) Discipline of Person Completing Assessment:','e'); ?></strong><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="OASIS_C_CRI_DoPCA" value="1-RN" id="OASIS_C_CRI_DoPCA"  <?php if ($obj{"OASIS_C_CRI_DoPCA"} == "1-RN") echo "checked";;?> />
            <?php xl('1-RN','e'); ?>&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="OASIS_C_CRI_DoPCA" value="2-PT" id="OASIS_C_CRI_DoPCA" <?php if ($obj{"OASIS_C_CRI_DoPCA"} == "2-PT") echo "checked";;?> />
            <?php xl('2-PT','e'); ?>&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="OASIS_C_CRI_DoPCA" value="3-SLP/ST" id="OASIS_C_CRI_DoPCA" <?php if ($obj{"OASIS_C_CRI_DoPCA"} == "3-SLP/ST") echo "checked";;?> />
            <?php xl('3-SLP/ST','e'); ?>&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="OASIS_C_CRI_DoPCA" value="4-OT" id="OASIS_C_CRI_DoPCA" <?php if ($obj{"OASIS_C_CRI_DoPCA"} == "4-OT") echo "checked";;?> />
            <?php xl('4-OT','e'); ?>&nbsp;&nbsp;&nbsp;
            <br>
       	    <strong><?php xl('(M0090) Date Assessment Completed:','e'); ?></strong>&nbsp;&nbsp;
            <input type='text' size='20' name='OASIS_C_date_curr' id='OASIS_C_date_curr'
    value='<?php echo stripslashes($obj{"OASIS_C_date_curr"});?>'
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
   onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/>
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"OASIS_C_date_curr", ifFormat:"%Y-%m-%d", button:"img_date"});
   </script>
           <br>
           <strong><?php xl('(M0100) This Assessment is Currently Being Completed for the Following Reason:','e'); ?></strong>&nbsp;&nbsp;
           <br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <strong><u><?php xl('Start/Resumption of Care','e'); ?></u></strong><br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Resumption_Care" value="1" id="OASIS_C_CRI_Resumption_Care" <?php if ($obj{"OASIS_C_CRI_Resumption_Care"} == "1") echo "checked";;?> />
           &nbsp;&nbsp;<?php xl('1 - Start of care - further visits planned','e'); ?>&nbsp;&nbsp;&nbsp;<br>
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Resumption_Care" value="3" id="OASIS_C_CRI_Resumption_Care" <?php if ($obj{"OASIS_C_CRI_Resumption_Care"} == "3") echo "checked";;?> />
           &nbsp;&nbsp;<?php xl('3 - Resumption of care (after inpatient stay)','e'); ?>&nbsp;&nbsp;&nbsp;

           <br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <strong><u><?php xl('Follow-Up','e'); ?></u></strong><br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Follow_Up" value="4" id="OASIS_C_CRI_Follow_Up" <?php if ($obj{"OASIS_C_CRI_Follow_Up"} == "4") echo "checked";;?> />
           &nbsp;&nbsp;<?php xl('4 - Recertification (follow-up) reassessment [ Go to M0110 ]','e'); ?>&nbsp;&nbsp;&nbsp;<br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Follow_Up" value="5" id="OASIS_C_CRI_Follow_Up" <?php if ($obj{"OASIS_C_CRI_Follow_Up"} == "5") echo "checked";;?> />
           &nbsp;&nbsp;<?php xl('5 - Other follow-up [ Go to M0110 ]','e'); ?>&nbsp;&nbsp;&nbsp;

           <br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <strong><u><?php xl('Transfer to an Inpatient Facility','e'); ?></u></strong><br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Inpatient_Facility" value="6" id="OASIS_C_CRI_Inpatient_Facility" <?php if ($obj{"OASIS_C_CRI_Inpatient_Facility"} == "6") echo "checked";;?> />
           &nbsp;&nbsp;<?php xl('6 - Transferred to an inpatient facility - patient not discharged from agency [ Go to M1040]','e'); ?>&nbsp;&nbsp;&nbsp;<br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Inpatient_Facility" value="7" id="OASIS_C_CRI_Inpatient_Facility" <?php if ($obj{"OASIS_C_CRI_Inpatient_Facility"} == "7") echo "checked";;?>/>
           &nbsp;&nbsp;<?php xl('7 - Transferred to an inpatient facility - patient discharged from agency [ Go to M1040 ]','e'); ?>&nbsp;&nbsp;&nbsp;
 
           <br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <strong><u><?php xl('Discharge from Agency - Not to an Inpatient Facility','e'); ?></u></strong><br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Not_Inpatient_Facility" value="8" id="OASIS_C_CRI_Not_Inpatient_Facility" <?php if ($obj{"OASIS_C_CRI_Not_Inpatient_Facility"} == "8") echo "checked";;?> />
           &nbsp;&nbsp;<?php xl('8 - Death at home [ Go to M0906 ]','e'); ?>&nbsp;&nbsp;&nbsp;<br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Not_Inpatient_Facility" value="9" id="OASIS_C_CRI_Not_Inpatient_Facility"<?php if ($obj{"OASIS_C_CRI_Not_Inpatient_Facility"} == "9") echo "checked";;?> />
           &nbsp;&nbsp;<?php xl('9 - Discharge from agency [ Go to M1032 ]','e'); ?>&nbsp;&nbsp;&nbsp;
 
            
    	   <br>
           <strong><?php xl('(M0102) Date of Physician-ordered Start of Care (Resumption of Care):','e'); ?></strong>&nbsp;&nbsp;
           <?php xl('If the physician (or physician designee) ','e'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?php xl('indicated a specific start of care (resumption of care) date when the patient was referred','e'); ?>
           <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?php xl(' for home health services, record the date specified.','e'); ?>
           <br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <input type='text' size='20' name='OASIS_C_start_care' id='OASIS_C_start_care'
    value='<?php echo stripslashes($obj{"OASIS_C_start_care"});?>'
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly />
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_date1' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"OASIS_C_start_care", ifFormat:"%Y-%m-%d", button:"img_date1"});
   </script>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php xl('(Go to M0110, if date entered)','e'); ?>
	   <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_No_specific_SOC" value="NA No specific SOC date ordered by physician" id="OASIS_C_CRI_No_specific_SOC" <?php if ($obj{"OASIS_C_CRI_No_specific_SOC"} == "NA No specific SOC date ordered by physician")       echo "checked";;?> />
          <?php xl('NA - No specific SOC date ordered by physician (or physician designee)','e'); ?>


	  <br>
           <strong><?php xl('(M0104) Date of Referral:','e'); ?></strong>&nbsp;&nbsp;
           <?php xl('Indicate the date that the written or documented orders from the physician or','e'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?php xl('physician designee for initiation or resumption of care were received by the HHA.','e'); ?>
           <br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

           <input type='text' size='20' name='OASIS_C_Date_Referral' id='OASIS_C_Date_Referral'
    value='<?php echo stripslashes($obj{"OASIS_C_Date_Referral"});?>'
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly />
    <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_date2' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
    <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"OASIS_C_Date_Referral", ifFormat:"%Y-%m-%d", button:"img_date2"});
   </script>
	
	   <br>
           <strong><?php xl('(M0110) Episode Timing:','e'); ?></strong>&nbsp;&nbsp;
           <?php xl('Is the Medicare home health payment episode for which this assessment will define a','e'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?php xl('case mix group an "early" episode or a "later" episode in the patient"s current sequence of adjacent','e'); ?>
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?php xl('Medicare home health payment episodes?','e'); ?>
           <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Episode_Timing" value="1" id="OASIS_C_CRI_Episode_Timing" <?php if ($obj{"OASIS_C_CRI_Episode_Timing"} == "1") echo "checked";;?>/>
           <?php xl('1 - Early','e'); ?>
           <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Episode_Timing" value="2" id="OASIS_C_CRI_Episode_Timing" <?php if ($obj{"OASIS_C_CRI_Episode_Timing"} == "2") echo "checked";;?>/>
           <?php xl('2 - Later','e'); ?>
           <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Episode_Timing" value="UK" id="OASIS_C_CRI_Episode_Timing" <?php if ($obj{"OASIS_C_CRI_Episode_Timing"} == "UK") echo "checked";;?>/>
           <?php xl('UK - Unknown','e'); ?>
           <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="OASIS_C_CRI_Episode_Timing" value="NA" id="OASIS_C_CRI_Episode_Timing" <?php if ($obj{"OASIS_C_CRI_Episode_Timing"} == "NA") echo "checked";?>/>
           <?php xl('NA - Not Applicable: No Medicare case mix group to be defined by this assessment.','e'); ?>
 
            </td>
        </tr>


</table>
                        </li>
                    </ul>
                </li>
                 <li>
					<div><a href="#" id="black">Patient History and Diagnoses</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table width="100%" align="center" cellspacing="0px" cellpadding="0px" class="formtable">
<tr>
	<td><?php xl('<strong>(M1000)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('From which of the following <strong>Inpatient Facilities</strong> was the patient discharged <u>during the past 14 days?</u> <strong>(Mark all that apply.)</strong>','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="Long-term nursing facility" <?php if(in_array("Long-term nursing facility",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> />
        <?php xl('1 - Long-term nursing facility','e'); ?><br>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="Skilled nursing facility (SNF / TCU)" <?php if(in_array("Skilled nursing facility (SNF / TCU)",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> />
        <?php xl('2 - Skilled nursing facility (SNF / TCU)','e'); ?><br>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="Hospital emergency department" <?php if(in_array("Hospital emergency department",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> />
        <?php xl('3 - Hospital emergency department','e'); ?><br>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="Short-stay acute hospital (IPP S)" <?php if(in_array("Short-stay acute hospital (IPP S)",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> />
        <?php xl('4 - Short-stay acute hospital (IPP S)','e'); ?><br>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="Long-term care hospital (LTCH)" <?php if(in_array("Long-term care hospital (LTCH)",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> /> <?php xl('5 - Long-term care hospital (LTCH)','e'); ?>
	</td>
	<td>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="Inpatient rehabilitation hospital or unit (IRF)" <?php if(in_array("Inpatient rehabilitation hospital or unit (IRF)",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> />
        <?php xl('6 - Inpatient rehabilitation hospital or unit (IRF)','e'); ?><br>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="Psychiatric hospital or unit" <?php if(in_array("Psychiatric hospital or unit",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> />
        <?php xl('7 - Psychiatric hospital or unit','e'); ?><br>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="Other (specify)" <?php if(in_array("Other (specify)",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> />
        <?php xl('8 - Other (specify)','e'); ?>&nbsp;
	<input type="text" style="width:50%" name="OASIS_C_PHAD_Inpatient_Facilities_Other" id="OASIS_C_PHAD_Inpatient_Facilities_Other" value="<?php echo $OASIS_C_PHAD_Inpatient_Facilities_Other[0];?>" /><br>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Facilities[]" value="NA - Patient was not discharged from an inpatient facility" <?php if(in_array("NA - Patient was not discharged from an inpatient facility",$OASIS_C_PHAD_Inpatient_Facilities)) { echo "checked"; };?> />
        <?php xl('NA - Patient was not discharged from an inpatient facility<strong> [Go to M1016 ]</strong>','e'); ?>&nbsp;
        </td>
</tr>
<tr>
	<td><?php xl('<strong>(M1005)</strong>','e'); ?></td>
	<td colspan="2">
        <?php xl('Inpatient Discharge Date (most recent):','e'); ?><br>
        </td><td>&nbsp;</td>	
</tr><tr>
	<td>&nbsp;</td>
	<td>
		<?php echo goals_date('OASIS_C_PHAD_date_curr',$OASIS_C_PHAD_date_curr[0]); ?>
	</td><td>
        <input type="checkbox" name="OASIS_C_PHAD_Inpatient_Discharge_UK" value="UK" <?php if(in_array("UK",$OASIS_C_PHAD_Inpatient_Discharge_UK)) { echo "checked"; };?> >
        <?php xl('UK - Unknown','e'); ?>&nbsp;
	</td>
</tr>
<tr>
	<td valign="top"><?php xl('<strong>(M1010)</strong>','e'); ?></td>
        <td colspan="2">
        <?php xl('List each <strong>Inpatient Diagnosis </strong>and ICD-9-C M code at the level of highest specificity for only those conditions treated during an inpatient stay within the last 14 days (no E-codes, or V-codes):','e'); ?><br>
        </td><td>&nbsp;</td>
</tr><tr>
	<td>&nbsp;</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u><?php xl('Inpatient Facility Diagnosis','e'); ?></u>
	</td>
	<td>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <u><?php xl('ICD-9-C M Code','e'); ?></u>
        </td>
</tr><tr>
	<td>&nbsp;</td>
	<td>
 	&nbsp;<?php xl('a.','e'); ?>&nbsp;
	<input type="text" style="width:80%" name="OASIS_C_PHAD_Facility_Diagnosis[]" id="OASIS_C_PHAD_Facility_Diagnosis1" value="<?php echo $OASIS_C_PHAD_Facility_Diagnosis[0]; ?>" />        <br>
	&nbsp;<?php xl('b.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Facility_Diagnosis[]" id="OASIS_C_PHAD_Facility_Diagnosis2" value="<?php echo $OASIS_C_PHAD_Facility_Diagnosis[1]; ?>" />
        <br>
	&nbsp;<?php xl('c.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Facility_Diagnosis[]" id="OASIS_C_PHAD_Facility_Diagnosis3" value="<?php echo $OASIS_C_PHAD_Facility_Diagnosis[2];?>" />
        <br>
	&nbsp;<?php xl('d.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Facility_Diagnosis[]" id="OASIS_C_PHAD_Facility_Diagnosis4" value="<?php echo $OASIS_C_PHAD_Facility_Diagnosis[3];?>" />
        <br>
	&nbsp;<?php xl('e.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Facility_Diagnosis[]" id="OASIS_C_PHAD_Facility_Diagnosis5" value="<?php echo $OASIS_C_PHAD_Facility_Diagnosis[4];?>" />
        <br>
	&nbsp;<?php xl('f.','e'); ?>&nbsp;&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Facility_Diagnosis[]" id="OASIS_C_PHAD_Facility_Diagnosis6" value="<?php echo $OASIS_C_PHAD_Facility_Diagnosis[5];?>" />
        </td>
	<td>
	&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_ICDMcode61" name="OASIS_C_PHAD_ICDMcode6[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_ICDMcode6[0];?>" ><br>
	&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_ICDMcode62" name="OASIS_C_PHAD_ICDMcode6[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_ICDMcode6[1];?>" ><br>
	&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_ICDMcode63" name="OASIS_C_PHAD_ICDMcode6[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_ICDMcode6[2];?>" ><br>
	&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_ICDMcode64" name="OASIS_C_PHAD_ICDMcode6[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_ICDMcode6[3];?>" ><br>
	&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_ICDMcode65" name="OASIS_C_PHAD_ICDMcode6[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_ICDMcode6[4];?>" ><br>
	&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_ICDMcode66" name="OASIS_C_PHAD_ICDMcode6[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_ICDMcode6[5];?>" >
	</td>
</tr>

<tr>
        <td><?php xl('<strong>(M1012)</strong>','e'); ?></td>
        <td colspan="2">
        <?php xl('List each <strong>Inpatient Procedure</strong> and the associated ICD-9-C M procedure code relevant to the plan of care.','e'); ?><br>
        </td><td>&nbsp;</td>
</tr><tr>
        <td>&nbsp;</td>
        <td>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <u><?php xl('Inpatient Procedure','e'); ?></u>
        </td>
        <td>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <u><?php xl('Procedure Code','e'); ?></u>
        </td>
</tr><tr>
        <td>&nbsp;</td>
        <td>
        &nbsp;<?php xl('a.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Inpatient_Procedure[]" id="OASIS_C_PHAD_Inpatient_Procedure1" value="<?php echo $OASIS_C_PHAD_Inpatient_Procedure[0];?>" />        <br>
        &nbsp;<?php xl('b.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Inpatient_Procedure[]" id="OASIS_C_PHAD_Inpatient_Procedure2" value="<?php echo $OASIS_C_PHAD_Inpatient_Procedure[1];?>" />
        <br>
        &nbsp;<?php xl('c.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Inpatient_Procedure[]" id="OASIS_C_PHAD_Inpatient_Procedure3" value="<?php echo $OASIS_C_PHAD_Inpatient_Procedure[2];?>" />
        <br>
        &nbsp;<?php xl('d.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_PHAD_Inpatient_Procedure[]" id="OASIS_C_PHAD_Inpatient_Procedure4" value="<?php echo $OASIS_C_PHAD_Inpatient_Procedure[3];?>" />
        </td>
	 <td>
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_diagnosis_ICDMcode64" name="OASIS_C_diagnosis_ICDMcode6[]" onkeydown="fonChange(this,100,'no')" value="<?php echo $OASIS_C_diagnosis_ICDMcode6[0];?>" ><br>
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_diagnosis_ICDMcode63" name="OASIS_C_diagnosis_ICDMcode6[]" onkeydown="fonChange(this,100,'no')" value="<?php echo $OASIS_C_diagnosis_ICDMcode6[1];?>" ><br>
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_diagnosis_ICDMcode62" name="OASIS_C_diagnosis_ICDMcode6[]" onkeydown="fonChange(this,100,'no')" value="<?php echo $OASIS_C_diagnosis_ICDMcode6[2];?>" ><br>
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_diagnosis_ICDMcode61" name="OASIS_C_diagnosis_ICDMcode6[]" onkeydown="fonChange(this,100,'no')" value="<?php echo $OASIS_C_diagnosis_ICDMcode6[3];?>" >
        </td>
</tr>
<tr>
<td>&nbsp;</td><td><input type="checkbox" name="OASIS_C_PHAD_Inpatient_Procedure_other[]" value="NA - Not applicable" <?php if(in_array("NA - Not applicable",$OASIS_C_PHAD_Inpatient_Procedure_other)) { echo "checked"; };?> /> NA - Not applicable
					<input type="checkbox" name="OASIS_C_PHAD_Inpatient_Procedure_other[]" value="UK - Unknown" <?php if(in_array("UK - Unknown",$OASIS_C_PHAD_Inpatient_Procedure_other)) { echo "checked"; };?> /> UK - Unknown</td>
</tr>
<tr>
        <td valign="top"><?php xl('<strong>(M1016)</strong>','e'); ?></td>
        <td colspan="2">
        <?php xl('<b>Diagnoses Requiring Medical or Treatment Regimen Change Within Past 14 Days:</b> List the patient\'s Medical Diagnoses and ICD-9-C M codes at the level of highest specificity for those conditions requiring changed medical or treatment regimen within the past 14 days (no surgical, E-codes, or V-codes):','e'); ?><br>
        </td><td>&nbsp;</td>
</tr><tr>
        <td>&nbsp;</td>
        <td>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <u><?php xl('Changed Medical Regimen Diagnosis','e'); ?></u>
        </td>
        <td>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <u><?php xl('ICD-9-C M Code','e'); ?></u>
        </td>
</tr><tr>
        <td>&nbsp;</td>
        <td>
        &nbsp;<?php xl('a.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_Changed_Medical_Regimen_Diagnosis[]" id="OASIS_C_Changed_Medical_Regimen_Diagnosis6" value="<?php echo $OASIS_C_Changed_Medical_Regimen_Diagnosis[0];?>" />        <br>
        &nbsp;<?php xl('b.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_Changed_Medical_Regimen_Diagnosis[]" id="OASIS_C_Changed_Medical_Regimen_Diagnosis5" value="<?php echo $OASIS_C_Changed_Medical_Regimen_Diagnosis[1];?>" />
        <br>
        &nbsp;<?php xl('c.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_Changed_Medical_Regimen_Diagnosis[]" id="OASIS_C_Changed_Medical_Regimen_Diagnosis4" value="<?php echo $OASIS_C_Changed_Medical_Regimen_Diagnosis[2];?>" />
        <br>
        &nbsp;<?php xl('d.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_Changed_Medical_Regimen_Diagnosis[]" id="OASIS_C_Changed_Medical_Regimen_Diagnosis2" value="<?php echo $OASIS_C_Changed_Medical_Regimen_Diagnosis[3];?>" />
        <br>
        &nbsp;<?php xl('e.','e'); ?>&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_Changed_Medical_Regimen_Diagnosis[]" id="OASIS_C_Changed_Medical_Regimen_Diagnosis3" value="<?php echo $OASIS_C_Changed_Medical_Regimen_Diagnosis[4];?>" />
        <br>
        &nbsp;<?php xl('f.','e'); ?>&nbsp;&nbsp;
        <input type="text" style="width:80%" name="OASIS_C_Changed_Medical_Regimen_Diagnosis[]" id="OASIS_C_Changed_Medical_Regimen_Diagnosis1" value="<?php echo $OASIS_C_Changed_Medical_Regimen_Diagnosis[5];?>" />
        </td>
	 <td>
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_Procedure_Code1" name="OASIS_C_PHAD_Procedure_Code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_Procedure_Code[0];?>" /><br />
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_Procedure_Code2" name="OASIS_C_PHAD_Procedure_Code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_Procedure_Code[1];?>" /><br />
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_Procedure_Code3" name="OASIS_C_PHAD_Procedure_Code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_Procedure_Code[2];?>" ><br>
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_Procedure_Code4" name="OASIS_C_PHAD_Procedure_Code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_Procedure_Code[3];?>" /><br>
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_Procedure_Code5" name="OASIS_C_PHAD_Procedure_Code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_Procedure_Code[4];?>" /><br>
		&nbsp;<input type="text" style="width:40%" class="autosearch" id="OASIS_C_PHAD_Procedure_Code6" name="OASIS_C_PHAD_Procedure_Code[]" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_PHAD_Procedure_Code[5];?>" />
        </td>
</tr>
<tr>
<td>&nbsp;</td><td colspan="2"><input type="checkbox" name="OASIS_C_Changed_Medical_Regimen_Diagnosis_other" value="NA - Not applicable" <?php if(in_array("NA - Not applicable",$OASIS_C_Changed_Medical_Regimen_Diagnosis_other)) { echo "checked"; };?> /> <?php xl('NA - Not applicable (no medical or treatment regimen changes within the past 14 days)','e');?>
</tr>
<tr>
        <td valign="top"><?php xl('<strong>(M1018)</strong>','e'); ?></td>
        <td colspan="2">
        <?php xl('<b>Conditions Prior to Medical or Treatment Regimen Change or Inpatient Stay Within Past 14 Days:</b> If this patient experienced an inpatient facility discharge or change in medical or treatment regimen within the past 14 days, indicate any conditions which existed ','e');?><u><?php xl('prior to','e');?></u><?php xl(' the inpatient stay or change in medical or treatment regimen. <b>(Mark all that apply.)</b>','e'); ?><br>
        
        <input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="Urinary incontinence" <?php if(in_array("Urinary incontinence",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('1 - Urinary incontinence','e'); ?><br>
		<input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="Indwelling/suprapubic catheter" <?php if(in_array("Indwelling/suprapubic catheter",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('2 - Indwelling/suprapubic catheter','e'); ?><br>
		<input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="Intractable pain" <?php if(in_array("Intractable pain",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('3 - Intractable pain','e'); ?><br>
		<input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="Impaired decision-making" <?php if(in_array("Impaired decision-making",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('4 - Impaired decision-making','e'); ?><br>
		<input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="Disruptive or socially inappropriate behavior" <?php if(in_array("Disruptive or socially inappropriate behavior",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('5 - Disruptive or socially inappropriate behavior','e'); ?><br>
		<input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="Memory loss to the extent that supervision required" <?php if(in_array("Memory loss to the extent that supervision required",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('6 - Memory loss to the extent that supervision required','e'); ?><br>
		<input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="None of the above" <?php if(in_array("None of the above",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('7 - None of the above','e'); ?><br>
		<input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="NA - No inpatient facility discharge" <?php if(in_array("NA - No inpatient facility discharge",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('NA - No inpatient facility discharge ','e');?><u><?php xl('and','e');?></u><?php xl(' no change in medical or treatment regimen in past 14 days','e'); ?><br>
		<input type="checkbox" name="OASIS_C_treatment_regimen_change[]" value="UK - Unknown" <?php if(in_array("UK - Unknown",$OASIS_C_treatment_regimen_change)) { echo "checked"; };?> /> <?php xl('UK - Unknown','e'); ?>
        </td>
</tr>


        <td colspan="3">
			<b><?php xl('(M1020/1022/1024)','e'); ?></b> <b><?php xl('Diagnoses, Symptom Control, and Payment Diagnoses:','e'); ?></b> <?php xl('List each diagnosis for which the patient is receiving home care (Column 1) and enter its ICD-9-C M code at the level of highest specificity (no surgical/procedure codes) (Column 2). Diagnoses are listed in the order that best reflect the seriousness of each condition and support the disciplines and services provided. Rate the degree of symptom control for each condition (Column 2). Choose one value that represents the degree of symptom control appropriate for each diagnosis: V-codes (for M1020 or M1022) or E-codes (for M1022 only) may be used. ICD-9-C M sequencing requirements must be followed if multiple coding is indicated for any diagnoses. If a V-code is reported in place of a case mix diagnosis, then optional item M1024 Payment Diagnoses (Columns 3 and 4) may be completed. A case mix diagnosis is a diagnosis that determines the Medicare P P S case mix group. Do not assign symptom control ratings for V- or E-codes. ','e'); ?><br />
			<div style="padding-left:15px;"><strong><?php xl('Code each row according to the following directions for each column:','e'); ?></strong><br />
			<?php xl('Column 1: Enter the description of the diagnosis.','e'); ?><br />
			<?php xl('Column 2: Enter the ICD-9-C M code for the diagnosis described in Column 1;','e'); ?><br />
			<div style="padding-left:15px;"><?php xl('Rate the degree of symptom control for the condition listed in Column 1 using the following scale:','e'); ?><br />
			<?php xl('0 - Asymptomatic, no treatment needed at this time','e'); ?><br />
			<?php xl('1 - Symptoms well controlled with current therapy','e'); ?><br />
			<?php xl('2 - Symptoms controlled with difficulty, affecting daily functioning; patient needs ongoing monitoring','e'); ?><br />
			<?php xl('3 - Symptoms poorly controlled; patient needs frequent adjustment in treatment and dose monitoring','e'); ?><br />
			<?php xl('4 - Symptoms poorly controlled; history of re-hospitalizations','e'); ?><br />
			<?php xl('Note that in Column 2 the rating for symptom control of each diagnosis should not be used to determine the sequencing of the diagnoses listed in Column 1. These are separate items and sequencing may not coincide. Sequencing of diagnoses should reflect the seriousness of each condition and support the disciplines and services provided.','e'); ?></div>
			<?php xl('Column 3: (OPTIONAL) If a V-code is assigned to any row in Column 2, in place of a case mix diagnosis, it may be necessary to complete optional item M1024 Payment Diagnoses (Columns 3 and 4). See OASIS-C Guidance Manual.','e'); ?><br />
			<?php xl('Column 4: (OPTIONAL) If a V-code in Column 2 is reported in place of a case mix diagnosis that requires multiple diagnosis codes under ICD-9-C M coding guidelines, enter the diagnosis descriptions and the ICD-9-C M codes in the same row in Columns 3 and 4. For example, if the case mix diagnosis is a manifestation code, record the diagnosis description and ICD-9-C M code for the underlying condition in Column 3 of that row and the diagnosis description and ICD-9-C M code for the manifestation in Column 4 of that row. Otherwise, leave Column 4 blank in that row.','e'); ?><br />
			</div>
		</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2">		<table border="1" cellpadding="5" cellspacing="0" width="100%" style="font-size:11px">
			<tbody>
				<tr>
					<td colspan="2" style="width: 398px; height: 7px;" align="center">
						
							<strong><?php xl('(M1020) Primary Diagnosis &amp; (M1022) Other Diagnoses','e'); ?> </strong>
					</td>
					<td colspan="2" style="width: 325px; height: 7px;" align="center">
						
							<strong><?php xl('(M1024) Payment Diagnoses (OPTIONAL)','e'); ?> </strong>
					</td>
				</tr>
				<tr>
					<td width="25%" align="center">
						
					  <?php xl('Column 1','e'); ?>
					</td>
					<td width="25%" align="center">
						
					  <?php xl('Column 2','e'); ?>
					</td>
					<td width="25%" align="center">
						
					  <?php xl('Column 3','e'); ?>
					</td>
					<td width="25%" align="center">
						
					  <?php xl('Column 4','e'); ?>
					</td>
				</tr>
				<tr>
					<td >
						
							<?php xl('Diagnoses (Sequencing of diagnoses should reflect the seriousness of each condition and support the disciplines and services provided.)','e'); ?>
					</td>
					<td>
						
							<?php xl('ICD-9-C M and symptom control rating for each condition.','e'); ?>
						
							<?php xl('Note that the sequencing of these ratings may not match the sequencing of the diagnoses','e'); ?>
					</td>
					<td>
						
							<?php xl('Complete if a V-code is assigned under certain circumstances to Column 2 in place of a case mix diagnosis.','e'); ?>
					</td>
					<td>
						
							<?php xl('Complete <strong><u>only if </u></strong>the V-code in Column 2 is reported in place of a case mix diagnosis that is a multiple coding situation (e.g., a manifestation code).','e'); ?>
					</td>
				</tr>
				<tr>
					<td>
						
							<?php xl('Description','e'); ?>
					</td>
					<td>
						
							<?php xl('ICD-9-C M / Symptom Control Rating','e'); ?>
					</td>
					<td>
						
							<?php xl('Description/ ICD-9-C M','e'); ?>
					</td>
					<td>
						
							<?php xl('Description/ ICD-9-C M','e'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						
							<strong><u><?php xl('(M1020) Primary Diagnosis','e'); ?> </u></strong><br />
						
							<?php xl('a.','e'); ?> <input type="text" name="OASIS_C_priamary_diagnosis" id="OASIS_priamary_diagnosis" value="<?php echo $OASIS_C_priamary_diagnosis[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
							<strong><?php xl('(V-codes are allowed)','e'); ?> </strong><br />
						
							<?php xl('a.','e');?> <input type="text" style="width:40%" class="autosearch" id="OASIS_primary_diagnosis_v_code" name="OASIS_C_primary_diagnosis_v_code" value="<?php echo $OASIS_C_primary_diagnosis_v_code[0]; ?>" onkeydown="fonChange(this,2,'noe')" /><br /><br />
						
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_options" value="0" <?php if(in_array("0",$OASIS_C_primary_diagnosis_v_code_options)) { echo "checked"; };?> /> <?php xl('0','e'); ?>
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_options" value="1" <?php if(in_array("1",$OASIS_C_primary_diagnosis_v_code_options)) { echo "checked"; };?> /> <?php xl('1','e'); ?>
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_options" value="2" <?php if(in_array("2",$OASIS_C_primary_diagnosis_v_code_options)) { echo "checked"; };?> /> <?php xl('2','e'); ?>
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_options" value="3" <?php if(in_array("3",$OASIS_C_primary_diagnosis_v_code_options)) { echo "checked"; };?> /> <?php xl('3','e'); ?>
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_options" value="4" <?php if(in_array("4",$OASIS_C_primary_diagnosis_v_code_options)) { echo "checked"; };?> /> <?php xl('4','e'); ?>
						
					</td>
					<td align="center" valign="top">
						
							<strong><?php xl('(V- or E-codes NOT allowed)','e'); ?> </strong><br /><?php xl('a.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_a" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_1_a" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_a[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_1_a" name="OASIS_C_payment_diagnosis_v_code_or_e_code_1_a" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_1_a[0]; ?>" />
					</td>
					<td align="center" valign="top" style="width: 156px; height: 30px;">
						
							<strong><?php xl('(V- or E-codes NOT allowed)','e'); ?> </strong><br /><?php xl('a.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_a" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_2_a" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_a[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_2_a" name="OASIS_C_payment_diagnosis_v_code_or_e_code_2_a" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_2_a[0]; ?>" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						
							<strong><?php xl('(M1022) Other Diagnoses','e'); ?> </strong><br />
						
							<?php xl('b.','e'); ?> <input type="text" name="OASIS_C_other_diagnosis_b" id="OASIS_C_other_diagnosis_b" value="<?php echo $OASIS_C_other_diagnosis_b[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
							<strong><?php xl('(V- or E-codes are allowed)','e'); ?> </strong><br />
						
							<?php xl('b.','e'); ?> <input type="text" style="width:40%" class="autosearch" id="OASIS_primary_diagnosis_v_code_e_code_b" name="OASIS_C_primary_diagnosis_v_code_e_code_b" onkeydown="fonChange(this,2,'all')" value="<?php echo $OASIS_C_primary_diagnosis_v_code_e_code_b[0]; ?>" //><br /><br />
						
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_b" value="0" <?php if(in_array("0",$OASIS_C_primary_diagnosis_v_code_e_code_options_b)) { echo "checked"; };?> /> <?php xl('0','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_b" value="1" <?php if(in_array("1",$OASIS_C_primary_diagnosis_v_code_e_code_options_b)) { echo "checked"; };?> /> <?php xl('1','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_b" value="2" <?php if(in_array("2",$OASIS_C_primary_diagnosis_v_code_e_code_options_b)) { echo "checked"; };?> /> <?php xl('2','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_b" value="3" <?php if(in_array("3",$OASIS_C_primary_diagnosis_v_code_e_code_options_b)) { echo "checked"; };?> /> <?php xl('3','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_b" value="4" <?php if(in_array("4",$OASIS_C_primary_diagnosis_v_code_e_code_options_b)) { echo "checked"; };?> /> <?php xl('4','e'); ?>
						
					</td>
					<td align="center" valign="top">
						
							<strong><?php xl('(V- or E-codes NOT allowed)','e'); ?> </strong><br /><?php xl('b.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_b" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_1_b" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_b[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_1_b" name="OASIS_C_payment_diagnosis_v_code_or_e_code_1_b" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_1_b[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
							<strong><?php xl('(V- or E-codes NOT allowed)','e'); ?> </strong><br /><?php xl('b.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_b" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_2_b" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_b[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_2_b" name="OASIS_C_payment_diagnosis_v_code_or_e_code_2_b" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_2_b[0]; ?>" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						
					  <?php xl('c.','e'); ?> <input type="text" name="OASIS_C_other_diagnosis_c" id="OASIS_C_other_diagnosis_c" value="<?php echo $OASIS_C_other_diagnosis_c[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
					  <?php xl('c.','e'); ?> <input type="text" style="width:40%" class="autosearch" id="OASIS_primary_diagnosis_v_code_e_code_c" name="OASIS_C_primary_diagnosis_v_code_e_code_c" onkeydown="fonChange(this,2,'all')" value="<?php echo $OASIS_C_primary_diagnosis_v_code_e_code_c[0]; ?>" /> <br /><br />
						
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_c" value="0" <?php if(in_array("0",$OASIS_C_primary_diagnosis_v_code_e_code_options_c)) { echo "checked"; };?> /> <?php xl('0','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_c" value="1" <?php if(in_array("1",$OASIS_C_primary_diagnosis_v_code_e_code_options_c)) { echo "checked"; };?> /> <?php xl('1','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_c" value="2" <?php if(in_array("2",$OASIS_C_primary_diagnosis_v_code_e_code_options_c)) { echo "checked"; };?> /> <?php xl('2','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_c" value="3" <?php if(in_array("3",$OASIS_C_primary_diagnosis_v_code_e_code_options_c)) { echo "checked"; };?> /> <?php xl('3','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_c" value="4" <?php if(in_array("4",$OASIS_C_primary_diagnosis_v_code_e_code_options_c)) { echo "checked"; };?> /> <?php xl('4','e'); ?>
					  
					</td>
					<td align="center" valign="top">
						
					  <?php xl('c.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_c" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_1_c" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_c[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_1_c" name="OASIS_C_payment_diagnosis_v_code_or_e_code_1_c" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_1_c[0]; ?>" />
				  </td>
					<td align="center" valign="top">
						
					  <?php xl('c.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_c" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_2_c" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_c[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_2_c" name="OASIS_C_payment_diagnosis_v_code_or_e_code_2_c" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_2_c[0]; ?>" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						
					  <?php xl('d.','e'); ?> <input type="text" name="OASIS_C_other_diagnosis_d" id="OASIS_C_other_diagnosis_d" value="<?php echo $OASIS_C_other_diagnosis_d[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
					  <?php xl('d.','e'); ?> <input type="text" style="width:40%" class="autosearch" id="OASIS_primary_diagnosis_v_code_e_code_d" name="OASIS_C_primary_diagnosis_v_code_e_code_d" value="<?php echo $OASIS_C_primary_diagnosis_v_code_e_code_d[0]; ?>" onkeydown="fonChange(this,2,'all')" /><br /><br />
						
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_d" value="0" <?php if(in_array("0",$OASIS_C_primary_diagnosis_v_code_e_code_options_d)) { echo "checked"; };?> /> <?php xl('0','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_d" value="1" <?php if(in_array("1",$OASIS_C_primary_diagnosis_v_code_e_code_options_d)) { echo "checked"; };?> /> <?php xl('1','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_d" value="2" <?php if(in_array("2",$OASIS_C_primary_diagnosis_v_code_e_code_options_d)) { echo "checked"; };?> /> <?php xl('2','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_d" value="3" <?php if(in_array("3",$OASIS_C_primary_diagnosis_v_code_e_code_options_d)) { echo "checked"; };?> /> <?php xl('3','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_d" value="4" <?php if(in_array("4",$OASIS_C_primary_diagnosis_v_code_e_code_options_d)) { echo "checked"; };?> /> <?php xl('4','e'); ?>
					  
					</td>
					<td align="center" valign="top">
						
					  <?php xl('d.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_e" type="text" id="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_e" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_e[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_1_e" name="OASIS__payment_diagnosis_v_code_or_e_code_1_e"  onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS__payment_diagnosis_v_code_or_e_code_1_e[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
					  <?php xl('d.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_d" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_2_d" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_d[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_2_d" name="OASIS_C_payment_diagnosis_v_code_or_e_code_2_d" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_2_d[0]; ?>" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						
					  <?php xl('e.','e'); ?> <input type="text" name="OASIS_C_other_diagnosis_e" id="OASIS_C_other_diagnosis_e" value="<?php echo $OASIS_C_other_diagnosis_e[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
					  <?php xl('e.','e'); ?> <input type="text" style="width:40%" class="autosearch" id="OASIS_primary_diagnosis_v_code_e_code_e" name="OASIS_C_primary_diagnosis_v_code_e_code_e" onkeydown="fonChange(this,2,'all')" value="<?php echo $OASIS_C_primary_diagnosis_v_code_e_code_e[0]; ?>" /> <br /><br />
						
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_e" value="0" <?php if(in_array("0",$OASIS_C_primary_diagnosis_v_code_e_code_options_e)) { echo "checked"; };?> /> <?php xl('0','e'); ?>
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_e" value="1" <?php if(in_array("1",$OASIS_C_primary_diagnosis_v_code_e_code_options_e)) { echo "checked"; };?> /> <?php xl('1','e'); ?>
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_e" value="2" <?php if(in_array("2",$OASIS_C_primary_diagnosis_v_code_e_code_options_e)) { echo "checked"; };?> /> <?php xl('2','e'); ?>
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_e" value="3" <?php if(in_array("3",$OASIS_C_primary_diagnosis_v_code_e_code_options_e)) { echo "checked"; };?> /> <?php xl('3','e'); ?>
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_e" value="4" <?php if(in_array("4",$OASIS_C_primary_diagnosis_v_code_e_code_options_e)) { echo "checked"; };?> /> <?php xl('4','e'); ?>					  
					</td>
					<td align="center" valign="top">
						
					  <?php xl('e.','e'); ?> <input name="OASIS_payment_diagnosis_V_or_E_code_not_allowed_1_e" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_1_e" size="15" value="<?php echo $OASIS_payment_diagnosis_V_or_E_code_not_allowed_1_e[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS_C_payment_diagnosis_v_code_or_e_code_1_e" name="OASIS_C_payment_diagnosis_v_code_or_e_code_1_e" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_1_e[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
					  <?php xl('e.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_e" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_2_e" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_e[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_2_e" name="OASIS_C_payment_diagnosis_v_code_or_e_code_2_e" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_2_e[0]; ?>" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						
					  <?php xl('f.','e'); ?> <input type="text" name="OASIS_C_other_diagnosis_f" id="OASIS_C_other_diagnosis_f" value="<?php echo $OASIS_C_other_diagnosis_f[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
					  <?php xl('f.','e'); ?> <input type="text" style="width:40%" class="autosearch" id="OASIS_primary_diagnosis_v_code_e_code_f" name="OASIS_C_primary_diagnosis_v_code_e_code_f" onkeydown="fonChange(this,2,'all')" value="<?php echo $OASIS_C_primary_diagnosis_v_code_e_code_f[0]; ?>" /> <br /><br />
						
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_f" value="0" <?php if(in_array("0",$OASIS_C_primary_diagnosis_v_code_e_code_options_f)) { echo "checked"; };?> /> <?php xl('0','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_f" value="1" <?php if(in_array("1",$OASIS_C_primary_diagnosis_v_code_e_code_options_f)) { echo "checked"; };?> /> <?php xl('1','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_f" value="2" <?php if(in_array("2",$OASIS_C_primary_diagnosis_v_code_e_code_options_f)) { echo "checked"; };?> /> <?php xl('2','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_f" value="3" <?php if(in_array("3",$OASIS_C_primary_diagnosis_v_code_e_code_options_f)) { echo "checked"; };?> /> <?php xl('3','e'); ?> 
							<input type="checkbox" name="OASIS_C_primary_diagnosis_v_code_e_code_options_f" value="4" <?php if(in_array("4",$OASIS_C_primary_diagnosis_v_code_e_code_options_f)) { echo "checked"; };?> /> <?php xl('4','e'); ?>
					  
					</td>
					<td align="center" valign="top">
						
					  <?php xl('f.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_f" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_1_f" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_1_f[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_1_f" name="OASIS_C_payment_diagnosis_v_code_or_e_code_1_f" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_1_f[0]; ?>" />
					</td>
					<td align="center" valign="top">
						
					  <?php xl('f.','e'); ?> <input name="OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_f" type="text" id="OASIS_payment_diagnosis_V_or_E_code_not_allowed_2_f" size="15" value="<?php echo $OASIS_C_payment_diagnosis_V_or_E_code_not_allowed_2_f[0]; ?>" />
						
							<input type="text" style="width:40%" class="autosearch" id="OASIS__payment_diagnosis_v_code_or_e_code_2_f" name="OASIS_C_payment_diagnosis_v_code_or_e_code_2_f" onkeydown="fonChange(this,2,'noev')" value="<?php echo $OASIS_C_payment_diagnosis_v_code_or_e_code_2_f[0]; ?>" />
				  </td>
				</tr>
			</tbody>
		</table>
</td>
</tr>
<tr>
	<td><?php xl('<strong>(M1030)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('<strong>Therapies</strong> the patient receives at home: <strong>(Mark all that apply.)</strong>','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="2">
        <input type="checkbox" name="OASIS_C_therapies_patient_received[]" value="Intravenous or infusion therapy (excludes TPN)" <?php if(in_array("Intravenous or infusion therapy (excludes TPN)",$OASIS_C_therapies_patient_received)) { echo "checked"; };?> />
        <?php xl('1 - Intravenous or infusion therapy (excludes TPN)','e'); ?><br>
        <input type="checkbox" name="OASIS_C_therapies_patient_received[]" value="Parenteral nutrition (TPN or lipids)" <?php if(in_array("Parenteral nutrition (TPN or lipids)",$OASIS_C_therapies_patient_received)) { echo "checked"; };?> />
        <?php xl('2 - Parenteral nutrition (TPN or lipids)','e'); ?><br>
	
        <input type="checkbox" name="OASIS_C_therapies_patient_received[]" value="Enteral nutrition (nasogastric, gastrostomy, jejunostomy, or any other artificial entry into the alimentary canal)" <?php if(in_array("Enteral nutrition (nasogastric, gastrostomy, jejunostomy, or any other artificial entry into the alimentary canal)",$OASIS_C_therapies_patient_received)) { echo "checked"; };?> />
        <?php xl('3 - Enteral nutrition (nasogastric, gastrostomy, jejunostomy, or any other artificial entry into the alimentary canal)','e'); ?><br>
        <input type="checkbox" name="OASIS_C_therapies_patient_received[]" value="None of the above" <?php if(in_array("None of the above",$OASIS_C_therapies_patient_received)) { echo "checked"; };?> />
        <?php xl('4 - None of the above','e'); ?><br>
        </td>
</tr>
<tr>
	<td valign="top"><?php xl('<strong>(M1032)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('<strong>Risk for Hospitalization:</strong> Which of the following signs or symptoms characterize this patient as at risk for hospitalization? <strong>(Mark all that apply.)</strong>','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="2">
        <input type="checkbox" name="OASIS_C_risk_for_hospitalization[]" value="Recent decline in mental, emotional, or behavioral status" <?php if(in_array("Recent decline in mental, emotional, or behavioral status",$OASIS_C_risk_for_hospitalization)) { echo "checked"; };?> />
        <?php xl('1 - Recent decline in mental, emotional, or behavioral status','e'); ?><br>
        <input type="checkbox" name="OASIS_C_risk_for_hospitalization[]" value="Multiple hospitalizations (2 or more) in the past 12 months" <?php if(in_array("Multiple hospitalizations (2 or more) in the past 12 months",$OASIS_C_risk_for_hospitalization)) { echo "checked"; };?> />
        <?php xl('2 - Multiple hospitalizations (2 or more) in the past 12 months','e'); ?><br>
       <input type="checkbox" name="OASIS_C_risk_for_hospitalization[]" value="History of falls (2 or more falls - or any fall with an injury - in the past year)" <?php if(in_array("History of falls (2 or more falls - or any fall with an injury - in the past year)",$OASIS_C_risk_for_hospitalization)) { echo "checked"; };?> />
        <?php xl('3 - History of falls (2 or more falls - or any fall with an injury - in the past year)','e'); ?><br>
        <input type="checkbox" name="OASIS_C_risk_for_hospitalization[]" value="Taking five or more medications" <?php if(in_array("Taking five or more medications",$OASIS_C_risk_for_hospitalization)) { echo "checked"; };?> />
        <?php xl('4 - Taking five or more medications','e'); ?><br>
       <input type="checkbox" name="OASIS_C_risk_for_hospitalization[]" value="Frailty indicators, e.g., weight loss, self-reported exhaustion" <?php if(in_array("Frailty indicators, e.g., weight loss, self-reported exhaustion",$OASIS_C_risk_for_hospitalization)) { echo "checked"; };?> />
        <?php xl('5 - Frailty indicators, e.g., weight loss, self-reported exhaustion','e'); ?><br>
       <input type="checkbox" name="OASIS_C_risk_for_hospitalization[]" value="Other" <?php if(in_array("Other",$OASIS_C_risk_for_hospitalization)) { echo "checked"; };?> />
        <?php xl('6 - Other','e'); ?><br>
        <input type="checkbox" name="OASIS_C_risk_for_hospitalization[]" value="None of the above" <?php if(in_array("None of the above",$OASIS_C_risk_for_hospitalization)) { echo "checked"; };?> />
        <?php xl('7 - None of the above','e'); ?>
	
        </td>
</tr>
<tr>
	<td><?php xl('<strong>(M1034)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('<strong>Overall Status:</strong> Which description best fits the patient"s overall status? <strong>(Check one)</strong>','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="2">
        <input type="checkbox" name="OASIS_C_best_fits_patient_overall_status" value="The patient is stable with no heightened risk(s) for serious complications and death (beyond those typical of the patients age)." <?php if(in_array("The patient is stable with no heightened risk(s) for serious complications and death (beyond those typical of the patients age).",$OASIS_C_best_fits_patient_overall_status)) { echo "checked"; };?> />
        <?php xl('0 - The patient is stable with no heightened risk(s) for serious complications and death (beyond those typical of the patient"s age).','e'); ?><br>
        <input type="checkbox" name="OASIS_C_best_fits_patient_overall_status" value="The patient is temporarily facing high health risk(s) but is likely to return to being stable without heightened risk(s) for serious complications and death (beyond those typical of the patients age)" <?php if(in_array("The patient is temporarily facing high health risk(s) but is likely to return to being stable without heightened risk(s) for serious complications and death (beyond those typical of the patients age)",$OASIS_C_best_fits_patient_overall_status)) { echo "checked"; };?> />
        <?php xl('1 - The patient is temporarily facing high health risk(s) but is likely to return to being stable without heightened risk(s) for serious complications and death (beyond those typical of the patient"s age).','e'); ?><br>
	
        <input type="checkbox" name="OASIS_C_best_fits_patient_overall_status" value="The patient is likely to remain in fragile health and have ongoing high risk(s) of serious complications and death." <?php if(in_array("The patient is likely to remain in fragile health and have ongoing high risk(s) of serious complications and death.",$OASIS_C_best_fits_patient_overall_status)) { echo "checked"; };?> />
        <?php xl('2 - The patient is likely to remain in fragile health and have ongoing high risk(s) of serious complications and death.','e'); ?><br>
        <input type="checkbox" name="OASIS_C_best_fits_patient_overall_status" value="The patient has serious progressive conditions that could lead to death within a year." <?php if(in_array("The patient has serious progressive conditions that could lead to death within a year.",$OASIS_C_best_fits_patient_overall_status)) { echo "checked"; };?> />
        <?php xl('3 - The patient has serious progressive conditions that could lead to death within a year.','e'); ?><br>
       <input type="checkbox" name="OASIS_C_best_fits_patient_overall_status" value="UK" <?php if(in_array("UK",$OASIS_C_best_fits_patient_overall_status)) { echo "checked"; };?> />
        <?php xl('UK - The patients situation is unknown or unclear.','e'); ?>
        </td>
</tr>
<tr>
	<td><?php xl('<strong>(M1036)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('<strong>Risk Factors</strong>, either present or past, likely to affect current health status and/or outcome: <strong>(Mark all that apply.)</strong>','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
        <input type="checkbox" name="OASIS_C_risk_factors_effects_health_status[]" value="Smoking" <?php if(in_array("Smoking",$OASIS_C_risk_factors_effects_health_status)) { echo "checked"; };?> />
        <?php xl('1 - Smoking','e'); ?><br>
        <input type="checkbox" name="OASIS_C_risk_factors_effects_health_status[]" value="Obesity" <?php if(in_array("Obesity",$OASIS_C_risk_factors_effects_health_status)) { echo "checked"; };?> />
        <?php xl('2 - Obesity','e'); ?><br>
       <input type="checkbox" name="OASIS_C_risk_factors_effects_health_status[]" value="Alcohol dependency" <?php if(in_array("Alcohol dependency",$OASIS_C_risk_factors_effects_health_status)) { echo "checked"; };?> />
        <?php xl('3 - Alcohol dependency','e'); ?>

	</td>
	<td>
        <input type="checkbox" name="OASIS_C_risk_factors_effects_health_status[]" value="Drug dependency" <?php if(in_array("Drug dependency",$OASIS_C_risk_factors_effects_health_status)) { echo "checked"; };?> />
        <?php xl('4 - Drug dependency','e'); ?><br>
        <input type="checkbox" name="OASIS_C_risk_factors_effects_health_status[]" value="None of the above" <?php if(in_array("None of the above",$OASIS_C_risk_factors_effects_health_status)) { echo "checked"; };?> />
        <?php xl('5 - None of the above','e'); ?><br>
       <input type="checkbox" name="OASIS_C_risk_factors_effects_health_status[]" value="Unknown" <?php if(in_array("Unknown",$OASIS_C_risk_factors_effects_health_status)) { echo "checked"; };?> />
        <?php xl('UK - Unknown','e'); ?>
        </td>
</tr>
<tr>
	<td valign="top"><?php xl('<strong>(M1040)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('<strong>Influenza Vaccine:</strong> Did the patient receive the influenza vaccine from your agency for this year"s influenza season (October 1 through March 31) during this episode of care?','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="2">
        <input type="checkbox" name="OASIS_C_recieved_influenza_vaccine_from_agency" value="No" <?php if(in_array("No",$OASIS_C_recieved_influenza_vaccine_from_agency)) { echo "checked"; };?> />
        <?php xl('0 - No','e'); ?><br>
        <input type="checkbox" name="OASIS_C_recieved_influenza_vaccine_from_agency" value="Yes" <?php if(in_array("Yes",$OASIS_C_recieved_influenza_vaccine_from_agency)) { echo "checked"; };?> />
        <?php xl('1 - Yes <strong>[ Go to M1050 ]</strong>','e'); ?><br>
	
        <input type="checkbox" name="OASIS_C_recieved_influenza_vaccine_from_agency" value="NA - Does not apply because entire episode of care (SOC/ROC to Transfer/Discharge) is outside this influenza season." <?php if(in_array("NA - Does not apply because entire episode of care (SOC/ROC to Transfer/Discharge) is outside this influenza season.",$OASIS_C_recieved_influenza_vaccine_from_agency)) { echo "checked"; };?> />
        <?php xl('NA - Does not apply because entire episode of care (SOC/ROC to Transfer/Discharge) is outside this influenza season. <strong>[ Go to M1050 ]</strong>','e'); ?><br>
        </td>
</tr>
<tr>
	<td valign="top"><?php xl('<strong>(M1045)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('<strong>Reason Influenza Vaccine not received:</strong> If the patient did not receive the influenza vaccine from your agency during this episode of care, state reason:','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="2">
        <input type="checkbox" name="OASIS_C_reason_influenza_caccine_not_received[]" value="Received from another health care provider (e.g., physician)" <?php if(in_array("Received from another health care provider (e.g., physician)",$OASIS_C_reason_influenza_caccine_not_received)) { echo "checked"; };?> />
        <?php xl('1 - Received from another health care provider (e.g., physician)','e'); ?><br>
        <input type="checkbox" name="OASIS_C_reason_influenza_caccine_not_received[]" value="Received from your agency previously during this years flu season" <?php if(in_array("Received from your agency previously during this years flu season",$OASIS_C_reason_influenza_caccine_not_received)) { echo "checked"; };?> />
        <?php xl('2 - Received from your agency previously during this years flu season','e'); ?><br>
       <input type="checkbox" name="OASIS_C_reason_influenza_caccine_not_received[]" value="Offered and declined" <?php if(in_array("Offered and declined",$OASIS_C_reason_influenza_caccine_not_received)) { echo "checked"; };?> />
        <?php xl('3 - Offered and declined','e'); ?><br>
       <input type="checkbox" name="OASIS_C_reason_influenza_caccine_not_received[]" value="Assessed and determined to have medical contraindication(s)" <?php if(in_array("Assessed and determined to have medical contraindication(s)",$OASIS_C_reason_influenza_caccine_not_received)) { echo "checked"; };?> />
        <?php xl('4 - Assessed and determined to have medical contraindication(s)','e'); ?><br>
	
        <input type="checkbox" name="OASIS_C_reason_influenza_caccine_not_received[]" value="Not indicated; patient does not meet age/condition guidelines for influenza vaccine" <?php if(in_array("Not indicated; patient does not meet age/condition guidelines for influenza vaccine",$OASIS_C_reason_influenza_caccine_not_received)) { echo "checked"; };?> />
        <?php xl('5 - Not indicated; patient does not meet age/condition guidelines for influenza vaccine','e'); ?><br>
       <input type="checkbox" name="OASIS_C_reason_influenza_caccine_not_received[]" value="Inability to obtain vaccine due to declared shortage" <?php if(in_array("Inability to obtain vaccine due to declared shortage",$OASIS_C_reason_influenza_caccine_not_received)) { echo "checked"; };?> />
        <?php xl('6 - Inability to obtain vaccine due to declared shortage','e'); ?><br>
       <input type="checkbox" name="OASIS_C_reason_influenza_caccine_not_received[]" value="None of the above" <?php if(in_array("None of the above",$OASIS_C_reason_influenza_caccine_not_received)) { echo "checked"; };?> />
        <?php xl('7 - None of the above','e'); ?>
        </td>
</tr>
<tr>
	<td valign="top"><?php xl('<strong>(M1050)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('<strong>Pneumococcal Vaccine:</strong> Did the patient receive pneumococcal polysaccharide vaccine (PPV) from your agency during this episode of care (SOC/ROC to Transfer/Discharge)?','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
        <input type="checkbox" name="OASIS_C_received_pneumococcal_vaccine_from_agency" value="No" <?php if(in_array("No",$OASIS_C_received_pneumococcal_vaccine_from_agency)) { echo "checked"; };?> />
        <?php xl('0 - No','e'); ?><br>


	</td>
	<td>
        <input type="checkbox" name="OASIS_C_received_pneumococcal_vaccine_from_agency" value="Yes" <?php if(in_array("Yes",$OASIS_C_received_pneumococcal_vaccine_from_agency)) { echo "checked"; };?> />
        <?php xl('1 - Yes <strong>[ Go to M1246 at TRN; Go to M1100 at DC ]</strong>','e'); ?><br>
        </td>
</tr>
<tr>
	<td valign="top"><?php xl('<strong>(M1055)</strong>','e'); ?></td>
	<td colspan="2">
	<?php xl('<strong>Reason PPV not received:</strong> If patient did not receive the pneumococcal polysaccharide vaccine (PPV) from your agency during this episode of care (SOC/ROC to Transfer/Discharge), state reason:','e'); ?><br>
	</td><td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
        <input type="checkbox" name="OASIS_C_reason_not_received_pneumocaccal_vaccine[]" value="Patient has received PPV in the past" <?php if(in_array("Patient has received PPV in the past",$OASIS_C_reason_not_received_pneumocaccal_vaccine)) { echo "checked"; };?> />
        <?php xl('1 - Patient has received PPV in the past','e'); ?><br>
        <input type="checkbox" name="OASIS_C_reason_not_received_pneumocaccal_vaccine[]" value="Offered and declined" <?php if(in_array("Offered and declined",$OASIS_C_reason_not_received_pneumocaccal_vaccine)) { echo "checked"; };?> />
        <?php xl('2 - Offered and declined','e'); ?><br>
        <input type="checkbox" name="OASIS_C_reason_not_received_pneumocaccal_vaccine[]" value="Assessed and determined to have medical contraindication(s)" <?php if(in_array("Assessed and determined to have medical contraindication(s)",$OASIS_C_reason_not_received_pneumocaccal_vaccine)) { echo "checked"; };?> />
        <?php xl('3 - Assessed and determined to have medical contraindication(s)','e'); ?><br>
	</td>
	<td>
        <input type="checkbox" name="OASIS_C_reason_not_received_pneumocaccal_vaccine[]" value="Not indicated; patient does not meet age/condition guidelines for PPV"  <?php if(in_array("Not indicated; patient does not meet age/condition guidelines for PPV",$OASIS_C_reason_not_received_pneumocaccal_vaccine)) { echo "checked"; };?> />
        <?php xl('4 - Not indicated; patient does not meet age/condition guidelines for PPV','e'); ?><br>
        <input type="checkbox" name="OASIS_C_reason_not_received_pneumocaccal_vaccine[]" value="None of the above" <?php if(in_array("None of the above",$OASIS_C_reason_not_received_pneumocaccal_vaccine)) { echo "checked"; };?> />
        <?php xl('5 - None of the above','e'); ?><br>
        </td>
</tr>


</table>
                        </li>
                    </ul>
                </li>
                <li>
				 <div><a href="#" id="black">Living Arrangements</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable" width="100%">
	<tr>
		<td valign="top">
			<strong>(M1100)</strong>
		</td>
		<td valign="middle">
			<strong><?php xl("Patient Living Situation:","e");?></strong> <?php xl("Which of the following best describes the patient's residential circumstance and availability of assistance?","e");?> <strong><?php xl("(Check one box only.)","e");?></strong>
		</td>
	</tr>
</table><table class="formtable" border="1px">
	<tr>
		<td valign="middle" rowspan="2">
			<strong><?php xl("Living Arrangement","e");?></strong>
		</td>
		<td valign="middle" align="center" colspan="5">
			<strong><?php xl("Availability of Assistance","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="center">
			<?php xl("Around the clock","e");?>
		</td>
		<td valign="middle" align="center">
			<?php xl("Regular daytime","e");?>
		</td>
		<td valign="middle" align="center">
			<?php xl("Regular nighttime","e");?>
		</td>
		<td valign="middle" align="center">
			<?php xl("Occasional / short-term assistance","e");?>
		</td>
		<td valign="middle" align="center">
			<?php xl("No assistance available","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			a.&nbsp;&nbsp;<?php xl("Patient lives alone","e");?>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="01" <?php if($obj{"living_arrangements_situation"}=="01") echo "checked"; ?> >01</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="02" <?php if($obj{"living_arrangements_situation"}=="02") echo "checked"; ?> >02</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="03" <?php if($obj{"living_arrangements_situation"}=="03") echo "checked"; ?> >03</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="04" <?php if($obj{"living_arrangements_situation"}=="04") echo "checked"; ?> >04</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="05" <?php if($obj{"living_arrangements_situation"}=="05") echo "checked"; ?> >05</label>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			b.&nbsp;&nbsp;<?php xl("Patient lives with other person(s) in the home","e");?>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="06" <?php if($obj{"living_arrangements_situation"}=="06") echo "checked"; ?> >06</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="07" <?php if($obj{"living_arrangements_situation"}=="07") echo "checked"; ?> >07</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="08" <?php if($obj{"living_arrangements_situation"}=="08") echo "checked"; ?> >08</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="09" <?php if($obj{"living_arrangements_situation"}=="09") echo "checked"; ?> >09</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="10" <?php if($obj{"living_arrangements_situation"}=="10") echo "checked"; ?> >10</label>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			c.&nbsp;&nbsp;<?php xl("Patient lives in congregate situation (e.g., assisted living)","e");?>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="11" <?php if($obj{"living_arrangements_situation"}=="11") echo "checked"; ?> >11</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="12" <?php if($obj{"living_arrangements_situation"}=="12") echo "checked"; ?> >12</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="13" <?php if($obj{"living_arrangements_situation"}=="13") echo "checked"; ?> >13</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="14" <?php if($obj{"living_arrangements_situation"}=="14") echo "checked"; ?> >14</label>
		</td>
		<td valign="middle" align="center">
			<label><input type="checkbox" name="living_arrangements_situation" value="15" <?php if($obj{"living_arrangements_situation"}=="15") echo "checked"; ?> >15</label>
		</td>
	</tr>
</table>
                        </li>
                    </ul>
                </li>
                <li>
				 <div><a href="#" id="black">Sensory Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable">
	<tr>
		<td valign="middle">
			<strong>(M1200)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Vision:","e");?></strong> <?php xl("(with corrective lenses if the patient usually wears them):","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_vision" value="0" <?php if($obj{"sensory_status_vision"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Normal vision: sees adequately in most situations; can see medication labels, newsprint.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_vision" value="1" <?php if($obj{"sensory_status_vision"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Partially impaired: cannot see medication labels or newsprint, but can see obstacles in path, and the surrounding layout; can count fingers at arm's length.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_vision" value="2" <?php if($obj{"sensory_status_vision"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Severely impaired: cannot locate objects without hearing or touching them or patient nonresponsive.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1210)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Ability to hear:","e");?></strong> <?php xl("(with hearing aid or hearing appliance if normally used):","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_hearing" value="0" <?php if($obj{"sensory_status_hearing"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Adequate: hears normal conversation without difficulty.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_hearing" value="1" <?php if($obj{"sensory_status_hearing"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Mildly to Moderately Impaired: difficulty hearing in some environments or speaker may need to increase volume or speak distinctly.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_hearing" value="2" <?php if($obj{"sensory_status_hearing"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Severely Impaired: absence of useful hearing.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_hearing" value="UK" <?php if($obj{"sensory_status_hearing"}=="UK") echo "checked"; ?> >
		</td>
		<td valign="middle">
			UK&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to assess hearing.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1220)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Understanding of Verbal Content","e");?></strong> <?php xl("in patient's own language (with hearing aid or device if used):","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_verbal_content" value="0" <?php if($obj{"sensory_status_verbal_content"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Understands: clear comprehension without cues or repetitions.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_verbal_content" value="1" <?php if($obj{"sensory_status_verbal_content"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Usually Understands: understands most conversations, but misses some part/intent of message. Requires cues at times to understand.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_verbal_content" value="2" <?php if($obj{"sensory_status_verbal_content"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Sometimes Understands: understands only basic conversations or simple, direct phrases. Frequently requires cues to understand.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_verbal_content" value="3" <?php if($obj{"sensory_status_verbal_content"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Rarely/Never Understands","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_verbal_content" value="UK" <?php if($obj{"sensory_status_verbal_content"}=="UK") echo "checked"; ?> >
		</td>
		<td valign="middle">
			UK&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to assess understanding.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1230)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Speech and Oral (Verbal) Expression of Language (in patient's own language):","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_speech_oral" value="0" <?php if($obj{"sensory_status_speech_oral"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Expresses complex ideas, feelings, and needs clearly, completely, and easily in all situations with no observable impairment.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_speech_oral" value="1" <?php if($obj{"sensory_status_speech_oral"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Minimal difficulty in expressing ideas and needs (may take extra time; makes occasional errors in word choice, grammar or speech intelligibility; needs minimal prompting or assistance).","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_speech_oral" value="2" <?php if($obj{"sensory_status_speech_oral"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Expresses simple ideas or needs with moderate difficulty (needs prompting or assistance, errors in word choice, organization or speech intelligibility). Speaks in phrases or short sentences.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_speech_oral" value="3" <?php if($obj{"sensory_status_speech_oral"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Has severe difficulty expressing basic ideas or needs and requires maximal assistance or guessing by listener. Speech limited to single words or short phrases.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_speech_oral" value="4" <?php if($obj{"sensory_status_speech_oral"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to express basic needs even with maximal prompting or assistance but is not comatose or unresponsive (e.g., speech is nonsensical or unintelligible).","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_speech_oral" value="5" <?php if($obj{"sensory_status_speech_oral"}=="5") echo "checked"; ?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient nonresponsive or unable to speak.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1240)</strong>
		</td>
		<td valign="middle" colspan="2">
			<?php xl("Has this patient had a formal ","e");?><strong><?php xl("Pain Assessment ","e");?></strong> <?php xl("using a standardized pain assessment tool (appropriate to the patient's ability to communicate the severity of pain)?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_pain" value="0" <?php if($obj{"sensory_status_pain"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No standardized assessment conducted","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_pain" value="1" <?php if($obj{"sensory_status_pain"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, and it does not indicate severe pain","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_pain" value="2" <?php if($obj{"sensory_status_pain"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, and it indicates severe pain","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1242)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Frequency of Pain Interfering ","e");?></strong> <?php xl("with patient's activity or movement:","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_frequency_pain" value="0" <?php if($obj{"sensory_status_frequency_pain"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient has no pain","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_frequency_pain" value="1" <?php if($obj{"sensory_status_frequency_pain"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient has pain that does not interfere with activity or movement","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_frequency_pain" value="2" <?php if($obj{"sensory_status_frequency_pain"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Less often than daily","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_frequency_pain" value="3" <?php if($obj{"sensory_status_frequency_pain"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Daily, but not constantly","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="sensory_status_frequency_pain" value="4" <?php if($obj{"sensory_status_frequency_pain"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("All of the time","e");?>
		</td>
	</tr>
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Integumentary Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable">
	<tr>
		<td valign="middle">
			<strong>(M1300)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Pressure Ulcer Assessment:","e");?></strong> <?php xl("Was this patient assessed for ","e");?><strong><?php xl("Risk of Developing Pressure Ulcers?","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_pressure_ulcer_assess" value="0" <?php if($obj{"integumentary_status_pressure_ulcer_assess"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No assessment conducted ","e");?><i><strong>[ Go to M1306 ]</strong></i>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_pressure_ulcer_assess" value="1" <?php if($obj{"integumentary_status_pressure_ulcer_assess"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, based on an evaluation of clinical factors, e.g., mobility, incontinence, nutrition, etc., without use of standardized tool","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_pressure_ulcer_assess" value="2" <?php if($obj{"integumentary_status_pressure_ulcer_assess"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, using a standardized tool, e.g., Braden, Norton, other","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1302)</strong>
		</td>
		<td valign="middle" colspan="2">
			<?php xl("Does this patient have a ","e");?> <strong><?php xl("Risk of Developing Pressure Ulcers?","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_risk_pressure_ulcer" value="0" <?php if($obj{"integumentary_status_risk_pressure_ulcer"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_risk_pressure_ulcer" value="1" <?php if($obj{"integumentary_status_risk_pressure_ulcer"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M1306)</strong>
		</td>
		<td valign="middle" colspan="2">
			<?php xl("Does this patient have at least one ","e");?><strong><?php xl("Unhealed (non-epithelialized) Pressure Ulcer at Stage II or Higher","e");?></strong> <?php xl("or designated as 'not stageable'?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_unhealed_pressure_ulcer" value="0" <?php if($obj{"integumentary_status_unhealed_pressure_ulcer"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No ","e");?><i><strong>[ Go to M1322 ]</strong></i>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_unhealed_pressure_ulcer" value="1" <?php if($obj{"integumentary_status_unhealed_pressure_ulcer"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="middle">
			<strong>(M1307)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Date of Onset of Oldest Unhealed Stage II Pressure Ulcer identified since most recent SOC/ROC assessment:","e");?></strong>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
		</td>
		<td>
			<input type='text' size='10' name='integumentary_status_date_unheal_stage2' id='integumentary_status_date_unheal_stage2' 
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>' value="<?php echo $obj{"integumentary_status_date_unheal_stage2"};?>" 
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
					Calendar.setup({inputField:"integumentary_status_date_unheal_stage2", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
					</script>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_date_unheal_stage2_status" value="UK" <?php if($obj{"integumentary_status_date_unheal_stage2_status"}=="UK") echo "checked"; ?> >
		</td>
		<td valign="middle">
			UK&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Present at most recent SOC/ROC assessment","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_date_unheal_stage2_status" value="NA" <?php if($obj{"integumentary_status_date_unheal_stage2_status"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No new Stage II pressure ulcer identified since most recent SOC/ROC assessment","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M1308)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Current Number of Unhealed (non-epithelialized) Pressure Ulcers at Each Stage: ","e");?></strong> <?php xl("(Enter '0' if none; enter '4' if '4 or more'; enter 'UK' for rows d.1 to d.3 if 'Unknown')","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="center" colspan="3">
			<table border="1px" class="formtable">
				<tr>
					<td colspan=2">
						<?php xl("Stage description: unhealed pressure ulcers","e");?>
					</td>
					<td>
						<?php xl("Number Present","e");?>
					</td>
					<td>
						<?php xl("Number of these that were present on admission (most recent SOC / ROC)","e");?>
					</td>
				</tr>
				<tr>
					<td width="5%">
						a.
					</td>
					<td>
						<strong><?php xl("Stage II: ","e");?></strong><?php xl(" Partial thickness loss of dermis presenting as a shallow open ulcer with red pink wound bed, without slough. May also present as an intact or open/ruptured serum-filled blister.","e");?>
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_a[]" value="<?php echo $integumentary_status_current_no_a[0];?>">
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_a[]" value="<?php echo $integumentary_status_current_no_a[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						b.
					</td>
					<td>
						<strong><?php xl("Stage III: ","e");?></strong><?php xl(" Full thickness tissue loss. Subcutaneous fat may be visible but bone, tendon, or muscles are not exposed. Slough may be present but does not obscure the depth of tissue loss. May include undermining and tunneling.","e");?>
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_b[]" value="<?php echo $integumentary_status_current_no_b[0];?>">
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_b[]" value="<?php echo $integumentary_status_current_no_b[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						c.
					</td>
					<td>
						<strong><?php xl("Stage IV: ","e");?></strong><?php xl(" Full thickness tissue loss with visible bone, tendon, or muscle. Slough or eschar may be present on some parts of the wound bed. Often includes undermining and tunneling.","e");?>
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_c[]" value="<?php echo $integumentary_status_current_no_c[0];?>">
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_c[]" value="<?php echo $integumentary_status_current_no_c[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						d 1.
					</td>
					<td>
						<?php xl(" Unstageable: Known or likely but not stageable due to non-removable dressing or device","e");?>
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_d1[]" value="<?php echo $integumentary_status_current_no_d1[0];?>">
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_d1[]" value="<?php echo $integumentary_status_current_no_d1[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						d 2.
					</td>
					<td>
						<?php xl(" Unstageable: Known or likely but not stageable due to coverage of wound bed by slough and/or eschar.","e");?>
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_d2[]" value="<?php echo $integumentary_status_current_no_d2[0];?>">
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_d2[]" value="<?php echo $integumentary_status_current_no_d2[1];?>">
					</td>
				</tr>
				<tr>
					<td>
						d 3.
					</td>
					<td>
						<?php xl(" Unstageable: Suspected deep tissue injury in evolution.","e");?>
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_d3[]" value="<?php echo $integumentary_status_current_no_d3[0];?>">
					</td>
					<td>
						<input type="text" name="integumentary_status_current_no_d3[]" value="<?php echo $integumentary_status_current_no_d3[1];?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>
		<td colspan="3">
			<strong><?php xl("Directions for M1310 and M1312: ","e");?></strong>
			<?php xl(" If the patient has one or more unhealed (non-epithelialized) Stage III or IV pressure ulcers, identify the ","e");?>
			<strong><?php xl(" pressure ulcer with the largest surface dimension (length x width) ","e");?></strong>
			<?php xl(" and record in centimeters:","e");?>
		<td>
	<tr>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1310)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Pressure Ulcer Length: ","e");?></strong> <?php xl("Longest length 'head-to-toe'","e");?>
			<input type="text" name="integumentary_status_pressure_ulcer_length" value="<?php echo $obj{"integumentary_status_pressure_ulcer_length"};?>">(cm)
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1312)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Pressure Ulcer Width: ","e");?></strong> <?php xl("Width of the same pressure ulcer; greatest width perpendicular to the length","e");?>
			<input type="text" name="integumentary_status_pressure_ulcer_width" value="<?php echo $obj{"integumentary_status_pressure_ulcer_width"};?>">(cm)
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1314)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Pressure Ulcer Depth: ","e");?></strong> <?php xl("Depth of the same pressure ulcer; from visible surface to the deepest area","e");?>
			<input type="text" name="integumentary_status_pressure_ulcer_depth" value="<?php echo $obj{"integumentary_status_pressure_ulcer_depth"};?>">(cm)
		</td>
	</tr>
	
	<tr>
		<td valign="middle">
			<strong>(M1320)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Status of Most Problematic (Observable) Pressure Ulcer:","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_ulcer" value="0" <?php if($obj{"integumentary_status_problematic_ulcer"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Re-epithelialized","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_ulcer" value="1" <?php if($obj{"integumentary_status_problematic_ulcer"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Fully granulating","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_ulcer" value="2" <?php if($obj{"integumentary_status_problematic_ulcer"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Early/partial granulation","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_ulcer" value="3" <?php if($obj{"integumentary_status_problematic_ulcer"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Not healing","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_ulcer" value="NA" <?php if($obj{"integumentary_status_problematic_ulcer"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No observable pressure ulcer","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1322)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Current Number of Stage I Pressure Ulcers: ","e");?></strong> <?php xl("Intact skin with non-blanchable redness of a localized area usually over a bony prominence. The area may be painful, firm, soft, warmer or cooler as compared to adjacent tissue.","e");?><br>
			<label><input type="checkbox" name="integumentary_status_current_ulcer_stage1" value="0" <?php if($obj{"integumentary_status_current_ulcer_stage1"}=="0") echo "checked"; ?> >0</label>
			<label><input type="checkbox" name="integumentary_status_current_ulcer_stage1" value="1" <?php if($obj{"integumentary_status_current_ulcer_stage1"}=="1") echo "checked"; ?> >1</label>
			<label><input type="checkbox" name="integumentary_status_current_ulcer_stage1" value="2" <?php if($obj{"integumentary_status_current_ulcer_stage1"}=="2") echo "checked"; ?> >2</label>
			<label><input type="checkbox" name="integumentary_status_current_ulcer_stage1" value="3" <?php if($obj{"integumentary_status_current_ulcer_stage1"}=="3") echo "checked"; ?> >3</label>
			<label><input type="checkbox" name="integumentary_status_current_ulcer_stage1" value="4 or more" <?php if($obj{"integumentary_status_current_ulcer_stage1"}=="4 or more") echo "checked"; ?> >4 or more</label>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1324)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Stage of Most Problematic (Observable) Pressure Ulcer:","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_stage_of_problematic_ulcer" value="1" <?php if($obj{"integumentary_status_stage_of_problematic_ulcer"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Stage I","e");?> <i><strong>[Go to M1330 at SOC/ROC/FU ]</strong></i>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_stage_of_problematic_ulcer" value="2" <?php if($obj{"integumentary_status_stage_of_problematic_ulcer"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Stage II","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_stage_of_problematic_ulcer" value="3" <?php if($obj{"integumentary_status_stage_of_problematic_ulcer"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Stage III","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_stage_of_problematic_ulcer" value="4" <?php if($obj{"integumentary_status_stage_of_problematic_ulcer"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Stage IV","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_stage_of_problematic_ulcer" value="NA" <?php if($obj{"integumentary_status_stage_of_problematic_ulcer"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No observable pressure ulcer","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1330)</strong>
		</td>
		<td valign="middle" colspan="2">
			<?php xl("Does this patient have a ","e");?> <strong><?php xl("Stasis Ulcer?","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_statis_ulcer" value="0" <?php if($obj{"integumentary_status_statis_ulcer"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?> <i><strong>[ Go to M1340 ]</strong></i>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_statis_ulcer" value="1" <?php if($obj{"integumentary_status_statis_ulcer"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, patient has one or more (observable) stasis ulcers","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_statis_ulcer" value="2" <?php if($obj{"integumentary_status_statis_ulcer"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Stasis ulcer known but not observable due to non-removable dressing","e");?><i><strong>[ Go to M1340 ]</strong></i>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1332)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Current Number of (Observable) Stasis Ulcer(s):","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_current_no_statis_ulcer" value="1" <?php if($obj{"integumentary_status_current_no_statis_ulcer"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("One","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_current_no_statis_ulcer" value="2" <?php if($obj{"integumentary_status_current_no_statis_ulcer"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Two","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_current_no_statis_ulcer" value="3" <?php if($obj{"integumentary_status_current_no_statis_ulcer"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Three","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_current_no_statis_ulcer" value="4" <?php if($obj{"integumentary_status_current_no_statis_ulcer"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Four or more","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1334)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Status of Most Problematic (Observable) Stasis Ulcer: ","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_statis_ulcer" value="1" <?php if($obj{"integumentary_status_problematic_statis_ulcer"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Fully granulating","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_statis_ulcer" value="2" <?php if($obj{"integumentary_status_problematic_statis_ulcer"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Early/partial granulation","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_statis_ulcer" value="3" <?php if($obj{"integumentary_status_problematic_statis_ulcer"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Not healing","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1340)</strong>
		</td>
		<td valign="middle" colspan="2">
			<?php xl("Does this patient have a ","e");?> <strong><?php xl("Surgical Wound?","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_surgical_wound" value="0" <?php if($obj{"integumentary_status_surgical_wound"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?><i><strong>[ Go to M1350 ]</strong></i>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_surgical_wound" value="1" <?php if($obj{"integumentary_status_surgical_wound"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, patient has at least one (observable) surgical wound","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_surgical_wound" value="2" <?php if($obj{"integumentary_status_surgical_wound"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Surgical wound known but not observable due to non-removable dressing","e");?><i><strong>[ Go to M1350 ]</strong></i>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1342)</strong>
		</td>
		<td valign="middle" colspan="2">
			<strong><?php xl("Status of Most Problematic (Observable) Surgical Wound:","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_surgical_wound" value="0" <?php if($obj{"integumentary_status_problematic_surgical_wound"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Re-epithelialized","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_surgical_wound" value="1" <?php if($obj{"integumentary_status_problematic_surgical_wound"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Fully granulating","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_surgical_wound" value="2" <?php if($obj{"integumentary_status_problematic_surgical_wound"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Early/partial granulation","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_problematic_surgical_wound" value="3" <?php if($obj{"integumentary_status_problematic_surgical_wound"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Not healing","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1350)</strong>
		</td>
		<td valign="middle" colspan="2">
			<?php xl("Does this patient have a ","e");?> 
			<strong><?php xl(" Skin Lesion or Open Wound, ","e");?></strong> 
			<?php xl("excluding bowel ostomy, other than those described above ","e");?><u><?php xl("that is receiving intervention","e");?></u><?php xl(" by the home health agency?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_skin_lesion" value="0" <?php if($obj{"integumentary_status_skin_lesion"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="integumentary_status_skin_lesion" value="1" <?php if($obj{"integumentary_status_skin_lesion"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	
	
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Respiratory Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable">
	<tr>
		<td valign="middle">
			<strong>(M1400)</strong>
		</td>
		<td valign="middle" colspan="6">
			<?php xl("When is the patient dyspneic or noticeably","e");?><strong><?php xl("Short of Breath?","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_short_of_breath" value="0" <?php if($obj{"respiratory_status_short_of_breath"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient is not short of breath","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_short_of_breath" value="1" <?php if($obj{"respiratory_status_short_of_breath"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("When walking more than 20 feet, climbing stairs","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_short_of_breath" value="2" <?php if($obj{"respiratory_status_short_of_breath"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("With moderate exertion (e.g., while dressing, using commode or bedpan, walking distances less than 20 feet)","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_short_of_breath" value="3" <?php if($obj{"respiratory_status_short_of_breath"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("With minimal exertion (e.g., while eating, talking, or performing other ADLs) or with agitation","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_short_of_breath" value="4" <?php if($obj{"respiratory_status_short_of_breath"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("At rest (during day or night)","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1410)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Respiratory Treatments ","e");?></strong><?php xl(" utilized at home: ","e");?><strong><?php xl(" (Mark all that apply.)","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_treatments[]" value="1" <?php if(in_array("1",$respiratory_status_treatments)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Oxygen (intermittent or continuous)","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_treatments[]" value="2" <?php if(in_array("2",$respiratory_status_treatments)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Ventilator (continually or at night)","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_treatments[]" value="3" <?php if(in_array("3",$respiratory_status_treatments)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Continuous / Bi-level positive airway pressure","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="respiratory_status_treatments[]" value="4" <?php if(in_array("4",$respiratory_status_treatments)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("None of the above","e");?>
		</td>
	</tr>
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Cardiac Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable">
	<tr>
		<td valign="top">
			<strong>(M1500)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Symptoms in Heart Failure Patients: ","e");?></strong><?php xl(" If patient has been diagnosed with heart failure, did the patient exhibit symptoms indicated by clinical heart failure guidelines (including dyspnea, orthopnea, edema, or weight gain) at any point since the previous OASIS assessment?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_symptoms" value="0" <?php if($obj{"cardiac_status_symptoms"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?><strong><i>[ Go to M1732 at TRN; Go to M1600 at DC ]</i></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_symptoms" value="1" <?php if($obj{"cardiac_status_symptoms"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_symptoms" value="2" <?php if($obj{"cardiac_status_symptoms"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Not assessed","e");?><strong><i>[ Go to M1732 at TRN; Go to M1600 at DC ]</i></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_symptoms" value="NA" <?php if($obj{"cardiac_status_symptoms"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient does not have diagnosis of heart failure","e");?><strong><i>[ Go to M1732 at TRN; Go to M1600 at DC ]</i></strong>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M1510)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Heart Failure Follow-up: ","e");?></strong><?php xl(" If patient has been diagnosed with heart failure and has exhibited symptoms indicative of heart failure since the previous OASIS assessment, what action(s) has (have) been taken to respond? ","e");?><strong><?php xl(" (Mark all that apply.)","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_follow_up[]" value="0" <?php if(in_array("0",$cardiac_status_follow_up)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No action taken","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_follow_up[]" value="1" <?php if(in_array("1",$cardiac_status_follow_up)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient's physician (or other primary care practitioner) contacted the same day","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_follow_up[]" value="2" <?php if(in_array("2",$cardiac_status_follow_up)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient advised to get emergency treatment (e.g., call 911 or go to emergency room)","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_follow_up[]" value="3" <?php if(in_array("3",$cardiac_status_follow_up)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Implement physician-ordered patient-specific established parameters for treatment","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_follow_up[]" value="4" <?php if(in_array("4",$cardiac_status_follow_up)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient education or other clinical interventions","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="cardiac_status_follow_up[]" value="5" <?php if(in_array("5",$cardiac_status_follow_up)) { echo "checked"; };?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Obtained change in care plan orders (e.g., increased monitoring by agency, change in visit frequency, telehealth, etc.)","e");?>
		</td>
	</tr>
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Elimination Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable">
	<tr>
		<td valign="middle">
			<strong>(M1600)</strong>
		</td>
		<td valign="middle" colspan="6">
			<?php xl("Has this patient been treated for a ","e");?><strong><?php xl(" Urinary Tract Infection ","e");?></strong><?php xl(" in the past 14 days?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_urinary_tract_infection" value="0" <?php if($obj{"elimination_status_urinary_tract_infection"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_urinary_tract_infection" value="1" <?php if($obj{"elimination_status_urinary_tract_infection"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_urinary_tract_infection" value="NA" <?php if($obj{"elimination_status_urinary_tract_infection"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient on prophylactic treatment","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_urinary_tract_infection" value="UK" <?php if($obj{"elimination_status_urinary_tract_infection"}=="UK") echo "checked"; ?> >
		</td>
		<td valign="middle">
			UK&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unknown","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1610)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Urinary Incontinence or Urinary Catheter Presence:","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_urinary_incontinence" value="0" <?php if($obj{"elimination_status_urinary_incontinence"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No incontinence or catheter (includes anuria or ostomy for urinary drainage)","e");?><strong><i>[ Go to M1620 ]</i></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_urinary_incontinence" value="1" <?php if($obj{"elimination_status_urinary_incontinence"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient is incontinent","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_urinary_incontinence" value="2" <?php if($obj{"elimination_status_urinary_incontinence"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient requires a urinary catheter (i.e., external, indwelling, intermittent, suprapubic)","e");?><strong><i>[ Go to M1620 ]</i></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1615)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("When does Urinary Incontinence occur?","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_when_urinary_incontinence_occur" value="0" <?php if($obj{"elimination_status_when_urinary_incontinence_occur"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Timed-voiding defers incontinence","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_when_urinary_incontinence_occur" value="1" <?php if($obj{"elimination_status_when_urinary_incontinence_occur"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Occasional stress incontinence","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_when_urinary_incontinence_occur" value="2" <?php if($obj{"elimination_status_when_urinary_incontinence_occur"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("During the night only","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_when_urinary_incontinence_occur" value="3" <?php if($obj{"elimination_status_when_urinary_incontinence_occur"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("During the day only","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_when_urinary_incontinence_occur" value="4" <?php if($obj{"elimination_status_when_urinary_incontinence_occur"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("During the day and night","e");?>
		</td>
	</tr>
		<tr>
		<td valign="middle">
			<strong>(M1620)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Bowel Incontinence Frequency:","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_incontinence_frequency" value="0" <?php if($obj{"elimination_status_bowel_incontinence_frequency"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Very rarely or never has bowel incontinence","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_incontinence_frequency" value="1" <?php if($obj{"elimination_status_bowel_incontinence_frequency"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Less than once weekly","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_incontinence_frequency" value="2" <?php if($obj{"elimination_status_bowel_incontinence_frequency"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("One to three times weekly","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_incontinence_frequency" value="3" <?php if($obj{"elimination_status_bowel_incontinence_frequency"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Four to six times weekly","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_incontinence_frequency" value="4" <?php if($obj{"elimination_status_bowel_incontinence_frequency"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("On a daily basis","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_incontinence_frequency" value="5" <?php if($obj{"elimination_status_bowel_incontinence_frequency"}=="5") echo "checked"; ?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("More often than once daily","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_incontinence_frequency" value="NA" <?php if($obj{"elimination_status_bowel_incontinence_frequency"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient has ostomy for bowel elimination","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_incontinence_frequency" value="UK" <?php if($obj{"elimination_status_bowel_incontinence_frequency"}=="UK") echo "checked"; ?> >
		</td>
		<td valign="middle">
			UK&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unknown","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1630)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Ostomy for Bowel Elimination:","e");?></strong> <?php xl(" Does this patient have an ostomy for bowel elimination that (within the last 14 days): a) was related to an inpatient facility stay, ","e");?><u><?php xl("or","e");?></u><?php xl(" b) necessitated a change in medical or treatment regimen?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_elimination" value="0" <?php if($obj{"elimination_status_bowel_elimination"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient does ","e");?><u><?php xl("not","e");?></u><?php xl(" have an ostomy for bowel elimination.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_elimination" value="1" <?php if($obj{"elimination_status_bowel_elimination"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient's ostomy was ","e");?><u><?php xl("not","e");?></u><?php xl(" related to an inpatient stay and did ","e");?><u><?php xl("not","e");?></u><?php xl(" necessitate change in medical or treatment regimen.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="elimination_status_bowel_elimination" value="2" <?php if($obj{"elimination_status_bowel_elimination"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("The ostomy ","e");?><u><?php xl("was","e");?></u><?php xl(" related to an inpatient stay or ","e");?><u><?php xl("did","e");?></u><?php xl(" necessitate change in medical or treatment regimen.","e");?>
		</td>
	</tr>
	
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Neuro/Emotional/Behavioral statusDiagnoses</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable">
	<tr>
		<td valign="top">
			<strong>(M1700)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Cognitive Functioning: ","e");?></strong><?php xl(" Patient's current (day of assessment) level of alertness, orientation, comprehension, concentration, and immediate memory for simple commands.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_cognitive_functioning" value="0" <?php if($obj{"neuro_status_cognitive_functioning"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Alert/oriented, able to focus and shift attention, comprehends and recalls task directions independently.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_cognitive_functioning" value="1" <?php if($obj{"neuro_status_cognitive_functioning"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Requires prompting (cuing, repetition, reminders) only under stressful or unfamiliar conditions.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_cognitive_functioning" value="2" <?php if($obj{"neuro_status_cognitive_functioning"}=="2") echo "checked"; ?> >
		</td>
		<td valign="top">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Requires assistance and some direction in specific situations (e.g., on all tasks involving shifting of attention), or consistently requires low stimulus environment due to distractibility.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_cognitive_functioning" value="3" <?php if($obj{"neuro_status_cognitive_functioning"}=="3") echo "checked"; ?> >
		</td>
		<td valign="top">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Requires considerable assistance in routine situations. Is not alert and oriented or is unable to shift attention and recall directions more than half the time.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_cognitive_functioning" value="4" <?php if($obj{"neuro_status_cognitive_functioning"}=="4") echo "checked"; ?> >
		</td>
		<td valign="top">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Totally dependent due to disturbances such as constant disorientation, coma, persistent vegetative state, or delirium.","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="middle">
			<strong>(M1710)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("When Confused (Reported or Observed Within the Last 14 Days): ","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_confused" value="0" <?php if($obj{"neuro_status_when_confused"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Never","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_confused" value="1" <?php if($obj{"neuro_status_when_confused"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("In new or complex situations only","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_confused" value="2" <?php if($obj{"neuro_status_when_confused"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("On awakening or at night only","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_confused" value="3" <?php if($obj{"neuro_status_when_confused"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("During the day and evening, but not constantly","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_confused" value="4" <?php if($obj{"neuro_status_when_confused"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Constantly","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_confused" value="NA" <?php if($obj{"neuro_status_when_confused"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient nonresponsive","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1720)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("When Anxious (Reported or Observed Within the Last 14 Days): ","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_anxious" value="0" <?php if($obj{"neuro_status_when_anxious"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("None of the time","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_anxious" value="1" <?php if($obj{"neuro_status_when_anxious"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Less often than daily","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_anxious" value="2" <?php if($obj{"neuro_status_when_anxious"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Daily, but not constantly","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_anxious" value="3" <?php if($obj{"neuro_status_when_anxious"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("All of the time","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_when_anxious" value="NA" <?php if($obj{"neuro_status_when_anxious"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient nonresponsive","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1730)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Depression Screening: ","e");?></strong><?php xl(" Has the patient been screened for depression, using a standardized depression screening tool? ","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_depression_screening" value="0" <?php if($obj{"neuro_status_depression_screening"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_depression_screening" value="1" <?php if($obj{"neuro_status_depression_screening"}=="1") echo "checked"; ?> >
		</td>
		<td valign="top">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, patient was screened using the PHQ-2","e");?>&copy;<?php xl(" scale. (Instructions for this two-question tool: Ask patient: 'Over the last two weeks, how often have you been bothered by any of the following problems')","e");?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<table width="100%" class="formtable" border="1px">
				<tr>
					<td>
						<strong>PHQ-2&copy; Pfizer</strong>
					</td>
					<td>
						<?php xl("Not at all 0-1 day","e");?>
					</td>
					<td>
						<?php xl("Several days 2-6 days","e");?>
					</td>
					<td>
						<?php xl("More than half of the days 7-11 days","e");?>
					</td>
					<td>
						<?php xl("Nearly every day 12-14 days","e");?>
					</td>
					<td>
						<?php xl("N/A Unable to respond","e");?>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("a) Little interest or pleasure in doing things","e");?>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_little_interest" value="0" <?php if($obj{"neuro_status_depression_screening_little_interest"}=="0") echo "checked"; ?> >0</label>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_little_interest" value="1" <?php if($obj{"neuro_status_depression_screening_little_interest"}=="1") echo "checked"; ?> >1</label>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_little_interest" value="2" <?php if($obj{"neuro_status_depression_screening_little_interest"}=="2") echo "checked"; ?> >2</label>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_little_interest" value="3" <?php if($obj{"neuro_status_depression_screening_little_interest"}=="3") echo "checked"; ?> >3</label>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_little_interest" value="NA" <?php if($obj{"neuro_status_depression_screening_little_interest"}=="NA") echo "checked"; ?> >NA</label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("b) Feeling down, depressed, or hopeless?","e");?>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_feeling_down" value="0" <?php if($obj{"neuro_status_depression_screening_feeling_down"}=="0") echo "checked"; ?> >0</label>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_feeling_down" value="1" <?php if($obj{"neuro_status_depression_screening_feeling_down"}=="1") echo "checked"; ?> >1</label>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_feeling_down" value="2" <?php if($obj{"neuro_status_depression_screening_feeling_down"}=="2") echo "checked"; ?> >2</label>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_feeling_down" value="3" <?php if($obj{"neuro_status_depression_screening_feeling_down"}=="3") echo "checked"; ?> >3</label>
					</td>
					<td>
						<label><input type="checkbox" name="neuro_status_depression_screening_feeling_down" value="NA" <?php if($obj{"neuro_status_depression_screening_feeling_down"}=="NA") echo "checked"; ?> >NA</label>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_depression_screening" value="2" <?php if($obj{"neuro_status_depression_screening"}=="2") echo "checked"; ?> >
		</td>
		<td valign="top">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, with a different standardized assessment-and the patient meets criteria for further evaluation for depression.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_depression_screening" value="3" <?php if($obj{"neuro_status_depression_screening"}=="3") echo "checked"; ?> >
		</td>
		<td valign="top">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, patient was screened with a different standardized assessment-and the patient does not meet criteria for further evaluation for depression.","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M1740)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Cognitive, behavioral, and psychiatric symptoms ","e");?></strong><?php xl(" that are demonstrated ","e");?><u><?php xl("at least once a week","e");?></u><?php xl(" (Reported or Observed): ","e");?><strong><?php xl("(Mark all that apply.)","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_cognitive_symptoms[]" value="1" <?php if(in_array("1",$neuro_status_cognitive_symptoms)) { echo "checked"; }?> >
		</td>
		<td valign="top">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Memory deficit: failure to recognize familiar persons/places, inability to recall events of past 24 hours, significant memory loss so that supervision is required","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_cognitive_symptoms[]" value="2" <?php if(in_array("2",$neuro_status_cognitive_symptoms)) { echo "checked"; }?> >
		</td>
		<td valign="top">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Impaired decision-making: failure to perform usual ADLs or IADLs, inability to appropriately stop activities, jeopardizes safety through actions","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_cognitive_symptoms[]" value="3" <?php if(in_array("3",$neuro_status_cognitive_symptoms)) { echo "checked"; }?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Verbal disruption: yelling, threatening, excessive profanity, sexual references, etc.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="neuro_status_cognitive_symptoms[]" value="4" <?php if(in_array("4",$neuro_status_cognitive_symptoms)) { echo "checked"; }?> >
		</td>
		<td valign="top">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Physical aggression: aggressive or combative to self and others (e.g., hits self, throws objects, punches, dangerous maneuvers with wheelchair or other objects)","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_cognitive_symptoms[]" value="5" <?php if(in_array("5",$neuro_status_cognitive_symptoms)) { echo "checked"; }?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Disruptive, infantile, or socially inappropriate behavior (excludes verbal actions)","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_cognitive_symptoms[]" value="6" <?php if(in_array("6",$neuro_status_cognitive_symptoms)) { echo "checked"; }?> >
		</td>
		<td valign="middle">
			6&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Delusional, hallucinatory, or paranoid behavior","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_cognitive_symptoms[]" value="7" <?php if(in_array("7",$neuro_status_cognitive_symptoms)) { echo "checked"; }?> >
		</td>
		<td valign="middle">
			7&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("None of the above behaviors demonstrated","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1745)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Frequency of Disruptive Behavior Symptoms (Reported or Observed) ","e");?></strong><?php xl(" Any physical, verbal, or other disruptive/dangerous symptoms that are injurious to self or others or jeopardize personal safety.","e");?><strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_freq_behaviour_symptoms" value="0" <?php if($obj{"neuro_status_freq_behaviour_symptoms"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Never","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_freq_behaviour_symptoms" value="1" <?php if($obj{"neuro_status_freq_behaviour_symptoms"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Less than once a month","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_freq_behaviour_symptoms" value="2" <?php if($obj{"neuro_status_freq_behaviour_symptoms"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Once a month","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_freq_behaviour_symptoms" value="3" <?php if($obj{"neuro_status_freq_behaviour_symptoms"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Several times each month","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_freq_behaviour_symptoms" value="4" <?php if($obj{"neuro_status_freq_behaviour_symptoms"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Several times a week","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_freq_behaviour_symptoms" value="5" <?php if($obj{"neuro_status_freq_behaviour_symptoms"}=="5") echo "checked"; ?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("At least daily","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle">
			<strong>(M1750)</strong>
		</td>
		<td valign="middle" colspan="6">
			<?php xl("Is this patient receiving ","e");?><strong><?php xl(" Psychiatric Nursing Services ","e");?></strong><?php xl(" at home provided by a qualified psychiatric nurse?","e");?><strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_psychiatric_nursing_service" value="0" <?php if($obj{"neuro_status_psychiatric_nursing_service"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="neuro_status_psychiatric_nursing_service" value="1" <?php if($obj{"neuro_status_psychiatric_nursing_service"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">ADL/IADLS</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable">
	<tr>
		<td valign="top">
			<strong>(M1800)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Grooming: ","e");?></strong><?php xl(" Current ability to tend safely to personal hygiene needs (i.e., washing face and hands, hair care, shaving or make up, teeth or denture care, fingernail care).","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_grooming" value="0" <?php if($obj{"adl_iadl_grooming"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to groom self unaided, with or without the use of assistive devices or adapted methods.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_grooming" value="1" <?php if($obj{"adl_iadl_grooming"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Grooming utensils must be placed within reach before able to complete grooming activities.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_grooming" value="2" <?php if($obj{"adl_iadl_grooming"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Someone must assist the patient to groom self.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_grooming" value="3" <?php if($obj{"adl_iadl_grooming"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient depends entirely upon someone else for grooming needs.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1810)</strong>
		</td>
		<td valign="middle" colspan="6">
			<?php xl("Current ","e");?><strong><?php xl("Ability to Dress ","e");?><u><?php xl("Upper","e");?></u><?php xl(" Body ","e");?></strong><?php xl(" safely (with or without dressing aids) including undergarments, pullovers, front-opening shirts and blouses, managing zippers, buttons, and snaps:","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_dress_upper" value="0" <?php if($obj{"adl_iadl_dress_upper"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to get clothes out of closets and drawers, put them on and remove them from the upper body without assistance.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_dress_upper" value="1" <?php if($obj{"adl_iadl_dress_upper"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to dress upper body without assistance if clothing is laid out or handed to the patient.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_dress_upper" value="2" <?php if($obj{"adl_iadl_dress_upper"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Someone must help the patient put on upper body clothing.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_dress_upper" value="3" <?php if($obj{"adl_iadl_dress_upper"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient depends entirely upon another person to dress the upper body.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1820)</strong>
		</td>
		<td valign="middle" colspan="6">
			<?php xl("Current ","e");?><strong><?php xl("Ability to Dress ","e");?><u><?php xl("Lower","e");?></u><?php xl(" Body ","e");?></strong><?php xl(" safely (with or without dressing aids) including undergarments, slacks, socks or nylons, shoes:","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_dress_lower" value="0" <?php if($obj{"adl_iadl_dress_lower"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to obtain, put on, and remove clothing and shoes without assistance.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_dress_lower" value="1" <?php if($obj{"adl_iadl_dress_lower"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to dress lower body without assistance if clothing and shoes are laid out or handed to the patient.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_dress_lower" value="2" <?php if($obj{"adl_iadl_dress_lower"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Someone must help the patient put on undergarments, slacks, socks or nylons, and shoes.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_dress_lower" value="3" <?php if($obj{"adl_iadl_dress_lower"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient depends entirely upon another person to dress lower body.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1830)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Bathing:","e");?></strong><?php xl(" Current ability to wash entire body safely. ","e");?><strong><ul><?php xl("Excludes","e");?></u><?php xl(" grooming (washing face and hands only).","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_bathing" value="0" <?php if($obj{"adl_iadl_bathing"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to bathe self in ","e");?><u><?php xl("shower or tub","e");?></u><?php xl(" independently, including getting in and out of tub/shower.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_bathing" value="1" <?php if($obj{"adl_iadl_bathing"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("With the use of devices, is able to bathe self in shower or tub independently, including getting in and out of the tub/shower.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_bathing" value="2" <?php if($obj{"adl_iadl_bathing"}=="2") echo "checked"; ?> >
		</td>
		<td valign="top">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to bathe in shower or tub with the intermittent assistance of another person:","e");?><br>
			<?php xl("(a) for intermittent supervision or encouragement or reminders, ","e");?><u><?php xl("OR","e");?></u><br>
			<?php xl("(b) to get in and out of the shower or tub, ","e");?><u><?php xl("OR","e");?></u><br>
			<?php xl("(c) for washing difficult to reach areas.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_bathing" value="3" <?php if($obj{"adl_iadl_bathing"}=="3") echo "checked"; ?> >
		</td>
		<td valign="top">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to participate in bathing self in shower or tub, ","e");?><u><?php xl("but","e");?></u><?php xl(" requires presence of another person throughout the bath for assistance or supervision.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_bathing" value="4" <?php if($obj{"adl_iadl_bathing"}=="4") echo "checked"; ?> >
		</td>
		<td valign="top">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to use the shower or tub, but able to bathe self independently with or without the use of devices at the sink, in chair, or on commode.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_bathing" value="5" <?php if($obj{"adl_iadl_bathing"}=="5") echo "checked"; ?> >
		</td>
		<td valign="top">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to use the shower or tub, but able to participate in bathing self in bed, at the sink, in bedside chair, or on commode, with the assistance or supervision of another person throughout the bath.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_bathing" value="6" <?php if($obj{"adl_iadl_bathing"}=="6") echo "checked"; ?> >
		</td>
		<td valign="middle">
			6&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to participate effectively in bathing and is bathed totally by another person.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1840)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Toilet Transferring: ","e");?></strong><?php xl(" Current ability to get to and from the toilet or bedside commode safely ","e");?><u><?php xl("and","e");?></u><?php xl(" transfer on and off toilet/commode.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_toilet_transfer" value="0" <?php if($obj{"adl_iadl_toilet_transfer"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to get to and from the toilet and transfer independently with or without a device.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_toilet_transfer" value="1" <?php if($obj{"adl_iadl_toilet_transfer"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("When reminded, assisted, or supervised by another person, able to get to and from the toilet and transfer.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_toilet_transfer" value="2" <?php if($obj{"adl_iadl_toilet_transfer"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<u><?php xl("Unable","e");?></u><?php xl(" to get to and from the toilet but is able to use a bedside commode (with or without assistance).","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_toilet_transfer" value="3" <?php if($obj{"adl_iadl_toilet_transfer"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<u><?php xl("Unable","e");?></u><?php xl(" to get to and from the toilet or bedside commode but is able to use a bedpan/urinal independently.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_toilet_transfer" value="4" <?php if($obj{"adl_iadl_toilet_transfer"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Is totally dependent in toileting.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1845)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Toileting Hygiene: ","e");?></strong><?php xl(" Current ability to maintain perineal hygiene safely, adjust clothes and/or incontinence pads before and after using toilet, commode, bedpan, urinal. If managing ostomy, includes cleaning area around stoma, but not managing equipment.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_toilet_hygiene" value="0" <?php if($obj{"adl_iadl_toilet_hygiene"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to manage toileting hygiene and clothing management without assistance.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_toilet_hygiene" value="1" <?php if($obj{"adl_iadl_toilet_hygiene"}=="1") echo "checked"; ?> >
		</td>
		<td valign="top">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to manage toileting hygiene and clothing management without assistance if supplies/implements are laid out for the patient.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_toilet_hygiene" value="2" <?php if($obj{"adl_iadl_toilet_hygiene"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Someone must help the patient to maintain toileting hygiene and/or adjust clothing.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_toilet_hygiene" value="3" <?php if($obj{"adl_iadl_toilet_hygiene"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient depends entirely upon another person to maintain toileting hygiene.","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M1850)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Transferring: ","e");?></strong><?php xl(" Current ability to move safely from bed to chair, or ability to turn and position self in bed if patient is bedfast.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_transferring" value="0" <?php if($obj{"adl_iadl_transferring"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to independently transfer.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_transferring" value="1" <?php if($obj{"adl_iadl_transferring"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to transfer with minimal human assistance or with use of an assistive device.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_transferring" value="2" <?php if($obj{"adl_iadl_transferring"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to bear weight and pivot during the transfer process but unable to transfer self.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_transferring" value="3" <?php if($obj{"adl_iadl_transferring"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to transfer self and is unable to bear weight or pivot when transferred by another person.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_transferring" value="4" <?php if($obj{"adl_iadl_transferring"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Bedfast, unable to transfer but is able to turn and position self in bed.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_transferring" value="5" <?php if($obj{"adl_iadl_transferring"}=="5") echo "checked"; ?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Bedfast, unable to transfer and is unable to turn and position self.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1860)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Ambulation/Locomotion: ","e");?></strong><?php xl(" Current ability to walk safely, once in a standing position, or use a wheelchair, once in a seated position, on a variety of surfaces.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_ambulation" value="0" <?php if($obj{"adl_iadl_ambulation"}=="0") echo "checked"; ?> >
		</td>
		<td valign="top">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to independently walk on even and uneven surfaces and negotiate stairs with or without railings (i.e., needs no human assistance or assistive device).","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_ambulation" value="1" <?php if($obj{"adl_iadl_ambulation"}=="1") echo "checked"; ?> >
		</td>
		<td valign="top">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("With the use of a one-handed device (e.g. cane, single crutch, hemi-walker), able to independently walk on even and uneven surfaces and negotiate stairs with or without railings.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_ambulation" value="2" <?php if($obj{"adl_iadl_ambulation"}=="2") echo "checked"; ?> >
		</td>
		<td valign="top">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Requires use of a two-handed device (e.g., walker or crutches) to walk alone on a level surface and/or requires human supervision or assistance to negotiate stairs or steps or uneven surfaces.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_ambulation" value="3" <?php if($obj{"adl_iadl_ambulation"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to walk only with the supervision or assistance of another person at all times.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_ambulation" value="4" <?php if($obj{"adl_iadl_ambulation"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Chairfast, ","e");?><u><?php xl("unable","e");?></u><?php xl(" to ambulate but is able to wheel self independently.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_ambulation" value="5" <?php if($obj{"adl_iadl_ambulation"}=="5") echo "checked"; ?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Chairfast, unable to ambulate and is unable to wheel self.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_ambulation" value="6" <?php if($obj{"adl_iadl_ambulation"}=="6") echo "checked"; ?> >
		</td>
		<td valign="middle">
			6&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Bedfast, unable to ambulate or be up in a chair.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1870)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Feeding or Eating: ","e");?></strong><?php xl(" Current ability to feed self meals and snacks safely. Note: This refers only to the process of ","e");?><u><?php xl("eating, chewing","e");?></u><?php xl(", and ","e");?><u><?php xl("swallowing, not preparing","e");?></u><?php xl(" the food to be eaten.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_feeding" value="0" <?php if($obj{"adl_iadl_feeding"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to independently feed self.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_feeding" value="1" <?php if($obj{"adl_iadl_feeding"}=="1") echo "checked"; ?> >
		</td>
		<td valign="top">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to feed self independently but requires:","e");?><br>
			<?php xl("(a) meal set-up; ","e");?><u><?php xl("OR","e");?></u><br>
			<?php xl("(b) intermittent assistance or supervision from another person; ","e");?><u><?php xl("OR","e");?></u><br>
			<?php xl("(c) a liquid, pureed or ground meat diet.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_feeding" value="2" <?php if($obj{"adl_iadl_feeding"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<u><?php xl("Unable","e");?></u><?php xl(" to feed self and must be assisted or supervised throughout the meal/snack.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_feeding" value="3" <?php if($obj{"adl_iadl_feeding"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to take in nutrients orally ","e");?><u><?php xl("and","e");?></u><?php xl(" receives supplemental nutrients through a nasogastric tube or gastrostomy.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_feeding" value="4" <?php if($obj{"adl_iadl_feeding"}=="4") echo "checked"; ?> >
		</td>
		<td valign="middle">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<u><?php xl("Unable","e");?></u><?php xl(" to take in nutrients orally and is fed nutrients through a nasogastric tube or gastrostomy.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_feeding" value="5" <?php if($obj{"adl_iadl_feeding"}=="5") echo "checked"; ?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to take in nutrients orally or by tube feeding.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1880)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Current Ability to Plan and Prepare Light Meals ","e");?></strong><?php xl(" (e.g., cereal, sandwich) or reheat delivered meals safely:","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_prepare_meal" value="0" <?php if($obj{"adl_iadl_prepare_meal"}=="0") echo "checked"; ?> >
		</td>
		<td valign="top">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("(a) Able to independently plan and prepare all light meals for self or reheat delivered meals; ","e");?><u><?php xl("OR","e");?></u><br>
			<?php xl("(b) Is physically, cognitively, and mentally able to prepare light meals on a regular basis but has not routinely performed light meal preparation in the past (i.e., prior to this home care admission).","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_prepare_meal" value="1" <?php if($obj{"adl_iadl_prepare_meal"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<u><?php xl("Unable","e");?></u><?php xl(" to prepare light meals on a regular basis due to physical, cognitive, or mental limitations.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_prepare_meal" value="2" <?php if($obj{"adl_iadl_prepare_meal"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Unable to prepare any light meals or reheat any delivered meals.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1890)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Ability to Use Telephone: ","e");?></strong><?php xl(" Current ability to answer the phone safely, including dialing numbers, and ","e");?><u><?php xl("effectively","e");?></u><?php xl(" using the telephone to communicate.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_use_telephone" value="0" <?php if($obj{"adl_iadl_use_telephone"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to dial numbers and answer calls appropriately and as desired.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_use_telephone" value="1" <?php if($obj{"adl_iadl_use_telephone"}=="1") echo "checked"; ?> >
		</td>
		<td valign="top">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to use a specially adapted telephone (i.e., large numbers on the dial, teletype phone for the deaf) and call essential numbers.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_use_telephone" value="2" <?php if($obj{"adl_iadl_use_telephone"}=="2") echo "checked"; ?> >
		</td>
		<td valign="top">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to answer the telephone and carry on a normal conversation but has difficulty with placing calls.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_use_telephone" value="3" <?php if($obj{"adl_iadl_use_telephone"}=="3") echo "checked"; ?> >
		</td>
		<td valign="top">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to answer the telephone only some of the time or is able to carry on only a limited conversation.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="adl_iadl_use_telephone" value="4" <?php if($obj{"adl_iadl_use_telephone"}=="4") echo "checked"; ?> >
		</td>
		<td valign="top">
			4&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<u><?php xl("Unable","e");?></u><?php xl(" to answer the telephone at all but can listen if assisted with equipment.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_use_telephone" value="5" <?php if($obj{"adl_iadl_use_telephone"}=="5") echo "checked"; ?> >
		</td>
		<td valign="middle">
			5&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Totally unable to use the telephone.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_use_telephone" value="NA" <?php if($obj{"adl_iadl_use_telephone"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient does not have a telephone.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1900)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Prior Functioning ADL/IADL: ","e");?></strong><?php xl(" Indicate the patient's usual ability with everyday activities prior to this current illness, exacerbation, or injury. Check only ","e");?><u><strong><?php xl("one","e");?></strong></u><?php xl(" box in each row.","e");?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<table width="100%" class="formtable" border="1px">
				<tr>
					<td colspan="2">
						<strong><?php xl("Functional Area","e");?></strong>
					</td>
					<td>
						<strong><?php xl("Independent","e");?></strong>
					</td>
					<td>
						<strong><?php xl("Needed Some Help","e");?></strong>
					</td>
					<td>
						<strong><?php xl("Dependent","e");?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("a.","e");?>
					</td>
					<td>
						<?php xl("Self-Care (e.g., grooming, dressing, and bathing)","e");?>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_selfcare" value="<?php xl("Independent","e");?>" <?php if($obj{"adl_iadl_functioning_selfcare"}=="Independent") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_selfcare" value="<?php xl("Needed Some Help","e");?>" <?php if($obj{"adl_iadl_functioning_selfcare"}=="Needed Some Help") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_selfcare" value="<?php xl("Dependent","e");?>" <?php if($obj{"adl_iadl_functioning_selfcare"}=="Dependent") echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("b.","e");?>
					</td>
					<td>
						<?php xl("Ambulation","e");?>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_ambulation" value="<?php xl("Independent","e");?>" <?php if($obj{"adl_iadl_functioning_ambulation"}=="Independent") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_ambulation" value="<?php xl("Needed Some Help","e");?>" <?php if($obj{"adl_iadl_functioning_ambulation"}=="Needed Some Help") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_ambulation" value="<?php xl("Dependent","e");?>" <?php if($obj{"adl_iadl_functioning_ambulation"}=="Dependent") echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("c.","e");?>
					</td>
					<td>
						<?php xl("Transfer","e");?>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_transfer" value="<?php xl("Independent","e");?>" <?php if($obj{"adl_iadl_functioning_transfer"}=="Independent") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_transfer" value="<?php xl("Needed Some Help","e");?>" <?php if($obj{"adl_iadl_functioning_transfer"}=="Needed Some Help") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_transfer" value="<?php xl("Dependent","e");?>" <?php if($obj{"adl_iadl_functioning_transfer"}=="Dependent") echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("d.","e");?>
					</td>
					<td>
						<?php xl("Household tasks (e.g., light meal preparation, laundry, shopping )","e");?>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_household" value="<?php xl("Independent","e");?>" <?php if($obj{"adl_iadl_functioning_household"}=="Independent") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_household" value="<?php xl("Needed Some Help","e");?>" <?php if($obj{"adl_iadl_functioning_household"}=="Needed Some Help") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="adl_iadl_functioning_household" value="<?php xl("Dependent","e");?>" <?php if($obj{"adl_iadl_functioning_household"}=="Dependent") echo "checked"; ?> ></label>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M1910)</strong>
		</td>
		<td valign="middle" colspan="6">
			<?php xl("Has this patient had a multi-factor ","e");?><strong><?php xl(" Fall Risk Assessment ","e");?></strong><?php xl(" (such as falls history, use of multiple medications, mental impairment, toileting frequency, general mobility/transferring impairment, environmental hazards)?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_risk_assessment" value="0" <?php if($obj{"adl_iadl_risk_assessment"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No multi-factor falls risk assessment conducted.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_risk_assessment" value="1" <?php if($obj{"adl_iadl_risk_assessment"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, and it does not indicate a risk for falls.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="adl_iadl_risk_assessment" value="2" <?php if($obj{"adl_iadl_risk_assessment"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes, and it indicates a risk for falls.","e");?>
		</td>
	</tr>
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Medications</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table class="formtable">
	<tr>
		<td valign="top">
			<strong>(M2000)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Drug Regimen Review: ","e");?></strong><?php xl(" Does a complete drug regimen review indicate potential clinically significant medication issues, e.g., drug reactions, ineffective drug therapy, side effects, drug interactions, duplicate therapy, omissions, dosage errors, or noncompliance?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_review" value="0" <?php if($obj{"medications_drug_review"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Not assessed/reviewed","e");?><strong><i>[Go to M2010]</i></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_review" value="1" <?php if($obj{"medications_drug_review"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No problems found during review","e");?><strong><i>[Go to M2010]</i></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_review" value="2" <?php if($obj{"medications_drug_review"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Problems found during review","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_review" value="NA" <?php if($obj{"medications_drug_review"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient is not taking any medications","e");?><strong><i>[ Go to M2040 ]</i></strong>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M2002)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Medication Follow-up: ","e");?></strong><?php xl(" Was a physician or the physician-designee contacted within one calendar day to resolve clinically significant medication issues, including reconciliation?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_follow_up" value="0" <?php if($obj{"medications_follow_up"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_follow_up" value="1" <?php if($obj{"medications_follow_up"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M2004)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Medication Intervention: ","e");?></strong><?php xl(" If there were any clinically significant medication issues since the previous OASIS assessment, was a physician or the physician-designee contacted within one calendar day of the assessment to resolve clinically significant medication issues, including reconciliation?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_intervention" value="0" <?php if($obj{"medications_intervention"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_intervention" value="1" <?php if($obj{"medications_intervention"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_intervention" value="NA" <?php if($obj{"medications_intervention"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No clinically significant medication issues identified since the previous OASIS assessment","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M2010)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Patient/Caregiver High Risk Drug Education: ","e");?></strong><?php xl(" Has the patient/caregiver received instruction on special precautions for all high-risk medications (such as hypoglycemics, anticoagulants, etc.) and how and when to report problems that may occur?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_education" value="0" <?php if($obj{"medications_drug_education"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_education" value="1" <?php if($obj{"medications_drug_education"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="medications_drug_education" value="NA" <?php if($obj{"medications_drug_education"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="top">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient not taking any high risk drugs OR patient/caregiver fully knowledgeable about special precautions associated with all high-risk medications","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M2015)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Patient/Caregiver Drug Education Intervention: ","e");?></strong><?php xl(" Since the previous OASIS assessment, was the patient/caregiver instructed by agency staff or other health care provider to monitor the effectiveness of drug therapy, drug reactions, and side effects, and how and when to report problems that may occur?","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_education_intervention" value="0" <?php if($obj{"medications_drug_education_intervention"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_education_intervention" value="1" <?php if($obj{"medications_drug_education_intervention"}=="1") echo "checked"; ?> >
		</td>
		<td valign="middle">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Yes","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_drug_education_intervention" value="NA" <?php if($obj{"medications_drug_education_intervention"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Patient not taking any drugs","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M2020)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Management of Oral Medications: ","e");?></strong><u><?php xl(" Patient's current ability","e");?></u><?php xl(" to prepare and take all oral medications reliably and safely, including administration of the correct dosage at the appropriate times/intervals.","e");?><strong><u><?php xl(" Excludes","e");?></u><?php xl(" injectable and IV medications. (NOTE: This refers to ability, not compliance or willingness.)","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_management_oral" value="0" <?php if($obj{"medications_management_oral"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to independently take the correct oral medication(s) and proper dosage(s) at the correct times.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="medications_management_oral" value="1" <?php if($obj{"medications_management_oral"}=="1") echo "checked"; ?> >
		</td>
		<td valign="top">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to take medication(s) at the correct times if:","e");?><br>
			<?php xl("(a) individual dosages are prepared in advance by another person; ","e");?><u><?php xl("OR","e");?></u><br>
			<?php xl("(b) another person develops a drug diary or chart.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_management_oral" value="2" <?php if($obj{"medications_management_oral"}=="2") echo "checked"; ?> >
		</td>
		<td valign="middle">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to take medication(s) at the correct times if given reminders by another person at the appropriate times.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_management_oral" value="3" <?php if($obj{"medications_management_oral"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<u><?php xl("Unable","e");?></u><?php xl(" to take medication unless administered by another person.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_management_oral" value="NA" <?php if($obj{"medications_management_oral"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No oral medications prescribed.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<strong>(M2030)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Management of Injectable Medications: ","e");?></strong><u><?php xl(" Patient's current ability","e");?></u><?php xl(" to prepare and take all prescribed injectable medications reliably and safely, including administration of correct dosage at the appropriate times/intervals. ","e");?><strong><u><?php xl(" Excludes","e");?></u><?php xl(" IV medications.","e");?></strong>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_management_injectable" value="0" <?php if($obj{"medications_management_injectable"}=="0") echo "checked"; ?> >
		</td>
		<td valign="middle">
			0&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to independently take the correct medication(s) and proper dosage(s) at the correct times.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="medications_management_injectable" value="1" <?php if($obj{"medications_management_injectable"}=="1") echo "checked"; ?> >
		</td>
		<td valign="top">
			1&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to take injectable medication(s) at the correct times if:","e");?><br>
			<?php xl("(a) individual syringes are prepared in advance by another person; ","e");?><u><?php xl("OR","e");?></u><br>
			<?php xl("(b) another person develops a drug diary or chart.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
			<input type="checkbox" name="medications_management_injectable" value="2" <?php if($obj{"medications_management_injectable"}=="2") echo "checked"; ?> >
		</td>
		<td valign="top">
			2&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("Able to take medication(s) at the correct times if given reminders by another person based on the frequency of the injection","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_management_injectable" value="3" <?php if($obj{"medications_management_injectable"}=="3") echo "checked"; ?> >
		</td>
		<td valign="middle">
			3&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<u><?php xl("Unable","e");?></u><?php xl(" to take injectable medication unless administered by another person.","e");?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right">
			<input type="checkbox" name="medications_management_injectable" value="NA" <?php if($obj{"medications_management_injectable"}=="NA") echo "checked"; ?> >
		</td>
		<td valign="middle">
			NA&nbsp;&nbsp;-&nbsp;
		</td>
		<td valign="middle">
			<?php xl("No injectable medications prescribed.","e");?>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<strong>(M2040)</strong>
		</td>
		<td valign="middle" colspan="6">
			<strong><?php xl("Prior Medication Management: ","e");?></strong><?php xl(" Indicate the patient's usual ability with managing oral and injectable medications prior to this current illness, exacerbation, or injury. Check only ","e");?><strong><u><?php xl("one","e");?></u></strong><?php xl(" box in each row.","e");?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<table width="100%" class="formtable" border="1px">
				<tr>
					<td colspan="2">
						<strong><?php xl("Functional Area","e");?></strong>
					</td>
					<td>
						<strong><?php xl("Independent","e");?></strong>
					</td>
					<td>
						<strong><?php xl("Needed Some Help","e");?></strong>
					</td>
					<td>
						<strong><?php xl("Dependent","e");?></strong>
					</td>
					<td>
						<strong><?php xl("Not Applicable","e");?></strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("a.","e");?>
					</td>
					<td>
						<?php xl("Oral medications","e");?>
					</td>
					<td>
						<label><input type="checkbox" name="medications_prior_management_oral" value="<?php xl("Independent","e");?>" <?php if($obj{"medications_prior_management_oral"}=="Independent") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="medications_prior_management_oral" value="<?php xl("Needed Some Help","e");?>" <?php if($obj{"medications_prior_management_oral"}=="Needed Some Help") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="medications_prior_management_oral" value="<?php xl("Dependent","e");?>" <?php if($obj{"medications_prior_management_oral"}=="Dependent") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="medications_prior_management_oral" value="<?php xl("Not Applicable","e");?>" <?php if($obj{"medications_prior_management_oral"}=="Not Applicable") echo "checked"; ?> ></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php xl("b.","e");?>
					</td>
					<td>
						<?php xl("Injectable medications","e");?>
					</td>
					<td>
						<label><input type="checkbox" name="medications_prior_management_injectable" value="<?php xl("Independent","e");?>" <?php if($obj{"medications_prior_management_injectable"}=="Independent") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="medications_prior_management_injectable" value="<?php xl("Needed Some Help","e");?>" <?php if($obj{"medications_prior_management_injectable"}=="Needed Some Help") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="medications_prior_management_injectable" value="<?php xl("Dependent","e");?>" <?php if($obj{"medications_prior_management_injectable"}=="Dependent") echo "checked"; ?> ></label>
					</td>
					<td>
						<label><input type="checkbox" name="medications_prior_management_injectable" value="<?php xl("Not Applicable","e");?>" <?php if($obj{"medications_prior_management_injectable"}=="Not Applicable") echo "checked"; ?> ></label>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Care Management</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table cellpadding="5" cellspacing="0" class="formtable">
<tr><td valign="top"><strong><?php xl("(M2100)","e");?></strong> </td>
<td><strong><?php xl("Types and Sources of Assistance:","e");?></strong> <?php xl(" Determine the level of caregiver ability and willingness to provide assistance for the following activities, if assistance is needed. (Check only ","e");?><strong><u><?php xl("one","e");?></u></strong><?php xl(" box in each row.)","e");?><br />
<br>
<table align="left" border="1" cellpadding="0" cellspacing="0" width="751" class="formtable">
			<tbody>
				<tr>
					<td style="width: 206px; height: 41px;">
						<p align="center">
							<?php xl("Needing assistance = patient needs assistance on any item on the &ldquo;e.g.&rdquo; list","e");?></p>
					</td>
					<td style="width: 91px; height: 41px;">
						<p align="center">
							<?php xl("No assistance needed in this area","e");?></p>
					</td>
					<td style="width: 91px; height: 41px;">
						<p align="center">
							<?php xl("Caregiver(s) currently provides assistance","e");?></p>
					</td>
					<td style="width: 91px; height: 41px;">
						<p align="center">
							<?php xl("Caregiver(s) need training/ supportive services to provide assistance","e");?></p>
					</td>
					<td style="width: 91px; height: 41px;">
						<p align="center">
							<?php xl("Caregiver(s) ","e");?><u><?php xl("not likely","e");?></u><?php xl(" to provide assistance","e");?></p>
					</td>
					<td style="width: 91px; height: 41px;">
						<p align="center">
							<?php xl("Unclear if Caregiver(s) will provide assistance","e");?></p>
					</td>
					<td style="width: 91px; height: 41px;">
						<p align="center">
							<?php xl("Assistance needed, but no Caregiver(s) available","e");?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 206px; height: 36px;">
						<p>
							<?php xl("a.","e");?> <strong><?php xl("ADL assistance","e");?> </strong><?php xl("(e.g., transfer/ ambulation, bathing, dressing, toileting, eating/feeding)","e");?></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance1" id="OASIS_receive_ADL_IADL_assistance1" value="No assistance needed in this area" <?php if(in_array("No assistance needed in this area",$ADL_assistance1)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance1" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) currently provides assistance"  <?php if(in_array("Caregiver(s) currently provides assistance",$ADL_assistance1)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance1" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) need training/ supportive services to provide assistance" <?php if(in_array("Caregiver(s) need training/ supportive services to provide assistance",$ADL_assistance1)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance1" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) not likely to provide assistance" <?php if(in_array("Caregiver(s) not likely to provide assistance",$ADL_assistance1)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance1" id="OASIS_receive_ADL_IADL_assistance1" value="Unclear if Caregiver(s) will provide assistance" <?php if(in_array("Unclear if Caregiver(s) will provide assistance",$ADL_assistance1)) { echo "checked"; };?> ></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance1" id="OASIS_receive_ADL_IADL_assistance1" value="Assistance needed, but no Caregiver(s) available" <?php if(in_array("Assistance needed, but no Caregiver(s) available",$ADL_assistance1)) { echo "checked"; };?> /></p>
					</td>
				</tr>
				<tr>
					<td style="width: 206px; height: 36px;">
						<p>
							<?php xl("b.","e");?> <strong><?php xl("IADL assistance","e");?> </strong><?php xl("(e.g., meals, housekeeping, laundry, telephone, shopping, finances)","e");?></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance12" id="OASIS_receive_ADL_IADL_assistance1" value="No assistance needed in this area" <?php if(in_array("No assistance needed in this area",$ADL_assistance12)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance12" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) currently provides assistance" <?php if(in_array("Caregiver(s) currently provides assistance",$ADL_assistance12)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance12" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) need training/ supportive services to provide assistance" <?php if(in_array("Caregiver(s) need training/ supportive services to provide assistance",$ADL_assistance12)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance12" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) not likely to provide assistance" <?php if(in_array("Caregiver(s) not likely to provide assistance",$ADL_assistance12)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance12" id="OASIS_receive_ADL_IADL_assistance1" value="Unclear if Caregiver(s) will provide assistance" <?php if(in_array("Unclear if Caregiver(s) will provide assistance",$ADL_assistance12)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 36px;">
						<p align="center">
							<input type="checkbox" name="ADL_assistance12" id="OASIS_receive_ADL_IADL_assistance1" value="Assistance needed, but no Caregiver(s) available" <?php if(in_array("Assistance needed, but no Caregiver(s) available",$ADL_assistance12)) { echo "checked"; };?> /></p>
					</td>
				</tr>
				<tr>
					<td style="width: 206px; height: 29px;">
						<p>
							<?php xl("c.","e");?> <strong><?php xl("Medication administration","e");?> </strong><?php xl("(e.g., oral, inhaled or injectable)","e");?></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medication_administration" id="OASIS_receive_ADL_IADL_assistance1" value="No assistance needed in this area" <?php if(in_array("No assistance needed in this area",$Medication_administration)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medication_administration" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) currently provides assistance" <?php if(in_array("Caregiver(s) currently provides assistance",$Medication_administration)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medication_administration" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) need training/ supportive services to provide assistance" <?php if(in_array("Caregiver(s) need training/ supportive services to provide assistance",$Medication_administration)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medication_administration" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) not likely to provide assistance" <?php if(in_array("Caregiver(s) not likely to provide assistance",$Medication_administration)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medication_administration" id="OASIS_receive_ADL_IADL_assistance1" value="Unclear if Caregiver(s) will provide assistance" <?php if(in_array("Unclear if Caregiver(s) will provide assistance",$Medication_administration)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medication_administration" id="OASIS_receive_ADL_IADL_assistance1" value="Assistance needed, but no Caregiver(s) available" <?php if(in_array("Assistance needed, but no Caregiver(s) available",$Medication_administration)) { echo "checked"; };?> /></p>
					</td>
				</tr>
				<tr>
					<td style="width: 206px; height: 29px;">
						<p>
							<?php xl("d.","e");?> <strong><?php xl("Medical procedures/ treatments","e");?> </strong><?php xl("(e.g., changing wound dressing)","e");?></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medical_procedures_treatments" id="OASIS_receive_ADL_IADL_assistance1" value="No assistance needed in this area" <?php if(in_array("No assistance needed in this area",$Medical_procedures_treatments)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medical_procedures_treatments" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) currently provides assistance" <?php if(in_array("Caregiver(s) currently provides assistance",$Medical_procedures_treatments)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medical_procedures_treatments" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) need training/ supportive services to provide assistance" <?php if(in_array("Caregiver(s) need training/ supportive services to provide assistance",$Medical_procedures_treatments)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medical_procedures_treatments" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) not likely to provide assistance" <?php if(in_array("Caregiver(s) not likely to provide assistance",$Medical_procedures_treatments)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medical_procedures_treatments" id="OASIS_receive_ADL_IADL_assistance1" value="Unclear if Caregiver(s) will provide assistance" <?php if(in_array("Unclear if Caregiver(s) will provide assistance",$Medical_procedures_treatments)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Medical_procedures_treatments" id="OASIS_receive_ADL_IADL_assistance1" value="Assistance needed, but no Caregiver(s) available" <?php if(in_array("Assistance needed, but no Caregiver(s) available",$Medical_procedures_treatments)) { echo "checked"; };?> /></p>
					</td>
				</tr>
				<tr>
					<td style="width: 206px; height: 56px;">
						<p>
							<?php xl("e.","e");?> <strong><?php xl("Management of Equipment","e");?> </strong><?php xl("(includes oxygen, IV/infusion equipment, enteral/ parenteral nutrition, ventilator therapy equipment or supplies)","e");?></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Management_of_Equipment" id="OASIS_receive_ADL_IADL_assistance1" value="No assistance needed in this area" <?php if(in_array("No assistance needed in this area",$Management_of_Equipment)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Management_of_Equipment" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) currently provides assistance" <?php if(in_array("Caregiver(s) currently provides assistance",$Management_of_Equipment)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Management_of_Equipment" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) need training/ supportive services to provide assistance" <?php if(in_array("Caregiver(s) need training/ supportive services to provide assistance",$Management_of_Equipment)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Management_of_Equipment" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) not likely to provide assistance" <?php if(in_array("Caregiver(s) not likely to provide assistance",$Management_of_Equipment)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Management_of_Equipment" id="OASIS_receive_ADL_IADL_assistance1" value="Unclear if Caregiver(s) will provide assistance" <?php if(in_array("Unclear if Caregiver(s) will provide assistance",$Management_of_Equipment)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Management_of_Equipment" id="OASIS_receive_ADL_IADL_assistance1" value="Assistance needed, but no Caregiver(s) available" <?php if(in_array("Assistance needed, but no Caregiver(s) available",$Management_of_Equipment)) { echo "checked"; };?> /></p>
					</td>
				</tr>
				<tr>
					<td style="width: 206px; height: 22px;">
						<p>
							<?php xl("f.","e");?> <strong><?php xl("Supervision and safety","e");?> </strong><?php xl("(e.g., due to cognitive impairment)","e");?></p>
					</td>
					<td style="width: 91px; height: 22px;">
						<p align="center">
							<input type="checkbox" name="Supervision_and_safety" id="OASIS_receive_ADL_IADL_assistance1" value="No assistance needed in this area" <?php if(in_array("No assistance needed in this area",$Supervision_and_safety)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 22px;">
						<p align="center">
							<input type="checkbox" name="Supervision_and_safety" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) currently provides assistance" <?php if(in_array("Caregiver(s) currently provides assistance",$Supervision_and_safety)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 22px;">
						<p align="center">
							<input type="checkbox" name="Supervision_and_safety" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) need training/ supportive services to provide assistance" <?php if(in_array("Caregiver(s) need training/ supportive services to provide assistance",$Supervision_and_safety)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 22px;">
						<p align="center">
							<input type="checkbox" name="Supervision_and_safety" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) not likely to provide assistance" <?php if(in_array("Caregiver(s) not likely to provide assistance",$Supervision_and_safety)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 22px;">
						<p align="center">
							<input type="checkbox" name="Supervision_and_safety" id="OASIS_receive_ADL_IADL_assistance1" value="Unclear if Caregiver(s) will provide assistance" <?php if(in_array("Unclear if Caregiver(s) will provide assistance",$Supervision_and_safety)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 22px;">
						<p align="center">
							<input type="checkbox" name="Supervision_and_safety" id="OASIS_receive_ADL_IADL_assistance1" value="Assistance needed, but no Caregiver(s) available" <?php if(in_array("Assistance needed, but no Caregiver(s) available",$Supervision_and_safety)) { echo "checked"; };?> /></p>
					</td>
				</tr>
				<tr>
					<td style="width: 206px; height: 56px;">
						<p>
							<?php xl("g.","e");?> <strong><?php xl("Advocacy or facilitation","e");?> </strong><?php xl("of patients participation in appropriate medical care (includes transporta-tion to or from appointments)","e");?></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Advocacy_or_facilitation" id="OASIS_receive_ADL_IADL_assistance1" value="No assistance needed in this area"  <?php if(in_array("No assistance needed in this area",$Advocacy_or_facilitation)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Advocacy_or_facilitation" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) currently provides assistance" <?php if(in_array("Caregiver(s) currently provides assistance",$Advocacy_or_facilitation)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Advocacy_or_facilitation" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) need training/ supportive services to provide assistance" <?php if(in_array("Caregiver(s) need training/ supportive services to provide assistance",$Advocacy_or_facilitation)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Advocacy_or_facilitation" id="OASIS_receive_ADL_IADL_assistance1" value="Caregiver(s) not likely to provide assistance" <?php if(in_array("Caregiver(s) not likely to provide assistance",$Advocacy_or_facilitation)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Advocacy_or_facilitation" id="OASIS_receive_ADL_IADL_assistance1" value="Unclear if Caregiver(s) will provide assistance" <?php if(in_array("Unclear if Caregiver(s) will provide assistance",$Advocacy_or_facilitation)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 91px; height: 56px;">
						<p align="center">
							<input type="checkbox" name="Advocacy_or_facilitation" id="OASIS_receive_ADL_IADL_assistance1" value="Assistance needed, but no Caregiver(s) available" <?php if(in_array("Assistance needed, but no Caregiver(s) available",$Advocacy_or_facilitation)) { echo "checked"; };?> /></p>
					</td>
				</tr>
			</tbody>
		</table>
</td></tr>
	<tr>
		<td valign="top">
		<strong><?php xl("(M2110)","e");?></strong>
		</td>
		<td><strong><?php xl("How Often","e");?></strong> <?php xl(" does the patient receive ","e");?><strong> <?php xl("ADL or IADL assistance","e");?></strong> <?php xl(" from any caregiver(s) (other than home health agency staff)?","e");?><br>
			<input type="checkbox" name="OASIS_C_receive_ADL_IADL_assistance" id="OASIS_receive_ADL_IADL_assistance1" value="At least daily" <?php if(in_array("At least daily",$OASIS_C_receive_ADL_IADL_assistance)) { echo "checked"; };?> /> <?php xl("1 - At least daily","e");?><br>
			<input type="checkbox" name="OASIS_C_receive_ADL_IADL_assistance" id="OASIS_receive_ADL_IADL_assistance2" value="Three or more times per week" <?php if(in_array("Three or more times per week",$OASIS_C_receive_ADL_IADL_assistance)) { echo "checked"; };?> /> <?php xl("2 - Three or more times per week","e");?><br>
			<input type="checkbox" name="OASIS_C_receive_ADL_IADL_assistance" id="OASIS_receive_ADL_IADL_assistance3" value="One to two times per week" <?php if(in_array("One to two times per week",$OASIS_C_receive_ADL_IADL_assistance)) { echo "checked"; };?> /> <?php xl("3 - One to two times per week","e");?><br>
			<input type="checkbox" name="OASIS_C_receive_ADL_IADL_assistance" id="OASIS_receive_ADL_IADL_assistance4" value="Received, but less often than weekly" <?php if(in_array("Received, but less often than weekly",$OASIS_C_receive_ADL_IADL_assistance)) { echo "checked"; };?> /> <?php xl("4 - Received, but less often than weekly","e");?><br>
			<input type="checkbox" name="OASIS_C_receive_ADL_IADL_assistance" id="OASIS_receive_ADL_IADL_assistance5" value="No assistance received" <?php if(in_array("No assistance received",$OASIS_C_receive_ADL_IADL_assistance)) { echo "checked"; };?> /> <?php xl("5 - No assistance received","e");?><br>
			<input type="checkbox" name="OASIS_C_receive_ADL_IADL_assistance" id="OASIS_receive_ADL_IADL_assistance6" value="UK - Unknown" <?php if(in_array("UK - Unknown",$OASIS_C_receive_ADL_IADL_assistance)) { echo "checked"; };?> /> <?php xl("UK - Unknown*","e");?> <br />
			<?php xl("*at discharge, omit Unknown response.","e");?>
		</td>
	</tr>
		</table>

                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Therapy need and plan of care</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table cellpadding="5" cellspacing="0" class="formtable">
<tr><td valign="top"><strong><?php xl('(M2200)','e')?></strong></td><td><strong><?php xl("Therapy Need:","e");?></strong> <?php xl(' In the home health plan of care for the Medicare payment episode for which this assessment will define a case mix group, what is the indicated need for therapy visits (total of reasonable and necessary physical, occupational, and speech-language pathology visits combined)? ','e');?><strong> <?php xl('(Enter zero [ "000" ] if no therapy visits indicated.)','e')?></strong>  <br />
<input type="text" name="OASIS_C_Therapy_Need" id="Therapy_Need" value="<?php echo $OASIS_C_Therapy_Need[0]; ?>" > <?php xl('Number of therapy visits indicated (total of physical, occupational and speech-language pathology combined).','e')?><br />
<input type="checkbox" name="OASIS_C_Therapy_Need_other" id="Therapy_Need_other" value="NA - Not Applicable" <?php if(in_array("NA - Not Applicable",$OASIS_C_Therapy_Need_other)) { echo "checked"; };?> /> <?php xl('NA - Not Applicable: No case mix group defined by this assessment.','e')?>
</td></tr>

<tr><td valign="top"> <strong><?php xl('(M2250)','e')?> </strong></td>
<td> <strong><?php xl("Plan of Care Synopsis:","e");?></strong><?php xl(" (Check only ","e");?><strong><u><?php xl("one","e");?></u></strong><?php xl(' box in each row.) Does the physician-ordered plan of care include the following:','e')?><br />

<table align="left" border="1" cellpadding="0" cellspacing="0" width="715" class="formtable">
			<tbody>
				<tr>
					<td style="width: 229px; height: 8px;">
						<p align="center">
							<strong><?php xl('Plan / Intervention','e')?> </strong></p>
					</td>
					<td style="width: 5%; height: 8px;">
						<p align="center">
							<strong><?php xl('No','e')?> </strong></p>
					</td>
					<td style="width: 5%; height: 8px;">
						<p align="center">
							<strong><?php xl('Yes','e')?> </strong></p>
					</td>
					<td colspan="2" style="width: 243px; height: 8px;">
						<p align="left">
							<strong><?php xl('Not Applicable','e')?> </strong></p>
					</td>
				</tr>
				<tr>
					<td style="width: 229px; height: 42px;">
						<p align="left">
							<?php xl('a. Patient-specific parameters for notifying physician of changes in vital signs or other clinical findings','e')?></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="parameters_for_notifying_physician_of_changes_in_vital_signs" value="No" <?php if(in_array("No",$parameters_for_notifying_physician_of_changes_in_vital_signs)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="parameters_for_notifying_physician_of_changes_in_vital_signs" value="Yes" <?php if(in_array("Yes",$parameters_for_notifying_physician_of_changes_in_vital_signs)) { echo "checked"; };?> /></p>
					</td>
					<td style="width:5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="parameters_for_notifying_physician_of_changes_in_vital_signs" value="Not Applicable" <?php if(in_array("Not Applicable",$parameters_for_notifying_physician_of_changes_in_vital_signs)) { echo "checked"; };?> /></p>
					</td>
					<td style="height: 42px;">
						<p align="left">
							<?php xl('Physician has chosen not to establish patient-specific parameters for this patient. Agency will use standardized clinical guidelines accessible for all care providers to reference','e')?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 229px; height: 29px;">
						<p align="left">
							<?php xl('b. Diabetic foot care including monitoring for the presence of skin lesions on the lower extremities and patient/caregiver education on proper foot care','e')?></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="presence_of_skin_lesions_on_the_lower_extremities1" value="No" <?php if(in_array("No",$presence_of_skin_lesions_on_the_lower_extremities1)) { echo "checked"; };?> /></p>
					</td>
					<td style="width:5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="presence_of_skin_lesions_on_the_lower_extremities1" value="Yes" <?php if(in_array("Yes",$presence_of_skin_lesions_on_the_lower_extremities1)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="presence_of_skin_lesions_on_the_lower_extremities1" value="Not Applicable" <?php if(in_array("Not Applicable",$presence_of_skin_lesions_on_the_lower_extremities1)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 29px;">
						<p align="left">
							<?php xl('Patient is not diabetic or is bilateral amputee','e')?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 229px; height: 15px;">
						<p align="left">
							<?php xl('c. Falls prevention interventions','e')?></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Falls_prevention_interventions1" value="No" <?php if(in_array("No",$Falls_prevention_interventions1)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Falls_prevention_interventions1" value="Yes" <?php if(in_array("Yes",$Falls_prevention_interventions1)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Falls_prevention_interventions1" value="Not Applicable" <?php if(in_array("Not Applicable",$Falls_prevention_interventions1)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 15px;">
						<p align="left">
							<?php xl('Patient is not assessed to be at risk for falls','e')?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 229px; height: 22px;">
						<p align="left">
							<?php xl('d. Depression intervention(s) such as medication, referral for other treatment, or a monitoring plan for current treatment','e')?></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Depression_interventions_such_as_medication_referral" value="No" <?php if(in_array("No",$Depression_interventions_such_as_medication_referral)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Depression_interventions_such_as_medication_referral" value="Yes" <?php if(in_array("Yes",$Depression_interventions_such_as_medication_referral)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Depression_interventions_such_as_medication_referral" value="Not Applicable" <?php if(in_array("Not Applicable",$Depression_interventions_such_as_medication_referral)) { echo "checked"; };?> ></p>
					</td>
					<td style=" height: 22px;">
						<p align="left">
							<?php xl('Patient has no diagnosis or symptoms of depression','e')?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 229px; height: 11px;">
						<p align="left">
							<?php xl('e. Intervention(s) to monitor and mitigate pain','e')?></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Interventions_to_monitor_and_mitigate" value="No" <?php if(in_array("No",$Interventions_to_monitor_and_mitigate)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Interventions_to_monitor_and_mitigate" value="Yes" <?php if(in_array("Yes",$Interventions_to_monitor_and_mitigate)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Interventions_to_monitor_and_mitigate" value="Not Applicable" <?php if(in_array("Not Applicable",$Interventions_to_monitor_and_mitigate)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 11px;">
						<p align="left">
							<?php xl('No pain identified','e')?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 229px; height: 15px;">
						<p align="left">
							<?php xl('f. Intervention(s) to prevent pressure ulcers','e')?></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Interventions_to_prevent_pressure_ulcers" value="No" <?php if(in_array("No",$Interventions_to_prevent_pressure_ulcers)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Interventions_to_prevent_pressure_ulcers" value="Yes" <?php if(in_array("Yes",$Interventions_to_prevent_pressure_ulcers)) { echo "checked"; };?> ></p>
					</td>
					<td style="width:5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="Interventions_to_prevent_pressure_ulcers" value="Not Applicable" <?php if(in_array("Not Applicable",$Interventions_to_prevent_pressure_ulcers)) { echo "checked"; };?> /></p>
					</td>
					<td style="height: 15px;">
						<p align="left">
							<?php xl('Patient is not assessed to be at risk for pressure ulcers','e')?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 229px; height: 29px;">
						<p align="left">
							<?php xl('g. Pressure ulcer treatment based on principles of moist wound healing OR order for treatment based on moist wound healing has been requested from physician','e')?></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="treatment_based_on_moist_wound_healing" value="No" <?php if(in_array("No",$treatment_based_on_moist_wound_healing)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="treatment_based_on_moist_wound_healing" value="Yes" <?php if(in_array("Yes",$treatment_based_on_moist_wound_healing)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 42px;">
						<p align="center">
							<input type="checkbox" name="treatment_based_on_moist_wound_healing" value="Not Applicable" <?php if(in_array("Not Applicable",$treatment_based_on_moist_wound_healing)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 29px;">
						<p align="left">
							<?php xl('Patient has no pressure ulcers with need for moist wound healing','e')?></p>
					</td>
				</tr>
			</tbody>
		</table>
				</td>
	</tr>
		</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Emergent Care</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table cellpadding="5" cellspacing="0" class="formtable">
<tr>
<td valign="top"><strong><?php xl('(M2300)','e')?></strong></td>
<td><strong><?php xl('Emergent Care:','e');?></strong><?php xl(' Since the last time OASIS data were collected, has the patient utilized a hospital emergency department (includes holding/observation)?','e')?><br>
<input type="checkbox" name="OASIS_C_emergent_Care_since_last_time_oasis" value="No" <?php if(in_array("No",$OASIS_C_emergent_Care_since_last_time_oasis)) { echo "checked"; };?> /> <?php xl('0 - No ','e');?><strong><i><?php xl('[ Go to M2400 ]','e')?></i></strong><br>
<input type="checkbox" name="OASIS_C_emergent_Care_since_last_time_oasis" value="Yes, used hospital emergency department WITHOUT hospital admission" <?php if(in_array("Yes, used hospital emergency department WITHOUT hospital admission",$OASIS_C_emergent_Care_since_last_time_oasis)) { echo "checked"; };?> /> <?php xl('1 - Yes, used hospital emergency department WITHOUT hospital admission','e')?><br>
<input type="checkbox" name="OASIS_C_emergent_Care_since_last_time_oasis" value="Yes, used hospital emergency department WITH hospital admission" <?php if(in_array("Yes, used hospital emergency department WITH hospital admission",$OASIS_C_emergent_Care_since_last_time_oasis)) { echo "checked"; };?> /> <?php xl('2 - Yes, used hospital emergency department WITH hospital admission','e')?><br>
<input type="checkbox" name="OASIS_C_emergent_Care_since_last_time_oasis" value="UK - Unknown" <?php if(in_array("UK - Unknown",$OASIS_C_emergent_Care_since_last_time_oasis)) { echo "checked"; };?> /> <?php xl('UK - Unknown ','e');?><strong><i><?php xl('[ Go to M2400 ]','e')?></i></strong>
</td>
</tr>
<tr>
<td valign="top"><strong><?php xl('(M2310)','e')?></strong></td>
<td><strong><?php xl('Reason for Emergent Care:','e');?></strong><?php xl(' For what reason(s) did the patient receive emergent care (with or without hospitalization)? ','e');?><strong><?php xl('(Mark all that apply.)','e')?></strong><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Improper medication administration, medication side effects, toxicity, anaphylaxis" <?php if(in_array("Improper medication administration, medication side effects, toxicity, anaphylaxis",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('1 - Improper medication administration, medication side effects, toxicity, anaphylaxis','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Injury caused by fall" <?php if(in_array("Injury caused by fall",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('2 - Injury caused by fall','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Respiratory infection (e.g., pneumonia, bronchitis)" <?php if(in_array("Respiratory infection (e.g., pneumonia, bronchitis)",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('3 - Respiratory infection (e.g., pneumonia, bronchitis)','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Other respiratory problem" <?php if(in_array("Other respiratory problem",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('4 - Other respiratory problem','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Heart failure (e.g., fluid overload)" <?php if(in_array("Heart failure (e.g., fluid overload)",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('5 - Heart failure (e.g., fluid overload)','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Cardiac dysrhythmia (irregular heartbeat)" <?php if(in_array("Cardiac dysrhythmia (irregular heartbeat)",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('6 - Cardiac dysrhythmia (irregular heartbeat)','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Myocardial infarction or chest pain" <?php if(in_array("Myocardial infarction or chest pain",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('7 - Myocardial infarction or chest pain','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Other heart disease" <?php if(in_array("Other heart disease",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('8 - Other heart disease','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Stroke (CVA) or TIA" <?php if(in_array("Stroke (CVA) or TIA",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('9 - Stroke (CVA) or TIA','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Hypo/Hyperglycemia, diabetes out of control" <?php if(in_array("Hypo/Hyperglycemia, diabetes out of control",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('10 - Hypo/Hyperglycemia, diabetes out of control','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="GI bleeding, obstruction, constipation, impaction" <?php if(in_array("GI bleeding, obstruction, constipation, impaction",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('11 - GI bleeding, obstruction, constipation, impaction','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Dehydration, malnutrition" <?php if(in_array("Dehydration, malnutrition",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('12 - Dehydration, malnutrition','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Urinary tract infection" <?php if(in_array("Urinary tract infection",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('13 - Urinary tract infection','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="IV catheter-related infection or complication" <?php if(in_array("IV catheter-related infection or complication",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('14 - IV catheter-related infection or complication','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Wound infection or deterioration" <?php if(in_array("Wound infection or deterioration",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('15 - Wound infection or deterioration','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Uncontrolled pain" <?php if(in_array("Uncontrolled pain",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('16 - Uncontrolled pain','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Acute mental/behavioral health problem" <?php if(in_array("Acute mental/behavioral health problem",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('17 - Acute mental/behavioral health problem','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Deep vein thrombosis, pulmonary embolus" <?php if(in_array("Deep vein thrombosis, pulmonary embolus",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('18 - Deep vein thrombosis, pulmonary embolus','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="Other than above reasons" <?php if(in_array("Other than above reasons",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('19 - Other than above reasons','e')?><br>
<input type="checkbox" name="OASIS_C_Reason_for_Emergent_Care[]" value="UK - Reason unknown" <?php if(in_array("UK - Reason unknown",$OASIS_C_Reason_for_Emergent_Care)) { echo "checked"; };?> /> <?php xl('UK - Reason unknown','e')?>
</td>
</tr>
</table>
                        </li>
                    </ul>
                </li>
                <li>
					 <div><a href="#" id="black">Data items collected at inpatient facility admission or Agency discharge only</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
<table cellpadding="5" cellspacing="0" class="formtable">
<tr>
<td valign="top"><strong><?php xl("(M2400)","e");?></strong></td>
<td><strong><?php xl("Intervention Synopsis:","e");?></strong><?php xl(" (Check only ","e");?><strong><u><?php xl("one","e");?></u></strong><?php xl(" box in each row.) Since the previous OASIS assessment, were the following interventions BOTH included in the physician-ordered plan of care AND implemented?","e");?> <br />
<br>
<table border="1" cellpadding="0" cellspacing="0" width="718" class="formtable">
			<tbody>
				<tr>
					<td style="width: 230px; height: 8px;">
						<p align="center">
							<strong><?php xl("Plan / Intervention","e");?> </strong></p>
					</td>
					<td style="width: 5%; height: 8px;">
						<p align="center">
							<strong><?php xl("No","e");?> </strong></p>
					</td>
					<td style="width: 5%; height: 8px;">
						<p align="center">
							<strong><?php xl("Yes","e");?> </strong></p>
					</td>
					<td colspan="2" style="width: 244px; height: 8px;">
						<p>
							<strong><?php xl("Not Applicable","e");?> </strong></p>
					</td>
				</tr>
				<tr>
					<td style="width: 230px; height: 29px;">
						<p>
							<?php xl("a. Diabetic foot care including monitoring for the presence of skin lesions on the lower extremities and patient/caregiver education on proper foot care","e");?></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="presence_of_skin_lesions_on_the_lower_extremities2" value="no" <?php if(in_array("no",$presence_of_skin_lesions_on_the_lower_extremities2)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="presence_of_skin_lesions_on_the_lower_extremities2" value="yes" <?php if(in_array("yes",$presence_of_skin_lesions_on_the_lower_extremities2)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="presence_of_skin_lesions_on_the_lower_extremities2" value="not applicable" <?php if(in_array("not applicable",$presence_of_skin_lesions_on_the_lower_extremities2)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 29px;">
						<p>
							<?php xl("Patient is not diabetic or is bilateral amputee","e");?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 230px; height: 29px;">
						<p>
							<?php xl("b. Falls prevention interventions","e");?></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Falls_prevention_interventions2" value="no" <?php if(in_array("no",$Falls_prevention_interventions2)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Falls_prevention_interventions2" value="yes" <?php if(in_array("yes",$Falls_prevention_interventions2)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Falls_prevention_interventions2" value="not applicable" <?php if(in_array("not applicable",$Falls_prevention_interventions2)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 29px;">
						<p>
							<?php xl("Formal multi-factor Fall Risk Assessment indicates the patient was not at risk for falls since the last OASIS assessment","e");?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 230px; height: 36px;">
						<p>
							<?php xl("c. Depression intervention(s) such as medication, referral for other treatment, or a monitoring plan for current treatment","e");?></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Depression_intervention" value="no" <?php if(in_array("no",$Depression_intervention)) { echo "checked"; };?> /></p>
					</td>
					<td style="width:5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Depression_intervention" value="yes" <?php if(in_array("yes",$Depression_intervention)) { echo "checked"; };?> /></p>
					</td>
					<td style="width:5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Depression_intervention" value="not applicable" <?php if(in_array("not applicable",$Depression_intervention)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 36px;">
						<p>
							<?php xl("Formal assessment indicates patient did not meet criteria for depression AND patient did not have diagnosis of depression since the last OASIS assessment","e");?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 230px; height: 22px;">
						<p>
							<?php xl("d. Intervention(s) to monitor and mitigate pain","e");?></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="intervention_to_monitor_migrate" value="no" <?php if(in_array("no",$intervention_to_monitor_migrate)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="intervention_to_monitor_migrate" value="yes" <?php if(in_array("yes",$intervention_to_monitor_migrate)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="intervention_to_monitor_migrate" value="not applicable" <?php if(in_array("not applicable",$intervention_to_monitor_migrate)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 22px;">
						<p>
							<?php xl("Formal assessment did not indicate pain since the last OASIS assessment","e");?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 230px; height: 29px;">
						<p>
							<?php xl("e. Intervention(s) to prevent pressure ulcers","e");?></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="intervention_to_prevent_pressure" value="no" <?php if(in_array("no",$intervention_to_prevent_pressure)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="intervention_to_prevent_pressure" value="yes" <?php if(in_array("yes",$intervention_to_prevent_pressure)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="intervention_to_prevent_pressure" value="not applicable" <?php if(in_array("not applicable",$intervention_to_prevent_pressure)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 29px;">
						<p>
							<?php xl("Formal assessment indicates the patient was not at risk of pressure ulcers since the last OASIS assessment","e");?></p>
					</td>
				</tr>
				<tr>
					<td style="width: 230px; height: 42px;">
						<p>

							<?php xl("f. Pressure ulcer treatment based on principles of moist wound healing","e");?></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Pressure_ulcer_treatment_based_on_principles" value="no" <?php if(in_array("no",$Pressure_ulcer_treatment_based_on_principles)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Pressure_ulcer_treatment_based_on_principles" value="yes" <?php if(in_array("yes",$Pressure_ulcer_treatment_based_on_principles)) { echo "checked"; };?> /></p>
					</td>
					<td style="width: 5%; height: 29px;">
						<p align="center">
							<input type="checkbox" name="Pressure_ulcer_treatment_based_on_principles" value="not applicable" <?php if(in_array("not applicable",$Pressure_ulcer_treatment_based_on_principles)) { echo "checked"; };?> /></p>
					</td>
					<td style=" height: 42px;">
						<p>
							<?php xl("Dressings that support the principles of moist wound healing not indicated for this patient&rsquo;s pressure ulcers OR patient has no pressure ulcers with need for moist wound healing","e");?></p>
					</td>
				</tr>
			</tbody>
		</table>
	</td>
</tr>
<tr>
<td valign="top"><strong><?php xl("(M2410)","e");?></strong></td><td><?php xl("To which ","e");?><strong><?php xl("Inpatient Facility","e");?></strong><?php xl(" has the patient been admitted?","e");?><br>
<input type="checkbox" name="Inpatient_Facility_patient_been_admitted" value="Hospital" <?php if(in_array("Hospital",$Inpatient_Facility_patient_been_admitted)) { echo "checked"; };?> /> <?php xl("1 - Hospital ","e");?><strong><i><?php xl("[ Go to M2430 ]","e");?></i></strong><br>
<input type="checkbox" name="Inpatient_Facility_patient_been_admitted" value="Rehabilitation facility" <?php if(in_array("Rehabilitation facility",$Inpatient_Facility_patient_been_admitted)) { echo "checked"; };?> /> <?php xl("2 - Rehabilitation facility ","e");?><strong><i><?php xl("[ Go to M0903 ]","e");?></i></strong><br>
<input type="checkbox" name="Inpatient_Facility_patient_been_admitted" value="Nursing home" <?php if(in_array("Nursing home",$Inpatient_Facility_patient_been_admitted)) { echo "checked"; };?> /> <?php xl("3 - Nursing home ","e");?><strong><i><?php xl("[ Go to M2440 ]","e");?></i></strong><br>
<input type="checkbox" name="Inpatient_Facility_patient_been_admitted" value="Hospice" <?php if(in_array("Hospice",$Inpatient_Facility_patient_been_admitted)) { echo "checked"; };?> /> <?php xl("4 - Hospice ","e");?><strong><i><?php xl("[ Go to M0903 ]","e");?></i></strong><br>
<input type="checkbox" name="Inpatient_Facility_patient_been_admitted" value="NA - No inpatient facility admission" <?php if(in_array("NA - No inpatient facility admission",$Inpatient_Facility_patient_been_admitted)) { echo "checked"; };?> /> <?php xl("NA - No inpatient facility admission	","e");?>
</td>
</tr>
<tr><td valign="top"><strong>
<?php xl("(M2420)","e");?></strong></td><td><strong><?php xl("Discharge Disposition:","e");?></strong><?php xl(" Where is the patient after discharge from your agency? ","e");?><strong><?php xl("(Choose only one answer.)","e");?></strong><br>
<input type="checkbox" name="patient_after_discharge_from_your_agency" value="Patient remained in the community (without formal assistive services)" <?php if(in_array("Patient remained in the community (without formal assistive services)",$patient_after_discharge_from_your_agency)) { echo "checked"; };?> /> <?php xl("1 - Patient remained in the community (without formal assistive services)","e");?><br>
<input type="checkbox" name="patient_after_discharge_from_your_agency" value="Patient remained in the community (with formal assistive services)" <?php if(in_array("Patient remained in the community (with formal assistive services)",$patient_after_discharge_from_your_agency)) { echo "checked"; };?> /> <?php xl("2 - Patient remained in the community (with formal assistive services)","e");?><br>
<input type="checkbox" name="patient_after_discharge_from_your_agency" value="Patient transferred to a non-institutional hospice" <?php if(in_array("Patient transferred to a non-institutional hospice",$patient_after_discharge_from_your_agency)) { echo "checked"; };?> /> <?php xl("3 - Patient transferred to a non-institutional hospice","e");?><br>
<input type="checkbox" name="patient_after_discharge_from_your_agency" value="Unknown because patient moved to a geographic location not served by this agency" <?php if(in_array("Unknown because patient moved to a geographic location not served by this agency",$patient_after_discharge_from_your_agency)) { echo "checked"; };?> /> <?php xl("4 - Unknown because patient moved to a geographic location not served by this agency","e");?><br>
<input type="checkbox" name="patient_after_discharge_from_your_agency" value="UK - Other unknown" <?php if(in_array("UK - Other unknown",$patient_after_discharge_from_your_agency)) { echo "checked"; };?> /> <?php xl("UK - Other unknown","e");?>
<strong><i><?php xl("[ Go to M0903 ]","e");?></i></strong></td>
</tr>
<tr><td valign="top"><strong>
<?php xl("(M2430)","e");?></strong></td><td><strong><?php xl("Reason for Hospitalization:","e");?></strong><?php xl(" For what reason(s) did the patient require hospitalization? ","e");?><strong><?php xl("(Mark all that apply.)","e");?></strong><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="roper medication administration, medication side effects, toxicity, anaphylaxis" <?php if(in_array("roper medication administration, medication side effects, toxicity, anaphylaxis",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("1 - Improper medication administration, medication side effects, toxicity, anaphylaxis","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Injury caused by fall" <?php if(in_array("Injury caused by fall",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("2 - Injury caused by fall","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Respiratory infection (e.g., pneumonia, bronchitis)" <?php if(in_array("Respiratory infection (e.g., pneumonia, bronchitis)",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("3 - Respiratory infection (e.g., pneumonia, bronchitis)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other respiratory problem" <?php if(in_array("Other respiratory problem",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("4 - Other respiratory problem","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Heart failure (e.g., fluid overload)" <?php if(in_array("Heart failure (e.g., fluid overload)",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("5 - Heart failure (e.g., fluid overload)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Cardiac dysrhythmia (irregular heartbeat)" <?php if(in_array("Cardiac dysrhythmia (irregular heartbeat)",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("6 - Cardiac dysrhythmia (irregular heartbeat)","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Myocardial infarction or chest pain" <?php if(in_array("Myocardial infarction or chest pain",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("7 - Myocardial infarction or chest pain","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other heart disease" <?php if(in_array("Other heart disease",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("8 - Other heart disease","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Stroke (CVA) or TIA" <?php if(in_array("Stroke (CVA) or TIA",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("9 - Stroke (CVA) or TIA","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Hypo/Hyperglycemia, diabetes out of control" <?php if(in_array("Hypo/Hyperglycemia, diabetes out of control",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("10 - Hypo/Hyperglycemia, diabetes out of control","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="GI bleeding, obstruction, constipation, impaction" <?php if(in_array("GI bleeding, obstruction, constipation, impaction",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("11 - GI bleeding, obstruction, constipation, impaction","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Dehydration, malnutrition" <?php if(in_array("Dehydration, malnutrition",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("12 - Dehydration, malnutrition","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Urinary tract infection" <?php if(in_array("Urinary tract infection",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("13 - Urinary tract infection","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="IV catheter-related infection or complication" <?php if(in_array("IV catheter-related infection or complication",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("14 - IV catheter-related infection or complication","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Wound infection or deterioration" <?php if(in_array("Wound infection or deterioration",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("15 - Wound infection or deterioration","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Uncontrolled pain" <?php if(in_array("Uncontrolled pain",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("16 - Uncontrolled pain","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Acute mental/behavioral health problem" <?php if(in_array("Acute mental/behavioral health problem",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("17 - Acute mental/behavioral health problem","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Deep vein thrombosis, pulmonary embolus" <?php if(in_array("Deep vein thrombosis, pulmonary embolus",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("18 - Deep vein thrombosis, pulmonary embolus","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Scheduled treatment or procedure" <?php if(in_array("Scheduled treatment or procedure",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("19 - Scheduled treatment or procedure","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="Other than above reasons" <?php if(in_array("Other than above reasons",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("20 - Other than above reasons","e");?><br>
<input type="checkbox" name="Reason_for_Hospitalization[]" value="UK - Reason unknown" <?php if(in_array("UK - Reason unknown",$Reason_for_Hospitalization)) { echo "checked"; };?> /> <?php xl("UK - Reason unknown","e");?>
<strong><i><?php xl("[ Go to M0903 ]","e");?></i></strong>
</td>
</tr>
<tr>
<td valign="top"><strong>
<?php xl("(M2440)","e");?></strong></td><td><?php xl("For what ","e");?><strong><?php xl("Reason(s)","e");?></strong><?php xl(" was the patient ","e");?><strong><?php xl("Admitted","e");?></strong><?php xl(" to a ","e");?><strong><?php xl("Nursing Home? (Mark all that apply.)","e");?></strong><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Therapy services" <?php if(in_array("Therapy services",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("1 - Therapy services","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Respite care" <?php if(in_array("Respite care",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("2 - Respite care","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Hospice care" <?php if(in_array("Hospice care",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("3 - Hospice care","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Permanent placement"<?php if(in_array("Permanent placement",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("4 - Permanent placement","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Unsafe for care at home"<?php if(in_array("Unsafe for care at home",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("5 - Unsafe for care at home","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Other" <?php if(in_array("Other",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("6 - Other","e");?><br>
<input type="checkbox" name="patient_Admitted_to_a_Nursing_Home[]" value="Unknown" <?php if(in_array("Unknown",$patient_Admitted_to_a_Nursing_Home)) { echo "checked"; };?> /> <?php xl("UK - Unknown","e");?>
<strong><i><?php xl("[ Go to M0903 ]","e");?></i></strong>
</td>
<td>
</tr>
<tr><td valign="top"><strong><?php xl("(M0903)","e");?></strong></td><td><strong><?php xl("Date of Last (Most Recent) Home Visit:","e");?></strong>  <?php echo goals_date('OASIS_C_Date_of_Last_Home_Visit',$OASIS_C_Date_of_Last_Home_Visit[0]); ?></td></tr>
<tr><td valign="top"><strong><?php xl("(M0906)","e");?></strong></td><td><strong><?php xl("Discharge/Transfer/Death Date:","e");?></strong><?php xl(" Enter the date of the discharge, transfer, or death (at home) of the patient.","e");?>  <?php echo goals_date('OASIS_C_Enter_the_date_of_the_discharge',$OASIS_C_Enter_the_date_of_the_discharge[0]); ?></td></tr>
</table>
                        </li>
                    </ul>
                </li>
            </ul>
<br>
<a href="javascript:top.restoreSession();document.OASIS_C.submit();"
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
