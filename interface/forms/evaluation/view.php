<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
?>
<html><head>
<?php html_header_show();?>
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
	<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
</head>
<body class="body_top">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_ot_Evaluation", $_GET["id"]);
?>
<form method=post action="<?php echo $rootdir?>/forms/evaluation/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="evaluation">
<span class="title"><?php xl('Evaluation','e');?></span><br></br>

<a href="javascript:top.restoreSession();document.evaluation.submit();" class="link_submit">[<?php xl('Save','e');?>]</a>
<br>
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save Changes','e');?>]</a>
<br></br>
<table align="center"  border="1" cellpadding="0px" cellspacing="0px">
  <tr>
    <td scope="row">
    <table width="100%" border="1" cellspacing="0px" cellpadding="5px">
        <tr>
          <td align="center" scope="row">
          <strong><?php xl('PATIENT NAME','e')?></strong></td>
         <td width="13%" align="center" valign="top"><input type="text"
					name="patient_name" id="patient_name" value="<?php patientName()?>"
					disabled /></td>
          <td align="center"><strong>MR#</strong></td>
         <td width="15%" align="center" valign="top" class="bold"><input
					type="text" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" disabled /></td>
          <td align="center"><strong>Date</strong></td>
         <td width="17%" align="center" valign="top" class="bold">
				<input type='text' size='10' name='Evaluation_date' id='Evaluation_date' 
				value='<?php echo stripslashes($obj{"Evaluation_date"});?>'
					title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);'  readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"Evaluation_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
				</td>
        </tr>
      </table>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td>
    <strong><?php xl('Vital Signs','e')?> </strong></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table border="0" cellspacing="0px"  cellpadding="5px"><tr>
    <td><?php xl('Pulse','e')?> <label for="pulse2"></label>

        <input type="text" name="Evaluation_Pulse" size="3px" id="Evaluation_Pulse"  value="<?php echo stripslashes($obj{"Evaluation_Pulse"});?>" >
        <label>
          <input type="checkbox" name="Evaluation_Pulse_State" value="Regular" id="Evaluation_Pulse_State" 
          <?php if ($obj{"Evaluation_Pulse_State"} == "Regular") echo "checked";;?>/>
                <?php xl('Regular','e')?></label>
      <label>
          <input type="checkbox" name="Evaluation_Pulse_State" value="Irregular" id="Evaluation_Pulse_State" 
          <?php if ($obj{"Evaluation_Pulse_State"} == "Irregular") echo "checked";;?>/>
          <?php xl('Irregular','e')?> &nbsp; <?php xl('Temperature','e')?> </label>

      <input type="text" size="3px" name="Evaluation_Temperature" id="Evaluation_Temperature" 
       value="<?php echo stripslashes($obj{"Evaluation_Temperature"});?>" />
       <input type="checkbox" name="Evaluation_Temperature_type" value="Oral" id="Evaluation_Temperature_type" 
        <?php if ($obj{"Evaluation_Temperature_type"} == "Oral") echo "checked";;?>/>
<?php xl('Oral','e')?>
<input type="checkbox" name="Evaluation_Temperature_type" value="Temporal" id="Evaluation_Temperature_type" 
<?php if ($obj{"Evaluation_Temperature_type"} == "Temporal") echo "checked";;?>/>
<?php xl('Temporal','e')?>&nbsp;  
     <?php xl('Other','e')?>
     <input type="text"  size="3px" name="Evaluation_VS_other" id="Evaluation_VS_other" 
     value="<?php echo stripslashes($obj{"Evaluation_VS_other"});?>" />&nbsp;  
      <?php xl('Respirations','e')?>
      <input type="text" size="3px" name="Evaluation_VS_Respirations" id="Evaluation_VS_Respirations" 
      value="<?php echo stripslashes($obj{"Evaluation_VS_Respirations"});?>" />
      <p>
      <?php xl('Blood Pressure Systolic','e')?>
      <input type="text" size="3px" name="Evaluation_VS_BP_Systolic" id="Evaluation_VS_BP_Systolic" 
        value="<?php echo stripslashes($obj{"Evaluation_VS_BP_Systolic"});?>" />
         <?php xl('/ Diastolic','e')?> 
      <input type="text" size="3px" name="Evaluation_VS_BP_Diastolic" id="Evaluation_VS_BP_Diastolic" 
       value="<?php echo stripslashes($obj{"Evaluation_VS_BP_Diastolic"});?>" />
      <label>
        <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Right" id="Evaluation_VS_BP_Body_Position" 
        <?php if ($obj{"Evaluation_VS_BP_Body_Position"} == "Right") echo "checked";;?>/>
            <?php xl('Right','e')?></label>
        <label>
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Left" id="Evaluation_VS_BP_Body_Position" 
            <?php if ($obj{"Evaluation_VS_BP_Body_Position"} == "Left") echo "checked";;?>/>
             <?php xl('Left','e')?></label>
          
          <label>
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Sitting" id="Evaluation_VS_BP_Body_Position" 
            <?php if ($obj{"Evaluation_VS_BP_Body_Position"} == "Sitting") echo "checked";;?>/>
              <?php xl('Sitting','e')?></label>

          <label>
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Standing" id="Evaluation_VS_BP_Body_Position" 
            <?php if ($obj{"Evaluation_VS_BP_Body_Position"} == "Standing") echo "checked";;?>/>
            <?php xl('Standing','e')?></label>
      <label>
            <input type="checkbox" name="Evaluation_VS_BP_Body_Position" value="Lying" id="Evaluation_VS_BP_Body_Position" 
            <?php if ($obj{"Evaluation_VS_BP_Body_Position"} == "Lying") echo "checked";;?>/>
            <?php xl('Lying *O2 Sat','e')?></label>
      <input type="text" name="Evaluation_VS_Sat" size="3px" id="Evaluation_VS_Sat"
      value="<?php echo stripslashes($obj{"Evaluation_VS_Sat"});?>" />
<?php xl('*Physician ordered ','e')?></p></td></tr></table></td></tr>

<tr>
<td scope="row"><table border="0" cellspacing="0px" cellpadding="5px"><tr><td>Pain
  <label for="pulse3"></label>
  <label>
    <input type="checkbox" name="Evaluation_VS_Pain" value="pain" id="Evaluation_VS_Pain" 
     <?php if ($obj{"Evaluation_VS_Pain"} == "pain") echo "checked";;?>/>
     <?php xl('No Pain','e')?></label>
  <label>
    <input type="checkbox" name="Evaluation_VS_Pain" value="nopain" id="Evaluation_VS_Pain" 
    <?php if ($obj{"Evaluation_VS_Pain"} == "nopain") echo "checked";;?>/>
     <?php xl('Pain limits functional ability','e')?>&nbsp; <?php xl('Intensity','e')?> </label>

  <input type="text" size="5px" name="Evaluation_VS_Pain_Intensity" id="Evaluation_VS_Pain_Intensity" 
  value="<?php echo stripslashes($obj{"Evaluation_VS_Pain_Intensity"});?>" />
   <?php xl('0-10)  Location(s)','e')?>
  <input type="text" size="25px" name="Evaluation_VS_Location" id="Evaluation_VS_Location" 
  value="<?php echo stripslashes($obj{"Evaluation_VS_Location"});?>" />
  <br />
  <label>
    <input type="checkbox" name="Evaluation_VS_Pain" value="pain_due_to_illness" id="Evaluation_VS_Pain" 
    <?php if ($obj{"Evaluation_VS_Pain"} == "pain_due_to_illness") echo "checked";;?>/></label>
   <?php xl('Pain due to recent illness/injury','e')?>
  <label>
  <input type="checkbox" name="Evaluation_VS_Pain" value="ChronicPain" id="Evaluation_VS_Pain " 
  <?php if ($obj{"Evaluation_VS_Pain"} == "ChronicPain") echo "checked";;?>/>
   <?php xl('Chronic pain','e')?></label>

  <?php xl('Other','e')?>
  <input type="text" name="Evaluation_VS_Other1" size="56px" id="Evaluation_VS_Other1" 
   value="<?php echo stripslashes($obj{"Evaluation_VS_Other1"});?>" />
  </td>
  </tr>
  </table>
  </td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr>
    <td><strong>
