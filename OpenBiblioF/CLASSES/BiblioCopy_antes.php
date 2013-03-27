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
  require_once("../functions/formatFuncs.php");

/******************************************************************************
 * BiblioCopy represents a library bibliography copy record.  Contains business rules for
 * bibliography data validation.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioCopy {
  var $_bibid = "";
  var $_copyid = "";
  var $_copyDesc = "";
  var $_barcodeNmbr = "";
  var $_barcodeNmbrError = "";
  var $_statusCd = OBIB_DEFAULT_STATUS;
  var $_statusBeginDt = "";
  var $_dueBackDt = "";
  var $_daysLate = "";
  var $_mbrid = "";
  var $_loc;
  /*ini 06/07/05 franco*/
  var $_volumen="";
  var $_tomo="";
  var $_userCreador="";
  var $_proveedor="";
  var $_precio="";
  var $_codLoc="";
  var $_dateSptu="";
  var $_dateSptuError="";
  var $_precioError="";
  /* fin franco */
//1/08/05 este atributo es solo para ser usado en la paginacion
// de aprobar ejemplar y solo para eso!!!!!!!!!
  var $_title="";
  function BiblioCopy () {
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
     
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
    if ($this->_barcodeNmbr == "") {
      $valid = false;
      $this->_barcodeNmbrError = $this->_loc->getText("biblioCopyError1");
    } else if (!ctypeAlnum($this->_barcodeNmbr)) {
      $valid = false;
      $this->_barcodeNmbrError = $this->_loc->getText("biblioCopyError2");
    }
	if(!is_numeric( $this->_precio) && $this->_precio != "")
    {
		$valid=false;
		$this->_precioError= $this->_loc->getText("biblioCopyError3");
    }
    
    list( $year, $month, $day ) = split( '[/.-]', $this->_dateSptu );
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
  function getCopyid() {
    return $this->_copyid;
  }
  function getCopyDesc() {
    return $this->_copyDesc;
  }
  function getBarcodeNmbr() {
    return $this->_barcodeNmbr;
  }
  function getBarcodeNmbrError() {
    return $this->_barcodeNmbrError;
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
  function getMbrid() {
    return $this->_mbrid;
  }
  /* ini frnaoc06/07/05 */
  function getVolumen()
  {
  return $this->_volumen;
  }
  function getTomo()
  {
  return $this->_tomo;
  }
  function getUserCreador()
  {
  return $this->_userCreador;
  }
  function getProveedor()
  {
  return $this->_proveedor;
  }
  function getPrecio()
  {
  return $this->_precio;
  }
  function getCodLoc()
  {
  return $this->_codLoc;
  }
  function getDateSptu()
  {
  return $this->_dateSptu;
  }
  function getPrecioError() 
  {
     return $this->_precioError;
  }
  function getDateSptuError() 
  {
     return $this->_dateSptuError;
  }
//funcion utilizada solo para paginacion
  function getTitle() 
  {
     return $this->_title;
  }

  /* fin franco*/
  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setTitle($value)
  {  
	$this->_title=trim($value);
  }
  function setVolumen($value)
  {  
	$this->_volumen=trim($value);
  }
  function setTomo($value)
  {  
	$this->_tomo=trim($value);
  }
  function setUserCreador($value)
  {  
	$this->_userCreador=trim($value);
  }
  function setProveedor($value)
  {  
	$this->_proveedor=trim($value);
  }
  function setPrecio($value)
  {  
	$this->_precio=trim($value);
  }
  function setCodLoc($value)
  {  
	$this->_codLoc=trim($value);
  }
  function setDateSptu($value)
  {  
	$this->_dateSptu=trim($value);
  }

  function setBibid($value) {
    $this->_bibid = trim($value);
  }
  function setCopyid($value) {
    $this->_copyid = trim($value);
  }
  function setCopyDesc($value) {
    $this->_copyDesc = trim($value);
  }
  function setBarcodeNmbr($value) {
    $this->_barcodeNmbr = strtolower(trim($value));
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
  function setDaysLate($value) {
    $this->_daysLate = trim($value);
  }
  function setMbrid($value) {
    $this->_mbrid = trim($value);
  }
}

?>
