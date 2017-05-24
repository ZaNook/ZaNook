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
      <a href="index.html" class="ui-btn ui-icon-search ui-btn-icon-left">
	    <button data-icon="home" data-iconpos="left">หน้าแรก</button>
      </a>
	  </div>
	  
	  <?
$host='localhost';
$user='root';
$pass='root';
$db_name='db1';
mysql_connect($host,$user,$pass)or die ('ติดต่อฐานข้อมูลไม่ได้');
mysql_select_db($db_name)or die ('ไม่พบฐานข้อมูล');
mysql_query('SET NAMES UTF8');
?>
</body>
</html>