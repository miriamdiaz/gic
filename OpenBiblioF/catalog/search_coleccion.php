<?
  $tab = "cataloging";
  
  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
?>
<html>
<head>
<title>Busqueda de Colecci&oacute;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function agregar(valor)
{
var input=window.opener.document.getElementById("coleccion");
if(input.value!="")
  valor=input.value+"|"+valor;
input.value=valor;
}
</script>
<style type="text/css">
  <?php include("../css/style.php");?>
</style>
</head>

<body onLoad="search.valor.focus()">
<table class="primary">
  <tr>
    <th nowrap="yes" align="left"> Busque una Colecci&oacute;n</th>
  </tr>
<tr class="primary">
<form name="search" action="search_coleccion.php">  
    <td class="primary">
	<input type="text" name="valor" maxlength="20"><input type="submit" value="Buscar" class="button">
    </td>
</form>
</tr>
</table>
<table>
<tr class="primary">
<td><center>
          <a href="#" onClick="self.close()">Cerrar</a>
        </center></td>
<td></td>
</form>
</tr>
</table>
<form name="agregar_valor" action="#">  
<?
$db=new Query();
$db->connect();
$db->_query("delete from coleccion","");
if(isset($_GET["valor"]))
{
$valor=$_GET["valor"];
$sql="SELECT field_data ";
$sql.="FROM biblio_field ";
$sql.="WHERE tag=440 AND subfield_cd = 'a' ";
$sql.="AND field_data <> '' AND NOT ISNULL(field_data) ";
$sql.="AND field_data like '%$valor%' OR field_data like '|%$valor%' ";
$sql.="GROUP BY field_data ";
$sql.="ORDER BY field_data ";
$result=$db->_query($sql,"");
while($row=mysql_fetch_array($result))
    {
	 $field_data=$row["field_data"];
	 $field_data_array=explode("|",$field_data);
	 foreach($field_data_array as $field_data_row)
	       {
			$sql="insert into coleccion values ('$field_data_row')";
			$db->_query($sql,"");
		   }
	}
$sql="select coleccion from coleccion where coleccion like '".$valor."%' group by coleccion order by coleccion";
$result=$db->_query($sql,"");	
if(mysql_num_rows($result)>0)
  {
   ?>
    <table class="primary">
      <tr>
         <th nowrap="yes" align="left" colspan="2"> Resultados</th>
      </tr>
   <?
   while($row=mysql_fetch_array($result))
        {
         $field_data=$row["coleccion"];
         ?>
          <tr class="primary">
             <td class="primary">
	             <? echo $field_data;?>
             </td>
             <td class="primary">
	             <a href="#" onClick="agregar('<?=$field_data?>')">Seleccionar</a>
             </td>	
          </tr>
         <?
        }
    ?>
    </table>
	<table>
<tr class="primary">
<td><center>
          <a href="#" onClick="self.close()">Cerrar</a>
        </center></td>
<td></td>
</form>
</tr>
</table>
    <?
   }
}
?>
</body>
</html>
