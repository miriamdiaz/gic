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
  $nav = "newanalitica";
  //$focus_form_name = "newAnaliticaForm";
 // $focus_form_field = "barcodeNmbr";

  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
 
  require_once("../functions/errorFuncs.php");
  require_once("../catalog/inputFuncs.php");

  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  require_once("../shared/header.php");


?>


<?php echo $loc->getText("catalogFootnote",array("symbol"=>"<font>*</font class=\"small\">")); ?>


<form name="newAnaliticaForm" method="POST" action="../catalog/biblio_analitica_new.php">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo $loc->getText("biblioAnaliticaNewFormLabel"); ?>:
    </th>
  </tr>
  
    <td nowrap="true" class="primary" valign="top">
     <sup>*</sup><?php echo $loc->getText("biblioAnaliticaNewTitulo"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaTitulo",40,150,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioAnaliticaNewSubTitulo"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaSubTitulo",40,150,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioAnaliticaNewAutor"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaAutor",40,100,$postVars,$pageErrors); ?>
    </td>
  </tr>
  
  <tr>
    <td nowrap="true" class="primary" valign="top">
     <SUP>*</SUP><?php echo $loc->getText("biblioAnaliticaNewPaginacion"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaPaginacion",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>
  
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioAnaliticaNewMateria"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("anaMateria",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>

  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioAnaliticaUserCreador"); ?>:
    </td>
    <td valign="top" class="primary">
     <?php if(isset($postVars["user_name_creador"])){echo $postVars["user_name_creador"]; } 
              else echo $_SESSION["username"]?>
    </td>
  </tr>
  
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
      <input type="button" onClick="parent.location='../shared/biblio_view.php?bibid=<?php echo $bibid; ?>'" value="<?php echo $loc->getText("catalogCancel"); ?>" class="button">
    </td>
  </tr>

</table>
<input type="hidden" name="bibid" value="<?php echo $bibid;?>">
</form>


<?php include("../shared/footer.php"); ?>
