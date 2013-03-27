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
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../catalog/biblio_new_form.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $bibid=$_POST["bibid"];
  $analitica = new BiblioAnalitica();
  $analitica->setBibid($bibid);
  $analitica->setTitulo($_POST["anaTitulo"]);
  $_POST["anaTitulo"] = $analitica->getAnaliticaTitulo();
  $analitica->setAutor($_POST["anaAutor"]);
  $_POST["anaAutor"] = $analitica->getAnaliticaAutor();
  $analitica->setPaginacion($_POST["anaPaginacion"]);
  $_POST["anaPaginacion"] = $analitica->getAnaliticaPaginacion();
  $analitica->setMateria($_POST["anaMateria"]);
  $_POST["anaMateria"] = $analitica->getAnaliticaMateria();
  $analitica->setUserCreador($_SESSION["userid"]);
  $_POST["usuario"]=$analitica->getUserCreador();
  $analitica->setSubTitulo($_POST["anaSubTitulo"]);
  $_POST["anaSubTitulo"] = $analitica->getAnaliticaSubTitulo();
  
  $validData = $analitica->validateData();
  if (!$validData) {
    $pageErrors["anaTitulo"] = $analitica->getAnaliticaTituloError();
    //$pageErrors["anaAutor"] = $analitica->getAnaliticaAutorError();
    $pageErrors["anaPaginacion"] = $analitica->getAnaliticaPaginacionError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../catalog/biblio_analitica_new_form.php?bibid=".$bibid);
    exit();
  }

  #**************************************************************************
  #*  Insert new bibliography copy
  #**************************************************************************
  $analiticaQ = new BiblioAnaliticaQuery();
  $analiticaQ->connect();
  if ($analiticaQ->errorOccurred()) {
    $analiticaQ->close();
    displayErrorPage($analiticaQ);
  }
  if (!$analiticaQ->insert($analitica)) 
  {
    $analiticaQ->close();
    displayErrorPage($analiticaQ);
    
  }
  $analiticaQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  $msg = $loc->getText("biblioAnaliticaNewSuccess");
  $msg = urlencode($msg);
  header("Location: ../shared/biblio_view.php?bibid=".$bibid."&msg=".$msg);
  exit();
?>
