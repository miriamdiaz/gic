<?php
session_start();
include ("../conexiondb.php");
include ("labels.php");
if ($_POST["titulo"] != null) $titulo = "'".$_POST["titulo"]."'";
    else $titulo = "NULL";
if ($_POST["descripcion"] != null) $descripcion = "'".$_POST["descripcion"]."'";
    else $descripcion = "NULL";
//if ($_POST["fecha_alta_Dia"] != null ) $fecha_alta = "DATE '".$_POST["fecha_alta_Ano"]."-".$_POST["fecha_alta_Mes"]."-".$_POST["fecha_alta_Dia"]."'";
//    else $fecha_alta = "NULL";
$fecha_alta = "'".date("Y-m-d",time())."'";
if ($_POST["fecha_vencimiento_Dia"] != null ) $fecha_vencimiento = "'".$_POST["fecha_vencimiento_Ano"]."-".$_POST["fecha_vencimiento_Mes"]."-".$_POST["fecha_vencimiento_Dia"]."'";
    else $fecha_vencimiento = "NULL";
$sql_insertar = "INSERT INTO novedades (titulo,descripcion,fecha_alta,fecha_vencimiento)  VALUES ($titulo,$descripcion,$fecha_alta,$fecha_vencimiento)";
//echo $sql_insertar;
//TRANSACCION
$i = 0;
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
