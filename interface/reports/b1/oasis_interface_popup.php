<?php
$b1_string=$_GET["b1_string"];
$generated_date=$_GET["generated_date"];
header('Content-type:text/plain');
header('Content-Disposition:attachment;filename="'.$generated_date.'.txt"');
echo $b1_string;
?>