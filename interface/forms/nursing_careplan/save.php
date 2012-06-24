<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$addnew = array();
foreach($_POST as $key => $val) {
	if(is_array($val)) { $val = implode("#",$val); }
	$addnew[$key] = $val;
}
if ($encounter == "")
$encounter = date("Ymd");
if ($_GET["mode"] == "new"){
$newid = formSubmit("forms_nursing_careplan", $addnew, $_GET["id"], $userauthorized);
addForm($encounter, "Nursing Careplan", $newid, "nursing_careplan", $pid, $userauthorized);
}
elseif ($_GET["mode"] == "update") {
sqlInsert("update forms_nursing_careplan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
careplan_Assess_Vital_Signs ='".implode("#",$_POST["careplan_Assess_Vital_Signs"])."',
careplan_Assess_Vital_Signs_Specify ='".$_POST["careplan_Assess_Vital_Signs_Specify"]."',
careplan_SN_Skilled_Assessment ='".implode("#",$_POST["careplan_SN_Skilled_Assessment"])."',
careplan_SN_Skilled_Assessment_Other ='".$_POST["careplan_SN_Skilled_Assessment_Other"]."',
careplan_SN_CARDIO_Assess ='".implode("#",$_POST["careplan_SN_CARDIO_Assess"])."',
careplan_SN_CARDIO_Assess_Other ='".$_POST["careplan_SN_CARDIO_Assess_Other"]."',
careplan_SN_CARDIO_Teach ='".implode("#",$_POST["careplan_SN_CARDIO_Teach"])."',
careplan_SN_CARDIO_Teach_Fluid ='".$_POST["careplan_SN_CARDIO_Teach_Fluid"]."',
careplan_SN_CARDIO_Teach_Other ='".$_POST["careplan_SN_CARDIO_Teach_Other"]."',
careplan_SN_CARDIO_PtPcgGoals ='".implode("#",$_POST["careplan_SN_CARDIO_PtPcgGoals"])."',
cardi0_cal1 ='".$_POST["cardi0_cal1"]."',
cardi0_cal2 ='".$_POST["cardi0_cal2"]."',
cardi0_cal3 ='".$_POST["cardi0_cal3"]."',
cardi0_cal4 ='".$_POST["cardi0_cal4"]."',
careplan_SN_CARDIO_PtPcgGoals_Other ='".$_POST["careplan_SN_CARDIO_PtPcgGoals_Other"]."',
careplan_SN_ENDO_Assess ='".implode("#",$_POST["careplan_SN_ENDO_Assess"])."',
careplan_SN_ENDO_Assess_Hrs ='".$_POST["careplan_SN_ENDO_Assess_Hrs"]."',
careplan_SN_ENDO_Admin_Other ='".$_POST["careplan_SN_ENDO_Admin_Other"]."',
careplan_SN_ENDO_Assess_Suchas ='".$_POST["careplan_SN_ENDO_Assess_Suchas"]."',
careplan_SN_ENDO_Assess_Other ='".$_POST["careplan_SN_ENDO_Assess_Other"]."',
careplan_SN_ENDO_Teach ='".implode("#",$_POST["careplan_SN_ENDO_Teach"])."',
careplan_SN_ENDO_cal_ada ='".$_POST["careplan_SN_ENDO_cal_ada"]."',
careplan_SN_ENDO_Other_Diet ='".$_POST["careplan_SN_ENDO_Other_Diet"]."',
careplan_SN_ENDO_Perform ='".implode("#",$_POST["careplan_SN_ENDO_Perform"])."',
careplan_SN_ENDO_Perform_Insulin ='".$_POST["careplan_SN_ENDO_Perform_Insulin"]."',
careplan_SN_ENDO_Perform_Freq ='".$_POST["careplan_SN_ENDO_Perform_Freq"]."',
careplan_SN_ENDO_Perform_Other ='".$_POST["careplan_SN_ENDO_Perform_Other"]."',
careplan_SN_ENDO_PCgGoals ='".implode("#",$_POST["careplan_SN_ENDO_PCgGoals"])."',
careplan_SN_ENDO_PCgGoals_text1 ='".$_POST["careplan_SN_ENDO_PCgGoals_text1"]."',
careplan_SN_ENDO_PCgGoals_Other ='".$_POST["careplan_SN_ENDO_PCgGoals_Other"]."',
endo_cal1 ='".$_POST["endo_cal1"]."',
endo_cal2 ='".$_POST["endo_cal2"]."',
endo_cal3 ='".$_POST["endo_cal3"]."',
endo_cal4 ='".$_POST["endo_cal4"]."',
endo_cal5 ='".$_POST["endo_cal5"]."',
careplan_SN_GASTRO_Assess ='".implode("#",$_POST["careplan_SN_GASTRO_Assess"])."',
careplan_SN_GASTRO_Other ='".$_POST["careplan_SN_GASTRO_Other"]."',
careplan_SN_GASTRO_Teach ='".implode("#",$_POST["careplan_SN_GASTRO_Teach"])."',
careplan_SN_GASTRO_Suchas ='".$_POST["careplan_SN_GASTRO_Suchas"]."',
careplan_SN_GASTRO_Teach_Freq ='".$_POST["careplan_SN_GASTRO_Teach_Freq"]."',
careplan_SN_GASTRO_Teach_Other ='".$_POST["careplan_SN_GASTRO_Teach_Other"]."',
careplan_SN_GASTRO_Perform ='".implode("#",$_POST["careplan_SN_GASTRO_Perform"])."',
careplan_SN_GASTRO_Perform_Freq ='".$_POST["careplan_SN_GASTRO_Perform_Freq"]."',
careplan_SN_GASTRO_Perform_followup ='".$_POST["careplan_SN_GASTRO_Perform_followup"]."',
careplan_SN_GASTRO_Perform_admin ='".$_POST["careplan_SN_GASTRO_Perform_admin"]."',
careplan_SN_GASTRO_Perform_admin_freq ='".$_POST["careplan_SN_GASTRO_Perform_admin_freq"]."',
careplan_SN_GASTRO_Perform_Other ='".$_POST["careplan_SN_GASTRO_Perform_Other"]."',
careplan_SN_GASTRO_PcGoals ='".implode("#",$_POST["careplan_SN_GASTRO_PcGoals"])."',
careplan_SN_GASTRO_PcGoals_Other ='".$_POST["careplan_SN_GASTRO_PcGoals_Other"]."',
gastro_cal1 ='".$_POST["gastro_cal1"]."',
careplan_SN_GENITO_Assess ='".implode("#",$_POST["careplan_SN_GENITO_Assess"])."',
careplan_SN_GENITO_Assess_Other ='".$_POST["careplan_SN_GENITO_Assess_Other"]."',
careplan_SN_GENITO_Teach ='".implode("#",$_POST["careplan_SN_GENITO_Teach"])."',
careplan_SN_GENITO_Teach_Freq ='".$_POST["careplan_SN_GENITO_Teach_Freq"]."',
careplan_SN_GENITO_Teach_Other ='".$_POST["careplan_SN_GENITO_Teach_Other"]."',
careplan_SN_GENITO_Perform ='".implode("#",$_POST["careplan_SN_GENITO_Perform"])."',
careplan_SN_GENITO_Perform_size ='".$_POST["careplan_SN_GENITO_Perform_size"]."',
careplan_SN_GENITO_Perform_ordered ='".$_POST["careplan_SN_GENITO_Perform_ordered"]."',
careplan_SN_GENITO_Perform_Other ='".$_POST["careplan_SN_GENITO_Perform_Other"]."',
careplan_SN_GENITO_PcgGoals ='".implode("#",$_POST["careplan_SN_GENITO_PcgGoals"])."',
genito_cal1 ='".$_POST["genito_cal1"]."',
genito_cal2 ='".$_POST["genito_cal2"]."',
genito_cal3 ='".$_POST["genito_cal3"]."',
genito_cal4 ='".$_POST["genito_cal4"]."',
careplan_SN_GENITO_PcgGoals_Other ='".$_POST["careplan_SN_GENITO_PcgGoals_Other"]."',
careplan_SN_INTEGU_Assess ='".implode("#",$_POST["careplan_SN_INTEGU_Assess"])."',
careplan_SN_INTEGU_Assess_Other ='".$_POST["careplan_SN_INTEGU_Assess_Other"]."',
careplan_SN_INTEGU_Teach ='".implode("#",$_POST["careplan_SN_INTEGU_Teach"])."',
careplan_SN_INTEGU_Teach_Other ='".$_POST["careplan_SN_INTEGU_Teach_Other"]."',
careplan_SN_INTEGU_Perform ='".$_POST["careplan_SN_INTEGU_Perform"]."',
careplan_SN_INTEGU_Perform_location ='".$_POST["careplan_SN_INTEGU_Perform_location"]."',
careplan_SN_INTEGU_Perform_Freq ='".$_POST["careplan_SN_INTEGU_Perform_Freq"]."',
careplan_SN_INTEGU_Perform_Clean ='".$_POST["careplan_SN_INTEGU_Perform_Clean"]."',
careplan_SN_INTEGU_Perform_Pack ='".$_POST["careplan_SN_INTEGU_Perform_Pack"]."',
careplan_SN_INTEGU_Perform_Apply ='".$_POST["careplan_SN_INTEGU_Perform_Apply"]."',
careplan_SN_INTEGU_Perform_Cover ='".$_POST["careplan_SN_INTEGU_Perform_Cover"]."',
careplan_SN_INTEGU_Perform_Secure ='".$_POST["careplan_SN_INTEGU_Perform_Secure"]."',
careplan_SN_INTEGU_PcgGoals ='".implode("#",$_POST["careplan_SN_INTEGU_PcgGoals"])."',
careplan_SN_INTEGU_PcgGoals_areas ='".$_POST["careplan_SN_INTEGU_PcgGoals_areas"]."',
integu_cal1 ='".$_POST["integu_cal1"]."',
integu_cal2 ='".$_POST["integu_cal2"]."',
integu_cal3 ='".$_POST["integu_cal3"]."',
careplan_SN_INTEGU_PcgGoals_Other ='".$_POST["careplan_SN_INTEGU_PcgGoals_Other"]."',
careplan_SN_MUSCULO_Assess ='".implode("#",$_POST["careplan_SN_MUSCULO_Assess"])."',
careplan_SN_MUSCULO_Assess_Other ='".$_POST["careplan_SN_MUSCULO_Assess_Other"]."',
careplan_SN_MUSCULO_Teach ='".implode("#",$_POST["careplan_SN_MUSCULO_Teach"])."',
careplan_SN_MUSCULO_Teach_Other ='".$_POST["careplan_SN_MUSCULO_Teach_Other"]."',
careplan_SN_MUSCULO_Perform_Venipuncture ='".$_POST["careplan_SN_MUSCULO_Perform_Venipuncture"]."',
careplan_SN_MUSCULO_Perform_staples ='".$_POST["careplan_SN_MUSCULO_Perform_staples"]."',
careplan_SN_MUSCULO_Perform_Other ='".$_POST["careplan_SN_MUSCULO_Perform_Other"]."',
careplan_SN_MUSCULO_PcgGoals ='".implode("#",$_POST["careplan_SN_MUSCULO_PcgGoals"])."',
musculo_cal1 ='".$_POST["musculo_cal1"]."',
musculo_cal2 ='".$_POST["musculo_cal2"]."',
musculo_cal3 ='".$_POST["musculo_cal3"]."',
musculo_cal4 ='".$_POST["musculo_cal4"]."',
careplan_SN_MUSCULO_PcgGoals_Other ='".$_POST["careplan_SN_MUSCULO_PcgGoals_Other"]."',
careplan_SN_MENTAL_Assess ='".implode("#",$_POST["careplan_SN_MENTAL_Assess"])."',
careplan_SN_MENTAL_Assess_Other ='".$_POST["careplan_SN_MENTAL_Assess_Other"]."',
careplan_SN_MENTAL_Teach ='".implode("#",$_POST["careplan_SN_MENTAL_Teach"])."',
careplan_SN_MENTAL_Teach_Other ='".$_POST["careplan_SN_MENTAL_Teach_Other"]."',
careplan_SN_MENTAL_PcgGoals ='".implode("#",$_POST["careplan_SN_MENTAL_PcgGoals"])."',
mental_cal1 ='".$_POST["mental_cal1"]."',
mental_cal2 ='".$_POST["mental_cal2"]."',
mental_cal3 ='".$_POST["mental_cal3"]."',
careplan_SN_MENTAL_PcgGoals_Other ='".$_POST["careplan_SN_MENTAL_PcgGoals_Other"]."',
careplan_SN_NEURO_Assess ='".implode("#",$_POST["careplan_SN_NEURO_Assess"])."',
careplan_SN_NEURO_Assess_minutes ='".$_POST["careplan_SN_NEURO_Assess_minutes"]."',
careplan_SN_NEURO_Assess_Other ='".$_POST["careplan_SN_NEURO_Assess_Other"]."',
careplan_SN_NEURO_Teach ='".implode("#",$_POST["careplan_SN_NEURO_Teach"])."',
careplan_SN_NEURO_Teach_Other ='".$_POST["careplan_SN_NEURO_Teach_Other"]."',
careplan_SN_NEURO_PcgGoals ='".implode("#",$_POST["careplan_SN_NEURO_PcgGoals"])."',
neuro_cal1 ='".$_POST["neuro_cal1"]."',
neuro_cal2 ='".$_POST["neuro_cal2"]."',
neuro_cal3 ='".$_POST["neuro_cal3"]."',
neuro_cal4 ='".$_POST["neuro_cal4"]."',
neuro_cal5 ='".$_POST["neuro_cal5"]."',
careplan_SN_NEURO_PcgGoals_Other ='".$_POST["careplan_SN_NEURO_PcgGoals_Other"]."',
careplan_SN_RESPIR_Assess ='".implode("#",$_POST["careplan_SN_RESPIR_Assess"])."',
careplan_SN_RESPIR_Assess_Other ='".$_POST["careplan_SN_RESPIR_Assess_Other"]."',
careplan_SN_RESPIR_Teach ='".implode("#",$_POST["careplan_SN_RESPIR_Teach"])."',
careplan_SN_RESPIR_Teach_Other ='".$_POST["careplan_SN_RESPIR_Teach_Other"]."',
careplan_SN_RESPIR_Perform ='".$_POST["careplan_SN_RESPIR_Perform"]."',
careplan_SN_RESPIR_Perform_Freq ='".$_POST["careplan_SN_RESPIR_Perform_Freq"]."',
careplan_SN_RESPIR_Perform_Other ='".$_POST["careplan_SN_RESPIR_Perform_Other"]."',
careplan_SN_RESPIR_PcgGoals ='".implode("#",$_POST["careplan_SN_RESPIR_PcgGoals"])."',
respir_cal1 ='".$_POST["respir_cal1"]."',
respir_cal2 ='".$_POST["respir_cal2"]."',
respir_cal3 ='".$_POST["respir_cal3"]."',
respir_cal4 ='".$_POST["respir_cal4"]."',
respir_cal5 ='".$_POST["respir_cal5"]."',
respir_cal6 ='".$_POST["respir_cal6"]."',
careplan_SN_RESPIR_PcgGoals_Other ='".$_POST["careplan_SN_RESPIR_PcgGoals_Other"]."',
careplan_SN_GENERAL_Assess ='".implode("#",$_POST["careplan_SN_GENERAL_Assess"])."',
careplan_SN_GENERAL_Assess_Other ='".$_POST["careplan_SN_GENERAL_Assess_Other"]."',
careplan_SN_GENERAL_Teach ='".implode("#",$_POST["careplan_SN_GENERAL_Teach"])."',
careplan_SN_GENERAL_Teach_Other ='".$_POST["careplan_SN_GENERAL_Teach_Other"]."',
careplan_SN_GENERAL_PcgGoals ='".implode("#",$_POST["careplan_SN_GENERAL_PcgGoals"])."',
general_cal1 ='".$_POST["general_cal1"]."',
general_cal2 ='".$_POST["general_cal2"]."',
general_cal3 ='".$_POST["general_cal3"]."',
careplan_SN_GENERAL_PcgGoals_Other ='".$_POST["careplan_SN_GENERAL_PcgGoals_Other"]."',
label ='".$_POST["label"]."',
detail ='".$_POST["detail"]."',
data ='".$_POST["data"]."',
process ='".$_POST["process"]."',
wound_label ='".implode("#",$_POST["wound_label"])."',
wound_value1 ='".implode("#",$_POST["wound_value1"])."',
wound_value2 ='".implode("#",$_POST["wound_value2"])."',
wound_value3 ='".implode("#",$_POST["wound_value3"])."',
wound_value4 ='".implode("#",$_POST["wound_value4"])."',
wound_value5 ='".implode("#",$_POST["wound_value5"])."',
wound_value6 ='".implode("#",$_POST["wound_value6"])."',
wound_value7 ='".implode("#",$_POST["wound_value7"])."',
wound_value8 ='".implode("#",$_POST["wound_value8"])."',
Interventions ='".$_POST["Interventions"]."',
wound_comments ='".$_POST["wound_comments"]."',
careplan_SN_WC_status ='".$_POST["careplan_SN_WC_status"]."',
careplan_SN_provide_wound_care ='".$_POST["careplan_SN_provide_wound_care"]."',
careplan_SN_wound_status ='".$_POST["careplan_SN_wound_status"]."'

where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

?>
