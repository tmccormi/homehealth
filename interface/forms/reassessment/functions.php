
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


function Mobility_status($sel)
{
	$Mob_status['status']= array(
	'U',
	'Dep',
	'Max',
	'Mod',
	'Min',
	'CG',
	'SBA',
	'S',
	'Mod I',
	'Independent'
);
echo "<option value='' selected='selected'>"."Please Select...". "</option>\n";

foreach($Mob_status['status'] as $stat)
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


function Balance_skills($sel)
{
	$Bal_skills['skills']=array(
	'G','F','P');
echo "<option value='' selected='selected'>"."Please Select...". "</option>\n";
foreach($Bal_skills['skills'] as $skill)
	{
		$selected="";
		if($sel!="new")
		{
			if($sel== $skill)
			{	
				$selected="selected='selected'";
			}			
		echo "<option value='$skill' $selected>".$skill. "</option>\n";
		$selected="";	
		}
		else
		{
		echo "<option value='$skill'>".$skill. "</option>\n";	
		}
	}
}

?>
