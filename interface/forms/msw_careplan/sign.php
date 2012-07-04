<?php
include_once("../../globals.php");
//include_once("$srcdir/FDFWriter.php");
include_once("$srcdir/sql.inc");
require_once("$srcdir/ESign.class.php");

$skipKeys = array("id","pid","date","user","groupname","authorized","activity");
$eSignResult = null;

/**
 * Receives a $_POST with:
 *  signature_uid:  the user id for the signature entry - equates to $_SESSION['authUserID']
 *  signature_id:  the id of the signature entry in the eSignatures table. 
 *  login_pass:  the sha1-encrypted password string - should match $_SESSION['authPass']
 */

foreach($_POST as $key => $value)
{
    $_POST[$key] = htmlspecialchars($_POST[$key]);
}

if($_POST['login_pass'] == $_SESSION['authPass'])
{
    //consider authenticated since $_SESSION is server-side. 
    $eSignResult = sqlQuery("select * from eSignatures where id = '". $_POST['signature_id']. "'");

    if($eSignResult)
    {
        sqlStatement("update eSignatures set `datetime` = now(), `signed`=1, `uid`='". $_POST['signature_uid']."' where `id` = '". $_POST['signature_id']. "'");
        $signingRole = $eSignResult['role'];
    }   
    else
    {
        echo "Signature not on file.  Please re-load the form and try again.";
        exit;
    }
    
    echo "Document Signed<br>";
}
else
{
    echo "Password is invalid";
}

?>
