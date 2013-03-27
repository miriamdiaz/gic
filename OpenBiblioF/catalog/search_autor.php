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
<title>Busqueda de Autor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function agregar(author)
{
var input=window.opener.document.getElementById("autor");
if(input.value!="")
  author=input.value+"|"+author;
input.value=author;
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
    <th nowrap="yes" align="left"> Busque un autor</th>
  </tr>
<tr class="primary">
<form name="search_autor" action="search_autor.php">  
    <td class="primary">
	<input type="text" name="autor" maxlength="20"><input type="submit" value="Buscar" class="button">
    </td>
</form>
</tr>
</table>
<form name="agregar_autor" action="#">  
<?
$db=new Query();
$db->connect();
$db->_query("delete from author","");
if(isset($_GET["autor"]))
{
$autor=$_GET["autor"];
$db->_query("delete from author","");
$sql="select author from biblio where author like '".$autor."%' or author like '%|".$autor."%' group by author ";
$result=$db->_query($sql,"");
while($row=mysql_fetch_array($result))
    {
	 $author=$row["author"];
	 $author_array=explode("|",$author);
	 foreach($author_array as $author_row)
	       {
			$sql="insert into author values ('$author_row')";
			$db->_query($sql,"");
		   }
	}
$sql="select author from author where author like '".$autor."%' group by author order by author";
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
         $author=$row["author"];
         ?>
          <tr class="primary">
             <td class="primary">
	             <? echo $author;?>
             </td>
             <td class="primary">
	             <a href="#" onClick="agregar('<?=$author?>')">Seleccionar</a>
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
