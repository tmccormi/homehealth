
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

function Communication_status($sel)
{
	$Comm_status['status']= array(
	'5',
	'4',
	'3',
	'2',
	'1',
	'0'	
);
echo "<option value='' selected='selected'>"."Please Select...". "</option>\n";

foreach($Comm_status['status'] as $stat)
	{
		$selected="";
		if($sel!="new")
		{
			if($sel== $stat)
			{	
				$selected="selected='selected'";
			}			
		echo "<option value='$stat' $selected>".$stat. "</option>\n";
		$selected="";	
		}
	else
	{
		echo "<option value='$stat'>".$stat. "</option>\n";
	}
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





?>
