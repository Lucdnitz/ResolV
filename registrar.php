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
		    <h5 class="center"><b>Cadastrar</b></h5>
					<br />
		    <form method="POST" action="">

			<p class="login-center"><b>Nome completo</b></p>
			<input type="text" class="login-center input-width" name="nome" required>

			<p class="login-center"><b>Apelido</b></p>
			<input type="text" class="login-center input-width" name="apelido" required>

			<p class="login-center"><b>E-mail</b></p>
			<input type="text" class="login-center input-width" name="email" required>

			<p class="login-center"><b>Senha</b></p>
			<input type="password" class="login-center input-width" name="senha" required>

			<br /> <br />
			<button type="submit" class="login-center btn waves-effect waves-light">Registrar</button>
<?php 
if(isset($_POST['apelido'])){
	$servername = "localhost";
	$username = "root";
	$password = "usbw";
	$database = "baseresolv";


	$apelido = filter_var($_POST['apelido'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$senha = filter_var($_POST['senha'], FILTER_SANITIZE_STRING);
	$nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
	// Create connection
	$conn = mysqli_connect($servername, $username, $password,$database);
	mysqli_set_charset($conn,"utf8");
	$sql = "SELECT * FROM usuario WHERE Apelido='$apelido' OR Email='$email'";
	$result = $conn->query($sql);

	if ($result->num_rows == 0){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //Não foi necessária a utilização de outro filtro.
			$sql = "SELECT * FROM usuario ORDER BY ID_Usuario DESC LIMIT 1";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$idUsuario=$row['ID_Usuario']+1;
				}
			}else{
				$idUsuario = 1;
			}
			$hash = password_hash($senha, PASSWORD_DEFAULT);
			$sql = "INSERT INTO usuario(Nome, Email, Apelido, Senha, ID_Usuario) VALUES ('$nome', '$email', '$apelido', '$hash', $idUsuario);";
			$result = $conn->query($sql);
			$conn->commit();
			echo "<label><span>Conta criada com sucesso.</span></label>";
		}else{
			echo "<label><span>Foi preenchido algum dado incorretamente.</span></label>";
		}
	}else{
		echo "<label><span>Foi colocado um email ou apelido existente.</span></label>";
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
