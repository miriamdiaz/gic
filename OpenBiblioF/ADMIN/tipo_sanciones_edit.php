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
  $nav = "tipo_sanciones";
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
    header("Location: ../admin/tipo_sanciones_list.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $dm = new Dm();
  $dm->setCode($_POST["code"]);
  $_POST["code"] = $dm->getCode();
  $dm->setDescription($_POST["description"]);
  $_POST["description"] = $dm->getDescription();
  $dm->setDias_sancion($_POST["dias_sancion"]);
  $_POST["dias_sancion"] = $dm->getDias_sancion();
  $dm->setAplica_nueva_en($_POST["aplica_nueva_en"]);
  $_POST["aplica_nueva_en"] = $dm->getAplica_nueva_en();  

  if (!$dm->validateData()) {
    $pageErrors["description"] = $dm->getDescriptionError();
    $pageErrors["dias_sancion"] = $dm->getDias_sancionError();
	$pageErrors["aplica_nueva_en"] = $dm->getAplica_nueva_enError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/tipo_sanciones_edit_form.php");
    exit();
  }

  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  if (!$dmQ->update("tipo_sancion_dm",$dm)) {
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
<? echo $loc->getText("adminTipoSanciones_delStart"); ?><?php echo $dm->getDescription();?><? echo $loc->getText("adminTipoSanciones_editEnd"); ?><br><br>
<a href="../admin/tipo_sanciones_list.php"><? echo $loc->getText("adminTipoSanciones_delReturn"); ?></a>

<?php require_once("../shared/footer.php"); ?>
