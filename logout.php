<?php
//desconecta y destruye la sesion y vuelve a la pagina de login
require 'login.php';
session_unset();
session_destroy();
header('Location: /hlc/loginPhpSql/login.php');
?>