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
// \/ MODIFICACIÓN JUDITH 25/10/05 \/
  $tab = "reports";
  $nav = "reportlistsiunpa";
  
 // $focus_form_name = "advancesearchform";
  //$focus_form_field = "fieldId1";
  
  require_once("../functions/inputFuncs.php");
  require_once("../shared/common.php");
  include("../shared/logincheck.php");
  include("../shared/header.php");
  require_once("../classes/Localize.php");
  require_once("../functions/errorFuncs.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
 
 // $okAction = "../reports/list_run.php";
  $cancelAction = "../reports/report_list_siunpa.php";
  
?>

<h1><?php print $loc->getText("reportSiunpaHead3");?>&nbsp;<?php print $loc->getText("reportSiunpaHead3-1");?></h1>

<?php echo $loc->getText("reportSiunpaListDesc");?>

<br><br>
<CENTER>
<form name="list_materials_run" method="POST" action="list_run.php">
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php print $loc->getText("reportTitleHead1"); ?>
    </th>
  </tr>

  <tr>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php echo $loc->getText("reportTitleBegin"); ?>
    </td>
    <td class="primary" align="left" valign="top" nowrap="yes">
		<?php printSelectDate1("fecha1",$postVars,$pageErrors);?>
    </td>
  </tr>

  <tr>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php echo $loc->getText("reportTitleEnd"); ?>
    </td>
    <td class="primary" align="left" valign="top" nowrap="yes">
		<?php printSelectDate2("fecha2",$postVars,$pageErrors);?>
    </td>
  </tr>
  
</table>  
<br>
<table class="primary">
<tr>
<td class="primary">
Impresion
<select name="impresion">
<option value="html" selected>HTML</option>
<option value="pdf">PDF</option>
<option value="csv">CSV</option>
</select>
</td>
</tr>
</table>
 <br>
  <center>
    <input type="submit" value="<?php echo $loc->getText("reportCriteriaRunReport"); ?>" class="button">
    <input type="button" onClick="parent.location='<?php echo $cancelAction; ?>'" value="<?php echo $loc->getText("reportsCancel"); ?>" class="button">
  	<input type="hidden" name="flg" value="bib_aprob">
  </center>
</form>
</CENTER>

<hr>

<h1><?php print $loc->getText("reportSiunpaHead3");?>&nbsp;<?php print $loc->getText("reportSiunpaHead3-2");?></h1>

<?php echo $loc->getText("reportSiunpaListDesc");?>

<br><br>
<CENTER>
<form name="list_materials_run" method="POST" action="list_run.php">
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php print $loc->getText("reportTitleHead1"); ?>
    </th>
  </tr>

  <tr>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php echo $loc->getText("reportTitleBegin"); ?>
    </td>
    <td class="primary" align="left" valign="top" nowrap="yes">
		<?php printSelectDate1("fecha1",$postVars,$pageErrors);?>
    </td>
  </tr>

  <tr>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php echo $loc->getText("reportTitleEnd"); ?>
    </td>
    <td class="primary" align="left" valign="top" nowrap="yes">
		<?php printSelectDate2("fecha2",$postVars,$pageErrors);?>
    </td>
  </tr>
  
</table>  
<br>
<table class="primary">
<tr>
<td class="primary">
Impresion
<select name="impresion">
<option value="html" selected>HTML</option>
<option value="pdf">PDF</option>
<option value="csv">CSV</option>
</select>
</td>
</tr>
</table>
 <br>
  <center>
    <input type="submit" value="<?php echo $loc->getText("reportCriteriaRunReport"); ?>" class="button">
    <input type="button" onClick="parent.location='<?php echo $cancelAction; ?>'" value="<?php echo $loc->getText("reportsCancel"); ?>" class="button">
  	<input type="hidden" name="flg" value="copy_aprob">
  </center>
</form>


<?php include("../shared/footer.php"); ?>