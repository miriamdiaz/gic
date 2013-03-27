<?php

echo "<!--\n
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
include ("../conexiondb.php");
include ("labels.php");
echo "<html>\n";
echo "<head>\n";
echo "<title>Buscar</title>\n";
echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"../estilo.css\"/>\n";
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
echo "<body onload=\"loading()\" onUnload=\"unloading()\" id=\"body\" style=\"visibility:hidden\">\n";
echo "<div align=\"center\">\n";
echo "<div class=\"clsTituloGrande\"><img src=\"../images/buscarGrande.png\"> Buscar</div>\n";
echo "<hr noshade size=\"1\" color=\"0c7caa\">\n";
echo "<div>&nbsp;</div>\n";
echo "<form action=\"queryResult.php\" method=\"post\" name=\"queryForm\" target=\"queryResult\">\n";
echo "<table cellsppacing=\"2\" class=\"clsTablaCreate\">\n";
echo "	<tr>\n";
echo "		<th>Titulo</th>\n";
echo "		<td align=\"left\">\n";
echo "			<table>\n";
echo "				<tr>\n";
echo "					<td>\n";
echo "					<input type=\"text\" name=\"titulo\" size=\"50\" maxlength=\"50\">\n";
echo "</td>\n<td>\n";
echo "&nbsp;";
echo "</td>\n</tr>\n</table>\n";
echo "</td>\n</tr>\n";
echo "	<tr>\n";
echo "		<th>Descripcion</th>\n";
echo "		<td align=\"left\">\n";
echo "			<table>\n";
echo "				<tr>\n";
echo "					<td>\n";
echo "					<input type=\"text\" name=\"descripcion\" size=\"50\" maxlength=\"200\">\n";
echo "</td>\n<td>\n";
echo "&nbsp;";
echo "</td>\n</tr>\n</table>\n";
echo "</td>\n</tr>\n";
echo "	<tr>\n";
echo "		<th>Fecha Alta</th>\n";
echo "		<td align=\"left\">\n";
echo "			<table>\n";
echo "				<tr>\n";
echo "					<td>\n";
echo "<table>\n";
echo "<tr>\n";
echo "<td>\n<input type=\"text\" name=\"fecha_alta_Dia\" size=\"2\" maxlength=\"2\">\n</td>\n";
echo "<td>\n/\n</td>\n";
echo "<td><select name=\"fecha_alta_Mes\">\n";
echo "<option value=\"\"> </option>\n";
echo "<option value=\"1\">Enero</option>\n";
echo "<option value=\"2\">Febrero</option>\n";
echo "<option value=\"3\">Marzo</option>\n";
echo "<option value=\"4\">Abril</option>\n";
echo "<option value=\"5\">Mayo</option>\n";
echo "<option value=\"6\">Junio</option>\n";
echo "<option value=\"7\">Julio</option>\n";
echo "<option value=\"8\">Agosto</option>\n";
echo "<option value=\"9\">Septiembre</option>\n";
echo "<option value=\"10\">Octubre</option>\n";
echo "<option value=\"11\">Noviembre</option>\n";
echo "<option value=\"12\">Diciembre</option>\n";
echo "</select>\n</td>\n";
echo "<td>\n/\n</td>\n";
echo "<td>\n<input type=\"text\" name=\"fecha_alta_Ano\" size=\"4\" maxlength=\"4\">\n</td>\n<td>\n<div style=\"font-size: 9px; color: #666666\">(ej. 30 / Noviembre / 2004)</div>\n</td>\n";
echo "</table>\n";
echo "</td>\n<td>\n";
echo "&nbsp;";
echo "</td>\n</tr>\n</table>\n";
echo "</td>\n</tr>\n";
echo "	<tr>\n";
echo "		<th>Fecha Vencimiento</th>\n";
echo "		<td align=\"left\">\n";
echo "			<table>\n";
echo "				<tr>\n";
echo "					<td>\n";
echo "<table>\n";
echo "<tr>\n";
echo "<td>\n<input type=\"text\" name=\"fecha_vencimiento_Dia\" size=\"2\" maxlength=\"2\">\n</td>\n";
echo "<td>\n/\n</td>\n";
echo "<td><select name=\"fecha_vencimiento_Mes\">\n";
echo "<option value=\"\"> </option>\n";
echo "<option value=\"1\">Enero</option>\n";
echo "<option value=\"2\">Febrero</option>\n";
echo "<option value=\"3\">Marzo</option>\n";
echo "<option value=\"4\">Abril</option>\n";
echo "<option value=\"5\">Mayo</option>\n";
echo "<option value=\"6\">Junio</option>\n";
echo "<option value=\"7\">Julio</option>\n";
echo "<option value=\"8\">Agosto</option>\n";
echo "<option value=\"9\">Septiembre</option>\n";
echo "<option value=\"10\">Octubre</option>\n";
echo "<option value=\"11\">Noviembre</option>\n";
echo "<option value=\"12\">Diciembre</option>\n";
echo "</select>\n</td>\n";
echo "<td>\n/\n</td>\n";
echo "<td>\n<input type=\"text\" name=\"fecha_vencimiento_Ano\" size=\"4\" maxlength=\"4\">\n</td>\n<td>\n<div style=\"font-size: 9px; color: #666666\">(ej. 30 / Noviembre / 2004)</div>\n</td>\n";
echo "</table>\n";
echo "</td>\n<td>\n";
echo "&nbsp;";
echo "</td>\n</tr>\n</table>\n";
echo "</td>\n</tr>\n";
echo "<script languaje=\"javascript\">\n function validar(form)\n {\n  \n form.submit()\n }\n  </script>\n";
echo "<tr>\n<td colspan=\"2\">\n<hr size=\"1\" color=\"#0c7caa\" noshade>\n</td>\n</tr>\n";
echo "<tr>\n<td colspan=\"2\">\n<div align=\"center\">\n<input type=\"button\" value=\"$btn_buscar\" onclick=\"validar(this.form)\" class=\"clsBoton\">\n&nbsp;\n";
echo "<input type=\"reset\" value=\"$btn_limpiar\" class=\"clsBoton\">\n&nbsp;\n";
echo "<input type=\"button\" value=\"$btn_cancelar\" onclick=\"parent.location='browse.php'\" class=\"clsBoton\">\n</div>\n</td>\n</tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
?>
