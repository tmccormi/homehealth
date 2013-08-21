<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: careplan");
?>

<html>
<head>
<title>Care Plan</title>
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
	    	 if(Dx=='med_dx_icd9')
	    	 {
		    	med_icd9.innerHTML= result['res'];
	    	 }
	    	 if(Dx=="trmnt_dx_icd9")
	    	 {
	    		 trmnt_icd9.innerHTML= result['res'];
	    	 }
	    	 return true;	    	               
	      }
	    };
	    obj.open("GET",site_root+"/forms/careplan/functions.php?code="+icd9code+"&Dx="+Dx,true);    
	    obj.send(null);
	  }	 
	</script>
</head>

<body>
	<form method="post"
		action="<?php echo $rootdir;?>/forms/careplan/save.php?mode=new" name="careplan">
		<h3 align="center"><?php xl('OCCUPATIONAL THERAPY CARE PLAN','e')?></h3>		
		<h5 align="center">
		<?php xl('(Information from this form goes to 485/Plan of care)','e'); ?>
		</h5>
		
 <br> <br/>
		<table width="100%" border="1" cellpadding="2px" class="formtable">
			<tr>
				<td width="13%" align="center" valign="top" scope="row">
				<strong><?php xl('PATIENT NAME','e')?></strong></td>
				<td width="13%" align="center" valign="top"><input type="text"
					 id="patient_name" value="<?php patientName()?>"
					readonly /></td>
				<td width="20%" align="center" valign="top"><strong><?php xl('MR#','e')?>
				</strong></td>
				<td width="15%" align="center" valign="top" class="bold"><input
					type="text" name="mr" id="mr"
					value="<?php  echo $_SESSION['pid']?>" readonly/></td>
				<td width="22%" align="center" valign="top">
				<strong><?php xl('DATE','e')?></strong></td>
				<td width="17%" align="center" valign="top" class="bold">
				<input type='text' size='10' name='date_curr' id='date_curr' 
					title='<?php xl('Date','e'); ?>'
					onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/> 
					<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
					height='22' id='img_curr_date' border='0' alt='[?]'
					style='cursor: pointer; cursor: hand'
					title='<?php xl('Click here to choose a date','e'); ?>'> 
					<script	LANGUAGE="JavaScript">
    Calendar.setup({inputField:"date_curr", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
				</td>

			</tr>

<tr>
<td width="20%" align="left" valign="top" scope="row">
<strong><?php xl('Med Dx/ Reason for OT intervention','e')?></strong></td>
<td width="30%" colspan="2" align="left" valign="top" class="bold">
<input type="text" id="med_dx_icd9" name="med_dx_icd9" style="width:100%;"/>
</td>

<td width="20%" align="left" valign="top" class="bold"><?php xl('Treatment Dx','e')?></td>
<td width="30%" colspan="2" align="left" valign="top" class="bold">
<input type="text" id="trmnt_dx_icd9" name="trmnt_dx_icd9" style="width:100%;"/>
</td>
</tr>

			<tr>
				<td colspan="3" valign="top" scope="row">
				<strong><?php xl('PROBLEMS REQUIRING OT INTERVENTION','e')?>
				</strong></td>

<td valign="top"><strong><?php xl('Start of Care Date','e')?> </strong></td>
<td colspan="2" valign="top">  
<input type='text' size='12' name='SOC_Date' id='SOC_Date' title='<?php xl('Start of Care Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='<?php VisitDate(); ?>' readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"SOC_Date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>
</td>

			</tr>
			<tr>
				<td colspan="3" valign="top" scope="row">
					<table width="100%" border="0" cellpadding="2px" class="formtable">
						<tr>
							<td scope="row"><table width="100%" border="0" cellpadding="2px" class="formtable">
									<tr>
										<td valign="top" scope="row"><label> 
										<input type="checkbox" name="adl_skills" id="adl_skills" /> 
										<?php xl('Decline in ADL skills','e')?>
										</label> <br /></td>
										<td valign="top"><input name="adl_skills_text"
											style="width:180px" id="adl_skills_text" type="text" /> &nbsp;</td>
									</tr>
									<tr>
										<td valign="top" scope="row"><label> <input type="checkbox"
												name="dec_rom" id="dec_rom" /> </label> 
												<?php xl('Decrease in ROM in','e')?>
										</td>
										<td valign="top"><label for="ROM in2"></label> <input
											style="width:180px" type="text" name="dec_rom_txt" id="dec_rom_txt" /></td>
									</tr>
									<tr>
										<td valign="top" scope="row"><label> <input type="checkbox"
												name="iadl_skills" id="iadl_skills" /> </label> 
												<?php xl('Decline in IADL skills','e')?>
										</td>
										<td valign="top"><label for="IADL skills"></label> 
										<input type="text" style="width:180px" name="iadl_skills_txt" id="iadl_skills_txt"/></td>
									</tr>
									<tr>
										<td valign="top" scope="row"><label> 
										<input type="checkbox" name="dec_mobility" id="dec_mobility"/> 
										<?php xl('Decline in Functional Mobility in','e')?>
										</label></td>
										<td valign="top"><label for="Mobility in"></label> 
										<input type="text" style="width:180px" name="mobility_in" id="mobility_in"/></td>
									</tr>
								</table>						
						</tr>
					</table>
				
				<td colspan="3" valign="top"><table width="100%" border="0" cellpadding="2px" class="formtable">
						<tr>
							<td colspan="2" valign="top" scope="row"><input type="checkbox"
								name="dec_safety_tech" id="dec_safety_tech" /> <label
								for="Decreased Safety Techniques in"> <?php xl('Decreased Safety Techniques in','e')?>
							</label> <label for="techniques in others"></label> <input
								type="text" name="safety_tech_txt" id="safety_tech_txt" />
						
						</tr>
						<tr>
							<td valign="top" scope="row"><?php xl('Other','e')?>
							</td>
							<td valign="top"><label for="soc date_other_1"></label>
								<input type="text" style="width:60%" name="safety_tech_others1"
								id="safety_tech_others1" />
							</td>
						</tr>
						<tr>
							<td valign="top" scope="row"><?php xl('Other','e')?></td>
							<td valign="top"><label for="soc date_other_2"></label> <input
								type="text" style="width:60%" name="safety_tech_others2" id="safety_tech_others2" />
							
							</td>
						
						</tr>
					</table></td>
			</tr>
			<tr>
				<td colspan="6">
					<table width="100%" class="formtable">

<tr>
<td colspan="2" valign="top" scope="row"><strong><?php xl('TREATMENT PLAN FREQUENCY','e')?></strong><br></td>
<tr>
<td><?php xl('Frequency & Duration: ','e')?>&nbsp;
<input type="text" name="frequency" id="frequency" style="width:100%;"/>
<br />
<?php xl('Effective Date: ','e')?>
<input type="text" name="effective_date" id="effective_date" size="12" readonly/>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_eff_date' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>'>

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"effective_date", ifFormat:"%Y-%m-%d", button:"img_eff_date"});
</script>
</strong>
</td>
</tr>

					</table>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('Information such as  frequency, duration and effective date should be linked to a physician order due report.','e')?>
				</strong>
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="middle" scope="row"><label> <input
						type="checkbox" name="evaluation" id="evaluation" /> <?php xl('Evaluation','e')?>
				</label> <br /> <label> <input type="checkbox" name="home_safety"
						id="home_safety" /> <?php xl('Home Safety Assessment','e')?> </label>
					<br /> <label> <input type="checkbox" name="adl_training"
						id="adl_training" /> <?php xl('Self Care ADL Training','e')?> </label>
					<br /> <label> <input type="checkbox" name="iadl_training"
						id="iadl_training" /> <?php xl('IADL Training','e')?> </label> <br />
					<label> <input type="checkbox" name="visual_comp" id="visual_comp" />
					<?php xl('Visual/Perceptual Compensatory','e')?> </label> <br /> <label>
						<input type="checkbox" name="energy_copd" id="energy_copd" /> <?php xl('Energy Conservation for COPD/CHF','e')?>
				</label></td>
				<td colspan="2" valign="top">
					<p>
						<label> <input type="checkbox" name="orthotics_mgmt"
							id="orthotics_mgmt" /> <?php xl('Orthotics/Splinting Management','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="adaptive_equipment" id="adaptive_equipment" /> <?php xl('Adaptive Equipment Training','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="cognitive_comp" id="cognitive_comp" /> <?php xl('Cognitive Compensatory Skills','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="homeue_exercise" id="homeue_exercise " /> <?php xl('Home UE Exercise Program','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="patient_education" id="patient_education" /> <?php xl('Patient/Caregiver/Family Education','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="fine_compensatory" id="fine_compensatory" /> <?php xl('Fine/Gross Motor Compensatory','e')?>
						</label> <br />
					</p>
				</td>
				<td colspan="2" valign="top">
					<p>
						<label> <input type="checkbox" name="educate_safety"
							id="educate_safety" /> <?php xl(' Educate Home/Fall Safety','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="teach_bathing_skills" id="teach_bathing_skills" /> <?php xl('Teach compensatory bathing, skills','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="exercises_to_patient" id="exercises_to_patient" /> <?php xl('Exercises/ Safety Techniques given to patient','e')?>
						</label>
					</p>
					<p>
						<?php xl(' Other','e')?> <input type="text"
							name="exercises_others" id="exercises_others" style="width:300px"/>
					</p>
					<p>
						<br />
					</p>
				</td>
			</tr>

			<tr>
				<td colspan="6" valign="top">
					<table width="100%" border="2" class="formtable">
						<tr>
							<td width="40%" align="cenetr" scope="row"><strong><?php xl('Short Term Outcomes','e')?>
							</strong>
							</td>
							<td width="10%" align="center"><strong><?php xl('Time','e')?> </strong></td>
							<td width="40%"><strong><?php xl('Short Term Outcomes','e')?></strong></td>
							<td width="10%" align="center"><strong><?php xl('Time','e')?> </strong></td>
						</tr>
							
						
									<tr>
										<td valign="top" scope="row"><label>
											
												<input type="checkbox" name="imp_adl_skills"
													id="imp_adl_skills" /> <?php xl('Improve ADL skills in','e')?>
												</label> <input type="text" name="imp_adl_skills_in"
													id="imp_adl_skills_in" size="12"/>
													<?php xl('to','e')?>
												<input type="text" name="imp_adl_skills_to"
													id="imp_adl_skills_to" size="12" />
													<?php xl('assist.','e')?>
											
										</td>
										<td  align="left" valign="center">
											<input type="text" name="shortterm_time" id="shortterm_time" size="10px">
										</td>
										<td scope="row">
										<?php xl('Other','e')?><input type="text" style="width:60%" name="time_others1" id="time_others1" />
										<br>
										<?php xl('Other','e')?><input type="text" style="width:60%" name="time_others2" id="time_others2" />
										</td>
										<td  align="left" valign="center">
											<input type="text" name="shortterm_time6" id="shortterm_time6" size="10px">
<br/>											<input type="text" name="shortterm_time7" id="shortterm_time7" size="10px">
										</td>
									</tr>
									
									<tr>
										<td valign="top" scope="row"><label> <input type="checkbox"
												name="imp_iadl_skills" id="imp_iadl_skills" size="12" /> <?php xl('Improve IADL skills in','e')?>
										</label> <input type="text" name="imp_iadl_skills_in"
											id="imp_iadl_skills_in" /> <?php xl('to','e')?> <input
											type="text" name="imp_iadl_skills_to" id="imp_iadl_skills_to" size="12" />
											<?php xl('assist.','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time1" id="shortterm_time1" size="10px">
										</td>
										<td align="left" colspan="2">
										    <strong><?php xl('Long Term Outcomes ','e')?></strong>
										</td>
										<td></td>
										
									</tr>
									
									
									<tr>
										<td valign="top" scope="row"><label> <input type="checkbox"
												name="wfl_Increase" id="wfl_Increase" /> <?php xl('Increase','e')?>
										</label> <input type="checkbox" name="wfl_details"
											id="wfl_details" value="strength" /> <label><?php xl('Strength','e')?> </label>
											<label> <input type="checkbox" name="wfl_details"
												id="wfl_details" value="ROMof" /> <?php xl('ROM of','e')?> </label> <label>
												<input type="checkbox" name="wfl_details"
												id="wfl_details" value="right"/> <?php xl('right','e')?> </label> <label>
												<input type="checkbox" name="wfl_details"
												id="wfl_details" value="left"/> <?php xl('left','e')?> </label> <input
											type="text" name="increase_to" id="increase_to" size="12" /> <?php xl(' to WFL','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time2" id="shortterm_time2" size="10px">
										</td>
										<td>
										<label> <input type="checkbox" name="return_to_priorlevel"
													id="return_to_priorlevel" /> <?php xl('Return to prior level of function in','e')?>
										</label>
										<input type="text" name="return_priorlevel_in" id="return_priorlevel_in" style="width:200px">
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time" id="longterm_time" size="10px">
										</td>
					
										
									</tr>
									<tr>
										<td valign="top" scope="row"><label> <input type="checkbox"
												name="perform" id="perform" /> <?php xl('Perform','e')?> </label>
											<input type="text" name="exercise_type" id="exercise_type" size="12" />
											<?php xl('Exercises using written handout  with','e')?> <input
											type="text" name="exercise_prompts" id="exercise_prompts" size="12" />
											<?php xl('verbal/physical prompts','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time3" id="shortterm_time3" size="10px">
										</td>
										<td><label>
											<input type="checkbox" name="home_exercise" id="home_exercise" /> 
											<?php xl('Demonstrate ability to follow home exercise program','e')?></label>
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time1" id="longterm_time1" size="10px">
										</td>								
									</tr>
									
									
									<tr>
										<td valign="top" scope="row"><label> <input type="checkbox"
												name="improve_safety" id="improve_safety" /> <?php xl('Improve safety techniques in','e')?>
										</label> <input type="text" name="safety_technique_in"
											id="safety_technique_in" size="12" /> <?php xl('to','e')?><input
											type="text" name="safety_technique_to"
											id="safety_technique_to" size="12" /> <?php xl('assist.','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time4" id="shortterm_time4" size="10px">
										</td>
										<td width="60%" scope="row">
											<label><input type="checkbox" name="safety_at_home" id="safety_at_home" />
											<?php xl('Improve independence in safety awareness in home','e')?>
											</label>
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time2" id="longterm_time2" size="10px">
										</td>
									</tr>
									
									<tr>
										<td scope="row"><br /> <label> <input
												type="checkbox" name="improve_mobility"
												id="improve_mobility" /> <?php xl('Improve functional mobility in','e')?>
										</label> <input type="text" name="improve_mobility_in"
											id="improve_mobility_in" size="12" /> <?php xl('to','e')?> <input
											type="text" name="improve_mobility_to"
											id="improve_mobility_to" size="12" /> <?php xl('assist.','e')?>
										</td>
										<td align="left" valign="center">
											<input type="text" name="shortterm_time5" id="shortterm_time5" size="10px">
										</td>
										<td scope="row"><label>
											<input type="checkbox" name="envrn_changes_home" id="envrn_changes_home" />
											<?php xl('Implement environmental changes in home to improve safety','e')?></label>
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time3" id="longterm_time3" size="10px">
										</td>
									</tr>
									
									<tr>
										<td >&nbsp;</td>
										<td>&nbsp;</td>
										<td scope="row"><?php xl('Other','e')?>
											<input type="text" style="width:60%" name="time_others3" id="time_others3" />
										</td>
										<td align="left" valign="center">
											<input type="text" name="longterm_time4" id="longterm_time4" size="10px">
										</td>
									</tr>
							
							
									
					</table> 
					
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><p>
						<strong> <?php xl('ADDITIONAL COMMENTS','e')?> </strong>
						<input type="text" style="width:760px" name="additional_comments_text" id="additional_comments_text" />
						</p>
			
			</tr>
			<tr>
				<th colspan="3" align="left" valign="middle" scope="row"><strong><?php xl('Rehab Potential','e')?>
				</strong> <label> <input type="checkbox" name="rehabpotential"
						id="rehabpotential" value="exlnt"/> <?php xl('Excellent','e')?> </label>
					<label> <input type="checkbox" name="rehabpotential"
						id="rehabpotential" value="good" /> <?php xl('Good','e')?> </label>
					<label> <input type="checkbox" name="rehabpotential"
						id="rehabpotential" value="fair" /> <?php xl('Fair','e')?> </label>
					<label> <input type="checkbox" name="rehabpotential"
						id="rehabpotential" value="poor" /> <?php xl('Poor','e')?> </label>
					<br />
				</th>
				<td align="center" valign="middle"><strong> <?php xl('Discharge Plan','e')?>
				</strong></td>
				<td align="left" valign="middle"><label> <input type="checkbox"
						name="rehabpotential_goals_met" id="rehabpotential_goals_met" /> <?php xl('When Goals Are Met','e')?>
				</label>
				</td>
				<td align="left" valign="middle"><p>
				<?php xl('Other','e')?>
						<input type="text" style="width:120px" name="rehabpotential_others"
							id="rehabpotential_others" />
					</p>
				</td>

			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('OT Care Plan and Discharge was communicated to and agreed upon by','e')?>
				</strong> <label> <input type="checkbox"
						name="careplan_discharge_comm" id="careplan_discharge_comm"
						value="patient" /> <?php xl('Patient','e')?> </label> <label> 
						<input type="checkbox" name="careplan_discharge_comm"
						id="careplan_discharge_comm" value="physician" /> <?php xl('Physician','e')?>
				</label> <label> <input type="checkbox"
						name="careplan_discharge_comm" id="careplan_discharge_comm"
						value="pt/ot" /> <?php xl('PT/OT/ST','e')?> </label> <label>
						 <input type="checkbox" name="careplan_discharge_comm"
						id="careplan_discharge_comm" value="COTA" /> <?php xl('COTA','e')?>
				</label> <label> <input type="checkbox"
						name="careplan_discharge_comm" id="careplan_discharge_comm"
						value="nurse" /> <?php xl('Skilled Nursing','e')?> </label> <label>
						<input type="checkbox" name="careplan_discharge_comm"
						id="careplan_discharge_comm" value="family" /> <?php xl('Caregiver/Family','e')?>
				</label> <label> <input type="checkbox"
						name="careplan_discharge_comm" id="careplan_discharge_comm"
						value="manager" /> <?php xl('Case Manager','e')?><br>
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:90%" name="care_plan_discharge_other"
					id="care_plan_discharge_other" />
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><p>
						<strong><?php xl(' Patient/Caregiver/Family Response
							to Care Plan and Occupational Therapy','e')?></strong>
					</p>
			
			</tr>
			<tr>
				<td colspan="3" valign="middle" scope="row">
					<p>
						<label> <input type="checkbox" name="careplan_response_agree"
							id="response_agree" /> <?php xl('Agreeable to general goals and treatment plan','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="careplan_response_motivated" id="response_motivated" /> <?php xl('Highly motivated to improve','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="careplan_response_supp" id="response_suppotive" /> <?php xl('Supportive family/caregiver likely to increase success','e')?>
						</label>
					</p>
				
				<td colspan="3" valign="middle"><input type="checkbox"
					name="addtn_treatment" id="addtn_treatment" /> 
					 <?php xl('May require additional treatment session  to
          achieve Long Term Outcomes due to','e')?> <input
					type="checkbox" name="addtn_treatment_req" value="memoryloss"
					id="addtn_treatment_req" /> <?php xl('short term memory difficulties','e')?>
					<input type="checkbox" name="addtn_treatment_req"
					id="addtn_treatment_req" value="minsupport" /> <?php xl('minimal support systems','e')?><br>
					<input type="checkbox" name="addtn_treatment_req"
					id="addtn_treatment_req" value="langbarrier" /> <?php xl('communication, language  barriers','e')?>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="middle" scope="row">
					<p>
						<strong><?php xl('Physician Orders','e')?> </strong> <input
							type="checkbox" name="physician_orders_obtained" id="physician_orders_obtained" /> <label
							for="Physician Orders Obtained"> <?php xl('Physician Orders Obtained','e')?>
						</label>
					</p>
					<p>
						<input type="checkbox" name="physician_orders_needed" id="physician_orders_needed" /> <label
							for="Physician orders needed"> <?php xl('Physician orders needed','e')?>
						</label> . <strong> <?php xl('Will follow agency&rsquo;s procedures for obtaining verbal orders and completing the 485/POC or submitting  supplemental orders for physician signature','e')?>
						</strong>
					</p>
				
				<td colspan="3" valign="middle"><p>
						<input type="checkbox" name="address_issues_by" id="address_issues_by" />
							<?php xl('Will address above issues by','e')?>
						<input type="checkbox" name="address_issues_options"
							id="writtendirection" value="writtendirection" />
							<?php xl('Providing written directions  and/or physical demonstration','e')?>
						<input type="checkbox" name="address_issues_options"
							id="communitysupport" value="communitysupport" />
							<?php xl('establish community  support systems','e')?><br>
						<input type="checkbox" name="address_issues_options"
							id="adaptations" value="adaptations" />
							<?php xl('home/environmental adaptations','e')?>
						<input type="checkbox" name="address_issues_options"
							id="usefamily" value="usefamily" />
							<?php xl('use family/professionals for interpretations as needed','e')?>
					</p>
					<p>
					<?php xl('Other','e')?>
						<input type="text" style="width:430px" name="address_issues_others"
							id="address_issues_others" />
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top" scope="row"><strong><?php xl('Therapist Who Developed POC','e')?>
				</strong> </td>
				<td colspan="3" valign="top"><strong><?php xl('Electronic Signature','e')?>
				</strong></td>
			</tr>	
		</table>
		<a href="javascript:top.restoreSession();document.careplan.submit();"
			class="link_submit"><?php xl(' [Save]','e')?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>
		</form>
</body>

</html>
