<?php
session_start();
include ("../conexiondb.php");
include ("library_labels.php");
$sql_delete = "DELETE FROM biblio_cod_library WHERE code=".$_GET["id"];
//echo $sql_delete;
//TRANSACCION
$termino = false;
if (mysql_query($sql_delete,$conexion))
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
    $_SESSION["msjbrowse"] = "<div class=\"clsExito\">$msj_delete</div>";
    }
    else $_SESSION["msjbrowse"] = "<div class=\"clsError\">$msj_no_delete</div>";
mysql_close($conexion);
header("location: library_list.php");
?>
