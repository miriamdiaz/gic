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
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioCopyNumQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $id = $_GET["id"];

  #**************************************************************************
  #*  Delete Bibliography Copy
  #**************************************************************************
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
  if (!$copyQ->delete($id)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  $copyQ->close();


  #**************************************************************************
  #*  Show success message
  #**************************************************************************
  $msg = "El registro del a�o ".$copy->getAnio()." con los n�meros ".$copy->getNumeros()." fue eliminado satisfactoriamente";
  $msg = urlencode($msg);
  header("Location: ../catalog/biblio_copy_num_list.php?bibid=".$copy->getBibid()."&copyid=".$copy->getCopyid()."&msg=".$msg);
  exit();
?>
