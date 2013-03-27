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
  $nav = "librarys";
  $focus_form_name = "editlibraryform";
  $focus_form_field = "description";

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  require_once("../shared/header.php");

  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #****************************************************************************
  if (isset($_GET["code"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    $code = $_GET["code"];
    $postVars["code"] = $code;
    include_once("../classes/Library.php");
    include_once("../classes/LibraryQuery.php");
    include_once("../functions/errorFuncs.php");
    $LmQ = new LibraryQuery();
    $LmQ->connect();
    if ($LmQ->errorOccurred()) {
      $LmQ->close();
      displayErrorPage($LmQ);
    }
    $LmQ->execSelect("biblio_cod_library",$code);
    if ($LmQ->errorOccurred()) {
      $LmQ->close();
      displayErrorPage($LmQ);
    }
    $lb = $LmQ->fetchRow();
    $postVars["description"] = $lb->getDescription();
//    $postVars["daysDueBack"] = $lb->getDaysDueBack();
//    $postVars["dailyLateFee"] = $lb->getDailyLateFee();
    $LmQ->close();
  } else {
    require("../shared/get_form_vars.php");
  }
?>

<form name="editlibraryform" method="POST" action="../catalog/library_edit.php">
<input type="hidden" name="code" value="<?php echo $postVars["code"];?>">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <? echo $loc->getText("catalogLibrary_edit_formEditlibrary"); ?>
    </th>
  </tr>

  <tr>
    <td nowrap="true" class="primary">
      <? echo $loc->getText("catalogLibrary_edit_formDescription"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("code",2,2,$postVars,$pageErrors); ?>
    </td>
  </tr>

  <tr>
    <td nowrap="true" class="primary">
      <? echo $loc->getText("catalogLibrary_edit_formDescription"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("description",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <? echo $loc->getText("catalogSubmit"); ?>  " class="button">
      <input type="button" onClick="parent.location='../catalog/library_list.php'" value="  <? echo $loc->getText("catalogCancel"); ?>  " class="button">
    </td>
  </tr>

</table>
      </form>
<table><tr><td valign="top"><font class="small"><? echo $loc->getText("catalogLibrary_edit_formNote"); ?></font></td>
<td><font class="small"><? echo $loc->getText("cotaloglibrary_edit_formNoteText"); ?><br></font>
</td></tr></table>

<?php include("../shared/footer.php"); ?>
