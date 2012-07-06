<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");


if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_ot_Evaluation", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "Evaluation", $newid, "evaluation", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_ot_Evaluation set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
Evaluation_date='".$_POST["Evaluation_date"]."',
Evaluation_Time_In='".$_POST["Evaluation_Time_In"]."',
Evaluation_Time_Out='".$_POST["Evaluation_Time_Out"]."',
Evaluation_Pulse='".$_POST["Evaluation_Pulse"]."',
Evaluation_Pulse_State='".$_POST["Evaluation_Pulse_State"]."',
Evaluation_Temperature='".$_POST["Evaluation_Temperature"]."',
Evaluation_Temperature_type='".$_POST["Evaluation_Temperature_type"]."',
Evaluation_VS_other='".$_POST["Evaluation_VS_other"]."',
Evaluation_VS_Respirations='".$_POST["Evaluation_VS_Respirations"]."',
Evaluation_VS_BP_Systolic='".$_POST["Evaluation_VS_BP_Systolic"]."',
Evaluation_VS_BP_Diastolic='".$_POST["Evaluation_VS_BP_Diastolic"]."',
Evaluation_VS_BP_side='".$_POST["Evaluation_VS_BP_side"]."',
Evaluation_VS_BP_Body_Position='".$_POST["Evaluation_VS_BP_Body_Position"]."',
Evaluation_VS_Sat='".$_POST["Evaluation_VS_Sat"]."',
Evaluation_VS_Pain='".$_POST["Evaluation_VS_Pain"]."',
Evaluation_VS_Pain_Intensity='".$_POST["Evaluation_VS_Pain_Intensity"]."',
Evaluation_VS_Location='".$_POST["Evaluation_VS_Location"]."',
Evaluation_VS_Other1='".$_POST["Evaluation_VS_Other1"]."',
Evaluation_HR_Needs_assistance='".$_POST["Evaluation_HR_Needs_assistance"]."',
Evaluation_HR_Unable_to_leave_home='".$_POST["Evaluation_HR_Unable_to_leave_home"]."',
Evaluation_HR_Medical_Restrictions='".$_POST["Evaluation_HR_Medical_Restrictions"]."',
Evaluation_HR_Medical_Restrictions_In='".$_POST["Evaluation_HR_Medical_Restrictions_In"]."',
Evaluation_HR_SOB_upon_exertion='".$_POST["Evaluation_HR_SOB_upon_exertion"]."',
Evaluation_HR_Pain_with_Travel='".$_POST["Evaluation_HR_Pain_with_Travel"]."',
Evaluation_HR_Requires_assistance='".$_POST["Evaluation_HR_Requires_assistance"]."',
Evaluation_HR_Arrhythmia='".$_POST["Evaluation_HR_Arrhythmia"]."',
Evaluation_HR_Bed_Bound='".$_POST["Evaluation_HR_Bed_Bound"]."',
Evaluation_HR_Residual_Weakness='".$_POST["Evaluation_HR_Residual_Weakness"]."',
Evaluation_HR_Confusion='".$_POST["Evaluation_HR_Confusion"]."',
Evaluation_HR_Other='".$_POST["Evaluation_HR_Other"]."',
Evaluation_Reason_for_intervention='".$_POST["Evaluation_Reason_for_intervention"]."',
Evaluation_TREATMENT_DX_OT_Problem='".$_POST["Evaluation_TREATMENT_DX_OT_Problem"]."',
Evaluation_PERTINENT_MEDICAL_HISTORY='".$_POST["Evaluation_PERTINENT_MEDICAL_HISTORY"]."',
Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS='".$_POST["Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"]."',
Evaluation_MFP_WB_status='".$_POST["Evaluation_MFP_WB_status"]."',
Evaluation_MFP_Other='".$_POST["Evaluation_MFP_Other"]."',
Evaluation_PRIOR_LEVEL_OF_FUNCTIONING='".$_POST["Evaluation_PRIOR_LEVEL_OF_FUNCTIONING"]."',
Evaluation_PLOF_IADLs='".$_POST["Evaluation_PLOF_IADLs"]."',
Evaluation_FAMILY_CAREGIVER_SUPPORT='".$_POST["Evaluation_FAMILY_CAREGIVER_SUPPORT"]."',
Evaluation_FCS_Relationship='".$_POST["Evaluation_FCS_Relationship"]."',
Evaluation_Visits_in_Community='".$_POST["Evaluation_Visits_in_Community"]."',
Evaluation_ADL_FEEDING='".$_POST["Evaluation_ADL_FEEDING"]."',
Evaluation_ADL_UTENSILCUP_USE='".$_POST["Evaluation_ADL_UTENSILCUP_USE"]."',
Evaluation_ADL_GROOMING='".$_POST["Evaluation_ADL_GROOMING"]."',
Evaluation_ADL_ORAL_HYGIENE='".$_POST["Evaluation_ADL_ORAL_HYGIENE"]."',
Evaluation_ADL_BED_WC_TRANSFERS='".$_POST["Evaluation_ADL_BED_WC_TRANSFERS"]."',
Evaluation_ADL_TOILET_TRANSFERS='".$_POST["Evaluation_ADL_TOILET_TRANSFERS"]."',
Evaluation_ADL_OTHERS_TEXT='".$_POST["Evaluation_ADL_OTHERS_TEXT"]."',
Evaluation_ADL_OTHERS='".$_POST["Evaluation_ADL_OTHERS"]."',
Evaluation_ADL_TOILETING='".$_POST["Evaluation_ADL_TOILETING"]."',
Evaluation_ADL_BATHING_SHOWER='".$_POST["Evaluation_ADL_BATHING_SHOWER"]."',
Evaluation_ADL_UB_DRESSING='".$_POST["Evaluation_ADL_UB_DRESSING"]."',
Evaluation_ADL_LB_DRESSING='".$_POST["Evaluation_ADL_LB_DRESSING"]."',
Evaluation_ADL_TUB_SHOWER_TRANSFERS='".$_POST["Evaluation_ADL_TUB_SHOWER_TRANSFERS"]."',
Evaluation_CI_ADL_HOUSEKEEPING='".$_POST["Evaluation_CI_ADL_HOUSEKEEPING"]."',
Evaluation_CI_ADL_HOUSEKEEPING1='".$_POST["Evaluation_CI_ADL_HOUSEKEEPING1"]."',
Evaluation_CI_ADL_PHONE_USAGE='".$_POST["Evaluation_CI_ADL_PHONE_USAGE"]."',
Evaluation_CI_ADL_COMMENTS='".$_POST["Evaluation_CI_ADL_COMMENTS"]."',
Evaluation_CI_ADL_COMMENTS1='".$_POST["Evaluation_CI_ADL_COMMENTS1"]."',
Evaluation_CI_ADL_LAUNDRY='".$_POST["Evaluation_CI_ADL_LAUNDRY"]."',
Evaluation_CI_ADL_GROCERY_SHOPPING='".$_POST["Evaluation_CI_ADL_GROCERY_SHOPPING"]."',
Evaluation_CI_ADL_MEAL_PREPARATION='".$_POST["Evaluation_CI_ADL_MEAL_PREPARATION"]."',
Evaluation_CI_ADL_MONEY_MANAGEMENT='".$_POST["Evaluation_CI_ADL_MONEY_MANAGEMENT"]."',
Evaluation_CI_ADL_TRASH_MANAGEMENT='".$_POST["Evaluation_CI_ADL_TRASH_MANAGEMENT"]."',
Evaluation_CI_ADL_TRANSPORTATION='".$_POST["Evaluation_CI_ADL_TRANSPORTATION"]."',
Evaluation_CI_ADL_OTHERS_TEXT='".$_POST["Evaluation_CI_ADL_OTHERS_TEXT"]."',
Evaluation_CI_ADL_OTHERS='".$_POST["Evaluation_CI_ADL_OTHERS"]."',
Evaluation_EnvBar_No_barriers='".$_POST["Evaluation_EnvBar_No_barriers"]."',
Evaluation_EnvBar_No_Safety_Issues='".$_POST["Evaluation_EnvBar_No_Safety_Issues"]."',
Evaluation_EnvBar_Bedroom_On_Second='".$_POST["Evaluation_EnvBar_Bedroom_On_Second"]."',
Evaluation_EnvBar_No_Inadequate_grab='".$_POST["Evaluation_EnvBar_No_Inadequate_grab"]."',
Evaluation_EnvBar_Throw_Rugs='".$_POST["Evaluation_EnvBar_Throw_Rugs"]."',
Evaluation_EnvBar_No_Inadequate_smoke='".$_POST["Evaluation_EnvBar_No_Inadequate_smoke"]."',
Evaluation_EnvBar_Telephone_Not_Working='".$_POST["Evaluation_EnvBar_Telephone_Not_Working"]."',
Evaluation_EnvBar_No_Emergency_Numbers='".$_POST["Evaluation_EnvBar_No_Emergency_Numbers"]."',
Evaluation_EnvBar_Lighting_Not_Adequate='".$_POST["Evaluation_EnvBar_Lighting_Not_Adequate"]."',
Evaluation_EnvBar_No_Handrails='".$_POST["Evaluation_EnvBar_No_Handrails"]."',
Evaluation_EnvBar_Stairs_Disrepair='".$_POST["Evaluation_EnvBar_Stairs_Disrepair"]."',
Evaluation_EnvBar_Fire_Extinguishers='".$_POST["Evaluation_EnvBar_Fire_Extinguishers"]."',
Evaluation_EnvBar_Other='".$_POST["Evaluation_EnvBar_Other"]."',
Evaluation_COG_Alert_type='".$_POST["Evaluation_COG_Alert_type"]."',
Evaluation_COG_Alert_note='".$_POST["Evaluation_COG_Alert_note"]."',
Evaluation_COG_Oriented_Type='".$_POST["Evaluation_COG_Oriented_Type"]."',
Evaluation_COG_Canfollow='".$_POST["Evaluation_COG_Canfollow"]."',
Evaluation_COG_Comments='".$_POST["Evaluation_COG_Comments"]."',
Evaluation_Skil_Safety_Awareness='".$_POST["Evaluation_Skil_Safety_Awareness"]."',
Evaluation_Skil_Attention_Span='".$_POST["Evaluation_Skil_Attention_Span"]."',
Evaluation_skil_Shortterm_Memory='".$_POST["Evaluation_skil_Shortterm_Memory"]."',
Evaluation_skil_Longterm_Memory='".$_POST["Evaluation_skil_Longterm_Memory"]."',
Evaluation_Mis_skil_Proprioception='".$_POST["Evaluation_Mis_skil_Proprioception"]."',
Evaluation_Mis_skil_Visual_Tracking='".$_POST["Evaluation_Mis_skil_Visual_Tracking"]."',
Evaluation_Mis_skil_Peripheral_Vision='".$_POST["Evaluation_Mis_skil_Peripheral_Vision"]."',
Evaluation_Mis_skil_Hearing='".$_POST["Evaluation_Mis_skil_Hearing"]."',
Evaluation_Mis_skil_Gross_Motor='".$_POST["Evaluation_Mis_skil_Gross_Motor"]."',
Evaluation_Mis_skil_Fine_Motor='".$_POST["Evaluation_Mis_skil_Fine_Motor"]."',
Evaluation_Mis_skil_Sensory='".$_POST["Evaluation_Mis_skil_Sensory"]."',
Evaluation_Mis_skil_Speech='".$_POST["Evaluation_Mis_skil_Speech"]."',
Evaluation_Activity_Tolerance_Type='".$_POST["Evaluation_Activity_Tolerance_Type"]."',
Evaluation_AT_Minutes_Participate_Note='".$_POST["Evaluation_AT_Minutes_Participate_Note"]."',
Evaluation_AT_SOB='".$_POST["Evaluation_AT_SOB"]."',
Evaluation_AT_RHC_Impacts_Activity='".$_POST["Evaluation_AT_RHC_Impacts_Activity"]."',
Evaluation_AT_Comments='".$_POST["Evaluation_AT_Comments"]."',
Evaluation_Assist_devices_Walker='".$_POST["Evaluation_Assist_devices_Walker"]."',
Evaluation_Assist_devices_Walker_Type='".$_POST["Evaluation_Assist_devices_Walker_Type"]."',
Evaluation_Assist_devices_Wheelchair='".$_POST["Evaluation_Assist_devices_Wheelchair"]."',
Evaluation_Assist_devices_Cane='".$_POST["Evaluation_Assist_devices_Cane"]."',
Evaluation_Assist_devices_Cane_Type='".$_POST["Evaluation_Assist_devices_Cane_Type"]."',
Evaluation_Assist_devices_Glasses_For_Read='".$_POST["Evaluation_Assist_devices_Glasses_For_Read"]."',
Evaluation_Assist_devices_Glasses_For_Distance='".$_POST["Evaluation_Assist_devices_Glasses_For_Distance"]."',
Evaluation_Assist_devices_Hearing_Aid='".$_POST["Evaluation_Assist_devices_Hearing_Aid"]."',
Evaluation_Assist_devices_Other='".$_POST["Evaluation_Assist_devices_Other"]."',
Evaluation_CB_Skills_Dynamic_Sitting='".$_POST["Evaluation_CB_Skills_Dynamic_Sitting"]."',
Evaluation_CB_Skills_Static_Sitting='".$_POST["Evaluation_CB_Skills_Static_Sitting"]."',
Evaluation_CB_Skills_Dynamic_Standing='".$_POST["Evaluation_CB_Skills_Dynamic_Standing"]."',
Evaluation_CB_Skills_Static_Standing='".$_POST["Evaluation_CB_Skills_Static_Standing"]."',
Evaluation_MS_ROM_All_Muscle_WFL='".$_POST["Evaluation_MS_ROM_All_Muscle_WFL"]."',
Evaluation_MS_ROM_Following_Problem_areas='".$_POST["Evaluation_MS_ROM_Following_Problem_areas"]."',
Evaluation_MS_ROM_Problemarea_text='".$_POST["Evaluation_MS_ROM_Problemarea_text"]."',
Evaluation_MS_ROM_STRENGTH_Right='".$_POST["Evaluation_MS_ROM_STRENGTH_Right"]."',
Evaluation_MS_ROM_STRENGTH_Left='".$_POST["Evaluation_MS_ROM_STRENGTH_Left"]."',
Evaluation_MS_ROM_ROM='".$_POST["Evaluation_MS_ROM_ROM"]."',
Evaluation_MS_ROM_ROM_Type='".$_POST["Evaluation_MS_ROM_ROM_Type"]."',
Evaluation_MS_ROM_Tonicity='".$_POST["Evaluation_MS_ROM_Tonicity"]."',
Evaluation_MS_ROM_Further_description='".$_POST["Evaluation_MS_ROM_Further_description"]."',
Evaluation_MS_ROM_Problemarea_text1='".$_POST["Evaluation_MS_ROM_Problemarea_text1"]."',
Evaluation_MS_ROM_STRENGTH_Right1='".$_POST["Evaluation_MS_ROM_STRENGTH_Right1"]."',
Evaluation_MS_ROM_STRENGTH_Left1='".$_POST["Evaluation_MS_ROM_STRENGTH_Left1"]."',
Evaluation_MS_ROM_ROM1='".$_POST["Evaluation_MS_ROM_ROM1"]."',
Evaluation_MS_ROM_ROM_Type1='".$_POST["Evaluation_MS_ROM_ROM_Type1"]."',
Evaluation_MS_ROM_Tonicity1='".$_POST["Evaluation_MS_ROM_Tonicity1"]."',
Evaluation_MS_ROM_Further_description1='".$_POST["Evaluation_MS_ROM_Further_description1"]."',
Evaluation_MS_ROM_Problemarea_text2='".$_POST["Evaluation_MS_ROM_Problemarea_text2"]."',
Evaluation_MS_ROM_STRENGTH_Right2='".$_POST["Evaluation_MS_ROM_STRENGTH_Right2"]."',
Evaluation_MS_ROM_STRENGTH_Left2='".$_POST["Evaluation_MS_ROM_STRENGTH_Left2"]."',
Evaluation_MS_ROM_ROM2='".$_POST["Evaluation_MS_ROM_ROM2"]."',
Evaluation_MS_ROM_ROM_Type2='".$_POST["Evaluation_MS_ROM_ROM_Type2"]."',
Evaluation_MS_ROM_Tonicity2='".$_POST["Evaluation_MS_ROM_Tonicity2"]."',
Evaluation_MS_ROM_Further_description2='".$_POST["Evaluation_MS_ROM_Further_description2"]."',
Evaluation_MS_ROM_Problemarea_text3='".$_POST["Evaluation_MS_ROM_Problemarea_text3"]."',
Evaluation_MS_ROM_STRENGTH_Right3='".$_POST["Evaluation_MS_ROM_STRENGTH_Right3"]."',
Evaluation_MS_ROM_STRENGTH_Left3='".$_POST["Evaluation_MS_ROM_STRENGTH_Left3"]."',
Evaluation_MS_ROM_ROM3='".$_POST["Evaluation_MS_ROM_ROM3"]."',
Evaluation_MS_ROM_ROM_Type3='".$_POST["Evaluation_MS_ROM_ROM_Type3"]."',
Evaluation_MS_ROM_Tonicity3='".$_POST["Evaluation_MS_ROM_Tonicity3"]."',
Evaluation_MS_ROM_Further_description3='".$_POST["Evaluation_MS_ROM_Further_description3"]."',
Evaluation_MS_ROM_Comments='".$_POST["Evaluation_MS_ROM_Comments"]."',
Evaluation_Summary_OT_Evaluation_Only='".$_POST["Evaluation_Summary_OT_Evaluation_Only"]."',
Evaluation_Summary_Need_physician_Orders='".$_POST["Evaluation_Summary_Need_physician_Orders"]."',
Evaluation_Summary_Received_Physician_Orders='".$_POST["Evaluation_Summary_Received_Physician_Orders"]."',
Evaluation_approximate_next_visit_date  ='".$_POST["Evaluation_approximate_next_visit_date"]."',
Evaluation_OT_Evaulation_Communicated_Agreed ='".$_POST["Evaluation_OT_Evaulation_Communicated_Agreed"]."',
Evaluation_OT_Evaulation_Communicated_other='".$_POST["Evaluation_OT_Evaulation_Communicated_other"]."',
Evaluation_ASP_Environmental_Adaptations_Discussed='".$_POST["Evaluation_ASP_Environmental_Adaptations_Discussed"]."',
Evaluation_ASP_Safety_Issues_Discussed='".$_POST["Evaluation_ASP_Safety_Issues_Discussed"]."',
Evaluation_ASP_Treatment_For='".$_POST["Evaluation_ASP_Treatment_For"]."',
Evaluation_ASP_Treatment_For_text='".$_POST["Evaluation_ASP_Treatment_For_text"]."',
Evaluation_ASP_Other='".$_POST["Evaluation_ASP_Other"]."',
Evaluation_Skilled_OT_Reasonable_And_Necessary_To='".$_POST["Evaluation_Skilled_OT_Reasonable_And_Necessary_To"]."',
Evaluation_Skilled_OT_Other='".$_POST["Evaluation_Skilled_OT_Other"]."',
Evaluation_Additional_Comments='".$_POST["Evaluation_Additional_Comments"]."',
Evaluation_Therapist_Who_Developed_POC='".$_POST["Evaluation_Therapist_Who_Developed_POC"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>