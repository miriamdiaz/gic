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
  $mbrid = $_GET["mbrid"];
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".stripslashes($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }

  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect("mbr_classify_dm");
  $mbrClassifyDm = $dmQ->fetchRows();
  $dmQ->execSelect("material_type_dm");
  $materialTypeDm = $dmQ->fetchRows();
  // reseting row to top of same result set to get image_file.  This avoids having to do another select.
  $dmQ->resetResult();
  $materialImageFiles = $dmQ->fetchRows("image_file");
  $dmQ->close();

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
<title>Préstamos de <?php echo $mbr->getLastFirstName();?></title>

<link href="../css/style_checkout.css" rel="stylesheet" type="text/css">
<script defer>
function viewinit() {
  if (!factory.object) {
  return
  } else {
//  factory.printing.header = ""
  factory.printing.footer = ""
  factory.printing.portrait = true
  }
}
</script>
</head>
<body bgcolor="<?php echo OBIB_PRIMARY_BG;?>" topmargin="5" bottommargin="5" leftmargin="5" rightmargin="5" marginheight="5" marginwidth="5" onLoad="self.focus();viewinit();self.print();">

<!-- MeadCo ScriptX Control -->
<object id="factory" style="display:none" viewastext
classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814"
codebase="http://www.meadroid.com/scriptx/smsx.cab#Version=6,2,433,70">
</object>

<font class="primary">

<!-- ************COMIENZO DE IMPRESION ORIGINAL*****************-->
<table class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
<!--    <td width="100%" class="noborder" valign="top">
      <h1><?php //echo $loc->getText("mbrPrintCheckoutsTitle",array("mbrName"=>$mbr->getFirstLastName())); ?><?php //echo $loc->getText("mbrPrintCheckoutsOriginal"); ?></h1>
    </td>-->
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
    <td class="noborder" valign="top"><?php echo $mbr->getLastFirstName();?></td>
  </tr>
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr3");?></td>
    <td class="noborder" valign="top"><?php echo $mbr->getBarcodeNmbr();?></td>
  </tr>
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr4");?></td>
    <td class="noborder" valign="top"><?php echo $mbrClassifyDm[$mbr->getClassification()];?></td>
  </tr>
  <tr> 
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr6");?></td>
    <th class="rpt" valign="top"><?php echo $loc->getText("mbrPrintCheckoutsLeyendaSancion");?></th>
  </tr>    
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr5");?></td>
    <td class="noborder" valign="top"><?php printDomainDescription("tipo_sancion_dm",$mbr->getTipo_sancion_cd());
	                                        if($mbr->getTipo_sancion_cd()>0) echo " al ".$mbr->getInicio_sancionDDmmYYYY();
	                                    ?></td>
  </tr>  
</table>
<br>
<table class="primary">
  <tr>
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr1"); ?>
    </td>
<!--    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php //print $loc->getText("mbrViewOutHdr2"); ?>
    </td> -->
	<!--
	Cabecera agregada: Horacio Alvarez 
	Fecha: 01-04-06
	-->	
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr3"); ?>
    </td>	
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr4"); ?>
    </td>
<!--    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php //print $loc->getText("mbrViewOutHdr5"); ?>
    </td>-->
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr6"); ?>
    </td>
<!--    <td class="primary" valign="top" align="left">
      <?php //print $loc->getText("mbrViewOutHdr7"); ?>
    </td>-->
	<!--
	Cabecera agregada (Usuario): Horacio Alvarez 
	Fecha: 01-04-06
	-->
    <td class="primary" valign="top" align="left">
      <?php print $loc->getText("mbrViewOutHdr8"); ?>
    </td>		
  </tr>

<?php
  #****************************************************************************
  #*  Search database for BiblioStatus data
  #****************************************************************************
  $biblioQ = new BiblioSearchQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->query(OBIB_STATUS_OUT,$mbrid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if ($biblioQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="6">
      <?php print $loc->getText("mbrViewNoCheckouts"); ?>
    </td>
  </tr>
<?php
  } else {
    while ($biblio = $biblioQ->fetchRow()) {
	if(isset($_GET[$biblio->getBarcodeNmbr()]))//if agregado  para comprobar que el prestamo fue seleccionado desde la pantalla anterior.
	{
?>
  <tr>
    <td class="primary" valign="top" nowrap>
	<!-- AUTOR: Horacio Alvarez
	     DESCRIPCION: Saco la hora de la fecha
		 -->
      <?php echo toDDmmYYYY(substr($biblio->getStatusBeginDt(),0,10));?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $biblio->getBarcodeNmbr();?>
    </td>	
    <td class="primary" valign="top" >
      <?php echo $biblio->getTitle();?>
    </td>
<!--    <td class="primary" valign="top" >
      <?php //echo $biblio->getAuthor();?>
    </td>-->
    <td class="primary" valign="top" nowrap="yes">
      <?php echo toDDmmYYYY($biblio->getDueBackDt());?>
	  <br><br><br>
    </td>
<!--    <td class="primary" valign="top" >
      <?php //echo $biblio->getDaysLate();?>
    </td>-->
	<?
	/**
	Autor: Horacio Alvarez
	Fecha: 01-04-06
	Descripcion: Agregado para obtener los datos del usuario que realizo el prestamo
	*/
    $staffQ = new StaffQuery();
    $staffQ->connect();
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ);
    }
    $staffQ->execSelect($biblio->getUserId());
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ); 	
	  }
    $staff = $staffQ->fetchStaff(); 	
	?>	
    <td class="primary" valign="top" >
      <?php echo $staff->getLastName();?>
    </td>	
  </tr>
