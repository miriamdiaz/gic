<?php
session_start();
echo "<!-- \n
               _,-.
       Creado {_/| \ 
          X     \/  \ 23/11/2005
      [E]DUARDO  |   `-._
       [R]OJEL	 |     _ `. __/)
     ,-------  m _/---m ___)--'
     ||+ rojel999@gmail.com +||
     ||+ http://sys9.com.ar +||
     `------------------------'
-->\n";
include ("../../conexiondb.php");
include ("labels.php");
if ($_POST["titulo"] != null)
	{
	$where .= "(lower(titulo) LIKE '%".strtolower($_POST["titulo"])."%')"; 
	$where .= " AND ";
 	}
if ($_POST["descripcion"] != null)
	{
	$where .= "(lower(descripcion) LIKE '%".strtolower($_POST["descripcion"])."%')"; 
	$where .= " AND ";
 	}
if ($_POST["fecha_alta_Dia"] != null)
	{
	$where .= "(substr(fecha_alta,9,2) LIKE '%".strtolower($_POST["fecha_alta_Dia"])."%')"; 
	$where .= " AND ";
 	}
if ($_POST["fecha_alta_Mes"] != null)
	{
	$where .= "(to_number(substr(fecha_alta,6,2),99) = ".intval(strtolower($_POST["fecha_alta_Mes"])).")"; 
	$where .= " AND ";
 	}
if ($_POST["fecha_alta_Ano"] != null)
	{
	$where .= "(substr(fecha_alta,1,4) LIKE '%".strtolower($_POST["fecha_alta_Ano"])."%')"; 
	$where .= " AND ";
 	}
if ($_POST["fecha_vencimiento_Dia"] != null)
	{
	$where .= "(substr(fecha_vencimiento,9,2) LIKE '%".strtolower($_POST["fecha_vencimiento_Dia"])."%')"; 
	$where .= " AND ";
 	}
if ($_POST["fecha_vencimiento_Mes"] != null)
	{
	$where .= "(to_number(substr(fecha_vencimiento,6,2),99) = ".intval(strtolower($_POST["fecha_vencimiento_Mes"])).")"; 
	$where .= " AND ";
 	}
if ($_POST["fecha_vencimiento_Ano"] != null)
	{
	$where .= "(substr(fecha_vencimiento,1,4) LIKE '%".strtolower($_POST["fecha_vencimiento_Ano"])."%')"; 
	$where .= " AND ";
 	}
echo "<html>\n";
echo "<head>\n";
echo "<title>Resultado de la Busqueda</title>\n";
echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"../estilo.css\"/>\n";
include ("ConfirmarEliminarJS.php");
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
echo "</head>\n";
echo "<div id=\"loading\" class=\"clsLoading\">Cargando...</div>";
echo "<body class=\"clsQueryResult\" onload=\"loading()\" onUnload=\"unloading()\" id=\"body\" style=\"visibility:hidden\">\n";
include ("labels.php");
echo "<div align=\"center\">\n";
$sql_total="SELECT id,titulo,descripcion,fecha_alta,fecha_vencimiento FROM novedades WHERE $where (1 = 1) ORDER BY fecha_alta";
$resultado_set_total = mysql_query($sql_total,$conexion);
$filas_total = mysql_num_rows($resultado_set_total);
$columnas = mysql_num_fields($resultado_set_total);
echo $_SESSION["msjbrowse"];
$_SESSION["msjbrowse"] = "";
echo "<div class=\"clsTituloGrande\">Resultado de la Busqueda</div>\n";
echo "<hr noshade size=\"1\" color=\"0c7caa\">\n";
echo "<div>&nbsp;</div>\n";
echo "<div class=\"clsNota\">$filas_total $msj_query_browse_cant_filas</div>\n";
echo "<div>&nbsp;</div>\n";
if ($filas_total > 0)
	{
	if ($filas_total <= 1000)
	{
	echo "<table class=\"clsTablaBrowse\" cellspacing=\"2\" border=\"0\" border-color=\"#000000\">\n";
	echo "<tr>\n";
	for ($j=1; $j < $columnas ; $j++)
		{
		$aux = split("_",strtolower(mysql_field_name($resultado_set_total,$j)));
		$columna_nombre= implode(" ",$aux);
		echo "<th>".ucwords($columna_nombre)."</th>\n";
		}
	echo "<th>Opciones</th>\n";
	echo "</tr>\n";
	$color = 1;
	while($resultado_array = mysql_fetch_array($resultado_set_total))
		{
		if ((strtotime($resultado_array["fecha_vencimiento"]) <= strtotime(date("Y-m-d",time()))) && ($resultado_array["fecha_vencimiento"] != "")) echo "<tr style=\"color: red\">\n";
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
			    echo "<td>$auxfecha2[2]/$auxfecha2[1]/$auxfecha2[0] <span style=\"font-size:9px\">$auxfecha[1]</span></td>\n";
			    }
			    else echo "<td>&nbsp;</td>\n";
		    }
		echo "<td>\n";
		echo "	<table width=\"20%\">\n";
		echo "	  <tr>\n";
		$raid=$resultado_array["id"];
		echo "		<td><input type=\"button\" value=\"$btn_modificar\" onclick=\"parent.location='edit.php?id=$raid'\" class=\"clsBoton\"></td>\n";
		echo "		<td><input type=\"button\" value=\"$btn_eliminar\" onclick=\"ConfirmarEliminar($raid)\" class=\"clsBoton\"></td>\n";
		echo "    </tr>\n";
		echo "  </table>\n";
		echo "</td>\n";
		echo "</tr>\n";
		}
	echo "</table>\n";
	} else echo "<div class=\"clsError\"><h3>Se han encotrado demasiados registros, no se pueden mostrar. Por favor refine la Busqueda.</h3></div>";
	}
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
mysql_close($conexion);
?>
