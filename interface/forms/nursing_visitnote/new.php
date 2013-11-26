<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: nursing_visitnote");
?>
<html>
<head>
<title>
<?php xl('SKILLED NURSING CARE PLAN','e')?>
</title>
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
<style type="text/css">
@import url(<?php echo $GLOBALS['webroot']?>/library/dynarch_calendar.css);
</style>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/css/jquery-ui-1.8.21.custom.css" type="text/css" media="all" />
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

<body>
<form method="post" id="submitForm"
		action="<?php echo $rootdir;?>/forms/nursing_visitnote/save.php?mode=new" name="nursing_visitnote" onSubmit="return top.restoreSession();" enctype="multipart/form-data">
  <h3 align="center">
    <?php xl('SKILLED NURSE VISIT NOTE','e')?>
  </h3>

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
          <td width="9%"><select name="visitnote_Time_In" id="Visitnote_Time_In">
              <?php timeDropDown($GLOBALS['Selected']) ?>
            </select></td>
          <td width="5%"><strong>
            <?php xl('Time Out','e'); ?>
            </strong></td>
          <td width="9%"><select name="visitnote_Time_Out" id="Visitnote_Time_Out">
              <?php timeDropDown($GLOBALS['Selected']) ?>
            </select></td>
          <td width="5%" align="center"><strong>
            <?php xl('Encounter Date','e')?>
            </strong></td>
          <td width="10%" ><input type='text' size='10' name='Visitnote_Evaluation_date' id='Visitnote_Evaluation_date' 
					title='<?php xl('Encounter Date','e'); ?>'
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
          <input type="checkbox" value="Visit" name="visitnote_type_of_visit" />
          <?php xl('Visit','e'); ?>
          <input type="checkbox" value="Visit and Supervisory Review Other" name="visitnote_type_of_visit" />
          <?php xl('Visit and Supervisory Review','e'); ?>
          <span class="padd"><strong>
          <?php xl('Other','e'); ?>
          </strong>
          <input type="text" size="55" name="visitnote_type_of_visit_other" />
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
            <input type="text" size="15" name="visitnote_Pulse" />
            <span class="padd">
            <input type="checkbox" value="Regular" name="visitnote_Pulse_State" />
            <?php xl('Regular','e'); ?>
            <input type="checkbox" value="Irregular" name="visitnote_Pulse_State" />
            Irregular</span> <span class="padd"><?php xl('Temperature','e'); ?>
            <input type="text" size="15" name="visitnote_Temperature" />
            </span> <span class="padd">
            <input type="checkbox" value="Oral" name="visitnote_Temperature_type" />
            <?php xl('Oral','e'); ?>
            <input type="checkbox" value="Temporal" name="visitnote_Temperature_type" />
           <?php xl(' Temporal','e'); ?></span> <span class="padd"><strong><?php xl('Other','e'); ?></strong>
            <input type="text" size="15" name="visitnote_VS_other" />
            </span> <span class="padd"><?php xl('Respirations','e'); ?>
            <input type="text" size="15" name="visitnote_VS_Respirations" />
            </span> <span class="padd"><?php xl('Blood Pressure Systolic','e'); ?>
            <input type="text" size="15" name="visitnote_VS_BP_Systolic" />
            /
            <input type="text" size="15" name="visitnote_VS_BP_Diastolic" />
            <?php xl('Diastolic','e'); ?></span> <span class="padd">
            <input type="checkbox" value="Right" name="visitnote_VS_BP_Body_side[]" />
            <?php xl('Right','e'); ?>
            <input type="checkbox" value="Left" name="visitnote_VS_BP_Body_side[]" />
            <?php xl('Left','e'); ?></span> <span class="padd">
            <input type="checkbox" value="Sitting" name="visitnote_VS_BP_Body_Position[]" />
            <?php xl('Sitting','e'); ?>
            <input type="checkbox" value="Standing" name="visitnote_VS_BP_Body_Position[]" />
            <?php xl('Standing','e'); ?>
            <input type="checkbox" value="Lying" name="visitnote_VS_BP_Body_Position[]" />
            <?php xl('Lying','e'); ?></span> <span class="padd"><strong>*O<sup>2</sup> Sat</strong>
            <input type="text" size="15" name="visitnote_VS_Sat" />
            <span> <strong>*<?php xl('Physician ordered','e')?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
        <tr>
          <td scope="row"> <b><?php xl('Pain','e')?></b>
            <input type="checkbox" value="No Pain" name="visitnote_VS_Pain" />
            <?php xl('No Pain','e')?>
            <input type="checkbox" value="Pain limits functional ability" name="visitnote_VS_Pain" />
            <?php xl('Pain limits functional ability','e')?>  <span class="padd"><strong><?php xl('Intensity','e')?> </strong>
            <input type="text" size="15" name="visitnote_VS_Pain_Intensity" />
            </span> <span class="padd">
            <input type="checkbox" value="Improve" name="visitnote_VS_condition" />
            <?php xl('Improve','e')?>
            <input type="checkbox" value="Worse" name="visitnote_VS_condition" />
            <?php xl('Worse','e')?>
            <input type="checkbox" value="No Change" name="visitnote_VS_condition" />
            <?php xl('No Change','e')?> </span><span class="padd">
            <input type="text" size="15" name="visitnote_VS_Condition_other" />
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
				<input type="text" id="visitnote_VS_Diagnosis" name="visitnote_VS_Diagnosis" style="width:100%;"/>	
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
        <tr>
          <td scope="row"> <strong><?php xl('PATIENT CONTINUES TO BE HOMEBOUND DUE TO','e')?></strong>
            <input type="checkbox" value="Bed Bound" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Bed Bound','e')?>
            <input type="checkbox" value="Impaired Mobility" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Impaired Mobility','e')?>
            <input type="checkbox" value="No Pain" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Incontinent','e')?>
            <input type="checkbox" value="Immunosuppressed" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Immunosuppressed','e')?>
            <input type="checkbox" value="Medical Restrictions in" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Medical Restrictions in','e')?>
            <input type="text" size="15" name="visitnote_HR_Patient_Restriction" />
            <input type="checkbox" value="Needs assistance in all activities of daily living" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Needs assistance in all activities of daily living','e')?>
            <input type="checkbox" value="Recent Hospital Stay" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Recent Hospital Stay','e')?>
            <input type="checkbox" value="Residual Weakness" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Residual Weakness','e')?>
            <input type="checkbox" value="Severe Dyspnea" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Severe Dyspnea','e')?>
            <input type="checkbox" value="Severe Pain" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Severe Pain','e')?>
            <input type="checkbox" value="SOB upon exertion" name="visitnote_HR_Home_Bound[]" />
            <?php xl('SOB upon exertion','e')?>
            <input type="checkbox" value="Unable to leave home safely without assistance" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Unable to leave home safely without assistance','e')?>
            <input type="checkbox" value="Wound" name="visitnote_HR_Home_Bound[]" />
            <?php xl('Wound','e')?> <span class="padd">
			<br>
			<?php xl('Other','e')?>
            <input type="text" style="width:75%" name="visitnote_HR_others" />
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
                  <input type="checkbox" value="Medication Management" name="visitnote_Cardiovascular[]" />
                  <?php xl('Medication Management','e')?>
                  <input type="checkbox" value="Hypertension" name="visitnote_Cardiovascular[]" />
                  <?php xl('Hypertension','e')?>
                  <input type="checkbox" value="Hypotension" name="visitnote_Cardiovascular[]" />
                  <?php xl('Hypotension','e')?>
                  <input type="checkbox" value="Peripheral Pulses" name="visitnote_Cardiovascular[]" />
                  <?php xl('Peripheral Pulses','e')?>
                  <input type="checkbox" value="Abnormal Lung Sounds" name="visitnote_Cardiovascular[]" />
                  <?php xl('Abnormal Lung Sounds','e')?>
                  <input type="checkbox" value="Patient Weight Gain/Loss" name="visitnote_Cardiovascular[]" />
                  <?php xl('Patient Weight Gain/Loss','e')?>
                  <input type="checkbox" value="Abnormal Heart Sounds" name="visitnote_Cardiovascular[]" />
                  <?php xl('Abnormal Heart Sounds','e')?>
                  <input type="checkbox" value="Chest Pain" name="visitnote_Cardiovascular[]" />
                  <?php xl('Chest Pain','e')?>
                  <input type="checkbox" value="Edema/Fluid Retention" name="visitnote_Cardiovascular[]" />
                  <?php xl('Edema/Fluid Retention','e')?> <span class="padd">
				  <br>
				  <?php xl('Other','e')?>
                  <input type="text" style="width:75%" name="visitnote_Cardiovascular_other" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('ENDOCRINE','e')?></strong>
                  <input type="checkbox" value="Diabetic Type I" name="visitnote_endocrine[]" />
                  <?php xl('Diabetic Type I','e')?>
                  <input type="checkbox" value="Diabetic Type 2" name="visitnote_endocrine[]" />
                  <?php xl('Diabetic Type 2','e')?>
                  <input type="checkbox" value="Diet/Oral Controlled" name="visitnote_endocrine[]" />
                  <?php xl('Diet/Oral Controlled','e')?>
                  <input type="checkbox" value="Insulin Controlled" name="visitnote_endocrine[]" />
                  <?php xl('Insulin Controlled','e')?>
                  <input type="checkbox" value="Hyploglycemia" name="visitnote_endocrine[]" />
                  <?php xl('Hyploglycemia','e')?>
                  <input type="checkbox" value="Hyperglycemia Insulin Administered by" name="visitnote_endocrine[]" />
                  <?php xl('Hyperglycemia Insulin Administered by','e')?>
                  <input type="checkbox" value="Self" name="visitnote_endocrine[]" />
                  <?php xl('Self','e')?>
                  <input type="checkbox" value="Caregiver" name="visitnote_endocrine[]" />
                  <?php xl('Caregiver','e')?>
                  <input type="checkbox" value="Nurse" name="visitnote_endocrine[]" />
                  <?php xl('Nurse','e')?>&nbsp;&nbsp;<?php xl('Other','e')?>
                  <input type="text" size="15" name="visitnote_endocrine_other" />&nbsp;
                  <input type="checkbox" value="Weight Loss/Gain" name="visitnote_endocrine[]" />
                  <?php xl('Weight Loss/Gain','e')?>
                  <input type="checkbox" value="Diet Compliance Blood Sugar Ranges" name="visitnote_endocrine[]" />
                   <?php xl('Diet Compliance','e')?> <span class="padd"><?php xl('Blood Sugar Ranges','e')?></span>
                  <input type="text" size="15" name="visitnote_endocrine_blood_sugar" />
                  <?php xl('Frequency of Monitoring','e')?>
                  <input type="text" size="15" name="visitnote_endocrine_frequency" />
                  <?php xl('Current Complications/ Risk Factors','e')?>
                  <input type="checkbox" value="None" name="visitnote_endocrine[]" />
                  <?php xl('None','e')?>
                  <input type="text" size="15" name="visitnote_endocrine_Risk_Factors" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('GASTROINTESTINAL','e')?></strong>
                  <input type="checkbox" value="GT Management/Site" name="visitnote_Gastrointestinal[]" />
                  <?php xl('GT Management/Site','e')?>
                  <input type="checkbox" value="Ostomy Management" name="visitnote_Gastrointestinal[]" />
                  <?php xl('Ostomy Management/Site','e')?>
                  <input type="checkbox" value="Bowel Sounds x4" name="visitnote_Gastrointestinal[]" />
                  <?php xl('Bowel Sounds x4','e')?>
                  <input type="checkbox" value="Last BM" name="visitnote_Gastrointestinal[]" />
                  <?php xl('Last BM','e')?>
                  <input type="text" style="width:10%" name="visitnote_Gastrointestinal_bm_date" id="visitnote_Gastrointestinal_bm_date" 
					 value="<?php echo stripslashes($visitnote_Gastrointestinal_bm_date[0]);?>" title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_onset_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
					Calendar.setup({inputField:"visitnote_Gastrointestinal_bm_date", ifFormat:"%Y-%m-%d", button:"img_onset_date"});
					</script> <br />
                  <input type="checkbox" value="Diarrhea/Vomiting" name="visitnote_Gastrointestinal[]" />
                  <?php xl('Diarrhea/Vomiting','e')?>
                  <input type="checkbox" value="Nausea/Vomiting" name="visitnote_Gastrointestinal[]" />
                 <?php xl('Nausea/Vomiting','e')?>
                  <input type="checkbox" value="ABD Distention" name="visitnote_Gastrointestinal[]" />
                  <?php xl('ABD Distention','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text"  style="width:45%" name="visitnote_Gastrointestinal_other" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('GENITOURINARY','e')?></strong>
                  <input type="checkbox" value="Nutrition/Hydration" name="visitnote_Genitourinary" />
                  <?php xl('Nutrition/Hydration','e')?> <span class="padd"><?php xl('Incontinence:','e')?>
                  <input type="checkbox" value="Bowel" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Bowel','e')?>
                  <input type="checkbox" value="Bladder" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Bladder','e')?>
                  <input type="checkbox" value="Urge" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Urge','e')?>
                  <input type="checkbox" value="Stress" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Stress','e')?>
                  <input type="checkbox" value="Urinary Retention" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Urinary Retention','e')?>
                  <input type="checkbox" value="Foley Catheter" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Foley Catheter','e')?>
                  <input type="checkbox" value="Urine Discolored" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Urine Discolored','e')?>
                  <input type="checkbox" value="Pain/Burning" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Pain/Burning','e')?>
                  <input type="checkbox" value="Feeling unable to Empty Bladder" name="visitnote_Genitourinary_Incontinence[]" />
                  <?php xl('Feeling unable to Empty Bladder','e')?></span> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:30%"  name="visitnote_Genitourinary_others" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('INTEGUMENTARY','e')?></strong>
                  <input type="checkbox" value="Normal" name="visitnote_Integumentary[]" />
                  <?php xl('Normal','e')?>
                  <input type="checkbox" value="Dry" name="visitnote_Integumentary[]" />
                  <?php xl('Dry','e')?>
                  <input type="checkbox" value="Warm" name="visitnote_Integumentary[]" />
                  <?php xl('Warm','e')?>
                  <input type="checkbox" value="Cold" name="visitnote_Integumentary[]" />
                  <?php xl('Cold','e')?>
                  <input type="checkbox" value="Pale" name="visitnote_Integumentary[]" />
                  <?php xl('Pale','e')?>
                  <input type="checkbox" value="Diaphoretic" name="visitnote_Integumentary[]" />
                  <?php xl('Diaphoretic','e')?>
                  <input type="checkbox" value="Rash" name="visitnote_Integumentary[]" />
                  <?php xl('Rash','e')?>
                  <input type="checkbox" value="Lesion" name="visitnote_Integumentary[]" />
                  <?php xl('Lesion','e')?>
                  <input type="checkbox" value="Turgor" name="visitnote_Integumentary[]" />
                  <?php xl('Turgor','e')?>
                  <input type="checkbox" value="Skin Tears" name="visitnote_Integumentary[]" /> <br />
                  <?php xl('Skin Tears','e')?>
                  <input type="checkbox" value="Wound" name="visitnote_Integumentary[]" />
                  <?php xl('Wound(s) (Refer to Assessment)','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:55%" name="visitnote_Integumentary_other" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('MENTAL/EMOTIONAL Oriented to:','e')?></strong>
                  <input type="checkbox" value="Person" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Person','e')?>
                  <input type="checkbox" value="Place" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Place','e')?>
                  <input type="checkbox" value="Date" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Date','e')?>
                  <span class="padd"><input type="checkbox" value="Disoriented" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Disoriented','e')?></span>
                  <input type="checkbox" value="Cooperative" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Cooperative','e')?>
                  <input type="checkbox" value="Uncooperative" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Uncooperative','e')?>
                  <input type="checkbox" value="Forgetful" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Forgetful','e')?>
                  <input type="checkbox" value="Anxious" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Anxious','e')?>
                  <input type="checkbox" value="Agitated" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Agitated','e')?>
                  <input type="checkbox" value="Depressed" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Depressed','e')?>
                  <input type="checkbox" value="Withdrawn" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Withdrawn','e')?>
                  <input type="checkbox" value="Delusional Thinking" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Delusional Thinking','e')?>
                  <input type="checkbox" value="Fearful" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Fearful','e')?>
                  <input type="checkbox" value="Lethargic" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Lethargic','e')?>
                  <input type="checkbox" value="Hallucinations" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Hallucinations','e')?>
                  <input type="checkbox" value="Social" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Social','e')?>
                  <input type="checkbox" value="Isolative" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Isolative','e')?>
                  <input type="checkbox" value="Paranoid" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Paranoid','e')?>
                  <input type="checkbox" value="Suicidal Ideation/Suicidal" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Suicidal Ideation/Suicidal','e')?>
                  <input type="checkbox" value="Labile" name="visitnote_Mental_Emotional[]" />
                  <?php xl('Labile','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:45%" name="visitnote_Mental_Emotional_other" />
                  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('MUSCULOSKELETAL/MOBILITY Weight Bearing Status (WB):','e')?></strong>
                  <input type="checkbox" value="Full-WB" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Full-WB','e')?>
                  <input type="checkbox" value="Non-WB" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Non-WB','e')?>
                  <input type="checkbox" value="Partial WB" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Partial WB','e')?>
                  <input type="checkbox" value="Poor Strength" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Poor Strength','e')?>
                  <input type="checkbox" value="Poor Endurance" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Poor Endurance','e')?>
                  <input type="checkbox" value="Limited Range of Motion (ROM)" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Limited Range of Motion (ROM)','e')?>
                  <input type="text" size="15" name="visitnote_Musculoskeletal_ROM" />
                  <input type="checkbox" value="Walking Steady" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Walking Steady','e')?>
                  <input type="checkbox" value="Walking Unsteady" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Walking Unsteady','e')?>
                  <input type="checkbox" value="Pain With Movement" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Pain With Movement','e')?>
                  <input type="checkbox" value="Wears Prosthetic" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Wears Prosthetic','e')?>
                  <input type="checkbox" value="Wears Orthotic" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Wears Orthotic','e')?>
                  <input type="checkbox" value="Transfers With Assist" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Transfers With Assist','e')?>
                  <input type="checkbox" value="Transfers Without Assist" name="visitnote_Musculoskeletal[]" />
                  <?php xl('Transfers Without Assist','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:23%" name="visitnote_Musculoskeletal_other" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('NEUROLOGICAL','e')?></strong>
                  <input type="checkbox" value="Alert" name="visitnote_Neurological[]" />
                  <?php xl('Alert','e')?>
                  <input type="checkbox" value="Not Alert" name="visitnote_Neurological[]" />
                  <?php xl('Not Alert','e')?>
                  <input type="checkbox" value="Visual Impairment" name="visitnote_Neurological[]" />
                  <?php xl('Visual Impairment','e')?>
                  <input type="checkbox" value="Hearing Impairment" name="visitnote_Neurological[]" />
                  <?php xl('Hearing Impairment','e')?>
                  <input type="checkbox" value="Unilateral Weakness" name="visitnote_Neurological[]" />
                  <?php xl('Unilateral Weakness','e')?>
                  <input type="checkbox" value="Bilateral Weakness" name="visitnote_Neurological[]" />
                  <?php xl('Bilateral Weakness','e')?>
                  <input type="checkbox" value="Speech Enunciation Difficulty" name="visitnote_Neurological[]" />
                  <?php xl('Speech Enunciation Difficulty','e')?>
                  <input type="checkbox" value="Speech Comprehension Difficulty" name="visitnote_Neurological[]" />
                  <?php xl('Speech Comprehension Difficulty','e')?>
                  <input type="checkbox" value="Swallowing Difficulty" name="visitnote_Neurological[]" />
                  <?php xl('Swallowing Difficulty','e')?>
                  <input type="checkbox" value="Seizure Activity" name="visitnote_Neurological[]" />
                  <?php xl('Seizure Activity','e')?> <span class="padd"><br><?php xl('Other','e')?>
                  <input type="text" style="width:75%" name="visitnote_Neurological_other" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('RESPIRATORY','e')?></strong>
                  <input type="checkbox" value="Lung Sounds Clear" name="visitnote_Respiratory[]" />
                  <?php xl('Lung Sounds Clear','e')?>
                  <input type="checkbox" value="Abnormal Breath Sounds" name="visitnote_Respiratory[]" />
                  <?php xl('Abnormal Breath Sounds','e')?>
                  <input type="checkbox" value="Cough/Sputum" name="visitnote_Respiratory[]" />
                  <?php xl('Cough/Sputum','e')?>
                  <input type="checkbox" value="O2 Liters" name="visitnote_Respiratory[]" />
                  <?php xl('O2 Liters','e')?>
                  <input type="text" size="15" name="visitnote_Respiratory_liters" />
                  <input type="checkbox" value="Pallor/Cyanosis" name="visitnote_Respiratory[]" />
                  <?php xl('Pallor/Cyanosis','e')?>
                  <input type="checkbox" value="Respiration Labored" name="visitnote_Respiratory[]" />
                  <?php xl('Respiration Labored','e')?>
                  <input type="checkbox" value="Respiration Unlabored Other" name="visitnote_Respiratory[]" />
                  <?php xl('Respiration Unlabored','e')?><span class="padd"><?php xl('Other','e')?></span>&nbsp;
                  <input type="text" style="width:41%" name="visitnote_Respiratory_other" />
                  <?php xl('(see above for O2 Sat)','e')?> </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"><strong><?php xl(' GENERAL MEDICAL','e')?></strong>
                  <input type="checkbox" value="Appetite" name="visitnote_General_medical[]" />
                  <?php xl('Appetite','e')?>
                  <input type="checkbox" value="Weight Gain" name="visitnote_General_medical[]" />
                  <?php xl('Weight Gain','e')?>
                  <input type="text" size="15" name="visitnote_General_medical_lbs1" />
                  <?php xl('lbs','e')?>
                  <input type="checkbox" value="Weight Loss" name="visitnote_General_medical[]" />
                  <?php xl('Weight Loss','e')?>
                  <input type="text" size="15" name="visitnote_General_medical_lbs2" />
                  <?php xl('lbs','e')?>
                  <input type="checkbox" value="Medication Mgt" name="visitnote_General_medical[]" />
                  <?php xl('Medication Mgt','e')?><br><?php xl('Other','e')?>
                  <input type="text" style="width:75%" name="visitnote_General_medical_other" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('SERVICES PROVIDED to','e')?></strong>
                  <input type="checkbox" value="Patient" name="visitnote_services_provided[]" />
                  <?php xl('Patient','e')?>
                  <input type="checkbox" value="Caregiver" name="visitnote_services_provided[]" />
                  <?php xl('Caregiver','e')?> <span class="padd"><?php xl('Other','e')?>
                  <input type="text" style="width:20%" name="visitnote_services_provided_other" />
                  <strong><?php xl('G-Codes','e')?></strong>
                  <input type="text" style="width:20%" name="visitnote_g_codes" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row" width="50%"><input type="checkbox" value="G0154-Direct skilled services of a LPN/LVN or RN" name="visitnote_services_provided_options[]" />
                  <?php xl('<b>G0154</b>-Direct skilled services of a LPN/LVN or RN','e')?> <br />
                  <input type="checkbox" value="G0162-RN management and evaluation of plan of care" name="visitnote_services_provided_options[]" />
                  <?php xl('<b>G0162</b>-RN management and evaluation of plan of care','e')?> <br />
                  <input type="checkbox" value="G0163- LPN/LVN or RN for observation and assessment of organ system" name="visitnote_services_provided_options[]" />
                  <?php xl('<b>G0163</b>- LPN/LVN or RN for observation and assessment of organ system','e')?> </td>
                <td scope="row"><input type="checkbox" value="G0164 RN Training and Education in" name="visitnote_services_provided_options[]" />
                  <?php xl('<b>G0164</b> RN Training and Education in','e')?>
                  <table style="padding-left:15px;"><tr><td width="75%"><input type="checkbox" value="Medication Management" name="visitnote_RN_Training_and_Education[]" />
                 <?php xl('Medication Management','e')?> <br />
                  <input type="checkbox" value="Disease Management" name="visitnote_RN_Training_and_Education[]" />
                  <?php xl('Disease Management','e')?>
                  <input type="checkbox" value="Wound Care" name="visitnote_RN_Training_and_Education[]" />
                  <?php xl('Wound Care','e')?> <br />
                  <input type="checkbox" value="Diet Management" name="visitnote_RN_Training_and_Education[]" />
                  <?php xl('Diet Management','e')?>
                  <input type="checkbox" value="Oxygen Management" name="visitnote_RN_Training_and_Education[]" />
                  <?php xl('Oxygen Management','e')?>
                  <br><?php xl('Other','e')?>
                  <input type="text" style="width:85%" name="visitnote_services_provided_options_other" />
				  </td></tr></table>
				  </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('CLINICAL FINDINGS THIS VISIT','e')?></strong>&nbsp;
                  <input type="text" style="width:70%" name="visitnote_clinical_finding" />
                  <br />
                  <b><?php xl('SPECIFIC TEACHING/TRAINING THIS VISIT','e')?></b>&nbsp;
                  <input type="text" style="width:62%" name="visitnote_training_visit" />
                  <br />
                  <b><?php xl('PATIENT/CAREGIVER/FAMILY RESPONSE TO TRAINING','e')?></b>
                  <input type="checkbox" value="Verbalized Understanding" name="visitnote_response_to_training[]" />
                  <?php xl('Verbalized Understanding','e')?>
                  <input type="checkbox" value="Demonstrated Task" name="visitnote_response_to_training[]" />
                  <?php xl('Demonstrated Task','e')?>
                  <input type="checkbox" value="Needed Guidance/Re-Instruction" name="visitnote_response_to_training[]" />
                  <?php xl('Needed Guidance/Re-Instruction','e')?><span class="padd"><?php xl('Other','e')?></span>&nbsp;
                  <input type="text" style="width:81%" name="visitnote_response_to_training_other" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('Has the patient had any falls since the last visit?','e')?></strong>
                  <input type="checkbox" value="Yes" name="visitnote_fall_since_last_visit" />
                  <?php xl('Yes','e')?>
                  <input type="checkbox" value="No" name="visitnote_fall_since_last_visit" />
                  <?php xl('No If yes, complete the Incident Report.','e')?> <br />
                  <strong><?php xl('Has the patient had any changes in medications since the last visit?','e')?></strong>
                  <input type="checkbox" value="Yes" name="visitnote_changes_in_medication" />
                 <?php xl('Yes','e')?>
                  <input type="checkbox" value="No" name="visitnote_changes_in_medication" />
                  <?php xl('No If yes, update the medication profile','e')?> <br />
                  <strong><?php xl('Plan for Next Visit','e')?></strong>
                  <input type="checkbox" value="Current Treatment Plan Frequency and Duration is Appropriate" name="visitnote_plot_for_next_visit" />
                  <?php xl('Current Treatment Plan Frequency and Duration is Appropriate','e')?>
                  <input type="checkbox" value="Initiate Discharge, physician order and summary of treatment" name="visitnote_plot_for_next_visit" />
                  <?php xl('Initiate Discharge, physician order and summary of treatment','e')?>
                  <input type="checkbox" value="Modify Care Plan to include" name="visitnote_plot_for_next_visit" />
                  <?php xl('Modify Care Plan to include','e')?>
                  <input type="text" style="width:65%" name="visitnote_plot_for_next_visit_other" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('SUPERVISOR VISITS','e')?></strong>
                  <input type="checkbox" value="LPN/LVN" name="visitnote_supervisor_visit" />
                  <?php xl('LPN/LVN (every 30 days)','e')?>
                  <input type="checkbox" value="HHA" name="visitnote_supervisor_visit" />
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
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_LPN_LVN_HHA_present" /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_LPN_LVN_HHA_present" /></td>
                <td scope="row"><?php xl('LPN/LVN or HHA present with this visit','e')?></td>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_Aware_of_patients_code_status" /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_Aware_of_patients_code_status" /></td>
                <td scope="row"><?php xl('Aware of patient\'s code status','e')?></td>
              </tr>
              <tr>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_Follows_Care_Plan" /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_Follows_Care_Plan" /></td>
                <td scope="row"><?php xl('Follows Care Plan','e')?></td>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_polite_courteous_and_respectful" /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_polite_courteous_and_respectful" /></td>
                <td scope="row"><?php xl('Was polite, courteous and respectful','e')?></td>
              </tr>
              <tr>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_time_necessary_to_meet_the_patients_needs" /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_time_necessary_to_meet_the_patients_needs" /></td>
                <td scope="row"><?php xl('Thorough and takes the time necessary to meet the patient\'s needs','e')?></td>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_clinical_skills_appropriate_to_patient_need" /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_clinical_skills_appropriate_to_patient_need" /></td>
                <td scope="row"><?php xl('Demonstrates clinical skills appropriate to patient need','e')?></td>
              </tr>
              <tr>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_Follows_Infection_Control_Procedures" /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_Follows_Infection_Control_Procedures" /></td>
                <td scope="row"><?php xl('Follows Infection Control Procedures including hand hygiene and bag technique','e')?></td>
                <td scope="row"><input type="checkbox" value="YES" name="visitnote_Identifies_patient_issues" /></td>
                <td scope="row"><input type="checkbox" value="NO" name="visitnote_Identifies_patient_issues" /></td>
                <td scope="row"><?php xl('If applicable, Identifies patient issues during visit','e')?></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"><b><?php xl('Additional Instruction/Training provided to LPN/LVN or HHA this visit','e')?></b><textarea name="visitnote_Additional_Instruction" rows="3" cols="98"></textarea></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td scope="row"><table width="100%" align="center"  border="1px" cellspacing="0px" cellpadding="5px">
              <tr>
                <td scope="row"> <strong><?php xl('NURSING IS CURRENTLY PROVIDING WOUND CARE','e')?></strong>
                  <input type="checkbox" value="YES" name="visitnote_Providing_wound" />
                  <?php xl('YES','e')?>
                  <input type="checkbox" value="NO" name="visitnote_Providing_wound" />
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
echo $c->default_action();
	  ?>
	  <table width="100%" border="1px" cellspacing="0px" cellpadding="2px" class="formtable">
	  	<tr>
	 <th scope="row"><?php xl('Wound','e')?>
	 <td align="center"><strong><?php xl('1','e')?></strong></td>
	 <td align="center"><strong><?php xl('2','e')?></strong></td>
	 <td align="center"><strong><?php xl('3','e')?></strong></td>
	 <td align="center"><strong><?php xl('4','e')?></strong></td>
	 <td align="center"><strong><?php xl('Comments','e')?></strong></td>
	</tr>
  <tr>
    <th scope="row" align="right"><?php xl('Type of Wound','e')?><input type="hidden" name="wound_label[]" value="Type of Wound" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
    <td rowspan="12"><textarea name="wound_Interventions" cols="30" rows="15"></textarea></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Status','e')?><input type="hidden" name="wound_label[]" value="Wound Status" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Wound Measurements Length','e')?><input type="hidden" name="wound_label[]" value="Measurements Length" /><br />
<?php xl('Width','e')?> <input type="hidden" name="wound_label[]" value="Measurements Width" /> <br />
<?php xl('Depth','e')?> <input type="hidden" name="wound_label[]" value="Measurements Depth" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /> <br /><input name="wound_value1[]" type="text" size="12" /> <br /><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /> <br /><input name="wound_value2[]" type="text" size="12" /> <br /><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /> <br /><input name="wound_value3[]" type="text" size="12" /> <br /><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /> <br /><input name="wound_value4[]" type="text" size="12" /> <br /><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Pressure Sore Stage','e')?><input type="hidden" name="wound_label[]" value="Pressure Sore Stage" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tunneling','e')?><input type="hidden" name="wound_label[]" value="Tunneling" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Undermining','e')?><input type="hidden" name="wound_label[]" value="Undermining" /></th>
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
    <th scope="row" align="right"><?php xl('Tissue of Surround Wound','e')?><input type="hidden" name="wound_label[]" value="Tissue of Surround Wound" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Level of Pain with Wound','e')?><input type="hidden" name="wound_label[]" value="Level of Pain with Wound" /></th>
    <td><input name="wound_value1[]" type="text" size="12" /></td>
    <td><input name="wound_value2[]" type="text" size="12" /></td>
    <td><input name="wound_value3[]" type="text" size="12" /></td>
    <td><input name="wound_value4[]" type="text" size="12" /></td>
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
    <th scope="row" align="right"><?php xl('Type of Wound','e')?></th>
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
    <th scope="row" align="right"><?php xl('Wound Measurements Length','e')?><br />
<?php xl('Width','e')?><br />
<?php xl('Depth','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /> <br /><input name="wound_value5[]" type="text" size="12" /> <br /><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /> <br /><input name="wound_value6[]" type="text" size="12" /> <br /><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /> <br /><input name="wound_value7[]" type="text" size="12" /> <br /><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /> <br /><input name="wound_value8[]" type="text" size="12" /> <br /><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Pressure Sore Stage','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tunneling','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Undermining','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Drainage','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Amount of Drainage','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Odor','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Wound Base','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Tissue of Surround Wound','e')?></th>
    <td><input name="wound_value5[]" type="text" size="12" /></td>
    <td><input name="wound_value6[]" type="text" size="12" /></td>
    <td><input name="wound_value7[]" type="text" size="12" /></td>
    <td><input name="wound_value8[]" type="text" size="12" /></td>
  </tr>
  <tr>
    <th scope="row" align="right"><?php xl('Level of Pain with Wound','e')?></th>
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
      <a id="btn_save" href="javascript:void(0)" class="link_submit" onClick="return requiredCheck()">
      <?php xl(' [Save]','e')?>
      </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[
      <?php xl('Don\'t Save','e'); ?>
      ]</a>
</form>
</body>
</html>
