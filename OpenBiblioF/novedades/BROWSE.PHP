<?php

//session_start();
  $tab = "admin";
  $nav = "novedades";
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../shared/header.php");
//echo "<html>\n";
//echo "<head>\n";
echo "<title>Novedades</title>\n";
echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"../css/library_estilo.css\"/>\n";

?>
<script languaje=\"javascript\">
    function loading()
	{
	document.getElementById("body").style.visibility="visible";
	document.getElementById("loading").style.visibility="hidden";
	}
    function unloading()
	{
	document.getElementById("loading").style.visibility="visible";
	}
</script>
<?
include ("ConfirmarEliminarJS.php");
echo "</head>\n";
echo "<div id=\"loading\" class=\"clsLoading\">Cargando...</div>";
echo "<body onload=\"loading()\" onUnload=\"unloading()\" id=\"body\">\n";
include ("../conexiondb.php");
include ("labels.php");
echo "<div align=\"center\">\n";
$sql="SELECT id,titulo,descripcion,fecha_alta,fecha_vencimiento FROM novedades  ORDER BY fecha_alta DESC ";
$sql_total="SELECT count(id) FROM novedades ";
$resultado_set_total = mysql_query($sql_total,$conexion);
if (mysql_num_rows($resultado_set_total) > 0)
	{
	$row_total = mysql_fetch_row($resultado_set_total); 
	$filas_total = $row_total[0];
	}
	else $filas_total = 0;
	
if(isset($_GET["offset"]))
   $offset= $_GET["offset"];
else
   $offset = 0;
