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

  $tab = "circulation";
  $nav = "view";
  $focus_form_name = "barcodesearch";
  $focus_form_field = "barcodeNmbr";

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/BiblioSearch.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  //agregado Horacio Alvarez 01-04-06
  require_once("../classes/StaffQuery.php");  
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $barcode = $_GET["barcode"];
  $mbrid = $_GET["mbrid"];
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".stripslashes($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }
  
  $copyQ = new BiblioCopyQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copy = $copyQ->queryByBarcode($barcode)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  } 


  #****************************************************************************
  #*  Search database for member
  #****************************************************************************
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
  $mbrQ->close();
  
  #****************************************************************************
  #*  Autor: Horacio Alvarez
  #*  Fecha: 17-04-06
  #*  Descripcion: Traigo los campos Unidad Academica, domicilio desde Settings.php
  #*  y biblioteca desde libraryid de Member.php
  #****************************************************************************
    include_once("../classes/Settings.php");
    include_once("../classes/SettingsQuery.php");
    include_once("../functions/errorFuncs.php");
    $setQ = new SettingsQuery();
    $setQ->connect();
    if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
    }
    $setQ->execSelect();
    if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
    }
    $set = $setQ->fetchRow();  
	
  include("../classes/Library.php");
  $libraryQ= new LibraryQuery;
  $libraryQ->connect();
  if ($libraryQ->errorOccurred()) {
      $libraryQ->close();
      displayErrorPage($libraryQ);
    }  
  $libraryQ->execSelectWithCode($mbr->getLibraryid());
  if ($libraryQ->errorOccurred()) {
      $libraryQ->close();
      displayErrorPage($libraryQ);
    }
    $library = $libraryQ->fetchRow();    
	
  #**************************************************************************
  #*  Show member checkouts
  #**************************************************************************
?>
<html>
<head>
<!-- Modificado: Horacio Alvarez 
     Fecha: 05-04-06
	 Descripcion: Se usa un CSS diferente para la impresion
-->

<meta name="description" content="OpenBiblio Library Automation System">
<title>Infracción de <?php echo $mbr->getFirstLastName();?></title>

<link href="../css/style_checkout.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="<?php echo OBIB_PRIMARY_BG;?>" topmargin="5" bottommargin="5" leftmargin="5" rightmargin="5" marginheight="5" marginwidth="5" onLoad="self.focus();self.print();">

<font class="primary">

<table class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td class="noborder" valign="top" nowrap="yes"><div align="right"><font class="small"><a href="javascript:window.close()"><?php echo $loc->getText("mbrPrintCloseWindow"); ?></font></a>&nbsp;&nbsp;</font></div></td>
  </tr>
</table>
<table class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td colspan="2" width="100%" class="noborder" valign="top"><?php echo $set->getUnidad_academica()." - ".$set->getDomicilio();?></td>
  </tr>
  <tr>
    <td colspan="2" width="100%" class="noborder" valign="top"><?php echo $library->getDescription();?></td>
  </tr>  
  <tr>
    <td class="noborder" valign="top"><?php echo $loc->getText("mbrPrintCheckoutsHdr1");?></td>
    <td width="100%" class="noborder" valign="top"><?php echo getFechaEspaniol();?></td>
  </tr>
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr2");?></td>
    <td class="noborder" valign="top"><?php echo $mbr->getFirstLastName();?></td>
  </tr>
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr3");?></td>
    <td class="noborder" valign="top"><?php echo $mbr->getBarcodeNmbr();?></td>
  </tr>
</table>
<br>
<table class="primary">
  <tr>
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr1"); ?>
    </td>	
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr6"); ?>
    </td>
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr2");?>
    </td>		
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr4"); ?>
    </td>
    <td class="primary" valign="top" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr3"); ?>
    </td>
    <td class="primary" valign="top" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr5"); ?>    </td>			
  </tr>
  <tr>
    <td class="primary" align="center">
      <?php echo $barcode ?>
    </td>
    <td class="primary" valign="top" >
      <?php echo toDDmmYYYY($copy->getDueBackDt());?>
    </td>	
    <td class="primary" valign="top" >
      <?php echo toDDmmYYYY($mbr->getInicio_sancion());?>
    </td>		
    <td class="primary" valign="top" >
      <?php echo toDDmmYYYY($mbr->getFecha_suspension());?>
    </td>
    <td class="primary" valign="top" >
      <?php printDomainDescription("tipo_sancion_dm",$mbr->getTipo_sancion_cd());?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $mbr->getCantidadDiasSuspension();?>
    </td>		
  </tr>
</table>
<br>
<table>
<tr><td class="noborder" valign="top" colspan="5">Firma.................................Aclaracion...........................</td></tr>
</table>
