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
  $nav = "newcopy";
  $focus_form_name = "newCopyForm";
  $focus_form_field = "barcodeNmbr";

  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  $copyid = $_GET["copyid"];
  require_once("../shared/header.php");


?>


<?php echo $loc->getText("catalogFootnote",array("symbol"=>"<font>*</font class=\"small\">")); ?>


<form name="newCopyForm" method="POST" action="../catalog/biblio_copy_num_new.php">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo "Nuevos números de publicación"; ?>:
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
  <?php /*ini franco 06/07/05*/?>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo "Números"; ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("numeros",50,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
      <input type="button" onClick="parent.location='../catalog/biblio_copy_num_list.php?bibid=<?php echo $bibid;?>&copyid=<?php echo $copyid;?>'" value="<?php echo $loc->getText("catalogCancel"); ?>" class="button">
    </td>
  </tr>

</table>
<input type="hidden" name="bibid" value="<?php echo $bibid;?>">
<input type="hidden" name="copyid" value="<?php echo $copyid;?>">
</form>


<?php include("../shared/footer.php"); ?>
