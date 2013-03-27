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
  $nav = "searchform";
  $focus_form_name = "barcodesearch";
  $focus_form_field = "searchText";

  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/header.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/inputFuncs.php");  
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

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


<h1><img src="../images/catalog.png" border="0" width="30" height="30" align="top"> <?php echo $loc->getText("indexHdr");?></h1>

<form name="barcodesearch" method="POST" action="../shared/biblio_search.php">
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("indexBarcodeHdr");?>:
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("indexBarcodeField");?>:
      <input type="text" name="searchText" size="20" maxlength="20">
      <input type="hidden" name="searchType" value="barcodeNmbr">
      <input type="hidden" name="sortBy" value="default">
      <input type="submit" value="<?php echo $loc->getText("indexButton");?>" class="button">
    </td>
  </tr>
</table>
</form>


<form name="phrasesearch" method="POST" action="../shared/biblio_search.php">
<?php 
$reference="";
printSelectReference("searchText","material_type_dm",$postVars,$reference);
?>
<input type="hidden" name="materiales" value="<?=$reference?>">

<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left" colspan="3">
      <?php echo $loc->getText("indexSearchHdr");?>:
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <select name="searchType" onChange="searchTypeListener()">
        <option value="title" selected><?php echo $loc->getText("indexTitle");?>
		<option value="title_analitica"><?php echo $loc->getText("indexTitleAnalitica");?>
        <option value="author"><?php echo $loc->getText("indexAuthor");?>
		<option value="autor_corporativo"><?php echo $loc->getText("opac_autor_corporativo");?>
        <option value="subject"><?php echo $loc->getText("indexSubject");?>
		<!-- ini franco 17/08/05 -->
        <option value="signatura"><?php echo $loc->getText("indexSignatura");?>
        <option value="material"><?php echo $loc->getText("indexMaterial");?>
        <option value="isbn"><?php echo $loc->getText("indexIsbn");?>
		<option value="bibid"><?php echo $loc->getText("indexBibid");?><!--bibid 20/10/06 -->
		<option value="coleccion"><?php echo $loc->getText("indexColeccion");?>
		<option value="nombre_editor"><?php echo $loc->getText("indexNombreEditor");?>
		<option value="nota"><?php echo $loc->getText("indexNota");?>
		<!-- fin franco 17/08/05 -->
      </select>
	  </td>
	  <td nowrap="true" class="primary" id="inputType">
      <input type="text" name="searchText" size="30" maxlength="256" >
	  </td>
	  <td nowrap="true" class="primary">	  
      
      <input type="hidden" name="sortBy" value="default">
      <input type="submit" value="<?php echo $loc->getText("indexButton");?>" class="button">
    </td>
  </tr>
</table>
</form>
<!-- Eduardo ROJEL 16/12/05 -->
<form name="phraseorcurr" method="POST" action="../shared/biblio_ocurrencias.php">
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("indexOcurrHdr");?>:
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <select name="searchType">
        <option value="title" selected><?php echo $loc->getText("indexTitle");?>
        <option value="author"><?php echo $loc->getText("indexAuthor");?>
        <option value="subject"><?php echo $loc->getText("indexSubject");?>
        <option value="signatura"><?php echo $loc->getText("indexSignatura");?>
        <option value="material"><?php echo $loc->getText("indexMaterial");?>
        <option value="isbn"><?php echo $loc->getText("indexIsbn");?>
      </select>
      <input type="text" name="searchText" size="30" maxlength="256">
      <input type="hidden" name="sortBy" value="default">
      <input type="submit" value="Calcular" class="button">
    </td>
  </tr>
</table>
</form>

<?php include("../shared/footer.php"); ?>
