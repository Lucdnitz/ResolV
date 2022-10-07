<?php
	session_start();
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
		<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		
	</head>
	<body>

		<?php include 'header.php';?>

		<section class="container-questao center-container">
			<section class="section-content-questao">
				<br />
				<h5 class="center"><b>Cadastrar questão</b></h5>
				<br />
				<form method="POST" action="">
					<p class="login-center"><b>Enunciado</b></p>
					<textarea id = "enunciado" class='login-center input-width materialize-textarea' name="enunciado"  maxlength="2000" required></textarea>
					<br><br>
					<input class="login-center" id="meuArquivo" type="file"/>
					<script>
						$(document).ready(function(){
   							 $("#meuArquivo").on('change',function(){
       								var arquivo = document.getElementById("meuArquivo").files[0];
								var reader = new FileReader();
								reader.onload = function (e) {
   									var textArea = document.getElementById("enunciado");
									textArea.value = e.target.result;
									};
								reader.readAsText(arquivo);
   						 });
						});
						
					</script>
					<p class="login-center"><b>Alternativas</b></p>
					<?php
                    for($i=1; $i<= 5; $i++){
                        echo "<textarea type='text' class='login-center input-width materialize-textarea' name='alternativa$i' placeholder='Alternativa $i' maxlength='200' required></textarea>
						<br /> <br />";
                    }
                    ?>
					<p class="login-center"><b>Resposta</b></p>
					<select class="browser-default login-center input-width" name="alternativaCorreta" required>
						<option value="-1" disabled selected>Escolha a alternativa correta</option>
						<?php 
                        for ($i = 1; $i <= 5; $i++) {
                           echo "<option value='$i'>Alternativa $i</option>";
                        }
                        ?>
					</select>
					<br /> 
					<p class="login-center"><b>Disciplina</b></p>
					<select name="disciplinas" class="browser-default login-center input-width" required>
						<option value="-1" disabled selected>Escolha a disciplina</option>
						<?php 
							$servername = "localhost";
							$username = "root";
							$password = "usbw";
							$database = "baseresolv";

							// Create connection
							$conn = mysqli_connect($servername, $username, $password,$database);
							mysqli_set_charset($conn,"utf8");
							$sql = "SELECT Nome FROM disciplina ORDER BY ID_Disciplina ASC;";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
								$disciplina = array();
								while($row = $result->fetch_assoc()) {
									$disciplina[] = $row["Nome"];
								}
							}

							$i = 1;
						?>
						<?php foreach ($disciplina as $nomeDisc) : ?>
							<option value="<?php echo $i; $i+=1;?>"><?php echo $nomeDisc ?></option>
						<?php endforeach ?>
					</select>
					<br />
					<p class="login-center"><b>Resolução</b></p>
					<textarea class="login-center input-width materialize-textarea" id="textarea1" name="resolucao" maxlength="2000" required></textarea>
					<br /><br />
					<p class="login-center"><b>Vestibular</b></p>
					<input type="text" class="login-center input-width" name="vestibular" maxlength="40" required>
					<p class="login-center"><b>Ano de criação</b></p>
					<input type="text" class="login-center input-width" name="ano" required>
					<br /><br />
					

					<button type="submit" class="login-center btn waves-effect waves-light">Enviar</button>
					<?php 
						if(isset($_SESSION['login']) && isset($_POST['enunciado']) && isset($_POST['alternativaCorreta']) && isset($_POST['disciplinas']) && is_numeric($_POST['ano'])
						&& filter_var($_POST['ano'], FILTER_VALIDATE_INT)){ //Aqui não foi necessário verificar mais de uma entrada do formulário
							$conn = mysqli_connect($servername, $username, $password,$database);
							mysqli_set_charset($conn,"utf8");

							$enunciado = filter_var($_POST['enunciado'], FILTER_SANITIZE_STRING);



							$sql = "SELECT * FROM questao WHERE Enunciado='$enunciado'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0){
								echo "<span><label>A questão já existe.</label></span>";
							}else{
								$a1=filter_var($_POST['alternativa1'], FILTER_SANITIZE_STRING);
								$a2=filter_var($_POST['alternativa2'], FILTER_SANITIZE_STRING);
								$a3=filter_var($_POST['alternativa3'], FILTER_SANITIZE_STRING);
								$a4=filter_var($_POST['alternativa4'], FILTER_SANITIZE_STRING);
								$a5=filter_var($_POST['alternativa5'], FILTER_SANITIZE_STRING);
								$disciplina=$_POST['disciplinas'];
								$ano = filter_var($_POST['ano'], FILTER_SANITIZE_NUMBER_INT);
								$vestibular=filter_var($_POST['vestibular'], FILTER_SANITIZE_STRING);
								$data = date('y-m-d');
								$resolucao = filter_var($_POST['resolucao'], FILTER_SANITIZE_STRING);
								$idUsuario = $_SESSION['idUsuarioSessao'];

								$sql = "SELECT ID_Questao FROM questao ORDER BY ID_Questao DESC LIMIT 1";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									$idQuestao = $result->fetch_assoc()['ID_Questao']+1;
								}else{
									$idQuestao = 1;
								}

								$sql = "SELECT ID_Alternativa FROM alternativa ORDER BY ID_Alternativa DESC LIMIT 1";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									$idAlt = $result->fetch_assoc()['ID_Alternativa'];
									$alternativaCertaId = $idAlt+$_POST['alternativaCorreta'];
								}else{
									$idAlt = 0;
									$alternativaCertaId = $idAlt+$_POST['alternativaCorreta'];
								}

								$sql = "SELECT ID FROM vestibular WHERE Nome='$vestibular'";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									$idVest = $result->fetch_assoc()['ID'];
								}else{
									$sql = "SELECT ID FROM vestibular ORDER BY ID DESC LIMIT 1";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
										$sql = "SELECT ID FROM vestibular ORDER BY ID DESC LIMIT 1";
										$result = $conn->query($sql);
										$idVest = $result->fetch_assoc()['ID']+1;
										$sql = "INSERT INTO vestibular(ID, Nome) VALUES ($idVest, '$vestibular')";
										$conn->query($sql);
										$conn->commit();
									}else{
										$sql = "INSERT INTO vestibular(ID, Nome) VALUES (1, '$vestibular')";
										$idVest=1;
										$conn->query($sql);
										$conn->commit();
									}
								}

								$sql = "INSERT INTO alternativa (ID_Alternativa, Valor) VALUES
									($idAlt+1, '$a1'),
									($idAlt+2, '$a2'),
									($idAlt+3, '$a3'),
									($idAlt+4, '$a4'),
									($idAlt+5, '$a5');";
								$conn->query($sql);
								$conn->commit();
								$sql = "INSERT INTO questao(ID_Questao, Enunciado, Solucao, Ano, Aprovada, fk_Disciplina_ID_Disciplina, fk_Usuario_ID_Usuario, dataCriada, fk_Alternativa_ID_Alternativa,fk_Vestibular_ID) VALUES
									('$idQuestao', '$enunciado','$resolucao',$ano,0,'$disciplina','$idUsuario','$data','$alternativaCertaId',$idVest);";
								$conn->query($sql);
								$conn->commit();
								$sql = "INSERT INTO possui (fk_Alternativa_ID_Alternativa, fk_Questao_ID_Questao) VALUES
									($idAlt+1, $idQuestao),
									($idAlt+2, $idQuestao),
									($idAlt+3, $idQuestao),
									($idAlt+4, $idQuestao),
									($idAlt+5, $idQuestao);";
								$conn->query($sql);
								$conn->commit();
								echo "<span><label>Questão registrada com sucesso.</label></span>";
								$conn->close();

							}

						}else if(isset($_SESSION['login'])==false){
							echo "<span><label>Você precisa estar logado para registrar uma questão.</label></span>";
						}else if(isset($_POST['enunciado'])){
							echo "<span><label>Faltou preencher algum dado ou algum dado foi preenchido incorretamente.</label></span>";
						}

				      ?>
				      <br /><br />
				</form>
			</section>
		</section>

		<script src="js/materialize.js"></script>
		<script src="js/init.js"></script>
		

	</body>
</html>
