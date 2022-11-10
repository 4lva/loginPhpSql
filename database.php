<?php
/*parseamos el archivo de configuracion de la base de datos 
y extraemos los datos almacenandolos en variables*/
$datos=parse_ini_file("acceso.ini");
$server = $datos['server'];
$username = $datos['username'];
$password = $datos['password'];
$database= $datos['database'];
//establecemos la conexion con la base de datos mediante un objeto PDO 
try{
$conn=new PDO("mysql:host=$server;dbname=$database",$username,$password);
}catch(PDOException $e){
    die('Conection Failed: '.$e->getMessage());
}
?>