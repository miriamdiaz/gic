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

  $tab = "cataloging";
  $nav = "view";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/BiblioAnalitica.php");
  require_once("../classes/BiblioAnaliticaQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to search if none found.
  #****************************************************************************
//  echo "<h1> entro...</h1>";
  if (count($_POST) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }
  $bibid = $_POST["bibid"];
  $anaid = $_POST["anaid"];

  #****************************************************************************
  #*  Ready copy record
  #****************************************************************************
  $anaQ = new BiblioAnaliticaQuery();
  $anaQ->connect();
  if ($anaQ->errorOccurred()) 
  {
    $anaQ->close();
    displayErrorPage($anaQ);
  }
  if (!$ana = $anaQ->query($bibid,$anaid)) 
  {
   //         echo "<h1>  error</h1>";
    $anaQ->close();
    displayErrorPage($anaQ);
  }


  #****************************************************************************
  #*  Validate data
  #****************************************************************************
 // echo "<h1> hasta q funca</h1>";
  $ana->setTitulo($_POST["anaTitulo"]);
  $_POST["anaTitulo"] = $ana->getAnaliticaTitulo();
  $ana->setAutor($_POST["anaAutor"]);
  $_POST["anaAutor"] = $ana->getAnaliticaAutor();
  $ana->setPaginacion($_POST["anaPaginacion"]);
  $_POST["anaPaginacion"] = $ana->getAnaliticaPaginacion();
  $ana->setUserCreador($_POST["anaUser"]);
  $_POST["anaUser"]= $ana->getUserCreador();
  //echo "<h1>".$_POST["anaUser"]."</h1>";
  $ana->setMateria($_POST["anaMateria"]);
  $_POST["anaMateria"]= $ana->getAnaliticaMateria();
  $ana->setSubTitulo($_POST["anaSubTitulo"]);
  $_POST["anaSubTitulo"] = $ana->getAnaliticaSubTitulo();
//  echo "<h1> ahora por aca</h1>";
  $validData = $ana->validateData();
  if (!$validData) {
    $anaQ->close();
    $pageErrors["anaTitulo"] = $ana->getAnaliticaTituloError();
	//$pageErrors["anaAutor"] = $ana->getAnaliticaAutorError();
    $pageErrors["anaPaginacion"] = $ana->getAnaliticaPaginacionError();
// echo "<h1>user  ".$_POST["anaUser"]."</h1>";
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../catalog/biblio_analitica_edit_form.php");
    exit();
  }
  //echo "<h1> validado</h1>";
  #**************************************************************************
  #*  Edit bibliography copy
  #**************************************************************************
  if (!$anaQ->update($ana)) 
  {
    $anaQ->close();
    if ($anaQ->getDbErrno() == "") 
	{
	//  echo "<h1> error</h1>";
//      $pageErrors["barcodeNmbr"] = $anaQ->getError();
      $_SESSION["postVars"] = $_POST;
      $_SESSION["pageErrors"] = $pageErrors;
      header("Location: ../catalog/biblio_analitica_edit_form.php");
      exit();
    }
	else 
	{
      displayErrorPage($anaQ);
    }
  }
  $anaQ->close();
  //echo "<h1> actualizado</h1>";
  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  $msg = $loc->getText("biblioAnaliticaEditSuccess");
  $msg = urlencode($msg);
  header("Location: ../shared/biblio_view.php?bibid=".$bibid."&msg=".$msg);
  exit();
?>
