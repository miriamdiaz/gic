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
  $nav = "docentes";

  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");

  $memberQ = new MemberQuery();
  $memberQ->connect();
  if ($memberQ->errorOccurred()) {
    $memberQ->close();
    displayErrorPage($memberQ);
  } 
  $memberQ->execSelectFieldValue("classification",2);
  if ($memberQ->errorOccurred()) {
    $memberQ->close();
    displayErrorPage($memberQ);
  }

?>
<a href="../adquisiciones/mbr_new_form.php?reset=Y"><? echo "Agregar Docente"; ?></a><br>
<h1><? echo "Docentes"; ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top"><? echo "Funciones"; ?>
      <font class="small">*</font>
    </th>
    <th valign="top">
      <? echo "Nombre y Apellido"; ?>
    </th>
    <th valign="top">
      <? echo "D.N.I."; ?>
    </th>
  </tr>
  <?php
    $row_class = "primary";
    while ($mbr = $memberQ->fetchEachMember()) {
  ?>
  <tr>
    <td valign="top" class="<?php echo $row_class;?>">
      <a href="../adquisiciones/mbr_edit_form.php?mbrid=<?php echo $mbr->getMbrid();?>" class="<?php echo $row_class;?>"><? echo "Editar"; ?></a>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
        <a href="../adquisiciones/mbr_del_confirm.php?mbrid=<?php echo $mbr->getMbrid();?>&description=<?php echo urlencode($mbr->getLastName().", ".$mbr->getFirstName());?>" class="<?php echo $row_class;?>"><? echo "Eliminar"; ?></a>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
      <?php echo $mbr->getLastName().", ".$mbr->getFirstName();?>
    </td>
    <td valign="top" align="center"  class="<?php echo $row_class;?>">
      <?php echo $mbr->getBarcodeNmbr();?>
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
    $memberQ->close();
  ?>
</table>
<br>
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><? echo ""; ?></font></td>
<td class="noborder"><font class="small"><? echo ""; ?><br></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>
