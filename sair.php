<?php
session_start();
$_SESSION['login']=null;
$_SESSION['idUsuarioSessao']=null;
header("Location: index.php");
exit;
?>