<?php xl('Please Note Contact MD if Vital Signs are Pulse ','e')?> &lt; 
<?php xl('56  or ','e')?>&gt; <?php xl('120; Temperature ','e')?>&lt;
 <?php xl('56 or  ','e')?>&gt; <?php xl('101;  Respirations','e')?> &lt;
<?php xl('10 or   ','e')?>&gt;<?php xl(' 30 ','e')?></strong> <br />
  <strong>
<?php xl('SBP','e')?> &lt;<?php xl('80 or','e')?> &gt;
<?php xl('190; DBP','e')?>  &lt;<?php xl('50 or ','e')?>&gt;
<?php xl('100; Pain Significantly Impacts patients ability to participate. O2 Sat ','e')?> &lt;
<?php xl('90% after rest','e')?></strong>
  </td></tr></table>
  </td></tr>

  <tr>
    <td scope="row"><table width="100%" border="0px" cellspacing="0px" cellpadding="5px">
        <tr>
          <td width="47%" valign="top" scope="row">
            <table width="100%">
                <tr>
                  <td><label>
                    <strong><?php xl('HOMEBOUND REASON','e')?></strong> <br />
                    <input type="checkbox" name="Evaluation_HR_Needs_assistance" id="Evaluation_HR_Needs_assistance" 
                    <?php if ($obj{"Evaluation_HR_Needs_assistance"} == "on") echo "checked";;?>/>
                    <?php xl('Needs assistance in all activities','e')?></label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="Evaluation_HR_Unable_to_leave_home" id="Evaluation_HR_Unable_to_leave_home" 
                    <?php if ($obj{"Evaluation_HR_Unable_to_leave_home"} == "on") echo "checked";;?>/>
                    <?php xl('Unable to leave home safely unassisted','e')?></label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="Evaluation_HR_Medical_Restrictions" id="Evaluation_HR_Medical_Restrictions" 
                    <?php if ($obj{"Evaluation_HR_Medical_Restrictions"} == "on") echo "checked";;?>/>
                    <?php xl('Medical Restrictions in','e')?>
                    <input type="text" name="Evaluation_HR_Medical_Restrictions_In" size="30px"id="Evaluation_HR_Medical_Restrictions_In" 
                    value="<?php echo stripslashes($obj{"Evaluation_HR_Medical_Restrictions_In"});?>" />
                  </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="Evaluation_HR_SOB_upon_exertion" id="Evaluation_HR_SOB_upon_exertion" 
                    <?php if ($obj{"Evaluation_HR_SOB_upon_exertion"} == "on") echo "checked";;?>/>
                    <?php xl('SOB upon exertion','e')?> 
                    <input type="checkbox" name="Evaluation_HR_Pain_with_Travel" id="Evaluation_HR_Pain_with_Travel" 
                    <?php if ($obj{"Evaluation_HR_Pain_with_Travel"} == "on") echo "checked";;?>/>
					<?php xl('Pain with Travel','e')?> </label></td>
                </tr>
              </table>
          <td width="53%" valign="top">
            <table width="100%" border="0px" cellspacing="0px" cellpadding="5px">

              <tr>
                <td><label>
                  <input type="checkbox" name="Evaluation_HR_Requires_assistance" id="Evaluation_HR_Requires_assistance" 
                  <?php if ($obj{"Evaluation_HR_Requires_assistance"} == "on") echo "checked";;?>/>
                  <?php xl('Requires assistance in mobility and ambulation','e')?> </label></td>
              </tr>
              <tr>
                <td><label>
                  <input type="checkbox" name="Evaluation_HR_Arrhythmia" id="Evaluation_HR_Arrhythmia" 
                  <?php if ($obj{"Evaluation_HR_Arrhythmia"} == "on") echo "checked";;?>/>
                  Arrhythmia
                  <input type="checkbox" name="Evaluation_HR_Bed_Bound" id="Evaluation_HR_Bed_Bound" 
                  <?php if ($obj{"Evaluation_HR_Bed_Bound"} == "on") echo "checked";;?>/>
				   <?php xl(' Bed Bound','e')?>
					<input type="checkbox" name="Evaluation_HR_Residual_Weakness" id="Evaluation_HR_Residual_Weakness" 
					<?php if ($obj{"Evaluation_HR_Residual_Weakness"} == "on") echo "checked";;?>/>
					<?php xl('Residual Weakness','e')?> </label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="Evaluation_HR_Confusion" id="Evaluation_HR_Confusion" 
                <?php if ($obj{"Evaluation_HR_Confusion"} == "on") echo "checked";;?>/>
<?php xl('Confusion, unable to go out of home alone','e')?> </td>
              </tr>
              <tr>
                <td><?php xl('Others','e')?>  
                  <input type="text" name="Evaluation_HR_Other" size="35px" id="Evaluation_HR_Other" 
                  value="<?php echo stripslashes($obj{"Evaluation_HR_Other"});?>" /></td>
              </tr>
              </table>
          </td>
        </tr>
      </table>
  </tr>

  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px">
        <tr>
          <td align="center" scope="row"><strong><?php xl('MED DX/ Reason for intervention','e')?>  </strong></td>
          <td align="center">
          <select id="Evaluation_Reason_for_intervention" name="Evaluation_Reason_for_intervention">
          <?php ICD9_dropdown(stripslashes($obj{"Evaluation_Reason_for_intervention"})) ?></select></td>
          <td align="center"><strong><?php xl('TREATMENT DX/ OT Problem','e')?>  </strong></td>
          <td align="center">
          <select id="Evaluation_TREATMENT_DX_OT_Problem" name="Evaluation_TREATMENT_DX_OT_Problem">
          <?php ICD9_dropdown(stripslashes($obj{"Evaluation_TREATMENT_DX_OT_Problem"})) ?></select></td>
        </tr>
      </table>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px">
    <tr><td><strong><?php xl('MEDICAL HISTORY AND PRIOR LEVEL OF FUNCTION ','e')?>  </strong></td></tr></table></td></tr>
    <tr>
    <td scope="row"><table width="100%" border="0px" cellspacing="0px" cellpadding="5px">
      <tr>
        <td scope="row"><strong><?php xl('PERTINENT MEDICAL HISTORY','e')?>  
          <input type="text" name="Evaluation_PERTINENT_MEDICAL_HISTORY" size="93px" id="Evaluation_PERTINENT_MEDICAL_HISTORY" 
          value="<?php echo stripslashes($obj{"Evaluation_PERTINENT_MEDICAL_HISTORY"});?>" />
        </strong></td>
      </tr>
      <tr>
        <td scope="row"><strong><?php xl('MEDICAL/FUNCTIONAL PRECAUTIONS ','e')?>&nbsp; &nbsp; &nbsp;
          <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="None" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" 
          <?php if ($obj{"Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"} == "None") echo "checked";;?>/>
<?php xl('None','e')?>

<input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="WB_Status" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" 
 <?php if ($obj{"Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"} == "WB_Status") echo "checked";;?>/>
<?php xl('WB Status ','e')?>
<input type="text" name="Evaluation_MFP_WB_status" id="Evaluation_MFP_WB_status" /> &nbsp; &nbsp; &nbsp;
        <input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="Falls_Risks" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" 
        <?php if ($obj{"Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"} == "Falls_Risks") echo "checked";;?>/>
<?php xl('Falls Risks','e')?>
<input type="checkbox" name="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" value="SOB" id="Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS" 
<?php if ($obj{"Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"} == "SOB") echo "checked";;?>/>
<?php xl('SOB Other','e')?></strong>
          <strong>
          <input type="text" name="Evaluation_MFP_Other" id="Evaluation_MFP_Other"  value="<?php echo stripslashes($obj{"Evaluation_MFP_Other"});?>" />
          </strong></td>
      </tr>
      <tr>
        <td scope="row"><strong>
<?php xl('PRIOR LEVEL OF FUNCTIONING (PLOF) IN HOME ','e')?></strong>
       <?php xl('Self Care ADLs (Dressing, Grooming, Bathing, Feeding, Toileting) ','e')?> 
        <strong>
        <input type="text" name="Evaluation_PRIOR_LEVEL_OF_FUNCTIONING" size="134px" id="Evaluation_PRIOR_LEVEL_OF_FUNCTIONING" 
        value="<?php echo stripslashes($obj{"Evaluation_PRIOR_LEVEL_OF_FUNCTIONING"});?>" />
        </strong></td>
      </tr>

      <tr>
        <td scope="row"><strong>
