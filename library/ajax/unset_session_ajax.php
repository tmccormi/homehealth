<?php
require_once("../../interface/globals.php");
if(($_POST['func']=="unset_pid"))
{
	if(isset($_SESSION['pid'])){unset($_SESSION['pid']);}
	if(isset($_SESSION['encounter'])){unset($_SESSION['encounter']);}
}
?> 
