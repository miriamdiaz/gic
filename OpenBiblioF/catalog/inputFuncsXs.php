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

define("OBIB_TEXT_CNTRL", "0");
define("OBIB_TEXTAREA_CNTRL", "1");

/*********************************************************************************
 * Draws input html tag of type text.
 * @param string $tag input field tag
 * @param string $subfieldCd input field subfield code
 * @param boolean $required true if field is required
 * @param array_reference &$fieldIds reference to array containing field ids if updating fields
 * @param array_reference &$postVars reference to array containing all input values
 * @param array_reference &$pageErrors reference to array containing all input errors
 * @param array_reference &$marcTags reference to array containing marc tag descriptions
 * @param array_reference &$marcSubflds reference to array containing marc subfield descriptions
 * @param boolean $showTagDesc set to true if the tag description should also show
 * @param string $cntrlType see defined constants OBIB_TEXT_CNTRL & OBIB_TEXTAREA_CNTRL above
 * @param int $occur input field occurance if field is being entered as repeatable
 * @return void
 * @access public
 *********************************************************************************
 */
function printUsmarcInputText($tag,$subfieldCd,$required,&$fieldIds,&$postVars,&$pageErrors,&$marcTags,&$marcSubflds,$showTagDesc,$cntrlType,$occur=""){
  $arrayIndex = sprintf("%03d",$tag).$subfieldCd;
  $formIndex = $arrayIndex.$occur;
  $size = 40;
  $maxLen = 3000;
  $cols = 35;
  $rows = 4;

  if (!isset($fieldIds)) {
    $fieldId = "";
  } elseif (!isset($fieldIds[$arrayIndex])) {
      $fieldId = "";
  } else {
      $fieldId = $fieldIds[$arrayIndex];
  }
  if (!isset($postVars)) {
    $value = "";
  } elseif (!isset($postVars[$formIndex])) {
      $value = "";
  } else {
      $value = $postVars[$formIndex];
  }
  if (!isset($pageErrors)) {
    $error = "";
  } elseif (!isset($pageErrors[$formIndex])) {
      $error = "";
  } else {
      $error = $pageErrors[$formIndex];
  }


  echo "<tr><td class=\"primary\" valign=\"top\">\n";
  if ($required) {
    echo "<sup>*</sup> ";
  }
  if (($showTagDesc) 
    && (isset($marcTags[$tag]))
    && (isset($marcSubflds[$arrayIndex]))){
    echo $marcTags[$tag]->getDescription();
    echo " (".$marcSubflds[$arrayIndex]->getDescription().")";
  } elseif (isset($marcSubflds[$arrayIndex])){
    echo $marcSubflds[$arrayIndex]->getDescription();
  }
  if ($occur != "") {
    echo " ".($occur+1);
  }
  echo ":\n</td>\n";
  echo "<td valign=\"top\" class=\"primary\">\n";
  if ($cntrlType == OBIB_TEXTAREA_CNTRL) {
    echo "<textarea name=\"values[".$formIndex."]\" cols=\"".$cols."\" rows=\"".$rows."\">";
    echo $value."</textarea>";
  } else {
    echo "<input type=\"text\"";
    echo "\" name=\"values[".$formIndex."]\" size=\"".$size."\" maxlength=\"".$maxLen."\" ";
    echo "value=\"".$value."\" >";
  }
  if ($error != "") {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
  echo "<input type=\"hidden\" name=\"indexes[]\" value=\"".$formIndex."\" >\n";
  echo "<input type=\"hidden\" name=\"tags[".$formIndex."]\" value=\"".$tag."\" >\n";
  echo "<input type=\"hidden\" name=\"subfieldCds[".$formIndex."]\" value=\"".$subfieldCd."\" >\n";
  echo "<input type=\"hidden\" name=\"fieldIds[".$formIndex."]\" value=\"".$fieldId."\" >\n";
  echo "<input type=\"hidden\" name=\"requiredFlgs[".$formIndex."]\" value=\"".$required."\" >\n";
  echo "</td></tr>\n";
}

function printUsmarcInputTextAutocompletar($tag,$subfieldCd,$required,&$fieldIds,&$postVars,&$pageErrors,&$marcTags,&$marcSubflds,$showTagDesc,$cntrlType,$occur="",$tabla,$atributo){
  $arrayIndex = sprintf("%03d",$tag).$subfieldCd;
  $formIndex = $arrayIndex.$occur;
  $size = 40;
  $maxLen = 1500;
  $cols = 35;
  $rows = 4;

  if (!isset($fieldIds)) {
    $fieldId = "";
  } elseif (!isset($fieldIds[$arrayIndex])) {
      $fieldId = "";
  } else {
      $fieldId = $fieldIds[$arrayIndex];
  }
  if (!isset($postVars)) {
    $value = "";
  } elseif (!isset($postVars[$formIndex])) {
      $value = "";
  } else {
      $value = $postVars[$formIndex];
  }
  if (!isset($pageErrors)) {
    $error = "";
  } elseif (!isset($pageErrors[$formIndex])) {
      $error = "";
  } else {
      $error = $pageErrors[$formIndex];
  }


  echo "<tr><td class=\"primary\" valign=\"top\">\n";
  if ($required) {
    echo "<sup>*</sup> ";
  }
  if (($showTagDesc) 
    && (isset($marcTags[$tag]))
    && (isset($marcSubflds[$arrayIndex]))){
    echo $marcTags[$tag]->getDescription();
    echo " (".$marcSubflds[$arrayIndex]->getDescription().")";
  } elseif (isset($marcSubflds[$arrayIndex])){
    echo $marcSubflds[$arrayIndex]->getDescription();
  }
  if ($occur != "") {
    echo " ".($occur+1);
  }
  echo ":\n</td>\n";
  echo "<td valign=\"top\" class=\"primary\">\n";
  if ($cntrlType == OBIB_TEXTAREA_CNTRL) {
    echo "<textarea name=\"values[".$formIndex."]\" cols=\"".$cols."\" rows=\"".$rows."\">";
    echo $value."</textarea>";
  } else {
?>
<SCRIPT LANGUAGE="JavaScript" SRC="autocomplete.js"></SCRIPT>
<div>
<?
    echo "<input type=\"text\"";
    echo "\" name=\"values[".$formIndex."]\" size=\"".$size."\" maxlength=\"".$maxLen."\" ";
    echo "value=\"".$value."\" ONKEYUP=\"autoComplete(this,this.form.options,'value',true)\" id=\"$atributo\">";
?>
</div>
<div><SELECT style="font-size: 9px; font-family: verdana" NAME="options" onClick="getElementById('<?=$atributo;?>').value=this.options[this.selectedIndex].value" onChange="getElementById('<?=$atributo;?>').value=this.options[this.selectedIndex].value">
<?
    include("../conexiondb.php");
    $sql = "SELECT DISTINCT $atributo FROM $tabla Where $atributo is not null ORDER BY $atributo";
    $resultado_set = mysql_query($sql,$conexion);
    $filas = mysql_numrows($resultado_set);
    if ($filas > 0)
	{ 
	while($ra = mysql_fetch_array($resultado_set)) 
	      {
	       if  ($ra["$atributo"] == $value) echo '<OPTION VALUE="'.$ra["$atributo"].'" selected>'.$ra["$atributo"];
			else echo '<OPTION VALUE="'.$ra["$atributo"].'">'.$ra["$atributo"];
	      }
	}

?>
</select></div>
<?    
  }
  if ($error != "") {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
  echo "<input type=\"hidden\" name=\"indexes[]\" value=\"".$formIndex."\" >\n";
  echo "<input type=\"hidden\" name=\"tags[".$formIndex."]\" value=\"".$tag."\" >\n";
  echo "<input type=\"hidden\" name=\"subfieldCds[".$formIndex."]\" value=\"".$subfieldCd."\" >\n";
  echo "<input type=\"hidden\" name=\"fieldIds[".$formIndex."]\" value=\"".$fieldId."\" >\n";
  echo "<input type=\"hidden\" name=\"requiredFlgs[".$formIndex."]\" value=\"".$required."\" >\n";
  echo "</td></tr>\n";
}


?>
