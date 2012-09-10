<?php
require_once("../../globals.php");
require_once("$srcdir/sql.inc");
require_once("$srcdir/formatting.inc.php");
if($_POST["func"]=="Analyse")
{
$user=$_POST["user"];
$pid=$_POST["pid"];
$form_name=$_POST["form_name"];
$table_name=$_POST["table_name"];
$form_id=$_POST["form_id"];
$encounter=$_POST['encounter'];
$b1_string=$_POST['b1_string'];
$timestamp=date('Y-m-d H:i:s',time());
$client = new SoapClient("https://services.ppsplus.com/services/analysisservice.asmx?wsdl");
$vendor_key='PPS-1ADF43FD-B331-4502-B7C7-ACEDD4523BA5';
$result = $client->Analysis(array('Key'=>$vendor_key, 'B1_String'=>$b1_string));
//print_r($result);
if($result->AnalysisResult->ResultCode=="Success")
{
$pdf_result=$client->AnalysisPDF(array('Key'=>$vendor_key, 'B1_String'=>$b1_string));
$file_name=$pid.$form_name.$timestamp.".pdf";
$analyse="Success";
?>

<?php
/*echo "<br>User: ".$user;
echo "<br>Pid: ".$pid;
echo "<br>Form_name: ".$form_name;
echo "<br>Encounter: ".$encounter;
echo "<br>Timestamp: ".$timestamp;
echo "<br>ResultCode: ".$pdf_result->AnalysisPDFResult->ResultCode;
echo "<br>ErrorMessage: ".$pdf_result->AnalysisPDFResult->ErrorMessage;
echo "<br>DaysRemainingInTrial: ".$pdf_result->AnalysisPDFResult->DaysRemainingInTrial;
echo "<br>IsCustomer: ".$pdf_result->AnalysisPDFResult->IsCustomer;*/
if($pdf_result->AnalysisPDFResult->ResultCode=="Success")
{
	$analyse_pdf="Success";
	file_put_contents("pdf/".$file_name, $pdf_result->AnalysisPDFResult->Analysis_PDF);
	echo "Done";
}
else
{
	echo "<br>ErrorMessage: ".$pdf_result->AnalysisPDFResult->ErrorMessage;
	$analyse_pdf="Failure";
}
}
else
{
	$analyse="Failure";
	echo "Analyse Failed";
	echo "<br>ErrorMessage: ".$result->AnalysisResult->ErrorMessage;
	$analyse_pdf="Not called";
}
$qstring2 = "insert into oasis_pdf values('','$user','$pid','$encounter','$form_name','$table_name','$form_id','$b1_string','$timestamp','$analyse','$analyse_pdf','$file_name')";
$result2 = mysql_query($qstring2);
}
if($_POST["func"]=="Select")
{
	$qstring1 = "select * from oasis_pdf ORDER BY generated_date DESC";
	$result1 = mysql_query($qstring1);//query the database for entries containing the term
	echo "<tbody id='result_table'>";
	while ($row=mysql_fetch_array($result1,MYSQL_ASSOC))
	{
	?>
		<tr>
			<td><?php echo $row["pid"];?></td>
			<td><?php echo $row["user"];?></td>
			<td><?php echo $row["form_name"];?></td>
			<td><?php echo $row["encounter"];?></td>
			<td><?php echo $row["analyse"];?></td>
			<td><?php echo $row["analyse_pdf"];?></td>
			<td class="center"><?php echo $row["generated_date"];?></td>
			<td class="center" width="90px">
				<?php if($row["analyse_pdf"]=="Success"){?>
					<a href="pdf/<?php echo $row["filename"];?>" target="_blank"><img src="../../pic/pdf.png" border="0" title="Download PDF" alt="Download PDF"></a>
				<?php }?>
				<img src="../../pic/view_b1.png" onclick="get_b1_text('<?php  echo $row["b1_string"];?>','<?php echo $row["generated_date"];?>')" border="0" title="View B1" alt="View B1" style="cursor:pointer;">
				<img src="../../pic/Delete.gif" onclick="delete_record(<?php  echo $row["id"];?>)" border="0" title="Delete" alt="Delete" style="cursor:pointer;">
			</td>
		</tr>
	<?php
	}
	echo "</tbody>";
}
if($_POST["func"]=="Delete Record")
{
	$id_pk=$_POST["id_pk"];
	$qstring3 = "select * from oasis_pdf where id='$id_pk'";
	$result3 = mysql_query($qstring3);//query the database for entries containing the term
	if(mysql_num_rows($result3)==1)
	{
		mysql_query("DELETE FROM oasis_pdf where id='$id_pk'");
		echo "Record Deleted";
	}
	else
	{
		echo "Cannot delete the record";
	}
}
if($_POST["func"]=="Get B1 Record")
{
	$b1_string=$_POST["b1_string"];
	header('Content-type:text/plain');
	header('Content-Disposition:attachment;filename="filename.txt"');
	echo $b1_string;
}
?>
