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

  $tab = "opac";
  $nav = "home";
  $focus_form_name = "phrasesearch";
  $focus_form_field = "searchText";
  require_once("../shared/common.php");
  require_once("../classes/Localize.php");
  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/inputFuncs.php");
  
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../shared/header_opac.php");

  $lookup = "N";
  if (isset($_GET["lookup"])) {
    $lookup = "Y";
  }
?>

<script language="JavaScript">
function searchTypeListener()
{	
var option=document.phrasesearch.searchType[document.phrasesearch.searchType.selectedIndex].value;
var element=document.getElementById("inputType");
if(option=="material")
  {
   var contenido=document.phrasesearch.materiales.value;
   element.innerHTML=contenido;
  }
else
  {
   var contenido="<input type='text' name='searchText' size='30' maxlength='256'>";
   element.innerHTML=contenido;
  }
}
</script>

<h1><?php echo $loc->getText("opac_Header");?></h1>
<?php echo $loc->getText("opac_WelcomeMsg");?>

<form name="phrasesearch" method="POST" action="../shared/biblio_search.php">
<?php 
$reference="";
printSelectReference("searchText","material_type_dm",$postVars,$reference);
?>
<input type="hidden" name="materiales" value="<?=$reference?>">
<br>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left" colspan="3">
      <?php echo $loc->getText("opac_SearchTitle");?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <select name="searchType" onChange="searchTypeListener()">
        <option value="title" selected><?php echo $loc->getText("opac_Title");?>
        <option value="author"><?php echo $loc->getText("opac_Author");?>
		<option value="author_analitica"><?php echo $loc->getText("opac_AuthorAnalitica");?>
        <option value="subject"><?php echo $loc->getText("opac_Subject");?>
        <option value="signatura"><?php echo $loc->getText("opac_Signatura");?>
        <option value="material"><?php echo $loc->getText("opac_Material");?>
        <option value="isbn"><?php echo $loc->getText("opac_Isbn");?>
		<option value="autor_corporativo"><?php echo $loc->getText("opac_autor_corporativo");?>
      </select>
	  </td>
	  <td nowrap="true" class="primary" id="inputType">
      <input type="text" name="searchText" size="30" maxlength="256">
	  </td>
	  <td nowrap="true" class="primary">
      <input type="hidden" name="sortBy" value="default">
      <input type="hidden" name="tab" value="<?php echo $tab; ?>">
      <input type="hidden" name="lookup" value="<?php echo $lookup; ?>">
      <input type="submit" value="<?php echo $loc->getText("opac_Search");?>" class="button">
    </td>
  </tr>
</table>
<br>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php echo "Impresión"; ?>:
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
Tipo: <select name="tipo">
<option value="opac_html">HTML</option>
<option value="opac_csv">CSV</option>
</select>	
    </td>
  </tr>
</table>
</form>

<br>
<form name="barcodesearch" method="POST" action="../shared/biblio_search.php">
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("opac_BarcodeHdr");?>:
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("opac_BarcodeField");?>:
      <input type="text" name="searchText" size="20" maxlength="20">
      <input type="hidden" name="searchType" value="barcodeNmbr">
      <input type="hidden" name="sortBy" value="default">
	  <input type="hidden" name="tab" value="<?php echo $tab; ?>">
      <input type="hidden" name="lookup" value="<?php echo $lookup; ?>">
      <input type="submit" value="<?php echo $loc->getText("opac_Search");?>" class="button">
    </td>
  </tr>
</table>
</form>

<?php include("../shared/footer.php"); ?>
