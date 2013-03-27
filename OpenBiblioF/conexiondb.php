<?
    require_once("../database_constants.php");
	
    $conexion = mysql_connect(OBIB_HOST,OBIB_USERNAME,OBIB_PWD);
    mysql_select_db(OBIB_DATABASE);
?>