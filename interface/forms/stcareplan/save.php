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
$newid = formSubmit("forms_st_careplan", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "ST Care plan", $newid, "stcareplan", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

sqlInsert("update forms_st_careplan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
stdate ='".$_POST["stdate"]."',
careplan_ST_intervention ='".$_POST["careplan_ST_intervention"]."',
careplan_Treatment_DX ='".$_POST["careplan_Treatment_DX"]."',
careplan_SOCDate ='".$_POST["careplan_SOCDate"]."',
careplan_ST_Decline_in_Oral_Stage_Skills ='".$_POST["careplan_ST_Decline_in_Oral_Stage_Skills"]."',
careplan_ST_Decline_in_Oral_Stage_Skills_Notes ='".$_POST["careplan_ST_Decline_in_Oral_Stage_Skills_Notes"]."',
careplan_ST_intervention_Other ='".$_POST["careplan_ST_intervention_Other"]."',
careplan_ST_intervention_Other1 ='".$_POST["careplan_ST_intervention_Other1"]."',
careplan_STO_Time1='".$_POST["careplan_STO_Time1"]."',
careplan_STO_Time2='".$_POST["careplan_STO_Time2"]."',
careplan_ST_Decrease_in_Pharyngeal_Stage ='".$_POST["careplan_ST_Decrease_in_Pharyngeal_Stage"]."',
careplan_ST_Decrease_in_Pharyngeal_Stage_Note ='".$_POST["careplan_ST_Decrease_in_Pharyngeal_Stage_Note"]."',
careplan_ST_Decline_in_Verbal_Expression ='".$_POST["careplan_ST_Decline_in_Verbal_Expression"]."',
careplan_ST_Decline_in_Verbal_Expression_Note ='".$_POST["careplan_ST_Decline_in_Verbal_Expression_Note"]."',
careplan_ST_Decline_in_NonVerbal_Expression ='".$_POST["careplan_ST_Decline_in_NonVerbal_Expression"]."',
careplan_ST_Decline_in_NonVerbal_Expression_Note ='".$_POST["careplan_ST_Decline_in_NonVerbal_Expression_Note"]."', 
careplan_ST_Decreased_Comprehension ='".$_POST["careplan_ST_Decreased_Comprehension"]."',
careplan_ST_Decreased_Comprehension_Note ='".$_POST["careplan_ST_Decreased_Comprehension_Note"]."',
careplan_ST_intervention_Other ='".$_POST["careplan_ST_intervention_Other"]."',
careplan_ST_intervention_Other1 ='".$_POST["careplan_ST_intervention_Other1"]."',
careplan_Treatment_Plan_Frequency ='".$_POST["careplan_Treatment_Plan_Frequency"]."',
careplan_Treatment_Plan_EffectiveDate='".$_POST["careplan_Treatment_Plan_EffectiveDate"]."',
careplan_Evaluation ='".$_POST["careplan_Evaluation"]."',
careplan_Dysphagia_Compensatory_Strategies ='".$_POST["careplan_Dysphagia_Compensatory_Strategies"]."',
careplan_Swallow_Exercise_Program ='".$_POST["careplan_Swallow_Exercise_Program"]."',
careplan_Safety_Training_in_Swallow ='".$_POST["careplan_Safety_Training_in_Swallow"]."',
careplan_Cognitive_Impairment ='".$_POST["careplan_Cognitive_Impairment"]."',
careplan_Communication_Strategies ='".$_POST["careplan_Communication_Strategies"]."',
careplan_Cognitive_Compensatory ='".$_POST["careplan_Cognitive_Compensatory"]."',
careplan_Patient_Caregiver_Family_Education ='".$_POST["careplan_Patient_Caregiver_Family_Education"]."',
careplan_ST_Other ='".$_POST["careplan_ST_Other"]."',
careplan_ST_Other1 ='".$_POST["careplan_ST_Other1"]."',
careplan_STO_Improve_OralStage_skills ='".$_POST["careplan_STO_Improve_OralStage_skills"]."',
careplan_STO_Improve_OralStage_skills_In='".$_POST["careplan_STO_Improve_OralStage_skills_In"]."',
careplan_STO_Improve_OralStage_skills_To ='".$_POST["careplan_STO_Improve_OralStage_skills_To"]."',
careplan_STO_Improve_OralStage_skills_Time='".$_POST["careplan_STO_Improve_OralStage_skills_Time"]."',
careplan_STO_Other1 ='".$_POST["careplan_STO_Other1"]."',
careplan_STO_Other2 ='".$_POST["careplan_STO_Other2"]."',
careplan_STO_Time1='".$_POST["careplan_STO_Time1"]."',
careplan_STO_Time2='".$_POST["careplan_STO_Time2"]."',
careplan_STO_Improve_Pharyngeal_Stage ='".$_POST["careplan_STO_Improve_Pharyngeal_Stage"]."',
careplan_STO_Improve_Pharyngeal_Stage_In ='".$_POST["careplan_STO_Improve_Pharyngeal_Stage_In"]."',
careplan_STO_Improve_Pharyngeal_Stage_To ='".$_POST["careplan_STO_Improve_Pharyngeal_Stage_To"]."',
careplan_STO_Improve_Pharyngeal_Stage_Time='".$_POST["careplan_STO_Improve_Pharyngeal_Stage_Time"]."', 
careplan_STO_Improve_Verbal_Expression ='".$_POST["careplan_STO_Improve_Verbal_Expression"]."',
careplan_STO_Improve_Verbal_Expression_In='".$_POST["careplan_STO_Improve_Verbal_Expression_In"]."',
careplan_STO_Improve_Verbal_Expression_To ='".$_POST["careplan_STO_Improve_Verbal_Expression_To"]."',
careplan_STO_Improve_Verbal_Expression_Time='".$_POST["careplan_STO_Improve_Verbal_Expression_Time"]."', 
careplan_LTO_Return_prior_level_function ='".$_POST["careplan_LTO_Return_prior_level_function"]."',
careplan_LTO_Return_prior_level_function_In='".$_POST["careplan_LTO_Return_prior_level_function_In"]."',
careplan_LTO_Return_prior_level_function_Time='".$_POST["careplan_LTO_Return_prior_level_function_Time"]."',
careplan_STO_Improve_Non_Verbal_Expression ='".$_POST["careplan_STO_Improve_Non_Verbal_Expression"]."',
careplan_STO_Improve_Non_Verbal_Expression_in ='".$_POST["careplan_STO_Improve_Non_Verbal_Expression_in"]."',
careplan_STO_Improve_Non_Verbal_Expression_to ='".$_POST["careplan_STO_Improve_Non_Verbal_Expression_to"]."',
careplan_STO_Improve_Non_Verbal_Expression_Time='".$_POST["careplan_STO_Improve_Non_Verbal_Expression_Time"]."',
careplan_LTO_Demonstrate_ability_follow_home_exercise ='".$_POST["careplan_LTO_Demonstrate_ability_follow_home_exercise"]."',
careplan_LTO_Demonstrate_ability_follow_home_exercise_Time='".$_POST["careplan_LTO_Demonstrate_ability_follow_home_exercise_Time"]."',
careplan_STO_Improve_careplan_STO_Improve_In='".$_POST["careplan_STO_Improve_careplan_STO_Improve_In"]."',
careplan_STO_Improve_careplan_STO_Improve_To ='".$_POST["careplan_STO_Improve_careplan_STO_Improve_To"]."',
careplan_STO_Improve_Improve_Comprehension ='".$_POST["careplan_STO_Improve_Improve_Comprehension"]."',
careplan_STO_Improve_Improve_Comprehension_In='".$_POST["careplan_STO_Improve_Improve_Comprehension_In"]."',
careplan_STO_Improve_Improve_Comprehension_To ='".$_POST["careplan_STO_Improve_Improve_Comprehension_To"]."',
careplan_STO_Improve_Improve_Comprehension_Time='".$_POST["careplan_STO_Improve_Improve_Comprehension_Time"]."',
careplan_LTO_Improve_compensatory_techniques ='".$_POST["careplan_LTO_Improve_compensatory_techniques"]."',
careplan_LTO_Improve_compensatory_techniques_Time='".$_POST["careplan_LTO_Improve_compensatory_techniques_Time"]."',
careplan_STO_Improve_Caregiver_Family_Performance ='".$_POST["careplan_STO_Improve_Caregiver_Family_Performance"]."',
careplan_STO_Improve_Caregiver_Family_Performance_In ='".$_POST["careplan_STO_Improve_Caregiver_Family_Performance_In"]."',
careplan_STO_Improve_Caregiver_Family_Performance_Time='".$_POST["careplan_STO_Improve_Caregiver_Family_Performance_Time"]."',
careplan_LTO_Implement_adaptations='".$_POST["careplan_LTO_Implement_adaptations"]."',
careplan_LTO_Implement_adaptations_Time='".$_POST["careplan_LTO_Implement_adaptations_Time"]."',
careplan_LTO_Other='".$_POST["careplan_LTO_Other"]."',
careplan_LTO_Other_Time ='".$_POST["careplan_LTO_Other_Time"]."',
careplan_Additional_Comments='".$_POST["careplan_Additional_Comments"]."',
careplan_Rehab_Potential ='".$_POST["careplan_Rehab_Potential"]."',
careplan_DP_When_Goals_Are_Met ='".$_POST["careplan_DP_When_Goals_Are_Met"]."',
careplan_DP_Other ='".$_POST["careplan_DP_Other"]."',
careplan_PT_communicated_and_agreed_upon_by ='".$_POST["careplan_PT_communicated_and_agreed_upon_by"]."',
careplan_PT_communicated_and_agreed_upon_Other ='".$_POST["careplan_PT_communicated_and_agreed_upon_Other"]."',
careplan_Agreeable_to_general_goals='".$_POST["careplan_Agreeable_to_general_goals"]."',
careplan_Highly_motivated_to_improve ='".$_POST["careplan_Highly_motivated_to_improve"]."',
careplan_Supportive_family_caregiver='".$_POST["careplan_Supportive_family_caregiver"]."',
careplan_Physician_Orders ='".$_POST["careplan_Physician_Orders"]."',
careplan_May_require_additional_treatment ='".$_POST["careplan_May_require_additional_treatment"]."',
careplan_May_require_additional_treatment_dueto ='".$_POST["careplan_May_require_additional_treatment_dueto"]."',
careplan_Will_address_above_issues ='".$_POST["careplan_Will_address_above_issues"]."',
careplan_Will_address_above_issues_by ='".$_POST["careplan_Will_address_above_issues_by"]."',
careplan_Physician_Orders_Other ='".$_POST["careplan_Physician_Orders_Other"]."',
careplan_Therapist_Who_Developed_POC ='".$_POST["careplan_Therapist_Who_Developed_POC"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
