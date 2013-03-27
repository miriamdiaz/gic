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
  $restrictInDemo = true;
  require_once("../shared/common.php");
//  require_once("../shared/logincheck.php");

  require_once("../classes/BiblioHold.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
 //REQUIRE AGREGADO: Horacio Alvarez FECHA: 08-04-06
  require_once("../classes/MemberQuery.php");
  $loc = new Localize(OBIB_LOCALE,$tab);


  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../home/index.php");
    exit();
  }
  $barcode = trim($_POST["holdBarcodeNmbr"]);
  $mbrid = trim($_POST["mbrid"]);
  
  #****************************************************************************
  #*  Valida la fecha de vto. del usuario alumno o externo 
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
  
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect("mbr_classify_dm");
  $mbrClassifyDm = $dmQ->fetchRows(); 
  $classification = $mbrClassifyDm[$mbr->getClassification()]; 
  if(trim($classification)=="ALUMNO" || trim($classification)=="EXTERNO")
    {
     $fechaVto=$mbr->getFechaVto();
     if ($fechaVto < date("Y-m-d")) 
        {
         $pageErrors["holdBarcodeNmbr"] = $loc->getText("checkoutErr9");
         $postVars["holdBarcodeNmbr"] = $barcode;
         $_SESSION["postVars"] = $postVars;
         $_SESSION["pageErrors"] = $pageErrors;
		 die($loc->getText("checkoutErr9"));
         header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
         exit($loc->getText("checkoutErr9"));
        }
    }
  $mbrQ->close();    
  #****************************************************************************
  #*  FIN Valida la fecha de vto. del usuario alumno o externo 
  #****************************************************************************      

  #****************************************************************************
  #*  Edit input
  #****************************************************************************
/*  if (!is_numeric($barcode)) {
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr1");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
    exit();
  }*/

  #****************************************************************************
  #*  Valida que el libro perteneza a esta Biblioteca
  #****************************************************************************
  $code=intval(substr($barcode,0,2));
  if (!in_array($code,$COD_LIBRARY)) 
     {
      $pageErrors["holdBarcodeNmbr"] = $loc->getText("checkoutErr8");
      $postVars["holdBarcodeNmbr"] = $barcode;
      $_SESSION["postVars"] = $postVars;
      $_SESSION["pageErrors"] = $pageErrors;
	  die($loc->getText("checkoutErr8"));	  
      header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
      exit();
     }  
	 
  $copyQ = new BiblioCopyQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  $copy = $copyQ->queryByBarcode($barcode);
  
  
  
  #****************************************************************************
  #*  Valida si el libro ya fue reservado por este socio
  #****************************************************************************
  $holdQ = new BiblioHoldQuery();
  $holdQ->connect();
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  
  #****************************************************************************
  #*  Valida si el libro ya fue reservado por cualquier socio
  #****************************************************************************
  $yaReservado=true;
  if ($holdQ->getFirstHold($copy->getBibid(),$copy->getCopyid())==FALSE)
      $yaReservado=false;
	  
  if (!$holdQ->queryByMbrid($mbrid)) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  #****************************************************************************
  #*  Valida si el libro ya fue reservado por este socio
  #****************************************************************************  
  $yaReservadoPorSocio=false;
  while ($hold = $holdQ->fetchRow()) {
      if($hold->getBarcodeNmbr()==$barcode)
	    {
	     $yaReservadoPorSocio=true;
		 break;
		}
  }
  #****************************************************************************
  #*  END Valida si el libro ya fue reservado por este socio
  #****************************************************************************	
	  
  
  if (!$copy) {
    $copyQ->close();
    displayErrorPage($copyQ);
    }
  else if($yaReservado){
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr6");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
    exit();    
  }	
  else if($yaReservadoPorSocio){
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr5");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
	die($loc->getText("placeHoldErr5"));
    header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
    exit();    
  } else if (!is_a($copy, 'BiblioCopy')) {
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr1");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
	die($loc->getText("placeHoldErr1"));
    header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
    exit();
  } else if ($copy->getStatusCd() == OBIB_STATUS_OUT
             and $copy->getMbrid() == $mbrid) {
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr3");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
	die($loc->getText("placeHoldErr3"));
    header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
    exit();
  } else if($copy->getStatusCd() == OBIB_STATUS_IN){
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr4");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
	die($loc->getText("placeHoldErr4"));
    header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
    exit();    
  }/* else if($copy->getStatusCd() == OBIB_STATUS_ON_HOLD){
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr5");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
    exit();    
  }     */

  #**************************************************************************
  #*  Insert hold
  #**************************************************************************
  // we need to also insert into status history table
  $holdQ = new BiblioHoldQuery();
  $holdQ->connect();
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  $rc = $holdQ->insert($mbrid,$barcode, $copy->getDueBackDt(), 42); //harcodeado
  if (!$rc) {
    $holdQ->close();
    displayErrorPage($holdQ);
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
  $nuevaCantidad=$mbr->getCantidadReservas()+1;
  $mbr->setCantidadReservas($nuevaCantidad);
  if (!$mbrQ->update($mbr)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }  
  $mbrQ->close();    

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Go back to member view
  #**************************************************************************
  header("Location: ../home/info_usuarios.php?dni=".$mbr->getBarcodeNmbr());
?>
