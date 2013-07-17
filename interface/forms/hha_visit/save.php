<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$addnew = array();

foreach($_POST as $key => $val) {
	if(is_array($val)) { $val = implode("#",$val); }
	$addnew[$key] = mysql_real_escape_string($val);
}

if ($encounter == "")
$encounter = date("Ymd");

if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_hha_visit", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "HHA VISIT", $newid, "hha_visit", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {

foreach($_POST as $key => $value) {
    if(is_array($value)) { $value = implode("#",$value); }
    $_POST[$key] = mysql_real_escape_string($value);
}

sqlInsert("update forms_hha_visit set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),

hha_visit_patient_name ='".$_POST["hha_visit_patient_name"]."',
hha_visit_caregiver_name ='".$_POST["hha_visit_caregiver_name"]."',
hha_visit_date ='".$_POST["hha_visit_date"]."',
hha_visit_time_in ='".$_POST["hha_visit_time_in"]."',
hha_visit_time_out ='".$_POST["hha_visit_time_out"]."',
hha_visit_employee_name ='".$_POST["hha_visit_employee_name"]."',
hha_visit_employee_no ='".$_POST["hha_visit_employee_no"]."',
hha_visit_activities ='".$_POST["hha_visit_activities"]."',
hha_visit_bath ='".$_POST["hha_visit_bath"]."',
hha_visit_bath_date ='".$_POST["hha_visit_bath_date"]."',
hha_visit_bed_bath ='".$_POST["hha_visit_bed_bath"]."',
hha_visit_bed_bath_date ='".$_POST["hha_visit_bed_bath_date"]."',
hha_visit_assist_bath ='".$_POST["hha_visit_assist_bath"]."',
hha_visit_assist_bath_date ='".$_POST["hha_visit_assist_bath_date"]."',
hha_visit_personal_care ='".$_POST["hha_visit_personal_care"]."',
hha_visit_personal_care_date ='".$_POST["hha_visit_personal_care_date"]."',
hha_visit_assist_with_dressing ='".$_POST["hha_visit_assist_with_dressing"]."',
hha_visit_assist_with_dressing_date ='".$_POST["hha_visit_assist_with_dressing_date"]."',
hha_visit_hair_care ='".$_POST["hha_visit_hair_care"]."',
hha_visit_hair_care_date ='".$_POST["hha_visit_hair_care_date"]."',
hha_visit_skin_care ='".$_POST["hha_visit_skin_care"]."',
hha_visit_skin_care_date ='".$_POST["hha_visit_skin_care_date"]."',
hha_visit_check_pressure_areas ='".$_POST["hha_visit_check_pressure_areas"]."',
hha_visit_check_pressure_areas_date ='".$_POST["hha_visit_check_pressure_areas_date"]."',
hha_visit_shave_groom ='".$_POST["hha_visit_shave_groom"]."',
hha_visit_shave_groom_date ='".$_POST["hha_visit_shave_groom_date"]."',
hha_visit_nail_hygiene ='".$_POST["hha_visit_nail_hygiene"]."',
hha_visit_nail_hygiene_date ='".$_POST["hha_visit_nail_hygiene_date"]."',
hha_visit_oral_care ='".$_POST["hha_visit_oral_care"]."',
hha_visit_oral_care_date ='".$_POST["hha_visit_oral_care_date"]."',
hha_visit_elimination_assist ='".$_POST["hha_visit_elimination_assist"]."',
hha_visit_elimination_assist_date ='".$_POST["hha_visit_elimination_assist_date"]."',
hha_visit_catheter_care ='".$_POST["hha_visit_catheter_care"]."',
hha_visit_catheter_care_date ='".$_POST["hha_visit_catheter_care_date"]."',
hha_visit_ostomy_care ='".$_POST["hha_visit_ostomy_care"]."',
hha_visit_ostomy_care_date ='".$_POST["hha_visit_ostomy_care_date"]."',
hha_visit_record ='".$_POST["hha_visit_record"]."',
hha_visit_record_date ='".$_POST["hha_visit_record_date"]."',
hha_visit_inspect_reinforce ='".$_POST["hha_visit_inspect_reinforce"]."',
hha_visit_inspect_reinforce_date ='".$_POST["hha_visit_inspect_reinforce_date"]."',
hha_visit_assist_with_medications ='".$_POST["hha_visit_assist_with_medications"]."',
hha_visit_assist_with_medications_date ='".$_POST["hha_visit_assist_with_medications_date"]."',
hha_visit_T ='".$_POST["hha_visit_T"]."',
hha_visit_T_date ='".$_POST["hha_visit_T_date"]."',
hha_visit_pulse ='".$_POST["hha_visit_pulse"]."',
hha_visit_pulse_date ='".$_POST["hha_visit_pulse_date"]."',
hha_visit_respirations ='".$_POST["hha_visit_respirations"]."',
hha_visit_respirations_date ='".$_POST["hha_visit_respirations_date"]."',
hha_visit_BP ='".$_POST["hha_visit_BP"]."',
hha_visit_BP_date ='".$_POST["hha_visit_BP_date"]."',
hha_visit_weight ='".$_POST["hha_visit_weight"]."',
hha_visit_weight_date ='".$_POST["hha_visit_weight_date"]."',
hha_visit_ambulation_assist ='".$_POST["hha_visit_ambulation_assist"]."',
hha_visit_ambulation_assist_date ='".$_POST["hha_visit_ambulation_assist_date"]."',
hha_visit_mobility_assist ='".$_POST["hha_visit_mobility_assist"]."',
hha_visit_mobility_assist_date ='".$_POST["hha_visit_mobility_assist_date"]."',
hha_visit_ROM ='".$_POST["hha_visit_ROM"]."',
hha_visit_ROM_date ='".$_POST["hha_visit_ROM_date"]."',
hha_visit_positioning ='".$_POST["hha_visit_positioning"]."',
hha_visit_positioning_date ='".$_POST["hha_visit_positioning_date"]."',
hha_visit_exercise ='".$_POST["hha_visit_exercise"]."',
hha_visit_exercise_date ='".$_POST["hha_visit_exercise_date"]."',
hha_visit_diet_order1 ='".$_POST["hha_visit_diet_order1"]."',
hha_visit_diet_order ='".$_POST["hha_visit_diet_order"]."',
hha_visit_diet_order_date ='".$_POST["hha_visit_diet_order_date"]."',
hha_visit_meal_preparation ='".$_POST["hha_visit_meal_preparation"]."',
hha_visit_meal_preparation_date ='".$_POST["hha_visit_meal_preparation_date"]."',
hha_visit_assist_with_feeding ='".$_POST["hha_visit_assist_with_feeding"]."',
hha_visit_assist_with_feeding_date ='".$_POST["hha_visit_assist_with_feeding_date"]."',
hha_visit_limit_encourage_fluids ='".$_POST["hha_visit_limit_encourage_fluids"]."',
hha_visit_limit_encourage_fluids_date ='".$_POST["hha_visit_limit_encourage_fluids_date"]."',
hha_visit_grocery_shopping ='".$_POST["hha_visit_grocery_shopping"]."',
hha_visit_grocery_shopping_date ='".$_POST["hha_visit_grocery_shopping_date"]."',
hha_visit_wash_clothes ='".$_POST["hha_visit_wash_clothes"]."',
hha_visit_wash_clothes_date ='".$_POST["hha_visit_wash_clothes_date"]."',
hha_visit_light_housekeeping ='".$_POST["hha_visit_light_housekeeping"]."',
hha_visit_light_housekeeping_date ='".$_POST["hha_visit_light_housekeeping_date"]."',
hha_visit_observe_universal_precaution ='".$_POST["hha_visit_observe_universal_precaution"]."',
hha_visit_observe_universal_precaution_date ='".$_POST["hha_visit_observe_universal_precaution_date"]."',
hha_visit_equipment_care ='".$_POST["hha_visit_equipment_care"]."',
hha_visit_equipment_care_date ='".$_POST["hha_visit_equipment_care_date"]."',
hha_visit_washing_hands ='".$_POST["hha_visit_washing_hands"]."',
hha_visit_washing_hands_date ='".$_POST["hha_visit_washing_hands_date"]."',
hha_visit_patient_client_sign ='".$_POST["hha_visit_patient_client_sign"]."',
hha_visit_patient_client_sign_date ='".$_POST["hha_visit_patient_client_sign_date"]."',
hha_visit_supplies_used ='".$_POST["hha_visit_supplies_used"]."',
hha_visit_supplies_used_data ='".$_POST["hha_visit_supplies_used_data"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
