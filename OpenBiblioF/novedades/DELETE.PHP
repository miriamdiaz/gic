<?php
session_start();
include ("../conexiondb.php");
include ("labels.php");
$sql_delete = "DELETE FROM novedades WHERE id=".$_GET["id"];
//echo $sql_delete;
//TRANSACCION
$i = 0;
$termino = false;
if (mysql_query($sql_delete, $conexion))
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
