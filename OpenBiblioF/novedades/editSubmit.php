<?php
session_start();
include ("../conexiondb.php");
include ("labels.php");
if ($_POST["titulo"] != null) $titulo = "'".$_POST["titulo"]."'";
    else $titulo = "NULL";
if ($_POST["descripcion"] != null) $descripcion = "'".$_POST["descripcion"]."'";
    else $descripcion = "NULL";
if ($_POST["fecha_vencimiento_Dia"] != null ) $fecha_vencimiento = "'".$_POST["fecha_vencimiento_Ano"]."-".$_POST["fecha_vencimiento_Mes"]."-".$_POST["fecha_vencimiento_Dia"]."'";
    else $fecha_vencimiento = "NULL";
$sql_update = "UPDATE novedades SET titulo=$titulo, descripcion=$descripcion, fecha_vencimiento=$fecha_vencimiento WHERE id=".$_POST["suid"];
//echo $sql_update;
//TRANSACCION
$i = 0;
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
mysql_close($conexion);
header("location: browse.php");
/*

               _,-.
       Creado {_/| \ 
          X     \/  \ 23/11/2005
      [E]DUARDO  |   `-._
       [R]OJEL	 |     _ `. __/)
     ,-------  m _/---m ___)--'
     ||+ rojel999@gmail.com +||
     ||+ http://sys9.com.ar +||
     `------------------------'
*/
?>