$anterior_offset = $offset-100;
$proximo_offset = $offset+100;
$sql="SELECT id,titulo,descripcion,fecha_alta,fecha_vencimiento FROM novedades  ORDER BY fecha_alta DESC  LIMIT 100 OFFSET $offset";
$resultado_set = mysql_query($sql,$conexion);
$columnas = mysql_num_fields($resultado_set);
$filas = mysql_num_rows($resultado_set);
echo $_SESSION["msjbrowse"];
$_SESSION["msjbrowse"] = "";
echo "<b>Novedades</b>\n";
echo "<hr noshade size=\"1\">\n";
echo "<div>&nbsp;</div>\n";
echo "<div class=\"clsNota\">$filas_total $msj_browse_cant_filas</div>\n";
echo "<div>&nbsp;</div>\n";
echo "<div><a href=\"create.php\" style=\"color: #000000\">$lnk_crear</a></div>\n";
if ($filas > 0)
	{
	if (!($filas_total < 100 ) && (($anterior_offset) || ($proximo_offset)))
		{
		echo "<table>\n<tr>\n<td align=\"left\">\n";
		if ($anterior_offset >= 0) 
			echo "<input type=\"button\" value=\"<< 100 anteriores\" onclick=\"window.location='browse.php?offset=$anterior_offset&orden=".$_GET["orden"]."'\" class=\"Button\">&nbsp;";
		if ($proximo_offset < $filas_total) 
			echo "<input type=\"button\" value=\"100 proximos >>\" onclick=\"window.location='browse.php?offset=$proximo_offset&orden=".$_GET["orden"]."'\" class=\"Button\">";
		echo "</td><td><div class=\"clsTextoCantFilas\" align=\"right\">Filas de ".($offset+1)." a ".($proximo_offset).".</div></td>\n</tr>\n<tr>\n<td colspan=\"2\">\n";
  		}
	echo "<table class=\"primary\" cellspacing=\"2\" border=\"0\" border-color=\"#000000\">\n";
	echo "<tr>\n";
	for ($j=1; $j < $columnas ; $j++)
		{
		$aux = split("_",strtolower(mysql_field_name($resultado_set,$j)));
		$columna_nombre= implode(" ",$aux);
		$orden = "";
		if(isset($_GET["orden"]))
		   $orden = $_GET["orden"];
		if ($orden == mysql_field_name($resultado_set,$j).",")
			{
			echo "<th><a href=\"browse.php?orden=".mysql_field_name($resultado_set,$j)." DESC,\">".ucwords($columna_nombre)."</a><img src=\"../images/arriba.png\"></th>\n";
			}
			else if ($orden == mysql_field_name($resultado_set,$j)." DESC,")
				{
				echo "<th><a href=\"browse.php?orden=".mysql_field_name($resultado_set,$j).",\">".ucwords($columna_nombre)."</a><img src=\"../images/abajo.png\"></th>\n";
				}
				else
					{
					echo "<th><a href=\"browse.php?orden=".mysql_field_name($resultado_set,$j).",\">".ucwords($columna_nombre)."</a></th>\n";
					}
		}
	echo "<th>Opciones</th>\n";
	echo "</tr>\n";
	$color = 1;
	while($resultado_array = mysql_fetch_array($resultado_set))
		{
		if (($resultado_array["fecha_vencimiento"] != "") && (strtotime($resultado_array["fecha_vencimiento"]) <= strtotime(date("Y-m-d",time())))) echo "<tr class=\"clsTablaBrowseFilaPar\" style=\"color: red\">\n";
		else
		if (($color % 2) == 0)
		    {
		    echo "<tr class=\"clsTablaBrowseFilaPar\">\n";
		    }
		    else
			{
			echo "<tr class=\"clsTablaBrowseFilaImpar\">\n";
			}
		$color++;
		for ( $numero_atributo=1; $numero_atributo < $columnas; $numero_atributo++)
		    {
		   if (($numero_atributo == 1) || ($numero_atributo == 2))
			{
				echo "<td>".$resultado_array[$numero_atributo]."</td>\n";
			}
			else 
			    if ($resultado_array[$numero_atributo])
			    {
			    $auxfecha = split(" ",$resultado_array[$numero_atributo]);
			    $auxfecha2 = split("-",$auxfecha[0]);
				$auxfecha2_1 = "";
				if(isset($auxfecha2[1]))
				   $auxfecha2_1 =  $auxfecha2[1];
				$auxfecha_1 = "";
				if(isset($auxfecha[1]))
				   $auxfecha_1 =  $auxfecha[1];				   
			    echo "<td>$auxfecha2[2]/$auxfecha2_1/$auxfecha2[0] <span style=\"font-size:9px\">$auxfecha_1</span></td>\n";
			    }
			    else echo "<td>&nbsp;</td>\n";
		    }
		echo "<td>\n";
		echo "	<table width=\"20%\">\n";
		echo "	  <tr>\n";
		$raid=$resultado_array["id"];
		$rapk=$resultado_array["id"];
		echo "		<td><input type=\"button\" value=\"$btn_modificar\" onclick=\"window.location='edit.php?id=$raid'\" class=\"Button\"></td>\n";
		echo "		<td><input type=\"button\" value=\"$btn_eliminar\" onclick=\"ConfirmarEliminar($raid)\" class=\"Button\"></td>\n";
		echo "    </tr>\n";
		echo "  </table>\n";
		echo "</td>\n";
		echo "</tr>\n";
		}
	echo "</table>\n";
	if (!($filas_total < 100 ) && (($anterior_offset) || ($proximo_offset)))
		{
		echo "</td>\n</tr>\n<tr>\n<td colspan=\"2\" align=\"left\">\n";
		if ($anterior_offset >= 0) 
			echo "<input type=\"button\" value=\"<< 100 anteriores\" onclick=\"window.location='browse.php?offset=$anterior_offset&orden=".$_GET["orden"]."'\" class=\"Button\">&nbsp;";
		if ($proximo_offset < $filas_total) 
			echo "<input type=\"button\" value=\"100 proximos >>\" onclick=\"window.location='browse.php?offset=$proximo_offset&orden=".$_GET["orden"]."'\" class=\"Button\">";
		echo "</td>\n</tr>\n</table>\n";
  		}
	}
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
mysql_close($conexion);

?>
