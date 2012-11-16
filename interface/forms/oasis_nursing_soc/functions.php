
<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

function patientfullName()
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
function timeDropDown($sel)
{ 
echo "<option value='' selected='selected'>"."Please Select...". "</option>\n";
	  $start = strtotime('9:00am');
	  $end = strtotime('9:00pm');
	  $selected="";
	  if($sel!="new")
	  {
	    for ($i = $start; $i <= $end; $i += 900)
	    {		
		if($sel== date('g:i a', $i))
		{	
			$selected= "selected='selected'";			
		}
		echo "<option value='".date('g:i a', $i)."'". $selected.">" . date('g:i a', $i).'</option>';
		$selected="";			
	    }
	  }
	  else
	  {
	    for ($i = $start; $i <= $end; $i += 900)
	    {
		echo "<option value='".date('g:i a', $i)."'".">" . date('g:i a', $i).'</option>';
	    }
	  }
}      

function VisitDate()
 {
        $select= sqlStatement("select date from form_encounter where pid=" .$_SESSION['pid']." and encounter=".$GLOBALS['encounter']);
        while($Row=sqlFetchArray($select))
        {
          $value= date('Y-m-d',strtotime($Row['date']));
        echo $value;
        }
}  

function patientName($field)
 {
        $select= sqlStatement("select " .$field. " from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
	{
	  $value= $Row[$field];
	echo $value;
        }	
}

function patientGender()
 {
        $select= sqlStatement("select sex from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
	{
	  return $Row["sex"];
	
        }	
}

?>
