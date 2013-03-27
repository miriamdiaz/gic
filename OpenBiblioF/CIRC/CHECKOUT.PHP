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
  require_once("../shared/logincheck.php");
  
  //REQUIRE AGREGADO: Horacio Alvarez FECHA: 26-03-06
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioCopy.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../classes/BiblioStatusHist.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../classes/MemberAccountQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../classes/Localize.php");
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if(isset($_GET["barcodeNmbr"]))
    {
	$_POST["limiteSuperado"] = "";  
    $_POST["barcodeNmbr"] = $_GET["barcodeNmbr"];
    if(isset($_GET["mbrid"]))
       $_POST["mbrid"] = $_GET["mbrid"];  
    if(isset($_GET["classification"]))
       $_POST["classification"] = $_GET["classification"];
    if(isset($_GET["dias_para_devolucion"]))
       $_POST["dias_para_devolucion"] = $_GET["dias_para_devolucion"];	
	}
	
  
  if (count($_POST) == 0) {
    header("Location: ../circ/index.php");
    exit();
  }

  $barcode = trim($_POST["barcodeNmbr"]);
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
         $pageErrors["barcodeNmbr"] = $loc->getText("checkoutErr9");
         $postVars["barcodeNmbr"] = $barcode;
         $_SESSION["postVars"] = $postVars;
         $_SESSION["pageErrors"] = $pageErrors;
         header("Location: ../circ/mbr_view.php?mbrid=".$mbrid);
         exit();
        }
    }
  $mbrQ->close();    
  #****************************************************************************
  #*  FIN Valida la fecha de vto. del usuario alumno o externo 
  #****************************************************************************    
  
  
    
  $mbrClassification = trim($_POST["classification"]);
  //DOS LINEAS AGREGAGDAS Horacio Alvarez
  $dias_para_devolucion = trim($_POST["dias_para_devolucion"]);
  $limiteSuperado = trim($_POST["limiteSuperado"]);
  
  #****************************************************************************
  #*  Valida que el libro perteneza a esta Biblioteca
  #****************************************************************************
  $code=intval(substr($barcode,0,2));
  if (!in_array($code,$COD_LIBRARY) && !isset($_POST["inter"])) 
     {
      $pageErrors["barcodeNmbr"] = $loc->getText("checkoutErr8");
      $postVars["barcodeNmbr"] = $barcode;
      $_SESSION["postVars"] = $postVars;
      $_SESSION["pageErrors"] = $pageErrors;
      header("Location: ../circ/mbr_view.php?mbrid=".$mbrid);
      exit();
     }  

  #****************************************************************************
  #*  Make sure member does not have outstanding balance due
  #****************************************************************************
  if (OBIB_BLOCK_CHECKOUTS_WHEN_FINES_DUE) {
    $acctQ = new MemberAccountQuery();
    $acctQ->connect();
    if ($acctQ->errorOccurred()) {
      $acctQ->close();
      displayErrorPage($acctQ);
    }
    $balance = $acctQ->getBalance($mbrid);
    if ($acctQ->errorOccurred()) {
      $acctQ->close();
      displayErrorPage($acctQ);
    }
    $acctQ->close();
    if ($balance > 0) {
      $pageErrors["barcodeNmbr"] = $loc->getText("checkoutBalErr");
      $postVars["barcodeNmbr"] = $barcode;
      $_SESSION["postVars"] = $postVars;
      $_SESSION["pageErrors"] = $pageErrors;
      header("Location: ../circ/mbr_view.php?mbrid=".$mbrid);
      exit();
    }
  }

  #****************************************************************************
  #*  Edit input
  #****************************************************************************
  if (!ctypeAlnum(trim($barcode))) {
    $pageErrors["barcodeNmbr"] = $loc->getText("checkoutErr1");
    $postVars["barcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/mbr_view.php?mbrid=".$mbrid);
    exit();
  }

  #****************************************************************************
  #*  Read copy record
  #****************************************************************************
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
  #*  Edit results
  #****************************************************************************
  $foundError = false;
  if ($copyQ->getRowCount() == 0) {
    $foundError = true;
    $pageErrors["barcodeNmbr"] = $loc->getText("checkoutErr2");
  } else if ($copy->getStatusCd() == OBIB_STATUS_OUT) {
    // copy is already checked out
    $foundError = TRUE;
    $pageErrors["barcodeNmbr"] = $loc->getText("checkoutErr3",array("barcode"=>$barcode));
  } else {
    // check days due back
    // some collections will have days due back set to 0 so that those items can not be checked out.
    $daysDueBack = $copyQ->getDaysDueBack($copy);
    if ($copyQ->errorOccurred()) {
      $copyQ->close();
      displayErrorPage($copyQ);
    }
    if ($daysDueBack <= 0) {
      $foundError = true;
      $pageErrors["barcodeNmbr"] = $loc->getText("checkoutErr4",array("barcode"=>$barcode));
    } else {
	  //MODIFICADO POR HORACIO ALVAREZ 26-03-06
	  
      /* check to see if collection max has been reached
      $reachedLimit = $copyQ->hasReachedCheckoutLimit($mbrid,$mbrClassification,$copy->getBibid());
      if ($copyQ->errorOccurred()) {
        $copyQ->close();
        displayErrorPage($copyQ);
      }
	  
      if ($reachedLimit) {
        $foundError = TRUE;
        $pageErrors["barcodeNmbr"] = $loc->getText("checkoutErr6");
      }*/
	  if($limiteSuperado!="")
	    {
        $foundError = TRUE;
        $pageErrors["barcodeNmbr"] = "";
		}
    }
  }

  #**************************************************************************
  #*  return to member view if there are checkout errors to show
  #**************************************************************************
  if ($foundError == TRUE) {
    $copyQ->close();
    $postVars["barcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/mbr_view.php?mbrid=".$mbrid);
    exit();
  }

  #**************************************************************************
  #*  Show hold edit if bibliography is currently on hold and 
  #*  current member != first member in hold queue
  #**************************************************************************
  if ($copy->getStatusCd() == OBIB_STATUS_ON_HOLD) {
    // need to close copyQ connection so we can call hold functions
    $copyQ->close();
    // check copy hold queue
    $holdQ = new BiblioHoldQuery();
    $holdQ->connect();
    if ($holdQ->errorOccurred()) {
      $holdQ->close();
      displayErrorPage($holdQ);
    }
    $hold = $holdQ->getFirstHold($copy->getBibid(),$copy->getCopyid());
    if ($holdQ->errorOccurred()) {
      $holdQ->close();
      displayErrorPage($holdQ);
    }
    // make sure hold still exists.  if not continue on with checkout
    if ($holdQ->getRowCount() > 0) {
      if ($mbrid != $hold->getMbrid()) {
        // show error if member who placed hold is not current member
        $holdQ->close();
        $pageErrors["barcodeNmbr"] = $loc->getText("checkoutErr5",array("barcode"=>$barcode));
        $postVars["barcodeNmbr"] = $barcode;
        $_SESSION["postVars"] = $postVars;
        $_SESSION["pageErrors"] = $pageErrors;
        header("Location: ../circ/mbr_view.php?mbrid=".$mbrid);
        exit();
      } else {
        // need to remove hold and continue on to checkout
        $holdQ->delete($hold->getBibid(),$hold->getCopyid(),$hold->getHoldid());
        if ($holdQ->errorOccurred()) {
          $holdQ->close();
          displayErrorPage($holdQ);
        }
        $holdQ->close();
      }
    }
    // need to reestablish copyQ connection so we can update status
    $copyQ->connect();
    if ($copyQ->errorOccurred()) {
      $copyQ->close();
      displayErrorPage($copyQ);
    }
  }

  
  #***************************************************************************************
  #*  ACTUALIZA LA COPIA DEL MATERIAL, ANTES VALIDA QUE NO PRESTE PARA UN SABADO O DOMINGO
  #***************************************************************************************
  $copy->setStatusCd(OBIB_STATUS_OUT);
  $copy->setMbrid($_POST["mbrid"]);
  //$copy->setDueBackDt($daysDueBack);
  $hoy = date("Y-m-d");
  $timestamp_current = strtotime($hoy);
  $timestamp_future  = $timestamp_current + (60*60*24*$dias_para_devolucion);				   
  $newDueBackDt = date('Y-m-d', $timestamp_future);
  if(isSabado($newDueBackDt))
     $dias_para_devolucion = $dias_para_devolucion + 2;
  if(isDomingo($newDueBackDt))
     $dias_para_devolucion = $dias_para_devolucion + 1;	 
  $copy->setDueBackDt($dias_para_devolucion);//ahora no toma el valor default del tipo de coleccion, toma el valor elegido 
                                             //desde la tabla Tipo de Prestamo
  if (!$copyQ->update($copy,true)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  $copyQ->close();
  
  #****************************************************************************
  #*  Autor: Horacio Alvarez
  #*  fecha: 26-03-06
  #*  Descripcion: Incrementa el campo cantidad de prestamos actual del socio.
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
  $nuevaCantidad=$mbr->getCantidadPrestamos()+1;
  $mbr->setCantidadPrestamos($nuevaCantidad);
  if (!$mbrQ->update($mbr)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }  
  $mbrQ->close();    

  #**************************************************************************
  #*  Insert into biblio status history
  #**************************************************************************
  // we need to also insert into status history table
  $hist = new BiblioStatusHist();
  $hist->setBibid($copy->getBibid());
  $hist->setCopyid($copy->getCopyid());
  $hist->setStatusCd($copy->getStatusCd());
  $hist->setDueBackDt($copy->getDueBackDt());
  $hist->setMbrid($copy->getMbrid());
  //LINEA AGREAGADA: Horacio Alvarez
  $hist->setUserId($_SESSION["userid"]);

  $histQ = new BiblioStatusHistQuery();
  $histQ->connect();
  if ($histQ->errorOccurred()) {
    $histQ->close();
    displayErrorPage($histQ);
  }
  $histQ->insert($hist);
  if ($histQ->errorOccurred()) {
    $histQ->close();
    displayErrorPage($histQ);
  }
  $histQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Go back to member view
  #**************************************************************************
  header("Location: ../circ/mbr_view.php?mbrid=".$mbrid);
?>
