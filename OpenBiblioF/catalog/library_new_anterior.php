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
  $nav = "librarys";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/Library.php");
  require_once("../classes/LibraryQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../catalog/library_new_form.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $lb = new Library();
  $lb->setDescription($_POST["description"]);
  $_POST["description"] = $lb->getDescription();
  $lb->setCode($_POST["code"]);
  $_POST["code"] = $lb->getCode();
echo"<h1>hola</h1>".$lb->getDescription()." ".$lb->getCode();
  if (!$lb->validateData())
  {
    $pageErrors["description"] = $lb->getDescriptionError();
    $pageErrors["code"] = $lb->getCodeError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../catalog/library_new_form.php");
    exit();
  }

  #**************************************************************************
  #*  Insert new domain table row
  #**************************************************************************
 /* $lbQ = new LibraryQuery();
  $lbQ->connect();
  if ($lbQ->errorOccurred()) {
    $lbQ->close();
    displayErrorPage($lbQ);
  }
  if (!$lbQ->insert("biblio_cod_library",$lb)) {
    $lbQ->close();
    displayErrorPage($lbQ);
  }
  $lbQ->close();*/

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
<? echo $loc->getText("catalogLibrary_delStart"); ?><?php echo $dm->getDescription();?><? echo $loc->getText("catalogLibrary_newAdded"); ?><br><br>
<a href="../catalog/library_list.php"><? echo $loc->getText("catalogLibrary_delReturn"); ?></a>

<?php require_once("../shared/footer.php"); ?>
