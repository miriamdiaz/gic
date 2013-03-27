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

  require_once("../classes/BiblioCopyNum.php");
  require_once("../classes/BiblioCopyNumQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../catalog/biblio_copy_num_new_form.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $bibid=$_POST["bibid"];
  $copyid=$_POST["copyid"];
  $copy = new BiblioCopyNum();
  $copy->setBibid($bibid);
  $copy->setCopyid($copyid);
  $copy->setAnio($_POST["anio"]);
  $_POST["anio"] = $copy->getAnio();
  $copy->setEstado($_POST["estado"]);
  $_POST["estado"] = $copy->getEstado();
  $copy->setNumeros($_POST["numeros"]);
  $_POST["numeros"] = $copy->getNumeros();
  
  $validData = $copy->validateData();
  if (!$validData) {
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../catalog/biblio_copy_num_new_form.php?bibid=".$bibid."&copyid=".$copyid);
    exit();
  }

  #**************************************************************************
  #*  Insert new bibliography copy
  #**************************************************************************
  $copyQ = new BiblioCopyNumQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copyQ->insert($copy)) {
    $copyQ->close();
    if ($copyQ->getDbErrno() == "") {
      $pageErrors["anio"] = $copyQ->getError();
      $_SESSION["postVars"] = $_POST;
      $_SESSION["pageErrors"] = $pageErrors;
      header("Location: ../catalog/biblio_copy_num_new_form.php?bibid=".$bibid);
      exit();
    } else {
      displayErrorPage($copyQ);
    }
  }
  $copyQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  $msg = "Registro creado satisfactoriamente";
  $msg = urlencode($msg);
  header("Location: ../catalog/biblio_copy_num_list.php?bibid=".$copy->getBibid()."&copyid=".$copy->getCopyid()."&msg=".$msg);
  exit();
?>
