<?php 

	session_start();
	if (isset($_SESSION["user"])) {
		header("Location:index.php");
		exit;
	}
	include '../helper/functions.php';
	
	if (isset($_POST["submit"])){
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$cek_user = mysqli_query($conn,"SELECT * FROM user WHERE username  = '$username'");
		if (mysqli_num_rows($cek_user) > 0){
			$row = mysqli_fetch_assoc($cek_user);
			if (password_verify($password, $row['password'])) {
				$_SESSION['user'] = $_POST['user'];
				$_SESSION['hash'] = hash('sha255', $row['id'], false);
				if (hash('sha255',$row['id']) == $_SESSION['hash']) {
					header("Location:index.php");
					die;
				}
				header("Location:index.php");
				die;
			}
		}
		$error = true;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<style>
		body{
			margin: 0;
			padding: 0;
			font-size: 15px;
			background: url(../assets/img/bg.jpg);
			background-size: cover;
		}
		.login-box{
			width: 320px;
			height: 310px;
			color: #333;
			background-color: white;
			top: 50%;
			left: 50%;
			position: absolute;
			transform: translate(-50%,-50%);
			padding: 50px 30px;
			border-radius: 10px;
		}
		h1{
			margin-top: -10px;
			margin-bottom: 20px;
			text-align: center;
			font-weight: bold;
		}
		input{
			color: #333;
			display: block;
			border: none;
			border-bottom: 2px solid #00a9c6;
			outline: none;
			background: transparent;
			width: 100%;
		}
		input[type="text"]{
			margin-bottom: 20px;
		}
		button{
			margin-top: 20px;
			color: black;
			width: 100%;
			border: 1px solid #00a9c6;
			background-color: white;
			height: 40px;
			border-radius: 3px;
			font-size: 15px;
		}
		button:hover{
			background-color: #00a9c6;
			border: 1px solid #333;
			color: white;
			cursor: pointer;
			box-shadow: 0px 0px 5px white; 
		}
		.userpass{
			text-align: center;
			padding-top: -300px;
			margin-bottom: 30px;
		}
		p{
			color: black;
		}
	</style>
</head>
<body>
<div class="login-box">
	<h1>Login</h1>
	<p class="userpass">admin | admin</p>
	<form action="" method="POST">

		<label for="username">Username :</label>
		<input type="text" name="user" id="username"  autocomplete="off" autofocus>

		<label for="password">Password :</label>
		<input type="password" name="pass" id="password">
			<?php if (isset($error)) : ?>
				<p style="color: red; font-style: italic;">Username atau Password SALAH!</p>				
			<?php endif; ?>
		<button type="submit" name="submit">Login</button>
		<p align="center"><a href="../index.php" style="text-decoration: none;">kembali</a></p>
	</form>
</div>
</body>
</html>