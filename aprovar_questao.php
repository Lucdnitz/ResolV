<?php
	session_start();
    $admin = array(1,2);
	if(!(in_array($_SESSION['idUsuarioSessao'], $admin))){
        Header("Location: index.php");
        die();
    }
?>
  
 
 <!DOCTYPE html>
  <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>ResolV</title>

	<!-- CSS  -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/form.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    </head>

    <body>
    <?php include 'header.php';?>
		<?php
		$servername = "localhost";
		$username = "root";
		$password = "usbw";
		$database = "baseresolv";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password,$database);
		mysqli_set_charset($conn,"utf8");

        if(isset($_POST['aprovacao']) &&  $_SESSION['apResultados']==True){
            if($_POST['aprovacao']==1){
                $idQuestao=$_SESSION['apIdQuestao'];
                $sql="UPDATE questao SET aprovada=1 WHERE ID_Questao=$idQuestao";
                $conn->query($sql);
                $conn->commit();
                $_SESSION['apResultados']=False;
            }else{
                $idQuestao=$_SESSION['apIdQuestao'];
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
                $nomeVest=$_SESSION['apVest'];
                $sql="SELECT ID FROM vestibular INNER JOIN questao ON questao.fk_Vestibular_ID=ID WHERE Nome='$nomeVest'";
                $result = $conn->query($sql);
                if ($result->num_rows == 0) {
                    $sql="DELETE FROM vestibular WHERE Nome='$nomeVest'";
                    $conn->query($sql);
                }
                $_SESSION['apResultados']=False;
                $conn->commit();
            }
        }


		$sql = "SELECT * FROM questao WHERE Aprovada=0 ORDER BY ID_Questao ASC LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$_SESSION['apEnunciado'] = $row["Enunciado"];
				$_SESSION['apAno'] = $row["Ano"];
				$_SESSION['apIdQuestao'] = $row["ID_Questao"];
                $idVest=$row["fk_Vestibular_ID"];
			}
            $sql = "SELECT Nome FROM vestibular WHERE ID='$idVest'";
		    $result = $conn->query($sql);
            $_SESSION['apVest']=$result->fetch_assoc()['Nome'];
			$_SESSION['apResultados'] = True;
			$idQuestao = $_SESSION['apIdQuestao'];
			$sql = "SELECT Nome FROM disciplina INNER JOIN questao ON questao.fk_Disciplina_ID_Disciplina=disciplina.ID_Disciplina
			WHERE questao.ID_Questao=$idQuestao";
			$result = $conn->query($sql);
            $_SESSION['apMateria']=$result->fetch_assoc()['Nome'];
		} else {
			$_SESSION['apResultados']=False;
		}
		

?>

	<section class="container center-container">
	    <section class="section_content">
	    <p><b><?php 
		if($_SESSION['apResultados']==True){ #Verifica se foi encontrado alguma questão
			echo $_SESSION['apMateria']." - (".$_SESSION['apVest']." - ".$_SESSION['apAno'].") ".$_SESSION['apEnunciado'];
		}else{
			echo "Não foi possível achar nenhuma questão.";
		}
        ?></b></p>
			<br />

			<form method="POST" action="">
<?php
		if($_SESSION['apResultados']){ #Verifica os resultados das alternativas, caso tenha achado alguma questão
			$sql = "SELECT Valor FROM alternativa 
				INNER JOIN possui ON alternativa.ID_Alternativa = possui.fk_Alternativa_ID_Alternativa INNER JOIN questao ON questao.ID_Questao = possui.fk_Questao_ID_Questao
				WHERE questao.ID_Questao = $idQuestao
				ORDER BY RAND()";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				$valores = array();
				while($row = $result->fetch_assoc()) {
					$valores[] = $row["Valor"];
				}
				$_SESSION['apAlternativas'] = $valores;
				$_SESSION['apResultados']=True;
			} else {
				$_SESSION['apResultados']=False;
			}
		}else{
			if(isset($_SESSION['apAlternativas'])){
				$valores=$_SESSION['apAlternativas'];
			}else{
				$valores=array(0,0,0,0,0);
			}
			
		}
		$conn->close();

?>

<?php 
		if($_SESSION['apResultados']){ #Encontra a alternativa certa, caso tenha encontrado as alternativas
			$conn = mysqli_connect($servername, $username, $password,$database); #conecta de novo ao banco de dados
			mysqli_set_charset($conn,"utf8");
			$sql = "SELECT Valor FROM alternativa
				INNER JOIN possui ON alternativa.ID_Alternativa = possui.fk_Alternativa_ID_Alternativa INNER JOIN questao ON questao.ID_Questao = possui.fk_Questao_ID_Questao
				WHERE ID_Alternativa = questao.fk_Alternativa_ID_Alternativa AND questao.ID_questao = $idQuestao"; #pega a alternativa correta
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$resposta = $row["Valor"];
				}
			}
			$conn->close();
		}
?>

			<?php foreach ($valores as $valor) : ?>

<?php
		if($_SESSION['apResultados']){ #Construção das alternativas
				if($valor==$resposta){
					echo "<p class='acertou'>";
				}else{
                    echo "<p>";
                }
			}else{
                echo "<p>";
            }
		
?>
				<label>
				<input type="radio" name="alternativas" id="resposta_<?php if($_SESSION['apResultados']){echo $valor;} ?>" value="<?php if($_SESSION['apResultados']){echo $valor;} ?>" >
                <span><?php if($_SESSION['apResultados']){echo $valor;} ?></span>
			    </label>
			</p>
			<?php endforeach ?>

<?php
		if($_SESSION['apResultados']){ #Coloca a solução da questão caso o usuário tenha clicado em enviar
			echo "<p><b>Resolução:</b></p><br />";
			$conn = mysqli_connect($servername, $username, $password,$database); #conecta de novo ao banco de dados
			mysqli_set_charset($conn,"utf8");
			$sql = "SELECT Solucao FROM questao WHERE ID_Questao = $idQuestao";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$resolucao = $row["Solucao"];
				}
			}
			echo $resolucao."<br /><br />";
			$conn->close();
		}
?>

	<button type="submit" class="btn waves-effect waves-light" name="aprovacao" value="1">Aprovar</button>
    <button type="submit" class="btn waves-effect waves-light" name="aprovacao" value="0">Reprovar</button>
		</form>


	    </section>
	</section>
      <!--JavaScript at end of body for optimized loading-->
      <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
    </body>
  </html>

