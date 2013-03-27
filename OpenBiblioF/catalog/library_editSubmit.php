<?php
session_start();
include ("../conexiondb.php");
include ("library_labels.php");
$ya_existe = "select code from biblio_cod_library where (code = '".$_POST["codigo"]."') AND (code <> ".$_POST["suid"].")";
$resultado_set_ya_existe = mysql_query($ya_existe,$conexion);
$filas_ya_existe = mysql_num_rows($resultado_set_ya_existe);
if ($filas_ya_existe == 0)
    {
if ($_POST["codigo"] != null) $codigo = $_POST["codigo"];
    else $codigo = "NULL";
if ($_POST["descripcion"] != null) $descripcion = "'".$_POST["descripcion"]."'";
    else $descripcion = "NULL";
$sql_update = "UPDATE biblio_cod_library SET code=$codigo, description=$descripcion WHERE code=".$_POST["suid"];
//echo $sql_update;
//TRANSACCION
$termino = false;
 if (mysql_query($sql_update, $conexion))
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
    $_SESSION["msjbrowse"] = "<div class=\"clsExito\">$msj_update</div>";
    }
    else $_SESSION["msjbrowse"] = "<div class=\"clsError\">$msj_no_update</div>";
} //if si ya existia
else $_SESSION["msjbrowse"] = "<div class=\"clsError\">$msj_insert_repetido</div>";
mysql_close($conexion);
header("location: library_list.php");

?>
