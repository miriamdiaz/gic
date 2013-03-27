<?php

  $tab = "admin";
  $nav = "novedades";
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../shared/header.php");

include ("../conexiondb.php");
include ("labels.php");
echo "<title>Cargar Novedad</title>\n";
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
echo "</head>\n";
echo "<div id=\"loading\" class=\"clsLoading\">Cargando...</div>";
echo "<body onload=\"loading()\" onUnload=\"unloading()\" id=\"body\" style=\"visibility:hidden\">\n";
echo "<div align=\"center\">\n";
$_current_pk = false;
if(isset($_SESSION["_current_pk"]))
   $_current_pk = $_SESSION["_current_pk"];
if ($_current_pk) echo "<div class=\"clsTituloGrandeCurrent\">".$_SESSION["_current_descripcion"]."</div>\n";
echo "<div><b>Cargar Novedad</b></div>\n";
echo "<hr noshade size=\"1\">\n";
echo "<div>&nbsp;</div>\n";
echo "<form action=\"createSubmit.php\" method=\"post\" name=\"createForm\">\n";
echo "<table cellsppacing=\"2\" class=\"primary\">\n";
echo "	<tr>\n";
echo "		<th>Titulo</th>\n";
echo "		<td align=\"left\">\n";
echo "			<table>\n";
echo "				<tr>\n";
echo "					<td>\n";
echo "					<input type=\"text\" name=\"titulo\" size=\"50\" maxlength=\"50\">\n";
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

					    ?>
<script languaje="javascript">
function charAlert1() 
    {
    var textField = document.createForm.descripcion;
    var pos = 0;
    var enters = 0;
    while (pos <= textField.value.length)
	{
	if (textField.value.charAt(pos) == "\n") enters++;
	pos++
	}
    document.createForm.ContadorTextarea1.value = parseInt(textField.value.length) + parseInt(enters);
    if(document.createForm.ContadorTextarea1.value > 500)
	{
	textField.value= textField.value.substring(0,(500 - parseInt(enters)));
	textField.blur();
	document.createForm.ContadorTextarea1.value = parseInt(textField.value.length) + parseInt(enters);
	alert( 'La cantidad maxima de caracteres de DESCRIPCION es 500');
	}
    }
</script> 

					    <?
echo "<textarea name=\"descripcion\" ROWS=\"5\" COLS=\"50\" onKeyUp=\"charAlert1()\"></textarea>\n<div><input type=\"text\" name=\"ContadorTextarea1\" size=\"5\" maxlength=\"5\" value=\"0\" class=\"clsContadorTextarea\"><span class=\"clsTextoChico\"> Caracteres (Maximo 500).</span></div>";
echo "</td>\n<td>\n";
echo "*";
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

$dia = split("-",date("Y-m-d", time()));
$dia[1]++;

echo "<td><input type=\"text\" name=\"fecha_vencimiento_Dia\" size=\"2\" maxlength=\"2\" value=\"$dia[2]\"></td>\n";
echo "<td>/</td>";
echo "<td><select name=\"fecha_vencimiento_Mes\">\n";
if (!$dia[1]) {echo "<option selected> </option>\n";}
    else {echo "<option> </option>\n";}
if ($dia[1] == 1) {echo "<option value=\"1\" selected>Enero</option>\n";}
    else {echo "<option value=\"1\">Enero</option>\n";}
if ($dia[1] == 2) {echo "<option value=\"2\" selected>Febrero</option>\n";}
    else {echo "<option value=\"2\">Febrero</option>\n";}
if ($dia[1] == 3) {echo "<option value=\"3\" selected>Marzo</option>\n";}
    else {echo "<option value=\"3\">Marzo</option>\n";}
if ($dia[1] == 4) {echo "<option value=\"4\" selected>Abril</option>\n";}
    else {echo "<option value=\"4\">Abril</option>\n";}
if ($dia[1] == 5) {echo "<option value=\"5\" selected>Mayo</option>\n";}
    else {echo "<option value=\"5\">Mayo</option>\n";}
if ($dia[1] == 6) {echo "<option value=\"6\" selected>Junio</option>\n";}
    else {echo "<option value=\"6\">Junio</option>\n";}
if ($dia[1] == 7) {echo "<option value=\"7\" selected>Julio</option>\n";}
    else {echo "<option value=\"7\">Julio</option>\n";}
if ($dia[1] == 8) {echo "<option value=\"8\" selected>Agosto</option>\n";}
    else {echo "<option value=\"8\">Agosto</option>\n";}
if ($dia[1] == 9) {echo "<option value=\"9\" selected>Septiembre</option>\n";}
    else {echo "<option value=\"9\">Septiembre</option>\n";}
if ($dia[1] == 10) {echo "<option value=\"10\" selected>Octubre</option>\n";}
    else {echo "<option value=\"10\">Octubre</option>\n";}
