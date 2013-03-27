<?
  $tab = "circulation";
  
  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
?>
<html>
<head>
<title>Tipo de Prestamos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function aceptar()
{
 var radios=window.seleccion_tipo_prestamo.tipo_prestamo;
 var longitud=radios.length;
 var i=0;
 var encontrado=false;
 var valor="";
 while(i<longitud && !encontrado)
    {
	 if(radios[i].checked)
	    {
		 encontrado=true;
		 valor=radios[i].value;
		}
	 i++;
	}
window.opener.barcodesearch.dias_para_devolucion.value=valor;
window.opener.barcodesearch.submit();
window.self.close();
}
function cancelar()
{
 window.self.close();
}
document.onkeydown = function(){ 
      if(window.event && window.event.keyCode == 13){
       aceptar();
      } 
   }
</script>
<style type="text/css">
  <?php include("../css/style.php");?>
</style>
</head>

<body>
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      Seleccione el Tipo de Prestamo
    </th>
  </tr>
<tr>
<form name="seleccion_tipo_prestamo" action="sin_accion">
    <td nowrap="true" class="primary">
      <font class="small">&nbsp;</font><? echo $loc->getText("adminCollections_new_formTipo_prestamo"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printRadioButtonsValue("tipo_prestamo_dm","tipo_prestamo",$postVars,$pageErrors); ?>
    </td>
</tr>
<tr class="primary">
<td><center>
          <input type="button" name="Aceptar" value="Aceptar" onClick="aceptar()" class="button">
        </center></td>
<td><center>
          <input type="button" name="Cancelar" value="Cancelar" onClick="cancelar()" class="button">
        </center></td>
<td></td>
</form>
</tr>
</table>
</body>
</html>
