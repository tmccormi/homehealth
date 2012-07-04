<?php
include_once("../../globals.php");
include_once($GLOBALS["srcdir"] . "/api.inc");

function thirtyday_progress_note_report($pid, $encounter, $cols, $id) {
 $count = 0;
 $data = formFetch("forms_30_day_progress_note", $id);
 if ($data) {
  print "<table>\n<tr>\n";
  foreach($data as $key => $value) {
   if ($key == "id" || $key == "pid" || $key == "user" || $key == "groupname" ||
       $key == "authorized" || $key == "activity" || $key == "date" ||
       $value == "" || $value == "0000-00-00 00:00:00") {
    continue;
   }
   if ($value == "on") {
    $value = "yes";
   }
   $key=ucwords(str_replace("_"," ",$key));  
   print "<td valign='top'><span class='bold'>$key: </span><span class='text'>$value</span></td>\n";
   $count++;
   if ($count == $cols) {
    $count = 0;
    print "</tr>\n<tr>\n";
   }
  }
  print "</tr>\n</table>\n";
 }
}
?> 
