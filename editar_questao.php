<?php
	session_start();
    $admin = array(1,2);
	if(!(in_array($_SESSION['idUsuarioSessao'], $admin))){
        Header("Location: index.php");
        die();
    }
    $servername = "localhost";
    $username = "root";
    $password = "usbw";
    $database = "baseresolv";
    if(isset($_POST['excluir'])){
        $conn = mysqli_connect($servername, $username, $password,$database);
		mysqli_set_charset($conn,"utf8");
        $idQuestao=$_REQUEST['ID'];

        $sql="SELECT ID_Alternativa
        FROM alternativa INNER JOIN possui ON possui.fk_Alternativa_ID_Alternativa=ID_Alternativa INNER JOIN questao ON questao.ID_Questao=possui.fk_Questao_ID_Questao
        WHERE questao.ID_Questao=$idQuestao";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $altApagar = array();
            while($row = $result->fetch_assoc()) {
                $altApagar[] = $row["ID_Alternativa"];
            }
        }
        $sql="DELETE FROM possui WHERE fk_Questao_ID_Questao=$idQuestao";
        $conn->query($sql);
        $sql="DELETE FROM questao WHERE ID_Questao=$idQuestao";
        $conn->query($sql);
        foreach($altApagar as $altIdApagar){
            $sql="DELETE FROM alternativa WHERE ID_Alternativa=$altIdApagar";
            $conn->query($sql);
        }
        $conn->commit();
        $vest = $_POST['vestibular'];
        $sql="SELECT ID FROM vestibular INNER JOIN questao ON questao.fk_Vestibular_ID=ID WHERE Nome='$vest'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $sql="DELETE FROM vestibular WHERE Nome='$vest'";
            $conn->query($sql);
        }
        $conn->commit();

        $sql='DELETE FROM realiza WHERE fk_Questao_ID_Questao IS NULL';
        $result = $conn->query($sql);
        $conn->commit();

        $sql='DELETE FROM edita WHERE fk_Questao_ID_Questao IS NULL';
        $result = $conn->query($sql);
        $conn->commit();
        $conn->close();
        Header("Location: buscar.php");
        die();
    }else if(isset($_POST['editar'])){
        $enunciado = filter_var($_POST['enunciado'], FILTER_SANITIZE_STRING);

        $alternativas = array();
        for($i=1;$i<=5;$i++){
            $alternativas[]=filter_var($_POST["alternativa".$i], FILTER_SANITIZE_STRING);
        }
		$disciplina=$_POST['disciplinas'];
		$ano = filter_var($_POST['ano'], FILTER_SANITIZE_NUMBER_INT);
		$vestibular=filter_var($_POST['vestibular'], FILTER_SANITIZE_STRING);
		$resolucao = filter_var($_POST['resolucao'], FILTER_SANITIZE_STRING);
        $idResp=($_REQUEST['ID']-1)*5+$_POST['alternativaCorreta'];

        $conn = mysqli_connect($servername, $username, $password,$database);
		mysqli_set_charset($conn,"utf8");
        $idQuestao=$_REQUEST['ID'];

        $sql = "SELECT * FROM questao WHERE Enunciado='$enunciado' AND NOT(Enunciado='{$_SESSION['enunciadoAntigo']}')";
		$result = $conn->query($sql);
		if ($result->num_rows == 0){		
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

            $sql="UPDATE questao SET Enunciado='$enunciado', fk_Disciplina_ID_Disciplina=$disciplina, Ano=$ano, Solucao='$resolucao', fk_Vestibular_ID=$idVest, fk_Alternativa_ID_Alternativa=$idResp WHERE ID_Questao=$idQuestao";
            $conn->query($sql);
            $conn->commit();

            $sql="SELECT ID FROM vestibular INNER JOIN questao ON questao.fk_Vestibular_ID=ID WHERE Nome='{$_SESSION['vestAntigo']}'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $sql="DELETE FROM vestibular WHERE Nome='{$_SESSION['vestAntigo']}'";
                $conn->query($sql);
            }


            for($i=1;$i<=5;$i++){
                $idAlternativa=($idQuestao-1)*5+$i;
                $sql="UPDATE alternativa SET Valor='{$alternativas[$i-1]}' WHERE ID_Alternativa=$idAlternativa";
                $conn->query($sql);
                $conn->commit();
            }
            $data = date('y-m-d');
            $sql="INSERT INTO edita(fk_Usuario_ID_Usuario, fk_Questao_ID_Questao, dataEditada) VALUES({$_SESSION['idUsuarioSessao']}, $idQuestao, '$data')";
            $conn->query($sql);
            $conn->commit();

            $conn->close();
            Header("Location: buscar.php");
            die();
        }
    }
        

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
        <section class="container-questao center-container">
			<section class="section-content-questao">
                <form method="POST" action="">


                    <?php
                        $conn = mysqli_connect($servername, $username, $password,$database);
						mysqli_set_charset($conn,"utf8");
                        $sql = "SELECT * FROM questao WHERE ID_Questao={$_REQUEST['ID']}";
                        $result = $conn->query($sql);
                        if ($result and $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $enunciado = $row['Enunciado'];
                            $resolucao = $row['Solucao'];
                            $ano = $row['Ano'];
                            $idDisciplina = $row['fk_Disciplina_ID_Disciplina'];
                            $idResposta = $row['fk_Alternativa_ID_Alternativa'];
                            $idVest = $row['fk_Vestibular_ID'];
                        }
                        $sql = "SELECT Nome FROM vestibular WHERE ID='$idVest'";
                        $result = $conn->query($sql);
                        $vest=$result->fetch_assoc()['Nome'];
                        $_SESSION['vestAntigo']=$vest;
                        $_SESSION['enunciadoAntigo']=$enunciado;

                        $sql = "SELECT Valor FROM alternativa 
                        INNER JOIN possui ON alternativa.ID_Alternativa = possui.fk_Alternativa_ID_Alternativa INNER JOIN questao ON questao.ID_Questao = possui.fk_Questao_ID_Questao
                        WHERE questao.ID_Questao = {$_REQUEST['ID']}
                        ORDER BY questao.ID_Questao ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $valores = array();
                            while($row = $result->fetch_assoc()) {
                                $valores[] = $row["Valor"];
                            }
                        }
                        $conn->close();
                    ?>

					<p class="login-center"><b>Enunciado</b></p>
					<textarea class="login-center input-width materialize-textarea" name="enunciado" maxlength='2000' required><?php echo $enunciado; ?></textarea>

					<p class="login-center"><b>Alternativas</b></p>
                    <?php
                    for($i=1; $i<= 5; $i++){
                        echo "<textarea type='text' class='login-center input-width materialize-textarea' name='alternativa$i' placeholder='Alternativa $i' maxlength='200' required>{$valores[$i-1]}</textarea>
                        <br /> <br />";
                    }
                    ?>
					<p class="login-center"><b>Resposta</b></p>
					<select class="browser-default login-center input-width" name="alternativaCorreta" required>
						<option value="-1" disabled>Escolha a alternativa correta</option>
                        <?php 
                        for ($i = 1; $i <= 5; $i++) {
                           echo "<option value='$i' ";
                           if($idResposta%5==$i){
                               echo "selected";
                            }
                           echo ">Alternativa $i</option>";
                        }
                        ?>

					</select>
					<br /> 
					<p class="login-center"><b>Disciplina</b></p>
					<select name="disciplinas" class="browser-default login-center input-width" required>
						<option value="-1" disabled>Escolha a disciplina</option>
						<?php 
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
                            $conn->close();
							$i = 1;
						?>
						<?php foreach ($disciplina as $nomeDisc) : ?>
							<option value="<?php echo $i;;?>" <?php if($idDisciplina==$i){echo "selected";} $i+=1;?>><?php echo $nomeDisc ?></option>
						<?php endforeach ?>
					</select>
					<br />
					<p class="login-center"><b>Resolução</b></p>
					<textarea class="login-center input-width materialize-textarea" name="resolucao" required maxlength='2000'><?php echo $resolucao; ?></textarea>
					<br /><br />
					<p class="login-center"><b>Vestibular</b></p>
					<input type="text" class="login-center input-width" name="vestibular" value="<?php echo $vest ?>" maxlength='40' required>
					<p class="login-center"><b>Ano de criação</b></p>
					<input type="text" class="login-center input-width" name="ano" value="<?php echo $ano;?>" required>
					<br /><br />

					<button type="submit" class="login-center btn waves-effect waves-light" name="editar" >Editar</button>
                    <button type="submit" class="btn waves-effect waves-light red" name="excluir" >Excluir</button>
                    <?php
                    $conn = mysqli_connect($servername, $username, $password,$database);
                    mysqli_set_charset($conn,"utf8");
                    if(isset($_POST['editar'])){
                        $idQuestao=$_REQUEST['ID'];
                        $sql = "SELECT * FROM questao WHERE Enunciado='$enunciado'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0){
                            echo "<span><label>A questão já existe.</label></span>";
                        }
                    }
                    $conn->close();
                    ?>
                </form>
            </section>
        </section>



    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="js/materialize.js"></script>
	<script src="js/init.js"></script>
    </body>
</html>