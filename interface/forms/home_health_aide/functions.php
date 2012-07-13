
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
function patientAddress()
{
        $select= sqlStatement("select street,city,state,postal_code from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
{
        $street= $Row['street'];
        $city= $Row['city'];
        $state= $Row['state'];
		$postal_code= $Row['postal_code'];
        echo $street.", ".$city.", ".$state.", ".$postal_code;
}
}
function patientPhone()
{
        $select= sqlStatement("select phone_home from patient_data where pid=" .$_SESSION['pid']);
        while($Row=sqlFetchArray($select))
{
        $phone_home= $Row['phone_home'];
        echo $phone_home;
}
}


?>
