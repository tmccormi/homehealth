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
$formTable = "forms_nursing_visitnote";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

?>
<html><head>
<?php html_header_show();?>
<style type="text/css">
.bold {
	font-weight: bold;
}
.padd {
	padding-left:20px
}
.formtable table { font-size:13px; }

table label, input { display:inherit !important; }
</style>

<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css" />
        <style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>//library/js/jquery-1.4.2.min.js"></script>

<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/css/jquery-ui-1.8.21.custom.css" type="text/css" media="all" />

<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<script>	
	//Function to create an XMLHttp Object.
	function pullAjax(){
    var a;
    try{
      a=new XMLHttpRequest();
    }
    catch(b)
    {
      try
      {
        a=new ActiveXObject("Msxml2.XMLHTTP");
      }catch(b)
      {
        try
        {
          a=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(b)
        {
         return false;
        }
      }
    }
    return a;
  }
	
	function changeICDlist(dx,code,rootdir)
	  {
	    site_root = rootdir; 
	    Dx = dx.name;
	    icd9code = code.value;	   	   
	    obj=pullAjax();	   
	    obj.onreadystatechange=function()
	    {
	      if(obj.readyState==4)
	      {	
	    	 eval("result = "+obj.responseText);

	    	 if(Dx=="visitnote_VS_Diagnosis")
	    	 {
	    		 trmnt_icd9.innerHTML= result['res'];
	    	 }
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/nursing_visitnote/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	
	</script>
	<script>
  $(document).ready(function($) {
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

<script>
function requiredCheck(){
    var time_in = document.getElementById('Visitnote_Time_In').value;
    var time_out = document.getElementById('Visitnote_Time_Out').value;
				var date = document.getElementById('Visitnote_Evaluation_date').value;
    
				if(time_in != "" && time_out != "" && date != "") {
        return true;
    } else {
        alert("Please select a time in, time out, and encounter date before submitting.");
        return false;
    }
}
</script>
</head>
<body class="body_top">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_nursing_visitnote", $_GET["id"]);

$val = array();
foreach($obj as $k => $v) {
	$key = $k;
	$$key = explode('#',$v);
}

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}
?>
<form method="post" id="submitForm"
		action="<?php echo $rootdir;?>/forms/nursing_visitnote/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="nursing_visitnote" onSubmit="return top.restoreSession();" enctype="multipart/form-data">
		<h3 align="center"> <?php xl('SKILLED NURSE VISIT NOTE','e')?> </h3>

<table width="100%" cellpadding="0px" cellspacing="0px" border="1" class="formtable">
  <tr>
    <td><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="0px">
        <tr>
          <td width="8%"  align="center" scope="row"><strong>
            <?php xl('Patient Name','e')?>
            </strong></td>
          <td width="8%" align="center"><input type="text"
					id="patient_name" value="<?php patientName()?>"
					readonly/></td>
          <td width="5%"><strong>
            <?php xl('Time In','e'); ?>
            </strong></td>
          <td width="9%"><select name="Visitnote_Time_In" id="Visitnote_Time_In">
              <?php timeDropDown($visitnote_Time_In[0]) ?>
            </select></td>
          <td width="5%"><strong>
            <?php xl('Time Out','e'); ?>
            </strong></td>
          <td width="9%"><select name="Visitnote_Time_Out" id="Visitnote_Time_Out">
              <?php timeDropDown($visitnote_Time_Out[0]) ?>
            </select></td>
          <td width="5%" align="center"><strong>
            <?php xl('Encounter Date','e')?>
            </strong></td>
          <td width="10%" ><input type='text' size='10' name='Visitnote_Evaluation_date' id='Visitnote_Evaluation_date' 
					title='<?php xl('Encounter Date','e'); ?>' value="<?php echo stripslashes($Visitnote_Evaluation_date[0]);?>" 
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/>
            <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
	style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
            <script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"Visitnote_Evaluation_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script></td>
        </tr>
      </table></td>
  </tr>
  <tr>
  <td>
    <table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="0px">
      <tr>
        <td scope="row"><strong>
          <?php xl('TYPE OF VISIT','e'); ?>
          </strong>
          <input type="checkbox" value="Visit" name="visitnote_type_of_visit" <?php if(in_array("Visit",$visitnote_type_of_visit)) echo "checked"; ?> />
          <?php xl('Visit','e'); ?>
          <input type="checkbox" value="Visit and Supervisory Review Other" <?php if(in_array("Visit and Supervisory Review Other",$visitnote_type_of_visit)) echo "checked"; ?> name="visitnote_type_of_visit" />
          <?php xl('Visit and Supervisory Review','e'); ?>
          <span class="padd"><strong>
          <?php xl('Other','e'); ?>
          </strong>
          <input type="text" size="55" name="visitnote_type_of_visit_other" value="<?php echo $visitnote_type_of_visit_other[0];?>" />
          </span></td>
		 </tr> 
		 </table>
      </td>
	  </tr>
  <tr>
  <td>
    <table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
      <tr>
        <td scope="row"><strong>
          <?php xl('VITAL SIGNS','e'); ?>
          </strong></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
        <tr>
          <td scope="row"> <strong><?php xl('Pulse','e'); ?></strong>
            <input type="text" size="15" name="visitnote_Pulse" value="<?php echo $visitnote_Pulse[0];?>" />
            <span class="padd">
            <input type="checkbox" value="Regular" name="visitnote_Pulse_State" <?php if(in_array("Regular",$visitnote_Pulse_State)) echo "checked"; ?> />
            <?php xl('Regular','e'); ?>
            <input type="checkbox" value="Irregular" name="visitnote_Pulse_State" <?php if(in_array("Irregular",$visitnote_Pulse_State)) echo "checked"; ?> />
            <?php xl('Irregular','e'); ?></span> <span class="padd"><?php xl('Temperature','e'); ?>
            <input type="text" size="15" name="visitnote_Temperature" value="<?php echo $visitnote_Temperature[0];?>" />
            </span> <span class="padd">
            <input type="checkbox" value="Oral" name="visitnote_Temperature_type" <?php if(in_array("Oral",$visitnote_Temperature_type)) echo "checked"; ?> />
            <?php xl('Oral','e'); ?>
            <input type="checkbox" value="Temporal" name="visitnote_Temperature_type" <?php if(in_array("Temporal",$visitnote_Temperature_type)) echo "checked"; ?> />
           <?php xl(' Temporal','e'); ?></span> <span class="padd"><strong><?php xl('Other','e'); ?></strong>
            <input type="text" size="15" name="visitnote_VS_other" value="<?php echo $visitnote_VS_other[0];?>" />
            </span> <span class="padd"><?php xl('Respirations','e'); ?>
            <input type="text" size="15" name="visitnote_VS_Respirations" value="<?php echo $visitnote_VS_Respirations[0];?>" />
            </span> <span class="padd"><?php xl('Blood Pressure Systolic','e'); ?>
            <input type="text" size="15" name="visitnote_VS_BP_Systolic" value="<?php echo $visitnote_VS_BP_Systolic[0];?>" />
            /
            <input type="text" size="15" name="visitnote_VS_BP_Diastolic" value="<?php echo $visitnote_VS_BP_Diastolic[0];?>" />
            <?php xl('Diastolic','e'); ?></span> <span class="padd">
            <input type="checkbox" value="Right" name="visitnote_VS_BP_Body_side[]" <?php if(in_array("Right",$visitnote_VS_BP_Body_side)) echo "checked"; ?> />
            <?php xl('Right','e'); ?>
            <input type="checkbox" value="Left" name="visitnote_VS_BP_Body_side[]" <?php if(in_array("Left",$visitnote_VS_BP_Body_side)) echo "checked"; ?> />
            <?php xl('Left','e'); ?></span> <span class="padd">
            <input type="checkbox" value="Sitting" name="visitnote_VS_BP_Body_Position[]" <?php if(in_array("Sitting",$visitnote_VS_BP_Body_Position)) echo "checked"; ?> />
            <?php xl('Sitting','e'); ?>
            <input type="checkbox" value="Standing" name="visitnote_VS_BP_Body_Position[]" <?php if(in_array("Standing",$visitnote_VS_BP_Body_Position)) echo "checked"; ?> />
            <?php xl('Standing','e'); ?>
            <input type="checkbox" value="Lying" name="visitnote_VS_BP_Body_Position[]" <?php if(in_array("Lying",$visitnote_VS_BP_Body_Position)) echo "checked"; ?> />
            <?php xl('Lying','e'); ?></span> <span class="padd"><strong>*O<sup>2</sup> Sat</strong>
            <input type="text" size="15" name="visitnote_VS_Sat" value="<?php echo $visitnote_VS_Sat[0];?>" />
            <span> <strong>*<?php xl('Physician ordered','e')?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
        <tr>
          <td scope="row"> <b><?php xl('Pain','e')?></b>
            <input type="checkbox" value="No Pain" name="visitnote_VS_Pain" <?php if(in_array("No Pain",$visitnote_VS_Pain)) echo "checked"; ?> />
            <?php xl('No Pain','e')?>
            <input type="checkbox" value="Pain limits functional ability" name="visitnote_VS_Pain" <?php if(in_array("Pain limits functional ability",$visitnote_VS_Pain)) echo "checked"; ?> />
            <?php xl('Pain limits functional ability','e')?>  <span class="padd"><strong><?php xl('Intensity','e')?> </strong>
            <input type="text" size="15" name="visitnote_VS_Pain_Intensity" value="<?php echo $visitnote_VS_Pain_Intensity[0];?>" />
            </span> <span class="padd">
            <input type="checkbox" value="Improve" name="visitnote_VS_condition" <?php if(in_array("Improve",$visitnote_VS_condition)) echo "checked"; ?> />
            <?php xl('Improve','e')?>
            <input type="checkbox" value="Worse" name="visitnote_VS_condition" <?php if(in_array("Worse",$visitnote_VS_condition)) echo "checked"; ?> />
            <?php xl('Worse','e')?>
            <input type="checkbox" value="No Change" name="visitnote_VS_condition" <?php if(in_array("No Change",$visitnote_VS_condition)) echo "checked"; ?> />
            <?php xl('No Change','e')?> </span><span class="padd">
            <input type="text" size="15" name="visitnote_VS_Condition_other" value="<?php echo $visitnote_VS_Condition_other[0];?>" />
            </span></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="1px" width="100%" cellspacing="0px" cellpadding="5px" class="formtable">
        <tr>
          <td><strong>
            <?php xl('Please Note: Contact MD if Vital Signs are: Pulse','e')?>
            &lt;
            <?php xl('56 or','e')?>
            &gt;
            <?php xl('120; Temperature ','e')?>
            &lt;
            <?php xl('56 or','e')?>;
            &gt;
            <?php xl('101; Respirations','e')?>
            &lt;
            <?php xl('10 or','e')?>
            &gt;
            <?php xl('30;','e')?>;
            <br />
            </strong> <strong>
            <?php xl('SBP','e')?>
            &lt;
            <?php xl('80 or','e')?>
            &gt;
            <?php xl('190; DBP','e')?>
            &lt;
            <?php xl('50 or','e')?>
            &gt;
            <?php xl('100; Pain Significantly Impacts patients ability to participate. O2 Sat ','e')?>
            &lt;
            <?php xl('90% 2 min. rest','e')?>
            </strong></td>
        </tr>
		</table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
        <tr>
          <td scope="row"> <strong><?php xl('DIAGNOSIS','e')?></strong>
			
				<input type="text" id="visitnote_VS_Diagnosis" name="visitnote_VS_Diagnosis" style="width:100%;" value="<?php echo stripslashes($obj{'visitnote_VS_Diagnosis'}); ?>"/>
			</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
        <tr>
          <td scope="row"> <strong><?php xl('PATIENT CONTINUES TO BE HOMEBOUND DUE TO','e')?></strong>
            <input type="checkbox" value="Bed Bound" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Bed Bound",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Bed Bound','e')?>
            <input type="checkbox" value="Impaired Mobility" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Impaired Mobility",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Impaired Mobility','e')?>
            <input type="checkbox" value="No Pain" name="visitnote_HR_Home_Bound[]" <?php if(in_array("No Pain",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Incontinent','e')?>
            <input type="checkbox" value="Immunosuppressed" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Immunosuppressed",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Immunosuppressed','e')?>
            <input type="checkbox" value="Medical Restrictions in" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Medical Restrictions in",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Medical Restrictions in','e')?>
            <input type="text" size="15" name="visitnote_HR_Patient_Restriction" value="<?php echo $visitnote_HR_Patient_Restriction[0];?>" />
            <input type="checkbox" value="Needs assistance in all activities of daily living" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Needs assistance in all activities of daily living",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Needs assistance in all activities of daily living','e')?>
            <input type="checkbox" value="Recent Hospital Stay" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Recent Hospital Stay",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Recent Hospital Stay','e')?>
            <input type="checkbox" value="Residual Weakness" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Residual Weakness",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Residual Weakness','e')?>
            <input type="checkbox" value="Severe Dyspnea" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Severe Dyspnea",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Severe Dyspnea','e')?>
            <input type="checkbox" value="Severe Pain" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Severe Pain",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Severe Pain','e')?>
            <input type="checkbox" value="SOB upon exertion" name="visitnote_HR_Home_Bound[]" <?php if(in_array("SOB upon exertion",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('SOB upon exertion','e')?>
            <input type="checkbox" value="Unable to leave home safely without assistance" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Unable to leave home safely without assistance",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Unable to leave home safely without assistance','e')?>
            <input type="checkbox" value="Wound" name="visitnote_HR_Home_Bound[]" <?php if(in_array("Wound",$visitnote_HR_Home_Bound)) echo "checked"; ?> />
            <?php xl('Wound','e')?> <span class="padd">
			<br>
			<?php xl('Other','e')?>
            <input type="text" style="width:75%" name="visitnote_HR_others" value="<?php echo $visitnote_HR_others[0];?>" />
            </span></td>
        </tr>
		</table>
	</td>
	</tr>	
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('SYSTEMS ASSESSMENT (Check all that apply)','e')?></strong> </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('CARDIOVASCULAR','e')?></strong>
                  <input type="checkbox" value="Medication Management" name="visitnote_Cardiovascular[]" <?php if(in_array("Medication Management",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Medication Management','e')?>
                  <input type="checkbox" value="Hypertension" name="visitnote_Cardiovascular[]" <?php if(in_array("Hypertension",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Hypertension','e')?>
                  <input type="checkbox" value="Hypotension" name="visitnote_Cardiovascular[]" <?php if(in_array("Hypotension",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Hypotension','e')?>
                  <input type="checkbox" value="Peripheral Pulses" name="visitnote_Cardiovascular[]" <?php if(in_array("Peripheral Pulses",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Peripheral Pulses','e')?>
                  <input type="checkbox" value="Abnormal Lung Sounds" name="visitnote_Cardiovascular[]" <?php if(in_array("Abnormal Lung Sounds",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Abnormal Lung Sounds','e')?>
                  <input type="checkbox" value="Patient Weight Gain/Loss" name="visitnote_Cardiovascular[]" <?php if(in_array("Patient Weight Gain/Loss",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Patient Weight Gain/Loss','e')?>
                  <input type="checkbox" value="Abnormal Heart Sounds" name="visitnote_Cardiovascular[]" <?php if(in_array("Abnormal Heart Sounds",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Abnormal Heart Sounds','e')?>
                  <input type="checkbox" value="Chest Pain" name="visitnote_Cardiovascular[]" <?php if(in_array("Chest Pain",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Chest Pain','e')?>
                  <input type="checkbox" value="Edema/Fluid Retention" name="visitnote_Cardiovascular[]" <?php if(in_array("Edema/Fluid Retention",$visitnote_Cardiovascular)) echo "checked"; ?> />
                  <?php xl('Edema/Fluid Retention','e')?> <span class="padd"> <?php xl('Other','e')?>
                  <input type="text" style="width:75%" name="visitnote_Cardiovascular_other" value="<?php echo $visitnote_Cardiovascular_other[0];?>" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('ENDOCRINE','e')?></strong>
                  <input type="checkbox" value="Diabetic Type I" name="visitnote_endocrine[]" <?php if(in_array("Diabetic Type I",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Diabetic Type I','e')?>
                  <input type="checkbox" value="Diabetic Type 2" name="visitnote_endocrine[]" <?php if(in_array("Diabetic Type 2",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Diabetic Type 2','e')?>
                  <input type="checkbox" value="Diet/Oral Controlled" name="visitnote_endocrine[]" <?php if(in_array("Diet/Oral Controlled",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Diet/Oral Controlled','e')?>
                  <input type="checkbox" value="Insulin Controlled" name="visitnote_endocrine[]" <?php if(in_array("Insulin Controlled",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Insulin Controlled','e')?>
                  <input type="checkbox" value="Hyploglycemia" name="visitnote_endocrine[]" <?php if(in_array("Hyploglycemia",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Hyploglycemia','e')?>
                  <input type="checkbox" value="Hyperglycemia Insulin Administered by" name="visitnote_endocrine[]" <?php if(in_array("Hyperglycemia Insulin Administered by",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Hyperglycemia Insulin Administered by','e')?>
                  <input type="checkbox" value="Self" name="visitnote_endocrine[]" <?php if(in_array("Self",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Self','e')?>
                  <input type="checkbox" value="Caregiver" name="visitnote_endocrine[]" <?php if(in_array("Caregiver",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Caregiver','e')?>
                  <input type="checkbox" value="Nurse" name="visitnote_endocrine[]" <?php if(in_array("Nurse",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Nurse','e')?>&nbsp;&nbsp;<?php xl('Other','e')?>
                  <input type="text" size="15" name="visitnote_endocrine_other" value="<?php echo $visitnote_endocrine_other[0];?>" />&nbsp;
                  <input type="checkbox" value="Weight Loss/Gain" name="visitnote_endocrine[]" <?php if(in_array("Weight Loss/Gain",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Weight Loss/Gain','e')?>
                  <input type="checkbox" value="Diet Compliance Blood Sugar Ranges" name="visitnote_endocrine[]" <?php if(in_array("Diet Compliance Blood Sugar Ranges",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('Diet Compliance','e')?> <span class="padd"><?php xl('Blood Sugar Ranges','e')?></span>
                  <input type="text" size="15" name="visitnote_endocrine_blood_sugar" value="<?php echo $visitnote_endocrine_blood_sugar[0];?>" />
                  <?php xl('Frequency of Monitoring','e')?>
                  <input type="text" size="15" name="visitnote_endocrine_frequency" value="<?php echo $visitnote_endocrine_frequency[0];?>" />
                  <?php xl('Current Complications/ Risk Factors','e')?>
                  <input type="checkbox" value="None" name="visitnote_endocrine[]" <?php if(in_array("None",$visitnote_endocrine)) echo "checked"; ?> />
                  <?php xl('None','e')?>
                  <input type="text" size="15" name="visitnote_endocrine_Risk_Factors" value="<?php echo $visitnote_endocrine_Risk_Factors[0];?>" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('GASTROINTESTINAL','e')?></strong>
                  <input type="checkbox" value="GT Management/Site" name="visitnote_Gastrointestinal[]" <?php if(in_array("GT Management/Site",$visitnote_Gastrointestinal)) echo "checked"; ?> />
                  <?php xl('GT Management/Site','e')?>
                  <input type="checkbox" value="Ostomy Management" name="visitnote_Gastrointestinal[]" <?php if(in_array("Ostomy Management",$visitnote_Gastrointestinal)) echo "checked"; ?> />
                  <?php xl('Ostomy Management/Site','e')?>
                  <input type="checkbox" value="Bowel Sounds x4" name="visitnote_Gastrointestinal[]" <?php if(in_array("Bowel Sounds x4",$visitnote_Gastrointestinal)) echo "checked"; ?> />
                  <?php xl('Bowel Sounds x4','e')?>
                  <input type="checkbox" value="Last BM" name="visitnote_Gastrointestinal[]" <?php if(in_array("Last BM",$visitnote_Gastrointestinal)) echo "checked"; ?> />
                  <?php xl('Last BM','e')?>
				  <input type="text" style="width:10%" name="visitnote_Gastrointestinal_bm_date" id="visitnote_Gastrointestinal_bm_date" 
					 value="<?php echo stripslashes($visitnote_Gastrointestinal_bm_date[0]);?>" title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_onset_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
					Calendar.setup({inputField:"visitnote_Gastrointestinal_bm_date", ifFormat:"%Y-%m-%d", button:"img_onset_date"});
					</script> <br />
                  <input type="checkbox" value="Diarrhea/Vomiting" name="visitnote_Gastrointestinal[]" <?php if(in_array("Diarrhea/Vomiting",$visitnote_Gastrointestinal)) echo "checked"; ?> />
                  <?php xl('Diarrhea/Vomiting','e')?>
                  <input type="checkbox" value="Nausea/Vomiting" name="visitnote_Gastrointestinal[]" <?php if(in_array("Nausea/Vomiting",$visitnote_Gastrointestinal)) echo "checked"; ?> />
                 <?php xl('Nausea/Vomiting','e')?>
                  <input type="checkbox" value="ABD Distention" name="visitnote_Gastrointestinal[]" <?php if(in_array("ABD Distention",$visitnote_Gastrointestinal)) echo "checked"; ?> />
                  <?php xl('ABD Distention','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:45%" name="visitnote_Gastrointestinal_other" value="<?php echo $visitnote_Gastrointestinal_other[0];?>" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('GENITOURINARY','e')?></strong>
                  <input type="checkbox" value="Nutrition/Hydration" name="visitnote_Genitourinary" <?php if(in_array("Nutrition/Hydration",$visitnote_Genitourinary)) echo "checked"; ?> />
                  <?php xl('Nutrition/Hydration','e')?> <span class="padd"><?php xl('Incontinence:','e')?>
                  <input type="checkbox" value="Bowel" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Bowel",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Bowel','e')?>
                  <input type="checkbox" value="Bladder" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Bladder",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Bladder','e')?>
                  <input type="checkbox" value="Urge" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Urge",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Urge','e')?>
                  <input type="checkbox" value="Stress" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Stress",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Stress','e')?>
                  <input type="checkbox" value="Urinary Retention" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Urinary Retention",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Urinary Retention','e')?>
                  <input type="checkbox" value="Foley Catheter" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Foley Catheter",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Foley Catheter','e')?>
                  <input type="checkbox" value="Urine Discolored" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Urine Discolored",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Urine Discolored','e')?>
                  <input type="checkbox" value="Pain/Burning" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Pain/Burning",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Pain/Burning','e')?>
                  <input type="checkbox" value="Feeling unable to Empty Bladder" name="visitnote_Genitourinary_Incontinence[]" <?php if(in_array("Feeling unable to Empty Bladder",$visitnote_Genitourinary_Incontinence)) echo "checked"; ?> />
                  <?php xl('Feeling unable to Empty Bladder','e')?></span> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:30%" name="visitnote_Genitourinary_others" value="<?php echo $visitnote_Genitourinary_others[0];?>" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('INTEGUMENTARY','e')?></strong>
                  <input type="checkbox" value="Normal" name="visitnote_Integumentary[]" <?php if(in_array("Normal",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Normal','e')?>
                  <input type="checkbox" value="Dry" name="visitnote_Integumentary[]" <?php if(in_array("Dry",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Dry','e')?>
                  <input type="checkbox" value="Warm" name="visitnote_Integumentary[]" <?php if(in_array("Warm",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Warm','e')?>
                  <input type="checkbox" value="Cold" name="visitnote_Integumentary[]" <?php if(in_array("Cold",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Cold','e')?>
                  <input type="checkbox" value="Pale" name="visitnote_Integumentary[]" <?php if(in_array("Pale",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Pale','e')?>
                  <input type="checkbox" value="Diaphoretic" name="visitnote_Integumentary[]" <?php if(in_array("Diaphoretic",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Diaphoretic','e')?>
                  <input type="checkbox" value="Rash" name="visitnote_Integumentary[]" <?php if(in_array("Rash",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Rash','e')?>
                  <input type="checkbox" value="Lesion" name="visitnote_Integumentary[]" <?php if(in_array("Lesion",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Lesion','e')?>
                  <input type="checkbox" value="Turgor" name="visitnote_Integumentary[]" <?php if(in_array("Turgor",$visitnote_Integumentary)) echo "checked"; ?> /> <br />
                  <?php xl('Turgor','e')?>
                  <input type="checkbox" value="Skin Tears" name="visitnote_Integumentary[]" <?php if(in_array("Skin Tears",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Skin Tears','e')?>
                  <input type="checkbox" value="Wound" name="visitnote_Integumentary[]" <?php if(in_array("Wound",$visitnote_Integumentary)) echo "checked"; ?> />
                  <?php xl('Wound(s) (Refer to Assessment)','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:55%" name="visitnote_Integumentary_other" value="<?php echo $visitnote_Integumentary_other[0];?>" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('MENTAL/EMOTIONAL Oriented to:','e')?></strong>
                  <input type="checkbox" value="Person" name="visitnote_Mental_Emotional[]" <?php if(in_array("Person",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Person','e')?>
                  <input type="checkbox" value="Place" name="visitnote_Mental_Emotional[]" <?php if(in_array("Place",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Place','e')?>
                  <input type="checkbox" value="Date" name="visitnote_Mental_Emotional[]" <?php if(in_array("Date",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Date','e')?>
                  <span class="padd"><input type="checkbox" value="Disoriented" name="visitnote_Mental_Emotional[]" <?php if(in_array("Disoriented",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Disoriented','e')?></span>
                  <input type="checkbox" value="Cooperative" name="visitnote_Mental_Emotional[]" <?php if(in_array("Cooperative",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Cooperative','e')?>
                  <input type="checkbox" value="Uncooperative" name="visitnote_Mental_Emotional[]" <?php if(in_array("Uncooperative",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Uncooperative','e')?>
                  <input type="checkbox" value="Forgetful" name="visitnote_Mental_Emotional[]" <?php if(in_array("Forgetful",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Forgetful','e')?>
                  <input type="checkbox" value="Anxious" name="visitnote_Mental_Emotional[]" <?php if(in_array("Anxious",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Anxious','e')?>
                  <input type="checkbox" value="Agitated" name="visitnote_Mental_Emotional[]" <?php if(in_array("Agitated",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Agitated','e')?>
                  <input type="checkbox" value="Depressed" name="visitnote_Mental_Emotional[]" <?php if(in_array("Depressed",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Depressed','e')?>
                  <input type="checkbox" value="Withdrawn" name="visitnote_Mental_Emotional[]" <?php if(in_array("Withdrawn",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Withdrawn','e')?>
                  <input type="checkbox" value="Delusional Thinking" name="visitnote_Mental_Emotional[]" <?php if(in_array("Delusional Thinking",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Delusional Thinking','e')?>
                  <input type="checkbox" value="Fearful" name="visitnote_Mental_Emotional[]" <?php if(in_array("Fearful",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Fearful','e')?>
                  <input type="checkbox" value="Lethargic" name="visitnote_Mental_Emotional[]" <?php if(in_array("Lethargic",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Lethargic','e')?>
                  <input type="checkbox" value="Hallucinations" name="visitnote_Mental_Emotional[]" <?php if(in_array("Hallucinations",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Hallucinations','e')?>
                  <input type="checkbox" value="Social" name="visitnote_Mental_Emotional[]" <?php if(in_array("Social",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Social','e')?>
                  <input type="checkbox" value="Isolative" name="visitnote_Mental_Emotional[]" <?php if(in_array("Isolative",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Isolative','e')?>
                  <input type="checkbox" value="Paranoid" name="visitnote_Mental_Emotional[]" <?php if(in_array("Paranoid",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Paranoid','e')?>
                  <input type="checkbox" value="Suicidal Ideation/Suicidal" name="visitnote_Mental_Emotional[]" <?php if(in_array("Suicidal Ideation/Suicidal",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Suicidal Ideation/Suicidal','e')?>
                  <input type="checkbox" value="Labile" name="visitnote_Mental_Emotional[]" <?php if(in_array("Labile",$visitnote_Mental_Emotional)) echo "checked"; ?> />
                  <?php xl('Labile','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:45%" name="visitnote_Mental_Emotional_other" value="<?php echo $visitnote_Mental_Emotional_other[0];?>" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('MUSCULOSKELETAL/MOBILITY Weight Bearing Status (WB):','e')?></strong>
                  <input type="checkbox" value="Full-WB" name="visitnote_Musculoskeletal[]" <?php if(in_array("Full-WB",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Full-WB','e')?>
                  <input type="checkbox" value="Non-WB" name="visitnote_Musculoskeletal[]" <?php if(in_array("Non-WB",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Non-WB','e')?>
                  <input type="checkbox" value="Partial WB" name="visitnote_Musculoskeletal[]" <?php if(in_array("Partial WB",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Partial WB','e')?>
                  <input type="checkbox" value="Poor Strength" name="visitnote_Musculoskeletal[]" <?php if(in_array("Poor Strength",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Poor Strength','e')?>
                  <input type="checkbox" value="Poor Endurance" name="visitnote_Musculoskeletal[]" <?php if(in_array("Poor Endurance",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Poor Endurance','e')?>
                  <input type="checkbox" value="Limited Range of Motion (ROM)" name="visitnote_Musculoskeletal[]" <?php if(in_array("Limited Range of Motion (ROM)",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Limited Range of Motion (ROM)','e')?>
                  <input type="text" size="15" name="visitnote_Musculoskeletal_ROM" value="<?php echo $visitnote_Musculoskeletal_ROM[0];?>" />
                  <input type="checkbox" value="Walking Steady" name="visitnote_Musculoskeletal[]" <?php if(in_array("Walking Steady",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Walking Steady','e')?>
                  <input type="checkbox" value="Walking Unsteady" name="visitnote_Musculoskeletal[]" <?php if(in_array("Walking Unsteady",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Walking Unsteady','e')?>
                  <input type="checkbox" value="Pain With Movement" name="visitnote_Musculoskeletal[]" <?php if(in_array("Pain With Movement",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Pain With Movement','e')?>
                  <input type="checkbox" value="Wears Prosthetic" name="visitnote_Musculoskeletal[]" <?php if(in_array("Wears Prosthetic",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Wears Prosthetic','e')?>
                  <input type="checkbox" value="Wears Orthotic" name="visitnote_Musculoskeletal[]" <?php if(in_array("Wears Orthotic",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Wears Orthotic','e')?>
                  <input type="checkbox" value="Transfers With Assist" name="visitnote_Musculoskeletal[]" <?php if(in_array("Transfers With Assist",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Transfers With Assist','e')?>
                  <input type="checkbox" value="Transfers Without Assist" name="visitnote_Musculoskeletal[]" <?php if(in_array("Transfers Without Assist",$visitnote_Musculoskeletal)) echo "checked"; ?> />
                  <?php xl('Transfers Without Assist','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:23%" name="visitnote_Musculoskeletal_other" value="<?php echo $visitnote_Musculoskeletal_other[0];?>" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('NEUROLOGICAL','e')?></strong>
                  <input type="checkbox" value="Alert" name="visitnote_Neurological[]" <?php if(in_array("Alert",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Alert','e')?>
                  <input type="checkbox" value="Not Alert" name="visitnote_Neurological[]" <?php if(in_array("Not Alert",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Not Alert','e')?>
                  <input type="checkbox" value="Visual Impairment" name="visitnote_Neurological[]" <?php if(in_array("Visual Impairment",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Visual Impairment','e')?>
                  <input type="checkbox" value="Hearing Impairment" name="visitnote_Neurological[]" <?php if(in_array("Hearing Impairment",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Hearing Impairment','e')?>
                  <input type="checkbox" value="Unilateral Weakness" name="visitnote_Neurological[]" <?php if(in_array("Unilateral Weakness",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Unilateral Weakness','e')?>
                  <input type="checkbox" value="Bilateral Weakness" name="visitnote_Neurological[]" <?php if(in_array("Bilateral Weakness",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Bilateral Weakness','e')?>
                  <input type="checkbox" value="Speech Enunciation Difficulty" name="visitnote_Neurological[]" <?php if(in_array("Speech Enunciation Difficulty",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Speech Enunciation Difficulty','e')?>
                  <input type="checkbox" value="Speech Comprehension Difficulty" name="visitnote_Neurological[]" <?php if(in_array("Speech Comprehension Difficulty",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Speech Comprehension Difficulty','e')?>
                  <input type="checkbox" value="Swallowing Difficulty" name="visitnote_Neurological[]" <?php if(in_array("Swallowing Difficulty",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Swallowing Difficulty','e')?>
                  <input type="checkbox" value="Seizure Activity" name="visitnote_Neurological[]" <?php if(in_array("Seizure Activity",$visitnote_Neurological)) echo "checked"; ?> />
                  <?php xl('Seizure Activity','e')?> <span class="padd"><br><?php xl('Other','e')?>
                  <input type="text" style="width:75%" name="visitnote_Neurological_other" value="<?php echo $visitnote_Neurological_other[0];?>" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('RESPIRATORY','e')?></strong>
                  <input type="checkbox" value="Lung Sounds Clear" name="visitnote_Respiratory[]" <?php if(in_array("Lung Sounds Clear",$visitnote_Respiratory)) echo "checked"; ?> />
                  <?php xl('Lung Sounds Clear','e')?>
                  <input type="checkbox" value="Abnormal Breath Sounds" name="visitnote_Respiratory[]" <?php if(in_array("Abnormal Breath Sounds",$visitnote_Respiratory)) echo "checked"; ?> />
                  <?php xl('Abnormal Breath Sounds','e')?>
                  <input type="checkbox" value="Cough/Sputum" name="visitnote_Respiratory[]" <?php if(in_array("Cough/Sputum",$visitnote_Respiratory)) echo "checked"; ?> />
                  <?php xl('Cough/Sputum','e')?>
                  <input type="checkbox" value="O2 Liters" name="visitnote_Respiratory[]" <?php if(in_array("O2 Liters",$visitnote_Respiratory)) echo "checked"; ?> />
                  <?php xl('O2 Liters','e')?>
                  <input type="text" size="15" name="visitnote_Respiratory_liters" value="<?php echo $visitnote_Respiratory_liters[0];?>" />
                  <input type="checkbox" value="Pallor/Cyanosis" name="visitnote_Respiratory[]" <?php if(in_array("Pallor/Cyanosis",$visitnote_Respiratory)) echo "checked"; ?> />
                  <?php xl('Pallor/Cyanosis','e')?>
                  <input type="checkbox" value="Respiration Labored" name="visitnote_Respiratory[]" <?php if(in_array("Respiration Labored",$visitnote_Respiratory)) echo "checked"; ?> />
                  <?php xl('Respiration Labored','e')?>
                  <input type="checkbox" value="Respiration Unlabored Other" name="visitnote_Respiratory[]" <?php if(in_array("Respiration Unlabored Other",$visitnote_Respiratory)) echo "checked"; ?> />
                  <?php xl('Respiration Unlabored','e')?><span class="padd"><?php xl('Other','e')?></span>&nbsp;
                  <input type="text" style="width:41%" name="visitnote_Respiratory_other" value="<?php echo $visitnote_Respiratory_other[0];?>" />
                  <?php xl('(see above for O2 Sat)','e')?> </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"><strong><?php xl(' GENERAL MEDICAL','e')?></strong>
                  <input type="checkbox" value="Appetite" name="visitnote_General_medical[]" <?php if(in_array("Appetite",$visitnote_General_medical)) echo "checked"; ?> />
                  <?php xl('Appetite','e')?>
                  <input type="checkbox" value="Weight Gain" name="visitnote_General_medical[]" <?php if(in_array("Weight Gain",$visitnote_General_medical)) echo "checked"; ?> />
                  <?php xl('Weight Gain','e')?>
                  <input type="text" size="15" name="visitnote_General_medical_lbs1" value="<?php echo $visitnote_General_medical_lbs1[0];?>" />
                  <?php xl('lbs','e')?>
                  <input type="checkbox" value="Weight Loss" name="visitnote_General_medical[]" <?php if(in_array("Weight Loss",$visitnote_General_medical)) echo "checked"; ?> />
                  <?php xl('Weight Loss','e')?>
                  <input type="text" size="15" name="visitnote_General_medical_lbs2" value="<?php echo $visitnote_General_medical_lbs2[0];?>" />
                  <?php xl('lbs','e')?>
                  <input type="checkbox" value="Medication Mgt" name="visitnote_General_medical[]" <?php if(in_array("Medication Mgt",$visitnote_General_medical)) echo "checked"; ?> />
                  <?php xl('Medication Mgt','e')?><?php xl('Other','e')?>
                  <input type="text" style="width:75%" name="visitnote_General_medical_other" value="<?php echo $visitnote_General_medical_other[0];?>" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('SERVICES PROVIDED to','e')?></strong>
                  <input type="checkbox" value="Patient" name="visitnote_services_provided[]" <?php if(in_array("Patient",$visitnote_services_provided)) echo "checked"; ?> />
                  <?php xl('Patient','e')?>
                  <input type="checkbox" value="Caregiver" name="visitnote_services_provided[]" <?php if(in_array("Caregiver",$visitnote_services_provided)) echo "checked"; ?> />
                  <?php xl('Caregiver','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:20%" name="visitnote_services_provided_other" value="<?php echo $visitnote_services_provided_other[0];?>" />
                  <strong><?php xl('G-Codes','e')?></strong>
                  <input type="text" style="width:20%" name="visitnote_g_codes" value="<?php echo $visitnote_g_codes[0];?>" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row" width="50%"><input type="checkbox" value="G0154-Direct skilled services of a LPN/LVN or RN" name="visitnote_services_provided_options[]" <?php if(in_array("G0154-Direct skilled services of a LPN/LVN or RN",$visitnote_services_provided_options)) echo "checked"; ?> />
                  <?php xl('<b>G0154</b>-Direct skilled services of a LPN/LVN or RN','e')?> <br />
                  <input type="checkbox" value="G0162-RN management and evaluation of plan of care" name="visitnote_services_provided_options[]" <?php if(in_array("G0162-RN management and evaluation of plan of care",$visitnote_services_provided_options)) echo "checked"; ?> />
                  <?php xl('<b>G0162</b>-RN management and evaluation of plan of care','e')?> <br />
                  <input type="checkbox" value="G0163- LPN/LVN or RN for observation and assessment of organ system" name="visitnote_services_provided_options[]" <?php if(in_array("G0163- LPN/LVN or RN for observation and assessment of organ system",$visitnote_services_provided_options)) echo "checked"; ?> />
                  <?php xl('<b>G0163</b>- LPN/LVN or RN for observation and assessment of organ system','e')?> </td>
                <td scope="row"><input type="checkbox" value="G0164 RN Training and Education in" name="visitnote_services_provided_options[]" <?php if(in_array("G0164 RN Training and Education in",$visitnote_services_provided_options)) echo "checked"; ?> />
                  <?php xl('<b>G0164</b> RN Training and Education in','e')?>
                  <table style="padding-left:15px;"><tr><td width="75%"><input type="checkbox" value="Medication Management" name="visitnote_RN_Training_and_Education[]" <?php if(in_array("Medication Management",$visitnote_RN_Training_and_Education)) echo "checked"; ?> />
                 <?php xl('Medication Management','e')?>
                  <input type="checkbox" value="Disease Management" name="visitnote_RN_Training_and_Education[]" <?php if(in_array("Disease Management",$visitnote_RN_Training_and_Education)) echo "checked"; ?> />
                  <?php xl('Disease Management','e')?>
                  <input type="checkbox" value="Wound Care" name="visitnote_RN_Training_and_Education[]" <?php if(in_array("Wound Care",$visitnote_RN_Training_and_Education)) echo "checked"; ?> />
                  <?php xl('Wound Care','e')?>
                  <input type="checkbox" value="Diet Management" name="visitnote_RN_Training_and_Education[]" <?php if(in_array("Diet Management",$visitnote_RN_Training_and_Education)) echo "checked"; ?> />
                  <?php xl('Diet Management','e')?>
                  <input type="checkbox" value="Oxygen Management" name="visitnote_RN_Training_and_Education[]" <?php if(in_array("Oxygen Management",$visitnote_RN_Training_and_Education)) echo "checked"; ?> />
                  <?php xl('Oxygen Management','e')?><br>
                  <?php xl('Other','e')?>
                  <input type="text" style="width:85%" name="visitnote_services_provided_options_other" value="<?php echo $visitnote_services_provided_options_other[0];?>" />
				  </td></tr></table>
				</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('CLINICAL FINDINGS THIS VISIT','e')?></strong>&nbsp;
                  <input type="text" style="width:70%" name="visitnote_clinical_finding" value="<?php echo $visitnote_clinical_finding[0];?>" />
                  <br />
                  <b><?php xl('SPECIFIC TEACHING/TRAINING THIS VISIT','e')?></b>&nbsp;
                  <input type="text" style="width:62%" name="visitnote_training_visit" value="<?php echo $visitnote_training_visit[0];?>" />
                  <br />
                  <b><?php xl('PATIENT/CAREGIVER/FAMILY RESPONSE TO TRAINING','e')?></b>
                  <input type="checkbox" value="Verbalized Understanding" name="visitnote_response_to_training[]" <?php if(in_array("Verbalized Understanding",$visitnote_response_to_training)) echo "checked"; ?> />
                  <?php xl('Verbalized Understanding','e')?>
                  <input type="checkbox" value="Demonstrated Task" name="visitnote_response_to_training[]" <?php if(in_array("Demonstrated Task",$visitnote_response_to_training)) echo "checked"; ?> />
                  <?php xl('Demonstrated Task','e')?>
                  <input type="checkbox" value="Needed Guidance/Re-Instruction" name="visitnote_response_to_training[]" <?php if(in_array("Needed Guidance/Re-Instruction",$visitnote_response_to_training)) echo "checked"; ?> />
                  <?php xl('Needed Guidance/Re-Instruction','e')?><span class="padd"><?php xl('Other','e')?></span>&nbsp;
                  <input type="text" style="width:81%" name="visitnote_response_to_training_other" value="<?php echo $visitnote_response_to_training_other[0];?>" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('Has the patient had any falls since the last visit?','e')?></strong>
                  <input type="checkbox" value="Yes" name="visitnote_fall_since_last_visit" <?php if(in_array("Yes",$visitnote_fall_since_last_visit)) echo "checked"; ?> />
                  <?php xl('Yes','e')?>
                  <input type="checkbox" value="No" name="visitnote_fall_since_last_visit" <?php if(in_array("No",$visitnote_fall_since_last_visit)) echo "checked"; ?> />
                  <?php xl('No If yes, complete the Incident Report.','e')?> <br />
                  <strong><?php xl('Has the patient had any changes in medications since the last visit?','e')?></strong>
                  <input type="checkbox" value="Yes" name="visitnote_changes_in_medication" <?php if(in_array("Yes",$visitnote_changes_in_medication)) echo "checked"; ?> />
                 <?php xl('Yes','e')?>
                  <input type="checkbox" value="No" name="visitnote_changes_in_medication" <?php if(in_array("No",$visitnote_changes_in_medication)) echo "checked"; ?> />
                  <?php xl('No If yes, update the medication profile','e')?> <br />
                  <strong><?php xl('Plan for Next Visit','e')?></strong>
                  <input type="checkbox" value="Current Treatment Plan Frequency and Duration is Appropriate" name="visitnote_plot_for_next_visit" <?php if(in_array("Current Treatment Plan Frequency and Duration is Appropriate",$visitnote_plot_for_next_visit)) echo "checked"; ?> />
                  <?php xl('Current Treatment Plan Frequency and Duration is Appropriate','e')?>
                  <input type="checkbox" value="Initiate Discharge, physician order and summary of treatment" name="visitnote_plot_for_next_visit" <?php if(in_array("Initiate Discharge, physician order and summary of treatment",$visitnote_plot_for_next_visit)) echo "checked"; ?> />
                  <?php xl('Initiate Discharge, physician order and summary of treatment','e')?>
                  <input type="checkbox" value="Modify Care Plan to include" name="visitnote_plot_for_next_visit" <?php if(in_array("Modify Care Plan to include",$visitnote_plot_for_next_visit)) echo "checked"; ?> />
                  <?php xl('Modify Care Plan to include','e')?>
                  <input type="text" style="width:65%" name="visitnote_plot_for_next_visit_other" value="<?php echo $visitnote_plot_for_next_visit_other[0];?>" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('SUPERVISOR VISITS','e')?></strong>
                  <input type="checkbox" value="LPN/LVN" name="visitnote_supervisor_visit" <?php if(in_array("LPN/LVN",$visitnote_supervisor_visit)) echo "checked"; ?> />
                  <?php xl('LPN/LVN (every 30 days)','e')?>
                  <input type="checkbox" value="HHA" name="visitnote_supervisor_visit" <?php if(in_array("HHA",$visitnote_supervisor_visit)) echo "checked"; ?> />
                  <?php xl('HHA (every 14 days)','e')?> </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"><strong><?php xl('YES','e')?></strong></td>
                <td scope="row"><strong><?php xl('NO','e')?></strong></td>
                <td scope="row"><strong><?php xl('OBSERVATIONS','e')?></strong></td>
                <td scope="row"><strong><?php xl('YES','e')?></strong></td>
                <td scope="row"><strong><?php xl('NO','e')?></strong></td>
                <td scope="row"><strong><?php xl('OBSERVATIONS','e')?></strong></td>
              </tr>
              <tr>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_LPN_LVN_HHA_present" <?php if(in_array("YES",$visitnote_LPN_LVN_HHA_present)) echo "checked"; ?> /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_LPN_LVN_HHA_present" <?php if(in_array("NO",$visitnote_LPN_LVN_HHA_present)) echo "checked"; ?> /></td>
                <td scope="row"><?php xl('LPN/LVN or HHA present with this visit','e')?></td>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_Aware_of_patients_code_status" <?php if(in_array("YES",$visitnote_Aware_of_patients_code_status)) echo "checked"; ?> /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_Aware_of_patients_code_status" <?php if(in_array("NO",$visitnote_Aware_of_patients_code_status)) echo "checked"; ?> /></td>
                <td scope="row"><?php xl('Aware of patient\'s code status','e')?></td>
              </tr>
              <tr>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_Follows_Care_Plan" <?php if(in_array("YES",$visitnote_Follows_Care_Plan)) echo "checked"; ?> /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_Follows_Care_Plan" <?php if(in_array("NO",$visitnote_Follows_Care_Plan)) echo "checked"; ?> /></td>
                <td scope="row"><?php xl('Follows Care Plan','e')?></td>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_polite_courteous_and_respectful" <?php if(in_array("YES",$visitnote_polite_courteous_and_respectful)) echo "checked"; ?> /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_polite_courteous_and_respectful" <?php if(in_array("NO",$visitnote_polite_courteous_and_respectful)) echo "checked"; ?> /></td>
                <td scope="row"><?php xl('Was polite, courteous and respectful','e')?></td>
              </tr>
              <tr>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_time_necessary_to_meet_the_patients_needs" <?php if(in_array("YES",$visitnote_time_necessary_to_meet_the_patients_needs)) echo "checked"; ?> /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_time_necessary_to_meet_the_patients_needs" <?php if(in_array("NO",$visitnote_time_necessary_to_meet_the_patients_needs)) echo "checked"; ?> /></td>
                <td scope="row"><?php xl('Thorough and takes the time necessary to meet the patient\'s needs','e')?></td>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_clinical_skills_appropriate_to_patient_need" <?php if(in_array("YES",$visitnote_clinical_skills_appropriate_to_patient_need)) echo "checked"; ?> /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_clinical_skills_appropriate_to_patient_need" <?php if(in_array("NO",$visitnote_clinical_skills_appropriate_to_patient_need)) echo "checked"; ?> /></td>
                <td scope="row"><?php xl('Demonstrates clinical skills appropriate to patient need','e')?></td>
              </tr>
              <tr>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_Follows_Infection_Control_Procedures" <?php if(in_array("YES",$visitnote_Follows_Infection_Control_Procedures)) echo "checked"; ?> /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_Follows_Infection_Control_Procedures" <?php if(in_array("NO",$visitnote_Follows_Infection_Control_Procedures)) echo "checked"; ?> /></td>
                <td scope="row"><?php xl('Follows Infection Control Procedures including hand hygiene and bag technique','e')?></td>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_Identifies_patient_issues" <?php if(in_array("YES",$visitnote_Identifies_patient_issues)) echo "checked"; ?> /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_Identifies_patient_issues" <?php if(in_array("NO",$visitnote_Identifies_patient_issues)) echo "checked"; ?> /></td>
                <td scope="row"><?php xl('If applicable, Identifies patient issues during visit','e')?></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"><b><?php xl('Additional Instruction/Training provided to LPN/LVN or HHA this visit','e')?></b><textarea name="visitnote_Additional_Instruction" rows="3" cols="98"><?php echo $visitnote_Additional_Instruction[0];?></textarea></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('NURSING IS CURRENTLY PROVIDING WOUND CARE','e')?></strong>
                  <input type="checkbox" value="YES" name="visitnote_Providing_wound" <?php if(in_array("YES",$visitnote_Providing_wound)) echo "checked"; ?> />
                  <?php xl('YES','e')?>
                  <input type="checkbox" value="NO" name="visitnote_Providing_wound" <?php if(in_array("NO",$visitnote_Providing_wound)) echo "checked"; ?> />
                  <?php xl('NO IF YES scroll down','e')?> </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('Therapist Signature (Name/Title)','e')?></strong>
                  <strong><?php xl('Electronic Signature','e')?></strong> </td>
              </tr>
            </table></td>
        </tr>
      </table>
	    
	  <?php
	  
/* include api.inc. also required. */
require_once($GLOBALS['srcdir'].'/api.inc');

/* include our smarty derived controller class. */
require($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');

/* Create a form object. */
$c = new C_FormPainMap('nursing_visitnote','painmap.png');

/* Render a 'new form' page. */
echo $c->view_action($_GET['id']);
	  ?>
	  
	 <table width="100%" border="1px" cellspacing="0px" cellpadding="2px" class="formtable">
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
    <td rowspan="12"><textarea name="wound_Interventions" cols="30" rows="15"><?php echo $wound_Interventions[0];?></textarea></td>
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

<table width="100%" border="1px" cellspacing="0px" cellpadding="2px" class="formtable">
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
<input type="checkbox" name="careplan_SN_WC_status" value="Yes" id="careplan_SN_WC_status"  <?php if(in_array("Yes",$careplan_SN_WC_status)) echo "checked"; ?>  />
<?php xl('Yes','e'); ?>
<input type="checkbox" name="careplan_SN_WC_status" value="No" id="careplan_SN_WC_status"  <?php if(in_array("No",$careplan_SN_WC_status)) echo "checked"; ?>  />
<?php xl('No','e'); ?> 
<br>&nbsp;
<?php xl('If, No explain','e'); ?> 
&nbsp;
<input type="text" style="width:72%" name="careplan_SN_provide_wound_care" id="careplan_SN_provide_wound_care" value="<?php echo stripslashes($careplan_SN_provide_wound_care[0]);?>"/>
</td>
<td width="50%">
<?php xl('Physician is notified every two weeks of wound status','e')?>
<br>&nbsp;
<input type="text" style="width:90%" name="careplan_SN_wound_status" id="careplan_SN_wound_status"  value="<?php echo stripslashes($careplan_SN_wound_status[0]);?>"/>
</td>
</tr></table>	 
      <a id="btn_save" href="javascript:void(0)" class="link_submit" onClick="return requiredCheck()"><?php xl(' [Save]','e')?></a>
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

	
