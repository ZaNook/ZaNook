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

if ((isset($_GET['t_id'])) && ($_GET['t_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM tw_symptom WHERE id=%s",
                       GetSQLValueString($_GET['t_id'], "int"));

  mysql_select_db($database_connect_db1, $connect_db1);
  $Result1 = mysql_query($deleteSQL, $connect_db1) or die(mysql_error());

  $deleteGoTo = "admin_login_success1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}


mysql_select_db($database_connect_db1, $connect_db1);
$query_R_symptom = "SELECT * FROM tw_symptom";
$R_symptom = mysql_query($query_R_symptom, $connect_db1) or die(mysql_error());
$row_R_symptom = mysql_fetch_assoc($R_symptom);
$totalRows_R_symptom = mysql_num_rows($R_symptom);

mysql_select_db($database_connect_db1, $connect_db1);
$query_R_member = "SELECT * FROM member";
$R_member = mysql_query($query_R_member, $connect_db1) or die(mysql_error());
$row_R_member = mysql_fetch_assoc($R_member);
$totalRows_R_member = mysql_num_rows($R_member);
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
<div data-role="header"><h1><img src="images/q1.png" width="300" height="100">   </h1>
	<div data-role="header">
      <a href="index.php" class="ui-btn ui-icon-search ui-btn-icon-left">
	    <button data-icon="home" data-iconpos="left">หน้าแรก</button>
      </a>
  </div>
  </div>  <div data-role="content"> ตอนรับผู้ใช้งาน: <?php echo $row_R_member['name']; ?> <a href="index.php">ออกจากระบบ</a>
<div data-role="collapsible-set">
      <div data-role="collapsible">
        <h3>ข้อมูลสมชิก</h3>
        <div align="center">
          <table width="80%" border="1">
            <tr>
              <td bgcolor="#0000FF"><div align="center" class="s"><strong>รหัส</strong></div></td>
              <td bgcolor="#0000FF"><div align="center" class="s"><strong>ชื่อ</strong></div></td>
              <td bgcolor="#0000FF"><div align="center" class="s"><strong>อีเมล์</strong></div></td>
              <td bgcolor="#0000FF"><div align="center" class="s"><strong>เบอร์โทร</strong></div></td>
            </tr>
            <?php do { ?>
            <tr>
              <td bgcolor="#CCFFCC"><div align="center"><?php echo $row_R_member['id']; ?></div></td>
              <td bgcolor="#CCFFCC"><div align="center"><?php echo $row_R_member['name']; ?></div></td>
              <td bgcolor="#CCFFCC"><div align="center"><?php echo $row_R_member['mail']; ?></div></td>
              <td bgcolor="#CCFFCC"><div align="center"><?php echo $row_R_member['tel']; ?></div></td>
            </tr>
            <?php } while ($row_R_member = mysql_fetch_assoc($R_member)); ?>
          </table>
        </div>
        <p>&nbsp;</p>
      </div>
    <div data-role="collapsible" data-collapsed="true">
        <h3>ข้อมูลอาการ</h3>
        <p><a href="admin_station_add1.php">เพิ่มข้อมูล</a></p>
      <p>
        
<table border="1" align="center">
        <tr>
           
          <td bgcolor="#0000FF"><div align="center" class="a"><strong>รหัส</strong></div></td>
          <td bgcolor="#0000FF"><div align="center" class="a"><strong>ชื่อ</strong></div></td>
          <td bgcolor="#0000FF"><div align="center" class="a"><strong>วันที่</strong></div></td>
          <td bgcolor="#0000FF"><div align="center" class="a"><strong>อาการ</strong></div></td>
            
        </tr>
        <?php do { ?>
          <tr>
            <td bgcolor="#CCFFCC"><div align="center"><?php echo $row_R_symptom['t_id']; ?></div></td>
            <td bgcolor="#CCFFCC"><div align="center"><?php echo $row_R_symptom['t_name']; ?></div></td>
            <td bgcolor="#CCFFCC"><div align="center"><?php echo $row_R_symptom['t_date']; ?></div></td>                     
            <td bgcolor="#CCFFCC"><div align="center"><?php echo $row_R_symptom['t_symptom']; ?></div></td>
              
          </tr>
          <?php } while ($row_R_symptom = mysql_fetch_assoc($R_symptom)); ?>
      </table>&nbsp;
      </p>
        
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

mysql_free_result($R_member);
?>
