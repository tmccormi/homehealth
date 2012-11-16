function form_validation(form_name)
{
	/*Required Variables*/
	var i;
	var error_indicator=0;
	
	
/****************************  For Oasis Nursing SOC and Oasis Nursing Resumption **************************/

		/* For M0030 Start of Care Date */
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption')
	{
		if((document.forms[form_name]['oasis_patient_soc_date'].value==null||document.forms[form_name]['oasis_patient_soc_date'].value==''||document.forms[form_name]['oasis_patient_soc_date'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Start of Care Date (M0030)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_patient_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_patient_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
	/* For M0090 Assessment Date */
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption')
	{
		if((document.forms[form_name]['oasis_patient_date_assessment_completed'].value==null||document.forms[form_name]['oasis_patient_date_assessment_completed'].value==''||document.forms[form_name]['oasis_patient_date_assessment_completed'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_patient_date_assessment_completed').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_patient_date_assessment_completed').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
	/* For M0030 greater than M0090  */
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption')
	{
		if((document.forms[form_name]['oasis_patient_soc_date'].value > document.forms[form_name]['oasis_patient_date_assessment_completed'].value) && error_indicator==0)
		{
			alert('Start of Care Date (M0030) should be less than Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_patient_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_patient_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
	
	
					/* For M0030 Assessment Date for Oasis-C PT SOC/ROC */
	if(form_name=='oasis_pt_soc')
	{
		if((document.forms[form_name]['oasis_patient_soc_date'].value==null||document.forms[form_name]['oasis_patient_soc_date'].value==''||document.forms[form_name]['oasis_patient_soc_date'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Start of Care Date (M0030)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_patient_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_patient_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
					/* For M0090 Assessment Date for Oasis-C PT SOC/ROC */
	if(form_name=='oasis_pt_soc')
	{
		if((document.forms[form_name]['oasis_patient_date_assessment_completed'].value==null||document.forms[form_name]['oasis_patient_date_assessment_completed'].value==''||document.forms[form_name]['oasis_patient_date_assessment_completed'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_patient_date_assessment_completed').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_patient_date_assessment_completed').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
		/* For M0030 greater than M0090  */
	if(form_name=='oasis_pt_soc')
	{
		if((document.forms[form_name]['oasis_patient_soc_date'].value > document.forms[form_name]['oasis_patient_date_assessment_completed'].value) && error_indicator==0)
		{
			alert('Start of Care Date (M0030) should be less than Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_patient_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_patient_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
	
	
		
	/*For M0100 Follow Up*/
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption'||form_name=='oasis_nursing_resumption')
	{
		var oasis_patient_follow_up_indicator=0;
		var oasis_patient_follow_up=document.forms[form_name]['oasis_patient_follow_up'];
		for(i=0;i<oasis_patient_follow_up.length;i++)
		{
			if(oasis_patient_follow_up[i].checked)
			oasis_patient_follow_up_indicator=1;
		}
		if(oasis_patient_follow_up_indicator==0 && error_indicator==0)
		{
			alert('Please enter Start/Resumption of Care Reason (M0100)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#m0100').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m0100').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	/*For M0100 Follow Up to M0110*/
	/*
	if(form_name=='oasis_therapy_rectification')
	{
		var oasis_patient_follow_up_indicator=0;
		var oasis_patient_episode_timing_indicator=0;
		var oasis_patient_follow_up=document.forms[form_name]['oasis_therapy_follow_up'];
		var oasis_patient_episode_timing=document.forms[form_name]['oasis_therapy_episode_timing'];
		for(i=0;i<oasis_patient_follow_up.length;i++)
		{
			if(oasis_patient_follow_up[i].checked)
			oasis_patient_follow_up_indicator=1;
		}
		if(oasis_patient_follow_up_indicator==0 && error_indicator==0)
		{
			alert('Please enter M0100');
			error_indicator=1;
		}
		for(i=0;i<oasis_patient_episode_timing.length;i++)
		{
			if(oasis_patient_episode_timing[i].checked)
			oasis_patient_episode_timing_indicator=1;
		}
		if(oasis_patient_episode_timing_indicator==0 && error_indicator==0)
		{
			alert('Please enter M0110');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#m0110').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m0110').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
		
	}
	*/
		
		
	/* For M0102 to M0110 */
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption')
	{
		var oasis_patient_episode_timing_indicator=0;
		var oasis_patient_episode_timing=document.forms[form_name]['oasis_patient_episode_timing'];
		for(i=0;i<oasis_patient_episode_timing.length;i++)
		{
			if(oasis_patient_episode_timing[i].checked)
			oasis_patient_episode_timing_indicator=1;
		}
		if((document.forms[form_name]['oasis_patient_date_ordered_soc'].value!=null && document.forms[form_name]['oasis_patient_date_ordered_soc'].value!=''||document.forms[form_name]['oasis_patient_date_ordered_soc'].value=='0000-00-00') && error_indicator==0)
		{
			if(oasis_patient_episode_timing_indicator==0)
			{
				alert('Please enter Episode Timing (M0110)');
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#m0110').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m0110').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
	
	
		/* For M0102 to M0110 for Oasis-c PT SOC/ROC */
	if(form_name=='oasis_pt_soc')
	{
		var oasis_patient_episode_timing_indicator=0;
		var oasis_patient_episode_timing=document.forms[form_name]['oasis_patient_episode_timing'];
		for(i=0;i<oasis_patient_episode_timing.length;i++)
		{
			if(oasis_patient_episode_timing[i].checked)
			oasis_patient_episode_timing_indicator=1;
		}
		if((document.forms[form_name]['oasis_patient_date_ordered_soc'].value!=null && document.forms[form_name]['oasis_patient_date_ordered_soc'].value!=''||document.forms[form_name]['oasis_patient_date_ordered_soc'].value=='0000-00-00') && error_indicator==0)
		{
			if(oasis_patient_episode_timing_indicator==0)
			{
				alert('Please enter Episode Timing (M0110)');
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#m0110').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m0110').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
		
	/* For M1000 to M1016 */
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption'||form_name=='oasis_pt_soc')
	{
		var oasis_patient_history_impatient_facility=document.forms[form_name]['oasis_patient_history_impatient_facility[]'];
		var oasis_patient_history_mrd_diagnosis=document.forms[form_name]['oasis_patient_history_mrd_diagnosis[]'];
		var oasis_patient_history_mrd_code=document.forms[form_name]['oasis_patient_history_mrd_code[]'];
		
		if(oasis_patient_history_impatient_facility[7].checked && error_indicator==0)
		{
			if(oasis_patient_history_mrd_diagnosis[0].value==null||oasis_patient_history_mrd_diagnosis[0].value==''||oasis_patient_history_mrd_code[0].value==null||oasis_patient_history_mrd_code[0].value=='')
			{
				alert('Please enter Diagnosis Requiring Medical or Treatment Regimen Change Within Past 14 Days (M1016)');
			if($('#patient_history_diagnosis').css('display') == 'none')
			{
			$('#patient_history_diagnosis').slideToggle('fast', function(){
			$('#m1016').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1016').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
		
	/* For M1300 to M1306 */
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption'||form_name == 'oasis_pt_soc')
	{
		var oasis_pressure_ulcer_assessment_indicator=0;
		var oasis_pressure_ulcer_unhealed_s2_indicator=0;
		var oasis_pressure_ulcer_assessment=document.forms[form_name]['oasis_pressure_ulcer_assessment'];
		var oasis_pressure_ulcer_unhealed_s2=document.forms[form_name]['oasis_pressure_ulcer_unhealed_s2'];
		for(i=0;i<oasis_pressure_ulcer_assessment.length;i++)
		{
			if(oasis_pressure_ulcer_assessment[i].checked)
			{
				if(oasis_pressure_ulcer_assessment[i].value=='0')
				oasis_pressure_ulcer_assessment_indicator=1;
			}
		}
		for(i=0;i<oasis_pressure_ulcer_unhealed_s2.length;i++)
		{
			if(oasis_pressure_ulcer_unhealed_s2[i].checked)
			oasis_pressure_ulcer_unhealed_s2_indicator=1;
		}
		if(oasis_pressure_ulcer_assessment_indicator==1 && error_indicator==0)
		{
			if(oasis_pressure_ulcer_unhealed_s2_indicator==0)
			{
				alert('Please enter Unhealed Pressure Ulcer at Stage II or Higher (M1306)');
			if($('#fall_risk_assessment').css('display') == 'none')
			{
			$('#fall_risk_assessment').slideToggle('fast', function(){
			$('#m1306').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1306').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
		
	/*For M1306 to M1322*/
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption'||form_name=='oasis_pt_soc')
	{
		var oasis_pressure_ulcer_unhealed_s2_indicator_2=0;
		var oasis_therapy_pressure_ulcer_current_no_indicator=0;
		var oasis_pressure_ulcer_unhealed_s2=document.forms[form_name]['oasis_pressure_ulcer_unhealed_s2'];
		var oasis_therapy_pressure_ulcer_current_no=document.forms[form_name]['oasis_therapy_pressure_ulcer_current_no'];
		
		
		for(i=0;i<oasis_pressure_ulcer_unhealed_s2.length;i++)
		{
			if(oasis_pressure_ulcer_unhealed_s2[i].checked)
			{
				if(oasis_pressure_ulcer_unhealed_s2[i].value=='0')
				oasis_pressure_ulcer_unhealed_s2_indicator_2=1;
			}
		}
		for(i=0;i<oasis_therapy_pressure_ulcer_current_no.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_current_no[i].checked)
			oasis_therapy_pressure_ulcer_current_no_indicator=1;
		}
		if(oasis_pressure_ulcer_unhealed_s2_indicator_2==1 && error_indicator==0)
		{
			if(oasis_therapy_pressure_ulcer_current_no_indicator==0)
			{
				alert('Please enter Current Number of Stage I Pressure Ulcers (M1322)');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1322').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1322').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
		
		
			/* For M1308 to M1320 */
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_pt_soc')
	{
		var oasis_therapy_pressure_ulcer_b_indicator=0;
		var oasis_therapy_pressure_ulcer_c_indicator=0;
		var oasis_therapy_pressure_ulcer_problematic_status_indicator=0;
		var oasis_therapy_pressure_ulcer_b=document.forms[form_name]['oasis_therapy_pressure_ulcer_b[]'];
		var oasis_therapy_pressure_ulcer_c=document.forms[form_name]['oasis_therapy_pressure_ulcer_c[]'];
		var oasis_therapy_pressure_ulcer_problematic_status=document.forms[form_name]['oasis_therapy_pressure_ulcer_problematic_status'];
		
		
		for(i=0;i<oasis_therapy_pressure_ulcer_b.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_b[i].value!='')
			oasis_therapy_pressure_ulcer_b_indicator=1;
		}
		for(i=0;i<oasis_therapy_pressure_ulcer_c.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_c[i].value!='')
			oasis_therapy_pressure_ulcer_c_indicator=1;
		}
		for(i=0;i<oasis_therapy_pressure_ulcer_problematic_status.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_problematic_status[i].checked)
			oasis_therapy_pressure_ulcer_problematic_status_indicator=1;
		}
		if((oasis_therapy_pressure_ulcer_b_indicator==0||oasis_therapy_pressure_ulcer_c_indicator==0) && error_indicator==0)
		{
		  
			if(oasis_therapy_pressure_ulcer_problematic_status_indicator==0)
			{
				alert('Please enter Status of Most Problematic (Observable) Pressure Ulcer (M1320)');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1320').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1320').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
		
		
		
	/*For M1330 to M1340*/
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption'||form_name=='oasis_discharge'||form_name=='oasis_pt_soc')
	{
		var oasis_therapy_pressure_ulcer_statis_ulcer_indicator=0;
		var oasis_therapy_surgical_wound_indicator=0;
		var oasis_therapy_pressure_ulcer_statis_ulcer=document.forms[form_name]['oasis_therapy_pressure_ulcer_statis_ulcer'];
		var oasis_therapy_surgical_wound=document.forms[form_name]['oasis_therapy_surgical_wound'];

		for(i=0;i<oasis_therapy_pressure_ulcer_statis_ulcer.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_statis_ulcer[i].checked)
			{
				if(oasis_therapy_pressure_ulcer_statis_ulcer[i].value=='0'||oasis_therapy_pressure_ulcer_statis_ulcer[i].value=='3')
				oasis_therapy_pressure_ulcer_statis_ulcer_indicator=1;
			}
		}
		for(i=0;i<oasis_therapy_surgical_wound.length;i++)
		{
			if(oasis_therapy_surgical_wound[i].checked)
			oasis_therapy_surgical_wound_indicator=1;
		}
		if(oasis_therapy_pressure_ulcer_statis_ulcer_indicator==1 && error_indicator==0)
		{
			if(oasis_therapy_surgical_wound_indicator==0)
			{
				alert('Please enter Surgical Wound (M1340)');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1340').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1340').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
		
	/*For M1340 to M1350*/
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption'||form_name=='oasis_discharge'||form_name=='oasis_pt_soc')
	{
		var oasis_therapy_surgical_wound_indicator_2=0;
		var oasis_therapy_skin_lesion_indicator=0;
		var oasis_therapy_surgical_wound=document.forms[form_name]['oasis_therapy_surgical_wound'];
		var oasis_therapy_skin_lesion=document.forms[form_name]['oasis_therapy_skin_lesion'];
		for(i=0;i<oasis_therapy_surgical_wound.length;i++)
		{
			if(oasis_therapy_surgical_wound[i].checked)
			{
				if(oasis_therapy_surgical_wound[i].value=='0'||oasis_therapy_surgical_wound[i].value=='2')
				oasis_therapy_surgical_wound_indicator_2=1;
			}
		}
		for(i=0;i<oasis_therapy_skin_lesion.length;i++)
		{
			if(oasis_therapy_skin_lesion[i].checked)
			oasis_therapy_skin_lesion_indicator=1;
		}
		if(oasis_therapy_surgical_wound_indicator_2==1 && error_indicator==0)
		{
			if(oasis_therapy_skin_lesion_indicator==0)
			{
				alert('Please enter Skin Lesion or Open Wound (M1350)');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1350').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1350').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
		
	/*For M1610 to M1620*/
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_nursing_resumption'||form_name=='oasis_discharge'||form_name=='oasis_pt_soc')
	{
		var oasis_elimination_status_urinary_incontinence_indicator=0;
		var oasis_elimination_status_bowel_incontinence_indicator=0;
		var oasis_elimination_status_urinary_incontinence=document.forms[form_name]['oasis_elimination_status_urinary_incontinence'];
		var oasis_elimination_status_bowel_incontinence=document.forms[form_name]['oasis_elimination_status_bowel_incontinence'];

		for(i=0;i<oasis_elimination_status_urinary_incontinence.length;i++)
		{
			if(oasis_elimination_status_urinary_incontinence[i].checked)
			{
				if(oasis_elimination_status_urinary_incontinence[i].value=='0'||oasis_elimination_status_urinary_incontinence[i].value=='2')
				oasis_elimination_status_urinary_incontinence_indicator=1;
			}
		}
		for(i=0;i<oasis_elimination_status_bowel_incontinence.length;i++)
		{
			if(oasis_elimination_status_bowel_incontinence[i].checked)
			oasis_elimination_status_bowel_incontinence_indicator=1;
		}
		if(oasis_elimination_status_urinary_incontinence_indicator==1 && error_indicator==0)
		{
			if(oasis_elimination_status_bowel_incontinence_indicator==0)
			{
				alert('Please enter Bowel Incontinence Frequency (M1620)');
				
			if($('#elimination_status').css('display') == 'none')
			{
			$('#elimination_status').slideToggle('fast', function(){
			$('#m1620').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1620').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
		
	/*For M2000 to M2010 and M2040*/
	if(form_name=='oasis_nursing_soc'||form_name=='oasis_pt_soc')
	{
		var oasis_adl_drug_regimen_indicator=0;
		var oasis_adl_patient_caregiver_indicator=0;
		var oasis_adl_func_oral_med_indicator=0;
		var oasis_adl_inject_med_indicator=0;
		var oasis_adl_drug_regimen=document.forms[form_name]['oasis_adl_drug_regimen'];
		var oasis_adl_patient_caregiver=document.forms[form_name]['oasis_adl_patient_caregiver'];
		var oasis_adl_func_oral_med=document.forms[form_name]['oasis_adl_func_oral_med'];
		var oasis_adl_inject_med=document.forms[form_name]['oasis_adl_inject_med'];
		for(i=0;i<oasis_adl_drug_regimen.length;i++)
		{
			if(oasis_adl_drug_regimen[i].checked)
			{
				if(oasis_adl_drug_regimen[i].value=='0'||oasis_adl_drug_regimen[i].value=='1')
				{
					oasis_adl_drug_regimen_indicator=1;
				}
				if(oasis_adl_drug_regimen[i].value=='NA')
				{
					oasis_adl_drug_regimen_indicator=2;
				}
			}
		}
		for(i=0;i<oasis_adl_patient_caregiver.length;i++)
		{
			if(oasis_adl_patient_caregiver[i].checked)
			oasis_adl_patient_caregiver_indicator=1;
		}
		for(i=0;i<oasis_adl_func_oral_med.length;i++)
		{
			if(oasis_adl_func_oral_med[i].checked)
			oasis_adl_func_oral_med_indicator=1;
		}
		for(i=0;i<oasis_adl_inject_med.length;i++)
		{
			if(oasis_adl_inject_med[i].checked)
			oasis_adl_inject_med_indicator=1;
		}
		
		if(oasis_adl_drug_regimen_indicator==1 && error_indicator==0)
		{
			if(oasis_adl_patient_caregiver_indicator==0)
			{
				alert('Please enter Patient/Caregiver High Risk Drug Education (M2010)');
			if($('#adl_iadls_contd').css('display') == 'none')
			{
			$('#adl_iadls_contd').slideToggle('fast', function(){
			$('#m2010').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m2010').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_adl_drug_regimen_indicator==2 && error_indicator==0)
		{
			if(oasis_adl_func_oral_med_indicator==0 || oasis_adl_inject_med_indicator==0)
			{
				alert('Please enter Prior Medication Management (M2040)');
			if($('#adl_iadls_contd').css('display') == 'none')
			{
			$('#adl_iadls_contd').slideToggle('fast', function(){
			$('#m2040').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m2040').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
	
/****************************  For OASIS Discharge **************************/

		/*For M0030 Start of Care Date */
	if(form_name=='oasis_discharge' || form_name=='oasistransfer')
	{
		if((document.forms[form_name]['oasis_therapy_soc_date'].value==null||document.forms[form_name]['oasis_therapy_soc_date'].value==''||document.forms[form_name]['oasis_therapy_soc_date'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Start of Care Date (M0030)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
		/*For M0090 Assessment Date */
	if(form_name=='oasis_discharge')
	{
		if((document.forms[form_name]['oasis_therapy_date_assessment_completed'].value==null||document.forms[form_name]['oasis_therapy_date_assessment_completed'].value==''||document.forms[form_name]['oasis_therapy_date_assessment_completed'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_therapy_date_assessment_completed').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_therapy_date_assessment_completed').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
		/* For M0030 greater than M0090  */
	if(form_name=='oasis_discharge')
	{
		if((document.forms[form_name]['oasis_therapy_soc_date'].value > document.forms[form_name]['oasis_therapy_date_assessment_completed'].value) && error_indicator==0)
		{
			alert('Start of Care Date (M0030) should be less than Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
			/* For M0906 greater than M0090  */
	if(form_name=='oasis_discharge')
	{
		if((document.forms[form_name]['oasis_discharge_transfer_date'].value > document.forms[form_name]['oasis_therapy_date_assessment_completed'].value) && error_indicator==0)
		{
			alert('Discharge/Transfer/Death Date (M0906) should be less than Date Assessment Completed (M0090)');
			
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasis_discharge_transfer_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_discharge_transfer_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	

		/*For M0100 Follow Up*/
	if(form_name=='oasis_discharge')
	{
		var oasis_therapy_follow_up_indicator=0;
		var oasis_therapy_follow_up=document.forms[form_name]['oasis_therapy_follow_up'];
		for(i=0;i<oasis_therapy_follow_up.length;i++)
		{
			if(oasis_therapy_follow_up[i].checked)
			oasis_therapy_follow_up_indicator=1;
		}
		if(oasis_therapy_follow_up_indicator==0 && error_indicator==0)
		{
			alert('Please enter Start/Resumption of Care Reason (M0100)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#m0100').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m0100').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
		/*For M0100 to M0903 and M1040*/
	if(form_name=='oasis_discharge')
	{
	  
		var oasis_therapy_follow_up_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var oasis_influenza_vaccine_indicator=0;
		var oasis_therapy_follow_up=document.forms[form_name]['oasis_therapy_follow_up'];
		var oasis_discharge_date_last_visit=document.forms[form_name]['oasis_discharge_date_last_visit'];
		var oasis_influenza_vaccine=document.forms[form_name]['oasis_influenza_vaccine'];

		for(i=0;i<oasis_therapy_follow_up.length;i++)
		{
			if(oasis_therapy_follow_up[i].checked)
			{
				if(oasis_therapy_follow_up[i].value=='8')
				{
					oasis_therapy_follow_up_indicator=1;
				}
				if(oasis_therapy_follow_up[i].value=='9')
				{
					oasis_therapy_follow_up_indicator=2;
				}
			}
		}
		
		if((document.forms[form_name]['oasis_discharge_date_last_visit'].value==null||document.forms[form_name]['oasis_discharge_date_last_visit'].value==''||document.forms[form_name]['oasis_discharge_date_last_visit'].value=='0000-00-00') && error_indicator==0)
		{
			oasis_discharge_date_last_visit_indicator=1;
		}
		
		for(i=0;i<oasis_influenza_vaccine.length;i++)
		{
			if(oasis_influenza_vaccine[i].checked)
			oasis_influenza_vaccine_indicator=1;
		}
		
		if(oasis_therapy_follow_up_indicator==1 && error_indicator==0)
		{
			if(oasis_discharge_date_last_visit_indicator==1)
			{
				alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_therapy_follow_up_indicator==2 && error_indicator==0)
		{
			if(oasis_influenza_vaccine_indicator==0)
			{
				alert('Please enter Influenza Vaccine (M1040)');
			if($('#patient_history_diagnosis').css('display') == 'none')
			{
			$('#patient_history_diagnosis').slideToggle('fast', function(){
			$('#m1040').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1040').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
			/*For M0906 Discharge/Transfer/Death Date */
	if(form_name=='oasis_discharge')
	{
		if((document.forms[form_name]['oasis_discharge_transfer_date'].value==null||document.forms[form_name]['oasis_discharge_transfer_date'].value==''||document.forms[form_name]['oasis_discharge_transfer_date'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Discharge/Transfer/Death Date (M0906)');
			
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasis_discharge_transfer_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_discharge_transfer_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
	
	
		/*For M1040 to M1050 */
	if(form_name=='oasis_discharge')
	{
		var oasis_influenza_vaccine_indicator=0;
		var oasis_pneumococcal_vaccine_indicator=0;
		var oasis_influenza_vaccine=document.forms[form_name]['oasis_influenza_vaccine'];
		var oasis_pneumococcal_vaccine=document.forms[form_name]['oasis_pneumococcal_vaccine'];

		for(i=0;i<oasis_influenza_vaccine.length;i++)
		{
			if(oasis_influenza_vaccine[i].checked)
			{
				if(oasis_influenza_vaccine[i].value=='1'||oasis_influenza_vaccine[i].value=='2')
				oasis_influenza_vaccine_indicator=1;
			}
		}
		for(i=0;i<oasis_pneumococcal_vaccine.length;i++)
		{
			if(oasis_pneumococcal_vaccine[i].checked)
			oasis_pneumococcal_vaccine_indicator=1;
		}
		if(oasis_influenza_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_pneumococcal_vaccine_indicator==0)
			{
				alert('Please enter Pneumococcal Vaccine (M1050)');
				
			if($('#patient_history_diagnosis').css('display') == 'none')
			{
			$('#patient_history_diagnosis').slideToggle('fast', function(){
			$('#m1050').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1050').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
			/*For M1050 to M1500 and M1230*/
	if(form_name=='oasis_discharge')
	{
		var oasis_pneumococcal_vaccine_indicator=0;
		var oasis_cardiac_status_symptoms_indicator=0;
		var oasis_speech_and_oral_indicator=0;
		var oasis_pneumococcal_vaccine=document.forms[form_name]['oasis_pneumococcal_vaccine'];
		var oasis_cardiac_status_symptoms=document.forms[form_name]['oasis_cardiac_status_symptoms'];
		var oasis_speech_and_oral=document.forms[form_name]['oasis_speech_and_oral'];

		for(i=0;i<oasis_pneumococcal_vaccine.length;i++)
		{
			if(oasis_pneumococcal_vaccine[i].checked)
			{
				if(oasis_pneumococcal_vaccine[i].value=='1')
				{
					oasis_pneumococcal_vaccine_indicator=1;
				}
			}
		}
		
		for(i=0;i<oasis_cardiac_status_symptoms.length;i++)
		{
			if(oasis_cardiac_status_symptoms[i].checked)
			oasis_cardiac_status_symptoms_indicator=1;
		}
		
		for(i=0;i<oasis_speech_and_oral.length;i++)
		{
			if(oasis_speech_and_oral[i].checked)
			oasis_speech_and_oral_indicator=1;
		}
		
		if(oasis_pneumococcal_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_cardiac_status_symptoms_indicator==0)
			{
				alert('Please enter Symptoms in Heart Failure Patients (M1500)');
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1500').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1500').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_pneumococcal_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_speech_and_oral_indicator==0)
			{
				alert('Please enter Speech and Oral (Verbal) Expression of Language (M1230)');
			if($('#patient_history_diagnosis').css('display') == 'none')
			{
			$('#patient_history_diagnosis').slideToggle('fast', function(){
			$('#m1230').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1230').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
			/*For M1306 to M1322 */
	if(form_name=='oasis_discharge')
	{
		var oasis_therapy_integumentary_status_indicator=0;
		var oasis_therapy_pressure_ulcer_current_no_indicator=0;
		var oasis_therapy_integumentary_status=document.forms[form_name]['oasis_therapy_integumentary_status'];
		var oasis_therapy_pressure_ulcer_current_no=document.forms[form_name]['oasis_therapy_pressure_ulcer_current_no'];

		for(i=0;i<oasis_therapy_integumentary_status.length;i++)
		{
			if(oasis_therapy_integumentary_status[i].checked)
			{
				oasis_therapy_integumentary_status_indicator=1;
			}
		}
		for(i=0;i<oasis_therapy_pressure_ulcer_current_no.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_current_no[i].checked)
			oasis_therapy_pressure_ulcer_current_no_indicator=1;
		}
		if(oasis_therapy_integumentary_status_indicator==1 && error_indicator==0)
		{
			if(oasis_therapy_pressure_ulcer_current_no_indicator==0)
			{
				alert('Please enter Current Number of Stage I Pressure Ulcers (M1322)');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1322').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1322').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
			/* For M1308 to M1320 Follow Up */
		if(form_name=='oasis_discharge')
	{
		var oasis_therapy_pressure_ulcer_b_indicator=0;
		var oasis_therapy_pressure_ulcer_c_indicator=0;
		var oasis_therapy_pressure_ulcer_problematic_status_indicator=0;
		var oasis_therapy_pressure_ulcer_b=document.forms[form_name]['oasis_therapy_pressure_ulcer_b[]'];
		var oasis_therapy_pressure_ulcer_c=document.forms[form_name]['oasis_therapy_pressure_ulcer_c[]'];
		var oasis_therapy_pressure_ulcer_problematic_status=document.forms[form_name]['oasis_therapy_pressure_ulcer_problematic_status'];
		
		
		for(i=0;i<oasis_therapy_pressure_ulcer_b.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_b[i].value!='')
			oasis_therapy_pressure_ulcer_b_indicator=1;
		}
		for(i=0;i<oasis_therapy_pressure_ulcer_c.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_c[i].value!='')
			oasis_therapy_pressure_ulcer_c_indicator=1;
		}
		for(i=0;i<oasis_therapy_pressure_ulcer_problematic_status.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_problematic_status[i].checked)
			oasis_therapy_pressure_ulcer_problematic_status_indicator=1;
		}
		if((oasis_therapy_pressure_ulcer_b_indicator==0||oasis_therapy_pressure_ulcer_c_indicator==0) && error_indicator==0)
		{
		  
			if(oasis_therapy_pressure_ulcer_problematic_status_indicator==0)
			{
				alert('Please enter Status of Most Problematic (Observable) Pressure Ulcer (M1320)');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1320').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1320').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
				/* For M1500 to M2004 and M1600 */
	if(form_name=='oasis_discharge' || form_name=='oasistransfer')
	{
		var oasis_pneumococcal_vaccine_indicator=0;
		var oasis_cardiac_status_symptoms_indicator=0;
		var oasis_speech_and_oral_indicator=0;
		var oasis_pneumococcal_vaccine=document.forms[form_name]['oasis_cardiac_status_symptoms'];
		var oasis_cardiac_status_symptoms=document.forms[form_name]['oasis_medication_intervention'];
		var oasis_speech_and_oral=document.forms[form_name]['oasis_elimination_status_tract_infection'];

		if(form_name=='oasistransfer')
		{
		var oasis_pneumococcal_vaccine=document.forms[form_name]['oasistransfer_Cardiac_Status'];
		var oasis_cardiac_status_symptoms=document.forms[form_name]['oasistransfer_Medication_Intervention'];
		var oasis_speech_and_oral=document.forms[form_name]['oasis_elimination_status_tract_infection'];
		}
		
		for(i=0;i<oasis_pneumococcal_vaccine.length;i++)
		{
			if(oasis_pneumococcal_vaccine[i].checked)
			{
				if(oasis_pneumococcal_vaccine[i].value=='0' || oasis_pneumococcal_vaccine[i].value=='2' || oasis_pneumococcal_vaccine[i].value=='NA' || oasis_pneumococcal_vaccine[i].value=='patient_didnot_Exhibit_Symptoms' || oasis_pneumococcal_vaccine[i].value=='Not_Assessed' || oasis_pneumococcal_vaccine[i].value=='oasistransfer_Cardiac_Status')
				{
					oasis_pneumococcal_vaccine_indicator=1;
				}
			}
		}
		
		for(i=0;i<oasis_cardiac_status_symptoms.length;i++)
		{
			if(oasis_cardiac_status_symptoms[i].checked)
			oasis_cardiac_status_symptoms_indicator=1;
		}
		
		for(i=0;i<oasis_speech_and_oral.length;i++)
		{
			if(oasis_speech_and_oral[i].checked)
			oasis_speech_and_oral_indicator=1;
		}
		
		if(oasis_pneumococcal_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_cardiac_status_symptoms_indicator==0)
			{
				alert('Please enter Medication Intervention (M2004)');
			if($('#adl_iadls').css('display') == 'none')
			{
			$('#adl_iadls').slideToggle('fast', function(){
			$('#m2004').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m2004').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_pneumococcal_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_speech_and_oral_indicator==0)
			{
				alert('Please enter Urinary Tract Infection (M1600)');
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1600').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1600').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}

	
			/*For M2300 to M2400 */
	if(form_name=='oasis_discharge' || form_name=='oasistransfer')
	{
		var oasis_emergent_care_indicator=0;
		var oasis_data_items_a_indicator=0;
		var oasis_data_items_b_indicator=0;
		var oasis_data_items_c_indicator=0;
		var oasis_data_items_d_indicator=0;
		var oasis_data_items_e_indicator=0;
		var oasis_data_items_f_indicator=0;
		var oasis_emergent_care=document.forms[form_name]['oasis_emergent_care'];
		var oasis_data_items_a=document.forms[form_name]['oasis_data_items_a'];
		var oasis_data_items_b=document.forms[form_name]['oasis_data_items_b'];
		var oasis_data_items_c=document.forms[form_name]['oasis_data_items_c'];
		var oasis_data_items_d=document.forms[form_name]['oasis_data_items_d'];
		var oasis_data_items_e=document.forms[form_name]['oasis_data_items_e'];
		var oasis_data_items_f=document.forms[form_name]['oasis_data_items_f'];

		if(form_name=='oasistransfer')
		{
		var oasis_emergent_care=document.forms[form_name]['oasistransfer_Used_Emergent_Care'];
		var oasis_data_items_a=document.forms[form_name]['oasistransfer_Diabetic_foot_care'];
		var oasis_data_items_b=document.forms[form_name]['oasistransfer_Falls_prevention_Intervention'];
		var oasis_data_items_c=document.forms[form_name]['oasistransfer_Depression_intervention'];
		var oasis_data_items_d=document.forms[form_name]['oasistransfer_Intervention_to_monitor_pain'];
		var oasis_data_items_e=document.forms[form_name]['oasistransfer_Intervention_to_prevent_pressure_ulcers'];
		var oasis_data_items_f=document.forms[form_name]['oasistransfer_Pressure_ulcer_treatment'];
		}
		
		for(i=0;i<oasis_emergent_care.length;i++)
		{
			if(oasis_emergent_care[i].checked)
			{
				if(oasis_emergent_care[i].value=='0'||oasis_emergent_care[i].value=='NA'||oasis_emergent_care[i].value=='No'||oasis_emergent_care[i].value=='Unknown')
				oasis_emergent_care_indicator=1;
			}
		}
		for(i=0;i<oasis_data_items_a.length;i++)
		{
			if(oasis_data_items_a[i].checked)
			oasis_data_items_a_indicator=1;
		}
		for(i=0;i<oasis_data_items_b.length;i++)
		{
			if(oasis_data_items_b[i].checked)
			oasis_data_items_b_indicator=1;
		}
		for(i=0;i<oasis_data_items_c.length;i++)
		{
			if(oasis_data_items_c[i].checked)
			oasis_data_items_c_indicator=1;
		}
		for(i=0;i<oasis_data_items_d.length;i++)
		{
			if(oasis_data_items_d[i].checked)
			oasis_data_items_d_indicator=1;
		}
		for(i=0;i<oasis_data_items_e.length;i++)
		{
			if(oasis_data_items_e[i].checked)
			oasis_data_items_e_indicator=1;
		}
		for(i=0;i<oasis_data_items_f.length;i++)
		{
			if(oasis_data_items_f[i].checked)
			oasis_data_items_f_indicator=1;
		}
		if(oasis_emergent_care_indicator==1 && error_indicator==0)
		{
			if(oasis_data_items_a_indicator==0 || oasis_data_items_b_indicator==0 || oasis_data_items_c_indicator==0 || oasis_data_items_d_indicator==0 || oasis_data_items_e_indicator==0 || oasis_data_items_f_indicator==0)
			{
				alert('Please enter all the details in Intervention Synopsis (M2400)');
				
			if($('#care_management').css('display') == 'none')
			{
			$('#care_management').slideToggle('fast', function(){
			$('#m2400').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m2400').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}

	
			/*For M2410 to M2430, M0903 and M2440*/
	if(form_name=='oasis_discharge')
	{
		var oasis_inpatient_facility_indicator=0;
		var Reason_for_Hospitalization_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var patient_Admitted_to_a_Nursing_Home_indicator=0;
		var oasis_inpatient_facility=document.forms[form_name]['oasis_inpatient_facility'];
		var Reason_for_Hospitalization=document.forms[form_name]['Reason_for_Hospitalization[]'];
		var oasis_discharge_date_last_visit=document.forms[form_name]['oasis_discharge_date_last_visit'];
		var patient_Admitted_to_a_Nursing_Home=document.forms[form_name]['patient_Admitted_to_a_Nursing_Home[]'];
		
		for(i=0;i<oasis_inpatient_facility.length;i++)
		{
			if(oasis_inpatient_facility[i].checked)
			{
				if(oasis_inpatient_facility[i].value=='1')
				{
					oasis_inpatient_facility_indicator=1;
				}
				if(oasis_inpatient_facility[i].value=='2' || oasis_inpatient_facility[i].value=='4')
				{
					oasis_inpatient_facility_indicator=2;
				}
				if(oasis_inpatient_facility[i].value=='3')
				{
					oasis_inpatient_facility_indicator=3;
				}
			}
		}
		
		if((document.forms[form_name]['oasis_discharge_date_last_visit'].value==null||document.forms[form_name]['oasis_discharge_date_last_visit'].value==''||document.forms[form_name]['oasis_discharge_date_last_visit'].value=='0000-00-00') && error_indicator==0)
		{
			oasis_discharge_date_last_visit_indicator=1;
		}
		
		for(i=0;i<Reason_for_Hospitalization.length;i++)
		{
			if(Reason_for_Hospitalization[i].checked)
			Reason_for_Hospitalization_indicator=1;
		}
		
		for(i=0;i<patient_Admitted_to_a_Nursing_Home.length;i++)
		{
			if(patient_Admitted_to_a_Nursing_Home[i].checked)
			patient_Admitted_to_a_Nursing_Home_indicator=1;
		}
		
		if(oasis_inpatient_facility_indicator==2 && error_indicator==0)
		{
			if(oasis_discharge_date_last_visit_indicator==1)
			{
			alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_inpatient_facility_indicator==1 && error_indicator==0)
		{
			if(Reason_for_Hospitalization_indicator==0)
			{
			alert('Please enter Reason for Hospitalization (M2430)');
			if($('#care_management').css('display') == 'none')
			{
			$('#care_management').slideToggle('fast', function(){
			$('#m2430').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m2430').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_inpatient_facility_indicator==3 && error_indicator==0)
		{
			if(patient_Admitted_to_a_Nursing_Home_indicator==0)
			{
			alert('Please enter Reason(s) for the patient Admitted to a Nursing Home (M2440)');
			if($('#care_management').css('display') == 'none')
			{
			$('#care_management').slideToggle('fast', function(){
			$('#m2440').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m2440').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
		/*For M2430 to M0903*/
	if(form_name=='oasis_discharge')
	{
		var Reason_for_Hospitalization_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var Reason_for_Hospitalization=document.forms[form_name]['Reason_for_Hospitalization[]'];
		var oasis_discharge_date_last_visit=document.forms[form_name]['oasis_discharge_date_last_visit'];
		if(Reason_for_Hospitalization[20].checked && error_indicator==0)
		{
		  
		  	if((document.forms[form_name]['oasis_discharge_date_last_visit'].value==null||document.forms[form_name]['oasis_discharge_date_last_visit'].value==''||document.forms[form_name]['oasis_discharge_date_last_visit'].value=='0000-00-00') && error_indicator==0)
			{
				oasis_discharge_date_last_visit_indicator=1;
			}
		  
			if(oasis_discharge_date_last_visit_indicator==1)
			{
			alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
			/*For M2440 to M0903*/
	if(form_name=='oasis_discharge')
	{
		var patient_Admitted_to_a_Nursing_Home_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var patient_Admitted_to_a_Nursing_Home=document.forms[form_name]['patient_Admitted_to_a_Nursing_Home[]'];
		var oasis_discharge_date_last_visit=document.forms[form_name]['oasis_discharge_date_last_visit'];
		if(patient_Admitted_to_a_Nursing_Home[6].checked && error_indicator==0)
		{
		  
		  
		  	if((document.forms[form_name]['oasis_discharge_date_last_visit'].value==null||document.forms[form_name]['oasis_discharge_date_last_visit'].value==''||document.forms[form_name]['oasis_discharge_date_last_visit'].value=='0000-00-00') && error_indicator==0)
			{
				oasis_discharge_date_last_visit_indicator=1;
			}
			if(oasis_discharge_date_last_visit_indicator==1)
			{
			alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
	
	
			/*For M2420 to M0903 */
	if(form_name=='oasis_discharge')
	{
		var oasis_influenza_vaccine_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var oasis_influenza_vaccine=document.forms[form_name]['oasis_discharge_disposition'];
		var oasis_discharge_date_last_visit=document.forms[form_name]['oasis_discharge_date_last_visit'];

		for(i=0;i<oasis_influenza_vaccine.length;i++)
		{
			if(oasis_influenza_vaccine[i].checked)
			{
				if(oasis_influenza_vaccine[i].value=='UK')
				oasis_influenza_vaccine_indicator=1;
			}
		}
		if((document.forms[form_name]['oasis_discharge_date_last_visit'].value==null||document.forms[form_name]['oasis_discharge_date_last_visit'].value==''||document.forms[form_name]['oasis_discharge_date_last_visit'].value=='0000-00-00') && error_indicator==0)
		{
			oasis_discharge_date_last_visit_indicator=1;
		}
		if(oasis_influenza_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_discharge_date_last_visit_indicator==1)
			{
			alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_discharge_date_last_visit').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	/****************************      For OASIS-C Tansfer         *******************************/
			/*For M0090 Assessment Date */
	if(form_name=='oasistransfer')
	{
		if((document.forms[form_name]['oasistransfer_Assessment_Completed_Date'].value==null||document.forms[form_name]['oasistransfer_Assessment_Completed_Date'].value==''||document.forms[form_name]['oasistransfer_Assessment_Completed_Date'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasistransfer_Assessment_Completed_Date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasistransfer_Assessment_Completed_Date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
			/*For M0100 Follow Up*/
	if(form_name=='oasistransfer')
	{
		var oasis_therapy_follow_up_indicator=0;
		var oasis_therapy_follow_up=document.forms[form_name]['oasistransfer_Transfer_to_an_InPatient_Facility'];
		for(i=0;i<oasis_therapy_follow_up.length;i++)
		{
			if(oasis_therapy_follow_up[i].checked)
			oasis_therapy_follow_up_indicator=1;
		}
		if(oasis_therapy_follow_up_indicator==0 && error_indicator==0)
		{
			alert('Please enter Start/Resumption of Care Reason (M0100)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#m0100').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m0100').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
					/* For M0030 greater than M0090  */
	if(form_name=='oasistransfer')
	{
		if((document.forms[form_name]['oasis_therapy_soc_date'].value > document.forms[form_name]['oasistransfer_Assessment_Completed_Date'].value) && error_indicator==0)
		{
			alert('Start of Care Date (M0030) should be less than Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
				/* For M0906 greater than M0090  */
	if(form_name=='oasistransfer')
	{
		if((document.forms[form_name]['oasistransfer_Discharge_Transfer_Death_Date'].value > document.forms[form_name]['oasistransfer_Assessment_Completed_Date'].value) && error_indicator==0)
		{
			alert('Discharge/Transfer/Death Date (M0906) should be less than Date Assessment Completed (M0090)');
			
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasistransfer_Discharge_Transfer_Death_Date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasistransfer_Discharge_Transfer_Death_Date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
			/*For M0100 to M0903 and M1040*/
	if(form_name=='oasistransfer')
	{
		var oasis_therapy_follow_up_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var oasis_influenza_vaccine_indicator=0;
		var oasis_therapy_follow_up=document.forms[form_name]['oasistransfer_Transfer_to_an_InPatient_Facility'];
		var oasis_discharge_date_last_visit=document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'];
		var oasis_influenza_vaccine=document.forms[form_name]['oasistransfer_Influenza_Vaccine_received'];

		for(i=0;i<oasis_therapy_follow_up.length;i++)
		{
			if(oasis_therapy_follow_up[i].checked)
			{
				if(oasis_therapy_follow_up[i].value=='Death_at_Home')
				{
					oasis_therapy_follow_up_indicator=1;
				}
				if(oasis_therapy_follow_up[i].value=='Patient_Not_Discharged_from_Agency' || oasis_therapy_follow_up[i].value=='Patient_Discharged_from_Agency')
				{
					oasis_therapy_follow_up_indicator=2;
				}
			}
		}
		
		if((document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value==null||document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value==''||document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value=='0000-00-00') && error_indicator==0)
		{
			oasis_discharge_date_last_visit_indicator=1;
		}
		
		for(i=0;i<oasis_influenza_vaccine.length;i++)
		{
			if(oasis_influenza_vaccine[i].checked)
			oasis_influenza_vaccine_indicator=1;
		}
		
		if(oasis_therapy_follow_up_indicator==1 && error_indicator==0)
		{
			if(oasis_discharge_date_last_visit_indicator==1)
			{
				alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasistransfer_Last_Home_Visit_Date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasistransfer_Last_Home_Visit_Date').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_therapy_follow_up_indicator==2 && error_indicator==0)
		{
			if(oasis_influenza_vaccine_indicator==0)
			{
				alert('Please enter Influenza Vaccine (M1040)');
			if($('#patient_history_diagnosis').css('display') == 'none')
			{
			$('#patient_history_diagnosis').slideToggle('fast', function(){
			$('#m1040').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1040').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
			/* For M1040 to M1050 */
	if(form_name=='oasistransfer')
	{
		var oasis_influenza_vaccine_indicator=0;
		var oasis_pneumococcal_vaccine_indicator=0;
		var oasis_influenza_vaccine=document.forms[form_name]['oasistransfer_Influenza_Vaccine_received'];
		var oasis_pneumococcal_vaccine=document.forms[form_name]['oasistransfer_Pneumococcal_Vaccine_Recieved'];

		for(i=0;i<oasis_influenza_vaccine.length;i++)
		{
			if(oasis_influenza_vaccine[i].checked)
			{
				if(oasis_influenza_vaccine[i].value=='Yes'||oasis_influenza_vaccine[i].value=='NA')
				oasis_influenza_vaccine_indicator=1;
			}
		}
		for(i=0;i<oasis_pneumococcal_vaccine.length;i++)
		{
			if(oasis_pneumococcal_vaccine[i].checked)
			oasis_pneumococcal_vaccine_indicator=1;
		}
		if(oasis_influenza_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_pneumococcal_vaccine_indicator==0)
			{
				alert('Please enter Pneumococcal Vaccine (M1050)');
				
			if($('#patient_history_diagnosis').css('display') == 'none')
			{
			$('#patient_history_diagnosis').slideToggle('fast', function(){
			$('#m1050').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1050').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}

	
	
				/*For M1050 to M1500 and M1230*/
	if(form_name=='oasistransfer')
	{
		var oasis_pneumococcal_vaccine_indicator=0;
		var oasis_cardiac_status_symptoms_indicator=0;
		var oasis_speech_and_oral_indicator=0;
		var oasis_pneumococcal_vaccine=document.forms[form_name]['oasistransfer_Pneumococcal_Vaccine_Recieved'];
		var oasis_cardiac_status_symptoms=document.forms[form_name]['oasistransfer_Cardiac_Status'];
		var oasis_speech_and_oral=document.forms[form_name]['oasis_speech_and_oral'];

		for(i=0;i<oasis_pneumococcal_vaccine.length;i++)
		{
			if(oasis_pneumococcal_vaccine[i].checked)
			{
				if(oasis_pneumococcal_vaccine[i].value=='Yes')
				{
					oasis_pneumococcal_vaccine_indicator=1;
				}
			}
		}
		
		for(i=0;i<oasis_cardiac_status_symptoms.length;i++)
		{
			if(oasis_cardiac_status_symptoms[i].checked)
			oasis_cardiac_status_symptoms_indicator=1;
		}
		
		for(i=0;i<oasis_speech_and_oral.length;i++)
		{
			if(oasis_speech_and_oral[i].checked)
			oasis_speech_and_oral_indicator=1;
		}
		
		if(oasis_pneumococcal_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_cardiac_status_symptoms_indicator==0)
			{
				alert('Please enter Symptoms in Heart Failure Patients (M1500)');
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1500').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1500').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_pneumococcal_vaccine_indicator==1 && error_indicator==0)
		{
			if(oasis_speech_and_oral_indicator==0)
			{
				alert('Please enter Speech and Oral (Verbal) Expression of Language (M1230)');
			if($('#patient_history_diagnosis').css('display') == 'none')
			{
			$('#patient_history_diagnosis').slideToggle('fast', function(){
			$('#m1230').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1230').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}

		
					/*For M0906 Discharge/Transfer/Death Date */
	if(form_name=='oasistransfer')
	{
		if((document.forms[form_name]['oasistransfer_Discharge_Transfer_Death_Date'].value==null||document.forms[form_name]['oasistransfer_Discharge_Transfer_Death_Date'].value==''||document.forms[form_name]['oasistransfer_Discharge_Transfer_Death_Date'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Discharge/Transfer/Death Date (M0906)');
			
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasistransfer_Discharge_Transfer_Death_Date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasistransfer_Discharge_Transfer_Death_Date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
				/*For M2410 to M2430, M0903 and M2440*/
	if(form_name=='oasistransfer')
	{
		var oasis_inpatient_facility_indicator=0;
		var Reason_for_Hospitalization_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var patient_Admitted_to_a_Nursing_Home_indicator=0;
		var oasis_inpatient_facility=document.forms[form_name]['oasistransfer_Inpatient_Facility_patient_admitted'];
		var oasis_discharge_date_last_visit=document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'];
		
		for(i=0;i<oasis_inpatient_facility.length;i++)
		{
			if(oasis_inpatient_facility[i].checked)
			{
				if(oasis_inpatient_facility[i].value=='Hospital')
				{
					oasis_inpatient_facility_indicator=1;
				}
				if(oasis_inpatient_facility[i].value=='Rehabilitation_Facility' || oasis_inpatient_facility[i].value=='Hospice')
				{
					oasis_inpatient_facility_indicator=2;
				}
				if(oasis_inpatient_facility[i].value=='Nursing_home')
				{
					oasis_inpatient_facility_indicator=3;
				}
			}
		}
		
		if((document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value==null||document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value==''||document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value=='0000-00-00') && error_indicator==0)
		{
			oasis_discharge_date_last_visit_indicator=1;
		}
		
		if((document.forms[form_name]['oasistransfer_Hospitalized_for_Improper_medication'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Injury_caused_by_fall'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Respiratory_infection'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Other_respiratory_problem'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Heart_failure'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Cardiac_dysrhythmia'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Chest_Pain'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Other_heart_disease'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Stroke_or_TIA'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Hypo_Hyperglycemia'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_GI_bleeding'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Dehydration_malnutrition'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Urinary_tract_infection'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_IV_catheter_related_infection'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Wound_infection'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Uncontrolled_pain'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Acute_health_problem'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Deep_vein_thrombosis'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_scheduled_Treatment'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Other_Reason'].checked || document.forms[form_name]['oasistransfer_Hospitalized_for_Reason_unknown'].checked) && error_indicator==0)
		{
			Reason_for_Hospitalization_indicator=1;
		}
		
		if((document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_for_Theraphy_Services'].checked || document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_for_Respite_care'].checked || document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_for_Hospice_care'].checked || document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_for_Permanent_placement'].checked || document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_as_Unsafe_at_home'].checked || document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_for_Other_Reason'].checked || document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason'].checked) && error_indicator==0)
		{
			patient_Admitted_to_a_Nursing_Home_indicator=1;
		}
		
		if(oasis_inpatient_facility_indicator==2 && error_indicator==0)
		{
			if(oasis_discharge_date_last_visit_indicator==1)
			{
			alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasistransfer_Last_Home_Visit_Date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasistransfer_Last_Home_Visit_Date').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_inpatient_facility_indicator==1 && error_indicator==0)
		{
			if(Reason_for_Hospitalization_indicator==0)
			{
			alert('Please enter Reason for Hospitalization (M2430)');
			if($('#care_management').css('display') == 'none')
			{
			$('#care_management').slideToggle('fast', function(){
			$('#m2430').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m2430').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
		if(oasis_inpatient_facility_indicator==3 && error_indicator==0)
		{
			if(patient_Admitted_to_a_Nursing_Home_indicator==0)
			{
			alert('Please enter Reason(s) for the patient Admitted to a Nursing Home (M2440)');
			if($('#care_management').css('display') == 'none')
			{
			$('#care_management').slideToggle('fast', function(){
			$('#m2440').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m2440').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
			/*For M2430 to M0903*/
	if(form_name=='oasistransfer')
	{
		var Reason_for_Hospitalization_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var Reason_for_Hospitalization=document.forms[form_name]['oasistransfer_Hospitalized_for_Reason_unknown'];
		var oasistransfer_Last_Home_Visit_Date=document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'];
		if(document.forms[form_name]['oasistransfer_Hospitalized_for_Reason_unknown'].checked && error_indicator==0)
		{
		  
		  	if((document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value==null||document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value==''||document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value=='0000-00-00') && error_indicator==0)
			{
				oasis_discharge_date_last_visit_indicator=1;
			}
		  
			if(oasis_discharge_date_last_visit_indicator==1)
			{
			alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasistransfer_Last_Home_Visit_Date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasistransfer_Last_Home_Visit_Date').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
			/*For M2440 to M0903*/
	if(form_name=='oasistransfer')
	{
		var patient_Admitted_to_a_Nursing_Home_indicator=0;
		var oasis_discharge_date_last_visit_indicator=0;
		var patient_Admitted_to_a_Nursing_Home=document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason'];
		var oasistransfer_Last_Home_Visit_Date=document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'];
		if(document.forms[form_name]['oasistransfer_Admitted_in_NursingHome_for_Unknown_Reason'].checked && error_indicator==0)
		{
		  
		  
		  	if((document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value==null||document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value==''||document.forms[form_name]['oasistransfer_Last_Home_Visit_Date'].value=='0000-00-00') && error_indicator==0)
			{
				oasis_discharge_date_last_visit_indicator=1;
			}
			if(oasis_discharge_date_last_visit_indicator==1)
			{
			alert('Please enter Date of Last (Most Recent) Home Visit (M0903)');
			if($('#summary').css('display') == 'none')
			{
			$('#summary').slideToggle('fast', function(){
			$('#oasistransfer_Last_Home_Visit_Date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasistransfer_Last_Home_Visit_Date').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
	
	
	
	
	/*********************************************************  Code Compression has to be performed from this  ****************************************************/
	
	
	/**************************************        For Oasis-C Nurse Recertification & Oasis-C PT Recert        ************************************/
	
	
		/* For M0030 Assessment Date */
	if(form_name=='oasis_c_nurse')
	{
		if((document.forms[form_name]['oasis_c_nurse_soc_date'].value==null||document.forms[form_name]['oasis_c_nurse_soc_date'].value==''||document.forms[form_name]['oasis_c_nurse_soc_date'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Start of Care Date (M0030)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_c_nurse_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_c_nurse_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
		
	}
	
		/* For M0090 Assessment Date */
	if(form_name=='oasis_c_nurse')
	{
		if((document.forms[form_name]['oasis_c_nurse_date_assessment_completed'].value==null||document.forms[form_name]['oasis_c_nurse_date_assessment_completed'].value==''||document.forms[form_name]['oasis_c_nurse_date_assessment_completed'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_c_nurse_date_assessment_completed').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_c_nurse_date_assessment_completed').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
				/* For M0030 greater than M0090  */
	if(form_name=='oasis_c_nurse')
	{
		if((document.forms[form_name]['oasis_c_nurse_soc_date'].value > document.forms[form_name]['oasis_c_nurse_date_assessment_completed'].value) && error_indicator==0)
		{
			alert('Start of Care Date (M0030) should be less than Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_c_nurse_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_c_nurse_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
	
			/* For M0030 Assessment Date for Oasis-C PT Recert*/
	if(form_name=='oasis_therapy_rectification')
	{
		if((document.forms[form_name]['oasis_therapy_soc_date'].value==null||document.forms[form_name]['oasis_therapy_soc_date'].value==''||document.forms[form_name]['oasis_therapy_soc_date'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Start of Care Date (M0030)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
		/* For M0090 Assessment Date for Oasis-C PT Recert*/
	if(form_name=='oasis_therapy_rectification')
	{
		if((document.forms[form_name]['oasis_therapy_date_assessment_completed'].value==null||document.forms[form_name]['oasis_therapy_date_assessment_completed'].value==''||document.forms[form_name]['oasis_therapy_date_assessment_completed'].value=='0000-00-00') && error_indicator==0)
		{
			alert('Please enter Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_therapy_date_assessment_completed').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_therapy_date_assessment_completed').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
					/* For M0030 greater than M0090  */
	if(form_name=='oasis_therapy_rectification')
	{
		if((document.forms[form_name]['oasis_therapy_soc_date'].value > document.forms[form_name]['oasis_therapy_date_assessment_completed'].value) && error_indicator==0)
		{
			alert('Start of Care Date (M0030) should be less than Date Assessment Completed (M0090)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#oasis_therapy_soc_date').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
	
			/*For M0100 Follow Up*/
	if(form_name=='oasis_c_nurse' || form_name=='oasis_therapy_rectification' || form_name=='oasis_pt_soc')
	{
		var oasis_therapy_follow_up_indicator=0;
		var oasis_therapy_follow_up=document.forms[form_name]['oasis_c_nurse_follow_up'];
		if(form_name=='oasis_therapy_rectification')
		{
		  var oasis_therapy_follow_up=document.forms[form_name]['oasis_therapy_follow_up'];
		}
		if(form_name=='oasis_pt_soc')
		{
		  var oasis_therapy_follow_up=document.forms[form_name]['oasis_patient_follow_up'];
		}
		for(i=0;i<oasis_therapy_follow_up.length;i++)
		{
			if(oasis_therapy_follow_up[i].checked)
			oasis_therapy_follow_up_indicator=1;
		}
		if(oasis_therapy_follow_up_indicator==0 && error_indicator==0)
		{
			alert('Please enter Start/Resumption of Care Reason (M0100)');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#m0100').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m0100').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
	}
	
	
		/*For M0100 Follow Up to M0110*/
	if(form_name=='oasis_c_nurse' || form_name=='oasis_therapy_rectification')
	{
		var oasis_patient_follow_up_indicator=0;
		var oasis_patient_episode_timing_indicator=0;
		var oasis_patient_follow_up=document.forms[form_name]['oasis_c_nurse_follow_up'];
		var oasis_patient_episode_timing=document.forms[form_name]['oasis_c_nurse_episode_timing'];
		if(form_name=='oasis_therapy_rectification')
		{
		  var oasis_patient_follow_up=document.forms[form_name]['oasis_therapy_follow_up'];
		  var oasis_patient_episode_timing=document.forms[form_name]['oasis_therapy_episode_timing'];
		}
		for(i=0;i<oasis_patient_follow_up.length;i++)
		{
			if(oasis_patient_follow_up[i].checked)
			oasis_patient_follow_up_indicator=1;
		}
		if(oasis_patient_follow_up_indicator==0 && error_indicator==0)
		{
			alert('Please enter M0100');
			error_indicator=1;
		}
		for(i=0;i<oasis_patient_episode_timing.length;i++)
		{
			if(oasis_patient_episode_timing[i].checked)
			oasis_patient_episode_timing_indicator=1;
		}
		if(oasis_patient_episode_timing_indicator==0 && error_indicator==0)
		{
			alert('Please enter Episode Timing M0110');
			
			if($('#patient_track_info').css('display') == 'none')
			{
			$('#patient_track_info').slideToggle('fast', function(){
			$('#m0110').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m0110').css('border','1px solid red').focus();
			}
			error_indicator=1;
		}
		
	}
	
	/*For M1306 to M1322*/
	if(form_name=='oasis_c_nurse' || form_name=='oasis_therapy_rectification')
	{
		var oasis_pressure_ulcer_unhealed_s2_indicator_2=0;
		var oasis_therapy_pressure_ulcer_current_no_indicator=0;
		var oasis_pressure_ulcer_unhealed_s2=document.forms[form_name]['oasis_integumentary_status'];
		var oasis_therapy_pressure_ulcer_current_no=document.forms[form_name]['oasis_c_nurse_current_ulcer_stage1'];
		
		if(form_name=='oasis_therapy_rectification')
		{
		  var oasis_pressure_ulcer_unhealed_s2=document.forms[form_name]['oasis_therapy_integumentary_status'];
		  var oasis_therapy_pressure_ulcer_current_no=document.forms[form_name]['oasis_therapy_current_ulcer_stage1'];
		}
		for(i=0;i<oasis_pressure_ulcer_unhealed_s2.length;i++)
		{
			if(oasis_pressure_ulcer_unhealed_s2[i].checked)
			{
				if(oasis_pressure_ulcer_unhealed_s2[i].value=='0')
				oasis_pressure_ulcer_unhealed_s2_indicator_2=1;
			}
		}
		for(i=0;i<oasis_therapy_pressure_ulcer_current_no.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_current_no[i].checked)
			oasis_therapy_pressure_ulcer_current_no_indicator=1;
		}
		if(oasis_pressure_ulcer_unhealed_s2_indicator_2==1 && error_indicator==0)
		{
			if(oasis_therapy_pressure_ulcer_current_no_indicator==0)
			{
				alert('Please enter Current Number of Stage I Pressure Ulcers (M1322) **');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1322').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1322').css('border','1px solid red').focus();
			}
				error_indicator=1;
				
				
			}
		}
		
	}
	
		/*For M1330 to M1340*/
	if(form_name=='oasis_c_nurse' || form_name=='oasis_therapy_rectification')
	{
		var oasis_therapy_pressure_ulcer_statis_ulcer_indicator=0;
		var oasis_therapy_surgical_wound_indicator=0;
		var oasis_therapy_pressure_ulcer_statis_ulcer=document.forms[form_name]['oasis_c_nurse_statis_ulcer'];
		var oasis_therapy_surgical_wound=document.forms[form_name]['oasis_c_nurse_surgical_wound'];
		
		if(form_name=='oasis_therapy_rectification')
		{
		  var oasis_therapy_pressure_ulcer_statis_ulcer=document.forms[form_name]['oasis_therapy_statis_ulcer'];
		  var oasis_therapy_surgical_wound=document.forms[form_name]['oasis_therapy_surgical_wound'];
		}
		
		for(i=0;i<oasis_therapy_pressure_ulcer_statis_ulcer.length;i++)
		{
			if(oasis_therapy_pressure_ulcer_statis_ulcer[i].checked)
			{
				if(oasis_therapy_pressure_ulcer_statis_ulcer[i].value=='0'||oasis_therapy_pressure_ulcer_statis_ulcer[i].value=='3')
				oasis_therapy_pressure_ulcer_statis_ulcer_indicator=1;
			}
		}
		for(i=0;i<oasis_therapy_surgical_wound.length;i++)
		{
			if(oasis_therapy_surgical_wound[i].checked)
			oasis_therapy_surgical_wound_indicator=1;
		}
		if(oasis_therapy_pressure_ulcer_statis_ulcer_indicator==1 && error_indicator==0)
		{
			if(oasis_therapy_surgical_wound_indicator==0)
			{
				alert('Please enter Surgical Wound (M1340)');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			$('#m1340').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1340').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
		/*For M1340 to M1350*/
	if(form_name=='oasis_c_nurse' || form_name=='oasis_therapy_rectification')
	{
		var oasis_therapy_surgical_wound_indicator_2=0;
		var oasis_therapy_skin_lesion_indicator=0;
		var oasis_therapy_surgical_wound=document.forms[form_name]['oasis_c_nurse_surgical_wound'];
		var oasis_therapy_skin_lesion=document.forms[form_name]['oasis_c_nurse_skin_lesion'];
		
		if(form_name=='oasis_therapy_rectification')
		{
		  var oasis_therapy_surgical_wound=document.forms[form_name]['oasis_therapy_surgical_wound'];
		  var oasis_therapy_skin_lesion=document.forms[form_name]['oasis_therapy_skin_lesion'];
		}
		
		for(i=0;i<oasis_therapy_surgical_wound.length;i++)
		{
			if(oasis_therapy_surgical_wound[i].checked)
			{
				if(oasis_therapy_surgical_wound[i].value=='0'||oasis_therapy_surgical_wound[i].value=='2')
				oasis_therapy_surgical_wound_indicator_2=1;
			}
		}
		for(i=0;i<oasis_therapy_skin_lesion.length;i++)
		{
			if(oasis_therapy_skin_lesion[i].checked)
			oasis_therapy_skin_lesion_indicator=1;
		}
		if(oasis_therapy_surgical_wound_indicator_2==1 && error_indicator==0)
		{
			if(oasis_therapy_skin_lesion_indicator==0)
			{
				alert('Please enter Skin Lesion or Open Wound (M1350)');
				
			if($('#integumentary_status').css('display') == 'none')
			{
			$('#integumentary_status').slideToggle('fast', function(){
			  alert('no prob till here - inside intr');
			$('#m1350').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1350').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
	
	
		/*For M1610 to M1620*/
	if(form_name=='oasis_c_nurse' || form_name=='oasis_therapy_rectification')
	{
		var oasis_elimination_status_urinary_incontinence_indicator=0;
		var oasis_elimination_status_bowel_incontinence_indicator=0;
		var oasis_elimination_status_urinary_incontinence=document.forms[form_name]['oasis_c_nurse_elimination_urinary_incontinence'];
		var oasis_elimination_status_bowel_incontinence=document.forms[form_name]['oasis_c_nurse_elimination_bowel_incontinence'];
		
		if(form_name=='oasis_therapy_rectification')
		{
		  var oasis_elimination_status_urinary_incontinence=document.forms[form_name]['oasis_therapy_elimination_urinary_incontinence'];
		  var oasis_elimination_status_bowel_incontinence=document.forms[form_name]['oasis_therapy_elimination_bowel_incontinence'];
		}
		
		for(i=0;i<oasis_elimination_status_urinary_incontinence.length;i++)
		{
			if(oasis_elimination_status_urinary_incontinence[i].checked)
			{
				if(oasis_elimination_status_urinary_incontinence[i].value=='0'||oasis_elimination_status_urinary_incontinence[i].value=='2')
				oasis_elimination_status_urinary_incontinence_indicator=1;
			}
		}
		for(i=0;i<oasis_elimination_status_bowel_incontinence.length;i++)
		{
			if(oasis_elimination_status_bowel_incontinence[i].checked)
			oasis_elimination_status_bowel_incontinence_indicator=1;
		}
		if(oasis_elimination_status_urinary_incontinence_indicator==1 && error_indicator==0)
		{
			if(oasis_elimination_status_bowel_incontinence_indicator==0)
			{
				alert('Please enter Bowel Incontinence Frequency (M1620)');
				
			if($('#elimination_status').css('display') == 'none')
			{
			$('#elimination_status').slideToggle('fast', function(){
			$('#m1620').css('border','1px solid red').focus();
			});
			}
			else{
			  $('#m1620').css('border','1px solid red').focus();
			}
				error_indicator=1;
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*Submit Form if no error*/
	if(error_indicator==0)
	{
		document.forms[form_name].submit();
	}
}




function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

