<?php
session_start();

  $tab = "cataloging";
  $nav = "librarys";

  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../shared/header.php");


include ("../conexiondb.php");
include ("library_labels.php");
//echo "<html>\n";
//echo "<head>\n";
//echo "<title>Nueva Biblioteca</title>\n";
echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"../css/library_estilo.css\"/>\n";
echo "</head>\n";
echo "<body>\n";
echo "<div align=\"center\">\n";
echo "<div class=\"clsTituloGrande\"><b>Nueva Biblioteca</b></div>\n";
echo "<hr noshade size=\"1\">\n";
echo "<div>&nbsp;</div>\n";
echo "<form action=\"library_createSubmit.php\" method=\"post\" name=\"createForm\">\n";
echo "<table cellsppacing=\"2\" class=\"primary\">\n";
echo "	<tr>\n";
echo "		<th>Codigo</th>\n";
echo "		<td align=\"left\">\n";
echo "			<table>\n";
echo "				<tr>\n";
echo "					<td>\n";
echo "<input type=\"text\" name=\"codigo\" size=\"6\" maxlength=\"6\">\n";
echo "</td>\n<td>\n";
echo "*";
echo "</td>\n</tr>\n</table>\n";
echo "</td>\n</tr>\n";
echo "	<tr>\n";
echo "		<th>Descripcion</th>\n";
echo "		<td align=\"left\">\n";
echo "			<table>\n";
echo "				<tr>\n";
echo "					<td>\n";
echo "					<input type=\"text\" name=\"descripcion\" size=\"50\" maxlength=\"50\">\n";
echo "</td>\n<td>\n";
echo "*";
echo "</td>\n</tr>\n</table>\n";
echo "</td>\n</tr>\n";
echo "<script languaje=\"javascript\">\n function validar(form)\n {\n  
<!-- /\/\/\/\/\/\/\/\/\/\/\/\ VALIDACION TIPO [INTEGER] /\/\/\/\/\/\/\/\/\/\/\/\ -!>
    if ((form.codigo.value != '') && (isNaN(form.codigo.value)))
	{
	alert('El campo CODIGO debe ser de tipo numerico (entero) '); 
	form.codigo.focus(); 
	return; 
  	}
    if ((form.codigo.value != '') && (!isNaN(form.codigo.value)) && ((form.codigo.value < 0) || (form.codigo.value > +32767 )))
        {
 	alert('El valor campo CODIGO debe estar comprendido entre 0 y +32767'); 
  	form.codigo.focus(); 
  	return; 
        }
    if (form.codigo.value == '')
        {
 	alert('Por favor complete el campo CODIGO. Es requerido. '); 
  	form.codigo.focus(); 
  	return; 
        }
    if (form.descripcion.value == '')
        {
 	alert('Por favor complete el campo DESCRIPCION. Es requerido. '); 
  	form.descripcion.focus(); 
  	return; 
        }\n form.submit()\n }\n  </script>\n";
//echo "<tr>\n<td colspan=\"2\">\n<hr size=\"1\" color=\"#0c7caa\" noshade>\n</td>\n</tr>\n";
echo "<tr>\n<td colspan=\"2\">\n<div align=\"center\">\n<input type=\"button\" value=\"$btn_guardar\" onclick=\"validar(this.form)\" class=\"button\">\n&nbsp;\n";
echo "<input type=\"reset\" value=\"$btn_limpiar\" class=\"button\">\n&nbsp;\n";
echo "<input type=\"button\" value=\"$btn_cancelar\" onclick=\"window.location='library_list.php'\" class=\"button\">\n</div>\n</td>\n</tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "<div>\n* Requerido.\n</div>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
?>
