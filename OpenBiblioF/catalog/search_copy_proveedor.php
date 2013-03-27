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
<title>Busqueda de Proveedor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function agregar(copy_proveedor)
{
var input=window.opener.document.getElementById("copyProveedor");
if(input.value!="")
  copy_proveedor=input.value+"|"+copy_proveedor;
input.value=copy_proveedor;
//self.close();
}
</script>
<style type="text/css">
  <?php include("../css/style.php");?>
</style>
</head>

<body>
<table class="primary">
  <tr>
    <th nowrap="yes" align="left"> Busque un Proveedor</th>
  </tr>
<tr class="primary">
<form name="search_copy_proveedor" action="search_copy_proveedor.php" method="post">  
    <td class="primary">
	<input type="text" name="copy_proveedor" maxlength="20"><input type="submit" value="Buscar" class="button">
    </td>
</form>
</tr>
</table>
<form name="agregar_copy_proveedor" action="#">  
<?
$db=new Query();
$db->connect();
$db->_query("delete from copy_proveedor","");
if(isset($_POST["copy_proveedor"]))
{
$copy_proveedor_post=$_POST["copy_proveedor"];
$db->_query("delete from copy_proveedor","");
$sql="select copy_proveedor from biblio_copy where copy_proveedor like '".$copy_proveedor_post."%' or copy_proveedor like '%|".$copy_proveedor_post."%' group by copy_proveedor ";
$result=$db->_query($sql,"");
while($row=mysql_fetch_array($result))
    {
	 $copy_proveedor_result=$row["copy_proveedor"];
	 $copy_proveedor_array=explode("|",$copy_proveedor_result);
	 foreach($copy_proveedor_array as $copy_proveedor_row)
	       {
			$sql="insert into copy_proveedor values ('$copy_proveedor_row')";
			$db->_query($sql,"");
		   }
	}
$sql="select copy_proveedor from copy_proveedor where copy_proveedor like '".$copy_proveedor_post."%' group by copy_proveedor order by copy_proveedor";
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
         $copy_proveedor=$row["copy_proveedor"];
         ?>
          <tr class="primary">
             <td class="primary">
	             <? echo $copy_proveedor;?>
             </td>
             <td class="primary">
	             <a href="#" onClick="agregar('<?=$copy_proveedor?>')">Seleccionar</a>
             </td>	
          </tr>
         <?
        }
    ?>
    </table>
    <?
   }
}
?>
<table>
<tr class="primary">
<td><center>
          <input type="button" name="Cerrar" value="Cerrar" onClick="self.close()" class="button">
        </center></td>
<td></td>
</form>
</tr>
</table>
</body>
</html>
