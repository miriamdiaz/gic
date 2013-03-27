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

  $tab = "cataloging";
  $nav = "edit";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/Biblio.php");
  require_once("../classes/BiblioField.php");
  require_once("../classes/BiblioQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to search if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }
  $bibid = $_POST["bibid"];

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $biblio = new Biblio();
  $biblio->setBibid($bibid);
  $biblio->setMaterialCd($_POST["materialCd"]);
  $_POST["materialCd"]= $biblio->getMaterialCd();
  $biblio->setCollectionCd($_POST["collectionCd"]);
  $_POST["collectionCd"] = $biblio->getCollectionCd();
  $biblio->setCallNmbr1($_POST["callNmbr1"]);
  $_POST["callNmbr1"] = $biblio->getCallNmbr1();
  $biblio->setCallNmbr2($_POST["callNmbr2"]);
  $_POST["callNmbr2"] = $biblio->getCallNmbr2();
  $biblio->setCallNmbr3($_POST["callNmbr3"]);
  $_POST["callNmbr3"] = $biblio->getCallNmbr3();
  $biblio->setLastChangeUserid($_SESSION["userid"]);
  $biblio->setOpacFlg(isset($_POST["opacFlg"]));
  $biblio->setLiteraturaFlg(isset($_POST["literaturaFlg"]));
  $_POST["literaturaFlg"] = $biblio->getLiteraturaFlg();
  $biblio->setImage_path($_POST["image_path"]);
  
  /*ini franco 05/07/05*/
  $dia=$HTTP_POST_VARS["list_day"];
  $mes=$HTTP_POST_VARS["list_month"];
  $anio=$HTTP_POST_VARS["list_year"];
  $biblio->setUserNameCreador($_POST["user_name_creador"]);
  $biblio->setFechaCatalog($anio."-".$mes."-".$dia);
  $_POST["fecha"]=$biblio->getFechaCatalog();
  $biblio->setIndice($_POST["indice"]);
  $_POST["indice"] = $biblio->getIndice(); 
  /*fin franco 05/07/05*/
  $indexes = $_POST["indexes"];

  foreach($indexes as $index) {
    $value = $_POST["values"][$index];
    $fieldid = $_POST["fieldIds"][$index];
    $tag = $_POST["tags"][$index];
    $subfieldCd = $_POST["subfieldCds"][$index];
    $requiredFlg = $_POST["requiredFlgs"][$index];
    $biblioFld = new BiblioField();
    $biblioFld->setBibid($bibid);
    $biblioFld->setFieldid($fieldid);
    $biblioFld->setTag($tag);
    $biblioFld->setSubfieldCd($subfieldCd);
    $biblioFld->setIsRequired($requiredFlg);
    $biblioFld->setFieldData($value);
    $_POST[$index] = $biblioFld->getFieldData();
    $biblio->addBiblioField($index,$biblioFld);
  }
  $_POST["indexes"]= $biblio->getBiblioFields();
  $validData = $biblio->validateData();
  if (!$validData) {
    $pageErrors["callNmbr1"] = $biblio->getCallNmbrError();
    $biblioFlds = $biblio->getBiblioFields();
    foreach($indexes as $index) {
      if ($biblioFlds[$index]->getFieldDataError() != "") {
        $pageErrors[$index] = $biblioFlds[$index]->getFieldDataError();
      }
    }
    /*ini franco 05/07/05*/

	$pageErrors["fecha"] = $biblio->getDateSptuError();
	    /*fin franco*/
 
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    //header("Location: ../catalog/biblio_edit_form.php");
    //exit();
  }

  #**************************************************************************
  #*  Update bibliography
  #**************************************************************************
  $biblioQ = new BiblioQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->update($biblio)) 
  {
  	 
     $biblioQ->close();
	 if ($biblioQ->getDbErrno() == "") 
	 {
      $pageErrors["callNmbr1"] = $biblioQ->getError();
      $_SESSION["postVars"] = $_POST;
      $_SESSION["pageErrors"] = $pageErrors;
	   foreach($indexes as $index) {
  $field=$_POST["fieldIds"][$index];
  //echo"<br> fieldid= ".$field;
  }
	  header("Location: ../catalog/biblio_edit_form.php");
	  exit();
      }
	  else 
	  {
       displayErrorPage($biblioQ);
      }

  }
  $biblioQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  $msg = $loc->getText("biblioEditSuccess");
  $msg = urlencode($msg);
  header("Location: ../shared/biblio_view.php?bibid=".$bibid."&msg=".$msg);
  exit();
?>