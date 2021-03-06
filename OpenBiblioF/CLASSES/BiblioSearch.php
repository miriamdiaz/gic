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

/******************************************************************************
 * BiblioSearch represents a library bibliography search result.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
 
require_once("../funciones.php");

class BiblioSearch {
  var $_bibid = "";
  var $_copyid = "";
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
  var $_title = "";
  var $_titleRemainder = "";
  var $_responsibilityStmt = "";
  var $_author = "";
  var $_topic1 = "";
  var $_topic2 = "";
  var $_topic3 = "";
  var $_topic4 = "";
  var $_topic5 = "";
  var $_barcodeNmbr = "";
  var $_statusCd = "";
  var $_statusBeginDt = "";
  var $_dueBackDt = "";
  var $_daysLate = "";
  var $_image_path = "";
   //agregado Horacio Alvarez 01-04-06
  var $_userId = "";
  var $_dni = "";

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getDni() {
    return $this->_dni;
  }
  function setDni($value) {
    $this->_dni = $value;
  }     
  function getBibid() {
    return $this->_bibid;
  }
  function getCopyid() {
    return $this->_copyid;
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
  function getTitle() {
    return $this->_title;
  }
  function getTitleRemainder() {
    return $this->_titleRemainder;
  }
  function getResponsibilityStmt() {
    return $this->_responsibilityStmt;
  }
  function getAuthor() {
    return $this->_author;
  }
  function getTopic1() {
    return $this->_topic1;
  }
  function getTopic2() {
    return $this->_topic2;
  }
  function getTopic3() {
    return $this->_topic3;
  }
  function getTopic4() {
    return $this->_topic4;
  }
  function getTopic5() {
    return $this->_topic5;
  }
  function getBarcodeNmbr() {
    return $this->_barcodeNmbr;
  }
  function getStatusCd() {
    return $this->_statusCd;
  }
  function getStatusBeginDt() {
    return $this->_statusBeginDt;
  }
  function getDueBackDt() {
    return $this->_dueBackDt;
  }
  function getDaysLate() {
    return $this->_daysLate;
  }
  //HORACIO ALVAREZ: 27-05-06
  function getImage_path() {
    return $this->_image_path;
  }  
 function getUserId() {
    return $this->_userId;
  }  
  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  //HORACIO ALVAREZ: 27-05-06
  function setImage_path($value) {
    return $this->_image_path=$value;
  }     
  function setBibid($value) {
    $this->_bibid = trim($value);
  }
  function setCopyid($value) {
    $this->_copyid = trim($value);
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
  function setTitle($value) {
    $this->_title = trim($value);
  }
  function setTitleRemainder($value) {
    $this->_titleRemainder = trim($value);
  }
  function setResponsibilityStmt($value) {
    $this->_responsibilityStmt = trim($value);
  }
  function setAuthor($value) {
    $this->_author = trim($value);
  }
  function setTopic1($value) {
    $this->_topic1 = trim($value);
  }
  function setTopic2($value) {
    $this->_topic2 = trim($value);
  }
  function setTopic3($value) {
    $this->_topic3 = trim($value);
  }
  function setTopic4($value) {
    $this->_topic4 = trim($value);
  }
  function setTopic5($value) {
    $this->_topic5 = trim($value);
  }
  function setBarcodeNmbr($value) {
    $this->_barcodeNmbr = trim($value);
  }
  function setStatusCd($value) {
    $this->_statusCd = trim($value);
  }
  function setStatusBeginDt($value) {
    $this->_statusBeginDt = trim($value);
  }
  function setDueBackDt($value) {
    $this->_dueBackDt = trim($value);
  }
  /*
  @autor: Horacio Alvarez
  @fecha: 2006-09-26
  @descripcion: Resta a la cantidad de dias devuelta
  por la base de datos, los dias de fin de semana.
  */
  function setDaysLate($value) {

  $dueBackDt = $this->getDueBackDt();
  if(empty($dueBackDt))
    $dueBackDt = date("Y-m-d");
  $timestamp_current = strtotime($dueBackDt);
	$realValue = 0;
	for($i=1;$i<=$value;$i++)
	    {
		 $timestamp_parcial = $timestamp_current + (60*60*24*$i); 
		 $parcial = date('Y-m-d', $timestamp_parcial);
		 if(!isFinde($parcial))
		    $realValue++;  
		}
    $this->_daysLate = trim($realValue);
  }
 function setUserId($value) {
    $this->_userId = trim($value);
  }
}  
?>
