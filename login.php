<?php
session_start()
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>ResolV</title>

		<!-- CSS  -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	</head>
	<body>

		<?php include 'header.php';?>

		<section class="container center-container">
	    <section class="section_content">
		    <h5 class="center"><b>Login</b></h5>
					<br />
		    <form method="POST" action="">
			<p class="login-center"><b>Apelido</b></p>
			<input type="text" class="login-center input-width" name="apelido" required>

			<p class="login-center"><b>Senha</b></p>
			<input type="password" class="login-center input-width" name="senha" required>

			<br /> <br />

			<button type="submit" class="login-center btn waves-effect waves-light">Entrar</button>
<?php
if(isset($_POST['apelido'])){
	$servername = "localhost";
	$username = "root";
	$password = "usbw";
	$database = "baseresolv";

	$senha = filter_var($_POST['senha'], FILTER_SANITIZE_STRING);
	$apelido = filter_var($_POST['apelido'], FILTER_SANITIZE_STRING);
	// Create connection
	$conn = mysqli_connect($servername, $username, $password,$database);
	mysqli_set_charset($conn,"utf8");
	$sql = "SELECT ID_Usuario,Senha FROM usuario WHERE Apelido='$apelido';";
	$result = $conn->query($sql);
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		if ( password_verify($senha, $row['Senha'])){
			$_SESSION['login']=True;
			$_SESSION['idUsuarioSessao']=$row['ID_Usuario'];
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'index.php';
			header("Location: http://$host$uri/$extra");
			exit;
		}
		else{
			echo "<span><label>Foram inseridos dados incorretos.</label></span>";
		}
	}else{
		echo "<span><label>Foram inseridos dados incorretos.</label></span>";
	}
	$conn->close();
}
?>
						<br /><br />
		    </form>
	    </section>
	</section>


		<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="js/materialize.js"></script>
		<script src="js/init.js"></script>

	</body>
</html>
