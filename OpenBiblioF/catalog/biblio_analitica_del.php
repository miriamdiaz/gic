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
  require_once("../classes/BiblioAnaliticaQuery.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $bibid = $_GET["bibid"];
  $anaid = $_GET["anaid"];
  $titulo = $_GET["titulo"];

  #**************************************************************************
  #*  Delete Bibliography Analitica
  #**************************************************************************
  $anaQ = new BiblioAnaliticaQuery();
  $anaQ->connect();
  if ($anaQ->errorOccurred()) {
    $anaQ->close();
    displayErrorPage($anaQ);
  }
  if (!$anaQ->delete($bibid,$anaid)) {
    $anaQ->close();
    displayErrorPage($anaQ);
  }
  $anaQ->close();

  #**************************************************************************
  #*  Show success message
  #**************************************************************************
  $msg = $loc->getText("biblioAnaDelSuccess",array("titulo"=>$titulo));
  $msg = urlencode($msg);
  header("Location: ../shared/biblio_view.php?bibid=".$bibid."&msg=".$msg);
  exit();
?>
