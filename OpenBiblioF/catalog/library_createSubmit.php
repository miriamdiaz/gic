<?php
session_start();
include ("../conexiondb.php");
include ("library_labels.php");
$ya_existe = "select code from biblio_cod_library where (code = '".$_POST["codigo"]."')" ;
$resultado_set_ya_existe = mysql_query($ya_existe,$conexion);
$filas_ya_existe = mysql_num_rows($resultado_set_ya_existe);
if ($filas_ya_existe == 0)
    {
if ($_POST["codigo"] != null) $codigo = $_POST["codigo"];
    else $codigo = "NULL";
if ($_POST["descripcion"] != null) $descripcion = "'".$_POST["descripcion"]."'";
    else $descripcion = "NULL";
$sql_insertar = "INSERT INTO biblio_cod_library (code,description,default_flg)  VALUES ($codigo,$descripcion,\"Y\")";
//echo $sql_insertar;
//TRANSACCION
$termino = false;
 if (mysql_query($sql_insertar, $conexion))
    {
    $termino = true;
    }
    else 
	{
	$termino = false;
	}
	
//TRANSACCION
if ($termino)
    {
    $_SESSION["msjbrowse"] = "<div class=\"clsExito\">$msj_insert</div>";
    }
    else $_SESSION["msjbrowse"] = "<div class=\"clsError\">$msj_no_insert</div>";
} //if si ya existia
else $_SESSION["msjbrowse"] = "<div class=\"clsError\">$msj_insert_repetido</div>";
mysql_close($conexion);
header("location: library_list.php");

?>
