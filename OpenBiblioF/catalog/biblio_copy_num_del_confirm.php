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
  $nav = "view";
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/BiblioCopyNum.php");
  require_once("../classes/BiblioCopyNumQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);


  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $id = $_GET["id"];

  #****************************************************************************
  #*  Ready copy information
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
  $copyQ->close();


  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delcopyform" method="POST" action="../catalog/biblio_copy_num_del.php?id=<?php echo $copy->getId();?>">
  <?php echo "Está seguro que desea eliminar este registro del año ".$copy->getAnio()." con los números ".$copy->getNumeros(); ?>
  <br><br>
  <input type="submit" value="Borrar" class="button">
  <input type="button" onClick="parent.location='../catalog/biblio_copy_num_list.php?bibid=<?php echo $copy->getBibid();?>&copyid=<?php echo $copy->getCopyid();?>'" value="Cancelar" class="button">
</form>
</center>
<?php include("../shared/footer.php"); ?>
