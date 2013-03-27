<?php
/**********************************************************************************
 *   Copyright(C) 2002 David Stevens
 *
 *   This file is part of OpenBiblio.
 *
 *   OpenBiblio is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   OpenBiblio is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with OpenBiblio; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **********************************************************************************
 */

  $tab = "home";
  $nav = "adquisicion";

  require_once("../shared/common.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/inputFuncs.php");
  require_once("../functions/formatFuncs.php");  
  require_once("../classes/AdquisicionQuery.php");
  require_once("../classes/Adquisicion.php");
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,"circulation");
  
    if(isset($_SESSION["postVars"])) $postVars = $_SESSION["postVars"] ;
    if(isset($_SESSION["pageErrors"])) $pageErrors = $_SESSION["pageErrors"];  
  
?>

  <script language="JavaScript">

  </script>

<h1><?php echo "Adquisición Online de Libros";?></h1>
<br>
<?php echo "Desde aquí el docente puede realizar pedidos de nuevos libros";?>
<?

include ("../conexiondb.php");
$muestraFormulario = true;
$msg = "";

if(isset($_GET["barcode_nmbr"]))
   $_POST["barcode_nmbr"] = $_GET["barcode_nmbr"];
  
if(isset($_POST["barcode_nmbr"]))
{
$muestraFormulario=false;
$barcode_nmbr = trim($_POST["barcode_nmbr"]);
$barcode_nmbr = str_replace("'","",$barcode_nmbr);
$sql = "SELECT * FROM MEMBER WHERE barcode_nmbr like '$barcode_nmbr' AND classification = 2 ";
$result = mysql_query($sql);
if($row = mysql_fetch_array($result))
  {
   $mbrid = $row["mbrid"];
   $mbrQ = new MemberQuery();
   $mbrQ->connect();
   if ($mbrQ->errorOccurred()) {
     $mbrQ->close();
     displayErrorPage($mbrQ);
   }
   if (!$mbrQ->execSelect($mbrid)) {
     $mbrQ->close();
     displayErrorPage($mbrQ);
   }
   $mbr = $mbrQ->fetchMember();   
   
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  /***********************************/
  /*Fin Actualiza las reservas vencidas  */
  /***********************************/
  $dmQ->execSelect("concepto_dm");
  $conceptoDm = $dmQ->fetchRows();
  $dmQ->execSelect("area_dm");
  $areaDm = $dmQ->fetchRows();
  $dmQ->execSelect("biblio_cod_library");
  $biblio_cod_library = $dmQ->fetchRows();    
  $dmQ->execSelect("estado_dm");
  $estadoDm = $dmQ->fetchRows();
  $dmQ->execSelect("mbr_classify_dm");
  $mbrClassifyDm = $dmQ->fetchRows();  
  $dmQ->close();   
?>
<div align="center">
<br>
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php print "Información del docente"; ?>
    </th>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <b><?php print $loc->getText("mbrViewCardNmbr"); ?></b>
    </td>
    <td valign="top" class="primary">
      <b><?php echo $mbr->getBarcodeNmbr();?></b>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <b><?php print $loc->getText("mbrViewName"); ?></b>
    </td>
    <td valign="top" class="primary">
      <b><?php echo $mbr->getLastName();?>, <?php echo $mbr->getFirstName();?></b>
    </td>
 
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewLibraryid"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $biblio_cod_library[$mbr->getLibraryid()];?>
    </td>    
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewClassify"); ?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $mbrClassifyDm[$mbr->getClassification()];?>
    </td>
  </tr>	
</table>
<br>
<div align="left"><a href="../home/adquisiciones_new_form.php?barcode_nmbr=<? echo $barcode_nmbr;?>&reset=Y"><? echo "Agregar Pedido"; ?></a></div>
<br>
<div align="left">Pedidos de Conceptos Actuales:</div>
<br>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left" colspan="2">
      <?php print "Funciones"; ?>
    </th>  
    <th valign="top" nowrap="yes" align="left">
      <?php print "Nro."; ?>
    </th>	
    <th valign="top" nowrap="yes" align="left">
      <?php print "Concepto"; ?>
    </th>
    <th valign="top" align="left">
      <?php print "Estado"; ?>
    </th>		
    <th valign="top" nowrap="yes" align="left">
      <?php print "Título"; ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print "Autor"; ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print "I.S.B.N"; ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print "Edición"; ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print "Editorial"; ?>
    </th>
    <th valign="top" align="left">
      <?php print "Biblioteca"; ?>
    </th>
    <th valign="top" align="left">
      <?php print "Área"; ?>
    </th>	
    <th valign="top" align="left">
      <?php print "Creado"; ?>
    </th>					
  </tr>
<?php
  #****************************************************************************
  #*  Search database for BiblioStatus data
  #****************************************************************************
  $adquisicionQ = new AdquisicionQuery();
  $adquisicionQ->connect();
  if ($adquisicionQ->errorOccurred()) {
    $adquisicionQ->close();
    displayErrorPage($adquisicionQ);
  }
  if (!$adquisicionQ->execSelectActuales($mbrid)) {
    $adquisicionQ->close();
    displayErrorPage($adquisicionQ);
  }

  if ($adquisicionQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="15">
      <?php print "No posee pedidos actuales"; ?>
    </td>
  </tr>
<?php
  } else {
    while ($adq = $adquisicionQ->fetchAdquisicion()) {
?>
  <tr>
    <td class="primary" valign="top" nowrap="yes">
	   <a href="../home/adquisiciones_edit_form.php?code=<?php echo $adq->getAdqid();?>&barcode_nmbr=<?php echo $barcode_nmbr;?>&reset=Y" class="<?php echo $row_class;?>"><? echo "Editar"; ?></a>
    </td>
    <td class="primary" valign="top" nowrap="yes">
      <a href="../home/adquisiciones_del_confirm.php?code=<?php echo $adq->getAdqid();?>&barcode_nmbr=<?php echo $barcode_nmbr;?>" class="<?php echo $row_class;?>"><? echo "Eliminar"; ?></a>
    </td>	  
    <td class="primary" valign="top" nowrap="yes">
      <?php echo $adq->getAdqid();?>
    </td>	
    <td class="primary" valign="top" nowrap="yes">
      <?php echo $conceptoDm[$adq->getConceptoCd()];?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $estadoDm[$adq->getEstadoCd()];?>
    </td>	
    <td class="primary" valign="top">
      <?php echo $adq->getTitle();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $adq->getAuthor();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $adq->getIsbn();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $adq->getEdicionDt();?>
    </td>
    <td class="primary" valign="top" nowrap="yes">
      <?php echo $adq->getEditorial();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $adq->getLibraryId();?>
    </td>	
    <td class="primary" valign="top" >
      <?php echo $areaDm[$adq->getAreaCd()];?>
    </td>		
    <td class="primary" valign="top" >
      <?php echo toDDmmYYYY($adq->getCreatedDt());?>
    </td>							
  </tr>
<?php
    }
  }
  $adquisicionQ->close();
?>
</table>
<br>
<div align="left">Pedidos de Conceptos Vencidos:</div>
<br>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php print "Nro."; ?>
    </th>	
    <th valign="top" nowrap="yes" align="left">
      <?php print "Concepto"; ?>
    </th>
    <th valign="top" align="left">
      <?php print "Estado"; ?>
    </th>		
    <th valign="top" nowrap="yes" align="left">
      <?php print "Título"; ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print "Autor"; ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print "I.S.B.N"; ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print "Edición"; ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print "Editorial"; ?>
    </th>
    <th valign="top" align="left">
      <?php print "Biblioteca"; ?>
    </th>
    <th valign="top" align="left">
      <?php print "Área"; ?>
    </th>	
    <th valign="top" align="left">
      <?php print "Creado"; ?>
    </th>					
  </tr>
<?php
  #****************************************************************************
  #*  Search database for BiblioStatus data
  #****************************************************************************
  $adquisicionQ = new AdquisicionQuery();
  $adquisicionQ->connect();
  if ($adquisicionQ->errorOccurred()) {
    $adquisicionQ->close();
    displayErrorPage($adquisicionQ);
  }
  if (!$adquisicionQ->execSelectVencidos($mbrid)) {
    $adquisicionQ->close();
    displayErrorPage($adquisicionQ);
  }

  if ($adquisicionQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="15">
      <?php print "No posee pedidos vencidos"; ?>
    </td>
  </tr>
<?php
  } else {
    while ($adq = $adquisicionQ->fetchAdquisicion()) {
?>
  <tr>	  
    <td class="primary" valign="top" nowrap="yes">
      <?php echo $adq->getAdqid();?>
    </td>	
    <td class="primary" valign="top" nowrap="yes">
      <?php echo $conceptoDm[$adq->getConceptoCd()];?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $estadoDm[$adq->getEstadoCd()];?>
    </td>	
    <td class="primary" valign="top">
      <?php echo $adq->getTitle();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $adq->getAuthor();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $adq->getIsbn();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $adq->getEdicionDt();?>
    </td>
    <td class="primary" valign="top" nowrap="yes">
      <?php echo $adq->getEditorial();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $adq->getLibraryId();?>
    </td>	
    <td class="primary" valign="top" >
      <?php echo $areaDm[$adq->getAreaCd()];?>
    </td>		
    <td class="primary" valign="top" >
      <?php echo toDDmmYYYY($adq->getCreatedDt());?>
    </td>							
  </tr>
<?php
    }
  }
  $adquisicionQ->close();
?>
</table>
<?
  }
else
  {
   $muestraFormulario = true;
   $msg = "El DNI no corresponde a un docente activo.";
  }
}

if($muestraFormulario)
{
?>
<form action="adquisicion.php" name="info" method="post">
<div align="center">
<table>
<tr>
<td><?php print $loc->getText("mbrViewCardNmbr"); ?></td>
<td><input type="text" name="barcode_nmbr"><? echo $msg;?></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input type="submit" name="Buscar" value="Ingresar" class="button"></div></td>
</tr>
</table>
</div>
</form>
<? 
}
//include("../shared/footer.php"); 
?>