<?php xl('PLOF IADLs','e')?> </strong>
<?php xl('(Meal Prep, Phone Use, Making Bed, Shopping,  Mail, Laundry, Money Mgt, Med Mgt)','e')?> <strong>
          <input type="text" name="Evaluation_PLOF_IADLs" size="134px" id="Evaluation_PLOF_IADLs"  value="<?php echo stripslashes($obj{"Evaluation_PLOF_IADLs"});?>" />
        </strong></td>
      </tr>
      <tr>
        <td scope="row"><strong><?php xl('FAMILY/CAREGIVER SUPPORT ','e')?>
             <input type="checkbox" name="Evaluation_FAMILY_CAREGIVER_SUPPORT" value="true" id="Evaluation_FAMILY_CAREGIVER_SUPPORT" 
             <?php if ($obj{"dec_safety_tech"} == "true") echo "checked";;?>/>

<?php xl('Yes','e')?>
<input type="checkbox" name="Evaluation_FAMILY_CAREGIVER_SUPPORT" value="false" id="Evaluation_FAMILY_CAREGIVER_SUPPORT" 
<?php if ($obj{"dec_safety_tech"} == "false") echo "checked";;?>/>
<?php xl('No Relationship ','e')?>
<input type="text" size="8px" name="Evaluation_FCS_Relationship" id="Evaluation_FCS_Relationship" 
value="<?php echo stripslashes($obj{"Evaluation_FCS_Relationship"});?>" /> 

<?php xl('PLOF # Visits in Community Weekly','e')?> 
<input type="text" size="5px"name="Evaluation_Visits_in_Community" id="Evaluation_Visits_in_Community" 
value="<?php echo stripslashes($obj{"Evaluation_Visits_in_Community"});?>" /> 
        </strong></td>
      </tr>
  </table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px">
    <tr><td><strong><?php xl('ADL/FUNCTIONAL MOBILITY STATUS','e')?></strong><br />

    <strong><?php xl('Drop down Scale','e')?> </strong>
<?php xl(' U=Unable*, Dep=Dependent, Max=needs 75-51% assist, Mod=needs 50-26%, Min=needs 25-1% assist, CG=constant contact guard, SBA=stand by assist, S=supervised, needs cues, Mod I=Independent with assistive devices, Independent=no  assist required','e')?></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px">
      <tr>
        <td width="23%" align="center" scope="row"><strong><?php xl('ADL TASK','e')?></strong>
          </td>
        <td width="15%" align="center"><strong><?php xl('STATUS','e')?></strong></td>

        <td width="27%" align="center"><strong><?php xl('ADL TASK','e')?></strong></td>
        <td width="12%" align="center"><strong><?php xl('STATUS','e')?></strong></td>
        <td width="23%" align="center"><strong><?php xl('*COMMENTS','e')?></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('FEEDING ','e')?>   </td>
        <td><select id="Evaluation_ADL_FEEDING" name="Evaluation_ADL_FEEDING">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_FEEDING"}))?> </select></td>
        <td><?php xl('TOILETING','e')?></td>
        <td><select id="Evaluation_ADL_TOILETING" name="Evaluation_ADL_TOILETING">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_TOILETING"}))	?> </select></td>
        <td rowspan="6" align="center">
        <textarea name="Evaluation_CI_ADL_COMMENTS" id="Evaluation_CI_ADL_COMMENTS" cols="25" rows="5">
         <?php echo stripslashes($obj{"Evaluation_CI_ADL_COMMENTS"});?> </textarea></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('UTENSIL-CUP USE','e')?></td>
       <td><select id="Evaluation_ADL_UTENSILCUP_USE" name="Evaluation_ADL_UTENSILCUP_USE">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_UTENSILCUP_USE"}))	?> </select></td>

        <td><?php xl('BATHING/SHOWER ','e')?></td>
       <td><select id="Evaluation_ADL_BATHING_SHOWER" name="Evaluation_ADL_BATHING_SHOWER">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_BATHING_SHOWER"}))	?> </select></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('GROOMING ','e')?></td>
       <td><select id="Evaluation_ADL_GROOMING" name="Evaluation_ADL_GROOMING">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_GROOMING"}))	?> </select></td>
			
        <td><?php xl('UB DRESSING ','e')?></td>
        <td><select id="Evaluation_ADL_UB_DRESSING" name="Evaluation_ADL_UB_DRESSING">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_UB_DRESSING"}))	?> </select></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('ORAL HYGIENE ','e')?></td>
         <td><select id="Evaluation_ADL_ORAL_HYGIENE" name="Evaluation_ADL_ORAL_HYGIENE">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_ORAL_HYGIENE"}))	?> </select></td>
        <td><?php xl('LB DRESSING ','e')?></td>
         <td><select id="Evaluation_ADL_LB_DRESSING" name="Evaluation_ADL_LB_DRESSING">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_LB_DRESSING"}))	?> </select></td>

      </tr>
      <tr>
        <td scope="row"><?php xl('BED/W/C TRANSFERS ','e')?></td>
        <td><select id="Evaluation_ADL_BED_WC_TRANSFERS" name="Evaluation_ADL_BED_WC_TRANSFERS">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_BED_WC_TRANSFERS"}))	?> </select></td>
        <td><?php xl('TUB/SHOWER TRANSFERS','e')?></td>
       <td><select id="Evaluation_ADL_TUB_SHOWER_TRANSFERS" name="Evaluation_ADL_TUB_SHOWER_TRANSFERS">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_TUB_SHOWER_TRANSFERS"}))	?> </select></td>
      </tr>

      <tr>
        <td scope="row"><?php xl('TOILET TRANSFERS','e')?></td>
        <td><select id="Evaluation_ADL_TOILET_TRANSFERS" name="Evaluation_ADL_TOILET_TRANSFERS">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_TOILET_TRANSFERS"}))	?> </select></td>
        <td><input type="text" name="Evaluation_ADL_OTHERS_TEXT" id="Evaluation_ADL_OTHERS_TEXT" /></td>
       <td><select id="Evaluation_ADL_OTHERS" name="Evaluation_ADL_OTHERS">
			<?php Mobility_status(stripslashes($obj{"Evaluation_ADL_OTHERS"}))	?> </select></td>
      </tr>
      <tr>

        <td colspan="5" scope="row"><strong><?php xl('CURRENT INSTRUMENTAL ADL SKILLS','e')?></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('HOUSEKEEPING','e')?></td>
         <td><select id="Evaluation_CI_ADL_HOUSEKEEPING" name="Evaluation_CI_ADL_HOUSEKEEPING">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_HOUSEKEEPING"}))	?> </select></td>
        <td><?php xl('HOUSEKEEPING','e')?></td>
         <td><select id="Evaluation_CI_ADL_HOUSEKEEPING1" name="Evaluation_CI_ADL_HOUSEKEEPING1">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_HOUSEKEEPING1"}))	?> </select></td>
        <td align="center"><strong><?php xl('*COMMENTS','e')?></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('PHONE USAGE','e')?></td>
        <td><select id="Evaluation_CI_ADL_PHONE_USAGE" name="Evaluation_CI_ADL_PHONE_USAGE">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_PHONE_USAGE"}))	?> </select></td>
        <td><?php xl('MONEY MANAGEMENT','e')?></td>
        <td><select id="Evaluation_CI_ADL_MONEY_MANAGEMENT" name="Evaluation_CI_ADL_MONEY_MANAGEMENT">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_MONEY_MANAGEMENT"}))	?> </select></td>

        <td rowspan="4" align="center">
        <textarea name="Evaluation_CI_ADL_COMMENTS1" id="Evaluation_CI_ADL_COMMENTS1" cols="25" rows="5">
         <?php echo stripslashes($obj{"Evaluation_CI_ADL_COMMENTS1"});?> </textarea></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('MEAL PREPARATION','e')?></td>
        <td><select id="Evaluation_CI_ADL_MEAL_PREPARATION" name="Evaluation_CI_ADL_MEAL_PREPARATION">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_MEAL_PREPARATION"}))	?> </select></td>
        <td><?php xl('TRASH MANAGEMENT','e')?></td>
       <td><select id="Evaluation_CI_ADL_TRASH_MANAGEMENT" name="Evaluation_CI_ADL_TRASH_MANAGEMENT">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_TRASH_MANAGEMENT"}))	?> </select></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('LAUNDRY','e')?></td>
        <td><select id="Evaluation_CI_ADL_LAUNDRY" name="Evaluation_CI_ADL_LAUNDRY">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_LAUNDRY"}))	?> </select></td>
        <td><?php xl('TRANSPORTATION','e')?></td>
        <td><select id="Evaluation_CI_ADL_TRANSPORTATION" name="Evaluation_CI_ADL_TRANSPORTATION">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_TRANSPORTATION"}))	?> </select></td>
      </tr>

      <tr>
        <td scope="row"><?php xl('GROCERY SHOPPING','e')?></td>
      <td><select id="Evaluation_CI_ADL_GROCERY_SHOPPING" name="Evaluation_CI_ADL_GROCERY_SHOPPING">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_GROCERY_SHOPPING"}))	?> </select></td>
        <td>  <input type="text" name="Evaluation_CI_ADL_OTHERS_TEXT" id="Evaluation_CI_ADL_OTHERS_TEXT" /></td>
        <td><select id="Evaluation_CI_ADL_OTHERS" name="Evaluation_CI_ADL_OTHERS">
			<?php Mobility_status(stripslashes($obj{"Evaluation_CI_ADL_OTHERS"}))	?> </select></td>
      </tr>
  </table>    
  </tr>

  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr>
    <td><strong><?php xl('ENVIRONMENTAL BARRIERS/SAFETY ISSUES (Check all that apply)','e')?></strong></td></tr></table></td></tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td>
    <input type="checkbox" name="Evaluation_EnvBar_No_barriers" id="Evaluation_EnvBar_No_barriers" 
     <?php if ($obj{"Evaluation_EnvBar_No_barriers"} == "on") echo "checked";;?>/>
