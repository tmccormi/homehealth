<?php
require_once("../../interface/globals.php");
require_once("$srcdir/sql.inc");
require_once("$srcdir/formatting.inc.php");
$term = trim(strip_tags($_GET['term']));
$qstring = "select id,pid,fname,mname,lname,DOB,phone_home from patient_data WHERE (fname LIKE '%".$term."%') OR (lname LIKE '%".$term."%')";
$result = mysql_query($qstring);
?>
<style>
.result tr:nth-child(odd)
{
background-color:#DDDDFF;
}
.result tr:nth-child(even)
{
background-color:#FFDDDD;
}
</style>
<table border="1px" cellspacing="0" cellpadding="10" bgcolor="#fefdcf" bordercolor="#000000">
	<tr>
		<td>
			<table border="1px" style="border:1px solid black" cellspacing="0" cellpadding="0" class="result">
				<tr>
					<td width="100px" class="text" bgcolor="#DDDDDD">First Name</td>
					<td width="100px" class="text" bgcolor="#DDDDDD">Last Name</td>
					<td width="100px" class="text" bgcolor="#DDDDDD">DOB</td>
					<td width="100px" class="text" bgcolor="#DDDDDD">Home Phone</td>
					<td width="100px" class="text" bgcolor="#DDDDDD">PID</td>
				</tr>
				<tr><td colspan="5" bgcolor="94d6e7">&nbsp;</td></tr>
<?php
while ($row = mysql_fetch_array($result,MYSQL_ASSOC))
{
?>
		<tr>
			<td width="100px" class="text"><a href="#" onclick="open_demography('<?php echo $row["pid"];?>')"><?php echo $row["fname"];?></a></td>
			<td width="100px" class="text"><a href="#" onclick="open_demography('<?php echo $row["pid"];?>')"><?php echo $row["lname"];?></a></td>
			<td width="100px" class="text"><a href="#" onclick="open_demography('<?php echo $row["pid"];?>')"><?php echo $row["DOB"];?></a></td>
			<td width="100px" class="text"><a href="#" onclick="open_demography('<?php echo $row["pid"];?>')"><?php echo $row["phone_home"];?></a></td>
			<td width="100px" class="text"><a href="#" onclick="open_demography('<?php echo $row["pid"];?>')"><?php echo $row["pid"];?></a></td>
		</tr>
<?php
}
?>
		</table>
		</td>
	</tr>
</table>
