<?php
// Copyright (C) 2008 Rod Roark <rod@sunsetsystems.com>
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

$fake_register_globals=false;
$sanitize_all_escapes=true;

require_once("../../globals.php");
require_once("$srcdir/patient.inc");
require_once("$srcdir/csv_like_join.php");
require_once("../../../custom/code_types.inc.php");

$info_msg = "";
$codetype = $_REQUEST['codetype'];
if (isset($codetype)) {
	$allowed_codes = split_csv_line($codetype);
}

$form_code_type = $_POST['form_code_type'];
?>
<html>
<head>
<?php html_header_show(); ?>
<title><?php echo xlt('Code Finder'); ?></title>
<link rel="stylesheet" href='<?php echo attr($css_header) ?>' type='text/css'>

<style>
td { font-size:10pt; }
</style>

<script language="JavaScript">

 function selcode(codetype, code, selector, codedesc) {
  if (opener.closed || ! opener.set_related)
   alert('<?php echo addslashes( xl('The destination form was closed; I cannot act on your selection.') ); ?>');
  else
   opener.set_related(codetype, code, selector, codedesc);
  window.close();
  return false;
 }

</script>

</head>

<body class="body_top">

<?php if (isset($allowed_codes)) { ?>
  <form method='post' name='theform' action='find_code_popup.php?codetype=<?php echo attr($codetype) ?>'>
<?php } else { ?>
  <form method='post' name='theform' action='find_code_popup.php'>
<?php } ?>

<center>

<table border='0' cellpadding='5' cellspacing='0'>

 <tr>
  <td height="1">
  </td>
 </tr>

 <tr bgcolor='#ddddff'>
  <td>
   <b>

<?php
if (isset($allowed_codes)) {
	if (count($allowed_codes) === 1) {
  echo "<input type='text' name='form_code_type' value='" . attr($codetype) . "' size='5' readonly>\n";
	} else {
?>
   <select name='form_code_type'>
<?php
		foreach ($allowed_codes as $code) {
			$selected_attr = ($form_code_type == $code) ? " selected='selected'" : '';
?>
   	<option value='<?php echo attr($code) ?>'<?php echo $selected_attr?>><?php echo xlt($code_types[$code]['label']) ?></option>
<?php
		}
?>
   </select>
<?php
	}
}
else {
  echo "   <select name='form_code_type'";
  echo ">\n";
  foreach ($code_types as $key => $value) {
    echo "    <option value='" . attr($key) . "'";
    if ($codetype == $key || $form_code_type == $key) echo " selected";
    echo ">" . xlt($value['label']) . "</option>\n";
  }
  echo "    <option value='PROD'";
  if ($codetype == 'PROD' || $form_code_type == 'PROD') echo " selected";
  echo ">" . xlt("Product") . "</option>\n";
  echo "   </select>&nbsp;&nbsp;\n";
}
?>

 <?php echo xlt('Search for:'); ?>
   <input type='text' name='search_term' size='12' value='<?php echo attr($_REQUEST['search_term']); ?>'
    title='<?php echo xla('Any part of the desired code or its description'); ?>' />
   &nbsp;
   <input type='submit' name='bn_search' value='<?php echo xla('Search'); ?>' />
   &nbsp;&nbsp;&nbsp;
   <input type='button' value='<?php echo xla('Erase'); ?>' onclick="selcode('', '', '', '')" />
   </b>
  </td>
 </tr>

 <tr>
  <td height="1">
  </td>
 </tr>

</table>

<?php if ($_REQUEST['bn_search']) { ?>

<table border='0'>
 <tr>
  <td><b><?php echo xlt('Code'); ?></b></td>
  <td><b><?php echo xlt('Description'); ?></b></td>
 </tr>
<?php
  $search_term = $_REQUEST['search_term'];
  $res = code_set_search($form_code_type,$search_term);
  if ($form_code_type == 'PROD') { // Special case that displays search for products/drugs
    while ($row = sqlFetchArray($res)) {
      $drug_id = addslashes($row['drug_id']);
      $selector = addslashes($row['selector']);
      $desc = addslashes($row['name']);
      $anchor = "<a href='' " .
        "onclick='return selcode(\"PROD\", \"$drug_id\", \"$selector\", \"$desc\")'>";
      echo " <tr>";
      echo "  <td>$anchor" . text($drug_id.":".$selector) . "</a></td>\n";
      echo "  <td>$anchor" . text($desc) . "</a></td>\n";
      echo " </tr>";
    }
  }
  else {
    while ($row = sqlFetchArray($res)) { // Display normal search
      $itercode = addslashes($row['code']);
      $itertext = addslashes(trim($row['code_text']));
      $anchor = "<a href='' " .
        "onclick='return selcode(\"" . addslashes($form_code_type) . "\", \"$itercode\", \"\", \"$itertext\")'>";
      echo " <tr>";
      echo "  <td>$anchor" . text($itercode) . "</a></td>\n";
      echo "  <td>$anchor" . text($itertext) . "</a></td>\n";
      echo " </tr>";
    }
  }
?>
</table>

<?php } ?>

</center>
</form>
</body>
</html>
