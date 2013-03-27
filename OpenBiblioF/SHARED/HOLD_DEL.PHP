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

  #****************************************************************************
  #*  Checking for get vars.
  #****************************************************************************
  $bibid = $_GET["bibid"];
  $copyid = $_GET["copyid"];
  $holdid = $_GET["holdid"];
  $mbrid = $_GET["mbrid"];
  if ($mbrid == "") {
    $tab = "cataloging";
    $nav = "holds";
    $returnNav = "../catalog/biblio_hold_list.php?bibid=".$bibid;
  } else {
    $tab = "circulation";
    $nav = "view";
    $returnNav = "../circ/mbr_view.php?mbrid=".$mbrid;
  }
  $restrictInDemo = TRUE;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  require_once("../classes/MemberQuery.php");
  //Agrego el siguiente require: Horacio Alvarez Fecha: 17-04-06
  require_once("../classes/BiblioCopyQuery.php");
  $loc = new Localize(OBIB_LOCALE,"shared");

  #**************************************************************************
  #*  Delete hold
  #**************************************************************************
  // we need to also insert into status history table
  $holdQ = new BiblioHoldQuery();
  $holdQ->connect();
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  $rc = $holdQ->delete($bibid,$copyid,$holdid);
  if (!$rc) {
    $holdQ->close();
    displayErrorPage($copyQ);
  }
  $holdQ->close();
  
    #****************************************************************************
  #*  Autor: Horacio Alvarez
  #*  fecha: 26-03-06
  #*  Descripcion: Incrementa el campo cantidad de reservas actual del socio.
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
  $nuevaCantidad=$mbr->getCantidadReservas()-1;
  $mbr->setCantidadReservas($nuevaCantidad);
  if (!$mbrQ->update($mbr)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }  
  $mbrQ->close();      

  #**************************************************************************
  #*  Go back to member view
  #**************************************************************************
  /**
  Autor: Horacio Alvarez
  Fecha: 17-04-06
  Descripcion: Se agrega el siguiente IF para saber si viene directamente desde eliminar
  la reserva, o si se debe eliminar y prestar la reserva. Si entre por prestar, 
  esto solo elimina la reserva normalmente, y setea en el postVars el codigo de barra,
  para que luego mbr_view.php lo coloque automaticamente en el input para ser prestado
  */
     $copyQ = new BiblioCopyQuery();
     $copyQ->connect();
     if ($copyQ->errorOccurred()) {
        $copyQ->close();
        displayErrorPage($copyQ);
     }
     if (!$copy = $copyQ->query($bibid, $copyid)) {
        $copyQ->close();
        displayErrorPage($copyQ);
     }	   
  if(isset($_GET["prestar"]))//presta
     {
	 $postVars["barcodeNmbr"]=$copy->getBarcodeNmbr();
	 $_SESSION["postVars"] = $postVars;
     header("Location: ".$returnNav);
	 }
  else//elimina
     {
	 if($copy->getStatusCd()=="hld")
	    {
	     $copy->setStatusCd("in");
	     $copy->setMbrid("");
	     $copyQ->update($copy);
		}
     $msg = $loc->getText("holdDelSuccess");
     $msg = urlencode($msg);
     header("Location: ".$returnNav."&msg=".$msg);
	 }
?>
