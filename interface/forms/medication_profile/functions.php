
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
function patientDOB()
{
        $select= sqlStatement("select DOB from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
{
        $dob= $Row['DOB'];
        echo $dob;
}
}


function physicianContact()
{
        $select= sqlStatement("select fname,mname,lname,street,streetb,city,state,zip,phone,email from users where id=(select providerID from patient_data where pid= ".$_SESSION['pid'].")");
        while($Row=sqlFetchArray($select))
{
		echo $Row['fname']." ".$Row['mname']." ".$Row['lname']."\n";
		echo $Row['street']." ".$Row['streetb']." ".$Row['city']."\n".$Row['state']." - ".$Row['zip']."\n";
		echo $Row['phone']."\n".$Row['email'];
        
}
}


?>
