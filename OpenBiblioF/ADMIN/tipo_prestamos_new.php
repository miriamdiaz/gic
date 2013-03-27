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

  $tab = "admin";
  $nav = "tipo_prestamos";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../admin/tipo_prestamos_new_form.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  /**
  Autor: Horacio Alvarez
  Modificado: 23-03-06
  Descripcion: Se mueve la porcion de codigo donde se declara un nuevo "objeto" DmQuery() hacia arriba.
  Se le setea el nombre de la tabla con la que trabaja este php.
  Se llama a una nueva funcion de validacion de campos agregada a la clase Dm, la cual recibe como parametro
  el "objeto" DmQuery. Esto se hace con el objetivo de poder validar duplicacion de datos antes de realizar
  el insert en la base de datos.
  */
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->_tableNm="tipo_prestamo_dm";

  $dm = new Dm();
  $dm->setDescription($_POST["description"]);
  $_POST["description"] = $dm->getDescription();
  $dm->setValue($_POST["dias_devolucion"]);
  $_POST["dias_devolucion"] = $dm->getValue();
  if (!$dm->validateDataWithDmQquery($dmQ))
     {
      $pageErrors["description"] = $dm->getDescriptionError();
      $pageErrors["dias_devolucion"] = $dm->getValueError();
      $_SESSION["postVars"] = $_POST;
      $_SESSION["pageErrors"] = $pageErrors;
      header("Location: ../admin/tipo_prestamos_new_form.php");
      exit();
    }

  #**************************************************************************
  #*  Insert new domain table row
  #**************************************************************************
/*  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }*/
  if (!$dmQ->insert("tipo_prestamo_dm",$dm)) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->close();

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
<? echo $loc->getText("adminTipoPrestamos_delStart"); ?><?php echo $dm->getDescription();?><? echo $loc->getText("adminTipoPrestamos_newAdded"); ?><br><br>
<a href="../admin/tipo_prestamos_list.php"><? echo $loc->getText("adminTipoPrestamos_delReturn"); ?></a>

<?php require_once("../shared/footer.php"); ?>
