
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

function doctorname()
{
	$select= sqlStatement("select fname,mname,lname from users where id=(select providerID from patient_data where pid= ".$_SESSION['pid'].")");
	        while($Row=sqlFetchArray($select))
{
       echo $Row['lname']." ".$Row['mname']." ".$Row['fname'];
	
}
	
}
function physicianfax()
{
	$select= sqlStatement("select fax from users where id=(select providerID from patient_data where pid= ".$_SESSION['pid'].")");
	        while($Row=sqlFetchArray($select))
{
       echo $Row['fax'];
	
}
	
}

?>
