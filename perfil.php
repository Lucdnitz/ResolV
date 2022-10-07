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
		<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	</head>
	<body>

		<?php include 'header.php';?>
		<main>
			<div class = "container grey lighten-4">
<?php
$servername = "localhost";
$username = "root";
$password = "usbw";
$database = "baseresolv";
$conn = mysqli_connect($servername, $username, $password,$database);
mysqli_set_charset($conn,"utf8");
$idUser = $_SESSION['idUsuarioSessao'];
$sql = 'SELECT usuario.Nome "Nome", usuario.Email "Email", usuario.Apelido "Apelido" from usuario WHERE usuario.ID_Usuario = '.$idUser.' GROUP BY usuario.ID_Usuario;';
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$apelido = $row["Apelido"];
$nome = $row["Nome"];
$email = $row["Email"];
echo "<h2> $apelido </h2>";
echo "<h4> Nome: $nome </h4>";
echo "<h4> Email: $email </h4>";
$sql = 'SELECT COUNT(realiza.dataRealizada) "qFeita" FROM usuario left join realiza ON (realiza.fk_Usuario_ID_Usuario = usuario.ID_Usuario) WHERE usuario.ID_Usuario ='. $idUser .' GROUP BY usuario.ID_Usuario;';
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$quantidade = (int) $row["qFeita"];
echo "<h4> Quantidade de questões realizadas: {$quantidade}</h4>";
$sql = 'SELECT COUNT(realiza.dataRealizada) "qAcerto" FROM usuario left join realiza ON (realiza.fk_Usuario_ID_Usuario = usuario.ID_Usuario) WHERE usuario.ID_Usuario ='. $idUser .' AND realiza.Acertou = 1 GROUP BY usuario.ID_Usuario;';
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$quantidadeAcertos = (int) $row["qAcerto"];
echo "<h4> Taxa de acertos: ". (int) ($quantidadeAcertos*100/$quantidade) . "%</h4>";
?>
			</div>
		</main>




		<!--  Scripts-->
		<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="js/materialize.js"></script>
		<script src="js/init.js"></script>

	</body>
</html>
