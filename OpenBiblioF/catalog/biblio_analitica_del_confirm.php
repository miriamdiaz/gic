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

  require_once("../classes/BiblioAnalitica.php");
  require_once("../classes/BiblioAnaliticaQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  $anaid = $_GET["anaid"];

  #****************************************************************************
  #*  Ready analitica information
  #****************************************************************************
  $anaQ = new BiblioAnaliticaQuery();
  $anaQ->connect();
  if ($anaQ->errorOccurred()) {
    $anaQ->close();
    displayErrorPage($anaQ);
  }
  if (!$ana = $anaQ->query($bibid,$anaid)) {
    $anaQ->close();
    displayErrorPage($anaQ);
  }
  $anaQ->close();

  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delanaform" method="POST" action="../catalog/biblio_analitica_del.php?bibid=<?php echo $bibid;?>&anaid=<?php echo $anaid;?>&titulo=<?php echo $ana->getAnaliticaTitulo();?>">
  <?php echo $loc->getText("biblioAnaDelConfirmMsg",array("titulo"=>$ana->getAnaliticaTitulo())); ?>
  <br><br>
  <input type="submit" value="Borrar" class="button">
  <input type="button" onClick="parent.location='../shared/biblio_view.php?bibid=<?php echo $bibid;?>'" value="Cancelar" class="button">
</form>
</center>
<?php include("../shared/footer.php"); ?>