<?php xl('No environmental barriers in home','e')?>
<input type="checkbox" name="Evaluation_EnvBar_No_Safety_Issues" id="Evaluation_EnvBar_No_Safety_Issues" 
<?php if ($obj{"Evaluation_EnvBar_No_Safety_Issues"} == "on") echo "checked";;?>/>
<?php xl('No safety issues in home','e')?>
<input type="checkbox" name="Evaluation_EnvBar_Bedroom_On_Second" id="Evaluation_EnvBar_Bedroom_On_Second" 
<?php if ($obj{"Evaluation_EnvBar_Bedroom_On_Second"} == "on") echo "checked";;?>/>
<?php xl('Bedroom on second floor','e')?>
<input type="checkbox" name="Evaluation_EnvBar_No_Inadequate_grab" id="Evaluation_EnvBar_No_Inadequate_grab" 
<?php if ($obj{"Evaluation_EnvBar_No_Inadequate_grab"} == "on") echo "checked";;?>/>
<?php xl('No or inadequate grab bars in bathroom/shower','e')?>

<input type="checkbox" name="Evaluation_EnvBar_Throw_Rugs" id="Evaluation_EnvBar_Throw_Rugs" 
<?php if ($obj{"Evaluation_EnvBar_Throw_Rugs"} == "on") echo "checked";;?>/>
<?php xl('Throw rugs in rooms','e')?>
<input type="checkbox" name="Evaluation_EnvBar_No_Inadequate_smoke" id="Evaluation_EnvBar_No_Inadequate_smoke" 
<?php if ($obj{"Evaluation_EnvBar_No_Inadequate_smoke"} == "on") echo "checked";;?>/>
<?php xl('No or inadequate smoke alarms','e')?>
<input type="checkbox" name="Evaluation_EnvBar_Telephone_Not_Working" id="Evaluation_EnvBar_Telephone_Not_Working" 
<?php if ($obj{"Evaluation_EnvBar_Telephone_Not_Working"} == "on") echo "checked";;?>/>
<?php xl('Telephone is not working','e')?>
<input type="checkbox" name="Evaluation_EnvBar_No_Emergency_Numbers" id="Evaluation_EnvBar_No_Emergency_Numbers" 
<?php if ($obj{"Evaluation_EnvBar_No_Emergency_Numbers"} == "on") echo "checked";;?>/>
<?php xl('No emergency numbers available','e')?>
<input type="checkbox" name="Evaluation_EnvBar_Lighting_Not_Adequate" id="Evaluation_EnvBar_Lighting_Not_Adequate" 
<?php if ($obj{"Evaluation_EnvBar_Lighting_Not_Adequate"} == "on") echo "checked";;?>/>
<?php xl('Lighting is not adequate for safe mobility in home','e')?>
<input type="checkbox" name="Evaluation_EnvBar_No_Handrails" id="Evaluation_EnvBar_No_Handrails" 
<?php if ($obj{"Evaluation_EnvBar_No_Handrails"} == "on") echo "checked";;?>/>
<?php xl('No handrails for stairs','e')?>
<input type="checkbox" name="Evaluation_EnvBar_Stairs_Disrepair" id="Evaluation_EnvBar_Stairs_Disrepair" 
<?php if ($obj{"Evaluation_EnvBar_Stairs_Disrepair"} == "on") echo "checked";;?>/>
<?php xl('Stairs are in disrepair','e')?>
<input type="checkbox" name="Evaluation_EnvBar_Fire_Extinguishers" id="Evaluation_EnvBar_Fire_Extinguishers" 
<?php if ($obj{"Evaluation_EnvBar_Fire_Extinguishers"} == "on") echo "checked";;?>/>
<?php xl('Fire extinguishers are not available Other','e')?><strong>

<input type="text" size="115%" name="Evaluation_EnvBar_Other" id="Evaluation_EnvBar_Other" 
value="<?php echo stripslashes($obj{"Evaluation_EnvBar_Other"});?>" />
</strong></td></tr></table></td></tr>
<tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td><strong>COGNITION</strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td>
    <input type="checkbox" name="Evaluation_COG_Alert_type" value="Alert" id="Evaluation_COG_Alert_type" 
    <?php if ($obj{"Evaluation_COG_Alert_type"} == "Alert") echo "checked";;?>/>
      <?php xl('Alert','e')?>
<input type="checkbox" name="Evaluation_COG_Alert_type" value="Not_Alert" id="Evaluation_COG_Alert_type" 
<?php if ($obj{"Evaluation_COG_Alert_type"} == "Not_Alert") echo "checked";;?>/>
<?php xl('Not Alert','e')?> <label for="textfield"></label>

  <input type="text" name="Evaluation_COG_Alert_note" id="Evaluation_COG_Alert_note" 
  value="<?php echo stripslashes($obj{"Evaluation_COG_Alert_note"});?>" />
     <label for="Oriented to">Oriented to 
      <input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Person" id="Evaluation_COG_Oriented_Type" 
      <?php if ($obj{"Evaluation_COG_Oriented_Type"} == "Person") echo "checked";;?>/>
<?php xl('Person','e')?>
<input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Place" id="Evaluation_COG_Oriented_Type" 
 <?php if ($obj{"Evaluation_COG_Oriented_Type"} == "Place") echo "checked";;?>/>
<?php xl('Place','e')?>
<input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Date" id="Evaluation_COG_Oriented_Type" 
 <?php if ($obj{"Evaluation_COG_Oriented_Type"} == "Date") echo "checked";;?>/>
<?php xl('Date','e')?>
<input type="checkbox" name="Evaluation_COG_Oriented_Type" value="Reason_for_Therapy" id="Evaluation_COG_Oriented_Type" 
 <?php if ($obj{"Evaluation_COG_Oriented_Type"} == "Reason_for_Therapy") echo "checked";;?>/>
<?php xl('Reason for Therapy','e')?><br />
<?php xl('Can Follow','e')?>
<input type="checkbox" name="Evaluation_COG_Canfollow" value="1" id="Evaluation_COG_Canfollow" 
 <?php if ($obj{"Evaluation_COG_Canfollow"} == "1") echo "checked";;?>/>
<?php xl('1','e')?>
<input type="checkbox" name="Evaluation_COG_Canfollow" value="2" id="Evaluation_COG_Canfollow" 
 <?php if ($obj{"Evaluation_COG_Canfollow"} == "2") echo "checked";;?>/>
