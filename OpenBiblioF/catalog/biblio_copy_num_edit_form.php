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

  session_cache_limiter(null);

  $tab = "cataloging";
  $nav = "editcopy";
  $focus_form_name = "editCopyForm";
  $focus_form_field = "barcodeNmbr";
  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioCopyNum.php");
  require_once("../classes/BiblioCopyNumQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  
  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  if (isset($_GET["id"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);
    #****************************************************************************
    #*  Retrieving get var
    #****************************************************************************
    $id = $_GET["id"];

    #****************************************************************************
    #*  Read copy information
    #****************************************************************************
    $copyQ = new BiblioCopyNumQuery();
    $copyQ->connect();
    if ($copyQ->errorOccurred()) {
      $copyQ->close();
      displayErrorPage($copyQ);
    }
    if (!$copy = $copyQ->query($id)) {
      $copyQ->close();
      displayErrorPage($copyQ);
    }
	$postVars["id"] = $copy->getId();
    $postVars["bibid"] = $copy->getBibid();
    $postVars["copyid"] = $copy->getCopyid();
    $postVars["anio"] = $copy->getAnio();
    $postVars["estado"] = $copy->getEstado();
    $postVars["numeros"] = $copy->getNumeros();

  } else {
    #**************************************************************************
    #*  load up post vars
    #**************************************************************************
    require("../shared/get_form_vars.php");
    $bibid = $postVars["bibid"];
    $copyid = $postVars["copyid"];
  }

  require_once("../shared/header.php");
?>


<?php echo $loc->getText("catalogFootnote",array("symbol"=>"<font class=\"small\">*</font>")); ?>


<form name="editCopyForm" method="POST" action="../catalog/biblio_copy_num_edit.php">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo "Editar números de publicación periódica"; ?>:
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo "Año"; ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anio",50,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo "Volumen"; ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("estado",50,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo "Números"; ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("numeros",50,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <input type="hidden" name="id" value="<?=$id?>">
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
      <input type="button" onClick="parent.location='../catalog/biblio_copy_num_list.php?bibid=<?php echo $copy->getBibid(); ?>&copyid=<?php echo $copy->getCopyid(); ?>'" value="<?php echo $loc->getText("catalogCancel"); ?>" class="button" >
    </td>
  </tr>

</table>
</form>


<?php include("../shared/footer.php"); ?>
