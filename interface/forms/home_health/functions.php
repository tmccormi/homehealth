
<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

$icdCode = strip_tags(trim($_REQUEST['code']));
$Dx= strip_tags(trim($_REQUEST['Dx']));
if($icdCode)
{
	ICD9SelDrop($icdCode,$Dx);
}

function patientName($field)
{
        $select= sqlStatement("select fname,mname,lname,sex,DOB from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
{
       echo $Row['lname']." ".$Row['mname']." ".$Row['fname'];
	
}
}

function patientSex($field)
{
        $select= sqlStatement("select sex from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
{
       return $Row['sex'];
	
}
}

function doctorname()
{
	$select= sqlStatement("select fname,mname,lname from users where id=(select providerID from patient_data where pid= ".$_SESSION['pid'].")");
	        while($Row=sqlFetchArray($select))
{
       echo $Row['lname']." ".$Row['mname']." ".$Row['fname'];
	
}
	
}

function doctorNameAddr()
{

	doctorname();
	echo "\n";
	
$select= sqlStatement("select street,streetb,city,state,zip from users where id=(select providerID from patient_data where pid= ".$_SESSION['pid'].")");
	        while($Row=sqlFetchArray($select))
{
       echo $Row['street']."\n".$Row['streetb']."\n".$Row['city']."\n".$Row['zip']."\n".$Row['state'];
	
}
}

function doctorPhone()
{
	$select= sqlStatement("select phonew1 from users where id=(select providerID from patient_data where pid= ".$_SESSION['pid'].")");
	        while($Row=sqlFetchArray($select))
{
       echo $Row['phonew1'];
	
}
	
}

function doctorFax()
{
	$select= sqlStatement("select fax from users where id=(select providerID from patient_data where pid= ".$_SESSION['pid'].")");
	        while($Row=sqlFetchArray($select))
{
       echo $Row['fax'];
	
}
	
}

function doctorNPI()
{
	$select= sqlStatement("select npi from users where id=(select providerID from patient_data where pid= ".$_SESSION['pid'].")");
	        while($Row=sqlFetchArray($select))
{
       echo $Row['npi'];
	
}
	
}



function patientNameAddr()
{

	patientName();
	
	echo "\n";
	$select= sqlStatement("select street,postal_code,city,state,country_code from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
{
       echo $Row['street']."\n".$Row['city']."\n".$Row['postal_code']."\n".$Row['state']."\n".$Row['country_code'];
	
}
}


function VisitDate()
 {
        $select= sqlStatement("select date from form_encounter where pid=" .$_SESSION['pid']." and encounter=".$GLOBALS['encounter']);
        while($Row=sqlFetchArray($select))
        {
          $value= $Row['date'];
        echo $value;
        }
}

function patientDOB($field)
{
        $select= sqlStatement("select fname,mname,lname,sex,DOB from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
{
       echo $Row['DOB'];
	
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

function ICD9_dropdown($sel)
{
          $select= sqlStatement("select code,code_text from codes");
		$selected="";		
		echo "<option value='' selected='selected'>"."Please Select...". "</option>\n";
          while($Row=sqlFetchArray($select))
          {
              $id= $Row['code'];
              $descr= $Row['code_text'];
          if($sel!="new")
			{
			if($sel== $id)
			{	
				$selected="selected='selected'";
			}
			 echo "<option value='$id' title=".$descr.". $selected> ".$id."</option>\n";
			$selected="";	
			}
			else 
			{
              echo "<option value='$id' title=".$descr."> ".$id."</option>\n";
			}
          }
}



function physicianNameDropDown($sel)
{
          $select= sqlStatement("select fname,mname,lname from users where id in (select providerID from patient_data);");
		$selected="";
		echo "<option value='' selected='selected'>"."Please Select...". "</option>\n";
          while($Row=sqlFetchArray($select))
          {
              $name= $Row['fname']." ".$Row['mname']." ".$Row['lname'];

          if($sel!="new")
			{
			if($sel== $name)
			{	
				$selected="selected='selected'";
			}
			 echo "<option value='$name' $selected> ".$name."</option>\n";
			$selected="";	
			}
			else 
			{
              echo "<option value='$id'> ".$id."</option>\n";
			}
          }
}



function ICD9SelDrop($Sel,$Dx)
{
	$result="";
	$select= sqlStatement("SELECT code, modifier, code_text FROM codes WHERE " .
    "(code_text LIKE '%" . $Sel. "%' OR code LIKE '%" .$Sel . "%') AND active = 1 ORDER BY code");
	$result.="<select id='".$Dx."' name='".$Dx."'>";
	$result.="<option value='' selected='selected'>"."Please Select...". "</option>\n"; 
 	while($Row=sqlFetchArray($select))
          {
          	 $id= $Row['code'];
         	 $result.= "<option value='$id' title=".$descr."> ".$id."</option>\n";
           }
           $result.= "</select>";           
          echo json_encode(array('res'  =>  $result));
 
 }


function Freq_Duration($sel)
{
        $Fre_duration['units']=array(
        'Day', 'Week','Month','Year');
echo "<option value='' selected='selected'>"."Please Select...". "</option>\n";
foreach($Fre_duration['units'] as $units)
        {
                $selected="";
                if($sel!="new")
                {
                        if($sel== $units)
                        {
                                $selected="selected='selected'";
                        }
                echo "<option value='$units' $selected>".$units. "</option>\n";
                $selected="";
                }
                else
                {
                echo "<option value='$units'>".$units. "</option>\n";
                }
        }
}

function goals_date($name, $val='') {
	return 
			"<input type='text' size='10' name='$name' id='$name'
							title='yyyy-mm-dd Date of Birth'
							onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' value='".stripslashes($val)."'  readonly/> 
							<img src='../../pic/show_calendar.gif' align='absbottom' width='24'
							height='22' id='img_$name' border='0' alt='[?]'
							style='cursor: pointer; cursor: hand'
							title='Click here to choose a date'> 
			<script	LANGUAGE='JavaScript'>
				Calendar.setup({inputField:'$name', ifFormat:'%Y-%m-%d', button:'img_$name'});
		   </script>";
   
   }
   


?>