<?php xl('2','e')?>
<input type="checkbox" name="Evaluation_COG_Canfollow" value="3" id="Evaluation_COG_Canfollow" 
 <?php if ($obj{"Evaluation_COG_Canfollow"} == "3") echo "checked";;?>/>
<?php xl('3','e')?></label>    
     <?php xl('or more Step-Directions   Comments ','e')?>
     <input type="text" size="67px" name="Evaluation_COG_Comments" id="Evaluation_COG_Comments" 
     value="<?php echo stripslashes($obj{"Evaluation_COG_Comments"});?>" />
     </td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px">
      <tr>
        <td align="center" scope="row">&nbsp;</td>

          <strong><?php xl('SKILL','e')?></strong>
        <td align="center"><strong><?php xl('GOOD','e')?></strong></td>
        <td align="center"><strong><?php xl('FAIR','e')?></strong></td>
        <td align="center"><strong><?php xl('POOR','e')?></strong></td>
        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('GOOD','e')?></strong></td>

        <td align="center"><strong><?php xl('FAIR','e')?></strong></td>
        <td align="center"><strong><?php xl('POOR','e')?> </strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('SAFETY AWARENESS','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Skil_Safety_Awareness" value="good" id="Evaluation_Skil_Safety_Awareness" 
        <?php if ($obj{"Evaluation_Skil_Safety_Awareness"} == "good") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_Skil_Safety_Awareness" value="fair" id="Evaluation_Skil_Safety_Awareness" 
        <?php if ($obj{"Evaluation_Skil_Safety_Awareness"} == "fair") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_Skil_Safety_Awareness" value="poor" id="Evaluation_Skil_Safety_Awareness" 
        <?php if ($obj{"Evaluation_Skil_Safety_Awareness"} == "poor") echo "checked";;?>/></td>
        <td>SHORT-TERM MEMORY</td>
        <td align="center"><input type="checkbox" name="Evaluation_skil_Shortterm_Memory" id="Evaluation_skil_Shortterm_Memory" value="good"
        <?php if ($obj{"Evaluation_skil_Shortterm_Memory"} == "good") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_skil_Shortterm_Memory" id="Evaluation_skil_Shortterm_Memory" value="fair"
        <?php if ($obj{"Evaluation_skil_Shortterm_Memory"} == "fair") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_skil_Shortterm_Memory" id="Evaluation_skil_Shortterm_Memory" value="poor"
        <?php if ($obj{"Evaluation_skil_Shortterm_Memory"} == "poor") echo "checked";;?>/></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('ATTENTION SPAN','e')?> </td>

        <td align="center"><input type="checkbox" name="Evaluation_Skil_Attention_Span" id="Evaluation_Skil_Attention_Span" value="good"
        <?php if ($obj{"Evaluation_Skil_Attention_Span"} == "good") echo "checked";;?>/>
          <label for="checkbox"></label></td>
        <td align="center"><input type="checkbox" name="Evaluation_Skil_Attention_Span" id="Evaluation_Skil_Attention_Span" value="fair"
        <?php if ($obj{"Evaluation_Skil_Attention_Span"} == "fair") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_Skil_Attention_Span" id="Evaluation_Skil_Attention_Span" value="poor"
        <?php if ($obj{"Evaluation_Skil_Attention_Span"} == "poor") echo "checked";;?>/></td>
        <td>LONG-TERM MEMORY</td>
        <td align="center"><input type="checkbox" name="Evaluation_skil_Longterm_Memory" id="Evaluation_skil_Longterm_Memory" value="good"
        <?php if ($obj{"dec_safety_tech"} == "good") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_skil_Longterm_Memory" id="Evaluation_skil_Longterm_Memory" value="fair"
        <?php if ($obj{"dec_safety_tech"} == "fair") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_skil_Longterm_Memory" id="Evaluation_skil_Longterm_Memory" value="poor"
        <?php if ($obj{"dec_safety_tech"} == "poor") echo "checked";;?>/></td>

      </tr>
  </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px">
    <tr><td><strong><?php xl('MISCELLANEOUS SKILLS','e')?> </strong></td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px">
      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('INTACT','e')?></strong></td>
        <td align="center"><strong><?php xl('IMPAIRED','e')?></strong></td>

        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>
        <td align="center"><strong><?php xl('INTACT','e')?></strong></td>
        <td align="center"><strong><?php xl('IMPAIRED','e')?> </strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('PROPRIOCEPTION','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Proprioception" id="Evaluation_Mis_skil_Proprioception" value="intact" 
        <?php if ($obj{"Evaluation_Mis_skil_Proprioception"} == "intact") echo "checked";;?>/></td>

        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Proprioception" id="Evaluation_Mis_skil_Proprioception" value="impaired"
        <?php if ($obj{"Evaluation_Mis_skil_Proprioception"} == "impaired") echo "checked";;?>/></td>
        <td><?php xl('GROSS MOTOR COORDINATION','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Gross_Motor" id="Evaluation_Mis_skil_Gross_Motor" value="intact"
        <?php if ($obj{"Evaluation_Mis_skil_Gross_Motor"} == "intact") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Gross_Motor" id="Evaluation_Mis_skil_Gross_Motor" value="impaired"
        <?php if ($obj{"Evaluation_Mis_skil_Gross_Motor"} == "impaired") echo "checked";;?>/></td>
        </tr>
      <tr>
        <td scope="row"><?php xl('VISUAL TRACKING','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Visual_Tracking" id="Evaluation_Mis_skil_Visual_Tracking" value="intact"
        <?php if ($obj{"Evaluation_Mis_skil_Visual_Tracking"} == "intact") echo "checked";;?>/></td>

        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Visual_Tracking" id="Evaluation_Mis_skil_Visual_Tracking" value="impaired"
        <?php if ($obj{"Evaluation_Mis_skil_Visual_Tracking"} == "impaired") echo "checked";;?>/></td>
        <td><?php xl('FINE MOTOR COORDINATION','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Fine_Motor" id="Evaluation_Mis_skil_Fine_Motor" value="intact"
        <?php if ($obj{"Evaluation_Mis_skil_Fine_Motor"} == "intact") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Fine_Motor" id="Evaluation_Mis_skil_Fine_Motor" value="impaired"
        <?php if ($obj{"Evaluation_Mis_skil_Fine_Motor"} == "impaired") echo "checked";;?>/></td>
        </tr>
      <tr>
        <td scope="row"><?php xl('PERIPHERAL VISION','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Peripheral_Vision" id="Evaluation_Mis_skil_Peripheral_Vision" value="intact"
        <?php if ($obj{"dec_safety_tech"} == "intact") echo "checked";;?>/></td>

        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Peripheral_Vision" id="Evaluation_Mis_skil_Peripheral_Vision" value="impaired"
        <?php if ($obj{"Evaluation_Mis_skil_Peripheral_Vision"} == "impaired") echo "checked";;?>/></td>
        <td><?php xl('SENSORY','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Sensory" id="Evaluation_Mis_skil_Sensory" value="intact"
        <?php if ($obj{"Evaluation_Mis_skil_Sensory"} == "intact") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Sensory" id="Evaluation_Mis_skil_Sensory" value="impaired"
        <?php if ($obj{"Evaluation_Mis_skil_Sensory"} == "impaired") echo "checked";;?>/></td>
        </tr>
      <tr>
        <td scope="row"><?php xl('HEARING','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Hearing" id="Evaluation_Mis_skil_Hearing" value="intact"
        <?php if ($obj{"Evaluation_Mis_skil_Hearing"} == "intact") echo "checked";;?>/></td>

        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Hearing" id="Evaluation_Mis_skil_Hearing" value="impaired"
        <?php if ($obj{"Evaluation_Mis_skil_Hearing"} == "impaired") echo "checked";;?>/></td>
        <td><?php xl('SPEECH','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Speech" id="Evaluation_Mis_skil_Speech" value="intact"
        <?php if ($obj{"Evaluation_Mis_skil_Speech"} == "intact") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_Mis_skil_Speech" id="Evaluation_Mis_skil_Speech" value="impaired"
        <?php if ($obj{"Evaluation_Mis_skil_Speech"} == "impaired") echo "checked";;?>/></td>
        </tr>
    </table></td>
  </tr>
  <tr>

    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td><strong>Activity Tolerance </strong>
      <input type="checkbox" name="Evaluation_Activity_Tolerance_Type" value="Good" id="Evaluation_Activity_Tolerance_Type" />
<?php xl('Good','e')?>
<input type="checkbox" name="Evaluation_Activity_Tolerance_Type" value="Fair" id="Evaluation_Activity_Tolerance_Type" 
<?php if ($obj{"Evaluation_Activity_Tolerance_Type"} == "Fair") echo "checked";;?>/>
<?php xl('Fair','e')?>
<input type="checkbox" name="Evaluation_Activity_Tolerance_Type" value="Poor" id="Evaluation_Activity_Tolerance_Type" 
<?php if ($obj{"Evaluation_Activity_Tolerance_Type"} == "Poor") echo "checked";;?>/>
<?php xl('Poor','e')?>
<input type="checkbox" name="Evaluation_AT_Minutes_Participate" id="Evaluation_AT_Minutes_Participate" 
<?php if ($obj{"Evaluation_AT_Minutes_Participate"} == "on") echo "checked";;?>/>
<?php xl('Number of Minutes Can Participate in a Task ','e')?>
<input type="text" size="22px" name="Evaluation_AT_Minutes_Participate_Note" id="part_task" 
value="<?php echo stripslashes($obj{"Evaluation_AT_Minutes_Participate_Note"});?>" />
<input type="checkbox" name="Evaluation_AT_SOB" id="Evaluation_AT_SOB" 
<?php if ($obj{"Evaluation_AT_SOB"} == "on") echo "checked";;?>/>
<?php xl('SOB','e')?>
<input type="checkbox" name="Evaluation_AT_RHC_Impacts_Activity" id="Evaluation_AT_RHC_Impacts_Activity" 
<?php if ($obj{"Evaluation_AT_RHC_Impacts_Activity"} == "on") echo "checked";;?>/>
<?php xl('Respiratory/Heart Condition Impacts Activity Tolerance Comments ','e')?>

<input type="text" size="61px" name="Evaluation_AT_Comments" id="Evaluation_AT_Comments" 
 value="<?php echo stripslashes($obj{"Evaluation_AT_Comments"});?>" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr>
    <td><strong><?php xl('Patient has the following assistive devices','e')?></strong>
      <input type="checkbox" name="Evaluation_Assist_devices_Walker" id="Evaluation_Assist_devices_Walker" 
      <?php if ($obj{"Evaluation_Assist_devices_Walker"} == "on") echo "checked";;?>/>
<?php xl('Walker-Type','e')?>
<input type="text" size="15px" name="Evaluation_Assist_devices_Walker_Type" id="Evaluation_Assist_devices_Walker_Type" 
value="<?php echo stripslashes($obj{"Evaluation_Assist_devices_Walker_Type"});?>" />
<input type="checkbox" name="Evaluation_Assist_devices_Wheelchair" id="Evaluation_Assist_devices_Wheelchair" 
<?php if ($obj{"Evaluation_Assist_devices_Walker"} == "on") echo "checked";;?>/>
<?php xl('Wheelchair','e')?>
<input type="checkbox" name="Evaluation_Assist_devices_Cane" id="Evaluation_Assist_devices_Cane" 
<?php if ($obj{"Evaluation_Assist_devices_Cane"} == "on") echo "checked";;?>/>
<?php xl('Cane Type','e')?>
<input type="text" size="15px" name="Evaluation_Assist_devices_Cane_Type" id="Evaluation_Assist_devices_Cane_Type" 
value="<?php echo stripslashes($obj{"Evaluation_Assist_devices_Cane_Type"});?>" />
<input type="checkbox" name="Evaluation_Assist_devices_Glasses_For_Read" id="Evaluation_Assist_devices_Glasses_For_Read" 
<?php if ($obj{"Evaluation_Assist_devices_Glasses_For_Read"} == "on") echo "checked";;?>/>
<?php xl('Glasses for reading','e')?>
<input type="checkbox" name="Evaluation_Assist_devices_Glasses_For_Distance" id="Evaluation_Assist_devices_Glasses_For_Distance" 
<?php if ($obj{"Evaluation_Assist_devices_Glasses_For_Distance"} == "on") echo "checked";;?>/>
<?php xl('Glasses for distance','e')?>
<input type="checkbox" name="Evaluation_Assist_devices_Hearing_Aid" id="Evaluation_Assist_devices_Hearing_Aid" 
<?php if ($obj{"Evaluation_Assist_devices_Hearing_Aid"} == "on") echo "checked";;?>/>
<?php xl('Hearing Aid Other','e')?> 
<input type="text" name="Evaluation_Assist_devices_Other" id="Evaluation_Assist_devices_Other" size="62px"
value="<?php echo stripslashes($obj{"Evaluation_Assist_devices_Other"});?>" /></td></tr></table></td>
  </tr>
  <tr>
    <td height="67" scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td><strong>CURRENT BALANCE SKILLS</strong><br />
      <strong><?php xl('Drop down Scale ','e')?></strong>
<?php xl('N=Normal, G=Good, takes moderate challenges, F=Fair, maintain balance without contact, P=Poor maintain balance for 15 seconds or less, 0 no balance reaction','e')?>
    </td></tr></table></td>

  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px">
      <tr>
        <td align="center" scope="row"><strong><?php xl('SKILL','e')?></strong></th>
        <td align="center"><strong><?php xl('STATUS','e')?> </strong></td>
        <td align="center"><strong><?php xl('SKILL','e')?></strong></td>

        <td align="center"><strong><?php xl('STATUS','e')?></strong></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('DYNAMIC SITTING BALANCE','e')?></td>
        <td><select name="Evaluation_CB_Skills_Dynamic_Sitting" id="Evaluation_CB_Skills_Dynamic_Sitting" >
        <?php Balance_skills(stripslashes($obj{"Evaluation_CB_Skills_Dynamic_Sitting"}))?></select></td>

        <td><?php xl('DYNAMIC STANDING BALANCE','e')?></td>
		<td><select name="Evaluation_CB_Skills_Dynamic_Standing" id="Evaluation_CB_Skills_Dynamic_Standing" >
		<?php Balance_skills(stripslashes($obj{"Evaluation_CB_Skills_Dynamic_Standing"}))?></select></td>
      </tr>
      <tr>
        <td scope="row"><?php xl('STATIC SITTING BALANCE','e')?></td>
       <td><select name="Evaluation_CB_Skills_Static_Sitting" id="Evaluation_CB_Skills_Static_Sitting" >
       <?php Balance_skills(stripslashes($obj{"Evaluation_CB_Skills_Static_Sitting"}))?></select></td>
        <td><?php xl('STATIC STANDING BALANCE','e')?></td>
        <td><select name="Evaluation_CB_Skills_Dynamic_Standing" id="Evaluation_CB_Skills_Dynamic_Standing" >
        <?php Balance_skills(stripslashes($obj{"Evaluation_CB_Skills_Dynamic_Standing"}))?></select></td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td><strong>MUSCLE STRENGTH/FUNCTIONAL ROM EVALUATION<br />
      <input type="checkbox" name="Evaluation_MS_ROM_All_Muscle_WFL" id="Evaluation_MS_ROM_All_Muscle_WFL" 
      <?php if ($obj{"Evaluation_MS_ROM_All_Muscle_WFL"} == "on") echo "checked";;?>/>
<?php xl('All Muscle Strength is WFL','e')?>
<input type="checkbox" name="Evaluation_MS_ROM_ALL_ROM_WFL" id="Evaluation_MS_ROM_ALL_ROM_WFL" 
<?php if ($obj{"Evaluation_MS_ROM_ALL_ROM_WFL"} == "on") echo "checked";;?>/>
<?php xl('All ROM is WFL','e')?>
<input type="checkbox" name="Evaluation_MS_ROM_Following_Problem_areas" id="Evaluation_MS_ROM_Following_Problem_areas" 
<?php if ($obj{"Evaluation_MS_ROM_Following_Problem_areas"} == "on") echo "checked";;?>/>

<?php xl('The following problem areas are','e')?></strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px">
      <tr>
        <td align="center" scope="row"><strong><?php xl('PROBLEM AREA','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('STRENGTH','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('ROM','e')?></strong></td>

        <td colspan="3" align="center"><strong><?php xl('ROM TYPE','e')?></strong></td>
        <td colspan="2" align="center"><strong><?php xl('TONICITY','e')?></strong></td>
        <td rowspan="2" align="center"><strong><?php xl('FURTHER DESCRIPTION','e')?></strong></td>
      </tr>
      <tr>
        <td align="center" scope="row">&nbsp;</td>
        <td align="center"><strong><?php xl('R','e')?></strong></td>

        <td align="center"><strong><?php xl('L','e')?></strong></td>
        <td align="center"><strong><?php xl('R','e')?></strong></td>
        <td align="center"><strong><?php xl('L','e')?></strong></td>
        <td align="center"><strong><?php xl('P','e')?></strong></td>
        <td align="center"><strong><?php xl('AA','e')?></strong></td>
        <td align="center"><strong><?php xl('A','e')?></strong></td>

        <td align="center"><strong><?php xl('Hyper','e')?></strong></td>
        <td align="center"><strong><?php xl('Hypo','e')?></strong></td>
        </tr>
      <tr>
        <td align="center" scope="row"><input type="text" name="Evaluation_MS_ROM_Problemarea_text" id="Evaluation_MS_ROM_Problemarea_text" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Problemarea_text"});?>" /></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right" id="Evaluation_MS_ROM_STRENGTH_Right" 
         value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Right"});?>" />
          <?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left" id="Evaluation_MS_ROM_STRENGTH_Left" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Left"});?>" />

<?php xl('/ 5','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM" id="Evaluation_MS_ROM_ROM" value="R"
        <?php if ($obj{"Evaluation_MS_ROM_ROM"} == "R") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM" id="Evaluation_MS_ROM_ROM" value="L"
        <?php if ($obj{"Evaluation_MS_ROM_ROM"} == "L") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_ROM_Type" value="P"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type"} == "P") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_ROM_Type" value="AA"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type"} == "AA") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type" id="Evaluation_MS_ROM_Tonicity" value="A"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type"} == "A") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_Tonicity" id="Evaluation_MS_ROM_Tonicity" value="Hyper"
        <?php if ($obj{"Evaluation_MS_ROM_Tonicity"} == "Hyper") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_Tonicity" id="Evaluation_MS_ROM_Tonicity" value="Hypo"
        <?php if ($obj{"Evaluation_MS_ROM_Tonicity"} == "Hypo") echo "checked";;?>/></td>
        <td align="center" scope="row"><input type="text" name="Evaluation_MS_ROM_Further_description" id="Evaluation_MS_ROM_Further_description" 
         value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Further_description"});?>" /></td>

        </tr>
      <tr>
        <td align="center" scope="row">
        <input type="text" name="Evaluation_MS_ROM_Problemarea_text1" id="Evaluation_MS_ROM_Problemarea_text1" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Problemarea_text1"});?>" /></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right1" id="Evaluation_MS_ROM_STRENGTH_Right1"
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Right1"});?>" />
<?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left1" id="Evaluation_MS_ROM_STRENGTH_Left1" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Left1"});?>" />
<?php xl('/ 5','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM1" id="Evaluation_MS_ROM_ROM1" value="R"
        <?php if ($obj{"Evaluation_MS_ROM_ROM1"} == "R") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM1" id="Evaluation_MS_ROM_ROM1" value="L"
        <?php if ($obj{"Evaluation_MS_ROM_ROM1"} == "L") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="P"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type1"} == "P") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="AA"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type1"} == "AA") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type1" id="Evaluation_MS_ROM_ROM_Type1" value="A"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type1"} == "A") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_Tonicity1" id="Evaluation_MS_ROM_Tonicity1" value="Hyper"
        <?php if ($obj{"Evaluation_MS_ROM_Tonicity1"} == "Hyper") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_Tonicity1" id="Evaluation_MS_ROM_Tonicity1" value="Hypo"
        <?php if ($obj{"Evaluation_MS_ROM_Tonicity1"} == "Hypo") echo "checked";;?>/></td>
        <td align="center" scope="row">
        <input type="text" name="Evaluation_MS_ROM_Further_description1" id="Evaluation_MS_ROM_Further_description1" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Further_description1"});?>" /></td>
        </tr>
      <tr>
        <td align="center" scope="row">
        <input type="text" name="Evaluation_MS_ROM_Problemarea_text2" id="Evaluation_MS_ROM_Problemarea_text2" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Problemarea_text2"});?>"/></td>

        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right2" id="Evaluation_MS_ROM_STRENGTH_Right2"
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Right2"});?>" />
<?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left2" id="Evaluation_MS_ROM_STRENGTH_Left2" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Left2"});?>" />
<?php xl('/ 5','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM2" id="Evaluation_MS_ROM_ROM2" value="R"
        <?php if ($obj{"Evaluation_MS_ROM_ROM2"} == "R") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM2" id="Evaluation_MS_ROM_ROM2" value="L"
        <?php if ($obj{"Evaluation_MS_ROM_ROM2"} == "L") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="P"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type2"} == "P") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="AA"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type2"} == "AA") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type2" id="Evaluation_MS_ROM_ROM_Type2" value="A"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type2"} == "A") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_Tonicity2" id="Evaluation_MS_ROM_Tonicity2" value="Hyper"
        <?php if ($obj{"Evaluation_MS_ROM_Tonicity2"} == "Hyper") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_Tonicity2" id="Evaluation_MS_ROM_Tonicity2" value="Hypo"
        <?php if ($obj{"Evaluation_MS_ROM_Tonicity2"} == "Hypo") echo "checked";;?>/></td>
               
        <td align="center" scope="row">
        <input type="text" name="Evaluation_MS_ROM_Further_description2" id="Evaluation_MS_ROM_Further_description2" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Further_description2"});?>" /></td>
        </tr>
      <tr>
        <td align="center" scope="row"><input type="text" name="Evaluation_MS_ROM_Problemarea_text3" id="Evaluation_MS_ROM_Problemarea_text3" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Problemarea_text3"});?>"/></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Right3" id="Evaluation_MS_ROM_STRENGTH_Right3" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Right3"});?>"/>
