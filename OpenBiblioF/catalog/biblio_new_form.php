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
  $nav = "new";
  $helpPage = "biblioEdit";
  $cancelLocation = "../catalog/index.php";
  $focus_form_name = "newbiblioform";
  $focus_form_field = "materialCd";

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  //28-06-06: Se agrega el siguiente require
  require_once("../classes/Query.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $headerWording=$loc->getText("biblioNewFormLabel");

  /*****************************************************
   *  Set form defaults
   *****************************************************/
  if (isset($_GET["reset"])){
    $postVars["opacFlg"] = "CHECKED";
  }

?>

<form name="newbiblioform" method="POST" action="../catalog/biblio_new.php">
<?php include("../catalog/biblio_fields.php"); ?>
<?php include("../shared/footer.php"); ?>
