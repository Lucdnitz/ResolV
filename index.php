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

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
	<br><br>
	<h1 class="header center teal-text text-lighten-2">ResolV</h1>
	<div class="row center">
	  <h5 class="header col s12 light">O site de estudos perfeito para você</h5>
	</div>
	<div class="row center">
	  <a href="materias.php" id="fazer-questao-botao" class="btn-large waves-effect waves-light teal lighten-1">Fazer questões</a>
	</div>
	<br><br>

      </div>
    </div>
    <div class="parallax"><img src="images/background1.jpg" alt="Unsplashed background img 1"></div>
  </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
	<div class="col s12 m4">
	  <div class="icon-block">
	    <h2 class="center brown-text"><i class="material-icons">flash_on</i></h2>
	    <h5 class="center">Eficiência</h5>

	    <p class="light justify">Com o ResolV você terá a rapidez de encontrar uma variedade de questões em um clique.</p>
	  </div>
	</div>

	<div class="col s12 m4">
	  <div class="icon-block">
	    <h2 class="center brown-text"><i class="material-icons">group</i></h2>
	    <h5 class="center">Comunidade</h5>

	    <p class="light justify">O tamanho do banco de dados é realizado pela comunidade do Resolv, portanto, caso tenha alguma questão, envie para nós!</p>
	  </div>
	</div>

	<div class="col s12 m4">
	  <div class="icon-block">
	    <h2 class="center brown-text"><i class="material-icons">settings</i></h2>
	    <h5 class="center">Sem burocracia</h5>

	    <p class="light justify">Nós da ResolV, realizamos esse site no intuito de fazê-lo sem nenhuma burocracia e totalmente gratuito!</p>
	  </div>
	</div>
      </div>

    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
	<div class="row center">
	  <h5 class="header col s12 light">Realização de questões em um clique</h5>
	</div>
      </div>
    </div>
    <div class="parallax"><img src="images/background2.jpg" alt="Unsplashed background img 2"></div>
  </div>

  <div class="container">
    <div class="section">

      <div class="row">
	<div class="col s12 center">
	  <h3><i class="mdi-content-send brown-text"></i></h3>
	  <h4>Nos contate</h4>
	  <p class="left-align light justify">Nos contate através do seguinte e-mail: suporte@resolv.com</p>
	</div>
      </div>

    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
	<div class="row center">
	  <h5 class="header col s12 light">O único site de estudos sem nenhuma burocracia e totalmente gratuito</h5>
	</div>
      </div>
    </div>
    <div class="parallax"><img src="images/background3.jpg" alt="Unsplashed background img 3"></div>
  </div>

  <footer class="page-footer teal">
	<div class="container row">
	  <h5 class="white-text">Sobre nós</h5>
	  <p class="justify">Na realidade estudantil, muitos alunos de baixa renda se encontram numa situação de falta de acesso a questões. Assim sendo, muitos buscam bancos de questões, que por sua vez são pagos, limitados ou burocráticos. Surge o ResolV entendendo a realidade social e de distribuição de renda no Brasil, onde, segundo a Unicef, em 2020, 5,5 milhões de brasileiros ficaram sem acesso à educação, somado aos outros vários problemas que afetam esse sistema (trabalho infantil, fuga das escolas, etc). O projeto é uma iniciativa sem fins lucrativos que visa apoiar essa problemática social de uma forma intuitiva, direta e sem burocracia. Inúmeras vezes o estudante necessita da resolução de alguma questão, mas para acessá-la, necessita de fazer login, nessa perspectiva, o ResolV proporciona conexão às atividades sem precisar e cadastro. Mesmo assim, há um sistema de matrícula com senha para salvar suas resoluções, simulados, cadastrar seus vestibulares preferidos para melhor filtragem, por exemplo. O sistema de simulado escolhe aleatoriamente questões nos moldes da prova escolhida e forma uma bateria de exercícios. Já o calendário destaca as datas da prova que você prestará (pode escolher quantos vestibulares desejar). Os usuários também poderão sugerir questões que serão revisadas e poderão entrar no banco de dados do site.</p>

    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>
