<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset=utf-8>
	<title>登录</title>
</head>
<body background="../image/Garr_rush.jpg" style="background-repeat:no-repeat;
background-size:100% 100%;background-attachment: fixed;color:white
">	<!--插入背景图片,且自适应-->
<div style="text-align:center;font-size:2em">
<?php
	try{
		$pdo = new PDO("mysql:host=localhost;dbname=mysystem","root","");
		$pdo->query('set names utf8;');
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		die('sql链接失败'.$e->getMessage());
	}
	$sure = $_POST['name']&&$_POST['sex']&&$_POST['age']&&
	$_POST['sid']&&$_POST['phone']&&$_POST['password'];
	if ($sure) {	//确定所有信息均录入
		$file = $_FILES['headimage'];
		$fileName = $file['name'];
		move_uploaded_file($file['tmp_name'],$fileName);	//显示图片，未录入sql
		// $pdo->beginTransaction();	//开启事务
		$sid = $_POST['sid'];
		$sec_sid = "SELECT * FROM student WHERE sid = '$sid'";	// 定义SQL语句
		$stmt_sid = $pdo->prepare($sec_sid);	// prepare()方法准备查询语句
		$stmt_sid->execute();	// execute()方法执行查询语句，并返回结果集
		$num_sid = $stmt_sid->rowCount();	//显示行数
		$phone = $_POST['phone'];
		$sec_phone = "SELECT * FROM student WHERE phone = '$phone'";	// 定义SQL语句
		$stmt_phone = $pdo->prepare($sec_phone);	// prepare()方法准备查询语句
		$stmt_phone->execute();	// execute()方法执行查询语句，并返回结果集
		$num_phone = $stmt_phone->rowCount();	//显示行数
		if (!($num_sid || $num_phone)) {	//若查询不到相关信息则注册
			$name = $_POST['name'];
			$password = $_POST['password'];
			$sex = $_POST['sex'];
			$age = $_POST['age'];
		try{
			//开启事务
			$pdo->beginTransaction();
			$sql = "insert into student(id,name,sex,age,sid,phone,password) value(?,?,?,?,?,?,?)";
			$stmt = $pdo->prepare($sql);
			//传入参数
			$stmt->execute(array(null,$name,$sex,$age,$sid,$phone,$password));
			//提交事务
			$pdo->commit();
			echo '注册成功！';
		}catch(PDOException $e){
			die('执行失败'.$e->getMessage());
			$pdo->rollBack();	//回滚
			}

		}else{
			echo '该账号已注册，请核对后再进行操作';
		}
	}else{
		echo '请完善所有信息';
	}
?></div>

<div style="text-align:right;font-size:2em;color:white;">
<a href="../meta/signup.html" style="color:white">back</a>
</div>
</body>
</html>