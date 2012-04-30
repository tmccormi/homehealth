<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

function patientName()
{
        $select= sqlStatement("select fname,mname,lname from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
{
        $fname= $Row['fname'];
        $lname= $Row['lname'];
        $mname= $Row['mname'];
        echo $fname." ".$mname." ".$lname;
}
}

function ICD9_dropdown()
{
          $select= sqlStatement("select code,code_text from codes");
          while($Row=sqlFetchArray($select))
          {
              $id= $Row['code'];
              $descr= $Row['code_text'];
              echo "<option value='$id' title=".$descr."> ".$id."</option>\n";
          }
}

function timeDropDown()
{ 
	  $start = strtotime('9:00am');
	  $end = strtotime('9:00pm');
	  for ($i = $start; $i <= $end; $i += 900)
	  {
	      echo '<option>' . date('g:i a', $i);
	  }
}
?>
