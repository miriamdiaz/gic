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

  $tab = "adquisiciones";
  $nav = "estados";
  $focus_form_name = "editestadoform";
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
    include_once("../classes/Dm.php");
    include_once("../classes/DmQuery.php");
    include_once("../functions/errorFuncs.php");
    $dmQ = new DmQuery();
    $dmQ->connect();
    if ($dmQ->errorOccurred()) {
      $dmQ->close();
      displayErrorPage($dmQ);
    }
    $dmQ->execSelect("estado_dm",$code);
    if ($dmQ->errorOccurred()) {
      $dmQ->close();
      displayErrorPage($dmQ);
    }
    $dm = $dmQ->fetchRow();
    $postVars["description"] = $dm->getDescription();
    $postVars["fecha_vto"] = $dm->getFechaVto();
    $dmQ->close();
  } else {
    require("../shared/get_form_vars.php");
  }
?>

<form name="editcollectionform" method="POST" action="../adquisiciones/estados_edit.php">
<input type="hidden" name="code" value="<?php echo $postVars["code"];?>">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <? echo "Edici�n de estado"; ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Descripci�n"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("description",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>

  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <? echo "Aceptar"; ?>  " class="button">
      <input type="button" onClick="parent.location='../adquisiciones/estados_list.php'" value="  <? echo "Cancelar"; ?>  " class="button">
    </td>
  </tr>

</table>
      </form>
<table><tr><td valign="top"><font class="small"><? echo ""; ?></font></td>
<td><font class="small"><? echo ""; ?><br></font>
</td></tr></table>

<?php include("../shared/footer.php"); ?>
