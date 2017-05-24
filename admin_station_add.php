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

$MM_restrictGoTo = "admin_login_fail.php";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "from_add")) {
  $insertSQL = sprintf("INSERT INTO member (id, name, user, pass, mail, tel) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['mail'], "text"),
                       GetSQLValueString($_POST['tel'], "text"));

  mysql_select_db($database_connect_db1, $connect_db1);
  $Result1 = mysql_query($insertSQL, $connect_db1) or die(mysql_error());

  $insertGoTo = "admin_login_success.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Rs_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Rs_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_connect_db1, $connect_db1);
$query_Rs_admin = sprintf("SELECT * FROM tw_admin WHERE admin_user = %s", GetSQLValueString($colname_Rs_admin, "text"));
$Rs_admin = mysql_query($query_Rs_admin, $connect_db1) or die(mysql_error());
$row_Rs_admin = mysql_fetch_assoc($Rs_admin);
$totalRows_Rs_admin = mysql_num_rows($Rs_admin);

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
<div data-role="header"><h1><img src="images/q1.png" width="300" height="100">   </h1>
	<div data-role="header">
      <a href="index.php" class="ui-btn ui-icon-search ui-btn-icon-left">
	    <button data-icon="home" data-iconpos="left">หน้าแรก</button>
      </a>
      </div>
  </div>
  <div data-role="content"> 
    <p>ตอนรับผู้ดูแลระบบ: <?php echo $row_Rs_admin['admin_fullname']; ?> <a href="index.php">ออกจากระบบ</a></p>
    <p><a href="admin_login_success.php">กลับก่อนหน้านี้</a></p>
   
   <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="from_add">
     <div data-role="fieldcontain">
       <label for="textinput">รหัส:</label>
       <input type="text" name="id" id="id" value=""  />
     </div>
     
     <div data-role="fieldcontain">
       <label for="textinput">ชื่อ:</label>
       <input type="text" name="name" id="name" value=""  />
     </div>
     
      <div data-role="fieldcontain">
       <label for="textinput">Username:</label>
       <input type="text" name="user" id="user" value=""  />
     </div>
     
      <div data-role="fieldcontain">
       <label for="textinput">Password:</label>
       <input type="text" name="pass" id="pass" value=""  />
     </div>
     
       <div data-role="fieldcontain">
       <label for="textinput">E-mail:</label>
       <input type="text" name="mail" id="mail" value=""  />
     </div>
   
      <div data-role="fieldcontain">
       <label for="textinput">เบอร์โทร:</label>
       <input type="text" name="tel" id="tel" value=""  />
     </div>
      
      <button data-icon="star">เพิ่มข้อมูล</button>
      <input type="hidden" name="MM_insert" value="from_add" />
      
     
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
mysql_free_result($Rs_admin);

mysql_free_result($Rs_member);
?>
