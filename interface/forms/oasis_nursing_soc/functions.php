
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

function timeDropDown($sel) {
    echo "<option value='' selected='selected'>"."Please Select..."."</option>";
				
    $array = array("09:00am","09:15am","09:30am","09:45am","10:00am","10:15am","10:30am","10:45am","11:00am","11:15am","11:30am","11:45am","12:00pm","12:15pm","12:30pm","12:45pm","01:00pm","01:15pm","01:30pm","01:45pm","02:00pm","02:15pm","02:30pm","02:45pm","03:00pm","03:15pm","03:30pm","03:45pm","04:00pm","04:15pm","04:30pm","04:45pm","05:00pm","05:15pm","05:30pm","05:45pm","06:00pm","06:15pm","06:30pm","06:45pm","07:00pm","07:15pm","07:30pm","07:45pm","08:00pm","08:15pm","08:30pm","08:45pm","09:00pm","09:15pm","09:30pm","09:45pm","10:00pm","10:15pm","10:30pm","10:45pm","11:00pm","11:15pm","11:30pm","11:45pm","12:00am","12:15am","12:30am","12:45am","01:00am","01:15am","01:30am","01:45am","02:00am","02:15am","02:30am","02:45am","03:00am","03:15am","03:30am","03:45am","04:00am","04:15am","04:30am","04:45am","05:00am","05:15am","05:30am","05:45am","06:00am","06:15am","06:30am","06:45am","07:00am","07:15am","07:30am","07:45am","08:00am","08:15am","08:30am","08:45am");
    $arrlength = count($array);
				
    $selected="";
    if($sel!="new") {
        for($x = 0; $x < $arrlength; $x++) {
            if($sel == date('g:i a', $x))  {
                $selected= "selected='selected'";
            }
            echo "<option value='".$array[$x]."'". $selected.">".$array[$x].'</option>';
            $selected="";
        }
        } else {
        for($x = 0; $x < $arrlength; $x++) {
            echo "<option value='".$array[$x]."'".">".$array[$x].'</option>';
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

//Start Non-function query
$is_it_empty = sqlStatement("SELECT date FROM form_encounter WHERE pid=" .$_SESSION['pid']." AND encounter=".$GLOBALS['encounter']);
while($is_it_empty_row = sqlFetchArray($is_it_empty)) {
$checking_for_date = date('Y-m-d',strtotime($is_it_empty_row['date']));
}
if($checking_for_date == '') {$date_is_blank = 0;} else {$date_is_blank = 1;}
//End Non-function query
?>
