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
?>
<?php
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "from_add1")) {
  $updateSQL = sprintf("UPDATE tw_symptom SET t_date=%s, t_symptom=%s, t_id=%s WHERE t_name=%s",
                       GetSQLValueString($_POST['t_date'], "text"),
                       GetSQLValueString($_POST['t_symptom'], "text"),
                       GetSQLValueString($_POST['t_id'], "text"),
                       GetSQLValueString($_POST['t_id'], "int"));

  mysql_select_db($database_connect_db1, $connect_db1);
  $Result1 = mysql_query($updateSQL, $connect_db1) or die(mysql_error());

  $updateGoTo = "admin_login_success1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<?php require_once('Connections/connect_db1.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "admin_login_fail1.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "from_add1")) {
  $updateSQL = sprintf("UPDATE tw_symptom SET t_date=%s, t_symptom=%s, t_id=%s WHERE t_name=%s",
                       GetSQLValueString($_POST['t_date'], "text"),
                       GetSQLValueString($_POST['t_symptom'], "text"),
                       GetSQLValueString($_POST['t_id'], "text"),
                       GetSQLValueString($_POST['t_id'], "int"));

  mysql_select_db($database_connect_db1, $connect_db1);
  $Result1 = mysql_query($updateSQL, $connect_db1) or die(mysql_error());

  $updateGoTo = "admin_login_success1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_connect_db1, $connect_db1);
$query_R_symptom = "SELECT * FROM tw_symptom";
$R_symptom = mysql_query($query_R_symptom, $connect_db1) or die(mysql_error());
$row_R_symptom = mysql_fetch_assoc($R_symptom);
$totalRows_R_symptom = mysql_num_rows($R_symptom);

mysql_select_db($database_connect_db1, $connect_db1);
$query_Rs_member = "SELECT * FROM member";
$Rs_member = mysql_query($query_Rs_member, $connect_db1) or die(mysql_error());
$row_Rs_member = mysql_fetch_assoc($Rs_member);
$totalRows_Rs_member = mysql_num_rows($Rs_member);
?>
<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8">
<title>Salubrity</title>
<link href="jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
<script src="jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="jquery.mobile-1.0.min.js" type="text/javascript"></script>
</head> 
<body> 

<div data-role="page" id="page">
	<div data-role="header">
      <a href="index.php" class="ui-btn ui-icon-search ui-btn-icon-left">
	    <button data-icon="home" data-iconpos="left">หน้าแรก</button>
      </a>
  </div>
  <div data-role="content"> 
    <p>ตอนรับผู้ดูแลระบบ: <?php echo $row_Rs_member['name']; ?> <a href="index.php">ออกจากระบบ</a></p>
    <p><a href="admin_login_success1.php">กลับก่อนหน้านี้</a></p>
   
   <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="from_add1">
     <div data-role="fieldcontain">
       <label for="textinput">รหัส:</label>
        <input type="text" name="t_id" id="t_id" value="<?php echo $row_R_symptom['t_id']; ?>"  />
     </div>
     
    <div data-role="fieldcontain">
       <label for="textinput">ชื่อ:</label>
       <input type="text" name="t_name" id="t_name" value="<?php echo $row_R_symptom['t_name']; ?>"  />
     </div>
     
      <div data-role="fieldcontain">
       <label for="date">วันที่:</label>
       <input type="date" name="t_date" id="t_date" value="<?php echo $row_R_symptom['t_date']; ?>"  />
     </div>
     
      <div data-role="fieldcontain">
       <label for="textinput">อาการ:</label>
       <input type="text" name="t_symptom" id="t_symptom" value="<?php echo $row_R_symptom['t_symptom']; ?>"  />
     </div>
     
       
      <button data-icon="star">แก้ไข</button>
      <input name="id" type="hidden" value="<?php echo $row_R_symptom['t_id']; ?>" />
      <input type="hidden" name="MM_update" value="from_add1" />
   </form>
   
  
  </div>
    
</div>
 <div data-role="footer" data-position="fixed">
		<h4><strong>Salubrity</strong></h4>
	</div>
</div>

</body>
</html>
<?php
mysql_free_result($R_symptom);

mysql_free_result($Rs_member);
?>
