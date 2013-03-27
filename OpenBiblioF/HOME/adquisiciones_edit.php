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
  $restrictInDemo = true;
  require_once("../shared/common.php");
//  require_once("../shared/logincheck.php");

  require_once("../classes/Adquisicion.php");
  require_once("../classes/AdquisicionQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../home/adquisicion.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $adq = new Adquisicion();
  $adq->setAdqid($_POST["adqid"]);
  $_POST["adqid"] = $adq->getAdqid();
  $adq->setConceptoCd($_POST["concepto_cd"]);
  $_POST["concepto_cd"] = $adq->getConceptoCd();  
  $adq->setTitle($_POST["title"]);
  $_POST["title"] = $adq->getTitle();
  $adq->setAuthor($_POST["author"]);
  $_POST["author"] = $adq->getAuthor();
  $adq->setIsbn($_POST["isbn"]);
  $_POST["isbn"] = $adq->getIsbn();
  $adq->setEdicionDt($_POST["edicion_dt"]);
  $_POST["edicion_dt"] = $adq->getEdicionDt();
  $adq->setEditorial($_POST["editorial"]);
  $_POST["editorial"] = $adq->getEditorial();
  $adq->setEjemplares($_POST["ejemplares"]);
  $_POST["ejemplares"] = $adq->getEjemplares();
  $adq->setLibraryId($_POST["libraryid"]);
  $_POST["libraryid"] = $adq->getLibraryId();
  $adq->setAreaCd($_POST["area_cd"]);
  $_POST["area_cd"] = $adq->getAreaCd();
  $adq->setMbrid($_POST["mbrid"]);
  $_POST["mbrid"] = $adq->getMbrid();
  $adq->setEstadoCd($_POST["estado_cd"]);
  $_POST["estado_cd"] = $adq->getEstadoCd();
  $adq->setObservacion($_POST["observacion"]);
  $_POST["observacion"] = $adq->getObservacion();
  
  $barcode_nmbr = $_POST["barcode_nmbr"];

  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $adqQ = new AdquisicionQuery();
  $adqQ->connect();
  if ($adqQ->errorOccurred()) {
    $adqQ->close();
    displayErrorPage($adqQ);
  }
  
  if (!$adq->validateData()) {
    $pageErrors["concepto_cd"] = $adq->getConceptoCdError();
    $pageErrors["title"] = $adq->getTitleError();
	$pageErrors["author"] = $adq->getAuthorError();
    $pageErrors["isbn"] = $adq->getIsbnError();	
    $pageErrors["ejemplares"] = $adq->getEjemplaresError();
    $pageErrors["libraryid"] = $adq->getLibraryIdError();
    $pageErrors["area_cd"] = $adq->getAreaCdError();
	$pageErrors["estado_cd"] = $adq->getEstadoCdError();
	$pageErrors["area_cd"] = $adq->getAreaCdError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../home/adquisiciones_edit_form.php?barcode_nmbr=".$barcode_nmbr);
    exit();
  }  
  
  if (!$adqQ->update($adq)) {
    $adqQ->close();
    displayErrorPage($adqQ);
  }
  $adqQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<? echo "Pedido de adquisición Nro: "; ?><?php echo $adq->getAdqid();?><? echo " , actualizado"; ?><br><br>
<a href="../home/adquisicion.php?barcode_nmbr=<? echo $barcode_nmbr;?>"><? echo "Volver a Pedidos de Adquisición"; ?></a>

<?php require_once("../shared/footer.php"); ?>
