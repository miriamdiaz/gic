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
    #****************************************************************************
    #*  Retrieving get var
    #****************************************************************************
    $bibid = $_GET["bibid"];
    $copyid = $_GET["copyid"];

  $tab = "cataloging";
  $nav = "editcopy";

  require_once("../classes/BiblioCopyNum.php");
  require_once("../classes/BiblioCopyNumQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");
  

	
    #****************************************************************************
    #*  Read copy num information
    #****************************************************************************
    $copyQ = new BiblioCopyNumQuery();
    $copyQ->connect();
    if ($copyQ->errorOccurred()) {
      $copyQ->close();
      displayErrorPage($copyQ);
    }
    if (!$copy = $copyQ->execSelect($bibid,$copyid)) {
      $copyQ->close();
      displayErrorPage($copyQ);
    }	

/*  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelectWithStats("collection_dm");
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }*/

?>
<a href="../catalog/biblio_copy_num_new_form.php?bibid=<?=$bibid?>&copyid=<?=$copyid?>&reset=Y"><? echo "Añadir nuevos Números"; ?></a><br>
<h1><? echo "Números de Publicación Periódica"; ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top"><? echo $loc->getText("adminCollections_listFunction"); ?>
    </th>
    <th valign="top">
      <? echo "Año"; ?>
    </th>
    <th valign="top">
      <? echo "Volumen"; ?>
    </th>
    <th valign="top">
      <? echo "Números"; ?>
    </th>
  </tr>
  <?php
    if ($copyQ->getRowCount() == 0) { ?>
      <tr>
        <td valign="top" colspan="5" class="primary">
          <?php echo "Esta publicación no posee números guardados"; ?>
        </td>
      </tr>      
    <?php } else {  
    $row_class = "primary";
    while ($copy = $copyQ->fetchCopy()) {
  ?>
  <tr>
    <td valign="top" class="<?php echo $row_class;?>">
      <a href="../catalog/biblio_copy_num_edit_form.php?id=<?php echo $copy->getId();?>" class="<?php echo $row_class;?>"><? echo $loc->getText("adminCollections_listEdit"); ?></a>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
        <a href="../catalog/biblio_copy_num_del_confirm.php?id=<?php echo $copy->getId();?>" class="<?php echo $row_class;?>"><? echo $loc->getText("adminCollections_listDel"); ?></a>
    </td>
    <td valign="top" class="<?php echo $row_class;?>">
      <?php echo $copy->getAnio();?>
    </td>
    <td valign="top" align="center" class="<?php echo $row_class;?>">
      <?php echo $copy->getEstado();?>
    </td>
    <td valign="top" align="center"  class="<?php echo $row_class;?>">
      <?php echo $copy->getNumeros();?>
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
    $copyQ->close();
 }
  ?>
</table>
<br>
<a href="../shared/biblio_view.php?bibid=<?=$bibid?>"><? echo "Volver a ejemplares"; ?></a><br>
<?php include("../shared/footer.php"); ?>
