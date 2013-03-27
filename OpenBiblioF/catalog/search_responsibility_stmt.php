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
<title>Busqueda de Responsabilidad Secundaria</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function agregar(responsibility_stmt)
{
var input=window.opener.document.getElementById("responsibility_stmt");
if(input.value!="")
  responsibility_stmt=input.value+"|"+responsibility_stmt;
input.value=responsibility_stmt;
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
    <th nowrap="yes" align="left"> Busque una Responsabilidad Secundaria</th>
  </tr>
<tr class="primary">
<form name="search_autor" action="search_responsibility_stmt.php" method="post">  
    <td class="primary">
	<input type="text" name="responsibility_stmt" maxlength="20"><input type="submit" value="Buscar" class="button">
    </td>
</form>
</tr>
</table>
<form name="agregar_autor" action="#">  
<?
$db=new Query();
$db->connect();
$db->_query("delete from responsibility_stmt","");
if(isset($_POST["responsibility_stmt"]))
{
$responsibility_stmt=$_POST["responsibility_stmt"];
$db->_query("delete from responsibility_stmt","");
$sql="select responsibility_stmt from biblio where responsibility_stmt like '".$responsibility_stmt."%' or responsibility_stmt like '%|".$responsibility_stmt."%' group by responsibility_stmt ";
$result=$db->_query($sql,"");
while($row=mysql_fetch_array($result))
    {
	 $responsibility_stmt_result=$row["responsibility_stmt"];
	 $responsibility_stmt_array=explode("|",$responsibility_stmt_result);
	 foreach($responsibility_stmt_array as $responsibility_stmt_row)
	       {
			$sql="insert into responsibility_stmt values ('$responsibility_stmt_row')";
			$db->_query($sql,"");
		   }
	}
$sql="select responsibility_stmt from responsibility_stmt where responsibility_stmt like '".$responsibility_stmt."%' group by responsibility_stmt order by responsibility_stmt";
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
         $responsibility_stmt=$row["responsibility_stmt"];
         ?>
          <tr class="primary">
             <td class="primary">
	             <? echo $responsibility_stmt;?>
             </td>
             <td class="primary">
	             <a href="#" onClick="agregar('<?=$responsibility_stmt?>')">Seleccionar</a>
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
