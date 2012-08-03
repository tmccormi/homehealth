
<?php
include_once("../../globals.php");
include_once($GLOBALS["srcdir"] . "/api.inc");

/* include our smarty derived controller class. */
include_once($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');

function nursing_visitnote_report($pid, $encounter, $cols, $id) {
 $count = 0;
 $label = array();
 $wound_val = array();
 $chart = 0;
 $data = formFetch("forms_nursing_visitnote", $id);
 if ($data) {
  print "<table>\n<tr>\n";
  foreach($data as $key => $value) {

   if($key == "wound_label") {
		$label = explode('#',$value);
		continue;
   }
   if($key == "data") {
		if($value!='') { $chart = 1; }
		continue;
   }

   if(($key == "wound_value1") || ($key == "wound_value2") || ($key == "wound_value3") || ($key == "wound_value4") || ($key == "wound_value5") || ($key == "wound_value6") || ($key == "wound_value7") || ($key == "wound_value8")) {
		$wound_val[] = explode('#',$value);
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
   $key = str_replace("Visitnote", "", $key);   
if($value!="Please Select...") 
{  
   print "<td valign='top'><span class='bold'> $key: </span><span class='text'>$value</span></td>\n";
}
   $count++;
   if ($count == $cols) {
    $count = 0;
    print "</tr>\n<tr>\n";
   }
  }
  print "</tr>\n</table>\n";
	if($chart == 1) { 
		$c = new C_FormPainMap('nursing_visitnote','painmap.png');
		/* Render the form. */
		echo $c->report_action($id,'nursing_visitnote');
	}	
	if($label) {
		for($i=0;$i<=7;$i++) {
			$v = $wound_val[$i];
			$table = "<table style='font-size:12px;'><tr><td><b>Wound ".($i+1)." </b></td></tr><tr><td>";
			foreach( $label as $index => $labels  ) {
				if($v[$index] == '') { continue; }
				$table .= "<b> $labels </b>> ".$v[$index].",";
			}
			print $table .= "</td></tr></table>";
		}	
	}
 }
}

?> 
