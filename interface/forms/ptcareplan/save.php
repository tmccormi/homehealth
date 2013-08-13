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
$newid = formSubmit("forms_pt_careplan", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "PT Care plan", $newid, "ptcareplan", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

sqlInsert("update forms_pt_careplan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
Onsetdate ='".$_POST["Onsetdate"]."',
careplan_PT_intervention ='".$_POST["careplan_PT_intervention"]."',
careplan_Treatment_DX ='".$_POST["careplan_Treatment_DX"]."',
careplan_SOCDate='".$_POST["careplan_SOCDate"]."',
careplan_PT_Decline_in_mobility ='".$_POST["careplan_PT_Decline_in_mobility"]."',
careplan_PT_Decline_in_mobility_Note ='".$_POST["careplan_PT_Decline_in_mobility_Note"]."',
careplan_PT_Decrease_in_ROM ='".$_POST["careplan_PT_Decrease_in_ROM"]."',
careplan_PT_Decrease_in_ROM_Note ='".$_POST["careplan_PT_Decrease_in_ROM_Note"]."', 
careplan_PT_Decline_in_Strength ='".$_POST["careplan_PT_Decline_in_Strength"]."',
careplan_PT_Decline_in_Strength_Note ='".$_POST["careplan_PT_Decline_in_Strength_Note"]."', 
careplan_PT_Increased_Pain_with_Movement ='".$_POST["careplan_PT_Increased_Pain_with_Movement"]."',
careplan_PT_Increased_Pain_with_Movement_Note ='".$_POST["careplan_PT_Increased_Pain_with_Movement_Note"]."', 
careplan_PT_Decline_in_Balance ='".$_POST["careplan_PT_Decline_in_Balance"]."',
careplan_PT_Decline_in_Balance_Note ='".$_POST["careplan_PT_Decline_in_Balance_Note"]."', 
careplan_PT_Decreased_Safety ='".$_POST["careplan_PT_Decreased_Safety"]."',
careplan_PT_Decreased_Safety_Note ='".$_POST["careplan_PT_Decreased_Safety_Note"]."',
careplan_PT_intervention_Other ='".$_POST["careplan_PT_intervention_Other"]."',
careplan_Treatment_Plan_Frequency ='".$_POST["careplan_Treatment_Plan_Frequency"]."',
careplan_Treatment_Plan_EffectiveDate ='".$_POST["careplan_Treatment_Plan_EffectiveDate"]."',
careplan_Evaluation ='".$_POST["careplan_Evaluation"]."',
careplan_Home_Therapeutic_Exercises ='".$_POST["careplan_Home_Therapeutic_Exercises"]."',
careplan_Gait_ReTraining ='".$_POST["careplan_Gait_ReTraining"]."',
careplan_Bed_Mobility_Training ='".$_POST["careplan_Bed_Mobility_Training"]."',
careplan_Transfer_Training ='".$_POST["careplan_Transfer_Training"]."',
careplan_Balance_Training_Activities ='".$_POST["careplan_Balance_Training_Activities"]."',
careplan_Patient_Caregiver_Family_Education ='".$_POST["careplan_Patient_Caregiver_Family_Education"]."',
careplan_Assistive_Device_Training ='".$_POST["careplan_Assistive_Device_Training"]."',
careplan_Neuro_developmental_Training ='".$_POST["careplan_Neuro_developmental_Training"]."',
careplan_Orthotics_Splinting ='".$_POST["careplan_Orthotics_Splinting"]."',
careplan_Hip_Safety_Precaution_Training ='".$_POST["careplan_Hip_Safety_Precaution_Training"]."',
careplan_Physical_Agents ='".$_POST["careplan_Physical_Agents"]."',
careplan_Physical_Agents_Name='".$_POST["careplan_Physical_Agents_Name"]."',
careplan_Physical_Agents_For ='".$_POST["careplan_Physical_Agents_For"]."',
careplan_Muscle_ReEducation ='".$_POST["careplan_Muscle_ReEducation"]."',
careplan_Safe_Stair_Climbing_Skills ='".$_POST["careplan_Safe_Stair_Climbing_Skills"]."',
careplan_Exercises_to_manage_pain ='".$_POST["careplan_Exercises_to_manage_pain"]."',
careplan_Fall_Precautions_Training ='".$_POST["careplan_Fall_Precautions_Training"]."', 
careplan_Exercises_Safety_Techniques_given_patient ='".$_POST["careplan_Exercises_Safety_Techniques_given_patient"]."',
careplan_PT_Other ='".$_POST["careplan_PT_Other"]."',
careplan_STO_Improve_mobility_skills ='".$_POST["careplan_STO_Improve_mobility_skills"]."',
careplan_STO_Improve_mobility_skills_In ='".$_POST["careplan_STO_Improve_mobility_skills_In"]."',
careplan_STO_Improve_mobility_skills_To ='".$_POST["careplan_STO_Improve_mobility_skills_To"]."',
careplan_STO_Increase_ROM ='".$_POST["careplan_STO_Increase_ROM"]."',
careplan_STO_Increase_ROM_Side ='".$_POST["careplan_STO_Increase_ROM_Side"]."',
careplan_STO_Increase_ROM_Note ='".$_POST["careplan_STO_Increase_ROM_Note"]."',
careplan_STO_Increase_ROM_To ='".$_POST["careplan_STO_Increase_ROM_To"]."',
careplan_STO_Increase_Strength ='".$_POST["careplan_STO_Increase_Strength"]."',
careplan_STO_Increase_Strength_Side ='".$_POST["careplan_STO_Increase_Strength_Side"]."',
careplan_STO_Increase_Strength_Note ='".$_POST["careplan_STO_Increase_Strength_Note"]."',
careplan_STO_Increase_Strength_To ='".$_POST["careplan_STO_Increase_Strength_To"]."',
careplan_STO_Exercises_using_written_handout ='".$_POST["careplan_STO_Exercises_using_written_handout"]."',
careplan_STO_Exercises_using_written_handout_With ='".$_POST["careplan_STO_Exercises_using_written_handout_With"]."',
careplan_STO_Improve_home_safety_techniques ='".$_POST["careplan_STO_Improve_home_safety_techniques"]."',
careplan_STO_Improve_home_safety_techniques_In ='".$_POST["careplan_STO_Improve_home_safety_techniques_In"]."',
careplan_STO_Improve_home_safety_techniques_To ='".$_POST["careplan_STO_Improve_home_safety_techniques_To"]."',
careplan_STO_Demonstrate_independent_use_of_prosthesis ='".$_POST["careplan_STO_Demonstrate_independent_use_of_prosthesis"]."', 
careplan_STO_Mobility_Skill_Time='".$_POST["careplan_STO_Mobility_Skill_Time"]."',
careplan_STO_ROM_Skill_Time='".$_POST["careplan_STO_ROM_Skill_Time"]."',
careplan_STO_WFL_Time ='".$_POST["careplan_STO_WFL_Time"]."',
careplan_STO_Excercise_Time ='".$_POST["careplan_STO_Excercise_Time"]."',
careplan_STO_Safety_Techniques_Time ='".$_POST["careplan_STO_Safety_Techniques_Time"]."',
careplan_STO_Independant_Use_Of_Prosthesis_Time ='".$_POST["careplan_STO_Independant_Use_Of_Prosthesis_Time"]."',
careplan_STO_Time='".$_POST["careplan_STO_Time"]."',
careplan_STO_Other ='".$_POST["careplan_STO_Other"]."',
careplan_STO_Other_Time ='".$_POST["careplan_STO_Other_Time"]."',
careplan_LTO_Return_prior_level_function ='".$_POST["careplan_LTO_Return_prior_level_function"]."',
careplan_LTO_Return_prior_level_function_In ='".$_POST["careplan_LTO_Return_prior_level_function_In"]."',
careplan_LTO_Return_prior_level_function_Time ='".$_POST["careplan_LTO_Return_prior_level_function_Time"]."',
careplan_LTO_Demonstrate_ability_follow_home_exercise ='".$_POST["careplan_LTO_Demonstrate_ability_follow_home_exercise"]."',
careplan_LTO_Demonstrate_ability_follow_home_exercise_Time ='".$_POST["careplan_LTO_Demonstrate_ability_follow_home_exercise_Time"]."',
careplan_LTO_Improve_mobility ='".$_POST["careplan_LTO_Improve_mobility"]."',
careplan_LTO_Improve_mobility_Type ='".$_POST["careplan_LTO_Improve_mobility_Type"]."',
careplan_LTO_Improve_mobility_Time ='".$_POST["careplan_LTO_Improve_mobility_Time"]."',
careplan_LTO_Improve_independence_safety_home ='".$_POST["careplan_LTO_Improve_independence_safety_home"]."',
careplan_LTO_Improve_independence_safety_home_Time ='".$_POST["careplan_LTO_Improve_independence_safety_home_Time"]."', 
careplan_LTO_Other ='".$_POST["careplan_LTO_Other"]."',
careplan_LTO_Other_Time ='".$_POST["careplan_LTO_Other_Time"]."',
careplan_Additional_comments='".$_POST["careplan_Additional_comments"]."',
careplan_Rehab_Potential ='".$_POST["careplan_Rehab_Potential"]."',
careplan_DP_When_Goals_Are_Met ='".$_POST["careplan_DP_When_Goals_Are_Met"]."',
careplan_DP_Other ='".$_POST["careplan_DP_Other"]."',
careplan_PT_communicated_and_agreed_upon_by ='".$_POST["careplan_PT_communicated_and_agreed_upon_by"]."',
careplan_PT_communicated_and_agreed_upon_Other ='".$_POST["careplan_PT_communicated_and_agreed_upon_Other"]."',
careplan_Agreeable_to_general_goals ='".$_POST["careplan_Agreeable_to_general_goals"]."',
careplan_Highly_motivated_to_improve  ='".$_POST["careplan_Highly_motivated_to_improve"]."',
careplan_Supportive_family_caregiver ='".$_POST["careplan_Supportive_family_caregiver"]."',
careplan_Physician_Orders ='".$_POST["careplan_Physician_Orders"]."',
careplan_May_require_additional_treatment='".$_POST["careplan_May_require_additional_treatment"]."',
careplan_May_require_additional_treatment_dueto ='".$_POST["careplan_May_require_additional_treatment_dueto"]."',
careplan_Will_address_above_issues='".$_POST["careplan_Will_address_above_issues"]."',
careplan_Will_address_above_issues_by ='".$_POST["careplan_Will_address_above_issues_by"]."',
careplan_Physician_Orders_Other ='".$_POST["careplan_Physician_Orders_Other"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
