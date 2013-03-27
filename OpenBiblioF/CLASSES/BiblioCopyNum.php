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
class BiblioCopyNum {
  var $_id = "";
  var $_bibid = "";
  var $_copyid = "";
  var $_anio = "";
  var $_estado = "";
  var $_numeros = "";
  
  function BiblioCopyNum () {
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
     
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
/*    if ($this->_barcodeNmbr == "") {
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
	}*/
    return $valid;
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getId() {
    return $this->_id;
  }   
  function getBibid() {
    return $this->_bibid;
  }
  function getCopyid() {
    return $this->_copyid;
  }
  function getAnio() {
    return $this->_anio;
  }
  function getEstado() {
    return $this->_estado;
  }
  function getNumeros() {
    return $this->_numeros;
  }
  
  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setId($value) {
    $this->_id = trim($value);
  }   
  function setBibid($value) {
    $this->_bibid = trim($value);
  }
  function setCopyid($value) {
    $this->_copyid = trim($value);
  }
  function setAnio($value) {
    $this->_anio = trim($value);
  }
  function setEstado($value) {
    $this->_estado = /*strtolower*/(trim($value));
  }
  function setNumeros($value) {
    $this->_numeros = trim($value);
  }
}



?>
