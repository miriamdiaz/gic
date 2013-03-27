<?
  $tab = "adquisiciones";
  
  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  include_once("../classes/Staff.php");
  include_once("../classes/StaffQuery.php");  
  $loc = new Localize(OBIB_LOCALE,$tab);
  
?>
<html>
<head>
<title>Historial de Cambio de Estados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function cerrar()
{
 window.self.close();
}
</script>
<style type="text/css">
  <?php include("../css/style.php");?>
</style>
</head>

<body>

<h1><?php echo "Historial de Estados";?></h1>

<table class="primary">
  <tr>
    <th nowrap="yes" align="left">
      Estado
    </th>
    <th nowrap="yes" align="left">
      Inicio
    </th>
    <th nowrap="yes" align="left">
      Operador
    </th>		
  </tr>
<?
$db=new Query();
$db->connect();
$sql="select * from adquisiciones_status_hist where adqid = ".$_GET["code"]." order by status_begin_dt desc";
$result=$db->_query($sql,"");
if(mysql_num_rows($result) == 0)
  {
   ?>
		  <tr>
			<td class="primary" align="center" colspan="15">
			  <?php print "No se econtró historial de cambios"; ?>
			</td>
		  </tr>
   <?
   }
else
  {
   $dmQ = new DmQuery();
   $dmQ->connect();
   if ($dmQ->errorOccurred()) {
		$dmQ->close();
		displayErrorPage($dmQ);
   }
   $dmQ->execSelect("estado_dm");
   $estadoDm = $dmQ->fetchRows();    
   
    $staffQ = new StaffQuery();
    $staffQ->connect();
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ);
    }
   
   while($row = mysql_fetch_array($result))
        {
         $estado_cd = $row["estado_cd"];
		 $status_begin_dt = $row["status_begin_dt"];
         $staffQ->execSelect($row["userid"]);
         if ($staffQ->errorOccurred()) {
            $staffQ->close();
            displayErrorPage($staffQ);
         }
         $staff = $staffQ->fetchStaff();   		 
         ?>
          <tr class="primary">
             <td class="primary">
	             <? echo $estadoDm[$estado_cd];?>
             </td>	
             <td class="primary">
	             <? echo $status_begin_dt;?>
             </td>	
             <td class="primary">
	             <? echo $staff->getLastName()." ".$staff->getFirstName();?>
             </td>				 			 
          </tr>
         <?
        }
   }
?>  
</table>
<br>
<div align="center">
<table class="primary">
<tr class="primary">
<td align="center">
          <input type="button" name="Cerrar" value="Cerrar" onClick="cerrar()" class="button">
</td>
<td></td>
</tr>
</table>
</div>
</body>
</html>
