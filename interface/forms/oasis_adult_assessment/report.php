<?php
include_once("../../globals.php");
include_once($GLOBALS["srcdir"] . "/api.inc");

/* include our smarty derived controller class. */
include_once($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');

function oasis_adult_assessment_report($pid, $encounter, $cols, $id) {
 $count = 0;
 $data = formFetch("forms_oasis_adult_assessment", $id);
 $chart = 0;
 
 if ($data) {
  print "<table>\n<tr>\n";
  foreach($data as $key => $value) {
  
	if($key == "data") {
		if($value!='') { $chart = 1; }
		continue;
   }
  
   if ($key == "id" || $key == "pid" || $key == "user" || $key == "groupname" ||
       $key == "authorized" || $key == "activity" || $key == "date" || $key == "detail" || $key == "process" ||
       $value == "" || $value == "0000-00-00 00:00:00") {
    continue;
   }
   if ($value == "on") {
    $value = "yes";
   }
   $key=ucwords(str_replace("_"," ",$key)); 
    $key = str_replace("Oasis", "", $key);   
   print "<td valign='top'><span class='bold'> $key: </span><span class='text'>$value</span></td>\n";
   $count++;
   if ($count == $cols) {
    $count = 0;
    print "</tr>\n<tr>\n";
   }
  }
  print "</tr>\n</table>\n";
  if($chart == 1) { 
		$c = new C_FormPainMap('oasis_adult_assessment','bodymap_man.png');
		/* Render the form. */
		echo $c->report_action($id,'oasis_adult_assessment');
	}
 } // End of if condition
}


?> 