<?php xl('/ 5','e')?></td>
        <td align="center"><input size="3px" type="text" name="Evaluation_MS_ROM_STRENGTH_Left3" id="Evaluation_MS_ROM_STRENGTH_Left3" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_STRENGTH_Left3"});?>"/>

<?php xl('/ 5','e')?></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM3" id="Evaluation_MS_ROM_ROM3" value="R"
        <?php if ($obj{"Evaluation_MS_ROM_ROM3"} == "R") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM3" id="Evaluation_MS_ROM_ROM3" value="L"
        <?php if ($obj{"Evaluation_MS_ROM_ROM3"} == "L") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="P"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type3"} == "P") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="AA"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type3"} == "AA") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_ROM_Type3" id="Evaluation_MS_ROM_ROM_Type3" value="A"
        <?php if ($obj{"Evaluation_MS_ROM_ROM_Type3"} == "A") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_Tonicity3" id="Evaluation_MS_ROM_Tonicity3" value="Hyper"
        <?php if ($obj{"Evaluation_MS_ROM_Tonicity3"} == "Hyper") echo "checked";;?>/></td>
        <td align="center"><input type="checkbox" name="Evaluation_MS_ROM_Tonicity3" id="Evaluation_MS_ROM_Tonicity3" value="Hypo"
        <?php if ($obj{"Evaluation_MS_ROM_Tonicity3"} == "Hypo") echo "checked";;?>/></td>
        <td align="center" scope="row"><input type="text" name="Evaluation_MS_ROM_Further_description3" id="Evaluation_MS_ROM_Further_description3" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Further_description3"});?>" /></td>

        </tr>
    </table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr>
      <td><strong>Comments 
        <input type="text" size="122px" name="Evaluation_MS_ROM_Comments" id="Evaluation_MS_ROM_Comments" 
        value="<?php echo stripslashes($obj{"Evaluation_MS_ROM_Comments"});?>" />
      </strong></td></tr></table></td>
  </tr>

  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr>
    <td><strong>SUMMARY</strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td>
    <input type="checkbox" name="Evaluation_Summary_OT_Evaluation_Only" id="Evaluation_Summary_OT_Evaluation_Only" 
    <?php if ($obj{"Evaluation_Summary_OT_Evaluation_Only"} == "on") echo "checked";;?>/>
