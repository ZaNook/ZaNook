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
		<h1>สมัครสมาชิก</h1>
	</div>
<div data-role="content">

<form method="POST" action="insert_register.php">
<table width="43%" border="0" align="center">
  <tr>
    <td width="38%"><div align="right">ชื่อ-นามสกุล :</div></td>
    <td width="62%"><input name="name"/></td>
  </tr>
  <tr>
    <td><div align="right">username 
      :</div></td>
    <td><input name="username" /></td>
  </tr>
  <tr>
    <td><div align="right">password : </div></td>
    <td><input name="password" type="password"/></td>
  </tr>
  <tr>
    <td><div align="right">e-mail :</div></td>
    <td><input name="mail" /></td>
  </tr>
  <tr>
    <td><div align="right">เบอร์โทร :</div></td>
    <td><input name="tel" /></td>
  </tr>
  <tr>
  </table>
  <div align="center">
    <table>
      <td height="30"><div align="right">
        <input name="submit" type="submit" value="สมัครสมาชิก"  />
        </div></td>
        <td><div align="center">
          <input name="reset" type="reset" value="ยกเลิก"  />
          </div></td>
        </tr>
    </table>
  </div>
</form>
	
<div data-role="footer" data-position="fixed">
		<h4><strong>Salubrity</strong></h4>
	</div>
</div>



</body>
</html>