<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");


if ($encounter == "")
$encounter = date("Ymd");

foreach($_POST as $key => $value) {
    $_POST[$key] = mysql_real_escape_string($value);
}

if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_pt_Evaluation", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "PT Evaluation", $newid, "ptEvaluation", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

sqlInsert("update forms_pt_Evaluation set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
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
Evaluation_VS_BP_Body_side ='".$_POST["Evaluation_VS_BP_Body_side"]."',
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
Evaluation_HR_Multiple_Stairs_Home='".$_POST["Evaluation_HR_Multiple_Stairs_Home"]."',
Evaluation_HR_Other='".$_POST["Evaluation_HR_Other"]."',
Evaluation_Reason_for_intervention='".$_POST["Evaluation_Reason_for_intervention"]."',
Evaluation_TREATMENT_DX_PT_Problem='".$_POST["Evaluation_TREATMENT_DX_PT_Problem"]."',
Evaluation_PERTINENT_MEDICAL_HISTORY='".$_POST["Evaluation_PERTINENT_MEDICAL_HISTORY"]."',
Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS='".$_POST["Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"]."',
Evaluation_MFP_WB_status ='".$_POST["Evaluation_MFP_WB_status"]."',
Evaluation_MFP_Other  ='".$_POST["Evaluation_MFP_Other"]."',
Evaluation_Prior_level_Mobility_Home  ='".$_POST["Evaluation_Prior_level_Mobility_Home"]."',
Evaluation_Prior_level_Mobility_Other ='".$_POST["Evaluation_Prior_level_Mobility_Other"]."',
Evaluation_PLM_Stairs_Front_House  ='".$_POST["Evaluation_PLM_Stairs_Front_House"]."',
Evaluation_PLM_Stairs_Back_House ='".$_POST["Evaluation_PLM_Stairs_Back_House"]."',
Evaluation_PLM_Stairs_Second_Level  ='".$_POST["Evaluation_PLM_Stairs_Second_Level"]."',
Evaluation_Prior_level_Mobility_Community  ='".$_POST["Evaluation_Prior_level_Mobility_Community"]."',
Evaluation_Family_Caregiver_Support ='".$_POST["Evaluation_Family_Caregiver_Support"]."',
Evaluation_Family_Caregiver_Support_Who ='".$_POST["Evaluation_Family_Caregiver_Support_Who"]."',
Evaluation_FC_Visits_Community_Weekly ='".$_POST["Evaluation_FC_Visits_Community_Weekly"]."',
Evaluation_FC_Additional_Comments ='".$_POST["Evaluation_FC_Additional_Comments"]."',
Evaluation_CMS_ROLLING_RIGHT ='".$_POST["Evaluation_CMS_ROLLING_RIGHT"]."',
Evaluation_CMS_ROLLING_LEFT ='".$_POST["Evaluation_CMS_ROLLING_LEFT"]."',
Evaluation_CMS_BRIDGING_SCOOT ='".$_POST["Evaluation_CMS_BRIDGING_SCOOT"]."',
Evaluation_CMS_SUPINE_SIT ='".$_POST["Evaluation_CMS_SUPINE_SIT"]."',
Evaluation_CMS_SIT_STAND ='".$_POST["Evaluation_CMS_SIT_STAND"]."',
Evaluation_CMS_BED_CHAIR_TRANSFERS='".$_POST["Evaluation_CMS_BED_CHAIR_TRANSFERS"]."',
Evaluation_CMS_TOILET_TRANSFERS ='".$_POST["Evaluation_CMS_TOILET_TRANSFERS"]."',
Evaluation_CMS_Other_text ='".$_POST["Evaluation_CMS_Other_text"]."',
Evaluation_CMS_Other ='".$_POST["Evaluation_CMS_Other"]."',
Evaluation_CMS_COMMENTS ='".$_POST["Evaluation_CMS_COMMENTS"]."',
Evaluation_GAIT_SKILLS='".$_POST["Evaluation_GAIT_SKILLS"]."',
Evaluation_GS_Assistance ='".$_POST["Evaluation_GS_Assistance"]."',
Evaluation_GS_Distance_Time ='".$_POST["Evaluation_GS_Distance_Time"]."',
Evaluation_GS_Surfaces  ='".$_POST["Evaluation_GS_Surfaces"]."',
Evaluation_GS_Assistive_Devices  ='".$_POST["Evaluation_GS_Assistive_Devices"]."',
Evaluation_GS_Assistive_Devices_Other  ='".$_POST["Evaluation_GS_Assistive_Devices_Other"]."',
Evaluation_GS_Gait_Deviations  ='".$_POST["Evaluation_GS_Gait_Deviations"]."',
Evaluation_WHEELCHAIR_SKILLS ='".$_POST["Evaluation_WHEELCHAIR_SKILLS"]."',
Evaluation_WS_Assistance  ='".$_POST["Evaluation_WS_Assistance"]."',
Evaluation_WS_Distance_Time  ='".$_POST["Evaluation_WS_Distance_Time"]."',
Evaluation_WS_Surfaces  ='".$_POST["Evaluation_WS_Surfaces"]."',
Evaluation_WS_Surfaces_other ='".$_POST["Evaluation_WS_Surfaces_other"]."',
Evaluation_WS_Remove_Footrests  ='".$_POST["Evaluation_WS_Remove_Footrests"]."',
Evaluation_WS_Remove_Armrests  ='".$_POST["Evaluation_WS_Remove_Armrests"]."',
Evaluation_WS_Reposition_WC  ='".$_POST["Evaluation_WS_Reposition_WC"]."',
Evaluation_WS_Posture_Alignment_Chair ='".$_POST["Evaluation_WS_Posture_Alignment_Chair"]."',
Evaluation_WS_Other ='".$_POST["Evaluation_WS_Other"]."',
Evaluation_COG_Alert_type ='".$_POST["Evaluation_COG_Alert_type"]."',
Evaluation_COG_Oriented_Type='".$_POST["Evaluation_COG_Oriented_Type"]."',
Evaluation_COG_Canfollow ='".$_POST["Evaluation_COG_Canfollow"]."',
Evaluation_COG_Safety_Awareness='".$_POST["Evaluation_COG_Safety_Awareness"]."',
Evaluation_Mis_skil_Endurance ='".$_POST["Evaluation_Mis_skil_Endurance"]."',
Evaluation_Mis_skil_Communication ='".$_POST["Evaluation_Mis_skil_Communication"]."',
Evaluation_Mis_skil_Hearing ='".$_POST["Evaluation_Mis_skil_Hearing"]."',
Evaluation_Mis_skil_Vision ='".$_POST["Evaluation_Mis_skil_Vision"]."',
Evaluation_CB_Skills_Dynamic_Sitting='".$_POST["Evaluation_CB_Skills_Dynamic_Sitting"]."',
Evaluation_CB_Skills_Static_Sitting='".$_POST["Evaluation_CB_Skills_Static_Sitting"]."',
Evaluation_CB_Skills_Dynamic_Standing='".$_POST["Evaluation_CB_Skills_Dynamic_Standing"]."',
Evaluation_CB_Skills_Static_Standing='".$_POST["Evaluation_CB_Skills_Static_Standing"]."',
Evaluation_MS_ROM_All_Muscle_WFL='".$_POST["Evaluation_MS_ROM_All_Muscle_WFL"]."',
Evaluation_MS_ROM_ALL_ROM_WFL='".$_POST["Evaluation_MS_ROM_ALL_ROM_WFL"]."',
Evaluation_MS_ROM_Following_Problem_areas='".$_POST["Evaluation_MS_ROM_Following_Problem_areas"]."',
Evaluation_MS_ROM_Problemarea_text='".$_POST["Evaluation_MS_ROM_Problemarea_text"]."',
Evaluation_MS_ROM_STRENGTH_Right='".$_POST["Evaluation_MS_ROM_STRENGTH_Right"]."',
Evaluation_MS_ROM_STRENGTH_Left='".$_POST["Evaluation_MS_ROM_STRENGTH_Left"]."',
Evaluation_MS_ROM_ROM='".$_POST["Evaluation_MS_ROM_ROM"]."',
Evaluation_MS_ROM_ROM_Type='".$_POST["Evaluation_MS_ROM_ROM_Type"]."',
Evaluation_MS_ROM_Tonicity='".$_POST["Evaluation_MS_ROM_Tonicity"]."',
Evaluation_MS_ROM_Problemarea_text1='".$_POST["Evaluation_MS_ROM_Problemarea_text1"]."',
Evaluation_MS_ROM_STRENGTH_Right1='".$_POST["Evaluation_MS_ROM_STRENGTH_Right1"]."',
Evaluation_MS_ROM_STRENGTH_Left1='".$_POST["Evaluation_MS_ROM_STRENGTH_Left1"]."',
Evaluation_MS_ROM_ROM1='".$_POST["Evaluation_MS_ROM_ROM1"]."',
Evaluation_MS_ROM_ROM_Type1='".$_POST["Evaluation_MS_ROM_ROM_Type1"]."',
Evaluation_MS_ROM_Tonicity1='".$_POST["Evaluation_MS_ROM_Tonicity1"]."',
Evaluation_MS_ROM_Problemarea_text2='".$_POST["Evaluation_MS_ROM_Problemarea_text2"]."',
Evaluation_MS_ROM_STRENGTH_Right2='".$_POST["Evaluation_MS_ROM_STRENGTH_Right2"]."',
Evaluation_MS_ROM_STRENGTH_Left2='".$_POST["Evaluation_MS_ROM_STRENGTH_Left2"]."',
Evaluation_MS_ROM_ROM2='".$_POST["Evaluation_MS_ROM_ROM2"]."',
Evaluation_MS_ROM_ROM_Type2='".$_POST["Evaluation_MS_ROM_ROM_Type2"]."',
Evaluation_MS_ROM_Tonicity2='".$_POST["Evaluation_MS_ROM_Tonicity2"]."',
Evaluation_MS_ROM_Problemarea_text3='".$_POST["Evaluation_MS_ROM_Problemarea_text3"]."',
Evaluation_MS_ROM_STRENGTH_Right3='".$_POST["Evaluation_MS_ROM_STRENGTH_Right3"]."',
Evaluation_MS_ROM_STRENGTH_Left3='".$_POST["Evaluation_MS_ROM_STRENGTH_Left3"]."',
Evaluation_MS_ROM_ROM3='".$_POST["Evaluation_MS_ROM_ROM3"]."',
Evaluation_MS_ROM_ROM_Type3='".$_POST["Evaluation_MS_ROM_ROM_Type3"]."',
Evaluation_MS_ROM_Tonicity3='".$_POST["Evaluation_MS_ROM_Tonicity3"]."',
Evaluation_MS_ROM_Further_description='".$_POST["Evaluation_MS_ROM_Further_description"]."',
Evaluation_MS_ROM_Comments='".$_POST["Evaluation_MS_ROM_Comments"]."',
Evaluation_EnvBar_No_barriers='".$_POST["Evaluation_EnvBar_No_barriers"]."',
Evaluation_EnvBar_No_Safety_Issues='".$_POST["Evaluation_EnvBar_No_Safety_Issues"]."',
Evaluation_EnvBar_Bedroom_On_Second='".$_POST["Evaluation_EnvBar_Bedroom_On_Second"]."',
Evaluation_EnvBar_No_Inadequate_grab='".$_POST["Evaluation_EnvBar_No_Inadequate_grab"]."',
Evaluation_EnvBar_Throw_Rugs='".$_POST["Evaluation_EnvBar_Throw_Rugs"]."',
Evaluation_EnvBar_No_Inadequate_smoke='".$_POST["Evaluation_EnvBar_No_Inadequate_smoke"]."',
Evaluation_EnvBar_No_Emergency_Numbers='".$_POST["Evaluation_EnvBar_No_Emergency_Numbers"]."',
Evaluation_EnvBar_Lighting_Not_Adequate='".$_POST["Evaluation_EnvBar_Lighting_Not_Adequate"]."',
Evaluation_EnvBar_No_Handrails='".$_POST["Evaluation_EnvBar_No_Handrails"]."',
Evaluation_EnvBar_Stairs_Disrepair='".$_POST["Evaluation_EnvBar_Stairs_Disrepair"]."',
Evaluation_EnvBar_Fire_Extinguishers='".$_POST["Evaluation_EnvBar_Fire_Extinguishers"]."',
Evaluation_EnvBar_Other='".$_POST["Evaluation_EnvBar_Other"]."',
Evaluation_Summary_PT_Evaluation_Only='".$_POST["Evaluation_Summary_PT_Evaluation_Only"]."',
Evaluation_Summary_Need_physician_Orders='".$_POST["Evaluation_Summary_Need_physician_Orders"]."',
Evaluation_Summary_Received_Physician_Orders='".$_POST["Evaluation_Summary_Received_Physician_Orders"]."',
Evaluation_approximate_next_visit_date  ='".$_POST["Evaluation_approximate_next_visit_date"]."',
Evaluation_PT_Evaulation_Communicated_Agreed ='".$_POST["Evaluation_PT_Evaulation_Communicated_Agreed"]."',
Evaluation_PT_Evaulation_Communicated_other='".$_POST["Evaluation_PT_Evaulation_Communicated_other"]."',
Evaluation_ASP_Home_Exercise_Initiated='".$_POST["Evaluation_ASP_Home_Exercise_Initiated"]."',
Evaluation_ASP_Falls_Management_Discussed='".$_POST["Evaluation_ASP_Falls_Management_Discussed"]."',
Evaluation_ASP_Safety_Issues_Discussed='".$_POST["Evaluation_ASP_Safety_Issues_Discussed"]."',
Evaluation_ASP_Treatment_For='".$_POST["Evaluation_ASP_Treatment_For"]."',
Evaluation_ASP_Treatment_For_text='".$_POST["Evaluation_ASP_Treatment_For_text"]."',
Evaluation_ASP_Other='".$_POST["Evaluation_ASP_Other"]."',
Evaluation_Skilled_PT_Reasonable_And_Necessary_To='".$_POST["Evaluation_Skilled_PT_Reasonable_And_Necessary_To"]."',
Evaluation_Skilled_PT_Other='".$_POST["Evaluation_Skilled_PT_Other"]."',
Evaluation_Additional_Comments='".$_POST["Evaluation_Additional_Comments"]."',
Evaluation_Therapist_Who_Developed_POC='".$_POST["Evaluation_Therapist_Who_Developed_POC"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
