<?php
require_once("../../interface/globals.php");
require_once("$srcdir/sql.inc");
require_once("$srcdir/formatting.inc.php");
$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends
$code_type=$_GET['code_type'];
$condition=$_GET['condition'];
$where="code like '".$term."%' AND  code_type =".$code_type;
if($condition=="noev")
{
        $where=$where." AND code NOT LIKE 'E%' AND code NOT LIKE 'V%'";
}
if($condition=="noe")
{
        $where=$where." AND code NOT LIKE 'E%'";
}
$qstring = "select code from codes where ".$where;
$result = mysql_query($qstring);//query the database for entries containing the term

while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
{
                //$row['value']=htmlentities(stripslashes($row['value']));
                //$row['id']=(int)$row['id'];
                $row_set[] = $row;//build an array
}
echo json_encode($row_set);//format the array into json data
?>
