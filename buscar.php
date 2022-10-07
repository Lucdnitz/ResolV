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
		<form action= "" method='POST' class = "row">

			<div class="input-field col s12 m3">
				<select name = "disciplinas[]" multiple>
					<option value="" disabled>Escolha as disciplinas</option>

					<?php 
						$servername = "localhost";
						$username = "root";
						$password = "usbw";
						$database = "baseresolv";

						// Create connection
						$conn = mysqli_connect($servername, $username, $password,$database);
						mysqli_set_charset($conn,"utf8");
						$sql = "SELECT * FROM disciplina ORDER BY ID_Disciplina ASC;";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								echo "<option value=\"{$row["ID_Disciplina"]}\"> {$row["Nome"]}</option>";
							}
						}
					?>


				</select>
			</div>
			<div class="input-field col s12 m3">
				<select name = "vestibulares[]" multiple>
					<option value="" disabled>Escolha os Vestibulares</option>

					<?php 
						// Create connection
						$conn = mysqli_connect($servername, $username, $password,$database);
						mysqli_set_charset($conn,"utf8");
						$sql = "SELECT * FROM Vestibular ORDER BY ID ASC;";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								echo "<option value=\"{$row["ID"]}\"> {$row["Nome"]}</option>";
							}
						}

					?>


				</select>
			</div>
			<div class="input-field col s6 m2">
				<label for="ano-comeco"> Escolha o ano inicial:</label>	
				<input name="ano-comeco" type="number" min="1900" max="2022" step="1" value="1900" />
			</div>

			<div class="input-field col s6 m2">
				<label for="ano-fim"> Escolha o ano final:</label>	
				<input name="ano-fim" type="number" min="1900" max="2022" step="1" value="2022" />
			</div>
			<div class="input-field col s12 m2">

				<textarea id="textarea1" name = "termo" class="materialize-textarea"></textarea>
				<label for="textarea1">Pesquisar:</label>
			</div>

			<div class="input-field col s12">
				<button class="btn waves-effect waves-light" type="submit" name="action">Buscar
					<i class="material-icons right">send</i>
				</button>
			</div>
		</form>

		<table>
			<thead>
				<th></th>
				<th> Enunciado </th> 
				<th> Disciplina </th>
				<th>Vestibular</th>
				<th>Ano</th>
				<?php
					$admin = array(1,2);
					if(isset($_SESSION['login']) && in_array($_SESSION['idUsuarioSessao'], $admin)){
						echo "<th>Editar</th>";
					}
				?>
			</thead>
			<tbody>
				<?php
							$servername = "localhost";
							$username = "root";
							$password = "usbw";
							$database = "baseresolv";

							// Create connection
							$conn = mysqli_connect($servername, $username, $password,$database);
							mysqli_set_charset($conn,"utf8");
						if(isset($_POST['action'])){
							$anoComeco = $_REQUEST["ano-comeco"];
							$anoFim = $_REQUEST["ano-fim"];
							$Enunciado = $_REQUEST["termo"];

							$sql = "SELECT Enunciado, ID_Questao, vestibular.nome 'Vestibular', disciplina.nome 'disciplina', disciplina.ID_Disciplina 'idDisc', Ano from questao inner join disciplina on (questao.fk_Disciplina_ID_Disciplina = disciplina.ID_Disciplina) inner join vestibular on (questao.fk_Vestibular_ID = vestibular.ID) where Enunciado like '%{$Enunciado}%' and questao.ano >= $anoComeco and questao.ano <= $anoFim and Aprovada = 1";

							if(isset($_REQUEST["vestibulares"])){
								$vestibulares =  "(".implode(",",$_REQUEST["vestibulares"]).")";
								$sql = $sql." and questao.fk_Vestibular_ID in $vestibulares";
							}
							if(isset($_REQUEST["disciplinas"])){
								$disciplinas =  "(".implode(",",$_REQUEST["disciplinas"]).")";
								$sql = $sql." and questao.fk_Disciplina_ID_Disciplina in $disciplinas";
							}
							$result = $conn->query($sql);
							if ($result and $result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo "
										<tr>
											<td> <button type='button' class='btn-floating waves-effect waves-light red' onclick=\"window.location='/questao.php?questao={$row["idDisc"]}&clicou=0&ID={$row["ID_Questao"]}'\"><i class='material-icons'>navigate_next</i></button>
											<td>
												{$row["Enunciado"]}
											</td>
											<td>
												{$row["disciplina"]}
											</td>
											<td>
												{$row["Vestibular"]}
											</td>
											<td>
												{$row["Ano"]}
											</td>
											";
									if(isset($_SESSION['login']) && in_array($_SESSION['idUsuarioSessao'], $admin)){
										echo "<td><button type='button' class='btn-floating waves-effect waves-light red' onclick=\"window.location='/editar_questao.php?ID={$row["ID_Questao"]}'\"><i class='material-icons'>edit</i></button></td>";
									}
									echo "</tr>";
								}
							}
						} else{

							$sql = "SELECT Enunciado, ID_Questao, vestibular.nome 'Vestibular', disciplina.nome 'disciplina', disciplina.ID_Disciplina 'idDisc', Ano from questao inner join disciplina on (questao.fk_Disciplina_ID_Disciplina = disciplina.ID_Disciplina) inner join vestibular on (questao.fk_Vestibular_ID = vestibular.ID) where aprovada=1;";
							$result = $conn->query($sql);
							if ($result and $result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo "
										<tr>
											<td> <button type='button' class='btn-floating waves-effect waves-light red' onclick=\"window.location='/questao.php?questao={$row["idDisc"]}&clicou=0&ID={$row["ID_Questao"]}'\"><i class='material-icons'>navigate_next</i></button>
											<td>
												{$row["Enunciado"]}
											</td>
											<td>
												{$row["disciplina"]}
											</td>
											<td>
												{$row["Vestibular"]}
											</td>
											<td>
												{$row["Ano"]}
											</td>
											";
									if(isset($_SESSION['login']) && in_array($_SESSION['idUsuarioSessao'], $admin)){
										echo "<td><button type='button' class='btn-floating waves-effect waves-light red' onclick=\"window.location='/editar_questao.php?ID={$row["ID_Questao"]}'\"><i class='material-icons'>edit</i></button></td>";
									}
									echo "</tr>";
								}
							}
						}
				?>
			</tbody>
		</table>

		<!--  Scripts-->
		<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="js/materialize.js"></script>
		<script src="js/init.js"></script>

	</body>
</html>
