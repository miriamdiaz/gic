<?php

session_start();

  $tab = "cataloging";
  $nav = "librarys";

  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../shared/header.php");

//echo "<html>\n";
//echo "<head>\n";
//echo "<title>Librarys</title>\n";
echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"../css/library_estilo.css\"/>\n";
//include ("./library_ConfirmarEliminarJS.php");
include ("library_labels.php");
?>
<script languaje="javascript">
function ConfirmarEliminar(id)
    {
    var confirmacion = confirm("<?=$msj_delete_alert_js;?>");
    if (confirmacion)
	{
	window.location = 'library_delete.php?id='+id+"&";
	}
    }

</script>
<?
echo "</head>\n";
echo "<body>\n";
include ("../conexiondb.php");
echo "<div align=\"center\">\n";
$sql_total="SELECT count(code) FROM biblio_cod_library ";
$resultado_set_total = mysql_query($sql_total,$conexion);
if (mysql_numrows($resultado_set_total) > 0)
	{
	$row_total = mysql_fetch_row($resultado_set_total); 
	$filas_total = $row_total[0];
	}
	else $filas_total = 0;
$offset= $_GET["offset"];
if ($offset == "") $offset = 0;
$anterior_offset = $offset-50;
$proximo_offset = $offset+50;
$sql="SELECT code,code,description FROM biblio_cod_library ORDER BY ".$_GET["orden"]." code LIMIT 50 OFFSET $offset";
$resultado_set = mysql_query($sql,$conexion);
$columnas = mysql_num_fields($resultado_set);
$filas = mysql_numrows($resultado_set);
echo $_SESSION["msjbrowse"];
$_SESSION["msjbrowse"] = "";
echo "<b>Bibliotecas</b>\n";
echo "<hr noshade size=\"1\" >\n";
echo "<div>&nbsp;</div>\n";
echo "<div class=\"clsNota\">$filas_total $msj_browse_cant_filas</div>\n";
echo "<div>&nbsp;</div>\n";
echo "<div><a href=\"library_create.php\" style=\"color: #000000\">$lnk_crear</a></div>\n";
if ($filas > 0)
	{
	if (!($filas_total < 50 ) && (($anterior_offset) || ($proximo_offset)))
		{
		echo "<table>\n<tr>\n<td align=\"left\">\n";
		if ($anterior_offset >= 0) 
			echo "<input type=\"button\" value=\"<< 50 anteriores\" onclick=\"window.location='browse.php?offset=$anterior_offset&orden=".$_GET["orden"]."'\" class=\"clsBotonPagina\">&nbsp;";
		if ($proximo_offset < $filas_total) 
			echo "<input type=\"button\" value=\"50 proximos >>\" onclick=\"window.location='browse.php?offset=$proximo_offset&orden=".$_GET["orden"]."'\" class=\"clsBotonPagina\">";
		echo "</td><td><div class=\"clsTextoChico\" align=\"right\">Filas de ".($offset+1)." a ".($proximo_offset).".</div></td>\n</tr>\n<tr>\n<td colspan=\"2\">\n";
  		}
	echo "<table class=\"primary\" cellspacing=\"2\" border=\"0\" border-color=\"#000000\">\n";
	echo "<tr>\n";
	for ($j=1; $j < $columnas ; $j++)
		{
		$aux = split("_",strtolower(mysql_field_name($resultado_set,$j)));
		$columna_nombre= implode(" ",$aux);
		if ($_GET["orden"] == mysql_field_name($resultado_set,$j).",")
			{
			echo "<th><a href=\"library_list.php?orden=".mysql_field_name($resultado_set,$j)." DESC,\">".ucwords($columna_nombre)."</a></th>\n";
			}
			else if ($_GET["orden"] == mysql_field_name($resultado_set,$j)." DESC,")
				{
				echo "<th><a href=\"library_list.php?orden=".mysql_field_name($resultado_set,$j).",\">".ucwords($columna_nombre)."</a></th>\n";
				}
				else
					{
					echo "<th><a href=\"library_list.php?orden=".mysql_field_name($resultado_set,$j).",\">".ucwords($columna_nombre)."</a></th>\n";
					}
		}
	echo "<th>Opciones</th>\n";
	echo "</tr>\n";
	$color = 1;
	while($resultado_array = mysql_fetch_array($resultado_set))
		{
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
		   if (($numero_atributo == 1) || ($numero_atributo == 2) || ($numero_atributo == 3))
			{
				echo "<td>".$resultado_array[$numero_atributo]."</td>\n";
			}
			else 
			    if ($resultado_array[$numero_atributo])
			    {
			    $auxfecha = split(" ",$resultado_array[$numero_atributo]);
			    $auxfecha2 = split("-",$auxfecha[0]);
			    echo "<td>$auxfecha2[2]/$auxfecha2[1]/$auxfecha2[0] <span style=\"font-size:9px\">$auxfecha[1]</span></td>\n";
			    }
			    else echo "<td>&nbsp;</td>\n";
		    }
		echo "<td>\n";
		echo "	<table width=\"20%\">\n";
		echo "	  <tr>\n";
		$raid=$resultado_array["code"];
		echo "		<td><input type=\"button\" value=\"$btn_modificar\" onclick=\"window.location='library_edit.php?id=$raid'\" class=\"button\"></td>\n";

		echo "		<td><input type=\"button\" value=\"$btn_eliminar\" onclick=\"ConfirmarEliminar($raid)\" class=\"button\" ";
		$ya_existe = "select * from biblio_copy where (copy_cod_loc = ".$raid.")";
		$resultado_set_ya_existe = mysql_query($ya_existe,$conexion);
		$filas_ya_existe = mysql_num_rows($resultado_set_ya_existe);
		if ($filas_ya_existe > 0) echo "disabled";
		echo "></td>\n";
		
		echo "    </tr>\n";
		echo "  </table>\n";
		echo "</td>\n";
		echo "</tr>\n";
		}
	echo "</table>\n";
	if (!($filas_total < 50 ) && (($anterior_offset) || ($proximo_offset)))
		{
		echo "</td>\n</tr>\n<tr>\n<td colspan=\"2\" align=\"left\">\n";
		if ($anterior_offset >= 0) 
			echo "<input type=\"button\" value=\"<< 50 anteriores\" onclick=\"window.location='browse.php?offset=$anterior_offset&orden=".$_GET["orden"]."'\" class=\"clsBotonPagina\">&nbsp;";
		if ($proximo_offset < $filas_total) 
			echo "<input type=\"button\" value=\"50 proximos >>\" onclick=\"window.location='browse.php?offset=$proximo_offset&orden=".$_GET["orden"]."'\" class=\"clsBotonPagina\">";
		echo "</td>\n</tr>\n</table>\n";
  		}
	}

echo "</div>\n";
?>
<br>
<div class="small">Nota: La funci&oacute;n de borrado solo esta disponible en bibliotecas que tengan una cuenta bibliogr&aacute;fica de cero.</div>
<div class="small">Si deseas borrar una Biblioteca con una cuenta bibliogr&aacute;fica mayor de cero primero tendr&aacute;s que reasignar los materiales y ejemplares de esa biblioteca a otra biblioteca.</div>
<?
echo "</body>\n";
echo "</html>\n";
mysql_close($conexion);

?>
