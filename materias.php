<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">
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
		<h2 class = "center">
			Escolha uma matéria
		</h2>

		<div class="container">
			<div class="section">

				<div class="row">
					<a href = "questao.php?questao=1&clicou=0">
					<div class="card col s12 m4">
						<div class="icon-block">
							<h2 class="center brown-text"><i class="material-icons">calculate</i></h2>
							<h5 class="center black-text"> Matemática</h5>

						</div>
					</div>
					</a>

					<a href = "questao.php?questao=2&clicou=0">
					<div class="card col s12 m4">
						<div class="icon-block">
							<h2 class="center brown-text"><i class="material-icons">precision_manufacturing</i></h2>
							<h5 class="center black-text">Física</h5>
						</div>
					</div>
					</a>

					<a href = "questao.php?questao=3&clicou=0">
					<div class="card col s12 m4">
						<div class="icon-block">
							<h2 class="center brown-text"><i class="material-icons">menu_book</i></h2>
							<h5 class="center black-text">Português</h5>

						</div>
					</div>
					</a>
					<a href = "questao.php?questao=4&clicou=0">
					<div class="card col s12 m4">
						<div class="icon-block">
							<h2 class="center brown-text"><i class="material-icons">science</i></h2>
							<h5 class="center black-text">Química</h5>

						</div>
					</div>
					</a>
					<a href = "questao.php?questao=5&clicou=0">
					<div class="card col s12 m4">
						<div class="icon-block">
							<h2 class="center brown-text"><i class="material-icons">biotech</i></h2>
							<h5 class="center black-text">Biologia</h5>

						</div>
					</div>
					</a>
					<a href = "questao.php?questao=6&clicou=0">
					<div class="card col s12 m4">
						<div class="icon-block">
							<h2 class="center brown-text"><i class="material-icons">psychology</i></h2>
							<h5 class="center black-text">Filosofia</h5>

						</div>
					</div>
					</a>
				</div>

			</div>
		</div>


		<!--  Scripts-->
		<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="js/materialize.js"></script>
		<script src="js/init.js"></script>

	</body>
</html>
