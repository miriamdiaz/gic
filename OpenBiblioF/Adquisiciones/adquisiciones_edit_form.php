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
  $nav = "summary";
  $focus_form_name = "editareaform";
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
  
  
  if (isset($_GET["reset"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);
	}
  else
     {
	 $pageErrors = $_SESSION["pageErrors"];
	  $postVars = $_SESSION["pageErrors"];
	 }  

  if(isset($_GET["code"]))
  {
    $adqid = $_GET["code"];
    $postVars["adqid"] = $adqid;
    include_once("../classes/Adquisicion.php");
    include_once("../classes/AdquisicionQuery.php");
    include_once("../functions/errorFuncs.php");
    $adqQ = new AdquisicionQuery();
    $adqQ->connect();
    if ($adqQ->errorOccurred()) {
      $adqQ->close();
      displayErrorPage($adqQ);
    }
    $adqQ->execSelectAdqid($adqid);
    if ($adqQ->errorOccurred()) {
      $adqQ->close();
      displayErrorPage($adqQ);
    }
    $adq = $adqQ->fetchAdquisicion();
	$postVars["adqid"] = $adq->getAdqid();
    $postVars["concepto_cd"] = $adq->getConceptoCd();
	$postVars["title"] = $adq->getTitle();
	$postVars["author"] = $adq->getAuthor();
	$postVars["isbn"] = $adq->getIsbn();
	$postVars["edicion_dt"] = $adq->getEdicionDt();
	$postVars["editorial"] = $adq->getEditorial();
	$postVars["ejemplares"] = $adq->getEjemplares();
	$postVars["libraryid"] = $adq->getLibraryId();
	$postVars["area_cd"] = $adq->getAreaCd();
	$postVars["mbrid"] = $adq->getMbrid();
	$postVars["estado_cd"] = $adq->getEstadoCd();
	$postVars["observacion"] = $adq->getObservacion();
	$postVars["created_dt"] = $adq->getCreatedDt();
    $adqQ->close();
  } else {
    require("../shared/get_form_vars.php");
  }
?>

<form name="editcollectionform" method="POST" action="../adquisiciones/adquisiciones_edit.php">
<input type="hidden" name="adqid" value="<?php echo $postVars["adqid"];?>">
<input type="hidden" name="mbrid" value="<?php echo $postVars["mbrid"];?>">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <? echo "Editar Pedido de Adquisición: "; ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Nro. Adquisición"; ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $postVars["adqid"]; ?>
    </td>
  </tr>    
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Concepto"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printConceptosActivos("concepto_cd","concepto_dm",$postVars,$pageErrors); ?>
    </td>
  </tr>  
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Título"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("title",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Autor"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("author",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>  
  <tr>
    <td nowrap="true" class="primary">
      <? echo "I.S.B.N"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("isbn",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>  
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Edición"; ?>
    </td>
    <td valign="top" class="primary">
     <?php printInputText("edicion_dt",50,50,$postVars,$pageErrors); ?>
    </td>
  </tr>  
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Editorial"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("editorial",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>  
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Ejemplares"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("ejemplares",2,2,$postVars,$pageErrors); ?>
    </td>
  </tr>  
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Biblioteca"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printSelectWithPosErrors("libraryid","biblio_cod_library",$postVars,$pageErrors); ?>
    </td>
  </tr>  
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Área"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printSelectWithPosErrors("area_cd","area_dm",$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Estado"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printSelectWithPosErrors("estado_cd","estado_dm",$postVars,$pageErrors); ?>
    </td>
  </tr>      
  <tr>
    <td nowrap="true" class="primary">
      <? echo "Observación"; ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("observacion",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>        

  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <? echo "Aceptar"; ?>  " class="button">
      <input type="button" onClick="parent.location='../adquisiciones/index.php?code=<? echo $postVars["adqid"];?>&buscar=1'" value="  <? echo "Cancelar"; ?>  " class="button">
    </td>
  </tr>

</table>
      </form>
<table><tr><td valign="top"><font class="small"><? echo ""; ?></font></td>
<td><font class="small"><? echo ""; ?><br></font>
</td></tr></table>

<?php include("../shared/footer.php"); ?>
