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

  $tab = "adquisiciones";
  $nav = "areas";

  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelectWithStats("area_dm");
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }

?>
<a href="../adquisiciones/areas_new_form.php?reset=Y"><? echo "Agregar Área"; ?></a><br>
<h1><? echo "Áreas"; ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top"><? echo "Funciones"; ?>
      <font class="small">*</font>
    </th>
    <th valign="top">
      <? echo "Código"; ?>
    </th>	
    <th valign="top">
      <? echo "Descripción"; ?>
    </th>
  </tr>
  <?php
    $row_class = "primary";
    while ($dm = $dmQ->fetchRow()) {
  ?>
  <tr>
    <td valign="top" class="<?php echo $row_class;?>">
      <a href="../adquisiciones/areas_edit_form.php?code=<?php echo $dm->getCode();?>" class="<?php echo $row_class;?>"><? echo "Editar"; ?></a>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
        <a href="../adquisiciones/areas_del_confirm.php?code=<?php echo $dm->getCode();?>&description=<?php echo urlencode($dm->getDescription());?>" class="<?php echo $row_class;?>"><? echo "Eliminar"; ?></a>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
      <?php echo $dm->getValue();?>
    </td>	
    <td valign="top" class="<?php echo $row_class;?>">
      <?php echo $dm->getDescription();?>
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
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><? echo ""; ?></font></td>
<td class="noborder"><font class="small"><? echo ""; ?><br></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>
