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
  $nav = "materials";
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
    header("Location: ../catalog/materials_new_form.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $dm = new Dm();
  $dm->setDescription($_POST["description"]);
  $_POST["description"] = $dm->getDescription();
  $path="../images/".$HTTP_POST_FILES["imageFile"]["name"];
  $dm->setImageFile($path);
  copy($HTTP_POST_FILES['imageFile']['tmp_name'], $path);

  if (!$dm->validateData()) {
    $pageErrors["description"] = $dm->getDescriptionError();
    $pageErrors["adultCheckoutLimit"] = $dm->getAdultCheckoutLimitError();
    $pageErrors["juvenileCheckoutLimit"] = $dm->getJuvenileCheckoutLimitError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../catalog/materials_new_form.php");
    exit();
  }

  #**************************************************************************
  #*  Insert new domain table row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  if (!$dmQ->insert("material_type_dm",$dm)) {
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
<? echo $loc->getText("admin_materials_delMaterialType"); ?><?php echo $dm->getDescription();?><? echo $loc->getText("admin_materials_newEnd"); ?><br><br>
<a href="../catalog/materials_list.php"><? echo $loc->getText("admin_materials_Return"); ?></a>

<?php require_once("../shared/footer.php"); ?>
