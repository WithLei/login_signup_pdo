<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset=utf-8>
	<title>登录</title>
</head>
<body background="../image/Garr_rush.jpg" style="background-repeat:no-repeat;
background-size:100% 100%;background-attachment: fixed;color:white
">	<!--插入背景图片,且自适应-->

<div style="text-align:center;font-size:2em;color:white;">
<?php
	try{
		$pdo = new PDO("mysql:host=localhost;dbname=mysystem","root","");
		$pdo->query('set names utf8;');
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		die("sql连接失败".$e->getMessage());
	}
	
		if ($_POST['password']&&$_POST['sid']) {
		$sid = $_POST['sid'];
		$sec = "SELECT * FROM student WHERE sid = '$sid'";	// 定义SQL语句
		$stmt = $pdo->prepare($sec);	// prepare()方法准备查询语句
		$stmt->execute();	// execute()方法执行查询语句，并返回结果集
		$num = $stmt->rowCount();	//显示行数
		if ($num) {	//用户存在
			$row = $stmt->fetch(PDO::FETCH_ASSOC);	//获取数组
			if ($_POST['password']==$row['password']) {
				echo '登陆成功';
			}else{
				echo '请核对密码再次输入';
			}
		}else{
			echo '请核对账户名';
		}
		}else{
			echo'请输入账号密码';
		}

?>
</div>

<div style="text-align:right;font-size:2em;color:white;">
<a href="../meta/login.html" style="color:white">back</a>
</div>

</body>
</html>