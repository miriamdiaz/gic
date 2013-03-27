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

  $tab = "home";
  $nav = "advancesearch";
  $focus_form_name = "advancesearchform";
  $focus_form_field = "fieldId1";

  require_once("../shared/common.php");
  //include("../shared/logincheck.php");
  require_once("../functions/inputFuncs.php");
  require_once("../classes/ReportQuery.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  page functions
  #****************************************************************************
  function getFullColumnName($fieldIds,$initialSort) 
  {
    foreach($fieldIds as $fldid) 
	{
      if (strpos($fldid,".".$initialSort)) 
	  {
        return $fldid;
      }
    }
    return "";
  }

  function printCriteriaFields($index,&$fieldIds,&$fieldNames,&$fieldTypes,&$fieldNumericFlgs,&$postVars,&$pageErrors,&$loc,&$fieldValuebVisibility)
  {
    $fldIndex = "fieldId".$index;
    echo "<select name=\"".$fldIndex."\">";
    echo "<option value=\"\"";
    if ((isset($postVars[$fldIndex])) and ($postVars[$fldIndex] == "")) echo " selected";
    echo " ></option>";
    foreach($fieldIds as $fldid) {
      $fld = $fldid." ".$fieldTypes[$fldid]." ".$fieldNumericFlgs[$fldid];
      echo "<option value=\"".$fld."\"";
      if ((isset($postVars[$fldIndex])) and ($postVars[$fldIndex] == $fld)) echo " selected";
      echo " >".$loc->getText($fldid)."</option>";
    }
    echo "</select>";
/*
Eduardo

    echo " <select name=\"comparitor".$index."\" onchange=\"comparitorOnChange(this,".$index.")\";>";
    echo "<option value=\"eq\" ";
    if ($postVars["comparitor".$index] == "eq") echo "selected";
    echo ">".$loc->getText("reportCriteriaEQ")."</option>";
    echo "<option value=\"ne\" ";
    if ($postVars["comparitor".$index] == "ne") echo "selected";
    echo ">".$loc->getText("reportCriteriaNE")."</option>";
    echo "<option value=\"lt\" ";
    if ($postVars["comparitor".$index] == "lt") echo "selected";
    echo ">".$loc->getText("reportCriteriaLT")."</option>";
    echo "<option value=\"gt\" ";
    if ($postVars["comparitor".$index] == "gt") echo "selected";
    echo ">".$loc->getText("reportCriteriaGT")."</option>";
    echo "<option value=\"le\" ";
    if ($postVars["comparitor".$index] == "le") echo "selected";
    echo ">".$loc->getText("reportCriteriaLE")."</option>";
    echo "<option value=\"ge\" ";
    if ($postVars["comparitor".$index] == "ge") echo "selected";
    echo ">".$loc->getText("reportCriteriaGE")."</option>";
    echo "<option value=\"bt\" ";
    if ($postVars["comparitor".$index] == "bt") echo "selected";
    echo ">".$loc->getText("reportCriteriaBT")."</option>";
    echo "</select> ";
*/


/*
Eduardo
*/
    echo " <select name=\"comparitor".$index."\" onchange=\"comparitorOnChange(this,".$index.")\";>";
    echo "<option value=\"like\" ";
    if ($postVars["comparitor".$index] == "like") echo "selected";
    echo ">contiene</option>";
    echo "<option value=\"eq\" ";
    if ($postVars["comparitor".$index] == "eq") echo "selected";
    echo ">".$loc->getText("reportCriteriaEQ")."</option>";
    echo "<option value=\"ne\" ";
    if ($postVars["comparitor".$index] == "ne") echo "selected";
    echo ">".$loc->getText("reportCriteriaNE")."</option>";
    if ($postVars["comparitor".$index] == "lt") echo "selected";
    echo ">".$loc->getText("reportCriteriaLT")."</option>";
    echo "<option value=\"gt\" ";
    if ($postVars["comparitor".$index] == "gt") echo "selected";
    echo ">".$loc->getText("reportCriteriaGT")."</option>";
    echo "<option value=\"le\" ";
    if ($postVars["comparitor".$index] == "le") echo "selected";
    echo ">".$loc->getText("reportCriteriaLE")."</option>";
    echo "<option value=\"ge\" ";
    if ($postVars["comparitor".$index] == "ge") echo "selected";
    echo ">".$loc->getText("reportCriteriaGE")."</option>";
    echo "<option value=\"bt\" ";
    if ($postVars["comparitor".$index] == "bt") echo "selected";
    echo ">".$loc->getText("reportCriteriaBT")."</option>";
    echo "</select> ";


    printInputText("fieldValue".$index."a",15,80,$postVars,$pageErrors);
    echo"<span id=\"and".$index."\" style=\"visibility:".$fieldValuebVisibility[$index].";\"> ".$loc->getText("reportCriteriaAnd")." </span>";
    printInputText("fieldValue".$index."b",15,80,$postVars,$pageErrors,$fieldValuebVisibility[$index]);
  }

  function printSortFields($index,&$fieldIds,&$postVars,&$pageErrors,&$loc){
    $fldIndex = "sortOrder".$index;
    echo "<select name=\"".$fldIndex."\">";
    echo "<option value=\"\"";
    if ((isset($postVars[$fldIndex])) and ($postVars[$fldIndex] == "")) echo " selected";
    echo " ></option>";
    foreach($fieldIds as $fldid) {
      echo "<option value=\"".$fldid."\"";
      if ((isset($postVars[$fldIndex])) and ($postVars[$fldIndex] == $fldid)) echo " selected";
      echo " >".$loc->getText($fldid)."</option>";
    }
    echo "</select>";
    
    $fldIndex = "sortDir".$index;
    echo "<input type=\"radio\" name=\"".$fldIndex."\" value=\"asc\"";
    if ((!isset($postVars[$fldIndex]) or
      (isset($postVars[$fldIndex])) and ($postVars[$fldIndex] == "asc"))) {
      echo " checked";
    }
    echo ">".$loc->getText("reportCriteriaAscending")."</input>";
    echo "<input type=\"radio\" name=\"".$fldIndex."\" value=\"desc\"";
    if ((isset($postVars[$fldIndex])) and ($postVars[$fldIndex] == "desc")) {
      echo " checked";
    }
    echo ">".$loc->getText("reportCriteriaDescending")."</input>";
  }

  function printOutputFields(&$fieldIds,&$postVars,&$pageErrors,&$loc){
    $fldIndex = "outputType";
    echo "<select name=\"".$fldIndex."\">";
    foreach($fieldIds as $fldid) {
      echo "<option value=\"".$fldid."\"";
      if ((isset($postVars[$fldIndex])) and ($postVars[$fldIndex] == $fldid)) echo " selected";
      echo " >".$loc->getText($fldid)."</option>";
    }
    echo "</select>";
  }

  #****************************************************************************
  #*  getting form vars
  #****************************************************************************
  require("../shared/get_form_vars.php");
 
  for ($i = 1; $i <= 4; $i++) {
    if (!isset($postVars["comparitor".$i])) {
      $postVars["comparitor".$i] = "";
    }
    if ($postVars["comparitor".$i] == "bt") {
      $fieldValuebVisibility[$i] = "visible";
    } else {
      $fieldValuebVisibility[$i] = "hidden";
    }
  }

  #****************************************************************************
  #*  Read query string args
  #****************************************************************************
  $rptid = $_GET["rptid"];
  $title = $_GET["title"];
  $sql = stripslashes($_GET["sql"]);
  //echo "<h1>reportlist</h1>";
  $nav = "home";
  $label = "";
  $letter = "";
  $initialSort = "";
  $okAction = "../shared/display_search.php";
  $cancelAction = "../home/index.php";
  $showStartLabelFld = FALSE;

  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".stripslashes($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }
//  $metaSql = $sql." limit 1";
  $metaSql = $sql;
  //echo "<h1>".$metaSql."</h1>";
  #****************************************************************************
  #*  Run report with row limit = 1 to get field names
  #****************************************************************************
  $reportQ = new ReportQuery();
  $reportQ->connect();
  if ($reportQ->errorOccurred()) {
    $reportQ->close();
    displayErrorPage($reportQ);
  }
//  echo $metaSql;
  $result = $reportQ->query($metaSql);
  if ($reportQ->errorOccurred()) {
    $reportQ->close();
    displayErrorPage($reportQ);
  }
  
  $fieldIds = array();
  $fieldNames = array();
  $fieldTypes = array();
  $fieldNumericFlgs = array();
  while ($fld = $reportQ->fetchField()) {
    $fldid = $fld->name;
/*    if ($fld->table != "") {
      $fldid = $fld->table.".".$fldid;
    }*/

    $fieldIds[] = $fldid;
    $fieldNames[$fldid] = $fld->name;
    $fieldTypes[$fldid] = $fld->type;
    $fieldNumericFlgs[$fldid] = $fld->numeric;
  }
// print_r($fieldNumericFlgs);
  $rowCount = $reportQ->getRowCount();
  $reportQ->close();


  // load initial sort if passed as query string
  if (($initialSort != "") and !isset($postVars["sortOrder1"])) {
    $intialSortValue = getFullColumnName($fieldIds,$initialSort);
    $postVars["sortOrder1"] = $intialSortValue;
  }

?>

  <script language="JavaScript">
  <!--
  function comparitorOnChange(inputElem,critNmbr) {
    elem = document.getElementById("fieldValue" + critNmbr + "b")
    andElem = document.getElementById("and" + critNmbr)
    if (inputElem.value == "bt") {
      elem.style.visibility = "visible";
      andElem.style.visibility = "visible";
    } else {
      elem.style.visibility = "hidden";
      andElem.style.visibility = "hidden";
    }
  }
  -->
  </script>

<?php
  include("../shared/header.php");
?>

<h1><?php echo $title.":";?></h1>

<?php echo $msg ?>

<form name="advancesearchform" method="POST" action="<?php echo $okAction; ?>">
<input type="hidden" name="fromBusquedaAvanzada">
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php print $loc->getText("reportCriteriaHead1"); ?>
    </th>
  </tr>
  <tr>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php echo $loc->getText("reportCriteriaCrit1"); ?>
    </td>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php printCriteriaFields(1,$fieldIds,$fieldNames,$fieldTypes,$fieldNumericFlgs,$postVars,$pageErrors,$loc,$fieldValuebVisibility); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php echo $loc->getText("reportCriteriaCrit2"); ?>
    </td>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php printCriteriaFields(2,$fieldIds,$fieldNames,$fieldTypes,$fieldNumericFlgs,$postVars,$pageErrors,$loc,$fieldValuebVisibility); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php echo $loc->getText("reportCriteriaCrit3"); ?>
    </td>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php printCriteriaFields(3,$fieldIds,$fieldNames,$fieldTypes,$fieldNumericFlgs,$postVars,$pageErrors,$loc,$fieldValuebVisibility);?>
    </td>
  </tr>
  <tr>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php echo $loc->getText("reportCriteriaCrit4"); ?>
    </td>
    <td class="primary" align="left" valign="top" nowrap="yes">
      <?php printCriteriaFields(4,$fieldIds,$fieldNames,$fieldTypes,$fieldNumericFlgs,$postVars,$pageErrors,$loc,$fieldValuebVisibility); ?>
    </td>
  </tr>

  
</table>
<br>

<?php if ($showStartLabelFld) {
    if (!isset($postVars["startOnLabel"])) {
      $postVars["startOnLabel"] = "1";
    }
    echo "<br>".$loc->getText("reportCriteriaStartOnLabel")." ";
    printInputText("startOnLabel",2,2,$postVars,$pageErrors);
  }
?>
  
  <input type="hidden" name="rptid" value="<?php echo $rptid;?>">
  <input type="hidden" name="title" value="<?php echo $title;?>">
  <input type="hidden" name="sql" value="<?php echo $sql;?>">
  <input type="hidden" name="label" value="<?php echo $label;?>">
  <input type="hidden" name="letter" value="<?php echo $letter;?>">
  <input type="hidden" name="initialSort" value="<?php echo $initialSort;?>">
<br>
  <center>
<!-- Eduardo Rojel 11/02/05 -->
Tipo: <select name="tipo">
<option value="html">HTML</option>
<option value="csv">CSV</option>
<option value="pdf">PDF</option>
</select>
<script language="javascript">
function Validar(form)
    {
    if (((form.fieldId1.value == "") || (form.fieldValue1a.value == "")) && ((form.fieldId2.value == "") || (form.fieldValue2a.value == "")) && ((form.fieldId3.value == "") || (form.fieldValue3a.value == "")) && ((form.fieldId4.value == "") || (form.fieldValue4a.value == "")))
  		{
  		alert("Para poder realizar la busqueda usted debera completar algun campo."); 
  		return; 
  		}
    form.submit();
    }
</script>
<input type="button" onClick="Validar(this.form)" value="<?php echo $loc->getText("reportCriteriaRunReport"); ?>" class="button">
<!-- Eduardo Rojel 11/02/05 -->

<input type="button" onClick="parent.location='<?php echo $cancelAction; ?>'" value="<?php echo $loc->getText("reportsCancel"); ?>" class="button">

	</center>
</form>

<?php include("../shared/footer.php"); ?>
