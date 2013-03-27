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

  require_once("../classes/Localize.php");

/******************************************************************************
 * Biblio represents a library bibliography record.  Contains business rules for
 * bibliography data validation.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Biblio {
  var $_bibid = "";
  var $_createDt = "";
  var $_lastChangeDt = "";
  var $_lastChangeUserid = "";
  var $_lastChangeUsername = "";
  var $_materialCd = "";
  var $_collectionCd = "";
  var $_callNmbr1 = "";
  var $_callNmbr2 = "";
  var $_callNmbr3 = "";
  var $_callNmbrError = "";
  var $_biblioFields = array();
  var $_opacFlg = true;
  var $_loc;
  var $_userNameCreador= "";
  var $_fechaCatalog="";
  var $_indice="";
  var $_dateSptuError="";
  // ini franco 29/07/05 agregado solo para la aprobacion de material
  var $_title="";
  //fin franco 
  //12/09/05 agregado para poder repetir
  //signatura en los materiales de literaruta.
  var $_literaturaFlg = false;
  // JUDITH AGREGADO PARA LISTAR APROB 29/11/05
  var $_fecha = "";
  var $_userId = "";
  //Horacio Alvarez: Agregado 27-05-06
  var $_image_path= "../images/logotipo.jpeg";
  
  function Biblio () {
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
    if ($this->_callNmbr1 == "") {
      $valid = false;
      $this->_callNmbrError = $this->_loc->getText("biblioError1");
    }
    foreach ($this->_biblioFields as $key => $value) {
      if (!$this->_biblioFields[$key]->validateData()) {
        $valid = false;
      }
    }
    list( $year, $month, $day ) = split( '[/.-]', $this->_fechaCatalog );
	if(!checkdate($month,$day,$year))
	{
		$valid=false;
		$this->_dateSptuError= $this->_loc->getText("biblioDateError");
	}
    return $valid;
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getBibid() {
    return $this->_bibid;
  }
  function getCreateDt() {
    return $this->_createDt;
  }
  function getLastChangeDt() {
    return $this->_lastChangeDt;
  }
  function getLastChangeUserid() {
    return $this->_lastChangeUserid;
  }
  function getLastChangeUsername() {
    return $this->_lastChangeUsername;
  }
  function getMaterialCd() {
    return $this->_materialCd;
  }
  function getCollectionCd() {
    return $this->_collectionCd;
  }
  function getCallNmbr1() {
    return $this->_callNmbr1;
  }
  function getCallNmbr2() {
    return $this->_callNmbr2;
  }
  function getCallNmbr3() {
    return $this->_callNmbr3;
  }
  function getCallNmbrError() {
    return $this->_callNmbrError;
  }
  function getBiblioFields() {
    return $this->_biblioFields;
  }
  function showInOpac() {
    return $this->_opacFlg;
  }
    // ini franco 29/07/05 solo para aprobacion
  function getTitle() 
  {
    return $this->_title;
  }
  
  function getLiteraturaFlg()
  {
  	return $this->_literaturaFlg;
  }
  function setTitle($value)
  { $this->_title= trim($value);}  

//fin franco 29/07/05
 /* ini franco*/
  function getUserNameCreador()
  {	return $this->_userNameCreador;}
  function getFechaCatalog()
  {	return $this->_fechaCatalog;}
  function getIndice()
  {	return $this->_indice;}
  function getDateSptuError() 
  {
     return $this->_dateSptuError;
  }
  // JUDITH AGREGADO PARA LISTAR APROB 29/11/05
  function getFecha()
  {	return $this->_fecha;}
  function getUserId()
  {	return $this->_userId;}
  
  //HORACIO ALVAREZ: 27-05-06
  function getImage_path(){	
   return $this->_image_path;
  }
 
  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setIndice($value)
  { $this->_indice= trim($value);}  
  
  //HORACIO ALVAREZ: 27-05-06
  function setImage_path($value){
   $this->_image_path=$value;
  }
  function setFechaCatalog($value)
  { $this->_fechaCatalog= trim($value);}  
 
  function setUserNameCreador($value)
  { $this->_userNameCreador= trim($value);}
 /*fin franco*/
  function setBibid($value) {
    $this->_bibid = trim($value);
  }
  function setCreateDt($value) {
    $this->_createDt = trim($value);
  }
  function setLastChangeDt($value) {
    $this->_lastChangeDt = trim($value);
  }
  function setLastChangeUserid($value) {
    $this->_lastChangeUserid = trim($value);
  }
  function setLastChangeUsername($value) {
    $this->_lastChangeUsername = trim($value);
  }
  function setMaterialCd($value) {
    $this->_materialCd = trim($value);
  }
  function setCollectionCd($value) {
    $this->_collectionCd = trim($value);
  }
  function setCallNmbr1($value) {
    $this->_callNmbr1 = trim($value);
  }
  function setCallNmbr2($value) {
    $this->_callNmbr2 = trim($value);
  }
  function setCallNmbr3($value) {
    $this->_callNmbr3 = trim($value);
  }
  function setCallNmbrError($value) {
    $this->_callNmbrError = trim($value);
  }
  function setOpacFlg($flag) {
    if ($flag == true) {
      $this->_opacFlg = true;
    } else {
      $this->_opacFlg = false;
    }
  }
  // JUDITH AGREGADO PARA LISTAR APROB 29/11/05
  function setFecha($value) {
    $this->_fecha = trim($value);
  }
  function setUserId($value) {
    $this->_userId = trim($value);
  }
  
  function addBiblioField($index, $value) {
    $keySuffix = "";
    while (array_key_exists($index.$keySuffix, $this->_biblioFields)) {
      if ($keySuffix == "") {
        $keySuffix = 1;
      } else {
        $keySuffix = $keySuffix + 1;
      }
    }    
    $this->_biblioFields[$index.$keySuffix] = $value;
  }
   function setLiteraturaFlg($flag) {
    if ($flag == true) {
      $this->_literaturaFlg = "CHECKED";
    } else {
      $this->_literaturaFlg = "";
    }
  }

}

?>
