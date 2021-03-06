<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");


if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){

foreach($_POST as $key => $value) {
    $_POST[$key] = mysql_real_escape_string($value);
}

$newid = formSubmit("forms_ot_careplan", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "OT Care plan", $newid, "careplan", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_ot_careplan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
date_curr ='".$_POST["date_curr"]."',
med_dx_icd9 ='".$_POST["med_dx_icd9"]."',
trmnt_dx_icd9 ='".$_POST["trmnt_dx_icd9"]."',
SOC_Date='".$_POST["SOC_Date"]."',
adl_skills='".$_POST["adl_skills"]."',
adl_skills_text='".$_POST["adl_skills_text"]."',
dec_rom='".$_POST["dec_rom"]."',
dec_rom_txt='".$_POST["dec_rom_txt"]."',
iadl_skills='".$_POST["iadl_skills"]."',
iadl_skills_txt='".$_POST["iadl_skills_txt"]."',
dec_mobility='".$_POST["dec_mobility"]."',
mobility_in='".$_POST["mobility_in"]."',
dec_safety_tech ='".$_POST["dec_safety_tech"]."',
safety_tech_txt='".$_POST["safety_tech_txt"]."',
safety_tech_others1='".$_POST["safety_tech_others1"]."',
safety_tech_others2='".$_POST["safety_tech_others2"]."',
frequency='".$_POST["frequency"]."',
effective_date='".$_POST["effective_date"]."',
evaluation='".$_POST["evaluation"]."',
home_safety='".$_POST["home_safety"]."',
adl_training='".$_POST["adl_training"]."',
iadl_training='".$_POST["iadl_training"]."',
visual_comp='".$_POST["visual_comp"]."',
energy_copd='".$_POST["energy_copd"]."',
orthotics_mgmt='".$_POST["orthotics_mgmt"]."',
adaptive_equipment='".$_POST["adaptive_equipment"]."',
cognitive_comp='".$_POST["cognitive_comp"]."',
homeue_exercise ='".$_POST["homeue_exercise"]."',
patient_education='".$_POST["patient_education"]."',
fine_compensatory='".$_POST["fine_compensatory"]."',
educate_safety ='".$_POST["educate_safety"]."',
teach_bathing_skills ='".$_POST["teach_bathing_skills"]."',
exercises_to_patient ='".$_POST["exercises_to_patient"]."',
exercises_others ='".$_POST["exercises_others"]."',
imp_adl_skills ='".$_POST["imp_adl_skills"]."',
imp_adl_skills_in ='".$_POST["imp_adl_skills_in"]."',
imp_adl_skills_to ='".$_POST["imp_adl_skills_to"]."',
imp_iadl_skills ='".$_POST["imp_iadl_skills"]."',
imp_iadl_skills_in ='".$_POST["imp_iadl_skills_in"]."',
imp_iadl_skills_to ='".$_POST["imp_iadl_skills_to"]."',
wfl_Increase='".$_POST["wfl_Increase"]."',
wfl_details='".$_POST["wfl_details"]."',
increase_to='".$_POST["increase_to"]."',
perform='".$_POST["perform"]."',
exercise_type='".$_POST["exercise_type"]."',
exercise_prompts='".$_POST["exercise_prompts"]."',
improve_safety='".$_POST["improve_safety"]."', 
safety_technique_in='".$_POST["safety_technique_in"]."', 
safety_technique_to='".$_POST["safety_technique_to"]."', 
improve_mobility='".$_POST["improve_mobility"]."', 
improve_mobility_in='".$_POST["improve_mobility_in"]."', 
improve_mobility_to='".$_POST["improve_mobility_to"]."', 
shortterm_time='".$_POST["shortterm_time"]."', 
shortterm_time1='".$_POST["shortterm_time1"]."',
shortterm_time2='".$_POST["shortterm_time2"]."',
shortterm_time3='".$_POST["shortterm_time3"]."',
shortterm_time4='".$_POST["shortterm_time4"]."',
shortterm_time5='".$_POST["shortterm_time5"]."',
shortterm_time6='".$_POST["shortterm_time6"]."',
shortterm_time7='".$_POST["shortterm_time7"]."',
time_others1='".$_POST["time_others1"]."',
time_others2='".$_POST["time_others2"]."', 
time_others3='".$_POST["time_others3"]."',
return_to_priorlevel='".$_POST["return_to_priorlevel"]."', 
return_priorlevel_in='".$_POST["return_priorlevel_in"]."',
longterm_time='".$_POST["longterm_time"]."',
longterm_time1='".$_POST["longterm_time1"]."',
longterm_time2='".$_POST["longterm_time2"]."',
longterm_time3='".$_POST["longterm_time3"]."',
longterm_time4='".$_POST["longterm_time4"]."',
home_exercise='".$_POST["home_exercise"]."', 
safety_at_home='".$_POST["safety_at_home"]."',
envrn_changes_home='".$_POST["envrn_changes_home"]."',
longterm_others='".$_POST["longterm_others"]."', 
rehabpotential='".$_POST["rehabpotential"]."',
rehabpotential_goals_met='".$_POST["rehabpotential_goals_met"]."', 
rehabpotential_others='".$_POST["rehabpotential_others"]."',
careplan_discharge_comm='".$_POST["careplan_discharge_comm"]."', 
care_plan_discharge_other='".$_POST["care_plan_discharge_other"]."', 
careplan_response_agree ='".$_POST["careplan_response_agree"]."',
careplan_response_motivated ='".$_POST["careplan_response_motivated"]."',
careplan_response_supp ='".$_POST["careplan_response_supp"]."',
addtn_treatment='".$_POST["addtn_treatment"]."', 
addtn_treatment_req ='".$_POST["addtn_treatment_req"]."',
physician_orders_obtained='".$_POST["physician_orders_obtained"]."',
physician_orders_needed='".$_POST["physician_orders_needed"]."',
address_issues_by='".$_POST["address_issues_by"]."', 
address_issues_options='".$_POST["address_issues_options"]."',
address_issues_others='".$_POST["address_issues_others"]."',
additional_comments_text='".$_POST["additional_comments_text"]."', 
therapist_name='".$_POST["therapist_name"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