<?php xl('OT Evaluation only. No further indications of service','e')?></td>
        <br />
        <input type="checkbox" name="Evaluation_Summary_Need_physician_Orders" id="Evaluation_Summary_Need_physician_Orders" 
        <?php if ($obj{"Evaluation_Summary_Need_physician_Orders"} == "on") echo "checked";;?>/>
<?php xl('Need physician orders for OT services with specific treatments, frequency, and duration. See OT Care Plan and/or 485','e')?><br />

<input type="checkbox" name="Evaluation_Summary_Received_Physician_Orders" id="Evaluation_Summary_Received_Physician_Orders" 
<?php if ($obj{"Evaluation_Summary_Received_Physician_Orders"} == "on") echo "checked";;?>/>
<?php xl('Received physician orders for OT treatment and approximate next visit date will be','e')?>
<input type="text" size="46px" name="Evaluation_approximate_next_visit_date" id="Evaluation_approximate_next_visit_date" 
value="<?php echo stripslashes($obj{"Evaluation_approximate_next_visit_date"});?>" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr>
    <td><strong><?php xl('OT Care Plan and Evaluation was communicated to and agreed upon by','e')?></strong>
      <input type="checkbox" name="Evaluation_OT_Evaulation_Communicated_Agreed" value="Patient" id="Evaluation_OT_Evaulation_Communicated_Agreed"
      <?php if ($obj{"Evaluation_OT_Evaulation_Communicated_Agreed"} == "Patient") echo "checked";;?>/>
