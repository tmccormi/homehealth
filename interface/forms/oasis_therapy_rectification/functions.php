
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

function VisitDate() {
$select= sqlStatement("select date from form_encounter where pid=" .$_SESSION['pid']." and encounter=".$GLOBALS['encounter']);
while($Row=sqlFetchArray($select)) {
$value= date('Y-m-d',strtotime($Row['date']));
echo $value;
}
}  

//Start Non-function query
$is_it_empty = sqlStatement("SELECT date FROM form_encounter WHERE pid=" .$_SESSION['pid']." AND encounter=".$GLOBALS['encounter']);
while($is_it_empty_row = sqlFetchArray($is_it_empty)) {
$checking_for_date = date('Y-m-d',strtotime($is_it_empty_row['date']));
}
if($checking_for_date == '') {$date_is_blank = 0;} else {$date_is_blank = 1;}
//End Non-function query 

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