if ($dia[1] == 11) {echo "<option value=\"11\" selected>Noviembre</option>\n";}
    else {echo "<option value=\"11\">Noviembre</option>\n";}
if ($dia[1] == 12) {echo "<option value=\"12\" selected>Diciembre</option>\n";}
    else {echo "<option value=\"12\">Diciembre</option>\n";}
echo "</select></td>\n";
echo "<td>/</td>";
echo "<td><input type=\"text\" name=\"fecha_vencimiento_Ano\" size=\"4\" maxlength=\"4\" value=\"$dia[0]\"></td>\n";
echo "<td>\n<div class=\"clsTextoChico\">(ej. 30/Noviembre/2004)</div>\n</td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</td>\n<td>\n";
echo "&nbsp;";
echo "</td>\n</tr>\n</table>\n";
echo "</td>\n</tr>\n";
echo "<script languaje=\"javascript\">\n function validar(form)\n {\n  
    if (form.titulo.value == '')
        {
 	alert('Por favor complete el campo TITULO. Es requerido. '); 
  	form.titulo.focus(); 
  	return; 
        }
    if (form.descripcion.value.length > 500)
	{
	alert( 'La cantidad maxima de caracteres de DESCRIPCION es 500' );
	form.descripcion.focus(); 
	return; 
	}
    if (form.descripcion.value == '')
        {
 	alert('Por favor complete el campo DESCRIPCION. Es requerido. '); 
  	form.descripcion.focus(); 
  	return; 
        }
<!-- /\/\/\/\/\/\/\/\/\/\/\/\ VALIDACION TIPO [DATE] /\/\/\/\/\/\/\/\/\/\/\/\ --!>
    if ((form.fecha_vencimiento_Dia.value != '') && (form.fecha_vencimiento_Mes.value != '') && (form.fecha_vencimiento_Ano.value != ''))
        {
	if ((!isNaN(form.fecha_vencimiento_Dia.value)) && (!isNaN(form.fecha_vencimiento_Ano.value)))
	    {
	    if ((form.fecha_vencimiento_Dia.value >= 1) && (form.fecha_vencimiento_Dia.value <= 31))
		{
    		if (form.fecha_vencimiento_Mes.value == 2)
		    {
		    if (form.fecha_vencimiento_Dia.value > 29)
			{
			alert('El mes seleccionado en el campo FECHA VENCIMIENTO no posee mas de 29 dias'); 
  			form.fecha_vencimiento_Dia.focus(); 
  			return; 
			}
		    }
		    else if ((form.fecha_vencimiento_Mes.value == 4) || (form.fecha_vencimiento_Mes.value == 6) || (form.fecha_vencimiento_Mes.value == 9) || (form.fecha_vencimiento_Mes.value == 11))
	    	        {
			if (form.fecha_vencimiento_Dia.value > 30)
			    {
			    alert('El mes seleccionado en el campo FECHA VENCIMIENTO no posee mas de 30 dias'); 
			    form.fecha_vencimiento_Dia.focus(); 
			    return; 
			    }
			}
		}
		else
		    {
		    alert('Dia invalido en el campo FECHA VENCIMIENTO'); 
		    form.fecha_vencimiento_Dia.focus(); 
		    return; 
		    }
	    if ((form.fecha_vencimiento_Ano.value < 1900) || (form.fecha_vencimiento_Ano.value > 2100))
		{
		alert('Ano invalido en el campo FECHA VENCIMIENTO (tiene que estar comprendido entre el 1900 y el 2100)'); 
		form.fecha_vencimiento_Ano.focus(); 
		return; 
		}
	    }
	    else
		{
		alert('El campo FECHA VENCIMIENTO debe contener numeros.'); 
		form.fecha_vencimiento_Dia.focus(); 
		return; 
		}
	}
	else if ((form.fecha_vencimiento_Dia.value != '') || (form.fecha_vencimiento_Mes.value != '') || (form.fecha_vencimiento_Ano.value != ''))  
	    {
	    alert('El valor del campo FECHA VENCIMIENTO es erroneo. Debe completar todos sus campos.'); 
	    form.fecha_vencimiento_Dia.focus(); 
	    return;
	    }\n form.submit()\n }\n  </script>\n";
//echo "<tr>\n<td colspan=\"2\">\n<hr size=\"1\" color=\"#0c7caa\" noshade>\n</td>\n</tr>\n";
echo "<tr>\n<td colspan=\"2\">\n<div align=\"center\">\n<input type=\"button\" value=\"$btn_guardar\" onclick=\"validar(this.form)\" class=\"Button\">\n&nbsp;\n";
echo "<input type=\"reset\" value=\"$btn_limpiar\" class=\"Button\">\n&nbsp;\n";
echo "<input type=\"button\" value=\"$btn_cancelar\" onclick=\"window.location='browse.php'\" class=\"Button\">\n</div>\n</td>\n</tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "<div>\n* Requerido.\n</div>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
?>
