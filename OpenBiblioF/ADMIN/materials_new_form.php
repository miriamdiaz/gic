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

  $tab = "admin";
  $nav = "materials";
  $focus_form_name = "newmaterialform";
  $focus_form_field = "description";

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../shared/header.php");

?>

<form name="newmaterialform" method="POST" action="../admin/materials_new.php">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <? echo $loc->getText("admin_materials_listAddmaterialtypes"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <? echo $loc->getText("admin_materials_listDescription"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("description",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <? echo $loc->getText("admin_materials_delAdultLimit"); ?><br><font class="small"><? echo $loc->getText("admin_materials_delunlimited"); ?></font>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("adultCheckoutLimit",2,2,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <? echo $loc->getText("admin_materials_delJuvenileLimit"); ?><br><font class="small"><? echo $loc->getText("admin_materials_delunlimited"); ?></font>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("juvenileCheckoutLimit",2,2,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <font class="small">*</font><? echo $loc->getText("admin_materials_delImagefile"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("imageFile",40,128,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <? echo $loc->getText("adminSubmit"); ?>  " class="button">
      <input type="button" onClick="parent.location='../admin/materials_list.php'" value="  <? echo $loc->getText("adminCancel"); ?>  " class="button">
    </td>
  </tr>

</table>
      </form>

<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><? echo $loc->getText("admin_materials_listNote"); ?></font></td>
<td class="noborder"><font class="small"><? echo $loc->getText("admin_materials_new_formNoteText"); ?><br></font>
</td></tr></table>

<?php include("../shared/footer.php"); ?>
