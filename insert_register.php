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
    <p>
      <?
if($_POST['name']!='' and $_POST['username']!='' and $_POST['password']!='' and $_POST['mail']!='' and $_POST['tel']!=''){
	include ('connect.php'); //เรียกใช้ไฟล์ connect เพื่อใช้ในการติดต่อฐานข้อมูล
	
	$sql='SELECT * FROM  `member` WHERE  `user` =  "'.$_POST["username"].'"';
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>=1){
		echo 'ชือผู้ใช้งานนี้มีคนใช้งานแล้ว'.'</br>';
		echo '<a href="from_register.php">กลับไปหน้าสมัครสมาชิก</a>';
		}
	else{
		$sql1="INSERT INTO member values ('','".$_POST['name']."','".$_POST['username']."','".$_POST['password']."','".$_POST['mail']."','".$_POST['tel']."')";
		$query1=mysql_query($sql);
		
		  if($query){
			echo 'บันทึกข้อมูลเรียบร้อยแล้ว'.'</br>';
			echo '<a href="admin_login1.php">ไปหน้าlogin</a>';
			}
			else {
				echo 'บันทึกข้อมูลไม่สำเร็จ'.'</br>';
		        echo '<a href="from_register.php">กลับไปหน้าสมัครสมาชิก</a>';
				}
		}	
	}
else{
	echo 'กรุณากรอกข้อมูลให้ครบ'.'</br>';
	echo '<a href="from_register.php">กลับไปหน้าสมัครสมาชิก</a>';
	
	}
?>
  </div>

<div data-role="footer" data-position="fixed">
		<h4><strong>Salubrity</strong></h4>
  </div>
</div>



</body>
</html>