<?php xl('Patient','e')?>
  <input type="checkbox" name="Evaluation_OT_Evaulation_Communicated_Agreed" value="Physician" id="Evaluation_OT_Evaulation_Communicated_Agreed" 
  <?php if ($obj{"Evaluation_OT_Evaulation_Communicated_Agreed"} == "Physician") echo "checked";;?>/>
<?php xl('Physician','e')?>
<input type="checkbox" name="Evaluation_OT_Evaulation_Communicated_Agreed" value="PT/ST" id="Evaluation_OT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_OT_Evaulation_Communicated_Agreed"} == "Patient") echo "checked";;?>/>

<?php xl('PT/ST','e')?>
<input type="checkbox" name="Evaluation_OT_Evaulation_Communicated_Agreed" value="COTA" id="Evaluation_OT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_OT_Evaulation_Communicated_Agreed"} == "COTA") echo "checked";;?>/>
<?php xl('COTA','e')?>
<input type="checkbox" name="Evaluation_OT_Evaulation_Communicated_Agreed" value="Skilled_Nursing" id="Evaluation_OT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_OT_Evaulation_Communicated_Agreed"} == "Skilled_Nursing") echo "checked";;?>/>
<?php xl('Skilled Nursing','e')?>
<input type="checkbox" name="Evaluation_OT_Evaulation_Communicated_Agreed" value="Caregiver/Family" id="Evaluation_OT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_OT_Evaulation_Communicated_Agreed"} == "Caregiver/Family") echo "checked";;?>/>
<?php xl('Caregiver/Family','e')?>
<input type="checkbox" name="Evaluation_OT_Evaulation_Communicated_Agreed" value="Case_Manager" id="Evaluation_OT_Evaulation_Communicated_Agreed" 
<?php if ($obj{"Evaluation_OT_Evaulation_Communicated_Agreed"} == "Case_Manager") echo "checked";;?>/>
<?php xl('Case Manager Others','e')?>
<input type="text" size="77px" name="Evaluation_OT_Evaulation_Communicated_other" id="Evaluation_OT_Evaulation_Communicated_other" 
value="<?php echo stripslashes($obj{"Evaluation_OT_Evaulation_Communicated_other"});?>" /></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr>
      <td><strong><?php xl('ADDITIONAL SERVICES PROVIDED','e')?>
      </strong>

        <input type="checkbox" name="Evaluation_ASP_Home_Exercise_Initiated" id="Evaluation_ASP_Home_Exercise_Initiated" 
        <?php if ($obj{"Evaluation_ASP_Home_Exercise_Initiated"} == "on") echo "checked";;?>/>
<?php xl('Exercise Program Initiated','e')?>
<input type="checkbox" name="Evaluation_ASP_Environmental_Adaptations_Discussed" id="Evaluation_ASP_Environmental_Adaptations_Discussed" 
   <?php if ($obj{"Evaluation_ASP_Environmental_Adaptations_Discussed"} == "on") echo "checked";;?>/>
<?php xl('Recommendations for Environmental','e')?>
<input type="checkbox" name="Evaluation_ASP_Safety_Issues_Discussed" id="Evaluation_ASP_Safety_Issues_Discussed" 
<?php if ($obj{"Evaluation_ASP_Safety_Issues_Discussed"} == "on") echo "checked";;?>/>
<?php xl('Recommendations for Safety Issues Discussed','e')?>
<input type="checkbox" name="Evaluation_ASP_Treatment_For" id="Evaluation_ASP_Treatment_For" 
<?php if ($obj{"Evaluation_ASP_Treatment_For"} == "on") echo "checked";;?>/>
<?php xl('Treatment for','e')?>
<input type="text" size="88px" name="Evaluation_ASP_Treatment_For_text" id="Evaluation_ASP_Treatment_For_text" 
value="<?php echo stripslashes($obj{"Evaluation_ASP_Treatment_For_text"});?>" /> 
<br />
<?php xl('Initiated   Other','e')?>
<input type="text" size="119px" name="Evaluation_ASP_Other" id="Evaluation_ASP_Other" 
value="<?php echo stripslashes($obj{"Evaluation_ASP_Other"});?>" /> </td></tr></table></td>
  </tr>
  <tr>

    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr><td><strong>Skilled OT is Reasonable and Necessary  to</strong>
            <br />
            <input type="checkbox" name="Evaluation_Skilled_OT_Reasonable_And_Necessary_To" value="Return_to_Prior_Level" id="Evaluation_Skilled_OT_Reasonable_And_Necessary_To" 
            <?php if ($obj{"Evaluation_Skilled_OT_Reasonable_And_Necessary_To"} == "Evaluation_Skilled_OT_Reasonable_And_Necessary_To") echo "checked";;?>/>
<?php xl('Return Patient to Their Prior Level of Function;','e')?>
<input type="checkbox" name="Evaluation_Skilled_OT_Reasonable_And_Necessary_To" value="Teach_patient_for_adaptation" id="Evaluation_Skilled_OT_Reasonable_And_Necessary_To" 
<?php if ($obj{"Evaluation_Skilled_OT_Reasonable_And_Necessary_To"} == "Teach_patient_for_adaptation") echo "checked";;?>/>
<?php xl('Teach patient compensatory techniques for adaptation','e')?>
<input type="checkbox" name="Evaluation_Skilled_OT_Reasonable_And_Necessary_To" value="Train_patient_new_skills" id="Evaluation_Skilled_OT_Reasonable_And_Necessary_To" 
<?php if ($obj{"Evaluation_Skilled_OT_Reasonable_And_Necessary_To"} == "Train_patient_new_skills") echo "checked";;?>/>
<?php xl('Train patient in learning new skills;','e')?>
<?php xl('Other','e')?>
<input type="text" size="117px" name="Evaluation_Skilled_OT_Other" id="Evaluation_Skilled_OT_Other" 
 value="<?php echo stripslashes($obj{"Evaluation_Skilled_OT_Other"});?>" /></td></tr></table></td>
  </tr>
  <tr>

    <td scope="row"><table border="0px" cellspacing="0px" cellpadding="5px"><tr>
    <td><strong><?php xl('ADDITIONAL COMMENTS ','e')?>
      <input type="text" size="135px" name="Evaluation_Additional_Comments" id="Evaluation_Additional_Comments" 
       value="<?php echo stripslashes($obj{"Evaluation_Additional_Comments"});?>" />
    </strong></td></tr></table></td>
  </tr>
  <tr>
    <td scope="row"><table width="100%" border="1px" cellspacing="0px" cellpadding="5px">
      <tr>
        <td width="50%" scope="row"><strong><?php xl('Therapist Who Developed POC (Name and Title)','e')?></strong>
        </td>

        <td width="50%"><strong><?php xl('Electronic Signature','e')?></strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
