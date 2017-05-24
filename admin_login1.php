<?php require_once('Connections/connect_db1.php'); ?>
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
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin_login_success1.php";
  $MM_redirectLoginFailed = "admin_login_fail1.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connect_db1, $connect_db1);
  
  $LoginRS__query=sprintf("SELECT user, pass FROM member WHERE user=%s AND pass=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connect_db1) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
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
		<h1>ลงชื่อเข้าใช้</h1>
	</div>
    

  <div data-role="content">
    <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
    <h2>ผู้ใช้งานเข้าสู่ระบบ</h2>
      
<div data-role="fieldcontain">
  <label for="textinput">User Name:</label>
  <input type="text" name="username" id="username" value=""  />
</div>
<div data-role="fieldcontain">
  <label for="passwordinput">Password :</label>
  <input type="password" name="password" id="password" value=""  />
</div>
<button data-icon="star" data-iconpos="left">เข้าสู่ระบบ</button>

    </form>
    
  </div>
<div data-role="footer" data-position="fixed">
		<h4><strong>Salubrity</strong></h4>
	</div>
</div>



</body>
</html>