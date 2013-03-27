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
  $nav = "checkin";
  $focus_form_name = "barcodesearch";
  $focus_form_field = "barcodeNmbr";

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  require_once("../classes/MemberQuery.php");
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  $barcode = $_GET["barcode"];
  $mbrid = $_GET["mbrid"];
  $holdBeginDt = $_GET["holdBeginDt"];
  
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
  
/*********************************************************/
/*  CHECKEA SI DEBE IMPRIMIR EL COMPROBANTE DE SANCION   */
/*********************************************************/
?>
<form name="sancion_shelving_cart" action="noaction">
<?
if(isset($_GET["sancionado"]))
   {
    $barcode=$_GET["barcode"];
	$mbrid=$_GET["mbrid_sancion"];
    echo "<input type='hidden' name='sancionado_barcode' value='$barcode'>";
	echo "<input type='hidden' name='sancionado_mbrid' value='$mbrid'>";
   }
?>
</form>

<!--*********************************************************/
/*  CHECKEA SI DEBE IMPRIMIR EL COMPROBANTE DE SANCION   */
/*********************************************************/ -->
<h1><?php echo $loc->getText("holdMessageHdr"); ?></h1>
<?php echo $loc->getText("holdMessageMsg1",array("barcode"=>$barcode,
                                                 "nombre"=>$mbr->getFirstName(),
												 "apellido"=>$mbr->getLastName(),
												 "dni"=>$mbr->getBarcodeNmbr(),
												 "fecha"=>toDDmmYYYY($holdBeginDt))); ?>
<br>
<br>	
<?php
  if (isset($_GET["msg"])){
    echo "<font class=\"error\">";
    echo $_GET["msg"]."</font>";
  }
?>												 
<br><br>
<a href="../circ/checkin_form.php"><?php echo $loc->getText("holdMessageMsg2"); ?></a>
<?php require_once("../shared/footer.php"); ?>
