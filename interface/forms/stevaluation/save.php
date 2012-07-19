<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");


if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_st_Evaluation", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "Evaluation", $newid, "stevaluation", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_st_Evaluation set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
Evaluation_date ='".$_POST["Evaluation_date"]."',
Evaluation_Time_In='".$_POST["Evaluation_Time_In"]."',
Evaluation_Time_Out='".$_POST["Evaluation_Time_Out"]."',
Evaluation_Pulse ='".$_POST["Evaluation_Pulse"]."',
Evaluation_Pulse_State ='".$_POST["Evaluation_Pulse_State"]."',
Evaluation_Temperature ='".$_POST["Evaluation_Temperature"]."',
Evaluation_Temperature_type ='".$_POST["Evaluation_Temperature_type"]."',
Evaluation_VS_other ='".$_POST["Evaluation_VS_other"]."',
Evaluation_VS_Respirations ='".$_POST["Evaluation_VS_Respirations"]."',
Evaluation_VS_BP_Systolic ='".$_POST["Evaluation_VS_BP_Systolic"]."',
Evaluation_VS_BP_Diastolic ='".$_POST["Evaluation_VS_BP_Diastolic"]."',
Evaluation_VS_BP_Body_side ='".$_POST["Evaluation_VS_BP_Body_side"]."',
Evaluation_VS_BP_Body_Position ='".$_POST["Evaluation_VS_BP_Body_Position"]."',
Evaluation_VS_Sat ='".$_POST["Evaluation_VS_Sat"]."',
Evaluation_VS_Pain ='".$_POST["Evaluation_VS_Pain"]."',
Evaluation_VS_Pain_Intensity ='".$_POST["Evaluation_VS_Pain_Intensity"]."',
Evaluation_VS_Location ='".$_POST["Evaluation_VS_Location"]."',
Evaluation_VS_Other1 ='".$_POST["Evaluation_VS_Other1"]."',
Evaluation_HR_Needs_assistance ='".$_POST["Evaluation_HR_Needs_assistance"]."',
Evaluation_HR_Unable_to_leave_home ='".$_POST["Evaluation_HR_Unable_to_leave_home"]."',
Evaluation_HR_Medical_Restrictions ='".$_POST["Evaluation_HR_Medical_Restrictions"]."',
Evaluation_HR_Medical_Restrictions_In ='".$_POST["Evaluation_HR_Medical_Restrictions_In"]."',
Evaluation_HR_SOB_upon_exertion ='".$_POST["Evaluation_HR_SOB_upon_exertion"]."',
Evaluation_HR_Pain_with_Travel ='".$_POST["Evaluation_HR_Pain_with_Travel"]."',
Evaluation_HR_Requires_assistance ='".$_POST["Evaluation_HR_Requires_assistance"]."',
Evaluation_HR_Arrhythmia ='".$_POST["Evaluation_HR_Arrhythmia"]."',
Evaluation_HR_Bed_Bound ='".$_POST["Evaluation_HR_Bed_Bound"]."',
Evaluation_HR_Residual_Weakness ='".$_POST["Evaluation_HR_Residual_Weakness"]."',
Evaluation_HR_Confusion ='".$_POST["Evaluation_HR_Confusion"]."',
Evaluation_HR_Multiple_Stairs_Home ='".$_POST["Evaluation_HR_Multiple_Stairs_Home"]."',
Evaluation_HR_Other ='".$_POST["Evaluation_HR_Other"]."',
Evaluation_Reason_for_intervention ='".$_POST["Evaluation_Reason_for_intervention"]."',
Evaluation_TREATMENT_DX_Problem ='".$_POST["Evaluation_TREATMENT_DX_Problem"]."',
Evaluation_PERTINENT_MEDICAL_HISTORY ='".$_POST["Evaluation_PERTINENT_MEDICAL_HISTORY"]."',
Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS ='".$_POST["Evaluation_MEDICAL_FUNCTIONAL_PRECAUTIONS"]."',
Evaluation_MFP_Swallow_status ='".$_POST["Evaluation_MFP_Swallow_status"]."',
Evaluation_MFP_Other ='".$_POST["Evaluation_MFP_Other"]."',
Evaluation_MFP_Handedness ='".$_POST["Evaluation_MFP_Handedness"]."',
Evaluation_MFP_Limitations ='".$_POST["Evaluation_MFP_Limitations"]."',
Evaluation_MFP_Current_Weight_Loss ='".$_POST["Evaluation_MFP_Current_Weight_Loss"]."',
Evaluation_MFP_Weight_Loss_Reason ='".$_POST["Evaluation_MFP_Weight_Loss_Reason"]."',
Evaluation_Prior_Level_Of_Function ='".$_POST["Evaluation_Prior_Level_Of_Function"]."',
Evaluation_Family_Caregiver_Support ='".$_POST["Evaluation_Family_Caregiver_Support"]."',
Evaluation_Family_Caregiver_Support_Who ='".$_POST["Evaluation_Family_Caregiver_Support_Who"]."',
Evaluation_FC_Visits_Community_Weekly ='".$_POST["Evaluation_FC_Visits_Community_Weekly"]."',
Evaluation_FC_Additional_Comments ='".$_POST["Evaluation_FC_Additional_Comments"]."',
Evaluation_Auditory_Comp ='".$_POST["Evaluation_Auditory_Comp"]."',
Evaluation_Reading_Comp ='".$_POST["Evaluation_Reading_Comp"]."',
Evaluation_Verbal_Expression ='".$_POST["Evaluation_Verbal_Expression"]."',
Evaluation_Written_Expression ='".$_POST["Evaluation_Written_Expression"]."',
Evaluation_Gestural_Expression ='".$_POST["Evaluation_Gestural_Expression"]."',
Evaluation_Speech_Intelligibility ='".$_POST["Evaluation_Speech_Intelligibility"]."',
Evaluation_Diet_Level ='".$_POST["Evaluation_Diet_Level"]."',
Evaluation_Mastication ='".$_POST["Evaluation_Mastication"]."',
Evaluation_Lingual_Transfer ='".$_POST["Evaluation_Lingual_Transfer"]."',
Evaluation_Pocketing ='".$_POST["Evaluation_Pocketing"]."',
Evaluation_AP_Propulsion ='".$_POST["Evaluation_AP_Propulsion"]."',
Evaluation_Oral_Transit ='".$_POST["Evaluation_Oral_Transit"]."',
Evaluation_Swallow_Timing ='".$_POST["Evaluation_Swallow_Timing"]."',
Evaluation_Diet_Level='".$_POST["Evaluation_Diet_Level"]."',
Evaluation_Mental_Status ='".$_POST["Evaluation_Mental_Status"]."',
Evaluation_Mental_Status_Oriented_to ='".$_POST["Evaluation_Mental_Status_Oriented_to"]."',
Evaluation_MS_Additional_Comments ='".$_POST["Evaluation_MS_Additional_Comments"]."',
Evaluation_ST_Evaluation_Only ='".$_POST["Evaluation_ST_Evaluation_Only"]."',
Evaluation_Need_Physician_Orders ='".$_POST["Evaluation_Need_Physician_Orders"]."',
Evaluation_Received_Physician_Orders ='".$_POST["Evaluation_Received_Physician_Orders"]."',
Evaluation_Approximate_Next_Visit_Date ='".$_POST["Evaluation_Approximate_Next_Visit_Date"]."',
Evaluation_ST_Communicated_And_Agreed_by ='".$_POST["Evaluation_ST_Communicated_And_Agreed_by"]."',
Evaluation_ST_Communicated_And_Agreed_By_Other ='".$_POST["Evaluation_ST_Communicated_And_Agreed_By_Other"]."',
Evaluation_ADDITIONAL_SERVICES_Speech_Excersice  ='".$_POST["Evaluation_ADDITIONAL_SERVICES_Speech_Excersice"]."',
Evaluation_ADDITIONAL_SERVICES_Swallow_technique ='".$_POST["Evaluation_ADDITIONAL_SERVICES_Swallow_technique"]."',
Evaluation_ADDITIONAL_SERVICES_Diet_Modifications ='".$_POST["Evaluation_ADDITIONAL_SERVICES_Diet_Modifications"]."',
Evaluation_ADDITIONAL_SERVICES_Treatment ='".$_POST["Evaluation_ADDITIONAL_SERVICES_Treatment"]."',
Evaluation_ASP_Treatment_For ='".$_POST["Evaluation_ASP_Treatment_For"]."',
Evaluation_Skilled_ST_Necessary_To ='".$_POST["Evaluation_Skilled_ST_Necessary_To"]."',
Evaluation_Skilled_ST_Other ='".$_POST["Evaluation_Skilled_ST_Other"]."',
Evaluation_Therapist_Who_Developed_POC ='".$_POST["Evaluation_Therapist_Who_Developed_POC"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
