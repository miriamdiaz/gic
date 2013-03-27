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

  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelectWithStats("tipo_prestamo_dm");
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }

?>
<a href="../admin/tipo_prestamos_new_form.php?reset=Y"><? echo $loc->getText("adminTipoPrestamos_listAddNewTipoPrestamo"); ?></a><br>
<h1><? echo $loc->getText("adminTipoPrestamos_listTipoPrestamos"); ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top"><? echo $loc->getText("adminTipoPrestamos_listFunction"); ?>
    </th>
    <th valign="top">
      <? echo $loc->getText("adminTipoPrestamos_listDescription"); ?>
    </th>
    <th valign="top">
      <? echo $loc->getText("adminTipoPrestamos_listDiasPrestamo"); ?>
    </th>
  </tr>
  <?php
    $row_class = "primary";
    while ($dm = $dmQ->fetchRow()) {
  ?>
  <tr>
    <td valign="top" class="<?php echo $row_class;?>">
      <a href="../admin/tipo_prestamos_edit_form.php?code=<?php echo $dm->getCode();?>" class="<?php echo $row_class;?>"><? echo $loc->getText("adminCollections_listEdit"); ?></a>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
      <?php if ($dm->getCount() == 0) { ?>
        <a href="../admin/tipo_prestamos_del_confirm.php?code=<?php echo $dm->getCode();?>&desc=<?php echo urlencode($dm->getDescription());?>" class="<?php echo $row_class;?>"><? echo $loc->getText("adminCollections_listDel"); ?></a>
      <?php } else { echo "borrar"; }?>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
      <?php echo $dm->getDescription();?>
    </td>
    <td valign="top" align="center" class="<?php echo $row_class;?>">
      <?php echo $dm->getValue();?>
    </td>
  </tr>
  <?php
      # swap row color
      if ($row_class == "primary") {
        $row_class = "alt1";
      } else {
        $row_class = "primary";
      }
    }
    $dmQ->close();
  ?>
</table>
<br>
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><? echo $loc->getText("adminTipoPrestamos_ListNote"); ?></font></td>
<td class="noborder"><font class="small"><? echo $loc->getText("adminTipoPrestamos_ListNoteText"); ?><br></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>
