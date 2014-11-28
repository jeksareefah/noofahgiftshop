<?php require_once('Connections/myconnect.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_studentset = 10;
$pageNum_studentset = 0;
if (isset($_GET['pageNum_studentset'])) {
  $pageNum_studentset = $_GET['pageNum_studentset'];
}
$startRow_studentset = $pageNum_studentset * $maxRows_studentset;

mysql_select_db($database_myconnect, $myconnect);
$query_studentset = "SELECT * FROM students";
$query_limit_studentset = sprintf("%s LIMIT %d, %d", $query_studentset, $startRow_studentset, $maxRows_studentset);
$studentset = mysql_query($query_limit_studentset, $myconnect) or die(mysql_error());
$row_studentset = mysql_fetch_assoc($studentset);

if (isset($_GET['totalRows_studentset'])) {
  $totalRows_studentset = $_GET['totalRows_studentset'];
} else {
  $all_studentset = mysql_query($query_studentset);
  $totalRows_studentset = mysql_num_rows($all_studentset);
}
$totalPages_studentset = ceil($totalRows_studentset/$maxRows_studentset)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td bgcolor="#00CCFF">id</td>
    <td bgcolor="#00CCFF">name</td>
    <td bgcolor="#00CCFF">age</td>
    <td bgcolor="#00CCFF">email</td>
  </tr>
  <?php do { ?>
    <tr>
      <td bgcolor="#00FFFF"><?php echo $row_studentset['id']; ?></td>
      <td bgcolor="#00FFFF"><?php echo $row_studentset['name']; ?></td>
      <td bgcolor="#00FFFF"><?php echo $row_studentset['age']; ?></td>
      <td bgcolor="#00FFFF"><?php echo $row_studentset['email']; ?></td>
    </tr>
    <?php } while ($row_studentset = mysql_fetch_assoc($studentset)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($studentset);
?>