<?php
    }
	}
  }
  //$biblioQ->close();
?>
</table>
<br><br>
<table>
<tr><td class="noborder" valign="top" colspan="5">Firma.................................Aclaración...........................</td></tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<!-- ************FIN DE IMPRESION ORIGINAL*****************-->

<!-- ************COMIENZO DE IMPRESION DUPLICADA*****************-->
<br>
<table class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr> 
<!--    <td width="100%" class="noborder" valign="top"> 
	<h1><?php //echo $loc->getText("mbrPrintCheckoutsTitle",array("mbrName"=>$mbr->getFirstLastName())); ?><?php //echo $loc->getText("mbrPrintCheckoutsDuplicado"); ?></h1>
	</td>-->
    <td class="noborder" valign="top" nowrap="yes"><a href="javascript:window.close()"><font class="small"><?php //echo $loc->getText("mbrPrintCloseWindow"); ?></font></a>&nbsp;&nbsp;</td>
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
    <td class="noborder" valign="top"><?php echo $mbr->getLastFirstName();?></td>
  </tr>
  <tr> 
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr3");?></td>
    <td class="noborder" valign="top"><?php echo $mbr->getBarcodeNmbr();?></td>
  </tr>
  <tr> 
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr4");?></td>
    <td class="noborder" valign="top"><?php echo $mbrClassifyDm[$mbr->getClassification()];?></td>
  </tr>
  <tr> 
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr6");?></td>
    <th class="rpt" valign="top"><?php echo $loc->getText("mbrPrintCheckoutsLeyendaSancion");?></th>
  </tr>  
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr5");?></td>
    <td class="noborder" valign="top"><?php printDomainDescription("tipo_sancion_dm",$mbr->getTipo_sancion_cd());
	                                        if($mbr->getTipo_sancion_cd()>0) echo " al ".$mbr->getInicio_sancionDDmmYYYY();?></td>
  </tr>    
</table>
<br>
<table class="primary">
  <tr> 
    <td class="primary" valign="top" nowrap="yes" align="left"> <?php print $loc->getText("mbrViewOutHdr1"); ?> 
    </td>
    <!--    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php //print $loc->getText("mbrViewOutHdr2"); ?> --> 
    <!--
	Cabecera agregada: Horacio Alvarez 
	Fecha: 01-04-06
	-->
    <td class="primary" valign="top" nowrap="yes" align="left"> <?php print $loc->getText("mbrViewOutHdr3"); ?> 
    </td>
    <td class="primary" valign="top" nowrap="yes" align="left"> <?php print $loc->getText("mbrViewOutHdr4"); ?> 
    </td>
    <!--    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php //print $loc->getText("mbrViewOutHdr5"); ?> --> 
    <td class="primary" valign="top" nowrap="yes" align="left"> <?php print $loc->getText("mbrViewOutHdr6"); ?> 
    </td>
    <!--    <td class="primary" valign="top" align="left">
      <?php //print $loc->getText("mbrViewOutHdr7"); ?> --> 
    <!--
	Cabecera agregada (Usuario): Horacio Alvarez 
	Fecha: 01-04-06
	-->
    <td class="primary" valign="top" align="left"> <?php print $loc->getText("mbrViewOutHdr8"); ?> 
    </td>
  </tr>
  <?php
  if (!$biblioQ->query(OBIB_STATUS_OUT,$mbrid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if ($biblioQ->getRowCount() == 0) {
?>
  <tr> 
    <td class="primary" align="center" colspan="6"> <?php print $loc->getText("mbrViewNoCheckouts"); ?> 
    </td>
  </tr>
  <?php
  } else {
    while ($biblio = $biblioQ->fetchRow()) {
	if(isset($_GET[$biblio->getBarcodeNmbr()]))//if agregado  para comprobar que el prestamo fue seleccionado desde la pantalla anterior.
	{	
?>
  <tr> 
    <td class="primary" valign="top" nowrap> 
      <!-- AUTOR: Horacio Alvarez
	     DESCRIPCION: Saco la hora de la fecha
		 -->
      <?php echo toDDmmYYYY(substr($biblio->getStatusBeginDt(),0,10));?>
    <td class="primary" valign="top" > <?php echo $biblio->getBarcodeNmbr();?> 
    </td>
    <td class="primary" valign="top" > <?php echo $biblio->getTitle();?> </td>
    <!--    <td class="primary" valign="top" >
      <?php //echo $biblio->getAuthor();?> --> 
    <td class="primary" valign="top" nowrap="yes"> <?php echo toDDmmYYYY($biblio->getDueBackDt());?> 
	</td>
    <!--    <td class="primary" valign="top" >
      <?php //echo $biblio->getDaysLate();?> --> 
    <?
    $staffQ->execSelect($biblio->getUserId());
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ); 	
	  }
    $staff = $staffQ->fetchStaff(); 	
	?>
    <td class="primary" valign="top" > <?php echo $staff->getLastName();?> </td>
  </tr>
  <?php
    }
	}
  }
  $biblioQ->close();
?>
</table>
<br><br>
<table>
<tr><td class="noborder" valign="top" colspan="5">Firma.................................Aclaración...........................</td></tr>
</table>
<p>&nbsp;</p>
