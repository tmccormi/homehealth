
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
          $select= sqlStatement("select code,code_text from codes where code_type='2' && superbill='COMMON'");
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


?>
